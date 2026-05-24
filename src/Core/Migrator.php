<?php
namespace App\Core;

class Migrator
{
    public static function run(): void
    {
        // Comprobación para migrar solo 1 vez
        if (file_exists(__DIR__ . '/../../storage/migrated.lock')) {
            return;
        }

        $pdo = Database::getConnection();

        // ==================== TABLAS PRINCIPALES ====================

        // 1. Usuarios
        $pdo->exec("CREATE TABLE IF NOT EXISTS `usuarios` (
            `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
            `nombre` varchar(255) NOT NULL,
            `email` varchar(255) NOT NULL,
            `password` varchar(255) NOT NULL,
            `rol` enum('alumno','instructor','admin') NOT NULL DEFAULT 'alumno',
            `reputacion` double(8,2) NOT NULL DEFAULT 0.00,
            `created_at` timestamp NULL DEFAULT current_timestamp(),
            `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
            PRIMARY KEY (`id`),
            UNIQUE KEY `usuarios_email_unique` (`email`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");

        // 2. Cursos
        $pdo->exec("CREATE TABLE IF NOT EXISTS `cursos` (
            `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
            `id_instructor` bigint(20) UNSIGNED NOT NULL,
            `titulo` varchar(255) NOT NULL,
            `descripcion` text NOT NULL,
            `precio` decimal(8,2) NOT NULL,
            `modalidad` enum('online','presencial') NOT NULL,
            `fecha` DATE DEFAULT NULL,
            `hora` TIME DEFAULT NULL,
            `ubicacion` VARCHAR(255) DEFAULT NULL,
            `plazas` INT(11) DEFAULT NULL,
            `estado` enum('borrador','revision','publicado','rechazado') NOT NULL DEFAULT 'borrador',
            `motivo_rechazo` TEXT DEFAULT NULL,
            `created_at` timestamp NULL DEFAULT current_timestamp(),
            `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
            `deleted_at` timestamp NULL DEFAULT NULL,
            PRIMARY KEY (`id`),
            KEY `cursos_id_instructor_foreign` (`id_instructor`),
            CONSTRAINT `cursos_id_instructor_foreign` FOREIGN KEY (`id_instructor`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");

        // 3. Clases (sin fecha_limite)
        $pdo->exec("CREATE TABLE IF NOT EXISTS `clases` (
            `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
            `curso_id` bigint(20) UNSIGNED NOT NULL,
            `titulo` varchar(255) NOT NULL,
            `duracion` int(11) NOT NULL DEFAULT 0,
            `contenido` text DEFAULT NULL,
            `orden` int(11) NOT NULL DEFAULT 0,
            `tipo` enum('teoria','archivo','tarea') NOT NULL DEFAULT 'teoria',
            `contenido_texto` text DEFAULT NULL,
            `archivo_id` bigint(20) UNSIGNED DEFAULT NULL,
            `criterios_evaluacion` text DEFAULT NULL,
            `created_at` timestamp NULL DEFAULT current_timestamp(),
            `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
            PRIMARY KEY (`id`),
            KEY `clases_curso_id_foreign` (`curso_id`),
            KEY `clases_archivo_id_foreign` (`archivo_id`),
            CONSTRAINT `clases_curso_id_foreign` FOREIGN KEY (`curso_id`) REFERENCES `cursos` (`id`) ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");

        // 4. Carritos
        $pdo->exec("CREATE TABLE IF NOT EXISTS `carritos` (
            `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
            `usuario_id` bigint(20) UNSIGNED NOT NULL,
            `total` decimal(10,2) NOT NULL DEFAULT 0.00,
            `created_at` timestamp NULL DEFAULT current_timestamp(),
            `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
            PRIMARY KEY (`id`),
            KEY `carritos_usuario_id_foreign` (`usuario_id`),
            CONSTRAINT `carritos_usuario_id_foreign` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");

        // 5. Carrito items
        $pdo->exec("CREATE TABLE IF NOT EXISTS `carrito_items` (
            `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
            `carrito_id` bigint(20) UNSIGNED NOT NULL,
            `curso_id` bigint(20) UNSIGNED NOT NULL,
            `cantidad` int(11) NOT NULL DEFAULT 1,
            `precio_unitario` decimal(8,2) NOT NULL,
            `created_at` timestamp NULL DEFAULT current_timestamp(),
            `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
            PRIMARY KEY (`id`),
            KEY `carrito_items_carrito_id_foreign` (`carrito_id`),
            KEY `carrito_items_curso_id_foreign` (`curso_id`),
            CONSTRAINT `carrito_items_carrito_id_foreign` FOREIGN KEY (`carrito_id`) REFERENCES `carritos` (`id`) ON DELETE CASCADE,
            CONSTRAINT `carrito_items_curso_id_foreign` FOREIGN KEY (`curso_id`) REFERENCES `cursos` (`id`) ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");

        // 6. Pedidos
        $pdo->exec("CREATE TABLE IF NOT EXISTS `pedidos` (
            `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
            `usuario_id` bigint(20) UNSIGNED NOT NULL,
            `fecha` datetime NOT NULL DEFAULT current_timestamp(),
            `total` decimal(10,2) NOT NULL,
            `estado` varchar(50) NOT NULL DEFAULT 'pendiente',
            `created_at` timestamp NULL DEFAULT current_timestamp(),
            `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
            PRIMARY KEY (`id`),
            KEY `pedidos_usuario_id_foreign` (`usuario_id`),
            CONSTRAINT `pedidos_usuario_id_foreign` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");

        // 7. Detalle pedido
        $pdo->exec("CREATE TABLE IF NOT EXISTS `detalle_pedido` (
            `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
            `pedido_id` bigint(20) UNSIGNED NOT NULL,
            `curso_id` bigint(20) UNSIGNED NOT NULL,
            `precio` decimal(8,2) NOT NULL,
            `cantidad` int(11) NOT NULL,
            `created_at` timestamp NULL DEFAULT current_timestamp(),
            `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
            PRIMARY KEY (`id`),
            KEY `detalle_pedido_pedido_id_foreign` (`pedido_id`),
            KEY `detalle_pedido_curso_id_foreign` (`curso_id`),
            CONSTRAINT `detalle_pedido_pedido_id_foreign` FOREIGN KEY (`pedido_id`) REFERENCES `pedidos` (`id`) ON DELETE CASCADE,
            CONSTRAINT `detalle_pedido_curso_id_foreign` FOREIGN KEY (`curso_id`) REFERENCES `cursos` (`id`) ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");

        // 8. Reseñas
        $pdo->exec("CREATE TABLE IF NOT EXISTS `resenas` (
            `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
            `usuario_id` bigint(20) UNSIGNED NOT NULL,
            `curso_id` bigint(20) UNSIGNED NOT NULL,
            `puntuacion` tinyint(3) UNSIGNED NOT NULL CHECK (`puntuacion` between 1 and 5),
            `comentario` text DEFAULT NULL,
            `fecha` datetime DEFAULT current_timestamp(),
            `created_at` timestamp NULL DEFAULT current_timestamp(),
            `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
            PRIMARY KEY (`id`),
            UNIQUE KEY `resenas_usuario_id_curso_id_unique` (`usuario_id`,`curso_id`),
            KEY `resenas_curso_id_foreign` (`curso_id`),
            CONSTRAINT `resenas_usuario_id_foreign` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE,
            CONSTRAINT `resenas_curso_id_foreign` FOREIGN KEY (`curso_id`) REFERENCES `cursos` (`id`) ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");

        // 9. Archivos
        $pdo->exec("CREATE TABLE IF NOT EXISTS `archivos` (
            `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
            `nombre_original` varchar(255) NOT NULL,
            `nombre_guardado` varchar(255) NOT NULL,
            `tipo_mime` varchar(100) DEFAULT NULL,
            `tamano` int(11) DEFAULT NULL,
            `usuario_id` bigint(20) UNSIGNED NOT NULL,
            `created_at` timestamp NULL DEFAULT current_timestamp(),
            `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
            PRIMARY KEY (`id`),
            KEY `archivos_usuario_id_foreign` (`usuario_id`),
            CONSTRAINT `archivos_usuario_id_foreign` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");

        // 10. Entregas tareas
        $pdo->exec("CREATE TABLE IF NOT EXISTS `entregas_tareas` (
            `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
            `clase_id` bigint(20) UNSIGNED NOT NULL,
            `alumno_id` bigint(20) UNSIGNED NOT NULL,
            `archivo_id` bigint(20) UNSIGNED DEFAULT NULL,
            `comentario_alumno` text DEFAULT NULL,
            `nota` decimal(4,2) DEFAULT NULL,
            `feedback_instructor` text DEFAULT NULL,
            `fecha_entrega` datetime DEFAULT current_timestamp(),
            `created_at` timestamp NULL DEFAULT current_timestamp(),
            `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
            PRIMARY KEY (`id`),
            KEY `entregas_clase_id_foreign` (`clase_id`),
            KEY `entregas_alumno_id_foreign` (`alumno_id`),
            KEY `entregas_archivo_id_foreign` (`archivo_id`),
            CONSTRAINT `entregas_clase_id_foreign` FOREIGN KEY (`clase_id`) REFERENCES `clases` (`id`) ON DELETE CASCADE,
            CONSTRAINT `entregas_alumno_id_foreign` FOREIGN KEY (`alumno_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE,
            CONSTRAINT `entregas_archivo_id_foreign` FOREIGN KEY (`archivo_id`) REFERENCES `archivos` (`id`) ON DELETE SET NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");

        // ==================== COLUMNAS NUEVAS EN TABLAS YA EXISTENTES ====================

        // Campos para cursos presenciales (si no existen)
        $camposPresenciales = [
            'fecha'       => "DATE DEFAULT NULL AFTER `modalidad`",
            'hora'        => "TIME DEFAULT NULL AFTER `fecha`",
            'ubicacion'   => "VARCHAR(255) DEFAULT NULL AFTER `hora`",
            'plazas'      => "INT(11) DEFAULT NULL AFTER `ubicacion`",
        ];
        foreach ($camposPresenciales as $campo => $definicion) {
            $stmt = $pdo->query("SHOW COLUMNS FROM cursos LIKE '$campo'");
            if ($stmt->rowCount() == 0) {
                $pdo->exec("ALTER TABLE cursos ADD COLUMN $campo $definicion");
            }
        }

        // Estado del curso y motivo de rechazo
        $stmt = $pdo->query("SHOW COLUMNS FROM cursos LIKE 'estado'");
        if ($stmt->rowCount() == 0) {
            $pdo->exec("ALTER TABLE cursos ADD estado enum('borrador','revision','publicado','rechazado') NOT NULL DEFAULT 'borrador' AFTER `plazas`");
            $pdo->exec("UPDATE cursos SET estado = 'borrador' WHERE estado IS NULL OR estado = ''");
        }

        $stmt = $pdo->query("SHOW COLUMNS FROM cursos LIKE 'motivo_rechazo'");
        if ($stmt->rowCount() == 0) {
            $pdo->exec("ALTER TABLE cursos ADD motivo_rechazo TEXT DEFAULT NULL AFTER `estado`");
        }

        // Campos adicionales en clases
        $nuevosCamposClases = [
            'tipo'                  => "ENUM('teoria','archivo','tarea') NOT NULL DEFAULT 'teoria' AFTER `orden`",
            'contenido_texto'       => "TEXT DEFAULT NULL AFTER `tipo`",
            'archivo_id'            => "bigint(20) UNSIGNED DEFAULT NULL AFTER `contenido_texto`",
            'criterios_evaluacion'  => "TEXT DEFAULT NULL AFTER `archivo_id`",
            'created_at'            => "timestamp NULL DEFAULT current_timestamp()",
            'updated_at'            => "timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()"
        ];
        foreach ($nuevosCamposClases as $campo => $definicion) {
            $stmt = $pdo->query("SHOW COLUMNS FROM clases LIKE '$campo'");
            if ($stmt->rowCount() == 0) {
                $pdo->exec("ALTER TABLE clases ADD $campo $definicion");
            }
        }

        // Crear admin por defecto
        $stmt = $pdo->query("SELECT COUNT(*) FROM usuarios WHERE rol = 'admin'");
        if ((int) $stmt->fetchColumn() === 0) {
            $pdo->exec("INSERT INTO usuarios (nombre, email, password, rol, reputacion) VALUES ('Administrador', 'admin@skillup.com', '" . password_hash('admin123', PASSWORD_DEFAULT) . "', 'admin', 0)");
        }

        // Crear archivo para comprobación de migrator
        file_put_contents(__DIR__ . '/../../storage/migrated.lock', date('Y-m-d H:i:s'));
    }
}