-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 23-10-2020 a las 15:42:12
-- Versión del servidor: 10.4.13-MariaDB
-- Versión de PHP: 7.4.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `moviepass`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bills`
--

CREATE TABLE `bills` (
  `idBill` int(11) NOT NULL,
  `idUser` int(11) NOT NULL,
  `tickets` int(11) NOT NULL,
  `totalPrice` float NOT NULL,
  `discount` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cinemas`
--

CREATE TABLE `cinemas` (
  `idCinema` int(11) NOT NULL,
  `state` tinyint(1) NOT NULL,
  `name` varchar(50) NOT NULL,
  `street` varchar(50) NOT NULL,
  `number` int(11) NOT NULL,
  `phone` bigint(20) NOT NULL,
  `email` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `cinemas`
--

INSERT INTO `cinemas` (`idCinema`, `state`, `name`, `street`, `number`, `phone`, `email`) VALUES
(1, 1, 'Ambassador', 'Cordoba', 3500, 65456, 'ambassador@hotmail.com'),
(2, 1, 'Paseo Aldrey', 'Sarmiento', 2222, 155666666, 'paseoaldrey@gmail.com'),
(3, 0, 'Port', '12 de Octubre', 1500, 155442233, 'cinemaport@hotmail.com');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cinemasxmovies`
--

CREATE TABLE `cinemasxmovies` (
  `idCinemaMovie` int(11) NOT NULL,
  `idCinema` int(11) NOT NULL,
  `idMovie` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `creditcards`
--

CREATE TABLE `creditcards` (
  `idCreditCard` int(11) NOT NULL,
  `idUser` int(11) NOT NULL,
  `number` bigint(20) NOT NULL,
  `propietary` varchar(50) DEFAULT NULL,
  `expiration` date DEFAULT NULL,
  `state` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `genres`
--

CREATE TABLE `genres` (
  `idGenre` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `movies`
--

CREATE TABLE `movies` (
  `idMovie` int(11) NOT NULL,
  `title` varchar(50) NOT NULL,
  `originalTitle` varchar(50) DEFAULT NULL,
  `voteAverage` float DEFAULT NULL,
  `overview` varchar(2000) DEFAULT NULL,
  `releaseDate` date DEFAULT NULL,
  `popularity` float DEFAULT NULL,
  `video` tinyint(1) DEFAULT NULL,
  `videoPath` varchar(200) DEFAULT NULL,
  `adult` tinyint(1) DEFAULT NULL,
  `posterPath` varchar(200) DEFAULT NULL,
  `backdropPath` varchar(100) DEFAULT NULL,
  `originalLanguage` varchar(10) DEFAULT NULL,
  `active` tinyint(1) DEFAULT NULL,
  `runtime` int(11) DEFAULT NULL,
  `homepage` varchar(100) DEFAULT NULL,
  `director` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `moviesxgenres`
--

CREATE TABLE `moviesxgenres` (
  `idMovieGenre` int(11) NOT NULL,
  `idMovie` int(11) NOT NULL,
  `idGenre` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `idRole` int(11) NOT NULL,
  `description` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rooms`
--

CREATE TABLE `rooms` (
  `idRoom` int(11) NOT NULL,
  `idCinema` int(11) NOT NULL,
  `number` int(11) NOT NULL,
  `capacity` int(11) NOT NULL,
  `type` varchar(10) NOT NULL,
  `state` tinyint(1) NOT NULL,
  `price` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `seats`
--

CREATE TABLE `seats` (
  `number` int(11) NOT NULL,
  `letter` char(1) NOT NULL,
  `idRoom` int(11) NOT NULL,
  `state` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `shows`
--

CREATE TABLE `shows` (
  `idShow` int(11) NOT NULL,
  `idCinema` int(11) NOT NULL,
  `idRoom` int(11) NOT NULL,
  `idMovie` int(11) NOT NULL,
  `remainingTickets` int(11) NOT NULL,
  `dateTime` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tickets`
--

CREATE TABLE `tickets` (
  `idTicket` int(11) NOT NULL,
  `idBill` int(11) NOT NULL,
  `idShow` int(11) NOT NULL,
  `price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `idUser` int(11) NOT NULL,
  `idRole` int(11) NOT NULL,
  `dni` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `surname` varchar(50) NOT NULL,
  `street` varchar(50) NOT NULL,
  `number` int(11) NOT NULL,
  `email` varchar(50) DEFAULT NULL,
  `password` varchar(16) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `bills`
--
ALTER TABLE `bills`
  ADD PRIMARY KEY (`idBill`),
  ADD KEY `fkUserBill` (`idUser`);

--
-- Indices de la tabla `cinemas`
--
ALTER TABLE `cinemas`
  ADD PRIMARY KEY (`idCinema`),
  ADD UNIQUE KEY `unqIdName` (`idCinema`,`name`);

--
-- Indices de la tabla `cinemasxmovies`
--
ALTER TABLE `cinemasxmovies`
  ADD PRIMARY KEY (`idCinemaMovie`),
  ADD KEY `fkCinemaMovie` (`idCinema`),
  ADD KEY `fkMovieCinema` (`idMovie`);

--
-- Indices de la tabla `creditcards`
--
ALTER TABLE `creditcards`
  ADD PRIMARY KEY (`idCreditCard`),
  ADD KEY `fkUserCreditCard` (`idUser`);

--
-- Indices de la tabla `genres`
--
ALTER TABLE `genres`
  ADD PRIMARY KEY (`idGenre`),
  ADD UNIQUE KEY `unqGenre` (`name`);

--
-- Indices de la tabla `movies`
--
ALTER TABLE `movies`
  ADD PRIMARY KEY (`idMovie`);

--
-- Indices de la tabla `moviesxgenres`
--
ALTER TABLE `moviesxgenres`
  ADD PRIMARY KEY (`idMovieGenre`),
  ADD KEY `fkMovieGenre` (`idMovie`),
  ADD KEY `fkGenreMovie` (`idGenre`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`idRole`);

--
-- Indices de la tabla `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`idRoom`),
  ADD UNIQUE KEY `unqIdCinemaNumber` (`idCinema`,`number`);

--
-- Indices de la tabla `seats`
--
ALTER TABLE `seats`
  ADD PRIMARY KEY (`number`,`letter`,`idRoom`),
  ADD KEY `fkRoomSeat` (`idRoom`);

--
-- Indices de la tabla `shows`
--
ALTER TABLE `shows`
  ADD PRIMARY KEY (`idShow`),
  ADD KEY `fkCinemaShow` (`idCinema`),
  ADD KEY `fkRoomShow` (`idRoom`),
  ADD KEY `fkMovieShow` (`idMovie`);

--
-- Indices de la tabla `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`idTicket`),
  ADD KEY `fkBillTicket` (`idBill`),
  ADD KEY `fkShowTicket` (`idShow`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`idUser`),
  ADD UNIQUE KEY `unqEmail` (`email`),
  ADD KEY `fkRoleUser` (`idRole`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `bills`
--
ALTER TABLE `bills`
  MODIFY `idBill` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cinemas`
--
ALTER TABLE `cinemas`
  MODIFY `idCinema` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `cinemasxmovies`
--
ALTER TABLE `cinemasxmovies`
  MODIFY `idCinemaMovie` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `creditcards`
--
ALTER TABLE `creditcards`
  MODIFY `idCreditCard` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `moviesxgenres`
--
ALTER TABLE `moviesxgenres`
  MODIFY `idMovieGenre` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `idRole` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `rooms`
--
ALTER TABLE `rooms`
  MODIFY `idRoom` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `shows`
--
ALTER TABLE `shows`
  MODIFY `idShow` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tickets`
--
ALTER TABLE `tickets`
  MODIFY `idTicket` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `idUser` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `bills`
--
ALTER TABLE `bills`
  ADD CONSTRAINT `fkUserBill` FOREIGN KEY (`idUser`) REFERENCES `users` (`idUser`);

--
-- Filtros para la tabla `cinemasxmovies`
--
ALTER TABLE `cinemasxmovies`
  ADD CONSTRAINT `fkCinemaMovie` FOREIGN KEY (`idCinema`) REFERENCES `cinemas` (`idCinema`),
  ADD CONSTRAINT `fkMovieCinema` FOREIGN KEY (`idMovie`) REFERENCES `movies` (`idMovie`);

--
-- Filtros para la tabla `creditcards`
--
ALTER TABLE `creditcards`
  ADD CONSTRAINT `fkUserCreditCard` FOREIGN KEY (`idUser`) REFERENCES `users` (`idUser`);

--
-- Filtros para la tabla `moviesxgenres`
--
ALTER TABLE `moviesxgenres`
  ADD CONSTRAINT `fkGenreMovie` FOREIGN KEY (`idGenre`) REFERENCES `genres` (`idGenre`),
  ADD CONSTRAINT `fkMovieGenre` FOREIGN KEY (`idMovie`) REFERENCES `movies` (`idMovie`);

--
-- Filtros para la tabla `rooms`
--
ALTER TABLE `rooms`
  ADD CONSTRAINT `fkCinemaRoom` FOREIGN KEY (`idCinema`) REFERENCES `cinemas` (`idCinema`);

--
-- Filtros para la tabla `seats`
--
ALTER TABLE `seats`
  ADD CONSTRAINT `fkRoomSeat` FOREIGN KEY (`idRoom`) REFERENCES `rooms` (`idRoom`);

--
-- Filtros para la tabla `shows`
--
ALTER TABLE `shows`
  ADD CONSTRAINT `fkCinemaShow` FOREIGN KEY (`idCinema`) REFERENCES `cinemas` (`idCinema`),
  ADD CONSTRAINT `fkMovieShow` FOREIGN KEY (`idMovie`) REFERENCES `movies` (`idMovie`),
  ADD CONSTRAINT `fkRoomShow` FOREIGN KEY (`idRoom`) REFERENCES `rooms` (`idRoom`);

--
-- Filtros para la tabla `tickets`
--
ALTER TABLE `tickets`
  ADD CONSTRAINT `fkBillTicket` FOREIGN KEY (`idBill`) REFERENCES `bills` (`idBill`),
  ADD CONSTRAINT `fkShowTicket` FOREIGN KEY (`idShow`) REFERENCES `shows` (`idShow`);

--
-- Filtros para la tabla `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fkRoleUser` FOREIGN KEY (`idRole`) REFERENCES `roles` (`idRole`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
