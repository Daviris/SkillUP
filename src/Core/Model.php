<?php

namespace App\Core;

use PDO;

abstract class Model
{
    protected static string $table;
    protected static string $primaryKey = 'id';

    public static function all(): array
    {
        $pdo = Database::getConnection();
        $stmt = $pdo->query('SELECT * FROM ' . static::$table);
        return $stmt->fetchAll();
    }

    public static function find(int $id): ?array
    {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare('SELECT * FROM ' . static::$table . ' WHERE ' . static::$primaryKey . ' = :id');
        $stmt->execute(['id' => $id]);
        $result = $stmt->fetch();
        return $result ?: null;
    }

    public static function where(string $column, string $value): ?array
    {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare('SELECT * FROM ' . static::$table . " WHERE $column = :value");
        $stmt->execute(['value' => $value]);
        $result = $stmt->fetch();
        return $result ?: null;
    }

    public static function whereAll(string $column, string $value): array
    {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare('SELECT * FROM ' . static::$table . " WHERE $column = :value ORDER BY created_at DESC");
        $stmt->execute(['value' => $value]);
        $result = $stmt->fetchAll();
        return $result;
    }

    public static function create(array $data): int
    {
        $pdo = Database::getConnection();
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');
        $columns = implode(', ', array_keys($data));
        $placeholders = ':' . implode(', :', array_keys($data));
        $stmt = $pdo->prepare("INSERT INTO " . static::$table . " ($columns) VALUES ($placeholders)");
        $stmt->execute($data);
        return (int) $pdo->lastInsertId();
    }

    public static function update(int $id, array $data): void
    {
        $pdo = Database::getConnection();
        $data['updated_at'] = date('Y-m-d H:i:s');
        $sets = [];
        foreach ($data as $columna => $valor) {
            $sets[] = "$columna = :$columna";
        }
        $data['id'] = $id;
        $stmt = $pdo->prepare("UPDATE " . static::$table . " SET " . implode(', ', $sets) . " WHERE " . static::$primaryKey . " = :id");
        $stmt->execute($data);
    }

    public static function delete(int $id): void
    {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("DELETE FROM " . static::$table . " WHERE " . static::$primaryKey . " = :id");
        $stmt->execute(['id' => $id]);
    }
}