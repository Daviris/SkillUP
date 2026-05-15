<?php ob_start(); ?>
<div style="max-width:900px; margin:0 auto;">
    <!-- Migas de pan -->
    <div style="margin-bottom:1.5rem; color:#9ca3af; font-size:0.9rem;">
        <a href="/mis-cursos" style="color:#fbbf24;">Mis Cursos</a> /
        <a href="/mis-cursos/ver/<?= $curso['id'] ?>" style="color:#fbbf24;"><?= htmlspecialchars($curso['titulo']) ?></a> /
        <span style="color:#e5e7eb;"><?= htmlspecialchars($clase['titulo']) ?></span>
    </div>

    <!-- Cabecera de la clase -->
    <div class="card" style="padding:1.5rem; margin-bottom:2rem;">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:1rem;">
            <h1 class="font-rpg" style="font-size:2.2rem; color:#fbbf24;">
                <?= $clase['orden'] ?>. <?= htmlspecialchars($clase['titulo']) ?>
            </h1>
            <span class="badge badge-amber"><?= ucfirst($clase['tipo']) ?></span>
        </div>
        <p style="color:#9ca3af;">Duración: <?= $clase['duracion'] ?> minutos</p>
    </div>

    <!-- Contenido según tipo -->
    <?php if ($clase['tipo'] === 'teoria'): ?>
        <div class="card" style="padding:2rem;">
            <h2 class="font-rpg" style="font-size:1.5rem; color:#fbbf24; margin-bottom:1rem;">📖 Contenido teórico</h2>
            <div style="color:#e5e7eb; line-height:1.8;">
                <?= nl2br(htmlspecialchars($clase['contenido_texto'] ?? '')) ?>
            </div>
        </div>

    <?php elseif ($clase['tipo'] === 'archivo'): ?>
        <div class="card" style="padding:2rem;">
            <h2 class="font-rpg" style="font-size:1.5rem; color:#fbbf24; margin-bottom:1rem;">📄 Material de la clase</h2>
            <?php if (!empty($clase['archivo_id'])): ?>
                <div style="display:flex; align-items:center; justify-content:space-between; background:#111827; padding:1.5rem; border-radius:0.5rem; border:1px solid #374151;">
                    <div>
                        <p style="color:#e5e7eb; font-weight:600;">Archivo disponible</p>
                        <p style="color:#9ca3af; font-size:0.9rem;">Descarga el material para estudiar</p>
                    </div>
                    <a href="/archivo/descargar/<?= $clase['archivo_id'] ?>" class="btn btn-primary">
                        📥 Descargar
                    </a>
                </div>
            <?php else: ?>
                <p style="color:#9ca3af;">No hay archivo adjunto para esta clase.</p>
            <?php endif; ?>
        </div>

    <?php elseif ($clase['tipo'] === 'tarea'): ?>
        <?php $fechaLimite = strtotime($clase['fecha_limite'] ?? ''); $plazoVencido = $fechaLimite && $fechaLimite < time(); ?>

        <!-- Descripción de la tarea -->
        <div class="card" style="padding:2rem; margin-bottom:2rem;">
            <h2 class="font-rpg" style="font-size:1.5rem; color:#fbbf24; margin-bottom:1rem;">📝 Descripción de la tarea</h2>
            <?php if (!empty($clase['criterios_evaluacion'])): ?>
                <p style="color:#e5e7eb; line-height:1.6;"><?= nl2br(htmlspecialchars($clase['criterios_evaluacion'])) ?></p>
            <?php else: ?>
                <p style="color:#9ca3af;">El instructor no ha añadido criterios de evaluación.</p>
            <?php endif; ?>

            <?php if (!empty($clase['fecha_limite'])): ?>
                <div style="margin-top:1.5rem; padding:1rem; background:#111827; border-radius:0.5rem; border:1px solid <?= $plazoVencido ? '#7f1d1d' : '#065f46' ?>;">
                    <span style="color:#fbbf24;">Fecha límite:</span>
                    <span style="color:<?= $plazoVencido ? '#ef4444' : '#10b981' ?>; font-weight:700; margin-left:0.5rem;">
                        <?= date('d/m/Y H:i', $fechaLimite) ?>
                    </span>
                    <?php if ($plazoVencido): ?>
                        <span class="badge badge-red" style="margin-left:0.5rem;">Vencido</span>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- Estado de la entrega -->
        <?php if ($entrega): ?>
            <div class="card" style="padding:2rem; border-color:#10b981;">
                <h2 class="font-rpg" style="font-size:1.5rem; color:#10b981; margin-bottom:1rem;">✅ Tu entrega</h2>
                <p style="color:#e5e7eb;">Entregado el <?= date('d/m/Y H:i', strtotime($entrega['fecha_entrega'])) ?></p>
                <?php if (!empty($entrega['archivo_id'])): ?>
                    <a href="/archivo/descargar/<?= $entrega['archivo_id'] ?>" class="btn btn-secondary" style="margin-top:0.5rem;">📎 Ver archivo subido</a>
                <?php endif; ?>

                <?php if ($entrega['nota'] !== null): ?>
                    <div style="margin-top:1.5rem; padding:1rem; background:#111827; border-radius:0.5rem; border:1px solid #fbbf24;">
                        <p style="color:#fbbf24; font-weight:700;">Nota: <?= $entrega['nota'] ?>/10</p>
                        <?php if ($entrega['feedback_instructor']): ?>
                            <p style="color:#e5e7eb; margin-top:0.5rem;">Feedback: <?= htmlspecialchars($entrega['feedback_instructor']) ?></p>
                        <?php endif; ?>
                    </div>
                <?php else: ?>
                    <div style="display:flex; gap:1rem; margin-top:1.5rem;">
                        <a href="/tarea/editar/<?= $entrega['id'] ?>" class="btn btn-primary btn-sm">✏️ Modificar</a>
                        <a href="/tarea/eliminar/<?= $entrega['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar esta entrega?')">🗑️ Eliminar</a>
                    </div>
                <?php endif; ?>
            </div>
        <?php else: ?>
            <?php if (!$plazoVencido): ?>
                <div class="card" style="padding:2rem;">
                    <h2 class="font-rpg" style="font-size:1.5rem; color:#fbbf24; margin-bottom:1rem;">📤 Subir entrega</h2>
                    <form action="/archivo/subir" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="clase_id" value="<?= $clase['id'] ?>">
                        <div class="form-group">
                            <label class="form-label">Selecciona un archivo</label>
                            <input type="file" name="archivo" class="form-input" required>
                        </div>
                        <button type="submit" class="btn btn-primary">📤 Enviar tarea</button>
                    </form>
                </div>
            <?php else: ?>
                <div class="card" style="padding:2rem; border-color:#7f1d1d;">
                    <p style="color:#ef4444; font-weight:700;">El plazo de entrega ha finalizado.</p>
                    <p style="color:#cbd5e1; margin-top:0.5rem;">No puedes enviar esta tarea porque la fecha límite ya pasó.</p>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    <?php endif; ?>

    <div style="margin-top:2rem;">
        <a href="/mis-cursos/ver/<?= $curso['id'] ?>" style="color:#fbbf24;">← Volver al curso</a>
    </div>
</div>
<?php $content = ob_get_clean(); ?>
<?php require __DIR__ . '/../layouts/main.php'; ?>