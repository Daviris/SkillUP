<?php ob_start(); ?>
<h1 class="text-3xl font-bold text-amber-300 mb-6">Pedido #<?= $pedido['id'] ?></h1>

<div class="bg-gray-800 border border-amber-700 rounded-lg p-6 mb-6">
    <?php if ($usuario): ?>
        <p class="text-gray-300"><span class="text-amber-400">Usuario:</span> <?= htmlspecialchars($usuario['nombre']) ?> (<?= htmlspecialchars($usuario['email']) ?>)</p>
    <?php else: ?>
        <p class="text-gray-300"><span class="text-amber-400">Usuario ID:</span> <?= $pedido['usuario_id'] ?> (no encontrado)</p>
    <?php endif; ?>
    <p class="text-gray-300"><span class="text-amber-400">Fecha:</span> <?= date('d/m/Y H:i', strtotime($pedido['fecha'])) ?></p>
    <p class="text-gray-300"><span class="text-amber-400">Total:</span> <span class="text-yellow-400 font-bold"><?= number_format($pedido['total'], 2) ?> €</span></p>
    <p class="text-gray-300"><span class="text-amber-400">Estado:</span> <?= $pedido['estado'] ?></p>
</div>

<h2 class="text-2xl text-amber-400 mb-3">Detalles</h2>
<div class="overflow-x-auto">
    <table class="min-w-full bg-gray-800 border border-amber-700 rounded-lg">
        <thead class="bg-amber-900/50">
            <tr>
                <th class="py-2 px-4 text-left text-amber-300">Curso</th>
                <th class="py-2 px-4 text-left text-amber-300">Precio</th>
                <th class="py-2 px-4 text-left text-amber-300">Cantidad</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($detalles as $detalle): ?>
            <tr class="border-b border-gray-700">
                <td class="py-2 px-4"><?= htmlspecialchars($detalle['titulo']) ?></td>
                <td class="py-2 px-4 text-yellow-400"><?= number_format($detalle['precio'], 2) ?> €</td>
                <td class="py-2 px-4"><?= $detalle['cantidad'] ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<div class="mt-6">
    <a href="/admin/pedidos" class="text-amber-400 hover:underline">Volver a pedidos</a>
</div>
<?php $content = ob_get_clean(); ?>
<?php require __DIR__ . '/layout.php'; ?>