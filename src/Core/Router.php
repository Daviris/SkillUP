<?php

namespace App\Core;

class Router
{
    private array $routes = [];

    public function get(string $path, callable|array $handler): void
    {
        $this->addRoute('GET', $path, $handler);
    }

    public function post(string $path, callable|array $handler): void
    {
        $this->addRoute('POST', $path, $handler);
    }

    private function addRoute(string $method, string $path, callable|array $handler): void
    {
        $this->routes[$method][$path] = $handler;
    }

    public function dispatch(Request $request): void
    {
        $method = $request->method;
        $path = $request->uri;

        // Buscar las coincidencias
        if (isset($this->routes[$method][$path])) {
            $handler = $this->routes[$method][$path];
            if (is_callable($handler)) {
                echo $handler($request);
            } elseif (is_array($handler) && count($handler) === 2) {
                [$controller, $action] = $handler;
                echo (new $controller())->$action($request);
            }
            return;
        }

        // Si no lo encuentra error 404
        http_response_code(404);
        echo "404 - Página no encontrada";
    }
}