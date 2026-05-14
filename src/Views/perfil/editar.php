<?php ob_start(); ?>
<div class="max-w-xl mx-auto">
    <div class="bg-gray-800 border-2 border-amber-700 rounded-lg shadow-xl p-6">
        <h1 class="text-3xl font-bold text-amber-300 mb-6" style="font-family: 'VT323', monospace;">Editar Perfil</h1>

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

        <form action="/perfil/actualizar" method="POST">
            <div class="mb-5">
                <label class="block text-amber-400 text-sm font-medium mb-1">Nombre</label>
                <input type="text" name="nombre" value="<?= htmlspecialchars($usuario['nombre']) ?>" required
                       class="w-full px-4 py-2 bg-gray-700 border-2 border-amber-600 rounded text-gray-200 focus:outline-none focus:border-amber-400 transition">
            </div>
            <div class="mb-5">
                <label class="block text-amber-400 text-sm font-medium mb-1">Email</label>
                <input type="email" name="email" value="<?= htmlspecialchars($usuario['email']) ?>" required
                       class="w-full px-4 py-2 bg-gray-700 border-2 border-amber-600 rounded text-gray-200 focus:outline-none focus:border-amber-400 transition">
            </div>
            <div class="mb-5">
                <label class="block text-amber-400 text-sm font-medium mb-1">Nueva contraseña (dejar en blanco para no cambiarla)</label>
                <input type="password" name="password"
                       class="w-full px-4 py-2 bg-gray-700 border-2 border-amber-600 rounded text-gray-200 focus:outline-none focus:border-amber-400 transition">
            </div>
            <div class="mb-6">
                <label class="block text-amber-400 text-sm font-medium mb-1">Confirmar nueva contraseña</label>
                <input type="password" name="password_confirmation"
                       class="w-full px-4 py-2 bg-gray-700 border-2 border-amber-600 rounded text-gray-200 focus:outline-none focus:border-amber-400 transition">
            </div>
            <div class="flex justify-end space-x-3">
                <a href="/perfil" class="bg-gray-600 hover:bg-gray-500 text-white font-bold py-2 px-6 rounded border border-gray-500 transition">Cancelar</a>
                <button type="submit" class="bg-amber-700 hover:bg-amber-600 text-white font-bold py-2 px-6 rounded border border-amber-500 shadow transition">Guardar cambios</button>
            </div>
        </form>
    </div>
</div>
<?php $content = ob_get_clean(); ?>
<?php require __DIR__ . '/../layouts/main.php'; ?>