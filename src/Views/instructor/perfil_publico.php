<?php ob_start(); ?>
<div style="max-width:900px; margin:0 auto;">
    <div class="card" style="padding:2rem; margin-bottom:2rem;">
        <div style="display:flex; align-items:center; gap:2rem;">
            <div style="font-size:5rem;">🧙</div>
            <div>
                <h1 class="font-rpg" style="font-size:2.5rem; color:#fbbf24; margin-bottom:0.5rem;">
                    <?= htmlspecialchars($instructor['nombre']) ?>
                </h1>
                <div style="color:#fbbf24; font-size:1.2rem; margin-bottom:0.5rem;">
                    <?= str_repeat('★', (int) round($reputacion)) ?><?= str_repeat('☆', 5 - (int) round($reputacion)) ?>
                    <span style="color:#cbd5e1; margin-left:0.5rem;"><?= number_format($reputacion, 1) ?> / 5</span>
                </div>
                <p style="color:#9ca3af;"><?= count($cursos) ?> cursos publicados · <?= $totalResenas ?> reseñas recibidas</p>
            </div>
        </div>
    </div>

    <h2 class="font-rpg" style="font-size:2rem; color:#fbbf24; margin-bottom:1.5rem;">Cursos publicados</h2>
    <?php if (!empty($cursos)): ?>
        <div class="grid-3">
            <?php foreach ($cursos as $curso): ?>
                <div class="card" style="display:flex; flex-direction:column; justify-content:space-between;">
                    <div>
                        <h3 class="card-title"><?= htmlspecialchars($curso['titulo']) ?></h3>
                        <p class="card-text"><?= htmlspecialchars(substr($curso['descripcion'], 0, 100)) ?>...</p>
                    </div>
                    <div style="margin-top:1rem;">
                        <span class="badge badge-amber"><?= ucfirst($curso['modalidad']) ?></span>
                        <span style="color:#fbbf24; font-weight:bold; margin-left:0.5rem;"><?= number_format($curso['precio'], 2) ?> €</span>
                    </div>
                    <a href="/cursos/<?= $curso['id'] ?>" class="btn btn-primary btn-sm" style="margin-top:1rem;">Ver curso</a>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p style="color:#9ca3af;">Este instructor aún no ha publicado cursos.</p>
    <?php endif; ?>
</div>
<?php $content = ob_get_clean(); ?>
<?php require __DIR__ . '/../layouts/main.php'; ?>