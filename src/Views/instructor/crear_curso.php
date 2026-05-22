<?php ob_start(); ?>
<div style="max-width:800px; margin:0 auto;">
    <div class="fade-in-up card" style="padding:2.5rem;">
        <!-- Icono decorativo -->
        <div style="text-align:center; font-size:3rem; margin-bottom:0.5rem;"><i class="fa-solid fa-scroll"></i></div>

        <h1 class="font-rpg" style="font-size:2.5rem; color:#fbbf24; text-align:center; margin-bottom:1.5rem;">
            <?= htmlspecialchars($accion ?? 'Crear') ?> Curso
        </h1>

        <form method="POST" action="<?= ($accion ?? '') === 'Crear' ? '/instructor/guardar' : '/instructor/actualizar/' . ($curso['id'] ?? '') ?>" id="curso-form" novalidate>
            <?= \App\Core\Csrf::tokenField() ?>

            <div class="form-group">
                <label class="form-label">Título del curso</label>
                <input type="text" name="titulo" class="form-input" value="<?= htmlspecialchars($curso['titulo'] ?? '') ?>" placeholder="Ej: Forja de PHP">
            </div>

            <div class="form-group">
                <label class="form-label">Descripción</label>
                <textarea name="descripcion" class="form-textarea" rows="5" placeholder="Describe la misión que vivirán los alumnos..."><?= htmlspecialchars($curso['descripcion'] ?? '') ?></textarea>
            </div>

            <div style="display:grid; grid-template-columns:1fr 1fr; gap:1rem;">
                <div class="form-group">
                    <label class="form-label">Precio (€)</label>
                    <input type="number" name="precio" class="form-input" step="0.01" value="<?= htmlspecialchars($curso['precio'] ?? '') ?>" placeholder="99.99">
                </div>
                <div class="form-group">
                    <label class="form-label">Modalidad</label>
                    <select name="modalidad" id="modalidad-select" class="form-select">
                        <option value="online" <?= (isset($curso['modalidad']) && $curso['modalidad'] === 'online') ? 'selected' : '' ?>><i class="fa-solid fa-globe"></i> Online</option>
                        <option value="presencial" <?= (isset($curso['modalidad']) && $curso['modalidad'] === 'presencial') ? 'selected' : '' ?>><i class="fa-solid fa-dungeon"></i> Presencial</option>
                    </select>
                </div>
            </div>

            <!-- Campos exclusivos para presencial -->
            <div id="campos-presencial" class="hidden">
                <div style="border:1px solid #334155; border-radius:0.5rem; padding:1.5rem; margin-top:1rem; background:#0f172a;">
                    <h3 style="color:#fbbf24; margin-bottom:1rem;"><i class="fa-solid fa-location-dot"></i> Detalles presenciales</h3>
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
                        <input type="number" name="plazas" class="form-input" value="<?= htmlspecialchars($curso['plazas'] ?? '') ?>" min="1" placeholder="20">
                    </div>
                </div>
            </div>

            <div style="display:flex; gap:1rem; margin-top:2rem;">
                <button type="submit" class="btn btn-primary" style="flex:1; background:linear-gradient(135deg, #b45309, #d97706); border:none; padding:0.8rem;">
                    <i class="fa-solid fa-sword"></i> <?= htmlspecialchars($accion ?? 'Guardar') ?>
                </button>
                <a href="/instructor" class="btn btn-secondary" style="flex:1; text-align:center; padding:0.8rem;">
                    Cancelar
                </a>
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