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
        if (!isset($_SESSION['usuario'])) {
            header('Location: /login');
            exit;
        }

        $claseId = (int) $request->input('clase_id');
        $archivo = $_FILES['archivo'] ?? null;

        if (!$archivo || $archivo['error'] !== UPLOAD_ERR_OK) {
            die('Error al subir archivo.');
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
            'tipo_mime' => mime_content_type($rutaDestino),
            'tamano' => filesize($rutaDestino),
            'usuario_id' => $_SESSION['usuario']['id'],
        ]);

        // Subida tarea de alumno
        $clase = \App\Models\Clase::find($claseId);
        if ($clase && $clase['tipo'] === 'tarea' && $_SESSION['usuario']['rol'] === 'alumno') {
            Tarea::create([
                'clase_id' => $claseId,
                'alumno_id' => $_SESSION['usuario']['id'],
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
                $_SESSION['mensaje'] = 'Archivo actualizado';
                header('Location: /instructor/clases/' . $claseId);
                exit;
            }
        }
    }

    // Descargar los archivos
    public function descargar(Request $request): void
    {
        $id = (int) $request->param('id');
        $archivo = Archivo::find($id);
        if (!$archivo) {
            http_response_code(404);
            exit;
        }

        if (!isset($_SESSION['usuario'])) {
            http_response_code(403);
            exit;
        }

        $ruta = __DIR__ . '/../../storage/uploads/' . $archivo['nombre_guardado'];
        if (file_exists($ruta)) {
            header('Content-Type: ' . $archivo['tipo_mime']);
            header('Content-Disposition: attachment; filename="' . $archivo['nombre_original'] . '"');
            readfile($ruta);
            exit;
        }
    }
}