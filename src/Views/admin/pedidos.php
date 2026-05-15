<?php ob_start(); ?>
<h1 class="font-rpg" style="font-size:2.5rem; color:#fbbf24; margin-bottom:2rem;">Pedidos</h1>

<div class="table-container">
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Usuario</th>
                <th>Total</th>
                <th>Fecha</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($pedidos as $pedido): ?>
            <tr>
                <td>#<?= $pedido['id'] ?></td>
                <td><?= htmlspecialchars($pedido['usuario_nombre'] ?? $pedido['usuario_id']) ?></td>
                <td style="color:#fbbf24; font-weight:600;"><?= number_format($pedido['total'], 2) ?> €</td>
                <td><?= date('d/m/Y', strtotime($pedido['fecha'])) ?></td>
                <td>
                    <span class="badge <?= $pedido['estado'] === 'completado' ? 'badge-green' : ($pedido['estado'] === 'cancelado' ? 'badge-red' : 'badge-amber') ?>">
                        <?= $pedido['estado'] ?>
                    </span>
                </td>
                <td>
                    <div style="display:flex; gap:0.5rem; align-items:center;">
                        <a href="/admin/pedidos/ver/<?= $pedido['id'] ?>" class="btn btn-primary btn-sm">Ver</a>
                        <form action="/admin/pedidos/cambiar-estado/<?= $pedido['id'] ?>" method="POST" style="display:inline;">
                            <select name="estado" onchange="this.form.submit()" class="form-select" style="width:auto; padding:0.3rem 0.5rem; font-size:0.85rem;">
                                <option value="pendiente" <?= $pedido['estado'] === 'pendiente' ? 'selected' : '' ?>>Pendiente</option>
                                <option value="completado" <?= $pedido['estado'] === 'completado' ? 'selected' : '' ?>>Completado</option>
                                <option value="cancelado" <?= $pedido['estado'] === 'cancelado' ? 'selected' : '' ?>>Cancelado</option>
                            </select>
                        </form>
                    </div>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php $content = ob_get_clean(); ?>
<?php require __DIR__ . '/layout.php'; ?>