<?php ob_start(); ?>
<div class="fade-in-up" style="margin-bottom:2rem;">
    <h1 class="font-rpg" style="font-size:2.5rem; color:#fbbf24; margin-bottom:0.5rem; text-shadow:0 0 15px rgba(251,191,36,0.4);">
        📚 Cursos
    </h1>
    <p style="color:#94a3b8; font-size:1.1rem;">Gestión de todas las misiones disponibles en la plataforma</p>
</div>

<div class="card" style="padding:1.5rem; background:#0f172a; border:1px solid #334155;">
    <table id="tabla-cursos" class="display" style="width:100%;">
        <thead>
            <tr>
                <th>Título</th>
                <th>Instructor</th>
                <th>Precio</th>
                <th>Modalidad</th>
                <th>Rating</th>
                <th style="text-align:right;">Acciones</th>
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
            { 
                data: 'precio',
                render: (precio) => `${parseFloat(precio).toFixed(2)} €`
            },
            { 
                data: 'modalidad',
                render: (modalidad) => {
                    const badge = modalidad === 'online' ? 'badge-exito' : 'badge-peligro';
                    const icono = modalidad === 'online' ? '🌐' : '🏰';
                    return `<span class="badge ${badge}">${icono} ${modalidad}</span>`;
                }
            },
            { 
                data: 'media_resenas',
                render: (media, type, row) => {
                    const estrellas = media ? `${parseFloat(media).toFixed(1)} ★` : 'Sin reseñas';
                    return `
                        <div style="display:flex; align-items:center; gap:0.5rem;">
                            <span>${estrellas}</span>
                            <a href="/admin/cursos/${row.id}/resenas" class="btn btn-secondary btn-sm" style="font-size:0.7rem;">Ver</a>
                        </div>`;
                }
            },
            {
                data: 'id',
                orderable: false,
                render: (id) => `
                    <div style="display:flex; gap:0.5rem; justify-content:flex-end;">
                        <a href="/admin/cursos/editar/${id}" class="btn btn-primary btn-sm" style="background:linear-gradient(135deg, #b45309, #d97706); border:none;">Editar</a>
                        <a href="/admin/cursos/eliminar/${id}" class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar este curso?')">Eliminar</a>
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