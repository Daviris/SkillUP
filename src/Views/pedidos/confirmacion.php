<?php ob_start(); ?>
<div style="max-width:700px; margin:3rem auto; text-align:center;">
    <div class="card" style="padding:3rem 2rem;">
        <p style="font-size:4rem; margin-bottom:1rem;">✅</p>
        <h1 class="font-rpg" style="font-size:2.5rem; color:#fbbf24; margin-bottom:0.5rem;">
            ¡Misión completada!
        </h1>
        <p style="color:#cbd5e1; font-size:1.1rem; margin-bottom:2rem;">
            Has adquirido nuevos conocimientos.
        </p>

        <div class="card" style="background:#111827; padding:1.5rem; margin-bottom:2rem; text-align:left;">
            <div style="display:flex; justify-content:space-between; margin-bottom:1rem;">
                <span style="color:#9ca3af;">Pedido #</span>
                <span style="color:#fbbf24; font-weight:700;"><?= $pedido['id'] ?></span>
            </div>
            <div style="display:flex; justify-content:space-between; margin-bottom:1rem;">
                <span style="color:#9ca3af;">Fecha</span>
                <span style="color:#e5e7eb;"><?= date('d/m/Y H:i', strtotime($pedido['fecha'])) ?></span>
            </div>
            <div style="display:flex; justify-content:space-between; margin-bottom:1rem;">
                <span style="color:#9ca3af;">Total</span>
                <span style="color:#fbbf24; font-weight:700; font-size:1.2rem;"><?= number_format($pedido['total'], 2) ?> €</span>
            </div>
            <div style="display:flex; justify-content:space-between;">
                <span style="color:#9ca3af;">Estado</span>
                <span class="badge badge-green"><?= $pedido['estado'] ?></span>
            </div>
        </div>

        <h2 class="font-rpg" style="font-size:1.5rem; color:#fbbf24; margin-bottom:1rem;">Cursos adquiridos</h2>
        <div class="table-container" style="margin-bottom:2rem;">
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
                        <td style="color:#e5e7eb;"><?= htmlspecialchars($detalle['titulo']) ?></td>
                        <td style="color:#fbbf24;"><?= number_format($detalle['precio'], 2) ?> €</td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <a href="/cursos" class="btn btn-primary" style="font-size:1.1rem;">🔍 Seguir explorando</a>
    </div>
</div>
<?php $content = ob_get_clean(); ?>
<?php require __DIR__ . '/../layouts/main.php'; ?>