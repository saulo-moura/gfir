-- linux

-- 11/11/2015

ALTER TABLE `grc_atendimento_organizacao`
ADD COLUMN `novo_registro`  char(1) NOT NULL DEFAULT 'N' AFTER `codigo_prod_rural`;

update grc_atendimento_organizacao set novo_registro = 'N';

CREATE TABLE `grc_atendimento_organizacao_tipo_informacao` (
  `idt` int(10) unsigned NOT NULL,
  `idt_tipo_informacao_e` int(10) unsigned NOT NULL,
  PRIMARY KEY (`idt`,`idt_tipo_informacao_e`),
  KEY `fk_grc_atendimento_organizacao_tipo_informacao_2` (`idt_tipo_informacao_e`),
  CONSTRAINT `fk_grc_atendimento_organizacao_tipo_informacao_2` FOREIGN KEY (`idt_tipo_informacao_e`) REFERENCES `db_pir_gec`.`gec_entidade_tipo_informacao` (`idt`),
  CONSTRAINT `fk_grc_atendimento_organizacao_tipo_informacao_1` FOREIGN KEY (`idt`) REFERENCES `grc_atendimento_organizacao` (`idt`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `grc_atendimento_pessoa_tipo_informacao` (
  `idt` int(10) unsigned NOT NULL,
  `idt_tipo_informacao` int(10) unsigned NOT NULL,
  PRIMARY KEY (`idt`,`idt_tipo_informacao`),
  KEY `fk_grc_atendimento_pessoa_tipo_informacao_2` (`idt_tipo_informacao`),
  CONSTRAINT `fk_grc_atendimento_pessoa_tipo_informacao_2` FOREIGN KEY (`idt_tipo_informacao`) REFERENCES `db_pir_gec`.`gec_entidade_tipo_informacao` (`idt`),
  CONSTRAINT `fk_grc_atendimento_pessoa_tipo_informacao_1` FOREIGN KEY (`idt`) REFERENCES `grc_atendimento_pessoa` (`idt`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `grc_atendimento_pessoa_tipo_deficiencia` (
  `idt` int(10) unsigned NOT NULL,
  `idt_tipo_deficiencia` int(10) unsigned NOT NULL,
  PRIMARY KEY (`idt`,`idt_tipo_deficiencia`),
  KEY `fk_grc_atendimento_pessoa_tipo_deficiencia_2` (`idt_tipo_deficiencia`),
  CONSTRAINT `fk_grc_atendimento_pessoa_tipo_deficiencia_2` FOREIGN KEY (`idt_tipo_deficiencia`) REFERENCES `db_pir_gec`.`gec_entidade_tipo_deficiencia` (`idt`),
  CONSTRAINT `fk_grc_atendimento_pessoa_tipo_deficiencia_1` FOREIGN KEY (`idt`) REFERENCES `grc_atendimento_pessoa` (`idt`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- 12/12/2015

ALTER TABLE db_pir_siac_ba.`cargcli`
ADD PRIMARY KEY (`codcargcli`);

ALTER TABLE `grc_atendimento_organizacao`
ADD COLUMN `representa_codcargcli`  int(10) NULL AFTER `novo_registro`;

ALTER TABLE `grc_atendimento_organizacao` ADD CONSTRAINT `FK_grc_atendimento_organizacao_2` FOREIGN KEY (`representa_codcargcli`) REFERENCES `db_pir_siac_ba`.`cargcli` (`codcargcli`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE db_pir_siac_ba.`contato`
MODIFY COLUMN `rowguid`  char(36) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL AFTER `codcargcli`,
ADD PRIMARY KEY (`codcontatopj`, `codcontatopf`);

update db_pir_gec.gec_entidade set codigo_siacweb = 323170369 where codigo_siacweb = 996662834;
update db_pir_grc.grc_atendimento_pessoa set codigo_siacweb = 323170369 where codigo_siacweb = 996662834;
update db_pir_grc.grc_atendimento_organizacao set codigo_siacweb_e = 323170369 where codigo_siacweb_e = 996662834;

ALTER TABLE `grc_atendimento_instrumento`
ADD COLUMN `descricao_siacweb`  varchar(120) NOT NULL AFTER `descricao`;

update grc_atendimento_instrumento set descricao_siacweb = descricao;

UPDATE `grc_atendimento_instrumento` SET `descricao`='ORIENTAÇÃO TÉCNICA' WHERE (`idt`='13');
UPDATE `grc_atendimento_instrumento` SET `descricao_siacweb`='Orientação Técnica Presencial' WHERE (`idt`='13');
UPDATE `grc_atendimento_instrumento` SET `descricao_siacweb`='Informação Presencial' WHERE (`idt`='8');
UPDATE `grc_atendimento_instrumento` SET `descricao_siacweb`='Consultoria Presencial' WHERE (`idt`='2');

ALTER TABLE db_pir.`sca_organizacao_secao`
ADD COLUMN `unidoperacional_siacweb`  int NULL AFTER `posto_atendimento`;

ALTER TABLE db_pir.`sca_organizacao_secao` ADD CONSTRAINT `FK_sca_organizacao_secao_3` FOREIGN KEY (`unidoperacional_siacweb`) REFERENCES `db_pir_siac_ba`.`unidoperacional` (`codunidop`) ON DELETE RESTRICT ON UPDATE RESTRICT;

UPDATE `db_pir`.`sca_organizacao_secao` SET `unidoperacional_siacweb`='26182' WHERE (`idt`='15');

ALTER TABLE `plu_usuario`
ADD COLUMN `cpf`  char(12) NULL AFTER `fase_acao_projeto`,
ADD COLUMN `codparceiro_siacweb`  int(10) NULL AFTER `cpf`;

ALTER TABLE `db_pir`.`sca_organizacao_secao`
ADD COLUMN `cpf_responsavel`  char(12) NULL,
ADD COLUMN `codparceiro_siacweb`  int(10) NULL;

-- 13/11/2015

ALTER TABLE `grc_atendimento_pessoa`
MODIFY COLUMN `logradouro_complemento`  varchar(120) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL AFTER `logradouro_numero`,
MODIFY COLUMN `logradouro_referencia`  varchar(120) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL AFTER `logradouro_complemento`,
ADD COLUMN `logradouro_codbairro`  int(11) NULL AFTER `logradouro_referencia`,
ADD COLUMN `logradouro_codcid`  int(11) NULL AFTER `logradouro_bairro`,
ADD COLUMN `logradouro_codest`  int(11) NULL AFTER `logradouro_cidade`,
ADD COLUMN `logradouro_codpais`  int(11) NULL AFTER `logradouro_estado`;

ALTER TABLE `grc_atendimento_organizacao`
MODIFY COLUMN `logradouro_complemento_e`  varchar(120) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL AFTER `logradouro_numero_e`,
MODIFY COLUMN `logradouro_referencia_e`  varchar(120) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL AFTER `logradouro_complemento_e`,
ADD COLUMN `logradouro_codbairro_e`  int(11) NULL AFTER `logradouro_referencia_e`,
ADD COLUMN `logradouro_codcid_e`  int(11) NULL AFTER `logradouro_bairro_e`,
ADD COLUMN `logradouro_codest_e`  int(11) NULL AFTER `logradouro_cidade_e`,
ADD COLUMN `logradouro_codpais_e`  int(11) NULL AFTER `logradouro_estado_e`;

-- homologa
