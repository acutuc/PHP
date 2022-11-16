-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 16-11-2022 a las 12:36:25
-- Versión del servidor: 10.4.25-MariaDB
-- Versión de PHP: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `bd_teoria`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `t_alumnos`
--

CREATE TABLE `t_alumnos` (
  `cod_alu` int(11) NOT NULL,
  `nombre` varchar(15) NOT NULL,
  `telefono` int(11) NOT NULL,
  `cp` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `t_alumnos`
--

INSERT INTO `t_alumnos` (`cod_alu`, `nombre`, `telefono`, `cp`) VALUES
(1, 'JAVIER PARODIO', 666666666, 29680),
(2, 'GABRIEL ALLENDE', 607666356, 29680),
(3, 'NO ES PERSONA', 999999999, 12345),
(4, 'CRISTINA', 555555555, 35014);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `t_asignaturas`
--

CREATE TABLE `t_asignaturas` (
  `cod_asig` int(11) NOT NULL,
  `denominacion` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `t_asignaturas`
--

INSERT INTO `t_asignaturas` (`cod_asig`, `denominacion`) VALUES
(1, 'INGLES'),
(2, 'REDES'),
(3, 'DWESE');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `t_notas`
--

CREATE TABLE `t_notas` (
  `cod_alu` int(11) NOT NULL,
  `cod_asig` int(11) NOT NULL,
  `nota` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `t_notas`
--

INSERT INTO `t_notas` (`cod_alu`, `cod_asig`, `nota`) VALUES
(1, 1, 9),
(1, 2, 8),
(2, 1, 8),
(2, 2, 7),
(4, 1, 5),
(4, 2, 8);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `t_alumnos`
--
ALTER TABLE `t_alumnos`
  ADD PRIMARY KEY (`cod_alu`);

--
-- Indices de la tabla `t_asignaturas`
--
ALTER TABLE `t_asignaturas`
  ADD PRIMARY KEY (`cod_asig`);

--
-- Indices de la tabla `t_notas`
--
ALTER TABLE `t_notas`
  ADD PRIMARY KEY (`cod_alu`,`cod_asig`),
  ADD KEY `cod_asig` (`cod_asig`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `t_alumnos`
--
ALTER TABLE `t_alumnos`
  MODIFY `cod_alu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `t_asignaturas`
--
ALTER TABLE `t_asignaturas`
  MODIFY `cod_asig` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `t_notas`
--
ALTER TABLE `t_notas`
  ADD CONSTRAINT `t_notas_ibfk_1` FOREIGN KEY (`cod_alu`) REFERENCES `t_alumnos` (`cod_alu`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `t_notas_ibfk_2` FOREIGN KEY (`cod_asig`) REFERENCES `t_asignaturas` (`cod_asig`) ON DELETE NO ACTION ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
