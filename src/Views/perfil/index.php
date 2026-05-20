<?php ob_start(); ?>
<div style="max-width:900px; margin:0 auto;">
    <!-- Encabezado del perfil (sin cambios) -->
    <div class="fade-in-up card" style="padding:2rem; margin-bottom:2rem; background:linear-gradient(135deg, #1e293b, #0f172a); border:2px solid #b45309;">
        <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:1.5rem;">
            <div style="display:flex; align-items:center; gap:1.5rem;">
                <div style="font-size:4rem;">👤</div>
                <div>
                    <h1 class="font-rpg" style="font-size:2.2rem; color:#fbbf24; margin-bottom:0.25rem;">
                        <?= htmlspecialchars($usuario['nombre']) ?>
                    </h1>
                    <p style="color:#cbd5e1; font-size:1rem; margin-bottom:0.25rem;"><?= htmlspecialchars($usuario['email']) ?></p>
                    <div style="display:flex; align-items:center; gap:1rem; color:#94a3b8; font-size:0.9rem;">
                        <span>Rol: <span class="badge" style="background:<?= $usuario['rol'] === 'instructor' ? '#b45309' : '#065f46' ?>; color:white;"><?= ucfirst($usuario['rol']) ?></span></span>
                        <?php if ($usuario['rol'] === 'instructor'): ?>
                            <span>Reputación: <span style="color:#fbbf24;"><?= number_format($usuario['reputacion'] ?? 0, 1) ?> ★</span></span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <a href="/perfil/editar" class="btn btn-primary" style="background:linear-gradient(135deg, #b45309, #d97706); border:none; padding:0.7rem 1.5rem;">
                ✏️ Editar perfil
            </a>
        </div>
    </div>

    <!-- Sección Alumno -->
    <?php if ($usuario['rol'] === 'alumno'): ?>
        <!-- Historial de pedidos (sin cambios) -->
        <div class="fade-in-up card" style="padding:2rem; margin-bottom:2rem;">
            <h2 class="font-rpg" style="font-size:1.8rem; color:#fbbf24; margin-bottom:1.5rem;">🛒 Historial de pedidos</h2>
            <?php if (!empty($pedidos)): ?>
                <div class="table-container">
                    <table style="width:100%;">
                        <thead>
                            <tr>
                                <th>Fecha</th>
                                <th>Total</th>
                                <th>Estado</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($pedidos as $pedido): ?>
                            <tr>
                                <td><?= date('d/m/Y', strtotime($pedido['fecha'])) ?></td>
                                <td style="color:#fbbf24;"><?= number_format($pedido['total'], 2) ?> €</td>
                                <td><span class="badge" style="background:#065f46; color:white;"><?= $pedido['estado'] ?></span></td>
                                <td><a href="/pedido/confirmacion/<?= $pedido['id'] ?>" style="color:#fbbf24; font-size:0.9rem;">Ver</a></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <p style="color:#94a3b8;">No has realizado ningún pedido todavía.</p>
            <?php endif; ?>
        </div>

        <!-- Cursos comprados (REDISEÑADO) -->
        <div class="fade-in-up card" style="padding:2rem; margin-bottom:2rem;">
            <h2 class="font-rpg" style="font-size:1.8rem; color:#fbbf24; margin-bottom:1.5rem;">📖 Cursos comprados</h2>
            <?php if (!empty($cursosComprados)): ?>
                <div style="display:grid; grid-template-columns:repeat(2, 1fr); gap:1rem;">
                    <?php foreach ($cursosComprados as $curso): ?>
                        <div class="card" style="padding:1.25rem; background:#0f172a; border:1px solid #334155; display:flex; flex-direction:column; justify-content:space-between; transition:border-color 0.2s;">
                            <div>
                                <div style="display:flex; align-items:center; gap:0.5rem; margin-bottom:0.5rem;">
                                    <span style="font-size:1.5rem;">📜</span>
                                    <h3 style="color:#fbbf24; font-weight:600;"><?= htmlspecialchars($curso['titulo']) ?></h3>
                                </div>
                                <p style="color:#94a3b8; font-size:0.9rem;">🧙 <?= htmlspecialchars($curso['instructor_nombre'] ?? 'N/A') ?></p>
                            </div>
                            <a href="/mis-cursos/ver/<?= $curso['id'] ?>" class="btn btn-primary" style="margin-top:1rem; background:linear-gradient(135deg, #b45309, #d97706); border:none; width:100%; text-align:center; padding:0.6rem;">
                                ⚔️ Ir al curso
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p style="color:#94a3b8;">No has comprado ningún curso todavía.</p>
            <?php endif; ?>
        </div>

        <!-- Reseñas escritas (sin cambios) -->
        <div class="fade-in-up card" style="padding:2rem; margin-bottom:2rem;">
            <h2 class="font-rpg" style="font-size:1.8rem; color:#fbbf24; margin-bottom:1.5rem;">⭐ Reseñas que has escrito</h2>
            <?php if (!empty($resenas)): ?>
                <div style="display:grid; gap:1rem;">
                    <?php foreach ($resenas as $resena): ?>
                        <div style="padding:1.25rem; background:#0f172a; border:1px solid #334155; border-radius:0.5rem;">
                            <div style="display:flex; justify-content:space-between; align-items:start; margin-bottom:0.5rem;">
                                <span style="color:#fbbf24; font-weight:600;"><?= htmlspecialchars($resena['curso_titulo'] ?? 'Curso') ?></span>
                                <span style="color:#fbbf24;"><?= str_repeat('★', $resena['puntuacion']) ?><?= str_repeat('☆', 5 - $resena['puntuacion']) ?></span>
                            </div>
                            <?php if (!empty($resena['comentario'])): ?>
                                <p style="color:#cbd5e1; font-size:0.95rem;"><?= htmlspecialchars($resena['comentario']) ?></p>
                            <?php endif; ?>
                            <div style="margin-top:0.75rem; display:flex; gap:0.75rem;">
                                <a href="/resena/editar/<?= $resena['id'] ?>" class="btn btn-primary btn-sm" style="background:linear-gradient(135deg, #b45309, #d97706); border:none;">Editar</a>
                                <a href="/resena/eliminar/<?= $resena['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar esta reseña?')">Eliminar</a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p style="color:#94a3b8;">No has escrito ninguna reseña todavía.</p>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <!-- Sección Instructor (sin cambios) -->
    <?php if ($usuario['rol'] === 'instructor'): ?>
        <div class="fade-in-up card" style="padding:2rem;">
            <h2 class="font-rpg" style="font-size:1.8rem; color:#fbbf24; margin-bottom:1.5rem;">🧙 Mis cursos publicados</h2>
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
                <p style="color:#94a3b8;">Aún no has publicado ningún curso.</p>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</div>
<?php $content = ob_get_clean(); ?>
<?php require __DIR__ . '/../layouts/main.php'; ?>