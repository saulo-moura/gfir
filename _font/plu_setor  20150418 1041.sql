-- MySQL Administrator dump 1.4
--
-- ------------------------------------------------------
-- Server version	5.1.30-community-log


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


--
-- Create schema db_oas_pco_producao8
--

CREATE DATABASE IF NOT EXISTS db_oas_pco_producao8;
USE db_oas_pco_producao8;

--
-- Definition of table `setor`
--

DROP TABLE IF EXISTS `setor`;
CREATE TABLE `setor` (
  `idt` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `codigo` varchar(45) NOT NULL,
  `descricao` varchar(120) NOT NULL,
  PRIMARY KEY (`idt`),
  UNIQUE KEY `iu_setor_codigo` (`codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `setor`
--

/*!40000 ALTER TABLE `setor` DISABLE KEYS */;
INSERT INTO `setor` (`idt`,`codigo`,`descricao`) VALUES 
 (2,'TI','Apoio TI'),
 (3,'SC','Setor de Controle'),
 (4,'Obra','Obra'),
 (5,'Fin','Financeiro'),
 (6,'Jur','Jurídico'),
 (7,'QSMA','QSMA'),
 (8,'ORÇ','Orçamento'),
 (9,'SUP','Suprimentos'),
 (10,'PROJ','Projetos');
/*!40000 ALTER TABLE `setor` ENABLE KEYS */;




/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
