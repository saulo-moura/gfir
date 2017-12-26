-- 17/08/2015

ALTER TABLE `plu_usuario`
ADD COLUMN `alt_status_produto`  char(1) NOT NULL DEFAULT 'N' AFTER `idt_projeto`;

-- 18/08/2015

ALTER TABLE `grc_produto_insumo`
MODIFY COLUMN `descricao`  varchar(120) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL AFTER `codigo`;

-- 02/10/2015

delete from grc_produto_insumo;
ALTER TABLE `grc_produto_insumo` AUTO_INCREMENT=1;

delete from grc_insumo;
ALTER TABLE `grc_insumo` AUTO_INCREMENT=1;

delete from grc_insumo_elemento_custo;
ALTER TABLE `grc_insumo_elemento_custo` AUTO_INCREMENT=1;

delete from grc_insumo_unidade;
ALTER TABLE `grc_insumo_unidade` AUTO_INCREMENT=1;

ALTER TABLE `grc_insumo`
ADD COLUMN `tipo`  char(1) NOT NULL AFTER `codigo_rm`,
ADD COLUMN `idprd`  int(10) NOT NULL AFTER `tipo`;

ALTER TABLE `grc_insumo`
MODIFY COLUMN `por_participante`  varchar(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL AFTER `custo_unitario_real`;

ALTER TABLE `grc_insumo`
MODIFY COLUMN `idprd`  int(10) NULL AFTER `tipo`;

-- 05/10/2015

ALTER TABLE `grc_produto_insumo`
MODIFY COLUMN `por_participante`  varchar(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL AFTER `idt_insumo_unidade`;

-- 10/10/2015

ALTER TABLE `grc_produto` DROP FOREIGN KEY `FK_grc_produto_9`;

ALTER TABLE `grc_produto` DROP FOREIGN KEY `FK_grc_produto_10`;

-- 12/10/2015

ALTER TABLE `plu_log_sistema`
MODIFY COLUMN `ip_usuario`  varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL COMMENT 'NÃºmero do ID do UsuÃ¡rio Ativo.' AFTER `nom_usuario`;

CREATE TABLE `plu_log_sistema_detalhe` (
  `id_lsd` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_log_sistema` int(10) NOT NULL,
  `campo_tabela` varchar(255) NOT NULL,
  `campo_desc` varchar(255) DEFAULT NULL,
  `vl_ant` longtext,
  `vl_atu` longtext,
  PRIMARY KEY (`id_lsd`),
  KEY `fk_log_sistema_detalhe_1` (`id_log_sistema`),
  CONSTRAINT `plu_log_sistema_detalhe_ibfk_1` FOREIGN KEY (`id_log_sistema`) REFERENCES `plu_log_sistema` (`id_log_sistema`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `plu_log_sistema_tab` (
  `idt` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tabela` varchar(45) NOT NULL,
  `descricao` varchar(255) NOT NULL,
  PRIMARY KEY (`idt`),
  UNIQUE KEY `un_plu_log_sistema_tab_2` (`tabela`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

INSERT INTO `plu_log_sistema_tab` (`tabela`, `descricao`) VALUES ('plu_log_sistema', 'Atual');

ALTER TABLE `plu_log_sistema_detalhe`
ADD COLUMN `desc_ant`  longtext NULL AFTER `vl_atu`,
ADD COLUMN `desc_atu`  longtext NULL AFTER `desc_ant`;

delete from plu_erro_msg;
ALTER TABLE `plu_erro_msg` AUTO_INCREMENT=1;

INSERT INTO `plu_erro_msg` (`data`, `origem_msg`, `num_erro`, `msg_erro`, `msg_usuario`) VALUES ('2014-12-10 11:27:35', 'mysql', '23000.i', '', 'Não é possível incluir %23000.i% com os mesmos dados de outro já existente!');
INSERT INTO `plu_erro_msg` (`data`, `origem_msg`, `num_erro`, `msg_erro`, `msg_usuario`) VALUES ('2014-12-10 11:27:35', 'mysql', '23000.d', '', 'Exclusão não pode ser feita pois existem %23000.d% associadas a esse item!');
INSERT INTO `plu_erro_msg` (`data`, `origem_msg`, `num_erro`, `msg_erro`, `msg_usuario`) VALUES ('2014-12-10 11:27:35', 'mysql', '23000.u', '', 'Não é possível alterar dados do %23000.u% para os mesmos dados de outro já existente!');

-- homologa

-- 16/10/2015

UPDATE `plu_funcao` SET `des_prefixo`='inc', `prefixo_menu`='inc' WHERE (`id_funcao`='580');

ALTER TABLE `grc_atendimento_organizacao`
ADD COLUMN `dap`  varchar(45) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL AFTER `tamanho_propriedade`,
ADD COLUMN `nirf`  varchar(45) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL AFTER `dap`,
ADD COLUMN `rmp`  varchar(45) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL AFTER `nirf`,
ADD COLUMN `ie_prod_rural`  varchar(45) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL AFTER `rmp`;

-- 19/10/2015

ALTER TABLE `grc_atendimento_organizacao`
MODIFY COLUMN `idt_cnae_principal`  varchar(45) NULL DEFAULT NULL AFTER `idt_setor`;

CREATE TABLE `grc_atendimento_organizacao_cnae` (
  `idt` INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  `idt_atendimento_organizacao` INTEGER UNSIGNED NOT NULL,
  `cnae` VARCHAR(45) NOT NULL,
  `observacao` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`idt`),
  UNIQUE INDEX `un_grc_atendimento_organizacao_cnae_2`(`idt_atendimento_organizacao`, `cnae`),
  CONSTRAINT `fk_grc_atendimento_organizacao_cnae_1` FOREIGN KEY `fk_grc_atendimento_organizacao_cnae_1` (`idt_atendimento_organizacao`)
    REFERENCES `grc_atendimento_organizacao` (`idt`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT
)
ENGINE = InnoDB;

insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_atendimento_organizacao_cnae','Atendimento Organização CNAE','99.99.99','N','N','listar','listar');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_atendimento_organizacao_cnae') as id_funcao
from plu_direito where cod_direito in ('alt', 'con', 'inc', 'exc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_atendimento_organizacao_cnae');

ALTER TABLE `grc_atendimento_organizacao_cnae` MODIFY COLUMN `observacao` VARCHAR(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL;

ALTER TABLE `grc_atendimento_organizacao_cnae` DROP COLUMN `observacao`;

-- 22/10/2015

ALTER TABLE `grc_atendimento_organizacao_cnae` DROP FOREIGN KEY `fk_grc_atendimento_organizacao_cnae_1`;

ALTER TABLE `grc_atendimento_organizacao_cnae` ADD CONSTRAINT `fk_grc_atendimento_organizacao_cnae_1` FOREIGN KEY (`idt_atendimento_organizacao`) REFERENCES `grc_atendimento_organizacao` (`idt`) ON DELETE CASCADE ON UPDATE RESTRICT;

ALTER TABLE `grc_atendimento_pessoa_arquivo_interesse` DROP FOREIGN KEY `FK_grc_atendimento_pessoa_arquivo_interesse_1`;

ALTER TABLE `grc_atendimento_pessoa_arquivo_interesse` ADD CONSTRAINT `FK_grc_atendimento_pessoa_arquivo_interesse_1` FOREIGN KEY (`idt_atendimento_pessoa`) REFERENCES `grc_atendimento_pessoa` (`idt`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `grc_atendimento_pessoa_produto_interesse` DROP FOREIGN KEY `FK_grc_atendimento_pessoa_produto_interesse_1`;

ALTER TABLE `grc_atendimento_pessoa_produto_interesse` ADD CONSTRAINT `FK_grc_atendimento_pessoa_produto_interesse_1` FOREIGN KEY (`idt_atendimento_pessoa`) REFERENCES `grc_atendimento_pessoa` (`idt`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `grc_atendimento_pessoa_tema_interesse` DROP FOREIGN KEY `FK_grc_atendimento_pessoa_tema_interesse_1`;

ALTER TABLE `grc_atendimento_pessoa_tema_interesse` ADD CONSTRAINT `FK_grc_atendimento_pessoa_tema_interesse_1` FOREIGN KEY (`idt_atendimento_pessoa`) REFERENCES `grc_atendimento_pessoa` (`idt`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `grc_atendimento_produto`
MODIFY COLUMN `codigo`  varchar(45) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL AFTER `idt_produto`,
MODIFY COLUMN `descricao`  varchar(120) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL AFTER `codigo`,
MODIFY COLUMN `ativo`  varchar(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT 'S' AFTER `descricao`,
MODIFY COLUMN `tipo_tratamento`  varchar(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT 'T' AFTER `detalhe`;

-- 23/10/2015

ALTER TABLE `grc_atendimento_organizacao`
ADD COLUMN `codigo_prod_rural`  varchar(45) NULL AFTER `desvincular`;

ALTER TABLE `grc_atendimento`
ADD COLUMN `data_atendimento_aberta`  char(1) NOT NULL DEFAULT 'N' AFTER `primeiro`;

ALTER TABLE `grc_atendimento`
ADD COLUMN `data_atendimento_relogio`  char(1) NOT NULL DEFAULT 'S' AFTER `primeiro`;

update grc_atendimento set idt_cliente = 107, idt_pessoa = 449;

ALTER TABLE `grc_atendimento` ADD CONSTRAINT `FK_grc_atendimento_17` FOREIGN KEY (`idt_cliente`) REFERENCES `grc_atendimento_organizacao` (`idt`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `grc_atendimento` ADD CONSTRAINT `FK_grc_atendimento_18` FOREIGN KEY (`idt_pessoa`) REFERENCES `grc_atendimento_pessoa` (`idt`) ON DELETE RESTRICT ON UPDATE RESTRICT;

-- 24/10/2015

ALTER TABLE `grc_atendimento` DROP FOREIGN KEY `FK_grc_atendimento_18`;

ALTER TABLE `grc_atendimento` DROP FOREIGN KEY `FK_grc_atendimento_17`;

ALTER TABLE `grc_atendimento` ADD CONSTRAINT `FK_grc_atendimento_18` FOREIGN KEY (`idt_pessoa`) REFERENCES `grc_atendimento_pessoa` (`idt`) ON DELETE SET NULL ON UPDATE RESTRICT;

ALTER TABLE `grc_atendimento` ADD CONSTRAINT `FK_grc_atendimento_17` FOREIGN KEY (`idt_cliente`) REFERENCES `grc_atendimento_organizacao` (`idt`) ON DELETE SET NULL ON UPDATE RESTRICT;

INSERT INTO `db_pir_gec`.`gec_entidade_classe` (`codigo`, `descricao`, `ativo`, `detalhe`, `tipo_entidade`) VALUES ('80.028.P', 'Cliente', 'S', NULL, 'P');
INSERT INTO `db_pir_gec`.`gec_endereco_tipo` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `ordem_contratacao`) VALUES ('8', '99', 'ATENDIMENTO', 'S', NULL, 'N');

-- 26/10/2015

ALTER TABLE `grc_tema_subtema`
ADD COLUMN `palavras_chaves`  varchar(255) NULL AFTER `detalhe`,
ADD COLUMN `rowguid`  varchar(45) NULL AFTER `palavras_chaves`;

update grc_tema_subtema set ativo = 'N';

ALTER TABLE `grc_atendimento_pendencia`
MODIFY COLUMN `solucao`  text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL AFTER `assunto`;

update grc_atendimento set idt_competencia = 1;

ALTER TABLE `grc_atendimento_instrumento`
ADD COLUMN `balcao`  char(1) NULL DEFAULT 'N' AFTER `idt_atendimento_instrumento`;

UPDATE `grc_atendimento_instrumento` SET `balcao`='S' WHERE (`idt`='2');
UPDATE `grc_atendimento_instrumento` SET `balcao`='S' WHERE (`idt`='8');
UPDATE `grc_atendimento_instrumento` SET `balcao`='S' WHERE (`idt`='13');

-- 03/11/2015

CREATE TABLE `grc_sincroniza_siac` (
  `idt` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idt_entidade` int(10) unsigned NOT NULL,
  `idt_atendimento` int(10) unsigned NOT NULL,
  `tipo` char(1) NOT NULL,
  `dt_registro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `dt_sincroniza` datetime DEFAULT NULL,
  `erro` text,
  PRIMARY KEY (`idt`),
  UNIQUE KEY `un_grc_sincroniza_siac_1` (`idt_entidade`,`idt_atendimento`),
  KEY `fk_grc_sincroniza_siac_2` (`idt_atendimento`),
  CONSTRAINT `fk_grc_sincroniza_siac_2` FOREIGN KEY (`idt_atendimento`) REFERENCES `grc_atendimento` (`idt`),
  CONSTRAINT `fk_grc_sincroniza_siac_1` FOREIGN KEY (`idt_entidade`) REFERENCES `db_pir_gec`.`gec_entidade` (`idt`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `grc_sincroniza_siac`
DROP INDEX `un_grc_sincroniza_siac_1` ,
ADD UNIQUE INDEX `un_grc_sincroniza_siac_1` (`idt_entidade`, `idt_atendimento`, `tipo`) USING BTREE ;

-- 04/11/2015

ALTER TABLE `grc_sincroniza_siac`
MODIFY COLUMN `idt_entidade`  int(10) UNSIGNED NULL AFTER `idt`;

ALTER TABLE `plu_erro_msg`
MODIFY COLUMN `origem_msg`  varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL COMMENT 'Origem da mensagem' AFTER `data`;

ALTER TABLE `plu_erro_log`
MODIFY COLUMN `origem_msg`  varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL COMMENT 'Origem da Mensagem.' AFTER `nom_tela`;

UPDATE `grc_atendimento_instrumento` SET `descricao`='ORIENTAÇÃO TÉCNICA PRESENCIAL' WHERE (`idt`='13');

-- linux
-- homologa
