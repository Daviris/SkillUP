<?php ob_start(); ?>
<h1 class="font-rpg" style="font-size:2.5rem; color:#fbbf24; margin-bottom:2rem;">Dashboard</h1>

<div class="grid-3">
    <div class="card text-center">
        <p style="font-size:3rem; color:#fbbf24; font-weight:700;"><?= $totalUsuarios ?></p>
        <p style="color:#cbd5e1; margin-top:0.5rem;">Usuarios registrados</p>
    </div>
    <div class="card text-center">
        <p style="font-size:3rem; color:#fbbf24; font-weight:700;"><?= $totalCursos ?></p>
        <p style="color:#cbd5e1; margin-top:0.5rem;">Cursos publicados</p>
    </div>
    <div class="card text-center">
        <p style="font-size:3rem; color:#fbbf24; font-weight:700;"><?= $totalPedidos ?></p>
        <p style="color:#cbd5e1; margin-top:0.5rem;">Pedidos realizados</p>
    </div>
    <div class="card text-center">
        <p style="font-size:3rem; color:#10b981; font-weight:700;"><?= number_format($ingresosTotales, 2) ?> €</p>
        <p style="color:#cbd5e1; margin-top:0.5rem;">Ingresos totales</p>
    </div>
    <div class="card text-center">
        <p style="font-size:3rem; color:#fbbf24; font-weight:700;"><?= $totalResenas ?></p>
        <p style="color:#cbd5e1; margin-top:0.5rem;">Reseñas escritas</p>
    </div>
</div>
<?php $content = ob_get_clean(); ?>
<?php require __DIR__ . '/layout.php'; ?>