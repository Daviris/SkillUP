<?php ob_start(); ?>
<div class="max-w-2xl mx-auto text-center py-12">
    <div class="bg-gray-800 border-4 border-red-700 rounded-lg p-8 shadow-2xl">
        <h1 class="text-5xl font-bold text-red-400 mb-4" style="font-family: 'VT323', monospace;">
            ¡Error crítico!
        </h1>
        <div class="h-1 w-16 bg-red-700 mx-auto mb-6"></div>
        <p class="text-gray-300 mb-4">Algo salió mal en nuestras mazmorras técnicas.</p>
        <?php if (($message ?? '') !== ''): ?>
            <div class="bg-gray-900 p-4 rounded border border-red-600 mb-4">
                <p class="text-red-300 text-sm font-mono"><?= htmlspecialchars($message) ?></p>
            </div>
        <?php endif; ?>
        <a href="/" class="inline-block bg-amber-700 hover:bg-amber-600 text-white font-bold py-2 px-6 rounded border border-amber-500 shadow transition">
            Volver a la taberna
        </a>
    </div>
</div>
<?php $content = ob_get_clean(); ?>
<?php require __DIR__ . '/../layouts/main.php'; ?>