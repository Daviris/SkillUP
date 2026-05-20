<?php ob_start(); ?>
<div class="fade-in-up" style="margin-bottom:2rem;">
    <h1 class="font-rpg" style="font-size:2.5rem; color:#fbbf24; margin-bottom:0.5rem; text-shadow:0 0 15px rgba(251,191,36,0.4);">
        📚 Cursos de <?= htmlspecialchars($usuario['nombre']) ?>
    </h1>
    <p style="color:#94a3b8; font-size:1.1rem;">Cursos en los que está matriculado</p>
</div>

<div class="card" style="padding:1.5rem; margin-bottom:2rem;">
    <div style="display:flex; align-items:center; gap:1rem;">
        <span style="font-size:2rem;">👤</span>
        <div>
            <p style="color:#fbbf24; font-weight:600;"><?= htmlspecialchars($usuario['nombre']) ?></p>
            <p style="color:#94a3b8;"><?= htmlspecialchars($usuario['email']) ?></p>
        </div>
    </div>
</div>

<?php if (!empty($cursos)): ?>
    <div class="table-container">
        <table style="width:100%;">
            <thead>
                <tr>
                    <th>Curso</th>
                    <th>Precio</th>
                    <th>Estado del pedido</th>
                    <th style="text-align:right;">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cursos as $curso): ?>
                <tr>
                    <td style="color:#fbbf24;"><?= htmlspecialchars($curso['titulo']) ?></td>
                    <td><?= number_format($curso['precio'], 2) ?> €</td>
                    <td>
                        <span class="badge <?= $curso['estado'] === 'completado' ? 'badge-exito' : 'badge-peligro' ?>">
                            <?= $curso['estado'] ?>
                        </span>
                    </td>
                    <td style="text-align:right;">
                        <?php if ($curso['estado'] === 'completado'): ?>
                            <a href="/admin/pedidos/revocar/<?= $curso['pedido_id'] ?>" 
                               class="btn btn-danger btn-sm" 
                               onclick="return confirm('¿Revocar el acceso a este curso?')">
                                🚫 Revocar
                            </a>
                        <?php else: ?>
                            <span style="color:#94a3b8;">Ya cancelado</span>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php else: ?>
    <div class="card" style="padding:3rem; text-align:center;">
        <p style="color:#cbd5e1;">Este alumno no está matriculado en ningún curso.</p>
    </div>
<?php endif; ?>

<div style="margin-top:2rem;">
    <a href="/admin/usuarios" class="btn btn-secondary">← Volver a usuarios</a>
</div>
<?php $content = ob_get_clean(); ?>
<?php require __DIR__ . '/layout.php'; ?>