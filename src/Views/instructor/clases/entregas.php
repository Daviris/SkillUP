<?php ob_start(); ?>
<div class="bg-gray-800 rounded-lg border-2 border-amber-700 shadow-xl p-6">
    <h1 class="text-4xl font-bold text-amber-300 mb-6" style="font-family: 'VT323', monospace;">
        Entregas: <?= htmlspecialchars($clase['titulo']) ?>
    </h1>

    <?php if (!empty($entregas)): ?>
    <ul class="divide-y divide-amber-700 border border-amber-700 rounded-lg">
        <?php foreach ($entregas as $entrega): ?>
        <li class="p-4 hover:bg-gray-700/50">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-gray-200 font-medium"><?= htmlspecialchars($entrega['alumno_nombre']) ?></p>
                    <p class="text-sm text-gray-400">Entregado: <?= date('d/m/Y H:i', strtotime($entrega['fecha_entrega'])) ?></p>
                    <?php if ($entrega['archivo_nombre']): ?>
                        <p class="text-sm"><a href="/archivo/descargar/<?= $entrega['archivo_id'] ?>" class="text-amber-400 hover:underline"><?= htmlspecialchars($entrega['archivo_nombre']) ?></a></p>
                    <?php endif; ?>
                    <?php if ($entrega['comentario_alumno']): ?>
                        <p class="text-sm text-gray-300 mt-1">Comentario: <?= htmlspecialchars($entrega['comentario_alumno']) ?></p>
                    <?php endif; ?>
                </div>
                <div class="text-right">
                    <?php if ($entrega['nota'] !== null): ?>
                        <div id="nota-mostrada-<?= $entrega['id'] ?>">
                            <p class="text-yellow-400 font-bold">Nota: <?= $entrega['nota'] ?></p>
                            <?php if ($entrega['feedback_instructor']): ?>
                                <p class="text-sm text-gray-300">Feedback: <?= htmlspecialchars($entrega['feedback_instructor']) ?></p>
                            <?php endif; ?>
                            <button onclick="toggleEdicion(<?= $entrega['id'] ?>)" class="mt-2 text-amber-400 hover:text-amber-300 text-sm font-medium">
                                Editar nota
                            </button>
                        </div>
                        <!-- Formulario de edición (oculto por defecto) -->
                        <div id="form-edicion-<?= $entrega['id'] ?>" class="hidden mt-2">
                            <form action="/instructor/entregas/actualizar" method="POST" class="space-y-2">
                                <input type="hidden" name="entrega_id" value="<?= $entrega['id'] ?>">
                                <input type="number" step="0.01" name="nota" value="<?= $entrega['nota'] ?>" class="w-20 px-2 py-1 bg-gray-700 border border-amber-600 rounded text-gray-200" required>
                                <textarea name="feedback" rows="2" placeholder="Feedback" class="w-40 px-2 py-1 bg-gray-700 border border-amber-600 rounded text-gray-200"><?= htmlspecialchars($entrega['feedback_instructor'] ?? '') ?></textarea>
                                <div class="flex space-x-2">
                                    <button type="submit" class="bg-green-700 hover:bg-green-600 text-white text-sm font-bold py-1 px-3 rounded">Guardar</button>
                                    <button type="button" onclick="toggleEdicion(<?= $entrega['id'] ?>)" class="bg-gray-600 hover:bg-gray-500 text-white text-sm font-bold py-1 px-3 rounded">Cancelar</button>
                                </div>
                            </form>
                        </div>
                    <?php else: ?>
                        <!-- Formulario para calificar (sin cambios) -->
                        <form action="/instructor/entregas/calificar" method="POST" class="inline-block">
                            <input type="hidden" name="entrega_id" value="<?= $entrega['id'] ?>">
                            <div class="flex items-center space-x-2">
                                <input type="number" step="0.01" name="nota" placeholder="Nota" class="w-20 px-2 py-1 bg-gray-700 border border-amber-600 rounded text-gray-200" required>
                                <textarea name="feedback" rows="1" placeholder="Feedback" class="w-32 px-2 py-1 bg-gray-700 border border-amber-600 rounded text-gray-200"></textarea>
                                <button type="submit" class="bg-green-700 hover:bg-green-600 text-white text-sm font-bold py-1 px-3 rounded">Calificar</button>
                            </div>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
        </li>
        <?php endforeach; ?>
    </ul>
    <?php else: ?>
    <div class="text-center py-12 bg-gray-900/50 rounded-lg border border-dashed border-amber-700">
        <p class="text-gray-400">Aún no hay entregas para esta tarea.</p>
    </div>
    <?php endif; ?>
</div>

<script>
function toggleEdicion(id) {
    document.getElementById('nota-mostrada-' + id).classList.toggle('hidden');
    document.getElementById('form-edicion-' + id).classList.toggle('hidden');
}
</script>

<?php $content = ob_get_clean(); ?>
<?php require __DIR__ . '/../../layouts/main.php'; ?>