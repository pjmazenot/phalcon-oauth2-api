-- --------------------------------------------------------
-- Hôte :                        localhost
-- Version du serveur:           5.7.9 - MySQL Community Server (GPL)
-- SE du serveur:                Win64
-- HeidiSQL Version:             9.4.0.5125
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Export de la structure de la table oauth2. oauth2_access_token
CREATE TABLE IF NOT EXISTS `oauth2_access_token` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `oauth2_session_id` bigint(20) unsigned NOT NULL,
  `access_token` varchar(100) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `issued_at` datetime NOT NULL,
  `expire_at` datetime NOT NULL,
  `is_revoked` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `access_token` (`access_token`),
  KEY `fk_oauth2_access_token_oauth2_session_id` (`oauth2_session_id`),
  CONSTRAINT `fk_oauth2_access_token_oauth2_session_id` FOREIGN KEY (`oauth2_session_id`) REFERENCES `oauth2_session` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

-- Export de données de la table oauth2.oauth2_access_token : ~0 rows (environ)
/*!40000 ALTER TABLE `oauth2_access_token` DISABLE KEYS */;
/*!40000 ALTER TABLE `oauth2_access_token` ENABLE KEYS */;

-- Export de la structure de la table oauth2. oauth2_access_token_scope
CREATE TABLE IF NOT EXISTS `oauth2_access_token_scope` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `oauth2_access_token_id` bigint(20) unsigned NOT NULL,
  `oauth2_scope_id` smallint(5) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_oauth2_access_token_scope_oauth2_access_token_id` (`oauth2_access_token_id`),
  KEY `fk_oauth2_access_token_scope_oauth2_scope_id` (`oauth2_scope_id`),
  CONSTRAINT `fk_oauth2_access_token_scope_oauth2_access_token_id` FOREIGN KEY (`oauth2_access_token_id`) REFERENCES `oauth2_access_token` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_oauth2_access_token_scope_oauth2_scope_id` FOREIGN KEY (`oauth2_scope_id`) REFERENCES `oauth2_scope` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

-- Export de données de la table oauth2.oauth2_access_token_scope : ~0 rows (environ)
/*!40000 ALTER TABLE `oauth2_access_token_scope` DISABLE KEYS */;
/*!40000 ALTER TABLE `oauth2_access_token_scope` ENABLE KEYS */;

-- Export de la structure de la table oauth2. oauth2_auth_code
CREATE TABLE IF NOT EXISTS `oauth2_auth_code` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `oauth2_session_id` bigint(20) unsigned NOT NULL,
  `code` varchar(100) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `redirect_uri` varchar(255) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `expire_at` datetime NOT NULL,
  `issued_at` datetime NOT NULL,
  `is_revoked` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`),
  KEY `fk_oauth2_auth_code_oauth2_session_id` (`oauth2_session_id`),
  CONSTRAINT `fk_oauth2_auth_code_oauth2_session_id` FOREIGN KEY (`oauth2_session_id`) REFERENCES `oauth2_session` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

-- Export de données de la table oauth2.oauth2_auth_code : ~0 rows (environ)
/*!40000 ALTER TABLE `oauth2_auth_code` DISABLE KEYS */;
/*!40000 ALTER TABLE `oauth2_auth_code` ENABLE KEYS */;

-- Export de la structure de la table oauth2. oauth2_auth_code_scope
CREATE TABLE IF NOT EXISTS `oauth2_auth_code_scope` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `oauth2_auth_code` bigint(20) unsigned NOT NULL,
  `oauth2_scope` smallint(5) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_oauth2_auth_code_scope_oauth2_auth_code_id` (`oauth2_auth_code`),
  KEY `fk_oauth2_auth_code_scope_oauth2_scope_id` (`oauth2_scope`),
  CONSTRAINT `fk_oauth2_auth_code_scope_oauth2_auth_code_id` FOREIGN KEY (`oauth2_auth_code`) REFERENCES `oauth2_auth_code` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_oauth2_auth_code_scope_oauth2_scope_id` FOREIGN KEY (`oauth2_scope`) REFERENCES `oauth2_scope` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

-- Export de données de la table oauth2.oauth2_auth_code_scope : ~0 rows (environ)
/*!40000 ALTER TABLE `oauth2_auth_code_scope` DISABLE KEYS */;
/*!40000 ALTER TABLE `oauth2_auth_code_scope` ENABLE KEYS */;

-- Export de la structure de la table oauth2. oauth2_client
CREATE TABLE IF NOT EXISTS `oauth2_client` (
  `id` bigint(20) unsigned NOT NULL,
  `client_secret` varchar(100) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `must_validate_secret` tinyint(1) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `client_secret` (`client_secret`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

-- Export de données de la table oauth2.oauth2_client : ~0 rows (environ)
/*!40000 ALTER TABLE `oauth2_client` DISABLE KEYS */;
/*!40000 ALTER TABLE `oauth2_client` ENABLE KEYS */;

-- Export de la structure de la table oauth2. oauth2_client_endpoint
CREATE TABLE IF NOT EXISTS `oauth2_client_endpoint` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `oauth2_client_id` bigint(20) unsigned NOT NULL,
  `redirect_uri` varchar(255) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_oauth2_client_endpoint_oauth2_client_id` (`oauth2_client_id`),
  CONSTRAINT `fk_oauth2_client_endpoint_oauth2_client_id` FOREIGN KEY (`oauth2_client_id`) REFERENCES `oauth2_client` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

-- Export de données de la table oauth2.oauth2_client_endpoint : ~0 rows (environ)
/*!40000 ALTER TABLE `oauth2_client_endpoint` DISABLE KEYS */;
/*!40000 ALTER TABLE `oauth2_client_endpoint` ENABLE KEYS */;

-- Export de la structure de la table oauth2. oauth2_client_grant_type
CREATE TABLE IF NOT EXISTS `oauth2_client_grant_type` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `oauth2_client_id` bigint(20) unsigned NOT NULL,
  `oauth2_grant_type_id` smallint(5) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_oauth2_client_grant_type_oauth2_client_id` (`oauth2_client_id`),
  KEY `fk_oauth2_client_grant_type_oauth2_grant_type_id` (`oauth2_grant_type_id`),
  CONSTRAINT `fk_oauth2_client_grant_type_oauth2_client_id` FOREIGN KEY (`oauth2_client_id`) REFERENCES `oauth2_client` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_oauth2_client_grant_type_oauth2_grant_type_id` FOREIGN KEY (`oauth2_grant_type_id`) REFERENCES `oauth2_grant_type` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

-- Export de données de la table oauth2.oauth2_client_grant_type : ~0 rows (environ)
/*!40000 ALTER TABLE `oauth2_client_grant_type` DISABLE KEYS */;
/*!40000 ALTER TABLE `oauth2_client_grant_type` ENABLE KEYS */;

-- Export de la structure de la table oauth2. oauth2_client_scope
CREATE TABLE IF NOT EXISTS `oauth2_client_scope` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `oauth2_client_id` bigint(20) unsigned NOT NULL,
  `oauth2_scope_id` smallint(5) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_oauth2_client_scope_oauth2_client_id` (`oauth2_client_id`),
  KEY `fk_oauth2_client_scope_oauth2_scope_id` (`oauth2_scope_id`),
  CONSTRAINT `fk_oauth2_client_scope_oauth2_client_id` FOREIGN KEY (`oauth2_client_id`) REFERENCES `oauth2_client` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_oauth2_client_scope_oauth2_scope_id` FOREIGN KEY (`oauth2_scope_id`) REFERENCES `oauth2_scope` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

-- Export de données de la table oauth2.oauth2_client_scope : ~0 rows (environ)
/*!40000 ALTER TABLE `oauth2_client_scope` DISABLE KEYS */;
/*!40000 ALTER TABLE `oauth2_client_scope` ENABLE KEYS */;

-- Export de la structure de la table oauth2. oauth2_client_user
CREATE TABLE IF NOT EXISTS `oauth2_client_user` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `oauth2_client_id` bigint(20) unsigned NOT NULL,
  `oauth2_user_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_oauth2_client_user_oauth2_client_id` (`oauth2_client_id`),
  KEY `fk_oauth2_client_user_oauth2_user_id` (`oauth2_user_id`),
  CONSTRAINT `fk_oauth2_client_user_oauth2_client_id` FOREIGN KEY (`oauth2_client_id`) REFERENCES `oauth2_client` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_oauth2_client_user_oauth2_user_id` FOREIGN KEY (`oauth2_user_id`) REFERENCES `oauth2_user` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

-- Export de données de la table oauth2.oauth2_client_user : ~0 rows (environ)
/*!40000 ALTER TABLE `oauth2_client_user` DISABLE KEYS */;
/*!40000 ALTER TABLE `oauth2_client_user` ENABLE KEYS */;

-- Export de la structure de la table oauth2. oauth2_grant_type
CREATE TABLE IF NOT EXISTS `oauth2_grant_type` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `grant_type` varchar(20) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

-- Export de données de la table oauth2.oauth2_grant_type : ~0 rows (environ)
/*!40000 ALTER TABLE `oauth2_grant_type` DISABLE KEYS */;
/*!40000 ALTER TABLE `oauth2_grant_type` ENABLE KEYS */;

-- Export de la structure de la table oauth2. oauth2_refresh_token
CREATE TABLE IF NOT EXISTS `oauth2_refresh_token` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `oauth2_access_token_id` bigint(20) unsigned NOT NULL,
  `refresh_token` varchar(100) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `expires_at` datetime NOT NULL,
  `issued_at` datetime NOT NULL,
  `is_revoked` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `refresh_token` (`refresh_token`),
  KEY `fk_oauth2_refresh_token_oauth2_access_token_id` (`oauth2_access_token_id`),
  CONSTRAINT `fk_oauth2_refresh_token_oauth2_access_token_id` FOREIGN KEY (`oauth2_access_token_id`) REFERENCES `oauth2_access_token` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

-- Export de données de la table oauth2.oauth2_refresh_token : ~0 rows (environ)
/*!40000 ALTER TABLE `oauth2_refresh_token` DISABLE KEYS */;
/*!40000 ALTER TABLE `oauth2_refresh_token` ENABLE KEYS */;

-- Export de la structure de la table oauth2. oauth2_scope
CREATE TABLE IF NOT EXISTS `oauth2_scope` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `scope` varchar(255) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `scope` (`scope`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

-- Export de données de la table oauth2.oauth2_scope : ~0 rows (environ)
/*!40000 ALTER TABLE `oauth2_scope` DISABLE KEYS */;
/*!40000 ALTER TABLE `oauth2_scope` ENABLE KEYS */;

-- Export de la structure de la table oauth2. oauth2_session
CREATE TABLE IF NOT EXISTS `oauth2_session` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `oauth2_client_id` bigint(20) unsigned NOT NULL,
  `oauth2_user_id` bigint(20) unsigned DEFAULT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_oauth2_session_oauth2_client_id` (`oauth2_client_id`),
  KEY `fk_oauth2_session_oauth2_user_id` (`oauth2_user_id`),
  CONSTRAINT `fk_oauth2_session_oauth2_client_id` FOREIGN KEY (`oauth2_client_id`) REFERENCES `oauth2_client` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_oauth2_session_oauth2_user_id` FOREIGN KEY (`oauth2_user_id`) REFERENCES `oauth2_user` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

-- Export de données de la table oauth2.oauth2_session : ~0 rows (environ)
/*!40000 ALTER TABLE `oauth2_session` DISABLE KEYS */;
/*!40000 ALTER TABLE `oauth2_session` ENABLE KEYS */;

-- Export de la structure de la table oauth2. oauth2_user
CREATE TABLE IF NOT EXISTS `oauth2_user` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(150) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `password` char(128) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  KEY `password` (`password`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

-- Export de données de la table oauth2.oauth2_user : ~0 rows (environ)
/*!40000 ALTER TABLE `oauth2_user` DISABLE KEYS */;
/*!40000 ALTER TABLE `oauth2_user` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
