<?php ob_start(); ?>

<div id="ultimo-curso-visitado" style="display:none;"></div>

<div class="text-center" style="padding:2rem 0;">
    <!-- Título principal con animación -->
    <h1 class="font-rpg fade-in-up" style="font-size:4rem; color:#fbbf24; text-shadow:0 0 15px rgba(251,191,36,0.6); margin-bottom:1rem;">
        SkillUP
    </h1>

    <!-- Subtítulo con animación y retraso -->
    <p class="fade-in-up" style="font-size:1.3rem; color:#cbd5e1; margin-bottom:2rem; transition-delay:0.2s;">
        Sube de nivel aprendiendo nuevas habilidades
    </p>

    <!-- Carrusel con animación y retraso -->
    <div class="carousel fade-in-up" id="homeCarousel" style="transition-delay:0.4s; min-width: 1000px;">
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
        <div class="carousel-dots">
            <span class="carousel-dot active" data-slide="0"></span>
            <span class="carousel-dot" data-slide="1"></span>
            <span class="carousel-dot" data-slide="2"></span>
        </div>
    </div>

    <!-- Botón con animación y retraso -->
    <a href="/cursos" class="btn btn-primary fade-in-up" style="font-size:1.2rem; margin-top:1.5rem; transition-delay:0.6s;">
        🔍 Explorar cursos
    </a>

    <!-- Estadísticas en tarjetas (dinámicas) -->
    <div class="grid-3" style="margin-top:4rem;">
        <div class="card text-center fade-in-up" style="transition-delay:0.8s;">
            <p style="font-size:3rem; color:#fbbf24; font-weight:700;"><?= $totalCursos ?></p>
            <p class="card-text">Cursos disponibles</p>
        </div>
        <div class="card text-center fade-in-up" style="transition-delay:1s;">
            <p style="font-size:3rem; color:#fbbf24; font-weight:700;"><?= $totalAlumnos ?></p>
            <p class="card-text">Alumnos aprendiendo</p>
        </div>
        <div class="card text-center fade-in-up" style="transition-delay:1.2s;">
            <p style="font-size:3rem; color:#fbbf24; font-weight:700;"><?= $totalInstructores ?></p>
            <p class="card-text">Instructores expertos</p>
        </div>
    </div>

    <!-- Características (antes de los números) -->
    <div class="grid-3" style="margin-top:4rem;">
        <div class="card text-center fade-in-up" style="transition-delay:1.4s;">
            <h3 class="card-title">⏳ A tu ritmo</h3>
            <p class="card-text">Accede cuando quieras</p>
        </div>
        <div class="card text-center fade-in-up" style="transition-delay:1.6s;">
            <h3 class="card-title">👨‍🏫 Expertos</h3>
            <p class="card-text">Instructores con experiencia real</p>
        </div>
        <div class="card text-center fade-in-up" style="transition-delay:1.8s;">
            <h3 class="card-title">📜 Certificados</h3>
            <p class="card-text">Valida tus conocimientos</p>
        </div>
    </div>
</div>

<script>
// Carrusel con opacidad y altura fija
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

    setInterval(() => {
        let next = current + 1 >= slides.length ? 0 : current + 1;
        showSlide(next);
    }, 4000);

    dots.forEach(dot => {
        dot.addEventListener('click', function() {
            showSlide(parseInt(this.dataset.slide));
        });
    });
})();

// Animación de aparición progresiva
window.addEventListener('DOMContentLoaded', function() {
    const elements = document.querySelectorAll('.fade-in-up');
    elements.forEach(function(el) {
        el.classList.add('visible');
    });
});
</script>
<?php $content = ob_get_clean(); ?>
<?php require __DIR__ . '/layouts/main.php'; ?>