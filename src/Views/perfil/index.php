<?php ob_start(); ?>
<div style="max-width:900px; margin:0 auto;">
    <h1 class="font-rpg" style="font-size:2.5rem; color:#fbbf24; margin-bottom:2rem;">👤 Mi Perfil</h1>

    <!-- Información básica -->
    <div class="card" style="padding:2rem; margin-bottom:2rem;">
        <div style="display:flex; justify-content:space-between; align-items:center;">
            <div>
                <h2 class="font-rpg" style="font-size:1.8rem; color:#fbbf24; margin-bottom:0.5rem;">
                    <?= htmlspecialchars($usuario['nombre']) ?>
                </h2>
                <p style="color:#cbd5e1;"><?= htmlspecialchars($usuario['email']) ?></p>
                <p style="color:#9ca3af; margin-top:0.25rem;">Rol: <?= ucfirst($usuario['rol']) ?></p>
                <?php if ($usuario['rol'] === 'instructor'): ?>
                    <p style="color:#9ca3af;">Reputación: <?= number_format($usuario['reputacion'] ?? 0, 1) ?> / 5</p>
                <?php endif; ?>
            </div>
            <a href="/perfil/editar" class="btn btn-primary">Editar perfil</a>
        </div>
    </div>

    <!-- Sección para Alumno -->
    <?php if ($usuario['rol'] === 'alumno'): ?>
        <!-- Pedidos -->
        <div class="card" style="padding:2rem; margin-bottom:2rem;">
            <h2 class="font-rpg" style="font-size:1.8rem; color:#fbbf24; margin-bottom:1rem;">🛒 Historial de pedidos</h2>
            <?php if (!empty($pedidos)): ?>
                <div class="table-container">
                    <table style="width:100%;">
                        <thead>
                            <tr>
                                <th>Curso</th>
                                <th>Fecha</th>
                                <th>Total</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($pedidos as $pedido): ?>
                            <tr>
                                <td><?= htmlspecialchars($pedido['curso_titulo']) ?></td>
                                <td><?= date('d/m/Y', strtotime($pedido['fecha'])) ?></td>
                                <td style="color:#fbbf24;"><?= number_format($pedido['total'], 2) ?> €</td>
                                <td><span class="badge badge-green"><?= $pedido['estado'] ?></span></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <p style="color:#9ca3af;">No has realizado ningún pedido.</p>
            <?php endif; ?>
        </div>

        <!-- Cursos comprados -->
        <div class="card" style="padding:2rem; margin-bottom:2rem;">
            <h2 class="font-rpg" style="font-size:1.8rem; color:#fbbf24; margin-bottom:1rem;">📖 Cursos comprados</h2>
            <?php if (!empty($cursosComprados)): ?>
                <div class="grid-3">
                    <?php foreach ($cursosComprados as $curso): ?>
                        <div class="card" style="padding:1rem;">
                            <h3 style="color:#fbbf24; font-weight:600;"><?= htmlspecialchars($curso['titulo']) ?></h3>
                            <p style="color:#9ca3af; font-size:0.9rem; margin-top:0.5rem;"><?= htmlspecialchars($curso['instructor_nombre'] ?? 'N/A') ?></p>
                            <a href="/mis-cursos/ver/<?= $curso['id'] ?>" class="btn btn-primary btn-sm" style="margin-top:0.75rem;">Ver clases</a>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p style="color:#9ca3af;">No has comprado ningún curso todavía.</p>
            <?php endif; ?>
        </div>

        <!-- Reseñas escritas -->
        <div class="card" style="padding:2rem; margin-bottom:2rem;">
            <h2 class="font-rpg" style="font-size:1.8rem; color:#fbbf24; margin-bottom:1rem;">⭐ Reseñas que has escrito</h2>
            <?php if (!empty($resenas)): ?>
                <div style="display:flex; flex-direction:column; gap:1rem;">
                    <?php foreach ($resenas as $resena): ?>
                        <div style="background:#111827; border:1px solid #374151; border-radius:0.5rem; padding:1rem;">
                            <div style="display:flex; justify-content:space-between; margin-bottom:0.5rem;">
                                <span style="color:#fbbf24; font-weight:600;"><?= htmlspecialchars($resena['curso_titulo'] ?? 'Curso') ?></span>
                                <span style="color:#fbbf24;"><?= str_repeat('★', $resena['puntuacion']) ?><?= str_repeat('☆', 5 - $resena['puntuacion']) ?></span>
                            </div>
                            <?php if (!empty($resena['comentario'])): ?>
                                <p style="color:#cbd5e1; font-size:0.95rem;"><?= htmlspecialchars($resena['comentario']) ?></p>
                            <?php endif; ?>
                            <p style="color:#6b7280; font-size:0.8rem; margin-top:0.5rem;"><?= date('d/m/Y', strtotime($resena['fecha'])) ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p style="color:#9ca3af;">No has escrito ninguna reseña.</p>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <!-- Sección para Instructor -->
    <?php if ($usuario['rol'] === 'instructor'): ?>
        <div class="card" style="padding:2rem;">
            <h2 class="font-rpg" style="font-size:1.8rem; color:#fbbf24; margin-bottom:1rem;">🧙 Mis cursos publicados</h2>
            <?php if (!empty($cursos)): ?>
                <div class="table-container">
                    <table style="width:100%;">
                        <thead>
                            <tr>
                                <th>Curso</th>
                                <th>Precio</th>
                                <th>Modalidad</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($cursos as $curso): ?>
                            <tr>
                                <td><?= htmlspecialchars($curso['titulo']) ?></td>
                                <td style="color:#fbbf24;"><?= number_format($curso['precio'], 2) ?> €</td>
                                <td><?= ucfirst($curso['modalidad']) ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <p style="color:#9ca3af;">Aún no has publicado ningún curso.</p>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</div>
<?php $content = ob_get_clean(); ?>
<?php require __DIR__ . '/../layouts/main.php'; ?>