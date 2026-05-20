<?php ob_start(); ?>
<div style="max-width:900px; margin:0 auto;">
    <div class="fade-in-up" style="margin-bottom:2rem;">
        <h1 class="font-rpg" style="font-size:2.5rem; color:#fbbf24; margin-bottom:0.5rem;">
            🎒 Tu Mochila de Conocimiento
        </h1>
        <p style="color:#94a3b8; font-size:1.1rem;">Cursos que has añadido para adquirir</p>
    </div>

    <?php if (!empty($cursos)): ?>
        <div class="fade-in-up" style="transition-delay:0.2s;">
            <!-- Lista de cursos en tarjetas -->
            <div style="display:grid; gap:1rem; margin-bottom:2rem;">
                <?php foreach ($cursos as $curso): ?>
                    <div class="card" style="padding:1.5rem; display:flex; justify-content:space-between; align-items:center; background:linear-gradient(135deg, #1e293b, #0f172a); border:1px solid #334155;">
                        <div style="flex:1;">
                            <h3 class="card-title" style="font-size:1.2rem; margin-bottom:0.25rem;">
                                <?= htmlspecialchars($curso['titulo']) ?>
                            </h3>
                            <p style="color:#94a3b8; font-size:0.9rem;">
                                🧙 <?= htmlspecialchars($curso['instructor_nombre'] ?? 'N/A') ?>
                            </p>
                            <?php if ($curso['modalidad'] === 'presencial' && !empty($curso['fecha'])): ?>
                                <p style="color:#6b7280; font-size:0.8rem; margin-top:0.25rem;">
                                    📅 <?= date('d/m/Y', strtotime($curso['fecha'])) ?> · 🕐 <?= $curso['hora'] ?? '--:--' ?>
                                </p>
                            <?php endif; ?>
                        </div>
                        <div style="text-align:right; margin-left:2rem;">
                            <span style="font-size:1.3rem; font-weight:bold; color:#fbbf24;">
                                <?= number_format($curso['precio'], 2) ?> €
                            </span>
                            <br>
                            <a href="/carrito/eliminar/<?= $curso['id'] ?>" class="btn btn-danger btn-sm" style="margin-top:0.5rem;" onclick="return confirm('¿Quitar este curso de la mochila?')">
                                🗑️ Quitar
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Total y acciones -->
            <div class="card" style="padding:1.5rem; background:#0f172a; border:2px solid #b45309; display:flex; justify-content:space-between; align-items:center;">
                <div style="margin-right:auto; padding-right:3rem;">
                    <span style="color:#94a3b8; font-size:0.9rem;">Total de la mochila</span>
                    <div style="font-size:2rem; font-weight:bold; color:#fbbf24;">
                        <?= number_format($total, 2) ?> €
                    </div>
                </div>
                <div style="display:flex; gap:1rem; align-items:center;">
                    <a href="/carrito/vaciar" class="btn btn-secondary" onclick="return confirm('¿Vaciar completamente la mochila?')">
                        🗑️ Vaciar mochila
                    </a>
                    <a href="/checkout" class="btn btn-primary" style="padding:0.8rem 2rem; font-size:1rem; background:linear-gradient(135deg, #b45309, #d97706); border:none; box-shadow:0 0 20px rgba(251,191,36,0.3);">
                        ⚔️ Finalizar misión (Comprar)
                    </a>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="fade-in-up card" style="padding:3rem; text-align:center;">
            <p style="font-size:4rem; margin-bottom:1rem;">🎒</p>
            <h2 class="font-rpg" style="font-size:1.8rem; color:#fbbf24; margin-bottom:0.5rem;">Tu mochila está vacía</h2>
            <p style="color:#94a3b8; margin-bottom:2rem;">Visita el tablón de misiones y añade cursos para empezar tu aventura.</p>
            <a href="/cursos" class="btn btn-primary" style="background:linear-gradient(135deg, #b45309, #d97706); border:none;">
                🗺️ Explorar cursos
            </a>
        </div>
    <?php endif; ?>
</div>
<?php $content = ob_get_clean(); ?>
<?php require __DIR__ . '/../layouts/main.php'; ?>