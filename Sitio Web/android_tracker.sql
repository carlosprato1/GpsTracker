-- phpMyAdmin SQL Dump
-- version 4.6.6deb4
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 06-02-2018 a las 13:53:05
-- Versión del servidor: 10.1.26-MariaDB-0+deb9u1
-- Versión de PHP: 7.0.27-0+deb9u1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `android_tracker`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `android`
--

CREATE TABLE `android` (
  `nombre_a` varchar(50) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `ID_A` int(10) NOT NULL,
  `telefono` varchar(40) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `appID` varchar(40) COLLATE utf8mb4_spanish2_ci NOT NULL DEFAULT 'no'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `android`
--

INSERT INTO `android` (`nombre_a`, `ID_A`, `telefono`, `appID`) VALUES
('CM990', 12, 'CM990', 'a0a237aa-153c-4312-be9f-2238714da5ec'),
('carlos', 13, '656', 'no'),
('fdfsdf', 14, 'sfsdf', 'no'),
('ttr', 15, 'trettr', 'no');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `areporte_12`
--

CREATE TABLE `areporte_12` (
  `latitud` decimal(10,7) NOT NULL DEFAULT '0.0000000',
  `longitud` decimal(10,7) NOT NULL DEFAULT '0.0000000',
  `ID_A` int(10) NOT NULL DEFAULT '12',
  `TimeCarga` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `speed` decimal(10,3) DEFAULT '0.000',
  `TimeGPS` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `altitud` decimal(10,1) DEFAULT '0.0',
  `direccion` decimal(10,1) DEFAULT '0.0',
  `disUlt` decimal(10,1) DEFAULT '0.0',
  `json` tinyint(1) DEFAULT '1',
  `error` decimal(10,2) NOT NULL DEFAULT '0.00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `areporte_12`
--

INSERT INTO `areporte_12` (`latitud`, `longitud`, `ID_A`, `TimeCarga`, `speed`, `TimeGPS`, `altitud`, `direccion`, `disUlt`, `json`, `error`) VALUES
('82.2999983', '-122.0840000', 12, '2018-01-19 03:34:51', '0.000', '2018-01-19 03:04:51', '0.0', '0.0', '11167.5', 0, '20.00'),
('82.0999983', '-122.0840000', 12, '2018-01-19 03:34:51', '0.000', '2018-01-19 03:03:00', '0.0', '0.0', '11167.0', 0, '20.00'),
('82.2000000', '-122.0840000', 12, '2018-01-19 03:34:51', '0.000', '2018-01-19 03:03:00', '0.0', '0.0', '11167.5', 0, '20.00'),
('82.0999983', '-122.0840000', 12, '2018-01-19 04:43:37', '0.000', '2018-01-19 04:13:37', '0.0', '0.0', '11167.1', 0, '20.00'),
('82.2999983', '-122.0840000', 12, '2018-01-19 04:43:37', '0.000', '2018-01-19 04:09:24', '0.0', '0.0', '0.0', 0, '20.00'),
('82.2000000', '-122.0840000', 12, '2018-01-19 04:43:37', '0.000', '2018-01-19 04:12:44', '0.0', '0.0', '11166.8', 0, '20.00'),
('82.0999983', '-122.0840000', 12, '2018-01-19 05:20:36', '0.000', '2018-01-19 04:49:07', '0.0', '0.0', '0.0', 0, '20.00'),
('82.2000000', '-122.0840000', 12, '2018-01-19 05:22:18', '0.000', '2018-01-19 04:52:18', '0.0', '0.0', '11167.5', 0, '20.00'),
('82.5000000', '-122.0840000', 12, '2018-01-19 05:24:26', '0.000', '2018-01-19 04:54:26', '0.0', '0.0', '11167.3', 0, '20.00'),
('82.2999983', '-122.0840000', 12, '2018-01-19 05:24:26', '0.000', '2018-01-19 04:52:48', '0.0', '0.0', '11167.5', 0, '20.00'),
('82.4000000', '-122.0840000', 12, '2018-01-19 05:24:26', '0.000', '2018-01-19 04:53:28', '0.0', '0.0', '11167.9', 0, '20.00'),
('82.5999983', '-122.0840000', 12, '2018-01-19 05:29:34', '0.000', '2018-01-19 04:59:34', '0.0', '0.0', '22334.6', 0, '20.00'),
('82.4000000', '-122.0840000', 12, '2018-01-19 05:29:34', '0.000', '2018-01-19 04:57:47', '0.0', '0.0', '11167.4', 0, '20.00'),
('82.7000000', '-122.0840000', 12, '2018-01-19 05:31:06', '0.000', '2018-01-19 05:01:06', '0.0', '0.0', '11167.7', 0, '20.00'),
('82.7999983', '-122.0840000', 12, '2018-01-19 05:32:53', '0.000', '2018-01-19 05:02:53', '0.0', '0.0', '11167.8', 0, '20.00'),
('83.0000000', '-122.0840000', 12, '2018-01-19 05:35:21', '0.000', '2018-01-19 05:05:21', '0.0', '0.0', '11167.5', 0, '20.00'),
('82.9000000', '-122.0840000', 12, '2018-01-19 05:35:21', '0.000', '2018-01-19 05:04:50', '0.0', '0.0', '11168.2', 0, '20.00'),
('83.0999983', '-122.0840000', 12, '2018-01-19 05:46:14', '0.000', '2018-01-19 05:16:14', '0.0', '0.0', '11167.6', 0, '20.00'),
('83.2999983', '-122.0840000', 12, '2018-01-19 05:48:46', '0.000', '2018-01-19 05:18:45', '0.0', '0.0', '11168.0', 0, '20.00'),
('83.2000000', '-122.0840000', 12, '2018-01-19 05:48:46', '0.000', '2018-01-19 05:17:18', '0.0', '0.0', '11168.0', 0, '20.00'),
('83.5999983', '-122.0840000', 12, '2018-01-19 05:59:22', '0.000', '2018-01-19 05:29:22', '0.0', '0.0', '11167.8', 0, '20.00'),
('83.4000000', '-122.0840000', 12, '2018-01-19 05:59:22', '0.000', '2018-01-19 05:27:08', '0.0', '0.0', '0.0', 0, '20.00'),
('83.5000000', '-122.0840000', 12, '2018-01-19 05:59:22', '0.000', '2018-01-19 05:28:05', '0.0', '0.0', '11167.8', 0, '20.00'),
('83.8322000', '-122.0840000', 12, '2018-01-24 21:00:27', '0.000', '2018-01-24 20:30:26', '0.0', '0.0', '0.0', 1, '20.00'),
('83.8323000', '-122.0840000', 12, '2018-01-24 21:01:09', '0.000', '2018-01-24 20:31:08', '0.0', '0.0', '0.0', 1, '20.00'),
('83.8323183', '-122.0840000', 12, '2018-01-24 21:02:09', '0.000', '2018-01-24 20:32:08', '0.0', '0.0', '0.0', 1, '20.00'),
('83.8323100', '-122.0840000', 12, '2018-01-24 21:02:44', '0.000', '2018-01-24 20:32:43', '0.0', '0.0', '0.0', 1, '20.00'),
('83.8322783', '-122.0840000', 12, '2018-01-24 21:06:00', '0.000', '2018-01-24 20:35:59', '0.0', '0.0', '0.0', 1, '20.00'),
('12.3000000', '12.5000000', 12, '2018-01-24 21:15:38', '0.000', '0000-00-00 00:00:00', '0.0', '0.0', '0.0', 0, '5.00'),
('83.8322783', '-122.0840000', 12, '2018-01-24 21:18:24', '0.000', '2018-01-24 20:48:23', '0.0', '0.0', '0.0', 1, '20.00'),
('80.8327000', '-122.0840000', 12, '2018-01-24 21:23:11', '0.000', '2018-01-24 20:53:11', '0.0', '0.0', '0.0', 1, '20.00'),
('80.8327000', '-122.0840000', 12, '2018-01-24 21:34:28', '0.000', '2018-01-24 21:04:27', '0.0', '0.0', '0.0', 1, '20.00'),
('80.8329983', '-122.0840000', 12, '2018-01-24 21:39:02', '0.000', '2018-01-24 21:09:02', '0.0', '0.0', '0.0', 1, '20.00'),
('80.8332000', '-122.0840000', 12, '2018-01-24 21:45:06', '0.000', '2018-01-24 21:15:05', '0.0', '0.0', '0.0', 1, '20.00'),
('80.8331000', '-122.0840000', 12, '2018-01-24 21:50:54', '0.000', '2018-01-24 21:13:31', '0.0', '0.0', '0.0', 1, '20.00'),
('80.8336983', '-122.0840000', 12, '2018-01-24 21:56:48', '0.000', '2018-01-24 21:26:48', '0.0', '0.0', '0.0', 1, '20.00'),
('80.8332983', '-122.0840000', 12, '2018-01-24 21:56:48', '0.000', '2018-01-24 21:23:29', '0.0', '0.0', '0.0', 0, '20.00'),
('80.8333983', '-122.0840000', 12, '2018-01-24 21:56:48', '0.000', '2018-01-24 21:24:00', '0.0', '0.0', '0.0', 0, '20.00'),
('80.8335000', '-122.0840000', 12, '2018-01-24 21:56:48', '0.000', '2018-01-24 21:24:30', '0.0', '0.0', '0.0', 0, '20.00'),
('80.8336000', '-122.0840000', 12, '2018-01-24 21:56:48', '0.000', '2018-01-24 21:25:27', '0.0', '0.0', '0.0', 0, '20.00'),
('80.8336983', '-122.0840000', 12, '2018-01-26 22:13:43', '0.000', '2018-01-26 21:43:40', '0.0', '0.0', '0.0', 1, '20.00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `areporte_13`
--

CREATE TABLE `areporte_13` (
  `latitud` decimal(10,7) NOT NULL DEFAULT '0.0000000',
  `longitud` decimal(10,7) NOT NULL DEFAULT '0.0000000',
  `ID_A` int(10) NOT NULL DEFAULT '13',
  `TimeCarga` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `speed` decimal(10,3) DEFAULT '0.000',
  `TimeGPS` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `altitud` decimal(10,1) DEFAULT '0.0',
  `direccion` decimal(10,1) DEFAULT '0.0',
  `disUlt` decimal(10,1) DEFAULT '0.0',
  `json` tinyint(1) DEFAULT '1',
  `error` decimal(10,2) NOT NULL DEFAULT '0.00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `areporte_13`
--

INSERT INTO `areporte_13` (`latitud`, `longitud`, `ID_A`, `TimeCarga`, `speed`, `TimeGPS`, `altitud`, `direccion`, `disUlt`, `json`, `error`) VALUES
('-12.5230000', '13.2540000', 13, '2018-01-23 04:00:01', '2.220', '2018-01-23 04:00:01', '0.0', '0.0', '0.0', 1, '5.00'),
('-12.5240000', '13.2540000', 13, '2018-01-23 04:00:00', '2.220', '2018-01-23 04:00:02', '0.0', '0.0', '0.0', 1, '5.00'),
('-12.5245000', '13.2540000', 13, '2018-01-23 04:00:00', '2.220', '2018-01-23 04:00:03', '0.0', '0.0', '0.0', 1, '5.00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `areporte_14`
--

CREATE TABLE `areporte_14` (
  `latitud` decimal(10,7) NOT NULL DEFAULT '0.0000000',
  `longitud` decimal(10,7) NOT NULL DEFAULT '0.0000000',
  `ID_A` int(10) NOT NULL DEFAULT '14',
  `TimeCarga` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `speed` decimal(10,3) DEFAULT '0.000',
  `TimeGPS` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `altitud` decimal(10,1) DEFAULT '0.0',
  `direccion` decimal(10,1) DEFAULT '0.0',
  `disUlt` decimal(10,1) DEFAULT '0.0',
  `json` tinyint(1) DEFAULT '1',
  `error` decimal(10,2) NOT NULL DEFAULT '0.00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `areporte_15`
--

CREATE TABLE `areporte_15` (
  `latitud` decimal(10,7) NOT NULL DEFAULT '0.0000000',
  `longitud` decimal(10,7) NOT NULL DEFAULT '0.0000000',
  `ID_A` int(10) NOT NULL DEFAULT '15',
  `TimeCarga` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `speed` decimal(10,3) DEFAULT '0.000',
  `TimeGPS` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `altitud` decimal(10,1) DEFAULT '0.0',
  `direccion` decimal(10,1) DEFAULT '0.0',
  `disUlt` decimal(10,1) DEFAULT '0.0',
  `json` tinyint(1) DEFAULT '1',
  `error` decimal(10,2) NOT NULL DEFAULT '0.00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `android`
--
ALTER TABLE `android`
  ADD PRIMARY KEY (`ID_A`);

--
-- Indices de la tabla `areporte_13`
--
ALTER TABLE `areporte_13`
  ADD PRIMARY KEY (`TimeGPS`);

--
-- Indices de la tabla `areporte_14`
--
ALTER TABLE `areporte_14`
  ADD PRIMARY KEY (`TimeGPS`);

--
-- Indices de la tabla `areporte_15`
--
ALTER TABLE `areporte_15`
  ADD PRIMARY KEY (`TimeGPS`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `android`
--
ALTER TABLE `android`
  MODIFY `ID_A` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
