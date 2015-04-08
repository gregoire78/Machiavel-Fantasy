-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Mar 31 Mars 2015 à 10:46
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
-- Structure de la table `type_jeu`
--

CREATE TABLE IF NOT EXISTS `type_jeu` (
  `id_type_jeu` int(11) NOT NULL AUTO_INCREMENT,
  `libelle_type_jeu` varchar(50) NOT NULL,
  `description_type_jeu` varchar(300) NOT NULL,
  `image_type_jeu` varchar(200) NOT NULL,
  PRIMARY KEY (`id_type_jeu`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=22 ;

--
-- Contenu de la table `type_jeu`
--

INSERT INTO `type_jeu` (`id_type_jeu`, `libelle_type_jeu`, `description_type_jeu`, `image_type_jeu`) VALUES
(1, 'Jeu de rôle', 'Vbi curarum abiectis ponderibus aliis tamquam nodum et codicem difficillimum Caesarem convellere nisu valido cogitabat, eique deliberanti cum proximis clandestinis conloquiis et nocturnis qua vi, quibusve commentis id fieret, antequam effundendis rebus pertinacius incumberet confidentia, acciri moll', 'images/icone_site/jeu_de_role.jpg'),
(2, 'Jeu de plateau', 'Quibus occurrere bene pertinax miles explicatis ordinibus parans hastisque feriens scuta qui habitus iram pugnantium concitat et dolorem proximos iam gestu terrebat sed eum in certamen alacriter consurgentem revocavere ductores rati intempestivum anceps subire certamen cum haut longe muri distarent,', 'images/icone_site/jeu_de_plateau.jpg'),
(3, 'Jeu de carte', 'Inter haec Orfitus praefecti potestate regebat urbem aeternam ultra modum delatae dignitatis sese efferens insolenter, vir quidem prudens et forensium negotiorum oppido gnarus, sed splendore liberalium doctrinarum minus quam nobilem decuerat institutus, quo administrante seditiones sunt concitatae g', 'images/icone_site/jeu-de-cartes-americaines.jpg');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
