<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Admin SkillUP' ?></title>
    <link rel="stylesheet" href="/css/styles.css">
    <link href="https://fonts.googleapis.com/css2?family=VT323&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- DataTables -->
     <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.min.css">
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.min.js"></script>
</head>
<body>
    <div class="admin-layout">
        <!-- Sidebar -->
        <aside class="admin-sidebar">
            <h2>🛡️ Admin</h2>
            <nav>
                <a href="/admin">📊 Dashboard</a>
                <a href="/admin/usuarios">👥 Usuarios</a>
                <a href="/admin/cursos">📚 Cursos</a>
                <a href="/admin/pedidos">🛒 Pedidos</a>
                <div class="dropdown-divider" style="margin:1rem 0;"></div>
                <a href="/">🏠 Volver a SkillUP</a>
                <a href="/logout" style="color:#ef4444;">🚪 Cerrar sesión</a>
            </nav>
        </aside>

        <!-- Contenido principal -->
        <main class="admin-content">
            <?php if ($mensaje = $_SESSION['mensaje'] ?? null): ?>
                <div class="flash-message flash-success" style="margin-bottom:1.5rem;">
                    <?= htmlspecialchars($mensaje) ?>
                </div>
                <?php unset($_SESSION['mensaje']); ?>
            <?php endif; ?>

            <?= $content ?? '' ?>
        </main>
    </div>
</body>
</html>