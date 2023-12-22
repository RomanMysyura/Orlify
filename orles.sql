-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 15-12-2023 a las 15:49:42
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `orles`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `errornotifications`
--

CREATE TABLE `errornotifications` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `status` varchar(250) DEFAULT 'pending',
  `date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `errornotifications`
--

INSERT INTO `errornotifications` (`id`, `user_id`, `description`, `status`, `date`) VALUES
(1, 3, 'dgdg', 'Resuelta', '2023-11-24 15:52:33'),
(2, 3, 'aaa', 'Resolta', '2023-11-24 15:54:30');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `groups`
--

CREATE TABLE `groups` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `groups`
--

INSERT INTO `groups` (`id`, `name`) VALUES
(1, '1 SMX'),
(2, '2 SMX'),
(3, '1 DAW'),
(4, '2 DAW'),
(5, '1 ESO'),
(6, '2 ESO'),
(7, '3 ESO'),
(8, '4 ESO'),
(9, '1 BAT'),
(10, '2 BAT');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `orla`
--

CREATE TABLE `orla` (
  `id` int(11) NOT NULL,
  `status` varchar(50) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `group_id` int(11) DEFAULT NULL,
  `name_orla` varchar(255) DEFAULT NULL,
  `users` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `orla`
--

INSERT INTO `orla` (`id`, `status`, `url`, `group_id`, `name_orla`, `users`) VALUES
(1, 'Privat', 'orla.png', 1, 'Orla per els alumnes', NULL),
(2, 'Privat', 'orla2.png', 1, 'Orla dels alumnes SMX', NULL),
(3, 'Public', '', 1, 'ORLA DE PROVES', NULL),
(75, 'Privat', NULL, 1, 'Orla 1 SMX', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `orla_users`
--

CREATE TABLE `orla_users` (
  `user_id` int(11) DEFAULT NULL,
  `orla_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `orla_users`
--

INSERT INTO `orla_users` (`user_id`, `orla_id`) VALUES
(1, 75),
(2, 75),
(3, 75),
(1, 1),
(1, 3),
(2, 3),
(3, 3),
(28, 3),
(1, 2),
(2, 2),
(3, 2),
(28, 2),
(32, 2),
(33, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `photo`
--

CREATE TABLE `photo` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `selected_photo` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `photo`
--

INSERT INTO `photo` (`id`, `name`, `url`, `user_id`, `selected_photo`) VALUES
(1, 'Emma Cardosa', './img/3.jpeg', 1, 'active'),
(4, 'Roman Mysyura', './img/4.jpeg', 3, 'active'),
(15, 'Enric Arboli', './img/3.jpeg', 32, 'active'),
(19, 'Tom Riddle', './img/4.jpeg', 28, 'inactive'),
(26, 'Dani Prados', 'img/image_65662bc491dab.png', 2, 'active'),
(38, 'Alex Winston', './img/5.jpeg', 33, 'active'),
(43, 'Jhon Cena', './img/6.jpeg', 39, 'active'),
(74, 'Lord Volandemort', 'img/image_6578751db8d9c.png', 36, 'active'),
(75, NULL, 'img/image_6579c4e8aa80a.png', 45, 'active'),
(76, NULL, 'img/image_657c6009efc53.png', 28, 'active');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `surname` varchar(255) DEFAULT NULL,
  `email` varchar(225) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `dni` varchar(15) DEFAULT NULL,
  `birth_date` date DEFAULT NULL,
  `role` varchar(50) DEFAULT NULL,
  `password` varchar(250) NOT NULL,
  `token` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `name`, `surname`, `email`, `phone`, `dni`, `birth_date`, `role`, `password`, `token`) VALUES
(1, 'Emmaa', 'Cardosa', 'emma@gmail.com', '123', '123', '2023-11-01', 'Alumne', '123', NULL),
(2, 'Danii', 'Prados', 'emma1@gmail.com', '', '', '2023-11-01', 'Alumne', '$2y$10$s5UE45MLNpHhAtT3D88gLekKYnwxbwPxTvkgs0gL./Z.yprwZVKXG', NULL),
(3, 'Roman', 'Mysyura', 'rmysyura@cendrassos.net', '11111', NULL, '2023-11-25', 'Professor', '$2y$10$rflrJruR4tWjcnYGz1rtO.IxoFfS16/ev3oDzBdLjqNsC4rZIhHTy', '6579bbd300687'),
(5, 'ousman', 'afasf', 'rmysyura2@cendrassos.net', '', '', '2023-11-27', 'Alumno', '$2y$10$P0Ch1qD.ggbVlltKMEN.GO7MO7fGFdtgDkqkbpI2LS.5v0Ju/.Ml6', NULL),
(6, 'Fatma', 'Okumuş', 'fatma.okumus@example.com', NULL, NULL, '1954-09-16', 'Alumne', '$2y$10$ss3jX9PW7zPvMSPVGfSieuAbkvVae2wrcfrgV1xSA9COfgIbsQ5Ca', NULL),
(7, 'client', 'abramovich', 'client@gmail.com', NULL, NULL, '2023-11-30', 'Alumne', '$2y$10$Yvro1/JauPvmx6NEQ3LXm.MaFpHqHc./sOf85vuxkXic9kByuXREm', NULL),
(27, 'dsgsdg', 'sdgsdg', 'teeestadfag@gmail', '23422', '23423', '2023-11-21', 'Alumne', '$2y$10$n1gns87T4XdyJvgvNN8sD.R3L2da174.4qtSTr/MNezO9L/FvYOwa', NULL),
(28, 'Tom', 'Riddle', 'aaaaaa@sdg', '3462', 'fdsgsgh', '2023-12-06', 'Alumne', '$2y$10$YZERxG.oNe/VJqRTyM8iVuBdMwxwaJdiNlZFwHbB9IN4KRL24AHKW', NULL),
(29, 'prova01', 'asfasf', 'prova01@p', '123', '123', '2023-11-29', 'Alumne', '$2y$10$rJk4rJCsr0R2Zv.gPDIDP.sbvK7QJOdMo8eZo5lgte1YpTP5LKdmK', NULL),
(30, 'prova02', 'sdgsdg', 'prova02@p', '23462', '346sgsg', '2023-11-14', 'Alumne', '$2y$10$90SUOF1GUkTjewHK4pvRCuf77WcAOpncS1YpS8bKkLsxV9J6GypM2', NULL),
(32, 'Enric', 'Arboli', 'alumneamine', '52352', '24526', '2023-11-13', 'Alumne', '$2y$10$zUF793SukzVtGu.84Srp1OJDC6Vsted6B/v2bQnJQnVhA6nGu.MqW', NULL),
(33, 'Alex', 'Winston', 'joanpaneque@gmail.com', '312523523', '246236236', '2023-11-09', 'Alumne', '$2y$10$.JGhlpmrKiLecPXSM3sb.uI8TOHP1LUoGeBcaaoVdmxs.MdnM4ehq', NULL),
(36, 'Lord', 'Volandemort', 'emaaaaaaa@gmail', '3463467', '34634', '2023-12-21', 'Alumne', '$2y$10$VuQgwkF0QZkp52AR4dCW.u3mDHicPMUkd7w0z910HfA.9IBXHXx4S', '656a1ca99bc97'),
(39, 'Jhon', 'Cena', 'administrador@gmail.com', '123123123', '123123123', '2023-11-30', 'Professor', '$2y$10$EhVr80Biw2KrARKYweL4u.656A4fEdQl8o8.E/gqlpqL8qzqFS4Sy', '656de07d75b47'),
(45, 'bababababab', 'sdg', 'marrrrr@saaa', '2352323', '34657343', '2023-11-29', 'Alumne', '$2y$10$LpkMM1vk3gYChhtjvO.FmO4G.bFSuBd8tpPFymD0/.BS4keA8rTny', '6579c4733fa00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user_groups`
--

CREATE TABLE `user_groups` (
  `user_id` int(11) DEFAULT NULL,
  `group_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `user_groups`
--

INSERT INTO `user_groups` (`user_id`, `group_id`) VALUES
(1, 1),
(2, 1),
(3, 1),
(5, 2),
(27, 5),
(28, 1),
(32, 1),
(33, 1),
(36, 1),
(39, 1),
(3, 2),
(3, 3),
(45, 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `errornotifications`
--
ALTER TABLE `errornotifications`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `orla`
--
ALTER TABLE `orla`
  ADD PRIMARY KEY (`id`),
  ADD KEY `group_id` (`group_id`);

--
-- Indices de la tabla `orla_users`
--
ALTER TABLE `orla_users`
  ADD KEY `user_id` (`user_id`),
  ADD KEY `orla_id` (`orla_id`);

--
-- Indices de la tabla `photo`
--
ALTER TABLE `photo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `user_groups`
--
ALTER TABLE `user_groups`
  ADD KEY `user_id` (`user_id`),
  ADD KEY `group_id` (`group_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `errornotifications`
--
ALTER TABLE `errornotifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `groups`
--
ALTER TABLE `groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de la tabla `orla`
--
ALTER TABLE `orla`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=103;

--
-- AUTO_INCREMENT de la tabla `photo`
--
ALTER TABLE `photo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `orla`
--
ALTER TABLE `orla`
  ADD CONSTRAINT `class_photo_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`);

--
-- Filtros para la tabla `orla_users`
--
ALTER TABLE `orla_users`
  ADD CONSTRAINT `orla_users_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `orla_users_ibfk_2` FOREIGN KEY (`orla_id`) REFERENCES `orla` (`id`);

--
-- Filtros para la tabla `photo`
--
ALTER TABLE `photo`
  ADD CONSTRAINT `photo_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Filtros para la tabla `user_groups`
--
ALTER TABLE `user_groups`
  ADD CONSTRAINT `user_groups_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `user_groups_ibfk_2` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
