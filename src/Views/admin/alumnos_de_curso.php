<?php ob_start(); ?>
<div class="fade-in-up" style="margin-bottom:2rem;">
    <h1 class="font-rpg" style="font-size:2.5rem; color:#fbbf24; margin-bottom:0.5rem;">
        👥 Alumnos de "<?= htmlspecialchars($curso['titulo']) ?>"
    </h1>
    <p style="color:#94a3b8;">Alumnos matriculados en este curso</p>
</div>

<?php if (!empty($alumnos)): ?>
    <div class="table-container">
        <table style="width:100%;">
            <thead>
                <tr>
                    <th>Alumno</th>
                    <th>Email</th>
                    <th>Fecha de compra</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($alumnos as $alumno): ?>
                <tr>
                    <td style="color:#fbbf24;"><?= htmlspecialchars($alumno['nombre']) ?></td>
                    <td><?= htmlspecialchars($alumno['email']) ?></td>
                    <td><?= date('d/m/Y', strtotime($alumno['fecha'])) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php else: ?>
    <div class="card" style="padding:3rem; text-align:center;">
        <p style="color:#94a3b8;">No hay alumnos matriculados en este curso.</p>
    </div>
<?php endif; ?>

<div style="margin-top:2rem;">
    <a href="/admin/cursos" class="btn btn-secondary">← Volver a cursos</a>
</div>
<?php $content = ob_get_clean(); ?>
<?php require __DIR__ . '/layout.php'; ?>