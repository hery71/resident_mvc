-- MySQL dump 10.13  Distrib 8.0.34, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: fass
-- ------------------------------------------------------
-- Server version	8.0.30

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `__efmigrationshistory`
--

DROP TABLE IF EXISTS `__efmigrationshistory`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `__efmigrationshistory` (
  `MigrationId` varchar(150) NOT NULL,
  `ProductVersion` varchar(32) NOT NULL,
  PRIMARY KEY (`MigrationId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `__efmigrationshistory`
--

LOCK TABLES `__efmigrationshistory` WRITE;
/*!40000 ALTER TABLE `__efmigrationshistory` DISABLE KEYS */;
INSERT INTO `__efmigrationshistory` VALUES ('20250220190102_InitialCreate','7.0.20');
/*!40000 ALTER TABLE `__efmigrationshistory` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `anniversaire_tbl`
--

DROP TABLE IF EXISTS `anniversaire_tbl`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `anniversaire_tbl` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_resident` int DEFAULT '0',
  `motif` varchar(45) DEFAULT '"Birthday"',
  `pax` int DEFAULT NULL,
  `date` date DEFAULT NULL,
  `heure` time DEFAULT NULL,
  `observation` varchar(255) DEFAULT NULL,
  `commentaires` varchar(45) DEFAULT NULL,
  `lieux` varchar(45) DEFAULT NULL,
  `annee` varchar(4) DEFAULT NULL,
  `tea` tinyint(1) DEFAULT '0',
  `coffee` tinyint(1) DEFAULT '0',
  `pop` tinyint(1) DEFAULT '0',
  `juice` tinyint(1) DEFAULT '0',
  `milk` tinyint(1) DEFAULT '0',
  `cake` tinyint(1) DEFAULT '0',
  `sugar` tinyint(1) DEFAULT '0',
  `saltpepper` tinyint(1) DEFAULT '0',
  `water` tinyint(1) DEFAULT '0',
  `tablecloth` tinyint(1) DEFAULT '0',
  `greycenter` tinyint(1) DEFAULT '0',
  `juiceglass` tinyint(1) DEFAULT '0',
  `foamglass` tinyint(1) DEFAULT '0',
  `plasticdish6` tinyint(1) DEFAULT '0',
  `plasticdish9` tinyint(1) DEFAULT '0',
  `cups` tinyint(1) DEFAULT '0',
  `knife` tinyint(1) DEFAULT '0',
  `fork` tinyint(1) DEFAULT '0',
  `teaspoon` tinyint(1) DEFAULT '0',
  `cakeknife` tinyint(1) DEFAULT '0',
  `napkin` tinyint(1) DEFAULT '0',
  `trashbag` tinyint(1) DEFAULT '0',
  `kitchencloth` tinyint(1) DEFAULT '0',
  `enabled` int DEFAULT '1',
  `rang` int DEFAULT '1',
  `idCakeOrder` int DEFAULT '0',
  `informations` varchar(90) DEFAULT NULL,
  `disposable` int DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=122 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `anniversaire_tbl`
--

LOCK TABLES `anniversaire_tbl` WRITE;
/*!40000 ALTER TABLE `anniversaire_tbl` DISABLE KEYS */;
INSERT INTO `anniversaire_tbl` VALUES (1,23,'Birthday',10,'2024-10-31','13:00:00','Confirmed','CAKE FOR RESIDENTS','Salle Activite','2024',1,1,0,0,1,1,0,0,1,0,6,1,1,1,0,0,0,0,0,0,1,1,1,0,1,0,NULL,0),(2,24,'Birthday',10,'2024-11-02','13:00:00','Confirmed','CAKE FOR RESIDENTS','Salle activite','2024',1,1,0,0,1,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,NULL,0),(3,24,'Birthday',10,'2024-10-31','13:30:00','Confirmed','CAKE FOR RESIDENTS','Salle activite','2024',0,1,1,1,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,NULL,0),(4,13,'Birthday',10,'2024-10-24','13:00:00','Confirmed','CAKE FOR RESIDENTS','Salle Activite','2024',0,0,0,1,1,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,NULL,0),(6,13,'Birthday',17,'2024-10-31','13:00:00','Subject to modification','CAKE FOR RESIDENTS','Salle Activite','2024',1,1,0,1,1,1,0,0,1,0,1,1,1,0,0,0,0,0,0,1,0,1,1,1,1,0,NULL,0),(7,24,'Birthday',15,'2024-11-02','13:00:00','Confirmed','CAKE FOR THE PARTY','Salle Activite','2024',1,1,0,1,0,1,1,0,1,0,1,0,0,1,0,1,0,1,1,0,0,0,0,1,1,0,NULL,0),(8,48,'Birthday',25,'2024-11-17','13:00:00','Confirmed','CAKE FOR THE PARTY','Salle Activite','2024',1,1,1,1,0,1,0,0,0,0,0,0,0,1,0,0,0,0,0,1,1,0,0,1,1,0,NULL,0),(9,15,'Anniversaire',0,'2025-10-03','13:00:00','Confirmed','CAKE FOR RESIDENTS','NO PARTY','2025',0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,26,'No',0),(10,15,'Anniversaire',20,'2025-10-04','13:00:00','Confirmed','FAMILY WILL BRING CAKE','Salle Activite','2025',0,0,0,0,0,0,0,0,0,0,0,1,0,1,0,0,0,1,0,0,1,0,0,0,0,0,NULL,0),(11,65,'Birthday',15,'2024-11-11','13:00:00','Confirmed','CAKE FOR THE PARTY','Salle Activite','2024',1,1,1,1,1,0,0,0,0,0,0,0,0,1,0,1,0,0,1,0,1,0,1,1,1,0,NULL,0),(12,57,'Birthday',0,'2024-11-13','13:00:00','Confirmed','CAKE FOR RESIDENTS','NO PARTY','2024',0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,1,0,NULL,0),(13,32,'Birthday',15,'2024-12-07','13:30:00','Confirmed','FAMILY WILL BRING CAKE','Salle Activite','2024',1,1,0,0,0,0,0,0,1,0,0,1,0,0,0,1,0,0,1,1,1,0,0,1,1,0,NULL,0),(14,23,'Birthday',0,'2024-11-18','13:00:00','Confirmed','CAKE FOR RESIDENTS','NO PARTY','2024',0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,1,0,NULL,0),(15,32,'Birthday',0,'2024-12-27','13:00:00','Confirmed','CAKE FOR RESIDENTS','NO PARTY','2024',0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,2,0,NULL,0),(16,43,'Birthday',0,'2025-01-04','13:30:00','Confirmed','CAKE FOR RESIDENTS','NO PARTY','2025',0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,1,0,NULL,0),(17,61,'Birthday',6,'2025-01-18','13:30:00','Confirmed','CAKE FOR THE PARTY','Salle Activite','2025',1,1,0,0,0,1,0,0,0,0,0,0,0,0,0,1,1,1,1,1,0,0,0,1,1,0,NULL,0),(18,63,'Birthday',5,'2025-01-17','13:30:00','Confirmed','CAKE FOR THE PARTY','Salle Activite','2025',1,1,0,1,0,1,0,0,0,0,0,0,0,0,0,1,1,0,1,0,1,0,0,1,1,0,NULL,0),(19,68,'Birthday',6,'2025-01-28','13:30:00','Confirmed','CAKE FOR THE PARTY','Salle Activite','2025',0,0,1,1,0,1,0,0,0,0,0,0,0,0,0,1,1,1,0,0,0,0,0,1,1,0,NULL,0),(20,25,'Birthday',2,'2025-01-18','13:30:00','Confirmed','CAKE FOR THE PARTY','Salle Activite','2025',1,1,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,0,0,0,0,0,0,1,1,0,NULL,0),(21,17,'Birthday',0,'2025-01-26','13:30:00','Confirmed','CAKE FOR RESIDENTS','NO PARTY','2025',0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,1,0,NULL,0),(22,70,'Birthday',0,'2025-01-27','13:00:00','Confirmed','CAKE FOR RESIDENTS','NO PARTY','2025',0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,1,0,NULL,0),(23,47,'Birthday',10,'2025-02-12','14:00:00','Confirmed','CAKE FOR THE PARTY','Salle Activite','2025',1,1,1,0,0,1,1,0,0,0,0,0,0,0,0,0,0,1,1,1,0,0,0,1,1,0,NULL,0),(24,17,'Birthday',0,'2025-02-23','13:00:00','Confirmed','CAKE FOR RESIDENTS','NO PARTY','2025',0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,2,0,NULL,0),(25,20,'Birthday',12,'2025-03-02','13:00:00','Confirmed','CAKE FOR THE PARTY','Salle Activite','2025',1,1,1,0,1,0,1,0,0,0,0,1,0,0,0,1,0,0,1,0,1,0,0,1,1,0,NULL,0),(26,18,'Birthday',10,'2025-03-04','13:00:00','Confirmed','CAKE FOR RESIDENTS','Salle Activite','2025',1,0,1,0,0,0,1,0,1,0,0,1,0,1,0,1,0,0,1,0,1,0,0,1,1,0,NULL,0),(27,45,'Birthday',20,'2025-03-08','14:00:00','Confirmed','CAKE FOR THE PARTY','Salle Activite','2025',1,1,1,0,0,0,0,0,0,0,0,0,1,0,0,1,0,0,1,0,1,0,0,1,1,0,NULL,0),(28,66,'Birthday',12,'2025-03-09','13:30:00','Confirmed','CAKE FOR THE PARTY','Salle Activite','2025',1,0,1,1,0,0,0,0,0,0,0,1,0,1,0,0,0,0,0,0,1,0,0,1,1,0,NULL,0),(29,9,'Birthday',0,'2025-03-27','13:00:00','Confirmed','CAKE FOR RESIDENTS','NO PARTY','2025',0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,1,0,NULL,0),(30,73,'Birthday',20,'2025-04-03','13:00:00','Confirmed','CAKE FOR THE PARTY','Salle Activite','2025',1,1,0,0,0,0,1,0,0,0,0,0,0,0,0,1,0,0,1,0,0,0,0,1,1,0,NULL,0),(31,28,'Birthday',5,'2025-04-05','13:00:00','Confirmed','CAKE FOR RESIDENTS','Chambre','2025',0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,0,0,1,1,0,1,0,0,1,1,0,NULL,0),(32,60,'Birthday',12,'2025-04-27','13:00:00','Confirmed','CAKE FOR THE PARTY','Salle Activite','2025',1,0,1,1,1,1,1,0,0,0,0,1,0,1,0,0,0,0,1,0,1,0,0,1,1,0,NULL,0),(33,54,'Birthday',20,'2025-04-26','13:00:00','Confirmed','CAKE FOR THE PARTY','Salle Activite','2025',1,1,0,1,1,0,1,0,1,0,0,0,0,1,0,1,0,0,1,0,1,0,0,1,1,0,NULL,0),(34,42,'Birthday',0,'2025-04-18','13:00:00','Confirmed','CAKE FOR RESIDENTS','NO PARTY','2025',0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,1,2,NULL,0),(55,7,'Birthday',0,'2025-07-13','13:30:00','Confirmed','CAKE FOR RESIDENTS','Salle Activite','2025',0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,1,15,NULL,0),(36,2,'Birthday',10,'2025-04-11','13:00:00','Confirmed','CAKE FOR RESIDENTS','Salle Activite','2025',1,1,1,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,NULL,0),(40,0,'Familiale',10,'2025-04-14','13:00:00','Confirmed','NO CAKE','Gazebo','2025',0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,0,NULL,0),(38,0,'Requiem',10,'2025-04-04','13:00:00','Confirmed','NO CAKE','Salon','2025',1,1,1,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,0,NULL,0),(39,0,'Requiem',10,'2025-04-04','13:00:00','Confirmed','NO CAKE','Salon','2025',1,1,1,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,0,NULL,0),(54,50,'Birthday',3,'2025-07-05','13:00:00','Confirmed','CAKE FOR THE PARTY','Salle Activite','2025',0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,0,0,0,1,1,1,1,0,1,1,0,NULL,0),(42,41,'Birthday',0,'2025-05-03','13:00:00','Confirmed','CAKE FOR RESIDENTS','NO PARTY','2025',0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,1,3,NULL,0),(43,37,'Birthday',10,'2025-05-10','13:00:00','Confirmed','CAKE FOR THE PARTY','Salle Activite','2025',1,1,1,1,1,0,1,0,1,0,0,0,0,1,0,0,0,1,1,0,0,0,0,1,1,4,NULL,0),(44,39,'Birthday',25,'2025-05-05','13:00:00','Confirmed','CAKE FOR THE PARTY','Salle Activite','2025',1,1,1,1,1,0,1,0,1,0,0,1,0,1,0,1,0,0,1,0,0,0,0,1,1,5,NULL,0),(45,2,'Birthday',10,'2025-05-25','13:00:00','Confirmed','CAKE FOR THE PARTY','Salle Activite','2025',1,1,0,1,1,0,0,0,0,0,0,0,1,1,0,1,0,0,1,0,1,0,0,1,1,6,NULL,0),(46,19,'Birthday',0,'2025-05-13','13:00:00','Family no answer','CAKE FOR RESIDENTS','NO PARTY','2025',0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,1,7,NULL,0),(47,10,'Birthday',0,'2025-06-06','13:00:00','Confirmed','CAKE FOR RESIDENTS','Salle Activite','2025',0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,1,8,NULL,0),(48,6,'Birthday',20,'2025-06-21','13:00:00','Confirmed','CAKE FOR RESIDENTS','Salle Activite','2025',1,1,1,1,1,1,1,0,0,0,0,0,0,1,0,1,0,0,0,1,0,0,0,1,1,9,NULL,0),(49,0,'Autre',60,'2025-05-28','14:00:00','Confirmed','CAKE FOR THE PARTY','Salon','2025',1,1,1,1,1,1,1,0,1,0,0,1,0,0,0,1,0,0,1,1,1,1,0,1,0,10,NULL,0),(50,71,'Birthday',25,'2025-06-22','13:00:00','Confirmed','CAKE FOR THE PARTY','Salle Activite','2025',1,1,1,1,1,0,0,0,1,0,0,0,0,1,0,1,0,1,1,0,0,0,0,1,1,11,NULL,0),(51,52,'Birthday',0,'2025-06-21','13:00:00','Confirmed','CAKE FOR RESIDENTS','NO PARTY','2025',0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,1,12,NULL,0),(52,21,'Birthday',30,'2025-06-21','13:00:00','Confirmed','CAKE FOR THE PARTY','Gazebo','2025',1,1,1,1,1,1,1,0,1,0,0,1,0,1,0,0,0,1,1,1,1,0,0,1,1,13,NULL,0),(53,4,'Birthday',0,'2025-06-22','13:00:00','Confirmed','CAKE FOR RESIDENTS','NO PARTY','2025',0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,1,14,NULL,0),(56,7,'Anniversaire',15,'2025-07-13','13:30:00','Confirmed','FAMILY WILL BRING CAKE','Salle Activite','2025',0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,15,NULL,0),(57,67,'Birthday',6,'2025-07-19','13:00:00','Confirmed','CAKE FOR THE PARTY','Salle Activite','2025',1,1,0,1,1,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,1,16,NULL,0),(58,74,'Birthday',15,'2025-08-10','13:00:00','Confirmed','CAKE FOR THE PARTY','Gazebo','2025',1,0,0,1,1,0,1,0,1,0,0,1,0,0,0,1,0,0,1,0,1,0,0,1,1,17,NULL,0),(59,53,'Birthday',0,'2025-08-25','17:00:00','Confirmed','CAKE FOR RESIDENTS','NO PARTY','2025',0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,1,18,NULL,0),(60,33,'Birthday',0,'2025-08-23','13:00:00','Family no answer','CAKE FOR RESIDENTS','NO PARTY','2025',0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,1,19,NULL,0),(63,5,'Birthday',8,'2025-09-11','14:00:00','Confirmed','CAKE FOR THE PARTY','Gazebo','2025',1,1,1,1,0,0,0,0,1,0,0,1,0,1,0,1,1,0,1,0,0,0,0,1,1,21,NULL,0),(62,77,'Autre',12,'2025-12-25','13:00:00','Confirmed','NO CAKE','Salle Activite','2025',0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,0,NULL,0),(64,72,'Birthday',15,'2025-09-27','17:00:00','Confirmed','CAKE FOR THE PARTY','Salle Activite','2025',0,0,0,1,0,1,0,0,1,0,0,1,0,1,0,0,0,0,1,0,1,1,0,1,1,22,'Family clean and throw all after party Send all disposables',1),(65,14,'Birthday',0,'2025-09-24','13:00:00','Confirmed','CAKE FOR RESIDENTS','NO PARTY','2025',0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,1,23,NULL,0),(66,49,'Birthday',15,'2025-09-21','13:00:00','Confirmed','CAKE FOR THE PARTY','Salle Activite','2025',1,0,1,0,0,0,0,0,0,0,0,1,1,1,0,1,0,0,1,0,1,0,0,1,1,25,NULL,0),(67,15,'Anniversaire',20,'2025-10-04','13:00:00','Confirmed','FAMILY WILL BRING CAKE','Salle Activite','2025',0,0,0,0,0,0,0,0,0,0,0,1,0,1,0,0,0,1,0,0,1,0,0,0,0,0,NULL,0),(68,15,'Anniversaire',20,'2025-10-04','13:00:00','Confirmed','FAMILY WILL BRING CAKE','Salle Activite','2025',0,0,0,0,0,0,0,0,0,0,0,1,0,1,0,0,0,1,0,0,1,0,0,0,0,0,NULL,0),(69,15,'Anniversaire',20,'2025-10-04','13:00:00','Confirmed','FAMILY WILL BRING CAKE','Salle Activite','2025',0,0,0,0,0,0,0,0,0,0,0,1,0,1,0,0,0,1,0,0,1,0,0,0,0,0,NULL,0),(70,15,'Anniversaire',20,'2025-10-04','13:00:00','Confirmed','FAMILY WILL BRING CAKE','Salle Activite','2025',0,0,0,0,0,0,0,0,0,0,0,1,0,1,0,0,0,1,0,0,1,0,0,0,0,0,NULL,0),(71,15,'Anniversaire',20,'2025-10-04','13:00:00','Confirmed','FAMILY WILL BRING CAKE','Salle Activite','2025',0,0,0,0,0,0,0,0,0,0,0,1,0,1,0,0,0,1,0,0,1,0,0,0,0,0,NULL,0),(72,15,'Anniversaire',20,'2025-10-04','13:00:00','Confirmed','FAMILY WILL BRING CAKE','Salle Activite','2025',0,0,0,0,0,0,0,0,0,0,0,1,0,1,0,0,0,1,0,0,1,0,0,0,0,0,NULL,0),(73,34,'Birthday',12,'2025-09-24','13:30:00','Confirmed','CAKE FOR THE STAFF','Salle Activite','2025',1,1,0,0,0,1,1,0,0,0,0,0,0,0,0,1,0,0,0,0,1,0,0,1,1,24,'No',0),(74,40,'Birthday',0,'2025-09-15','13:00:00','Confirmed','CAKE FOR RESIDENTS','Salle Activite','2025',0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,1,20,NULL,0),(78,15,'Anniversaire',20,'2025-10-04','13:00:00','Confirmed','FAMILY WILL BRING CAKE','Salle Activite','2025',1,1,0,1,0,0,0,0,1,0,0,0,0,1,0,1,0,0,0,1,0,0,0,1,0,0,NULL,0),(75,69,'Birthday',10,'2025-10-06','13:00:00','Confirmed','CAKE FOR THE PARTY','Salle Activite','2025',1,1,0,1,1,1,1,0,1,0,0,1,0,1,0,1,0,0,1,0,1,0,0,1,1,27,NULL,0),(76,62,'Birthday',10,'2025-10-08','13:00:00','Confirmed','CAKE FOR THE PARTY','Salle Activite','2025',1,1,0,1,0,1,1,0,1,0,0,1,0,1,0,1,0,0,0,0,0,0,0,1,1,28,NULL,0),(77,26,'Birthday',0,'2025-10-31','13:00:00','Confirmed','CAKE FOR RESIDENTS','NO PARTY','2025',0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,1,29,NULL,0),(79,81,'Birthday',12,'2025-11-02','13:00:00','Confirmed','CAKE FOR THE PARTY','Salle Activite','2025',0,1,0,0,0,1,0,0,1,0,0,1,1,1,0,1,0,0,0,0,0,1,0,1,1,30,NULL,0),(80,24,'Birthday',12,'2025-11-01','13:00:00','Confirmed','CAKE FOR THE PARTY','Salle Activite','2025',1,1,0,1,1,1,0,0,1,0,0,1,0,1,0,1,0,0,1,0,1,1,0,1,1,31,NULL,0),(81,48,'Birthday',20,'2025-11-16','13:00:00','Confirmed','CAKE FOR THE PARTY','Salle Activite','2025',1,1,1,1,1,1,1,0,1,0,0,1,0,1,0,1,0,0,0,1,1,1,0,1,1,32,NULL,0),(82,65,'Birthday',20,'2025-11-09','13:00:00','Confirmed','CAKE FOR RESIDENTS','Salle Activite','2025',1,1,1,1,0,0,0,0,0,0,0,1,0,1,0,1,0,0,0,0,1,1,0,1,1,33,'No',0),(83,76,'Birthday',25,'2025-12-07','13:00:00','Confirmed','CAKE FOR THE PARTY','Salle Activite','2025',1,1,0,0,0,1,1,0,0,0,0,1,0,1,0,0,0,0,1,0,1,0,0,1,1,34,'No',0),(84,32,'Birthday',10,'2025-12-14','13:00:00','Confirmed','CAKE FOR THE PARTY','Salle Activite','2025',1,1,0,0,0,1,1,0,1,0,0,0,0,1,0,0,0,0,1,0,1,0,0,1,1,35,'No',0),(85,59,'Birthday',0,'2025-12-30','13:00:00','Confirmed','CAKE FOR RESIDENTS','Salle Activite','2025',0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,1,36,'No',0),(86,21,'Autre',6,'2025-12-22','13:00:00','Confirmed','NO CAKE','Salle Activite','2025',1,1,1,0,0,0,0,0,0,0,0,0,0,0,1,1,0,0,1,0,1,0,0,1,0,0,NULL,0),(87,83,'Birthday',0,'2025-12-17','13:00:00','Confirmed','CAKE FOR RESIDENTS','NO PARTY','2025',0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,1,37,NULL,0),(88,6,'Autre',12,'2025-12-20','13:00:00','Confirmed','NO CAKE','Salle Activite','2025',0,1,0,0,0,0,1,0,0,0,0,0,0,1,0,1,0,0,1,1,1,0,0,1,0,0,NULL,0),(89,6,'Autre',5,'2025-12-20','13:00:00','Confirmed','NO CAKE','Salle Activite','2025',0,1,0,0,1,0,1,0,0,0,0,0,0,1,0,1,0,0,1,0,1,0,0,0,0,0,NULL,0),(90,6,'Autre',12,'2025-12-20','13:00:00','Confirmed','NO CAKE','Salle Activite','2025',0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,NULL,0),(91,6,'Autre',5,'2025-12-20','13:00:00','Confirmed','NO CAKE','Salle Activite','2025',0,1,0,0,1,0,1,0,0,0,0,0,0,1,0,1,0,0,1,0,1,0,0,0,0,0,NULL,0),(92,6,'Autre',12,'2025-12-20','13:00:00','Confirmed','NO CAKE','Salle Activite','2025',0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,NULL,0),(93,6,'Autre',12,'2025-12-20','13:00:00','Confirmed','NO CAKE','Salle Activite','2025',0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,NULL,0),(94,6,'Autre',12,'2025-12-20','13:00:00','Confirmed','NO CAKE','Salle Activite','2025',0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,NULL,0),(95,6,'Autre',12,'2025-12-20','13:00:00','Confirmed','NO CAKE','Salle Activite','2025',0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,NULL,0),(96,6,'Autre',12,'2025-12-20','13:00:00','Confirmed','NO CAKE','Salle Activite','2025',0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,NULL,0),(97,6,'Autre',12,'2025-12-20','13:00:00','Confirmed','NO CAKE','Salle Activite','2025',0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,NULL,0),(98,6,'Autre',12,'2025-12-20','13:00:00','Confirmed','NO CAKE','Salle Activite','2025',0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,NULL,0),(99,6,'Autre',12,'2025-12-20','13:00:00','Confirmed','NO CAKE','Salle Activite','2025',0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,NULL,0),(100,6,'Autre',12,'2025-12-20','13:00:00','Confirmed','NO CAKE','Salle Activite','2025',0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,NULL,0),(101,6,'Autre',12,'2025-12-20','13:00:00','Confirmed','NO CAKE','Salle Activite','2025',0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,NULL,0),(102,6,'Autre',12,'2025-12-20','13:00:00','Confirmed','NO CAKE','Salle Activite','2025',0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,NULL,0),(103,6,'Autre',12,'2025-12-20','13:00:00','Confirmed','NO CAKE','Salle Activite','2025',0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,NULL,0),(104,25,'Birthday',6,'2025-12-18','13:00:00','Confirmed','CAKE FOR THE PARTY','Salle Activite','2025',1,0,0,1,0,1,1,0,1,0,0,0,0,1,0,0,0,0,1,1,1,0,0,1,1,0,'No',0),(105,25,'Birthday',6,'2026-01-18','13:30:00','Confirmed','CAKE FOR THE PARTY','Salle Activite','2026',1,0,0,1,0,1,1,0,1,0,0,0,0,1,0,1,0,0,1,1,0,0,0,1,1,38,'No',0),(106,63,'Birthday',6,'2026-01-23','13:30:00','Confirmed','CAKE FOR THE PARTY','Salle Activite','2026',0,1,0,0,0,1,0,0,1,0,0,0,0,1,0,1,0,1,1,0,0,0,0,1,1,39,'No',0),(107,43,'Birthday',6,'2025-12-06','13:00:00','Confirmed','CAKE FOR THE PARTY','Salle Activite','2025',1,0,0,1,0,1,1,0,1,0,0,0,0,1,0,0,0,1,1,0,0,0,0,1,1,0,'No',0),(108,43,'Birthday',6,'2025-12-06','13:00:00','Confirmed','CAKE FOR THE PARTY','Salle Activite','2025',1,0,0,1,0,1,1,0,0,0,0,1,0,1,0,1,0,1,1,0,1,0,0,1,1,0,'No',0),(109,43,'Birthday',6,'2026-01-04','13:00:00','Confirmed','CAKE FOR RESIDENTS','Salle Activite','2026',1,0,0,1,0,1,1,0,0,0,0,0,0,1,0,1,0,1,1,1,1,0,0,1,1,41,'No',0),(110,70,'Birthday',15,'2026-01-27','13:30:00','Confirmed','CAKE FOR THE PARTY','Salle Activite','2026',1,1,0,1,0,1,1,0,1,0,0,1,0,0,0,1,0,1,1,0,0,0,0,1,1,40,'No',0),(111,78,'Birthday',8,'2026-01-20','13:30:00','Confirmed','CAKE FOR THE PARTY','Salle Activite','2026',1,1,0,1,0,1,1,0,1,0,0,1,0,1,1,1,0,1,1,1,0,0,0,1,1,42,'No',0),(112,61,'Birthday',8,'2026-01-16','13:30:00','Confirmed','CAKE FOR THE PARTY','Salle Activite','2026',1,1,0,0,1,1,1,0,1,0,0,1,0,1,0,1,0,0,0,1,1,0,0,1,1,43,'No',0),(113,68,'Birthday',12,'2026-02-01','13:30:00','Confirmed','CAKE FOR RESIDENTS','Salle Activite','2026',0,1,0,1,1,0,1,0,0,0,0,1,0,1,0,1,0,0,1,1,1,0,0,1,1,44,'No',0),(114,47,'Birthday',10,'2026-02-13','15:30:00','Confirmed','CAKE FOR THE PARTY','Salle Activite','2026',1,0,0,1,1,1,0,0,1,0,0,1,1,1,0,0,0,0,0,1,1,1,0,1,1,45,'No',1),(115,6,'Autre',10,'2026-02-11','13:30:00','Confirmed','NO CAKE','Salle Activite','2026',0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,0,0,1,0,0,1,0,0,1,0,0,NULL,0),(116,6,'Autre',10,'2026-02-11','13:30:00','Confirmed','NO CAKE','Salle Activite','2026',0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,0,0,1,0,0,1,1,0,0,0,0,NULL,0),(118,45,'Birthday',25,'2026-03-12','13:30:00','Confirmed','CAKE FOR THE PARTY','Salle Activite','2026',1,1,1,0,1,1,0,0,1,0,0,1,0,1,0,0,0,0,1,0,1,0,0,1,1,47,'No',0),(119,66,'Birthday',15,'2026-03-07','13:30:00','Confirmed','CAKE FOR THE PARTY','Salle Activite','2026',1,1,1,1,1,1,0,0,1,1,0,1,0,1,0,0,1,1,1,0,0,1,0,1,0,46,'',0),(120,77,'Birthday',20,'2026-04-04','13:30:00','Confirmed','CAKE FOR THE PARTY','Salle Activite','2026',0,1,1,0,1,1,1,0,1,0,0,1,0,0,0,1,0,1,1,1,1,0,0,1,0,0,'',0),(121,9,'Birthday',5,'2026-03-27','13:30:00','Confirmed','CAKE FOR RESIDENTS','NO PARTY','2026',0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,48,'',0);
/*!40000 ALTER TABLE `anniversaire_tbl` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `breakfast`
--

DROP TABLE IF EXISTS `breakfast`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `breakfast` (
  `id` int NOT NULL AUTO_INCREMENT,
  `meal` varchar(45) DEFAULT NULL,
  `allergene` varchar(250) DEFAULT NULL,
  `enabled` int DEFAULT '1',
  `id_menu` int DEFAULT '0',
  `intolerance` varchar(250) DEFAULT NULL,
  `ids` int DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=449 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `breakfast`
--

LOCK TABLES `breakfast` WRITE;
/*!40000 ALTER TABLE `breakfast` DISABLE KEYS */;
INSERT INTO `breakfast` VALUES (24,'Orange juice (6oz)','',1,4,NULL,0),(25,'Prunejuice(4oz)','',1,4,NULL,0),(26,'Cream of wheat','',1,4,NULL,0),(27,'Cold cereal','',1,4,NULL,0),(28,'Custard or assorted eggs','',1,4,NULL,0),(29,'Apple juice (6oz)','',1,5,NULL,0),(30,'Prunes','',1,5,NULL,0),(31,'Oatmeal','',1,5,NULL,0),(32,'Cold cereal','',1,5,NULL,0),(33,'Bran muffin','',1,5,NULL,0),(34,'Assorted eggs','',1,5,NULL,0),(35,'Cranberry juice (6oz)','',1,6,NULL,0),(36,'Prune juice (4oz)','',1,6,NULL,0),(37,'Cream of wheat','',1,6,NULL,0),(38,'Cold cereal','',1,6,NULL,0),(39,'Banana','',1,6,NULL,0),(40,'Beans (canned)','',1,6,NULL,0),(41,'Orange juice(6oz)','',1,7,NULL,0),(42,'Prunes','',1,7,NULL,0),(43,'Oatmeal','',1,7,NULL,0),(44,'Cold cereal','',1,7,NULL,0),(45,'Assorted eggs and bacon','',1,7,NULL,0),(46,'Apple juice (6oz)','',1,8,NULL,0),(47,'Prune juice (4oz)','',1,8,NULL,0),(48,'Cream of wheat','',1,8,NULL,0),(49,'Cold cereal','',1,8,NULL,0),(50,'Strawberries','',1,8,NULL,0),(51,'Cheese or assorted eggs','',1,8,NULL,0),(52,'Toasts','',1,8,NULL,0),(53,'margarine','',1,8,NULL,0),(54,'jam','',1,8,NULL,0),(55,'milk 4oz','',1,8,NULL,0),(56,'water 6oz','',1,8,NULL,0),(57,'tea or coffee 6oz','',1,8,NULL,0),(58,'Cranberry juice (6oz)','',1,9,NULL,0),(59,'Prunes','',1,9,NULL,0),(60,'Oatmeal','',1,9,NULL,0),(61,'Cold cereal','',1,9,NULL,0),(62,'Banana','',1,9,NULL,0),(63,'Assorted eggs','',1,9,NULL,0),(64,'Orange juice (6oz)','',1,10,NULL,0),(65,'Prune juice (4oz)','',1,10,NULL,0),(66,'Cream of wheat','',1,10,NULL,0),(67,'Cold cereal','',1,10,NULL,0),(68,'Assorted eggs','',1,10,NULL,0),(69,'Apple juice (6oz)','',1,11,NULL,0),(70,'Prunes','',1,11,NULL,0),(71,'Oatmeal','',1,11,NULL,0),(72,'French toast','',1,11,NULL,0),(73,'syrup','',1,11,NULL,0),(74,'Custard or assorted eggs','',1,11,NULL,0),(75,'Cranberry juice (6oz)','',1,12,NULL,0),(76,'Prune juice (4oz)','',1,12,NULL,0),(77,'Cream of wheat','',1,12,NULL,0),(78,'Cold cereal','',1,12,NULL,0),(79,'Bran muffin','',1,12,NULL,0),(80,'Assorted eggs','',1,12,NULL,0),(81,'Orange juice (6oz)','',1,13,NULL,0),(82,'Prunes','',1,13,NULL,0),(83,'Oatmeal','',1,13,NULL,0),(84,'Cold cereal','',1,13,NULL,0),(85,'Banana','',1,13,NULL,0),(86,'Beans (canned)','',1,13,NULL,0),(87,'Apple juice (6oz)','',1,14,NULL,0),(88,'Prune juice (4oz)','',1,14,NULL,0),(89,'Cream of wheat','',1,14,NULL,0),(90,'Cold cereal','',1,14,NULL,0),(91,'Assorted eggs and bacon','',1,14,NULL,0),(92,'Cranberry juice (6oz)','',1,15,NULL,0),(93,'Prunes','',1,15,NULL,0),(94,'Oatmeal','',1,15,NULL,0),(95,'Cold cereal','',1,15,NULL,0),(96,'Strawberries','',1,15,NULL,0),(97,'Cheese or assorted eggs','',1,15,NULL,0),(98,'Toasts','',1,15,NULL,0),(99,'margarine','',1,15,NULL,0),(100,'jam','',1,15,NULL,0),(101,'milk 4oz','',1,15,NULL,0),(102,'water 6oz','',1,15,NULL,0),(103,'tea or coffee 6oz','',1,15,NULL,0),(104,'Orange juice (6oz)','',1,16,NULL,0),(105,'Prune juice (4oz)','',1,16,NULL,0),(106,'Cream of wheat','',1,16,NULL,0),(107,'Cold cereal','',1,16,NULL,0),(108,'Banana','',1,16,NULL,0),(109,'Assorted eggs','',1,16,NULL,0),(110,'Apple juice (6oz)','',1,17,NULL,0),(111,'Prunes','',1,17,NULL,0),(112,'Oatmeal','',1,17,NULL,0),(113,'Cold cereal','',1,17,NULL,0),(114,'Assorted eggs','',1,17,NULL,0),(115,'Cranberry juice (6oz)','',1,18,NULL,0),(116,'Prune juice (4oz)','',1,18,NULL,0),(117,'Cream of wheat','',1,18,NULL,0),(118,'Cold cereal','',1,18,NULL,0),(119,'Custard or assorted eggs','',1,18,NULL,0),(120,'Orange juice (6oz)','',1,19,NULL,0),(121,'Prunes','',1,19,NULL,0),(122,'Oatmeal','',1,19,NULL,0),(123,'Cold cereal','',1,19,NULL,0),(124,'Bran muffin','',1,19,NULL,0),(125,'Assorted eggs','',1,19,NULL,0),(126,'Apple juice (6oz)','',1,20,NULL,0),(127,'Prune juice (4oz)','',1,20,NULL,0),(128,'Cream of wheat','',1,20,NULL,0),(129,'Cold cereal','',1,20,NULL,0),(130,'Banana','',1,20,NULL,0),(131,'Beans (canned)','',1,20,NULL,0),(132,'Cranberry juice (6oz)','',1,21,NULL,0),(133,'Prunes','',1,21,NULL,0),(134,'Oatmeal','',1,21,NULL,0),(135,'Cold cereal','',1,21,NULL,0),(136,'Assorted eggs and bacon','',1,21,NULL,0),(137,'Sunday','',1,22,NULL,0),(138,'Cranberry juice (6oz)','',1,22,NULL,0),(139,'Prunes','',1,22,NULL,0),(140,'Oatmeal','',1,22,NULL,0),(141,'Cold cereal','',1,22,NULL,0),(142,'Strawberries','',1,22,NULL,0),(143,'Cheese or assorted eggs','',1,22,NULL,0),(144,'Monday','',1,23,NULL,0),(145,'Orange juice (6oz)','',1,23,NULL,0),(146,'Prune juice (4oz)','',1,23,NULL,0),(147,'Cream of wheat','',1,23,NULL,0),(148,'Cold cereal','',1,23,NULL,0),(149,'Banana','',1,23,NULL,0),(150,'Assorted eggs','',1,23,NULL,0),(151,'Tuesday','',1,24,NULL,0),(152,'Apple juice (6oz)','',1,24,NULL,0),(153,'Prunes','',1,24,NULL,0),(154,'Oatmeal','',1,24,NULL,0),(155,'Cold cereal','',1,24,NULL,0),(156,'Assorted eggs','',1,24,NULL,0),(157,'Wednesday','',1,25,NULL,0),(158,'Cranberry juice (6oz)','',1,25,NULL,0),(159,'Prune juice (4oz)','',1,25,NULL,0),(160,'Cream of wheat','',1,25,NULL,0),(161,'Cold cereal','',1,25,NULL,0),(162,'Custard or assorted eggs','',1,25,NULL,0),(163,'Thursday','',1,26,NULL,0),(164,'Orange juice (6oz)','',1,26,NULL,0),(165,'Prunes','',1,26,NULL,0),(166,'Oatmeal','',1,26,NULL,0),(167,'Cold cereal','',1,26,NULL,0),(168,'Bran muffin','',1,26,NULL,0),(169,'Assorted eggs','',1,26,NULL,0),(170,'Friday','',1,27,NULL,0),(171,'Apple juice (6oz)','',1,27,NULL,0),(172,'Prune juice (4oz)','',1,27,NULL,0),(173,'Cream of wheat','',1,27,NULL,0),(174,'Cold cereal','',1,27,NULL,0),(175,'Banana','',1,27,NULL,0),(176,'Beans','',1,27,NULL,0),(177,'Saturday','',1,28,NULL,0),(178,'Cranberry juice (6oz)','',1,28,NULL,0),(179,'Prunes','',1,28,NULL,0),(180,'Oatmeal','',1,28,NULL,0),(181,'Cold cereal','',1,28,NULL,0),(182,'Assorted eggs and bacon','',1,28,NULL,0),(183,'Cranberry juice (6oz)','',1,34,NULL,0),(184,'Prunes','',1,34,NULL,0),(185,'Oatmeal','',1,34,NULL,0),(186,'Cold cereal','',1,34,NULL,0),(187,'Strawberries','',1,34,NULL,0),(188,'Cheese or assorted eggs!!!','',1,34,NULL,0),(189,'Orange juice (6oz)','',1,35,NULL,0),(190,'Prune juice (4oz)','',1,35,NULL,0),(191,'Cream of wheat','',1,35,NULL,0),(192,'Cold cereal','',1,35,NULL,0),(193,'Banana','',1,35,NULL,0),(194,'Assorted eggs','',1,35,NULL,0),(195,'Apple juice (6oz)','',1,36,NULL,0),(196,'Prunes','',1,36,NULL,0),(197,'Oatmeal','',1,36,NULL,0),(198,'Cold cereal','',1,36,NULL,0),(199,'Assorted eggs','',1,36,NULL,0),(200,'Cranberry juice (6oz)','',1,37,NULL,0),(201,'Prune juice (4oz)','',1,37,NULL,0),(202,'Cream of wheat','',1,37,NULL,0),(203,'Pancakes','',1,37,NULL,0),(204,'syrup','',1,37,NULL,0),(205,'Custard or assorted eggs','',1,37,NULL,0),(206,'Orange juice (6oz)','',1,38,NULL,0),(207,'Prunes','',1,38,NULL,0),(208,'Oatmeal','',1,38,NULL,0),(209,'Cold cereal','',1,38,NULL,0),(210,'Bran muffin','',1,38,NULL,0),(211,'Assorted eggs','',1,38,NULL,0),(212,'Apple juice (6oz)','',1,39,NULL,0),(213,'Prune juice (4oz)','',1,39,NULL,0),(214,'Cream of wheat','',1,39,NULL,0),(215,'Cold cereal','',1,39,NULL,0),(216,'Banana','',1,39,NULL,0),(217,'Assorted eggs','',1,39,NULL,0),(218,'Orange juice (6oz)','',1,40,NULL,0),(219,'Prunes','',1,40,NULL,0),(220,'Oatmeal','',1,40,NULL,0),(221,'Cold cereal','',1,40,NULL,0),(222,'Muffin','',1,40,NULL,0),(223,'Assorted eggs','',1,40,NULL,0),(285,'Cranberry juice (6oz)','',1,3,'',0),(286,'Prunes','',1,3,'',0),(287,'Oatmeal','',1,3,'',0),(288,'Cold cereal','',1,3,'',0),(289,'Assorted eggs','',1,3,'',0),(290,'Apple juice (6oz)','',1,2,'',0),(291,'Prune juice(4oz)','',1,2,'',0),(292,'Cream of wheat','',1,2,'',0),(293,'Cold cereal','',1,2,'',0),(294,'Banana','',1,2,'',0),(295,'Assorted eggs','',1,2,'',0),(296,'Jus d orange','',1,1,'',0),(297,'Prunes','',0,1,'',0),(298,'Prunelle','',1,1,'',0),(299,'Toast','',0,1,'',0),(300,'lait,cafe',NULL,1,0,NULL,0),(301,'Lait',NULL,1,0,NULL,5),(302,'Cafe',NULL,1,0,NULL,5),(303,'Oeuf varié',NULL,1,0,NULL,5),(304,'Lait',NULL,1,0,NULL,3),(305,'croissant',NULL,1,0,NULL,3),(306,'Toast',NULL,1,0,NULL,3),(307,'Strawerry',NULL,1,0,NULL,3),(308,'Cranberry juice (6oz)','',1,1,'',0),(309,'Toasts','',1,1,'',0),(310,'Pain perdu','',1,1,'',0),(311,'croissant','',1,1,'',0),(312,'Yogourt','',1,1,'',0),(313,'apple juice',NULL,1,0,NULL,6),(314,'Prunes',NULL,1,0,NULL,6),(315,'Oatmeal',NULL,1,0,NULL,6),(316,'Cold Cereal',NULL,1,0,NULL,6),(317,'Assorted eggs',NULL,1,0,NULL,6),(318,'Cranberry juice (6oz)',NULL,1,0,NULL,18),(319,'Prunes',NULL,1,0,NULL,18),(320,'Oatmeal',NULL,1,0,NULL,18),(321,'Cold cereal',NULL,1,0,NULL,18),(322,'Banana',NULL,1,0,NULL,18),(323,'Assorted eggs',NULL,1,0,NULL,18),(324,'Orange juice (6oz)',NULL,1,0,NULL,19),(325,'Prune juice (4oz)',NULL,1,0,NULL,19),(326,'Cream of wheat',NULL,1,0,NULL,19),(327,'Cold cereal',NULL,1,0,NULL,19),(328,'Assorted eggs',NULL,1,0,NULL,19),(329,'Apple juice (6oz)',NULL,1,0,NULL,20),(330,'Prunes',NULL,1,0,NULL,20),(331,'Oatmeal',NULL,1,0,NULL,20),(332,'French toast',NULL,1,0,NULL,20),(333,'syrup',NULL,1,0,NULL,20),(334,'Custard or assorted eggs',NULL,1,0,NULL,20),(335,'Orange juîce (6oz)','',1,41,'',0),(336,'prunes','',1,41,'',0),(337,'Oatmeal','',1,41,'',0),(338,'Cold cereal','',1,41,'',0),(339,'Strawberries','',1,41,'',0),(340,'Cheese or  assorted eggs','',1,41,'',0),(341,'Apple juice {6oz)','',1,42,'',0),(342,'Prune juice(4oz)','',1,42,'',0),(343,'Cream of wheat','',1,42,'',0),(344,'Cold cereal','',1,42,'',0),(345,'Banana','',1,42,'',0),(346,'Assorted eggs','',1,42,'',0),(347,'Cranberry juice {6oz)','',1,43,'',0),(348,'Prunes','',1,43,'',0),(349,'Oatmeal','',1,43,'',0),(350,'Cold cereal','',1,43,'',0),(351,'Assorted eggs','',1,43,'',0),(352,'Orange juice {6oz)','',1,44,'',0),(353,'Prunejuice(4oz)','',1,44,'',0),(354,'Cream of wheat','',1,44,'',0),(355,'Cold cereal','',1,44,'',0),(356,'Custard','',1,44,'',0),(357,'assorted eggs','',1,44,'',0),(358,'Apple juice (6oz)','',1,45,'',0),(359,'Prunes','',1,45,'',0),(360,'Oatmeal','',1,45,'',0),(361,'Cold cereal','',1,45,'',0),(362,'Bran muffin','',1,45,'',0),(363,'Assorted eggs','',1,45,'',0),(364,'Cranberry juice {6oz)','',1,46,'',0),(365,'Prune juice (4oz)','',1,46,'',0),(366,'Cream of wheat Cold cereal','',1,46,'',0),(367,'Banana','',1,46,'',0),(368,'Beans (canned)','',1,46,'',0),(369,'Orange juice(6oz)','',1,47,'',0),(370,'Prunes','',1,47,'',0),(371,'Oatmeal','',1,47,'',0),(372,'Cold cereal','',1,47,'',0),(373,'Assorted eggs','',1,47,'',0),(374,'bacon','',1,47,'',0),(375,'Apple juice (6oz)','',1,48,'',0),(376,'Prune juice (4oz)','',1,48,'',0),(377,'Cheese or  assorted eggs','',1,48,'',0),(378,'Cream of wheat','',1,48,'',0),(379,'Cold cereal','',1,48,'',0),(380,'Strawberries','',1,48,'',0),(381,'Cranberry juice (6oz)','',1,49,'',0),(382,'Prunes','',1,49,'',0),(383,'Assorted eggs','',1,49,'',0),(384,'Oatmeal','',1,49,'',0),(385,'Cold cereal','',1,49,'',0),(386,'Banana','',1,49,'',0),(387,'Orange juice (6oz)','',1,50,'',0),(388,'Prune juice (4oz)','',1,50,'',0),(389,'Assorted eggs','',1,50,'',0),(390,'Cream of wheat','',1,50,'',0),(391,'Cold cereal','',1,50,'',0),(392,'Apple juice (6oz)','',1,51,'',0),(393,'Prunes','',1,51,'',0),(394,'Oatmeal','',1,51,'',0),(395,'French toast/ syrup','',1,51,'',0),(396,'Custard or assorted eggs','',1,51,'',0),(397,'Cranberry juice(6oz)','',1,52,'',0),(398,'Prune juice (4oz)','',1,52,'',0),(399,'Bran muffin','',1,52,'',0),(400,'Assorted eggs','',1,52,'',0),(401,'Cream of wheat','',1,52,'',0),(402,'Cold cereal','',1,52,'',0),(403,'Orange juice (6oz)','',1,53,'',0),(404,'Prunes Oatmeal Banana','',1,53,'',0),(405,'Beans (canned)','',1,53,'',0),(406,'Cold cereal','',1,53,'',0),(407,'Apple juice (6oz)','',1,54,'',0),(408,'Prune juice (4oz)','',1,54,'',0),(409,'Assorted eggs and bacon','',1,54,'',0),(410,'Cold cereal','',1,54,'',0),(411,'Cranberry juice {6oz)','',1,55,'',0),(412,'Prunes','',1,55,'',0),(413,'Oatmeal','',1,55,'',0),(414,'Cold cereal','',1,55,'',0),(415,'Strawberries','',1,55,'',0),(416,'Cheese or assorted eggs','',1,55,'',0),(417,'Orange juice (6oz)','',1,56,'',0),(418,'Prune juice (4oz)','',1,56,'',0),(419,'Cream of wheat','',1,56,'',0),(420,'Cold cereal','',1,56,'',0),(421,'Banana','',1,56,'',0),(422,'Assorted eggs','',1,56,'',0),(423,'Apple juice (6oz)','',1,57,'',0),(424,'Prunes','',1,57,'',0),(425,'Oatmeal','',1,57,'',0),(426,'Cold cereal','',1,57,'',0),(427,'Assorted eggs','',1,57,'',0),(428,'Cranberry juice {6oz)','',1,58,'',0),(429,'Cream of wheat','',1,58,'',0),(430,'Cold cereal','',1,58,'',0),(431,'Custard or assorted eggs','',1,58,'',0),(432,'Orange juice (6oz)','',1,59,'',0),(433,'Prunes','',1,59,'',0),(434,'Oatmeal','',1,59,'',0),(435,'Cold cereal','',1,59,'',0),(436,'Assorted eggs','',1,59,'',0),(437,'Bran muffin','',1,59,'',0),(438,'Apple juice {6oz)','',1,60,'',0),(439,'Prune juice (4oz)','',1,60,'',0),(440,'Cream of wheat','',1,60,'',0),(441,'Cold cereal','',1,60,'',0),(442,'Beans (canned)','',1,60,'',0),(443,'Banana','',1,60,'',0),(444,'Cranberry juice {6oz)','',1,61,'',0),(445,'Prunes','',1,61,'',0),(446,'Oatmeal','',1,61,'',0),(447,'Cold cereal','',1,61,'',0),(448,'Assorted eggs and bacon','',1,61,'',0);
/*!40000 ALTER TABLE `breakfast` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cake`
--

DROP TABLE IF EXISTS `cake`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cake` (
  `id` int NOT NULL AUTO_INCREMENT,
  `idResident` int DEFAULT NULL,
  `dateAnniversaire` date DEFAULT NULL,
  `dateLivraison` date DEFAULT NULL,
  `message` varchar(45) DEFAULT NULL,
  `couleur` varchar(45) DEFAULT NULL,
  `observation` varchar(45) DEFAULT NULL,
  `enabled` int DEFAULT NULL,
  `annee` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=49 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cake`
--

LOCK TABLES `cake` WRITE;
/*!40000 ALTER TABLE `cake` DISABLE KEYS */;
INSERT INTO `cake` VALUES (1,28,'1940-04-05','2025-04-24','Joyeux anniversaire Julia','Jaune','',NULL,2025),(2,42,'1940-04-18','2025-04-17','Joyeux anniversaire Marcel','Bleu','',NULL,2025),(3,41,'1951-05-03','2025-05-01','bon anniversaire John','Bleu','',NULL,2025),(4,37,'1947-05-08','2025-05-08','joyeux anniversaire Dorothy','Rose','',NULL,2025),(5,39,'1940-05-05','2025-05-01','joyeux anniversaire Ernest','Bleu','',NULL,2025),(6,2,'1931-05-20','2025-05-22','Bonne Fete Therese','Rose','',NULL,2025),(7,19,'1941-05-13','2025-05-13','bonnes fetes Laudia','Rose','',NULL,2025),(8,10,'1943-06-06','2025-06-05','Bonnes fetes  Arthur','Bleu','',NULL,2025),(9,6,'1931-06-19','2025-06-19','Bonne Fete Yvonne','Rose','',NULL,2025),(10,0,'0000-00-00','2025-05-27','Happy Retirement Lisa','Rose','',NULL,2025),(11,71,'1933-06-20','2025-06-19','Bonne Fete Lorette','Rose','',NULL,2025),(12,52,'1946-06-21','2025-06-19','Bonne fetes Eloi','Bleu','',NULL,2025),(13,21,'1934-06-21','2025-06-19','Bonnes fetes Norman','Bleu','',NULL,2025),(14,4,'1926-06-22','2025-06-20','Bonne Fete Suzanne','Rose','',NULL,2025),(15,7,'1935-07-13','2025-07-10','Bonnes fetes Dorina','Bleu','',NULL,2025),(16,67,'1943-07-16','2025-07-16','Bonnes fetes Leandre','Bleu','',NULL,2025),(17,74,'1937-08-11','2025-08-07','Bonne fetes Yvonne','Rose','',NULL,2025),(18,53,'1944-08-25','2025-08-21','Bonnes fetes Anne Marie','Rose','',NULL,2025),(19,33,'1927-08-23','2025-08-21','bonnes fetes Alphonse','Bleu','',NULL,2025),(20,40,'1929-09-15','2025-09-11','Bonne fetes Gerald','Bleu','',NULL,2025),(21,5,'1932-09-11','2025-09-11','Bonnes fetes Willie','Bleu','',NULL,2025),(22,72,'1940-09-26','2025-08-26','Bonnes fetes Alice','Rose','',NULL,2025),(23,14,'1946-09-24','2025-09-23','Bonnes fetes Yvettes','Rose','',NULL,2025),(24,34,'1980-09-24','2025-09-23','Bonnes fetes Andre','Bleu','',NULL,2025),(25,49,'1987-09-21','2025-09-18','Bonnes fetes Rose','Rose','',NULL,2025),(26,15,'1928-10-03','2025-10-02','Bonne fetes Bella','Rose','',NULL,2025),(27,69,'1933-10-06','2025-10-02','Bonnes fetes Eva','Bleu','',NULL,2025),(28,62,'1947-10-08','2025-10-07','Bonnes fetes Fernand','Bleu','',NULL,2025),(29,26,'1947-10-31','2025-10-30','joyeux anniversaire Marielle','Rose','',NULL,2025),(30,81,'1940-11-02','2025-10-30','joyeux anniversaire Anne Marie','Rose','',NULL,2025),(31,24,'1985-11-02','2025-10-30','joyeux anniversaire Anise','Rose','',NULL,2025),(32,48,'1926-11-19','2025-11-13','joyeux anniversaire Maria','Rose','',NULL,2025),(33,65,'1931-11-11','2025-11-06','joyeux anniversaire Guillaume','Bleu','',NULL,2025),(34,76,'1931-12-07','2025-12-04','Bonne Fete Elzear','Bleu','',NULL,2025),(35,32,'1932-12-27','2025-12-11','Bonne Fete Albert','Bleu','',NULL,2025),(36,59,'1938-12-30','2025-12-30','Bonne Fetes Lina','Bleu','',NULL,2025),(37,83,'1936-12-17','2025-12-16','Bonne fete Therese','Rose','',NULL,2025),(38,25,'1927-01-18','2026-01-15','Bonne Fetes Frere leo','Bleu','',NULL,2026),(39,63,'1956-01-20','2026-01-22','Bonne Fetes Rachel','Rose','',NULL,2026),(40,70,'1956-01-27','2025-12-25','Bonnes Fetes Jacques','Bleu','',NULL,2026),(41,43,'1961-01-04','2025-12-30','Bonnes fetes Paula','Bleu','',NULL,2026),(42,78,'1963-01-19','2026-01-15','Bonne Fete Odette','Rose','',NULL,2026),(43,61,'1941-01-16','2026-01-15','Bonnes Fêtes Rosa','Rose','',NULL,2026),(44,68,'1940-01-28','2026-01-29','Bonnes Fêtes Florine','Rose','',NULL,2026),(45,47,'1974-02-13','2026-02-12','Bonnes Fêtes Denis','Bleu','',NULL,2026),(46,66,'1937-03-09','2026-03-05','Bonnes fetes Alma','Rose','',1,2026),(47,45,'1931-03-11','2026-03-10','Bonnes fetes Aurore','Rose','',1,2026),(48,9,'1961-03-27','2026-03-27','Bonnes fetes Omer','Bleu','',1,2026);
/*!40000 ALTER TABLE `cake` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dinner`
--

DROP TABLE IF EXISTS `dinner`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `dinner` (
  `id` int NOT NULL AUTO_INCREMENT,
  `meal` varchar(45) DEFAULT NULL,
  `allergene` varchar(250) DEFAULT NULL,
  `enabled` int DEFAULT '1',
  `id_menu` int DEFAULT '0',
  `intolerance` varchar(45) DEFAULT NULL,
  `ids` int DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=217 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dinner`
--

LOCK TABLES `dinner` WRITE;
/*!40000 ALTER TABLE `dinner` DISABLE KEYS */;
INSERT INTO `dinner` VALUES (9,'Ham and caulflower chowder','',1,4,NULL,0),(10,'Hot biscuit','',1,4,NULL,0),(11,'Turkey Chilli','',1,5,NULL,0),(12,'Beef chicken Vegetable barley soup','',1,6,NULL,0),(13,'corn Bread','',1,6,NULL,0),(14,'Fish Cakes','',1,7,NULL,0),(15,'Chow chow','',1,7,NULL,0),(16,'Assorted sandwiches','',1,8,NULL,0),(17,'Choice of Soup','',1,8,NULL,0),(18,'Chicken Hash and Gravy','',1,9,NULL,0),(19,'Hot biscuit','',1,10,NULL,0),(20,'Home Made Baked beans','',1,10,NULL,0),(21,'Vegetable Noodle soup','',1,11,NULL,0),(22,'Vegetable fritata','',1,11,NULL,0),(23,'Green salad','',1,11,NULL,0),(24,'Pancakes','',1,12,NULL,0),(25,'Cheese','',1,12,NULL,0),(26,'Tomato Juice','',1,12,NULL,0),(27,'Pasta with ground beef tomato sauce','',1,13,NULL,0),(28,'Hearty homemade soup beef','',1,14,NULL,0),(29,'Stuffed Chicken','',1,15,NULL,0),(30,'Gravy','',1,15,NULL,0),(31,'Assorted vegetables','',1,15,NULL,0),(32,'Macaroni and Cheese Casserole','',1,16,NULL,0),(33,'Broccoli or Green salad','',1,16,NULL,0),(34,'Cod nuggets','',1,17,NULL,0),(35,'French Toast and Strawberry','',1,18,NULL,0),(36,'Baby carrots','',0,18,NULL,0),(37,'Egg and Ham Scramble','',1,19,NULL,0),(38,'Diced Fresh Tomatoes','',1,19,NULL,0),(39,'Seasoned Home Fries','',1,19,NULL,0),(40,'Hamburgers','',1,20,NULL,0),(41,'Chips','',1,20,NULL,0),(42,'Green peas salad','',1,20,NULL,0),(43,'Beef fricot','',1,21,NULL,0),(44,'Bread roll','',1,21,NULL,0),(45,'milk 4oz','',1,22,NULL,0),(46,'water 6oz','',1,22,NULL,0),(47,'tea or coffee 6oz','',1,22,NULL,0),(48,'Fish cakes','',1,22,NULL,0),(49,'Chow chow','',1,22,NULL,0),(50,'Chicken and vegetables casserole','',1,23,NULL,0),(51,'Vegetable Soup','',1,24,NULL,0),(52,'Grilled cheese sandwich','',1,24,NULL,0),(53,'Buckwheat pancakes','',1,25,NULL,0),(54,'Blueberry syrup','',1,25,NULL,0),(55,'Cod nuggets','',1,26,NULL,0),(56,'Diced potatoes','',1,26,NULL,0),(57,'Barley soup','',1,27,NULL,0),(58,'Cornbread and cheese','',1,27,NULL,0),(59,'Corned beef hash','',1,28,NULL,0),(60,'Green salad','',1,28,NULL,0),(61,'Stuffed Chicken','',1,34,NULL,0),(62,'Gravy','',1,34,NULL,0),(63,'Assorted vegetables!!!','',1,34,NULL,0),(64,'Macaroni and Cheese Casserole','',1,35,NULL,0),(65,'Green salad','',1,35,NULL,0),(66,'Seafood Chowder','',1,36,NULL,0),(67,'Bread roll','',1,36,NULL,0),(68,'Meat pies','',1,37,NULL,0),(69,'Diced potatoes','',1,37,NULL,0),(70,'Coleslaw','',1,37,NULL,0),(71,'French toast and strawberries','',1,38,NULL,0),(72,'Vegetable soup','',1,39,NULL,0),(73,'Sandwich','',1,39,NULL,0),(74,'Assorted cold plates','',1,40,NULL,0),(75,'Salad','',1,40,NULL,0),(143,'Pepper Steak','',1,3,'',0),(144,'White rice','',1,3,'',0),(145,'syrup','',0,3,'',0),(146,'Buckwheat Pancake','',1,2,'',0),(147,'Blueberry Sauce','',1,2,'',0),(148,'Coleslaw','',0,2,'',0),(149,'Tomato vegetable soup','',1,1,'',0),(150,'Grilled cheese sandwich','',1,1,'',0),(151,'Minestrone',NULL,1,0,NULL,5),(152,'Kaizer roll',NULL,1,0,NULL,5),(153,'Margarine',NULL,1,0,NULL,5),(154,'Veggies soup',NULL,1,0,NULL,3),(155,'bread roll',NULL,1,0,NULL,3),(157,'French Toast and Strawberry',NULL,1,0,NULL,6),(158,'Diced Potatoes','',1,17,'',0),(159,'Coleslaw','',1,17,'',0),(160,'Or Mashed potatoes','',1,3,'',0),(161,'Garlic Bread','',1,5,'',0),(162,'Chicken hash and gravy',NULL,1,0,NULL,18),(163,'Hot biscuit',NULL,1,0,NULL,19),(164,'Home Made Baked beans',NULL,1,0,NULL,19),(165,'Tomato juice',NULL,1,0,NULL,20),(166,'Vgetable Fritata',NULL,1,0,NULL,20),(167,'Green salad',NULL,1,0,NULL,20),(168,'Steak Sub (peppers','',1,41,'',0),(169,'onions','',1,41,'',0),(170,'mushroom and cheese)','',1,41,'',0),(171,'Beef fricot','',1,42,'',0),(172,'Bread roll with margarine','',1,42,'',0),(173,'Vegetable soup','',1,43,'',0),(174,'Assorted sandwiches','',1,43,'',0),(175,'grilled cheese','',1,43,'',0),(176,'Chicken noodle soup','',1,44,'',0),(177,'Homemade baked beans Hot biscuit','',1,44,'',0),(178,'Chicken pie  (OS) with gravy','',1,45,'',0),(179,'Seasoned diced potatoes','',1,45,'',0),(180,'Fresh tomatoes','',1,45,'',0),(181,'cucumbers','',1,45,'',0),(182,'Buckwheat pancakes Cheese','',1,46,'',0),(183,'Chicken nuggets','',1,47,'',0),(184,'Mashed potatoes or Fries','',1,47,'',0),(185,'Peas and carrots','',1,47,'',0),(186,'Coleslaw','',1,47,'',0),(187,'Vegetable soup','',1,48,'',0),(188,'Assorted sandwich','',1,48,'',0),(189,'Homemade baked beans','',1,49,'',0),(190,'Bread roll','',1,49,'',0),(191,'Vegetable juice Bar Clam Fricot','',1,50,'',0),(192,'Bread roll with margarine','',1,50,'',0),(193,'Spaghetti with meat sauce','',1,51,'',0),(194,'Garlic bread','',1,51,'',0),(195,'Minestrone soup (OS)','',1,52,'',0),(196,'Grilled cheese sandwich','',1,52,'',0),(197,'Vegetable Omelet','',1,53,'',0),(198,'Tossed salad with dressing','',1,53,'',0),(199,'Toast','',1,53,'',0),(200,'Soup of the day','',1,54,'',0),(201,'Assorted subs','',1,54,'',0),(202,'Chicken fricot','',1,55,'',0),(203,'Bread roll','',1,55,'',0),(204,'Tomate soup Pancakes with syrup','',1,56,'',0),(205,'Ham and cauliflower chowder','',1,57,'',0),(206,'Hot biscuit','',1,57,'',0),(207,'Homemade baked beans','',1,58,'',0),(208,'Vegetable juice','',1,58,'',0),(209,'Bread roll','',1,58,'',0),(210,'Pizza Casserole','',1,59,'',0),(211,'Garden Salad with dressing','',1,59,'',0),(212,'Cream of broccoli OS','',1,60,'',0),(213,'Assorted Sandwiches','',1,60,'',0),(214,'Chicken à la King Casserole','',1,61,'',0),(215,'Garlic Bread','',1,61,'',0),(216,'Asparagus','',1,61,'',0);
/*!40000 ALTER TABLE `dinner` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dinner_dessert`
--

DROP TABLE IF EXISTS `dinner_dessert`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `dinner_dessert` (
  `id` int NOT NULL AUTO_INCREMENT,
  `meal` varchar(45) DEFAULT NULL,
  `allergene` varchar(250) DEFAULT NULL,
  `enabled` int DEFAULT '1',
  `id_menu` int DEFAULT '0',
  `intolerance` varchar(45) DEFAULT NULL,
  `ids` int DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=193 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dinner_dessert`
--

LOCK TABLES `dinner_dessert` WRITE;
/*!40000 ALTER TABLE `dinner_dessert` DISABLE KEYS */;
INSERT INTO `dinner_dessert` VALUES (129,'Cherry Square',NULL,1,8,NULL,0),(130,'Blueberry Muffin',NULL,1,9,NULL,0),(131,'Banana square',NULL,1,10,NULL,0),(132,'Molasses cake',NULL,1,11,NULL,0),(133,'Raisin Pie',NULL,1,12,NULL,0),(134,'Pudding',NULL,1,13,NULL,0),(135,'Rhubarb cheesecake',NULL,1,14,NULL,0),(136,'Carrot cake',NULL,1,15,NULL,0),(137,'Strawberry and short cake',NULL,1,16,NULL,0),(138,'Lemon merigue pie',NULL,1,17,NULL,0),(139,'Yogurt',NULL,1,18,NULL,0),(140,'Home made cookies',NULL,1,19,NULL,0),(141,'Apple crisp',NULL,1,20,NULL,0),(142,'Jello',NULL,1,21,NULL,0),(143,'milk 4oz',NULL,1,22,NULL,0),(144,'Chicken and vegetables casserole',NULL,1,23,NULL,0),(145,'Vegetable Soup',NULL,1,24,NULL,0),(146,'Buckwheat pancakes',NULL,1,25,NULL,0),(147,'Cod nuggets',NULL,1,26,NULL,0),(148,'Barley soup',NULL,1,27,NULL,0),(149,'Corned beef hash',NULL,1,28,NULL,0),(150,'Stuffed Chicken!!',NULL,1,34,NULL,0),(151,'Macaroni and Cheese Casserole',NULL,1,35,NULL,0),(152,'Seafood Chowder',NULL,1,36,NULL,0),(153,'Meat pies',NULL,1,37,NULL,0),(154,'French toast and strawberries',NULL,1,38,NULL,0),(155,'Vegetable soup',NULL,1,39,NULL,0),(156,'Assorted cold plates',NULL,1,40,NULL,0),(159,'Yagourt',NULL,1,0,NULL,5),(160,'Yogourt',NULL,1,0,NULL,3),(161,'Lemon Tarts','',1,1,'',0),(162,'Lemon Tarts',NULL,1,0,NULL,6),(163,'Pudding with whipping cream','',1,2,'',0),(164,'Yogurt','',1,3,'',0),(165,'Banana bread','',1,4,'',0),(166,'Butterscotch square','',1,5,'',0),(167,'Carrot Cake','',1,6,'',0),(168,'peaches','',1,7,'',0),(169,'Blueberry Muffin',NULL,1,0,NULL,18),(170,'Banana square',NULL,1,0,NULL,19),(171,'Molasses cake',NULL,1,0,NULL,20),(172,'Mandarins','',1,41,'',0),(173,'Assorted pie','',1,42,'',0),(174,'Cherry square','',1,43,'',0),(175,'lce Cream','',1,44,'',0),(176,'Date square','',1,45,'',0),(177,'Homemade cookies','',1,46,'',0),(178,'Yogurt','',1,47,'',0),(179,'Homemade cookies','',1,48,'',0),(180,'Banana bread','',1,49,'',0),(181,'Strawberry rhubarb compote','',1,50,'',0),(182,'Carrot cake','',1,51,'',0),(183,'lce Cream','',1,52,'',0),(184,'Leman pie','',1,53,'',0),(185,'Apple Crisp','',1,54,'',0),(186,'Wild Blueberry Crisp','',1,55,'',0),(187,'Yogurt','',1,56,'',0),(188,'Pineapple square','',1,57,'',0),(189,'Homemade cookies','',1,58,'',0),(190,'Strawberry and rhubarbcompote','',1,59,'',0),(191,'Pudding','',1,60,'',0),(192,'Muffin','',1,61,'',0);
/*!40000 ALTER TABLE `dinner_dessert` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fete`
--

DROP TABLE IF EXISTS `fete`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `fete` (
  `id` int NOT NULL AUTO_INCREMENT,
  `date` date DEFAULT NULL,
  `heure` time DEFAULT NULL,
  `observation` varchar(255) DEFAULT NULL,
  `annee` varchar(4) DEFAULT NULL,
  `id_resident` int DEFAULT '0',
  `commentaires` varchar(45) DEFAULT NULL,
  `pax` int DEFAULT NULL,
  `lieux` varchar(45) DEFAULT NULL,
  `enabled` int DEFAULT '1',
  `motif` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fete`
--

LOCK TABLES `fete` WRITE;
/*!40000 ALTER TABLE `fete` DISABLE KEYS */;
/*!40000 ALTER TABLE `fete` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `inspection_list`
--

DROP TABLE IF EXISTS `inspection_list`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `inspection_list` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(45) DEFAULT NULL,
  `date` varchar(45) DEFAULT NULL,
  `observation` varchar(45) DEFAULT NULL,
  `enabled` varchar(45) DEFAULT NULL,
  `staff` varchar(45) DEFAULT NULL,
  `id_staff` int DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `inspection_list`
--

LOCK TABLES `inspection_list` WRITE;
/*!40000 ALTER TABLE `inspection_list` DISABLE KEYS */;
INSERT INTO `inspection_list` VALUES (1,'INspection avant Noel','2025-11-18','','1','Martin Stephanie',1);
/*!40000 ALTER TABLE `inspection_list` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `inspection_task`
--

DROP TABLE IF EXISTS `inspection_task`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `inspection_task` (
  `id` int NOT NULL AUTO_INCREMENT,
  `task` varchar(45) DEFAULT NULL,
  `value` varchar(45) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `enabled` int DEFAULT '1',
  `observation` varchar(255) DEFAULT NULL,
  `inspection_id` int DEFAULT '0',
  `room` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `inspection_task`
--

LOCK TABLES `inspection_task` WRITE;
/*!40000 ALTER TABLE `inspection_task` DISABLE KEYS */;
/*!40000 ALTER TABLE `inspection_task` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `list_breakfast`
--

DROP TABLE IF EXISTS `list_breakfast`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `list_breakfast` (
  `id` int NOT NULL AUTO_INCREMENT,
  `meal` varchar(255) NOT NULL,
  `enabled` int DEFAULT '1',
  `allergene` varchar(255) DEFAULT NULL,
  `intolerance` varchar(255) DEFAULT NULL,
  `ingredients` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=66 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `list_breakfast`
--

LOCK TABLES `list_breakfast` WRITE;
/*!40000 ALTER TABLE `list_breakfast` DISABLE KEYS */;
INSERT INTO `list_breakfast` VALUES (1,'Apple juice (6oz)',1,NULL,NULL,NULL),(2,'Assorted eggs',1,'oeuf','albumine',NULL),(3,'Assorted eggs and bacon',1,NULL,NULL,NULL),(4,'Banana',1,NULL,NULL,NULL),(5,'Beans',1,NULL,NULL,NULL),(6,'Beans (canned)',1,NULL,NULL,NULL),(7,'Bran muffin',1,NULL,NULL,NULL),(8,'Cafe',1,NULL,NULL,NULL),(9,'Cheese or assorted eggs',1,NULL,NULL,NULL),(10,'Cheese or assorted eggs!!!',1,NULL,NULL,NULL),(11,'Cold cereal',1,NULL,NULL,NULL),(12,'Cranberry juice (6oz)',1,NULL,NULL,NULL),(13,'Cream of wheat',1,NULL,NULL,NULL),(14,'croissant',1,NULL,NULL,NULL),(15,'Custard or assorted eggs',1,NULL,NULL,NULL),(16,'French toast',1,'','Gluten (blé, seigle, orge, triticale)',NULL),(17,'Friday',1,NULL,NULL,NULL),(18,'jam',1,NULL,NULL,NULL),(19,'Jus d orange',1,NULL,NULL,NULL),(20,'Lait',1,NULL,NULL,NULL),(21,'lait,cafe',1,NULL,NULL,NULL),(22,'margarine',1,NULL,NULL,NULL),(23,'milk 4oz',1,NULL,NULL,NULL),(24,'Monday',1,NULL,NULL,NULL),(25,'Muffin',1,NULL,NULL,NULL),(26,'Oatmeal',1,NULL,NULL,NULL),(27,'Oeuf varié',1,NULL,NULL,NULL),(28,'Orange juice (6oz)',1,NULL,NULL,NULL),(29,'Orange juice(6oz)',1,NULL,NULL,NULL),(30,'Pancakes',1,NULL,NULL,NULL),(31,'Prune juice (4oz)',1,NULL,NULL,NULL),(32,'Prune juice(4oz)',1,NULL,NULL,NULL),(33,'Prunejuice(4oz)',1,NULL,NULL,NULL),(34,'Prunelle',1,NULL,NULL,NULL),(35,'Prunes',1,NULL,NULL,NULL),(36,'Saturday',1,NULL,NULL,NULL),(37,'Strawberries',1,NULL,NULL,NULL),(38,'Strawerry',1,NULL,NULL,NULL),(39,'Sunday',1,NULL,NULL,NULL),(40,'syrup',1,NULL,NULL,NULL),(41,'tea or coffee 6oz',1,NULL,NULL,NULL),(42,'Thursday',1,NULL,NULL,NULL),(43,'Toast',1,NULL,NULL,NULL),(44,'Toasts',1,NULL,NULL,NULL),(45,'Tuesday',1,NULL,NULL,NULL),(46,'water 6oz',1,NULL,NULL,NULL),(47,'Wednesday',1,NULL,NULL,NULL),(64,'Pain perdu',1,'','',NULL),(65,'Yogourt',1,'','',NULL);
/*!40000 ALTER TABLE `list_breakfast` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `list_dinner`
--

DROP TABLE IF EXISTS `list_dinner`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `list_dinner` (
  `id` int NOT NULL AUTO_INCREMENT,
  `meal` varchar(255) NOT NULL,
  `enabled` int DEFAULT '1',
  `allergene` varchar(255) DEFAULT NULL,
  `intolerance` varchar(255) DEFAULT NULL,
  `ingredients` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `list_dinner`
--

LOCK TABLES `list_dinner` WRITE;
/*!40000 ALTER TABLE `list_dinner` DISABLE KEYS */;
INSERT INTO `list_dinner` VALUES (1,'Hearty Soup',1,'','',NULL),(2,'Kaizer Roll',1,'','',NULL),(3,'Assorted sandwiches',1,'','',NULL),(4,'2nd option:',1,'','',NULL),(5,'Hot biscuit',1,'','',NULL),(6,'Home Made Baked beans',1,'','',NULL),(7,'Vegetable Noodle soup',1,'','',NULL),(8,'Vegetable fritata',1,'','',NULL),(9,'Green salad',1,'','',NULL),(10,'Pancakes',1,'','',NULL),(11,'Cheese',1,'','',NULL),(12,'Tomato Juice',1,'','',NULL),(13,'Pasta with ground beef tomato sauce',1,'','',NULL),(14,'Hearty homemade soup beef',1,'','',NULL),(15,'Stuffed Chicken',1,'','',NULL),(16,'Gravy',1,'','',NULL),(17,'Assorted vegetables',1,'','',NULL),(18,'Macaroni and Cheese Casserole',1,'','',NULL),(19,'Broccoli or Green salad',1,'','',NULL),(20,'Cod nuggets',1,'','',NULL),(21,'Diced Potatoes',1,'','',NULL),(22,'Coleslaw',1,'','',NULL),(23,'French Toast and Strawberry',1,'','',NULL),(24,'Egg and Ham Scramble',1,'','',NULL),(25,'Diced Fresh Tomatoes',1,'','',NULL),(26,'Seasoned Home Fries',1,'','',NULL),(27,'Hamburgers',1,'','',NULL),(28,'Chips',1,'','',NULL),(29,'Green peas salad',1,'','',NULL),(30,'Beef fricot',1,'','',NULL),(31,'Bread roll',1,'','',NULL),(32,'Tomato vegetable soup',1,'','',NULL),(33,'Grilled cheese sandwich',1,'','',NULL),(34,'Buckwheat Pancake',1,'','',NULL),(35,'Blueberry Sauce',1,'','',NULL),(36,'Pepper Steak',1,'','',NULL),(37,'White rice',1,'','',NULL),(38,'Or Mashed potatoes',1,'','',NULL),(39,'Ham and caulflower chowder',1,'','',NULL),(40,'Turkey Chilli',1,'','',NULL),(41,'Garlic Bread',1,'','',NULL),(42,'Beef chicken Vegetable barley soup',1,'','',NULL),(43,'corn Bread',1,'','',NULL),(44,'Fish Cakes',1,'','',NULL),(45,'Chow chow',1,'','',NULL);
/*!40000 ALTER TABLE `list_dinner` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `list_dinner_dessert`
--

DROP TABLE IF EXISTS `list_dinner_dessert`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `list_dinner_dessert` (
  `id` int NOT NULL AUTO_INCREMENT,
  `meal` varchar(255) NOT NULL,
  `enabled` int DEFAULT '1',
  `allergene` varchar(255) DEFAULT NULL,
  `intolerance` varchar(255) DEFAULT NULL,
  `ingredients` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `list_dinner_dessert`
--

LOCK TABLES `list_dinner_dessert` WRITE;
/*!40000 ALTER TABLE `list_dinner_dessert` DISABLE KEYS */;
INSERT INTO `list_dinner_dessert` VALUES (1,'2nd option:',1,NULL,NULL,NULL),(2,'Assorted cold plates',1,NULL,NULL,NULL),(3,'Assorted sandwiches',1,NULL,NULL,NULL),(4,'Barley soup',1,NULL,NULL,NULL),(5,'Beef fricot',1,NULL,NULL,NULL),(6,'Buckwheat pancakes',1,NULL,NULL,NULL),(7,'Chicken and vegetables casserole',1,NULL,NULL,NULL),(8,'Cod nuggets',1,NULL,NULL,NULL),(9,'Corned beef hash',1,NULL,NULL,NULL),(10,'Crêpes râpées',1,NULL,NULL,NULL),(11,'Egg and Ham Scramble',1,NULL,NULL,NULL),(12,'French toast and strawberries',1,NULL,NULL,NULL),(13,'Hamburgers',1,NULL,NULL,NULL),(14,'Hot biscuit',1,NULL,NULL,NULL),(15,'Ice cream',1,NULL,NULL,NULL),(16,'Macaroni and Cheese Casserole',1,NULL,NULL,NULL),(17,'Meat pies',1,NULL,NULL,NULL),(18,'milk 4oz',1,NULL,NULL,NULL),(19,'Pancakes',1,NULL,NULL,NULL),(20,'Seafood Chowder',1,NULL,NULL,NULL),(21,'Stuffed Chicken!!',1,NULL,NULL,NULL),(22,'Vegetable fritatta',1,NULL,NULL,NULL),(23,'Vegetable Soup',1,NULL,NULL,NULL),(24,'Yagourt',1,NULL,NULL,NULL),(25,'Yogourt',1,NULL,NULL,NULL),(32,'Tarte aux bleuets',1,'','',NULL),(33,'Cherry Square',1,'','',NULL),(34,'Blueberry Muffin',1,'','',NULL),(35,'Banana square',1,'','',NULL),(36,'Molasses cake',1,'','',NULL),(37,'Raisin Pie',1,'','',NULL),(38,'Pudding',1,'','',NULL),(39,'Rhubarb cheesecake',1,'','',NULL),(40,'Carrot cake',1,'','',NULL),(41,'Strawberry and short cake',1,'','',NULL),(42,'Lemon merigue pie',1,'','',NULL),(43,'Yogurt',1,'','',NULL),(44,'Home made cookies',1,'','',NULL),(45,'Apple crisp',1,'','',NULL),(46,'Jello',1,'','',NULL),(47,'Lemon Tarts',1,'','',NULL),(48,'Pudding with whipping cream',1,'','',NULL),(49,'Banana bread',1,'','',NULL),(50,'Butterscotch square',1,'','',NULL),(51,'peaches',1,'','',NULL);
/*!40000 ALTER TABLE `list_dinner_dessert` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `list_lunch`
--

DROP TABLE IF EXISTS `list_lunch`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `list_lunch` (
  `id` int NOT NULL AUTO_INCREMENT,
  `meal` varchar(255) NOT NULL,
  `enabled` int DEFAULT '1',
  `allergene` varchar(255) DEFAULT NULL,
  `intolerance` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=133 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `list_lunch`
--

LOCK TABLES `list_lunch` WRITE;
/*!40000 ALTER TABLE `list_lunch` DISABLE KEYS */;
INSERT INTO `list_lunch` VALUES (1,'Baked potato',1,'',''),(2,'Beets',1,NULL,NULL),(3,'Boiled potatoes',1,NULL,NULL),(4,'Bologne',1,'','Gluten (blé,seigle,triticale)'),(5,'Bread roll',1,NULL,NULL),(6,'Breaded fish filet',1,NULL,NULL),(7,'Breaded fish fillet',1,NULL,NULL),(8,'Brocoli and carrots',1,NULL,NULL),(9,'Carottes',1,NULL,NULL),(10,'Carrots',1,NULL,NULL),(11,'Carrots!!!',1,NULL,NULL),(12,'Chicken à la King Casserole',1,NULL,NULL),(13,'Chicken Chasseur',1,NULL,NULL),(14,'Chicken Fricot',1,NULL,NULL),(15,'Clam stew',1,NULL,NULL),(16,'Cod fish in white sauce',1,NULL,NULL),(17,'Coleslaw',1,NULL,NULL),(18,'Cranberry sauce',1,NULL,NULL),(19,'Dinner roll',1,NULL,NULL),(20,'Gravy',1,NULL,NULL),(21,'Green beans',1,NULL,NULL),(22,'Green peas',1,NULL,NULL),(23,'Haricots verts',1,NULL,NULL),(24,'Hot turkey sandwich',1,NULL,NULL),(25,'jam',1,NULL,NULL),(26,'Kaizer roll',1,NULL,NULL),(27,'margarine',1,NULL,NULL),(28,'Marinated beets',1,NULL,NULL),(29,'Mashed potato',1,NULL,NULL),(30,'Mashed potatoes',1,NULL,NULL),(31,'Meat pie or pizza with green salad',1,NULL,NULL),(32,'Meatloaf and gravy',1,NULL,NULL),(33,'milk 4oz',1,NULL,NULL),(34,'Mixed vegetables',1,NULL,NULL),(35,'Oven baked fries',1,NULL,NULL),(36,'patate machees',1,NULL,NULL),(37,'Peas and carrots',1,NULL,NULL),(38,'Pork chops in cream of mushroom',1,NULL,NULL),(39,'Pork roast and gravy',1,NULL,NULL),(40,'poulet',1,NULL,NULL),(41,'Poulet  aux champignons',1,NULL,NULL),(42,'Poutine râpée',1,NULL,NULL),(43,'Poutines',1,NULL,NULL),(44,'Râpé',1,NULL,NULL),(45,'Roast beef',1,NULL,NULL),(46,'Roast beef and gravy',1,NULL,NULL),(47,'Roast chicken and gravy',1,NULL,NULL),(48,'roasted Chicken',1,NULL,NULL),(49,'Salted cod',1,NULL,NULL),(50,'Scaloped poatoes',1,NULL,NULL),(51,'Scaloped potatoes',1,NULL,NULL),(52,'Shepherd\'s pie',1,NULL,NULL),(53,'Shepherd’s pie',1,NULL,NULL),(54,'stuffing and gravy',1,NULL,NULL),(55,'Sweet n\' Sour  or Swedish meatballs',1,NULL,NULL),(56,'Swiss steak',1,NULL,NULL),(57,'tea or coffee 6oz',1,NULL,NULL),(58,'Toasts',1,NULL,NULL),(59,'Turkey',1,NULL,NULL),(60,'Turnip',1,NULL,NULL),(61,'Turnips',1,NULL,NULL),(62,'Turnips and carrots',1,NULL,NULL),(63,'Vegetable medley',1,NULL,NULL),(64,'water 6oz',1,NULL,NULL),(65,'Whipped potatoes',1,NULL,NULL),(128,'Riz Pilaf',1,'',''),(129,'Salad',1,'',''),(130,'Crab meat casserole',1,'',''),(131,'Green salad',1,'',''),(132,'Peas',1,'','');
/*!40000 ALTER TABLE `list_lunch` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `list_lunch_dessert`
--

DROP TABLE IF EXISTS `list_lunch_dessert`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `list_lunch_dessert` (
  `id` int NOT NULL AUTO_INCREMENT,
  `meal` varchar(255) NOT NULL,
  `enabled` int DEFAULT '1',
  `allergene` varchar(255) DEFAULT NULL,
  `intolerance` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `list_lunch_dessert`
--

LOCK TABLES `list_lunch_dessert` WRITE;
/*!40000 ALTER TABLE `list_lunch_dessert` DISABLE KEYS */;
INSERT INTO `list_lunch_dessert` VALUES (1,'2nd option:',1,NULL,NULL),(2,'Assorted cold plates',1,NULL,NULL),(3,'Assorted sandwiches',1,NULL,NULL),(4,'Assorted vegetables',1,NULL,NULL),(5,'Barley soup',1,NULL,NULL),(6,'Buckwheat pancakes',1,NULL,NULL),(7,'Chicken and vegetables casserole',1,NULL,NULL),(8,'Cod nuggets',1,NULL,NULL),(9,'Corned beef hash',1,NULL,NULL),(10,'Datte Cake',1,NULL,NULL),(11,'French toast and strawberries',1,NULL,NULL),(12,'Gravy',1,NULL,NULL),(13,'Hot biscuit',1,NULL,NULL),(14,'Ice cream',1,NULL,NULL),(15,'Jello',1,NULL,NULL),(16,'Macaroni and Cheese Casserole',1,NULL,NULL),(17,'Mandarine',1,NULL,NULL),(18,'Meat pies',1,NULL,NULL),(19,'milk 4oz',1,NULL,NULL),(20,'Pancakes',1,NULL,NULL),(21,'Seafood Chowder',1,NULL,NULL),(22,'Stuffed Chicken!',1,NULL,NULL),(23,'Vegetable fritatta',1,NULL,NULL),(24,'Vegetable Soup',1,NULL,NULL),(32,'Mandarins',1,'',''),(33,'Pudding',1,'',''),(34,'Strawberry',1,'',''),(35,'Yogurt',1,'',''),(36,'Peaches',1,'',''),(37,'Pears',1,'',''),(38,'Applesauce',1,'',''),(39,'Fruit salad',1,'',''),(40,'Fruit Mousse',1,'',''),(41,'Assorted fruits',1,'',''),(42,'Banana Muffin',1,'',''),(43,'Black forest  cake square',1,'',''),(44,'Rhubarb',1,'',''),(45,'Pineapple Muffin',1,'','');
/*!40000 ALTER TABLE `list_lunch_dessert` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lunch`
--

DROP TABLE IF EXISTS `lunch`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `lunch` (
  `id` int NOT NULL AUTO_INCREMENT,
  `meal` varchar(45) DEFAULT NULL,
  `allergene` varchar(250) DEFAULT NULL,
  `enabled` int DEFAULT '1',
  `id_menu` int DEFAULT '0',
  `intolerance` varchar(45) DEFAULT NULL,
  `ids` int DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=235 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lunch`
--

LOCK TABLES `lunch` WRITE;
/*!40000 ALTER TABLE `lunch` DISABLE KEYS */;
INSERT INTO `lunch` VALUES (8,'Shepherd\'s pie','',1,4,NULL,0),(9,'Marinated beets','',1,4,NULL,0),(10,'Bologne','',1,5,NULL,0),(11,'Scaloped potatoes','',1,5,NULL,0),(12,'Vegetable medley','',1,5,NULL,0),(13,'Breaded fish fillet','',1,6,NULL,0),(14,'Baked potato','',1,6,NULL,0),(15,'Mixed vegetables','',1,6,NULL,0),(16,'Roast beef and gravy','',1,7,NULL,0),(17,'Mashed potatoes','',1,7,NULL,0),(18,'Turnip','',1,7,NULL,0),(19,'Roast chicken and gravy','',1,8,NULL,0),(20,'Mashed potatoes','',1,8,NULL,0),(21,'Vegetable medley','',1,8,NULL,0),(22,'Poutines Rapes','',1,9,NULL,0),(23,'Râpé','',0,9,NULL,0),(24,'Mixed vegetables','',1,9,NULL,0),(25,'Salted cod','',1,10,NULL,0),(26,'Boiled potatoes','',1,10,NULL,0),(27,'Peas and carrots','',1,10,NULL,0),(28,'Meat pie or pizza with green salad','',1,11,NULL,0),(29,'Mashed potato','',1,11,NULL,0),(30,'Green beans','',1,11,NULL,0),(31,'Roast beef and gravy','',1,12,NULL,0),(32,'Boiled potatoes','',1,12,NULL,0),(33,'Turnips and carrots','',1,12,NULL,0),(34,'Clam stew','',1,13,NULL,0),(35,'Bread roll','',1,13,NULL,0),(36,'Chicken Chasseur','',1,14,NULL,0),(37,'Mashed potatoes','',1,14,NULL,0),(38,'Brocoli and carrots','',1,14,NULL,0),(39,'Swiss steak','',1,15,NULL,0),(40,'Mashed potatoes','',1,15,NULL,0),(41,'Green peas','',1,15,NULL,0),(42,'Pork chops in cream of mushroom','',1,16,NULL,0),(43,'Whipped potatoes','',1,16,NULL,0),(44,'Mixed vegetables','',1,16,NULL,0),(45,'Chicken à la King Casserole','',1,17,NULL,0),(46,'Green Beans','',1,17,NULL,0),(47,'Dinner roll','',1,17,NULL,0),(48,'Meatloaf and gravy','',1,18,NULL,0),(49,'Mashed potatoes','',1,18,NULL,0),(50,'Beets','',1,18,NULL,0),(51,'Hot turkey sandwich','',1,19,NULL,0),(52,'Mashed potato','',1,19,NULL,0),(53,'Coleslaw','',1,19,NULL,0),(54,'Cod fish in white sauce','',1,20,NULL,0),(55,'Mashed potato','',1,20,NULL,0),(56,'Green beans','',1,20,NULL,0),(57,'Pork roast and gravy','',1,21,NULL,0),(58,'Boiled potatoes','',1,21,NULL,0),(59,'Carrots','',1,21,NULL,0),(60,'Toasts','',1,22,NULL,0),(61,'margarine','',1,22,NULL,0),(62,'jam','',1,22,NULL,0),(63,'milk 4oz','',1,22,NULL,0),(64,'water 6oz','',1,22,NULL,0),(65,'tea or coffee 6oz','',1,22,NULL,0),(66,'Shepherd\'s Pie','',1,22,NULL,0),(67,'Marinated beets','',1,22,NULL,0),(68,'Bologne','',1,23,NULL,0),(69,'Scaloped poatoes','',1,23,NULL,0),(70,'Chicken Fricot','',1,24,NULL,0),(71,'Kaizer roll','',1,24,NULL,0),(72,'Turkey','',1,25,NULL,0),(73,'stuffing and gravy','',1,25,NULL,0),(74,'Cranberry sauce','',1,25,NULL,0),(75,'Sweet n\' Sour  or Swedish meatballs','',1,26,NULL,0),(76,'Mashed potatoes','',1,26,NULL,0),(77,'Breaded fish filet','',1,27,NULL,0),(78,'Baked potato','',1,27,NULL,0),(79,'Roast Beef and gravy','',1,28,NULL,0),(80,'Mashed potatoes','',1,28,NULL,0),(81,'Swiss steak','',1,34,NULL,0),(82,'Mashed potatoes','',1,34,NULL,0),(83,'Green beans','',1,34,NULL,0),(84,'Carrots!!!','',1,34,NULL,0),(85,'Pork chops in cream of mushroom','',1,35,NULL,0),(86,'Whipped potatoes','',1,35,NULL,0),(87,'Mixed vegetables','',1,35,NULL,0),(88,'Chicken à la King Casserole','',1,36,NULL,0),(89,'Green beans','',1,36,NULL,0),(90,'Dinner roll','',1,36,NULL,0),(91,'Poutine râpée','',1,37,NULL,0),(92,'Mixed vegetables','',1,37,NULL,0),(93,'Hot turkey sandwich','',1,38,NULL,0),(94,'Oven baked fries','',1,38,NULL,0),(95,'Coleslaw','',1,38,NULL,0),(96,'Shepherd’s pie','',1,39,NULL,0),(97,'Beets','',1,39,NULL,0),(98,'Turnips','',1,39,NULL,0),(99,'Roast beef','',1,40,NULL,0),(100,'Mashed potatoes','',1,40,NULL,0),(101,'Gravy','',1,40,NULL,0),(102,'Mixed vegetables','',1,40,NULL,0),(142,'Chicken fricot','',1,3,'',0),(143,'Kaizer roll','',1,3,'',0),(144,'Sweet n\' Sour  or Swedish meatballs','',1,2,'',0),(145,'Mashed potatoes','',1,2,'',0),(146,'Carrots','',1,2,'',0),(147,'poulet',NULL,1,0,NULL,0),(148,'Poulet  aux champignons',NULL,1,0,NULL,5),(149,'patate machees',NULL,1,0,NULL,5),(150,'Carottes',NULL,1,0,NULL,5),(151,'Haricots verts',NULL,1,0,NULL,5),(152,'roasted Chicken',NULL,1,0,NULL,3),(153,'Mashed potatoes',NULL,1,0,NULL,3),(154,'carottes',NULL,1,0,NULL,3),(155,'Crab meat casserole','',1,1,'',0),(156,'Green peas','',1,1,'',0),(157,'Seafood Chowder',NULL,1,0,NULL,6),(158,'Bread Roll',NULL,1,0,NULL,6),(159,'Salad','',1,11,'',0),(160,'Carrots','',1,15,'',0),(161,'carrots','',1,18,'',0),(162,'Turnip','',1,21,'',0),(163,'Green salad','',1,1,'',0),(164,'Green beans','',1,2,'',0),(165,'Peas','',1,7,'',0),(166,'Meat pies',NULL,1,0,NULL,18),(167,'Mashed potatoes',NULL,1,0,NULL,18),(168,'Green beans',NULL,1,0,NULL,18),(169,'Poutines',NULL,1,0,NULL,19),(170,'salted cod',NULL,1,0,NULL,20),(171,'Boiled potatoes',NULL,1,0,NULL,20),(172,'Peas ans carrots',NULL,1,0,NULL,20),(173,'Cantonese Chicken','',1,41,'',0),(174,'Mashed potatoes Mixed','',1,41,'',0),(175,'vegetables','',1,41,'',0),(176,'Breaded fish fillet with tartar sauce','',1,42,'',0),(177,'Mashed potatoes','',1,42,'',0),(178,'Broccoli with cheese sauce','',1,42,'',0),(179,'Diced carrots','',1,42,'',0),(180,'Boiled pork dinner','',1,43,'',0),(181,'Whole potatoes Carrots','',1,43,'',0),(182,'cabbage','',1,43,'',0),(183,'Lasagna OS','',1,44,'',0),(184,'Garlic bread Caesar salad','',1,44,'',0),(185,'Irish Stew','',1,45,'',0),(186,'Bread roll wîtH margarine','',1,45,'',0),(187,'Salmon with white sauce','',1,46,'',0),(188,'Mashed potatoes','',1,46,'',0),(189,'Mixed vegetables','',1,46,'',0),(190,'Baked toupie ham','',1,47,'',0),(191,'Scalloped potatoes','',1,47,'',0),(192,'Vegetables','',1,47,'',0),(193,'Turkey and gravy','',1,48,'',0),(194,'Mashed potatoes','',1,48,'',0),(195,'Mixed vegetables','',1,48,'',0),(196,'Bologne','',1,49,'',0),(197,'Scalloped potatoes','',1,49,'',0),(198,'Carrots and green begns','',1,49,'',0),(199,'Boneless chicken Shake n\' Bake','',1,50,'',0),(200,'Mashed potatoes','',1,50,'',0),(201,'Peas and yellow string beans','',1,50,'',0),(202,'Cod nuggets','',1,51,'',0),(203,'Diced potatoes with cheese and gravy','',1,51,'',0),(204,'Mixed vegetables','',1,51,'',0),(205,'Roast Beef and gravy','',1,52,'',0),(206,'Mashed potatoes','',1,52,'',0),(207,'Carrots and cabbage','',1,52,'',0),(208,'Cod filet White sauce','',1,53,'',0),(209,'Baked/mashed potatoes','',1,53,'',0),(210,'Mixed vegetables','',1,53,'',0),(211,'Roast pork and gravy','',1,54,'',0),(212,'Mashed potatoes Carrots','',1,54,'',0),(213,'green beans','',1,54,'',0),(214,'Meatloaf','',1,55,'',0),(215,'Mashed potatoes Peas','',1,55,'',0),(216,'Beets','',1,55,'',0),(217,'Fish cakes OS and chow chow','',1,56,'',0),(218,'Brussel sprouts with cheesesauce','',1,56,'',0),(219,'Hot turkey sandwich','',1,57,'',0),(220,'Gravy','',1,57,'',0),(221,'Mashed potatoes','',1,57,'',0),(222,'Fries Peas','',1,57,'',0),(223,'coleslaw','',1,57,'',0),(224,'Macaroni with ground beef and tomate sauce','',1,58,'',0),(225,'Tossed salad with dressing','',1,58,'',0),(226,'BBQ pork cutlets','',1,59,'',0),(227,'Mashed potatoes','',1,59,'',0),(228,'Carrots and','',1,59,'',0),(229,'rutabaga','',1,59,'',0),(230,'Salmon filet','',1,60,'',0),(231,'Baked /mashed patata','',1,60,'',0),(232,'Mixed vegetables','',1,60,'',0),(233,'Râpé','',1,61,'',0),(234,'Vegetables','',1,61,'',0);
/*!40000 ALTER TABLE `lunch` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lunch_dessert`
--

DROP TABLE IF EXISTS `lunch_dessert`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `lunch_dessert` (
  `id` int NOT NULL AUTO_INCREMENT,
  `meal` varchar(45) DEFAULT NULL,
  `allergene` varchar(250) DEFAULT NULL,
  `enabled` int DEFAULT '1',
  `id_menu` int DEFAULT '0',
  `intolerance` varchar(45) DEFAULT NULL,
  `ids` int DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=203 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lunch_dessert`
--

LOCK TABLES `lunch_dessert` WRITE;
/*!40000 ALTER TABLE `lunch_dessert` DISABLE KEYS */;
INSERT INTO `lunch_dessert` VALUES (131,'Jello',NULL,1,8,NULL,0),(132,'Mandarins',NULL,1,9,NULL,0),(133,'Pudding',NULL,1,10,NULL,0),(134,'Strawberry',NULL,1,11,NULL,0),(135,'Yogurt',NULL,1,12,NULL,0),(136,'Peaches',NULL,1,13,NULL,0),(137,'Pears',NULL,1,14,NULL,0),(138,'Applesauce',NULL,1,15,NULL,0),(139,'Gravy',NULL,0,15,NULL,0),(140,'Assorted vegetables',NULL,0,15,NULL,0),(141,'milk 4oz',NULL,1,22,NULL,0),(142,'Chicken and vegetables casserole',NULL,1,23,NULL,0),(143,'Vegetable Soup',NULL,1,24,NULL,0),(144,'Buckwheat pancakes',NULL,1,25,NULL,0),(145,'Cod nuggets',NULL,1,26,NULL,0),(146,'Barley soup',NULL,1,27,NULL,0),(147,'Corned beef hash',NULL,1,28,NULL,0),(148,'Stuffed Chicken!',NULL,1,34,NULL,0),(149,'Macaroni and Cheese Casserole',NULL,1,35,NULL,0),(150,'Seafood Chowder',NULL,1,36,NULL,0),(151,'Meat pies',NULL,1,37,NULL,0),(152,'French toast and strawberries',NULL,1,38,NULL,0),(153,'Vegetable soup',NULL,1,39,NULL,0),(154,'Assorted cold plates',NULL,1,40,NULL,0),(163,'Black forest  cake square','',1,2,'',0),(164,'Jello','',1,1,'',0),(165,'Datte Cake',NULL,1,0,NULL,5),(166,'Ice cream',NULL,1,0,NULL,3),(167,'Pudding',NULL,1,0,NULL,6),(168,'Fruit salad','',1,16,'',0),(169,'Pudding','',1,17,'',0),(170,'Fruit Mousse','',1,18,'',0),(171,'Assorted fruits','',1,19,'',0),(172,'Mandarine','',1,20,'',0),(173,'Banana Muffin','',1,21,'',0),(174,'applesauce','',1,3,'',0),(175,'Mandarins','',1,4,'',0),(176,'Rhubarb','',1,5,'',0),(177,'Assorted fruits','',1,6,'',0),(178,'Pineapple Muffin','',1,7,'',0),(179,'Mandarins',NULL,1,0,NULL,18),(180,'Pudding',NULL,1,0,NULL,19),(181,'Strawberry',NULL,1,0,NULL,20),(182,'Yogurt','',1,41,'',0),(183,'Diced pear','',1,42,'',0),(184,'Crushed pineapple','',1,43,'',0),(185,'Apricots','',1,44,'',0),(186,'Strawberry rhubarb compote','',1,45,'',0),(187,'Fruit cocktail','',1,46,'',0),(188,'Diced peaches','',1,47,'',0),(189,'Banana','',1,48,'',0),(190,'Applesauce','',1,49,'',0),(191,'Yogurt','',1,50,'',0),(192,'Diced pear','',1,51,'',0),(193,'Crushed pineapple','',1,52,'',0),(194,'Apricots','',1,53,'',0),(195,'Mandarins','',1,54,'',0),(196,'Fruit Cocktail','',1,55,'',0),(197,'Diced peaches','',1,56,'',0),(198,'Assorted fresh fruit','',1,57,'',0),(199,'Applesauce','',1,58,'',0),(200,'lce Cream','',1,59,'',0),(201,'Diced pear','',1,60,'',0),(202,'Crushed pineapple','',1,61,'',0);
/*!40000 ALTER TABLE `lunch_dessert` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `menu_special`
--

DROP TABLE IF EXISTS `menu_special`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `menu_special` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(45) DEFAULT NULL,
  `enabled` int DEFAULT '1',
  `date` date DEFAULT NULL,
  `observation` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `menu_special`
--

LOCK TABLES `menu_special` WRITE;
/*!40000 ALTER TABLE `menu_special` DISABLE KEYS */;
INSERT INTO `menu_special` VALUES (1,'Mardi gras',0,'2026-02-17','NIL'),(2,'Mardi gras',1,'2026-02-17','NIL'),(3,'Mardi gras',1,'2025-02-17','crepes'),(5,'lkjhgfdfg',1,'2025-11-17',''),(6,'ns',1,'2025-12-23','');
/*!40000 ALTER TABLE `menu_special` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `menu_tbl`
--

DROP TABLE IF EXISTS `menu_tbl`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `menu_tbl` (
  `id` int NOT NULL AUTO_INCREMENT,
  `week` int DEFAULT NULL,
  `annee` varchar(45) DEFAULT NULL,
  `saison` enum('Winter','Spring','Summer','Falls','Christmass','New year') DEFAULT NULL,
  `day` varchar(15) DEFAULT NULL,
  `breakfast` text,
  `lunch` text,
  `lunch_dessert` text,
  `dinner` text,
  `dinner_dessert` text,
  `enabled` int DEFAULT '1',
  `date1` datetime DEFAULT NULL,
  `date2` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=62 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `menu_tbl`
--

LOCK TABLES `menu_tbl` WRITE;
/*!40000 ALTER TABLE `menu_tbl` DISABLE KEYS */;
INSERT INTO `menu_tbl` VALUES (1,1,'2026','Winter','Sunday','Orange juice (6oz) , prunes , Oatmeal , Cold cereal , Strawberries , Cheese or assorted eggs , Toasts, margarine, jam, milk 4oz, water 6oz, tea or coffee 6oz','Chicken Alfredo with noodles , Peas','milk 4oz, water 6oz, tea or coffee 6oz','Vegetable soup , Grilled cheese sandwich','Lemon tarts3',1,NULL,NULL),(2,1,'2026','Winter','Monday','Apple juice (6oz) , Prune juice(4oz) , Cream of wheat , Cold cereal , Banana , Assorted eggs','Sweet n\' Sour  or Swedish meatballs , Mashed potatoes , Carrots','','Cod nuggets , Diced potatoes , Coleslaw','',1,NULL,NULL),(3,1,'2026','Winter','Tuesday','Cranberry juice (6oz) , Prunes , Oatmeal , Cold cereal , Assorted eggs','Chicken fricot , \"Kaizer rolls\"','','Buckwheat pancakes , Blueberry sauce , syrup','',1,NULL,NULL),(4,1,'2026','Winter','Wednesday','Orange juice (6oz) , Prunejuice(4oz) , Cream of wheat , Cold cereal , Custard or assorted eggs','Shepherd\'s pie , Marinated beets','','Ham and caulflower chowder , Hot biscuit','',1,NULL,NULL),(5,1,'2026','Winter','Thursday','Apple juice (6oz) , Prunes , Oatmeal , Cold cereal , Bran muffin , Assorted eggs','Bologne , Scaloped potatoes , Vegetable medley','','Chicken and vegetable casserole','',1,NULL,NULL),(6,1,'2026','Winter','Friday','Cranberry juice (6oz) , Prune juice (4oz) , Cream of wheat , Cold cereal , Banana , Beans (canned)','Breaded fish fillet , Baked potato , Mixed vegetables','','Barley soup , Corn bread and cheese','',1,NULL,NULL),(7,1,'2026','Winter','Saturday','Orange juice(6oz) , Prunes , Oatmeal , Cold cereal , Assorted eggs and bacon','Roast beef and gravy , Mashed potatoes , Turnip','','Fish Cakes , Chow chow','',1,NULL,NULL),(8,2,'2026','Winter','Sunday','Apple juice (6oz) , Prune juice (4oz) , Cream of wheat , Cold cereal , Strawberries , Cheese or assorted eggs , Toasts, margarine, jam, milk 4oz, water 6oz, tea or coffee 6oz','Roast chicken and gravy , Mashed potatoes , Vegetable medley','Choice of soup','Assorted sandwiches , 2nd option:','Cherry Square',1,NULL,NULL),(9,2,'2026','Winter','Monday','Cranberry juice (6oz) , Prunes , Oatmeal , Cold cereal , Banana , Assorted eggs','Poutines,Râpé , Mixed vegetables','Pasta with ground beef and tomato sauce','2nd option:','Blueberry Muffin',1,NULL,NULL),(10,2,'2026','Winter','Tuesday','Orange juice (6oz) , Prune juice (4oz) , Cream of wheat , Cold cereal , Assorted eggs','Salted cod , Boiled potatoes , Peas and carrots','Baked beans','Hot biscuit , 2nd option:','Banana Square',1,NULL,NULL),(11,2,'2026','Winter','Wednesday','Apple juice (6oz) , Prunes , Oatmeal , French toast , syrup , Custard or assorted eggs','Meat pie or pizza with green salad , Mashed potato , Green beans','Chicken noodle soup','Vegetable fritatta , Green Salad , 2nd option:','Molasses Cake',1,NULL,NULL),(12,2,'2026','Winter','Thursday','Cranberry juice (6oz) , Prune juice (4oz) , Cream of wheat , Cold cereal , Bran muffin , Assorted eggs','Roast beef and gravy , Boiled potatoes , Turnips and carrots','Tomato juice','Pancakes , Cheese , 2nd option:','Raisin Pie',1,NULL,NULL),(13,2,'2026','Winter','Friday','Orange juice (6oz) , Prunes , Oatmeal , Cold cereal , Banana , Beans (canned)','Clam stew , Bread roll','Chicken Hash and gravy','2nd option:','Pudding',1,NULL,NULL),(14,2,'2026','Winter','Saturday','Apple juice (6oz) , Prune juice (4oz) , Cream of wheat , Cold cereal , Assorted eggs and bacon','Chicken Chasseur , Mashed potatoes , Brocoli and carrots','Hearty homemade beef soup','2nd option:','Rhubarb Cheesecake',1,NULL,NULL),(15,3,'2026','Winter','Sunday','Cranberry juice (6oz) , Prunes , Oatmeal , Cold cereal , Strawberries , Cheese or assorted eggs , Toasts, margarine, jam, milk 4oz, water 6oz, tea or coffee 6oz','Swiss steak , Mashed potatoes , Green peas','milk 4oz, water 6oz, tea or coffee 6oz','Stuffed Chicken , Gravy , Assorted vegetables','2nd option:',1,NULL,NULL),(16,3,'2026','Winter','Monday','Orange juice (6oz) , Prune juice (4oz) , Cream of wheat , Cold cereal , Banana , Assorted eggs','Pork chops in cream of mushroom , Whipped potatoes , Mixed vegetables','','Macaroni and Cheese Casserole , Broccoli or Green salad','2nd option:',1,NULL,NULL),(17,3,'2026','Winter','Tuesday','Apple juice (6oz) , Prunes , Oatmeal , Cold cereal , Assorted eggs','Chicken à la King Casserole , Green Beans , Dinner roll','','French toast and strawberries','2nd option:',1,NULL,NULL),(18,3,'2026','Winter','Wednesday','Cranberry juice (6oz) , Prune juice (4oz) , Cream of wheat , Cold cereal , Custard or assorted eggs','Meatloaf and gravy  , Mashed potatoes , Beets','','Crêpes râpées , Baby carrots','2nd option:',1,NULL,NULL),(19,3,'2026','Winter','Thursday','Orange juice (6oz) , Prunes , Oatmeal , Cold cereal , Bran muffin , Assorted eggs','Hot turkey sandwich , Mashed potato , Coleslaw','','Egg and Ham Scramble , Diced Fresh Tomatoes , Seasoned Home Fries','2nd option:',1,NULL,NULL),(20,3,'2026','Winter','Friday','Apple juice (6oz) , Prune juice (4oz) , Cream of wheat , Cold cereal , Banana , Beans (canned)','Cod fish in white sauce , Mashed potato , Green beans','','Hamburgers , Chips , Green peas salad','2nd option:',1,NULL,NULL),(21,3,'2026','Winter','Saturday','Cranberry juice (6oz) , Prunes , Oatmeal , Cold cereal , Assorted eggs and bacon','Pork roast and gravy , Boiled potatoes , Carrots','','Beef fricot , Bread roll','2nd option:',1,NULL,NULL),(22,5,'2025','New year','Sunday','Sunday , Cranberry juice (6oz) , Prunes , Oatmeal , Cold cereal , Strawberries , Cheese or assorted eggs','Toasts, margarine, jam, milk 4oz, water 6oz, tea or coffee 6oz , Shepherd\'s Pie , Marinated beets','Jell-o','milk 4oz, water 6oz, tea or coffee 6oz , Fish cakes , Chow chow','2nd option:',1,NULL,NULL),(23,5,'2025','New year','Monday','Monday , Orange juice (6oz) , Prune juice (4oz) , Cream of wheat , Cold cereal , Banana , Assorted eggs','Bologne , Scaloped poatoes','Pudding with whip','Chicken and vegetables casserole','2nd option:',1,NULL,NULL),(24,5,'2025','New year','Tuesday','Tuesday , Apple juice (6oz) , Prunes , Oatmeal , Cold cereal , Assorted eggs','Chicken Fricot , Kaizer roll','Applesauce','Vegetable Soup , Grilled cheese sandwich','2nd option:',1,'2025-12-01 00:00:00',NULL),(25,5,'2025','New year','Wednesday','Wednesday , Cranberry juice (6oz) , Prune juice (4oz) , Cream of wheat , Cold cereal , Custard or assorted eggs','Turkey, stuffing and gravy , Cranberry sauce','Chocolate Éclairs','Buckwheat pancakes , Blueberry syrup','2nd option:',1,'2026-01-01 00:00:00',NULL),(26,5,'2025','New year','Thursday','Thursday , Orange juice (6oz) , Prunes , Oatmeal , Cold cereal , Bran muffin , Assorted eggs','Sweet n\' Sour  or Swedish meatballs , Mashed potatoes','Butterscotch square','Cod nuggets , Diced potatoes','2nd option:',1,NULL,NULL),(27,5,'2025','New year','Friday','Friday , Apple juice (6oz) , Prune juice (4oz) , Cream of wheat , Cold cereal , Banana , Beans','Breaded fish filet , Baked potato','Carrot Cake','Barley soup , Cornbread and cheese','2nd option:',1,NULL,NULL),(28,5,'2025','New year','Saturday','Saturday , Cranberry juice (6oz) , Prunes , Oatmeal , Cold cereal , Assorted eggs and bacon','Roast Beef and gravy , Mashed potatoes','Pineapple muffin','Corned beef hash , Green salad','2nd option:',1,NULL,NULL),(34,4,'2025','Christmass','Sunday','Cranberry juice (6oz), Prunes, Oatmeal, Cold cereal, Strawberries, Cheese or assorted eggs','Swiss steak, Mashed potatoes, Green beans, Carrots','Carrot cake','Stuffed Chicken, Gravy, Assorted vegetables xx','Applesauce',1,NULL,NULL),(35,4,'2025','Christmass','Monday','Orange juice (6oz), Prune juice (4oz), Cream of wheat, Cold cereal, Banana, Assorted eggs','Pork chops in cream of mushroom, Whipped potatoes, Mixed vegetables','Fruit salad','Macaroni and Cheese Casserole, Green salad','Strawberry shortcake',1,NULL,NULL),(36,4,'2025','Christmass','Tuesday','Apple juice (6oz), Prunes, Oatmeal, Cold cereal, Assorted eggs','Chicken à la King Casserole, Green beans, Dinner roll','Pudding','Seafood Chowder, Bread roll','Lemon tarts',1,NULL,NULL),(37,4,'2025','Christmass','Wednesday','Cranberry juice (6oz), Prune juice (4oz), Cream of wheat, Pancakes , syrup, Custard or assorted eggs','Poutine râpée, Mixed vegetables','Yule log','Meat pies, Diced potatoes, Coleslaw','Assorted squares',1,NULL,NULL),(38,4,'2025','Christmass','Thursday','Orange juice (6oz), Prunes, Oatmeal, Cold cereal, Bran muffin, Assorted eggs','Hot turkey sandwich, Oven baked fries, Coleslaw','Assorted fruits','French toast and strawberries','Homemade cookies',1,NULL,NULL),(39,4,'2025','Christmass','Friday','Apple juice (6oz), Prune juice (4oz), Cream of wheat, Cold cereal, Banana, Assorted eggs','Shepherd’s pie, Beets, Turnips','Pineapple upside down cake','Vegetable soup, Sandwich','Rice pudding',1,NULL,NULL),(40,4,'2025','Christmass','Saturday','Orange juice (6oz), Prunes, Oatmeal, Cold cereal, Muffin, Assorted eggs','Roast beef, Mashed potatoes, Gravy, Mixed vegetables','Fruit cocktail','Assorted cold plates, Salad','Assorted fruits',1,NULL,NULL),(41,1,'2026','Spring','Sunday','Orange juîce (6oz), prunes, Oatmeal, Cold cereal, Strawberries, Cheese or  assorted eggs','Cantonese Chicken, Mashed potatoes Mixed, vegetables','Yogurt','Steak Sub (peppers, onions, mushroom and cheese)','Mandarins',1,'2026-02-27 12:41:16',NULL),(42,1,'2026','Spring','Monday','Apple juice {6oz), Prune juice(4oz), Cream of wheat, Cold cereal, Banana, Assorted eggs','Breaded fish fillet with tartar sauce, Mashed potatoes, Broccoli with cheese sauce, Diced carrots','Diced pear','Beef fricot, Bread roll with margarine','Assorted pie',1,'2026-02-27 12:41:16',NULL),(43,1,'2026','Spring','Tuesday','Cranberry juice {6oz), Prunes, Oatmeal, Cold cereal, Assorted eggs','Boiled pork dinner, Whole potatoes Carrots, cabbage','Crushed pineapple','Vegetable soup, Assorted sandwiches, grilled cheese','Cherry square',1,'2026-02-27 12:41:16',NULL),(44,1,'2026','Spring','Wednesday','Orange juice {6oz), Prunejuice(4oz), Cream of wheat, Cold cereal, Custard, assorted eggs','Lasagna OS, Garlic bread Caesar salad','Apricots','Chicken noodle soup, Homemade baked beans Hot biscuit','lce Cream',1,'2026-02-27 12:41:16',NULL),(45,1,'2026','Spring','Thursday','Apple juice (6oz), Prunes, Oatmeal, Cold cereal, Bran muffin, Assorted eggs','Irish Stew, Bread roll wîtH margarine','Strawberry rhubarb compote','Chicken pie  (OS) with gravy, Seasoned diced potatoes, Fresh tomatoes, cucumbers','Date square',1,'2026-02-27 12:41:16',NULL),(46,1,'2026','Spring','Friday','Cranberry juice {6oz), Prune juice (4oz), Cream of wheat Cold cereal, Banana, Beans (canned)','Salmon with white sauce, Mashed potatoes, Mixed vegetables','Fruit cocktail','Buckwheat pancakes Cheese','Homemade cookies',1,'2026-02-27 12:41:16',NULL),(47,1,'2026','Spring','Saturday','Orange juice(6oz), Prunes, Oatmeal, Cold cereal, Assorted eggs, bacon','Baked toupie ham, Scalloped potatoes, Vegetables','Diced peaches','Chicken nuggets, Mashed potatoes or Fries, Peas and carrots, Coleslaw','Yogurt',1,'2026-02-27 12:41:16',NULL),(48,2,'2026','Spring','Sunday','Apple juice (6oz), Prune juice (4oz), Cheese or  assorted eggs, Cream of wheat, Cold cereal, Strawberries','Turkey and gravy, Mashed potatoes, Mixed vegetables','Banana','Vegetable soup, Assorted sandwich','Homemade cookies',1,'2026-02-27 12:41:16',NULL),(49,2,'2026','Spring','Monday','Cranberry juice (6oz), Prunes, Assorted eggs, Oatmeal, Cold cereal, Banana','Bologne, Scalloped potatoes, Carrots and green begns','Applesauce','Homemade baked beans, Bread roll','Banana bread',1,'2026-02-27 12:41:16',NULL),(50,2,'2026','Spring','Tuesday','Orange juice (6oz), Prune juice (4oz), Assorted eggs, Cream of wheat, Cold cereal','Boneless chicken Shake n\' Bake, Mashed potatoes, Peas and yellow string beans','Yogurt','Vegetable juice Bar Clam Fricot, Bread roll with margarine','Strawberry rhubarb compote',1,'2026-02-27 12:41:16',NULL),(51,2,'2026','Spring','Wednesday','Apple juice (6oz), Prunes, Oatmeal, French toast/ syrup, Custard or assorted eggs','Cod nuggets, Diced potatoes with cheese and gravy, Mixed vegetables','Diced pear','Spaghetti with meat sauce, Garlic bread','Carrot cake',1,'2026-02-27 12:41:16',NULL),(52,2,'2026','Spring','Thursday','Cranberry juice(6oz), Prune juice (4oz), Bran muffin, Assorted eggs, Cream of wheat, Cold cereal','Roast Beef and gravy, Mashed potatoes, Carrots and cabbage','Crushed pineapple','Minestrone soup (OS), Grilled cheese sandwich','lce Cream',1,'2026-02-27 12:41:16',NULL),(53,2,'2026','Spring','Friday','Orange juice (6oz), Prunes Oatmeal Banana, Beans (canned), Cold cereal','Cod filet White sauce, Baked/mashed potatoes, Mixed vegetables','Apricots','Vegetable Omelet, Tossed salad with dressing, Toast','Leman pie',1,'2026-02-27 12:41:16',NULL),(54,2,'2026','Spring','Saturday','Apple juice (6oz), Prune juice (4oz), Assorted eggs and bacon, Cold cereal','Roast pork and gravy, Mashed potatoes Carrots, green beans','Mandarins','Soup of the day, Assorted subs','Apple Crisp',1,'2026-02-27 12:41:16',NULL),(55,3,'2026','Spring','Sunday','Cranberry juice {6oz), Prunes, Oatmeal, Cold cereal, Strawberries, Cheese or assorted eggs','Meatloaf, Mashed potatoes Peas, Beets','Fruit Cocktail','Chicken fricot, Bread roll','Wild Blueberry Crisp',1,'2026-02-27 12:41:16',NULL),(56,3,'2026','Spring','Monday','Orange juice (6oz), Prune juice (4oz), Cream of wheat, Cold cereal, Banana, Assorted eggs','Fish cakes OS and chow chow, Brussel sprouts with cheesesauce','Diced peaches','Tomate soup Pancakes with syrup','Yogurt',1,'2026-02-27 12:41:16',NULL),(57,3,'2026','Spring','Tuesday','Apple juice (6oz), Prunes, Oatmeal, Cold cereal, Assorted eggs','Hot turkey sandwich, Gravy, Mashed potatoes, Fries Peas, coleslaw','Assorted fresh fruit','Ham and cauliflower chowder, Hot biscuit','Pineapple square',1,'2026-02-27 12:41:16',NULL),(58,3,'2026','Spring','Wednesday','Cranberry juice {6oz), Cream of wheat, Cold cereal, Custard or assorted eggs','Macaroni with ground beef and tomate sauce, Tossed salad with dressing','Applesauce','Homemade baked beans, Vegetable juice, Bread roll','Homemade cookies',1,'2026-02-27 12:41:16',NULL),(59,3,'2026','Spring','Thursday','Orange juice (6oz), Prunes, Oatmeal, Cold cereal, Assorted eggs, Bran muffin','BBQ pork cutlets, Mashed potatoes, Carrots and, rutabaga','lce Cream','Pizza Casserole, Garden Salad with dressing','Strawberry and rhubarbcompote',1,'2026-02-27 12:41:16',NULL),(60,3,'2026','Spring','Friday','Apple juice {6oz), Prune juice (4oz), Cream of wheat, Cold cereal, Beans (canned), Banana','Salmon filet, Baked /mashed patata, Mixed vegetables','Diced pear','Cream of broccoli OS, Assorted Sandwiches','Pudding',1,'2026-02-27 12:41:16',NULL),(61,3,'2026','Spring','Saturday','Cranberry juice {6oz), Prunes, Oatmeal, Cold cereal, Assorted eggs and bacon','Râpé, Vegetables','Crushed pineapple','Chicken à la King Casserole, Garlic Bread, Asparagus','Muffin',1,'2026-02-27 12:41:16',NULL);
/*!40000 ALTER TABLE `menu_tbl` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `menu_unique`
--

DROP TABLE IF EXISTS `menu_unique`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `menu_unique` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(45) DEFAULT NULL,
  `enabled` int DEFAULT '1',
  `date` date DEFAULT NULL,
  `observation` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `menu_unique`
--

LOCK TABLES `menu_unique` WRITE;
/*!40000 ALTER TABLE `menu_unique` DISABLE KEYS */;
INSERT INTO `menu_unique` VALUES (1,'Mardi gras',0,'2026-02-17','NIL'),(2,'Mardi gras',0,'2026-02-17','NIL'),(3,'Mardi gras',0,'2025-02-17','crepes'),(5,'lkjhgfdfg',0,'2025-11-17',''),(6,'test01',0,'2025-12-21',''),(7,'test02',0,'2025-12-21',''),(8,'test05',0,'2025-12-22',''),(9,'test06',0,'2026-01-20',''),(10,'test08',0,'2026-01-20',''),(11,'test09',0,'2026-01-27',''),(13,'xunique',0,'2026-01-23',''),(14,'menu du 24',0,'2026-01-24','nnn'),(15,'Annuel 2026-01',0,'2026-01-23','TEst001'),(16,'menu finale',0,'2026-01-25','tilt'),(17,'menu unique01',0,'2026-01-30','01'),(18,'16feb2026',1,'2026-02-16',''),(19,'Mardis gras',1,'2026-02-17',''),(20,'Ash Wdnesday',1,'2026-02-18',''),(21,'16feb2026',1,'2026-02-27',''),(22,'Good Friday',0,'2026-04-03','');
/*!40000 ALTER TABLE `menu_unique` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `multi`
--

DROP TABLE IF EXISTS `multi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `multi` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_resident` int DEFAULT NULL,
  `date` date DEFAULT NULL,
  `enabled` int DEFAULT NULL,
  `environnement` text,
  `alimentaire` text,
  `observation` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `multi`
--

LOCK TABLES `multi` WRITE;
/*!40000 ALTER TABLE `multi` DISABLE KEYS */;
/*!40000 ALTER TABLE `multi` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `off_table`
--

DROP TABLE IF EXISTS `off_table`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `off_table` (
  `Id` int NOT NULL AUTO_INCREMENT,
  `IdStaff` int DEFAULT '0',
  `hour` decimal(6,2) DEFAULT NULL,
  `Date` date DEFAULT NULL,
  `off` varchar(45) DEFAULT NULL,
  `observation` varchar(45) DEFAULT NULL,
  `enabled` int DEFAULT '1',
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `off_table`
--

LOCK TABLES `off_table` WRITE;
/*!40000 ALTER TABLE `off_table` DISABLE KEYS */;
/*!40000 ALTER TABLE `off_table` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `organisation`
--

DROP TABLE IF EXISTS `organisation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `organisation` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(45) DEFAULT NULL,
  `adresse` varchar(45) DEFAULT NULL,
  `ville` varchar(45) DEFAULT NULL,
  `code_postale` varchar(45) DEFAULT NULL,
  `pays` varchar(45) DEFAULT NULL,
  `telephone` varchar(45) DEFAULT NULL,
  `fax` varchar(45) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `web` varchar(45) DEFAULT NULL,
  `region` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `organisation`
--

LOCK TABLES `organisation` WRITE;
/*!40000 ALTER TABLE `organisation` DISABLE KEYS */;
INSERT INTO `organisation` VALUES (1,'FOYER ASSOMPTION','62','R','E4Y 1S5','Canada','5067752040','5067752053','die.fa@nb.aibn.com','foyerassomption.ca','Nouveau-Brunswick');
/*!40000 ALTER TABLE `organisation` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `preparation`
--

DROP TABLE IF EXISTS `preparation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `preparation` (
  `id` int NOT NULL AUTO_INCREMENT,
  `date` varchar(45) DEFAULT NULL,
  `plat` varchar(45) DEFAULT NULL,
  `ingredient` varchar(45) DEFAULT NULL,
  `nb` varchar(45) DEFAULT NULL,
  `unite` varchar(45) DEFAULT NULL,
  `action` varchar(45) DEFAULT NULL,
  `jour` varchar(45) DEFAULT NULL,
  `enabled` int DEFAULT '1',
  `preparation_date` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `preparation`
--

LOCK TABLES `preparation` WRITE;
/*!40000 ALTER TABLE `preparation` DISABLE KEYS */;
INSERT INTO `preparation` VALUES (1,'2025-01-20','Sweet n\' Sour  or Swedish meatballs','Bœuf haché','2','u','Defrost','2',1,'2025-01-18'),(2,'2025-01-20','Jello','Jello','1','Pack','Prepare','1',1,'2025-01-19'),(3,'2025-01-20','Coleslaw','Chou','4','Livre','Chop','1',1,'2025-01-19'),(4,'2025-01-16','Bran muffin','The Mixture','1','Recepie Book','Prepare','2',1,'2025-01-14'),(5,'2025-01-16','Bran muffin','The Mixture','1','Pièce','Bake','1',1,'2025-01-15'),(6,'2025-01-16','Coleslaw','Chou','4','Livre','Chop','1',1,'2025-01-15'),(7,'2025-01-16','Hot turkey sandwich','Turkey','1','Pièce','Defrost','5',1,'2025-01-11'),(8,'2025-01-16','Hot turkey sandwich','Turkey','1','Pièce','Bake','2',1,'2025-01-14'),(9,'2025-01-16','Hot turkey sandwich','Turkey','1','Pièce','Debone','1',1,'2025-01-15'),(10,'2026-02-15','Strawberries','Fraises','1','Pack','Defrost','1',1,'2026-02-14'),(11,'2026-02-15','Roast chicken and gravy','Poulet','3','Pièce','Defrost','3',1,'2026-02-12'),(12,'2026-02-15','Roast chicken and gravy','Poulet','3','Pièce','Bake','2',1,'2026-02-13'),(13,'2026-02-15','Roast chicken and gravy','Poulet','3','Pièce','Debone','2',1,'2026-02-13'),(14,'2026-02-15','Assorted sandwiches','Sandwiches','50','Pièce','Prepare','1',1,'2026-02-14'),(15,'2026-02-14','Roast beef and gravy','Rôti de bœuf','3','Recepie Book','Defrost','3',1,'2026-02-11'),(16,'2026-02-14','Roast beef and gravy','Rôti de bœuf','3','Pièce','Bake','2',1,'2026-02-12'),(17,'2026-02-13','Beef chicken Vegetable barley soup','Bœuf en cubes','3','Pièce','Defrost','3',1,'2026-02-10'),(18,'2026-02-12','Bologne','Bologne','1','Pièce','Defrost','2',1,'2026-02-10'),(19,'2026-02-16','Blueberry Muffin','Muffins','50','Pièce','Prepare','1',1,'2026-02-15'),(20,'2026-02-16','Blueberry Muffin','Muffins','50','Pièce','Bake','1',1,'2026-02-15'),(21,'2026-02-17','Salted cod','Salted cod','1','Pack','Unsalt','1',1,'2026-02-16'),(22,'2026-02-18','Meat pie or pizza with green salad','Meat pie congelé','2','Pack','Defrost','4',1,'2026-02-14'),(23,'2026-02-18','Meat pie or pizza with green salad','Meat pie Mix','2','Pack','Bake','3',1,'2026-02-15'),(24,'2026-02-18','Meat pie or pizza with green salad','Meat Pies','10','bttl','Mount','2',1,'2026-02-16'),(25,'2026-02-18','Strawberry','Fraises','1','Pack','Defrost','1',1,'2026-02-17'),(26,'2026-02-18','Custard or assorted eggs','Custard','1','Recepie Book','Cook','1',1,'2026-02-17'),(27,'2026-02-19','Roast beef and gravy','Rôti de bœuf','3','Pack','Defrost','3',1,'2026-02-16'),(28,'2026-02-19','Roast beef and gravy','Rôti de bœuf','3','Pack','Bake','1',1,'2026-02-18'),(29,'2026-02-19','Bran muffin','Muffins','50','Pièce','Bake','1',1,'2026-02-18'),(30,'2026-02-21','Chicken Chasseur','Poulet','3','Pièce','Bake','3',0,'2026-02-18'),(31,'2026-02-21','Chicken Chasseur','Poulet','3','Pièce','Bake','1',0,'2026-02-20'),(32,'2026-02-21','Chicken Chasseur','Poulet','3','Pièce','Defrost','3',1,'2026-02-18'),(33,'2026-02-21','Chicken Chasseur','Poulet','3','bttl','Bake','1',1,'2026-02-20'),(34,'2026-02-21','Chicken Chasseur','Poulet','3','Pièce','Debone','1',1,'2026-02-20'),(35,'2026-02-21','Hearty homemade soup beef','Bœuf en cubes','3','Pack','Defrost','2',1,'2026-02-19'),(36,'2026-02-22','Swiss steak','Swiss Steak','3','Pack','Defrost','3',1,'2026-02-19'),(37,'2026-02-22','Swiss steak','Swiss Steak','3','bttl','Pre Cook','1',1,'2026-02-21'),(38,'2026-02-22','Stuffed Chicken','Poulet','3','Pack','Defrost','3',1,'2026-02-19'),(39,'2026-02-22','Stuffed Chicken','Poulet','3','Pièce','Bake','1',1,'2026-02-21'),(40,'2026-02-22','Stuffed Chicken','Poulet','3','Pack','Debone','1',1,'2026-02-21'),(41,'2026-02-20','Pasta with ground beef tomato sauce','Bœuf haché','3','Pack','Defrost','3',1,'2026-02-17'),(42,'2026-02-16','Meat pies','Meat pie congelé','5','Pièce','Defrost','1',1,'2026-02-15'),(43,'2026-02-16','Meat pies','Meat pie Mix','2','Pack','Defrost','3',1,'2026-02-13'),(44,'2026-02-16','Meat pies','Meat pie Mix','2','Pack','Bake','2',1,'2026-02-14'),(45,'2026-02-16','Meat pies','Meat pie Mix','5','Pièce','Prepare','1',1,'2026-02-15'),(46,'2026-02-18','salted cod','Salted cod','1','Pack','Unsalt','1',1,'2026-02-17'),(47,'2026-02-19','Roast beef and gravy','Rôti de bœuf','3','Pièce','Slice','1',1,'2026-02-18');
/*!40000 ALTER TABLE `preparation` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `resident_tbl`
--

DROP TABLE IF EXISTS `resident_tbl`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `resident_tbl` (
  `id` int NOT NULL AUTO_INCREMENT,
  `Gender` varchar(45) DEFAULT 'Ns',
  `Prenom` text,
  `Nom` text,
  `Enabled` int DEFAULT '1',
  `mark` int DEFAULT '1',
  `Anniversaire` date DEFAULT NULL,
  `Famille` text,
  `Relation` text,
  `Tel1` text,
  `Tel2` text,
  `Tel3` text,
  `Chambre` text,
  `Numero` varchar(45) DEFAULT NULL,
  `Diabet` varchar(45) DEFAULT '0',
  `Puree` varchar(45) DEFAULT '0',
  `Grinded` varchar(45) DEFAULT '0',
  `leavedate` date DEFAULT NULL,
  `CauseDepart` varchar(45) DEFAULT NULL,
  `LieuRepas` varchar(45) DEFAULT NULL,
  `Admission` date DEFAULT NULL,
  `ModeEating` varchar(45) DEFAULT 'Ns',
  `Allergie` varchar(450) DEFAULT NULL,
  `Juice` varchar(45) DEFAULT 'Ns',
  `Prune` varchar(45) DEFAULT NULL,
  `Bread` varchar(450) DEFAULT 'Ns',
  `Eggs` varchar(45) DEFAULT 'Ns',
  `Cereale` varchar(450) DEFAULT 'Ns',
  `Picture` varchar(45) DEFAULT 'Ns',
  `Diet` varchar(45) DEFAULT NULL,
  `Lunch` varchar(45) DEFAULT NULL,
  `Dinner` varchar(45) DEFAULT NULL,
  `moremeal` varchar(45) DEFAULT NULL,
  `lessmeal` varchar(45) DEFAULT NULL,
  `Thickened` varchar(45) DEFAULT 'Ns',
  `Consistance` varchar(45) DEFAULT NULL,
  `Milk` varchar(45) DEFAULT NULL,
  `Lactose` varchar(45) DEFAULT NULL,
  `HotDrink` varchar(45) DEFAULT NULL,
  `Confirmation_birthday` int DEFAULT '0',
  `DepartObs` varchar(45) DEFAULT NULL,
  `Intolerance` varchar(450) DEFAULT NULL,
  `Tartinade` varchar(450) DEFAULT NULL,
  `Proteine` varchar(450) DEFAULT NULL,
  `Fruit` varchar(450) DEFAULT NULL,
  `Breuvage_dej` varchar(450) DEFAULT NULL,
  `Breuvage_din` varchar(450) DEFAULT NULL,
  `Breuvage_sou` varchar(450) DEFAULT NULL,
  `Autre_fruit` varchar(450) DEFAULT NULL,
  `Regime` varchar(450) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=90 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='	';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `resident_tbl`
--

LOCK TABLES `resident_tbl` WRITE;
/*!40000 ALTER TABLE `resident_tbl` DISABLE KEYS */;
INSERT INTO `resident_tbl` VALUES (1,'Femme','Eva','ARSENEAU',0,0,'1950-08-12','Gerard Arseneault','Grands parents','775-0987','624-7205','','B-6a','B2','0','1','0','2024-11-30','Décès',NULL,'2020-01-01','Ns','sellfish','Orange','Jus','Roti pain blanc','Omelette','Cereales chaudes','Ns','no salt','poulet','soupe','','','Ns',NULL,'Grand','Normale',NULL,0,'palliatif',NULL,'Beurre','Custard','Fraise','','','',NULL,NULL),(2,'Femme','Thérèse','ARSENEAULT',0,0,'1931-05-20','Jimmy','Fille','251-3292','775-2365','625-4767','04-A','B22','1','1','0','2025-11-28','Décès',NULL,'2020-01-01','Ns',NULL,'Ns',NULL,'Ns','Ns','Ns','Ns',NULL,NULL,NULL,NULL,NULL,'Ns',NULL,NULL,NULL,NULL,0,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(3,'Femme','Marguerite','BABIN',0,0,'1940-05-14','Bella Hachey','fille','775-9096','378-0114','','','S10','0','1','0',NULL,NULL,NULL,'2020-01-01','Ns',NULL,'Ns',NULL,'Ns','Ns','Ns','Ns',NULL,NULL,NULL,NULL,NULL,'Ns',NULL,NULL,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(4,'Femme','Suzanne','BLAIS',0,0,'1926-06-22','Leonard Vautour','Epoux','705-663-2711','','','05-B','B4','0','0','1','2025-09-30','Décès',NULL,'2020-01-01','Ns',NULL,'Ns',NULL,'Ns','Ns','Ns','Ns',NULL,NULL,NULL,NULL,NULL,'Ns',NULL,NULL,NULL,NULL,0,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(5,'Homme','Willie','BOURQUE',0,0,'1932-09-11','Yvonne Bourque','Epoux','775-2863','251-1815','','01-B','','0','1','0','2025-10-13','Décès',NULL,'2012-10-22','Ns',NULL,'Ns',NULL,'Ns','Ns','Ns','Ns',NULL,NULL,NULL,NULL,NULL,'Ns',NULL,NULL,NULL,NULL,2,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(6,'Femme','Yvonne','CAISSIE',1,1,'1931-06-19','Edgar Gallant','Epoux','625-8586','','','02-A','','0','0','0',NULL,NULL,NULL,NULL,'Ns',NULL,'Ns',NULL,'Ns','Ns','Ns','Ns',NULL,NULL,NULL,NULL,NULL,'Ns',NULL,NULL,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(7,'Femme','Dorina','CAMERON',1,1,'1935-07-13','Rita Blacquière','Epoux','251-5801','','','07-A','S2','0','0','0',NULL,NULL,NULL,NULL,'Ns',NULL,'Ns',NULL,'Ns','Ns','Ns','Ns',NULL,NULL,NULL,NULL,NULL,'Ns',NULL,NULL,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(8,'Femme','Lina','CHIASSON',0,0,'1935-10-30','Jocelyne Beaulieu','Grands parents','775-1106','625-2520','','C-6','','0','0','1','2024-10-21','Décès',NULL,NULL,'Ns',NULL,'Ns',NULL,'Ns','Ns','Ns','Ns',NULL,NULL,NULL,NULL,NULL,'Ns',NULL,NULL,NULL,NULL,1,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(9,'Homme','Omer','DAIGLE',1,1,'1961-03-27','Murielle Robichaud','Epoux','876-2136','524-3063','','01-A','S4','1','1','0',NULL,NULL,NULL,'2022-01-01','Ns',NULL,'Ns',NULL,'Ns','Ns','Ns','omer_daigle.png',NULL,NULL,NULL,NULL,NULL,'Ns',NULL,NULL,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(10,'Homme','Arthur','DESPRÉS',0,0,'1943-06-06','Cécilia Després','Na','625-1634','','','C-8b','','1','0','0','2025-08-09','Décès',NULL,NULL,'Ns',NULL,'Ns',NULL,'Ns','Ns','Ns','xmemere.jpg',NULL,NULL,NULL,NULL,NULL,'Ns',NULL,NULL,NULL,NULL,0,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(11,'Homme','Gérard','DESPRÉS',0,0,'1930-04-19','Charlotte Goguen','Na','775-6098','775-6600','','','B25','0','1','0',NULL,NULL,NULL,NULL,'Ns',NULL,'Ns',NULL,'Ns','Ns','Ns','memere.jpg',NULL,NULL,NULL,NULL,NULL,'Ns',NULL,NULL,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(12,'Homme','Laurie','DESPRÉS',0,0,'1946-12-31','Cécilia Després','Autre','625-1634','610-7894','','','B27','0','0','1',NULL,NULL,'Cafeteria','2024-03-10','Autonome','Pistache,Melon','Cranberry','Jus','Whole,GlutenFree','Omelette','CreamWheat','laurie_després.jpg','Sans sucre','poulet','Soupe','Poulet','Kiwi','IDDSI1','Normal','Moyen',NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(13,'Homme','Ulysse','DOIRON',0,0,'1931-10-14','Lucina Martin','soeur','775-0816','210-0658','','C-8a','','1','0','0','2024-12-15','Décès',NULL,NULL,'Ns',NULL,'Ns',NULL,'Ns','Ns','Ns','xmemere3.jpg',NULL,NULL,NULL,NULL,NULL,'Ns',NULL,NULL,NULL,NULL,1,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(14,'Femme','Yvette','DOIRON',1,1,'1946-09-24','Bernice Maillet','Epoux','524-7519','523-3742','','04-B','B7','0','1','0',NULL,NULL,NULL,NULL,'Ns',NULL,'Ns',NULL,'Ns','Ns','Ns','xmemere2.jpg',NULL,NULL,NULL,NULL,NULL,'Ns',NULL,NULL,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(15,'Femme','Bella','DOUCET',0,1,'1928-10-03','Odette McCaie','Fille','625-6242','','','04-A','','0','0','1',NULL,'Décès',NULL,NULL,'Ns',NULL,'Ns',NULL,'Ns','Ns','Ns','sary2.jpg',NULL,NULL,NULL,NULL,NULL,'Ns',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(16,'Femme','Eléonore','DURELLE',0,0,'1931-07-30','Laurie-Anne Durelle','fille','251-4494','','','','S1','0','1','0','2023-12-22','DECES',NULL,NULL,'Ns',NULL,'Ns',NULL,'Ns','Ns','Ns','Ns',NULL,NULL,NULL,NULL,NULL,'Ns',NULL,NULL,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(17,'Femme','Marguerite','FINNIGAN',0,0,'1931-02-23','Carmelle Richard','fille','775-2807','233-2807','','C-3a','','1','0','0','2025-05-19','Décès',NULL,NULL,'Ns',NULL,'Ns',NULL,'Ns','Ns','Ns','marguerite_finnigan.jpg',NULL,NULL,NULL,NULL,NULL,'Ns',NULL,NULL,NULL,NULL,0,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(18,'Femme','Eva','GALLANT',0,0,'1927-03-04','Cécilia Gallant','Na','775-2800','210-0641','','B-1b','','0','0','0','2025-03-07','Décès',NULL,NULL,'Ns',NULL,'Ns',NULL,'Ns','Ns','Ns','Ns',NULL,NULL,NULL,NULL,NULL,'Ns',NULL,NULL,NULL,NULL,0,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(19,'Femme','Laudia','GALLANT',0,0,'1941-05-13','Francine Gallant','Epoux','506-700-3621','506-864-0400','506-576-7264','03-B','S5','1','0','1','2025-09-17','Décès',NULL,'2020-10-07','Ns',NULL,'Ns',NULL,'Ns','Ns','Ns','Ns',NULL,NULL,NULL,NULL,NULL,'Ns',NULL,NULL,NULL,NULL,0,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(20,'Femme','Alfreda','GAUDET',0,0,'1947-03-02','','','346-2100','','','B-4b','B11','0','0','0','2025-06-08','Décès',NULL,NULL,'Ns',NULL,'Ns',NULL,'Ns','Ns','Ns','Ns',NULL,NULL,NULL,NULL,NULL,'Ns',NULL,NULL,NULL,NULL,0,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(21,'Homme','Norman','GAUDET',1,1,'1934-06-21','Margaret Arseneault','Epoux','775-2734','','','02-B','','0','0','0',NULL,NULL,NULL,NULL,'Ns',NULL,'Ns',NULL,'Ns','Ns','Ns','Ns',NULL,NULL,NULL,NULL,NULL,'Ns',NULL,NULL,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(22,'Homme','Alphonse','GIONET',0,0,'1918-11-01','Barbara Gallant','fille','775-6894  ','626-2449','','','','0','0','0','2023-12-23','DECES',NULL,NULL,'Ns',NULL,'Ns',NULL,'Ns','Ns','Ns','Ns',NULL,NULL,NULL,NULL,NULL,'Ns',NULL,NULL,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(23,'Homme','Marie-thérèse','HACHEY',0,0,'1943-11-18','Marilyne hachey','fille','381-5292','','','B-7b','','0','0','1','2025-01-13','Décès',NULL,NULL,'Ns',NULL,'Ns',NULL,'Ns','Ns','Ns','Ns',NULL,NULL,NULL,NULL,NULL,'Ns',NULL,NULL,NULL,NULL,0,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(24,'Homme','Anise','HÉBERT',1,1,'1985-11-02','Denise Hébert','Epoux','775-2820','523-3246','','01-A','S9','0','1','0',NULL,NULL,NULL,NULL,'Ns',NULL,'Ns',NULL,'Ns','Ns','Ns','Ns',NULL,NULL,NULL,NULL,NULL,'Ns',NULL,NULL,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(25,'Homme','Frere leo','LEBLANC',1,1,'1927-01-18','pere innocent Ugyeh','Grands parents','424-1113','','','08-A','B14','0','0','0',NULL,NULL,NULL,'2020-01-01','Ns',NULL,'Ns',NULL,'Ns','Ns','Ns','Ns',NULL,NULL,NULL,NULL,NULL,'Ns',NULL,NULL,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(26,'Femme','Marielle','LIRETTE',1,1,'1947-10-31','Elda  Williston','Epoux','627-9564','','','01-A','','0','0','0',NULL,NULL,NULL,NULL,'Ns',NULL,'Ns',NULL,'Ns','Ns','Ns','Ns',NULL,NULL,NULL,NULL,NULL,'Ns',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(27,'Femme','Claudine','MAILLET',0,0,'1957-01-28','Yolande Robichaud','Na','775-6454','','','C-7b','','0','0','0',NULL,NULL,NULL,NULL,'Ns',NULL,'Ns',NULL,'Ns','Ns','Ns','Ns',NULL,NULL,NULL,NULL,NULL,'Ns',NULL,NULL,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(28,'Femme','Angela','MARTIN',1,1,'1940-04-05','Dianne Cormier','Epoux','380-0177','388-9061','','05-A','','0','0','0',NULL,NULL,NULL,NULL,'Ns',NULL,'Ns',NULL,'Ns','Ns','Ns','Ns',NULL,NULL,NULL,NULL,NULL,'Ns',NULL,NULL,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(29,'Homme','Eloi','MARTIN',0,0,'1940-04-07','Dianne Cormier','fille','380-0177','388-9061','','','','0','0','0',NULL,NULL,NULL,NULL,'Ns',NULL,'Ns',NULL,'Ns','Ns','Ns','Ns',NULL,NULL,NULL,NULL,NULL,'Ns',NULL,NULL,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(30,'Femme','Edna','MIOUSSE',0,0,'1932-02-26','Astride Miousse','Na','775-9339','210-1360','','A-8a','B24','1','0','1',NULL,NULL,NULL,NULL,'Ns',NULL,'Ns',NULL,'Ns','Ns','Ns','Ns',NULL,NULL,NULL,NULL,NULL,'Ns',NULL,NULL,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(31,'Homme','Marcel','MORAIS',0,0,'1945-04-18','Maria Pitre','sœur','775-2529','','','A-6b','','1','0','0','2024-06-07','DECES',NULL,NULL,'Ns',NULL,'Ns',NULL,'Ns','Ns','Ns','Ns',NULL,NULL,NULL,NULL,NULL,'Ns',NULL,NULL,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(32,'Homme','Albert','RICHARD',1,1,'1932-12-27','Jeannette Richard','Epoux','902-306-1047','','','03-B','B9','0','0','0',NULL,NULL,NULL,NULL,'Ns',NULL,'Ns',NULL,'Pain Blanc','Ns','Muffin','Ns',NULL,NULL,NULL,'poulet, poutine','Poisson','Ns',NULL,NULL,NULL,NULL,0,NULL,NULL,'Margarine','Custard','Autre','The,Cafe,Lait 1Oz','Cafe,Eau 8Oz','Cafe,Lait 8Oz',NULL,NULL),(33,'Homme','Alphonse','RICHARD',1,1,'1927-08-23','Diane Chiasson','Epoux','346-0935','','','03-A','','0','0','0',NULL,NULL,NULL,NULL,'Ns',NULL,'Ns',NULL,'Ns','Ns','Ns','Ns',NULL,NULL,NULL,NULL,NULL,'Ns',NULL,NULL,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(34,'Homme','André','RICHARD',1,1,'1980-09-24','Annette Richard','Epoux','775-2366','524-7223','','01-B','NA','0','0','0',NULL,NULL,NULL,NULL,'Ns',NULL,'Ns',NULL,'Ns','Ns','Ns','Ns',NULL,NULL,NULL,NULL,NULL,'Ns',NULL,NULL,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(35,'Homme','Arnold','RICHARD',0,0,'1940-09-19','Ronald McGraw','neveu','775-2374 ',' 210-2473','','B-2a','','0','0','1',NULL,NULL,NULL,NULL,'Ns',NULL,'Ns',NULL,'Ns','Ns','Ns','arnold_richard.jpg',NULL,NULL,NULL,NULL,NULL,'Ns',NULL,NULL,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(36,'Homme','Aurele','RICHARD',1,1,'1936-08-18','lorianne Richard','Fille','506-627-6566','506-627-6566','','07-A','','0','0','0',NULL,NULL,'Cafeteria',NULL,'Autonome',NULL,'Orange','Puree','Roti ble entier','Bouilli','Cereales chaudes','Ns',NULL,NULL,NULL,NULL,NULL,'2','Normale','Grand','Normale','Café',0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(37,'Femme','Dorothy','RICHARD',1,1,'1947-05-08','Jeannette Richard','Epoux','902-306-1047','','','03-A','B8','1','0','0',NULL,NULL,NULL,NULL,'Ns',NULL,'Ns',NULL,'Ns','Ns','Ns','Ns',NULL,NULL,NULL,NULL,NULL,'Ns',NULL,NULL,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(38,'Femme','Elda','RICHARD',0,0,'1941-05-05','Marie Richard','fille','251-2169','','','A-7b','','1','0','0','2025-03-11','Décès',NULL,NULL,'Ns',NULL,'Ns',NULL,'Ns','Ns','Ns','Ns',NULL,NULL,NULL,NULL,NULL,'Ns',NULL,NULL,NULL,NULL,0,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(39,'Homme','Ernest','RICHARD',1,1,'1940-05-05','Gerald Richard','Epoux','312-3354','531-5490','','09-B','B19','1','0','0',NULL,NULL,NULL,NULL,'Ns',NULL,'Ns',NULL,'Ns','Ns','Ns','Ns',NULL,NULL,NULL,NULL,NULL,'Ns',NULL,NULL,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(40,'Homme','Gérald','RICHARD',0,0,'1929-07-15','Anise Richard','Fille','506-521-1870','506-470-3335','506-775-2802','08-B','S8','0','0','1','2026-02-17','Décès',NULL,NULL,'Ns',NULL,'Ns',NULL,'Ns','Ns','Ns','Ns',NULL,NULL,NULL,NULL,NULL,'Ns',NULL,NULL,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(41,'Homme','John','RICHARD',0,0,'1951-05-03','Anita Noseworthy','Epoux','365-724-3077','','','04-B','','0','0','0','2025-09-17','Décès',NULL,NULL,'Ns',NULL,'Ns',NULL,'Ns','Ns','Ns','Ns',NULL,NULL,NULL,NULL,NULL,'Ns',NULL,NULL,NULL,NULL,0,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(42,'Homme','Marcel','RICHARD',0,0,'1940-04-18','Claudine Richard','Fille','506-251-0796','','','09-A','S3','0','0','1','2025-10-21','Décès',NULL,NULL,'Ns',NULL,'Ns',NULL,'Ns','Ns','Ns','Ns',NULL,NULL,NULL,NULL,NULL,'Ns',NULL,NULL,NULL,NULL,0,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(43,'Femme','Paula','RICHARD',1,1,'1961-01-04','Joanne Collette','Epoux','775-6121','625-0909','','05-A','S7','0','1','0',NULL,NULL,NULL,NULL,'Ns',NULL,'Ns',NULL,'Ns','Ns','Ns','Ns',NULL,NULL,NULL,NULL,NULL,'Ns',NULL,NULL,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(44,'Femme','Jeannette','RIGBY',0,0,'1948-09-28','Normande Arseneault','Na','626-2287','','','A-2b','','0','0','0','2025-02-03','Déménagement',NULL,NULL,'Ns',NULL,'Ns',NULL,'Ns','Ns','Ns','Ns',NULL,NULL,NULL,NULL,NULL,'Ns',NULL,NULL,NULL,NULL,0,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(45,'Femme','Aurore','ROY',1,1,'1931-03-11','Claudine Pineau','Epoux','775-6798','625-4763','','07-A','','1','0','0',NULL,NULL,NULL,NULL,'Ns',NULL,'Ns',NULL,'Ns','Ns','Ns','Ns',NULL,NULL,NULL,NULL,NULL,'Ns',NULL,NULL,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(46,'Femme','Thérèse','ROY',0,0,'1950-07-13','Ginette Roy','Epoux','251-0279','','','C-4b','','0','0','0',NULL,NULL,NULL,NULL,'Ns',NULL,'Ns',NULL,'Ns','Ns','Ns','Ns',NULL,NULL,NULL,NULL,NULL,'Ns',NULL,NULL,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(47,'Homme','Denis','THEBEAU',1,0,'1974-02-13','Diane Babin','Epouse','506-625-2824','','','01-A','NA','0','0','0',NULL,NULL,NULL,NULL,'Ns',NULL,'Ns',NULL,'Ns','Ns','Ns','Ns',NULL,NULL,NULL,NULL,NULL,'Ns',NULL,NULL,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(48,'Femme','Maria','THEBEAU',1,1,'1926-11-19','Hélèna Thebeau','Fille','775-6409','625-6409','','05-A','','0','0','0',NULL,NULL,NULL,NULL,'Ns',NULL,'Ns',NULL,'Ns','Ns','Ns','Ns',NULL,NULL,NULL,NULL,NULL,'Ns',NULL,NULL,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(49,'Femme','Rose','THÉBEAU',1,1,'1987-09-21','Lilliane Thébeau','Mère','210-2116','','','07-B','S6','0','0','1',NULL,NULL,NULL,NULL,'Ns',NULL,'Ns',NULL,'Ns','Ns','Ns','Ns',NULL,NULL,NULL,NULL,NULL,'Ns',NULL,NULL,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(50,'Femme','Lynda','VAN DE KRAATS',1,1,'1946-07-05','Christy Gauvin','Epoux','346-0333','210-2404','','08-B','B20','0','1','0',NULL,NULL,NULL,NULL,'Ns',NULL,'Ns',NULL,'Ns','Ns','Ns','Ns',NULL,NULL,NULL,NULL,NULL,'Ns',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(51,'Femme','Geraldine','POIRIER',0,0,'1955-05-08','Yolande Poirier','Na','573-3508','775-0899',NULL,'C-7b','B5','0','1','0',NULL,NULL,NULL,NULL,'Ns',NULL,'Ns',NULL,'Ns','Ns','Ns','Ns',NULL,NULL,NULL,NULL,NULL,'Ns',NULL,NULL,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(52,'Homme','Eloi','MORAIS',0,0,'1946-06-21','Sylvio Carter','Na','384-0905','261-0285',NULL,'A-6a',NULL,'0','0','0','2025-08-08','Décès',NULL,NULL,'Ns',NULL,'Ns',NULL,'Ns','Ns','Ns','Ns',NULL,NULL,NULL,NULL,NULL,'Ns',NULL,NULL,NULL,NULL,0,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(53,'Femme','Anne marie','ARSENEAULT',1,1,'1944-08-25','liette Arsenault','Epoux','210-1418','','','07-B',NULL,'0','0','0',NULL,NULL,NULL,'2020-01-01','Ns',NULL,'Ns',NULL,'Ns','Ns','Ns','Ns',NULL,NULL,NULL,NULL,NULL,'Ns',NULL,NULL,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(54,'Femme','Alice','ROACH',1,1,'1941-04-08','yvon','Fils','905-717-1589','251-8014','','06-B',NULL,'0','0','1',NULL,NULL,NULL,NULL,'Ns',NULL,'Ns',NULL,'Ns','Ns','Ns','Ns',NULL,NULL,NULL,NULL,NULL,'Ns',NULL,NULL,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(59,'Femme','Lina','GOGUEN',1,1,'1938-12-30','Andre Lavoie','Epoux','902-488-8055','','','06-A',NULL,'0','0','0',NULL,NULL,NULL,NULL,'Ns',NULL,'Ns',NULL,'Ns','Ns','Ns','Ns',NULL,NULL,NULL,NULL,NULL,'Ns',NULL,NULL,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(57,'Homme','Martin','DOIRON',0,0,'1947-11-13','Francelyne Bourque','Nd','233-9885','','','A-4a',NULL,'0','0','0','2025-04-15','Décès','','2024-03-13','','no','','','','','','Ns','no','no','no','no','','','','',NULL,NULL,0,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(58,'Femme','Marie dorice','POIRIER',0,0,'1940-01-23','Jacques Poirier','Autre','775-2752','','','C-7b',NULL,'0','0','0',NULL,NULL,'Cafeteria','2024-04-03','Autonome','','Orange','Purée','Blanc','Omelette','CreamWheat,Gruau','Ns','','poulet','sandwich ','patate,llegume','putine,rapee','IDDSI1','Normal','Moyen',NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(60,'Femme','Stella','HACHE',0,0,'1941-04-22','Daniel haché','Autre','866-2466','','',NULL,NULL,'1','1','0','2025-08-02','Décès',NULL,'2024-05-01','FEEDING','MENTHOL','CRAMBERRIES','PUREE','WHITE','NO EGGS','NO CEREAL','Ns',NULL,'POUTINE, RAPEE','SOUP','DIET SUGAR',NULL,'Ns',NULL,'SMALL','NORMAL',NULL,0,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(61,'Femme','Rosa','VAUTOUR',1,1,'1941-01-16','Norman Vautour','Epoux','775-6917','626-2232','',NULL,NULL,'0','0','0',NULL,NULL,'','2024-05-08','','','','','WHITE','FRIED,SCRAMBLE','CREAM OF WHEAT, FLAKES','Ns','','','','','','','','MEDIUM','','Tea',0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(62,'Homme','Fernand','HACHEY',1,1,'1947-10-08','Dianne Hachey','Epoux','251-0235','','','06-B',NULL,'0','0','1',NULL,NULL,'Chambre','2024-06-12','Autonome','','Tomate','Jus','Ns','Omelette','CREAM OF WHEAT, FLAKES','Ns','','rapure','','','soupe, laitue','Ns','Grinded','Moyen','Normal','Cafe',2,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(63,'Femme','Rachel','LEBLANC',1,1,'1956-01-20','Francis Leblanc','Epoux','506-334-4085','506-875-0494','','08-A',NULL,'0','0','0',NULL,NULL,NULL,NULL,'Ns',NULL,'Ns',NULL,'Ns','Ns','Ns','Ns',NULL,NULL,NULL,NULL,NULL,'Ns',NULL,NULL,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(64,'Femme','Linda','CHAVARIE',0,0,'1961-08-05','Paul chavarie','Frere','905-706-0746','','',NULL,NULL,'0','0','0',NULL,NULL,'Activite','2024-10-03','Autonome','','Nd','Jus','Whole','Poached','Gruau','Ns','','meat','soup, sandwich','hamburger , fish','fish','Nd','Normal','Moyen','Normal','Nd',0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(65,'Homme','Guillaume','ARSENEAU',1,1,'1931-11-11','lucile arsenault','Fille','775-6653','627-9987','','02-B',NULL,'1','0','0',NULL,NULL,'Cafeteria','2024-10-17','Autonome','','Orange','Jus','Roti ble entier','Omelette','Cereales chaudes','Ns','','rapee, poulet','','poisson- petits pois','pates','Nd','Hachée','Petit','','',0,NULL,NULL,'Confiture','Oeuf','Fraise','The','The','The',NULL,NULL),(66,'Femme','Alma','ARSENEAU',1,1,'1937-03-09','lucile arsenault','Fille','775-6653','627-9987','','02-A',NULL,'0','0','0',NULL,NULL,NULL,'2024-10-24','Autonome',NULL,'Ns',NULL,'Ns','Ns','Ns','Ns',NULL,NULL,NULL,NULL,NULL,'Ns',NULL,NULL,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(67,'Homme','Leandre','DOIRON',1,1,'1943-07-16','stella','Epouse','775-6795','626-1640','','08-A',NULL,'0','0','0',NULL,NULL,NULL,'2024-12-04','Ns',NULL,'Ns',NULL,'Ns','Ns','Ns','Ns',NULL,NULL,NULL,NULL,NULL,'Ns',NULL,NULL,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(68,'Femme','Florine','MAZEROLLE',1,1,'1940-01-28','1/ Irene 2/ jean guy','Fille','506-800-9101','251-1237','','06-A',NULL,'0','0','0',NULL,NULL,NULL,'2004-12-05','Ns',NULL,'Ns',NULL,'Ns','Ns','Ns','Ns',NULL,NULL,NULL,NULL,NULL,'Ns',NULL,NULL,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(69,'Femme','Eva','BOISVERT',1,1,'1933-10-06','Jeanne Doiron','Grands parents','506-626-3250','','','02-B',NULL,'0','0','0',NULL,NULL,NULL,'2024-12-18','Ns',NULL,'Ns',NULL,'Ns','Ns','Ns','Ns',NULL,NULL,NULL,NULL,NULL,'Ns',NULL,NULL,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(70,'Homme','Jacques','RICHARD',1,1,'1956-01-27','Brian Geneau ou Cecile Richard','Sœur','506-210-3143','506-775-6987','506-623-8806','',NULL,'0','0','0',NULL,NULL,NULL,'2024-05-01','Ns',NULL,'Ns',NULL,'Ns','Ns','Ns','Ns',NULL,NULL,NULL,NULL,NULL,'Ns',NULL,NULL,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(71,'Femme','Lorette','MARTIN',1,1,'1933-06-20','Jacques Martin','Fils','506-625-0646','','',NULL,NULL,'0','0','0',NULL,NULL,NULL,'2025-01-08','Ns',NULL,'Ns',NULL,'Ns','Ns','Ns','Ns',NULL,NULL,NULL,NULL,NULL,'Ns',NULL,NULL,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(72,'Femme','Alice','ROY',1,1,'1940-09-26','Nicole Roy','Fille','506-251-8500','','',NULL,NULL,'0','0','0',NULL,NULL,NULL,'2025-03-14','Feeding','Fraise','Ns',NULL,'Pain Blanc','Ns','Muffin','Ns',NULL,NULL,NULL,'poulet, poutine','POISSON','Ns',NULL,NULL,NULL,NULL,0,NULL,NULL,'Margarine','Oeuf','Autre','The','The,Cafe,Lait 1Oz,Lait 8Oz,Eau','Cafe,Lait 8Oz,Eau',NULL,'Sans sucrex'),(73,'Homme','Euclide','BOURQUE',1,1,'1951-04-03','Nicole Roy','Fille','506-251-8500','','',NULL,NULL,'0','0','0',NULL,NULL,NULL,'2020-01-01','Ns',NULL,'Ns',NULL,'Ns','Ns','Ns','Ns',NULL,NULL,NULL,NULL,NULL,'Ns',NULL,NULL,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(74,'Femme','Yvonne','MILLETTE',1,1,'1937-08-11','Nicole Haché ','Fille','506-624-9360','','','A-3a',NULL,'0','0','0',NULL,NULL,'Cafeteria','2025-04-23','Autonome','','Pommes','Jus','Roti pain blanc','Fricassée','Cereales froides','Ns','0','','','poulet-poisson','poutine et rapee','0','Normale','Petit','Normale','The',0,NULL,'','Confiture','Oeuf','Fraise','The','The','The','banane',NULL),(76,'Homme','Elzear','THEBEAU',1,1,'1931-12-07','Josianne Thebeau','Fille','506-521-4779','','',NULL,NULL,'0','0','0',NULL,NULL,'Cafeteria','2025-05-26','Autonome',NULL,'Autres','Puree','Roti pain blanc','Brouillé','Cereales chaudes','Ns',NULL,NULL,NULL,NULL,NULL,'0','Normale','Grand','Normale',NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(77,'Femme','Carole','CAISSIE',1,1,'1975-04-06','murielle isaac','Sœur','','506-625-0996','','B-4b',NULL,'0','0','0',NULL,NULL,'Cafeteria','2025-06-11','Autonome','','Orange','Jus','Pain Blanc','Bouilli','Cereales froides','Ns','0','','','poulet, repas chinois','','0','Normale','Petit','Normale',NULL,0,NULL,'','Margarine','Oeuf','Fraise','Cafe','Cafe','Cafe','',NULL),(78,'Femme','Odette','DOIRON',1,1,'1963-01-19','Conrad DOIRON','Epoux','506-251-5600','','',NULL,NULL,'0','0','0',NULL,NULL,NULL,'2025-08-08','Ns',NULL,'Ns',NULL,'Roti ble entier','Ns','Cereales chaudes','Ns',NULL,NULL,NULL,'Imes tout','Aucun','Ns',NULL,NULL,NULL,NULL,0,NULL,NULL,'Confiture','Oeuf','Fraise','','','',NULL,NULL),(79,'Homme','Georges','RICHARD',1,1,'1939-06-14','Mario Le Blanc','Fille','506-775-0189','807-737-1278','','08-B',NULL,'0','0','0',NULL,NULL,NULL,'2025-08-15','Ns',NULL,'Ns',NULL,'Roti ble entier','Ns','Cereales chaudes','Ns',NULL,NULL,NULL,'','','Ns',NULL,NULL,NULL,NULL,0,NULL,NULL,'Confiture','Oeuf','Fraise','The, Lait 1Oz, Lait 8Oz, Eau, Eau 8Oz','The, Lait 1Oz, Lait 8Oz, Eau, Jus 4Oz','The, Lait 1Oz, Lait 8Oz, Eau',NULL,NULL),(80,'Femme','Barbara','HOWARTH',1,1,'1936-04-24','Sandra Webb','Fille','519-802-9599','','','',NULL,'0','0','0','2025-12-23',NULL,'Cafeteria','2025-08-13','Autonome',NULL,'Canneberge','Jus','Roti pain blanc','Omelette','Muffin','Ns',NULL,NULL,NULL,NULL,NULL,'0','Normale','Petit','Normale',NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(81,'Femme','Anne-marie','CHIASSON',1,1,'1940-11-02','Gino Chiasson','Fils','506-626-2957','','','',NULL,'0','0','0',NULL,NULL,NULL,'2025-10-02','Ns',NULL,'Ns',NULL,'Ns','Ns','Ns','Ns',NULL,NULL,NULL,NULL,NULL,'Ns',NULL,NULL,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(82,'Homme','Jean-louis','BOUCHER',1,1,'1954-08-03','Nathalie Doiron','Epoux','506-625-9015','','','',NULL,'0','0','0',NULL,NULL,'Chambre','2025-10-07','Feeding',NULL,'Pommes','Jus','Roti ble entier','Omelette','Cereales chaudes','Ns',NULL,NULL,NULL,'Poisson - petits pois','Haricots verts','0','Normale','Moyen','Normale','Thé',0,NULL,NULL,'Beurre d arachide','Oeuf','Autre','The','The','The',NULL,NULL),(83,'Femme','Therese','BOURQUE',1,1,'1936-12-17','Jimmy Bourque','Fils','506-627-6390','','','',NULL,'0','0','0',NULL,'',NULL,'2025-09-23','Ns',NULL,'Ns',NULL,'Ns','Ns','Ns','Ns',NULL,NULL,NULL,NULL,NULL,'Ns',NULL,NULL,NULL,NULL,0,'deces',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(84,'Femme','Marie','ARSENAULT',1,1,'1934-07-01','Marguerite Arseneault','Sœur','506-775-9362','506-775-2304','','',NULL,'0','0','0',NULL,NULL,NULL,'2025-10-24','Ns',NULL,'Ns',NULL,'Ns','Ns','Ns','Ns',NULL,NULL,NULL,NULL,NULL,'Ns',NULL,NULL,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(85,'Femme','Anita','CAISSIE RICHARD',0,0,'1937-01-14','Janice Richard','Fille','506-625-5481',NULL,NULL,NULL,NULL,'0','0','0','2025-12-01','Décès',NULL,'2025-11-10','Ns',NULL,'Ns',NULL,'Ns','Ns','Ns','Ns',NULL,NULL,NULL,NULL,NULL,'Ns',NULL,NULL,NULL,NULL,0,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(86,'Femme','Yvonne','RICHARD',1,1,'1935-05-17','Carmel Gaudet HERBERT','Niece','506-775-6010','506-625-1843','','',NULL,'0','0','0',NULL,NULL,NULL,'2025-12-09','Ns',NULL,'Ns',NULL,'Ns','Ns','Ns','Ns',NULL,NULL,NULL,NULL,NULL,'Ns',NULL,NULL,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(-1,'Homme','Test','TEST',1,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'0','0','0',NULL,NULL,NULL,NULL,'Ns',NULL,'Ns',NULL,'Ns','Ns','Ns','Ns',NULL,NULL,NULL,NULL,NULL,'Ns',NULL,NULL,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(87,'Femme','Fernande','Richard-MacLeod',1,1,'1956-04-20','RONALD MCLEOD','Epoux','506-850-3119',NULL,NULL,NULL,NULL,'0','0','0',NULL,NULL,NULL,'2026-01-07','Ns',NULL,'Ns',NULL,'Ns','Ns','Ns','Ns',NULL,NULL,NULL,NULL,NULL,'Ns',NULL,NULL,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(88,'Femme','Yolande','GAUTREAU',1,1,'1950-01-11','Natalie Menard','Fille','902-790-4359','','','',NULL,'0','0','0',NULL,NULL,NULL,'2026-01-12','Ns',NULL,'Ns',NULL,'Ns','Ns','Ns','Ns',NULL,NULL,NULL,NULL,NULL,'Ns',NULL,NULL,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(89,'Homme','Yvon','SAVOIE',1,1,'1944-08-18','Adele','Epouse','506-228-1900','506-251-2411','','B1',NULL,'Non','0','0',NULL,NULL,'Cafeteria','2026-02-20','Autonome',NULL,'Orange','Jus','Roti ble entier','Ns','Cereales froides','Ns',NULL,NULL,NULL,'Poulet','Belonie','0','Normale','Petit','Normale',NULL,0,NULL,NULL,NULL,'Bacon','Fraise','Cafe,Lait 1Oz','Cafe,Lait 1Oz','Cafe,Lait 1Oz',NULL,'');
/*!40000 ALTER TABLE `resident_tbl` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `season_start_week`
--

DROP TABLE IF EXISTS `season_start_week`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `season_start_week` (
  `id` int NOT NULL AUTO_INCREMENT,
  `annee` int DEFAULT NULL,
  `saison` varchar(45) DEFAULT NULL,
  `week` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_season_year` (`annee`,`saison`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `season_start_week`
--

LOCK TABLES `season_start_week` WRITE;
/*!40000 ALTER TABLE `season_start_week` DISABLE KEYS */;
INSERT INTO `season_start_week` VALUES (1,2026,'Winter',1),(2,2026,'Spring',1),(11,2026,'Summer',1),(12,2026,'Fall',1);
/*!40000 ALTER TABLE `season_start_week` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `seek_tbl`
--

DROP TABLE IF EXISTS `seek_tbl`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `seek_tbl` (
  `Id` int NOT NULL AUTO_INCREMENT,
  `IdStaff` int DEFAULT '0',
  `Heure` decimal(6,0) DEFAULT '0',
  `Date` date DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `seek_tbl`
--

LOCK TABLES `seek_tbl` WRITE;
/*!40000 ALTER TABLE `seek_tbl` DISABLE KEYS */;
/*!40000 ALTER TABLE `seek_tbl` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `staff_tbl`
--

DROP TABLE IF EXISTS `staff_tbl`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `staff_tbl` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(45) DEFAULT NULL,
  `prenom` varchar(45) DEFAULT NULL,
  `service` varchar(45) DEFAULT NULL,
  `departement` varchar(45) DEFAULT NULL,
  `poste` varchar(45) DEFAULT NULL,
  `status` varchar(45) DEFAULT NULL,
  `enabled` int DEFAULT '0',
  `gender` varchar(45) DEFAULT NULL,
  `middle_name` varchar(45) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `tel1` varchar(45) DEFAULT NULL,
  `tel2` varchar(45) DEFAULT NULL,
  `adresse_l1` varchar(45) DEFAULT NULL,
  `adresse_l2` varchar(45) DEFAULT NULL,
  `code_postal` varchar(45) DEFAULT NULL,
  `ville` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `staff_tbl`
--

LOCK TABLES `staff_tbl` WRITE;
/*!40000 ALTER TABLE `staff_tbl` DISABLE KEYS */;
INSERT INTO `staff_tbl` VALUES (1,'Martin','Stephanie','Service alimentaire et Menage','Laundry','MAID','FT',1,'Femme','',NULL,'506-626-4776','','','','E4Y 1S5','Rogersville');
/*!40000 ALTER TABLE `staff_tbl` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `start_year`
--

DROP TABLE IF EXISTS `start_year`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `start_year` (
  `year` varchar(4) NOT NULL,
  `start_date` date NOT NULL,
  PRIMARY KEY (`year`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `start_year`
--

LOCK TABLES `start_year` WRITE;
/*!40000 ALTER TABLE `start_year` DISABLE KEYS */;
INSERT INTO `start_year` VALUES ('2026','2025-11-30');
/*!40000 ALTER TABLE `start_year` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `startweek`
--

DROP TABLE IF EXISTS `startweek`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `startweek` (
  `id` int NOT NULL AUTO_INCREMENT,
  `annee` int DEFAULT NULL,
  `week` int DEFAULT NULL,
  `date_start` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `startweek`
--

LOCK TABLES `startweek` WRITE;
/*!40000 ALTER TABLE `startweek` DISABLE KEYS */;
INSERT INTO `startweek` VALUES (1,2026,2,'2026-01-04'),(2,2025,1,'2025-01-05');
/*!40000 ALTER TABLE `startweek` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `Id` int NOT NULL AUTO_INCREMENT,
  `Login` longtext NOT NULL,
  `Email` longtext NOT NULL,
  `password` varchar(96) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'hery','die.fa@nb.aibn.com','$2y$10$o1MzXf5znJ4MCOPjXJBokOMTuUC4uMGTuvUs0sdQPg4XNZoW6pYTS');
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

-- Dump completed on 2026-03-10 17:15:02
