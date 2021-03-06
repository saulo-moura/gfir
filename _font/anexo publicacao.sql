-- MySQL Administrator dump 1.4
--
-- ------------------------------------------------------
-- Server version	5.6.25-log


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


--
-- Create schema db_pir_grc
--

CREATE DATABASE IF NOT EXISTS db_pir_grc;
USE db_pir_grc;

--
-- Definition of table `grc_evento_publicacao_canal`
--

DROP TABLE IF EXISTS `grc_evento_publicacao_canal`;
CREATE TABLE `grc_evento_publicacao_canal` (
  `idt` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idt_evento_publicacao` int(10) unsigned NOT NULL,
  `idt_canal_inscricao` int(10) unsigned NOT NULL,
  `quantidade_inscrito` int(10) unsigned NOT NULL,
  PRIMARY KEY (`idt`),
  UNIQUE KEY `iu_grc_evento_publicacao_canal` (`idt_evento_publicacao`,`idt_canal_inscricao`),
  KEY `FK_grc_evento_publicacao_canal_2` (`idt_canal_inscricao`),
  CONSTRAINT `FK_grc_evento_publicacao_canal_1` FOREIGN KEY (`idt_evento_publicacao`) REFERENCES `grc_evento_publicacao` (`idt`) ON DELETE CASCADE,
  CONSTRAINT `FK_grc_evento_publicacao_canal_2` FOREIGN KEY (`idt_canal_inscricao`) REFERENCES `grc_evento_canal_inscricao` (`idt`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `grc_evento_publicacao_canal`
--

/*!40000 ALTER TABLE `grc_evento_publicacao_canal` DISABLE KEYS */;
INSERT INTO `grc_evento_publicacao_canal` (`idt`,`idt_evento_publicacao`,`idt_canal_inscricao`,`quantidade_inscrito`) VALUES 
 (1,3,1,12);
/*!40000 ALTER TABLE `grc_evento_publicacao_canal` ENABLE KEYS */;




/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
