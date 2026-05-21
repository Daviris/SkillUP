<?php ob_start(); ?>
<div style="max-width:1100px; margin:0 auto;">
    <!-- Migas de pan -->
    <div class="fade-in-up" style="margin-bottom:1.5rem; color:#94a3b8; font-size:0.9rem;">
        <a href="/instructor" style="color:#fbbf24;">🧙 Panel Instructor</a> /
        <span style="color:#e5e7eb;"><?= htmlspecialchars($curso['titulo']) ?></span>
    </div>

    <!-- Cabecera -->
    <div class="fade-in-up" style="margin-bottom:2rem; display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:1rem;">
        <div>
            <h1 class="font-rpg" style="font-size:2.5rem; color:#fbbf24; margin-bottom:0.25rem;">
                <?= htmlspecialchars($curso['titulo']) ?>
            </h1>
            <p style="color:#94a3b8; font-size:1rem;">Gestión de clases · <?= count($clases ?? []) ?> clases</p>
        </div>
        <a href="/instructor/cursos/<?= $curso['id'] ?>/clases/crear" class="btn btn-primary" style="background:linear-gradient(135deg, #b45309, #d97706); border:none; padding:0.7rem 1.8rem; box-shadow:0 0 15px rgba(251,191,36,0.2);">
            + Nueva clase
        </a>
    </div>

    <!-- Listado de clases -->
    <?php if (!empty($clases)): ?>
        <div class="fade-in-up" style="transition-delay:0.2s; display:grid; gap:1rem;">
            <?php foreach ($clases as $clase): ?>
                <div class="card" style="padding:1.25rem 1.5rem; display:flex; justify-content:space-between; align-items:center; gap:2rem; background:linear-gradient(135deg, #1e293b, #0f172a); border:1px solid #334155; transition:border-color 0.2s;">
                    <!-- Bloque izquierdo -->
                    <div style="flex:1;">
                        <div style="display:flex; align-items:center; gap:0.75rem; margin-bottom:0.5rem;">
                            <a href="/instructor/clases/ver/<?= $clase['id'] ?>" style="color:#fbbf24; font-weight:600; font-size:1.1rem; text-decoration:none; transition:color 0.2s;">
                                <?= $clase['orden'] ?>. <?= htmlspecialchars($clase['titulo']) ?>
                            </a>
                            <span class="badge" style="background:<?= $clase['tipo'] === 'teoria' ? '#065f46' : ($clase['tipo'] === 'tarea' ? '#7f1d1d' : '#b45309') ?>; color:white; font-size:0.7rem;">
                                <?= ucfirst($clase['tipo']) ?>
                            </span>
                            <span style="color:#94a3b8; font-size:0.85rem;"><?= $clase['duracion'] ?> min</span>
                        </div>
                    </div>
                    <!-- Bloque derecho (botones) -->
                    <div style="display:flex; gap:1rem; align-items:center; flex-shrink:0;">
                        <a href="/instructor/clases/editar/<?= $clase['id'] ?>" class="btn btn-primary btn-sm" style="background:linear-gradient(135deg, #b45309, #d97706); border:none;">
                            ✏️ Editar
                        </a>
                        <a href="/instructor/clases/eliminar/<?= $clase['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar esta clase?')">
                            🗑️ Eliminar
                        </a>
                        <?php if ($clase['tipo'] === 'tarea'): ?>
                            <a href="/instructor/clases/<?= $clase['id'] ?>/entregas" class="btn btn-secondary btn-sm">
                                📋 Entregas
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="fade-in-up card" style="padding:4rem 2rem; text-align:center;">
            <p style="font-size:4rem; margin-bottom:1rem;">📭</p>
            <h2 class="font-rpg" style="font-size:1.8rem; color:#fbbf24; margin-bottom:0.5rem;">No hay clases todavía</h2>
            <p style="color:#94a3b8; font-size:1.1rem; margin-bottom:2rem;">Crea la primera clase para este curso y comparte tu conocimiento.</p>
            <a href="/instructor/cursos/<?= $curso['id'] ?>/clases/crear" class="btn btn-primary" style="background:linear-gradient(135deg, #b45309, #d97706); border:none; padding:0.7rem 2rem;">
                + Añadir primera clase
            </a>
        </div>
    <?php endif; ?>

    <div style="margin-top:2rem;">
        <a href="/instructor" class="fade-in-up btn btn-secondary">← Volver al panel</a>
    </div>
</div>
<?php $content = ob_get_clean(); ?>
<?php require __DIR__ . '/../../layouts/main.php'; ?>