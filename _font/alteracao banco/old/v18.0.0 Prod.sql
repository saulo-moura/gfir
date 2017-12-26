-- esmeraldo

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

-- homologacao
-- sala
-- jonata
-- producao
