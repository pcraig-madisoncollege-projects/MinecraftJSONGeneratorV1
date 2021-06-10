-- MySQL dump 10.13  Distrib 5.7.27, for Linux (x86_64)
--
-- Host: localhost    Database: projects
-- ------------------------------------------------------
-- Server version	5.7.27-0ubuntu0.18.04.1

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
-- Table structure for table `madlibs`
--

DROP TABLE IF EXISTS `madlibs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `madlibs` (
  `userID` int(11) NOT NULL AUTO_INCREMENT,
  `noun` varchar(100) NOT NULL,
  `verb` varchar(100) NOT NULL,
  `adverb` varchar(100) NOT NULL,
  `adjective` varchar(100) NOT NULL,
  `story` varchar(1000) DEFAULT NULL,
  PRIMARY KEY (`userID`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `madlibs`
--

LOCK TABLES `madlibs` WRITE;
/*!40000 ALTER TABLE `madlibs` DISABLE KEYS */;
INSERT INTO `madlibs` VALUES (10,'Apple','Jump','Silently','Round','You enter a Round classroom with lots of desks and chairs. On one of the desks, you see a Apple that is Silently  shuffling papers. The Apple slowly spins towards you as if it is aware of your presence. The Apple comes to a halt to face you. Creeped out, you Jump and get the heck out of there.'),(11,'Battery','Cry','Hourly','Sad','You enter a Sad classroom with lots of desks and chairs. On one of the desks, you see a Battery that is Hourly  shuffling papers. The Battery slowly spins towards you as if it is aware of your presence. The Battery comes to a halt to face you. Creeped out, you Cry and get the heck out of there.'),(12,'Lamp','Look','Deathly','Bored','You enter a Bored classroom with lots of desks and chairs. On one of the desks, you see a Lamp that is Deathly  shuffling papers. The Lamp slowly spins towards you as if it is aware of your presence. The Lamp comes to a halt to face you. Creeped out, you Look and get the heck out of there.'),(13,'Pencil','Roll','Outwardly','Stiff','You enter a Stiff classroom with lots of desks and chairs. On one of the desks, you see a Pencil that is Outwardly  shuffling papers. The Pencil slowly spins towards you as if it is aware of your presence. The Pencil comes to a halt to face you. Creeped out, you Roll and get the heck out of there.'),(14,'Platypus','flying','fuzzy','forlornly','You enter a forlornly classroom with lots of desks and chairs. On one of the desks, you see a Platypus that is fuzzy  shuffling papers. The Platypus slowly spins towards you as if it is aware of your presence. The Platypus comes to a halt to face you. Creeped out, you flying and get the heck out of there.');
/*!40000 ALTER TABLE `madlibs` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-02-18 19:07:09
