-- MySQL dump 10.13  Distrib 8.0.29, for Linux (x86_64)
--
-- Host: localhost    Database: bank
-- ------------------------------------------------------
-- Server version	8.0.29-0ubuntu0.20.04.3

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `balance`
--

DROP TABLE IF EXISTS `balance`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `balance` (
  `account_no` bigint NOT NULL,
  `balance` int DEFAULT NULL,
  `online_limit` int DEFAULT NULL,
  `card_limit` int DEFAULT NULL,
  `upi_limit` int DEFAULT NULL,
  `online_no` int DEFAULT NULL,
  `card_no` int DEFAULT NULL,
  `upi_no` int DEFAULT NULL,
  PRIMARY KEY (`account_no`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `balance`
--

LOCK TABLES `balance` WRITE;
/*!40000 ALTER TABLE `balance` DISABLE KEYS */;
INSERT INTO `balance` VALUES (7133517839,1000,NULL,NULL,NULL,NULL,NULL,NULL),(8955108227,1000,NULL,NULL,NULL,NULL,NULL,NULL),(9151070187,1000,NULL,NULL,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `balance` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `login`
--

DROP TABLE IF EXISTS `login`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `login` (
  `id` varchar(30) NOT NULL,
  `pwd` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `account_no` bigint NOT NULL,
  PRIMARY KEY (`account_no`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `login`
--

LOCK TABLES `login` WRITE;
/*!40000 ALTER TABLE `login` DISABLE KEYS */;
INSERT INTO `login` VALUES ('u@gmail.com','Oa0RgJ3Dy7hXitPGqp/HqYVDU9M98NWKOhgm5StZ+ucLDYGL1jDaf0sHSLpxeLrG',7133517839),('q@gmail.com','ARpgQPyeRHxky8/vl5/A8jpOIy/Wu47B5p0nWnaIv58hJfWQtItWdvmTCh7forLM',9151070187);
/*!40000 ALTER TABLE `login` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `register`
--

DROP TABLE IF EXISTS `register`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `register` (
  `account_no` bigint NOT NULL,
  `firstname` varchar(15) NOT NULL,
  `lastname` varchar(15) NOT NULL,
  `email` varchar(30) NOT NULL,
  `phone` bigint NOT NULL,
  `acc_type` varchar(20) NOT NULL,
  `birthday` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `person_id` bigint NOT NULL,
  `gender` varchar(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `address` varchar(250) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `district` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `city` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `country` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `nationality` varchar(20) NOT NULL,
  PRIMARY KEY (`account_no`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `register`
--

LOCK TABLES `register` WRITE;
/*!40000 ALTER TABLE `register` DISABLE KEYS */;
INSERT INTO `register` VALUES (7133517839,'u','u','u@gmail.com',3333333333,'saving','2004-12-17',444444444444,'male','1','u','u','u','u'),(8955108227,'ha','ha','testuitbank@gmail.com',987654321,'saving','2004-12-11',222222222222,'male','321,xyz,p.15','tb','hcm','vn','vn'),(9151070187,'q','q','q@gmail.com',1111111111,'saving','2004-12-12',222222222222,'male','12,qq','q','q','q','q');
/*!40000 ALTER TABLE `register` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-05-21 18:32:33
