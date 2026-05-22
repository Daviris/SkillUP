<?php ob_start(); ?>
<div style="max-width:500px; margin:3rem auto;">
    <div class="card fade-in-up" style="padding:2.5rem 2rem;">
        <!-- Icono decorativo -->
        <div style="text-align:center; font-size:3rem; margin-bottom:0.5rem;"><i class="fa-solid fa-key"></i></div>
        
        <h1 class="font-rpg" style="font-size:2.5rem; color:#fbbf24; text-align:center; margin-bottom:1.5rem;">
            Acceder a la Taberna
        </h1>
        
        <!-- Errores del servidor -->
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

        <form method="POST" action="/login" id="login-form" novalidate>
            <?= \App\Core\Csrf::tokenField() ?>
            <div class="form-group">
                <label class="form-label">Correo electrónico</label>
                <input type="text" name="email" class="form-input" value="<?= htmlspecialchars($_SESSION['old']['email'] ?? '') ?>" placeholder="aventurero@skillup.com" autofocus>
            </div>
            <div class="form-group">
                <label class="form-label">Contraseña</label>
                <input type="password" name="password" class="form-input" placeholder="••••••••">
            </div>
            <button type="submit" class="btn btn-primary" style="width:100%; margin-top:1.5rem; padding:0.8rem; font-size:1rem; background:linear-gradient(135deg, #b45309, #d97706); border:none;">
                <i class="fa-solid fa-sword"></i> Entrar
            </button>
        </form>
        
        <p style="text-align:center; margin-top:1.5rem; color:#94a3b8;">
            ¿Aún no tienes cuenta? <a href="/register" style="color:#fbbf24; font-weight:600;">Regístrate aquí</a>
        </p>
    </div>
</div>
<?php $content = ob_get_clean(); ?>
<?php require __DIR__ . '/../layouts/main.php'; ?>