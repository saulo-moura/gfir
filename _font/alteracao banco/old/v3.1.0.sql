-- linux

-- 17/11/2015

ALTER TABLE `grc_sincroniza_siac`
ADD COLUMN `tipo_entidade`  char(1) NULL AFTER `tipo`;

ALTER TABLE `grc_atendimento_painel` MODIFY COLUMN `codigo` VARCHAR(45) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL;

ALTER TABLE `db_pir`.`plu_usuario` MODIFY COLUMN `idt_natureza` INT(10) UNSIGNED DEFAULT NULL;
ALTER TABLE `db_pir_bia`.`plu_usuario` MODIFY COLUMN `idt_natureza` INT(10) UNSIGNED DEFAULT NULL;
ALTER TABLE `db_pir_gec`.`plu_usuario` MODIFY COLUMN `idt_natureza` INT(10) UNSIGNED DEFAULT NULL;
ALTER TABLE `db_pir_grc`.`plu_usuario` MODIFY COLUMN `idt_natureza` INT(10) UNSIGNED DEFAULT NULL;
ALTER TABLE `db_sebrae_pfo`.`plu_usuario` MODIFY COLUMN `idt_natureza` INT(10) UNSIGNED DEFAULT NULL;

-- 23/11/2015

INSERT INTO `plu_config` (`variavel`, `descricao`, `valor`, `extra`, `js`) VALUES ('email_envio', 'e-Mail utilizado no envio', 'lupe.tecnologia.pco@gmail.com', NULL, 'N');
INSERT INTO `plu_config` (`variavel`, `descricao`, `valor`, `extra`, `js`) VALUES ('email_logerro', 'e-Mail utilizado no envio das mensagens de erro (separar os email com ;)', 'lupe.tecnologia.sebrae@gmail.com', NULL, 'N');

ALTER TABLE `plu_erro_log`
ADD COLUMN `vget`  longtext NULL AFTER `objeto`,
ADD COLUMN `vpost`  longtext NULL AFTER `vget`,
ADD COLUMN `vserver`  longtext NULL AFTER `vpost`,
ADD COLUMN `vsession`  longtext NULL AFTER `vserver`;

-- 24/11/2015

UPDATE `plu_config` SET `variavel`='url_helpdesk', `descricao`='URL do HelpDesk', `valor`='http://otrs.sebraeba.com.br/index.pl?Action=AgentTicketQueue;OTRSAgentInterface=JxHrlOLBDPg06A58i2lKNw0NcTgq7xOe' WHERE (`id_config`='13');

ALTER TABLE `grc_sincroniza_siac`
ADD COLUMN `representa`  char(1) NULL AFTER `tipo_entidade`;

update grc_sincroniza_siac set representa = 'N';

ALTER TABLE `grc_sincroniza_siac`
MODIFY COLUMN `representa`  char(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'N' AFTER `tipo_entidade`;

update grc_sincroniza_siac set representa = 'S' where tipo = 'E';

-- 26/11/2015

ALTER TABLE `plu_usuario`
ADD COLUMN `mostra_menu`  char(1) NOT NULL DEFAULT 'N' AFTER `codparceiro_siacweb`;

ALTER TABLE `plu_usuario`
ADD COLUMN `ldap`  char(1) NOT NULL DEFAULT 'N' AFTER `mostra_menu`;

-- 28/11/2015

ALTER TABLE `grc_atendimento_organizacao`
ADD COLUMN `modificado`  char(1) NOT NULL DEFAULT 'N' AFTER `novo_registro`;

-- 30/11/2015

-- ----------------------------
-- Table structure for relporteconstjur
-- ----------------------------
DROP TABLE IF EXISTS `relporteconstjur`;
CREATE TABLE `relporteconstjur` (
  `codrel` smallint(6) NOT NULL,
  `codconst` smallint(6) NOT NULL,
  `codporte` smallint(6) NOT NULL,
  `atende` char(1) NOT NULL,
  `situacao` char(1) NOT NULL,
  `rowguid` char(36) DEFAULT NULL,
  PRIMARY KEY (`codrel`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of relporteconstjur
-- ----------------------------
INSERT INTO `relporteconstjur` VALUES ('12', '5', '1', 'N', 'A', '2382E5FC-DD6E-499D-9CE1-077E3C1A7D6D');
INSERT INTO `relporteconstjur` VALUES ('13', '5', '2', 'N', 'A', '0A7C1676-7C67-464F-8D5F-B1DBAB9D67F1');
INSERT INTO `relporteconstjur` VALUES ('14', '5', '3', 'S', 'A', 'D631F555-736D-4117-82CF-F46A3D4015FA');
INSERT INTO `relporteconstjur` VALUES ('15', '5', '4', 'N', 'A', 'AA9B2915-C653-46A0-AE06-CC2966AF8BDB');
INSERT INTO `relporteconstjur` VALUES ('16', '6', '1', 'N', 'I', '3A7D918D-744A-451D-A358-9763CE35D6CA');
INSERT INTO `relporteconstjur` VALUES ('17', '6', '2', 'N', 'I', '473F1346-75BD-4DC9-AB6E-F6B41C0BFF84');
INSERT INTO `relporteconstjur` VALUES ('18', '6', '3', 'N', 'I', '0CB88B07-C64D-4037-8DBC-95F4222D998C');
INSERT INTO `relporteconstjur` VALUES ('19', '6', '4', 'N', 'I', 'BCF3C9A4-5E75-4D48-8FED-6C9862F9D9C3');
INSERT INTO `relporteconstjur` VALUES ('29', '12', '2', 'S', 'A', '1D703AE6-5C12-44D9-97B4-41A2ED87411E');
INSERT INTO `relporteconstjur` VALUES ('30', '12', '3', 'S', 'A', '55613BFC-5477-4C09-BEE8-6B99EB93E269');
INSERT INTO `relporteconstjur` VALUES ('31', '12', '99', 'S', 'A', 'D3031FEC-6734-4818-9863-AE509A7DA41B');
INSERT INTO `relporteconstjur` VALUES ('32', '99', '2', 'S', 'A', '360B3C22-9A34-47B0-B10B-088359EB373D');
INSERT INTO `relporteconstjur` VALUES ('33', '99', '3', 'S', 'A', 'DCF3FCAB-E0B8-4198-9B71-3AF48D5D1E2E');
INSERT INTO `relporteconstjur` VALUES ('34', '99', '1', 'N', 'A', '45FD158B-EAF4-46FB-AD12-D32D6C77BDB6');
INSERT INTO `relporteconstjur` VALUES ('35', '99', '4', 'N', 'A', '8A35A710-4CA1-409D-9C81-F82B336ABC7C');
INSERT INTO `relporteconstjur` VALUES ('36', '99', '99', 'S', 'A', '96AACB17-4D90-4DF7-9608-2859690E926A');
INSERT INTO `relporteconstjur` VALUES ('37', '11', '99', 'N', 'A', 'D73E7AAD-4535-4B8D-A645-AFE4B577B0C5');
INSERT INTO `relporteconstjur` VALUES ('38', '14', '5', 'N', 'A', '894FEBB5-F9EF-4429-ACF6-C3720D705A43');
INSERT INTO `relporteconstjur` VALUES ('43', '7', '5', 'N', 'A', 'D2A38182-B3EE-4EFA-8C9E-08B786325379');
INSERT INTO `relporteconstjur` VALUES ('44', '8', '5', 'N', 'A', 'A72B3E82-D86D-4848-AF5B-FF98A90986B7');
INSERT INTO `relporteconstjur` VALUES ('45', '9', '5', 'N', 'A', 'B5ABB132-DBDC-4059-BD30-DFFE68C1F395');
INSERT INTO `relporteconstjur` VALUES ('46', '16', '5', 'N', 'A', '67A10AE2-0579-438C-B170-FD17784DC41D');
INSERT INTO `relporteconstjur` VALUES ('47', '15', '5', 'N', 'A', 'D73C6A9D-29EB-45D5-87F9-CA5B4F4F93DF');
INSERT INTO `relporteconstjur` VALUES ('53', '17', '5', 'N', 'A', 'DFD503C1-5F96-43C0-B07F-FB80484FD9DB');
INSERT INTO `relporteconstjur` VALUES ('54', '18', '5', 'N', 'A', 'B6E8713D-6595-476E-950A-9365A980B69D');
INSERT INTO `relporteconstjur` VALUES ('55', '19', '5', 'N', 'A', '578D1837-BBCF-4BBD-87B7-FA6AF81D6911');
INSERT INTO `relporteconstjur` VALUES ('56', '20', '5', 'N', 'A', '719DACF7-19CD-4B47-A1D5-D57BE9BA55F8');
INSERT INTO `relporteconstjur` VALUES ('57', '99', '5', 'N', 'I', 'D6DAF8F3-D3F7-406C-81B8-321415422A28');
INSERT INTO `relporteconstjur` VALUES ('58', '6', '5', 'N', 'A', '35641A6A-0C60-45DB-97AB-E63C323AC2D1');

ALTER TABLE `plu_noticia_sistema`
ADD COLUMN `dt_mostra_ini`  datetime NOT NULL AFTER `local_apresentacao`,
ADD COLUMN `dt_mostra_fim`  datetime NOT NULL AFTER `dt_mostra_ini`;

update plu_noticia_sistema set dt_mostra_ini = '2015-08-01', dt_mostra_fim = '2015-08-20';

ALTER TABLE `plu_usuario`
ADD COLUMN `dt_validade_inicio`  date NULL AFTER `dt_validade`;

ALTER TABLE `plu_mime_tipo` DROP FOREIGN KEY `plu_mime_tipo_ibfk_1`;

ALTER TABLE `plu_mime_tipo` ADD CONSTRAINT `plu_mime_tipo_ibfk_1` FOREIGN KEY (`idt_miar`) REFERENCES `plu_mime_arquivo` (`idt_miar`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `plu_direito_perfil` DROP FOREIGN KEY `plu_direito_perfil_ibfk_2`;

ALTER TABLE `plu_direito_perfil` ADD CONSTRAINT `plu_direito_perfil_ibfk_2` FOREIGN KEY (`id_perfil`) REFERENCES `plu_perfil` (`id_perfil`) ON DELETE CASCADE ON UPDATE RESTRICT;

ALTER TABLE `plu_painel_grupo`
ADD COLUMN `bt_fecha`  char(1) NOT NULL DEFAULT 'A' AFTER `painel_largura`;

ALTER TABLE `plu_painel_grupo`
CHANGE COLUMN `bt_fecha` `tit_bt_fecha`  char(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT 'A' AFTER `tit_mostrar`;

CREATE TABLE `plu_email_log` (
  `idt` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `protocolo` varchar(120) NOT NULL,
  `data_registro` datetime NOT NULL,
  `email_origem` varchar(120) NOT NULL,
  `nome_origem` varchar(120) NOT NULL,
  `email_destino` varchar(120) NOT NULL,
  `nome_destino` varchar(120) NOT NULL,
  `idt_usuario` int(11) DEFAULT NULL,
  `msg_principal` text,
  `confirmacao` varchar(1) NOT NULL DEFAULT 'N',
  `enviado` varchar(1) NOT NULL DEFAULT 'N',
  `liberado` varchar(1) DEFAULT NULL,
  `idt_autorizador` int(11) DEFAULT NULL,
  `data_liberacao` datetime DEFAULT NULL,
  `origem` varchar(45) DEFAULT NULL,
  `msg_erro` text,
  PRIMARY KEY (`idt`),
  UNIQUE KEY `iu_plu_email_log` (`protocolo`,`data_registro`,`idt`) USING BTREE,
  KEY `FK_plu_email_log_1` (`idt_usuario`),
  KEY `FK_plu_email_log_2` (`idt_autorizador`),
  CONSTRAINT `plu_email_log_ibfk_1` FOREIGN KEY (`idt_usuario`) REFERENCES `plu_usuario` (`id_usuario`) ON UPDATE CASCADE,
  CONSTRAINT `plu_email_log_ibfk_2` FOREIGN KEY (`idt_autorizador`) REFERENCES `plu_usuario` (`id_usuario`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

INSERT INTO `plu_config` (`variavel`, `descricao`, `valor`, `extra`, `js`) VALUES ('email_nome', 'Nome utilizado no envio de email', 'Sebrae-BA', NULL, 'N');

-- 05/12/2015

ALTER TABLE `plu_usuario`
ADD COLUMN `mostra_barra_home`  char(1) NOT NULL DEFAULT 'N' AFTER `ldap`;

-- 08/12/2015

resturar v3.1.0 grc instrumento atual 20151208 1631.sql

ALTER TABLE `grc_produto`
ADD COLUMN `idt_instrumento_atend`  int(10) UNSIGNED NULL AFTER `idt_secao_autora`;

update grc_produto set idt_instrumento_atend = 40 where idt_instrumento = 3;
update grc_produto set idt_instrumento_atend = 47 where idt_instrumento = 4;
update grc_produto set idt_instrumento_atend = 46 where idt_instrumento = 5;
update grc_produto set idt_instrumento_atend = 49 where idt_instrumento = 6;
update grc_produto set idt_instrumento_atend = 39 where idt_instrumento = 8;
update grc_produto set idt_instrumento_atend = 39 where idt_instrumento = 9;
update grc_produto set idt_instrumento_atend = 45 where idt_instrumento = 12;
update grc_produto set idt_instrumento_atend = 41 where idt_instrumento = 17;
update grc_produto set idt_instrumento_atend = 47 where idt_instrumento = 2;
update grc_produto set idt_instrumento_atend = 41 where idt_instrumento = 13;

checar se tem o campo idt_instrumento_atend null

ALTER TABLE `grc_produto` DROP FOREIGN KEY `FK_grc_produto_1`;

ALTER TABLE `grc_produto`
CHANGE COLUMN `idt_instrumento` `idt_instrumento_old`  int(10) UNSIGNED NULL DEFAULT NULL AFTER `idt_instrumento_atend`,
DROP INDEX `FK_grc_produto_1` ,
ADD INDEX `FK_grc_produto_1` (`idt_instrumento_old`) USING BTREE ;

ALTER TABLE `grc_produto` ADD CONSTRAINT `FK_grc_produto_1` FOREIGN KEY (`idt_instrumento_old`) REFERENCES `grc_instrumento` (`idt`) ON DELETE RESTRICT ON UPDATE CASCADE;

ALTER TABLE `grc_produto`
CHANGE COLUMN `idt_instrumento_atend` `idt_instrumento`  int(10) UNSIGNED NULL DEFAULT NULL AFTER `idt_secao_autora`;

ALTER TABLE `grc_produto` ADD CONSTRAINT `FK_grc_produto_13` FOREIGN KEY (`idt_instrumento`) REFERENCES `grc_atendimento_instrumento` (`idt`) ON DELETE RESTRICT ON UPDATE CASCADE;

ALTER TABLE db_pir_siac_ba.sebrae
ADD PRIMARY KEY (`codsebrae`);

-- 09/12/2015

CREATE TABLE `grc_parametros` (
  `idt` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `codigo` varchar(45) NOT NULL,
  `descricao` varchar(120) NOT NULL,
  `ativo` char(1) NOT NULL DEFAULT 'S',
  `html` char(1) NOT NULL DEFAULT 'S',
  `detalhe` text,
  `classificacao` varchar(45) NOT NULL,
  PRIMARY KEY (`idt`),
  UNIQUE KEY `iu_grc_parametros` (`codigo`),
  KEY `ix_grc_parametros_classificacao` (`classificacao`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `grc_parametros` (`codigo`, `descricao`, `ativo`, `html`, `detalhe`, `classificacao`) VALUES ('grc_atendimento_pendencia_01', 'Assunto do email para novos registros de Pendência Atendimento', 'S', 'N', 'Novos registros de Pendência Atendimento', '01.01');
INSERT INTO `grc_parametros` (`codigo`, `descricao`, `ativo`, `html`, `detalhe`, `classificacao`) VALUES ('grc_atendimento_pendencia_02', 'Mensagem do email para novos registros de Pendência Atendimento', 'S', 'S', 'protocolo: #protocolo<br/>data: #data<br/>consultor: #consultor<br/>ponto_atendimento: #ponto_atendimento<br/>protocolo pendencia: #pendencia_protocolo<br/>cliente: #cliente<br/>empreendimento: #empreendimento<br/>assunto: #assunto<br/>Detalhamento: #detalhamento ', '01.02');

INSERT INTO `grc_parametros` (`codigo`, `descricao`, `ativo`, `html`, `detalhe`, `classificacao`) VALUES ('grc_atendimento_pendencia_03', 'Assunto do email para novos registros de Pendência Evento Aprovação', 'S', 'N', 'Novos registros de Pendência Evento Aprovação', '01.03');
INSERT INTO `grc_parametros` (`codigo`, `descricao`, `ativo`, `html`, `detalhe`, `classificacao`) VALUES ('grc_atendimento_pendencia_04', 'Mensagem do email para novos registros de Pendência Evento Aprovação', 'S', 'S', 'protocolo: #protocolo<br/>data: #data<br/>solicitante: #solicitante<br/>ponto_atendimento: #ponto_atendimento<br/>codigo: #codigo<br/>cidade: #cidade<br/>local: #local<br/>descricao: #descricao<br/>dt_previsao_inicial: #dt_previsao_inicial<br/>dt_previsao_fim: #dt_previsao_fim<br/>hora_inicio: #hora_inicio<br/>hora_fim: #hora_fim<br/>observacao: #observacao', '01.04');

INSERT INTO `grc_parametros` (`codigo`, `descricao`, `ativo`, `html`, `detalhe`, `classificacao`) VALUES ('grc_atendimento_pendencia_05', 'Assunto do email para novos registros de Pendência Evento Devolução', 'S', 'N', 'Novos registros de Pendência Evento Devolução', '01.05');
INSERT INTO `grc_parametros` (`codigo`, `descricao`, `ativo`, `html`, `detalhe`, `classificacao`) VALUES ('grc_atendimento_pendencia_06', 'Mensagem do email para novos registros de Pendência Evento Devolução', 'S', 'S', 'protocolo: #protocolo<br/>data: #data<br/>solicitante: #solicitante<br/>ponto_atendimento: #ponto_atendimento<br/>codigo: #codigo<br/>cidade: #cidade<br/>local: #local<br/>descricao: #descricao<br/>dt_previsao_inicial: #dt_previsao_inicial<br/>dt_previsao_fim: #dt_previsao_fim<br/>hora_inicio: #hora_inicio<br/>hora_fim: #hora_fim<br/>observacao: #observacao', '01.06');

INSERT INTO `grc_parametros` (`codigo`, `descricao`, `ativo`, `html`, `detalhe`, `classificacao`) VALUES ('grc_atendimento_pendencia_07', 'Assunto do email para novos registros de Pendência Evento Execução', 'S', 'N', 'Novos registros de Pendência Evento Execução', '01.07');
INSERT INTO `grc_parametros` (`codigo`, `descricao`, `ativo`, `html`, `detalhe`, `classificacao`) VALUES ('grc_atendimento_pendencia_08', 'Mensagem do email para novos registros de Pendência Evento Execução', 'S', 'S', 'protocolo: #protocolo<br/>data: #data<br/>solicitante: #solicitante<br/>ponto_atendimento: #ponto_atendimento<br/>codigo: #codigo<br/>cidade: #cidade<br/>local: #local<br/>descricao: #descricao<br/>dt_previsao_inicial: #dt_previsao_inicial<br/>dt_previsao_fim: #dt_previsao_fim<br/>hora_inicio: #hora_inicio<br/>hora_fim: #hora_fim<br/>observacao: #observacao', '01.08');

insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_parametros','Parametros de Textos','90.80.05.11','N','N','listar','listar');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_parametros') as id_funcao
from plu_direito where cod_direito in ('con', 'alt', 'exc', 'inc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_parametros');

-- 10/12/2015

resturar v3.1.0 grc_evento_situacao.sql

ALTER TABLE `grc_produto`
ADD COLUMN `carga_horaria_num`  decimal(15,2) NULL AFTER `carga_horaria`,
ADD COLUMN `carga_horaria_2_num`  decimal(15,2) NULL AFTER `carga_horaria_2`;

ALTER TABLE `grc_evento`
ADD COLUMN `frequencia_min`  decimal(10,2) NULL AFTER `data_criacao`;

delete from grc_evento_participante;
delete from grc_atendimento_pessoa where idt_atendimento in (select idt from grc_atendimento where idt_evento is not null);
delete from grc_atendimento_organizacao where idt_atendimento in (select idt from grc_atendimento where idt_evento is not null);
delete from grc_atendimento where idt_evento is not null;
delete from grc_atendimento_pendencia where idt_evento is not null;
delete from grc_evento_responsavel;
delete from grc_evento_produto;
delete from grc_evento_periodo;
delete from grc_evento_ocorrencia;
delete from grc_evento_local;
delete from grc_evento_insumo;
delete from grc_evento_etapa;
delete from grc_evento_agenda;
delete from grc_evento;

delete from plu_autonum where codigo = 'grc_evento_codigo';

alter table grc_atendimento_pessoa auto_increment = 1;
alter table grc_atendimento_organizacao auto_increment = 1;
alter table grc_atendimento auto_increment = 1;
alter table grc_atendimento_pendencia auto_increment = 1;
alter table grc_evento_responsavel auto_increment = 1;
alter table grc_evento_produto auto_increment = 1;
alter table grc_evento_periodo auto_increment = 1;
alter table grc_evento_participante auto_increment = 1;
alter table grc_evento_ocorrencia auto_increment = 1;
alter table grc_evento_local auto_increment = 1;
alter table grc_evento_insumo auto_increment = 1;
alter table grc_evento_etapa auto_increment = 1;
alter table grc_evento_agenda auto_increment = 1;
alter table grc_evento auto_increment = 1;

CREATE TABLE `grc_atendimento_pendencia_anexo` (
  `idt` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idt_atendimento_pendencia` int(10) unsigned NOT NULL,
  `descricao` varchar(120) NOT NULL,
  `tipo` char(1) NOT NULL,
  `arquivo` varchar(255) NOT NULL,
  PRIMARY KEY (`idt`),
  KEY `fk_grc_atendimento_pendencia_anexo_1` (`idt_atendimento_pendencia`),
  CONSTRAINT `fk_grc_atendimento_pendencia_anexo_1` FOREIGN KEY (`idt_atendimento_pendencia`) REFERENCES `grc_atendimento_pendencia` (`idt`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_atendimento_pendencia_anexo','Atendimento Pendencia Anexo','90.80.05.12','N','N','listar','listar');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_atendimento_pendencia_anexo') as id_funcao
from plu_direito where cod_direito in ('con', 'alt', 'exc', 'inc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_atendimento_pendencia_anexo');

ALTER TABLE `grc_atendimento_pendencia`
MODIFY COLUMN `assunto`  varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL AFTER `recorrencia`;

ALTER TABLE `grc_atendimento_pendencia`
ADD COLUMN `temporario`  char(1) NULL AFTER `idt_atendimento_pendencia`;

ALTER TABLE `grc_produto` MODIFY COLUMN `gratuito` VARCHAR(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL;

-- 11/12/2015

insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('executa_job_rm','Sincronização dos Insumos do RM','99.80.05.99','N','N','inc','inc');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'executa_job_rm') as id_funcao
from plu_direito where cod_direito in ('con', 'alt', 'exc', 'inc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('executa_job_rm');

/*
Já executado em Homologação e Produção
ALTER TABLE `grc_insumo`
ADD INDEX `un_grc_insumo_5` (`idprd`) USING BTREE ;
*/

ALTER TABLE `grc_insumo`
ADD COLUMN `evento_insc_receita`  char(1) NOT NULL DEFAULT 'N';

-- 14/12/2015

ALTER TABLE `grc_projeto_acao`
ADD INDEX `un_grc_projeto_acao_1` (`codigo_sge`) ,
ADD INDEX `un_grc_projeto_acao_2` (`codigo_proj`) ;

ALTER TABLE `grc_atendimento_instrumento`
ADD INDEX `iu_grc_atendimento_instrumento_1` (`codigo_sge`) ;

ALTER TABLE db_pir_siac_ba.tbpaiacao
ADD INDEX `un_tbpaiacao_1` (`codpratif`, `codacao`) ;

CREATE TABLE `grc_projeto_acao_orcamentaria` (
  `idt` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idt_projeto_acao` int(10) unsigned NOT NULL,
  `codpratif` char(36) NOT NULL,
  `codacao` char(36) NOT NULL,
  `anoprevisao` smallint(6) NOT NULL,
  `dtoperacao_ultima` datetime DEFAULT NULL,
  `codentidade_fin` char(36) NOT NULL,
  `entidade_financeira` varchar(100) DEFAULT NULL,
  `codetapapratif` char(36) NOT NULL,
  `operacao` char(1) NOT NULL,
  `codtipoprevisao` int(11) NOT NULL,
  `descprevisao` varchar(50) DEFAULT NULL,
  `ativo` char(1) NOT NULL,
  `vlprevisto` decimal(15,2) NOT NULL,
  `codprocesso` char(4) NOT NULL,
  `codfase` char(4) NOT NULL,
  `descfase` varchar(40) DEFAULT NULL,
  `codentidade_inicio` char(36) NOT NULL,
  `codentidade_fim` char(36) DEFAULT NULL,
  PRIMARY KEY (`idt`),
  KEY `un_grc_projeto_acao_orcamentaria_` (`codpratif`),
  KEY `un_grc_projeto_acao_orcamentaria_2` (`codacao`),
  KEY `fk_grc_projeto_acao_orcamentaria_1` (`idt_projeto_acao`),
  CONSTRAINT `fk_grc_projeto_acao_orcamentaria_1` FOREIGN KEY (`idt_projeto_acao`) REFERENCES `grc_projeto_acao` (`idt`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `grc_projeto_acao_orcamentaria`
ADD INDEX `un_grc_projeto_acao_orcamentaria_3` (`codacao`, `anoprevisao`) ;

-- 16/12/2015

ALTER TABLE `grc_evento`
ADD COLUMN `tipo_evento`  char(1) NULL AFTER `parecer`,
ADD COLUMN `participacao_sebrae`  char(4) NULL AFTER `tipo_evento`;

ALTER TABLE `grc_evento`
ADD COLUMN `idt_gec_entidade_setor`  int(10) UNSIGNED NULL AFTER `participacao_sebrae`;

ALTER TABLE `grc_evento` ADD CONSTRAINT `FK_grc_evento_9` FOREIGN KEY (`idt_gec_entidade_setor`) REFERENCES `db_pir_gec`.`gec_entidade_setor` (`idt`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `grc_evento`
ADD COLUMN `desc_evento`  varchar(200) NULL AFTER `idt_gec_entidade_setor`,
ADD COLUMN `desc_local`  varchar(200) NULL AFTER `desc_evento`;

CREATE TABLE `grc_evento_tema` (
  `idt` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idt_evento` int(10) unsigned NOT NULL,
  `idt_tema` int(10) unsigned NOT NULL,
  `idt_sub_tema` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`idt`),
  KEY `iu_grc_evento_tema` (`idt_evento`,`idt_sub_tema`) USING BTREE,
  KEY `FK_grc_evento_tema_2` (`idt_tema`),
  KEY `FK_grc_evento_tema_3` (`idt_sub_tema`),
  CONSTRAINT `FK_grc_evento_tema` FOREIGN KEY (`idt_evento`) REFERENCES `grc_evento` (`idt`) ON UPDATE CASCADE,
  CONSTRAINT `FK_grc_evento_tema_2` FOREIGN KEY (`idt_tema`) REFERENCES `grc_tema_subtema` (`idt`) ON UPDATE CASCADE,
  CONSTRAINT `FK_grc_evento_tema_3` FOREIGN KEY (`idt_sub_tema`) REFERENCES `grc_tema_subtema` (`idt`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `grc_evento`
ADD COLUMN `desc_perfil`  varchar(200) NULL AFTER `desc_local`;

CREATE TABLE `grc_evento_programacao` (
  `idt` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idt_evento` int(10) unsigned NOT NULL,
  `descricao` varchar(120) NOT NULL,
  `data` datetime NOT NULL,
  `hora` char(5) NOT NULL,
  `local` varchar(200) NOT NULL,
  `objetivo` text NOT NULL,
  PRIMARY KEY (`idt`),
  KEY `FK_grc_evento_programacao` (`idt_evento`) USING BTREE,
  CONSTRAINT `FK_grc_evento_programacao` FOREIGN KEY (`idt_evento`) REFERENCES `grc_evento` (`idt`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_evento_tema','Evento Tema','02.03.45','N','N','listar','listar');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_evento_tema') as id_funcao
from plu_direito where cod_direito in ('con', 'alt', 'exc', 'inc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_evento_tema');

insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_evento_programacao','Evento Programação','02.03.50','N','N','listar','listar');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_evento_programacao') as id_funcao
from plu_direito where cod_direito in ('con', 'alt', 'exc', 'inc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_evento_programacao');

ALTER TABLE `grc_evento_programacao` DROP FOREIGN KEY `FK_grc_evento_programacao`;

ALTER TABLE `grc_evento_programacao` ADD CONSTRAINT `FK_grc_evento_programacao` FOREIGN KEY (`idt_evento`) REFERENCES `grc_evento` (`idt`) ON DELETE CASCADE ON UPDATE RESTRICT;

ALTER TABLE `grc_evento_tema` DROP FOREIGN KEY `FK_grc_evento_tema`;

ALTER TABLE `grc_evento_tema` ADD CONSTRAINT `FK_grc_evento_tema` FOREIGN KEY (`idt_evento`) REFERENCES `grc_evento` (`idt`) ON DELETE CASCADE ON UPDATE RESTRICT;

ALTER TABLE `grc_evento`
ADD COLUMN `vl_metro`  decimal(15,2) NULL AFTER `desc_perfil`,
ADD COLUMN `publico_visitante`  varchar(200) NULL AFTER `vl_metro`;

CREATE TABLE `grc_evento_cnae` (
  `idt` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idt_evento` int(10) unsigned NOT NULL,
  `cnae` varchar(45) NOT NULL,
  PRIMARY KEY (`idt`),
  UNIQUE KEY `un_grc_evento_cnae_2` (`idt_evento`,`cnae`),
  CONSTRAINT `fk_grc_evento_cnae_1` FOREIGN KEY (`idt_evento`) REFERENCES `grc_evento` (`idt`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `db_pir_gec`.`cnae` ADD INDEX (`subclasse`);

ALTER TABLE `grc_evento_cnae` ADD CONSTRAINT `fk_grc_evento_cnae_2` FOREIGN KEY (`cnae`) REFERENCES `db_pir_gec`.`cnae` (`subclasse`) ON DELETE RESTRICT ON UPDATE RESTRICT;

insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_evento_cnae','Evento CNAE','02.03.51','N','N','listar','listar');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_evento_cnae') as id_funcao
from plu_direito where cod_direito in ('con', 'alt', 'exc', 'inc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_evento_cnae');

CREATE TABLE `grc_evento_stand` (
  `idt` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idt_evento` int(10) unsigned NOT NULL,
  `numero` varchar(120) NOT NULL,
  `area` varchar(120) NOT NULL,
  `rua` varchar(120) NOT NULL,
  `vl_stand` decimal(15,2) NOT NULL,
  `caracteristica` varchar(120) NOT NULL,
  `cnae` varchar(45) NOT NULL,
  PRIMARY KEY (`idt`),
  CONSTRAINT `fk_grc_evento_stand_1` FOREIGN KEY (`idt_evento`) REFERENCES `grc_evento` (`idt`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `grc_evento_stand` ADD CONSTRAINT `fk_grc_evento_stand_2` FOREIGN KEY (`cnae`) REFERENCES `db_pir_gec`.`cnae` (`subclasse`) ON DELETE RESTRICT ON UPDATE RESTRICT;

insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_evento_stand','Evento STAND','02.03.52','N','N','listar','listar');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_evento_stand') as id_funcao
from plu_direito where cod_direito in ('con', 'alt', 'exc', 'inc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_evento_stand');

ALTER TABLE `grc_evento_agenda`
CHANGE COLUMN `hora_inicio` `hora_inicial`  varchar(5) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL AFTER `data_inicial`,
MODIFY COLUMN `hora_final`  varchar(5) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL AFTER `data_final`,
ADD COLUMN `dt_ini`  datetime NULL AFTER `hora_inicial`,
ADD COLUMN `dt_fim`  datetime NULL AFTER `hora_final`;

ALTER TABLE `grc_evento_agenda`
MODIFY COLUMN `nome_agenda`  varchar(120) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL AFTER `codigo`,
MODIFY COLUMN `data_inicial`  date NOT NULL AFTER `observacao`,
MODIFY COLUMN `hora_inicial`  varchar(5) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL AFTER `data_inicial`,
MODIFY COLUMN `dt_ini`  datetime NOT NULL AFTER `hora_inicial`,
MODIFY COLUMN `data_final`  date NOT NULL AFTER `dt_ini`,
MODIFY COLUMN `hora_final`  varchar(5) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL AFTER `data_final`,
MODIFY COLUMN `dt_fim`  datetime NOT NULL AFTER `hora_final`;

ALTER TABLE `db_pir_siac_ba`.`cidade` ADD INDEX (`codcid`);

ALTER TABLE `grc_evento_agenda`
ADD COLUMN `idt_local`  int(10) UNSIGNED NULL DEFAULT NULL AFTER `quantidade_horas_mes`,
ADD COLUMN `idt_cidade`  int(10) UNSIGNED NULL DEFAULT NULL AFTER `idt_local`,
DROP INDEX `iu_grc_evento_agenda`;

ALTER TABLE `grc_evento_agenda`
MODIFY COLUMN `idt_cidade`  int(11) NULL DEFAULT NULL;

ALTER TABLE `grc_evento_agenda` ADD CONSTRAINT `fk_grc_evento_agenda_1` FOREIGN KEY (`idt_evento`) REFERENCES `grc_evento` (`idt`) ON DELETE CASCADE ON UPDATE RESTRICT;

ALTER TABLE `grc_evento_agenda` ADD CONSTRAINT `fk_grc_evento_agenda_2` FOREIGN KEY (`idt_local`) REFERENCES `grc_evento_local_pa` (`idt`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `grc_evento_agenda` ADD CONSTRAINT `fk_grc_evento_agenda_3` FOREIGN KEY (`idt_cidade`) REFERENCES `db_pir_siac_ba`.`cidade` (`codcid`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `grc_evento_agenda`
MODIFY COLUMN `idt_local`  int(10) UNSIGNED NOT NULL AFTER `quantidade_horas_mes`,
MODIFY COLUMN `idt_cidade`  int(11) NOT NULL AFTER `idt_local`;

-- 17/12/2015

/*
Já executado em Homologação e Produção
INSERT INTO `plu_config` (`variavel`, `descricao`, `valor`, `extra`, js) VALUES ('max_upload_size', 'Limite do Upload (MB)', '10', NULL, 'N');

insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_produto_insumo_copia','Copia de Insumo no Produto','01.01.19','N','N','listar_cmbmulti','listar_cmbmulti');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_produto_insumo_copia') as id_funcao
from plu_direito where cod_direito in ('alt');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_produto_insumo_copia');

insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('executa_job_sge','Sincronização com SGE','99.80.05.98','N','N','inc','inc');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'executa_job_sge') as id_funcao
from plu_direito where cod_direito in ('alt');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('executa_job_sge');

ALTER TABLE `grc_produto_arquivo_associado`
DROP INDEX `iu_grc_produto_arquivo_associado` ,
ADD INDEX `iu_grc_produto_arquivo_associado` (`idt_produto`, `codigo`) USING BTREE ;

ALTER TABLE `grc_produto_ocorrencia`
DROP INDEX `iu_grc_produto_ocorrencia` ,
ADD INDEX `iu_grc_produto_ocorrencia` (`idt_produto`, `data`) USING BTREE ;

ALTER TABLE db_pir.plu_usuario
MODIFY COLUMN `nome_completo`  varchar(120) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL COMMENT 'Nome completo do usuÃ¡rio' AFTER `id_usuario`,
MODIFY COLUMN `login`  varchar(120) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL COMMENT 'Login do UsuÃ¡rio' AFTER `nome_completo`;

ALTER TABLE db_pir_gec.plu_usuario
MODIFY COLUMN `nome_completo`  varchar(120) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL COMMENT 'Nome completo do usuÃ¡rio' AFTER `id_usuario`,
MODIFY COLUMN `login`  varchar(120) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL COMMENT 'Login do UsuÃ¡rio' AFTER `nome_completo`;

ALTER TABLE db_pir_grc.plu_usuario
MODIFY COLUMN `nome_completo`  varchar(120) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL COMMENT 'Nome completo do usuÃ¡rio' AFTER `id_usuario`,
MODIFY COLUMN `login`  varchar(120) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL COMMENT 'Login do UsuÃ¡rio' AFTER `nome_completo`;

ALTER TABLE db_sebrae_pfo.plu_usuario
MODIFY COLUMN `nome_completo`  varchar(120) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL COMMENT 'Nome completo do usuÃ¡rio' AFTER `id_usuario`,
MODIFY COLUMN `login`  varchar(120) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL COMMENT 'Login do UsuÃ¡rio' AFTER `nome_completo`;

ALTER TABLE db_pir_bia.plu_usuario
MODIFY COLUMN `nome_completo`  varchar(120) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL COMMENT 'Nome completo do usuÃ¡rio' AFTER `id_usuario`,
MODIFY COLUMN `login`  varchar(120) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL COMMENT 'Login do UsuÃ¡rio' AFTER `nome_completo`;
*/

-- 18/12/2015

CREATE TABLE `grc_atendimento_instrumento_metrica` (
  `idt` INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  `idt_atendimento_instrumento` INTEGER UNSIGNED NOT NULL,
  `idt_atendimento_metrica` INTEGER UNSIGNED NOT NULL,
  `ano` CHAR(4) NOT NULL,
  PRIMARY KEY (`idt`),
  UNIQUE INDEX `un_grc_atendimento_instrumento_metrica_2`(`idt_atendimento_instrumento`, `idt_atendimento_metrica`, `ano`),
  CONSTRAINT `fk_grc_atendimento_instrumento_metrica_1` FOREIGN KEY `fk_grc_atendimento_instrumento_metrica_1` (`idt_atendimento_instrumento`)
    REFERENCES `grc_atendimento_instrumento` (`idt`)
    ON DELETE CASCADE
    ON UPDATE RESTRICT,
  CONSTRAINT `fk_grc_atendimento_instrumento_metrica_2` FOREIGN KEY `fk_grc_atendimento_instrumento_metrica_2` (`idt_atendimento_metrica`)
    REFERENCES `grc_atendimento_metrica` (`idt`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT
)
ENGINE = InnoDB;

insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_atendimento_instrumento_metrica','Instrumentos SGE (Métrica)','95.65.29.01','N','N','listar','listar');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_atendimento_instrumento_metrica') as id_funcao
from plu_direito where cod_direito in ('con', 'alt', 'exc', 'inc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_atendimento_instrumento_metrica');

ALTER TABLE `grc_evento` ADD CONSTRAINT `FK_grc_evento_20` FOREIGN KEY (`idt_projeto`) REFERENCES `grc_projeto` (`idt`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `grc_evento` ADD CONSTRAINT `FK_grc_evento_21` FOREIGN KEY (`idt_acao`) REFERENCES `grc_projeto_acao` (`idt`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `grc_projeto_acao_meta`
ADD INDEX `iu_grc_projeto_acao_meta_1` (`idt_projeto_acao`, `codigo_metrica`, `codigo_instrumento`, `ano`, `mes`) USING BTREE ;

-- 19/12/2015

TRUNCATE grc_projeto_acao_meta;

ALTER TABLE `grc_atendimento_instrumento_metrica`
DROP INDEX `un_grc_atendimento_instrumento_metrica_2` ,
ADD UNIQUE INDEX `un_grc_atendimento_instrumento_metrica_2` (`idt_atendimento_instrumento`, `ano`) USING BTREE ;

ALTER TABLE `grc_evento_agenda`
ADD COLUMN `alocacao_erro`  char(1) NOT NULL DEFAULT 'N' AFTER `competencia`,
ADD COLUMN `alocacao_msg`  text NULL AFTER `alocacao_erro`;

-- 21/12/2015

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for familiaprodutoportfolio
-- ----------------------------
DROP TABLE IF EXISTS db_pir_siac_ba.familiaprodutoportfolio;
CREATE TABLE db_pir_siac_ba.familiaprodutoportfolio (
  `codfamiliaproduto` smallint(6) NOT NULL,
  `codfamiliaprodutoestruturado` varchar(2) DEFAULT NULL,
  `nomefamiliaproduto` varchar(50) DEFAULT NULL,
  `descfamiliaproduto` varchar(500) DEFAULT NULL,
  `indcomplementocadastro` char(1) DEFAULT NULL,
  `codaplicacao` int(11) DEFAULT NULL,
  `situacao` char(1) DEFAULT NULL,
  `rowguid` char(36) DEFAULT NULL,
  PRIMARY KEY (`codfamiliaproduto`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of familiaprodutoportfolio
-- ----------------------------
INSERT INTO db_pir_siac_ba.familiaprodutoportfolio VALUES ('1', '01', 'CURSOS', 'São tendimentos com ênfase no processo de educação, onde se busca por meio de recursos instrucionais desenvolver e aprimorar conhecimentos, atitudes e habilidades gerenciais, com vistas a suprir as necessidades dos clientes atendidos. No âmbito do SEBRAE~são considerados cursos apenas as atividades de capacitação com 12 ou mais horas de duração.', 'S', '1000', 'S', '1B5A1233-0515-4CD0-90B3-64F569C793D1');
INSERT INTO db_pir_siac_ba.familiaprodutoportfolio VALUES ('2', '02', 'PALESTRAS', 'Têm sua ênfase em exposições orais de curta duração, onde um orador conversa com um público formado por várias pessoas. Elas são voltadas a disseminação de diversos temas e, inclusive, a processos de sensibilização. São consideradas palestras as atividades com as características aqui descritas, quem tenham carga horária inferior a 12h.', 'S', '1000', 'S', '54BA6DCC-3321-441B-94D3-1EED4893FC13');
INSERT INTO db_pir_siac_ba.familiaprodutoportfolio VALUES ('3', '03', 'OFICINAS', 'Trabalhos em grupo, com o apoio de facilitadores onde se busca trabalhar temas de interesse, normalmente utilizando estratégias mistas como exposições orais, dinâmicas de grupos, simulações, experimentações, etc. São consideradas oficinas as atividades com as características aqui descritas que tenham carga horária inferiro a 12h.', 'S', '1000', 'S', 'D959A690-0686-4248-A669-A3059FA8223B');
INSERT INTO db_pir_siac_ba.familiaprodutoportfolio VALUES ('4', '04', 'CONSULTORIA', 'Tipo de intervenção', 'S', '1000', 'S', '80405CFE-65FA-41AC-802C-E115DFC23313');
INSERT INTO db_pir_siac_ba.familiaprodutoportfolio VALUES ('5', '05', 'SEMINÁRIOS', 'Grupos de estudos em que se debatem matérias propostas pelos participantes. Caracteriza-se por reunir, como expositores, diferentes especialistas no assunto em qustão. Eventos desta natureza independente da carga horária, enquandram-se nesta categoria.', 'S', '1000', 'S', 'D0BE13E4-D147-46B6-A129-A87E86EF1726');
INSERT INTO db_pir_siac_ba.familiaprodutoportfolio VALUES ('10002', '06', 'CONSULTORIA TECNOLÓGICA', 'Tipo de intervenção na área tecnológica', 'S', '1000', 'S', '9EFF88AF-1EF2-4E68-A77B-2AF46A241148');

ALTER TABLE `grc_evento_local_pa_agenda`
ADD COLUMN `dt_ini`  datetime NOT NULL AFTER `hora_inicio`,
ADD COLUMN `dt_fim`  datetime NOT NULL AFTER `hora_final`;

ALTER TABLE `grc_evento_local_pa_agenda`
ADD COLUMN `alocacao_erro`  char(1) NOT NULL DEFAULT 'N',
ADD COLUMN `alocacao_msg`  text NULL AFTER `alocacao_erro`;

ALTER TABLE `grc_evento_local_pa_agenda`
CHANGE COLUMN `data_inicio` `data_inicial`  date NOT NULL AFTER `idt_local_pa`,
CHANGE COLUMN `hora_inicio` `hora_inicial`  varchar(5) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL AFTER `data_inicial`;

-- 22/12/2015

ALTER TABLE `grc_evento`
ADD COLUMN `ano_competencia`  char(4) NULL AFTER `idt_responsavel_consultor`;

update grc_evento set descricao = desc_evento
where descricao is null;

ALTER TABLE `grc_evento`
DROP COLUMN `desc_evento`;

delete FROM `grc_atendimento_metrica` where codigo in ('04', '05', '06');

/*
já executado em produção
ALTER TABLE `grc_atendimento_instrumento`
ADD COLUMN `codigo_familia_siac`  int(10) NULL AFTER `codigo_sge`;

update grc_atendimento_instrumento set codigo_familia_siac = 1 where idt = 40;
update grc_atendimento_instrumento set codigo_familia_siac = 2 where idt = 47;
update grc_atendimento_instrumento set codigo_familia_siac = 3 where idt = 46;
update grc_atendimento_instrumento set codigo_familia_siac = 4 where idt = 39;
update grc_atendimento_instrumento set codigo_familia_siac = 5 where idt = 49;
*/

ALTER TABLE `grc_produto_ocorrencia` MODIFY COLUMN `descricao` VARCHAR(300) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL;

-- 23/12/2015

ALTER TABLE `grc_evento_agenda`
CHANGE COLUMN `alocacao_erro` `alocacao_disponivel`  char(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'S' AFTER `competencia`;

update grc_evento_agenda set alocacao_disponivel = 'X' where alocacao_disponivel = 'S';
update grc_evento_agenda set alocacao_disponivel = 'S' where alocacao_disponivel = 'N';
update grc_evento_agenda set alocacao_disponivel = 'N' where alocacao_disponivel = 'X';

ALTER TABLE `grc_evento_local_pa_agenda`
CHANGE COLUMN `alocacao_erro` `alocacao_disponivel`  char(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'S' AFTER `detalhe`;

update grc_evento_local_pa_agenda set alocacao_disponivel = 'X' where alocacao_disponivel = 'S';
update grc_evento_local_pa_agenda set alocacao_disponivel = 'S' where alocacao_disponivel = 'N';
update grc_evento_local_pa_agenda set alocacao_disponivel = 'N' where alocacao_disponivel = 'X';

-- 24/12/2015

ALTER TABLE `grc_atendimento`
MODIFY COLUMN `fase_acao_projeto`  varchar(120) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL AFTER `gestor_sge`;

ALTER TABLE `grc_evento_local_pa`
DROP COLUMN `logradouro_municipio`;

ALTER TABLE `grc_evento`
ADD COLUMN `idt_ponto_atendimento_tela`  int(10) NULL AFTER `idt_ponto_atendimento`;

ALTER TABLE `grc_evento`
MODIFY COLUMN `idt_ponto_atendimento`  int(11) NULL DEFAULT NULL AFTER `idt_unidade`,
MODIFY COLUMN `idt_ponto_atendimento_tela`  int(11) NULL DEFAULT NULL AFTER `idt_ponto_atendimento`;

ALTER TABLE `grc_evento` ADD CONSTRAINT `FK_grc_evento_22` FOREIGN KEY (`idt_ponto_atendimento`) REFERENCES `db_pir`.`sca_organizacao_secao` (`idt`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `grc_evento` ADD CONSTRAINT `FK_grc_evento_23` FOREIGN KEY (`idt_ponto_atendimento_tela`) REFERENCES `db_pir`.`sca_organizacao_secao` (`idt`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `plu_usuario`
MODIFY COLUMN `idt_unidade_regional`  int(11) NULL DEFAULT NULL AFTER `idt_acao`,
ADD COLUMN `idt_unidade_lotacao`  int(11) NULL AFTER `idt_unidade_regional`;

ALTER TABLE `plu_usuario` ADD CONSTRAINT `FK_plu_usuario_7` FOREIGN KEY (`idt_unidade_regional`) REFERENCES `db_pir`.`sca_organizacao_secao` (`idt`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `plu_usuario` ADD CONSTRAINT `FK_plu_usuario_8` FOREIGN KEY (`idt_unidade_lotacao`) REFERENCES `db_pir`.`sca_organizacao_secao` (`idt`) ON DELETE RESTRICT ON UPDATE RESTRICT;

-- 28/12/2015

CREATE TABLE `grc_area_suporte` (
  `idt` INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  `codigo` VARCHAR(45) NOT NULL,
  `descricao` VARCHAR(200) NOT NULL,
  `ativo` CHAR(1) NOT NULL,
  PRIMARY KEY (`idt`),
  UNIQUE INDEX `un_grc_area_suporte_2`(`codigo`)
)
ENGINE = InnoDB;

insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_area_suporte','Área de Suporte','99.80.05.01','N','N','listar','listar');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_area_suporte') as id_funcao
from plu_direito where cod_direito in ('con', 'alt', 'exc', 'inc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_area_suporte');

ALTER TABLE `grc_insumo` DROP FOREIGN KEY `FK_grc_insumo_1`;

ALTER TABLE `grc_insumo` DROP FOREIGN KEY `FK_grc_insumo_2`;

ALTER TABLE `grc_insumo`
ADD COLUMN `idt_area_suporte`  int(10) UNSIGNED NULL AFTER `evento_insc_receita`;

ALTER TABLE `grc_insumo` ADD CONSTRAINT `FK_grc_insumo_1` FOREIGN KEY (`idt_insumo_elemento_custo`) REFERENCES `grc_insumo_elemento_custo` (`idt`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `grc_insumo` ADD CONSTRAINT `FK_grc_insumo_2` FOREIGN KEY (`idt_insumo_unidade`) REFERENCES `grc_insumo_unidade` (`idt`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `grc_insumo` ADD CONSTRAINT `FK_grc_insumo_3` FOREIGN KEY (`idt_area_suporte`) REFERENCES `grc_area_suporte` (`idt`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `grc_evento_insumo` DROP FOREIGN KEY `FK_grc_evento_insumo_2`;

ALTER TABLE `grc_evento_insumo` DROP FOREIGN KEY `FK_grc_evento_insumo_3`;

ALTER TABLE `grc_evento_insumo` DROP FOREIGN KEY `FK_grc_pevento_insumo`;

ALTER TABLE `grc_evento_insumo` ADD CONSTRAINT `FK_grc_evento_insumo_2` FOREIGN KEY (`idt_insumo`) REFERENCES `grc_insumo` (`idt`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `grc_evento_insumo` ADD CONSTRAINT `FK_grc_evento_insumo_3` FOREIGN KEY (`idt_insumo_unidade`) REFERENCES `grc_insumo_unidade` (`idt`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `grc_evento_insumo` ADD CONSTRAINT `FK_grc_pevento_insumo` FOREIGN KEY (`idt_evento`) REFERENCES `grc_evento` (`idt`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `grc_evento_insumo` ADD CONSTRAINT `FK_grc_evento_insumo_4` FOREIGN KEY (`idt_area_suporte`) REFERENCES `grc_area_suporte` (`idt`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `grc_produto_insumo` DROP FOREIGN KEY `FK_grc_produto_insumo`;

ALTER TABLE `grc_produto_insumo` DROP FOREIGN KEY `FK_grc_produto_insumo_2`;

ALTER TABLE `grc_produto_insumo` DROP FOREIGN KEY `FK_grc_produto_insumo_3`;

ALTER TABLE `grc_produto_insumo` ADD CONSTRAINT `FK_grc_produto_insumo` FOREIGN KEY (`idt_produto`) REFERENCES `grc_produto` (`idt`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `grc_produto_insumo` ADD CONSTRAINT `FK_grc_produto_insumo_2` FOREIGN KEY (`idt_insumo_unidade`) REFERENCES `grc_insumo_unidade` (`idt`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `grc_produto_insumo` ADD CONSTRAINT `FK_grc_produto_insumo_3` FOREIGN KEY (`idt_insumo`) REFERENCES `grc_insumo` (`idt`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `grc_produto_insumo` ADD CONSTRAINT `FK_grc_produto_insumo_4` FOREIGN KEY (`idt_area_suporte`) REFERENCES `grc_area_suporte` (`idt`) ON DELETE RESTRICT ON UPDATE RESTRICT;

INSERT INTO `grc_area_suporte` (`idt`, `codigo`, `descricao`, `ativo`) VALUES ('1', '01', 'CAD - Coordenação de Administração - Compras', 'S');
INSERT INTO `grc_area_suporte` (`idt`, `codigo`, `descricao`, `ativo`) VALUES ('2', '02', 'CAD - Coordenação de Administração - Estoque', 'S');
INSERT INTO `grc_area_suporte` (`idt`, `codigo`, `descricao`, `ativo`) VALUES ('3', '03', 'UMC - Unidade de Marketing e Comunicação', 'S');

UPDATE `db_pir_grc`.`grc_parametros` SET `idt`='1', `codigo`='grc_atendimento_pendencia_01', `descricao`='Assunto do email para novos registros de Pendência', `ativo`='S', `html`='N', `detalhe`='[#pendencia_protocolo] - Abertura  de Pendencia no CRM | Sebrae - #assunto', `classificacao`='01.01' WHERE (`idt`='1');
UPDATE `db_pir_grc`.`grc_parametros` SET `idt`='2', `codigo`='grc_atendimento_pendencia_02', `descricao`='Mensagem do email para novos registros de Pendência', `ativo`='S', `html`='S', `detalhe`='<p>Caro(a) #responsavel<br />\r\n<br />\r\nFoi aberta  pend&ecirc;ncia de atendimento CRM | Sebrae para que voc&ecirc; adote as providencias cab&iacute;veis.<br />\r\n<br />\r\nInforma&ccedil;&otilde;es sobre esta pend&ecirc;ncia:<br />\r\n<br />\r\n<strong> Detalhamento:</strong><br />\r\n#detalhamento<br />\r\n<strong> Autor:</strong><br />\r\n#consultor<br />\r\n<strong> Data de Abertura:</strong><br />\r\n#reg_data<br />\r\n<strong> Protocolo de Atendimento:</strong><br />\r\n#ponto_atendimento<br />\r\n<strong> Cliente:</strong><br />\r\n#cliente<br />\r\n<strong> Prazo Para Fechamento:</strong><br />\r\n#dasolucao_data<br />\r\n<br />\r\nPara responde-la, acesse pagina principal do sistema.<br />\r\n<br />\r\nCordialmente,<br />\r\n<br />\r\nEquipe Gestora da Plataforma Integrada de Relacionamento<br />\r\nUnidade de Atendimento Individual - DIRAT<br />\r\nUnidade de Tecnologia da Informa&ccedil;&atilde;o e Comunica&ccedil;&atilde;o - DISUP<br />\r\nSebrae - Bahia<br />\r\n<br />\r\n<strong>IMPORTANTE:</strong> Mensagem autom&aacute;tica  do sistema. N&atilde;o responda!</p>', `classificacao`='01.02' WHERE (`idt`='2');
UPDATE `db_pir_grc`.`grc_parametros` SET `idt`='3', `codigo`='grc_atendimento_pendencia_03', `descricao`='Assunto do email para novos registros de Pendência Evento', `ativo`='S', `html`='N', `detalhe`='[#codigo] – Solicitação de Aprovação de Evento no CRM|Sebrae', `classificacao`='01.03' WHERE (`idt`='3');
UPDATE `db_pir_grc`.`grc_parametros` SET `idt`='4', `codigo`='grc_atendimento_pendencia_04', `descricao`='Mensagem do email para novos registros de Pendência Evento', `ativo`='S', `html`='S', `detalhe`='<p>Caro(a) #responsavel<br />\r\n<br />\r\nFoi aberta pend&ecirc;ncia de evento no CRM|Sebrae para sua an&aacute;lise e delibera&ccedil;&atilde;o.<br />\r\nInforma&ccedil;&otilde;es sobre esta pend&ecirc;ncia:<br />\r\n<br />\r\n<strong>C&oacute;digo do Evento:</strong><br />\r\n#codigo<br />\r\n<strong> T&iacute;tulo do Evento:</strong><br />\r\n#descricao<br />\r\n<strong>Data de Realiza&ccedil;&atilde;o:</strong><br />\r\n#dt_previsao_inicial #hora_inicio a #dt_previsao_fim #hora_fim<br />\r\n<strong> Local/Cidade:</strong><br />\r\n#local / #cidade<br />\r\n<strong> Previs&atilde;o Receita:</strong><br />\r\n#previsao_receita<br />\r\n<strong> Despesas:</strong><br />\r\n#previsao_despesa<br />\r\n<strong> Data de Abertura:</strong><br />\r\n#dt_previsao_inicial<br />\r\n<strong> Autor:</strong><br />\r\n#solicitante<br />\r\n<br />\r\nPara respond&ecirc;-la, acesse a p&aacute;gina principal do sistema.<br />\r\n<br />\r\nCordialmente,<br />\r\n<br />\r\nEquipe gestora da Plataforma Integrada de Relacionamento<br />\r\nUnidade de Atendimento Individual - DIRAT<br />\r\nUnidade de Tecnologia da Informa&ccedil;&atilde;o e Comunica&ccedil;&atilde;o - DISUP<br />\r\nSebrae - Bahia<br />\r\n<br />\r\n<strong>IMPORTANTE:</strong> Mensagem autom&aacute;tica do sistema. N&atilde;o responda!</p>', `classificacao`='01.04' WHERE (`idt`='4');
UPDATE `db_pir_grc`.`grc_parametros` SET `idt`='5', `codigo`='grc_atendimento_pendencia_05', `descricao`='Assunto do email para novos registros de Pendência Evento Devolução', `ativo`='S', `html`='N', `detalhe`='[#codigo] – Devolução de Pendência de Evento no CRM|Sebrae', `classificacao`='01.04' WHERE (`idt`='5');
UPDATE `db_pir_grc`.`grc_parametros` SET `idt`='6', `codigo`='grc_atendimento_pendencia_06', `descricao`='Mensagem do email para novos registros de Pendência Evento Devolução', `ativo`='S', `html`='S', `detalhe`='<p>Caro(a) #responsavel<br />\r\n<br />\r\nA pend&ecirc;ncia de evento de c&oacute;digo n&uacute;mero&nbsp; #codigo aberta em&nbsp; #dt_previsao_inicial no CRM|Sebrae foi devolvida.<br />\r\nInforma&ccedil;&otilde;es sobre esta pend&ecirc;ncia:<br />\r\n<br />\r\n<strong>T&iacute;tulo do Evento:</strong><br />\r\n#descricao<br />\r\n<strong>Data de Realiza&ccedil;&atilde;o:</strong><br />\r\n#dt_previsao_inicial #hora_inicio a #dt_previsao_fim #hora_fim<br />\r\n<strong> Local/Cidade:</strong><br />\r\n#local / #cidade<br />\r\n<strong> Previs&atilde;o Receita:</strong><br />\r\n#previsao_receita<br />\r\n<strong> Despesas:</strong><br />\r\n#previsao_despesa<br />\r\n<strong> </strong><br />\r\nPara verific&aacute;-la, acesse a p&aacute;gina principal do sistema.<br />\r\n<br />\r\nCordialmente,<br />\r\n<br />\r\nEquipe gestora da Plataforma Integrada de Relacionamento<br />\r\nUnidade de Atendimento Individual - DIRAT<br />\r\nUnidade de Tecnologia da Informa&ccedil;&atilde;o e Comunica&ccedil;&atilde;o - DISUP<br />\r\nSebrae - Bahia<br />\r\n<br />\r\n<strong>IMPORTANTE:</strong> Mensagem autom&aacute;tica do sistema. N&atilde;o responda!</p>', `classificacao`='01.05' WHERE (`idt`='6');
UPDATE `db_pir_grc`.`grc_parametros` SET `idt`='7', `codigo`='grc_atendimento_pendencia_07', `descricao`='Assunto do email para novos registros de Pendência Evento Execução', `ativo`='S', `html`='N', `detalhe`='Novos registros de Pendência Evento Execução', `classificacao`='01.07' WHERE (`idt`='7');
UPDATE `db_pir_grc`.`grc_parametros` SET `idt`='8', `codigo`='grc_atendimento_pendencia_08', `descricao`='Mensagem do email para novos registros de Pendência Evento Execução', `ativo`='S', `html`='S', `detalhe`='protocolo: #protocolo<br/>data: #data<br/>solicitante: #solicitante<br/>ponto_atendimento: #ponto_atendimento<br/>codigo: #codigo<br/>cidade: #cidade<br/>local: #local<br/>descricao: #descricao<br/>dt_previsao_inicial: #dt_previsao_inicial<br/>dt_previsao_fim: #dt_previsao_fim<br/>hora_inicio: #hora_inicio<br/>hora_fim: #hora_fim<br/>observacao: #observacao', `classificacao`='01.08' WHERE (`idt`='8');

-- 29/12/2015

ALTER TABLE `grc_evento_programacao`
MODIFY COLUMN `data`  date NOT NULL AFTER `descricao`;

ALTER TABLE `grc_evento_stand`
MODIFY COLUMN `area`  decimal(15,2) NOT NULL AFTER `numero`;

ALTER TABLE `grc_evento`
ADD COLUMN `tot_hora_consultoria`  decimal(15,2) NULL AFTER `previsao_despesa`;

ALTER TABLE `grc_evento`
ADD COLUMN `custo_tot_consultoria`  decimal(15,2) NULL AFTER `tot_hora_consultoria`;

ALTER TABLE `grc_atendimento`
ADD COLUMN `idt_evento`  int(10) UNSIGNED NULL AFTER `demanda`;

ALTER TABLE `grc_atendimento` ADD CONSTRAINT `FK_grc_atendimento_19` FOREIGN KEY (`idt_evento`) REFERENCES `grc_evento` (`idt`) ON DELETE RESTRICT ON UPDATE RESTRICT;

-- 30-12-2015

ALTER TABLE `db_pir_grc`.`grc_evento_participante` DROP COLUMN `idt_pessoa`,
 DROP COLUMN `idt_empreendimento`,
 ADD COLUMN `idt_stand` INTEGER UNSIGNED AFTER `idt_atendimento`,
 ADD COLUMN `data_pagamento` DATE AFTER `idt_stand`,
 ADD COLUMN `valor_pagamento` NUMERIC(15,2) AFTER `data_pagamento`;


ALTER TABLE `db_pir_grc`.`grc_evento_participante` DROP COLUMN `idt_evento_relacao_participante`,
 DROP INDEX `iu_grc_evento_participante_relacao`,
 ADD INDEX `iu_grc_evento_participante_relacao` USING BTREE(`idt_evento`);

ALTER TABLE `db_pir_grc`.`grc_evento_participante` ADD CONSTRAINT `FK_grc_evento_participante_3` FOREIGN KEY `FK_grc_evento_participante_3` (`idt_stand`)
    REFERENCES `grc_evento_stand` (`idt`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE;


ALTER TABLE `db_pir_grc`.`grc_evento_participante` MODIFY COLUMN `ativo` VARCHAR(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT 'N';

ALTER TABLE `grc_atendimento_pessoa`
MODIFY COLUMN `nome`  varchar(120) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL AFTER `cpf`;

ALTER TABLE `grc_evento_participante` DROP FOREIGN KEY `FK_grc_evento_participante`;

ALTER TABLE `grc_evento_participante`
DROP COLUMN `idt_evento`,
DROP COLUMN `idt_entidade`,
MODIFY COLUMN `idt_atendimento`  int(10) UNSIGNED NULL DEFAULT NULL AFTER `idt`,
DROP INDEX `iu_grc_evento_participante`,
DROP INDEX `iu_grc_evento_participante_entidade`,
DROP INDEX `iu_grc_evento_participante_codigo`,
DROP INDEX `FK_grc_evento_participante`,
DROP INDEX `iu_grc_evento_participante_relacao`;

ALTER TABLE `grc_evento_participante` ADD CONSTRAINT `FK_grc_evento_participante_4` FOREIGN KEY (`idt_midia`) REFERENCES `db_pir_gec`.`gec_meio_informacao` (`idt`) ON DELETE RESTRICT ON UPDATE RESTRICT;

-- 05/01/2016

ALTER TABLE `grc_sincroniza_siac` DROP FOREIGN KEY `fk_grc_sincroniza_siac_2`;

ALTER TABLE `grc_sincroniza_siac` ADD CONSTRAINT `fk_grc_sincroniza_siac_2` FOREIGN KEY (`idt_atendimento`) REFERENCES `grc_atendimento` (`idt`) ON DELETE CASCADE ON UPDATE RESTRICT;

-- 06/01/2016

/*
Já executado em Homologação e Produção
ALTER TABLE db_pir_siac_ba.tbpaiacao ADD UNIQUE INDEX `un_tbpaiacao_2` (`rowguid`) ;
ALTER TABLE db_pir_siac_ba.tbpaipratif ADD UNIQUE INDEX `un_tbpaipratif_1` (`rowguid`) ;

CREATE TABLE `grc_produto_item` (
  `idt` INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  `idt_produto` INTEGER UNSIGNED NOT NULL,
  `descricao` VARCHAR(255) NOT NULL,
  `quantidade` DECIMAL(10,2) NOT NULL,
  `idt_insumo_unidade` INTEGER UNSIGNED NOT NULL,
  `detalhe` TEXT,
  PRIMARY KEY (`idt`),
  CONSTRAINT `fk_grc_produto_item_1` FOREIGN KEY `fk_grc_produto_item_1` (`idt_produto`)
    REFERENCES `grc_produto` (`idt`)
    ON DELETE CASCADE
    ON UPDATE RESTRICT,
  CONSTRAINT `fk_grc_produto_item_2` FOREIGN KEY `fk_grc_produto_item_2` (`idt_insumo_unidade`)
    REFERENCES `grc_insumo_unidade` (`idt`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT
)
ENGINE = InnoDB;

ALTER TABLE `grc_produto_item`
ADD UNIQUE INDEX `un_grc_produto_item_2` (`descricao`) ;

ALTER TABLE `grc_produto_item`
DROP INDEX `un_grc_produto_item_2` ,
ADD UNIQUE INDEX `un_grc_produto_item_2` (`idt_produto`, `descricao`) USING BTREE ;
*/

ALTER TABLE `grc_produto_insumo` MODIFY COLUMN `descricao` VARCHAR(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL;

-- 08/01/2016

TRUNCATE grc_projeto_acao_orcamentaria;

ALTER TABLE db_pir.plu_usuario ADD COLUMN codparceiro_siacweb  int(10) NULL DEFAULT NULL AFTER `cpf`;
ALTER TABLE db_pir_gec.plu_usuario ADD COLUMN codparceiro_siacweb  int(10) NULL DEFAULT NULL AFTER `cpf`;
ALTER TABLE db_sebrae_pfo.plu_usuario ADD COLUMN codparceiro_siacweb  int(10) NULL DEFAULT NULL AFTER `cpf`;

-- 09/01/2016

ALTER TABLE `grc_projeto`
ADD COLUMN `idt_responsavel`  int(10) NULL AFTER `codparceiro_siacweb`;

ALTER TABLE `grc_projeto` ADD CONSTRAINT `fk_grc_projeto_1` FOREIGN KEY (`idt_responsavel`) REFERENCES `plu_usuario` (`id_usuario`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `grc_evento`
MODIFY COLUMN `idt_gestor_projeto`  int(10) NULL DEFAULT NULL AFTER `idt_acao`;

ALTER TABLE `grc_evento` ADD CONSTRAINT `FK_grc_evento_24` FOREIGN KEY (`idt_gestor_projeto`) REFERENCES `plu_usuario` (`id_usuario`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `grc_atendimento_instrumento_metrica`
ADD COLUMN `participacao_sebrae`  varchar(4) NULL AFTER `ano`;

ALTER TABLE `grc_atendimento_instrumento_metrica`
DROP INDEX `un_grc_atendimento_instrumento_metrica_2` ,
ADD UNIQUE INDEX `un_grc_atendimento_instrumento_metrica_2` (`idt_atendimento_instrumento`, `ano`, `participacao_sebrae`) USING BTREE ;

-- 11/01/2016

ALTER TABLE `grc_atendimento_pessoa_arquivo_interesse` MODIFY COLUMN `data_registro` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP;
ALTER TABLE `grc_atendimento_pessoa_produto_interesse` MODIFY COLUMN `data_registro` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP;
ALTER TABLE `grc_atendimento_pessoa_tema_interesse` MODIFY COLUMN `data_registro` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP;

ALTER TABLE `grc_projeto_acao`
ADD COLUMN `idt_responsavel`  int(10) NULL DEFAULT NULL AFTER `codparceiro_siacweb`,
ADD COLUMN `codgestor`  varchar(40) NULL DEFAULT '' AFTER `idt_responsavel`,
ADD COLUMN `nomegestor`  varchar(200) NULL DEFAULT '' AFTER `codgestor`,
ADD COLUMN `usuario`  varchar(60) NULL DEFAULT '' AFTER `nomegestor`,
ADD COLUMN `codunidade`  varchar(40) NULL DEFAULT '' AFTER `usuario`,
ADD COLUMN `nomeunidade`  varchar(200) NULL DEFAULT '' AFTER `codunidade`,
ADD COLUMN `idt_unidade`  int(10) NULL DEFAULT NULL AFTER `nomeunidade`;

ALTER TABLE `grc_projeto_acao` ADD CONSTRAINT `FK_grc_projeto_acao_2` FOREIGN KEY (`idt_responsavel`) REFERENCES `plu_usuario` (`id_usuario`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `grc_projeto_acao` ADD CONSTRAINT `FK_grc_projeto_acao_3` FOREIGN KEY (`idt_unidade`) REFERENCES `db_pir`.`sca_organizacao_secao` (`idt`) ON DELETE RESTRICT ON UPDATE RESTRICT;

INSERT INTO `grc_insumo` (`codigo`, `descricao`, `ativo`, `detalhe`, `classificacao`, `idt_insumo_elemento_custo`, `idt_insumo_unidade`, `custo_unitario_real`, `por_participante`, `nivel`, `sinal`, `codigo_rm`, `tipo`, `idprd`, `evento_insc_receita`, `idt_area_suporte`) VALUES ('80000', 'RECEITAS', 'N', NULL, '80', NULL, NULL, NULL, NULL, 'N', 'N', NULL, 'R', NULL, 'N', NULL);
INSERT INTO `grc_insumo` (`codigo`, `descricao`, `ativo`, `detalhe`, `classificacao`, `idt_insumo_elemento_custo`, `idt_insumo_unidade`, `custo_unitario_real`, `por_participante`, `nivel`, `sinal`, `codigo_rm`, `tipo`, `idprd`, `evento_insc_receita`, `idt_area_suporte`) VALUES ('80001', 'RECEITA DE INSCRIÇÃO', 'N', 'RECEITA RESULTANTE DO PROCESSO DE INSCRIÇÃO', '80.01.01', NULL, '1', NULL, 'S', 'S', 'N', NULL, 'R', NULL, 'S', NULL);
INSERT INTO `grc_insumo` (`codigo`, `descricao`, `ativo`, `detalhe`, `classificacao`, `idt_insumo_elemento_custo`, `idt_insumo_unidade`, `custo_unitario_real`, `por_participante`, `nivel`, `sinal`, `codigo_rm`, `tipo`, `idprd`, `evento_insc_receita`, `idt_area_suporte`) VALUES ('80002', 'RECEITA  DIRETA', 'N', 'RECEITA PROVENIENTE DE RECEBIMENTOS DIRETOS EM FUNÇÃO DO EVENTO, INSCRIÇÕES, VENDAS DE LIVROS ETC...', '80.01', NULL, NULL, NULL, NULL, 'N', 'N', NULL, 'R', NULL, 'N', NULL);
INSERT INTO `grc_insumo` (`codigo`, `descricao`, `ativo`, `detalhe`, `classificacao`, `idt_insumo_elemento_custo`, `idt_insumo_unidade`, `custo_unitario_real`, `por_participante`, `nivel`, `sinal`, `codigo_rm`, `tipo`, `idprd`, `evento_insc_receita`, `idt_area_suporte`) VALUES ('80003', 'RECEITAS DE TERCEIROS', 'N', 'RECEITA PROVENIENTE DE ENTIDADES EXTERNAS AO SEBRAE, PATROCINADORES, PARTICIPAÇÃO DE CLIENTES, ETC.', '80.05', NULL, NULL, NULL, NULL, 'N', 'N', NULL, 'R', NULL, 'N', NULL);
INSERT INTO `grc_insumo` (`codigo`, `descricao`, `ativo`, `detalhe`, `classificacao`, `idt_insumo_elemento_custo`, `idt_insumo_unidade`, `custo_unitario_real`, `por_participante`, `nivel`, `sinal`, `codigo_rm`, `tipo`, `idprd`, `evento_insc_receita`, `idt_area_suporte`) VALUES ('80004', 'RECEITA DE PATROCINADORES', 'N', 'RECEITA PROVENIENTE DE VALORES RECEBIDOS COM PATROCÍNIO E PARTICIPAÇÃO DE CLIENTES', '80.05.01', NULL, '1', NULL, 'N', 'S', 'N', NULL, 'R', NULL, 'N', NULL);

-- 12/01/2016

ALTER TABLE `grc_sincroniza_siac`
MODIFY COLUMN `idt_atendimento`  int(10) UNSIGNED NULL AFTER `idt_entidade`,
ADD COLUMN `idt_evento`  int(10) UNSIGNED NULL AFTER `idt_atendimento`;

ALTER TABLE `grc_sincroniza_siac` ADD CONSTRAINT `fk_grc_sincroniza_siac_3` FOREIGN KEY (`idt_evento`) REFERENCES `grc_evento` (`idt`) ON DELETE CASCADE ON UPDATE RESTRICT;

ALTER TABLE `grc_sincroniza_siac`
MODIFY COLUMN `tipo`  varchar(2) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL AFTER `idt_evento`;

ALTER TABLE `grc_atendimento_instrumento`
ADD COLUMN `codigo_tipoevento_siac`  int(10) NULL AFTER `codigo_familia_siac`;

UPDATE `grc_atendimento_instrumento` SET `codigo_tipoevento_siac`='11' WHERE (`idt`='39');
UPDATE `grc_atendimento_instrumento` SET `codigo_tipoevento_siac`='2' WHERE (`idt`='40');
UPDATE `grc_atendimento_instrumento` SET `codigo_tipoevento_siac`='12' WHERE (`idt`='46');
UPDATE `grc_atendimento_instrumento` SET `codigo_tipoevento_siac`='4' WHERE (`idt`='47');
UPDATE `grc_atendimento_instrumento` SET `codigo_tipoevento_siac`='7' WHERE (`idt`='49');

ALTER TABLE `grc_evento_local_pa`
DROP COLUMN `idt_cidade`,
DROP COLUMN `logradouro_bairro`,
DROP COLUMN `logradouro_estado`,
DROP COLUMN `logradouro_pais`,
ADD COLUMN `logradouro_codbairro`  int(11) NULL DEFAULT NULL AFTER `cep`,
ADD COLUMN `logradouro_codcid`  int(11) NULL DEFAULT NULL AFTER `logradouro_codbairro`,
ADD COLUMN `logradouro_codest`  int(11) NULL DEFAULT NULL AFTER `logradouro_codcid`,
ADD COLUMN `logradouro_codpais`  int(11) NULL DEFAULT NULL AFTER `logradouro_codest`;

-- 14/01/2016

ALTER TABLE `grc_evento`
ADD COLUMN `area_codigo_siacweb`  int(40) NULL AFTER `idt_ponto_atendimento_tela`,
ADD COLUMN `local_codigo_siacweb`  int(40) NULL AFTER `idt_local`;

-- 15/01/2016

ALTER TABLE `grc_evento`
MODIFY COLUMN `frequencia_min`  int(10) NULL DEFAULT NULL AFTER `data_criacao`;

-- producao
-- homologa
