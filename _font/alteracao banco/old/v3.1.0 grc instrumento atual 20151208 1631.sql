-- MySQL Administrator dump 1.4
--
-- ------------------------------------------------------
-- Server version	5.5.33


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
-- Definition of table `grc_atendimento_instrumento`
--

DROP TABLE IF EXISTS `grc_atendimento_instrumento`;
CREATE TABLE `grc_atendimento_instrumento` (
  `idt` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `codigo` varchar(45) NOT NULL,
  `codigo_siacweb` varchar(45) DEFAULT NULL,
  `codigo_sge` varchar(45) DEFAULT NULL,
  `nivel` int(10) unsigned NOT NULL DEFAULT '2',
  `descricao` varchar(120) NOT NULL,
  `descricao_siacweb` varchar(120) DEFAULT NULL,
  `ativo` varchar(1) NOT NULL DEFAULT 'S',
  `detalhe` text,
  `idt_atendimento_instrumento` int(10) unsigned DEFAULT NULL,
  `balcao` char(1) DEFAULT 'N',
  PRIMARY KEY (`idt`),
  UNIQUE KEY `iu_grc_atendimento_instrumento` (`codigo`),
  KEY `FK_grc_atendimento_instrumento_1` (`idt_atendimento_instrumento`) USING BTREE,
  CONSTRAINT `FK_grc_atendimento_instrumento_1` FOREIGN KEY (`idt_atendimento_instrumento`) REFERENCES `grc_instrumento` (`idt`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `grc_atendimento_instrumento`
--

/*!40000 ALTER TABLE `grc_atendimento_instrumento` DISABLE KEYS */;
INSERT INTO `grc_atendimento_instrumento` (`idt`,`codigo`,`codigo_siacweb`,`codigo_sge`,`nivel`,`descricao`,`descricao_siacweb`,`ativo`,`detalhe`,`idt_atendimento_instrumento`,`balcao`) VALUES 
 (1,'OF.31','31','35',2,'Oficina','Oficina','S',NULL,6,'N'),
 (2,'CO.1','1','02',2,'CONSULTORIA','Consultoria Presencial','S',NULL,3,'S'),
 (3,'MC.35','35','30',2,'Missão e Caravana','Missão/Caravana','S',NULL,8,'N'),
 (4,'PA.30','30','33',2,'Palestra','Palestra','S',NULL,5,'N'),
 (5,'FE.33','33','31',2,'Feiras','Feira','S',NULL,9,'N'),
 (6,'RO.37','37','32',2,'Rodada','Rodada de Negócios','S',NULL,10,'N'),
 (7,'CS.3','3','01',2,'CURSO','Cursos Presenciais','S',NULL,4,'N'),
 (8,'IG.23','23','05',2,'INFORMAÇÃO','Informação Presencial','S',NULL,1,'S'),
 (9,'PA.21','21','23',2,'PALESTRA, OFICINA, SEMINÁRIO','Palestras, Oficinas, Seminários Presenciais','N',NULL,NULL,'N'),
 (10,'PE.29','29','25',2,'PROMOÇÃO E ACESSO A EVENTOS DO SEBRAE','Promoção e Acesso a Eventos do Sebrae','N',NULL,NULL,'N'),
 (11,'AE.28','28','27',2,'ACESSO A EVENTOS PROMOVIDOS POR TERCEIROS','Acesso a Eventos Promovidos por Terceiros','N',NULL,NULL,'N'),
 (12,'03',NULL,'03',2,'Eventos Patrocinados',NULL,'N',NULL,NULL,'N'),
 (13,'IT.18','18','24',2,'ORIENTAÇÃO TÉCNICA','Orientação Técnica Presencial','S',NULL,2,'S'),
 (14,'SM.32','32','34',2,'Seminário','Seminário','S',NULL,7,'N'),
 (15,'CO.2','2',NULL,2,'Consultoria a Distância','Consultoria a Distância','S',NULL,NULL,'N'),
 (16,'CS.4','4',NULL,2,'Cursos a Distância','Cursos a Distância','S',NULL,NULL,'N'),
 (17,'PA.5','5',NULL,2,'Palestras, oficinas, encontros, sem. Presenciais','Palestras, oficinas, encontros, sem. Presenciais','N',NULL,NULL,'N'),
 (18,'PA.6','6',NULL,2,'Palestras, oficinas, encontros, sem. a Distância','Palestras, oficinas, encontros, sem. a Distância','N',NULL,NULL,'N'),
 (19,'IG.7','7',NULL,2,'Informação Geral de Interesse Emp. Presencial','Informação Geral de Interesse Emp. Presencial','N',NULL,NULL,'N'),
 (20,'IG.8','8',NULL,2,'Informação Geral de Interesse Emp. a Distância','Informação Geral de Interesse Emp. a Distância','N',NULL,NULL,'N'),
 (21,'IG.9','9',NULL,2,'Informação de Interesse Emp. Presencial','Informação de Interesse Emp. Presencial','N',NULL,NULL,'N'),
 (22,'IG.10','10',NULL,2,'Informação de Interesse Emp. a Distância','Informação de Interesse Emp. a Distância','N',NULL,NULL,'N'),
 (23,'AE.11','11',NULL,2,'Promoção e acesso a eventos de mercado','Promoção e acesso a eventos de mercado','N',NULL,NULL,'N'),
 (24,'PE.12','12',NULL,2,'Promoção a eventos de mercado','Promoção a eventos de mercado','N',NULL,NULL,'N'),
 (25,'AE.13','13',NULL,2,'Acesso a eventos de mercado','Acesso a eventos de mercado','N',NULL,NULL,'N'),
 (26,'IT.14','14',NULL,2,'Orientação Presencial','Orientação Presencial','N',NULL,NULL,'N'),
 (27,'IT.15','15',NULL,2,'Orientação a Distância','Orientação a Distância','N',NULL,NULL,'N'),
 (28,'IG.16','16',NULL,2,'Informação Técnica Presencial','Informação Técnica Presencial','N',NULL,NULL,'N'),
 (29,'IG.17','17',NULL,2,'Informação Técnica a Distância','Informação Técnica a Distância','N',NULL,NULL,'N'),
 (30,'IT.19','19',NULL,2,'Orientação Técnica a Distância','Orientação Técnica a Distância','S',NULL,NULL,'N'),
 (31,'IG.20','20',NULL,2,'Informação','Informação','N',NULL,NULL,'N'),
 (32,'PA.22','22',NULL,2,'Palestras, Oficinas, Seminários a Distância','Palestras, Oficinas, Seminários a Distância','N',NULL,NULL,'N'),
 (33,'IG.24','24',NULL,2,'Informação a Distância','Informação a Distância','S',NULL,NULL,'N'),
 (34,'FP.25','25',NULL,2,'Garantia FAMPE','Garantia FAMPE','S',NULL,NULL,'N'),
 (35,'AE.26','26',NULL,2,'Acesso a eventos','Acesso a eventos','N',NULL,NULL,'N'),
 (36,'PE.27','27',NULL,2,'Promoção de eventos','Promoção de eventos','N',NULL,NULL,'N'),
 (37,'FE.34','34',NULL,2,'Registro Obsoleto','Registro Obsoleto','N',NULL,NULL,'N'),
 (38,'MC.36','36',NULL,2,'Registro Obsoleto','Registro Obsoleto','N',NULL,NULL,'N'),
 (39,'CO',NULL,NULL,1,'Consultoria',NULL,'S',NULL,NULL,'N'),
 (40,'CS',NULL,NULL,1,'Curso',NULL,'S',NULL,NULL,'N'),
 (41,'FE',NULL,NULL,1,'Feira',NULL,'S',NULL,NULL,'N'),
 (42,'FP',NULL,NULL,1,'FAMPE',NULL,'S',NULL,NULL,'N'),
 (43,'IG',NULL,NULL,1,'Informação',NULL,'S',NULL,NULL,'N'),
 (44,'IT',NULL,NULL,1,'Orientação Técnica',NULL,'S',NULL,NULL,'N'),
 (45,'MC',NULL,NULL,1,'Missão e Caravana',NULL,'S',NULL,NULL,'N'),
 (46,'OF',NULL,NULL,1,'Oficina',NULL,'S',NULL,NULL,'N'),
 (47,'PA',NULL,NULL,1,'Palestra',NULL,'S',NULL,NULL,'N'),
 (48,'RO',NULL,NULL,1,'Rodada',NULL,'S',NULL,NULL,'N'),
 (49,'SM',NULL,NULL,1,'Seminário',NULL,'S',NULL,NULL,'N');
/*!40000 ALTER TABLE `grc_atendimento_instrumento` ENABLE KEYS */;




/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
