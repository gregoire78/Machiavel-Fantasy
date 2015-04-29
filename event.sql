-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Mer 29 Avril 2015 à 17:02
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
  `id_type_jeu` int(11) NOT NULL,
  `statut_event` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_event`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Contenu de la table `event`
--

INSERT INTO `event` (`id_event`, `title_event`, `image_event`, `text_event`, `date_event`, `date_update`, `id_user`, `id_type_jeu`, `statut_event`) VALUES
(1, 'Une campagne vampirique', 'images\\jeux\\pathfinder_0.jpg', 'Ceci est un vrai test', '2015-04-09 16:55:00', '2015-04-02 22:30:47', 2, 3, 1),
(2, 'Mon 1er evenement', 'images\\jeux\\vampire_0.jpg', 'fghjfgjhd', '2015-04-08 18:10:00', '2015-04-06 11:04:57', 2, 3, 1),
(3, 'Le printemps des orques', 'images\\jeux\\pathfinder_0.jpg', 'Excogitatum est super his, ut homines quidam ignoti, vilitate ipsa parum cavendi ad colligendos rumores per Antiochiae latera cuncta destinarentur relaturi quae audirent. hi peragranter et dissimulanter honoratorum circulis adsistendo pervadendoque divites domus egentium habitu quicquid noscere poterant vel audire latenter intromissi per posticas in regiam nuntiabant, id observantes conspiratione concordi, ut fingerent quaedam et cognita duplicarent in peius, laudes vero supprimerent Caesaris, quas invitis conpluribus formido malorum inpendentium exprimebat.\r\n\r\nQuid enim tam absurdum quam delectari multis inanimis rebus, ut honore, ut gloria, ut aedificio, ut vestitu cultuque corporis, animante virtute praedito, eo qui vel amare vel, ut ita dicam, redamare possit, non admodum delectari? Nihil est enim remuneratione benevolentiae, nihil vicissitudine studiorum officiorumque iucundius.', '2015-04-18 07:25:00', '2015-04-14 21:08:57', 1, 3, 1),
(4, 'Mon 1er evenement', 'images\\jeux\\jeu_de_role_5.jpg', 'sfgjytghjueytrgjgut-ytrghy', '2015-04-29 03:10:00', '2015-04-29 15:39:43', 1, 1, 1),
(5, 'Des vacances de mercenaires', 'images/icone_site/jeu-de-cartes-americaines.jpg', 'Livre 3 - Dearg : Episode 2\r\nCe supplément contient le deuxième épisode de la grande campagne des Ombres d’Esteren qui vous emmènera au cœur du royaume de Reizh et jusqu’aux portes de la capitale gwidrite d’Ard-Amrach ! Il inclut également “Dearg”, le deuxième album du collectif Esteren, composé par Jure Peternel.\r\n\r\n· La Part des Ombres. Cette aide de jeu explore le côté obscur des Personnages et les potentialités narratives et dramatiques qui y sont liées. Elle donne des conseils sur la manière de les mettre en scène dans la campagne des Ombres d’Esteren. Les joueurs pourront explorer la face sombre de leurs Arcs narratifs... Mais attention aux\r\nconséquences de leurs actes !', '2015-05-31 14:25:00', '2015-04-29 16:31:47', 1, 3, 1),
(6, '7 wonders of vacances', 'images\\jeux\\jeux_de_plateaux_1.jpg', 'Les Ombres d''Esteren est un jeu réalisé par le collectif Forgesonges et s''inscrit dans un ensemble comprenant en particulier un jeu vidéo. Divers compléments sont disponibles sur le net, comme de la musique ou des aventures dont vous êtes le héros. Il s''agit un jeu à secrets, qui met l''accent sur l''horreur. Le fantastique est présent mais reste relativement discret : l’univers ne met en scène que des êtres humains, et il n’y a pas de magiciens lançant des boules de feu. Les personnages sont des gens normaux qui vont être confrontés à l’horreur et au surnaturel.', '2015-06-06 12:45:00', '2015-04-29 16:32:01', 1, 2, 1),
(7, 'Test création événement', 'images\\icone_site\\jeu_de_role.png', 'Les Ombres d''Esteren est un jeu réalisé par le collectif Forgesonges et s''inscrit dans un ensemble comprenant en particulier un jeu vidéo. Divers compléments sont disponibles sur le net, comme de la musique.', '2015-05-22 16:15:00', '2015-04-29 16:31:29', 1, 1, 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
