<?php ob_start(); ?>
<h1 class="text-3xl font-bold text-amber-300 mb-6">Pedidos</h1>

<div class="overflow-x-auto">
    <table class="min-w-full bg-gray-800 border border-amber-700 rounded-lg">
        <thead class="bg-amber-900/50">
            <tr>
                <th class="py-2 px-4 text-left text-amber-300">ID</th>
                <th class="py-2 px-4 text-left text-amber-300">Usuario</th>
                <th class="py-2 px-4 text-left text-amber-300">Total</th>
                <th class="py-2 px-4 text-left text-amber-300">Fecha</th>
                <th class="py-2 px-4 text-left text-amber-300">Estado</th>
                <th class="py-2 px-4 text-left text-amber-300">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($pedidos as $pedido): ?>
            <tr class="border-b border-gray-700 hover:bg-gray-700/50">
                <td class="py-2 px-4"><?= $pedido['id'] ?></td>
                <td class="py-2 px-4"><?= htmlspecialchars($pedido['usuario_id'] ?? '') ?></td>
                <td class="py-2 px-4 text-amber-300"><?= number_format($pedido['total'], 2) ?> €</td>
                <td class="py-2 px-4"><?= date('d/m/Y', strtotime($pedido['fecha'])) ?></td>
                <td class="py-2 px-4"><?= $pedido['estado'] ?></td>
                <td class="py-2 px-4 space-x-2">
                    <a href="/admin/pedidos/ver/<?= $pedido['id'] ?>" class="text-amber-400 hover:underline">Ver</a>
                    <form action="/admin/pedidos/cambiar-estado/<?= $pedido['id'] ?>" method="POST" class="inline">
                        <select name="estado" onchange="this.form.submit()" class="bg-gray-700 border border-amber-600 rounded px-2 py-1 text-gray-200">
                            <option value="pendiente" <?= $pedido['estado'] == 'pendiente' ? 'selected' : '' ?>>Pendiente</option>
                            <option value="completado" <?= $pedido['estado'] == 'completado' ? 'selected' : '' ?>>Completado</option>
                            <option value="cancelado" <?= $pedido['estado'] == 'cancelado' ? 'selected' : '' ?>>Cancelado</option>
                        </select>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php $content = ob_get_clean(); ?>
<?php require __DIR__ . '/layout.php'; ?>