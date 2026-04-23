<?php ob_start(); ?>
<h1 class="text-4xl font-bold text-amber-300 mb-6" style="font-family: 'VT323', monospace;">Catálogo de Cursos</h1>

<form method="GET" action="/cursos" class="bg-gray-800 p-4 rounded-lg border-2 border-amber-700 shadow mb-8 flex flex-wrap gap-4 items-end">
    <div>
        <label class="block text-sm font-medium text-amber-400 mb-1">Modalidad</label>
        <select name="modalidad" class="px-4 py-2 bg-gray-700 border-2 border-amber-600 rounded text-gray-200 focus:outline-none focus:border-amber-400">
            <option value="">Todas</option>
            <option value="online" <?= ($modalidad ?? '') === 'online' ? 'selected' : '' ?>>Online</option>
            <option value="presencial" <?= ($modalidad ?? '') === 'presencial' ? 'selected' : '' ?>>Presencial</option>
        </select>
    </div>
    <div>
        <label class="block text-sm font-medium text-amber-400 mb-1">Precio máximo (€)</label>
        <input type="number" name="precio_max" value="<?= htmlspecialchars($precio_max ?? '') ?>" step="0.01"
               class="px-4 py-2 bg-gray-700 border-2 border-amber-600 rounded text-gray-200 focus:outline-none focus:border-amber-400 w-32">
    </div>
    <div>
        <button type="submit" class="bg-amber-700 hover:bg-amber-600 text-white font-bold py-2 px-6 rounded border border-amber-500 shadow transition">
            Filtrar
        </button>
    </div>
</form>

<?php if (!empty($cursos)): ?>
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    <?php foreach ($cursos as $curso): ?>
    <div class="bg-gray-800 rounded-lg border-2 border-amber-700 shadow-lg hover:shadow-amber-900/50 transition p-5 flex flex-col">
        <h3 class="text-xl font-semibold text-amber-300"><?= htmlspecialchars($curso['titulo']) ?></h3>
        <p class="text-gray-300 mt-2 flex-grow"><?= htmlspecialchars(substr($curso['descripcion'], 0, 100)) ?>...</p>
        <div class="mt-3 text-sm text-gray-400">
            <p><span class="text-amber-400">Instructor:</span> <?= htmlspecialchars($curso['instructor_nombre'] ?? 'N/A') ?></p>
            <p><span class="text-amber-400">Modalidad:</span> <?= ucfirst($curso['modalidad']) ?></p>
            <p class="text-xl font-bold text-amber-400 mt-2"><?= number_format($curso['precio'], 2) ?> €</p>
        </div>
        <a href="/cursos/<?= $curso['id'] ?>"
           class="mt-4 inline-block bg-amber-700 hover:bg-amber-600 text-white text-center font-bold py-2 px-4 rounded border border-amber-500 transition">
            Ver detalles
        </a>
    </div>
    <?php endforeach; ?>
</div>

<!-- Paginación -->
<?php if ($lastPage > 1): ?>
<div class="mt-8 flex justify-center space-x-2">
    <?php for ($i = 1; $i <= $lastPage; $i++): ?>
        <a href="/cursos?page=<?= $i ?>&<?= http_build_query(['modalidad' => $modalidad ?? '', 'precio_max' => $precio_max ?? '']) ?>"
           class="px-4 py-2 border <?= $i === $currentPage ? 'bg-amber-700 border-amber-500 text-white' : 'bg-gray-700 border-gray-600 text-gray-200 hover:bg-amber-800' ?> rounded">
            <?= $i ?>
        </a>
    <?php endfor; ?>
</div>
<?php endif; ?>

<?php else: ?>
<div class="bg-gray-800 border-2 border-dashed border-gray-600 rounded-lg p-12 text-center">
    <p class="text-gray-400 text-lg">No se encontraron cursos.</p>
</div>
<?php endif; ?>

<?php $content = ob_get_clean(); ?>
<?php require __DIR__ . '/../layouts/main.php'; ?>