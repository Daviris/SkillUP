<?php ob_start(); ?>
<?php
// Inicializar variables para evitar "Undefined variable"
$clase    = $clase    ?? [];
$curso_id = $curso_id ?? null;
$accion   = $accion   ?? 'Crear';

// Preparar la fecha límite formateada con segundos
$fechaLimiteFormateada = '';
if (!empty($clase['fecha_limite'])) {
    $fechaLimiteFormateada = date('Y-m-d\TH:i:s', strtotime($clase['fecha_limite']));
} else {
    $fechaLimiteFormateada = date('Y-m-d\TH:i:s', strtotime('+1 hour'));
}
?>
<div style="max-width:800px; margin:0 auto;">
    <div class="fade-in-up card" style="padding:2.5rem;">
        <!-- Icono decorativo -->
        <div style="text-align:center; font-size:3rem; margin-bottom:0.5rem;">
            <?= ($accion === 'Crear') ? '📜' : '✏️' ?>
        </div>

        <h1 class="font-rpg" style="font-size:2.5rem; color:#fbbf24; text-align:center; margin-bottom:1.5rem;">
            <?= htmlspecialchars($accion) ?> clase
        </h1>

        <form method="POST" action="<?= $accion === 'Crear' ? '/instructor/clases/guardar' : '/instructor/clases/actualizar/' . ($clase['id'] ?? '') ?>" enctype="multipart/form-data" novalidate>
            <?= \App\Core\Csrf::tokenField() ?>
            <input type="hidden" name="curso_id" value="<?= htmlspecialchars($curso_id ?? $clase['curso_id'] ?? '') ?>">

            <div class="form-group">
                <label class="form-label">Título de la clase</label>
                <input type="text" name="titulo" class="form-input" value="<?= htmlspecialchars($clase['titulo'] ?? '') ?>" placeholder="Ej: Introducción a la forja">
            </div>

            <div style="display:grid; grid-template-columns:1fr 1fr; gap:1rem;">
                <div class="form-group">
                    <label class="form-label">Duración (minutos)</label>
                    <input type="number" name="duracion" class="form-input" value="<?= htmlspecialchars($clase['duracion'] ?? 0) ?>" placeholder="45">
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Tipo de clase</label>
                <select name="tipo" id="tipo-select" class="form-select">
                    <option value="teoria" <?= (isset($clase['tipo']) && $clase['tipo'] === 'teoria') ? 'selected' : '' ?>>📖 Teoría (texto)</option>
                    <option value="archivo" <?= (isset($clase['tipo']) && $clase['tipo'] === 'archivo') ? 'selected' : '' ?>>📄 Archivo (PDF, etc.)</option>
                    <option value="tarea" <?= (isset($clase['tipo']) && $clase['tipo'] === 'tarea') ? 'selected' : '' ?>>📝 Tarea (entrega de alumno)</option>
                </select>
            </div>

            <!-- Campo para teoría -->
            <div id="campo-teoria" class="form-group hidden">
                <label class="form-label">Contenido teórico</label>
                <textarea name="contenido_texto" class="form-textarea" rows="10" placeholder="Escribe aquí el contenido de la clase..."><?= htmlspecialchars($clase['contenido_texto'] ?? '') ?></textarea>
            </div>

            <!-- Campo para archivo -->
            <div id="campo-archivo" class="form-group hidden">
                <label class="form-label">Archivo</label>
                <input type="file" name="archivo" class="form-input">
                <?php if (!empty($clase['archivo_id'])): ?>
                    <p style="color:#94a3b8; font-size:0.85rem; margin-top:0.25rem;">Ya hay un archivo subido. Selecciona uno nuevo solo si quieres reemplazarlo.</p>
                <?php endif; ?>
            </div>

            <!-- Campos para tarea -->
            <div id="campo-tarea" class="hidden">
                <div style="border:1px solid #334155; border-radius:0.5rem; padding:1.5rem; margin-top:1rem; background:#0f172a;">
                    <h3 style="color:#fbbf24; margin-bottom:1rem;">📝 Configuración de la tarea</h3>
                    <div class="form-group">
                        <label class="form-label">Fecha límite</label>
                        <input type="datetime-local" name="fecha_limite" class="form-input" value="<?= $fechaLimiteFormateada ?>" step="60">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Criterios de evaluación</label>
                        <textarea name="criterios_evaluacion" class="form-textarea" rows="4" placeholder="Describe qué deben hacer los alumnos y cómo se evaluará..."><?= htmlspecialchars($clase['criterios_evaluacion'] ?? '') ?></textarea>
                    </div>
                </div>
            </div>

            <div style="display:flex; gap:1rem; margin-top:2rem;">
                <button type="submit" class="btn btn-primary" style="flex:1; background:linear-gradient(135deg, #b45309, #d97706); border:none; padding:0.8rem;">
                    ⚔️ <?= htmlspecialchars($accion) ?>
                </button>
                <a href="<?= !empty($clase['curso_id']) ? '/instructor/cursos/' . $clase['curso_id'] . '/clases' : (!empty($curso_id) ? '/instructor/cursos/' . $curso_id . '/clases' : '/instructor') ?>" class="btn btn-secondary" style="flex:1; text-align:center; padding:0.8rem;">
                    Cancelar
                </a>
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
<?php require __DIR__ . '/../../layouts/main.php'; ?>