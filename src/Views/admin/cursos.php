<?php ob_start(); ?>
<h1 class="font-rpg" style="font-size:2.5rem; color:#fbbf24; margin-bottom:2rem;">Cursos</h1>
<div class="table-container">
    <table id="tabla-cursos" class="display" style="width:100%;">
        <thead>
            <tr>
                <th>Título</th>
                <th>Instructor</th>
                <th>Precio</th>
                <th>Modalidad</th>
                <th>Acciones</th>
            </tr>
        </thead>
    </table>
</div>
<script>
document.addEventListener('DOMContentLoaded', () => {
    $('#tabla-cursos').DataTable({
        ajax: '/api/admin/cursos',
        columns: [
            { data: 'titulo' },
            { data: 'instructor_nombre' },
            { data: 'precio' },
            { data: 'modalidad' },
            {
                data: 'id',
                render: (id) => `
                    <a href="/admin/cursos/${id}/resenas" class="btn btn-secondary btn-sm">Reseñas</a>
                    <a href="/admin/cursos/editar/${id}" class="btn btn-primary btn-sm">Editar</a>
                    <a href="/admin/cursos/eliminar/${id}" class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar?')">Eliminar</a>
                `
            }
        ],
        language: { url: 'https://cdn.datatables.net/plug-ins/2.1.8/i18n/es-ES.json' }
    });
});
</script>
<?php $content = ob_get_clean(); ?>
<?php require __DIR__ . '/layout.php'; ?>