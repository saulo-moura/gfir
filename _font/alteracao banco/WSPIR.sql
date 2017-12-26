-- esmeraldo
-- treina
-- producao

-- 29/06/2017

ALTER TABLE `grc_entidade_pessoa_arquivo_interesse`
ADD COLUMN `idt_gec_entidade_pessoa_arquivo_interesse`  int(10) UNSIGNED NULL AFTER `arquivo`;

-- 30/06/2017

ALTER TABLE `grc_entidade_pessoa`
ADD COLUMN `excluido_ws`  char(1) NOT NULL DEFAULT 'N' AFTER `idt_entidade`;

ALTER TABLE `grc_entidade_organizacao`
ADD COLUMN `excluido_ws`  char(1) NOT NULL DEFAULT 'N' AFTER `idt_entidade`;

-- desenvolve

-- 24/07/2017

update grc_atendimento set evento_origem = 'PIR' where evento_origem is null or evento_origem = '';

ALTER TABLE `grc_atendimento`
MODIFY COLUMN `evento_origem`  varchar(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'PIR' AFTER `idt_atendimento_pai`;

-- 24/07/2017

update grc_atendimento set evento_origem = 'PIR' where evento_origem is null or evento_origem = '';

ALTER TABLE `grc_atendimento`
MODIFY COLUMN `evento_origem`  varchar(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'PIR' AFTER `idt_atendimento_pai`;

-- 20/09/2017

ALTER TABLE db_pir_gec.`gec_entidade`
ADD COLUMN `dt_ult_alteracao`  timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP AFTER `reg_situacao_usuario`;

ALTER TABLE `grc_entidade_pessoa`
ADD COLUMN `dt_ult_alteracao`  datetime NULL AFTER `idt_entidade`;

ALTER TABLE `grc_entidade_organizacao`
ADD COLUMN `dt_ult_alteracao`  datetime NULL AFTER `idt_entidade`;

-- jonata
-- homologacao
-- sala