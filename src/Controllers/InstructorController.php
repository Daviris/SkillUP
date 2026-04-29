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
        
    }
}