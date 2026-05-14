<?php ob_start(); ?>
<div class="max-w-4xl mx-auto">
    <h1 class="text-4xl font-bold text-amber-300 mb-6" style="font-family: 'VT323', monospace;">
        <?= htmlspecialchars($curso['titulo']) ?>
    </h1>

    <?php if (!empty($curso['clases'])): ?>
        <div class="space-y-8">
            <?php foreach ($curso['clases'] as $index => $clase): ?>
                <div class="bg-gray-800 border-2 border-amber-700 rounded-lg shadow-xl overflow-hidden">
                    <!-- Cabecera de la clase -->
                    <div class="bg-amber-900/50 px-6 py-4 flex justify-between items-center">
                        <h2 class="text-2xl font-bold text-amber-300">
                            <?= $clase['orden'] ?>. <?= htmlspecialchars($clase['titulo']) ?>
                        </h2>
                        <div class="flex items-center space-x-3 text-sm">
                            <span class="px-3 py-1 bg-amber-700 text-white rounded-full text-xs font-bold">
                                <?= ucfirst($clase['tipo']) ?>
                            </span>
                            <span class="text-gray-400"><?= $clase['duracion'] ?> min</span>
                        </div>
                    </div>

                    <!-- Contenido de la clase -->
                    <div class="p-6">
                        <?php if ($clase['tipo'] === 'teoria'): ?>
                            <!-- Teoría -->
                            <div class="prose prose-invert max-w-none text-gray-300">
                                <?= nl2br(htmlspecialchars($clase['contenido_texto'] ?? '')) ?>
                            </div>

                        <?php elseif ($clase['tipo'] === 'archivo'): ?>
                            <!-- Archivo descargable -->
                            <?php if (!empty($clase['archivo_id'])): ?>
                                <div class="flex items-center justify-between bg-gray-700 p-4 rounded-lg border border-amber-600">
                                    <div class="flex items-center space-x-3">
                                        <span class="text-4xl">📄</span>
                                        <div>
                                            <p class="text-amber-300 font-medium">Material de la clase</p>
                                            <p class="text-gray-400 text-sm">Descarga el archivo para estudiar</p>
                                        </div>
                                    </div>
                                    <a href="/archivo/descargar/<?= $clase['archivo_id'] ?>"
                                       class="bg-amber-700 hover:bg-amber-600 text-white font-bold py-2 px-6 rounded border border-amber-500 shadow transition">
                                        Descargar
                                    </a>
                                </div>
                            <?php else: ?>
                                <p class="text-gray-400 italic">No hay archivo adjunto para esta clase.</p>
                            <?php endif; ?>

                        <?php elseif ($clase['tipo'] === 'tarea'): ?>
                            <!-- Tarea -->
                            <?php
                                $entrega = \App\Models\Tarea::entregaAlumno($clase['id'], $_SESSION['usuario']['id']);
                                $fechaLimite = strtotime($clase['fecha_limite'] ?? '');
                                $plazoVencido = $fechaLimite && $fechaLimite < time();
                            ?>

                            <!-- Información de la tarea -->
                            <div class="bg-gray-700 p-4 rounded-lg border border-amber-600 mb-4">
                                <h3 class="text-amber-400 font-semibold mb-2">Descripción de la tarea</h3>
                                <?php if (!empty($clase['criterios_evaluacion'])): ?>
                                    <p class="text-gray-300"><?= nl2br(htmlspecialchars($clase['criterios_evaluacion'])) ?></p>
                                <?php else: ?>
                                    <p class="text-gray-500 italic">El instructor no ha añadido criterios de evaluación.</p>
                                <?php endif; ?>

                                <?php if (!empty($clase['fecha_limite'])): ?>
                                    <div class="mt-3 flex items-center space-x-2">
                                        <span class="text-amber-400">Fecha límite:</span>
                                        <span class="<?= $plazoVencido ? 'text-red-400' : 'text-green-400' ?> font-bold">
                                            <?= date('d/m/Y H:i', $fechaLimite) ?>
                                        </span>
                                        <?php if ($plazoVencido && !$entrega): ?>
                                            <span class="text-red-500 text-xs font-bold">(Vencido)</span>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <!-- Estado de la entrega -->
                            <?php if ($entrega): ?>
                                <div class="bg-green-900/50 border border-green-600 rounded-lg p-4">
                                    <h3 class="text-green-400 font-semibold mb-2">Tu entrega</h3>
                                    <p class="text-green-200 text-sm">
                                        Entregado el <?= date('d/m/Y H:i', strtotime($entrega['fecha_entrega'])) ?>
                                    </p>
                                    <?php if (!empty($entrega['archivo_id'])): ?>
                                        <a href="/archivo/descargar/<?= $entrega['archivo_id'] ?>"
                                           class="inline-block mt-2 text-amber-400 hover:underline text-sm">
                                            Ver archivo subido
                                        </a>
                                    <?php endif; ?>
                                    <?php if ($entrega['comentario_alumno']): ?>
                                        <p class="text-gray-300 mt-2 text-sm">
                                            Comentario: <?= htmlspecialchars($entrega['comentario_alumno']) ?>
                                        </p>
                                    <?php endif; ?>

                                    <?php if ($entrega['nota'] !== null): ?>
                                        <div class="mt-4 pt-3 border-t border-green-600">
                                            <p class="text-yellow-400 font-bold">Nota: <?= $entrega['nota'] ?>/10</p>
                                            <?php if ($entrega['feedback_instructor']): ?>
                                                <p class="text-gray-300 mt-1 text-sm">
                                                    <span class="text-amber-400">Feedback del instructor:</span>
                                                    <?= htmlspecialchars($entrega['feedback_instructor']) ?>
                                                </p>
                                            <?php endif; ?>
                                        </div>
                                    <?php else: ?>
                                        <!-- Opciones para modificar/eliminar (solo si no calificada) -->
                                        <div class="mt-4 pt-3 border-t border-green-600 flex space-x-4">
                                            <a href="/tarea/editar/<?= $entrega['id'] ?>"
                                               class="text-amber-400 hover:text-amber-300 text-sm font-medium">
                                                Modificar
                                            </a>
                                            <a href="/tarea/eliminar/<?= $entrega['id'] ?>"
                                               onclick="return confirm('¿Estás seguro de eliminar esta entrega?')"
                                               class="text-red-400 hover:text-red-300 text-sm font-medium">
                                                Eliminar
                                            </a>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            <?php else: ?>
                                <!-- Formulario de subida -->
                                <?php if (!$plazoVencido): ?>
                                    <div class="bg-gray-700 p-4 rounded-lg border border-amber-600">
                                        <h3 class="text-amber-400 font-semibold mb-3">Subir entrega</h3>
                                        <form action="/archivo/subir" method="POST" enctype="multipart/form-data">
                                            <input type="hidden" name="clase_id" value="<?= $clase['id'] ?>">
                                            <div class="mb-3">
                                                <label class="block text-gray-300 text-sm mb-1">Selecciona un archivo</label>
                                                <input type="file" name="archivo" required
                                                       class="w-full text-gray-200 bg-gray-600 border border-amber-500 rounded p-2">
                                            </div>
                                            <button type="submit"
                                                    class="bg-amber-700 hover:bg-amber-600 text-white font-bold py-2 px-6 rounded border border-amber-500 shadow transition">
                                                Enviar tarea
                                            </button>
                                        </form>
                                    </div>
                                <?php else: ?>
                                    <div class="bg-red-900/50 border border-red-600 rounded-lg p-4">
                                        <p class="text-red-400 font-semibold">El plazo de entrega ha finalizado.</p>
                                        <p class="text-red-200 text-sm mt-1">No puedes enviar esta tarea porque la fecha límite ya pasó.</p>
                                    </div>
                                <?php endif; ?>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="bg-gray-800 border-2 border-dashed border-amber-700 rounded-lg p-12 text-center">
            <p class="text-gray-400 text-lg">Este curso aún no tiene clases.</p>
        </div>
    <?php endif; ?>
</div>
<?php $content = ob_get_clean(); ?>
<?php require __DIR__ . '/../layouts/main.php'; ?>