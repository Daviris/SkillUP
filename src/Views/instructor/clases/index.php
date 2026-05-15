<?php ob_start(); ?>
<div style="max-width:1000px; margin:0 auto;">
    <!-- Cabecera -->
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:1rem;">
        <div>
            <h1 class="font-rpg" style="font-size:2.5rem; color:#fbbf24; margin-bottom:0.25rem;">
                <?= htmlspecialchars($curso['titulo']) ?>
            </h1>
            <p style="color:#9ca3af;">Gestión de clases</p>
        </div>
        <a href="/instructor/cursos/<?= $curso['id'] ?>/clases/crear" class="btn btn-primary">+ Nueva clase</a>
    </div>

    <!-- Migas de pan -->
    <div style="margin-bottom:2rem; color:#9ca3af; font-size:0.9rem;">
        <a href="/instructor" style="color:#fbbf24;">Panel Instructor</a> /
        <span style="color:#e5e7eb;"><?= htmlspecialchars($curso['titulo']) ?></span>
    </div>

    <!-- Listado de clases -->
    <?php if (!empty($clases)): ?>
        <div style="display:flex; flex-direction:column; gap:1rem;">
            <?php foreach ($clases as $clase): ?>
                <div class="card" style="padding:1.25rem 1.5rem; display:flex; justify-content:space-between; align-items:center;">
                    <div>
                        <div style="display:flex; align-items:center; gap:0.75rem; margin-bottom:0.25rem;">
                            <span style="color:#fbbf24; font-weight:600; font-size:1.1rem;">
                                <?= $clase['orden'] ?>. <?= htmlspecialchars($clase['titulo']) ?>
                            </span>
                            <span class="badge badge-amber"><?= ucfirst($clase['tipo']) ?></span>
                            <span style="color:#9ca3af; font-size:0.85rem;"><?= $clase['duracion'] ?> min</span>
                        </div>
                        <?php if ($clase['tipo'] === 'tarea' && !empty($clase['fecha_limite'])): ?>
                            <p style="color:#ef4444; font-size:0.8rem; margin-top:0.25rem;">
                                Límite: <?= date('d/m/Y H:i', strtotime($clase['fecha_limite'])) ?>
                            </p>
                        <?php endif; ?>
                    </div>
                    <div style="display:flex; gap:0.75rem;">
                        <a href="/instructor/clases/editar/<?= $clase['id'] ?>" class="btn btn-primary btn-sm">Editar</a>
                        <a href="/instructor/clases/eliminar/<?= $clase['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar esta clase?')">Eliminar</a>
                        <?php if ($clase['tipo'] === 'tarea'): ?>
                            <a href="/instructor/clases/<?= $clase['id'] ?>/entregas" class="btn btn-secondary btn-sm">Entregas</a>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="card" style="padding:3rem; text-align:center;">
            <p style="font-size:3rem; margin-bottom:1rem;">📭</p>
            <p style="color:#cbd5e1; font-size:1.1rem;">No hay clases todavía.</p>
            <a href="/instructor/cursos/<?= $curso['id'] ?>/clases/crear" class="btn btn-primary" style="margin-top:1.5rem;">Añadir primera clase</a>
        </div>
    <?php endif; ?>
</div>
<?php $content = ob_get_clean(); ?>
<?php require __DIR__ . '/../../layouts/main.php'; ?>