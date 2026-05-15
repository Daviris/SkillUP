<?php ob_start(); ?>
<h1 class="font-rpg" style="font-size:2.5rem; color:#fbbf24; margin-bottom:1.5rem;">Catálogo de Cursos</h1>

<!-- Filtros -->
<form method="GET" action="/cursos" class="card" style="display:flex; gap:1rem; align-items:end; margin-bottom:2rem; padding:1.5rem;">
    <div class="form-group" style="flex:1;">
        <label class="form-label">Modalidad</label>
        <select name="modalidad" class="form-select">
            <option value="">Todas</option>
            <option value="online" <?= ($modalidad ?? '') === 'online' ? 'selected' : '' ?>>Online</option>
            <option value="presencial" <?= ($modalidad ?? '') === 'presencial' ? 'selected' : '' ?>>Presencial</option>
        </select>
    </div>
    <div class="form-group" style="flex:1;">
        <label class="form-label">Precio máximo (€)</label>
        <input type="number" name="precio_max" value="<?= htmlspecialchars($precio_max ?? '') ?>" step="0.01" class="form-input">
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-primary">🔍 Filtrar</button>
    </div>
</form>

<!-- Grid de cursos -->
<?php if (!empty($cursos)): ?>
    <div class="grid-3">
        <?php foreach ($cursos as $curso): ?>
            <div class="card" style="display:flex; flex-direction:column; justify-content:space-between;">
                <div>
                    <h3 class="card-title"><?= htmlspecialchars($curso['titulo']) ?></h3>
                    <p class="card-text" style="margin-bottom:1rem;">
                        <?= htmlspecialchars(substr($curso['descripcion'], 0, 100)) ?>...
                    </p>
                </div>
                <div style="font-size:0.9rem; color:#9ca3af; margin-bottom:0.5rem;">
                    <p><span style="color:#fbbf24;">Instructor:</span> <?= htmlspecialchars($curso['instructor_nombre'] ?? 'N/A') ?></p>
                    <p><span style="color:#fbbf24;">Modalidad:</span> <?= ucfirst($curso['modalidad']) ?></p>
                </div>
                <div style="display:flex; justify-content:space-between; align-items:center;">
                    <span style="font-size:1.3rem; font-weight:bold; color:#fbbf24;">
                        <?= number_format($curso['precio'], 2) ?> €
                    </span>
                    <a href="/cursos/<?= $curso['id'] ?>" class="btn btn-primary btn-sm">Ver detalles</a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Paginación -->
    <?php if ($ultimaPag > 1): ?>
        <div style="display:flex; justify-content:center; gap:0.5rem; margin-top:2rem;">
            <?php for ($i = 1; $i <= $ultimaPag; $i++): ?>
                <a href="/cursos?page=<?= $i ?>&<?= http_build_query(['modalidad' => $modalidad ?? '', 'precio_max' => $precio_max ?? '']) ?>"
                   class="btn <?= $i === $paginaActual ? 'btn-primary' : 'btn-secondary' ?> btn-sm">
                    <?= $i ?>
                </a>
            <?php endfor; ?>
        </div>
    <?php endif; ?>
<?php else: ?>
    <div class="card text-center" style="padding:3rem;">
        <p style="color:#9ca3af; font-size:1.1rem;">No se encontraron cursos.</p>
    </div>
<?php endif; ?>
<?php $content = ob_get_clean(); ?>
<?php require __DIR__ . '/../layouts/main.php'; ?>