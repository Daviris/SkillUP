<?php

namespace App\Controllers;

use App\Core\Request;
use App\Core\View;
use App\Models\Curso;

class InstructorController
{
    // Verificar si el usuario es instructor.
    private function verificarInstructor(): void
    {
        if(!isset($_SESSION['usuario']) || $_SESSION['usuari']['rol'] !== "instructor") {
            header('Location: /login');
            exit;
        }
    }

    // Cursos del instructor.
    public function index(Request $request): void
    {
        $this->verificarInstructor();

        $cursos = Curso::whereAll('id_instructor', $_SESSION['usuario']['id']);
        View::render('instructor/index', [
            'title' => 'Panel de instructor',
            'cursos' => $cursos,
        ]);
    }

    // Crear nuevo curso.
    public function create(Request $request): void
    {
        $this->verificarInstructor();
        View::render('instructor/form', [
            'title' => 'Crear Curso',
            'accion' => 'Crear',
            'curso' => null,
        ]);
    }

    // Guarda el curso.
    public function store(Request $request): void
    {
        $this->verificarInstructor();

        $data = [
            'id_instructor' => $_SESSION['usuario']['id'],
            'titulo' => $request->input('titulo'),
            'descripcion' => $request->input('descripcion'),
            'precio' => $request->input('precio'),
            'modalidad' => $request->input('modalidad'),
        ];

        Curso::create($data);

        $_SESSION['mensaje'] = 'Curso creado correctamente.';
        header('Location: /instructor');
        exit;
    }

    // Editar curso.

    public function edit(Request $request): void
    {
        $this->verificarInstructor();

        $id = (int) $request->param('id');
        $curso = Curso::find($id);

        if (!$curso || $curso['id_instructor'] != $_SESSION['usuario']['id']) {
            http_response_code(403);
            echo "No tienes permiso para editar este curso";
            exit;
        }

        View::render('instructor/form', [
            'title' => 'Editar Curso',
            'accion' => 'Actualizar',
            'curso' => $curso,
        ]);
    }

    // Actualizar curso editado.
    public  function update(Request $request): void
    {
        $this->verificarInstructor();

        $id = (int) $request->param('id');
        $curso = Curso::find($id);

        if (!$curso || $curso['id_instructor'] != $_SESSION['usuario']['id']) {
            http_response_code(403);
            exit;
        }

        Curso::update($id, [
            'titulo' => $request->input('titulo'),
            'descripcion' => $request->input('descripcion'),
            'precio' => $request->input('precio'),
            'modalidad' => $request->input('modalidad'),
        ]);

        $_SESSION['mensaje'] = 'Curso actualizado correctamente.';
        header('Location: /instructor');
        exit;
    }

    // Eliminar un curso.
    public function delete(Request $request): void
    {
        $this->verificarInstructor();

        $id = (int) $request->param('id');
        $curso = Curso::find($id);

        if ($curso && $curso['id_instructor'] == $_SESSION['usuario']['id']) {
            Curso::delete($id);
            $_SESSION['mensaje'] = 'Curso eliminado correctamente.';
        }

        header('Location: /instructor');
        exit;
    }
}