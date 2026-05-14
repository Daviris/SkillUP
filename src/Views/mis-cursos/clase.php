<?php ob_start(); ?>
<div class="bg-gray-800 rounded-lg border-2 border-amber-700 shadow-xl p-6">
    <!-- Título y migas de pan -->
    <div class="mb-4">
        <a href="/mis-cursos" class="text-amber-400 hover:underline">Mis Cursos</a> &raquo;
        <a href="/mis-cursos/ver/<?= $curso['id'] ?>" class="text-amber-400 hover:underline"><?= htmlspecialchars($curso['titulo']) ?></a> &raquo;
        <span class="text-gray-400"><?= htmlspecialchars($clase['titulo']) ?></span>
    </div>

    <h1 class="text-4xl font-bold text-amber-300 mb-2" style="font-family: 'VT323', monospace;">
        <?= htmlspecialchars($clase['titulo']) ?>
    </h1>
    <div class="flex space-x-4 text-sm text-gray-400 mb-6">
        <span>Tipo: <?= ucfirst($clase['tipo']) ?></span>
        <span>Duración: <?= $clase['duracion'] ?> min</span>
        <?php if ($clase['tipo'] === 'tarea' && !empty($clase['fecha_limite'])): ?>
            <span class="text-red-400">Límite: <?= date('d/m/Y H:i', strtotime($clase['fecha_limite'])) ?></span>
        <?php endif; ?>
    </div>

    <!-- Contenido según tipo -->
    <?php if ($clase['tipo'] === 'teoria'): ?>
        <div class="prose prose-invert max-w-none bg-gray-900/50 p-4 rounded border border-amber-700">
            <?= nl2br(htmlspecialchars($clase['contenido_texto'] ?? '')) ?>
        </div>
    <?php elseif ($clase['tipo'] === 'archivo' && $archivo): ?>
        <div class="bg-gray-900/50 p-4 rounded border border-amber-700">
            <p class="text-gray-300 mb-2">Material de la clase:</p>
            <a href="/archivo/descargar/<?= $archivo['id'] ?>" class="inline-block bg-amber-700 hover:bg-amber-600 text-white font-bold py-2 px-6 rounded border border-amber-500 shadow transition">
                Descargar <?= htmlspecialchars($archivo['nombre_original']) ?>
            </a>
            <p class="text-sm text-gray-400 mt-2">(<?= htmlspecialchars($archivo['tipo_mime']) ?>, <?= round($archivo['tamano']/1024, 1) ?> KB)</p>
        </div>
    <?php elseif ($clase['tipo'] === 'tarea'): ?>
        <div class="bg-gray-900/50 p-4 rounded border border-amber-700 mb-6">
            <h3 class="text-amber-400 font-semibold mb-2">Instrucciones</h3>
            <?php if (!empty($clase['criterios_evaluacion'])): ?>
                <div class="text-gray-300 mb-4"><?= nl2br(htmlspecialchars($clase['criterios_evaluacion'])) ?></div>
            <?php else: ?>
                <p class="text-gray-400">No hay criterios adicionales.</p>
            <?php endif; ?>
            
            <?php if (!empty($clase['fecha_limite'])): ?>
                <p class="text-sm text-red-400">Fecha límite: <?= date('d/m/Y H:i', strtotime($clase['fecha_limite'])) ?></p>
            <?php endif; ?>
        </div>

        <!-- Estado de la entrega -->
        <?php if ($entrega): ?>
            <div class="bg-green-900/50 border border-green-600 p-4 rounded">
                <h3 class="text-green-300 font-semibold">Tu entrega</h3>
                <p class="text-green-200 text-sm">Entregado el <?= date('d/m/Y H:i', strtotime($entrega['fecha_entrega'])) ?></p>
                <?php if ($entrega['archivo_id']): ?>
                    <a href="/archivo/descargar/<?= $entrega['archivo_id'] ?>" class="text-amber-400 hover:underline text-sm">Ver archivo entregado</a>
                <?php endif; ?>
                <?php if ($entrega['nota'] !== null): ?>
                    <p class="text-yellow-400 mt-2">Nota: <?= $entrega['nota'] ?></p>
                    <?php if ($entrega['feedback_instructor']): ?>
                        <p class="text-gray-300 mt-1">Feedback: <?= htmlspecialchars($entrega['feedback_instructor']) ?></p>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        <?php else: ?>
            <?php if (!empty($clase['fecha_limite']) && strtotime($clase['fecha_limite']) > time()): ?>
                <form action="/tarea/subir" method="POST" enctype="multipart/form-data" class="bg-gray-900/50 p-4 rounded border border-amber-700">
                    <input type="hidden" name="clase_id" value="<?= $clase['id'] ?>">
                    <label class="block text-amber-400 text-sm mb-2">Subir archivo</label>
                    <input type="file" name="archivo" required class="w-full text-gray-200 mb-3">
                    <textarea name="comentario" placeholder="Comentario (opcional)" class="w-full px-4 py-2 bg-gray-700 border border-amber-600 rounded text-gray-200 mb-3" rows="2"></textarea>
                    <button type="submit" class="bg-amber-700 hover:bg-amber-600 text-white font-bold py-2 px-6 rounded border border-amber-500 shadow transition">
                        Enviar tarea
                    </button>
                </form>
            <?php else: ?>
                <div class="bg-red-900/50 border border-red-600 p-4 rounded">
                    <p class="text-red-300">El plazo de entrega ha vencido.</p>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    <?php endif; ?>

    <!-- Navegación entre clases (siguiente/anterior) -->
    <div class="mt-8 flex justify-between">
        <?php
        // Buscar las clases del mismo curso para navegación
        $clasesCurso = \App\Models\Clase::whereAll('curso_id', (string)$curso['id']);
        $posActual = array_search($clase['id'], array_column($clasesCurso, 'id'));
        $anterior = $posActual > 0 ? $clasesCurso[$posActual - 1] : null;
        $siguiente = $posActual < count($clasesCurso) - 1 ? $clasesCurso[$posActual + 1] : null;
        ?>
        <?php if ($anterior): ?>
            <a href="/mis-cursos/clase/<?= $anterior['id'] ?>" class="text-amber-400 hover:underline">&laquo; <?= htmlspecialchars($anterior['titulo']) ?></a>
        <?php else: ?>
            <span></span>
        <?php endif; ?>
        <?php if ($siguiente): ?>
            <a href="/mis-cursos/clase/<?= $siguiente['id'] ?>" class="text-amber-400 hover:underline"><?= htmlspecialchars($siguiente['titulo']) ?> &raquo;</a>
        <?php else: ?>
            <span></span>
        <?php endif; ?>
    </div>
</div>
<?php $content = ob_get_clean(); ?>
<?php require __DIR__ . '/../../layouts/main.php'; ?>