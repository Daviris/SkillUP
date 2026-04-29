<?php ob_start(); ?>
<div class="max-w-3xl mx-auto">
    <div class="bg-gray-800 rounded-lg border-2 border-amber-700 shadow-xl p-6">
        <h1 class="text-3xl font-bold text-amber-300 mb-6" style="font-family: 'VT323', monospace;">
            <?= $accion ?? 'Crear' ?> curso
        </h1>

        <form method="POST" action="<?= $accion === 'Crear' ? '/instructor/guardar' : '/instructor/actualizar/' . ($curso['id'] ?? '') ?>">
            <div class="mb-5">
                <label class="block text-amber-400 text-sm font-medium mb-1">Título</label>
                <input type="text" name="titulo" value="<?= htmlspecialchars($curso['titulo'] ?? '') ?>"
                       class="w-full px-4 py-2 bg-gray-700 border-2 border-amber-600 rounded text-gray-200 focus:outline-none focus:border-amber-400 transition"
                       required>
            </div>
            <div class="mb-5">
                <label class="block text-amber-400 text-sm font-medium mb-1">Descripción</label>
                <textarea name="descripcion" rows="4"
                          class="w-full px-4 py-2 bg-gray-700 border-2 border-amber-600 rounded text-gray-200 focus:outline-none focus:border-amber-400 transition"
                          required><?= htmlspecialchars($curso['descripcion'] ?? '') ?></textarea>
            </div>
            <div class="grid grid-cols-2 gap-5">
                <div class="mb-5">
                    <label class="block text-amber-400 text-sm font-medium mb-1">Precio (€)</label>
                    <input type="number" step="0.01" name="precio" value="<?= htmlspecialchars($curso['precio'] ?? '') ?>"
                           class="w-full px-4 py-2 bg-gray-700 border-2 border-amber-600 rounded text-gray-200 focus:outline-none focus:border-amber-400 transition"
                           required>
                </div>
                <div class="mb-5">
                    <label class="block text-amber-400 text-sm font-medium mb-1">Modalidad</label>
                    <select name="modalidad"
                            class="w-full px-4 py-2 bg-gray-700 border-2 border-amber-600 rounded text-gray-200 focus:outline-none focus:border-amber-400 transition"
                            required>
                        <option value="online" <?= (isset($curso['modalidad']) && $curso['modalidad'] === 'online') ? 'selected' : '' ?>>Online</option>
                        <option value="presencial" <?= (isset($curso['modalidad']) && $curso['modalidad'] === 'presencial') ? 'selected' : '' ?>>Presencial</option>
                    </select>
                </div>
            </div>
            <div class="flex justify-end space-x-3 mt-6">
                <a href="/instructor" class="bg-gray-600 hover:bg-gray-500 text-white font-bold py-2 px-6 rounded border border-gray-500 transition">
                    Cancelar
                </a>
                <button type="submit" class="bg-amber-700 hover:bg-amber-600 text-white font-bold py-2 px-6 rounded border border-amber-500 shadow transition">
                    <?= $accion ?? 'Guardar' ?>
                </button>
            </div>
        </form>
    </div>
</div>
<?php $content = ob_get_clean(); ?>
<?php require __DIR__ . '/../layouts/main.php'; ?>