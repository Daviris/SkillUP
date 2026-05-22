<?php ob_start(); ?>
<div class="fade-in-up" style="margin-bottom:2rem;">
    <h1 class="font-rpg" style="font-size:2.5rem; color:#fbbf24; margin-bottom:0.5rem; text-shadow:0 0 15px rgba(251,191,36,0.4);">
        <i class="fa-solid fa-people-group"></i> Alumnos de "<?= htmlspecialchars($curso['titulo']) ?>"
    </h1>
    <p style="color:#94a3b8; font-size:1.1rem;">Alumnos matriculados en este curso</p>
</div>

<div class="card" style="padding:1.5rem; margin-bottom:2rem;">
    <div style="display:flex; align-items:center; gap:1rem;">
        <span style="font-size:2rem;"><i class="fa-solid fa-book-open"></i></span>
        <div>
            <p style="color:#fbbf24; font-weight:600;"><?= htmlspecialchars($curso['titulo']) ?></p>
            <p style="color:#94a3b8;"><?= ucfirst($curso['modalidad']) ?> · <?= number_format($curso['precio'], 2) ?> €</p>
        </div>
    </div>
</div>

<?php if (!empty($alumnos)): ?>
    <div class="table-container">
        <table style="width:100%;">
            <thead>
                <tr>
                    <th>Alumno</th>
                    <th>Email</th>
                    <th>Estado del pedido</th>
                    <th style="text-align:right;">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($alumnos as $alumno): ?>
                <tr>
                    <td style="color:#fbbf24;"><?= htmlspecialchars($alumno['nombre']) ?></td>
                    <td><?= htmlspecialchars($alumno['email']) ?></td>
                    <td>
                        <span class="badge <?= $alumno['estado'] === 'completado' ? 'badge-exito' : 'badge-peligro' ?>">
                            <?= $alumno['estado'] ?>
                        </span>
                    </td>
                    <td style="text-align:right;">
                        <?php if ($alumno['estado'] === 'completado'): ?>
                            <a href="/admin/pedidos/revocar/<?= $alumno['pedido_id'] ?>" 
                               class="btn btn-danger btn-sm" 
                               onclick="return confirm('¿Revocar el acceso de este alumno?')">
                               <i class="fa-solid fa-ban"></i> Revocar
                            </a>
                        <?php else: ?>
                            <span style="color:#94a3b8;">Ya cancelado</span>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php else: ?>
    <div class="card" style="padding:3rem; text-align:center;">
        <p style="color:#cbd5e1;">No hay alumnos matriculados en este curso.</p>
    </div>
<?php endif; ?>

<div style="margin-top:2rem;">
    <a href="/admin/cursos" class="btn btn-secondary">← Volver a cursos</a>
</div>
<?php $content = ob_get_clean(); ?>
<?php require __DIR__ . '/layout.php'; ?>