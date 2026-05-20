<?php ob_start(); ?>
<div style="max-width:1200px; margin:0 auto;">
    <!-- Cabecera -->
    <div class="fade-in-up" style="margin-bottom:2rem; display:flex; justify-content:space-between; align-items:center;">
        <div>
            <h1 class="font-rpg" style="font-size:2.8rem; color:#fbbf24; margin-bottom:0.5rem; text-shadow:0 0 15px rgba(251,191,36,0.4);">
                🧙 Panel de Instructor
            </h1>
            <p style="color:#94a3b8; font-size:1.1rem;">Gestiona tus cursos y comparte tu conocimiento</p>
        </div>
        <a href="/instructor/crear" class="btn btn-primary" style="background:linear-gradient(135deg, #b45309, #d97706); border:none; padding:0.8rem 2rem; font-size:1.1rem; box-shadow:0 0 20px rgba(251,191,36,0.3);">
            + Nueva misión
        </a>
    </div>

    <!-- Mensaje flash -->
    <?php if ($mensaje = $_SESSION['mensaje'] ?? null): ?>
        <div class="fade-in-up flash-message flash-success" style="margin-bottom:1.5rem;">
            <?= htmlspecialchars($mensaje) ?>
        </div>
        <?php unset($_SESSION['mensaje']); ?>
    <?php endif; ?>

    <!-- Listado de cursos -->
    <?php if (!empty($cursos)): ?>
        <div class="fade-in-up" style="transition-delay:0.2s;">
            <div class="table-container">
                <table style="width:100%;">
                    <thead>
                        <tr>
                            <th>Título</th>
                            <th>Modalidad</th>
                            <th>Precio</th>
                            <th>Estado</th>
                            <th>Gestión</th>
                            <th style="text-align:right;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($cursos as $curso): ?>
                        <tr>
                            <td style="font-weight:600; color:#fbbf24;"><?= htmlspecialchars($curso['titulo']) ?></td>
                            <td>
                                <span class="badge" style="background:<?= $curso['modalidad'] === 'online' ? '#065f46' : '#7f1d1d' ?>; color:white;">
                                    <?= $curso['modalidad'] === 'online' ? '🌐 Online' : '🏰 Presencial' ?>
                                </span>
                            </td>
                            <td style="color:#fbbf24; font-weight:600;"><?= number_format($curso['precio'], 2) ?> €</td>
                            <td>
                                <?php
                                // Si el estado está vacío, asumimos borrador
                                $estado = !empty($curso['estado']) ? $curso['estado'] : 'borrador';
                                $colores = [
                                    'borrador'   => '#4b5563',
                                    'revision'   => '#fbbf24',
                                    'publicado'  => '#10b981',
                                    'rechazado'  => '#ef4444'
                                ];
                                ?>
                                <span class="badge" style="background:<?= $colores[$estado] ?? '#4b5563' ?>; color:white;">
                                    <?= ucfirst($estado) ?>
                                </span>
                            </td>
                            <td>
                                <?php if ($curso['modalidad'] === 'online'): ?>
                                    <a href="/instructor/cursos/<?= $curso['id'] ?>/clases" class="btn btn-secondary btn-sm">
                                        📚 Clases
                                    </a>
                                <?php else: ?>
                                    <a href="/instructor/cursos/<?= $curso['id'] ?>/asistentes" class="btn btn-secondary btn-sm">
                                        👥 Asistentes
                                    </a>
                                <?php endif; ?>
                            </td>
                            <td style="text-align:right;">
                                <div style="display:flex; gap:0.5rem; justify-content:flex-end;">
                                    <?php if ($estado === 'borrador'): ?>
                                        <a href="/instructor/enviar-revision/<?= $curso['id'] ?>" 
                                           class="btn btn-secondary btn-sm"
                                           onclick="return confirm('¿Enviar este curso a revisión?')">
                                            📤 Enviar a revisión
                                        </a>
                                    <?php endif; ?>
                                    <a href="/instructor/editar/<?= $curso['id'] ?>" class="btn btn-primary btn-sm" style="background:linear-gradient(135deg, #b45309, #d97706); border:none;">
                                        ✏️ Editar
                                    </a>
                                    <a href="/instructor/eliminar/<?= $curso['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar este curso?')">
                                        🗑️ Eliminar
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php else: ?>
        <div class="fade-in-up card" style="padding:4rem 2rem; text-align:center;">
            <p style="font-size:4rem; margin-bottom:1rem;">📜</p>
            <h2 class="font-rpg" style="font-size:2rem; color:#fbbf24; margin-bottom:0.5rem;">Aún no has creado ningún curso</h2>
            <p style="color:#94a3b8; font-size:1.1rem; margin-bottom:2rem;">Comparte tu sabiduría con el mundo y crea tu primera misión de aprendizaje.</p>
            <a href="/instructor/crear" class="btn btn-primary" style="background:linear-gradient(135deg, #b45309, #d97706); border:none; padding:0.8rem 2.5rem; font-size:1.1rem;">
                ⚔️ Crear mi primer curso
            </a>
        </div>
    <?php endif; ?>
</div>
<?php $content = ob_get_clean(); ?>
<?php require __DIR__ . '/../layouts/main.php'; ?>