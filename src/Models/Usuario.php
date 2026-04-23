<?php

namespace App\Models;

use App\Core\Model;

class Usuario extends Model
{
    protected static string $table = 'usuarios';
    protected static string $primaryKey = 'id';

    public static function autenticar(string $email, string $password): ?array
    {
        $usuario = self::where('email', $email);
        if ($usuario && password_verify($password, $usuario['password'])) {
            return $usuario;
        }
        return null;
    }
}