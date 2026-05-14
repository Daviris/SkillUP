<?php

namespace App\Core;

class ExceptionHandler
{
    public static function handleException(\Throwable $exception): void
    {
        $logDir = __DIR__ . '/../../storage/logs';
        if (!is_dir($logDir)) {
            mkdir($logDir, 0777, true);
        }
        $logFile = $logDir . '/error.log';
        $mensaje = '[' . date('Y-m-d H:i:s') . '] ';
        $mensaje .= $exception->getMessage() . ' en ' . $exception->getFile() . ' línea ' . $exception->getLine() . "\n";
        file_put_contents($logFile, $mensaje, FILE_APPEND);

        while (ob_get_level()) {
            ob_end_clean();
        }

        http_response_code(500);

        if (class_exists('App\\Core\\View')) {
            try {
                View::render('error/500', ['message' => $exception->getMessage()]);
            } catch (\Throwable $e) {
                echo '<h1>Error interno del servidor</h1>';
                echo '<p>Ocurrió un error inesperado.';
            }
        } else {
            echo '<h1>Error interno del servidor</h1>';
            echo '<p>Ocurrió un error inesperado.';
        }

        exit;
    }
}