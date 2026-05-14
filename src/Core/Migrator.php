<?php
namespace App\Core;

class Migrator
{
    public static function run(): void
    {
        $pdo = Database::getConnection();

        // Tabla para archivos subidos
        $pdo->exec("CREATE TABLE IF NOT EXISTS `archivos` (
    `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
    `nombre_original` varchar(255) NOT NULL,
    `nombre_guardado` varchar(255) NOT NULL,
    `tipo_mime` varchar(100) DEFAULT NULL,
    `tamano` int(11) DEFAULT NULL,
    `usuario_id` bigint(20) UNSIGNED NOT NULL,
    `created_at` datetime DEFAULT current_timestamp(),
    `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
    PRIMARY KEY (`id`),
    KEY `archivos_usuario_id_foreign` (`usuario_id`),
    CONSTRAINT `archivos_usuario_id_foreign` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");

// Añadir updated_at si la tabla ya existía pero sin esa columna
try {
    $stmt = $pdo->query("SHOW COLUMNS FROM archivos LIKE 'updated_at'");
    if ($stmt->rowCount() == 0) {
        $pdo->exec("ALTER TABLE archivos ADD updated_at datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()");
    }
} catch (\PDOException $e) {
    // Si falla, mostramos un mensaje (no detenemos la aplicación)
    error_log("Error al añadir updated_at a archivos: " . $e->getMessage());
}

        // Asegurar que la tabla 'clases' tenga los timestamps
        $stmt = $pdo->query("SHOW COLUMNS FROM clases LIKE 'created_at'");
        if ($stmt->rowCount() == 0) {
            $pdo->exec("ALTER TABLE clases ADD created_at datetime DEFAULT current_timestamp()");
        }
        $stmt = $pdo->query("SHOW COLUMNS FROM clases LIKE 'updated_at'");
        if ($stmt->rowCount() == 0) {
            $pdo->exec("ALTER TABLE clases ADD updated_at datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()");
        }

        // Modificar la tabla 'clases' si no tiene los nuevos campos
        $stmt = $pdo->query("SHOW COLUMNS FROM clases LIKE 'tipo'");
        if ($stmt->rowCount() == 0) {
            $pdo->exec("ALTER TABLE clases ADD tipo ENUM('teoria','archivo','tarea') NOT NULL DEFAULT 'teoria' AFTER `orden`");
        }
        $stmt = $pdo->query("SHOW COLUMNS FROM clases LIKE 'contenido_texto'");
        if ($stmt->rowCount() == 0) {
            $pdo->exec("ALTER TABLE clases ADD contenido_texto TEXT DEFAULT NULL AFTER `tipo`");
        }
        $stmt = $pdo->query("SHOW COLUMNS FROM clases LIKE 'archivo_id'");
        if ($stmt->rowCount() == 0) {
            $pdo->exec("ALTER TABLE clases ADD archivo_id bigint(20) UNSIGNED DEFAULT NULL AFTER `contenido_texto`");
            $pdo->exec("ALTER TABLE clases ADD CONSTRAINT fk_clases_archivo FOREIGN KEY (archivo_id) REFERENCES archivos(id) ON DELETE SET NULL");
        }
        $stmt = $pdo->query("SHOW COLUMNS FROM clases LIKE 'fecha_limite'");
        if ($stmt->rowCount() == 0) {
            $pdo->exec("ALTER TABLE clases ADD fecha_limite datetime DEFAULT NULL AFTER `archivo_id`");
        }
        $stmt = $pdo->query("SHOW COLUMNS FROM clases LIKE 'criterios_evaluacion'");
        if ($stmt->rowCount() == 0) {
            $pdo->exec("ALTER TABLE clases ADD criterios_evaluacion TEXT DEFAULT NULL AFTER `fecha_limite`");
        }

        // Tabla para entregas de tareas de alumnos
        $pdo->exec("CREATE TABLE IF NOT EXISTS `entregas_tareas` (
            `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
            `clase_id` bigint(20) UNSIGNED NOT NULL,
            `alumno_id` bigint(20) UNSIGNED NOT NULL,
            `archivo_id` bigint(20) UNSIGNED DEFAULT NULL COMMENT 'Archivo subido por el alumno',
            `comentario_alumno` text DEFAULT NULL,
            `nota` decimal(4,2) DEFAULT NULL,
            `feedback_instructor` text DEFAULT NULL,
            `fecha_entrega` datetime DEFAULT current_timestamp(),
            `created_at` datetime DEFAULT current_timestamp(),
            `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
            PRIMARY KEY (`id`),
            KEY `entregas_clase_id_foreign` (`clase_id`),
            KEY `entregas_alumno_id_foreign` (`alumno_id`),
            KEY `entregas_archivo_id_foreign` (`archivo_id`),
            CONSTRAINT `entregas_clase_id_foreign` FOREIGN KEY (`clase_id`) REFERENCES `clases` (`id`) ON DELETE CASCADE,
            CONSTRAINT `entregas_alumno_id_foreign` FOREIGN KEY (`alumno_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE,
            CONSTRAINT `entregas_archivo_id_foreign` FOREIGN KEY (`archivo_id`) REFERENCES `archivos` (`id`) ON DELETE SET NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
    }
}