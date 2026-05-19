<?php ob_start(); ?>
<div style="max-width:500px; margin:3rem auto;">
    <div class="card" style="padding:2rem;">
        <h1 class="font-rpg" style="font-size:2.5rem; color:#fbbf24; text-align:center; margin-bottom:1.5rem;">
            Editar Perfil
        </h1>

        <form action="/perfil/actualizar" method="POST" id="perfil-form" novalidate>
            <div class="form-group">
                <label class="form-label">Nombre</label>
                <input type="text" name="nombre" class="form-input" value="<?= htmlspecialchars($usuario['nombre']) ?>">
            </div>
            <div class="form-group">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-input" value="<?= htmlspecialchars($usuario['email']) ?>">
            </div>
            <div class="form-group">
                <label class="form-label">Nueva contraseña (dejar en blanco para no cambiarla)</label>
                <input type="password" name="password" class="form-input" placeholder="Mínimo 8 caracteres">
            </div>
            <div class="form-group">
                <label class="form-label">Confirmar nueva contraseña</label>
                <input type="password" name="password_confirmation" class="form-input" placeholder="Repite la contraseña">
            </div>
            <div style="display:flex; gap:1rem; margin-top:1.5rem;">
                <button type="submit" class="btn btn-primary">Guardar cambios</button>
                <a href="/perfil" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>
<?php $content = ob_get_clean(); ?>
<?php require __DIR__ . '/../layouts/main.php'; ?>