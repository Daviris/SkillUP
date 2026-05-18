<?php ob_start(); ?>
<div style="max-width:900px; margin:0 auto;">
    <h1 class="font-rpg" style="font-size:2.5rem; color:#fbbf24; margin-bottom:1rem;">
        Asistentes: <?= htmlspecialchars($curso['titulo']) ?>
    </h1>

    <div style="margin-bottom:2rem; color:#9ca3af; font-size:0.9rem;">
        <a href="/instructor" style="color:#fbbf24;">Panel Instructor</a> /
        <span style="color:#e5e7eb;">Asistentes</span>
    </div>

    <?php if (!empty($asistentes)): ?>
        <div class="table-container">
            <table style="width:100%;">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Fecha de compra</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($asistentes as $a): ?>
                    <tr>
                        <td><?= htmlspecialchars($a['nombre']) ?></td>
                        <td><?= htmlspecialchars($a['email']) ?></td>
                        <td><?= date('d/m/Y', strtotime($a['fecha'])) ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <p style="color:#9ca3af; margin-top:1rem;">Total de asistentes: <?= count($asistentes) ?></p>
    <?php else: ?>
        <div class="card text-center" style="padding:3rem;">
            <p style="color:#9ca3af; font-size:1.1rem;">Aún no hay alumnos inscritos en este curso presencial.</p>
        </div>
    <?php endif; ?>

    <div style="margin-top:2rem;">
        <a href="/instructor" style="color:#fbbf24;">← Volver al panel</a>
    </div>
</div>
<?php $content = ob_get_clean(); ?>
<?php require __DIR__ . '/../layouts/main.php'; ?>