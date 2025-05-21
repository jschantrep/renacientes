-- MySQL dump 10.13  Distrib 8.0.42, for Win64 (x86_64)
--
-- Host: localhost    Database: renacer
-- ------------------------------------------------------
-- Server version	8.0.42

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
-- Table structure for table `datos_basicos`
--

DROP TABLE IF EXISTS `datos_basicos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `datos_basicos` (
  `idDatos_Basicos` int NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(45) NOT NULL,
  `Documento` bigint NOT NULL,
  `Direccion` varchar(45) NOT NULL,
  `email` varchar(35) NOT NULL,
  `tel` bigint NOT NULL,
  `password` varchar(45) NOT NULL,
  `rol` enum('admin','usuario') DEFAULT 'usuario',
  PRIMARY KEY (`idDatos_Basicos`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `datos_basicos`
--

LOCK TABLES `datos_basicos` WRITE;
/*!40000 ALTER TABLE `datos_basicos` DISABLE KEYS */;
INSERT INTO `datos_basicos` VALUES (1,'jonatan chantre',123456,'cra 2165','jonatan.chantre@innovasoftcol.com',12315,'1234','usuario'),(2,'yurley molina',100015645,'cra 17 sc # 41586 sur','ymolina@gmail.com',310321561,'81dc9bdb52d04dc20036dbd8313ed055','admin'),(3,'david clavijo',215656,'safa456','juanda@gmail.com',123456,'123456','usuario'),(4,'Yurley Molina',1209869583,'Cra 62 # 2c','molinayurley72@gmail.com',31422,'e10adc3949ba59abbe56e057f20f883e','usuario'),(5,'Yurley Molina',1209869583,'no','admin@gmail.com',314,'e10adc3949ba59abbe56e057f20f883e','usuario'),(6,'santiago',12345,'cl 12 sur','lujo@gmail.com',321456789,'0bb9e2687b1eed23096afe2670d26282','usuario'),(7,'JONATAN SMITH CHANTRE',100123124,'124BJJ','jonatansm@gmail.com',124124,'81dc9bdb52d04dc20036dbd8313ed055','usuario');
/*!40000 ALTER TABLE `datos_basicos` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-05-20 20:45:34
