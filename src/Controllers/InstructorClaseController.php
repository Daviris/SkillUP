<?php

namespace App\Controllers;

use App\Core\Request;
use App\Core\View;
use App\Models\Clase;
use App\Models\Curso;
use App\Models\Tarea;

class InstructorClaseController
{
    private function verificarInstructor(): void
    {
        if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] !== 'instructor') {
            header('Location: /login');
            exit;
        }
    }

    // Listar clases de un curso
    public function index(Request $request): void
    {
        $this->verificarInstructor();
        $cursoId = (int) $request->param('curso_id');
        $curso = Curso::find($cursoId);
        
        if (!$curso) {
            http_response_code(404);
            echo "Curso no encontrado.";
            exit;
        }
        if ($curso['id_instructor'] != $_SESSION['usuario']['id']) {
            http_response_code(403);
            echo "No eres el propietario de este curso.";
            exit;
        }
        
        $clases = Clase::porCurso($cursoId);
        View::render('instructor/clases/index', [
            'title' => 'Clases de ' . $curso['titulo'],
            'curso' => $curso,
            'clases' => $clases,
        ]);
    }

    // Crear clase
    public function create(Request $request): void
    {
        $this->verificarInstructor();
        $cursoId = (int) $request->param('curso_id');
        $curso = Curso::find($cursoId);
        if (!$curso || $curso['id_instructor'] != $_SESSION['usuario']['id']) {
            http_response_code(403);
            echo "No autorizado.";
            exit;
        }
        View::render('instructor/clases/formClase', [
            'title' => 'Nueva clase',
            'accion' => 'Crear',
            'curso_id' => $cursoId,
        ]);
    }

    // Guardar clase creada
    public function store(Request $request): void
    {
        $this->verificarInstructor();

        $cursoId = (int) $request->input('curso_id');
        $curso = Curso::find($cursoId);

        if (!$curso || $curso['id_instructor'] != $_SESSION['usuario']['id']) {
            http_response_code(403);
            echo "No autorizado.";
            exit;
        }

        $tipo = $request->input('tipo');

        // Asignar automáticamente el orden si se deja vacío
        $pdo = \App\Core\Database::getConnection();
        $stmt = $pdo->prepare("SELECT MAX(orden) FROM clases WHERE curso_id = :curso_id");
        $stmt->execute(['curso_id' => $cursoId]);
        $max = $stmt->fetchColumn();
        $orden = ($max !== false) ? (int)$max + 1 : 1;

        $data = [
            'curso_id' => $cursoId,
            'titulo'   => $request->input('titulo'),
            'duracion' => $request->input('duracion'),
            'orden'    => $orden,
            'tipo'     => $tipo,
        ];

        if ($tipo === 'teoria') {
            $data['contenido_texto'] = $request->input('contenido_texto');
        } elseif ($tipo === 'tarea') {
            $data['fecha_limite'] = $request->input('fecha_limite')
                ? date('Y-m-d H:i:s', strtotime($request->input('fecha_limite')))
                : null;
            $data['criterios_evaluacion'] = $request->input('criterios_evaluacion');
        }
        // Para archivo se sube aparte, la clase se crea primero sin archivo

        $id = Clase::create($data);

        // Si el tipo es archivo y se ha subido uno, lo guardamos y vinculamos
        if ($tipo === 'archivo' && !empty($_FILES['archivo']['tmp_name'])) {
            $uploadDir = __DIR__ . '/../../storage/uploads/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            $nombreGuardado = uniqid() . '_' . basename($_FILES['archivo']['name']);
            move_uploaded_file($_FILES['archivo']['tmp_name'], $uploadDir . $nombreGuardado);

            $archivoId = \App\Models\Archivo::create([
                'nombre_original' => $_FILES['archivo']['name'],
                'nombre_guardado' => $nombreGuardado,
                'tipo_mime'       => mime_content_type($uploadDir . $nombreGuardado),
                'tamano'          => filesize($uploadDir . $nombreGuardado),
                'usuario_id'      => $_SESSION['usuario']['id'],
            ]);

            Clase::update($id, ['archivo_id' => $archivoId]);
        }

        $_SESSION['mensaje'] = 'Clase creada correctamente.';
        header('Location: /instructor/cursos/' . $cursoId . '/clases');
        exit;
    }

    // Editar clases
    public function edit(Request $request): void
    {
        $this->verificarInstructor();
        $id = (int) $request->param('id');
        $clase = Clase::find($id);
        if (!$clase) {
            http_response_code(404);
            echo "Clsae no encontrada.";
            exit;
        }
        $curso = Curso::find($clase['curso_id']);
        if ($curso['id_instructor'] != $_SESSION['usuario']['id']) {
            http_response_code(403);
            echo "No autorizado.";
            exit;
        }
        View::render('instructor/clases/formClase', [
            'title' => 'Editar clase',
            'accion' => 'Actualizar',
            'clase' => $clase,
            'curso' => $curso['id'],
        ]);
    }

    // Actualizar la clase editada
    public function update(Request $request): void
{
    $this->verificarInstructor();
    $id = (int) $request->param('id');
    $clase = Clase::find($id);
    if (!$clase) {
        http_response_code(404);
        exit;
    }
    $curso = Curso::find($clase['curso_id']);
    if ($curso['id_instructor'] != $_SESSION['usuario']['id']) {
        http_response_code(403);
        exit;
    }

    $data = [
        'titulo'   => $request->input('titulo'),
        'duracion' => $request->input('duracion'),
        'tipo'     => $request->input('tipo'),
    ];

    if (!empty($request->input('fecha_limite'))) {
        $data['fecha_limite'] = date('Y-m-d H:i:s', strtotime($request->input('fecha_limite')));
    } else {
        $data['fecha_limite'] = null;
    }

    $tipo = $data['tipo'];
    if ($tipo === 'teoria') {
        $data['contenido_texto'] = $request->input('contenido_texto');
        $data['archivo_id'] = null;
    } elseif ($tipo === 'archivo') {
        // Si se subió un archivo nuevo, se procesa; si no, se conserva el existente
        if (!empty($_FILES['archivo']['tmp_name'])) {
            // Subir archivo nuevo
            $archivoController = new \App\Controllers\ArchivoController();
            // Simular la subida del archivo
            $uploadDir = __DIR__ . '/../../storage/uploads/';
            if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
            $nombreGuardado = uniqid() . '_' . basename($_FILES['archivo']['name']);
            move_uploaded_file($_FILES['archivo']['tmp_name'], $uploadDir . $nombreGuardado);
            $archivoId = \App\Models\Archivo::create([
                'nombre_original' => $_FILES['archivo']['name'],
                'nombre_guardado' => $nombreGuardado,
                'tipo_mime' => mime_content_type($uploadDir . $nombreGuardado),
                'tamano' => filesize($uploadDir . $nombreGuardado),
                'usuario_id' => $_SESSION['usuario']['id'],
            ]);
            $data['archivo_id'] = $archivoId;
        } // si no, se mantiene el archivo actual
        $data['contenido_texto'] = null;
    } elseif ($tipo === 'tarea') {
        $data['fecha_limite'] = $request->input('fecha_limite');
        $data['criterios_evaluacion'] = $request->input('criterios_evaluacion');
        $data['archivo_id'] = null;
        $data['contenido_texto'] = null;
    }

    Clase::update($id, $data);
    $_SESSION['mensaje'] = 'Clase actualizada.';
    header('Location: /instructor/cursos/' . $curso['id'] . '/clases');
    exit;
}

    // Borrar clase
    public function delete(Request $request): void
    {
        $this->verificarInstructor();
        $claseId = (int) $request->param('id');
        $clase = Clase::find($claseId);
        if ($clase) {
            $curso = Curso::find($clase['curso_id']);
            if ($curso['id_instructor'] == $_SESSION['usuario']['id']) {
                Clase::delete($claseId);
            }
        }
        header('Location: /instructor/cursos/' . $clase['curso_id'] . '/clases');
        exit;
    }

    public function verEntregas(Request $request): void
    {
        $this->verificarInstructor();
        $claseId = (int) $request->param('id');
        $clase = Clase::find($claseId);
        if (!$clase) {
            http_response_code(404);
            echo "Clase no encontrada.";
            exit;
        }
        // Verificar que el curso pertenece al instructor
        $curso = Curso::find($clase['curso_id']);
        if ($curso['id_instructor'] != $_SESSION['usuario']['id']) {
            http_response_code(403);
            echo "No autorizado.";
            exit;
        }

        $entregas = Tarea::todasEntregas($claseId); // método ya definido en el modelo

        View::render('instructor/clases/entregas', [
            'title' => 'Entregas de ' . $clase['titulo'],
            'clase' => $clase,
            'entregas' => $entregas,
        ]);
    }

    public function calificarEntrega(Request $request): void
    {
        $this->verificarInstructor();
        $entregaId = (int) $request->input('entrega_id');
        $nota = $request->input('nota');
        $feedback = $request->input('feedback', '');

        $entrega = Tarea::find($entregaId);
        if (!$entrega) {
            http_response_code(404);
            exit;
        }
        // Verificar que la tarea pertenece a un curso del instructor
        $clase = Clase::find($entrega['clase_id']);
        $curso = Curso::find($clase['curso_id']);
        if ($curso['id_instructor'] != $_SESSION['usuario']['id']) {
            http_response_code(403);
            exit;
        }

        Tarea::update($entregaId, [
            'nota' => $nota,
            'feedback_instructor' => $feedback,
        ]);

        $_SESSION['mensaje'] = 'Entrega calificada.';
        header('Location: /instructor/clases/' . $entrega['clase_id'] . '/entregas');
        exit;
    }

    public function actualizarNota(Request $request): void
    {
        $this->verificarInstructor();
        $entregaId = (int) $request->input('entrega_id');
        $nota = $request->input('nota');
        $feedback = $request->input('feedback', '');

        $entrega = Tarea::find($entregaId);
        if (!$entrega) {
            http_response_code(404);
            exit;
        }

        // Verificar que la tarea pertenece al instructor
        $clase = Clase::find($entrega['clase_id']);
        $curso = Curso::find($clase['curso_id']);
        if ($curso['id_instructor'] != $_SESSION['usuario']['id']) {
            http_response_code(403);
            exit;
        }

        Tarea::update($entregaId, [
            'nota' => $nota,
            'feedback_instructor' => $feedback,
        ]);

        $_SESSION['mensaje'] = 'Nota y feedback actualizados.';
        header('Location: /instructor/clases/' . $entrega['clase_id'] . '/entregas');
        exit;
    }

    public function verClase(Request $request): void
    {
        $this->verificarInstructor();
        $claseId = (int) $request->param('id');
        $clase = Clase::find($claseId);
        if (!$clase) {
            http_response_code(404);
            echo "Clase no encontrada.";
            exit;
        }
        $curso = Curso::find($clase['curso_id']);
        if ($curso['id_instructor'] != $_SESSION['usuario']['id']) {
            http_response_code(403);
            echo "No autorizado.";
            exit;
        }

        View::render('instructor/clases/ver', [
            'title' => $clase['titulo'],
            'clase' => $clase,
        ]);
    }
}