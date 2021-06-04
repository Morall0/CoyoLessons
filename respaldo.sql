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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `alumnohashorario`
--

LOCK TABLES `alumnohashorario` WRITE;
/*!40000 ALTER TABLE `alumnohashorario` DISABLE KEYS */;
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
  `id_materia` int(10) DEFAULT NULL,
  PRIMARY KEY (`id_asesoria`),
  KEY `id_materia` (`id_materia`),
  CONSTRAINT `asesoria_ibfk_1` FOREIGN KEY (`id_materia`) REFERENCES `materia` (`id_materia`)
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
  `nombre` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id_colegio`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `colegio`
--

LOCK TABLES `colegio` WRITE;
/*!40000 ALTER TABLE `colegio` DISABLE KEYS */;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `horario`
--

LOCK TABLES `horario` WRITE;
/*!40000 ALTER TABLE `horario` DISABLE KEYS */;
/*!40000 ALTER TABLE `horario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `materia`
--

DROP TABLE IF EXISTS `materia`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `materia` (
  `id_materia` int(10) NOT NULL,
  `Nombre` varchar(30) DEFAULT NULL,
  `id_colegio` int(2) DEFAULT NULL,
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
  `Correo` varchar(50) DEFAULT NULL,
  `Teléfono` bigint(10) DEFAULT NULL,
  `Nacimiento` date DEFAULT NULL,
  `Grado` enum('C','Q','S') DEFAULT NULL,
  `Strike` tinyint(4) DEFAULT NULL,
  `Contraseña` varchar(20) DEFAULT NULL,
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
/*!40000 ALTER TABLE `usuario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuariohasmateria`
--

DROP TABLE IF EXISTS `usuariohasmateria`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuariohasmateria` (
  `id_uhm` int(10) NOT NULL,
  `num_cuenta` bigint(9) DEFAULT NULL,
  `id_materia` int(10) DEFAULT NULL,
  PRIMARY KEY (`id_uhm`),
  KEY `num_cuenta` (`num_cuenta`),
  KEY `id_materia` (`id_materia`),
  CONSTRAINT `usuariohasmateria_ibfk_1` FOREIGN KEY (`num_cuenta`) REFERENCES `usuario` (`num_cuenta`),
  CONSTRAINT `usuariohasmateria_ibfk_2` FOREIGN KEY (`id_materia`) REFERENCES `materia` (`id_materia`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuariohasmateria`
--

LOCK TABLES `usuariohasmateria` WRITE;
/*!40000 ALTER TABLE `usuariohasmateria` DISABLE KEYS */;
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

-- Dump completed on 2021-06-04 12:08:38
