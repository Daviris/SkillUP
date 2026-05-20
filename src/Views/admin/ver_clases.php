<?php ob_start(); ?>
<div class="fade-in-up" style="margin-bottom:2rem;">
    <h1 class="font-rpg" style="font-size:2.5rem; color:#fbbf24; margin-bottom:0.5rem; text-shadow:0 0 15px rgba(251,191,36,0.4);">
        📚 Clases de "<?= htmlspecialchars($curso['titulo']) ?>"
    </h1>
    <p style="color:#94a3b8; font-size:1.1rem;">Revisa el contenido del curso</p>
</div>

<!-- Migas de pan -->
<div style="margin-bottom:1.5rem; color:#94a3b8; font-size:0.9rem;">
    <a href="/admin/cursos" style="color:#fbbf24;">📚 Cursos</a> /
    <span style="color:#e5e7eb;"><?= htmlspecialchars($curso['titulo']) ?></span>
</div>

<?php if (!empty($curso['clases'])): ?>
    <div style="display:grid; gap:1rem;">
        <?php foreach ($curso['clases'] as $clase): ?>
            <div class="card" style="padding:1.25rem 1.5rem; display:flex; justify-content:space-between; align-items:center; background:linear-gradient(135deg, #1e293b, #0f172a); border:1px solid #334155;">
                <div style="flex:1;">
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
                <div style="display:flex; gap:0.5rem; align-items:center;">
                    <a href="/admin/clases/editar/<?= $clase['id'] ?>" class="btn btn-primary btn-sm" style="background:linear-gradient(135deg, #b45309, #d97706); border:none;">
                        ✏️ Editar
                    </a>
                    <a href="/admin/clases/eliminar/<?= $clase['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar esta clase?')">
                        🗑️ Eliminar
                    </a>
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

<div style="margin-top:2rem;">
    <a href="/admin/cursos" class="btn btn-secondary">← Volver a cursos</a>
</div>
<?php $content = ob_get_clean(); ?>
<?php require __DIR__ . '/layout.php'; ?>