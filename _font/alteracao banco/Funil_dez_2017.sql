-- 03/12/2017

CREATE TABLE `db_pir_grc`.`grc_funil_historico_nota_clessificacao` (
  `idt` INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  `identificacao` VARCHAR(255) NOT NULL,
  `datahora` DATETIME NOT NULL,
  `ano` VARCHAR(4) NOT NULL,
  `nota` NUMERIC(15,2) NOT NULL,
  `comentario` VARCHAR(255),
  PRIMARY KEY (`idt`),
  UNIQUE INDEX `iu_grc_funil_historico_nota_clessificacao`(`identificacao`, `ano`, `datahora`)
)
ENGINE = InnoDB;


ALTER TABLE `db_pir_grc`.`grc_funil_historico_nota_clessificacao` RENAME TO `db_pir_grc`.`grc_funil_historico_nota_classificacao`
, DROP INDEX `iu_grc_funil_historico_nota_clessificacao`,
 ADD UNIQUE INDEX `iu_grc_funil_historico_nota_classificacao` USING BTREE(`identificacao`, `ano`, `datahora`);


insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_relatorio_agendamento','Relatório de Agendamento','40.38','S','S','listar','listar');
insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_relatorio_agendamento') as id_funcao
from plu_direito where cod_direito in ('con','alt','inc','exc');
insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_relatorio_agendamento');
