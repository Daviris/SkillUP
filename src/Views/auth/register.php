<?php ob_start(); ?>
<div style="max-width:900px; margin:3rem auto;">
    <div class="fade-in-up" style="display:grid; grid-template-columns:1fr 1fr; gap:2rem; align-items:start;">
        
        <!-- Columna izquierda: Beneficios -->
        <div class="card" style="padding:2rem; background:linear-gradient(135deg, #1e293b, #0f172a); border:1px solid #334155; position:relative; overflow:hidden;">
            <div style="position:absolute; top:0; left:0; right:0; bottom:0; background:radial-gradient(circle at 30% 20%, rgba(251,191,36,0.05) 0%, transparent 60%); pointer-events:none;"></div>
            <div style="position:relative; z-index:2;">
                <div style="text-align:center; font-size:3.5rem; margin-bottom:1rem;">🛡️</div>
                <h2 class="font-rpg" style="font-size:1.8rem; color:#fbbf24; text-align:center; margin-bottom:1.5rem;">
                    ¿Por qué unirte a SkillUP?
                </h2>
                
                <div style="display:grid; gap:1rem;">
                    <div style="display:flex; gap:1rem; padding:1rem; background:rgba(15,23,42,0.6); border-radius:0.5rem; border:1px solid #334155;">
                        <span style="font-size:1.5rem;">🔐</span>
                        <div>
                            <div style="color:#fbbf24; font-weight:600; margin-bottom:0.25rem;">Cuenta segura</div>
                            <div style="color:#94a3b8; font-size:0.9rem;">Tus datos están encriptados y protegidos con los más altos estándares de seguridad.</div>
                        </div>
                    </div>
                    <div style="display:flex; gap:1rem; padding:1rem; background:rgba(15,23,42,0.6); border-radius:0.5rem; border:1px solid #334155;">
                        <span style="font-size:1.5rem;">💳</span>
                        <div>
                            <div style="color:#fbbf24; font-weight:600; margin-bottom:0.25rem;">Pagos protegidos</div>
                            <div style="color:#94a3b8; font-size:0.9rem;">Simulación de pago con datos bancarios simulados, sin riesgos reales.</div>
                        </div>
                    </div>
                    <div style="display:flex; gap:1rem; padding:1rem; background:rgba(15,23,42,0.6); border-radius:0.5rem; border:1px solid #334155;">
                        <span style="font-size:1.5rem;">♾️</span>
                        <div>
                            <div style="color:#fbbf24; font-weight:600; margin-bottom:0.25rem;">Acceso de por vida</div>
                            <div style="color:#94a3b8; font-size:0.9rem;">Una vez comprado un curso, tendrás acceso ilimitado para siempre.</div>
                        </div>
                    </div>
                    <div style="display:flex; gap:1rem; padding:1rem; background:rgba(15,23,42,0.6); border-radius:0.5rem; border:1px solid #334155;">
                        <span style="font-size:1.5rem;">🧑‍🏫</span>
                        <div>
                            <div style="color:#fbbf24; font-weight:600; margin-bottom:0.25rem;">Instructores verificados</div>
                            <div style="color:#94a3b8; font-size:0.9rem;">Todos los maestros pasan un proceso de verificación y tienen reputación pública.</div>
                        </div>
                    </div>
                    <div style="display:flex; gap:1rem; padding:1rem; background:rgba(15,23,42,0.6); border-radius:0.5rem; border:1px solid #334155;">
                        <span style="font-size:1.5rem;">📜</span>
                        <div>
                            <div style="color:#fbbf24; font-weight:600; margin-bottom:0.25rem;">Certificados</div>
                            <div style="color:#94a3b8; font-size:0.9rem;">Obtén un certificado al completar cada curso para demostrar tus habilidades.</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Columna derecha: Formulario -->
        <div class="card" style="padding:2.5rem 2rem;">
            <div style="text-align:center; font-size:3rem; margin-bottom:0.5rem;">✨</div>
            <h1 class="font-rpg" style="font-size:2.5rem; color:#fbbf24; text-align:center; margin-bottom:1.5rem;">
                Crear Cuenta
            </h1>
            
            <!-- Errores del servidor -->
            <?php if (!empty($_SESSION['errores'])): ?>
                <div class="flash-message flash-error" style="margin-bottom:1.5rem;">
                    <ul style="list-style:none; padding:0; margin:0;">
                        <?php foreach ($_SESSION['errores'] as $error): ?>
                            <li><?= htmlspecialchars($error) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <?php unset($_SESSION['errores']); ?>
            <?php endif; ?>

            <form method="POST" action="/register" id="register-form" novalidate>
                <div class="form-group">
                    <label class="form-label">Nombre completo</label>
                    <input type="text" name="nombre" class="form-input" value="<?= htmlspecialchars($_SESSION['old']['nombre'] ?? '') ?>" placeholder="Elige tu nombre de aventurero">
                </div>
                <div class="form-group">
                    <label class="form-label">Correo electrónico</label>
                    <input type="text" name="email" class="form-input" value="<?= htmlspecialchars($_SESSION['old']['email'] ?? '') ?>" placeholder="aventurero@skillup.com">
                </div>
                <div class="form-group">
                    <label class="form-label">Contraseña (mínimo 8 caracteres)</label>
                    <input type="password" name="password" class="form-input" placeholder="••••••••">
                </div>
                <div class="form-group">
                    <label class="form-label">Confirmar contraseña</label>
                    <input type="password" name="password_confirmacion" class="form-input" placeholder="••••••••">
                </div>
                <div class="form-group">
                    <label class="form-label">Tipo de cuenta</label>
                    <select name="rol" class="form-select">
                        <option value="alumno" <?= ($_SESSION['old']['rol'] ?? '') === 'alumno' ? 'selected' : '' ?>>📖 Aprendiz (Alumno)</option>
                        <option value="instructor" <?= ($_SESSION['old']['rol'] ?? '') === 'instructor' ? 'selected' : '' ?>>🧙 Maestro (Instructor)</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary" style="width:100%; margin-top:1.5rem; padding:0.8rem; font-size:1rem; background:linear-gradient(135deg, #b45309, #d97706); border:none;">
                    ✨ Crear cuenta
                </button>
            </form>
            
            <p style="text-align:center; margin-top:1.5rem; color:#94a3b8;">
                ¿Ya tienes cuenta? <a href="/login" style="color:#fbbf24; font-weight:600;">Inicia sesión</a>
            </p>
        </div>
    </div>
</div>
<?php $content = ob_get_clean(); ?>
<?php require __DIR__ . '/../layouts/main.php'; ?>