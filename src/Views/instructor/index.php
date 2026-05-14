<?php ob_start(); ?>
<div class="bg-gray-800 rounded-lg border-2 border-amber-700 shadow-xl p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-4xl font-bold text-amber-300" style="font-family: 'VT323', monospace;">Mis Cursos</h1>
        <a href="/instructor/crear" class="bg-amber-700 hover:bg-amber-600 text-white font-bold px-4 py-2 rounded border border-amber-500 shadow transition">
            + Nuevo curso
        </a>
    </div>

    <?php if (!empty($cursos)): ?>
    <div class="overflow-x-auto">
        <table class="min-w-full bg-gray-900/50 border border-amber-700 rounded-lg">
            <thead class="bg-amber-900/50">
                <tr>
                    <th class="py-3 px-4 text-left text-sm font-medium text-amber-300">Título</th>
                    <th class="py-3 px-4 text-left text-sm font-medium text-amber-300">Modalidad</th>
                    <th class="py-3 px-4 text-left text-sm font-medium text-amber-300">Precio</th>
                    <th class="py-3 px-4 text-left text-sm font-medium text-amber-300">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-amber-700">
                <?php foreach ($cursos as $c): ?>
                <tr class="hover:bg-gray-700/50 transition">
                    <td class="py-3 px-4 text-gray-200"><?= htmlspecialchars($c['titulo']) ?></td>
                    <td class="py-3 px-4 text-gray-200"><?= ucfirst($c['modalidad']) ?></td>
                    <td class="py-3 px-4 text-amber-300 font-bold"><?= number_format($c['precio'], 2) ?> €</td>
                    <td class="py-3 px-4">
                        <div class="flex space-x-3">
                            <a href="/instructor/editar/<?= $c['id'] ?>" class="text-amber-400 hover:text-amber-300 font-medium transition">Editar</a>
                            <a href="/instructor/eliminar/<?= $c['id'] ?>" onclick="return confirm('¿Eliminar este curso?')" class="text-red-400 hover:text-red-300 font-medium transition">Eliminar</a>
                            <a href="/instructor/cursos/<?= $c['id'] ?>/clases" class="text-amber-400 hover:underline">Clases</a>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php else: ?>
    <div class="text-center py-12 bg-gray-900/50 rounded-lg border border-dashed border-amber-700">
        <p class="text-gray-400">Aún no has creado ningún curso.</p>
    </div>
    <?php endif; ?>
</div>
<?php $content = ob_get_clean(); ?>
<?php require __DIR__ . '/../layouts/main.php'; ?>