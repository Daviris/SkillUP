<?php ob_start(); ?>
<h1 class="font-rpg" style="font-size:2.5rem; color:#fbbf24; margin-bottom:2rem;">Cursos</h1>

<div class="table-container">
    <table>
        <thead>
            <tr>
                <th>Título</th>
                <th>Instructor</th>
                <th>Precio</th>
                <th>Modalidad</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($cursos as $curso): ?>
            <tr>
                <td><?= htmlspecialchars($curso['titulo']) ?></td>
                <td><?= htmlspecialchars($curso['instructor_nombre']) ?></td>
                <td style="color:#fbbf24; font-weight:600;"><?= number_format($curso['precio'], 2) ?> €</td>
                <td>
                    <span class="badge <?= $curso['modalidad'] === 'online' ? 'badge-green' : 'badge-amber' ?>">
                        <?= ucfirst($curso['modalidad']) ?>
                    </span>
                </td>
                <td>
                    <div style="display:flex; gap:0.5rem;">
                        <a href="/admin/cursos/editar/<?= $curso['id'] ?>" class="btn btn-primary btn-sm">Editar</a>
                        <a href="/admin/cursos/eliminar/<?= $curso['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar este curso?')">Eliminar</a>
                    </div>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php $content = ob_get_clean(); ?>
<?php require __DIR__ . '/layout.php'; ?>