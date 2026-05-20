<?php

namespace App\Controllers;

use App\Core\Request;
use App\Core\View;
use App\Models\Curso;

class InstructorController
{
    // Verificar si el usuario es instructor.
    private function verificarInstructor(): void
    {
        if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] !== "instructor") {
            header('Location: /login');
            exit;
        }
    }

    // Cursos del instructor.
    public function index(Request $request): void
    {
        $this->verificarInstructor();

        $cursos = Curso::whereAll('id_instructor', (string) $_SESSION['usuario']['id']);
        View::render('instructor/index', [
            'title' => 'Panel de instructor',
            'cursos' => $cursos,
        ]);
    }

    // Crear nuevo curso.
    public function create(Request $request): void
    {
        $this->verificarInstructor();
        View::render('instructor/crear_curso', [
            'title' => 'Crear Curso',
            'accion' => 'Crear',
            'curso' => null,
        ]);
    }

    // Guarda el curso.
    public function store(Request $request): void
    {
        \App\Core\Csrf::verify();
        $this->verificarInstructor();
        $data = [
            'id_instructor' => $_SESSION['usuario']['id'],
            'titulo' => $request->input('titulo'),
            'descripcion' => $request->input('descripcion'),
            'precio' => $request->input('precio'),
            'modalidad' => $request->input('modalidad'),
            'estado' => 'borrador',
        ];

        if ($data['modalidad'] === 'presencial') {
            $data['fecha'] = $request->input('fecha') ?: null;
            $data['hora'] = $request->input('hora') ?: null;
            $data['ubicacion'] = $request->input('ubicacion') ?: null;
            $data['plazas'] = $request->input('plazas') ?: null;
        }

        Curso::create($data);
        $_SESSION['mensaje'] = 'Curso creado correctamente.';
        header('Location: /instructor');
        exit;
    }

    // Editar curso.
    public function edit(Request $request): void
    {
        $this->verificarInstructor();

        $id = (int) $request->param('id');
        $curso = Curso::find($id);

        if (!$curso || $curso['id_instructor'] != $_SESSION['usuario']['id']) {
            http_response_code(403);
            echo "No tienes permiso para editar este curso";
            exit;
        }

        View::render('instructor/crear_curso', [
            'title' => 'Editar Curso',
            'accion' => 'Actualizar',
            'curso' => $curso,
        ]);
    }

    // Actualizar curso editado.
    public function update(Request $request): void
    {
        \App\Core\Csrf::verify();
        $this->verificarInstructor();
        $id = (int) $request->param('id');
        $curso = Curso::find($id);
        $cursoActualizado = Curso::find($id);
        var_dump($cursoActualizado['estado']); exit;
        if (!$curso || $curso['id_instructor'] != $_SESSION['usuario']['id']) {
            http_response_code(403);
            exit;
        }

        $data = [
            'titulo'      => $request->input('titulo'),
            'descripcion' => $request->input('descripcion'),
            'precio'      => $request->input('precio'),
            'modalidad'   => $request->input('modalidad'),
        ];

        if ($data['modalidad'] === 'presencial') {
            $data['fecha']     = $request->input('fecha') ?: null;
            $data['hora']      = $request->input('hora') ?: null;
            $data['ubicacion'] = $request->input('ubicacion') ?: null;
            $data['plazas']    = $request->input('plazas') ?: null;
        }

        Curso::update($id, $data);
        $_SESSION['mensaje'] = 'Curso actualizado correctamente.';
        header('Location: /instructor');
        exit;
    }

    // Eliminar un curso.
    public function delete(Request $request): void
    {
        $this->verificarInstructor();

        $id = (int) $request->param('id');
        $curso = Curso::find($id);

        if ($curso && $curso['id_instructor'] == $_SESSION['usuario']['id']) {
            Curso::delete($id);
            $_SESSION['mensaje'] = 'Curso eliminado correctamente.';
        }

        header('Location: /instructor');
        exit;
    }

    // Mostrar asistentes si el curso es presencial.
    public function verAsistentes(Request $request): void
    {
        $this->verificarInstructor();
        $id = (int) $request->param('id');
        $curso = Curso::find($id);
        if (!$curso || $curso['id_instructor'] != $_SESSION['usuario']['id']) {
            http_response_code(403);
            exit;
        }

        // Obtener los alumnos que han comprado este curso
        $pdo = \App\Core\Database::getConnection();
        $stmt = $pdo->prepare("SELECT u.id, u.nombre, u.email, p.fecha 
                            FROM detalle_pedido dp
                            JOIN pedidos p ON dp.pedido_id = p.id
                            JOIN usuarios u ON p.usuario_id = u.id
                            WHERE dp.curso_id = :curso AND p.estado = 'completado'");
        $stmt->execute(['curso' => $id]);
        $asistentes = $stmt->fetchAll();

        View::render('instructor/asistentes', [
            'title'      => 'Asistentes de ' . $curso['titulo'],
            'curso'      => $curso,
            'asistentes' => $asistentes,
        ]);
    }

    // Enviar curso creado nuevo a revisión
    public function enviarRevision(Request $request): void
    {
        $this->verificarInstructor();
        $id = (int) $request->param('id');
        $curso = Curso::find($id);

        if (!$curso || $curso['id_instructor'] != $_SESSION['usuario']['id']) {
            http_response_code(403);
            echo "No autorizado.";
            exit;
        }

        if ($curso['estado'] !== 'borrador') {
            $_SESSION['mensaje'] = 'Solo los cursos en borrador pueden enviarse a revisión.';
            header('Location: /instructor');
            exit;
        }

        Curso::update($id, ['estado' => 'revision']);
        $_SESSION['mensaje'] = 'Curso enviado a revisión correctamente. Será evaluado por un administrador.';
        header('Location: /instructor');
        exit;
    }
}