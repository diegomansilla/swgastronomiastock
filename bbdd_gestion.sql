-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 23, 2025 at 03:22 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bbdd_gestion`
--

-- --------------------------------------------------------

--
-- Table structure for table `despacho_plato`
--

CREATE TABLE `despacho_plato` (
  `id` int(11) NOT NULL,
  `id_platos` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `cantidad_despachada` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `equipamientos`
--

CREATE TABLE `equipamientos` (
  `id` int(11) NOT NULL,
  `descripcion` varchar(200) NOT NULL,
  `fecha_ingreso` date NOT NULL,
  `estado` tinyint(4) DEFAULT 0 COMMENT '0 = en mantenimiento, 1 = activo',
  `vida_util` int(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `equipamiento_plato`
--

CREATE TABLE `equipamiento_plato` (
  `id` int(11) NOT NULL,
  `id_plato` int(11) NOT NULL,
  `id_equipamiento` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ingredientes_plato`
--

CREATE TABLE `ingredientes_plato` (
  `id_plato` int(11) NOT NULL,
  `id_materia_prima` int(50) NOT NULL,
  `cantidad` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ingreso_materia_prima`
--

CREATE TABLE `ingreso_materia_prima` (
  `id` int(11) NOT NULL,
  `id_materia_prima` int(50) NOT NULL,
  `fecha` date NOT NULL,
  `cantidad` float NOT NULL,
  `fecha_lote` date NOT NULL,
  `fecha_vencimiento` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `materia_prima`
--

CREATE TABLE `materia_prima` (
  `id` int(11) NOT NULL,
  `codigo_barra` varchar(200) NOT NULL,
  `descripcion` varchar(200) NOT NULL,
  `cantidad` float NOT NULL,
  `fecha_lote` date NOT NULL,
  `fecha_ingreso` date NOT NULL,
  `fecha_vencimiento` date NOT NULL,
  `contenido_neto` varchar(200) NOT NULL COMMENT 'unidad de medida',
  `marca` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `platos`
--

CREATE TABLE `platos` (
  `id` int(11) NOT NULL,
  `descripcion` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `salida_materia_prima`
--

CREATE TABLE `salida_materia_prima` (
  `id` int(11) NOT NULL,
  `id_materia_prima` int(50) NOT NULL,
  `fecha` date NOT NULL,
  `cantidad` float NOT NULL,
  `motivo` varchar(200) NOT NULL,
  `id_usuario` int(11) NOT NULL COMMENT 'usuario que realizo la acción'
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(200) NOT NULL,
  `clave` varchar(200) NOT NULL,
  `correo` varchar(200) NOT NULL,
  `estado` tinyint(1) DEFAULT 0 COMMENT '0 = usuario inactivo, 1 = usuario activo',
  `admin` tinyint(1) DEFAULT 0 COMMENT '0 = no es admin, 1 = es admin'
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `despacho_plato`
--
ALTER TABLE `despacho_plato`
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indexes for table `equipamientos`
--
ALTER TABLE `equipamientos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `equipamiento_plato`
--
ALTER TABLE `equipamiento_plato`
  ADD KEY `id_equipamiento` (`id_equipamiento`);

--
-- Indexes for table `ingredientes_plato`
--
ALTER TABLE `ingredientes_plato`
  ADD KEY `id_materia_prima` (`id_materia_prima`);

--
-- Indexes for table `ingreso_materia_prima`
--
ALTER TABLE `ingreso_materia_prima`
  ADD KEY `id_materia_prima` (`id_materia_prima`);

--
-- Indexes for table `materia_prima`
--
ALTER TABLE `materia_prima`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `salida_materia_prima`
--
ALTER TABLE `salida_materia_prima`
  ADD KEY `id_materia_prima` (`id_materia_prima`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indexes for table `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `equipamientos`
--
ALTER TABLE `equipamientos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `materia_prima`
--
ALTER TABLE `materia_prima`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `despacho_plato`
--
ALTER TABLE `despacho_plato`
  ADD CONSTRAINT `despacho_plato_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`);

--
-- Constraints for table `equipamiento_plato`
--
ALTER TABLE `equipamiento_plato`
  ADD CONSTRAINT `equipamiento_plato_ibfk_1` FOREIGN KEY (`id_equipamiento`) REFERENCES `equipamientos` (`id`);

--
-- Constraints for table `ingredientes_plato`
--
ALTER TABLE `ingredientes_plato`
  ADD CONSTRAINT `ingredientes_plato_ibfk_1` FOREIGN KEY (`id_materia_prima`) REFERENCES `materia_prima` (`id`);

--
-- Constraints for table `ingreso_materia_prima`
--
ALTER TABLE `ingreso_materia_prima`
  ADD CONSTRAINT `ingreso_materia_prima_ibfk_1` FOREIGN KEY (`id_materia_prima`) REFERENCES `materia_prima` (`id`),
  ADD CONSTRAINT `ingreso_materia_prima_ibfk_2` FOREIGN KEY (`id_materia_prima`) REFERENCES `materia_prima` (`id`);

--
-- Constraints for table `salida_materia_prima`
--
ALTER TABLE `salida_materia_prima`
  ADD CONSTRAINT `salida_materia_prima_ibfk_1` FOREIGN KEY (`id_materia_prima`) REFERENCES `materia_prima` (`id`),
  ADD CONSTRAINT `salida_materia_prima_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`),
  ADD CONSTRAINT `salida_materia_prima_ibfk_3` FOREIGN KEY (`id_materia_prima`) REFERENCES `materia_prima` (`id`),
  ADD CONSTRAINT `salida_materia_prima_ibfk_4` FOREIGN KEY (`id_materia_prima`) REFERENCES `materia_prima` (`id`),
  ADD CONSTRAINT `salida_materia_prima_ibfk_5` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
