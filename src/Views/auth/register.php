<?php ob_start(); ?>
<div class="min-h-[80vh] flex items-center justify-center px-4 py-8">
    <div class="w-full max-w-lg">
        <div class="bg-gray-800 border-4 border-amber-700 rounded-lg shadow-2xl p-8 relative">
            <div class="absolute -top-3 -left-3 text-3xl text-amber-500">✦</div>
            <div class="absolute -top-3 -right-3 text-3xl text-amber-500">✦</div>
            <div class="absolute -bottom-3 -left-3 text-3xl text-amber-500">✦</div>
            <div class="absolute -bottom-3 -right-3 text-3xl text-amber-500">✦</div>

            <h2 class="text-3xl font-bold text-amber-300 mb-2 text-center" style="font-family: 'VT323', monospace;">Crear Cuenta</h2>
            <div class="h-1 w-16 bg-amber-700 mx-auto mb-6"></div>

            <?php if (!empty($_SESSION['errores'])): ?>
                <div class="bg-red-900/50 border border-red-600 text-red-200 px-4 py-3 rounded mb-6">
                    <ul class="list-disc list-inside text-sm">
                        <?php foreach ($_SESSION['errores'] as $error): ?>
                            <li><?= htmlspecialchars($error) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <?php unset($_SESSION['errores']); ?>
            <?php endif; ?>

            <form method="POST" action="/register">
                <div class="mb-5">
                    <label for="nombre" class="block text-amber-400 text-sm font-medium mb-1">Nombre completo</label>
                    <input type="text" name="nombre" id="nombre" value="<?= htmlspecialchars($_SESSION['old']['nombre'] ?? '') ?>"
                           class="w-full px-4 py-2 bg-gray-700 border-2 border-amber-600 rounded text-gray-200 placeholder-gray-400 focus:outline-none focus:border-amber-400 transition"
                           placeholder="Tu nombre" required>
                </div>
                <div class="mb-5">
                    <label for="email" class="block text-amber-400 text-sm font-medium mb-1">Correo electrónico</label>
                    <input type="email" name="email" id="email" value="<?= htmlspecialchars($_SESSION['old']['email'] ?? '') ?>"
                           class="w-full px-4 py-2 bg-gray-700 border-2 border-amber-600 rounded text-gray-200 placeholder-gray-400 focus:outline-none focus:border-amber-400 transition"
                           placeholder="ejemplo@correo.com" required>
                </div>
                <div class="mb-5">
                    <label for="password" class="block text-amber-400 text-sm font-medium mb-1">Contraseña (mínimo 8 caracteres)</label>
                    <input type="password" name="password" id="password"
                           class="w-full px-4 py-2 bg-gray-700 border-2 border-amber-600 rounded text-gray-200 placeholder-gray-400 focus:outline-none focus:border-amber-400 transition"
                           placeholder="••••••••" required>
                </div>
                <div class="mb-5">
                    <label for="password_confirmation" class="block text-amber-400 text-sm font-medium mb-1">Confirmar contraseña</label>
                    <input type="password" name="password_confirmation" id="password_confirmation"
                           class="w-full px-4 py-2 bg-gray-700 border-2 border-amber-600 rounded text-gray-200 placeholder-gray-400 focus:outline-none focus:border-amber-400 transition"
                           placeholder="••••••••" required>
                </div>
                <div class="mb-6">
                    <label for="rol" class="block text-amber-400 text-sm font-medium mb-1">Tipo de cuenta</label>
                    <select name="rol" id="rol"
                            class="w-full px-4 py-2 bg-gray-700 border-2 border-amber-600 rounded text-gray-200 focus:outline-none focus:border-amber-400 transition" required>
                        <option value="alumno" <?= ($_SESSION['old']['rol'] ?? '') === 'alumno' ? 'selected' : '' ?>>Alumno</option>
                        <option value="instructor" <?= ($_SESSION['old']['rol'] ?? '') === 'instructor' ? 'selected' : '' ?>>Instructor</option>
                    </select>
                </div>
                <button type="submit"
                        class="w-full bg-amber-700 hover:bg-amber-600 text-white font-bold py-3 px-4 rounded border border-yellow-600 shadow-lg transition transform hover:scale-105">
                    Registrarse
                </button>
            </form>
            <div class="mt-6 text-center">
                <p class="text-gray-400">
                    ¿Ya tienes cuenta?
                    <a href="/login" class="text-amber-400 hover:text-amber-300 hover:underline transition">Inicia sesión</a>
                </p>
            </div>
        </div>
    </div>
</div>
<?php $content = ob_get_clean(); ?>
<?php require __DIR__ . '/../layouts/main.php'; ?>