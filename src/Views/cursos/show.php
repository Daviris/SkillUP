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
                <li>
                    <span class="text-amber-400">Instructor:</span> <?= htmlspecialchars($curso['instructor_nombre']) ?>
                    <?php
                        $instructor = \App\Models\Usuario::find($curso['id_instructor']);
                        $reputacion = $instructor['reputacion'] ?? 0;
                    ?>
                    <span class="text-yellow-400 ml-2">
                        <?= number_format($reputacion, 1) ?> / 5
                    </span>
                </li>
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
<!-- Reseñas -->
<div class="mt-8 pt-6 border-t border-amber-700">
    <h2 class="text-2xl font-semibold mb-4 text-amber-400">Reseñas de alumnos</h2>

    <?php
        $resenas = \App\Models\Resena::delCurso($curso['id']);
    ?>

    <?php if (!empty($resenas)): ?>
        <ul class="divide-y divide-gray-600 border border-amber-700 rounded-lg bg-gray-900/50">
            <?php foreach ($resenas as $resena): ?>
            <li class="p-4">
                <div class="flex justify-between items-start mb-2">
                    <span class="font-medium text-amber-300">
                        <?= htmlspecialchars($resena['alumno_nombre']) ?>
                    </span>
                    <span class="text-yellow-400 font-bold">
                        <?= str_repeat('★', $resena['puntuacion']) ?><?= str_repeat('☆', 5 - $resena['puntuacion']) ?>
                    </span>
                </div>
                <?php if (!empty($resena['comentario'])): ?>
                    <p class="text-gray-300 text-sm"><?= htmlspecialchars($resena['comentario']) ?></p>
                    <?php if (isset($_SESSION['usuario']) && $_SESSION['usuario']['id'] == $resena['usuario_id']): ?>
                        <div class="mt-2 flex space-x-3">
                            <a href="/resena/editar/<?= $resena['id'] ?>" class="text-amber-400 hover:text-amber-300 text-sm">Editar</a>
                            <a href="/resena/eliminar/<?= $resena['id'] ?>" onclick="return confirm('¿Eliminar esta reseña?')" class="text-red-400 hover:text-red-300 text-sm">Eliminar</a>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
                <p class="text-xs text-gray-500 mt-1"><?= date('d/m/Y', strtotime($resena['fecha'])) ?></p>
            </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p class="text-gray-400">Aún no hay reseñas.</p>
    <?php endif; ?>

    <!-- Formulario de reseña (solo para alumnos que compraron el curso y aún no lo han reseñado) -->
    <?php if (isset($_SESSION['usuario']) && $_SESSION['usuario']['rol'] === 'alumno'): ?>
        <?php
            $usuarioId = $_SESSION['usuario']['id'];
            $yaCompro = \App\Models\Pedido::usuarioTieneCurso($usuarioId, $curso['id']);
            $yaReseno = \App\Models\Resena::where('usuario_id', (string)$usuarioId) && $yaCompro;
            // Un poco más preciso:
            $yaReseno = false;
            if ($yaCompro) {
                $resenaExistente = \App\Models\Resena::where('usuario_id', (string)$usuarioId);
                $yaReseno = $resenaExistente && $resenaExistente['curso_id'] == $curso['id'];
            }
        ?>
        <?php if ($yaCompro && !$yaReseno): ?>
            <div class="mt-6 bg-gray-800 p-4 rounded-lg border border-amber-700">
                <h3 class="text-amber-400 font-semibold mb-3">Deja tu reseña</h3>
                <form action="/resena/guardar" method="POST">
                    <input type="hidden" name="curso_id" value="<?= $curso['id'] ?>">
                    <div class="mb-3">
                        <label class="block text-amber-400 text-sm mb-1">Puntuación (1-5)</label>
                        <select name="puntuacion" required class="w-full px-4 py-2 bg-gray-700 border border-amber-600 rounded text-gray-200">
                            <option value="5">★★★★★ (5)</option>
                            <option value="4">★★★★☆ (4)</option>
                            <option value="3">★★★☆☆ (3)</option>
                            <option value="2">★★☆☆☆ (2)</option>
                            <option value="1">★☆☆☆☆ (1)</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="block text-amber-400 text-sm mb-1">Comentario (opcional)</label>
                        <textarea name="comentario" rows="3" class="w-full px-4 py-2 bg-gray-700 border border-amber-600 rounded text-gray-200"></textarea>
                    </div>
                    <button type="submit" class="bg-amber-700 hover:bg-amber-600 text-white font-bold py-2 px-6 rounded border border-amber-500 shadow transition">
                        Enviar reseña
                    </button>
                </form>
            </div>
        <?php elseif ($yaReseno): ?>
            <p class="mt-4 text-sm text-gray-400">Ya has reseñado este curso.</p>
        <?php endif; ?>
    <?php endif; ?>
</div>
<?php $content = ob_get_clean(); ?>
<?php require __DIR__ . '/../layouts/main.php'; ?>