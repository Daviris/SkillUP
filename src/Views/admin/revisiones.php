<?php ob_start(); ?>
<h1 class="font-rpg" style="font-size:2.5rem; color:#fbbf24; margin-bottom:1.5rem;"><i class="fa-solid fa-clipboard-list"></i> Cursos en Revisión</h1>
<div class="table-container">
    <table id="tabla-revisiones" class="display" style="width:100%;">
        <thead>
            <tr>
                <th>Título</th>
                <th>Instructor</th>
                <th>Precio</th>
                <th>Modalidad</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($cursos as $curso): ?>
            <tr>
                <td><?= htmlspecialchars($curso['titulo']) ?></td>
                <td><?= htmlspecialchars($curso['instructor_nombre'] ?? 'N/A') ?></td>
                <td><?= number_format($curso['precio'], 2) ?> €</td>
                <td><?= ucfirst($curso['modalidad']) ?></td>
                <td>
                    <div style="display:flex; gap:0.5rem; flex-wrap:wrap;">
                        <a href="/admin/revisiones/ver-clases/<?= $curso['id'] ?>" class="btn btn-secondary btn-sm"><i class="fa-solid fa-book-open"></i> Ver clases</a>
                        <a href="/admin/revisiones/aprobar/<?= $curso['id'] ?>" class="btn btn-success btn-sm"><i class="fa-solid fa-circle-check"></i> Aprobar</a>
                        <button onclick="mostrarRechazo(<?= $curso['id'] ?>)" class="btn btn-danger btn-sm"><i class="fa-solid fa-circle-xmark"></i> Rechazar</button>
                        <div id="rechazo-<?= $curso['id'] ?>" style="display:none; margin-top:0.5rem; width:100%;">
                            <form action="/admin/revisiones/rechazar/<?= $curso['id'] ?>" method="POST">
                                <?= \App\Core\Csrf::tokenField() ?>
                                <textarea name="motivo" rows="2" placeholder="Motivo del rechazo" class="form-textarea" style="width:100%; margin-bottom:0.25rem;"></textarea>
                                <button type="submit" class="btn btn-danger btn-sm">Confirmar rechazo</button>
                            </form>
                        </div>
                    </div>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<script>
function mostrarRechazo(id) {
    document.getElementById('rechazo-' + id).style.display = 'block';
}
$(document).ready(function() {
    $('#tabla-revisiones').DataTable({
        language: { url: 'https://cdn.datatables.net/plug-ins/2.1.8/i18n/es-ES.json' }
    });
});
</script>
<?php $content = ob_get_clean(); ?>
<?php require __DIR__ . '/layout.php'; ?>