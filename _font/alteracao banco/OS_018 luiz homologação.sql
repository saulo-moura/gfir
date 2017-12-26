-- 21/10/2017

-- FUNIL

ALTER TABLE `db_pir_grc`.`grc_funil_2017_cliente_classificado` ADD COLUMN `meta7` CHAR(1) AFTER `meta2`;
ALTER TABLE `db_pir_grc`.`grc_funil_2017_gestao_meta` DROP INDEX `Index_7`,
 ADD INDEX `Index_7` USING BTREE(`cnpj`, `meta1`),
 ADD INDEX `Index_8`(`cnpj`, `meta7`);

ALTER TABLE `db_pir_grc`.`grc_funil_2017_gestao_meta` ADD COLUMN `campo_semcnpj` VARCHAR(45) AFTER `codmicro`;

ALTER TABLE `db_pir_grc`.`grc_funil_2017_cliente_classificado` ADD COLUMN `campo_semcnpj` VARCHAR(45) AFTER `meta7`;


ALTER TABLE `db_pir_grc`.`grc_funil_2017_cliente_classificado` ADD COLUMN `tipo_empreendimento` VARCHAR(120) AFTER `campo_semcnpj`;

ALTER TABLE `db_pir_grc`.`grc_atendimento_resumo` ADD COLUMN `complemento_acao` VARCHAR(500) AFTER `marcacao`;

ALTER TABLE `db_pir_grc`.`grc_funil_2017_gestao_meta` ADD COLUMN `codempreendimento` INTEGER UNSIGNED AFTER `campo_semcnpj`;


ALTER TABLE `db_pir_grc`.`grc_funil_parametro` ADD COLUMN `msgClienteSemClassificacao` VARCHAR(500) AFTER `ano_ativo`;

ALTER TABLE `db_pir_grc`.`grc_funil_parametro` CHANGE COLUMN `msgClienteSemClassificacao` `msgclientesemclassificacao` VARCHAR(500) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL;


ALTER TABLE `db_pir_gec`.`gec_entidade` ADD COLUMN `funil_cliente_data_avaliacao` DATETIME AFTER `funil_idt_cliente_classificacao`,
 ADD COLUMN `funil_cliente_obs_avaliacao` VARCHAR(255) AFTER `funil_cliente_data_avaliacao`;



ALTER TABLE `db_pir_grc`.`grc_atendimento_organizacao` ADD COLUMN `funil_cliente_data_avaliacao` DATETIME AFTER `funil_idt_cliente_classificacao`,
 ADD COLUMN `funil_cliente_obs_avaliacao` VARCHAR(255) AFTER `funil_cliente_data_avaliacao`;



ALTER TABLE `db_pir_grc`.`grc_entidade_organizacao` ADD COLUMN `funil_cliente_data_avaliacao` DATETIME AFTER `funil_idt_cliente_classificacao`,
 ADD COLUMN `funil_cliente_obs_avaliacao` VARCHAR(255) AFTER `funil_cliente_data_avaliacao`;

-- sala

-- 20-12-2017
ALTER TABLE `db_pir_grc`.`grc_funil_historico_nota_classificacao` ADD COLUMN `idt_classificacao` INTEGER UNSIGNED AFTER `comentario`;
