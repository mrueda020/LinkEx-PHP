-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 13-01-2021 a las 05:05:47
-- Versión del servidor: 8.0.22
-- Versión de PHP: 7.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "-06:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `examen3`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `admin`
--

CREATE TABLE `admin` (
  `idAdmin` int NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `admin`
--

INSERT INTO `admin` (`idAdmin`, `email`, `password`) VALUES
(1, 'linkexadmin@gmail.com', 'linkex');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `calificacion`
--

CREATE TABLE `calificacion` (
  `email` varchar(50) NOT NULL,
  `idExamen` text NOT NULL,
  `calificacion` int NOT NULL,
  `cantidadPregunta` int NOT NULL,
  `respuestaCorrecta` int NOT NULL,
  `tipoExamen` int NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `evaluado`
--

CREATE TABLE `evaluado` (
  `nombre` varchar(50) NOT NULL,
  `apellido` varchar(100) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `evaluado`
--

INSERT INTO `evaluado` (`nombre`, `apellido`, `email`, `password`) VALUES
('Francisco Alan', 'Almanza Medina', 'alanescom@gmail.com', 'alan123'),
('Miguel', 'Rueda Carbjal', 'miguelescom@gmail.com', 'miguel123');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `examen`
--

CREATE TABLE `examen` (
  `idExamen` text NOT NULL,
  `tema` varchar(100) NOT NULL,
  `respuestaCorrecta` int NOT NULL,
  `tipoExamen` int NOT NULL,
  `total` int NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `examen`
--

INSERT INTO `examen` (`idExamen`, `tema`, `respuestaCorrecta`, `tipoExamen`, `total`, `fecha`) VALUES
('5ffe6b79042fb', 'Examen 1', 1, 1, 5, '2021-01-13 03:39:37'),
('5ffe6f17550ef', 'Examen 2', 1, 0, 2, '2021-01-13 03:55:03');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `incisos`
--

CREATE TABLE `incisos` (
  `idPregunta` varchar(50) NOT NULL,
  `opciones` varchar(5000) NOT NULL,
  `idOpciones` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `incisos`
--

INSERT INTO `incisos` (`idPregunta`, `opciones`, `idOpciones`) VALUES
('5ffe6f05e83b9', 'C#', '5ffe6f05e97a3'),
('5ffe6f05e83b9', 'PHP', '5ffe6f05e97a6'),
('5ffe6f05e83b9', 'Pyhton', '5ffe6f05e97a7'),
('5ffe6f05e83b9', 'AMD', '5ffe6f05e97a8'),
('5ffe6f05f0651', 'MySQL', '5ffe6f05f1515'),
('5ffe6f05f0651', 'MariaDB', '5ffe6f05f1518'),
('5ffe6f05f0651', 'Oracle', '5ffe6f05f1519'),
('5ffe6f05f0651', 'NVIDIA', '5ffe6f05f151a'),
('5ffe6f06036b0', 'Intel', '5ffe6f0604db8'),
('5ffe6f06036b0', 'Windows', '5ffe6f0604dbb'),
('5ffe6f06036b0', 'Linux', '5ffe6f0604dbc'),
('5ffe6f06036b0', 'Solaris', '5ffe6f0604dbd'),
('5ffe6f060a94c', 'Java', '5ffe6f060bcd6'),
('5ffe6f060a94c', 'Ryzen', '5ffe6f060bcda'),
('5ffe6f060a94c', 'C', '5ffe6f060bcdb'),
('5ffe6f060a94c', 'Python', '5ffe6f060bcdc'),
('5ffe6f0611432', 'C# y Visual Studio', '5ffe6f061228b'),
('5ffe6f0611432', 'React y PHP', '5ffe6f061228e'),
('5ffe6f0611432', 'Perl y Java', '5ffe6f061228f'),
('5ffe6f0611432', 'Python y Unity', '5ffe6f0612290'),
('5ffe7004ec701', 'Autoridad lineal', '5ffe7004edbb3'),
('5ffe7004ec701', 'Autoridad moral', '5ffe7004edbb6'),
('5ffe7004ec701', 'Autoridad inmoral', '5ffe7004edbb7'),
('5ffe7004ec701', 'Autoridad liderada', '5ffe7004edbb8'),
('5ffe7005003cd', 'Liderazgo', '5ffe700501bea'),
('5ffe7005003cd', 'Virtudes', '5ffe700501bee'),
('5ffe7005003cd', 'Fe', '5ffe700501bef'),
('5ffe7005003cd', 'El poder legitimo', '5ffe700501bf0');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pregunta`
--

CREATE TABLE `pregunta` (
  `idExamen` text NOT NULL,
  `idPregunta` text NOT NULL,
  `pregunta` text NOT NULL,
  `cantidadRespuesta` int NOT NULL,
  `numeroPregunta` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `pregunta`
--

INSERT INTO `pregunta` (`idExamen`, `idPregunta`, `pregunta`, `cantidadRespuesta`, `numeroPregunta`) VALUES
('5ffe6b79042fb', '5ffe6f05e83b9', 'Cual de los siguientes NO corresponde a un lenguaje de programacion', 4, 1),
('5ffe6b79042fb', '5ffe6f05f0651', 'Sistema Gestor de Base de Datos de la empresa Oracle Corporation', 4, 2),
('5ffe6b79042fb', '5ffe6f06036b0', 'Sistema Operativo de la empresa Microsoft', 4, 3),
('5ffe6b79042fb', '5ffe6f060a94c', 'Lenguaje de Programación Orientado a Objetos de la empresa Oracle', 4, 4),
('5ffe6b79042fb', '5ffe6f0611432', 'LinkEX se desarrollo usando...', 4, 5),
('5ffe6f17550ef', '5ffe7004ec701', 'Es el tipo de autoridad directa jefe-subordinado...', 4, 1),
('5ffe6f17550ef', '5ffe7005003cd', 'La autoridad lineal se basa principalmente en...', 4, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `respuesta`
--

CREATE TABLE `respuesta` (
  `idPregunta` text NOT NULL,
  `idRespuesta` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `respuesta`
--

INSERT INTO `respuesta` (`idPregunta`, `idRespuesta`) VALUES
('5ffe6f05e83b9', '5ffe6f05e97a8'),
('5ffe6f05f0651', '5ffe6f05f1519'),
('5ffe6f06036b0', '5ffe6f0604dbb'),
('5ffe6f060a94c', '5ffe6f060bcd6'),
('5ffe6f0611432', '5ffe6f061228e'),
('5ffe7004ec701', '5ffe7004edbb3'),
('5ffe7005003cd', '5ffe700501bf0');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`idAdmin`);

--
-- Indices de la tabla `evaluado`
--
ALTER TABLE `evaluado`
  ADD PRIMARY KEY (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `admin`
--
ALTER TABLE `admin`
  MODIFY `idAdmin` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
