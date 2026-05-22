<?php ob_start(); ?>
<div style="max-width:1200px; margin:0 auto;">
    <!-- Cabecera con estadísticas -->
    <div class="fade-in-up" style="margin-bottom: 2rem;">
        <h1 class="font-rpg" style="font-size: 2.8rem; color: #fbbf24; margin-bottom: 0.5rem; text-shadow: 0 0 15px rgba(251,191,36,0.4);">
            <i class="fa-solid fa-map"></i> Tablón de Misiones
        </h1>
        <p style="color: #94a3b8; font-size: 1.1rem;">
            Explora las misiones disponibles y comienza tu aventura de aprendizaje
        </p>
    </div>

    <!-- Último curso visitado con JS -->
     <div id="ultimo-curso-visitado" style="display: none; margin-bottom: 1.5rem;"></div>

    <!-- Barra de filtros mejorada (con búsqueda) -->
    <form method="GET" action="/cursos" id="catalog-form" class="fade-in-up" style="transition-delay: 0.2s; background: linear-gradient(135deg, #1e293b, #0f172a); border: 2px solid #334155; border-radius: 1rem; padding: 1.5rem; margin-bottom: 2rem; display: flex; gap: 1rem; align-items: end; flex-wrap: wrap;">
        <?= \App\Core\Csrf::tokenField() ?>
        <!-- Búsqueda por texto -->
        <div style="flex: 2; min-width: 200px;">
            <label class="form-label" style="color: #94a3b8; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 1px;"><i class="fa-solid fa-magnifying-glass"></i> Buscar por título o descripción</label>
            <input type="text" name="busqueda" value="<?= htmlspecialchars($busqueda ?? '') ?>" class="form-input" placeholder="Escribe lo que quieres aprender..." style="background: #0f172a; border-color: #334155;">
        </div>
        <div style="flex: 1; min-width: 150px;">
            <label class="form-label" style="color: #94a3b8; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 1px;">Tipo de Misión</label>
            <select name="modalidad" class="form-select" style="background: #0f172a; border-color: #334155;">
                <option value="">Todas las misiones</option>
                <option value="online" <?= ($modalidad ?? '') === 'online' ? 'selected' : '' ?>><i class="fa-solid fa-globe"></i> Online (Remota)</option>
                <option value="presencial" <?= ($modalidad ?? '') === 'presencial' ? 'selected' : '' ?>><i class="fa-solid fa-dungeon"></i> Presencial (En persona)</option>
            </select>
        </div>
        <div style="flex: 1; min-width: 150px;">
            <label class="form-label" style="color: #94a3b8; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 1px;">Oro máximo (€)</label>
            <input type="number" name="precio_max" value="<?= htmlspecialchars($precio_max ?? '') ?>" step="0.01" class="form-input" placeholder="Sin límite" style="background: #0f172a; border-color: #334155;">
        </div>
        <div style="display: flex; gap: 0.5rem;">
            <button type="submit" class="btn btn-primary" style="padding: 0.7rem 2rem; font-size: 1rem; background: linear-gradient(135deg, #b45309, #d97706); border: none; box-shadow: 0 0 20px rgba(251,191,36,0.2);">
                <i class="fa-solid fa-magnifying-glass"></i> Buscar
            </button>
            <?php if (!empty($modalidad) || !empty($precio_max) || !empty($busqueda)): ?>
                <a href="/cursos" class="btn btn-secondary" style="padding: 0.7rem 1.5rem;">✕ Limpiar</a>
            <?php endif; ?>
        </div>
    </form>

    <!-- Grid de cursos -->
    <?php if (!empty($cursos)): ?>
        <div id="cursos-grid" style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.5rem;">
            <?php foreach ($cursos as $index => $curso): ?>
                <div class="course-card fade-in-up" style="transition-delay: <?= 0.1 * $index ?>s; display: flex; flex-direction: column; height: 100%;">
                    <!-- Icono de portada -->
                    <div class="course-cover" style="background: linear-gradient(135deg, <?= $curso['modalidad'] === 'online' ? '#1e3a5f, #0f172a' : '#5f1e1e, #0f172a' ?>); height: 120px; display: flex; align-items: center; justify-content: center; font-size: 3rem; border-radius: 0.75rem 0.75rem 0 0; position: relative; overflow: hidden;">
                        <?php if ($curso['modalidad'] === 'online'): ?>
                            <i class="fa-solid fa-globe"></i>
                        <?php else: ?>
                            <i class="fa-solid fa-dungeon"></i>
                        <?php endif; ?>
                        <!-- Badge de modalidad -->
                        <span class="badge" style="position: absolute; top: 0.75rem; left: 0.75rem; background: <?= $curso['modalidad'] === 'online' ? '#065f46' : '#7f1d1d' ?>; color: white; font-size: 0.7rem;">
                            <?= $curso['modalidad'] === 'online' ? 'Online' : 'Presencial' ?>
                        </span>
                        <?php if (isset($curso['plazas']) && $curso['modalidad'] === 'presencial'): ?>
                            <span class="badge" style="position: absolute; top: 0.75rem; right: 0.75rem; background: <?= ($curso['compradores'] ?? 0) >= $curso['plazas'] ? '#7f1d1d' : '#065f46' ?>; color: white; font-size: 0.7rem;">
                                <?= ($curso['compradores'] ?? 0) >= $curso['plazas'] ? 'Completo' : ($curso['compradores'] ?? 0) . '/' . $curso['plazas'] . ' plazas' ?>
                            </span>
                        <?php endif; ?>
                    </div>
                    <!-- Contenido de la tarjeta (flexible) -->
                    <div style="padding: 1.25rem; background: #1e293b; border-radius: 0 0 0.75rem 0.75rem; border: 1px solid #334155; border-top: none; flex: 1; display: flex; flex-direction: column;">
                        <h3 class="card-title" style="font-size: 1.2rem; margin-bottom: 0.5rem;">
                            <?= htmlspecialchars($curso['titulo']) ?>
                        </h3>
                        <p style="color: #94a3b8; font-size: 0.9rem; margin-bottom: 0.75rem; line-height: 1.4;">
                            <?= htmlspecialchars(substr($curso['descripcion'], 0, 90)) ?>...
                        </p>
                        <!-- Instructor y valoración -->
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.75rem; font-size: 0.85rem;">
                            <span style="color: #94a3b8;">
                                <i class="fa-solid fa-hat-wizard"></i> <?= htmlspecialchars($curso['instructor_nombre'] ?? 'N/A') ?>
                            </span>
                            <span style="color: #fbbf24;">
                                <i class="fa-regular fa-star"></i> <?= number_format($curso['media_resenas'] ?? 0, 1) ?>
                            </span>
                        </div>
                        <!-- Precio y botón (empujados al fondo) -->
                        <div style="margin-top: auto; display: flex; justify-content: space-between; align-items: center;">
                            <span style="font-size: 1.5rem; font-weight: bold; color: #fbbf24;">
                                <?= number_format($curso['precio'], 2) ?> €
                            </span>
                            <a href="/cursos/<?= $curso['id'] ?>" class="btn btn-primary btn-sm" style="background: linear-gradient(135deg, #b45309, #d97706); border: none;">
                                Ver misión →
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Paginación -->
        <?php if ($ultimaPag > 1): ?>
            <div style="display: flex; justify-content: center; gap: 0.5rem; margin-top: 2.5rem;">
                <?php for ($i = 1; $i <= $ultimaPag; $i++): ?>
                    <a href="/cursos?page=<?= $i ?>&<?= http_build_query(['modalidad' => $modalidad ?? '', 'precio_max' => $precio_max ?? '', 'busqueda' => $busqueda ?? '']) ?>"
                       style="display: inline-flex; align-items: center; justify-content: center; width: 2.5rem; height: 2.5rem; border-radius: 0.5rem; font-weight: 600; text-decoration: none; transition: all 0.2s; <?= $i === $paginaActual ? 'background: #b45309; color: white; border: 1px solid #d97706;' : 'background: #1e293b; color: #94a3b8; border: 1px solid #334155;' ?>">
                        <?= $i ?>
                    </a>
                <?php endfor; ?>
            </div>
        <?php endif; ?>
    <?php else: ?>
        <div class="fade-in-up" style="text-align: center; padding: 4rem 2rem; background: #1e293b; border: 2px solid #334155; border-radius: 1rem;">
            <span style="font-size: 4rem; display: block; margin-bottom: 1rem;"><i class="fa-solid fa-scroll"></i></span>
            <h3 style="font-size: 1.5rem; color: #fbbf24; margin-bottom: 0.5rem;">No se encontraron misiones</h3>
            <p style="color: #94a3b8;">Prueba a ajustar los filtros o vuelve más tarde para nuevas aventuras.</p>
        </div>
    <?php endif; ?>
</div>
<?php $content = ob_get_clean(); ?>
<?php require __DIR__ . '/../layouts/main.php'; ?>