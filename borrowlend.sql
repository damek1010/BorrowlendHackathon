-- phpMyAdmin SQL Dump
-- version 4.8.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Czas generowania: 21 Kwi 2018, 15:34
-- Wersja serwera: 10.1.31-MariaDB
-- Wersja PHP: 7.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `borrowlend`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `Bills`
--

CREATE TABLE `Bills` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `amount` int(11) NOT NULL,
  `owned` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Zrzut danych tabeli `Bills`
--

INSERT INTO `Bills` (`id`, `title`, `amount`, `owned`) VALUES
(3, 'saasfsa', 2324, 1);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `Users`
--

CREATE TABLE `Users` (
  `id` int(11) NOT NULL,
  `login` varchar(20) NOT NULL,
  `password` varchar(60) NOT NULL,
  `email` varchar(100) NOT NULL,
  `firstname` text NOT NULL,
  `lastname` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Zrzut danych tabeli `Users`
--

INSERT INTO `Users` (`id`, `login`, `password`, `email`, `firstname`, `lastname`) VALUES
(1, 'test', 'test', 't@t.t', '', ''),
(3, 'test1', '098f6bcd4621d373cade4e832627b4f6', 't@t.t', '', ''),
(5, 'test2', '098f6bcd4621d373cade4e832627b4f6', 't@t.t', '', ''),
(6, 'test3', '098f6bcd4621d373cade4e832627b4f6', 't@t.t', '', ''),
(7, 'test4', '098f6bcd4621d373cade4e832627b4f6', 't@t.t', '', '');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `User_Bills`
--

CREATE TABLE `User_Bills` (
  `id` int(11) NOT NULL,
  `user` int(11) NOT NULL,
  `bill` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Zrzut danych tabeli `User_Bills`
--

INSERT INTO `User_Bills` (`id`, `user`, `bill`) VALUES
(1, 1, 3);

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `Bills`
--
ALTER TABLE `Bills`
  ADD PRIMARY KEY (`id`),
  ADD KEY `owned` (`owned`);

--
-- Indeksy dla tabeli `Users`
--
ALTER TABLE `Users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `login` (`login`);

--
-- Indeksy dla tabeli `User_Bills`
--
ALTER TABLE `User_Bills`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user` (`user`),
  ADD KEY `bill` (`bill`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT dla tabeli `Bills`
--
ALTER TABLE `Bills`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT dla tabeli `Users`
--
ALTER TABLE `Users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT dla tabeli `User_Bills`
--
ALTER TABLE `User_Bills`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `Bills`
--
ALTER TABLE `Bills`
  ADD CONSTRAINT `Bills_ibfk_2` FOREIGN KEY (`owned`) REFERENCES `Users` (`id`);

--
-- Ograniczenia dla tabeli `User_Bills`
--
ALTER TABLE `User_Bills`
  ADD CONSTRAINT `User_Bills_ibfk_1` FOREIGN KEY (`user`) REFERENCES `Users` (`id`),
  ADD CONSTRAINT `User_Bills_ibfk_2` FOREIGN KEY (`bill`) REFERENCES `Bills` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
