-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Jeu 02 Avril 2015 à 10:21
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
  `text_event` text NOT NULL,
  `image_event` varchar(200) NOT NULL,
  `date_event` datetime NOT NULL,
  `date_update` datetime NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_jeu` int(11) NOT NULL,
  `statut_event` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_event`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=17 ;

--
-- Contenu de la table `event`
--

INSERT INTO `event` (`id_event`, `title_event`, `text_event`, `image_event`, `date_event`, `date_update`, `id_user`, `id_jeu`, `statut_event`) VALUES
(8, 'Une campagne épique', 'Sed ut tum ad senem senex de senectute, sic hoc libro ad amicum amicissimus scripsi de amicitia. Tum est Cato locutus, quo erat nemo fere senior temporibus illis, nemo prudentior; nunc Laelius et sapiens (sic enim est habitus) et amicitiae gloria excellens de amicitia loquetur. Tu velim a me animum parumper avertas, Laelium loqui ipsum putes. C. Fannius et Q. Mucius ad socerum veniunt post mortem Africani; ab his sermo oritur, respondet Laelius, cuius tota disputatio est de amicitia, quam legens te ipse cognosces.', 'images\\pathfinder\\pathfinder_0.jpg', '2015-03-31 20:30:00', '2015-03-08 20:04:15', 5, 1, 1),
(9, 'Une cave de sang frais', 'Sed ut tum ad senem senex de senectute, sic hoc libro ad amicum amicissimus scripsi de amicitia. Tum est Cato locutus, quo erat nemo fere senior temporibus illis, nemo prudentior; nunc Laelius et sapiens (sic enim est habitus) et amicitiae gloria excellens de amicitia loquetur. Tu velim a me animum parumper avertas, Laelium loqui ipsum putes. C. Fannius et Q. Mucius ad socerum veniunt post mortem Africani; ab his sermo oritur, respondet Laelius, cuius tota disputatio est de amicitia, quam legens te ipse cognosces.', 'images\\vampire\\vampire_0.jpg', '2015-04-15 10:20:00', '2015-03-08 21:54:16', 4, 3, 1),
(10, 'Les 7 merveilles du monde dans votre salon', 'Sed ut tum ad senem senex de senectute, sic hoc libro ad amicum amicissimus scripsi de amicitia. Tum est Cato locutus, quo erat nemo fere senior temporibus illis, nemo prudentior; nunc Laelius et sapiens (sic enim est habitus) et amicitiae gloria excellens de amicitia loquetur. Tu velim a me animum parumper avertas, Laelium loqui ipsum putes. C. Fannius et Q. Mucius ad socerum veniunt post mortem Africani; ab his sermo oritur, respondet Laelius, cuius tota disputatio est de amicitia, quam legens te ipse cognosces.', 'images\\jeux_de_plateaux\\jeux_de_plateaux_1.jpg', '2015-05-13 10:30:00', '2015-03-08 21:55:00', 6, 18, 1),
(11, 'L''attaque des orques', 'Sed ut tum ad senem senex de senectute, sic hoc libro ad amicum amicissimus scripsi de amicitia. Tum est Cato locutus, quo erat nemo fere senior temporibus illis, nemo prudentior; nunc Laelius et sapiens (sic enim est habitus) et amicitiae gloria excellens de amicitia loquetur. Tu velim a me animum parumper avertas, Laelium loqui ipsum putes. C. Fannius et Q. Mucius ad socerum veniunt post mortem Africani; ab his sermo oritur, respondet Laelius, cuius tota disputatio est de amicitia, quam legens te ipse cognosces.', 'images\\pathfinder\\pathfinder_0.jpg', '2015-03-06 21:10:00', '2015-03-05 21:14:05', 5, 1, 1),
(12, 'Une campagne vampirique', 'Nec minus feminae quoque calamitatum participes fuere similium. nam ex hoc quoque sexu peremptae sunt originis altae conplures, adulteriorum flagitiis obnoxiae vel stuprorum. inter quas notiores fuere Claritas et Flaviana, quarum altera cum duceretur ad mortem, indumento, quo vestita erat, abrepto, ne velemen quidem secreto membrorum sufficiens retinere permissa est. ideoque carnifex nefas admisisse convictus inmane, vivus exustus est.', 'images\\vampire\\vampire_0.jpg', '2015-06-03 13:15:00', '2015-03-08 21:54:22', 4, 3, 1),
(13, 'title_1', 'text1', '', '2015-04-02 09:21:37', '2015-04-02 09:21:37', 5, 0, 1),
(14, 'title_1', 'text1', '', '2015-04-02 09:22:34', '2015-04-02 09:22:34', 5, 1, 1),
(15, 'Hello', 'Test', '', '2015-04-02 09:25:12', '2015-04-02 09:25:12', 5, 2, 1),
(16, 'Test modif event', 'MOdification dun événement ', '', '2015-04-02 09:52:12', '2015-04-02 09:52:12', 5, 18, 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
