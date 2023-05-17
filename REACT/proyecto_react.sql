-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 17-05-2023 a las 10:22:48
-- Versión del servidor: 10.4.27-MariaDB
-- Versión de PHP: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `proyecto_react`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Almacen`
--

CREATE TABLE `Almacen` (
  `id_almacen` int(11) NOT NULL,
  `direccion` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `Almacen`
--

INSERT INTO `Almacen` (`id_almacen`, `direccion`) VALUES
(1, 'Estepona, Málaga'),
(2, 'Marbella, Málaga');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Productos`
--

CREATE TABLE `Productos` (
  `id_producto` int(11) NOT NULL,
  `nombre_producto` varchar(50) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `unidad_medida` enum('L','gr','u') NOT NULL,
  `precio_unitario` decimal(5,2) NOT NULL,
  `fecha_recepcion` int(11) NOT NULL,
  `consumido` tinyint(1) NOT NULL,
  `id_almacen` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `Productos`
--

INSERT INTO `Productos` (`id_producto`, `nombre_producto`, `cantidad`, `unidad_medida`, `precio_unitario`, `fecha_recepcion`, `consumido`, `id_almacen`) VALUES
(1, 'Aceite de oliva', 50, 'L', '1.20', 20230510, 0, 1),
(2, 'Arroz blanco', 50000, 'gr', '1.20', 20230429, 0, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Usuarios`
--

CREATE TABLE `Usuarios` (
  `id_usuario` int(11) NOT NULL,
  `nombre_usuario` varchar(100) NOT NULL,
  `clave` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `Almacen`
--
ALTER TABLE `Almacen`
  ADD PRIMARY KEY (`id_almacen`);

--
-- Indices de la tabla `Productos`
--
ALTER TABLE `Productos`
  ADD PRIMARY KEY (`id_producto`),
  ADD KEY `id_almacen` (`id_almacen`);

--
-- Indices de la tabla `Usuarios`
--
ALTER TABLE `Usuarios`
  ADD PRIMARY KEY (`id_usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `Almacen`
--
ALTER TABLE `Almacen`
  MODIFY `id_almacen` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `Productos`
--
ALTER TABLE `Productos`
  MODIFY `id_producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `Usuarios`
--
ALTER TABLE `Usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `Productos`
--
ALTER TABLE `Productos`
  ADD CONSTRAINT `Productos_ibfk_1` FOREIGN KEY (`id_almacen`) REFERENCES `Almacen` (`id_almacen`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
