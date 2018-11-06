-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le :  mar. 06 nov. 2018 à 09:18
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
-- Structure de la table `article`
--

CREATE TABLE `article` (
  `article_id` int(11) NOT NULL,
  `article_title` varchar(50) NOT NULL,
  `article_date` date NOT NULL,
  `article_author` int(11) NOT NULL,
  `article_content` varchar(2000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `article`
--

INSERT INTO `article` (`article_id`, `article_title`, `article_date`, `article_author`, `article_content`) VALUES
(1, '6795', '2006-12-19', 8, 'Blabla'),
(2, '1652', '2007-06-27', 0, 'Blabla'),
(3, '5656', '2006-11-07', 0, 'Blabla'),
(4, '4367', '2006-11-20', 0, 'Blabla'),
(5, '1865', '2012-03-28', 0, 'Blabla'),
(6, '4942', '2010-12-01', 0, 'Blabla'),
(7, '3089', '2002-04-02', 0, 'Blabla'),
(8, '177', '2005-01-09', 0, 'Blabla'),
(9, '1139', '2014-03-13', 0, 'Blabla'),
(10, '8372', '2006-12-06', 0, 'Blabla'),
(11, '1774', '2003-08-21', 0, 'Blabla'),
(12, '1347', '2002-07-15', 0, 'Blabla'),
(13, '4320', '2010-04-04', 0, 'Blabla'),
(14, '534', '2004-12-03', 0, 'Blabla'),
(15, '3833', '2017-02-11', 0, 'Blabla'),
(16, '9694', '2016-09-30', 0, 'Blabla'),
(17, '2434', '2011-02-08', 0, 'Blabla'),
(18, '788', '2011-08-04', 0, 'Blabla'),
(19, '1267', '2003-06-30', 0, 'Blabla'),
(20, '9070', '2003-08-18', 0, 'Blabla'),
(21, '1418', '2010-02-01', 0, 'Blabla'),
(22, '1020', '2004-09-28', 0, 'Blabla'),
(23, '7495', '2009-08-17', 0, 'Blabla'),
(24, '2687', '2011-10-07', 0, 'Blabla'),
(25, '2953', '2011-01-05', 0, 'Blabla'),
(26, '5162', '2014-08-18', 0, 'Blabla'),
(27, '1104', '2012-10-31', 0, 'Blabla'),
(28, '3640', '2007-07-01', 0, 'Blabla'),
(29, '4444', '2005-07-12', 0, 'Blabla'),
(30, '3575', '2014-04-30', 0, 'Blabla'),
(31, '9006', '2006-07-27', 0, 'Blabla'),
(32, '6205', '2015-01-11', 0, 'Blabla'),
(33, '2231', '2009-07-20', 0, 'Blabla'),
(34, '9156', '2007-08-24', 0, 'Blabla'),
(35, '5097', '2002-07-27', 0, 'Blabla'),
(36, '7023', '2010-04-02', 0, 'Blabla'),
(37, '5678', '2008-05-06', 0, 'Blabla'),
(38, '6726', '2013-05-14', 0, 'Blabla'),
(39, '8969', '2010-12-17', 0, 'Blabla'),
(40, '8906', '2008-02-07', 0, 'Blabla'),
(41, '338', '2004-01-23', 0, 'Blabla'),
(42, '2822', '2011-09-15', 0, 'Blabla'),
(43, '5016', '2008-02-29', 0, 'Blabla'),
(44, '4691', '2006-08-16', 0, 'Blabla'),
(45, '4343', '2005-05-13', 0, 'Blabla'),
(46, '5291', '2005-10-16', 0, 'Blabla'),
(47, '1266', '2015-08-23', 0, 'Blabla'),
(48, '1437', '2017-03-24', 0, 'Blabla'),
(49, '6444', '2002-08-24', 0, 'Blabla'),
(50, '6236', '2013-05-16', 0, 'Blabla');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
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

INSERT INTO `user` (`user_id`, `user_email`, `user_password`, `user_ip`, `user_date`, `user_lastname`, `user_firstname`, `user_key`, `user_active`) VALUES
(0, 'exemple@exemple.fr', '$2y$10$66kFP3/C.NU9Hk6nU6srue.5K8HY1Hmascp2gscG5Zt3FkRJXLLZO', '::1', '2018-11-05 00:00:00', 'Truc', 'Amandine', '', 0),
(2, 'test3@test.com', '$2y$10$0S7geKGBzaWghYDONUV/g.Zvs58g7TtrtrKZauFQEXb746CetFtYG', '::1', '2018-11-05 00:00:00', 'Truc', 'getyhrhrt', '', 0),
(3, 'test2@test.fr', '$2y$10$2obMoJHw5OAg/x8CKSu4COLs2wFnlzbDhZpL98FH23He3SLdBHuxi', '::1', '2018-11-05 11:41:42', 'gyrturujty', 'getyhrhrt', '', 0),
(4, 'trucmachin@test.fr', '$2y$10$PKmXsDbF37WWnRRmIFawnOAeoT1N6a9E8hiSnLx4zCorYL3UzRU4i', '::1', '2018-11-05 11:53:47', 'gyrturujty', 'Amandine', '', 0),
(5, 'a@a.fr', '$2y$10$RoW4kdtSBGpXwdCwAz7QrOTkf3IUPLK1tlsikksOGi7tQY7SAZ5eC', '::1', '2018-11-05 12:00:42', 'rthtyjty', 'gdfhrthrt', '', 0),
(6, 'hgfh@rttry.gt', '$2y$10$upb.hZ3P6ZtQHlr02MMoI.ZQQOijAQaBPWTa6SDGAUsWMXVcqQWvO', '127.0.0.1', '2018-11-05 12:15:04', 'ggsd', 'erzer', '', 0),
(7, 'ttttt@tttt.ttt', '$2y$10$TtAJH2D1Wr8PxvQlENeUFeZ1SmsXYHJSZrZZ7nBad/NYIgyzKlEtS', '127.0.0.1', '2018-11-05 14:10:08', 'laurioz', 'benoit', '', 0),
(8, 'aaa@aaaa.fr', '$2y$10$YyAaD.Xeh9IjFc99yDVoMOSbvu14BwfJUnjS5MPJ13c2MPQptpADq', '::1', '2018-11-05 14:46:07', 'Truc', 'amandine', '', 1),
(9, 'bbb@bbb.fr', '$2y$10$VEnjL7cK0eBvQxvhrEH8puk0L7SkJGVq19VhKu0dV55pS4tz21Lg.', '::1', '2018-11-05 15:14:15', 'truc', 'amandine', '', 0),
(10, 'cccc@cccc.cc', '$2y$10$9G5byHDxSPDF.Bec6lQKVOpDdKnbkkm3zpVgvTAp7WtYmR.rwKjMy', '::1', '2018-11-05 15:20:07', 'gyrturujty', 'Amandine', '4e70631898f427197662a5e95851be93', 1),
(11, 'dddddd@ddddd.dd', '$2y$10$XtEpw0sIXiGMkCETciB/hOkPwnLFaE0qUMWgLmONjVG7psX7JUyju', '::1', '2018-11-05 15:59:22', 'truc', 'Amandine', '5ea7b4f80b7ee808c3dbb62689fe38d3', 1),
(12, 'eeeeeee@eeeee.ee', '$2y$10$8W5kb62FkC9eld/.9io1wOtf0o8UbKhCqY9VtCFU9ERBCo7Kj/5LK', '::1', '2018-11-05 16:03:49', 'truc', 'amandine', 'c5ce06069b4e7cc02ad03ffdbc190287', 1);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `article`
--
ALTER TABLE `article`
  ADD PRIMARY KEY (`article_id`),
  ADD KEY `article_author` (`article_author`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `article`
--
ALTER TABLE `article`
  MODIFY `article_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `article`
--
ALTER TABLE `article`
  ADD CONSTRAINT `article_ibfk_1` FOREIGN KEY (`article_author`) REFERENCES `user` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
