<?php

namespace App\Controllers;

use App\Core\Request;
use App\Core\View;
use App\Core\Database;
use App\Models\Curso;

class PedidoController
{
    // Finalizar compra
    public function checkout(Request $request): void
    {
        if (!isset($_SESSION['usuario'])) {
            header('Location: /login');
            exit;
        }

        if (empty($_SESSION['carrito']['items'])) {
            header('Location: /carrito');
            exit;
        }

        $items = $_SESSION['carrito']['items'];
        $cursosValidos = [];

        // Calcular total y que los cursos existen
        foreach ($items as $cursoId => $item) {
            $curso = Curso::find((int)$cursoId);
            if ($curso) {
                $cursosValidos[] = [
                    'id' => $curso['id'],
                    'precio' => $curso['precio'],
                    'cantidad' => $item['cantidad'] ?? 1,
                ];
            } else {
                unset($_SESSION['carrito']['items'][$idCurso]);
            }
        }

        if (empty($cursosValidos)) {
            $_SESSION['mensaje'] = 'Los cursos de tu mochila ya no están disponibles.';
            header('Location: /carrito');
            exit;
        }

        // Crear el pedido
        $pdo = Database::getConnection();
        $usuarioId = $_SESSION['usuario']['id'];
        $total = 0;
        foreach ($cursosValidos as $cv) {
            $total += $cv['precio'] * $cv['cantidad'];
        }

        $stmt = $pdo->prepare("INSERT INTO pedidos (usuario_id, fecha, total, estado) VALUES (:usuario, NOW(), :total, 'completado')");
        $stmt->execute([
            'usuario' => $usuarioId,
            'total' => $total,
        ]);
        $pedidoId = $pdo->lastInsertId();

        // Crear los detalles del pedido
        $stmtDetalle = $pdo->prepare("INSERT INTO detalle_pedido (pedido_id, curso_id, precio, cantidad) VALUES (:pedido, :curso, :precio, :cantidad)");
        foreach ($cursosValidos as $cv) {
            $stmtDetalle->execute([
                'pedido' => $pedidoId,
                'curso' => $cv['id'],
                'precio' => $cv['precio'],
                'cantidad' => $cv['cantidad'],
            ]);
        }

        // Vaciar carrito
        $_SESSION['carrito'] = [];
        
        header('Location: /pedidos/confirmacion/' . $pedidoId);
        exit;
    }

    // Confirmación de pedido
    public function confirmacion(Request $request): void
    {
        if (!isset($_SESSION['usuario'])) {
            header('Location: /login');
            exit;
        }

        $pedidoId = (int) $request->param('id');
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("SELECT * FROM pedidos WHERE id= :id AND usuario_id = :usuario");
        $stmt->execute(['id' => $pedidoId, 'usuario' => $_SESSION['usuario']['id']]);
        $pedido = $stmt->fetch();

        if (!$pedido) {
            http_response_code(404);
            echo "Pedido no encontrado";
            return;
        }

        // Obtener los detalles de la confirmación
        $stmtDetalles = $pdo->prepare("SELECT dp.*, c.titulo FROM detalle_pedido dp JOIN cursos c ON dp.curso_id = c.id WHERE dp.pedido_id = :pedido");
        $stmtDetalles->execute(['pedido' => $pedidoId]);
        $detalles = $stmtDetalles->fetchAll();

        View::render('pedidos/confirmacion', [
            'title' => 'Pedido completado',
            'pedido' => $pedido,
            'detalles' => $detalles,
        ]);
    }

    public function formularioCheckout(Request $request): void
    {
        if (!isset($_SESSION['usuario'])) {
            header('Location: /login');
            exit;
        }
        if (empty($_SESSION['carrito']['items'])) {
            header('Location: /carrito');
            exit;
        }
        View::render('pedidos/checkout', ['title' => 'Checkout']);
    }

    public function procesarCheckout(Request $request): void
    {
        $this->checkout($request);
    }
}