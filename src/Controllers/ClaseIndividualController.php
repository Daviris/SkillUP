<?php

// Se ha tenido que crear este controlador separado solo para mostrar las clases
// debido a un problema raro de enrutamiento en el otro.

namespace App\Controllers;

use App\Core\Request;
use App\Models\Clase;
use App\Models\Curso;
use App\Models\Pedido;
use App\Models\Tarea;

class ClaseIndividualController
{
    public function mostrar(Request $request): void
    {
        if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] !== 'alumno') {
            header('Location: /login');
            exit;
        }

        $claseId = (int) $request->param('id');
        $clase = Clase::find($claseId);

        if (!$clase) {
            http_response_code(404);
            echo "Clase no encontrada.";
            exit;
        }

        $cursoId = (int) $clase['curso_id'];
        if (!Pedido::usuarioTieneCurso($_SESSION['usuario']['id'], $cursoId)) {
            http_response_code(403);
            echo "No has comprado este curso.";
            exit;
        }

        $curso = Curso::find($cursoId);
        $entrega = ($clase['tipo'] === 'tarea') ? Tarea::entregaAlumno($claseId, $_SESSION['usuario']['id']) : null;

        \App\Core\View::render('mis-cursos/clase', [
            'title'   => $clase['titulo'],
            'clase'   => $clase,
            'curso'   => $curso,
            'entrega' => $entrega,
        ]);
    }
}