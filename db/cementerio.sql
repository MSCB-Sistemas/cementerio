-- sgcm.sexo definition

CREATE TABLE `sexo` (
  `id_sexo` int NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci NOT NULL,
  PRIMARY KEY (`id_sexo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

-- sgcm.estado_civil definition

CREATE TABLE `estado_civil` (
  `id_estado_civil` int NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci NOT NULL,
  PRIMARY KEY (`id_estado_civil`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

-- sgcm.nacionalidades definition

CREATE TABLE `nacionalidades` (
  `id_nacionalidad` int NOT NULL AUTO_INCREMENT,
  `nacionalidad` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci NOT NULL,
  PRIMARY KEY (`id_nacionalidad`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

-- sgcm.orientacion definition

CREATE TABLE `orientacion` (
  `id_orientacion` int NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci NOT NULL,
  PRIMARY KEY (`id_orientacion`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;


-- sgcm.tipo_parcela definition

CREATE TABLE `tipo_parcela` (
  `id_tipo` int NOT NULL AUTO_INCREMENT,
  `nombre_parcela` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci NOT NULL,
  PRIMARY KEY (`id_tipo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

-- sgcm.tipos_usuarios definition

CREATE TABLE `tipos_usuarios` (
  `id_tipo_usuario` int NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(100) COLLATE utf8mb4_spanish2_ci NOT NULL,
  PRIMARY KEY (`id_tipo_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;


-- sgcm.deudo definition

CREATE TABLE `deudo` (
  `id_deudo` int NOT NULL AUTO_INCREMENT,
  `dni` int DEFAULT NULL,
  `nombre` varchar(100) COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  `apellido` varchar(100) COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  `telefono` bigint DEFAULT NULL,
  `email` varchar(100) COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  `domicilio` varchar(100) COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  `localidad` varchar(100) COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  `codigo_postal` varchar(100) COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  PRIMARY KEY (`id_deudo`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

-- sgcm.usuarios definition

CREATE TABLE `usuarios` (
  `id_usuario` int NOT NULL AUTO_INCREMENT,
  `usuario` varchar(100) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `nombre` varchar(100) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `apellido` varchar(100) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `cargo` varchar(100) COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  `sector` varchar(100) COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  `contrasenia` varchar(100) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `id_tipo_usuario` int NOT NULL,
  `activo` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id_usuario`),
  KEY `usuarios_FK` (`id_tipo_usuario`),
  CONSTRAINT `usuarios_FK` FOREIGN KEY (`id_tipo_usuario`) REFERENCES `tipos_usuarios` (`id_tipo_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;


-- sgcm.difunto definition

CREATE TABLE `difunto` (
  `id_difunto` int NOT NULL AUTO_INCREMENT,
  `id_deudo` int NOT NULL,
  `nombre` varchar(100) COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  `apellido` varchar(100) COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  `dni` int DEFAULT NULL,
  `edad` int DEFAULT NULL,
  `fecha_fallecimiento` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `id_sexo` int DEFAULT NULL,
  `id_nacionalidad` int DEFAULT NULL,
  `id_estado_civil` int DEFAULT NULL,
  `domicilio` varchar(100) COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  `localidad` varchar(100) COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  `codigo_postal` varchar(100) COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  PRIMARY KEY (`id_difunto`),
  KEY `difunto_FK` (`id_deudo`),
  KEY `difunto_FK_2` (`id_sexo`),
  KEY `difunto_FK_3` (`id_estado_civil`),
  KEY `difunto_FK_1` (`id_nacionalidad`),
  CONSTRAINT `difunto_FK` FOREIGN KEY (`id_deudo`) REFERENCES `deudo` (`id_deudo`),
  CONSTRAINT `difunto_FK_1` FOREIGN KEY (`id_nacionalidad`) REFERENCES `nacionalidades` (`id_nacionalidad`),
  CONSTRAINT `difunto_FK_2` FOREIGN KEY (`id_sexo`) REFERENCES `sexo` (`id_sexo`),
  CONSTRAINT `difunto_FK_3` FOREIGN KEY (`id_estado_civil`) REFERENCES `estado_civil` (`id_estado_civil`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;


-- sgcm.parcela definition

CREATE TABLE `parcela` (
  `id_parcela` int NOT NULL AUTO_INCREMENT,
  `id_tipo` int NOT NULL,
  `id_deudo` int DEFAULT NULL,
  `numero_ubicacion` int DEFAULT NULL,
  `hilera` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  `seccion` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  `fraccion` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  `nivel` int DEFAULT NULL,
  `id_orientacion` int DEFAULT NULL,
  PRIMARY KEY (`id_parcela`),
  KEY `parcela_FK` (`id_tipo`),
  KEY `parcela_FK_1` (`id_deudo`),
  KEY `parcela_FK_2` (`id_orientacion`),
  CONSTRAINT `parcela_FK` FOREIGN KEY (`id_tipo`) REFERENCES `tipo_parcela` (`id_tipo`),
  CONSTRAINT `parcela_FK_1` FOREIGN KEY (`id_deudo`) REFERENCES `deudo` (`id_deudo`),
  CONSTRAINT `parcela_FK_2` FOREIGN KEY (`id_orientacion`) REFERENCES `orientacion` (`id_orientacion`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;


-- sgcm.pago definition

CREATE TABLE `pago` (
  `id_pago` int NOT NULL AUTO_INCREMENT,
  `id_deudo` int NOT NULL,
  `id_parcela` int NOT NULL,
  `fecha_pago` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `importe` int DEFAULT NULL,
  `recargo` int DEFAULT NULL,
  `total` int DEFAULT NULL,
  `id_usuario` int NOT NULL,
  PRIMARY KEY (`id_pago`),
  KEY `pago_FK` (`id_deudo`),
  KEY `pago_FK_1` (`id_parcela`),
  KEY `pago_FK_2` (`id_usuario`),
  CONSTRAINT `pago_FK` FOREIGN KEY (`id_deudo`) REFERENCES `deudo` (`id_deudo`),
  CONSTRAINT `pago_FK_1` FOREIGN KEY (`id_parcela`) REFERENCES `parcela` (`id_parcela`),
  CONSTRAINT `pago_FK_2` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;


-- sgcm.ubicacion_difunto definition

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;


