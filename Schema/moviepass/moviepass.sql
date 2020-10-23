-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 23-10-2020 a las 04:23:21
-- Versión del servidor: 8.0.21
-- Versión de PHP: 7.3.21

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

DROP TABLE IF EXISTS `bills`;
CREATE TABLE IF NOT EXISTS `bills` (
  `idBill` int NOT NULL AUTO_INCREMENT,
  `idUser` int NOT NULL,
  `codePayment` int NOT NULL,
  `tickets` int NOT NULL,
  `date` date NOT NULL,
  `totalPrice` float NOT NULL,
  `discount` float DEFAULT NULL,
  PRIMARY KEY (`idBill`),
  KEY `fkUserBill` (`idUser`),
  KEY `fkCodePayment` (`codePayment`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cinemas`
--

DROP TABLE IF EXISTS `cinemas`;
CREATE TABLE IF NOT EXISTS `cinemas` (
  `idCinema` int NOT NULL AUTO_INCREMENT,
  `state` tinyint(1) NOT NULL,
  `name` varchar(50) NOT NULL,
  `street` varchar(50) NOT NULL,
  `number` int NOT NULL,
  `phone` bigint NOT NULL,
  `email` varchar(50) NOT NULL,
  PRIMARY KEY (`idCinema`),
  UNIQUE KEY `unqIdName` (`idCinema`,`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `creditcardpayments`
--

DROP TABLE IF EXISTS `creditcardpayments`;
CREATE TABLE IF NOT EXISTS `creditcardpayments` (
  `code` int NOT NULL AUTO_INCREMENT,
  `idCreditCard` int NOT NULL,
  `date` date NOT NULL,
  `total` double NOT NULL,
  PRIMARY KEY (`code`),
  KEY `fkCreditCard` (`idCreditCard`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `creditcards`
--

DROP TABLE IF EXISTS `creditcards`;
CREATE TABLE IF NOT EXISTS `creditcards` (
  `idCreditCard` int NOT NULL AUTO_INCREMENT,
  `company` varchar(50) NOT NULL,
  `number` bigint NOT NULL,
  `propietary` varchar(50) DEFAULT NULL,
  `expiration` date DEFAULT NULL,
  `state` tinyint(1) NOT NULL,
  PRIMARY KEY (`idCreditCard`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `genres`
--

DROP TABLE IF EXISTS `genres`;
CREATE TABLE IF NOT EXISTS `genres` (
  `idGenre` int NOT NULL,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`idGenre`),
  UNIQUE KEY `unqGenre` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `movies`
--

DROP TABLE IF EXISTS `movies`;
CREATE TABLE IF NOT EXISTS `movies` (
  `idMovie` int NOT NULL,
  `title` varchar(50) NOT NULL,
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
  `runtime` int DEFAULT NULL,
  `homepage` varchar(100) DEFAULT NULL,
  `director` varchar(50) DEFAULT NULL,
  `review` varchar(10000) DEFAULT NULL,
  PRIMARY KEY (`idMovie`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `moviesxgenres`
--

DROP TABLE IF EXISTS `moviesxgenres`;
CREATE TABLE IF NOT EXISTS `moviesxgenres` (
  `idMovieGenre` int NOT NULL AUTO_INCREMENT,
  `idMovie` int NOT NULL,
  `idGenre` int NOT NULL,
  PRIMARY KEY (`idMovieGenre`),
  KEY `fkMovieGenre` (`idMovie`),
  KEY `fkGenreMovie` (`idGenre`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE IF NOT EXISTS `roles` (
  `idRole` int NOT NULL,
  `description` varchar(50) NOT NULL,
  PRIMARY KEY (`idRole`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rooms`
--

DROP TABLE IF EXISTS `rooms`;
CREATE TABLE IF NOT EXISTS `rooms` (
  `idRoom` int NOT NULL AUTO_INCREMENT,
  `idCinema` int NOT NULL,
  `name` varchar(50) NOT NULL,
  `capacity` int NOT NULL,
  `type` varchar(10) NOT NULL,
  `price` float NOT NULL,
  PRIMARY KEY (`idRoom`),
  UNIQUE KEY `unqIdCinemaNumber` (`idCinema`,`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `shows`
--

DROP TABLE IF EXISTS `shows`;
CREATE TABLE IF NOT EXISTS `shows` (
  `idShow` int NOT NULL AUTO_INCREMENT,
  `idRoom` int NOT NULL,
  `idMovie` int NOT NULL,
  `dateTime` datetime DEFAULT NULL,
  `shift` varchar(30) DEFAULT NULL,
  `remainingTickets` int NOT NULL,
  PRIMARY KEY (`idShow`),
  KEY `fkRoomShow` (`idRoom`),
  KEY `fkMovieShow` (`idMovie`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tickets`
--

DROP TABLE IF EXISTS `tickets`;
CREATE TABLE IF NOT EXISTS `tickets` (
  `idTicket` int NOT NULL AUTO_INCREMENT,
  `idBill` int NOT NULL,
  `idShow` int NOT NULL,
  `seat` int NOT NULL,
  `price` int NOT NULL,
  `qrCode` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`idTicket`),
  KEY `fkBillTicket` (`idBill`),
  KEY `fkShowTicket` (`idShow`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `idUser` int NOT NULL AUTO_INCREMENT,
  `idRole` int NOT NULL,
  `dni` int NOT NULL,
  `name` varchar(50) NOT NULL,
  `surname` varchar(50) NOT NULL,
  `street` varchar(50) NOT NULL,
  `number` int NOT NULL,
  `email` varchar(50) DEFAULT NULL,
  `password` varchar(16) DEFAULT NULL,
  PRIMARY KEY (`idUser`),
  UNIQUE KEY `unqEmail` (`email`),
  KEY `fkRoleUser` (`idRole`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `bills`
--
ALTER TABLE `bills`
  ADD CONSTRAINT `fkCodePayment` FOREIGN KEY (`codePayment`) REFERENCES `creditcardpayments` (`code`),
  ADD CONSTRAINT `fkUserBill` FOREIGN KEY (`idUser`) REFERENCES `users` (`idUser`);

--
-- Filtros para la tabla `creditcardpayments`
--
ALTER TABLE `creditcardpayments`
  ADD CONSTRAINT `fkCreditCard` FOREIGN KEY (`idCreditCard`) REFERENCES `creditcards` (`idCreditCard`);

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
