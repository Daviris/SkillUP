<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Admin SkillUP' ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="/css/styles.css">
</head>
<body class="bg-gray-900 text-gray-100 font-sans antialiased">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside class="w-64 bg-gray-800 border-r-2 border-amber-700 p-6 flex-shrink-0">
            <h2 class="text-2xl font-bold text-amber-400 mb-8" style="font-family: 'VT323', monospace;">Admin Panel</h2>
            <nav class="space-y-2">
                <a href="/admin" class="block px-3 py-2 rounded hover:bg-amber-700 hover:text-white transition text-gray-300">Dashboard</a>
                <a href="/admin/usuarios" class="block px-3 py-2 rounded hover:bg-amber-700 hover:text-white transition text-gray-300">Usuarios</a>
                <a href="/admin/cursos" class="block px-3 py-2 rounded hover:bg-amber-700 hover:text-white transition text-gray-300">Cursos</a>
                <a href="/admin/pedidos" class="block px-3 py-2 rounded hover:bg-amber-700 hover:text-white transition text-gray-300">Pedidos</a>
                <a href="/admin/resenas" class="block px-3 py-2 rounded hover:bg-amber-700 hover:text-white transition text-gray-300">Reseñas</a>
                <hr class="border-gray-600 my-4">
                <a href="/" class="block px-3 py-2 rounded hover:bg-gray-700 transition text-gray-400">Volver a SkillUP</a>
                <a href="/logout" class="block px-3 py-2 rounded hover:bg-red-800 hover:text-white transition text-red-400">Cerrar sesión</a>
            </nav>
        </aside>
        <!-- Contenido principal -->
        <main class="flex-grow p-8">
            <?= $content ?? '' ?>
        </main>
    </div>
</body>
</html>