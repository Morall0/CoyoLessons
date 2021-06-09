-- MariaDB dump 10.19  Distrib 10.4.18-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: coyolessons
-- ------------------------------------------------------
-- Server version	10.4.18-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `alumnohashorario`
--

DROP TABLE IF EXISTS `alumnohashorario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `alumnohashorario` (
  `id_ahh` int(5) NOT NULL AUTO_INCREMENT,
  `num_cuenta` bigint(9) DEFAULT NULL,
  `id_horario` int(5) DEFAULT NULL,
  PRIMARY KEY (`id_ahh`),
  KEY `id_horario` (`id_horario`),
  KEY `num_cuenta` (`num_cuenta`),
  CONSTRAINT `alumnohashorario_ibfk_1` FOREIGN KEY (`id_horario`) REFERENCES `horario` (`id_horario`),
  CONSTRAINT `alumnohashorario_ibfk_2` FOREIGN KEY (`num_cuenta`) REFERENCES `usuario` (`num_cuenta`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `alumnohashorario`
--

LOCK TABLES `alumnohashorario` WRITE;
/*!40000 ALTER TABLE `alumnohashorario` DISABLE KEYS */;
INSERT INTO `alumnohashorario` VALUES (1,320110199,1);
/*!40000 ALTER TABLE `alumnohashorario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `alumnohasreporte`
--

DROP TABLE IF EXISTS `alumnohasreporte`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `alumnohasreporte` (
  `id_ahr` int(5) NOT NULL AUTO_INCREMENT,
  `num_cuenta` bigint(9) DEFAULT NULL,
  `id_reporte` int(5) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `motivo` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_ahr`),
  KEY `num_cuenta` (`num_cuenta`),
  KEY `id_reporte` (`id_reporte`),
  CONSTRAINT `alumnohasreporte_ibfk_1` FOREIGN KEY (`num_cuenta`) REFERENCES `usuario` (`num_cuenta`),
  CONSTRAINT `alumnohasreporte_ibfk_2` FOREIGN KEY (`id_reporte`) REFERENCES `tipo_reporte` (`id_reporte`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `alumnohasreporte`
--

LOCK TABLES `alumnohasreporte` WRITE;
/*!40000 ALTER TABLE `alumnohasreporte` DISABLE KEYS */;
/*!40000 ALTER TABLE `alumnohasreporte` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `asesoria`
--

DROP TABLE IF EXISTS `asesoria`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `asesoria` (
  `id_asesoria` int(10) NOT NULL AUTO_INCREMENT,
  `Medio` varchar(60) DEFAULT NULL,
  `Modalidad` enum('P','L') DEFAULT NULL,
  `Fecha` date DEFAULT NULL,
  `Duracion` int(3) DEFAULT NULL,
  `Tema` varchar(50) DEFAULT NULL,
  `id_materia` varchar(4) DEFAULT NULL,
  `id_ahh` int(5) DEFAULT NULL,
  PRIMARY KEY (`id_asesoria`),
  KEY `id_materia` (`id_materia`),
  KEY `id_ahh` (`id_ahh`),
  CONSTRAINT `asesoria_ibfk_1` FOREIGN KEY (`id_materia`) REFERENCES `materia` (`id_materia`),
  CONSTRAINT `asesoria_ibfk_2` FOREIGN KEY (`id_ahh`) REFERENCES `alumnohashorario` (`id_ahh`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `asesoria`
--

LOCK TABLES `asesoria` WRITE;
/*!40000 ALTER TABLE `asesoria` DISABLE KEYS */;
/*!40000 ALTER TABLE `asesoria` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `asesoriahasalumno`
--

DROP TABLE IF EXISTS `asesoriahasalumno`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `asesoriahasalumno` (
  `id_uha` int(10) NOT NULL AUTO_INCREMENT,
  `id_asesoria` int(10) DEFAULT NULL,
  `num_cuentaAsesor` bigint(9) DEFAULT NULL,
  `num_cuentaAlumno` bigint(9) DEFAULT NULL,
  PRIMARY KEY (`id_uha`),
  KEY `id_asesoria` (`id_asesoria`),
  KEY `num_cuentaAsesor` (`num_cuentaAsesor`),
  KEY `num_cuentaAlumno` (`num_cuentaAlumno`),
  CONSTRAINT `asesoriahasalumno_ibfk_1` FOREIGN KEY (`id_asesoria`) REFERENCES `asesoria` (`id_asesoria`),
  CONSTRAINT `asesoriahasalumno_ibfk_2` FOREIGN KEY (`num_cuentaAsesor`) REFERENCES `usuario` (`num_cuenta`),
  CONSTRAINT `asesoriahasalumno_ibfk_3` FOREIGN KEY (`num_cuentaAlumno`) REFERENCES `usuario` (`num_cuenta`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `asesoriahasalumno`
--

LOCK TABLES `asesoriahasalumno` WRITE;
/*!40000 ALTER TABLE `asesoriahasalumno` DISABLE KEYS */;
/*!40000 ALTER TABLE `asesoriahasalumno` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `colegio`
--

DROP TABLE IF EXISTS `colegio`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `colegio` (
  `id_colegio` int(2) NOT NULL,
  `nombre` varchar(40) DEFAULT NULL,
  PRIMARY KEY (`id_colegio`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `colegio`
--

LOCK TABLES `colegio` WRITE;
/*!40000 ALTER TABLE `colegio` DISABLE KEYS */;
INSERT INTO `colegio` VALUES (1,'EDUCACIÓN FÍSICA'),(2,'EDUCACIÓN ESTÉTICA Y ARTÍSTICA'),(3,'MORFOFISIOLOGÍA'),(4,'BIOLOGÍA'),(5,'CIENCIAS SOCIALES'),(6,'DIBUJO'),(7,'FILOSOFÍA'),(8,'FÍSICA'),(9,'GEOGRAFÍA'),(10,'HISTORIA'),(11,'LENGUAS VIVAS'),(12,'LETRAS CLÁSICAS'),(13,'LITERATURA'),(14,'MATEMÁTICAS'),(15,'PSICOLOGÍA'),(16,'QUÍMICA'),(17,'INFORMÁTICA'),(18,'OPCIONES TÉCNICAS'),(19,'ORIENTACIÓN'),(20,'CÓMPUTO');
/*!40000 ALTER TABLE `colegio` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `comentario`
--

DROP TABLE IF EXISTS `comentario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `comentario` (
  `id_comentario` int(10) NOT NULL AUTO_INCREMENT,
  `num_cuentaAsesor` bigint(9) DEFAULT NULL,
  `num_cuentaAlumno` bigint(9) DEFAULT NULL,
  `Calificacion` int(1) DEFAULT NULL,
  `Comentario` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_comentario`),
  KEY `num_cuentaAsesor` (`num_cuentaAsesor`),
  KEY `num_cuentaAlumno` (`num_cuentaAlumno`),
  CONSTRAINT `comentario_ibfk_1` FOREIGN KEY (`num_cuentaAsesor`) REFERENCES `usuario` (`num_cuenta`),
  CONSTRAINT `comentario_ibfk_2` FOREIGN KEY (`num_cuentaAlumno`) REFERENCES `usuario` (`num_cuenta`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comentario`
--

LOCK TABLES `comentario` WRITE;
/*!40000 ALTER TABLE `comentario` DISABLE KEYS */;
/*!40000 ALTER TABLE `comentario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hora`
--

DROP TABLE IF EXISTS `hora`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `hora` (
  `id_hora` int(5) NOT NULL,
  `hora` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id_hora`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hora`
--

LOCK TABLES `hora` WRITE;
/*!40000 ALTER TABLE `hora` DISABLE KEYS */;
INSERT INTO `hora` VALUES (1,'7:50-840\r'),(2,'8:40-9:30\r'),(3,'9:30-10:20\r'),(4,'10:20-11:10\r'),(5,'11:10-12:00\r'),(6,'12:00-12:50\r'),(7,'12:50-13:40\r'),(8,'13:40-14:30\r'),(9,'14:30-15:20\r'),(10,'15:20-16:10\r'),(11,'16:10-17:00'),(12,'17:00-17:50\r'),(13,'17:50-18:40\r'),(14,'18:40-19:30');
/*!40000 ALTER TABLE `hora` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `horario`
--

DROP TABLE IF EXISTS `horario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `horario` (
  `id_horario` int(5) NOT NULL AUTO_INCREMENT,
  `id_hora` int(5) DEFAULT NULL,
  `dia` enum('L','Ma','Mi','J','V') DEFAULT NULL,
  PRIMARY KEY (`id_horario`),
  KEY `id_hora` (`id_hora`),
  CONSTRAINT `horario_ibfk_1` FOREIGN KEY (`id_hora`) REFERENCES `hora` (`id_hora`)
) ENGINE=InnoDB AUTO_INCREMENT=76 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `horario`
--

LOCK TABLES `horario` WRITE;
/*!40000 ALTER TABLE `horario` DISABLE KEYS */;
INSERT INTO `horario` VALUES (1,1,'L'),(2,2,'L'),(3,3,'L'),(4,4,'L'),(5,5,'L'),(6,6,'L'),(7,7,'L'),(8,8,'L'),(9,9,'L'),(10,10,'L'),(11,11,'L'),(12,12,'L'),(13,13,'L'),(14,14,'L'),(15,1,'Ma'),(16,2,'Ma'),(17,3,'Ma'),(18,4,'Ma'),(19,5,'Ma'),(20,6,'Ma'),(21,7,'Ma'),(22,8,'Ma'),(23,9,'Ma'),(24,10,'Ma'),(25,11,'Ma'),(26,12,'Ma'),(27,13,'Ma'),(28,14,'Ma'),(29,1,'Mi'),(30,2,'Mi'),(31,3,'Mi'),(33,4,'Mi'),(34,5,'Mi'),(35,6,'Mi'),(36,7,'Mi'),(37,8,'Mi'),(38,9,'Mi'),(39,10,'Mi'),(40,11,'Mi'),(41,12,'Mi'),(42,13,'Mi'),(43,14,'Mi'),(44,1,'J'),(45,2,'J'),(46,3,'J'),(47,4,'J'),(48,5,'J'),(49,6,'J'),(50,7,'J'),(51,8,'J'),(52,9,'J'),(53,10,'J'),(54,11,'J'),(55,12,'J'),(56,13,'J'),(57,14,'J'),(58,1,'V'),(59,2,'V'),(60,3,'V'),(61,4,'V'),(62,5,'V'),(63,6,'V'),(64,7,'V'),(65,8,'V'),(66,9,'V'),(67,10,'V'),(68,11,'V'),(69,12,'V'),(70,13,'V'),(71,14,'V');
/*!40000 ALTER TABLE `horario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `materia`
--

DROP TABLE IF EXISTS `materia`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `materia` (
  `id_materia` varchar(4) NOT NULL,
  `Nombre` varchar(30) DEFAULT NULL,
  `id_colegio` int(2) DEFAULT NULL,
  `abreviacion` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id_materia`),
  KEY `id_colegio` (`id_colegio`),
  CONSTRAINT `materia_ibfk_1` FOREIGN KEY (`id_colegio`) REFERENCES `colegio` (`id_colegio`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `materia`
--

LOCK TABLES `materia` WRITE;
/*!40000 ALTER TABLE `materia` DISABLE KEYS */;
INSERT INTO `materia` VALUES ('1400','MATEMATICAS IV',14,'MATEM. IV'),('1401','FISICA III',8,'FIS. III'),('1402','LENGUA ESPAÑOLA',13,'L. ESPAÑ.'),('1403','HISTORIA UNIVERSAL III',10,'H.UNI.III'),('1404','LOGICA',7,'LOGICA'),('1405','GEOGRAFIA',9,'GEOGRAFIA'),('1406','DIBUJO II',6,'DIBUJO II'),('1407','LENGUA EXTRAN. INGLES IV',11,'L.E.I. IV'),('1408','LENGUA EXTRAN. FRANCES IV',11,'L.E.F. IV'),('1409','ED. ESTETICA-ARTISTICA IV',2,'E.E.A. IV'),('1410','EDUCACION FISICA IV',1,'E.F. IV'),('1411','ORIENTACION EDUCATIVA IV',19,'O.EDU. IV'),('1412','INFORMATICA',17,'INFORMAT.'),('1500','MATEMATICAS V',14,'MATEM. V'),('1501','QUIMICA III',16,'QUIM. III'),('1502','BIOLOGIA IV',4,'BIOL. IV'),('1503','EDUCACION PARA LA SALUD',3,'E. SALUD'),('1504','HISTORIA DE MEXICO II',10,'H. MEXICO'),('1505','ETIMOLOGIAS GRECOLATINAS',12,'E. GREC.'),('1506','L. EXTRANJERA INGLES V',11,'L.E.I. V'),('1507','L. EXTRANJERA FRANCES V',11,'L.E.F. V'),('1508','L. EXTRANJERA ITALIANO I',11,'L.E.IT. I'),('1509','L. EXTRANJERA ALEMAN I',11,'L.E.A. I'),('1510','L. EXTRANJERA INGLES I',11,'L.E.I. I'),('1511','L. EXTRANJERA FRANCES I',11,'L.E.F. I'),('1512','ETICA',7,'ETICA'),('1513','EDUCACION FISICA V',1,'E.F. V'),('1514','ED. ESTETICA-ARTISTICA V',2,'E.E.A. V'),('1515','ORIENTACION EDUCATIVA V',19,'O.ED. V'),('1516','LITERATURA UNIVERSAL',13,'LIT. UNI.'),('1600','MATEMATICAS VI AREA I Y II',14,'MATEM. VI'),('1601','DERECHO',5,'DERECHO'),('1602','LITERATURA MEX. E IB.',13,'LIT. MEX.'),('1603','INGLES VI',11,'INGLES VI'),('1604','FRANCES VI',11,'FRANC. VI'),('1605','ALEMAN II',11,'ALEMAN II'),('1606','ITALIANO II',11,'ITAL. II'),('1607','INGLES II',11,'INGLES II'),('1608','FRANCES II',11,'FRANC. II'),('1609','PSICOLOGIA',15,'PSIC.'),('1610','DIBUJO CONSTRUCTIVO II',6,'D. C. II'),('1611','FISICA IV AREA I',8,'FISICA IV'),('1612','QUIMICA IV AREA I',16,'QUIM. IV'),('1613','BIOLOGIA V',4,'BIOL. V'),('1614','GEOGRAFIA ECONOMICA',9,'GEOG. ECO'),('1615','INT. AL EST. C. S. Y ECO.',5,'INT. EST.'),('1616','PROBS. SOC. Y POL. Y ECO.',5,'PROB. SOC'),('1617','HISTORIA DE LA CULTURA',10,'H. CULT.'),('1618','HISTORIA DE LAS DOC. FIL.',7,'H DOC FIL'),('1619','MATEMATICAS VI AREA III',14,'MATE VI'),('1620','MATEMATICAS VI AREA IV',14,'MATE VI'),('1621','FISICA IV AREA II',8,'FISICA IV'),('1622','QUIMICA IV AREA II',16,'QUIM. IV'),('1700','HIGIENE MENTAL',15,'HIG. MENT'),('1703','REVOLUCION MEXICANA',10,'REV. MEX.'),('1704','CONT. Y GEST. ADMINISTRAT',5,'CONT GEST'),('1705','PENS. FILOSOFICO EN MEXIC',5,'PENS FIL.'),('1706','GEOLOGIA Y MINEROLOGIA',9,'GEOLOGIA'),('1707','GEOGRAFIA POLITICA',9,'GEOG POL.'),('1708','MODELADO II',6,'MODEL II'),('1709','FISICO-QUIMICA',8,'FIS-QUIM.'),('1710','TEMAS SELECTOS DE MATEM.',14,'T S MATE.'),('1711','TEMAS SELECTOS DE BIOLOG.',4,'T S BIOL.'),('1712','ESTADISTICA Y PROBABILID.',14,'EST. PROB'),('1713','LATIN',12,'LATIN'),('1714','GRIEGO',12,'GRIEGO'),('1715','COMUNICACION VISUAL',6,'COM. VIS.'),('1716','TEMAS SEL. MORFOL. Y FIS.',3,'T S MORFO'),('1717','ESTETICA',7,'ESTETICA'),('1718','HISTORIA DEL ARTE',10,'H. ARTE'),('1719','INFORMAT. APLI. C. E IND.',17,'INF. APLI'),('1720','SOCIOLOGIA',5,'SOCIOLOG.'),('1721','COSMOGRAFÍA',8,'COSMO'),('1723','ASTRONOMIA',8,'ASTRONOM.'),('2101','O. T. COMPUTACION V',18,'O.T.COMP1'),('2122','O.T. CONTABILIDAD',18,'O.T.CONTA'),('2201','O. T. COMPUTACION VI',18,'O.T.COMP2'),('2225','O. T. ENSEÑANZA DE INGLES',18,'O.T. ING'),('2226','O.T. HISTOPATOLOGÍA',18,'O.T. HIST'),('E101','FOTOGRAFÍA',2,'FOTO'),('E102','PINTURA',2,'PINTURA'),('E103','ESCULTURA',2,'ESCULTURA'),('E104','GRABADO',2,'GRABADO'),('E105','CERÁMICA',2,'CERÁMICA'),('E106','DANZA CLÁSICA',2,'D. CLÁSIC'),('E107','DANZA CONTEMPORÁNEA',2,'D. CONTEM'),('E108','DANZA ESPAÑOLA',2,'D. ESPAÑO'),('E109','DANZA REGIONAL',2,'D. REGNAL'),('E110','BANDA',2,'BANDA'),('E111','CORO',2,'CORO'),('E112','CLARINETE',2,'CLARINETE'),('E113','FLAUTA',2,'FLAUTA'),('E114','GUITARRA',2,'GUITARRA'),('E115','ESTUDIANTINA',2,'ESTUDTINA'),('E116','PIANO',2,'PIANO'),('E117','SAXOFÓN',2,'SAXOFÓN'),('E118','TROMPETA',2,'TROMPETA'),('E119','ORATORIA',2,'ORATORIA'),('E120','TEATRO',2,'TEATRO'),('E121','CINE',2,'CINE');
/*!40000 ALTER TABLE `materia` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipo_reporte`
--

DROP TABLE IF EXISTS `tipo_reporte`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tipo_reporte` (
  `id_reporte` int(5) NOT NULL,
  `nombre` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_reporte`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipo_reporte`
--

LOCK TABLES `tipo_reporte` WRITE;
/*!40000 ALTER TABLE `tipo_reporte` DISABLE KEYS */;
/*!40000 ALTER TABLE `tipo_reporte` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuario`
--

DROP TABLE IF EXISTS `usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuario` (
  `num_cuenta` bigint(9) NOT NULL,
  `Nombre` varchar(50) DEFAULT NULL,
  `Correo` varchar(100) DEFAULT NULL,
  `Teléfono` varchar(100) DEFAULT NULL,
  `Nacimiento` date DEFAULT NULL,
  `Grado` enum('C','Q','S') DEFAULT NULL,
  `Strike` tinyint(4) DEFAULT NULL,
  `Contraseña` varchar(100) DEFAULT NULL,
  `Paleta` enum('B','N') DEFAULT NULL,
  `Tipo` enum('E','A') DEFAULT NULL,
  `Imagen` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`num_cuenta`),
  UNIQUE KEY `Teléfono` (`Teléfono`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuario`
--

LOCK TABLES `usuario` WRITE;
/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
INSERT INTO `usuario` VALUES (320110199,'Melissa Natalia Archundia Tapia','f7uGNM8joRQD5DWJXli3oGiz8X3YJc82dWq9/j92Ow+v3moToOEvrw6o7rDub+eD','X1HzLoOqhYvD+S/2Ugwuu+KcMB/TIUu3g378jfcbpOc=','2004-03-19','Q',0,'$2y$10$yKCLU8Uc9/.wrbFMHxiHXe1pnUV.aAzCHWTfZIJGG5NcFOyfwcGV2rpOOV','B','E','user.png');
/*!40000 ALTER TABLE `usuario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuariohasmateria`
--

DROP TABLE IF EXISTS `usuariohasmateria`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuariohasmateria` (
  `id_uhm` int(10) NOT NULL AUTO_INCREMENT,
  `num_cuenta` bigint(9) DEFAULT NULL,
  `id_materia` varchar(4) DEFAULT NULL,
  PRIMARY KEY (`id_uhm`),
  KEY `num_cuenta` (`num_cuenta`),
  KEY `id_materia` (`id_materia`),
  CONSTRAINT `usuariohasmateria_ibfk_1` FOREIGN KEY (`num_cuenta`) REFERENCES `usuario` (`num_cuenta`),
  CONSTRAINT `usuariohasmateria_ibfk_2` FOREIGN KEY (`id_materia`) REFERENCES `materia` (`id_materia`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuariohasmateria`
--

LOCK TABLES `usuariohasmateria` WRITE;
/*!40000 ALTER TABLE `usuariohasmateria` DISABLE KEYS */;
INSERT INTO `usuariohasmateria` VALUES (1,320110199,'1400');
/*!40000 ALTER TABLE `usuariohasmateria` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2021-06-09  1:09:21
