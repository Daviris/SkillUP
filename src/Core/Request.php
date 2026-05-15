<?php

namespace App\Core;

class Request
{
    public string $method;
    public string $uri;
    private array $routeParams = [];

    public function __construct(bool $useServer = true)
    {
        if ($useServer) {
            $this->method = $_SERVER['REQUEST_METHOD'];
            // Obtener la URI sin query string
            $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
            // Quitar el prefijo base
            $this->uri = rtrim($uri, '/') ?: '/';
        }
    }

    public function input(string $key, $default = null): mixed
    {
        return $_REQUEST[$key] ?? $default;
    }

    public function param(string $key, $default = null): ?string
    {
        return $this->routeParams[$key] ?? $default;
    }

    public static function capture(): self
    {
        return new self();
    }

    public function setRouteParams(array $params): void
    {
        $this->routeParams = $params;
    }

    public static function blank(): self
    {
        return new self(false);
    }
}