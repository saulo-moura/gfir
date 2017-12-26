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
-- Definition of table `grc_avaliacao`
--

DROP TABLE IF EXISTS `grc_avaliacao`;
CREATE TABLE `grc_avaliacao` (
  `idt` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `codigo` varchar(45) NOT NULL,
  `descricao` varchar(120) DEFAULT NULL,
  `ativo` varchar(1) DEFAULT 'S',
  `detalhe` text,
  `idt_avaliador` int(10) unsigned DEFAULT NULL,
  `idt_avaliado` int(10) unsigned DEFAULT NULL,
  `idt_organizacao_avaliador` int(10) unsigned DEFAULT NULL,
  `idt_organizacao_avaliado` int(10) unsigned DEFAULT NULL,
  `observacao` text,
  `data_avaliacao` date NOT NULL,
  `data_registro` datetime NOT NULL,
  `idt_responsavel_registro` int(11) NOT NULL,
  `idt_formulario` int(10) unsigned NOT NULL,
  `data_resposta` datetime DEFAULT NULL,
  `qtd_g` int(10) unsigned DEFAULT NULL,
  `qtd_e` int(10) unsigned DEFAULT NULL,
  `qtd_r` int(10) unsigned DEFAULT NULL,
  `idt_situacao` int(10) unsigned NOT NULL,
  PRIMARY KEY (`idt`),
  UNIQUE KEY `iu_grc_avaliacao` (`codigo`),
  KEY `FK_grc_avaliacao_1` (`idt_formulario`),
  KEY `FK_grc_avaliacao_2` (`idt_responsavel_registro`),
  KEY `FK_grc_avaliacao_3` (`idt_avaliador`),
  KEY `FK_grc_avaliacao_4` (`idt_avaliado`),
  KEY `FK_grc_avaliacao_5` (`idt_organizacao_avaliador`),
  KEY `FK_grc_avaliacao_6` (`idt_organizacao_avaliado`),
  KEY `FK_grc_avaliacao_7` (`idt_situacao`),
  CONSTRAINT `FK_grc_avaliacao_1` FOREIGN KEY (`idt_formulario`) REFERENCES `grc_formulario` (`idt`) ON UPDATE CASCADE,
  CONSTRAINT `FK_grc_avaliacao_2` FOREIGN KEY (`idt_responsavel_registro`) REFERENCES `plu_usuario` (`id_usuario`) ON UPDATE CASCADE,
  CONSTRAINT `FK_grc_avaliacao_3` FOREIGN KEY (`idt_avaliador`) REFERENCES `db_pir_gec`.`gec_entidade` (`idt`),
  CONSTRAINT `FK_grc_avaliacao_4` FOREIGN KEY (`idt_avaliado`) REFERENCES `db_pir_gec`.`gec_entidade` (`idt`),
  CONSTRAINT `FK_grc_avaliacao_5` FOREIGN KEY (`idt_organizacao_avaliador`) REFERENCES `db_pir_gec`.`gec_entidade` (`idt`),
  CONSTRAINT `FK_grc_avaliacao_6` FOREIGN KEY (`idt_organizacao_avaliado`) REFERENCES `db_pir_gec`.`gec_entidade` (`idt`),
  CONSTRAINT `FK_grc_avaliacao_7` FOREIGN KEY (`idt_situacao`) REFERENCES `grc_avaliacao_situacao` (`idt`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `grc_avaliacao`
--

/*!40000 ALTER TABLE `grc_avaliacao` DISABLE KEYS */;
INSERT INTO `grc_avaliacao` (`idt`,`codigo`,`descricao`,`ativo`,`detalhe`,`idt_avaliador`,`idt_avaliado`,`idt_organizacao_avaliador`,`idt_organizacao_avaliado`,`observacao`,`data_avaliacao`,`data_registro`,`idt_responsavel_registro`,`idt_formulario`,`data_resposta`,`qtd_g`,`qtd_e`,`qtd_r`,`idt_situacao`) VALUES 
 (1,'23','23','S',NULL,2715,2715,2715,2715,NULL,'2016-04-11','2016-04-11 00:00:00',1922,4,'2016-04-17 12:01:05',0,0,0,1),
 (2,'DS0000005','Lupe enginfo','S',NULL,28263,28227,27635,27336,NULL,'2016-04-16','2016-04-15 02:07:00',1,4,'2016-04-17 12:45:25',63,0,63,3);
/*!40000 ALTER TABLE `grc_avaliacao` ENABLE KEYS */;


--
-- Definition of table `grc_avaliacao_resposta`
--

DROP TABLE IF EXISTS `grc_avaliacao_resposta`;
CREATE TABLE `grc_avaliacao_resposta` (
  `idt` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idt_avaliacao` int(10) unsigned NOT NULL,
  `idt_formulario` int(10) unsigned NOT NULL,
  `idt_secao` int(10) unsigned NOT NULL,
  `idt_pergunta` int(10) unsigned NOT NULL,
  `idt_resposta` int(10) unsigned DEFAULT NULL,
  `qtd_pontos` int(10) unsigned DEFAULT NULL,
  `resposta_txt` text,
  PRIMARY KEY (`idt`),
  KEY `fk_grc_avaliacao_resposta_1` (`idt_formulario`),
  KEY `fk_grc_avaliacao_resposta_2` (`idt_secao`),
  KEY `fk_grc_avaliacao_resposta_3` (`idt_pergunta`),
  KEY `fk_grc_avaliacao_resposta_4` (`idt_resposta`),
  KEY `un_grc_avaliacao_resposta_2` (`idt_avaliacao`,`idt_pergunta`) USING BTREE,
  CONSTRAINT `fk_grc_avaliacao_resposta_1` FOREIGN KEY (`idt_formulario`) REFERENCES `grc_formulario` (`idt`),
  CONSTRAINT `fk_grc_avaliacao_resposta_2` FOREIGN KEY (`idt_secao`) REFERENCES `grc_formulario_secao` (`idt`),
  CONSTRAINT `fk_grc_avaliacao_resposta_3` FOREIGN KEY (`idt_pergunta`) REFERENCES `grc_formulario_pergunta` (`idt`),
  CONSTRAINT `fk_grc_avaliacao_resposta_4` FOREIGN KEY (`idt_resposta`) REFERENCES `grc_formulario_resposta` (`idt`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_grc_avaliacao_resposta_5` FOREIGN KEY (`idt_avaliacao`) REFERENCES `grc_avaliacao` (`idt`)
) ENGINE=InnoDB AUTO_INCREMENT=589 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `grc_avaliacao_resposta`
--

/*!40000 ALTER TABLE `grc_avaliacao_resposta` DISABLE KEYS */;
INSERT INTO `grc_avaliacao_resposta` (`idt`,`idt_avaliacao`,`idt_formulario`,`idt_secao`,`idt_pergunta`,`idt_resposta`,`qtd_pontos`,`resposta_txt`) VALUES 
 (526,2,4,107,767,1985,NULL,NULL),
 (527,2,4,107,768,1988,NULL,NULL),
 (528,2,4,107,769,1990,NULL,NULL),
 (529,2,4,107,770,1993,NULL,NULL),
 (530,2,4,107,771,1997,NULL,NULL),
 (531,2,4,107,772,2000,NULL,NULL),
 (532,2,4,107,773,2003,NULL,NULL),
 (533,2,4,107,774,2005,NULL,NULL),
 (534,2,4,107,801,2087,NULL,NULL),
 (535,2,4,107,802,2093,NULL,NULL),
 (536,2,4,107,803,2095,NULL,NULL),
 (537,2,4,107,804,2099,NULL,NULL),
 (538,2,4,107,805,2103,NULL,NULL),
 (539,2,4,107,806,2107,NULL,NULL),
 (540,2,4,107,807,2113,NULL,NULL),
 (541,2,4,107,824,2180,NULL,NULL),
 (542,2,4,108,775,2009,NULL,NULL),
 (543,2,4,108,776,2011,NULL,NULL),
 (544,2,4,108,777,2016,NULL,NULL),
 (545,2,4,108,778,2018,NULL,NULL),
 (546,2,4,108,779,2020,NULL,NULL),
 (547,2,4,108,780,2023,NULL,NULL),
 (548,2,4,108,781,2026,NULL,NULL),
 (549,2,4,108,808,2115,NULL,NULL),
 (550,2,4,108,809,2118,NULL,NULL),
 (551,2,4,108,810,2124,NULL,NULL),
 (552,2,4,108,811,2129,NULL,NULL),
 (553,2,4,108,812,2132,NULL,NULL),
 (554,2,4,108,825,2184,NULL,NULL),
 (555,2,4,109,782,2029,NULL,NULL),
 (556,2,4,109,783,2033,NULL,NULL),
 (557,2,4,109,784,2035,NULL,NULL),
 (558,2,4,109,785,2038,NULL,NULL),
 (559,2,4,109,813,2135,NULL,NULL),
 (560,2,4,109,814,2140,NULL,NULL),
 (561,2,4,109,826,2188,NULL,NULL),
 (562,2,4,110,786,2041,NULL,NULL),
 (563,2,4,110,787,2044,NULL,NULL),
 (564,2,4,110,788,2049,NULL,NULL),
 (565,2,4,110,789,2050,NULL,NULL),
 (566,2,4,110,790,2054,NULL,NULL),
 (567,2,4,110,815,2143,NULL,NULL),
 (568,2,4,110,816,2149,NULL,NULL),
 (569,2,4,110,817,2151,NULL,NULL),
 (570,2,4,110,818,2154,NULL,NULL),
 (571,2,4,110,827,2191,NULL,NULL),
 (572,2,4,111,791,2056,NULL,NULL),
 (573,2,4,111,792,2060,NULL,NULL),
 (574,2,4,111,793,2063,NULL,NULL),
 (575,2,4,111,794,2066,NULL,NULL),
 (576,2,4,111,795,2070,NULL,NULL),
 (577,2,4,111,819,2160,NULL,NULL),
 (578,2,4,111,820,2163,NULL,NULL),
 (579,2,4,111,828,2196,NULL,NULL),
 (580,2,4,112,796,2072,NULL,NULL),
 (581,2,4,112,797,2074,NULL,NULL),
 (582,2,4,112,798,2077,NULL,NULL),
 (583,2,4,112,799,2081,NULL,NULL),
 (584,2,4,112,800,2084,NULL,NULL),
 (585,2,4,112,821,2167,NULL,NULL),
 (586,2,4,112,822,2172,NULL,NULL),
 (587,2,4,112,823,2175,NULL,NULL),
 (588,2,4,112,829,2200,NULL,NULL);
/*!40000 ALTER TABLE `grc_avaliacao_resposta` ENABLE KEYS */;


--
-- Definition of table `grc_avaliacao_resposta_anexo`
--

DROP TABLE IF EXISTS `grc_avaliacao_resposta_anexo`;
CREATE TABLE `grc_avaliacao_resposta_anexo` (
  `idt` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idt_resposta` int(10) unsigned NOT NULL,
  `descricao` varchar(120) NOT NULL,
  `observacao` text,
  `idt_responsavel` int(11) NOT NULL,
  `data_responsavel` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `arquivo` varchar(120) NOT NULL,
  PRIMARY KEY (`idt`),
  KEY `iu_grc_avaliacao_resposta_anexo` (`idt_resposta`,`descricao`),
  KEY `FK_grc_avaliacao_resposta_anexo_2` (`idt_responsavel`),
  CONSTRAINT `FK_grc_avaliacao_resposta_anexo_1` FOREIGN KEY (`idt_resposta`) REFERENCES `grc_avaliacao_resposta` (`idt`) ON DELETE CASCADE,
  CONSTRAINT `FK_grc_avaliacao_resposta_anexo_2` FOREIGN KEY (`idt_responsavel`) REFERENCES `plu_usuario` (`id_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `grc_avaliacao_resposta_anexo`
--

/*!40000 ALTER TABLE `grc_avaliacao_resposta_anexo` DISABLE KEYS */;
/*!40000 ALTER TABLE `grc_avaliacao_resposta_anexo` ENABLE KEYS */;


--
-- Definition of table `grc_avaliacao_situacao`
--

DROP TABLE IF EXISTS `grc_avaliacao_situacao`;
CREATE TABLE `grc_avaliacao_situacao` (
  `idt` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `codigo` varchar(45) NOT NULL,
  `descricao` varchar(120) NOT NULL,
  `ativo` varchar(1) NOT NULL,
  `detalhe` text,
  PRIMARY KEY (`idt`),
  UNIQUE KEY `iu_grc_avaliacao_situacao` (`codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `grc_avaliacao_situacao`
--

/*!40000 ALTER TABLE `grc_avaliacao_situacao` DISABLE KEYS */;
INSERT INTO `grc_avaliacao_situacao` (`idt`,`codigo`,`descricao`,`ativo`,`detalhe`) VALUES 
 (1,'01','Cadastrada','S',NULL),
 (2,'02','Respondendo','S',NULL),
 (3,'03','Totalmente Respondido','S',NULL),
 (4,'10','Fechado e Apurado','S',NULL),
 (5,'12','Vazio','S',NULL),
 (6,'90','Cancelado','S',NULL),
 (7,'20','Concluido','S',NULL);
/*!40000 ALTER TABLE `grc_avaliacao_situacao` ENABLE KEYS */;


--
-- Definition of table `grc_formulario`
--

DROP TABLE IF EXISTS `grc_formulario`;
CREATE TABLE `grc_formulario` (
  `idt` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `codigo` varchar(45) NOT NULL,
  `descricao` varchar(120) NOT NULL,
  `ativo` varchar(1) DEFAULT 'S',
  `detalhe` text,
  `qtd_pontos` int(10) unsigned DEFAULT NULL,
  `idt_aplicacao` int(10) unsigned NOT NULL,
  `idt_responsavel` int(11) NOT NULL,
  `idt_area_responsavel` int(11) NOT NULL,
  `versao_texto` varchar(45) DEFAULT 'V.0',
  `versao_numero` decimal(15,2) DEFAULT NULL,
  `data_inicio_aplicacao` datetime DEFAULT NULL,
  `data_termino_aplicacao` datetime DEFAULT NULL,
  `observacao` varchar(4000) DEFAULT NULL,
  `idt_dimensao` int(10) unsigned NOT NULL,
  `controle_pontos` varchar(1) NOT NULL DEFAULT 'N',
  PRIMARY KEY (`idt`),
  UNIQUE KEY `iu_grc_formulario` (`codigo`),
  KEY `FK_grc_formulario_1` (`idt_aplicacao`),
  KEY `FK_grc_formulario_2` (`idt_responsavel`),
  KEY `FK_grc_formulario_3` (`idt_area_responsavel`),
  KEY `FK_grc_formulario_4` (`idt_dimensao`),
  CONSTRAINT `FK_grc_formulario_1` FOREIGN KEY (`idt_aplicacao`) REFERENCES `grc_formulario_aplicacao` (`idt`),
  CONSTRAINT `FK_grc_formulario_2` FOREIGN KEY (`idt_responsavel`) REFERENCES `plu_usuario` (`id_usuario`),
  CONSTRAINT `FK_grc_formulario_3` FOREIGN KEY (`idt_area_responsavel`) REFERENCES `db_pir`.`sca_organizacao_secao` (`idt`),
  CONSTRAINT `FK_grc_formulario_4` FOREIGN KEY (`idt_dimensao`) REFERENCES `grc_formulario_dimensao_resposta` (`idt`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `grc_formulario`
--

/*!40000 ALTER TABLE `grc_formulario` DISABLE KEYS */;
INSERT INTO `grc_formulario` (`idt`,`codigo`,`descricao`,`ativo`,`detalhe`,`qtd_pontos`,`idt_aplicacao`,`idt_responsavel`,`idt_area_responsavel`,`versao_texto`,`versao_numero`,`data_inicio_aplicacao`,`data_termino_aplicacao`,`observacao`,`idt_dimensao`,`controle_pontos`) VALUES 
 (1,'03','Negócio a Negócio - Percepção do AOE (ELEGIBILIDADE)','S','Como o nome já diz, respostas prováveis, através da análise realizada no atendimento, o agente deverá escolher a \r\nresposta mais apropriada. Sempre solicitar ao cliente uma evidencia para verificar se o método dele realmente é \r\nefetivo e adequado. Procurando sensibilizar acerca da importância das ferramentas de gestão empresarial.',100,1,21,74,'V1.0','1.00','2015-07-01 00:00:00','2015-07-31 00:00:00',NULL,2,'N'),
 (2,'02','Negócio a Negócio - Percepção do Cliente (QUESITOS)','S','Neste campo o que vale é a opinião do empresário, é como ele se sente em relação as suas ações referentes a um determinado quesito.\r\nNeste bloco ele expõe seu sentimento, sua percepção de como ele está praticando aquela ferramenta questionada.',100,1,21,54,NULL,NULL,NULL,NULL,NULL,4,'N'),
 (3,'01','Negócio a Negócio - Percepção do Cliente  (Área Temática)','S','Neste campo o que vale é a opinião do empresário, é como ele se sente em relação as suas ações referentes a um determinado quesito.\r\nNeste bloco ele expõe seu sentimento, sua percepção de como ele está praticando aquela ferramenta questionada.',100,1,1373,74,'V.1','1.00',NULL,NULL,NULL,5,'N'),
 (4,'50','Diagnóstico Situacional','S','Negócio a Negócio - Diagnóstico Situacional',NULL,1,2129,52,'v.1','1.00',NULL,NULL,NULL,6,'N');
/*!40000 ALTER TABLE `grc_formulario` ENABLE KEYS */;


--
-- Definition of table `grc_formulario_aplicacao`
--

DROP TABLE IF EXISTS `grc_formulario_aplicacao`;
CREATE TABLE `grc_formulario_aplicacao` (
  `idt` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `codigo` varchar(45) NOT NULL,
  `descricao` varchar(120) NOT NULL,
  `ativo` varchar(1) NOT NULL,
  `detalhe` text,
  PRIMARY KEY (`idt`),
  UNIQUE KEY `iu_grc_formulario_aplicacao` (`codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `grc_formulario_aplicacao`
--

/*!40000 ALTER TABLE `grc_formulario_aplicacao` DISABLE KEYS */;
INSERT INTO `grc_formulario_aplicacao` (`idt`,`codigo`,`descricao`,`ativo`,`detalhe`) VALUES 
 (1,'01','Negócio a Negócio','S',NULL);
/*!40000 ALTER TABLE `grc_formulario_aplicacao` ENABLE KEYS */;


--
-- Definition of table `grc_formulario_area`
--

DROP TABLE IF EXISTS `grc_formulario_area`;
CREATE TABLE `grc_formulario_area` (
  `idt` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `codigo` varchar(45) NOT NULL,
  `descricao` varchar(120) NOT NULL,
  `ativo` varchar(1) NOT NULL,
  `detalhe` text,
  PRIMARY KEY (`idt`),
  UNIQUE KEY `iu_grc_formulario_area` (`codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `grc_formulario_area`
--

/*!40000 ALTER TABLE `grc_formulario_area` DISABLE KEYS */;
INSERT INTO `grc_formulario_area` (`idt`,`codigo`,`descricao`,`ativo`,`detalhe`) VALUES 
 (2,'01','FINANÇAS','S','FINANÇAS'),
 (3,'02','MERCADO','S','MERCADO'),
 (4,'03','PLANEJAMENTO','S','PLANEJAMENTO'),
 (5,'04','ORGANIZAÇÃO','S','ORGANIZAÇÃO'),
 (6,'05','PESSOAS','S','PESSOAS'),
 (7,'06','INOVAÇÃO','S','INOVAÇÃO'),
 (8,'07','COOPERAÇÃO','S','COOPERAÇÃO');
/*!40000 ALTER TABLE `grc_formulario_area` ENABLE KEYS */;


--
-- Definition of table `grc_formulario_classe_pergunta`
--

DROP TABLE IF EXISTS `grc_formulario_classe_pergunta`;
CREATE TABLE `grc_formulario_classe_pergunta` (
  `idt` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `codigo` varchar(45) NOT NULL,
  `descricao` varchar(120) NOT NULL,
  `ativo` varchar(1) NOT NULL,
  `detalhe` text,
  PRIMARY KEY (`idt`),
  UNIQUE KEY `iu_grc_formulario_classe_pergunta` (`codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `grc_formulario_classe_pergunta`
--

/*!40000 ALTER TABLE `grc_formulario_classe_pergunta` DISABLE KEYS */;
INSERT INTO `grc_formulario_classe_pergunta` (`idt`,`codigo`,`descricao`,`ativo`,`detalhe`) VALUES 
 (2,'01','Múltipla Escolha','S',NULL);
/*!40000 ALTER TABLE `grc_formulario_classe_pergunta` ENABLE KEYS */;


--
-- Definition of table `grc_formulario_classe_resposta`
--

DROP TABLE IF EXISTS `grc_formulario_classe_resposta`;
CREATE TABLE `grc_formulario_classe_resposta` (
  `idt` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `codigo` varchar(45) NOT NULL,
  `descricao` varchar(120) NOT NULL,
  `ativo` varchar(1) NOT NULL,
  `detalhe` text,
  PRIMARY KEY (`idt`),
  UNIQUE KEY `iu_grc_formulario_grc_formulario_classe_resposta` (`codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `grc_formulario_classe_resposta`
--

/*!40000 ALTER TABLE `grc_formulario_classe_resposta` DISABLE KEYS */;
INSERT INTO `grc_formulario_classe_resposta` (`idt`,`codigo`,`descricao`,`ativo`,`detalhe`) VALUES 
 (2,'01','Com complemento','S',NULL);
/*!40000 ALTER TABLE `grc_formulario_classe_resposta` ENABLE KEYS */;


--
-- Definition of table `grc_formulario_dimensao_resposta`
--

DROP TABLE IF EXISTS `grc_formulario_dimensao_resposta`;
CREATE TABLE `grc_formulario_dimensao_resposta` (
  `idt` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `codigo` varchar(45) NOT NULL,
  `descricao` varchar(120) NOT NULL,
  `ativo` varchar(1) NOT NULL,
  `detalhe` text,
  `agregador` varchar(1) NOT NULL DEFAULT 'N',
  `sigla` varchar(5) DEFAULT NULL,
  PRIMARY KEY (`idt`),
  UNIQUE KEY `iu_grc_formulario_dimensao_resposta` (`codigo`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `grc_formulario_dimensao_resposta`
--

/*!40000 ALTER TABLE `grc_formulario_dimensao_resposta` DISABLE KEYS */;
INSERT INTO `grc_formulario_dimensao_resposta` (`idt`,`codigo`,`descricao`,`ativo`,`detalhe`,`agregador`,`sigla`) VALUES 
 (2,'01','Elegibilidade','S',NULL,'N','E'),
 (3,'02','Complexidade','S',NULL,'N','C'),
 (4,'03','Satisfação(Q)','S',NULL,'N','Q'),
 (5,'04','Satisfação(A)','S',NULL,'N','A'),
 (6,'50','Diagnóstico Situacional','S','Negócio a Negócio - Diagnóstico Situacional','S','D');
/*!40000 ALTER TABLE `grc_formulario_dimensao_resposta` ENABLE KEYS */;


--
-- Definition of table `grc_formulario_ferramenta_ead`
--

DROP TABLE IF EXISTS `grc_formulario_ferramenta_ead`;
CREATE TABLE `grc_formulario_ferramenta_ead` (
  `idt` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `codigo` int(10) unsigned NOT NULL,
  `descricao` varchar(120) NOT NULL,
  `ativo` varchar(1) NOT NULL,
  `detalhe` text,
  `nivel` int(10) unsigned NOT NULL DEFAULT '1',
  `numero_pagina` int(10) unsigned DEFAULT NULL,
  `idt_area` int(10) unsigned NOT NULL,
  `link` varchar(255) DEFAULT NULL,
  `solucao` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`idt`),
  UNIQUE KEY `iu_grc_formulario_ferramenta_ead` (`codigo`),
  KEY `FK_grc_formulario_ferramenta_ead_1` (`idt_area`),
  CONSTRAINT `FK_grc_formulario_ferramenta_ead_1` FOREIGN KEY (`idt_area`) REFERENCES `grc_formulario_area` (`idt`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `grc_formulario_ferramenta_ead`
--

/*!40000 ALTER TABLE `grc_formulario_ferramenta_ead` DISABLE KEYS */;
INSERT INTO `grc_formulario_ferramenta_ead` (`idt`,`codigo`,`descricao`,`ativo`,`detalhe`,`nivel`,`numero_pagina`,`idt_area`,`link`,`solucao`) VALUES 
 (1,1,'Análise e Planejamento Financeiro','S',NULL,1,NULL,2,'https://ead.sebrae.com.br/cursos/analise-e-planejamento-financeiro','CURSO'),
 (2,2,'Programa Varejo Fácil – Controles Financeiros','S',NULL,1,NULL,2,'www.ead.sebrae.com.br/cursos/programa-varejo-facil-controles-financeiros','CURSO'),
 (3,3,'Sei Comprar','S',NULL,1,NULL,2,'https://www.ead.sebrae.com.br/cursos/sei-comprar','CURSO'),
 (4,4,'Sei Comprar','S',NULL,1,NULL,2,'www.ead.sebrae.com.br/oficinas-por-celular/sei-comprar','Oficina por celular'),
 (5,5,'Sei Controlar meu Dinheiro','S',NULL,1,NULL,2,'https://www.ead.sebrae.com.br/cursos/sei-controlar-meu-dinheiro','CURSO'),
 (6,6,'Sei Controlar meu Dinheiro','S',NULL,1,NULL,2,'www.ead.sebrae.com.br/oficinas-por-celular/sei-controlar-meu-dinheiro','Oficina por celular'),
 (7,7,'Formação do Preço de Venda','S',NULL,2,NULL,2,'www.ead.sebrae.com.br/cursos/formacao-do-preco-de-venda','CURSO'),
 (8,8,'Programa Varejo Fácil – Formação do Preço de Venda','S',NULL,1,NULL,2,'www.ead.sebrae.com.br/cursos/programa-varejo-facil-formacao-do-preco-de-venda','CURSO'),
 (9,9,'Ponto de Equilíbrio','S',NULL,1,NULL,2,'https://ead.sebrae.com.br/videos/ponto-de-equilibrio','VIDEO'),
 (10,10,'Controle Financeiro','S',NULL,1,NULL,2,'https://ead.sebrae.com.br/dicas/controle-financeiro','DICA'),
 (12,11,'Conhecendo os Custos da sua Empresa','S',NULL,1,NULL,2,'https://ead.sebrae.com.br/dicas/conhecendo-os-custos-da-sua-empresa','DICA'),
 (13,12,'Tratar Bem ou Atender Bem?','S',NULL,1,NULL,2,'https://ead.sebrae.com.br/dicas/tratar-bem-ou-atender-bem','DICA'),
 (14,13,'Trilha do Empreendedor','S',NULL,1,NULL,3,'https://ead.sebrae.com.br/jogos/trilha-do-empreendedor','JOGO'),
 (15,14,'Kart das 11 Habilidades','S',NULL,1,NULL,3,'https://ead.sebrae.com.br/jogos/kart-das-11-habilidades','JOGO'),
 (16,15,'Atendimento ao Cliente','S',NULL,3,NULL,2,'www.ead.sebrae.com.br/cursos/atendimento-ao-cliente','CURSO'),
 (17,16,'Como Vender Mais e Melhor','S',NULL,1,NULL,2,'www.ead.sebrae.com.br/cursos/como-vender-mais-e-melhor','CURSO'),
 (18,17,'Compras Governamentais','S',NULL,2,NULL,3,'www.ead.sebrae.com.br/cursos/compras-governamentais','CURSO'),
 (19,18,'Condições de venda para o mercado externo','S',NULL,3,NULL,3,'www.ead.sebrae.com.br/cursos/condicoes-de-venda-para-o-mercado-externo','CURSO'),
 (20,19,'Programa Varejo Fácil – Atendimento ao Cliente','S',NULL,1,NULL,3,'www.ead.sebrae.com.br/cursos/programa-varejo-facil-atendimento-ao-cliente','CURSO'),
 (21,20,'Programa Varejo Fácil – Técnicas de Vendas','S',NULL,1,NULL,2,'www.ead.sebrae.com.br/cursos/programa-varejo-facil-tecnicas-de-vendas','CURSO'),
 (22,21,'Sei Vender','S',NULL,1,NULL,2,'https://ead.sebrae.com.br/cursos/sei-vender','CURSO'),
 (23,22,'Sei Vender','S',NULL,1,NULL,3,'https://ead.sebrae.com.br/oficinas-por-celular/sei-vender','Oficina por celular'),
 (24,23,'Conquistar, Encantar e Surpreender o Cliente','S',NULL,1,NULL,3,'https://ead.sebrae.com.br/minicursos/conquistar-encantar-e-surpreender-o-cliente','MINICURSO'),
 (25,24,'Os 7 Pecados do Atendimento','S',NULL,2,NULL,3,'https://ead.sebrae.com.br/dicas/os-7-pecados-do-atendimento','DICA'),
 (26,25,'Pesquisa de Mercado','S',NULL,1,NULL,3,'https://ead.sebrae.com.br/jogos/pesquisa-de-mercado','JOGO'),
 (27,26,'Perfil do Cliente','S',NULL,1,NULL,3,'https://ead.sebrae.com.br/jogos/perfil-do-cliente','JOGO'),
 (28,27,'Conquistar, Encantar e Surpreender o Cliente','S',NULL,3,NULL,3,'https://ead.sebrae.com.br/minicursos/conquistar-encantar-e-surpreender-o-cliente','MINICURSO'),
 (29,28,'Ganhando Clientes','S',NULL,1,NULL,3,'https://ead.sebrae.com.br/jogos/ganhando-clientes','JOGO'),
 (30,29,'Conquiste seu Espaço','S',NULL,2,NULL,4,'https://ead.sebrae.com.br/jogos/conquiste-seu-espaco','JOGO'),
 (31,30,'Gestão da Qualidade: Visão Estratégica','S',NULL,3,NULL,4,'www.ead.sebrae.com.br/cursos/gestao-da-qualidade-visao-estrategica','CURSO'),
 (32,31,'Gestão Empresarial Integrada','S',NULL,3,NULL,4,'www.ead.sebrae.com.br/cursos/gestao-empresarial-integrada','CURSO'),
 (34,32,'Planejamento para Exportar','S',NULL,1,NULL,4,'www.ead.sebrae.com.br/cursos/planejamento-para-exportar','CURSO'),
 (35,33,'Sei Planejar','S',NULL,1,NULL,2,'www.ead.sebrae.com.br/cursos/sei-planejar','CURSO'),
 (36,34,'Sei Planejar','S',NULL,1,NULL,2,'www.ead.sebrae.com.br/oficinas-por-celular/sei-planejar','Oficina por celular'),
 (37,35,'Aprender a Empreender','S',NULL,1,NULL,4,'www.ead.sebrae.com.br/cursos/aprender-a-empreender','CURSO'),
 (38,36,'Iniciando um Pequeno e Grande Negócio','S',NULL,1,NULL,4,'www.ead.sebrae.com.br/cursos/iniciando-um-pequeno-e-grande-negocio','CURSO'),
 (39,37,'Sei Empreender','S',NULL,1,NULL,4,'www.ead.sebrae.com.br/cursos/sei-empreender','CURSO'),
 (40,38,'Sei Empreender','S',NULL,1,NULL,4,'www.ead.sebrae.com.br/oficinas-por-celular/sei-empreender','Oficina por celular'),
 (41,39,'Em Busca do Sucesso','S',NULL,1,NULL,4,'https://ead.sebrae.com.br/jogos/em-busca-do-sucesso','JOGO'),
 (42,40,'Perfil do Microempreendedor Individual','S',NULL,1,NULL,4,'https://ead.sebrae.com.br/dicas/perfil-do-microempreendedor-individual','DICA'),
 (43,41,'Características Empreendedoras','S',NULL,1,NULL,4,'https://ead.sebrae.com.br/dicas/caracteristicas-empreendedoras','DICA'),
 (44,42,'MEG na Avaliação da Gestão de Negócios','S',NULL,3,NULL,5,'https://ead.sebrae.com.br/cursos/meg-na-avaliacao-da-gestao-de-negocios','CURSO'),
 (45,43,'Procedimentos para Exportação','S',NULL,3,NULL,5,'www.ead.sebrae.com.br/cursos/procedimentos-para-exportacao','CURSO'),
 (46,44,'Responsabilidade Social','S',NULL,1,NULL,5,'www.ead.sebrae.com.br/cursos/responsabilidade-social','CURSO'),
 (47,45,'D-Olho na Qualidade: 5Ss para os pequenos negócios','S',NULL,1,NULL,5,'www.ead.sebrae.com.br/cursos/d-olho-na-qualidade','CURSO'),
 (48,48,'Programa Varejo Fácil – Gestão de Pessoas','S',NULL,3,NULL,6,'www.ead.sebrae.com.br/cursos/programa-varejo-facil-gestao-de-pessoas','CURSO'),
 (49,49,'Gestão da Inovação: Inovar para Competir','S',NULL,2,NULL,7,'www.ead.sebrae.com.br/cursos/gestao-da-inovacao-inovar-para-competir','CURSO'),
 (50,50,'Boas Práticas nos Serviços de Alimentação','S',NULL,3,NULL,7,'www.ead.sebrae.com.br/cursos/boas-praticas-nos-servicos-de-alimentacao','CURSO'),
 (51,46,'Sei Unir Forças','S',NULL,1,NULL,8,'https://ead.sebrae.com.br/oficinas-por-celular/sei-unir-forcas','Oficina por celular'),
 (52,47,'Sei Unir Forças para Melhorar','S',NULL,1,NULL,8,'www.ead.sebrae.com.br/cursos/sei-unir-forcas-para-melhorar','CURSO');
/*!40000 ALTER TABLE `grc_formulario_ferramenta_ead` ENABLE KEYS */;


--
-- Definition of table `grc_formulario_ferramenta_gestao`
--

DROP TABLE IF EXISTS `grc_formulario_ferramenta_gestao`;
CREATE TABLE `grc_formulario_ferramenta_gestao` (
  `idt` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `codigo` int(10) unsigned NOT NULL,
  `descricao` varchar(120) NOT NULL,
  `ativo` varchar(1) NOT NULL,
  `detalhe` text,
  `nivel` int(10) unsigned NOT NULL DEFAULT '1',
  `numero_pagina` int(10) unsigned DEFAULT NULL,
  `idt_area` int(10) unsigned NOT NULL,
  PRIMARY KEY (`idt`),
  UNIQUE KEY `iu_grc_formulario_ferramenta_gestao` (`codigo`),
  KEY `FK_grc_formulario_ferramenta_gestao_1` (`idt_area`),
  CONSTRAINT `FK_grc_formulario_ferramenta_gestao_1` FOREIGN KEY (`idt_area`) REFERENCES `grc_formulario_area` (`idt`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `grc_formulario_ferramenta_gestao`
--

/*!40000 ALTER TABLE `grc_formulario_ferramenta_gestao` DISABLE KEYS */;
INSERT INTO `grc_formulario_ferramenta_gestao` (`idt`,`codigo`,`descricao`,`ativo`,`detalhe`,`nivel`,`numero_pagina`,`idt_area`) VALUES 
 (2,1,'DIÁRIO DE CAIXA','S','<p><span style=\"font-family: Tahoma;\">Essa ferramenta permitir&aacute; que voc&ecirc; acompanhe diariamente as entradas e sa&iacute;das de dinheiro em sua empresa. Assim voc&ecirc; poder&aacute; saber o quanto est&aacute; recebendo e para onde est&aacute; indo o dinheiro de seu caixa.&nbsp;</span></p>',1,19,2),
 (7,2,'CONTROLE DO PAGAMENTO DE TRIBUTOS','S','<p><span style=\"font-family: Tahoma;\">Esta ferramenta apresenta duas finalidades. A primeira &eacute; possibilitar que voc&ecirc; registre quais os tributos (impostos, taxas, contribui&ccedil;&otilde;es, etc.) que devem ser pagos periodicamente por sua empresa. A segunda &eacute; fornecer um espa&ccedil;o para voc&ecirc; registrar o per&iacute;odo em que estes tributos devem ser pagos, bem como os valores pagos ao longo do tempo.</span></p>',1,26,2),
 (8,3,'CONTROLE DO FLUXO DE CAIXA','S','<p><span style=\"font-family: Tahoma;\"><strong>O que &eacute;: </strong><br />\r\n<br />\r\nEsta ferramenta apresenta as receitas e gastos futuros distribu&iacute;dos semanalmente, permitindo a visualiza&ccedil;&atilde;o dos descompassos que podem ocorrer entre receitas e gastos, ou seja, per&iacute;odos com gastos superiores &agrave;s receitas e vice-versa.</span></p>',1,31,2),
 (9,4,'CÁLCULO DO GANHO UNITÁRIO','S','<p><strong><span style=\"font-family: Tahoma;\">O que &eacute;: </span></strong><span style=\"font-family: Tahoma;\"><br />\r\n<br />\r\nEssa ferramenta auxilia no c&aacute;lculo do ganho em dinheiro que o empres&aacute;rio obt&eacute;m com a venda de seus produtos e/ou servi&ccedil;os. Ou seja, a partir do pre&ccedil;o praticado, diminuindo os custos vari&aacute;veis diretos necess&aacute;rios para fazer o produto ou prestar o servi&ccedil;o, identificar quanto sobra para o empres&aacute;rio.</span></p>',2,36,2),
 (10,5,'DEMONSTRATIVO DE RESULTADO','S','<p><strong><span style=\"font-family: Tahoma;\">O que &eacute;: </span></strong><span style=\"font-family: Tahoma;\"><br />\r\n<br />\r\nEssa ferramenta apresenta objetivamente o resultado mensal de seu neg&oacute;cio. Com ela voc&ecirc; poder&aacute; registrar os valores de suas despesas e receitas. Al&eacute;m disso, pode acompanhar m&ecirc;s a m&ecirc;s quanto seu neg&oacute;cio est&aacute; gerando de dinheiro.</span></p>',2,42,2),
 (11,6,'GESTÃO DE ESTOQUES','S','<p><strong><span style=\"font-family: Tahoma;\">O que &eacute;: </span></strong><span style=\"font-family: Tahoma;\"><br />\r\n<br />\r\nEsta ferramenta tem como objetivo auxili&aacute;-lo no controle dos seus estoques (produtos, mat&eacute;riasprimas e materiais). Voc&ecirc; poder&aacute; definir qual a quantidade m&iacute;nima ou m&aacute;xima necess&aacute;ria de um determinado produto e tamb&eacute;m qual o momento ideal para fazer um novo pedido, evitando, principalmente, a falta de produtos para seus clientes.</span></p>',2,47,2),
 (12,7,'CONTROLE DO CAPITAL DE GIRO','S','<p><strong><span style=\"font-family: Tahoma;\">O que &eacute;: </span></strong><span style=\"font-family: Tahoma;\"><br />\r\n<br />\r\nEssa ferramenta permite acompanhar a quantidade de dinheiro necess&aacute;rio para atender os compromissos do dia a dia da empresa, o seu Capital de Giro.</span></p>',2,42,2),
 (13,8,'CADASTRO DE CLIENTES','S','<p><strong><span style=\"font-family: Tahoma;\">O que &eacute;: </span></strong><span style=\"font-family: Tahoma;\"><br />\r\n<br />\r\nEsta ferramenta ir&aacute; manter importantes informa&ccedil;&otilde;es sobre seus clientes &agrave; disposi&ccedil;&atilde;o, tais como a regi&atilde;o em que residem, seu perfil pessoal, os melhores meios para voc&ecirc; contat&aacute;-lo, seu perfil de compras, etc. Al&eacute;m de tudo, ir&aacute; ajudar voc&ecirc; a conhecer melhor os seus clientes para atend&ecirc;-los de maneira mais adequada</span></p>',1,61,3),
 (14,9,'PESQUISA DE SATISFAÇÃO','S','<p><strong><span style=\"font-family: Tahoma;\">O que &eacute;: </span></strong><span style=\"font-family: Tahoma;\"><br />\r\n<br />\r\nO fato de seus clientes n&atilde;o reclamarem n&atilde;o significa que eles estejam totalmente satisfeitos com seu neg&oacute;cio. Assim, esta ferramenta ir&aacute; auxili&aacute;-lo a identificar o n&iacute;vel de satisfa&ccedil;&atilde;o de seus clientes em rela&ccedil;&atilde;o aos produtos e servi&ccedil;os ofertados em sua empresa. Um cliente satisfeito amplia a propaganda boca a boca</span></p>',1,69,3),
 (15,10,'ANÁLISE DAS NECESSIDADES DOS CLIENTES','S','<p><strong><span style=\"font-family: Tahoma;\">O que &eacute;: </span></strong><span style=\"font-family: Tahoma;\"><br />\r\n<br />\r\nEsta ferramenta ir&aacute; auxili&aacute;-lo na identifica&ccedil;&atilde;o e an&aacute;lise das principais necessidades e desejos de seus clientes, permitindo, assim, ampliar e melhorar suas possibilidades de atendimento o que poder&aacute; gerar diferencia&ccedil;&atilde;o e novas formas de ganhar mais dinheiro.</span></p>',2,74,3),
 (16,11,'SEGMENTAÇÃO DE CLIENTES','S','<p><strong><span style=\"font-family: Tahoma;\">O que &eacute;: </span></strong><span style=\"font-family: Tahoma;\"><br />\r\n<br />\r\nEsta ferramenta ir&aacute; classificar seus clientes de acordo com alguns crit&eacute;rios de segmenta&ccedil;&atilde;o (prefer&ecirc;ncia e volume de compra, regi&atilde;o, idade, estilos de vida, etc.). Assim, poder&aacute; formar grupos de clientes que possuem caracter&iacute;sticas comuns. Agrupando seus clientes desta maneira, sua empresa estar&aacute; apta a praticar o Marketing de Segmento, permitindo que voc&ecirc; tenha a&ccedil;&otilde;es mais direcionadas a cada grupo de clientes.</span></p>',2,80,3),
 (17,12,'OFERTANDO NOVOS PRODUTOS/SERVIÇOS','S','<p><strong><span style=\"font-family: Tahoma;\">O que &eacute;: </span></strong><span style=\"font-family: Tahoma;\"><br />\r\n<br />\r\nEsta ferramenta est&aacute; direcionada a captar do mercado informa&ccedil;&otilde;es que contribuam para voc&ecirc; visualizar oportunidades de ofertar novos produtos e servi&ccedil;os. Vai mostrar a voc&ecirc; oportunidades que hoje n&atilde;o s&atilde;o ofertadas e que podem contribuir com a melhoria da sua empresa.</span></p>',2,84,3),
 (18,13,'ENTENDIMENTO DO MERCADO','S','<p><strong><span style=\"font-family: Tahoma;\">O que &eacute;: </span></strong><span style=\"font-family: Tahoma;\"><br />\r\n<br />\r\nEsta ferramenta ir&aacute; propiciar que voc&ecirc; conhe&ccedil;a mais claramente o mercado em que atua e a partir destas informa&ccedil;&otilde;es direcionar a&ccedil;&otilde;es para tornar seu neg&oacute;cio mais competitivo, ou seja, mais atraente ao seu cliente do que seus concorrentes.</span></p>',3,89,3),
 (19,14,'PLANO DE PROMOÇÃO','S','<p><strong><span style=\"font-family: Tahoma;\">O que &eacute;: </span></strong><span style=\"font-family: Tahoma;\"><br />\r\n<br />\r\nEsta ferramenta auxilia voc&ecirc; a planejar as a&ccedil;&otilde;es de promo&ccedil;&atilde;o que pretende realizar no seu neg&oacute;- cio (propaganda de produtos e servi&ccedil;os, descontos, etc.). As promo&ccedil;&otilde;es servem para mobilizar e fidelizar os clientes, aumentado suas vendas e o lucro.</span></p>',3,93,3),
 (20,15,'PLANEJAMENTO: O PRIMEIRO PASSO PARA O SUCESSO','S','<p><strong><span style=\"font-family: Tahoma;\">O que &eacute;: </span></strong><span style=\"font-family: Tahoma;\"><br />\r\n<br />\r\nEsta ferramenta ir&aacute; ajud&aacute;-lo a entender o porqu&ecirc; de fazer o planejamento e a import&acirc;ncia de definir um conjunto de a&ccedil;&otilde;es para realizar este plano. Quanto melhor for o seu planejamento e a realiza&ccedil;&atilde;o, maiores ser&atilde;o as suas chances de sucesso. O planejamento &eacute; um processo din&acirc;mico e cont&iacute;nuo. Planejar de maneira din&acirc;mica ajuda a reduzir atritos, confus&otilde;es e perdas. &Eacute; considerado cont&iacute;nuo porque voc&ecirc; deve planejar sempre e fazer corre&ccedil;&otilde;es a qualquer momento para alterar os rumos previamente definidos.</span></p>',1,101,3),
 (21,16,'PLANEJANDO O NEGÓCIO: OBJETIVOS E METAS','S','<p><strong><span style=\"font-family: Tahoma;\">O que &eacute;: </span></strong><span style=\"font-family: Tahoma;\"><br />\r\n<br />\r\nAo utilizar essa ferramenta, voc&ecirc; refletir&aacute; sobre a situa&ccedil;&atilde;o atual do seu neg&oacute;cio e a situa&ccedil;&atilde;o desejada, definindo a orienta&ccedil;&atilde;o de &ldquo;como causar a mudan&ccedil;a?&rdquo;, com foco no crescimento e sucesso do neg&oacute;cio. Voc&ecirc; partir&aacute; da situa&ccedil;&atilde;o atual (&ldquo;o que mudar?&rdquo;) e ter&aacute; como vis&atilde;o de futuro onde quer chegar (&ldquo;para o qu&ecirc; mudar?&rdquo;).</span></p>',2,106,3),
 (22,17,'PLANO DE AÇÃO DE CURTO E MÉDIO PRAZO','S','<p><strong><span style=\"font-family: Tahoma;\">O que &eacute;: </span></strong><span style=\"font-family: Tahoma;\"><br />\r\n<br />\r\nObjetivos e Metas s&atilde;o materializados por planos de a&ccedil;&atilde;o bem definidos. Sendo assim, ao utilizar esta ferramenta, voc&ecirc; definir&aacute; o caminho para conduzir sua empresa ao sucesso. Um plano de a&ccedil;&atilde;o a gerenciar o planejamento.</span></p>',2,111,3),
 (23,18,'APRENDIZAGEM ESTRATÉGICA','S','<p><strong><span style=\"font-family: Tahoma;\">O que &eacute;: </span></strong><span style=\"font-family: Tahoma;\"><br />\r\n<br />\r\nAo utilizar essa ferramenta voc&ecirc; poder&aacute; resgatar situa&ccedil;&otilde;es que tiveram resultados satisfat&oacute;rios e/ ou ruins, por parte da empresa. Sendo assim, por meio destas situa&ccedil;&otilde;es, voc&ecirc; poder&aacute; manter e/ ou melhorar boas pr&aacute;ticas e n&atilde;o repetir os erros realizados no passado.</span></p>',3,115,3),
 (24,19,'ORGANIZAÇÃO E DISCIPLINA','S','<p><strong><span style=\"font-family: Tahoma;\">O que &eacute;: </span></strong><span style=\"font-family: Tahoma;\"><br />\r\n<br />\r\nA ferramenta apresentar&aacute; a voc&ecirc; um conjunto de conceitos e orienta&ccedil;&otilde;es que ir&atilde;o o auxiliar a compreender a import&acirc;ncia da organiza&ccedil;&atilde;o e disciplina para sua empresa. Ajudar&aacute;, ainda, a verificar em que n&iacute;vel de organiza&ccedil;&atilde;o sua empresa se encontra. Um ambiente de trabalho limpo e organizado pode garantir sua produtividade. Al&eacute;m de deixar as coisas &ldquo;mais &agrave; m&atilde;o&rdquo;, os desperd&iacute;cios e movimentos desnecess&aacute;rios come&ccedil;am a desaparecer, melhorando seu rendimento na atividade.</span></p>',1,123,5),
 (25,20,'ORGANIZAÇÃO DE DOCUMENTOS','S','<p><strong><span style=\"font-family: Tahoma;\">O que &eacute;: </span></strong><span style=\"font-family: Tahoma;\"><br />\r\n<br />\r\nCom esta ferramenta voc&ecirc; manter&aacute; organizado e sempre &agrave; m&atilde;o os documentos b&aacute;sicos da sua empresa. Al&eacute;m disso, contas a pagar e comprovantes de pagamentos, por exemplo, estar&atilde;o facilmente dispon&iacute;veis, reduzindo o risco de pagar duas vezes a mesma conta ou, ainda pior, n&atilde;o realizar o pagamento e ter que pagar juros ou at&eacute; mesmo ter o servi&ccedil;o interrompido por esquecimento e falta de organiza&ccedil;&atilde;o.</span></p>',1,129,5),
 (26,21,'CADASTRO DE FORNECEDORES','S','<p><strong><span style=\"font-family: Tahoma;\">O que &eacute;: </span></strong><span style=\"font-family: Tahoma;\"><br />\r\n<br />\r\nEsta ferramenta se apresenta como um fich&aacute;rio b&aacute;sico de fornecedores por produto ou fam&iacute;lia de produtos. Este cadastro &eacute; o m&iacute;nimo que voc&ecirc; precisa para saber de quem comprar quando precisar.</span></p>',2,131,5),
 (27,22,'INSTRUÇÃO DE TRABALHO','S','<p><strong><span style=\"font-family: Tahoma;\">O que &eacute;: </span></strong><span style=\"font-family: Tahoma;\"><br />\r\n<br />\r\nA Instru&ccedil;&atilde;o de Trabalho &eacute; uma ferramenta para documentar ou padronizar tarefas espec&iacute;ficas e operacionais. Com ela voc&ecirc; faz a descri&ccedil;&atilde;o e tamb&eacute;m a ilustra&ccedil;&atilde;o de como fazer determinado processo. Com isso, voc&ecirc; pode delegar e cobrar a realiza&ccedil;&atilde;o do trabalho de seus funcion&aacute;rios.</span></p>',3,135,5),
 (28,23,'COMPETÊNCIAS NECESSÁRIAS','S','<p><strong><span style=\"font-family: Tahoma;\">O que &eacute;: </span></strong><span style=\"font-family: Tahoma;\"><br />\r\n<br />\r\nEssa ferramenta visa orientar voc&ecirc; sobre como definir o que as pessoas precisam para trabalhar bem, assim como, havendo a necessidade de contrata&ccedil;&atilde;o, identificar quais as compet&ecirc;ncias essenciais para o neg&oacute;cio s&atilde;o desejadas dos candidatos.<span class=\"Apple-tab-span\" style=\"white-space: pre;\">			</span>&nbsp;</span></p>',1,143,6),
 (29,24,'ORIENTAÇÕES PARA OBRIGAÇÕES TRABALHISTAS','S','<p><strong><span style=\"font-family: Tahoma;\">O que &eacute;: </span></strong><span style=\"font-family: Tahoma;\"><br />\r\n<br />\r\nEssa ferramenta visa orientar voc&ecirc;, que inicia o processo de recrutamento, sobre como agir com os funcion&aacute;rios desde a contrata&ccedil;&atilde;o at&eacute; sua eventual demiss&atilde;o, al&eacute;m de orient&aacute;-lo para todas as obriga&ccedil;&otilde;es trabalhistas relacionadas com voc&ecirc; e com seus funcion&aacute;rios. Isso pode evitar um conjunto de preju&iacute;zos de rela&ccedil;&atilde;o trabalhista que podem impactar no resultado da empresa e na insatisfa&ccedil;&atilde;o dos funcion&aacute;rios.</span></p>',1,147,6),
 (30,25,'MATRIZ DE RESPONSABILIDADES','S','<p><strong><span style=\"font-family: Tahoma;\">O que &eacute;: </span></strong><span style=\"font-family: Tahoma;\"><br />\r\n<br />\r\nAo utilizar esta ferramenta voc&ecirc; ir&aacute; identificar as responsabilidades esperadas dos seus funcion&aacute;rios e que eles est&atilde;o aptos a realizar. Poder&aacute; tamb&eacute;m definir quem &eacute; a pessoa substituta em caso de aus&ecirc;ncia do respons&aacute;vel.</span></p>',2,150,4),
 (31,26,'PENSANDO EM EXPANDIR? PREPARE-SE PARA DELEGAR','S','<p><strong><span style=\"font-family: Tahoma;\">O que &eacute;: </span></strong><span style=\"font-family: Tahoma;\"><br />\r\n<br />\r\nEsta ferramenta far&aacute; voc&ecirc; refletir sobre a import&acirc;ncia da delega&ccedil;&atilde;o de tarefas para que possa expandir seu neg&oacute;cio. Este processo de delega&ccedil;&atilde;o deve ser conduzido de maneira organizada e sistem&aacute;tica para seus funcion&aacute;rios. Somente delegando ser&aacute; poss&iacute;vel que voc&ecirc; invista mais tempo em atividades estrat&eacute;gicas para seu neg&oacute;cio</span></p>',3,154,6),
 (32,27,'TREINAMENTO BASEADO EM PROBLEMAS','S','<p><strong><span style=\"font-family: Tahoma;\">O que &eacute;: </span></strong><span style=\"font-family: Tahoma;\"><br />\r\n<br />\r\nEsta ferramenta ir&aacute; orientar voc&ecirc; a realizar treinamentos com base na an&aacute;lise de problemas. Estes problemas podem ter ocorrido, ou a partir da sua experi&ecirc;ncia, podem vir a ocorrer no futuro.</span></p>',3,158,6),
 (33,28,'CONHECIMENTOS E CARACTERÍSTICAS','S',NULL,1,159,6),
 (36,29,'LAYOUT E ORGANIZAÇÃO DO EMPREENDIMENTO','S',NULL,1,160,7),
 (37,30,'TRENA DAS VENDAS','S',NULL,1,161,7),
 (38,31,'MATERIAL DE SINALIZAÇÃO','S',NULL,1,162,7),
 (39,32,'RELACIONAMENTO COM O CLIENTE','S',NULL,1,163,7),
 (40,33,'ANÁLISE DOS PROCEDIMENTOS NA EMPRESA','S',NULL,1,164,7);
/*!40000 ALTER TABLE `grc_formulario_ferramenta_gestao` ENABLE KEYS */;


--
-- Definition of table `grc_formulario_pergunta`
--

DROP TABLE IF EXISTS `grc_formulario_pergunta`;
CREATE TABLE `grc_formulario_pergunta` (
  `idt` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idt_secao` int(10) unsigned NOT NULL,
  `codigo` int(10) unsigned NOT NULL,
  `descricao` varchar(2000) NOT NULL,
  `detalhe` text,
  `qtd_pontos` int(10) DEFAULT NULL,
  `valido` char(1) NOT NULL DEFAULT 'S',
  `idt_classe` int(10) unsigned NOT NULL,
  `ajuda` text,
  `idt_ferramenta` int(10) unsigned DEFAULT NULL,
  `obrigatoria` varchar(1) NOT NULL DEFAULT 'S',
  `evidencias` text,
  `idt_dimensao` int(10) unsigned NOT NULL,
  `codigo_quesito` int(10) unsigned DEFAULT NULL,
  `sigla_dimensao` varchar(5) DEFAULT NULL,
  PRIMARY KEY (`idt`),
  UNIQUE KEY `iu_grc_formulario_pergunta` (`idt_secao`,`idt_dimensao`,`codigo`) USING BTREE,
  KEY `FK_grc_formulario_pergunta_3` (`idt_classe`),
  KEY `FK_grc_formulario_pergunta_4` (`idt_ferramenta`),
  CONSTRAINT `FK_grc_formulario_pergunta_2` FOREIGN KEY (`idt_secao`) REFERENCES `grc_formulario_secao` (`idt`) ON UPDATE CASCADE,
  CONSTRAINT `FK_grc_formulario_pergunta_3` FOREIGN KEY (`idt_classe`) REFERENCES `grc_formulario_classe_pergunta` (`idt`) ON UPDATE CASCADE,
  CONSTRAINT `FK_grc_formulario_pergunta_4` FOREIGN KEY (`idt_ferramenta`) REFERENCES `grc_formulario_ferramenta_gestao` (`idt`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=830 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `grc_formulario_pergunta`
--

/*!40000 ALTER TABLE `grc_formulario_pergunta` DISABLE KEYS */;
INSERT INTO `grc_formulario_pergunta` (`idt`,`idt_secao`,`codigo`,`descricao`,`detalhe`,`qtd_pontos`,`valido`,`idt_classe`,`ajuda`,`idt_ferramenta`,`obrigatoria`,`evidencias`,`idt_dimensao`,`codigo_quesito`,`sigla_dimensao`) VALUES 
 (1,1,1,'Você controla as entradas e saídas diárias de dinheiro?','PERGUNTA',30,'S',2,NULL,2,'S',NULL,0,NULL,NULL),
 (4,4,1,'Sua empresa tem um cadastro com informações de seus clientes em algum lugar?','PERGUNTA',20,'S',2,NULL,13,'S',NULL,0,NULL,NULL),
 (7,7,1,'Você planeja os objetivos que deseja alcançar, tendo alguma forma de registro de onde quer chegar?','PERGUNTA',50,'S',2,NULL,20,'S',NULL,0,NULL,NULL),
 (8,8,2,'Como você se sente quanto ao Dimensionamento do Capital de Giro na sua empresa?',NULL,10,'S',2,NULL,2,'S',NULL,0,NULL,NULL),
 (10,8,3,'Como você se sente quanto à gestão dos Pagamentos de Impostos da sua empresa?',NULL,10,'S',2,NULL,2,'S',NULL,0,NULL,NULL),
 (11,8,1,'Como você se sente quanto ao Controle do Fluxo de Caixa da sua empresa?',NULL,0,'S',2,NULL,8,'S',NULL,0,NULL,NULL),
 (12,8,4,'Como você se sente quanto Identificação e Cálculos dos Custos da empresa?',NULL,0,'S',2,NULL,12,'N',NULL,0,NULL,NULL),
 (13,8,5,'Como você se sente quanto ao controle Periódico do Lucro da empresa?',NULL,0,'S',2,NULL,8,'N',NULL,0,NULL,NULL),
 (14,8,6,'Como você se sente quanto a Análise do Preço de Venda dos produtos da empresa?',NULL,0,'S',2,NULL,8,'N',NULL,0,NULL,NULL),
 (15,8,7,'Como você se sente quanto à Gestão de Estoques da sua empresa?',NULL,0,'S',2,NULL,11,'N',NULL,0,NULL,NULL),
 (16,1,2,'Você possui um controle de entradas, saídas e saldo de dinheiro para os meses futuros?','PERGUNTA',0,'S',2,NULL,8,'N',NULL,0,NULL,NULL),
 (17,1,3,'Você sabe quanto dinheiro deve ter em caixa para cobrir suas despesas enquanto não recebe os pagamentos?','PERGUNTA',0,'S',2,NULL,12,'N',NULL,0,NULL,NULL),
 (18,1,4,'Você controla as datas e valores de todos os tributos a serem pagos? (Impostos e também Taxas)','PERGUNTA',0,'S',2,NULL,7,'N',NULL,0,NULL,NULL),
 (19,1,5,'Você calcula os gastos (custos e despesas) mensalmente?','PERGUNTA',0,'S',2,NULL,10,'S',NULL,0,NULL,NULL),
 (20,1,6,'Você calcula o resultado (lucro ou prejuízo) do seu negócio periodicamente?','PERGUNTA',0,'S',2,NULL,10,'S',NULL,0,NULL,NULL),
 (21,1,7,'Você sabe qual é o seu ganho de dinheiro em cada produto ou serviço vendido?','PERGUNTA',0,'S',2,NULL,9,'S',NULL,0,NULL,NULL),
 (22,1,8,'Você tem um controle do estoque dos produtos e insumos? (incluindo datas de validade, quantidade, etc.)','PERGUNTA',0,'S',2,NULL,11,'S',NULL,0,NULL,NULL),
 (23,4,2,'A empresa sabe quais são os diferentes grupos de clientes que frequentam seu estabelecimento e faz ações direcionadas a cada um destes grupos?','PERGUNTA',0,'S',2,NULL,16,'S',NULL,0,NULL,NULL),
 (24,4,3,'Você analisa regularmente as necessidades dos clientes para orientar suas ações de marketing e definição de serviços e produtos?','PERGUNTA',0,'S',2,NULL,15,'S',NULL,0,NULL,NULL),
 (25,4,4,'Você faz alguma pesquisa para saber a satisfação dos clientes?','PERGUNTA',0,'S',2,NULL,14,'S',NULL,0,NULL,NULL),
 (26,4,5,'Você planeja ações para promover e divulgar seus produtos e serviços?','PERGUNTA',0,'S',2,NULL,19,'S',NULL,0,NULL,NULL),
 (27,4,6,'Sua empresa oferta novos produtos/serviços para seus clientes? (Observar critérios para escolha dos produtos e teste dos produtos novos)','PERGUNTA',0,'S',2,NULL,17,'S',NULL,0,NULL,NULL),
 (28,4,7,'Você avalia seus concorrentes para saber o que deve melhorar?','PERGUNTA',0,'S',2,NULL,18,'S',NULL,0,NULL,NULL),
 (29,7,2,'Você tem seus objetivos e metas escritos e bem definidos?','PERGUNTA',0,'S',2,NULL,21,'S',NULL,0,NULL,NULL),
 (30,7,3,'Você toma nota das decisões e resultados de seu planejamento, observando situações em que houve resultados diferentes dos que você queria, para aprimorar o que deu certo e não repetir erros do passado?','PERGUNTA',0,'S',2,NULL,23,'S',NULL,0,NULL,NULL),
 (31,7,4,'Existem ações com prazos definidos para que os objetivos planejados pela empresa para o futuro possam ser alcançados?','PERGUNTA',0,'S',2,NULL,22,'S',NULL,0,NULL,NULL),
 (32,10,1,'Controle de Resultados na sua empresa, você considera que está:','PERCEPÇÃO DO EMPRESÁRIO',12,'S',2,'12',2,'S',NULL,0,NULL,NULL),
 (33,11,1,'Você possui um controle de quem são os fornecedores de seus produtos e prestadores de serviço, facilitando sua pesquisa de preços?','PERGUNTA',NULL,'S',2,NULL,26,'S',NULL,0,NULL,NULL),
 (34,11,2,'Os documentos importantes de sua empresas e contas estão bem organizados?','PERGUNTA',NULL,'S',2,NULL,25,'S',NULL,0,NULL,NULL),
 (35,11,3,'As atividades realizadas regularmente possuem um procedimento escrito de como elas devem ser feitas?','PERGUNTA',NULL,'S',2,NULL,27,'S',NULL,0,NULL,NULL),
 (36,11,4,'A organização da sua empresa permite que você trabalhe de maneira eficiente e ágil?','PERGUNTA',NULL,'S',2,NULL,24,'S',NULL,0,NULL,NULL),
 (37,11,5,'Sua empresa possui um layout (arranjo físico) definido para facilitar a entrega do produto/serviço, comercialização e atendimento aos clientes?','PEGUNTA',NULL,'S',2,NULL,NULL,'S',NULL,0,NULL,NULL),
 (38,12,1,'Você sabe quais são as obrigações trabalhistas de sua empresa, da contratação até o desligamento? E em relação a você, sabe o que fazer para se aposentar com tranquilidade?','PERGUNTA',NULL,'S',2,NULL,29,'S',NULL,0,NULL,NULL),
 (39,12,2,'Você já definiu que conhecimentos e características as pessoas devem ter para realizar as atividades em sua empresa, incluindo você e sócios?','PERGUNTA',NULL,'S',2,NULL,33,'S',NULL,0,NULL,NULL),
 (40,12,3,'Se você, seu sócio ou algum funcionário faltar ou tirar férias, está definido um responsável para ficar no lugar desta pessoa?','PERGUNTA',NULL,'S',2,NULL,30,'S',NULL,0,NULL,NULL),
 (41,12,4,'Você faz uma avaliação dos problemas recorrentes ou potenciais em seu negócio, visando evitar que os mesmos ocorram?','PERGUNTA',NULL,'S',2,NULL,32,'S',NULL,0,NULL,NULL),
 (42,12,5,'Se for necessário delegar alguma atividade (por motivo de doença, expansão, etc.), você já sabe quais são as atividades que pode delegar?','PERGUNTA',NULL,'S',2,NULL,31,'S',NULL,0,NULL,NULL),
 (43,13,1,'A organização do espaço de forma geral é clara e a circulação está desobstruída?','PERGUNTA',NULL,'S',2,NULL,36,'S',NULL,0,NULL,NULL),
 (44,13,2,'A empresa comercializa produtos de forma que a exposição deles favoreça a venda?','PERGUNTA',NULL,'S',2,NULL,37,'S',NULL,0,NULL,NULL),
 (45,13,3,'A empresa possui marca própria e comunicação visual padronizada? Todas as áreas do estabelecimento onde a circulação é desejada são acessadas pelos clientes? Visualmente, os clientes e funcionários conseguem encontrar a informação que precisam?','PERGUNTA',NULL,'S',2,NULL,38,'S',NULL,0,NULL,NULL),
 (48,13,4,'Os clientes são pessoas ou organizações que usam ou consomem produtos para atender às determinadas necessidades. Os métodos de inovação centrados no cliente divergem das abordagens tradicionais, caracterizadas pela busca da inovação por meio de avanços tecnológicos ou da otimização dos processos comerciais. Inovar nesta dimensão significa, por exemplo, encontrar um novo nicho de mercado para determinado produto ou serviço. A empresa adota alguma prática de relacionamento ou pesquisa sistemática para identificar as necessidades do mercado ou dos clientes?','PERGUNTA',NULL,'S',2,NULL,39,'S',NULL,0,NULL,NULL),
 (49,13,5,'Os processos são as configurações das atividades usadas na condução das operações internas à empresa. A inovação, nesta dimensão, pressupõe o reprojeto de seus processos para buscar maior eficiência, maior qualidade ou um tempo de resposta (tempo de ciclo) menor. A empresa alterou seus processos para obter maior eficiência, qualidade, flexibilidade ou menor ciclo de produção?','PERGUNTA',NULL,'S',2,NULL,40,'S',NULL,0,NULL,NULL),
 (50,14,1,'Compreensão das Necessidades que atende em sua empresa, você considera que está:',NULL,NULL,'S',2,NULL,2,'S',NULL,0,NULL,NULL),
 (51,15,1,'Visão de longo prazo na sua empresa, você considera que está:',NULL,NULL,'S',2,NULL,2,'S',NULL,0,NULL,NULL),
 (52,16,1,'Na sua empresa, você considera que está:',NULL,NULL,'S',2,NULL,2,'S',NULL,0,NULL,NULL),
 (53,17,1,'Na sua empresa, você considera que está:',NULL,NULL,'S',2,NULL,2,'S',NULL,0,NULL,NULL),
 (54,18,1,'Compreensão das Necessidades de inovação que atende em sua empresa, você considera que está:',NULL,NULL,'S',2,NULL,2,'S',NULL,0,NULL,NULL),
 (55,19,1,'Como você se sente quanto ao seu conhecimento das Características dos seus Clientes?',NULL,NULL,'S',2,NULL,2,'S',NULL,0,NULL,NULL),
 (56,19,2,'Como você se sente quanto ao seu conhecimento da Satisfação dos seus Clientes?',NULL,NULL,'S',2,NULL,2,'S',NULL,0,NULL,NULL),
 (57,19,3,'Como você se sente quanto à Divulgação de seus produtos e/ou serviços?',NULL,NULL,'S',2,NULL,2,'S',NULL,0,NULL,NULL),
 (58,19,4,'Como você se sente quanto à Expansão para novas áreas e lançamento de novos produtos/serviços?',NULL,NULL,'S',2,NULL,2,'S',NULL,0,NULL,NULL),
 (59,19,5,'Como você se sente quanto ao entendimento da Concorrência no seu mercado?',NULL,NULL,'S',2,NULL,2,'S',NULL,0,NULL,NULL),
 (60,20,1,'Como você se sente quanto ao Plano de Negócios da sua empresa?',NULL,NULL,'S',2,NULL,2,'S',NULL,0,NULL,NULL),
 (61,20,2,'Como você se sente quanto à Organização das Ações de Curto e Médio Prazo da sua empresa?',NULL,NULL,'S',2,NULL,2,'S',NULL,0,NULL,NULL),
 (62,21,1,'Como você se sente quanto à Gestão dos Fornecedores da sua empresa?',NULL,NULL,'S',2,NULL,2,'S',NULL,0,NULL,NULL),
 (63,21,2,'Como você se sente quanto à Organização de Documentos da sua empresa?',NULL,NULL,'S',2,NULL,2,'S',NULL,0,NULL,NULL),
 (64,21,3,'Como você se sente quanto à Padronização das Atividades da sua empresa?',NULL,NULL,'S',2,NULL,2,'S',NULL,0,NULL,NULL),
 (65,21,4,'Como você se sente quanto ao Layout da sua empresa?',NULL,NULL,'S',2,NULL,2,'S',NULL,0,NULL,NULL),
 (66,22,1,'Como você se sente quanto à Gestão das Pessoas em termos de legislação e responsabilidade social da sua empresa?',NULL,NULL,'S',2,NULL,2,'S',NULL,0,NULL,NULL),
 (67,22,2,'Como você se sente quanto à Gestão das Pessoas em termos de desenvolvimento de equipe na sua empresa?',NULL,NULL,'S',2,NULL,2,'S',NULL,0,NULL,NULL),
 (68,23,1,'Como você se sente quanto à sistematização organizacional na sua empresa?',NULL,NULL,'S',2,NULL,2,'S',NULL,0,NULL,NULL),
 (69,23,2,'Como você se sente quanto ao serviço e relacionamento com o cliente na sua empresa?',NULL,NULL,'S',2,NULL,2,'S',NULL,0,NULL,NULL),
 (70,23,3,'Como você se sente quanto ao processo de inovação na sua empresa?',NULL,NULL,'S',2,NULL,2,'S',NULL,0,NULL,NULL),
 (767,107,1,'Você controla as entradas e saídas diárias de dinheiro?','PERGUNTA',30,'S',2,NULL,2,'S',NULL,2,1,'E'),
 (768,107,2,'Você possui um controle de entradas, saídas e saldo de dinheiro para os meses futuros?','PERGUNTA',0,'S',2,NULL,8,'N',NULL,2,1,'E'),
 (769,107,3,'Você sabe quanto dinheiro deve ter em caixa para cobrir suas despesas enquanto não recebe os pagamentos?','PERGUNTA',0,'S',2,NULL,12,'N',NULL,2,2,'E'),
 (770,107,4,'Você controla as datas e valores de todos os tributos a serem pagos? (Impostos e também Taxas)','PERGUNTA',0,'S',2,NULL,7,'N',NULL,2,3,'E'),
 (771,107,5,'Você calcula os gastos (custos e despesas) mensalmente?','PERGUNTA',0,'S',2,NULL,10,'S',NULL,2,4,'E'),
 (772,107,6,'Você calcula o resultado (lucro ou prejuízo) do seu negócio periodicamente?','PERGUNTA',0,'S',2,NULL,10,'S',NULL,2,5,'E'),
 (773,107,7,'Você sabe qual é o seu ganho de dinheiro em cada produto ou serviço vendido?','PERGUNTA',0,'S',2,NULL,9,'S',NULL,2,6,'E'),
 (774,107,8,'Você tem um controle do estoque dos produtos e insumos? (incluindo datas de validade, quantidade, etc.)','PERGUNTA',0,'S',2,NULL,11,'S',NULL,2,7,'E'),
 (775,108,1,'Sua empresa tem um cadastro com informações de seus clientes em algum lugar?','PERGUNTA',20,'S',2,NULL,13,'S',NULL,2,1,'E'),
 (776,108,2,'A empresa sabe quais são os diferentes grupos de clientes que frequentam seu estabelecimento e faz ações direcionadas a cada um destes grupos?','PERGUNTA',0,'S',2,NULL,16,'S',NULL,2,1,'E'),
 (777,108,3,'Você analisa regularmente as necessidades dos clientes para orientar suas ações de marketing e definição de serviços e produtos?','PERGUNTA',0,'S',2,NULL,15,'S',NULL,2,1,'E'),
 (778,108,4,'Você faz alguma pesquisa para saber a satisfação dos clientes?','PERGUNTA',0,'S',2,NULL,14,'S',NULL,2,2,'E'),
 (779,108,5,'Você planeja ações para promover e divulgar seus produtos e serviços?','PERGUNTA',0,'S',2,NULL,19,'S',NULL,2,3,'E'),
 (780,108,6,'Sua empresa oferta novos produtos/serviços para seus clientes? (Observar critérios para escolha dos produtos e teste dos produtos novos)','PERGUNTA',0,'S',2,NULL,17,'S',NULL,2,4,'E'),
 (781,108,7,'Você avalia seus concorrentes para saber o que deve melhorar?','PERGUNTA',0,'S',2,NULL,18,'S',NULL,2,5,'E'),
 (782,109,1,'Você planeja os objetivos que deseja alcançar, tendo alguma forma de registro de onde quer chegar?','PERGUNTA',50,'S',2,NULL,20,'S',NULL,2,1,'E'),
 (783,109,2,'Você tem seus objetivos e metas escritos e bem definidos?','PERGUNTA',0,'S',2,NULL,21,'S',NULL,2,1,'E'),
 (784,109,3,'Você toma nota das decisões e resultados de seu planejamento, observando situações em que houve resultados diferentes dos que você queria, para aprimorar o que deu certo e não repetir erros do passado?','PERGUNTA',0,'S',2,NULL,23,'S',NULL,2,1,'E'),
 (785,109,4,'Existem ações com prazos definidos para que os objetivos planejados pela empresa para o futuro possam ser alcançados?','PERGUNTA',0,'S',2,NULL,22,'S',NULL,2,2,'E'),
 (786,110,1,'Você possui um controle de quem são os fornecedores de seus produtos e prestadores de serviço, facilitando sua pesquisa de preços?','PERGUNTA',NULL,'S',2,NULL,26,'S',NULL,2,1,'E'),
 (787,110,2,'Os documentos importantes de sua empresas e contas estão bem organizados?','PERGUNTA',NULL,'S',2,NULL,25,'S',NULL,2,2,'E'),
 (788,110,3,'As atividades realizadas regularmente possuem um procedimento escrito de como elas devem ser feitas?','PERGUNTA',NULL,'S',2,NULL,27,'S',NULL,2,3,'E'),
 (789,110,4,'A organização da sua empresa permite que você trabalhe de maneira eficiente e ágil?','PERGUNTA',NULL,'S',2,NULL,24,'S',NULL,2,4,'E'),
 (790,110,5,'Sua empresa possui um layout (arranjo físico) definido para facilitar a entrega do produto/serviço, comercialização e atendimento aos clientes?','PEGUNTA',NULL,'S',2,NULL,NULL,'S',NULL,2,4,'E'),
 (791,111,1,'Você sabe quais são as obrigações trabalhistas de sua empresa, da contratação até o desligamento? E em relação a você, sabe o que fazer para se aposentar com tranquilidade?','PERGUNTA',NULL,'S',2,NULL,29,'S',NULL,2,1,'E'),
 (792,111,2,'Você já definiu que conhecimentos e características as pessoas devem ter para realizar as atividades em sua empresa, incluindo você e sócios?','PERGUNTA',NULL,'S',2,NULL,33,'S',NULL,2,2,'E'),
 (793,111,3,'Se você, seu sócio ou algum funcionário faltar ou tirar férias, está definido um responsável para ficar no lugar desta pessoa?','PERGUNTA',NULL,'S',2,NULL,30,'S',NULL,2,2,'E'),
 (794,111,4,'Você faz uma avaliação dos problemas recorrentes ou potenciais em seu negócio, visando evitar que os mesmos ocorram?','PERGUNTA',NULL,'S',2,NULL,32,'S',NULL,2,2,'E'),
 (795,111,5,'Se for necessário delegar alguma atividade (por motivo de doença, expansão, etc.), você já sabe quais são as atividades que pode delegar?','PERGUNTA',NULL,'S',2,NULL,31,'S',NULL,2,2,'E'),
 (796,112,1,'A organização do espaço de forma geral é clara e a circulação está desobstruída?','PERGUNTA',NULL,'S',2,NULL,36,'S',NULL,2,1,'E'),
 (797,112,2,'A empresa comercializa produtos de forma que a exposição deles favoreça a venda?','PERGUNTA',NULL,'S',2,NULL,37,'S',NULL,2,1,'E'),
 (798,112,3,'A empresa possui marca própria e comunicação visual padronizada? Todas as áreas do estabelecimento onde a circulação é desejada são acessadas pelos clientes? Visualmente, os clientes e funcionários conseguem encontrar a informação que precisam?','PERGUNTA',NULL,'S',2,NULL,38,'S',NULL,2,1,'E'),
 (799,112,4,'Os clientes são pessoas ou organizações que usam ou consomem produtos para atender às determinadas necessidades. Os métodos de inovação centrados no cliente divergem das abordagens tradicionais, caracterizadas pela busca da inovação por meio de avanços tecnológicos ou da otimização dos processos comerciais. Inovar nesta dimensão significa, por exemplo, encontrar um novo nicho de mercado para determinado produto ou serviço. A empresa adota alguma prática de relacionamento ou pesquisa sistemática para identificar as necessidades do mercado ou dos clientes?','PERGUNTA',NULL,'S',2,NULL,39,'S',NULL,2,2,'E'),
 (800,112,5,'Os processos são as configurações das atividades usadas na condução das operações internas à empresa. A inovação, nesta dimensão, pressupõe o reprojeto de seus processos para buscar maior eficiência, maior qualidade ou um tempo de resposta (tempo de ciclo) menor. A empresa alterou seus processos para obter maior eficiência, qualidade, flexibilidade ou menor ciclo de produção?','PERGUNTA',NULL,'S',2,NULL,40,'S',NULL,2,3,'E'),
 (801,107,1,'Como você se sente quanto ao Controle do Fluxo de Caixa da sua empresa?',NULL,0,'S',2,NULL,8,'S',NULL,4,1,'Q'),
 (802,107,2,'Como você se sente quanto ao Dimensionamento do Capital de Giro na sua empresa?',NULL,10,'S',2,NULL,2,'S',NULL,4,2,'Q'),
 (803,107,3,'Como você se sente quanto à gestão dos Pagamentos de Impostos da sua empresa?',NULL,10,'S',2,NULL,2,'S',NULL,4,3,'Q'),
 (804,107,4,'Como você se sente quanto Identificação e Cálculos dos Custos da empresa?',NULL,0,'S',2,NULL,12,'N',NULL,4,4,'Q'),
 (805,107,5,'Como você se sente quanto ao controle Periódico do Lucro da empresa?',NULL,0,'S',2,NULL,8,'N',NULL,4,5,'Q'),
 (806,107,6,'Como você se sente quanto a Análise do Preço de Venda dos produtos da empresa?',NULL,0,'S',2,NULL,8,'N',NULL,4,6,'Q'),
 (807,107,7,'Como você se sente quanto à Gestão de Estoques da sua empresa?',NULL,0,'S',2,NULL,11,'N',NULL,4,7,'Q'),
 (808,108,1,'Como você se sente quanto ao seu conhecimento das Características dos seus Clientes?',NULL,NULL,'S',2,NULL,2,'S',NULL,4,1,'Q'),
 (809,108,2,'Como você se sente quanto ao seu conhecimento da Satisfação dos seus Clientes?',NULL,NULL,'S',2,NULL,2,'S',NULL,4,2,'Q'),
 (810,108,3,'Como você se sente quanto à Divulgação de seus produtos e/ou serviços?',NULL,NULL,'S',2,NULL,2,'S',NULL,4,3,'Q'),
 (811,108,4,'Como você se sente quanto à Expansão para novas áreas e lançamento de novos produtos/serviços?',NULL,NULL,'S',2,NULL,2,'S',NULL,4,4,'Q'),
 (812,108,5,'Como você se sente quanto ao entendimento da Concorrência no seu mercado?',NULL,NULL,'S',2,NULL,2,'S',NULL,4,5,'Q'),
 (813,109,1,'Como você se sente quanto ao Plano de Negócios da sua empresa?',NULL,NULL,'S',2,NULL,2,'S',NULL,4,1,'Q'),
 (814,109,2,'Como você se sente quanto à Organização das Ações de Curto e Médio Prazo da sua empresa?',NULL,NULL,'S',2,NULL,2,'S',NULL,4,2,'Q'),
 (815,110,1,'Como você se sente quanto à Gestão dos Fornecedores da sua empresa?',NULL,NULL,'S',2,NULL,2,'S',NULL,4,1,'Q'),
 (816,110,2,'Como você se sente quanto à Organização de Documentos da sua empresa?',NULL,NULL,'S',2,NULL,2,'S',NULL,4,2,'Q'),
 (817,110,3,'Como você se sente quanto à Padronização das Atividades da sua empresa?',NULL,NULL,'S',2,NULL,2,'S',NULL,4,3,'Q'),
 (818,110,4,'Como você se sente quanto ao Layout da sua empresa?',NULL,NULL,'S',2,NULL,2,'S',NULL,4,4,'Q'),
 (819,111,1,'Como você se sente quanto à Gestão das Pessoas em termos de legislação e responsabilidade social da sua empresa?',NULL,NULL,'S',2,NULL,2,'S',NULL,4,1,'Q'),
 (820,111,2,'Como você se sente quanto à Gestão das Pessoas em termos de desenvolvimento de equipe na sua empresa?',NULL,NULL,'S',2,NULL,2,'S',NULL,4,2,'Q'),
 (821,112,1,'Como você se sente quanto à sistematização organizacional na sua empresa?',NULL,NULL,'S',2,NULL,2,'S',NULL,4,1,'Q'),
 (822,112,2,'Como você se sente quanto ao serviço e relacionamento com o cliente na sua empresa?',NULL,NULL,'S',2,NULL,2,'S',NULL,4,2,'Q'),
 (823,112,3,'Como você se sente quanto ao processo de inovação na sua empresa?',NULL,NULL,'S',2,NULL,2,'S',NULL,4,3,'Q'),
 (824,107,1,'Controle de Resultados na sua empresa, você considera que está:','PERCEPÇÃO DO EMPRESÁRIO',12,'S',2,'12',2,'S',NULL,5,99,'A'),
 (825,108,1,'Compreensão das Necessidades que atende em sua empresa, você considera que está:',NULL,NULL,'S',2,NULL,2,'S',NULL,5,99,'A'),
 (826,109,1,'Visão de longo prazo na sua empresa, você considera que está:',NULL,NULL,'S',2,NULL,2,'S',NULL,5,99,'A'),
 (827,110,1,'Na sua empresa, você considera que está:',NULL,NULL,'S',2,NULL,2,'S',NULL,5,99,'A'),
 (828,111,1,'Na sua empresa, você considera que está:',NULL,NULL,'S',2,NULL,2,'S',NULL,5,99,'A'),
 (829,112,1,'Compreensão das Necessidades de inovação que atende em sua empresa, você considera que está:',NULL,NULL,'S',2,NULL,2,'S',NULL,5,99,'A');
/*!40000 ALTER TABLE `grc_formulario_pergunta` ENABLE KEYS */;


--
-- Definition of table `grc_formulario_pergunta_pergunta`
--

DROP TABLE IF EXISTS `grc_formulario_pergunta_pergunta`;
CREATE TABLE `grc_formulario_pergunta_pergunta` (
  `idt` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idt_pergunta_n1` int(10) unsigned NOT NULL,
  `idt_pergunta_n2` int(10) unsigned NOT NULL,
  PRIMARY KEY (`idt`),
  UNIQUE KEY `iu_grc_formulario_pergunta_pergunta` (`idt_pergunta_n1`,`idt_pergunta_n2`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `grc_formulario_pergunta_pergunta`
--

/*!40000 ALTER TABLE `grc_formulario_pergunta_pergunta` DISABLE KEYS */;
INSERT INTO `grc_formulario_pergunta_pergunta` (`idt`,`idt_pergunta_n1`,`idt_pergunta_n2`) VALUES 
 (4,8,17),
 (5,10,18),
 (2,11,1),
 (3,11,16),
 (6,12,19),
 (9,13,20),
 (7,14,21),
 (8,15,22),
 (10,55,4),
 (11,55,23),
 (12,55,24),
 (13,56,25),
 (14,57,26),
 (15,58,27),
 (16,59,28),
 (17,60,7),
 (18,60,29),
 (19,60,30),
 (20,61,31),
 (21,62,33),
 (22,63,34),
 (23,64,35),
 (24,65,36),
 (25,65,37),
 (26,66,38),
 (27,67,39),
 (28,67,40),
 (29,67,41),
 (30,67,42),
 (31,68,43),
 (32,68,44),
 (33,68,45),
 (34,69,48),
 (35,70,49);
/*!40000 ALTER TABLE `grc_formulario_pergunta_pergunta` ENABLE KEYS */;


--
-- Definition of table `grc_formulario_relevancia`
--

DROP TABLE IF EXISTS `grc_formulario_relevancia`;
CREATE TABLE `grc_formulario_relevancia` (
  `idt` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `codigo` varchar(45) NOT NULL,
  `descricao` varchar(120) NOT NULL,
  `ativo` varchar(1) NOT NULL,
  `detalhe` text,
  PRIMARY KEY (`idt`),
  UNIQUE KEY `iu_grc_formulario_relevancia` (`codigo`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `grc_formulario_relevancia`
--

/*!40000 ALTER TABLE `grc_formulario_relevancia` DISABLE KEYS */;
INSERT INTO `grc_formulario_relevancia` (`idt`,`codigo`,`descricao`,`ativo`,`detalhe`) VALUES 
 (2,'01','Não tem relevância','S',NULL),
 (3,'02','Relevância de baixo impacto','S',NULL),
 (4,'03','Relevância de médio impacto','S',NULL),
 (5,'04','Relevância de alto impacto','S',NULL);
/*!40000 ALTER TABLE `grc_formulario_relevancia` ENABLE KEYS */;


--
-- Definition of table `grc_formulario_resposta`
--

DROP TABLE IF EXISTS `grc_formulario_resposta`;
CREATE TABLE `grc_formulario_resposta` (
  `idt` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idt_pergunta` int(10) unsigned NOT NULL,
  `codigo` int(10) unsigned NOT NULL,
  `descricao` varchar(2000) NOT NULL,
  `detalhe` text,
  `qtd_pontos` int(10) DEFAULT NULL,
  `valido` char(1) NOT NULL DEFAULT 'S',
  `campo_txt` char(1) NOT NULL DEFAULT 'N',
  `idt_classe` int(10) unsigned NOT NULL,
  PRIMARY KEY (`idt`),
  UNIQUE KEY `iu_grc_formulario_resposta` (`idt_pergunta`,`codigo`),
  KEY `FK_grc_formulario_resposta_2` (`idt_classe`),
  CONSTRAINT `FK_grc_formulario_resposta_1` FOREIGN KEY (`idt_pergunta`) REFERENCES `grc_formulario_pergunta` (`idt`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_grc_formulario_resposta_2` FOREIGN KEY (`idt_classe`) REFERENCES `grc_formulario_classe_resposta` (`idt`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2202 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `grc_formulario_resposta`
--

/*!40000 ALTER TABLE `grc_formulario_resposta` DISABLE KEYS */;
INSERT INTO `grc_formulario_resposta` (`idt`,`idt_pergunta`,`codigo`,`descricao`,`detalhe`,`qtd_pontos`,`valido`,`campo_txt`,`idt_classe`) VALUES 
 (4,1,1,'Não, apenas vejo quanto tenho de dinheiro no final do dia.',NULL,10,'S','N',2),
 (6,1,2,'Tenho um controle informal das entradas e saídas de dinheiro.',NULL,10,'S','N',2),
 (7,4,1,'Não, não tenho um cadastro de clientes.',NULL,10,'S','N',2),
 (9,4,2,'Tenho um cadastro de clientes, mas não faço uso dele.',NULL,10,'S','N',2),
 (11,7,1,'Não, vou tocando o negócio sem planejar o futuro.',NULL,25,'S','N',2),
 (13,7,2,'Planejo na minha cabeça algumas coisas, porém não acho necessário definir como vou alcançar os objetivos.',NULL,25,'S','N',2),
 (15,1,3,'Sim, possuo um controle formalizado e detalhado das entradas e saídas de dinheiro.',NULL,10,'S','S',2),
 (16,8,1,'Melhorar com urgência, Nada Satisfeito.',NULL,4,'S','N',2),
 (18,8,2,'Preciso Melhorar, Pouco Satisfeito.',NULL,3,'S','N',2),
 (20,8,3,'Posso Aprimorar, Bastante Satisfeito.',NULL,3,'S','N',2),
 (21,10,1,'Melhorar com urgência, Nada Satisfeito.',NULL,5,'S','N',2),
 (23,10,2,'Preciso Melhorar, Pouco Satisfeito.',NULL,3,'S','N',2),
 (25,10,3,'Posso Aprimorar, Bastante Satisfeito.',NULL,2,'S','N',2),
 (26,11,1,'Melhorar com urgência, Nada Satisfeito.',NULL,0,'S','N',2),
 (27,11,2,'Preciso Melhorar, Pouco Satisfeito.',NULL,0,'S','N',2),
 (28,11,3,'Posso Aprimorar, Bastante Satisfeito.',NULL,0,'S','N',2),
 (29,11,4,'Manter, Totalmente Satisfeito.',NULL,0,'S','N',2),
 (30,8,4,'Manter, Totalmente Satisfeito.',NULL,0,'S','N',2),
 (31,10,4,'Manter, Totalmente Satisfeito.',NULL,0,'S','N',2),
 (32,12,1,'Melhorar com urgência, Nada Satisfeito.',NULL,0,'S','N',2),
 (33,12,2,'Preciso Melhorar, Pouco Satisfeito.',NULL,0,'S','N',2),
 (34,12,3,'Posso Aprimorar, Bastante Satisfeito.',NULL,0,'S','N',2),
 (35,12,4,'Manter, Totalmente Satisfeito.',NULL,0,'S','N',2),
 (36,13,1,'Melhorar com urgência, Nada Satisfeito.',NULL,0,'S','N',2),
 (37,13,2,'Preciso Melhorar, Pouco Satisfeito.',NULL,0,'S','N',2),
 (38,13,3,'Posso Aprimorar, Bastante Satisfeito.',NULL,0,'S','N',2),
 (39,13,4,'Manter, Totalmente Satisfeito.',NULL,0,'S','N',2),
 (40,14,1,'Melhorar com urgência, Nada Satisfeito.',NULL,0,'S','N',2),
 (41,14,2,'Preciso Melhorar, Pouco Satisfeito.',NULL,0,'S','N',2),
 (42,14,3,'Posso Aprimorar, Bastante Satisfeito.',NULL,0,'S','N',2),
 (43,14,4,'Manter, Totalmente Satisfeito.',NULL,0,'S','N',2),
 (44,15,1,'Melhorar com urgência, Nada Satisfeito.',NULL,0,'S','N',2),
 (45,15,2,'Preciso Melhorar, Pouco Satisfeito.',NULL,0,'S','N',2),
 (46,15,3,'Posso Aprimorar, Bastante Satisfeito.',NULL,0,'S','N',2),
 (47,15,4,'Manter, Totalmente Satisfeito.',NULL,0,'S','N',2),
 (48,16,1,'Não tenho este controle.',NULL,0,'S','N',2),
 (49,16,2,'Tenho um controle não formalizado e/ou que não prevê como estará o saldo no futuro.',NULL,0,'S','N',2),
 (50,16,3,'Sim, possuo planilhas para controlar o Fluxo de Caixa e visualizo ao longo do tempo quando terei falta ou sobra de dinheiro.',NULL,0,'S','N',2),
 (51,17,1,'Não faço este cálculo regularmente.',NULL,0,'S','N',2),
 (52,17,2,'Tenho noção de quais são minhas despesas, mas não sei quanto dinheiro preciso ter em caixa.',NULL,0,'S','N',2),
 (53,17,3,'Sim, calculo qual o valor que a empresa precisa ter em caixa para que não precise pedir dinheiro emprestado.',NULL,0,'S','N',2),
 (54,18,1,'Não, não tenho controle sobre o pagamento de tributos.',NULL,0,'S','N',2),
 (55,18,2,'Sei quando devem ser pagos alguns tributos, mas não tenho controle sobre quando cada um deve ser pago.',NULL,0,'S','N',2),
 (56,18,3,'Sim, possuo controle formal e registro de quando cada tributo deve ser pago, assim como registro os pagamentos.',NULL,0,'S','N',2),
 (57,19,1,'Não, não sei quais são os custos da empresa.',NULL,0,'S','N',2),
 (58,19,2,'Tenho noção de qual é o valor dos custos e despesas mensais da empresa, mas não tenho um controle preciso.',NULL,0,'S','N',2),
 (59,19,3,'Sim, registro qual o valor dos custos e despesas mensalmente, sabendo quanto foi o desembolso no período.',NULL,0,'S','N',2),
 (60,20,1,'Não, não sei qual foi o resultado da empresa no período.',NULL,0,'S','N',2),
 (61,20,2,'Tenho uma noção de qual é o resultado da empresa em determinado tempo.',NULL,0,'S','N',2),
 (62,20,3,'Sim, calculo o resultado da minha empresa relacionando os meus custos e despesas com a receita (faturamento).',NULL,0,'S','N',2),
 (63,21,1,'Não, não sei qual é o meu ganho naquilo que vendo.',NULL,0,'S','N',2),
 (64,21,2,'Tenho um conhecimento aproximado sobre o ganho que cada produto / serviço traz.',NULL,0,'S','N',2),
 (65,21,3,'Sim, calculo periodicamente o ganho de cada produto / serviço.',NULL,0,'S','N',2),
 (66,22,1,'Não, não tenho este controle.',NULL,0,'S','N',2),
 (67,22,2,'Sei de cabeça, mas não tenho um controle formal.',NULL,0,'S','N',2),
 (68,22,3,'Sim, registro quanto tenho em estoque e faço seu controle periodicamente.',NULL,0,'S','N',2),
 (69,4,3,'Sim, possuo cadastro de clientes que me auxilia na comunicação com os fregueses.',NULL,0,'S','N',2),
 (70,23,1,'Não sei quais são os grupos de clientes que frequentam meu estabelecimento.',NULL,0,'S','N',2),
 (71,23,2,'Conheço alguns grupos, mas não faço ações direcionadas.',NULL,0,'S','N',2),
 (72,23,3,'Conheço os grupos que frequentam, e faço ações direcionadas a cada um deles.',NULL,0,'S','N',2),
 (73,24,1,'Não faço esta análise regularmente.',NULL,0,'S','N',2),
 (74,24,2,'Eu converso com meus clientes, mas não faço uma análise regularmente ou não uso esta informação sistematicamente.',NULL,0,'S','N',2),
 (75,24,3,'Sim, busco periodicamente as necessidades dos meus clientes e uso estas informações para melhorar meus produtos / serviços.',NULL,0,'S','N',2),
 (76,25,1,'Não faço pesquisa.',NULL,0,'S','N',2),
 (77,25,2,'Faço pesquisa, mas não a utilizo para melhorar a empresa.',NULL,0,'S','N',2),
 (78,25,3,'Sim, realizo uma pesquisa de satisfação e utilizo as respostas para melhorar meu negócio.',NULL,0,'S','N',2),
 (79,26,1,'Não tenho ações planejadas para promover ou divulgar o produto ou serviço.',NULL,0,'S','N',2),
 (80,26,2,'Tenho algumas ações planejadas, mas a maioria vou pensando e fazendo sem um plano.',NULL,0,'S','N',2),
 (81,26,3,'Realizo ações promocionais de maneira planejada e controlo os resultados de cada ação.',NULL,0,'S','N',2),
 (82,27,1,'Não, oferto sempre os mesmos produtos.',NULL,0,'S','N',2),
 (83,27,2,'Oferto novos produtos ocasionalmente, somente quando vejo que meu negócio está parado no tempo.',NULL,0,'S','N',2),
 (84,27,3,'Sim, oferto novos produtos/serviços, tenho critérios para o lançamento e os testo por um tempo.',NULL,0,'S','N',2),
 (85,28,1,'Não, não analiso meus concorrentes.',NULL,0,'S','N',2),
 (86,28,2,'Tenho alguma noção de como meus concorrentes atuam e se diferenciam de mim.',NULL,0,'S','N',2),
 (87,28,3,'Sim, sei no que sou pior e melhor do que meus concorrentes e realizo ações para melhorar.',NULL,0,'S','N',2),
 (88,7,3,'Sim, entendo a importância de planejar para ser bem sucedido e defino ações para conseguir chegar onde quero.',NULL,0,'S','N',2),
 (89,29,1,'Não tenho objetivos e metas definidas.',NULL,0,'S','N',2),
 (90,29,2,'Tenho alguns objetivos, mas não tenho metas específicas.',NULL,0,'S','N',2),
 (91,29,3,'Sim, planejo meu negócio e defino objetivos e metas de forma clara e consistente.',NULL,0,'S','N',2),
 (92,30,1,'Não faço esta reflexão.',NULL,0,'S','N',2),
 (93,30,2,'Até paro para pensar nisto, mas nunca coloquei tudo isso no papel.',NULL,0,'S','N',2),
 (94,30,3,'Sim, comparo as decisões que tomei e os resultados que eu esperava com o que realmente fiz e alcancei.',NULL,0,'S','N',2),
 (95,31,1,'Não tenho ações com prazos definidos.',NULL,0,'S','N',2),
 (96,31,2,'Sei onde quero chegar, mas não sei quais e quando as ações devem ser tomadas para atingir meus objetivos.',NULL,0,'S','N',2),
 (97,31,3,'Sim, defino o que e como deve ser feito para a empresa atingir os objetivos planejados previamente.',NULL,0,'S','N',2),
 (98,32,1,'Melhorar com urgência, Nada Satisfeito.',NULL,1,'S','N',2),
 (99,32,2,'Preciso Melhorar, Pouco Satisfeito.',NULL,NULL,'S','N',2),
 (100,32,3,'Posso Aprimorar, Bastante Satisfeito.',NULL,NULL,'S','N',2),
 (101,32,4,'Manter, Totalmente Satisfeito.',NULL,NULL,'S','N',2),
 (102,33,1,'Não tenho um controle, sei isso de cabeça.',NULL,NULL,'S','N',2),
 (103,33,2,'Tenho informações de meus fornecedores, espalhadas em agendas e não detalhadas.',NULL,NULL,'S','N',2),
 (104,33,3,'Sim, possuo uma planilha ou caderno com cadastro de fornecedores, que acesso quando compro algum produto ou serviço.',NULL,NULL,'S','N',2),
 (105,34,1,'Não estão bem organizados, demoro muito tempo para encontrar qualquer documento.',NULL,NULL,'S','N',2),
 (106,34,2,'Estão até organizados, mas mesmo assim ainda demoro para encontrar.',NULL,NULL,'S','N',2),
 (107,34,3,'Organizo meus documentos e isto me permite trabalhar de modo ágil.',NULL,NULL,'S','N',2),
 (108,35,1,'Não, não possuo um procedimento padrão formalizado.',NULL,NULL,'S','N',2),
 (109,35,2,'Tenho check-list(s) de alguma tarefas, porém não há um responsável definido.',NULL,NULL,'S','N',2),
 (110,35,3,'Sim, tenho procedimentos escritos para as principais atividades do meu negócio, com responsáveis definidos.',NULL,NULL,'S','N',2),
 (111,36,1,'Não consigo trabalhar de maneira eficiente e ágil.',NULL,NULL,'S','N',2),
 (112,36,2,'Consigo trabalhar eficientemente, porém frequentemente a desorganização volta.',NULL,NULL,'S','N',2),
 (113,36,3,'Consigo trabalhar de maneira eficiente e ágil sempre.',NULL,NULL,'S','N',2),
 (114,37,1,'Não, o layout não é organizado.',NULL,NULL,'S','N',2),
 (115,37,2,'Algumas coisas na empresa estão organizadas, porém há móveis/mercadorias/máquinas que estão em locais inadequados.',NULL,NULL,'S','N',2),
 (116,37,3,'Sim, possuo um layout definido que facilita o fluxo de pessoas e materiais.',NULL,NULL,'S','N',2),
 (117,38,1,'Não conheço as obrigações trabalhistas e não sei o que fazer quanto à minha aposentadoria.',NULL,NULL,'S','N',2),
 (118,38,2,'Tenho pouco conhecimento sobre relações trabalhistas e minha aposentadoria, mas ainda tenho dúvidas.',NULL,NULL,'S','N',2),
 (119,38,3,'Sim, tenho domínio sobre as obrigações trabalhistas e também sobre a minha aposentadoria.',NULL,NULL,'S','N',2),
 (120,39,1,'Nunca defini.',NULL,NULL,'S','N',2),
 (121,39,2,'Tenho uma noção dos conhecimentos e características necessários, mas não utilizei isto para contratar as pessoas.',NULL,NULL,'S','N',2),
 (122,39,3,'Sim, tenho registrado quais são os conhecimentos e características necessárias para realizar as atividades e uso isto para a contratação das pessoas.',NULL,NULL,'S','N',2),
 (123,40,1,'Não, se alguém faltar o negócio não funciona.',NULL,NULL,'S','N',2),
 (124,40,2,'Em alguns casos sim, mas se algumas pessoas faltarem a empresa não tem que saiba fazer aquela atividade.',NULL,NULL,'S','N',2),
 (125,40,3,'Se alguém faltar, sabemos quem deve assumir a responsabilidade e esta pessoa estará capacitada a isso.',NULL,NULL,'S','N',2),
 (126,41,1,'Não faço esta avaliação.',NULL,NULL,'S','N',2),
 (127,41,2,'Faço esta avaliação, mas não treino as pessoas com base nisso.',NULL,NULL,'S','N',2),
 (128,41,3,'Faço esta avaliação e treino as pessoas para evitar que o problema ocorra ou volte a acontecer.',NULL,NULL,'S','N',2),
 (129,42,1,'Não sei quais atividades posso delegar.',NULL,NULL,'S','N',2),
 (130,42,2,'Costumo realizar as principais atividades da empresa, e tenho funcionários que podem executá-las e delego-as para eles.',NULL,NULL,'S','N',2),
 (131,42,3,'Sim, delego atividades para que meus funcionários realizem sem minha presença, investindo meu tempo no que é mais importante para o negócio.',NULL,NULL,'S','N',2),
 (132,43,1,'Não, é difícil identificar onde está uma área específica, os clientes parecem ficar confusos sobre onde encontrar o que procuram e muitos vão embora sem consumir nada ou sem serem atendidos. Existem áreas pouco acessadas pelos clientes, e que poderiam ser melhor aproveitadas.',NULL,NULL,'S','N',2),
 (133,43,2,'Em parte, a área de circulação não está obstruída mas a distribuição de produtos ou serviços pode ser revisada. Nota-se alguma dificuldade nos clientes em entender o espaço.',NULL,NULL,'S','N',2),
 (134,43,3,'Sim, a forma como o espaço se apresenta é clara e muito bem organizada. Os produtos são facilmente encontrados e nota-se que os clientes percorrem todas as áreas em que a circulação é desejada, não apresentando dificuldade em encontrar o que procuram.',NULL,NULL,'S','N',2),
 (135,44,1,'Este item não é aplicável, pois a empresa não comercializa produtos.',NULL,NULL,'S','N',2),
 (136,44,2,'Não, os produtos com maior margem de lucro ou de venda por impulso estão posicionados fora da altura compreendida entre 1,20m a 1,80m; produtos destinado ao público infantil estão posicionados fora do alcance de crianças; as promoções não estão visíveis pelo cliente.',NULL,NULL,'S','N',2),
 (137,44,3,'Sim, a organização dos produtos está adequada; os produtos com maior margem de lucro, os de venda por impulso ou as promoções estão na altura dos olhos do cliente, compreendida entre 1,20m e 1,80m; os produtos destinados ao público infantil estão ao alcance das crianças.',NULL,NULL,'S','N',2),
 (138,45,1,'Não, a empresa não possui uma marca definida e por isso não possui uma comunicação visual padronizada. Além disso, algumas áreas não são facilmente identificadas pelos clientes, que têm dificuldade em se localizar dentro do estabelecimento.',NULL,NULL,'S','N',2),
 (139,45,2,'Em parte, a empresa possui uma marca própria e algumas aplicações padronizadas, mas estes materiais não contemplam peças de comunicação visual para o estabelecimento. Sendo assim, visualmente não há uma comunicação clara, causando uma certa dificuldade nos clientes em encontrar o que procuram.',NULL,NULL,'S','N',2),
 (140,45,3,'Sim, a empresa possui uma marca própria e comunicação visual padronizada. Não é percebida nenhuma dificuldade para os clientes em encontrar o que procuram.',NULL,NULL,'S','N',2),
 (141,48,1,'Não vê importância e necessidade em avaliar a empresa do ponto de vista do cliente;',NULL,NULL,'S','N',2),
 (142,48,2,'Não faz esta avaliação periodicamente, mas de vez em quando pensa a respeito;',NULL,NULL,'S','N',2),
 (143,48,3,'Faz esta avaliação de forma periódica e por escrito, utilizando os resultados para definir ações de melhoria.',NULL,NULL,'S','N',2),
 (144,49,1,'Não vê necessidade de padronizar etapas do serviço.',NULL,NULL,'S','N',2),
 (145,49,2,'Comunica verbalmente aos funcionários como as atividades devem ser feitas.',NULL,NULL,'S','N',2),
 (146,49,3,'Possui alguns procedimentos formalizados, mas percebe a necessidade de melhorá-los e/ou criar novos.',NULL,NULL,'S','N',2),
 (147,50,1,'Melhorar com urgência, Nada Satisfeito.',NULL,NULL,'S','N',2),
 (148,50,2,'Preciso Melhorar, Pouco Satisfeito.',NULL,NULL,'S','N',2),
 (149,50,3,'Posso Aprimorar, Bastante Satisfeito.',NULL,NULL,'S','N',2),
 (150,50,4,'Manter, Totalmente Satisfeito.',NULL,NULL,'S','N',2),
 (151,51,1,'Melhorar com urgência, Nada Satisfeito.',NULL,NULL,'S','N',2),
 (152,51,2,'Preciso Melhorar, Pouco Satisfeito.',NULL,NULL,'S','N',2),
 (153,51,3,'Posso Aprimorar, Bastante Satisfeito.',NULL,NULL,'S','N',2),
 (154,51,4,'Manter, Totalmente Satisfeito.',NULL,NULL,'S','N',2),
 (155,52,1,'Melhorar com urgência, Nada Satisfeito.',NULL,NULL,'S','N',2),
 (156,52,2,'Preciso Melhorar, Pouco Satisfeito.',NULL,NULL,'S','N',2),
 (157,52,3,'Posso Aprimorar, Bastante Satisfeito.',NULL,NULL,'S','N',2),
 (158,52,4,'Manter, Totalmente Satisfeito.',NULL,NULL,'S','N',2),
 (159,53,1,'Melhorar com urgência, Nada Satisfeito.',NULL,NULL,'S','N',2),
 (160,53,2,'Preciso Melhorar, Pouco Satisfeito.',NULL,NULL,'S','N',2),
 (161,53,3,'Posso Aprimorar, Bastante Satisfeito.',NULL,NULL,'S','N',2),
 (162,53,4,'Manter, Totalmente Satisfeito.',NULL,NULL,'S','N',2),
 (163,54,1,'Melhorar com urgência, Nada Satisfeito.',NULL,NULL,'S','N',2),
 (164,54,2,'Preciso Melhorar, Pouco Satisfeito.',NULL,NULL,'S','N',2),
 (165,54,3,'Posso Aprimorar, Bastante Satisfeito.',NULL,NULL,'S','N',2),
 (166,54,4,'Manter, Totalmente Satisfeito.',NULL,NULL,'S','N',2),
 (167,55,1,'Melhorar com urgência, Nada Satisfeito.',NULL,NULL,'S','N',2),
 (168,55,2,'Preciso Melhorar, Pouco Satisfeito.',NULL,NULL,'S','N',2),
 (169,55,3,'Posso Aprimorar, Bastante Satisfeito.',NULL,NULL,'S','N',2),
 (170,55,4,'Manter, Totalmente Satisfeito.',NULL,NULL,'S','N',2),
 (171,56,1,'Melhorar com urgência, Nada Satisfeito.',NULL,NULL,'S','N',2),
 (172,56,2,'Preciso Melhorar, Pouco Satisfeito.',NULL,NULL,'S','N',2),
 (173,56,3,'Posso Aprimorar, Bastante Satisfeito.',NULL,NULL,'S','N',2),
 (174,56,4,'Manter, Totalmente Satisfeito.',NULL,NULL,'S','N',2),
 (175,57,1,'Melhorar com urgência, Nada Satisfeito.',NULL,NULL,'S','N',2),
 (176,57,2,'Preciso Melhorar, Pouco Satisfeito.',NULL,NULL,'S','N',2),
 (177,57,3,'Posso Aprimorar, Bastante Satisfeito.',NULL,NULL,'S','N',2),
 (178,57,4,'Manter, Totalmente Satisfeito.',NULL,NULL,'S','N',2),
 (179,58,1,'Melhorar com urgência, Nada Satisfeito.',NULL,NULL,'S','N',2),
 (180,58,2,'Preciso Melhorar, Pouco Satisfeito',NULL,NULL,'S','N',2),
 (181,58,3,'Posso Aprimorar, Bastante Satisfeito.',NULL,NULL,'S','N',2),
 (182,58,4,'Manter, Totalmente Satisfeito.',NULL,NULL,'S','N',2),
 (183,59,1,'Melhorar com urgência, Nada Satisfeito.',NULL,NULL,'S','N',2),
 (184,59,2,'Preciso Melhorar, Pouco Satisfeito.',NULL,NULL,'S','N',2),
 (185,59,3,'Posso Aprimorar, Bastante Satisfeito.',NULL,NULL,'S','N',2),
 (186,59,4,'Manter, Totalmente Satisfeito.',NULL,NULL,'S','N',2),
 (187,60,1,'Melhorar com urgência, Nada Satisfeito.',NULL,NULL,'S','N',2),
 (188,60,2,'Preciso Melhorar, Pouco Satisfeito.',NULL,NULL,'S','N',2),
 (189,60,3,'Posso Aprimorar, Bastante Satisfeito.',NULL,NULL,'S','N',2),
 (190,60,4,'Manter, Totalmente Satisfeito.',NULL,NULL,'S','N',2),
 (191,61,1,'Melhorar com urgência, Nada Satisfeito.',NULL,NULL,'S','N',2),
 (192,61,2,'Preciso Melhorar, Pouco Satisfeito.',NULL,NULL,'S','N',2),
 (193,61,3,'Posso Aprimorar, Bastante Satisfeito.',NULL,NULL,'S','N',2),
 (194,61,4,'Manter, Totalmente Satisfeito.',NULL,NULL,'S','N',2),
 (195,62,1,'Melhorar com urgência, Nada Satisfeito.',NULL,NULL,'S','N',2),
 (196,62,2,'Preciso Melhorar, Pouco Satisfeito.',NULL,NULL,'S','N',2),
 (197,62,3,'Posso Aprimorar, Bastante Satisfeito.',NULL,NULL,'S','N',2),
 (198,62,4,'Manter, Totalmente Satisfeito.',NULL,NULL,'S','N',2),
 (199,63,1,'Melhorar com urgência, Nada Satisfeito.',NULL,NULL,'S','N',2),
 (200,63,2,'Preciso Melhorar, Pouco Satisfeito.',NULL,NULL,'S','N',2),
 (201,63,3,'Posso Aprimorar, Bastante Satisfeito.',NULL,NULL,'S','N',2),
 (202,63,4,'Manter, Totalmente Satisfeito.',NULL,NULL,'S','N',2),
 (203,64,1,'Melhorar com urgência, Nada Satisfeito.',NULL,NULL,'S','N',2),
 (204,64,2,'Preciso Melhorar, Pouco Satisfeito.',NULL,NULL,'S','N',2),
 (205,64,3,'Posso Aprimorar, Bastante Satisfeito.',NULL,NULL,'S','N',2),
 (206,64,4,'Manter, Totalmente Satisfeito.',NULL,NULL,'S','N',2),
 (207,65,1,'Melhorar com urgência, Nada Satisfeito.',NULL,NULL,'S','N',2),
 (208,65,2,'Preciso Melhorar, Pouco Satisfeito.',NULL,NULL,'S','N',2),
 (209,65,3,'Posso Aprimorar, Bastante Satisfeito.',NULL,NULL,'S','N',2),
 (210,65,4,'Manter, Totalmente Satisfeito.',NULL,NULL,'S','N',2),
 (211,66,1,'Melhorar com urgência, Nada Satisfeito.',NULL,NULL,'S','N',2),
 (212,66,2,'Preciso Melhorar, Pouco Satisfeito.',NULL,NULL,'S','N',2),
 (213,66,3,'Posso Aprimorar, Bastante Satisfeito.',NULL,NULL,'S','N',2),
 (214,66,4,'Manter, Totalmente Satisfeito.',NULL,NULL,'S','N',2),
 (215,67,1,'Melhorar com urgência, Nada Satisfeito.',NULL,NULL,'S','N',2),
 (216,67,2,'Preciso Melhorar, Pouco Satisfeito.',NULL,NULL,'S','N',2),
 (217,67,3,'Posso Aprimorar, Bastante Satisfeito.',NULL,NULL,'S','N',2),
 (218,67,4,'Manter, Totalmente Satisfeito.',NULL,NULL,'S','N',2),
 (219,68,1,'Melhorar com urgência, Nada Satisfeito.',NULL,NULL,'S','N',2),
 (220,68,2,'Preciso Melhorar, Pouco Satisfeito.',NULL,NULL,'S','N',2),
 (221,68,3,'Posso Aprimorar, Bastante Satisfeito.',NULL,NULL,'S','N',2),
 (222,68,4,'Manter, Totalmente Satisfeito.',NULL,NULL,'S','N',2),
 (223,69,1,'Melhorar com urgência, Nada Satisfeito.',NULL,NULL,'S','N',2),
 (224,69,2,'Preciso Melhorar, Pouco Satisfeito.',NULL,NULL,'S','N',2),
 (225,69,3,'Posso Aprimorar, Bastante Satisfeito.',NULL,NULL,'S','N',2),
 (226,69,4,'Manter, Totalmente Satisfeito.',NULL,NULL,'S','N',2),
 (227,70,1,'Melhorar com urgência, Nada Satisfeito.',NULL,NULL,'S','N',2),
 (228,70,2,'Preciso Melhorar, Pouco Satisfeito.',NULL,NULL,'S','N',2),
 (229,70,3,'Posso Aprimorar, Bastante Satisfeito.',NULL,NULL,'S','N',2),
 (230,70,4,'Manter, Totalmente Satisfeito.',NULL,NULL,'S','N',2),
 (1984,767,1,'Não, apenas vejo quanto tenho de dinheiro no final do dia.',NULL,10,'S','N',2),
 (1985,767,2,'Tenho um controle informal das entradas e saídas de dinheiro.',NULL,10,'S','N',2),
 (1986,767,3,'Sim, possuo um controle formalizado e detalhado das entradas e saídas de dinheiro.',NULL,10,'S','S',2),
 (1987,768,1,'Não tenho este controle.',NULL,0,'S','N',2),
 (1988,768,2,'Tenho um controle não formalizado e/ou que não prevê como estará o saldo no futuro.',NULL,0,'S','N',2),
 (1989,768,3,'Sim, possuo planilhas para controlar o Fluxo de Caixa e visualizo ao longo do tempo quando terei falta ou sobra de dinheiro.',NULL,0,'S','N',2),
 (1990,769,1,'Não faço este cálculo regularmente.',NULL,0,'S','N',2),
 (1991,769,2,'Tenho noção de quais são minhas despesas, mas não sei quanto dinheiro preciso ter em caixa.',NULL,0,'S','N',2),
 (1992,769,3,'Sim, calculo qual o valor que a empresa precisa ter em caixa para que não precise pedir dinheiro emprestado.',NULL,0,'S','N',2),
 (1993,770,1,'Não, não tenho controle sobre o pagamento de tributos.',NULL,0,'S','N',2),
 (1994,770,2,'Sei quando devem ser pagos alguns tributos, mas não tenho controle sobre quando cada um deve ser pago.',NULL,0,'S','N',2),
 (1995,770,3,'Sim, possuo controle formal e registro de quando cada tributo deve ser pago, assim como registro os pagamentos.',NULL,0,'S','N',2),
 (1996,771,1,'Não, não sei quais são os custos da empresa.',NULL,0,'S','N',2),
 (1997,771,2,'Tenho noção de qual é o valor dos custos e despesas mensais da empresa, mas não tenho um controle preciso.',NULL,0,'S','N',2),
 (1998,771,3,'Sim, registro qual o valor dos custos e despesas mensalmente, sabendo quanto foi o desembolso no período.',NULL,0,'S','N',2),
 (1999,772,1,'Não, não sei qual foi o resultado da empresa no período.',NULL,0,'S','N',2),
 (2000,772,2,'Tenho uma noção de qual é o resultado da empresa em determinado tempo.',NULL,0,'S','N',2),
 (2001,772,3,'Sim, calculo o resultado da minha empresa relacionando os meus custos e despesas com a receita (faturamento).',NULL,0,'S','N',2),
 (2002,773,1,'Não, não sei qual é o meu ganho naquilo que vendo.',NULL,0,'S','N',2),
 (2003,773,2,'Tenho um conhecimento aproximado sobre o ganho que cada produto / serviço traz.',NULL,0,'S','N',2),
 (2004,773,3,'Sim, calculo periodicamente o ganho de cada produto / serviço.',NULL,0,'S','N',2),
 (2005,774,1,'Não, não tenho este controle.',NULL,0,'S','N',2),
 (2006,774,2,'Sei de cabeça, mas não tenho um controle formal.',NULL,0,'S','N',2),
 (2007,774,3,'Sim, registro quanto tenho em estoque e faço seu controle periodicamente.',NULL,0,'S','N',2),
 (2008,775,1,'Não, não tenho um cadastro de clientes.',NULL,10,'S','N',2),
 (2009,775,2,'Tenho um cadastro de clientes, mas não faço uso dele.',NULL,10,'S','N',2),
 (2010,775,3,'Sim, possuo cadastro de clientes que me auxilia na comunicação com os fregueses.',NULL,0,'S','N',2),
 (2011,776,1,'Não sei quais são os grupos de clientes que frequentam meu estabelecimento.',NULL,0,'S','N',2),
 (2012,776,2,'Conheço alguns grupos, mas não faço ações direcionadas.',NULL,0,'S','N',2),
 (2013,776,3,'Conheço os grupos que frequentam, e faço ações direcionadas a cada um deles.',NULL,0,'S','N',2),
 (2014,777,1,'Não faço esta análise regularmente.',NULL,0,'S','N',2),
 (2015,777,2,'Eu converso com meus clientes, mas não faço uma análise regularmente ou não uso esta informação sistematicamente.',NULL,0,'S','N',2),
 (2016,777,3,'Sim, busco periodicamente as necessidades dos meus clientes e uso estas informações para melhorar meus produtos / serviços.',NULL,0,'S','N',2),
 (2017,778,1,'Não faço pesquisa.',NULL,0,'S','N',2),
 (2018,778,2,'Faço pesquisa, mas não a utilizo para melhorar a empresa.',NULL,0,'S','N',2),
 (2019,778,3,'Sim, realizo uma pesquisa de satisfação e utilizo as respostas para melhorar meu negócio.',NULL,0,'S','N',2),
 (2020,779,1,'Não tenho ações planejadas para promover ou divulgar o produto ou serviço.',NULL,0,'S','N',2),
 (2021,779,2,'Tenho algumas ações planejadas, mas a maioria vou pensando e fazendo sem um plano.',NULL,0,'S','N',2),
 (2022,779,3,'Realizo ações promocionais de maneira planejada e controlo os resultados de cada ação.',NULL,0,'S','N',2),
 (2023,780,1,'Não, oferto sempre os mesmos produtos.',NULL,0,'S','N',2),
 (2024,780,2,'Oferto novos produtos ocasionalmente, somente quando vejo que meu negócio está parado no tempo.',NULL,0,'S','N',2),
 (2025,780,3,'Sim, oferto novos produtos/serviços, tenho critérios para o lançamento e os testo por um tempo.',NULL,0,'S','N',2),
 (2026,781,1,'Não, não analiso meus concorrentes.',NULL,0,'S','N',2),
 (2027,781,2,'Tenho alguma noção de como meus concorrentes atuam e se diferenciam de mim.',NULL,0,'S','N',2),
 (2028,781,3,'Sim, sei no que sou pior e melhor do que meus concorrentes e realizo ações para melhorar.',NULL,0,'S','N',2),
 (2029,782,1,'Não, vou tocando o negócio sem planejar o futuro.',NULL,25,'S','N',2),
 (2030,782,2,'Planejo na minha cabeça algumas coisas, porém não acho necessário definir como vou alcançar os objetivos.',NULL,25,'S','N',2),
 (2031,782,3,'Sim, entendo a importância de planejar para ser bem sucedido e defino ações para conseguir chegar onde quero.',NULL,0,'S','N',2),
 (2032,783,1,'Não tenho objetivos e metas definidas.',NULL,0,'S','N',2),
 (2033,783,2,'Tenho alguns objetivos, mas não tenho metas específicas.',NULL,0,'S','N',2),
 (2034,783,3,'Sim, planejo meu negócio e defino objetivos e metas de forma clara e consistente.',NULL,0,'S','N',2),
 (2035,784,1,'Não faço esta reflexão.',NULL,0,'S','N',2),
 (2036,784,2,'Até paro para pensar nisto, mas nunca coloquei tudo isso no papel.',NULL,0,'S','N',2),
 (2037,784,3,'Sim, comparo as decisões que tomei e os resultados que eu esperava com o que realmente fiz e alcancei.',NULL,0,'S','N',2),
 (2038,785,1,'Não tenho ações com prazos definidos.',NULL,0,'S','N',2),
 (2039,785,2,'Sei onde quero chegar, mas não sei quais e quando as ações devem ser tomadas para atingir meus objetivos.',NULL,0,'S','N',2),
 (2040,785,3,'Sim, defino o que e como deve ser feito para a empresa atingir os objetivos planejados previamente.',NULL,0,'S','N',2),
 (2041,786,1,'Não tenho um controle, sei isso de cabeça.',NULL,NULL,'S','N',2),
 (2042,786,2,'Tenho informações de meus fornecedores, espalhadas em agendas e não detalhadas.',NULL,NULL,'S','N',2),
 (2043,786,3,'Sim, possuo uma planilha ou caderno com cadastro de fornecedores, que acesso quando compro algum produto ou serviço.',NULL,NULL,'S','N',2),
 (2044,787,1,'Não estão bem organizados, demoro muito tempo para encontrar qualquer documento.',NULL,NULL,'S','N',2),
 (2045,787,2,'Estão até organizados, mas mesmo assim ainda demoro para encontrar.',NULL,NULL,'S','N',2),
 (2046,787,3,'Organizo meus documentos e isto me permite trabalhar de modo ágil.',NULL,NULL,'S','N',2),
 (2047,788,1,'Não, não possuo um procedimento padrão formalizado.',NULL,NULL,'S','N',2),
 (2048,788,2,'Tenho check-list(s) de alguma tarefas, porém não há um responsável definido.',NULL,NULL,'S','N',2),
 (2049,788,3,'Sim, tenho procedimentos escritos para as principais atividades do meu negócio, com responsáveis definidos.',NULL,NULL,'S','N',2),
 (2050,789,1,'Não consigo trabalhar de maneira eficiente e ágil.',NULL,NULL,'S','N',2),
 (2051,789,2,'Consigo trabalhar eficientemente, porém frequentemente a desorganização volta.',NULL,NULL,'S','N',2),
 (2052,789,3,'Consigo trabalhar de maneira eficiente e ágil sempre.',NULL,NULL,'S','N',2),
 (2053,790,1,'Não, o layout não é organizado.',NULL,NULL,'S','N',2),
 (2054,790,2,'Algumas coisas na empresa estão organizadas, porém há móveis/mercadorias/máquinas que estão em locais inadequados.',NULL,NULL,'S','N',2),
 (2055,790,3,'Sim, possuo um layout definido que facilita o fluxo de pessoas e materiais.',NULL,NULL,'S','N',2),
 (2056,791,1,'Não conheço as obrigações trabalhistas e não sei o que fazer quanto à minha aposentadoria.',NULL,NULL,'S','N',2),
 (2057,791,2,'Tenho pouco conhecimento sobre relações trabalhistas e minha aposentadoria, mas ainda tenho dúvidas.',NULL,NULL,'S','N',2),
 (2058,791,3,'Sim, tenho domínio sobre as obrigações trabalhistas e também sobre a minha aposentadoria.',NULL,NULL,'S','N',2),
 (2059,792,1,'Nunca defini.',NULL,NULL,'S','N',2),
 (2060,792,2,'Tenho uma noção dos conhecimentos e características necessários, mas não utilizei isto para contratar as pessoas.',NULL,NULL,'S','N',2),
 (2061,792,3,'Sim, tenho registrado quais são os conhecimentos e características necessárias para realizar as atividades e uso isto para a contratação das pessoas.',NULL,NULL,'S','N',2),
 (2062,793,1,'Não, se alguém faltar o negócio não funciona.',NULL,NULL,'S','N',2),
 (2063,793,2,'Em alguns casos sim, mas se algumas pessoas faltarem a empresa não tem que saiba fazer aquela atividade.',NULL,NULL,'S','N',2),
 (2064,793,3,'Se alguém faltar, sabemos quem deve assumir a responsabilidade e esta pessoa estará capacitada a isso.',NULL,NULL,'S','N',2),
 (2065,794,1,'Não faço esta avaliação.',NULL,NULL,'S','N',2),
 (2066,794,2,'Faço esta avaliação, mas não treino as pessoas com base nisso.',NULL,NULL,'S','N',2),
 (2067,794,3,'Faço esta avaliação e treino as pessoas para evitar que o problema ocorra ou volte a acontecer.',NULL,NULL,'S','N',2),
 (2068,795,1,'Não sei quais atividades posso delegar.',NULL,NULL,'S','N',2),
 (2069,795,2,'Costumo realizar as principais atividades da empresa, e tenho funcionários que podem executá-las e delego-as para eles.',NULL,NULL,'S','N',2),
 (2070,795,3,'Sim, delego atividades para que meus funcionários realizem sem minha presença, investindo meu tempo no que é mais importante para o negócio.',NULL,NULL,'S','N',2),
 (2071,796,1,'Não, é difícil identificar onde está uma área específica, os clientes parecem ficar confusos sobre onde encontrar o que procuram e muitos vão embora sem consumir nada ou sem serem atendidos. Existem áreas pouco acessadas pelos clientes, e que poderiam ser melhor aproveitadas.',NULL,NULL,'S','N',2),
 (2072,796,2,'Em parte, a área de circulação não está obstruída mas a distribuição de produtos ou serviços pode ser revisada. Nota-se alguma dificuldade nos clientes em entender o espaço.',NULL,NULL,'S','N',2),
 (2073,796,3,'Sim, a forma como o espaço se apresenta é clara e muito bem organizada. Os produtos são facilmente encontrados e nota-se que os clientes percorrem todas as áreas em que a circulação é desejada, não apresentando dificuldade em encontrar o que procuram.',NULL,NULL,'S','N',2),
 (2074,797,1,'Este item não é aplicável, pois a empresa não comercializa produtos.',NULL,NULL,'S','N',2),
 (2075,797,2,'Não, os produtos com maior margem de lucro ou de venda por impulso estão posicionados fora da altura compreendida entre 1,20m a 1,80m; produtos destinado ao público infantil estão posicionados fora do alcance de crianças; as promoções não estão visíveis pelo cliente.',NULL,NULL,'S','N',2),
 (2076,797,3,'Sim, a organização dos produtos está adequada; os produtos com maior margem de lucro, os de venda por impulso ou as promoções estão na altura dos olhos do cliente, compreendida entre 1,20m e 1,80m; os produtos destinados ao público infantil estão ao alcance das crianças.',NULL,NULL,'S','N',2),
 (2077,798,1,'Não, a empresa não possui uma marca definida e por isso não possui uma comunicação visual padronizada. Além disso, algumas áreas não são facilmente identificadas pelos clientes, que têm dificuldade em se localizar dentro do estabelecimento.',NULL,NULL,'S','N',2),
 (2078,798,2,'Em parte, a empresa possui uma marca própria e algumas aplicações padronizadas, mas estes materiais não contemplam peças de comunicação visual para o estabelecimento. Sendo assim, visualmente não há uma comunicação clara, causando uma certa dificuldade nos clientes em encontrar o que procuram.',NULL,NULL,'S','N',2),
 (2079,798,3,'Sim, a empresa possui uma marca própria e comunicação visual padronizada. Não é percebida nenhuma dificuldade para os clientes em encontrar o que procuram.',NULL,NULL,'S','N',2),
 (2080,799,1,'Não vê importância e necessidade em avaliar a empresa do ponto de vista do cliente;',NULL,NULL,'S','N',2),
 (2081,799,2,'Não faz esta avaliação periodicamente, mas de vez em quando pensa a respeito;',NULL,NULL,'S','N',2),
 (2082,799,3,'Faz esta avaliação de forma periódica e por escrito, utilizando os resultados para definir ações de melhoria.',NULL,NULL,'S','N',2),
 (2083,800,1,'Não vê necessidade de padronizar etapas do serviço.',NULL,NULL,'S','N',2),
 (2084,800,2,'Comunica verbalmente aos funcionários como as atividades devem ser feitas.',NULL,NULL,'S','N',2),
 (2085,800,3,'Possui alguns procedimentos formalizados, mas percebe a necessidade de melhorá-los e/ou criar novos.',NULL,NULL,'S','N',2),
 (2086,801,1,'Melhorar com urgência, Nada Satisfeito.',NULL,0,'S','N',2),
 (2087,801,2,'Preciso Melhorar, Pouco Satisfeito.',NULL,0,'S','N',2),
 (2088,801,3,'Posso Aprimorar, Bastante Satisfeito.',NULL,0,'S','N',2),
 (2089,801,4,'Manter, Totalmente Satisfeito.',NULL,0,'S','N',2),
 (2090,802,1,'Melhorar com urgência, Nada Satisfeito.',NULL,4,'S','N',2),
 (2091,802,2,'Preciso Melhorar, Pouco Satisfeito.',NULL,3,'S','N',2),
 (2092,802,3,'Posso Aprimorar, Bastante Satisfeito.',NULL,3,'S','N',2),
 (2093,802,4,'Manter, Totalmente Satisfeito.',NULL,0,'S','N',2),
 (2094,803,1,'Melhorar com urgência, Nada Satisfeito.',NULL,5,'S','N',2),
 (2095,803,2,'Preciso Melhorar, Pouco Satisfeito.',NULL,3,'S','N',2),
 (2096,803,3,'Posso Aprimorar, Bastante Satisfeito.',NULL,2,'S','N',2),
 (2097,803,4,'Manter, Totalmente Satisfeito.',NULL,0,'S','N',2),
 (2098,804,1,'Melhorar com urgência, Nada Satisfeito.',NULL,0,'S','N',2),
 (2099,804,2,'Preciso Melhorar, Pouco Satisfeito.',NULL,0,'S','N',2),
 (2100,804,3,'Posso Aprimorar, Bastante Satisfeito.',NULL,0,'S','N',2),
 (2101,804,4,'Manter, Totalmente Satisfeito.',NULL,0,'S','N',2),
 (2102,805,1,'Melhorar com urgência, Nada Satisfeito.',NULL,0,'S','N',2),
 (2103,805,2,'Preciso Melhorar, Pouco Satisfeito.',NULL,0,'S','N',2),
 (2104,805,3,'Posso Aprimorar, Bastante Satisfeito.',NULL,0,'S','N',2),
 (2105,805,4,'Manter, Totalmente Satisfeito.',NULL,0,'S','N',2),
 (2106,806,1,'Melhorar com urgência, Nada Satisfeito.',NULL,0,'S','N',2),
 (2107,806,2,'Preciso Melhorar, Pouco Satisfeito.',NULL,0,'S','N',2),
 (2108,806,3,'Posso Aprimorar, Bastante Satisfeito.',NULL,0,'S','N',2),
 (2109,806,4,'Manter, Totalmente Satisfeito.',NULL,0,'S','N',2),
 (2110,807,1,'Melhorar com urgência, Nada Satisfeito.',NULL,0,'S','N',2),
 (2111,807,2,'Preciso Melhorar, Pouco Satisfeito.',NULL,0,'S','N',2),
 (2112,807,3,'Posso Aprimorar, Bastante Satisfeito.',NULL,0,'S','N',2),
 (2113,807,4,'Manter, Totalmente Satisfeito.',NULL,0,'S','N',2),
 (2114,808,1,'Melhorar com urgência, Nada Satisfeito.',NULL,NULL,'S','N',2),
 (2115,808,2,'Preciso Melhorar, Pouco Satisfeito.',NULL,NULL,'S','N',2),
 (2116,808,3,'Posso Aprimorar, Bastante Satisfeito.',NULL,NULL,'S','N',2),
 (2117,808,4,'Manter, Totalmente Satisfeito.',NULL,NULL,'S','N',2),
 (2118,809,1,'Melhorar com urgência, Nada Satisfeito.',NULL,NULL,'S','N',2),
 (2119,809,2,'Preciso Melhorar, Pouco Satisfeito.',NULL,NULL,'S','N',2),
 (2120,809,3,'Posso Aprimorar, Bastante Satisfeito.',NULL,NULL,'S','N',2),
 (2121,809,4,'Manter, Totalmente Satisfeito.',NULL,NULL,'S','N',2),
 (2122,810,1,'Melhorar com urgência, Nada Satisfeito.',NULL,NULL,'S','N',2),
 (2123,810,2,'Preciso Melhorar, Pouco Satisfeito.',NULL,NULL,'S','N',2),
 (2124,810,3,'Posso Aprimorar, Bastante Satisfeito.',NULL,NULL,'S','N',2),
 (2125,810,4,'Manter, Totalmente Satisfeito.',NULL,NULL,'S','N',2),
 (2126,811,1,'Melhorar com urgência, Nada Satisfeito.',NULL,NULL,'S','N',2),
 (2127,811,2,'Preciso Melhorar, Pouco Satisfeito',NULL,NULL,'S','N',2),
 (2128,811,3,'Posso Aprimorar, Bastante Satisfeito.',NULL,NULL,'S','N',2),
 (2129,811,4,'Manter, Totalmente Satisfeito.',NULL,NULL,'S','N',2),
 (2130,812,1,'Melhorar com urgência, Nada Satisfeito.',NULL,NULL,'S','N',2),
 (2131,812,2,'Preciso Melhorar, Pouco Satisfeito.',NULL,NULL,'S','N',2),
 (2132,812,3,'Posso Aprimorar, Bastante Satisfeito.',NULL,NULL,'S','N',2),
 (2133,812,4,'Manter, Totalmente Satisfeito.',NULL,NULL,'S','N',2),
 (2134,813,1,'Melhorar com urgência, Nada Satisfeito.',NULL,NULL,'S','N',2),
 (2135,813,2,'Preciso Melhorar, Pouco Satisfeito.',NULL,NULL,'S','N',2),
 (2136,813,3,'Posso Aprimorar, Bastante Satisfeito.',NULL,NULL,'S','N',2),
 (2137,813,4,'Manter, Totalmente Satisfeito.',NULL,NULL,'S','N',2),
 (2138,814,1,'Melhorar com urgência, Nada Satisfeito.',NULL,NULL,'S','N',2),
 (2139,814,2,'Preciso Melhorar, Pouco Satisfeito.',NULL,NULL,'S','N',2),
 (2140,814,3,'Posso Aprimorar, Bastante Satisfeito.',NULL,NULL,'S','N',2),
 (2141,814,4,'Manter, Totalmente Satisfeito.',NULL,NULL,'S','N',2),
 (2142,815,1,'Melhorar com urgência, Nada Satisfeito.',NULL,NULL,'S','N',2),
 (2143,815,2,'Preciso Melhorar, Pouco Satisfeito.',NULL,NULL,'S','N',2),
 (2144,815,3,'Posso Aprimorar, Bastante Satisfeito.',NULL,NULL,'S','N',2),
 (2145,815,4,'Manter, Totalmente Satisfeito.',NULL,NULL,'S','N',2),
 (2146,816,1,'Melhorar com urgência, Nada Satisfeito.',NULL,NULL,'S','N',2),
 (2147,816,2,'Preciso Melhorar, Pouco Satisfeito.',NULL,NULL,'S','N',2),
 (2148,816,3,'Posso Aprimorar, Bastante Satisfeito.',NULL,NULL,'S','N',2),
 (2149,816,4,'Manter, Totalmente Satisfeito.',NULL,NULL,'S','N',2),
 (2150,817,1,'Melhorar com urgência, Nada Satisfeito.',NULL,NULL,'S','N',2),
 (2151,817,2,'Preciso Melhorar, Pouco Satisfeito.',NULL,NULL,'S','N',2),
 (2152,817,3,'Posso Aprimorar, Bastante Satisfeito.',NULL,NULL,'S','N',2),
 (2153,817,4,'Manter, Totalmente Satisfeito.',NULL,NULL,'S','N',2),
 (2154,818,1,'Melhorar com urgência, Nada Satisfeito.',NULL,NULL,'S','N',2),
 (2155,818,2,'Preciso Melhorar, Pouco Satisfeito.',NULL,NULL,'S','N',2),
 (2156,818,3,'Posso Aprimorar, Bastante Satisfeito.',NULL,NULL,'S','N',2),
 (2157,818,4,'Manter, Totalmente Satisfeito.',NULL,NULL,'S','N',2),
 (2158,819,1,'Melhorar com urgência, Nada Satisfeito.',NULL,NULL,'S','N',2),
 (2159,819,2,'Preciso Melhorar, Pouco Satisfeito.',NULL,NULL,'S','N',2),
 (2160,819,3,'Posso Aprimorar, Bastante Satisfeito.',NULL,NULL,'S','N',2),
 (2161,819,4,'Manter, Totalmente Satisfeito.',NULL,NULL,'S','N',2),
 (2162,820,1,'Melhorar com urgência, Nada Satisfeito.',NULL,NULL,'S','N',2),
 (2163,820,2,'Preciso Melhorar, Pouco Satisfeito.',NULL,NULL,'S','N',2),
 (2164,820,3,'Posso Aprimorar, Bastante Satisfeito.',NULL,NULL,'S','N',2),
 (2165,820,4,'Manter, Totalmente Satisfeito.',NULL,NULL,'S','N',2),
 (2166,821,1,'Melhorar com urgência, Nada Satisfeito.',NULL,NULL,'S','N',2),
 (2167,821,2,'Preciso Melhorar, Pouco Satisfeito.',NULL,NULL,'S','N',2),
 (2168,821,3,'Posso Aprimorar, Bastante Satisfeito.',NULL,NULL,'S','N',2),
 (2169,821,4,'Manter, Totalmente Satisfeito.',NULL,NULL,'S','N',2),
 (2170,822,1,'Melhorar com urgência, Nada Satisfeito.',NULL,NULL,'S','N',2),
 (2171,822,2,'Preciso Melhorar, Pouco Satisfeito.',NULL,NULL,'S','N',2),
 (2172,822,3,'Posso Aprimorar, Bastante Satisfeito.',NULL,NULL,'S','N',2),
 (2173,822,4,'Manter, Totalmente Satisfeito.',NULL,NULL,'S','N',2),
 (2174,823,1,'Melhorar com urgência, Nada Satisfeito.',NULL,NULL,'S','N',2),
 (2175,823,2,'Preciso Melhorar, Pouco Satisfeito.',NULL,NULL,'S','N',2),
 (2176,823,3,'Posso Aprimorar, Bastante Satisfeito.',NULL,NULL,'S','N',2),
 (2177,823,4,'Manter, Totalmente Satisfeito.',NULL,NULL,'S','N',2),
 (2178,824,1,'Melhorar com urgência, Nada Satisfeito.',NULL,1,'S','N',2),
 (2179,824,2,'Preciso Melhorar, Pouco Satisfeito.',NULL,NULL,'S','N',2),
 (2180,824,3,'Posso Aprimorar, Bastante Satisfeito.',NULL,NULL,'S','N',2),
 (2181,824,4,'Manter, Totalmente Satisfeito.',NULL,NULL,'S','N',2),
 (2182,825,1,'Melhorar com urgência, Nada Satisfeito.',NULL,NULL,'S','N',2),
 (2183,825,2,'Preciso Melhorar, Pouco Satisfeito.',NULL,NULL,'S','N',2),
 (2184,825,3,'Posso Aprimorar, Bastante Satisfeito.',NULL,NULL,'S','N',2),
 (2185,825,4,'Manter, Totalmente Satisfeito.',NULL,NULL,'S','N',2),
 (2186,826,1,'Melhorar com urgência, Nada Satisfeito.',NULL,NULL,'S','N',2),
 (2187,826,2,'Preciso Melhorar, Pouco Satisfeito.',NULL,NULL,'S','N',2),
 (2188,826,3,'Posso Aprimorar, Bastante Satisfeito.',NULL,NULL,'S','N',2),
 (2189,826,4,'Manter, Totalmente Satisfeito.',NULL,NULL,'S','N',2),
 (2190,827,1,'Melhorar com urgência, Nada Satisfeito.',NULL,NULL,'S','N',2),
 (2191,827,2,'Preciso Melhorar, Pouco Satisfeito.',NULL,NULL,'S','N',2),
 (2192,827,3,'Posso Aprimorar, Bastante Satisfeito.',NULL,NULL,'S','N',2),
 (2193,827,4,'Manter, Totalmente Satisfeito.',NULL,NULL,'S','N',2),
 (2194,828,1,'Melhorar com urgência, Nada Satisfeito.',NULL,NULL,'S','N',2),
 (2195,828,2,'Preciso Melhorar, Pouco Satisfeito.',NULL,NULL,'S','N',2),
 (2196,828,3,'Posso Aprimorar, Bastante Satisfeito.',NULL,NULL,'S','N',2),
 (2197,828,4,'Manter, Totalmente Satisfeito.',NULL,NULL,'S','N',2),
 (2198,829,1,'Melhorar com urgência, Nada Satisfeito.',NULL,NULL,'S','N',2),
 (2199,829,2,'Preciso Melhorar, Pouco Satisfeito.',NULL,NULL,'S','N',2),
 (2200,829,3,'Posso Aprimorar, Bastante Satisfeito.',NULL,NULL,'S','N',2),
 (2201,829,4,'Manter, Totalmente Satisfeito.',NULL,NULL,'S','N',2);
/*!40000 ALTER TABLE `grc_formulario_resposta` ENABLE KEYS */;


--
-- Definition of table `grc_formulario_secao`
--

DROP TABLE IF EXISTS `grc_formulario_secao`;
CREATE TABLE `grc_formulario_secao` (
  `idt` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idt_formulario` int(10) unsigned NOT NULL,
  `codigo` varchar(45) NOT NULL,
  `descricao` varchar(120) NOT NULL,
  `detalhe` text,
  `qtd_pontos` int(10) DEFAULT NULL,
  `valido` char(1) NOT NULL DEFAULT 'S',
  `idt_formulario_area` int(10) unsigned NOT NULL,
  `idt_formulario_relevancia` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`idt`),
  UNIQUE KEY `iu_grc_formulario_secao` (`idt_formulario`,`codigo`),
  KEY `FK_grc_formulario_secao_2` (`idt_formulario_area`),
  KEY `FK_grc_formulario_secao_3` (`idt_formulario_relevancia`),
  CONSTRAINT `FK_grc_formulario_secao_2` FOREIGN KEY (`idt_formulario_area`) REFERENCES `grc_formulario_area` (`idt`) ON UPDATE CASCADE,
  CONSTRAINT `FK_grc_formulario_secao_3` FOREIGN KEY (`idt_formulario_relevancia`) REFERENCES `grc_formulario_relevancia` (`idt`) ON UPDATE CASCADE,
  CONSTRAINT `fk_grc_formulario_secao` FOREIGN KEY (`idt_formulario`) REFERENCES `grc_formulario` (`idt`)
) ENGINE=InnoDB AUTO_INCREMENT=113 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `grc_formulario_secao`
--

/*!40000 ALTER TABLE `grc_formulario_secao` DISABLE KEYS */;
INSERT INTO `grc_formulario_secao` (`idt`,`idt_formulario`,`codigo`,`descricao`,`detalhe`,`qtd_pontos`,`valido`,`idt_formulario_area`,`idt_formulario_relevancia`) VALUES 
 (1,1,'1','FINANÇAS','Finanças',30,'S',2,5),
 (4,1,'2','MERCADO','Mercado',20,'S',3,5),
 (7,1,'3','PLANEJAMENTO','Planejamento',50,'S',4,5),
 (8,2,'01','Finanças',NULL,20,'S',2,2),
 (10,3,'SE0000007','FINANÇAS','Finanças',23,'S',2,5),
 (11,1,'SE0000008','ORGANIZAÇÃO','Organização',NULL,'S',5,5),
 (12,1,'SE0000010','PESSOAS','Pessoas',NULL,'S',6,5),
 (13,1,'SE0000012','INOVAÇÃO','Inovação',NULL,'S',7,5),
 (14,3,'SE0000013','MERCADO','Mercado',NULL,'S',3,5),
 (15,3,'SE0000014','PLANEJAMENTO','Planejamento',NULL,'S',4,5),
 (16,3,'SE0000015','ORGANIZAÇÃO','Organização',NULL,'S',5,5),
 (17,3,'SE0000016','PESSOAS','Pessoas',NULL,'S',6,5),
 (18,3,'SE0000017','INOVAÇÃO','Inovação',NULL,'S',7,5),
 (19,2,'SE0000018','MERCADO','Mercado',NULL,'S',3,5),
 (20,2,'SE0000020','PLANEJAMENTO','Planejamento',NULL,'S',4,5),
 (21,2,'SE0000021','ORGANIZAÇÃO','Organização',NULL,'S',5,5),
 (22,2,'SE0000022','PESSOAS','Pessoas',NULL,'S',6,5),
 (23,2,'SE0000023','INOVAÇÃO','Inovação',NULL,'S',7,2),
 (107,4,'1','FINANÇAS','Finanças',30,'S',2,5),
 (108,4,'2','MERCADO','Mercado',20,'S',3,5),
 (109,4,'3','PLANEJAMENTO','Planejamento',50,'S',4,5),
 (110,4,'SE0000008','ORGANIZAÇÃO','Organização',NULL,'S',5,5),
 (111,4,'SE0000010','PESSOAS','Pessoas',NULL,'S',6,5),
 (112,4,'SE0000012','INOVAÇÃO','Inovação',NULL,'S',7,5);
/*!40000 ALTER TABLE `grc_formulario_secao` ENABLE KEYS */;




/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
