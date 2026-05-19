<?php ob_start(); ?>
<h1 class="font-rpg" style="font-size:2.5rem; color:#fbbf24; margin-bottom:2rem;">Usuarios</h1>
<div class="table-container">
    <table id="tabla-usuarios" class="display" style="width:100%;">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Email</th>
                <th>Rol</th>
                <th>Reputación</th>
                <th>Acciones</th>
            </tr>
        </thead>
    </table>
</div>
<script>
document.addEventListener('DOMContentLoaded', () => {
    $('#tabla-usuarios').DataTable({
        ajax: '/api/admin/usuarios',
        columns: [
            { data: 'nombre' },
            { data: 'email' },
            { data: 'rol' },
            { data: 'reputacion' },
            {
                data: 'id',
                render: (id) => `
                    <a href="/admin/usuarios/editar/${id}" class="btn btn-primary btn-sm">Editar</a>
                    <a href="/admin/usuarios/eliminar/${id}" class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar?')">Eliminar</a>
                `
            }
        ],
        language: { url: 'https://cdn.datatables.net/plug-ins/2.1.8/i18n/es-ES.json' }
    });
});
</script>
<?php $content = ob_get_clean(); ?>
<?php require __DIR__ . '/layout.php'; ?>