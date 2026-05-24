<?php ob_start(); ?>
<div style="max-width:800px; margin:0 auto;">
    <div class="fade-in-up" style="margin-bottom:2rem;">
        <h1 class="font-rpg" style="font-size:2.5rem; color:#fbbf24; margin-bottom:0.5rem;">
            <i class="fa-solid fa-sword"></i> Finalizar Misión
        </h1>
        <p style="color:#94a3b8; font-size:1.1rem;">Completa los pasos para adquirir tus cursos</p>
    </div>

    <!-- Indicadores de paso -->
    <div class="fade-in-up" style="transition-delay:0.2s; display:flex; margin-bottom:2rem; gap:1rem;">
        <div style="flex:1; text-align:center;">
            <span id="paso1-ind" class="badge" style="background:#b45309; color:white; font-size:0.9rem; padding:0.5rem 1rem;">1 · Datos</span>
        </div>
        <div style="flex:1; text-align:center;">
            <span id="paso2-ind" class="badge" style="background:#4b5563; color:white; font-size:0.9rem; padding:0.5rem 1rem;">2 · Tarjeta</span>
        </div>
        <div style="flex:1; text-align:center;">
            <span id="paso3-ind" class="badge" style="background:#4b5563; color:white; font-size:0.9rem; padding:0.5rem 1rem;">3 · Confirmar</span>
        </div>
    </div>

    <form id="checkout-form" method="POST" action="/checkout/procesar" novalidate>
        <?= \App\Core\Csrf::tokenField() ?>
        <!-- Paso 1: Datos personales -->
        <div id="paso1" class="paso card fade-in-up" style="padding:2rem;">
            <h2 class="font-rpg" style="font-size:1.8rem; color:#fbbf24; margin-bottom:1.5rem;"><i class="fa-solid fa-clipboard-list"></i> Datos personales</h2>
            <div class="form-group">
                <label class="form-label">Nombre completo</label>
                <input type="text" name="nombre" class="form-input" value="<?= htmlspecialchars($_SESSION['usuario']['nombre'] ?? '') ?>">
            </div>
            <div class="form-group">
                <label class="form-label">Correo electrónico</label>
                <input type="text" name="email" class="form-input" value="<?= htmlspecialchars($_SESSION['usuario']['email'] ?? '') ?>">
            </div>
            <div class="form-group">
                <label class="form-label">Teléfono</label>
                <input type="text" name="telefono" class="form-input" placeholder="+34 600 000 000">
            </div>
            <div style="text-align:right; margin-top:1.5rem;">
                <button type="button" onclick="siguientePaso(2)" class="btn btn-primary" style="background:linear-gradient(135deg, #b45309, #d97706); border:none;">
                    Siguiente →
                </button>
            </div>
        </div>

        <!-- Paso 2: Tarjeta (simulado) -->
        <div id="paso2" class="paso card hidden fade-in-up" style="padding:2rem;">
            <h2 class="font-rpg" style="font-size:1.8rem; color:#fbbf24; margin-bottom:1rem;"><i class="fa-regular fa-credit-card"></i> Datos de pago</h2>
            <p style="color:#94a3b8; margin-bottom:1.5rem;">Estos datos son simulados y no se almacenarán.</p>
            <div class="form-group">
                <label class="form-label">Titular de la tarjeta</label>
                <input type="text" name="titular" class="form-input" placeholder="Nombre en la tarjeta">
            </div>
            <div class="form-group">
                <label class="form-label">Número de tarjeta</label>
                <input type="text" name="tarjeta" class="form-input" placeholder="0000 0000 0000 0000" maxlength="19">
            </div>
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:1rem;">
                <div class="form-group">
                    <label class="form-label">Caducidad</label>
                    <input type="text" name="caducidad" class="form-input" placeholder="MM/AA" maxlength="5">
                </div>
                <div class="form-group">
                    <label class="form-label">CVV</label>
                    <input type="text" name="cvv" class="form-input" placeholder="123" maxlength="3">
                </div>
            </div>
            <div style="display:flex; justify-content:space-between; margin-top:1.5rem;">
                <button type="button" onclick="siguientePaso(1)" class="btn btn-secondary">← Anterior</button>
                <button type="button" onclick="siguientePaso(3)" class="btn btn-primary" style="background:linear-gradient(135deg, #b45309, #d97706); border:none;">
                    Siguiente →
                </button>
            </div>
        </div>

        <!-- Paso 3: Confirmación -->
        <div id="paso3" class="paso card hidden fade-in-up" style="padding:2rem;">
            <h2 class="font-rpg" style="font-size:1.8rem; color:#fbbf24; margin-bottom:1rem;"><i class="fa-solid fa-circle-check"></i> Confirmar compra</h2>

            <div class="card" style="background:#0f172a; margin-bottom:1.5rem; padding:1.5rem; border:1px solid #334155;">
                <h3 class="font-rpg" style="font-size:1.3rem; color:#fbbf24; margin-bottom:1rem;">Resumen del pedido</h3>
                <?php
                $totalCheckout = 0;
                foreach ($_SESSION['carrito']['items'] as $idCurso => $item):
                    $cursoCheckout = \App\Models\Curso::find($idCurso);
                    if ($cursoCheckout):
                        $totalCheckout += $cursoCheckout['precio'];
                ?>
                    <div style="display:flex; justify-content:space-between; padding:0.5rem 0; border-bottom:1px solid #374151; color:#cbd5e1;">
                        <span><?= htmlspecialchars($cursoCheckout['titulo']) ?></span>
                        <span style="color:#fbbf24;"><?= number_format($cursoCheckout['precio'], 2) ?> €</span>
                    </div>
                <?php endif; endforeach; ?>
                <div style="display:flex; justify-content:space-between; padding-top:1rem; font-weight:700; font-size:1.2rem; color:#fbbf24;">
                    <span>Total</span>
                    <span><?= number_format($totalCheckout, 2) ?> €</span>
                </div>
            </div>

            <div style="display:flex; justify-content:space-between;">
                <button type="button" onclick="siguientePaso(2)" class="btn btn-secondary">← Anterior</button>
                <button type="submit" class="btn btn-success" style="background:linear-gradient(135deg, #065f46, #047857); border:none;">
                    <i class="fa-solid fa-circle-check"></i> Confirmar pago
                </button>
            </div>
        </div>
    </form>
</div>
<?php $content = ob_get_clean(); ?>
<?php require __DIR__ . '/../layouts/main.php'; ?>