<?php ob_start(); ?>
<div style="max-width:700px; margin:3rem auto;">
    <div class="fade-in-up card" style="padding:3rem 2rem; text-align:center;">
        <!-- Icono de éxito -->
        <div style="font-size:5rem; margin-bottom:1rem;"><i class="fa-solid fa-circle-check"></i></div>
        
        <h1 class="font-rpg" style="font-size:2.5rem; color:#fbbf24; margin-bottom:0.5rem;">
            ¡Misión Completada!
        </h1>
        <p style="color:#cbd5e1; font-size:1.1rem; margin-bottom:2rem;">
            Has adquirido nuevos conocimientos para tu aventura.
        </p>

        <!-- Detalles del pedido -->
        <div class="card" style="background:#0f172a; padding:1.5rem; margin-bottom:2rem; text-align:left; border:1px solid #334155;">
            <div style="display:flex; justify-content:space-between; margin-bottom:0.75rem;">
                <span style="color:#94a3b8;">Pedido #</span>
                <span style="color:#fbbf24; font-weight:700;"><?= $pedido['id'] ?></span>
            </div>
            <div style="display:flex; justify-content:space-between; margin-bottom:0.75rem;">
                <span style="color:#94a3b8;">Fecha</span>
                <span style="color:#e5e7eb;"><?= date('d/m/Y H:i', strtotime($pedido['fecha'])) ?></span>
            </div>
            <div style="display:flex; justify-content:space-between; margin-bottom:0.75rem;">
                <span style="color:#94a3b8;">Total</span>
                <span style="color:#fbbf24; font-weight:700; font-size:1.2rem;"><?= number_format($pedido['total'], 2) ?> €</span>
            </div>
            <div style="display:flex; justify-content:space-between;">
                <span style="color:#94a3b8;">Estado</span>
                <span class="badge" style="background:#065f46; color:white;"><?= $pedido['estado'] ?></span>
            </div>
        </div>

        <!-- Cursos adquiridos -->
        <h2 class="font-rpg" style="font-size:1.5rem; color:#fbbf24; margin-bottom:1rem; text-align:left;"><i class="fa-solid fa-book-open"></i> Cursos adquiridos</h2>
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

        <!-- Botones de acción -->
        <div style="display:flex; gap:1rem; justify-content:center; flex-wrap:wrap;">
            <a href="/cursos" class="btn btn-primary" style="background:linear-gradient(135deg, #b45309, #d97706); border:none; font-size:1.1rem; padding:0.8rem 2rem;">
                <i class="fa-solid fa-map"></i> Seguir explorando
            </a>
            <?php if (count($detalles) === 1): ?>
                <a href="/mis-cursos/ver/<?= $detalles[0]['curso_id'] ?>" class="btn btn-primary" style="background:linear-gradient(135deg, #065f46, #047857); border:none; font-size:1.1rem; padding:0.8rem 2rem;">
                    <i class="fa-solid fa-sword"></i> Ir a la misión
                </a>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $content = ob_get_clean(); ?>
<?php require __DIR__ . '/../layouts/main.php'; ?>