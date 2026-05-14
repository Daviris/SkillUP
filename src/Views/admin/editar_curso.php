<?php ob_start(); ?>
<h1 class="text-3xl font-bold text-amber-300 mb-6">Editar curso</h1>
<form action="/admin/cursos/actualizar/<?= $curso['id'] ?>" method="POST" class="max-w-lg bg-gray-800 p-6 rounded-lg border border-amber-700">
    <div class="mb-4">
        <label class="block text-amber-400 text-sm mb-1">Título</label>
        <input type="text" name="titulo" value="<?= htmlspecialchars($curso['titulo']) ?>" required class="w-full px-4 py-2 bg-gray-700 border border-amber-600 rounded text-gray-200">
    </div>
    <div class="mb-4">
        <label class="block text-amber-400 text-sm mb-1">Descripción</label>
        <textarea name="descripcion" rows="4" required class="w-full px-4 py-2 bg-gray-700 border border-amber-600 rounded text-gray-200"><?= htmlspecialchars($curso['descripcion']) ?></textarea>
    </div>
    <div class="mb-4">
        <label class="block text-amber-400 text-sm mb-1">Precio</label>
        <input type="number" step="0.01" name="precio" value="<?= $curso['precio'] ?>" required class="w-full px-4 py-2 bg-gray-700 border border-amber-600 rounded text-gray-200">
    </div>
    <div class="mb-4">
        <label class="block text-amber-400 text-sm mb-1">Modalidad</label>
        <select name="modalidad" class="w-full px-4 py-2 bg-gray-700 border border-amber-600 rounded text-gray-200">
            <option value="online" <?= $curso['modalidad'] === 'online' ? 'selected' : '' ?>>Online</option>
            <option value="presencial" <?= $curso['modalidad'] === 'presencial' ? 'selected' : '' ?>>Presencial</option>
        </select>
    </div>
    <div class="mb-4">
        <label class="block text-amber-400 text-sm mb-1">Instructor</label>
        <select name="id_instructor" class="w-full px-4 py-2 bg-gray-700 border border-amber-600 rounded text-gray-200">
            <?php foreach ($instructores as $instructor): ?>
                <option value="<?= $instructor['id'] ?>" <?= $instructor['id'] == $curso['id_instructor'] ? 'selected' : '' ?>><?= htmlspecialchars($instructor['nombre']) ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <button type="submit" class="bg-amber-700 hover:bg-amber-600 text-white font-bold py-2 px-6 rounded border border-amber-500 shadow transition">Actualizar</button>
</form>
<?php $content = ob_get_clean(); ?>
<?php require __DIR__ . '/layout.php'; ?>