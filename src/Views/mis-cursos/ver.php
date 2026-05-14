<?php ob_start(); ?>
<div class="max-w-4xl mx-auto">
    <h1 class="text-4xl font-bold text-amber-300 mb-6" style="font-family: 'VT323', monospace;">
        <?= htmlspecialchars($curso['titulo']) ?>
    </h1>

    <?php if (!empty($curso['clases'])): ?>
        <div class="space-y-4">
            <?php foreach ($curso['clases'] as $clase): ?>
                <a href="/mis-cursos/clase/<?= $clase['id'] ?>" 
                   class="block bg-gray-800 border-2 border-amber-700 rounded-lg p-5 hover:bg-gray-700 transition">
                    <div class="flex justify-between items-center">
                        <div>
                            <h2 class="text-xl font-semibold text-amber-300">
                                <?= $clase['orden'] ?>. <?= htmlspecialchars($clase['titulo']) ?>
                            </h2>
                            <p class="text-gray-400 text-sm mt-1"><?= $clase['duracion'] ?> minutos</p>
                        </div>
                        <span class="px-3 py-1 bg-amber-700 text-white rounded-full text-xs font-bold">
                            <?= ucfirst($clase['tipo']) ?>
                        </span>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
        <!-- Sección de reseñas (desde Mis Cursos) -->
        <div class="mt-8 pt-6 border-t border-amber-700">
            <h2 class="text-2xl font-semibold mb-4 text-amber-400">Reseñas de alumnos</h2>

            <?php
                $resenas = \App\Models\Resena::delCurso($curso['id']);
            ?>

            <?php if (!empty($resenas)): ?>
                <ul class="divide-y divide-gray-600 border border-amber-700 rounded-lg bg-gray-900/50 mb-6">
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
                        <?php endif; ?>
                        <p class="text-xs text-gray-500 mt-1"><?= date('d/m/Y', strtotime($resena['fecha'])) ?></p>
                    </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p class="text-gray-400 mb-6">Aún no hay reseñas.</p>
            <?php endif; ?>

            <!-- Formulario de reseña (solo si no ha reseñado) -->
            <?php
                $yaReseno = \App\Models\Resena::buscarPorUsuarioYCurso($_SESSION['usuario']['id'], $curso['id']);
            ?>
            <?php if (!$yaReseno): ?>
                <div class="bg-gray-800 p-4 rounded-lg border border-amber-700">
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
            <?php else: ?>
                <p class="mt-4 text-sm text-gray-400">Ya has reseñado este curso.</p>
            <?php endif; ?>
        </div>
    <?php else: ?>
        <p class="text-gray-400">Este curso aún no tiene clases.</p>
    <?php endif; ?>
</div>
<?php $content = ob_get_clean(); ?>
<?php require __DIR__ . '/../layouts/main.php'; ?>