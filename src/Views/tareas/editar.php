<?php ob_start(); ?>
<div class="max-w-xl mx-auto">
    <div class="bg-gray-800 border-2 border-amber-700 rounded-lg shadow-xl p-6">
        <h1 class="text-3xl font-bold text-amber-300 mb-6" style="font-family: 'VT323', monospace;">Modificar entrega</h1>

        <p class="text-gray-300 mb-4">Selecciona un nuevo archivo para reemplazar tu entrega actual.</p>

        <form action="/tarea/actualizar/<?= $entrega['id'] ?>" method="POST" enctype="multipart/form-data">
            <?= \App\Core\Csrf::tokenField() ?>
            <div class="mb-4">
                <label class="block text-amber-400 text-sm mb-1">Nuevo archivo</label>
                <input type="file" name="archivo" required
                       class="w-full text-gray-200 bg-gray-600 border border-amber-500 rounded p-2">
            </div>
            <div class="flex justify-end space-x-3">
                <a href="/mis-cursos/ver/<?= $entrega['clase_id'] ?>" class="bg-gray-600 hover:bg-gray-500 text-white font-bold py-2 px-6 rounded border border-gray-500 transition">Cancelar</a>
                <button type="submit" class="bg-amber-700 hover:bg-amber-600 text-white font-bold py-2 px-6 rounded border border-amber-500 shadow transition">Actualizar</button>
            </div>
        </form>
    </div>
</div>
<?php $content = ob_get_clean(); ?>
<?php require __DIR__ . '/../layouts/main.php'; ?>