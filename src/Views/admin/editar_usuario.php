<?php ob_start(); ?>
<h1 class="text-3xl font-bold text-amber-300 mb-6">Editar usuario</h1>
<form action="/admin/usuarios/actualizar/<?= $usuario['id'] ?>" method="POST" class="max-w-lg bg-gray-800 p-6 rounded-lg border border-amber-700">
    <div class="mb-4">
        <label class="block text-amber-400 text-sm mb-1">Nombre</label>
        <input type="text" name="nombre" value="<?= htmlspecialchars($usuario['nombre']) ?>" required class="w-full px-4 py-2 bg-gray-700 border border-amber-600 rounded text-gray-200">
    </div>
    <div class="mb-4">
        <label class="block text-amber-400 text-sm mb-1">Email</label>
        <input type="email" name="email" value="<?= htmlspecialchars($usuario['email']) ?>" required class="w-full px-4 py-2 bg-gray-700 border border-amber-600 rounded text-gray-200">
    </div>
    <div class="mb-4">
        <label class="block text-amber-400 text-sm mb-1">Contraseña (dejar en blanco para no cambiar)</label>
        <input type="password" name="password" class="w-full px-4 py-2 bg-gray-700 border border-amber-600 rounded text-gray-200">
    </div>
    <div class="mb-4">
        <label class="block text-amber-400 text-sm mb-1">Rol</label>
        <select name="rol" class="w-full px-4 py-2 bg-gray-700 border border-amber-600 rounded text-gray-200">
            <option value="alumno" <?= $usuario['rol'] === 'alumno' ? 'selected' : '' ?>>Alumno</option>
            <option value="instructor" <?= $usuario['rol'] === 'instructor' ? 'selected' : '' ?>>Instructor</option>
            <option value="admin" <?= $usuario['rol'] === 'admin' ? 'selected' : '' ?>>Admin</option>
        </select>
    </div>
    <button type="submit" class="bg-amber-700 hover:bg-amber-600 text-white font-bold py-2 px-6 rounded border border-amber-500 shadow transition">Actualizar</button>
</form>
<?php $content = ob_get_clean(); ?>
<?php require __DIR__ . '/layout.php'; ?>