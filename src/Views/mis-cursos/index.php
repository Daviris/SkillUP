<?php ob_start(); ?>
<div style="max-width:1000px; margin:0 auto;">
    <h1 class="font-rpg" style="font-size:2.5rem; color:#fbbf24; margin-bottom:0.5rem;">
        📖 Mis Cursos
    </h1>
    <p style="color:#9ca3af; margin-bottom:2rem;">Cursos que has adquirido y puedes estudiar</p>

    <?php if (!empty($cursos)): ?>
        <div class="grid-3">
            <?php foreach ($cursos as $curso): ?>
                <div class="card" style="display:flex; flex-direction:column; justify-content:space-between;">
                    <div>
                        <h3 class="card-title"><?= htmlspecialchars($curso['titulo']) ?></h3>
                        <p class="card-text"><?= htmlspecialchars(substr($curso['descripcion'], 0, 100)) ?>...</p>
                        <p style="color:#9ca3af; font-size:0.9rem; margin-top:0.75rem;">
                            Instructor: <?= htmlspecialchars($curso['instructor_nombre'] ?? 'N/A') ?>
                        </p>
                    </div>
                    <a href="/mis-cursos/ver/<?= $curso['id'] ?>" class="btn btn-primary" style="margin-top:1.5rem; text-align:center;">
                        Ver clases
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="card" style="padding:3rem; text-align:center;">
            <p style="font-size:3rem; margin-bottom:1rem;">📭</p>
            <p style="color:#cbd5e1; font-size:1.2rem; margin-bottom:1rem;">Aún no has adquirido ningún curso.</p>
            <p style="color:#9ca3af; margin-bottom:2rem;">Explora el catálogo y encuentra conocimientos que subirán tu nivel.</p>
            <a href="/cursos" class="btn btn-primary">🔍 Explorar cursos</a>
        </div>
    <?php endif; ?>
</div>
<?php $content = ob_get_clean(); ?>
<?php require __DIR__ . '/../layouts/main.php'; ?>