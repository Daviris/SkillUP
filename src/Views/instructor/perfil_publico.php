<?php ob_start(); ?>
<div style="max-width:1100px; margin:0 auto;">
    <!-- Cabecera del instructor -->
    <div class="fade-in-up card" style="padding:2.5rem; margin-bottom:2rem; background:linear-gradient(135deg, #1e293b, #0f172a); border:2px solid #b45309; position:relative; overflow:hidden;">
        <div style="position:absolute; top:0; left:0; right:0; bottom:0; background:radial-gradient(circle at 30% 20%, rgba(251,191,36,0.08) 0%, transparent 60%); pointer-events:none;"></div>
        <div style="position:relative; z-index:2; display:flex; align-items:center; gap:2rem; flex-wrap:wrap;">
            <!-- Avatar -->
            <div style="font-size:5rem;">🧙</div>
            <div style="flex:1; min-width:250px;">
                <h1 class="font-rpg" style="font-size:2.8rem; color:#fbbf24; margin-bottom:0.5rem; text-shadow:0 0 15px rgba(251,191,36,0.4);">
                    <?= htmlspecialchars($instructor['nombre']) ?>
                </h1>
                <div style="display:flex; align-items:center; gap:1rem; color:#94a3b8; font-size:1rem; margin-bottom:0.5rem;">
                    <span>Maestro</span>
                </div>
                <!-- Reputación -->
                <div style="display:flex; align-items:center; gap:0.5rem; margin-bottom:0.25rem;">
                    <span style="color:#fbbf24; font-size:1.5rem;">
                        <?= str_repeat('★', (int) round($reputacion)) ?><?= str_repeat('☆', 5 - (int) round($reputacion)) ?>
                    </span>
                    <span style="color:#cbd5e1; font-size:1.1rem; font-weight:600;"><?= number_format($reputacion, 1) ?> / 5</span>
                </div>
                <p style="color:#94a3b8; font-size:0.9rem;">
                    <?= $totalResenas ?> reseñas recibidas · <?= count($cursos) ?> cursos publicados
                </p>
            </div>
            <!-- Estadísticas rápidas -->
            <div style="display:flex; gap:2rem;">
                <div style="text-align:center;">
                    <div style="font-size:2.5rem; color:#fbbf24; font-weight:bold;"><?= count($cursos) ?></div>
                    <div style="color:#94a3b8; font-size:0.9rem;">Cursos</div>
                </div>
                <div style="text-align:center;">
                    <div style="font-size:2.5rem; color:#fbbf24; font-weight:bold;"><?= $totalResenas ?></div>
                    <div style="color:#94a3b8; font-size:0.9rem;">Reseñas</div>
                </div>
                <div style="text-align:center;">
                    <div style="font-size:2.5rem; color:#fbbf24; font-weight:bold;"><?= number_format($reputacion, 1) ?></div>
                    <div style="color:#94a3b8; font-size:0.9rem;">Estrellas</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Cursos publicados -->
    <div class="fade-in-up" style="transition-delay:0.2s;">
        <h2 class="font-rpg" style="font-size:2rem; color:#fbbf24; margin-bottom:1.5rem;">📚 Cursos publicados</h2>
        <?php if (!empty($cursos)): ?>
            <div style="display:grid; grid-template-columns:repeat(3, 1fr); gap:1.5rem;">
                <?php foreach ($cursos as $curso): ?>
                    <div class="card" style="display:flex; flex-direction:column; justify-content:space-between; background:linear-gradient(135deg, #1e293b, #0f172a); border:1px solid #334155; transition:transform 0.2s, box-shadow 0.2s;">
                        <div style="padding:1.5rem; flex:1;">
                            <div style="display:flex; align-items:center; gap:0.5rem; margin-bottom:0.75rem;">
                                <span class="badge" style="background:<?= $curso['modalidad'] === 'online' ? '#065f46' : '#7f1d1d' ?>; color:white; font-size:0.7rem;">
                                    <?= $curso['modalidad'] === 'online' ? '🌐 Online' : '🏰 Presencial' ?>
                                </span>
                            </div>
                            <h3 class="card-title" style="font-size:1.2rem; margin-bottom:0.5rem;"><?= htmlspecialchars($curso['titulo']) ?></h3>
                            <p style="color:#94a3b8; font-size:0.9rem; line-height:1.4; margin-bottom:0.5rem;">
                                <?= htmlspecialchars(substr($curso['descripcion'], 0, 100)) ?>...
                            </p>
                            <div style="font-size:1.3rem; font-weight:bold; color:#fbbf24; margin-top:auto;">
                                <?= number_format($curso['precio'], 2) ?> €
                            </div>
                        </div>
                        <div style="border-top:1px solid #334155; padding:1rem;">
                            <a href="/cursos/<?= $curso['id'] ?>" class="btn btn-primary" style="width:100%; background:linear-gradient(135deg, #b45309, #d97706); border:none; text-align:center;">
                                Ver misión →
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="card" style="padding:3rem; text-align:center;">
                <p style="font-size:3rem; margin-bottom:1rem;">📭</p>
                <p style="color:#cbd5e1; font-size:1.1rem;">Este instructor aún no ha publicado cursos.</p>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php $content = ob_get_clean(); ?>
<?php require __DIR__ . '/../layouts/main.php'; ?>