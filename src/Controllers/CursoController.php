<?php

namespace App\Controllers;

use App\Core\Request;
use App\Core\View;
use App\Models\Curso;

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

        if (!$curso) {
            http_response_code(404);
            echo "Curso no encontrado";
            return;
        }

        View::render('cursos/show', [
            'title' => $curso['titulo'],
            'curso' => $curso,
        ]);
    }
}