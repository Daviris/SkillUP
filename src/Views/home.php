<?php ob_start(); ?>
<div class="text-center" style="padding:2rem 0;">
    <h1 class="font-rpg" style="font-size:4rem; color:#fbbf24; text-shadow:0 0 15px rgba(251,191,36,0.6);">SkillUP</h1>
    <p style="font-size:1.3rem; color:#cbd5e1; margin-bottom:2rem;">Sube de nivel aprendiendo nuevas habilidades</p>

    <!-- Carrusel con altura fija -->
    <div class="carousel" id="homeCarousel">
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

    <a href="/cursos" class="btn btn-primary" style="font-size:1.2rem; margin-top:1.5rem;">🔍 Explorar cursos</a>

    <div class="grid-3" style="margin-top:4rem;">
        <div class="card text-center">
            <h3 class="card-title">⏳ A tu ritmo</h3>
            <p class="card-text">Accede cuando quieras</p>
        </div>
        <div class="card text-center">
            <h3 class="card-title">👨‍🏫 Expertos</h3>
            <p class="card-text">Instructores con experiencia real</p>
        </div>
        <div class="card text-center">
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
</script>
<?php $content = ob_get_clean(); ?>
<?php require __DIR__ . '/layouts/main.php'; ?>