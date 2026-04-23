<?php

namespace App\Core;

use PDO;
use PDOException;

class Database
{
    private static ?PDO  $connection = null;

    public static function init(array $config): void
    {
        if (self::$connection !== null) return;

        try {
            $dsn = "mysql:host={$config['host']};port={$config['port']};dbname={$config['database']};charset=utf8mb4";
            self::$connection = new PDO($dsn, $config['username'], $config['password'], [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]);
        } catch (PDOException $e) {
            die('Error de conexión: ' . $e->getMessage());
        }
    }

    public static function getConnection(): PDO
    {
        if (self::$connection === null) {
            throw new \RuntimeException('Base de datos no iniciada');
        }
        return self::$connection;
    }
}