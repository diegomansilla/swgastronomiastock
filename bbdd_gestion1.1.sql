-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 11, 2025 at 06:47 PM
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
-- Database: `bbdd_gestion1`
--

-- --------------------------------------------------------

--
-- Table structure for table `despacho_plato`
--

CREATE TABLE `despacho_plato` (
  `id` int(11) NOT NULL,
  `id_salida_materia_prima` int(11) NOT NULL,
  `id_platos` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `cantidad_despachada` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ingredientes_plato`
--

CREATE TABLE `ingredientes_plato` (
  `id_plato` int(11) NOT NULL,
  `id_materia_prima` int(50) NOT NULL
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

--
-- Dumping data for table `ingreso_materia_prima`
--

INSERT INTO `ingreso_materia_prima` (`id`, `id_materia_prima`, `fecha`, `cantidad`, `fecha_lote`, `fecha_vencimiento`) VALUES
(1, 2, '2025-08-05', 9, '2025-07-08', '2025-11-21'),
(2, 2, '2025-08-06', 2, '2025-09-02', '2025-08-01'),
(3, 3, '2025-08-06', 2, '0000-00-00', '2025-07-05');

-- --------------------------------------------------------

--
-- Table structure for table `materia_prima`
--

CREATE TABLE `materia_prima` (
  `id` int(11) NOT NULL,
  `codigo_barra` varchar(200) NOT NULL,
  `descripcion` varchar(200) NOT NULL,
  `contenido_neto` varchar(200) NOT NULL COMMENT 'unidad de medida',
  `marca` varchar(200) NOT NULL,
  `stock_minimo` double NOT NULL,
  `stock_maximo` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_general_ci;

--
-- Dumping data for table `materia_prima`
--

INSERT INTO `materia_prima` (`id`, `codigo_barra`, `descripcion`, `contenido_neto`, `marca`, `stock_minimo`, `stock_maximo`) VALUES
(2, '123412451123', 'Harina 0000', '500g', 'X', 10, 50),
(3, '123235325', 'Maple de huevos', '2kg', 'Huevo Feliz', 5, 20),
(4, '144325346363', 'Caja de tomate', '125g', 'Tomatito', 5, 15);

-- --------------------------------------------------------

--
-- Table structure for table `motivos`
--

CREATE TABLE `motivos` (
  `id` int(11) NOT NULL,
  `descripcion` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `platos`
--

CREATE TABLE `platos` (
  `id` int(11) NOT NULL,
  `descripcion` varchar(200) NOT NULL,
  `precio` float NOT NULL,
  `estado` int(11) NOT NULL DEFAULT 1 COMMENT '1 = activo, 0 = inactivo'
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `salida_materia_prima`
--

CREATE TABLE `salida_materia_prima` (
  `id` int(11) NOT NULL,
  `id_despacho_plato` int(11) NOT NULL,
  `id_motivo` int(11) DEFAULT NULL,
  `id_materia_prima` int(50) NOT NULL,
  `fecha` date NOT NULL
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
-- Dumping data for table `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `clave`, `correo`, `estado`, `admin`) VALUES
(1, 'Alesio', '1234', 'alesio577@gmail.com', 1, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `despacho_plato`
--
ALTER TABLE `despacho_plato`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_salida_materia_prima` (`id_salida_materia_prima`);

--
-- Indexes for table `ingredientes_plato`
--
ALTER TABLE `ingredientes_plato`
  ADD PRIMARY KEY (`id_plato`),
  ADD KEY `id_materia_prima` (`id_materia_prima`);

--
-- Indexes for table `ingreso_materia_prima`
--
ALTER TABLE `ingreso_materia_prima`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_materia_prima` (`id_materia_prima`);

--
-- Indexes for table `materia_prima`
--
ALTER TABLE `materia_prima`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `motivos`
--
ALTER TABLE `motivos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `platos`
--
ALTER TABLE `platos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `salida_materia_prima`
--
ALTER TABLE `salida_materia_prima`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_materia_prima` (`id_materia_prima`),
  ADD KEY `id_motivo` (`id_motivo`);

--
-- Indexes for table `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `despacho_plato`
--
ALTER TABLE `despacho_plato`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ingredientes_plato`
--
ALTER TABLE `ingredientes_plato`
  MODIFY `id_plato` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ingreso_materia_prima`
--
ALTER TABLE `ingreso_materia_prima`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `materia_prima`
--
ALTER TABLE `materia_prima`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `motivos`
--
ALTER TABLE `motivos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `platos`
--
ALTER TABLE `platos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `salida_materia_prima`
--
ALTER TABLE `salida_materia_prima`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `despacho_plato`
--
ALTER TABLE `despacho_plato`
  ADD CONSTRAINT `despacho_plato_ibfk_2` FOREIGN KEY (`id_salida_materia_prima`) REFERENCES `salida_materia_prima` (`id`);

--
-- Constraints for table `ingredientes_plato`
--
ALTER TABLE `ingredientes_plato`
  ADD CONSTRAINT `ingredientes_plato_ibfk_1` FOREIGN KEY (`id_materia_prima`) REFERENCES `materia_prima` (`id`);

--
-- Constraints for table `ingreso_materia_prima`
--
ALTER TABLE `ingreso_materia_prima`
  ADD CONSTRAINT `ingreso_materia_prima_ibfk_1` FOREIGN KEY (`id_materia_prima`) REFERENCES `materia_prima` (`id`);

--
-- Constraints for table `salida_materia_prima`
--
ALTER TABLE `salida_materia_prima`
  ADD CONSTRAINT `salida_materia_prima_ibfk_1` FOREIGN KEY (`id_materia_prima`) REFERENCES `materia_prima` (`id`),
  ADD CONSTRAINT `salida_materia_prima_ibfk_6` FOREIGN KEY (`id_motivo`) REFERENCES `motivos` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
