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
        $pattern = preg_replace('/\{(\w+)\}/', '(?P<$1>[^/]+)', $path);
        $pattern = "#^" . $pattern . "$#";
        $this->routes[$method][$pattern] = [$handler, $path];
    }

    public function dispatch(Request $request): void
    {
        $method = $request->method;
        $uri = $request->uri;

        foreach ($this->routes[$method] ?? [] as $pattern => [$handler, $path]) {
            if (preg_match($pattern, $uri, $matches)) {
                // Extraer parámetros de la URL
                $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
                
                $request->uri;

                if (is_callable($handler)) {
                    echo $handler($request);
                } elseif (is_array($handler) && count($handler) === 2) {
                    [$controller, $action] = $handler;
                    echo (new $controller())->$action($request);
                }
                return;
            }
        }

        // Si no lo encuentra error 404
        http_response_code(404);
        echo "404 - Página no encontrada";
    }
}