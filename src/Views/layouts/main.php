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
        <div class="header-container">
            <!-- Bloque izquierdo: Logo + Cursos -->
            <div class="header-nav-left">
                <a href="/" class="header-logo">
                    <span class="logo-icon">⚔️</span> SkillUP
                </a>
                <a href="/cursos">📚 Cursos</a>
            </div>

            <!-- Bloque derecho: Carrito + Usuario o Login/Register -->
            <div class="header-nav-right">
                <?php if (isset($_SESSION['usuario'])): ?>
                    <?php $cartCount = !empty($_SESSION['carrito']['items']) ? count($_SESSION['carrito']['items']) : 0; ?>
                    <!-- Carrito -->
                    <a href="/carrito" class="cart-link">
                        🛒
                        <?php if ($cartCount > 0): ?>
                            <span class="cart-badge"><?= $cartCount ?></span>
                        <?php endif; ?>
                    </a>
                    <!-- Dropdown usuario -->
                    <div class="dropdown" id="userDropdown">
                        <button class="dropdown-toggle" id="userMenuButton">
                            <span class="user-avatar">🧑</span>
                            <span><?= htmlspecialchars($_SESSION['usuario']['nombre']) ?></span>
                            <span class="arrow">▼</span>
                        </button>
                        <div class="dropdown-menu" id="userMenu">
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
                            <a href="/logout" class="logout-link">🚪 Cerrar sesión</a>
                        </div>
                    </div>
                <?php else: ?>
                    <a href="/login" class="btn-login">🔐 Login</a>
                    <a href="/register" class="btn-register">✨ Registro</a>
                <?php endif; ?>
            </div>
        </div>
    </header>

    <main class="container" style="padding-top:2rem; padding-bottom:3rem; flex:1;">
        <?php if ($mensaje = $_SESSION['mensaje'] ?? null): ?>
            <div class="flash-container">
                <span><?= htmlspecialchars($mensaje) ?></span>
                <button class="flash-close" onclick="this.parentElement.remove()">✕</button>
            </div>
            <?php unset($_SESSION['mensaje']); ?>
        <?php endif; ?>
        <?= $content ?? '' ?>
    </main>

    <footer style="background:#1e293b; border-top:1px solid #334155; color:#94a3b8; text-align:center; padding:1.2rem; font-size:0.9rem;">
        &copy; 2026 SkillUP — TFG DAW
    </footer>

    <script src="/js/app.js"></script>
</body>
</html>