<?php

// Home
$router->get('/', [\App\Controllers\HomeController::class, 'index']);

// Cursos
$router->get('/cursos', [\App\Controllers\CursoController::class, 'index']);
$router->get('/cursos/{id}', [\App\Controllers\CursoController::class, 'show']);
$router->get('/mis-cursos', [\App\Controllers\MisCursosController::class, 'index']);
$router->get('/mis-cursos/ver/{id}', [\App\Controllers\AlumnoCursoController::class, 'verCurso']);

// Clases
$router->get('/instructor/cursos/{curso_id}/clases', [\App\Controllers\InstructorClaseController::class, 'index']);
$router->get('/instructor/cursos/{curso_id}/clases/crear', [\App\Controllers\InstructorClaseController::class, 'create']);
$router->post('/instructor/clases/guardar', [\App\Controllers\InstructorClaseController::class, 'store']);
$router->get('/instructor/clases/editar/{id}', [\App\Controllers\InstructorClaseController::class, 'edit']);
$router->post('/instructor/clases/actualizar/{id}', [\App\Controllers\InstructorClaseController::class, 'update']);
$router->get('/instructor/clases/eliminar/{id}', [\App\Controllers\InstructorClaseController::class, 'delete']);
$router->get('/instructor/clases/{id}/entregas', [\App\Controllers\InstructorClaseController::class, 'verEntregas']);
$router->post('/instructor/entregas/calificar', [\App\Controllers\InstructorClaseController::class, 'calificarEntrega']);
$router->get('/mis-cursos/clase/{id}', [\App\Controllers\AlumnoCursoController::class, 'verClase']);

// Subida/Descarga de archivos
$router->post('/archivo/subir', [\App\Controllers\ArchivoController::class, 'subir']);
$router->get('/archivo/descargar/{id}', [\App\Controllers\ArchivoController::class, 'descargar']);

// Tareas
$router->get('/tarea/editar/{id}', [\App\Controllers\TareaController::class, 'editar']);
$router->post('/tarea/actualizar/{id}', [\App\Controllers\TareaController::class, 'actualizar']);
$router->get('/tarea/eliminar/{id}', [\App\Controllers\TareaController::class, 'eliminar']);

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

$router->get('/pedido/confirmacion/{id}', [\App\Controllers\PedidoController::class, 'confirmacion']);
$router->get('/checkout', [\App\Controllers\PedidoController::class, 'formularioCheckout']);
$router->post('/checkout/procesar', [\App\Controllers\PedidoController::class, 'procesarCheckout']);

// Panel de Instructor
$router->get('/instructor', [\App\Controllers\InstructorController::class, 'index']);
$router->get('/instructor/crear', [\App\Controllers\InstructorController::class, 'create']);
$router->post('/instructor/guardar', [\App\Controllers\InstructorController::class, 'store']);
$router->get('/instructor/editar/{id}', [\App\Controllers\InstructorController::class, 'edit']);
$router->post('/instructor/actualizar/{id}', [\App\Controllers\InstructorController::class, 'update']);
$router->get('/instructor/eliminar/{id}', [\App\Controllers\InstructorController::class, 'delete']);