<?php ob_start(); ?>
<div class="text-center" style="padding:2rem 0; position:relative; overflow:hidden;">
    <!-- Hero Section con partículas -->
    <div style="position:relative; padding:4rem 0 3rem;">
        <!-- Partículas decorativas generadas con PHP -->
        <?php for ($i = 0; $i < 20; $i++): ?>
            <div class="particle" style="
                left: <?= rand(5, 95) ?>%;
                top: <?= rand(10, 90) ?>%;
                animation-delay: <?= rand(0, 4) ?>s;
                animation-duration: <?= rand(3, 6) ?>s;
                width: <?= rand(4, 8) ?>px;
                height: <?= rand(4, 8) ?>px;
            "></div>
        <?php endfor; ?>

        <!-- Título principal con animación -->
        <h1 class="font-rpg animate-fade-in-up" style="font-size:5rem; color:#fbbf24; text-shadow:0 0 20px rgba(251,191,36,0.7); margin-bottom:1rem;">
            ⚡ SkillUP
        </h1>
        <p class="animate-fade-in-up delay-1" style="font-size:1.5rem; color:#cbd5e1; margin-bottom:0.5rem;">
            Sube de nivel aprendiendo nuevas habilidades
        </p>
        <p class="animate-fade-in-up delay-2" style="font-size:1.1rem; color:#94a3b8; margin-bottom:2rem;">
            La plataforma de aprendizaje que te lleva al siguiente nivel
        </p>
        
        <!-- Botón principal con animación de pulso -->
        <a href="/cursos" class="btn btn-primary animate-fade-in-up delay-3 animate-pulse" style="font-size:1.3rem; padding:0.8rem 2.5rem;">
            🔍 Explorar cursos
        </a>
    </div>

    <!-- Carrusel con animaciones -->
    <div class="carousel animate-fade-in-up delay-4" id="homeCarousel" style="height:300px; max-width:900px; margin:0 auto;">
        <div class="carousel-slide active">
            <div style="font-size:3rem; margin-bottom:0.5rem;">🔥</div>
            <h2>Aprende a tu ritmo</h2>
            <p>Cursos online y presenciales con horarios flexibles que se adaptan a tu vida</p>
        </div>
        <div class="carousel-slide">
            <div style="font-size:3rem; margin-bottom:0.5rem;">🧠</div>
            <h2>Instructores expertos</h2>
            <p>Aprende de profesionales con experiencia real en el sector</p>
        </div>
        <div class="carousel-slide">
            <div style="font-size:3rem; margin-bottom:0.5rem;">📜</div>
            <h2>Certifícate</h2>
            <p>Obtén un diploma al finalizar cada curso y valida tus conocimientos</p>
        </div>
        <div class="carousel-dots">
            <span class="carousel-dot active" data-slide="0"></span>
            <span class="carousel-dot" data-slide="1"></span>
            <span class="carousel-dot" data-slide="2"></span>
        </div>
    </div>

    <!-- Estadísticas animadas -->
    <div class="grid-3 animate-fade-in-up delay-5" style="margin-top:4rem;">
        <div class="card text-center" style="padding:2rem;">
            <div style="font-size:3rem; color:#fbbf24; font-weight:700;" class="count-animate">+50</div>
            <p style="color:#cbd5e1; margin-top:0.5rem; font-size:1.1rem;">Cursos disponibles</p>
            <p style="color:#94a3b8; font-size:0.9rem;">En constante actualización</p>
        </div>
        <div class="card text-center" style="padding:2rem;">
            <div style="font-size:3rem; color:#fbbf24; font-weight:700;" class="count-animate">+1000</div>
            <p style="color:#cbd5e1; margin-top:0.5rem; font-size:1.1rem;">Estudiantes activos</p>
            <p style="color:#94a3b8; font-size:0.9rem;">Creciendo cada día</p>
        </div>
        <div class="card text-center" style="padding:2rem;">
            <div style="font-size:3rem; color:#fbbf24; font-weight:700;" class="count-animate">4.8</div>
            <p style="color:#cbd5e1; margin-top:0.5rem; font-size:1.1rem;">Valoración media</p>
            <p style="color:#94a3b8; font-size:0.9rem;">★★★★★ por nuestros alumnos</p>
        </div>
    </div>

    <!-- Sección de características con iconos -->
    <div style="margin-top:5rem;">
        <h2 class="font-rpg animate-fade-in" style="font-size:2.5rem; color:#fbbf24; margin-bottom:2rem;">¿Por qué SkillUP?</h2>
        <div class="grid-3">
            <div class="card text-center animate-fade-in-up delay-1" style="padding:2rem;">
                <div style="font-size:3rem; margin-bottom:1rem;">⏳</div>
                <h3 class="card-title">A tu ritmo</h3>
                <p class="card-text">Accede cuando quieras, sin horarios fijos. Avanza a la velocidad que prefieras.</p>
            </div>
            <div class="card text-center animate-fade-in-up delay-2" style="padding:2rem;">
                <div style="font-size:3rem; margin-bottom:1rem;">👨‍🏫</div>
                <h3 class="card-title">Instructores expertos</h3>
                <p class="card-text">Profesionales en activo que comparten su conocimiento y experiencia real.</p>
            </div>
            <div class="card text-center animate-fade-in-up delay-3" style="padding:2rem;">
                <div style="font-size:3rem; margin-bottom:1rem;">📜</div>
                <h3 class="card-title">Certificados</h3>
                <p class="card-text">Obtén un diploma al finalizar y añade valor a tu currículum.</p>
            </div>
            <div class="card text-center animate-fade-in-up delay-4" style="padding:2rem;">
                <div style="font-size:3rem; margin-bottom:1rem;">💰</div>
                <h3 class="card-title">Precios justos</h3>
                <p class="card-text">Cursos de calidad a precios accesibles. Invierte en tu futuro.</p>
            </div>
            <div class="card text-center animate-fade-in-up delay-5" style="padding:2rem;">
                <div style="font-size:3rem; margin-bottom:1rem;">🛡️</div>
                <h3 class="card-title">Garantía de calidad</h3>
                <p class="card-text">Si no estás satisfecho, te devolvemos tu dinero en los primeros 7 días.</p>
            </div>
            <div class="card text-center animate-fade-in-up delay-5" style="padding:2rem;">
                <div style="font-size:3rem; margin-bottom:1rem;">🌐</div>
                <h3 class="card-title">Acceso global</h3>
                <p class="card-text">Estudia desde cualquier lugar del mundo. Solo necesitas conexión a internet.</p>
            </div>
        </div>
    </div>

    <!-- Call to Action final -->
    <div class="animate-fade-in-up" style="margin-top:5rem; padding:3rem; background:linear-gradient(135deg, #1e293b, #0f172a); border:2px solid #b45309; border-radius:1rem;">
        <h2 class="font-rpg" style="font-size:2.5rem; color:#fbbf24; margin-bottom:1rem;">¿Listo para subir de nivel?</h2>
        <p style="color:#cbd5e1; font-size:1.1rem; margin-bottom:2rem;">Únete a más de 1000 estudiantes que ya están mejorando sus habilidades.</p>
        <a href="/register" class="btn btn-primary animate-pulse" style="font-size:1.2rem; padding:0.8rem 2.5rem;">
            ✨ Crear cuenta gratis
        </a>
    </div>
</div>

<script>
// Carrusel con animaciones
(function() {
    const slides = document.querySelectorAll('.carousel-slide');
    const dots = document.querySelectorAll('.carousel-dot');
    let current = 0;

    function showSlide(index) {
        slides.forEach(s => s.classList.remove('active'));
        dots.forEach(d => d.classList.remove('active'));
        slides[index].classList.add('active');
        dots[index].classList.add('active');
        current = index;
    }

    // Cambio automático cada 4 segundos
    setInterval(() => {
        let next = current + 1 >= slides.length ? 0 : current + 1;
        showSlide(next);
    }, 4000);

    // Navegación por puntos
    dots.forEach(dot => {
        dot.addEventListener('click', function() {
            showSlide(parseInt(this.dataset.slide));
        });
    });
})();

// Animación de elementos al hacer scroll
(function() {
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, { threshold: 0.1 });

    document.querySelectorAll('.animate-fade-in-up').forEach(el => {
        observer.observe(el);
    });
})();
</script>
<?php $content = ob_get_clean(); ?>
<?php require __DIR__ . '/layouts/main.php'; ?>