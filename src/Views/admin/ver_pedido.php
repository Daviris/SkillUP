<?php ob_start(); ?>
<h1 class="font-rpg" style="font-size:2.5rem; color:#fbbf24; margin-bottom:2rem;">
    Pedido #<?= $pedido['id'] ?>
</h1>

<!-- Datos del cliente -->
<div class="card" style="margin-bottom:2rem; padding:1.5rem;">
    <h2 class="font-rpg" style="font-size:1.5rem; color:#fbbf24; margin-bottom:1rem;">Cliente</h2>
    <div style="display:grid; grid-template-columns:1fr 1fr; gap:1rem; color:#e5e7eb;">
        <div>
            <span style="color:#fbbf24;">Nombre:</span>
            <?= htmlspecialchars($pedido['usuario_nombre'] ?? 'Desconocido') ?>
        </div>
        <div>
            <span style="color:#fbbf24;">Email:</span>
            <?= htmlspecialchars($pedido['usuario_email'] ?? 'No disponible') ?>
        </div>
    </div>
</div>

<!-- Resumen del pedido -->
<div class="card" style="margin-bottom:2rem; padding:1.5rem;">
    <h2 class="font-rpg" style="font-size:1.5rem; color:#fbbf24; margin-bottom:1rem;">Resumen del pedido</h2>
    <div style="display:grid; grid-template-columns:1fr 1fr; gap:1rem; color:#e5e7eb; margin-bottom:1.5rem;">
        <div>
            <span style="color:#fbbf24;">Fecha:</span>
            <?= date('d/m/Y H:i', strtotime($pedido['fecha'])) ?>
        </div>
        <div>
            <span style="color:#fbbf24;">Estado:</span>
            <span class="badge <?= $pedido['estado'] === 'completado' ? 'badge-green' : ($pedido['estado'] === 'cancelado' ? 'badge-red' : 'badge-amber') ?>">
                <?= $pedido['estado'] ?>
            </span>
        </div>
        <div>
            <span style="color:#fbbf24;">Total:</span>
            <span style="color:#fbbf24; font-weight:700; font-size:1.2rem;"><?= number_format($pedido['total'], 2) ?> €</span>
        </div>
    </div>

    <h3 style="color:#fbbf24; margin-bottom:0.5rem;">Cursos adquiridos</h3>
    <div class="table-container">
        <table style="width:100%;">
            <thead>
                <tr>
                    <th>Curso</th>
                    <th>Precio</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($detalles as $detalle): ?>
                <tr>
                    <td><?= htmlspecialchars($detalle['titulo']) ?></td>
                    <td style="color:#fbbf24;"><?= number_format($detalle['precio'], 2) ?> €</td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<div style="margin-top:2rem;">
    <a href="/admin/pedidos" class="btn btn-secondary">← Volver a pedidos</a>
</div>
<?php $content = ob_get_clean(); ?>
<?php require __DIR__ . '/layout.php'; ?>