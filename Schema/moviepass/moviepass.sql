-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 11-11-2020 a las 01:40:51
-- Versión del servidor: 10.4.14-MariaDB
-- Versión de PHP: 7.4.11

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
  `codePayment` int(11) NOT NULL,
  `tickets` int(11) NOT NULL,
  `date` date NOT NULL,
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
  `email` varchar(50) NOT NULL,
  `poster` varchar(1000) DEFAULT NULL,
  `city` varchar(50) NOT NULL,
  `country` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cinemaxmovies`
--

CREATE TABLE `cinemaxmovies` (
  `idCinema` int(11) NOT NULL,
  `idMovie` int(11) NOT NULL,
  `state` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `creditcardpayments`
--

CREATE TABLE `creditcardpayments` (
  `idCreditCardPayment` int(11) NOT NULL,
  `idCreditCard` bigint(20) NOT NULL,
  `idCreditCardCompany` varchar(50) NOT NULL,
  `datePayment` datetime NOT NULL,
  `total` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `creditcards`
--

CREATE TABLE `creditcards` (
  `company` varchar(50) NOT NULL,
  `numberCard` bigint(20) NOT NULL,
  `propietary` varchar(50) DEFAULT NULL,
  `expiration` date DEFAULT NULL
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
  `title` varchar(100) DEFAULT NULL,
  `originalTitle` varchar(50) DEFAULT NULL,
  `voteAverage` float DEFAULT NULL,
  `overview` varchar(2000) DEFAULT NULL,
  `releaseDate` date DEFAULT NULL,
  `popularity` float DEFAULT NULL,
  `videoPath` varchar(200) DEFAULT NULL,
  `adult` tinyint(1) DEFAULT NULL,
  `posterPath` varchar(200) DEFAULT NULL,
  `backDropPath` varchar(100) DEFAULT NULL,
  `originalLanguage` varchar(10) DEFAULT NULL,
  `runtime` int(11) DEFAULT NULL,
  `homepage` varchar(100) DEFAULT NULL,
  `director` varchar(50) DEFAULT NULL,
  `review` varchar(10000) DEFAULT NULL,
  `state` tinyint(1) NOT NULL
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
  `name_room` varchar(50) DEFAULT NULL,
  `capacity` int(11) NOT NULL,
  `type` varchar(10) NOT NULL,
  `price` float NOT NULL,
  `roomrows` int(11) NOT NULL,
  `roomcolumns` int(11) NOT NULL,
  `stateRoom` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `seats`
--

CREATE TABLE `seats` (
  `idSeat` int(11) NOT NULL,
  `rowSeat` int(11) NOT NULL,
  `numberSeat` int(11) NOT NULL,
  `idShow` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `shows`
--

CREATE TABLE `shows` (
  `idShow` int(11) NOT NULL,
  `idRoom` int(11) NOT NULL,
  `idMovie` int(11) NOT NULL,
  `dateTime` datetime DEFAULT NULL,
  `shift` varchar(30) DEFAULT NULL,
  `remainingTickets` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tickets`
--

CREATE TABLE `tickets` (
  `idTicket` int(11) NOT NULL,
  `idBill` int(11) NOT NULL,
  `idShow` int(11) NOT NULL,
  `seat` int(11) NOT NULL,
  `priceTicket` int(11) DEFAULT NULL,
  `qrCode` varchar(200) DEFAULT NULL
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
  ADD KEY `fkUserBill` (`idUser`),
  ADD KEY `fkCodePayment` (`codePayment`);

--
-- Indices de la tabla `cinemas`
--
ALTER TABLE `cinemas`
  ADD PRIMARY KEY (`idCinema`),
  ADD UNIQUE KEY `unqIdName` (`idCinema`,`name`);

--
-- Indices de la tabla `cinemaxmovies`
--
ALTER TABLE `cinemaxmovies`
  ADD PRIMARY KEY (`idCinema`,`idMovie`),
  ADD KEY `FK_idMovie` (`idMovie`);

--
-- Indices de la tabla `creditcardpayments`
--
ALTER TABLE `creditcardpayments`
  ADD PRIMARY KEY (`idCreditCardPayment`),
  ADD KEY `fkCreditCardCompany` (`idCreditCardCompany`),
  ADD KEY `idCreditCard` (`idCreditCard`);

--
-- Indices de la tabla `creditcards`
--
ALTER TABLE `creditcards`
  ADD PRIMARY KEY (`company`,`numberCard`);

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
  ADD UNIQUE KEY `unqIdCinemaNumber` (`idCinema`,`name_room`);

--
-- Indices de la tabla `seats`
--
ALTER TABLE `seats`
  ADD PRIMARY KEY (`idSeat`),
  ADD KEY `fk-show` (`idShow`);

--
-- Indices de la tabla `shows`
--
ALTER TABLE `shows`
  ADD PRIMARY KEY (`idShow`),
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
  MODIFY `idBill` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=192;

--
-- AUTO_INCREMENT de la tabla `cinemas`
--
ALTER TABLE `cinemas`
  MODIFY `idCinema` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `creditcardpayments`
--
ALTER TABLE `creditcardpayments`
  MODIFY `idCreditCardPayment` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=204;

--
-- AUTO_INCREMENT de la tabla `moviesxgenres`
--
ALTER TABLE `moviesxgenres`
  MODIFY `idMovieGenre` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=340;

--
-- AUTO_INCREMENT de la tabla `rooms`
--
ALTER TABLE `rooms`
  MODIFY `idRoom` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT de la tabla `seats`
--
ALTER TABLE `seats`
  MODIFY `idSeat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=263;

--
-- AUTO_INCREMENT de la tabla `shows`
--
ALTER TABLE `shows`
  MODIFY `idShow` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT de la tabla `tickets`
--
ALTER TABLE `tickets`
  MODIFY `idTicket` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=253;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `idUser` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `bills`
--
ALTER TABLE `bills`
  ADD CONSTRAINT `fkCodePayment` FOREIGN KEY (`codePayment`) REFERENCES `creditcardpayments` (`idCreditCardPayment`),
  ADD CONSTRAINT `fkUserBill` FOREIGN KEY (`idUser`) REFERENCES `users` (`idUser`);

--
-- Filtros para la tabla `cinemaxmovies`
--
ALTER TABLE `cinemaxmovies`
  ADD CONSTRAINT `FK_idCinema` FOREIGN KEY (`idCinema`) REFERENCES `cinemas` (`idCinema`),
  ADD CONSTRAINT `FK_idMovie` FOREIGN KEY (`idMovie`) REFERENCES `movies` (`idMovie`);

--
-- Filtros para la tabla `creditcardpayments`
--
ALTER TABLE `creditcardpayments`
  ADD CONSTRAINT `fkCreditCardCompany` FOREIGN KEY (`idCreditCardCompany`) REFERENCES `creditcards` (`company`);

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
  ADD CONSTRAINT `fk-show` FOREIGN KEY (`idShow`) REFERENCES `shows` (`idShow`);

--
-- Filtros para la tabla `shows`
--
ALTER TABLE `shows`
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
