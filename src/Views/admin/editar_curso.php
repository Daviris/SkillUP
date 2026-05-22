<?php ob_start(); ?>
<div style="max-width:700px; margin:0 auto;">
    <div class="card" style="padding:2rem;">
        <h1 class="font-rpg" style="font-size:2.2rem; color:#fbbf24; margin-bottom:1.5rem;">
            Editar Curso: <?= htmlspecialchars($curso['titulo']) ?>
        </h1>

        <form method="POST" action="/admin/cursos/actualizar/<?= $curso['id'] ?>">
            <?= \App\Core\Csrf::tokenField() ?>

            <div class="form-group">
                <label class="form-label">Título</label>
                <input type="text" name="titulo" class="form-input" value="<?= htmlspecialchars($curso['titulo']) ?>" required>
            </div>

            <div class="form-group">
                <label class="form-label">Descripción</label>
                <textarea name="descripcion" class="form-textarea" rows="5" required><?= htmlspecialchars($curso['descripcion']) ?></textarea>
            </div>

            <div style="display:grid; grid-template-columns:1fr 1fr; gap:1rem;">
                <div class="form-group">
                    <label class="form-label">Precio (€)</label>
                    <input type="number" name="precio" class="form-input" step="0.01" value="<?= htmlspecialchars($curso['precio']) ?>" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Modalidad</label>
                    <select name="modalidad" class="form-select" required>
                        <option value="online" <?= $curso['modalidad'] === 'online' ? 'selected' : '' ?>><i class="fa-solid fa-globe"></i> Online</option>
                        <option value="presencial" <?= $curso['modalidad'] === 'presencial' ? 'selected' : '' ?>><i class="fa-solid fa-dungeon"></i> Presencial</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Instructor</label>
                <select name="id_instructor" class="form-select" required>
                    <?php foreach ($instructores as $instructor): ?>
                        <option value="<?= $instructor['id'] ?>" <?= $instructor['id'] == $curso['id_instructor'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($instructor['nombre']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div style="display:flex; gap:1rem; margin-top:2rem;">
                <button type="submit" class="btn btn-primary" style="flex:1; background:linear-gradient(135deg, #b45309, #d97706); border:none; padding:0.8rem;">
                    <i class="fa-solid fa-floppy-disk"></i> Guardar cambios
                </button>
                <a href="/admin/cursos" class="btn btn-secondary" style="flex:1; text-align:center; padding:0.8rem;">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</div>
<?php $content = ob_get_clean(); ?>
<?php require __DIR__ . '/layout.php'; ?>