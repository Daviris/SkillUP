<?php ob_start(); ?>
<div class="fade-in-up" style="margin-bottom:2rem;">
    <h1 class="font-rpg" style="font-size:2.5rem; color:#fbbf24; margin-bottom:0.5rem; text-shadow:0 0 15px rgba(251,191,36,0.4);">
        📚 Clases de "<?= htmlspecialchars($curso['titulo']) ?>"
    </h1>
    <p style="color:#94a3b8; font-size:1.1rem;">Revisa el contenido antes de aprobar o rechazar el curso</p>
</div>

<!-- Migas de pan -->
<div style="margin-bottom:1.5rem; color:#94a3b8; font-size:0.9rem;">
    <a href="/admin/revisiones" style="color:#fbbf24;">📋 Revisiones</a> /
    <span style="color:#e5e7eb;"><?= htmlspecialchars($curso['titulo']) ?></span>
</div>

<?php if (!empty($curso['clases'])): ?>
    <div style="display:grid; gap:1rem;">
        <?php foreach ($curso['clases'] as $clase): ?>
            <div class="card" style="padding:1.25rem 1.5rem; display:flex; justify-content:space-between; align-items:center; background:linear-gradient(135deg, #1e293b, #0f172a); border:1px solid #334155;">
                <div>
                    <div style="display:flex; align-items:center; gap:0.75rem; margin-bottom:0.25rem;">
                        <span style="color:#fbbf24; font-weight:600; font-size:1.1rem;">
                            <?= $clase['orden'] ?>. <?= htmlspecialchars($clase['titulo']) ?>
                        </span>
                        <span class="badge" style="background:<?= $clase['tipo'] === 'teoria' ? '#065f46' : ($clase['tipo'] === 'tarea' ? '#7f1d1d' : '#b45309') ?>; color:white; font-size:0.7rem;">
                            <?= ucfirst($clase['tipo']) ?>
                        </span>
                        <span style="color:#94a3b8; font-size:0.85rem;"><?= $clase['duracion'] ?> min</span>
                    </div>
                    <?php if ($clase['tipo'] === 'teoria' && !empty($clase['contenido_texto'])): ?>
                        <p style="color:#cbd5e1; font-size:0.9rem; margin-top:0.5rem;">
                            <?= htmlspecialchars(substr($clase['contenido_texto'], 0, 200)) ?>...
                        </p>
                    <?php elseif ($clase['tipo'] === 'archivo' && !empty($clase['archivo_id'])): ?>
                        <p style="color:#94a3b8; font-size:0.9rem; margin-top:0.5rem;">📄 Archivo adjunto</p>
                    <?php elseif ($clase['tipo'] === 'tarea' && !empty($clase['criterios_evaluacion'])): ?>
                        <p style="color:#cbd5e1; font-size:0.9rem; margin-top:0.5rem;">
                            <?= htmlspecialchars(substr($clase['criterios_evaluacion'], 0, 200)) ?>...
                        </p>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php else: ?>
    <div class="card" style="padding:3rem; text-align:center;">
        <p style="font-size:3rem; margin-bottom:1rem;">📭</p>
        <p style="color:#cbd5e1; font-size:1.1rem;">Este curso aún no tiene clases.</p>
    </div>
<?php endif; ?>

<div style="margin-top:2rem; display:flex; gap:1rem;">
    <a href="/admin/revisiones" class="btn btn-secondary">← Volver a revisiones</a>
    <a href="/admin/revisiones/aprobar/<?= $curso['id'] ?>" class="btn btn-success">✅ Aprobar curso</a>
    <button onclick="document.getElementById('form-rechazo').style.display='block'" class="btn btn-danger">❌ Rechazar curso</button>
</div>

<!-- Formulario de rechazo (oculto) -->
<div id="form-rechazo" style="display:none; margin-top:1rem;">
    <div class="card" style="padding:1.5rem;">
        <h3 style="color:#fbbf24; margin-bottom:1rem;">Motivo del rechazo</h3>
        <form action="/admin/revisiones/rechazar/<?= $curso['id'] ?>" method="POST">
            <?= \App\Core\Csrf::tokenField() ?>
            <textarea name="motivo" rows="3" class="form-textarea" placeholder="Explica por qué se rechaza el curso..." required></textarea>
            <button type="submit" class="btn btn-danger" style="margin-top:0.5rem;">Confirmar rechazo</button>
        </form>
    </div>
</div>
<?php $content = ob_get_clean(); ?>
<?php require __DIR__ . '/layout.php'; ?>