<?php

$router->get('/', [\App\Controllers\HomeController::class, 'index']);
$router->get('/cursos', [\App\Controllers\CursoController::class, 'index']);
$router->get('/cursos/{id}', [\App\Controllers\CursoController::class, 'show']);
$router->get('/login', [\App\Controllers\AuthController::class, 'loginForm']);
$router->post('/login', [\App\Controllers\AuthController::class, 'login']);
$router->get('/register', [\App\Controllers\AuthController::class, 'registerForm']);
$router->post('/register', [\App\Controllers\AuthController::class, 'register']);
$router->get('/logout', [\App\Controllers\AuthController::class, 'logout']);