
-- 2017-06-07

ALTER TABLE `db_pir_grc`.`grc_atendimento_pa_pessoa` ADD COLUMN `ativo_pa` CHAR(1) DEFAULT 'N' AFTER `pode_feriado`;

-- sala