<?php

namespace App\Controllers;

use App\Core\Request;
use App\Models\Resena;
use App\Models\Curso;
use App\Models\Pedido;

class ResenaController
{
    // Almacenar reseña
    public function store(Request $request): void
    {
        \App\Core\Csrf::verify();
        if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] !== 'alumno') {
            header('Location: /login');
            exit;
        }

        $cursoId    = (int) $request->input('curso_id');
        $puntuacion = (int) $request->input('puntuacion');
        $comentario = trim($request->input('comentario', ''));

        if (!$cursoId || $puntuacion < 1 || $puntuacion > 5) {
            $_SESSION['mensaje'] = 'Datos inválidos.';
            header('Location: /cursos/' . $cursoId);
            exit;
        }

        $usuarioId = $_SESSION['usuario']['id'];

        if (!Pedido::usuarioTieneCurso($usuarioId, $cursoId)) {
            http_response_code(403);
            echo "No puedes reseñar un curso que no has comprado.";
            exit;
        }

        // Evitar duplicado usando el nuevo método
        $existente = Resena::buscarPorUsuarioYCurso($usuarioId, $cursoId);
        if ($existente) {
            $_SESSION['mensaje'] = 'Ya has reseñado este curso.';
            header('Location: /cursos/' . $cursoId);
            exit;
        }

        Resena::create([
            'usuario_id'  => $usuarioId,
            'curso_id'    => $cursoId,
            'puntuacion'  => $puntuacion,
            'comentario'  => $comentario,
            'fecha'       => date('Y-m-d H:i:s'),
        ]);

        // Actualizar reputación del instructor
        $curso = Curso::find($cursoId);
        if ($curso) {
            Resena::actualizarReputacionInstructor($curso['id_instructor']);
        }

        $_SESSION['mensaje'] = '¡Gracias por tu reseña!';
        header('Location: /cursos/' . $cursoId);
        exit;
    }

    // Editar reseña
    public function edit(Request $request): void
    {
        if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] !== 'alumno') {
            header('Location: /login');
            exit;
        }

        $id = (int) $request->param('id');
        $resena = Resena::find($id);

        if (!$resena || $resena['usuario_id'] != $_SESSION['usuario']['id']) {
            http_response_code(403);
            echo "No puedes editar esta reseña.";
            exit;
        }

        \App\Core\View::render('resenas/editar', [
            'title' => 'Editar reseña',
            'resena' => $resena,
        ]);
    }

    // Actualizar reseña
    public function update(Request $request): void
    {
        \App\Core\Csrf::verify();
        if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] !== 'alumno') {
            header('Location: /login');
            exit;
        }

        $id = (int) $request->param('id');
        $resena = Resena::find($id);

        if (!$resena || $resena['usuario_id'] != $_SESSION['usuario']['id']) {
            http_response_code(403);
            exit;
        }

        $puntuacion = (int) $request->input('puntuacion');
        $comentario = trim($request->input('comentario', ''));

        if ($puntuacion < 1 || $puntuacion > 5) {
            $_SESSION['mensaje'] = 'Puntuación inválida.';
            header('Location: /resena/editar/' . $id);
            exit;
        }

        Resena::update($id, [
            'puntuacion' => $puntuacion,
            'comentario' => $comentario,
            'fecha' => date('Y-m-d H:i:s'),
        ]);

        // Recalcular reputacion
        $curso = Curso::find($resena['curso_id']);
        if ($curso) {
            Resena::actualizarReputacionInstructor($curso['id_instructor']);
        }

        $_SESSION['mensaje'] = 'Reseña actualizada.';
        header('Location: /cursos/' . $resena['curso_id']);
        exit;
    }

    // Eliminar Reseña
    public function delete(Request $request): void
    {
        if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] !== 'alumno') {
            header('Location: /login');
            exit;
        }

        $id = (int) $request->param('id');
        $resena = Resena::find($id);

        if (!$resena || $resena['usuario_id'] != $_SESSION['usuario']['id']) {
            http_response_code(403);
            exit;
        }

        $cursoId = $resena['curso_id'];
        Resena::delete($id);

        // Recalcular reputación
        $curso = Curso::find($cursoId);
        if ($curso) {
            Resena::actualizarReputacionInstructor($curso['id_instructor']);
        }

        $_SESSION['mensaje'] = 'Reseña eliminada.';
        header('Location: /cursos/' . $cursoId);
        exit;
    }
}