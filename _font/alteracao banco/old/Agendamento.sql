-- 12/05/2017

-- pode dar problema pois tinha incosistência e podem ter registros duplicados e inconsistentes

ALTER TABLE `db_pir_grc`.`grc_atendimento_pa_pessoa_servico` DROP INDEX `iu_grc_atendimento_pa_pessoa_servico`,
 ADD INDEX `iu_grc_atendimento_pa_pessoa_servico`(`idt_pa_pessoa`, `idt_servico`);


ALTER TABLE `db_pir_grc`.`grc_atendimento_pa_pessoa_servico` DROP INDEX `iu_grc_atendimento_pa_pessoa_servico`,
 ADD UNIQUE INDEX `iu_grc_atendimento_pa_pessoa_servico` USING BTREE(`idt_pa_pessoa`, `idt_servico`);




ALTER TABLE `db_pir_grc`.`grc_atendimento_pa_pessoa_servico` ADD CONSTRAINT `FK_grc_atendimento_pa_pessoa_servico_1` FOREIGN KEY `FK_grc_atendimento_pa_pessoa_servico_1` (`idt_pa_pessoa`)
    REFERENCES `grc_atendimento_pa_pessoa` (`idt`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT;


ALTER TABLE `db_pir_grc`.`grc_atendimento_pa_pessoa_servico` 
ADD CONSTRAINT `FK_grc_atendimento_pa_pessoa_servico_4` 
FOREIGN KEY `FK_grc_atendimento_pa_pessoa_servico_4` (`idt_servico_duracao`)
    REFERENCES `grc_atendimento_especialidade_duracao` (`idt`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT;	
	
--- grc_agenda_oarametro_servico (tem idt_ponto_atendimento) - criar costraint

ALTER TABLE `grc_agenda_parametro_servico`
ADD INDEX `FK_grc_agenda_parametro_servico_3` (`idt_ponto_atendimento`) USING BTREE ;

ALTER TABLE `grc_agenda_parametro_servico`
MODIFY COLUMN `idt_ponto_atendimento`  int(10) NOT NULL AFTER `idt_parametro`,
DROP INDEX `FK_grc_agenda_parametro_servico_3`,
ADD INDEX `FK_grc_agenda_parametro_servico_3` (`idt_ponto_atendimento`) USING BTREE ;

ALTER TABLE `grc_agenda_parametro_servico` ADD CONSTRAINT `FK_grc_agenda_parametro_servico_3` FOREIGN KEY (`idt_ponto_atendimento`) REFERENCES `db_pir`.`sca_organizacao_secao` (`idt`) ON DELETE RESTRICT ON UPDATE RESTRICT;


ALTER TABLE `grc_agenda_parametro_servico` ADD CONSTRAINT `FK_grc_agenda_parametro_servico_3` FOREIGN KEY (`idt_ponto_atendimento`) REFERENCES `db_pir`.`sca_organizacao_secao` (`idt`) ON DELETE RESTRICT ON UPDATE RESTRICT;

-- 25-05-2017

ALTER TABLE `db_pir_grc`.`grc_atendimento_pa_pessoa` ADD COLUMN `pode_feriado` CHAR(1) DEFAULT 'N' AFTER `idt_acao`;

-- mes 06

-- 2017-06-07

ALTER TABLE `db_pir_grc`.`grc_atendimento_pa_pessoa` ADD COLUMN `ativo_pa` CHAR(1) DEFAULT 'N' AFTER `pode_feriado`;

-- insert no plu_config - Fazer e colocar aqui

INSERT INTO `db_pir_grc`.`plu_config` (`variavel`, `descricao`, `valor`, `extra`, `js`, `classificacao`) VALUES ('ParametroPresoAgenda', 'Minutos para LIBERAR Agenda Presa para Marcação Desmarcação', '60', NULL, 'N', NULL);

-- 17/06/2017

-- producao
-- sala
-- Desenvolvimento
-- homologacao