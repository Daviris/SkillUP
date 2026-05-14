<?php ob_start(); ?>
<div class="bg-gray-800 rounded-lg border-2 border-amber-700 shadow-xl p-6">
    <h1 class="text-4xl font-bold text-amber-300 mb-6" style="font-family: 'VT323', monospace;">
        Mis Cursos Adquiridos
    </h1>

    <?php if (!empty($cursos)): ?>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php foreach ($cursos as $curso): ?>
        <div class="bg-gray-700 rounded-lg border border-amber-600 p-5 shadow hover:shadow-amber-900/50 transition">
            <h3 class="text-xl font-semibold text-amber-300"><?= htmlspecialchars($curso['titulo']) ?></h3>
            <p class="text-gray-300 mt-2"><?= htmlspecialchars(substr($curso['descripcion'], 0, 100)) ?>...</p>
            <p class="text-sm text-gray-400 mt-2">
                Instructor: <?= htmlspecialchars($curso['instructor_nombre'] ?? 'N/A') ?>
            </p>
            <div class="mt-4">
                <a href="/mis-cursos/ver/<?= $curso['id'] ?>" 
                   class="inline-block bg-amber-700 hover:bg-amber-600 text-white font-bold py-2 px-4 rounded border border-amber-500 shadow transition">
                    Ver clases
                </a>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php else: ?>
    <div class="text-center py-12 bg-gray-900/50 rounded-lg border border-dashed border-amber-700">
        <p class="text-gray-400">Aún no has adquirido ningún curso.</p>
        <a href="/cursos" 
           class="inline-block mt-4 bg-amber-700 hover:bg-amber-600 text-white font-bold py-2 px-4 rounded border border-amber-500 shadow transition">
            Explorar cursos
        </a>
    </div>
    <?php endif; ?>
</div>
<?php $content = ob_get_clean(); ?>
<?php require __DIR__ . '/../layouts/main.php'; ?>