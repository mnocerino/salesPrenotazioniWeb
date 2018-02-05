-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Feb 05, 2018 alle 18:39
-- Versione del server: 10.1.28-MariaDB
-- Versione PHP: 7.1.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `salesprenotazioni`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `administrators`
--

CREATE TABLE `administrators` (
  `userId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `administrators`
--

INSERT INTO `administrators` (`userId`) VALUES
(13),
(17);

-- --------------------------------------------------------

--
-- Struttura della tabella `bookings`
--

CREATE TABLE `bookings` (
  `bookingId` int(11) NOT NULL,
  `roomId` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `status` int(1) NOT NULL,
  `start` datetime NOT NULL,
  `end` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `bookings`
--

INSERT INTO `bookings` (`bookingId`, `roomId`, `userId`, `status`, `start`, `end`) VALUES
(1, 1, 13, 1, '2018-02-09 08:00:00', '2018-02-09 09:00:00'),
(2, 1, 13, 2, '2018-02-08 08:00:00', '2018-02-08 14:00:00'),
(3, 2, 14, 1, '2018-02-07 12:00:00', '2018-02-07 14:00:00'),
(4, 2, 16, 1, '2018-02-07 17:00:00', '2018-02-07 19:00:00'),
(5, 4, 17, 1, '2018-02-07 08:00:00', '2018-02-07 12:00:00');

-- --------------------------------------------------------

--
-- Struttura della tabella `rooms`
--

CREATE TABLE `rooms` (
  `roomId` int(11) NOT NULL,
  `roomName` varchar(255) NOT NULL,
  `roomDescription` varchar(1000) NOT NULL,
  `isActive` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `rooms`
--

INSERT INTO `rooms` (`roomId`, `roomName`, `roomDescription`, `isActive`) VALUES
(1, 'Sala 1', 'Piccola sala', 1),
(2, 'Sala 2', 'Grande sala', 1),
(3, 'Sala psicomotoria', 'Sala attrezzata', 1),
(4, 'Pet therapy', 'Area per attivitÃ  con animali', 1);

-- --------------------------------------------------------

--
-- Struttura della tabella `sessions`
--

CREATE TABLE `sessions` (
  `sessionId` varchar(30) NOT NULL,
  `userId` int(11) NOT NULL,
  `start` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `end` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `sessions`
--

INSERT INTO `sessions` (`sessionId`, `userId`, `start`, `end`) VALUES
('hjru5m0asbiqnngrtmsl77mqt6', 13, '2018-02-05 17:36:36', '2018-02-05 18:36:36');

-- --------------------------------------------------------

--
-- Struttura della tabella `users`
--

CREATE TABLE `users` (
  `userId` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `surname` varchar(255) NOT NULL,
  `mail` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1',
  `lastLogin` datetime DEFAULT NULL,
  `rate` float NOT NULL DEFAULT '20',
  `allowance` int(11) NOT NULL DEFAULT '20'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `users`
--

INSERT INTO `users` (`userId`, `name`, `surname`, `mail`, `password`, `status`, `lastLogin`, `rate`, `allowance`) VALUES
(13, 'Mattia', 'Nocerino', 'mnocerino@gmail.com', '955a5c1dce63a9cc15edaa67b82b3e6336a79b77', 1, '2018-02-05 18:36:36', 20, 20),
(14, 'Tizio', 'Caio', 'tizio@caio.com', 'ff96221d843e4e52b69e525bcbdff613d4afc297', 1, NULL, 20, 20),
(15, 'Mario', 'Rossi', 'mario@rossi.com', 'acac2c00fbf71543c326df7d80897a5804bee9c7', 1, NULL, 25.64, 14),
(16, 'Giulio', 'Bianchi', 'giulio@bianchi.com', '450f4fa44f39412f9cff91999ac5f4699273113b', 0, NULL, 20, 20),
(17, 'Giancarlo', 'Ruffo', 'giancarlo@ruffo.com', '70ccd9007338d6d81dd3b6271621b9cf9a97ea00', 1, '2018-02-05 18:32:50', 18.2, 50),
(18, 'Tes', 'test', 'test@test.com', '67e28b4e1799f71798322c6e0f486a3eb2d2680d', 1, NULL, 20, 20);

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `administrators`
--
ALTER TABLE `administrators`
  ADD PRIMARY KEY (`userId`),
  ADD UNIQUE KEY `userId` (`userId`);

--
-- Indici per le tabelle `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`bookingId`),
  ADD KEY `roomHasToExist` (`roomId`),
  ADD KEY `userIdHasToExist` (`userId`);

--
-- Indici per le tabelle `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`roomId`);

--
-- Indici per le tabelle `sessions`
--
ALTER TABLE `sessions`
  ADD UNIQUE KEY `userId` (`userId`);

--
-- Indici per le tabelle `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userId`),
  ADD UNIQUE KEY `mail` (`mail`),
  ADD KEY `userId` (`userId`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `bookings`
--
ALTER TABLE `bookings`
  MODIFY `bookingId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT per la tabella `rooms`
--
ALTER TABLE `rooms`
  MODIFY `roomId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT per la tabella `users`
--
ALTER TABLE `users`
  MODIFY `userId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `administrators`
--
ALTER TABLE `administrators`
  ADD CONSTRAINT `userHasToExist` FOREIGN KEY (`userId`) REFERENCES `users` (`userId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `roomHasToExist` FOREIGN KEY (`roomId`) REFERENCES `rooms` (`roomId`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `userIdHasToExist` FOREIGN KEY (`userId`) REFERENCES `users` (`userId`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Limiti per la tabella `sessions`
--
ALTER TABLE `sessions`
  ADD CONSTRAINT `userExists` FOREIGN KEY (`userId`) REFERENCES `users` (`userId`);

DELIMITER $$
--
-- Eventi
--
CREATE DEFINER=`root`@`localhost` EVENT `delete old sessions` ON SCHEDULE EVERY 1 MINUTE STARTS '2018-01-01 00:00:00' ENDS '2025-01-01 00:00:00' ON COMPLETION NOT PRESERVE ENABLE DO DELETE FROM sessions where end < now()$$

DELIMITER ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
