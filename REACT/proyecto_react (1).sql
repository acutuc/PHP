-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 01-06-2023 a las 11:09:36
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
-- Estructura de tabla para la tabla `almacen`
--

CREATE TABLE `almacen` (
  `id_almacen` int(11) NOT NULL,
  `direccion` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `almacen`
--

INSERT INTO `almacen` (`id_almacen`, `direccion`) VALUES
(1, 'Estepona, Málaga'),
(2, 'Marbella, Málaga');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `menus`
--

CREATE TABLE `menus` (
  `id_menu` int(11) NOT NULL,
  `nombre_menu` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `menusProductos`
--

CREATE TABLE `menusProductos` (
  `id_menu_productos` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `id_menu` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
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
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id_producto`, `nombre_producto`, `cantidad`, `unidad_medida`, `precio_unitario`, `fecha_recepcion`, `consumido`, `id_almacen`) VALUES
(11, 'ARROZ BLANCO (KG)', 100, 'u', '1.20', 20230525, 0, 1),
(12, 'ACEITE DE OLIVA', 69, 'L', '6.40', 20230526, 11, 1),
(13, 'CHORIZO', 96, 'u', '3.00', 20230527, 4, 1),
(14, 'LENTEJAS (KG)', 8, 'u', '1.10', 20230601, 0, 1),
(15, 'GARBANZOS (KG)', 21, 'u', '3.20', 20230529, 3, 1),
(16, 'MANDARINAS (KG)', 6, 'u', '5.25', 20230602, 2, 1),
(17, 'SAL (KG)', 290, 'u', '0.90', 20230603, 10, 1),
(18, 'JJJJJJJ', 5, 'u', '4.30', 20230603, 0, 1),
(19, 'GARBANZOS (KG)', 100, 'u', '5.00', 20230601, 0, 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `almacen`
--
ALTER TABLE `almacen`
  ADD PRIMARY KEY (`id_almacen`);

--
-- Indices de la tabla `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`id_menu`);

--
-- Indices de la tabla `menusProductos`
--
ALTER TABLE `menusProductos`
  ADD PRIMARY KEY (`id_menu_productos`),
  ADD KEY `id_producto` (`id_producto`),
  ADD KEY `id_menu` (`id_menu`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id_producto`),
  ADD KEY `id_almacen` (`id_almacen`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `almacen`
--
ALTER TABLE `almacen`
  MODIFY `id_almacen` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `menus`
--
ALTER TABLE `menus`
  MODIFY `id_menu` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `menusProductos`
--
ALTER TABLE `menusProductos`
  MODIFY `id_menu_productos` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id_producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `menus`
--
ALTER TABLE `menus`
  ADD CONSTRAINT `menus_ibfk_1` FOREIGN KEY (`id_menu`) REFERENCES `menusProductos` (`id_menu`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Filtros para la tabla `menusProductos`
--
ALTER TABLE `menusProductos`
  ADD CONSTRAINT `menusProductos_ibfk_1` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `Productos_ibfk_1` FOREIGN KEY (`id_almacen`) REFERENCES `almacen` (`id_almacen`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
