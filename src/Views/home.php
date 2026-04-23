<?php ob_start(); ?>
<div class="text-center py-10">
    <h1 class="text-6xl font-extrabold text-amber-400 tracking-tight" style="font-family: 'VT323', monospace;">SkillUP</h1>
    <p class="text-xl text-gray-300 mt-3">Sube de nivel aprendiendo nuevas habilidades</p>
    <a href="/cursos" class="inline-block mt-8 bg-amber-700 hover:bg-amber-600 text-white text-lg font-bold px-8 py-3 rounded border border-amber-500 shadow-lg transition transform hover:scale-105">
        Explorar cursos
    </a>
</div>
<?php $content = ob_get_clean(); ?>
<?php require 'layouts/main.php'; ?>