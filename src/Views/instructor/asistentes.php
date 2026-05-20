<?php ob_start(); ?>
<div style="max-width:1000px; margin:0 auto;">
    <!-- Migas de pan -->
    <div class="fade-in-up" style="margin-bottom:1.5rem; color:#94a3b8; font-size:0.9rem;">
        <a href="/instructor" style="color:#fbbf24;">🧙 Panel Instructor</a> /
        <span style="color:#e5e7eb;">Asistentes de "<?= htmlspecialchars($curso['titulo']) ?>"</span>
    </div>

    <!-- Cabecera -->
    <div class="fade-in-up card" style="padding:2rem; margin-bottom:2rem; background:linear-gradient(135deg, #5f1e1e, #0f172a); border:2px solid #b45309;">
        <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:1.5rem;">
            <div>
                <h1 class="font-rpg" style="font-size:2.2rem; color:#fbbf24; margin-bottom:0.25rem;">
                    👥 Asistentes
                </h1>
                <p style="color:#cbd5e1;"><?= htmlspecialchars($curso['titulo']) ?> · <?= count($asistentes) ?> alumnos inscritos</p>
            </div>
            <div class="badge" style="background:#7f1d1d; color:white; font-size:0.9rem; padding:0.5rem 1rem;">
                🏰 Presencial
            </div>
        </div>
    </div>

    <!-- Listado de asistentes -->
    <?php if (!empty($asistentes)): ?>
        <div class="fade-in-up table-container" style="transition-delay:0.2s;">
            <table style="width:100%;">
                <thead>
                    <tr>
                        <th>Alumno</th>
                        <th>Email</th>
                        <th>Fecha de compra</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($asistentes as $asistente): ?>
                    <tr>
                        <td style="color:#fbbf24; font-weight:600;"><?= htmlspecialchars($asistente['nombre']) ?></td>
                        <td style="color:#cbd5e1;"><?= htmlspecialchars($asistente['email']) ?></td>
                        <td style="color:#94a3b8;"><?= date('d/m/Y', strtotime($asistente['fecha'])) ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="fade-in-up card" style="padding:3rem; text-align:center;">
            <p style="font-size:3rem; margin-bottom:1rem;">📭</p>
            <p style="color:#cbd5e1; font-size:1.1rem;">Nadie se ha inscrito aún en este curso presencial.</p>
        </div>
    <?php endif; ?>

    <div style="margin-top:2rem;">
        <a href="/instructor" class="btn btn-secondary">← Volver al panel</a>
    </div>
</div>
<?php $content = ob_get_clean(); ?>
<?php require __DIR__ . '/../layouts/main.php'; ?>