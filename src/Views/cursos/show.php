<?php ob_start(); ?>
<div style="max-width:1100px; margin:0 auto;">
    <!-- Migas de pan -->
    <div class="fade-in-up" style="margin-bottom:1.5rem; color:#94a3b8; font-size:0.9rem;">
        <a href="/cursos" style="color:#fbbf24;">🗺️ Tablón de Misiones</a> /
        <span style="color:#e5e7eb;"><?= htmlspecialchars($curso['titulo']) ?></span>
    </div>

    <!-- Cabecera del curso -->
    <div class="fade-in-up card" style="padding:2.5rem; margin-bottom:2rem; background: linear-gradient(135deg, <?= $curso['modalidad'] === 'online' ? '#1e3a5f, #0f172a' : '#5f1e1e, #0f172a' ?>); border:2px solid #b45309; position:relative; overflow:hidden;">
        <!-- Efecto de partículas decorativas -->
        <div style="position:absolute; top:0; left:0; right:0; bottom:0; background:radial-gradient(circle at 80% 20%, rgba(251,191,36,0.1) 0%, transparent 50%); pointer-events:none;"></div>
        
        <div style="position:relative; z-index:2;">
            <div style="display:flex; justify-content:space-between; align-items:start; flex-wrap:wrap; gap:1.5rem;">
                <div style="flex:1; min-width:300px;">
                    <div style="display:flex; align-items:center; gap:0.75rem; margin-bottom:1rem;">
                        <span class="badge" style="background:<?= $curso['modalidad'] === 'online' ? '#065f46' : '#7f1d1d' ?>; font-size:0.8rem;">
                            <?= $curso['modalidad'] === 'online' ? '🌐 Online' : '🏰 Presencial' ?>
                        </span>
                        <?php if ($completo): ?>
                            <span class="badge" style="background:#7f1d1d; font-size:0.8rem;">⚠️ Completo</span>
                        <?php endif; ?>
                    </div>
                    <h1 class="font-rpg" style="font-size:2.8rem; color:#fbbf24; margin-bottom:1rem; text-shadow:0 0 20px rgba(251,191,36,0.4);">
                        <?= htmlspecialchars($curso['titulo']) ?>
                    </h1>
                    <p style="color:#cbd5e1; font-size:1.1rem; line-height:1.6; margin-bottom:1.5rem;">
                        <?= htmlspecialchars($curso['descripcion']) ?>
                    </p>
                    
                    <!-- Instructor con reputación -->
                    <div style="display:flex; align-items:center; gap:1rem; margin-top:1rem;">
                        <div style="font-size:2.5rem;">🧙</div>
                        <div>
                            <a href="/instructor/<?= $curso['id_instructor'] ?>" style="color:#fbbf24; font-weight:600; font-size:1.1rem; text-decoration:underline;">
                                <?= htmlspecialchars($curso['instructor_nombre']) ?>
                            </a>
                            <?php
                                $instructor = \App\Models\Usuario::find($curso['id_instructor']);
                                $reputacion = $instructor['reputacion'] ?? 0;
                            ?>
                            <div style="color:#fbbf24; font-size:0.9rem;">
                                <?= str_repeat('★', (int) round($reputacion)) ?><?= str_repeat('☆', 5 - (int) round($reputacion)) ?>
                                <span style="color:#94a3b8;">(<?= number_format($reputacion, 1) ?>)</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Tarjeta de precio y acción -->
                <div style="background:#0f172a; border:1px solid #b45309; border-radius:1rem; padding:2rem; text-align:center; min-width:250px;">
                    <div style="font-size:3rem; color:#fbbf24; font-weight:bold; margin-bottom:0.5rem;">
                        <?= number_format($curso['precio'], 2) ?> €
                    </div>
                    <p style="color:#94a3b8; margin-bottom:1.5rem;">Inversión única</p>
                    
                    <?php if (isset($_SESSION['usuario']) && $_SESSION['usuario']['rol'] === 'alumno' && !$yaComprado): ?>
                        <?php if ($completo): ?>
                            <div class="flash-message flash-error" style="text-align:center;">
                                No quedan plazas disponibles
                            </div>
                        <?php else: ?>
                            <a href="/carrito/agregar/<?= $curso['id'] ?>" class="btn btn-primary" style="width:100%; padding:1rem; font-size:1.1rem; background:linear-gradient(135deg, #b45309, #d97706); border:none; box-shadow:0 0 25px rgba(251,191,36,0.3);">
                                ⚔️ Añadir a la mochila
                            </a>
                        <?php endif; ?>
                    <?php elseif (isset($_SESSION['usuario']) && $yaComprado): ?>
                        <div class="flash-message flash-success" style="text-align:center;">
                            ✅ Ya has adquirido este curso
                        </div>
                    <?php else: ?>
                        <a href="/login" class="btn btn-primary" style="width:100%; padding:1rem; font-size:1.1rem; background:linear-gradient(135deg, #b45309, #d97706); border:none;">
                            🔐 Inicia sesión para comprar
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <div style="display:grid; grid-template-columns: minmax(300px, 1fr) 1fr; gap:2rem;">
        <!-- Detalles del curso -->
        <div class="fade-in-up" style="transition-delay:0.2s;">
            <div class="card" style="padding:2rem;">
                <h2 class="font-rpg" style="font-size:1.8rem; color:#fbbf24; margin-bottom:1.5rem;">📋 Detalles de la Misión</h2>
                
                <div style="display:grid; gap:1rem;">
                    <!-- Modalidad -->
                    <div style="display:flex; align-items:center; gap:1rem; padding:1rem; background:#0f172a; border-radius:0.5rem; border:1px solid #334155;">
                        <span style="font-size:1.5rem;"><?= $curso['modalidad'] === 'online' ? '🌐' : '🏰' ?></span>
                        <div>
                            <div style="color:#fbbf24; font-weight:600;">Modalidad</div>
                            <div style="color:#94a3b8;"><?= ucfirst($curso['modalidad']) ?></div>
                        </div>
                    </div>
                    
                    <?php if ($curso['modalidad'] === 'online'): ?>
                        <!-- Duración y clases -->
                        <div style="display:grid; grid-template-columns:1fr 1fr; gap:1rem;">
                            <div style="padding:1rem; background:#0f172a; border-radius:0.5rem; border:1px solid #334155;">
                                <div style="font-size:1.5rem; margin-bottom:0.25rem;">⏱️</div>
                                <div style="color:#fbbf24; font-weight:600;"><?= array_sum(array_column($curso['clases'] ?? [], 'duracion')) ?> min</div>
                                <div style="color:#94a3b8; font-size:0.9rem;">Duración total</div>
                            </div>
                            <div style="padding:1rem; background:#0f172a; border-radius:0.5rem; border:1px solid #334155;">
                                <div style="font-size:1.5rem; margin-bottom:0.25rem;">📚</div>
                                <div style="color:#fbbf24; font-weight:600;"><?= count($curso['clases'] ?? []) ?></div>
                                <div style="color:#94a3b8; font-size:0.9rem;">Clases</div>
                            </div>
                        </div>
                    <?php else: ?>
                        <!-- Información presencial compacta -->
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
                                    <div style="color:<?= $completo ? '#ef4444' : '#fbbf24' ?>; font-weight:600;">
                                        <?= $completo ? 'Completo' : ($curso['compradores'] ?? 0) . ' / ' . $curso['plazas'] . ' plazas' ?>
                                    </div>
                                    <div style="color:#94a3b8; font-size:0.8rem;">Plazas</div>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Contenido del curso -->
        <div class="fade-in-up" style="transition-delay:0.3s;">
            <?php if ($curso['modalidad'] === 'online'): ?>
                <div class="card" style="padding:2rem;">
                    <h2 class="font-rpg" style="font-size:1.8rem; color:#fbbf24; margin-bottom:1.5rem;">📖 Contenido del Curso</h2>
                    <?php if (!empty($curso['clases'])): ?>
                        <div style="display:grid; gap:0.75rem;">
                            <?php foreach ($curso['clases'] as $clase): ?>
                                <div style="padding:1rem; background:#0f172a; border:1px solid #334155; border-radius:0.5rem; display:flex; justify-content:space-between; align-items:center; transition:border-color 0.2s;">
                                    <div>
                                        <div style="display:flex; align-items:center; gap:0.75rem;">
                                            <span style="color:#fbbf24; font-weight:600;">
                                                <?= $clase['orden'] ?>. <?= htmlspecialchars($clase['titulo']) ?>
                                            </span>
                                            <span class="badge" style="background:<?= $clase['tipo'] === 'teoria' ? '#065f46' : ($clase['tipo'] === 'tarea' ? '#7f1d1d' : '#b45309') ?>; font-size:0.7rem;">
                                                <?= ucfirst($clase['tipo']) ?>
                                            </span>
                                        </div>
                                        <?php if ($clase['tipo'] === 'teoria' && !empty($clase['contenido_texto'])): ?>
                                            <p style="color:#94a3b8; font-size:0.85rem; margin-top:0.25rem;">
                                                <?= htmlspecialchars(substr($clase['contenido_texto'], 0, 100)) ?>...
                                            </p>
                                        <?php endif; ?>
                                    </div>
                                    <span style="color:#94a3b8; font-size:0.85rem;"><?= $clase['duracion'] ?> min</span>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <p style="color:#94a3b8;">Este curso aún no tiene clases publicadas.</p>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

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
            <p style="color:#94a3b8; margin-bottom:2rem;">Aún no hay reseñas para esta misión. ¡Sé el primero en valorarla!</p>
        <?php endif; ?>

        <!-- Formulario de reseña -->
        <?php if (isset($_SESSION['usuario']) && $_SESSION['usuario']['rol'] === 'alumno'): ?>
            <?php
                $usuarioId = $_SESSION['usuario']['id'];
                $yaCompro = \App\Models\Pedido::usuarioTieneCurso($usuarioId, $curso['id']);
                $yaReseno = \App\Models\Resena::buscarPorUsuarioYCurso($usuarioId, $curso['id']);
            ?>
            <?php if ($yaCompro && !$yaReseno): ?>
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
            <?php elseif ($yaReseno): ?>
                <p style="color:#94a3b8; margin-top:1rem;">Ya has valorado esta misión. ¡Gracias por tu aporte!</p>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</div>
<?php $content = ob_get_clean(); ?>
<?php require __DIR__ . '/../layouts/main.php'; ?>