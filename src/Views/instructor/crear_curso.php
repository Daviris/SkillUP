<?php ob_start(); ?>
<div style="max-width:800px; margin:0 auto;">
    <div class="card" style="padding:2rem;">
        <h1 class="font-rpg" style="font-size:2.2rem; color:#fbbf24; margin-bottom:1.5rem;">
            <?= htmlspecialchars($accion ?? 'Crear') ?> Curso
        </h1>

        <form method="POST" action="<?= ($accion ?? '') === 'Crear' ? '/instructor/guardar' : '/instructor/actualizar/' . ($curso['id'] ?? '') ?>" id="curso-form">
            <?= \App\Core\Csrf::tokenField() ?>
            <div class="form-group">
                <label class="form-label">Título</label>
                <input type="text" name="titulo" class="form-input" value="<?= htmlspecialchars($curso['titulo'] ?? '') ?>">
            </div>
            <div class="form-group">
                <label class="form-label">Descripción</label>
                <textarea name="descripcion" class="form-textarea" rows="5"><?= htmlspecialchars($curso['descripcion'] ?? '') ?></textarea>
            </div>
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:1rem;">
                <div class="form-group">
                    <label class="form-label">Precio (€)</label>
                    <input type="number" name="precio" class="form-input" step="0.01" value="<?= htmlspecialchars($curso['precio'] ?? '') ?>">
                </div>
                <div class="form-group">
                    <label class="form-label">Modalidad</label>
                    <select name="modalidad" id="modalidad-select" class="form-select" required>
                        <option value="online" <?= (isset($curso['modalidad']) && $curso['modalidad'] === 'online') ? 'selected' : '' ?>>Online</option>
                        <option value="presencial" <?= (isset($curso['modalidad']) && $curso['modalidad'] === 'presencial') ? 'selected' : '' ?>>Presencial</option>
                    </select>
                </div>
            </div>

            <!-- Campos exclusivos para presencial -->
            <div id="campos-presencial" class="hidden">
                <div class="form-group">
                    <label class="form-label">Fecha</label>
                    <input type="date" name="fecha" class="form-input" value="<?= htmlspecialchars($curso['fecha'] ?? '') ?>">
                </div>
                <div class="form-group">
                    <label class="form-label">Hora</label>
                    <input type="time" name="hora" class="form-input" value="<?= htmlspecialchars($curso['hora'] ?? '') ?>">
                </div>
                <div class="form-group">
                    <label class="form-label">Ubicación</label>
                    <input type="text" name="ubicacion" class="form-input" value="<?= htmlspecialchars($curso['ubicacion'] ?? '') ?>" placeholder="Dirección o aula">
                </div>
                <div class="form-group">
                    <label class="form-label">Plazas disponibles</label>
                    <input type="number" name="plazas" class="form-input" value="<?= htmlspecialchars($curso['plazas'] ?? '') ?>" min="1">
                </div>
            </div>

            <div style="display:flex; gap:1rem; margin-top:2rem;">
                <button type="submit" class="btn btn-primary"><?= htmlspecialchars($accion ?? 'Guardar') ?></button>
                <a href="/instructor" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>

<script>
// Mostrar/ocultar campos de presencial según modalidad
document.getElementById('modalidad-select').addEventListener('change', function() {
    const campos = document.getElementById('campos-presencial');
    if (this.value === 'presencial') {
        campos.classList.remove('hidden');
    } else {
        campos.classList.add('hidden');
    }
});
// Ejecutar al cargar por si ya tiene valor seleccionado
window.addEventListener('DOMContentLoaded', function() {
    document.getElementById('modalidad-select').dispatchEvent(new Event('change'));
});
</script>
<?php $content = ob_get_clean(); ?>
<?php require __DIR__ . '/../layouts/main.php'; ?>