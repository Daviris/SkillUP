<?php ob_start(); ?>
<h1 class="text-3xl font-bold text-amber-300 mb-6">Reseñas</h1>
<div class="overflow-x-auto">
    <table class="min-w-full bg-gray-800 border border-amber-700 rounded-lg">
        <thead class="bg-amber-900/50">
            <tr>
                <th class="py-2 px-4 text-left text-amber-300">Curso</th>
                <th class="py-2 px-4 text-left text-amber-300">Usuario</th>
                <th class="py-2 px-4 text-left text-amber-300">Puntuación</th>
                <th class="py-2 px-4 text-left text-amber-300">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($resenas as $r): ?>
            <tr class="border-b border-gray-700">
                <td class="py-2 px-4"><?= $r['curso_id'] ?></td>
                <td class="py-2 px-4"><?= $r['usuario_id'] ?></td>
                <td class="py-2 px-4"><?= str_repeat('★', $r['puntuacion']) ?></td>
                <td class="py-2 px-4">
                    <a href="/admin/resenas/eliminar/<?= $r['id'] ?>" onclick="return confirm('¿Eliminar esta reseña?')" class="text-red-400 hover:underline">Eliminar</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php $content = ob_get_clean(); ?>
<?php require __DIR__ . '/layout.php'; ?>