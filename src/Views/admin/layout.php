<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Admin SkillUP' ?></title>
    <link rel="stylesheet" href="/css/styles.css">
    <link href="https://fonts.googleapis.com/css2?family=VT323&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.min.css">
</head>
<body>
    <div class="admin-layout">
        <!-- Sidebar -->
        <aside class="admin-sidebar" style="background:linear-gradient(180deg, #0f172a, #1e293b); border-right:2px solid #b45309;">
            <h2 style="font-family:'VT323', monospace; font-size:2rem; color:#fbbf24; margin-bottom:2rem; text-shadow:0 0 10px rgba(251,191,36,0.5);">🛡️ Admin</h2>
            <nav>
                <a href="/admin" style="display:flex; align-items:center; gap:0.5rem;">📊 Dashboard</a>
                <a href="/admin/usuarios" style="display:flex; align-items:center; gap:0.5rem;">👥 Usuarios</a>
                <a href="/admin/cursos" style="display:flex; align-items:center; gap:0.5rem;">📚 Cursos</a>
                <a href="/admin/pedidos" style="display:flex; align-items:center; gap:0.5rem;">🛒 Pedidos</a>
                <a href="/admin/revisiones" style="display:flex; align-items:center; gap:0.5rem; position:relative;">
                    🔍 Revisiones
                    <?php if (!empty($pendientesRevision)): ?>
                        <span class="badge badge-peligro" style="position:absolute; top:-5px; right:-10px; font-size:0.7rem; min-width:1.2rem; height:1.2rem; border-radius:50%; display:flex; align-items:center; justify-content:center;">
                            <?= $pendientesRevision ?>
                        </span>
                    <?php endif; ?>
                </a>
                <div class="dropdown-divider" style="margin:1rem 0;"></div>
                <a href="/" style="display:flex; align-items:center; gap:0.5rem;">🏠 Volver a SkillUP</a>
                <a href="/logout" style="color:#f87171; display:flex; align-items:center; gap:0.5rem;">🚪 Cerrar sesión</a>
            </nav>
        </aside>

        <!-- Contenido principal -->
        <main class="admin-content" style="background:#0b1120;">
            <?php if ($mensaje = $_SESSION['mensaje'] ?? null): ?>
                <div class="flash-message flash-success" style="margin-bottom:1.5rem;">
                    <?= htmlspecialchars($mensaje) ?>
                </div>
                <?php unset($_SESSION['mensaje']); ?>
            <?php endif; ?>

            <?= $content ?? '' ?>
        </main>
    </div>

    <!-- jQuery y DataTables JS -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.min.js"></script>

    <script src="/js/app.js"></script>
</body>
</html>