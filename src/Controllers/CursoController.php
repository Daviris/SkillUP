<?php

namespace App\Controllers;

use App\Core\Request;
use App\Core\View;
use App\Models\Curso;
use App\Models\Pedido;

class CursoController
{
    public function index(Request $request): void
    {
        $modalidad = $request->input('modalidad');
        $precioMax = $request->input('precio_max');
        $pag = (int) $request->input('pag', 1);

        $data = Curso::listar(
            $modalidad ?: null,
            $precioMax !== null ? (float) $precioMax : null,
            12,
            $pag
        );

        $data['title'] = 'Catálogo de cursos';
        $data['modalidad'] = $modalidad;
        $data['precio_max'] = $precioMax;

        View::render('cursos/index', $data);
    }

    public function show(Request $request): void
    {
        $id = (int) $request->param('id');
        $curso = Curso::buscarConClases($id);
        $completo = false;
        if ($curso['modalidad'] === 'presencial' && isset($curso['plazas'])) {
            $compradores = Curso::contarCompradores($curso['id']);
            $completo = $compradores >= $curso['plazas'];
            $curso['compradores'] = $compradores;
        }
        $yaComprado = false;
        if (isset($_SESSION['usuario'])) {
            $yaComprado = Pedido::usuarioTieneCurso($_SESSION['usuario']['id'], $id);
        }

        if (!$curso) {
            http_response_code(404);
            echo "Curso no encontrado";
            return;
        }

        View::render('cursos/show', [
            'title' => $curso['titulo'],
            'curso' => $curso,
            'yaComprado' => $yaComprado,
            'completo' => $completo,
        ]);
    }

    public function verInstructor(Request $request): void
    {
        $id = (int) $request->param('id');
        $instructor = \App\Models\Usuario::find($id);
        if (!$instructor || $instructor['rol'] !== 'instructor') {
            http_response_code(404);
            echo "Instructor no encontrado.";
            exit;
        }

        $cursos = Curso::whereAll('id_instructor', (string) $id);
        $totalResenas = 0;
        $sumaPuntuaciones = 0;
        foreach ($cursos as $curso) {
            $resenas = \App\Models\Resena::delCurso($curso['id']);
            $totalResenas += count($resenas);
            foreach ($resenas as $r) {
                $sumaPuntuaciones += $r['puntuacion'];
            }
        }
        $reputacion = $totalResenas > 0 ? round($sumaPuntuaciones / $totalResenas, 1) : 0;

        View::render('instructor/perfil_publico', [
            'title' => $instructor['nombre'],
            'instructor' => $instructor,
            'cursos' => $cursos,
            'reputacion' => $reputacion,
            'totalResenas' => $totalResenas,
        ]);
    }

    public function apiIndex(Request $request): void
    {
        $modalidad = $request->input('modalidad');
        $precioMax = $request->input('precio_max');
        if ($modalidad === '') $modalidad = null;
        if ($precioMax === '') $precioMax = null;
        $page = (int) $request->input('page', 1);

        $data = Curso::listar(
            $modalidad ?: null,
            $precioMax !== null ? (float) $precioMax : null,
            12,
            $page
        );

        // Añadir conteo de compradores para los cursos presenciales.
        foreach ($data['cursos'] as &$curso) {
            if ($curso['modalidad'] === 'presencial' && isset($curso['plazas'])) {
                $curso['compradores'] = Curso::contarCompradores($curso['id']);
            }
        }
        unset($curso);

        if (ob_get_level()) {
            ob_clean();
        }

        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }

    public function apiShow(Request $request): void
    {
        $id = (int) $request->param('id');
        $curso = Curso::buscarConClases($id);
        if (!$curso) {
            http_response_code(404);
            echo json_encode(['error' => 'Curso no encontrado']);
            exit;
        }
        header('Content-Type: application/json');
        echo json_encode($curso);
        exit;
    }
}