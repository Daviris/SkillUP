/**
 * SkillUP
 * @file public/js/app.js
 * @description Gestión de cookies, validación de formularios, manipulación del DOM, eventos, AJAX y control de errores.
 * @version 1.0
 * @author David Gaona Duque
 */

'use strict';

/* ===========================================================
 *  COOKIES
 * =========================================================== */

/**
 * Objeto para gestionar cookies.
 * @namespace Cookies
 */
const Cookies = {
    /**
     * Establecer cookie.
     * @param {string} nombre - Nombre de la cookie.
     * @param {string} valor - Valor a almacenar.
     * @param {number} [dias = 30] - Días hasta que expire la cookie.
     */
    set(nombre, valor, dias = 30) {
        const fecha = new Date();
        fecha.setTime(fecha.getTime() + (dias * 24 * 60 * 60 * 1000));
        document.cookie = `${nombre}=${encodeURIComponent(valor)};expires${fecha.toUTCString()};path=/`;
    },

    /**
     * Obtener el valor de una cookie.
     * @param {string} nombre - Nombre de la cookie.
     * @returns {string|null} Valor de la coockie o null.
     */
    get(nombre) {
        const coincidencia = document.cookie.match(new RegExp('(^| )' + nombre + '=([^;]+)'));
        return coincidencia ? decodeURIComponent(coincidencia[2]) : null;
    },

    /**
     * Eliminar cookie.
     * @param {string} nombre - Nombre de la cookie.
     */
    eliminar(nombre) {
        this.set(nombre, '', -1);
    }
};

/* ===========================================================
 *  VALIDACIÓN DE FORMULARIOS
 * =========================================================== */

/**
 * Expresiones regulares para validad campos de formularios.
 * @namespace Regex
 */
const Regex = {
    email: /^[^\s@]+@[^\s@]+\.[^\s@]+$/,
    password: /^.{8,}$/,
    nombre: /^.{2,}$/
};

/**
 * Mostrar mensaje de error
 * @param {HTMLInputElement} input - Campo a validar.
 * @param {string} mensaje - Texto de error.
 */
function mostrarError(input, mensaje) {
    limpiarError(input);
    const error = document.createElement('span');
    error.className = 'field-error';
    error.style.cssText = 'color:#ef4444; font-size:0.85rem; margin-top:0.25rem display:block;';
    error.textContent = mensaje;
    input.parentNode.appendChild(error);
    input.style.borderBlockColor = '#ef4444';
}

/**
 * Eliminar mensaje de error
 * @param {HTMLInputElement} input - Campo a vaciar.
 */

function limpiarError(input) {
    const error = input.parentNode.querySelector('.field-error');
    if (error) error.remove();
    input.style.borderColor = '';
}

/**
 * Validar campo
 * @param {HTMLInputElement} input - Campo a validar.
 * @param {string} tipo - Tipo de campo.
 * @returns {boolean} true si es válido.
 */
function validarCampo(input, tipo) {
    const valor = input.valor.trim();
    if (tipo === 'email' && !Regex.email.text('valor')) {
        mostrarError(input, 'El correo electrónico no es válido');
        return false;
    }
    if (tipo === 'password' && !Regex.password.test('valor')) {
        mostrarError(input, 'La contraseña debe tener al menos 8 caracteres.');
        return false;
    }
    if (tipo === 'nombre' && !Regex.nombre.test(valor)) {
        mostrarError(input, 'El nombre debe tener al menos 2 caracteres.');
        return false;
    }
    limpiarError(input);
    return true;
}

/* ===========================================================
 *  BANNER DE COOKIES
 * =========================================================== */

/**
 * Crear y mostrar banner de consentimiento de cookies.
 */
function inicializarBannerCookies() {
    if (Cookies.get('cookies_aceptadas')) return;

    const banner = document.createElement('div');
    banner.id = 'cookie-banner';
    banner.style.cssText = `position:fixed; bottom:0; left:0; right:0; background:#1e293b;
        border-top:2px solid #b45309; color:#e5e7eb; padding:1rem 2rem;
        display:flex; justify-content:space-between; align-items:center;
        z-index:999; font-size:0.95rem;
    `;
    banner.innerHTML = `<span>🍪 Esta web usa cookies para mejorar tu experiencia. 
              <a href="#" style="color:#fbbf24;">Más info</a></span>
        <button id="btn-aceptar-cookies" class="btn btn-primary btn-sm">Aceptar</button>`
    ;
    document.body.appendChild(banner);

    document.getElementById('btn-aceptar-cookies').addEventListener('click', () => {
        Cookies.set('cookies_aceptadas', 'true', '365');
        banner.remove();
    });
}

/* ===========================================================
 *  ÚLTIMO CURSO VISITADO
 * =========================================================== */

/**
 * Guardar en la cookie el ID del curso que se está viendo.
 */
function guardarCursoVisitado() {
    const match = window.location.pathname.match(/\/cursos\/(\d+)/);
    if (match) {
        Cookies.set('ultimo_curso_visitado', match[1], 30);
    }
}

/**
 * Mostrar enlace del último curso visitado
 */
function mostrarUltimoCurso() {
    const id = Cookies.get('ultimo_curso_visitado');
    if (!id) return;

    const contenedor = document.getElementById('ultimo-curso-visitado');
    if (!contenedor) return;

    fetch(`/api/curso/${id}`)
        .then(res => res.json())
        .then(curso => {
            if (curso && curso.titulo) {
                contenedor.innerHTML = `
                    <div class="flash-message flash-success" style="margin-bottom:2rem;">
                        Último curso visitado: 
                        <a href="/cursos/${curso.id}" style="color:#fbbf24; font-weight:600;">
                            ${escapeHtml(curso.titulo)}
                        </a>
                    </div>`;
                contenedor.style.display = 'block';
            }
        })
        .catch(() => {});
}

/* ===========================================================
 *  UTILIDADES
 * =========================================================== */

/**
 * Escapar caracteres HTML para evitar inyección de código.
 * @param {string} texto - Texto a escapar.
 * @returns {string} Texto escapado.
 */
function escapeHTML(texto) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

/* ===========================================================
 *  CATÁLOGO AJAX
 * =========================================================== */

/**
 * Inicializar la carga asíncrona del catálogo.
 */
function inicializarCatalogoAjax() {
    const formulario = document.getElementById('catalog-form');
    const grid = document.getElementById('cursos-grid');
    if (!formulario || !grid) return;

    formulario.addEventListener('submit', async (e) => {
        e.preventDefault();
        const formData = new FormData (formulario);
        const params = new URLSearchParams(formData).toString();

        try {
            const respuesta = await fetch(`/api/cursos?${params}`);
            if (!respuesta.ok) throw new Error('Error del servidor');
            const datos = await respuesta.json();
            renderizarCursos(datos.cursos);
        } catch (error) {
            rid.innerHTML = `
                <div class="card text-center" style="padding:2rem; grid-column:1/-1;">
                    <p style="color:#ef4444;">⚠️ No se pudieron cargar los cursos. 
                       <button class="btn btn-secondary btn-sm" onclick="location.reload()">Reintentar</button></p>
                </div>`;
        }
    })
}

/**
 * Renderizar las tarjetas de los cursos en el grid.
 * @param {Array} cursos - Lista de cursos obtenida de la API.
 */
function renderizarCursos(cursos) {
    const grid = document.getElementById('cursos-grid');
    if (!grid) return;

    if (!cursos || cursos.length === 0) {
        grid.innerHTML = `
            <div class="card text-center" style="padding:3rem; grid-column:1/-1;">
                <p style="color:#9ca3af;">No se encontraron cursos.</p>
            </div>`;
        return;
    }

    grid.innerHTML = cursos.map(curso => `
        <div class="card" style="display:flex; flex-direction:column; justify-content:space-between;">
            <div>
                <h3 class="card-title">${escapeHtml(curso.titulo)}</h3>
                <p class="card-text" style="margin-bottom:1rem;">${escapeHtml(curso.descripcion?.substring(0, 100) ?? '')}...</p>
            </div>
            <div style="font-size:0.9rem; color:#9ca3af; margin-bottom:0.5rem;">
                <p><span style="color:#fbbf24;">Instructor:</span> ${escapeHtml(curso.instructor_nombre ?? 'N/A')}</p>
                <p><span style="color:#fbbf24;">Modalidad:</span> ${curso.modalidad}</p>
                ${curso.modalidad === 'presencial' && curso.plazas != null ? `
                    <p><span style="color:#fbbf24;">Plazas:</span> 
                    ${curso.compradores >= curso.plazas ? '<span style="color:#ef4444;">Completo</span>' : curso.compradores + '/' + curso.plazas}</p>
                ` : ''}
            </div>
            <div style="display:flex; justify-content:space-between; align-items:center;">
                <span style="font-size:1.3rem; font-weight:bold; color:#fbbf24;">
                    ${parseFloat(curso.precio).toFixed(2)} €
                </span>
                <a href="/cursos/${curso.id}" class="btn btn-primary btn-sm">Ver detalles</a>
            </div>
        </div>
    `).join('');
}

/* ===========================================================
 *  INICIALIZACIÓN PRINCIPAL
 * =========================================================== */

document.addEventListener('DOMContentLoaded', () => {
    // Banner de cookies
    inicializarBannerCookies();

    // Último curso visitado
    guardarCursoVisitado();
    mostrarUltimoCurso();

    // --- Validación de los formularios ---

    // Login
    const loginForm = document.querySelector('form[action="login"]');
    if (loginForm) {
        const email = loginForm.querySelector('input[name="email"]');
        const password = loginForm.querySelector('input[name="password"]');

        email?.addEventListener('input', () => validarCampo(email, 'email'));
        password?.addEventListener('input', () => validarCampo(password, 'password'));

        loginForm.addEventListener('submit', (e) => {
            let valido = true;
            if (!validarCampo(email, 'email')) valido = false;
            if (!validarCampo(password, 'password')) valido = false;
            if (!valido) e.preventDefault();
        });
    }

    // Registro
    const registerForm = document.querySelector('form[action="/register"]');
    if (registerForm) {
        const nombre = registerForm.querySelector('input[name="nombre"]');
        const email = registerForm.querySelector('input[name="email"]');
        const pass = registerForm.querySelector('input[name="password"]');
        const pass2 = registerForm.querySelector('input[name="password_confirmation"]');

        nombre?.addEventListener('input', () => validarCampo(nombre, 'nombre'));
        email?.addEventListener('input', () => validarCampo(email, 'email'));
        pass?.addEventListener('input', () => validarCampo(pass, 'password'));
        pass2?.addEventListener('input', () => {
            if (pass.value !== pass2.value) {
                mostrarError(pass2, 'Las contraseñas no coinciden.');
            } else {
                limpiarError(pass2);
            }
        });
    }

    // --- Dropdown del header ---
    const btn = document.getElementById('userMenuButton');
    const menu = document.getElementById('userDropdown');
    if (btn && menu) {
        btn.addEventListener('click', (e) => {
            e.stopPropagation();
            menu.classList.toggle('open');
        });
        document.addEventListener('click', () => menu.classList.remove('open'));
        menu.addEventListener('click', (e) => e.stopPropagation());
    }

    // --- Carrusel Home ---
    const slides = document.querySelectorAll('.carousel-slide');
    const dots = document.querySelectorAll('.carousel-dot');
    if (slides.length) {
        let current = 0;
        const mostrarSlide = (index) => {
            slides.forEach(s => s.classList.remove('active'));
            dots.forEach(d => d.classList.remove('active'));
            slides[index].classList.add('active');
            dots[index].classList.add('active');
            current = index;
        };
        setInterval(() => mostrarSlide((current +1 ) % slides.length), 4000);
        dots.forEach(dot => dot.addEventListener('click', (e) => {
            mostrarSlide(parseInt(e.target.dataset.slide));
        }));
    }

    // --- Checkout por pasos ---
    window.siguientePaso = (paso) => {
        document.querySelectorAll('.paso').forEach(el => el.classList.add('hidden'));
        for (let i = 1; i <= 3; i++) {
            const ind = document.getElementById('paso' + i + '-ind');
            if (ind) ind.style.background = i <= paso ? '#b45309' : '#4b5563';
        }
    };
});