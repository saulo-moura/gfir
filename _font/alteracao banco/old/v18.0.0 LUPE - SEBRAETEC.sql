

insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_prototipo','PROTÓTIPOS','85','S','S','listar','listar');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_prototipo') as id_funcao
from plu_direito where cod_direito in ('alt','con','exc','inc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_prototipo');



insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_evento_sebraetec','Lista Eventos SEBRAETEC','85.01','S','S','listar','listar');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_evento_sebraetec') as id_funcao
from plu_direito where cod_direito in ('alt','con','exc','inc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_evento_sebraetec');


insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_sebraetec_relatorios','SEBRAETEC - RELATÓRIOS','85.00','S','S','inc','inc');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_sebraetec_relatorios') as id_funcao
from plu_direito where cod_direito in ('alt','con','exc','inc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_sebraetec_relatorios');


insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_sebraetec_r03','Relatório 03 - Eventos(Status)','85.03','S','S','relatorio','relatorio');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_sebraetec_r03') as id_funcao
from plu_direito where cod_direito in ('alt','con','exc','inc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_sebraetec_r03');



insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_sebraetec_r04','Relatório 04 - Produtos mais Vendidos','85.04','S','S','relatorio','relatorio');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_sebraetec_r04') as id_funcao
from plu_direito where cod_direito in ('alt','con','exc','inc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_sebraetec_r04');

insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_sebraetec_r06','Relatório 06 - Valor médio do Produto','85.06','S','S','relatorio','relatorio');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_sebraetec_r06') as id_funcao
from plu_direito where cod_direito in ('alt','con','exc','inc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_sebraetec_r06');

insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_sebraetec_r07','Relatório 07 - Ciclo de Contratação do Serviço','85.07','S','S','relatorio','relatorio');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_sebraetec_r07') as id_funcao
from plu_direito where cod_direito in ('alt','con','exc','inc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_sebraetec_r07');


insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_sebraetec_r09','Relatório 09 - Taxa de Apresentação de Proposta','85.09','S','S','relatorio','relatorio');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_sebraetec_r09') as id_funcao
from plu_direito where cod_direito in ('alt','con','exc','inc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_sebraetec_r09');


insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_sebraetec_r10','Relatório 10 - Preços praticados pelas PSTs','85.10','S','S','relatorio','relatorio');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_sebraetec_r10') as id_funcao
from plu_direito where cod_direito in ('alt','con','exc','inc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_sebraetec_r10');

insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_sebraetec_r11','Relatório 11 - Execução Física/Orçamentária','85.11','S','S','relatorio','relatorio');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_sebraetec_r11') as id_funcao
from plu_direito where cod_direito in ('alt','con','exc','inc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_sebraetec_r11');

insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_sebraetec_r15','Relatório 15 - Credenciados por àrea Temática/Subárea/Peoduto','85.15','S','S','relatorio','relatorio');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_sebraetec_r15') as id_funcao
from plu_direito where cod_direito in ('alt','con','exc','inc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_sebraetec_r15');

insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_sebraetec_r16','Relatório 16 - Credenciados por àrea Temática/Subárea/Peoduto','85.16','S','S','relatorio','relatorio');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_sebraetec_r16') as id_funcao
from plu_direito where cod_direito in ('alt','con','exc','inc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_sebraetec_r16');


insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_sebraetec_r17','Relatório 17 -Serviços Prestados pelas PSTs X gestot','85.17','S','S','relatorio','relatorio');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_sebraetec_r17') as id_funcao
from plu_direito where cod_direito in ('alt','con','exc','inc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_sebraetec_r17');




insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_pa_mede','MEDE','86.00','S','S','inc','inc');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_pa_mede') as id_funcao
from plu_direito where cod_direito in ('alt','con','exc','inc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_pa_mede');

-- 14-03-2017 -  PA

CREATE TABLE `db_pir_grc`.`grc_formulario_porte` (
  `idt` INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  `codigo` VARCHAR(45) NOT NULL,
  `descricao` VARCHAR(45) NOT NULL,
  `ativo` CHAR(1) NOT NULL DEFAULT 'S',
  `detalhe` TEXT,
  `idt_porte` INTEGER UNSIGNED,
  PRIMARY KEY (`idt`),
  UNIQUE INDEX `iu_grc_formulario_porte`(`codigo`)
)
ENGINE = InnoDB;


insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_formulario_porte','Porte - MEDE','30.99.11','S','S','listar','listar');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_formulario_porte') as id_funcao
from plu_direito where cod_direito in ('alt','con','exc','inc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_formulario_porte');

ALTER TABLE `db_pir_grc`.`grc_formulario_porte` ADD COLUMN `grupo` VARCHAR(45) NOT NULL DEFAULT 'GER' AFTER `idt_porte`;

CREATE TABLE `db_pir_grc`.`grc_formulario_porte_area` (
  `idt` INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  `idt_area` INTEGER UNSIGNED NOT NULL,
  PRIMARY KEY (`idt`),
  UNIQUE INDEX `iu_grc_formulario_porte_area`(`idt`, `idt_area`),
  CONSTRAINT `FK_grc_formulario_porte_area_1` FOREIGN KEY `FK_grc_formulario_porte_area_1` (`idt`)
    REFERENCES `grc_formulario_porte` (`idt`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT,
  CONSTRAINT `FK_grc_formulario_porte_area_2` FOREIGN KEY `FK_grc_formulario_porte_area_2` (`idt_area`)
    REFERENCES `grc_formulario_area` (`idt`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT
)
ENGINE = InnoDB;


insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_formulario_porte_area','Porte X Área - MEDE','30.99.11.03','N','N','listar','listar');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_formulario_porte_area') as id_funcao
from plu_direito where cod_direito in ('alt','con','exc','inc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_formulario_porte_area');

ALTER TABLE `db_pir_grc`.`grc_formulario_porte_area` DROP PRIMARY KEY;


CREATE TABLE `db_pir_grc`.`grc_formulario_guia` (
  `idt` INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  `codigo` VARCHAR(45) NOT NULL,
  `descricao` VARCHAR(120) NOT NULL,
  `ativo` CHAR(1) NOT NULL DEFAULT 'S',
  `detalhe` TEXT,
  `idt_formulario` INTEGER UNSIGNED NOT NULL,
  `idt_porte` INTEGER UNSIGNED NOT NULL,
  `situacao` CHAR(1) NOT NULL,
  `grupo` VARCHAR(45) NOT NULL DEFAULT 'GER',
  PRIMARY KEY (`idt`),
  UNIQUE INDEX `iu_grc_formulario_guia`(`codigo`)
)
ENGINE = InnoDB;


insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_formulario_guia','Guia par Aplicar Diagnóstico','30.99.12','S','S','listar','listar');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_formulario_guia') as id_funcao
from plu_direito where cod_direito in ('alt','con','exc','inc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_formulario_guia');

ALTER TABLE `db_pir_grc`.`grc_formulario_guia` MODIFY COLUMN `idt_porte` INT(10) UNSIGNED DEFAULT NULL;

ALTER TABLE `db_pir_grc`.`grc_avaliacao` ADD COLUMN `idt_guia` INTEGER UNSIGNED AFTER `idt_pfo_af_processo`,
 ADD CONSTRAINT `FK_grc_avaliacao_10` FOREIGN KEY `FK_grc_avaliacao_10` (`idt_guia`)
    REFERENCES `grc_formulario_guia` (`idt`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT;
ALTER TABLE `db_pir_grc`.`grc_formulario_classe_pergunta` MODIFY COLUMN `ativo` VARCHAR(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'S',
 ADD COLUMN `grupo` VARCHAR(45) DEFAULT 'GER' AFTER `detalhe`;
ALTER TABLE `db_pir_grc`.`grc_formulario_classe_resposta` MODIFY COLUMN `ativo` VARCHAR(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'S',
 ADD COLUMN `grupo` VARCHAR(45) DEFAULT 'GER' AFTER `detalhe`;
ALTER TABLE `db_pir_grc`.`grc_formulario_classe_pergunta` DROP INDEX `iu_grc_formulario_classe_pergunta`,
 ADD UNIQUE INDEX `iu_grc_formulario_classe_pergunta` USING BTREE(`grupo`, `codigo`);
ALTER TABLE `db_pir_grc`.`grc_formulario_classe_resposta` DROP INDEX `iu_grc_formulario_grc_formulario_classe_resposta`,
 ADD UNIQUE INDEX `iu_grc_formulario_grc_formulario_classe_resposta` USING BTREE(`grupo`, `codigo`);


CREATE TABLE `db_pir_grc`.`grc_atendimento_administrar_email` (
  `idt` INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  `codigo` VARCHAR(45) NOT NULL,
  `descricao` VARCHAR(120) NOT NULL,
  `ativo` CHAR(1) NOT NULL DEFAULT 'S',
  `detalhe` TEXT,
  `data_registro` DATETIME NOT NULL,
  `idt_responsavel` INTEGER NOT NULL,
  PRIMARY KEY (`idt`),
  INDEX `iu_grc_atendimento_administrar_email`(`data_registro`, `idt_responsavel`),
  CONSTRAINT `FK_grc_atendimento_administrar_email_1` FOREIGN KEY `FK_grc_atendimento_administrar_email_1` (`idt_responsavel`)
    REFERENCES `plu_usuario` (`id_usuario`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT
)
ENGINE = InnoDB;


insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_atendimento_administrar_email','Administrar Email e SMS','20.50','S','S','listar','listar');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_atendimento_administrar_email') as id_funcao
from plu_direito where cod_direito in ('alt','con','exc','inc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_atendimento_administrar_email');

ALTER TABLE `db_pir_grc`.`grc_comunicacao_anexo`
 DROP FOREIGN KEY `FK_grc_comunicacao_anexo_1`;

ALTER TABLE `db_pir_grc`.`grc_comunicacao_anexo`
 DROP FOREIGN KEY `FK_grc_comunicacao_anexo_2`;

ALTER TABLE `db_pir_grc`.`grc_comunicacao_anexo` ADD CONSTRAINT `FK_grc_comunicacao_anexo_1` FOREIGN KEY `FK_grc_comunicacao_anexo_1` (`idt_comunicacao`)
    REFERENCES `grc_comunicacao` (`idt`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT,
 ADD CONSTRAINT `FK_grc_comunicacao_anexo_2` FOREIGN KEY `FK_grc_comunicacao_anexo_2` (`idt_responsavel`)
    REFERENCES `plu_usuario` (`id_usuario`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT;



insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_atendimento_agenda_log','Agenda - LOG','20.55','S','S','listar','listar');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_atendimento_agenda_log') as id_funcao
from plu_direito where cod_direito in ('alt','con','exc','inc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_atendimento_agenda_log');

CREATE TABLE `db_pir_grc`.`grc_atendimento_agenda_email_tag` (
  `idt` INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  `codigo` VARCHAR(45) NOT NULL,
  `descricao` VARCHAR(120) NOT NULL,
  `ativo` CHAR(1) NOT NULL DEFAULT 'S',
  `detalhe` TEXT NOT NULL,
  `tabela` VARCHAR(120) NOT NULL,
  `campo` VARCHAR(120) NOT NULL,
  PRIMARY KEY (`idt`),
  UNIQUE INDEX `iu_grc_atendimento_agenda_email_tag`(`codigo`)
)
ENGINE = InnoDB;


insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_atendimento_agenda_email_tag','Agenda - TAG para Email','20.57','S','S','listar','listar');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_atendimento_agenda_email_tag') as id_funcao
from plu_direito where cod_direito in ('alt','con','exc','inc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_atendimento_agenda_email_tag');

ALTER TABLE `db_pir_grc`.`grc_atendimento_agenda_email_tag` CHANGE COLUMN `tabela` `tabela_p` VARCHAR(120) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
 CHANGE COLUMN `campo` `campo_p` VARCHAR(120) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;

ALTER TABLE `db_pir_grc`.`grc_atendimento_agenda_email_tag` MODIFY COLUMN `detalhe` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
 MODIFY COLUMN `tabela_p` VARCHAR(120) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
 MODIFY COLUMN `campo_p` VARCHAR(120) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL;
ALTER TABLE `db_pir_grc`.`grc_atendimento_agenda_email_tag` ADD COLUMN `ordem` VARCHAR(45) AFTER `campo_p`
, AUTO_INCREMENT = 1;
ALTER TABLE `db_pir_grc`.`grc_comunicacao` ADD COLUMN  `sms_t` VARCHAR(120) AFTER `sms`;
ALTER TABLE `db_pir_grc`.`grc_comunicacao` MODIFY COLUMN `sms` NUMERIC DEFAULT NULL;
ALTER TABLE `db_pir_grc`.`grc_comunicacao` MODIFY COLUMN `sms` DECIMAL(15,0) DEFAULT NULL;
ALTER TABLE `db_pir_grc`.`grc_comunicacao` ADD COLUMN  `sms_e` VARCHAR(120) AFTER `sms_t`,
 ADD COLUMN `sms_enum` DECIMAL(15,0) AFTER `sms_e`
, AUTO_INCREMENT = 56;


ALTER TABLE `db_pir_grc`.`plu_erro_msg` ADD COLUMN `gravidade` VARCHAR(45) AFTER `msg_usuario`;
ALTER TABLE `db_pir_grc`.`plu_erro_msg` ADD COLUMN `detalhe` LONGTEXT AFTER `gravidade`;


-- 20032017

ALTER TABLE `db_pir_grc`.`grc_comunicacao` ADD COLUMN `pendente_envio` CHAR(1) DEFAULT 'N' AFTER `sms_enum`,
 ADD COLUMN `data_envio` DATETIME AFTER `pendente_envio`,
 ADD COLUMN `observacao_envio` TEXT AFTER `data_envio`;
 
 ALTER TABLE `db_pir_grc`.`grc_comunicacao` ADD COLUMN `prazo` INTEGER UNSIGNED AFTER `observacao_envio`,
 ADD COLUMN `quando` VARCHAR(45) AFTER `prazo`,
 ADD COLUMN `data_enviar` DATETIME AFTER `quando`;

ALTER TABLE `db_pir_grc`.`grc_agenda_emailsms` MODIFY COLUMN `descricao` VARCHAR(500) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;


ALTER TABLE `db_pir_grc`.`grc_agenda_emailsms_processo` ADD COLUMN `aplicacao` VARCHAR(120) NOT NULL DEFAULT 'Agenda' AFTER `quando`;

ALTER TABLE `db_pir_grc`.`grc_comunicacao` DROP INDEX `iu_protocolo`,
 ADD UNIQUE INDEX `iu_protocolo` USING BTREE(`processo`, `protocolo`);


ALTER TABLE `db_pir_grc`.`grc_comunicacao` ADD COLUMN `protocolo_agenda` VARCHAR(45) AFTER `data_enviar`,
 DROP INDEX `iu_protocolo`,
 ADD UNIQUE INDEX `iu_protocolo` USING BTREE(`protocolo`),
 ADD UNIQUE INDEX `iu_peocesso_protocolo_agenda`(`protocolo_agenda`, `processo`);
ALTER TABLE `db_pir_grc`.`grc_atendimento_agenda_email_tag` ADD COLUMN `disponivel` CHAR(1) NOT NULL DEFAULT 'N' AFTER `ordem`;


ALTER TABLE `db_pir_grc`.`grc_atendimento_agenda_email_tag` DROP INDEX `iu_grc_atendimento_agenda_email_tag`,
 ADD UNIQUE INDEX `iu_grc_atendimento_agenda_email_tag` USING BTREE(`campo_p`, `codigo`);

ALTER TABLE `db_pir_grc`.`grc_atendimento_agenda_log` ADD COLUMN `idt_especialidade` INTEGER UNSIGNED AFTER `observacao_desmarcacao`;
ALTER TABLE `db_pir_grc`.`grc_atendimento_agenda_log` ADD COLUMN `idt_consultor` INTEGER UNSIGNED AFTER `idt_especialidade`;

ALTER TABLE `db_pir_grc`.`grc_atendimento_agenda_log` MODIFY COLUMN `idt` INT(10) UNSIGNED NOT NULL,
 MODIFY COLUMN `idt_consultor` INT(10) UNSIGNED NOT NULL,
 ADD COLUMN `neutro` CHAR(1) DEFAULT 'N' AFTER `idt_consultor`;
ALTER TABLE `db_pir_grc`.`grc_atendimento_agenda_log` MODIFY COLUMN `idt` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT;

CREATE TABLE `db_pir_grc`.`grc_atendimento_tipo_deficiencia` (
  `idt` INTEGER UNSIGNED NOT NULL,
  `idt_tipo_deficiencia` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`idt`),
  UNIQUE INDEX `iu_grc_atendimento_tipo_deficiencia`(`idt`, `idt_tipo_deficiencia`),
  CONSTRAINT `FK_grc_atendimento_tipo_deficiencia_1` FOREIGN KEY `FK_grc_atendimento_tipo_deficiencia_1` (`idt`)
    REFERENCES `grc_atendimento_agenda` (`idt`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT
)
ENGINE = InnoDB;

ALTER TABLE `db_pir_grc`.`grc_atendimento_tipo_deficiencia` RENAME TO `db_pir_grc`.`grc_atendimento_agenda_tipo_deficiencia`
, DROP INDEX `iu_grc_atendimento_tipo_deficiencia`,
 ADD UNIQUE INDEX `iu_grc_atendimento_agenda_tipo_deficiencia` USING BTREE(`idt`, `idt_tipo_deficiencia`),
 DROP FOREIGN KEY `FK_grc_atendimento_tipo_deficiencia_1`,
 ADD CONSTRAINT `FK_grc_atendimento_agenda_tipo_deficiencia_1` FOREIGN KEY `FK_grc_atendimento_agenda_tipo_deficiencia_1` (`idt`)
    REFERENCES `grc_atendimento_agenda` (`idt`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT;

insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_atendimento_agenda_tipo_deficiencia','Agenda - Deficiência','05.57.02','S','S','listar','listar');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_atendimento_agenda_tipo_deficiencia') as id_funcao
from plu_direito where cod_direito in ('alt','con','exc','inc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_atendimento_agenda_tipo_deficiencia');
ALTER TABLE `db_pir_grc`.`grc_atendimento_agenda_tipo_deficiencia` DROP PRIMARY KEY,
 ADD PRIMARY KEY  USING BTREE(`idt`, `idt_tipo_deficiencia`);
ALTER TABLE `db_pir_grc`.`grc_atendimento_agenda_log` ADD COLUMN `observacao` TEXT AFTER `neutro`;

-- Job de Agendamento

insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_atendimento_agenda_job','Job de Agendamento','95.64','S','S','link','link');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_atendimento_agenda_job') as id_funcao
from plu_direito where cod_direito in ('alt','con','exc','inc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_atendimento_agenda_job');

-- divulgação do pir

insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('pir_divulgacao','Divulgação do PIR','87','S','S','inc','inc');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'pir_divulgacao') as id_funcao
from plu_direito where cod_direito in ('alt','con','exc','inc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('pir_divulgacao');

insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('plu_pl_glossario','Glossário','87.03','S','S','listar','listar');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'plu_pl_glossario') as id_funcao
from plu_direito where cod_direito in ('alt','con','exc','inc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('plu_pl_glossario');

insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('plu_pl_glossario_natureza','Glossário - Natureza','87.50','S','S','listar','listar');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'plu_pl_glossario_natureza') as id_funcao
from plu_direito where cod_direito in ('alt','con','exc','inc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('plu_pl_glossario_natureza');

insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('plu_boletim_informativo','Boletim Informativo','87.07','S','S','listar','listar');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'plu_boletim_informativo') as id_funcao
from plu_direito where cod_direito in ('alt','con','exc','inc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('plu_boletim_informativo');


ALTER TABLE `db_pir_grc`.`grc_atendimento_agenda_servico` ADD CONSTRAINT `FK_grc_atendimento_agenda_servico_3` FOREIGN KEY `FK_grc_atendimento_agenda_servico_3` (`idt_servico`)
    REFERENCES `grc_atendimento_especialidade` (`idt`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT;

ALTER TABLE `db_pir_grc`.`grc_atendimento_agenda` ADD INDEX `ix_data`(`data`, `hora`, `idt_ponto_atendimento`);

ALTER TABLE `db_pir_grc`.`grc_atendimento_agenda` DROP INDEX `ix_data`,
 ADD INDEX `ix_data_origem` USING BTREE(`data`, `origem`);
 
-- 29-03-2017

ALTER TABLE `db_pir_grc`.`grc_atendimento_anexo` ADD COLUMN `devolutiva_distancia` CHAR(1) DEFAULT 'N' AFTER `arquivo`;



ALTER TABLE `db_pir_grc`.`grc_atendimento_pendencia` ADD COLUMN `idt_responsavel_acao` INTEGER AFTER `dt_limite_trans`,
 ADD COLUMN `data_acao` DATETIME AFTER `idt_responsavel_acao`,
 ADD CONSTRAINT `FK_grc_atendimento_pendencia_13` FOREIGN KEY `FK_grc_atendimento_pendencia_13` (`idt_responsavel_acao`)
    REFERENCES `plu_usuario` (`id_usuario`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT;



insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_diagnostico_global','Diagnósticos','30.50','S','S','inc','inc');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_diagnostico_global') as id_funcao
from plu_direito where cod_direito in ('alt','con','exc','inc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_diagnostico_global');

-- fila de espera



insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_evento_participante_filaespera','Fila de Espera','02.03.47','S','S','listar','listar');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_evento_participante_filaespera') as id_funcao
from plu_direito where cod_direito in ('alt','con','exc','inc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_evento_participante_filaespera');


-- FILA ESPERA

ALTER TABLE `db_pir_grc`.`grc_atendimento` ADD COLUMN `fila` CHAR(2) DEFAULT 'MA' AFTER `idt_servico`;

-- PUBLICAR-DESPUBLICAR EVENTO

CREATE TABLE `grc_evento_publicacao` (
  `idt` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idt_evento` int(10) unsigned NOT NULL,
  `descricao` varchar(120) NOT NULL,
  `observacao` text,
  `idt_responsavel` int(11) NOT NULL,
  `data_responsavel` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `arquivo` varchar(120) NOT NULL,
  `ativo` char(1) NOT NULL DEFAULT 'N',
  PRIMARY KEY (`idt`),
  KEY `iu_grc_evento_publicacao` (`idt_evento`,`descricao`),
  KEY `FK_grc_evento_publicacao_2` (`idt_responsavel`),
  CONSTRAINT `FK_grc_evento_publicacao_1` FOREIGN KEY (`idt_evento`) REFERENCES `grc_evento` (`idt`) ON DELETE CASCADE,
  CONSTRAINT `FK_grc_evento_publicacao_2` FOREIGN KEY (`idt_responsavel`) REFERENCES `plu_usuario` (`id_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_evento_publicacao','Publicação de Eventos','02.03.54','S','S','listar','listar');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_evento_publicacao') as id_funcao
from plu_direito where cod_direito in ('alt','con','exc','inc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_evento_publicacao');

ALTER TABLE `db_pir_grc`.`grc_evento_publicacao` MODIFY COLUMN `ativo` CHAR(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'S';

ALTER TABLE `db_pir_grc`.`grc_evento_publicacao` ADD COLUMN `data_publicacao_de` DATE NOT NULL AFTER `ativo`,
 ADD COLUMN `data_publicacao_ate` DATE NOT NULL AFTER `data_publicacao_de`;

ALTER TABLE `db_pir_grc`.`grc_evento_publicacao` MODIFY COLUMN `arquivo` VARCHAR(120) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL;

ALTER TABLE `db_pir_grc`.`grc_evento_publicacao` ADD COLUMN `tipo_acao` VARCHAR(45) AFTER `data_publicacao_ate`;


-- 04-04-2017

ALTER TABLE `db_pir_grc`.`grc_formulario_guia` MODIFY COLUMN `idt_formulario` INT(10) UNSIGNED DEFAULT NULL;

ALTER TABLE `db_pir_grc`.`grc_comunicacao` ADD COLUMN `quantidade_envio` INTEGER UNSIGNED DEFAULT 1 AFTER `protocolo_agenda`;

ALTER TABLE `db_pir_grc`.`grc_comunicacao` DROP INDEX `iu_protocolo`,
 ADD UNIQUE INDEX `iu_protocolo` USING BTREE(`protocolo`, `quantidade_envio`);
ALTER TABLE `db_pir_grc`.`grc_comunicacao` DROP INDEX `iu_peocesso_protocolo_agenda`,
 ADD UNIQUE INDEX `iu_peocesso_protocolo_agenda` USING BTREE(`protocolo_agenda`, `processo`, `quantidade_envio`)
, AUTO_INCREMENT = 377;
-- Jonata

-- 08-04-2017

insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('conteudo_pa_mede','PA - MEDE','86.03','S','S','janela','janela');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'conteudo_pa_mede') as id_funcao
from plu_direito where cod_direito in ('alt','con','exc','inc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('conteudo_pa_mede');

-- treinamento
-- 19-04-2017

ALTER TABLE `db_pir_grc`.`grc_comunicacao` MODIFY COLUMN `titulo` VARCHAR(1200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;

ALTER TABLE `db_pir_grc`.`grc_agenda_emailsms` ADD CONSTRAINT `FK_grc_agenda_emailsms_1` FOREIGN KEY `FK_grc_agenda_emailsms_1` (`idt_processo`)
    REFERENCES `grc_agenda_emailsms_processo` (`idt`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT;

-- producao
-- homologacao
-- sala

insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('plu_funcao_seg','PA - MEDE','88','S','S','inc','inc');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'plu_funcao_seg') as id_funcao
from plu_direito where cod_direito in ('con');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('plu_funcao_seg');

