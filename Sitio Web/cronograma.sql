-- phpMyAdmin SQL Dump
-- version 4.6.6deb4
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 06-02-2018 a las 13:53:17
-- Versión del servidor: 10.1.26-MariaDB-0+deb9u1
-- Versión de PHP: 7.0.27-0+deb9u1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `cronograma`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `descripcion`
--

CREATE TABLE `descripcion` (
  `est_des` char(1) COLLATE utf8_spanish2_ci NOT NULL,
  `descri` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci NOT NULL,
  `cod_des` int(11) NOT NULL,
  `tipo` char(1) COLLATE utf8_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `descripcion`
--

INSERT INTO `descripcion` (`est_des`, `descri`, `cod_des`, `tipo`) VALUES
('i', 'Ruta 2.  Salida: UNET  LLegada: Capacho', 11, 'f'),
('i', 'Ruta 3: tariba', 13, 'u'),
('a', 'Ruta 32 CENTRO', 16, 'u');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `evento`
--

CREATE TABLE `evento` (
  `tiempo` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `fky_des` int(11) NOT NULL,
  `vehiculo` varchar(30) COLLATE utf8_spanish2_ci DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `evento`
--

INSERT INTO `evento` (`tiempo`, `fky_des`, `vehiculo`) VALUES
('2018-02-04 08:23:00', 11, '5,7,3'),
('2018-02-04 12:59:00', 11, '6'),
('2018-02-04 10:57:00', 11, 'x'),
('2018-02-04 11:06:00', 11, '6,9'),
('2018-02-05 02:58:00', 11, '5'),
('2018-02-04 04:25:00', 13, '6'),
('2018-02-06 08:54:00', 13, 'x'),
('2018-02-07 07:01:00', 13, 'x'),
('2018-02-05 07:33:00', 11, '3'),
('2018-02-05 10:05:00', 11, '65'),
('2018-02-05 11:06:00', 16, '4,6,7'),
('2018-02-05 11:06:00', 16, '76');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `descripcion`
--
ALTER TABLE `descripcion`
  ADD PRIMARY KEY (`cod_des`);

--
-- Indices de la tabla `evento`
--
ALTER TABLE `evento`
  ADD KEY `fky_des` (`fky_des`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `descripcion`
--
ALTER TABLE `descripcion`
  MODIFY `cod_des` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `evento`
--
ALTER TABLE `evento`
  ADD CONSTRAINT `evento_ibfk_1` FOREIGN KEY (`fky_des`) REFERENCES `descripcion` (`cod_des`) ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
