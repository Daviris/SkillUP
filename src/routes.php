<?php

// Home
$router->get('/', [\App\Controllers\HomeController::class, 'index']);

// Cursos
$router->get('/cursos', [\App\Controllers\CursoController::class, 'index']);
$router->get('/cursos/{id}', [\App\Controllers\CursoController::class, 'show']);
$router->get('/mis-cursos', [\App\Controllers\MisCursosController::class, 'index']);
$router->get('/mis-cursos/ver/{id}', [\App\Controllers\AlumnoCursoController::class, 'verCurso']);

// Panel de Instructor
$router->get('/instructor', [\App\Controllers\InstructorController::class, 'index']);
$router->get('/instructor/crear', [\App\Controllers\InstructorController::class, 'create']);
$router->post('/instructor/guardar', [\App\Controllers\InstructorController::class, 'store']);
$router->get('/instructor/editar/{id}', [\App\Controllers\InstructorController::class, 'edit']);
$router->post('/instructor/actualizar/{id}', [\App\Controllers\InstructorController::class, 'update']);
$router->get('/instructor/eliminar/{id}', [\App\Controllers\InstructorController::class, 'delete']);
$router->get('/instructor/cursos/{id}/asistentes', [\App\Controllers\InstructorController::class, 'verAsistentes']);
$router->get('/instructor/enviar-revision/{id}', [\App\Controllers\InstructorController::class, 'enviarRevision']);
$router->get('/instructor/{id}', [\App\Controllers\CursoController::class, 'verInstructor']);
$router->get('/admin/cursos/ver-clases/{id}', [\App\Controllers\AdminController::class, 'verClasesCurso']);

// Clases
$router->get('/instructor/cursos/{curso_id}/clases', [\App\Controllers\InstructorClaseController::class, 'index']);
$router->get('/instructor/cursos/{curso_id}/clases/crear', [\App\Controllers\InstructorClaseController::class, 'create']);
$router->post('/instructor/clases/guardar', [\App\Controllers\InstructorClaseController::class, 'store']);
$router->get('/instructor/clases/editar/{id}', [\App\Controllers\InstructorClaseController::class, 'edit']);
$router->post('/instructor/clases/actualizar/{id}', [\App\Controllers\InstructorClaseController::class, 'update']);
$router->get('/instructor/clases/eliminar/{id}', [\App\Controllers\InstructorClaseController::class, 'delete']);
$router->get('/instructor/clases/{id}/entregas', [\App\Controllers\InstructorClaseController::class, 'verEntregas']);
$router->post('/instructor/entregas/calificar', [\App\Controllers\InstructorClaseController::class, 'calificarEntrega']);
$router->get('/mis-cursos/clase/{id}', [\App\Controllers\ClaseIndividualController::class, 'mostrar']);
$router->get('/instructor/clases/ver/{id}', [\App\Controllers\InstructorClaseController::class, 'verClase']);

// Subida/Descarga de archivos
$router->post('/archivo/subir', [\App\Controllers\ArchivoController::class, 'subir']);
$router->get('/archivo/descargar/{id}', [\App\Controllers\ArchivoController::class, 'descargar']);

// Tareas
$router->get('/tarea/editar/{id}', [\App\Controllers\TareaController::class, 'editar']);
$router->post('/tarea/actualizar/{id}', [\App\Controllers\TareaController::class, 'actualizar']);
$router->get('/tarea/eliminar/{id}', [\App\Controllers\TareaController::class, 'eliminar']);
$router->post('/instructor/entregas/actualizar', [\App\Controllers\InstructorClaseController::class, 'actualizarNota']);

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
$router->get('/pedidos/confirmacion/{id}', [\App\Controllers\PedidoController::class, 'confirmacion']);
$router->get('/checkout', [\App\Controllers\PedidoController::class, 'formularioCheckout']);
$router->post('/checkout/procesar', [\App\Controllers\PedidoController::class, 'procesarCheckout']);

// Reseñas
$router->post('/resena/guardar', [\App\Controllers\ResenaController::class, 'store']);
$router->get('/resena/editar/{id}', [\App\Controllers\ResenaController::class, 'edit']);
$router->post('/resena/actualizar/{id}', [\App\Controllers\ResenaController::class, 'update']);
$router->get('/resena/eliminar/{id}', [\App\Controllers\ResenaController::class, 'delete']);

// Perfil de usuario
$router->get('/perfil', [\App\Controllers\PerfilController::class, 'index']);
$router->get('/perfil/editar', [\App\Controllers\PerfilController::class, 'edit']);
$router->post('/perfil/actualizar', [\App\Controllers\PerfilController::class, 'update']);

// Administrador
$router->get('/admin', [\App\Controllers\AdminController::class, 'dashboard']);
$router->get('/admin/usuarios', [\App\Controllers\AdminController::class, 'usuarios']);
$router->get('/admin/usuarios/editar/{id}', [\App\Controllers\AdminController::class, 'editarUsuario']);
$router->post('/admin/usuarios/actualizar/{id}', [\App\Controllers\AdminController::class, 'actualizarUsuario']);
$router->get('/admin/usuarios/eliminar/{id}', [\App\Controllers\AdminController::class, 'eliminarUsuario']);
$router->get('/admin/usuarios/{id}/cursos', [\App\Controllers\AdminController::class, 'cursosDeAlumno']);
$router->get('/admin/cursos', [\App\Controllers\AdminController::class, 'cursos']);
$router->get('/admin/cursos/editar/{id}', [\App\Controllers\AdminController::class, 'editarCurso']);
$router->post('/admin/cursos/actualizar/{id}', [\App\Controllers\AdminController::class, 'actulizarCurso']);
$router->get('/admin/cursos/eliminar/{id}', [\App\Controllers\AdminController::class, 'eliminarCurso']);
$router->get('/admin/cursos/{id}/resenas', [\App\Controllers\AdminController::class, 'verResenas']);
$router->get('/admin/cursos/{id}/alumnos', [\App\Controllers\AdminController::class, 'alumnosDeCurso']);
$router->get('/admin/resenas/eliminar/{id}', [\App\Controllers\AdminController::class, 'eliminarResena']);
$router->get('/admin/pedidos', [\App\Controllers\AdminController::class, 'pedidos']);
$router->post('/admin/pedidos/cambiar-estado/{id}', [\App\Controllers\AdminController::class, 'cambiarEstadoPedido']);
$router->get('/admin/pedidos/cambiar-estado/{id}', [\App\Controllers\AdminController::class, 'cambiarEstadoPedido']);
$router->get('/admin/pedidos/ver/{id}', [\App\Controllers\AdminController::class, 'verPedido']);
$router->get('/admin/pedidos/revocar/{id}', [\App\Controllers\AdminController::class, 'revocarAccesoCurso']);
$router->get('/admin/revisiones', [\App\Controllers\AdminController::class, 'revisiones']);
$router->get('/admin/revisiones/aprobar/{id}', [\App\Controllers\AdminController::class, 'aprobarCurso']);
$router->post('/admin/revisiones/rechazar/{id}', [\App\Controllers\AdminController::class, 'rechazarCurso']);
$router->get('/admin/revisiones/ver-clases/{id}', [\App\Controllers\AdminController::class, 'verClasesRevision']);
$router->get('/admin/clases/editar/{id}', [\App\Controllers\AdminController::class, 'editarClase']);
$router->post('/admin/clases/actualizar/{id}', [\App\Controllers\AdminController::class, 'actualizarClase']);
$router->get('/admin/clases/eliminar/{id}', [\App\Controllers\AdminController::class, 'eliminarClase']);

// Endpoints JavaScript
$router->get('/api/cursos', [\App\Controllers\CursoController::class, 'apiIndex']);
$router->get('/api/curso/{id}', [\App\Controllers\CursoController::class, 'apiShow']);
$router->get('/api/admin/usuarios', [\App\Controllers\AdminController::class, 'apiUsuarios']);
$router->get('/api/admin/cursos', [\App\Controllers\AdminController::class, 'apiCursos']);
$router->get('/api/admin/pedidos', [\App\Controllers\AdminController::class, 'apiPedidos']);
$router->get('/api/admin/cursos/{id}/resenas', [\App\Controllers\AdminController::class, 'apiResenasCurso']);