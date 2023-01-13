-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 13-01-2023 a las 08:50:49
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
-- Base de datos: `bd_blog`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `idCategoria` int(11) NOT NULL,
  `valor` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`idCategoria`, `valor`) VALUES
(1, 'Deportes'),
(2, 'Economía');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comentarios`
--

CREATE TABLE `comentarios` (
  `idComentario` int(11) NOT NULL,
  `comentario` text DEFAULT NULL,
  `idUsuario` int(11) DEFAULT NULL,
  `idNoticia` int(11) DEFAULT NULL,
  `estado` enum('sin validar','apto') DEFAULT 'sin validar',
  `fCreacion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `noticias`
--

CREATE TABLE `noticias` (
  `idNoticia` int(11) NOT NULL,
  `titulo` varchar(100) DEFAULT NULL,
  `copete` varchar(255) DEFAULT NULL,
  `cuerpo` text DEFAULT NULL,
  `idUsuario` int(11) DEFAULT NULL,
  `idCategoria` int(11) DEFAULT NULL,
  `fPublicacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `fCreacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `fModificacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `noticias`
--

INSERT INTO `noticias` (`idNoticia`, `titulo`, `copete`, `cuerpo`, `idUsuario`, `idCategoria`, `fPublicacion`, `fCreacion`, `fModificacion`) VALUES
(1, 'El Barça entra en bucle', 'Es incapaz de cerrar los partidos a pesar de ponerse por delante en el marcador', 'Al Barcelona le persiguen los mismos errores desde que se reanudó la competición en el mes de diciembre. Marca pronto, se adelanta en el partido, pero es incapaz de cerrar la contienda y le empatan una y otra vez. Le sucedió en el primer partido frente al Espanyol. El gol inicial fue neutralizado por el de Joselu en la segunda parte. Dos puntos que volaron en Liga. El Barça fue mejor, pero no ganó.', 2, 1, '2023-01-13 07:45:40', '2023-01-13 07:45:40', '2023-01-13 07:45:40'),
(2, 'La gasolina escala un 17% y el diésel un 15%', 'El precio de los combustibles sube por segunda semana consecutiva. El litro de gasolina cuesta ya 1,616 euros y el de diésel 1,681 euros. Llenar un depósito de 55 litros es 13 euros más caro que la semana previa a la supresión del descuento', 'El precio de la gasolina y del diésel consolida una nueva tendencia al alza tras acumular dos semanas consecutivas de subidas justo después de desaparecer la bonificación generalizada de 20 céntimos a los carburantes. La semana pasada (27 de diciembre al 2 de enero), la gasolina subió por primera vez después de seis semanas consecutivas de caídas (desde mediados noviembre) y el gasóleo también dejó atrás su racha de nueve retrocesos seguidos (desde finales de octubre). Ahora ya hablamos de una segunda subida, que en el caso de la gasolina ha sido del 2,08% y en el del gasóleo del 1,26% con respecto a la semana pasada, cuando la gasolina costaba 1,583 euros y el diésel 1,660 euros sin descuentos. No obstante, antes de que se acabase la bonificación, el 1 de enero, los usuarios pagaban por la gasolina 1,383 y por el diésel 1,46 euros, por lo que, con respecto a esos precios aún rebajados, el encarecimiento de esta semana es de un 16,85% para la gasolina y de un 15,2% para el diésel.', 2, 2, '2023-01-13 07:50:11', '2023-01-13 07:50:11', '2023-01-13 07:50:11');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `idUsuario` int(11) NOT NULL,
  `usuario` varchar(30) DEFAULT NULL,
  `clave` varchar(50) DEFAULT NULL,
  `nombre` varchar(50) DEFAULT NULL,
  `email` varchar(30) DEFAULT NULL,
  `tipo` enum('admin','normal') DEFAULT 'normal'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`idUsuario`, `usuario`, `clave`, `nombre`, `email`, `tipo`) VALUES
(1, 'acutuc', 'b08578c42d1d2ef199c102ccfedb1cc7', 'Gabriel', 'acutuc94@gmail.com', 'admin'),
(2, 'parodio', '77aee531020171767c919dc91fcc1e07', 'Javier Parodi', 'parodio@gmail.com', 'normal');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`idCategoria`);

--
-- Indices de la tabla `comentarios`
--
ALTER TABLE `comentarios`
  ADD PRIMARY KEY (`idComentario`),
  ADD KEY `idUsuario` (`idUsuario`),
  ADD KEY `idNoticia` (`idNoticia`);

--
-- Indices de la tabla `noticias`
--
ALTER TABLE `noticias`
  ADD PRIMARY KEY (`idNoticia`),
  ADD KEY `idUsuario` (`idUsuario`),
  ADD KEY `idCategoria` (`idCategoria`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`idUsuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `idCategoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `comentarios`
--
ALTER TABLE `comentarios`
  MODIFY `idComentario` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `noticias`
--
ALTER TABLE `noticias`
  MODIFY `idNoticia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `idUsuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `comentarios`
--
ALTER TABLE `comentarios`
  ADD CONSTRAINT `comentarios_ibfk_1` FOREIGN KEY (`idUsuario`) REFERENCES `usuarios` (`idUsuario`),
  ADD CONSTRAINT `comentarios_ibfk_2` FOREIGN KEY (`idNoticia`) REFERENCES `noticias` (`idNoticia`);

--
-- Filtros para la tabla `noticias`
--
ALTER TABLE `noticias`
  ADD CONSTRAINT `noticias_ibfk_1` FOREIGN KEY (`idUsuario`) REFERENCES `usuarios` (`idUsuario`),
  ADD CONSTRAINT `noticias_ibfk_2` FOREIGN KEY (`idCategoria`) REFERENCES `categorias` (`idCategoria`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
