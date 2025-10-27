
-- Create databases
CREATE DATABASE IF NOT EXISTS `testdb` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE DATABASE IF NOT EXISTS `wildhog_analytics` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- ========== testdb ==========
USE `testdb`;

CREATE TABLE IF NOT EXISTS `home_visits` (
  `visit_id` VARCHAR(16) NOT NULL,
  `visitor_ip` VARCHAR(64) NOT NULL,
  `visit_time` TIMESTAMP NOT NULL,
  INDEX (`visit_id`),
  INDEX (`visitor_ip`),
  INDEX (`visit_time`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
CREATE DATABASE IF NOT EXISTS `wildhog_nothingeverhappens` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `wildhog_nothingeverhappens`;

CREATE TABLE IF NOT EXISTS `users` (
  `user_id` VARCHAR(16) NOT NULL,
  `username` VARCHAR(32) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255) DEFAULT NULL,
  `created_at` TIMESTAMP NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `groups` (
  `group_id` VARCHAR(16) NOT NULL,
  `name` VARCHAR(32) NOT NULL,
  `created_at` TIMESTAMP NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `group_users` (
  `group_id` VARCHAR(16) NOT NULL,
  `user_id` VARCHAR(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `events` (
  `event_id` VARCHAR(16) NOT NULL,
  `group_id` VARCHAR(16) NOT NULL,
  `user_id` VARCHAR(16) NOT NULL,
  `question` VARCHAR(64) NOT NULL,
  `deadline` INT(11) NOT NULL,
  `cancelled` VARCHAR(1) NOT NULL,
  `option_id` VARCHAR(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `options` (
  `option_id` VARCHAR(16) NOT NULL,
  `event_id` VARCHAR(16) NOT NULL,
  `option_text` VARCHAR(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `user_calls` (
  `event_id` VARCHAR(16) NOT NULL,		
  `user_id` VARCHAR(16) NOT NULL,
  `option_id` VARCHAR(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE IF NOT EXISTS `home_visits` (
  `visit_id` CHAR(36) NOT NULL PRIMARY KEY,
  `visitor_ip` VARCHAR(45) DEFAULT NULL,
  `visit_time` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` CHAR(36) DEFAULT NULL,
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
