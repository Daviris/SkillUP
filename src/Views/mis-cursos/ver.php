<?php ob_start(); ?>
<div style="max-width:1100px; margin:0 auto;">
    <!-- Migas de pan -->
    <div class="fade-in-up" style="margin-bottom:1.5rem; color:#94a3b8; font-size:0.9rem;">
        <a href="/mis-cursos" style="color:#fbbf24;">📖 Mis Cursos</a> /
        <span style="color:#e5e7eb;"><?= htmlspecialchars($curso['titulo']) ?></span>
    </div>

    <!-- Cabecera del curso -->
    <div class="fade-in-up card" style="padding:2.5rem; margin-bottom:2rem; background: linear-gradient(135deg, #1e3a5f, #0f172a); border:2px solid #b45309; position:relative; overflow:hidden;">
        <div style="position:absolute; top:0; left:0; right:0; bottom:0; background:radial-gradient(circle at 80% 20%, rgba(251,191,36,0.08) 0%, transparent 50%); pointer-events:none;"></div>
        <div style="position:relative; z-index:2;">
            <h1 class="font-rpg" style="font-size:2.5rem; color:#fbbf24; margin-bottom:0.5rem; text-shadow:0 0 15px rgba(251,191,36,0.3);">
                <?= htmlspecialchars($curso['titulo']) ?>
            </h1>
            <p style="color:#cbd5e1; margin-bottom:1.5rem; line-height:1.6;"><?= htmlspecialchars($curso['descripcion']) ?></p>
            
            <!-- Detalles rápidos -->
            <div style="display:flex; flex-wrap:wrap; gap:1.5rem; color:#94a3b8; font-size:0.95rem;">
                <!-- Enlace al perfil del instructor -->
                <a href="/instructor/<?= $curso['id_instructor'] ?>" style="color:#fbbf24; text-decoration:underline;">
                    🧙 <?= htmlspecialchars($curso['instructor_nombre'] ?? 'N/A') ?>
                </a>
                <span><?= $curso['modalidad'] === 'online' ? '🌐 Online' : '🏰 Presencial' ?></span>
                <?php if ($curso['modalidad'] === 'online'): ?>
                    <span>📚 <?= count($curso['clases'] ?? []) ?> clases</span>
                    <span>⏱️ <?= array_sum(array_column($curso['clases'] ?? [], 'duracion')) ?> min total</span>
                <?php else: ?>
                    <?php if (!empty($curso['fecha'])): ?>
                        <span>📅 <?= date('d/m/Y', strtotime($curso['fecha'])) ?></span>
                    <?php endif; ?>
                    <?php if (!empty($curso['hora'])): ?>
                        <span>🕐 <?= $curso['hora'] ?></span>
                    <?php endif; ?>
                    <?php if (!empty($curso['ubicacion'])): ?>
                        <span>📍 <?= htmlspecialchars($curso['ubicacion']) ?></span>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Contenido según modalidad -->
    <?php if ($curso['modalidad'] === 'online'): ?>
        <div class="fade-in-up" style="transition-delay:0.2s; margin-bottom:2rem;">
            <h2 class="font-rpg" style="font-size:1.8rem; color:#fbbf24; margin-bottom:1.5rem;">📖 Clases de esta misión</h2>
            <?php if (!empty($curso['clases'])): ?>
                <div style="display:grid; gap:1rem;">
                    <?php foreach ($curso['clases'] as $clase): ?>
                        <a href="/mis-cursos/clase/<?= $clase['id'] ?>" class="card" style="padding:1.25rem 1.5rem; display:flex; justify-content:space-between; align-items:center; text-decoration:none; transition:transform 0.2s, box-shadow 0.2s;">
                            <div>
                                <h3 style="color:#fbbf24; font-weight:600; margin-bottom:0.25rem;">
                                    <?= $clase['orden'] ?>. <?= htmlspecialchars($clase['titulo']) ?>
                                </h3>
                                <div style="display:flex; align-items:center; gap:0.75rem; color:#94a3b8; font-size:0.85rem;">
                                    <span class="badge" style="background:<?= $clase['tipo'] === 'teoria' ? '#065f46' : ($clase['tipo'] === 'tarea' ? '#7f1d1d' : '#b45309') ?>; font-size:0.7rem;">
                                        <?= ucfirst($clase['tipo']) ?>
                                    </span>
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
        </div>
    <?php else: ?>
        <div class="fade-in-up" style="transition-delay:0.2s; margin-bottom:2rem;">
            <h2 class="font-rpg" style="font-size:1.8rem; color:#fbbf24; margin-bottom:1.5rem;">📍 Información de la sesión</h2>
            <div class="card" style="padding:2rem;">
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:1rem;">
                    <?php if (!empty($curso['fecha'])): ?>
                        <div style="padding:1rem; background:#0f172a; border-radius:0.5rem; border:1px solid #334155;">
                            <div style="font-size:1.2rem; margin-bottom:0.25rem;">📅</div>
                            <div style="color:#fbbf24; font-weight:600;"><?= date('d/m/Y', strtotime($curso['fecha'])) ?></div>
                            <div style="color:#94a3b8; font-size:0.8rem;">Fecha</div>
                        </div>
                    <?php endif; ?>
                    <?php if (!empty($curso['hora'])): ?>
                        <div style="padding:1rem; background:#0f172a; border-radius:0.5rem; border:1px solid #334155;">
                            <div style="font-size:1.2rem; margin-bottom:0.25rem;">🕐</div>
                            <div style="color:#fbbf24; font-weight:600;"><?= $curso['hora'] ?></div>
                            <div style="color:#94a3b8; font-size:0.8rem;">Hora</div>
                        </div>
                    <?php endif; ?>
                    <?php if (!empty($curso['ubicacion'])): ?>
                        <div style="padding:1rem; background:#0f172a; border-radius:0.5rem; border:1px solid #334155;">
                            <div style="font-size:1.2rem; margin-bottom:0.25rem;">📍</div>
                            <div style="color:#fbbf24; font-weight:600;"><?= htmlspecialchars($curso['ubicacion']) ?></div>
                            <div style="color:#94a3b8; font-size:0.8rem;">Ubicación</div>
                        </div>
                    <?php endif; ?>
                    <?php if (isset($curso['plazas'])): ?>
                        <div style="padding:1rem; background:#0f172a; border-radius:0.5rem; border:1px solid #334155;">
                            <div style="font-size:1.2rem; margin-bottom:0.25rem;">👥</div>
                            <div style="color:#fbbf24; font-weight:600;"><?= $curso['plazas'] ?> plazas</div>
                            <div style="color:#94a3b8; font-size:0.8rem;">Capacidad</div>
                        </div>
                    <?php endif; ?>
                </div>
                <?php if (empty($curso['fecha']) && empty($curso['hora']) && empty($curso['ubicacion'])): ?>
                    <p style="color:#94a3b8;">El instructor aún no ha definido los detalles de la sesión presencial.</p>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>

    <!-- Sección de reseñas -->
    <div class="fade-in-up card" style="margin-top:2rem; padding:2.5rem;">
        <h2 class="font-rpg" style="font-size:1.8rem; color:#fbbf24; margin-bottom:1.5rem;">⭐ Reseñas de Aventureros</h2>

        <?php $resenas = \App\Models\Resena::delCurso($curso['id']); ?>

        <?php if (!empty($resenas)): ?>
            <div style="display:grid; gap:1rem; margin-bottom:2rem;">
                <?php foreach ($resenas as $resena): ?>
                    <div style="padding:1.5rem; background:#0f172a; border:1px solid #334155; border-radius:0.75rem;">
                        <div style="display:flex; justify-content:space-between; align-items:start; margin-bottom:0.75rem;">
                            <span style="color:#fbbf24; font-weight:600; font-size:1.1rem;">
                                🧑‍🎓 <?= htmlspecialchars($resena['alumno_nombre']) ?>
                            </span>
                            <span style="color:#fbbf24; font-size:1.1rem;">
                                <?= str_repeat('★', $resena['puntuacion']) ?><?= str_repeat('☆', 5 - $resena['puntuacion']) ?>
                            </span>
                        </div>
                        <?php if (!empty($resena['comentario'])): ?>
                            <p style="color:#cbd5e1; font-size:0.95rem; line-height:1.5;"><?= htmlspecialchars($resena['comentario']) ?></p>
                        <?php endif; ?>
                        <p style="color:#6b7280; font-size:0.8rem; margin-top:0.75rem;"><?= date('d/m/Y', strtotime($resena['fecha'])) ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p style="color:#94a3b8; margin-bottom:2rem;">Aún no hay reseñas para este curso. ¡Sé el primero en valorarlo!</p>
        <?php endif; ?>

        <?php if (isset($_SESSION['usuario']) && $_SESSION['usuario']['rol'] === 'alumno'): ?>
            <?php $yaReseno = \App\Models\Resena::buscarPorUsuarioYCurso($_SESSION['usuario']['id'], $curso['id']); ?>
            <?php if (!$yaReseno): ?>
                <div style="padding:1.5rem; background:#0f172a; border:1px solid #b45309; border-radius:0.75rem;">
                    <h3 class="font-rpg" style="font-size:1.3rem; color:#fbbf24; margin-bottom:1rem;">Deja tu reseña</h3>
                    <form action="/resena/guardar" method="POST" id="resena-form" novalidate>
                        <input type="hidden" name="curso_id" value="<?= $curso['id'] ?>">
                        <div class="form-group">
                            <label class="form-label">Puntuación (1-5)</label>
                            <select name="puntuacion" class="form-select" required>
                                <option value="5">★★★★★ (5) - ¡Épica!</option>
                                <option value="4">★★★★☆ (4) - Muy buena</option>
                                <option value="3">★★★☆☆ (3) - Normal</option>
                                <option value="2">★★☆☆☆ (2) - Mejorable</option>
                                <option value="1">★☆☆☆☆ (1) - No me gustó</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Comentario (opcional)</label>
                            <textarea name="comentario" class="form-textarea" rows="3" placeholder="Comparte tu experiencia con otros aventureros..."></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary" style="background:linear-gradient(135deg, #b45309, #d97706); border:none;">
                            📝 Enviar reseña
                        </button>
                    </form>
                </div>
            <?php else: ?>
                <p style="color:#94a3b8; margin-top:1rem;">Ya has valorado esta misión. ¡Gracias por tu aporte!</p>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</div>
<?php $content = ob_get_clean(); ?>
<?php require __DIR__ . '/../layouts/main.php'; ?>