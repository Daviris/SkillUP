<?php

namespace App\Models;

use App\Core\Model;
use App\Core\Database;

class Clase extends Model
{
    protected static string $table = 'clases';

    public static function porCurso(int $cursoId): array
    {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("SELECT * FROM clases WHERE curso_id = :curso_id ORDER BY orden ASC");
        $stmt->execute(['curso_id' => $cursoId]);
        return $stmt->fetchAll();
    }
}