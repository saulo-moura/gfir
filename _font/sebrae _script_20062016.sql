-- esmeraldo

-- 20-06-2016


insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('conteudo_painel_controle.php','Painel de Controle','90.80.80.40','S','S','janela','janela');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'conteudo_painel_controle.php') as id_funcao
from plu_direito where cod_direito in ('alt','con','exc','inc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('conteudo_painel_controle.php');


ALTER TABLE `db_pir_grc`.`plu_log_sistema` ADD COLUMN `latitude` DECIMAL(15,9) AFTER `obj_extra`,
 ADD COLUMN `longitude` DECIMAL(15,9) AFTER `latitude`;
ALTER TABLE `db_pir_grc`.`plu_log_sistema` ADD COLUMN `navegador` VARCHAR(100) AFTER `longitude`,
 ADD COLUMN `tipo_dispositivo` VARCHAR(255) AFTER `navegador`,
 ADD COLUMN `modelo` VARCHAR(255) AFTER `tipo_dispositivo`;
 
 ALTER TABLE `db_pir_grc`.`plu_log_sistema` MODIFY COLUMN `navegador` VARCHAR(1000) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL;

ALTER TABLE `db_pir_grc`.`plu_log_sistema` ADD COLUMN `id_session` VARCHAR(255) AFTER `modelo`;

ALTER TABLE `db_pir_grc`.`plu_log_sistema` ADD COLUMN `pg_usuario` VARCHAR(1000) AFTER `id_session`;


insert into plu_config (variavel,descricao,valor,js)
values ('to_vivo','Tempo para dar sinal de estar vivo','120','N');

-- 28-06-2016
ALTER TABLE `db_pir_grc`.`grc_atendimento` ADD COLUMN `nan_idt_motivo_desistencia` INTEGER UNSIGNED AFTER `nan_ap_dt_at`,
 ADD COLUMN `nan_motivo_desistencia` VARCHAR(1000) AFTER `nan_idt_motivo_desistencia`;


ALTER TABLE `db_pir_grc`.`grc_atendimento` ADD CONSTRAINT `FK_grc_atendimento_27` FOREIGN KEY `FK_grc_atendimento_27` (`nan_idt_motivo_desistencia`)
    REFERENCES `grc_nan_motivo_desistencia` (`idt`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT;
	
ALTER TABLE `db_pir_grc`.`grc_atendimento` ADD COLUMN `nan_prazo_validacao` INTEGER UNSIGNED AFTER `nan_motivo_desistencia`;

CREATE TABLE `db_pir_grc`.`plu_pesquisa` (
  `idt` INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  `codigo` VARCHAR(45) NOT NULL,
  `descricao` VARCHAR(120) NOT NULL,
  `idt_proprietario` INTEGER,
  `texto` TEXT,
  PRIMARY KEY (`idt`),
  UNIQUE INDEX `iu_plu_pesquisa`(`codigo`),
  CONSTRAINT `FK_plu_pesquisa_1` FOREIGN KEY `FK_plu_pesquisa_1` (`idt_proprietario`)
    REFERENCES `plu_usuario` (`id_usuario`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT
)
ENGINE = InnoDB;

ALTER TABLE `db_pir_grc`.`plu_pesquisa` DROP INDEX `iu_plu_pesquisa`,
 ADD INDEX `iu_plu_pesquisa` USING BTREE(`codigo`);

ALTER TABLE `db_pir_grc`.`plu_pesquisa` CHANGE COLUMN `texto` `post` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
 ADD COLUMN `get` TEXT AFTER `post`;

ALTER TABLE `db_pir_grc`.`plu_pesquisa` MODIFY COLUMN `post_slv` LONGTEXT CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
 MODIFY COLUMN `get_slv` LONGTEXT CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL;

ALTER TABLE `db_pir_grc`.`plu_pesquisa` ADD COLUMN `data_criacao` DATETIME AFTER `get_slv`;

ALTER TABLE `db_pir_grc`.`plu_pesquisa` ADD COLUMN `funcao` VARCHAR(255) AFTER `data_criacao`;



insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_presencial_relatorios','Relatórios Presencial','05.60','S','S','listar','listar');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_presencial_relatorios') as id_funcao
from plu_direito where cod_direito in ('con');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_presencial_relatorios');


insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_presencial_analitico','Relatório Presencial Analítico','05.60.03','S','S','listar_rel','listar_rel');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_presencial_analitico') as id_funcao
from plu_direito where cod_direito in ('con');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_presencial_analitico');

insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_presencial_sintetico','Relatório Presencial Sintético','05.60.05','S','S','listar_rel','listar_rel');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_presencial_sintetico') as id_funcao
from plu_direito where cod_direito in ('con');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_presencial_sintetico');


insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('conteudo_matriz_balcao_evento.php','Matriz de Instrumentos - Presencial','05.60.07','S','S','janela','janela');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'conteudo_matriz_balcao_evento.php') as id_funcao
from plu_direito where cod_direito in ('con');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('conteudo_matriz_balcao_evento.php');

ALTER TABLE `db_pir_grc`.`grc_atendimento_instrumento` ADD COLUMN `ordem_matriz` INTEGER UNSIGNED AFTER `contrapartida_sgtec`;

ALTER TABLE `db_pir_grc`.`grc_atendimento_instrumento` ADD COLUMN `descricao_matriz` VARCHAR(120) AFTER `ordem_matriz`;

update grc_atendimento_instrumento set descricao_matriz = descricao;

ALTER TABLE `db_pir_grc`.`plu_pesquisa` MODIFY COLUMN `descricao` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;

ALTER TABLE `db_pir_grc`.`plu_log_sistema` MODIFY COLUMN `pg_usuario` TEXT CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL;


insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('conteudo_matriz_evento.php','Matriz de Evento','05.60.09','S','S','janela','janela');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'conteudo_matriz_evento.php') as id_funcao
from plu_direito where cod_direito in ('con');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('conteudo_matriz_evento.php');



ALTER TABLE `db_pir_grc`.`grc_avaliacao_devolutiva_produto` ADD COLUMN `sistema` CHAR(1) NOT NULL DEFAULT 'N' AFTER `status`;


insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_evento_catalogo','Catálogo de Eventos','05.60.11','S','S','listar','listar');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_evento_catalogo') as id_funcao
from plu_direito where cod_direito in ('con');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_evento_catalogo');



-- 06-07-2016

insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('conteudo_plano_facil.php','Plano Fácil','05.70.30','S','S','janela','janela');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'conteudo_plano_facil.php') as id_funcao
from plu_direito where cod_direito in ('con');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('conteudo_plano_facil.php');

insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('conteudo_nan_protocolo_2.php','Plano Fácil','05.70.33','S','S','janela','janela');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'conteudo_nan_protocolo_2.php') as id_funcao
from plu_direito where cod_direito in ('con');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('conteudo_nan_protocolo_2.php');


-- 07-07-2016

CREATE TABLE `db_pir_grc`.`grc_avaliacao_visita` (
  `idt` INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  `idt_avaliacao` INTEGER UNSIGNED NOT NULL,
  `data_devolutiva_pdf` DATETIME,
  `data_plano_facil_pdf` DATETIME,
  `data_inicio_segunda_visita` DATETIME,
  `idt_responsavel` INTEGER UNSIGNED,
  `data_responsavel` DATETIME,
  `numero_visita` INTEGER UNSIGNED NOT NULL,
  PRIMARY KEY (`idt`),
  UNIQUE INDEX `iu_grc_avaliacao_visita`(`idt_avaliacao`, `numero_visita`)
)
ENGINE = InnoDB;
ALTER TABLE `db_pir_grc`.`grc_avaliacao_visita` ADD CONSTRAINT `FK_grc_avaliacao_visita_1` FOREIGN KEY `FK_grc_avaliacao_visita_1` (`idt_avaliacao`)
    REFERENCES `grc_avaliacao` (`idt`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT;
ALTER TABLE `db_pir_grc`.`grc_avaliacao_visita` MODIFY COLUMN `idt_responsavel` INT(10) DEFAULT NULL,
 ADD CONSTRAINT `FK_grc_avaliacao_visita_2` FOREIGN KEY `FK_grc_avaliacao_visita_2` (`idt_responsavel`)
    REFERENCES `plu_usuario` (`id_usuario`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT;
ALTER TABLE `db_pir_grc`.`grc_avaliacao_visita` ADD COLUMN `arquivo_devolutiva_pdf` VARCHAR(255) AFTER `numero_visita`,
 ADD COLUMN `arquivo_plano_facil_pdf` VARCHAR(255) AFTER `arquivo_devolutiva_pdf`,
 ADD COLUMN `data_protocolo_pdf` DATETIME AFTER `arquivo_plano_facil_pdf`,
 ADD COLUMN `arquivo_protocolo_pdf` VARCHAR(255) AFTER `data_protocolo_pdf`,
 ADD COLUMN `idt_responsavel_iniciar` INTEGER AFTER `arquivo_protocolo_pdf`,
 ADD CONSTRAINT `FK_grc_avaliacao_visita_3` FOREIGN KEY `FK_grc_avaliacao_visita_3` (`idt_responsavel_iniciar`)
    REFERENCES `plu_usuario` (`id_usuario`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT;
ALTER TABLE `db_pir_grc`.`grc_avaliacao_visita` MODIFY COLUMN `idt_responsavel` INT(10) NOT NULL,
 MODIFY COLUMN `data_responsavel` DATETIME NOT NULL;


ALTER TABLE `db_pir_grc`.`grc_nan_grupo_atendimento` ADD COLUMN `pdf_devolutiva` VARCHAR(255) AFTER `status_3`,
 ADD COLUMN `pdf_plano_facil` VARCHAR(255) AFTER `pdf_devolutiva`,
 ADD COLUMN `pdf_protocolo` VARCHAR(255) AFTER `pdf_plano_facil`;


ALTER TABLE `db_pir_grc`.`grc_nan_grupo_atendimento` ADD COLUMN `idt_aprovador_1` INTEGER UNSIGNED AFTER `pdf_protocolo`,
 ADD COLUMN `data_aprovador_1` DATETIME AFTER `idt_aprovador_1`,
 ADD COLUMN `idt_aprovador_2` INTEGER UNSIGNED AFTER `data_aprovador_1`,
 ADD COLUMN `data_aprovador_2` DATETIME AFTER `idt_aprovador_2`,
 ADD COLUMN `idt_aprovador_3` INTEGER UNSIGNED AFTER `data_aprovador_2`,
 ADD COLUMN `data_aprovador_3` DATETIME AFTER `idt_aprovador_3`;


ALTER TABLE `db_pir_grc`.`grc_nan_grupo_atendimento` MODIFY COLUMN `idt_aprovador_1` INT(10) DEFAULT NULL,
 MODIFY COLUMN `idt_aprovador_2` INT(10) DEFAULT NULL,
 MODIFY COLUMN `idt_aprovador_3` INT(10) DEFAULT NULL,
 ADD CONSTRAINT `FK_grc_nan_grupo_atendimento_5` FOREIGN KEY `FK_grc_nan_grupo_atendimento_5` (`idt_aprovador_1`)
    REFERENCES `plu_usuario` (`id_usuario`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT;
ALTER TABLE `db_pir_grc`.`grc_nan_grupo_atendimento` ADD CONSTRAINT `FK_grc_nan_grupo_atendimento_6` FOREIGN KEY `FK_grc_nan_grupo_atendimento_6` (`idt_aprovador_2`)
    REFERENCES `plu_usuario` (`id_usuario`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT;
ALTER TABLE `db_pir_grc`.`grc_nan_grupo_atendimento` ADD CONSTRAINT `FK_grc_nan_grupo_atendimento_7` FOREIGN KEY `FK_grc_nan_grupo_atendimento_7` (`idt_aprovador_3`)
    REFERENCES `plu_usuario` (`id_usuario`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT;


CREATE TABLE `db_pir_grc`.`grc_plano_facil` (
  `idt` INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  `idt_atendimento` INTEGER UNSIGNED NOT NULL,
  `idt_area` INTEGER UNSIGNED NOT NULL,
  `decido_planejo` TEXT,
  PRIMARY KEY (`idt`),
  UNIQUE INDEX `iu_grc_plano_facil`(`idt_atendimento`, `idt_area`)
)
ENGINE = InnoDB;




CREATE TABLE `db_pir_grc`.`grc_plano_facil_ferramenta` (
  `idt` INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  `idt_plano_facil` INTEGER UNSIGNED NOT NULL,
  `idt_ferramenta` INTEGER UNSIGNED NOT NULL,
  `flag` CHAR(1) NOT NULL DEFAULT 'D',
  PRIMARY KEY (`idt`),
  UNIQUE INDEX `iu_grc_plano_facil_ferramenta`(`idt_plano_facil`, `idt_ferramenta`),
  CONSTRAINT `FK_grc_plano_facil_ferramenta_1` FOREIGN KEY `FK_grc_plano_facil_ferramenta_1` (`idt_plano_facil`)
    REFERENCES `grc_plano_facil` (`idt`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT
)
ENGINE = InnoDB;
ALTER TABLE `db_pir_grc`.`grc_plano_facil_ferramenta` ADD CONSTRAINT `FK_grc_plano_facil_ferramenta_2` FOREIGN KEY `FK_grc_plano_facil_ferramenta_2` (`idt_ferramenta`)
    REFERENCES `grc_formulario_ferramenta_gestao` (`idt`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT;
CREATE TABLE `db_pir_grc`.`grc_plano_facil_produto` (
  `idt` INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  `idt_plano_facil` INTEGER UNSIGNED NOT NULL,
  `idt_produto` INTEGER UNSIGNED NOT NULL,
  `flag` CHAR(1) NOT NULL DEFAULT 'D',
  `observacao` TEXT,
  PRIMARY KEY (`idt`),
  UNIQUE INDEX `iu_grc_plano_facil_produto`(`idt_plano_facil`, `idt_produto`),
  CONSTRAINT `FK_grc_plano_facil_produto_1` FOREIGN KEY `FK_grc_plano_facil_produto_1` (`idt_plano_facil`)
    REFERENCES `grc_plano_facil` (`idt`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT,
  CONSTRAINT `FK_grc_plano_facil_produto_2` FOREIGN KEY `FK_grc_plano_facil_produto_2` (`idt_produto`)
    REFERENCES `grc_produto` (`idt`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT
)
ENGINE = InnoDB;
CREATE TABLE `db_pir_grc`.`grc_plano_facil_plano_acao` (
  `idt` INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  `idt_plano_facil` INTEGER UNSIGNED NOT NULL,
  `idt_area` INTEGER UNSIGNED NOT NULL,
  `quem` VARCHAR(120) NOT NULL,
  `idt_quem` INTEGER UNSIGNED,
  `quando` DATETIME,
  `quando_txt` VARCHAR(120),
  `observacao` TEXT,
  PRIMARY KEY (`idt`),
  UNIQUE INDEX `iu_grc_plano_facil_plano_acao`(`idt_plano_facil`, `idt_area`),
  CONSTRAINT `FK_grc_plano_facil_plano_acao_1` FOREIGN KEY `FK_grc_plano_facil_plano_acao_1` (`idt_plano_facil`)
    REFERENCES `grc_plano_facil` (`idt`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT,
  CONSTRAINT `FK_grc_plano_facil_plano_acao_2` FOREIGN KEY `FK_grc_plano_facil_plano_acao_2` (`idt_area`)
    REFERENCES `grc_formulario_area` (`idt`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT
)
ENGINE = InnoDB;
ALTER TABLE `db_pir_grc`.`grc_plano_facil` ADD COLUMN `banco_ideia` TEXT AFTER `decido_planejo`,
 ADD COLUMN `quemquandoprocurar` TEXT AFTER `banco_ideia`;
 
CREATE TABLE `db_pir_grc`.`grc_plano_facil_cresce` (
  `idt` INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  `idt_area` INTEGER UNSIGNED NOT NULL,
  `percentual` NUMERIC(10,2) NOT NULL,
  `idt_plano_facil` INTEGER UNSIGNED NOT NULL,
  PRIMARY KEY (`idt`),
  UNIQUE INDEX `iu_grc_plano_facil_cresce`(`idt_plano_facil`, `idt_area`),
  CONSTRAINT `FK_grc_plano_facil_cresce_1` FOREIGN KEY `FK_grc_plano_facil_cresce_1` (`idt_plano_facil`)
    REFERENCES `grc_plano_facil` (`idt`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT,
  CONSTRAINT `FK_grc_plano_facil_cresce_2` FOREIGN KEY `FK_grc_plano_facil_cresce_2` (`idt_area`)
    REFERENCES `grc_formulario_area` (`idt`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT
)
ENGINE = InnoDB;



insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_plano_facil_atende','Plano Fácil - Atendimento','05.70.40','S','S','listar','listar');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_plano_facil_atende') as id_funcao
from plu_direito where cod_direito in ('alt','con','exc','inc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_plano_facil_atende');

insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_plano_facil','Plano Fácil - Visita 2','05.70.40.03','S','S','listar','listar');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_plano_facil') as id_funcao
from plu_direito where cod_direito in ('alt','con','exc','inc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_plano_facil');


insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_plano_facil_area','Plano Fácil - Área','05.70.40.04','N','N','listar','listar');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_plano_facil_area') as id_funcao
from plu_direito where cod_direito in ('alt','con','exc','inc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_plano_facil_area');




insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_plano_facil_ferramenta','Plano Fácil - Ferramenta','05.70.40.05','N','N','listar','listar');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_plano_facil_ferramenta') as id_funcao
from plu_direito where cod_direito in ('alt','con','exc','inc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_plano_facil_ferramenta');


insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_plano_facil_produto','Plano Fácil - Produto','05.70.40.07','N','N','listar','listar');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_plano_facil_produto') as id_funcao
from plu_direito where cod_direito in ('alt','con','exc','inc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_plano_facil_produto');


insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_plano_facil_plano_acao','Plano Fácil - Plano de Ação','05.70.40.09','N','N','listar','listar');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_plano_facil_plano_acao') as id_funcao
from plu_direito where cod_direito in ('alt','con','exc','inc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_plano_facil_plano_acao');


insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_plano_facil_cresce','Plano Fácil - Crescer','05.70.40.11','N','N','listar','listar');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_plano_facil_cresce') as id_funcao
from plu_direito where cod_direito in ('alt','con','exc','inc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_plano_facil_cresce');

-- 

ALTER TABLE `db_pir_grc`.`grc_plano_facil` RENAME TO `db_pir_grc`.`grc_plano_facil_area`,
 CHANGE COLUMN `idt_atendimento` `idt_plano_facil` INT(10) UNSIGNED NOT NULL,
 DROP INDEX `iu_grc_plano_facil`,
 ADD UNIQUE INDEX `iu_grc_plano_facil` USING BTREE(`idt_plano_facil`, `idt_area`);


ALTER TABLE `db_pir_grc`.`grc_plano_facil_area` DROP COLUMN `banco_ideia`,
 DROP COLUMN `quemquandoprocurar`;
 
 CREATE TABLE `db_pir_grc`.`grc_plano_facil` (
  `idt` INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  `idt_atendimento` INTEGER UNSIGNED NOT NULL,
  `protocolo` VARCHAR(45) NOT NULL,
  `banco_ideia` TEXT,
  `quemquandoprocurar` TEXT,
  `idt_responsavel` INTEGER UNSIGNED,
  `data_responsavel` DATETIME,
  PRIMARY KEY (`idt`),
  UNIQUE INDEX `iu_grc_plano_facil`(`idt_atendimento`, `protocolo`)
)
ENGINE = InnoDB;


ALTER TABLE `db_pir_grc`.`grc_plano_facil_area` ADD CONSTRAINT `FK_grc_plano_facil_area_1` FOREIGN KEY `FK_grc_plano_facil_area_1` (`idt_plano_facil`)
    REFERENCES `grc_plano_facil` (`idt`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT;
ALTER TABLE `db_pir_grc`.`grc_plano_facil_area` ADD CONSTRAINT `FK_grc_plano_facil_area_2` FOREIGN KEY `FK_grc_plano_facil_area_2` (`idt_area`)
    REFERENCES `grc_formulario_area` (`idt`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT;
ALTER TABLE `db_pir_grc`.`grc_plano_facil_cresce`
 DROP FOREIGN KEY `FK_grc_plano_facil_cresce_1`;

ALTER TABLE `db_pir_grc`.`grc_plano_facil_cresce` ADD CONSTRAINT `FK_grc_plano_facil_cresce_1` FOREIGN KEY `FK_grc_plano_facil_cresce_1` (`idt_plano_facil`)
    REFERENCES `grc_plano_facil` (`idt`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT;
ALTER TABLE `db_pir_grc`.`grc_plano_facil_ferramenta`
 DROP FOREIGN KEY `FK_grc_plano_facil_ferramenta_1`;

ALTER TABLE `db_pir_grc`.`grc_plano_facil_ferramenta` ADD CONSTRAINT `FK_grc_plano_facil_ferramenta_1` FOREIGN KEY `FK_grc_plano_facil_ferramenta_1` (`idt_plano_facil`)
    REFERENCES `grc_plano_facil` (`idt`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT;
ALTER TABLE `db_pir_grc`.`grc_plano_facil_plano_acao`
 DROP FOREIGN KEY `FK_grc_plano_facil_plano_acao_1`;

ALTER TABLE `db_pir_grc`.`grc_plano_facil_plano_acao` CHANGE COLUMN `idt_plano_facil` `idt_plano_facil_area` INT(10) UNSIGNED NOT NULL,
 DROP INDEX `iu_grc_plano_facil_plano_acao`,
 ADD UNIQUE INDEX `iu_grc_plano_facil_plano_acao` USING BTREE(`idt_plano_facil_area`, `idt_area`),
 ADD CONSTRAINT `FK_grc_plano_facil_plano_acao_1` FOREIGN KEY `FK_grc_plano_facil_plano_acao_1` (`idt_plano_facil_area`)
    REFERENCES `grc_plano_facil_area` (`idt`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT;
ALTER TABLE `db_pir_grc`.`grc_plano_facil_plano_acao` DROP COLUMN `idt_area`,
 DROP INDEX `iu_grc_plano_facil_plano_acao`,
 ADD UNIQUE INDEX `iu_grc_plano_facil_plano_acao` USING BTREE(`idt_plano_facil_area`)
, DROP INDEX `FK_grc_plano_facil_plano_acao_2`,
 DROP FOREIGN KEY `FK_grc_plano_facil_plano_acao_2`;
ALTER TABLE `db_pir_grc`.`grc_plano_facil_produto`
 DROP FOREIGN KEY `FK_grc_plano_facil_produto_1`;

ALTER TABLE `db_pir_grc`.`grc_plano_facil_produto` CHANGE COLUMN `idt_plano_facil` `idt_plano_facil_area` INT(10) UNSIGNED NOT NULL,
 DROP INDEX `iu_grc_plano_facil_produto`,
 ADD UNIQUE INDEX `iu_grc_plano_facil_produto` USING BTREE(`idt_plano_facil_area`, `idt_produto`),
 ADD CONSTRAINT `FK_grc_plano_facil_produto_1` FOREIGN KEY `FK_grc_plano_facil_produto_1` (`idt_plano_facil_area`)
    REFERENCES `grc_plano_facil_area` (`idt`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT;
ALTER TABLE `db_pir_grc`.`grc_plano_facil_ferramenta`
 DROP FOREIGN KEY `FK_grc_plano_facil_ferramenta_1`;

ALTER TABLE `db_pir_grc`.`grc_plano_facil_ferramenta` CHANGE COLUMN `idt_plano_facil` `idt_plano_facil_area` INT(10) UNSIGNED NOT NULL,
 DROP INDEX `iu_grc_plano_facil_ferramenta`,
 ADD UNIQUE INDEX `iu_grc_plano_facil_ferramenta` USING BTREE(`idt_plano_facil_area`, `idt_ferramenta`),
 ADD CONSTRAINT `FK_grc_plano_facil_ferramenta_1` FOREIGN KEY `FK_grc_plano_facil_ferramenta_1` (`idt_plano_facil_area`)
    REFERENCES `grc_plano_facil_area` (`idt`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT;


-- depois voltar a ser obrigatório

ALTER TABLE `db_pir_grc`.`grc_plano_facil` MODIFY COLUMN `idt_atendimento` INT(10) UNSIGNED DEFAULT NULL;
-- --------------
ALTER TABLE `db_pir_grc`.`grc_plano_facil_plano_acao` ADD COLUMN `atividade` TEXT AFTER `observacao`;

ALTER TABLE `db_pir_grc`.`grc_plano_facil_plano_acao` MODIFY COLUMN `quando` DATE DEFAULT NULL;

-- 11-07-2016 tarde
CREATE TABLE `db_pir_grc`.`grc_avaliacao_devolutiva_resultado_area` (
  `idt` INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  `idt_avaliacao_devolutiva` INTEGER UNSIGNED NOT NULL,
  `idt_area` INTEGER UNSIGNED NOT NULL,
  `percentual` NUMERIC(10,2) NOT NULL,
  PRIMARY KEY (`idt`),
  UNIQUE INDEX `iu_grc_avaliacao_devolutiva_resultado_area`(`idt_avaliacao_devolutiva`, `idt_area`),
  CONSTRAINT `FK_grc_avaliacao_devolutiva_resultado_area_1` FOREIGN KEY `FK_grc_avaliacao_devolutiva_resultado_area_1` (`idt_avaliacao_devolutiva`)
    REFERENCES `grc_avaliacao_devolutiva` (`idt`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT
)
ENGINE = InnoDB;


ALTER TABLE `db_pir_grc`.`grc_avaliacao_devolutiva_resultado_area` ADD CONSTRAINT `FK_grc_avaliacao_devolutiva_resultado_area_2` FOREIGN KEY `FK_grc_avaliacao_devolutiva_resultado_area_2` (`idt_area`)
    REFERENCES `grc_formulario_area` (`idt`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT;

ALTER TABLE `grc_avaliacao_devolutiva_resultado_area`
ADD COLUMN `area_descricao`  varchar(120) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL AFTER `percentual`;

-- sala
-- producao
