<?php ob_start(); ?>
<div class="max-w-4xl mx-auto">
    <h1 class="text-4xl font-bold text-amber-300 mb-2" style="font-family: 'VT323', monospace;">
        Tu Mochila de Conocimiento
    </h1>
    <div class="h-1 w-24 bg-amber-700 mb-8"></div>

    <?php if (!empty($cursos)): ?>
        <div class="bg-gray-800 border-2 border-amber-700 rounded-lg p-4 shadow-inner">
            <table class="w-full text-gray-200">
                <thead class="border-b border-amber-600">
                    <tr class="text-left text-amber-400 font-mono">
                        <th class="py-2">Curso</th>
                        <th class="py-2">Precio</th>
                        <th class="py-2 text-right">Acción</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cursos as $curso): ?>
                    <tr class="border-b border-gray-700 hover:bg-gray-700 transition">
                        <td class="py-3">
                            <div>
                                <p class="font-semibold"><?= htmlspecialchars($curso['titulo']) ?></p>
                                <p class="text-xs text-gray-400">1 unidad</p>
                            </div>
                        </td>
                        <td class="py-3">
                            <span class="text-yellow-400 font-bold"><?= number_format($curso['precio'], 2) ?> €</span>
                        </td>
                        <td class="py-3 text-right">
                            <a href="/carrito/eliminar/<?= $curso['id'] ?>" 
                               class="text-red-400 hover:text-red-300 transition text-sm px-3 py-1 border border-red-600 rounded hover:bg-red-900">
                                Soltar
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot class="border-t border-amber-600">
                    <tr>
                        <td colspan="2" class="pt-4 text-right text-xl text-amber-400 font-bold">
                            Total: <span class="text-yellow-300"><?= number_format($total, 2) ?> €</span>
                        </td>
                        <td class="pt-4 text-right">
                            <a href="/carrito/vaciar" class="text-sm text-gray-400 hover:text-red-400 transition mr-3">
                                Vaciar mochila
                            </a>
                            <a href="/checkout" class="inline-block bg-amber-700 hover:bg-amber-600 text-white font-bold py-2 px-6 rounded border border-yellow-600 shadow transition">
                                Comprar
                            </a>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    <?php else: ?>
        <div class="bg-gray-800 border-2 border-dashed border-gray-600 rounded-lg p-12 text-center">
            <p class="text-gray-400 text-lg">Tu mochila está vacía.</p>
            <p class="text-gray-500">Visita el <a href="/cursos" class="text-amber-400 hover:underline">catálogo de cursos</a> para equiparte.</p>
        </div>
    <?php endif; ?>

    <div class="mt-6 text-right">
        <a href="/cursos" class="text-amber-400 hover:text-amber-300 transition">
            Volver al catálogo
        </a>
    </div>
</div>
<?php $content = ob_get_clean(); ?>
<?php require __DIR__ . '/../layouts/main.php'; ?>