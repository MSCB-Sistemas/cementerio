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
-- Table structure for table `auditoria`
--

DROP TABLE IF EXISTS `auditoria`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `auditoria` (
  `id_auditoria` int NOT NULL AUTO_INCREMENT,
  `id_usuario` int NOT NULL,
  `model` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  `accion` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  `creado_en` datetime DEFAULT CURRENT_TIMESTAMP,
  `query_sql` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci NOT NULL,
  `parametros` json DEFAULT NULL,
  PRIMARY KEY (`id_auditoria`),
  KEY `fk_asistencia_usuario` (`id_usuario`),
  CONSTRAINT `fk_asistencia_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auditoria`
--

LOCK TABLES `auditoria` WRITE;
/*!40000 ALTER TABLE `auditoria` DISABLE KEYS */;
INSERT INTO `auditoria` VALUES (14,1,'DifuntoModel','Update','2025-08-26 03:07:42','DELETE FROM difunto WHERE id_difunto = :id_difunto','{\"id_difunto\": 1}'),(15,1,'EstadoCivilModel','Insert','2025-08-26 03:21:04','INSERT INTO estado_civil (descripcion) VALUES (:descripcion)','{\"descripcion\": \"otro\"}'),(16,1,'EstadoCivilModel','Delete','2025-08-26 03:21:17','DELETE FROM estado_civil WHERE id_estado_civil = :id_estado_civil','{\"id_estado_civil\": \"3\"}'),(17,1,'EstadoCivilModel','Update','2025-08-26 03:22:01','UPDATE estado_civil \r\n                SET id_estado_civil = :id_estado_civil, descripcion = :descripcion \r\n                WHERE id_estado_civil = :id_estado_civil','{\"descripcion\": \"SOLTERO\", \"id_estado_civil\": \"2\"}'),(18,1,'Ubicacion Difunto Model','Insert','2025-08-26 03:31:34','INSERT INTO ubicacion_difunto (id_parcela, id_difunto, fecha_ingreso, fecha_retiro)\r\n                VALUES (:id_parcela, :id_difunto, :fecha_ingreso, :fecha_retiro)\r\n                ','{\"id_difunto\": \"2\", \"id_parcela\": \"6\", \"fecha_retiro\": \"2060-08-05\", \"fecha_ingreso\": \"2000-05-09\"}'),(19,1,'Orientacion Model','Insert','2025-08-26 03:41:01','INSERT INTO orientacion (descripcion) VALUES (:descripcion)','{\"descripcion\": \"N\"}'),(20,1,'Orientacion Model','Delete','2025-08-26 03:42:20','DELETE FROM orientacion WHERE id_orientacion = :id_orientacion','{\"id_orientacion\": \"2\"}'),(21,1,'Orientacion Model','Update','2025-08-26 03:42:37','UPDATE orientacion \r\n                SET descripcion = :descripcion \r\n                WHERE id_orientacion = :id_orientacion\r\n                ','{\"descripcion\": \"o\", \"id_orientacion\": \"1\"}'),(22,1,'Genero/Sexo Model','Insert','2025-08-26 03:49:04','INSERT INTO sexo (descripcion) VALUES (:descripcion)','{\"descripcion\": \"otro\"}'),(23,1,'Genero/Sexo Model','Delete','2025-08-26 03:49:22','DELETE FROM sexo WHERE id_sexo = :id_sexo','{\"id_sexo\": \"3\"}'),(24,1,'Genero/Sexo Model','Update','2025-08-26 03:49:44','UPDATE sexo SET id_sexo = :id_sexo, descripcion = :descripcion WHERE id_sexo = :id_sexo','{\"id_sexo\": \"2\", \"descripcion\": \"FA\"}'),(25,1,'Nacionalidades Model','Insert','2025-08-26 03:55:09','INSERT INTO nacionalidades (nacionalidad) VALUES (:nacionalidad)','{\"nacionalidad\": \"Brasil\"}'),(26,1,'Nacionalidades Model','Delete','2025-08-26 03:55:28','DELETE FROM nacionalidades WHERE id_nacionalidad = :id_nacionalidad','{\"id_nacionalidad\": \"3\"}'),(27,1,'Nacionalidades Model','Update','2025-08-26 15:45:34','UPDATE nacionalidades SET nacionalidad = :nacionalidad WHERE id_nacionalidad = :id_nacionalidad','{\"nacionalidad\": \"Brasil\", \"id_nacionalidad\": \"2\"}'),(28,1,'Tipo Parcela Model','Insert','2025-08-26 22:58:25','INSERT INTO tipo_parcela (nombre_parcela) VALUES (:nombre_parcela)','{\"nombre_parcela\": \"prueba\"}'),(29,1,'Tipo Parcela Model','Update','2025-08-26 22:58:38','UPDATE tipo_parcela SET nombre_parcela = :nombre_parcela WHERE id_tipo_parcela = :id_tipo_parcela','{\"nombre_parcela\": \"prueba2\", \"id_tipo_parcela\": \"2\"}'),(30,1,'Tipo Parcela Model','Delete','2025-08-26 22:58:43','DELETE FROM tipo_parcela WHERE id_tipo_parcela = :id_tipo_parcela','{\"id_tipo_parcela\": \"2\"}'),(31,1,'Tipo Usuarios Model','Insert','2025-08-26 23:13:28','INSERT INTO tipos_usuarios (descripcion) VALUES (:descripcion)','{\"descripcion\": \"Alen\"}'),(32,1,'Tipo Usuarios Model','Update','2025-08-26 23:14:16','UPDATE tipos_usuarios SET descripcion = :descripcion \r\n                WHERE id_tipo_usuario = :id_tipo_usuario','{\"descripcion\": \"Ali\", \"id_tipo_usuario\": \"5\"}'),(33,1,'Tipo Usuarios Model','Delete','2025-08-26 23:15:17','DELETE FROM tipos_usuarios WHERE id_tipo_usuario = :id_tipo_usuario','{\"id_tipo_usuario\": 4}'),(34,1,'Pago Model','Insert','2025-08-26 23:24:42','INSERT INTO pago (id_deudo, id_parcela, fecha_pago, importe, recargo, total, id_usuario) \r\n                VALUES (:id_deudo, :id_parcela, :fecha_pago, :importe, :recargo, :total, :id_usuario)','{\"total\": \"80000\", \"importe\": \"100000\", \"recargo\": \"444\", \"id_deudo\": \"1\", \"fecha_pago\": \"5000-08-01\", \"id_parcela\": \"6\", \"id_usuario\": 1}'),(35,1,'Pago Model','Update','2025-08-26 23:25:08','UPDATE pago SET id_deudo = :id_deudo, id_parcela = :id_parcela, fecha_pago = :fecha_pago, importe = :importe, recargo = :recargo, total = :total, id_usuario = :id_usuario\r\n                WHERE id_pago = :id_pago','{\"total\": \"80000\", \"id_pago\": \"1\", \"importe\": \"100000\", \"recargo\": \"40\", \"id_deudo\": \"1\", \"fecha_pago\": \"9999-08-10\", \"id_parcela\": \"6\", \"id_usuario\": 1}'),(36,1,'Pago Model','Delete','2025-08-26 23:25:13','DELETE FROM pago WHERE id_pago = :id_pago','{\"id_pago\": \"1\"}'),(37,1,'Deudo Model','Update','2025-09-05 11:40:15','UPDATE deudo SET dni = :dni, nombre = :nombre, apellido = :apellido, telefono = :telefono, email = :email, domicilio = :domicilio, localidad = :localidad, codigo_postal = :codigo_postal\r\n                WHERE id_deudo = :id_deudo','{\"dni\": \"1818100000\", \"email\": \"futcutuyv@gmail.com\", \"nombre\": \"Abelardo\", \"apellido\": \"rosales\", \"id_deudo\": \"1\", \"telefono\": \"4686884\", \"domicilio\": \"galera\", \"localidad\": \"RN\", \"codigo_postal\": \"8400\"}'),(38,1,'Deudo Model','Update','2025-09-05 11:53:04','UPDATE deudo SET dni = :dni, nombre = :nombre, apellido = :apellido, telefono = :telefono, email = :email, domicilio = :domicilio, localidad = :localidad, codigo_postal = :codigo_postal\r\n                WHERE id_deudo = :id_deudo','{\"dni\": \"1818100000\", \"email\": \"futcutuyv@gmail.com\", \"nombre\": \"Rodrigo\", \"apellido\": \"rosales\", \"id_deudo\": \"1\", \"telefono\": \"4686884\", \"domicilio\": \"galera\", \"localidad\": \"RN\", \"codigo_postal\": \"8400\"}'),(39,1,'Usuario Model','Update','2025-09-05 11:53:49','UPDATE usuarios \r\n                SET usuario = :usuario, nombre = :nombre, apellido = :apellido, cargo = :cargo, sector = :sector, telefono = :telefono, email = :email, id_tipo_usuario = :id_tipo_usuario \r\n                WHERE id_usuario = :id_usuario\r\n                ','{\"cargo\": \"vendedora\", \"email\": \"ara@gmail.com\", \"nombre\": \"Patricia\", \"sector\": \"otro sector\", \"usuario\": \"PatiConsultor\", \"apellido\": \"Pavloska\", \"telefono\": \"2944333333\", \"id_usuario\": \"3\", \"id_tipo_usuario\": \"3\"}'),(40,1,'Usuario Model','Update','2025-09-05 11:54:45','UPDATE usuarios \r\n                SET usuario = :usuario, nombre = :nombre, apellido = :apellido, cargo = :cargo, sector = :sector, telefono = :telefono, email = :email, id_tipo_usuario = :id_tipo_usuario \r\n                WHERE id_usuario = :id_usuario\r\n                ','{\"cargo\": \"vendedora\", \"email\": \"pati23@gmail.com\", \"nombre\": \"Patricia\", \"sector\": \"otro sector\", \"usuario\": \"PatiConsultor\", \"apellido\": \"Pavloska\", \"telefono\": \"2944333333\", \"id_usuario\": \"3\", \"id_tipo_usuario\": \"3\"}'),(41,1,'Usuario Model','Update','2025-09-08 13:57:48','UPDATE usuarios \r\n                SET usuario = :usuario, nombre = :nombre, apellido = :apellido, cargo = :cargo, sector = :sector, telefono = :telefono, email = :email, id_tipo_usuario = :id_tipo_usuario \r\n                WHERE id_usuario = :id_usuario\r\n                ','{\"cargo\": \"yyyy\", \"email\": \"a@hotmail.com\", \"nombre\": \"Dorothea\", \"sector\": \"YY\", \"usuario\": \"prueba\", \"apellido\": \"Yukino\", \"telefono\": \"8888888888\", \"id_usuario\": \"4\", \"id_tipo_usuario\": \"1\"}'),(42,1,'Usuario Model','Delete','2025-09-08 13:59:21','UPDATE usuarios SET activo = 0 WHERE id_usuario = :id_usuario','{\"id_usuario\": \"4\"}'),(43,1,'Usuario Model','Delete','2025-09-08 14:01:00','UPDATE usuarios SET activo = 0 WHERE id_usuario = :id_usuario','{\"id_usuario\": \"4\"}'),(44,1,'Usuario Model','Insert','2025-09-08 14:02:08','INSERT INTO usuarios (usuario, nombre, apellido, cargo, sector, telefono, email, contrasenia, id_tipo_usuario) \r\n                VALUES (:usuario, :nombre, :apellido, :cargo, :sector, :telefono, :email, :contrasenia, :id_tipo_usuario)\r\n                ','{\"cargo\": \"yyyy\", \"email\": \"b@gmail.com\", \"nombre\": \"Abelardo\", \"sector\": \"7777\", \"usuario\": \"aaaaa\", \"apellido\": \"Yuki\", \"telefono\": \"88888888888\", \"contrasenia\": \"$2y$12$G/WqkWy8wJuavrHI0Z73JeIkVs.8Q3lewFDkX526B7e0F.UJNkUhq\", \"id_tipo_usuario\": \"3\"}'),(45,1,'Usuario Model','Insert','2025-09-15 21:13:54','INSERT INTO usuarios (usuario, nombre, apellido, cargo, sector, telefono, email, contrasenia, id_tipo_usuario) \r\n                VALUES (:usuario, :nombre, :apellido, :cargo, :sector, :telefono, :email, :contrasenia, :id_tipo_usuario)\r\n                ','{\"cargo\": \"yyyy\", \"email\": \"guyg@gmail.com\", \"nombre\": \"Abelardo\", \"sector\": \"7777\", \"usuario\": \"95687653\", \"apellido\": \"rosales\", \"telefono\": \"888888\", \"contrasenia\": \"$2y$12$l/GsKz1t5ggqfbScGuPTuOAL6wa9A1nYl1e/3/MlQ5ZKALoDX49Va\", \"id_tipo_usuario\": \"3\"}'),(46,1,'Usuario Model','Update','2025-09-17 11:21:00','UPDATE usuarios \r\n                SET usuario = :usuario, nombre = :nombre, apellido = :apellido, cargo = :cargo, sector = :sector, telefono = :telefono, email = :email, id_tipo_usuario = :id_tipo_usuario \r\n                WHERE id_usuario = :id_usuario\r\n                ','{\"cargo\": \"yyyy\", \"email\": \"guyg@gmail.com\", \"nombre\": \"Abelardo\", \"sector\": \"7777\", \"usuario\": \"Cristina\", \"apellido\": \"rosales\", \"telefono\": \"888888\", \"id_usuario\": 6, \"id_tipo_usuario\": \"3\"}'),(47,1,'Usuario Model','Delete','2025-09-17 11:41:46','UPDATE usuarios SET activo = 0 WHERE id_usuario = :id_usuario','{\"id_usuario\": 6}'),(48,1,'Difunto Model','Insert','2025-09-17 11:46:31','INSERT INTO difunto (\r\n                id_deudo, nombre, apellido, dni, edad, fecha_fallecimiento,\r\n                id_sexo, id_nacionalidad, id_estado_civil, domicilio, localidad, codigo_postal\r\n            ) \r\n            VALUES (\r\n                :id_deudo, :nombre, :apellido, :dni, :edad, :fecha_fallecimiento,\r\n                :id_sexo, :id_nacionalidad, :id_estado_civil, :domicilio, :localidad, :codigo_postal\r\n            )','{\"dni\": \"53463453456\", \"edad\": \"43\", \"nombre\": \"ferff\", \"id_sexo\": \"1\", \"apellido\": \"erferfer\", \"id_deudo\": \"1\", \"domicilio\": \"desgser\", \"localidad\": \"RN\", \"codigo_postal\": \"8400\", \"id_estado_civil\": \"2\", \"id_nacionalidad\": \"2\", \"fecha_fallecimiento\": \"2025-09-01\"}'),(49,1,'DifuntoModel','Insert','2025-08-26 03:04:29','INSERT INTO difunto (\r\n                id_deudo, nombre, apellido, dni, edad, fecha_fallecimiento,\r\n                id_sexo, id_nacionalidad, id_estado_civil, domicilio, localidad, codigo_postal\r\n            ) \r\n            VALUES (\r\n                :id_deudo, :nombre, :apellido, :dni, :edad, :fecha_fallecimiento,\r\n                :id_sexo, :id_nacionalidad, :id_estado_civil, :domicilio, :localidad, :codigo_postal\r\n            )','{\"dni\": \"58658577\", \"edad\": \"25\", \"nombre\": \"Ali\", \"id_sexo\": \"1\", \"apellido\": \"Averizaga\", \"id_deudo\": \"1\", \"domicilio\": \"los alerces\", \"localidad\": \"RN\", \"codigo_postal\": \"8400\", \"id_estado_civil\": \"2\", \"id_nacionalidad\": \"2\", \"fecha_fallecimiento\": \"2000-01-16\"}');
/*!40000 ALTER TABLE `auditoria` ENABLE KEYS */;
UNLOCK TABLES;

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
-- Table structure for table `permisos`
--

DROP TABLE IF EXISTS `permisos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `permisos` (
  `id_permiso` int NOT NULL AUTO_INCREMENT,
  `nombre_permiso` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci NOT NULL,
  `descripcion` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  PRIMARY KEY (`id_permiso`),
  UNIQUE KEY `permisos_unique` (`nombre_permiso`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permisos`
--

LOCK TABLES `permisos` WRITE;
/*!40000 ALTER TABLE `permisos` DISABLE KEYS */;
INSERT INTO `permisos` VALUES (1,'crear_usuario','Permite registrar nuevos usuarios'),(2,'editar_usuario','Permite actualizar la información de un usuario'),(3,'eliminar_usuario','Elimina de la BD al usuario'),(4,'ver_estadisticas','Permite ver la tabla de Estadísticas'),(5,'ver_usuario','Permite ver la info de usuarios'),(10,'ver_difunto','Permite ver la tabla de Difuntos'),(11,'crear_difunto','Permite registrar nuevo difunto'),(12,'ver_parcela','Permite ver parcelas'),(13,'ver_deudo','Permite ver deudo'),(14,'ver_nacionalidad','Permite ver las nacionalidades'),(15,'ver_ubicacion','Permitir ver ubicaciones'),(16,'editar_difunto',NULL),(17,'eliminar_difunto',NULL);
/*!40000 ALTER TABLE `permisos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rol_permiso`
--

DROP TABLE IF EXISTS `rol_permiso`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `rol_permiso` (
  `id_tipo_usuario` int DEFAULT NULL,
  `id_permiso` int DEFAULT NULL,
  KEY `rol_permiso_tipos_usuarios_FK` (`id_tipo_usuario`),
  KEY `rol_permiso_permisos_FK` (`id_permiso`),
  CONSTRAINT `rol_permiso_permisos_FK` FOREIGN KEY (`id_permiso`) REFERENCES `permisos` (`id_permiso`),
  CONSTRAINT `rol_permiso_tipos_usuarios_FK` FOREIGN KEY (`id_tipo_usuario`) REFERENCES `tipos_usuarios` (`id_tipo_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rol_permiso`
--

LOCK TABLES `rol_permiso` WRITE;
/*!40000 ALTER TABLE `rol_permiso` DISABLE KEYS */;
INSERT INTO `rol_permiso` VALUES (1,1),(1,2),(1,3),(1,4),(1,5),(1,10),(1,11),(4,4),(4,10),(4,13),(4,12),(4,15),(2,10),(2,11),(2,13),(2,5),(2,1),(2,2),(2,16),(2,4);
/*!40000 ALTER TABLE `rol_permiso` ENABLE KEYS */;
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
INSERT INTO `sexo` VALUES (1,'Masculinno'),(2,'Femenino');
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
  `rol` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci NOT NULL,
  `descripcion` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  PRIMARY KEY (`id_tipo_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipos_usuarios`
--

LOCK TABLES `tipos_usuarios` WRITE;
/*!40000 ALTER TABLE `tipos_usuarios` DISABLE KEYS */;
INSERT INTO `tipos_usuarios` VALUES (1,'Administrador','CRUD completo en todas las secciones (incluye usuarios)'),(2,'Editor','CRUD excepto eliminar usuarios, pero sí puede eliminar datos de otros modelos'),(3,'Consultor','Solo acceso a estadísticas (lectura)');
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
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
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
INSERT INTO `usuarios` VALUES (1,'admin','adm','adm','-','-','$2a$12$jcPTF/onz0m4ahZP822oF.BRy3AFtgiOQioTJmctuPVx1Xi0v5YHy',1,1,2944302449,'ejemplo@mail.com'),(2,'director','dir','dir','-','-','$2y$12$ofvmsS0vv6mySeMAFkod.e8/Ca3zReGl7A3CSBLEDFnzIQHaeI1ua',2,1,2944123456,'ejemplo@mail.com'),(3,'operario','op','op','-','-','$2y$12$vBNi6mxsffV6lDWeepjgF.sa2bMh2zRDrHowhpHTONAWoOpC7a5t2',3,1,2944123456,'ejemplo@mail.com'),(4,'invitado','inv','inv','-','-','$2a$12$jcPTF/onz0m4ahZP822oF.BRy3AFtgiOQioTJmctuPVx1Xi0v5YHy',4,1,2944123456,'ejemplo@mail.com');
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

-- Dump completed on 2025-09-23  9:22:30
