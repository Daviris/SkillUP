<?php ob_start(); ?>
<div style="max-width:1000px; margin:0 auto;">
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:2rem;">
        <h1 class="font-rpg" style="font-size:2.5rem; color:#fbbf24;">Mis Cursos</h1>
        <a href="/instructor/crear" class="btn btn-primary">+ Nuevo curso</a>
    </div>

    <?php if ($mensaje = $_SESSION['mensaje'] ?? null): ?>
        <div class="flash-message flash-success" style="margin-bottom:1.5rem;">
            <?= htmlspecialchars($mensaje) ?>
        </div>
        <?php unset($_SESSION['mensaje']); ?>
    <?php endif; ?>

    <?php if (!empty($cursos)): ?>
        <div class="table-container">
            <table style="width:100%;">
                <thead>
                    <tr>
                        <th>Título</th>
                        <th>Modalidad</th>
                        <th>Precio</th>
                        <th>Clases</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cursos as $c): ?>
                    <tr>
                        <td style="font-weight:600; color:#fbbf24;"><?= htmlspecialchars($c['titulo']) ?></td>
                        <td><?= ucfirst($c['modalidad']) ?></td>
                        <td style="color:#fbbf24;"><?= number_format($c['precio'], 2) ?> €</td>
                        <td>
                            <a href="/instructor/cursos/<?= $c['id'] ?>/clases" style="color:#fbbf24;">
                                <?= $c['total_clases'] ?? 'Gestionar' ?>
                            </a>
                        </td>
                        <td>
                            <div style="display:flex; gap:0.5rem;">
                                <a href="/instructor/editar/<?= $c['id'] ?>" class="btn btn-primary btn-sm">Editar</a>
                                <a href="/instructor/eliminar/<?= $c['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar este curso?')">Eliminar</a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="card" style="padding:3rem; text-align:center;">
            <p style="font-size:3rem; margin-bottom:1rem;">📭</p>
            <p style="color:#cbd5e1; font-size:1.1rem;">Aún no has creado ningún curso.</p>
            <a href="/instructor/crear" class="btn btn-primary" style="margin-top:1.5rem;">Crear mi primer curso</a>
        </div>
    <?php endif; ?>
</div>
<?php $content = ob_get_clean(); ?>
<?php require __DIR__ . '/../layouts/main.php'; ?>