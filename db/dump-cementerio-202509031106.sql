-- MySQL dump 10.13  Distrib 9.3.0, for Win64 (x86_64)
--
-- Host: localhost    Database: cementerio
-- ------------------------------------------------------
-- Server version	9.3.0

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
-- Table structure for table `deudo`
--

DROP TABLE IF EXISTS `deudo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `deudo` (
  `id_deudo` int NOT NULL AUTO_INCREMENT,
  `dni` int DEFAULT NULL,
  `nombre` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  `apellido` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  `telefono` bigint DEFAULT NULL,
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  `domicilio` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  `localidad` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  `codigo_postal` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  PRIMARY KEY (`id_deudo`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `deudo`
--

LOCK TABLES `deudo` WRITE;
/*!40000 ALTER TABLE `deudo` DISABLE KEYS */;
INSERT INTO `deudo` VALUES (1,30123456,'Roberto','González',3516123456,'roberto.gonzalez@email.com','Av. Siempre Viva 742','Springfield','1234'),(2,31234567,'Ana María','López',3516234567,'ana.lopez@email.com','Calle Falsa 123','Springfield','1234'),(3,32345678,'Carlos','Pérez',3516345678,'carlos.perez@email.com','Av. Libertador 456','Córdoba','5000'),(4,33456789,'Laura','Martínez',3516456789,'laura.martinez@email.com','Belgrano 789','Córdoba','5000'),(5,34567890,'Miguel','Rodríguez',3516567890,'miguel.rodriguez@email.com','Sarmiento 321','Rosario','2000'),(6,35678901,'Sofía','García',3416678901,'sofia.garcia@email.com','Mitre 654','Rosario','2000'),(7,36789012,'José','Fernández',2616789012,'jose.fernandez@email.com','San Martín 987','Mendoza','5500'),(8,37890123,'Elena','Díaz',2616890123,'elena.diaz@email.com','Av. Colón 159','Mendoza','5500'),(9,38901234,'Francisco','Sánchez',1155901234,'francisco.sanchez@email.com','Rivadavia 753','Buenos Aires','1001'),(10,40012345,'Carmen','Romero',1155012345,'carmen.romero@email.com','Corrientes 852','Buenos Aires','1001'),(11,41123456,'Pedro','Álvarez',2216123456,'pedro.alvarez@email.com','Uruguay 963','La Plata','1900'),(12,42234567,'Isabel','Torres',2216234567,'isabel.torres@email.com','7 y 50 147','La Plata','1900'),(13,43345678,'Antonio','Ortiz',3426345678,'antonio.ortiz@email.com','Av. Circunvalación 258','Santa Fe','3000'),(14,44456789,'María','Navarro',3426456789,'maria.navarro@email.com','25 de Mayo 369','Santa Fe','3000'),(15,45567890,'Juan Carlos','Méndez',3816567890,'juanc.mendez@email.com','Independencia 741','Tucumán','4000');
/*!40000 ALTER TABLE `deudo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `difunto`
--

DROP TABLE IF EXISTS `difunto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `difunto` (
  `id_difunto` int NOT NULL AUTO_INCREMENT,
  `id_deudo` int NOT NULL,
  `nombre` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  `apellido` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  `dni` int NOT NULL,
  `edad` int DEFAULT NULL,
  `fecha_fallecimiento` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `id_sexo` int DEFAULT NULL,
  `id_nacionalidad` int DEFAULT NULL,
  `id_estado_civil` int DEFAULT NULL,
  `domicilio` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  `localidad` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  `codigo_postal` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  PRIMARY KEY (`id_difunto`),
  KEY `difunto_FK` (`id_deudo`),
  KEY `difunto_FK_1` (`id_sexo`),
  KEY `difunto_FK_2` (`id_estado_civil`),
  KEY `difunto_FK_3` (`id_nacionalidad`),
  CONSTRAINT `difunto_FK` FOREIGN KEY (`id_deudo`) REFERENCES `deudo` (`id_deudo`),
  CONSTRAINT `difunto_FK_1` FOREIGN KEY (`id_sexo`) REFERENCES `sexo` (`id_sexo`),
  CONSTRAINT `difunto_FK_2` FOREIGN KEY (`id_estado_civil`) REFERENCES `estado_civil` (`id_estado_civil`),
  CONSTRAINT `difunto_FK_3` FOREIGN KEY (`id_nacionalidad`) REFERENCES `nacionalidades` (`id_nacionalidad`)
) ENGINE=InnoDB AUTO_INCREMENT=91 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `difunto`
--

LOCK TABLES `difunto` WRITE;
/*!40000 ALTER TABLE `difunto` DISABLE KEYS */;
INSERT INTO `difunto` VALUES (1,1,'Carlos','González',12345678,75,'2023-01-15 13:30:00',1,1,3,'Av. Siempre Viva 742','Springfield','1234'),(2,2,'María','López',23456789,68,'2023-02-20 17:45:00',2,1,4,'Calle Falsa 123','Springfield','1234'),(3,3,'Juan','Pérez',34567890,82,'2023-03-10 12:15:00',1,1,1,'Av. Libertador 456','Córdoba','5000'),(4,4,'Ana','Martínez',45678901,59,'2023-04-05 19:20:00',2,1,2,'Belgrano 789','Córdoba','5000'),(5,5,'Roberto','Rodríguez',56789012,71,'2023-05-12 14:00:00',1,1,3,'Sarmiento 321','Rosario','2000'),(6,6,'Laura','García',67890123,63,'2023-06-18 11:45:00',2,2,4,'Mitre 654','Rosario','2000'),(7,7,'José','Fernández',78901234,77,'2023-07-22 16:30:00',1,1,1,'San Martín 987','Mendoza','5500'),(8,8,'Sofía','Díaz',89012345,65,'2023-08-30 18:10:00',2,3,2,'Av. Colón 159','Mendoza','5500'),(9,9,'Miguel','Sánchez',90123456,80,'2023-09-05 15:00:00',1,1,3,'Rivadavia 753','Buenos Aires','1001'),(10,10,'Elena','Romero',11223344,69,'2023-10-14 20:25:00',2,4,4,'Corrientes 852','Buenos Aires','1001'),(11,11,'Pedro','Álvarez',22334455,72,'2023-11-20 13:40:00',1,1,1,'Uruguay 963','La Plata','1900'),(12,12,'Carmen','Torres',33445566,66,'2023-12-03 17:15:00',2,1,2,'7 y 50 147','La Plata','1900'),(13,13,'Francisco','Ortiz',44556677,74,'2024-01-08 12:50:00',1,5,3,'Av. Circunvalación 258','Santa Fe','3000'),(14,14,'Isabel','Navarro',55667788,61,'2024-02-14 19:05:00',2,1,4,'25 de Mayo 369','Santa Fe','3000'),(15,15,'Antonio','Méndez',66778899,79,'2024-03-25 14:20:00',1,1,1,'Independencia 741','Tucumán','4000');
/*!40000 ALTER TABLE `difunto` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `estado_civil`
--

DROP TABLE IF EXISTS `estado_civil`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `estado_civil` (
  `id_estado_civil` int NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci NOT NULL,
  PRIMARY KEY (`id_estado_civil`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `estado_civil`
--

LOCK TABLES `estado_civil` WRITE;
/*!40000 ALTER TABLE `estado_civil` DISABLE KEYS */;
INSERT INTO `estado_civil` VALUES (1,'Soltero'),(2,'Casado'),(3,'Viudo'),(4,'Divorciado');
/*!40000 ALTER TABLE `estado_civil` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nacionalidades`
--

DROP TABLE IF EXISTS `nacionalidades`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `nacionalidades` (
  `id_nacionalidad` int NOT NULL AUTO_INCREMENT,
  `nacionalidad` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci NOT NULL,
  PRIMARY KEY (`id_nacionalidad`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nacionalidades`
--

LOCK TABLES `nacionalidades` WRITE;
/*!40000 ALTER TABLE `nacionalidades` DISABLE KEYS */;
INSERT INTO `nacionalidades` VALUES (1,'CHILE'),(2,'ARGENTINA'),(3,'PARAGUAY'),(4,'BOLIVIA'),(5,'URUGUAY');
/*!40000 ALTER TABLE `nacionalidades` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orientacion`
--

DROP TABLE IF EXISTS `orientacion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `orientacion` (
  `id_orientacion` int NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci NOT NULL,
  PRIMARY KEY (`id_orientacion`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orientacion`
--

LOCK TABLES `orientacion` WRITE;
/*!40000 ALTER TABLE `orientacion` DISABLE KEYS */;
INSERT INTO `orientacion` VALUES (1,'Norte'),(2,'Sur'),(3,'Este'),(4,'Oeste');
/*!40000 ALTER TABLE `orientacion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pago`
--

DROP TABLE IF EXISTS `pago`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pago` (
  `id_pago` int NOT NULL AUTO_INCREMENT,
  `id_deudo` int NOT NULL,
  `id_parcela` int NOT NULL,
  `fecha_pago` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `importe` int DEFAULT NULL,
  `recargo` int DEFAULT NULL,
  `total` int DEFAULT NULL,
  `id_usuario` int NOT NULL,
  `fecha_vencimiento` datetime NOT NULL,
  PRIMARY KEY (`id_pago`),
  KEY `pago_FK` (`id_deudo`),
  KEY `pago_FK_1` (`id_parcela`),
  KEY `pago_FK_2` (`id_usuario`),
  CONSTRAINT `pago_FK` FOREIGN KEY (`id_deudo`) REFERENCES `deudo` (`id_deudo`),
  CONSTRAINT `pago_FK_1` FOREIGN KEY (`id_parcela`) REFERENCES `parcela` (`id_parcela`),
  CONSTRAINT `pago_FK_2` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pago`
--

LOCK TABLES `pago` WRITE;
/*!40000 ALTER TABLE `pago` DISABLE KEYS */;
INSERT INTO `pago` VALUES (1,1,1,'2024-01-15 10:30:00',5000,0,5000,1,'2024-07-15 23:59:59'),(2,2,2,'2024-02-20 14:45:00',5000,0,5000,1,'2024-08-20 23:59:59'),(3,3,3,'2024-03-10 09:15:00',5000,0,5000,1,'2024-09-10 23:59:59'),(4,4,4,'2024-04-20 16:20:00',5000,500,5500,1,'2024-04-15 23:59:59'),(5,5,5,'2024-05-25 11:00:00',5000,750,5750,1,'2024-05-20 23:59:59'),(6,6,6,'2023-06-30 10:00:00',5000,0,5000,1,'2023-12-31 23:59:59'),(7,7,7,'2023-07-15 14:30:00',5000,0,5000,1,'2024-01-31 23:59:59'),(8,8,8,'2023-08-20 09:45:00',5000,0,5000,1,'2024-02-29 23:59:59'),(9,9,9,'2023-09-10 16:20:00',8000,0,8000,1,'2024-03-31 23:59:59'),(10,10,10,'2023-10-05 11:30:00',8000,0,8000,1,'2024-04-30 23:59:59'),(11,11,11,'2024-06-01 08:00:00',3000,0,3000,1,'2024-12-01 23:59:59'),(12,12,12,'2024-06-05 12:30:00',3000,0,3000,1,'2024-12-05 23:59:59'),(13,13,13,'2024-06-10 16:45:00',10000,0,10000,1,'2024-12-10 23:59:59'),(14,14,14,'2024-06-15 11:20:00',10000,0,10000,1,'2024-12-15 23:59:59'),(15,15,15,'2024-06-20 09:30:00',10000,0,10000,1,'2024-12-20 23:59:59');
/*!40000 ALTER TABLE `pago` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `parcela`
--

DROP TABLE IF EXISTS `parcela`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `parcela` (
  `id_parcela` int NOT NULL AUTO_INCREMENT,
  `id_tipo_parcela` int NOT NULL,
  `id_deudo` int DEFAULT NULL,
  `numero_ubicacion` int DEFAULT NULL,
  `hilera` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  `seccion` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  `fraccion` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  `nivel` int DEFAULT NULL,
  `id_orientacion` int DEFAULT NULL,
  PRIMARY KEY (`id_parcela`),
  KEY `parcela_FK` (`id_tipo_parcela`),
  KEY `parcela_FK_1` (`id_deudo`),
  KEY `parcela_FK_2` (`id_orientacion`),
  CONSTRAINT `parcela_FK` FOREIGN KEY (`id_tipo_parcela`) REFERENCES `tipo_parcela` (`id_tipo_parcela`),
  CONSTRAINT `parcela_FK_1` FOREIGN KEY (`id_deudo`) REFERENCES `deudo` (`id_deudo`),
  CONSTRAINT `parcela_FK_2` FOREIGN KEY (`id_orientacion`) REFERENCES `orientacion` (`id_orientacion`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `parcela`
--

LOCK TABLES `parcela` WRITE;
/*!40000 ALTER TABLE `parcela` DISABLE KEYS */;
INSERT INTO `parcela` VALUES (1,1,1,101,'A','Norte','1',1,1),(2,1,2,102,'A','Norte','1',2,1),(3,1,3,103,'B','Norte','1',1,2),(4,1,4,104,'B','Norte','1',2,2),(5,1,5,105,'C','Sur','2',1,3),(6,2,6,201,'D','Este','3',0,4),(7,2,7,202,'D','Este','3',0,1),(8,2,8,203,'E','Oeste','4',0,2),(9,3,9,301,'F','Central','5',0,3),(10,3,10,302,'F','Central','5',0,4),(11,4,11,401,'G','Memorial','6',1,1),(12,4,12,402,'G','Memorial','6',2,2),(13,5,13,501,'H','VIP','7',0,3),(14,5,14,502,'H','VIP','7',0,4),(15,5,15,503,'I','Premium','8',0,1);
/*!40000 ALTER TABLE `parcela` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `remember_tokens`
--

DROP TABLE IF EXISTS `remember_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `remember_tokens` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_usuario` int NOT NULL,
  `token` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci NOT NULL,
  `fecha_expiracion` timestamp NOT NULL,
  `fecha_creacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `remember_tokens_FK` (`id_usuario`),
  CONSTRAINT `remember_tokens_FK` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `remember_tokens`
--

LOCK TABLES `remember_tokens` WRITE;
/*!40000 ALTER TABLE `remember_tokens` DISABLE KEYS */;
INSERT INTO `remember_tokens` VALUES (3,1,'6b4876781c1c171e18b7bf305afb523eac6e80b362c6b97d1a7207219d251a7c','2025-09-17 16:48:49','2025-08-18 13:48:49'),(4,1,'af5a4af46d0ff892041d8c9768c110134e2688a301a7c394bb556cb20a12b777','2025-09-19 14:30:25','2025-08-20 11:30:25');
/*!40000 ALTER TABLE `remember_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sexo`
--

DROP TABLE IF EXISTS `sexo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sexo` (
  `id_sexo` int NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci NOT NULL,
  PRIMARY KEY (`id_sexo`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sexo`
--

LOCK TABLES `sexo` WRITE;
/*!40000 ALTER TABLE `sexo` DISABLE KEYS */;
INSERT INTO `sexo` VALUES (1,'MASCULINO'),(2,'FEMENINO');
/*!40000 ALTER TABLE `sexo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipo_parcela`
--

DROP TABLE IF EXISTS `tipo_parcela`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tipo_parcela` (
  `id_tipo_parcela` int NOT NULL AUTO_INCREMENT,
  `nombre_parcela` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci NOT NULL,
  PRIMARY KEY (`id_tipo_parcela`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipo_parcela`
--

LOCK TABLES `tipo_parcela` WRITE;
/*!40000 ALTER TABLE `tipo_parcela` DISABLE KEYS */;
INSERT INTO `tipo_parcela` VALUES (1,'Nicho'),(2,'Fosa'),(3,'Panteón'),(4,'Osario'),(5,'Especial');
/*!40000 ALTER TABLE `tipo_parcela` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipos_usuarios`
--

DROP TABLE IF EXISTS `tipos_usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tipos_usuarios` (
  `id_tipo_usuario` int NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci NOT NULL,
  PRIMARY KEY (`id_tipo_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipos_usuarios`
--

LOCK TABLES `tipos_usuarios` WRITE;
/*!40000 ALTER TABLE `tipos_usuarios` DISABLE KEYS */;
INSERT INTO `tipos_usuarios` VALUES (1,'admin'),(2,'director'),(3,'operario'),(4,'invitado');
/*!40000 ALTER TABLE `tipos_usuarios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ubicacion_difunto`
--

DROP TABLE IF EXISTS `ubicacion_difunto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ubicacion_difunto` (
  `id_ubicacion_difunto` int NOT NULL AUTO_INCREMENT,
  `id_parcela` int NOT NULL,
  `id_difunto` int NOT NULL,
  `fecha_ingreso` date DEFAULT NULL,
  `fecha_retiro` date DEFAULT NULL,
  PRIMARY KEY (`id_ubicacion_difunto`),
  KEY `ubicacion_difunto_FK` (`id_parcela`),
  KEY `ubicacion_difunto_FK_1` (`id_difunto`),
  CONSTRAINT `ubicacion_difunto_FK` FOREIGN KEY (`id_parcela`) REFERENCES `parcela` (`id_parcela`),
  CONSTRAINT `ubicacion_difunto_FK_1` FOREIGN KEY (`id_difunto`) REFERENCES `difunto` (`id_difunto`)
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ubicacion_difunto`
--

LOCK TABLES `ubicacion_difunto` WRITE;
/*!40000 ALTER TABLE `ubicacion_difunto` DISABLE KEYS */;
INSERT INTO `ubicacion_difunto` VALUES (1,1,1,'2023-01-20',NULL),(2,2,2,'2023-02-25',NULL),(3,3,3,'2023-03-15',NULL),(4,4,4,'2023-04-10',NULL),(5,5,5,'2023-05-17',NULL),(6,6,6,'2023-06-23',NULL),(7,7,7,'2023-07-27',NULL),(8,8,8,'2023-08-15','2024-01-10'),(9,9,9,'2023-09-10',NULL),(10,10,10,'2023-10-19',NULL),(11,11,11,'2023-11-25',NULL),(12,12,12,'2023-12-08',NULL),(13,13,13,'2024-01-13',NULL),(14,14,14,'2024-02-19',NULL),(15,15,15,'2024-03-30',NULL),(16,9,8,'2024-01-15',NULL),(17,10,1,'2023-01-20','2023-10-18'),(18,10,10,'2023-10-19',NULL),(19,11,12,'2023-11-20','2023-12-07'),(20,12,12,'2023-12-08',NULL);
/*!40000 ALTER TABLE `ubicacion_difunto` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usuarios` (
  `id_usuario` int NOT NULL AUTO_INCREMENT,
  `usuario` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci NOT NULL,
  `nombre` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci NOT NULL,
  `apellido` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci NOT NULL,
  `cargo` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  `sector` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  `contrasenia` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci NOT NULL,
  `id_tipo_usuario` int NOT NULL,
  `activo` tinyint(1) DEFAULT NULL,
  `telefono` bigint DEFAULT NULL,
  `email` varchar(100) COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  PRIMARY KEY (`id_usuario`),
  KEY `usuarios_FK` (`id_tipo_usuario`),
  CONSTRAINT `usuarios_FK` FOREIGN KEY (`id_tipo_usuario`) REFERENCES `tipos_usuarios` (`id_tipo_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios`
--

LOCK TABLES `usuarios` WRITE;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` VALUES (1,'admin','adm','adm','-','-','$2y$12$vBNi6mxsffV6lDWeepjgF.sa2bMh2zRDrHowhpHTONAWoOpC7a5t2',1,1,2944302449,'ejemplo@mail.com'),(2,'director','dir','dir','-','-','$2y$12$ofvmsS0vv6mySeMAFkod.e8/Ca3zReGl7A3CSBLEDFnzIQHaeI1ua',2,1,2944123456,'ejemplo@mail.com'),(3,'operario','op','op','-','-','$2y$12$vBNi6mxsffV6lDWeepjgF.sa2bMh2zRDrHowhpHTONAWoOpC7a5t2',3,1,2944123456,'ejemplo@mail.com'),(4,'invitado','inv','inv','-','-','$2y$12$vBNi6mxsffV6lDWeepjgF.sa2bMh2zRDrHowhpHTONAWoOpC7a5t2',4,1,2944123456,'ejemplo@mail.com');
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'cementerio'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-09-03 11:06:31
