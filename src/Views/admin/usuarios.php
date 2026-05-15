<?php ob_start(); ?>
<h1 class="font-rpg" style="font-size:2.5rem; color:#fbbf24; margin-bottom:2rem;">Usuarios</h1>

<div class="table-container">
    <table>
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Email</th>
                <th>Rol</th>
                <th>Reputación</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($usuarios as $u): ?>
            <tr>
                <td><?= htmlspecialchars($u['nombre']) ?></td>
                <td><?= htmlspecialchars($u['email']) ?></td>
                <td>
                    <span class="badge <?= $u['rol'] === 'admin' ? 'badge-red' : ($u['rol'] === 'instructor' ? 'badge-amber' : 'badge-green') ?>">
                        <?= $u['rol'] ?>
                    </span>
                </td>
                <td><?= number_format($u['reputacion'], 1) ?> / 5</td>
                <td>
                    <div style="display:flex; gap:0.5rem;">
                        <a href="/admin/usuarios/editar/<?= $u['id'] ?>" class="btn btn-primary btn-sm">Editar</a>
                        <a href="/admin/usuarios/eliminar/<?= $u['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar este usuario?')">Eliminar</a>
                    </div>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php $content = ob_get_clean(); ?>
<?php require __DIR__ . '/layout.php'; ?>