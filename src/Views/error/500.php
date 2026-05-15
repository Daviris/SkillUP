<?php ob_start(); ?>
<div style="max-width:600px; margin:4rem auto; text-align:center;">
    <div class="card" style="padding:3rem 2rem;">
        <p style="font-size:5rem; margin-bottom:1rem;">💥</p>
        <h1 class="font-rpg" style="font-size:2.5rem; color:#ef4444; margin-bottom:0.5rem;">
            ¡Error crítico!
        </h1>
        <p style="color:#cbd5e1; margin-bottom:1.5rem;">
            Algo salió mal en nuestras mazmorras técnicas.
        </p>

        <?php if (!empty($message)): ?>
            <div style="background:#111827; border:1px solid #374151; border-radius:0.5rem; padding:1rem; margin-bottom:1.5rem; text-align:left;">
                <p style="color:#ef4444; font-family:monospace; font-size:0.9rem; word-break:break-word;">
                    <?= htmlspecialchars($message) ?>
                </p>
            </div>
        <?php endif; ?>

        <a href="/" class="btn btn-primary">🏠 Volver a la taberna</a>
    </div>
</div>
<?php $content = ob_get_clean(); ?>
<?php require __DIR__ . '/../layouts/main.php'; ?>