-- 24-08-2016
-- helpdesk

CREATE TABLE `db_pir_grc`.`plu_email` (
  `idt` INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  `email` VARCHAR(255) NOT NULL,
  `senha` VARCHAR(255) NOT NULL,
  `host` VARCHAR(255) NOT NULL,
  `porta` INTEGER UNSIGNED,
  `opcao` VARCHAR(255),
  `box` VARCHAR(255),
  PRIMARY KEY (`idt`),
  UNIQUE INDEX `iu_plu_email`(`email`)
)
ENGINE = InnoDB;

CREATE TABLE `db_pir_grc`.`plu_email_conteudo` (
  `idt` INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  `idt_email` INTEGER UNSIGNED NOT NULL,
  `numero` INTEGER UNSIGNED NOT NULL,
  `titulo` VARCHAR(500),
  `corpo` LONGTEXT,
  `datahora` DATETIME NOT NULL,
  `header` LONGTEXT NOT NULL,
  PRIMARY KEY (`idt`),
  UNIQUE INDEX `iu_plu_email_conteudo`(`idt_email`, `numero`),
  CONSTRAINT `FK_plu_email_conteudo_1` FOREIGN KEY `FK_plu_email_conteudo_1` (`idt`)
    REFERENCES `plu_email` (`idt`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT
)
ENGINE = InnoDB;


insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('plu_email_g','Email','90.80.80.20','S','S','listar','listar');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'plu_email_g') as id_funcao
from plu_direito where cod_direito in ('alt','con','exc','inc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('plu_email_g');


insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('plu_email','Emails','90.80.80.20.03','S','S','listar','listar');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'plu_email') as id_funcao
from plu_direito where cod_direito in ('alt','con','exc','inc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('plu_email');

insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('plu_email_conteudo','Email - Conteúdo','90.80.80.20.05','S','S','listar','listar');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'plu_email_conteudo') as id_funcao
from plu_direito where cod_direito in ('alt','con','exc','inc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('plu_email_conteudo');


ALTER TABLE `db_pir_grc`.`plu_email_conteudo` MODIFY COLUMN `header` LONGTEXT CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL;

ALTER TABLE `db_pir_grc`.`plu_email_conteudo`
 DROP FOREIGN KEY `FK_plu_email_conteudo_1`;

ALTER TABLE `db_pir_grc`.`plu_email_conteudo` ADD CONSTRAINT `FK_plu_email_conteudo_1` FOREIGN KEY `FK_plu_email_conteudo_1` (`idt_email`)
    REFERENCES `plu_email` (`idt`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT;


ALTER TABLE `db_pir_grc`.`plu_helpdesk_interacao` ADD COLUMN `numero_id_helpdesk_usuario` VARCHAR(255) AFTER `flag_logico`;

ALTER TABLE `db_pir_grc`.`plu_email_conteudo` ADD COLUMN `from` VARCHAR(255) AFTER `header`;

ALTER TABLE `db_pir_grc`.`plu_email_conteudo` CHANGE COLUMN `from` `origem` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL;


ALTER TABLE `db_pir_grc`.`plu_email_conteudo` ADD COLUMN `nossonumero` VARCHAR(255) AFTER `origem`,
 ADD COLUMN `seunumero` VARCHAR(255) AFTER `nossonumero`
, AUTO_INCREMENT = 6300;

ALTER TABLE `db_pir_grc`.`plu_email_conteudo` ADD COLUMN `subjectww` VARCHAR(255) AFTER `seunumero`;

ALTER TABLE `db_pir_grc`.`plu_email_conteudo` ADD COLUMN `nao_lida` CHAR(1) NOT NULL DEFAULT 'N' AFTER `subjectww`
, AUTO_INCREMENT = 1;


ALTER TABLE `db_pir_grc`.`plu_email_conteudo` ADD INDEX `iu_nao_lida`(`nao_lida`, `idt_email`);


ALTER TABLE `db_pir_grc`.`plu_helpdesk_interacao` DROP INDEX `iu_protocolo`,
 ADD UNIQUE INDEX `iu_protocolo` USING BTREE(`idt_helpdesk`, `protocolo`);

ALTER TABLE `db_pir_grc`.`plu_helpdesk_interacao` ADD COLUMN `idt_helpdesk_interacao_ref` INTEGER UNSIGNED AFTER `numero_id_helpdesk_usuario`;

ALTER TABLE `db_pir_grc`.`plu_helpdesk_interacao` ADD COLUMN `idt_email_conteudo` INTEGER UNSIGNED AFTER `idt_helpdesk_interacao_ref`,
 ADD CONSTRAINT `FK_plu_helpdesk_interacao_3` FOREIGN KEY `FK_plu_helpdesk_interacao_3` (`idt_email_conteudo`)
    REFERENCES `plu_email_conteudo` (`idt`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT;

-- 05-09-2016


insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('plu_email_adm','Fale Conosco','90.80.80.20.07','N','N','cadastro','cadastro');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'plu_email_adm') as id_funcao
from plu_direito where cod_direito in ('alt','con','exc','inc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('plu_email_adm');

-- 15-09-2016

insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('conteudo_calendario.php','Agenda a Distância','95.58','S','S','janela','janela');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'conteudo_calendario.php') as id_funcao
from plu_direito where cod_direito in ('alt','con','exc','inc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('conteudo_calendario.php');



ALTER TABLE `db_pir_grc`.`grc_atendimento_agenda` ADD COLUMN `idt_tipo_deficiencia` INTEGER UNSIGNED AFTER `idt_empreendimento`,
 ADD COLUMN `necessidade_especial` CHAR(1) DEFAULT 'N' AFTER `idt_tipo_deficiencia`;


-- 16-09-2016
-- produto composto

CREATE TABLE `db_pir_grc`.`grc_produto_especie` (
  `idt` INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  `codigo` VARCHAR(45) NOT NULL,
  `descricao` VARCHAR(120) NOT NULL,
  `detalhe` TEXT,
  `ativo` CHAR(1) NOT NULL DEFAULT 'S',
  PRIMARY KEY (`idt`),
  UNIQUE INDEX `iu_grc_produto_especie`(`codigo`)
)
ENGINE = InnoDB;

insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_produto_especie','Espécie do Produto','01.99.57','S','S','listar','listar');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_produto_especie') as id_funcao
from plu_direito where cod_direito in ('alt','con','exc','inc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_produto_especie');

-- Novo campo de espécie
ALTER TABLE `db_pir_grc`.`grc_produto` ADD COLUMN `idt_produto_especie` INTEGER UNSIGNED AFTER `insumo_horas_comp`;
-- colocar todos como PRODUTO
update `db_pir_grc`.`grc_produto` set idt_produto_especie = 1;
-- torna obrigatório
ALTER TABLE `db_pir_grc`.`grc_produto` MODIFY COLUMN `idt_produto_especie` INT(10) UNSIGNED NOT NULL;

INSERT INTO `db_pir_grc`.`grc_produto_especie` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('1', '01', 'Produto', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_produto_especie` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('2', '02', 'Subproduto', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_produto_especie` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('3', '03', 'Produto Composto', NULL, 'S');

-- cria relação
ALTER TABLE `db_pir_grc`.`grc_produto` ADD CONSTRAINT `FK_grc_produto_17` FOREIGN KEY `FK_grc_produto_17` (`idt_produto_especie`)
    REFERENCES `grc_produto_especie` (`idt`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT;
	
ALTER TABLE `db_pir_grc`.`grc_produto` ADD COLUMN `pc_consultoria` CHAR(1) AFTER `idt_produto_especie`,
 ADD COLUMN `pc_curso` CHAR(1) AFTER `pc_consultoria`,
 ADD COLUMN `pc_oficina` CHAR(1) AFTER `pc_curso`,
 ADD COLUMN `pc_palestra` CHAR(1) AFTER `pc_oficina`,
 ADD COLUMN `pc_seminario` CHAR(1) AFTER `pc_palestra`;

-- 17-09-2016

insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_atendimento_distancia_p','Atendimento a Distância','05.56','S','S','listar','listar');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_atendimento_distancia_p') as id_funcao
from plu_direito where cod_direito in ('alt','con','exc','inc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_atendimento_distancia_p');

insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_atendimento_distancia_parametro','Parâmetros','05.56.03','S','S','listar','listar');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_atendimento_distancia_parametro') as id_funcao
from plu_direito where cod_direito in ('alt','con','exc','inc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_atendimento_distancia_parametro');



insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_atendimento_agenda_marcacao','Marcar Horário para Atendimento','05.56.50','N','N','cadastro','cadastro');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_atendimento_agenda_marcacao') as id_funcao
from plu_direito where cod_direito in ('alt','con','exc','inc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_atendimento_agenda_marcacao');



ALTER TABLE `db_pir_grc`.`grc_atendimento_agenda` ADD COLUMN `idt_marcador` INTEGER AFTER `necessidade_especial`,
 ADD COLUMN `marcador` VARCHAR(120) AFTER `idt_marcador`,
 ADD COLUMN `semmarcacao` CHAR(1) DEFAULT 'N' AFTER `marcador`,
 ADD CONSTRAINT `FK_grc_atendimento_agenda_2` FOREIGN KEY `FK_grc_atendimento_agenda_2` (`idt_marcador`)
    REFERENCES `plu_usuario` (`id_usuario`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT;
ALTER TABLE `db_pir_grc`.`grc_atendimento_agenda` ADD COLUMN `data_hora_marcacao_inicial` DATETIME AFTER `semmarcacao`;


CREATE TABLE `db_pir_grc`.`grc_atendimento_agenda_log` (
  `idt` INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  `idt_responsavel` INTEGER UNSIGNED NOT NULL,
  `idt_atendimento_agenda` INTEGER UNSIGNED NOT NULL,
  `dataregistro` DATETIME NOT NULL,
  `tipo` VARCHAR(255) NOT NULL,
  `texto` TEXT,
  `protocolo` VARCHAR(45),
  `idt_cliente` INTEGER UNSIGNED,
  PRIMARY KEY (`idt`)
)
ENGINE = InnoDB;

ALTER TABLE `db_pir_grc`.`grc_atendimento_agenda_log` ADD COLUMN `idt_tipo_deficiencia` INTEGER UNSIGNED AFTER `idt_cliente`,
 ADD COLUMN `necessidade_especial` VARCHAR(45) AFTER `idt_tipo_deficiencia`,
 ADD COLUMN `detalhe` TEXT AFTER `necessidade_especial`,
 ADD COLUMN `telefone` VARCHAR(45) AFTER `detalhe`,
 ADD COLUMN `celular` VARCHAR(45) AFTER `telefone`,
 ADD COLUMN `mensagem` TEXT AFTER `celular`,
 ADD COLUMN `cpf` VARCHAR(45) AFTER `mensagem`,
 ADD COLUMN `cnpj` VARCHAR(45) AFTER `cpf`;

ALTER TABLE `db_pir_grc`.`grc_atendimento_agenda_log` CHANGE COLUMN `mensagem` `assunto` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
 ADD COLUMN `email` VARCHAR(120) AFTER `cnpj`,
 ADD COLUMN `nome_empresa` VARCHAR(120) NOT NULL AFTER `email`,
 ADD COLUMN `cliente_texto` VARCHAR(120) AFTER `nome_empresa`;

ALTER TABLE `db_pir_grc`.`grc_atendimento_agenda_log` ADD COLUMN `situacao` VARCHAR(45) AFTER `cliente_texto`;
ALTER TABLE `db_pir_grc`.`grc_atendimento_agenda_log` MODIFY COLUMN `nome_empresa` VARCHAR(120) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL;
ALTER TABLE `db_pir_grc`.`grc_atendimento_agenda_log` ADD COLUMN `semmarcacao` CHAR(1) AFTER `situacao`,
 ADD COLUMN `marcador` VARCHAR(120) AFTER `semmarcacao`,
 ADD COLUMN `idt_marcador` INTEGER UNSIGNED AFTER `marcador`,
 ADD COLUMN `data_hora_marcacao_inicial` DATETIME AFTER `idt_marcador`;

-- 19-09-2016

insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_atendimento_agenda_desmarcacao','Desmarcar Horário para Atendimento','05.56.53','N','N','cadastro','cadastro');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_atendimento_agenda_desmarcacao') as id_funcao
from plu_direito where cod_direito in ('alt','con','exc','inc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_atendimento_agenda_desmarcacao');

ALTER TABLE `db_pir_grc`.`grc_atendimento_agenda` MODIFY COLUMN `observacao_chegada` VARCHAR(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
 MODIFY COLUMN `observacao_atendimento` VARCHAR(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
 ADD COLUMN `observacao_desmarcacao` VARCHAR(255) AFTER `data_hora_marcacao_inicial`;

ALTER TABLE `db_pir_grc`.`grc_atendimento_agenda_log` ADD COLUMN `observacao_desmarcacao` VARCHAR(255) AFTER `data_hora_marcacao_inicial`;

-- 20-09-2016

CREATE TABLE `db_pir_grc`.`grc_agenda_parametro` (
  `idt` INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  `codigo` VARCHAR(45) NOT NULL,
  `descricao` VARCHAR(120) NOT NULL,
  `ativo` CHAR(1) NOT NULL DEFAULT 'S',
  `detalhe` TEXT,
  PRIMARY KEY (`idt`),
  UNIQUE INDEX `iu_grc_agenda_parametro`(`codigo`)
)
ENGINE = InnoDB;


update plu_funcao set cod_funcao = 'grc_agenda_parametro' where cod_funcao = 'grc_atendimento_distancia_parametro';



CREATE TABLE `db_pir_grc`.`grc_agenda_emailsms` (
  `idt` INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  `codigo` VARCHAR(45) NOT NULL,
  `descricao` VARCHAR(120) NOT NULL,
  `ativo` cHAR(1) NOT NULL DEFAULT 'S',
  `detalhe` TEXT NOT NULL,
  PRIMARY KEY (`idt`),
  UNIQUE INDEX `iu_grc_agenda_emailsms`(`codigo`)
)
ENGINE = InnoDB;


insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_agenda_emailsms','Formato Email e SMS','05.56.05','S','S','listar','listar');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_agenda_emailsms') as id_funcao
from plu_direito where cod_direito in ('alt','con','exc','inc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_agenda_emailsms');




insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_distancia_parametro','Painel Distância Parâmetro','05.56.00','N','N','inc','inc');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_distancia_parametro') as id_funcao
from plu_direito where cod_direito in ('alt','con','exc','inc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_distancia_parametro');


update plu_funcao set cod_funcao = 'grc_distancia_parametrizacao' where cod_funcao = 'grc_distancia_parametro';




CREATE TABLE `db_pir_grc`.`grc_agenda_parametro_servico` (
  `idt` INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  `idt_parametro` VARCHAR(45) NOT NULL,
  `idt_ponto_atendimento` INTEGER UNSIGNED NOT NULL,
  `idt_servico` INTEGER UNSIGNED NOT NULL,
  PRIMARY KEY (`idt`),
  UNIQUE INDEX `iu_grc_agenda_parametro_servico`(`idt_parametro`, `idt_ponto_atendimento`)
)
ENGINE = InnoDB;

ALTER TABLE `db_pir_grc`.`grc_agenda_parametro_servico` ADD CONSTRAINT `FK_grc_agenda_parametro_servico_1` FOREIGN KEY `FK_grc_agenda_parametro_servico_1` (`idt_servico`)
    REFERENCES `grc_atendimento_especialidade` (`idt`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT;


insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_agenda_parametro_servico','Parâmetro - Serviços','05.56.03.03','N','N','listar','listar');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_agenda_parametro_servico') as id_funcao
from plu_direito where cod_direito in ('alt','con','exc','inc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_agenda_parametro_servico');



CREATE TABLE `db_pir_grc`.`grc_agenda_parametro_suspensao` (
  `idt` INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  `idt_parametro` INTEGER UNSIGNED NOT NULL,
  `data` DATE NOT NULL,
  `idt_ponto_atendimento` INTEGER UNSIGNED NOT NULL,
  `observacao` VARCHAR(2000),
  PRIMARY KEY (`idt`),
  UNIQUE INDEX `iu_grc_agenda_parametro_suspensao`(`idt_parametro`, `idt_ponto_atendimento`, `data`),
  CONSTRAINT `FK_grc_agenda_parametro_suspensao_1` FOREIGN KEY `FK_grc_agenda_parametro_suspensao_1` (`idt_parametro`)
    REFERENCES `grc_agenda_parametro` (`idt`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT
)
ENGINE = InnoDB;


ALTER TABLE `db_pir_grc`.`grc_agenda_parametro_servico` MODIFY COLUMN `idt_parametro` INTEGER UNSIGNED NOT NULL,
 ADD CONSTRAINT `FK_grc_agenda_parametro_servico_2` FOREIGN KEY `FK_grc_agenda_parametro_servico_2` (`idt_parametro`)
    REFERENCES `grc_agenda_parametro` (`idt`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT;



insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_agenda_parametro_suspensao','Parâmetro - Serviços','05.56.03.05','N','N','listar','listar');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_agenda_parametro_suspensao') as id_funcao
from plu_direito where cod_direito in ('alt','con','exc','inc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_agenda_parametro_suspensao');

ALTER TABLE `db_pir_grc`.`grc_atendimento_gera_agenda` ADD COLUMN `hora_inicio` VARCHAR(5) AFTER `executa`,
 ADD COLUMN `hora_fim` VARCHAR(5) AFTER `hora_inicio`,
 ADD COLUMN `hora_intervalo_inicio` VARCHAR(5) AFTER `hora_fim`,
 ADD COLUMN `hora_intervalo_fim` VARCHAR(45) AFTER `hora_intervalo_inicio`;


ALTER TABLE `db_pir_grc`.`grc_atendimento_gera_agenda` ADD COLUMN `data_aleatoria` VARCHAR(255) AFTER `hora_intervalo_fim`;


CREATE TABLE `grc_atendimento_pa_pessoa_servico` (
  `idt` int(10) unsigned NOT NULL,
  `idt_servico` int(10) unsigned NOT NULL,
  PRIMARY KEY (`idt`,`idt_servico`),
  KEY `fk_grc_atendimento_pa_pessoa_servico_2` (`idt_servico`),
  CONSTRAINT `fk_grc_atendimento_pa_pessoa_servico_1` FOREIGN KEY (`idt`) REFERENCES `grc_atendimento_pa_pessoa` (`idt`) ON DELETE CASCADE,
  CONSTRAINT `fk_grc_atendimento_pa_pessoa_servico_2` FOREIGN KEY (`idt_servico`) REFERENCES `grc_atendimento_especialidade` (`idt`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



ALTER TABLE `db_pir_grc`.`grc_atendimento_gera_agenda` MODIFY COLUMN `idt` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'IdentificaÃ§Ã£o Ãºnica, sequencial de um UsuÃ¡rio';

CREATE TABLE `grc_atendimento_gera_agenda_servico` (
  `idt` int(10) unsigned NOT NULL,
  `idt_servico` int(10) unsigned NOT NULL,
  PRIMARY KEY (`idt`,`idt_servico`),
  KEY `fk_grc_atendimento_gera_agenda_servico_2` (`idt_servico`),
  CONSTRAINT `fk_grc_atendimento_gera_agenda_serv1` FOREIGN KEY (`idt`) REFERENCES `grc_atendimento_gera_agenda` (`idt`) ON DELETE CASCADE,
  CONSTRAINT `fk_grc_atendimento_gera_agenda_serv2` FOREIGN KEY (`idt_servico`) REFERENCES `grc_atendimento_especialidade` (`idt`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;







ALTER TABLE `db_pir_grc`.`grc_atendimento_agenda` ADD COLUMN `duracao` INTEGER UNSIGNED AFTER `observacao_desmarcacao`;

ALTER TABLE `db_pir_grc`.`grc_atendimento_gera_agenda` ADD COLUMN `duracao` INTEGER UNSIGNED AFTER `data_aleatoria`;

ALTER TABLE `db_pir_grc`.`grc_atendimento_gera_agenda` CHANGE COLUMN `executa` `executa_ag` VARCHAR(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL;


ALTER TABLE `db_pir_grc`.`grc_atendimento_gera_agenda` CHANGE COLUMN `executa_ag` `executa` VARCHAR(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL;

ALTER TABLE `db_pir_grc`.`grc_atendimento_gera_agenda` ADD COLUMN `executa_ag` VARCHAR(10) AFTER `duracao`;



CREATE TABLE `db_pir_grc`.`grc_atendimento_agenda_servico` (
  `idt` INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  `idt_servico` INTEGER UNSIGNED NOT NULL,
  PRIMARY KEY (`idt`),
  CONSTRAINT `FK_grc_atendimento_agenda_servico_1` FOREIGN KEY `FK_grc_atendimento_agenda_servico_1` (`idt_servico`)
    REFERENCES `grc_atendimento_especialidade` (`idt`)
)
ENGINE = InnoDB;


ALTER TABLE `db_pir_grc`.`grc_atendimento_agenda_servico` ADD CONSTRAINT `FK_grc_atendimento_agenda_servico_2` FOREIGN KEY `FK_grc_atendimento_agenda_servico_2` (`idt`)
    REFERENCES `grc_atendimento_agenda` (`idt`)
    ON DELETE CASCADE
    ON UPDATE RESTRICT;

ALTER TABLE `db_pir_grc`.`grc_atendimento_agenda` ADD COLUMN `servicos` VARCHAR(2000) AFTER `duracao`;

ALTER TABLE `db_pir_grc`.`grc_atendimento_agenda` ADD COLUMN `servicos_idt` VARCHAR(1000) AFTER `servicos`;

ALTER TABLE `db_pir_grc`.`grc_atendimento_agenda` ADD COLUMN `confirmado` CHAR(1) DEFAULT 'N' AFTER `servicos_idt`;


-- 04102016

ALTER TABLE `db_pir_grc`.`grc_historico_meta` ADD COLUMN `reprovadom1` VARCHAR(1000) AFTER `status_2`,
 ADD COLUMN `reprovadom2` VARCHAR(1000) AFTER `reprovadom1`,
 ADD COLUMN `reprovadom3` VARCHAR(1000) AFTER `reprovadom2`,
 ADD COLUMN `reprovadom4` VARCHAR(1000) AFTER `reprovadom3`,
 ADD COLUMN `reprovadom5` VARCHAR(1000) AFTER `reprovadom4`,
 ADD COLUMN `reprovadom7` VARCHAR(1000) AFTER `reprovadom5`;
ALTER TABLE `db_pir_grc`.`grc_historico_meta` ADD COLUMN `ordem_cnpj` INTEGER UNSIGNED AFTER `reprovadom7`;

ALTER TABLE `db_pir_grc`.`grc_historico_meta` ADD COLUMN `req_intensidade` CHAR(1);


-- 05102016

ALTER TABLE `db_pir_grc`.`grc_historico_meta` DROP INDEX `iu_grc_historico_meta`,
 ADD INDEX `ix_grc_historico_meta` USING BTREE(`idt_atendimento`),
 ADD INDEX `ix_grc_historico_meta_1`(`data_atendimento`);

ALTER TABLE `db_pir_grc`.`grc_historico_meta` ADD INDEX `ix_grc_historico_meta_2`(`tipo_pessoa`, `porte_meta`);

 -- 07102016
 
 ALTER TABLE `db_pir_grc`.`grc_historico_meta` MODIFY COLUMN `cnpj` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL;

-- 08102016

ALTER TABLE `db_pir_grc`.`grc_historico_meta` ADD COLUMN `unidade_regional` VARCHAR(120) AFTER `req_intensidade`,
 ADD COLUMN `pa` VARCHAR(120) AFTER `unidade_regional`;

-- producao
-- sala
