<?php

namespace App\Core;

class View
{
    public static function render(string $template, array $data = []): void
    {
        extract($data);
        $viewFile = __DIR__ . '/../Views/' . $template . '.php';
        if (!file_exists($viewFile)) {
            throw new \RuntimeException("Vista no encontrada: {$template}");
        }
        require $viewFile;
    }
}