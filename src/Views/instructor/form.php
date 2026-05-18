<?php ob_start(); ?>
<div style="max-width:700px; margin:0 auto;">
    <div class="card" style="padding:2rem;">
        <h1 class="font-rpg" style="font-size:2.2rem; color:#fbbf24; margin-bottom:1.5rem;">
            <?= htmlspecialchars($accion ?? 'Crear') ?> Curso
        </h1>

        <form method="POST" action="<?= ($accion ?? '') === 'Crear' ? '/instructor/guardar' : '/instructor/actualizar/' . ($curso['id'] ?? '') ?>">
            <div class="form-group">
                <label class="form-label">Título</label>
                <input type="text" name="titulo" class="form-input" value="<?= htmlspecialchars($curso['titulo'] ?? '') ?>" required>
            </div>
            <div class="form-group">
                <label class="form-label">Descripción</label>
                <textarea name="descripcion" class="form-textarea" rows="5" required><?= htmlspecialchars($curso['descripcion'] ?? '') ?></textarea>
            </div>
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:1rem;">
                <div class="form-group">
                    <label class="form-label">Precio (€)</label>
                    <input type="number" name="precio" class="form-input" step="0.01" value="<?= htmlspecialchars($curso['precio'] ?? '') ?>" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Modalidad</label>
                    <select name="modalidad" class="form-select" required>
                        <option value="online" <?= (isset($curso['modalidad']) && $curso['modalidad'] === 'online') ? 'selected' : '' ?>>Online</option>
                        <option value="presencial" <?= (isset($curso['modalidad']) && $curso['modalidad'] === 'presencial') ? 'selected' : '' ?>>Presencial</option>
                    </select>
                </div>
            </div>
            <div style="display:flex; gap:1rem; margin-top:2rem;">
                <button type="submit" class="btn btn-primary"><?= htmlspecialchars($accion ?? 'Guardar') ?></button>
                <a href="/instructor" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>
<?php $content = ob_get_clean(); ?>
<?php require __DIR__ . '/../layouts/main.php'; ?>