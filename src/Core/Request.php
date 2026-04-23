<?php

namespace App\Core;

class Request
{
    public readonly string $method;
    public readonly string $uri;

    public function __construct()
    {
        $this->method = $_SERVER['REQUEST_METHOD'];
        // Obtener la URI sin query string
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        // Quitar el prefijo base
        $this->uri = rtrim($uri, '/') ?: '/';
    }

    public static function capture(): self
    {
        return new self();
    }

    public function input(string $key, $default = null): mixed
    {
        return $_REQUEST[$key] ?? $default;
    }
}