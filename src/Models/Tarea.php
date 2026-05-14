<?php

namespace App\Models;

use App\Core\Database;
use App\Core\Model;

class Tarea extends Model
{
    protected static string $table = 'entregas_tareas';

    public static function entregaAlumno(int $claseId, int $alumnoId): ?array
    {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("SELECT * FROM entregas_tareas WHERE clase_id = :clase AND alumno_id = :alumno ORDER BY fecha_entrega DESC LIMIT 1");
        $stmt->execute(['clase' => $claseId, 'alumno' => $alumnoId]);
        $result = $stmt->fetch();
        return $result ?: null;
    }

    public static function todasEntregas(int $claseId): array
    {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("SELECT et.*, u.nombre AS alumno_nombre, a.nombre_original AS archivo_nombre FROM entregas_tareas et JOIN usuarios u ON et.alumno_id = u.id LEFT JOIN archivos a ON et.archivo_id = a.id WHERE et.clase_id = :clase ORDER BY et.fecha_entrega DESC");
        $stmt->execute(['clase' => $claseId]);
        return $stmt->fetchAll();
    }
}