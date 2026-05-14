<?php ob_start(); ?>
<?php
$fechaLimiteFormateada = '';
if (!empty($clase['fecha_limite'])) {
    $fechaLimiteFormateada = date('Y-m-d\TH:i', strtotime($clase['fecha_limite']));
}
?>
<div class="max-w-3xl mx-auto">
    <div class="bg-gray-800 rounded-lg border-2 border-amber-700 shadow-xl p-6">
        <h1 class="text-3xl font-bold text-amber-300 mb-6" style="font-family: 'VT323', monospace;">
            <?= $accion ?? 'Crear' ?> clase
        </h1>

        <form method="POST" action="<?= $accion === 'Crear' ? '/instructor/clases/guardar' : '/instructor/clases/actualizar/' . ($clase['id'] ?? '') ?>" enctype="multipart/form-data">
            <input type="hidden" name="curso_id" value="<?= $curso_id ?? $clase['curso_id'] ?>">

            <div class="mb-4">
                <label class="block text-amber-400 text-sm mb-1">Título</label>
                <input type="text" name="titulo" value="<?= htmlspecialchars($clase['titulo'] ?? '') ?>" required
                       class="w-full px-4 py-2 bg-gray-700 border-2 border-amber-600 rounded text-gray-200 focus:outline-none focus:border-amber-400">
            </div>

            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-amber-400 text-sm mb-1">Duración (min)</label>
                    <input type="number" name="duracion" value="<?= htmlspecialchars($clase['duracion'] ?? 0) ?>" required
                           class="w-full px-4 py-2 bg-gray-700 border-2 border-amber-600 rounded text-gray-200 focus:outline-none focus:border-amber-400">
                </div>
                <div>
                    <label class="block text-amber-400 text-sm mb-1">Orden</label>
                    <input type="number" name="orden" value="<?= htmlspecialchars($clase['orden'] ?? 0) ?>" required
                           class="w-full px-4 py-2 bg-gray-700 border-2 border-amber-600 rounded text-gray-200 focus:outline-none focus:border-amber-400">
                </div>
            </div>

            <div class="mb-4">
                <label class="block text-amber-400 text-sm mb-1">Tipo de clase</label>
                <select name="tipo" id="tipo-select" class="w-full px-4 py-2 bg-gray-700 border-2 border-amber-600 rounded text-gray-200 focus:outline-none focus:border-amber-400">
                    <option value="teoria" <?= (isset($clase['tipo']) && $clase['tipo'] === 'teoria') ? 'selected' : '' ?>>Teoría (texto)</option>
                    <option value="archivo" <?= (isset($clase['tipo']) && $clase['tipo'] === 'archivo') ? 'selected' : '' ?>>Archivo (PDF, etc.)</option>
                    <option value="tarea" <?= (isset($clase['tipo']) && $clase['tipo'] === 'tarea') ? 'selected' : '' ?>>Tarea (entrega de alumno)</option>
                </select>
            </div>

            <div id="campo-teoria" class="mb-4 hidden">
                <label class="block text-amber-400 text-sm mb-1">Contenido teórico (markdown)</label>
                <textarea name="contenido_texto" rows="8" class="w-full px-4 py-2 bg-gray-700 border-2 border-amber-600 rounded text-gray-200 focus:outline-none focus:border-amber-400"><?= htmlspecialchars($clase['contenido_texto'] ?? '') ?></textarea>
            </div>

            <div id="campo-archivo" class="mb-4 hidden">
                <label class="block text-amber-400 text-sm mb-1">Archivo (si no se selecciona, se mantiene el actual)</label>
                <input type="file" name="archivo" class="w-full text-gray-200">
                <?php if (!empty($clase['archivo_id'])): ?>
                    <p class="text-sm text-gray-400 mt-1">Actualmente hay un archivo subido.</p>
                <?php endif; ?>
            </div>

            <div id="campo-tarea" class="mb-4 hidden">
                <div class="mb-2">
                    <label class="block text-amber-400 text-sm mb-1">Fecha límite</label>
                    <input type="datetime-local" name="fecha_limite" value="<?= $fechaLimiteFormateada ?>" 
                           class="w-full px-4 py-2 bg-gray-700 border-2 border-amber-600 rounded text-gray-200 focus:outline-none focus:border-amber-400">
                </div>
                <div>
                    <label class="block text-amber-400 text-sm mb-1">Criterios de evaluación</label>
                    <textarea name="criterios_evaluacion" rows="4" class="w-full px-4 py-2 bg-gray-700 border-2 border-amber-600 rounded text-gray-200 focus:outline-none focus:border-amber-400"><?= htmlspecialchars($clase['criterios_evaluacion'] ?? '') ?></textarea>
                </div>
            </div>

            <div class="flex justify-end space-x-3 mt-6">
                <a href="<?= isset($curso_id) ? '/instructor/cursos/' . $curso_id . '/clases' : '/instructor/cursos/' . ($clase['curso_id'] ?? 0) . '/clases' ?>" class="bg-gray-600 hover:bg-gray-500 text-white font-bold py-2 px-6 rounded border border-gray-500 transition">Cancelar</a>
                <button type="submit" class="bg-amber-700 hover:bg-amber-600 text-white font-bold py-2 px-6 rounded border border-amber-500 shadow transition"><?= $accion ?? 'Guardar' ?></button>
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