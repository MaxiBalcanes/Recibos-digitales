-- MySQL dump 10.13  Distrib 8.0.38, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: recibos_sueldo
-- ------------------------------------------------------
-- Server version	5.5.5-10.4.32-MariaDB

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
-- Table structure for table `pdf_files`
--

DROP TABLE IF EXISTS `pdf_files`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pdf_files` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `ruta` varchar(255) NOT NULL,
  `uploaded_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `legajo` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pdf_files`
--

LOCK TABLES `pdf_files` WRITE;
/*!40000 ALTER TABLE `pdf_files` DISABLE KEYS */;
INSERT INTO `pdf_files` VALUES (1,'Boleta_0212767_2024-012.pdf','../uploads/Boleta_0212767_2024-012.pdf','2024-12-19 15:29:48','111111'),(2,'101010-mayo.pdf','../uploads/101010-mayo.pdf','2024-12-19 15:37:11','111111'),(3,'111111-ESET Business Account.pdf','../uploads/Administración de usuarios _ ESET Business Account.pdf','2024-12-19 15:42:50','107759'),(4,'107759 - Administración de usuarios _ ESET Business Account.pdf','../uploads/107759 - Administración de usuarios _ ESET Business Account.pdf','2024-12-23 12:06:14',''),(41,'107759 - Diciembre.pdf','../uploads/107759 - Diciembre.pdf','2024-12-23 12:30:18',''),(42,'111111-Diciembre.pdf','../uploads/111111-Diciembre.pdf','2024-12-23 12:30:18','');
/*!40000 ALTER TABLE `pdf_files` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `legajo` varchar(10) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','member') DEFAULT 'member',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `legajo` (`legajo`),
  UNIQUE KEY `correo` (`correo`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'107759','Maxi','maxi@ejemplo.com','$2y$10$W7oPARTlMmQdUQLE0G55guczoqbOb6pZKUwUPq0JWjt2tMlRrUYe2','member','2024-12-19 14:59:51'),(5,'101010','admin','admin@ejemplo.com','$2y$10$2DtBC.hVWqOhhCnsL2JLju3BqnR3JE3NkZsG3NXc7FKGz9YuPfkq.','admin','2024-12-19 15:28:27'),(6,'111111','Gabriel Mendoza','gabriel@prueba.com','$2y$10$hySC1fsseuYx0h0rf7ws9.tXPcGQBmgP8oe0HYLsDtzYkyukrW9TO','member','2024-12-19 15:31:23');
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

-- Dump completed on 2024-12-23 13:45:49
