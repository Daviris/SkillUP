<?php ob_start(); ?>
<div class="bg-gray-800 rounded-lg border-2 border-amber-700 shadow-xl p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-4xl font-bold text-amber-300" style="font-family: 'VT323', monospace;">
            <?= htmlspecialchars($curso['titulo']) ?> - Clases
        </h1>
        <a href="/instructor/cursos/<?= $curso['id'] ?>/clases/crear" 
           class="bg-amber-700 hover:bg-amber-600 text-white font-bold px-4 py-2 rounded border border-amber-500 shadow transition">
            + Nueva clase
        </a>
    </div>

    <?php if (!empty($clases)): ?>
    <ul class="divide-y divide-amber-700 border border-amber-700 rounded-lg">
        <?php foreach ($clases as $clase): ?>
        <li class="p-4 hover:bg-gray-700/50 flex justify-between items-center">
            <div>
                <span class="text-amber-300 font-medium">
                    <?= $clase['orden'] ?>. <?= htmlspecialchars($clase['titulo']) ?>
                </span>
                <span class="text-xs text-gray-400 ml-2">(<?= ucfirst($clase['tipo']) ?>)</span>
                <?php if ($clase['tipo'] === 'tarea' && !empty($clase['fecha_limite'])): ?>
                    <span class="text-xs text-red-400 ml-2">
                        (Límite: <?= date('d/m/Y H:i', strtotime($clase['fecha_limite'])) ?>)
                    </span>
                <?php endif; ?>
            </div>
            <div class="space-x-2">
                <a href="/instructor/clases/editar/<?= $clase['id'] ?>" 
                   class="text-amber-400 hover:text-amber-300">Editar</a>
                <a href="/instructor/clases/eliminar/<?= $clase['id'] ?>" 
                   onclick="return confirm('¿Eliminar esta clase?')" 
                   class="text-red-400 hover:text-red-300">Eliminar</a>
                <?php if ($clase['tipo'] === 'tarea'): ?>
                <a href="/instructor/clases/<?= $clase['id'] ?>/entregas" 
                   class="text-green-400 hover:text-green-300">Ver entregas</a>
                <?php endif; ?>
            </div>
        </li>
        <?php endforeach; ?>
    </ul>
    <?php else: ?>
    <div class="text-center py-12 bg-gray-900/50 rounded-lg border border-dashed border-amber-700">
        <p class="text-gray-400">No hay clases aún.</p>
    </div>
    <?php endif; ?>
</div>
<?php $content = ob_get_clean(); ?>
<?php require __DIR__ . '/../../layouts/main.php'; ?>