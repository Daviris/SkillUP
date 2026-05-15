<?php

namespace App\Controllers;

use App\Core\Request;
use App\Core\View;

class HomeController
{
    public function index(Request $request): void
    {
        $totalCursos = count(\App\Models\Curso::all());
        $totalAlumnos = count(\App\Models\Usuario::whereAll('rol', 'alumno'));
        $totalInstructores = count(\App\Models\Usuario::whereAll('rol', 'instructor'));

        View::render('home', [
            'title' => 'SkillUP - Sube de nivel',
            'totalCursos' => $totalCursos,
            'totalAlumnos' => $totalAlumnos,
            'totalInstructores' => $totalInstructores,
        ]);
    }
}