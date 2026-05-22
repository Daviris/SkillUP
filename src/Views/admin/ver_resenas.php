<?php ob_start(); ?>
<div class="fade-in-up" style="margin-bottom:2rem;">
    <h1 class="font-rpg" style="font-size:2.5rem; color:#fbbf24; margin-bottom:0.5rem; text-shadow:0 0 15px rgba(251,191,36,0.4);">
        <i class="fa-solid fa-star"></i> Reseñas de "<?= htmlspecialchars($curso['titulo']) ?>"
    </h1>
    <p style="color:#94a3b8; font-size:1.1rem;">Valoraciones de los aventureros sobre esta misión</p>
</div>

<!-- Estadísticas -->
<div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(150px, 1fr)); gap:1rem; margin-bottom:2rem;">
    <div class="card text-center" style="padding:1.5rem; background:linear-gradient(135deg, #1e293b, #0f172a); border:1px solid #334155;">
        <div style="font-size:2rem; color:#fbbf24; font-weight:bold;"><?= number_format($media, 1) ?> ★</div>
        <div style="color:#94a3b8; font-size:0.9rem;">Valoración media</div>
    </div>
    <div class="card text-center" style="padding:1.5rem; background:linear-gradient(135deg, #1e293b, #0f172a); border:1px solid #334155;">
        <div style="font-size:2rem; color:#fbbf24; font-weight:bold;"><?= $totalResenas ?></div>
        <div style="color:#94a3b8; font-size:0.9rem;">Total reseñas</div>
    </div>
</div>

<!-- Listado de reseñas -->
<?php if (!empty($resenas)): ?>
    <div style="display:grid; gap:1rem;">
        <?php foreach ($resenas as $resena): ?>
            <div class="card" style="padding:1.5rem; background:linear-gradient(135deg, #1e293b, #0f172a); border:1px solid #334155;">
                <div style="display:flex; justify-content:space-between; align-items:start; flex-wrap:wrap; gap:1rem;">
                    <div style="flex:1; min-width:200px;">
                        <div style="display:flex; align-items:center; gap:0.5rem; margin-bottom:0.5rem;">
                            <span style="font-size:1.5rem;"><i class="fa-solid fa-user-graduate"></i></span>
                            <span style="color:#fbbf24; font-weight:600;"><?= htmlspecialchars($resena['alumno_nombre']) ?></span>
                        </div>
                        <div style="color:#fbbf24; font-size:1.1rem; margin-bottom:0.5rem;">
                            <?= str_repeat('★', $resena['puntuacion']) ?><?= str_repeat('☆', 5 - $resena['puntuacion']) ?>
                        </div>
                        <?php if (!empty($resena['comentario'])): ?>
                            <p style="color:#cbd5e1; font-size:0.95rem; line-height:1.5;"><?= htmlspecialchars($resena['comentario']) ?></p>
                        <?php endif; ?>
                        <p style="color:#6b7280; font-size:0.8rem; margin-top:0.5rem;"><?= date('d/m/Y', strtotime($resena['fecha'])) ?></p>
                    </div>
                    <div>
                        <a href="/admin/resenas/eliminar/<?= $resena['id'] ?>?curso_id=<?= $curso['id'] ?>" 
                           class="btn btn-danger btn-sm" 
                           onclick="return confirm('¿Eliminar esta reseña?')">
                            <i class="fa-solid fa-trash-can"></i> Eliminar
                        </a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php else: ?>
    <div class="card" style="padding:3rem; text-align:center;">
        <p style="font-size:3rem; margin-bottom:1rem;">	<i class="fa-solid fa-inbox"></i></p>
        <p style="color:#cbd5e1; font-size:1.1rem;">Este curso aún no tiene reseñas.</p>
    </div>
<?php endif; ?>

<div style="margin-top:2rem;">
    <a href="/admin/cursos" class="btn btn-secondary">← Volver a cursos</a>
</div>
<?php $content = ob_get_clean(); ?>
<?php require __DIR__ . '/layout.php'; ?>