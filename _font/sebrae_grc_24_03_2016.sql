use db_pir_grc;

-- 24 03 2016 - homologação

CREATE TABLE `db_pir_grc`.`grc_programa` (
  `idt` INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  `codigo` VARCHAR(45) NOT NULL,
  `descricao` VARCHAR(120) NOT NULL,
  `ativo` VARCHAR(1),
  `detalhe` TEXT,
  PRIMARY KEY (`idt`),
  UNIQUE INDEX `iu_grc_programa`(`codigo`)
)
ENGINE = InnoDB;


ALTER TABLE `db_pir_grc`.`grc_programa` ADD COLUMN `sigla` VARCHAR(45) NOT NULL AFTER `detalhe`;


insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_programa','Programa','01.16','S','S','listar','listar');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_programa') as id_funcao
from plu_direito where cod_direito in ('alt','con','exc','inc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_programa');

ALTER TABLE `db_pir_grc`.`grc_produto` ADD COLUMN `idt_programa_grc` INTEGER UNSIGNED AFTER `necessita_credenciado`,
 ADD CONSTRAINT `FK_grc_produto_14` FOREIGN KEY `FK_grc_produto_14` (`idt_programa_grc`)
    REFERENCES `grc_programa` (`idt`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE;

ALTER TABLE `db_pir_grc`.`grc_produto` ADD COLUMN `titulo_comercial` VARCHAR(255) NOT NULL AFTER `idt_programa_grc`;


ALTER TABLE `db_pir_grc`.`grc_formulario` MODIFY COLUMN `ativo` VARCHAR(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT 'S';

-- producao
-- esmeraldo
-- sala
