<?php ob_start(); ?>
<div class="card" style="padding:2rem;">
    <!-- Título y descripción -->
    <div style="margin-bottom:2rem;">
        <h1 class="font-rpg" style="font-size:2.5rem; color:#fbbf24; margin-bottom:0.5rem;">
            <?= htmlspecialchars($curso['titulo']) ?>
        </h1>
        <p style="color:#cbd5e1; line-height:1.6;"><?= htmlspecialchars($curso['descripcion']) ?></p>
    </div>

    <div style="display:grid; grid-template-columns:1fr 1fr; gap:2rem;">
        <!-- Detalles del curso -->
        <div>
            <h2 class="font-rpg" style="font-size:1.8rem; color:#fbbf24; margin-bottom:1rem;">Detalles del curso</h2>
            <ul style="list-style:none; padding:0; color:#e5e7eb; line-height:2;">
                <li><span style="color:#fbbf24;">Instructor:</span> <?= htmlspecialchars($curso['instructor_nombre']) ?></li>
                <li><span style="color:#fbbf24;">Modalidad:</span> <?= ucfirst($curso['modalidad']) ?></li>
                <li><span style="color:#fbbf24;">Precio:</span> <span style="color:#fbbf24; font-weight:bold;"><?= number_format($curso['precio'], 2) ?> €</span></li>
                <li><span style="color:#fbbf24;">Duración total:</span> <?= array_sum(array_column($curso['clases'] ?? [], 'duracion')) ?> min</li>
                <li><span style="color:#fbbf24;">Clases:</span> <?= count($curso['clases'] ?? []) ?></li>
            </ul>

            <!-- Botón de compra o estado -->
            <?php if (isset($_SESSION['usuario']) && $_SESSION['usuario']['rol'] === 'alumno' && !$yaComprado): ?>
                <a href="/carrito/agregar/<?= $curso['id'] ?>" class="btn btn-primary" style="margin-top:1.5rem;">
                    Añadir a la mochila
                </a>
            <?php elseif (isset($_SESSION['usuario']) && $yaComprado): ?>
                <div class="flash-message flash-success" style="margin-top:1.5rem;">
                    Ya has adquirido este curso.
                </div>
            <?php elseif (!isset($_SESSION['usuario'])): ?>
                <div style="margin-top:1.5rem; padding:1rem; background:#1e293b; border:1px solid #b45309; border-radius:0.5rem; color:#cbd5e1;">
                    <a href="/login" style="color:#fbbf24; font-weight:500;">Inicia sesión</a> para comprar este curso.
                </div>
            <?php endif; ?>
        </div>

        <!-- Contenido del curso (clases) -->
        <div>
            <h2 class="font-rpg" style="font-size:1.8rem; color:#fbbf24; margin-bottom:1rem;">Contenido del curso</h2>
            <?php if (!empty($curso['clases'])): ?>
                <div style="border:1px solid #b45309; border-radius:0.5rem; overflow:hidden;">
                    <?php foreach ($curso['clases'] as $clase): ?>
                        <div style="padding:1rem; border-bottom:1px solid #374151; display:flex; justify-content:space-between; align-items:center;">
                            <div>
                                <span style="color:#fbbf24; font-weight:600;">
                                    <?= $clase['orden'] ?>. <?= htmlspecialchars($clase['titulo']) ?>
                                </span>
                                <span class="badge badge-amber" style="margin-left:0.5rem;"><?= ucfirst($clase['tipo']) ?></span>
                                <?php if ($clase['tipo'] === 'teoria' && !empty($clase['contenido_texto'])): ?>
                                    <p style="color:#9ca3af; margin-top:0.25rem; font-size:0.9rem;">
                                        <?= htmlspecialchars(substr($clase['contenido_texto'], 0, 80)) ?>...
                                    </p>
                                <?php elseif ($clase['tipo'] === 'archivo' && !empty($clase['archivo_id'])): ?>
                                    <p style="color:#9ca3af; margin-top:0.25rem; font-size:0.9rem;">Material descargable</p>
                                <?php elseif ($clase['tipo'] === 'tarea' && !empty($clase['criterios_evaluacion'])): ?>
                                    <p style="color:#9ca3af; margin-top:0.25rem; font-size:0.9rem;">
                                        <?= htmlspecialchars(substr($clase['criterios_evaluacion'], 0, 80)) ?>...
                                    </p>
                                <?php else: ?>
                                    <p style="color:#6b7280; margin-top:0.25rem; font-size:0.9rem;">Sin descripción</p>
                                <?php endif; ?>
                            </div>
                            <span style="color:#9ca3af; font-size:0.9rem;"><?= $clase['duracion'] ?> min</span>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p style="color:#9ca3af;">Este curso aún no tiene clases publicadas.</p>
            <?php endif; ?>
        </div>
    </div>

    <!-- Sección de reseñas -->
    <div style="margin-top:3rem; border-top:1px solid #374151; padding-top:2rem;">
        <h2 class="font-rpg" style="font-size:1.8rem; color:#fbbf24; margin-bottom:1.5rem;">Reseñas de alumnos</h2>

        <?php
            $resenas = \App\Models\Resena::delCurso($curso['id']);
        ?>

        <?php if (!empty($resenas)): ?>
            <div style="display:flex; flex-direction:column; gap:1rem;">
                <?php foreach ($resenas as $resena): ?>
                    <div class="card" style="padding:1rem;">
                        <div style="display:flex; justify-content:space-between; align-items:start; margin-bottom:0.5rem;">
                            <span style="color:#fbbf24; font-weight:600;">
                                <?= htmlspecialchars($resena['alumno_nombre']) ?>
                            </span>
                            <span style="color:#fbbf24;">
                                <?= str_repeat('★', $resena['puntuacion']) ?><?= str_repeat('☆', 5 - $resena['puntuacion']) ?>
                            </span>
                        </div>
                        <?php if (!empty($resena['comentario'])): ?>
                            <p style="color:#cbd5e1; font-size:0.95rem;"><?= htmlspecialchars($resena['comentario']) ?></p>
                        <?php endif; ?>
                        <p style="color:#6b7280; font-size:0.8rem; margin-top:0.5rem;"><?= date('d/m/Y', strtotime($resena['fecha'])) ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p style="color:#9ca3af;">Aún no hay reseñas para este curso.</p>
        <?php endif; ?>

        <!-- Formulario de reseña (solo para alumnos que compraron y no han reseñado) -->
        <?php if (isset($_SESSION['usuario']) && $_SESSION['usuario']['rol'] === 'alumno'): ?>
            <?php
                $usuarioId = $_SESSION['usuario']['id'];
                $yaCompro = \App\Models\Pedido::usuarioTieneCurso($usuarioId, $curso['id']);
                $yaReseno = \App\Models\Resena::buscarPorUsuarioYCurso($usuarioId, $curso['id']);
            ?>
            <?php if ($yaCompro && !$yaReseno): ?>
                <div class="card" style="margin-top:1.5rem; padding:1.5rem;">
                    <h3 class="font-rpg" style="font-size:1.3rem; color:#fbbf24; margin-bottom:1rem;">Deja tu reseña</h3>
                    <form action="/resena/guardar" method="POST">
                        <input type="hidden" name="curso_id" value="<?= $curso['id'] ?>">
                        <div class="form-group">
                            <label class="form-label">Puntuación (1-5)</label>
                            <select name="puntuacion" class="form-select" required>
                                <option value="5">★★★★★ (5)</option>
                                <option value="4">★★★★☆ (4)</option>
                                <option value="3">★★★☆☆ (3)</option>
                                <option value="2">★★☆☆☆ (2)</option>
                                <option value="1">★☆☆☆☆ (1)</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Comentario (opcional)</label>
                            <textarea name="comentario" class="form-textarea" rows="3"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Enviar reseña</button>
                    </form>
                </div>
            <?php elseif ($yaReseno): ?>
                <p style="color:#9ca3af; margin-top:1rem;">Ya has reseñado este curso.</p>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</div>
<?php $content = ob_get_clean(); ?>
<?php require __DIR__ . '/../layouts/main.php'; ?>