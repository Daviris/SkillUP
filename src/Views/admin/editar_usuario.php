<?php ob_start(); ?>
<h1 class="font-rpg" style="font-size:2.5rem; color:#fbbf24; margin-bottom:2rem;">
    Editar Usuario: <?= htmlspecialchars($usuario['nombre']) ?>
</h1>

<div class="card" style="max-width:600px; margin:0 auto; padding:2rem;">
    <form action="/admin/usuarios/actualizar/<?= $usuario['id'] ?>" method="POST">
        <?= \App\Core\Csrf::tokenField() ?>
        <div class="form-group">
            <label class="form-label">Nombre</label>
            <input type="text" name="nombre" class="form-input" value="<?= htmlspecialchars($usuario['nombre']) ?>" required>
        </div>

        <div class="form-group">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-input" value="<?= htmlspecialchars($usuario['email']) ?>" required>
        </div>

        <div class="form-group">
            <label class="form-label">Rol</label>
            <select name="rol" class="form-select" required>
                <option value="alumno" <?= $usuario['rol'] === 'alumno' ? 'selected' : '' ?>>Alumno</option>
                <option value="instructor" <?= $usuario['rol'] === 'instructor' ? 'selected' : '' ?>>Instructor</option>
                <option value="admin" <?= $usuario['rol'] === 'admin' ? 'selected' : '' ?>>Administrador</option>
            </select>
        </div>

        <div class="form-group">
            <label class="form-label">Nueva contraseña (dejar en blanco para no cambiarla)</label>
            <input type="password" name="password" class="form-input" placeholder="Mínimo 8 caracteres">
        </div>

        <div style="display:flex; gap:1rem; margin-top:2rem;">
            <button type="submit" class="btn btn-primary">Guardar cambios</button>
            <a href="/admin/usuarios" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>
<?php $content = ob_get_clean(); ?>
<?php require __DIR__ . '/layout.php'; ?>