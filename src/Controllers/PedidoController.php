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

        $pdo = Database::getConnection();
        $usuarioId = $_SESSION['usuario']['id'];
        $items = $_SESSION['carrito']['items'];
        $total = 0;

        // Calcular total y que los cursos existen
        $cursosValido = [];
        foreach ($items as $cursoId => $item) {
            $curso = Curso::find((int)$cursoId);
            if ($curso) {
                $subtotal = $curso['precio'] * $item['cantidad'];
                $total += $subtotal;
                $cursosValidados[] = [
                    'id' => $curso['id'],
                    'precio' => $curso['precio'],
                    'cantidad' => $item['cantidad'],
                ];
            }
        }

        if (empty($cursosValidos)) {
            $_SESSION['mensaje'] = 'No se pudo procesar el pedido.';
            header('Location: /carrito');
            exit;
        }

        // Crear el pedido
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
        $_SESSION['mensaje'] = 'Tu pedido #' . $pedidoId . 'ha sido registrado';

        header('Location: /pedido/confirmacion/' . $pedidoId);
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

        View::render('pedido/confirmacion', [
            'title' => 'Pedido completado',
            'pedido' => $pedido,
            'detalles' => $detalles,
        ]);
    }
}