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
        document.cookie = `${nombre}=${encodeURIComponent(valor)};expires=${fecha.toUTCString()};path=/`;
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
    error.style.cssText = 'color:#ef4444; font-size:0.85rem; margin-top:0.25rem; display:block;';
    error.textContent = mensaje;
    input.parentNode.appendChild(error);
    input.style.borderColor = '#ef4444';
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
    const valor = input.value.trim();
    if (valor === '') {
        mostrarError(input, 'Este campo es obligatorio.');
        return false;
    }
    if (tipo === 'email' && !Regex.email.test(valor)) {
        mostrarError(input, 'El correo electrónico no es válido');
        return false;
    }
    if (tipo === 'password' && !Regex.password.test(valor)) {
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
    const autenticado = document.body.getAttribute('data-authenticated') === 'true';
    if (!autenticado) return;

    const id = Cookies.get('ultimo_curso_visitado');
    if (!id) return;

    const contenedor = document.getElementById('ultimo-curso-visitado');
    if (!contenedor) return;

    fetch(`/api/curso/${id}`)
        .then(res => res.json())
        .then(curso => {
            if (curso && curso.titulo) {
                // Limpiar el contenedor
                contenedor.innerHTML = '';
                contenedor.style.display = 'none';
                
                // Crear tarjeta estilizada
                const tarjeta = document.createElement('div');
                tarjeta.className = 'fade-in-up';
                tarjeta.style.cssText = `
                    background: linear-gradient(135deg, #1e293b, #0f172a);
                    border: 1px solid #b45309;
                    border-radius: 0.75rem;
                    padding: 1rem 1.5rem;
                    margin-bottom: 1.5rem;
                    display: flex;
                    align-items: center;
                    gap: 1rem;
                    color: #e5e7eb;
                    font-size: 0.95rem;
                    box-shadow: 0 4px 15px rgba(0,0,0,0.3);
                `;
                
                tarjeta.innerHTML = `
                    <span style="font-size: 1.5rem;">🕒</span>
                    <div style="flex:1;">
                        <span style="color:#94a3b8;">Último curso visitado:</span>
                        <a href="/cursos/${curso.id}" style="color:#fbbf24; font-weight:600; margin-left:0.5rem; text-decoration:none; transition:color 0.2s;">
                            ${escapeHTML(curso.titulo)}
                        </a>
                    </div>
                    <button onclick="this.parentElement.remove()" style="background:none; border:none; color:#6b7280; cursor:pointer; font-size:1.2rem; padding:0.25rem; transition:color 0.2s;" onmouseover="this.style.color='#ef4444'" onmouseout="this.style.color='#6b7280'">✕</button>
                `;
                
                contenedor.appendChild(tarjeta);
                contenedor.style.display = 'block';
                
                // Forzar reflow y activar animación
                void tarjeta.offsetWidth;
                requestAnimationFrame(() => {
                    tarjeta.classList.add('visible');
                });
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
    div.textContent = texto;
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
        const formData = new FormData(formulario);
        const params = new URLSearchParams(formData).toString();

        try {
            const respuesta = await fetch(`/api/cursos?${params}`);
            const texto = await respuesta.text(); // Obtenemos el texto sin procesar
            
            // Intentamos parsearlo a JSON
            let datos;
            try {
                datos = JSON.parse(texto);
            } catch (parseError) {
                // Si falla, mostramos el texto crudo (posible warning de PHP)
                console.error('No se pudo parsear la respuesta:', texto);
                grid.innerHTML = `
                    <div class="card text-center" style="padding:2rem; grid-column:1/-1;">
                        <p style="color:#ef4444;">⚠️ Error del servidor</p>
                        <pre style="color:#fbbf24; text-align:left; max-height:200px; overflow:auto;">${escapeHTML(texto)}</pre>
                        <button class="btn btn-secondary btn-sm" onclick="location.reload()">Reintentar</button>
                    </div>`;
                return;
            }

            // Si se parsea correctamente, renderizamos los cursos
            renderizarCursos(datos.cursos);

        } catch (error) {
            console.error('Error de red:', error);
            grid.innerHTML = `
                <div class="card text-center" style="padding:2rem; grid-column:1/-1;">
                    <p style="color:#ef4444;">⚠️ No se pudieron cargar los cursos.</p>
                    <button class="btn btn-secondary btn-sm" onclick="location.reload()">Reintentar</button>
                </div>`;
        }
    });
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
            <div class="fade-in-up" style="text-align: center; padding: 4rem 2rem; background: #1e293b; border: 2px solid #334155; border-radius: 1rem; grid-column: 1 / -1;">
                <span style="font-size: 4rem; display: block; margin-bottom: 1rem;">📜</span>
                <h3 style="font-size: 1.5rem; color: #fbbf24; margin-bottom: 0.5rem;">No se encontraron misiones</h3>
                <p style="color: #94a3b8;">Prueba a ajustar los filtros o vuelve más tarde para nuevas aventuras.</p>
            </div>`;
        return;
    }

    grid.innerHTML = cursos.map((curso, index) => {
        const modalidadColor = curso.modalidad === 'online' ? '#1e3a5f, #0f172a' : '#5f1e1e, #0f172a';
        const modalidadIcon = curso.modalidad === 'online' ? '🌐' : '🏰';
        const modalidadBadgeColor = curso.modalidad === 'online' ? '#065f46' : '#7f1d1d';
        const plazasBadge = curso.plazas != null ? `
            <span class="badge" style="position: absolute; top: 0.75rem; right: 0.75rem; background: ${(curso.compradores ?? 0) >= curso.plazas ? '#7f1d1d' : '#065f46'}; color: white; font-size: 0.7rem;">
                ${(curso.compradores ?? 0) >= curso.plazas ? 'Completo' : (curso.compradores ?? 0) + '/' + curso.plazas + ' plazas'}
            </span>` : '';

        return `
            <div class="course-card fade-in-up" style="display: flex; flex-direction: column; height: 100%;">
                <div class="course-cover" style="background: linear-gradient(135deg, ${modalidadColor}); height: 120px; display: flex; align-items: center; justify-content: center; font-size: 3rem; border-radius: 0.75rem 0.75rem 0 0; position: relative; overflow: hidden;">
                    ${modalidadIcon}
                    <span class="badge" style="position: absolute; top: 0.75rem; left: 0.75rem; background: ${modalidadBadgeColor}; color: white; font-size: 0.7rem;">
                        ${curso.modalidad === 'online' ? 'Online' : 'Presencial'}
                    </span>
                    ${plazasBadge}
                </div>
                <div style="padding: 1.25rem; background: #1e293b; border-radius: 0 0 0.75rem 0.75rem; border: 1px solid #334155; border-top: none; flex: 1; display: flex; flex-direction: column;">
                    <h3 class="card-title" style="font-size: 1.2rem; margin-bottom: 0.5rem;">
                        ${escapeHTML(curso.titulo)}
                    </h3>
                    <p style="color: #94a3b8; font-size: 0.9rem; margin-bottom: 0.75rem; line-height: 1.4;">
                        ${escapeHTML((curso.descripcion ?? '').substring(0, 90))}...
                    </p>
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.75rem; font-size: 0.85rem;">
                        <span style="color: #94a3b8;">
                            🧙 ${escapeHTML(curso.instructor_nombre ?? 'N/A')}
                        </span>
                        <span style="color: #fbbf24;">
                            ★ ${(curso.media_resenas ?? 0).toFixed(1)}
                        </span>
                    </div>
                    <div style="margin-top: auto; display: flex; justify-content: space-between; align-items: center;">
                        <span style="font-size: 1.5rem; font-weight: bold; color: #fbbf24;">
                            ${parseFloat(curso.precio).toFixed(2)} €
                        </span>
                        <a href="/cursos/${curso.id}" class="btn btn-primary btn-sm" style="background: linear-gradient(135deg, #b45309, #d97706); border: none;">
                            Ver misión →
                        </a>
                    </div>
                </div>
            </div>`;
    }).join('');

    // Reaplicar animaciones
    const nuevos = grid.querySelectorAll('.fade-in-up');
    nuevos.forEach(el => el.classList.add('visible'));
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


    inicializarCatalogoAjax();

    const elementosAnimados = document.querySelectorAll('.fade-in-up');
    elementosAnimados.forEach(el => el.classList.add('visible'));

    // --- Validación de los formularios ---

    // Login
    const loginForm = document.querySelector('form[action="/login"]');
    if (loginForm) {
        const email = loginForm.querySelector('input[name="email"]');
        const password = loginForm.querySelector('input[name="password"]');

        loginForm.addEventListener('submit', (e) => {
            document.querySelectorAll('.field-error').forEach(el => el.remove());
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
        const pass2 = registerForm.querySelector('input[name="password_confirmacion"]');

        registerForm.addEventListener('submit', (e) => {
            document.querySelectorAll('.field-error').forEach(el => el.remove());
            let valido = true;
            if (!validarCampo(nombre, 'nombre')) valido = false;
            if (!validarCampo(email, 'email')) valido = false;
            if (!validarCampo(pass, 'password')) valido = false;
            if (pass.value !== pass2.value) {
                mostrarError(pass2, 'Las contraseñas no coinciden.');
                valido = false;
            }
            if (!valido) { e.preventDefault(); }
        });
    }

    // --- Checkout por pasos ---
    window.siguientePaso = (paso) => {
        document.querySelectorAll('.paso').forEach(el => el.classList.add('hidden'));
        document.getElementById('paso' + paso)?.classList.remove('hidden');
        for (let i = 1; i <= 3; i++) {
            const ind = document.getElementById('paso' + i + '-ind');
            if (ind) ind.style.background = i <= paso ? '#b45309' : '#4b5563';
        }
    };

    // Checkout
    const checkoutForm = document.getElementById('checkout-form');
    if (checkoutForm) {
        // Función para validar que un campo no esté vacío
        const validarNoVacio = (input, mensaje = 'Este campo es obligatorio') => {
            if (input.value.trim() === '') {
                mostrarError(input, mensaje);
                return false;
            }
            limpiarError(input);
            return true;
        };

        // Campos de cada paso
        const camposPaso1 = [
            checkoutForm.querySelector('input[name="nombre"]'),
            checkoutForm.querySelector('input[name="email"]'),
            checkoutForm.querySelector('input[name="telefono"]')
        ];
        const camposPaso2 = [
            checkoutForm.querySelector('input[name="titular"]'),
            checkoutForm.querySelector('input[name="tarjeta"]'),
            checkoutForm.querySelector('input[name="caducidad"]'),
            checkoutForm.querySelector('input[name="cvv"]')
        ];

        // Validar formato de tarjeta (16 dígitos)
        const validarTarjeta = (input) => {
            const valor = input.value.replace(/\s/g, '');
            if (valor === '') {
                mostrarError(input, 'Este campo es obligatorio');
                return false;
            }
            if (!/^\d{16}$/.test(valor)) {
                mostrarError(input, 'Número de tarjeta no válido (16 dígitos)');
                return false;
            }
            limpiarError(input);
            return true;
        };

        // Validar caducidad (MM/AA en el futuro)
        const validarCaducidad = (input) => {
            const valor = input.value.trim();
            if (valor === '') {
                mostrarError(input, 'Este campo es obligatorio');
                return false;
            }
            if (!/^(0[1-9]|1[0-2])\/\d{2}$/.test(valor)) {
                mostrarError(input, 'Formato: MM/AA');
                return false;
            }
            const [mes, ano] = valor.split('/');
            const fechaActual = new Date();
            const anoActual = fechaActual.getFullYear() % 100;
            const mesActual = fechaActual.getMonth() + 1;
            if (+ano < anoActual || (+ano === anoActual && +mes < mesActual)) {
                mostrarError(input, 'La tarjeta ha caducado');
                return false;
            }
            limpiarError(input);
            return true;
        };

        // Validar CVV (3 dígitos)
        const validarCvv = (input) => {
            const valor = input.value.trim();
            if (valor === '') {
                mostrarError(input, 'Este campo es obligatorio');
                return false;
            }
            if (!/^\d{3}$/.test(valor)) {
                mostrarError(input, 'CVV no válido (3 dígitos)');
                return false;
            }
            limpiarError(input);
            return true;
        };

        // Validar un grupo de campos
        const validarGrupo = (campos, paso) => {
            let valido = true;
            campos.forEach(input => {
                if (!input) return;
                if (input.name === 'email') {
                    if (!validarCampo(input, 'email')) valido = false;
                } else if (input.name === 'telefono') {
                    if (input.value.trim() === '') {
                        mostrarError(input, 'El teléfono es obligatorio');
                        valido = false;
                    } else if (!/^\+?\d{6,15}$/.test(input.value.trim())) {
                        mostrarError(input, 'Teléfono no válido');
                        valido = false;
                    } else {
                        limpiarError(input);
                    }
                } else if (input.name === 'tarjeta') {
                    if (!validarTarjeta(input)) valido = false;
                } else if (input.name === 'caducidad') {
                    if (!validarCaducidad(input)) valido = false;
                } else if (input.name === 'cvv') {
                    if (!validarCvv(input)) valido = false;
                } else {
                    if (!validarNoVacio(input)) valido = false;
                }
            });
            return valido;
        };

        // Sobrescribir la función global siguientePaso para incluir validación
        const originalSiguientePaso = window.siguientePaso;
        window.siguientePaso = (paso) => {
            let puedeAvanzar = true;

            if (paso === 2) {
                puedeAvanzar = validarGrupo(camposPaso1, 1);
            } else if (paso === 3) {
                puedeAvanzar = validarGrupo(camposPaso2, 2);
            }

            if (!puedeAvanzar) return;

            originalSiguientePaso(paso);
        };

        // Validación al enviar el formulario
        checkoutForm.addEventListener('submit', (e) => {
            document.querySelectorAll('.field-error').forEach(el => el.remove());
            [...camposPaso1, ...camposPaso2].forEach(inp => { if (inp) inp.style.borderColor = ''; });

            let valido = true;
            if (!validarGrupo(camposPaso1, 1)) valido = false;
            if (!validarGrupo(camposPaso2, 2)) valido = false;

            if (!valido) {
                e.preventDefault();
                // Volver al primer paso con errores
                if (camposPaso1.some(inp => inp && inp.style.borderColor === 'rgb(239, 68, 68)')) {
                    originalSiguientePaso(1);
                } else if (camposPaso2.some(inp => inp && inp.style.borderColor === 'rgb(239, 68, 68)')) {
                    originalSiguientePaso(2);
                }
            }
        });
    }

    // Validación del formulario de cursos (instructor)
    const cursoForm = document.getElementById('curso-form');
    if (cursoForm) {
        const titulo = cursoForm.querySelector('input[name="titulo"]');
        const descripcion = cursoForm.querySelector('textarea[name="descripcion"]');
        const precio = cursoForm.querySelector('input[name="precio"]');
        const modalidad = cursoForm.querySelector('select[name="modalidad"]');

        // Campos presenciales (solo se validan si modalidad === 'presencial')
        const fechaPresencial = cursoForm.querySelector('input[name="fecha"]');
        const horaPresencial = cursoForm.querySelector('input[name="hora"]');
        const ubicacion = cursoForm.querySelector('input[name="ubicacion"]');
        const plazas = cursoForm.querySelector('input[name="plazas"]');

        const validarCurso = () => {
            let valido = true;

            // Limpiar errores previos
            [titulo, descripcion, precio, fechaPresencial, horaPresencial, ubicacion, plazas].forEach(inp => {
                if (inp) limpiarError(inp);
            });

            // Título
            if (titulo.value.trim() === '') {
                mostrarError(titulo, 'El título es obligatorio.');
                valido = false;
            }

            // Descripción
            if (descripcion.value.trim() === '') {
                mostrarError(descripcion, 'La descripción es obligatoria.');
                valido = false;
            }

            // Precio
            const precioValor = parseFloat(precio.value.trim());
            if (isNaN(precioValor) || precioValor <= 0) {
                mostrarError(precio, 'El precio debe ser un número positivo.');
                valido = false;
            }

            // Modalidad (siempre tiene valor por defecto, no es necesario validar)

            // Campos presenciales (solo si modalidad es 'presencial')
            if (modalidad.value === 'presencial') {
                if (fechaPresencial && fechaPresencial.value.trim() === '') {
                    mostrarError(fechaPresencial, 'La fecha es obligatoria para cursos presenciales.');
                    valido = false;
                }
                if (horaPresencial && horaPresencial.value.trim() === '') {
                    mostrarError(horaPresencial, 'La hora es obligatoria.');
                    valido = false;
                }
                if (ubicacion && ubicacion.value.trim() === '') {
                    mostrarError(ubicacion, 'La ubicación es obligatoria.');
                    valido = false;
                }
                if (plazas && plazas.value.trim() !== '') {
                    const plazasValor = parseInt(plazas.value.trim());
                    if (isNaN(plazasValor) || plazasValor < 1) {
                        mostrarError(plazas, 'Las plazas deben ser al menos 1.');
                        valido = false;
                    }
                }
            }

            return valido;
        };

        cursoForm.addEventListener('submit', (e) => {
            if (!validarCurso()) {
                e.preventDefault();
            }
        });

        // Opcional: validar al cambiar la modalidad (mostrar/ocultar campos ya lo tienes)
        if (modalidad) {
            modalidad.addEventListener('change', () => {
                // Limpiar errores de campos presenciales si se cambia a online
                if (modalidad.value === 'online') {
                    [fechaPresencial, horaPresencial, ubicacion, plazas].forEach(inp => {
                        if (inp) limpiarError(inp);
                    });
                }
            });
        }
    }

    // Validación del formulario de clases (instructor)
    const claseForm = document.getElementById('clase-form');
    if (claseForm) {
        const tituloClase = claseForm.querySelector('input[name="titulo"]');
        const duracion = claseForm.querySelector('input[name="duracion"]');
        const tipo = claseForm.querySelector('select[name="tipo"]');

        // Campos específicos
        const contenidoTexto = claseForm.querySelector('textarea[name="contenido_texto"]');
        const archivo = claseForm.querySelector('input[name="archivo"]');
        const fechaLimite = claseForm.querySelector('input[name="fecha_limite"]');
        const criterios = claseForm.querySelector('textarea[name="criterios_evaluacion"]');

        const validarClase = () => {
            let valido = true;

            // Limpiar todos los errores previos
            [tituloClase, duracion, contenidoTexto, archivo, fechaLimite, criterios].forEach(inp => {
                if (inp) limpiarError(inp);
            });

            // Título obligatorio
            if (tituloClase.value.trim() === '') {
                mostrarError(tituloClase, 'El título es obligatorio.');
                valido = false;
            }

            // Duración obligatoria y numérica
            const duracionValor = parseInt(duracion.value.trim());
            if (isNaN(duracionValor) || duracionValor <= 0) {
                mostrarError(duracion, 'La duración debe ser un número positivo.');
                valido = false;
            }

            // Validar según tipo
            if (tipo.value === 'teoria') {
                if (!contenidoTexto || contenidoTexto.value.trim() === '') {
                    if (contenidoTexto) mostrarError(contenidoTexto, 'El contenido teórico es obligatorio.');
                    valido = false;
                }
            } else if (tipo.value === 'archivo') {
                // En creación, archivo es obligatorio; en edición, solo si no hay archivo previo
                const archivoActual = claseForm.querySelector('input[name="archivo_id"]'); // campo oculto si existe
                if ((!archivoActual || archivoActual.value === '') && (!archivo || archivo.files.length === 0)) {
                    if (archivo) mostrarError(archivo, 'Debes subir un archivo.');
                    valido = false;
                }
            } else if (tipo.value === 'tarea') {
                if (fechaLimite && fechaLimite.value.trim() === '') {
                    mostrarError(fechaLimite, 'La fecha límite es obligatoria.');
                    valido = false;
                }
                if (criterios && criterios.value.trim() === '') {
                    mostrarError(criterios, 'Los criterios de evaluación son obligatorios.');
                    valido = false;
                }
            }

            return valido;
        };

        claseForm.addEventListener('submit', (e) => {
            if (!validarClase()) {
                e.preventDefault();
            }
        });
    }

    // Formulraio del perfil
    const perfilForm = document.getElementById('perfil-form');
    if (perfilForm) {
        const nombre = perfilForm.querySelector('input[name="nombre"]');
        const email = perfilForm.querySelector('input[name="email"]');
        const password = perfilForm.querySelector('input[name="password"]');
        const passwordConfirm = perfilForm.querySelector('input[name="password_confirmation"]');

        perfilForm.addEventListener('submit', (e) => {
            document.querySelectorAll('.field-error').forEach(el => el.remove());

            let valido = true;

            if (nombre.value.trim() === '') {
                mostrarError(nombre, 'El nombre es obligatorio');
                valido = false;
            }
            if (!Regex.email.text(email.value.trim())) {
                mostrarError(email, 'El correo no es válido');
                valido = false;
            }
            if (password.value.trim() !== '') {
                if (password.value.trim().length < 8) {
                    mostrarError(password, 'La contraseña debe tener al menos 8 caracteres');
                    valido = false;
                }
                if (password.value !== passwordConfirm.value) {
                    mostrarError(passwordConfirm, 'Las contraseñas no coinciden');
                    valido = false;
                }
            }

            if (!valido) {
                e.preventDefault();
            }
        });
    }

    // --- Dropdown del header ---
    const dropdown = document.getElementById('userDropdown');
    const btn = document.getElementById('userMenuButton');
    const menu = document.getElementById('userMenu');
    if (dropdown && btn && menu) {
        btn.addEventListener('click', function(e) {
            e.stopPropagation();
            menu.classList.toggle('open');
            dropdown.classList.toggle('open');
        });
        document.addEventListener('click', function() {
            menu.classList.remove('open');
            dropdown.classList.remove('open');
        });
        menu.addEventListener('click', function(e) {
            e.stopPropagation();
        });
    };

    // --- Carrusel Home ---
    const track = document.querySelector('.carousel-track');
    const slides = document.querySelectorAll('.carousel-slide');
    const dots = document.querySelectorAll('.carousel-dot');

    if (track && slides.length) {
        let current = 0;
        const total = slides.length;

        const goTo = (index) => {
            track.style.transform = `translateX(-${index * 100}%)`;
            dots.forEach(d => d.classList.remove('active'));
            if (dots[index]) dots[index].classList.add('active');
            current = index;
        };

        setInterval(() => {
            goTo((current + 1) % total);
        }, 4000);

        dots.forEach(dot => {
            dot.addEventListener('click', (e) => {
                const index = parseInt(e.target.dataset.slide);
                goTo(index);
            });
        });
    }
});