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
-- Create schema db_pir
--

CREATE DATABASE IF NOT EXISTS db_pir;
USE db_pir;

--
-- Definition of table `plu_ed_campos`
--

DROP TABLE IF EXISTS `plu_ed_campos`;
CREATE TABLE `plu_ed_campos` (
  `idt` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `codigo` varchar(45) NOT NULL,
  `descricao` varchar(120) NOT NULL,
  `idt_tipo` int(10) unsigned NOT NULL,
  `detalhe` text,
  `tamanho` int(10) unsigned NOT NULL,
  `qtd_decimal` int(10) unsigned DEFAULT NULL,
  `mascara` varchar(120) DEFAULT NULL,
  `idt_natureza` int(10) unsigned NOT NULL,
  PRIMARY KEY (`idt`),
  UNIQUE KEY `iu_plu_ed_campos` (`codigo`),
  KEY `FK_plu_ed_campos_1` (`idt_tipo`),
  KEY `FK_plu_ed_campos_2` (`idt_natureza`),
  CONSTRAINT `FK_plu_ed_campos_1` FOREIGN KEY (`idt_tipo`) REFERENCES `plu_ed_campos_tipo` (`idt`) ON UPDATE CASCADE,
  CONSTRAINT `FK_plu_ed_campos_2` FOREIGN KEY (`idt_natureza`) REFERENCES `plu_ed_campo_natureza` (`idt`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `plu_ed_campos`
--

/*!40000 ALTER TABLE `plu_ed_campos` DISABLE KEYS */;
INSERT INTO `plu_ed_campos` (`idt`,`codigo`,`descricao`,`idt_tipo`,`detalhe`,`tamanho`,`qtd_decimal`,`mascara`,`idt_natureza`) VALUES 
 (1,'codigo','Representa genericamente',1,'teste de detalhe para o campo',45,NULL,'444.444.444',2),
 (2,'data_nascimento','data de nascimento',5,'estrutura para armazenar a data de nascimento de uma pessoa',10,NULL,NULL,1),
 (3,'CEP','Código do CEP',5,NULL,10,NULL,NULL,6),
 (4,'DATA_REGISTRO_ID','DATA DE REGISTRO DE CARTEIRA',5,NULL,10,NULL,NULL,1);
/*!40000 ALTER TABLE `plu_ed_campos` ENABLE KEYS */;




/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
