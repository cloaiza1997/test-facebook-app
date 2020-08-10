-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         10.4.11-MariaDB - mariadb.org binary distribution
-- SO del servidor:              Win64
-- HeidiSQL Versión:             11.0.0.5919
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Volcando estructura de base de datos para api_facebook
DROP DATABASE IF EXISTS `api_facebook`;
CREATE DATABASE IF NOT EXISTS `api_facebook` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `api_facebook`;

-- Volcando estructura para tabla api_facebook.anuncios
DROP TABLE IF EXISTS `anuncios`;
CREATE TABLE IF NOT EXISTS `anuncios` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_fb` varchar(100) NOT NULL,
  `id_grupo` int(10) unsigned NOT NULL,
  `id_contenido` int(10) unsigned NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Volcando datos para la tabla api_facebook.anuncios: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `anuncios` DISABLE KEYS */;
/*!40000 ALTER TABLE `anuncios` ENABLE KEYS */;

-- Volcando estructura para tabla api_facebook.campanhas
DROP TABLE IF EXISTS `campanhas`;
CREATE TABLE IF NOT EXISTS `campanhas` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_fb` varchar(100) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `objetivo` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Volcando datos para la tabla api_facebook.campanhas: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `campanhas` DISABLE KEYS */;
/*!40000 ALTER TABLE `campanhas` ENABLE KEYS */;

-- Volcando estructura para tabla api_facebook.contenido
DROP TABLE IF EXISTS `contenido`;
CREATE TABLE IF NOT EXISTS `contenido` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_fb` varchar(100) DEFAULT NULL,
  `nombre` varchar(100) NOT NULL,
  `titulo` varchar(100) NOT NULL,
  `url_imagen` varchar(1000) NOT NULL,
  `cuerpo` varchar(1000) NOT NULL,
  `id_publicacion` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Volcando datos para la tabla api_facebook.contenido: ~1 rows (aproximadamente)
/*!40000 ALTER TABLE `contenido` DISABLE KEYS */;
/*!40000 ALTER TABLE `contenido` ENABLE KEYS */;

-- Volcando estructura para tabla api_facebook.grupos_anuncios
DROP TABLE IF EXISTS `grupos_anuncios`;
CREATE TABLE IF NOT EXISTS `grupos_anuncios` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_campanha` int(10) unsigned NOT NULL,
  `id_fb` varchar(100) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `inicio` date NOT NULL,
  `fin` date NOT NULL,
  `evento_facturacion` varchar(50) NOT NULL DEFAULT '',
  `objetivo_optimizacion` varchar(50) NOT NULL DEFAULT '',
  `presupuesto_diario` double NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `fk_campahna` (`id_campanha`),
  CONSTRAINT `fk_campahna` FOREIGN KEY (`id_campanha`) REFERENCES `campanhas` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Volcando datos para la tabla api_facebook.grupos_anuncios: ~1 rows (aproximadamente)
/*!40000 ALTER TABLE `grupos_anuncios` DISABLE KEYS */;
/*!40000 ALTER TABLE `grupos_anuncios` ENABLE KEYS */;

-- Volcando estructura para tabla api_facebook.parametros
DROP TABLE IF EXISTS `parametros`;
CREATE TABLE IF NOT EXISTS `parametros` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `valor` varchar(500) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;

-- Volcando datos para la tabla api_facebook.parametros: ~4 rows (aproximadamente)
/*!40000 ALTER TABLE `parametros` DISABLE KEYS */;
REPLACE INTO `parametros` (`id`, `nombre`, `valor`, `created_at`, `updated_at`) VALUES
	(1, 'access_token', 'EAAnBYcOocroBADBYwKWaMYc9HDCGELxVucE7FgMpDTVbm2HSNcjJjKXcTnAlbewNBqWR1y7eJkysw0OJZATUWcA2zPVkjCHO9PoSz66S5l9h5XggKakSIDZCOb3JcwZAZBhS9TB02bZBnOWzJtNih7a95yOR33meQcP1Q5nwZAIIE50WTu8XlEuu0lWb50FskZD', '2020-08-07 21:07:16', '2020-08-07 21:07:16'),
	(2, 'ad_account_id', 'act_738678520298769', '2020-08-07 21:07:31', '2020-08-07 21:07:31'),
	(3, 'app_secret', 'fa426cbaa4258645ed00bd68925666fe', '2020-08-07 21:07:40', '2020-08-07 21:07:40'),
	(4, 'page_id', '592692364752928', '2020-08-07 21:07:51', '2020-08-07 21:07:51'),
	(5, 'app_id', '2745900428980922', '2020-08-07 21:07:58', '2020-08-07 21:07:58');
/*!40000 ALTER TABLE `parametros` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
