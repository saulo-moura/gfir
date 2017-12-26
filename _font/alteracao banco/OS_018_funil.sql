-- esmeraldo
-- jonata
-- producao

-- os 18 - 05-07-2017

CREATE TABLE `db_pir_grc`.`grc_funil_fase` (
  `idt` INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  `codigo` VARCHAR(45) NOT NULL,
  `descricao` VARCHAR(45) NOT NULL,
  `ativo` CHAR(1) NOT NULL DEFAULT 'S',
  `detalhe` TEXT,
  PRIMARY KEY (`idt`),
  UNIQUE INDEX `iu_grc_funil_fase`(`codigo`)
)
ENGINE = InnoDB;



insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_funil_func','Funções do Funil de Atendimento','40','S','S','listar','listar');
insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_funil_func') as id_funcao
from plu_direito where cod_direito in ('con');
insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_funil_func');

insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_funil_painel','Chama painel Funil','40.01','S','S','inc','inc');
insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_funil_painel') as id_funcao
from plu_direito where cod_direito in ('con','alt','inc','exc');
insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_funil_painel');



insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_funil_fase','Fases do Funil','40.03','S','S','listar','listar');
insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_funil_fase') as id_funcao
from plu_direito where cod_direito in ('con','alt','inc','exc');
insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_funil_fase');


ALTER TABLE `db_pir_grc`.`grc_funil_fase` ADD COLUMN `cordafase` VARCHAR(45) AFTER `detalhe`;

-- 25-07-2017

ALTER TABLE `db_pir_gec`.`gec_entidade` ADD COLUMN `funil_cliente_nota_avaliacao` INTEGER UNSIGNED AFTER `sgtec_adesao_edital_dt`,
 ADD COLUMN `funil_idt_cliente_classificacao` INTEGER UNSIGNED AFTER `funil_cliente_nota_avaliacao`;



CREATE TABLE `db_pir_grc`.`grc_funil_classificacao` (
  `idt` INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  `codigo` VARCHAR(45) NOT NULL,
  `descricao` VARCHAR(45) NOT NULL,
  `ativo` CHAR(1) NOT NULL DEFAULT 'S',
  `detalhe` TEXT,
  PRIMARY KEY (`idt`),
  UNIQUE INDEX `iu_grc_funil_classificacao`(`codigo`)
)
ENGINE = InnoDB;

insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_funil_classificacao','Classificação Cliente do Funil','40.05','S','S','listar','listar');
insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_funil_classificacao') as id_funcao
from plu_direito where cod_direito in ('con','alt','inc','exc');
insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_funil_classificacao');

ALTER TABLE `db_pir_grc`.`grc_funil_classificacao` ADD COLUMN `cordaclassificacao` VARCHAR(45) AFTER `detalhe`;

ALTER TABLE `db_pir_grc`.`grc_funil_classificacao` ADD COLUMN `nota_minima` NUMERIC(15,2) NOT NULL AFTER `cordaclassificacao`
, AUTO_INCREMENT = 1;

ALTER TABLE `db_pir_grc`.`grc_funil_fase` MODIFY COLUMN `descricao` VARCHAR(120) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
 ADD COLUMN `nome` VARCHAR(120) NOT NULL AFTER `cordafase`;

ALTER TABLE `db_pir_gec`.`gec_entidade` MODIFY COLUMN `funil_cliente_nota_avaliacao` NUMERIC(15,2) DEFAULT NULL;


ALTER TABLE `db_pir_grc`.`grc_atendimento_organizacao` ADD COLUMN `funil_cliente_nota_avaliacao` NUMERIC(15,2) AFTER `representa_codcargcli`,
 ADD COLUMN `funil_idt_cliente_classificacao` INTEGER UNSIGNED AFTER `funil_cliente_nota_avaliacao`,
 ADD CONSTRAINT `FK_grc_atendimento_organizacao_3` FOREIGN KEY `FK_grc_atendimento_organizacao_3` (`funil_idt_cliente_classificacao`)
    REFERENCES `grc_funil_classificacao` (`idt`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT;
ALTER TABLE `db_pir_grc`.`grc_entidade_organizacao` ADD COLUMN `funil_cliente_nota_avaliacao` NUMERIC(15,2) AFTER `idt_representa`,
 ADD COLUMN `funil_idt_cliente_classificacao` INTEGER UNSIGNED AFTER `funil_cliente_nota_avaliacao`,
 ADD CONSTRAINT `FK_grc_entidade_organizacao_4` FOREIGN KEY `FK_grc_entidade_organizacao_4` (`funil_idt_cliente_classificacao`)
    REFERENCES `grc_funil_classificacao` (`idt`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT;
	
--

ALTER TABLE `db_pir_grc`.`grc_entidade_organizacao`
 DROP FOREIGN KEY `FK_grc_entidade_organizacao_4`;

ALTER TABLE `db_pir_grc`.`grc_entidade_organizacao` ADD CONSTRAINT `FK_grc_entidade_organizacao_4` FOREIGN KEY `FK_grc_entidade_organizacao_4` (`funil_idt_cliente_classificacao`)
    REFERENCES `grc_funil_fase` (`idt`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT;
--

ALTER TABLE `db_pir_grc`.`grc_atendimento_organizacao`
 DROP FOREIGN KEY `FK_grc_atendimento_organizacao_3`;

ALTER TABLE `db_pir_grc`.`grc_atendimento_organizacao` ADD CONSTRAINT `FK_grc_atendimento_organizacao_3` FOREIGN KEY `FK_grc_atendimento_organizacao_3` (`funil_idt_cliente_classificacao`)
    REFERENCES `grc_funil_fase` (`idt`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT;
--
ALTER TABLE `db_pir_grc`.`grc_funil_fase` ADD COLUMN `cortextfase` VARCHAR(45) AFTER `nome`;


-- relatório


CREATE TABLE `db_pir_grc`.`grc_funil_meta` (
  `idt` INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  `codigo` VARCHAR(45) NOT NULL,
  `descricao` VARCHAR(45) NOT NULL,
  `ativo` CHAR(1) NOT NULL DEFAULT 'S',
  `detalhe` TEXT,
  PRIMARY KEY (`idt`),
  UNIQUE INDEX `iu_grc_funil_meta`(`codigo`)
)
ENGINE = InnoDB;

insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_funil_meta','Meta da Unidade Regional','40.20','S','S','listar','listar');
insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_funil_meta') as id_funcao
from plu_direito where cod_direito in ('con','alt','inc','exc');
insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_funil_meta');


CREATE TABLE `db_pir_grc`.`grc_funil_execucao` (
  `idt` INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  `codigo` VARCHAR(45) NOT NULL,
  `descricao` VARCHAR(45) NOT NULL,
  `ativo` CHAR(1) NOT NULL DEFAULT 'S',
  `detalhe` TEXT,
  PRIMARY KEY (`idt`),
  UNIQUE INDEX `iu_grc_funil_execucao`(`codigo`)
)
ENGINE = InnoDB;

insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_funil_execucao','Execução da Unidade Regional','40.23','S','S','listar','listar');
insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_funil_execucao') as id_funcao
from plu_direito where cod_direito in ('con','alt','inc','exc');
insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_funil_execucao');

--

ALTER TABLE `db_pir_grc`.`grc_funil_meta` CHANGE COLUMN `codigo` `ano` VARCHAR(45) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
 ADD COLUMN `idt_unidade_regional` INTEGER UNSIGNED NOT NULL AFTER `detalhe`,
 ADD COLUMN `qtd_prospects` INTEGER UNSIGNED AFTER `idt_unidade_regional`,
 ADD COLUMN `qtd_leads` INTEGER UNSIGNED AFTER `qtd_prospects`,
 ADD COLUMN `qtd_clientes` INTEGER UNSIGNED AFTER `qtd_leads`,
 ADD COLUMN `qtd_netpromoter_score` INTEGER UNSIGNED AFTER `qtd_clientes`,
 DROP INDEX `iu_grc_funil_meta`,
 ADD UNIQUE INDEX `iu_grc_funil_meta` USING BTREE(`idt_unidade_regional`, `ano`);


ALTER TABLE `db_pir_grc`.`grc_funil_execucao` CHANGE COLUMN `codigo` `ano` VARCHAR(45) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
 ADD COLUMN `idt_unidade_regional` INTEGER UNSIGNED NOT NULL AFTER `detalhe`,
 ADD COLUMN `qtd_prospects` INTEGER UNSIGNED AFTER `idt_unidade_regional`,
 ADD COLUMN `qtd_leads` INTEGER UNSIGNED AFTER `qtd_prospects`,
 ADD COLUMN `qtd_sem_avaliacao` INTEGER UNSIGNED AFTER `qtd_leads`,
 ADD COLUMN `qtd_detrators` INTEGER UNSIGNED AFTER `qtd_sem_avaliacao`,
 ADD COLUMN `qtd_neutros` INTEGER UNSIGNED AFTER `qtd_detrators`,
 ADD COLUMN `qtd_promotores` INTEGER UNSIGNED AFTER `qtd_neutros`,
 ADD COLUMN `qtd_net_promoter_score` NUMERIC(15,2) AFTER `qtd_promotores`,
 DROP INDEX `iu_grc_funil_execucao`,
 ADD UNIQUE INDEX `iu_grc_funil_execucao` USING BTREE(`idt_unidade_regional`, `ano`);

ALTER TABLE `db_pir_grc`.`grc_funil_meta` MODIFY COLUMN `qtd_netpromoter_score` NUMERIC(15,2) DEFAULT NULL;

ALTER TABLE `db_pir_grc`.`grc_funil_execucao` DROP COLUMN `descricao`,
 DROP COLUMN `ativo`,
 CHANGE COLUMN `qtd_net_promoter_score` `net_promoter_score` DECIMAL(15,2) DEFAULT NULL;

ALTER TABLE `db_pir_grc`.`grc_funil_meta` CHANGE COLUMN `qtd_netpromoter_score` `net_promoter_score` DECIMAL(15,2) DEFAULT NULL;

ALTER TABLE `db_pir_grc`.`grc_funil_meta` DROP COLUMN `descricao`,
 DROP COLUMN `ativo`;
 
-- relatório de funil de atendimento

insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('conteudo_funil_relatorio.php','Funil de Atendimento Relatório','40.35','S','S','janela','janela');
insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'conteudo_funil_relatorio.php') as id_funcao
from plu_direito where cod_direito in ('con','alt','inc','exc');
insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('conteudo_funil_relatorio.php');

-- 27-07-2017

CREATE TABLE `db_pir_grc`.`grc_funil_parametro` (
  `idt` INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  `codigo` VARCHAR(45) NOT NULL,
  `descricao` VARCHAR(45) NOT NULL,
  `ativo` CHAR(1) NOT NULL DEFAULT 'S',
  `detalhe` TEXT,
  PRIMARY KEY (`idt`),
  UNIQUE INDEX `iu_grc_funil_parametro`(`codigo`)
)
ENGINE = InnoDB;

insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_funil_parametro','Parâmetros do Funil','40.29','S','S','cadastro','cadastro');
insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_funil_parametro') as id_funcao
from plu_direito where cod_direito in ('con','alt','inc','exc');
insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_funil_parametro');

ALTER TABLE `db_pir_grc`.`grc_funil_parametro` ADD COLUMN `ano_ativo` CHAR(4) NOT NULL AFTER `detalhe`;


CREATE TABLE `db_pir_grc`.`grc_funil_gestao_meta` (
  `idt` INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  `ano` VARCHAR(4) NOT NULL,
  `cnpj` VARCHAR(45) NOT NULL,
  `meta1` CHAR(1) NOT NULL DEFAULT 'N',
  `meta2` CHAR(1) NOT NULL DEFAULT 'N',
  `meta3` CHAR(1) NOT NULL DEFAULT 'N',
  `meta4` CHAR(1) NOT NULL DEFAULT 'N',
  `meta5` CHAR(1) NOT NULL DEFAULT 'N',
  `meta6` CHAR(1) NOT NULL DEFAULT 'N',
  `meta7` CHAR(1) NOT NULL DEFAULT 'N',
  `meta8` CHAR(1) NOT NULL DEFAULT 'N',
  PRIMARY KEY (`idt`),
  UNIQUE INDEX `iu_grc_funil_gestao_meta`(`ano`,`cnpj`)
)
ENGINE = InnoDB;

insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_funil_gestao_meta','Gestão de Metas do Funil','40.30','S','S','listar','listar');
insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_funil_gestao_meta') as id_funcao
from plu_direito where cod_direito in ('con','alt','inc','exc');
insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_funil_gestao_meta');

ALTER TABLE `db_pir_grc`.`grc_funil_gestao_meta` MODIFY COLUMN `meta1` CHAR(1) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT 'N',
 MODIFY COLUMN `meta2` CHAR(1) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT 'N',
 MODIFY COLUMN `meta3` CHAR(1) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT 'N',
 MODIFY COLUMN `meta4` CHAR(1) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT 'N',
 MODIFY COLUMN `meta5` CHAR(1) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT 'N',
 MODIFY COLUMN `meta6` CHAR(1) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT 'N',
 MODIFY COLUMN `meta7` CHAR(1) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT 'N',
 MODIFY COLUMN `meta8` CHAR(1) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT 'N',
 ADD COLUMN `razao_social` VARCHAR(255) AFTER `meta8`;

ALTER TABLE `db_pir_grc`.`grc_funil_gestao_meta` ADD COLUMN `flag_atu` CHAR(1) AFTER `razao_social`;

-- 28072017

insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('conteudo_funil_job.php','Executa Job de Metas','40.26','S','S','janela','janela');
insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'conteudo_funil_job.php') as id_funcao
from plu_direito where cod_direito in ('con','alt','inc','exc');
insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('conteudo_funil_job.php');


ALTER TABLE `db_pir_grc`.`grc_atendimento_organizacao` MODIFY COLUMN `funil_cliente_nota_avaliacao` DECIMAL(15,2);

ALTER TABLE `db_pir_grc`.`grc_funil_gestao_meta` DROP INDEX `iu_grc_funil_gestao_meta`,
 ADD UNIQUE INDEX `iu_grc_funil_gestao_meta` USING BTREE(`ano`, `cnpj`, `razao_social`);
ALTER TABLE `db_pir_grc`.`grc_funil_gestao_meta` MODIFY COLUMN `cnpj` VARCHAR(45) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL;


ALTER TABLE `db_pir_grc`.`grc_funil_gestao_meta` ADD COLUMN `cpf` VARCHAR(45) AFTER `flag_atu`,
 ADD COLUMN `nome_cliente` VARCHAR(255) AFTER `cpf`,
 ADD COLUMN `escritorio_de_atendimento` VARCHAR(120) AFTER `nome_cliente`;


ALTER TABLE `db_pir_grc`.`grc_funil_gestao_meta` ADD COLUMN `tipoderealizacao` VARCHAR(120) AFTER `escritorio_de_atendimento`,
 ADD INDEX `ix_empresa`(`razao_social`),
 ADD INDEX `Ix_tiporealizacao`(`tipoderealizacao`);


ALTER TABLE `db_pir_grc`.`grc_funil_gestao_meta` CHANGE COLUMN `tipoderealizacao` `tiporealizacao` VARCHAR(120) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
 DROP INDEX `Ix_tiporealizacao`,
 ADD INDEX `Ix_tiporealizacao` USING BTREE(`tiporealizacao`);

ALTER TABLE `db_pir_grc`.`grc_funil_gestao_meta` ADD COLUMN `instrumento` VARCHAR(120) AFTER `tiporealizacao`;


ALTER TABLE `db_pir_grc`.`grc_funil_gestao_meta` RENAME TO `db_pir_grc`.`grc_funil_gestao_meta_2017`
, DROP INDEX `iu_grc_funil_gestao_meta`
, DROP INDEX `ix_empresa`
, DROP INDEX `Ix_tiporealizacao`,
 ADD UNIQUE INDEX `iu_grc_funil_gestao_meta_2017` USING BTREE(`ano`, `cnpj`, `razao_social`),
 ADD INDEX `ix_empresa_2017` USING BTREE(`razao_social`),
 ADD INDEX `Ix_tiporealizacao_2017` USING BTREE(`tiporealizacao`);

ALTER TABLE `db_pir_grc`.`grc_funil_gestao_meta_2017` DROP INDEX `iu_grc_funil_gestao_meta_2017`,
 ADD INDEX `iu_grc_funil_gestao_meta_2017` USING BTREE(`ano`, `cnpj`, `razao_social`);

ALTER TABLE `db_pir_grc`.`grc_funil_gestao_meta_2017` ADD COLUMN `tipo_pessoa` VARCHAR(120) AFTER `instrumento`,
 ADD COLUMN `datahorainicial` VARCHAR(120) AFTER `tipo_pessoa`,
 ADD COLUMN `datahorafinal` VARCHAR(120) AFTER `datahorainicial`;


ALTER TABLE `db_pir_grc`.`grc_funil_gestao_meta_2017` ADD COLUMN `tipo_de_empreendimento` VARCHAR(120) AFTER `datahorafinal`,
 ADD COLUMN `porte` VARCHAR(120) AFTER `tipo_de_empreendimento`,
 ADD COLUMN `setor` VARCHAR(120) AFTER `porte`,
 ADD COLUMN `atividade_economica` VARCHAR(120) AFTER `setor`;


ALTER TABLE `db_pir_grc`.`grc_funil_gestao_meta_2017` RENAME TO `db_pir_grc`.`grc_funil_2017_gestao_meta`;

ALTER TABLE `db_pir_grc`.`grc_funil_2017_gestao_meta` MODIFY COLUMN `atividade_economica` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL;
ALTER TABLE `db_pir_grc`.`grc_funil_2017_gestao_meta` ADD INDEX `ix_grc_funil_2017_gestao_meta`(`razao_social`);

ALTER TABLE `db_pir_grc`.`grc_funil_2017_gestao_meta` DROP INDEX `ix_grc_funil_2017_gestao_meta`,
 ADD INDEX `ix_grc_funil_2017_gestao_meta` USING BTREE(`nome_cliente`);

ALTER TABLE `grc_funil_2017_gestao_meta`
ADD COLUMN `codrealizacao`  varchar(120) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL AFTER `atividade_economica`;

ALTER TABLE `db_pir_grc`.`grc_funil_2017_gestao_meta` ADD COLUMN `meta_afetada` VARCHAR(255) AFTER `codrealizacao`;

ALTER TABLE `db_pir_grc`.`grc_funil_2017_gestao_meta` ADD COLUMN `meta9` CHAR(1) NOT NULL DEFAULT 'N' AFTER `meta_afetada`;

-- tirar tb o ano - não copiei a mofificação 

ALTER TABLE `db_pir_grc`.`grc_funil_2017_gestao_meta` DROP INDEX `iu_grc_funil_gestao_meta_2017`,
 ADD INDEX `iu_grc_funil_gestao_meta_2017` USING BTREE(`cnpj`);


-- chamado 1562

CREATE TABLE `db_pir_grc`.`grc_atendimento_resumo` (
  `idt` INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  `idt_atendimento` INTEGER UNSIGNED NOT NULL,
  `numero` VARCHAR(45) NOT NULL,
  `idt_acao` INTEGER UNSIGNED NOT NULL,
  `descricao` VARCHAR(5000) NOT NULL,
  `datahora` DATETIME NOT NULL,
  PRIMARY KEY (`idt`),
  UNIQUE INDEX `iu_grc_atendimento_resumo`(`idt_atendimento`, `numero`),
  CONSTRAINT `FK_grc_atendimento_resumo_1` FOREIGN KEY `FK_grc_atendimento_resumo_1` (`idt_atendimento`)
    REFERENCES `grc_atendimento` (`idt`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT
)
ENGINE = InnoDB;

CREATE TABLE `db_pir_grc`.`grc_atendimento_resumo_acao` (
  `idt` INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  `codigo` VARCHAR(45) NOT NULL,
  `descricao` VARCHAR(120) NOT NULL,
  `ativo` CHAR(1) NOT NULL DEFAULT 'S',
  `detalhe` TEXT,
  PRIMARY KEY (`idt`),
  UNIQUE INDEX `iu_grc_atendimento_resumo_acao`(`codigo`)
)
ENGINE = InnoDB;

ALTER TABLE `db_pir_grc`.`grc_atendimento_resumo` ADD CONSTRAINT `FK_grc_atendimento_resumo_2` FOREIGN KEY `FK_grc_atendimento_resumo_2` (`idt_acao`)
    REFERENCES `grc_atendimento_resumo_acao` (`idt`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT;
	
insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_atendimento_resumo','Resumo do Atendimento','05.01.05','N','N','listar','listar');
insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_atendimento_resumo') as id_funcao
from plu_direito where cod_direito in ('con','alt','inc','exc');
insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_atendimento_resumo');


insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_atendimento_resumo_acao','Ação do Resumo do Atendimento','05.90.57','S','S','listar','listar');
insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_atendimento_resumo_acao') as id_funcao
from plu_direito where cod_direito in ('con','alt','inc','exc');
insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_atendimento_resumo_acao');

-- rede de pendencias

CREATE TABLE `db_pir_grc`.`grc_atendimento_pendencia_destinatario` (
  `idt` INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  `idt_pendencia` INTEGER UNSIGNED NOT NULL,
  `idt_destinatario` INTEGER NOT NULL,
  `observacao` VARCHAR(5000) NOT NULL,
  PRIMARY KEY (`idt`),
  UNIQUE INDEX `iu_grc_atendimento_pendencia_destinatario`(`idt_pendencia`, `idt_destinatario`),
  CONSTRAINT `FK_grc_atendimento_pendencia_destinatario_1` FOREIGN KEY `FK_grc_atendimento_pendencia_destinatario_1` (`idt_pendencia`)
    REFERENCES `grc_atendimento_pendencia` (`idt`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT,
  CONSTRAINT `FK_grc_atendimento_pendencia_destinatario_2` FOREIGN KEY `FK_grc_atendimento_pendencia_destinatario_2` (`idt_destinatario`)
    REFERENCES `plu_usuario` (`id_usuario`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT
)
ENGINE = InnoDB;


insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_atendimento_pendencia_destinatario','Destinatarios da pendência do Atendimento','90.80.05.14','S','S','listar','listar');
insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_atendimento_pendencia_destinatario') as id_funcao
from plu_direito where cod_direito in ('con','alt','inc','exc');
insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_atendimento_pendencia_destinatario');


ALTER TABLE `db_pir_grc`.`grc_atendimento_pendencia_destinatario` MODIFY COLUMN `observacao` VARCHAR(5000) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL;


ALTER TABLE `db_pir_grc`.`grc_atendimento_pendencia_destinatario` ADD COLUMN `idt_pendencia_destinatario` INTEGER UNSIGNED AFTER `observacao`,
 ADD CONSTRAINT `FK_grc_atendimento_pendencia_destinatario_3` FOREIGN KEY `FK_grc_atendimento_pendencia_destinatario_3` (`idt_pendencia_destinatario`)
    REFERENCES `grc_atendimento_pendencia` (`idt`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT
, AUTO_INCREMENT = 2;

ALTER TABLE `grc_atendimento_pendencia`
ADD COLUMN `idt_pendencia_pai`  int(10) UNSIGNED NULL DEFAULT NULL AFTER `situacao_para`;

ALTER TABLE `grc_atendimento_pendencia` ADD CONSTRAINT `FK_grc_atendimento_pendencia_20` FOREIGN KEY (`idt_pendencia_pai`) REFERENCES `grc_atendimento_pendencia` (`idt`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `db_pir_grc`.`grc_atendimento_pendencia` ADD COLUMN `idt_status` INTEGER UNSIGNED AFTER `idt_pendencia_pai`,
 ADD COLUMN `prazo_resposta_final` INTEGER UNSIGNED AFTER `idt_status`,
 ADD COLUMN `email_cliente` VARCHAR(255) AFTER `prazo_resposta_final`,
 ADD COLUMN `prazo_resposta_encaminhamento` INTEGER UNSIGNED AFTER `email_cliente`,
 ADD COLUMN `data_fechamento` DATETIME AFTER `prazo_resposta_encaminhamento`
, AUTO_INCREMENT = 1456;

ALTER TABLE `db_pir_grc`.`grc_atendimento_pendencia` MODIFY COLUMN `prazo_resposta_final` DATETIME DEFAULT NULL,
 MODIFY COLUMN `prazo_resposta_encaminhamento` DATETIME DEFAULT NULL;


ALTER TABLE `grc_atendimento_pendencia`
ADD COLUMN `opcao_tramitacao`  char(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'E' AFTER `data_fechamento`;

ALTER TABLE `db_pir_grc`.`grc_atendimento_pendencia` CHANGE COLUMN `prazo_resposta_final` `data_resposta_final` DATETIME DEFAULT NULL,
 CHANGE COLUMN `prazo_resposta_encaminhamento` `data_resposta_encaminhamento` DATETIME DEFAULT NULL;

ALTER TABLE `db_pir_grc`.`grc_atendimento_pendencia` ADD COLUMN `consideracoes_encaminhamento` VARCHAR(5000) AFTER `opcao_tramitacao`;

ALTER TABLE `db_pir_grc`.`grc_atendimento_pendencia_destinatario` ADD COLUMN `email` VARCHAR(120) AFTER `idt_pendencia_destinatario`,
 ADD COLUMN `enviar_email_destinatario` CHAR(1) NOT NULL DEFAULT 'S' AFTER `email`;


-- Falta fazer o constraint que é entre bancos
ALTER TABLE `db_pir_grc`.`grc_atendimento_pendencia_destinatario` ADD COLUMN `idt_unidade` INTEGER UNSIGNED AFTER `enviar_email_destinatario`,
 ADD COLUMN `idt_ponto_atendimento` INTEGER UNSIGNED AFTER `idt_unidade`;


ALTER TABLE `db_pir_grc`.`grc_atendimento_pendencia` ADD COLUMN `data_solucao_atendimento` DATETIME AFTER `consideracoes_encaminhamento`,
 ADD COLUMN `informa_demandante` CHAR(1) NOT NULL DEFAULT 'S' AFTER `data_solucao_atendimento`,
 ADD COLUMN `enviar_email_cliente` CHAR(1) NOT NULL DEFAULT 'S' AFTER `informa_demandante`,
 ADD COLUMN `incluir_anexos_resposta_cliente` CHAR(1) NOT NULL DEFAULT 'S' AFTER `enviar_email_cliente`;

ALTER TABLE `db_pir_grc`.`grc_atendimento_pendencia` ADD COLUMN `parecer_encaminhamento` TEXT AFTER `incluir_anexos_resposta_cliente`;


ALTER TABLE `db_pir_grc`.`grc_atendimento_pendencia` CHANGE COLUMN `idt_status` `idt_status_tramitacao` INT(10) UNSIGNED DEFAULT NULL;

-- status da tramitação de pendência

CREATE TABLE `db_pir_grc`.`grc_atendimento_pendencia_status_tramitacao` (
  `idt` INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  `codigo` VARCHAR(45) NOT NULL,
  `descricao` VARCHAR(120) NOT NULL,
  `ativo` CHAR(1) NOT NULL DEFAULT 'S',
  `detalhe` TEXT,
  PRIMARY KEY (`idt`),
  UNIQUE INDEX `iu_grc_atendimento_pendencia_status_tramitacao`(`codigo`)
)
ENGINE = InnoDB;



insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_atendimento_pendencia_status_tramitacao','Status de Tramitação da Pendência','90.80.05.20','S','S','listar','listar');
insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_atendimento_pendencia_status_tramitacao') as id_funcao
from plu_direito where cod_direito in ('con','alt','inc','exc');
insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_atendimento_pendencia_status_tramitacao');


ALTER TABLE `db_pir_grc`.`grc_atendimento_pendencia` ADD CONSTRAINT `FK_grc_atendimento_pendencia_21` FOREIGN KEY `FK_grc_atendimento_pendencia_21` (`idt_status_tramitacao`)
    REFERENCES `grc_atendimento_pendencia_status_tramitacao` (`idt`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT;


ALTER TABLE `db_pir_grc`.`grc_atendimento_pendencia` MODIFY COLUMN `informa_demandante` CHAR(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'N',
 MODIFY COLUMN `enviar_email_cliente` CHAR(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'N',
 MODIFY COLUMN `incluir_anexos_resposta_cliente` CHAR(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'N'
, AUTO_INCREMENT = 1458;



-- Tabela para padronizar parametrização de email e sms
-- Comunicações diversas
CREATE TABLE `grc_comunica_processo` (
  `idt` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `codigo` varchar(45) NOT NULL,
  `descricao` varchar(120) NOT NULL,
  `ativo` char(1) NOT NULL DEFAULT 'S',
  `detalhe` text,
  `prazo` int(10) unsigned DEFAULT NULL,
  `quando` char(1) DEFAULT 'A',
  `aplicacao` varchar(120) NOT NULL DEFAULT 'Agenda',
  `origem` char(1) NOT NULL DEFAULT 'A',
  PRIMARY KEY (`idt`),
  UNIQUE KEY `iu_grc_comunica_processo` (`codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `grc_comunica` (
  `idt` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `codigo` varchar(45) NOT NULL,
  `descricao` varchar(500) NOT NULL,
  `ativo` char(1) NOT NULL DEFAULT 'S',
  `detalhe` text NOT NULL,
  `idt_processo` int(10) unsigned NOT NULL,
  `tipo` char(1) NOT NULL DEFAULT 'E',
  `origem` char(1) NOT NULL DEFAULT 'A',
  PRIMARY KEY (`idt`),
  UNIQUE KEY `iu_grc_comunica` (`codigo`),
  KEY `FK_grc_comunica_1` (`idt_processo`),
  CONSTRAINT `FK_grc_comunica_1` FOREIGN KEY (`idt_processo`) REFERENCES `grc_comunica_processo` (`idt`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE `grc_comunica_tag` (
  `idt` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `codigo` varchar(45) NOT NULL,
  `descricao` varchar(120) NOT NULL,
  `ativo` char(1) NOT NULL DEFAULT 'S',
  `detalhe` text,
  `tabela_p` varchar(120) DEFAULT NULL,
  `campo_p` varchar(120) DEFAULT NULL,
  `ordem` varchar(45) DEFAULT NULL,
  `disponivel` char(1) NOT NULL DEFAULT 'N',
  PRIMARY KEY (`idt`),
  UNIQUE KEY `iu_grc_comunica_tag` (`campo_p`,`codigo`) USING BTREE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;


insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_comunica_parametro','Comunicação - Parametrização','45','S','S','listar','listar');
insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_comunica_parametro') as id_funcao
from plu_direito where cod_direito in ('con','alt','inc','exc');
insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_comunica_parametro');


insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_comunica','Comunicação - Email,SMS, Relatório ','45.03','S','S','listar','listar');
insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_comunica') as id_funcao
from plu_direito where cod_direito in ('con','alt','inc','exc');
insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_comunica');

insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_comunica_processo','Processo de Comunicação - Parâmetros','45.04','S','S','listar','listar');
insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_comunica_processo') as id_funcao
from plu_direito where cod_direito in ('con','alt','inc','exc');
insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_comunica_processo');




insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_comunica_tag','Comunicação - TAG','45.05','S','S','listar','listar');
insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_comunica_tag') as id_funcao
from plu_direito where cod_direito in ('con','alt','inc','exc');
insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_comunica_tag');

-- 08-08-2017

ALTER TABLE `db_pir_grc`.`grc_atendimento_pendencia` ADD COLUMN `consideracoes_encaminhamento_pai` VARCHAR(5000) AFTER `parecer_encaminhamento`,
 ADD COLUMN `data_resposta_encaminhamento_pai` DATETIME AFTER `consideracoes_encaminhamento_pai`;

-- 10/08/2017

insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_atendimento_pendencia_consulta','Consulta Pendências','45.07','S','S','listar','listar');
insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_atendimento_pendencia_consulta') as id_funcao
from plu_direito where cod_direito in ('con');
insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_atendimento_pendencia_consulta');


ALTER TABLE `db_pir_grc`.`grc_atendimento_resumo` ADD COLUMN `idt_pendencia` INTEGER UNSIGNED AFTER `datahora`,
 ADD CONSTRAINT `FK_grc_atendimento_resumo_3` FOREIGN KEY `FK_grc_atendimento_resumo_3` (`idt_pendencia`)
    REFERENCES `grc_atendimento_pendencia` (`idt`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT;
-- 17-08-2017

ALTER TABLE `db_pir_grc`.`grc_funil_2017_gestao_meta` ADD COLUMN `regional_da_jurisdicao` VARCHAR(120) AFTER `meta9`;
ALTER TABLE `db_pir_grc`.`grc_funil_2017_gestao_meta` ADD COLUMN `cidade` VARCHAR(120) AFTER `regional_da_jurisdicao`;


ALTER TABLE `db_pir_grc`.`grc_funil_2017_gestao_meta` ADD COLUMN `dap` VARCHAR(120) AFTER `cidade`,
 ADD COLUMN `nirf` VARCHAR(120) AFTER `dap`,
 ADD COLUMN `rmp` VARCHAR(120) AFTER `nirf`,
 ADD COLUMN `ie` VARCHAR(120) AFTER `rmp`,
 ADD COLUMN `sicab` VARCHAR(120) AFTER `ie`;
 
 
 CREATE TABLE `db_pir_grc`.`grc_funil_cliente_classificado` (
  `idt` INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  `codigo` VARCHAR(45) NOT NULL,
  `razao_social` VARCHAR(120) NOT NULL,
  `idt_ponto_atendimento` INTEGER UNSIGNED,
  `ponto_atendimento` VARCHAR(120),
  `ponto_atendimento_regional` VARCHAR(120),
  `idt_ponto_atendimento_regional` INTEGER UNSIGNED,
  `nota` DECIMAL(15,2),
  `nota_promotor` DECIMAL(15,2),
  `nota_detrator` DECIMAL(15,2),
  `idt_cliente_classificacao` INTEGER UNSIGNED,
  `tipo_cliente` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`idt`),
  UNIQUE INDEX `iu_grc_funil_cliente_classificado`(`tipo_cliente`, `codigo`)
)
ENGINE = InnoDB;

ALTER TABLE `db_pir_grc`.`grc_funil_cliente_classificado` RENAME TO `db_pir_grc`.`grc_funil_2017_cliente_classificado`
, DROP INDEX `iu_grc_funil_cliente_classificado`,
 ADD UNIQUE INDEX `iu_grc_funi_2017_cliente_classificado` USING BTREE(`tipo_cliente`, `codigo`);

ALTER TABLE `db_pir_grc`.`grc_funil_2017_gestao_meta` ADD INDEX `Index_6`(`tipo_de_empreendimento`, `cnpj`);

-- ISSO É DO gec 

ALTER TABLE `db_pir_gec`.`gec_entidade` ADD INDEX `Index_18FUNIL`(`codigo`, `reg_situacao`);

-- funil

ALTER TABLE `db_pir_grc`.`grc_funil_2017_gestao_meta` ADD INDEX `Index_7`(`cnpj`);

ALTER TABLE `db_pir_grc`.`grc_funil_2017_cliente_classificado` MODIFY COLUMN `razao_social` VARCHAR(120) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL;

ALTER TABLE `db_pir_grc`.`grc_funil_2017_cliente_classificado` ADD COLUMN `meta1` CHAR(1) AFTER `tipo_cliente`,
 ADD COLUMN `meta2` CHAR(1) AFTER `meta1`;
 
 ALTER TABLE `db_pir_grc`.`grc_funil_2017_gestao_meta` MODIFY COLUMN `cnpj` VARCHAR(120) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
 MODIFY COLUMN `meta3` CHAR(1) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'N';
ALTER TABLE `db_pir_grc`.`grc_funil_2017_cliente_classificado` MODIFY COLUMN `codigo` VARCHAR(120) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;

ALTER TABLE `db_pir_grc`.`grc_funil_2017_gestao_meta` ADD COLUMN `codmicro` INTEGER UNSIGNED AFTER `sicab`;

CREATE TABLE `db_pir_grc`.`grc_funil_jurisdicao` (
  `idt` INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  `codigo` INTEGER UNSIGNED NOT NULL,
  `descricao` VARCHAR(120),
  PRIMARY KEY (`idt`),
  UNIQUE INDEX `iu_grc_funil_jurisdicao`(`codigo`)
)
ENGINE = InnoDB;



ALTER TABLE `db_pir_grc`.`grc_funil_jurisdicao` RENAME TO `db_pir_grc`.`grc_funil_2017_jurisdicao`
, DROP INDEX `iu_grc_funil_jurisdicao`,
 ADD UNIQUE INDEX `iu_grc_funil_2017_jurisdicao` USING BTREE(`codigo`);
 
 
 ALTER TABLE `db_pir_grc`.`grc_funil_2017_jurisdicao` MODIFY COLUMN `codigo` INT(10) UNSIGNED DEFAULT NULL;

ALTER TABLE `db_pir_grc`.`grc_funil_2017_jurisdicao` ADD COLUMN `quntidade` INTEGER UNSIGNED AFTER `descricao`;

ALTER TABLE `db_pir_grc`.`grc_funil_2017_jurisdicao` CHANGE COLUMN `quntidade` `quantidade` INT(10) UNSIGNED DEFAULT NULL;

ALTER TABLE `db_pir_grc`.`grc_funil_execucao` ADD COLUMN `codigo_jurisdicao` INTEGER UNSIGNED AFTER `net_promoter_score`;

ALTER TABLE `db_pir_grc`.`grc_funil_execucao` ADD COLUMN `descricao_jurisdicao` VARCHAR(45) AFTER `codigo_jurisdicao`;

ALTER TABLE `db_pir_grc`.`grc_atendimento_pendencia` ADD COLUMN `idt_pendencia_raiz` INTEGER UNSIGNED AFTER `data_resposta_encaminhamento_pai`;

-- 21-09-2017

ALTER TABLE `db_pir_grc`.`grc_atendimento_resumo` ADD COLUMN `link_util` VARCHAR(255) AFTER `idt_pendencia`;

ALTER TABLE `db_pir_grc`.`grc_atendimento_resumo` ADD COLUMN `bia_conteudo` LONGTEXT AFTER `link_util`,
 ADD COLUMN `bia_enviada` LONGTEXT AFTER `bia_conteudo`;


ALTER TABLE `db_pir_grc`.`grc_atendimento_resumo` ADD COLUMN `bia_acao` VARCHAR(45) AFTER `bia_enviada`;

ALTER TABLE `db_pir_grc`.`grc_atendimento_resumo` ADD COLUMN `idt_atendimento_agenda` INTEGER UNSIGNED AFTER `bia_acao`,
 ADD CONSTRAINT `FK_grc_atendimento_resumo_4` FOREIGN KEY `FK_grc_atendimento_resumo_4` (`idt_atendimento_agenda`)
    REFERENCES `grc_atendimento_agenda` (`idt`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT;

ALTER TABLE `db_pir_grc`.`grc_atendimento_resumo` ADD COLUMN `marcacao` TEXT AFTER `idt_atendimento_agenda`;


ALTER TABLE `db_pir_grc`.`grc_atendimento_pendencia` MODIFY COLUMN `data_solucao` DATETIME,
 MODIFY COLUMN `data_dasolucao` DATETIME;

-- 05/10/2017

select id_funcao INTO @id_funcao from plu_funcao where cod_funcao = 'conteudo_funil_relatorio.php';
INSERT INTO `db_pir_grc`.`plu_painel_funcao` (`idt_painel_grupo`, `id_funcao`, `pos_top`, `pos_left`, `imagem`, `imagem_d`, `texto_cab`, `detalhe`, `visivel`, `hint`, `parametros`, `texto_font_tam`, `texto_ativ_font_cor`, `texto_ativ_fundo`, `texto_desativ_font_cor`, `texto_desativ_fundo`, `include`, `include_arq`, `include_altura`, `include_largura`) VALUES 
('3', @id_funcao, '0', '260', '590_imagem_440_funil.png', NULL, 'Funil de Atendimento', NULL, 'S', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'N', NULL, NULL, NULL);

select id_funcao INTO @id_funcao from plu_funcao where cod_funcao = 'grc_funil_painel';
INSERT INTO `db_pir_grc`.`plu_painel_funcao` (`idt_painel_grupo`, `id_funcao`, `pos_top`, `pos_left`, `imagem`, `imagem_d`, `texto_cab`, `detalhe`, `visivel`, `hint`, `parametros`, `texto_font_tam`, `texto_ativ_font_cor`, `texto_ativ_fundo`, `texto_desativ_font_cor`, `texto_desativ_fundo`, `include`, `include_arq`, `include_altura`, `include_largura`) VALUES 
('3', @id_funcao, '0', '280', '585_imagem_024_funil.png', NULL, 'Cadastros do Funil de Atendimento', NULL, 'S', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'N', NULL, NULL, NULL);

INSERT INTO `db_pir_grc`.`plu_painel` (`codigo`, `classificacao`, `descricao`) VALUES ('grc_funil_painel', '88', 'Painel de Funil');
select idt INTO @idt_painel from plu_painel where codigo = 'grc_funil_painel';

INSERT INTO `db_pir_grc`.`plu_painel_grupo` (`idt_painel`, `codigo`, `ordem`, `descricao`, `hint`, `tit_mostrar`, `tit_bt_fecha`, `tit_font_tam`, `tit_font_cor`, `tit_fundo`, `mostra_item`, `texto_altura`, `texto_font_tam`, `texto_ativ_font_cor`, `texto_ativ_fundo`, `texto_desativ_font_cor`, `texto_desativ_fundo`, `move_item`, `passo`, `passo_tit`, `layout_grid`, `img_altura`, `img_largura`, `img_margem_dir`, `img_margem_esq`, `espaco_linha`, `painel_altura`, `painel_largura`) VALUES 
(@idt_painel, '1', '1', 'TABELAS DE APOIO', NULL, 'S', 'A', NULL, NULL, NULL, 'IT', '30', NULL, NULL, NULL, NULL, NULL, 'S', 'N', 'N', 'S', '70', '100', '15', '15', '15', '115', '910');
select idt INTO @idt_painel_grupo from plu_painel_grupo where idt_painel = @idt_painel and codigo = '1';

select id_funcao INTO @id_funcao from plu_funcao where cod_funcao = 'grc_funil_fase';
INSERT INTO `db_pir_grc`.`plu_painel_funcao` (`idt_painel_grupo`, `id_funcao`, `pos_top`, `pos_left`, `imagem`, `imagem_d`, `texto_cab`, `detalhe`, `visivel`, `hint`, `parametros`, `texto_font_tam`, `texto_ativ_font_cor`, `texto_ativ_fundo`, `texto_desativ_font_cor`, `texto_desativ_fundo`, `include`, `include_arq`, `include_altura`, `include_largura`) 
VALUES (@idt_painel_grupo, @id_funcao, '0', '0', '586_imagem_418_251imagemd042ic2pesquisaratendimento2.jpg', NULL, 'Fases do Funil do Atendimento', NULL, 'S', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'N', NULL, NULL, NULL);
select id_funcao INTO @id_funcao from plu_funcao where cod_funcao = 'grc_funil_classificacao';
INSERT INTO `db_pir_grc`.`plu_painel_funcao` (`idt_painel_grupo`, `id_funcao`, `pos_top`, `pos_left`, `imagem`, `imagem_d`, `texto_cab`, `detalhe`, `visivel`, `hint`, `parametros`, `texto_font_tam`, `texto_ativ_font_cor`, `texto_ativ_fundo`, `texto_desativ_font_cor`, `texto_desativ_fundo`, `include`, `include_arq`, `include_altura`, `include_largura`) 
VALUES (@idt_painel_grupo, @id_funcao, '0', '0', '588_imagem_763_262imagem022icpalestra2.jpg', NULL, 'Notas para identificação do Cliente', NULL, 'S', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'N', NULL, NULL, NULL);
select id_funcao INTO @id_funcao from plu_funcao where cod_funcao = 'grc_funil_parametro';
INSERT INTO `db_pir_grc`.`plu_painel_funcao` (`idt_painel_grupo`, `id_funcao`, `pos_top`, `pos_left`, `imagem`, `imagem_d`, `texto_cab`, `detalhe`, `visivel`, `hint`, `parametros`, `texto_font_tam`, `texto_ativ_font_cor`, `texto_ativ_fundo`, `texto_desativ_font_cor`, `texto_desativ_fundo`, `include`, `include_arq`, `include_altura`, `include_largura`) 
VALUES (@idt_painel_grupo, @id_funcao, '0', '0', '593_imagem_171_253imagemd057icpreferenciasdousuario-03.png', NULL, 'Parêmetros Gerais', NULL, 'S', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'N', NULL, NULL, NULL);
select id_funcao INTO @id_funcao from plu_funcao where cod_funcao = 'grc_atendimento_pendencia_status_tramitacao';
INSERT INTO `db_pir_grc`.`plu_painel_funcao` (`idt_painel_grupo`, `id_funcao`, `pos_top`, `pos_left`, `imagem`, `imagem_d`, `texto_cab`, `detalhe`, `visivel`, `hint`, `parametros`, `texto_font_tam`, `texto_ativ_font_cor`, `texto_ativ_fundo`, `texto_desativ_font_cor`, `texto_desativ_fundo`, `include`, `include_arq`, `include_altura`, `include_largura`) 
VALUES (@idt_painel_grupo, @id_funcao, '0', '0', '599_imagem_804_251imagemd042ic2pesquisaratendimento2.jpg', NULL, 'Status da Tramitação da Pendência', NULL, 'S', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'N', NULL, NULL, NULL);
select id_funcao INTO @id_funcao from plu_funcao where cod_funcao = 'grc_comunica';
INSERT INTO `db_pir_grc`.`plu_painel_funcao` (`idt_painel_grupo`, `id_funcao`, `pos_top`, `pos_left`, `imagem`, `imagem_d`, `texto_cab`, `detalhe`, `visivel`, `hint`, `parametros`, `texto_font_tam`, `texto_ativ_font_cor`, `texto_ativ_fundo`, `texto_desativ_font_cor`, `texto_desativ_fundo`, `include`, `include_arq`, `include_altura`, `include_largura`) 
VALUES (@idt_painel_grupo, @id_funcao, '0', '130', '600_imagem_625_mensagens.png', NULL, 'Email, SMS - Parâmetros', NULL, 'S', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'N', NULL, NULL, NULL);
select id_funcao INTO @id_funcao from plu_funcao where cod_funcao = 'grc_comunica_processo';
INSERT INTO `db_pir_grc`.`plu_painel_funcao` (`idt_painel_grupo`, `id_funcao`, `pos_top`, `pos_left`, `imagem`, `imagem_d`, `texto_cab`, `detalhe`, `visivel`, `hint`, `parametros`, `texto_font_tam`, `texto_ativ_font_cor`, `texto_ativ_fundo`, `texto_desativ_font_cor`, `texto_desativ_fundo`, `include`, `include_arq`, `include_altura`, `include_largura`) 
VALUES (@idt_painel_grupo, @id_funcao, '0', '130', '601_imagem_673_254imagem643icconsultoria2.jpg', NULL, 'Comunicação - Processos', NULL, 'S', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'N', NULL, NULL, NULL);
select id_funcao INTO @id_funcao from plu_funcao where cod_funcao = 'grc_comunica_tag';
INSERT INTO `db_pir_grc`.`plu_painel_funcao` (`idt_painel_grupo`, `id_funcao`, `pos_top`, `pos_left`, `imagem`, `imagem_d`, `texto_cab`, `detalhe`, `visivel`, `hint`, `parametros`, `texto_font_tam`, `texto_ativ_font_cor`, `texto_ativ_fundo`, `texto_desativ_font_cor`, `texto_desativ_fundo`, `include`, `include_arq`, `include_altura`, `include_largura`) 
VALUES (@idt_painel_grupo, @id_funcao, '0', '130', '602_imagem_738_254imagemd643icconsultoria3.jpg', NULL, 'TAGs de Comunicação', NULL, 'S', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'N', NULL, NULL, NULL);

INSERT INTO `db_pir_grc`.`plu_painel_grupo` (`idt_painel`, `codigo`, `ordem`, `descricao`, `hint`, `tit_mostrar`, `tit_bt_fecha`, `tit_font_tam`, `tit_font_cor`, `tit_fundo`, `mostra_item`, `texto_altura`, `texto_font_tam`, `texto_ativ_font_cor`, `texto_ativ_fundo`, `texto_desativ_font_cor`, `texto_desativ_fundo`, `move_item`, `passo`, `passo_tit`, `layout_grid`, `img_altura`, `img_largura`, `img_margem_dir`, `img_margem_esq`, `espaco_linha`, `painel_altura`, `painel_largura`) VALUES 
(@idt_painel, '2', '2', 'OBTENÇÃO DE  DADOS', NULL, 'S', 'A', NULL, NULL, NULL, 'IT', '30', NULL, NULL, NULL, NULL, NULL, 'S', 'N', 'N', 'S', '70', '100', '15', '15', '15', '0', '0');
select idt INTO @idt_painel_grupo from plu_painel_grupo where idt_painel = @idt_painel and codigo = '2';

select id_funcao INTO @id_funcao from plu_funcao where cod_funcao = 'grc_funil_meta';
INSERT INTO `db_pir_grc`.`plu_painel_funcao` (`idt_painel_grupo`, `id_funcao`, `pos_top`, `pos_left`, `imagem`, `imagem_d`, `texto_cab`, `detalhe`, `visivel`, `hint`, `parametros`, `texto_font_tam`, `texto_ativ_font_cor`, `texto_ativ_fundo`, `texto_desativ_font_cor`, `texto_desativ_fundo`, `include`, `include_arq`, `include_altura`, `include_largura`) 
VALUES (@idt_painel_grupo, @id_funcao, '0', '0', '589_imagem_986_251imagem042ic2pesquisaratendimento.jpg', NULL, 'Metas<br /> Unidade Regional', NULL, 'S', 'Possibilita informa as Metas por Unidade Regional.', NULL, NULL, NULL, NULL, NULL, NULL, 'N', NULL, NULL, NULL);
select id_funcao INTO @id_funcao from plu_funcao where cod_funcao = 'grc_funil_execucao';
INSERT INTO `db_pir_grc`.`plu_painel_funcao` (`idt_painel_grupo`, `id_funcao`, `pos_top`, `pos_left`, `imagem`, `imagem_d`, `texto_cab`, `detalhe`, `visivel`, `hint`, `parametros`, `texto_font_tam`, `texto_ativ_font_cor`, `texto_ativ_fundo`, `texto_desativ_font_cor`, `texto_desativ_fundo`, `include`, `include_arq`, `include_altura`, `include_largura`) 
VALUES (@idt_painel_grupo, @id_funcao, '0', '0', '591_imagem_968_263imagem136icrodadadenegocios2.jpg', NULL, 'Execução<br /> Unidade Regional', NULL, 'S', 'Informa a realização de valores por Unidade Regional.', NULL, NULL, NULL, NULL, NULL, NULL, 'N', NULL, NULL, NULL);
select id_funcao INTO @id_funcao from plu_funcao where cod_funcao = 'conteudo_funil_job.php';
INSERT INTO `db_pir_grc`.`plu_painel_funcao` (`idt_painel_grupo`, `id_funcao`, `pos_top`, `pos_left`, `imagem`, `imagem_d`, `texto_cab`, `detalhe`, `visivel`, `hint`, `parametros`, `texto_font_tam`, `texto_ativ_font_cor`, `texto_ativ_fundo`, `texto_desativ_font_cor`, `texto_desativ_fundo`, `include`, `include_arq`, `include_altura`, `include_largura`) 
VALUES (@idt_painel_grupo, @id_funcao, '0', '130', '595_imagem_389_254imagem643icconsultoria2.jpg', NULL, 'Executa Job<br />Metas Siacweb', NULL, 'S', 'Possibilita a execução do job para obter a sensibilização das Metas 1 e 7 no Siacweb,', NULL, NULL, NULL, NULL, NULL, NULL, 'N', NULL, NULL, NULL);

INSERT INTO `db_pir_grc`.`plu_painel_grupo` (`idt_painel`, `codigo`, `ordem`, `descricao`, `hint`, `tit_mostrar`, `tit_bt_fecha`, `tit_font_tam`, `tit_font_cor`, `tit_fundo`, `mostra_item`, `texto_altura`, `texto_font_tam`, `texto_ativ_font_cor`, `texto_ativ_fundo`, `texto_desativ_font_cor`, `texto_desativ_fundo`, `move_item`, `passo`, `passo_tit`, `layout_grid`, `img_altura`, `img_largura`, `img_margem_dir`, `img_margem_esq`, `espaco_linha`, `painel_altura`, `painel_largura`) VALUES 
(@idt_painel, '3', '3', 'RESULTADOS', NULL, 'S', 'A', NULL, NULL, NULL, 'IT', '30', NULL, NULL, NULL, NULL, NULL, 'S', 'N', 'N', 'S', '70', '100', '15', '15', '15', '0', '0');
select idt INTO @idt_painel_grupo from plu_painel_grupo where idt_painel = @idt_painel and codigo = '3';

select id_funcao INTO @id_funcao from plu_funcao where cod_funcao = 'conteudo_funil_relatorio.php';
INSERT INTO `db_pir_grc`.`plu_painel_funcao` (`idt_painel_grupo`, `id_funcao`, `pos_top`, `pos_left`, `imagem`, `imagem_d`, `texto_cab`, `detalhe`, `visivel`, `hint`, `parametros`, `texto_font_tam`, `texto_ativ_font_cor`, `texto_ativ_fundo`, `texto_desativ_font_cor`, `texto_desativ_fundo`, `include`, `include_arq`, `include_altura`, `include_largura`) 
VALUES (@idt_painel_grupo, @id_funcao, '0', '0', '596_imagem_087_254imagem643icconsultoria2.jpg', NULL, NULL, NULL, 'S', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'N', NULL, NULL, NULL);
select id_funcao INTO @id_funcao from plu_funcao where cod_funcao = 'grc_atendimento_pendencia_consulta';
INSERT INTO `db_pir_grc`.`plu_painel_funcao` (`idt_painel_grupo`, `id_funcao`, `pos_top`, `pos_left`, `imagem`, `imagem_d`, `texto_cab`, `detalhe`, `visivel`, `hint`, `parametros`, `texto_font_tam`, `texto_ativ_font_cor`, `texto_ativ_fundo`, `texto_desativ_font_cor`, `texto_desativ_fundo`, `include`, `include_arq`, `include_altura`, `include_largura`) 
VALUES (@idt_painel_grupo, @id_funcao, '0', '0', '603_imagem_541_251imagem042ic2pesquisaratendimento.jpg', NULL, 'Consultar Pendências', NULL, 'S', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'N', NULL, NULL, NULL);

INSERT INTO `db_pir_grc`.`grc_funil_classificacao` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `cordaclassificacao`, `nota_minima`) VALUES ('1', 'NOTA_PROMOTOR', 'CLIENTE PROMOTOR', 'S', NULL, '78FFC0', '2.00');
INSERT INTO `db_pir_grc`.`grc_funil_classificacao` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `cordaclassificacao`, `nota_minima`) VALUES ('2', 'NOTA_DETRATOR', 'CLIENTE DETRATOR', 'S', NULL, 'FFBE5C', '4.00');

INSERT INTO `db_pir_grc`.`grc_funil_execucao` (`idt`, `ano`, `detalhe`, `idt_unidade_regional`, `qtd_prospects`, `qtd_leads`, `qtd_sem_avaliacao`, `qtd_detrators`, `qtd_neutros`, `qtd_promotores`, `net_promoter_score`, `codigo_jurisdicao`, `descricao_jurisdicao`) VALUES ('1', '2017', 'teste de obs', '12', '1', '3332', '1979', '0', '0', '0', '12.67', '42', 'BARREIRAS');
INSERT INTO `db_pir_grc`.`grc_funil_execucao` (`idt`, `ano`, `detalhe`, `idt_unidade_regional`, `qtd_prospects`, `qtd_leads`, `qtd_sem_avaliacao`, `qtd_detrators`, `qtd_neutros`, `qtd_promotores`, `net_promoter_score`, `codigo_jurisdicao`, `descricao_jurisdicao`) VALUES ('2', '2017', NULL, '4', '111', '15373', '10195', '0', '0', '0', '12.34', '49', 'SALVADOR');
INSERT INTO `db_pir_grc`.`grc_funil_execucao` (`idt`, `ano`, `detalhe`, `idt_unidade_regional`, `qtd_prospects`, `qtd_leads`, `qtd_sem_avaliacao`, `qtd_detrators`, `qtd_neutros`, `qtd_promotores`, `net_promoter_score`, `codigo_jurisdicao`, `descricao_jurisdicao`) VALUES ('3', '2017', NULL, '19', '4', '4182', '4458', '0', '0', '0', '10.40', '47', 'FEIRA DE SANTANA');
INSERT INTO `db_pir_grc`.`grc_funil_execucao` (`idt`, `ano`, `detalhe`, `idt_unidade_regional`, `qtd_prospects`, `qtd_leads`, `qtd_sem_avaliacao`, `qtd_detrators`, `qtd_neutros`, `qtd_promotores`, `net_promoter_score`, `codigo_jurisdicao`, `descricao_jurisdicao`) VALUES ('4', '2017', NULL, '15', '44', '3515', '1855', '0', '0', '0', '34.00', '43', 'ILHÉUS');
INSERT INTO `db_pir_grc`.`grc_funil_execucao` (`idt`, `ano`, `detalhe`, `idt_unidade_regional`, `qtd_prospects`, `qtd_leads`, `qtd_sem_avaliacao`, `qtd_detrators`, `qtd_neutros`, `qtd_promotores`, `net_promoter_score`, `codigo_jurisdicao`, `descricao_jurisdicao`) VALUES ('5', '2017', NULL, '44', '9', '6', '7', '3', '4', '5', '66.00', NULL, 'JACOBINA');
INSERT INTO `db_pir_grc`.`grc_funil_execucao` (`idt`, `ano`, `detalhe`, `idt_unidade_regional`, `qtd_prospects`, `qtd_leads`, `qtd_sem_avaliacao`, `qtd_detrators`, `qtd_neutros`, `qtd_promotores`, `net_promoter_score`, `codigo_jurisdicao`, `descricao_jurisdicao`) VALUES ('6', '2017', NULL, '17', '5', '1953', '1079', '0', '0', '0', '66.00', '45', 'JUAZEIRO');
INSERT INTO `db_pir_grc`.`grc_funil_execucao` (`idt`, `ano`, `detalhe`, `idt_unidade_regional`, `qtd_prospects`, `qtd_leads`, `qtd_sem_avaliacao`, `qtd_detrators`, `qtd_neutros`, `qtd_promotores`, `net_promoter_score`, `codigo_jurisdicao`, `descricao_jurisdicao`) VALUES ('7', '2017', NULL, '27', '6', '2474', '1675', '0', '0', '0', '23.00', '51', 'S.A. JESUS');
INSERT INTO `db_pir_grc`.`grc_funil_execucao` (`idt`, `ano`, `detalhe`, `idt_unidade_regional`, `qtd_prospects`, `qtd_leads`, `qtd_sem_avaliacao`, `qtd_detrators`, `qtd_neutros`, `qtd_promotores`, `net_promoter_score`, `codigo_jurisdicao`, `descricao_jurisdicao`) VALUES ('8', '2017', NULL, '26', '5', '1539', '1157', '0', '0', '0', '5.00', '48', 'IRECÊ');
INSERT INTO `db_pir_grc`.`grc_funil_execucao` (`idt`, `ano`, `detalhe`, `idt_unidade_regional`, `qtd_prospects`, `qtd_leads`, `qtd_sem_avaliacao`, `qtd_detrators`, `qtd_neutros`, `qtd_promotores`, `net_promoter_score`, `codigo_jurisdicao`, `descricao_jurisdicao`) VALUES ('9', '2017', NULL, '10', '7', '3833', '1583', '0', '0', '0', '4.00', '46', 'TEIXEIRA DE FREITAS');
INSERT INTO `db_pir_grc`.`grc_funil_execucao` (`idt`, `ano`, `detalhe`, `idt_unidade_regional`, `qtd_prospects`, `qtd_leads`, `qtd_sem_avaliacao`, `qtd_detrators`, `qtd_neutros`, `qtd_promotores`, `net_promoter_score`, `codigo_jurisdicao`, `descricao_jurisdicao`) VALUES ('10', '2017', NULL, '21', '4', '6985', '3168', '0', '0', '0', '33.00', '52', 'VITÓRIA DA CONQUISTA');
INSERT INTO `db_pir_grc`.`grc_funil_execucao` (`idt`, `ano`, `detalhe`, `idt_unidade_regional`, `qtd_prospects`, `qtd_leads`, `qtd_sem_avaliacao`, `qtd_detrators`, `qtd_neutros`, `qtd_promotores`, `net_promoter_score`, `codigo_jurisdicao`, `descricao_jurisdicao`) VALUES ('11', '2017', NULL, '6', NULL, '43373', '8', '0', '0', '0', NULL, '54', 'ATENDIMENTO INDIVIDUAL');

INSERT INTO `db_pir_grc`.`grc_funil_fase` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `cordafase`, `nome`, `cortextfase`) VALUES ('1', '01', 'PROSPECT', 'S', 'No atendimento, o CNPJ será automaticamente classificado e identificado como PROSPECT caso nenhuma das situações a seguir (itens 3.4.2, 3.4.3, 3.4.4, 3.4.5 e 3.4.6) sejam atendidas;', '33F554', 'PROSPECT', 'FFFFFF');
INSERT INTO `db_pir_grc`.`grc_funil_fase` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `cordafase`, `nome`, `cortextfase`) VALUES ('2', '02', 'LEAD', 'S', 'O CNPJ que já sensibilizou a META 1 e que ainda NÃO sensibilizou a META 7 do SEBRAE/BA, no ano corrente, será classificado e identificado automaticamente no atendimento como LEAD;', 'ED4E42', 'LEAD', 'FFFFFF');
INSERT INTO `db_pir_grc`.`grc_funil_fase` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `cordafase`, `nome`, `cortextfase`) VALUES ('3', '03', 'CLIENTE SEM AVALIAÇÃO', 'S', 'O CNPJ que já sensibilizou a META 7 e que NÃO possui “Nota da Avaliação”, será classificado e identificado automaticamente no atendimento como “CLIENTE SEM AVALIAÇÃO”;', '000000', 'CLIENTE', 'FFFFFF');
INSERT INTO `db_pir_grc`.`grc_funil_fase` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `cordafase`, `nome`, `cortextfase`) VALUES ('4', '04', 'CLIENTE DETRATOR', 'S', 'O CNPJ que já sensibilizou a META 7 e que possui “Nota da Avaliação” menor ou igual a cadastrada no parâmetro NOTA_DETRATOR, será classificado e identificado automaticamente no atendimento como “CLIENTE DETRATOR”;', '0000FF', 'CLIENTE', 'FFFFFF');
INSERT INTO `db_pir_grc`.`grc_funil_fase` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `cordafase`, `nome`, `cortextfase`) VALUES ('5', '05', 'CLIENTE NEUTRO', 'S', 'O CNPJ que já sensibilizou a META 7 e que possui “Nota da Avaliação” maior que a cadastrada no parâmetro NOTA_DETRATOR e menor que a cadastrada no parâmetro NOTA_PROMOTOR, será classificado e identificado automaticamente no atendimento como “CLIENTE NEUTRO”;', 'FFDD00', 'CLIENTE', '000000');
INSERT INTO `db_pir_grc`.`grc_funil_fase` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `cordafase`, `nome`, `cortextfase`) VALUES ('6', '06', 'CLIENTE PROMOTOR', 'S', '', '00FFFF', 'CLIENTE', 'FFFFFF');

INSERT INTO `db_pir_grc`.`grc_funil_meta` (`idt`, `ano`, `detalhe`, `idt_unidade_regional`, `qtd_prospects`, `qtd_leads`, `qtd_clientes`, `net_promoter_score`) VALUES ('1', '2017', 'ccc', '4', '40', '30', '55', '12.34');
INSERT INTO `db_pir_grc`.`grc_funil_meta` (`idt`, `ano`, `detalhe`, `idt_unidade_regional`, `qtd_prospects`, `qtd_leads`, `qtd_clientes`, `net_promoter_score`) VALUES ('2', '2017', NULL, '12', '2', '4', '6', '2.00');
INSERT INTO `db_pir_grc`.`grc_funil_meta` (`idt`, `ano`, `detalhe`, `idt_unidade_regional`, `qtd_prospects`, `qtd_leads`, `qtd_clientes`, `net_promoter_score`) VALUES ('3', '2017', NULL, '19', '6', '6', '6', '6.00');
INSERT INTO `db_pir_grc`.`grc_funil_meta` (`idt`, `ano`, `detalhe`, `idt_unidade_regional`, `qtd_prospects`, `qtd_leads`, `qtd_clientes`, `net_promoter_score`) VALUES ('4', '2017', NULL, '15', '8', '8', '8', '8.00');
INSERT INTO `db_pir_grc`.`grc_funil_meta` (`idt`, `ano`, `detalhe`, `idt_unidade_regional`, `qtd_prospects`, `qtd_leads`, `qtd_clientes`, `net_promoter_score`) VALUES ('5', '2017', NULL, '44', '9', '9', '9', '9.00');
INSERT INTO `db_pir_grc`.`grc_funil_meta` (`idt`, `ano`, `detalhe`, `idt_unidade_regional`, `qtd_prospects`, `qtd_leads`, `qtd_clientes`, `net_promoter_score`) VALUES ('6', '2017', NULL, '17', '44', '44', '4', '4.00');
INSERT INTO `db_pir_grc`.`grc_funil_meta` (`idt`, `ano`, `detalhe`, `idt_unidade_regional`, `qtd_prospects`, `qtd_leads`, `qtd_clientes`, `net_promoter_score`) VALUES ('7', '2017', NULL, '27', '7', '7', '7', '7.00');
INSERT INTO `db_pir_grc`.`grc_funil_meta` (`idt`, `ano`, `detalhe`, `idt_unidade_regional`, `qtd_prospects`, `qtd_leads`, `qtd_clientes`, `net_promoter_score`) VALUES ('8', '2017', NULL, '6', '8', '8', '8', '8.00');
INSERT INTO `db_pir_grc`.`grc_funil_meta` (`idt`, `ano`, `detalhe`, `idt_unidade_regional`, `qtd_prospects`, `qtd_leads`, `qtd_clientes`, `net_promoter_score`) VALUES ('11', '2017', NULL, '26', '1', '1', '1', '1.00');
INSERT INTO `db_pir_grc`.`grc_funil_meta` (`idt`, `ano`, `detalhe`, `idt_unidade_regional`, `qtd_prospects`, `qtd_leads`, `qtd_clientes`, `net_promoter_score`) VALUES ('12', '2017', NULL, '10', '7', '7', '7', '7.00');
INSERT INTO `db_pir_grc`.`grc_funil_meta` (`idt`, `ano`, `detalhe`, `idt_unidade_regional`, `qtd_prospects`, `qtd_leads`, `qtd_clientes`, `net_promoter_score`) VALUES ('14', '2017', NULL, '21', '10', '10', '10', '10.00');

INSERT INTO `db_pir_grc`.`grc_funil_parametro` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `ano_ativo`) VALUES ('1', 'PAR', 'Parâmetros Gerais do Funil de Atendimento', 'S', 'aqui vai o alerta para clientes sem avaliação', '2017');

INSERT INTO `db_pir_grc`.`grc_atendimento_pendencia_status_tramitacao` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`) VALUES ('1', '01', 'ABERTO', 'S', NULL);
INSERT INTO `db_pir_grc`.`grc_atendimento_pendencia_status_tramitacao` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`) VALUES ('2', '02', 'ENCAMINHADO', 'S', NULL);
INSERT INTO `db_pir_grc`.`grc_atendimento_pendencia_status_tramitacao` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`) VALUES ('3', '03', 'FINALIZADO - DEMANDA ATENDIDA', 'S', NULL);
INSERT INTO `db_pir_grc`.`grc_atendimento_pendencia_status_tramitacao` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`) VALUES ('4', '04', 'FINALIZADO - DEMANDA CANCELADA', 'S', NULL);

INSERT INTO `db_pir_grc`.`grc_comunica_processo` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `prazo`, `quando`, `aplicacao`, `origem`) VALUES ('1', '02', 'Avisar ao Demandante que um Demandado respondeu', 'S', 'Avisar a um demandante que um demandado respondeu', '8', 'A', 'Agenda', 'A');
INSERT INTO `db_pir_grc`.`grc_comunica_processo` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `prazo`, `quando`, `aplicacao`, `origem`) VALUES ('2', '01', 'Aviso ao demandado de Pendência Criada', 'S', 'Avisar ao Demandado que ele tem Pendência', '8', 'A', 'Agenda', 'A');
INSERT INTO `db_pir_grc`.`grc_comunica_processo` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `prazo`, `quando`, `aplicacao`, `origem`) VALUES ('3', '03', 'Avisar ao Cliente que tem a resposta', 'S', NULL, '8', 'A', 'Agenda', 'A');

INSERT INTO `db_pir_grc`.`grc_comunica` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `idt_processo`, `tipo`, `origem`) VALUES ('4', '02', 'aVISAR A UM DEMANDANTE QUE QUE UM DEMANDADO RESPONDEU', 'S', '<p style=\"text-align: justify; \"><font face=\"Open Sans, Arial, sans-serif\"><span style=\"font-size: 14px;\">aVISAR A UM DEMANDANTE QUE QUE UM DEMANDADO RESPONDEU</span></font></p>', '1', 'E', 'P');
INSERT INTO `db_pir_grc`.`grc_comunica` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `idt_processo`, `tipo`, `origem`) VALUES ('5', '01', 'Aviso ao Demandado de Pendência Criada', 'S', '<p>&nbsp;Aviso ao DEMANDADO PEND&Ecirc;NCIA cRIADA</p>\r\n<p>&nbsp;</p>\r\n<pre>\r\n#data] =&gt; data\r\n            [#observacao] =&gt; observacao\r\n            [#idt_usuario] =&gt; idt_usuario\r\n            [#data_solucao] =&gt; data_solucao\r\n            [#idt_responsavel_solucao] =&gt; idt_responsavel_solucao\r\n            [#enviar_email] =&gt; enviar_email\r\n            [#recorrencia] =&gt; recorrencia\r\n            [#assunto] =&gt; assunto\r\n            [#solucao] =&gt; solucao\r\n            [#data_dasolucao] =&gt; data_dasolucao\r\n            [#idt_gestor_local] =&gt; idt_gestor_local\r\n            [#protocolo] =&gt; protocolo\r\n            [#status] =&gt; status\r\n            [#tipo] =&gt; tipo\r\n            [#ativo] =&gt; ativo\r\n            [#idt_ponto_atendimento] =&gt; idt_ponto_atendimento\r\n            [#cod_cliente_siac] =&gt; cod_cliente_siac\r\n            [#nome_cliente] =&gt; nome_cliente\r\n            [#cod_empreendimento_siac] =&gt; cod_empreendimento_siac\r\n            [#nome_empreendimento] =&gt; nome_empreendimento\r\n            [#cpf] =&gt; cpf\r\n            [#cnpj] =&gt; cnpj\r\n            [#idt_atendimento_pendencia] =&gt; idt_atendimento_pendencia\r\n            [#temporario] =&gt; temporario\r\n            [#idt_usuario_update] =&gt; idt_usuario_update\r\n            [#dt_update] =&gt; dt_update\r\n            [#idt_evento_situacao_de] =&gt; idt_evento_situacao_de\r\n            [#idt_evento_situacao_para] =&gt; idt_evento_situacao_para\r\n            [#idt_atendimento_pendencia_trans] =&gt; idt_atendimento_pendencia_trans\r\n            [#dt_limite_trans] =&gt; dt_limite_trans\r\n            [#idt_responsavel_acao] =&gt; idt_responsavel_acao\r\n            [#data_acao] =&gt; data_acao\r\n            [#e_ou] =&gt; e_ou\r\n            [#apagado] =&gt; apagado\r\n            [#idt_pendencia_pai] =&gt; idt_pendencia_pai\r\n            [#idt_status_tramitacao] =&gt; idt_status_tramitacao\r\n            [#data_resposta_final] =&gt; data_resposta_final\r\n            [#email_cliente] =&gt; email_cliente\r\n            [#data_resposta_encaminhamento] =&gt; data_resposta_encaminhamento\r\n            [#data_fechamento] =&gt; data_fechamento\r\n            [#opcao_tramitacao] =&gt; opcao_tramitacao\r\n            [#consideracoes_encaminhamento] =&gt; consideracoes_encaminhamento\r\n            [#data_solucao_atendimento] =&gt; data_solucao_atendimento\r\n            [#informa_demandante] =&gt; informa_demandante\r\n            [#enviar_email_cliente] =&gt; enviar_email_cliente\r\n            [#incluir_anexos_resposta_cliente] =&gt; incluir_anexos_resposta_cliente\r\n            [#parecer_encaminhamento] =&gt; parecer_encaminhamento\r\n            [#consideracoes_encaminhamento_pai] =&gt; consideracoes_encaminhamento_pai\r\n            [#data_resposta_encaminhamento_pai] =&gt; data_resposta_encaminhamento_pai</pre>', '2', 'E', 'P');
INSERT INTO `db_pir_grc`.`grc_comunica` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `idt_processo`, `tipo`, `origem`) VALUES ('6', '03', 'Avisar ao Cliente que tem a resposta', 'S', '<p>&nbsp;Avisar ao Cliente que tem a resposta</p>', '3', 'E', 'P');

INSERT INTO `db_pir_grc`.`grc_comunica_tag` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `tabela_p`, `campo_p`, `ordem`, `disponivel`) VALUES ('401', '#idt', 'idt', 'S', NULL, 'grc_atendimento_agenda', 'idt', '99', 'N');
INSERT INTO `db_pir_grc`.`grc_comunica_tag` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `tabela_p`, `campo_p`, `ordem`, `disponivel`) VALUES ('402', '#idt_nan_ordem_pagamento', 'idt_nan_ordem_pagamento', 'S', NULL, 'grc_atendimento_agenda', 'idt_nan_ordem_pagamento', '99', 'N');
INSERT INTO `db_pir_grc`.`grc_comunica_tag` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `tabela_p`, `campo_p`, `ordem`, `disponivel`) VALUES ('403', '#idt_evento', 'idt_evento', 'S', NULL, 'grc_atendimento_agenda', 'idt_evento', '99', 'N');
INSERT INTO `db_pir_grc`.`grc_comunica_tag` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `tabela_p`, `campo_p`, `ordem`, `disponivel`) VALUES ('404', '#idt_evento_publicacao', 'idt_evento_publicacao', 'S', NULL, 'grc_atendimento_agenda', 'idt_evento_publicacao', '99', 'N');
INSERT INTO `db_pir_grc`.`grc_comunica_tag` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `tabela_p`, `campo_p`, `ordem`, `disponivel`) VALUES ('405', '#idt_pfo_af_processo', 'idt_pfo_af_processo', 'S', NULL, 'grc_atendimento_agenda', 'idt_pfo_af_processo', '99', 'N');
INSERT INTO `db_pir_grc`.`grc_comunica_tag` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `tabela_p`, `campo_p`, `ordem`, `disponivel`) VALUES ('406', '#idt_transferencia_responsabilidade', 'idt_transferencia_responsabilidade', 'S', NULL, 'grc_atendimento_agenda', 'idt_transferencia_responsabilidade', '99', 'N');
INSERT INTO `db_pir_grc`.`grc_comunica_tag` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `tabela_p`, `campo_p`, `ordem`, `disponivel`) VALUES ('407', '#idt_atendimento', 'idt_atendimento', 'S', NULL, 'grc_atendimento_agenda', 'idt_atendimento', '99', 'N');
INSERT INTO `db_pir_grc`.`grc_comunica_tag` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `tabela_p`, `campo_p`, `ordem`, `disponivel`) VALUES ('408', '#idt_atendimento_abertura', 'idt_atendimento_abertura', 'S', NULL, 'grc_atendimento_agenda', 'idt_atendimento_abertura', '99', 'N');
INSERT INTO `db_pir_grc`.`grc_comunica_tag` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `tabela_p`, `campo_p`, `ordem`, `disponivel`) VALUES ('409', '#data', 'data', 'S', NULL, 'grc_atendimento_agenda', 'data', '99', 'N');
INSERT INTO `db_pir_grc`.`grc_comunica_tag` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `tabela_p`, `campo_p`, `ordem`, `disponivel`) VALUES ('410', '#observacao', 'observacao', 'S', NULL, 'grc_atendimento_agenda', 'observacao', '99', 'N');
INSERT INTO `db_pir_grc`.`grc_comunica_tag` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `tabela_p`, `campo_p`, `ordem`, `disponivel`) VALUES ('411', '#idt_usuario', 'idt_usuario', 'S', NULL, 'grc_atendimento_agenda', 'idt_usuario', '99', 'N');
INSERT INTO `db_pir_grc`.`grc_comunica_tag` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `tabela_p`, `campo_p`, `ordem`, `disponivel`) VALUES ('412', '#data_solucao', 'data_solucao', 'S', NULL, 'grc_atendimento_agenda', 'data_solucao', '99', 'N');
INSERT INTO `db_pir_grc`.`grc_comunica_tag` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `tabela_p`, `campo_p`, `ordem`, `disponivel`) VALUES ('413', '#idt_responsavel_solucao', 'idt_responsavel_solucao', 'S', NULL, 'grc_atendimento_agenda', 'idt_responsavel_solucao', '99', 'N');
INSERT INTO `db_pir_grc`.`grc_comunica_tag` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `tabela_p`, `campo_p`, `ordem`, `disponivel`) VALUES ('414', '#enviar_email', 'enviar_email', 'S', NULL, 'grc_atendimento_agenda', 'enviar_email', '99', 'N');
INSERT INTO `db_pir_grc`.`grc_comunica_tag` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `tabela_p`, `campo_p`, `ordem`, `disponivel`) VALUES ('415', '#recorrencia', 'recorrencia', 'S', NULL, 'grc_atendimento_agenda', 'recorrencia', '99', 'N');
INSERT INTO `db_pir_grc`.`grc_comunica_tag` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `tabela_p`, `campo_p`, `ordem`, `disponivel`) VALUES ('416', '#assunto', 'assunto', 'S', NULL, 'grc_atendimento_agenda', 'assunto', '99', 'N');
INSERT INTO `db_pir_grc`.`grc_comunica_tag` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `tabela_p`, `campo_p`, `ordem`, `disponivel`) VALUES ('417', '#solucao', 'solucao', 'S', NULL, 'grc_atendimento_agenda', 'solucao', '99', 'N');
INSERT INTO `db_pir_grc`.`grc_comunica_tag` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `tabela_p`, `campo_p`, `ordem`, `disponivel`) VALUES ('418', '#data_dasolucao', 'data_dasolucao', 'S', NULL, 'grc_atendimento_agenda', 'data_dasolucao', '99', 'N');
INSERT INTO `db_pir_grc`.`grc_comunica_tag` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `tabela_p`, `campo_p`, `ordem`, `disponivel`) VALUES ('419', '#idt_gestor_local', 'idt_gestor_local', 'S', NULL, 'grc_atendimento_agenda', 'idt_gestor_local', '99', 'N');
INSERT INTO `db_pir_grc`.`grc_comunica_tag` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `tabela_p`, `campo_p`, `ordem`, `disponivel`) VALUES ('420', '#protocolo', 'protocolo', 'S', NULL, 'grc_atendimento_agenda', 'protocolo', '99', 'N');
INSERT INTO `db_pir_grc`.`grc_comunica_tag` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `tabela_p`, `campo_p`, `ordem`, `disponivel`) VALUES ('421', '#status', 'status', 'S', NULL, 'grc_atendimento_agenda', 'status', '99', 'N');
INSERT INTO `db_pir_grc`.`grc_comunica_tag` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `tabela_p`, `campo_p`, `ordem`, `disponivel`) VALUES ('422', '#tipo', 'tipo', 'S', NULL, 'grc_atendimento_agenda', 'tipo', '99', 'N');
INSERT INTO `db_pir_grc`.`grc_comunica_tag` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `tabela_p`, `campo_p`, `ordem`, `disponivel`) VALUES ('423', '#ativo', 'ativo', 'S', NULL, 'grc_atendimento_agenda', 'ativo', '99', 'N');
INSERT INTO `db_pir_grc`.`grc_comunica_tag` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `tabela_p`, `campo_p`, `ordem`, `disponivel`) VALUES ('424', '#idt_ponto_atendimento', 'idt_ponto_atendimento', 'S', NULL, 'grc_atendimento_agenda', 'idt_ponto_atendimento', '99', 'N');
INSERT INTO `db_pir_grc`.`grc_comunica_tag` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `tabela_p`, `campo_p`, `ordem`, `disponivel`) VALUES ('425', '#cod_cliente_siac', 'cod_cliente_siac', 'S', NULL, 'grc_atendimento_agenda', 'cod_cliente_siac', '99', 'N');
INSERT INTO `db_pir_grc`.`grc_comunica_tag` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `tabela_p`, `campo_p`, `ordem`, `disponivel`) VALUES ('426', '#nome_cliente', 'nome_cliente', 'S', NULL, 'grc_atendimento_agenda', 'nome_cliente', '99', 'N');
INSERT INTO `db_pir_grc`.`grc_comunica_tag` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `tabela_p`, `campo_p`, `ordem`, `disponivel`) VALUES ('427', '#cod_empreendimento_siac', 'cod_empreendimento_siac', 'S', NULL, 'grc_atendimento_agenda', 'cod_empreendimento_siac', '99', 'N');
INSERT INTO `db_pir_grc`.`grc_comunica_tag` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `tabela_p`, `campo_p`, `ordem`, `disponivel`) VALUES ('428', '#nome_empreendimento', 'nome_empreendimento', 'S', NULL, 'grc_atendimento_agenda', 'nome_empreendimento', '99', 'N');
INSERT INTO `db_pir_grc`.`grc_comunica_tag` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `tabela_p`, `campo_p`, `ordem`, `disponivel`) VALUES ('429', '#cpf', 'cpf', 'S', NULL, 'grc_atendimento_agenda', 'cpf', '99', 'N');
INSERT INTO `db_pir_grc`.`grc_comunica_tag` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `tabela_p`, `campo_p`, `ordem`, `disponivel`) VALUES ('430', '#cnpj', 'cnpj', 'S', NULL, 'grc_atendimento_agenda', 'cnpj', '99', 'N');
INSERT INTO `db_pir_grc`.`grc_comunica_tag` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `tabela_p`, `campo_p`, `ordem`, `disponivel`) VALUES ('431', '#idt_atendimento_pendencia', 'idt_atendimento_pendencia', 'S', NULL, 'grc_atendimento_agenda', 'idt_atendimento_pendencia', '99', 'N');
INSERT INTO `db_pir_grc`.`grc_comunica_tag` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `tabela_p`, `campo_p`, `ordem`, `disponivel`) VALUES ('432', '#temporario', 'temporario', 'S', NULL, 'grc_atendimento_agenda', 'temporario', '99', 'N');
INSERT INTO `db_pir_grc`.`grc_comunica_tag` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `tabela_p`, `campo_p`, `ordem`, `disponivel`) VALUES ('433', '#idt_usuario_update', 'idt_usuario_update', 'S', NULL, 'grc_atendimento_agenda', 'idt_usuario_update', '99', 'N');
INSERT INTO `db_pir_grc`.`grc_comunica_tag` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `tabela_p`, `campo_p`, `ordem`, `disponivel`) VALUES ('434', '#dt_update', 'dt_update', 'S', NULL, 'grc_atendimento_agenda', 'dt_update', '99', 'N');
INSERT INTO `db_pir_grc`.`grc_comunica_tag` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `tabela_p`, `campo_p`, `ordem`, `disponivel`) VALUES ('435', '#idt_evento_situacao_de', 'idt_evento_situacao_de', 'S', NULL, 'grc_atendimento_agenda', 'idt_evento_situacao_de', '99', 'N');
INSERT INTO `db_pir_grc`.`grc_comunica_tag` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `tabela_p`, `campo_p`, `ordem`, `disponivel`) VALUES ('436', '#idt_evento_situacao_para', 'idt_evento_situacao_para', 'S', NULL, 'grc_atendimento_agenda', 'idt_evento_situacao_para', '99', 'N');
INSERT INTO `db_pir_grc`.`grc_comunica_tag` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `tabela_p`, `campo_p`, `ordem`, `disponivel`) VALUES ('437', '#idt_atendimento_pendencia_trans', 'idt_atendimento_pendencia_trans', 'S', NULL, 'grc_atendimento_agenda', 'idt_atendimento_pendencia_trans', '99', 'N');
INSERT INTO `db_pir_grc`.`grc_comunica_tag` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `tabela_p`, `campo_p`, `ordem`, `disponivel`) VALUES ('438', '#dt_limite_trans', 'dt_limite_trans', 'S', NULL, 'grc_atendimento_agenda', 'dt_limite_trans', '99', 'N');
INSERT INTO `db_pir_grc`.`grc_comunica_tag` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `tabela_p`, `campo_p`, `ordem`, `disponivel`) VALUES ('439', '#idt_responsavel_acao', 'idt_responsavel_acao', 'S', NULL, 'grc_atendimento_agenda', 'idt_responsavel_acao', '99', 'N');
INSERT INTO `db_pir_grc`.`grc_comunica_tag` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `tabela_p`, `campo_p`, `ordem`, `disponivel`) VALUES ('440', '#data_acao', 'data_acao', 'S', NULL, 'grc_atendimento_agenda', 'data_acao', '99', 'N');
INSERT INTO `db_pir_grc`.`grc_comunica_tag` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `tabela_p`, `campo_p`, `ordem`, `disponivel`) VALUES ('441', '#e_ou', 'e_ou', 'S', NULL, 'grc_atendimento_agenda', 'e_ou', '99', 'N');
INSERT INTO `db_pir_grc`.`grc_comunica_tag` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `tabela_p`, `campo_p`, `ordem`, `disponivel`) VALUES ('442', '#apagado', 'apagado', 'S', NULL, 'grc_atendimento_agenda', 'apagado', '99', 'N');
INSERT INTO `db_pir_grc`.`grc_comunica_tag` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `tabela_p`, `campo_p`, `ordem`, `disponivel`) VALUES ('443', '#idt_pendencia_pai', 'idt_pendencia_pai', 'S', NULL, 'grc_atendimento_agenda', 'idt_pendencia_pai', '99', 'N');
INSERT INTO `db_pir_grc`.`grc_comunica_tag` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `tabela_p`, `campo_p`, `ordem`, `disponivel`) VALUES ('444', '#idt_status_tramitacao', 'idt_status_tramitacao', 'S', NULL, 'grc_atendimento_agenda', 'idt_status_tramitacao', '99', 'N');
INSERT INTO `db_pir_grc`.`grc_comunica_tag` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `tabela_p`, `campo_p`, `ordem`, `disponivel`) VALUES ('445', '#data_resposta_final', 'data_resposta_final', 'S', NULL, 'grc_atendimento_agenda', 'data_resposta_final', '99', 'N');
INSERT INTO `db_pir_grc`.`grc_comunica_tag` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `tabela_p`, `campo_p`, `ordem`, `disponivel`) VALUES ('446', '#email_cliente', 'email_cliente', 'S', NULL, 'grc_atendimento_agenda', 'email_cliente', '99', 'N');
INSERT INTO `db_pir_grc`.`grc_comunica_tag` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `tabela_p`, `campo_p`, `ordem`, `disponivel`) VALUES ('447', '#data_resposta_encaminhamento', 'data_resposta_encaminhamento', 'S', NULL, 'grc_atendimento_agenda', 'data_resposta_encaminhamento', '99', 'N');
INSERT INTO `db_pir_grc`.`grc_comunica_tag` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `tabela_p`, `campo_p`, `ordem`, `disponivel`) VALUES ('448', '#data_fechamento', 'data_fechamento', 'S', NULL, 'grc_atendimento_agenda', 'data_fechamento', '99', 'N');
INSERT INTO `db_pir_grc`.`grc_comunica_tag` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `tabela_p`, `campo_p`, `ordem`, `disponivel`) VALUES ('449', '#opcao_tramitacao', 'opcao_tramitacao', 'S', NULL, 'grc_atendimento_agenda', 'opcao_tramitacao', '99', 'N');
INSERT INTO `db_pir_grc`.`grc_comunica_tag` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `tabela_p`, `campo_p`, `ordem`, `disponivel`) VALUES ('450', '#consideracoes_encaminhamento', 'consideracoes_encaminhamento', 'S', NULL, 'grc_atendimento_agenda', 'consideracoes_encaminhamento', '99', 'N');
INSERT INTO `db_pir_grc`.`grc_comunica_tag` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `tabela_p`, `campo_p`, `ordem`, `disponivel`) VALUES ('451', '#data_solucao_atendimento', 'data_solucao_atendimento', 'S', NULL, 'grc_atendimento_agenda', 'data_solucao_atendimento', '99', 'N');
INSERT INTO `db_pir_grc`.`grc_comunica_tag` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `tabela_p`, `campo_p`, `ordem`, `disponivel`) VALUES ('452', '#informa_demandante', 'informa_demandante', 'S', NULL, 'grc_atendimento_agenda', 'informa_demandante', '99', 'N');
INSERT INTO `db_pir_grc`.`grc_comunica_tag` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `tabela_p`, `campo_p`, `ordem`, `disponivel`) VALUES ('453', '#enviar_email_cliente', 'enviar_email_cliente', 'S', NULL, 'grc_atendimento_agenda', 'enviar_email_cliente', '99', 'N');
INSERT INTO `db_pir_grc`.`grc_comunica_tag` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `tabela_p`, `campo_p`, `ordem`, `disponivel`) VALUES ('454', '#incluir_anexos_resposta_cliente', 'incluir_anexos_resposta_cliente', 'S', NULL, 'grc_atendimento_agenda', 'incluir_anexos_resposta_cliente', '99', 'N');
INSERT INTO `db_pir_grc`.`grc_comunica_tag` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `tabela_p`, `campo_p`, `ordem`, `disponivel`) VALUES ('455', '#parecer_encaminhamento', 'parecer_encaminhamento', 'S', NULL, 'grc_atendimento_agenda', 'parecer_encaminhamento', '99', 'N');
INSERT INTO `db_pir_grc`.`grc_comunica_tag` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `tabela_p`, `campo_p`, `ordem`, `disponivel`) VALUES ('456', '#consideracoes_encaminhamento_pai', 'consideracoes_encaminhamento_pai', 'S', NULL, 'grc_atendimento_agenda', 'consideracoes_encaminhamento_pai', '99', 'N');
INSERT INTO `db_pir_grc`.`grc_comunica_tag` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `tabela_p`, `campo_p`, `ordem`, `disponivel`) VALUES ('457', '#data_resposta_encaminhamento_pai', 'data_resposta_encaminhamento_pai', 'S', NULL, 'grc_atendimento_agenda', 'data_resposta_encaminhamento_pai', '99', 'N');
INSERT INTO `db_pir_grc`.`grc_comunica_tag` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `tabela_p`, `campo_p`, `ordem`, `disponivel`) VALUES ('458', '#idt_pendencia_raiz', 'idt_pendencia_raiz', 'S', NULL, 'grc_atendimento_agenda', 'idt_pendencia_raiz', '99', 'N');

INSERT INTO `db_pir_grc`.`grc_atendimento_resumo_acao` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`) VALUES ('1', '01', 'Envio de conteúdo da BIA', 'S', NULL);
INSERT INTO `db_pir_grc`.`grc_atendimento_resumo_acao` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`) VALUES ('2', '02', 'Acesso a um Link útil', 'S', NULL);
INSERT INTO `db_pir_grc`.`grc_atendimento_resumo_acao` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`) VALUES ('3', '03', 'Abertura de Consultoria SEBRAETEC', 'S', NULL);
INSERT INTO `db_pir_grc`.`grc_atendimento_resumo_acao` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`) VALUES ('4', '04', 'Cadastramento de Pendência', 'S', NULL);
INSERT INTO `db_pir_grc`.`grc_atendimento_resumo_acao` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`) VALUES ('5', '05', 'Agendamento - Marcação', 'S', NULL);
INSERT INTO `db_pir_grc`.`grc_atendimento_resumo_acao` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`) VALUES ('6', '06', 'Agendamento - Desmarcação', 'S', NULL);
INSERT INTO `db_pir_grc`.`grc_atendimento_resumo_acao` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`) VALUES ('7', '07', 'Agendamento - Exclusão', 'S', NULL);

insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_relatorios_presencial','Painel dos Relatorios do Presencial','40.37','S','S','inc','inc');
insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_relatorios_presencial') as id_funcao
from plu_direito where cod_direito in ('con','alt','inc','exc');
insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_relatorios_presencial');

-- desenvolve
-- homologacao
-- sala
