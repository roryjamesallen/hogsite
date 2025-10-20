
-- Create databases
CREATE DATABASE IF NOT EXISTS `testdb` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE DATABASE IF NOT EXISTS `nothingeverhappens` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- ========== testdb ==========
USE `testdb`;

CREATE TABLE IF NOT EXISTS `artists` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `artist` VARCHAR(255) NOT NULL,
  `related` VARCHAR(255) DEFAULT NULL,
  `ip` VARCHAR(45) DEFAULT NULL,
  `time` INT UNSIGNED DEFAULT NULL,         -- code used integer timestamps
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  INDEX (`artist`),
  INDEX (`ip`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `issues` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `artist` VARCHAR(255) DEFAULT NULL,
  `type` VARCHAR(100) DEFAULT NULL,
  `info` TEXT,
  `ip` VARCHAR(45) DEFAULT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  INDEX (`artist`),
  INDEX (`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- ========== nothingeverhappens ==========
USE `nothingeverhappens`;

CREATE TABLE IF NOT EXISTS `users` (
  `user_id` CHAR(36) NOT NULL PRIMARY KEY,   -- UUID-friendly
  `username` VARCHAR(100) NOT NULL UNIQUE,
  `password` VARCHAR(255) NOT NULL,          -- hashed password
  `email` VARCHAR(255) DEFAULT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  INDEX (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `groups` (
  `group_id` CHAR(36) NOT NULL PRIMARY KEY,
  `name` VARCHAR(255) NOT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `group_users` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `group_id` CHAR(36) NOT NULL,
  `user_id` CHAR(36) NOT NULL,
  UNIQUE KEY `ux_group_user` (`group_id`,`user_id`),
  INDEX (`user_id`),
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `home_visits` (
  `visit_id` CHAR(36) NOT NULL PRIMARY KEY,
  `visitor_ip` VARCHAR(45) DEFAULT NULL,
  `visit_time` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` CHAR(36) DEFAULT NULL,
  INDEX (`visitor_ip`),
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
