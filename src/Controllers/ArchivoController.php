<?php

namespace App\Controllers;

use App\Core\Request;
use App\Core\Database;
use App\Models\Archivo;
use App\Models\Tarea;

class ArchivoController
{
    public function subir(Request $request): void
    {
        \App\Core\Csrf::verify();
        if (!isset($_SESSION['usuario'])) {
            header('Location: /login');
            exit;
        }

        $claseId = (int) $request->input('clase_id');
        $archivo = $_FILES['archivo'] ?? null;

        if (!$archivo || $archivo['error'] !== UPLOAD_ERR_OK) {
            $_SESSION['mensaje'] = 'Error al subir el archivo.';
            header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? '/'));
            exit;
        }

        // Validar tamaño máximo (10 MB)
        $tamanoMaximo = 10 * 1024 * 1024; // 10 MB en bytes
        if ($archivo['size'] > $tamanoMaximo) {
            $_SESSION['mensaje'] = 'El archivo es demasiado grande. El tamaño máximo permitido es de 10 MB.';
            header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? '/'));
            exit;
        }

        // Validar tipos de archivo permitidos
        $tiposPermitidos = [
            'application/pdf',                                                                               // PDF
            'image/jpeg',                                                                                     // JPEG
            'image/png',                                                                                      // PNG
            'image/gif',                                                                                      // GIF
            'text/plain',                                                                                     // Texto plano
            'text/csv',                                                                                       // CSV
            'application/zip',                                                                                // ZIP
            'application/x-rar-compressed',                                                                   // RAR
            'application/msword',                                                                             // DOC
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',                        // DOCX
            'application/vnd.ms-excel',                                                                       // XLS
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',                              // XLSX
            'application/vnd.ms-powerpoint',                                                                  // PPT
            'application/vnd.openxmlformats-officedocument.presentationml.presentation',                      // PPTX
            'text/html',                                                                                      // HTML
            'text/css',                                                                                       // CSS
            'text/javascript',                                                                                // JS
            'application/json',                                                                               // JSON
            'application/xml',                                                                                // XML
            'text/xml',                                                                                       // XML (alternativo)
            'application/octet-stream',                                                                       // Genérico (archivos sin tipo MIME definido)
        ];

        $tipoArchivo = mime_content_type($archivo['tmp_name']);
        if (!in_array($tipoArchivo, $tiposPermitidos)) {
            $_SESSION['mensaje'] = 'El tipo de archivo no está permitido. Se aceptan PDF, imágenes, documentos de Office, archivos de código y texto.';
            header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? '/'));
            exit;
        }

        // Guardar archivo subido
        $uploadDir = __DIR__ . '/../../storage/uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        $nombreGuardado = uniqid() . '_' . basename($archivo['name']);
        $rutaDestino = $uploadDir . $nombreGuardado;
        move_uploaded_file($archivo['tmp_name'], $rutaDestino);

        // Registrar archivo en la BD
        $archivoId = Archivo::create([
            'nombre_original' => $archivo['name'],
            'nombre_guardado' => $nombreGuardado,
            'tipo_mime'       => $tipoArchivo,
            'tamano'          => filesize($rutaDestino),
            'usuario_id'      => $_SESSION['usuario']['id'],
        ]);

        // Subida tarea de alumno
        $clase = \App\Models\Clase::find($claseId);
        if ($clase && $clase['tipo'] === 'tarea' && $_SESSION['usuario']['rol'] === 'alumno') {
            Tarea::create([
                'clase_id'   => $claseId,
                'alumno_id'  => $_SESSION['usuario']['id'],
                'archivo_id' => $archivoId,
            ]);
            $_SESSION['mensaje'] = 'Tarea enviada correctamente.';
            header('Location: /mis-cursos/ver/' . $clase['curso_id']);
            exit;
        }

        // Actualizar archivos instructor
        if ($clase && $_SESSION['usuario']['rol'] === 'instructor') {
            $curso = \App\Models\Curso::find($clase['curso_id']);
            if ($curso && $curso['id_instructor'] == $_SESSION['usuario']['id']) {
                \App\Models\Clase::update($claseId, ['archivo_id' => $archivoId]);
                $_SESSION['mensaje'] = 'Archivo actualizado correctamente.';
                header('Location: /instructor/clases/ver/' . $claseId);
                exit;
            }
        }

        // Si no se cumplió ninguna condición, redirigir a un lugar seguro
        $_SESSION['mensaje'] = 'No se pudo procesar la subida.';
        header('Location: /');
        exit;
    }

    // Descargar los archivos
    public function descargar(Request $request): void
    {
        $id = (int) $request->param('id');
        $archivo = Archivo::find($id);
        if (!$archivo) {
            http_response_code(404);
            echo "Archivo no encontrado.";
            exit;
        }

        if (!isset($_SESSION['usuario'])) {
            http_response_code(403);
            echo "Acceso denegado.";
            exit;
        }

        $ruta = __DIR__ . '/../../storage/uploads/' . $archivo['nombre_guardado'];
        if (!file_exists($ruta)) {
            http_response_code(404);
            echo "El archivo no existe en el servidor.";
            exit;
        }

        header('Content-Type: ' . ($archivo['tipo_mime'] ?? 'application/octet-stream'));
        header('Content-Disposition: attachment; filename="' . $archivo['nombre_original'] . '"');
        header('Content-Length: ' . filesize($ruta));
        readfile($ruta);
        exit;
    }
}