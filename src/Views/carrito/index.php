<?php ob_start(); ?>
<div style="max-width:900px; margin:0 auto;">
    <h1 class="font-rpg" style="font-size:2.5rem; color:#fbbf24; margin-bottom:0.5rem;">
        🎒 Tu Mochila de Conocimiento
    </h1>
    <p style="color:#9ca3af; margin-bottom:2rem;">Cursos que has añadido para adquirir</p>

    <?php if (!empty($cursos)): ?>
        <div class="card" style="padding:1.5rem; margin-bottom:2rem;">
            <div class="table-container">
                <table style="width:100%;">
                    <thead>
                        <tr>
                            <th>Curso</th>
                            <th>Instructor</th>
                            <th>Precio</th>
                            <th style="text-align:right;">Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($cursos as $curso): ?>
                        <tr>
                            <td style="font-weight:600; color:#fbbf24;"><?= htmlspecialchars($curso['titulo']) ?></td>
                            <td style="color:#cbd5e1;"><?= htmlspecialchars($curso['instructor_nombre'] ?? 'N/A') ?></td>
                            <td style="color:#fbbf24; font-weight:700;"><?= number_format($curso['precio'], 2) ?> €</td>
                            <td style="text-align:right;">
                                <a href="/carrito/eliminar/<?= $curso['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Quitar este curso de la mochila?')">
                                    🗑️ Quitar
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr style="border-top:2px solid #b45309;">
                            <td colspan="2" style="text-align:right; font-weight:700; color:#fbbf24; padding-top:1rem;">
                                Total:
                            </td>
                            <td style="font-size:1.3rem; font-weight:700; color:#fbbf24; padding-top:1rem;">
                                <?= number_format($total, 2) ?> €
                            </td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <div style="display:flex; gap:1rem; justify-content:flex-end;">
            <a href="/carrito/vaciar" class="btn btn-secondary" onclick="return confirm('¿Vaciar completamente la mochila?')">
                🗑️ Vaciar mochila
            </a>
            <a href="/checkout" class="btn btn-primary" style="font-size:1.1rem;">
                ⚔️ Finalizar misión (Comprar)
            </a>
        </div>
    <?php else: ?>
        <div class="card" style="padding:3rem; text-align:center;">
            <p style="font-size:3rem; margin-bottom:1rem;">🎒</p>
            <p style="color:#cbd5e1; font-size:1.2rem; margin-bottom:1.5rem;">Tu mochila está vacía.</p>
            <p style="color:#9ca3af; margin-bottom:2rem;">Visita el catálogo de cursos para equiparte con nuevos conocimientos.</p>
            <a href="/cursos" class="btn btn-primary">🔍 Explorar cursos</a>
        </div>
    <?php endif; ?>

    <div style="margin-top:2rem;">
        <a href="/cursos" style="color:#fbbf24;">← Volver al catálogo</a>
    </div>
</div>
<?php $content = ob_get_clean(); ?>
<?php require __DIR__ . '/../layouts/main.php'; ?>