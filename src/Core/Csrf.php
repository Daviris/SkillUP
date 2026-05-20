<?php

namespace App\Core;

class Csrf
{
    // Generar el token CSRF y guardar en sesión.
    public static function generate(): string
    {
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }

    // Devolver campo HTML oculto con el token.
    public static function tokenField(): string
    {
        return '<input type="hidden" name="_token" value"' . self::generate() . '">';
    }

    // Verificar token enviado con el de la sesión.
    public static function verify(?string $toke = null): void
    {
        $token = $token ?? $_POST['_token'] ?? $_GET['_token'] ?? '';
        if (!isset($_SESSION['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $token)) {
            http_response_code(403);
            echo 'Petición no autorizada.';
            exit;
        }
    }
}