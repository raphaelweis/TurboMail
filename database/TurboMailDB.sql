-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 05, 2023 at 06:33 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `TurboMailDB`
--

-- --------------------------------------------------------

--
-- Table structure for table `Message`
--

CREATE TABLE `Message` (
  `id` bigint(20) NOT NULL,
  `id_sender` bigint(20) NOT NULL,
  `id_receiver` bigint(20) NOT NULL,
  `id_relation` bigint(20) NOT NULL,
  `message` text NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `Message`
--

INSERT INTO `Message` (`id`, `id_sender`, `id_receiver`, `id_relation`, `message`, `date`) VALUES
(1, 1, 9, 1, 'Hello, Shaq!', '2023-06-05 18:29:58');

-- --------------------------------------------------------

--
-- Table structure for table `Relation`
--

CREATE TABLE `Relation` (
  `id` bigint(20) NOT NULL,
  `id_sender` bigint(20) NOT NULL,
  `id_receiver` bigint(20) NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `Relation`
--

INSERT INTO `Relation` (`id`, `id_sender`, `id_receiver`, `status`) VALUES
(1, 1, 9, 0);

-- --------------------------------------------------------

--
-- Table structure for table `User`
--

CREATE TABLE `User` (
  `id` bigint(20) NOT NULL,
  `first_name` varchar(128) NOT NULL,
  `last_name` varchar(128) NOT NULL,
  `email` varchar(256) NOT NULL,
  `password` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `User`
--

INSERT INTO `User` (`id`, `first_name`, `last_name`, `email`, `password`) VALUES
(1, 'Stephen', 'Curry', 'stephen.curry@nba.com', '$2y$10$uhtykJP028WoTnaf1tM8tOUhW5UQI9vnzWxQNVGIEc64N8hc7GQ9e'),
(2, 'Fabio', 'Quartararo', 'fabio.quartararo@motogp.com', '$2y$10$4wh4QPv99xTHVwvN4iikE.ExTSPSucM8KYfkOAaOnjVXjtuCcqFNq'),
(3, 'LeBron', 'James', 'lebron.james@nba.com', '$2y$10$1glcIew5VaPtFeI1yTPy/uVry7DDp3Vx/4LHzwdiLIdRmB0qutUjy'),
(4, 'Johann', 'Zarco', 'johann.zarco@motogp.com', '$2y$10$4jCOeAbMbU6xWSeJpezeuuicAcAalQmczXZnZd7uqgYJ5yysvuIyG'),
(5, 'Michael', 'Jordan', 'michael.jordan@nba.com', '$2y$10$SwZjrh9mxDMumT2Iz4/7VuFpF0SPl8MT8Rwiy.2rZcpH5YkcBVhIi'),
(6, 'Valentino', 'Rossi', 'valentino.rossi@motogp.com', '$2y$10$5e3QnsIx7sTJ8JeqLdg2neoXexLCQhPIyP3YuI7WX/7.ZKIvToBPa'),
(7, 'Giannis', 'Antetokounmpo', 'giannis.antetokounmpo@nba.com', '$2y$10$9c8Y9dNOu8ggoy3h1AeRQeFIkexS4fpc6PzaCgGeJvtJOocRYm0sW'),
(8, 'Marc', 'Marquez', 'marc.marquez@motogp.com', '$2y$10$U4UqBfH06QMzxdBxzE14eu1/bAm9KL/vNmAxNT9nL3c9uR1gUCw8G'),
(9, 'Shaquille', 'O&#039;Neal', 'shaquille.oneal@nba.com', '$2y$10$7t7xceEmEuM5tUOS3UjwjuZz74FPhvU5WvLb8AwWU5ql/CRLPQLVa'),
(10, 'Francesco', 'Bagnaia', 'francesco.bagnaia@motogp.com', '$2y$10$3GplDa9rpH/cR8u/sR9DfOA8UixerwuTvcufE89MPsxuToN3M5ame');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Message`
--
ALTER TABLE `Message`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_relation` (`id_relation`);

--
-- Indexes for table `Relation`
--
ALTER TABLE `Relation`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_sender` (`id_sender`),
  ADD UNIQUE KEY `id_receiver` (`id_receiver`);

--
-- Indexes for table `User`
--
ALTER TABLE `User`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Message`
--
ALTER TABLE `Message`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `Relation`
--
ALTER TABLE `Relation`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `User`
--
ALTER TABLE `User`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Message`
--
ALTER TABLE `Message`
  ADD CONSTRAINT `Message_ibfk_1` FOREIGN KEY (`id_relation`) REFERENCES `Relation` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `Relation`
--
ALTER TABLE `Relation`
  ADD CONSTRAINT `Relation_ibfk_1` FOREIGN KEY (`id_sender`) REFERENCES `User` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Relation_ibfk_2` FOREIGN KEY (`id_receiver`) REFERENCES `User` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
