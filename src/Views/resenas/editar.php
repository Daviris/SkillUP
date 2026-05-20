<?php ob_start(); ?>
<div style="max-width:500px; margin:3rem auto;">
    <div class="card" style="padding:2rem;">
        <h1 class="font-rpg" style="font-size:2.5rem; color:#fbbf24; text-align:center; margin-bottom:1.5rem;">
            Editar Reseña
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

        <form action="/resena/actualizar/<?= $resena['id'] ?>" method="POST">
            <?= \App\Core\Csrf::tokenField() ?>
            <div class="form-group">
                <label class="form-label">Puntuación (1-5)</label>
                <select name="puntuacion" class="form-select" required>
                    <option value="5" <?= $resena['puntuacion'] == 5 ? 'selected' : '' ?>>★★★★★ (5)</option>
                    <option value="4" <?= $resena['puntuacion'] == 4 ? 'selected' : '' ?>>★★★★☆ (4)</option>
                    <option value="3" <?= $resena['puntuacion'] == 3 ? 'selected' : '' ?>>★★★☆☆ (3)</option>
                    <option value="2" <?= $resena['puntuacion'] == 2 ? 'selected' : '' ?>>★★☆☆☆ (2)</option>
                    <option value="1" <?= $resena['puntuacion'] == 1 ? 'selected' : '' ?>>★☆☆☆☆ (1)</option>
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">Comentario</label>
                <textarea name="comentario" class="form-textarea" rows="4"><?= htmlspecialchars($resena['comentario'] ?? '') ?></textarea>
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