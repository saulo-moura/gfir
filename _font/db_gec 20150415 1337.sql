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
-- Create schema db_gec
--

CREATE DATABASE IF NOT EXISTS db_gec;
USE db_gec;

--
-- Definition of table `ajuda`
--

DROP TABLE IF EXISTS `ajuda`;
CREATE TABLE `ajuda` (
  `idt` int(11) NOT NULL AUTO_INCREMENT COMMENT 'IdentificaÃ§Ã£o Ãºnica, sequencial de uma Ajuda.',
  `codigo` varchar(60) NOT NULL COMMENT 'CÃ³digo do registro de Ajuda',
  `descricao` varchar(200) NOT NULL COMMENT 'DescriÃ§Ã£o da Ajuda.',
  `texto` longtext COMMENT 'DescriÃ§Ã£o detalhada da Ajuda.',
  PRIMARY KEY (`idt`),
  UNIQUE KEY `unpk_ajuda_2` (`codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 COMMENT='Ajuda do Sistema (Help)';

--
-- Dumping data for table `ajuda`
--

/*!40000 ALTER TABLE `ajuda` DISABLE KEYS */;
INSERT INTO `ajuda` (`idt`,`codigo`,`descricao`,`texto`) VALUES 
 (1,'sistema','Ajuda :: PIR_GC_ADM - Gerenciador de Conteúdo','<p>&nbsp;Escrever aqui o Help.</p>');
/*!40000 ALTER TABLE `ajuda` ENABLE KEYS */;


--
-- Definition of table `ajudalogin`
--

DROP TABLE IF EXISTS `ajudalogin`;
CREATE TABLE `ajudalogin` (
  `idt` int(11) NOT NULL AUTO_INCREMENT,
  `pergunta` longtext,
  `resposta` longtext,
  `ordem` varchar(3) NOT NULL,
  PRIMARY KEY (`idt`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ajudalogin`
--

/*!40000 ALTER TABLE `ajudalogin` DISABLE KEYS */;
INSERT INTO `ajudalogin` (`idt`,`pergunta`,`resposta`,`ordem`) VALUES 
 (1,'O que é \"Login\"?','Significa a ação de solicitar autenticação no sistema.\r\n<br />\r\nUma autenticação (Login) necessita das informações de um nome de \"Usuário\" e de uma \"Senha\".\r\n<br />\r\nEsse par de informações deve identificar uma e somente uma Entidade, Pessoa física ou não física que tenha permissão de utilização do sistema.\r\n<br />\r\nPara ter permissão é necessário que seja solicitado através do Fale conosco o cadastramento de um Usuário e senha.','001');
/*!40000 ALTER TABLE `ajudalogin` ENABLE KEYS */;


--
-- Definition of table `ajudalogin_adm`
--

DROP TABLE IF EXISTS `ajudalogin_adm`;
CREATE TABLE `ajudalogin_adm` (
  `idt` int(11) NOT NULL AUTO_INCREMENT,
  `pergunta` longtext,
  `resposta` longtext,
  `ordem` varchar(3) NOT NULL,
  PRIMARY KEY (`idt`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ajudalogin_adm`
--

/*!40000 ALTER TABLE `ajudalogin_adm` DISABLE KEYS */;
INSERT INTO `ajudalogin_adm` (`idt`,`pergunta`,`resposta`,`ordem`) VALUES 
 (1,'O que é \"Login\"?','Significa a ação de solicitar autenticação no sistema.\r\n<br />\r\nUma autenticação (Login) necessita das informações de um nome de \"Usuário\" e de uma \"Senha\".\r\n<br />\r\nEsse par de informações deve identificar uma e somente uma Entidade, Pessoa física ou não física que tenha permissão de utilização do sistema.\r\n<br />\r\nPara ter permissão é necessário que seja solicitado através do Fale conosco o cadastramento de um Usuário e senha.','001');
/*!40000 ALTER TABLE `ajudalogin_adm` ENABLE KEYS */;


--
-- Definition of table `autonum`
--

DROP TABLE IF EXISTS `autonum`;
CREATE TABLE `autonum` (
  `codigo` varchar(255) NOT NULL COMMENT 'CÃ³digo de identificaÃ§Ã£o do autonumerador.',
  `idt` int(11) NOT NULL COMMENT 'IdentificaÃ§Ã£o NÃºmerica Ãºnica e sequencial.',
  PRIMARY KEY (`codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Auxiliar para gerara nÃºmeros sequenciais do Sistema';

--
-- Dumping data for table `autonum`
--

/*!40000 ALTER TABLE `autonum` DISABLE KEYS */;
INSERT INTO `autonum` (`codigo`,`idt`) VALUES 
 ('noticia_sistema_ordem',3);
/*!40000 ALTER TABLE `autonum` ENABLE KEYS */;


--
-- Definition of table `cidade`
--

DROP TABLE IF EXISTS `cidade`;
CREATE TABLE `cidade` (
  `idt` int(11) NOT NULL AUTO_INCREMENT,
  `sigla` varchar(5) NOT NULL,
  `descricao` varchar(45) NOT NULL,
  `idt_estado` int(11) NOT NULL,
  PRIMARY KEY (`idt`),
  UNIQUE KEY `iu_cidade` (`idt_estado`,`sigla`),
  CONSTRAINT `cidade_ibfk_1` FOREIGN KEY (`idt_estado`) REFERENCES `estado` (`idt`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cidade`
--

/*!40000 ALTER TABLE `cidade` DISABLE KEYS */;
INSERT INTO `cidade` (`idt`,`sigla`,`descricao`,`idt_estado`) VALUES 
 (1,'SSA','Salvador',5),
 (2,'AJU','Aracaju',26);
/*!40000 ALTER TABLE `cidade` ENABLE KEYS */;


--
-- Definition of table `config`
--

DROP TABLE IF EXISTS `config`;
CREATE TABLE `config` (
  `id_config` int(11) NOT NULL AUTO_INCREMENT COMMENT 'IdentificaÃ§Ã£o Ãºnica, sequencial de uma configuraÃ§Ã£o.',
  `variavel` varchar(30) NOT NULL COMMENT 'VariÃ¡vel de identificaÃ§Ã£o da ConfiguraÃ§Ã£o.',
  `descricao` varchar(100) NOT NULL COMMENT 'DescriÃ§Ã£o da configuraÃ§Ã£o.',
  `valor` longtext COMMENT 'Valor da ConfiguraÃ§Ã£o.',
  `extra` longtext COMMENT 'Valor extra (adicional) da configuraÃ§Ã£o.',
  `js` char(1) NOT NULL COMMENT 'js (explicar)',
  PRIMARY KEY (`id_config`),
  UNIQUE KEY `unpk_config_2` (`variavel`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=latin1 COMMENT='ConfiguraÃ§Ã£o do Sistema';

--
-- Dumping data for table `config`
--

/*!40000 ALTER TABLE `config` DISABLE KEYS */;
INSERT INTO `config` (`id_config`,`variavel`,`descricao`,`valor`,`extra`,`js`) VALUES 
 (1,'timeout','Nº de Segundos para dar o timeout no Gerenciador de Conteúdo','3600000',NULL,'N'),
 (2,'reg_pagina','Quantidade de registros nas tabelas','80',NULL,'N'),
 (3,'num_pagina','Quantidade de números no links da páginação para cada lado','6',NULL,'N'),
 (4,'senha_padrao','Senha padrão para um novo usuário','12345',NULL,'N'),
 (5,'ico_texto','Forma de apresentação da barra de ação do grid',NULL,'IT','N'),
 (6,'email_site','e-Mail utilizado no site','lupe.tecnologia.sebrae@gmail.com',NULL,'N'),
 (7,'host_smtp','Host do servidor de SMTP','smtp.gmail.com',NULL,'N'),
 (8,'port_smtp','Porta do servidor de SMTP','465',NULL,'N'),
 (9,'login_smtp','Login para autenticação no SMTP','lupe.tecnologia.sebrae@gmail.com',NULL,'N'),
 (10,'senha_smtp','Senha para autenticação no SMTP','guybete52',NULL,'N'),
 (11,'url_sebrae_na','URL da url_sebrae_na','http://www.sebrae.com.br/sites/PortalSebrae/',NULL,''),
 (12,'url_sebrae_ba','URL da url_sebrae_ba','http://www.sebrae.com.br/sites/PortalSebrae/ufs/ba?codUf=5',NULL,''),
 (13,'url_oas_imoveis','URL da oas imóveis','http://www.oasimoveis.com.br',NULL,''),
 (14,'url_sebrae','URL Webmail Sebrae','https://webmail.oasempreendimentos.com.br/owa',NULL,''),
 (16,'timeout_site','Nº de Segundos para dar o timeout no Site','3600000',NULL,''),
 (19,'url_site','URL desse Site','http://localhost/sebrae_login_adm/',NULL,''),
 (21,'url_google_analytics','URL Google Analytics','https://www.google.com/accounts/ServiceLogin?service=analytics&passive=true&nui=1',NULL,'N'),
 (22,'LINK_SGC','Link para SGC - Gestão de Contratos','/sgc/','','N');
/*!40000 ALTER TABLE `config` ENABLE KEYS */;


--
-- Definition of table `contato`
--

DROP TABLE IF EXISTS `contato`;
CREATE TABLE `contato` (
  `idt` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificaçã0 única, sequencial de um Contato',
  `descricao` varchar(120) NOT NULL COMMENT 'Descrição do Contato',
  `email` varchar(120) NOT NULL COMMENT 'E-mail do Contato',
  `idt_responsavel` int(11) NOT NULL COMMENT 'IDT do responsável pelo setor',
  PRIMARY KEY (`idt`),
  UNIQUE KEY `ui_contato_descricao` (`descricao`),
  UNIQUE KEY `ui_contato_email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1 COMMENT='Contatos para Fale conosco';

--
-- Dumping data for table `contato`
--

/*!40000 ALTER TABLE `contato` DISABLE KEYS */;
INSERT INTO `contato` (`idt`,`descricao`,`email`,`idt_responsavel`) VALUES 
 (5,'SEBRAE','lupe.tecnologia.sebrae@gmail.com',1);
/*!40000 ALTER TABLE `contato` ENABLE KEYS */;


--
-- Definition of table `direito`
--

DROP TABLE IF EXISTS `direito`;
CREATE TABLE `direito` (
  `id_direito` int(11) NOT NULL AUTO_INCREMENT COMMENT 'IdentificaÃ§Ã£o Ãºnica, sequencial de um Direito.',
  `cod_direito` varchar(5) NOT NULL COMMENT 'CÃ³digo do Direito',
  `nm_direito` varchar(25) NOT NULL COMMENT 'Nome do Direito',
  PRIMARY KEY (`id_direito`),
  UNIQUE KEY `unpk_direito_2` (`nm_direito`),
  UNIQUE KEY `unpk_direito_3` (`cod_direito`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1 COMMENT='Direitos do Sistema';

--
-- Dumping data for table `direito`
--

/*!40000 ALTER TABLE `direito` DISABLE KEYS */;
INSERT INTO `direito` (`id_direito`,`cod_direito`,`nm_direito`) VALUES 
 (1,'alt','Alterar'),
 (2,'con','Consultar'),
 (3,'exc','Excluir'),
 (4,'inc','Incluir'),
 (5,'exe','executar');
/*!40000 ALTER TABLE `direito` ENABLE KEYS */;


--
-- Definition of table `direito_funcao`
--

DROP TABLE IF EXISTS `direito_funcao`;
CREATE TABLE `direito_funcao` (
  `id_difu` int(11) NOT NULL AUTO_INCREMENT COMMENT 'IdentificaÃ§Ã£o Ãºnica, sequencial de um direito_funÃ§Ã£o.',
  `id_direito` int(11) NOT NULL COMMENT 'IdentificaÃ§Ã£o Ãºnica, sequencial de um direito.',
  `id_funcao` int(11) NOT NULL COMMENT 'IdentificaÃ§Ã£o Ãºnica, sequencial de uma funÃ§Ã£o.',
  PRIMARY KEY (`id_difu`),
  UNIQUE KEY `unpk_direito_funcao_2` (`id_direito`,`id_funcao`),
  KEY `direito_funcao.id_direito` (`id_direito`),
  KEY `direito_funcao.id_funcao` (`id_funcao`),
  CONSTRAINT `direito_funcao_ibfk_2` FOREIGN KEY (`id_funcao`) REFERENCES `funcao` (`id_funcao`) ON DELETE CASCADE,
  CONSTRAINT `direito_funcao_ibfk_1` FOREIGN KEY (`id_direito`) REFERENCES `direito` (`id_direito`)
) ENGINE=InnoDB AUTO_INCREMENT=1344 DEFAULT CHARSET=latin1 COMMENT='RelaÃ§Ã£o direito e funcÃ£o do sistema';

--
-- Dumping data for table `direito_funcao`
--

/*!40000 ALTER TABLE `direito_funcao` DISABLE KEYS */;
INSERT INTO `direito_funcao` (`id_difu`,`id_direito`,`id_funcao`) VALUES 
 (11,1,1),
 (15,1,2),
 (3,1,4),
 (7,1,5),
 (19,1,7),
 (23,1,8),
 (27,1,10),
 (42,1,11),
 (30,1,13),
 (34,1,14),
 (38,1,15),
 (126,1,43),
 (130,1,44),
 (134,1,45),
 (253,1,78),
 (673,1,188),
 (677,1,189),
 (681,1,190),
 (685,1,191),
 (689,1,192),
 (749,1,209),
 (1142,1,319),
 (1294,1,366),
 (12,2,1),
 (16,2,2),
 (2,2,3),
 (4,2,4),
 (8,2,5),
 (1,2,6),
 (20,2,7),
 (24,2,8),
 (26,2,9),
 (28,2,10),
 (29,2,12),
 (31,2,13),
 (35,2,14),
 (39,2,15),
 (25,2,16),
 (125,2,42),
 (127,2,43),
 (131,2,44),
 (135,2,45),
 (254,2,78),
 (672,2,188),
 (676,2,189),
 (680,2,190),
 (684,2,191),
 (688,2,192),
 (748,2,209),
 (1141,2,319),
 (1145,2,320),
 (1146,2,321),
 (1293,2,365),
 (1295,2,366),
 (13,3,1),
 (17,3,2),
 (5,3,4),
 (9,3,5),
 (21,3,7),
 (36,3,14),
 (40,3,15),
 (128,3,43),
 (132,3,44),
 (136,3,45),
 (255,3,78),
 (674,3,188),
 (678,3,189),
 (682,3,190),
 (686,3,191),
 (690,3,192),
 (750,3,209),
 (1143,3,319),
 (1296,3,366),
 (14,4,1),
 (18,4,2),
 (6,4,4),
 (10,4,5),
 (22,4,7),
 (37,4,14),
 (41,4,15),
 (129,4,43),
 (133,4,44),
 (137,4,45),
 (256,4,78),
 (671,4,188),
 (675,4,189),
 (679,4,190),
 (683,4,191),
 (687,4,192),
 (747,4,209),
 (1144,4,319),
 (1297,4,366);
/*!40000 ALTER TABLE `direito_funcao` ENABLE KEYS */;


--
-- Definition of table `direito_perfil`
--

DROP TABLE IF EXISTS `direito_perfil`;
CREATE TABLE `direito_perfil` (
  `id_perfil` int(11) NOT NULL COMMENT 'IdentificaÃ§Ã£o Ãºnica, sequencial de um perfil.',
  `id_difu` int(11) NOT NULL COMMENT 'IdentificaÃ§Ã£o Ãºnica, sequencial de um direito_funÃ§Ã£o.',
  PRIMARY KEY (`id_perfil`,`id_difu`),
  KEY `direito_perfil.id_difu` (`id_difu`),
  KEY `direito_perfil.id_perfil` (`id_perfil`),
  CONSTRAINT `direito_perfil_ibfk_1` FOREIGN KEY (`id_difu`) REFERENCES `direito_funcao` (`id_difu`) ON DELETE CASCADE,
  CONSTRAINT `direito_perfil_ibfk_2` FOREIGN KEY (`id_perfil`) REFERENCES `perfil` (`id_perfil`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='RelaÃ§Ã£o direito e Parfil do sistema';

--
-- Dumping data for table `direito_perfil`
--

/*!40000 ALTER TABLE `direito_perfil` DISABLE KEYS */;
INSERT INTO `direito_perfil` (`id_perfil`,`id_difu`) VALUES 
 (1,1),
 (1,2),
 (1,3),
 (1,4),
 (1,5),
 (1,6),
 (1,7),
 (1,8),
 (1,9),
 (1,10),
 (1,11),
 (1,12),
 (1,13),
 (1,14),
 (1,15),
 (1,16),
 (1,17),
 (1,18),
 (1,19),
 (1,20),
 (1,21),
 (1,22),
 (1,23),
 (1,24),
 (1,25),
 (1,26),
 (1,27),
 (1,28),
 (1,29),
 (1,30),
 (1,31),
 (1,34),
 (1,35),
 (1,36),
 (1,37),
 (1,38),
 (1,39),
 (1,40),
 (1,41),
 (1,42),
 (2,42),
 (1,125),
 (1,126),
 (1,127),
 (1,128),
 (1,129),
 (1,130),
 (1,131),
 (1,132),
 (1,133),
 (1,134),
 (1,135),
 (1,136),
 (1,137),
 (1,253),
 (1,254),
 (1,255),
 (1,256),
 (1,671),
 (1,672),
 (1,673),
 (1,674),
 (1,675),
 (1,676),
 (1,677),
 (1,678),
 (1,679),
 (1,680),
 (1,681),
 (1,682),
 (1,683),
 (1,684),
 (1,685),
 (1,686),
 (1,687),
 (1,688),
 (1,689),
 (1,690),
 (1,747),
 (1,748),
 (1,749),
 (1,750),
 (1,1141),
 (1,1142),
 (1,1143),
 (1,1144),
 (1,1145),
 (1,1146),
 (1,1293),
 (1,1294),
 (1,1295),
 (1,1296),
 (1,1297);
/*!40000 ALTER TABLE `direito_perfil` ENABLE KEYS */;


--
-- Definition of table `duvida`
--

DROP TABLE IF EXISTS `duvida`;
CREATE TABLE `duvida` (
  `idt` int(11) NOT NULL AUTO_INCREMENT,
  `pergunta` longtext,
  `resposta` longtext,
  PRIMARY KEY (`idt`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `duvida`
--

/*!40000 ALTER TABLE `duvida` DISABLE KEYS */;
INSERT INTO `duvida` (`idt`,`pergunta`,`resposta`) VALUES 
 (1,'O que é sebrae.PIR?','Essa sigla representa a Solução Integrada de Sistema automatizados para atendimento aos Processos do Sebrae-BA.\r\n<br />\r\nPIR - Plataforma Integrada de Relacionamento.\r\n<br />\r\nEssa Plataforma tem por Objetivo Integrar os Processos automatizados as');
/*!40000 ALTER TABLE `duvida` ENABLE KEYS */;


--
-- Definition of table `erro_log`
--

DROP TABLE IF EXISTS `erro_log`;
CREATE TABLE `erro_log` (
  `idt` int(11) NOT NULL AUTO_INCREMENT COMMENT 'IdentificaÃ§Ã£o Ãºnica, sequencial de um Log de Erro.',
  `data` datetime NOT NULL COMMENT 'Data da OcorrÃªncia',
  `login` varchar(50) DEFAULT NULL COMMENT 'Login do usuÃ¡rio ativo.',
  `nom_usuario` varchar(50) DEFAULT NULL COMMENT 'Nome do UsuÃ¡rio ativo',
  `ip_usuario` varchar(15) DEFAULT NULL COMMENT 'NÃºmero do IP do UsuÃ¡rio ativo.',
  `nom_tela` varchar(255) DEFAULT NULL COMMENT 'Nome interno do sistema da tela onde ocorreu o erro.',
  `origem_msg` varchar(10) NOT NULL COMMENT 'Origem da Mensagem.',
  `num_erro` varchar(50) NOT NULL COMMENT 'NÃºmero do erro',
  `mensagem` longtext NOT NULL COMMENT 'Mensagem de erro',
  `objeto` longtext NOT NULL COMMENT 'Objeto do erro',
  PRIMARY KEY (`idt`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1 COMMENT='LOG de ERROS do Sistema';

--
-- Dumping data for table `erro_log`
--

/*!40000 ALTER TABLE `erro_log` DISABLE KEYS */;
INSERT INTO `erro_log` (`idt`,`data`,`login`,`nom_usuario`,`ip_usuario`,`nom_tela`,`origem_msg`,`num_erro`,`mensagem`,`objeto`) VALUES 
 (1,'2015-04-15 12:30:00','lupe','Administrador','127.0.0.1','Cadastro','mysql','42S02','SQLSTATE[42S02]: Base table or view not found: 1146 Table \'db_gec.plu_usuario_natureza\' doesn\'t exist','czo1Mjc2OiJQRE9FeGNlcHRpb24gT2JqZWN0CigKICAgIFttZXNzYWdlOnByb3RlY3RlZF0gPT4gU1FMU1RBVEVbNDJTMDJdOiBCYXNlIHRhYmxlIG9yIHZpZXcgbm90IGZvdW5kOiAxMTQ2IFRhYmxlICdkYl9nZWMucGx1X3VzdWFyaW9fbmF0dXJlemEnIGRvZXNuJ3QgZXhpc3QKICAgIFtzdHJpbmc6cHJpdmF0ZV0gPT4gCiAgICBbY29kZTpwcm90ZWN0ZWRdID0+IDQyUzAyCiAgICBbZmlsZTpwcm90ZWN0ZWRdID0+IEM6XHdhbXBcd3d3XHNlYnJhZV9nZWNcYWRtaW5cZnVuY2FvLnBocAogICAgW2xpbmU6cHJvdGVjdGVkXSA9PiA4MjUKICAgIFt0cmFjZTpwcml2YXRlXSA9PiBBcnJheQogICAgICAgICgKICAgICAgICAgICAgWzBdID0+IEFycmF5CiAgICAgICAgICAgICAgICAoCiAgICAgICAgICAgICAgICAgICAgW2ZpbGVdID0+IEM6XHdhbXBcd3d3XHNlYnJhZV9nZWNcYWRtaW5cZnVuY2FvLnBocAogICAgICAgICAgICAgICAgICAgIFtsaW5lXSA9PiA4MjUKICAgICAgICAgICAgICAgICAgICBbZnVuY3Rpb25dID0+IHF1ZXJ5CiAgICAgICAgICAgICAgICAgICAgW2NsYXNzXSA9PiBQRE8KICAgICAgICAgICAgICAgICAgICBbdHlwZV0gPT4gLT4KICAgICAgICAgICAgICAgICAgICBbYXJnc10gPT4gQXJyYXkKICAgICAgICAgICAgICAgICAgICAgICAgKAogICAgICAgICAgICAgICAgICAgICAgICAgICAgWzBdID0+IHNlbGVjdCB1c3UuKiwgICBwbHVfdW4uZGVzY3JpY2FvIGFzIHBsdV91bl9kZXNjcmljYW8gICBmcm9tIHVzdWFyaW8gdXN1ICBpbm5lciBqb2luIHBsdV91c3VhcmlvX25hdHVyZXphIHBsdV91biBvbiBwbHVfdW4uaWR0ID0gdXN1LmlkdF9uYXR1cmV6YSBvcmRlciBieSBub21lX2NvbXBsZXRvCiAgICAgICAgICAgICAgICAgICAgICAgICkKCiAgICAgICAgICAgICAgICApCgogICAgICAgICAgICBbMV0gPT4gQXJyYXkKICAgICAgICAgICAgICAgICgKICAgICAgICAgICAgICAgICAgICBbZmlsZV0gPT4gQzpcd2FtcFx3d3dcc2VicmFlX2dlY1xhZG1pblxsaXN0YXIucGhwCiAgICAgICAgICAgICAgICAgICAgW2xpbmVdID0+IDE0NAogICAgICAgICAgICAgICAgICAgIFtmdW5jdGlvbl0gPT4gZXhlY3NxbAogICAgICAgICAgICAgICAgICAgIFthcmdzXSA9PiBBcnJheQogICAgICAgICAgICAgICAgICAgICAgICAoCiAgICAgICAgICAgICAgICAgICAgICAgICAgICBbMF0gPT4gc2VsZWN0IHVzdS4qLCAgIHBsdV91bi5kZXNjcmljYW8gYXMgcGx1X3VuX2Rlc2NyaWNhbyAgIGZyb20gdXN1YXJpbyB1c3UgIGlubmVyIGpvaW4gcGx1X3VzdWFyaW9fbmF0dXJlemEgcGx1X3VuIG9uIHBsdV91bi5pZHQgPSB1c3UuaWR0X25hdHVyZXphIG9yZGVyIGJ5IG5vbWVfY29tcGxldG8KICAgICAgICAgICAgICAgICAgICAgICAgKQoKICAgICAgICAgICAgICAgICkKCiAgICAgICAgICAgIFsyXSA9PiBBcnJheQogICAgICAgICAgICAgICAgKAogICAgICAgICAgICAgICAgICAgIFtmaWxlXSA9PiBDOlx3YW1wXHd3d1xzZWJyYWVfZ2VjXGFkbWluXGNvbnRldWRvLnBocAogICAgICAgICAgICAgICAgICAgIFtsaW5lXSA9PiAyODMKICAgICAgICAgICAgICAgICAgICBbYXJnc10gPT4gQXJyYXkKICAgICAgICAgICAgICAgICAgICAgICAgKAogICAgICAgICAgICAgICAgICAgICAgICAgICAgWzBdID0+IEM6XHdhbXBcd3d3XHNlYnJhZV9nZWNcYWRtaW5cbGlzdGFyLnBocAogICAgICAgICAgICAgICAgICAgICAgICApCgogICAgICAgICAgICAgICAgICAgIFtmdW5jdGlvbl0gPT4gcmVxdWlyZV9vbmNlCiAgICAgICAgICAgICAgICApCgogICAgICAgICkKCiAgICBbZXJyb3JJbmZvXSA9PiBBcnJheQogICAgICAgICgKICAgICAgICAgICAgWzBdID0+IDQyUzAyCiAgICAgICAgICAgIFsxXSA9PiAxMTQ2CiAgICAgICAgICAgIFsyXSA9PiBUYWJsZSAnZGJfZ2VjLnBsdV91c3VhcmlvX25hdHVyZXphJyBkb2Vzbid0IGV4aXN0CiAgICAgICAgKQoKICAgIFt4ZGVidWdfbWVzc2FnZV0gPT4gPHRyPjx0aCBhbGlnbj0nbGVmdCcgYmdjb2xvcj0nI2Y1NzkwMCcgY29sc3Bhbj0iNSI+PHNwYW4gc3R5bGU9J2JhY2tncm91bmQtY29sb3I6ICNjYzAwMDA7IGNvbG9yOiAjZmNlOTRmOyBmb250LXNpemU6IHgtbGFyZ2U7Jz4oICEgKTwvc3Bhbj4gUERPRXhjZXB0aW9uOiBTUUxTVEFURVs0MlMwMl06IEJhc2UgdGFibGUgb3IgdmlldyBub3QgZm91bmQ6IDExNDYgVGFibGUgJ2RiX2dlYy5wbHVfdXN1YXJpb19uYXR1cmV6YScgZG9lc24ndCBleGlzdCBpbiBDOlx3YW1wXHd3d1xzZWJyYWVfZ2VjXGFkbWluXGZ1bmNhby5waHAgb24gbGluZSA8aT44MjU8L2k+PC90aD48L3RyPgo8dHI+PHRoIGFsaWduPSdsZWZ0JyBiZ2NvbG9yPScjZTliOTZlJyBjb2xzcGFuPSc1Jz5DYWxsIFN0YWNrPC90aD48L3RyPgo8dHI+PHRoIGFsaWduPSdjZW50ZXInIGJnY29sb3I9JyNlZWVlZWMnPiM8L3RoPjx0aCBhbGlnbj0nbGVmdCcgYmdjb2xvcj0nI2VlZWVlYyc+VGltZTwvdGg+PHRoIGFsaWduPSdsZWZ0JyBiZ2NvbG9yPScjZWVlZWVjJz5NZW1vcnk8L3RoPjx0aCBhbGlnbj0nbGVmdCcgYmdjb2xvcj0nI2VlZWVlYyc+RnVuY3Rpb248L3RoPjx0aCBhbGlnbj0nbGVmdCcgYmdjb2xvcj0nI2VlZWVlYyc+TG9jYXRpb248L3RoPjwvdHI+Cjx0cj48dGQgYmdjb2xvcj0nI2VlZWVlYycgYWxpZ249J2NlbnRlcic+MTwvdGQ+PHRkIGJnY29sb3I9JyNlZWVlZWMnIGFsaWduPSdjZW50ZXInPjAuMDA0MzwvdGQ+PHRkIGJnY29sb3I9JyNlZWVlZWMnIGFsaWduPSdyaWdodCc+MTI3Mzc2PC90ZD48dGQgYmdjb2xvcj0nI2VlZWVlYyc+e21haW59KCAgKTwvdGQ+PHRkIHRpdGxlPSdDOlx3YW1wXHd3d1xzZWJyYWVfZ2VjXGFkbWluXGNvbnRldWRvLnBocCcgYmdjb2xvcj0nI2VlZWVlYyc+Li5cY29udGV1ZG8ucGhwPGI+OjwvYj4wPC90ZD48L3RyPgo8dHI+PHRkIGJnY29sb3I9JyNlZWVlZWMnIGFsaWduPSdjZW50ZXInPjI8L3RkPjx0ZCBiZ2NvbG9yPScjZWVlZWVjJyBhbGlnbj0nY2VudGVyJz4wLjI3OTg8L3RkPjx0ZCBiZ2NvbG9yPScjZWVlZWVjJyBhbGlnbj0ncmlnaHQnPjcyNDM5NzY8L3RkPjx0ZCBiZ2NvbG9yPScjZWVlZWVjJz5yZXF1aXJlX29uY2UoIDxmb250IGNvbG9yPScjMDBiYjAwJz4nQzpcd2FtcFx3d3dcc2VicmFlX2dlY1xhZG1pblxsaXN0YXIucGhwJzwvZm9udD4gKTwvdGQ+PHRkIHRpdGxlPSdDOlx3YW1wXHd3d1xzZWJyYWVfZ2VjXGFkbWluXGNvbnRldWRvLnBocCcgYmdjb2xvcj0nI2VlZWVlYyc+Li5cY29udGV1ZG8ucGhwPGI+OjwvYj4yODM8L3RkPjwvdHI+Cjx0cj48dGQgYmdjb2xvcj0nI2VlZWVlYycgYWxpZ249J2NlbnRlcic+MzwvdGQ+PHRkIGJnY29sb3I9JyNlZWVlZWMnIGFsaWduPSdjZW50ZXInPjAuMjg2MTwvdGQ+PHRkIGJnY29sb3I9JyNlZWVlZWMnIGFsaWduPSdyaWdodCc+NzI0NzUxMjwvdGQ+PHRkIGJnY29sb3I9JyNlZWVlZWMnPmV4ZWNzcWwoIDxzcGFuPjxmb250IGNvbG9yPScjY2MwMDAwJz5zdHJpbmcoMTY3KTwvZm9udD48L3NwYW4+LCA/Pz8sID8/PyApPC90ZD48dGQgdGl0bGU9J0M6XHdhbXBcd3d3XHNlYnJhZV9nZWNcYWRtaW5cbGlzdGFyLnBocCcgYmdjb2xvcj0nI2VlZWVlYyc+Li5cbGlzdGFyLnBocDxiPjo8L2I+MTQ0PC90ZD48L3RyPgo8dHI+PHRkIGJnY29sb3I9JyNlZWVlZWMnIGFsaWduPSdjZW50ZXInPjQ8L3RkPjx0ZCBiZ2NvbG9yPScjZWVlZWVjJyBhbGlnbj0nY2VudGVyJz4wLjI4NjM8L3RkPjx0ZCBiZ2NvbG9yPScjZWVlZWVjJyBhbGlnbj0ncmlnaHQnPjcyNTM4MDA8L3RkPjx0ZCBiZ2NvbG9yPScjZWVlZWVjJz5QRE8tPnF1ZXJ5KCA8c3Bhbj48Zm9udCBjb2xvcj0nI2NjMDAwMCc+c3RyaW5nKDE2Nyk8L2ZvbnQ+PC9zcGFuPiApPC90ZD48dGQgdGl0bGU9J0M6XHdhbXBcd3d3XHNlYnJhZV9nZWNcYWRtaW5cZnVuY2FvLnBocCcgYmdjb2xvcj0nI2VlZWVlYyc+Li5cZnVuY2FvLnBocDxiPjo8L2I+ODI1PC90ZD48L3RyPgo8dHI+PHRoIGNvbHNwYW49JzUnIGFsaWduPSdsZWZ0JyBiZ2NvbG9yPScjZTliOTZlJz5EdW1wIDxpPiRfR0VUPC9pPjwvdGg+PC90cj4KPHRyPjx0ZCBjb2xzcGFuPScyJyBhbGlnbj0ncmlnaHQnIGJnY29sb3I9JyNlZWVlZWMnIHZhbGlnbj0ndG9wJz48cHJlPiRfR0VUWydwcmVmaXhvJ10mbmJzcDs9PC9wcmU+PC90ZD48dGQgY29sc3Bhbj0nMycgYmdjb2xvcj0nI2VlZWVlYyc+PHByZSBjbGFzcz0neGRlYnVnLXZhci1kdW1wJyBkaXI9J2x0cic+PHNtYWxsPnN0cmluZzwvc21hbGw+IDxmb250IGNvbG9yPScjY2MwMDAwJz4nbGlzdGFyJzwvZm9udD4gPGk+KGxlbmd0aD02KTwvaT4KPC9wcmU+PC90ZD48L3RyPgo8dHI+PHRkIGNvbHNwYW49JzInIGFsaWduPSdyaWdodCcgYmdjb2xvcj0nI2VlZWVlYycgdmFsaWduPSd0b3AnPjxwcmU+JF9HRVRbJ21lbnUnXSZuYnNwOz08L3ByZT48L3RkPjx0ZCBjb2xzcGFuPSczJyBiZ2NvbG9yPScjZWVlZWVjJz48cHJlIGNsYXNzPSd4ZGVidWctdmFyLWR1bXAnIGRpcj0nbHRyJz48c21hbGw+c3RyaW5nPC9zbWFsbD4gPGZvbnQgY29sb3I9JyNjYzAwMDAnPid1c3VhcmlvJzwvZm9udD4gPGk+KGxlbmd0aD03KTwvaT4KPC9wcmU+PC90ZD48L3RyPgo8dHI+PHRkIGNvbHNwYW49JzInIGFsaWduPSdyaWdodCcgYmdjb2xvcj0nI2VlZWVlYycgdmFsaWduPSd0b3AnPjxwcmU+JF9HRVRbJ2NsYXNzJ10mbmJzcDs9PC9wcmU+PC90ZD48dGQgY29sc3Bhbj0nMycgYmdjb2xvcj0nI2VlZWVlYyc+PHByZSBjbGFzcz0neGRlYnVnLXZhci1kdW1wJyBkaXI9J2x0cic+PHNtYWxsPnN0cmluZzwvc21hbGw+IDxmb250IGNvbG9yPScjY2MwMDAwJz4nMCc8L2ZvbnQ+IDxpPihsZW5ndGg9MSk8L2k+CjwvcHJlPjwvdGQ+PC90cj4KPHRyPjx0ZCBjb2xzcGFuPScyJyBhbGlnbj0ncmlnaHQnIGJnY29sb3I9JyNlZWVlZWMnIHZhbGlnbj0ndG9wJz48cHJlPiRfR0VUWydwcmknXSZuYnNwOz08L3ByZT48L3RkPjx0ZCBjb2xzcGFuPSczJyBiZ2NvbG9yPScjZWVlZWVjJz48cHJlIGNsYXNzPSd4ZGVidWctdmFyLWR1bXAnIGRpcj0nbHRyJz48c21hbGw+c3RyaW5nPC9zbWFsbD4gPGZvbnQgY29sb3I9JyNjYzAwMDAnPidTJzwvZm9udD4gPGk+KGxlbmd0aD0xKTwvaT4KPC9wcmU+PC90ZD48L3RyPgo8dHI+PHRoIGNvbHNwYW49JzUnIGFsaWduPSdsZWZ0JyBiZ2NvbG9yPScjZTliOTZlJz5EdW1wIDxpPiRfUE9TVDwvaT48L3RoPjwvdHI+Cjx0cj48dGggY29sc3Bhbj0nNScgYWxpZ249J2xlZnQnIGJnY29sb3I9JyNlOWI5NmUnPkR1bXAgPGk+JF9GSUxFUzwvaT48L3RoPjwvdHI+CgopCiI7'),
 (2,'2015-04-15 13:16:00','lupe','Administrador','127.0.0.1','Cadastro','mysql','42S02','SQLSTATE[42S02]: Base table or view not found: 1146 Table \'db_gec.sca_organizacao_secao\' doesn\'t exist','czo2NjQxOiJQRE9FeGNlcHRpb24gT2JqZWN0CigKICAgIFttZXNzYWdlOnByb3RlY3RlZF0gPT4gU1FMU1RBVEVbNDJTMDJdOiBCYXNlIHRhYmxlIG9yIHZpZXcgbm90IGZvdW5kOiAxMTQ2IFRhYmxlICdkYl9nZWMuc2NhX29yZ2FuaXphY2FvX3NlY2FvJyBkb2Vzbid0IGV4aXN0CiAgICBbc3RyaW5nOnByaXZhdGVdID0+IAogICAgW2NvZGU6cHJvdGVjdGVkXSA9PiA0MlMwMgogICAgW2ZpbGU6cHJvdGVjdGVkXSA9PiBDOlx3YW1wXHd3d1xzZWJyYWVfZ2VjXGFkbWluXGZ1bmNhby5waHAKICAgIFtsaW5lOnByb3RlY3RlZF0gPT4gODI1CiAgICBbdHJhY2U6cHJpdmF0ZV0gPT4gQXJyYXkKICAgICAgICAoCiAgICAgICAgICAgIFswXSA9PiBBcnJheQogICAgICAgICAgICAgICAgKAogICAgICAgICAgICAgICAgICAgIFtmaWxlXSA9PiBDOlx3YW1wXHd3d1xzZWJyYWVfZ2VjXGFkbWluXGZ1bmNhby5waHAKICAgICAgICAgICAgICAgICAgICBbbGluZV0gPT4gODI1CiAgICAgICAgICAgICAgICAgICAgW2Z1bmN0aW9uXSA9PiBxdWVyeQogICAgICAgICAgICAgICAgICAgIFtjbGFzc10gPT4gUERPCiAgICAgICAgICAgICAgICAgICAgW3R5cGVdID0+IC0+CiAgICAgICAgICAgICAgICAgICAgW2FyZ3NdID0+IEFycmF5CiAgICAgICAgICAgICAgICAgICAgICAgICgKICAgICAgICAgICAgICAgICAgICAgICAgICAgIFswXSA9PiBzZWxlY3QgICAgc2Nhb2MuaWR0LCAgICAgZXN0LmNvZGlnbyBhcyBlc3RfY29kaWdvLCAgICBzY2Fvcy5sb2NhbGlkYWRlLCAgICAgc2Nhb3MuZGVzY3JpY2FvLCAgICAgc2Nhb2MuZGVzY3JpY2FvICAgZnJvbSBzY2Ffb3JnYW5pemFjYW9fc2VjYW8gYXMgc2Nhb3MgIGxlZnQgam9pbiBlc3RhZG8gZXN0IG9uIGVzdC5pZHQgPSBzY2Fvcy5pZHRfZXN0YWRvICBsZWZ0IGpvaW4gc2NhX29yZ2FuaXphY2FvX2NhcmdvIHNjYW9jIG9uIHNjYW9jLmlkdF9zZWNhbyA9IHNjYW9zLmlkdCAgb3JkZXIgYnkgZXN0LmRlc2NyaWNhbywgc2Nhb3MuZGVzY3JpY2FvLCBzY2FvYy5kZXNjcmljYW8KICAgICAgICAgICAgICAgICAgICAgICAgKQoKICAgICAgICAgICAgICAgICkKCiAgICAgICAgICAgIFsxXSA9PiBBcnJheQogICAgICAgICAgICAgICAgKAogICAgICAgICAgICAgICAgICAgIFtmaWxlXSA9PiBDOlx3YW1wXHd3d1xzZWJyYWVfZ2VjXGFkbWluXGNhZGFzdHJvX3AucGhwCiAgICAgICAgICAgICAgICAgICAgW2xpbmVdID0+IDEwNzgKICAgICAgICAgICAgICAgICAgICBbZnVuY3Rpb25dID0+IGV4ZWNzcWwKICAgICAgICAgICAgICAgICAgICBbYXJnc10gPT4gQXJyYXkKICAgICAgICAgICAgICAgICAgICAgICAgKAogICAgICAgICAgICAgICAgICAgICAgICAgICAgWzBdID0+IHNlbGVjdCAgICBzY2FvYy5pZHQsICAgICBlc3QuY29kaWdvIGFzIGVzdF9jb2RpZ28sICAgIHNjYW9zLmxvY2FsaWRhZGUsICAgICBzY2Fvcy5kZXNjcmljYW8sICAgICBzY2FvYy5kZXNjcmljYW8gICBmcm9tIHNjYV9vcmdhbml6YWNhb19zZWNhbyBhcyBzY2FvcyAgbGVmdCBqb2luIGVzdGFkbyBlc3Qgb24gZXN0LmlkdCA9IHNjYW9zLmlkdF9lc3RhZG8gIGxlZnQgam9pbiBzY2Ffb3JnYW5pemFjYW9fY2FyZ28gc2Nhb2Mgb24gc2Nhb2MuaWR0X3NlY2FvID0gc2Nhb3MuaWR0ICBvcmRlciBieSBlc3QuZGVzY3JpY2FvLCBzY2Fvcy5kZXNjcmljYW8sIHNjYW9jLmRlc2NyaWNhbyAKICAgICAgICAgICAgICAgICAgICAgICAgKQoKICAgICAgICAgICAgICAgICkKCiAgICAgICAgICAgIFsyXSA9PiBBcnJheQogICAgICAgICAgICAgICAgKAogICAgICAgICAgICAgICAgICAgIFtmaWxlXSA9PiBDOlx3YW1wXHd3d1xzZWJyYWVfZ2VjXGFkbWluXGNhZGFzdHJvLnBocAogICAgICAgICAgICAgICAgICAgIFtsaW5lXSA9PiAzMAogICAgICAgICAgICAgICAgICAgIFthcmdzXSA9PiBBcnJheQogICAgICAgICAgICAgICAgICAgICAgICAoCiAgICAgICAgICAgICAgICAgICAgICAgICAgICBbMF0gPT4gQzpcd2FtcFx3d3dcc2VicmFlX2dlY1xhZG1pblxjYWRhc3Ryb19wLnBocAogICAgICAgICAgICAgICAgICAgICAgICApCgogICAgICAgICAgICAgICAgICAgIFtmdW5jdGlvbl0gPT4gcmVxdWlyZV9vbmNlCiAgICAgICAgICAgICAgICApCgogICAgICAgICAgICBbM10gPT4gQXJyYXkKICAgICAgICAgICAgICAgICgKICAgICAgICAgICAgICAgICAgICBbZmlsZV0gPT4gQzpcd2FtcFx3d3dcc2VicmFlX2dlY1xhZG1pblxjb250ZXVkby5waHAKICAgICAgICAgICAgICAgICAgICBbbGluZV0gPT4gMjgzCiAgICAgICAgICAgICAgICAgICAgW2FyZ3NdID0+IEFycmF5CiAgICAgICAgICAgICAgICAgICAgICAgICgKICAgICAgICAgICAgICAgICAgICAgICAgICAgIFswXSA9PiBDOlx3YW1wXHd3d1xzZWJyYWVfZ2VjXGFkbWluXGNhZGFzdHJvLnBocAogICAgICAgICAgICAgICAgICAgICAgICApCgogICAgICAgICAgICAgICAgICAgIFtmdW5jdGlvbl0gPT4gcmVxdWlyZV9vbmNlCiAgICAgICAgICAgICAgICApCgogICAgICAgICkKCiAgICBbZXJyb3JJbmZvXSA9PiBBcnJheQogICAgICAgICgKICAgICAgICAgICAgWzBdID0+IDQyUzAyCiAgICAgICAgICAgIFsxXSA9PiAxMTQ2CiAgICAgICAgICAgIFsyXSA9PiBUYWJsZSAnZGJfZ2VjLnNjYV9vcmdhbml6YWNhb19zZWNhbycgZG9lc24ndCBleGlzdAogICAgICAgICkKCiAgICBbeGRlYnVnX21lc3NhZ2VdID0+IDx0cj48dGggYWxpZ249J2xlZnQnIGJnY29sb3I9JyNmNTc5MDAnIGNvbHNwYW49IjUiPjxzcGFuIHN0eWxlPSdiYWNrZ3JvdW5kLWNvbG9yOiAjY2MwMDAwOyBjb2xvcjogI2ZjZTk0ZjsgZm9udC1zaXplOiB4LWxhcmdlOyc+KCAhICk8L3NwYW4+IFBET0V4Y2VwdGlvbjogU1FMU1RBVEVbNDJTMDJdOiBCYXNlIHRhYmxlIG9yIHZpZXcgbm90IGZvdW5kOiAxMTQ2IFRhYmxlICdkYl9nZWMuc2NhX29yZ2FuaXphY2FvX3NlY2FvJyBkb2Vzbid0IGV4aXN0IGluIEM6XHdhbXBcd3d3XHNlYnJhZV9nZWNcYWRtaW5cZnVuY2FvLnBocCBvbiBsaW5lIDxpPjgyNTwvaT48L3RoPjwvdHI+Cjx0cj48dGggYWxpZ249J2xlZnQnIGJnY29sb3I9JyNlOWI5NmUnIGNvbHNwYW49JzUnPkNhbGwgU3RhY2s8L3RoPjwvdHI+Cjx0cj48dGggYWxpZ249J2NlbnRlcicgYmdjb2xvcj0nI2VlZWVlYyc+IzwvdGg+PHRoIGFsaWduPSdsZWZ0JyBiZ2NvbG9yPScjZWVlZWVjJz5UaW1lPC90aD48dGggYWxpZ249J2xlZnQnIGJnY29sb3I9JyNlZWVlZWMnPk1lbW9yeTwvdGg+PHRoIGFsaWduPSdsZWZ0JyBiZ2NvbG9yPScjZWVlZWVjJz5GdW5jdGlvbjwvdGg+PHRoIGFsaWduPSdsZWZ0JyBiZ2NvbG9yPScjZWVlZWVjJz5Mb2NhdGlvbjwvdGg+PC90cj4KPHRyPjx0ZCBiZ2NvbG9yPScjZWVlZWVjJyBhbGlnbj0nY2VudGVyJz4xPC90ZD48dGQgYmdjb2xvcj0nI2VlZWVlYycgYWxpZ249J2NlbnRlcic+MC4wMDM0PC90ZD48dGQgYmdjb2xvcj0nI2VlZWVlYycgYWxpZ249J3JpZ2h0Jz4xMjc4NDA8L3RkPjx0ZCBiZ2NvbG9yPScjZWVlZWVjJz57bWFpbn0oICApPC90ZD48dGQgdGl0bGU9J0M6XHdhbXBcd3d3XHNlYnJhZV9nZWNcYWRtaW5cY29udGV1ZG8ucGhwJyBiZ2NvbG9yPScjZWVlZWVjJz4uLlxjb250ZXVkby5waHA8Yj46PC9iPjA8L3RkPjwvdHI+Cjx0cj48dGQgYmdjb2xvcj0nI2VlZWVlYycgYWxpZ249J2NlbnRlcic+MjwvdGQ+PHRkIGJnY29sb3I9JyNlZWVlZWMnIGFsaWduPSdjZW50ZXInPjAuMjUzOTwvdGQ+PHRkIGJnY29sb3I9JyNlZWVlZWMnIGFsaWduPSdyaWdodCc+NzIyMTU1MjwvdGQ+PHRkIGJnY29sb3I9JyNlZWVlZWMnPnJlcXVpcmVfb25jZSggPGZvbnQgY29sb3I9JyMwMGJiMDAnPidDOlx3YW1wXHd3d1xzZWJyYWVfZ2VjXGFkbWluXGNhZGFzdHJvLnBocCc8L2ZvbnQ+ICk8L3RkPjx0ZCB0aXRsZT0nQzpcd2FtcFx3d3dcc2VicmFlX2dlY1xhZG1pblxjb250ZXVkby5waHAnIGJnY29sb3I9JyNlZWVlZWMnPi4uXGNvbnRldWRvLnBocDxiPjo8L2I+MjgzPC90ZD48L3RyPgo8dHI+PHRkIGJnY29sb3I9JyNlZWVlZWMnIGFsaWduPSdjZW50ZXInPjM8L3RkPjx0ZCBiZ2NvbG9yPScjZWVlZWVjJyBhbGlnbj0nY2VudGVyJz4wLjI3NDk8L3RkPjx0ZCBiZ2NvbG9yPScjZWVlZWVjJyBhbGlnbj0ncmlnaHQnPjc3MzM5OTI8L3RkPjx0ZCBiZ2NvbG9yPScjZWVlZWVjJz5yZXF1aXJlX29uY2UoIDxmb250IGNvbG9yPScjMDBiYjAwJz4nQzpcd2FtcFx3d3dcc2VicmFlX2dlY1xhZG1pblxjYWRhc3Ryb19wLnBocCc8L2ZvbnQ+ICk8L3RkPjx0ZCB0aXRsZT0nQzpcd2FtcFx3d3dcc2VicmFlX2dlY1xhZG1pblxjYWRhc3Ryby5waHAnIGJnY29sb3I9JyNlZWVlZWMnPi4uXGNhZGFzdHJvLnBocDxiPjo8L2I+MzA8L3RkPjwvdHI+Cjx0cj48dGQgYmdjb2xvcj0nI2VlZWVlYycgYWxpZ249J2NlbnRlcic+NDwvdGQ+PHRkIGJnY29sb3I9JyNlZWVlZWMnIGFsaWduPSdjZW50ZXInPjAuMzE4ODwvdGQ+PHRkIGJnY29sb3I9JyNlZWVlZWMnIGFsaWduPSdyaWdodCc+Nzk2NjAwMDwvdGQ+PHRkIGJnY29sb3I9JyNlZWVlZWMnPmV4ZWNzcWwoIDxzcGFuPjxmb250IGNvbG9yPScjY2MwMDAwJz5zdHJpbmcoMzMxKTwvZm9udD48L3NwYW4+LCA/Pz8sID8/PyApPC90ZD48dGQgdGl0bGU9J0M6XHdhbXBcd3d3XHNlYnJhZV9nZWNcYWRtaW5cY2FkYXN0cm9fcC5waHAnIGJnY29sb3I9JyNlZWVlZWMnPi4uXGNhZGFzdHJvX3AucGhwPGI+OjwvYj4xMDc4PC90ZD48L3RyPgo8dHI+PHRkIGJnY29sb3I9JyNlZWVlZWMnIGFsaWduPSdjZW50ZXInPjU8L3RkPjx0ZCBiZ2NvbG9yPScjZWVlZWVjJyBhbGlnbj0nY2VudGVyJz4wLjMxOTA8L3RkPjx0ZCBiZ2NvbG9yPScjZWVlZWVjJyBhbGlnbj0ncmlnaHQnPjc5NzI0NDg8L3RkPjx0ZCBiZ2NvbG9yPScjZWVlZWVjJz5QRE8tPnF1ZXJ5KCA8c3Bhbj48Zm9udCBjb2xvcj0nI2NjMDAwMCc+c3RyaW5nKDMzMCk8L2ZvbnQ+PC9zcGFuPiApPC90ZD48dGQgdGl0bGU9J0M6XHdhbXBcd3d3XHNlYnJhZV9nZWNcYWRtaW5cZnVuY2FvLnBocCcgYmdjb2xvcj0nI2VlZWVlYyc+Li5cZnVuY2FvLnBocDxiPjo8L2I+ODI1PC90ZD48L3RyPgo8dHI+PHRoIGNvbHNwYW49JzUnIGFsaWduPSdsZWZ0JyBiZ2NvbG9yPScjZTliOTZlJz5EdW1wIDxpPiRfR0VUPC9pPjwvdGg+PC90cj4KPHRyPjx0ZCBjb2xzcGFuPScyJyBhbGlnbj0ncmlnaHQnIGJnY29sb3I9JyNlZWVlZWMnIHZhbGlnbj0ndG9wJz48cHJlPiRfR0VUWydhY2FvJ10mbmJzcDs9PC9wcmU+PC90ZD48dGQgY29sc3Bhbj0nMycgYmdjb2xvcj0nI2VlZWVlYyc+PHByZSBjbGFzcz0neGRlYnVnLXZhci1kdW1wJyBkaXI9J2x0cic+PHNtYWxsPnN0cmluZzwvc21hbGw+IDxmb250IGNvbG9yPScjY2MwMDAwJz4nYWx0JzwvZm9udD4gPGk+KGxlbmd0aD0zKTwvaT4KPC9wcmU+PC90ZD48L3RyPgo8dHI+PHRkIGNvbHNwYW49JzInIGFsaWduPSdyaWdodCcgYmdjb2xvcj0nI2VlZWVlYycgdmFsaWduPSd0b3AnPjxwcmU+JF9HRVRbJ3RleHRvMCddJm5ic3A7PTwvcHJlPjwvdGQ+PHRkIGNvbHNwYW49JzMnIGJnY29sb3I9JyNlZWVlZWMnPjxwcmUgY2xhc3M9J3hkZWJ1Zy12YXItZHVtcCcgZGlyPSdsdHInPjxzbWFsbD5zdHJpbmc8L3NtYWxsPiA8Zm9udCBjb2xvcj0nI2NjMDAwMCc+Jyc8L2ZvbnQ+IDxpPihsZW5ndGg9MCk8L2k+CjwvcHJlPjwvdGQ+PC90cj4KPHRyPjx0ZCBjb2xzcGFuPScyJyBhbGlnbj0ncmlnaHQnIGJnY29sb3I9JyNlZWVlZWMnIHZhbGlnbj0ndG9wJz48cHJlPiRfR0VUWydwcmVmaXhvJ10mbmJzcDs9PC9wcmU+PC90ZD48dGQgY29sc3Bhbj0nMycgYmdjb2xvcj0nI2VlZWVlYyc+PHByZSBjbGFzcz0neGRlYnVnLXZhci1kdW1wJyBkaXI9J2x0cic+PHNtYWxsPnN0cmluZzwvc21hbGw+IDxmb250IGNvbG9yPScjY2MwMDAwJz4nY2FkYXN0cm8nPC9mb250PiA8aT4obGVuZ3RoPTgpPC9pPgo8L3ByZT48L3RkPjwvdHI+Cjx0cj48dGQgY29sc3Bhbj0nMicgYWxpZ249J3JpZ2h0JyBiZ2NvbG9yPScjZWVlZWVjJyB2YWxpZ249J3RvcCc+PHByZT4kX0dFVFsnbWVudSddJm5ic3A7PTwvcHJlPjwvdGQ+PHRkIGNvbHNwYW49JzMnIGJnY29sb3I9JyNlZWVlZWMnPjxwcmUgY2xhc3M9J3hkZWJ1Zy12YXItZHVtcCcgZGlyPSdsdHInPjxzbWFsbD5zdHJpbmc8L3NtYWxsPiA8Zm9udCBjb2xvcj0nI2NjMDAwMCc+J3VzdWFyaW8nPC9mb250PiA8aT4obGVuZ3RoPTcpPC9pPgo8L3ByZT48L3RkPjwvdHI+Cjx0cj48dGQgY29sc3Bhbj0nMicgYWxpZ249J3JpZ2h0JyBiZ2NvbG9yPScjZWVlZWVjJyB2YWxpZ249J3RvcCc+PHByZT4kX0dFVFsnaWQnXSZuYnNwOz08L3ByZT48L3RkPjx0ZCBjb2xzcGFuPSczJyBiZ2NvbG9yPScjZWVlZWVjJz48cHJlIGNsYXNzPSd4ZGVidWctdmFyLWR1bXAnIGRpcj0nbHRyJz48c21hbGw+c3RyaW5nPC9zbWFsbD4gPGZvbnQgY29sb3I9JyNjYzAwMDAnPicxJzwvZm9udD4gPGk+KGxlbmd0aD0xKTwvaT4KPC9wcmU+PC90ZD48L3RyPgo8dHI+PHRoIGNvbHNwYW49JzUnIGFsaWduPSdsZWZ0JyBiZ2NvbG9yPScjZTliOTZlJz5EdW1wIDxpPiRfUE9TVDwvaT48L3RoPjwvdHI+Cjx0cj48dGggY29sc3Bhbj0nNScgYWxpZ249J2xlZnQnIGJnY29sb3I9JyNlOWI5NmUnPkR1bXAgPGk+JF9GSUxFUzwvaT48L3RoPjwvdHI+CgopCiI7'),
 (3,'2015-04-15 13:19:00','lupe','Administrador','127.0.0.1','Cadastro','mysql','42S02','SQLSTATE[42S02]: Base table or view not found: 1146 Table \'db_gec.empreendimento\' doesn\'t exist','czo2OTcwOiJQRE9FeGNlcHRpb24gT2JqZWN0CigKICAgIFttZXNzYWdlOnByb3RlY3RlZF0gPT4gU1FMU1RBVEVbNDJTMDJdOiBCYXNlIHRhYmxlIG9yIHZpZXcgbm90IGZvdW5kOiAxMTQ2IFRhYmxlICdkYl9nZWMuZW1wcmVlbmRpbWVudG8nIGRvZXNuJ3QgZXhpc3QKICAgIFtzdHJpbmc6cHJpdmF0ZV0gPT4gCiAgICBbY29kZTpwcm90ZWN0ZWRdID0+IDQyUzAyCiAgICBbZmlsZTpwcm90ZWN0ZWRdID0+IEM6XHdhbXBcd3d3XHNlYnJhZV9nZWNcYWRtaW5cZnVuY2FvLnBocAogICAgW2xpbmU6cHJvdGVjdGVkXSA9PiA4MjUKICAgIFt0cmFjZTpwcml2YXRlXSA9PiBBcnJheQogICAgICAgICgKICAgICAgICAgICAgWzBdID0+IEFycmF5CiAgICAgICAgICAgICAgICAoCiAgICAgICAgICAgICAgICAgICAgW2ZpbGVdID0+IEM6XHdhbXBcd3d3XHNlYnJhZV9nZWNcYWRtaW5cZnVuY2FvLnBocAogICAgICAgICAgICAgICAgICAgIFtsaW5lXSA9PiA4MjUKICAgICAgICAgICAgICAgICAgICBbZnVuY3Rpb25dID0+IHF1ZXJ5CiAgICAgICAgICAgICAgICAgICAgW2NsYXNzXSA9PiBQRE8KICAgICAgICAgICAgICAgICAgICBbdHlwZV0gPT4gLT4KICAgICAgICAgICAgICAgICAgICBbYXJnc10gPT4gQXJyYXkKICAgICAgICAgICAgICAgICAgICAgICAgKAogICAgICAgICAgICAgICAgICAgICAgICAgICAgWzBdID0+IHNlbGVjdCBlbS5pZHQgYXMgaWR0X2VtcHJlZW5kaW1lbnRvLCAgc2Fjc2kuZGVzY3JpY2FvLCBzYWNzaS5zaWdsYSwgZW0uZGVzY3JpY2FvICBmcm9tIGVtcHJlZW5kaW1lbnRvIGVtICBpbm5lciBqb2luIHNjYV9zaXN0ZW1hIHNhY3NpIG9uIHNhY3NpLmlkdCA9IGVtLmlkdF9zaXN0ZW1hIG9yZGVyIGJ5IHNhY3NpLmRlc2NyaWNhbywgZW0uZGVzY3JpY2FvCiAgICAgICAgICAgICAgICAgICAgICAgICkKCiAgICAgICAgICAgICAgICApCgogICAgICAgICAgICBbMV0gPT4gQXJyYXkKICAgICAgICAgICAgICAgICgKICAgICAgICAgICAgICAgICAgICBbZmlsZV0gPT4gQzpcd2FtcFx3d3dcc2VicmFlX2dlY1xhZG1pblxjYWRhc3Ryb19wLnBocAogICAgICAgICAgICAgICAgICAgIFtsaW5lXSA9PiAxMzkwCiAgICAgICAgICAgICAgICAgICAgW2Z1bmN0aW9uXSA9PiBleGVjc3FsCiAgICAgICAgICAgICAgICAgICAgW2FyZ3NdID0+IEFycmF5CiAgICAgICAgICAgICAgICAgICAgICAgICgKICAgICAgICAgICAgICAgICAgICAgICAgICAgIFswXSA9PiBzZWxlY3QgZW0uaWR0IGFzIGlkdF9lbXByZWVuZGltZW50bywgIHNhY3NpLmRlc2NyaWNhbywgc2Fjc2kuc2lnbGEsIGVtLmRlc2NyaWNhbyAgZnJvbSBlbXByZWVuZGltZW50byBlbSAgaW5uZXIgam9pbiBzY2Ffc2lzdGVtYSBzYWNzaSBvbiBzYWNzaS5pZHQgPSBlbS5pZHRfc2lzdGVtYSBvcmRlciBieSBzYWNzaS5kZXNjcmljYW8sIGVtLmRlc2NyaWNhbwogICAgICAgICAgICAgICAgICAgICAgICApCgogICAgICAgICAgICAgICAgKQoKICAgICAgICAgICAgWzJdID0+IEFycmF5CiAgICAgICAgICAgICAgICAoCiAgICAgICAgICAgICAgICAgICAgW2ZpbGVdID0+IEM6XHdhbXBcd3d3XHNlYnJhZV9nZWNcYWRtaW5cY2FkYXN0cm9fcC5waHAKICAgICAgICAgICAgICAgICAgICBbbGluZV0gPT4gOTMxCiAgICAgICAgICAgICAgICAgICAgW2Z1bmN0aW9uXSA9PiBjb2RpZ29fbGlzdGEKICAgICAgICAgICAgICAgICAgICBbYXJnc10gPT4gQXJyYXkKICAgICAgICAgICAgICAgICAgICAgICAgKAogICAgICAgICAgICAgICAgICAgICAgICApCgogICAgICAgICAgICAgICAgKQoKICAgICAgICAgICAgWzNdID0+IEFycmF5CiAgICAgICAgICAgICAgICAoCiAgICAgICAgICAgICAgICAgICAgW2ZpbGVdID0+IEM6XHdhbXBcd3d3XHNlYnJhZV9nZWNcYWRtaW5cY2FkYXN0cm8ucGhwCiAgICAgICAgICAgICAgICAgICAgW2xpbmVdID0+IDMwCiAgICAgICAgICAgICAgICAgICAgW2FyZ3NdID0+IEFycmF5CiAgICAgICAgICAgICAgICAgICAgICAgICgKICAgICAgICAgICAgICAgICAgICAgICAgICAgIFswXSA9PiBDOlx3YW1wXHd3d1xzZWJyYWVfZ2VjXGFkbWluXGNhZGFzdHJvX3AucGhwCiAgICAgICAgICAgICAgICAgICAgICAgICkKCiAgICAgICAgICAgICAgICAgICAgW2Z1bmN0aW9uXSA9PiByZXF1aXJlX29uY2UKICAgICAgICAgICAgICAgICkKCiAgICAgICAgICAgIFs0XSA9PiBBcnJheQogICAgICAgICAgICAgICAgKAogICAgICAgICAgICAgICAgICAgIFtmaWxlXSA9PiBDOlx3YW1wXHd3d1xzZWJyYWVfZ2VjXGFkbWluXGNvbnRldWRvLnBocAogICAgICAgICAgICAgICAgICAgIFtsaW5lXSA9PiAyODMKICAgICAgICAgICAgICAgICAgICBbYXJnc10gPT4gQXJyYXkKICAgICAgICAgICAgICAgICAgICAgICAgKAogICAgICAgICAgICAgICAgICAgICAgICAgICAgWzBdID0+IEM6XHdhbXBcd3d3XHNlYnJhZV9nZWNcYWRtaW5cY2FkYXN0cm8ucGhwCiAgICAgICAgICAgICAgICAgICAgICAgICkKCiAgICAgICAgICAgICAgICAgICAgW2Z1bmN0aW9uXSA9PiByZXF1aXJlX29uY2UKICAgICAgICAgICAgICAgICkKCiAgICAgICAgKQoKICAgIFtlcnJvckluZm9dID0+IEFycmF5CiAgICAgICAgKAogICAgICAgICAgICBbMF0gPT4gNDJTMDIKICAgICAgICAgICAgWzFdID0+IDExNDYKICAgICAgICAgICAgWzJdID0+IFRhYmxlICdkYl9nZWMuZW1wcmVlbmRpbWVudG8nIGRvZXNuJ3QgZXhpc3QKICAgICAgICApCgogICAgW3hkZWJ1Z19tZXNzYWdlXSA9PiA8dHI+PHRoIGFsaWduPSdsZWZ0JyBiZ2NvbG9yPScjZjU3OTAwJyBjb2xzcGFuPSI1Ij48c3BhbiBzdHlsZT0nYmFja2dyb3VuZC1jb2xvcjogI2NjMDAwMDsgY29sb3I6ICNmY2U5NGY7IGZvbnQtc2l6ZTogeC1sYXJnZTsnPiggISApPC9zcGFuPiBQRE9FeGNlcHRpb246IFNRTFNUQVRFWzQyUzAyXTogQmFzZSB0YWJsZSBvciB2aWV3IG5vdCBmb3VuZDogMTE0NiBUYWJsZSAnZGJfZ2VjLmVtcHJlZW5kaW1lbnRvJyBkb2Vzbid0IGV4aXN0IGluIEM6XHdhbXBcd3d3XHNlYnJhZV9nZWNcYWRtaW5cZnVuY2FvLnBocCBvbiBsaW5lIDxpPjgyNTwvaT48L3RoPjwvdHI+Cjx0cj48dGggYWxpZ249J2xlZnQnIGJnY29sb3I9JyNlOWI5NmUnIGNvbHNwYW49JzUnPkNhbGwgU3RhY2s8L3RoPjwvdHI+Cjx0cj48dGggYWxpZ249J2NlbnRlcicgYmdjb2xvcj0nI2VlZWVlYyc+IzwvdGg+PHRoIGFsaWduPSdsZWZ0JyBiZ2NvbG9yPScjZWVlZWVjJz5UaW1lPC90aD48dGggYWxpZ249J2xlZnQnIGJnY29sb3I9JyNlZWVlZWMnPk1lbW9yeTwvdGg+PHRoIGFsaWduPSdsZWZ0JyBiZ2NvbG9yPScjZWVlZWVjJz5GdW5jdGlvbjwvdGg+PHRoIGFsaWduPSdsZWZ0JyBiZ2NvbG9yPScjZWVlZWVjJz5Mb2NhdGlvbjwvdGg+PC90cj4KPHRyPjx0ZCBiZ2NvbG9yPScjZWVlZWVjJyBhbGlnbj0nY2VudGVyJz4xPC90ZD48dGQgYmdjb2xvcj0nI2VlZWVlYycgYWxpZ249J2NlbnRlcic+MC4wMDgzPC90ZD48dGQgYmdjb2xvcj0nI2VlZWVlYycgYWxpZ249J3JpZ2h0Jz4xMjgwNjQ8L3RkPjx0ZCBiZ2NvbG9yPScjZWVlZWVjJz57bWFpbn0oICApPC90ZD48dGQgdGl0bGU9J0M6XHdhbXBcd3d3XHNlYnJhZV9nZWNcYWRtaW5cY29udGV1ZG8ucGhwJyBiZ2NvbG9yPScjZWVlZWVjJz4uLlxjb250ZXVkby5waHA8Yj46PC9iPjA8L3RkPjwvdHI+Cjx0cj48dGQgYmdjb2xvcj0nI2VlZWVlYycgYWxpZ249J2NlbnRlcic+MjwvdGQ+PHRkIGJnY29sb3I9JyNlZWVlZWMnIGFsaWduPSdjZW50ZXInPjAuMjg1MjwvdGQ+PHRkIGJnY29sb3I9JyNlZWVlZWMnIGFsaWduPSdyaWdodCc+NzIyMTgwMDwvdGQ+PHRkIGJnY29sb3I9JyNlZWVlZWMnPnJlcXVpcmVfb25jZSggPGZvbnQgY29sb3I9JyMwMGJiMDAnPidDOlx3YW1wXHd3d1xzZWJyYWVfZ2VjXGFkbWluXGNhZGFzdHJvLnBocCc8L2ZvbnQ+ICk8L3RkPjx0ZCB0aXRsZT0nQzpcd2FtcFx3d3dcc2VicmFlX2dlY1xhZG1pblxjb250ZXVkby5waHAnIGJnY29sb3I9JyNlZWVlZWMnPi4uXGNvbnRldWRvLnBocDxiPjo8L2I+MjgzPC90ZD48L3RyPgo8dHI+PHRkIGJnY29sb3I9JyNlZWVlZWMnIGFsaWduPSdjZW50ZXInPjM8L3RkPjx0ZCBiZ2NvbG9yPScjZWVlZWVjJyBhbGlnbj0nY2VudGVyJz4wLjI5MzM8L3RkPjx0ZCBiZ2NvbG9yPScjZWVlZWVjJyBhbGlnbj0ncmlnaHQnPjc3MzQ1NTI8L3RkPjx0ZCBiZ2NvbG9yPScjZWVlZWVjJz5yZXF1aXJlX29uY2UoIDxmb250IGNvbG9yPScjMDBiYjAwJz4nQzpcd2FtcFx3d3dcc2VicmFlX2dlY1xhZG1pblxjYWRhc3Ryb19wLnBocCc8L2ZvbnQ+ICk8L3RkPjx0ZCB0aXRsZT0nQzpcd2FtcFx3d3dcc2VicmFlX2dlY1xhZG1pblxjYWRhc3Ryby5waHAnIGJnY29sb3I9JyNlZWVlZWMnPi4uXGNhZGFzdHJvLnBocDxiPjo8L2I+MzA8L3RkPjwvdHI+Cjx0cj48dGQgYmdjb2xvcj0nI2VlZWVlYycgYWxpZ249J2NlbnRlcic+NDwvdGQ+PHRkIGJnY29sb3I9JyNlZWVlZWMnIGFsaWduPSdjZW50ZXInPjAuMzQxOTwvdGQ+PHRkIGJnY29sb3I9JyNlZWVlZWMnIGFsaWduPSdyaWdodCc+Nzk2NTg1NjwvdGQ+PHRkIGJnY29sb3I9JyNlZWVlZWMnPmNvZGlnb19saXN0YSggICk8L3RkPjx0ZCB0aXRsZT0nQzpcd2FtcFx3d3dcc2VicmFlX2dlY1xhZG1pblxjYWRhc3Ryb19wLnBocCcgYmdjb2xvcj0nI2VlZWVlYyc+Li5cY2FkYXN0cm9fcC5waHA8Yj46PC9iPjkzMTwvdGQ+PC90cj4KPHRyPjx0ZCBiZ2NvbG9yPScjZWVlZWVjJyBhbGlnbj0nY2VudGVyJz41PC90ZD48dGQgYmdjb2xvcj0nI2VlZWVlYycgYWxpZ249J2NlbnRlcic+MC4zNDIwPC90ZD48dGQgYmdjb2xvcj0nI2VlZWVlYycgYWxpZ249J3JpZ2h0Jz43OTY5NTEyPC90ZD48dGQgYmdjb2xvcj0nI2VlZWVlYyc+ZXhlY3NxbCggPHNwYW4+PGZvbnQgY29sb3I9JyNjYzAwMDAnPnN0cmluZygyMDMpPC9mb250Pjwvc3Bhbj4sID8/PywgPz8/ICk8L3RkPjx0ZCB0aXRsZT0nQzpcd2FtcFx3d3dcc2VicmFlX2dlY1xhZG1pblxjYWRhc3Ryb19wLnBocCcgYmdjb2xvcj0nI2VlZWVlYyc+Li5cY2FkYXN0cm9fcC5waHA8Yj46PC9iPjEzOTA8L3RkPjwvdHI+Cjx0cj48dGQgYmdjb2xvcj0nI2VlZWVlYycgYWxpZ249J2NlbnRlcic+NjwvdGQ+PHRkIGJnY29sb3I9JyNlZWVlZWMnIGFsaWduPSdjZW50ZXInPjAuMzQyMzwvdGQ+PHRkIGJnY29sb3I9JyNlZWVlZWMnIGFsaWduPSdyaWdodCc+Nzk3NTcyODwvdGQ+PHRkIGJnY29sb3I9JyNlZWVlZWMnPlBETy0+cXVlcnkoIDxzcGFuPjxmb250IGNvbG9yPScjY2MwMDAwJz5zdHJpbmcoMjAzKTwvZm9udD48L3NwYW4+ICk8L3RkPjx0ZCB0aXRsZT0nQzpcd2FtcFx3d3dcc2VicmFlX2dlY1xhZG1pblxmdW5jYW8ucGhwJyBiZ2NvbG9yPScjZWVlZWVjJz4uLlxmdW5jYW8ucGhwPGI+OjwvYj44MjU8L3RkPjwvdHI+Cjx0cj48dGggY29sc3Bhbj0nNScgYWxpZ249J2xlZnQnIGJnY29sb3I9JyNlOWI5NmUnPkR1bXAgPGk+JF9HRVQ8L2k+PC90aD48L3RyPgo8dHI+PHRkIGNvbHNwYW49JzInIGFsaWduPSdyaWdodCcgYmdjb2xvcj0nI2VlZWVlYycgdmFsaWduPSd0b3AnPjxwcmU+JF9HRVRbJ2FjYW8nXSZuYnNwOz08L3ByZT48L3RkPjx0ZCBjb2xzcGFuPSczJyBiZ2NvbG9yPScjZWVlZWVjJz48cHJlIGNsYXNzPSd4ZGVidWctdmFyLWR1bXAnIGRpcj0nbHRyJz48c21hbGw+c3RyaW5nPC9zbWFsbD4gPGZvbnQgY29sb3I9JyNjYzAwMDAnPidhbHQnPC9mb250PiA8aT4obGVuZ3RoPTMpPC9pPgo8L3ByZT48L3RkPjwvdHI+Cjx0cj48dGQgY29sc3Bhbj0nMicgYWxpZ249J3JpZ2h0JyBiZ2NvbG9yPScjZWVlZWVjJyB2YWxpZ249J3RvcCc+PHByZT4kX0dFVFsndGV4dG8wJ10mbmJzcDs9PC9wcmU+PC90ZD48dGQgY29sc3Bhbj0nMycgYmdjb2xvcj0nI2VlZWVlYyc+PHByZSBjbGFzcz0neGRlYnVnLXZhci1kdW1wJyBkaXI9J2x0cic+PHNtYWxsPnN0cmluZzwvc21hbGw+IDxmb250IGNvbG9yPScjY2MwMDAwJz4nJzwvZm9udD4gPGk+KGxlbmd0aD0wKTwvaT4KPC9wcmU+PC90ZD48L3RyPgo8dHI+PHRkIGNvbHNwYW49JzInIGFsaWduPSdyaWdodCcgYmdjb2xvcj0nI2VlZWVlYycgdmFsaWduPSd0b3AnPjxwcmU+JF9HRVRbJ3ByZWZpeG8nXSZuYnNwOz08L3ByZT48L3RkPjx0ZCBjb2xzcGFuPSczJyBiZ2NvbG9yPScjZWVlZWVjJz48cHJlIGNsYXNzPSd4ZGVidWctdmFyLWR1bXAnIGRpcj0nbHRyJz48c21hbGw+c3RyaW5nPC9zbWFsbD4gPGZvbnQgY29sb3I9JyNjYzAwMDAnPidjYWRhc3Rybyc8L2ZvbnQ+IDxpPihsZW5ndGg9OCk8L2k+CjwvcHJlPjwvdGQ+PC90cj4KPHRyPjx0ZCBjb2xzcGFuPScyJyBhbGlnbj0ncmlnaHQnIGJnY29sb3I9JyNlZWVlZWMnIHZhbGlnbj0ndG9wJz48cHJlPiRfR0VUWydtZW51J10mbmJzcDs9PC9wcmU+PC90ZD48dGQgY29sc3Bhbj0nMycgYmdjb2xvcj0nI2VlZWVlYyc+PHByZSBjbGFzcz0neGRlYnVnLXZhci1kdW1wJyBkaXI9J2x0cic+PHNtYWxsPnN0cmluZzwvc21hbGw+IDxmb250IGNvbG9yPScjY2MwMDAwJz4ndXN1YXJpbyc8L2ZvbnQ+IDxpPihsZW5ndGg9Nyk8L2k+CjwvcHJlPjwvdGQ+PC90cj4KPHRyPjx0ZCBjb2xzcGFuPScyJyBhbGlnbj0ncmlnaHQnIGJnY29sb3I9JyNlZWVlZWMnIHZhbGlnbj0ndG9wJz48cHJlPiRfR0VUWydpZCddJm5ic3A7PTwvcHJlPjwvdGQ+PHRkIGNvbHNwYW49JzMnIGJnY29sb3I9JyNlZWVlZWMnPjxwcmUgY2xhc3M9J3hkZWJ1Zy12YXItZHVtcCcgZGlyPSdsdHInPjxzbWFsbD5zdHJpbmc8L3NtYWxsPiA8Zm9udCBjb2xvcj0nI2NjMDAwMCc+JzEnPC9mb250PiA8aT4obGVuZ3RoPTEpPC9pPgo8L3ByZT48L3RkPjwvdHI+Cjx0cj48dGggY29sc3Bhbj0nNScgYWxpZ249J2xlZnQnIGJnY29sb3I9JyNlOWI5NmUnPkR1bXAgPGk+JF9QT1NUPC9pPjwvdGg+PC90cj4KPHRyPjx0aCBjb2xzcGFuPSc1JyBhbGlnbj0nbGVmdCcgYmdjb2xvcj0nI2U5Yjk2ZSc+RHVtcCA8aT4kX0ZJTEVTPC9pPjwvdGg+PC90cj4KCikKIjs='),
 (4,'2015-04-15 13:21:00','lupe','Administrador','127.0.0.1','Lista de Usuários','mysql','42S02','SQLSTATE[42S02]: Base table or view not found: 1146 Table \'db_gec.sca_estrutura\' doesn\'t exist','czo2MTM3OiJQRE9FeGNlcHRpb24gT2JqZWN0CigKICAgIFttZXNzYWdlOnByb3RlY3RlZF0gPT4gU1FMU1RBVEVbNDJTMDJdOiBCYXNlIHRhYmxlIG9yIHZpZXcgbm90IGZvdW5kOiAxMTQ2IFRhYmxlICdkYl9nZWMuc2NhX2VzdHJ1dHVyYScgZG9lc24ndCBleGlzdAogICAgW3N0cmluZzpwcml2YXRlXSA9PiAKICAgIFtjb2RlOnByb3RlY3RlZF0gPT4gNDJTMDIKICAgIFtmaWxlOnByb3RlY3RlZF0gPT4gQzpcd2FtcFx3d3dcc2VicmFlX2dlY1xhZG1pblxmdW5jYW8ucGhwCiAgICBbbGluZTpwcm90ZWN0ZWRdID0+IDgyNQogICAgW3RyYWNlOnByaXZhdGVdID0+IEFycmF5CiAgICAgICAgKAogICAgICAgICAgICBbMF0gPT4gQXJyYXkKICAgICAgICAgICAgICAgICgKICAgICAgICAgICAgICAgICAgICBbZmlsZV0gPT4gQzpcd2FtcFx3d3dcc2VicmFlX2dlY1xhZG1pblxmdW5jYW8ucGhwCiAgICAgICAgICAgICAgICAgICAgW2xpbmVdID0+IDgyNQogICAgICAgICAgICAgICAgICAgIFtmdW5jdGlvbl0gPT4gcXVlcnkKICAgICAgICAgICAgICAgICAgICBbY2xhc3NdID0+IFBETwogICAgICAgICAgICAgICAgICAgIFt0eXBlXSA9PiAtPgogICAgICAgICAgICAgICAgICAgIFthcmdzXSA9PiBBcnJheQogICAgICAgICAgICAgICAgICAgICAgICAoCiAgICAgICAgICAgICAgICAgICAgICAgICAgICBbMF0gPT4gc2VsZWN0DQoNCiAgICAgICAgICAgICAgIHVzLm5vbWVfY29tcGxldG8gYXMgdXNfbm9tZV9jb21wbGV0bywNCiAgICAgICAgICAgICAgIHVzLmxvZ2luIGFzIHVzX2xvZ2luLA0KICAgICAgICAgICAgICAgdXMuYXRpdm8gYXMgdXNfYXRpdm8sDQogICAgICAgICAgICAgICB1cy5hY2Vzc29fb2JyYSBhcyB1c19hY2Vzc29fb2JyYSwNCiAgICAgICAgICAgICAgIHVzLmdlcmVuY2lhZG9yIGFzIHVzX2dlcmVuY2lhZG9yLA0KICAgICAgICAgICAgICAgcGUubm1fcGVyZmlsIGFzIHBlX25tX3BlcmZpbCwNCiAgICAgICAgICAgICAgIHVzLmR0X3ZhbGlkYWRlIGFzIHVzX2R0X3ZhbGlkYWRlLA0KICAgICAgICAgICAgICAgdXMuZW1haWwgYXMgdXNfZW1haWwsDQogICAgICAgICAgICAgICBzY2FzZS5jbGFzc2lmaWNhY2FvIGFzIHNjYXNlX2NsYXNzaWZpY2FjYW8sDQogICAgICAgICAgICAgICBzY2FzZS5kZXNjcmljYW8gYXMgc2Nhc2VfZGVzY3JpY2FvDQoNCiAgICAgICAgZnJvbSB1c3VhcmlvIGFzIHVzDQoNCiAgICAgICAgbGVmdCAgam9pbiBzY2FfZXN0cnV0dXJhIGFzIHNjYXNlIG9uIHNjYXNlLmlkdCA9ICB1cy5pZHRfc2V0b3INCg0KICAgICAgICBpbm5lciBqb2luIHBlcmZpbCAgIGFzIHBlIG9uIHVzLmlkX3BlcmZpbCA9IHBlLmlkX3BlcmZpbCAgb3JkZXIgYnkgc2Nhc2UuY2xhc3NpZmljYWNhbywgdXMubm9tZV9jb21wbGV0bwogICAgICAgICAgICAgICAgICAgICAgICApCgogICAgICAgICAgICAgICAgKQoKICAgICAgICAgICAgWzFdID0+IEFycmF5CiAgICAgICAgICAgICAgICAoCiAgICAgICAgICAgICAgICAgICAgW2ZpbGVdID0+IEM6XHdhbXBcd3d3XHNlYnJhZV9nZWNcYWRtaW5ccmVsYXRvcmlvXHJlbF91c3VhcmlvLnBocAogICAgICAgICAgICAgICAgICAgIFtsaW5lXSA9PiAxNDQKICAgICAgICAgICAgICAgICAgICBbZnVuY3Rpb25dID0+IGV4ZWNzcWwKICAgICAgICAgICAgICAgICAgICBbYXJnc10gPT4gQXJyYXkKICAgICAgICAgICAgICAgICAgICAgICAgKAogICAgICAgICAgICAgICAgICAgICAgICAgICAgWzBdID0+IHNlbGVjdA0KDQogICAgICAgICAgICAgICB1cy5ub21lX2NvbXBsZXRvIGFzIHVzX25vbWVfY29tcGxldG8sDQogICAgICAgICAgICAgICB1cy5sb2dpbiBhcyB1c19sb2dpbiwNCiAgICAgICAgICAgICAgIHVzLmF0aXZvIGFzIHVzX2F0aXZvLA0KICAgICAgICAgICAgICAgdXMuYWNlc3NvX29icmEgYXMgdXNfYWNlc3NvX29icmEsDQogICAgICAgICAgICAgICB1cy5nZXJlbmNpYWRvciBhcyB1c19nZXJlbmNpYWRvciwNCiAgICAgICAgICAgICAgIHBlLm5tX3BlcmZpbCBhcyBwZV9ubV9wZXJmaWwsDQogICAgICAgICAgICAgICB1cy5kdF92YWxpZGFkZSBhcyB1c19kdF92YWxpZGFkZSwNCiAgICAgICAgICAgICAgIHVzLmVtYWlsIGFzIHVzX2VtYWlsLA0KICAgICAgICAgICAgICAgc2Nhc2UuY2xhc3NpZmljYWNhbyBhcyBzY2FzZV9jbGFzc2lmaWNhY2FvLA0KICAgICAgICAgICAgICAgc2Nhc2UuZGVzY3JpY2FvIGFzIHNjYXNlX2Rlc2NyaWNhbw0KDQogICAgICAgIGZyb20gdXN1YXJpbyBhcyB1cw0KDQogICAgICAgIGxlZnQgIGpvaW4gc2NhX2VzdHJ1dHVyYSBhcyBzY2FzZSBvbiBzY2FzZS5pZHQgPSAgdXMuaWR0X3NldG9yDQoNCiAgICAgICAgaW5uZXIgam9pbiBwZXJmaWwgICBhcyBwZSBvbiB1cy5pZF9wZXJmaWwgPSBwZS5pZF9wZXJmaWwgIG9yZGVyIGJ5IHNjYXNlLmNsYXNzaWZpY2FjYW8sIHVzLm5vbWVfY29tcGxldG8KICAgICAgICAgICAgICAgICAgICAgICAgKQoKICAgICAgICAgICAgICAgICkKCiAgICAgICAgICAgIFsyXSA9PiBBcnJheQogICAgICAgICAgICAgICAgKAogICAgICAgICAgICAgICAgICAgIFtmaWxlXSA9PiBDOlx3YW1wXHd3d1xzZWJyYWVfZ2VjXGFkbWluXGNvbnRldWRvLnBocAogICAgICAgICAgICAgICAgICAgIFtsaW5lXSA9PiAyODMKICAgICAgICAgICAgICAgICAgICBbYXJnc10gPT4gQXJyYXkKICAgICAgICAgICAgICAgICAgICAgICAgKAogICAgICAgICAgICAgICAgICAgICAgICAgICAgWzBdID0+IEM6XHdhbXBcd3d3XHNlYnJhZV9nZWNcYWRtaW5ccmVsYXRvcmlvXHJlbF91c3VhcmlvLnBocAogICAgICAgICAgICAgICAgICAgICAgICApCgogICAgICAgICAgICAgICAgICAgIFtmdW5jdGlvbl0gPT4gcmVxdWlyZV9vbmNlCiAgICAgICAgICAgICAgICApCgogICAgICAgICkKCiAgICBbZXJyb3JJbmZvXSA9PiBBcnJheQogICAgICAgICgKICAgICAgICAgICAgWzBdID0+IDQyUzAyCiAgICAgICAgICAgIFsxXSA9PiAxMTQ2CiAgICAgICAgICAgIFsyXSA9PiBUYWJsZSAnZGJfZ2VjLnNjYV9lc3RydXR1cmEnIGRvZXNuJ3QgZXhpc3QKICAgICAgICApCgogICAgW3hkZWJ1Z19tZXNzYWdlXSA9PiA8dHI+PHRoIGFsaWduPSdsZWZ0JyBiZ2NvbG9yPScjZjU3OTAwJyBjb2xzcGFuPSI1Ij48c3BhbiBzdHlsZT0nYmFja2dyb3VuZC1jb2xvcjogI2NjMDAwMDsgY29sb3I6ICNmY2U5NGY7IGZvbnQtc2l6ZTogeC1sYXJnZTsnPiggISApPC9zcGFuPiBQRE9FeGNlcHRpb246IFNRTFNUQVRFWzQyUzAyXTogQmFzZSB0YWJsZSBvciB2aWV3IG5vdCBmb3VuZDogMTE0NiBUYWJsZSAnZGJfZ2VjLnNjYV9lc3RydXR1cmEnIGRvZXNuJ3QgZXhpc3QgaW4gQzpcd2FtcFx3d3dcc2VicmFlX2dlY1xhZG1pblxmdW5jYW8ucGhwIG9uIGxpbmUgPGk+ODI1PC9pPjwvdGg+PC90cj4KPHRyPjx0aCBhbGlnbj0nbGVmdCcgYmdjb2xvcj0nI2U5Yjk2ZScgY29sc3Bhbj0nNSc+Q2FsbCBTdGFjazwvdGg+PC90cj4KPHRyPjx0aCBhbGlnbj0nY2VudGVyJyBiZ2NvbG9yPScjZWVlZWVjJz4jPC90aD48dGggYWxpZ249J2xlZnQnIGJnY29sb3I9JyNlZWVlZWMnPlRpbWU8L3RoPjx0aCBhbGlnbj0nbGVmdCcgYmdjb2xvcj0nI2VlZWVlYyc+TWVtb3J5PC90aD48dGggYWxpZ249J2xlZnQnIGJnY29sb3I9JyNlZWVlZWMnPkZ1bmN0aW9uPC90aD48dGggYWxpZ249J2xlZnQnIGJnY29sb3I9JyNlZWVlZWMnPkxvY2F0aW9uPC90aD48L3RyPgo8dHI+PHRkIGJnY29sb3I9JyNlZWVlZWMnIGFsaWduPSdjZW50ZXInPjE8L3RkPjx0ZCBiZ2NvbG9yPScjZWVlZWVjJyBhbGlnbj0nY2VudGVyJz4wLjAwMjc8L3RkPjx0ZCBiZ2NvbG9yPScjZWVlZWVjJyBhbGlnbj0ncmlnaHQnPjEyNzI5NjwvdGQ+PHRkIGJnY29sb3I9JyNlZWVlZWMnPnttYWlufSggICk8L3RkPjx0ZCB0aXRsZT0nQzpcd2FtcFx3d3dcc2VicmFlX2dlY1xhZG1pblxjb250ZXVkby5waHAnIGJnY29sb3I9JyNlZWVlZWMnPi4uXGNvbnRldWRvLnBocDxiPjo8L2I+MDwvdGQ+PC90cj4KPHRyPjx0ZCBiZ2NvbG9yPScjZWVlZWVjJyBhbGlnbj0nY2VudGVyJz4yPC90ZD48dGQgYmdjb2xvcj0nI2VlZWVlYycgYWxpZ249J2NlbnRlcic+MC4zMDg2PC90ZD48dGQgYmdjb2xvcj0nI2VlZWVlYycgYWxpZ249J3JpZ2h0Jz43MjkyODE2PC90ZD48dGQgYmdjb2xvcj0nI2VlZWVlYyc+cmVxdWlyZV9vbmNlKCA8Zm9udCBjb2xvcj0nIzAwYmIwMCc+J0M6XHdhbXBcd3d3XHNlYnJhZV9nZWNcYWRtaW5ccmVsYXRvcmlvXHJlbF91c3VhcmlvLnBocCc8L2ZvbnQ+ICk8L3RkPjx0ZCB0aXRsZT0nQzpcd2FtcFx3d3dcc2VicmFlX2dlY1xhZG1pblxjb250ZXVkby5waHAnIGJnY29sb3I9JyNlZWVlZWMnPi4uXGNvbnRldWRvLnBocDxiPjo8L2I+MjgzPC90ZD48L3RyPgo8dHI+PHRkIGJnY29sb3I9JyNlZWVlZWMnIGFsaWduPSdjZW50ZXInPjM8L3RkPjx0ZCBiZ2NvbG9yPScjZWVlZWVjJyBhbGlnbj0nY2VudGVyJz4wLjM3MDI8L3RkPjx0ZCBiZ2NvbG9yPScjZWVlZWVjJyBhbGlnbj0ncmlnaHQnPjgxMTg4NjQ8L3RkPjx0ZCBiZ2NvbG9yPScjZWVlZWVjJz5leGVjc3FsKCA8c3Bhbj48Zm9udCBjb2xvcj0nI2NjMDAwMCc+c3RyaW5nKDcwMyk8L2ZvbnQ+PC9zcGFuPiwgPz8/LCA/Pz8gKTwvdGQ+PHRkIHRpdGxlPSdDOlx3YW1wXHd3d1xzZWJyYWVfZ2VjXGFkbWluXHJlbGF0b3Jpb1xyZWxfdXN1YXJpby5waHAnIGJnY29sb3I9JyNlZWVlZWMnPi4uXHJlbF91c3VhcmlvLnBocDxiPjo8L2I+MTQ0PC90ZD48L3RyPgo8dHI+PHRkIGJnY29sb3I9JyNlZWVlZWMnIGFsaWduPSdjZW50ZXInPjQ8L3RkPjx0ZCBiZ2NvbG9yPScjZWVlZWVjJyBhbGlnbj0nY2VudGVyJz4wLjM3MDQ8L3RkPjx0ZCBiZ2NvbG9yPScjZWVlZWVjJyBhbGlnbj0ncmlnaHQnPjgxMjU2ODA8L3RkPjx0ZCBiZ2NvbG9yPScjZWVlZWVjJz5QRE8tPnF1ZXJ5KCA8c3Bhbj48Zm9udCBjb2xvcj0nI2NjMDAwMCc+c3RyaW5nKDcwMyk8L2ZvbnQ+PC9zcGFuPiApPC90ZD48dGQgdGl0bGU9J0M6XHdhbXBcd3d3XHNlYnJhZV9nZWNcYWRtaW5cZnVuY2FvLnBocCcgYmdjb2xvcj0nI2VlZWVlYyc+Li5cZnVuY2FvLnBocDxiPjo8L2I+ODI1PC90ZD48L3RyPgo8dHI+PHRoIGNvbHNwYW49JzUnIGFsaWduPSdsZWZ0JyBiZ2NvbG9yPScjZTliOTZlJz5EdW1wIDxpPiRfR0VUPC9pPjwvdGg+PC90cj4KPHRyPjx0ZCBjb2xzcGFuPScyJyBhbGlnbj0ncmlnaHQnIGJnY29sb3I9JyNlZWVlZWMnIHZhbGlnbj0ndG9wJz48cHJlPiRfR0VUWydwcmVmaXhvJ10mbmJzcDs9PC9wcmU+PC90ZD48dGQgY29sc3Bhbj0nMycgYmdjb2xvcj0nI2VlZWVlYyc+PHByZSBjbGFzcz0neGRlYnVnLXZhci1kdW1wJyBkaXI9J2x0cic+PHNtYWxsPnN0cmluZzwvc21hbGw+IDxmb250IGNvbG9yPScjY2MwMDAwJz4ncmVsYXRvcmlvJzwvZm9udD4gPGk+KGxlbmd0aD05KTwvaT4KPC9wcmU+PC90ZD48L3RyPgo8dHI+PHRkIGNvbHNwYW49JzInIGFsaWduPSdyaWdodCcgYmdjb2xvcj0nI2VlZWVlYycgdmFsaWduPSd0b3AnPjxwcmU+JF9HRVRbJ21lbnUnXSZuYnNwOz08L3ByZT48L3RkPjx0ZCBjb2xzcGFuPSczJyBiZ2NvbG9yPScjZWVlZWVjJz48cHJlIGNsYXNzPSd4ZGVidWctdmFyLWR1bXAnIGRpcj0nbHRyJz48c21hbGw+c3RyaW5nPC9zbWFsbD4gPGZvbnQgY29sb3I9JyNjYzAwMDAnPidyZWxfdXN1YXJpbyc8L2ZvbnQ+IDxpPihsZW5ndGg9MTEpPC9pPgo8L3ByZT48L3RkPjwvdHI+Cjx0cj48dGQgY29sc3Bhbj0nMicgYWxpZ249J3JpZ2h0JyBiZ2NvbG9yPScjZWVlZWVjJyB2YWxpZ249J3RvcCc+PHByZT4kX0dFVFsnY2xhc3MnXSZuYnNwOz08L3ByZT48L3RkPjx0ZCBjb2xzcGFuPSczJyBiZ2NvbG9yPScjZWVlZWVjJz48cHJlIGNsYXNzPSd4ZGVidWctdmFyLWR1bXAnIGRpcj0nbHRyJz48c21hbGw+c3RyaW5nPC9zbWFsbD4gPGZvbnQgY29sb3I9JyNjYzAwMDAnPicwJzwvZm9udD4gPGk+KGxlbmd0aD0xKTwvaT4KPC9wcmU+PC90ZD48L3RyPgo8dHI+PHRoIGNvbHNwYW49JzUnIGFsaWduPSdsZWZ0JyBiZ2NvbG9yPScjZTliOTZlJz5EdW1wIDxpPiRfUE9TVDwvaT48L3RoPjwvdHI+Cjx0cj48dGggY29sc3Bhbj0nNScgYWxpZ249J2xlZnQnIGJnY29sb3I9JyNlOWI5NmUnPkR1bXAgPGk+JF9GSUxFUzwvaT48L3RoPjwvdHI+CgopCiI7'),
 (5,'2015-04-15 13:23:00','lupe','Administrador','127.0.0.1','Lista de Usuários','mysql','42000','SQLSTATE[42000]: Syntax error or access violation: 1064 You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near \'//        scase.classificacao as scase_classificacao,\r\n       //        scase.de\' at line 11','czo2NzEwOiJQRE9FeGNlcHRpb24gT2JqZWN0CigKICAgIFttZXNzYWdlOnByb3RlY3RlZF0gPT4gU1FMU1RBVEVbNDIwMDBdOiBTeW50YXggZXJyb3Igb3IgYWNjZXNzIHZpb2xhdGlvbjogMTA2NCBZb3UgaGF2ZSBhbiBlcnJvciBpbiB5b3VyIFNRTCBzeW50YXg7IGNoZWNrIHRoZSBtYW51YWwgdGhhdCBjb3JyZXNwb25kcyB0byB5b3VyIE15U1FMIHNlcnZlciB2ZXJzaW9uIGZvciB0aGUgcmlnaHQgc3ludGF4IHRvIHVzZSBuZWFyICcvLyAgICAgICAgc2Nhc2UuY2xhc3NpZmljYWNhbyBhcyBzY2FzZV9jbGFzc2lmaWNhY2FvLA0KICAgICAgIC8vICAgICAgICBzY2FzZS5kZScgYXQgbGluZSAxMQogICAgW3N0cmluZzpwcml2YXRlXSA9PiAKICAgIFtjb2RlOnByb3RlY3RlZF0gPT4gNDIwMDAKICAgIFtmaWxlOnByb3RlY3RlZF0gPT4gQzpcd2FtcFx3d3dcc2VicmFlX2dlY1xhZG1pblxmdW5jYW8ucGhwCiAgICBbbGluZTpwcm90ZWN0ZWRdID0+IDgyNQogICAgW3RyYWNlOnByaXZhdGVdID0+IEFycmF5CiAgICAgICAgKAogICAgICAgICAgICBbMF0gPT4gQXJyYXkKICAgICAgICAgICAgICAgICgKICAgICAgICAgICAgICAgICAgICBbZmlsZV0gPT4gQzpcd2FtcFx3d3dcc2VicmFlX2dlY1xhZG1pblxmdW5jYW8ucGhwCiAgICAgICAgICAgICAgICAgICAgW2xpbmVdID0+IDgyNQogICAgICAgICAgICAgICAgICAgIFtmdW5jdGlvbl0gPT4gcXVlcnkKICAgICAgICAgICAgICAgICAgICBbY2xhc3NdID0+IFBETwogICAgICAgICAgICAgICAgICAgIFt0eXBlXSA9PiAtPgogICAgICAgICAgICAgICAgICAgIFthcmdzXSA9PiBBcnJheQogICAgICAgICAgICAgICAgICAgICAgICAoCiAgICAgICAgICAgICAgICAgICAgICAgICAgICBbMF0gPT4gc2VsZWN0DQoNCiAgICAgICAgICAgICAgIHVzLm5vbWVfY29tcGxldG8gYXMgdXNfbm9tZV9jb21wbGV0bywNCiAgICAgICAgICAgICAgIHVzLmxvZ2luIGFzIHVzX2xvZ2luLA0KICAgICAgICAgICAgICAgdXMuYXRpdm8gYXMgdXNfYXRpdm8sDQogICAgICAgICAgICAgICB1cy5hY2Vzc29fb2JyYSBhcyB1c19hY2Vzc29fb2JyYSwNCiAgICAgICAgICAgICAgIHVzLmdlcmVuY2lhZG9yIGFzIHVzX2dlcmVuY2lhZG9yLA0KICAgICAgICAgICAgICAgcGUubm1fcGVyZmlsIGFzIHBlX25tX3BlcmZpbCwNCiAgICAgICAgICAgICAgIHVzLmR0X3ZhbGlkYWRlIGFzIHVzX2R0X3ZhbGlkYWRlLA0KICAgICAgICAgICAgICAgdXMuZW1haWwgYXMgdXNfZW1haWwNCiAgICAgICAvLyAgICAgICAgc2Nhc2UuY2xhc3NpZmljYWNhbyBhcyBzY2FzZV9jbGFzc2lmaWNhY2FvLA0KICAgICAgIC8vICAgICAgICBzY2FzZS5kZXNjcmljYW8gYXMgc2Nhc2VfZGVzY3JpY2FvDQoNCiAgICAgICAgZnJvbSB1c3VhcmlvIGFzIHVzDQoNCiAgICAgLy8gICBsZWZ0ICBqb2luIHNjYV9lc3RydXR1cmEgYXMgc2Nhc2Ugb24gc2Nhc2UuaWR0ID0gIHVzLmlkdF9zZXRvcg0KDQogICAgICAgIGlubmVyIGpvaW4gcGVyZmlsICAgYXMgcGUgb24gdXMuaWRfcGVyZmlsID0gcGUuaWRfcGVyZmlsICBvcmRlciBieSBzY2FzZS5jbGFzc2lmaWNhY2FvLCB1cy5ub21lX2NvbXBsZXRvCiAgICAgICAgICAgICAgICAgICAgICAgICkKCiAgICAgICAgICAgICAgICApCgogICAgICAgICAgICBbMV0gPT4gQXJyYXkKICAgICAgICAgICAgICAgICgKICAgICAgICAgICAgICAgICAgICBbZmlsZV0gPT4gQzpcd2FtcFx3d3dcc2VicmFlX2dlY1xhZG1pblxyZWxhdG9yaW9ccmVsX3VzdWFyaW8ucGhwCiAgICAgICAgICAgICAgICAgICAgW2xpbmVdID0+IDE0NAogICAgICAgICAgICAgICAgICAgIFtmdW5jdGlvbl0gPT4gZXhlY3NxbAogICAgICAgICAgICAgICAgICAgIFthcmdzXSA9PiBBcnJheQogICAgICAgICAgICAgICAgICAgICAgICAoCiAgICAgICAgICAgICAgICAgICAgICAgICAgICBbMF0gPT4gc2VsZWN0DQoNCiAgICAgICAgICAgICAgIHVzLm5vbWVfY29tcGxldG8gYXMgdXNfbm9tZV9jb21wbGV0bywNCiAgICAgICAgICAgICAgIHVzLmxvZ2luIGFzIHVzX2xvZ2luLA0KICAgICAgICAgICAgICAgdXMuYXRpdm8gYXMgdXNfYXRpdm8sDQogICAgICAgICAgICAgICB1cy5hY2Vzc29fb2JyYSBhcyB1c19hY2Vzc29fb2JyYSwNCiAgICAgICAgICAgICAgIHVzLmdlcmVuY2lhZG9yIGFzIHVzX2dlcmVuY2lhZG9yLA0KICAgICAgICAgICAgICAgcGUubm1fcGVyZmlsIGFzIHBlX25tX3BlcmZpbCwNCiAgICAgICAgICAgICAgIHVzLmR0X3ZhbGlkYWRlIGFzIHVzX2R0X3ZhbGlkYWRlLA0KICAgICAgICAgICAgICAgdXMuZW1haWwgYXMgdXNfZW1haWwNCiAgICAgICAvLyAgICAgICAgc2Nhc2UuY2xhc3NpZmljYWNhbyBhcyBzY2FzZV9jbGFzc2lmaWNhY2FvLA0KICAgICAgIC8vICAgICAgICBzY2FzZS5kZXNjcmljYW8gYXMgc2Nhc2VfZGVzY3JpY2FvDQoNCiAgICAgICAgZnJvbSB1c3VhcmlvIGFzIHVzDQoNCiAgICAgLy8gICBsZWZ0ICBqb2luIHNjYV9lc3RydXR1cmEgYXMgc2Nhc2Ugb24gc2Nhc2UuaWR0ID0gIHVzLmlkdF9zZXRvcg0KDQogICAgICAgIGlubmVyIGpvaW4gcGVyZmlsICAgYXMgcGUgb24gdXMuaWRfcGVyZmlsID0gcGUuaWRfcGVyZmlsICBvcmRlciBieSBzY2FzZS5jbGFzc2lmaWNhY2FvLCB1cy5ub21lX2NvbXBsZXRvCiAgICAgICAgICAgICAgICAgICAgICAgICkKCiAgICAgICAgICAgICAgICApCgogICAgICAgICAgICBbMl0gPT4gQXJyYXkKICAgICAgICAgICAgICAgICgKICAgICAgICAgICAgICAgICAgICBbZmlsZV0gPT4gQzpcd2FtcFx3d3dcc2VicmFlX2dlY1xhZG1pblxjb250ZXVkby5waHAKICAgICAgICAgICAgICAgICAgICBbbGluZV0gPT4gMjgzCiAgICAgICAgICAgICAgICAgICAgW2FyZ3NdID0+IEFycmF5CiAgICAgICAgICAgICAgICAgICAgICAgICgKICAgICAgICAgICAgICAgICAgICAgICAgICAgIFswXSA9PiBDOlx3YW1wXHd3d1xzZWJyYWVfZ2VjXGFkbWluXHJlbGF0b3Jpb1xyZWxfdXN1YXJpby5waHAKICAgICAgICAgICAgICAgICAgICAgICAgKQoKICAgICAgICAgICAgICAgICAgICBbZnVuY3Rpb25dID0+IHJlcXVpcmVfb25jZQogICAgICAgICAgICAgICAgKQoKICAgICAgICApCgogICAgW2Vycm9ySW5mb10gPT4gQXJyYXkKICAgICAgICAoCiAgICAgICAgICAgIFswXSA9PiA0MjAwMAogICAgICAgICAgICBbMV0gPT4gMTA2NAogICAgICAgICAgICBbMl0gPT4gWW91IGhhdmUgYW4gZXJyb3IgaW4geW91ciBTUUwgc3ludGF4OyBjaGVjayB0aGUgbWFudWFsIHRoYXQgY29ycmVzcG9uZHMgdG8geW91ciBNeVNRTCBzZXJ2ZXIgdmVyc2lvbiBmb3IgdGhlIHJpZ2h0IHN5bnRheCB0byB1c2UgbmVhciAnLy8gICAgICAgIHNjYXNlLmNsYXNzaWZpY2FjYW8gYXMgc2Nhc2VfY2xhc3NpZmljYWNhbywNCiAgICAgICAvLyAgICAgICAgc2Nhc2UuZGUnIGF0IGxpbmUgMTEKICAgICAgICApCgogICAgW3hkZWJ1Z19tZXNzYWdlXSA9PiA8dHI+PHRoIGFsaWduPSdsZWZ0JyBiZ2NvbG9yPScjZjU3OTAwJyBjb2xzcGFuPSI1Ij48c3BhbiBzdHlsZT0nYmFja2dyb3VuZC1jb2xvcjogI2NjMDAwMDsgY29sb3I6ICNmY2U5NGY7IGZvbnQtc2l6ZTogeC1sYXJnZTsnPiggISApPC9zcGFuPiBQRE9FeGNlcHRpb246IFNRTFNUQVRFWzQyMDAwXTogU3ludGF4IGVycm9yIG9yIGFjY2VzcyB2aW9sYXRpb246IDEwNjQgWW91IGhhdmUgYW4gZXJyb3IgaW4geW91ciBTUUwgc3ludGF4OyBjaGVjayB0aGUgbWFudWFsIHRoYXQgY29ycmVzcG9uZHMgdG8geW91ciBNeVNRTCBzZXJ2ZXIgdmVyc2lvbiBmb3IgdGhlIHJpZ2h0IHN5bnRheCB0byB1c2UgbmVhciAnLy8gICAgICAgIHNjYXNlLmNsYXNzaWZpY2FjYW8gYXMgc2Nhc2VfY2xhc3NpZmljYWNhbywNCiAgICAgICAvLyAgICAgICAgc2Nhc2UuZGUnIGF0IGxpbmUgMTEgaW4gQzpcd2FtcFx3d3dcc2VicmFlX2dlY1xhZG1pblxmdW5jYW8ucGhwIG9uIGxpbmUgPGk+ODI1PC9pPjwvdGg+PC90cj4KPHRyPjx0aCBhbGlnbj0nbGVmdCcgYmdjb2xvcj0nI2U5Yjk2ZScgY29sc3Bhbj0nNSc+Q2FsbCBTdGFjazwvdGg+PC90cj4KPHRyPjx0aCBhbGlnbj0nY2VudGVyJyBiZ2NvbG9yPScjZWVlZWVjJz4jPC90aD48dGggYWxpZ249J2xlZnQnIGJnY29sb3I9JyNlZWVlZWMnPlRpbWU8L3RoPjx0aCBhbGlnbj0nbGVmdCcgYmdjb2xvcj0nI2VlZWVlYyc+TWVtb3J5PC90aD48dGggYWxpZ249J2xlZnQnIGJnY29sb3I9JyNlZWVlZWMnPkZ1bmN0aW9uPC90aD48dGggYWxpZ249J2xlZnQnIGJnY29sb3I9JyNlZWVlZWMnPkxvY2F0aW9uPC90aD48L3RyPgo8dHI+PHRkIGJnY29sb3I9JyNlZWVlZWMnIGFsaWduPSdjZW50ZXInPjE8L3RkPjx0ZCBiZ2NvbG9yPScjZWVlZWVjJyBhbGlnbj0nY2VudGVyJz4wLjAwMzg8L3RkPjx0ZCBiZ2NvbG9yPScjZWVlZWVjJyBhbGlnbj0ncmlnaHQnPjEyNzUyMDwvdGQ+PHRkIGJnY29sb3I9JyNlZWVlZWMnPnttYWlufSggICk8L3RkPjx0ZCB0aXRsZT0nQzpcd2FtcFx3d3dcc2VicmFlX2dlY1xhZG1pblxjb250ZXVkby5waHAnIGJnY29sb3I9JyNlZWVlZWMnPi4uXGNvbnRldWRvLnBocDxiPjo8L2I+MDwvdGQ+PC90cj4KPHRyPjx0ZCBiZ2NvbG9yPScjZWVlZWVjJyBhbGlnbj0nY2VudGVyJz4yPC90ZD48dGQgYmdjb2xvcj0nI2VlZWVlYycgYWxpZ249J2NlbnRlcic+MC4yNzI5PC90ZD48dGQgYmdjb2xvcj0nI2VlZWVlYycgYWxpZ249J3JpZ2h0Jz43MjkyOTYwPC90ZD48dGQgYmdjb2xvcj0nI2VlZWVlYyc+cmVxdWlyZV9vbmNlKCA8Zm9udCBjb2xvcj0nIzAwYmIwMCc+J0M6XHdhbXBcd3d3XHNlYnJhZV9nZWNcYWRtaW5ccmVsYXRvcmlvXHJlbF91c3VhcmlvLnBocCc8L2ZvbnQ+ICk8L3RkPjx0ZCB0aXRsZT0nQzpcd2FtcFx3d3dcc2VicmFlX2dlY1xhZG1pblxjb250ZXVkby5waHAnIGJnY29sb3I9JyNlZWVlZWMnPi4uXGNvbnRldWRvLnBocDxiPjo8L2I+MjgzPC90ZD48L3RyPgo8dHI+PHRkIGJnY29sb3I9JyNlZWVlZWMnIGFsaWduPSdjZW50ZXInPjM8L3RkPjx0ZCBiZ2NvbG9yPScjZWVlZWVjJyBhbGlnbj0nY2VudGVyJz4wLjI5MjA8L3RkPjx0ZCBiZ2NvbG9yPScjZWVlZWVjJyBhbGlnbj0ncmlnaHQnPjgxMTkyNjQ8L3RkPjx0ZCBiZ2NvbG9yPScjZWVlZWVjJz5leGVjc3FsKCA8c3Bhbj48Zm9udCBjb2xvcj0nI2NjMDAwMCc+c3RyaW5nKDcwOCk8L2ZvbnQ+PC9zcGFuPiwgPz8/LCA/Pz8gKTwvdGQ+PHRkIHRpdGxlPSdDOlx3YW1wXHd3d1xzZWJyYWVfZ2VjXGFkbWluXHJlbGF0b3Jpb1xyZWxfdXN1YXJpby5waHAnIGJnY29sb3I9JyNlZWVlZWMnPi4uXHJlbF91c3VhcmlvLnBocDxiPjo8L2I+MTQ0PC90ZD48L3RyPgo8dHI+PHRkIGJnY29sb3I9JyNlZWVlZWMnIGFsaWduPSdjZW50ZXInPjQ8L3RkPjx0ZCBiZ2NvbG9yPScjZWVlZWVjJyBhbGlnbj0nY2VudGVyJz4wLjI5MjM8L3RkPjx0ZCBiZ2NvbG9yPScjZWVlZWVjJyBhbGlnbj0ncmlnaHQnPjgxMjYwODg8L3RkPjx0ZCBiZ2NvbG9yPScjZWVlZWVjJz5QRE8tPnF1ZXJ5KCA8c3Bhbj48Zm9udCBjb2xvcj0nI2NjMDAwMCc+c3RyaW5nKDcwOCk8L2ZvbnQ+PC9zcGFuPiApPC90ZD48dGQgdGl0bGU9J0M6XHdhbXBcd3d3XHNlYnJhZV9nZWNcYWRtaW5cZnVuY2FvLnBocCcgYmdjb2xvcj0nI2VlZWVlYyc+Li5cZnVuY2FvLnBocDxiPjo8L2I+ODI1PC90ZD48L3RyPgo8dHI+PHRoIGNvbHNwYW49JzUnIGFsaWduPSdsZWZ0JyBiZ2NvbG9yPScjZTliOTZlJz5EdW1wIDxpPiRfR0VUPC9pPjwvdGg+PC90cj4KPHRyPjx0ZCBjb2xzcGFuPScyJyBhbGlnbj0ncmlnaHQnIGJnY29sb3I9JyNlZWVlZWMnIHZhbGlnbj0ndG9wJz48cHJlPiRfR0VUWydwcmVmaXhvJ10mbmJzcDs9PC9wcmU+PC90ZD48dGQgY29sc3Bhbj0nMycgYmdjb2xvcj0nI2VlZWVlYyc+PHByZSBjbGFzcz0neGRlYnVnLXZhci1kdW1wJyBkaXI9J2x0cic+PHNtYWxsPnN0cmluZzwvc21hbGw+IDxmb250IGNvbG9yPScjY2MwMDAwJz4ncmVsYXRvcmlvJzwvZm9udD4gPGk+KGxlbmd0aD05KTwvaT4KPC9wcmU+PC90ZD48L3RyPgo8dHI+PHRkIGNvbHNwYW49JzInIGFsaWduPSdyaWdodCcgYmdjb2xvcj0nI2VlZWVlYycgdmFsaWduPSd0b3AnPjxwcmU+JF9HRVRbJ21lbnUnXSZuYnNwOz08L3ByZT48L3RkPjx0ZCBjb2xzcGFuPSczJyBiZ2NvbG9yPScjZWVlZWVjJz48cHJlIGNsYXNzPSd4ZGVidWctdmFyLWR1bXAnIGRpcj0nbHRyJz48c21hbGw+c3RyaW5nPC9zbWFsbD4gPGZvbnQgY29sb3I9JyNjYzAwMDAnPidyZWxfdXN1YXJpbyc8L2ZvbnQ+IDxpPihsZW5ndGg9MTEpPC9pPgo8L3ByZT48L3RkPjwvdHI+Cjx0cj48dGQgY29sc3Bhbj0nMicgYWxpZ249J3JpZ2h0JyBiZ2NvbG9yPScjZWVlZWVjJyB2YWxpZ249J3RvcCc+PHByZT4kX0dFVFsnY2xhc3MnXSZuYnNwOz08L3ByZT48L3RkPjx0ZCBjb2xzcGFuPSczJyBiZ2NvbG9yPScjZWVlZWVjJz48cHJlIGNsYXNzPSd4ZGVidWctdmFyLWR1bXAnIGRpcj0nbHRyJz48c21hbGw+c3RyaW5nPC9zbWFsbD4gPGZvbnQgY29sb3I9JyNjYzAwMDAnPicwJzwvZm9udD4gPGk+KGxlbmd0aD0xKTwvaT4KPC9wcmU+PC90ZD48L3RyPgo8dHI+PHRoIGNvbHNwYW49JzUnIGFsaWduPSdsZWZ0JyBiZ2NvbG9yPScjZTliOTZlJz5EdW1wIDxpPiRfUE9TVDwvaT48L3RoPjwvdHI+Cjx0cj48dGggY29sc3Bhbj0nNScgYWxpZ249J2xlZnQnIGJnY29sb3I9JyNlOWI5NmUnPkR1bXAgPGk+JF9GSUxFUzwvaT48L3RoPjwvdHI+CgopCiI7'),
 (6,'2015-04-15 13:25:00','lupe','Administrador','127.0.0.1','Lista de Usuários','mysql','42000','SQLSTATE[42000]: Syntax error or access violation: 1064 You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near \'//        scase.classificacao as scase_classificacao,\r\n       //        scase.de\' at line 11','czo2NjY4OiJQRE9FeGNlcHRpb24gT2JqZWN0CigKICAgIFttZXNzYWdlOnByb3RlY3RlZF0gPT4gU1FMU1RBVEVbNDIwMDBdOiBTeW50YXggZXJyb3Igb3IgYWNjZXNzIHZpb2xhdGlvbjogMTA2NCBZb3UgaGF2ZSBhbiBlcnJvciBpbiB5b3VyIFNRTCBzeW50YXg7IGNoZWNrIHRoZSBtYW51YWwgdGhhdCBjb3JyZXNwb25kcyB0byB5b3VyIE15U1FMIHNlcnZlciB2ZXJzaW9uIGZvciB0aGUgcmlnaHQgc3ludGF4IHRvIHVzZSBuZWFyICcvLyAgICAgICAgc2Nhc2UuY2xhc3NpZmljYWNhbyBhcyBzY2FzZV9jbGFzc2lmaWNhY2FvLA0KICAgICAgIC8vICAgICAgICBzY2FzZS5kZScgYXQgbGluZSAxMQogICAgW3N0cmluZzpwcml2YXRlXSA9PiAKICAgIFtjb2RlOnByb3RlY3RlZF0gPT4gNDIwMDAKICAgIFtmaWxlOnByb3RlY3RlZF0gPT4gQzpcd2FtcFx3d3dcc2VicmFlX2dlY1xhZG1pblxmdW5jYW8ucGhwCiAgICBbbGluZTpwcm90ZWN0ZWRdID0+IDgyNQogICAgW3RyYWNlOnByaXZhdGVdID0+IEFycmF5CiAgICAgICAgKAogICAgICAgICAgICBbMF0gPT4gQXJyYXkKICAgICAgICAgICAgICAgICgKICAgICAgICAgICAgICAgICAgICBbZmlsZV0gPT4gQzpcd2FtcFx3d3dcc2VicmFlX2dlY1xhZG1pblxmdW5jYW8ucGhwCiAgICAgICAgICAgICAgICAgICAgW2xpbmVdID0+IDgyNQogICAgICAgICAgICAgICAgICAgIFtmdW5jdGlvbl0gPT4gcXVlcnkKICAgICAgICAgICAgICAgICAgICBbY2xhc3NdID0+IFBETwogICAgICAgICAgICAgICAgICAgIFt0eXBlXSA9PiAtPgogICAgICAgICAgICAgICAgICAgIFthcmdzXSA9PiBBcnJheQogICAgICAgICAgICAgICAgICAgICAgICAoCiAgICAgICAgICAgICAgICAgICAgICAgICAgICBbMF0gPT4gc2VsZWN0DQoNCiAgICAgICAgICAgICAgIHVzLm5vbWVfY29tcGxldG8gYXMgdXNfbm9tZV9jb21wbGV0bywNCiAgICAgICAgICAgICAgIHVzLmxvZ2luIGFzIHVzX2xvZ2luLA0KICAgICAgICAgICAgICAgdXMuYXRpdm8gYXMgdXNfYXRpdm8sDQogICAgICAgICAgICAgICB1cy5hY2Vzc29fb2JyYSBhcyB1c19hY2Vzc29fb2JyYSwNCiAgICAgICAgICAgICAgIHVzLmdlcmVuY2lhZG9yIGFzIHVzX2dlcmVuY2lhZG9yLA0KICAgICAgICAgICAgICAgcGUubm1fcGVyZmlsIGFzIHBlX25tX3BlcmZpbCwNCiAgICAgICAgICAgICAgIHVzLmR0X3ZhbGlkYWRlIGFzIHVzX2R0X3ZhbGlkYWRlLA0KICAgICAgICAgICAgICAgdXMuZW1haWwgYXMgdXNfZW1haWwNCiAgICAgICAvLyAgICAgICAgc2Nhc2UuY2xhc3NpZmljYWNhbyBhcyBzY2FzZV9jbGFzc2lmaWNhY2FvLA0KICAgICAgIC8vICAgICAgICBzY2FzZS5kZXNjcmljYW8gYXMgc2Nhc2VfZGVzY3JpY2FvDQoNCiAgICAgICAgZnJvbSB1c3VhcmlvIGFzIHVzDQoNCiAgICAgLy8gICBsZWZ0ICBqb2luIHNjYV9lc3RydXR1cmEgYXMgc2Nhc2Ugb24gc2Nhc2UuaWR0ID0gIHVzLmlkdF9zZXRvcg0KDQogICAgICAgIGlubmVyIGpvaW4gcGVyZmlsICAgYXMgcGUgb24gdXMuaWRfcGVyZmlsID0gcGUuaWRfcGVyZmlsICBvcmRlciBieSB1cy5ub21lX2NvbXBsZXRvCiAgICAgICAgICAgICAgICAgICAgICAgICkKCiAgICAgICAgICAgICAgICApCgogICAgICAgICAgICBbMV0gPT4gQXJyYXkKICAgICAgICAgICAgICAgICgKICAgICAgICAgICAgICAgICAgICBbZmlsZV0gPT4gQzpcd2FtcFx3d3dcc2VicmFlX2dlY1xhZG1pblxyZWxhdG9yaW9ccmVsX3VzdWFyaW8ucGhwCiAgICAgICAgICAgICAgICAgICAgW2xpbmVdID0+IDE1NgogICAgICAgICAgICAgICAgICAgIFtmdW5jdGlvbl0gPT4gZXhlY3NxbAogICAgICAgICAgICAgICAgICAgIFthcmdzXSA9PiBBcnJheQogICAgICAgICAgICAgICAgICAgICAgICAoCiAgICAgICAgICAgICAgICAgICAgICAgICAgICBbMF0gPT4gc2VsZWN0DQoNCiAgICAgICAgICAgICAgIHVzLm5vbWVfY29tcGxldG8gYXMgdXNfbm9tZV9jb21wbGV0bywNCiAgICAgICAgICAgICAgIHVzLmxvZ2luIGFzIHVzX2xvZ2luLA0KICAgICAgICAgICAgICAgdXMuYXRpdm8gYXMgdXNfYXRpdm8sDQogICAgICAgICAgICAgICB1cy5hY2Vzc29fb2JyYSBhcyB1c19hY2Vzc29fb2JyYSwNCiAgICAgICAgICAgICAgIHVzLmdlcmVuY2lhZG9yIGFzIHVzX2dlcmVuY2lhZG9yLA0KICAgICAgICAgICAgICAgcGUubm1fcGVyZmlsIGFzIHBlX25tX3BlcmZpbCwNCiAgICAgICAgICAgICAgIHVzLmR0X3ZhbGlkYWRlIGFzIHVzX2R0X3ZhbGlkYWRlLA0KICAgICAgICAgICAgICAgdXMuZW1haWwgYXMgdXNfZW1haWwNCiAgICAgICAvLyAgICAgICAgc2Nhc2UuY2xhc3NpZmljYWNhbyBhcyBzY2FzZV9jbGFzc2lmaWNhY2FvLA0KICAgICAgIC8vICAgICAgICBzY2FzZS5kZXNjcmljYW8gYXMgc2Nhc2VfZGVzY3JpY2FvDQoNCiAgICAgICAgZnJvbSB1c3VhcmlvIGFzIHVzDQoNCiAgICAgLy8gICBsZWZ0ICBqb2luIHNjYV9lc3RydXR1cmEgYXMgc2Nhc2Ugb24gc2Nhc2UuaWR0ID0gIHVzLmlkdF9zZXRvcg0KDQogICAgICAgIGlubmVyIGpvaW4gcGVyZmlsICAgYXMgcGUgb24gdXMuaWRfcGVyZmlsID0gcGUuaWRfcGVyZmlsICBvcmRlciBieSB1cy5ub21lX2NvbXBsZXRvCiAgICAgICAgICAgICAgICAgICAgICAgICkKCiAgICAgICAgICAgICAgICApCgogICAgICAgICAgICBbMl0gPT4gQXJyYXkKICAgICAgICAgICAgICAgICgKICAgICAgICAgICAgICAgICAgICBbZmlsZV0gPT4gQzpcd2FtcFx3d3dcc2VicmFlX2dlY1xhZG1pblxjb250ZXVkby5waHAKICAgICAgICAgICAgICAgICAgICBbbGluZV0gPT4gMjgzCiAgICAgICAgICAgICAgICAgICAgW2FyZ3NdID0+IEFycmF5CiAgICAgICAgICAgICAgICAgICAgICAgICgKICAgICAgICAgICAgICAgICAgICAgICAgICAgIFswXSA9PiBDOlx3YW1wXHd3d1xzZWJyYWVfZ2VjXGFkbWluXHJlbGF0b3Jpb1xyZWxfdXN1YXJpby5waHAKICAgICAgICAgICAgICAgICAgICAgICAgKQoKICAgICAgICAgICAgICAgICAgICBbZnVuY3Rpb25dID0+IHJlcXVpcmVfb25jZQogICAgICAgICAgICAgICAgKQoKICAgICAgICApCgogICAgW2Vycm9ySW5mb10gPT4gQXJyYXkKICAgICAgICAoCiAgICAgICAgICAgIFswXSA9PiA0MjAwMAogICAgICAgICAgICBbMV0gPT4gMTA2NAogICAgICAgICAgICBbMl0gPT4gWW91IGhhdmUgYW4gZXJyb3IgaW4geW91ciBTUUwgc3ludGF4OyBjaGVjayB0aGUgbWFudWFsIHRoYXQgY29ycmVzcG9uZHMgdG8geW91ciBNeVNRTCBzZXJ2ZXIgdmVyc2lvbiBmb3IgdGhlIHJpZ2h0IHN5bnRheCB0byB1c2UgbmVhciAnLy8gICAgICAgIHNjYXNlLmNsYXNzaWZpY2FjYW8gYXMgc2Nhc2VfY2xhc3NpZmljYWNhbywNCiAgICAgICAvLyAgICAgICAgc2Nhc2UuZGUnIGF0IGxpbmUgMTEKICAgICAgICApCgogICAgW3hkZWJ1Z19tZXNzYWdlXSA9PiA8dHI+PHRoIGFsaWduPSdsZWZ0JyBiZ2NvbG9yPScjZjU3OTAwJyBjb2xzcGFuPSI1Ij48c3BhbiBzdHlsZT0nYmFja2dyb3VuZC1jb2xvcjogI2NjMDAwMDsgY29sb3I6ICNmY2U5NGY7IGZvbnQtc2l6ZTogeC1sYXJnZTsnPiggISApPC9zcGFuPiBQRE9FeGNlcHRpb246IFNRTFNUQVRFWzQyMDAwXTogU3ludGF4IGVycm9yIG9yIGFjY2VzcyB2aW9sYXRpb246IDEwNjQgWW91IGhhdmUgYW4gZXJyb3IgaW4geW91ciBTUUwgc3ludGF4OyBjaGVjayB0aGUgbWFudWFsIHRoYXQgY29ycmVzcG9uZHMgdG8geW91ciBNeVNRTCBzZXJ2ZXIgdmVyc2lvbiBmb3IgdGhlIHJpZ2h0IHN5bnRheCB0byB1c2UgbmVhciAnLy8gICAgICAgIHNjYXNlLmNsYXNzaWZpY2FjYW8gYXMgc2Nhc2VfY2xhc3NpZmljYWNhbywNCiAgICAgICAvLyAgICAgICAgc2Nhc2UuZGUnIGF0IGxpbmUgMTEgaW4gQzpcd2FtcFx3d3dcc2VicmFlX2dlY1xhZG1pblxmdW5jYW8ucGhwIG9uIGxpbmUgPGk+ODI1PC9pPjwvdGg+PC90cj4KPHRyPjx0aCBhbGlnbj0nbGVmdCcgYmdjb2xvcj0nI2U5Yjk2ZScgY29sc3Bhbj0nNSc+Q2FsbCBTdGFjazwvdGg+PC90cj4KPHRyPjx0aCBhbGlnbj0nY2VudGVyJyBiZ2NvbG9yPScjZWVlZWVjJz4jPC90aD48dGggYWxpZ249J2xlZnQnIGJnY29sb3I9JyNlZWVlZWMnPlRpbWU8L3RoPjx0aCBhbGlnbj0nbGVmdCcgYmdjb2xvcj0nI2VlZWVlYyc+TWVtb3J5PC90aD48dGggYWxpZ249J2xlZnQnIGJnY29sb3I9JyNlZWVlZWMnPkZ1bmN0aW9uPC90aD48dGggYWxpZ249J2xlZnQnIGJnY29sb3I9JyNlZWVlZWMnPkxvY2F0aW9uPC90aD48L3RyPgo8dHI+PHRkIGJnY29sb3I9JyNlZWVlZWMnIGFsaWduPSdjZW50ZXInPjE8L3RkPjx0ZCBiZ2NvbG9yPScjZWVlZWVjJyBhbGlnbj0nY2VudGVyJz4wLjAwMzY8L3RkPjx0ZCBiZ2NvbG9yPScjZWVlZWVjJyBhbGlnbj0ncmlnaHQnPjEyNzUyMDwvdGQ+PHRkIGJnY29sb3I9JyNlZWVlZWMnPnttYWlufSggICk8L3RkPjx0ZCB0aXRsZT0nQzpcd2FtcFx3d3dcc2VicmFlX2dlY1xhZG1pblxjb250ZXVkby5waHAnIGJnY29sb3I9JyNlZWVlZWMnPi4uXGNvbnRldWRvLnBocDxiPjo8L2I+MDwvdGQ+PC90cj4KPHRyPjx0ZCBiZ2NvbG9yPScjZWVlZWVjJyBhbGlnbj0nY2VudGVyJz4yPC90ZD48dGQgYmdjb2xvcj0nI2VlZWVlYycgYWxpZ249J2NlbnRlcic+MC4yODQ4PC90ZD48dGQgYmdjb2xvcj0nI2VlZWVlYycgYWxpZ249J3JpZ2h0Jz43MjkyODY0PC90ZD48dGQgYmdjb2xvcj0nI2VlZWVlYyc+cmVxdWlyZV9vbmNlKCA8Zm9udCBjb2xvcj0nIzAwYmIwMCc+J0M6XHdhbXBcd3d3XHNlYnJhZV9nZWNcYWRtaW5ccmVsYXRvcmlvXHJlbF91c3VhcmlvLnBocCc8L2ZvbnQ+ICk8L3RkPjx0ZCB0aXRsZT0nQzpcd2FtcFx3d3dcc2VicmFlX2dlY1xhZG1pblxjb250ZXVkby5waHAnIGJnY29sb3I9JyNlZWVlZWMnPi4uXGNvbnRldWRvLnBocDxiPjo8L2I+MjgzPC90ZD48L3RyPgo8dHI+PHRkIGJnY29sb3I9JyNlZWVlZWMnIGFsaWduPSdjZW50ZXInPjM8L3RkPjx0ZCBiZ2NvbG9yPScjZWVlZWVjJyBhbGlnbj0nY2VudGVyJz4wLjMwMjA8L3RkPjx0ZCBiZ2NvbG9yPScjZWVlZWVjJyBhbGlnbj0ncmlnaHQnPjgxMTg0NjQ8L3RkPjx0ZCBiZ2NvbG9yPScjZWVlZWVjJz5leGVjc3FsKCA8c3Bhbj48Zm9udCBjb2xvcj0nI2NjMDAwMCc+c3RyaW5nKDY4Nyk8L2ZvbnQ+PC9zcGFuPiwgPz8/LCA/Pz8gKTwvdGQ+PHRkIHRpdGxlPSdDOlx3YW1wXHd3d1xzZWJyYWVfZ2VjXGFkbWluXHJlbGF0b3Jpb1xyZWxfdXN1YXJpby5waHAnIGJnY29sb3I9JyNlZWVlZWMnPi4uXHJlbF91c3VhcmlvLnBocDxiPjo8L2I+MTU2PC90ZD48L3RyPgo8dHI+PHRkIGJnY29sb3I9JyNlZWVlZWMnIGFsaWduPSdjZW50ZXInPjQ8L3RkPjx0ZCBiZ2NvbG9yPScjZWVlZWVjJyBhbGlnbj0nY2VudGVyJz4wLjMwMjM8L3RkPjx0ZCBiZ2NvbG9yPScjZWVlZWVjJyBhbGlnbj0ncmlnaHQnPjgxMjUyNjQ8L3RkPjx0ZCBiZ2NvbG9yPScjZWVlZWVjJz5QRE8tPnF1ZXJ5KCA8c3Bhbj48Zm9udCBjb2xvcj0nI2NjMDAwMCc+c3RyaW5nKDY4Nyk8L2ZvbnQ+PC9zcGFuPiApPC90ZD48dGQgdGl0bGU9J0M6XHdhbXBcd3d3XHNlYnJhZV9nZWNcYWRtaW5cZnVuY2FvLnBocCcgYmdjb2xvcj0nI2VlZWVlYyc+Li5cZnVuY2FvLnBocDxiPjo8L2I+ODI1PC90ZD48L3RyPgo8dHI+PHRoIGNvbHNwYW49JzUnIGFsaWduPSdsZWZ0JyBiZ2NvbG9yPScjZTliOTZlJz5EdW1wIDxpPiRfR0VUPC9pPjwvdGg+PC90cj4KPHRyPjx0ZCBjb2xzcGFuPScyJyBhbGlnbj0ncmlnaHQnIGJnY29sb3I9JyNlZWVlZWMnIHZhbGlnbj0ndG9wJz48cHJlPiRfR0VUWydwcmVmaXhvJ10mbmJzcDs9PC9wcmU+PC90ZD48dGQgY29sc3Bhbj0nMycgYmdjb2xvcj0nI2VlZWVlYyc+PHByZSBjbGFzcz0neGRlYnVnLXZhci1kdW1wJyBkaXI9J2x0cic+PHNtYWxsPnN0cmluZzwvc21hbGw+IDxmb250IGNvbG9yPScjY2MwMDAwJz4ncmVsYXRvcmlvJzwvZm9udD4gPGk+KGxlbmd0aD05KTwvaT4KPC9wcmU+PC90ZD48L3RyPgo8dHI+PHRkIGNvbHNwYW49JzInIGFsaWduPSdyaWdodCcgYmdjb2xvcj0nI2VlZWVlYycgdmFsaWduPSd0b3AnPjxwcmU+JF9HRVRbJ21lbnUnXSZuYnNwOz08L3ByZT48L3RkPjx0ZCBjb2xzcGFuPSczJyBiZ2NvbG9yPScjZWVlZWVjJz48cHJlIGNsYXNzPSd4ZGVidWctdmFyLWR1bXAnIGRpcj0nbHRyJz48c21hbGw+c3RyaW5nPC9zbWFsbD4gPGZvbnQgY29sb3I9JyNjYzAwMDAnPidyZWxfdXN1YXJpbyc8L2ZvbnQ+IDxpPihsZW5ndGg9MTEpPC9pPgo8L3ByZT48L3RkPjwvdHI+Cjx0cj48dGQgY29sc3Bhbj0nMicgYWxpZ249J3JpZ2h0JyBiZ2NvbG9yPScjZWVlZWVjJyB2YWxpZ249J3RvcCc+PHByZT4kX0dFVFsnY2xhc3MnXSZuYnNwOz08L3ByZT48L3RkPjx0ZCBjb2xzcGFuPSczJyBiZ2NvbG9yPScjZWVlZWVjJz48cHJlIGNsYXNzPSd4ZGVidWctdmFyLWR1bXAnIGRpcj0nbHRyJz48c21hbGw+c3RyaW5nPC9zbWFsbD4gPGZvbnQgY29sb3I9JyNjYzAwMDAnPicwJzwvZm9udD4gPGk+KGxlbmd0aD0xKTwvaT4KPC9wcmU+PC90ZD48L3RyPgo8dHI+PHRoIGNvbHNwYW49JzUnIGFsaWduPSdsZWZ0JyBiZ2NvbG9yPScjZTliOTZlJz5EdW1wIDxpPiRfUE9TVDwvaT48L3RoPjwvdHI+Cjx0cj48dGggY29sc3Bhbj0nNScgYWxpZ249J2xlZnQnIGJnY29sb3I9JyNlOWI5NmUnPkR1bXAgPGk+JF9GSUxFUzwvaT48L3RoPjwvdHI+CgopCiI7');
/*!40000 ALTER TABLE `erro_log` ENABLE KEYS */;


--
-- Definition of table `erro_msg`
--

DROP TABLE IF EXISTS `erro_msg`;
CREATE TABLE `erro_msg` (
  `idt` int(11) NOT NULL AUTO_INCREMENT COMMENT 'IdentificaÃ§Ã£o Ãºnica, sequencial de uma mensagem de erro.',
  `data` datetime NOT NULL COMMENT 'Data em que ocorreu a Mensagem',
  `origem_msg` varchar(10) NOT NULL COMMENT 'Origem da mensagem',
  `num_erro` varchar(50) NOT NULL COMMENT 'NÃºmero interno do erro',
  `msg_erro` longtext NOT NULL COMMENT 'Mensagem de erro - interno',
  `msg_usuario` longtext NOT NULL COMMENT 'Mensagem traduzida pelo UsuÃ¡rio (administrador do Sistema)',
  PRIMARY KEY (`idt`),
  UNIQUE KEY `un_erro_msg` (`origem_msg`,`num_erro`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1 COMMENT='Mensagens de ERROS';

--
-- Dumping data for table `erro_msg`
--

/*!40000 ALTER TABLE `erro_msg` DISABLE KEYS */;
INSERT INTO `erro_msg` (`idt`,`data`,`origem_msg`,`num_erro`,`msg_erro`,`msg_usuario`) VALUES 
 (1,'2015-04-03 13:11:00','sqlsrv','42000','SQLSTATE[42000]: [Microsoft][ODBC Driver 11 for SQL Server][SQL Server]Itens ORDER BY devem aparecer na lista de seleção se SELECT DISTINCT for especificado.','Erro de ESCRITA DE INSTRUÇÃO EM SQL.\r\n POR FAVOR, ENTRE EM CONTATO IMEDIATO COM O ADMINISTRADOR DO SISTEMA.'),
 (2,'2015-04-01 01:35:00','sqlsrv','23000','SQLSTATE[23000]: [Microsoft][ODBC Driver 11 for SQL Server][SQL Server]Não é possível inserir uma linha de chave duplicada no objeto \'dbo.sca_sistema\' com índice exclusivo \'iu_sca_sistema_codigo\'.','Erro de TENTATIVA DE INSERIR UMA CHAVE ÚNICA QUE JÁ EXISTE NA TABELA.\r\n POR FAVOR, ENTRE EM CONTATO IMEDIATO COM O ADMINISTRADOR DO SISTEMA.'),
 (3,'2015-04-01 19:10:00','sqlsrv','42S02','SQLSTATE[42S02]: [Microsoft][ODBC Driver 11 for SQL Server][SQL Server]Nome de objeto \'setor\' inválido.','Erro de INEXISTÊNCIA DO OBJETO (TABELA, INDICE ETC) NA BASE DE DADOS.\r\n POR FAVOR, ENTRE EM CONTATO IMEDIATO COM O ADMINISTRADOR DO SISTEMA.'),
 (4,'2015-04-02 15:05:00','sqlsrv','42S22','SQLSTATE[42S22]: [Microsoft][ODBC Driver 11 for SQL Server][SQL Server]Nome de coluna \'hint\' inválido.','Erro de INSTRUÇÃO EM SQL.\r\n POR FAVOR, ENTRE EM CONTATO IMEDIATO COM O ADMINISTRADOR DO SISTEMA.'),
 (5,'2015-04-10 11:18:00','mysql','23000','SQLSTATE[23000]: Integrity constraint violation: 1048 Column \'idt_modulo\' cannot be null','Erro tentando incluir um registro COM A CHAVE UNICA INVÁLIDA.\r\nENTRE EM CONTATO IMEDIATO COM O ADMINISTRADOR DO SISTEMA.'),
 (6,'2015-04-15 13:25:00','mysql','42000','SQLSTATE[42000]: Syntax error or access violation: 1064 You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near \'//        scase.classificacao as scase_classificacao,\r\n       //        scase.de\' at line 11','Erro de ESCRITA DE COMANDO EM SQL..\r\n POR FAVOR, ENTRE EM CONTATO IMEDIATO COM O ADMINISTRADOR DO SISTEMA.'),
 (7,'2015-04-15 13:21:00','mysql','42S02','SQLSTATE[42S02]: Base table or view not found: 1146 Table \'db_gec.sca_estrutura\' doesn\'t exist','Erro grave.\r\n POR FAVOR, ENTRE EM CONTATO IMEDIATO COM O ADMINISTRADOR DO SISTEMA.'),
 (8,'2015-04-10 20:59:00','mysql','42S22','SQLSTATE[42S22]: Column not found: 1054 Unknown column \'plu_pl_req.idt_requisito\' in \'on clause\'','Erro de ESCRITA DE INSTRUÇÃO EM SQL.\r\n POR FAVOR, ENTRE EM CONTATO IMEDIATO COM O ADMINISTRADOR DO SISTEMA.'),
 (9,'2015-04-07 08:13:00','mysql','HY000','SQLSTATE[HY000]: General error: 1451 Cannot delete or update a parent row: a foreign key constraint fails (`db_sebrae_login`.`usuario`, CONSTRAINT `usuario_ibfk_3` FOREIGN KEY (`idt_cargo`) REFERENCES `sca_organizacao_cargo` (`idt`))','Erro de Relacionamento entre Tabelas do Sistema. ESSA OPERAÇÃO NÃO PODE SER REALIZADA.\r\n POR FAVOR, ENTRE EM CONTATO IMEDIATO COM O ADMINISTRADOR DO SISTEMA.'),
 (10,'2015-04-07 09:26:00','mysql','21S01','SQLSTATE[21S01]: Insert value list does not match column list: 1136 Column count doesn\'t match value count at row 1','Erro tentando incluir um registro em Tabela porém o comando de INSERT esta com problemas de Escrita. POR FAVOR, ENTRE EM CONTATO IMEDIATO COM O ADMINISTRADOR DO SISTEMA.');
/*!40000 ALTER TABLE `erro_msg` ENABLE KEYS */;


--
-- Definition of table `estado`
--

DROP TABLE IF EXISTS `estado`;
CREATE TABLE `estado` (
  `idt` int(11) NOT NULL AUTO_INCREMENT,
  `codigo` varchar(2) NOT NULL,
  `descricao` varchar(120) NOT NULL,
  `ordem` varchar(3) DEFAULT NULL,
  `imagem` varchar(120) DEFAULT NULL,
  `poligono` longtext,
  `pos_sigla` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`idt`),
  UNIQUE KEY `estado_descricao` (`descricao`),
  UNIQUE KEY `iu_estado_codigo` (`codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `estado`
--

/*!40000 ALTER TABLE `estado` DISABLE KEYS */;
INSERT INTO `estado` (`idt`,`codigo`,`descricao`,`ordem`,`imagem`,`poligono`,`pos_sigla`) VALUES 
 (1,'AC','Acre','000',NULL,'2,135,3,136,7,136,10,137,13,137,15,137,18,138,21,138,23,138,25,138,29,138,31,139,35,141,37,141,40,141,44,142,46,142,48,143,51,144,54,145,59,146,63,147,66,148,64,152,60,154,57,155,54,158,50,160,46,161,42,161,36,160,34,158,34,155,34,151,31,151,28,151,27,153,24,154,24,154,21,154,17,154,16,152,14,151,12,152,11,153,9,152,8,150,8,148,7,147,6,146,4,144,3,142,3,141','25,142'),
 (2,'AL','Alagoas','999',NULL,'329,122,332,121,335,122,338,122,340,121,343,121,347,119,346,122,345,125,344,128,342,130,339,128,335,127,330,126,329,124','348,124'),
 (3,'AP','Amapá','999',NULL,NULL,NULL),
 (4,'AM','Amazonas','999',NULL,NULL,NULL),
 (5,'BA','Bahia','001','5_imagem_ba.jpg','309,204,308,199,311,196,312,191,311,186,308,182,304,181,301,181,299,179,296,177,293,175,289,173,287,172,281,171,276,170,273,168,269,171,265,172,263,174,261,176,258,174,261,170,259,167,257,163,257,159,257,153,256,149,253,147,253,145,256,143,256,139,259,138,262,140,265,141,269,141,272,139,275,138,279,133,279,130,281,127,284,126,288,127,290,126,293,126,295,125,297,124,300,124,304,125,308,125,310,123,315,121,316,118,319,120,322,123,324,126,327,130,330,132,326,134,326,136,326,139,326,142,328,144,328,147,327,150,326,153,323,155,320,154,318,156,317,158,318,162,318,166,317,171,317,175,318,178,317,182,317,186,318,189,318,192,318,195,316,198,314,200,313,204','290,140'),
 (6,'CE','Ceará','999',NULL,NULL,NULL),
 (7,'DF','Distrito Federal','999',NULL,'235,186,238,186,242,186,241,193,233,192,234,196','229,186'),
 (8,'ES','Espirito Santo','999',NULL,'300,236,304,235,306,231,306,225,309,221,312,217,312,213,311,209,307,206,304,207,301,221,299,230','313,221'),
 (9,'GO','Goiás','999',NULL,'246,186,248,183,249,180,250,176,255,173,253,167,253,164,251,159,247,159,243,160,240,160,238,158,235,158,230,160,228,160,224,160,221,162,220,161,220,164,217,168,217,171,215,171,215,174,215,178,214,182,210,184,209,186,208,193,204,198,200,202,198,205,201,210,203,213,207,215,210,216,213,218,218,214,221,211,227,209,233,207,239,206,244,203,245,197,243,195,241,194,239,194,235,193,235,189,234,186,237,185,241,186,243,188','220,171'),
 (10,'MA','Maranho','999',NULL,NULL,NULL),
 (11,'MT','Mato Grosso','999',NULL,NULL,NULL),
 (12,'MS','Mato Grosso do Sul','999',NULL,NULL,NULL),
 (13,'MG','Minas Gerais','999',NULL,'305,201,306,196,308,189,305,185,298,183,293,180,287,177,279,174,273,173,268,174,265,177,260,179,255,177,253,181,253,185,250,188,247,191,248,195,249,200,250,206,245,209,237,211,229,214,223,214,218,221,218,225,222,224,226,224,230,224,235,226,239,225,244,225,249,224,252,226,252,230,253,235,255,239,255,242,256,246,260,247,265,246,270,246,275,243,279,242,283,240,287,238,291,234,295,230,297,226,298,221,300,216,300,213,301,208','262,207'),
 (14,'PA','Pará','999',NULL,NULL,NULL),
 (15,'PB','Paraba','999',NULL,NULL,NULL),
 (16,'PR','Paraná','999',NULL,'239,282,239,279,240,273,237,272,232,269,231,265,226,262,224,256,222,256,218,256,213,256,209,255,203,253,198,257,195,259,193,260,191,266,192,273,192,280,197,284,207,286,214,287,221,285,227,283,234,284,238,283,238,278','203,267'),
 (17,'PE','Pernambuco','999',NULL,NULL,NULL),
 (18,'PI','Piau','999',NULL,NULL,NULL),
 (19,'RJ','Rio de Janeiro','999',NULL,'272,255,278,253,282,252,286,252,290,252,294,248,296,247,299,244,301,240,298,239,295,237,292,240,288,242,285,243,283,244,277,246,274,250,273,254','288,254'),
 (20,'RN','Rio Grande do Norte','999',NULL,NULL,NULL),
 (21,'RS','Rio Grande do Sul','999',NULL,'206,355,209,353,210,349,210,344,212,340,213,335,214,333,215,331,216,326,219,322,223,323,225,327,223,330,225,324,228,317,228,313,226,309,223,308,220,304,218,301,213,299,208,301,204,300,201,299,197,299,192,301,186,308,183,310,179,314,176,318,175,323,180,327,183,334,190,335,193,338,198,342,200,344,203,347,206,348,206,354','195,309'),
 (22,'RO','Rondnia','999',NULL,NULL,NULL),
 (23,'RR','Roraima','999',NULL,NULL,NULL),
 (24,'SC','Santa Catarina','999',NULL,'232,313,234,308,238,304,237,298,237,293,238,290,239,286,233,286,230,287,226,287,222,287,218,289,211,291,207,291,203,291,200,290,199,295,205,296,210,296,218,296,223,302,222,302,224,306,229,307,230,312','220,289'),
 (25,'SP','São Paulo','002','25_imagem_sp.jpg','243,271,238,269,233,266,232,261,228,256,222,253,217,252,207,252,207,248,210,247,211,243,212,238,214,233,215,229,219,228,224,227,228,228,231,229,235,229,238,229,241,228,246,228,249,229,249,233,249,237,251,240,252,244,253,250,259,250,267,250,271,250,267,253,266,256,258,259,251,266','230,240'),
 (26,'SE','Sergipe','999',NULL,'332,140,334,138,337,135,338,133,337,131,332,130,332,132,331,136,329,136,329,140,332,142,330,142,331,139','337,138'),
 (27,'TO','Tocantins','999',NULL,NULL,NULL);
/*!40000 ALTER TABLE `estado` ENABLE KEYS */;


--
-- Definition of table `funcao`
--

DROP TABLE IF EXISTS `funcao`;
CREATE TABLE `funcao` (
  `id_funcao` int(11) NOT NULL AUTO_INCREMENT COMMENT 'IdentificaÃ§Ã£o Ãºnica, sequencial de uma funÃ§Ã£o.',
  `cod_funcao` varchar(50) NOT NULL COMMENT 'CÃ³digo da funÃ§Ã£o',
  `nm_funcao` varchar(100) NOT NULL COMMENT 'Nome da FunÃ§Ã£o (DescriÃ§Ã£o)',
  `cod_classificacao` varchar(200) NOT NULL COMMENT 'CÃ³digo de ClassificaÃ§Ã£o da FunÃ§Ã£o.',
  `sts_menu` char(1) NOT NULL COMMENT 'Indicador para aparecer ou nÃ£o no MENU',
  `sts_linha` char(1) NOT NULL COMMENT 'Indicador para criar linha separadora apÃ³s.',
  `des_prefixo` varchar(40) NOT NULL COMMENT 'Indicador de prefixo - como serÃ¡ chamado para execuÃ§Ã£o.',
  `imagem` varchar(120) DEFAULT NULL,
  `coluna` int(11) DEFAULT NULL,
  `linha` int(11) DEFAULT NULL,
  `texto_cab` varchar(50) DEFAULT NULL,
  `detalhe` text,
  `visivel` char(1) DEFAULT NULL,
  `grupo_classe` varchar(50) DEFAULT NULL,
  `hint` text,
  `painel` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id_funcao`),
  UNIQUE KEY `unpk_funcao_2` (`cod_funcao`),
  UNIQUE KEY `unpk_funcao_3` (`cod_classificacao`)
) ENGINE=InnoDB AUTO_INCREMENT=379 DEFAULT CHARSET=latin1 COMMENT='Funções do Sistema (MENU)';

--
-- Dumping data for table `funcao`
--

/*!40000 ALTER TABLE `funcao` DISABLE KEYS */;
INSERT INTO `funcao` (`id_funcao`,`cod_funcao`,`nm_funcao`,`cod_classificacao`,`sts_menu`,`sts_linha`,`des_prefixo`,`imagem`,`coluna`,`linha`,`texto_cab`,`detalhe`,`visivel`,`grupo_classe`,`hint`,`painel`) VALUES 
 (1,'direito','Direito','80.05.05','S','N','listar',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
 (2,'funcao','Função','80.05.07','S','N','listar','2_imagem_transacao.png',6,3,'Transação',NULL,'S',NULL,NULL,'01.05'),
 (3,'seguranca','Segurança - GC ','80.05','S','N','listar',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
 (4,'usuario','Cadastro','50.03','S','N','listar','4_imagem_usuarios.png',6,1,'Usuário',NULL,'S',NULL,NULL,'01.04'),
 (5,'perfil','Perfil','80.05.03','S','N','listar',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
 (6,'configuracao','Configurar','80','S','N','listar',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
 (7,'ajuda','Ajuda','80.07','S','N','listar',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
 (8,'config','Parametrização','80.09','S','N','listar',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
 (9,'erro_log','LOG dos erros do sistema','80.13','S','N','inc',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
 (10,'erro_msg','Mensagem de Erro','80.15','S','N','listar',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
 (11,'senha','Alterar a Senha','90','S','N','cadastro',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
 (12,'mime','Tipo Mime','80.17','S','N','listar',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
 (13,'mime_grupo','Grupo','80.17.03','S','N','listar',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
 (14,'mime_arquivo','Arquivo','80.17.05','S','N','listar',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
 (15,'mime_tipo','Tipo do Arquivo','80.17.05.03','N','N','listar',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
 (16,'log_sis','Auditoria do Sistema','80.11','S','N','inc',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
 (42,'administrar','Administrar','70','S','N','inc',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
 (43,'ajudalogin','Ajuda Login','70.01','S','N','listar',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
 (44,'duvida','Dúvidas','70.07','S','N','listar',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
 (45,'contato','Contato e-mail','70.09','S','N','listar',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
 (78,'ajudalogin_adm','Ajuda Login G.C.','70.02','S','N','listar',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
 (188,'site_seguranca','Segurança - SITE','80.03','S','N','listar',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
 (189,'site_perfil','Perfil','80.03.03','S','N','listar',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
 (190,'site_direito','Direito','80.03.05','S','N','listar',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
 (191,'site_funcao','Função','80.03.07','S','N','listar',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
 (192,'ajuda_campo','Ajuda de Campo','80.19','S','N','listar',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
 (209,'noticia_sistema','Notícias do Sistema','70.11','S','N','listar',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
 (319,'sca_usuarios','Usuários','50','S','S','listar',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
 (320,'consulta_usuario','Consultas e Relatórios','50.07','S','S','listar',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
 (321,'rel_usuario','Lista de Usuários','50.07.03','S','S','relatorio',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
 (365,'usuario_nomenclatura','Nomenclaturas','50.05','S','S','listar',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
 (366,'plu_usuario_natureza','Natureza','50.05.03','S','N','listar',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `funcao` ENABLE KEYS */;


--
-- Definition of table `help_campo`
--

DROP TABLE IF EXISTS `help_campo`;
CREATE TABLE `help_campo` (
  `idt` int(11) NOT NULL AUTO_INCREMENT,
  `tabela` varchar(120) NOT NULL,
  `campo` varchar(120) NOT NULL,
  `sistema` varchar(45) DEFAULT NULL,
  `texto` longtext,
  `resumo` varchar(120) NOT NULL,
  `descricao` varchar(120) DEFAULT NULL,
  PRIMARY KEY (`idt`),
  UNIQUE KEY `iu_help_campo_tabela_campo` (`tabela`,`campo`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `help_campo`
--

/*!40000 ALTER TABLE `help_campo` DISABLE KEYS */;
INSERT INTO `help_campo` (`idt`,`tabela`,`campo`,`sistema`,`texto`,`resumo`,`descricao`) VALUES 
 (1,'qp_material','idt_cor_textura','QSMA','','Informar Resumo Help do Campo','Cor/Textura'),
 (2,'qp_material','idt_marca','QSMA','','Informar Resumo Help do Campo','Marca'),
 (3,'sca_sistema','codigo','SCA','','Informar Resumo Help do Campo','Código'),
 (4,'funcao','cod_classificacao','GTI','','Informar Resumo Help do Campo','Classificação'),
 (5,'usuario','gestor_login','PDCA_GC_SITE','','Informar Resumo Help do Campo','Gestor Autorização?'),
 (6,'sca_solicitacao_acesso','idt_administrador','PDCA_GC_SITE','','Informar Resumo Help do Campo','Usuário Administrador'),
 (7,'usuario','telefone','PDCA_GC_SITE','','Informar Resumo Help do Campo','Telefone'),
 (8,'usuario','gerenciador','PDCA_GC_SITE','','Informar Resumo Help do Campo','Acesso ao Gerenciador de Conteúdo?'),
 (9,'usuario','ativo','PDCA_GC_SITE','','Informar Resumo Help do Campo','Ativo'),
 (10,'sca_sistema','quadrante','PIR_GC','','Informar Resumo Help do Campo','Quadrante'),
 (11,'plu_pl_projeto','descricao','PIR_GC','','Informar Resumo Help do Campo','Descrição');
/*!40000 ALTER TABLE `help_campo` ENABLE KEYS */;


--
-- Definition of table `html`
--

DROP TABLE IF EXISTS `html`;
CREATE TABLE `html` (
  `idt_html` int(11) NOT NULL AUTO_INCREMENT,
  `menu` varchar(45) NOT NULL,
  `des_titulo` varchar(60) NOT NULL,
  `des_html` longtext,
  `des_resumo` longtext,
  PRIMARY KEY (`idt_html`),
  KEY `Index_2` (`menu`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `html`
--

/*!40000 ALTER TABLE `html` DISABLE KEYS */;
/*!40000 ALTER TABLE `html` ENABLE KEYS */;


--
-- Definition of table `log_sistema`
--

DROP TABLE IF EXISTS `log_sistema`;
CREATE TABLE `log_sistema` (
  `id_log_sistema` int(11) NOT NULL AUTO_INCREMENT COMMENT 'IdentificaÃ§Ã£o Ãºnica, sequencial de um LOG do Sistema.',
  `login` varchar(50) DEFAULT NULL COMMENT 'Login do UsuÃ¡rio ativo',
  `nom_usuario` varchar(50) DEFAULT NULL COMMENT 'Nome do usuÃ¡rio ativo',
  `ip_usuario` varchar(15) NOT NULL COMMENT 'NÃºmero do ID do UsuÃ¡rio Ativo.',
  `nom_tela` varchar(255) NOT NULL COMMENT 'Nome da Tela (interna) onde ocorreu o Erro.',
  `nom_tabela` varchar(100) DEFAULT NULL COMMENT 'Nome da Tabela (interna) de geraÃ§Ã£o do LOG.',
  `dtc_registro` datetime NOT NULL COMMENT 'Data do registro do LOG',
  `sts_acao` char(1) NOT NULL COMMENT 'AÃ§Ã£o executada pelo UsuÃ¡rio',
  `des_pk` varchar(255) DEFAULT NULL COMMENT 'DescriÃ§Ã£o do LOG',
  `des_registro` longtext COMMENT 'DescriÃ§Ã£o do registro do LOG',
  `obj_extra` longtext COMMENT 'Extra',
  PRIMARY KEY (`id_log_sistema`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Registro de LOG do Sistema';

--
-- Dumping data for table `log_sistema`
--

/*!40000 ALTER TABLE `log_sistema` DISABLE KEYS */;
/*!40000 ALTER TABLE `log_sistema` ENABLE KEYS */;


--
-- Definition of table `mime_arquivo`
--

DROP TABLE IF EXISTS `mime_arquivo`;
CREATE TABLE `mime_arquivo` (
  `idt_miar` int(11) NOT NULL AUTO_INCREMENT COMMENT 'IdentificaÃ§Ã£o Ãºnica, sequencial de uma extensÃ£o de Arquivo.',
  `des_extensao` varchar(10) NOT NULL COMMENT 'DescriÃ§Ã£o da ExtensÃ£o.',
  PRIMARY KEY (`idt_miar`),
  UNIQUE KEY `unpk_mime_arquivo_2` (`des_extensao`)
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=latin1 COMMENT='ExtensÃ£o do Arquivo';

--
-- Dumping data for table `mime_arquivo`
--

/*!40000 ALTER TABLE `mime_arquivo` DISABLE KEYS */;
INSERT INTO `mime_arquivo` (`idt_miar`,`des_extensao`) VALUES 
 (3,'aiff'),
 (4,'asf'),
 (5,'avi'),
 (6,'bmp'),
 (51,'csv'),
 (8,'doc'),
 (11,'gif'),
 (12,'gz'),
 (13,'gzip'),
 (53,'htm'),
 (52,'html'),
 (14,'jpeg'),
 (1,'jpg'),
 (15,'mid'),
 (16,'mov'),
 (17,'mp3'),
 (18,'mp4'),
 (19,'mpc'),
 (20,'mpeg'),
 (21,'mpg'),
 (24,'pdf'),
 (25,'png'),
 (26,'ppt'),
 (28,'qt'),
 (29,'ram'),
 (30,'rar'),
 (31,'rm'),
 (32,'rmi'),
 (34,'rtf'),
 (37,'swf'),
 (40,'tar'),
 (41,'tgz'),
 (42,'tif'),
 (43,'tiff'),
 (44,'txt'),
 (45,'vsd'),
 (46,'wav'),
 (49,'xls'),
 (54,'xlsx'),
 (50,'zip');
/*!40000 ALTER TABLE `mime_arquivo` ENABLE KEYS */;


--
-- Definition of table `mime_grar`
--

DROP TABLE IF EXISTS `mime_grar`;
CREATE TABLE `mime_grar` (
  `idt_migr` int(11) NOT NULL AUTO_INCREMENT COMMENT 'IdentificaÃ§Ã£o Ãºnica, sequencial de um Grupo.',
  `idt_miar` int(11) NOT NULL COMMENT 'IdentificaÃ§Ã£o Ãºnica, sequencial de um Arquivo.',
  PRIMARY KEY (`idt_migr`,`idt_miar`),
  KEY `mime_grar.idt_migr` (`idt_migr`),
  KEY `mime_grar.idt_miar` (`idt_miar`),
  CONSTRAINT `mime_grar_ibfk_1` FOREIGN KEY (`idt_miar`) REFERENCES `mime_arquivo` (`idt_miar`),
  CONSTRAINT `mime_grar_ibfk_2` FOREIGN KEY (`idt_migr`) REFERENCES `mime_grupo` (`idt_migr`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1 COMMENT='Relaciona Grupo a ExtensÃ£o';

--
-- Dumping data for table `mime_grar`
--

/*!40000 ALTER TABLE `mime_grar` DISABLE KEYS */;
INSERT INTO `mime_grar` (`idt_migr`,`idt_miar`) VALUES 
 (1,1),
 (1,6),
 (1,11),
 (1,14),
 (1,25),
 (1,42),
 (1,43),
 (2,1),
 (2,3),
 (2,4),
 (2,5),
 (2,6),
 (2,8),
 (2,11),
 (2,12),
 (2,13),
 (2,14),
 (2,15),
 (2,16),
 (2,17),
 (2,18),
 (2,19),
 (2,20),
 (2,21),
 (2,24),
 (2,25),
 (2,26),
 (2,28),
 (2,29),
 (2,30),
 (2,31),
 (2,32),
 (2,34),
 (2,37),
 (2,40),
 (2,41),
 (2,42),
 (2,43),
 (2,44),
 (2,45),
 (2,46),
 (2,49),
 (2,50),
 (2,51),
 (2,54),
 (3,24),
 (4,1),
 (4,5),
 (4,11),
 (4,14),
 (4,16),
 (4,17),
 (4,18),
 (4,20),
 (4,21),
 (4,37),
 (5,52),
 (5,53);
/*!40000 ALTER TABLE `mime_grar` ENABLE KEYS */;


--
-- Definition of table `mime_grupo`
--

DROP TABLE IF EXISTS `mime_grupo`;
CREATE TABLE `mime_grupo` (
  `idt_migr` int(11) NOT NULL AUTO_INCREMENT COMMENT 'IdentificaÃ§Ã£o Ãºnica, sequencial de um Grupo de Arquivo.',
  `cod_grupo` varchar(10) NOT NULL COMMENT 'CÃ³digo do Grupo.',
  `des_gurpo` varchar(60) NOT NULL COMMENT 'DescriÃ§Ã£o do Grupo mine.',
  PRIMARY KEY (`idt_migr`),
  UNIQUE KEY `unpk_mime_grupo_2` (`cod_grupo`),
  UNIQUE KEY `unpk_mime_grupo_3` (`des_gurpo`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1 COMMENT='Grupo de Arquivo';

--
-- Dumping data for table `mime_grupo`
--

/*!40000 ALTER TABLE `mime_grupo` DISABLE KEYS */;
INSERT INTO `mime_grupo` (`idt_migr`,`cod_grupo`,`des_gurpo`) VALUES 
 (1,'imagem','Só Imagem'),
 (2,'todos','Todos os Tipos'),
 (3,'pdf','Só arquivo PDF'),
 (4,'video','Só Vídeo'),
 (5,'html','Só HTML');
/*!40000 ALTER TABLE `mime_grupo` ENABLE KEYS */;


--
-- Definition of table `mime_tipo`
--

DROP TABLE IF EXISTS `mime_tipo`;
CREATE TABLE `mime_tipo` (
  `idt_miti` int(11) NOT NULL AUTO_INCREMENT COMMENT 'IdentificaÃ§Ã£o Ãºnica, sequencial de um mime.',
  `idt_miar` int(11) NOT NULL COMMENT 'IdentificaÃ§Ã£o Ãºnica, sequencial de uma extensÃ£o de arquivo.',
  `des_tipo` varchar(100) NOT NULL COMMENT 'Tipo mime',
  PRIMARY KEY (`idt_miti`),
  UNIQUE KEY `unpk_mime_tipo_2` (`idt_miar`,`des_tipo`),
  CONSTRAINT `mime_tipo_ibfk_1` FOREIGN KEY (`idt_miar`) REFERENCES `mime_arquivo` (`idt_miar`)
) ENGINE=InnoDB AUTO_INCREMENT=83 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mime_tipo`
--

/*!40000 ALTER TABLE `mime_tipo` DISABLE KEYS */;
INSERT INTO `mime_tipo` (`idt_miti`,`idt_miar`,`des_tipo`) VALUES 
 (18,1,'image/jpeg'),
 (19,1,'image/pjpeg'),
 (1,3,'audio/aiff'),
 (2,3,'audio/x-aiff'),
 (3,4,'video/x-ms-asf'),
 (74,5,'application/octet-stream'),
 (4,5,'application/x-troff-msvideo'),
 (5,5,'video/avi'),
 (6,5,'video/msvideo'),
 (7,5,'video/x-msvideo'),
 (8,6,'image/bmp'),
 (9,6,'image/x-windows-bmp'),
 (10,8,'application/msword'),
 (11,11,'image/gif'),
 (12,12,'application/x-compressed'),
 (13,12,'application/x-gzip'),
 (14,13,'application/x-gzip'),
 (15,13,'multipart/x-gzip'),
 (16,14,'image/jpeg'),
 (17,14,'image/pjpeg'),
 (20,15,'application/x-midi'),
 (26,15,'audio/mid'),
 (21,15,'audio/midi'),
 (22,15,'audio/x-mid'),
 (23,15,'audio/x-midi'),
 (24,15,'music/crescendo'),
 (25,15,'x-music/x-midi'),
 (27,16,'video/quicktime'),
 (32,17,'audio/mpeg'),
 (28,17,'audio/mpeg3'),
 (29,17,'audio/x-mpeg-3'),
 (30,17,'video/mpeg'),
 (31,17,'video/x-mpeg'),
 (75,18,'application/octet-stream'),
 (33,18,'video/mp4'),
 (34,19,'application/x-project'),
 (35,20,'video/mpeg'),
 (36,21,'audio/mpeg'),
 (37,21,'video/mpeg'),
 (38,24,'application/pdf'),
 (39,25,'image/png'),
 (40,26,'application/mspowerpoint'),
 (41,26,'application/powerpoint'),
 (42,26,'application/vnd.ms-powerpoint'),
 (43,26,'application/x-mspowerpoint'),
 (44,28,'video/quicktime'),
 (45,29,'audio/x-pn-realaudio'),
 (46,30,'application/x-rar-compressed'),
 (47,31,'application/vnd.rn-realmedia'),
 (48,31,'audio/x-pn-realaudio'),
 (49,32,'audio/mid'),
 (50,34,'application/rtf'),
 (51,34,'application/x-rtf'),
 (52,34,'text/richtext'),
 (53,34,'text/rtf'),
 (54,37,'application/x-shockwave-flash'),
 (55,40,'application/x-tar'),
 (56,41,'application/gnutar'),
 (57,41,'application/x-compressed'),
 (58,42,'image/tiff'),
 (59,42,'image/x-tiff'),
 (60,43,'image/tiff'),
 (61,43,'image/x-tiff'),
 (62,44,'text/plain'),
 (63,45,'application/x-visio'),
 (64,46,'audio/wav'),
 (65,46,'audio/x-wav'),
 (66,49,'application/excel'),
 (67,49,'application/vnd.ms-excel'),
 (68,49,'application/x-excel'),
 (69,49,'application/x-msexcel'),
 (70,50,'application/x-compressed'),
 (71,50,'application/x-zip-compressed'),
 (72,50,'application/zip'),
 (73,50,'multipart/x-zip'),
 (78,51,'application/octet-stream'),
 (76,51,'application/vnd.ms-excel'),
 (77,51,'text/csv'),
 (80,52,'text/html'),
 (79,53,'text/html'),
 (82,54,'application/octet-stream'),
 (81,54,'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
/*!40000 ALTER TABLE `mime_tipo` ENABLE KEYS */;


--
-- Definition of table `noticia_sistema`
--

DROP TABLE IF EXISTS `noticia_sistema`;
CREATE TABLE `noticia_sistema` (
  `idt` int(11) NOT NULL AUTO_INCREMENT,
  `ordem` varchar(10) NOT NULL,
  `data` date NOT NULL,
  `hora` varchar(8) NOT NULL,
  `ativa` varchar(1) NOT NULL,
  `descricao` varchar(120) NOT NULL,
  `contato` varchar(45) NOT NULL,
  `principal` varchar(1) NOT NULL,
  `detalhe` longtext,
  PRIMARY KEY (`idt`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `noticia_sistema`
--

/*!40000 ALTER TABLE `noticia_sistema` DISABLE KEYS */;
INSERT INTO `noticia_sistema` (`idt`,`ordem`,`data`,`hora`,`ativa`,`descricao`,`contato`,`principal`,`detalhe`) VALUES 
 (1,'0000000001','2015-04-07','12:00','S','Homologação do Sistema de Credenciamento de Acesso','Luiz Pereira','N','<p>&nbsp;O sistema deve ser Homologado no que se refere a Padr&atilde;o de desenvolvimento.</p>'),
 (2,'0000000002','2015-04-07','11:36','N','Nova versão referente a Design para verificações e Homologação','Luiz Pereira','N','<p>&nbsp;Modificamos as telas e bot&otilde;es conforme solicitado para ter ader&ecirc;ncia aos sites do sistema SEBRAE</p>'),
 (3,'0000000003','2015-04-07','12:00','S','Vem aí o Novo sistema de Credenciados.','Luiz Pereira','N','<p>&nbsp;An&aacute;lise e implementa&ccedil;&atilde;o do novo sistema de Credenciados.</p>');
/*!40000 ALTER TABLE `noticia_sistema` ENABLE KEYS */;


--
-- Definition of table `perfil`
--

DROP TABLE IF EXISTS `perfil`;
CREATE TABLE `perfil` (
  `id_perfil` int(11) NOT NULL AUTO_INCREMENT COMMENT 'IdentificaÃ§Ã£o Ãºnica, sequencial de um Perfil.',
  `nm_perfil` varchar(40) NOT NULL COMMENT 'Nome do Perfil.',
  `classificacao` varchar(45) DEFAULT NULL,
  `ativo` varchar(1) NOT NULL DEFAULT 'S',
  PRIMARY KEY (`id_perfil`),
  UNIQUE KEY `unpk_perfil_2` (`nm_perfil`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 COMMENT='Perfil do Sistema';

--
-- Dumping data for table `perfil`
--

/*!40000 ALTER TABLE `perfil` DISABLE KEYS */;
INSERT INTO `perfil` (`id_perfil`,`nm_perfil`,`classificacao`,`ativo`) VALUES 
 (1,'Administrador','01','S'),
 (2,'INICIAL','02','S');
/*!40000 ALTER TABLE `perfil` ENABLE KEYS */;


--
-- Definition of table `plu_usuario_natureza`
--

DROP TABLE IF EXISTS `plu_usuario_natureza`;
CREATE TABLE `plu_usuario_natureza` (
  `idt` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `codigo` varchar(45) NOT NULL,
  `descricao` varchar(120) NOT NULL,
  PRIMARY KEY (`idt`),
  UNIQUE KEY `iu_plu_usuario_natureza` (`codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `plu_usuario_natureza`
--

/*!40000 ALTER TABLE `plu_usuario_natureza` DISABLE KEYS */;
INSERT INTO `plu_usuario_natureza` (`idt`,`codigo`,`descricao`) VALUES 
 (1,'ADM','Administrador'),
 (2,'CREDENCIADO','CREDENCIADOS');
/*!40000 ALTER TABLE `plu_usuario_natureza` ENABLE KEYS */;


--
-- Definition of table `site_assinatura`
--

DROP TABLE IF EXISTS `site_assinatura`;
CREATE TABLE `site_assinatura` (
  `idt` int(11) NOT NULL AUTO_INCREMENT,
  `idt_empreendimento` int(11) DEFAULT NULL,
  `chave` varchar(45) NOT NULL,
  `idt_usuario` int(11) NOT NULL,
  `assinado` varchar(1) NOT NULL,
  `ano` varchar(4) DEFAULT NULL,
  `mes` varchar(2) DEFAULT NULL,
  `data` date NOT NULL,
  PRIMARY KEY (`idt`),
  KEY `FK_site_assinatura_idt_usuario` (`idt_usuario`),
  CONSTRAINT `site_assinatura_ibfk_2` FOREIGN KEY (`idt_usuario`) REFERENCES `usuario` (`id_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `site_assinatura`
--

/*!40000 ALTER TABLE `site_assinatura` DISABLE KEYS */;
/*!40000 ALTER TABLE `site_assinatura` ENABLE KEYS */;


--
-- Definition of table `site_direito`
--

DROP TABLE IF EXISTS `site_direito`;
CREATE TABLE `site_direito` (
  `id_direito` int(11) NOT NULL AUTO_INCREMENT COMMENT 'IdentificaÃƒÂ§ÃƒÂ£o ÃƒÂºnica, sequencial de um Direito.',
  `cod_direito` varchar(5) NOT NULL COMMENT 'CÃƒÂ³digo do Direito',
  `nm_direito` varchar(25) NOT NULL COMMENT 'Nome do Direito',
  PRIMARY KEY (`id_direito`),
  UNIQUE KEY `unpk_site_direito_2` (`nm_direito`),
  UNIQUE KEY `unpk_site_direito_3` (`cod_direito`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1 COMMENT='Direitos do Sistema';

--
-- Dumping data for table `site_direito`
--

/*!40000 ALTER TABLE `site_direito` DISABLE KEYS */;
INSERT INTO `site_direito` (`id_direito`,`cod_direito`,`nm_direito`) VALUES 
 (6,'VIS','Visualizar'),
 (7,'ASSIN','Parar de Assinar?');
/*!40000 ALTER TABLE `site_direito` ENABLE KEYS */;


--
-- Definition of table `site_direito_funcao`
--

DROP TABLE IF EXISTS `site_direito_funcao`;
CREATE TABLE `site_direito_funcao` (
  `id_difu` int(11) NOT NULL AUTO_INCREMENT COMMENT 'IdentificaÃƒÂ§ÃƒÂ£o ÃƒÂºnica, sequencial de um direito_funÃƒÂ§ÃƒÂ£o.',
  `id_direito` int(11) NOT NULL COMMENT 'IdentificaÃƒÂ§ÃƒÂ£o ÃƒÂºnica, sequencial de um direito.',
  `id_funcao` int(11) NOT NULL COMMENT 'IdentificaÃƒÂ§ÃƒÂ£o ÃƒÂºnica, sequencial de uma funÃƒÂ§ÃƒÂ£o.',
  PRIMARY KEY (`id_difu`),
  UNIQUE KEY `unpk_site_direito_funcao_2` (`id_direito`,`id_funcao`),
  KEY `site_direito_funcao.id_direito` (`id_direito`),
  KEY `site_direito_funcao.id_funcao` (`id_funcao`),
  CONSTRAINT `site_direito_funcao_ibfk_1` FOREIGN KEY (`id_direito`) REFERENCES `site_direito` (`id_direito`),
  CONSTRAINT `site_direito_funcao_ibfk_2` FOREIGN KEY (`id_funcao`) REFERENCES `site_funcao` (`id_funcao`)
) ENGINE=InnoDB AUTO_INCREMENT=819 DEFAULT CHARSET=latin1 COMMENT='RelaÃƒÂ§ÃƒÂ£o direito e funcÃƒÂ£o do sistema';

--
-- Dumping data for table `site_direito_funcao`
--

/*!40000 ALTER TABLE `site_direito_funcao` DISABLE KEYS */;
INSERT INTO `site_direito_funcao` (`id_difu`,`id_direito`,`id_funcao`) VALUES 
 (814,6,252),
 (815,6,253),
 (816,6,254),
 (817,6,255),
 (818,6,256);
/*!40000 ALTER TABLE `site_direito_funcao` ENABLE KEYS */;


--
-- Definition of table `site_direito_perfil`
--

DROP TABLE IF EXISTS `site_direito_perfil`;
CREATE TABLE `site_direito_perfil` (
  `id_perfil` int(11) NOT NULL COMMENT 'IdentificaÃƒÂ§ÃƒÂ£o ÃƒÂºnica, sequencial de um perfil.',
  `id_difu` int(11) NOT NULL COMMENT 'IdentificaÃƒÂ§ÃƒÂ£o ÃƒÂºnica, sequencial de um direito_funÃƒÂ§ÃƒÂ£o.',
  PRIMARY KEY (`id_perfil`,`id_difu`),
  KEY `site_direito_perfil.id_difu` (`id_difu`),
  KEY `site_direito_perfil.id_perfil` (`id_perfil`),
  CONSTRAINT `site_direito_perfil_ibfk_1` FOREIGN KEY (`id_difu`) REFERENCES `site_direito_funcao` (`id_difu`),
  CONSTRAINT `site_direito_perfil_ibfk_2` FOREIGN KEY (`id_perfil`) REFERENCES `site_perfil` (`id_perfil`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='RelaÃƒÂ§ÃƒÂ£o direito e Parfil do sistema';

--
-- Dumping data for table `site_direito_perfil`
--

/*!40000 ALTER TABLE `site_direito_perfil` DISABLE KEYS */;
INSERT INTO `site_direito_perfil` (`id_perfil`,`id_difu`) VALUES 
 (6,814),
 (6,815),
 (6,816),
 (6,817),
 (6,818);
/*!40000 ALTER TABLE `site_direito_perfil` ENABLE KEYS */;


--
-- Definition of table `site_direito_perfil_assi`
--

DROP TABLE IF EXISTS `site_direito_perfil_assi`;
CREATE TABLE `site_direito_perfil_assi` (
  `id_perfil` int(11) NOT NULL,
  `id_difu` int(11) NOT NULL,
  PRIMARY KEY (`id_perfil`,`id_difu`),
  KEY `site_direito_perfil_assi.id_difu` (`id_difu`),
  KEY `site_direito_perfil_assi.id_perfil` (`id_perfil`),
  CONSTRAINT `site_direito_perfil_assi_ibfk_1` FOREIGN KEY (`id_difu`) REFERENCES `site_direito_funcao` (`id_difu`),
  CONSTRAINT `site_direito_perfil_assi_ibfk_2` FOREIGN KEY (`id_perfil`) REFERENCES `site_perfil_assinatura` (`id_perfil`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `site_direito_perfil_assi`
--

/*!40000 ALTER TABLE `site_direito_perfil_assi` DISABLE KEYS */;
/*!40000 ALTER TABLE `site_direito_perfil_assi` ENABLE KEYS */;


--
-- Definition of table `site_funcao`
--

DROP TABLE IF EXISTS `site_funcao`;
CREATE TABLE `site_funcao` (
  `id_funcao` int(11) NOT NULL AUTO_INCREMENT COMMENT 'IdentificaÃƒÂ§ÃƒÂ£o ÃƒÂºnica, sequencial de uma funÃƒÂ§ÃƒÂ£o.',
  `cod_funcao` varchar(50) NOT NULL COMMENT 'CÃƒÂ³digo da funÃƒÂ§ÃƒÂ£o',
  `nm_funcao` varchar(100) NOT NULL COMMENT 'Nome da FunÃƒÂ§ÃƒÂ£o (DescriÃƒÂ§ÃƒÂ£o)',
  `cod_classificacao` varchar(200) NOT NULL COMMENT 'CÃƒÂ³digo de ClassificaÃƒÂ§ÃƒÂ£o da FunÃƒÂ§ÃƒÂ£o.',
  `sts_menu` char(1) NOT NULL COMMENT 'Indicador para aparecer ou nÃƒÂ£o no MENU',
  `sts_linha` char(1) NOT NULL COMMENT 'Indicador para criar linha separadora apÃƒÂ³s.',
  `des_prefixo` varchar(40) NOT NULL COMMENT 'Indicador de prefixo - como serÃƒÂ¡ chamado para execuÃƒÂ§ÃƒÂ£o.',
  `cod_assinatura` varchar(45) DEFAULT NULL,
  `gestao` varchar(1) DEFAULT NULL,
  `procedimento` varchar(1) DEFAULT NULL,
  `idt_setor` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_funcao`),
  UNIQUE KEY `unpk_site_funcao_2` (`cod_funcao`),
  UNIQUE KEY `unpk_site_funcao_3` (`cod_classificacao`),
  KEY `FK_site_funcao_idt_setor` (`idt_setor`)
) ENGINE=InnoDB AUTO_INCREMENT=257 DEFAULT CHARSET=latin1 COMMENT='FunÃƒÂ§ÃƒÂ£o do Sistema (MENU)';

--
-- Dumping data for table `site_funcao`
--

/*!40000 ALTER TABLE `site_funcao` DISABLE KEYS */;
INSERT INTO `site_funcao` (`id_funcao`,`cod_funcao`,`nm_funcao`,`cod_classificacao`,`sts_menu`,`sts_linha`,`des_prefixo`,`cod_assinatura`,`gestao`,`procedimento`,`idt_setor`) VALUES 
 (252,'padrao_empreendimento','Padrão dos Empreendimentos','10','S','S','inc',NULL,NULL,NULL,7),
 (253,'cadastro_materiais','Banco de Dados de Produtos','15','S','S','inc',NULL,NULL,NULL,7),
 (254,'especificacao_obra','Especificação da Obra','20','S','S','inc',NULL,NULL,NULL,7),
 (255,'detalhe_execucao','Detalhes da Execução','25','S','S','inc',NULL,NULL,NULL,7),
 (256,'especificacao','Especificação','40','S','S','inc',NULL,NULL,NULL,7);
/*!40000 ALTER TABLE `site_funcao` ENABLE KEYS */;


--
-- Definition of table `site_perfil`
--

DROP TABLE IF EXISTS `site_perfil`;
CREATE TABLE `site_perfil` (
  `id_perfil` int(11) NOT NULL AUTO_INCREMENT COMMENT 'IdentificaÃƒÂ§ÃƒÂ£o ÃƒÂºnica, sequencial de um Perfil.',
  `nm_perfil` varchar(40) NOT NULL COMMENT 'Nome do Perfil.',
  `todos` varchar(1) NOT NULL,
  `idt_empreendimento` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_perfil`),
  UNIQUE KEY `unpk_site_perfil_2` (`nm_perfil`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1 COMMENT='Perfil do Sistema';

--
-- Dumping data for table `site_perfil`
--

/*!40000 ALTER TABLE `site_perfil` DISABLE KEYS */;
INSERT INTO `site_perfil` (`id_perfil`,`nm_perfil`,`todos`,`idt_empreendimento`) VALUES 
 (6,'Total','S',NULL);
/*!40000 ALTER TABLE `site_perfil` ENABLE KEYS */;


--
-- Definition of table `site_perfil_assinatura`
--

DROP TABLE IF EXISTS `site_perfil_assinatura`;
CREATE TABLE `site_perfil_assinatura` (
  `id_perfil` int(11) NOT NULL AUTO_INCREMENT,
  `nm_perfil` varchar(40) NOT NULL COMMENT 'Nome do Perfil.',
  `todos` varchar(1) NOT NULL,
  `idt_empreendimento` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_perfil`),
  UNIQUE KEY `unpk_site_perfil_assinatura_2` (`nm_perfil`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Perfil do Sistema';

--
-- Dumping data for table `site_perfil_assinatura`
--

/*!40000 ALTER TABLE `site_perfil_assinatura` DISABLE KEYS */;
/*!40000 ALTER TABLE `site_perfil_assinatura` ENABLE KEYS */;


--
-- Definition of table `usuario`
--

DROP TABLE IF EXISTS `usuario`;
CREATE TABLE `usuario` (
  `id_usuario` int(11) NOT NULL AUTO_INCREMENT COMMENT 'IdentificaÃ§Ã£o Ãºnica, sequencial de um UsuÃ¡rio',
  `nome_completo` varchar(50) NOT NULL COMMENT 'Nome completo do usuÃ¡rio',
  `login` varchar(50) NOT NULL COMMENT 'Login do UsuÃ¡rio',
  `senha` varchar(32) NOT NULL COMMENT 'Senha do UsuÃ¡rio',
  `ativo` char(1) NOT NULL COMMENT 'Indicador de usÃ¡rio ativo ou nÃ£o.',
  `id_perfil` int(11) NOT NULL COMMENT 'IdentificaÃ§Ã£o numÃ©rica do Perfil do UsuÃ¡rio',
  `dt_validade` date DEFAULT NULL COMMENT 'Data limite de Validade do Login, Senha',
  `email` varchar(60) DEFAULT NULL COMMENT 'e_mail para comunicaÃ§Ã£o com o usuÃ¡rio',
  `confirma_login` varchar(1) DEFAULT NULL,
  `tipo_usuario` varchar(1) DEFAULT NULL,
  `lembrete` varchar(1) DEFAULT NULL,
  `situacao_login` varchar(2) NOT NULL,
  `gerenciador` varchar(1) NOT NULL,
  `acesso_obra` varchar(1) DEFAULT NULL,
  `matricula_intranet` varchar(20) DEFAULT NULL,
  `id_site_perfil` int(11) DEFAULT NULL,
  `gestor_obra` varchar(1) DEFAULT NULL,
  `idt_setor` int(11) DEFAULT NULL,
  `procedimento` varchar(1) DEFAULT NULL,
  `idt_site_perfil_assi` int(11) DEFAULT NULL,
  `marketing` varchar(1) DEFAULT NULL,
  `trancar_gantt` varchar(1) DEFAULT NULL,
  `idt_cargo` int(11) DEFAULT NULL,
  `telefone` varchar(45) DEFAULT NULL,
  `gestor_login` varchar(1) DEFAULT NULL,
  `idt_natureza` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id_usuario`),
  UNIQUE KEY `unpk_usuario_2` (`login`),
  KEY `usuario.id_perfil` (`id_perfil`),
  KEY `FK_usuario_idt_site_perfil` (`id_site_perfil`),
  KEY `FK_usuario_idt_setor` (`idt_setor`),
  KEY `FK_usuario_idt_site_perfil_assi` (`idt_site_perfil_assi`),
  KEY `FK_usuario_cargo` (`idt_cargo`),
  KEY `unpk_usuario_3` (`nome_completo`),
  KEY `iu_usuario_email` (`email`),
  KEY `FK_usuario_5` (`idt_natureza`),
  CONSTRAINT `FK_usuario_4` FOREIGN KEY (`idt_natureza`) REFERENCES `plu_usuario_natureza` (`idt`) ON UPDATE CASCADE,
  CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`id_perfil`) REFERENCES `perfil` (`id_perfil`),
  CONSTRAINT `usuario_ibfk_2` FOREIGN KEY (`id_site_perfil`) REFERENCES `site_perfil` (`id_perfil`),
  CONSTRAINT `usuario_ibfk_4` FOREIGN KEY (`idt_site_perfil_assi`) REFERENCES `site_perfil_assinatura` (`id_perfil`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 COMMENT='UsuÃ¡rio do Sistema';

--
-- Dumping data for table `usuario`
--

/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
INSERT INTO `usuario` (`id_usuario`,`nome_completo`,`login`,`senha`,`ativo`,`id_perfil`,`dt_validade`,`email`,`confirma_login`,`tipo_usuario`,`lembrete`,`situacao_login`,`gerenciador`,`acesso_obra`,`matricula_intranet`,`id_site_perfil`,`gestor_obra`,`idt_setor`,`procedimento`,`idt_site_perfil_assi`,`marketing`,`trancar_gantt`,`idt_cargo`,`telefone`,`gestor_login`,`idt_natureza`) VALUES 
 (1,'Administrador','lupe','c4ca4238a0b923820dcc509a6f75849b','S',1,NULL,'1@servidor.br',NULL,'A',NULL,'02','S','0','123',6,'N',3,'N',NULL,NULL,NULL,NULL,'(71)3245-0190','S',1);
/*!40000 ALTER TABLE `usuario` ENABLE KEYS */;




/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
