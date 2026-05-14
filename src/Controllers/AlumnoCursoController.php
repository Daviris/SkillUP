<?php

namespace App\Controllers;

use App\Core\Request;
use App\Core\View;
use App\Models\Curso;
use App\Models\Pedido;

class AlumnoCursoController
{
    public function verCurso(Request $request): void
    {
        if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] !== 'alumno') {
            header('Location: /login');
            exit;
        }

        $idCurso = (int) $request->param('id');
        $usuarioId = $_SESSION['usuario']['id'];

        if (!Pedido::usuarioTieneCurso($usuarioId, $idCurso)) {
            http_response_code(403);
            echo "No has comprado este curso.";
            exit;
        }

        $curso = Curso::buscarConClases($idCurso);
        if (!$curso) {
            http_response_code(404);
            echo "Curso no encontrado.";
            exit;
        }

        View::render('mis-cursos/ver', [
            'title' => $curso['titulo'],
            'curso' => $curso,
        ]);
    }
}