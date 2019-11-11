-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 11, 2019 at 02:57 PM
-- Server version: 10.1.37-MariaDB
-- PHP Version: 7.1.25

CREATE DATABASE restaurante
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `restaurante`
--

-- --------------------------------------------------------

--
-- Table structure for table `encargados`
--

CREATE TABLE `encargados` (
  `id` int(11) NOT NULL,
  `nombre` varchar(60) COLLATE utf8_spanish2_ci NOT NULL,
  `idRol` int(2) NOT NULL,
  `clave` varchar(60) COLLATE utf8_spanish2_ci NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Dumping data for table `encargados`
--

INSERT INTO `encargados` (`id`, `nombre`, `idRol`, `clave`, `updated_at`, `created_at`) VALUES
(1, 'Damian', 3, '1234', '2019-11-09 19:16:41', '2019-11-09 19:16:41'),
(2, 'Juan', 1, '1234', '2019-11-09 19:18:26', '2019-11-09 19:18:26'),
(3, 'Pepe', 2, '1234', '2019-11-09 19:18:37', '2019-11-09 19:18:37'),
(4, 'Lorenzo', 4, '1234', '2019-11-09 19:18:47', '2019-11-09 19:18:47'),
(5, 'Leandro', 5, '1234', '2019-11-09 19:18:55', '2019-11-09 19:18:55');

-- --------------------------------------------------------

--
-- Table structure for table `estados_mesa`
--

CREATE TABLE `estados_mesa` (
  `id` int(11) NOT NULL,
  `descripcion` varchar(40) COLLATE utf8_spanish2_ci NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Dumping data for table `estados_mesa`
--

INSERT INTO `estados_mesa` (`id`, `descripcion`, `updated_at`, `created_at`) VALUES
(1, 'con cliente esperando', '2019-11-09 19:20:31', '2019-11-09 19:20:31'),
(2, 'con clientes comiendo', '2019-11-09 19:22:03', '2019-11-09 19:22:03'),
(3, 'con clientes pagando', '2019-11-09 19:23:13', '2019-11-09 19:23:13'),
(4, 'cerrada', '2019-11-09 19:23:23', '2019-11-09 19:23:23');

-- --------------------------------------------------------

--
-- Table structure for table `estados_pedidos`
--

CREATE TABLE `estados_pedidos` (
  `id` int(11) NOT NULL,
  `descripcion` varchar(20) COLLATE utf8_spanish2_ci NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Dumping data for table `estados_pedidos`
--

INSERT INTO `estados_pedidos` (`id`, `descripcion`, `updated_at`, `created_at`) VALUES
(1, 'en preparacion', '2019-11-09 19:29:48', '2019-11-09 19:29:48'),
(2, 'listo para servir', '2019-11-09 19:30:16', '2019-11-09 19:30:16');

-- --------------------------------------------------------

--
-- Table structure for table `estados_productos`
--

CREATE TABLE `estados_productos` (
  `id` int(11) NOT NULL,
  `descripcion` varchar(20) COLLATE utf8_spanish2_ci NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Dumping data for table `estados_productos`
--

INSERT INTO `estados_productos` (`id`, `descripcion`, `updated_at`, `created_at`) VALUES
(1, 'pendiente', '2019-11-09 19:24:39', '2019-11-09 19:24:39'),
(2, 'en preparacion', '2019-11-09 19:24:55', '2019-11-09 19:24:55'),
(3, 'listo para serv', '2019-11-09 19:25:23', '2019-11-09 19:25:23');

-- --------------------------------------------------------

--
-- Table structure for table `mesas`
--

CREATE TABLE `mesas` (
  `id` int(11) NOT NULL,
  `codigoMesa` varchar(60) COLLATE utf8_spanish2_ci NOT NULL,
  `idEstadoMesa` int(2) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Dumping data for table `mesas`
--

INSERT INTO `mesas` (`id`, `codigoMesa`, `idEstadoMesa`, `updated_at`, `created_at`) VALUES
(1, 'MESA1', 4, '2019-11-09 19:48:16', '2019-11-09 19:48:16'),
(2, 'MESA2', 4, '2019-11-09 19:48:22', '2019-11-09 19:48:22'),
(4, 'MESA3', 4, '2019-11-09 19:48:37', '2019-11-09 19:48:37'),
(5, 'MESA4', 4, '2019-11-09 19:48:41', '2019-11-09 19:48:41');

-- --------------------------------------------------------

--
-- Table structure for table `pedidos`
--

CREATE TABLE `pedidos` (
  `id` int(11) NOT NULL,
  `idEstadoPedido` int(2) NOT NULL,
  `codigoMesa` varchar(20) COLLATE utf8_spanish2_ci NOT NULL,
  `idEncargado` int(2) NOT NULL,
  `productos` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `nombreCliente` varchar(40) COLLATE utf8_spanish2_ci NOT NULL,
  `imagen` varchar(200) COLLATE utf8_spanish2_ci NOT NULL,
  `tiempo` int(4) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Table structure for table `productos`
--

CREATE TABLE `productos` (
  `id` int(11) NOT NULL,
  `descripcion` varchar(60) COLLATE utf8_spanish2_ci NOT NULL,
  `precio` int(10) NOT NULL,
  `idRol` int(11) NOT NULL,
  `tiempoPreparacion` int(11) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Dumping data for table `productos`
--

INSERT INTO `productos` (`id`, `descripcion`, `precio`, `idRol`, `tiempoPreparacion`, `updated_at`, `created_at`) VALUES
(1, 'Coca Cola', 90, 5, 1, '2019-11-09 19:53:01', '2019-11-09 19:53:01'),
(2, 'Sprite', 90, 5, 1, '2019-11-09 19:53:10', '2019-11-09 19:53:10'),
(3, 'Aquarius', 90, 5, 1, '2019-11-09 19:53:19', '2019-11-09 19:53:19'),
(4, 'Cafe', 110, 5, 3, '2019-11-09 19:53:46', '2019-11-09 19:53:46'),
(5, 'Te', 100, 5, 3, '2019-11-09 19:54:01', '2019-11-09 19:54:01'),
(6, 'Agua', 90, 5, 1, '2019-11-09 19:54:14', '2019-11-09 19:54:14'),
(7, 'Milanesa con papas fritas', 280, 1, 1, '2019-11-09 19:55:28', '2019-11-09 19:55:28'),
(8, 'Bife de lomo con verduras', 300, 1, 1, '2019-11-09 19:55:56', '2019-11-09 19:55:56'),
(9, 'Pulpo a la gallega', 1700, 1, 1, '2019-11-09 19:56:10', '2019-11-09 19:56:10'),
(10, 'Pollo para dos', 480, 1, 1, '2019-11-09 19:56:58', '2019-11-09 19:56:58'),
(11, 'Vino tinto', 300, 4, 3, '2019-11-09 19:58:36', '2019-11-09 19:58:36'),
(12, 'Vino blanco', 300, 4, 3, '2019-11-09 19:58:42', '2019-11-09 19:58:42'),
(13, 'Mojito', 300, 4, 3, '2019-11-09 19:59:22', '2019-11-09 19:59:22'),
(14, 'Esperma de Pitufo', 300, 4, 3, '2019-11-09 19:59:41', '2019-11-09 19:59:41'),
(15, 'Cerveza', 150, 2, 3, '2019-11-09 20:00:12', '2019-11-09 20:00:12'),
(16, 'Rabas', 220, 1, 30, '2019-11-09 20:03:55', '2019-11-09 20:03:55');

-- --------------------------------------------------------

--
-- Table structure for table `productos_pedidos`
--

CREATE TABLE `productos_pedidos` (
  `idPedido` int(11) NOT NULL,
  `idProducto` int(11) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `cargo` varchar(20) COLLATE utf8_spanish2_ci NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `cargo`, `updated_at`, `created_at`) VALUES
(1, 'cocinero', '2019-11-09 19:50:01', '2019-11-09 19:50:01'),
(2, 'cervecero', '2019-11-09 19:50:17', '2019-11-09 19:50:17'),
(3, 'socio', '2019-11-09 19:50:22', '2019-11-09 19:50:22'),
(4, 'bartender', '2019-11-09 19:50:46', '2019-11-09 19:50:46'),
(5, 'mozo', '2019-11-09 19:50:54', '2019-11-09 19:50:54');

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

CREATE TABLE `tickets` (
  `id` int(11) NOT NULL,
  `precioTotal` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `encargados`
--
ALTER TABLE `encargados`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `estados_mesa`
--
ALTER TABLE `estados_mesa`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `estados_pedidos`
--
ALTER TABLE `estados_pedidos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `estados_productos`
--
ALTER TABLE `estados_productos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mesas`
--
ALTER TABLE `mesas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `encargados`
--
ALTER TABLE `encargados`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `estados_mesa`
--
ALTER TABLE `estados_mesa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `estados_pedidos`
--
ALTER TABLE `estados_pedidos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `estados_productos`
--
ALTER TABLE `estados_productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `mesas`
--
ALTER TABLE `mesas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
