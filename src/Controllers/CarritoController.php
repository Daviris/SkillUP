<?php

namespace App\Controllers;

use App\Core\Request;
use App\Core\View;
use App\Models\Curso;
use App\Models\Pedido;

class CarritoController
{
    // Inicia el carrito en sesión si no lo está ya
    private function iniciarCarrito(): void
    {
        if(!isset($_SESSION['carrito'])) {
            $_SESSION['carrito'] = [];
        }
    }

    // Mostrar el carrito
    public function index(Request $request): void
    {
        $this->iniciarCarrito();
        $items = $_SESSION['carrito']['items'] ?? [];
        $total = 0;

        $cursosEnCarrito = [];
        foreach ($items as $cursoId => $item) {
            $curso = Curso::buscarConClases($cursoId);
            if ($curso) {
                $curso['cantidad'] = $item['cantidad'];
                $curso['precio_unitario'] = $item['precio_unitario'];
                $cursosEnCarrito[] = $curso;
                $total += $curso['precio'] * $item['cantidad'];
            }
        }

        View::render('carrito/index', [
            'title' => 'Tu Mochila',
            'cursos' => $cursosEnCarrito,
            'total' => $total,
        ]);
    }

    // Añadir un curso
        public function agregar(Request $request) : void
        {
            \App\Core\Csrf::verify();
            $idCurso = (int) $request->param('id')   ;
            if (!$idCurso) {
                header('Location: /cursos');
                exit;
            }

            $curso = Curso::find($idCurso);
            if (!$curso) {
                header('Location: /cursos');
                exit;
            }

            if ($curso['modalidad'] === 'presencial') {
                $compradores = Curso::contarCompradores($curso['id']);
                if (isset($curso['plazas']) && $compradores >= $curso['plazas']) {
                    $_SESSION['mensaje'] = 'No quedan plazas disponibles.';
                    header('Location: /cursos/' . $idCurso);
                    exit;
                }
            }

            $this->iniciarCarrito();

            if (isset($_SESSION['carrito']['items'][$idCurso])) {
                $_SESSION['mensaje'] = 'Este curso ya está en tu mochila';
                header('Location: /carrito');
                exit;
            }

            if (isset($_SESSION['usuario'])) {
                if (Pedido::usuarioTieneCurso($_SESSION['usuario']['id'], $idCurso)) {
                    $_SESSION['mensaje'] = 'Ya has adquirido este curso.';
                    header('Location: /carrito');
                    exit;
                }
            }

            $_SESSION['carrito']['items'][$idCurso] = [
                'cantidad' => 1,
                'precio_unitario' => $curso['precio']
            ];

            $_SESSION['mensaje'] = 'Curso añadido a tu mochila.';
            header('Location: /carrito');
            exit;
        }

        // Eliminar un curso
        public function eliminar(Request $request): void
        {
            \App\Core\Csrf::verify();
            $idCurso = (int) $request->param('id');
            $this->iniciarCarrito();

            if (isset($_SESSION['carrito']['items'][$idCurso])) {
                unset($_SESSION['carrito']['items'][$idCurso]);
            }

            header('Location: /carrito');
            exit;
        }

        // Vaciar carro
        public function vaciar(Request $request): void
        {
            \App\Core\Csrf::verify();
            $_SESSION['carrito'] = [];
            header('Location: /carrito');
            exit;
        }
}