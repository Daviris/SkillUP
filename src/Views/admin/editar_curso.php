<?php ob_start(); ?>
<h1 class="font-rpg" style="font-size:2.5rem; color:#fbbf24; margin-bottom:2rem;">
    Editar Curso: <?= htmlspecialchars($curso['titulo']) ?>
</h1>

<div class="card" style="max-width:700px; margin:0 auto; padding:2rem;">
    <form action="/admin/cursos/actualizar/<?= $curso['id'] ?>" method="POST">
        <div class="form-group">
            <label class="form-label">Título</label>
            <input type="text" name="titulo" class="form-input" value="<?= htmlspecialchars($curso['titulo']) ?>" required>
        </div>

        <div class="form-group">
            <label class="form-label">Descripción</label>
            <textarea name="descripcion" class="form-textarea" rows="5" required><?= htmlspecialchars($curso['descripcion']) ?></textarea>
        </div>

        <div class="form-group">
            <label class="form-label">Precio (€)</label>
            <input type="number" name="precio" class="form-input" step="0.01" value="<?= $curso['precio'] ?>" required>
        </div>

        <div class="form-group">
            <label class="form-label">Modalidad</label>
            <select name="modalidad" class="form-select" required>
                <option value="online" <?= $curso['modalidad'] === 'online' ? 'selected' : '' ?>>Online</option>
                <option value="presencial" <?= $curso['modalidad'] === 'presencial' ? 'selected' : '' ?>>Presencial</option>
            </select>
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
            <button type="submit" class="btn btn-primary">Guardar cambios</button>
            <a href="/admin/cursos" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>
<?php $content = ob_get_clean(); ?>
<?php require __DIR__ . '/layout.php'; ?>