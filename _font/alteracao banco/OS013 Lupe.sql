-- esmeraldo
-- treina
-- producao

-- 12-06-2017

ALTER TABLE `db_pir_grc`.`grc_avaliacao` ADD COLUMN `idt_evento` INTEGER UNSIGNED AFTER `idt_guia`,
 ADD CONSTRAINT `FK_grc_avaliacao_11` FOREIGN KEY `FK_grc_avaliacao_11` (`idt_evento`)
    REFERENCES `grc_evento` (`idt`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT;

insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('conteudo_avaliacao_estrelinhas.php','Avaliação Estrelinhas','86.01','S','S','janela','janela');
insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'conteudo_avaliacao_estrelinhas.php') as id_funcao
from plu_direito where cod_direito in ('con','alt','inc','exc');
insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('conteudo_avaliacao_estrelinhas.php');

ALTER TABLE `db_pir_grc`.`grc_avaliacao` ADD COLUMN `cpf` VARCHAR(45) AFTER `idt_evento`;

-- desenvolve

-- 10-10-2017

ALTER TABLE `db_pir_grc`.`grc_evento` ADD COLUMN `peca_padrao` CHAR(1) NOT NULL DEFAULT 'S' AFTER `conteudo_programatico`,
 ADD COLUMN `idr_peca_evento` INTEGER UNSIGNED AFTER `peca_padrao`,
 ADD CONSTRAINT `FK_grc_evento_37` FOREIGN KEY `FK_grc_evento_37` (`idr_peca_evento`)
    REFERENCES `grc_agenda_emailsms` (`idt`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT;


ALTER TABLE `db_pir_grc`.`grc_agenda_emailsms` ADD COLUMN `proprietario` VARCHAR(45) NOT NULL DEFAULT 'UAIN' AFTER `classificacao`,
 ADD COLUMN `padrao` CHAR(1) NOT NULL DEFAULT 'N' AFTER `proprietario`;

ALTER TABLE `db_pir_grc`.`grc_agenda_emailsms` ADD COLUMN `data_responsavel` DATETIME NOT NULL AFTER `padrao`,
 ADD COLUMN `idt_responsavel` INTEGER UNSIGNED NOT NULL AFTER `data_responsavel`;


ALTER TABLE `db_pir_grc`.`grc_evento`
 DROP FOREIGN KEY `FK_grc_evento_37`;

ALTER TABLE `db_pir_grc`.`grc_evento` CHANGE COLUMN `idr_peca_evento` `idt_peca_evento` INT(10) UNSIGNED DEFAULT NULL,
 DROP INDEX `FK_grc_evento_37`,
 ADD INDEX `FK_grc_evento_37` USING BTREE(`idt_peca_evento`),
 ADD CONSTRAINT `FK_grc_evento_37` FOREIGN KEY `FK_grc_evento_37` (`idt_peca_evento`)
    REFERENCES `grc_agenda_emailsms` (`idt`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT;

-- homologacao
-- sala
