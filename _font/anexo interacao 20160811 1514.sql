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
-- Definition of table `plu_helpdesk_anexo`
--

DROP TABLE IF EXISTS `plu_helpdesk_anexo`;
CREATE TABLE `plu_helpdesk_anexo` (
  `idt` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idt_helpdesk` int(10) unsigned NOT NULL,
  `descricao` varchar(120) NOT NULL,
  `observacao` text,
  `idt_responsavel` int(11) NOT NULL,
  `data_responsavel` datetime NOT NULL,
  `arquivo` varchar(120) NOT NULL,
  PRIMARY KEY (`idt`),
  KEY `iu_plu_helpdesk_anexo` (`idt_helpdesk`,`descricao`),
  KEY `FK_plu_helpdesk_anexo_2` (`idt_responsavel`),
  CONSTRAINT `FK_plu_helpdesk_anexo_1` FOREIGN KEY (`idt_helpdesk`) REFERENCES `plu_helpdesk` (`idt`) ON UPDATE CASCADE,
  CONSTRAINT `FK_plu_helpdesk_anexo_2` FOREIGN KEY (`idt_responsavel`) REFERENCES `plu_usuario` (`id_usuario`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `plu_helpdesk_anexo`
--

/*!40000 ALTER TABLE `plu_helpdesk_anexo` DISABLE KEYS */;
INSERT INTO `plu_helpdesk_anexo` (`idt`,`idt_helpdesk`,`descricao`,`observacao`,`idt_responsavel`,`data_responsavel`,`arquivo`) VALUES 
 (3,5,'erererer',NULL,1,'2016-06-14 21:03:00','3_arquivo_023_migraram-com-problemas.xls'),
 (4,5,'xxx','xcxcxcxc',1,'2016-06-14 21:12:00','4_arquivo_588_nao-sao-credenciados.csv'),
 (5,13,'Teste','Teste grande',1,'2016-06-14 23:24:00','5_arquivo_521_image.jpg'),
 (6,30,'teste de anexo','teste de anexo',1,'2016-06-16 16:21:00','6_arquivo_921_sgteccredenciados-2.xls'),
 (7,39,'teste do arquivo','observação detalhada',1,'2016-06-16 21:47:00','7_arquivo_510_profissionais-que-migraram-gc.csv'),
 (8,39,'rrrrrrrrrrr','rrrrrrrrrrrrrrr',1,'2016-06-16 21:48:00','8_arquivo_531_sgc-lista-de-credenciados-99.xls'),
 (9,40,'xxxxxxxxxxxxxx','xxxxxxxxxxxxxxxxxxxxxxxx',1,'2016-06-16 21:53:00','9_arquivo_825_sgteccredenciados-2.xls'),
 (10,40,'xcxcxcxcxc','xcxcxcxc',1,'2016-06-16 21:53:00','10_arquivo_844_sgc-lista-de-credenciados-99.xls'),
 (11,41,'Teste arq',NULL,1,'2016-06-16 22:02:00','11_arquivo_396_image.jpg'),
 (12,48,'teste',NULL,98,'2016-06-20 16:11:00','12_arquivo_898_topo.jpg'),
 (13,80,'Tttttttttttttt','Tem tudo aqui',1,'2016-08-11 06:49:00','13_arquivo_105_image.jpeg');
/*!40000 ALTER TABLE `plu_helpdesk_anexo` ENABLE KEYS */;




/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
