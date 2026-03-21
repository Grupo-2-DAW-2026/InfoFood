-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 21-03-2026 a las 20:09:46
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `el_pozo_db`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alergenos`
--

CREATE TABLE `alergenos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `icono` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `alergenos`
--

INSERT INTO `alergenos` (`id`, `nombre`, `icono`, `created_at`, `updated_at`) VALUES
(1, 'Gluten', NULL, '2026-03-18 15:22:42', '2026-03-18 15:22:42'),
(2, 'Crustáceos', NULL, '2026-03-18 15:22:42', '2026-03-18 15:22:42'),
(3, 'Huevos', NULL, '2026-03-18 15:22:42', '2026-03-18 15:22:42'),
(4, 'Pescado', NULL, '2026-03-18 15:22:42', '2026-03-18 15:22:42'),
(5, 'Cacahuetes', NULL, '2026-03-18 15:22:42', '2026-03-18 15:22:42'),
(6, 'Soja', NULL, '2026-03-18 15:22:42', '2026-03-18 15:22:42'),
(7, 'Lácteos', NULL, '2026-03-18 15:22:42', '2026-03-18 15:22:42'),
(8, 'Frutos de cáscara', NULL, '2026-03-18 15:22:42', '2026-03-18 15:22:42'),
(9, 'Apio', NULL, '2026-03-18 15:22:42', '2026-03-18 15:22:42'),
(10, 'Mostaza', NULL, '2026-03-18 15:22:42', '2026-03-18 15:22:42'),
(11, 'Sésamo', NULL, '2026-03-18 15:22:42', '2026-03-18 15:22:42'),
(12, 'Sulfitos', NULL, '2026-03-18 15:22:42', '2026-03-18 15:22:42'),
(13, 'Altramuces', NULL, '2026-03-18 15:22:42', '2026-03-18 15:22:42'),
(14, 'Moluscos', NULL, '2026-03-18 15:22:42', '2026-03-18 15:22:42');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alergeno_producto`
--

CREATE TABLE `alergeno_producto` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `producto_id` bigint(20) UNSIGNED NOT NULL,
  `alergeno_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `alergeno_producto`
--

INSERT INTO `alergeno_producto` (`id`, `producto_id`, `alergeno_id`) VALUES
(1, 6, 2),
(2, 6, 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ingredientes`
--

CREATE TABLE `ingredientes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `producto_id` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `ingredientes`
--

INSERT INTO `ingredientes` (`id`, `producto_id`, `nombre`, `created_at`, `updated_at`) VALUES
(3, 6, 'Jamón de cerdo (92%), agua, sal, aroma de humo, estabilizantes: E-407, E-451 y E-420, antioxidantes: E-316 y E-331, conservador: E-250 Puede contener trazas de proteína de leche y soja.', '2026-03-18 15:24:24', '2026-03-18 15:24:24');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_03_17_202802_create_productos_table', 1),
(5, '2026_03_17_203031_create_alergenos_table', 1),
(6, '2026_03_17_204113_create_valor_nutricionals_table', 1),
(7, '2026_03_17_204141_create_ingredientes_table', 1),
(8, '2026_03_17_204422_create_trazabilidad_pasos_table', 1),
(9, '2026_03_17_204532_create_alergeno_producto_table', 1),
(10, '2026_03_18_122718_add_user_id_to_productos_table', 2),
(11, '2026_03_18_162719_create_producto_user_historial_table', 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `ean_13` varchar(255) NOT NULL,
  `imagen_url` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `nombre`, `ean_13`, `imagen_url`, `created_at`, `updated_at`, `user_id`) VALUES
(6, 'Jamón Cocido Calidad Extra', '8410843144007', 'https://images.openfoodfacts.org/images/products/841/084/314/4007/front_es.51.400.jpg', '2026-03-18 15:24:24', '2026-03-18 15:24:24', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto_user_historial`
--

CREATE TABLE `producto_user_historial` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `producto_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `producto_user_historial`
--

INSERT INTO `producto_user_historial` (`id`, `user_id`, `producto_id`, `created_at`, `updated_at`) VALUES
(9, 4, 6, NULL, NULL),
(10, 5, 6, NULL, NULL),
(11, 6, 6, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('DbFRHC9Shk9XWdMsZLw1wKEX1iA7iQEEQIQBNCHz', 5, '127.0.0.1', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_7 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.2 Mobile/15E148 Safari/604.1', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiYW9QRUJPbnM1UjlLM1hWSmxiYXYwM0hZSEF5VW9CSXZMYjVVWXU0aiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NjU6Imh0dHA6Ly8wY2EyLTgyLTIxMy0yMDItMTIzLm5ncm9rLWZyZWUuYXBwL3Byb2R1Y3Rvcy9udWV2b1Byb2R1Y3RvIjtzOjU6InJvdXRlIjtzOjE0OiJwcm9kdWN0b3Muc2hvdyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6MzoidXJsIjthOjA6e31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aTo1O30=', 1774114496),
('F4IQ02DG7N03irISPJgvhoaPxB8giWTwMfvpETMq', NULL, '127.0.0.1', 'WhatsApp/2.23.20.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiWGI1WE1VcTRwNXpyRXVTSDZ2VFJvVjNjNzVGRTFETUt2TGJSYmdodyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDE6Imh0dHA6Ly8wY2EyLTgyLTIxMy0yMDItMTIzLm5ncm9rLWZyZWUuYXBwIjtzOjU6InJvdXRlIjtzOjc6IndlbGNvbWUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1774114303),
('Rl1P1koFq5yLbPce0DzOxHHNkzLcEkAAzwgIt3u0', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiZWpuWE9qS3Joa2xBaUp4Q1J1dnBoRVowOVdCcnJPRUpKSzhQbmU3dCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7czo1OiJyb3V0ZSI7czo3OiJ3ZWxjb21lIjt9fQ==', 1774119987);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `trazabilidad_pasos`
--

CREATE TABLE `trazabilidad_pasos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `producto_id` bigint(20) UNSIGNED NOT NULL,
  `orden` int(11) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `descripcion` text NOT NULL,
  `fecha_proceso` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `trazabilidad_pasos`
--

INSERT INTO `trazabilidad_pasos` (`id`, `producto_id`, `orden`, `titulo`, `descripcion`, `fecha_proceso`, `created_at`, `updated_at`) VALUES
(4, 6, 1, 'Origen y Envasado', 'Producido en: El Pozo. Lote: ES 10.01672/MU CE', '2026-03-04', '2026-03-18 15:24:24', '2026-03-18 15:24:24');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'user',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Álvaro Galera', 'alvarogaleraboluda777@gmail.com', NULL, '$2y$12$Fe9t9nl3YhWWDFjUyHbPCOCUnUIMu1xSDdUdzGo1OTBPviFjL121q', 'admin', '3E6vuHIQZEpo9XxnX5FNbDjyvpP2M9Ok2DSkyjfPRDD5S4LGG4bLmzG5uJF9', '2026-03-17 22:13:14', '2026-03-17 22:26:15'),
(3, 'Juan Fernando', 'juanfernandogt06@gmail.com', NULL, '$2y$12$XVU5bIjpuYOroipZ5LiEEuKKBk9pUpOd1fp8RgqjeUBt1POp8yIaG', 'user', NULL, '2026-03-18 12:11:45', '2026-03-18 12:11:45'),
(4, 'Fran Asensio', 'franase@gmail.com', NULL, '$2y$12$fQ.w4aikS4QzvolklSDfNu9YzspqusXu2fC0LAop.Ykl4lgg1Ikca', 'user', NULL, '2026-03-18 17:01:23', '2026-03-18 17:01:53'),
(5, 'Usuario', 'usuario@gmail.com', NULL, '$2y$12$WI5ElpPajZ/Qdoebi7mQ6.2AS4t6nD5qXf72.kHIdRGhKweciQy66', 'user', NULL, '2026-03-18 17:13:45', '2026-03-18 17:13:45'),
(6, 'Admin', 'admin@gmail.com', NULL, '$2y$12$a4c403qZmYMYin3rIRBhneixJ4kMzc7nUYSDTGI8WJ5koqF.w8a8S', 'admin', NULL, '2026-03-18 17:14:16', '2026-03-18 17:14:16');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `valores_nutricionales`
--

CREATE TABLE `valores_nutricionales` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `producto_id` bigint(20) UNSIGNED NOT NULL,
  `kcal` varchar(255) NOT NULL,
  `grasas_totales` varchar(255) NOT NULL,
  `grasas_saturadas` varchar(255) NOT NULL,
  `hidratos` varchar(255) NOT NULL,
  `azucares` varchar(255) NOT NULL,
  `proteinas` varchar(255) NOT NULL,
  `sal` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `valores_nutricionales`
--

INSERT INTO `valores_nutricionales` (`id`, `producto_id`, `kcal`, `grasas_totales`, `grasas_saturadas`, `hidratos`, `azucares`, `proteinas`, `sal`, `created_at`, `updated_at`) VALUES
(3, 6, '111', '3.5', '1.2', '0.5', '0.5', '19.4', '1.86', '2026-03-18 15:24:24', '2026-03-18 15:24:24');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `alergenos`
--
ALTER TABLE `alergenos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `alergeno_producto`
--
ALTER TABLE `alergeno_producto`
  ADD PRIMARY KEY (`id`),
  ADD KEY `alergeno_producto_producto_id_foreign` (`producto_id`),
  ADD KEY `alergeno_producto_alergeno_id_foreign` (`alergeno_id`);

--
-- Indices de la tabla `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indices de la tabla `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indices de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indices de la tabla `ingredientes`
--
ALTER TABLE `ingredientes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ingredientes_producto_id_foreign` (`producto_id`);

--
-- Indices de la tabla `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indices de la tabla `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `productos_ean_13_unique` (`ean_13`),
  ADD KEY `productos_user_id_foreign` (`user_id`);

--
-- Indices de la tabla `producto_user_historial`
--
ALTER TABLE `producto_user_historial`
  ADD PRIMARY KEY (`id`),
  ADD KEY `producto_user_historial_user_id_foreign` (`user_id`),
  ADD KEY `producto_user_historial_producto_id_foreign` (`producto_id`);

--
-- Indices de la tabla `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indices de la tabla `trazabilidad_pasos`
--
ALTER TABLE `trazabilidad_pasos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `trazabilidad_pasos_producto_id_foreign` (`producto_id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indices de la tabla `valores_nutricionales`
--
ALTER TABLE `valores_nutricionales`
  ADD PRIMARY KEY (`id`),
  ADD KEY `valores_nutricionales_producto_id_foreign` (`producto_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `alergenos`
--
ALTER TABLE `alergenos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `alergeno_producto`
--
ALTER TABLE `alergeno_producto`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `ingredientes`
--
ALTER TABLE `ingredientes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `producto_user_historial`
--
ALTER TABLE `producto_user_historial`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `trazabilidad_pasos`
--
ALTER TABLE `trazabilidad_pasos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `valores_nutricionales`
--
ALTER TABLE `valores_nutricionales`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `alergeno_producto`
--
ALTER TABLE `alergeno_producto`
  ADD CONSTRAINT `alergeno_producto_alergeno_id_foreign` FOREIGN KEY (`alergeno_id`) REFERENCES `alergenos` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `alergeno_producto_producto_id_foreign` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `ingredientes`
--
ALTER TABLE `ingredientes`
  ADD CONSTRAINT `ingredientes_producto_id_foreign` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `productos_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `producto_user_historial`
--
ALTER TABLE `producto_user_historial`
  ADD CONSTRAINT `producto_user_historial_producto_id_foreign` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `producto_user_historial_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `trazabilidad_pasos`
--
ALTER TABLE `trazabilidad_pasos`
  ADD CONSTRAINT `trazabilidad_pasos_producto_id_foreign` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `valores_nutricionales`
--
ALTER TABLE `valores_nutricionales`
  ADD CONSTRAINT `valores_nutricionales_producto_id_foreign` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
