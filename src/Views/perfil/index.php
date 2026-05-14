<?php ob_start(); ?>
<div class="max-w-4xl mx-auto">
    <h1 class="text-4xl font-bold text-amber-300 mb-6" style="font-family: 'VT323', monospace;">Mi Perfil</h1>

    <div class="bg-gray-800 border-2 border-amber-700 rounded-lg shadow-xl p-6 mb-8">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-2xl text-amber-400">Información personal</h2>
            <a href="/perfil/editar" class="bg-amber-700 hover:bg-amber-600 text-white font-bold py-2 px-4 rounded border border-amber-500 shadow transition">Editar</a>
        </div>
        <div class="grid grid-cols-2 gap-4 text-gray-200">
            <p><span class="text-amber-400">Nombre:</span> <?= htmlspecialchars($usuario['nombre']) ?></p>
            <p><span class="text-amber-400">Email:</span> <?= htmlspecialchars($usuario['email']) ?></p>
            <p><span class="text-amber-400">Rol:</span> <?= ucfirst($usuario['rol']) ?></p>
            <?php if ($usuario['rol'] === 'instructor'): ?>
                <p><span class="text-amber-400">Reputación:</span> <?= number_format($usuario['reputacion'], 2) ?> / 5</p>
            <?php endif; ?>
        </div>
    </div>

    <?php if ($usuario['rol'] === 'alumno'): ?>
        <!-- Historial de pedidos -->
        <div class="bg-gray-800 border-2 border-amber-700 rounded-lg shadow-xl p-6 mb-8">
            <h2 class="text-2xl text-amber-400 mb-4">Historial de compras</h2>
            <?php if (!empty($pedidos)): ?>
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-gray-900/50 border border-amber-700 rounded-lg">
                        <thead class="bg-amber-900/50">
                            <tr>
                                <th class="py-3 px-4 text-left text-sm font-medium text-amber-300">Pedido #</th>
                                <th class="py-3 px-4 text-left text-sm font-medium text-amber-300">Fecha</th>
                                <th class="py-3 px-4 text-left text-sm font-medium text-amber-300">Total</th>
                                <th class="py-3 px-4 text-left text-sm font-medium text-amber-300">Estado</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-amber-700">
                            <?php foreach ($pedidos as $pedido): ?>
                            <tr class="hover:bg-gray-700/50 transition">
                                <td class="py-3 px-4"><?= $pedido['id'] ?></td>
                                <td class="py-3 px-4"><?= date('d/m/Y H:i', strtotime($pedido['fecha'])) ?></td>
                                <td class="py-3 px-4 text-amber-300 font-bold">€<?= number_format($pedido['total'], 2) ?></td>
                                <td class="py-3 px-4"><?= ucfirst($pedido['estado']) ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <p class="text-gray-400">Aún no has realizado ninguna compra.</p>
            <?php endif; ?>
        </div>

        <!-- Reseñas escritas -->
        <div class="bg-gray-800 border-2 border-amber-700 rounded-lg shadow-xl p-6">
            <h2 class="text-2xl text-amber-400 mb-4">Tus reseñas</h2>
            <?php if (!empty($resenas)): ?>
                <ul class="divide-y divide-gray-600 border border-amber-700 rounded-lg">
                    <?php foreach ($resenas as $resena): ?>
                    <li class="p-4">
                        <div class="flex justify-between items-start mb-2">
                            <span class="font-medium text-amber-300"><?= htmlspecialchars($resena['curso_titulo']) ?></span>
                            <span class="text-yellow-400 font-bold"><?= str_repeat('★', $resena['puntuacion']) ?><?= str_repeat('☆', 5 - $resena['puntuacion']) ?></span>
                        </div>
                        <?php if (!empty($resena['comentario'])): ?>
                            <p class="text-gray-300 text-sm"><?= htmlspecialchars($resena['comentario']) ?></p>
                        <?php endif; ?>
                        <p class="text-xs text-gray-500 mt-1"><?= date('d/m/Y', strtotime($resena['fecha'])) ?></p>
                    </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p class="text-gray-400">Aún no has escrito ninguna reseña.</p>
            <?php endif; ?>
        </div>
    <?php elseif ($usuario['rol'] === 'instructor'): ?>
        <!-- Cursos publicados -->
        <div class="bg-gray-800 border-2 border-amber-700 rounded-lg shadow-xl p-6">
            <h2 class="text-2xl text-amber-400 mb-4">Mis cursos publicados</h2>
            <?php if (!empty($cursos)): ?>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <?php foreach ($cursos as $curso): ?>
                        <div class="bg-gray-700 p-4 rounded-lg border border-amber-600">
                            <h3 class="text-amber-300 font-semibold"><?= htmlspecialchars($curso['titulo']) ?></h3>
                            <p class="text-gray-400 text-sm">€<?= number_format($curso['precio'], 2) ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p class="text-gray-400">Aún no has publicado ningún curso.</p>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</div>
<?php $content = ob_get_clean(); ?>
<?php require __DIR__ . '/../layouts/main.php'; ?>