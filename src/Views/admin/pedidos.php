<?php ob_start(); ?>
<div class="fade-in-up" style="margin-bottom:2rem;">
    <h1 class="font-rpg" style="font-size:2.5rem; color:#fbbf24; margin-bottom:0.5rem; text-shadow:0 0 15px rgba(251,191,36,0.4);">
        <i class="fa-solid fa-cart-shopping"></i> Pedidos
    </h1>
    <p style="color:#94a3b8; font-size:1.1rem;">Todos los pedidos realizados en la plataforma</p>
</div>

<div class="card" style="padding:1.5rem; background:#0f172a; border:1px solid #334155;">
    <table id="tabla-pedidos" class="display" style="width:100%;">
        <thead>
            <tr>
                <th>ID</th>
                <th>Usuario</th>
                <th>Total</th>
                <th>Fecha</th>
                <th>Estado</th>
                <th style="text-align:right;">Acciones</th>
            </tr>
        </thead>
    </table>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    // Inicializar DataTable
    $('#tabla-pedidos').DataTable({
        ajax: '/api/admin/pedidos',
        columns: [
            { data: 'id' },
            { data: 'usuario_nombre' },
            { 
                data: 'total',
                render: (total) => `${parseFloat(total).toFixed(2)} €`
            },
            { 
                data: 'fecha',
                render: (fecha) => new Date(fecha).toLocaleDateString('es-ES')
            },
            { 
                data: 'estado',
                render: (estado) => {
                    const clases = {
                        completado: 'badge-exito',
                        pendiente: 'badge-primario',
                        cancelado: 'badge-peligro'
                    };
                    return `<span class="badge ${clases[estado] || 'badge-secundario'}">${estado}</span>`;
                }
            },
            {
                data: 'id',
                orderable: false,
                render: (id, type, row) => `
                    <div style="display:flex; gap:0.5rem; align-items:center; justify-content:flex-end;">
                        <a href="/admin/pedidos/ver/${id}" class="btn btn-primary btn-sm" style="background:linear-gradient(135deg, #b45309, #d97706); border:none;">
                            Ver
                        </a>
                        <select class="form-select cambio-estado" data-id="${id}" style="width:auto; padding:0.3rem 0.5rem; font-size:0.85rem; background:#0f172a; color:#e5e7eb; border:1px solid #334155;">
                            <option value="pendiente" ${row.estado === 'pendiente' ? 'selected' : ''}>Pendiente</option>
                            <option value="completado" ${row.estado === 'completado' ? 'selected' : ''}>Completado</option>
                            <option value="cancelado" ${row.estado === 'cancelado' ? 'selected' : ''}>Cancelado</option>
                        </select>
                    </div>
                `
            }
        ],
        language: { url: 'https://cdn.datatables.net/plug-ins/2.1.8/i18n/es-ES.json' },
        order: [[0, 'desc']]
    });

    // Delegar evento para cambiar estado del pedido
    document.getElementById('tabla-pedidos').addEventListener('change', function(e) {
        if (e.target.classList.contains('cambio-estado')) {
            const id = e.target.getAttribute('data-id');
            const estado = e.target.value;
            if (confirm(`¿Cambiar el pedido #${id} a "${estado}"?`)) {
                window.location.href = `/admin/pedidos/cambiar-estado/${id}?estado=${estado}`;
            }
        }
    });
});
</script>
<?php $content = ob_get_clean(); ?>
<?php require __DIR__ . '/layout.php'; ?>