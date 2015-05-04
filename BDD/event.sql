-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Lun 04 Mai 2015 à 13:16
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
-- Structure de la table `event`
--

CREATE TABLE IF NOT EXISTS `event` (
  `id_event` int(11) NOT NULL AUTO_INCREMENT,
  `title_event` varchar(50) NOT NULL,
  `image_event` varchar(255) NOT NULL,
  `text_event` text NOT NULL,
  `date_event` datetime NOT NULL,
  `date_update` datetime NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_jeu` int(11) DEFAULT NULL,
  `statut_event` int(1) NOT NULL DEFAULT '1',
  `inscription_event` int(11) DEFAULT NULL,
  `nb_inscrit` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_event`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Contenu de la table `event`
--

INSERT INTO `event` (`id_event`, `title_event`, `image_event`, `text_event`, `date_event`, `date_update`, `id_user`, `id_jeu`, `statut_event`, `inscription_event`, `nb_inscrit`) VALUES
(1, 'Une campagne vampirique', 'images\\jeux\\vampire_0.jpg', 'Les Ombres d''Esteren est un jeu réalisé par le collectif Forgesonges et s''inscrit dans un ensemble comprenant en particulier un jeu vidéo. Divers compléments sont disponibles sur le net, comme de la musique ou des aventures dont vous êtes le héros. Il s''agit un jeu à secrets, qui met l''accent sur l''horreur. Le fantastique est présent mais reste relativement discret : l’univers ne met en scène que des êtres humains, et il n’y a pas de magiciens lançant des boules de feu. Les personnages sont des gens normaux qui vont être confrontés à l’horreur et au surnaturel.', '2015-05-29 10:40:00', '2015-05-02 15:40:01', 1, 3, 1, 5, 1),
(2, 'Des vacances de mercenaires', 'images\\jeux\\jeu_de_role_5.jpg', 'Les Ombres d''Esteren est un jeu réalisé par le collectif Forgesonges et s''inscrit dans un ensemble comprenant en particulier un jeu vidéo. Divers compléments sont disponibles sur le net, comme de la musique ou des aventures dont vous êtes le héros. Il s''agit un jeu à secrets, qui met l''accent sur l''horreur. Le fantastique est présent mais reste relativement discret : l’univers ne met en scène que des êtres humains, et il n’y a pas de magiciens lançant des boules de feu. Les personnages sont des gens normaux qui vont être confrontés à l’horreur et au surnaturel.', '2015-05-15 07:05:00', '2015-05-02 15:35:09', 1, 20, 0, 3, 3),
(3, 'Gare aux monstres !!!', 'images\\jeux\\cthulhu_0.jpg', 'Les Ombres d''Esteren est un jeu réalisé par le collectif Forgesonges et s''inscrit dans un ensemble comprenant en particulier un jeu vidéo. Divers compléments sont disponibles sur le net, comme de la musique ou des aventures dont vous êtes le héros. Il s''agit un jeu à secrets, qui met l''accent sur l''horreur. Le fantastique est présent mais reste relativement discret : l’univers ne met en scène que des êtres humains, et il n’y a pas de magiciens lançant des boules de feu. Les personnages sont des gens normaux qui vont être confrontés à l’horreur et au surnaturel.', '2015-05-27 09:10:00', '2015-05-03 23:58:47', 1, 4, 1, 2, 2),
(4, 'Tournoi Netrunner', 'images\\jeux\\61uJRfdE7hL._SL1000_.jpg', 'Les Ombres d''Esteren est un jeu réalisé par le collectif Forgesonges et s''inscrit dans un ensemble comprenant en particulier un jeu vidéo. Divers compléments sont disponibles sur le net, comme de la musique ou des aventures dont vous êtes le héros. Il s''agit un jeu à secrets, qui met l''accent sur l''horreur. Le fantastique est présent mais reste relativement discret : l’univers ne met en scène que des êtres humains, et il n’y a pas de magiciens lançant des boules de feu. Les personnages sont des gens normaux qui vont être confrontés à l’horreur et au surnaturel.', '2015-05-21 13:50:00', '2015-05-02 19:49:40', 1, 25, 1, 4, 3),
(5, 'Une cave de sang frais', 'images\\jeux\\vampire_0.jpg', 'Annoncé l’année dernière en VF, Numenéra, le jeu de rôle de Monte Cook (l’auteur de JdR le plus connu aux USA) prend son envol. L’aventure de ce JdR aussi original dans ses règles (mêlant narrativisme et précision) que dans son univers (où la science est capable de tant de choses qu’elle en paraît magique) a tout d''abord débuté par un kickstarter très remarqué. Lequel a ensuite été suivi par trois autres kickstarters : Torment : Tide of Numenéra, un jeu vidéo d’une grande ampleur puisque conçu par les anciens de Planescape : Torment (un must !) et ayant rassemblé $ 4 188 927 ; un kickstarter pour financer une magnifique boîte (imaginée au départ par les éditeurs Italiens de Numenéra) qui lui a rassemblé $ 286 565 ; et Strand, un short-film situé dans le Neuvième Monde de Monte Cook dont la bande annonce est alléchante et  financé à $ 40 000.', '2015-05-09 14:35:00', '2015-05-03 01:15:45', 1, 3, 1, 4, 2),
(6, 'A fond avec formule Dés !!', 'images/icone_site/calendrier.jpg', 'Modern versions of assistive technologies will announce CSS generated content, as well as specific Unicode characters. To avoid unintended and confusing output in screen readers (particularly when icons are used purely for decoration), we hide them with the aria-hidden="true" attribute.\r\n\r\nIf you''re using an icon to convey meaning (rather than only as a decorative element), ensure that this meaning is also conveyed to assistive technologies – for instance, include additional content, visually hidden with the .sr-only class.', '2015-05-17 13:30:00', '2015-05-02 19:59:29', 1, 0, 1, 4, 1),
(7, 'Une campagne vampirique', 'images\\jeux\\cthulhu_0.jpg', 'Soutenu par une gamme conséquente et de de qualité en VO (notons par exemple le Character Options, le Ninth World Bestiary, la campagne Devil''s Spine ou encore le magnifique Ninth World Guide Book), nous espérons que le succès sera au rendez-vous, de sorte que toute l''équipe puisse envisager la parution en français de nombreux suppléments. Il n''y a pas de recette miracle, plus un jeu fonctionnera bien, plus le suivi sera conséquent !', '2015-05-13 13:30:00', '2015-05-04 12:59:22', 1, 4, 1, 3, 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
