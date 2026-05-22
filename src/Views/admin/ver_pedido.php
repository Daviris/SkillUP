<?php ob_start(); ?>
<div class="fade-in-up" style="margin-bottom:2rem;">
    <h1 class="font-rpg" style="font-size:2.5rem; color:#fbbf24; margin-bottom:0.5rem; text-shadow:0 0 15px rgba(251,191,36,0.4);">
        <i class="fa-solid fa-magnifying-glass"></i> Pedido #<?= $pedido['id'] ?>
    </h1>
    <p style="color:#94a3b8; font-size:1.1rem;">Detalle completo de la transacción</p>
</div>

<!-- Datos del cliente -->
<div class="card" style="padding:1.5rem; margin-bottom:1.5rem; background:linear-gradient(135deg, #1e293b, #0f172a); border:1px solid #334155;">
    <h2 class="font-rpg" style="font-size:1.5rem; color:#fbbf24; margin-bottom:1rem;"><i class="fa-solid fa-circle-user"></i> Cliente</h2>
    <div style="display:grid; grid-template-columns:1fr 1fr; gap:1rem; color:#e5e7eb;">
        <div>
            <span style="color:#fbbf24;">Nombre:</span>
            <?= htmlspecialchars($pedido['usuario_nombre'] ?? 'No disponible') ?>
        </div>
        <div>
            <span style="color:#fbbf24;">Email:</span>
            <?= htmlspecialchars($pedido['usuario_email'] ?? 'No disponible') ?>
        </div>
    </div>
</div>

<!-- Resumen del pedido -->
<div class="card" style="padding:1.5rem; margin-bottom:1.5rem; background:linear-gradient(135deg, #1e293b, #0f172a); border:1px solid #334155;">
    <h2 class="font-rpg" style="font-size:1.5rem; color:#fbbf24; margin-bottom:1rem;"><i class="fa-solid fa-clipboard-list"></i> Resumen del pedido</h2>
    <div style="display:grid; grid-template-columns:1fr 1fr; gap:1rem; color:#e5e7eb; margin-bottom:1rem;">
        <div>
            <span style="color:#fbbf24;">Fecha:</span>
            <?= date('d/m/Y H:i', strtotime($pedido['fecha'])) ?>
        </div>
        <div>
            <span style="color:#fbbf24;">Estado:</span>
            <span class="badge <?= $pedido['estado'] === 'completado' ? 'badge-exito' : ($pedido['estado'] === 'cancelado' ? 'badge-peligro' : 'badge-primario') ?>">
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
                    <th>Cantidad</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($detalles as $detalle): ?>
                <tr>
                    <td><?= htmlspecialchars($detalle['titulo']) ?></td>
                    <td style="color:#fbbf24;"><?= number_format($detalle['precio'], 2) ?> €</td>
                    <td><?= $detalle['cantidad'] ?></td>
                    <td style="color:#fbbf24;"><?= number_format($detalle['precio'] * $detalle['cantidad'], 2) ?> €</td>
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