<?php ob_start(); ?>
<h1 class="text-3xl font-bold text-amber-300 mb-6">Cursos</h1>

<div class="overflow-x-auto">
    <table class="min-w-full bg-gray-800 border border-amber-700 rounded-lg">
        <thead class="bg-amber-900/50">
            <tr>
                <th class="py-2 px-4 text-left text-amber-300">Título</th>
                <th class="py-2 px-4 text-left text-amber-300">Instructor</th>
                <th class="py-2 px-4 text-left text-amber-300">Precio</th>
                <th class="py-2 px-4 text-left text-amber-300">Modalidad</th>
                <th class="py-2 px-4 text-left text-amber-300">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($cursos as $curso): ?>
            <tr class="border-b border-gray-700 hover:bg-gray-700/50">
                <td class="py-2 px-4"><?= htmlspecialchars($curso['titulo']) ?></td>
                <td class="py-2 px-4"><?= htmlspecialchars($curso['instructor_nombre']) ?></td>
                <td class="py-2 px-4 text-amber-300"><?= number_format($curso['precio'], 2) ?> €</td>
                <td class="py-2 px-4"><?= ucfirst($curso['modalidad']) ?></td>
                <td class="py-2 px-4 space-x-2">
                    <a href="/admin/cursos/editar/<?= $curso['id'] ?>" class="text-amber-400 hover:underline">Editar</a>
                    <a href="/admin/cursos/eliminar/<?= $curso['id'] ?>" onclick="return confirm('¿Eliminar este curso?')" class="text-red-400 hover:underline">Eliminar</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php $content = ob_get_clean(); ?>
<?php require __DIR__ . '/layout.php'; ?>