<?php

namespace App\Controllers;

use App\Core\Request;
use App\Models\Tarea;
use App\Models\Archivo;

class TareaController
{
    // Editar entrega
    public function editar(Request $request): void
    {
        if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] !== 'alumno') {
            header('Location: /login');
            exit;
        }

        $id = (int) $request->param('id');
        $entrega = Tarea::find($id);

        if (!$entrega || $entrega['alumno_id'] != $_SESSION['usuario']['id'] || $entrega['nota'] !== null) {
            http_response_code(403);
            echo "No puedes modificar esta etnrega.";
            exit;
        }

        \App\Core\View::render('tareas/editar', [
            'title' => 'Modificar entrega',
            'entrega' => $entrega,
        ]);
    }

    // Actualiza la entrega
    public function actualizar(Request $request): void
    {
        \App\Core\Csrf::verify();
        if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] !== 'alumno') {
            header('Location: /login');
            exit;
        }

        $id = (int) $request->param('id');
        $entrega = Tarea::find($id);

        if (!$entrega || $entrega['alumno_id'] != $_SESSION['usuario']['id'] || $entrega['nota'] !== null) {
            http_response_code(403);
            exit;
        }

        if (empty($_FILES['archivo']['tmp_name'])) {
            $_SESSION['mensaje'] = 'Debes seleccionar un archivo.';
            header('Location: /tarea/editar/' . $id);
            exit;
        }

        // Eliminar archivo antiguo
        if ($entrega['archivo_id']) {
            $archivoAntiguo = Archivo::find($entrega['archivo_id']);
            if ($archivoAntiguo) {
                $rutaAntigua = __DIR__ . '/../../storage/uploads/' . $archivoAntiguo['nombre_guardado'];
                if (file_exists($rutaAntigua)) {
                    unlink($rutaAntigua);
                }
                Archivo::delete($entrega['archivo_id']);
            }
        }

        // Subir nuevo archivo.
                $uploadDir = __DIR__ . '/../../storage/uploads/';
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
        $nombreGuardado = uniqid() . '_' . basename($_FILES['archivo']['name']);
        move_uploaded_file($_FILES['archivo']['tmp_name'], $uploadDir . $nombreGuardado);

        $nuevoArchivoId = Archivo::create([
            'nombre_original' => $_FILES['archivo']['name'],
            'nombre_guardado' => $nombreGuardado,
            'tipo_mime'       => mime_content_type($uploadDir . $nombreGuardado),
            'tamano'          => filesize($uploadDir . $nombreGuardado),
            'usuario_id'      => $_SESSION['usuario']['id'],
        ]);

        Tarea::update($id, ['archivo_id' => $nuevoArchivoId]);

        // Obtener el curso asociado a la clase
        $clase = \App\Models\Clase::find($entrega['clase_id']);
        $cursoId = $clase ? $clase['curso_id'] : null;

        $_SESSION['mensaje'] = 'Entrega actualizada correctamente.';
        header('Location: ' . ($cursoId ? '/mis-cursos/ver/' . $cursoId : '/mis-cursos'));
        exit;
    }

    //Elimina una entrega no calificada.
    public function eliminar(Request $request): void
    {
        \App\Core\Csrf::verify();
        if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] !== 'alumno') {
            header('Location: /login');
            exit;
        }

        $id = (int) $request->param('id');
        $entrega = Tarea::find($id);

        if (!$entrega || $entrega['alumno_id'] != $_SESSION['usuario']['id'] || $entrega['nota'] !== null) {
            http_response_code(403);
            exit;
        }

        // Eliminar archivo físico y lógico
        if ($entrega['archivo_id']) {
            $archivo = Archivo::find($entrega['archivo_id']);
            if ($archivo) {
                $ruta = __DIR__ . '/../../storage/uploads/' . $archivo['nombre_guardado'];
                if (file_exists($ruta)) unlink($ruta);
                Archivo::delete($entrega['archivo_id']);
            }
        }

        Tarea::delete($id);

        // Obtener el curso asociado a la clase
        $clase = \App\Models\Clase::find($entrega['clase_id']);
        $cursoId = $clase ? $clase['curso_id'] : null;
        
        $_SESSION['mensaje'] = 'Entrega eliminada. Puedes volver a enviarla.';
        header('Location: ' . ($cursoId ? '/mis-cursos/ver/' . $cursoId : '/mis-cursos'));
        exit;
    }
}