<?php ob_start(); ?>
<div class="max-w-4xl mx-auto">
    <h1 class="text-4xl font-bold text-amber-300 mb-6" style="font-family: 'VT323', monospace;">
        <?= htmlspecialchars($curso['titulo']) ?>
    </h1>

    <?php if (!empty($curso['clases'])): ?>
        <div class="space-y-4">
            <?php foreach ($curso['clases'] as $clase): ?>
                <a href="/mis-cursos/clase/<?= $clase['id'] ?>" 
                   class="block bg-gray-800 border-2 border-amber-700 rounded-lg p-5 hover:bg-gray-700 transition">
                    <div class="flex justify-between items-center">
                        <div>
                            <h2 class="text-xl font-semibold text-amber-300">
                                <?= $clase['orden'] ?>. <?= htmlspecialchars($clase['titulo']) ?>
                            </h2>
                            <p class="text-gray-400 text-sm mt-1"><?= $clase['duracion'] ?> minutos</p>
                        </div>
                        <span class="px-3 py-1 bg-amber-700 text-white rounded-full text-xs font-bold">
                            <?= ucfirst($clase['tipo']) ?>
                        </span>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p class="text-gray-400">Este curso aún no tiene clases.</p>
    <?php endif; ?>
</div>
<?php $content = ob_get_clean(); ?>
<?php require __DIR__ . '/../layouts/main.php'; ?>