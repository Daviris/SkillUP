<?php ob_start(); ?>
<div style="max-width:550px; margin:3rem auto;">
    <div class="card" style="padding:2.5rem 2rem;">
        <h1 class="font-rpg" style="font-size:2.5rem; color:#fbbf24; text-align:center; margin-bottom:1.5rem;">
            Crear Cuenta
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

        <form method="POST" action="/register">
            <div class="form-group">
                <label class="form-label">Nombre completo</label>
                <input type="text" name="nombre" class="form-input" value="<?= htmlspecialchars($_SESSION['old']['nombre'] ?? '') ?>" placeholder="Tu nombre" required>
            </div>

            <div class="form-group">
                <label class="form-label">Correo electrónico</label>
                <input type="email" name="email" class="form-input" value="<?= htmlspecialchars($_SESSION['old']['email'] ?? '') ?>" placeholder="ejemplo@correo.com" required>
            </div>

            <div class="form-group">
                <label class="form-label">Contraseña (mínimo 8 caracteres)</label>
                <input type="password" name="password" class="form-input" placeholder="••••••••" required>
            </div>

            <div class="form-group">
                <label class="form-label">Confirmar contraseña</label>
                <input type="password" name="password_confirmation" class="form-input" placeholder="••••••••" required>
            </div>

            <div class="form-group">
                <label class="form-label">Tipo de cuenta</label>
                <select name="rol" class="form-select" required>
                    <option value="alumno" <?= ($_SESSION['old']['rol'] ?? '') === 'alumno' ? 'selected' : '' ?>>Alumno</option>
                    <option value="instructor" <?= ($_SESSION['old']['rol'] ?? '') === 'instructor' ? 'selected' : '' ?>>Instructor</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary" style="width:100%; margin-top:1rem;">Registrarse</button>
        </form>

        <p style="text-align:center; margin-top:1.5rem; color:#9ca3af;">
            ¿Ya tienes cuenta? <a href="/login" style="color:#fbbf24;">Inicia sesión</a>
        </p>
    </div>
</div>
<?php $content = ob_get_clean(); ?>
<?php require __DIR__ . '/../layouts/main.php'; ?>