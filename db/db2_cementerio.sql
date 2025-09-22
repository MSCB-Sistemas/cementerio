-- MySQL dump 10.13  Distrib 9.4.0, for Win64 (x86_64)
--
-- Host: localhost    Database: cementerio
-- ------------------------------------------------------
-- Server version	9.4.0

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
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auditoria`
--

LOCK TABLES `auditoria` WRITE;
/*!40000 ALTER TABLE `auditoria` DISABLE KEYS */;
INSERT INTO `auditoria` VALUES (0,1,'DifuntoModel','Insert','2025-08-26 03:04:29','INSERT INTO difunto (\r\n                id_deudo, nombre, apellido, dni, edad, fecha_fallecimiento,\r\n                id_sexo, id_nacionalidad, id_estado_civil, domicilio, localidad, codigo_postal\r\n            ) \r\n            VALUES (\r\n                :id_deudo, :nombre, :apellido, :dni, :edad, :fecha_fallecimiento,\r\n                :id_sexo, :id_nacionalidad, :id_estado_civil, :domicilio, :localidad, :codigo_postal\r\n            )','{\"dni\": \"58658577\", \"edad\": \"25\", \"nombre\": \"Ali\", \"id_sexo\": \"1\", \"apellido\": \"Averizaga\", \"id_deudo\": \"1\", \"domicilio\": \"los alerces\", \"localidad\": \"RN\", \"codigo_postal\": \"8400\", \"id_estado_civil\": \"2\", \"id_nacionalidad\": \"2\", \"fecha_fallecimiento\": \"2000-01-16\"}'),(14,1,'DifuntoModel','Update','2025-08-26 03:07:42','DELETE FROM difunto WHERE id_difunto = :id_difunto','{\"id_difunto\": 1}'),(15,1,'EstadoCivilModel','Insert','2025-08-26 03:21:04','INSERT INTO estado_civil (descripcion) VALUES (:descripcion)','{\"descripcion\": \"otro\"}'),(16,1,'EstadoCivilModel','Delete','2025-08-26 03:21:17','DELETE FROM estado_civil WHERE id_estado_civil = :id_estado_civil','{\"id_estado_civil\": \"3\"}'),(17,1,'EstadoCivilModel','Update','2025-08-26 03:22:01','UPDATE estado_civil \r\n                SET id_estado_civil = :id_estado_civil, descripcion = :descripcion \r\n                WHERE id_estado_civil = :id_estado_civil','{\"descripcion\": \"SOLTERO\", \"id_estado_civil\": \"2\"}'),(18,1,'Ubicacion Difunto Model','Insert','2025-08-26 03:31:34','INSERT INTO ubicacion_difunto (id_parcela, id_difunto, fecha_ingreso, fecha_retiro)\r\n                VALUES (:id_parcela, :id_difunto, :fecha_ingreso, :fecha_retiro)\r\n                ','{\"id_difunto\": \"2\", \"id_parcela\": \"6\", \"fecha_retiro\": \"2060-08-05\", \"fecha_ingreso\": \"2000-05-09\"}'),(19,1,'Orientacion Model','Insert','2025-08-26 03:41:01','INSERT INTO orientacion (descripcion) VALUES (:descripcion)','{\"descripcion\": \"N\"}'),(20,1,'Orientacion Model','Delete','2025-08-26 03:42:20','DELETE FROM orientacion WHERE id_orientacion = :id_orientacion','{\"id_orientacion\": \"2\"}'),(21,1,'Orientacion Model','Update','2025-08-26 03:42:37','UPDATE orientacion \r\n                SET descripcion = :descripcion \r\n                WHERE id_orientacion = :id_orientacion\r\n                ','{\"descripcion\": \"o\", \"id_orientacion\": \"1\"}'),(22,1,'Genero/Sexo Model','Insert','2025-08-26 03:49:04','INSERT INTO sexo (descripcion) VALUES (:descripcion)','{\"descripcion\": \"otro\"}'),(23,1,'Genero/Sexo Model','Delete','2025-08-26 03:49:22','DELETE FROM sexo WHERE id_sexo = :id_sexo','{\"id_sexo\": \"3\"}'),(24,1,'Genero/Sexo Model','Update','2025-08-26 03:49:44','UPDATE sexo SET id_sexo = :id_sexo, descripcion = :descripcion WHERE id_sexo = :id_sexo','{\"id_sexo\": \"2\", \"descripcion\": \"FA\"}'),(25,1,'Nacionalidades Model','Insert','2025-08-26 03:55:09','INSERT INTO nacionalidades (nacionalidad) VALUES (:nacionalidad)','{\"nacionalidad\": \"Brasil\"}'),(26,1,'Nacionalidades Model','Delete','2025-08-26 03:55:28','DELETE FROM nacionalidades WHERE id_nacionalidad = :id_nacionalidad','{\"id_nacionalidad\": \"3\"}'),(27,1,'Nacionalidades Model','Update','2025-08-26 15:45:34','UPDATE nacionalidades SET nacionalidad = :nacionalidad WHERE id_nacionalidad = :id_nacionalidad','{\"nacionalidad\": \"Brasil\", \"id_nacionalidad\": \"2\"}'),(28,1,'Tipo Parcela Model','Insert','2025-08-26 22:58:25','INSERT INTO tipo_parcela (nombre_parcela) VALUES (:nombre_parcela)','{\"nombre_parcela\": \"prueba\"}'),(29,1,'Tipo Parcela Model','Update','2025-08-26 22:58:38','UPDATE tipo_parcela SET nombre_parcela = :nombre_parcela WHERE id_tipo_parcela = :id_tipo_parcela','{\"nombre_parcela\": \"prueba2\", \"id_tipo_parcela\": \"2\"}'),(30,1,'Tipo Parcela Model','Delete','2025-08-26 22:58:43','DELETE FROM tipo_parcela WHERE id_tipo_parcela = :id_tipo_parcela','{\"id_tipo_parcela\": \"2\"}'),(31,1,'Tipo Usuarios Model','Insert','2025-08-26 23:13:28','INSERT INTO tipos_usuarios (descripcion) VALUES (:descripcion)','{\"descripcion\": \"Alen\"}'),(32,1,'Tipo Usuarios Model','Update','2025-08-26 23:14:16','UPDATE tipos_usuarios SET descripcion = :descripcion \r\n                WHERE id_tipo_usuario = :id_tipo_usuario','{\"descripcion\": \"Ali\", \"id_tipo_usuario\": \"5\"}'),(33,1,'Tipo Usuarios Model','Delete','2025-08-26 23:15:17','DELETE FROM tipos_usuarios WHERE id_tipo_usuario = :id_tipo_usuario','{\"id_tipo_usuario\": 4}'),(34,1,'Pago Model','Insert','2025-08-26 23:24:42','INSERT INTO pago (id_deudo, id_parcela, fecha_pago, importe, recargo, total, id_usuario) \r\n                VALUES (:id_deudo, :id_parcela, :fecha_pago, :importe, :recargo, :total, :id_usuario)','{\"total\": \"80000\", \"importe\": \"100000\", \"recargo\": \"444\", \"id_deudo\": \"1\", \"fecha_pago\": \"5000-08-01\", \"id_parcela\": \"6\", \"id_usuario\": 1}'),(35,1,'Pago Model','Update','2025-08-26 23:25:08','UPDATE pago SET id_deudo = :id_deudo, id_parcela = :id_parcela, fecha_pago = :fecha_pago, importe = :importe, recargo = :recargo, total = :total, id_usuario = :id_usuario\r\n                WHERE id_pago = :id_pago','{\"total\": \"80000\", \"id_pago\": \"1\", \"importe\": \"100000\", \"recargo\": \"40\", \"id_deudo\": \"1\", \"fecha_pago\": \"9999-08-10\", \"id_parcela\": \"6\", \"id_usuario\": 1}'),(36,1,'Pago Model','Delete','2025-08-26 23:25:13','DELETE FROM pago WHERE id_pago = :id_pago','{\"id_pago\": \"1\"}'),(37,1,'Deudo Model','Update','2025-09-05 11:40:15','UPDATE deudo SET dni = :dni, nombre = :nombre, apellido = :apellido, telefono = :telefono, email = :email, domicilio = :domicilio, localidad = :localidad, codigo_postal = :codigo_postal\r\n                WHERE id_deudo = :id_deudo','{\"dni\": \"1818100000\", \"email\": \"futcutuyv@gmail.com\", \"nombre\": \"Abelardo\", \"apellido\": \"rosales\", \"id_deudo\": \"1\", \"telefono\": \"4686884\", \"domicilio\": \"galera\", \"localidad\": \"RN\", \"codigo_postal\": \"8400\"}'),(38,1,'Deudo Model','Update','2025-09-05 11:53:04','UPDATE deudo SET dni = :dni, nombre = :nombre, apellido = :apellido, telefono = :telefono, email = :email, domicilio = :domicilio, localidad = :localidad, codigo_postal = :codigo_postal\r\n                WHERE id_deudo = :id_deudo','{\"dni\": \"1818100000\", \"email\": \"futcutuyv@gmail.com\", \"nombre\": \"Rodrigo\", \"apellido\": \"rosales\", \"id_deudo\": \"1\", \"telefono\": \"4686884\", \"domicilio\": \"galera\", \"localidad\": \"RN\", \"codigo_postal\": \"8400\"}'),(39,1,'Usuario Model','Update','2025-09-05 11:53:49','UPDATE usuarios \r\n                SET usuario = :usuario, nombre = :nombre, apellido = :apellido, cargo = :cargo, sector = :sector, telefono = :telefono, email = :email, id_tipo_usuario = :id_tipo_usuario \r\n                WHERE id_usuario = :id_usuario\r\n                ','{\"cargo\": \"vendedora\", \"email\": \"ara@gmail.com\", \"nombre\": \"Patricia\", \"sector\": \"otro sector\", \"usuario\": \"PatiConsultor\", \"apellido\": \"Pavloska\", \"telefono\": \"2944333333\", \"id_usuario\": \"3\", \"id_tipo_usuario\": \"3\"}'),(40,1,'Usuario Model','Update','2025-09-05 11:54:45','UPDATE usuarios \r\n                SET usuario = :usuario, nombre = :nombre, apellido = :apellido, cargo = :cargo, sector = :sector, telefono = :telefono, email = :email, id_tipo_usuario = :id_tipo_usuario \r\n                WHERE id_usuario = :id_usuario\r\n                ','{\"cargo\": \"vendedora\", \"email\": \"pati23@gmail.com\", \"nombre\": \"Patricia\", \"sector\": \"otro sector\", \"usuario\": \"PatiConsultor\", \"apellido\": \"Pavloska\", \"telefono\": \"2944333333\", \"id_usuario\": \"3\", \"id_tipo_usuario\": \"3\"}'),(41,1,'Usuario Model','Update','2025-09-08 13:57:48','UPDATE usuarios \r\n                SET usuario = :usuario, nombre = :nombre, apellido = :apellido, cargo = :cargo, sector = :sector, telefono = :telefono, email = :email, id_tipo_usuario = :id_tipo_usuario \r\n                WHERE id_usuario = :id_usuario\r\n                ','{\"cargo\": \"yyyy\", \"email\": \"a@hotmail.com\", \"nombre\": \"Dorothea\", \"sector\": \"YY\", \"usuario\": \"prueba\", \"apellido\": \"Yukino\", \"telefono\": \"8888888888\", \"id_usuario\": \"4\", \"id_tipo_usuario\": \"1\"}'),(42,1,'Usuario Model','Delete','2025-09-08 13:59:21','UPDATE usuarios SET activo = 0 WHERE id_usuario = :id_usuario','{\"id_usuario\": \"4\"}'),(43,1,'Usuario Model','Delete','2025-09-08 14:01:00','UPDATE usuarios SET activo = 0 WHERE id_usuario = :id_usuario','{\"id_usuario\": \"4\"}'),(44,1,'Usuario Model','Insert','2025-09-08 14:02:08','INSERT INTO usuarios (usuario, nombre, apellido, cargo, sector, telefono, email, contrasenia, id_tipo_usuario) \r\n                VALUES (:usuario, :nombre, :apellido, :cargo, :sector, :telefono, :email, :contrasenia, :id_tipo_usuario)\r\n                ','{\"cargo\": \"yyyy\", \"email\": \"b@gmail.com\", \"nombre\": \"Abelardo\", \"sector\": \"7777\", \"usuario\": \"aaaaa\", \"apellido\": \"Yuki\", \"telefono\": \"88888888888\", \"contrasenia\": \"$2y$12$G/WqkWy8wJuavrHI0Z73JeIkVs.8Q3lewFDkX526B7e0F.UJNkUhq\", \"id_tipo_usuario\": \"3\"}'),(45,1,'Usuario Model','Insert','2025-09-15 21:13:54','INSERT INTO usuarios (usuario, nombre, apellido, cargo, sector, telefono, email, contrasenia, id_tipo_usuario) \r\n                VALUES (:usuario, :nombre, :apellido, :cargo, :sector, :telefono, :email, :contrasenia, :id_tipo_usuario)\r\n                ','{\"cargo\": \"yyyy\", \"email\": \"guyg@gmail.com\", \"nombre\": \"Abelardo\", \"sector\": \"7777\", \"usuario\": \"95687653\", \"apellido\": \"rosales\", \"telefono\": \"888888\", \"contrasenia\": \"$2y$12$l/GsKz1t5ggqfbScGuPTuOAL6wa9A1nYl1e/3/MlQ5ZKALoDX49Va\", \"id_tipo_usuario\": \"3\"}'),(46,1,'Usuario Model','Update','2025-09-17 11:21:00','UPDATE usuarios \r\n                SET usuario = :usuario, nombre = :nombre, apellido = :apellido, cargo = :cargo, sector = :sector, telefono = :telefono, email = :email, id_tipo_usuario = :id_tipo_usuario \r\n                WHERE id_usuario = :id_usuario\r\n                ','{\"cargo\": \"yyyy\", \"email\": \"guyg@gmail.com\", \"nombre\": \"Abelardo\", \"sector\": \"7777\", \"usuario\": \"Cristina\", \"apellido\": \"rosales\", \"telefono\": \"888888\", \"id_usuario\": 6, \"id_tipo_usuario\": \"3\"}'),(47,1,'Usuario Model','Delete','2025-09-17 11:41:46','UPDATE usuarios SET activo = 0 WHERE id_usuario = :id_usuario','{\"id_usuario\": 6}'),(48,1,'Difunto Model','Insert','2025-09-17 11:46:31','INSERT INTO difunto (\r\n                id_deudo, nombre, apellido, dni, edad, fecha_fallecimiento,\r\n                id_sexo, id_nacionalidad, id_estado_civil, domicilio, localidad, codigo_postal\r\n            ) \r\n            VALUES (\r\n                :id_deudo, :nombre, :apellido, :dni, :edad, :fecha_fallecimiento,\r\n                :id_sexo, :id_nacionalidad, :id_estado_civil, :domicilio, :localidad, :codigo_postal\r\n            )','{\"dni\": \"53463453456\", \"edad\": \"43\", \"nombre\": \"ferff\", \"id_sexo\": \"1\", \"apellido\": \"erferfer\", \"id_deudo\": \"1\", \"domicilio\": \"desgser\", \"localidad\": \"RN\", \"codigo_postal\": \"8400\", \"id_estado_civil\": \"2\", \"id_nacionalidad\": \"2\", \"fecha_fallecimiento\": \"2025-09-01\"}');
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
  `telefono` int DEFAULT NULL,
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  `domicilio` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  `localidad` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  `codigo_postal` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  PRIMARY KEY (`id_deudo`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `deudo`
--

LOCK TABLES `deudo` WRITE;
/*!40000 ALTER TABLE `deudo` DISABLE KEYS */;
INSERT INTO `deudo` VALUES (1,1818100000,'Rodrigo','rosales',4686884,'futcutuyv@gmail.com','galera','RN','8400');
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
  `dni` int DEFAULT NULL,
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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `difunto`
--

LOCK TABLES `difunto` WRITE;
/*!40000 ALTER TABLE `difunto` DISABLE KEYS */;
INSERT INTO `difunto` VALUES (2,1,'RAUL','Ramires',888888,99,'2025-08-26 03:30:44',1,1,1,'tryhth','btb','8400'),(3,1,'ferff','erferfer',2147483647,43,'2025-09-01 03:00:00',1,2,2,'desgser','RN','8400');
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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `estado_civil`
--

LOCK TABLES `estado_civil` WRITE;
/*!40000 ALTER TABLE `estado_civil` DISABLE KEYS */;
INSERT INTO `estado_civil` VALUES (1,'casado'),(2,'SOLTERO');
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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nacionalidades`
--

LOCK TABLES `nacionalidades` WRITE;
/*!40000 ALTER TABLE `nacionalidades` DISABLE KEYS */;
INSERT INTO `nacionalidades` VALUES (1,'Argentina '),(2,'Brasil');
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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orientacion`
--

LOCK TABLES `orientacion` WRITE;
/*!40000 ALTER TABLE `orientacion` DISABLE KEYS */;
INSERT INTO `orientacion` VALUES (1,'o');
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
  `fecha_pago` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pago`
--

LOCK TABLES `pago` WRITE;
/*!40000 ALTER TABLE `pago` DISABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `parcela`
--

LOCK TABLES `parcela` WRITE;
/*!40000 ALTER TABLE `parcela` DISABLE KEYS */;
INSERT INTO `parcela` VALUES (6,1,1,0,'Z','0','N-89',3,1),(7,1,1,8,'A','15','N-14',3,1);
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
  `nombre_permiso` varchar(100) COLLATE utf8mb4_spanish2_ci NOT NULL,
  PRIMARY KEY (`id_permiso`),
  UNIQUE KEY `nombre_permiso` (`nombre_permiso`)
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permisos`
--

LOCK TABLES `permisos` WRITE;
/*!40000 ALTER TABLE `permisos` DISABLE KEYS */;
INSERT INTO `permisos` VALUES (35,'crear_deudo'),(7,'crear_difunto'),(11,'crear_estado_civil'),(39,'crear_nacionalidad'),(43,'crear_orientacion'),(23,'crear_pago'),(15,'crear_parcela'),(19,'crear_sexo'),(27,'crear_tipo_parcela'),(31,'crear_tipo_usuario'),(47,'crear_ubicacion'),(3,'crear_usuario'),(36,'editar_deudo'),(8,'editar_difunto'),(12,'editar_estado_civil'),(40,'editar_nacionalidad'),(44,'editar_orientacion'),(24,'editar_pago'),(16,'editar_parcela'),(20,'editar_sexo'),(28,'editar_tipo_parcela'),(32,'editar_tipo_usuario'),(48,'editar_ubicacion'),(4,'editar_usuario'),(37,'eliminar_deudo'),(9,'eliminar_difunto'),(13,'eliminar_estado_civil'),(41,'eliminar_nacionalidad'),(45,'eliminar_orientacion'),(25,'eliminar_pago'),(17,'eliminar_parcela'),(21,'eliminar_sexo'),(29,'eliminar_tipo_parcela'),(33,'eliminar_tipo_usuario'),(49,'eliminar_ubicacion'),(5,'eliminar_usuario'),(34,'ver_deudo'),(6,'ver_difunto'),(1,'ver_estadisticas'),(10,'ver_estado_civil'),(38,'ver_nacionalidad'),(42,'ver_orientacion'),(22,'ver_pago'),(14,'ver_parcela'),(18,'ver_sexo'),(26,'ver_tipo_parcela'),(30,'ver_tipo_usuario'),(46,'ver_ubicacion'),(2,'ver_usuario');
/*!40000 ALTER TABLE `permisos` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `remember_tokens`
--

LOCK TABLES `remember_tokens` WRITE;
/*!40000 ALTER TABLE `remember_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `remember_tokens` ENABLE KEYS */;
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
  KEY `rol_permiso_permisos_fk` (`id_permiso`),
  CONSTRAINT `rol_permiso_permisos_fk` FOREIGN KEY (`id_permiso`) REFERENCES `permisos` (`id_permiso`),
  CONSTRAINT `rol_permiso_tipos_usuarios_FK` FOREIGN KEY (`id_tipo_usuario`) REFERENCES `tipos_usuarios` (`id_tipo_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rol_permiso`
--

LOCK TABLES `rol_permiso` WRITE;
/*!40000 ALTER TABLE `rol_permiso` DISABLE KEYS */;
INSERT INTO `rol_permiso` VALUES (1,1),(1,2),(1,3),(1,4),(1,5),(1,6),(1,7),(1,8),(1,9),(1,10),(1,11),(1,12),(1,13),(1,14),(1,15),(1,16),(1,17),(1,18),(1,19),(1,20),(1,21),(1,22),(1,23),(1,24),(1,25),(1,26),(1,27),(1,28),(1,29),(1,30),(1,31),(1,32),(1,33),(1,34),(1,35),(1,36),(1,37),(1,38),(1,39),(1,40),(1,41),(1,42),(1,43),(1,44),(1,45),(1,46),(1,47),(1,48),(1,49),(2,1),(2,2),(2,3),(2,4),(2,6),(2,7),(2,8),(2,9),(2,10),(2,11),(2,12),(2,13),(2,14),(2,15),(2,16),(2,17),(2,18),(2,19),(2,20),(2,21),(2,22),(2,23),(2,24),(2,25),(2,26),(2,27),(2,28),(2,29),(2,30),(2,31),(2,32),(2,33),(2,34),(2,35),(2,36),(2,37),(2,37),(2,37),(2,37),(2,41),(2,42),(2,43),(2,44),(2,45),(2,46),(2,47),(2,48),(2,49),(3,1),(3,6),(3,14),(3,34),(3,46);
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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sexo`
--

LOCK TABLES `sexo` WRITE;
/*!40000 ALTER TABLE `sexo` DISABLE KEYS */;
INSERT INTO `sexo` VALUES (1,'M'),(2,'FA');
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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipo_parcela`
--

LOCK TABLES `tipo_parcela` WRITE;
/*!40000 ALTER TABLE `tipo_parcela` DISABLE KEYS */;
INSERT INTO `tipo_parcela` VALUES (1,'jl66');
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
  `descripcion` varchar(255) COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  PRIMARY KEY (`id_tipo_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipos_usuarios`
--

LOCK TABLES `tipos_usuarios` WRITE;
/*!40000 ALTER TABLE `tipos_usuarios` DISABLE KEYS */;
INSERT INTO `tipos_usuarios` VALUES (1,'Admin','CRUD completo en todas las secciones (incluye usuarios)'),(2,'Editor','CRUD excepto eliminar usuarios, pero sí puede eliminar datos de otros modelos'),(3,'Consultor','Solo acceso a estadísticas (lectura)');
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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ubicacion_difunto`
--

LOCK TABLES `ubicacion_difunto` WRITE;
/*!40000 ALTER TABLE `ubicacion_difunto` DISABLE KEYS */;
INSERT INTO `ubicacion_difunto` VALUES (1,6,2,'2000-05-09','2060-08-05');
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
  `contrasenia` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci NOT NULL,
  `nombre` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci NOT NULL,
  `apellido` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci NOT NULL,
  `cargo` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  `sector` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  `telefono` varchar(50) COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci NOT NULL,
  `id_tipo_usuario` int NOT NULL,
  `activo` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id_usuario`),
  KEY `usuarios_FK` (`id_tipo_usuario`),
  CONSTRAINT `usuarios_FK` FOREIGN KEY (`id_tipo_usuario`) REFERENCES `tipos_usuarios` (`id_tipo_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios`
--

LOCK TABLES `usuarios` WRITE;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` VALUES (1,'JuanAdmin','$2a$12$0PV7GrKY9zO4u2xturwade8f3jKfla7XfITgsKe2iHW6YvsTlDYxW','Juan','Carrillo','secretario','sistemas','2944444444','juan@gmail.com',1,1),(2,'TatiEditor','$2a$12$0PV7GrKY9zO4u2xturwade8f3jKfla7XfITgsKe2iHW6YvsTlDYxW','Tatiana','Lopez','Ingeniera Industrial','obras','2944888888','tatiana@gmail.com',2,1),(3,'PatiConsultor','$2a$12$0PV7GrKY9zO4u2xturwade8f3jKfla7XfITgsKe2iHW6YvsTlDYxW','Patricia','Pavloska','vendedora','otro sector','2944333333','pati23@gmail.com',3,1),(4,'prueba','$2a$12$0PV7GrKY9zO4u2xturwade8f3jKfla7XfITgsKe2iHW6YvsTlDYxW','Dorothea','Yukino','yyyy','YY','8888888888','a@hotmail.com',1,1),(5,'aaaaa','$2a$12$0PV7GrKY9zO4u2xturwade8f3jKfla7XfITgsKe2iHW6YvsTlDYxW','Abelardo','Yuki','yyyy','7777','88888888888','b@gmail.com',3,NULL),(6,'Cristina','$2y$12$l/GsKz1t5ggqfbScGuPTuOAL6wa9A1nYl1e/3/MlQ5ZKALoDX49Va','Abelardo','rosales','yyyy','7777','888888','guyg@gmail.com',3,0);
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

-- Dump completed on 2025-09-22  9:31:52
