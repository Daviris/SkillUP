<?php ob_start(); ?>
<div class="fade-in-up" style="margin-bottom:2rem;">
    <h1 class="font-rpg" style="font-size:2.5rem; color:#fbbf24; margin-bottom:0.5rem;">
        📚 Cursos de <?= htmlspecialchars($usuario['nombre']) ?>
    </h1>
    <p style="color:#94a3b8;">Cursos en los que está matriculado este alumno</p>
</div>

<?php if (!empty($cursos)): ?>
    <div class="table-container">
        <table style="width:100%;">
            <thead>
                <tr>
                    <th>Curso</th>
                    <th>Instructor</th>
                    <th>Modalidad</th>
                    <th>Precio</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cursos as $curso): ?>
                <tr>
                    <td style="color:#fbbf24;"><?= htmlspecialchars($curso['titulo']) ?></td>
                    <td><?= htmlspecialchars($curso['instructor_nombre'] ?? 'N/A') ?></td>
                    <td><?= ucfirst($curso['modalidad']) ?></td>
                    <td style="color:#fbbf24;"><?= number_format($curso['precio'], 2) ?> €</td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php else: ?>
    <div class="card" style="padding:3rem; text-align:center;">
        <p style="color:#94a3b8;">Este alumno no está matriculado en ningún curso.</p>
    </div>
<?php endif; ?>

<div style="margin-top:2rem;">
    <a href="/admin/usuarios" class="btn btn-secondary">← Volver a usuarios</a>
</div>
<?php $content = ob_get_clean(); ?>
<?php require __DIR__ . '/layout.php'; ?>