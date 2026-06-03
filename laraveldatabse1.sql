-- ============================================================
-- SportsRent — Esquema Mejorado
-- Basado en Base-datos-0(1).sql con refactorizaciones
-- estructurales. Sin datos, solo DDL.
-- ============================================================

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";
SET NAMES utf8mb4;

-- ============================================================
-- CAMBIO 1: persona — sin modificaciones (estaba bien)
-- ============================================================
CREATE TABLE `persona` (
  `cedula_persona`   VARCHAR(20)  NOT NULL,
  `primer_nombre`    VARCHAR(50)  NOT NULL,
  `segundo_nombre`   VARCHAR(50)  DEFAULT NULL,
  `primer_apellido`  VARCHAR(50)  NOT NULL,
  `segundo_apellido` VARCHAR(50)  NOT NULL,
  `correo`           VARCHAR(100) NOT NULL,
  `direccion`        VARCHAR(100) NOT NULL,
  `telefono`         VARCHAR(20)  NOT NULL,
  PRIMARY KEY (`cedula_persona`),
  UNIQUE KEY `uq_persona_correo` (`correo`)   -- agregado: correos únicos
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- ============================================================
-- CAMBIO 2: credencial fusionada dentro de usuario
--   - Se elimina la tabla `credencial` por separado
--   - usuario ahora tiene usuario_login + contrasena directamente
--   - El correo de persona puede usarse como login alternativo
-- ============================================================
CREATE TABLE `usuario` (
  `cedula_persona`  VARCHAR(20)  NOT NULL,
  `usuario_login`   VARCHAR(100) NOT NULL,              -- antes: credencial.usuario
  `contrasena`      VARCHAR(255) NOT NULL,              -- antes: credencial.contrasena
  `estado`          ENUM('activo','inactivo','bloqueado') NOT NULL DEFAULT 'activo',
  `remember_token`  VARCHAR(100) DEFAULT NULL,          -- necesario para auth de Laravel
  `created_at`      TIMESTAMP    NULL DEFAULT NULL,
  `updated_at`      TIMESTAMP    NULL DEFAULT NULL,
  PRIMARY KEY (`cedula_persona`),
  UNIQUE KEY `uq_usuario_login` (`usuario_login`),
  CONSTRAINT `fk_usuario_persona`
    FOREIGN KEY (`cedula_persona`) REFERENCES `persona` (`cedula_persona`)
    ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- ============================================================
-- CAMBIO 3: proveedor — igual pero apunta al nuevo usuario
-- ============================================================
CREATE TABLE `proveedor` (
  `cedula_propietario` VARCHAR(20)  NOT NULL,
  `usuario_login`      VARCHAR(100) NOT NULL,
  `contrasena`         VARCHAR(255) NOT NULL,
  `tipo_documento`     VARCHAR(100) NOT NULL,
  `remember_token`     VARCHAR(100) DEFAULT NULL,
  `created_at`         TIMESTAMP    NULL DEFAULT NULL,
  `updated_at`         TIMESTAMP    NULL DEFAULT NULL,
  PRIMARY KEY (`cedula_propietario`),
  UNIQUE KEY `uq_proveedor_login` (`usuario_login`),
  CONSTRAINT `fk_proveedor_persona`
    FOREIGN KEY (`cedula_propietario`) REFERENCES `persona` (`cedula_persona`)
    ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- ============================================================
-- CAMBIO 4: cancha
--   - id_cancha pasa a BIGINT AUTO_INCREMENT
--   - hora_apertura / hora_cierre pasan a TIME
--   - valor_hora pasa a DECIMAL(10,2)
--   - foto pasa a VARCHAR(500) para URL/ruta del archivo
-- ============================================================
CREATE TABLE `cancha` (
  `id_cancha`        BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre_cancha`    VARCHAR(100)    NOT NULL,
  `tipo_cancha`      VARCHAR(100)    NOT NULL,
  `descripcion`      TEXT            NOT NULL,
  `valor_hora`       DECIMAL(10,2)   NOT NULL,          -- antes: INT
  `hora_apertura`    TIME            NOT NULL,           -- antes: VARCHAR(15)
  `hora_cierre`      TIME            NOT NULL,           -- antes: VARCHAR(15)
  `estado`           ENUM('disponible','no_disponible','mantenimiento') NOT NULL DEFAULT 'disponible',
  `foto`             VARCHAR(500)    DEFAULT NULL,       -- antes: MEDIUMBLOB
  `direccion_cancha` VARCHAR(240)    DEFAULT NULL,
  `created_at`       TIMESTAMP       NULL DEFAULT NULL,
  `updated_at`       TIMESTAMP       NULL DEFAULT NULL,
  PRIMARY KEY (`id_cancha`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- ============================================================
-- CAMBIO 5: tabla administra — ajuste de FK a nuevo tipo de id_cancha
-- ============================================================
CREATE TABLE `administra` (
  `id_admin`           VARCHAR(10)     NOT NULL,
  `cedula_propietario` VARCHAR(20)     NOT NULL,
  `id_cancha`          BIGINT UNSIGNED NOT NULL,
  PRIMARY KEY (`id_admin`),
  CONSTRAINT `fk_administra_proveedor`
    FOREIGN KEY (`cedula_propietario`) REFERENCES `proveedor` (`cedula_propietario`)
    ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_administra_cancha`
    FOREIGN KEY (`id_cancha`) REFERENCES `cancha` (`id_cancha`)
    ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- ============================================================
-- CAMBIO 6: reserva
--   - id_reserva pasa a BIGINT AUTO_INCREMENT
--   - hora_inicio / hora_final pasan a TIME
--   - estado pasa a ENUM
-- ============================================================
CREATE TABLE `reserva` (
  `id_reserva`     BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `fecha_reserva`  DATE            NOT NULL,
  `hora_inicio`    TIME            NOT NULL,             -- antes: VARCHAR(20)
  `hora_final`     TIME            NOT NULL,             -- antes: VARCHAR(20)
  `estado`         ENUM('pendiente','confirmada','cancelada','completada') NOT NULL DEFAULT 'pendiente',
  `cedula_persona` VARCHAR(20)     NOT NULL,
  `id_cancha`      BIGINT UNSIGNED NOT NULL,
  `created_at`     TIMESTAMP       NULL DEFAULT NULL,
  `updated_at`     TIMESTAMP       NULL DEFAULT NULL,
  PRIMARY KEY (`id_reserva`),
  KEY `idx_reserva_fecha` (`fecha_reserva`),             -- índice útil para disponibilidad
  KEY `idx_reserva_cancha_fecha` (`id_cancha`, `fecha_reserva`),
  CONSTRAINT `fk_reserva_usuario`
    FOREIGN KEY (`cedula_persona`) REFERENCES `usuario` (`cedula_persona`)
    ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_reserva_cancha`
    FOREIGN KEY (`id_cancha`) REFERENCES `cancha` (`id_cancha`)
    ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- ============================================================
-- CAMBIO 7: factura
--   - id_factura pasa a BIGINT AUTO_INCREMENT
--   - valor_aPagar pasa a DECIMAL(10,2)
--   - fecha_emision pasa a DATE (era VARCHAR — bug potencial)
--   - estado pasa a ENUM
-- ============================================================
CREATE TABLE `factura` (
  `id_factura`    BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `valor_aPagar`  DECIMAL(10,2)   NOT NULL,              -- antes: INT
  `fecha_emision` DATE            NOT NULL,              -- antes: VARCHAR(20)
  `fecha_pago`    DATE            DEFAULT NULL,
  `metodo_pago`   VARCHAR(50)     DEFAULT NULL,
  `estado`        ENUM('pendiente','pagada','anulada') NOT NULL DEFAULT 'pendiente',
  `id_reserva`    BIGINT UNSIGNED NOT NULL,
  `created_at`    TIMESTAMP       NULL DEFAULT NULL,
  `updated_at`    TIMESTAMP       NULL DEFAULT NULL,
  PRIMARY KEY (`id_factura`),
  UNIQUE KEY `uq_factura_reserva` (`id_reserva`),        -- 1 factura por reserva
  CONSTRAINT `fk_factura_reserva`
    FOREIGN KEY (`id_reserva`) REFERENCES `reserva` (`id_reserva`)
    ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- ============================================================
-- CAMBIO 8: calificacion
--   - id_calificacion pasa a BIGINT AUTO_INCREMENT
--   - Se elimina calfi_usuario y calif_cancha (redundantes)
--     El quién y el qué se derivan de reserva → usuario + cancha
--   - puntuacion pasa a TINYINT con CHECK constraint
-- ============================================================
CREATE TABLE `calificacion` (
  `id_calificacion`   BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_reserva`        BIGINT UNSIGNED NOT NULL,
  `puntuacion`        TINYINT UNSIGNED NOT NULL CHECK (`puntuacion` BETWEEN 1 AND 5),
  `comentario`        TEXT            DEFAULT NULL,      -- antes: NOT NULL (innecesario)
  `fecha`             DATE            NOT NULL,
  `created_at`        TIMESTAMP       NULL DEFAULT NULL,
  `updated_at`        TIMESTAMP       NULL DEFAULT NULL,
  PRIMARY KEY (`id_calificacion`),
  UNIQUE KEY `uq_calificacion_reserva` (`id_reserva`),   -- 1 calificación por reserva
  CONSTRAINT `fk_calificacion_reserva`
    FOREIGN KEY (`id_reserva`) REFERENCES `reserva` (`id_reserva`)
    ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- ============================================================
-- CAMBIO 9: recuperacion_cuenta — unificada (se elimina `recuperacion`)
--   Se añaden los campos que le faltaban: usado + expiracion
-- ============================================================
CREATE TABLE `recuperacion_cuenta` (
  `identificacion` VARCHAR(50)  NOT NULL,
  `codigo`         VARCHAR(10)  NOT NULL,
  `fecha`          DATETIME     NOT NULL,
  `expiracion`     DATETIME     NOT NULL,                -- antes: inexistente
  `usado`          TINYINT(1)   NOT NULL DEFAULT 0,      -- antes: inexistente
  PRIMARY KEY (`identificacion`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- ============================================================
-- Tabla de tokens Sanctum (creada por Laravel, incluida aquí
-- para tener el esquema completo en un solo archivo)
-- ============================================================
CREATE TABLE `personal_access_tokens` (
  `id`             BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `tokenable_type` VARCHAR(255)    NOT NULL,
  `tokenable_id`   BIGINT UNSIGNED NOT NULL,
  `name`           VARCHAR(255)    NOT NULL,
  `token`          VARCHAR(64)     NOT NULL,
  `abilities`      TEXT            DEFAULT NULL,
  `last_used_at`   TIMESTAMP       NULL DEFAULT NULL,
  `expires_at`     TIMESTAMP       NULL DEFAULT NULL,
  `created_at`     TIMESTAMP       NULL DEFAULT NULL,
  `updated_at`     TIMESTAMP       NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_token` (`token`),
  KEY `idx_tokenable` (`tokenable_type`, `tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

COMMIT;
