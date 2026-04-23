<?php

namespace App\Controllers;

use App\Core\Request;
use App\Core\View;
use App\Models\Usuario;

class AuthController
{
    public function formularioLogin(Request $request): void
    {
        View::render('auth/login', ['title' => 'Iniciar Sesión']);
    }

    public function login(Request $request): void
    {
        $email = trim($request->input('email', ''));
        $password = $request->input('password', '');

        $errros = [];
        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'El correo no es válido.';
        }
        if (empty($password)) {
            $errors[] = 'La contraseña es obligatoria.';
        }

        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            header('Location: /login');
            exit;
        }

        $usuario = Usuario::autenticar($email, $password);
        if ($usuario) {
            $_SESSION['usuario'] = [
                'id' => $usuario['id'],
                'nombre' => $usuario['nombre'],
                'email' => $usuario['email'],
                'rol' => $usuario['rol'],
            ];
            $_SESSION['mensaje'] = 'Bienvenid@';
            header('Location: /');
        } else {
            $_SESSION['errors'] = ['Credenciales incorrectas.'];
            header('Location: /login');
        }
        exit;
    }

    public function formularioRegister(Request $request): void
    {
        View::render('auth/register', ['title' => 'Crear Cuenta']);
    }

    public function register(Request $request): void
    {
        $nombre = trim($request->input('nombre', ''));
        $email = trim($request->input('email', ''));
        $password = $request->input('password', '');
        $passwordConfirmacion = $request->input('password_confirmacion', '');
        $rol = $request->input('rol', 'alumno');

        $errors = [];
        if (empty($nombre)) {
            $errors[] = 'El nombre es obligatorio.';
        }
        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "El correo no es válido.";
        }
        if (strlen($password) < 8) {
            $errors[] = 'La contraseña debe tener al menos 8 caracteres.';
        }
        if ($password !== $passwordConfirmacion) {
            $errors[] = 'Las contraseñas no coinciden.';
        }
        if (!in_array($rol, ['alumno', 'instructor'])) {
            $errors[] = 'El tipo de cuenta no es válido.';
        }

        // Verificar si ya existe el correo
        if (Usuario::where('email', $email)) {
            $errors[] = 'El correo ya está registrado.';
        }

        if (!empty($errors)) {
            $_SESSION['errores'] = $errors;
            $_SESSION['old'] = compact('nombre', 'email', 'rol');
            header('Location: /register');
            exit;
        }

        $id = Usuario::create([
            'nombre' => $nombre,
            'email' => $email,
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'rol' => $rol,
            'reputacion' => 0,
        ]);

        $usuario = Usuario::find($id);
        $_SESSION['usuario'] = [
            'id' => $usuario['id'],
            'nombre' => $usuario['nombre'],
            'email' => $usuario['email'],
            'rol' => $usuario['rol'],
        ];
        $_SESSION['mensaje'] = 'Cuenta creada con éxito';
        header('Location: /');
        exit;
    }

    public function logout(Request $request): void
    {
        session_destroy();
        header('Location: /');
        exit;
    }
}