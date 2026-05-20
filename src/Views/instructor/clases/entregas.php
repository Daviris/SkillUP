<?php ob_start(); ?>
<div style="max-width:1000px; margin:0 auto;">
    <!-- Migas de pan -->
    <div class="fade-in-up" style="margin-bottom:1.5rem; color:#94a3b8; font-size:0.9rem;">
        <a href="/instructor" style="color:#fbbf24;">🧙 Panel Instructor</a> /
        <a href="/instructor/cursos/<?= $clase['curso_id'] ?>/clases" style="color:#fbbf24;">Clases</a> /
        <span style="color:#e5e7eb;">Entregas de "<?= htmlspecialchars($clase['titulo']) ?>"</span>
    </div>

    <!-- Cabecera -->
    <div class="fade-in-up card" style="padding:2rem; margin-bottom:2rem; background:linear-gradient(135deg, #7f1d1d, #0f172a); border:2px solid #b45309;">
        <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:1rem;">
            <div>
                <h1 class="font-rpg" style="font-size:2.2rem; color:#fbbf24; margin-bottom:0.25rem;">
                    📋 Entregas
                </h1>
                <p style="color:#cbd5e1;"><?= htmlspecialchars($clase['titulo']) ?> · <?= count($entregas ?? []) ?> entregas</p>
            </div>
            <span class="badge" style="background:#7f1d1d; color:white; font-size:0.9rem; padding:0.5rem 1rem;">
                📝 Tarea
            </span>
        </div>
    </div>

    <!-- Listado de entregas -->
    <?php if (!empty($entregas)): ?>
        <div class="fade-in-up" style="transition-delay:0.2s; display:grid; gap:1.5rem;">
            <?php foreach ($entregas as $entrega): ?>
                <div class="card" style="padding:1.5rem; background:linear-gradient(135deg, #1e293b, #0f172a); border:1px solid #334155;">
                    <div style="display:flex; justify-content:space-between; align-items:start; flex-wrap:wrap; gap:1.5rem;">
                        <!-- Datos del alumno -->
                        <div style="flex:1; min-width:250px;">
                            <h3 style="color:#fbbf24; font-weight:600; font-size:1.1rem; margin-bottom:0.5rem;">
                                <?= htmlspecialchars($entrega['alumno_nombre']) ?>
                            </h3>
                            <p style="color:#94a3b8; font-size:0.85rem; margin-bottom:0.5rem;">
                                Entregado el <?= date('d/m/Y H:i', strtotime($entrega['fecha_entrega'])) ?>
                            </p>
                            <?php if (!empty($entrega['archivo_nombre'])): ?>
                                <a href="/archivo/descargar/<?= $entrega['archivo_id'] ?>" class="btn btn-secondary btn-sm" style="margin-top:0.25rem;">
                                    📄 <?= htmlspecialchars($entrega['archivo_nombre']) ?>
                                </a>
                            <?php endif; ?>
                            <?php if (!empty($entrega['comentario_alumno'])): ?>
                                <p style="color:#cbd5e1; font-size:0.9rem; margin-top:0.5rem;">
                                    💬 <?= htmlspecialchars($entrega['comentario_alumno']) ?>
                                </p>
                            <?php endif; ?>
                        </div>

                        <!-- Calificación -->
                        <div style="min-width:250px; text-align:right;">
                            <?php if ($entrega['nota'] !== null): ?>
                                <!-- Nota existente -->
                                <div id="nota-estatica-<?= $entrega['id'] ?>">
                                    <p style="color:#fbbf24; font-size:1.5rem; font-weight:700;"><?= $entrega['nota'] ?>/10</p>
                                    <?php if (!empty($entrega['feedback_instructor'])): ?>
                                        <p style="color:#94a3b8; font-size:0.85rem; margin-top:0.25rem;">
                                            <?= htmlspecialchars($entrega['feedback_instructor']) ?>
                                        </p>
                                    <?php endif; ?>
                                    <button onclick="activarEdicion(<?= $entrega['id'] ?>)" class="btn btn-primary btn-sm" style="margin-top:0.5rem; background:linear-gradient(135deg, #b45309, #d97706); border:none;">
                                        ✏️ Editar
                                    </button>
                                </div>
                                <!-- Formulario de edición oculto -->
                                <div id="nota-form-<?= $entrega['id'] ?>" class="hidden">
                                    <form action="/instructor/entregas/actualizar" method="POST">
                                        <?= \App\Core\Csrf::tokenField() ?>
                                        <input type="hidden" name="entrega_id" value="<?= $entrega['id'] ?>">
                                        <div style="display:flex; gap:0.5rem; align-items:center; margin-bottom:0.5rem;">
                                            <input type="number" name="nota" step="0.1" min="0" max="10" value="<?= $entrega['nota'] ?>" class="form-input" style="width:80px; padding:0.4rem;" required>
                                            <span style="color:#94a3b8;">/10</span>
                                        </div>
                                        <textarea name="feedback" rows="2" placeholder="Feedback" class="form-textarea" style="margin-bottom:0.5rem;"><?= htmlspecialchars($entrega['feedback_instructor'] ?? '') ?></textarea>
                                        <div style="display:flex; gap:0.5rem; justify-content:flex-end;">
                                            <button type="submit" class="btn btn-success btn-sm">💾 Guardar</button>
                                            <button type="button" onclick="cancelarEdicion(<?= $entrega['id'] ?>)" class="btn btn-secondary btn-sm">Cancelar</button>
                                        </div>
                                    </form>
                                </div>
                            <?php else: ?>
                                <!-- Sin calificar -->
                                <form action="/instructor/entregas/calificar" method="POST">
                                    <?= \App\Core\Csrf::tokenField() ?>
                                    <input type="hidden" name="entrega_id" value="<?= $entrega['id'] ?>">
                                    <div style="display:flex; gap:0.5rem; align-items:center; margin-bottom:0.5rem;">
                                        <input type="number" name="nota" step="0.1" min="0" max="10" placeholder="Nota" class="form-input" style="width:80px; padding:0.4rem;" required>
                                        <span style="color:#94a3b8;">/10</span>
                                    </div>
                                    <textarea name="feedback" rows="2" placeholder="Feedback para el alumno" class="form-textarea" style="margin-bottom:0.5rem;"></textarea>
                                    <button type="submit" class="btn btn-success btn-sm">✅ Calificar</button>
                                </form>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="fade-in-up card" style="padding:4rem 2rem; text-align:center;">
            <p style="font-size:4rem; margin-bottom:1rem;">📭</p>
            <h2 class="font-rpg" style="font-size:1.8rem; color:#fbbf24; margin-bottom:0.5rem;">No hay entregas aún</h2>
            <p style="color:#94a3b8;">Los alumnos todavía no han enviado sus tareas.</p>
        </div>
    <?php endif; ?>

    <div style="margin-top:2rem;">
        <a href="/instructor/cursos/<?= $clase['curso_id'] ?>/clases" class="btn btn-secondary">← Volver a clases</a>
    </div>
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