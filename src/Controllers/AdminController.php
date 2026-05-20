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

        $this->renderAdmin('admin/dashboard', [
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
        $this->renderAdmin('admin/usuarios', ['title' => 'Usuarios']);
    }

    public function actualizarUsuario(Request $request): void
    {
        \App\Core\Csrf::verify();
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
        $this->renderAdmin('admin/editar_usuario', ['title' => 'Editar usuario', 'usuario' => $usuario]);
    }

    public function eliminarUsuario(Request $request): void
    {
        $this->verificarAdmin();
        $id = (int) $request->param('id');
        Usuario::delete($id);
        header('Location: /admin/usuarios');
        exit;
    }

    public function cursosDeAlumno(Request $request): void
    {
        $this->verificarAdmin();
        $usuarioId = (int) $request->param('id');
        $usuario = Usuario::find($usuarioId);
        if (!$usuario) {
            http_response_code(404);
            echo "Usuario no encontrado.";
            exit;
        }

        $pdo = \App\Core\Database::getConnection();
        $stmt = $pdo->prepare("SELECT c.id, c.titulo, c.precio, p.id AS pedido_id, p.estado FROM detalle_pedido dp JOIN pedidos p ON dp.pedido_id = p.id JOIN cursos c ON dp.curso_id = c.id WHERE p.usuario_id = :uid ORDER BY p.fecha DESC");
        $stmt->execute(['uid' => $usuarioId]);
        $cursos = $stmt->fetchAll();

        $this->renderAdmin('admin/cursos_de_alumno', [
            'title' => 'Cursos de ' . $usuario['nombre'],
            'usuario' => $usuario,
            'cursos' => $cursos,
        ]);
    }

    // ==================== CURSOS ====================
    public function cursos(Request $request): void
    {
        $this->verificarAdmin();
        $this->renderAdmin('admin/cursos', ['title' => 'Cursos']);
    }

    public function editarCurso(Request $request): void
    {
        $this->verificarAdmin();
        $id = (int) $request->param('id');
        $curso = Curso::find($id);
        if (!$curso) { http_response_code(404); exit; }
        $instructores = Usuario::whereAll('rol', 'instructor');
        $this->renderAdmin('admin/editar_curso', ['title' => 'Editar curso', 'curso' => $curso, 'instructores' => $instructores]);
    }

    public function actualizarCurso(Request $request): void
    {
        \App\Core\Csrf::verify();
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

    public function alumnosDeCurso(Request $request): void
    {
        $this->verificarAdmin();
        $cursoId = (int) $request->param('id');
        $curso = Curso::find($cursoId);
        if (!$curso) {
            http_response_code(404);
            echo "Curso no encontrado.";
            exit;
        }

        $pdo = \App\Core\Database::getConnection();
        $stmt = $pdo->prepare("SELECT u.id, u.nombre, u.email, p.id AS pedido_id, p.estado FROM detalle_pedido dp JOIN pedidos p ON dp.pedido_id = p.id JOIN usuarios u ON p.usuario_id = u.id WHERE dp.curso_id = :cid ORDER BY p.fecha DESC");
        $stmt->execute(['cid' => $cursoId]);
        $alumnos = $stmt->fetchAll();

        $this->renderAdmin('admin/alumnos_de_curso', [
            'title'   => 'Alumnos de ' . $curso['titulo'],
            'curso'   => $curso,
            'alumnos' => $alumnos,
        ]);
    }

    // ==================== PEDIDOS ====================
    public function pedidos(Request $request): void
    {
        $this->verificarAdmin();
        $this->renderAdmin('admin/pedidos', ['title' => 'Pedidos']);
    }

    public function cambiarEstadoPedido(Request $request): void
    {
        $this->verificarAdmin();
        $id = (int) $request->param('id');
        $nuevoEstado = $request->input('estado') ?? $_GET['estado'] ?? '';

        if (!in_array($nuevoEstado, ['pendiente', 'completado', 'cancelado'])) {
            $_SESSION['mensaje'] = 'Estado no válido.';
            header('Location: /admin/pedidos');
            exit;
        }

        $pedido = Pedido::find($id);
        if (!$pedido) {
            $_SESSION['mensaje'] = 'Pedido no encontrado.';
            header('Location: /admin/pedidos');
            exit;
        }

        if ($nuevoEstado === 'completado' && $pedido['estado'] === 'cancelado') {
            $pdo = \App\Core\Database::getConnection();
            $stmt = $pdo->prepare("SELECT dp.curso_id, c.plazas, c.modalidad 
                                FROM detalle_pedido dp 
                                JOIN cursos c ON dp.curso_id = c.id 
                                WHERE dp.pedido_id = :pid");
            $stmt->execute(['pid' => $id]);
            $cursosDelPedido = $stmt->fetchAll();

            foreach ($cursosDelPedido as $curso) {
                if ($curso['modalidad'] === 'presencial' && $curso['plazas'] !== null) {
                    $compradoresActuales = Curso::contarCompradores($curso['curso_id']);
                    if ($compradoresActuales >= $curso['plazas']) {
                        $_SESSION['mensaje'] = 'No se puede reactivar el pedido: el curso "' . $curso['titulo'] . '" ya tiene todas las plazas ocupadas.';
                        header('Location: /admin/pedidos');
                        exit;
                    }
                }
            }
        }

        Pedido::update($id, ['estado' => $nuevoEstado]);
        $_SESSION['mensaje'] = 'Estado del pedido actualizado correctamente.';
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

        $this->renderAdmin('admin/ver_pedido', [
            'title'    => 'Pedido #' . $pedido['id'],
            'pedido'   => $pedido,
            'detalles' => $detalles,
        ]);
    }

        public function revocarAccesoCurso(Request $request): void
    {
        $this->verificarAdmin();
        $pedidoId = (int) $request->param('id');

        $pedido = Pedido::find($pedidoId);
        if (!$pedido) {
            $_SESSION['mensaje'] = 'Pedido no encontrado.';
            header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? '/admin'));
            exit;
        }

        // Cancelar el pedido
        Pedido::update($pedidoId, ['estado' => 'cancelado']);
        $_SESSION['mensaje'] = 'Acceso revocado correctamente.';
        header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? '/admin'));
        exit;
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

        $this->renderAdmin('admin/ver_resenas', [
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

    // ==================== DATATABLES ====================
    public function apiUsuarios(Request $request): void
    {
        $this->verificarAdmin();
        $usuarios = Usuario::all();
        ob_clean();
        header('Content-Type: application/json');
        echo json_encode(['data' => $usuarios]);
        exit;
    }

    public function apiCursos(Request $request): void
    {
        $this->verificarAdmin();
        $estado = $request->input('estado'); // 'revision', 'publicado', etc.
        $pdo = \App\Core\Database::getConnection();
        $sql = "SELECT c.id, c.titulo, c.precio, c.modalidad, u.nombre AS instructor_nombre FROM cursos c JOIN usuarios u ON c.id_instructor = u.id";
        if ($estado) {
            $sql .= " WHERE c.estado = :estado";
        }
        $sql .= " ORDER BY c.created_at DESC";
        $stmt = $pdo->prepare($sql);
        if ($estado) {
            $stmt->execute(['estado' => $estado]);
        } else {
            $stmt->execute();
        }
        $cursos = $stmt->fetchAll();
        ob_clean();
        header('Content-Type: application/json');
        echo json_encode(['data' => $cursos]);
        exit;
    }

    public function apiPedidos(Request $request): void
    {
        $this->verificarAdmin();
        $pdo = \App\Core\Database::getConnection();
        $stmt = $pdo->query("SELECT p.*, u.nombre AS usuario_nombre FROM pedidos p JOIN usuarios u ON p.usuario_id = u.id ORDER BY p.fecha DESC");
        $pedidos = $stmt->fetchAll();
        ob_clean();
        header('Content-Type: application/json');
        echo json_encode(['data' => $pedidos]);
        exit;
    }

    public function apiResenasCurso(Request $request): void
    {
        $this->verificarAdmin();
        $id = (int) $request->param('id');
        $resenas = Resena::delCurso($id);
        ob_clean();
        header('Content-Type: application/json');
        echo json_encode(['data' => $resenas]);
        exit;
    }

    // ==================== REVISIONES ====================
    public function revisiones(Request $request): void
    {
        $this->verificarAdmin();

        $cursos = Curso::whereAll('estado', 'revision');

        $this->renderAdmin('admin/revisiones', [
            'title'  => 'Cursos en Revisión',
            'cursos' => $cursos,
        ]);
    }

    public function aprobarCurso(Request $request): void
    {
        $this->verificarAdmin();
        $id = (int) $request->param('id');
        Curso::update($id, ['estado' => 'publicado', 'motivo_rechazo' => null]);
        $_SESSION['mensaje'] = 'Curso aprobado y publicado.';
        header('Location: /admin/revisiones');
        exit;
    }

    public function rechazarCurso(Request $request): void
    {
        $this->verificarAdmin();
        $id = (int) $request->param('id');
        $motivo = $request->input('motivo', '');
        Curso::update($id, ['estado' => 'rechazado', 'motivo_rechazo' => $motivo]);
        $_SESSION['mensaje'] = 'Curso rechazado.';
        header('Location: /admin/revisiones');
        exit;
    }

    public function verClasesRevision(Request $request): void
    {
        $this->verificarAdmin();
        $id = (int) $request->param('id');
        $curso = Curso::buscarConClases($id);
        if (!$curso) {
            http_response_code(404);
            echo "Curso no encontrado.";
            exit;
        }
        $this->renderAdmin('admin/ver_clases_revision', [
            'title' => 'Clases de ' . $curso['titulo'],
            'curso' => $curso,
        ]);
    }

    private function pendientesRevision(): int
    {
        $pdo = \App\Core\Database::getConnection();
        $stmt = $pdo->query("SELECT COUNT(*) FROM cursos WHERE estado = 'revision'");
        return (int) $stmt->fetchColumn();
    }

    private function renderAdmin(string $template, array $data = []): void
    {
        $data['pendientesRevision'] = $this->pendientesRevision();
        View::render($template, $data);
    }
}