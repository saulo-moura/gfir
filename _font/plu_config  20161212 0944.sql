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
-- Definition of table `plu_config`
--

DROP TABLE IF EXISTS `plu_config`;
CREATE TABLE `plu_config` (
  `id_config` int(11) NOT NULL AUTO_INCREMENT COMMENT 'IdentificaÃ§Ã£o Ãºnica, sequencial de uma configuraÃ§Ã£o.',
  `variavel` varchar(50) NOT NULL COMMENT 'VariÃ¡vel de identificaÃ§Ã£o da ConfiguraÃ§Ã£o.',
  `descricao` varchar(200) NOT NULL COMMENT 'DescriÃ§Ã£o da configuraÃ§Ã£o.',
  `valor` longtext COMMENT 'Valor da ConfiguraÃ§Ã£o.',
  `extra` longtext COMMENT 'Valor extra (adicional) da configuraÃ§Ã£o.',
  `js` char(1) NOT NULL COMMENT 'js (explicar)',
  `classificacao` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id_config`),
  UNIQUE KEY `unpk_plu_config_2` (`variavel`),
  KEY `ix_classificacao` (`classificacao`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=latin1 COMMENT='ConfiguraÃ§Ã£o do Sistema';

--
-- Dumping data for table `plu_config`
--

/*!40000 ALTER TABLE `plu_config` DISABLE KEYS */;
INSERT INTO `plu_config` (`id_config`,`variavel`,`descricao`,`valor`,`extra`,`js`,`classificacao`) VALUES 
 (1,'timeout','Nº de Segundos para dar o timeout no Gerenciador de Conteúdo','3600000',NULL,'N','01.13'),
 (2,'reg_pagina','Quantidade de registros nas tabelas','30',NULL,'N','05.03'),
 (3,'num_pagina','Quantidade de números no links da páginação para cada lado','6',NULL,'N','05.05'),
 (4,'senha_padrao','Senha padrão para um novo usuário','12345',NULL,'N','01.03'),
 (5,'ico_texto','Forma de apresentação da barra de ação do grid',NULL,'IT','N','05.07'),
 (6,'email_site','e-Mail utilizado no site','servicedesk@servico.sebraeba.com.br',NULL,'N','20.03'),
 (7,'host_smtp','Host do servidor de SMTP','10.6.14.42',NULL,'N','20.05'),
 (8,'port_smtp','Porta do servidor de SMTP','25',NULL,'N','20.07'),
 (9,'login_smtp','Login para autenticação no SMTP',NULL,NULL,'N','20.09'),
 (10,'senha_smtp','Senha para autenticação no SMTP',NULL,NULL,'N','20.11'),
 (11,'url_sebrae_na','URL da url_sebrae_na','http://www.sebrae.com.br/sites/PortalSebrae/',NULL,'','10.03'),
 (12,'url_sebrae_ba','URL da url_sebrae_ba','http://www.sebrae.com.br/sites/PortalSebrae/ufs/ba?codUf=5',NULL,'','10.05'),
 (13,'url_helpdesk','HelpDesk: URL de Acesso HelpDesk do SEBRAE-BA','http://otrs.sebraeba.com.br/index.pl?Action=AgentTicketQueue;OTRSAgentInterface=JxHrlOLBDPg06A58i2lKNw0NcTgq7xOe',NULL,'N','30.03'),
 (14,'url_sebrae','URL Webmail Sebrae','https://webmail.sebraeba.com.br',NULL,'','10.09'),
 (16,'timeout_site','Nº de Segundos para dar o timeout no Site','3600000',NULL,'','01.10'),
 (19,'url_site','URL desse Site','http://www.pir.ba.sebrae.com.br/sebrae_grc/',NULL,'','10.11'),
 (21,'url_google_analytics','URL Google Analytics','https://www.google.com',NULL,'N','10.13'),
 (22,'LINK_SGC','Link para SGC - Gestão de Contratos','/sgc/','','N','10.15'),
 (23,'smtp_secure','SMTP Secure (tls, ssl ou vazio)',NULL,NULL,'','20.13'),
 (24,'refresh_painel','REFRESH PAINEL (em segundos)','10',NULL,'','05.09'),
 (25,'email_envio','e-Mail utilizado no envio','envio.pir@ba.sebrae.com.br',NULL,'N','20.20'),
 (26,'email_logerro','e-Mail utilizado no envio das mensagens de erro (separar os email com ;)',NULL,NULL,'N','20.23'),
 (27,'email_nome','Nome utilizado no envio de email','Sebrae-BA',NULL,'N','20.25'),
 (28,'max_upload_size','Limite do Upload (MB)','10',NULL,'N','01.20'),
 (29,'helpdesk_solicitacao','HelpDesk CRM: e-Mail utilizado na Solicitação - Destinatário  (separar os email com ;)','servicedesk@servico.sebraeba.com.br',NULL,'N','30.20'),
 (30,'to_vivo','Tempo para dar sinal de estar vivo','120',NULL,'N','01.15'),
 (31,'email_canc_evento_suporte','e-Mail utilizado no envio das mensagens no Cancelamento do Evento para a Unidades de Suporte (separar os email com ;)','marcelo.vitorio@ba.sebrae.com.br; daniela.silva@ba.sebrae.com.br',NULL,'N','20.80'),
 (32,'email_canc_evento_financeiro','e-Mail utilizado no envio das mensagens no Cancelamento do Evento para o Financeiro (separar os email com ;)','emanuel.santos@ba.sebrae.com.br',NULL,'N','20.83'),
 (33,'evento_cons_hora_mes','A quantidade de horas mensais máximas de um credenciado','120',NULL,'N','50.03'),
 (34,'helpdesk_email_envio','HelpDesk CRM: e-Mail Utilizado para Remetente','suporte.pir@servico.sebraeba.com.br',NULL,'N','30.10'),
 (35,'helpdesk_host_smtp','HelpDesk CRM: Host SMTP','smtp.office365.com',NULL,'N','30.13'),
 (36,'helpdesk_port_smtp','HelpDesk CRM: Porta do Servidor SMTP','587',NULL,'N','30.15'),
 (37,'helpdesk_login_smtp','HelpDesk CRM: Login para autenticação no Servidor SMTP','suporte.pir@servico.sebraeba.com.br',NULL,'N','30.17'),
 (38,'helpdesk_senha_smtp','HelpDesk CRM: Senha para autenticação no Servidor SMTP','Lupe@2016.2',NULL,'N','30.19'),
 (39,'helpdesk_smtp_secure','HelpDesk CRM: SMTP Secure (tls, ssl ou vazio)','tls',NULL,'N','30.21'),
 (40,'helpdesk_email_nome','HelpDesk CRM: Nome para Envio do Email','PIR - HELPDESK',NULL,'N','30.11');
/*!40000 ALTER TABLE `plu_config` ENABLE KEYS */;




/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
