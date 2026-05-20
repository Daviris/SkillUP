<?php ob_start(); ?>
<div style="max-width:900px; margin:0 auto;">
    <!-- Migas de pan -->
    <div class="fade-in-up" style="margin-bottom:1.5rem; color:#94a3b8; font-size:0.9rem;">
        <a href="/mis-cursos" style="color:#fbbf24;">📖 Mis Cursos</a> /
        <a href="/mis-cursos/ver/<?= $curso['id'] ?>" style="color:#fbbf24;"><?= htmlspecialchars($curso['titulo']) ?></a> /
        <span style="color:#e5e7eb;"><?= htmlspecialchars($clase['titulo']) ?></span>
    </div>

    <!-- Cabecera de la clase -->
    <div class="fade-in-up card" style="padding:2rem; margin-bottom:2rem; background:linear-gradient(135deg, #1e293b, #0f172a); border:2px solid #b45309;">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:1rem;">
            <h1 class="font-rpg" style="font-size:2.2rem; color:#fbbf24;">
                <?= $clase['orden'] ?>. <?= htmlspecialchars($clase['titulo']) ?>
            </h1>
            <div style="display:flex; gap:0.75rem; align-items:center;">
                <span class="badge" style="background:<?= $clase['tipo'] === 'teoria' ? '#065f46' : ($clase['tipo'] === 'tarea' ? '#7f1d1d' : '#b45309') ?>; font-size:0.8rem;">
                    <?= ucfirst($clase['tipo']) ?>
                </span>
                <span style="color:#94a3b8; font-size:0.9rem;"><?= $clase['duracion'] ?> min</span>
            </div>
        </div>
        <p style="color:#94a3b8; font-size:0.9rem;"><?= $curso['modalidad'] === 'online' ? '🌐 Online' : '🏰 Presencial' ?></p>
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
                        <p style="color:#e5e7eb; font-weight:600; margin-bottom:0.25rem;">Archivo disponible</p>
                        <p style="color:#94a3b8; font-size:0.9rem;">Descarga el material para estudiar</p>
                    </div>
                    <a href="/archivo/descargar/<?= $clase['archivo_id'] ?>" class="btn btn-primary" style="background:linear-gradient(135deg, #b45309, #d97706); border:none;">
                        📥 Descargar
                    </a>
                </div>
            <?php else: ?>
                <p style="color:#94a3b8;">No hay archivo adjunto para esta clase.</p>
            <?php endif; ?>
        </div>

    <?php elseif ($clase['tipo'] === 'tarea'): ?>
        <?php $fechaLimite = strtotime($clase['fecha_limite'] ?? ''); $plazoVencido = $fechaLimite && $fechaLimite < time(); ?>

        <!-- Descripción de la tarea -->
        <div class="fade-in-up card" style="padding:2rem; margin-bottom:2rem;">
            <h2 class="font-rpg" style="font-size:1.5rem; color:#fbbf24; margin-bottom:1rem;">📝 Descripción de la tarea</h2>
            <?php if (!empty($clase['criterios_evaluacion'])): ?>
                <p style="color:#e5e7eb; line-height:1.6;"><?= nl2br(htmlspecialchars($clase['criterios_evaluacion'])) ?></p>
            <?php else: ?>
                <p style="color:#94a3b8;">El instructor no ha añadido criterios de evaluación.</p>
            <?php endif; ?>

            <?php if (!empty($clase['fecha_limite'])): ?>
                <div style="margin-top:1.5rem; padding:1rem; background:#0f172a; border-radius:0.5rem; border:1px solid <?= $plazoVencido ? '#7f1d1d' : '#065f46' ?>;">
                    <p style="color:#94a3b8; margin-bottom:0.25rem;">Fecha límite</p>
                    <p style="color:<?= $plazoVencido ? '#ef4444' : '#10b981' ?>; font-weight:bold; font-size:1.1rem;">
                        <?= date('d/m/Y H:i', $fechaLimite) ?>
                        <?php if ($plazoVencido): ?>
                            <span style="font-size:0.8rem; margin-left:0.5rem;">(Vencido)</span>
                        <?php endif; ?>
                    </p>
                </div>
            <?php endif; ?>
        </div>

        <!-- Estado de la entrega -->
        <?php if ($entrega): ?>
            <div class="fade-in-up card" style="padding:1.5rem; background:rgba(6,95,70,0.1); border:1px solid #065f46;">
                <h3 style="color:#10b981; font-weight:600; margin-bottom:1rem; display:flex; align-items:center; gap:0.5rem;">
                    ✅ Tu entrega
                </h3>
                <p style="color:#e5e7eb; font-size:0.95rem; margin-bottom:0.5rem;">
                    Entregado el <?= date('d/m/Y H:i', strtotime($entrega['fecha_entrega'])) ?>
                </p>
                <?php if (!empty($entrega['archivo_id'])): ?>
                    <a href="/archivo/descargar/<?= $entrega['archivo_id'] ?>" style="color:#fbbf24; font-size:0.9rem;">
                        📎 Ver archivo subido
                    </a>
                <?php endif; ?>
                <?php if (!empty($entrega['comentario_alumno'])): ?>
                    <p style="color:#94a3b8; font-size:0.85rem; margin-top:0.5rem;">
                        Comentario: <?= htmlspecialchars($entrega['comentario_alumno']) ?>
                    </p>
                <?php endif; ?>

                <?php if ($entrega['nota'] !== null): ?>
                    <div style="margin-top:1rem; padding-top:1rem; border-top:1px solid #065f46;">
                        <p style="color:#fbbf24; font-weight:bold; font-size:1.1rem;">Nota: <?= $entrega['nota'] ?>/10</p>
                        <?php if (!empty($entrega['feedback_instructor'])): ?>
                            <p style="color:#cbd5e1; font-size:0.9rem; margin-top:0.5rem;">
                                <span style="color:#fbbf24;">Feedback:</span> <?= htmlspecialchars($entrega['feedback_instructor']) ?>
                            </p>
                        <?php endif; ?>
                    </div>
                <?php else: ?>
                    <div style="margin-top:1rem; display:flex; gap:0.75rem;">
                        <a href="/tarea/editar/<?= $entrega['id'] ?>" class="btn btn-primary btn-sm" style="background:linear-gradient(135deg, #b45309, #d97706); border:none;">
                            Modificar
                        </a>
                        <a href="/tarea/eliminar/<?= $entrega['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar esta entrega?')">
                            Eliminar
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        <?php else: ?>
            <div class="fade-in-up card" style="padding:1.5rem;">
                <?php if (!$plazoVencido): ?>
                    <h3 style="color:#fbbf24; font-weight:600; margin-bottom:1rem;">📤 Subir entrega</h3>
                    <form action="/archivo/subir" method="POST" enctype="multipart/form-data">
                        <?= \App\Core\Csrf::tokenField() ?>
                        <input type="hidden" name="clase_id" value="<?= $clase['id'] ?>">
                        <div class="form-group">
                            <label class="form-label">Selecciona un archivo</label>
                            <input type="file" name="archivo" class="form-input" required>
                        </div>
                        <button type="submit" class="btn btn-primary" style="background:linear-gradient(135deg, #b45309, #d97706); border:none;">
                            Enviar tarea
                        </button>
                    </form>
                <?php else: ?>
                    <div style="text-align:center; padding:1rem;">
                        <p style="color:#ef4444; font-size:1.1rem; font-weight:600;">El plazo de entrega ha finalizado.</p>
                        <p style="color:#94a3b8; font-size:0.9rem; margin-top:0.5rem;">No puedes enviar esta tarea porque la fecha límite ya pasó.</p>
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    <?php endif; ?>
</div>
<?php $content = ob_get_clean(); ?>
<?php require __DIR__ . '/../layouts/main.php'; ?>