<?php ob_start(); ?>
<?php
$fechaLimiteFormateada = '';
if (!empty($clase['fecha_limite'])) {
    $fechaLimiteFormateada = date('Y-m-d\TH:i', strtotime($clase['fecha_limite']));
}
?>
<div style="max-width:700px; margin:0 auto;">
    <div class="card" style="padding:2rem;">
        <h1 class="font-rpg" style="font-size:2.2rem; color:#fbbf24; margin-bottom:1.5rem;">
            <?= $accion ?? 'Crear' ?> clase
        </h1>

        <form method="POST" action="<?= ($accion ?? '') === 'Crear' ? '/instructor/clases/guardar' : '/instructor/clases/actualizar/' . ($clase['id'] ?? '') ?>" enctype="multipart/form-data">
            <input type="hidden" name="curso_id" value="<?= $curso_id ?? $clase['curso_id'] ?>">

            <div class="form-group">
                <label class="form-label">Título</label>
                <input type="text" name="titulo" class="form-input" value="<?= htmlspecialchars($clase['titulo'] ?? '') ?>" required>
            </div>

            <div style="display:grid; grid-template-columns:1fr 1fr; gap:1rem;">
                <div class="form-group">
                    <label class="form-label">Duración (min)</label>
                    <input type="number" name="duracion" class="form-input" value="<?= htmlspecialchars($clase['duracion'] ?? 0) ?>" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Orden</label>
                    <input type="number" name="orden" class="form-input" value="<?= htmlspecialchars($clase['orden'] ?? '') ?>" placeholder="Auto">
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Tipo de clase</label>
                <select name="tipo" id="tipo-select" class="form-select">
                    <option value="teoria" <?= (isset($clase['tipo']) && $clase['tipo'] === 'teoria') ? 'selected' : '' ?>>Teoría (texto)</option>
                    <option value="archivo" <?= (isset($clase['tipo']) && $clase['tipo'] === 'archivo') ? 'selected' : '' ?>>Archivo (PDF, etc.)</option>
                    <option value="tarea" <?= (isset($clase['tipo']) && $clase['tipo'] === 'tarea') ? 'selected' : '' ?>>Tarea (entrega de alumno)</option>
                </select>
            </div>

            <div id="campo-teoria" class="form-group hidden">
                <label class="form-label">Contenido teórico (markdown)</label>
                <textarea name="contenido_texto" class="form-textarea" rows="8"><?= htmlspecialchars($clase['contenido_texto'] ?? '') ?></textarea>
            </div>

            <div id="campo-archivo" class="form-group hidden">
                <label class="form-label">Archivo</label>
                <input type="file" name="archivo" class="form-input">
                <?php if (!empty($clase['archivo_id'])): ?>
                    <p style="color:#9ca3af; font-size:0.85rem; margin-top:0.25rem;">Ya hay un archivo subido. Selecciona uno nuevo solo si quieres reemplazarlo.</p>
                <?php endif; ?>
            </div>

            <div id="campo-tarea" class="hidden">
                <div class="form-group">
                    <label class="form-label">Fecha límite</label>
                    <input type="datetime-local" name="fecha_limite" class="form-input" value="<?= $fechaLimiteFormateada ?>">
                </div>
                <div class="form-group">
                    <label class="form-label">Criterios de evaluación</label>
                    <textarea name="criterios_evaluacion" class="form-textarea" rows="4"><?= htmlspecialchars($clase['criterios_evaluacion'] ?? '') ?></textarea>
                </div>
            </div>

            <div style="display:flex; gap:1rem; margin-top:2rem;">
                <button type="submit" class="btn btn-primary"><?= $accion ?? 'Guardar' ?></button>
                <a href="/instructor/cursos/<?= $curso_id ?? $clase['curso_id'] ?>/clases" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>

<script>
document.getElementById('tipo-select').addEventListener('change', function() {
    document.getElementById('campo-teoria').classList.add('hidden');
    document.getElementById('campo-archivo').classList.add('hidden');
    document.getElementById('campo-tarea').classList.add('hidden');
    if (this.value === 'teoria') document.getElementById('campo-teoria').classList.remove('hidden');
    if (this.value === 'archivo') document.getElementById('campo-archivo').classList.remove('hidden');
    if (this.value === 'tarea') document.getElementById('campo-tarea').classList.remove('hidden');
});
window.addEventListener('DOMContentLoaded', function() {
    document.getElementById('tipo-select').dispatchEvent(new Event('change'));
});
</script>
<?php $content = ob_get_clean(); ?>
<?php require __DIR__ . '/../layouts/main.php'; ?>