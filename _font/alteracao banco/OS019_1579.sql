-- esmeraldo
-- desenvolve

-- 05/08/2017

ALTER TABLE `grc_entidade_organizacao`
ADD COLUMN `sicab_codigo`  varchar(20) NULL AFTER `ie_prod_rural`,
ADD COLUMN `sicab_dt_validade`  date NULL AFTER `sicab_codigo`;

ALTER TABLE `grc_atendimento_organizacao`
ADD COLUMN `sicab_codigo`  varchar(20) NULL AFTER `ie_prod_rural`,
ADD COLUMN `sicab_dt_validade`  date NULL AFTER `sicab_codigo`;

-- 07/08/2017

ALTER TABLE `grc_entidade_organizacao`
ADD COLUMN `data_fim_atividade`  date NULL DEFAULT NULL AFTER `data_abertura`,
ADD COLUMN `siacweb_situacao_e`  tinyint(1) NULL DEFAULT 1 COMMENT '0 para inativo ou 1 para ativo' AFTER `data_fim_atividade`;

ALTER TABLE `grc_atendimento_organizacao`
ADD COLUMN `data_fim_atividade`  date NULL DEFAULT NULL AFTER `data_abertura`,
ADD COLUMN `siacweb_situacao_e`  tinyint(1) NULL DEFAULT 1 COMMENT '0 para inativo ou 1 para ativo' AFTER `data_fim_atividade`;

ALTER TABLE `grc_entidade_pessoa`
ADD COLUMN `idt_ativeconpf`  int(10) UNSIGNED NULL DEFAULT NULL AFTER `falta_sincronizar_siacweb`,
ADD COLUMN `siacweb_situacao`  tinyint(1) NULL DEFAULT 1 COMMENT '0 para inativo ou 1 para ativo' AFTER `idt_ativeconpf`;

ALTER TABLE `grc_entidade_pessoa` ADD CONSTRAINT `FK_grc_entidade_pessoa_5` FOREIGN KEY (`idt_ativeconpf`) REFERENCES `db_pir_gec`.`gec_entidade_ativeconpf` (`idt`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `grc_atendimento_pessoa`
ADD COLUMN `idt_ativeconpf`  int(10) UNSIGNED NULL DEFAULT NULL AFTER `falta_sincronizar_siacweb`,
ADD COLUMN `siacweb_situacao`  tinyint(1) NULL DEFAULT 1 COMMENT '0 para inativo ou 1 para ativo' AFTER `idt_ativeconpf`;

ALTER TABLE `grc_atendimento_pessoa` ADD CONSTRAINT `FK_grc_atendimento_pessoa_6` FOREIGN KEY (`idt_ativeconpf`) REFERENCES `db_pir_gec`.`gec_entidade_ativeconpf` (`idt`) ON DELETE RESTRICT ON UPDATE RESTRICT;

-- 11/08/2017

update db_pir_gec.gec_entidade_pessoa set idt_ativeconpf = 1 where idt_ativeconpf is null;
update db_pir_grc.grc_entidade_pessoa set idt_ativeconpf = 1 where idt_ativeconpf is null;
update db_pir_grc.grc_atendimento_pessoa set idt_ativeconpf = 1 where idt_ativeconpf is null;

-- homologacao
-- producao
-- sala
-- jonata