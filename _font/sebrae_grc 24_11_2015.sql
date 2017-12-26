-- ja executado
/*

 ALTER TABLE `db_pir_grc`.`grc_atendimento_pendencia` ADD COLUMN `idt_evento` INTEGER UNSIGNED AFTER `idt_gestor_local`,
 ADD CONSTRAINT `FK_grc_atendimento_pendencia_5` FOREIGN KEY `FK_grc_atendimento_pendencia_5` (`idt_evento`)
    REFERENCES `grc_evento` (`idt`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE;

 ALTER TABLE `db_pir_grc`.`grc_atendimento_pendencia` MODIFY COLUMN `idt_atendimento` INT(10) UNSIGNED DEFAULT NULL;

ALTER TABLE `db_pir_grc`.`grc_atendimento_pendencia` ADD COLUMN `protocolo` VARCHAR(45) AFTER `idt_evento`;

ALTER TABLE `db_pir_grc`.`grc_atendimento_pendencia` ADD COLUMN `status` VARCHAR(45) AFTER `protocolo`;

ALTER TABLE `db_pir_grc`.`grc_atendimento_pendencia` MODIFY COLUMN `status` VARCHAR(45) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT 'Aberto';

ALTER TABLE `db_pir_grc`.`grc_atendimento_pendencia` ADD COLUMN `tipo` VARCHAR(120) AFTER `status`;

ALTER TABLE `db_pir_grc`.`grc_atendimento_pendencia` MODIFY COLUMN `tipo` VARCHAR(120) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT 'Atendimento Presencial';

ALTER TABLE `db_pir_grc`.`grc_atendimento_pendencia` ADD COLUMN `ativo` CHAR(1) DEFAULT 'S' AFTER `tipo`;

ALTER TABLE `db_pir_grc`.`grc_atendimento_pendencia` ADD COLUMN `idt_ponto_atendimento` INTEGER UNSIGNED AFTER `ativo`;

*/

-- eventos

ALTER TABLE `grc_evento` ADD COLUMN `codigo_siacweb` VARCHAR(45) AFTER `idt_instrumento`;

ALTER TABLE `db_pir_grc`.`grc_evento` ADD COLUMN `gestor_sge` VARCHAR(45) AFTER `codigo_siacweb`;


ALTER TABLE `db_pir_grc`.`grc_evento` MODIFY COLUMN `gestor_sge` VARCHAR(120) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
 ADD COLUMN `fase_acao_projeto` VARCHAR(120) AFTER `gestor_sge`;
 
 
 ALTER TABLE `db_pir_grc`.`grc_evento` ADD COLUMN `qtd_previsto` INTEGER UNSIGNED AFTER `fase_acao_projeto`,
 ADD COLUMN `qtd_realizado` INTEGER UNSIGNED AFTER `qtd_previsto`,
 ADD COLUMN `qtd_percentual` NUMERIC(15,2) AFTER `qtd_realizado`,
 ADD COLUMN `qtd_saldo` INTEGER UNSIGNED AFTER `qtd_percentual`,
 ADD COLUMN `orc_previsto` NUMERIC(15,2) AFTER `qtd_saldo`,
 ADD COLUMN `orc_realizado` NUMERIC(15,2) AFTER `orc_previsto`,
 ADD COLUMN `orc_percentual` NUMERIC(15,2) AFTER `orc_realizado`,
 ADD COLUMN `orc_saldo` NUMERIC(15,2) AFTER `orc_percentual`;
 
 ALTER TABLE `db_pir_grc`.`grc_evento` ADD COLUMN `carga_horaria_total` DECIMAL(15,2) AFTER `orc_saldo`;


ALTER TABLE `db_pir_grc`.`grc_evento` ADD COLUMN `dt_prevista_inicio` DATE AFTER `carga_horaria_total`,
 ADD COLUMN `dt_prevista_final` DATE AFTER `dt_prevista_inicio`;


ALTER TABLE `db_pir_grc`.`grc_evento` CHANGE COLUMN `dt_prevista_inicio` `dt_previsao_inicio` DATE DEFAULT NULL,
 CHANGE COLUMN `dt_prevista_final` `dt_previsao_fim` DATE DEFAULT NULL;
 
 ALTER TABLE `db_pir_grc`.`grc_evento` CHANGE COLUMN `dt_previsao_inicio` `dt_previsao_inicial` DATE DEFAULT NULL;


ALTER TABLE `db_pir_grc`.`grc_evento` ADD COLUMN `valor_inscricao` DECIMAL(15,2) AFTER `dt_previsao_fim`;


ALTER TABLE `db_pir_grc`.`grc_evento` ADD COLUMN `qtd_minima_pagantes` INTEGER UNSIGNED AFTER `valor_inscricao`,
 ADD COLUMN `qtd_dias_reservados` INTEGER UNSIGNED AFTER `qtd_minima_pagantes`;

ALTER TABLE `db_pir_grc`.`grc_evento` ADD COLUMN `previsao_receita` NUMERIC(15,2) AFTER `qtd_dias_reservados`;


ALTER TABLE `db_pir_grc`.`grc_evento` ADD COLUMN `evento_aberto` CHAR(1) DEFAULT 'N' AFTER `previsao_receita`,
 ADD COLUMN `publica_internet` CHAR(1) DEFAULT 'N' AFTER `evento_aberto`,
 ADD COLUMN `comercializar` CHAR(1) DEFAULT 'N' AFTER `publica_internet`;

ALTER TABLE `db_pir_grc`.`grc_evento` ADD COLUMN `idt_unidade` INTEGER UNSIGNED NOT NULL AFTER `comercializar`,
 ADD COLUMN `idt_ponto_atendimento` INTEGER UNSIGNED NOT NULL AFTER `idt_unidade`;

ALTER TABLE `db_pir_grc`.`grc_evento` ADD COLUMN `observacao` TEXT AFTER `idt_ponto_atendimento`;


ALTER TABLE `db_pir_grc`.`grc_evento` ADD COLUMN `hora_inicio` VARCHAR(5) AFTER `observacao`,
 ADD COLUMN `hora_fim` VARCHAR(5) AFTER `hora_inicio`;

ALTER TABLE `db_pir_grc`.`grc_evento` ADD COLUMN `maturidade` VARCHAR(45) AFTER `hora_fim`;

ALTER TABLE `db_pir_grc`.`grc_evento` ADD COLUMN `idt_local` INTEGER UNSIGNED AFTER `maturidade`,
 ADD COLUMN `idt_cidade` INTEGER UNSIGNED AFTER `idt_local`;
 
 
 ALTER TABLE `db_pir_grc`.`grc_evento` MODIFY COLUMN `ativo` VARCHAR(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT 'S',
 MODIFY COLUMN `idt_tema_subtema` INT(10) UNSIGNED DEFAULT NULL,
 MODIFY COLUMN `copia` INT(10) UNSIGNED DEFAULT 0;
 
 
 ALTER TABLE `db_pir_grc`.`grc_evento` MODIFY COLUMN `idt_foco_tematico` INT(10) UNSIGNED DEFAULT NULL,
 MODIFY COLUMN `idt_publico_alvo` INT(10) UNSIGNED DEFAULT NULL,
 ADD COLUMN `temporario` VARCHAR(45) NOT NULL DEFAULT 'S' AFTER `idt_cidade`;
 
 
 ALTER TABLE `db_pir_grc`.`grc_evento` MODIFY COLUMN `idt_unidade` INT(10) UNSIGNED DEFAULT NULL,
 MODIFY COLUMN `idt_ponto_atendimento` INT(10) UNSIGNED DEFAULT NULL;


CREATE TABLE `db_pir_grc`.`grc_evento_atorizador` (
  `idt` INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  `idt_ponto_atendimento` INTEGER UNSIGNED NOT NULL,
  `idt_autorizador` INTEGER UNSIGNED NOT NULL,
  `prioridade` VARCHAR(45) DEFAULT '1',
  `observacao` VARCHAR(120),
  PRIMARY KEY (`idt`),
  UNIQUE INDEX `iu_grc_evento_atorizador`(`idt_ponto_atendimento`, `idt_autorizador`)
)
ENGINE = InnoDB;


ALTER TABLE `db_pir_grc`.`grc_evento_atorizador` MODIFY COLUMN `idt_autorizador` INT(10) DEFAULT NULL,
 ADD CONSTRAINT `FK_grc_evento_atorizador_1` FOREIGN KEY `FK_grc_evento_atorizador_1` (`idt_autorizador`)
    REFERENCES `plu_usuario` (`id_usuario`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE;

ALTER TABLE `db_pir_grc`.`grc_evento_atorizador` MODIFY COLUMN `idt_autorizador` INT(10) NOT NULL;


ALTER TABLE `db_pir_grc`.`grc_evento_atorizador` RENAME TO `db_pir_grc`.`grc_evento_autorizador`
, DROP INDEX `iu_grc_evento_atorizador`
, DROP INDEX `FK_grc_evento_atorizador_1`,
 ADD UNIQUE INDEX `iu_grc_evento_autorizador` USING BTREE(`idt_ponto_atendimento`, `idt_autorizador`),
 ADD INDEX `FK_grc_evento_autorizador_1` USING BTREE(`idt_autorizador`),
 DROP FOREIGN KEY `FK_grc_evento_atorizador_1`,
 ADD CONSTRAINT `FK_grc_evento_autorizador_1` FOREIGN KEY `FK_grc_evento_autorizador_1` (`idt_autorizador`)
    REFERENCES `plu_usuario` (`id_usuario`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE;


CREATE TABLE `db_pir_grc`.`grc_evento_local_novo` (
  `idt` INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  `codigo` VARCHAR(45) NOT NULL,
  `descricao` VARCHAR(120) NOT NULL,
  `idt_ponto_atendimento` VARCHAR(45),
  `proprio` CHAR(1) NOT NULL DEFAULT 'S',
  `detahe` TEXT,
  `qtd_pessoas_maximo` INTEGER UNSIGNED,
  PRIMARY KEY (`idt`),
  UNIQUE INDEX `iu_grc_evento_local`(`codigo`)
)
ENGINE = InnoDB;


ALTER TABLE `db_pir_grc`.`grc_evento_local_novo` RENAME TO `db_pir_grc`.`grc_evento_local_pa`
, DROP INDEX `iu_grc_evento_local`,
 ADD UNIQUE INDEX `iu_grc_evento_local_pa` USING BTREE(`codigo`);


ALTER TABLE `db_pir_grc`.`grc_evento_local_pa` ADD COLUMN `codigo_siacweb` VARCHAR(45) AFTER `qtd_pessoas_maximo`;


ALTER TABLE `db_pir_grc`.`grc_evento_local_pa` CHANGE COLUMN `detahe` `detalhe` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL;


ALTER TABLE `db_pir_grc`.`grc_evento_local_pa` MODIFY COLUMN `proprio` CHAR(1) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT 'S'
, AUTO_INCREMENT = 1;

-- 07-12-2015

ALTER TABLE `db_pir_grc`.`grc_evento_local_pa` ADD COLUMN `idt_cidade` INTEGER UNSIGNED AFTER `codigo_siacweb`;

ALTER TABLE `db_pir_grc`.`grc_evento_local_pa` MODIFY COLUMN `idt_cidade` INT(10) UNSIGNED NOT NULL;

ALTER TABLE `db_pir_grc`.`grc_evento_insumo` MODIFY COLUMN `descricao` VARCHAR(120) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL;
ALTER TABLE `db_pir_grc`.`grc_evento_insumo` MODIFY COLUMN `por_participante` VARCHAR(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT 'S';

-- 08-12-2015

ALTER TABLE `db_pir_grc`.`grc_atendimento_pendencia` ADD COLUMN `cod_cliente_siac` VARCHAR(45) AFTER `idt_ponto_atendimento`,
 ADD COLUMN `nome_cliente` VARCHAR(120) AFTER `cod_cliente_siac`,
 ADD COLUMN `cod_empreendimento_siac` VARCHAR(45) AFTER `nome_cliente`,
 ADD COLUMN `nome_empreendimento` VARCHAR(120) AFTER `cod_empreendimento_siac`;


ALTER TABLE `db_pir_grc`.`grc_atendimento_pendencia` ADD COLUMN `cpf` VARCHAR(45) AFTER `nome_empreendimento`,
 ADD COLUMN `cnpj` VARCHAR(45) AFTER `cpf`;

-- 09--12-2015

ALTER TABLE `db_pir_grc`.`grc_evento` ADD COLUMN `idt_responsavel` INTEGER UNSIGNED AFTER `temporario`,
 ADD COLUMN `data_criacao` DATETIME AFTER `idt_responsavel`;

ALTER TABLE `db_pir_grc`.`grc_atendimento_pendencia` ADD COLUMN `idt_atendimento_pendencia` INTEGER UNSIGNED AFTER `cnpj`;

-- 10-12-2015

ALTER TABLE `db_pir_grc`.`grc_evento_participante` MODIFY COLUMN `codigo` VARCHAR(45) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
 MODIFY COLUMN `descricao` VARCHAR(120) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
 ADD COLUMN `idt_midia` INTEGER UNSIGNED AFTER `detalhe`,
 ADD COLUMN `idt_statuspgto` INTEGER UNSIGNED AFTER `idt_midia`;
 
 ALTER TABLE `db_pir_grc`.`grc_evento_participante` MODIFY COLUMN `ativo` VARCHAR(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'N',
 CHANGE COLUMN `idt_statuspgto` `statuspgto` INT(10) UNSIGNED DEFAULT NULL;


ALTER TABLE `db_pir_grc`.`grc_evento_participante` MODIFY COLUMN `statuspgto` VARCHAR(45) DEFAULT 'Pendente';

ALTER TABLE `db_pir_grc`.`grc_evento_participante` MODIFY COLUMN `idt_entidade` INT(10) UNSIGNED DEFAULT NULL,
 MODIFY COLUMN `idt_evento_relacao_participante` INT(10) UNSIGNED DEFAULT NULL,
 ADD COLUMN `idt_pessoa` INTEGER UNSIGNED NOT NULL AFTER `statuspgto`,
 ADD COLUMN `idt_empreendimento` INTEGER UNSIGNED AFTER `idt_pessoa`,
 ADD COLUMN `idt_atendimento` INTEGER UNSIGNED NOT NULL AFTER `idt_empreendimento`;


ALTER TABLE `db_pir_grc`.`grc_evento_participante` ADD CONSTRAINT `FK_grc_evento_participante_2` FOREIGN KEY `FK_grc_evento_participante_2` (`idt_atendimento`)
    REFERENCES `grc_atendimento` (`idt`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE;
ALTER TABLE `db_pir_grc`.`grc_evento_participante` MODIFY COLUMN `idt_atendimento` INT(10) UNSIGNED DEFAULT NULL;

-- 11-12-2015

-- 12-12-2015

ALTER TABLE `db_pir_grc`.`grc_evento` MODIFY COLUMN `observacao` VARCHAR(2000) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
 MODIFY COLUMN `maturidade` VARCHAR(45) CHARACTER SET latin1 COLLATE latin1_swedish_ci,
 ADD COLUMN `parecer` VARCHAR(2000) AFTER `frequencia_min`;

ALTER TABLE `db_pir_grc`.`grc_atendimento_pendencia_anexo` ADD COLUMN `data` DATETIME AFTER `arquivo`,
 ADD COLUMN `email` VARCHAR(120) AFTER `data`;

-- 16-12-2015

ALTER TABLE `db_pir_grc`.`grc_evento_agenda` MODIFY COLUMN `tipo_agenda` VARCHAR(15) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
 MODIFY COLUMN `codigo` VARCHAR(45) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
 MODIFY COLUMN `nome_agenda` VARCHAR(120) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
 MODIFY COLUMN `ativo` VARCHAR(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT 'S',
 MODIFY COLUMN `data_inicial` DATE DEFAULT NULL,
 MODIFY COLUMN `data_final` DATE DEFAULT NULL,
 ADD COLUMN `hora_inicial` VARCHAR(5) AFTER `quantidade_horas_mes`,
 ADD COLUMN `hora_final` VARCHAR(5) AFTER `hora_inicial`;
 
 ALTER TABLE `db_pir_grc`.`grc_evento_agenda` CHANGE COLUMN `data_inicial` `data_iniciao` DATE DEFAULT NULL;
 
 ALTER TABLE `db_pir_grc`.`grc_evento_agenda` CHANGE COLUMN `data_iniciao` `data_inicial` DATE DEFAULT NULL,
 CHANGE COLUMN `hora_inicial` `hora_iniciao` VARCHAR(5) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL;
ALTER TABLE `db_pir_grc`.`grc_evento_agenda` CHANGE COLUMN `hora_iniciao` `hora_inicio` VARCHAR(5) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL;

-- 17-12-2015

ALTER TABLE `db_pir_grc`.`grc_evento` ADD COLUMN `resultado_esperado` VARCHAR(5000) AFTER `publico_visitante`;
ALTER TABLE `db_pir_grc`.`grc_evento` ADD COLUMN `tipo_consultor` VARCHAR(1) DEFAULT 'N' AFTER `resultado_esperado`;

ALTER TABLE `db_pir_grc`.`grc_evento` ADD COLUMN `valor_hora` NUMERIC(15,2) AFTER `tipo_consultor`;

ALTER TABLE `db_pir_grc`.`grc_evento` ADD COLUMN `idt_responsavel_consultor` INTEGER AFTER `valor_hora`,
 ADD CONSTRAINT `FK_grc_evento_10` FOREIGN KEY `FK_grc_evento_10` (`idt_responsavel_consultor`)
    REFERENCES `plu_usuario` (`id_usuario`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE;


ALTER TABLE `db_pir_grc`.`grc_evento_agenda` ADD COLUMN `atividade` VARCHAR(5000) AFTER `idt_cidade`,
 ADD COLUMN `valor_hora` NUMERIC(15,2) AFTER `atividade`,
 ADD COLUMN `idt_tema` INTEGER UNSIGNED AFTER `valor_hora`,
 ADD COLUMN `idt_subtema` INTEGER UNSIGNED AFTER `idt_tema`,
 ADD COLUMN `competencia` DATE AFTER `idt_subtema`;


ALTER TABLE `db_pir_grc`.`grc_evento_agenda` MODIFY COLUMN `idt_local` INT(10) UNSIGNED DEFAULT NULL,
 MODIFY COLUMN `idt_cidade` INT(11) DEFAULT NULL;

ALTER TABLE `db_pir_grc`.`grc_evento_local_pa` ADD COLUMN `cep` VARCHAR(45) NOT NULL AFTER `idt_cidade`,
 ADD COLUMN `logradouro` VARCHAR(120) AFTER `cep`,
 ADD COLUMN `logradouro_numero` VARCHAR(120) AFTER `logradouro`,
 ADD COLUMN `logradouro_complemento` VARCHAR(120) AFTER `logradouro_numero`,
 ADD COLUMN `logradouro_bairro` VARCHAR(120) AFTER `logradouro_complemento`,
 ADD COLUMN `logradouro_municipio` VARCHAR(120) AFTER `logradouro_bairro`,
 ADD COLUMN `logradouro_estado` VARCHAR(2) AFTER `logradouro_municipio`,
 ADD COLUMN `logradouro_pais` VARCHAR(120) NOT NULL AFTER `logradouro_estado`,
 ADD COLUMN `logradouro_referencia` VARCHAR(120) AFTER `logradouro_pais`;


ALTER TABLE `db_pir_grc`.`grc_evento_autorizador` ADD COLUMN `idt_tipo_autorizador` INTEGER UNSIGNED AFTER `observacao`,
 ADD COLUMN `valor` NUMERIC(15,2) AFTER `idt_tipo_autorizador`;


CREATE TABLE `db_pir_grc`.`grc_evento_tipo_autorizador` (
  `idt` INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  `codigo` VARCHAR(45) NOT NULL,
  `descricao` VARCHAR(120) NOT NULL,
  `detalhe` TEXT,
  PRIMARY KEY (`idt`),
  UNIQUE INDEX `iu_grc_evento_tipo_autorizador`(`codigo`)
)
ENGINE = InnoDB;


ALTER TABLE `db_pir_grc`.`grc_evento_autorizador` ADD CONSTRAINT `FK_grc_evento_autorizador_2` FOREIGN KEY `FK_grc_evento_autorizador_2` (`idt_tipo_autorizador`)
    REFERENCES `grc_evento_tipo_autorizador` (`idt`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE;


ALTER TABLE `db_pir_grc`.`grc_evento_tipo_autorizador` ADD COLUMN `ativo` VARCHAR(45) NOT NULL DEFAULT 'S' AFTER `detalhe`;



-- tipo de autorizador

insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_evento_tipo_autorizador','Tipo de Autorizador para Eventos','05.90.60','N','N','listar','listar');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_evento_tipo_autorizador') as id_funcao
from plu_direito where cod_direito in ('alt','con','exc','inc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_evento_tipo_autorizador');


ALTER TABLE `db_pir_grc`.`grc_evento_local_pa` MODIFY COLUMN `idt_ponto_atendimento` INTEGER UNSIGNED DEFAULT NULL,
 DROP INDEX `iu_grc_evento_local_pa`,
 ADD UNIQUE INDEX `iu_grc_evento_local_pa` USING BTREE(`idt_ponto_atendimento`, `codigo`);



CREATE TABLE `db_pir_grc`.`grc_evento_local_pa_agenda` (
  `idt` INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  `idt_local_pa` INTEGER UNSIGNED NOT NULL,
  `data_inicio` DATE NOT NULL,
  `hora_inicio` VARCHAR(5) NOT NULL,
  `data_final` DATE NOT NULL,
  `hora_final` VARCHAR(5) NOT NULL,
  `status` VARCHAR(45) NOT NULL DEFAULT 'LIVRE',
  PRIMARY KEY (`idt`),
  INDEX `iu_grc_evento_local_pa_agenda`(`idt_local_pa`, `data_inicio`, `hora_inicio`)
)
ENGINE = InnoDB;

ALTER TABLE `db_pir_grc`.`grc_evento_local_pa_agenda` ADD COLUMN `detalhe` TEXT AFTER `status`;

ALTER TABLE `db_pir_grc`.`grc_evento_local_pa_agenda` MODIFY COLUMN `status` VARCHAR(45) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'OCUPADA';

ALTER TABLE `db_pir_grc`.`grc_evento_local_pa_agenda` MODIFY COLUMN `status` VARCHAR(45) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'INDISPONIVEL';


-- agenda da sala

insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_evento_local_pa_agenda','Agenda da Sala','05.90.63','N','N','listar','listar');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_evento_local_pa_agenda') as id_funcao
from plu_direito where cod_direito in ('alt','con','exc','inc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_evento_local_pa_agenda');

ALTER TABLE `db_pir_grc`.`grc_produto_insumo` ADD COLUMN `idt_area_suporte` INTEGER UNSIGNED AFTER `receita_total`;

ALTER TABLE `db_pir_grc`.`grc_evento_insumo` ADD COLUMN `idt_area_suporte` INTEGER UNSIGNED AFTER `dif_media`;


ALTER TABLE `db_pir_grc`.`grc_evento_insumo` ADD COLUMN `atendimento_data_prevista` DATE,
 ADD COLUMN `atendimento_data_real` DATE,
 ADD COLUMN `atendimento_quantidade` NUMERIC(15,2),
 ADD COLUMN `atendimento_falta_atender` NUMERIC(15,2),
 ADD COLUMN `status` VARCHAR(45) DEFAULT 'PENDENTE';

-- 28-12-2015

ALTER TABLE `db_pir_grc`.`grc_evento_tipo_autorizador` ADD COLUMN `valor` NUMERIC(15,2) AFTER `ativo`;

ALTER TABLE `db_pir_grc`.`grc_evento` ADD COLUMN `previsao_despesa` NUMERIC(15,2) AFTER `ano_competencia`;


CREATE TABLE `db_pir_grc`.`grc_pendencia_recorrencia` (
  `idt` INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  `codigo` VARCHAR(45) NOT NULL,
  `descricao` VARCHAR(120) NOT NULL,
  `periodicidade` INTEGER UNSIGNED NOT NULL DEFAULT 0,
  `periodo` INTEGER UNSIGNED NOT NULL DEFAULT 1,
  `observacao` VARCHAR(3000) NOT NULL,
  PRIMARY KEY (`idt`),
  UNIQUE INDEX `iu_grc_pendencia_recorrencia`(`codigo`)
)
ENGINE = InnoDB;

ALTER TABLE `db_pir_grc`.`grc_pendencia_recorrencia` ADD COLUMN `ordem` INTEGER UNSIGNED NOT NULL DEFAULT 1 AFTER `observacao`;
ALTER TABLE `db_pir_grc`.`grc_pendencia_recorrencia` DROP INDEX `iu_grc_pendencia_recorrencia`,
 ADD UNIQUE INDEX `iu_grc_pendencia_recorrencia` USING BTREE(`codigo`, `ordem`);


-- grc_pendencia_recorrencia

insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_pendencia_recorrencia','Recorrência de Pendência','05.90.70','S','S','listar','listar');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_pendencia_recorrencia') as id_funcao
from plu_direito where cod_direito in ('alt','con','exc','inc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_pendencia_recorrencia');


ALTER TABLE `db_pir_grc`.`grc_evento_insumo` ADD COLUMN `previsao_despesa` NUMERIC(15,2) AFTER `status`;


-- 30-12-2015

ALTER TABLE `db_pir_grc`.`grc_evento_insumo` ADD COLUMN `idt_ordem_contratacao` INTEGER UNSIGNED AFTER `previsao_despesa`;

-- 06-01-2016

/*
executado em produção
ALTER TABLE `db_pir_grc`.`grc_produto` ADD COLUMN `generico` CHar(1) DEFAULT 'N' AFTER `situacao_siac`;
*/

-- 07-01-2016

ALTER TABLE `db_pir_grc`.`grc_projeto_acao` ADD COLUMN `cpf_responsavel` VARCHAR(45) AFTER `codigo_siacweb`,
 ADD COLUMN `codigosiacwebresponsavel` INTEGER UNSIGNED AFTER `cpf_responsavel`;
 
 ALTER TABLE `db_pir_grc`.`grc_projeto_acao` CHANGE COLUMN `codigosiacwebresponsavel` `codparceiro_siacweb` INT(10) UNSIGNED DEFAULT NULL;


ALTER TABLE `db_pir_grc`.`grc_projeto` ADD COLUMN `cpf_responsavel` VARCHAR(45) AFTER `existe_siacweb`,
 ADD COLUMN `codparceiro_siacweb` INTEGER UNSIGNED AFTER `cpf_responsavel`;

insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('conteudo_matriz_atendimento.php','Matriz de Atendimento','05.01.67','S','S','janela','janela');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'conteudo_matriz_atendimento.php') as id_funcao
from plu_direito where cod_direito in ('alt','con','exc','inc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('conteudo_matriz_atendimento.php');

-- 22-01-2016

CREATE TABLE `db_pir_grc`.`grc_evento_banco` (
  `idt` INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  `codigo` VARCHAR(45) NOT NULL,
  `descricao` VARCHAR(120),
  `detalhe` VARCHAR(1000),
  PRIMARY KEY (`idt`),
  UNIQUE INDEX `iu_grc_evento_banco`(`codigo`)
)
ENGINE = InnoDB;

insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_evento_banco','Bancos','02.99.15','S','S','listar','listar');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_evento_banco') as id_funcao
from plu_direito where cod_direito in ('alt','con','exc','inc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_evento_banco');






CREATE TABLE `db_pir_grc`.grc_evento_natureza_pagamento (
  `idt` INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  `codigo` VARCHAR(45) NOT NULL,
  `descricao` VARCHAR(120),
  `detalhe` VARCHAR(1000),
  PRIMARY KEY (`idt`),
  UNIQUE INDEX `iu_grc_evento_natureza_pagamento`(`codigo`)
)
ENGINE = InnoDB;


insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_evento_natureza_pagamento','Natureza da Forma de Pagamento','02.99.17','S','S','listar','listar');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_evento_natureza_pagamento') as id_funcao
from plu_direito where cod_direito in ('alt','con','exc','inc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_evento_natureza_pagamento');



CREATE TABLE `db_pir_grc`.`grc_evento_cartao_bandeira` (
  `idt` INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  `codigo` VARCHAR(45) NOT NULL,
  `descricao` VARCHAR(120),
  `detalhe` VARCHAR(1000),
  PRIMARY KEY (`idt`),
  UNIQUE INDEX `iu_grc_evento_cartao_bandeira`(`codigo`)
)
ENGINE = InnoDB;

insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_evento_cartao_bandeira','Bandeira de Cartão','02.99.19','S','S','listar','listar');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_evento_cartao_bandeira') as id_funcao
from plu_direito where cod_direito in ('alt','con','exc','inc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_evento_cartao_bandeira');


CREATE TABLE `db_pir_grc`.`grc_evento_forma_parcelamento`  (
  `idt` INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  `codigo` VARCHAR(45) NOT NULL,
  `descricao` VARCHAR(120),
  `detalhe` VARCHAR(1000),
  
  PRIMARY KEY (`idt`),
  UNIQUE INDEX `iu_grc_evento_forma_parcelamento`(`codigo`)
)
ENGINE = InnoDB;

insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_evento_forma_parcelamento','Forma de Parcelamento','02.99.21','S','S','listar','listar');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_evento_forma_parcelamento') as id_funcao
from plu_direito where cod_direito in ('alt','con','exc','inc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_evento_forma_parcelamento');

ALTER TABLE `db_pir_grc`.`grc_evento_banco` ADD COLUMN `ativo` VARCHAR(1) NOT NULL AFTER `detalhe`;
ALTER TABLE `db_pir_grc`.`grc_evento_banco` MODIFY COLUMN `ativo` VARCHAR(1) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'S';
ALTER TABLE `db_pir_grc`.`grc_evento_natureza_pagamento` ADD COLUMN `ativo` VARCHAR(1) NOT NULL DEFAULT 'S' AFTER `detalhe`;
ALTER TABLE `db_pir_grc`.`grc_evento_cartao_bandeira` ADD COLUMN `ativo` VARCHAR(1) NOT NULL DEFAULT 'S' AFTER `detalhe`;



ALTER TABLE `db_pir_grc`.`grc_evento_forma_parcelamento` ADD COLUMN `ativo` VARCHAR(1) NOT NULL DEFAULT 'S' AFTER `detalhe`,
 ADD COLUMN `idt_natureza` INTEGER UNSIGNED NOT NULL AFTER `ativo`,
 ADD CONSTRAINT `FK_grc_evento_forma_parcelamento_1` FOREIGN KEY `FK_grc_evento_forma_parcelamento_1` (`idt_natureza`)
    REFERENCES `grc_evento_natureza_pagamento` (`idt`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT;

ALTER TABLE `db_pir_grc`.`grc_evento_forma_parcelamento` ADD COLUMN `numero_de_parcelas` INTEGER UNSIGNED NOT NULL AFTER `idt_natureza`;

ALTER TABLE `db_pir_grc`.`grc_evento_forma_parcelamento` ADD COLUMN `valor_ate` NUMERIC(15,2) NOT NULL AFTER `numero_de_parcelas`;


insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('conteudo_painel_gerencial.php','Painel Gerencial','05.01.69','S','S','janela','janela');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'conteudo_painel_gerencial.php') as id_funcao
from plu_direito where cod_direito in ('alt','con','exc','inc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('conteudo_painel_gerencial.php');

-- produção
-- esmeraldo
