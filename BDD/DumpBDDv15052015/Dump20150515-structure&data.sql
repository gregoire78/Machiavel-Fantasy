-- MySQL dump 10.13  Distrib 5.6.23, for Win32 (x86)
--
-- Host: localhost    Database: machiavel_fantasy
-- ------------------------------------------------------
-- Server version	5.6.20-log

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `club`
--

DROP TABLE IF EXISTS `club`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `club` (
  `text_club` longtext NOT NULL,
  `date_update` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `club`
--

LOCK TABLES `club` WRITE;
/*!40000 ALTER TABLE `club` DISABLE KEYS */;
/*!40000 ALTER TABLE `club` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `event`
--

DROP TABLE IF EXISTS `event`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `event` (
  `id_event` int(11) NOT NULL AUTO_INCREMENT,
  `title_event` varchar(50) NOT NULL,
  `text_event` text NOT NULL,
  `image_event` varchar(200) NOT NULL DEFAULT 'defaut_event.png',
  `date_event` datetime NOT NULL,
  `date_update` datetime NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_jeu` int(11) NOT NULL,
  `statut_event` int(11) NOT NULL DEFAULT '1',
  `inscription_event` int(11) DEFAULT NULL,
  `nb_inscrit` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_event`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `event`
--

LOCK TABLES `event` WRITE;
/*!40000 ALTER TABLE `event` DISABLE KEYS */;
INSERT INTO `event` VALUES (1,'guku','ghiughuol','defaut_jeu.png','2015-05-14 05:25:00','2015-05-04 22:33:32',2,27,0,5,1),(2,'les guiguis','fgfgdgdfgdfgndc','test_pc','2015-05-22 08:35:00','2015-05-06 18:45:21',2,58,1,5,1),(3,'gggg','uuu','test_jeu','2015-05-08 05:20:00','2015-05-07 01:51:36',2,55,1,5,1);
/*!40000 ALTER TABLE `event` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `historique`
--

DROP TABLE IF EXISTS `historique`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `historique` (
  `id_historique` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `table_historique` int(1) NOT NULL COMMENT '1 = forum ; 2 = événement  ;  3 = administration;  4 = jeu ; 5 = users',
  `text_historique` varchar(100) NOT NULL,
  `date_historique` datetime NOT NULL,
  PRIMARY KEY (`id_historique`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `historique`
--

LOCK TABLES `historique` WRITE;
/*!40000 ALTER TABLE `historique` DISABLE KEYS */;
INSERT INTO `historique` VALUES (5,2,2,'L\'utilisateur s\'est inscrit à l\'événement : gggg','2015-05-07 02:01:40'),(18,2,3,'Journal d\'administration effacé','2015-05-14 12:17:49');
/*!40000 ALTER TABLE `historique` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `inscription`
--

DROP TABLE IF EXISTS `inscription`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `inscription` (
  `id_event` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `date_inscription` datetime NOT NULL,
  PRIMARY KEY (`id_event`,`id_user`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `inscription`
--

LOCK TABLES `inscription` WRITE;
/*!40000 ALTER TABLE `inscription` DISABLE KEYS */;
INSERT INTO `inscription` VALUES (3,2,'2015-05-07 02:01:40'),(2,2,'2015-05-06 18:14:09');
/*!40000 ALTER TABLE `inscription` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jeu`
--

DROP TABLE IF EXISTS `jeu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jeu` (
  `id_jeu` int(11) NOT NULL AUTO_INCREMENT,
  `title_jeu` varchar(50) NOT NULL,
  `text_jeu` longtext NOT NULL,
  `image_jeu` varchar(200) NOT NULL DEFAULT 'defaut_jeu.png',
  `id_type_jeu` int(11) NOT NULL,
  `date_update` datetime NOT NULL,
  `id_user` int(11) NOT NULL,
  `statut_jeu` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_jeu`)
) ENGINE=InnoDB AUTO_INCREMENT=90 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jeu`
--

LOCK TABLES `jeu` WRITE;
/*!40000 ALTER TABLE `jeu` DISABLE KEYS */;
INSERT INTO `jeu` VALUES (89,'a','<p>a</p>','a.png',1,'2015-05-12 19:54:49',2,1);
/*!40000 ALTER TABLE `jeu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `type_jeu`
--

DROP TABLE IF EXISTS `type_jeu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `type_jeu` (
  `id_type_jeu` int(11) NOT NULL AUTO_INCREMENT,
  `libelle_type_jeu` varchar(50) NOT NULL,
  `description_type_jeu` varchar(300) NOT NULL,
  `image_type_jeu` varchar(200) NOT NULL,
  `color_type_jeu` varchar(10) NOT NULL,
  `icon_type_jeu` varchar(255) NOT NULL,
  PRIMARY KEY (`id_type_jeu`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `type_jeu`
--

LOCK TABLES `type_jeu` WRITE;
/*!40000 ALTER TABLE `type_jeu` DISABLE KEYS */;
INSERT INTO `type_jeu` VALUES (1,'crotte','caca','rien','fff','rien'),(2,'biquette','boule noire','rien','fff','rien');
/*!40000 ALTER TABLE `type_jeu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `pseudo` varchar(35) NOT NULL,
  `civility` varchar(4) NOT NULL,
  `lastname` varchar(35) NOT NULL,
  `firstname` varchar(35) NOT NULL,
  `password` varchar(60) NOT NULL,
  `email` varchar(320) NOT NULL,
  `date_register` datetime NOT NULL,
  `date_lastco` datetime NOT NULL,
  `ip_user` varchar(15) NOT NULL,
  `key_user` varchar(100) NOT NULL,
  `avatars` varchar(255) NOT NULL DEFAULT 'defaut.png',
  `activation` int(1) NOT NULL DEFAULT '0',
  `droits` int(1) NOT NULL DEFAULT '1' COMMENT '0 = aucun droit ; 1 = utilisateur ; 2 = modérateur ; 3 = administrateur',
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (2,'greetin','Mr.','Joncour','Gr&eacute;goire','$2y$10$ANs8G6Fu9onr97RHX4tMeOBglFtdWPqhpPQLbqDl1Vm2h5/TLn31.','greg.joncour@gmail.com','2015-04-30 20:11:00','2015-05-14 12:02:51','127.0.0.1','6a17c33b0e94d9ec881a91221336d1e1','da4b9237bacccdf19c0760cab7aec4a8359010b0.png',1,3),(4,'greg','Mr.','Joncour','Gregoire','$2y$10$RhPgjZdV1uiBRM2VKZACSOPNE2iBCpRpimTwXwODmz56BCWOYCDym','greg.autre@gmail.com','2015-05-07 02:27:48','2015-05-07 02:27:48','127.0.0.1','5d441b47211002594514c23821719c28','defaut.png',1,1);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-05-15 18:03:11
