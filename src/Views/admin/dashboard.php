<?php ob_start(); ?>
<h1 class="text-3xl font-bold text-amber-300 mb-6" style="font-family: 'VT323', monospace;">Dashboard</h1>
<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <div class="bg-gray-800 border border-amber-700 p-6 rounded-lg text-center">
        <p class="text-amber-400 text-4xl font-bold"><?= $totalUsuarios ?></p>
        <p class="text-gray-300 mt-2">Usuarios registrados</p>
    </div>
    <div class="bg-gray-800 border border-amber-700 p-6 rounded-lg text-center">
        <p class="text-amber-400 text-4xl font-bold"><?= $totalCursos ?></p>
        <p class="text-gray-300 mt-2">Cursos publicados</p>
    </div>
    <div class="bg-gray-800 border border-amber-700 p-6 rounded-lg text-center">
        <p class="text-amber-400 text-4xl font-bold"><?= $totalPedidos ?></p>
        <p class="text-gray-300 mt-2">Pedidos realizados</p>
    </div>
    <div class="bg-gray-800 border border-amber-700 p-6 rounded-lg text-center">
        <p class="text-green-400 text-4xl font-bold"><?= number_format($ingresosTotales, 2) ?> €</p>
        <p class="text-gray-300 mt-2">Ingresos totales</p>
    </div>
    <div class="bg-gray-800 border border-amber-700 p-6 rounded-lg text-center">
        <p class="text-amber-400 text-4xl font-bold"><?= $totalResenas ?></p>
        <p class="text-gray-300 mt-2">Reseñas escritas</p>
    </div>
</div>
<?php $content = ob_get_clean(); ?>
<?php require __DIR__ . '/layout.php'; ?>