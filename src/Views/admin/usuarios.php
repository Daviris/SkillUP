<?php ob_start(); ?>
<div class="fade-in-up" style="margin-bottom:2rem;">
    <h1 class="font-rpg" style="font-size:2.5rem; color:#fbbf24; margin-bottom:0.5rem; text-shadow:0 0 15px rgba(251,191,36,0.4);">
        👥 Usuarios
    </h1>
    <p style="color:#94a3b8; font-size:1.1rem;">Gestión de todos los aventureros de la plataforma</p>
</div>

<div class="card" style="padding:1.5rem; background:#0f172a; border:1px solid #334155;">
    <table id="tabla-usuarios" class="display" style="width:100%;">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Email</th>
                <th>Rol</th>
                <th>Reputación</th>
                <th style="text-align:right;">Acciones</th>
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
            { 
                data: 'rol',
                render: (rol) => {
                    const colores = { admin: '#7f1d1d', instructor: '#b45309', alumno: '#065f46' };
                    return `<span class="badge" style="background:${colores[rol] || '#4b5563'}; color:white;">${rol}</span>`;
                }
            },
            { 
                data: 'reputacion',
                render: (rep) => `${parseFloat(rep).toFixed(1)} ★`
            },
            {
                data: 'id',
                orderable: false,
                render: (id) => `
                    <div style="display:flex; gap:0.5rem; justify-content:flex-end;">
                        <a href="/admin/usuarios/editar/${id}" class="btn btn-primary btn-sm" style="background:linear-gradient(135deg, #b45309, #d97706); border:none;">Editar</a>
                        <a href="/admin/usuarios/eliminar/${id}" class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar este usuario?')">Eliminar</a>
                    </div>
                `
            }
        ],
        language: { url: 'https://cdn.datatables.net/plug-ins/2.1.8/i18n/es-ES.json' },
        order: [[0, 'asc']]
    });
});
</script>
<?php $content = ob_get_clean(); ?>
<?php require __DIR__ . '/layout.php'; ?>