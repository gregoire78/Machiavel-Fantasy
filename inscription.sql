-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Sam 02 Mai 2015 à 12:33
-- Version du serveur :  5.6.17
-- Version de PHP :  5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `machiavel_fantasy`
--

-- --------------------------------------------------------

--
-- Structure de la table `inscription`
--

CREATE TABLE IF NOT EXISTS `inscription` (
  `id_event` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `date_inscription` datetime NOT NULL,
  PRIMARY KEY (`id_event`,`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `inscription`
--

INSERT INTO `inscription` (`id_event`, `id_user`, `date_inscription`) VALUES
(1, 1, '2015-05-01 21:53:10'),
(1, 2, '2015-05-01 21:52:47'),
(1, 3, '2015-05-01 21:57:59'),
(2, 1, '2015-05-02 00:33:28'),
(2, 3, '2015-05-02 00:58:25'),
(2, 4, '2015-05-02 00:44:03'),
(3, 1, '2015-05-02 00:43:30'),
(3, 2, '2015-05-01 21:52:45'),
(4, 1, '2015-05-02 00:43:40'),
(4, 2, '2015-05-02 00:44:29'),
(4, 4, '2015-05-02 00:44:05'),
(5, 1, '2015-05-02 00:29:04'),
(5, 2, '2015-05-02 00:44:26'),
(5, 4, '2015-05-02 00:44:02');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
