<?php ob_start(); ?>
<div class="max-w-xl mx-auto">
    <div class="bg-gray-800 border-2 border-amber-700 rounded-lg shadow-xl p-6">
        <h1 class="text-3xl font-bold text-amber-300 mb-6" style="font-family: 'VT323', monospace;">Editar reseña</h1>
        <form action="/resena/actualizar/<?= $resena['id'] ?>" method="POST">
            <div class="mb-4">
                <label class="block text-amber-400 text-sm mb-1">Puntuación</label>
                <select name="puntuacion" required class="w-full px-4 py-2 bg-gray-700 border border-amber-600 rounded text-gray-200">
                    <?php for ($i = 5; $i >= 1; $i--): ?>
                        <option value="<?= $i ?>" <?= $resena['puntuacion'] == $i ? 'selected' : '' ?>>
                            <?= str_repeat('★', $i) ?><?= str_repeat('☆', 5 - $i) ?> (<?= $i ?>)
                        </option>
                    <?php endfor; ?>
                </select>
            </div>
            <div class="mb-4">
                <label class="block text-amber-400 text-sm mb-1">Comentario</label>
                <textarea name="comentario" rows="4" class="w-full px-4 py-2 bg-gray-700 border border-amber-600 rounded text-gray-200"><?= htmlspecialchars($resena['comentario'] ?? '') ?></textarea>
            </div>
            <div class="flex justify-end space-x-3">
                <a href="/cursos/<?= $resena['curso_id'] ?>" class="bg-gray-600 hover:bg-gray-500 text-white font-bold py-2 px-6 rounded border border-gray-500 transition">Cancelar</a>
                <button type="submit" class="bg-amber-700 hover:bg-amber-600 text-white font-bold py-2 px-6 rounded border border-amber-500 shadow transition">Actualizar</button>
            </div>
        </form>
    </div>
</div>
<?php $content = ob_get_clean(); ?>
<?php require __DIR__ . '/../layouts/main.php'; ?>