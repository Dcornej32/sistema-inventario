-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 25-06-2022 a las 05:48:54
-- Versión del servidor: 10.4.22-MariaDB
-- Versión de PHP: 7.4.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `dbinventario`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `acciones`
--

CREATE TABLE `acciones` (
  `id` int(11) NOT NULL,
  `usuario` varchar(100) NOT NULL,
  `fecha_cambio` date NOT NULL,
  `cambio` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `acciones`
--

INSERT INTO `acciones` (`id`, `usuario`, `fecha_cambio`, `cambio`) VALUES
(1, 'root@localhost', '2022-06-24', 'Actualización del registro de un usuario.');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` varchar(256) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `condicion` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Disparadores `categorias`
--
DELIMITER $$
CREATE TRIGGER `Actualizar_Categoria` AFTER UPDATE ON `categorias` FOR EACH ROW BEGIN
INSERT into acciones (usuario, fecha_cambio,cambio) VALUES
(CURRENT_USER(),CURDATE(),"Actualización de un registro de categoría");
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `tr_InsertarCategoria` AFTER INSERT ON `categorias` FOR EACH ROW BEGIN
INSERT into acciones (usuario, fecha_cambio,cambio) VALUES
(CURRENT_USER(),CURDATE(),"Insercion de una nueva categoría");
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_entradas`
--

CREATE TABLE `detalle_entradas` (
  `id` int(10) UNSIGNED NOT NULL,
  `identradas` int(10) UNSIGNED NOT NULL,
  `idproductos` int(10) UNSIGNED NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_compra` decimal(11,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Disparadores `detalle_entradas`
--
DELIMITER $$
CREATE TRIGGER `tr_updStockEntrada` AFTER INSERT ON `detalle_entradas` FOR EACH ROW BEGIN
UPDATE productos SET stock = stock + NEW.cantidad
WHERE productos.id = NEW.idproductos;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_salidas`
--

CREATE TABLE `detalle_salidas` (
  `id` int(10) UNSIGNED NOT NULL,
  `idsalidas` int(10) UNSIGNED NOT NULL,
  `idproductos` int(10) UNSIGNED NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_actual` decimal(11,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Disparadores `detalle_salidas`
--
DELIMITER $$
CREATE TRIGGER `tr_updStockSalida` AFTER INSERT ON `detalle_salidas` FOR EACH ROW BEGIN
UPDATE productos SET stock = stock - NEW.cantidad
WHERE productos.id = NEW.idproductos;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `entradas`
--

CREATE TABLE `entradas` (
  `id` int(10) UNSIGNED NOT NULL,
  `idproveedores` int(10) UNSIGNED NOT NULL,
  `idusuarios` int(10) UNSIGNED NOT NULL,
  `fecha_entrada` date NOT NULL,
  `total_compra` decimal(11,2) NOT NULL,
  `condicion` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Disparadores `entradas`
--
DELIMITER $$
CREATE TRIGGER `Actualizar_Entrada` AFTER UPDATE ON `entradas` FOR EACH ROW BEGIN
INSERT into acciones (usuario, fecha_cambio,cambio) VALUES
(CURRENT_USER(),CURDATE(),"Actualización del estado del registro de entrada.");
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `Insertar_Entrada` AFTER UPDATE ON `entradas` FOR EACH ROW BEGIN
INSERT into acciones (usuario, fecha_cambio,cambio) VALUES
(CURRENT_USER(),CURDATE(),"Inserción de una nueva entrada de productos.");
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `tr_updStockEntradaAnular` AFTER UPDATE ON `entradas` FOR EACH ROW BEGIN
UPDATE productos p
JOIN detalle_entradas de
ON de.idproductos = p.id
AND de.identradas = new.id
set p.stock = p.stock - de.cantidad;
end
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `informaciones`
--

CREATE TABLE `informaciones` (
  `id` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `direccion` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telefono` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `numero_tributario` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `numero_registro` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `giro` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nombre_contacto` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telefono_contacto` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cargo` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `informaciones`
--

INSERT INTO `informaciones` (`id`, `nombre`, `direccion`, `email`, `telefono`, `numero_tributario`, `numero_registro`, `giro`, `nombre_contacto`, `telefono_contacto`, `cargo`, `created_at`, `updated_at`) VALUES
(1, 'Tienda Variedades(SJ)', 'San Jacinto, San Salvador', 'variedades@gmail.com', '77895467', '', '', 'Cereales-Bebidas', 'Sandra Amelia Sandoval Linares', '71234567', 'Vendedora', NULL, NULL);

--
-- Disparadores `informaciones`
--
DELIMITER $$
CREATE TRIGGER `Actualizar_Informacion` AFTER UPDATE ON `informaciones` FOR EACH ROW BEGIN
INSERT into acciones (usuario, fecha_cambio,cambio) VALUES
(CURRENT_USER(),CURDATE(),"Actualización de la información de la empresa.");
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_100000_create_password_resets_table', 1),
(2, '2022_04_20_034415_create_categorias_table', 1),
(3, '2022_04_23_011733_create_productos_table', 1),
(4, '2022_04_28_034555_create_personas_table', 1),
(5, '2022_04_28_043335_create_proveedores_table', 1),
(6, '2022_05_03_045924_create_roles_table', 1),
(7, '2022_05_04_000000_create_users_table', 1),
(8, '2022_05_05_021522_create_informaciones_table', 1),
(9, '2022_05_15_223637_create_entradas_table', 1),
(10, '2022_05_15_224012_create_detalle_entradas_table', 1),
(11, '2022_05_17_205959_create_salidas_table', 1),
(12, '2022_05_17_210028_create_detalle_salidas_table', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personas`
--

CREATE TABLE `personas` (
  `id` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tipo_documento` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `numero_documento` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `direccion` varchar(256) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telefono` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `condicion` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `personas`
--

INSERT INTO `personas` (`id`, `nombre`, `tipo_documento`, `numero_documento`, `direccion`, `telefono`, `email`, `condicion`, `created_at`, `updated_at`) VALUES
(1, 'Administrador', '', '', '', '', '', 1, NULL, NULL);

--
-- Disparadores `personas`
--
DELIMITER $$
CREATE TRIGGER `Actualizar_Personas` AFTER INSERT ON `personas` FOR EACH ROW BEGIN
INSERT into acciones (usuario, fecha_cambio,cambio) VALUES
(CURRENT_USER(),CURDATE(),"Actualización en la tabla de persona.");
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `Insertar_Personas` AFTER INSERT ON `personas` FOR EACH ROW BEGIN
INSERT into acciones (usuario, fecha_cambio,cambio) VALUES
(CURRENT_USER(),CURDATE(),"Inserción de un nuevo registro de persona.");
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int(10) UNSIGNED NOT NULL,
  `codigo` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombre` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `precio_actual` decimal(11,2) NOT NULL,
  `stock` int(11) NOT NULL,
  `descripcion` varchar(256) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `condicion` tinyint(1) NOT NULL DEFAULT 1,
  `idcategorias` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Disparadores `productos`
--
DELIMITER $$
CREATE TRIGGER `Actualizar_Producto` AFTER UPDATE ON `productos` FOR EACH ROW BEGIN
INSERT into acciones (usuario, fecha_cambio,cambio) VALUES
(CURRENT_USER(),CURDATE(),"Actualización de un registro de Producto");
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `Insertar_Producto` AFTER INSERT ON `productos` FOR EACH ROW BEGIN
INSERT into acciones (usuario, fecha_cambio,cambio) VALUES
(CURRENT_USER(),CURDATE(),"Inserción de un registro de Producto");
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedores`
--

CREATE TABLE `proveedores` (
  `id` int(10) UNSIGNED NOT NULL,
  `nombre_contacto` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telefono_contacto` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `condicion` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Disparadores `proveedores`
--
DELIMITER $$
CREATE TRIGGER `Actualizar_Proveedores` AFTER UPDATE ON `proveedores` FOR EACH ROW BEGIN
INSERT into acciones (usuario, fecha_cambio,cambio) VALUES
(CURRENT_USER(),CURDATE(),"Actualización de un registro de proveedor.");
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `Insertar_Proveedores` AFTER INSERT ON `proveedores` FOR EACH ROW BEGIN
INSERT into acciones (usuario, fecha_cambio,cambio) VALUES
(CURRENT_USER(),CURDATE(),"Inserción de un nuevo proveedor.");END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `condicion` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id`, `nombre`, `descripcion`, `condicion`, `created_at`, `updated_at`) VALUES
(1, 'Administrador', 'Administrador del sistema', 1, NULL, NULL),
(2, 'Almacenero', 'Almacenero del sistema', 1, NULL, NULL);

--
-- Disparadores `roles`
--
DELIMITER $$
CREATE TRIGGER `Actualizar_Rol` AFTER UPDATE ON `roles` FOR EACH ROW BEGIN
INSERT into acciones (usuario, fecha_cambio,cambio) VALUES
(CURRENT_USER(),CURDATE(),"Actualización de la información de los roles.");
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `salidas`
--

CREATE TABLE `salidas` (
  `id` int(10) UNSIGNED NOT NULL,
  `idclientes` int(10) UNSIGNED NOT NULL,
  `idusuarios` int(10) UNSIGNED NOT NULL,
  `fecha_salida` date NOT NULL,
  `total` decimal(11,2) NOT NULL,
  `condicion` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Disparadores `salidas`
--
DELIMITER $$
CREATE TRIGGER `Actualizar_Salida` AFTER UPDATE ON `salidas` FOR EACH ROW BEGIN
INSERT into acciones (usuario, fecha_cambio,cambio) VALUES
(CURRENT_USER(),CURDATE(),"Actualización del estado del registro de salida.");
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `Insertar_Salida` AFTER UPDATE ON `salidas` FOR EACH ROW BEGIN
INSERT into acciones (usuario, fecha_cambio,cambio) VALUES
(CURRENT_USER(),CURDATE(),"Inserción de un nuevo registro de salida de productos");
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `tr_updStockSalidaAnular` AFTER UPDATE ON `salidas` FOR EACH ROW BEGIN
UPDATE productos p
JOIN detalle_salidas ds
ON ds.idproductos = p.id
AND ds.idsalidas= new.id
set p.stock = p.stock + ds.cantidad;
end
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `usuario` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `condicion` tinyint(1) NOT NULL DEFAULT 1,
  `idrol` int(10) UNSIGNED NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `usuario`, `password`, `condicion`, `idrol`, `remember_token`) VALUES
(1, 'administrador', '$2y$10$H8v7yYZImp8T5H35DdkHUueMq7bxFqsbbANYajQ/f.49fCMLpdnpO', 1, 1, 'NSCelwaKrZVHtaSghi9dbcqdnShvCvt2wDItfw48GFZqN29jM0jedEtX0JBW');

--
-- Disparadores `users`
--
DELIMITER $$
CREATE TRIGGER `Actualizar_Usuario` AFTER UPDATE ON `users` FOR EACH ROW BEGIN
INSERT into acciones (usuario, fecha_cambio,cambio) VALUES
(CURRENT_USER(),CURDATE(),"Actualización del registro de un usuario.");
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `Insertar_Usuario` AFTER INSERT ON `users` FOR EACH ROW BEGIN
INSERT into acciones (usuario, fecha_cambio,cambio) VALUES
(CURRENT_USER(),CURDATE(),"Inserción de un nuevo registro de usuario.");
END
$$
DELIMITER ;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `acciones`
--
ALTER TABLE `acciones`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `detalle_entradas`
--
ALTER TABLE `detalle_entradas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `detalle_entradas_identradas_foreign` (`identradas`),
  ADD KEY `detalle_entradas_idproductos_foreign` (`idproductos`);

--
-- Indices de la tabla `detalle_salidas`
--
ALTER TABLE `detalle_salidas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `detalle_salidas_idsalidas_foreign` (`idsalidas`),
  ADD KEY `detalle_salidas_idproductos_foreign` (`idproductos`);

--
-- Indices de la tabla `entradas`
--
ALTER TABLE `entradas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `entradas_idproveedores_foreign` (`idproveedores`),
  ADD KEY `entradas_idusuarios_foreign` (`idusuarios`);

--
-- Indices de la tabla `informaciones`
--
ALTER TABLE `informaciones`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indices de la tabla `personas`
--
ALTER TABLE `personas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `productos_codigo_unique` (`codigo`),
  ADD KEY `productos_idcategorias_foreign` (`idcategorias`);

--
-- Indices de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  ADD KEY `proveedores_id_foreign` (`id`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_nombre_unique` (`nombre`);

--
-- Indices de la tabla `salidas`
--
ALTER TABLE `salidas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `salidas_idclientes_foreign` (`idclientes`),
  ADD KEY `salidas_idusuarios_foreign` (`idusuarios`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD UNIQUE KEY `users_usuario_unique` (`usuario`),
  ADD KEY `users_id_foreign` (`id`),
  ADD KEY `users_idrol_foreign` (`idrol`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `acciones`
--
ALTER TABLE `acciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `detalle_entradas`
--
ALTER TABLE `detalle_entradas`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `detalle_salidas`
--
ALTER TABLE `detalle_salidas`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `entradas`
--
ALTER TABLE `entradas`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `informaciones`
--
ALTER TABLE `informaciones`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `personas`
--
ALTER TABLE `personas`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `salidas`
--
ALTER TABLE `salidas`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `detalle_entradas`
--
ALTER TABLE `detalle_entradas`
  ADD CONSTRAINT `detalle_entradas_identradas_foreign` FOREIGN KEY (`identradas`) REFERENCES `entradas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `detalle_entradas_idproductos_foreign` FOREIGN KEY (`idproductos`) REFERENCES `productos` (`id`);

--
-- Filtros para la tabla `detalle_salidas`
--
ALTER TABLE `detalle_salidas`
  ADD CONSTRAINT `detalle_salidas_idproductos_foreign` FOREIGN KEY (`idproductos`) REFERENCES `productos` (`id`),
  ADD CONSTRAINT `detalle_salidas_idsalidas_foreign` FOREIGN KEY (`idsalidas`) REFERENCES `salidas` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `entradas`
--
ALTER TABLE `entradas`
  ADD CONSTRAINT `entradas_idproveedores_foreign` FOREIGN KEY (`idproveedores`) REFERENCES `proveedores` (`id`),
  ADD CONSTRAINT `entradas_idusuarios_foreign` FOREIGN KEY (`idusuarios`) REFERENCES `users` (`id`);

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `productos_idcategorias_foreign` FOREIGN KEY (`idcategorias`) REFERENCES `categorias` (`id`);

--
-- Filtros para la tabla `proveedores`
--
ALTER TABLE `proveedores`
  ADD CONSTRAINT `proveedores_id_foreign` FOREIGN KEY (`id`) REFERENCES `personas` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `salidas`
--
ALTER TABLE `salidas`
  ADD CONSTRAINT `salidas_idclientes_foreign` FOREIGN KEY (`idclientes`) REFERENCES `personas` (`id`),
  ADD CONSTRAINT `salidas_idusuarios_foreign` FOREIGN KEY (`idusuarios`) REFERENCES `users` (`id`);

--
-- Filtros para la tabla `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_id_foreign` FOREIGN KEY (`id`) REFERENCES `personas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `users_idrol_foreign` FOREIGN KEY (`idrol`) REFERENCES `roles` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
