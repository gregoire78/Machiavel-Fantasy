-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Jeu 02 Avril 2015 à 10:22
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
-- Structure de la table `club`
--

CREATE TABLE IF NOT EXISTS `club` (
  `text_club` longtext NOT NULL,
  `date_update` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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

-- --------------------------------------------------------

--
-- Structure de la table `jeu`
--

CREATE TABLE IF NOT EXISTS `jeu` (
  `id_jeu` int(11) NOT NULL AUTO_INCREMENT,
  `title_jeu` varchar(50) NOT NULL,
  `text_jeu` longtext NOT NULL,
  `image_jeu` varchar(200) NOT NULL,
  `id_type_jeu` int(11) NOT NULL,
  `date_update` datetime NOT NULL,
  `id_user` int(11) NOT NULL,
  `statut_jeu` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_jeu`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=22 ;

--
-- Contenu de la table `jeu`
--

INSERT INTO `jeu` (`id_jeu`, `title_jeu`, `text_jeu`, `image_jeu`, `id_type_jeu`, `date_update`, `id_user`, `statut_jeu`) VALUES
(1, 'Pathfinder', '<p>Ca devrait &ecirc;tre bon !</p>\r\n', 'images\\jeux\\pathfinder_0.jpg', 1, '2015-03-07 23:48:09', 5, 1),
(2, 'Cyberpunk', '', 'images\\jeux\\cyberpunk_2020_0.jpg', 1, '2015-03-08 21:52:42', 5, 1),
(3, 'Vampire', '<p>Sed maximum est in amicitia parem esse inferiori. Saepe enim excellentiae quaedam sunt, qualis erat Scipionis in nostro, ut ita dicam, grege. Numquam se ille Philo, numquam Rupilio, numquam Mummio anteposuit, numquam inferioris ordinis amicis, Q. vero Maximum fratrem, egregium virum omnino, sibi nequaquam parem, quod is anteibat aetate, tamquam superiorem colebat suosque omnes per se posse esse ampliores volebat.<br />\r\n<br />\r\nIpsam vero urbem Byzantiorum fuisse refertissimam atque ornatissimam signis quis ignorat? Quae illi, exhausti sumptibus bellisque maximis, cum omnis Mithridaticos impetus totumque Pontum armatum affervescentem in Asiam atque erumpentem, ore repulsum et cervicibus interclusum suis sustinerent, tum, inquam, Byzantii et postea signa illa et reliqua urbis ornanemta sanctissime custodita tenuerunt.<br />\r\n<br />\r\nQuis enim aut eum diligat quem metuat, aut eum a quo se metui putet? Coluntur tamen simulatione dumtaxat ad tempus. Quod si forte, ut fit plerumque, ceciderunt, tum intellegitur quam fuerint inopes amicorum. Quod Tarquinium dixisse ferunt, tum exsulantem se intellexisse quos fidos amicos habuisset, quos infidos, cum iam neutris gratiam referre posset.<br />\r\n<br />\r\nVerum ad istam omnem orationem brevis est defensio. Nam quoad aetas M. Caeli dare potuit isti suspicioni locum, fuit primum ipsius pudore, deinde etiam patris diligentia disciplinaque munita. Qui ut huic virilem togam dedit&scaron;nihil dicam hoc loco de me; tantum sit, quantum vos existimatis; hoc dicam, hunc a patre continuo ad me esse deductum; nemo hunc M. Caelium in illo aetatis flore vidit nisi aut cum patre aut mecum aut in M. Crassi castissima domo, cum artibus honestissimis erudiretur.<br />\r\n<br />\r\nErgo ego senator inimicus, si ita vultis, homini, amicus esse, sicut semper fui, rei publicae debeo. Quid? si ipsas inimicitias, depono rei publicae causa, quis me tandem iure reprehendet, praesertim cum ego omnium meorum consiliorum atque factorum exempla semper ex summorum hominum consiliis atque factis mihi censuerim petenda.</p>\r\n', 'images\\jeux\\vampire_0.jpg', 1, '2015-03-08 21:53:11', 5, 1),
(4, 'L''Appel de Cthulu', '<p>Nec minus feminae quoque calamitatum participes fuere similium. nam ex hoc quoque sexu peremptae sunt originis altae conplures, adulteriorum flagitiis obnoxiae vel stuprorum. inter quas notiores fuere Claritas et Flaviana, quarum altera cum duceretur ad mortem, indumento, quo vestita erat, abrepto, ne velemen quidem secreto membrorum sufficiens retinere permissa est. ideoque carnifex nefas admisisse convictus inmane, vivus exustus est.</p>\r\n\r\n<p>Harum trium sententiarum nulli prorsus assentior. Nec enim illa prima vera est, ut, quem ad modum in se quisque sit, sic in amicum sit animatus. Quam multa enim, quae nostra causa numquam faceremus, facimus causa amicorum! precari ab indigno, supplicare, tum acerbius in aliquem invehi insectarique vehementius, quae in nostris rebus non satis honeste, in amicorum fiunt honestissime; multaeque res sunt in quibus de suis commodis viri boni multa detrahunt detrahique patiuntur, ut iis amici potius quam ipsi fruantur.</p>\r\n\r\n<p>Et quoniam mirari posse quosdam peregrinos existimo haec lecturos forsitan, si contigerit, quamobrem cum oratio ad ea monstranda deflexerit quae Romae gererentur, nihil praeter seditiones narratur et tabernas et vilitates harum similis alias, summatim causas perstringam nusquam a veritate sponte propria digressurus.</p>\r\n', 'images\\jeux\\cthulhu_0.jpg', 1, '2015-03-07 23:10:36', 5, 1),
(16, 'Le Livre des 5 Anneaux', '<p style="text-align:justify"><strong>Sed maximum est in amicitia pare</strong>m esse inferiori. Saepe enim excellentiae quaedam sunt, qualis erat Scipionis in nostro, ut ita dicam, grege. Numquam se ille Philo, numquam Rupilio, numquam Mummio anteposuit, numquam inferioris ordinis amicis, Q. vero Maximum fratrem, egregium virum omnino, sibi nequaquam par<em>em, quod is anteibat aetate, tamquam superiorem colebat suosque omnes per se posse esse ampliores volebat.</em></p>\r\n\r\n<p style="text-align:justify"><em>Ipsam vero urbem Byzantiorum fuiss</em>e refertissimam atque ornatissimam signis quis ignorat? Quae illi, exhausti sumptibus bellisque maximis, cum omnis Mithridaticos impetus totumque Pontum armatum affervescentem in Asiam atque erumpentem, ore repulsum et cervicibus interclusum suis sustinerent, tum, inquam, Byzantii et postea signa illa et reliqua urbis ornanemta sanctissime custodita tenuerunt.</p>\r\n\r\n<p>Quis enim aut eum diligat quem metuat, aut eum a quo se metui putet? Coluntur tamen simulatione dumtaxat ad tempus. Quod si forte, ut fit plerumque, ceciderunt, tum intellegitur quam fuerint inopes amicorum. Quod Tarquinium dixisse ferunt, tum exsulantem se intellexisse quos fidos amicos habuisset, quos infidos, cum iam neutris gratiam referre posset.</p>\r\n\r\n<p>Verum ad istam omnem orationem brevis est defensio. Nam quoad aetas M. Caeli dare potuit isti suspicioni locum, fuit primum ipsius pudore, deinde etiam patris diligentia disciplinaque munita. Qui ut huic virilem togam dedit&scaron;nihil dicam hoc loco de me; tantum sit, quantum vos existimatis; hoc dicam, hunc a patre continuo ad me esse deductum; nemo hunc M. Caelium in illo aetatis flore vidit nisi aut cum patre aut mecum aut in M. Crassi castissima domo, cum artibus honestissimis erudiretur.</p>\r\n\r\n<p>Ergo ego senator inimicus, si ita vultis, homini, amicus esse, sicut semper fui, rei publicae debeo. Quid? si ipsas inimicitias, depono rei publicae causa, quis me tandem iure reprehendet, praesertim cum ego omnium meorum consiliorum atque factorum exempla semper ex summorum hominum consiliis atque factis mihi censuerim petenda.</p>\r\n', 'images\\jeux\\jeu_de_role_4.jpg', 1, '2015-03-08 21:53:40', 5, 1),
(17, 'Test ajouter jeu avec my editor 2', '<p>Sed maximum est in amicitia parem esse inferiori. Saepe enim excellentiae quaedam sunt, qualis erat Scipionis in nostro, ut ita dicam, grege. Numquam se ille Philo, numquam Rupilio, numquam Mummio anteposuit, numquam inferioris ordinis amicis, Q. vero Maximum fratrem, egregium virum omnino, sibi nequaquam parem, quod is anteibat aetate, tamquam superiorem colebat suosque omnes per se posse esse ampliores volebat.</p>\r\n\r\n<p>Ipsam vero urbem Byzantiorum fuisse refertissimam atque ornatissimam signis quis ignorat? Quae illi, exhausti sumptibus bellisque maximis, cum omnis Mithridaticos impetus totumque Pontum armatum affervescentem in Asiam atque erumpentem, ore repulsum et cervicibus interclusum suis sustinerent, tum, inquam, Byzantii et postea signa illa et reliqua urbis ornanemta sanctissime custodita tenuerunt.</p>\r\n\r\n<p>Quis enim aut eum diligat quem metuat, aut eum a quo se metui putet? Coluntur tamen simulatione dumtaxat ad tempus. Quod si forte, ut fit plerumque, ceciderunt, tum intellegitur quam fuerint inopes amicorum. Quod Tarquinium dixisse ferunt, tum exsulantem se intellexisse quos fidos amicos habuisset, quos infidos, cum iam neutris gratiam referre posset.</p>\r\n\r\n<p>Verum ad istam omnem orationem brevis est defensio. Nam quoad aetas M. Caeli dare potuit isti suspicioni locum, fuit primum ipsius pudore, deinde etiam patris diligentia disciplinaque munita. Qui ut huic virilem togam dedit&scaron;nihil dicam hoc loco de me; tantum sit, quantum vos existimatis; hoc dicam, hunc a patre continuo ad me esse deductum; nemo hunc M. Caelium in illo aetatis flore vidit nisi aut cum patre aut mecum aut in M. Crassi castissima domo, cum artibus honestissimis erudiretur.</p>\r\n\r\n<p>Ergo ego senator inimicus, si ita vultis, homini, amicus esse, sicut semper fui, rei publicae debeo. Quid? si ipsas inimicitias, depono rei publicae causa, quis me tandem iure reprehendet, praesertim cum ego omnium meorum consiliorum atque factorum exempla semper ex summorum hominum consiliis atque factis mihi censuerim petenda.</p>\r\n', '', 2, '2015-03-07 02:35:39', 5, 1),
(18, '7 Wonders', '<p>Sed maximum est in amicitia parem esse inferiori. Saepe enim excellentiae quaedam sunt, qualis erat Scipionis in nostro, ut ita dicam, grege. Numquam se ille Philo, numquam Rupilio, numquam Mummio anteposuit, numquam inferioris ordinis amicis, Q. vero Maximum fratrem, egregium virum omnino, sibi nequaquam parem, quod is anteibat aetate, tamquam superiorem colebat suosque omnes per se posse esse ampliores volebat.</p>\r\n\r\n<p>Ipsam vero urbem Byzantiorum fuisse refertissimam atque ornatissimam signis quis ignorat? Quae illi, exhausti sumptibus bellisque maximis, cum omnis Mithridaticos impetus totumque Pontum armatum affervescentem in Asiam atque erumpentem, ore repulsum et cervicibus interclusum suis sustinerent, tum, inquam, Byzantii et postea signa illa et reliqua urbis ornanemta sanctissime custodita tenuerunt.</p>\r\n\r\n<p>Quis enim aut eum diligat quem metuat, aut eum a quo se metui putet? Coluntur tamen simulatione dumtaxat ad tempus. Quod si forte, ut fit plerumque, ceciderunt, tum intellegitur quam fuerint inopes amicorum. Quod Tarquinium dixisse ferunt, tum exsulantem se intellexisse quos fidos amicos habuisset, quos infidos, cum iam neutris gratiam referre posset.</p>\r\n\r\n<p>Verum ad istam omnem orationem brevis est defensio. Nam quoad aetas M. Caeli dare potuit isti suspicioni locum, fuit primum ipsius pudore, deinde etiam patris diligentia disciplinaque munita. Qui ut huic virilem togam dedit&scaron;nihil dicam hoc loco de me; tantum sit, quantum vos existimatis; hoc dicam, hunc a patre continuo ad me esse deductum; nemo hunc M. Caelium in illo aetatis flore vidit nisi aut cum patre aut mecum aut in M. Crassi castissima domo, cum artibus honestissimis erudiretur.</p>\r\n\r\n<p>Ergo ego senator inimicus, si ita vultis, homini, amicus esse, sicut semper fui, rei publicae debeo. Quid? si ipsas inimicitias, depono rei publicae causa, quis me tandem iure reprehendet, praesertim cum ego omnium meorum consiliorum atque factorum exempla semper ex summorum hominum consiliis atque factis mihi censuerim petenda.</p>\r\n', 'images\\jeux\\jeux_de_plateaux_1.jpg', 2, '2015-03-08 21:54:49', 5, 1),
(19, 'Test ajouter jeu avec my editor 2', '<p style="text-align: right;"><span style="background-color:rgb(255, 255, 255); color:rgb(126, 117, 75); font-family:verdana,arial,helvetica,sans-serif; font-size:10px">Ce texte g&eacute;n&eacute;r&eacute; al&eacute;atoirement (lorem ipsum) peut-&ecirc;tre utilis&eacute; dans vos maquettes (webdesign, sites internet, livres, affiches...) gratuitement. Ce texte est enti&egrave;rement libre de droit.</span><br />\r\n<span style="background-color:rgb(255, 255, 255); color:rgb(126, 117, 75); font-family:verdana,arial,helvetica,sans-serif; font-size:10px">N&#39;h&eacute;sitez pas &agrave; faire un lien sur ce site en utilisant l&#39;image ci-dessous ou en faisant un simple lien texte&nbsp;:</span></p>\r\n', '', 2, '2015-03-06 19:48:56', 5, 1),
(20, 'Donjon et Dragon 3.5', '<p>Sed maximum est in amicitia parem esse inferiori. Saepe enim excellentiae quaedam sunt, qualis erat Scipionis in nostro, ut ita dicam, grege. Numquam se ille Philo, numquam Rupilio, numquam Mummio anteposuit, numquam inferioris ordinis amicis, Q. vero Maximum fratrem, egregium virum omnino, sibi nequaquam parem, quod is anteibat aetate, tamquam superiorem colebat suosque omnes per se posse esse ampliores volebat.</p>\r\n\r\n<p>Ipsam vero urbem Byzantiorum fuisse refertissimam atque ornatissimam signis quis ignorat? Quae illi, exhausti sumptibus bellisque maximis, cum omnis Mithridaticos impetus totumque Pontum armatum affervescentem in Asiam atque erumpentem, ore repulsum et cervicibus interclusum suis sustinerent, tum, inquam, Byzantii et postea signa illa et reliqua urbis ornanemta sanctissime custodita tenuerunt.</p>\r\n\r\n<p>Quis enim aut eum diligat quem metuat, aut eum a quo se metui putet? Coluntur tamen simulatione dumtaxat ad tempus. Quod si forte, ut fit plerumque, ceciderunt, tum intellegitur quam fuerint inopes amicorum. Quod Tarquinium dixisse ferunt, tum exsulantem se intellexisse quos fidos amicos habuisset, quos infidos, cum iam neutris gratiam referre posset.</p>\r\n\r\n<p>Verum ad istam omnem orationem brevis est defensio. Nam quoad aetas M. Caeli dare potuit isti suspicioni locum, fuit primum ipsius pudore, deinde etiam patris diligentia disciplinaque munita. Qui ut huic virilem togam dedit&scaron;nihil dicam hoc loco de me; tantum sit, quantum vos existimatis; hoc dicam, hunc a patre continuo ad me esse deductum; nemo hunc M. Caelium in illo aetatis flore vidit nisi aut cum patre aut mecum aut in M. Crassi castissima domo, cum artibus honestissimis erudiretur.</p>\r\n\r\n<p>Ergo ego senator inimicus, si ita vultis, homini, amicus esse, sicut semper fui, rei publicae debeo. Quid? si ipsas inimicitias, depono rei publicae causa, quis me tandem iure reprehendet, praesertim cum ego omnium meorum consiliorum atque factorum exempla semper ex summorum hominum consiliis atque factis mihi censuerim petenda.</p>\r\n', 'images\\jeux\\jeu_de_role_5.jpg', 1, '2015-03-06 23:06:05', 5, 1),
(21, 'Quorridor', '<p><strong>Sed maximum est in amicitia parem esse inferiori. Saepe enim excellentiae quaedam sunt, qualis erat Scipionis in nostro, ut ita dicam, grege. Numquam se ille Philo, numquam Rupilio, numquam Mummio anteposuit, numquam inferioris ordinis amicis, Q. vero Maximum fratrem, egregium virum omnino, sibi nequaquam parem, quod is anteibat aetate, tamquam superiorem colebat suosque omnes per se posse esse ampliores volebat.</strong></p>\r\n\r\n<p>Ipsam vero urbem Byzantiorum fuisse refertissimam atque ornatissimam signis quis ignorat? Quae illi, exhausti sumptibus bellisque maximis, cum omnis Mithridaticos impetus totumque Pontum armatum affervescentem in Asiam atque erumpentem, ore repulsum et cervicibus interclusum suis sustinerent, tum, inquam, Byzantii et postea signa illa et reliqua urbis ornanemta sanctissime custodita tenuerunt.</p>\r\n\r\n<p>Quis enim aut eum diligat quem metuat, aut eum a quo se metui putet? Coluntur tamen simulatione dumtaxat ad tempus. Quod si forte, ut fit plerumque, ceciderunt, tum intellegitur quam fuerint inopes amicorum. Quod Tarquinium dixisse ferunt, tum exsulantem se intellexisse quos fidos amicos habuisset, quos infidos, cum iam neutris gratiam referre posset.</p>\r\n\r\n<p>Verum ad istam omnem orationem brevis est defensio. Nam quoad aetas M. Caeli dare potuit isti suspicioni locum, fuit primum ipsius pudore, deinde etiam patris diligentia disciplinaque munita. Qui ut huic virilem togam dedit&scaron;nihil dicam hoc loco de me; tantum sit, quantum vos existimatis; hoc dicam, hunc a patre continuo ad me esse deductum; nemo hunc M. Caelium in illo aetatis flore vidit nisi aut cum patre aut mecum aut in M. Crassi castissima domo, cum artibus honestissimis erudiretur.</p>\r\n\r\n<p>Ergo ego senator inimicus, si ita vultis, homini, amicus esse, sicut semper fui, rei publicae debeo. Quid? si ipsas inimicitias, depono rei publicae causa, quis me tandem iure reprehendet, praesertim cum ego omnium meorum consiliorum atque factorum exempla semper ex summorum hominum consiliis atque factis mihi censuerim petenda.</p>\r\n', 'images\\jeux\\jeux_de_plateaux_0.jpg', 2, '2015-03-06 23:18:58', 5, 1);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Contenu de la table `type_jeu`
--

INSERT INTO `type_jeu` (`id_type_jeu`, `libelle_type_jeu`, `description_type_jeu`, `image_type_jeu`) VALUES
(1, 'Jeu de rôle', 'Vbi curarum abiectis ponderibus aliis tamquam nodum et codicem difficillimum Caesarem convellere nisu valido cogitabat, eique deliberanti cum proximis clandestinis conloquiis et nocturnis qua vi, quibusve commentis id fieret, antequam effundendis rebus pertinacius incumberet confidentia, acciri moll', 'images/icone_site/jeu_de_role.jpg'),
(2, 'Jeu de plateau', 'Quibus occurrere bene pertinax miles explicatis ordinibus parans hastisque feriens scuta qui habitus iram pugnantium concitat et dolorem proximos iam gestu terrebat sed eum in certamen alacriter consurgentem revocavere ductores rati intempestivum anceps subire certamen cum haut longe muri distarent,', 'images/icone_site/jeu_de_plateau.jpg'),
(3, 'Jeu de carte', 'Inter haec Orfitus praefecti potestate regebat urbem aeternam ultra modum delatae dignitatis sese efferens insolenter, vir quidem prudens et forensium negotiorum oppido gnarus, sed splendore liberalium doctrinarum minus quam nobilem decuerat institutus, quo administrante seditiones sunt concitatae g', 'images/icone_site/jeu-de-cartes-americaines.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `pseudo` varchar(35) NOT NULL,
  `civility` varchar(4) NOT NULL,
  `lastname` varchar(35) NOT NULL,
  `firstname` varchar(35) NOT NULL,
  `password` varchar(100) NOT NULL,
  `email` varchar(320) NOT NULL,
  `date_register` datetime NOT NULL,
  `date_lastco` datetime NOT NULL,
  `ip_user` varchar(15) NOT NULL,
  `key_user` varchar(100) NOT NULL,
  `avatars` varchar(500) NOT NULL DEFAULT 'defaut.png',
  `activation` int(11) DEFAULT '0',
  `droits` int(11) NOT NULL DEFAULT '0' COMMENT '0 = aucun droit ; 1 = utilisateur ; 2 = modérateur ; 3 = administrateur',
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- Contenu de la table `users`
--

INSERT INTO `users` (`id_user`, `pseudo`, `civility`, `lastname`, `firstname`, `password`, `email`, `date_register`, `date_lastco`, `ip_user`, `key_user`, `avatars`, `activation`, `droits`) VALUES
(4, 'greg', 'Mr.', 'jonc', 'gr&eacute;goire', '42d0c654ba5e11c71b06ce012fc599b96dd22c38', 'greg.autre@gmail.com', '2015-02-13 01:07:20', '2015-02-13 01:07:20', '127.0.0.1', '97071cf3dcd165f502d9fa0d731c4c70', 'defaut.png', 1, 0),
(5, 'dralliam', 'Mr.', 'Maillard', 'Erik', '0f34ea8e18dc5f7c894fd5187cf5ac5c742ee442', 'dralliam0@live.fr', '2015-02-15 01:50:20', '2015-03-27 11:26:39', '127.0.0.1', 'df6017c40245d255784d8663c895050d', '5-diapo-mobile-gilardi.jpg', 1, 3),
(6, 'test_tablette', 'Mme.', 'Maillard', 'Typhaine', '5e83abb6689cc3d8d842b6a9c1c53055e269bfc6', 'dralliam001@gmail.com', '2015-02-15 20:50:30', '2015-03-08 19:35:51', '192.168.1.60', '0b4515c448c4c6d06a067465d2bda28b', 'defaut.png', 1, 2),
(8, '&lt;h1&gt;greetin&lt;/h1&gt;', 'Mr.', 'joncour', 'gregoir', '8b8f564ccdd2354547b4524bdc8c261ff29cc551', 'greg.joncour@gmail.com', '2015-02-23 09:17:10', '2015-02-23 09:17:10', '10.10.163.143', 'dc6b8ecd87e337e7f8aafbddb65f01ec', 'defaut.png', 1, 0),
(9, 'test_mail', 'Mr.', 'Maillard', 'Yannick', '5e83abb6689cc3d8d842b6a9c1c53055e269bfc6', 'erik.maillard@y-nov.com', '2015-02-27 12:12:28', '2015-03-09 00:35:05', '127.0.0.1', '875e21fab61b8bfb5582476d468c069d', 'defaut.png', 1, 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
