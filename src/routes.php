<?php

// Home
$router->get('/', [\App\Controllers\HomeController::class, 'index']);

// Cursos
$router->get('/cursos', [\App\Controllers\CursoController::class, 'index']);
$router->get('/cursos/{id}', [\App\Controllers\CursoController::class, 'show']);

// Autenticación
$router->get('/login', [\App\Controllers\AuthController::class, 'formularioLogin']);
$router->post('/login', [\App\Controllers\AuthController::class, 'login']);
$router->get('/register', [\App\Controllers\AuthController::class, 'formularioRegister']);
$router->post('/register', [\App\Controllers\AuthController::class, 'register']);
$router->get('/logout', [\App\Controllers\AuthController::class, 'logout']);

// Carrito
$router->get('/carrito', [\App\Controllers\CarritoController::class, 'index']);
$router->get('/carrito/agregar/{id}', [\App\Controllers\CarritoController::class, 'agregar']);
$router->get('/carrito/eliminar/{id}', [\App\Controllers\CarritoController::class, 'eliminar']);
$router->get('/carrito/vaciar', [\App\Controllers\CarritoController::class, 'vaciar']);

// Checkout
$router->get('/pedido/checkout', [\App\Controllers\PedidoController::class, 'checkout']);
$router->get('/pedido/confirmacion/{id}', [\App\Controllers\PedidoController::class, 'confirmacion']);

// Panel de Instructor

$router->get('/instructor', [\App\Controllers\InstructorController::class, 'index']);
$router->get('/instructor/crear', [\App\Controllers\InstructorController::class, 'create']);
$router->post('/instructor/guardar', [\App\Controllers\InstructorController::class, 'store']);
$router->get('/instructor/editar/{id}', [\App\Controllers\InstructorController::class, 'edit']);
$router->post('instructor/actualizar/{id}', [\App\Controllers\InstructorController::class, 'update']);
$router->get('/instructor/eliminar/{id}', [\App\Controllers\InstructorController::class, 'delete']);