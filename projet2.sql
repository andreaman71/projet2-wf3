-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le :  lun. 05 nov. 2018 à 14:33
-- Version du serveur :  10.1.36-MariaDB
-- Version de PHP :  7.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `projet2`
--
CREATE DATABASE IF NOT EXISTS `projet2` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `projet2`;

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `user_email` varchar(320) NOT NULL,
  `user_password` varchar(300) NOT NULL,
  `user_ip` varchar(300) NOT NULL,
  `user_date` datetime NOT NULL,
  `user_lastname` varchar(100) NOT NULL,
  `user_firstname` varchar(100) NOT NULL,
  `user_key` char(32) NOT NULL,
  `user_active` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `user_email`, `user_password`, `user_ip`, `user_date`, `user_lastname`, `user_firstname`, `user_key`, `user_active`) VALUES
(1, 'exemple@exemple.fr', '$2y$10$66kFP3/C.NU9Hk6nU6srue.5K8HY1Hmascp2gscG5Zt3FkRJXLLZO', '::1', '2018-11-05 00:00:00', 'Truc', 'Amandine', '', 0),
(2, 'test3@test.com', '$2y$10$0S7geKGBzaWghYDONUV/g.Zvs58g7TtrtrKZauFQEXb746CetFtYG', '::1', '2018-11-05 00:00:00', 'Truc', 'getyhrhrt', '', 0),
(3, 'test2@test.fr', '$2y$10$2obMoJHw5OAg/x8CKSu4COLs2wFnlzbDhZpL98FH23He3SLdBHuxi', '::1', '2018-11-05 11:41:42', 'gyrturujty', 'getyhrhrt', '', 0),
(4, 'trucmachin@test.fr', '$2y$10$PKmXsDbF37WWnRRmIFawnOAeoT1N6a9E8hiSnLx4zCorYL3UzRU4i', '::1', '2018-11-05 11:53:47', 'gyrturujty', 'Amandine', '', 0),
(5, 'a@a.fr', '$2y$10$RoW4kdtSBGpXwdCwAz7QrOTkf3IUPLK1tlsikksOGi7tQY7SAZ5eC', '::1', '2018-11-05 12:00:42', 'rthtyjty', 'gdfhrthrt', '', 0),
(6, 'hgfh@rttry.gt', '$2y$10$upb.hZ3P6ZtQHlr02MMoI.ZQQOijAQaBPWTa6SDGAUsWMXVcqQWvO', '127.0.0.1', '2018-11-05 12:15:04', 'ggsd', 'erzer', '', 0),
(7, 'ttttt@tttt.ttt', '$2y$10$TtAJH2D1Wr8PxvQlENeUFeZ1SmsXYHJSZrZZ7nBad/NYIgyzKlEtS', '127.0.0.1', '2018-11-05 14:10:08', 'laurioz', 'benoit', '', 0);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
