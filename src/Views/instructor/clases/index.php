<?php ob_start(); ?>
<div style="max-width:1000px; margin:0 auto;">
    <!-- Cabecera con mejor espaciado -->
    <div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:2rem;">
        <div>
            <h1 class="font-rpg" style="font-size:2.5rem; color:#fbbf24; margin-bottom:0.5rem;">
                <?= htmlspecialchars($curso['titulo']) ?>
            </h1>
            <p style="color:#9ca3af; font-size:1.1rem;">Gestión de clases</p>
            <?php if (!empty($clases)): ?>
                <p style="color:#9ca3af; font-size:0.9rem; margin-top:0.25rem;">
                    <?= count($clases) ?> clase(s) · <?= array_sum(array_column($clases, 'duracion')) ?> min total
                </p>
            <?php endif; ?>
        </div>
        <a href="/instructor/cursos/<?= $curso['id'] ?>/clases/crear" class="btn btn-primary" style="font-size:1rem; padding:0.75rem 1.5rem;">
            + Nueva clase
        </a>
    </div>

    <!-- Migas de pan con mejor estilo -->
    <div style="margin-bottom:2.5rem; padding:0.75rem 1rem; background:#1e293b; border-radius:0.5rem; border:1px solid #334155; color:#9ca3af; font-size:0.9rem;">
        <a href="/instructor" style="color:#fbbf24;">Panel Instructor</a>
        <span style="margin:0 0.5rem;">/</span>
        <span style="color:#e5e7eb;"><?= htmlspecialchars($curso['titulo']) ?></span>
        <span style="margin:0 0.5rem;">/</span>
        <span style="color:#e5e7eb;">Clases</span>
    </div>

    <!-- Listado de clases -->
    <?php if (!empty($clases)): ?>
        <div style="display:flex; flex-direction:column; gap:1rem;">
            <?php foreach ($clases as $clase): ?>
                <div class="card" style="padding:1.5rem; display:flex; justify-content:space-between; align-items:center; transition:transform 0.15s;">
                    <div style="flex:1;">
                        <div style="display:flex; align-items:center; gap:1rem; margin-bottom:0.5rem;">
                            <span style="background:#b45309; color:white; width:2rem; height:2rem; border-radius:50%; display:flex; align-items:center; justify-content:center; font-weight:700; font-size:0.9rem; flex-shrink:0;">
                                <?= $clase['orden'] ?>
                            </span>
                            <div>
                                <span style="color:#fbbf24; font-weight:600; font-size:1.1rem;">
                                    <a href="/instructor/clases/ver/<?= $clase['id'] ?>" style="color:inherit;">
                                        <?= $clase['orden'] ?>. <?= htmlspecialchars($clase['titulo']) ?>
                                    </a>
                                </span>
                                <div style="display:flex; align-items:center; gap:0.75rem; margin-top:0.25rem;">
                                    <span class="badge badge-amber" style="font-size:0.7rem;"><?= ucfirst($clase['tipo']) ?></span>
                                    <span style="color:#9ca3af; font-size:0.85rem;"><?= $clase['duracion'] ?> min</span>
                                </div>
                            </div>
                        </div>
                        <?php if ($clase['tipo'] === 'tarea' && !empty($clase['fecha_limite'])): ?>
                            <div style="margin-left:3rem; margin-top:0.5rem;">
                                <p style="color:#ef4444; font-size:0.8rem; display:flex; align-items:center; gap:0.25rem;">
                                    ⏰ Límite: <?= date('d/m/Y H:i', strtotime($clase['fecha_limite'])) ?>
                                </p>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div style="display:flex; gap:0.5rem; flex-shrink:0; margin-left:1rem;">
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
        <div class="card" style="padding:4rem 2rem; text-align:center;">
            <p style="font-size:4rem; margin-bottom:1rem;">📚</p>
            <h2 style="color:#fbbf24; font-size:1.5rem; margin-bottom:0.5rem;">No hay clases todavía</h2>
            <p style="color:#9ca3af; margin-bottom:2rem;">Empieza a construir el contenido de tu curso</p>
            <a href="/instructor/cursos/<?= $curso['id'] ?>/clases/crear" class="btn btn-primary" style="font-size:1rem; padding:0.75rem 2rem;">Añadir primera clase</a>
        </div>
    <?php endif; ?>
</div>
<?php $content = ob_get_clean(); ?>
<?php require __DIR__ . '/../../layouts/main.php'; ?>