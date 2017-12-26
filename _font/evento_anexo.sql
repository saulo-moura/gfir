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
-- Definition of table `grc_evento_anexo`
--

DROP TABLE IF EXISTS `grc_evento_anexo`;
CREATE TABLE `grc_evento_anexo` (
  `idt` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idt_evento` int(10) unsigned NOT NULL,
  `descricao` varchar(120) NOT NULL,
  `observacao` text,
  `idt_responsavel` int(11) NOT NULL,
  `data_responsavel` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `arquivo` varchar(120) NOT NULL,
  PRIMARY KEY (`idt`),
  KEY `iu_grc_evento_anexo` (`idt_evento`,`descricao`),
  KEY `FK_grc_evento_anexo_2` (`idt_responsavel`),
  CONSTRAINT `FK_grc_evento_anexo_1` FOREIGN KEY (`idt_evento`) REFERENCES `grc_evento` (`idt`) ON DELETE CASCADE,
  CONSTRAINT `FK_grc_evento_anexo_2` FOREIGN KEY (`idt_responsavel`) REFERENCES `plu_usuario` (`id_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `grc_evento_anexo`
--

/*!40000 ALTER TABLE `grc_evento_anexo` DISABLE KEYS */;
/*!40000 ALTER TABLE `grc_evento_anexo` ENABLE KEYS */;




/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
