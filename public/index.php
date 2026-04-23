<?php

declare(strict_types=1);

// Autoload de Composer
require_once __DIR__ . '/../vendor/autoload.php';

use App\Core\Request;
use App\Core\Router;
use App\Core\Session;

// Inicia sesión
Session::start();

// Carga la configuración de la BD
$config = require_once __DIR__ . '/../config/database.php';

// Crea la conexión con la BD
\App\Core\Database::init($config);

// Carga las rutas
$router = new Router();
require_once __DIR__ . '/../src/routes.php';

// Despacha la petición
$router->dispatch(Request::capture());