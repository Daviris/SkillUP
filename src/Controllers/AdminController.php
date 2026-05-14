<?php

namespace App\Controllers;

use App\Core\Request;
use App\Core\View;
use App\Models\Usuario;
use App\Models\Curso;
use App\Models\Pedido;
use App\Models\Resena;

class AdminController
{
    private function verificarAdmin(): void
    {
        if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] !== 'admin') {
            header('Location: /login');
            exit;
        }
    }

    // ==================== DASHBOARD ====================
    public function dashboard(Request $request): void
    {
        $this->verificarAdmin();

        $totalUsuarios = count(Usuario::all());
        $totalCursos = count(Curso::all());
        $pedidos = Pedido::all();
        $totalPedidos = count($pedidos);
        $ingresosTotales = array_sum(array_column($pedidos, 'total'));
        $totalResenas = count(Resena::all());

        View::render('admin/dashboard', [
            'title' => 'Panel de Administración',
            'totalUsuarios' => $totalUsuarios,
            'totalCursos' => $totalCursos,
            'totalPedidos' => $totalPedidos,
            'ingresosTotales' => $ingresosTotales,
            'totalResenas' => $totalResenas,
        ]);
    }

    // ==================== USUARIOS ====================
    public function usuarios(Request $request): void
    {
        $this->verificarAdmin();
        $usuarios = Usuario::all();
        View::render('admin/usuarios', ['title' => 'Usuarios', 'usuarios' => $usuarios]);
    }

    public function editarUsuario(Request $request): void
    {
        $this->verificarAdmin();
        $id = (int) $request->param('id');
        $data = [
            'nombre' => $request->input('nombre'),
            'email' => $request->input('email'),
            'rol' => $request->input('rol'),
        ];
        if (!empty($request->input('password'))) {
            $data['password'] = password_hash($request->input('password'), PASSWORD_DEFAULT);
        }
        Usuario::update($id, $data);
        header('Location: /admin/usuarios');
        exit;
    }

    public function eliminarUsuario(Request $request): void
    {
        $this->verificarAdmin();
        $id = (int) $request->param('id');
        Usuario::delete($id);
        header('Location: /admin/usuarios');
        exit;
    }

    // ==================== CURSOS ====================
    public function cursos(Request $request): void
    {
        $this->verificarAdmin();
        $cursos = Curso::todosInstructores();
        View::render('admin/cursos', ['title' => 'Cursos', 'cursos' => $cursos]);
    }

    public function editarCurso(Request $request): void
    {
        $this->verificarAdmin();
        $id = (int) $request->param('id');
        $curso = Curso::find($id);
        if (!$curso) { http_response_code(404); exit; }
        $instructores = Usuario::whereAll('rol', 'instructor');
        View::render('admin/editar_curso', ['title' => 'Editar curso', 'curso' => $curso, 'instructores' => $instructores]);
    }

    public function actualizarCurso(Request $request): void
    {
        $this->verificarAdmin();
        $id = (int) $request->param('id');
        $data = [
            'titulo' => $request->input('titulo'),
            'descripcion' => $request->input('descripcion'),
            'precio' => $request->input('precio'),
            'modalidad' => $request->input('modalidad'),
            'id_instructor' => $request->input('id_instructor'),
        ];
        Curso::update($id, $data);
        header('Location: /admin/cursos');
        exit;
    }

    public function eliminarCurso(Request $request): void
    {
        $this->verificarAdmin();
        $id = (int) $request->param('id');
        Curso::delete($id);
        header('Location: /admin/cursos');
        exit;
    }

    // ==================== PEDIDOS ====================
    public function pedidos(Request $request): void
    {
        $this->verificarAdmin();
        $pedidos = Pedido::all();
        View::render('admin/pedidos', ['title' => 'Pedidos', 'pedidos' => $pedidos]);
    }

    public function cambiarEstadoPedido(Request $request): void
    {
        $this->verificarAdmin();
        $id = (int) $request->param('id');
        $nuevoEstado = $request->input('estado');
        if ($id && in_array($nuevoEstado, ['pendiente', 'completado', 'cancelado'])) {
            Pedido::update($id, ['estado' => $nuevoEstado]);
        }
        header('Location: /admin/pedidos');
        exit;
    }

    public function verPedido(Request $request): void
    {
        $this->verificarAdmin();
        $id = (int) $request->param('id');
        $pedido = Pedido::find($id);

        if (!$pedido) {
            http_response_code(404);
            echo "Pedido no encontrado.";
            exit;
        }

        $pdo = \App\Core\Database::getConnection();
        $stmt = $pdo->prepare("SELECT dp.*, c.titulo FROM detalle_pedido dp JOIN cursos c ON dp.curso_id = c.id WHERE dp.pedido_id = :pedido");
        $stmt->execute(['pedido' => $id]);
        $detalles = $stmt->fetchAll();

        $usuario = Usuario::find($pedido['usuario_id']);

        View::render('admin/ver_pedido', [
            'title' => 'Pedido #' . $pedido['id'],
            'pedido' => $pedido,
            'detalles' => $detalles,
            'usuario' => $usuario,
        ]);
    }

    // ==================== RESEÑAS ====================
    public function resenas(Request $request): void
    {
        $this->verificarAdmin();
        $resenas = Resena::all();
        View::render('admin/resenas', ['title' => 'Reseñas', 'resenas' => $resenas]);
    }

    public function eliminarResena(Request $request): void
    {
        $this->verificarAdmin();
        $id = (int) $request->param('id');
        Resena::delete($id);
        header('Location: /admin/resenas');
        exit;
    }
}