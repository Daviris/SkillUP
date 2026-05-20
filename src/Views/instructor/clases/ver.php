<?php ob_start(); ?>
<div style="max-width:900px; margin:0 auto;">
    <!-- Migas de pan -->
    <div class="fade-in-up" style="margin-bottom:1.5rem; color:#94a3b8; font-size:0.9rem;">
        <a href="/instructor" style="color:#fbbf24;">🧙 Panel Instructor</a> /
        <a href="/instructor/cursos/<?= $clase['curso_id'] ?>/clases" style="color:#fbbf24;">Clases</a> /
        <span style="color:#e5e7eb;"><?= htmlspecialchars($clase['titulo']) ?></span>
    </div>

    <!-- Cabecera de la clase -->
    <div class="fade-in-up card" style="padding:2rem; margin-bottom:2rem; background:linear-gradient(135deg, #1e293b, #0f172a); border:2px solid #b45309;">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:1rem;">
            <h1 class="font-rpg" style="font-size:2.2rem; color:#fbbf24;">
                <?= $clase['orden'] ?>. <?= htmlspecialchars($clase['titulo']) ?>
            </h1>
            <div style="display:flex; gap:0.75rem; align-items:center;">
                <span class="badge" style="background:<?= $clase['tipo'] === 'teoria' ? '#065f46' : ($clase['tipo'] === 'tarea' ? '#7f1d1d' : '#b45309') ?>; color:white; font-size:0.8rem;">
                    <?= ucfirst($clase['tipo']) ?>
                </span>
                <span style="color:#94a3b8; font-size:0.9rem;"><?= $clase['duracion'] ?> min</span>
            </div>
        </div>
        <p style="color:#94a3b8; font-size:0.9rem;">Curso: <?= htmlspecialchars($curso['titulo'] ?? '') ?></p>
    </div>

    <!-- Contenido según tipo de clase -->
    <?php if ($clase['tipo'] === 'teoria'): ?>
        <div class="fade-in-up card" style="padding:2rem;">
            <h2 class="font-rpg" style="font-size:1.5rem; color:#fbbf24; margin-bottom:1rem;">📖 Contenido teórico</h2>
            <div style="color:#e5e7eb; line-height:1.8;">
                <?= nl2br(htmlspecialchars($clase['contenido_texto'] ?? '')) ?>
            </div>
        </div>

    <?php elseif ($clase['tipo'] === 'archivo'): ?>
        <div class="fade-in-up card" style="padding:2rem;">
            <h2 class="font-rpg" style="font-size:1.5rem; color:#fbbf24; margin-bottom:1rem;">📄 Material de la clase</h2>
            <?php if (!empty($clase['archivo_id'])): ?>
                <div style="display:flex; align-items:center; justify-content:space-between; background:#0f172a; padding:1.5rem; border-radius:0.75rem; border:1px solid #334155;">
                    <div>
                        <p style="color:#e5e7eb; font-weight:600; margin-bottom:0.25rem;">Archivo subido</p>
                        <p style="color:#94a3b8; font-size:0.9rem;">Los alumnos podrán descargarlo</p>
                    </div>
                    <a href="/archivo/descargar/<?= $clase['archivo_id'] ?>" class="btn btn-primary" style="background:linear-gradient(135deg, #b45309, #d97706); border:none;">
                        📥 Descargar
                    </a>
                </div>
            <?php else: ?>
                <p style="color:#94a3b8;">No hay archivo adjunto en esta clase.</p>
            <?php endif; ?>
        </div>

    <?php elseif ($clase['tipo'] === 'tarea'): ?>
        <div class="fade-in-up card" style="padding:2rem; margin-bottom:2rem;">
            <h2 class="font-rpg" style="font-size:1.5rem; color:#fbbf24; margin-bottom:1rem;">📝 Descripción de la tarea</h2>
            <?php if (!empty($clase['criterios_evaluacion'])): ?>
                <p style="color:#e5e7eb; line-height:1.6;"><?= nl2br(htmlspecialchars($clase['criterios_evaluacion'])) ?></p>
            <?php else: ?>
                <p style="color:#94a3b8;">No se han definido criterios de evaluación.</p>
            <?php endif; ?>

            <?php if (!empty($clase['fecha_limite'])): ?>
                <div style="margin-top:1.5rem; padding:1rem; background:#0f172a; border-radius:0.5rem; border:1px solid #334155;">
                    <p style="color:#94a3b8; margin-bottom:0.25rem;">Fecha límite</p>
                    <p style="color:#fbbf24; font-weight:bold; font-size:1.1rem;">
                        <?= date('d/m/Y H:i', strtotime($clase['fecha_limite'])) ?>
                    </p>
                </div>
            <?php endif; ?>
        </div>

        <!-- Botón para ver entregas -->
        <div class="fade-in-up" style="text-align:center; margin-bottom:2rem;">
            <a href="/instructor/clases/<?= $clase['id'] ?>/entregas" class="btn btn-primary" style="background:linear-gradient(135deg, #b45309, #d97706); border:none; padding:0.8rem 2.5rem; font-size:1.1rem;">
                📋 Ver entregas de alumnos
            </a>
        </div>
    <?php endif; ?>

    <div style="margin-top:2rem;">
        <a href="/instructor/cursos/<?= $clase['curso_id'] ?>/clases" class="btn btn-secondary">← Volver a clases</a>
    </div>
</div>
<?php $content = ob_get_clean(); ?>
<?php require __DIR__ . '/../../layouts/main.php'; ?>