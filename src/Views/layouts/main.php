<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'SkillUP' ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="/css/styles.css">
    <style>
        .dropdown-menu {
            display: none;
        }
        .dropdown-menu.open {
            display: block;
        }
    </style>
</head>
<body class="bg-gray-900 text-gray-100 font-sans antialiased">
    <div class="min-h-screen flex flex-col">
        <!-- Header RPG -->
        <header class="bg-gray-900 border-b-4 border-amber-700 shadow-lg">
            <nav class="container mx-auto px-4 py-3 flex flex-wrap items-center justify-between">
                <a href="/" class="text-3xl font-bold tracking-wider text-amber-400 hover:text-amber-300 transition" style="font-family: 'VT323', monospace;">
                    SkillUP
                </a>
                <div class="flex items-center space-x-6 text-gray-200">
                    <a href="/cursos" class="hover:text-amber-400 transition font-medium">Cursos</a>

                    <?php if (isset($_SESSION['usuario'])): ?>
                        <!-- Icono del carrito -->
                        <?php
                            $count = 0;
                            if (!empty($_SESSION['carrito']['items'])) {
                                $count = count($_SESSION['carrito']['items']);
                            }
                        ?>
                        <a href="/carrito" class="relative hover:text-amber-400 transition">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                            </svg>
                            <?php if ($count > 0): ?>
                                <span class="absolute -top-2 -right-2 bg-red-700 text-white text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center border border-amber-500">
                                    <?= $count ?>
                                </span>
                            <?php endif; ?>
                        </a>

                        <!-- Dropdown del usuario -->
                        <div class="relative">
                            <button id="userMenuButton" class="flex items-center space-x-2 text-amber-300 hover:text-amber-200 transition font-medium focus:outline-none">
                                <span><?= htmlspecialchars($_SESSION['usuario']['nombre']) ?></span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                            </button>
                            <div id="userDropdown" class="dropdown-menu absolute right-0 mt-2 w-56 bg-gray-800 border-2 border-amber-700 rounded-lg shadow-xl z-50">
                                <div class="py-2">
                                    <a href="/perfil" class="block px-4 py-2 text-sm text-gray-200 hover:bg-gray-700 hover:text-amber-400 transition">Mi Perfil</a>
                                    <?php if ($_SESSION['usuario']['rol'] === 'alumno'): ?>
                                        <a href="/mis-cursos" class="block px-4 py-2 text-sm text-gray-200 hover:bg-gray-700 hover:text-amber-400 transition">Mis Cursos</a>
                                    <?php endif; ?>
                                    <?php if ($_SESSION['usuario']['rol'] === 'instructor'): ?>
                                        <a href="/instructor" class="block px-4 py-2 text-sm text-gray-200 hover:bg-gray-700 hover:text-amber-400 transition">Panel Instructor</a>
                                    <?php endif; ?>
                                    <?php if ($_SESSION['usuario']['rol'] === 'admin'): ?>
                                        <a href="/admin" class="block px-4 py-2 text-sm text-gray-200 hover:bg-gray-700 hover:text-amber-400 transition">Panel Admin</a>
                                    <?php endif; ?>
                                    <hr class="border-gray-600 my-1">
                                    <a href="/logout" class="block px-4 py-2 text-sm text-red-400 hover:bg-gray-700 hover:text-red-300 transition">Cerrar sesión</a>
                                </div>
                            </div>
                        </div>
                    <?php else: ?>
                        <a href="/login" class="hover:text-amber-400 transition font-medium">Login</a>
                        <a href="/register" class="bg-amber-700 hover:bg-amber-600 text-white px-4 py-2 rounded border border-amber-500 shadow transition font-medium">Registro</a>
                    <?php endif; ?>
                </div>
            </nav>
        </header>

        <main class="flex-grow container mx-auto px-4 py-8">
            <?php if (($mensaje = $_SESSION['mensaje'] ?? null)): ?>
                <div class="bg-green-900/50 border border-green-600 text-green-200 px-4 py-3 rounded mb-6">
                    <?= htmlspecialchars($mensaje) ?>
                </div>
                <?php unset($_SESSION['mensaje']); ?>
            <?php endif; ?>
            <?= $content ?? '' ?>
        </main>

        <footer class="bg-gray-800 text-white text-center py-4 text-sm">
            &copy; <?= date('Y') ?> SkillUP - TFG DAW
        </footer>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var button = document.getElementById('userMenuButton');
            var dropdown = document.getElementById('userDropdown');
            if (button && dropdown) {
                button.addEventListener('click', function(e) {
                    e.stopPropagation();
                    dropdown.classList.toggle('open');
                });
                document.addEventListener('click', function() {
                    dropdown.classList.remove('open');
                });
                dropdown.addEventListener('click', function(e) {
                    e.stopPropagation();
                });
            }
        });
    </script>
</body>
</html>