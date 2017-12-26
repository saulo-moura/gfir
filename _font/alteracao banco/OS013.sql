-- esmeraldo
-- treina
-- producao

-- 02/05/2017

ALTER TABLE `grc_evento_publicacao`
MODIFY COLUMN `tipo_acao`  char(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL AFTER `idt_evento`,
ADD COLUMN `situacao`  char(2) NOT NULL AFTER `tipo_acao`;

ALTER TABLE `grc_evento_publicacao`
ADD COLUMN `idt_usuario_situacao`  int(11) NULL DEFAULT NULL AFTER `data_publicacao_ate`,
ADD COLUMN `data_situacao`  datetime NULL DEFAULT NULL AFTER `idt_usuario_situacao`;

ALTER TABLE `grc_evento_publicacao` ADD CONSTRAINT `FK_grc_evento_publicacao_3` FOREIGN KEY (`idt_usuario_situacao`) REFERENCES `plu_usuario` (`id_usuario`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `grc_atendimento_pendencia`
ADD COLUMN `idt_evento_publicacao`  int(10) UNSIGNED NULL AFTER `idt_evento`;

ALTER TABLE `grc_atendimento_pendencia` ADD CONSTRAINT `FK_grc_atendimento_pendencia_14` FOREIGN KEY (`idt_evento_publicacao`) REFERENCES `grc_evento_publicacao` (`idt`) ON DELETE RESTRICT ON UPDATE RESTRICT;

-- 04/05/2017 LUPE

/*
-- Executado em Produção

CREATE TABLE `db_pir_grc`.`grc_evento_publicacao_canal` (
  `idt` INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  `idt_evento_publicacao` INTEGER UNSIGNED NOT NULL,
  `idt_canal_inscricao` INTEGER UNSIGNED NOT NULL,
  `quantidade_inscrito` INTEGER UNSIGNED NOT NULL,
  PRIMARY KEY (`idt`),
  UNIQUE INDEX `iu_grc_evento_publicacao_canal`(`idt_evento_publicacao`, `idt_canal_inscricao`),
  CONSTRAINT `FK_grc_evento_publicacao_canal_1` FOREIGN KEY `FK_grc_evento_publicacao_canal_1` (`idt_evento_publicacao`)
    REFERENCES `grc_evento_publicacao` (`idt`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT
)
ENGINE = InnoDB;

CREATE TABLE `db_pir_grc`.`grc_evento_canal_inscricao` (
  `idt` INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  `codigo` VARCHAR(45) NOT NULL,
  `descricao` VARCHAR(120) NOT NULL,
  `detalhe` text,
  `ativo` CHAR(1) NOT NULL DEFAULT 'S',
  PRIMARY KEY (`idt`),
  UNIQUE INDEX `iu_grc_evento_canal_inscricao`(`codigo`)
)
ENGINE = InnoDB;

ALTER TABLE `db_pir_grc`.`grc_evento_publicacao_canal` ADD CONSTRAINT `FK_grc_evento_publicacao_canal_2` FOREIGN KEY `FK_grc_evento_publicacao_canal_2` (`idt_canal_inscricao`)
    REFERENCES `grc_evento_canal_inscricao` (`idt`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT;


CREATE TABLE `db_pir_grc`.`grc_evento_grupo` (
  `idt` INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  `codigo` VARCHAR(45) NOT NULL,
  `descricao` VARCHAR(120) NOT NULL,
  `detalhe` text,
  `ativo` CHAR(1) NOT NULL DEFAULT 'S',
  PRIMARY KEY (`idt`),
  UNIQUE INDEX `iu_grc_evento_grupo`(`codigo`)
)
ENGINE = InnoDB;


CREATE TABLE `db_pir_grc`.`grc_evento_publicacao_brinde` (
  `idt` INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  `idt_evento_publicacao` INTEGER UNSIGNED NOT NULL,
  `idt_brinde` INTEGER UNSIGNED NOT NULL,

  PRIMARY KEY (`idt`),
  UNIQUE INDEX `iu_grc_evento_publicacao_brinde`(`idt_evento_publicacao`, `idt_brinde`),
  CONSTRAINT `FK_grc_evento_publicacao_brinde_1` FOREIGN KEY `FK_grc_evento_publicacao_brinde_1` (`idt_evento_publicacao`)
    REFERENCES `grc_evento_publicacao` (`idt`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT
)
ENGINE = InnoDB;
ALTER TABLE `db_pir_grc`.`grc_evento_publicacao_brinde` ADD CONSTRAINT `FK_grc_evento_publicacao_brinde_2` FOREIGN KEY `FK_grc_evento_publicacao_brinde_2` (`idt_brinde`)
    REFERENCES `grc_evento_publicacao_brinde` (`idt`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT;

CREATE TABLE `db_pir_grc`.`grc_evento_publicacao_publico_alvo` (
  `idt` INTEGER UNSIGNED NOT NULL,
  `idt_publico_alvo` INTEGER UNSIGNED NOT NULL,
  UNIQUE INDEX `iu_grc_evento_publicacao_publico_alvo`(`idt`, `idt_publico_alvo`),
  CONSTRAINT `FK_grc_evento_publicacao_publico_alvo_1` FOREIGN KEY `FK_grc_evento_publicacao_publico_alvo_1` (`idt_publico_alvo`)
    REFERENCES `grc_produto_publico_alvo` (`idt`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT,
  CONSTRAINT `FK_grc_evento_publicacao_publico_alvo_2` FOREIGN KEY `FK_grc_evento_publicacao_publico_alvo_2` (`idt`)
    REFERENCES `grc_evento_publicacao` (`idt`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT
)
ENGINE = InnoDB;



CREATE TABLE `db_pir_grc`.`grc_evento_tipo_voucher` (
  `idt` INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  `codigo` VARCHAR(45) NOT NULL,
  `descricao` VARCHAR(120) NOT NULL,
  `detalhe` text,
  `ativo` CHAR(1) NOT NULL DEFAULT 'S',
  PRIMARY KEY (`idt`),
  UNIQUE INDEX `iu_grc_evento_tipo_voucher`(`codigo`)
)
ENGINE = InnoDB;
*/

ALTER TABLE `db_pir_grc`.`grc_evento_publicacao` ADD COLUMN `data_hora_fim_inscricao_ec` DATETIME AFTER `data_situacao`,
 ADD COLUMN `restrito` CHAR(1) DEFAULT 'N' AFTER `data_hora_fim_inscricao_ec`,
 ADD COLUMN `desconto_porte` CHAR(1) DEFAULT 'N' AFTER `restrito`,
 ADD COLUMN `assento_marcado` CHAR(1) DEFAULT 'N' AFTER `desconto_porte`,
 ADD COLUMN `tag_busca` VARCHAR(5000) AFTER `assento_marcado`,
 ADD COLUMN `gerador_voucher` CHAR(1) DEFAULT 'N' AFTER `tag_busca`,
 ADD COLUMN `publico_ab_fe` CHAR(1) DEFAULT 'A' AFTER `gerador_voucher`,
 ADD COLUMN `idt_tipo_voucher` INTEGER UNSIGNED AFTER `publico_ab_fe`,
 ADD COLUMN `quantidade_voucher` INTEGER UNSIGNED AFTER `idt_tipo_voucher`,
 ADD COLUMN `perc_desconto_voucher` NUMERIC(6,2) AFTER `quantidade_voucher`,
 ADD COLUMN `data_validade_voucher` DATETIME AFTER `perc_desconto_voucher`,
 ADD COLUMN `cupon_desconto` CHAR(45) DEFAULT 'N' AFTER `data_validade_voucher`,
 ADD COLUMN `palavra_chave_cupon` VARCHAR(45) AFTER `cupon_desconto`,
 ADD COLUMN `data_validade_cupon` DATETIME AFTER `palavra_chave_cupon`,
 ADD COLUMN `perc_desconto_cupon` NUMERIC(6,2) AFTER `data_validade_cupon`;
 
ALTER TABLE `db_pir_grc`.`grc_evento_publicacao` ADD CONSTRAINT `FK_grc_evento_publicacao_4` FOREIGN KEY `FK_grc_evento_publicacao_4` (`idt_tipo_voucher`)
    REFERENCES `grc_evento_tipo_voucher` (`idt`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT;


CREATE TABLE `db_pir_grc`.`grc_evento_local_assento` (
  `idt` INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  `codigo` VARCHAR(45) NOT NULL,
  `descricao` VARCHAR(120) NOT NULL,
  `detalhe` text,
  `ativo` CHAR(1) NOT NULL DEFAULT 'S',
  PRIMARY KEY (`idt`),
  UNIQUE INDEX `iu_grc_evento_local_assento`(`codigo`)
)
ENGINE = InnoDB;

CREATE TABLE `db_pir_grc`.`grc_evento_local_assento_categoria` (
  `idt` INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  `codigo` VARCHAR(45) NOT NULL,
  `descricao` VARCHAR(120) NOT NULL,
  `detalhe` text,
  `ativo` CHAR(1) NOT NULL DEFAULT 'S',
  PRIMARY KEY (`idt`),
  UNIQUE INDEX `iu_grc_evento_local_assento_categoria`(`codigo`)
)
ENGINE = InnoDB;


CREATE TABLE `db_pir_grc`.`grc_evento_brinde` (
  `idt` INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  `codigo` VARCHAR(45) NOT NULL,
  `descricao` VARCHAR(120) NOT NULL,
  `detalhe` text,
  `ativo` CHAR(1) NOT NULL DEFAULT 'S',
  PRIMARY KEY (`idt`),
  UNIQUE INDEX `iu_grc_evento_brinde`(`codigo`)
)
ENGINE = InnoDB;

-- NOMENCLATURAS 02.03.82
insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_evento_canal_inscricao','Canal de Inscrição de Evento','02.03.82','S','S','listar','listar');
insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_evento_canal_inscricao') as id_funcao
from plu_direito where cod_direito in ('con','alt','inc','exc');
insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_evento_canal_inscricao');

insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_evento_grupo','Grupo de Evento','02.03.83','S','S','listar','listar');
insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_evento_grupo') as id_funcao
from plu_direito where cod_direito in ('con','alt','inc','exc');
insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_evento_grupo');

insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_evento_tipo_voucher','Tipo de Voucher','02.03.84','S','S','listar','listar');
insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_evento_tipo_voucher') as id_funcao
from plu_direito where cod_direito in ('con','alt','inc','exc');
insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_evento_tipo_voucher');

insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_evento_local_assento_categoria','Categoria do Assento','02.03.85','S','S','listar','listar');
insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_evento_local_assento_categoria') as id_funcao
from plu_direito where cod_direito in ('con','alt','inc','exc');
insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_evento_local_assento_categoria');



insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_evento_brinde','Brinbes para Eventos','02.03.86','S','S','listar','listar');
insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_evento_brinde') as id_funcao
from plu_direito where cod_direito in ('con','alt','inc','exc');
insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_evento_brinde');



-- PUBLICACAO    02.03.54

insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_evento_publicacao_canal','Canal de Inscrição','02.03.54.01','S','S','listar','listar');
insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_evento_publicacao_canal') as id_funcao
from plu_direito where cod_direito in ('con','alt','inc','exc');
insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_evento_publicacao_canal');




insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_evento_publicacao_brinde','Brinde do Evento','02.03.54.03','S','S','listar','listar');
insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_evento_publicacao_brinde') as id_funcao
from plu_direito where cod_direito in ('con','alt','inc','exc');
insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_evento_publicacao_brinde');


insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_evento_publicacao_publico_alvo','Público Alvo','02.03.54.05','S','S','listar','listar');
insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_evento_publicacao_publico_alvo') as id_funcao
from plu_direito where cod_direito in ('con','alt','inc','exc');
insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_evento_publicacao_publico_alvo');



-- LOCAL    02.03.39



insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_evento_local_assento','Assentos do Local','02.03.39.03','S','S','listar','listar');
insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_evento_local_assento') as id_funcao
from plu_direito where cod_direito in ('con','alt','inc','exc');
insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_evento_local_assento');


ALTER TABLE `db_pir_grc`.`grc_evento_publicacao_publico_alvo`
 DROP FOREIGN KEY `FK_grc_evento_publicacao_publico_alvo_1`;

ALTER TABLE `db_pir_grc`.`grc_evento_publicacao_publico_alvo` ADD CONSTRAINT `FK_grc_evento_publicacao_publico_alvo_1` FOREIGN KEY `FK_grc_evento_publicacao_publico_alvo_1` (`idt_publico_alvo`)
    REFERENCES `grc_publico_alvo` (`idt`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT;
ALTER TABLE `db_pir_grc`.`grc_evento_publicacao` ADD COLUMN `idt_grupo` INTEGER UNSIGNED AFTER `perc_desconto_cupon`,
 ADD CONSTRAINT `FK_grc_evento_publicacao_5` FOREIGN KEY `FK_grc_evento_publicacao_5` (`idt_grupo`)
    REFERENCES `grc_evento_grupo` (`idt`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT;
ALTER TABLE `db_pir_grc`.`grc_evento_publicacao` ADD COLUMN `assento_mapa` VARCHAR(120) AFTER `idt_grupo`;
ALTER TABLE `db_pir_grc`.`grc_evento_publicacao` ADD COLUMN `qtd_linha` INTEGER UNSIGNED AFTER `assento_mapa`,
 ADD COLUMN `qtd_coluna` INTEGER UNSIGNED AFTER `qtd_linha`;

-- esmeraldo, ver esse relacionamento pois aqui no desenvolvimento estava sem ele -- cuidado na produção

ALTER TABLE `db_pir_grc`.`grc_evento_local_pa_agenda` ADD CONSTRAINT `FK_grc_evento_local_pa_agenda_1` FOREIGN KEY `FK_grc_evento_local_pa_agenda_1` (`idt_local_pa`)
    REFERENCES `grc_evento_local_pa` (`idt`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT;
	
	
CREATE TABLE `db_pir_grc`.`grc_evento_local_pa_mapa` (
  `idt` INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  `idt_local_pa` INTEGER UNSIGNED NOT NULL,
  `codigo` VARCHAR(45) NOT NULL,
  `descricao` VARCHAR(120) NOT NULL,
  `ativo` CHAR(1) NOT NULL DEFAULT 'S',
  `detalhe` TEXT,
  `assento_mapa` VARCHAR(255),
  PRIMARY KEY (`idt`),
  UNIQUE INDEX `iu_grc_evento_local_pa_mapa`(`idt_local_pa`, `codigo`),
  CONSTRAINT `FK_grc_evento_local_pa_mapa_1` FOREIGN KEY `FK_grc_evento_local_pa_mapa_1` (`idt_local_pa`)
    REFERENCES `grc_evento_local_pa` (`idt`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT
)
ENGINE = InnoDB;
	
insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_evento_local_pa_mapa','Mapa dos Assentos do Local','02.03.39.05','S','S','listar','listar');
insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_evento_local_pa_mapa') as id_funcao
from plu_direito where cod_direito in ('con','alt','inc','exc');
insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_evento_local_pa_mapa');

CREATE TABLE `db_pir_grc`.`grc_evento_local_pa_mapa_assento` (
  `idt` INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  `idt_local_pa_mapa` INTEGER UNSIGNED NOT NULL,
  `codigo` VARCHAR(45) NOT NULL,
  `descricao` VARCHAR(120),
  `ativo` CHAR(1) NOT NULL DEFAULT 'S',
  `detalhe` TEXT,
  `linha` INTEGER UNSIGNED,
  `coluna` INTEGER UNSIGNED,
  `coordenada` VARCHAR(255),
  `idt_tipo_assento` INTEGER UNSIGNED,
  PRIMARY KEY (`idt`),
  UNIQUE INDEX `iu_grc_evento_local_pa_mapa_assento`(`idt_local_pa_mapa`, `codigo`),
  CONSTRAINT `FK_grc_evento_local_pa_mapa_assento_1` FOREIGN KEY `FK_grc_evento_local_pa_mapa_assento_1` (`idt_local_pa_mapa`)
    REFERENCES `grc_evento_local_pa_mapa` (`idt`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT
)
ENGINE = InnoDB;


insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_evento_local_pa_mapa_assento','Assentos do Local','02.03.39.05.03','S','S','listar','listar');
insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_evento_local_pa_mapa_assento') as id_funcao
from plu_direito where cod_direito in ('con','alt','inc','exc');
insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_evento_local_pa_mapa_assento');

ALTER TABLE `db_pir_grc`.`grc_evento_local_pa_mapa_assento` ADD COLUMN `mapa_assento` VARCHAR(120) AFTER `idt_tipo_assento`;


CREATE TABLE `db_pir_grc`.`grc_evento_local_pa_tipo_assento` (
  `idt` INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  `codigo` VARCHAR(45) NOT NULL,
  `descricao` VARCHAR(45) NOT NULL,
  `detalhe` TEXT,
  `ativo` CHAR(1) NOT NULL DEFAULT 'S',
  PRIMARY KEY (`idt`),
  UNIQUE INDEX `iu_grc_evento_local_pa_tipo_assento`(`codigo`)
)
ENGINE = InnoDB;

insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_evento_local_pa_tipo_assento','Tipo de Assento do Local','02.03.87','S','S','listar','listar');
insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_evento_local_pa_tipo_assento') as id_funcao
from plu_direito where cod_direito in ('con','alt','inc','exc');
insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_evento_local_pa_tipo_assento');

ALTER TABLE `db_pir_grc`.`grc_evento_local_pa_mapa_assento` ADD CONSTRAINT `FK_grc_evento_local_pa_mapa_assento_2` FOREIGN KEY `FK_grc_evento_local_pa_mapa_assento_2` (`idt_tipo_assento`)
    REFERENCES `grc_evento_local_pa_tipo_assento` (`idt`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT;
--

CREATE TABLE `db_pir_grc`.`grc_evento_publicacao_porte` (
  `idt` INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  `idt_evento_publicacao` INTEGER UNSIGNED NOT NULL,
  `idt_porte` INTEGER UNSIGNED NOT NULL,
  `percrntual_desconto` NUMERIC(6,2) NOT NULL,
  PRIMARY KEY (`idt`),
  UNIQUE INDEX `iu_grc_evento_publicacao_porte`(`idt_evento_publicacao`, `idt_porte`),
  CONSTRAINT `FK_grc_evento_publicacao_porte_1` FOREIGN KEY `FK_grc_evento_publicacao_porte_1` (`idt_evento_publicacao`)
    REFERENCES `grc_evento_publicacao` (`idt`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT
)
ENGINE = InnoDB;


insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_evento_publicacao_porte','Porte','02.03.54.07','S','S','listar','listar');
insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_evento_publicacao_porte') as id_funcao
from plu_direito where cod_direito in ('con','alt','inc','exc');
insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_evento_publicacao_porte');

ALTER TABLE `db_pir_grc`.`grc_evento_publicacao_porte` CHANGE COLUMN `percrntual_desconto` `percentual_desconto` DECIMAL(6,2) NOT NULL;

-- 09/05/2017

INSERT INTO `db_pir_grc`.`grc_evento_tipo_voucher` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('1', 'A', 'Voucher criado a partir da aquisição de uma solução (compra no módulo de e-commerce)', 'Voucher A\r\n\r\n -Voucher criado a partir da aquisição de uma solução (compra no módulo de e-commerce);\r\n\r\na.Atende a Inscrição de uma empresa com dois participantes.\r\nExemplo: na compra de uma solução “Na Medida” o comprador tem direito de levar mais um participante da sua escolha – \r\nVoucher 100% desconto.\r\n\r\nSe o cliente optar por levar um outro participante é gerado um voucher com data de validade e reservada uma vaga do evento para a mesma empresa. \r\n\r\nQuem utilizar este voucher deve ter seu cadastro de Pessoa Física vinculado à empresa de quem gerou o voucher;', 'S');
INSERT INTO `db_pir_grc`.`grc_evento_tipo_voucher` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('2', 'B', 'Voucher criado por vaga de evento;', 'Voucher B\r\n\r\nAtende a: Venda de eventos para cliente específico. \r\n\r\nExemplo: \r\n\r\nO gestor cria uma consultoria de 1 vaga e gera um voucher de 0% desconto.\r\n\r\nAssim, somente o detentor do voucher terá a possibilidade de inscrição neste evento pagando o valor total (neste exemplo);', 'S');
INSERT INTO `db_pir_grc`.`grc_evento_tipo_voucher` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('3', 'C', 'Cancelamento - Deve ser aceito em todos os eventos do Sebrae, exceto nos eventos parametrizáveis para não recebimento.', 'Voucher C\r\nCancelamento - Deve ser aceito em todos os eventos do Sebrae, exceto nos eventos parametrizáveis para não recebimento. \r\n\r\nExemplo: \r\nUm cliente compra um evento e este é cancelado.\r\nO cliente então recebe um voucher correspondente ao valor do evento cancelado.\r\n\r\nRestrições:\r\n1 - Este voucher somente poderá ser utilizado em eventos de mesmo valor;\r\n2 - O cliente pode optar por trocar este voucher pelo dinheiro de volta, somente no valor total;\r\n3 - Este voucher terá validade. Após vencimento, será gerado a devolução a devolução do valor total para o cliente.', 'S');
INSERT INTO `db_pir_grc`.`grc_evento_tipo_voucher` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('4', 'D', 'Voucher ligado a um produto específico do Sebrae Bahia - MEDE.', 'Voucher D\r\nVoucher ligado a um produto específico do Sebrae Bahia - MEDE.\r\n\r\nRestrições:\r\n1 - O cliente só pode comprar um produto dessa natureza utilizando esse voucher; \r\n2 - Este voucher terá validade. Após vencimento, gerar devolução do valor total da COMPRA para o cliente;\r\n3 - Este voucher dá direito ao cliente de acessar qualquer evento com este mesmo produto independentemente do valor atual do evento.\r\n4 - Este voucher também poderá ser trocado, a qualquer tempo durante sua validade, apenas pelo valor total da COMPRA inicialmente feita pelo cliente.', 'S');
INSERT INTO `db_pir_grc`.`grc_evento_tipo_voucher` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('5', 'E', 'Voucher de indicação para amigo', 'Voucher E – Voucher de indicação para amigo. \r\n\r\nO cliente terá a opção de indicar o evento para um amigo por e-mail, que deverá realizar sua inscrição informando o número do voucher gerado pelo sistema.\r\nCaso a indicação finalize a inscrição, o primeiro cliente terá XX% de desconto na próxima inscrição que realizar em eventos do Sebrae.', 'S');

INSERT INTO `db_pir_grc`.`grc_evento_grupo` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`) VALUES ('1', '01', 'Semana do Direito a Vida', 'S', NULL);

INSERT INTO `db_pir_grc`.`grc_evento_brinde` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('1', '01', 'e-book', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_brinde` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('2', '02', 'Planilha', 'Planilha', 'S');

INSERT INTO `db_pir_grc`.`grc_evento_canal_inscricao` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('1', '01', 'CRM', 'Sistema de Relacionamento Sebrae-BA', 'S');
INSERT INTO `db_pir_grc`.`grc_evento_canal_inscricao` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('2', '02', 'Loja Virtual', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_canal_inscricao` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('3', '03', 'Central de Relacionamento com o Cliente', NULL, 'S');

INSERT INTO `db_pir_grc`.`grc_evento_local_assento_categoria` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('1', 'A', 'CATEGORIA A', NULL, 'S');

ALTER TABLE `grc_evento_publicacao`
MODIFY COLUMN `descricao`  varchar(120) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL AFTER `situacao`,
MODIFY COLUMN `data_publicacao_de`  date NULL AFTER `ativo`,
MODIFY COLUMN `data_publicacao_ate`  date NULL AFTER `data_publicacao_de`;

ALTER TABLE `grc_evento_publicacao`
ADD COLUMN `temporario`  char(1) NOT NULL DEFAULT 'S' AFTER `situacao`;

update grc_evento_publicacao set temporario = 'N';

-- 11/05/2017

ALTER TABLE `grc_evento_publicacao_brinde` DROP FOREIGN KEY `FK_grc_evento_publicacao_brinde_1`;

ALTER TABLE `grc_evento_publicacao_brinde` ADD CONSTRAINT `FK_grc_evento_publicacao_brinde_1` FOREIGN KEY (`idt_evento_publicacao`) REFERENCES `grc_evento_publicacao` (`idt`) ON DELETE CASCADE ON UPDATE RESTRICT;

ALTER TABLE `grc_evento_publicacao_canal` DROP FOREIGN KEY `FK_grc_evento_publicacao_canal_1`;

ALTER TABLE `grc_evento_publicacao_canal` ADD CONSTRAINT `FK_grc_evento_publicacao_canal_1` FOREIGN KEY (`idt_evento_publicacao`) REFERENCES `grc_evento_publicacao` (`idt`) ON DELETE CASCADE ON UPDATE RESTRICT;

ALTER TABLE `grc_evento_publicacao_porte` DROP FOREIGN KEY `FK_grc_evento_publicacao_porte_1`;

ALTER TABLE `grc_evento_publicacao_porte` ADD CONSTRAINT `FK_grc_evento_publicacao_porte_1` FOREIGN KEY (`idt_evento_publicacao`) REFERENCES `grc_evento_publicacao` (`idt`) ON DELETE CASCADE ON UPDATE RESTRICT;

ALTER TABLE `grc_evento_publicacao_porte` ADD CONSTRAINT `FK_grc_evento_publicacao_porte_2` FOREIGN KEY (`idt_porte`) REFERENCES `db_pir_gec`.`gec_organizacao_porte` (`idt`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `grc_evento_publicacao_brinde` DROP FOREIGN KEY `FK_grc_evento_publicacao_brinde_2`;

ALTER TABLE `grc_evento_publicacao_brinde` ADD CONSTRAINT `FK_grc_evento_publicacao_brinde_2` FOREIGN KEY (`idt_brinde`) REFERENCES `grc_evento_brinde` (`idt`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `grc_evento_publicacao`
MODIFY COLUMN `data_hora_fim_inscricao_ec`  date NULL DEFAULT NULL AFTER `data_situacao`,
MODIFY COLUMN `data_validade_voucher`  date NULL DEFAULT NULL AFTER `perc_desconto_voucher`,
MODIFY COLUMN `data_validade_cupon`  date NULL DEFAULT NULL AFTER `palavra_chave_cupon`;

ALTER TABLE `grc_evento`
ADD COLUMN `publicacao_ok`  char(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT 'N' AFTER `publica_internet`;

insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_evento_publicacao_acao','Publicação de Eventos','02.03.90','S','S','listar','listar');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_evento_publicacao_acao') as id_funcao
from plu_direito where cod_direito in ('con');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_evento_publicacao_acao');

-- select id_funcao INTO @id_funcao from plu_funcao where cod_funcao = 'grc_evento_publicacao_acao';
-- INSERT INTO `db_pir_grc`.`plu_painel_funcao` (`idt_painel_grupo`, `id_funcao`, `pos_top`, `pos_left`, `imagem`, `imagem_d`, `texto_cab`, `detalhe`, `visivel`, `hint`, `parametros`, `texto_font_tam`, `texto_ativ_font_cor`, `texto_ativ_fundo`, `texto_desativ_font_cor`, `texto_desativ_fundo`, `include`, `include_arq`, `include_altura`, `include_largura`) VALUES ('4', @id_funcao, '105', '768', NULL, NULL, NULL, NULL, 'S', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'N', NULL, NULL, NULL);

CREATE TABLE `grc_evento_publicacao_mapa` (
  `idt` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idt_local_pa` int(10) unsigned NOT NULL,
  `idt_local_pa_mapa` int(10) unsigned DEFAULT NULL,
  `descricao` varchar(120) NOT NULL,
  `detalhe` text,
  `assento_mapa` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`idt`),
  UNIQUE KEY `iu_grc_evento_publicacao_mapa` (`idt_local_pa`),
  CONSTRAINT `FK_grc_evento_publicacao_mapa_1` FOREIGN KEY (`idt_local_pa`) REFERENCES `grc_evento_local_pa` (`idt`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `grc_evento_publicacao_mapa_assento` (
  `idt` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idt_publicacao_mapa` int(10) unsigned NOT NULL,
  `codigo` varchar(45) NOT NULL,
  `descricao` varchar(120) DEFAULT NULL,
  `ativo` char(1) NOT NULL DEFAULT 'S',
  `detalhe` text,
  `linha` int(10) unsigned DEFAULT NULL,
  `coluna` int(10) unsigned DEFAULT NULL,
  `coordenada` varchar(255) DEFAULT NULL,
  `idt_tipo_assento` int(10) unsigned DEFAULT NULL,
  `mapa_assento` varchar(120) DEFAULT NULL,
  PRIMARY KEY (`idt`),
  UNIQUE KEY `iu_grc_evento_publicacao_mapa_assento` (`idt_publicacao_mapa`,`codigo`),
  KEY `FK_grc_evento_publicacao_mapa_assento_2` (`idt_tipo_assento`),
  CONSTRAINT `FK_grc_evento_publicacao_mapa_assento_1` FOREIGN KEY (`idt_publicacao_mapa`) REFERENCES `grc_evento_publicacao_mapa` (`idt`),
  CONSTRAINT `FK_grc_evento_publicacao_mapa_assento_2` FOREIGN KEY (`idt_tipo_assento`) REFERENCES `grc_evento_local_pa_tipo_assento` (`idt`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_evento_publicacao_mapa','Evento Publicação Mapa','02.03.54.08','S','S','listar','listar');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_evento_publicacao_mapa') as id_funcao
from plu_direito where cod_direito in ('con','alt','inc','exc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_evento_publicacao_mapa');

insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_evento_publicacao_mapa_assento','Evento Publicação Mapa - Assento','02.03.54.08.01','S','S','listar','listar');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_evento_publicacao_mapa_assento') as id_funcao
from plu_direito where cod_direito in ('con','alt','inc','exc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_evento_publicacao_mapa_assento');

ALTER TABLE `grc_evento_publicacao_mapa`
ADD COLUMN `idt_evento_publicacao`  int(10) UNSIGNED NOT NULL AFTER `idt`;

ALTER TABLE `grc_evento_publicacao_mapa` ADD CONSTRAINT `FK_grc_evento_publicacao_mapa_2` FOREIGN KEY (`idt_evento_publicacao`) REFERENCES `grc_evento_publicacao` (`idt`) ON DELETE CASCADE ON UPDATE RESTRICT;

ALTER TABLE `grc_evento_publicacao_mapa_assento` DROP FOREIGN KEY `FK_grc_evento_publicacao_mapa_assento_1`;

ALTER TABLE `grc_evento_publicacao_mapa_assento` ADD CONSTRAINT `FK_grc_evento_publicacao_mapa_assento_1` FOREIGN KEY (`idt_publicacao_mapa`) REFERENCES `grc_evento_publicacao_mapa` (`idt`) ON DELETE CASCADE ON UPDATE RESTRICT;

ALTER TABLE `grc_evento_publicacao_mapa` ADD CONSTRAINT `FK_grc_evento_publicacao_mapa_3` FOREIGN KEY (`idt_local_pa_mapa`) REFERENCES `grc_evento_local_pa_mapa` (`idt`) ON DELETE RESTRICT ON UPDATE RESTRICT;

-- 12/05/2017

ALTER TABLE `grc_evento_local_pa_mapa_assento`
MODIFY COLUMN `coordenada`  text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL AFTER `coluna`;

ALTER TABLE `grc_evento_publicacao_mapa_assento`
MODIFY COLUMN `coordenada`  text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL AFTER `coluna`;

insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_evento_despublicacao_acao','Despublicação de Eventos','02.03.91','S','S','listar','listar');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_evento_despublicacao_acao') as id_funcao
from plu_direito where cod_direito in ('con');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_evento_despublicacao_acao');

-- select id_funcao INTO @id_funcao from plu_funcao where cod_funcao = 'grc_evento_despublicacao_acao';
-- INSERT INTO `db_pir_grc`.`plu_painel_funcao` (`idt_painel_grupo`, `id_funcao`, `pos_top`, `pos_left`, `imagem`, `imagem_d`, `texto_cab`, `detalhe`, `visivel`, `hint`, `parametros`, `texto_font_tam`, `texto_ativ_font_cor`, `texto_ativ_fundo`, `texto_desativ_font_cor`, `texto_desativ_fundo`, `include`, `include_arq`, `include_altura`, `include_largura`) VALUES ('4', @id_funcao, '105', '768', NULL, NULL, NULL, NULL, 'S', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'N', NULL, NULL, NULL);

-- INSERT INTO `db_pir_grc`.`plu_painel_grupo` (`idt_painel`, `codigo`, `ordem`, `descricao`, `hint`, `tit_mostrar`, `tit_bt_fecha`, `tit_font_tam`, `tit_font_cor`, `tit_fundo`, `mostra_item`, `texto_altura`, `texto_font_tam`, `texto_ativ_font_cor`, `texto_ativ_fundo`, `texto_desativ_font_cor`, `texto_desativ_fundo`, `move_item`, `passo`, `passo_tit`, `layout_grid`, `img_altura`, `img_largura`, `img_margem_dir`, `img_margem_esq`, `espaco_linha`, `painel_altura`, `painel_largura`) VALUES ('36', '3', '3', 'PUBLICAÇÃO DE EVENTO', NULL, 'S', 'A', NULL, NULL, NULL, 'IT', '30', NULL, NULL, NULL, NULL, NULL, 'S', 'N', 'N', 'S', '70', '100', '15', '15', '15', '0', '0');
-- select idt INTO @idt_painel_grupo from plu_painel_grupo where idt_painel = 36 and codigo = '3';

-- select id_funcao INTO @id_funcao from plu_funcao where cod_funcao = 'grc_evento_local_pa_tipo_assento';
-- INSERT INTO `db_pir_grc`.`plu_painel_funcao` (`idt_painel_grupo`, `id_funcao`, `pos_top`, `pos_left`, `imagem`, `imagem_d`, `texto_cab`, `detalhe`, `visivel`, `hint`, `parametros`, `texto_font_tam`, `texto_ativ_font_cor`, `texto_ativ_fundo`, `texto_desativ_font_cor`, `texto_desativ_fundo`, `include`, `include_arq`, `include_altura`, `include_largura`) VALUES (@idt_painel_grupo, @id_funcao, '0', '260', NULL, NULL, 'Tipo de Assento', NULL, 'S', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'N', NULL, NULL, NULL);
-- select id_funcao INTO @id_funcao from plu_funcao where cod_funcao = 'grc_evento_local_assento_categoria';
-- INSERT INTO `db_pir_grc`.`plu_painel_funcao` (`idt_painel_grupo`, `id_funcao`, `pos_top`, `pos_left`, `imagem`, `imagem_d`, `texto_cab`, `detalhe`, `visivel`, `hint`, `parametros`, `texto_font_tam`, `texto_ativ_font_cor`, `texto_ativ_fundo`, `texto_desativ_font_cor`, `texto_desativ_fundo`, `include`, `include_arq`, `include_altura`, `include_largura`) VALUES (@idt_painel_grupo, @id_funcao, '0', '0', NULL, NULL, 'Categoria do Assento', NULL, 'S', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'N', NULL, NULL, NULL);
-- select id_funcao INTO @id_funcao from plu_funcao where cod_funcao = 'grc_evento_tipo_voucher';
-- INSERT INTO `db_pir_grc`.`plu_painel_funcao` (`idt_painel_grupo`, `id_funcao`, `pos_top`, `pos_left`, `imagem`, `imagem_d`, `texto_cab`, `detalhe`, `visivel`, `hint`, `parametros`, `texto_font_tam`, `texto_ativ_font_cor`, `texto_ativ_fundo`, `texto_desativ_font_cor`, `texto_desativ_fundo`, `include`, `include_arq`, `include_altura`, `include_largura`) VALUES (@idt_painel_grupo, @id_funcao, '0', '0', NULL, NULL, 'Tipo de Voucher', NULL, 'S', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'N', NULL, NULL, NULL);
-- select id_funcao INTO @id_funcao from plu_funcao where cod_funcao = 'grc_evento_grupo';
-- INSERT INTO `db_pir_grc`.`plu_painel_funcao` (`idt_painel_grupo`, `id_funcao`, `pos_top`, `pos_left`, `imagem`, `imagem_d`, `texto_cab`, `detalhe`, `visivel`, `hint`, `parametros`, `texto_font_tam`, `texto_ativ_font_cor`, `texto_ativ_fundo`, `texto_desativ_font_cor`, `texto_desativ_fundo`, `include`, `include_arq`, `include_altura`, `include_largura`) VALUES (@idt_painel_grupo, @id_funcao, '0', '0', NULL, NULL, 'Grandes Eventos', NULL, 'S', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'N', NULL, NULL, NULL);
-- select id_funcao INTO @id_funcao from plu_funcao where cod_funcao = 'grc_evento_brinde';
-- INSERT INTO `db_pir_grc`.`plu_painel_funcao` (`idt_painel_grupo`, `id_funcao`, `pos_top`, `pos_left`, `imagem`, `imagem_d`, `texto_cab`, `detalhe`, `visivel`, `hint`, `parametros`, `texto_font_tam`, `texto_ativ_font_cor`, `texto_ativ_fundo`, `texto_desativ_font_cor`, `texto_desativ_fundo`, `include`, `include_arq`, `include_altura`, `include_largura`) VALUES (@idt_painel_grupo, @id_funcao, '0', '0', NULL, NULL, 'Brindes do Evento', NULL, 'S', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'N', NULL, NULL, NULL);
-- select id_funcao INTO @id_funcao from plu_funcao where cod_funcao = 'grc_evento_canal_inscricao';
-- INSERT INTO `db_pir_grc`.`plu_painel_funcao` (`idt_painel_grupo`, `id_funcao`, `pos_top`, `pos_left`, `imagem`, `imagem_d`, `texto_cab`, `detalhe`, `visivel`, `hint`, `parametros`, `texto_font_tam`, `texto_ativ_font_cor`, `texto_ativ_fundo`, `texto_desativ_font_cor`, `texto_desativ_fundo`, `include`, `include_arq`, `include_altura`, `include_largura`) VALUES (@idt_painel_grupo, @id_funcao, '0', '0', NULL, NULL, 'Canal de Inscrição', NULL, 'S', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'N', NULL, NULL, NULL);

-- luiz 4=06-2017


CREATE TABLE `grc_evento_publicacao_anexo` (
  `idt` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idt_evento_publicacao` int(10) unsigned NOT NULL,
  PRIMARY KEY (`idt`),
  UNIQUE KEY `iu_grc_evento_publicacao_anexo` (`idt_evento_publicacao`)
  ) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE `grc_evento_publicacao_cupom` (
  `idt` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idt_evento_publicacao` int(10) unsigned NOT NULL,
  PRIMARY KEY (`idt`),
  UNIQUE KEY `iu_grc_evento_publicacao_cupom` (`idt_evento_publicacao`)
  ) ENGINE=InnoDB DEFAULT CHARSET=latin1;



ALTER TABLE `db_pir_grc`.`grc_evento_publicacao_anexo` ADD COLUMN `arquivo` VARCHAR(255) NOT NULL AFTER `idt_evento_publicacao`,
 ADD COLUMN `descricao` VARCHAR(255) NOT NULL AFTER `arquivo`,
 DROP INDEX `iu_grc_evento_publicacao_anexo`,
 ADD UNIQUE INDEX `iu_grc_evento_publicacao_anexo` USING BTREE(`idt_evento_publicacao`, `arquivo`);


ALTER TABLE `db_pir_grc`.`grc_evento_publicacao_cupom` ADD COLUMN `palavra_chave` VARCHAR(45) NOT NULL AFTER `idt_evento_publicacao`,
 ADD COLUMN `data_validade` DATE NOT NULL AFTER `palavra_chave`,
 ADD COLUMN `perc_desconto` VARCHAR(45) NOT NULL AFTER `data_validade`,
 ADD COLUMN `quantidade` INTEGER UNSIGNED NOT NULL AFTER `perc_desconto`,
 DROP INDEX `iu_grc_evento_publicacao_cupom`,
 ADD UNIQUE INDEX `iu_grc_evento_publicacao_cupom` USING BTREE(`idt_evento_publicacao`, `palavra_chave`);



ALTER TABLE `db_pir_grc`.`grc_evento_publicacao_brinde` ADD COLUMN `link` VARCHAR(255) AFTER `idt_brinde`;




insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_evento_publicacao_anexo','Anexos da Publicação','02.03.54.11','S','S','listar','listar');
insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_evento_publicacao_anexo') as id_funcao
from plu_direito where cod_direito in ('con','alt','inc','exc');
insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_evento_publicacao_anexo');


insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_evento_publicacao_cupom','Cupons da Publicação','02.03.54.13','S','S','listar','listar');
insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_evento_publicacao_cupom') as id_funcao
from plu_direito where cod_direito in ('con','alt','inc','exc');
insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_evento_publicacao_cupom');



CREATE TABLE `grc_evento_publicacao_vouchers` (
  `idt` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idt_evento_publicacao` int(10) unsigned NOT NULL,
  `numero` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`idt`),
  UNIQUE KEY `iu_grc_evento_publicacao_vouchers` (`idt_evento_publicacao`,`numero`)
  ) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE `grc_evento_publicacao_cupons` (
  `idt` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idt_evento_publicacao` int(10) unsigned NOT NULL,
  `numero` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`idt`),
  UNIQUE KEY `iu_grc_evento_publicacao_cupons` (`idt_evento_publicacao`,`numero`)
  ) ENGINE=InnoDB DEFAULT CHARSET=latin1;


insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_evento_publicacao_vouchers','Voucers Emitidos','02.03.54.15','S','S','listar','listar');
insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_evento_publicacao_vouchers') as id_funcao
from plu_direito where cod_direito in ('con','alt','inc','exc');
insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_evento_publicacao_vouchers');


insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_evento_publicacao_cupons','Cupons Emitidos','02.03.54.17','S','S','listar','listar');
insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_evento_publicacao_cupons') as id_funcao
from plu_direito where cod_direito in ('con','alt','inc','exc');
insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_evento_publicacao_cupons');

ALTER TABLE `db_pir_grc`.`grc_evento_publicacao_cupons` ADD COLUMN `data_validade` DATE NOT NULL AFTER `numero`,
 ADD COLUMN `perc_desconto` NUMERIC(15,2) NOT NULL AFTER `data_validade`,
 ADD COLUMN `valor_desconto` NUMERIC(15,2) NOT NULL AFTER `perc_desconto`,
 ADD COLUMN `data_utilizacao` DATE NOT NULL AFTER `valor_desconto`,
 ADD COLUMN `pessoa` VARCHAR(120) NOT NULL AFTER `data_utilizacao`,
 ADD COLUMN `cpf` VARCHAR(45) NOT NULL AFTER `pessoa`,
 ADD COLUMN `cnpj` VARCHAR(45) NOT NULL AFTER `cpf`,
 ADD COLUMN `nome_empresa` VARCHAR(120) NOT NULL AFTER `cnpj`;


ALTER TABLE `db_pir_grc`.`grc_evento_publicacao_vouchers` ADD COLUMN `data_validade` DATE NOT NULL AFTER `numero`,
 ADD COLUMN `perc_desconto` NUMERIC(15,2) NOT NULL AFTER `data_validade`,
 ADD COLUMN `valor_desconto` NUMERIC(15,2) NOT NULL AFTER `perc_desconto`,
 ADD COLUMN `data_utilizacao` DATE NOT NULL AFTER `valor_desconto`,
 ADD COLUMN `pessoa` VARCHAR(120) NOT NULL AFTER `data_utilizacao`,
 ADD COLUMN `cpf` VARCHAR(45) NOT NULL AFTER `pessoa`,
 ADD COLUMN `cnpj` VARCHAR(45) NOT NULL AFTER `cpf`,
 ADD COLUMN `nome_empresa` VARCHAR(120) NOT NULL AFTER `cnpj`;
 
 
 ALTER TABLE `db_pir_grc`.`grc_evento_publicacao_cupons` MODIFY COLUMN `cnpj` VARCHAR(45) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
 MODIFY COLUMN `nome_empresa` VARCHAR(120) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL;


ALTER TABLE `db_pir_grc`.`grc_evento_publicacao_vouchers` MODIFY COLUMN `cnpj` VARCHAR(45) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
 MODIFY COLUMN `nome_empresa` VARCHAR(120) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL;




CREATE TABLE `grc_evento_combo` (
  `idt` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `codigo` VARCHAR(45) NOT NULL,
  `descricao` VARCHAR(120) NOT NULL,
  PRIMARY KEY (`idt`),
  UNIQUE KEY `iu_grc_evento_combo` (`codigo`)
  ) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `grc_evento_combo_instrumento` (
  `idt` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idt_evento_combo` int(10) unsigned NOT NULL,
  `idt_instrumento` int(10) unsigned NOT NULL,
  PRIMARY KEY (`idt`),
  UNIQUE KEY `iu_grc_evento_combo_instrumento` (`idt_evento_combo`,`idt_instrumento`)
  ) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE `grc_evento_combo_instrumento_evento` (
  `idt` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idt_evento_combo_instrumento` int(10) unsigned NOT NULL,
  `idt_evento` int(10) unsigned NOT NULL,
  PRIMARY KEY (`idt`),
  UNIQUE KEY `iu_grc_evento_combo_instrumento_evento` (`idt_evento_combo_instrumento`,`idt_evento`)
  ) ENGINE=InnoDB DEFAULT CHARSET=latin1;

insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_evento_combo','Combo de Evento','02.03.59','S','S','listar','listar');
insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_evento_combo') as id_funcao
from plu_direito where cod_direito in ('con','alt','inc','exc');
insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_evento_combo');

insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_evento_combo_instrumento','Combo de Evento','02.03.59.03','N','N','listar','listar');
insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_evento_combo_instrumento') as id_funcao
from plu_direito where cod_direito in ('con','alt','inc','exc');
insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_evento_combo_instrumento');


insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_evento_combo_instrumento_evento','Combo de Evento','02.03.59.05','N','N','listar','listar');
insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_evento_combo_instrumento_evento') as id_funcao
from plu_direito where cod_direito in ('con','alt','inc','exc');
insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_evento_combo_instrumento_evento');


ALTER TABLE `db_pir_grc`.`grc_evento_combo` ADD COLUMN `ativo` CHAR(1) NOT NULL DEFAULT 'S' AFTER `descricao`,
 ADD COLUMN `detalhe` TEXT AFTER `ativo`,
 ADD COLUMN `tipo` CHAR(1) NOT NULL DEFAULT 'F' AFTER `detalhe`;
 
 
 ALTER TABLE `db_pir_grc`.`grc_evento_combo_instrumento_evento` ADD COLUMN `obrigatorio` CHAR(1) NOT NULL DEFAULT 'S' AFTER `idt_evento`;


ALTER TABLE `db_pir_grc`.`grc_evento_combo_instrumento_evento` ADD CONSTRAINT `FK_grc_evento_combo_instrumento_evento_1` FOREIGN KEY `FK_grc_evento_combo_instrumento_evento_1` (`idt_evento_combo_instrumento`)
    REFERENCES `grc_evento_combo_instrumento` (`idt`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT;
ALTER TABLE `db_pir_grc`.`grc_evento_combo_instrumento_evento` ADD CONSTRAINT `FK_grc_evento_combo_instrumento_evento_2` FOREIGN KEY `FK_grc_evento_combo_instrumento_evento_2` (`idt_evento`)
    REFERENCES `grc_evento` (`idt`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT;
ALTER TABLE `db_pir_grc`.`grc_evento_combo_instrumento` ADD CONSTRAINT `FK_grc_evento_combo_instrumento_1` FOREIGN KEY `FK_grc_evento_combo_instrumento_1` (`idt_evento_combo`)
    REFERENCES `grc_evento_combo` (`idt`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT;
ALTER TABLE `db_pir_grc`.`grc_evento_combo_instrumento` ADD CONSTRAINT `FK_grc_evento_combo_instrumento_2` FOREIGN KEY `FK_grc_evento_combo_instrumento_2` (`idt_instrumento`)
    REFERENCES `grc_atendimento_instrumento` (`idt`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT;
	
	ALTER TABLE `db_pir_grc`.`grc_evento_publicacao_anexo` ADD CONSTRAINT `FK_grc_evento_publicacao_anexo_1` FOREIGN KEY `FK_grc_evento_publicacao_anexo_1` (`idt_evento_publicacao`)
    REFERENCES `grc_evento_publicacao` (`idt`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT;

-- 06/06/2017

-- Painel Vendas
UPDATE `plu_painel_funcao` SET `id_funcao`='386', `texto_cab`='Política de Vendas' WHERE (`idt`='241');
UPDATE `plu_painel` SET `codigo`='grc_vendas' WHERE (`idt`='13');

UPDATE `db_pir_grc`.`plu_painel_grupo` SET `idt`='24', `idt_painel`='13', `codigo`='1', `ordem`='1', `descricao`='POLÍTICA DE VENDAS', `hint`=NULL, `tit_mostrar`='S', `tit_bt_fecha`='A', `tit_font_tam`=NULL, `tit_font_cor`=NULL, `tit_fundo`=NULL, `mostra_item`='IT', `texto_altura`='30', `texto_font_tam`=NULL, `texto_ativ_font_cor`=NULL, `texto_ativ_fundo`=NULL, `texto_desativ_font_cor`=NULL, `texto_desativ_fundo`=NULL, `move_item`='S', `passo`='N', `passo_tit`='N', `layout_grid`='S', `img_altura`='70', `img_largura`='100', `img_margem_dir`='10', `img_margem_esq`='10', `espaco_linha`='15', `painel_altura`='257', `painel_largura`='869' WHERE (`idt`='24');
INSERT INTO `db_pir_grc`.`plu_painel_grupo` (`idt_painel`, `codigo`, `ordem`, `descricao`, `hint`, `tit_mostrar`, `tit_bt_fecha`, `tit_font_tam`, `tit_font_cor`, `tit_fundo`, `mostra_item`, `texto_altura`, `texto_font_tam`, `texto_ativ_font_cor`, `texto_ativ_fundo`, `texto_desativ_font_cor`, `texto_desativ_fundo`, `move_item`, `passo`, `passo_tit`, `layout_grid`, `img_altura`, `img_largura`, `img_margem_dir`, `img_margem_esq`, `espaco_linha`, `painel_altura`, `painel_largura`) VALUES ('13', '2', '2', 'TABELAS DE APOIO', NULL, 'S', 'A', NULL, NULL, NULL, 'IT', '30', NULL, NULL, NULL, NULL, NULL, 'S', 'N', 'N', 'S', '70', '100', '15', '15', '15', '0', '0');

select id_funcao INTO @id_funcao from plu_funcao where cod_funcao = 'grc_evento_publicacao_acao';
INSERT INTO `db_pir_grc`.`plu_painel_funcao` (`idt_painel_grupo`, `id_funcao`, `pos_top`, `pos_left`, `imagem`, `imagem_d`, `texto_cab`, `detalhe`, `visivel`, `hint`, `parametros`, `texto_font_tam`, `texto_ativ_font_cor`, `texto_ativ_fundo`, `texto_desativ_font_cor`, `texto_desativ_fundo`, `include`, `include_arq`, `include_altura`, `include_largura`) VALUES ('24', @id_funcao, '0', '0', '574_imagem_938_publicacao.png', NULL, 'Publicação de Eventos', NULL, 'S', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'N', NULL, NULL, NULL);
select id_funcao INTO @id_funcao from plu_funcao where cod_funcao = 'grc_evento_despublicacao_acao';
INSERT INTO `db_pir_grc`.`plu_painel_funcao` (`idt_painel_grupo`, `id_funcao`, `pos_top`, `pos_left`, `imagem`, `imagem_d`, `texto_cab`, `detalhe`, `visivel`, `hint`, `parametros`, `texto_font_tam`, `texto_ativ_font_cor`, `texto_ativ_fundo`, `texto_desativ_font_cor`, `texto_desativ_fundo`, `include`, `include_arq`, `include_altura`, `include_largura`) VALUES ('24', @id_funcao, '0', '0', '575_imagem_054_despublicacao.png', NULL, 'Despublicação de Eventos', NULL, 'S', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'N', NULL, NULL, NULL);
select id_funcao INTO @id_funcao from plu_funcao where cod_funcao = 'grc_evento_publicacao_vouchers';
INSERT INTO `db_pir_grc`.`plu_painel_funcao` (`idt_painel_grupo`, `id_funcao`, `pos_top`, `pos_left`, `imagem`, `imagem_d`, `texto_cab`, `detalhe`, `visivel`, `hint`, `parametros`, `texto_font_tam`, `texto_ativ_font_cor`, `texto_ativ_fundo`, `texto_desativ_font_cor`, `texto_desativ_fundo`, `include`, `include_arq`, `include_altura`, `include_largura`) VALUES ('24', @id_funcao, '0', '0', '576_imagem_443_voucher.png', NULL, 'Gestão de Voucher', NULL, 'S', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'N', NULL, NULL, NULL);
select id_funcao INTO @id_funcao from plu_funcao where cod_funcao = 'grc_evento_publicacao_cupons';
INSERT INTO `db_pir_grc`.`plu_painel_funcao` (`idt_painel_grupo`, `id_funcao`, `pos_top`, `pos_left`, `imagem`, `imagem_d`, `texto_cab`, `detalhe`, `visivel`, `hint`, `parametros`, `texto_font_tam`, `texto_ativ_font_cor`, `texto_ativ_fundo`, `texto_desativ_font_cor`, `texto_desativ_fundo`, `include`, `include_arq`, `include_altura`, `include_largura`) VALUES ('24', @id_funcao, '0', '0', '577_imagem_465_cupomdesconto.png', NULL, 'Gestão de Cupons', NULL, 'S', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'N', NULL, NULL, NULL);
select id_funcao INTO @id_funcao from plu_funcao where cod_funcao = 'grc_evento_combo';
INSERT INTO `db_pir_grc`.`plu_painel_funcao` (`idt_painel_grupo`, `id_funcao`, `pos_top`, `pos_left`, `imagem`, `imagem_d`, `texto_cab`, `detalhe`, `visivel`, `hint`, `parametros`, `texto_font_tam`, `texto_ativ_font_cor`, `texto_ativ_fundo`, `texto_desativ_font_cor`, `texto_desativ_fundo`, `include`, `include_arq`, `include_altura`, `include_largura`) VALUES ('24', @id_funcao, '0', '0', '578_imagem_425_combo-evento.png', NULL, 'Combo de Eventos', NULL, 'S', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'N', NULL, NULL, NULL);

select idt INTO @idt_painel_grupo from plu_painel_grupo where idt_painel = 13 and codigo = '2';

select id_funcao INTO @id_funcao from plu_funcao where cod_funcao = 'grc_evento_local_pa';
INSERT INTO `db_pir_grc`.`plu_painel_funcao` (`idt_painel_grupo`, `id_funcao`, `pos_top`, `pos_left`, `imagem`, `imagem_d`, `texto_cab`, `detalhe`, `visivel`, `hint`, `parametros`, `texto_font_tam`, `texto_ativ_font_cor`, `texto_ativ_fundo`, `texto_desativ_font_cor`, `texto_desativ_fundo`, `include`, `include_arq`, `include_altura`, `include_largura`) VALUES (@idt_painel_grupo, @id_funcao, '0', '0', '566_imagem_031_367imagem526local-icon-pin.png', NULL, 'Local do Evento - Externo', NULL, 'S', NULL, 'externo=S', NULL, NULL, NULL, NULL, NULL, 'N', NULL, NULL, NULL);
INSERT INTO `db_pir_grc`.`plu_painel_funcao` (`idt_painel_grupo`, `id_funcao`, `pos_top`, `pos_left`, `imagem`, `imagem_d`, `texto_cab`, `detalhe`, `visivel`, `hint`, `parametros`, `texto_font_tam`, `texto_ativ_font_cor`, `texto_ativ_fundo`, `texto_desativ_font_cor`, `texto_desativ_fundo`, `include`, `include_arq`, `include_altura`, `include_largura`) VALUES (@idt_painel_grupo, @id_funcao, '0', '0', '567_imagem_072_367imagem526local-icon-pin.png', NULL, 'Local do Evento - Interno', NULL, 'S', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'N', NULL, NULL, NULL);
select id_funcao INTO @id_funcao from plu_funcao where cod_funcao = 'grc_evento_brinde';
INSERT INTO `db_pir_grc`.`plu_painel_funcao` (`idt_painel_grupo`, `id_funcao`, `pos_top`, `pos_left`, `imagem`, `imagem_d`, `texto_cab`, `detalhe`, `visivel`, `hint`, `parametros`, `texto_font_tam`, `texto_ativ_font_cor`, `texto_ativ_fundo`, `texto_desativ_font_cor`, `texto_desativ_fundo`, `include`, `include_arq`, `include_altura`, `include_largura`) VALUES (@idt_painel_grupo, @id_funcao, '115', '0', '568_imagem_921_brinds.jpg', NULL, 'Brindes do Evento', NULL, 'S', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'N', NULL, NULL, NULL);
select id_funcao INTO @id_funcao from plu_funcao where cod_funcao = 'grc_evento_canal_inscricao';
INSERT INTO `db_pir_grc`.`plu_painel_funcao` (`idt_painel_grupo`, `id_funcao`, `pos_top`, `pos_left`, `imagem`, `imagem_d`, `texto_cab`, `detalhe`, `visivel`, `hint`, `parametros`, `texto_font_tam`, `texto_ativ_font_cor`, `texto_ativ_fundo`, `texto_desativ_font_cor`, `texto_desativ_fundo`, `include`, `include_arq`, `include_altura`, `include_largura`) VALUES (@idt_painel_grupo, @id_funcao, '115', '0', '569_imagem_616_canalinscricao.png', NULL, 'Canal de Inscrição', NULL, 'S', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'N', NULL, NULL, NULL);
select id_funcao INTO @id_funcao from plu_funcao where cod_funcao = 'grc_evento_local_assento_categoria';
INSERT INTO `db_pir_grc`.`plu_painel_funcao` (`idt_painel_grupo`, `id_funcao`, `pos_top`, `pos_left`, `imagem`, `imagem_d`, `texto_cab`, `detalhe`, `visivel`, `hint`, `parametros`, `texto_font_tam`, `texto_ativ_font_cor`, `texto_ativ_fundo`, `texto_desativ_font_cor`, `texto_desativ_fundo`, `include`, `include_arq`, `include_altura`, `include_largura`) VALUES (@idt_painel_grupo, @id_funcao, '0', '0', '570_imagem_282_categoriaassento.jpg', NULL, 'Categoria do Assento', NULL, 'S', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'N', NULL, NULL, NULL);
select id_funcao INTO @id_funcao from plu_funcao where cod_funcao = 'grc_evento_grupo';
INSERT INTO `db_pir_grc`.`plu_painel_funcao` (`idt_painel_grupo`, `id_funcao`, `pos_top`, `pos_left`, `imagem`, `imagem_d`, `texto_cab`, `detalhe`, `visivel`, `hint`, `parametros`, `texto_font_tam`, `texto_ativ_font_cor`, `texto_ativ_fundo`, `texto_desativ_font_cor`, `texto_desativ_fundo`, `include`, `include_arq`, `include_altura`, `include_largura`) VALUES (@idt_painel_grupo, @id_funcao, '0', '650', '571_imagem_307_grandeseventos.png', NULL, 'Grandes Eventos', NULL, 'S', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'N', NULL, NULL, NULL);
select id_funcao INTO @id_funcao from plu_funcao where cod_funcao = 'grc_evento_local_pa_tipo_assento';
INSERT INTO `db_pir_grc`.`plu_painel_funcao` (`idt_painel_grupo`, `id_funcao`, `pos_top`, `pos_left`, `imagem`, `imagem_d`, `texto_cab`, `detalhe`, `visivel`, `hint`, `parametros`, `texto_font_tam`, `texto_ativ_font_cor`, `texto_ativ_fundo`, `texto_desativ_font_cor`, `texto_desativ_fundo`, `include`, `include_arq`, `include_altura`, `include_largura`) VALUES (@idt_painel_grupo, @id_funcao, '0', '0', '572_imagem_526_tipoassento.jpg', NULL, 'Tipos de Assentos', NULL, 'S', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'N', NULL, NULL, NULL);
select id_funcao INTO @id_funcao from plu_funcao where cod_funcao = 'grc_evento_tipo_voucher';
INSERT INTO `db_pir_grc`.`plu_painel_funcao` (`idt_painel_grupo`, `id_funcao`, `pos_top`, `pos_left`, `imagem`, `imagem_d`, `texto_cab`, `detalhe`, `visivel`, `hint`, `parametros`, `texto_font_tam`, `texto_ativ_font_cor`, `texto_ativ_fundo`, `texto_desativ_font_cor`, `texto_desativ_fundo`, `include`, `include_arq`, `include_altura`, `include_largura`) VALUES (@idt_painel_grupo, @id_funcao, '0', '520', '573_imagem_984_voucher.png', NULL, 'Tipo de Voucher', NULL, 'S', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'N', NULL, NULL, NULL);

DELETE FROM `plu_painel_funcao` WHERE (`idt`='136');

-- 07/06/2017

ALTER TABLE `grc_evento`
DROP COLUMN `publicacao_ok`;

-- 08/06/2017

ALTER TABLE `grc_evento_local_pa_tipo_assento`
ADD COLUMN `imagem`  varchar(255) NOT NULL AFTER `ativo`,
ADD COLUMN `imagem_d`  varchar(255) NOT NULL AFTER `imagem`;

-- 09/06/2017

ALTER TABLE `grc_evento_publicacao_mapa`
MODIFY COLUMN `descricao`  varchar(120) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL AFTER `idt_local_pa_mapa`;

ALTER TABLE `grc_evento_publicacao_mapa_assento`
ADD UNIQUE INDEX `iu_grc_evento_publicacao_mapa_assento_1` (`idt_publicacao_mapa`, `linha`, `coluna`) USING BTREE ;

ALTER TABLE `grc_evento_local_pa_mapa_assento`
ADD UNIQUE INDEX `iu_grc_evento_local_pa_mapa_assento_1` (`idt_local_pa_mapa`, `linha`, `coluna`) USING BTREE ;

ALTER TABLE `grc_evento_publicacao_cupom`
MODIFY COLUMN `perc_desconto`  decimal(10,2) NOT NULL AFTER `data_validade`;

ALTER TABLE `grc_evento_publicacao_cupom` ADD CONSTRAINT `fk_grc_evento_publicacao_cupom_1` FOREIGN KEY (`idt_evento_publicacao`) REFERENCES `grc_evento_publicacao` (`idt`) ON DELETE CASCADE ON UPDATE RESTRICT;

CREATE TABLE `grc_evento_publicacao_publico` (
  `idt` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idt_evento_publicacao` int(10) unsigned NOT NULL,
  `idt_entidade_pf` int(10) unsigned NOT NULL,
  `idt_entidade_pj` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`idt`),
  UNIQUE KEY `iu_grc_evento_publicacao_publico` (`idt_evento_publicacao`,`idt_entidade_pf`) USING BTREE,
  KEY `fk_grc_evento_publicacao_publico_2` (`idt_entidade_pf`),
  KEY `fk_grc_evento_publicacao_publico_3` (`idt_entidade_pj`),
  CONSTRAINT `fk_grc_evento_publicacao_publico_3` FOREIGN KEY (`idt_entidade_pj`) REFERENCES `db_pir_gec`.`gec_entidade` (`idt`),
  CONSTRAINT `fk_grc_evento_publicacao_publico_1` FOREIGN KEY (`idt_evento_publicacao`) REFERENCES `grc_evento_publicacao` (`idt`) ON DELETE CASCADE,
  CONSTRAINT `fk_grc_evento_publicacao_publico_2` FOREIGN KEY (`idt_entidade_pf`) REFERENCES `db_pir_gec`.`gec_entidade` (`idt`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_evento_publicacao_publico','Política de Vendas Público','02.03.54.19','S','S','listar','listar');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_evento_publicacao_publico') as id_funcao
from plu_direito where cod_direito in ('con','alt','inc','exc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_evento_publicacao_publico');

UPDATE `plu_funcao` SET `nm_funcao`='Política de Vendas' WHERE (`cod_classificacao`='02.03.54');
UPDATE `plu_funcao` SET `nm_funcao`='Política de Vendas Mapa' WHERE (`cod_classificacao`='02.03.54.08');
UPDATE `plu_funcao` SET `nm_funcao`='Política de Vendas Mapa - Assento' WHERE (`cod_classificacao`='02.03.54.08.01');
UPDATE `plu_funcao` SET `nm_funcao`='Política de Vendas Anexos' WHERE (`cod_classificacao`='02.03.54.11');
UPDATE `plu_funcao` SET `nm_funcao`='Política de Vendas Cupom de Desconto' WHERE (`cod_classificacao`='02.03.54.13');

-- 10/06/2017

CREATE TABLE `grc_evento_publicacao_voucher` (
  `idt` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idt_evento_publicacao` int(10) unsigned NOT NULL,
  `idt_tipo_voucher` int(10) unsigned NOT NULL,
  `data_validade` date NOT NULL,
  `perc_desconto` decimal(10,2) NOT NULL,
  `quantidade` int(10) unsigned NOT NULL,
  PRIMARY KEY (`idt`),
  KEY `fk_grc_evento_publicacao_voucher_1` (`idt_evento_publicacao`),
  KEY `fk_grc_evento_publicacao_voucher_2` (`idt_tipo_voucher`),
  CONSTRAINT `fk_grc_evento_publicacao_voucher_2` FOREIGN KEY (`idt_tipo_voucher`) REFERENCES `grc_evento_tipo_voucher` (`idt`),
  CONSTRAINT `fk_grc_evento_publicacao_voucher_1` FOREIGN KEY (`idt_evento_publicacao`) REFERENCES `grc_evento_publicacao` (`idt`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

DROP TABLE `grc_evento_publicacao_vouchers`;

CREATE TABLE `grc_evento_publicacao_voucher_registro` (
  `idt` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idt_evento_publicacao` int(10) unsigned NOT NULL,
  `idt_evento_publicacao_voucher` int(10) unsigned NOT NULL,
  `numero` varchar(45) NOT NULL,
  `idt_entidade_pf` int(10) unsigned NOT NULL,
  `idt_entidade_pj` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`idt`),
  UNIQUE KEY `iu_grc_evento_publicacao_voucher_registro` (`idt_evento_publicacao`,`idt_entidade_pf`) USING BTREE,
  KEY `fk_grc_evento_publicacao_voucher_registro_1` (`idt_entidade_pj`),
  KEY `fk_grc_evento_publicacao_voucher_registro_2` (`idt_entidade_pf`),
  KEY `fk_grc_evento_publicacao_voucher_registro_4` (`idt_evento_publicacao_voucher`),
  CONSTRAINT `fk_grc_evento_publicacao_voucher_registro_4` FOREIGN KEY (`idt_evento_publicacao_voucher`) REFERENCES `grc_evento_publicacao_voucher` (`idt`),
  CONSTRAINT `fk_grc_evento_publicacao_voucher_registro_1` FOREIGN KEY (`idt_entidade_pj`) REFERENCES `db_pir_gec`.`gec_entidade` (`idt`),
  CONSTRAINT `fk_grc_evento_publicacao_voucher_registro_2` FOREIGN KEY (`idt_entidade_pf`) REFERENCES `db_pir_gec`.`gec_entidade` (`idt`),
  CONSTRAINT `fk_grc_evento_publicacao_voucher_registro_3` FOREIGN KEY (`idt_evento_publicacao`) REFERENCES `grc_evento_publicacao` (`idt`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

UPDATE `plu_funcao` SET `nm_funcao`='Política de Vendas Voucher', cod_funcao='grc_evento_publicacao_voucher' WHERE (`cod_classificacao`='02.03.54.15');

insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_evento_publicacao_voucher_registro','Política de Vendas Voucher - Registro','02.03.54.15.01','S','S','listar','listar');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_evento_publicacao_voucher_registro') as id_funcao
from plu_direito where cod_direito in ('con','alt','inc','exc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_evento_publicacao_voucher_registro');

ALTER TABLE `grc_evento_publicacao_voucher`
ADD COLUMN `descricao`  varchar(45) NOT NULL AFTER `idt_tipo_voucher`;

ALTER TABLE `grc_evento_publicacao_publico_alvo` DROP FOREIGN KEY `FK_grc_evento_publicacao_publico_alvo_2`;

ALTER TABLE `grc_evento_publicacao_publico_alvo` ADD CONSTRAINT `FK_grc_evento_publicacao_publico_alvo_2` FOREIGN KEY (`idt`) REFERENCES `grc_evento_publicacao` (`idt`) ON DELETE CASCADE ON UPDATE RESTRICT;

ALTER TABLE `grc_evento_publicacao_voucher_registro` DROP FOREIGN KEY `fk_grc_evento_publicacao_voucher_registro_4`;

ALTER TABLE `grc_evento_publicacao_voucher_registro` ADD CONSTRAINT `fk_grc_evento_publicacao_voucher_registro_4` FOREIGN KEY (`idt_evento_publicacao_voucher`) REFERENCES `grc_evento_publicacao_voucher` (`idt`) ON DELETE CASCADE ON UPDATE RESTRICT;

ALTER TABLE `grc_evento_publicacao_voucher_registro`
MODIFY COLUMN `cpf`  varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL AFTER `ativo`,
MODIFY COLUMN `nome_pessoa`  varchar(120) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL AFTER `cpf`;

-- 12/06/2017

DROP TABLE grc_evento_publicacao_cupons;

ALTER TABLE `grc_evento_publicacao_voucher_registro`
MODIFY COLUMN `idt_entidade_pf`  int(10) UNSIGNED NULL AFTER `numero`;

ALTER TABLE `grc_evento_publicacao_voucher_registro`
ADD COLUMN `dt_utilizacao`  datetime NULL AFTER `idt_entidade_pj`;

-- 19/06/2017

INSERT INTO `db_pir_grc`.`grc_evento_grupo` (`codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('00', 'Não', 'Não faz parte de um Evento de Grande Porte', 'S');

ALTER TABLE `grc_evento_publicacao_anexo` DROP FOREIGN KEY `FK_grc_evento_publicacao_anexo_1`;

ALTER TABLE `grc_evento_publicacao_anexo` ADD CONSTRAINT `FK_grc_evento_publicacao_anexo_1` FOREIGN KEY (`idt_evento_publicacao`) REFERENCES `grc_evento_publicacao` (`idt`) ON DELETE CASCADE ON UPDATE RESTRICT;

-- desenvolve

-- 14/08/2017

ALTER TABLE `grc_evento_grupo`
ADD COLUMN `arq_selo`  varchar(255) NULL AFTER `ativo`;

ALTER TABLE `grc_evento_publicacao_voucher`
MODIFY COLUMN `data_validade`  date NULL AFTER `descricao`,
ADD COLUMN `qtd_prazo`  int(10) UNSIGNED NULL AFTER `data_validade`;

INSERT INTO `db_pir_grc`.`plu_config` (`variavel`, `descricao`, `valor`, `extra`, `js`, `classificacao`) VALUES ('evento_publicacao_cupom_can', 'Aceita Cupom de Cancelamento?', 'Escolha na Política de Venda', NULL, 'N', 'POLÍTICA DE VENDAS');

insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_evento_publicacao_parametrizacao','Parametrização da Política de Venda','02.03.92','S','S','listar','listar');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_evento_publicacao_parametrizacao') as id_funcao
from plu_direito where cod_direito in ('con','alt');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_evento_publicacao_parametrizacao');

select idt INTO @idt_painel_grupo from plu_painel_grupo where idt_painel = 13 and codigo = '2';
select id_funcao INTO @id_funcao from plu_funcao where cod_funcao = 'grc_evento_publicacao_parametrizacao';

INSERT INTO `db_pir_grc`.`plu_painel_funcao` (`idt_painel_grupo`, `id_funcao`, `pos_top`, `pos_left`, `imagem`, `imagem_d`, `texto_cab`, `detalhe`, `visivel`, `hint`, `parametros`, `texto_font_tam`, `texto_ativ_font_cor`, `texto_ativ_fundo`, `texto_desativ_font_cor`, `texto_desativ_fundo`, `include`, `include_arq`, `include_altura`, `include_largura`) VALUES (@idt_painel_grupo, @id_funcao, '0', '0', NULL, NULL, 'Parametrização', NULL, 'S', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'N', NULL, NULL, NULL);

ALTER TABLE `grc_evento_publicacao`
ADD COLUMN `aceita_cupom_can`  char(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL AFTER `cupon_desconto`;

INSERT INTO `db_pir_grc`.`plu_config` (`variavel`, `descricao`, `valor`, `extra`, `js`, `classificacao`) VALUES ('evento_publicacao_limite_voucher_e', 'Máximo de Desconto para o Voucher E', '100,00', NULL, 'S', 'POLÍTICA DE VENDAS');

CREATE TABLE `grc_evento_cupom` (
  `idt` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `palavra_chave` varchar(45) NOT NULL,
  `data_validade` date NOT NULL,
  `perc_desconto` decimal(10,2) NOT NULL,
  `qtd_disponivel` int(10) unsigned NOT NULL,
  `qtd_resevada` int(10) unsigned NOT NULL,
  `qtd_utilizada` int(10) unsigned NOT NULL,
  PRIMARY KEY (`idt`),
  UNIQUE KEY `iu_grc_evento_cupom` (`palavra_chave`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_evento_cupom','Gestão de Cupons','02.03.93','S','S','listar','listar');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_evento_cupom') as id_funcao
from plu_direito where cod_direito in ('con','alt','inc','exc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_evento_cupom');

select id_funcao INTO @id_funcao from plu_funcao where cod_funcao = 'grc_evento_cupom';
select id_funcao INTO @id_funcao_del from plu_funcao where cod_funcao = 'grc_evento_publicacao_cupons';
update plu_painel_funcao set id_funcao = @id_funcao where id_funcao = @id_funcao_del;

delete from plu_funcao where cod_funcao = 'grc_evento_publicacao_cupons';

ALTER TABLE `grc_evento_cupom`
ADD COLUMN `ativo`  char(1) NOT NULL AFTER `palavra_chave`;

ALTER TABLE `grc_evento_cupom`
MODIFY COLUMN `qtd_disponivel`  int(10) NOT NULL AFTER `perc_desconto`,
MODIFY COLUMN `qtd_resevada`  int(10) NOT NULL DEFAULT 0 AFTER `qtd_disponivel`,
MODIFY COLUMN `qtd_utilizada`  int(10) NOT NULL DEFAULT 0 AFTER `qtd_resevada`;

TRUNCATE grc_evento_publicacao_cupom;

ALTER TABLE `grc_evento_publicacao_cupom`
DROP COLUMN `palavra_chave`,
DROP COLUMN `data_validade`,
DROP COLUMN `perc_desconto`,
CHANGE COLUMN `quantidade` `qtd_resevada`  int(10) NOT NULL AFTER `idt_evento_publicacao`,
ADD COLUMN `idt_evento_cupom`  int(10) UNSIGNED NOT NULL AFTER `idt_evento_publicacao`,
ADD COLUMN `qtd_disponivel`  int(10) NOT NULL AFTER `qtd_resevada`,
ADD COLUMN `qtd_utilizada`  int(10) NOT NULL AFTER `qtd_disponivel`,
DROP INDEX `iu_grc_evento_publicacao_cupom` ,
ADD UNIQUE INDEX `iu_grc_evento_publicacao_cupom` (`idt_evento_publicacao`, `idt_evento_cupom`) USING BTREE ;

ALTER TABLE `grc_evento_publicacao_cupom` ADD CONSTRAINT `fk_grc_evento_publicacao_cupom_2` FOREIGN KEY (`idt_evento_cupom`) REFERENCES `grc_evento_cupom` (`idt`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `grc_evento_publicacao_cupom`
MODIFY COLUMN `idt_evento_cupom`  int(10) UNSIGNED NULL AFTER `idt_evento_publicacao`,
MODIFY COLUMN `qtd_resevada`  int(10) NULL AFTER `idt_evento_cupom`,
MODIFY COLUMN `qtd_disponivel`  int(10) NULL AFTER `qtd_resevada`,
MODIFY COLUMN `qtd_utilizada`  int(10) NULL AFTER `qtd_disponivel`;

-- 16/08/2017

drop table grc_evento_combo_instrumento_evento;
drop table grc_evento_combo_instrumento;
drop table grc_evento_combo;

delete from plu_funcao where cod_funcao = 'grc_evento_combo_instrumento_evento';
delete from plu_funcao where cod_funcao = 'grc_evento_combo_instrumento';

CREATE TABLE `grc_evento_combo` (
  `idt` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idt_evento_combo` int(10) unsigned NOT NULL,
  `idt_evento` int(10) unsigned NOT NULL,
  `matricula_obr` char(1) NOT NULL,
  `vl_matricula` decimal(15,2) NOT NULL,
  PRIMARY KEY (`idt`),
  UNIQUE KEY `un_grc_evento_combo_1` (`idt_evento_combo`,`idt_evento`),
  KEY `fk_grc_evento_combo_2` (`idt_evento`),
  CONSTRAINT `fk_grc_evento_combo_1` FOREIGN KEY (`idt_evento_combo`) REFERENCES `grc_evento` (`idt`),
  CONSTRAINT `fk_grc_evento_combo_2` FOREIGN KEY (`idt_evento`) REFERENCES `grc_evento` (`idt`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

UPDATE `plu_funcao` SET `cod_classificacao`='02.03.59.05' WHERE cod_funcao = 'grc_evento_combo';

insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_evento_combo_cad','Cadastro do Combo de Evento','02.03.59','S','S','listar','listar');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_evento_combo_cad') as id_funcao
from plu_direito where cod_direito in ('con','alt','inc','exc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_evento_combo_cad');

select id_funcao INTO @id_funcao from plu_funcao where cod_funcao = 'grc_evento_combo_cad';
select id_funcao INTO @id_funcao_del from plu_funcao where cod_funcao = 'grc_evento_combo';
update plu_painel_funcao set id_funcao = @id_funcao where id_funcao = @id_funcao_del;

INSERT INTO `db_pir_grc`.`grc_atendimento_instrumento` (`codigo`, `codigo_siacweb`, `codigo_sge`, `codigo_familia_siac`, `codigo_tipoevento_siac`, `nivel`, `descricao`, `descricao_siacweb`, `ativo`, `detalhe`, `idt_atendimento_instrumento`, `balcao`, `contrapartida_sgtec`, `ordem_matriz`, `descricao_matriz`, `idt_produto_tipo`, `ordem_composto`) VALUES ('COMBO', NULL, NULL, NULL, NULL, '1', 'Evento Combo', NULL, 'N', NULL, NULL, 'N', NULL, NULL, NULL, NULL, '100');

-- 17/08/2017

ALTER TABLE `grc_evento_combo`
CHANGE COLUMN `vl_matricula` `perc_desconto`  decimal(15,2) NOT NULL AFTER `matricula_obr`,
ADD COLUMN `qtd_vaga`  int(10) NOT NULL AFTER `matricula_obr`,
ADD COLUMN `vl_evento`  decimal(15,2) NOT NULL AFTER `perc_desconto`,
ADD COLUMN `vl_matricula`  decimal(15,2) NOT NULL AFTER `vl_evento`;

ALTER TABLE `grc_evento_combo` DROP FOREIGN KEY `fk_grc_evento_combo_1`;

ALTER TABLE `grc_evento_combo`
CHANGE COLUMN `idt_evento_combo` `idt_evento_origem`  int(10) UNSIGNED NOT NULL AFTER `idt`,
DROP INDEX `un_grc_evento_combo_1` ,
ADD UNIQUE INDEX `un_grc_evento_combo_1` (`idt_evento_origem`, `idt_evento`) USING BTREE ;

ALTER TABLE `grc_evento_combo` ADD CONSTRAINT `fk_grc_evento_combo_1` FOREIGN KEY (`idt_evento_origem`) REFERENCES `grc_evento` (`idt`) ON DELETE RESTRICT ON UPDATE RESTRICT;

CREATE TABLE `grc_evento_combo_instrumento` (
  `idt` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idt_evento` int(10) unsigned NOT NULL,
  `idt_instrumento` int(10) unsigned NOT NULL,
  `qtd_min` int(10) unsigned NOT NULL,
  `qtd_max` int(10) unsigned NOT NULL,
  `qtd_atual` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`idt`),
  UNIQUE KEY `iu_grc_evento_combo_instrumento` (`idt_evento`,`idt_instrumento`) USING BTREE,
  KEY `fk_grc_evento_combo_instrumento_2` (`idt_instrumento`),
  CONSTRAINT `fk_grc_evento_combo_instrumento_1` FOREIGN KEY (`idt_evento`) REFERENCES `grc_evento` (`idt`) ON DELETE CASCADE,
  CONSTRAINT `fk_grc_evento_combo_instrumento_2` FOREIGN KEY (`idt_instrumento`) REFERENCES `grc_atendimento_instrumento` (`idt`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `grc_evento`
ADD COLUMN `qtd_evento_insc_combo`  int(10) NULL AFTER `qtd_vagas_adicional`;

-- 18/08/2017

ALTER TABLE `grc_evento_combo`
ADD COLUMN `situacao`  char(2) NOT NULL AFTER `idt_evento`;

ALTER TABLE `grc_atendimento_pendencia`
ADD COLUMN `idt_evento_combo_origem`  int(10) UNSIGNED NULL DEFAULT NULL AFTER `idt_evento`;

ALTER TABLE `grc_atendimento_pendencia` ADD CONSTRAINT `FK_grc_atendimento_pendencia_17` FOREIGN KEY (`idt_evento_combo_origem`) REFERENCES `grc_evento` (`idt`) ON DELETE RESTRICT ON UPDATE RESTRICT;

UPDATE `grc_evento_situacao` SET `descricao`='APROVADO', `ativo`='S' WHERE (`idt`='15');

-- 19/08/2017

ALTER TABLE `grc_evento_combo`
ADD COLUMN `qtd_utilizada`  int(10) NOT NULL DEFAULT 0 AFTER `qtd_vaga`;

-- 21/08/2017

insert into grc_evento_natureza_pagamento_instrumento (idt_evento_natureza_pagamento, idt_atendimento_instrumento)
select p.idt as idt_evento_natureza_pagamento, i.idt as idt_atendimento_instrumento
from grc_atendimento_instrumento i, grc_evento_natureza_pagamento p
where i.idt in (54)
and p.idt <> 8
order by p.idt, i.idt;

-- 22/08/2017

ALTER TABLE `grc_evento_natureza_pagamento`
MODIFY COLUMN `ativo`  char(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'S' AFTER `detalhe`,
ADD COLUMN `desconto`  char(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'N' AFTER `ativo`;

ALTER TABLE `grc_evento_natureza_pagamento`
MODIFY COLUMN `rm_idformapagto`  int(10) NULL AFTER `desconto`;

insert into plu_painel_funcao (
idt_painel_grupo, id_funcao, pos_top, pos_left, texto_cab, detalhe, visivel, hint, parametros, texto_font_tam, texto_ativ_font_cor,
texto_ativ_fundo, texto_desativ_font_cor, texto_desativ_fundo, include, include_arq, include_altura, include_largura
)
SELECT idt_painel_grupo, 737 as id_funcao, pos_top, pos_left, 'Forma de Parcelamento' as texto_cab, detalhe, visivel, hint, parametros, texto_font_tam, texto_ativ_font_cor,
texto_ativ_fundo, texto_desativ_font_cor, texto_desativ_fundo, include, include_arq, include_altura, include_largura FROM `plu_painel_funcao` where id_funcao = 735;

ALTER TABLE `grc_evento_forma_parcelamento`
MODIFY COLUMN `rm_codcpg`  int(10) NULL AFTER `valor_ini`;

INSERT INTO `db_pir_grc`.`grc_evento_natureza_pagamento` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`, `desconto`, `rm_idformapagto`, `lojasiac_modalidade`) VALUES ('9', 'DES_CUPOM', 'Desconto por Cupom', NULL, 'S', 'S', NULL, NULL);
INSERT INTO `db_pir_grc`.`grc_evento_natureza_pagamento` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`, `desconto`, `rm_idformapagto`, `lojasiac_modalidade`) VALUES ('10', 'DES_VOUCHER', 'Desconto por Voucher', NULL, 'S', 'S', NULL, NULL);

INSERT INTO `db_pir_grc`.`grc_evento_forma_parcelamento` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`, `idt_natureza`, `numero_de_parcelas`, `valor_ate`, `valor_ini`, `rm_codcpg`) VALUES ('17', 'Desconto', 'Desconto', NULL, 'S', '9', '1', '0.00', '0.00', NULL);
INSERT INTO `db_pir_grc`.`grc_evento_forma_parcelamento` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`, `idt_natureza`, `numero_de_parcelas`, `valor_ate`, `valor_ini`, `rm_codcpg`) VALUES ('18', 'Desconto', 'Desconto', NULL, 'S', '10', '1', '0.00', '0.00', NULL);

ALTER TABLE `grc_evento_participante_pagamento`
ADD COLUMN `desconto_codigo`  varchar(45) NULL AFTER `par_estado`,
ADD COLUMN `idt_evento_publicacao_cupom`  int(10) UNSIGNED NULL AFTER `desconto_codigo`;

ALTER TABLE `grc_evento_participante_pagamento` ADD CONSTRAINT `grc_evento_participante_pagamento_ibfk_9` FOREIGN KEY (`idt_evento_publicacao_cupom`) REFERENCES `grc_evento_publicacao_cupom` (`idt`) ON DELETE RESTRICT ON UPDATE RESTRICT;

-- 23/08/2017

ALTER TABLE `grc_evento_publicacao_voucher_registro`
ADD COLUMN `idt_matricula_gerado`  int(10) UNSIGNED NULL AFTER `dt_utilizacao`,
ADD COLUMN `idt_matricula_utilizado`  int(10) UNSIGNED NULL AFTER `idt_matricula_gerado`;

ALTER TABLE `grc_evento_publicacao_voucher_registro` ADD CONSTRAINT `fk_grc_evento_publicacao_voucher_registro_5` FOREIGN KEY (`idt_matricula_gerado`) REFERENCES `grc_atendimento` (`idt`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `grc_evento_publicacao_voucher_registro` ADD CONSTRAINT `fk_grc_evento_publicacao_voucher_registro_6` FOREIGN KEY (`idt_matricula_utilizado`) REFERENCES `grc_atendimento` (`idt`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `grc_evento_participante`
ADD COLUMN `gerar_voucher_a`  char(1) NULL AFTER `vl_tot_pagamento_real`;

ALTER TABLE `grc_evento`
MODIFY COLUMN `quantidade_participante`  int(10) NULL DEFAULT NULL AFTER `participante_maximo`;

-- 25/08/2017

ALTER TABLE `grc_evento_publicacao_voucher_registro`
ADD COLUMN `ativo`  char(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'S' AFTER `numero`;

ALTER TABLE `grc_evento_participante_pagamento`
ADD COLUMN `so_consulta`  char(1) NOT NULL DEFAULT 'N' AFTER `idt_evento_publicacao_cupom`;

-- 26/08/2017

ALTER TABLE `grc_evento_participante`
ADD COLUMN `gerar_voucher_e`  char(1) NULL AFTER `gerar_voucher_a`;

-- 28/08/2017

ALTER TABLE `grc_evento_participante`
ADD COLUMN `numero_voucher_e`  varchar(45) NULL AFTER `gerar_voucher_e`;

ALTER TABLE `grc_evento_publicacao_voucher_registro`
ADD COLUMN `data_validade`  date NOT NULL AFTER `idt_entidade_pj`;

UPDATE grc_evento_publicacao_voucher_registro vr
INNER JOIN grc_evento_publicacao_voucher v ON v.idt = vr.idt_evento_publicacao_voucher
SET vr.data_validade = v.data_validade
WHERE
	v.data_validade IS NOT NULL;

INSERT INTO `db_pir_grc`.`grc_evento_natureza_pagamento` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`, `desconto`, `rm_idformapagto`, `lojasiac_modalidade`) VALUES ('11', 'DES_PORTE', 'Desconto por Porte', NULL, 'S', 'S', NULL, NULL);
INSERT INTO `db_pir_grc`.`grc_evento_forma_parcelamento` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`, `idt_natureza`, `numero_de_parcelas`, `valor_ate`, `valor_ini`, `rm_codcpg`) VALUES ('19', 'Desconto', 'Desconto', NULL, 'S', '11', '1', '0.00', '0.00', NULL);

ALTER TABLE `grc_evento_publicacao_mapa_assento`
ADD COLUMN `idt_matricula_utilizado`  int(10) UNSIGNED NULL DEFAULT NULL AFTER `mapa_assento`;

ALTER TABLE `grc_evento_publicacao_mapa_assento` ADD CONSTRAINT `FK_grc_evento_publicacao_mapa_assento_3` FOREIGN KEY (`idt_matricula_utilizado`) REFERENCES `grc_atendimento` (`idt`) ON DELETE RESTRICT ON UPDATE RESTRICT;

-- 05/09/2017

update grc_atendimento_pendencia set tipo = 'Política de Desconto do Evento' where tipo = 'Política de Venda do Evento';
update plu_config set classificacao = 'POLÍTICA DE DESCONTO' where classificacao = 'POLÍTICA DE VENDAS';

ALTER TABLE `grc_evento_publicacao`
MODIFY COLUMN `data_publicacao_de`  datetime NULL DEFAULT NULL AFTER `ativo`,
MODIFY COLUMN `data_publicacao_ate`  datetime NULL DEFAULT NULL AFTER `data_publicacao_de`,
MODIFY COLUMN `data_hora_fim_inscricao_ec`  datetime NULL DEFAULT NULL AFTER `data_publicacao_ate`;

delete from grc_evento_publicacao_publico;

ALTER TABLE `grc_evento_publicacao_publico` DROP FOREIGN KEY `fk_grc_evento_publicacao_publico_2`;

ALTER TABLE `grc_evento_publicacao_publico` DROP FOREIGN KEY `fk_grc_evento_publicacao_publico_3`;

ALTER TABLE `grc_evento_publicacao_publico`
DROP COLUMN `idt_entidade_pf`,
DROP COLUMN `idt_entidade_pj`,
ADD COLUMN `cpf`  varchar(20) NOT NULL AFTER `idt_evento_publicacao`,
ADD COLUMN `nome_pessoa`  varchar(120) NOT NULL AFTER `cpf`,
DROP INDEX `fk_grc_evento_publicacao_publico_2`,
DROP INDEX `fk_grc_evento_publicacao_publico_3`,
DROP INDEX `iu_grc_evento_publicacao_publico` ,
ADD UNIQUE INDEX `iu_grc_evento_publicacao_publico` (`idt_evento_publicacao`, `cpf`) USING BTREE ,
AUTO_INCREMENT=1;

-- 06/09/2017

delete from grc_evento_publicacao_voucher_registro;

ALTER TABLE `grc_evento_publicacao_voucher_registro` DROP FOREIGN KEY `fk_grc_evento_publicacao_voucher_registro_1`;

ALTER TABLE `grc_evento_publicacao_voucher_registro` DROP FOREIGN KEY `fk_grc_evento_publicacao_voucher_registro_2`;

ALTER TABLE `grc_evento_publicacao_voucher_registro`
DROP COLUMN `idt_entidade_pf`,
DROP COLUMN `idt_entidade_pj`,
ADD COLUMN `cpf`  varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL AFTER `ativo`,
ADD COLUMN `nome_pessoa`  varchar(120) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL AFTER `cpf`,
DROP INDEX `fk_grc_evento_publicacao_voucher_registro_1`,
DROP INDEX `fk_grc_evento_publicacao_voucher_registro_2`,
DROP INDEX `iu_grc_evento_publicacao_voucher_registro` ,
ADD UNIQUE INDEX `iu_grc_evento_publicacao_voucher_registro` (`idt_evento_publicacao`, `cpf`) USING BTREE ,
AUTO_INCREMENT=1;

ALTER TABLE `grc_evento_publicacao_voucher_registro`
ADD COLUMN `idt_entidade_pj`  int(10) UNSIGNED NULL AFTER `idt_matricula_utilizado`;

ALTER TABLE `grc_evento_publicacao_voucher_registro` ADD CONSTRAINT `fk_grc_evento_publicacao_voucher_registro_1` FOREIGN KEY (`idt_entidade_pj`) REFERENCES `db_pir_gec`.`gec_entidade` (`idt`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `grc_evento_publicacao_voucher`
ADD COLUMN `qtd_prazo_indicado`  int(10) UNSIGNED NULL DEFAULT NULL AFTER `quantidade`,
ADD COLUMN `perc_desconto_indicado`  decimal(10,2) NULL AFTER `qtd_prazo_indicado`;

-- 08/09/2017

ALTER TABLE `grc_evento_publicacao_voucher`
MODIFY COLUMN `quantidade`  int(10) UNSIGNED NULL AFTER `perc_desconto`;

UPDATE `plu_funcao` SET `nm_funcao`='Política de Desconto' WHERE `cod_funcao` = 'grc_evento_publicacao';
UPDATE `plu_funcao` SET `nm_funcao`='Política de Desconto Mapa' WHERE `cod_funcao` = 'grc_evento_publicacao_mapa';
UPDATE `plu_funcao` SET `nm_funcao`='Política de Desconto Mapa - Assento' WHERE `cod_funcao` = 'grc_evento_publicacao_mapa_assento';
UPDATE `plu_funcao` SET `nm_funcao`='Política de Desconto Anexos' WHERE `cod_funcao` = 'grc_evento_publicacao_anexo';
UPDATE `plu_funcao` SET `nm_funcao`='Política de Desconto Cupom de Desconto' WHERE `cod_funcao` = 'grc_evento_publicacao_cupom';
UPDATE `plu_funcao` SET `nm_funcao`='Política de Desconto Voucher' WHERE `cod_funcao` = 'grc_evento_publicacao_voucher';
UPDATE `plu_funcao` SET `nm_funcao`='Política de Desconto Público' WHERE `cod_funcao` = 'grc_evento_publicacao_publico';
UPDATE `plu_funcao` SET `nm_funcao`='Política de Desconto Voucher - Registro' WHERE `cod_funcao` = 'grc_evento_publicacao_voucher_registro';
UPDATE `plu_funcao` SET `nm_funcao`='Parametrização da Política de Desconto' WHERE `cod_funcao` = 'grc_evento_publicacao_parametrizacao';

update plu_painel_funcao set visivel = 'N' where texto_cab = 'Categoria do Assento';

ALTER TABLE `grc_evento_local_pa_tipo_assento`
ADD COLUMN `img_ocupado`  varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL AFTER `imagem_d`;

UPDATE `grc_evento_local_pa_tipo_assento` SET `codigo`= concat('0', codigo);

INSERT INTO `db_pir_grc`.`plu_autonum` (`codigo`, `idt`) VALUES ('grc_evento_local_pa_tipo_assento_codigo', '3');

ALTER TABLE `grc_evento_local_pa_tipo_assento`
ADD COLUMN `pode_ocupar`  char(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'S' AFTER `ativo`;

UPDATE `grc_atendimento_instrumento` SET `descricao`='Combo' WHERE (`idt`='54');

-- 09/09/2017

ALTER TABLE `grc_evento`
ADD COLUMN `tipo_combo`  char(1) NULL AFTER `qtd_evento_insc_combo`;

CREATE TABLE `grc_evento_combo_unidade` (
  `idt` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idt_evento` int(10) unsigned NOT NULL,
  `idt_unidade` int(11) NOT NULL,
  `qtd_evento` int(10) unsigned NOT NULL,
  `situacao` char(2) NOT NULL,
  `idt_usuario_aprovacao` int(10) DEFAULT NULL,
  `dt_aprovacao` datetime DEFAULT NULL,
  PRIMARY KEY (`idt`),
  UNIQUE KEY `iu_grc_evento_combo_unidade` (`idt_evento`,`idt_unidade`) USING BTREE,
  KEY `fk_grc_evento_combo_unidade_2` (`idt_unidade`),
  KEY `fk_grc_evento_combo_unidade_3` (`idt_usuario_aprovacao`),
  CONSTRAINT `fk_grc_evento_combo_unidade_1` FOREIGN KEY (`idt_evento`) REFERENCES `grc_evento` (`idt`) ON DELETE CASCADE,
  CONSTRAINT `fk_grc_evento_combo_unidade_2` FOREIGN KEY (`idt_unidade`) REFERENCES `db_pir`.`sca_organizacao_secao` (`idt`),
  CONSTRAINT `fk_grc_evento_combo_unidade_3` FOREIGN KEY (`idt_usuario_aprovacao`) REFERENCES `plu_usuario` (`id_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- 11/09/2017

ALTER TABLE `grc_atendimento_pendencia`
ADD COLUMN `idt_responsavel_unidade_lotacao`  int(11) NULL DEFAULT NULL AFTER `data_solucao`;

ALTER TABLE `grc_atendimento_pendencia` ADD CONSTRAINT `FK_grc_atendimento_pendencia_18` FOREIGN KEY (`idt_responsavel_unidade_lotacao`) REFERENCES `db_pir`.`sca_organizacao_secao` (`idt`) ON DELETE RESTRICT ON UPDATE RESTRICT;

INSERT INTO `db_pir_grc`.`grc_produto_publico_alvo` (`idt`, `idt_publico_alvo_outro`)
select idt, idt_publico_alvo as idt_publico_alvo_outro from grc_produto
where idt_publico_alvo is not null;

ALTER TABLE `grc_evento_publicacao_voucher_registro`
MODIFY COLUMN `cpf`  varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL AFTER `ativo`,
MODIFY COLUMN `nome_pessoa`  varchar(120) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL AFTER `cpf`;

ALTER TABLE `grc_evento_combo_unidade`
MODIFY COLUMN `situacao`  char(2) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL AFTER `qtd_evento`;

CREATE TABLE `grc_evento_publico_alvo` (
  `idt` int(10) unsigned NOT NULL,
  `idt_publico_alvo_outro` int(10) unsigned NOT NULL,
  PRIMARY KEY (`idt`,`idt_publico_alvo_outro`),
  KEY `fk_grc_evento_publico_alvo_2` (`idt_publico_alvo_outro`) USING BTREE,
  CONSTRAINT `fk_grc_evento_publico_alvo_1` FOREIGN KEY (`idt`) REFERENCES `grc_evento` (`idt`) ON DELETE CASCADE,
  CONSTRAINT `fk_grc_evento_publico_alvo_2` FOREIGN KEY (`idt_publico_alvo_outro`) REFERENCES `grc_publico_alvo` (`idt`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `grc_evento_publico_alvo`
ADD COLUMN `ativo`  char(1) NOT NULL DEFAULT 'S' AFTER `idt_publico_alvo_outro`;

INSERT INTO `db_pir_grc`.`grc_evento_publico_alvo` (`idt`, `idt_publico_alvo_outro`)
select e.idt, a.idt_publico_alvo_outro 
from grc_evento e inner join grc_produto_publico_alvo a on a.idt = e.idt_produto
union
select idt, idt_publico_alvo as idt_publico_alvo_outro from grc_evento
where idt_publico_alvo is not null;

-- 13/09/2017

ALTER TABLE `grc_evento_publicacao_publico_alvo`
ADD COLUMN `ativo`  char(1) NOT NULL DEFAULT 'S' AFTER `idt_publico_alvo`;

INSERT INTO `db_pir_grc`.`grc_evento_publicacao_publico_alvo` (`idt`, `idt_publico_alvo`)
select e.idt, a.idt_publico_alvo_outro as idt_publico_alvo
from grc_evento_publicacao e inner join grc_evento_publico_alvo a on a.idt = e.idt_evento
where a.ativo = 'S';

-- 15/09/2017

ALTER TABLE `grc_evento_participante`
CHANGE COLUMN `numero_voucher_e` `usado_numero_voucher_e`  varchar(45) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL AFTER `gerar_voucher_a`;

ALTER TABLE `grc_evento_participante`
ADD COLUMN `email_indicado`  varchar(255) NULL AFTER `gerar_voucher_e`,
ADD COLUMN `idt_voucher_e_indicado`  int(10) UNSIGNED NULL AFTER `email_indicado`,
ADD COLUMN `idt_voucher_e_indicador`  int(10) UNSIGNED NULL AFTER `idt_voucher_e_indicado`;

ALTER TABLE `grc_evento_participante` ADD CONSTRAINT `FK_grc_evento_participante_5` FOREIGN KEY (`idt_voucher_e_indicado`) REFERENCES `grc_evento_publicacao_voucher_registro` (`idt`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `grc_evento_participante` ADD CONSTRAINT `FK_grc_evento_participante_6` FOREIGN KEY (`idt_voucher_e_indicador`) REFERENCES `grc_evento_publicacao_voucher_registro` (`idt`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `grc_evento_publicacao_voucher`
CHANGE COLUMN `qtd_prazo_indicado` `qtd_prazo_indicador`  int(10) UNSIGNED NULL DEFAULT NULL AFTER `quantidade`,
CHANGE COLUMN `perc_desconto_indicado` `perc_desconto_indicador`  decimal(10,2) NULL DEFAULT NULL AFTER `qtd_prazo_indicador`;

INSERT INTO `db_pir_grc`.`grc_parametros` (`codigo`, `descricao`, `ativo`, `html`, `detalhe`, `classificacao`) VALUES ('voucher_e_email_01', 'Assunto do email da Indicar Amigo (Voucher E)', 'S', 'N', 'Evento do Sebrae indicado pelo Amigo', '07.01');
INSERT INTO `db_pir_grc`.`grc_parametros` (`codigo`, `descricao`, `ativo`, `html`, `detalhe`, `classificacao`) VALUES ('voucher_e_email_02', 'Mensagem do email da Indicar Amigo (Voucher E)', 'S', 'S', '<p>Caro(a)<br />\r\n<br />\r\nEste evento foi indicado por <strong>#nome_pessoa#</strong>.<br />\r\n<br />\r\nPara se inscrever neste evento procure o Sebrae e informe o N&uacute;mero do Voucher para poder ganhar o desconto.<br />\r\n<br />\r\nN&uacute;mero do Voucher: #numero_voucher#<br />\r\nV&aacute;lido at&eacute; #validade_voucher#<br />\r\nDesconto de #desconto_voucher#%<br />\r\n<br />\r\nInforma&ccedil;&otilde;es sobre o Evento:<br />\r\n<br />\r\n<strong>C&oacute;digo do Evento:</strong><br />\r\n#codigo#<br />\r\n<strong> T&iacute;tulo do Evento:</strong><br />\r\n#descricao#<br />\r\n<strong>Data de Realiza&ccedil;&atilde;o:</strong><br />\r\n#dt_previsao_inicial# #hora_inicio# a #dt_previsao_fim# #hora_fim#<br />\r\n<strong> Local/Cidade:</strong><br />\r\n#local# / #cidade#<br />\r\n<strong>Data de Abertura:</strong><br />\r\n#dt_previsao_inicial#<br />\r\n<br />\r\nCordialmente,<br />\r\n<br />\r\nEquipe gestora da Plataforma Integrada de Relacionamento<br />\r\nUnidade de Atendimento Individual - DIRAT<br />\r\nUnidade de Tecnologia da Informa&ccedil;&atilde;o e Comunica&ccedil;&atilde;o - DISUP<br />\r\nSebrae - Bahia<br />\r\n<br />\r\n<strong>IMPORTANTE:</strong> Mensagem autom&aacute;tica do sistema. N&atilde;o responda!<br />\r\n<br />\r\nProtocolo de controle: #protocolo#</p>', '07.02');

ALTER TABLE `grc_evento`
ADD COLUMN `qtd_vagas_extra`  int(10) NOT NULL DEFAULT 0 AFTER `qtd_vagas_adicional`;

UPDATE `grc_evento_participante_pagamento` SET `idt_evento_natureza_pagamento`='9' WHERE idt_evento_natureza_pagamento in (10, 11);
delete from `grc_evento_forma_parcelamento` WHERE idt_natureza in (10, 11);
delete from `grc_evento_natureza_pagamento` WHERE idt in (10, 11);

UPDATE `grc_evento_natureza_pagamento` SET `codigo`='DES', `descricao`='Desconto Utilizado' WHERE (`idt`='9');

ALTER TABLE `grc_evento_participante_pagamento` DROP FOREIGN KEY `grc_evento_participante_pagamento_ibfk_9`;

ALTER TABLE `grc_evento_participante_pagamento`
DROP COLUMN `desconto_codigo`,
DROP COLUMN `idt_evento_publicacao_cupom`,
DROP INDEX `grc_evento_participante_pagamento_ibfk_9`;

ALTER TABLE `grc_evento_participante`
ADD COLUMN `codigo_cupom`  varchar(45) NULL AFTER `idt_voucher_e_indicador`;

ALTER TABLE `grc_evento_participante`
ADD COLUMN `idt_evento_publicacao_cupom`  int(10) UNSIGNED NULL AFTER `codigo_cupom`;

ALTER TABLE `grc_evento_participante` ADD CONSTRAINT `FK_grc_evento_participante_7` FOREIGN KEY (`idt_evento_publicacao_cupom`) REFERENCES `grc_evento_publicacao_cupom` (`idt`) ON DELETE RESTRICT ON UPDATE RESTRICT;

CREATE TABLE `grc_evento_participante_desconto` (
  `idt` int(10) unsigned NOT NULL,
  `idt_atendimento` int(10) unsigned NOT NULL,
  `codigo` varchar(45) NOT NULL,
  `descricao` varchar(100) NOT NULL,
  `percentual` decimal(10,2) NOT NULL,
  PRIMARY KEY (`idt`),
  UNIQUE KEY `un_grc_evento_participante_desconto` (`idt_atendimento`,`codigo`),
  CONSTRAINT `fk_grc_evento_participante_desconto_1` FOREIGN KEY (`idt_atendimento`) REFERENCES `grc_atendimento` (`idt`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 16/07/2017

ALTER TABLE `grc_evento_participante_desconto`
MODIFY COLUMN `idt`  int(10) UNSIGNED NOT NULL AUTO_INCREMENT FIRST ;

-- 19/09/2017

-- Copiado do arquivo OS013 Lupe.sql

-- 29-06-2017

CREATE TABLE `db_pir_grc`.`grc_politica_vendas` (
  `idt` INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  `codigo` VARCHAR(45) NOT NULL,
  `descricao` VARCHAR(45) NOT NULL,
  `ativo` CHAR(1) NOT NULL DEFAULT 'S',
  `detalhe` TEXT,
  PRIMARY KEY (`idt`),
  UNIQUE INDEX `iu_grc_politica_vendas`(`codigo`)
)
ENGINE = InnoDB;

--

CREATE TABLE `db_pir_grc`.`grc_politica_vendas_tabelas` (
  `idt` INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  `idt_politica_vendas` INTEGER UNSIGNED NOT NULL,
  `codigo` VARCHAR(45) NOT NULL,
  `descricao` VARCHAR(120) NOT NULL,
  `ativo` CHAR(1) NOT NULL DEFAULT 'S',
  `detalhe` TEXT,
  PRIMARY KEY (`idt`),
  UNIQUE INDEX `iu_grc_politica_vendas_tabelas`(`idt_politica_vendas`, `codigo`),
  CONSTRAINT `FK_grc_politica_vendas_tabelas_1` FOREIGN KEY `FK_grc_politica_vendas_tabelas_1` (`idt_politica_vendas`)
    REFERENCES `grc_politica_vendas` (`idt`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT
)
ENGINE = InnoDB;



insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_politica_vendas_tabelas','Política de Vendas - Tabelas','84.03.03','N','N','listar','listar');
insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_politica_vendas_tabelas') as id_funcao
from plu_direito where cod_direito in ('con','alt','inc','exc');
insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_politica_vendas_tabelas');


ALTER TABLE `db_pir_grc`.`grc_politica_vendas_tabelas` ADD COLUMN `alias` VARCHAR(45) NOT NULL AFTER `detalhe`
, AUTO_INCREMENT = 1;

ALTER TABLE `db_pir_grc`.`grc_politica_vendas_tabelas` MODIFY COLUMN `codigo` VARCHAR(120) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;




CREATE TABLE `db_pir_grc`.`grc_politica_vendas_campos` (
  `idt` INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  `idt_politica_vendas` INTEGER UNSIGNED NOT NULL,
  `codigo` VARCHAR(120) NOT NULL,
  `descricao` VARCHAR(120) NOT NULL,
  `alias` VARCHAR(45) NOT NULL,
  `ativo` CHAR(1) NOT NULL DEFAULT 'S',
  `detalhe` TEXT,
  PRIMARY KEY (`idt`),
  UNIQUE INDEX `iu_grc_politica_vendas_campos`(`idt_politica_vendas`, `codigo`),
  CONSTRAINT `FK_grc_politica_vendas_campos_1` FOREIGN KEY `FK_grc_politica_vendas_campos_1` (`idt_politica_vendas`)
    REFERENCES `grc_politica_vendas` (`idt`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT
)
ENGINE = InnoDB;


insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_politica_vendas_campos','Política de Vendas - Campos','84.03.05','N','N','listar','listar');
insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_politica_vendas_campos') as id_funcao
from plu_direito where cod_direito in ('con','alt','inc','exc');
insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_politica_vendas_campos');


ALTER TABLE `db_pir_grc`.`grc_politica_vendas_campos` MODIFY COLUMN `codigo` VARCHAR(5000) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
 MODIFY COLUMN `descricao` VARCHAR(120) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
 MODIFY COLUMN `alias` VARCHAR(45) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
 MODIFY COLUMN `detalhe` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci,
 DROP INDEX `iu_grc_politica_vendas_campos`,
 ADD UNIQUE INDEX `iu_grc_politica_vendas_campos` USING BTREE(`idt_politica_vendas`, `alias`);
 
 
 
 
 
 
 
 CREATE TABLE `db_pir_grc`.`grc_politica_vendas_condicao` (
  `idt` INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  `idt_politica_vendas` INTEGER UNSIGNED NOT NULL,
  `codigo` VARCHAR(5000) NOT NULL,
  `descricao` VARCHAR(120) NOT NULL,
  `ordem` VARCHAR(45) NOT NULL,
  `parentese_ant` CHAR(1) NULL,
  `parentese_dep` CHAR(1) NULL,
  `condicao` VARCHAR(45) NOT NULL,
  `valor` VARCHAR(5000) NOT NULL,
  `ativo` CHAR(1) NOT NULL DEFAULT 'S',
  `detalhe` TEXT,
  PRIMARY KEY (`idt`),
  UNIQUE INDEX `iu_grc_politica_vendas_condicao`(`idt_politica_vendas`, `ordem`),
  CONSTRAINT `FK_grc_politica_vendas_condicao_1` FOREIGN KEY `FK_grc_politica_vendas_condicao_1` (`idt_politica_vendas`)
    REFERENCES `grc_politica_vendas` (`idt`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT
)
ENGINE = InnoDB;


insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_politica_vendas_condicao','Política de Vendas - Condição','84.03.07','N','N','listar','listar');
insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_politica_vendas_condicao') as id_funcao
from plu_direito where cod_direito in ('con','alt','inc','exc');
insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_politica_vendas_condicao');


ALTER TABLE `db_pir_grc`.`grc_politica_vendas_condicao` ADD COLUMN `operador` CHAR(2) AFTER `detalhe`;

ALTER TABLE `db_pir_grc`.`grc_politica_vendas_condicao` MODIFY COLUMN `descricao` VARCHAR(120) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL;

ALTER TABLE `db_pir_grc`.`grc_politica_vendas_condicao` MODIFY COLUMN `ordem` INTEGER UNSIGNED NOT NULL
, AUTO_INCREMENT = 1;


ALTER TABLE `db_pir_grc`.`grc_politica_vendas` ADD COLUMN `idt_responsavel` INTEGER UNSIGNED NOT NULL AFTER `detalhe`,
 ADD COLUMN `data_responsavel` DATETIME NOT NULL AFTER `idt_responsavel`;

ALTER TABLE `db_pir_grc`.`grc_politica_vendas` ADD COLUMN `data_inicio` DATE NOT NULL AFTER `data_responsavel`,
 ADD COLUMN `data_fim` DATE AFTER `data_inicio`;

ALTER TABLE `db_pir_grc`.`grc_politica_vendas` ADD COLUMN `status` CHAR(2) NOT NULL DEFAULT 'CA' AFTER `data_fim`;





CREATE TABLE `db_pir_grc`.`grc_politica_parametro_tabelas` (
  `idt` INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  `codigo` VARCHAR(45) NOT NULL,
  `descricao` VARCHAR(120) NOT NULL,
  `ativo` CHAR(1) NOT NULL DEFAULT 'S',
  `detalhe` TEXT,
  PRIMARY KEY (`idt`),
  UNIQUE INDEX `iu_grc_politica_parametro_tabelas`(`codigo`)
    
)
ENGINE = InnoDB;



insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_politica_parametro_tabelas','Política de Vendas - Parâmetro Tabelas','84.03.20','S','S','listar','listar');
insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_politica_parametro_tabelas') as id_funcao
from plu_direito where cod_direito in ('con','alt','inc','exc');
insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_politica_parametro_tabelas');



CREATE TABLE `db_pir_grc`.`grc_politica_parametro_campos` (
  `idt` INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  `idt_politica_parametro_tabelas` INTEGER UNSIGNED NOT NULL,
  `codigo` VARCHAR(120) NOT NULL,
  `descricao` VARCHAR(120) NOT NULL,
  `alias` VARCHAR(45) NOT NULL,
  `ativo` CHAR(1) NOT NULL DEFAULT 'S',
  `detalhe` TEXT,
  PRIMARY KEY (`idt`),
  UNIQUE INDEX `iu_grc_politica_parametro_campos`(`idt_politica_parametro_tabelas`, `codigo`),
  CONSTRAINT `FK_grc_politica_parametro_campos_1` FOREIGN KEY `FK_grc_politica_parametro_campos_1` (`idt_politica_parametro_tabelas`)
    REFERENCES `grc_politica_parametro_campos` (`idt`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT
)
ENGINE = InnoDB;

insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_politica_parametro_campos','Política de Vendas - Parâmetro Tabelas Campos','84.03.23','N','N','listar','listar');
insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_politica_parametro_campos') as id_funcao
from plu_direito where cod_direito in ('con','alt','inc','exc');
insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_politica_parametro_campos');

ALTER TABLE `db_pir_grc`.`grc_politica_parametro_tabelas` ADD COLUMN `alias` VARCHAR(120) NOT NULL AFTER `detalhe`;

-- 13-09-2017

CREATE TABLE `db_pir_grc`.`grc_politica_vendas_eventos` (
  `idt` INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  `idt_politica_vendas` INTEGER UNSIGNED NOT NULL,
  `idt_evento` INTEGER UNSIGNED NOT NULL,
  `descricao` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`idt`),
  INDEX `iu_grc_politica_vendas_eventos`(`idt_politica_vendas`, `idt_evento`),
  CONSTRAINT `FK_grc_politica_vendas_eventos_1` FOREIGN KEY `FK_grc_politica_vendas_eventos_1` (`idt_politica_vendas`)
    REFERENCES `grc_politica_vendas` (`idt`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT,
  CONSTRAINT `FK_grc_politica_vendas_eventos_2` FOREIGN KEY `FK_grc_politica_vendas_eventos_2` (`idt_evento`)
    REFERENCES `grc_evento` (`idt`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT
)
ENGINE = InnoDB;

insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_politica_vendas_eventos','Política de Vendas - Eventos','84.03.08','N','N','listar','listar');
insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_politica_vendas_eventos') as id_funcao
from plu_direito where cod_direito in ('con','alt','inc','exc');
insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_politica_vendas_eventos');


ALTER TABLE `db_pir_grc`.`grc_politica_vendas_eventos` MODIFY COLUMN `descricao` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL;

ALTER TABLE `db_pir_grc`.`grc_politica_vendas` ADD COLUMN `desconto_percentual` NUMERIC(15,2) NOT NULL AFTER `status`;

ALTER TABLE `db_pir_grc`.`grc_politica_parametro_campos` ADD COLUMN `status` CHAR(1) NOT NULL DEFAULT 'A' AFTER `detalhe`;

ALTER TABLE `db_pir_grc`.`grc_politica_vendas_condicao` ADD COLUMN `tipo` CHAR(45) NOT NULL DEFAULT 'P' AFTER `operador`;


insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_politica_vendas_condicao_matricula','Política de Vendas - Condicao Matricula','84.03.09','N','N','listar','listar');
insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_politica_vendas_condicao_matricula') as id_funcao
from plu_direito where cod_direito in ('con','alt','inc','exc');
insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_politica_vendas_condicao_matricula');

ALTER TABLE `db_pir_grc`.`grc_politica_vendas_condicao` DROP INDEX `iu_grc_politica_vendas_condicao`,
 ADD UNIQUE INDEX `iu_grc_politica_vendas_condicao` USING BTREE(`idt_politica_vendas`, `ordem`, `tipo`);


ALTER TABLE `db_pir_grc`.`grc_politica_parametro_campos` ADD COLUMN `selecao` CHAR(1) NOT NULL DEFAULT 'S' AFTER `status`,
 ADD COLUMN `tipo` VARCHAR(45) AFTER `selecao`;

-- Fim da Copiado do arquivo OS013 Lupe.sql

insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_politica_vendas','Política de Vendas','84.03','N','N','listar','listar');
insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_politica_vendas') as id_funcao
from plu_direito where cod_direito in ('con','alt','inc','exc');
insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_politica_vendas');

update plu_painel_grupo set descricao = 'POLÍTICA DE DESCONTO' where idt_painel = 13 and codigo = '1';

INSERT INTO `db_pir_grc`.`plu_painel_grupo` (`idt_painel`, `codigo`, `ordem`, `descricao`, `hint`, `tit_mostrar`, `tit_bt_fecha`, `tit_font_tam`, `tit_font_cor`, `tit_fundo`, `mostra_item`, `texto_altura`, `texto_font_tam`, `texto_ativ_font_cor`, `texto_ativ_fundo`, `texto_desativ_font_cor`, `texto_desativ_fundo`, `move_item`, `passo`, `passo_tit`, `layout_grid`, `img_altura`, `img_largura`, `img_margem_dir`, `img_margem_esq`, `espaco_linha`, `painel_altura`, `painel_largura`) VALUES ('13', '3', '2', 'POLÍTICA DE VENDAS', NULL, 'S', 'A', NULL, NULL, NULL, 'IT', '30', NULL, NULL, NULL, NULL, NULL, 'S', 'N', 'N', 'S', '70', '100', '15', '15', '15', '0', '0');
select idt INTO @idt_painel_grupo from plu_painel_grupo where idt_painel = 13 and codigo = '3';

select id_funcao INTO @id_funcao from plu_funcao where cod_funcao = 'grc_politica_vendas';
INSERT INTO `db_pir_grc`.`plu_painel_funcao` (`idt_painel_grupo`, `id_funcao`, `pos_top`, `pos_left`, `imagem`, `imagem_d`, `texto_cab`, `detalhe`, `visivel`, `hint`, `parametros`, `texto_font_tam`, `texto_ativ_font_cor`, `texto_ativ_fundo`, `texto_desativ_font_cor`, `texto_desativ_fundo`, `include`, `include_arq`, `include_altura`, `include_largura`) VALUES (@idt_painel_grupo, @id_funcao, '0', '0', NULL, NULL, 'Política de Vendas', NULL, 'S', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'N', NULL, NULL, NULL);

update plu_painel_grupo set ordem = 10 where idt_painel = 13 and codigo = '2';

select idt INTO @idt_painel_grupo from plu_painel_grupo where idt_painel = 13 and codigo = '2';
select id_funcao INTO @id_funcao from plu_funcao where cod_funcao = 'grc_politica_parametro_tabelas';
INSERT INTO `db_pir_grc`.`plu_painel_funcao` (`idt_painel_grupo`, `id_funcao`, `pos_top`, `pos_left`, `imagem`, `imagem_d`, `texto_cab`, `detalhe`, `visivel`, `hint`, `parametros`, `texto_font_tam`, `texto_ativ_font_cor`, `texto_ativ_fundo`, `texto_desativ_font_cor`, `texto_desativ_fundo`, `include`, `include_arq`, `include_altura`, `include_largura`) VALUES (@idt_painel_grupo, @id_funcao, '0', '0', NULL, NULL, 'Tabelas e Campos', NULL, 'S', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'N', NULL, NULL, NULL);

INSERT INTO `db_pir_grc`.`grc_politica_parametro_tabelas` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `alias`) VALUES ('1', 'db_pir_grc.grc_evento', 'Tabela de Eventos', 'S', NULL, 'evento');
INSERT INTO `db_pir_grc`.`grc_politica_parametro_tabelas` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `alias`) VALUES ('2', 'db_pir_grc.grc_produto', 'Tabela de Produtos', 'S', NULL, 'produto');
INSERT INTO `db_pir_grc`.`grc_politica_parametro_tabelas` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `alias`) VALUES ('3', 'db_pir_gec.gec_entidade', 'Tabela de Clientes', 'S', NULL, 'cliente');

ALTER TABLE `grc_politica_vendas`
MODIFY COLUMN `desconto_percentual`  decimal(15,2) NOT NULL DEFAULT 0 AFTER `status`;

-- 23/09/2017

ALTER TABLE `grc_evento`
CHANGE COLUMN `qtd_evento_insc_combo` `combo_qtd_evento_insc`  int(10) NULL DEFAULT NULL AFTER `qtd_vagas_extra`,
CHANGE COLUMN `tipo_combo` `combo_tipo`  char(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL AFTER `combo_qtd_evento_insc`,
ADD COLUMN `combo_dt_validade`  date NULL AFTER `combo_tipo`,
ADD COLUMN `combo_vl_tot_original`  decimal(15,2) NULL AFTER `combo_dt_validade`,
ADD COLUMN `combo_vl_tot_desconto`  decimal(15,2) NULL AFTER `combo_vl_tot_original`,
ADD COLUMN `combo_percentual_desc`  decimal(15,2) NULL AFTER `combo_vl_tot_desconto`;

ALTER TABLE `grc_evento`
CHANGE COLUMN `combo_vl_tot_original` `combo_vl_tot_evento`  decimal(15,2) NULL DEFAULT NULL AFTER `combo_dt_validade`,
CHANGE COLUMN `combo_vl_tot_desconto` `combo_vl_tot_matricula`  decimal(15,2) NULL DEFAULT NULL AFTER `combo_vl_tot_evento`;

-- 26/09/2017

-- Copiado do arquivo OS013 Lupe.sql

-- 29-06-2017

ALTER TABLE `db_pir_grc`.`grc_agenda_emailsms_processo` ADD COLUMN `origem` CHAR(1) NOT NULL DEFAULT 'A' AFTER `aplicacao`;
ALTER TABLE `db_pir_grc`.`grc_agenda_emailsms` ADD COLUMN `origem` CHAR(1) NOT NULL DEFAULT 'A' AFTER `tipo`;

-- 17092017

ALTER TABLE `db_pir_grc`.`grc_evento` ADD COLUMN `idt_peca` INTEGER UNSIGNED AFTER `ws_sg_erro`;

ALTER TABLE `db_pir_grc`.`grc_evento` ADD CONSTRAINT `FK_grc_evento_35` FOREIGN KEY `FK_grc_evento_35` (`idt_peca`)
    REFERENCES `grc_agenda_emailsms` (`idt`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT;

ALTER TABLE `db_pir_grc`.`grc_agenda_emailsms` ADD COLUMN `classificacao` VARCHAR(45) AFTER `origem`;

update  `db_pir_grc`.`grc_agenda_emailsms` set classificacao = codigo;

-- Fim da Copiado do arquivo OS013 Lupe.sql

INSERT INTO `db_pir_grc`.`plu_painel_grupo` (`idt_painel`, `codigo`, `ordem`, `descricao`, `hint`, `tit_mostrar`, `tit_bt_fecha`, `tit_font_tam`, `tit_font_cor`, `tit_fundo`, `mostra_item`, `texto_altura`, `texto_font_tam`, `texto_ativ_font_cor`, `texto_ativ_fundo`, `texto_desativ_font_cor`, `texto_desativ_fundo`, `move_item`, `passo`, `passo_tit`, `layout_grid`, `img_altura`, `img_largura`, `img_margem_dir`, `img_margem_esq`, `espaco_linha`, `painel_altura`, `painel_largura`) VALUES ('13', '4', '4', 'COMUNICAÇÃO', NULL, 'S', 'A', NULL, NULL, NULL, 'IT', '30', NULL, NULL, NULL, NULL, NULL, 'S', 'N', 'N', 'S', '70', '100', '15', '15', '15', '0', '0');
select idt INTO @idt_painel_grupo from plu_painel_grupo where idt_painel = 13 and codigo = '4';

select id_funcao INTO @id_funcao from plu_funcao where cod_funcao = 'grc_agenda_emailsms_processo';
INSERT INTO `db_pir_grc`.`plu_painel_funcao` (`idt_painel_grupo`, `id_funcao`, `pos_top`, `pos_left`, `imagem`, `imagem_d`, `texto_cab`, `detalhe`, `visivel`, `hint`, `parametros`, `texto_font_tam`, `texto_ativ_font_cor`, `texto_ativ_fundo`, `texto_desativ_font_cor`, `texto_desativ_fundo`, `include`, `include_arq`, `include_altura`, `include_largura`) VALUES (@idt_painel_grupo, @id_funcao, '0', '0', NULL, NULL, 'Processo', NULL, 'S', NULL, 'veio=pa', NULL, NULL, NULL, NULL, NULL, 'N', NULL, NULL, NULL);

select id_funcao INTO @id_funcao from plu_funcao where cod_funcao = 'grc_agenda_emailsms';
INSERT INTO `db_pir_grc`.`plu_painel_funcao` (`idt_painel_grupo`, `id_funcao`, `pos_top`, `pos_left`, `imagem`, `imagem_d`, `texto_cab`, `detalhe`, `visivel`, `hint`, `parametros`, `texto_font_tam`, `texto_ativ_font_cor`, `texto_ativ_fundo`, `texto_desativ_font_cor`, `texto_desativ_fundo`, `include`, `include_arq`, `include_altura`, `include_largura`) VALUES (@idt_painel_grupo, @id_funcao, '0', '0', NULL, NULL, 'Peça', NULL, 'S', NULL, 'veio=pa', NULL, NULL, NULL, NULL, NULL, 'N', NULL, NULL, NULL);

CREATE TABLE `grc_evento_acesso` (
  `idt` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `descricao` varchar(120) NOT NULL,
  PRIMARY KEY (`idt`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_evento_acesso','Entrega para acesso ao Evento','02.99.02','N','N','listar','listar');
insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_evento_acesso') as id_funcao
from plu_direito where cod_direito in ('con','alt','inc','exc');
insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_evento_acesso');

ALTER TABLE `grc_evento_acesso`
ADD COLUMN `descricao_md5`  char(32) NOT NULL AFTER `descricao`,
ADD UNIQUE INDEX `un_grc_evento_acesso_1` (`descricao_md5`) ;

select idt INTO @idt_painel from plu_painel where codigo = 'grc_presencial_parametrizacao';
select idt INTO @idt_painel_grupo from plu_painel_grupo where idt_painel = @idt_painel and codigo = 'gestao_local';
select id_funcao INTO @id_funcao from plu_funcao where cod_funcao = 'grc_evento_acesso';
INSERT INTO `db_pir_grc`.`plu_painel_funcao` (`idt_painel_grupo`, `id_funcao`, `pos_top`, `pos_left`, `imagem`, `imagem_d`, `texto_cab`, `detalhe`, `visivel`, `hint`, `parametros`, `texto_font_tam`, `texto_ativ_font_cor`, `texto_ativ_fundo`, `texto_desativ_font_cor`, `texto_desativ_fundo`, `include`, `include_arq`, `include_altura`, `include_largura`) VALUES (@idt_painel_grupo, @id_funcao, '0', '0', NULL, NULL, 'Entrega para acesso ao Evento', NULL, 'S', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'N', NULL, NULL, NULL);

ALTER TABLE `grc_evento`
ADD COLUMN `evento_acesso_descricao`  varchar(120) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL AFTER `contrapartida_sgtec`,
ADD COLUMN `evento_acesso_descricao_md5`  char(32) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL AFTER `evento_acesso_descricao`;

ALTER TABLE `grc_evento`
ADD COLUMN `conteudo_programatico`  text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL AFTER `evento_acesso_descricao_md5`;

-- 27/09/2017

insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_evento_acompanhar','Acompanhar Evento','02.02.25','S','S','listar','listar');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_evento_acompanhar') as id_funcao
from plu_direito where cod_direito in ('con', 'alt');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_evento_acompanhar');

select id_funcao INTO @id_funcao from plu_funcao where cod_funcao = 'grc_evento_acompanhar';
INSERT INTO `db_pir_grc`.`plu_painel_funcao` (`idt_painel_grupo`, `id_funcao`, `pos_top`, `pos_left`, `imagem`, `imagem_d`, `texto_cab`, `detalhe`, `visivel`, `hint`, `parametros`, `texto_font_tam`, `texto_ativ_font_cor`, `texto_ativ_fundo`, `texto_desativ_font_cor`, `texto_desativ_fundo`, `include`, `include_arq`, `include_altura`, `include_largura`) VALUES ('4', @id_funcao, '105', '768', NULL, NULL, NULL, NULL, 'S', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'N', NULL, NULL, NULL);

insert into plu_direito_funcao (id_direito, id_funcao, descricao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_evento_acompanhar') as id_funcao,
'Se marcado, vai poder acompanhar qualquer Evento' as descricao
from plu_direito where cod_direito in ('per');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df 
inner join plu_funcao f on df.id_funcao = f.id_funcao
inner join plu_direito d on df.id_direito = d.id_direito
where f.cod_funcao in ('grc_evento_acompanhar')
and d.cod_direito in ('per');

CREATE TABLE `grc_evento_participante_motivo_ic` (
  `idt` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `descricao` varchar(120) NOT NULL,
  `descricao_md5` char(32) NOT NULL,
  PRIMARY KEY (`idt`),
  UNIQUE KEY `un_grc_evento_participante_motivo_ic_1` (`descricao_md5`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_evento_participante_motivo_ic','Motivo do Cancelamento da Inscrição','02.99.24','N','N','listar','listar');
insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_evento_participante_motivo_ic') as id_funcao
from plu_direito where cod_direito in ('con','alt','inc','exc');
insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_evento_participante_motivo_ic');

select idt INTO @idt_painel from plu_painel where codigo = 'grc_presencial_parametrizacao';
select idt INTO @idt_painel_grupo from plu_painel_grupo where idt_painel = @idt_painel and codigo = 'gestao_local';
select id_funcao INTO @id_funcao from plu_funcao where cod_funcao = 'grc_evento_participante_motivo_ic';
INSERT INTO `db_pir_grc`.`plu_painel_funcao` (`idt_painel_grupo`, `id_funcao`, `pos_top`, `pos_left`, `imagem`, `imagem_d`, `texto_cab`, `detalhe`, `visivel`, `hint`, `parametros`, `texto_font_tam`, `texto_ativ_font_cor`, `texto_ativ_fundo`, `texto_desativ_font_cor`, `texto_desativ_fundo`, `include`, `include_arq`, `include_altura`, `include_largura`) VALUES (@idt_painel_grupo, @id_funcao, '0', '0', NULL, NULL, 'Motivo do Cancelamento da Inscrição', NULL, 'S', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'N', NULL, NULL, NULL);

-- 28/09/2017

ALTER TABLE `grc_evento_participante`
ADD COLUMN `motivo_cancelamento`  varchar(120) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL AFTER `contrato`,
ADD COLUMN `motivo_cancelamento_md5`  char(32) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL AFTER `motivo_cancelamento`;

-- Inicio do OS013_FilaEspera.sql

-- 21/09/2017

insert into plu_direito_funcao (id_direito, id_funcao, descricao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_evento_participante_filaespera') as id_funcao,
'Se marcado, vai poder habilitar os registros da Fila de Espera para poder continuar a inscrição no evento' as descricao
from plu_direito where cod_direito in ('per');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df 
inner join plu_funcao f on df.id_funcao = f.id_funcao
inner join plu_direito d on df.id_direito = d.id_direito
where f.cod_funcao in ('grc_evento_participante_filaespera')
and d.cod_direito in ('per');

-- 22/09/2017

CREATE TABLE `grc_evento_participante_fe_log` (
  `idt` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idt_evento` int(10) unsigned NOT NULL,
  `idt_atendimento` int(10) unsigned NOT NULL,
  `dt_registro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `usuario_nome` varchar(120) CHARACTER SET latin1 NOT NULL,
  `usuario_login` varchar(120) CHARACTER SET latin1 NOT NULL,
  `situacao` char(2) NOT NULL,
  `dt_validade` datetime DEFAULT NULL,
  PRIMARY KEY (`idt`),
  KEY `fk_grc_evento_participante_fe_log_1` (`idt_evento`),
  KEY `fk_grc_evento_participante_fe_log_2` (`idt_atendimento`),
  CONSTRAINT `fk_grc_evento_participante_fe_log_1` FOREIGN KEY (`idt_evento`) REFERENCES `grc_evento` (`idt`),
  CONSTRAINT `fk_grc_evento_participante_fe_log_2` FOREIGN KEY (`idt_atendimento`) REFERENCES `grc_atendimento` (`idt`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `grc_evento_participante`
ADD COLUMN `fe_situacao`  char(2) NULL AFTER `idt_stand`,
ADD COLUMN `fe_dt_validade`  datetime NULL AFTER `fe_situacao`;

INSERT INTO `db_pir_grc`.`plu_config` (`variavel`, `descricao`, `valor`, `extra`, `js`) VALUES ('evento_fe_prazo_habilitado', 'Qtd. de Horas para a efeticação da inscrição quando é Habilitado a partir da Fila de Espera', 30, NULL, 'N');

-- Fim OS013_FilaEspera.sql

-- 29/09/2017

INSERT INTO `db_pir_grc`.`grc_parametros` (`codigo`, `descricao`, `ativo`, `html`, `detalhe`, `classificacao`) VALUES ('grc_evento_acompanhar_lista_01', 'Assunto do email para o envio da Lista de Presença do Evento', 'S', 'N', '[#codigo_evento#] – Lista de Presença do Evento no CRM|Sebrae', '08.01');
INSERT INTO `db_pir_grc`.`grc_parametros` (`codigo`, `descricao`, `ativo`, `html`, `detalhe`, `classificacao`) VALUES ('grc_evento_acompanhar_lista_02', 'Mensagem do email para o envio da Lista de Presença do Evento', 'S', 'S', '<p>Caro(a),<br />\r\n<br />\r\nSegue em anexo a lista de presen&ccedil;a do evento <strong>[#codigo_evento#] #descricao_evento#</strong><br />\r\n<br />\r\nCordialmente,<br />\r\n<br />\r\nEquipe gestora da Plataforma Integrada de Relacionamento<br />\r\nUnidade de Atendimento Individual - DIRAT<br />\r\nUnidade de Tecnologia da Informa&ccedil;&atilde;o e Comunica&ccedil;&atilde;o - DISUP<br />\r\nSebrae - Bahia<br />\r\n<br />\r\n<strong>IMPORTANTE:</strong> Mensagem autom&aacute;tica do sistema. N&atilde;o responda!</p>', '08.02');

INSERT INTO `db_pir_grc`.`plu_config` (`variavel`, `descricao`, `valor`, `extra`, `js`, `classificacao`) VALUES ('evento_lista_presenca_dias_email', 'Qtd. de dias para o envio do e-mail com a Lista de Presença antes do início do evento', 10, NULL, 'N', NULL);

ALTER TABLE `grc_evento`
ADD COLUMN `email_enviado_lista_presenca`  char(1) NOT NULL DEFAULT 'N' AFTER `evento_acesso_descricao_md5`;

update grc_evento set email_enviado_lista_presenca = 'S'
where dt_previsao_inicial <= now()
and idt_evento_situacao in (14, 15, 16, 19, 20)
and idt_instrumento not in (52, 54);

-- 04/10/2017

CREATE TABLE `grc_evento_publicar` (
  `idt` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `codigo` varchar(10) NOT NULL,
  `idt_unidade` int(11) NOT NULL,
  `dt_registro` datetime NOT NULL,
  `idt_responsalvel` int(10) NOT NULL,
  `situacao` char(2) CHARACTER SET latin1 NOT NULL DEFAULT 'AA',
  `idt_usuario_aprovacao` int(10) DEFAULT NULL,
  `dt_aprovacao` datetime DEFAULT NULL,
  PRIMARY KEY (`idt`),
  UNIQUE KEY `un_grc_evento_publicar_1` (`codigo`,`idt_unidade`),
  KEY `fk_grc_evento_publicar_1` (`idt_responsalvel`),
  KEY `fk_grc_evento_publicar_2` (`idt_usuario_aprovacao`),
  KEY `fk_grc_evento_publicar_3` (`idt_unidade`),
  CONSTRAINT `fk_grc_evento_publicar_1` FOREIGN KEY (`idt_responsalvel`) REFERENCES `plu_usuario` (`id_usuario`),
  CONSTRAINT `fk_grc_evento_publicar_2` FOREIGN KEY (`idt_usuario_aprovacao`) REFERENCES `plu_usuario` (`id_usuario`),
  CONSTRAINT `fk_grc_evento_publicar_3` FOREIGN KEY (`idt_unidade`) REFERENCES `db_pir`.`sca_organizacao_secao` (`idt`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `grc_evento_publicar_evento` (
  `idt_evento_publicar` int(10) unsigned NOT NULL,
  `idt_evento` int(10) unsigned NOT NULL,
  `situacao` char(2) NOT NULL DEFAULT 'AA',
  PRIMARY KEY (`idt_evento_publicar`,`idt_evento`),
  KEY `fk_grc_evento_publicar_evento_2` (`idt_evento`),
  CONSTRAINT `fk_grc_evento_publicar_evento_1` FOREIGN KEY (`idt_evento_publicar`) REFERENCES `grc_evento_publicar` (`idt`) ON DELETE CASCADE,
  CONSTRAINT `fk_grc_evento_publicar_evento_2` FOREIGN KEY (`idt_evento`) REFERENCES `grc_evento` (`idt`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `grc_atendimento_pendencia`
ADD COLUMN `idt_evento_publicar`  int(10) UNSIGNED NULL DEFAULT NULL AFTER `idt_evento_publicacao`;

ALTER TABLE `grc_atendimento_pendencia` ADD CONSTRAINT `FK_grc_atendimento_pendencia_19` FOREIGN KEY (`idt_evento_publicar`) REFERENCES `grc_evento_publicar` (`idt`) ON DELETE RESTRICT ON UPDATE RESTRICT;

update plu_funcao set cod_funcao = 'grc_evento_publicar' where cod_funcao = 'grc_evento_publicacao_acao';

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_evento_publicar') as id_funcao
from plu_direito where cod_direito in ('alt','inc');

insert into plu_direito_funcao (id_direito, id_funcao, descricao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_evento_publicar') as id_funcao,
'Se marcado, vai poder ver todos os registros' as descricao
from plu_direito where cod_direito in ('per');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df 
inner join plu_funcao f on df.id_funcao = f.id_funcao
inner join plu_direito d on df.id_direito = d.id_direito
where f.cod_funcao in ('grc_evento_publicar')
and d.cod_direito in ('alt','inc','per');

-- 09/10/2017

ALTER TABLE `grc_evento`
ADD COLUMN `publique_imediatamente`  char(1) NOT NULL DEFAULT 'N' AFTER `contrapartida_sgtec`;

-- 18/10/2017

ALTER TABLE `grc_evento`
ADD COLUMN `publica_desconto_loja`  char(1) NULL AFTER `publique_imediatamente`;

-- 31/10/2017

INSERT INTO `db_pir_grc`.`grc_formulario_aplicacao` (`codigo`, `descricao`, `ativo`, `detalhe`) VALUES ('80', 'Avaliação de Estrelinhas', 'S', NULL);
INSERT INTO `db_pir_grc`.`grc_formulario_area` (`codigo`, `descricao`, `ativo`, `detalhe`, `grupo`, `idt_tema_subtema`) VALUES ('90', 'Avaliação de Estrelinhas', 'S', NULL, 'CRM', NULL);

select idt INTO @idt_aplicacao from grc_formulario_aplicacao where codigo = '80';
INSERT INTO `db_pir_grc`.`grc_formulario` (`codigo`, `descricao`, `ativo`, `detalhe`, `qtd_pontos`, `idt_aplicacao`, `idt_responsavel`, `idt_area_responsavel`, `versao_texto`, `versao_numero`, `data_inicio_aplicacao`, `data_termino_aplicacao`, `observacao`, `idt_dimensao`, `controle_pontos`, `grupo`, `idt_instrumento`) 
VALUES ('700', 'Avaliação de Eventos - Estrelinhas', 'S', 'Avaliação Geral dos Eventos na forma das cinco Estrelinhas.', '100', '5', '90', '64', 'V.01', '1.00', NULL, NULL, NULL, @idt_aplicacao, 'S', 'MEDE', NULL);

select idt INTO @idt_formulario from grc_formulario where codigo = '700' and grupo = 'MEDE';
select idt INTO @idt_formulario_area from grc_formulario_area where codigo = '90';
INSERT INTO `db_pir_grc`.`grc_formulario_secao` (`idt_formulario`, `codigo`, `descricao`, `detalhe`, `qtd_pontos`, `valido`, `idt_formulario_area`, `idt_formulario_relevancia`, `evidencia`) 
VALUES (@idt_formulario, 'SE0000048', 'Avaliação de Estrelinhas', 'Avaliação da forma Estrelinha', '100', 'S', @idt_formulario_area, '5', 'N');

select idt INTO @idt_secao from grc_formulario_secao where idt_formulario = @idt_formulario and codigo = 'SE0000048';
INSERT INTO `db_pir_grc`.`grc_formulario_pergunta` (`idt_secao`, `codigo`, `descricao`, `detalhe`, `qtd_pontos`, `valido`, `idt_classe`, `ajuda`, `idt_ferramenta`, `obrigatoria`, `evidencias`, `idt_dimensao`, `codigo_quesito`, `sigla_dimensao`) 
VALUES (@idt_secao, '1', 'Como você avalia esse Evento?', NULL, '100', 'S', NULL, NULL, NULL, 'N', NULL, NULL, NULL, NULL);

select idt INTO @idt_pergunta from grc_formulario_pergunta where idt_secao = @idt_secao and idt_dimensao is null and codigo = '1';
INSERT INTO `db_pir_grc`.`grc_formulario_resposta` (`idt_pergunta`, `codigo`, `descricao`, `detalhe`, `qtd_pontos`, `valido`, `campo_txt`, `idt_classe`) 
VALUES (@idt_pergunta, '1', 'Uma Estrelinha', NULL, '0', 'S', 'N', '2');
INSERT INTO `db_pir_grc`.`grc_formulario_resposta` (`idt_pergunta`, `codigo`, `descricao`, `detalhe`, `qtd_pontos`, `valido`, `campo_txt`, `idt_classe`) 
VALUES (@idt_pergunta, '2', 'Duas Estrelinhas', NULL, '25', 'S', 'N', '2');
INSERT INTO `db_pir_grc`.`grc_formulario_resposta` (`idt_pergunta`, `codigo`, `descricao`, `detalhe`, `qtd_pontos`, `valido`, `campo_txt`, `idt_classe`) 
VALUES (@idt_pergunta, '3', 'Três Estrelinhas', NULL, '25', 'S', 'N', '2');
INSERT INTO `db_pir_grc`.`grc_formulario_resposta` (`idt_pergunta`, `codigo`, `descricao`, `detalhe`, `qtd_pontos`, `valido`, `campo_txt`, `idt_classe`) 
VALUES (@idt_pergunta, '4', 'Quatro Estrelinhas', NULL, '25', 'S', 'N', '2');
INSERT INTO `db_pir_grc`.`grc_formulario_resposta` (`idt_pergunta`, `codigo`, `descricao`, `detalhe`, `qtd_pontos`, `valido`, `campo_txt`, `idt_classe`) 
VALUES (@idt_pergunta, '5', 'Cinco Estrelinhas', NULL, '25', 'S', 'N', '2');

-- 01/11/2017

ALTER TABLE `grc_avaliacao`
ADD COLUMN `origem`  varchar(20) NOT NULL DEFAULT 'CRM' AFTER `idt`;

-- 08/11/2017

ALTER TABLE `grc_produto`
ADD COLUMN `premio`  char(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'N' AFTER `vl_teto`;

ALTER TABLE `grc_evento`
ADD COLUMN `obrigar_pesq_certificado`  char(1) NOT NULL DEFAULT 'N' AFTER `cred_contratacao_cont_obs`;

ALTER TABLE db_pir_gec.`gec_entidade`
ADD COLUMN `pa_senha`  varchar(255) NULL AFTER `siacweb_situacao`,
ADD COLUMN `pa_idfacebook`  varchar(255) NULL AFTER `pa_senha`;

ALTER TABLE `grc_atendimento_organizacao`
ADD COLUMN `pa_senha_e`  varchar(255) NULL AFTER `siacweb_situacao_e`,
ADD COLUMN `pa_idfacebook_e`  varchar(255) NULL AFTER `pa_senha_e`;

ALTER TABLE `grc_entidade_organizacao`
ADD COLUMN `pa_senha_e`  varchar(255) NULL AFTER `siacweb_situacao_e`,
ADD COLUMN `pa_idfacebook_e`  varchar(255) NULL AFTER `pa_senha_e`;

ALTER TABLE `grc_atendimento_pessoa`
ADD COLUMN `pa_senha`  varchar(255) NULL AFTER `siacweb_situacao`,
ADD COLUMN `pa_idfacebook`  varchar(255) NULL AFTER `pa_senha`;

ALTER TABLE `grc_entidade_pessoa`
ADD COLUMN `pa_senha`  varchar(255) NULL AFTER `siacweb_situacao`,
ADD COLUMN `pa_idfacebook`  varchar(255) NULL AFTER `pa_senha`;

-- 10/11/2017

ALTER TABLE db_pir.`bc_rf_2015`
CHANGE COLUMN `Endereço - Número` `endereco_numero`  varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL AFTER `Endereço - Logradouro`,
CHANGE COLUMN `Endereço - Complemento` `endereco_complemento`  varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL AFTER `endereco_numero`,
CHANGE COLUMN `Endereço - CEP` `endereco_cep`  varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL AFTER `Endereço - Bairro`,
CHANGE COLUMN `Telefone (Siac2015)` `telefone_siac2015`  varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL AFTER `endereco_cep`,
CHANGE COLUMN `Telefone (Siac2015 - Celular)` `telefone_siac2015_celular`  varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL AFTER `telefone_siac2015`,
CHANGE COLUMN `Telefone (ZipCode)` `telefone_zipcode`  varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL AFTER `telefone_siac2015_celular`,
CHANGE COLUMN `Telefone (ZipCode - Celular)` `telefone_zipcode_celular`  varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL AFTER `telefone_zipcode`,
CHANGE COLUMN `Telefone (MEI2015)` `telefone_mei2015`  varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL AFTER `telefone_zipcode_celular`,
CHANGE COLUMN `Telefone (RFB)` `telefone_rfb`  varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL AFTER `telefone_mei2015`,
CHANGE COLUMN `E-mail (MEI2015)` `email_mei2015`  varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL AFTER `telefone_rfb`,
CHANGE COLUMN `E-mail (Siac 2015)` `email_siac2015`  varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL AFTER `email_mei2015`,
CHANGE COLUMN `Porte CSE 2010 (cód.)` `porte_cse_2010_cod`  varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL AFTER `email_siac2015`,
CHANGE COLUMN `Porte CSE 2011 (cód.)` `porte_cse_2011_cod`  varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL AFTER `Porte CSE 2010 (descr.)`,
CHANGE COLUMN `Porte CSE 2012 (cód.)` `porte_cse_2012_cod`  varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL AFTER `Porte CSE 2011 (descr.)`,
CHANGE COLUMN `Porte CSE 2013 (cód.)` `porte_cse_2013_cod`  varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL AFTER `Porte CSE 2012 (descr.)`,
CHANGE COLUMN `Porte CSE 2014 (cód.)` `porte_cse_2014_cod`  varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL AFTER `Porte CSE 2013 (descr.)`,
CHANGE COLUMN `Porte CSE 27/mar/2015 (cód.)` `porte_cse_2015_cod`  varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL AFTER `Porte CSE 2014 (descr.)`,
CHANGE COLUMN `Porte Siac julho/2015 (cód.)` `porte_siac_2015_cod`  varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL AFTER `porte_CSE_27mar2015_descr`,
CHANGE COLUMN `Opção pelo Simples em 31/12/2010` `opcao_pelo_simples_2010`  varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL AFTER `Porte Siac julho/2015 (descr.)`,
CHANGE COLUMN `Opção pelo Simples em 31/12/2011` `opcao_pelo_simples_2011`  varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL AFTER `opcao_pelo_simples_2010`,
CHANGE COLUMN `Opção pelo Simples em 31/12/2012` `opcao_pelo_simples_2012`  varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL AFTER `opcao_pelo_simples_2011`,
CHANGE COLUMN `Opção pelo Simples em 31/12/2013` `opcao_pelo_simples_2013`  varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL AFTER `opcao_pelo_simples_2012`,
CHANGE COLUMN `Opção pelo Simples em 31/12/2014` `opcao_pelo_simples_2014`  varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL AFTER `opcao_pelo_simples_2013`,
CHANGE COLUMN `Opção pelo Simples em 27/03/2015` `opcao_pelo_simples_2015`  varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL AFTER `opcao_pelo_simples_2014`,
CHANGE COLUMN `Empregados em 31/12/2010 (RAIS)` `empregados_2010_rais`  varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL AFTER `Produtos Siac utilizados em 2014`,
CHANGE COLUMN `Empregados em 31/12/2011 (RAIS)` `empregados_2011_rais`  varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL AFTER `empregados_2010_rais`,
CHANGE COLUMN `Empregados em 31/12/2012 (RAIS)` `empregados_2012_rais`  varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL AFTER `empregados_2011_rais`,
CHANGE COLUMN `Empregados em 31/12/2013 (RAIS)` `empregados_2013_rais`  varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL AFTER `empregados_2012_rais`;

ALTER TABLE db_pir.`bc_rf_2015`
CHANGE COLUMN `Endereço - Logradouro` `endereco_logradouro`  varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL AFTER `Endereço - Tipo de logradouro`;

-- jonata

-- 11/11/2017

CREATE TABLE `grc_evento_certificado_modelo` (
  `idt` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idt_instrumento` int(10) unsigned DEFAULT NULL,
  `descricao` varchar(100) NOT NULL,
  `html_corpo` longtext NOT NULL,
  `html_header` longtext,
  `html_footer` longtext,
  PRIMARY KEY (`idt`),
  UNIQUE KEY `un_grc_evento_certificado_modelo_1` (`descricao`),
  KEY `fk_grc_evento_certificado_modelo_1` (`idt_instrumento`),
  CONSTRAINT `fk_grc_evento_certificado_modelo_1` FOREIGN KEY (`idt_instrumento`) REFERENCES `grc_atendimento_instrumento` (`idt`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_evento_certificado_modelo','Modelo Certificado do Evento','02.99.04','N','N','listar','listar');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_evento_certificado_modelo') as id_funcao
from plu_direito where cod_direito in ('con','alt','inc','exc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_evento_certificado_modelo');

select idt INTO @idt_painel from plu_painel where codigo = 'grc_presencial_parametrizacao';
select idt INTO @idt_painel_grupo from plu_painel_grupo where idt_painel = @idt_painel and codigo = 'GERAL';
select id_funcao INTO @id_funcao from plu_funcao where cod_funcao = 'grc_evento_certificado_modelo';
INSERT INTO `db_pir_grc`.`plu_painel_funcao` (`idt_painel_grupo`, `id_funcao`, `pos_top`, `pos_left`, `imagem`, `imagem_d`, `texto_cab`, `detalhe`, `visivel`, `hint`, `parametros`, `texto_font_tam`, `texto_ativ_font_cor`, `texto_ativ_fundo`, `texto_desativ_font_cor`, `texto_desativ_fundo`, `include`, `include_arq`, `include_altura`, `include_largura`) VALUES (@idt_painel_grupo, @id_funcao, '0', '0', NULL, NULL, NULL, NULL, 'S', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'N', NULL, NULL, NULL);

ALTER TABLE `grc_evento` DROP FOREIGN KEY `fk_grc_evento_27`;

ALTER TABLE `grc_evento`
ADD COLUMN `html_corpo`  longtext NULL AFTER `dt_consolidado`,
ADD COLUMN `html_header`  longtext NULL AFTER `html_corpo`,
ADD COLUMN `html_footer`  longtext NULL AFTER `html_header`;

ALTER TABLE `grc_evento` ADD CONSTRAINT `FK_grc_evento_27` FOREIGN KEY (`idt_programa`) REFERENCES `db_pir_gec`.`gec_programa` (`idt`) ON DELETE RESTRICT ON UPDATE RESTRICT;

-- 13/11/2017

ALTER TABLE `grc_atendimento_pessoa`
ADD COLUMN `evento_resp_pesq_certificado`  char(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL AFTER `evento_concluio`;

--17/11/2017

ALTER TABLE `grc_evento_certificado_modelo`
ADD COLUMN `mpdf_me`  int(10) NOT NULL AFTER `html_footer`,
ADD COLUMN `mpdf_md`  int(10) NOT NULL AFTER `mpdf_me`,
ADD COLUMN `mpdf_ms`  int(10) NOT NULL AFTER `mpdf_md`,
ADD COLUMN `mpdf_mb`  int(10) NOT NULL AFTER `mpdf_ms`,
ADD COLUMN `mpdf_mh`  int(10) NOT NULL AFTER `mpdf_mb`,
ADD COLUMN `mpdf_mf`  int(10) NOT NULL AFTER `mpdf_mh`,
ADD COLUMN `mpdf_papel_orientacao`  char(1) NOT NULL AFTER `mpdf_mf`;

ALTER TABLE `grc_evento`
ADD COLUMN `mpdf_me`  int(10) NULL AFTER `html_footer`,
ADD COLUMN `mpdf_md`  int(10) NULL AFTER `mpdf_me`,
ADD COLUMN `mpdf_ms`  int(10) NULL AFTER `mpdf_md`,
ADD COLUMN `mpdf_mb`  int(10) NULL AFTER `mpdf_ms`,
ADD COLUMN `mpdf_mh`  int(10) NULL AFTER `mpdf_mb`,
ADD COLUMN `mpdf_mf`  int(10) NULL AFTER `mpdf_mh`,
ADD COLUMN `mpdf_papel_orientacao`  char(1) NULL AFTER `mpdf_mf`;

-- 27/11/2017

select idt INTO @idt_formulario from grc_formulario where codigo = '700' and grupo = 'MEDE';
select idt INTO @idt_secao from grc_formulario_secao where idt_formulario = @idt_formulario and codigo = 'SE0000048';
select idt INTO @idt_pergunta from grc_formulario_pergunta where idt_secao = @idt_secao and idt_dimensao is null and codigo = '1';

UPDATE `grc_formulario_resposta` SET `campo_txt`='S' WHERE (`idt_pergunta`= @idt_pergunta);

ALTER TABLE `grc_avaliacao`
ADD COLUMN `email_avaliador`  varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL AFTER `cpf`,
ADD COLUMN `nome_avaliador`  varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL AFTER `email_avaliador`,
ADD COLUMN `telefone_avaliador`  varchar(45) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL AFTER `nome_avaliador`;

ALTER TABLE `grc_avaliacao`
ADD COLUMN `idt_produto`  int(10) UNSIGNED NULL DEFAULT NULL AFTER `idt_guia`;

ALTER TABLE `grc_avaliacao` ADD CONSTRAINT `FK_grc_avaliacao_12` FOREIGN KEY (`idt_produto`) REFERENCES `grc_produto` (`idt`) ON DELETE RESTRICT ON UPDATE RESTRICT;

update grc_avaliacao set 
idt_produto = (select idt_produto from grc_evento where idt = grc_avaliacao.idt_evento)
where idt_evento is not null;

-- 28/11/2017

ALTER TABLE `grc_evento_participante`
ADD COLUMN `justificativa_cancelamento`  text NULL AFTER `motivo_cancelamento_md5`;

ALTER TABLE `grc_evento`
ADD COLUMN `descricao_comercial`  text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL AFTER `conteudo_programatico`;

ALTER TABLE `grc_atendimento`
ADD COLUMN `canal_registro`  varchar(45) NULL AFTER `evento_origem`;

update grc_atendimento set canal_registro = 'CRM' where evento_origem = 'PIR';
update grc_atendimento set canal_registro = 'LOJA' where evento_origem = 'SIACWEB';
update grc_atendimento set canal_registro = 'LOJA' where evento_origem = 'WEBSERVICE';

ALTER TABLE `plu_usuario`
ADD COLUMN `evento_canal_registro`  varchar(45) NULL AFTER `ldap`;

ALTER TABLE db_pir_webservice.`plu_usuario`
ADD COLUMN `evento_canal_registro`  varchar(45) NULL AFTER `ldap`;

executar php copia_end_agenda2evento.php

-- 30/11/2017

ALTER TABLE `grc_evento`
ADD COLUMN `data_publicacao_de`  datetime NULL DEFAULT NULL AFTER `descricao_comercial`,
ADD COLUMN `data_publicacao_ate`  datetime NULL DEFAULT NULL AFTER `data_publicacao_de`,
ADD COLUMN `data_hora_fim_inscricao_ec`  datetime NULL DEFAULT NULL AFTER `data_publicacao_ate`,
ADD COLUMN `restrito`  char(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT 'N' AFTER `data_hora_fim_inscricao_ec`,
ADD COLUMN `tag_busca`  varchar(5000) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL AFTER `restrito`,
ADD COLUMN `publico_ab_fe`  char(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT 'A' AFTER `tag_busca`,
ADD COLUMN `assento_marcado`  char(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL AFTER `publico_ab_fe`;

-- 01/12/2017

update plu_funcao set nm_funcao = 'Evento Mapa', cod_funcao = 'grc_evento_mapa' where cod_funcao = 'grc_evento_publicacao_mapa';
update plu_funcao set nm_funcao = 'Evento Mapa - Assento', cod_funcao = 'grc_evento_mapa_assento' where cod_funcao = 'grc_evento_publicacao_mapa_assento';

RENAME TABLE grc_evento_publicacao_mapa_assento TO grc_evento_mapa_assento;
RENAME TABLE grc_evento_publicacao_mapa TO grc_evento_mapa;

delete from grc_evento_mapa;

ALTER TABLE `grc_evento_mapa` DROP FOREIGN KEY `FK_grc_evento_publicacao_mapa_2`;

ALTER TABLE `grc_evento_mapa`
CHANGE COLUMN `idt_evento_publicacao` `idt_evento`  int(10) UNSIGNED NOT NULL AFTER `idt`,
DROP INDEX `FK_grc_evento_publicacao_mapa_2` ,
ADD INDEX `FK_grc_evento_publicacao_mapa_2` (`idt_evento`) USING BTREE ,
AUTO_INCREMENT=1;

ALTER TABLE `grc_evento_mapa` ADD CONSTRAINT `FK_grc_evento_publicacao_mapa_2` FOREIGN KEY (`idt_evento`) REFERENCES `grc_evento` (`idt`) ON DELETE CASCADE ON UPDATE RESTRICT;

ALTER TABLE `grc_evento_mapa_assento` DROP FOREIGN KEY `FK_grc_evento_publicacao_mapa_assento_1`;

ALTER TABLE `grc_evento_mapa_assento`
CHANGE COLUMN `idt_publicacao_mapa` `idt_evento_mapa`  int(10) UNSIGNED NOT NULL AFTER `idt`,
DROP INDEX `iu_grc_evento_publicacao_mapa_assento` ,
ADD UNIQUE INDEX `iu_grc_evento_publicacao_mapa_assento` (`idt_evento_mapa`, `codigo`) USING BTREE ,
DROP INDEX `iu_grc_evento_publicacao_mapa_assento_1` ,
ADD UNIQUE INDEX `iu_grc_evento_publicacao_mapa_assento_1` (`idt_evento_mapa`, `linha`, `coluna`) USING BTREE ;

ALTER TABLE `grc_evento_mapa_assento` ADD CONSTRAINT `FK_grc_evento_publicacao_mapa_assento_1` FOREIGN KEY (`idt_evento_mapa`) REFERENCES `grc_evento_mapa` (`idt`) ON DELETE CASCADE ON UPDATE RESTRICT;

ALTER TABLE `grc_evento`
ADD COLUMN `idt_grupo`  int(10) UNSIGNED NULL DEFAULT NULL AFTER `assento_marcado`;

ALTER TABLE `grc_evento` ADD CONSTRAINT `FK_grc_evento_38` FOREIGN KEY (`idt_grupo`) REFERENCES `grc_evento_grupo` (`idt`) ON DELETE RESTRICT ON UPDATE RESTRICT;

select idt INTO @idt_grupo from grc_evento_grupo where codigo = '00';
update grc_evento set idt_grupo = @idt_grupo;

update plu_funcao set nm_funcao = 'Evento Público', cod_funcao = 'grc_evento_publico' where cod_funcao = 'grc_evento_publicacao_publico';

RENAME TABLE grc_evento_publicacao_publico TO grc_evento_publico;

delete from grc_evento_publico;

ALTER TABLE `grc_evento_publico` DROP FOREIGN KEY `fk_grc_evento_publicacao_publico_1`;

ALTER TABLE `grc_evento_publico`
CHANGE COLUMN `idt_evento_publicacao` `idt_evento`  int(10) UNSIGNED NOT NULL AFTER `idt`,
DROP INDEX `iu_grc_evento_publicacao_publico` ,
ADD UNIQUE INDEX `iu_grc_evento_publicacao_publico` (`idt_evento`, `cpf`) USING BTREE ,
AUTO_INCREMENT=1;

ALTER TABLE `grc_evento_publico` ADD CONSTRAINT `fk_grc_evento_publicacao_publico_1` FOREIGN KEY (idt_evento) REFERENCES `grc_evento` (`idt`) ON DELETE CASCADE ON UPDATE RESTRICT;

-- 05/12/2017

select id_funcao INTO @id_funcao from plu_funcao where cod_funcao = 'grc_evento_acompanhar';
update plu_painel_funcao set visivel = 'N' where id_funcao = @id_funcao;

-- 06/12/2017

update plu_funcao set cod_funcao = 'grc_evento_publicar_acao' where cod_funcao = 'grc_evento_publicar';

ALTER TABLE `grc_evento_publicar`
ADD COLUMN `data_publicacao_de`  datetime NULL DEFAULT NULL AFTER `dt_aprovacao`,
ADD COLUMN `data_publicacao_ate`  datetime NULL DEFAULT NULL AFTER `data_publicacao_de`,
ADD COLUMN `data_hora_fim_inscricao_ec`  datetime NULL DEFAULT NULL AFTER `data_publicacao_ate`;

select id_funcao INTO @id_funcao from plu_funcao where cod_funcao = 'grc_evento_despublicacao_acao';
update plu_painel_funcao set visivel = 'N' where id_funcao = @id_funcao;

CREATE TABLE `grc_tipo_galeria` (
  `idt` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `descricao` varchar(120) NOT NULL,
  `tem_link` char(1) NOT NULL,
  `tem_arquivo` char(1) NOT NULL,
  PRIMARY KEY (`idt`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_tipo_galeria','Tipo de Galeria','01.99.60.30','N','N','listar','listar');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_tipo_galeria') as id_funcao
from plu_direito where cod_direito in ('con','alt','inc','exc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_tipo_galeria');

CREATE TABLE `grc_produto_galeria` (
  `idt` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idt_produto` int(10) unsigned NOT NULL,
  `idt_tipo_galeria` int(10) unsigned NOT NULL,
  `descricao` varchar(120) NOT NULL,
  `detalhe` text,
  `link` varchar(254) DEFAULT NULL,
  `arquivo` varchar(120) DEFAULT NULL,
  PRIMARY KEY (`idt`),
  KEY `FK_grc_produto_galeria` (`idt_produto`),
  KEY `FK_grc_tipo_galeria` (`idt_tipo_galeria`),
  CONSTRAINT `FK_grc_produto_galeria` FOREIGN KEY (`idt_produto`) REFERENCES `grc_produto` (`idt`),
  CONSTRAINT `FK_grc_tipo_galeria` FOREIGN KEY (`idt_tipo_galeria`) REFERENCES `grc_tipo_galeria` (`idt`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_produto_galeria','Galeria do Produto','01.01.02','N','N','listar','listar');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_produto_galeria') as id_funcao
from plu_direito where cod_direito in ('con','alt','inc','exc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_produto_galeria');

-- 07/12/2017

CREATE TABLE `grc_evento_galeria` (
  `idt` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idt_evento` int(10) unsigned NOT NULL,
  `idt_tipo_galeria` int(10) unsigned NOT NULL,
  `descricao` varchar(120) NOT NULL,
  `detalhe` text,
  `link` varchar(254) DEFAULT NULL,
  `arquivo` varchar(120) DEFAULT NULL,
  PRIMARY KEY (`idt`),
  KEY `FK_grc_evento_galeria` (`idt_evento`),
  KEY `FK_grc_tipo_galeria_evento` (`idt_tipo_galeria`),
  CONSTRAINT `FK_grc_evento_galeria` FOREIGN KEY (`idt_evento`) REFERENCES `grc_evento` (`idt`),
  CONSTRAINT `FK_grc_tipo_galeria_evento` FOREIGN KEY (`idt_tipo_galeria`) REFERENCES `grc_tipo_galeria` (`idt`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_evento_galeria','Galeria do Evento','02.03.02','N','N','listar','listar');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_evento_galeria') as id_funcao
from plu_direito where cod_direito in ('con','alt','inc','exc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_evento_galeria');

ALTER TABLE `grc_evento_galeria`
ADD COLUMN `reg_produto`  char(1) NOT NULL DEFAULT 'N' AFTER `arquivo`;

-- 08/12/2017

ALTER TABLE `grc_evento_cupom`
ADD COLUMN `utilizacao_direta`  char(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL AFTER `qtd_utilizada`;

update grc_evento_cupom set utilizacao_direta = 'N';

-- 14/12/2017

ALTER TABLE `grc_politica_parametro_tabelas`
ADD UNIQUE INDEX `iu_grc_politica_parametro_tabelas_1` (`alias`) USING BTREE ;

ALTER TABLE `grc_politica_vendas_condicao`
MODIFY COLUMN `operador`  varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL AFTER `detalhe`;

update grc_politica_vendas_condicao set operador = 'and' where operador = 'e';
update grc_politica_vendas_condicao set operador = 'or' where operador = 'ou';

-- 18/12/2017

select idt INTO @idt_painel from plu_painel where codigo = 'cadastros_tabela_apoio';
select idt INTO @idt_painel_grupo from plu_painel_grupo where idt_painel = @idt_painel and codigo = 'geral';
select id_funcao INTO @id_funcao from plu_funcao where cod_funcao = 'grc_tipo_galeria';
INSERT INTO `db_pir_grc`.`plu_painel_funcao` (`idt_painel_grupo`, `id_funcao`, `pos_top`, `pos_left`, `imagem`, `imagem_d`, `texto_cab`, `detalhe`, `visivel`, `hint`, `parametros`, `texto_font_tam`, `texto_ativ_font_cor`, `texto_ativ_fundo`, `texto_desativ_font_cor`, `texto_desativ_fundo`, `include`, `include_arq`, `include_altura`, `include_largura`) VALUES (@idt_painel_grupo, @id_funcao, '0', '0', NULL, NULL, NULL, NULL, 'S', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'N', NULL, NULL, NULL);

-- homologacao
-- sala
