-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 23-02-2018 a las 23:27:48
-- Versión del servidor: 10.1.28-MariaDB
-- Versión de PHP: 7.1.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `ajax`
--

CREATE DATABASE `ajax` DEFAULT CHARACTER SET utf8 COLLATE utf8_spanish_ci;
USE `ajax`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `generos`
--

CREATE TABLE `generos` (
  `idGen` tinyint(4) NOT NULL,
  `nombre` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `generos`
--

INSERT INTO `generos` (`idGen`, `nombre`) VALUES
(1, 'Acción'),
(2, 'Aventura'),
(3, 'Lucha'),
(4, 'Rol'),
(5, 'Estrategia');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `juegos`
--

CREATE TABLE `juegos` (
  `idJue` tinyint(4) NOT NULL,
  `idGen` tinyint(4) NOT NULL,
  `titulo` varchar(50) NOT NULL,
  `nota` tinyint(4) NOT NULL,
  `lanzamiento` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `juegos`
--

INSERT INTO `juegos` (`idJue`, `idGen`, `titulo`, `nota`, `lanzamiento`) VALUES
(1, 1, 'Monster Hunter: World', 90, '2018-01-26'),
(2, 1, 'Bayonetta', 89, '2017-04-11'),
(3, 2, 'Until Dawn', 79, '2015-08-25'),
(4, 2, 'Gone Home', 85, '2016-01-12'),
(5, 3, 'Dissidia: Final Fantasy NT', 69, '2018-01-30'),
(6, 3, 'Dragon Ball Fighter Z', 88, '2018-01-26'),
(7, 4, 'Radiant Historia: Perfect Chronology', 84, '2018-02-13'),
(8, 4, 'Xenoblade Chronicles 2', 83, '2017-12-01'),
(9, 5, 'Fire Emblem Echoes: Shadows of Valentia', 81, '2017-05-17'),
(10, 5, 'Mario + Rabbids Kingdom Battle', 85, '2017-08-29'),
(11, 1, 'Wolfenstein 2: The New Colossus', 87, '2017-10-27'),
(12, 1, 'Uncharted 4', 93, '2016-05-10'),
(13, 2, 'Ghost Trick: Phantom Detective', 83, '2011-01-11'),
(14, 2, 'Time Hollow', 64, '2008-09-23'),
(15, 3, 'Super Smash Bros for WiiU', 92, '2014-11-21'),
(16, 3, 'Tekken 7', 82, '2017-06-02'),
(17, 4, 'Persona 5', 93, '2017-04-04'),
(18, 4, 'Ys VIII: Lacrimosa of Dana', 85, '2017-09-12'),
(19, 5, 'Civilization VI', 88, '2016-10-21'),
(20, 5, 'Disgaea 5: Alliance of Vengeance', 80, '2015-10-06');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `nick` varchar(20) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellidos` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `api` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`nick`, `nombre`, `apellidos`, `email`, `api`) VALUES
('Alpharad', 'Jacob', 'Smith', 'alpharad-goi@gmail.com', '243gd'),
('Mattermius', 'Mathew', 'Mercer', 'mattmer@gmail.com', '423rt');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `generos`
--
ALTER TABLE `generos`
  ADD PRIMARY KEY (`idGen`);

--
-- Indices de la tabla `juegos`
--
ALTER TABLE `juegos`
  ADD PRIMARY KEY (`idJue`),
  ADD KEY `idGen` (`idGen`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`nick`);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `juegos`
--
ALTER TABLE `juegos`
  ADD CONSTRAINT `juegos_ibfk_1` FOREIGN KEY (`idGen`) REFERENCES `generos` (`idGen`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
