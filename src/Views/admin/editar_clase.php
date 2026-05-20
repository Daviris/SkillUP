<?php ob_start(); ?>
<div style="max-width:700px; margin:0 auto;">
    <div class="card" style="padding:2rem;">
        <h1 class="font-rpg" style="color:#fbbf24;">
            Editar Clase: <?= htmlspecialchars($clase['titulo']) ?>
        </h1>

        <form method="POST" action="/admin/clases/actualizar/<?= $clase['id'] ?>">
            <?= \App\Core\Csrf::tokenField() ?>
            <input type="hidden" name="curso_id" value="<?= $clase['curso_id'] ?>">

            <div class="form-group">
                <label class="form-label">Título</label>
                <input type="text" name="titulo" class="form-input" value="<?= htmlspecialchars($clase['titulo']) ?>">
            </div>
            <div class="form-group">
                <label class="form-label">Duración (min)</label>
                <input type="number" name="duracion" class="form-input" value="<?= htmlspecialchars($clase['duracion']) ?>">
            </div>
            <div class="form-group">
                <label class="form-label">Orden</label>
                <input type="number" name="orden" class="form-input" value="<?= htmlspecialchars($clase['orden']) ?>">
            </div>
            <div class="form-group">
                <label class="form-label">Tipo</label>
                <select name="tipo" class="form-select">
                    <option value="teoria" <?= $clase['tipo'] === 'teoria' ? 'selected' : '' ?>>Teoría</option>
                    <option value="archivo" <?= $clase['tipo'] === 'archivo' ? 'selected' : '' ?>>Archivo</option>
                    <option value="tarea" <?= $clase['tipo'] === 'tarea' ? 'selected' : '' ?>>Tarea</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary" style="margin-top:1rem;">Guardar cambios</button>
            <a href="/admin/cursos/ver-clases/<?= $clase['curso_id'] ?>" class="btn btn-secondary" style="margin-top:1rem;">Cancelar</a>
        </form>
    </div>
</div>
<?php $content = ob_get_clean(); ?>
<?php require __DIR__ . '/layout.php'; ?>