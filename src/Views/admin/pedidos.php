<?php ob_start(); ?>
<h1 class="font-rpg" style="font-size:2.5rem; color:#fbbf24; margin-bottom:2rem;">Pedidos</h1>
<div class="table-container">
    <table id="tabla-pedidos" class="display" style="width:100%;">
        <thead>
            <tr>
                <th>ID</th>
                <th>Usuario</th>
                <th>Total</th>
                <th>Fecha</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
    </table>
</div>
<script>
document.addEventListener('DOMContentLoaded', () => {
    $('#tabla-pedidos').DataTable({
        ajax: '/api/admin/pedidos',
        columns: [
            { data: 'id' },
            { data: 'usuario_nombre' },
            { data: 'total' },
            { data: 'fecha' },
            { data: 'estado' },
            {
                data: 'id',
                render: (id) => `
                    <a href="/admin/pedidos/ver/${id}" class="btn btn-primary btn-sm">Ver</a>
                    <form action="/admin/pedidos/cambiar-estado/${id}" method="POST" style="display:inline;">
                        <select name="estado" onchange="this.form.submit()" class="form-select" style="width:auto; padding:0.3rem;">
                            <option value="pendiente">Pendiente</option>
                            <option value="completado">Completado</option>
                            <option value="cancelado">Cancelado</option>
                        </select>
                    </form>
                `
            }
        ],
        language: { url: 'https://cdn.datatables.net/plug-ins/2.1.8/i18n/es-ES.json' }
    });
});
</script>
<?php $content = ob_get_clean(); ?>
<?php require __DIR__ . '/layout.php'; ?>