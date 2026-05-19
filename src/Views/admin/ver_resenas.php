<?php ob_start(); ?>
<h1 class="font-rpg" style="font-size:2.5rem; color:#fbbf24; margin-bottom:1rem;">Reseñas de "<?= htmlspecialchars($curso['titulo']) ?>"</h1>
<div class="table-container">
    <table id="tabla-resenas" class="display" style="width:100%;">
        <thead>
            <tr>
                <th>Alumno</th>
                <th>Puntuación</th>
                <th>Comentario</th>
                <th>Fecha</th>
                <th>Acciones</th>
            </tr>
        </thead>
    </table>
</div>
<script>
document.addEventListener('DOMContentLoaded', () => {
    $('#tabla-resenas').DataTable({
        ajax: '/api/admin/cursos/<?= $curso['id'] ?>/resenas',
        columns: [
            { data: 'alumno_nombre' },
            { data: 'puntuacion' },
            { data: 'comentario' },
            { data: 'fecha' },
            {
                data: 'id',
                render: (id) => `<a href="/admin/resenas/eliminar/${id}" class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar?')">Eliminar</a>`
            }
        ],
        language: { url: 'https://cdn.datatables.net/plug-ins/2.1.8/i18n/es-ES.json' }
    });
});
</script>
<?php $content = ob_get_clean(); ?>
<?php require __DIR__ . '/layout.php'; ?>