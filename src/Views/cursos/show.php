<?php ob_start(); ?>
<div class="bg-gray-800 rounded-lg border-2 border-amber-700 shadow-xl p-6">
    <div class="mb-6">
        <h1 class="text-4xl font-bold text-amber-300" style="font-family: 'VT323', monospace;"><?= htmlspecialchars($curso['titulo']) ?></h1>
        <p class="text-gray-300 mt-2"><?= htmlspecialchars($curso['descripcion']) ?></p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <div>
            <h2 class="text-2xl font-semibold mb-3 text-amber-400">Detalles del curso</h2>
            <ul class="space-y-2 text-gray-200">
                <li><span class="text-amber-400">Instructor:</span> <?= htmlspecialchars($curso['instructor_nombre']) ?></li>
                <li><span class="text-amber-400">Modalidad:</span> <?= ucfirst($curso['modalidad']) ?></li>
                <li><span class="text-amber-400">Precio:</span> <span class="text-amber-300 font-bold"><?= number_format($curso['precio'], 2) ?> €</span></li>
                <li><span class="text-amber-400">Duración total:</span> <?= array_sum(array_column($curso['clases'] ?? [], 'duracion')) ?> minutos</li>
                <li><span class="text-amber-400">Clases:</span> <?= count($curso['clases'] ?? []) ?></li>
            </ul>

            <?php if (isset($_SESSION['usuario']) && $_SESSION['usuario']['rol'] === 'alumno' && !$yaComprado): ?>
                <a href="/carrito/agregar/<?= htmlspecialchars($curso['id']) ?>" class="mt-6 inline-block bg-amber-700 hover:bg-amber-600 text-white font-bold py-3 px-8 rounded border border-amber-500 shadow-lg transition transform hover:scale-105">
                    Añadir a la mochila
                </a>
            <?php elseif (isset($_SESSION['usuario']) && $yaComprado): ?>
                <div class="mt-6 p-4 bg-green-900/50 border border-green-600 rounded text-green-200">
                    Ya has adquirido este curso.
                </div>
            <?php elseif (!isset($_SESSION['usuario'])): ?>
                <div class="mt-6 p-4 bg-gray-700 border border-amber-600 rounded">
                    <p class="text-gray-300"><a href="/login" class="font-medium text-amber-400 hover:underline">Inicia sesión</a> para comprar este curso.</p>
                </div>
            <?php endif; ?>
        </div>

        <div>
            <h2 class="text-2xl font-semibold mb-3 text-amber-400">Contenido del curso</h2>
            <?php if (!empty($curso['clases'])): ?>
            <ul class="divide-y divide-gray-600 border border-amber-700 rounded-lg bg-gray-900/50">
                <?php foreach ($curso['clases'] as $clase): ?>
                <li class="p-4 hover:bg-gray-700/50 transition">
                    <div class="flex justify-between items-start">
                        <div>
                            <span class="font-medium text-amber-300">
                                <?= $clase['orden'] ?>. <?= htmlspecialchars($clase['titulo']) ?>
                            </span>
                            <span class="text-xs text-gray-500 ml-2">(<?= ucfirst($clase['tipo']) ?>)</span>
                            <?php if ($clase['tipo'] === 'teoria' && !empty($clase['contenido_texto'])): ?>
                                <p class="text-sm text-gray-400 mt-1">
                                    <?= htmlspecialchars(substr($clase['contenido_texto'], 0, 80)) ?>...
                                </p>
                            <?php elseif ($clase['tipo'] === 'archivo' && !empty($clase['archivo_id'])): ?>
                                <p class="text-sm text-gray-400 mt-1">Material descargable</p>
                            <?php elseif ($clase['tipo'] === 'tarea' && !empty($clase['criterios_evaluacion'])): ?>
                                <p class="text-sm text-gray-400 mt-1">
                                    <?= htmlspecialchars(substr($clase['criterios_evaluacion'], 0, 80)) ?>...
                                </p>
                            <?php else: ?>
                                <p class="text-sm text-gray-500 mt-1 italic">Sin descripción</p>
                            <?php endif; ?>
                        </div>
                        <span class="text-sm text-gray-400 whitespace-nowrap ml-4"><?= $clase['duracion'] ?> min</span>
                    </div>
                </li>
                <?php endforeach; ?>
            </ul>
            <?php else: ?>
            <p class="text-gray-400">Este curso aún no tiene clases publicadas.</p>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $content = ob_get_clean(); ?>
<?php require __DIR__ . '/../layouts/main.php'; ?>