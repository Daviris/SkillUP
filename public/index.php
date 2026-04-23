<?php
declare(strict_types=1);

error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

require_once __DIR__ . '/../vendor/autoload.php';

use App\Core\Request;
use App\Core\Router;
use App\Core\Session;
use App\Core\Database;

Session::start();

$config = require_once __DIR__ . '/../config/database.php';
Database::init($config);

// Construir Request manualmente con ajuste de subdirectorio
$method = $_SERVER['REQUEST_METHOD'];
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Quitar el prefijo /skillup/public automáticamente
$scriptDir = dirname($_SERVER['SCRIPT_NAME']); // ej: /skillup/public
if ($scriptDir !== '/' && strpos($uri, $scriptDir) === 0) {
    $uri = substr($uri, strlen($scriptDir));
}
// Si queda vacía, es la raíz
if (empty($uri)) {
    $uri = '/';
}

$request = new Request();
$request->method = $method;
$request->uri = $uri;

$router = new Router();
require_once __DIR__ . '/../src/routes.php';
$router->dispatch($request);