<?php ob_start(); ?>
<div style="max-width:550px; margin:3rem auto;">
    <div class="fade-in-up card" style="padding:2.5rem;">
        <!-- Icono decorativo -->
        <div style="text-align:center; font-size:3rem; margin-bottom:0.5rem;">📤</div>

        <h1 class="font-rpg" style="font-size:2.2rem; color:#fbbf24; text-align:center; margin-bottom:1.5rem;">
            Modificar entrega
        </h1>

        <p style="color:#cbd5e1; text-align:center; margin-bottom:2rem;">
            Selecciona un nuevo archivo para reemplazar tu entrega actual.
        </p>

        <form action="/tarea/actualizar/<?= $entrega['id'] ?>" method="POST" enctype="multipart/form-data">
            <?= \App\Core\Csrf::tokenField() ?>

            <div class="form-group">
                <label class="form-label">Nuevo archivo</label>
                <input type="file" name="archivo" class="form-input" required>
            </div>

            <div style="display:flex; gap:1rem; margin-top:2rem;">
                <button type="submit" class="btn btn-primary" style="flex:1; background:linear-gradient(135deg, #b45309, #d97706); border:none; padding:0.8rem;">
                    💾 Actualizar
                </button>
                <a href="/mis-cursos/ver/<?= $entrega['clase_id'] ?>" class="btn btn-secondary" style="flex:1; text-align:center; padding:0.8rem;">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</div>
<?php $content = ob_get_clean(); ?>
<?php require __DIR__ . '/../layouts/main.php'; ?>