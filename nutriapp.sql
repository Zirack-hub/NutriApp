-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 23-03-2026 a las 08:35:07
-- Versión del servidor: 5.7.31
-- Versión de PHP: 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `nutriapp`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alergenos`
--

DROP TABLE IF EXISTS `alergenos`;
CREATE TABLE IF NOT EXISTS `alergenos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `alergenos`
--

INSERT INTO `alergenos` (`id`, `nombre`) VALUES
(1, 'Gluten'),
(2, 'Crustáceos'),
(3, 'Huevos'),
(4, 'Pescado'),
(5, 'Cacahuetes'),
(6, 'Soja'),
(7, 'Leche'),
(8, 'Frutos secos'),
(9, 'Apio'),
(10, 'Mostaza'),
(11, 'Sésamo'),
(12, 'Sulfitos'),
(13, 'Altramuces'),
(14, 'Moluscos');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `t-2`
--

DROP TABLE IF EXISTS `t-2`;
CREATE TABLE IF NOT EXISTS `t-2` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `na_100` decimal(10,2) DEFAULT NULL,
  `ca_100` decimal(10,2) DEFAULT NULL,
  `k_100` decimal(10,2) DEFAULT NULL,
  `energia_kcal` decimal(10,2) DEFAULT NULL,
  `proteinas_g` decimal(10,2) DEFAULT NULL,
  `grasas_g` decimal(10,2) DEFAULT NULL,
  `ags_g` decimal(10,2) DEFAULT NULL,
  `agm_g` decimal(10,2) DEFAULT NULL,
  `agp_g` decimal(10,2) DEFAULT NULL,
  `colesterol_mg` decimal(10,2) DEFAULT NULL,
  `hc_g` decimal(10,2) DEFAULT NULL,
  `fibra_g` decimal(10,2) DEFAULT NULL,
  `vit_c_mg` decimal(10,2) DEFAULT NULL,
  `vit_b6_mg` decimal(10,2) DEFAULT NULL,
  `vit_e_mg` decimal(10,2) DEFAULT NULL,
  `hierro_mg` decimal(10,2) DEFAULT NULL,
  `sodio_mg` decimal(10,2) DEFAULT NULL,
  `calcio_mg` decimal(10,2) DEFAULT NULL,
  `potasio_mg` decimal(10,2) DEFAULT NULL,
  `porcentaje_energia_total` decimal(5,2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipos`
--

DROP TABLE IF EXISTS `tipos`;
CREATE TABLE IF NOT EXISTS `tipos` (
  `ID` int(11) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tipos`
--

INSERT INTO `tipos` (`ID`, `nombre`) VALUES
(0, 'Admin'),
(1, 'Profesor'),
(2, 'Alumno');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE IF NOT EXISTS `usuarios` (
  `ID` int(11) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `NOMBRE` varchar(100) DEFAULT NULL,
  `CONTRASENA` varchar(255) DEFAULT NULL,
  `TIPO` int(11) DEFAULT NULL,
  `TABLA` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `email` (`email`),
  KEY `TIPO` (`TIPO`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`ID`, `email`, `NOMBRE`, `CONTRASENA`, `TIPO`, `TABLA`) VALUES
(0, 'admin@admin.com', 'Admin', 'Admin', 0, 't0'),
(1, 'samuel@edu.madrid.org', 'Samuel', '$2y$10$obOa415WANjEVTKsjRNuleCNJu56F./IuE0F2ERLq/Zsdai111.ma', 2, 'T-1'),
(2, 'EmilioNotCharlie@charlint.com', 'Emilio', '$2y$10$EoKELCvLFkzpv2vDPdbSt.OxqViTBJ9Qwwb/.ZZHe206gI6yURHdS', 2, 't-2');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
