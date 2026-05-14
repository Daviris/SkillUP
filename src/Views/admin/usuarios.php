<?php ob_start(); ?>
<h1 class="text-3xl font-bold text-amber-300 mb-6">Usuarios</h1>
<div class="overflow-x-auto">
    <table class="min-w-full bg-gray-800 border border-amber-700 rounded-lg">
        <thead class="bg-amber-900/50">
            <tr>
                <th class="py-2 px-4 text-left text-amber-300">Nombre</th>
                <th class="py-2 px-4 text-left text-amber-300">Email</th>
                <th class="py-2 px-4 text-left text-amber-300">Rol</th>
                <th class="py-2 px-4 text-left text-amber-300">Reputación</th>
                <th class="py-2 px-4 text-left text-amber-300">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($usuarios as $u): ?>
            <tr class="border-b border-gray-700">
                <td class="py-2 px-4"><?= htmlspecialchars($u['nombre']) ?></td>
                <td class="py-2 px-4"><?= htmlspecialchars($u['email']) ?></td>
                <td class="py-2 px-4"><?= $u['rol'] ?></td>
                <td class="py-2 px-4"><?= $u['reputacion'] ?></td>
                <td class="py-2 px-4">
                    <a href="/admin/usuarios/editar/<?= $u['id'] ?>" class="text-amber-400 hover:underline mr-2">Editar</a>
                    <a href="/admin/usuarios/eliminar/<?= $u['id'] ?>" onclick="return confirm('¿Eliminar este usuario?')" class="text-red-400 hover:underline">Eliminar</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php $content = ob_get_clean(); ?>
<?php require __DIR__ . '/layout.php'; ?>