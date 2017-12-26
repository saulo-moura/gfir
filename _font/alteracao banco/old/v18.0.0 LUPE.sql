-- esmeraldo
-- producao


-- 28-10-2016

ALTER TABLE `db_pir_grc`.`plu_config` ADD COLUMN `classificacao` VARCHAR(45) AFTER `js`,
 ADD INDEX `ix_classificacao`(`classificacao`);
 
 
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

ALTER TABLE `db_pir_grc`.`grc_agenda_parametro` MODIFY COLUMN `prazo_sms_confirmacao` INT(10) UNSIGNED DEFAULT 1,
 MODIFY COLUMN `prazo_sms_cancelamento` INT(10) UNSIGNED DEFAULT 1,
 MODIFY COLUMN `texto_sms_confirmacao` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci,
 MODIFY COLUMN `texto_sms_cancelamento` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci,
 ADD COLUMN `envia_sms_vespera` CHAR(1) AFTER `tolerancia_atraso`,
 ADD COLUMN `envia_sms_agradecimento` CHAR(1) AFTER `envia_sms_vespera`,
 ADD COLUMN `envia_sms_cancelamento_sebrae` CHAR(1) AFTER `envia_sms_agradecimento`,
 ADD COLUMN `prazo_sms_vespera` INTEGER UNSIGNED AFTER `envia_sms_cancelamento_sebrae`,
 ADD COLUMN `prazo_sms_agradecimento` INTEGER UNSIGNED AFTER `prazo_sms_vespera`,
 ADD COLUMN `prazo_sms_cancelamento_sebrae` INTEGER UNSIGNED AFTER `prazo_sms_agradecimento`,
 ADD COLUMN `texto_sms_vespera` VARCHAR(255) AFTER `prazo_sms_cancelamento_sebrae`,
 ADD COLUMN `texto_sms_agradecimento` VARCHAR(255) AFTER `texto_sms_vespera`,
 ADD COLUMN `texto_sms_cancelamento_sebrae` VARCHAR(255) AFTER `texto_sms_agradecimento`;



ALTER TABLE `db_pir_grc`.`grc_agenda_parametro` CHANGE COLUMN `emvia_sms_cancelamento` `envia_sms_cancelamento` CHAR(1) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'N';


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
  PRIMARY KEY (`idt`),
  KEY `ix_grc_historico_meta` (`idt_atendimento`) USING BTREE,
  KEY `ix_grc_historico_meta_1` (`data_atendimento`),
  KEY `ix_grc_historico_meta_2` (`tipo_pessoa`,`porte_meta`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE `db_pir_grc`.`grc_dw_iq_2016` (
  `idt` INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  `idt_ponto_atendimento` INTEGER UNSIGNED NOT NULL,
  `ponto_atendimento` VARCHAR(120) NOT NULL,
  `indicador_1` NUMERIC(15,2),
  `indicador_2` NUMERIC(15,2),
  `indicador_3` NUMERIC(15,2),
  `indicador_4` NUMERIC(15,2),
  `indicador_5` NUMERIC(15,2),
  `indicador_g` NUMERIC(15,2),
  PRIMARY KEY (`idt`),
  UNIQUE INDEX `iu_grc_dw_iq_2016`(`idt_ponto_atendimento`),
  UNIQUE INDEX `ix_ponto_atendimento`(`ponto_atendimento`)
)
ENGINE = InnoDB;


ALTER TABLE `db_pir_grc`.`grc_dw_iq_2016` ADD COLUMN `unidade_regional` VARCHAR(120) AFTER `indicador_g`,
 DROP INDEX `ix_ponto_atendimento`,
 ADD UNIQUE INDEX `ix_ponto_atendimento` USING BTREE(`unidade_regional`, `ponto_atendimento`);


ALTER TABLE `db_pir_grc`.`grc_dw_indicadores_qualidade_2016` ADD COLUMN `indicador_1` NUMERIC(15,2) AFTER `pa`;
ALTER TABLE `db_pir_grc`.`grc_dw_iq_2016` ADD COLUMN `quantidade_atendimentos` INTEGER UNSIGNED AFTER `unidade_regional`;

-- noite

ALTER TABLE `db_pir_grc`.`grc_dw_indicadores_qualidade_2016` ADD COLUMN `logradouro_complemento` VARCHAR(120) AFTER `indicador_1`,
 ADD COLUMN `telefone_residencial` VARCHAR(45) AFTER `logradouro_complemento`,
 ADD COLUMN `telefone_celular` VARCHAR(45) AFTER `telefone_residencial`,
 ADD COLUMN `telefone_recado` VARCHAR(45) AFTER `telefone_celular`,
 ADD COLUMN `idt_escolaridade` INTEGER UNSIGNED AFTER `telefone_recado`,
 ADD COLUMN `escolaridade` VARCHAR(120) AFTER `idt_escolaridade`,
 ADD COLUMN `potencial_personagem` VARCHAR(45) AFTER `escolaridade`,
 ADD COLUMN `necessidade_especial` VARCHAR(45) AFTER `potencial_personagem`,
 ADD COLUMN `simples_nacional` VARCHAR(45) AFTER `necessidade_especial`,
 ADD COLUMN `logradouro_complemento_e` VARCHAR(120) AFTER `simples_nacional`,
 ADD COLUMN `telefone_comercial_e` VARCHAR(45) AFTER `logradouro_complemento_e`,
 ADD COLUMN `telefone_celular_e` VARCHAR(45) AFTER `telefone_comercial_e`,
 ADD COLUMN `atividade_economica_secundaria` VARCHAR(120) AFTER `telefone_celular_e`,
 ADD COLUMN `data_inf_atendimento` DATETIME AFTER `atividade_economica_secundaria`,
 ADD COLUMN `data_inicio_atendimento` DATETIME AFTER `data_inf_atendimento`,
 ADD COLUMN `criterio1` VARCHAR(45) AFTER `data_inicio_atendimento`;


ALTER TABLE `db_pir_grc`.`grc_dw_indicadores_qualidade_2016` ADD COLUMN `indicador_2` NUMERIC(15,2) AFTER `criterio1`;

-- 22-01-2019

ALTER TABLE `db_pir_grc`.`grc_dw_indicadores_qualidade_2016` ADD COLUMN `cnpj_crm` VARCHAR(45) AFTER `indicador_2`,
 ADD COLUMN `cnpj_rf` VARCHAR(45) AFTER `cnpj_crm`,
 ADD COLUMN `razao_social_crm` VARCHAR(120) AFTER `cnpj_rf`,
 ADD COLUMN `razao_social_rf` VARCHAR(120) AFTER `razao_social_crm`,
 ADD COLUMN `porte_crm` VARCHAR(45) AFTER `razao_social_rf`,
 ADD COLUMN `porte_rf` VARCHAR(45) AFTER `porte_crm`,
 ADD COLUMN `data_abertura_crm` VARCHAR(45) AFTER `porte_rf`,
 ADD COLUMN `data_abertura_rf` VARCHAR(45) AFTER `data_abertura_crm`,
 ADD COLUMN `cnae_crm` VARCHAR(45) AFTER `data_abertura_rf`,
 ADD COLUMN `cnae_rf` VARCHAR(45) AFTER `cnae_crm`;


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




ALTER TABLE `db_pir_grc`.`grc_dw_indicadores_qualidade_2016` ADD COLUMN `data_nascimento` DATE AFTER `indicadorpj`,
 ADD COLUMN `logradouro_cep` VARCHAR(45) AFTER `data_nascimento`,
 ADD COLUMN `logradouro_endereco` VARCHAR(120) AFTER `logradouro_cep`,
 ADD COLUMN `logradouro_numero` VARCHAR(45) AFTER `logradouro_endereco`,
 ADD COLUMN `logradouro_bairro` VARCHAR(120) AFTER `logradouro_complemento`,
 ADD COLUMN `logradouro_cidade` VARCHAR(120) AFTER `logradouro_bairro`,
 ADD COLUMN `logradouro_estado` VARCHAR(45) AFTER `logradouro_cidade`,
 ADD COLUMN `logradouro_pais` VARCHAR(120) AFTER `logradouro_estado`;



ALTER TABLE `db_pir_grc`.`grc_dw_indicadores_qualidade_2016` ADD COLUMN `idt_consultor` INTEGER UNSIGNED AFTER `cnae_rf`;

ALTER TABLE `db_pir_grc`.`grc_dw_indicadores_qualidade_2016` ADD COLUMN `nome_consultor` VARCHAR(120) AFTER `idt_consultor`;

ALTER TABLE `db_pir_grc`.`grc_dw_indicadores_qualidade_2016` ADD COLUMN `indicadorpf` NUMERIC(15,2) AFTER `nome_consultor`,
 ADD COLUMN `indicadorpj` NUMERIC(15,2) AFTER `indicadorpf`;
 
 -- 23-01-2017
 
 ALTER TABLE `db_pir_grc`.`grc_dw_indicadores_qualidade_2016` ADD COLUMN `logradouro_cep_e` DATE AFTER `logradouro_numero`,

 ADD COLUMN `logradouro_endereco_e` VARCHAR(120) AFTER `logradouro_cep_e`,
 ADD COLUMN `logradouro_numero_e` VARCHAR(45) AFTER `logradouro_endereco_e`,
 ADD COLUMN `logradouro_bairro_e` VARCHAR(120) AFTER `logradouro_complemento_e`,
 ADD COLUMN `logradouro_cidade_e` VARCHAR(120) AFTER `logradouro_bairro_e`,
 ADD COLUMN `logradouro_estado_e` VARCHAR(45) AFTER `logradouro_cidade_e`,
 ADD COLUMN `logradouro_pais_e` VARCHAR(120) AFTER `logradouro_estado_e`;

ALTER TABLE `db_pir_grc`.`grc_dw_indicadores_qualidade_2016` ADD COLUMN `data_atendimento_aberta` CHAR(1) AFTER `logradouro_numero_e`;

ALTER TABLE `db_pir_grc`.`grc_dw_indicadores_qualidade_2016` MODIFY COLUMN `logradouro_cep_e` VARCHAR(45) DEFAULT NULL;

CREATE TABLE `db_pir_grc`.`grc_dw_matriz_campos_2016` (
  `idt` INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  `idt_ponto_atendimento` INTEGER UNSIGNED NOT NULL,
  `campo` VARCHAR(120) NOT NULL,
  `quantidade` INTEGER UNSIGNED NOT NULL,
  PRIMARY KEY (`idt`),
  UNIQUE INDEX `iu_grc_dw_matriz_campos_2016`(`idt_ponto_atendimento`, `campo`)
)
ENGINE = InnoDB;

ALTER TABLE `db_pir_grc`.`grc_dw_matriz_campos_2016` ADD COLUMN `valor` VARCHAR(255) AFTER `quantidade`;
ALTER TABLE `db_pir_grc`.`grc_dw_matriz_campos_2016` DROP INDEX `iu_grc_dw_matriz_campos_2016`,
 ADD UNIQUE INDEX `iu_grc_dw_matriz_campos_2016` USING BTREE(`idt_ponto_atendimento`, `campo`, `valor`)
, AUTO_INCREMENT = 1;


ALTER TABLE `db_pir_grc`.`grc_dw_indicadores_qualidade_2016` ADD COLUMN `email` VARCHAR(120) AFTER `data_atendimento_aberta`,
 ADD COLUMN `email_e` VARCHAR(120) AFTER `email`;

ALTER TABLE `db_pir_grc`.`grc_dw_indicadores_qualidade_2016` ADD COLUMN `data_abertura` DATE AFTER `email_e`
, AUTO_INCREMENT = 1;

ALTER TABLE `db_pir_grc`.`grc_dw_matriz_campos_2016` ADD COLUMN `inconsistente` CHAR(1) DEFAULT 'N' AFTER `valor`;

-- sala


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
	
-- Jonata
-- homologacao