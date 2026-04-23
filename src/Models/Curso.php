<?php

namespace App\Models;

use App\Core\Database;
use App\Core\Model;

class Curso extends Model
{
    protected static string $table = 'cursos';
    protected static string $primaryKey = 'id';

    // Paginación con filtros
    public static function listar(?string $modalidad = null, ?float $precioMax = null, int $porPag = 12, int $pag = 1) : array
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
        $offset = ($pag -1) * $porPag;
        $sql .= " LIMIT :limit OFFSET :offset";
        $params['limit'] = $porPag;
        $params['offset'] = $offset;

        $stmt = $pdo->prepare($sql);

        // Asignar tipos
        foreach ($params as $key = $valor) {
            $paramType = is_int($value) ? \PDO::PARAM_INT : \PDO::PARAM_STR;
            $stmt->bindValue(":$key", $value, $paramType);
        }
        $stmt->execute();
        $cursos = $stmt->fetchAll();

        return [
            'cursos' => $cursos,
            'total' => $total,
            'paginaActual' => $pag,
            'porPag' => $porPag,
            'ultimaPag' => ceil($total / $porPag),
        ];
    }

    // Obtener curso y sus clases por ID
    public static function buscarConClases(int $id): ?array
    {
        // Curso
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("SELECT c.*, u.nombre AS instructor_nombre FROM cursos c JOIN usuarios u ONc.id_instructor = u.id WHERE c.id = :id");
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
}