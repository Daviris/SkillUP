<?php
namespace App\Models;

use App\Core\Database;
use App\Core\Model;

class Resena extends Model
{
    protected static string $table = 'resenas';

    // Obtiene todas las reseñas de un curso con el nombre del alumno.
    public static function delCurso(int $cursoId): array
    {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("SELECT r.*, u.nombre AS alumno_nombre
                               FROM resenas r
                               JOIN usuarios u ON r.usuario_id = u.id
                               WHERE r.curso_id = :curso
                               ORDER BY r.fecha DESC");
        $stmt->execute(['curso' => $cursoId]);
        return $stmt->fetchAll();
    }

    // Busca una reseña por usuario y curso.
    public static function buscarPorUsuarioYCurso(int $usuarioId, int $cursoId): ?array
    {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("SELECT * FROM resenas WHERE usuario_id = :uid AND curso_id = :cid");
        $stmt->execute(['uid' => $usuarioId, 'cid' => $cursoId]);
        $result = $stmt->fetch();
        return $result ?: null;
    }

    // Calcula reputación
    public static function actualizarReputacionInstructor(int $instructorId): void
    {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("SELECT AVG(r.puntuacion)
                               FROM resenas r
                               JOIN cursos c ON r.curso_id = c.id
                               WHERE c.id_instructor = :instructor");
        $stmt->execute(['instructor' => $instructorId]);
        $promedio = $stmt->fetchColumn();

        $pdo->prepare("UPDATE usuarios SET reputacion = :rep WHERE id = :id")
            ->execute(['rep' => round($promedio ?? 0, 2), 'id' => $instructorId]);
    }

    public static function delUsuario(int $usuarioId): array
    {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("SELECT r.*, c.titulo AS curso_titulo FROM resenas r JOIN cursos c ON r.curso_id = c.id WHERE r.usuario_id = :uid ORDER BY r.fecha DESC");
        $stmt->execute(['uid' => $usuarioId]);
        return $stmt->fetchAll();
    }
}