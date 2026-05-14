<?php ob_start(); ?>
<div class="max-w-2xl mx-auto">
    <h1 class="text-4xl font-bold text-amber-300 mb-8" style="font-family: 'VT323', monospace;">Checkout</h1>

    <!-- Indicadores de paso -->
    <div class="flex mb-8">
        <div class="flex-1 text-center">
            <span id="paso1-ind" class="inline-block w-8 h-8 bg-amber-700 text-white rounded-full">1</span>
            <div class="text-sm mt-1 text-amber-400">Datos</div>
        </div>
        <div class="flex-1 text-center">
            <span id="paso2-ind" class="inline-block w-8 h-8 bg-gray-600 text-white rounded-full">2</span>
            <div class="text-sm mt-1 text-gray-400">Tarjeta</div>
        </div>
        <div class="flex-1 text-center">
            <span id="paso3-ind" class="inline-block w-8 h-8 bg-gray-600 text-white rounded-full">3</span>
            <div class="text-sm mt-1 text-gray-400">Confirmar</div>
        </div>
    </div>

    <form id="checkout-form" method="POST" action="/checkout/procesar">
        <!-- Paso 1: Datos personales -->
        <div id="paso1" class="paso bg-gray-800 border-2 border-amber-700 rounded-lg p-6">
            <h2 class="text-xl text-amber-400 mb-4">Datos personales</h2>
            <div class="mb-4">
                <label class="block text-amber-400 text-sm mb-1">Nombre completo</label>
                <input type="text" name="nombre" value="<?= htmlspecialchars($_SESSION['usuario']['nombre'] ?? '') ?>" required
                       class="w-full px-4 py-2 bg-gray-700 border-2 border-amber-600 rounded text-gray-200 focus:outline-none focus:border-amber-400">
            </div>
            <div class="mb-4">
                <label class="block text-amber-400 text-sm mb-1">Correo electrónico</label>
                <input type="email" name="email" value="<?= htmlspecialchars($_SESSION['usuario']['email'] ?? '') ?>" required
                       class="w-full px-4 py-2 bg-gray-700 border-2 border-amber-600 rounded text-gray-200 focus:outline-none focus:border-amber-400">
            </div>
            <div class="mb-4">
                <label class="block text-amber-400 text-sm mb-1">Teléfono</label>
                <input type="text" name="telefono" placeholder="+34 600 000 000"
                       class="w-full px-4 py-2 bg-gray-700 border-2 border-amber-600 rounded text-gray-200 focus:outline-none focus:border-amber-400">
            </div>
            <button type="button" onclick="siguientePaso(2)" class="bg-amber-700 hover:bg-amber-600 text-white font-bold py-2 px-6 rounded border border-amber-500 shadow transition">
                Siguiente
            </button>
        </div>

        <!-- Paso 2: Tarjeta (simulado) -->
        <div id="paso2" class="paso bg-gray-800 border-2 border-amber-700 rounded-lg p-6 hidden">
            <h2 class="text-xl text-amber-400 mb-4">Datos de pago</h2>
            <p class="text-gray-400 text-sm mb-4">Estos datos son simulados y no se almacenarán.</p>
            <div class="mb-4">
                <label class="block text-amber-400 text-sm mb-1">Titular de la tarjeta</label>
                <input type="text" name="titular" placeholder="Nombre en la tarjeta"
                       class="w-full px-4 py-2 bg-gray-700 border-2 border-amber-600 rounded text-gray-200 focus:outline-none focus:border-amber-400">
            </div>
            <div class="mb-4">
                <label class="block text-amber-400 text-sm mb-1">Número de tarjeta</label>
                <input type="text" name="tarjeta" placeholder="0000 0000 0000 0000" maxlength="19"
                       class="w-full px-4 py-2 bg-gray-700 border-2 border-amber-600 rounded text-gray-200 focus:outline-none focus:border-amber-400">
            </div>
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-amber-400 text-sm mb-1">Caducidad</label>
                    <input type="text" name="caducidad" placeholder="MM/AA" maxlength="5"
                           class="w-full px-4 py-2 bg-gray-700 border-2 border-amber-600 rounded text-gray-200 focus:outline-none focus:border-amber-400">
                </div>
                <div>
                    <label class="block text-amber-400 text-sm mb-1">CVV</label>
                    <input type="text" name="cvv" placeholder="123" maxlength="3"
                           class="w-full px-4 py-2 bg-gray-700 border-2 border-amber-600 rounded text-gray-200 focus:outline-none focus:border-amber-400">
                </div>
            </div>
            <div class="flex justify-between">
                <button type="button" onclick="siguientePaso(1)" class="bg-gray-600 hover:bg-gray-500 text-white font-bold py-2 px-4 rounded border border-gray-500 transition">
                    Anterior
                </button>
                <button type="button" onclick="siguientePaso(3)" class="bg-amber-700 hover:bg-amber-600 text-white font-bold py-2 px-6 rounded border border-amber-500 shadow transition">
                    Siguiente
                </button>
            </div>
        </div>

        <!-- Paso 3: Confirmación -->
        <div id="paso3" class="paso bg-gray-800 border-2 border-amber-700 rounded-lg p-6 hidden">
            <h2 class="text-xl text-amber-400 mb-4">Confirmar compra</h2>
            <div class="bg-gray-900/50 p-4 rounded border border-amber-700 mb-6">
                <h3 class="text-amber-300 mb-2">Resumen del pedido</h3>
                <?php
                $totalCheckout = 0;
                foreach ($_SESSION['carrito']['items'] as $idCurso => $item):
                    $cursoCheckout = \App\Models\Curso::find($idCurso);
                    if ($cursoCheckout):
                        $totalCheckout += $cursoCheckout['precio'];
                ?>
                    <div class="flex justify-between text-gray-200 py-1">
                        <span><?= htmlspecialchars($cursoCheckout['titulo']) ?></span>
                        <span class="text-yellow-400"><?= number_format($cursoCheckout['precio'], 2) ?> €</span>
                    </div>
                <?php endif; endforeach; ?>
                <div class="border-t border-amber-600 mt-2 pt-2 flex justify-between font-bold text-amber-300">
                    <span>Total</span>
                    <span><?= number_format($totalCheckout, 2) ?> €</span>
                </div>
            </div>
            <div class="flex justify-between">
                <button type="button" onclick="siguientePaso(2)" class="bg-gray-600 hover:bg-gray-500 text-white font-bold py-2 px-4 rounded border border-gray-500 transition">
                    Anterior
                </button>
                <button type="submit" class="bg-green-700 hover:bg-green-600 text-white font-bold py-2 px-6 rounded border border-green-500 shadow transition">
                    Confirmar pago
                </button>
            </div>
        </div>
    </form>
</div>

<script>
    function siguientePaso(paso) {
        document.querySelectorAll('.paso').forEach(el => el.classList.add('hidden'));
        document.getElementById('paso' + paso).classList.remove('hidden');

        for(let i=1; i<=3; i++) {
            let ind = document.getElementById('paso'+i+'-ind');
            if(i <= paso) {
                ind.classList.add('bg-amber-700');
                ind.classList.remove('bg-gray-600');
            } else {
                ind.classList.add('bg-gray-600');
                ind.classList.remove('bg-amber-700');
            }
        }
    }
</script>
<?php $content = ob_get_clean(); ?>
<?php require __DIR__ . '/../layouts/main.php'; ?>