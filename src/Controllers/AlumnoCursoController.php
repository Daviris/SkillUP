<?php

namespace App\Controllers;

use App\Core\Request;
use App\Core\View;
use App\Models\Curso;
use App\Models\Pedido;
use App\Models\Clase;
use App\Models\Archivo;
use App\Models\Tarea;

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

    public function verClase(Request $request): void
    {
        if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] !== 'alumno') {
            header('Location: /login');
            exit;
        }

        $claseId = (int) $request->param('id');
        $clase = \App\Models\Clase::find($claseId);
        if (!$clase) {
            http_response_code(404);
            echo "Clase no encontrada.";
            exit;
        }

        $curso = Curso::find($clase['curso_id']);
        if (!$curso) {
            http_response_code(404);
            echo "Curso no encontrado.";
            exit;
        }

        // Verificar que el alumno ha comprado el curso
        if (!Pedido::usuarioTieneCurso($_SESSION['usuario']['id'], $curso['id'])) {
            http_response_code(403);
            echo "No has comprado este curso.";
            exit;
        }

        // Obtener datos adicionales según el tipo de clase
        $archivo = null;
        if ($clase['archivo_id']) {
            $archivo = \App\Models\Archivo::find($clase['archivo_id']);
        }
        $entrega = null;
        if ($clase['tipo'] === 'tarea') {
            $entrega = \App\Models\Tarea::entregaAlumno($claseId, $_SESSION['usuario']['id']);
        }

        View::render('mis-cursos/clase', [
            'title' => $clase['titulo'],
            'clase' => $clase,
            'curso' => $curso,
            'archivo' => $archivo,
            'entrega' => $entrega,
        ]);
    }
}