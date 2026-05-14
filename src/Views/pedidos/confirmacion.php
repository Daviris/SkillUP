<?php ob_start(); ?>
<div class="max-w-2xl mx-auto text-center">
    <div class="bg-gray-800 border-4 border-amber-700 rounded-lg p-8 shadow-2xl">
        <div class="text-6xl mb-4">✅</div>
        <h1 class="text-4xl font-bold text-amber-300 mb-2" style="font-family: 'VT323', monospace;">¡Misión completada!</h1>
        <div class="h-1 w-16 bg-amber-700 mx-auto mb-6"></div>
        <p class="text-gray-300 text-lg mb-2">Has adquirido nuevos conocimientos.</p>
        <p class="text-gray-400">Pedido #<span class="text-amber-400 font-bold"><?= $pedido['id'] ?></span></p>
        <p class="text-gray-400">Total: <span class="text-yellow-400 font-bold"><?= number_format($pedido['total'], 2) ?> €</span></p>

        <div class="mt-8 text-left">
            <h2 class="text-xl text-amber-400 mb-3">Cursos adquiridos:</h2>
            <ul class="divide-y divide-gray-600 border border-amber-700 rounded-lg">
                <?php foreach ($detalles as $detalle): ?>
                <li class="p-3 flex justify-between">
                    <span class="text-gray-200"><?= htmlspecialchars($detalle['titulo']) ?></span>
                    <span class="text-yellow-400"><?= number_format($detalle['precio'], 2) ?> €</span>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>

        <div class="mt-8">
            <a href="/cursos" class="inline-block bg-amber-700 hover:bg-amber-600 text-white font-bold py-3 px-6 rounded border border-amber-500 shadow transition">
                Seguir explorando
            </a>
        </div>
    </div>
</div>
<?php $content = ob_get_clean(); ?>
<?php require __DIR__ . '/../layouts/main.php'; ?>