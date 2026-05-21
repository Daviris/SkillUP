<?php ob_start(); ?>
<div class="hero-section fade-in-up" style="position: relative; overflow: visible; padding: 4rem 0 3rem; text-align: center;">
    
    <div style="max-width: 900px; margin: 0 auto; position: relative; z-index: 2;">
        <!-- Logo / Icono principal -->
        <div style="margin-bottom: 1.5rem;">
            <img src="/img/logo.png" alt="SkillUP Logo" style="height: 8rem; filter: drop-shadow(0 0 20px rgba(251, 191, 36, 0.5)); margin-bottom: 0.5;">
        </div>

        <!-- Título principal -->
        <h1 class="font-rpg" style="font-size: 4.5rem; color: #fbbf24; margin-bottom: 0.5rem; text-shadow: 0 0 30px rgba(251,191,36,0.6), 0 4px 8px rgba(0,0,0,0.5); letter-spacing: 3px;">
            SkillUP
        </h1>

        <!-- Subtítulo -->
        <p style="font-size: 1.4rem; color: #cbd5e1; margin-bottom: 0.75rem; font-weight: 300;">
            Forja tu leyenda, conquista el conocimiento
        </p>
        <p style="font-size: 1.1rem; color: #94a3b8; margin-bottom: 2.5rem; max-width: 650px; margin-left: auto; margin-right: auto;">
            Únete a la comunidad de aventureros que ya están subiendo de nivel con nuestros cursos online y presenciales.
        </p>

        <!-- Botones de acción -->
        <div style="display: flex; gap: 1.2rem; justify-content: center; flex-wrap: wrap;">
            <a href="/cursos" class="btn btn-primary" style="font-size: 1.15rem; padding: 0.9rem 2.5rem; box-shadow: 0 0 20px rgba(251,191,36,0.3);">
                🗺️ Explorar cursos
            </a>
            <?php if (!isset($_SESSION['usuario'])): ?>
                <a href="/register" class="btn btn-secondary" style="font-size: 1.15rem; padding: 0.9rem 2.5rem; border-color: #fbbf24; color: #fbbf24;">
                    ✨ Crear cuenta gratuita
                </a>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Carrusel -->
<div class="carousel fade-in-up" id="homeCarousel" style="transition-delay:0.4s;">
    <div class="carousel-track">
        <div class="carousel-slide active">
            <h2>🔥 Aprende a tu ritmo</h2>
            <p>Cursos online y presenciales con horarios flexibles</p>
        </div>
        <div class="carousel-slide">
            <h2>🧠 Instructores expertos</h2>
            <p>Aprende de profesionales con experiencia real</p>
        </div>
        <div class="carousel-slide">
            <h2>📜 Certifícate</h2>
            <p>Obtén un diploma al finalizar cada curso</p>
        </div>
    </div>
    <div class="carousel-dots">
        <span class="carousel-dot active" data-slide="0"></span>
        <span class="carousel-dot" data-slide="1"></span>
        <span class="carousel-dot" data-slide="2"></span>
    </div>
</div>

<!-- Estadísticas -->
<div class="fade-in-up" style="max-width: 1100px; margin: 0 auto 4rem; padding: 0 1rem;">
    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 2rem;">
        <div class="stat-card">
            <div class="stat-icon">🗡️</div>
            <div class="stat-number"><?= $totalCursos ?></div>
            <div class="stat-label">Misiones disponibles</div>
            <div class="stat-desc">Cursos para todos los niveles</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">🧑‍🎓</div>
            <div class="stat-number"><?= $totalAlumnos ?></div>
            <div class="stat-label">Aventureros activos</div>
            <div class="stat-desc">Alumnos forjando su leyenda</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">🧙</div>
            <div class="stat-number"><?= $totalInstructores ?></div>
            <div class="stat-label">Maestros guías</div>
            <div class="stat-desc">Instructores con experiencia real</div>
        </div>
    </div>
</div>

<!-- Características con iconos SVG -->
<div class="fade-in-up" style="max-width: 1100px; margin: 0 auto 2rem; padding: 0 1rem;">
    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 2rem;">
        <div class="feature-card">
            <div style="font-size: 2.5rem; margin-bottom: 1rem;">🛡️</div>
            <h3 class="font-rpg" style="font-size: 1.4rem; color: #fbbf24; margin-bottom: 0.5rem;">Acceso de por vida</h3>
            <p style="color: #94a3b8; font-size: 0.95rem;">Tendrás acceso ilimitado al contenido para que puedas repasar siempre que quieras.</p>
        </div>
        <div class="feature-card">
            <div style="font-size: 2.5rem; margin-bottom: 1rem;">🏆</div>
            <h3 class="font-rpg" style="font-size: 1.4rem; color: #fbbf24; margin-bottom: 0.5rem;">Retos prácticos</h3>
            <p style="color: #94a3b8; font-size: 0.95rem;">Cada curso incluye ejercicios y tareas para que pongas a prueba lo aprendido.</p>
        </div>
        <div class="feature-card">
            <div style="font-size: 2.5rem; margin-bottom: 1rem;">💬</div>
            <h3 class="font-rpg" style="font-size: 1.4rem; color: #fbbf24; margin-bottom: 0.5rem;">Comunidad activa</h3>
            <p style="color: #94a3b8; font-size: 0.95rem;">Resuelve dudas y comparte experiencias con otros aventureros y con el instructor.</p>
        </div>
    </div>
</div>
<?php $content = ob_get_clean(); ?>
<?php require __DIR__ . '/layouts/main.php'; ?>