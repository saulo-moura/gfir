/*
-- 22/11/2016

INSERT INTO `db_pir_grc`.`plu_direito_funcao` (`id_direito`, `id_funcao`, `descricao`) VALUES ('5', '767', 'Se esta opção estiver marcada vai poder Consultar todos os registros de atendimentos.');
INSERT INTO `db_pir_grc`.`plu_direito_funcao` (`id_direito`, `id_funcao`, `descricao`) VALUES ('5', '796', 'Se esta opção estiver marcada vai poder Consultar todos os registros de atendimentos.');

-- 24/11/2016

ALTER TABLE `grc_atendimento`
ADD COLUMN `idt_consultor_prox_atend`  int(11) NULL AFTER `idt_digitador`,
ADD INDEX `FK_grc_atendimento_29` (`idt_consultor_prox_atend`) USING BTREE ;

ALTER TABLE `grc_atendimento` ADD CONSTRAINT `FK_grc_atendimento_29` FOREIGN KEY (`idt_consultor_prox_atend`) REFERENCES `plu_usuario` (`id_usuario`) ON DELETE RESTRICT ON UPDATE RESTRICT;

update grc_atendimento set idt_consultor_prox_atend = idt_consultor
where idt_grupo_atendimento is not null;

-- 25/11/2016

ALTER TABLE `grc_atendimento`
ADD INDEX `iu_grc_atendimento_1` (`idt_grupo_atendimento`, `nan_num_visita`) ;

ALTER TABLE `plu_log_sistema`
ADD INDEX `un_plu_log_sistema_1` (`login`) ,
ADD INDEX `un_plu_log_sistema_2` (`nom_usuario`) ,
ADD INDEX `un_plu_log_sistema_3` (`nom_tela`) ,
ADD INDEX `un_plu_log_sistema_4` (`sts_acao`) ,
ADD INDEX `un_plu_log_sistema_5` (`dtc_registro`) ,
ADD INDEX `un_plu_log_sistema_6` (`des_pk`);

ALTER TABLE `plu_erro_log`
ADD INDEX `un_plu_erro_log_1` (`data`, `idt`) ;

-- 21/10/2016

update plu_funcao set des_prefixo = 'cadastro', prefixo_menu = 'cadastro' where cod_funcao = 'grc_nan_transferir_atendimento';

-- 27/10/2016

ALTER TABLE `grc_produto`
ADD COLUMN `tipo_calculo`  char(1) NULL AFTER `pc_seminario`,
ADD COLUMN `forcar_carga_horarria`  char(1) NULL AFTER `tipo_calculo`;

update grc_produto set forcar_carga_horarria = 'N'
where idt_instrumento = 39
and (idt_programa <> 4 
or idt_programa is null
);
*/

-- 05/11/2016

ALTER TABLE `grc_evento`
ADD COLUMN `dt_real_ini`  datetime NULL AFTER `tipo_sincroniza_siacweb_old`,
ADD COLUMN `seg_real_ini`  char(3) NULL AFTER `dt_real_ini`,
ADD COLUMN `siacweb_hist_hora_ini`  datetime NULL AFTER `seg_real_ini`;

UPDATE grc_evento SET 
	siacweb_hist_hora_ini = concat(dt_previsao_inicial, ' ', hora_inicio)
WHERE
	idt_evento_situacao = 20;

ALTER TABLE `plu_usuario`
ADD COLUMN `evento_muda_dt_real_ini_hist`  char(1) NOT NULL DEFAULT 'N' AFTER `evento_sincroniza_rm`;

-- 07/11/2016

ALTER TABLE `grc_evento`
MODIFY COLUMN `seg_real_ini`  char(3) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL AFTER `tipo_sincroniza_siacweb_old`,
ADD COLUMN `muda_dt_hist`  char(1) NOT NULL DEFAULT 'N' AFTER `tipo_sincroniza_siacweb_old`,
ADD COLUMN `dt_real_fim`  datetime NULL AFTER `dt_real_ini`,
ADD COLUMN `siacweb_hist_hora_fim`  datetime NULL AFTER `siacweb_hist_hora_ini`;

UPDATE grc_evento SET 
	siacweb_hist_hora_fim = concat(dt_previsao_fim, ' ', hora_fim)
WHERE
	idt_evento_situacao = 20;

-- 11/11/2016

ALTER TABLE `grc_evento_participante`
ADD COLUMN `ativo`  char(1) NOT NULL DEFAULT 'S' AFTER `idt_atendimento`;

UPDATE `grc_atendimento_instrumento` SET `descricao`='Evento Composto' WHERE (`idt`='52');

ALTER TABLE `grc_atendimento`
ADD COLUMN `idt_atendimento_pai`  int(10) UNSIGNED NULL AFTER `idt_evento`;

ALTER TABLE `grc_atendimento` ADD CONSTRAINT `FK_grc_atendimento_28` FOREIGN KEY (`idt_atendimento_pai`) REFERENCES `grc_atendimento` (`idt`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `grc_atendimento`
DROP INDEX `iu_grc_atendimento` ,
ADD INDEX `iu_grc_atendimento` (`protocolo`) USING BTREE ;

-- 18/11/2016

ALTER TABLE `grc_atendimento_instrumento`
ADD COLUMN `idt_produto_tipo`  int(10) UNSIGNED NULL AFTER `descricao_matriz`;

ALTER TABLE `grc_atendimento_instrumento` ADD CONSTRAINT `FK_grc_atendimento_instrumento_2` FOREIGN KEY (`idt_produto_tipo`) REFERENCES `grc_produto_tipo` (`idt`) ON DELETE RESTRICT ON UPDATE RESTRICT;

update grc_atendimento_instrumento set idt_produto_tipo = 1 where nivel = 1;
update grc_atendimento_instrumento set idt_produto_tipo = 2 where idt = 39;

-- 16/12/2016

-- CLD
/* Já executado em Produção
ALTER TABLE `grc_atendimento_pessoa`
ADD COLUMN `siacweb_codcosultoria`  int(10) UNSIGNED NULL DEFAULT NULL AFTER `codigo_siacweb`;

update grc_atendimento a
inner join grc_atendimento_pessoa p on p.idt_atendimento = a.idt and p.tipo_relacao = 'L'
set p.siacweb_codcosultoria = a.siacweb_codcosultoria
where a.siacweb_codcosultoria is not null;

ALTER TABLE `grc_atendimento`
DROP COLUMN `siacweb_codcosultoria`;

ALTER TABLE `grc_atendimento_pessoa`
ADD COLUMN `siacweb_hist_erro_cod`  int(10) NULL DEFAULT NULL AFTER `falta_sincronizar_siacweb`,
ADD COLUMN `siacweb_hist_erro_msg`  varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL AFTER `siacweb_hist_erro_cod`;

update grc_atendimento a
inner join grc_atendimento_pessoa p on p.idt_atendimento = a.idt
set p.siacweb_hist_erro_cod = a.siacweb_hist_erro_cod, p.siacweb_hist_erro_msg = a.siacweb_hist_erro_msg
where a.siacweb_hist_erro_cod is not null;

ALTER TABLE `grc_atendimento`
DROP COLUMN `siacweb_hist_erro_cod`,
DROP COLUMN `siacweb_hist_erro_msg`;
*/

-- 21/12/2016

CREATE TABLE `grc_evento_declaracao` (
  `idt` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idt_evento` int(10) unsigned NOT NULL,
  `idt_pfo_af_processo` int(10) unsigned NOT NULL,
  `ativo` char(1) NOT NULL,
  `arquivo` varchar(255) NOT NULL,
  `md5` char(32) NOT NULL,
  `ip` varchar(45) NOT NULL,
  `login_aprovacao` varchar(150) NOT NULL,
  `codigo_evento` varchar(45) NOT NULL,
  `codigo_produto` varchar(45) DEFAULT NULL,
  `vl_despesa` decimal(15,2) NOT NULL,
  `vl_receita` decimal(15,2) NOT NULL,
  `codigo_os` varchar(45) NOT NULL,
  `vl_os` decimal(15,2) NOT NULL,
  `dt_aprovacao` datetime NOT NULL,
  `idt_usuario_aprovacao` int(10) NOT NULL,
  `dt_cancelamento` datetime DEFAULT NULL,
  `idt_usuario_cancelamento` int(10) DEFAULT NULL,
  PRIMARY KEY (`idt`),
  KEY `fk_grc_evento_declaracao_1` (`idt_evento`),
  KEY `fk_grc_evento_declaracao_2` (`idt_usuario_aprovacao`),
  KEY `fk_grc_evento_declaracao_3` (`idt_usuario_cancelamento`),
  KEY `fk_grc_evento_declaracao_4` (`idt_pfo_af_processo`),
  CONSTRAINT `fk_grc_evento_declaracao_4` FOREIGN KEY (`idt_pfo_af_processo`) REFERENCES `db_sebrae_pfo`.`pfo_af_processo` (`idt`),
  CONSTRAINT `fk_grc_evento_declaracao_1` FOREIGN KEY (`idt_evento`) REFERENCES `grc_evento` (`idt`),
  CONSTRAINT `fk_grc_evento_declaracao_2` FOREIGN KEY (`idt_usuario_aprovacao`) REFERENCES `plu_usuario` (`id_usuario`),
  CONSTRAINT `fk_grc_evento_declaracao_3` FOREIGN KEY (`idt_usuario_cancelamento`) REFERENCES `plu_usuario` (`id_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `grc_evento_anexo`
ADD COLUMN `so_consulta`  char(1) NOT NULL DEFAULT 'N' AFTER `arquivo`;

insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_evento_declaracao','Declaração de Conclusão dos Serviços no Evento','02.03.80','N','N','listar','listar');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_evento_declaracao') as id_funcao
from plu_direito where cod_direito in ('con');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df 
inner join plu_funcao f on df.id_funcao = f.id_funcao
inner join plu_direito d on df.id_direito = d.id_direito
where f.cod_funcao in ('grc_evento_declaracao');
-- and d.cod_direito in ('alt','con');

-- 28-10-2016

-- ALTER TABLE `db_pir_grc`.`plu_config` ADD COLUMN `classificacao` VARCHAR(45) AFTER `js`,
-- ADD INDEX `ix_classificacao`(`classificacao`);
 
 
 ALTER TABLE `db_pir_grc`.`plu_helpdesk` ADD COLUMN `msg_erro` TEXT AFTER `flag_logico`;




insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('xml_diversos','Lista XML Diversas','80','S','S','listar','listar');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'xml_diversos') as id_funcao
from plu_direito where cod_direito in ('alt','con','exc','inc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('xml_diversos');


insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('conteudo_xml_lista.php','Lista XML','80.03','S','S','janela','janela');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'conteudo_xml_lista.php') as id_funcao
from plu_direito where cod_direito in ('alt','con','exc','inc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('conteudo_xml_lista.php');

-- 21-11-2016
-- Agendamento

insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_parametros_agendamento','Parâmetros do Agendamento','05.90.90','S','S','inc','inc');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_parametros_agendamento') as id_funcao
from plu_direito where cod_direito in ('alt','con','exc','inc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_parametros_agendamento');

update plu_funcao set nm_funcao = "Cadastro de Serviços" where cod_funcao = 'grc_atendimento_especialidade';



CREATE TABLE `db_pir_grc`.`grc_agenda_parametro_sondagem` (
  `idt` INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  `codigo` VARCHAR(45) NOT NULL,
  `descricao` VARCHAR(120) NOT NULL,
  `ativo` VARCHAR(45) NOT NULL DEFAULT 'S',
  `detalhe` TEXT,
  PRIMARY KEY (`idt`),
  UNIQUE INDEX `iu_grc_agenda_parametro_sondagem`(`codigo`)
)
ENGINE = InnoDB;


ALTER TABLE `db_pir_grc`.`grc_atendimento_especialidade` ADD COLUMN `periodo` INTEGER UNSIGNED AFTER `detalhe`,
 ADD COLUMN `quantidade_periodo` INTEGER UNSIGNED AFTER `periodo`;

ALTER TABLE `db_pir_grc`.`grc_agenda_parametro_servico` DROP INDEX `iu_grc_agenda_parametro_servico`,
 ADD UNIQUE INDEX `iu_grc_agenda_parametro_servico` USING BTREE(`idt_parametro`, `idt_ponto_atendimento`, `idt_servico`);

ALTER TABLE `db_pir_grc`.`grc_atendimento_gera_agenda` ADD COLUMN `horario_semanal` CHar(1);


ALTER TABLE `db_pir_grc`.`grc_atendimento_agenda_servico`
 DROP FOREIGN KEY `FK_grc_atendimento_agenda_servico_1`;

ALTER TABLE `db_pir_grc`.`grc_atendimento_agenda_servico` ADD CONSTRAINT `FK_grc_atendimento_agenda_servico_1` FOREIGN KEY `FK_grc_atendimento_agenda_servico_1` (`idt_servico`)
    REFERENCES `grc_atendimento_especialidade` (`idt`)
    ON DELETE CASCADE
    ON UPDATE RESTRICT;


ALTER TABLE `db_pir_grc`.`grc_atendimento_agenda_servico`
 DROP FOREIGN KEY `FK_grc_atendimento_agenda_servico_2`;

ALTER TABLE `db_pir_grc`.`grc_atendimento_agenda_servico` ADD CONSTRAINT `FK_grc_atendimento_agenda_servico_2` FOREIGN KEY `FK_grc_atendimento_agenda_servico_2` (`idt`)
    REFERENCES `grc_atendimento_agenda` (`idt`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT;


ALTER TABLE `db_pir_grc`.`grc_atendimento_agenda_servico` ADD UNIQUE INDEX `UN_grc_atendimento_agenda_servico_1` USING BTREE(`idt`, `idt_servico`);


ALTER TABLE `db_pir_grc`.`grc_atendimento_agenda_servico`
 DROP FOREIGN KEY `FK_grc_atendimento_agenda_servico_2`;

ALTER TABLE `db_pir_grc`.`grc_atendimento_agenda_servico` ADD CONSTRAINT `FK_grc_atendimento_agenda_servico_2` FOREIGN KEY `FK_grc_atendimento_agenda_servico_2` (`idt`)
    REFERENCES `grc_atendimento_agenda` (`idt`)
    ON DELETE CASCADE
    ON UPDATE RESTRICT;
ALTER TABLE `db_pir_grc`.`grc_atendimento_agenda_servico`
 DROP FOREIGN KEY `FK_grc_atendimento_agenda_servico_2`;

ALTER TABLE `db_pir_grc`.`grc_atendimento_agenda_servico` MODIFY COLUMN `idt` INT(10) UNSIGNED NOT NULL,
 DROP PRIMARY KEY,
 ADD CONSTRAINT `FK_grc_atendimento_agenda_servico_2` FOREIGN KEY `FK_grc_atendimento_agenda_servico_2` (`idt`)
    REFERENCES `grc_atendimento_agenda` (`idt`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT;
ALTER TABLE `db_pir_grc`.`grc_atendimento_agenda_servico`
 DROP FOREIGN KEY `FK_grc_atendimento_agenda_servico_2`;

ALTER TABLE `db_pir_grc`.`grc_atendimento_agenda_servico` ADD CONSTRAINT `FK_grc_atendimento_agenda_servico_2` FOREIGN KEY `FK_grc_atendimento_agenda_servico_2` (`idt`)
    REFERENCES `grc_atendimento_agenda` (`idt`)
    ON DELETE CASCADE
    ON UPDATE RESTRICT;
ALTER TABLE `db_pir_grc`.`grc_agenda_parametro_suspensao` ADD COLUMN `tipo` CHAR(1) DEFAULT 'S' AFTER `observacao`;
ALTER TABLE `db_pir_grc`.`grc_agenda_parametro_suspensao` ADD COLUMN `geral` CHar(1) DEFAULT 'N' AFTER `tipo`;
ALTER TABLE `db_pir_grc`.`grc_agenda_parametro_suspensao` ADD COLUMN `excluir` CHAR(1) DEFAULT 'N' AFTER `geral`,
 ADD COLUMN `nacional` CHAR(1) DEFAULT 'N' AFTER `excluir`;
ALTER TABLE `db_pir_grc`.`grc_agenda_parametro_servico` ADD COLUMN `quantidade_periodo` INTEGER UNSIGNED AFTER `idt_servico`,
 ADD COLUMN `periodo` INTEGER UNSIGNED AFTER `quantidade_periodo`;


CREATE TABLE `db_pir_grc`.`grc_transferencia_responsabilidade` (
  `idt` INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  `codigo` VARCHAR(45) NOT NULL,
  `descricao` VARCHAR(120) NOT NULL,
  `ativo` CHAR(1) NOT NULL DEFAULT 'S',
  `detalhe` TEXT,
  PRIMARY KEY (`idt`),
  UNIQUE INDEX `iu_grc_transferencia_responsabilidade`(`codigo`)
)
ENGINE = InnoDB;


insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_transferencia_responsabilidade','Transferência de Responsabilidades','95.65.60','S','S','listar','listar');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_transferencia_responsabilidade') as id_funcao
from plu_direito where cod_direito in ('alt','con','exc','inc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_transferencia_responsabilidade');

ALTER TABLE `db_pir_grc`.`grc_transferencia_responsabilidade` ADD COLUMN `idt_colaborador_origem` INTEGER UNSIGNED NOT NULL AFTER `detalhe`,
 ADD COLUMN `idt_colaborador_destino` INTEGER UNSIGNED NOT NULL AFTER `idt_colaborador_origem`,
 ADD COLUMN `data_validade` DATE NOT NULL AFTER `idt_colaborador_destino`,
 ADD COLUMN `justificativa` TEXT AFTER `data_validade`;


ALTER TABLE `db_pir_grc`.`grc_atendimento_especialidade` ADD COLUMN `opcoes_escolher` VARCHAR(255) NOT NULL AFTER `quantidade_periodo`;



ALTER TABLE `db_pir_grc`.`grc_atendimento_pa_pessoa_servico` MODIFY COLUMN `idt` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
 DROP PRIMARY KEY,
 ADD PRIMARY KEY  USING BTREE(`idt`),
 DROP FOREIGN KEY `fk_grc_atendimento_pa_pessoa_servico_1`;


ALTER TABLE `db_pir_grc`.`grc_atendimento_pa_pessoa_servico` ADD COLUMN `idt_pa_pessoa` INTEGER UNSIGNED NOT NULL AFTER `idt_servico`;

ALTER TABLE `db_pir_grc`.`grc_atendimento_pa_pessoa_servico` ADD COLUMN `periodo` INTEGER UNSIGNED AFTER `idt_pa_pessoa`;



insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_atendimento_pa_pessoa_servico','Serviçõs da pessoa no PA','05.90.35.03','S','S','listar','listar');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_atendimento_pa_pessoa_servico') as id_funcao
from plu_direito where cod_direito in ('alt','con','exc','inc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_atendimento_pa_pessoa_servico');

ALTER TABLE `db_pir_grc`.`grc_atendimento_pa_pessoa_servico` ADD COLUMN `idt_servico_duracao` INTEGER UNSIGNED AFTER `periodo`;


insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_atendimento_especialidade_duracao','Duração do Serviço','05.90.03.03','S','S','listar','listar');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_atendimento_especialidade_duracao') as id_funcao
from plu_direito where cod_direito in ('alt','con','exc','inc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_atendimento_especialidade_duracao');


CREATE TABLE `db_pir_grc`.`grc_atendimento_especialidade_duracao` (
  `idt` INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  `idt_especialidade` INTEGER UNSIGNED NOT NULL,
  `duracao` INTEGER UNSIGNED NOT NULL,
  PRIMARY KEY (`idt`),
  UNIQUE INDEX `iu_grc_atendimento_especialidade_duracao`(`idt_especialidade`, `duracao`),
  CONSTRAINT `FK_grc_atendimento_especialidade_duracao_1` FOREIGN KEY `FK_grc_atendimento_especialidade_duracao_1` (`idt_especialidade`)
    REFERENCES `grc_atendimento_especialidade` (`idt`)
    ON DELETE CASCADE
    ON UPDATE RESTRICT
)
ENGINE = InnoDB;

-- 04-12-2016

CREATE TABLE `db_pir_grc`.`grc_prazo_sms` (
  `idt` INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  `codigo` VARCHAR(45) NOT NULL,
  `descricao` VARCHAR(120) NOT NULL,
  `ativo` CHAR(1) NOT NULL,
  `detalhe` TEXT,
  PRIMARY KEY (`idt`),
  UNIQUE INDEX `iu_grc_prazo_sms`(`codigo`)
)
ENGINE = InnoDB;


insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_prazo_sms','Prazo envio SMS','05.90.65','S','S','listar','listar');
insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_prazo_sms') as id_funcao
from plu_direito where cod_direito in ('alt','con','exc','inc');
insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_prazo_sms');

ALTER TABLE `db_pir_grc`.`grc_prazo_sms` MODIFY COLUMN `codigo` INTEGER UNSIGNED NOT NULL;

/*
Navicat MySQL Data Transfer

Source Server         : 1 - Desenvolve
Source Server Version : 50625
Source Host           : 10.6.14.40:3306
Source Database       : db_pir_grc

Target Server Type    : MYSQL
Target Server Version : 50625
File Encoding         : 65001

Date: 2017-02-22 17:30:00
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for grc_agenda_parametro
-- ----------------------------
DROP TABLE IF EXISTS `grc_agenda_parametro`;
CREATE TABLE `grc_agenda_parametro` (
  `idt` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `codigo` varchar(45) NOT NULL,
  `descricao` varchar(120) NOT NULL,
  `ativo` char(1) NOT NULL DEFAULT 'S',
  `detalhe` text,
  `mesmo_dia` char(1) NOT NULL DEFAULT 'N',
  `abstencao_dias` int(10) unsigned NOT NULL DEFAULT '3',
  `multiplos_agendamentos` char(1) NOT NULL DEFAULT 'S',
  `envia_sms_confirmacao` char(1) NOT NULL DEFAULT 'N',
  `prazo_sms_confirmacao` int(10) unsigned DEFAULT '1',
  `envia_sms_cancelamento` char(1) NOT NULL DEFAULT 'N',
  `prazo_sms_cancelamento` int(10) unsigned DEFAULT '1',
  `texto_sms_confirmacao` varchar(255) DEFAULT NULL,
  `texto_sms_cancelamento` varchar(255) DEFAULT NULL,
  `tolerancia_atraso` int(10) unsigned NOT NULL DEFAULT '0',
  `envia_sms_vespera` char(1) DEFAULT NULL,
  `envia_sms_agradecimento` char(1) DEFAULT NULL,
  `envia_sms_cancelamento_sebrae` char(1) DEFAULT NULL,
  `prazo_sms_vespera` int(10) unsigned DEFAULT NULL,
  `prazo_sms_agradecimento` int(10) unsigned DEFAULT NULL,
  `prazo_sms_cancelamento_sebrae` int(10) unsigned DEFAULT NULL,
  `texto_sms_vespera` varchar(255) DEFAULT NULL,
  `texto_sms_agradecimento` varchar(255) DEFAULT NULL,
  `texto_sms_cancelamento_sebrae` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`idt`),
  UNIQUE KEY `iu_grc_agenda_parametro` (`codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE `db_pir_grc`.`grc_agenda_parametro_sondagem_grupo` (
  `idt` INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  `codigo` VARCHAR(45) NOT NULL,
  `descricao` VARCHAR(125) NOT NULL,
  `ativo` CHAR(1) DEFAULT 'S',
  `detalhe` TEXT,
  PRIMARY KEY (`idt`),
  UNIQUE INDEX `iu_grc_agenda_parametro_sondagem_grupo`(`codigo`)
)
ENGINE = InnoDB;


insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_agenda_parametro_sondagem_grupo','Grupo de Perguntas de Sondagem','05.90.67','S','S','listar','listar');
insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_agenda_parametro_sondagem_grupo') as id_funcao
from plu_direito where cod_direito in ('alt','con','exc','inc');
insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_agenda_parametro_sondagem_grupo');

ALTER TABLE `db_pir_grc`.`grc_agenda_parametro_sondagem` ADD COLUMN `idt_grupo` INTEGER UNSIGNED NOT NULL AFTER `detalhe`,
 DROP INDEX `iu_grc_agenda_parametro_sondagem`,
 ADD UNIQUE INDEX `iu_grc_agenda_parametro_sondagem` USING BTREE(`idt_grupo`, `codigo`);


ALTER TABLE `db_pir_grc`.`grc_agenda_parametro_sondagem` ADD CONSTRAINT `FK_grc_agenda_parametro_sondagem_1` FOREIGN KEY `FK_grc_agenda_parametro_sondagem_1` (`idt_grupo`)
    REFERENCES `grc_agenda_parametro_sondagem_grupo` (`idt`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT;
ALTER TABLE `db_pir_grc`.`grc_atendimento_especialidade` ADD COLUMN `tipo_atendimento` CHAR(1) NOT NULL DEFAULT 'P' AFTER `opcoes_escolher`;
ALTER TABLE `db_pir_grc`.`grc_atendimento_especialidade` DROP INDEX `iu_grc_atendimento_especialidade`,
 ADD UNIQUE INDEX `iu_grc_atendimento_especialidade` USING BTREE(`tipo_atendimento`, `codigo`);


CREATE TABLE `db_pir_grc`.`grc_atendimento_especialidade_acao` (
  `idt` INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  `idt_especialidade` INTEGER UNSIGNED NOT NULL,
  `tipo_acao` VARCHAR(45) NOT NULL DEFAULT 'R',
  `descricao` VARCHAR(120) NOT NULL,
  `codigo` VARCHAR(45) NOT NULL,
  `ativo` CHAR(1) NOT NULL DEFAULT 'S',
  `detalhe` TEXT,
  PRIMARY KEY (`idt`),
  INDEX `iu_grc_atendimento_especialidade_acao`(`idt_especialidade`, `codigo`),
  CONSTRAINT `FK_grc_atendimento_especialidade_acao_1` FOREIGN KEY `FK_grc_atendimento_especialidade_acao_1` (`idt_especialidade`)
    REFERENCES `grc_atendimento_especialidade` (`idt`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT
)
ENGINE = InnoDB;

insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_atendimento_especialidade_acao','Ação para um Serviço','05.90.03.05','N','N','listar','listar');
insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_atendimento_especialidade_acao') as id_funcao
from plu_direito where cod_direito in ('alt','con','exc','inc');
insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_atendimento_especialidade_acao');


ALTER TABLE `db_pir_grc`.`grc_atendimento_especialidade_acao` ADD COLUMN `arquivo_cab` VARCHAR(120) AFTER `detalhe`,
 ADD COLUMN `arquivo_rod` VARCHAR(120) AFTER `arquivo_cab`;


ALTER TABLE `db_pir_grc`.`grc_atendimento_especialidade_acao` ADD COLUMN `introducao_texto` TEXT AFTER `arquivo_rod`,
 ADD COLUMN `observacao_texto` TEXT AFTER `introducao_texto`;


CREATE TABLE `db_pir_grc`.`grc_atendimento_especialidade_acao_anexo` (
  `idt` INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  `idt_especialidade_acao` INTEGER UNSIGNED NOT NULL,
  `codigo` VARCHAR(45) NOT NULL,
  `descricao` VARCHAR(120) NOT NULL,
  `ativo` CHAR(1) NOT NULL DEFAULT 'S',
  `detalhe` TEXT,
  `arquivo` VARCHAR(120) NOT NULL,
  PRIMARY KEY (`idt`),
  UNIQUE INDEX `iu_grc_atendimento_especialidade_acao_anexo`(`idt_especialidade_acao`, `codigo`),
  CONSTRAINT `FK_grc_atendimento_especialidade_acao_anexo_1` FOREIGN KEY `FK_grc_atendimento_especialidade_acao_anexo_1` (`idt_especialidade_acao`)
    REFERENCES `grc_atendimento_especialidade_acao` (`idt`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT
)
ENGINE = InnoDB;

insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_atendimento_especialidade_acao_anexo','Anexo da Ação para um Serviço','05.90.03.05.03','N','N','listar','listar');
insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_atendimento_especialidade_acao_anexo') as id_funcao
from plu_direito where cod_direito in ('alt','con','exc','inc');
insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_atendimento_especialidade_acao_anexo');


CREATE TABLE `db_pir_grc`.`grc_atendimento_modalidade` (
  `idt` INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  `codigo` VARCHAR(45) NOT NULL,
  `descricao` VARCHAR(120) NOT NULL,
  `ativo` CHAR(1) NOT NULL DEFAULT 'S',
  `detalhe` TEXT,
  PRIMARY KEY (`idt`),
  UNIQUE INDEX `iu_grc_atendimento_modalidade`(`codigo`)
)
ENGINE = InnoDB;


insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_atendimento_modalidade','Modalidade do Atendimento','05.90.54','S','S','listar','listar');
insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_atendimento_modalidade') as id_funcao
from plu_direito where cod_direito in ('alt','con','exc','inc');
insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_atendimento_modalidade');


ALTER TABLE `db_pir_grc`.`grc_atendimento_modalidade` ADD COLUMN `tipo_atendimento` CHAR(1) NOT NULL DEFAULT 'D' AFTER `detalhe`;

ALTER TABLE `db_pir_grc`.`grc_atendimento` ADD COLUMN `idt_modalidade` INTEGER UNSIGNED AFTER `siacweb_codconst`;

ALTER TABLE `db_pir_grc`.`grc_atendimento` ADD COLUMN `recomendacao` TEXT AFTER `idt_modalidade`,
 ADD COLUMN `solucao_sebrae` TEXT AFTER `recomendacao`;

CREATE TABLE `db_pir_grc`.`grc_atendimento_especialidade_gestor` (
  `idt` INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  `idt_especialidade` INTEGER UNSIGNED NOT NULL,
  `idt_gestor` INTEGER UNSIGNED NOT NULL,
  PRIMARY KEY (`idt`),
  UNIQUE INDEX `iu_grc_atendimento_especialidade_gestor`(`idt_especialidade`, `idt_gestor`)
)
ENGINE = InnoDB;

ALTER TABLE `db_pir_grc`.`grc_atendimento_especialidade_gestor` ADD CONSTRAINT `FK_grc_atendimento_especialidade_gestor_1` FOREIGN KEY `FK_grc_atendimento_especialidade_gestor_1` (`idt_especialidade`)
    REFERENCES `grc_atendimento_especialidade` (`idt`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT;


ALTER TABLE `db_pir_grc`.`grc_atendimento_especialidade_gestor` MODIFY COLUMN `idt_gestor` INT(10) NOT NULL,
 ADD CONSTRAINT `FK_grc_atendimento_especialidade_gestor_2` FOREIGN KEY `FK_grc_atendimento_especialidade_gestor_2` (`idt_gestor`)
    REFERENCES `plu_usuario` (`id_usuario`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT;
	
	
insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_atendimento_especialidade_gestor','Gestor para o Serviço','05.90.03.06','N','N','listar','listar');
insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_atendimento_especialidade_gestor') as id_funcao
from plu_direito where cod_direito in ('alt','con','exc','inc');
insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_atendimento_especialidade_gestor');
	
	
ALTER TABLE `db_pir_grc`.`grc_atendimento_especialidade_acao` ADD COLUMN `cor` varchar(45) AFTER `observacao_texto`,
 ADD COLUMN `largura` INTEGER UNSIGNED AFTER `cor`;


ALTER TABLE `db_pir_grc`.`grc_atendimento` ADD COLUMN `idt_servico` INTEGER UNSIGNED AFTER `solucao_sebrae`,
 ADD CONSTRAINT `FK_grc_atendimento_30` FOREIGN KEY `FK_grc_atendimento_30` (`idt_servico`)
    REFERENCES `grc_atendimento_especialidade` (`idt`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT;
ALTER TABLE `db_pir_grc`.`grc_atendimento_especialidade` ADD COLUMN `idt_acao` INTEGER UNSIGNED AFTER `tipo_atendimento`,
 ADD CONSTRAINT `FK_grc_atendimento_especialidade_1` FOREIGN KEY `FK_grc_atendimento_especialidade_1` (`idt_acao`)
    REFERENCES `grc_atendimento_especialidade_acao` (`idt`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT;

ALTER TABLE `db_pir_grc`.`grc_atendimento_especialidade_acao` ADD UNIQUE INDEX `Index_3`(`idt_especialidade`, `tipo_acao`);




insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_atendimento_agenda_ausencia','Agenda - Registrar ausência','05.56.54','N','N','listar','listar');
insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_atendimento_agenda_ausencia') as id_funcao
from plu_direito where cod_direito in ('alt','con','exc','inc');
insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_atendimento_agenda_ausencia');

insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_atendimento_agenda_excluir','Agenda - Excluir Agendamento','05.56.55','N','N','listar','listar');
insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_atendimento_agenda_excluir') as id_funcao
from plu_direito where cod_direito in ('alt','con','exc','inc');
insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_atendimento_agenda_excluir');

insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_atendimento_agenda_visualizar','Agenda - Visualizar','05.56.56','N','N','listar','listar');
insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_atendimento_agenda_visualizar') as id_funcao
from plu_direito where cod_direito in ('alt','con','exc','inc');
insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_atendimento_agenda_visualizar');


ALTER TABLE `db_pir_grc`.`grc_agenda_emailsms` ADD COLUMN `idt_processo` INTEGER UNSIGNED NOT NULL AFTER `detalhe`;

insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_agenda_emailsms_processo','Agenda - Processos para Email-SMS','05.56.05.03','N','N','listar','listar');
insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_agenda_emailsms_processo') as id_funcao
from plu_direito where cod_direito in ('alt','con','exc','inc');
insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_agenda_emailsms_processo');

CREATE TABLE `db_pir_grc`.`grc_agenda_emailsms_processo` (
  `idt` INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  `codigo` VARCHAR(45) NOT NULL,
  `descricao` VARCHAR(120) NOT NULL,
  `ativo` CHAR(1) NOT NULL DEFAULT 'S',
  `detalhe` TEXT,
  PRIMARY KEY (`idt`),
  UNIQUE INDEX `iu_grc_agenda_emailsms_processo`(`codigo`)
)
ENGINE = InnoDB;

ALTER TABLE `db_pir_grc`.`grc_agenda_emailsms` ADD COLUMN `tipo` CHAR(1) NOT NULL DEFAULT 'E' AFTER `idt_processo`;
ALTER TABLE `db_pir_grc`.`grc_agenda_emailsms_processo` ADD COLUMN `prazo` INTEGER UNSIGNED NOT NULL AFTER `detalhe`,
 ADD COLUMN `quando` CHAR(1) NOT NULL DEFAULT 'A' AFTER `prazo`;


ALTER TABLE `db_pir_grc`.`grc_agenda_emailsms_processo` MODIFY COLUMN `prazo` INT(10) UNSIGNED DEFAULT NULL,
 MODIFY COLUMN `quando` CHAR(1) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT 'A';

ALTER TABLE `db_pir_grc`.`grc_atendimento_agenda` ADD COLUMN `data_hora_ausencia` DATETIME AFTER `confirmado`;




-- comunicação com o cliente
-- 12-12-2016

CREATE TABLE `grc_comunicacao` (
  `idt` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `login` varchar(255) DEFAULT NULL,
  `datahora` datetime DEFAULT NULL,
  `ip` varchar(45) DEFAULT NULL,
  `anonimo_nome` varchar(120) DEFAULT NULL,
  `anomimo_email` varchar(120) DEFAULT NULL,
  `latitude` decimal(15,9) DEFAULT NULL,
  `longitude` decimal(15,9) DEFAULT NULL,
  `titulo` varchar(120) NOT NULL,
  `descricao` text NOT NULL,
  `macroprocesso` varchar(45) DEFAULT NULL,
  `protocolo` varchar(45) NOT NULL,
  `nome` varchar(120) DEFAULT NULL,
  `email` varchar(120) DEFAULT NULL,
  `navegador` varchar(1000) DEFAULT NULL,
  `tipo_dispositivo` varchar(255) DEFAULT NULL,
  `modelo` varchar(255) DEFAULT NULL,
  `status` char(1) NOT NULL DEFAULT 'A',
  `tipo_solicitacao` char(2) NOT NULL DEFAULT 'NA',
  `data_envio_email_comunicacao` datetime DEFAULT NULL,
  `mandou_email_comunicacao` varchar(120) DEFAULT NULL,
  `complemento` text,
  `idt_comunicacao` int(10) unsigned DEFAULT NULL,
  `flag_logico` char(1) NOT NULL DEFAULT 'I',
  `msg_erro` text,
  PRIMARY KEY (`idt`),
  UNIQUE KEY `iu_protocolo` (`protocolo`),
  KEY `ix_login` (`login`,`datahora`),
  KEY `ix_datahora` (`datahora`,`login`),
  KEY `ix_ip` (`ip`),
  KEY `ix_macroprocesso` (`macroprocesso`),
  KEY `FK_grc_comunicacao_1` (`idt_comunicacao`),
  CONSTRAINT `FK_grc_comunicacao_1` FOREIGN KEY (`idt_comunicacao`) REFERENCES `grc_comunicacao` (`idt`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `grc_comunicacao_anexo` (
  `idt` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idt_comunicacao` int(10) unsigned NOT NULL,
  `descricao` varchar(120) NOT NULL,
  `observacao` text,
  `idt_responsavel` int(11) NOT NULL,
  `data_responsavel` datetime NOT NULL,
  `arquivo` varchar(120) NOT NULL,
  PRIMARY KEY (`idt`),
  KEY `iu_grc_comunicacao_anexo` (`idt_comunicacao`,`descricao`),
  KEY `FK_grc_comunicacao_anexo_2` (`idt_responsavel`),
  CONSTRAINT `FK_grc_comunicacao_anexo_1` FOREIGN KEY (`idt_comunicacao`) REFERENCES `grc_comunicacao` (`idt`) ON UPDATE CASCADE,
  CONSTRAINT `FK_grc_comunicacao_anexo_2` FOREIGN KEY (`idt_responsavel`) REFERENCES `plu_usuario` (`id_usuario`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `grc_comunicacao_grupo` (
  `idt` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `protocolo` varchar(45) NOT NULL,
  `descricao` varchar(120) NOT NULL,
  `data_registro` int(10) unsigned NOT NULL,
  `idt_responsavel` int(10) unsigned NOT NULL,
  PRIMARY KEY (`idt`),
  UNIQUE KEY `iu_grc_comunicacao_grupo` (`protocolo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `grc_comunicacao_grupo_sa` (
  `idt` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idt_comunicacao_grupo` varchar(45) NOT NULL,
  `idt_comunicacao` varchar(45) NOT NULL,
  `data_registro` datetime NOT NULL,
  `idt_responsavel` int(10) unsigned NOT NULL,
  PRIMARY KEY (`idt`),
  UNIQUE KEY `iu_grc_comunicacao_grupo_sa` (`idt_comunicacao_grupo`,`idt_comunicacao`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `grc_comunicacao_interacao` (
  `idt` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `login` varchar(255) DEFAULT NULL,
  `datahora` datetime DEFAULT NULL,
  `ip` varchar(45) DEFAULT NULL,
  `anonimo_nome` varchar(120) DEFAULT NULL,
  `anomimo_email` varchar(120) DEFAULT NULL,
  `latitude` decimal(15,9) DEFAULT NULL,
  `longitude` decimal(15,9) DEFAULT NULL,
  `titulo` varchar(120) NOT NULL,
  `descricao` text NOT NULL,
  `macroprocesso` varchar(45) DEFAULT NULL,
  `protocolo` varchar(45) NOT NULL,
  `nome` varchar(120) DEFAULT NULL,
  `email` varchar(120) DEFAULT NULL,
  `navegador` varchar(1000) DEFAULT NULL,
  `tipo_dispositivo` varchar(255) DEFAULT NULL,
  `modelo` varchar(255) DEFAULT NULL,
  `status` char(1) NOT NULL DEFAULT 'A',
  `tipo_solicitacao` char(2) NOT NULL DEFAULT 'NA',
  `data_envio_email_comunicacao` datetime DEFAULT NULL,
  `mandou_email_comunicacao` varchar(120) DEFAULT NULL,
  `complemento` text,
  `idt_comunicacao_interacao` int(10) unsigned DEFAULT NULL,
  `idt_comunicacao` int(10) unsigned NOT NULL,
  `flag_logico` char(1) NOT NULL DEFAULT 'I',
  `numero_id_comunicacao_usuario` varchar(255) DEFAULT NULL,
  `idt_comunicacao_interacao_ref` int(10) unsigned DEFAULT NULL,
  `idt_email_conteudo` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`idt`),
  UNIQUE KEY `iu_protocolo` (`idt_comunicacao`,`protocolo`) USING BTREE,
  KEY `ix_login` (`login`,`datahora`),
  KEY `ix_datahora` (`datahora`,`login`),
  KEY `ix_ip` (`ip`),
  KEY `ix_macroprocesso` (`macroprocesso`),
  KEY `FK_grc_comunicacao_interacao_1` (`idt_comunicacao_interacao`),
  KEY `FK_grc_comunicacao_interacao_3` (`idt_email_conteudo`),
  CONSTRAINT `FK_grc_comunicacao_interacao_1` FOREIGN KEY (`idt_comunicacao_interacao`) REFERENCES `grc_comunicacao_interacao` (`idt`),
  CONSTRAINT `FK_grc_comunicacao_interacao_2` FOREIGN KEY (`idt_comunicacao`) REFERENCES `grc_comunicacao` (`idt`),
  CONSTRAINT `FK_grc_comunicacao_interacao_3` FOREIGN KEY (`idt_email_conteudo`) REFERENCES `plu_email_conteudo` (`idt`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_comunicacao_cliente','Agenda - Comunicação','20','S','S','listar','listar');
insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_comunicacao_cliente') as id_funcao
from plu_direito where cod_direito in ('alt','con','exc','inc');
insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_comunicacao_cliente');


insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_comunicacao','Agenda - Comunicação','20.03','S','S','listar','listar');
insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_comunicacao') as id_funcao
from plu_direito where cod_direito in ('alt','con','exc','inc');
insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_comunicacao');

insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_comunicacao_anexo','Agenda - Comunicação Anexos','20.03.03','N','N','listar','listar');
insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_comunicacao_anexo') as id_funcao
from plu_direito where cod_direito in ('alt','con','exc','inc');
insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_comunicacao_anexo');


insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_comunicacao_grupo','Agenda - Comunicação Grupo','20.05','S','S','listar','listar');
insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_comunicacao_grupo') as id_funcao
from plu_direito where cod_direito in ('alt','con','exc','inc');
insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_comunicacao_grupo');

insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_comunicacao_grupo_sa','Agenda - Comunicação Grupo sa','20.07','S','S','listar','listar');
insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_comunicacao_grupo_sa') as id_funcao
from plu_direito where cod_direito in ('alt','con','exc','inc');
insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_comunicacao_grupo_sa');

insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_comunicacao_interacao','Agenda - Comunicação Interação','20.03.05','N','N','listar','listar');
insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_comunicacao_interacao') as id_funcao
from plu_direito where cod_direito in ('alt','con','exc','inc');
insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_comunicacao_interacao');


ALTER TABLE `db_pir_grc`.`grc_comunicacao` ADD COLUMN `idt_externo` INTEGER UNSIGNED AFTER `msg_erro`,
 ADD COLUMN `processo` VARCHAR(45) AFTER `idt_externo`;
ALTER TABLE `db_pir_grc`.`grc_comunicacao` ADD COLUMN `cliente_nome` VARCHAR(120) AFTER `processo`,
 ADD COLUMN `cliente_email` VARCHAR(120) AFTER `cliente_nome`;


--

INSERT INTO `plu_config` (`variavel`,`descricao`,`valor`,`extra`,`js`,`classificacao`) VALUES 
 ('comunicacao_email_envio','Comunicação CRM: e-Mail Utilizado para Remetente','servicedesk@servico.sebraeba.com.br',NULL,'N','40.10'),
 ('comunicacao_host_smtp','Comunicação CRM: Host SMTP','10.6.14.42',NULL,'N','40.13'),
 ('comunicacao_port_smtp','Comunicação CRM: Porta do Servidor SMTP','25',NULL,'N','40.15'),
 ('comunicacao_login_smtp','Comunicação CRM: Login para autenticação no Servidor SMTP','servicedesk@servico.sebraeba.com.br',NULL,'N','40.17'),
 ('comunicacao_senha_smtp','Comunicação CRM: Senha para autenticação no Servidor SMTP','',NULL,'N','40.19'),
 ('comunicacao_smtp_secure','Comunicação CRM: SMTP Secure (tls, ssl ou vazio)','',NULL,'N','40.21'),
 ('comunicacao_email_nome','Comunicação CRM: Nome para Envio do Email','CRM - COMUNICAÇÃO',NULL,'N','40.11');


ALTER TABLE `db_pir_grc`.`grc_comunicacao` ADD COLUMN `idt_grc_agenda_emailsms` INTEGER UNSIGNED AFTER `cliente_email`,
 ADD CONSTRAINT `FK_grc_comunicacao_2` FOREIGN KEY `FK_grc_comunicacao_2` (`idt_grc_agenda_emailsms`)
    REFERENCES `grc_agenda_emailsms` (`idt`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT;

ALTER TABLE `db_pir_grc`.`grc_comunicacao` MODIFY COLUMN `tipo_solicitacao` CHAR(2) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT 'NA';


ALTER TABLE `db_pir_grc`.`grc_comunicacao` ADD COLUMN `sms` INTEGER UNSIGNED AFTER `idt_grc_agenda_emailsms`;



ALTER TABLE `db_pir_grc`.`plu_helpdesk` ADD COLUMN `numero_id_helpdesk_usuario` VARCHAR(120) AFTER `msg_erro`,
 ADD COLUMN `status_helpdesk_usuario` VARCHAR(120) AFTER `numero_id_helpdesk_usuario`;

ALTER TABLE `db_pir_grc`.`plu_helpdesk_interacao` ADD COLUMN `msg_erro` TEXT AFTER `idt_email_conteudo`;





insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_atendimento_pendencia_devolutiva','Pendência Atendimento Devolutiva Distância','95.65.28','S','S','listar','listar');
insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_atendimento_pendencia_devolutiva') as id_funcao
from plu_direito where cod_direito in ('alt','con','exc','inc');
insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_atendimento_pendencia_devolutiva');



ALTER TABLE `db_pir_grc`.`plu_email_conteudo` ADD COLUMN `situacao` VARCHAR(120) AFTER `nao_lida`;
ALTER TABLE `db_pir_grc`.`plu_helpdesk_interacao` ADD COLUMN `status_helpdesk_usuario` VARCHAR(120) AFTER `msg_erro`;


ALTER TABLE `db_pir_grc`.`grc_atendimento_agenda` ADD COLUMN `data_nascimento` DATE AFTER `data_hora_ausencia`;


ALTER TABLE `db_pir_grc`.`grc_atendimento_agenda` ADD COLUMN `sms_1` VARCHAR(45) AFTER `data_nascimento`;


ALTER TABLE `db_pir_grc`.`plu_helpdesk` MODIFY COLUMN `titulo` VARCHAR(500) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;


ALTER TABLE `db_pir_grc`.`plu_helpdesk_interacao` MODIFY COLUMN `titulo` VARCHAR(500) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;


ALTER TABLE `db_pir_grc`.`plu_helpdesk` MODIFY COLUMN `status_helpdesk_usuario` VARCHAR(120) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT 'INCLUIDO';




CREATE TABLE `db_pir_grc`.`plu_email_conteudo_anexo` (
  `idt` INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  `idt_plu_email_conteudo` INTEGER UNSIGNED NOT NULL,
  `nomeAnexo` VARCHAR(255) NOT NULL,
  `extensao` VARCHAR(45),
  `caminho` VARCHAR(255),
  `titulo` VARCHAR(255),
  `detalhe` VARCHAR(2000),
  PRIMARY KEY (`idt`),
  UNIQUE INDEX `iu_plu_email_conteudo_anexo`(`idt_plu_email_conteudo`, `nomeAnexo`, `extensao`),
  CONSTRAINT `FK_plu_email_conteudo_anexo_1` FOREIGN KEY `FK_plu_email_conteudo_anexo_1` (`idt_plu_email_conteudo`)
    REFERENCES `plu_email_conteudo` (`idt`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT
)
ENGINE = InnoDB;

-- 20-01-2017

insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('conteudo_painel_indicadores','Indicadores de Qualidade','05.01.70','S','S','janela','janela');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'conteudo_painel_indicadores') as id_funcao
from plu_direito where cod_direito in ('alt','con','exc','inc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('conteudo_painel_indicadores');

insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('conteudo_indicador_qd_det','Detalhes dos Indicadores de Qualidade','05.01.70.50','S','S','janela','janela');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'conteudo_indicador_qd_det') as id_funcao
from plu_direito where cod_direito in ('alt','con','exc','inc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('conteudo_indicador_qd_det');


insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_dw_indicadores_qualidade_2016','Detalhes dos Indicadores 1','05.01.70.50.01','S','S','listar','listar');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_dw_indicadores_qualidade_2016') as id_funcao
from plu_direito where cod_direito in ('alt','con','exc','inc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_dw_indicadores_qualidade_2016');


insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_indicador_q1','Detalhes dos Indicadores 1','05.01.70.50.10','S','S','listar','listar');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_indicador_q1') as id_funcao
from plu_direito where cod_direito in ('alt','con','exc','inc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_indicador_q1');


insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_indicador_q2','Detalhes dos Indicadores 2','05.01.70.50.12','S','S','listar','listar');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_indicador_q2') as id_funcao
from plu_direito where cod_direito in ('alt','con','exc','inc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_indicador_q2');


insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_indicador_q3','Detalhes dos Indicadores 3','05.01.70.50.13','S','S','listar','listar');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_indicador_q3') as id_funcao
from plu_direito where cod_direito in ('alt','con','exc','inc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_indicador_q3');


insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_indicador_q4','Detalhes dos Indicadores 4','05.01.70.50.14','S','S','listar','listar');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_indicador_q4') as id_funcao
from plu_direito where cod_direito in ('alt','con','exc','inc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_indicador_q4');

insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_indicador_q5','Detalhes dos Indicadores 5','05.01.70.50.15','S','S','listar','listar');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_indicador_q5') as id_funcao
from plu_direito where cod_direito in ('alt','con','exc','inc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_indicador_q5');





-- 17-02-2017 luiz

ALTER TABLE `db_pir_grc`.`grc_atendimento_agenda` ADD COLUMN `idt_grupo_horarios` INTEGER UNSIGNED AFTER `sms_1`;
ALTER TABLE `db_pir_grc`.`grc_atendimento_agenda` CHANGE COLUMN `idt_grupo_horarios` `idt_atendimento_agenda` INT(10) UNSIGNED DEFAULT NULL;
ALTER TABLE `db_pir_grc`.`grc_atendimento_agenda` ADD CONSTRAINT `FK_grc_atendimento_agenda_3` FOREIGN KEY `FK_grc_atendimento_agenda_3` (`idt_atendimento_agenda`)
    REFERENCES `grc_atendimento_agenda` (`idt`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT;
-- 21-02-2017
-- estava sem esse constraint para tema subtema - verifique se pode ter mesmo - necessito para documentação
ALTER TABLE `db_pir_grc`.`grc_produto` ADD CONSTRAINT `FK_grc_produto_18` FOREIGN KEY `FK_grc_produto_18` (`idt_tema_subtema`)
    REFERENCES `grc_tema_subtema` (`idt`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT;

-- 27/01/2017

ALTER TABLE `db_pir_gec`.`gec_organizacao_porte` ADD COLUMN `descricao_rf` VARCHAR(45) AFTER `contrapartida_sgtec`;

-- 28/01/2017

-- 30/01/2017

UPDATE `db_pir_gec`.`gec_organizacao_porte` SET `descricao_rf`='EEP' WHERE (`idt`='1');
UPDATE `db_pir_gec`.`gec_organizacao_porte` SET `descricao_rf`='MdE' WHERE (`idt`='2');
UPDATE `db_pir_gec`.`gec_organizacao_porte` SET `descricao_rf`='ME' WHERE (`idt`='3');
UPDATE `db_pir_gec`.`gec_organizacao_porte` SET `descricao_rf`='GdE' WHERE (`idt`='4');
UPDATE `db_pir_gec`.`gec_organizacao_porte` SET `descricao_rf`='MEI' WHERE (`idt`='5');

INSERT INTO `db_pir_grc`.`grc_parametros` (`codigo`, `descricao`, `ativo`, `html`, `detalhe`, `classificacao`) VALUES ('grc_indicador_obs_INQ1', 'INDICADORES DE QUALIDADE 1 - Observação ', 'S', 'S', 'INDICADORES DE QUALIDADE 1', '05.01');
INSERT INTO `db_pir_grc`.`grc_parametros` (`codigo`, `descricao`, `ativo`, `html`, `detalhe`, `classificacao`) VALUES ('grc_indicador_obs_INQ2', 'INDICADORES DE QUALIDADE 2 - Observação ', 'S', 'S', 'INDICADORES DE QUALIDADE 2', '05.02');
INSERT INTO `db_pir_grc`.`grc_parametros` (`codigo`, `descricao`, `ativo`, `html`, `detalhe`, `classificacao`) VALUES ('grc_indicador_obs_INQ3', 'INDICADORES DE QUALIDADE 3 - Observação ', 'S', 'S', 'INDICADORES DE QUALIDADE 3', '05.03');
INSERT INTO `db_pir_grc`.`grc_parametros` (`codigo`, `descricao`, `ativo`, `html`, `detalhe`, `classificacao`) VALUES ('grc_indicador_obs_INQ4', 'INDICADORES DE QUALIDADE 4 - Observação ', 'S', 'S', 'INDICADORES DE QUALIDADE 4', '05.04');
INSERT INTO `db_pir_grc`.`grc_parametros` (`codigo`, `descricao`, `ativo`, `html`, `detalhe`, `classificacao`) VALUES ('grc_indicador_obs_INQ5', 'INDICADORES DE QUALIDADE 5 - Observação ', 'S', 'S', 'INDICADORES DE QUALIDADE 5', '05.05');

/*
Produção: Executado em 06/12/2016 para implantação do chamado 1486 NF final de Ano

insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_evento_nf','Autorizar NF sem documentação','02.03.75','N','N','listar','listar');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_evento_nf') as id_funcao
from plu_direito where cod_direito in ('alt','con');

insert into plu_direito_funcao (id_direito, id_funcao, descricao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_evento_nf') as id_funcao,
'Se marcado, vai poder autorizar qualquer Evento' as descricao
from plu_direito where cod_direito in ('per');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df 
inner join plu_funcao f on df.id_funcao = f.id_funcao
inner join plu_direito d on df.id_direito = d.id_direito
where f.cod_funcao in ('grc_evento_nf');
-- and d.cod_direito in ('alt','con');
*/

ALTER TABLE `grc_evento`
ADD COLUMN `autorizar_nf_sem_doc`  char(1) NOT NULL DEFAULT 'N' AFTER `sincroniza_loja`;

-- 28/11/2016

-- Painel do grc_evento_monitoramento
INSERT INTO `db_pir_grc`.`plu_painel_funcao` (`idt_painel_grupo`, `id_funcao`, `pos_top`, `pos_left`, `imagem`, `imagem_d`, `texto_cab`, `detalhe`, `visivel`, `hint`, `parametros`, `texto_font_tam`, `texto_ativ_font_cor`, `texto_ativ_fundo`, `texto_desativ_font_cor`, `texto_desativ_fundo`, `include`, `include_arq`, `include_altura`, `include_largura`) VALUES ('1', '799', '115', '840', NULL, NULL, NULL, NULL, 'S', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'N', NULL, NULL, NULL);

/*
Produção: Executado em 06/12/2016 para implantação do chamado 1486 NF final de Ano

ALTER TABLE `grc_evento_prazo_insumo`
ADD COLUMN `idt_programa`  int(10) UNSIGNED NOT NULL DEFAULT 1 AFTER `idt_instrumento`;

ALTER TABLE `grc_evento_prazo_insumo` ADD CONSTRAINT `fk_grc_evento_prazo_insumo_2` FOREIGN KEY (`idt_programa`) REFERENCES `db_pir_gec`.`gec_programa` (`idt`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `grc_evento_prazo_insumo`
MODIFY COLUMN `idt_programa`  int(10) UNSIGNED NOT NULL AFTER `idt_instrumento`;

ALTER TABLE `grc_evento_prazo_insumo`
DROP INDEX `un_grc_evento_prazo_insumo_1` ,
ADD UNIQUE INDEX `un_grc_evento_prazo_insumo_1` (`idt_instrumento`, `idt_programa`) USING BTREE ;

update grc_evento set tipo_sincroniza_siacweb = 'VF'
where idt_instrumento in (46,47);
*/

-- 05/12/2016

ALTER TABLE `grc_evento`
DROP COLUMN `autorizar_nf_sem_doc`;

-- v18.0.0 OS001.1

-- 02/12/2016

ALTER TABLE `grc_transferencia_responsabilidade`
DROP COLUMN `codigo`,
DROP COLUMN `detalhe`,
MODIFY COLUMN `justificativa`  text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL AFTER `ativo`,
MODIFY COLUMN `idt_colaborador_origem`  int(11) NOT NULL AFTER `justificativa`,
MODIFY COLUMN `idt_colaborador_destino`  int(11) NOT NULL AFTER `idt_colaborador_origem`,
CHANGE COLUMN `data_validade` `data_validade_ini`  date NOT NULL AFTER `idt_colaborador_destino`,
ADD COLUMN `tipo`  char(1) NOT NULL AFTER `idt`,
ADD COLUMN `data_validade_fim`  date NOT NULL AFTER `data_validade_ini`,
DROP INDEX `iu_grc_transferencia_responsabilidade`;

ALTER TABLE `grc_transferencia_responsabilidade` ADD CONSTRAINT `fk_grc_transferencia_responsabilidade_1` FOREIGN KEY (`idt_colaborador_origem`) REFERENCES `plu_usuario` (`id_usuario`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `grc_transferencia_responsabilidade` ADD CONSTRAINT `fk_grc_transferencia_responsabilidade_2` FOREIGN KEY (`idt_colaborador_destino`) REFERENCES `plu_usuario` (`id_usuario`) ON DELETE RESTRICT ON UPDATE RESTRICT;

CREATE TABLE `grc_transferencia_responsabilidade_reg` (
`idt`  int(10) UNSIGNED NOT NULL AUTO_INCREMENT ,
`idt_transferencia_responsabilidade`  int(10) UNSIGNED NOT NULL ,
`tipo`  varchar(120) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '' ,
`idt_evento`  int(10) UNSIGNED NULL DEFAULT NULL ,
`idt_atendimento`  int(10) UNSIGNED NULL DEFAULT NULL ,
PRIMARY KEY (`idt`),
CONSTRAINT `fk_grc_transferencia_responsabilidade_reg_1` FOREIGN KEY (`idt_transferencia_responsabilidade`) REFERENCES `grc_transferencia_responsabilidade` (`idt`) ON DELETE RESTRICT ON UPDATE RESTRICT,
CONSTRAINT `fk_grc_transferencia_responsabilidade_reg_2` FOREIGN KEY (`idt_evento`) REFERENCES `grc_evento` (`idt`) ON DELETE RESTRICT ON UPDATE RESTRICT,
CONSTRAINT `fk_grc_transferencia_responsabilidade_reg_3` FOREIGN KEY (`idt_atendimento`) REFERENCES `grc_atendimento` (`idt`) ON DELETE RESTRICT ON UPDATE RESTRICT,
UNIQUE INDEX `un_grc_transferencia_responsabilidade_reg_1` (`idt_transferencia_responsabilidade`, `tipo`, `idt_evento`, `idt_atendimento`) 
);

-- 08/12/2016

ALTER TABLE `grc_transferencia_responsabilidade`
CHANGE COLUMN `ativo` `situacao`  char(2) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'S' AFTER `descricao`;

ALTER TABLE `grc_transferencia_responsabilidade_reg` DROP FOREIGN KEY `fk_grc_transferencia_responsabilidade_reg_2`;

ALTER TABLE `grc_transferencia_responsabilidade_reg` DROP FOREIGN KEY `fk_grc_transferencia_responsabilidade_reg_3`;

ALTER TABLE `grc_transferencia_responsabilidade_reg`
DROP COLUMN `idt_evento`,
CHANGE COLUMN `idt_atendimento` `idt_atendimento_pendencia`  int(10) UNSIGNED NOT NULL AFTER `idt_transferencia_responsabilidade`,
CHANGE COLUMN `tipo` `ativo`  char(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '' AFTER `idt_atendimento_pendencia`,
DROP INDEX `fk_grc_transferencia_responsabilidade_reg_2`,
DROP INDEX `fk_grc_transferencia_responsabilidade_reg_3`,
DROP INDEX `un_grc_transferencia_responsabilidade_reg_1` ,
ADD UNIQUE INDEX `un_grc_transferencia_responsabilidade_reg_1` (`idt_transferencia_responsabilidade`, `idt_atendimento_pendencia`) USING BTREE ;

ALTER TABLE `grc_transferencia_responsabilidade_reg` ADD CONSTRAINT `fk_grc_transferencia_responsabilidade_reg_2` FOREIGN KEY (`idt_atendimento_pendencia`) REFERENCES `grc_atendimento_pendencia` (`idt`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `grc_transferencia_responsabilidade`
MODIFY COLUMN `data_validade_ini`  date NULL AFTER `idt_colaborador_destino`,
MODIFY COLUMN `data_validade_fim`  date NULL AFTER `data_validade_ini`,
ADD COLUMN `chk_evento`  char(1) NOT NULL COMMENT 'Pendencias do Tipo: Evento' AFTER `data_validade_fim`,
ADD COLUMN `chk_pag_cred`  char(1) NOT NULL COMMENT 'Pendencias do Tipo: Pagamento a Credenciado' AFTER `chk_evento`,
ADD COLUMN `chk_atend`  char(1) NOT NULL COMMENT 'Pendencias do Tipo: Atendimento Presencial' AFTER `chk_pag_cred`;

ALTER TABLE `grc_transferencia_responsabilidade`
ADD COLUMN `evidencia`  varchar(255) NOT NULL AFTER `data_validade_fim`,
ADD COLUMN `dt_etapa_gc`  datetime NULL AFTER `chk_atend`,
ADD COLUMN `usuario_etapa_gc`  int(11) NULL AFTER `dt_etapa_gc`,
ADD COLUMN `dt_etapa_cg`  datetime NULL AFTER `usuario_etapa_gc`,
ADD COLUMN `usuario_etapa_cg`  int(11) NULL AFTER `dt_etapa_cg`,
ADD COLUMN `justificativa_reprovacao`  text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL AFTER `usuario_etapa_cg`;

ALTER TABLE `grc_transferencia_responsabilidade` ADD CONSTRAINT `fk_grc_transferencia_responsabilidade_3` FOREIGN KEY (`usuario_etapa_gc`) REFERENCES `plu_usuario` (`id_usuario`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `grc_transferencia_responsabilidade` ADD CONSTRAINT `fk_grc_transferencia_responsabilidade_4` FOREIGN KEY (`usuario_etapa_cg`) REFERENCES `plu_usuario` (`id_usuario`) ON DELETE RESTRICT ON UPDATE RESTRICT;

delete from plu_direito_funcao 
where id_funcao in (select id_funcao from plu_funcao where cod_funcao = 'grc_transferencia_responsabilidade')
and id_direito in (select id_direito from plu_direito where cod_direito in ('exc'));

ALTER TABLE `grc_transferencia_responsabilidade`
DROP COLUMN `data_validade_fim`,
CHANGE COLUMN `data_validade_ini` `dt_validade`  date NOT NULL AFTER `idt_colaborador_destino`;

-- 09/12/2016

ALTER TABLE `grc_atendimento_pendencia`
ADD COLUMN `idt_transferencia_responsabilidade`  int(10) UNSIGNED NULL AFTER `idt_evento`;

ALTER TABLE `grc_atendimento_pendencia`
DROP INDEX `FK_grc_atendimento_pendencia_11` ,
ADD INDEX `FK_grc_atendimento_pendencia_1` (`idt_atendimento`) USING BTREE ;

ALTER TABLE `grc_atendimento_pendencia` ADD CONSTRAINT `FK_grc_atendimento_pendencia_11` FOREIGN KEY (`idt_transferencia_responsabilidade`) REFERENCES `grc_transferencia_responsabilidade` (`idt`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `grc_atendimento_pendencia`
MODIFY COLUMN `idt_pfo_af_processo`  int(10) UNSIGNED NULL DEFAULT NULL AFTER `idt_evento`;

-- 12/12/2016

INSERT INTO `db_pir_grc`.`grc_parametros` (`codigo`, `descricao`, `ativo`, `html`, `detalhe`, `classificacao`) VALUES ('grc_transferencia_responsabilidade_01', 'Assunto do email da Reprovação da Transferência de Responsabilidades', 'S', 'N', '[#protocolo#] - Reprova&ccedil;&atilde;o da Transfer&ecirc;ncia de Responsabilidades no CRM | Sebrae', '04.01');
INSERT INTO `db_pir_grc`.`grc_parametros` (`codigo`, `descricao`, `ativo`, `html`, `detalhe`, `classificacao`) VALUES ('grc_transferencia_responsabilidade_02', 'Mensagem do email da Reprovação da Transferência de Responsabilidades', 'S', 'S', '<p>Caro(a) #responsavel#<br />\r\n<br />\r\nA sua solicita&ccedil;&atilde;o de Transfer&ecirc;ncia de Responsabilidades foi Reprovada.<br />\r\n<br />\r\n<strong> Justificativa da Reprova&ccedil;&atilde;o:</strong><br />\r\n#justificativa_reprovacao#<br />\r\n<br />\r\nInforma&ccedil;&otilde;es sobre a Transfer&ecirc;ncia de Responsabilidades:<br />\r\n<br />\r\n<strong> Protocolo:</strong><br />\r\n#protocolo#<br />\r\n<strong> Descri&ccedil;&atilde;o:</strong><br />\r\n#descricao#<br />\r\n<strong> Colaborador Origem:</strong><br />\r\n#colaborador_origem#<br />\r\n<strong> Colaborador Destino:</strong><br />\r\n#colaborador_destino#<br />\r\n<strong> Validade da Transfer&ecirc;ncia:</strong><br />\r\n#dt_validade#<br />\r\n<strong> Justificativa:</strong><br />\r\n#justificativa#<br />\r\n<br />\r\nPara responde-la, acesse pagina principal do sistema.<br />\r\n<br />\r\nCordialmente,<br />\r\n<br />\r\nEquipe Gestora da Plataforma Integrada de Relacionamento<br />\r\nUnidade de Atendimento Individual - DIRAT<br />\r\nUnidade de Tecnologia da Informa&ccedil;&atilde;o e Comunica&ccedil;&atilde;o - DISUP<br />\r\nSebrae - Bahia<br />\r\n<br />\r\n<strong>IMPORTANTE:</strong> Mensagem autom&aacute;tica  do sistema. N&atilde;o responda!</p>', '04.02');

INSERT INTO `db_pir_grc`.`grc_parametros` (`codigo`, `descricao`, `ativo`, `html`, `detalhe`, `classificacao`) VALUES ('grc_transferencia_responsabilidade_03', 'Assunto do email da Aprovação da Transferência de Responsabilidades', 'S', 'N', '[#protocolo#] - Aprova&ccedil;&atilde;o da Transfer&ecirc;ncia de Responsabilidades no CRM | Sebrae', '04.03');
INSERT INTO `db_pir_grc`.`grc_parametros` (`codigo`, `descricao`, `ativo`, `html`, `detalhe`, `classificacao`) VALUES ('grc_transferencia_responsabilidade_04', 'Mensagem do email da Aprovação da Transferência de Responsabilidades', 'S', 'S', '<p>Caro(a) #responsavel#<br />\r\n<br />\r\nA sua solicita&ccedil;&atilde;o de Transfer&ecirc;ncia de Responsabilidades foi Aprovada.<br />\r\n<br />\r\nInforma&ccedil;&otilde;es sobre a Transfer&ecirc;ncia de Responsabilidades:<br />\r\n<br />\r\n<strong> Protocolo:</strong><br />\r\n#protocolo#<br />\r\n<strong> Descri&ccedil;&atilde;o:</strong><br />\r\n#descricao#<br />\r\n<strong> Colaborador Origem:</strong><br />\r\n#colaborador_origem#<br />\r\n<strong> Colaborador Destino:</strong><br />\r\n#colaborador_destino#<br />\r\n<strong> Validade da Transfer&ecirc;ncia:</strong><br />\r\n#dt_validade#<br />\r\n<strong> Justificativa:</strong><br />\r\n#justificativa#<br />\r\n<br />\r\nPara responde-la, acesse pagina principal do sistema.<br />\r\n<br />\r\nCordialmente,<br />\r\n<br />\r\nEquipe Gestora da Plataforma Integrada de Relacionamento<br />\r\nUnidade de Atendimento Individual - DIRAT<br />\r\nUnidade de Tecnologia da Informa&ccedil;&atilde;o e Comunica&ccedil;&atilde;o - DISUP<br />\r\nSebrae - Bahia<br />\r\n<br />\r\n<strong>IMPORTANTE:</strong> Mensagem autom&aacute;tica  do sistema. N&atilde;o responda!</p>', '04.04');

ALTER TABLE db_pir.`sca_organizacao_secao`
ADD COLUMN `grc_transferencia_responsabilidade`  char(255) NOT NULL DEFAULT 'N' AFTER `telefone`;

UPDATE db_pir.`sca_organizacao_secao` SET `grc_transferencia_responsabilidade`='S' WHERE (`idt`='13');

ALTER TABLE `grc_transferencia_responsabilidade`
ADD COLUMN `dt_inicio`  date NOT NULL AFTER `idt_colaborador_destino`;

ALTER TABLE `grc_atendimento_pendencia`
ADD COLUMN `idt_atendimento_pendencia_trans`  int(10) UNSIGNED NULL AFTER `idt_evento_situacao_para`,
ADD COLUMN `dt_limite_trans`  date NULL AFTER `idt_atendimento_pendencia_trans`;

ALTER TABLE `grc_atendimento_pendencia` ADD CONSTRAINT `FK_grc_atendimento_pendencia_12` FOREIGN KEY (`idt_atendimento_pendencia_trans`) REFERENCES `grc_atendimento_pendencia` (`idt`) ON DELETE RESTRICT ON UPDATE RESTRICT;

-- 13/12/2016

ALTER TABLE `grc_atendimento_pendencia`
ADD INDEX `un_grc_atendimento_pendencia_1` (`dt_limite_trans`) ;

-- 14/12/2016

ALTER TABLE `grc_transferencia_responsabilidade`
MODIFY COLUMN `evidencia`  varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL AFTER `dt_validade`;

-- 19/01/2017

insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_transferencia_interinidade','Transferência por Interinidade','95.65.61','S','S','listar','listar');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_transferencia_interinidade') as id_funcao
from plu_direito where cod_direito in ('con');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df 
inner join plu_funcao f on df.id_funcao = f.id_funcao
inner join plu_direito d on df.id_direito = d.id_direito
where f.cod_funcao in ('grc_transferencia_interinidade');
-- and d.cod_direito in ('alt','con');

ALTER TABLE `plu_perfil`
ADD COLUMN `trans_resp_aprova_cgp`  char(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'N' AFTER `coloca_evento_retroaitvo`;

/*
Navicat MySQL Data Transfer

Source Server         : 2 - Homologa
Source Server Version : 50625
Source Host           : 10.6.14.40:3307
Source Database       : db_pir_grc

Target Server Type    : MYSQL
Target Server Version : 50625
File Encoding         : 65001

Date: 2017-02-22 17:15:29
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for grc_dw_indicadores_qualidade_2016
-- ----------------------------
DROP TABLE IF EXISTS `grc_dw_indicadores_qualidade_2016`;
CREATE TABLE `grc_dw_indicadores_qualidade_2016` (
  `idt` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idt_atendimento` int(10) unsigned NOT NULL,
  `horas_atendimento` decimal(15,2) DEFAULT NULL,
  `idt_ponto_atendimento` int(10) unsigned DEFAULT NULL,
  `idt_instrumento` int(10) unsigned DEFAULT NULL,
  `cpf` varchar(45) DEFAULT NULL,
  `cnpj` varchar(255) DEFAULT NULL,
  `data_base` date NOT NULL,
  `protocolo` varchar(45) DEFAULT NULL,
  `ponto_atendimento` varchar(120) DEFAULT NULL,
  `instrumento` varchar(120) DEFAULT NULL,
  `porte` varchar(120) DEFAULT NULL,
  `data_atendimento` datetime DEFAULT NULL,
  `origem` varchar(45) DEFAULT NULL,
  `razao_social` varchar(120) DEFAULT NULL,
  `nome` varchar(120) DEFAULT NULL,
  `idt_porte` int(10) unsigned DEFAULT NULL,
  `idt_tipo_empreendimento` int(10) unsigned DEFAULT NULL,
  `tipo_empreendimento` varchar(120) DEFAULT NULL,
  `evento_concluido` char(1) DEFAULT NULL,
  `evento_contrato` varchar(45) DEFAULT NULL,
  `evento` varchar(120) DEFAULT NULL,
  `idt_evento` int(10) unsigned DEFAULT NULL,
  `horas_evento` decimal(15,2) DEFAULT NULL,
  `inovacao` char(1) DEFAULT NULL,
  `idt_foco_tematico` int(10) unsigned DEFAULT NULL,
  `dt_previsao_fim` date DEFAULT NULL,
  `dt_previsao_inicial` date DEFAULT NULL,
  `tipo_pessoa` char(1) DEFAULT NULL,
  `natureza` char(2) DEFAULT NULL,
  `meta1` char(1) DEFAULT NULL,
  `meta2` char(2) DEFAULT NULL,
  `meta3` char(1) DEFAULT NULL,
  `meta4` char(1) DEFAULT NULL,
  `meta5` char(1) DEFAULT NULL,
  `meta7` char(1) DEFAULT NULL,
  `idt_segmentacao` int(10) unsigned DEFAULT NULL,
  `segmentacao` varchar(45) DEFAULT NULL,
  `instrumento_intensidade` char(2) DEFAULT NULL,
  `instrumento_sigla` char(2) DEFAULT NULL,
  `porte_meta` char(5) DEFAULT NULL,
  `status_1` char(2) DEFAULT NULL,
  `status_2` char(2) DEFAULT NULL,
  `reprovadom1` varchar(1000) DEFAULT NULL,
  `reprovadom2` varchar(1000) DEFAULT NULL,
  `reprovadom3` varchar(1000) DEFAULT NULL,
  `reprovadom4` varchar(1000) DEFAULT NULL,
  `reprovadom5` varchar(1000) DEFAULT NULL,
  `reprovadom7` varchar(1000) DEFAULT NULL,
  `ordem_cnpj` int(10) unsigned DEFAULT NULL,
  `req_intensidade` char(1) DEFAULT NULL,
  `unidade_regional` varchar(45) DEFAULT NULL,
  `pa` varchar(45) DEFAULT NULL,
  `indicador_1` decimal(15,2) DEFAULT NULL,
  `logradouro_complemento` varchar(120) DEFAULT NULL,
  `logradouro_bairro` varchar(120) DEFAULT NULL,
  `logradouro_cidade` varchar(120) DEFAULT NULL,
  `logradouro_estado` varchar(45) DEFAULT NULL,
  `logradouro_pais` varchar(120) DEFAULT NULL,
  `telefone_residencial` varchar(45) DEFAULT NULL,
  `telefone_celular` varchar(45) DEFAULT NULL,
  `telefone_recado` varchar(45) DEFAULT NULL,
  `idt_escolaridade` int(10) unsigned DEFAULT NULL,
  `escolaridade` varchar(120) DEFAULT NULL,
  `potencial_personagem` varchar(45) DEFAULT NULL,
  `necessidade_especial` varchar(45) DEFAULT NULL,
  `simples_nacional` varchar(45) DEFAULT NULL,
  `logradouro_complemento_e` varchar(120) DEFAULT NULL,
  `logradouro_bairro_e` varchar(120) DEFAULT NULL,
  `logradouro_cidade_e` varchar(120) DEFAULT NULL,
  `logradouro_estado_e` varchar(45) DEFAULT NULL,
  `logradouro_pais_e` varchar(120) DEFAULT NULL,
  `telefone_comercial_e` varchar(45) DEFAULT NULL,
  `telefone_celular_e` varchar(45) DEFAULT NULL,
  `atividade_economica_secundaria` varchar(120) DEFAULT NULL,
  `data_inf_atendimento` datetime DEFAULT NULL,
  `data_inicio_atendimento` datetime DEFAULT NULL,
  `criterio1` varchar(45) DEFAULT NULL,
  `indicador_2` decimal(15,2) DEFAULT NULL,
  `cnpj_crm` varchar(45) DEFAULT NULL,
  `cnpj_rf` varchar(45) DEFAULT NULL,
  `razao_social_crm` varchar(120) DEFAULT NULL,
  `razao_social_rf` varchar(120) DEFAULT NULL,
  `porte_crm` varchar(45) DEFAULT NULL,
  `porte_rf` varchar(45) DEFAULT NULL,
  `data_abertura_crm` varchar(45) DEFAULT NULL,
  `data_abertura_rf` varchar(45) DEFAULT NULL,
  `cnae_crm` varchar(45) DEFAULT NULL,
  `cnae_rf` varchar(45) DEFAULT NULL,
  `idt_consultor` int(10) unsigned DEFAULT NULL,
  `nome_consultor` varchar(120) DEFAULT NULL,
  `indicadorpf` decimal(15,2) DEFAULT NULL,
  `indicadorpj` decimal(15,2) DEFAULT NULL,
  `data_nascimento` date DEFAULT NULL,
  `logradouro_cep` varchar(45) DEFAULT NULL,
  `logradouro_endereco` varchar(120) DEFAULT NULL,
  `logradouro_numero` varchar(45) DEFAULT NULL,
  `logradouro_cep_e` varchar(45) DEFAULT NULL,
  `logradouro_endereco_e` varchar(120) DEFAULT NULL,
  `logradouro_numero_e` varchar(45) DEFAULT NULL,
  `data_atendimento_aberta` char(1) DEFAULT NULL,
  `email` varchar(120) DEFAULT NULL,
  `email_e` varchar(120) DEFAULT NULL,
  `data_abertura` date DEFAULT NULL,
  `indicador_3_inconsistente` char(1) DEFAULT 'N',
  `demanda` text CHARACTER SET latin1,
  `demanda_md5` char(32) DEFAULT NULL,
  `indicador_5_inconsistente` char(1) DEFAULT 'N',
  `indicador_5_hora` char(1) DEFAULT 'N',
  `indicador_5_demanda` char(1) DEFAULT 'N',
  `descricao_rf` varchar(45) DEFAULT NULL,
  `amostra_2` char(1) NOT NULL DEFAULT 'N',
  `hora_inicio_atendimento` char(5) DEFAULT NULL,
  `hora_termino_atendimento` char(5) DEFAULT NULL,
  PRIMARY KEY (`idt`),
  KEY `ix_grc_historico_meta` (`idt_atendimento`) USING BTREE,
  KEY `ix_grc_historico_meta_1` (`data_atendimento`),
  KEY `ix_grc_historico_meta_2` (`tipo_pessoa`,`porte_meta`),
  KEY `ix_grc_historico_meta_3` (`idt_ponto_atendimento`,`data_atendimento_aberta`,`horas_atendimento`),
  KEY `ix_grc_historico_meta_4` (`idt_ponto_atendimento`,`logradouro_cep`,`logradouro_endereco`,`logradouro_numero`,`logradouro_bairro`),
  KEY `ix_grc_historico_meta_5` (`idt_ponto_atendimento`,`data_nascimento`),
  KEY `ix_grc_historico_meta_6` (`idt_ponto_atendimento`,`telefone_residencial`),
  KEY `ix_grc_historico_meta_7` (`idt_ponto_atendimento`,`telefone_celular`),
  KEY `ix_grc_historico_meta_8` (`idt_ponto_atendimento`,`telefone_recado`),
  KEY `ix_grc_historico_meta_9` (`idt_ponto_atendimento`,`email`),
  KEY `ix_grc_historico_meta_10` (`idt_ponto_atendimento`,`logradouro_cep_e`,`logradouro_endereco_e`,`logradouro_numero_e`,`logradouro_bairro_e`),
  KEY `ix_grc_historico_meta_11` (`idt_ponto_atendimento`,`data_abertura`),
  KEY `ix_grc_historico_meta_12` (`idt_ponto_atendimento`,`telefone_comercial_e`),
  KEY `ix_grc_historico_meta_13` (`idt_ponto_atendimento`,`telefone_celular_e`),
  KEY `ix_grc_historico_meta_14` (`idt_ponto_atendimento`,`email_e`),
  KEY `ix_grc_historico_meta_15` (`idt_ponto_atendimento`,`demanda_md5`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=599850 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for grc_dw_iq_2016
-- ----------------------------
DROP TABLE IF EXISTS `grc_dw_iq_2016`;
CREATE TABLE `grc_dw_iq_2016` (
  `idt` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idt_ponto_atendimento` int(10) unsigned NOT NULL,
  `ponto_atendimento` varchar(120) NOT NULL,
  `indicador_1` decimal(15,2) DEFAULT NULL,
  `indicador_2` decimal(15,2) DEFAULT NULL,
  `indicador_3` decimal(15,2) DEFAULT NULL,
  `indicador_4` decimal(15,2) DEFAULT NULL,
  `indicador_5` decimal(15,2) DEFAULT NULL,
  `indicador_g` decimal(15,2) DEFAULT NULL,
  `unidade_regional` varchar(120) DEFAULT NULL,
  `quantidade_atendimentos` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`idt`),
  UNIQUE KEY `iu_grc_dw_iq_2016` (`idt_ponto_atendimento`),
  UNIQUE KEY `ix_ponto_atendimento` (`unidade_regional`,`ponto_atendimento`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=44 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for grc_dw_matriz_campos_2016
-- ----------------------------
DROP TABLE IF EXISTS `grc_dw_matriz_campos_2016`;
CREATE TABLE `grc_dw_matriz_campos_2016` (
  `idt` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idt_ponto_atendimento` int(10) unsigned NOT NULL,
  `campo` varchar(120) NOT NULL,
  `quantidade` int(10) unsigned NOT NULL,
  `valor` varchar(255) DEFAULT NULL,
  `inconsistente` char(1) DEFAULT 'N',
  PRIMARY KEY (`idt`)
) ENGINE=MyISAM AUTO_INCREMENT=662 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for grc_dw_matriz_campos_iq_3_2016
-- ----------------------------
DROP TABLE IF EXISTS `grc_dw_matriz_campos_iq_3_2016`;
CREATE TABLE `grc_dw_matriz_campos_iq_3_2016` (
  `idt_dw_matriz_campos` int(10) unsigned NOT NULL,
  `idt_dw_indicadores_qualidade` int(10) unsigned NOT NULL,
  PRIMARY KEY (`idt_dw_matriz_campos`,`idt_dw_indicadores_qualidade`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- 01/03/2017

UPDATE `db_pir_grc`.`plu_config` SET `descricao`='Comunicação CRM: e-Mail Utilizado para Remetente', `valor`='suporte.pir@servico.sebraeba.com.br', `extra`=NULL, `js`='N', `classificacao`='40.10' WHERE (`variavel`='comunicacao_email_envio');
UPDATE `db_pir_grc`.`plu_config` SET `descricao`='Comunicação CRM: Host SMTP', `valor`='smtp.office365.com', `extra`=NULL, `js`='N', `classificacao`='40.13' WHERE (`variavel`='comunicacao_host_smtp');
UPDATE `db_pir_grc`.`plu_config` SET `descricao`='Comunicação CRM: Porta do Servidor SMTP', `valor`='587', `extra`=NULL, `js`='N', `classificacao`='40.15' WHERE (`variavel`='comunicacao_port_smtp');
UPDATE `db_pir_grc`.`plu_config` SET `descricao`='Comunicação CRM: Login para autenticação no Servidor SMTP', `valor`='suporte.pir@servico.sebraeba.com.br', `extra`=NULL, `js`='N', `classificacao`='40.17' WHERE (`variavel`='comunicacao_login_smtp');
UPDATE `db_pir_grc`.`plu_config` SET `descricao`='Comunicação CRM: Senha para autenticação no Servidor SMTP', `valor`='Lupe@2016.2', `extra`=NULL, `js`='N', `classificacao`='40.19' WHERE (`variavel`='comunicacao_senha_smtp');
UPDATE `db_pir_grc`.`plu_config` SET `descricao`='Comunicação CRM: SMTP Secure (tls, ssl ou vazio)', `valor`='tls', `extra`=NULL, `js`='N', `classificacao`='40.21' WHERE (`variavel`='comunicacao_smtp_secure');
UPDATE `db_pir_grc`.`plu_config` SET `descricao`='Comunicação CRM: Nome para Envio do Email', `valor`='CRM - COMUNICAÇÃO', `extra`=NULL, `js`='N', `classificacao`='40.11' WHERE (`variavel`='comunicacao_email_nome');

INSERT INTO `db_pir_grc`.`plu_config` (`variavel`, `descricao`, `valor`, `extra`, `js`, `classificacao`) VALUES ('helpdesk_email_envio', 'HelpDesk CRM: e-Mail Utilizado para Remetente', 'suporte.pir@servico.sebraeba.com.br', NULL, 'N', '30.10');
INSERT INTO `db_pir_grc`.`plu_config` (`variavel`, `descricao`, `valor`, `extra`, `js`, `classificacao`) VALUES ('helpdesk_host_smtp', 'HelpDesk CRM: Host SMTP', 'smtp.office365.com', NULL, 'N', '30.13');
INSERT INTO `db_pir_grc`.`plu_config` (`variavel`, `descricao`, `valor`, `extra`, `js`, `classificacao`) VALUES ('helpdesk_port_smtp', 'HelpDesk CRM: Porta do Servidor SMTP', '587', NULL, 'N', '30.15');
INSERT INTO `db_pir_grc`.`plu_config` (`variavel`, `descricao`, `valor`, `extra`, `js`, `classificacao`) VALUES ('helpdesk_login_smtp', 'HelpDesk CRM: Login para autenticação no Servidor SMTP', 'suporte.pir@servico.sebraeba.com.br', NULL, 'N', '30.17');
INSERT INTO `db_pir_grc`.`plu_config` (`variavel`, `descricao`, `valor`, `extra`, `js`, `classificacao`) VALUES ('helpdesk_senha_smtp', 'HelpDesk CRM: Senha para autenticação no Servidor SMTP', 'Lupe@2016.2', NULL, 'N', '30.19');
INSERT INTO `db_pir_grc`.`plu_config` (`variavel`, `descricao`, `valor`, `extra`, `js`, `classificacao`) VALUES ('helpdesk_smtp_secure', 'HelpDesk CRM: SMTP Secure (tls, ssl ou vazio)', 'tls', NULL, 'N', '30.21');
INSERT INTO `db_pir_grc`.`plu_config` (`variavel`, `descricao`, `valor`, `extra`, `js`, `classificacao`) VALUES ('helpdesk_email_nome', 'HelpDesk CRM: Nome para Envio do Email', 'PIR - HELPDESK', NULL, 'N', '30.11');

-- producao
-- homologaco