<?php ob_start(); ?>
<div style="max-width:550px; margin:3rem auto;">
    <div class="fade-in-up card" style="padding:2.5rem 2rem;">
        <div style="text-align:center; font-size:3rem; margin-bottom:0.5rem;">✏️</div>
        <h1 class="font-rpg" style="font-size:2.5rem; color:#fbbf24; text-align:center; margin-bottom:1.5rem;">
            Editar Perfil
        </h1>

        <?php if (!empty($_SESSION['errores'])): ?>
            <div class="flash-message flash-error" style="margin-bottom:1.5rem;">
                <ul style="list-style:none; padding:0; margin:0;">
                    <?php foreach ($_SESSION['errores'] as $error): ?>
                        <li><?= htmlspecialchars($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <?php unset($_SESSION['errores']); ?>
        <?php endif; ?>

        <form action="/perfil/actualizar" method="POST" id="perfil-form" novalidate>
            <?= \App\Core\Csrf::tokenField() ?>
            <div class="form-group">
                <label class="form-label">Nombre</label>
                <input type="text" name="nombre" class="form-input" value="<?= htmlspecialchars($usuario['nombre']) ?>">
            </div>
            <div class="form-group">
                <label class="form-label">Email</label>
                <input type="text" name="email" class="form-input" value="<?= htmlspecialchars($usuario['email']) ?>">
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
                <button type="submit" class="btn btn-primary" style="flex:1; background:linear-gradient(135deg, #b45309, #d97706); border:none; padding:0.8rem;">
                    💾 Guardar cambios
                </button>
                <a href="/perfil" class="btn btn-secondary" style="flex:1; text-align:center; padding:0.8rem;">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</div>
<?php $content = ob_get_clean(); ?>
<?php require __DIR__ . '/../layouts/main.php'; ?>