SET NAMES utf8;
SET FOREIGN_KEY_CHECKS=0;

CREATE TABLE IF NOT EXISTS `users` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(75),
  `email` VARCHAR(125),
  `password` VARCHAR(255),
  `first_name` VARCHAR(255),
  `last_name` VARCHAR(255),
  `genero` ENUM('masculino', 'femenino','no definido'),
  `fecha_nacimiento` DATE,
  `telefono` VARCHAR(75),
  `estado` BOOL,
  `newsletter` BOOL,
  `permissions` TEXT,
  `activated` TINYINT(1),
  `activation_code` VARCHAR(255),
  `activated_at` TIMESTAMP,
  `last_login` TIMESTAMP,
  `persist_code` VARCHAR(255),
  `reset_password_code` VARCHAR(255),
  `created_at` DATETIME,
  `updated_at` DATETIME,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `groups` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255),
  `permissions` TEXT,
  `created_at` TIMESTAMP,
  `updated_at` TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `throttle` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `user_id` INT,
  `ip_address` VARCHAR(255),
  `attempts` INT,
  `suspended` BOOL,
  `banned` BOOL,
  `last_attempt_at` TIMESTAMP,
  `suspended_at` TIMESTAMP,
  `banned_at` TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `users_groups` (
  `user_id` INT,
  `group_id` INT
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `agentes` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `maquina` VARCHAR(45),
  `agente` VARCHAR(45),
  `tipo` ENUM('agencia','subagencia','vendedor') DEFAULT 'vendedor',
  `telefono` VARCHAR(45),
  `created_at` DATETIME,
  `updated_at` DATETIME,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `rendicions` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `agentes_id` INT NOT NULL,
  `sorteo` NUMERIC,
  `maquina` VARCHAR(45),
  `quiniela` DECIMAL(8,2) DEFAULT 0,
  `quiniela_agencia` DECIMAL(8,2) DEFAULT 0,
  `quiniela_agente` DECIMAL(8,2) DEFAULT 0,
  `quiniela_pagar` DECIMAL(8,2) DEFAULT 0,
  `quiniexpress` DECIMAL(8,2) DEFAULT 0,
  `quiniexpress_agencia` DECIMAL(8,2) DEFAULT 0,
  `quiniexpress_agente` DECIMAL(8,2) DEFAULT 0,
  `quiniexpress_pagar` DECIMAL(8,2) DEFAULT 0,
  `juegos` DECIMAL(8,2) DEFAULT 0,
  `juegos_agencia` DECIMAL(8,2) DEFAULT 0,
  `juegos_agente` DECIMAL(8,2) DEFAULT 0,
  `juegos_pagar` DECIMAL(8,2) DEFAULT 0,
  `total_maquina` DECIMAL(8,2) DEFAULT 0,
  `total_pagar` DECIMAL(8,2) DEFAULT 0,
  `premios` DECIMAL(8,2) DEFAULT 0,
  `neto_pagar` DECIMAL(8,2) DEFAULT 0,
  `pagado` DECIMAL(8,2) DEFAULT 0,
  `deuda` DECIMAL(8,2) DEFAULT 0,
  `created_at` DATETIME,
  `updated_at` DATETIME,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `juegos` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `agentes_id` INT NOT NULL,
  `cartons_id` INT NOT NULL,
  `sorteo` INT,
  `valor_juego` DECIMAL(10,2),
  `entregados` INT,
  `devolucion` INT,
  `vendidos` INT,
  `neto` DECIMAL(10,2) DEFAULT 0,
  `agencia` DECIMAL(10,2) DEFAULT 0,
  `agente` DECIMAL(10,2),
  `a_pagar` DECIMAL(10,2),
  `pagado` DECIMAL(10,2),
  `deuda` DECIMAL(10,2),
  `created_at` DATETIME,
  `updated_at` DATETIME,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `clientes` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `cliente` VARCHAR(125),
  `created_at` DATETIME,
  `updated_at` DATETIME,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `movimientos` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `clientes_id` INT NOT NULL,
  `descripcion` VARCHAR(125),
  `tipo` ENUM('debe','haber'),
  `importe` DECIMAL(10,2),
  `created_at` DATETIME,
  `updated_at` DATETIME,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `diarios` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `cuentas_id` INT NOT NULL,
  `tipo` ENUM('debe','haber'),
  `descripcion` VARCHAR(125),
  `importe` DECIMAL(10,2),
  `created_at` DATETIME,
  `updated_at` DATETIME,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `cuentas` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `cuenta` VARCHAR(125),
  `tipo` ENUM('debe','haber'),
  `repite` INT DEFAULT 0,
  `created_at` DATETIME,
  `updated_at` DATETIME,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `cartons` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `carton` VARCHAR(45),
  `created_at` DATETIME,
  `updated_at` DATETIME,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

SET FOREIGN_KEY_CHECKS=1;
