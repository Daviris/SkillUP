<?php

namespace App\Controllers;

use App\Core\Request;
use App\Core\View;
use App\Models\Usuario;
use App\Models\Pedido;
use App\Models\Resena;

class PerfilController
{
    public function index(Request $request): void
    {
        if (!isset($_SESSION['usuario'])) {
            header('Location: /login');
            exit;
        }

        $usuarioId = $_SESSION['usuario']['id'];
        $usuario = Usuario::find($usuarioId);
        $rol = $usuario['rol'];

        // Datos comunes
        $data = [
            'title' => 'Mi Perfil',
            'usuario' => $usuario,
        ];

        if ($rol === 'alumno') {
            // Historial de pedidos
            $pdo = \App\Core\Database::getConnection();
            $stmt = $pdo->prepare("SELECT p.*, dp.curso_id, c.titulo AS curso_titulo FROM pedidos p JOIN detalle_pedido dp ON p.id = dp.pedido_id JOIN cursos c ON dp.curso_id = c.id WHERE p.usuario_id = :uid ORDER BY p.fecha DESC");
            $stmt->execute(['uid' => $usuarioId]);
            $pedidos = $stmt->fetchAll();

            // Cursos comprados
            $cursosComprados = Pedido::cursosCompradosPorUsuario($usuarioId);

            // Reseñas escritas
            $resenas = Resena::delUsuario($usuarioId);

            $data['pedidos'] = $pedidos;
            $data['cursosComprados'] = $cursosComprados;
            $data['resenas'] = $resenas;
        } elseif ($rol === 'instructor') {
            // Cursos publicados
            $cursos = \App\Models\Curso::whereAll('id_instructor', (string) $usuarioId);
            $data['cursos'] = $cursos;
        }

        View::render('perfil/index', $data);
    }

    public function edit(Request $request): void
    {
        if (!isset($_SESSION['usuario'])) {
            header('Location: /lohgin');
            exit;
        }

        $usuario = Usuario::find($_SESSION['usuario']['id']);
        View::render('perfil/editar', ['title' => 'Editar Perfil', 'usuario' => $usuario]);
    }

    public function update(Request $request): void
    {
        \App\Core\Csrf::verify();
        if (!isset($_SESSION['usuario'])) {
            header('Location: /login');
            exit;
        }

        $usuarioId = $_SESSION['usuario']['id'];
        $nombre = trim($request->input('nombre'));
        $email = trim($request->input('email'));
        $password = $request->input('password');
        $passwordConfirm = $request->input('password_confirmation');

        $errors = [];
        if (empty($nombre)) $errors[] = 'El nombre es obligatorio.';
        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Email no válido.';

        $existente = Usuario::where('email', $email);
        if ($existente && $existente['id'] != $usuarioId) {
            $errors[] = 'El email ya está en uso.';
        }

        $updateData = ['nombre' => $nombre, 'email' => $email];
        if (!empty($password)) {
            if (strlen($password) < 8) $errors[] = 'La contraseña debe tener al menos 8 caracteres.';
            if ($password !== $passwordConfirm) $errors[] = 'Las contraseñas no coinciden.';
            $updateData['password'] = password_hash($password, PASSWORD_DEFAULT);
        }

        if (!empty($errors)) {
            $_SESSION['errores'] = $errors;
            header('Location: /perfil/editar');
            exit;
        }

        Usuario::update($usuarioId, $updateData);
        // Actualizar Datos
        $_SESSION['usuario']['nombre'] = $nombre;
        $_SESSION['usuario']['email'] = $email;
        $_SESSION['mensaje'] = 'Perfil actualizado correctamente.';
        header('Location: /perfil');
        exit;
    }
}