<?php ob_start(); ?>
<div style="max-width:600px; margin:0 auto;">
    <div class="card" style="padding:2rem;">
        <h1 class="font-rpg" style="color:#fbbf24;">
            Editar Usuario: <?= htmlspecialchars($usuario['nombre']) ?>
        </h1>

        <form method="POST" action="/admin/usuarios/actualizar/<?= $usuario['id'] ?>">
            <?= \App\Core\Csrf::tokenField() ?>

            <div class="form-group">
                <label class="form-label">Nombre</label>
                <input type="text" name="nombre" class="form-input" value="<?= htmlspecialchars($usuario['nombre']) ?>">
            </div>
            <div class="form-group">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-input" value="<?= htmlspecialchars($usuario['email']) ?>">
            </div>
            <div class="form-group">
                <label class="form-label">Rol</label>
                <select name="rol" class="form-select">
                    <option value="alumno" <?= $usuario['rol'] === 'alumno' ? 'selected' : '' ?>><i class="fa-solid fa-book"></i> Alumno</option>
                    <option value="instructor" <?= $usuario['rol'] === 'instructor' ? 'selected' : '' ?>><i class="fa-solid fa-hat-wizard"></i> Instructor</option>
                    <option value="admin" <?= $usuario['rol'] === 'admin' ? 'selected' : '' ?>><i class="fa-solid fa-shield"></i> Administrador</option>
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">Nueva contraseña (dejar vacío para no cambiarla)</label>
                <input type="password" name="password" class="form-input" placeholder="Mínimo 8 caracteres">
            </div>

            <div style="display:flex; gap:1rem; margin-top:2rem;">
                <button type="submit" class="btn btn-primary" style="flex:1; background:linear-gradient(135deg, #b45309, #d97706); border:none; padding:0.8rem;">
                    <i class="fa-solid fa-floppy-disk"></i> Guardar cambios
                </button>
                <a href="/admin/usuarios" class="btn btn-secondary" style="flex:1; text-align:center; padding:0.8rem;">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</div>
<?php $content = ob_get_clean(); ?>
<?php require __DIR__ . '/layout.php'; ?>