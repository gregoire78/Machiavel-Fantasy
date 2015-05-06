-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Jeu 07 Mai 2015 à 00:44
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
-- Structure de la table `historique`
--

CREATE TABLE IF NOT EXISTS `historique` (
  `id_historique` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `table_historique` int(1) NOT NULL COMMENT '1 = forum ; 2 = événement  ;  3 = administration;  4 = jeu ; 5 = users',
  `text_historique` varchar(100) NOT NULL,
  `date_historique` datetime NOT NULL,
  PRIMARY KEY (`id_historique`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=22 ;

--
-- Contenu de la table `historique`
--

INSERT INTO `historique` (`id_historique`, `id_user`, `table_historique`, `text_historique`, `date_historique`) VALUES
(1, 1, 2, 'L''utilisateur s''est inscrit à un événement', '2015-05-06 16:21:27'),
(2, 1, 2, 'L''utilisateur s''est désinscrit d''un événement', '2015-05-06 16:21:29'),
(3, 1, 2, 'L''utilisateur à mis à jour l''événement Les mur ont des oreilles', '2015-05-06 16:39:13'),
(4, 1, 2, 'L''utilisateur à mis à jour l''événement : Des vacances de mercenaires', '2015-05-06 16:44:02'),
(5, 1, 2, 'L''utilisateur s''est inscrit à un événement : A fond avec formule Dés !!', '2015-05-06 17:00:50'),
(6, 1, 2, 'L''utilisateur s''est désinscrit d''un événement : ', '2015-05-06 17:01:28'),
(7, 1, 2, 'L''utilisateur s''est inscrit à un événement : Une campagne vampirique', '2015-05-06 17:01:32'),
(8, 1, 2, 'L''utilisateur s''est désinscrit d''un événement : ', '2015-05-06 17:01:34'),
(9, 1, 2, 'L''utilisateur s''est inscrit à un événement : Une campagne vampirique', '2015-05-06 17:02:24'),
(10, 1, 2, 'L''utilisateur s''est désinscrit d''un événement : Des vacances de mercenaires', '2015-05-06 17:02:34'),
(11, 1, 2, 'L''utilisateur s''est inscrit à un événement : Des vacances de mercenaires', '2015-05-06 17:02:35'),
(12, 1, 2, 'L''utilisateur a supprimer l''événement : Tournoi Netrunner', '2015-05-06 17:14:16'),
(13, 7, 5, 'L''utilisateur s''est inscrit', '2015-05-06 17:55:37'),
(14, 7, 5, 'L''utilisateur a modifié son mot de passe', '2015-05-06 18:08:51'),
(15, 7, 5, 'L''utilisateur a modifié son mot de passe', '2015-05-06 18:09:31'),
(16, 1, 2, 'L''utilisateur s''est inscrit à l''événement : Une cave de sang frais', '2015-05-06 22:50:03'),
(17, 1, 2, 'L''utilisateur s''est désinscrit de l''événement : Une cave de sang frais', '2015-05-06 22:52:09'),
(18, 1, 2, 'L''utilisateur s''est inscrit à l''événement : Une cave de sang frais', '2015-05-06 22:56:12'),
(19, 1, 2, 'L''utilisateur s''est désinscrit de l''événement : Une cave de sang frais', '2015-05-06 22:59:54'),
(20, 1, 2, 'L''utilisateur s''est inscrit à l''événement : Une cave de sang frais', '2015-05-06 23:01:44'),
(21, 1, 2, 'L''utilisateur s''est désinscrit de l''événement : Une cave de sang frais', '2015-05-06 23:01:45');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
