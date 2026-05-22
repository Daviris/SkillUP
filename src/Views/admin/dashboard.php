<?php ob_start(); ?>
<h1 class="font-rpg" style="font-size:2.5rem; color:#fbbf24; margin-bottom:0.5rem; text-shadow:0 0 15px rgba(251,191,36,0.4);">
    <i class="fa-solid fa-chart-pie"></i> Panel de Administración
</h1>
<p style="color:#94a3b8; font-size:1.1rem; margin-bottom:2rem;">Resumen general de la plataforma SkillUP</p>

<!-- Tarjetas de estadísticas -->
<div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(200px, 1fr)); gap:1.5rem;">
    <div class="card" style="padding:1.5rem; text-align:center; background:linear-gradient(135deg, #1e293b, #0f172a); border:1px solid #334155;">
        <div style="font-size:2.5rem; margin-bottom:0.5rem;"><i class="fa-solid fa-people-group"></i></div>
        <div style="font-size:2.5rem; font-weight:bold; color:#fbbf24;"><?= $totalUsuarios ?? '?' ?></div>
        <div style="color:#94a3b8; font-size:0.95rem;">Usuarios registrados</div>
    </div>
    <div class="card" style="padding:1.5rem; text-align:center; background:linear-gradient(135deg, #1e293b, #0f172a); border:1px solid #334155;">
        <div style="font-size:2.5rem; margin-bottom:0.5rem;"><i class="fa-solid fa-book-open"></i></div>
        <div style="font-size:2.5rem; font-weight:bold; color:#fbbf24;"><?= $totalCursos ?? '?' ?></div>
        <div style="color:#94a3b8; font-size:0.95rem;">Cursos publicados</div>
    </div>
    <div class="card" style="padding:1.5rem; text-align:center; background:linear-gradient(135deg, #1e293b, #0f172a); border:1px solid #334155;">
        <div style="font-size:2.5rem; margin-bottom:0.5rem;"><i class="fa-solid fa-cart-shopping"></i></div>
        <div style="font-size:2.5rem; font-weight:bold; color:#fbbf24;"><?= $totalPedidos ?? '?' ?></div>
        <div style="color:#94a3b8; font-size:0.95rem;">Pedidos realizados</div>
    </div>
    <div class="card" style="padding:1.5rem; text-align:center; background:linear-gradient(135deg, #1e293b, #0f172a); border:1px solid #334155;">
        <div style="font-size:2.5rem; margin-bottom:0.5rem;"><i class="fa-solid fa-coins"></i></div>
        <div style="font-size:2.5rem; font-weight:bold; color:#10b981;"><?= number_format($ingresosTotales ?? 0, 2) ?> €</div>
        <div style="color:#94a3b8; font-size:0.95rem;">Ingresos totales</div>
    </div>
    <div class="card" style="padding:1.5rem; text-align:center; background:linear-gradient(135deg, #1e293b, #0f172a); border:1px solid #334155;">
        <div style="font-size:2.5rem; margin-bottom:0.5rem;"><i class="fa-solid fa-star"></i></div>
        <div style="font-size:2.5rem; font-weight:bold; color:#fbbf24;"><?= $totalResenas ?? '?' ?></div>
        <div style="color:#94a3b8; font-size:0.95rem;">Reseñas escritas</div>
    </div>
</div>
<?php $content = ob_get_clean(); ?>
<?php require __DIR__ . '/layout.php'; ?>