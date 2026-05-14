<?php

namespace App\Models;

use App\Core\Database;
use App\Core\Model;

class Curso extends Model
{
    protected static string $table = 'cursos';
    protected static string $primaryKey = 'id';

    // Paginación con filtros
    public static function listar(?string $modalidad = null, ?float $precioMax = null, int $porPagina = 12, int $pagina = 1) : array
    {
        $pdo = Database::getConnection();
        $sql = "SELECT c.*, u.nombre AS instructor_nombre FROM cursos c JOIN usuarios u ON c.id_instructor = u.id WHERE 1=1";
        $params = [];

        if ($modalidad) {
            $sql .= " AND c.modalidad = :modalidad";
            $params['modalidad'] = $modalidad;
        }
        if ($precioMax !== null) {
            $sql .= " AND c.precio <= :precioMax";
            $params['precioMax'] = $precioMax;
        }

        // Contar el total
        $countStmt = $pdo->prepare("SELECT COUNT(*) FROM ($sql) as total");
        $countStmt->execute($params);
        $total = (int) $countStmt->fetchColumn();

        // Paginación
        $offset = ($pagina -1) * $porPagina;
        $sql .= " LIMIT :limit OFFSET :offset";
        $params['limit'] = $porPagina;
        $params['offset'] = $offset;

        $stmt = $pdo->prepare($sql);

        // Asignar tipos
        foreach ($params as $key => $valor) {
            $paramType = is_int($valor) ? \PDO::PARAM_INT : \PDO::PARAM_STR;
            $stmt->bindValue(":$key", $valor, $paramType);
        }
        $stmt->execute();
        $cursos = $stmt->fetchAll();

        return [
            'cursos' => $cursos,
            'total' => $total,
            'paginaActual' => $pagina,
            'porPag' => $porPagina,
            'ultimaPag' => ceil($total / $porPagina),
        ];
    }

    // Obtener curso y sus clases por ID
    public static function buscarConClases(int $id): ?array
    {
        // Curso
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("SELECT c.*, u.nombre AS instructor_nombre FROM cursos c JOIN usuarios u ON c.id_instructor = u.id WHERE c.id = :id");
        $stmt->execute(['id' => $id]);
        $curso = $stmt->fetch();
        if (!$curso) return null;

        // Clases
        $stmt = $pdo->prepare("SELECT * FROM clases WHERE curso_id = :id ORDER BY orden ASC");
        $stmt->execute(['id' => $id]);
        $clases = $stmt->fetchAll();

        $curso['clases'] = $clases;
        return $curso;
    }

    // Obtener todos los instructores
    public static function todosInstructores(): array
    {
        $pdo = Database::getConnection();
        $stmt = $pdo->query("SELECT c.*, u.nombre AS instructor_nombre FROM cursos c JOIN usuarios u ON c.id_instructor = u.id ORDER BY c.created_at DESC");
        return $stmt->fetchAll();
    }
}