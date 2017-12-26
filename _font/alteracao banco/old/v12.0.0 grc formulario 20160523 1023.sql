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
  `grupo` varchar(45) NOT NULL DEFAULT 'GER',
  `idt_instrumento` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`idt`),
  UNIQUE KEY `iu_grc_formulario` (`grupo`,`codigo`) USING BTREE,
  KEY `FK_grc_formulario_1` (`idt_aplicacao`),
  KEY `FK_grc_formulario_2` (`idt_responsavel`),
  KEY `FK_grc_formulario_3` (`idt_area_responsavel`),
  KEY `FK_grc_formulario_4` (`idt_dimensao`),
  KEY `FK_grc_formulario_5` (`idt_instrumento`),
  CONSTRAINT `FK_grc_formulario_1` FOREIGN KEY (`idt_aplicacao`) REFERENCES `grc_formulario_aplicacao` (`idt`),
  CONSTRAINT `FK_grc_formulario_2` FOREIGN KEY (`idt_responsavel`) REFERENCES `plu_usuario` (`id_usuario`),
  CONSTRAINT `FK_grc_formulario_3` FOREIGN KEY (`idt_area_responsavel`) REFERENCES `db_pir`.`sca_organizacao_secao` (`idt`),
  CONSTRAINT `FK_grc_formulario_4` FOREIGN KEY (`idt_dimensao`) REFERENCES `grc_formulario_dimensao_resposta` (`idt`) ON UPDATE CASCADE,
  CONSTRAINT `FK_grc_formulario_5` FOREIGN KEY (`idt_instrumento`) REFERENCES `grc_atendimento_instrumento` (`idt`) ON UPDATE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `grc_formulario`
--

/*!40000 ALTER TABLE `grc_formulario` DISABLE KEYS */;
INSERT INTO `grc_formulario` (`idt`,`codigo`,`descricao`,`ativo`,`detalhe`,`qtd_pontos`,`idt_aplicacao`,`idt_responsavel`,`idt_area_responsavel`,`versao_texto`,`versao_numero`,`data_inicio_aplicacao`,`data_termino_aplicacao`,`observacao`,`idt_dimensao`,`controle_pontos`,`grupo`,`idt_instrumento`) VALUES 
 (1,'03','Negócio a Negócio - Percepção do AOE (ELEGIBILIDADE)','S','Como o nome já diz, respostas prováveis, através da análise realizada no atendimento, o agente deverá escolher a \r\nresposta mais apropriada. Sempre solicitar ao cliente uma evidencia para verificar se o método dele realmente é \r\nefetivo e adequado. Procurando sensibilizar acerca da importância das ferramentas de gestão empresarial.',100,1,90,6,'V1.0','1.00','2015-07-01 00:00:00','2015-07-31 00:00:00',NULL,2,'N','NAN',NULL),
 (2,'02','Negócio a Negócio - Percepção do Cliente (QUESITOS)','S','Neste campo o que vale é a opinião do empresário, é como ele se sente em relação as suas ações referentes a um determinado quesito.\r\nNeste bloco ele expõe seu sentimento, sua percepção de como ele está praticando aquela ferramenta questionada.',100,1,90,6,NULL,NULL,NULL,NULL,NULL,4,'N','NAN',NULL),
 (3,'01','Negócio a Negócio - Percepção do Cliente  (Área Temática)','S','Neste campo o que vale é a opinião do empresário, é como ele se sente em relação as suas ações referentes a um determinado quesito.\r\nNeste bloco ele expõe seu sentimento, sua percepção de como ele está praticando aquela ferramenta questionada.',100,1,1373,74,'V.1','1.00',NULL,NULL,NULL,5,'N','NAN',NULL),
 (4,'50','Diagnóstico Situacional','S','Negócio a Negócio - Diagnóstico Situacional',100,1,90,6,'v.1','1.00',NULL,NULL,NULL,6,'N','NAN',NULL),
 (5,'70','Evento - Avaliação do Gestor','S','Formulário para avaliação do Evento pelo gestor do Evento',100,4,186,5,'v.1','1.00',NULL,NULL,NULL,2,'S','GC',NULL),
 (6,'71','Evento - Avaliação do Credenciado','S','Avaliação do Evento pelo Credenciado',100,3,186,5,'V.1','1.00',NULL,NULL,NULL,2,'S','GC',NULL),
 (7,'72','Evento - Avaliação do Cliente','S','Avaliação do Evento pelo Cliente (Alunos)',100,2,186,5,'V.1','1.00',NULL,NULL,NULL,2,'S','GC',NULL),
 (8,'00','Perspectiva Empresarial','S',NULL,100,1,90,6,NULL,NULL,NULL,NULL,NULL,7,'N','NAN',NULL);
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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `grc_formulario_aplicacao`
--

/*!40000 ALTER TABLE `grc_formulario_aplicacao` DISABLE KEYS */;
INSERT INTO `grc_formulario_aplicacao` (`idt`,`codigo`,`descricao`,`ativo`,`detalhe`) VALUES 
 (1,'01','Negócio a Negócio','S',NULL),
 (2,'70','Avaliação do Cliente - (Aluno)','S',NULL),
 (3,'71','Avaliação do Credenciado','S','O Credenciado avalia as condições oferecidas pelo SEBRAE e Clientes para consecução dos trabalhos.'),
 (4,'72','Avaliação do Gestor do Evento','S','O Gestor do Evento avalia toda a execução do Evento');
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
  `grupo` varchar(45) NOT NULL DEFAULT 'GER',
  `idt_tema_subtema` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`idt`),
  UNIQUE KEY `iu_grc_formulario_area` (`grupo`,`codigo`) USING BTREE,
  KEY `fk_grc_formulario_area_1` (`idt_tema_subtema`),
  CONSTRAINT `fk_grc_formulario_area_1` FOREIGN KEY (`idt_tema_subtema`) REFERENCES `grc_tema_subtema` (`idt`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `grc_formulario_area`
--

/*!40000 ALTER TABLE `grc_formulario_area` DISABLE KEYS */;
INSERT INTO `grc_formulario_area` (`idt`,`codigo`,`descricao`,`ativo`,`detalhe`,`grupo`,`idt_tema_subtema`) VALUES 
 (2,'01','FINANÇAS','S','FINANÇAS','NAN',NULL),
 (3,'02','MERCADO','S','MERCADO','NAN',NULL),
 (4,'03','PLANEJAMENTO','S','PLANEJAMENTO','NAN',NULL),
 (5,'04','ORGANIZAÇÃO','S','ORGANIZAÇÃO','NAN',NULL),
 (6,'05','PESSOAS','S','PESSOAS','NAN',NULL),
 (7,'06','INOVAÇÃO','S','INOVAÇÃO','NAN',NULL),
 (8,'07','COOPERAÇÃO','S','COOPERAÇÃO','NAN',NULL),
 (10,'00','PERSPECTIVA EMPRESARIAL','S','PERSPECTIVA EMPRESARIAL','NAN',NULL);
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
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `grc_formulario_dimensao_resposta`
--

/*!40000 ALTER TABLE `grc_formulario_dimensao_resposta` DISABLE KEYS */;
INSERT INTO `grc_formulario_dimensao_resposta` (`idt`,`codigo`,`descricao`,`ativo`,`detalhe`,`agregador`,`sigla`) VALUES 
 (2,'01','Elegibilidade','S',NULL,'N','E'),
 (3,'02','Complexidade','S',NULL,'N','C'),
 (4,'03','Satisfação(Q)','S',NULL,'N','Q'),
 (5,'04','Satisfação(A)','S',NULL,'N','A'),
 (6,'50','Diagnóstico Situacional','S','Negócio a Negócio - Diagnóstico Situacional','S','D'),
 (7,'05','Geral','S',NULL,'N','GE');
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
 (8,3,'CONTROLE DO FLUXO DE CAIXA','S','<p><span style=\"font-family: Tahoma;\">Esta ferramenta apresenta as receitas e gastos futuros distribu&iacute;dos semanalmente, permitindo a visualiza&ccedil;&atilde;o dos descompassos que podem ocorrer entre receitas e gastos, ou seja, per&iacute;odos com gastos superiores &agrave;s receitas e vice-versa.</span></p>',1,31,2),
 (9,4,'CÁLCULO DO GANHO UNITÁRIO','S','<p><span style=\"font-family: Tahoma;\">Essa ferramenta auxilia no c&aacute;lculo do ganho em dinheiro que o empres&aacute;rio obt&eacute;m com a venda de seus produtos e/ou servi&ccedil;os. Ou seja, a partir do pre&ccedil;o praticado, diminuindo os custos vari&aacute;veis diretos necess&aacute;rios para fazer o produto ou prestar o servi&ccedil;o, identificar quanto sobra para o empres&aacute;rio.</span></p>',2,36,2),
 (10,5,'DEMONSTRATIVO DE RESULTADO','S','<p><span style=\"font-family: Tahoma;\">Essa ferramenta apresenta objetivamente o resultado mensal de seu neg&oacute;cio. Com ela voc&ecirc; poder&aacute; registrar os valores de suas despesas e receitas. Al&eacute;m disso, pode acompanhar m&ecirc;s a m&ecirc;s quanto seu neg&oacute;cio est&aacute; gerando de dinheiro.</span></p>',2,42,2),
 (11,6,'GESTÃO DE ESTOQUES','S','<p><span style=\"font-family: Tahoma;\">Esta ferramenta tem como objetivo auxili&aacute;-lo no controle dos seus estoques (produtos, mat&eacute;riasprimas e materiais). Voc&ecirc; poder&aacute; definir qual a quantidade m&iacute;nima ou m&aacute;xima necess&aacute;ria de um determinado produto e tamb&eacute;m qual o momento ideal para fazer um novo pedido, evitando, principalmente, a falta de produtos para seus clientes.</span></p>',2,47,2),
 (12,7,'CONTROLE DO CAPITAL DE GIRO','S','<p><span style=\"font-family: Tahoma;\">Essa ferramenta permite acompanhar a quantidade de dinheiro necess&aacute;rio para atender os compromissos do dia a dia da empresa, o seu Capital de Giro.</span></p>',2,42,2),
 (13,8,'CADASTRO DE CLIENTES','S','<p><span style=\"font-family: Tahoma;\">Esta ferramenta ir&aacute; manter importantes informa&ccedil;&otilde;es sobre seus clientes &agrave; disposi&ccedil;&atilde;o, tais como a regi&atilde;o em que residem, seu perfil pessoal, os melhores meios para voc&ecirc; contat&aacute;-lo, seu perfil de compras, etc. Al&eacute;m de tudo, ir&aacute; ajudar voc&ecirc; a conhecer melhor os seus clientes para atend&ecirc;-los de maneira mais adequada</span></p>',1,61,3),
 (14,9,'PESQUISA DE SATISFAÇÃO','S','<p><span style=\"font-family: Tahoma;\">O fato de seus clientes n&atilde;o reclamarem n&atilde;o significa que eles estejam totalmente satisfeitos com seu neg&oacute;cio. Assim, esta ferramenta ir&aacute; auxili&aacute;-lo a identificar o n&iacute;vel de satisfa&ccedil;&atilde;o de seus clientes em rela&ccedil;&atilde;o aos produtos e servi&ccedil;os ofertados em sua empresa. Um cliente satisfeito amplia a propaganda boca a boca</span></p>',1,69,3),
 (15,10,'ANÁLISE DAS NECESSIDADES DOS CLIENTES','S','<p><span style=\"font-family: Tahoma;\">Esta ferramenta ir&aacute; auxili&aacute;-lo na identifica&ccedil;&atilde;o e an&aacute;lise das principais necessidades e desejos de seus clientes, permitindo, assim, ampliar e melhorar suas possibilidades de atendimento o que poder&aacute; gerar diferencia&ccedil;&atilde;o e novas formas de ganhar mais dinheiro.</span></p>',2,74,3),
 (16,11,'SEGMENTAÇÃO DE CLIENTES','S','<p><span style=\"font-family: Tahoma;\">Esta ferramenta ir&aacute; classificar seus clientes de acordo com alguns crit&eacute;rios de segmenta&ccedil;&atilde;o (prefer&ecirc;ncia e volume de compra, regi&atilde;o, idade, estilos de vida, etc.). Assim, poder&aacute; formar grupos de clientes que possuem caracter&iacute;sticas comuns. Agrupando seus clientes desta maneira, sua empresa estar&aacute; apta a praticar o Marketing de Segmento, permitindo que voc&ecirc; tenha a&ccedil;&otilde;es mais direcionadas a cada grupo de clientes.</span></p>',2,80,3),
 (17,12,'OFERTANDO NOVOS PRODUTOS/SERVIÇOS','S','<p><span style=\"font-family: Tahoma;\">Esta ferramenta est&aacute; direcionada a captar do mercado informa&ccedil;&otilde;es que contribuam para voc&ecirc; visualizar oportunidades de ofertar novos produtos e servi&ccedil;os. Vai mostrar a voc&ecirc; oportunidades que hoje n&atilde;o s&atilde;o ofertadas e que podem contribuir com a melhoria da sua empresa.</span></p>',2,84,3),
 (18,13,'ENTENDIMENTO DO MERCADO','S','<p><span style=\"font-family: Tahoma;\">Esta ferramenta ir&aacute; propiciar que voc&ecirc; conhe&ccedil;a mais claramente o mercado em que atua e a partir destas informa&ccedil;&otilde;es direcionar a&ccedil;&otilde;es para tornar seu neg&oacute;cio mais competitivo, ou seja, mais atraente ao seu cliente do que seus concorrentes.</span></p>',3,89,3),
 (19,14,'PLANO DE PROMOÇÃO','S','<p><span style=\"font-family: Tahoma;\">Esta ferramenta auxilia voc&ecirc; a planejar as a&ccedil;&otilde;es de promo&ccedil;&atilde;o que pretende realizar no seu neg&oacute;- cio (propaganda de produtos e servi&ccedil;os, descontos, etc.). As promo&ccedil;&otilde;es servem para mobilizar e fidelizar os clientes, aumentado suas vendas e o lucro.</span></p>',3,93,3),
 (20,15,'PLANEJAMENTO: O PRIMEIRO PASSO PARA O SUCESSO','S','<p><span style=\"font-family: Tahoma;\">Esta ferramenta ir&aacute; ajud&aacute;-lo a entender o porqu&ecirc; de fazer o planejamento e a import&acirc;ncia de definir um conjunto de a&ccedil;&otilde;es para realizar este plano. Quanto melhor for o seu planejamento e a realiza&ccedil;&atilde;o, maiores ser&atilde;o as suas chances de sucesso. O planejamento &eacute; um processo din&acirc;mico e cont&iacute;nuo. Planejar de maneira din&acirc;mica ajuda a reduzir atritos, confus&otilde;es e perdas. &Eacute; considerado cont&iacute;nuo porque voc&ecirc; deve planejar sempre e fazer corre&ccedil;&otilde;es a qualquer momento para alterar os rumos previamente definidos.</span></p>',1,101,3),
 (21,16,'PLANEJANDO O NEGÓCIO: OBJETIVOS E METAS','S','<p><span style=\"font-family: Tahoma;\">Ao utilizar essa ferramenta, voc&ecirc; refletir&aacute; sobre a situa&ccedil;&atilde;o atual do seu neg&oacute;cio e a situa&ccedil;&atilde;o desejada, definindo a orienta&ccedil;&atilde;o de &ldquo;como causar a mudan&ccedil;a?&rdquo;, com foco no crescimento e sucesso do neg&oacute;cio. Voc&ecirc; partir&aacute; da situa&ccedil;&atilde;o atual (&ldquo;o que mudar?&rdquo;) e ter&aacute; como vis&atilde;o de futuro onde quer chegar (&ldquo;para o qu&ecirc; mudar?&rdquo;).</span></p>',2,106,3),
 (22,17,'PLANO DE AÇÃO DE CURTO E MÉDIO PRAZO','S','<p><span style=\"font-family: Tahoma;\">Objetivos e Metas s&atilde;o materializados por planos de a&ccedil;&atilde;o bem definidos. Sendo assim, ao utilizar esta ferramenta, voc&ecirc; definir&aacute; o caminho para conduzir sua empresa ao sucesso. Um plano de a&ccedil;&atilde;o a gerenciar o planejamento.</span></p>',2,111,3),
 (23,18,'APRENDIZAGEM ESTRATÉGICA','S','<p><span style=\"font-family: Tahoma;\">Ao utilizar essa ferramenta voc&ecirc; poder&aacute; resgatar situa&ccedil;&otilde;es que tiveram resultados satisfat&oacute;rios e/ ou ruins, por parte da empresa. Sendo assim, por meio destas situa&ccedil;&otilde;es, voc&ecirc; poder&aacute; manter e/ ou melhorar boas pr&aacute;ticas e n&atilde;o repetir os erros realizados no passado.</span></p>',3,115,3),
 (24,19,'ORGANIZAÇÃO E DISCIPLINA','S','<p><span style=\"font-family: Tahoma;\">A ferramenta apresentar&aacute; a voc&ecirc; um conjunto de conceitos e orienta&ccedil;&otilde;es que ir&atilde;o o auxiliar a compreender a import&acirc;ncia da organiza&ccedil;&atilde;o e disciplina para sua empresa. Ajudar&aacute;, ainda, a verificar em que n&iacute;vel de organiza&ccedil;&atilde;o sua empresa se encontra. Um ambiente de trabalho limpo e organizado pode garantir sua produtividade. Al&eacute;m de deixar as coisas &ldquo;mais &agrave; m&atilde;o&rdquo;, os desperd&iacute;cios e movimentos desnecess&aacute;rios come&ccedil;am a desaparecer, melhorando seu rendimento na atividade.</span></p>',1,123,5),
 (25,20,'ORGANIZAÇÃO DE DOCUMENTOS','S','<p><span style=\"font-family: Tahoma;\">Com esta ferramenta voc&ecirc; manter&aacute; organizado e sempre &agrave; m&atilde;o os documentos b&aacute;sicos da sua empresa. Al&eacute;m disso, contas a pagar e comprovantes de pagamentos, por exemplo, estar&atilde;o facilmente dispon&iacute;veis, reduzindo o risco de pagar duas vezes a mesma conta ou, ainda pior, n&atilde;o realizar o pagamento e ter que pagar juros ou at&eacute; mesmo ter o servi&ccedil;o interrompido por esquecimento e falta de organiza&ccedil;&atilde;o.</span></p>',1,129,5),
 (26,21,'CADASTRO DE FORNECEDORES','S','<p><span style=\"font-family: Tahoma;\">Esta ferramenta se apresenta como um fich&aacute;rio b&aacute;sico de fornecedores por produto ou fam&iacute;lia de produtos. Este cadastro &eacute; o m&iacute;nimo que voc&ecirc; precisa para saber de quem comprar quando precisar.</span></p>',2,131,5),
 (27,22,'INSTRUÇÃO DE TRABALHO','S','<p><span style=\"font-family: Tahoma;\">A Instru&ccedil;&atilde;o de Trabalho &eacute; uma ferramenta para documentar ou padronizar tarefas espec&iacute;ficas e operacionais. Com ela voc&ecirc; faz a descri&ccedil;&atilde;o e tamb&eacute;m a ilustra&ccedil;&atilde;o de como fazer determinado processo. Com isso, voc&ecirc; pode delegar e cobrar a realiza&ccedil;&atilde;o do trabalho de seus funcion&aacute;rios.</span></p>',3,135,5),
 (28,23,'COMPETÊNCIAS NECESSÁRIAS','S','<p><span style=\"font-family: Tahoma;\">Essa ferramenta visa orientar voc&ecirc; sobre como definir o que as pessoas precisam para trabalhar bem, assim como, havendo a necessidade de contrata&ccedil;&atilde;o, identificar quais as compet&ecirc;ncias essenciais para o neg&oacute;cio s&atilde;o desejadas dos candidatos.<span class=\"Apple-tab-span\" style=\"white-space: pre;\">			</span>&nbsp;</span></p>',1,143,6),
 (29,24,'ORIENTAÇÕES PARA OBRIGAÇÕES TRABALHISTAS','S','<p><span style=\"font-family: Tahoma;\">Essa ferramenta visa orientar voc&ecirc;, que inicia o processo de recrutamento, sobre como agir com os funcion&aacute;rios desde a contrata&ccedil;&atilde;o at&eacute; sua eventual demiss&atilde;o, al&eacute;m de orient&aacute;-lo para todas as obriga&ccedil;&otilde;es trabalhistas relacionadas com voc&ecirc; e com seus funcion&aacute;rios. Isso pode evitar um conjunto de preju&iacute;zos de rela&ccedil;&atilde;o trabalhista que podem impactar no resultado da empresa e na insatisfa&ccedil;&atilde;o dos funcion&aacute;rios.</span></p>',1,147,6),
 (30,25,'MATRIZ DE RESPONSABILIDADES','S','<p><span style=\"font-family: Tahoma;\">Ao utilizar esta ferramenta voc&ecirc; ir&aacute; identificar as responsabilidades esperadas dos seus funcion&aacute;rios e que eles est&atilde;o aptos a realizar. Poder&aacute; tamb&eacute;m definir quem &eacute; a pessoa substituta em caso de aus&ecirc;ncia do respons&aacute;vel.</span></p>',2,150,4),
 (31,26,'PENSANDO EM EXPANDIR? PREPARE-SE PARA DELEGAR','S','<p><span style=\"font-family: Tahoma;\">Esta ferramenta far&aacute; voc&ecirc; refletir sobre a import&acirc;ncia da delega&ccedil;&atilde;o de tarefas para que possa expandir seu neg&oacute;cio. Este processo de delega&ccedil;&atilde;o deve ser conduzido de maneira organizada e sistem&aacute;tica para seus funcion&aacute;rios. Somente delegando ser&aacute; poss&iacute;vel que voc&ecirc; invista mais tempo em atividades estrat&eacute;gicas para seu neg&oacute;cio</span></p>',3,154,6),
 (32,27,'TREINAMENTO BASEADO EM PROBLEMAS','S','<p><span style=\"font-family: Tahoma;\">Esta ferramenta ir&aacute; orientar voc&ecirc; a realizar treinamentos com base na an&aacute;lise de problemas. Estes problemas podem ter ocorrido, ou a partir da sua experi&ecirc;ncia, podem vir a ocorrer no futuro.</span></p>',3,158,6),
 (33,28,'CONHECIMENTOS E CARACTERÍSTICAS','S',NULL,1,159,6),
 (36,29,'LAYOUT E ORGANIZAÇÃO DO EMPREENDIMENTO','S',NULL,1,NULL,7),
 (37,30,'TRENA DAS VENDAS','S',NULL,1,NULL,7),
 (38,31,'MATERIAL DE SINALIZAÇÃO','S',NULL,1,NULL,7),
 (39,32,'RELACIONAMENTO COM O CLIENTE','S',NULL,1,NULL,7),
 (40,33,'ANÁLISE DOS PROCEDIMENTOS NA EMPRESA','S',NULL,1,NULL,7);
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
  `idt_classe` int(10) unsigned DEFAULT NULL,
  `ajuda` text,
  `idt_ferramenta` int(10) unsigned DEFAULT NULL,
  `obrigatoria` varchar(1) NOT NULL DEFAULT 'S',
  `evidencias` text,
  `idt_dimensao` int(10) unsigned DEFAULT NULL,
  `codigo_quesito` int(10) unsigned DEFAULT NULL,
  `sigla_dimensao` varchar(5) DEFAULT NULL,
  PRIMARY KEY (`idt`),
  UNIQUE KEY `iu_grc_formulario_pergunta` (`idt_secao`,`idt_dimensao`,`codigo`) USING BTREE,
  KEY `FK_grc_formulario_pergunta_3` (`idt_classe`),
  KEY `FK_grc_formulario_pergunta_4` (`idt_ferramenta`),
  CONSTRAINT `FK_grc_formulario_pergunta_2` FOREIGN KEY (`idt_secao`) REFERENCES `grc_formulario_secao` (`idt`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_grc_formulario_pergunta_3` FOREIGN KEY (`idt_classe`) REFERENCES `grc_formulario_classe_pergunta` (`idt`) ON UPDATE CASCADE,
  CONSTRAINT `FK_grc_formulario_pergunta_4` FOREIGN KEY (`idt_ferramenta`) REFERENCES `grc_formulario_ferramenta_gestao` (`idt`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1353 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `grc_formulario_pergunta`
--

/*!40000 ALTER TABLE `grc_formulario_pergunta` DISABLE KEYS */;
INSERT INTO `grc_formulario_pergunta` (`idt`,`idt_secao`,`codigo`,`descricao`,`detalhe`,`qtd_pontos`,`valido`,`idt_classe`,`ajuda`,`idt_ferramenta`,`obrigatoria`,`evidencias`,`idt_dimensao`,`codigo_quesito`,`sigla_dimensao`) VALUES 
 (1,1,1,'Você controla as entradas e saídas diárias de dinheiro?',NULL,30,'S',2,NULL,2,'S',NULL,0,NULL,NULL),
 (4,4,1,'Sua empresa tem um cadastro com informações de seus clientes em algum lugar?',NULL,20,'S',2,NULL,13,'S',NULL,0,NULL,NULL),
 (7,7,1,'Você planeja os objetivos que deseja alcançar, tendo alguma forma de registro de onde quer chegar?',NULL,50,'S',2,NULL,20,'S',NULL,0,NULL,NULL),
 (8,8,2,'Como você se sente quanto ao Dimensionamento do Capital de Giro na sua empresa?',NULL,10,'S',2,NULL,2,'S',NULL,0,NULL,NULL),
 (10,8,3,'Como você se sente quanto à gestão dos Pagamentos de Impostos da sua empresa?',NULL,10,'S',2,NULL,2,'S',NULL,0,NULL,NULL),
 (11,8,1,'Como você se sente quanto ao Controle do Fluxo de Caixa da sua empresa?',NULL,0,'S',2,NULL,8,'S',NULL,0,NULL,NULL),
 (12,8,4,'Como você se sente quanto Identificação e Cálculos dos Custos da empresa?',NULL,0,'S',2,NULL,12,'N',NULL,0,NULL,NULL),
 (13,8,5,'Como você se sente quanto ao controle Periódico do Lucro da empresa?',NULL,0,'S',2,NULL,8,'N',NULL,0,NULL,NULL),
 (14,8,6,'Como você se sente quanto a Análise do Preço de Venda dos produtos da empresa?',NULL,0,'S',2,NULL,8,'N',NULL,0,NULL,NULL),
 (15,8,7,'Como você se sente quanto à Gestão de Estoques da sua empresa?',NULL,0,'S',2,NULL,11,'N',NULL,0,NULL,NULL),
 (16,1,2,'Você possui um controle de entradas, saídas e saldo de dinheiro para os meses futuros?',NULL,0,'S',2,NULL,8,'N',NULL,0,NULL,NULL),
 (17,1,3,'Você sabe quanto dinheiro deve ter em caixa para cobrir suas despesas enquanto não recebe os pagamentos?',NULL,0,'S',2,NULL,12,'N',NULL,0,NULL,NULL),
 (18,1,4,'Você controla as datas e valores de todos os tributos a serem pagos? (Impostos e também Taxas)',NULL,0,'S',2,NULL,7,'N',NULL,0,NULL,NULL),
 (19,1,5,'Você calcula os gastos (custos e despesas) mensalmente?',NULL,0,'S',2,NULL,10,'S',NULL,0,NULL,NULL),
 (20,1,6,'Você calcula o resultado (lucro ou prejuízo) do seu negócio periodicamente?',NULL,0,'S',2,NULL,10,'S',NULL,0,NULL,NULL),
 (21,1,7,'Você sabe qual é o seu ganho de dinheiro em cada produto ou serviço vendido?',NULL,0,'S',2,NULL,9,'S',NULL,0,NULL,NULL),
 (22,1,8,'Você tem um controle do estoque dos produtos e insumos? (incluindo datas de validade, quantidade, etc.)',NULL,0,'S',2,NULL,11,'S',NULL,0,NULL,NULL),
 (23,4,2,'A empresa sabe quais são os diferentes grupos de clientes que frequentam seu estabelecimento e faz ações direcionadas a cada um destes grupos?',NULL,0,'S',2,NULL,16,'S',NULL,0,NULL,NULL),
 (24,4,3,'Você analisa regularmente as necessidades dos clientes para orientar suas ações de marketing e definição de serviços e produtos?',NULL,0,'S',2,NULL,15,'S',NULL,0,NULL,NULL),
 (25,4,4,'Você faz alguma pesquisa para saber a satisfação dos clientes?',NULL,0,'S',2,NULL,14,'S',NULL,0,NULL,NULL),
 (26,4,5,'Você planeja ações para promover e divulgar seus produtos e serviços?',NULL,0,'S',2,NULL,19,'S',NULL,0,NULL,NULL),
 (27,4,6,'Sua empresa oferta novos produtos/serviços para seus clientes? (Observar critérios para escolha dos produtos e teste dos produtos novos)',NULL,0,'S',2,NULL,17,'S',NULL,0,NULL,NULL),
 (28,4,7,'Você avalia seus concorrentes para saber o que deve melhorar?',NULL,0,'S',2,NULL,18,'S',NULL,0,NULL,NULL),
 (29,7,2,'Você tem seus objetivos e metas escritos e bem definidos?',NULL,0,'S',2,NULL,21,'S',NULL,0,NULL,NULL),
 (30,7,3,'Você toma nota das decisões e resultados de seu planejamento, observando situações em que houve resultados diferentes dos que você queria, para aprimorar o que deu certo e não repetir erros do passado?',NULL,0,'S',2,NULL,23,'S',NULL,0,NULL,NULL),
 (31,7,4,'Existem ações com prazos definidos para que os objetivos planejados pela empresa para o futuro possam ser alcançados?',NULL,0,'S',2,NULL,22,'S',NULL,0,NULL,NULL),
 (32,10,1,'Controle de Resultados na sua empresa, você considera que está:',NULL,12,'S',2,'12',2,'S',NULL,0,NULL,NULL),
 (33,11,1,'Você possui um controle de quem são os fornecedores de seus produtos e prestadores de serviço, facilitando sua pesquisa de preços?',NULL,NULL,'S',2,NULL,26,'S',NULL,0,NULL,NULL),
 (34,11,2,'Os documentos importantes de sua empresas e contas estão bem organizados?',NULL,NULL,'S',2,NULL,25,'S',NULL,0,NULL,NULL),
 (35,11,3,'As atividades realizadas regularmente possuem um procedimento escrito de como elas devem ser feitas?',NULL,NULL,'S',2,NULL,27,'S',NULL,0,NULL,NULL),
 (36,11,4,'A organização da sua empresa permite que você trabalhe de maneira eficiente e ágil?',NULL,NULL,'S',2,NULL,24,'S',NULL,0,NULL,NULL),
 (37,11,5,'Sua empresa possui um layout (arranjo físico) definido para facilitar a entrega do produto/serviço, comercialização e atendimento aos clientes?',NULL,NULL,'S',2,NULL,NULL,'S',NULL,0,NULL,NULL),
 (38,12,1,'Você sabe quais são as obrigações trabalhistas de sua empresa, da contratação até o desligamento? E em relação a você, sabe o que fazer para se aposentar com tranquilidade?',NULL,NULL,'S',2,NULL,29,'S',NULL,0,NULL,NULL),
 (39,12,2,'Você já definiu que conhecimentos e características as pessoas devem ter para realizar as atividades em sua empresa, incluindo você e sócios?',NULL,NULL,'S',2,NULL,33,'S',NULL,0,NULL,NULL),
 (40,12,3,'Se você, seu sócio ou algum funcionário faltar ou tirar férias, está definido um responsável para ficar no lugar desta pessoa?',NULL,NULL,'S',2,NULL,30,'S',NULL,0,NULL,NULL),
 (41,12,4,'Você faz uma avaliação dos problemas recorrentes ou potenciais em seu negócio, visando evitar que os mesmos ocorram?',NULL,NULL,'S',2,NULL,32,'S',NULL,0,NULL,NULL),
 (42,12,5,'Se for necessário delegar alguma atividade (por motivo de doença, expansão, etc.), você já sabe quais são as atividades que pode delegar?',NULL,NULL,'S',2,NULL,31,'S',NULL,0,NULL,NULL),
 (43,13,1,'A organização do espaço de forma geral é clara e a circulação está desobstruída?',NULL,NULL,'S',2,NULL,36,'S',NULL,0,NULL,NULL),
 (44,13,2,'A empresa comercializa produtos de forma que a exposição deles favoreça a venda?',NULL,NULL,'S',2,NULL,37,'S',NULL,0,NULL,NULL),
 (45,13,3,'A empresa possui marca própria e comunicação visual padronizada? Todas as áreas do estabelecimento onde a circulação é desejada são acessadas pelos clientes? Visualmente, os clientes e funcionários conseguem encontrar a informação que precisam?',NULL,NULL,'S',2,NULL,38,'S',NULL,0,NULL,NULL),
 (48,13,4,'Os clientes são pessoas ou organizações que usam ou consomem produtos para atender às determinadas necessidades. Os métodos de inovação centrados no cliente divergem das abordagens tradicionais, caracterizadas pela busca da inovação por meio de avanços tecnológicos ou da otimização dos processos comerciais. Inovar nesta dimensão significa, por exemplo, encontrar um novo nicho de mercado para determinado produto ou serviço. A empresa adota alguma prática de relacionamento ou pesquisa sistemática para identificar as necessidades do mercado ou dos clientes?',NULL,NULL,'S',2,NULL,39,'S',NULL,0,NULL,NULL),
 (49,13,5,'Os processos são as configurações das atividades usadas na condução das operações internas à empresa. A inovação, nesta dimensão, pressupõe o reprojeto de seus processos para buscar maior eficiência, maior qualidade ou um tempo de resposta (tempo de ciclo) menor. A empresa alterou seus processos para obter maior eficiência, qualidade, flexibilidade ou menor ciclo de produção?',NULL,NULL,'S',2,NULL,40,'S',NULL,0,NULL,NULL),
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
 (830,113,1,'Cumpriu o cronograma combinado?',NULL,100,'S',2,NULL,NULL,'N',NULL,NULL,NULL,NULL),
 (831,113,2,'Atendeu os objetivos e requisitos ténicos exigidos?',NULL,0,'S',2,NULL,NULL,'N',NULL,NULL,NULL,NULL),
 (832,113,3,'Obedeceu aos prazos pré-estabelecidos na entrega de documentos (relatórios, notas fiscais, formulários, etc)?',NULL,0,'S',2,NULL,NULL,'N',NULL,NULL,NULL,NULL),
 (833,113,4,'Manteve relacionamento de sigilo, confiança e respeito em todas as etapas do trabalho?',NULL,0,'S',2,NULL,NULL,'N',NULL,NULL,NULL,NULL),
 (835,145,1,'Estabeleceu cronograma e objetivos da contratação compatíveis com o serviço a ser realizado?',NULL,100,'S',2,NULL,NULL,'N',NULL,NULL,NULL,NULL),
 (836,145,2,'Manteve relacionamento de confiança e respeito em todas as etapas do trabalho?',NULL,0,'S',2,NULL,NULL,'N',NULL,NULL,NULL,NULL),
 (837,145,3,'Disponibilizou todos os rescursos físicos e materiais necessários à execução dos serviços contratados?',NULL,0,'S',NULL,NULL,NULL,'N',NULL,NULL,NULL,NULL),
 (838,145,4,'Tomou as providências para garantir que o pagamento e os eventuais ressarcimentos de despesas fossem realizados nos prazos acordados?',NULL,0,'S',2,NULL,NULL,'N',NULL,NULL,NULL,NULL),
 (839,146,1,'Tratou as informações da sua empresa com ética e sigilo?',NULL,100,'S',2,NULL,NULL,'N',NULL,NULL,NULL,NULL),
 (840,146,2,'Criou um relacionamento de confiança e respeito com as pessoas envolvidas no trabalho?',NULL,0,'S',2,NULL,NULL,'N',NULL,NULL,NULL,NULL),
 (841,146,3,'Demonstrou conhecimentos técnicos atualizados sobre o problema?',NULL,0,'S',2,NULL,NULL,'N',NULL,NULL,NULL,NULL),
 (842,146,4,'Desenvolveu soluções considerando a realidade/contexto da empresa?',NULL,0,'S',2,NULL,NULL,'N',NULL,NULL,NULL,NULL),
 (843,146,5,'Orientou a aplicação das soluções propostas?',NULL,0,'S',2,NULL,NULL,'N',NULL,NULL,NULL,NULL),
 (970,159,1,'O que você pensa em fazer com o seu negócio em alguns anos?',NULL,1,'S',2,NULL,NULL,'N',NULL,NULL,NULL,NULL),
 (1289,193,1,'O que você pensa em fazer com o seu negócio em alguns anos?',NULL,1,'S',2,NULL,NULL,'N',NULL,7,0,'GE'),
 (1290,194,1,'Você controla as entradas e saídas diárias de dinheiro?',NULL,30,'S',2,NULL,2,'S',NULL,2,1,'E'),
 (1291,194,2,'Você possui um controle de entradas, saídas e saldo de dinheiro para os meses futuros?',NULL,0,'S',2,NULL,8,'N',NULL,2,1,'E'),
 (1292,194,3,'Você sabe quanto dinheiro deve ter em caixa para cobrir suas despesas enquanto não recebe os pagamentos?',NULL,0,'S',2,NULL,12,'N',NULL,2,2,'E'),
 (1293,194,4,'Você controla as datas e valores de todos os tributos a serem pagos? (Impostos e também Taxas)',NULL,0,'S',2,NULL,7,'N',NULL,2,3,'E'),
 (1294,194,5,'Você calcula os gastos (custos e despesas) mensalmente?',NULL,0,'S',2,NULL,10,'S',NULL,2,4,'E'),
 (1295,194,6,'Você calcula o resultado (lucro ou prejuízo) do seu negócio periodicamente?',NULL,0,'S',2,NULL,10,'S',NULL,2,5,'E'),
 (1296,194,7,'Você sabe qual é o seu ganho de dinheiro em cada produto ou serviço vendido?',NULL,0,'S',2,NULL,9,'S',NULL,2,6,'E'),
 (1297,194,8,'Você tem um controle do estoque dos produtos e insumos? (incluindo datas de validade, quantidade, etc.)',NULL,0,'S',2,NULL,11,'S',NULL,2,7,'E'),
 (1298,195,1,'Sua empresa tem um cadastro com informações de seus clientes em algum lugar?',NULL,20,'S',2,NULL,13,'S',NULL,2,1,'E'),
 (1299,195,2,'A empresa sabe quais são os diferentes grupos de clientes que frequentam seu estabelecimento e faz ações direcionadas a cada um destes grupos?',NULL,0,'S',2,NULL,16,'S',NULL,2,1,'E'),
 (1300,195,3,'Você analisa regularmente as necessidades dos clientes para orientar suas ações de marketing e definição de serviços e produtos?',NULL,0,'S',2,NULL,15,'S',NULL,2,1,'E'),
 (1301,195,4,'Você faz alguma pesquisa para saber a satisfação dos clientes?',NULL,0,'S',2,NULL,14,'S',NULL,2,2,'E'),
 (1302,195,5,'Você planeja ações para promover e divulgar seus produtos e serviços?',NULL,0,'S',2,NULL,19,'S',NULL,2,3,'E'),
 (1303,195,6,'Sua empresa oferta novos produtos/serviços para seus clientes? (Observar critérios para escolha dos produtos e teste dos produtos novos)',NULL,0,'S',2,NULL,17,'S',NULL,2,4,'E'),
 (1304,195,7,'Você avalia seus concorrentes para saber o que deve melhorar?',NULL,0,'S',2,NULL,18,'S',NULL,2,5,'E'),
 (1305,196,1,'Você planeja os objetivos que deseja alcançar, tendo alguma forma de registro de onde quer chegar?',NULL,50,'S',2,NULL,20,'S',NULL,2,1,'E'),
 (1306,196,2,'Você tem seus objetivos e metas escritos e bem definidos?',NULL,0,'S',2,NULL,21,'S',NULL,2,1,'E'),
 (1307,196,3,'Você toma nota das decisões e resultados de seu planejamento, observando situações em que houve resultados diferentes dos que você queria, para aprimorar o que deu certo e não repetir erros do passado?',NULL,0,'S',2,NULL,23,'S',NULL,2,1,'E'),
 (1308,196,4,'Existem ações com prazos definidos para que os objetivos planejados pela empresa para o futuro possam ser alcançados?',NULL,0,'S',2,NULL,22,'S',NULL,2,2,'E'),
 (1309,197,1,'Você possui um controle de quem são os fornecedores de seus produtos e prestadores de serviço, facilitando sua pesquisa de preços?',NULL,NULL,'S',2,NULL,26,'S',NULL,2,1,'E'),
 (1310,197,2,'Os documentos importantes de sua empresas e contas estão bem organizados?',NULL,NULL,'S',2,NULL,25,'S',NULL,2,2,'E'),
 (1311,197,3,'As atividades realizadas regularmente possuem um procedimento escrito de como elas devem ser feitas?',NULL,NULL,'S',2,NULL,27,'S',NULL,2,3,'E'),
 (1312,197,4,'A organização da sua empresa permite que você trabalhe de maneira eficiente e ágil?',NULL,NULL,'S',2,NULL,24,'S',NULL,2,4,'E'),
 (1313,197,5,'Sua empresa possui um layout (arranjo físico) definido para facilitar a entrega do produto/serviço, comercialização e atendimento aos clientes?',NULL,NULL,'S',2,NULL,NULL,'S',NULL,2,4,'E'),
 (1314,198,1,'Você sabe quais são as obrigações trabalhistas de sua empresa, da contratação até o desligamento? E em relação a você, sabe o que fazer para se aposentar com tranquilidade?',NULL,NULL,'S',2,NULL,29,'S',NULL,2,1,'E'),
 (1315,198,2,'Você já definiu que conhecimentos e características as pessoas devem ter para realizar as atividades em sua empresa, incluindo você e sócios?',NULL,NULL,'S',2,NULL,33,'S',NULL,2,2,'E'),
 (1316,198,3,'Se você, seu sócio ou algum funcionário faltar ou tirar férias, está definido um responsável para ficar no lugar desta pessoa?',NULL,NULL,'S',2,NULL,30,'S',NULL,2,2,'E'),
 (1317,198,4,'Você faz uma avaliação dos problemas recorrentes ou potenciais em seu negócio, visando evitar que os mesmos ocorram?',NULL,NULL,'S',2,NULL,32,'S',NULL,2,2,'E'),
 (1318,198,5,'Se for necessário delegar alguma atividade (por motivo de doença, expansão, etc.), você já sabe quais são as atividades que pode delegar?',NULL,NULL,'S',2,NULL,31,'S',NULL,2,2,'E'),
 (1319,199,1,'A organização do espaço de forma geral é clara e a circulação está desobstruída?',NULL,NULL,'S',2,NULL,36,'S',NULL,2,1,'E'),
 (1320,199,2,'A empresa comercializa produtos de forma que a exposição deles favoreça a venda?',NULL,NULL,'S',2,NULL,37,'S',NULL,2,1,'E'),
 (1321,199,3,'A empresa possui marca própria e comunicação visual padronizada? Todas as áreas do estabelecimento onde a circulação é desejada são acessadas pelos clientes? Visualmente, os clientes e funcionários conseguem encontrar a informação que precisam?',NULL,NULL,'S',2,NULL,38,'S',NULL,2,1,'E'),
 (1322,199,4,'Os clientes são pessoas ou organizações que usam ou consomem produtos para atender às determinadas necessidades. Os métodos de inovação centrados no cliente divergem das abordagens tradicionais, caracterizadas pela busca da inovação por meio de avanços tecnológicos ou da otimização dos processos comerciais. Inovar nesta dimensão significa, por exemplo, encontrar um novo nicho de mercado para determinado produto ou serviço. A empresa adota alguma prática de relacionamento ou pesquisa sistemática para identificar as necessidades do mercado ou dos clientes?',NULL,NULL,'S',2,NULL,39,'S',NULL,2,2,'E'),
 (1323,199,5,'Os processos são as configurações das atividades usadas na condução das operações internas à empresa. A inovação, nesta dimensão, pressupõe o reprojeto de seus processos para buscar maior eficiência, maior qualidade ou um tempo de resposta (tempo de ciclo) menor. A empresa alterou seus processos para obter maior eficiência, qualidade, flexibilidade ou menor ciclo de produção?',NULL,NULL,'S',2,NULL,40,'S',NULL,2,3,'E'),
 (1324,194,1,'Como você se sente quanto ao Controle do Fluxo de Caixa da sua empresa?',NULL,0,'S',2,NULL,8,'S',NULL,4,1,'Q'),
 (1325,194,2,'Como você se sente quanto ao Dimensionamento do Capital de Giro na sua empresa?',NULL,10,'S',2,NULL,2,'S',NULL,4,2,'Q'),
 (1326,194,3,'Como você se sente quanto à gestão dos Pagamentos de Impostos da sua empresa?',NULL,10,'S',2,NULL,2,'S',NULL,4,3,'Q'),
 (1327,194,4,'Como você se sente quanto Identificação e Cálculos dos Custos da empresa?',NULL,0,'S',2,NULL,12,'N',NULL,4,4,'Q'),
 (1328,194,5,'Como você se sente quanto ao controle Periódico do Lucro da empresa?',NULL,0,'S',2,NULL,8,'N',NULL,4,5,'Q'),
 (1329,194,6,'Como você se sente quanto a Análise do Preço de Venda dos produtos da empresa?',NULL,0,'S',2,NULL,8,'N',NULL,4,6,'Q'),
 (1330,194,7,'Como você se sente quanto à Gestão de Estoques da sua empresa?',NULL,0,'S',2,NULL,11,'N',NULL,4,7,'Q'),
 (1331,195,1,'Como você se sente quanto ao seu conhecimento das Características dos seus Clientes?',NULL,NULL,'S',2,NULL,2,'S',NULL,4,1,'Q'),
 (1332,195,2,'Como você se sente quanto ao seu conhecimento da Satisfação dos seus Clientes?',NULL,NULL,'S',2,NULL,2,'S',NULL,4,2,'Q'),
 (1333,195,3,'Como você se sente quanto à Divulgação de seus produtos e/ou serviços?',NULL,NULL,'S',2,NULL,2,'S',NULL,4,3,'Q'),
 (1334,195,4,'Como você se sente quanto à Expansão para novas áreas e lançamento de novos produtos/serviços?',NULL,NULL,'S',2,NULL,2,'S',NULL,4,4,'Q'),
 (1335,195,5,'Como você se sente quanto ao entendimento da Concorrência no seu mercado?',NULL,NULL,'S',2,NULL,2,'S',NULL,4,5,'Q'),
 (1336,196,1,'Como você se sente quanto ao Plano de Negócios da sua empresa?',NULL,NULL,'S',2,NULL,2,'S',NULL,4,1,'Q'),
 (1337,196,2,'Como você se sente quanto à Organização das Ações de Curto e Médio Prazo da sua empresa?',NULL,NULL,'S',2,NULL,2,'S',NULL,4,2,'Q'),
 (1338,197,1,'Como você se sente quanto à Gestão dos Fornecedores da sua empresa?',NULL,NULL,'S',2,NULL,2,'S',NULL,4,1,'Q'),
 (1339,197,2,'Como você se sente quanto à Organização de Documentos da sua empresa?',NULL,NULL,'S',2,NULL,2,'S',NULL,4,2,'Q'),
 (1340,197,3,'Como você se sente quanto à Padronização das Atividades da sua empresa?',NULL,NULL,'S',2,NULL,2,'S',NULL,4,3,'Q'),
 (1341,197,4,'Como você se sente quanto ao Layout da sua empresa?',NULL,NULL,'S',2,NULL,2,'S',NULL,4,4,'Q'),
 (1342,198,1,'Como você se sente quanto à Gestão das Pessoas em termos de legislação e responsabilidade social da sua empresa?',NULL,NULL,'S',2,NULL,2,'S',NULL,4,1,'Q'),
 (1343,198,2,'Como você se sente quanto à Gestão das Pessoas em termos de desenvolvimento de equipe na sua empresa?',NULL,NULL,'S',2,NULL,2,'S',NULL,4,2,'Q'),
 (1344,199,1,'Como você se sente quanto à sistematização organizacional na sua empresa?',NULL,NULL,'S',2,NULL,2,'S',NULL,4,1,'Q'),
 (1345,199,2,'Como você se sente quanto ao serviço e relacionamento com o cliente na sua empresa?',NULL,NULL,'S',2,NULL,2,'S',NULL,4,2,'Q'),
 (1346,199,3,'Como você se sente quanto ao processo de inovação na sua empresa?',NULL,NULL,'S',2,NULL,2,'S',NULL,4,3,'Q'),
 (1347,194,1,'Controle de Resultados na sua empresa, você considera que está:',NULL,12,'S',2,'12',2,'S',NULL,5,99,'A'),
 (1348,195,1,'Compreensão das Necessidades que atende em sua empresa, você considera que está:',NULL,NULL,'S',2,NULL,2,'S',NULL,5,99,'A'),
 (1349,196,1,'Visão de longo prazo na sua empresa, você considera que está:',NULL,NULL,'S',2,NULL,2,'S',NULL,5,99,'A'),
 (1350,197,1,'Na sua empresa, você considera que está:',NULL,NULL,'S',2,NULL,2,'S',NULL,5,99,'A'),
 (1351,198,1,'Na sua empresa, você considera que está:',NULL,NULL,'S',2,NULL,2,'S',NULL,5,99,'A'),
 (1352,199,1,'Compreensão das Necessidades de inovação que atende em sua empresa, você considera que está:',NULL,NULL,'S',2,NULL,2,'S',NULL,5,99,'A');
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
  `idt_classe` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`idt`),
  UNIQUE KEY `iu_grc_formulario_resposta` (`idt_pergunta`,`codigo`),
  KEY `FK_grc_formulario_resposta_2` (`idt_classe`),
  CONSTRAINT `FK_grc_formulario_resposta_1` FOREIGN KEY (`idt_pergunta`) REFERENCES `grc_formulario_pergunta` (`idt`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_grc_formulario_resposta_2` FOREIGN KEY (`idt_classe`) REFERENCES `grc_formulario_classe_resposta` (`idt`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4022 DEFAULT CHARSET=latin1;

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
 (15,1,3,'Sim, possuo um controle formalizado e detalhado das entradas e saídas de dinheiro.',NULL,10,'S','N',2),
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
 (2202,830,1,'Nunca','teste',20,'S','N',2),
 (2205,830,2,'Poucas vezes',NULL,10,'S','N',2),
 (2207,830,3,'Quase sempre',NULL,10,'S','N',2),
 (2209,830,4,'Sempre',NULL,5,'S','N',2),
 (2210,830,5,'Não se aplica',NULL,0,'S','N',2),
 (2211,831,1,'Nunca',NULL,0,'S','N',2),
 (2212,832,1,'Nunca',NULL,0,'S','N',2),
 (2213,833,1,'Nunca',NULL,0,'S','S',2),
 (2214,833,2,'Poucas vezes',NULL,0,'S','N',2),
 (2215,833,3,'Quase sempre',NULL,0,'S','N',2),
 (2216,833,4,'Sempre',NULL,0,'S','N',2),
 (2217,833,5,'Não se aplica',NULL,0,'S','N',2),
 (2218,831,2,'Poucas vezes',NULL,0,'S','N',2),
 (2219,831,3,'Quase sempre',NULL,0,'S','N',2),
 (2220,831,4,'Sempre',NULL,0,'S','N',2),
 (2221,831,5,'Não se aplica',NULL,0,'S','N',2),
 (2222,832,2,'Poucas vezes',NULL,0,'S','N',2),
 (2223,832,3,'Quase sempre',NULL,0,'S','N',2),
 (2224,832,4,'Sempre',NULL,0,'S','N',2),
 (2225,832,5,'Não se aplica',NULL,0,'S','N',2),
 (2226,835,1,'Nunca',NULL,0,'S','N',2),
 (2228,835,2,'Poucas vezes',NULL,100,'S','N',2),
 (2229,835,3,'Quase sempre',NULL,0,'S','N',2),
 (2230,835,4,'Sempre',NULL,0,'S','N',2),
 (2231,835,5,'Não se aplica',NULL,0,'S','N',2),
 (2232,836,1,'Nunca',NULL,0,'S','N',2),
 (2233,836,2,'Poucas vezes',NULL,0,'S','N',2),
 (2234,837,1,'Nunca',NULL,0,'S','N',2),
 (2235,838,0,'Nunca',NULL,0,'S','N',2),
 (2236,839,1,'Nunca',NULL,100,'S','N',2),
 (2237,840,1,'Nunca',NULL,0,'S','N',2),
 (2238,841,1,'Nunca',NULL,0,'S','N',2),
 (2239,842,1,'Nunca',NULL,0,'S','N',2),
 (2240,843,1,'Nunca',NULL,0,'S','N',2),
 (2241,843,2,'Poucas vezes',NULL,0,'S','N',2),
 (2242,843,3,'Quase sempre',NULL,0,'S','N',2),
 (2243,843,4,'Sempre',NULL,0,'S','N',2),
 (2244,843,5,'Não se aplica',NULL,0,'S','N',2),
 (2245,839,2,'Poucas vezes',NULL,0,'S','N',2),
 (2246,839,3,'Quase sempre',NULL,0,'S','N',2),
 (2247,839,4,'Sempre',NULL,0,'S','N',2),
 (2248,839,5,'Não se aplica',NULL,0,'S','N',2),
 (2249,840,2,'Poucas vezes',NULL,0,'S','N',2),
 (2250,840,3,'Quase sempre',NULL,0,'S','N',2),
 (2251,840,4,'Sempre',NULL,0,'S','N',2),
 (2252,840,5,'Não se aplica',NULL,0,'S','N',2),
 (2253,841,2,'Poucas vezes',NULL,0,'S','N',2),
 (2254,841,3,'Quase sempre',NULL,0,'S','N',2),
 (2255,841,4,'Sempre',NULL,0,'S','N',2),
 (2256,841,5,'Não se aplica',NULL,0,'S','N',2),
 (2693,970,1,'Pretendo fechar/passar o ponto e me aposentar',NULL,1,'S','N',2),
 (2695,970,2,'Pretendo fechar/passar o ponto e mudar de ramo.',NULL,1,'S','N',2),
 (2696,970,3,'Pretendo manter o negócio.',NULL,1,'S','N',2),
 (2697,970,4,'Pretendo manter ou até melhorar o negócio.',NULL,1,'S','N',2),
 (3800,1289,1,'Pretendo fechar/passar o ponto e me aposentar',NULL,1,'S','N',2),
 (3801,1289,2,'Pretendo fechar/passar o ponto e mudar de ramo.',NULL,1,'S','N',2),
 (3802,1289,3,'Pretendo manter o negócio.',NULL,1,'S','N',2),
 (3803,1289,4,'Pretendo manter ou até melhorar o negócio.',NULL,1,'S','N',2),
 (3804,1290,1,'Não, apenas vejo quanto tenho de dinheiro no final do dia.',NULL,10,'S','N',2),
 (3805,1290,2,'Tenho um controle informal das entradas e saídas de dinheiro.',NULL,10,'S','N',2),
 (3806,1290,3,'Sim, possuo um controle formalizado e detalhado das entradas e saídas de dinheiro.',NULL,10,'S','N',2),
 (3807,1291,1,'Não tenho este controle.',NULL,0,'S','N',2),
 (3808,1291,2,'Tenho um controle não formalizado e/ou que não prevê como estará o saldo no futuro.',NULL,0,'S','N',2),
 (3809,1291,3,'Sim, possuo planilhas para controlar o Fluxo de Caixa e visualizo ao longo do tempo quando terei falta ou sobra de dinheiro.',NULL,0,'S','N',2),
 (3810,1292,1,'Não faço este cálculo regularmente.',NULL,0,'S','N',2),
 (3811,1292,2,'Tenho noção de quais são minhas despesas, mas não sei quanto dinheiro preciso ter em caixa.',NULL,0,'S','N',2),
 (3812,1292,3,'Sim, calculo qual o valor que a empresa precisa ter em caixa para que não precise pedir dinheiro emprestado.',NULL,0,'S','N',2),
 (3813,1293,1,'Não, não tenho controle sobre o pagamento de tributos.',NULL,0,'S','N',2),
 (3814,1293,2,'Sei quando devem ser pagos alguns tributos, mas não tenho controle sobre quando cada um deve ser pago.',NULL,0,'S','N',2),
 (3815,1293,3,'Sim, possuo controle formal e registro de quando cada tributo deve ser pago, assim como registro os pagamentos.',NULL,0,'S','N',2),
 (3816,1294,1,'Não, não sei quais são os custos da empresa.',NULL,0,'S','N',2),
 (3817,1294,2,'Tenho noção de qual é o valor dos custos e despesas mensais da empresa, mas não tenho um controle preciso.',NULL,0,'S','N',2),
 (3818,1294,3,'Sim, registro qual o valor dos custos e despesas mensalmente, sabendo quanto foi o desembolso no período.',NULL,0,'S','N',2),
 (3819,1295,1,'Não, não sei qual foi o resultado da empresa no período.',NULL,0,'S','N',2),
 (3820,1295,2,'Tenho uma noção de qual é o resultado da empresa em determinado tempo.',NULL,0,'S','N',2),
 (3821,1295,3,'Sim, calculo o resultado da minha empresa relacionando os meus custos e despesas com a receita (faturamento).',NULL,0,'S','N',2),
 (3822,1296,1,'Não, não sei qual é o meu ganho naquilo que vendo.',NULL,0,'S','N',2),
 (3823,1296,2,'Tenho um conhecimento aproximado sobre o ganho que cada produto / serviço traz.',NULL,0,'S','N',2),
 (3824,1296,3,'Sim, calculo periodicamente o ganho de cada produto / serviço.',NULL,0,'S','N',2),
 (3825,1297,1,'Não, não tenho este controle.',NULL,0,'S','N',2),
 (3826,1297,2,'Sei de cabeça, mas não tenho um controle formal.',NULL,0,'S','N',2),
 (3827,1297,3,'Sim, registro quanto tenho em estoque e faço seu controle periodicamente.',NULL,0,'S','N',2),
 (3828,1298,1,'Não, não tenho um cadastro de clientes.',NULL,10,'S','N',2),
 (3829,1298,2,'Tenho um cadastro de clientes, mas não faço uso dele.',NULL,10,'S','N',2),
 (3830,1298,3,'Sim, possuo cadastro de clientes que me auxilia na comunicação com os fregueses.',NULL,0,'S','N',2),
 (3831,1299,1,'Não sei quais são os grupos de clientes que frequentam meu estabelecimento.',NULL,0,'S','N',2),
 (3832,1299,2,'Conheço alguns grupos, mas não faço ações direcionadas.',NULL,0,'S','N',2),
 (3833,1299,3,'Conheço os grupos que frequentam, e faço ações direcionadas a cada um deles.',NULL,0,'S','N',2),
 (3834,1300,1,'Não faço esta análise regularmente.',NULL,0,'S','N',2),
 (3835,1300,2,'Eu converso com meus clientes, mas não faço uma análise regularmente ou não uso esta informação sistematicamente.',NULL,0,'S','N',2),
 (3836,1300,3,'Sim, busco periodicamente as necessidades dos meus clientes e uso estas informações para melhorar meus produtos / serviços.',NULL,0,'S','N',2),
 (3837,1301,1,'Não faço pesquisa.',NULL,0,'S','N',2),
 (3838,1301,2,'Faço pesquisa, mas não a utilizo para melhorar a empresa.',NULL,0,'S','N',2),
 (3839,1301,3,'Sim, realizo uma pesquisa de satisfação e utilizo as respostas para melhorar meu negócio.',NULL,0,'S','N',2),
 (3840,1302,1,'Não tenho ações planejadas para promover ou divulgar o produto ou serviço.',NULL,0,'S','N',2),
 (3841,1302,2,'Tenho algumas ações planejadas, mas a maioria vou pensando e fazendo sem um plano.',NULL,0,'S','N',2),
 (3842,1302,3,'Realizo ações promocionais de maneira planejada e controlo os resultados de cada ação.',NULL,0,'S','N',2),
 (3843,1303,1,'Não, oferto sempre os mesmos produtos.',NULL,0,'S','N',2),
 (3844,1303,2,'Oferto novos produtos ocasionalmente, somente quando vejo que meu negócio está parado no tempo.',NULL,0,'S','N',2),
 (3845,1303,3,'Sim, oferto novos produtos/serviços, tenho critérios para o lançamento e os testo por um tempo.',NULL,0,'S','N',2),
 (3846,1304,1,'Não, não analiso meus concorrentes.',NULL,0,'S','N',2),
 (3847,1304,2,'Tenho alguma noção de como meus concorrentes atuam e se diferenciam de mim.',NULL,0,'S','N',2),
 (3848,1304,3,'Sim, sei no que sou pior e melhor do que meus concorrentes e realizo ações para melhorar.',NULL,0,'S','N',2),
 (3849,1305,1,'Não, vou tocando o negócio sem planejar o futuro.',NULL,25,'S','N',2),
 (3850,1305,2,'Planejo na minha cabeça algumas coisas, porém não acho necessário definir como vou alcançar os objetivos.',NULL,25,'S','N',2),
 (3851,1305,3,'Sim, entendo a importância de planejar para ser bem sucedido e defino ações para conseguir chegar onde quero.',NULL,0,'S','N',2),
 (3852,1306,1,'Não tenho objetivos e metas definidas.',NULL,0,'S','N',2),
 (3853,1306,2,'Tenho alguns objetivos, mas não tenho metas específicas.',NULL,0,'S','N',2),
 (3854,1306,3,'Sim, planejo meu negócio e defino objetivos e metas de forma clara e consistente.',NULL,0,'S','N',2),
 (3855,1307,1,'Não faço esta reflexão.',NULL,0,'S','N',2),
 (3856,1307,2,'Até paro para pensar nisto, mas nunca coloquei tudo isso no papel.',NULL,0,'S','N',2),
 (3857,1307,3,'Sim, comparo as decisões que tomei e os resultados que eu esperava com o que realmente fiz e alcancei.',NULL,0,'S','N',2),
 (3858,1308,1,'Não tenho ações com prazos definidos.',NULL,0,'S','N',2),
 (3859,1308,2,'Sei onde quero chegar, mas não sei quais e quando as ações devem ser tomadas para atingir meus objetivos.',NULL,0,'S','N',2),
 (3860,1308,3,'Sim, defino o que e como deve ser feito para a empresa atingir os objetivos planejados previamente.',NULL,0,'S','N',2),
 (3861,1309,1,'Não tenho um controle, sei isso de cabeça.',NULL,NULL,'S','N',2),
 (3862,1309,2,'Tenho informações de meus fornecedores, espalhadas em agendas e não detalhadas.',NULL,NULL,'S','N',2),
 (3863,1309,3,'Sim, possuo uma planilha ou caderno com cadastro de fornecedores, que acesso quando compro algum produto ou serviço.',NULL,NULL,'S','N',2),
 (3864,1310,1,'Não estão bem organizados, demoro muito tempo para encontrar qualquer documento.',NULL,NULL,'S','N',2),
 (3865,1310,2,'Estão até organizados, mas mesmo assim ainda demoro para encontrar.',NULL,NULL,'S','N',2),
 (3866,1310,3,'Organizo meus documentos e isto me permite trabalhar de modo ágil.',NULL,NULL,'S','N',2),
 (3867,1311,1,'Não, não possuo um procedimento padrão formalizado.',NULL,NULL,'S','N',2),
 (3868,1311,2,'Tenho check-list(s) de alguma tarefas, porém não há um responsável definido.',NULL,NULL,'S','N',2),
 (3869,1311,3,'Sim, tenho procedimentos escritos para as principais atividades do meu negócio, com responsáveis definidos.',NULL,NULL,'S','N',2),
 (3870,1312,1,'Não consigo trabalhar de maneira eficiente e ágil.',NULL,NULL,'S','N',2),
 (3871,1312,2,'Consigo trabalhar eficientemente, porém frequentemente a desorganização volta.',NULL,NULL,'S','N',2),
 (3872,1312,3,'Consigo trabalhar de maneira eficiente e ágil sempre.',NULL,NULL,'S','N',2),
 (3873,1313,1,'Não, o layout não é organizado.',NULL,NULL,'S','N',2),
 (3874,1313,2,'Algumas coisas na empresa estão organizadas, porém há móveis/mercadorias/máquinas que estão em locais inadequados.',NULL,NULL,'S','N',2),
 (3875,1313,3,'Sim, possuo um layout definido que facilita o fluxo de pessoas e materiais.',NULL,NULL,'S','N',2),
 (3876,1314,1,'Não conheço as obrigações trabalhistas e não sei o que fazer quanto à minha aposentadoria.',NULL,NULL,'S','N',2),
 (3877,1314,2,'Tenho pouco conhecimento sobre relações trabalhistas e minha aposentadoria, mas ainda tenho dúvidas.',NULL,NULL,'S','N',2),
 (3878,1314,3,'Sim, tenho domínio sobre as obrigações trabalhistas e também sobre a minha aposentadoria.',NULL,NULL,'S','N',2),
 (3879,1315,1,'Nunca defini.',NULL,NULL,'S','N',2),
 (3880,1315,2,'Tenho uma noção dos conhecimentos e características necessários, mas não utilizei isto para contratar as pessoas.',NULL,NULL,'S','N',2),
 (3881,1315,3,'Sim, tenho registrado quais são os conhecimentos e características necessárias para realizar as atividades e uso isto para a contratação das pessoas.',NULL,NULL,'S','N',2),
 (3882,1316,1,'Não, se alguém faltar o negócio não funciona.',NULL,NULL,'S','N',2),
 (3883,1316,2,'Em alguns casos sim, mas se algumas pessoas faltarem a empresa não tem que saiba fazer aquela atividade.',NULL,NULL,'S','N',2),
 (3884,1316,3,'Se alguém faltar, sabemos quem deve assumir a responsabilidade e esta pessoa estará capacitada a isso.',NULL,NULL,'S','N',2),
 (3885,1317,1,'Não faço esta avaliação.',NULL,NULL,'S','N',2),
 (3886,1317,2,'Faço esta avaliação, mas não treino as pessoas com base nisso.',NULL,NULL,'S','N',2),
 (3887,1317,3,'Faço esta avaliação e treino as pessoas para evitar que o problema ocorra ou volte a acontecer.',NULL,NULL,'S','N',2),
 (3888,1318,1,'Não sei quais atividades posso delegar.',NULL,NULL,'S','N',2),
 (3889,1318,2,'Costumo realizar as principais atividades da empresa, e tenho funcionários que podem executá-las e delego-as para eles.',NULL,NULL,'S','N',2),
 (3890,1318,3,'Sim, delego atividades para que meus funcionários realizem sem minha presença, investindo meu tempo no que é mais importante para o negócio.',NULL,NULL,'S','N',2),
 (3891,1319,1,'Não, é difícil identificar onde está uma área específica, os clientes parecem ficar confusos sobre onde encontrar o que procuram e muitos vão embora sem consumir nada ou sem serem atendidos. Existem áreas pouco acessadas pelos clientes, e que poderiam ser melhor aproveitadas.',NULL,NULL,'S','N',2),
 (3892,1319,2,'Em parte, a área de circulação não está obstruída mas a distribuição de produtos ou serviços pode ser revisada. Nota-se alguma dificuldade nos clientes em entender o espaço.',NULL,NULL,'S','N',2),
 (3893,1319,3,'Sim, a forma como o espaço se apresenta é clara e muito bem organizada. Os produtos são facilmente encontrados e nota-se que os clientes percorrem todas as áreas em que a circulação é desejada, não apresentando dificuldade em encontrar o que procuram.',NULL,NULL,'S','N',2),
 (3894,1320,1,'Este item não é aplicável, pois a empresa não comercializa produtos.',NULL,NULL,'S','N',2),
 (3895,1320,2,'Não, os produtos com maior margem de lucro ou de venda por impulso estão posicionados fora da altura compreendida entre 1,20m a 1,80m; produtos destinado ao público infantil estão posicionados fora do alcance de crianças; as promoções não estão visíveis pelo cliente.',NULL,NULL,'S','N',2),
 (3896,1320,3,'Sim, a organização dos produtos está adequada; os produtos com maior margem de lucro, os de venda por impulso ou as promoções estão na altura dos olhos do cliente, compreendida entre 1,20m e 1,80m; os produtos destinados ao público infantil estão ao alcance das crianças.',NULL,NULL,'S','N',2),
 (3897,1321,1,'Não, a empresa não possui uma marca definida e por isso não possui uma comunicação visual padronizada. Além disso, algumas áreas não são facilmente identificadas pelos clientes, que têm dificuldade em se localizar dentro do estabelecimento.',NULL,NULL,'S','N',2),
 (3898,1321,2,'Em parte, a empresa possui uma marca própria e algumas aplicações padronizadas, mas estes materiais não contemplam peças de comunicação visual para o estabelecimento. Sendo assim, visualmente não há uma comunicação clara, causando uma certa dificuldade nos clientes em encontrar o que procuram.',NULL,NULL,'S','N',2),
 (3899,1321,3,'Sim, a empresa possui uma marca própria e comunicação visual padronizada. Não é percebida nenhuma dificuldade para os clientes em encontrar o que procuram.',NULL,NULL,'S','N',2),
 (3900,1322,1,'Não vê importância e necessidade em avaliar a empresa do ponto de vista do cliente;',NULL,NULL,'S','N',2),
 (3901,1322,2,'Não faz esta avaliação periodicamente, mas de vez em quando pensa a respeito;',NULL,NULL,'S','N',2),
 (3902,1322,3,'Faz esta avaliação de forma periódica e por escrito, utilizando os resultados para definir ações de melhoria.',NULL,NULL,'S','N',2),
 (3903,1323,1,'Não vê necessidade de padronizar etapas do serviço.',NULL,NULL,'S','N',2),
 (3904,1323,2,'Comunica verbalmente aos funcionários como as atividades devem ser feitas.',NULL,NULL,'S','N',2),
 (3905,1323,3,'Possui alguns procedimentos formalizados, mas percebe a necessidade de melhorá-los e/ou criar novos.',NULL,NULL,'S','N',2),
 (3906,1324,1,'Melhorar com urgência, Nada Satisfeito.',NULL,0,'S','N',2),
 (3907,1324,2,'Preciso Melhorar, Pouco Satisfeito.',NULL,0,'S','N',2),
 (3908,1324,3,'Posso Aprimorar, Bastante Satisfeito.',NULL,0,'S','N',2),
 (3909,1324,4,'Manter, Totalmente Satisfeito.',NULL,0,'S','N',2),
 (3910,1325,1,'Melhorar com urgência, Nada Satisfeito.',NULL,4,'S','N',2),
 (3911,1325,2,'Preciso Melhorar, Pouco Satisfeito.',NULL,3,'S','N',2),
 (3912,1325,3,'Posso Aprimorar, Bastante Satisfeito.',NULL,3,'S','N',2),
 (3913,1325,4,'Manter, Totalmente Satisfeito.',NULL,0,'S','N',2),
 (3914,1326,1,'Melhorar com urgência, Nada Satisfeito.',NULL,5,'S','N',2),
 (3915,1326,2,'Preciso Melhorar, Pouco Satisfeito.',NULL,3,'S','N',2),
 (3916,1326,3,'Posso Aprimorar, Bastante Satisfeito.',NULL,2,'S','N',2),
 (3917,1326,4,'Manter, Totalmente Satisfeito.',NULL,0,'S','N',2),
 (3918,1327,1,'Melhorar com urgência, Nada Satisfeito.',NULL,0,'S','N',2),
 (3919,1327,2,'Preciso Melhorar, Pouco Satisfeito.',NULL,0,'S','N',2),
 (3920,1327,3,'Posso Aprimorar, Bastante Satisfeito.',NULL,0,'S','N',2),
 (3921,1327,4,'Manter, Totalmente Satisfeito.',NULL,0,'S','N',2),
 (3922,1328,1,'Melhorar com urgência, Nada Satisfeito.',NULL,0,'S','N',2),
 (3923,1328,2,'Preciso Melhorar, Pouco Satisfeito.',NULL,0,'S','N',2),
 (3924,1328,3,'Posso Aprimorar, Bastante Satisfeito.',NULL,0,'S','N',2),
 (3925,1328,4,'Manter, Totalmente Satisfeito.',NULL,0,'S','N',2),
 (3926,1329,1,'Melhorar com urgência, Nada Satisfeito.',NULL,0,'S','N',2),
 (3927,1329,2,'Preciso Melhorar, Pouco Satisfeito.',NULL,0,'S','N',2),
 (3928,1329,3,'Posso Aprimorar, Bastante Satisfeito.',NULL,0,'S','N',2),
 (3929,1329,4,'Manter, Totalmente Satisfeito.',NULL,0,'S','N',2),
 (3930,1330,1,'Melhorar com urgência, Nada Satisfeito.',NULL,0,'S','N',2),
 (3931,1330,2,'Preciso Melhorar, Pouco Satisfeito.',NULL,0,'S','N',2),
 (3932,1330,3,'Posso Aprimorar, Bastante Satisfeito.',NULL,0,'S','N',2),
 (3933,1330,4,'Manter, Totalmente Satisfeito.',NULL,0,'S','N',2),
 (3934,1331,1,'Melhorar com urgência, Nada Satisfeito.',NULL,NULL,'S','N',2),
 (3935,1331,2,'Preciso Melhorar, Pouco Satisfeito.',NULL,NULL,'S','N',2),
 (3936,1331,3,'Posso Aprimorar, Bastante Satisfeito.',NULL,NULL,'S','N',2),
 (3937,1331,4,'Manter, Totalmente Satisfeito.',NULL,NULL,'S','N',2),
 (3938,1332,1,'Melhorar com urgência, Nada Satisfeito.',NULL,NULL,'S','N',2),
 (3939,1332,2,'Preciso Melhorar, Pouco Satisfeito.',NULL,NULL,'S','N',2),
 (3940,1332,3,'Posso Aprimorar, Bastante Satisfeito.',NULL,NULL,'S','N',2),
 (3941,1332,4,'Manter, Totalmente Satisfeito.',NULL,NULL,'S','N',2),
 (3942,1333,1,'Melhorar com urgência, Nada Satisfeito.',NULL,NULL,'S','N',2),
 (3943,1333,2,'Preciso Melhorar, Pouco Satisfeito.',NULL,NULL,'S','N',2),
 (3944,1333,3,'Posso Aprimorar, Bastante Satisfeito.',NULL,NULL,'S','N',2),
 (3945,1333,4,'Manter, Totalmente Satisfeito.',NULL,NULL,'S','N',2),
 (3946,1334,1,'Melhorar com urgência, Nada Satisfeito.',NULL,NULL,'S','N',2),
 (3947,1334,2,'Preciso Melhorar, Pouco Satisfeito',NULL,NULL,'S','N',2),
 (3948,1334,3,'Posso Aprimorar, Bastante Satisfeito.',NULL,NULL,'S','N',2),
 (3949,1334,4,'Manter, Totalmente Satisfeito.',NULL,NULL,'S','N',2),
 (3950,1335,1,'Melhorar com urgência, Nada Satisfeito.',NULL,NULL,'S','N',2),
 (3951,1335,2,'Preciso Melhorar, Pouco Satisfeito.',NULL,NULL,'S','N',2),
 (3952,1335,3,'Posso Aprimorar, Bastante Satisfeito.',NULL,NULL,'S','N',2),
 (3953,1335,4,'Manter, Totalmente Satisfeito.',NULL,NULL,'S','N',2),
 (3954,1336,1,'Melhorar com urgência, Nada Satisfeito.',NULL,NULL,'S','N',2),
 (3955,1336,2,'Preciso Melhorar, Pouco Satisfeito.',NULL,NULL,'S','N',2),
 (3956,1336,3,'Posso Aprimorar, Bastante Satisfeito.',NULL,NULL,'S','N',2),
 (3957,1336,4,'Manter, Totalmente Satisfeito.',NULL,NULL,'S','N',2),
 (3958,1337,1,'Melhorar com urgência, Nada Satisfeito.',NULL,NULL,'S','N',2),
 (3959,1337,2,'Preciso Melhorar, Pouco Satisfeito.',NULL,NULL,'S','N',2),
 (3960,1337,3,'Posso Aprimorar, Bastante Satisfeito.',NULL,NULL,'S','N',2),
 (3961,1337,4,'Manter, Totalmente Satisfeito.',NULL,NULL,'S','N',2),
 (3962,1338,1,'Melhorar com urgência, Nada Satisfeito.',NULL,NULL,'S','N',2),
 (3963,1338,2,'Preciso Melhorar, Pouco Satisfeito.',NULL,NULL,'S','N',2),
 (3964,1338,3,'Posso Aprimorar, Bastante Satisfeito.',NULL,NULL,'S','N',2),
 (3965,1338,4,'Manter, Totalmente Satisfeito.',NULL,NULL,'S','N',2),
 (3966,1339,1,'Melhorar com urgência, Nada Satisfeito.',NULL,NULL,'S','N',2),
 (3967,1339,2,'Preciso Melhorar, Pouco Satisfeito.',NULL,NULL,'S','N',2),
 (3968,1339,3,'Posso Aprimorar, Bastante Satisfeito.',NULL,NULL,'S','N',2),
 (3969,1339,4,'Manter, Totalmente Satisfeito.',NULL,NULL,'S','N',2),
 (3970,1340,1,'Melhorar com urgência, Nada Satisfeito.',NULL,NULL,'S','N',2),
 (3971,1340,2,'Preciso Melhorar, Pouco Satisfeito.',NULL,NULL,'S','N',2),
 (3972,1340,3,'Posso Aprimorar, Bastante Satisfeito.',NULL,NULL,'S','N',2),
 (3973,1340,4,'Manter, Totalmente Satisfeito.',NULL,NULL,'S','N',2),
 (3974,1341,1,'Melhorar com urgência, Nada Satisfeito.',NULL,NULL,'S','N',2),
 (3975,1341,2,'Preciso Melhorar, Pouco Satisfeito.',NULL,NULL,'S','N',2),
 (3976,1341,3,'Posso Aprimorar, Bastante Satisfeito.',NULL,NULL,'S','N',2),
 (3977,1341,4,'Manter, Totalmente Satisfeito.',NULL,NULL,'S','N',2),
 (3978,1342,1,'Melhorar com urgência, Nada Satisfeito.',NULL,NULL,'S','N',2),
 (3979,1342,2,'Preciso Melhorar, Pouco Satisfeito.',NULL,NULL,'S','N',2),
 (3980,1342,3,'Posso Aprimorar, Bastante Satisfeito.',NULL,NULL,'S','N',2),
 (3981,1342,4,'Manter, Totalmente Satisfeito.',NULL,NULL,'S','N',2),
 (3982,1343,1,'Melhorar com urgência, Nada Satisfeito.',NULL,NULL,'S','N',2),
 (3983,1343,2,'Preciso Melhorar, Pouco Satisfeito.',NULL,NULL,'S','N',2),
 (3984,1343,3,'Posso Aprimorar, Bastante Satisfeito.',NULL,NULL,'S','N',2),
 (3985,1343,4,'Manter, Totalmente Satisfeito.',NULL,NULL,'S','N',2),
 (3986,1344,1,'Melhorar com urgência, Nada Satisfeito.',NULL,NULL,'S','N',2),
 (3987,1344,2,'Preciso Melhorar, Pouco Satisfeito.',NULL,NULL,'S','N',2),
 (3988,1344,3,'Posso Aprimorar, Bastante Satisfeito.',NULL,NULL,'S','N',2),
 (3989,1344,4,'Manter, Totalmente Satisfeito.',NULL,NULL,'S','N',2),
 (3990,1345,1,'Melhorar com urgência, Nada Satisfeito.',NULL,NULL,'S','N',2),
 (3991,1345,2,'Preciso Melhorar, Pouco Satisfeito.',NULL,NULL,'S','N',2),
 (3992,1345,3,'Posso Aprimorar, Bastante Satisfeito.',NULL,NULL,'S','N',2),
 (3993,1345,4,'Manter, Totalmente Satisfeito.',NULL,NULL,'S','N',2),
 (3994,1346,1,'Melhorar com urgência, Nada Satisfeito.',NULL,NULL,'S','N',2),
 (3995,1346,2,'Preciso Melhorar, Pouco Satisfeito.',NULL,NULL,'S','N',2),
 (3996,1346,3,'Posso Aprimorar, Bastante Satisfeito.',NULL,NULL,'S','N',2),
 (3997,1346,4,'Manter, Totalmente Satisfeito.',NULL,NULL,'S','N',2),
 (3998,1347,1,'Melhorar com urgência, Nada Satisfeito.',NULL,1,'S','N',2),
 (3999,1347,2,'Preciso Melhorar, Pouco Satisfeito.',NULL,NULL,'S','N',2),
 (4000,1347,3,'Posso Aprimorar, Bastante Satisfeito.',NULL,NULL,'S','N',2),
 (4001,1347,4,'Manter, Totalmente Satisfeito.',NULL,NULL,'S','N',2),
 (4002,1348,1,'Melhorar com urgência, Nada Satisfeito.',NULL,NULL,'S','N',2),
 (4003,1348,2,'Preciso Melhorar, Pouco Satisfeito.',NULL,NULL,'S','N',2),
 (4004,1348,3,'Posso Aprimorar, Bastante Satisfeito.',NULL,NULL,'S','N',2),
 (4005,1348,4,'Manter, Totalmente Satisfeito.',NULL,NULL,'S','N',2),
 (4006,1349,1,'Melhorar com urgência, Nada Satisfeito.',NULL,NULL,'S','N',2),
 (4007,1349,2,'Preciso Melhorar, Pouco Satisfeito.',NULL,NULL,'S','N',2),
 (4008,1349,3,'Posso Aprimorar, Bastante Satisfeito.',NULL,NULL,'S','N',2),
 (4009,1349,4,'Manter, Totalmente Satisfeito.',NULL,NULL,'S','N',2),
 (4010,1350,1,'Melhorar com urgência, Nada Satisfeito.',NULL,NULL,'S','N',2),
 (4011,1350,2,'Preciso Melhorar, Pouco Satisfeito.',NULL,NULL,'S','N',2),
 (4012,1350,3,'Posso Aprimorar, Bastante Satisfeito.',NULL,NULL,'S','N',2),
 (4013,1350,4,'Manter, Totalmente Satisfeito.',NULL,NULL,'S','N',2),
 (4014,1351,1,'Melhorar com urgência, Nada Satisfeito.',NULL,NULL,'S','N',2),
 (4015,1351,2,'Preciso Melhorar, Pouco Satisfeito.',NULL,NULL,'S','N',2),
 (4016,1351,3,'Posso Aprimorar, Bastante Satisfeito.',NULL,NULL,'S','N',2),
 (4017,1351,4,'Manter, Totalmente Satisfeito.',NULL,NULL,'S','N',2),
 (4018,1352,1,'Melhorar com urgência, Nada Satisfeito.',NULL,NULL,'S','N',2),
 (4019,1352,2,'Preciso Melhorar, Pouco Satisfeito.',NULL,NULL,'S','N',2),
 (4020,1352,3,'Posso Aprimorar, Bastante Satisfeito.',NULL,NULL,'S','N',2),
 (4021,1352,4,'Manter, Totalmente Satisfeito.',NULL,NULL,'S','N',2);
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
  `idt_formulario_area` int(10) unsigned DEFAULT NULL,
  `idt_formulario_relevancia` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`idt`),
  UNIQUE KEY `iu_grc_formulario_secao` (`idt_formulario`,`codigo`),
  KEY `FK_grc_formulario_secao_2` (`idt_formulario_area`),
  KEY `FK_grc_formulario_secao_3` (`idt_formulario_relevancia`),
  CONSTRAINT `FK_grc_formulario_secao_2` FOREIGN KEY (`idt_formulario_area`) REFERENCES `grc_formulario_area` (`idt`) ON UPDATE CASCADE,
  CONSTRAINT `FK_grc_formulario_secao_3` FOREIGN KEY (`idt_formulario_relevancia`) REFERENCES `grc_formulario_relevancia` (`idt`) ON UPDATE CASCADE,
  CONSTRAINT `fk_grc_formulario_secao` FOREIGN KEY (`idt_formulario`) REFERENCES `grc_formulario` (`idt`)
) ENGINE=InnoDB AUTO_INCREMENT=200 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `grc_formulario_secao`
--

/*!40000 ALTER TABLE `grc_formulario_secao` DISABLE KEYS */;
INSERT INTO `grc_formulario_secao` (`idt`,`idt_formulario`,`codigo`,`descricao`,`detalhe`,`qtd_pontos`,`valido`,`idt_formulario_area`,`idt_formulario_relevancia`) VALUES 
 (1,1,'SE0000001','FINANÇAS',NULL,30,'S',2,5),
 (4,1,'SE0000002','MERCADO',NULL,20,'S',3,5),
 (7,1,'SE0000003','PLANEJAMENTO',NULL,50,'S',4,5),
 (8,2,'01','Finanças',NULL,20,'S',2,2),
 (10,3,'SE0000007','FINANÇAS',NULL,23,'S',2,5),
 (11,1,'SE0000008','ORGANIZAÇÃO',NULL,1,'S',5,5),
 (12,1,'SE0000010','PESSOAS',NULL,1,'S',6,5),
 (13,1,'SE0000012','INOVAÇÃO',NULL,1,'S',7,5),
 (14,3,'SE0000013','MERCADO',NULL,1,'S',3,5),
 (15,3,'SE0000014','PLANEJAMENTO',NULL,1,'S',4,5),
 (16,3,'SE0000015','ORGANIZAÇÃO',NULL,1,'S',5,5),
 (17,3,'SE0000016','PESSOAS',NULL,1,'S',6,5),
 (18,3,'SE0000017','INOVAÇÃO',NULL,1,'S',7,5),
 (19,2,'SE0000018','MERCADO',NULL,1,'S',3,5),
 (20,2,'SE0000020','PLANEJAMENTO',NULL,1,'S',4,5),
 (21,2,'SE0000021','ORGANIZAÇÃO',NULL,1,'S',5,5),
 (22,2,'SE0000022','PESSOAS',NULL,1,'S',6,5),
 (23,2,'SE0000023','INOVAÇÃO',NULL,1,'S',7,2),
 (113,5,'SE0000026','PERSPECTIVA EMPRESARIAL',NULL,100,'S',10,2),
 (145,6,'SE0000038','PERSPECTIVA EMPRESARIAL',NULL,100,'S',10,2),
 (146,7,'SE0000039','PERSPECTIVA EMPRESARIAL',NULL,100,'S',10,2),
 (159,8,'SE0000000','PERSPECTIVA EMPRESARIAL',NULL,1,'S',10,2),
 (193,4,'SE0000000','PERSPECTIVA EMPRESARIAL',NULL,1,'S',10,2),
 (194,4,'SE0000001','FINANÇAS',NULL,30,'S',2,5),
 (195,4,'SE0000002','MERCADO',NULL,20,'S',3,5),
 (196,4,'SE0000003','PLANEJAMENTO',NULL,50,'S',4,5),
 (197,4,'SE0000008','ORGANIZAÇÃO',NULL,1,'S',5,5),
 (198,4,'SE0000010','PESSOAS',NULL,1,'S',6,5),
 (199,4,'SE0000012','INOVAÇÃO',NULL,1,'S',7,5);
/*!40000 ALTER TABLE `grc_formulario_secao` ENABLE KEYS */;




/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
