<?php

namespace App\Controllers;

use App\Core\Request;
use App\Core\View;
use App\Models\Pedido;

class MisCursosController
{
    public function index(Request $request): void
    {
        if (!isset($_SESSION['usuario'])) {
            header('Location: /login');
            exit;
        }

        $cursos = Pedido::cursosCompradosPorUsuario($_SESSION['usuario']['id']);

        View::render('mis-cursos/index', [
            'title' => 'Mis Cursos',
            'cursos' => $cursos,
        ]);
    }
}