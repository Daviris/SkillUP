<?php ob_start(); ?>
<div style="max-width:900px; margin:0 auto;">
    <!-- Migas de pan -->
    <div style="margin-bottom:1.5rem; color:#9ca3af; font-size:0.9rem;">
        <a href="/mis-cursos" style="color:#fbbf24;">Mis Cursos</a> /
        <span style="color:#e5e7eb;"><?= htmlspecialchars($curso['titulo']) ?></span>
    </div>

    <!-- Cabecera del curso -->
    <div class="card" style="padding:2rem; margin-bottom:2rem;">
        <h1 class="font-rpg" style="font-size:2.5rem; color:#fbbf24; margin-bottom:0.5rem;">
            <?= htmlspecialchars($curso['titulo']) ?>
        </h1>
        <p style="color:#cbd5e1; margin-bottom:1rem;"><?= htmlspecialchars($curso['descripcion']) ?></p>
        <div style="display:flex; gap:2rem; color:#9ca3af; font-size:0.9rem;">
            <span>Instructor: <?= htmlspecialchars($curso['instructor_nombre'] ?? 'N/A') ?></span>
            <span><?= count($curso['clases'] ?? []) ?> clases</span>
            <span><?= array_sum(array_column($curso['clases'] ?? [], 'duracion')) ?> min total</span>
        </div>
    </div>

    <!-- Listado de clases -->
    <?php if (!empty($curso['clases'])): ?>
        <div style="display:flex; flex-direction:column; gap:1rem;">
            <?php foreach ($curso['clases'] as $clase): ?>
                <a href="/mis-cursos/clase/<?= $clase['id'] ?>" class="card" style="display:flex; justify-content:space-between; align-items:center; padding:1.25rem 1.5rem; text-decoration:none; transition:transform 0.15s;">
                    <div>
                        <h3 style="color:#fbbf24; font-weight:600; margin-bottom:0.25rem;">
                            <?= $clase['orden'] ?>. <?= htmlspecialchars($clase['titulo']) ?>
                        </h3>
                        <div style="display:flex; align-items:center; gap:0.75rem; color:#9ca3af; font-size:0.85rem;">
                            <span class="badge badge-amber" style="font-size:0.7rem;"><?= ucfirst($clase['tipo']) ?></span>
                            <span><?= $clase['duracion'] ?> min</span>
                        </div>
                    </div>
                    <span style="color:#fbbf24; font-size:1.2rem;">→</span>
                </a>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="card" style="padding:3rem; text-align:center;">
            <p style="font-size:3rem; margin-bottom:1rem;">📭</p>
            <p style="color:#cbd5e1; font-size:1.1rem;">Este curso aún no tiene clases publicadas.</p>
        </div>
    <?php endif; ?>

    <!-- Reseñas y formulario -->
    <div style="margin-top:3rem; border-top:1px solid #374151; padding-top:2rem;">
        <h2 class="font-rpg" style="font-size:1.8rem; color:#fbbf24; margin-bottom:1.5rem;">⭐ Reseñas de alumnos</h2>

        <?php
            $resenas = \App\Models\Resena::delCurso($curso['id']);
        ?>

        <?php if (!empty($resenas)): ?>
            <div style="display:flex; flex-direction:column; gap:1rem; margin-bottom:2rem;">
                <?php foreach ($resenas as $resena): ?>
                    <div class="card" style="padding:1rem;">
                        <div style="display:flex; justify-content:space-between; align-items:start; margin-bottom:0.5rem;">
                            <span style="color:#fbbf24; font-weight:600;"><?= htmlspecialchars($resena['alumno_nombre']) ?></span>
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
            <p style="color:#9ca3af; margin-bottom:2rem;">Aún no hay reseñas para este curso.</p>
        <?php endif; ?>

        <!-- Formulario de reseña (solo si el alumno no ha reseñado aún) -->
        <?php if (isset($_SESSION['usuario']) && $_SESSION['usuario']['rol'] === 'alumno'): ?>
            <?php
                $yaReseno = \App\Models\Resena::buscarPorUsuarioYCurso($_SESSION['usuario']['id'], $curso['id']);
            ?>
            <?php if (!$yaReseno): ?>
                <div class="card" style="padding:1.5rem;">
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
            <?php else: ?>
                <p style="color:#9ca3af; margin-top:1rem;">Ya has reseñado este curso.</p>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</div>
<?php $content = ob_get_clean(); ?>
<?php require __DIR__ . '/../layouts/main.php'; ?>