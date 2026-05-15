<?php ob_start(); ?>
<div style="max-width:1000px; margin:0 auto;">
    <!-- Cabecera -->
    <div style="margin-bottom:2rem;">
        <h1 class="font-rpg" style="font-size:2.5rem; color:#fbbf24; margin-bottom:0.25rem;">
            Entregas: <?= htmlspecialchars($clase['titulo']) ?>
        </h1>
        <p style="color:#9ca3af;">Tarea del curso</p>
    </div>

    <!-- Migas de pan -->
    <div style="margin-bottom:2rem; color:#9ca3af; font-size:0.9rem;">
        <a href="/instructor" style="color:#fbbf24;">Panel Instructor</a> /
        <a href="/instructor/cursos/<?= $clase['curso_id'] ?>/clases" style="color:#fbbf24;">Clases</a> /
        <span style="color:#e5e7eb;">Entregas</span>
    </div>

    <?php if (!empty($entregas)): ?>
        <div style="display:flex; flex-direction:column; gap:1.5rem;">
            <?php foreach ($entregas as $entrega): ?>
                <div class="card" style="padding:1.5rem;">
                    <div style="display:flex; justify-content:space-between; align-items:start; margin-bottom:1rem;">
                        <div>
                            <h3 style="color:#fbbf24; font-weight:600; font-size:1.1rem;">
                                <?= htmlspecialchars($entrega['alumno_nombre']) ?>
                            </h3>
                            <p style="color:#9ca3af; font-size:0.85rem;">
                                Entregado el <?= date('d/m/Y H:i', strtotime($entrega['fecha_entrega'])) ?>
                            </p>
                            <?php if (!empty($entrega['archivo_nombre'])): ?>
                                <a href="/archivo/descargar/<?= $entrega['archivo_id'] ?>" style="color:#fbbf24; font-size:0.9rem; margin-top:0.5rem; display:inline-block;">
                                    📄 <?= htmlspecialchars($entrega['archivo_nombre']) ?>
                                </a>
                            <?php endif; ?>
                            <?php if (!empty($entrega['comentario_alumno'])): ?>
                                <p style="color:#cbd5e1; font-size:0.9rem; margin-top:0.5rem;">
                                    Comentario: <?= htmlspecialchars($entrega['comentario_alumno']) ?>
                                </p>
                            <?php endif; ?>
                        </div>

                        <!-- Bloque de calificación -->
                        <div style="text-align:right; min-width:260px;">
                            <?php if ($entrega['nota'] !== null): ?>
                                <!-- Mostrar nota existente y botón Editar -->
                                <div id="nota-estatica-<?= $entrega['id'] ?>">
                                    <p style="color:#fbbf24; font-size:1.5rem; font-weight:700;"><?= $entrega['nota'] ?>/10</p>
                                    <?php if (!empty($entrega['feedback_instructor'])): ?>
                                        <p style="color:#9ca3af; font-size:0.85rem; max-width:200px;">
                                            <?= htmlspecialchars($entrega['feedback_instructor']) ?>
                                        </p>
                                    <?php endif; ?>
                                    <button onclick="activarEdicion(<?= $entrega['id'] ?>)" class="btn btn-primary btn-sm" style="margin-top:0.5rem;">Editar</button>
                                </div>
                                <!-- Formulario de edición (oculto inicialmente) -->
                                <div id="nota-form-<?= $entrega['id'] ?>" class="hidden">
                                    <form action="/instructor/entregas/actualizar" method="POST">
                                        <input type="hidden" name="entrega_id" value="<?= $entrega['id'] ?>">
                                        <div style="display:flex; gap:0.5rem; align-items:center; margin-bottom:0.5rem;">
                                            <input type="number" name="nota" step="0.1" min="0" max="10" value="<?= $entrega['nota'] ?>" 
                                                   class="form-input" style="width:80px; padding:0.4rem 0.5rem;" required>
                                            <span style="color:#9ca3af;">/10</span>
                                        </div>
                                        <textarea name="feedback" rows="2" placeholder="Feedback para el alumno" 
                                                  class="form-textarea" style="margin-bottom:0.5rem;"><?= htmlspecialchars($entrega['feedback_instructor'] ?? '') ?></textarea>
                                        <div style="display:flex; gap:0.5rem;">
                                            <button type="submit" class="btn btn-success btn-sm">Guardar</button>
                                            <button type="button" onclick="cancelarEdicion(<?= $entrega['id'] ?>)" class="btn btn-secondary btn-sm">Cancelar</button>
                                        </div>
                                    </form>
                                </div>
                            <?php else: ?>
                                <!-- Sin calificar: formulario nuevo -->
                                <form action="/instructor/entregas/calificar" method="POST">
                                    <input type="hidden" name="entrega_id" value="<?= $entrega['id'] ?>">
                                    <div style="display:flex; gap:0.5rem; align-items:center; margin-bottom:0.5rem;">
                                        <input type="number" name="nota" step="0.1" min="0" max="10" placeholder="Nota" 
                                               class="form-input" style="width:80px; padding:0.4rem 0.5rem;" required>
                                        <span style="color:#9ca3af;">/10</span>
                                    </div>
                                    <textarea name="feedback" rows="2" placeholder="Feedback para el alumno" 
                                              class="form-textarea" style="margin-bottom:0.5rem;"></textarea>
                                    <button type="submit" class="btn btn-success btn-sm">Calificar</button>
                                </form>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="card" style="padding:3rem; text-align:center;">
            <p style="font-size:3rem; margin-bottom:1rem;">📭</p>
            <p style="color:#cbd5e1; font-size:1.1rem;">Aún no hay entregas para esta tarea.</p>
        </div>
    <?php endif; ?>
</div>

<script>
function activarEdicion(id) {
    document.getElementById('nota-estatica-' + id).classList.add('hidden');
    document.getElementById('nota-form-' + id).classList.remove('hidden');
}
function cancelarEdicion(id) {
    document.getElementById('nota-estatica-' + id).classList.remove('hidden');
    document.getElementById('nota-form-' + id).classList.add('hidden');
}
</script>
<?php $content = ob_get_clean(); ?>
<?php require __DIR__ . '/../../layouts/main.php'; ?>