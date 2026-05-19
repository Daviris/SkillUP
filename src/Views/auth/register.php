<?php ob_start(); ?>
<div style="max-width:1000px; margin:3rem auto; display:flex; gap:2rem; align-items:start;">
    <!-- Columna de confianza (izquierda) -->
    <div style="flex:1; padding-top:2rem;">
        <h2 style="font-family:'VT323', monospace; font-size:2rem; color:#fbbf24; margin-bottom:1.5rem;">✨ Únete a SkillUP</h2>
        <p style="color:#cbd5e1; margin-bottom:2rem;">Crea tu cuenta y empieza a subir de nivel.</p>

        <div style="display:flex; flex-direction:column; gap:1rem; margin-bottom:2rem;">
            <div style="display:flex; align-items:center; gap:0.75rem; color:#9ca3af;">
                <span style="font-size:1.5rem;">🔒</span>
                <span>Contraseñas cifradas con hash seguro</span>
            </div>
            <div style="display:flex; align-items:center; gap:0.75rem; color:#9ca3af;">
                <span style="font-size:1.5rem;">📧</span>
                <span>Verificación de email incluida</span>
            </div>
            <div style="display:flex; align-items:center; gap:0.75rem; color:#9ca3af;">
                <span style="font-size:1.5rem;">💳</span>
                <span>Pagos protegidos con tecnología SSL</span>
            </div>
            <div style="display:flex; align-items:center; gap:0.75rem; color:#9ca3af;">
                <span style="font-size:1.5rem;">🛡️</span>
                <span>Protección de datos personal</span>
            </div>
        </div>
    </div>

    <!-- Formulario (derecha) -->
    <div style="flex:1; max-width:550px;">
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

            <form method="POST" action="/register" id="register-form" novalidate>
                <div class="form-group">
                    <label class="form-label">Nombre completo</label>
                    <input type="text" name="nombre" class="form-input" value="<?= htmlspecialchars($_SESSION['old']['nombre'] ?? '') ?>" placeholder="Tu nombre">
                </div>

                <div class="form-group">
                    <label class="form-label">Correo electrónico</label>
                    <input type="text" name="email" class="form-input" value="<?= htmlspecialchars($_SESSION['old']['email'] ?? '') ?>" placeholder="ejemplo@correo.com">
                </div>

                <div class="form-group">
                    <label class="form-label">Contraseña (mínimo 8 caracteres)</label>
                    <input type="password" name="password" class="form-input" placeholder="••••••••">
                </div>

                <div class="form-group">
                    <label class="form-label">Confirmar contraseña</label>
                    <input type="password" name="password_confirmation" class="form-input" placeholder="••••••••">
                </div>

                <div class="form-group">
                    <label class="form-label">Tipo de cuenta</label>
                    <select name="rol" class="form-select">
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
</div>
<?php $content = ob_get_clean(); ?>
<?php require __DIR__ . '/../layouts/main.php'; ?>