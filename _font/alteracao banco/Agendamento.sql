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

-- 2017 -  07 - 04

ALTER TABLE `db_pir_grc`.`grc_atendimento_especialidade` ADD COLUMN `idt_email_confirmacao` INTEGER UNSIGNED AFTER `idt_acao`,
 ADD CONSTRAINT `FK_grc_atendimento_especialidade_2` FOREIGN KEY `FK_grc_atendimento_especialidade_2` (`idt_email_confirmacao`)
    REFERENCES `grc_agenda_emailsms` (`idt`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT;
	
	ALTER TABLE `db_pir_grc`.`grc_atendimento_agenda` ADD INDEX `Index_9`(`idt_consultor`, `origem`, `data`, `idt_ponto_atendimento`);



-- 11-07-2017

CREATE TABLE `db_pir_grc`.`grc_agenda_maturidade` (
  `idt` INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  `codigo` VARCHAR(45) NOT NULL,
  `descricao` VARCHAR(120) NOT NULL,
  `ativo` CHAR(1) NOT NULL DEFAULT 'S',
  `detalhe` TEXT,
  PRIMARY KEY (`idt`),
  UNIQUE INDEX `iu_grc_agenda_maturidade`(`codigo`)
)
ENGINE = InnoDB;

insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_agenda_maturidade','Maturidade Servico Agenda','05.90.95','S','S','listar','listar');
insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_agenda_maturidade') as id_funcao
from plu_direito where cod_direito in ('con','alt','inc','exc');
insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_agenda_maturidade');


ALTER TABLE `db_pir_grc`.`grc_atendimento_especialidade` ADD COLUMN `idt_maturidade` INTEGER UNSIGNED AFTER `idt_email_confirmacao`;
ALTER TABLE `db_pir_grc`.`grc_atendimento_especialidade` ADD CONSTRAINT `FK_grc_atendimento_especialidade_3` FOREIGN KEY `FK_grc_atendimento_especialidade_3` (`idt_maturidade`)
    REFERENCES `grc_agenda_maturidade` (`idt`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT;
	
	ALTER TABLE `db_pir_grc`.`grc_atendimento_especialidade` ADD COLUMN `idt_tema_subtema` INTEGER UNSIGNED AFTER `idt_maturidade`,
 ADD CONSTRAINT `FK_grc_atendimento_especialidade_4` FOREIGN KEY `FK_grc_atendimento_especialidade_4` (`idt_tema_subtema`)
    REFERENCES `grc_tema_subtema` (`idt`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT;

-- especialidade porte


CREATE TABLE `grc_atendimento_especialidade_porte` (
  `idt` int(10) unsigned NOT NULL,
  `idt_porte` int(10) unsigned NOT NULL,
  PRIMARY KEY (`idt`,`idt_porte`),
  KEY `fk_grc_atendimento_especialidade_porte_2` (`idt_porte`),
  CONSTRAINT `fk_grc_atendimento_especialidade_porte_1` FOREIGN KEY (`idt`) REFERENCES `grc_atendimento_especialidade` (`idt`) ON DELETE CASCADE,
  CONSTRAINT `fk_grc_atendimento_especialidade_porte_2` FOREIGN KEY (`idt_porte`) REFERENCES `db_pir_gec`.`gec_organizacao_porte` (`idt`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
 
insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_atendimento_especialidade_porte','Portes do Servico Agenda','05.90.03.07','N','N','listar','listar');
insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_atendimento_especialidade_porte') as id_funcao
from plu_direito where cod_direito in ('con','alt','inc','exc');
insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_atendimento_especialidade_porte');


ALTER TABLE `db_pir_grc`.`grc_atendimento_especialidade` ADD COLUMN `idt_publico_alvo` INTEGER UNSIGNED AFTER `idt_tema_subtema`;
ALTER TABLE `db_pir_grc`.`grc_atendimento_especialidade` ADD CONSTRAINT `FK_grc_atendimento_especialidade_5` FOREIGN KEY `FK_grc_atendimento_especialidade_5` (`idt_publico_alvo`)
    REFERENCES `grc_publico_alvo` (`idt`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT;


-- especialidade publico alvo


CREATE TABLE `grc_atendimento_especialidade_publico_alvo` (
  `idt` int(10) unsigned NOT NULL,
  `idt_publico_alvo` int(10) unsigned NOT NULL,
  PRIMARY KEY (`idt`,`idt_publico_alvo`),
  KEY `fk_grc_atendimento_especialidade_publico_alvo_2` (`idt_publico_alvo`),
  CONSTRAINT `fk_grc_atendimento_especialidade_publico_alvo_1` FOREIGN KEY (`idt`) REFERENCES `grc_atendimento_especialidade` (`idt`) ON DELETE CASCADE,
  CONSTRAINT `fk_grc_atendimento_especialidade_publico_alvo_2` FOREIGN KEY (`idt_publico_alvo`) REFERENCES `grc_publico_alvo` (`idt`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_atendimento_especialidade_publico_alvo','Puplico Alvo do Servico Agenda','05.90.03.09','N','N','listar','listar');
insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_atendimento_especialidade_publico_alvo') as id_funcao
from plu_direito where cod_direito in ('con','alt','inc','exc');
insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_atendimento_especialidade_publico_alvo');



ALTER TABLE `db_pir_grc`.`grc_atendimento_especialidade_publico_alvo`
 DROP FOREIGN KEY `fk_grc_atendimento_especialidade_publico_alvo_2`;

ALTER TABLE `db_pir_grc`.`grc_atendimento_especialidade_publico_alvo` CHANGE COLUMN `idt_publico_alvo` `idt_publico_alvo_outro` INT(10) UNSIGNED NOT NULL,
 DROP PRIMARY KEY,
 ADD PRIMARY KEY  USING BTREE(`idt`, `idt_publico_alvo_outro`),
 DROP INDEX `fk_grc_atendimento_especialidade_publico_alvo_2`,
 ADD INDEX `fk_grc_atendimento_especialidade_publico_alvo_2` USING BTREE(`idt_publico_alvo_outro`),
 ADD CONSTRAINT `fk_grc_atendimento_especialidade_publico_alvo_2` FOREIGN KEY `fk_grc_atendimento_especialidade_publico_alvo_2` (`idt_publico_alvo_outro`)
    REFERENCES `grc_publico_alvo` (`idt`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT;


ALTER TABLE `db_pir_grc`.`grc_atendimento_especialidade` ADD COLUMN `despublica` CHAR(1) DEFAULT 'N' AFTER `idt_publico_alvo`,
 ADD COLUMN `data_despublicar` DATETIME AFTER `despublica`;


ALTER TABLE `db_pir_grc`.`grc_atendimento_especialidade` MODIFY COLUMN `data_despublicar` DATE DEFAULT NULL,
 ADD COLUMN `hora_despublicar` CHAR(5) AFTER `data_despublicar`;



-- especialidade produto

CREATE TABLE `grc_atendimento_especialidade_produto` (
  `idt` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idt_atendimento_especialidade` int(10) unsigned NOT NULL,
  `idt_produto` int(10) unsigned NOT NULL,
  `observacao` varchar(255) DEFAULT NULL,
  `data_registro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `idt_responsavel` int(11) NOT NULL,
  PRIMARY KEY (`idt`),
  UNIQUE KEY `iu_grc_atendimento_especialidade_produto` (`idt_atendimento_especialidade`,`idt_produto`) USING BTREE,
  KEY `FK_grc_atendimento_especialidade_produto_2` (`idt_responsavel`) USING BTREE,
  KEY `FK_grc_atendimento_especialidade_produto_3` (`idt_produto`) USING BTREE,
  CONSTRAINT `FK_grc_atendimento_especialidade_produto_1` FOREIGN KEY (`idt_atendimento_especialidade`) REFERENCES `grc_atendimento_especialidade` (`idt`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_grc_atendimento_especialidade_produto_2` FOREIGN KEY (`idt_responsavel`) REFERENCES `plu_usuario` (`id_usuario`) ON UPDATE CASCADE,
  CONSTRAINT `FK_grc_atendimento_especialidade_produto_3` FOREIGN KEY (`idt_produto`) REFERENCES `grc_produto` (`idt`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_atendimento_especialidade_produto','Produtos do Serviço','05.90.03.11','N','N','listar','listar');
insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_atendimento_especialidade_produto') as id_funcao
from plu_direito where cod_direito in ('con','alt','inc','exc');
insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_atendimento_especialidade_produto');


ALTER TABLE `db_pir_grc`.`grc_atendimento_especialidade` ADD COLUMN `palavras_chave` VARCHAR(5000) AFTER `hora_despublicar`;

-- Desenvolvimento
-- Homologacao
-- sala
