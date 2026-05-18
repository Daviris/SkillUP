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

    public function actualizarUsuario(Request $request): void
    {
        $this->verificarAdmin();
        $id = (int) $request->param('id');

        $nombre = trim($request->input('nombre', ''));
        $email = trim($request->input('email', ''));
        $rol = $request->input('rol', 'alumno');

        if (empty($nombre) || empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['mensaje'] = 'El nombre y un email válido son obligatorios.';
            header('Location: /admin/usuarios/editar/' . $id);
            exit;
        }

        if (!in_array($rol, ['alumno', 'instructor', 'admin'])) {
            $rol = 'alumno';
        }

        $data = [
            'nombre' => $nombre,
            'email' => $email,
            'rol' => $rol,
        ];

        if (!empty($request->input('password'))) {
            $data['password'] = password_hash($request->input('password'), PASSWORD_DEFAULT);
        }

        Usuario::update($id, $data);
        $_SESSION['mensaje'] = 'Usuario actualizado correctamente.';
        header('Location: /admin/usuarios');
        exit;
    }

    public function editarUsuario(Request $request): void
    {
        $this->verificarAdmin();
        $id = (int) $request->param('id');
        $usuario = Usuario::find($id);
        if (!$usuario) {
            http_response_code(404);
            echo "Usuario no encontrado.";
            exit;
        }
        View::render('admin/editar_usuario', ['title' => 'Editar usuario', 'usuario' => $usuario]);
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
        $pdo = \App\Core\Database::getConnection();
        // Obtener cursos con media de reseñas
        $stmt = $pdo->query("SELECT c.*, u.nombre AS instructor_nombre, 
                            AVG(r.puntuacion) AS media_resenas, 
                            COUNT(r.id) AS total_resenas
                            FROM cursos c 
                            JOIN usuarios u ON c.id_instructor = u.id 
                            LEFT JOIN resenas r ON c.id = r.curso_id 
                            GROUP BY c.id 
                            ORDER BY c.created_at DESC");
        $cursos = $stmt->fetchAll();
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
        $pdo = \App\Core\Database::getConnection();
        $stmt = $pdo->query("SELECT p.*, u.nombre AS usuario_nombre FROM pedidos p JOIN usuarios u ON p.usuario_id = u.id ORDER BY p.fecha DESC");
        $pedidos = $stmt->fetchAll();
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

        $pdo = \App\Core\Database::getConnection();
        $stmt = $pdo->prepare("SELECT p.*, u.nombre AS usuario_nombre, u.email AS usuario_email 
                            FROM pedidos p 
                            JOIN usuarios u ON p.usuario_id = u.id 
                            WHERE p.id = :id");
        $stmt->execute(['id' => $id]);
        $pedido = $stmt->fetch();

        if (!$pedido) {
            http_response_code(404);
            echo "Pedido no encontrado.";
            exit;
        }

        $stmtDetalles = $pdo->prepare("SELECT dp.*, c.titulo FROM detalle_pedido dp JOIN cursos c ON dp.curso_id = c.id WHERE dp.pedido_id = :pedido");
        $stmtDetalles->execute(['pedido' => $id]);
        $detalles = $stmtDetalles->fetchAll();

        View::render('admin/ver_pedido', [
            'title'    => 'Pedido #' . $pedido['id'],
            'pedido'   => $pedido,
            'detalles' => $detalles,
        ]);
    }

    // ==================== RESEÑAS ====================
    public function verResenas(Request $request): void
    {
        $this->verificarAdmin();
        $id = (int) $request->param('id');
        $curso = Curso::find($id);
        if (!$curso) {
            http_response_code(404);
            echo "Curso no encontrado.";
            exit;
        }

        $resenas = Resena::delCurso($id);
        $media = 0;
        $totalResenas = count($resenas);
        if ($totalResenas > 0) {
            $suma = array_sum(array_column($resenas, 'puntuacion'));
            $media = $suma / $totalResenas;
        }

        View::render('admin/ver_resenas', [
            'title'        => 'Reseñas de ' . $curso['titulo'],
            'curso'        => $curso,
            'resenas'      => $resenas,
            'media'        => $media,
            'totalResenas' => $totalResenas,
        ]);
    }

    public function eliminarResena(Request $request): void
    {
        $this->verificarAdmin();
        $id = (int) $request->param('id');
        $cursoId = $request->input('curso_id') ?? $request->input('curso_id', 0);
        Resena::delete($id);
        if ($cursoId) {
            header('Location: /admin/cursos/' . $cursoId . '/resenas');
        } else {
            header('Location: /admin/cursos');
        }
        exit;
    }
}