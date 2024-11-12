-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 04-07-2022 a las 09:48:18
-- Versión del servidor: 5.1.41
-- Versión de PHP: 5.3.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `bd_planilla`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_material`
--

CREATE TABLE IF NOT EXISTS `detalle_material` (
  `id_detalle_material` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(200) NOT NULL,
  `unidad_medida` varchar(50) NOT NULL,
  `cantidad_solicitada` float(9,2) NOT NULL,
  `cantidad_despachada` float(9,2) NOT NULL,
  `precio_unitario` float(9,2) NOT NULL,
  `id_solicitud_material` int(11) NOT NULL,
  PRIMARY KEY (`id_detalle_material`),
  KEY `id_solicitud_material` (`id_solicitud_material`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=26 ;


--
-- Filtros para las tablas descargadas (dump)
--

--
-- Filtros para la tabla `detalle_material`
--
ALTER TABLE `detalle_material`
  ADD CONSTRAINT `detalle_material_ibfk_1` FOREIGN KEY (`id_solicitud_material`) REFERENCES `solicitud_material` (`id_solicitud_material`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
