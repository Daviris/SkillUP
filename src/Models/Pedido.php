<?php

namespace App\Models;

use App\Core\Model;
use App\Core\Database;

class Pedido extends Model
{
    protected static string $table = 'pedidos';

    // Verifica si un usuario ha comprado un curso específico.
    public static function usuarioTieneCurso(int $usuarioId, int $cursoId): bool
    {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM detalle_pedido dp JOIN pedidos p ON dp.pedido_id = p.id WHERE p.usuario_id = :uid AND dp.curso_id = :cid AND p.estado = 'completado'");
        $stmt->execute(['uid' => $usuarioId, 'cid' => $cursoId]);
        return (bool) $stmt->fetchColumn();
    }

    // Devuelve todos los cursos comprados.
    public static function cursosCompradosPorUsuario(int $usuarioId): array
    {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("SELECT c.*, u.nombre AS instructor_nombre FROM detalle_pedido dp JOIN pedidos p ON dp.pedido_id = p.id JOIN cursos c ON dp.curso_id = c.id JOIN usuarios u ON c.id_instructor = u.id WHERE p.usuario_id = :uid AND p.estado = 'completado' ORDER BY p.fecha DESC");
        $stmt->execute(['uid' => $usuarioId]);
        return $stmt->fetchAll();
    }
}