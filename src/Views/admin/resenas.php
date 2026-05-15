<?php ob_start(); ?>
<h1 class="font-rpg" style="font-size:2.5rem; color:#fbbf24; margin-bottom:2rem;">Reseñas</h1>

<div class="table-container">
    <table>
        <thead>
            <tr>
                <th>Alumno</th>
                <th>Curso</th>
                <th>Puntuación</th>
                <th>Comentario</th>
                <th>Fecha</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($resenas as $resena): ?>
            <tr>
                <td><?= htmlspecialchars($resena['alumno_nombre'] ?? 'ID: ' . $resena['usuario_id']) ?></td>
                <td><?= htmlspecialchars($resena['curso_titulo'] ?? 'ID: ' . $resena['curso_id']) ?></td>
                <td style="color:#fbbf24;">
                    <?= str_repeat('★', $resena['puntuacion']) ?><?= str_repeat('☆', 5 - $resena['puntuacion']) ?>
                </td>
                <td style="max-width:200px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">
                    <?= htmlspecialchars($resena['comentario'] ?? '') ?>
                </td>
                <td><?= date('d/m/Y', strtotime($resena['fecha'])) ?></td>
                <td>
                    <a href="/admin/resenas/eliminar/<?= $resena['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar esta reseña?')">Eliminar</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php $content = ob_get_clean(); ?>
<?php require __DIR__ . '/layout.php'; ?>