<?php ob_start(); ?>
<h1 class="font-rpg" style="font-size:2.5rem; color:#fbbf24; margin-bottom:1rem;">
    Reseñas de "<?= htmlspecialchars($curso['titulo']) ?>"
</h1>

<!-- Estadísticas -->
<div class="grid-3" style="margin-bottom:2rem;">
    <div class="card text-center">
        <p style="font-size:2.5rem; color:#fbbf24; font-weight:700;"><?= number_format($media, 1) ?></p>
        <p class="card-text">Valoración media</p>
    </div>
    <div class="card text-center">
        <p style="font-size:2.5rem; color:#fbbf24; font-weight:700;"><?= $totalResenas ?></p>
        <p class="card-text">Total reseñas</p>
    </div>
</div>

<!-- Listado de reseñas -->
<?php if (!empty($resenas)): ?>
    <div style="display:flex; flex-direction:column; gap:1rem;">
        <?php foreach ($resenas as $resena): ?>
            <div class="card" style="padding:1rem;">
                <div style="display:flex; justify-content:space-between; align-items:start; margin-bottom:0.5rem;">
                    <span style="color:#fbbf24; font-weight:600;"><?= htmlspecialchars($resena['alumno_nombre']) ?></span>
                    <span style="color:#fbbf24;"><?= str_repeat('★', $resena['puntuacion']) ?><?= str_repeat('☆', 5 - $resena['puntuacion']) ?></span>
                </div>
                <?php if (!empty($resena['comentario'])): ?>
                    <p style="color:#cbd5e1; font-size:0.95rem;"><?= htmlspecialchars($resena['comentario']) ?></p>
                <?php endif; ?>
                <p style="color:#6b7280; font-size:0.8rem; margin-top:0.5rem;"><?= date('d/m/Y', strtotime($resena['fecha'])) ?></p>
                <div style="margin-top:0.5rem;">
                    <a href="/admin/resenas/eliminar/<?= $resena['id'] ?>?curso_id=<?= $curso['id'] ?>" 
                       class="btn btn-danger btn-sm" 
                       onclick="return confirm('¿Eliminar esta reseña?')">Eliminar</a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php else: ?>
    <div class="card text-center" style="padding:3rem;">
        <p style="color:#9ca3af;">Este curso aún no tiene reseñas.</p>
    </div>
<?php endif; ?>

<div style="margin-top:2rem;">
    <a href="/admin/cursos" class="btn btn-secondary">← Volver a cursos</a>
</div>
<?php $content = ob_get_clean(); ?>
<?php require __DIR__ . '/layout.php'; ?>