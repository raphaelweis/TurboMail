CREATE DATABASE IF NOT EXISTS TurboMailDB;

USE TurboMailDB;

-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : sam. 17 juin 2023 à 20:53
-- Version du serveur : 10.4.28-MariaDB
-- Version de PHP : 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `turbomaildb`
--

-- --------------------------------------------------------

--
-- Structure de la table `message`
--

CREATE TABLE `message` (
  `id` bigint(20) NOT NULL,
  `id_sender` bigint(20) NOT NULL,
  `id_receiver` bigint(20) NOT NULL,
  `id_relation` bigint(20) NOT NULL,
  `message` text NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `message`
--

INSERT INTO `message` (`id`, `id_sender`, `id_receiver`, `id_relation`, `message`, `date`) VALUES
(1, 1, 2, 1, 'J\'adore TurboMail !', '2023-06-16 21:06:24'),
(2, 1, 3, 2, 'TurboMail est la meilleure application !', '2023-06-16 21:06:51'),
(3, 1, 4, 3, 'Comment trouves tu cette application LeBron ?', '2023-06-16 21:07:30'),
(4, 5, 1, 4, 'Salut Fabio !!<br/><br/>Veux tu aller au Mans ?', '2023-06-16 21:08:14'),
(5, 1, 6, 5, 'Salut Michael !<br/><br/>Est-ce que tu as encore des chaussures à vendre ?', '2023-06-16 21:09:28'),
(6, 1, 7, 6, 'Salut Marc !', '2023-06-16 21:10:10'),
(7, 1, 8, 7, 'Ce nouveau site à l\'air cool pour communiquer !', '2023-06-16 21:10:48'),
(9, 1, 10, 9, 'Salut Giannis !<br/><br/>Ton prochain match se joue où ?', '2023-06-16 21:11:54'),
(10, 1, 11, 10, 'Salut Aleix !<br/>Super course tout à l\'heure !', '2023-06-16 21:12:23'),
(11, 1, 12, 11, 'Salut Nikola !<br/><br/>Bien joué pour ton titre de finals MVP !<br/>Repose toi bien !', '2023-06-16 21:13:20'),
(12, 1, 13, 12, 'Salut Jorge !<br/>Tu as changé quoi sur ta moto ?', '2023-06-16 21:13:53'),
(13, 1, 5, 4, 'Bien sur !', '2023-06-16 21:14:34'),
(14, 4, 1, 3, 'Elle est super bien !!', '2023-06-16 21:15:13'),
(15, 2, 10, 13, 'Salut Giannis !', '2023-06-16 21:16:08'),
(16, 2, 11, 14, 'Comment va tu Aleix ?<br/><br/>La course s\'est bien passée ?', '2023-06-16 21:16:55'),
(17, 2, 12, 15, 'Salut Nikola !<br/><br/>Comment la finale s\'est passée ?', '2023-06-16 21:20:22'),
(18, 2, 13, 16, 'Salut Jorge !!<br/><br/>Tu es super rapide dans le secteur 2 !', '2023-06-16 21:21:42'),
(19, 14, 2, 17, 'Salut Stephen !', '2023-06-16 21:22:29'),
(20, 15, 2, 18, 'Salut Stephen ! Comment mets tu autant de trois points ?', '2023-06-16 21:22:59'),
(21, 1, 3, 2, 'Parlons nous sur cette application maintenant !', '2023-06-16 21:24:29'),
(22, 3, 1, 2, 'Pas de problème !<br/><br/>Elle à l\'air super bien !', '2023-06-16 21:25:07'),
(23, 1, 5, 4, 'Tu veux y aller quel jour ?', '2023-06-16 21:26:20');

-- --------------------------------------------------------

--
-- Structure de la table `relation`
--

CREATE TABLE `relation` (
  `id` bigint(20) NOT NULL,
  `id_sender` bigint(20) NOT NULL,
  `id_receiver` bigint(20) NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `relation`
--

INSERT INTO `relation` (`id`, `id_sender`, `id_receiver`, `status`) VALUES
(1, 1, 2, 1),
(2, 1, 3, 1),
(3, 1, 4, 1),
(4, 5, 1, 1),
(5, 1, 6, 0),
(6, 1, 7, 0),
(7, 1, 8, 0),
(9, 1, 10, 0),
(10, 1, 11, 0),
(11, 1, 12, 0),
(12, 1, 13, 0),
(13, 2, 10, 0),
(14, 2, 11, 0),
(15, 2, 12, 0),
(16, 2, 13, 0),
(17, 14, 2, 0),
(18, 15, 2, 0);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` bigint(20) NOT NULL,
  `first_name` varchar(128) NOT NULL,
  `last_name` varchar(128) NOT NULL,
  `email` varchar(256) NOT NULL,
  `password` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `first_name`, `last_name`, `email`, `password`) VALUES
(1, 'Fabio', 'Quartararo', 'fabio.quartararo@motogp.com', '$2y$10$oglGo5n8LXp57Ydb9l077ugyhBpCyUBpO/msKJfVmUGtVv644hkqC'),
(2, 'Stephen', 'Curry', 'stephen.curry@nba.com', '$2y$10$b/rEUhlLZRkelxv2Le8L7.jOwAzQ8ndG3WPSIwoIFy.hXjlJHQOu6'),
(3, 'Johann', 'Zarco', 'johann.zarco@motogp.com', '$2y$10$uHwC6bFgIIsQHwJiLsJ/nOGM/n6DCmgmFppu/Ac99/2k0syVP7Z8a'),
(4, 'LeBron', 'James', 'lebron.james@nba.com', '$2y$10$Pufs1V81UgDSJvNTww0fnursw5h5gFCGKVu5LYJBu93kQtyVUpxRO'),
(5, 'Francesco', 'Bagnaia', 'francesco.bagnaia@motogp.com', '$2y$10$9f2rxHiXOw/F6etwkl2I2uhfgjEL0C4TR9WY1gtgrxfGiBrqj1klO'),
(6, 'Michael', 'Jordan', 'michael.jordan@nba.com', '$2y$10$cXARpAg0XnKHws4yCvybLuvYKz6fT.NOhu1oVI6FzXPPpKjAfYwWi'),
(7, 'Marc', 'Marquez', 'marc.marquez@motogp.com', '$2y$10$HC3LVq5znVyIq30ftcwCoO4aQc7/z2dGrUVeCGkhsYb/E8mpHYBB6'),
(8, 'Kobe', 'Bryant', 'kobe.bryant@nba.com', '$2y$10$JxLvVOt43B0/FkdJfcZpq.ba2CaVqteCzhzMUaHoodFabVxnin.0q'),
(9, 'Valentino', 'Rossi', 'valentino.rossi@motogp.com', '$2y$10$E3aigmDYQoWNd6KTydlz7eLE5MrnfqAymKVaDQNXiadEorEWn14Lq'),
(10, 'Giannis', 'Antetokounmpo', 'giannis.antetokounmpo@nba.com', '$2y$10$UYuw67VyP1rKj8DoFSeTseYCQhvbBZx.NjWOjpWFlOuNajndjONHO'),
(11, 'Aleix', 'Espargaro', 'aleix.espargaro@motogp.com', '$2y$10$xx58DhZMWtO7diNOKDIFSeEngONySmafqCpGOn/eAWUzjSIZDfhue'),
(12, 'Nikola', 'Jokic', 'nikola.jokic@nba.com', '$2y$10$Etu0TE1pAoyHfpMfQgA8FezqV2tF4UHhwwgQxeqzYsCejlY5UiPRG'),
(13, 'Jorge', 'Martin', 'jorge.martin@motogp.com', '$2y$10$XHom4nAqEZdVeIC2ZFRrOuo54Xr1S0npT1gPz8jMtv8KiWm2Vuw0S'),
(14, 'Rudy', 'Gobert', 'rudy.gobert@nba.com', '$2y$10$MiZLe4cns0C1z8GZxRLz2O5qKO.WBX57uVxeWGG2t7g8Yf7R8/KD6'),
(15, 'Brad', 'Binder', 'brad.binder@motogp.com', '$2y$10$AiuPKVraJ1S7PyRtD6ZJiucnEllpBo17wXnw4U5OuTqorxWNMuimu'),
(16, 'Shaquille', 'O&#039;Neal', 'shaquille.oneal@nba.com', '$2y$10$fCnM4T/IP2P3CwDmw.17A.rjrC2/wx4EcjSfDv7hVhfkfUe4UvsXa');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_Message` (`id_relation`);

--
-- Index pour la table `relation`
--
ALTER TABLE `relation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_Relation_Sender` (`id_sender`),
  ADD KEY `FK_Relation_Receiver` (`id_receiver`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UC_User` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `message`
--
ALTER TABLE `message`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT pour la table `relation`
--
ALTER TABLE `relation`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `message`
--
ALTER TABLE `message`
  ADD CONSTRAINT `FK_Message` FOREIGN KEY (`id_relation`) REFERENCES `relation` (`id`);

--
-- Contraintes pour la table `relation`
--
ALTER TABLE `relation`
  ADD CONSTRAINT `FK_Relation_Receiver` FOREIGN KEY (`id_receiver`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `FK_Relation_Sender` FOREIGN KEY (`id_sender`) REFERENCES `user` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
