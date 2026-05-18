<?php ob_start(); ?>
<div style="max-width:900px; margin:0 auto;">
    <!-- Cabecera y migas de pan -->
    <div style="margin-bottom:1.5rem; color:#9ca3af; font-size:0.9rem;">
        <a href="/instructor" style="color:#fbbf24;">Panel Instructor</a> /
        <a href="/instructor/cursos/<?= $clase['curso_id'] ?>/clases" style="color:#fbbf24;">Clases</a> /
        <span style="color:#e5e7eb;"><?= htmlspecialchars($clase['titulo']) ?></span>
    </div>

    <!-- Tarjeta principal -->
    <div class="card" style="padding:2rem; margin-bottom:2rem;">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:1.5rem;">
            <h1 class="font-rpg" style="font-size:2.2rem; color:#fbbf24;">
                <?= $clase['orden'] ?>. <?= htmlspecialchars($clase['titulo']) ?>
            </h1>
            <span class="badge badge-amber"><?= ucfirst($clase['tipo']) ?></span>
        </div>

        <?php if ($clase['tipo'] === 'teoria'): ?>
            <div style="color:#e5e7eb; line-height:1.8;">
                <?= nl2br(htmlspecialchars($clase['contenido_texto'] ?? '')) ?>
            </div>

        <?php elseif ($clase['tipo'] === 'archivo'): ?>
            <?php if (!empty($clase['archivo_id'])): ?>
                <div style="display:flex; align-items:center; justify-content:space-between; background:#111827; padding:1.5rem; border-radius:0.5rem; border:1px solid #374151;">
                    <div>
                        <p style="color:#e5e7eb; font-weight:600;">Material de la clase</p>
                        <p style="color:#9ca3af; font-size:0.9rem;">Archivo subido</p>
                    </div>
                    <a href="/archivo/descargar/<?= $clase['archivo_id'] ?>" class="btn btn-primary">📥 Descargar</a>
                </div>
            <?php else: ?>
                <p style="color:#9ca3af;">No hay archivo adjunto.</p>
            <?php endif; ?>

        <?php elseif ($clase['tipo'] === 'tarea'): ?>
            <div style="background:#111827; border:1px solid #374151; border-radius:0.5rem; padding:1.5rem; margin-bottom:1.5rem;">
                <h3 style="color:#fbbf24; font-weight:600; margin-bottom:0.5rem;">Criterios de evaluación</h3>
                <p style="color:#e5e7eb;"><?= nl2br(htmlspecialchars($clase['criterios_evaluacion'] ?? 'Sin criterios definidos.')) ?></p>
                <?php if (!empty($clase['fecha_limite'])): ?>
                    <p style="color:#ef4444; margin-top:1rem;">
                        <strong>Fecha límite:</strong> <?= date('d/m/Y H:i', strtotime($clase['fecha_limite'])) ?>
                    </p>
                <?php endif; ?>
            </div>
            <a href="/instructor/clases/<?= $clase['id'] ?>/entregas" class="btn btn-primary">
                📋 Ver entregas de alumnos
            </a>
        <?php endif; ?>
    </div>

    <!-- Botón volver -->
    <a href="/instructor/cursos/<?= $clase['curso_id'] ?>/clases" style="color:#fbbf24;">← Volver a la lista de clases</a>
</div>
<?php $content = ob_get_clean(); ?>
<?php require __DIR__ . '/../../layouts/main.php'; ?>