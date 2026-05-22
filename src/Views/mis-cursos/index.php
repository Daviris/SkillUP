<?php ob_start(); ?>
<div style="max-width:1200px; margin:0 auto;">
    <!-- Cabecera -->
    <div class="fade-in-up" style="margin-bottom:2rem;">
        <h1 class="font-rpg" style="font-size:2.8rem; color:#fbbf24; margin-bottom:0.5rem; text-shadow:0 0 15px rgba(251,191,36,0.4);">
            	<i class="fa-solid fa-book"></i> Tus Misiones Adquiridas
        </h1>
        <p style="color:#94a3b8; font-size:1.1rem;">
            Aquí están los cursos que has comprado. ¡Empieza a aprender!
        </p>
    </div>

    <!-- Contenido -->
    <?php if (!empty($cursos)): ?>
        <div id="mis-cursos-grid" style="display:grid; grid-template-columns:repeat(3, 1fr); gap:1.5rem;">
            <?php foreach ($cursos as $index => $curso): ?>
                <div class="course-card fade-in-up" style="display:flex; flex-direction:column; height:100%; transition-delay:<?= 0.1 * $index ?>s;">
                    <!-- Portada con icono -->
                    <div class="course-cover" style="background: linear-gradient(135deg, #1e3a5f, #0f172a); height:120px; display:flex; align-items:center; justify-content:center; font-size:3rem; border-radius:0.75rem 0.75rem 0 0; position:relative; overflow:hidden;">
                        <i class="fa-solid fa-scroll"></i>
                        <span class="badge" style="position:absolute; top:0.75rem; left:0.75rem; background:#065f46; color:white; font-size:0.7rem;">Adquirido</span>
                    </div>
                    <!-- Contenido de la tarjeta -->
                    <div style="padding:1.25rem; background:#1e293b; border-radius:0 0 0.75rem 0.75rem; border:1px solid #334155; border-top:none; flex:1; display:flex; flex-direction:column;">
                        <h3 class="card-title" style="font-size:1.2rem; margin-bottom:0.5rem;">
                            <?= htmlspecialchars($curso['titulo']) ?>
                        </h3>
                        <p style="color:#94a3b8; font-size:0.9rem; margin-bottom:0.75rem; line-height:1.4;">
                            <?= htmlspecialchars(substr($curso['descripcion'] ?? '', 0, 90)) ?>...
                        </p>
                        <!-- Instructor -->
                        <div style="display:flex; align-items:center; gap:0.5rem; margin-bottom:0.75rem; font-size:0.85rem;">
                            <span style="color:#94a3b8;"><i class="fa-solid fa-hat-wizard"></i> <?= htmlspecialchars($curso['instructor_nombre'] ?? 'N/A') ?></span>
                        </div>
                        <!-- Botón de acción (empujado al fondo) -->
                        <div style="margin-top:auto;">
                            <a href="/mis-cursos/ver/<?= $curso['id'] ?>" class="btn btn-primary" style="width:100%; background:linear-gradient(135deg, #b45309, #d97706); border:none; padding:0.7rem; font-size:0.95rem;">
                                <i class="fa-solid fa-sword"></i> Acceder a misión
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="fade-in-up card" style="padding:3rem; text-align:center;">
            <p style="font-size:4rem; margin-bottom:1rem;"><i class="fa-solid fa-inbox"></i></p>
            <h2 class="font-rpg" style="font-size:1.8rem; color:#fbbf24; margin-bottom:0.5rem;">No has adquirido ninguna misión</h2>
            <p style="color:#94a3b8; margin-bottom:2rem;">Explora el tablón y encuentra cursos que te ayuden a subir de nivel.</p>
            <a href="/cursos" class="btn btn-primary" style="background:linear-gradient(135deg, #b45309, #d97706); border:none;">
                <i class="fa-solid fa-map"></i> Ir al tablón de misiones
            </a>
        </div>
    <?php endif; ?>
</div>
<?php $content = ob_get_clean(); ?>
<?php require __DIR__ . '/../layouts/main.php'; ?>