<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'SkillUP' ?></title>
    <link rel="stylesheet" href="/css/styles.css">
    <link href="https://fonts.googleapis.com/css2?family=VT323&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <header class="main-header">
        <div class="container" style="display:flex; justify-content:space-between; align-items:center; padding:0.6rem 0;">
            <!-- Bloque izquierdo: Logo + Cursos -->
            <div style="display:flex; align-items:center; gap:2rem;">
                <a href="/" class="header-logo" style="margin:0;">⚡ SkillUP</a>
                <a href="/cursos" style="color:#d1d5db; font-weight:500; font-size:1rem; transition:color 0.2s;">📚 Cursos</a>
            </div>

            <!-- Bloque derecho: Carrito + Usuario o Login/Register -->
            <div style="display:flex; align-items:center; gap:1.5rem;">
                <?php if (isset($_SESSION['usuario'])): ?>
                    <?php $cartCount = !empty($_SESSION['carrito']['items']) ? count($_SESSION['carrito']['items']) : 0; ?>
                    <a href="/carrito" style="position:relative; color:#d1d5db;">
                        🛒
                        <?php if ($cartCount > 0): ?>
                            <span class="badge badge-red" style="position:absolute; top:-12px; right:-12px; font-size:0.7rem; min-width:1.5rem; height:1.5rem; display:flex; align-items:center; justify-content:center;"><?= $cartCount ?></span>
                        <?php endif; ?>
                    </a>
                    <div class="dropdown">
                        <button class="dropdown-toggle" id="userMenuButton">
                            <?= htmlspecialchars($_SESSION['usuario']['nombre']) ?> ▾
                        </button>
                        <div class="dropdown-menu" id="userDropdown">
                            <a href="/perfil">👤 Mi Perfil</a>
                            <?php if ($_SESSION['usuario']['rol'] === 'alumno'): ?>
                                <a href="/mis-cursos">📖 Mis Cursos</a>
                            <?php endif; ?>
                            <?php if ($_SESSION['usuario']['rol'] === 'instructor'): ?>
                                <a href="/instructor">🧙 Panel Instructor</a>
                            <?php endif; ?>
                            <?php if ($_SESSION['usuario']['rol'] === 'admin'): ?>
                                <a href="/admin">🛡️ Panel Admin</a>
                            <?php endif; ?>
                            <div class="dropdown-divider"></div>
                            <a href="/logout" style="color:#ef4444;">🚪 Cerrar sesión</a>
                        </div>
                    </div>
                <?php else: ?>
                    <a href="/login" style="color:#d1d5db; font-weight:500;">🔐 Login</a>
                    <a href="/register" class="btn btn-primary" style="padding:0.5rem 1.2rem;">✨ Registro</a>
                <?php endif; ?>
            </div>
        </div>
    </header>

    <main class="container" style="padding-top:2rem; padding-bottom:3rem; flex:1;">
        <!-- Mensajes flash (se mantiene igual) -->
        <?php if ($mensaje = $_SESSION['mensaje'] ?? null): ?>
            <div class="flash-container">
                <span><?= htmlspecialchars($mensaje) ?></span>
                <button class="flash-close" onclick="this.parentElement.remove()">✕</button>
            </div>
            <?php unset($_SESSION['mensaje']); ?>
        <?php endif; ?>
        <?= $content ?? '' ?>
    </main>

    <!-- Comprobación de loggeo para JS -->
    <body data-authenticated="<?= isset($_SESSION['usuario']) ? 'true' : 'false' ?>"></body>

    <footer style="background:#1e293b; border-top:1px solid #334155; color:#94a3b8; text-align:center; padding:1.2rem; font-size:0.9rem;">
        &copy; <?= date('Y') ?> SkillUP — TFG DAW
    </footer>

    <script src="/js/app.js"></script>
</body>
</html>