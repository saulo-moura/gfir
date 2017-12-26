-- esmeraldo

-- 16/01/2017

ALTER TABLE `grc_produto`
ADD COLUMN `entrega_prazo_max`  int(10) NULL AFTER `forcar_carga_horarria`;

CREATE TABLE `grc_produto_entrega_documento` (
  `idt` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idt_produto_entrega` int(10) unsigned NOT NULL,
  `idt_documento` int(10) unsigned NOT NULL,
  `codigo` varchar(45) NOT NULL,
  PRIMARY KEY (`idt`),
  KEY `fk_grc_produto_entrega_documento_1` (`idt_produto_entrega`),
  KEY `fk_grc_produto_entrega_documento_2` (`idt_documento`),
  CONSTRAINT `fk_grc_produto_entrega_documento_2` FOREIGN KEY (`idt_documento`) REFERENCES `db_pir_gec`.`gec_documento` (`idt`),
  CONSTRAINT `fk_grc_produto_entrega_documento_1` FOREIGN KEY (`idt_produto_entrega`) REFERENCES `grc_produto_entrega` (`idt`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_produto_entrega_documento','Entrega do Produto (Documento)','01.01.27.01','S','N','listar','listar');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_produto_entrega_documento') as id_funcao
from plu_direito where cod_direito in ('alt','con','inc','exc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_produto_entrega_documento');

-- 17/01/2017

ALTER TABLE `grc_produto`
ADD COLUMN `vl_determinado`  char(1) NULL AFTER `entrega_prazo_max`;

update grc_produto set vl_determinado = 'N' where idt_programa = 4;

CREATE TABLE `grc_insumo_dimensionamento` (
  `idt` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `codigo` varchar(45) NOT NULL,
  `descricao` varchar(120) NOT NULL,
  `ativo` varchar(1) NOT NULL DEFAULT 'S',
  `detalhe` text,
  `idt_insumo_unidade` int(10) unsigned NOT NULL,
  `vl_unitario` decimal(10,2) NOT NULL,
  PRIMARY KEY (`idt`),
  UNIQUE KEY `iu_grc_insumo_dimensionamento` (`codigo`),
  KEY `FK_grc_insumo_dimensionamento_1` (`idt_insumo_unidade`),
  CONSTRAINT `FK_grc_insumo_dimensionamento_1` FOREIGN KEY (`idt_insumo_unidade`) REFERENCES `grc_insumo_unidade` (`idt`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_insumo_dimensionamento','Insumo do Dimensionamento','01.99.60.15','S','N','listar','listar');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_insumo_dimensionamento') as id_funcao
from plu_direito where cod_direito in ('alt','con','inc','exc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_insumo_dimensionamento');

CREATE TABLE `grc_produto_dimensionamento` (
  `idt` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idt_produto` int(10) unsigned NOT NULL,
  `idt_insumo_dimensionamento` int(10) unsigned NOT NULL,
  `codigo` varchar(45) NOT NULL,
  `descricao` varchar(120) NOT NULL,
  `detalhe` text,
  `idt_insumo_unidade` int(10) unsigned NOT NULL,
  `vl_unitario` decimal(10,2) NOT NULL,
  PRIMARY KEY (`idt`),
  UNIQUE KEY `iu_grc_produto_dimensionamento` (`codigo`,`idt_produto`) USING BTREE,
  KEY `fk_grc_produto_dimensionamento_2` (`idt_produto`),
  KEY `fk_grc_produto_dimensionamento_3` (`idt_insumo_dimensionamento`),
  KEY `fk_grc_produto_dimensionamento_1` (`idt_insumo_unidade`) USING BTREE,
  CONSTRAINT `fk_grc_produto_dimensionamento_3` FOREIGN KEY (`idt_insumo_dimensionamento`) REFERENCES `grc_insumo_dimensionamento` (`idt`),
  CONSTRAINT `fk_grc_produto_dimensionamento_1` FOREIGN KEY (`idt_insumo_unidade`) REFERENCES `grc_insumo_unidade` (`idt`),
  CONSTRAINT `fk_grc_produto_dimensionamento_2` FOREIGN KEY (`idt_produto`) REFERENCES `grc_produto` (`idt`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_produto_dimensionamento','Dimensionamento do Produto','01.01.30','S','N','listar','listar');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_produto_dimensionamento') as id_funcao
from plu_direito where cod_direito in ('alt','con','inc','exc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_produto_dimensionamento');

CREATE TABLE `grc_atendimento_evento` (
  `idt` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idt_atendimento` int(10) unsigned NOT NULL,
  `idt_projeto` int(10) unsigned DEFAULT NULL,
  `idt_acao` int(10) unsigned DEFAULT NULL,
  `idt_produto` int(10) unsigned DEFAULT NULL,
  `idt_gestor_evento` int(11) DEFAULT NULL,
  `objetivo` text,
  `resultado_esperado` varchar(5000) DEFAULT NULL,
  `idt_evento` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`idt`),
  KEY `fk_grc_atendimento_evento_1` (`idt_atendimento`),
  KEY `fk_grc_atendimento_evento_2` (`idt_projeto`),
  KEY `fk_grc_atendimento_evento_3` (`idt_acao`),
  KEY `fk_grc_atendimento_evento_4` (`idt_gestor_evento`),
  KEY `fk_grc_atendimento_evento_5` (`idt_produto`),
  KEY `fk_grc_atendimento_evento_6` (`idt_evento`),
  CONSTRAINT `fk_grc_atendimento_evento_1` FOREIGN KEY (`idt_atendimento`) REFERENCES `grc_atendimento` (`idt`),
  CONSTRAINT `fk_grc_atendimento_evento_2` FOREIGN KEY (`idt_projeto`) REFERENCES `grc_projeto` (`idt`),
  CONSTRAINT `fk_grc_atendimento_evento_3` FOREIGN KEY (`idt_acao`) REFERENCES `grc_projeto_acao` (`idt`),
  CONSTRAINT `fk_grc_atendimento_evento_4` FOREIGN KEY (`idt_gestor_evento`) REFERENCES `plu_usuario` (`id_usuario`),
  CONSTRAINT `fk_grc_atendimento_evento_5` FOREIGN KEY (`idt_produto`) REFERENCES `grc_produto` (`idt`),
  CONSTRAINT `fk_grc_atendimento_evento_6` FOREIGN KEY (`idt_evento`) REFERENCES `grc_evento` (`idt`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `grc_atendimento_evento_anexo` (
  `idt` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idt_atendimento_evento` int(10) unsigned NOT NULL,
  `descricao` varchar(120) NOT NULL,
  `observacao` text,
  `idt_responsavel` int(11) NOT NULL,
  `data_responsavel` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `arquivo` varchar(120) NOT NULL,
  `so_consulta` char(1) NOT NULL DEFAULT 'N',
  PRIMARY KEY (`idt`),
  KEY `iu_grc_atendimento_evento_anexo_1` (`idt_atendimento_evento`,`descricao`) USING BTREE,
  KEY `fk_grc_atendimento_evento_anexo_2` (`idt_responsavel`),
  CONSTRAINT `fk_grc_atendimento_evento_anexo_2` FOREIGN KEY (`idt_responsavel`) REFERENCES `plu_usuario` (`id_usuario`),
  CONSTRAINT `fk_grc_atendimento_evento_anexo_1` FOREIGN KEY (`idt_atendimento_evento`) REFERENCES `grc_atendimento_evento` (`idt`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `grc_atendimento_evento_dimensionamento` (
  `idt` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idt_atendimento_evento` int(10) unsigned NOT NULL,
  `idt_insumo_dimensionamento` int(10) unsigned NOT NULL,
  `codigo` varchar(45) NOT NULL,
  `descricao` varchar(120) NOT NULL,
  `detalhe` text,
  `idt_insumo_unidade` int(10) unsigned NOT NULL,
  `vl_unitario` decimal(10,2) NOT NULL,
  PRIMARY KEY (`idt`),
  UNIQUE KEY `iu_grc_atendimento_evento_dimensionamento` (`codigo`,`idt_atendimento_evento`) USING BTREE,
  KEY `fk_grc_atendimento_evento_dimensionamento_1` (`idt_insumo_unidade`),
  KEY `fk_grc_atendimento_evento_dimensionamento_2` (`idt_atendimento_evento`),
  KEY `fk_grc_atendimento_evento_dimensionamento_3` (`idt_insumo_dimensionamento`),
  CONSTRAINT `fk_grc_atendimento_evento_dimensionamento_3` FOREIGN KEY (`idt_insumo_dimensionamento`) REFERENCES `grc_insumo_dimensionamento` (`idt`),
  CONSTRAINT `fk_grc_atendimento_evento_dimensionamento_1` FOREIGN KEY (`idt_insumo_unidade`) REFERENCES `grc_insumo_unidade` (`idt`),
  CONSTRAINT `fk_grc_atendimento_evento_dimensionamento_2` FOREIGN KEY (`idt_atendimento_evento`) REFERENCES `grc_atendimento_evento` (`idt`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `grc_atendimento_evento_entrega` (
  `idt` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idt_atendimento_evento` int(10) unsigned NOT NULL,
  `codigo` varchar(45) NOT NULL,
  `descricao` varchar(120) NOT NULL,
  `detalhe` text,
  `percentual` decimal(15,4) NOT NULL,
  `ordem` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`idt`),
  UNIQUE KEY `iu_grc_atendimento_evento_1` (`codigo`,`idt_atendimento_evento`) USING BTREE,
  KEY `fk_grc_atendimento_evento_entrega_1` (`idt_atendimento_evento`),
  CONSTRAINT `fk_grc_atendimento_evento_entrega_1` FOREIGN KEY (`idt_atendimento_evento`) REFERENCES `grc_atendimento_evento` (`idt`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `grc_atendimento_evento_entrega_documento` (
  `idt` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idt_atendimento_evento_entrega` int(10) unsigned NOT NULL,
  `idt_documento` int(10) unsigned NOT NULL,
  `codigo` varchar(45) NOT NULL,
  PRIMARY KEY (`idt`),
  KEY `fk_grc_atendimento_evento_entrega_documento_1` (`idt_atendimento_evento_entrega`),
  KEY `fk_grc_atendimento_evento_entrega_documento_2` (`idt_documento`),
  CONSTRAINT `fk_grc_atendimento_evento_entrega_documento_2` FOREIGN KEY (`idt_documento`) REFERENCES `db_pir_gec`.`gec_documento` (`idt`),
  CONSTRAINT `fk_grc_atendimento_evento_entrega_documento_1` FOREIGN KEY (`idt_atendimento_evento_entrega`) REFERENCES `grc_atendimento_evento_entrega` (`idt`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `grc_atendimento_evento_pagamento` (
  `idt` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idt_atendimento_evento` int(10) unsigned NOT NULL,
  `idt_evento_situacao_pagamento` int(10) unsigned NOT NULL,
  `data_vencimento` date DEFAULT NULL,
  `data_pagamento` date DEFAULT NULL,
  `valor_pagamento` decimal(15,2) DEFAULT NULL,
  `idt_evento_natureza_pagamento` int(10) unsigned DEFAULT NULL,
  `idt_evento_cartao_bandeira` int(10) unsigned DEFAULT NULL,
  `idt_evento_forma_parcelamento` int(10) unsigned DEFAULT NULL,
  `codigo_nsu` varchar(45) DEFAULT NULL,
  `idt_evento_estabelecimento` int(10) unsigned DEFAULT NULL,
  `idt_evento_participante_contrato` int(10) unsigned DEFAULT NULL,
  `estornado` char(1) NOT NULL DEFAULT 'N',
  `estornar_rm` char(1) NOT NULL DEFAULT 'N',
  `origem_reg` varchar(50) NOT NULL DEFAULT 'PIR',
  `lojasiac_id` int(10) DEFAULT NULL,
  `rm_idmov` int(10) DEFAULT NULL,
  `ch_numero` varchar(50) DEFAULT NULL,
  `ch_banco` varchar(50) DEFAULT NULL,
  `ch_agencia` varchar(50) DEFAULT NULL,
  `ch_cc` varchar(50) DEFAULT NULL,
  `emitente_nome` varchar(120) DEFAULT NULL,
  `emitente_tel` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`idt`),
  KEY `fk_grc_atendimento_evento_pagamento_1` (`idt_atendimento_evento`),
  KEY `fk_grc_atendimento_evento_pagamento_2` (`idt_evento_natureza_pagamento`),
  KEY `fk_grc_atendimento_evento_pagamento_3` (`idt_evento_cartao_bandeira`),
  KEY `fk_grc_atendimento_evento_pagamento_4` (`idt_evento_forma_parcelamento`),
  KEY `fk_grc_atendimento_evento_pagamento_5` (`idt_evento_participante_contrato`),
  KEY `fk_grc_atendimento_evento_pagamento_6` (`idt_evento_situacao_pagamento`),
  KEY `fk_grc_atendimento_evento_pagamento_7` (`idt_evento_estabelecimento`),
  CONSTRAINT `fk_grc_atendimento_evento_pagamento_7` FOREIGN KEY (`idt_evento_estabelecimento`) REFERENCES `grc_evento_estabelecimento` (`idt`),
  CONSTRAINT `fk_grc_atendimento_evento_pagamento_1` FOREIGN KEY (`idt_atendimento_evento`) REFERENCES `grc_atendimento_evento` (`idt`),
  CONSTRAINT `fk_grc_atendimento_evento_pagamento_2` FOREIGN KEY (`idt_evento_natureza_pagamento`) REFERENCES `grc_evento_natureza_pagamento` (`idt`),
  CONSTRAINT `fk_grc_atendimento_evento_pagamento_3` FOREIGN KEY (`idt_evento_cartao_bandeira`) REFERENCES `grc_evento_cartao_bandeira` (`idt`),
  CONSTRAINT `fk_grc_atendimento_evento_pagamento_4` FOREIGN KEY (`idt_evento_forma_parcelamento`) REFERENCES `grc_evento_forma_parcelamento` (`idt`),
  CONSTRAINT `fk_grc_atendimento_evento_pagamento_5` FOREIGN KEY (`idt_evento_participante_contrato`) REFERENCES `grc_evento_participante_contrato` (`idt`),
  CONSTRAINT `fk_grc_atendimento_evento_pagamento_6` FOREIGN KEY (`idt_evento_situacao_pagamento`) REFERENCES `grc_evento_situacao_pagamento` (`idt`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_atendimento_evento','Evento no Atendimento','05.01.64','S','N','listar','listar');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_atendimento_evento') as id_funcao
from plu_direito where cod_direito in ('alt','con','inc','exc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_atendimento_evento');

insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_atendimento_evento_anexo','Anexo do Evento no Atendimento','05.01.64.05','S','N','listar','listar');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_atendimento_evento_anexo') as id_funcao
from plu_direito where cod_direito in ('alt','con','inc','exc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_atendimento_evento_anexo');

insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_atendimento_evento_dimensionamento','Dimensionamento do Evento no Atendimento','05.01.64.10','S','N','listar','listar');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_atendimento_evento_dimensionamento') as id_funcao
from plu_direito where cod_direito in ('alt','con');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_atendimento_evento_dimensionamento');

insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_atendimento_evento_entrega','Entregas do Evento no Atendimento','05.01.64.15','S','N','listar','listar');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_atendimento_evento_entrega') as id_funcao
from plu_direito where cod_direito in ('con');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_atendimento_evento_entrega');

insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_atendimento_evento_entrega_documento','Entregas do Evento (Documento) no Atendimento','05.01.64.15.05','S','N','listar','listar');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_atendimento_evento_entrega_documento') as id_funcao
from plu_direito where cod_direito in ('alt','con','inc','exc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_atendimento_evento_entrega_documento');

insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_atendimento_evento_pagamento','Pagamentos do Evento no Atendimento','05.01.64.20','S','N','listar','listar');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_atendimento_evento_pagamento') as id_funcao
from plu_direito where cod_direito in ('alt','con','inc','exc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_atendimento_evento_pagamento');

-- 19/01/2017

ALTER TABLE `grc_atendimento_evento_dimensionamento`
ADD COLUMN `qtd`  decimal(10,2) NOT NULL AFTER `vl_unitario`,
ADD COLUMN `vl_total`  decimal(10,2) NOT NULL AFTER `qtd`;

-- 21/01/2017

ALTER TABLE `grc_atendimento_evento`
MODIFY COLUMN `idt_evento`  int(10) UNSIGNED NULL DEFAULT NULL AFTER `idt_atendimento`,
ADD COLUMN `gestor_sge`  varchar(120) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL AFTER `resultado_esperado`,
ADD COLUMN `qtd_previsto`  int(10) NULL DEFAULT NULL AFTER `gestor_sge`,
ADD COLUMN `qtd_realizado`  int(10) NULL DEFAULT NULL AFTER `qtd_previsto`,
ADD COLUMN `qtd_percentual`  decimal(15,2) NULL DEFAULT NULL AFTER `qtd_realizado`,
ADD COLUMN `qtd_saldo`  int(10) NULL DEFAULT NULL AFTER `qtd_percentual`,
ADD COLUMN `orc_previsto`  decimal(15,2) NULL DEFAULT NULL AFTER `qtd_saldo`,
ADD COLUMN `orc_realizado`  decimal(15,2) NULL DEFAULT NULL AFTER `orc_previsto`,
ADD COLUMN `orc_percentual`  decimal(15,2) NULL DEFAULT NULL AFTER `orc_realizado`,
ADD COLUMN `orc_saldo`  decimal(15,2) NULL DEFAULT NULL AFTER `orc_percentual`,
ADD COLUMN `idt_gestor_projeto`  int(10) NULL DEFAULT NULL AFTER `orc_saldo`,
ADD COLUMN `idt_unidade`  int(10) UNSIGNED NULL DEFAULT NULL AFTER `idt_gestor_projeto`,
ADD COLUMN `ano_competencia`  char(4) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL AFTER `idt_unidade`;

ALTER TABLE `grc_atendimento_evento`
MODIFY COLUMN `idt_gestor_projeto`  int(10) NULL DEFAULT NULL AFTER `gestor_sge`,
MODIFY COLUMN `idt_unidade`  int(10) UNSIGNED NULL DEFAULT NULL AFTER `idt_gestor_projeto`,
MODIFY COLUMN `ano_competencia`  char(4) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL AFTER `idt_unidade`,
ADD COLUMN `fase_acao_projeto`  varchar(120) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL AFTER `gestor_sge`;

ALTER TABLE `grc_atendimento_evento`
ADD COLUMN `idt_ponto_atendimento`  int(11) NULL DEFAULT NULL AFTER `idt_unidade`,
ADD COLUMN `idt_ponto_atendimento_tela`  int(11) NULL DEFAULT NULL AFTER `idt_ponto_atendimento`;

ALTER TABLE `grc_atendimento_evento_entrega_documento` DROP FOREIGN KEY `fk_grc_atendimento_evento_entrega_documento_1`;

ALTER TABLE `grc_atendimento_evento_entrega_documento` ADD CONSTRAINT `fk_grc_atendimento_evento_entrega_documento_1` FOREIGN KEY (`idt_atendimento_evento_entrega`) REFERENCES `grc_atendimento_evento_entrega` (`idt`) ON DELETE CASCADE ON UPDATE RESTRICT;

-- 25/01/2016

ALTER TABLE `grc_atendimento_evento`
ADD COLUMN `resumo_tot`  decimal(15,2) NULL DEFAULT NULL AFTER `orc_saldo`,
ADD COLUMN `resumo_sub`  decimal(15,2) NULL DEFAULT NULL AFTER `resumo_tot`,
ADD COLUMN `resumo_pag`  decimal(15,2) NULL DEFAULT NULL AFTER `resumo_sub`;

ALTER TABLE `grc_atendimento_evento`
MODIFY COLUMN `resumo_tot`  decimal(15,2) NOT NULL DEFAULT 0 AFTER `orc_saldo`,
MODIFY COLUMN `resumo_sub`  decimal(15,2) NOT NULL DEFAULT 0 AFTER `resumo_tot`,
MODIFY COLUMN `resumo_pag`  decimal(15,2) NOT NULL DEFAULT 0 AFTER `resumo_sub`;

ALTER TABLE `grc_atendimento_evento`
ADD COLUMN `entrega_prazo_max`  int(10) NULL DEFAULT NULL AFTER `resumo_pag`,
ADD COLUMN `vl_determinado`  char(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL AFTER `entrega_prazo_max`;

ALTER TABLE `grc_evento`
ADD COLUMN `entrega_prazo_max`  int(10) NULL DEFAULT NULL AFTER `tipo_sincroniza_siacweb_old`,
ADD COLUMN `vl_determinado`  char(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL AFTER `entrega_prazo_max`;

-- 26/01/2016

ALTER TABLE `grc_evento_agenda`
ADD COLUMN `sgtec_percentual`  decimal(15,4) NULL AFTER `carga_horaria_real`,
ADD COLUMN `sgtec_ordem`  int(10) UNSIGNED NULL DEFAULT 0 AFTER `sgtec_percentual`;

-- 27/01/2016

CREATE TABLE `grc_evento_dimensionamento` (
  `idt` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idt_evento` int(10) unsigned NOT NULL,
  `idt_insumo_dimensionamento` int(10) unsigned NOT NULL,
  `codigo` varchar(45) NOT NULL,
  `descricao` varchar(120) NOT NULL,
  `detalhe` text,
  `idt_insumo_unidade` int(10) unsigned NOT NULL,
  `vl_unitario` decimal(10,2) NOT NULL,
  PRIMARY KEY (`idt`),
  UNIQUE KEY `iu_grc_evento_dimensionamento` (`codigo`,`idt_evento`) USING BTREE,
  KEY `fk_grc_evento_dimensionamento_1` (`idt_insumo_unidade`),
  KEY `fk_grc_evento_dimensionamento_2` (`idt_evento`),
  KEY `fk_grc_evento_dimensionamento_3` (`idt_insumo_dimensionamento`),
  CONSTRAINT `fk_grc_evento_dimensionamento_3` FOREIGN KEY (`idt_insumo_dimensionamento`) REFERENCES `grc_insumo_dimensionamento` (`idt`),
  CONSTRAINT `fk_grc_evento_dimensionamento_1` FOREIGN KEY (`idt_insumo_unidade`) REFERENCES `grc_insumo_unidade` (`idt`),
  CONSTRAINT `fk_grc_evento_dimensionamento_2` FOREIGN KEY (`idt_evento`) REFERENCES `grc_evento` (`idt`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `grc_evento_entrega` (
  `idt` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idt_evento` int(10) unsigned NOT NULL,
  `codigo` varchar(45) NOT NULL,
  `descricao` varchar(120) NOT NULL,
  `detalhe` text,
  `percentual` decimal(15,4) NOT NULL,
  `ordem` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`idt`),
  UNIQUE KEY `iu_grc_evento_entrega_1` (`codigo`,`idt_evento`) USING BTREE,
  KEY `fk_grc_evento_entrega_1` (`idt_evento`),
  CONSTRAINT `fk_grc_evento_entrega_1` FOREIGN KEY (`idt_evento`) REFERENCES `grc_evento` (`idt`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `grc_evento_entrega_documento` (
  `idt` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idt_evento_entrega` int(10) unsigned NOT NULL,
  `idt_documento` int(10) unsigned NOT NULL,
  `codigo` varchar(45) NOT NULL,
  PRIMARY KEY (`idt`),
  KEY `fk_grc_evento_entrega_documento_1` (`idt_evento_entrega`),
  KEY `fk_grc_evento_entrega_documento_2` (`idt_documento`),
  CONSTRAINT `fk_grc_evento_entrega_documento_2` FOREIGN KEY (`idt_documento`) REFERENCES `db_pir_gec`.`gec_documento` (`idt`),
  CONSTRAINT `fk_grc_evento_entrega_documento_1` FOREIGN KEY (`idt_evento_entrega`) REFERENCES `grc_evento_entrega` (`idt`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_evento_dimensionamento','Dimensionamento do Evento','02.03.56','S','N','listar','listar');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_evento_dimensionamento') as id_funcao
from plu_direito where cod_direito in ('alt','con');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_evento_dimensionamento');

insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_evento_entrega','Entregas do Evento','02.03.57','S','N','listar','listar');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_evento_entrega') as id_funcao
from plu_direito where cod_direito in ('con');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_evento_entrega');

insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_evento_entrega_documento','Entregas do Evento (Documento)','02.03.57.05','S','N','listar','listar');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_evento_entrega_documento') as id_funcao
from plu_direito where cod_direito in ('alt','con','inc','exc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_evento_entrega_documento');

ALTER TABLE `grc_evento_agenda`
DROP COLUMN `sgtec_percentual`,
DROP COLUMN `sgtec_ordem`;

ALTER TABLE `grc_evento_dimensionamento`
ADD COLUMN `idt_atendimento`  int(10) UNSIGNED NULL AFTER `idt_evento`;

ALTER TABLE `grc_evento_dimensionamento` ADD CONSTRAINT `fk_grc_evento_dimensionamento_4` FOREIGN KEY (`idt_atendimento`) REFERENCES `grc_atendimento` (`idt`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `grc_evento_entrega`
ADD COLUMN `idt_atendimento`  int(10) UNSIGNED NULL AFTER `idt_evento`;

ALTER TABLE `grc_evento_entrega` ADD CONSTRAINT `fk_grc_evento_entrega_4` FOREIGN KEY (`idt_atendimento`) REFERENCES `grc_atendimento` (`idt`) ON DELETE RESTRICT ON UPDATE RESTRICT;

-- 31/01/2017

ALTER TABLE `grc_evento_dimensionamento`
ADD COLUMN `qtd`  decimal(10,2) NOT NULL AFTER `vl_unitario`,
ADD COLUMN `vl_total`  decimal(10,2) NOT NULL AFTER `qtd`;

ALTER TABLE `grc_atendimento_evento_dimensionamento`
ADD UNIQUE INDEX `iu_grc_atendimento_evento_dimensionamento_1` (`idt_insumo_dimensionamento`, `idt_atendimento_evento`) USING BTREE ;

ALTER TABLE `grc_produto_dimensionamento`
ADD UNIQUE INDEX `iu_grc_produto_dimensionamento_1` (`idt_insumo_dimensionamento`, `idt_produto`) USING BTREE ;

ALTER TABLE `grc_evento_dimensionamento`
ADD UNIQUE INDEX `iu_grc_evento_dimensionamento_1` (`idt_insumo_dimensionamento`, `idt_atendimento`) USING BTREE ;

UPDATE `plu_painel_funcao` SET `texto_cab`='Programa Credenciado' WHERE (`idt`='220');

INSERT INTO `db_pir_grc`.`plu_painel_funcao` (`idt_painel_grupo`, `id_funcao`, `pos_top`, `pos_left`, `imagem`, `imagem_d`, `texto_cab`, `detalhe`, `visivel`, `hint`, `parametros`, `texto_font_tam`, `texto_ativ_font_cor`, `texto_ativ_fundo`, `texto_desativ_font_cor`, `texto_desativ_fundo`, `include`, `include_arq`, `include_altura`, `include_largura`) VALUES ('16', '743', '0', '0', NULL, NULL, 'Programa', NULL, 'S', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'N', NULL, NULL, NULL);

-- 01/02/2017

-- não é mais usado
-- INSERT INTO `db_pir_gec`.`gec_meio_informacao` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`) VALUES ('10', '10', 'Orientação Técnica', 'S', NULL);

-- 02/02/2017

ALTER TABLE `grc_evento`
ADD COLUMN `sgtec_modelo`  char(1) NOT NULL DEFAULT 'E' AFTER `resultados_obtidos`;

update grc_evento set sgtec_modelo = 'H';

-- 03/02/2017

ALTER TABLE `grc_evento_entrega`
ADD COLUMN `mesano`  char(7) NULL AFTER `ordem`;

ALTER TABLE `grc_atendimento_evento_dimensionamento`
MODIFY COLUMN `qtd`  decimal(10,2) NOT NULL DEFAULT 0 AFTER `vl_unitario`,
MODIFY COLUMN `vl_total`  decimal(10,2) NOT NULL DEFAULT 0 AFTER `qtd`;

-- 06/02/2017

ALTER TABLE `grc_produto`
ADD COLUMN `tempo_medio`  decimal(10,2) NULL AFTER `vl_determinado`;

ALTER TABLE `grc_produto`
ADD COLUMN `vl_teto`  decimal(10,2) NULL AFTER `tempo_medio`;

-- 08/02/2017

delete from plu_direito_funcao
where id_direito in (select id_direito from plu_direito where cod_direito in ('alt','inc','exc'))
and id_funcao in (select id_funcao from plu_funcao where cod_funcao in ('grc_atendimento_evento_entrega', 'grc_evento_entrega'));

-- 10/02/2017

ALTER TABLE `grc_evento_entrega` DROP FOREIGN KEY `fk_grc_evento_entrega_4`;

ALTER TABLE `grc_evento_entrega` ADD CONSTRAINT `fk_grc_evento_entrega_4` FOREIGN KEY (`idt_atendimento`) REFERENCES `grc_atendimento` (`idt`) ON DELETE CASCADE ON UPDATE RESTRICT;

ALTER TABLE `grc_evento_entrega_documento` DROP FOREIGN KEY `fk_grc_evento_entrega_documento_1`;

ALTER TABLE `grc_evento_entrega_documento` ADD CONSTRAINT `fk_grc_evento_entrega_documento_1` FOREIGN KEY (`idt_evento_entrega`) REFERENCES `grc_evento_entrega` (`idt`) ON DELETE CASCADE ON UPDATE RESTRICT;

ALTER TABLE `grc_evento_dimensionamento` DROP FOREIGN KEY `fk_grc_evento_dimensionamento_4`;

ALTER TABLE `grc_evento_dimensionamento` ADD CONSTRAINT `fk_grc_evento_dimensionamento_4` FOREIGN KEY (`idt_atendimento`) REFERENCES `grc_atendimento` (`idt`) ON DELETE CASCADE ON UPDATE RESTRICT;

ALTER TABLE `grc_evento_dimensionamento`
DROP INDEX `iu_grc_evento_dimensionamento` ,
ADD UNIQUE INDEX `iu_grc_evento_dimensionamento` (`codigo`, `idt_atendimento`) USING BTREE ;

ALTER TABLE `grc_evento_entrega`
DROP INDEX `iu_grc_evento_entrega_1` ,
ADD UNIQUE INDEX `iu_grc_evento_entrega_1` (`codigo`, `idt_atendimento`) USING BTREE ;

-- 14/02/2017

ALTER TABLE `grc_evento_entrega`
ADD COLUMN `consolidado_cred`  char(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'N' AFTER `mesano`,
ADD COLUMN `consolidado_siacweb`  char(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'N' AFTER `consolidado_cred`,
ADD COLUMN `siacweb_codatividade`  int(10) NULL DEFAULT NULL AFTER `consolidado_siacweb`;

-- 17/02/2017

ALTER TABLE `grc_evento_entrega`
DROP COLUMN `consolidado_cred`,
DROP COLUMN `consolidado_siacweb`,
DROP COLUMN `siacweb_codatividade`;

ALTER TABLE `grc_evento_entrega`
ADD COLUMN `idt_evento_agenda`  int(10) UNSIGNED NULL AFTER `idt_atendimento`;

ALTER TABLE `grc_evento_entrega` ADD CONSTRAINT `fk_grc_evento_entrega_2` FOREIGN KEY (`idt_evento_agenda`) REFERENCES `grc_evento_agenda` (`idt`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `grc_evento_entrega`
ADD COLUMN `valor`  decimal(15,2) NULL AFTER `mesano`;

ALTER TABLE `grc_evento_participante_pagamento`
ADD COLUMN `operacao`  char(1) NOT NULL DEFAULT 'C' AFTER `idt_evento_situacao_pagamento`;

ALTER TABLE `grc_evento_participante`
ADD COLUMN `vl_tot_devolucao`  decimal(15,2) NULL DEFAULT NULL AFTER `vl_tot_pagamento`;

ALTER TABLE `grc_evento_participante`
CHANGE COLUMN `vl_tot_devolucao` `vl_tot_pagamento_real`  decimal(15,2) NULL DEFAULT NULL AFTER `vl_tot_pagamento`;

ALTER TABLE `grc_evento_situacao_pagamento`
MODIFY COLUMN `lojasiac_status`  int(10) NULL AFTER `ativo`;

INSERT INTO `db_pir_grc`.`grc_evento_situacao_pagamento` (`idt`, `codigo`, `descricao`, `ativo`, `lojasiac_status`) VALUES ('7', 'DE', 'Devolução', 'S', null);

-- 03/03/2017

INSERT INTO `db_pir_grc`.`plu_config` (`variavel`, `descricao`, `valor`, `extra`, `js`, `classificacao`) VALUES ('produto_limite_teto', 'Limite do Teto no Produto', '30000', NULL, 'N', NULL);

-- 04/03/2017

INSERT INTO `db_pir_grc`.`grc_parametros` (`codigo`, `descricao`, `ativo`, `html`, `detalhe`, `classificacao`) VALUES ('evento_modelo_contrato_sg_cont', 'Modelo do Contrato para o Evento SebraeTEC', 'S', 'S', '<div style=\"border:1px solid #000000; padding:5px;\">\r\n    <b>Serviço de Apoio às Micro e Pequenas Empresas</b>, doravante denominado #sebrae_nome#, localizado na cidade de #sebrae_cidade# / #sebrae_estado#, Bairro #sebrae_bairro#, CNPJ nº #sebrae_cnpj#, Inscrição Estadual nº #sebrae_ie#.\r\n</div>\r\n<br />e<br /><br />\r\n<div style=\"border:1px solid #000000; padding:5px;\">\r\n    #empresa_nome#, doravante denominado (a) <b>CONTRATANTE</b>, localizado na cidade de #empresa_cidade# / #empresa_estado#, Bairro #empresa_bairro#, CEP: #empresa_cep#, Telefone: #empresa_telefone#,CNPJ nº #empresa_cnpj#, neste ato representado(a) por #representante_nome# e CPF nº #representante_cpf#.\r\n</div>\r\n<br />\r\nAjustam entre si o presente <b>CONTRATO</b>, mediante as seguintes cláusulas e condições:<br />\r\n<br />\r\n<b>CLÁUSULA PRIMEIRA - DO OBJETO</b><br />\r\n1.1 - Constitui objeto deste CONTRATO, o estabelecimento de termos e condições para viabilizar a participação do (a) CONTRATANTE em:<br />\r\n<br />\r\n<table width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" border=\"1\">\r\n    <tr>\r\n        <td style=\"text-align:center; background:#C0C0C0;\"><b>Vagas</b></td>\r\n        <td style=\"text-align:center; background:#C0C0C0;\"><b>Agenda</b></td>\r\n        <td style=\"text-align:center; background:#C0C0C0;\"><b>Data de Realização</b></td>\r\n        <td style=\"text-align:center; background:#C0C0C0;\"><b>Local da Realização</b></td> \r\n    </tr>\r\n    <tr>\r\n        <td style=\"text-align: center;\">#evento_vagas#</td>\r\n        <td>#evento_nome#</td>\r\n        <td style=\"text-align: center;\">#agenda_data#</td>\r\n        <td>#agenda_local#</td>\r\n    </tr>\r\n</table><br />\r\n1.2 - Será considerado (a) como Beneficiário (a) do presente curso o (s) aluno (a)(s):<br />\r\n<br />\r\n<table width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" border=\"1\">\r\n    <tr>\r\n        <td style=\"text-align:center; background:#C0C0C0;\"><b>Agenda</b></td>\r\n        <td style=\"text-align:center; background:#C0C0C0;\"><b>Aluno (a)</b></td> \r\n    </tr>\r\n    <tr>\r\n        <td>#evento_nome#</td>\r\n        <td>#insc_nome#</td>\r\n    </tr>\r\n</table><br />\r\n<b>CLÁUSULA SEGUNDA - DAS RESPONSABILIDADES DAS PARTES</b><br />\r\n2.1 - Do #sebrae_nome#.:<br />\r\n2.1.1 - Desenvolver na integridade o objeto deste CONTRATO;<br />\r\n2.1.2 - Entregar ao(a) CONTRATANTE o certificado de participação no curso, mediante frequência mínima das horas/aula ministradas e cumprimento da integralidade das atividades obrigatórias do (s) curso(s):<br />\r\n<br />\r\n<table width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" border=\"1\">\r\n    <tr>\r\n        <td style=\"text-align:center; background:#C0C0C0;\"><b>Agenda</b></td>\r\n        <td style=\"text-align:center; background:#C0C0C0;\"><b>Frequência (%)</b></td> \r\n    </tr>\r\n    <tr>\r\n        <td>#evento_nome#</td>\r\n        <td style=\"text-align: center;\">#evento_freq#</td>\r\n    </tr>\r\n</table><br />\r\n2.2 - <b>Da CONTRATANTE</b>:<br />\r\n2.2.1 - Participar ou indicar participante do curso contratado, observando a frequência mínima fixada neste CONTRATO;<br />\r\n2.2.2 - Efetuar o pagamento do valor pactuado neste CONTRATO;<br />\r\n2.2.3 - Não reproduzir os materiais didáticos ou utilizar a metodologia adotada no curso sem prévia e formal autorização do #sebrae_nome#.<br />\r\n2.2.4 - Avaliar o curso contratado após sua participação.<br />\r\n<br />\r\n<b>CLÁUSULA TERCEIRA - DO PRAZO</b><br />\r\n3.1 - O presente <b>CONTRATO</b> terá vigência pelo período de #dt_atual# a #n+dt_atual#, podendo ser alterado desde que acordado entre as partes e retratado através de termo aditivo, conforme legislação em vigor.<br />\r\n<br />\r\n<b>CLÁUSULA QUARTA - DO VALOR E FORMA DE PAGAMENTO</b><br />\r\n4.1 - Para a realização completa do objeto deste CONTRATO, o (a) CONTRATANTE pagará ao #sebrae_nome# o valor total de R$#pagamento_tot# (#pagamento_desc#), da seguinte forma:<br />\r\n4.1.1 - O valor contratado no item 4.1 será pago por meio de:<br />\r\n<table width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" border=\"1\">\r\n    <tr>\r\n        <td style=\"text-align:center; background:#C0C0C0;\"><b>Forma de Pagamento</b></td>\r\n        <td style=\"text-align:center; background:#C0C0C0;\"><b>Porcentagem Pagamento</b></td> \r\n        <td style=\"text-align:center; background:#C0C0C0;\"><b>Valor do Pagamento (R$)</b></td> \r\n    </tr>\r\n    <tr>\r\n        <td>#pagamento_forma#</td>\r\n        <td style=\"text-align: center;\">#pagamento_porc#</td>\r\n        <td style=\"text-align: center;\">#pagamento_valor#</td>\r\n    </tr>\r\n</table><br />\r\n4.2 - Deixando o(a) CONTRATANTE de efetuar o pagamento na forma descrita neste CONTRATO ficará constituído(a) em mora, devendo pagar ao  #sebrae_nome#, além do(s) valor (es) em atraso (principal), os seguintes acréscimos:<br />\r\n<br />\r\n4.2.1 - multa de 2% (dois por cento) sobre o valor principal, atualizado na forma abaixo;<br />\r\n<br />\r\n4.2.2 - juros de mora de 1% (um por cento) ao mês.<br />\r\n<br />\r\n4.3 - As parcelas devidas pelo (a) CONTRATANTE, por força deste CONTRATO, assim como correspondentes acréscimos, constituirão dívida líquida e certa, passível de cobrança executiva, independente de notificação extrajudicial ou judicial.<br />\r\n<br />\r\n4.4 - Se na vigência deste CONTRATO tolerar o #sebrae_nome#, direta ou indiretamente, qualquer atraso ou demora de pagamento do valor pactuado ou no cumprimento de qualquer outra obrigação contratual, esse fato não poderá, jamais, ser considerado como renúncia ou modificação das condições do contrato, que permanecerão em pleno vigor, para todos os efeitos jurídicos.<br />\r\n<br />\r\n<b>CLÁUSULA QUINTA - DA RESCISÃO</b><br />\r\n5.1 - O #sebrae_nome# reserva-se o direito de não realizar o objeto deste <b>CONTRATO</b> caso o número de requerimentos não atinja o mínimo de:<br />\r\n<br />\r\n<table width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" border=\"1\">\r\n    <tr>\r\n        <td style=\"text-align:center; background:#C0C0C0;\"><b>Agenda</b></td>\r\n        <td style=\"text-align:center; background:#C0C0C0;\"><b>Número Mínimo de Participantes</b></td> \r\n    </tr>\r\n    <tr>\r\n        <td>#evento_nome#</td>\r\n        <td style=\"text-align: center;\">#evento_min_pag#</td>\r\n    </tr>\r\n</table><br />\r\n5.1.1 - Ocorrendo a hipótese prevista no item 5.1, o valor eventualmente pago será integralmente devolvido ao (à) CONTRATANTE sem direito a qualquer reparação.<br />\r\n<br />\r\n5.2 - O não cumprimento pelas partes das obrigações assumidas neste <b>CONTRATO</b> importará em sua rescisão de pleno direito, independentemente de interpelação judicial.<br />\r\n<br />\r\n<b>CLÁUSULA SEXTA - DA DESISTÊNCIA</b><br />\r\n6.1 - O(A) <b>CONTRATANTE</b> terá um prazo de até 07 (sete) dias de antecedência do início do treinamento, para desistir do objeto ora contratado, sendo-lhe garantida a devolução integral do valor pago até o momento da sua desistência.<br />\r\n<br />\r\n6.1.1 - Após o prazo fixado neste item e até a data de início do treinamento, a desistência do(a) <b>CONTRATANTE</b> de participar do treinamento, objeto deste <b>CONTRATO</b>, importará no pagamento, a título de multa, de 50% (cinquenta por cento) do valor total do <b>CONTRATO</b>.<br />\r\n<br />\r\n6.1.2 - Vencido o prazo disposto no subitem 6.1.1 supra, a desistência do (a) <b>CONTRATANTE</b> importará na obrigação pelo pagamento do valor integral deste <b>CONTRATO</b>.<br />\r\n<br />\r\n6.1.3 - A desistência deverá ser feita por escrito, devidamente protocolada junto à Unidade do #sebrae_nome# na qual foi feita a contratação;<br />\r\n<br />\r\n6.2 - O simples não comparecimento ao curso e/ou a não participação nas atividades previstas não desobriga o (a) <b>CONTRATANTE</b> do pagamento das parcelas contratadas.<br />\r\n<br />\r\n<b>CLÁUSULA SÉTIMA - DOS ENCARGOS</b><br />\r\n7.1 - As obrigações fiscais, trabalhistas e previdenciárias, relativas à execução do objeto deste <b>CONTRATO</b> serão de responsabilidade exclusiva do #sebrae_nome# que, desde já, exime o (a) <b>CONTRATANTE</b> de qualquer responsabilidade ou vínculo com o pessoal utilizado na execução dos serviços, objeto deste <b>CONTRATO</b>.<br />\r\n<br />\r\n<b>CLÁUSULA OITAVA - DAS DISPOSIÇÕES GERAIS</b><br />\r\n8.1 - Casos omissos e modificações serão resolvidas entre as partes através de Termos Aditivos, que farão parte integrante deste CONTRATO.<br />\r\n<br />\r\n8.2 - Fica eleito o Foro da Comarca de #sebrae_cidade#, Estado de #sebrae_estado# que será o competente para dirimir dúvidas decorrentes da execução deste CONTRATO, com renúncia expressa de qualquer outro, por mais privilegiado que seja.<br />\r\n<br />\r\nE por estarem assim, justas e contratadas, assinam as partes o presente CONTRATO, em 02 (duas vias) de igual teor e forma, para um só efeito, na presença das testemunhas abaixo, que também o assinam.<br />\r\n<br />\r\n<br />\r\n<br />\r\n#hoje#.<br />\r\n<br />\r\n<br />\r\n<br />\r\n<table width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\">\r\n    <tr>\r\n        <td style=\"text-align:center; width: 47%; height: 60px; vertical-align: top;\"><b>CONTRATADA</b></td>\r\n        <td style=\"text-align:center; width: 6%; height: 60px; vertical-align: top;\"></td>\r\n        <td style=\"text-align:center; width: 47%; height: 60px; vertical-align: top;\"><b>CONTRATANTE</b></td> \r\n    </tr>\r\n    <tr>\r\n        <td style=\"text-align:center; border-top: 1px solid black;\">#sebrae_nome#</td>\r\n        <td></td>\r\n        <td style=\"text-align:center; border-top: 1px solid black;\">#empresa_nome#</td>\r\n    </tr>\r\n</table><br />\r\n<br />\r\n<br />\r\n<br />\r\nTESTEMUNHAS<br />\r\n<table width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\">\r\n    <tr>\r\n        <td style=\"text-align:center; width: 47%; height: 60px; vertical-align: top;\"></td>\r\n        <td style=\"text-align:center; width: 6%; height: 60px; vertical-align: top;\"></td>\r\n        <td style=\"text-align:center; width: 47%; height: 60px; vertical-align: top;\"></td> \r\n    </tr>\r\n    <tr>\r\n        <td style=\"border-top: 1px solid black;\">CPF:</td>\r\n        <td></td>\r\n        <td style=\"border-top: 1px solid black;\">CPF:</td>\r\n    </tr>\r\n</table>', '02.03');
INSERT INTO `db_pir_grc`.`grc_parametros` (`codigo`, `descricao`, `ativo`, `html`, `detalhe`, `classificacao`) VALUES ('evento_modelo_contrato_sg_cab', 'Modelo do Contrato para o Evento SebraeTEC (Cabeçalho)', 'S', 'S', '<table width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\">\r\n    <tbody>\r\n        <tr>\r\n            <td valign=\"top\" style=\"width:20%;\" rowspan=\"4\" id=\"logo\"><img width=\"236\" height=\"76\" align=\"top\" alt=\"\" src=\"/sebrae_grc/admin/fckupload/images/logo_sebrae.jpg\" /></td>\r\n            <td style=\"text-align:right; width:80%;\" id=\"titulo_1\"><b>Contrato de Receita do Participante</b></td>\r\n        </tr>\r\n        <tr>\r\n            <td style=\"text-align:right; width:100%;\" id=\"titulo_2\"><b>Cliente: #empresa_nome#</b></td>\r\n        </tr>\r\n        <tr>\r\n            <td style=\"text-align:right; width:100%;\" id=\"titulo_3\">&nbsp;</td>\r\n        </tr>\r\n        <tr>\r\n            <td style=\"text-align:right; width:100%;\" id=\"titulo_4\">&nbsp;</td>\r\n        </tr>\r\n    </tbody>\r\n</table>', '02.04');
INSERT INTO `db_pir_grc`.`grc_parametros` (`codigo`, `descricao`, `ativo`, `html`, `detalhe`, `classificacao`) VALUES ('evento_modelo_contrato_sg_rod', 'Modelo do Contrato para o Evento SebraeTEC (Rodape)', 'S', 'S', NULL, '02.05');

-- 10/03/2017

ALTER TABLE `grc_projeto_acao`
ADD COLUMN `contrapartida_sgtec`  decimal(15,2) NULL AFTER `idt_unidade`;

-- 14/03/2017

UPDATE `db_pir_grc`.`grc_parametros` SET `codigo`='evento_modelo_contrato_sg_cont', `descricao`='Modelo do Contrato para o Evento SebraeTEC', `ativo`='S', `html`='S', `detalhe`='<p><style type=\"text/css\">\r\n    table.bordasimples {\r\n        border-collapse: collapse;\r\n    }\r\n\r\n    table.bordasimples tr td {\r\n        border:1px solid black;\r\n    }\r\n\r\n    div.margem table {\r\n        width: 100%;\r\n    }\r\n\r\n</style></p>\r\n<div class=\"margem\">\r\n<div style=\"background:#4f81bd; color: white; font-weight: bold; overflow: hidden; margin-bottom: 20px\">\r\n<div style=\"text-align: center; width: 60%; float: left\">TERMO DE ADES&Atilde;O E COMPROMISSO</div>\r\n<div style=\"text-align: center; width: 40%; float: left\">N&ordm; DO EVENTO:&nbsp;#numero_evento#</div>\r\n</div>\r\n<table class=\"bordasimples\">\r\n    <tbody>\r\n        <tr style=\"background:#4f81bd; color: white; font-weight: bold; text-align: left;\">\r\n            <td colspan=\"2\" style=\"border: 1px solid #4f81bd\">EMPRESA DEMANDANTE</td>\r\n        </tr>\r\n        <tr>\r\n            <td colspan=\"2\" style=\"border: 1px solid black\"><strong>CNPJ ou equivalente:</strong>&nbsp;#cnpj_equivalente#</td>\r\n        </tr>\r\n        <tr>\r\n            <td colspan=\"2\"><strong>Raz&atilde;o Social:</strong>&nbsp;#razao_social#</td>\r\n        </tr>\r\n        <tr>\r\n            <td style=\"width: 50%;\"><strong>Nome Fantasia:</strong>&nbsp;#nome_fantasia#</td>\r\n            <td style=\"width: 50%;\"><strong>Telefone:</strong>&nbsp;#telefone#</td>\r\n        </tr>\r\n        <tr>\r\n            <td style=\"width: 50%;\"><strong>Nome do Respons&aacute;vel:</strong>&nbsp;#nome_responsavel#</td>\r\n            <td style=\"width: 50%;\"><strong>CPF:</strong>&nbsp;#cpf#</td>\r\n        </tr>\r\n        <tr>\r\n            <td colspan=\"2\"><strong>E-mail:</strong>&nbsp;#email#</td>\r\n        </tr>\r\n        <tr>\r\n            <td style=\"width: 50%;\"><strong>Endere&ccedil;o:</strong>&nbsp;#endereco#</td>\r\n            <td style=\"width: 50%;\"><strong>Complemento:</strong>&nbsp;#complemento#</td>\r\n        </tr>\r\n        <tr>\r\n            <td style=\"width: 50%;\"><strong>Bairro:</strong>&nbsp;#bairro#</td>\r\n            <td style=\"width: 50%;\"><strong>Cidade:</strong>&nbsp;#cidade#</td>\r\n        </tr>\r\n        <tr>\r\n            <td colspan=\"2\"><strong>CEP:</strong>&nbsp;#cep#</td>\r\n        </tr>\r\n        <tr style=\"background:#4f81bd; color: white; font-weight: bold; text-align: left;\">\r\n            <td colspan=\"2\" style=\"border: 1px solid #4f81bd\">DADOS DO EVENTO</td>\r\n        </tr>\r\n        <tr>\r\n            <td style=\"width: 50%;\"><strong>Produto:</strong>&nbsp;#produto#</td>\r\n            <td style=\"width: 50%;\"><strong>N&uacute;mero do Evento:</strong>&nbsp;#numero_evento#</td>\r\n        </tr>\r\n        <tr>\r\n            <td style=\"width: 50%;\"><strong>Data Prevista de In&iacute;cio:</strong>&nbsp;#data_prevista_inicio#</td>\r\n            <td style=\"width: 50%;\"><strong>Data Prevista de T&eacute;rmino:</strong>&nbsp;#data_prevista_termino#</td>\r\n        </tr>\r\n        <tr>\r\n            <td colspan=\"2\"><strong>Tipo de Servi&ccedil;o:</strong>&nbsp;#tipo_servico#</td>\r\n        </tr>\r\n        <tr>\r\n            <td colspan=\"2\"><strong>Necessidade do Cliente:</strong>&nbsp;#necessidade_cliente#</td>\r\n        </tr>\r\n        <tr>\r\n            <td colspan=\"2\"><strong>Resultados Esperados:</strong>&nbsp;#resultados_esperados#</td>\r\n        </tr>\r\n        <tr>\r\n            <td colspan=\"2\"><strong>Tipo de Servi&ccedil;o:</strong>&nbsp;#tipo_servico#</td>\r\n        </tr>\r\n    </tbody>\r\n</table>\r\n<table class=\"bordasimples\">\r\n    <tbody>\r\n        <tr style=\"background:#4f81bd; color: white; font-weight: bold; text-align: left;\">\r\n            <td style=\"border: 1px solid #4f81bd\">ENTREGAS</td>\r\n        </tr>\r\n    </tbody>\r\n</table>\r\n#entregas#\r\n<table style=\"margin-top: 20px\">\r\n    <tbody>\r\n        <tr style=\"background:#4f81bd; color: white; font-weight: bold; text-align: left;\">\r\n            <td style=\"border: 1px solid #4f81bd\">CL&Aacute;USULA PRIMEIRA &ndash; DO PRE&Ccedil;O</td>\r\n        </tr>\r\n    </tbody>\r\n</table>\r\n<p>Por este instrumento, a &nbsp;#razao_social#&nbsp; assume o compromisso de efetuar o                          pagamento ao SEBRAE/BA, da import&acirc;ncia total de &nbsp;#valor_servico#&nbsp; (R$) pelos servi&ccedil;os referidos neste Termo de Ades&atilde;o                          e Compromisso.</p>\r\n<p><strong>Par&aacute;grafo Primeiro</strong> &ndash; A cota-parte do cliente ser&aacute; paga no Cart&atilde;o de d&eacute;bito; Cart&atilde;o de cr&eacute;dito, Boleto (&agrave; vista), Dinheiro, ou Cheque, de acordo com a orienta&ccedil;&atilde;o vigente.</p>\r\n<p><strong>Par&aacute;grafo Segundo</strong> &ndash; O n&atilde;o pagamento de qualquer das parcelas implicar&aacute;, conforme o caso, na suspens&atilde;o ou cancelamento do servi&ccedil;o e, a crit&eacute;rio do SEBRAE/BA, na ado&ccedil;&atilde;o de medidas legais cab&iacute;veis, judiciais ou extrajudiciais.</p>\r\n<p><strong>Par&aacute;grafo Terceiro</strong> &ndash; A &nbsp;#razao_social# compreende que est&aacute; arcando com cota parte de 30% do pre&ccedil;o do servi&ccedil;o em fun&ccedil;&atilde;o de subs&iacute;dio concedido pelo SEBRAE/BA.</p>\r\n<table style=\"margin-top: 20px; margin-bottom: 10px;\">\r\n    <tbody>\r\n        <tr style=\"background:#4f81bd; color: white; font-weight: bold; text-align: left;\">\r\n            <td style=\"border: 1px solid #4f81bd\">CL&Aacute;USULA SEGUNDA &ndash; DAS OBRIGA&Ccedil;&Otilde;ES</td>\r\n        </tr>\r\n    </tbody>\r\n</table>\r\n<p>I - S&atilde;o obriga&ccedil;&otilde;es da #razao_social#:</p>\r\n<p><strong> a) </strong> Avaliar as entregas de trabalhos realizadas pela ENTIDADE EXECUTORA (parcial e final).</p>\r\n<p><strong> b) </strong> Responsabilizar-se pelo efetivo repasse da cota-parte ao SEBRAE/BA.</p>\r\n<p><strong> c) </strong> Disponibilizar ao SEBRAE Nacional e/ou SEBRAE/BA, a qualquer tempo, informa&ccedil;&otilde;es sobre os servi&ccedil;os prestados, sobre os resultados obtidos ou sobre a ENTIDADE EXECUTORA contratada pelo SEBRAE/BA por meio do SEBRAETEC.</p>\r\n<p><strong> d) </strong> Cumprir as disposi&ccedil;&otilde;es previstas neste Edital.</p>\r\n<p><strong> e) </strong> Responsabilizar-se para que a utiliza&ccedil;&atilde;o dos recursos na presta&ccedil;&atilde;o de servi&ccedil;os n&atilde;o seja indevida ou desnecess&aacute;ria.</p>\r\n<p><strong> f) </strong> Receber os representantes do SEBRAE/BA com ou sem agendamento pr&eacute;vio.</p>\r\n<p><strong> g) </strong> Responder &agrave;s pesquisas de satisfa&ccedil;&atilde;o dos servi&ccedil;os prestados e da efetividade do SEBRAETEC realizadas pelo SEBRAE/BA e/ou pelo SEBRAE/NA, responsabilizando-se pela veracidade, exatid&atilde;o e completude das respostas.</p>\r\n<p><strong> h) </strong> Restituir ao SEBRAE/BA os valores investidos na proposta, caso haja comprova&ccedil;&atilde;o de a&ccedil;&atilde;o em conjunto com a ENTIDADE EXECUTORA para lesar o SEBRAE/BA.</p>\r\n<p><strong> i) </strong> Assinar a Carta Contrato antes do in&iacute;cio da presta&ccedil;&atilde;o de servi&ccedil;o, conforme padr&atilde;o definido no Sistema de contrata&ccedil;&atilde;o do SEBRAETEC.</p>\r\n<p><strong> j) </strong> Assinar o relat&oacute;rio final apenas ap&oacute;s o t&eacute;rmino completo do servi&ccedil;o, sob pena de restituir os valores pagos pelo SEBRAE/BA para a realiza&ccedil;&atilde;o do servi&ccedil;o, conforme padr&atilde;o definido no Sistema de contrata&ccedil;&atilde;o do SEBRAETEC.</p>\r\n<p><strong> k) </strong> Responder pelo pagamento proporcional dos servi&ccedil;os at&eacute; ent&atilde;o realizados em caso de solicita&ccedil;&atilde;o de distrato da proposta por sua pr&oacute;pria iniciativa.</p>\r\n<p><strong> l) </strong> Responsabilizar-se pelas informa&ccedil;&otilde;es prestadas no momento do atendimento.</p>\r\n<p><strong>Par&aacute;grafo &uacute;nico</strong> &ndash; Ap&oacute;s assinatura do Relat&oacute;rio Final a #razao_social# n&atilde;o poder&aacute; contestar, sob qualquer hip&oacute;tese, a revis&atilde;o do servi&ccedil;o prestado.</p>\r\n<p>II &ndash; S&atilde;o obriga&ccedil;&otilde;es do SEBRAE/BA:</p>\r\n<p>a. Contratar credenciada para executar os servi&ccedil;os decorrentes deste termo.</p>\r\n<p>b. Acompanhar toda a execu&ccedil;&atilde;o do servi&ccedil;o ora acordado, bem como subsidiar os custos nas condi&ccedil;&otilde;es estabelecidas.</p>\r\n<p>c. Efetuar, quando couber,  a devolu&ccedil;&atilde;o proporcional da cota-parte paga pelo cliente, nos casos em que este pagamento ocorra antes do processo de cota&ccedil;&atilde;o.</p>\r\n<p>d. Demais obriga&ccedil;&otilde;es impostas pelo Edital de Credenciamento SEBRAETEC vigente.</p>\r\n<table style=\"margin-top: 20px; margin-bottom: 10px;\">\r\n    <tbody>\r\n        <tr style=\"background:#4f81bd; color: white; font-weight: bold; text-align: left;\">\r\n            <td style=\"border: 1px solid #4f81bd\">CL&Aacute;USULA TERCEIRA &ndash; DO FORO</td>\r\n        </tr>\r\n    </tbody>\r\n</table>\r\n<p>Fica estabelecido entre as partes que o foro competente para a solu&ccedil;&atilde;o de qualquer lit&iacute;gio decorrente deste contrato &eacute; o de Salvador-BA, exclu&iacute;do qualquer outro.</p>\r\n<p>E, por assim terem acordado, assinam este Termo de Ades&atilde;o e Compromisso, em tr&ecirc;s vias de igual teor e forma.</p>\r\n<table style=\"margin-top: 20px; margin-bottom: 10px;\">\r\n    <tbody>\r\n        <tr>\r\n            <td style=\"padding-top: 20px; margin-bottom: 20px;\">\r\n            <p>#cidade_assinatura#, &nbsp;#data_assinatura#&nbsp; de &nbsp;#mes_assinatura#&nbsp; de &nbsp;#ano_assinatura#&nbsp;.</p>\r\n            </td>\r\n        </tr>\r\n    </tbody>\r\n</table>\r\n<table style=\"margin-top: 50px; margin-bottom: 50px\">\r\n    <tbody>\r\n        <tr>\r\n            <td style=\"width: 45%; vertical-align: top; text-align: center; border-top: 1px solid black; font-size: 12px; padding-top: 5px;\">#nome_responsavel#<br />\r\n            RESPONSAVEL PELA #razao_social#</td>\r\n            <td style=\"width: 10%; vertical-align: top;\">&nbsp;</td>\r\n            <td style=\"width: 45%; vertical-align: top; text-align: center; border-top: 1px solid black; font-size: 12px; padding-top: 5px;\">RESPONS&Aacute;VEL PELO ATENDIMENTO &ndash; SEBRAE/BA<br />\r\n            (N&atilde;o rubricar)</td>\r\n        </tr>\r\n        <tr>\r\n            <td colspan=\"3\" style=\"width: 100%; height: 50px\">&nbsp;</td>\r\n        </tr>\r\n        <tr>\r\n            <td style=\"width: 45%; vertical-align: top; text-align: center; border-top: 1px solid black; font-size: 12px; padding-top: 5px;\">#diretor_superintendente#<br />\r\n            Diretor Superintendente</td>\r\n            <td style=\"width: 10%; vertical-align: top;\">&nbsp;</td>\r\n            <td style=\"width: 45%; vertical-align: top; text-align: center; border-top: 1px solid black; font-size: 12px; padding-top: 5px;\">#diretor_atendimento#<br />\r\n            Diretor de Atendimento</td>\r\n        </tr>\r\n    </tbody>\r\n</table>\r\n</div>', `classificacao`='02.03' WHERE `codigo`='evento_modelo_contrato_sg_cont';
UPDATE `db_pir_grc`.`grc_parametros` SET `codigo`='evento_modelo_contrato_sg_cab', `descricao`='Modelo do Contrato para o Evento SebraeTEC (Cabeçalho)', `ativo`='S', `html`='S', `detalhe`='<p style=\"text-align: center;\"><img src=\"#url_sebrae_grc#/admin/fckupload/images/logo_sebrae.jpg\" alt=\"\" width=\"236\" height=\"76\" /></p>', `classificacao`='02.04' WHERE `codigo`='evento_modelo_contrato_sg_cab';
UPDATE `db_pir_grc`.`grc_parametros` SET `codigo`='evento_modelo_contrato_sg_rod', `descricao`='Modelo do Contrato para o Evento SebraeTEC (Rodape)', `ativo`='S', `html`='S', `detalhe`='<center>\r\n    <div>\r\n        <div style=\"margin-top: 10px; text-align: right\">\r\n            Pág.: {PAGENO} / {nb}\r\n        </div>\r\n    </div>\r\n</center>', `classificacao`='02.05' WHERE `codigo`='evento_modelo_contrato_sg_rod';

-- 15/03/2017

INSERT INTO `db_pir_grc`.`plu_config` (`variavel`, `descricao`, `valor`, `extra`, `js`, `classificacao`) VALUES ('evento_sg_vl_hora', 'Valor da Hora para converter Entregas em Atividades nos eventos SebraeTec', '100', NULL, 'N', NULL);

ALTER TABLE `grc_atendimento_evento`
ADD COLUMN `idt_instrumento`  int(10) UNSIGNED NULL AFTER `idt_atendimento`;

ALTER TABLE `grc_atendimento_evento` ADD CONSTRAINT `fk_grc_atendimento_evento_7` FOREIGN KEY (`idt_instrumento`) REFERENCES `grc_atendimento_instrumento` (`idt`) ON DELETE RESTRICT ON UPDATE RESTRICT;

update grc_atendimento_evento set idt_instrumento = 2;

ALTER TABLE `grc_atendimento_evento`
ADD COLUMN `contrapartida_sgtec`  decimal(15,2) NULL AFTER `vl_determinado`;

-- 16/03/2017

ALTER TABLE `grc_evento`
ADD COLUMN `contrapartida_sgtec`  decimal(15,2) NULL AFTER `vl_determinado`;

-- jonata

ALTER TABLE `grc_evento_participante_pagamento`
ADD COLUMN `usa_parceiro`  char(1) NOT NULL DEFAULT 'N' AFTER `emitente_tel`,
ADD COLUMN `par_cnpj`  varchar(45) NULL AFTER `usa_parceiro`,
ADD COLUMN `par_razao_social`  varchar(120) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL AFTER `par_cnpj`,
ADD COLUMN `par_nome_fantasia`  varchar(120) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL AFTER `par_razao_social`,
ADD COLUMN `par_cep`  varchar(15) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL AFTER `par_nome_fantasia`,
ADD COLUMN `par_rua`  varchar(120) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL AFTER `par_cep`,
ADD COLUMN `par_numero`  varchar(45) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL AFTER `par_rua`,
ADD COLUMN `par_bairro`  varchar(45) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL AFTER `par_numero`,
ADD COLUMN `par_cidade`  varchar(45) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL AFTER `par_bairro`,
ADD COLUMN `par_estado`  varchar(2) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL AFTER `par_cidade`;

-- 21/03/2017

ALTER TABLE `grc_atendimento_evento`
ADD COLUMN `idt_midia`  int(10) UNSIGNED NULL DEFAULT NULL AFTER `contrapartida_sgtec`;

ALTER TABLE `grc_atendimento_evento` ADD CONSTRAINT `fk_grc_atendimento_evento_8` FOREIGN KEY (`idt_midia`) REFERENCES `db_pir_gec`.`gec_meio_informacao` (`idt`) ON DELETE RESTRICT ON UPDATE RESTRICT;

update grc_atendimento_evento set idt_midia = 1;
update grc_evento_participante set idt_midia = 1 where idt_midia = 10;

delete from `db_pir_gec`.`gec_meio_informacao` where idt = 10;

INSERT INTO `db_pir_grc`.`plu_config` (`variavel`, `descricao`, `valor`, `extra`, `js`, `classificacao`) VALUES ('evento_sem_metrica_sge', 'Pode aprovar Eventos sem Previsão de Métricas no SGE', 'Sim', NULL, 'N', NULL);

-- treina

-- 22/03/2017

-- UPDATE `db_pir_grc`.`grc_parametros` SET `detalhe`='<p><style type=\"text/css\">\r\n    table.bordasimples {\r\n        border-collapse: collapse;\r\n    }\r\n\r\n    table.bordasimples tr td {\r\n        border:1px solid black;\r\n    }\r\n\r\n    div.margem table {\r\n        width: 100%;\r\n    }\r\n\r\n</style></p>\r\n<div class=\"margem\">\r\n<div style=\"background:#4f81bd; color: white; font-weight: bold; overflow: hidden; margin-bottom: 20px\">\r\n<div style=\"text-align: center; width: 60%; float: left\">TERMO DE ADES&Atilde;O E COMPROMISSO</div>\r\n<div style=\"text-align: center; width: 40%; float: left\">N&ordm; DO EVENTO:&nbsp;#numero_evento#</div>\r\n</div>\r\n<table class=\"bordasimples\">\r\n    <tbody>\r\n        <tr style=\"background:#4f81bd; color: white; font-weight: bold; text-align: left;\">\r\n            <td colspan=\"2\" style=\"border: 1px solid #4f81bd\">EMPRESA DEMANDANTE</td>\r\n        </tr>\r\n        <tr>\r\n            <td colspan=\"2\" style=\"border: 1px solid black\"><strong>CNPJ ou equivalente:</strong>&nbsp;#cnpj_equivalente#</td>\r\n        </tr>\r\n        <tr>\r\n            <td colspan=\"2\"><strong>Raz&atilde;o Social:</strong>&nbsp;#razao_social#</td>\r\n        </tr>\r\n        <tr>\r\n            <td style=\"width: 50%;\"><strong>Nome Fantasia:</strong>&nbsp;#nome_fantasia#</td>\r\n            <td style=\"width: 50%;\"><strong>Telefone:</strong>&nbsp;#telefone#</td>\r\n        </tr>\r\n        <tr>\r\n            <td style=\"width: 50%;\"><strong>Nome do Respons&aacute;vel:</strong>&nbsp;#nome_responsavel#</td>\r\n            <td style=\"width: 50%;\"><strong>CPF:</strong>&nbsp;#cpf#</td>\r\n        </tr>\r\n        <tr>\r\n            <td colspan=\"2\"><strong>E-mail:</strong>&nbsp;#email#</td>\r\n        </tr>\r\n        <tr>\r\n            <td style=\"width: 50%;\"><strong>Endere&ccedil;o:</strong>&nbsp;#endereco#</td>\r\n            <td style=\"width: 50%;\"><strong>Complemento:</strong>&nbsp;#complemento#</td>\r\n        </tr>\r\n        <tr>\r\n            <td style=\"width: 50%;\"><strong>Bairro:</strong>&nbsp;#bairro#</td>\r\n            <td style=\"width: 50%;\"><strong>Cidade:</strong>&nbsp;#cidade#</td>\r\n        </tr>\r\n        <tr>\r\n            <td colspan=\"2\"><strong>CEP:</strong>&nbsp;#cep#</td>\r\n        </tr>\r\n        <tr style=\"background:#4f81bd; color: white; font-weight: bold; text-align: left;\">\r\n            <td colspan=\"2\" style=\"border: 1px solid #4f81bd\">DADOS DO EVENTO</td>\r\n        </tr>\r\n        <tr>\r\n            <td style=\"width: 50%;\"><strong>Produto:</strong>&nbsp;#produto#</td>\r\n            <td style=\"width: 50%;\"><strong>N&uacute;mero do Evento:</strong>&nbsp;#numero_evento#</td>\r\n        </tr>\r\n        <tr>\r\n            <td style=\"width: 50%;\"><strong>Data Prevista de In&iacute;cio:</strong>&nbsp;#data_prevista_inicio#</td>\r\n            <td style=\"width: 50%;\"><strong>Data Prevista de T&eacute;rmino:</strong>&nbsp;#data_prevista_termino#</td>\r\n        </tr>\r\n        <tr>\r\n            <td colspan=\"2\"><strong>Tipo de Servi&ccedil;o:</strong>&nbsp;#tipo_servico#</td>\r\n        </tr>\r\n        <tr>\r\n            <td colspan=\"2\"><strong>Necessidade do Cliente:</strong>&nbsp;#necessidade_cliente#</td>\r\n        </tr>\r\n        <tr>\r\n            <td colspan=\"2\"><strong>Resultados Esperados:</strong>&nbsp;#resultados_esperados#</td>\r\n        </tr>\r\n        <tr>\r\n            <td colspan=\"2\"><strong>Tipo de Servi&ccedil;o:</strong>&nbsp;#tipo_servico#</td>\r\n        </tr>\r\n    </tbody>\r\n</table>\r\n<table class=\"bordasimples\">\r\n    <tbody>\r\n        <tr style=\"background:#4f81bd; color: white; font-weight: bold; text-align: left;\">\r\n            <td style=\"border: 1px solid #4f81bd\">ENTREGAS</td>\r\n        </tr>\r\n    </tbody>\r\n</table>\r\n#entregas#\r\n<table style=\"margin-top: 20px\">\r\n    <tbody>\r\n        <tr style=\"background:#4f81bd; color: white; font-weight: bold; text-align: left;\">\r\n            <td style=\"border: 1px solid #4f81bd\">CL&Aacute;USULA PRIMEIRA &ndash; DO PRE&Ccedil;O</td>\r\n        </tr>\r\n    </tbody>\r\n</table>\r\n<p>Por este instrumento, a &nbsp;#razao_social#&nbsp; assume o compromisso de efetuar o                          pagamento ao SEBRAE/BA, da import&acirc;ncia total de &nbsp;#valor_servico#&nbsp; (R$) pelos servi&ccedil;os referidos neste Termo de Ades&atilde;o                          e Compromisso.</p>\r\n<p><strong>Par&aacute;grafo Primeiro</strong> &ndash; A cota-parte do cliente ser&aacute; paga no Cart&atilde;o de d&eacute;bito; Cart&atilde;o de cr&eacute;dito, Boleto (&agrave; vista), Dinheiro, ou Cheque, de acordo com a orienta&ccedil;&atilde;o vigente.</p>\r\n<p><strong>Par&aacute;grafo Segundo</strong> &ndash; O n&atilde;o pagamento de qualquer das parcelas implicar&aacute;, conforme o caso, na suspens&atilde;o ou cancelamento do servi&ccedil;o e, a crit&eacute;rio do SEBRAE/BA, na ado&ccedil;&atilde;o de medidas legais cab&iacute;veis, judiciais ou extrajudiciais.</p>\r\n<p><strong>Par&aacute;grafo Terceiro</strong> &ndash; A &nbsp;#razao_social# compreende que est&aacute; arcando com cota parte de 30% do pre&ccedil;o do servi&ccedil;o em fun&ccedil;&atilde;o de subs&iacute;dio concedido pelo SEBRAE/BA.</p>\r\n<table style=\"margin-top: 20px; margin-bottom: 10px;\">\r\n    <tbody>\r\n        <tr style=\"background:#4f81bd; color: white; font-weight: bold; text-align: left;\">\r\n            <td style=\"border: 1px solid #4f81bd\">CL&Aacute;USULA SEGUNDA &ndash; DAS OBRIGA&Ccedil;&Otilde;ES</td>\r\n        </tr>\r\n    </tbody>\r\n</table>\r\n<p>I - S&atilde;o obriga&ccedil;&otilde;es da #razao_social#:</p>\r\n<p><strong> a) </strong> Avaliar as entregas de trabalhos realizadas pela ENTIDADE EXECUTORA (parcial e final).</p>\r\n<p><strong> b) </strong> Responsabilizar-se pelo efetivo repasse da cota-parte ao SEBRAE/BA.</p>\r\n<p><strong> c) </strong> Disponibilizar ao SEBRAE Nacional e/ou SEBRAE/BA, a qualquer tempo, informa&ccedil;&otilde;es sobre os servi&ccedil;os prestados, sobre os resultados obtidos ou sobre a ENTIDADE EXECUTORA contratada pelo SEBRAE/BA por meio do SEBRAETEC.</p>\r\n<p><strong> d) </strong> Cumprir as disposi&ccedil;&otilde;es previstas neste Edital.</p>\r\n<p><strong> e) </strong> Responsabilizar-se para que a utiliza&ccedil;&atilde;o dos recursos na presta&ccedil;&atilde;o de servi&ccedil;os n&atilde;o seja indevida ou desnecess&aacute;ria.</p>\r\n<p><strong> f) </strong> Receber os representantes do SEBRAE/BA com ou sem agendamento pr&eacute;vio.</p>\r\n<p><strong> g) </strong> Responder &agrave;s pesquisas de satisfa&ccedil;&atilde;o dos servi&ccedil;os prestados e da efetividade do SEBRAETEC realizadas pelo SEBRAE/BA e/ou pelo SEBRAE/NA, responsabilizando-se pela veracidade, exatid&atilde;o e completude das respostas.</p>\r\n<p><strong> h) </strong> Restituir ao SEBRAE/BA os valores investidos na proposta, caso haja comprova&ccedil;&atilde;o de a&ccedil;&atilde;o em conjunto com a ENTIDADE EXECUTORA para lesar o SEBRAE/BA.</p>\r\n<p><strong> i) </strong> Assinar a Carta Contrato antes do in&iacute;cio da presta&ccedil;&atilde;o de servi&ccedil;o, conforme padr&atilde;o definido no Sistema de contrata&ccedil;&atilde;o do SEBRAETEC.</p>\r\n<p><strong> j) </strong> Assinar o relat&oacute;rio final apenas ap&oacute;s o t&eacute;rmino completo do servi&ccedil;o, sob pena de restituir os valores pagos pelo SEBRAE/BA para a realiza&ccedil;&atilde;o do servi&ccedil;o, conforme padr&atilde;o definido no Sistema de contrata&ccedil;&atilde;o do SEBRAETEC.</p>\r\n<p><strong> k) </strong> Responder pelo pagamento proporcional dos servi&ccedil;os at&eacute; ent&atilde;o realizados em caso de solicita&ccedil;&atilde;o de distrato da proposta por sua pr&oacute;pria iniciativa.</p>\r\n<p><strong> l) </strong> Responsabilizar-se pelas informa&ccedil;&otilde;es prestadas no momento do atendimento.</p>\r\n<p><strong>Par&aacute;grafo &uacute;nico</strong> &ndash; Ap&oacute;s assinatura do Relat&oacute;rio Final a #razao_social# n&atilde;o poder&aacute; contestar, sob qualquer hip&oacute;tese, a revis&atilde;o do servi&ccedil;o prestado.</p>\r\n<p>II &ndash; S&atilde;o obriga&ccedil;&otilde;es do SEBRAE/BA:</p>\r\n<p>a. Contratar credenciada para executar os servi&ccedil;os decorrentes deste termo.</p>\r\n<p>b. Acompanhar toda a execu&ccedil;&atilde;o do servi&ccedil;o ora acordado, bem como subsidiar os custos nas condi&ccedil;&otilde;es estabelecidas.</p>\r\n<p>c. Efetuar, quando couber,  a devolu&ccedil;&atilde;o proporcional da cota-parte paga pelo cliente, nos casos em que este pagamento ocorra antes do processo de cota&ccedil;&atilde;o.</p>\r\n<p>d. Demais obriga&ccedil;&otilde;es impostas pelo Edital de Credenciamento SEBRAETEC vigente.</p>\r\n<table style=\"margin-top: 20px; margin-bottom: 10px;\">\r\n    <tbody>\r\n        <tr style=\"background:#4f81bd; color: white; font-weight: bold; text-align: left;\">\r\n            <td style=\"border: 1px solid #4f81bd\">CL&Aacute;USULA TERCEIRA &ndash; DO FORO</td>\r\n        </tr>\r\n    </tbody>\r\n</table>\r\n<p>Fica estabelecido entre as partes que o foro competente para a solu&ccedil;&atilde;o de qualquer lit&iacute;gio decorrente deste contrato &eacute; o de Salvador-BA, exclu&iacute;do qualquer outro.</p>\r\n<p>E, por assim terem acordado, assinam este Termo de Ades&atilde;o e Compromisso, em tr&ecirc;s vias de igual teor e forma.</p>\r\n<table style=\"margin-top: 20px; margin-bottom: 10px;\">\r\n    <tbody>\r\n        <tr>\r\n            <td style=\"padding-top: 20px; margin-bottom: 20px;\">\r\n            <p>#cidade_assinatura#, &nbsp;#data_assinatura#&nbsp; de &nbsp;#mes_assinatura#&nbsp; de &nbsp;#ano_assinatura#&nbsp;.</p>\r\n            </td>\r\n        </tr>\r\n    </tbody>\r\n</table>\r\n<table style=\"margin-top: 50px; margin-bottom: 50px\">\r\n    <tbody>\r\n        <tr>\r\n            <td style=\"width: 45%; vertical-align: top; text-align: center; border-top: 1px solid black; font-size: 12px; padding-top: 5px;\">#nome_responsavel#<br />\r\n            RESPONSAVEL PELA #razao_social#</td>\r\n            <td style=\"width: 10%; vertical-align: top;\">&nbsp;</td>\r\n            <td style=\"width: 45%; vertical-align: top; text-align: center; border-top: 1px solid black; font-size: 12px; padding-top: 5px;\">RESPONS&Aacute;VEL PELO ATENDIMENTO &ndash; SEBRAE/BA<br />\r\n            (N&atilde;o rubricar)</td>\r\n        </tr>\r\n        <tr>\r\n            <td colspan=\"3\" style=\"width: 100%; height: 50px\">&nbsp;</td>\r\n        </tr>\r\n        <tr>\r\n            <td style=\"width: 45%; vertical-align: top; text-align: center; border-top: 1px solid black; font-size: 12px; padding-top: 5px;\">#diretor_superintendente#<br />\r\n            Diretor Superintendente</td>\r\n            <td style=\"width: 10%; vertical-align: top;\">&nbsp;</td>\r\n            <td style=\"width: 45%; vertical-align: top; text-align: center; border-top: 1px solid black; font-size: 12px; padding-top: 5px;\">#diretor_atendimento#<br />\r\n            Diretor de Atendimento</td>\r\n        </tr>\r\n    </tbody>\r\n</table>\r\n</div>' WHERE `codigo`='evento_modelo_contrato_sg_cont';

-- 24/03/2017

CREATE TABLE `grc_evento_participante_contadevolucao` (
  `idt` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idt_atendimento` int(10) unsigned NOT NULL,
  `codigo` varchar(45) NOT NULL,
  `descricao` varchar(120) NOT NULL,
  `inc_pag_rm` char(1) NOT NULL,
  `banco_numero` int(10) DEFAULT NULL,
  `banco_nome` varchar(50) DEFAULT NULL,
  `agencia_numero` varchar(20) DEFAULT NULL,
  `agencia_digito` varchar(5) DEFAULT NULL,
  `cc_numero` varchar(20) DEFAULT NULL,
  `cc_digito` varchar(5) DEFAULT NULL,
  `cpfcnpj` varchar(18) DEFAULT NULL,
  `razao_social` varchar(120) DEFAULT NULL,
  `vl_pago` decimal(15,2) NOT NULL,
  `vl_devolucao` decimal(15,2) DEFAULT NULL,
  `rm_codcfo` varchar(10) DEFAULT NULL,
  `rm_idpgto` int(10) DEFAULT NULL,
  `idt_evento_participante_pagamento` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`idt`),
  KEY `fk_grc_evento_participante_contadevolucao_1` (`idt_atendimento`) USING BTREE,
  KEY `fk_grc_evento_participante_contadevolucao_2` (`idt_evento_participante_pagamento`),
  CONSTRAINT `fk_grc_evento_participante_contadevolucao_2` FOREIGN KEY (`idt_evento_participante_pagamento`) REFERENCES `grc_evento_participante_pagamento` (`idt`),
  CONSTRAINT `fk_grc_evento_participante_contadevolucao_1` FOREIGN KEY (`idt_atendimento`) REFERENCES `grc_atendimento` (`idt`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_evento_participante_contadevolucao','Conta para Devolução do Pagamento Participante (Evento)','02.03.58','S','N','listar','listar');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_evento_participante_contadevolucao') as id_funcao
from plu_direito where cod_direito in ('alt','con');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_evento_participante_contadevolucao');

-- 25/03/2017

ALTER TABLE `grc_evento_banco`
MODIFY COLUMN `codigo`  varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `idt`,
MODIFY COLUMN `descricao`  varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `codigo`,
ADD UNIQUE INDEX `iu_grc_evento_banco_2` (`descricao`) USING BTREE ;

ALTER TABLE `grc_evento_banco`
MODIFY COLUMN `codigo`  int(10) NOT NULL AFTER `idt`;

INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('1', '356', 'ABN AMRO S.A', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('2', '735', 'BACO POTENCIAL', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('3', '654', 'BANCO A. J. RENNER S.A', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('4', '246', 'BANCO ABC ROMA S.A', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('5', '222', 'BANCO AGF BRASIL S. A.', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('6', '483', 'BANCO AGRIMISA S.A.', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('7', '217', 'BANCO AGROINVEST S.A', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('8', '25', 'BANCO ALFA S/A', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('9', '215', 'BANCO AMERICA DO SUL S.A', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('10', '621', 'BANCO APLICAP S.A.', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('11', '625', 'BANCO ARAUCARIA S.A', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('12', '213', 'BANCO ARBI S.A', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('13', '648', 'BANCO ATLANTIS S.A', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('14', '201', 'BANCO AUGUSTA INDUSTRIA E COMERCIAL S.A', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('15', '394', 'BANCO B.M.C. S.A', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('16', '318', 'BANCO B.M.G. S.A', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('17', '116', 'BANCO B.N.L DO BRASIL S.A', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('18', '399', 'BANCO BAMERINDUS DO BRASIL S.A', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('19', '239', 'BANCO BANCRED S.A', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('20', '230', 'BANCO BANDEIRANTES S.A', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('21', '752', 'BANCO BANQUE NATIONALE DE PARIS BRASIL S', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('22', '107', 'BANCO BBM S.A', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('23', '267', 'BANCO BBM-COM.C.IMOB.CFI S.A.', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('24', '231', 'BANCO BOAVISTA S.A', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('25', '262', 'BANCO BOREAL S.A', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('26', '351', 'BANCO BOZANO SIMONSEN S.A', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('27', '237', 'BANCO BRADESCO S.A', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('28', '225', 'BANCO BRASCAN S.A', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('29', '282', 'BANCO BRASILEIRO COMERCIAL', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('30', '501', 'BANCO BRASILEIRO IRAQUIANO S.A.', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('31', '168', 'BANCO C.C.F. BRASIL S.A', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('32', '263', 'BANCO CACIQUE', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('33', '236', 'BANCO CAMBIAL S.A', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('34', '266', 'BANCO CEDULA S.A', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('35', '2', 'BANCO CENTRAL DO BRASIL', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('36', '244', 'BANCO CIDADE S.A', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('37', '713', 'BANCO CINDAM S.A', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('38', '241', 'BANCO CLASSICO S.A', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('39', '308', 'BANCO COMERCIAL BANCESA S.A.', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('40', '730', 'BANCO COMERCIAL PARAGUAYO S.A', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('41', '753', 'BANCO COMERCIAL URUGUAI S.A.', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('42', '756', 'BANCO COOPERATIVO DO BRASIL S.A.', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('43', '109', 'BANCO CREDIBANCO S.A', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('44', '721', 'BANCO CREDIBEL S.A', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('45', '295', 'BANCO CREDIPLAN S.A', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('46', '220', 'BANCO CREFISUL', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('47', '628', 'BANCO CRITERIUM S.A', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('48', '229', 'BANCO CRUZEIRO S.A', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('49', '3', 'BANCO DA AMAZONIA S.A', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('50', '707', 'BANCO DAYCOVAL S.A', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('51', '479', 'BANCO DE BOSTON S.A', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('52', '70', 'BANCO DE BRASILIA S.A', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('53', '219', 'BANCO DE CREDITO DE SAO PAULO S.A', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('54', '640', 'BANCO DE CREDITO METROPOLITANO S.A', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('55', '291', 'BANCO DE CREDITO NACIONAL S.A', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('56', '240', 'BANCO DE CREDITO REAL DE MINAS GERAIS S.', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('57', '22', 'BANCO DE CREDITO REAL DE MINAS GERAIS SA', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('58', '300', 'BANCO DE LA NACION ARGENTINA S.A', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('59', '627', 'BANCO DESTAK S.A', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('60', '214', 'BANCO DIBENS S.A', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('61', '649', 'BANCO DIMENSAO S.A', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('62', '1', 'BANCO DO BRASIL S/A', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('63', '34', 'BANCO DO ESADO DO AMAZONAS S.A', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('64', '28', 'BANCO DO ESTADO DA BAHIA S.A', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('65', '30', 'BANCO DO ESTADO DA PARAIBA S.A', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('66', '20', 'BANCO DO ESTADO DE ALAGOAS S.A', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('67', '31', 'BANCO DO ESTADO DE GOIAS S.A', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('68', '48', 'BANCO DO ESTADO DE MINAS GERAIS S.A', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('69', '24', 'BANCO DO ESTADO DE PERNAMBUCO', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('70', '59', 'BANCO DO ESTADO DE RONDONIA S.A', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('71', '645', 'BANCO DO ESTADO DE RORAIMA S.A', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('72', '27', 'BANCO DO ESTADO DE SANTA CATARINA S.A', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('73', '33', 'BANCO DO ESTADO DE SAO PAULO S.A', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('74', '47', 'BANCO DO ESTADO DE SERGIPE S.A', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('75', '26', 'BANCO DO ESTADO DO ACRE S.A', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('76', '635', 'BANCO DO ESTADO DO AMAPA S.A', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('77', '35', 'BANCO DO ESTADO DO CEARA S.A', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('78', '21', 'BANCO DO ESTADO DO ESPIRITO SANTO S.A', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('79', '36', 'BANCO DO ESTADO DO MARANHAO S.A', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('80', '32', 'BANCO DO ESTADO DO MATO GROSSO S.A.', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('81', '37', 'BANCO DO ESTADO DO PARA S.A', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('82', '38', 'BANCO DO ESTADO DO PARANA S.A', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('83', '39', 'BANCO DO ESTADO DO PIAUI S.A', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('84', '29', 'BANCO DO ESTADO DO RIO DE JANEIRO S.A', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('85', '41', 'BANCO DO ESTADO DO RIO GRANDE DO SUL S.A', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('86', '4', 'BANCO DO NORDESTE DO BRASIL S.A', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('87', '302', 'BANCO DO PROGRESSO S.A', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('88', '622', 'BANCO DRACMA S.A', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('89', '743', 'BANCO EMBLEMA S.A', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('90', '245', 'BANCO EMPRESARIAL S.A', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('91', '242', 'BANCO EUROINVEST S.A', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('92', '641', 'BANCO EXCEL ECONOMICO S/A', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('93', '496', 'BANCO EXTERIOR DE ESPANA S.A', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('94', '265', 'BANCO FATOR S.A', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('95', '375', 'BANCO FENICIA S.A', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('96', '224', 'BANCO FIBRA S.A', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('97', '626', 'BANCO FICSA S.A', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('98', '725', 'BANCO FINABANCO S.A', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('99', '199', 'BANCO FINANCIAL PORTUGUES', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('100', '473', 'BANCO FINANCIAL PORTUGUES S.A', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('101', '252', 'BANCO FININVEST S.A', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('102', '728', 'BANCO FITAL S.A', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('103', '729', 'BANCO FONTE S.A', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('104', '434', 'BANCO FORTALEZA S.A', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('105', '346', 'BANCO FRANCES E BRASILEIRO S.A', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('106', '652', 'BANCO FRANCES E BRASILEIRO SA', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('107', '200', 'BANCO FRICRISA AXELRUD S.A', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('108', '505', 'BANCO GARANTIA S.A', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('109', '624', 'BANCO GENERAL MOTORS S.A', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('110', '353', 'BANCO GERAL DO COMERCIO S.A', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('111', '734', 'BANCO GERDAU S.A', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('112', '731', 'BANCO GNPP S.A.', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('113', '221', 'BANCO GRAPHUS S.A', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('114', '612', 'BANCO GUANABARA S.A', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('115', '256', 'BANCO GULVINVEST S.A', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('116', '303', 'BANCO HNF S.A.', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('117', '228', 'BANCO ICATU S.A', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('118', '258', 'BANCO INDUSCRED S.A', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('119', '604', 'BANCO INDUSTRIAL DO BRASIL S.A', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('120', '320', 'BANCO INDUSTRIAL E COMERCIAL', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('121', '653', 'BANCO INDUSVAL S.A', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('122', '166', 'BANCO INTER-ATLANTICO S.A', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('123', '630', 'BANCO INTERCAP S.A', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('124', '722', 'BANCO INTERIOR DE SAO PAULO S.A', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('125', '616', 'BANCO INTERPACIFICO S.A', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('126', '232', 'BANCO INTERPART S.A', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('127', '223', 'BANCO INTERUNION S.A', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('128', '705', 'BANCO INVESTCORP S.A.', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('129', '249', 'BANCO INVESTCRED S.A', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('130', '617', 'BANCO INVESTOR S.A.', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('131', '499', 'BANCO IOCHPE S.A', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('132', '106', 'BANCO ITABANCO S.A.', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('133', '372', 'BANCO ITAMARATI S.A', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('134', '341', 'BANCO ITAU S.A', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('135', '488', 'BANCO J. P. MORGAN S.A', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('136', '757', 'BANCO KEB DO BRASIL S.A.', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('137', '495', 'BANCO LA PROVINCIA DE BUENOS AIRES', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('138', '494', 'BANCO LA REP. ORIENTAL DEL URUGUAY', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('139', '234', 'BANCO LAVRA S.A.', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('140', '235', 'BANCO LIBERAL S.A', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('141', '600', 'BANCO LUSO BRASILEIRO S.A', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('142', '233', 'BANCO MAPPIN S.A', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('143', '647', 'BANCO MARKA S.A', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('144', '206', 'BANCO MARTINELLI S.A', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('145', '212', 'BANCO MATONE S.A', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('146', '656', 'BANCO MATRIX S.A', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('147', '720', 'BANCO MAXINVEST S.A', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('148', '388', 'BANCO MERCANTIL DE DESCONTOS S/A', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('149', '392', 'BANCO MERCANTIL DE SAO PAULO S.A', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('150', '389', 'BANCO MERCANTIL DO BRASIL S.A', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('151', '8', 'BANCO MERIDIONAL DO BRASIL', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('152', '755', 'BANCO MERRILL LYNCH S.A', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('153', '466', 'BANCO MITSUBISHI BRASILEIRO S.A', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('154', '504', 'BANCO MULTIPLIC S.A', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('155', '7', 'BANCO NAC DESENV. ECO. SOCIAL S.A', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('156', '412', 'BANCO NACIONAL DA BAHIA S.A', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('157', '420', 'BANCO NACIONAL DO NORTE S.A', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('158', '415', 'BANCO NACIONAL S.A', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('159', '733', 'BANCO NACOES S.A.', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('160', '165', 'BANCO NORCHEM S.A', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('161', '424', 'BANCO NOROESTE S.A', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('162', '247', 'BANCO OMEGA S.A', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('163', '608', 'BANCO OPEN S.A', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('164', '718', 'BANCO OPERADOR S.A', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('165', '208', 'BANCO PACTUAL S.A', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('166', '623', 'BANCO PANAMERICANO S.A', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('167', '254', 'BANCO PARANA BANCO S.A', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('168', '602', 'BANCO PATENTE S.A', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('169', '611', 'BANCO PAULISTA S.A', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('170', '650', 'BANCO PEBB S.A', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('171', '613', 'BANCO PECUNIA S.A', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('172', '264', 'BANCO PERFORMANCE S.A', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('173', '277', 'BANCO PLANIBANC S.A', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('174', '304', 'BANCO PONTUAL S.A', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('175', '658', 'BANCO PORTO REAL S.A', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('176', '724', 'BANCO PORTO SEGURO S.A', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('177', '480', 'BANCO PORTUGUES DO ATLANTICO-BRASIL S.A', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('178', '732', 'BANCO PREMIER S.A.', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('179', '719', 'BANCO PRIMUS S.A', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('180', '638', 'BANCO PROSPER S.A', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('181', '275', 'BANCO REAL S.A', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('182', '633', 'BANCO REDIMENTO S.A', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('183', '216', 'BANCO REGIONAL MALCON S.A', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('184', '750', 'BANCO REPUBLIC NATIONAL OF NEW YORK (BRA', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('185', '453', 'BANCO RURAL S.A', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('186', '204', 'BANCO S.R.L S.A', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('187', '422', 'BANCO SAFRA S.A', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('188', '502', 'BANCO SANTANDER S.A', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('189', '607', 'BANCO SANTOS NEVES S.A', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('190', '702', 'BANCO SANTOS S.A', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('191', '251', 'BANCO SAO JORGE S.A.', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('192', '250', 'BANCO SCHAHIN CURY S.A', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('193', '643', 'BANCO SEGMENTO S.A', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('194', '211', 'BANCO SISTEMA S.A', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('195', '637', 'BANCO SOFISA S.A', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('196', '366', 'BANCO SOGERAL S.A', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('197', '243', 'BANCO STOCK S.A', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('198', '347', 'BANCO SUDAMERIS BRASIL S.A', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('199', '205', 'BANCO SUL AMERICA S.A', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('200', '464', 'BANCO SUMITOMO BRASILEIRO S.A', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('201', '657', 'BANCO TECNICORP S.A', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('202', '618', 'BANCO TENDENCIA S.A', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('203', '456', 'BANCO TOKIO S.A', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('204', '634', 'BANCO TRIANGULO S.A', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('205', '493', 'BANCO UNION S.A.C.A', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('206', '736', 'BANCO UNITED S.A', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('207', '726', 'BANCO UNIVERSAL S.A', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('208', '610', 'BANCO V.R. S.A', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('209', '261', 'BANCO VARIG S.A', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('210', '715', 'BANCO VEGA S.A', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('211', '711', 'BANCO VETOR S.A.', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('212', '655', 'BANCO VOTORANTIM S.A.', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('213', '629', 'BANCORP BANCO COML. E. DE INVESTMENTO', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('214', '489', 'BANESTO BANCO URUGAUAY S.A', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('215', '184', 'BBA - CREDITANSTALT S.A', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('216', '218', 'BBS - BANCO BONSUCESSO S.A.', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('217', '740', 'BCN BARCLAYS', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('218', '294', 'BCR - BANCO DE CREDITO REAL S.A', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('219', '370', 'BEAL - BANCO EUROPEU PARA AMERICA LATINA', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('220', '601', 'BFC BANCO S.A.', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('221', '739', 'BGN', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('222', '639', 'BIG S.A. - BANCO IRMAOS GUIMARAES', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('223', '749', 'BRMSANTIL SA', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('224', '741', 'BRP', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('225', '151', 'CAIXA ECONOMICA DO ESTADO DE SAO PAULO', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('226', '153', 'CAIXA ECONOMICA DO ESTADO DO R.G.SUL', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('227', '104', 'CAIXA ECONOMICA FEDERAL', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('228', '498', 'CENTRO HISPANO BANCO', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('229', '376', 'CHASE MANHATTAN BANK S.A', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('230', '745', 'CITIBAN N.A.', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('231', '477', 'CITIBANK N.A', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('232', '175', 'CONTINENTAL BANCO S.A', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('233', '210', 'DEUTSCH SUDAMERIKANICHE BANK AG', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('234', '487', 'DEUTSCHE BANK S.A - BANCO ALEMAO', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('235', '751', 'DRESDNER BANK LATEINAMERIKA-BRASIL S/A', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('236', '742', 'EQUATORIAL', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('237', '492', 'INTERNATIONALE NEDERLANDEN BANK N.V.', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('238', '472', 'LLOYDS BANK PLC', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('239', '738', 'MARADA', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('240', '255', 'MILBANCO S.A.', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('241', '746', 'MODAL SA', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('242', '148', 'MULTI BANCO S.A', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('243', '369', 'PONTUAL', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('244', '747', 'RAIBOBANK DO BRASIL', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('245', '748', 'SICREDI', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('246', '744', 'THE FIRST NATIONAL BANK OF BOSTON', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('247', '737', 'THECA', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_banco` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('248', '409', 'UNIBANCO - UNIAO DOS BANCOS BRASILEIROS', NULL, 'S');

-- 29/03/2017

UPDATE `grc_evento_situacao` SET `descricao`='EM COTAÇÃO' WHERE (`idt`='24');

-- 31/03/2017

ALTER TABLE `grc_atendimento_pendencia`
MODIFY COLUMN `idt_usuario`  int(11) NULL AFTER `observacao`;

-- 01/04/2017

UPDATE `db_pir_grc`.`grc_evento_situacao` SET `idt`='1', `codigo`='01', `descricao`='EM CONSTRUÇÃO', `ativo`='S', `detalhe`='evento criado e que ainda não foi enviado para aprovação e pode ser editado a qualquer momento', `situacao_etapa`='D', `vai_para`='05', `volta_para`='03,90' WHERE (`idt`='1');
UPDATE `db_pir_grc`.`grc_evento_situacao` SET `idt`='2', `codigo`='80', `descricao`='Aguardando aprovação do Gestor do Projeto', `ativo`='S', `detalhe`=NULL, `situacao_etapa`='C', `vai_para`=NULL, `volta_para`=NULL WHERE (`idt`='2');
UPDATE `db_pir_grc`.`grc_evento_situacao` SET `idt`='3', `codigo`='85', `descricao`='Aguardando aprovação do Coordenador/Gerente', `ativo`='S', `detalhe`=NULL, `situacao_etapa`='C', `vai_para`=NULL, `volta_para`=NULL WHERE (`idt`='3');
UPDATE `db_pir_grc`.`grc_evento_situacao` SET `idt`='4', `codigo`='90', `descricao`='CANCELADO DURANTE APROVAÇÃO', `ativo`='S', `detalhe`=NULL, `situacao_etapa`='C', `vai_para`=NULL, `volta_para`=NULL WHERE (`idt`='4');
UPDATE `db_pir_grc`.`grc_evento_situacao` SET `idt`='5', `codigo`='03', `descricao`='DEVOLVIDO', `ativo`='S', `detalhe`='evento devolvido para correção pelo aprovador', `situacao_etapa`='D', `vai_para`='05', `volta_para`='85,90' WHERE (`idt`='5');
UPDATE `db_pir_grc`.`grc_evento_situacao` SET `idt`='6', `codigo`='05', `descricao`='EM TRAMITAÇÃO', `ativo`='S', `detalhe`='evento percorrendo o fluxo de aprovação. não pode ser editado ou excluído', `situacao_etapa`='A', `vai_para`='07', `volta_para`='85,90' WHERE (`idt`='6');
UPDATE `db_pir_grc`.`grc_evento_situacao` SET `idt`='7', `codigo`='07', `descricao`='Aguardando a aprovação do Diretor', `ativo`='S', `detalhe`=NULL, `situacao_etapa`='A', `vai_para`='10', `volta_para`='03,90' WHERE (`idt`='7');
UPDATE `db_pir_grc`.`grc_evento_situacao` SET `idt`='8', `codigo`='10', `descricao`='COTAÇÃO FINALIZADA', `ativo`='S', `detalhe`=NULL, `situacao_etapa`='A', `vai_para`='13', `volta_para`='03' WHERE (`idt`='8');
UPDATE `db_pir_grc`.`grc_evento_situacao` SET `idt`='9', `codigo`='13', `descricao`='AGUARDANDO ASSINATURA', `ativo`='S', `detalhe`=NULL, `situacao_etapa`='A', `vai_para`='20', `volta_para`='03,90' WHERE (`idt`='9');
UPDATE `db_pir_grc`.`grc_evento_situacao` SET `idt`='10', `codigo`='20', `descricao`='AGUARDANDO PACTUAÇÃO COM O GERENTE', `ativo`='N', `detalhe`=NULL, `situacao_etapa`='A', `vai_para`='25', `volta_para`='03,90' WHERE (`idt`='10');
UPDATE `db_pir_grc`.`grc_evento_situacao` SET `idt`='11', `codigo`='25', `descricao`='AGUARDANDO PACTUAÇÃO COM O COORDENADOR', `ativo`='N', `detalhe`=NULL, `situacao_etapa`='A', `vai_para`='30', `volta_para`='03,90' WHERE (`idt`='11');
UPDATE `db_pir_grc`.`grc_evento_situacao` SET `idt`='12', `codigo`='30', `descricao`='AGUARDANDO PACTUAÇÃO COM O GERENTE DISPONIBILIZAÇÃO', `ativo`='N', `detalhe`=NULL, `situacao_etapa`='A', `vai_para`='35', `volta_para`='03,90' WHERE (`idt`='12');
UPDATE `db_pir_grc`.`grc_evento_situacao` SET `idt`='13', `codigo`='75', `descricao`='EVENTO SEM SALDO PARA EXECUÇÃO', `ativo`='N', `detalhe`=NULL, `situacao_etapa`='P', `vai_para`='35', `volta_para`='03,90' WHERE (`idt`='13');
UPDATE `db_pir_grc`.`grc_evento_situacao` SET `idt`='14', `codigo`='35', `descricao`='AGENDADO', `ativo`='S', `detalhe`='evento aprovado que irá acontecer em data futura', `situacao_etapa`='E', `vai_para`='40,75', `volta_para`='03,90' WHERE (`idt`='14');
UPDATE `db_pir_grc`.`grc_evento_situacao` SET `idt`='15', `codigo`='40', `descricao`='AGUARDANDO EXECUÇÃO', `ativo`='N', `detalhe`=NULL, `situacao_etapa`='E', `vai_para`='45', `volta_para`='90' WHERE (`idt`='15');
UPDATE `db_pir_grc`.`grc_evento_situacao` SET `idt`='16', `codigo`='60', `descricao`='EM EXECUÇÃO', `ativo`='S', `detalhe`='evento que ocorre nesse momento - data atual', `situacao_etapa`='E', `vai_para`=NULL, `volta_para`=NULL WHERE (`idt`='16');
UPDATE `db_pir_grc`.`grc_evento_situacao` SET `idt`='17', `codigo`='45', `descricao`='DISPARADA SOLICITAÇÃO DE INSUMOS', `ativo`='N', `detalhe`=NULL, `situacao_etapa`='E', `vai_para`='50', `volta_para`='03,90' WHERE (`idt`='17');
UPDATE `db_pir_grc`.`grc_evento_situacao` SET `idt`='18', `codigo`='50', `descricao`='COMPRAS FECHADA', `ativo`='N', `detalhe`=NULL, `situacao_etapa`='E', `vai_para`='60', `volta_para`='03,90' WHERE (`idt`='18');
UPDATE `db_pir_grc`.`grc_evento_situacao` SET `idt`='19', `codigo`='65', `descricao`='PENDENTE', `ativo`='S', `detalhe`='evento que ocorreu no passado, mas não foi consolidado ainda', `situacao_etapa`='D', `vai_para`=NULL, `volta_para`=NULL WHERE (`idt`='19');
UPDATE `db_pir_grc`.`grc_evento_situacao` SET `idt`='20', `codigo`='67', `descricao`='CONSOLIDADO', `ativo`='S', `detalhe`='evento encerrado', `situacao_etapa`='D', `vai_para`=NULL, `volta_para`=NULL WHERE (`idt`='20');
UPDATE `db_pir_grc`.`grc_evento_situacao` SET `idt`='21', `codigo`='95', `descricao`='CANCELADO APÓS APROVAÇÃO', `ativo`='S', `detalhe`=NULL, `situacao_etapa`='C', `vai_para`=NULL, `volta_para`=NULL WHERE (`idt`='21');
UPDATE `db_pir_grc`.`grc_evento_situacao` SET `idt`='22', `codigo`='96', `descricao`='CANCELADO APÓS APROVAÇÃO COM ERRO', `ativo`='S', `detalhe`=NULL, `situacao_etapa`='C', `vai_para`=NULL, `volta_para`=NULL WHERE (`idt`='22');
UPDATE `db_pir_grc`.`grc_evento_situacao` SET `idt`='23', `codigo`='97', `descricao`='APROVAÇÃO DE CANCELAMENTO', `ativo`='S', `detalhe`=NULL, `situacao_etapa`='C', `vai_para`=NULL, `volta_para`=NULL WHERE (`idt`='23');
UPDATE `db_pir_grc`.`grc_evento_situacao` SET `idt`='24', `codigo`='27', `descricao`='EM COTAÇÃO', `ativo`='S', `detalhe`=NULL, `situacao_etapa`='D', `vai_para`=NULL, `volta_para`=NULL WHERE (`idt`='24');

-- 03/04/2017

INSERT INTO `db_pir_grc`.`plu_config` (`variavel`, `descricao`, `valor`, `extra`, `js`, `classificacao`) VALUES ('evento_sg_qtd_inicio', 'Quantidade de dias para iniciar o serviço do evento SebraeTec', '15', NULL, 'N', NULL);

ALTER TABLE `grc_atendimento_evento_pagamento`
ADD COLUMN `usa_parceiro`  char(1) NOT NULL DEFAULT 'N' AFTER `emitente_tel`,
ADD COLUMN `par_cnpj`  varchar(45) NULL AFTER `usa_parceiro`,
ADD COLUMN `par_razao_social`  varchar(120) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL AFTER `par_cnpj`,
ADD COLUMN `par_nome_fantasia`  varchar(120) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL AFTER `par_razao_social`,
ADD COLUMN `par_cep`  varchar(15) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL AFTER `par_nome_fantasia`,
ADD COLUMN `par_rua`  varchar(120) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL AFTER `par_cep`,
ADD COLUMN `par_numero`  varchar(45) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL AFTER `par_rua`,
ADD COLUMN `par_bairro`  varchar(45) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL AFTER `par_numero`,
ADD COLUMN `par_cidade`  varchar(45) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL AFTER `par_bairro`,
ADD COLUMN `par_estado`  varchar(2) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL AFTER `par_cidade`;

CREATE TABLE `grc_atendimento_evento_contadevolucao` (
  `idt` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idt_atendimento_evento` int(10) unsigned NOT NULL,
  `codigo` varchar(45) NOT NULL,
  `descricao` varchar(120) NOT NULL,
  `inc_pag_rm` char(1) NOT NULL,
  `banco_numero` int(10) DEFAULT NULL,
  `banco_nome` varchar(50) DEFAULT NULL,
  `agencia_numero` varchar(20) DEFAULT NULL,
  `agencia_digito` varchar(5) DEFAULT NULL,
  `cc_numero` varchar(20) DEFAULT NULL,
  `cc_digito` varchar(5) DEFAULT NULL,
  `cpfcnpj` varchar(18) DEFAULT NULL,
  `razao_social` varchar(120) DEFAULT NULL,
  `vl_pago` decimal(15,2) NOT NULL,
  `vl_devolucao` decimal(15,2) DEFAULT NULL,
  `rm_codcfo` varchar(10) DEFAULT NULL,
  `rm_idpgto` int(10) DEFAULT NULL,
  `idt_atendimento_evento_participante_pagamento` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`idt`),
  KEY `fk_grc_atendimento_evento_contadevolucao_1` (`idt_atendimento_evento`) USING BTREE,
  KEY `fk_grc_atendimento_evento_contadevolucao_2` (`idt_atendimento_evento_participante_pagamento`),
  CONSTRAINT `fk_grc_atendimento_evento_contadevolucao_1` FOREIGN KEY (`idt_atendimento_evento`) REFERENCES `grc_atendimento_evento` (`idt`),
  CONSTRAINT `fk_grc_atendimento_evento_contadevolucao_2` FOREIGN KEY (`idt_atendimento_evento_participante_pagamento`) REFERENCES `grc_atendimento_evento_pagamento` (`idt`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_atendimento_evento_contadevolucao','Conta para Devolução do Pagamento Participante (Evento)','05.01.64.25','S','N','listar','listar');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_atendimento_evento_contadevolucao') as id_funcao
from plu_direito where cod_direito in ('alt','con');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_atendimento_evento_contadevolucao');

-- 04/04/2017

ALTER TABLE `grc_atendimento_evento_contadevolucao` DROP FOREIGN KEY `fk_grc_atendimento_evento_contadevolucao_2`;

ALTER TABLE `grc_atendimento_evento_contadevolucao`
DROP COLUMN `idt_atendimento_evento_participante_pagamento`,
DROP INDEX `fk_grc_atendimento_evento_contadevolucao_2`;

ALTER TABLE `grc_atendimento_evento`
ADD COLUMN `bt_acao_cadastro`  varchar(50) NULL AFTER `idt_midia`,
ADD COLUMN `contrato_ass_pdf`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL AFTER `bt_acao_cadastro`;

ALTER TABLE `grc_atendimento_evento`
DROP COLUMN `contrato_ass_pdf`;

-- 18/04/2017

ALTER TABLE `grc_evento`
ADD COLUMN `dt_consolidado`  datetime NULL AFTER `siacweb_hist_hora_fim`;

update grc_evento set dt_consolidado = (select dt_registro from grc_sincroniza_siac where idt_evento = grc_evento.idt and tipo = 'EV_CON');

-- 19/04/2017

ALTER TABLE `grc_evento`
ADD COLUMN `ws_sg_dt_cadastro`  datetime NULL AFTER `dt_consolidado`,
ADD COLUMN `ws_sg_idprestadora`  int(10) NULL AFTER `ws_sg_dt_cadastro`,
ADD COLUMN `ws_sg_iddemanda`  int(10) NULL AFTER `ws_sg_idprestadora`,
ADD COLUMN `ws_sg_erro`  text NULL AFTER `ws_sg_iddemanda`;

-- 24/04/2017

insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_sincroniza_ws_sg','Sincronização com o SebraeTEC Nacional','02.03.71','S','N','listar','listar');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_sincroniza_ws_sg') as id_funcao
from plu_direito where cod_direito in ('alt','con');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_sincroniza_ws_sg');

select idt INTO @idt_painel from plu_painel where codigo = 'plu_seguranca';
select idt INTO @idt_painel_grupo from plu_painel_grupo where idt_painel = @idt_painel and codigo = '1';
select idt INTO @id_funcao from plu_funcao where cod_funcao = 'grc_sincroniza_ws_sg';

INSERT INTO `db_pir_grc`.`plu_painel_funcao` (`idt_painel_grupo`, `id_funcao`, `pos_top`, `pos_left`, `imagem`, `imagem_d`, `texto_cab`, `detalhe`, `visivel`, `hint`, `parametros`, `texto_font_tam`, `texto_ativ_font_cor`, `texto_ativ_fundo`, `texto_desativ_font_cor`, `texto_desativ_fundo`, `include`, `include_arq`, `include_altura`, `include_largura`) VALUES (@idt_painel_grupo, @id_funcao, '230', '240', NULL, NULL, NULL, NULL, 'S', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'N', NULL, NULL, NULL);

-- 25/04/2017

INSERT INTO `db_pir_grc`.`grc_parametros` (`codigo`, `descricao`, `ativo`, `html`, `detalhe`, `classificacao`) VALUES ('produto_ficha_cont', 'Modelo da Ficha do Produto', 'S', 'S', '<style type=\"text/css\">\r\n	table.tabela {\r\n		width: 100%;\r\n		border: none;\r\n		border-spacing: 0px;\r\n	}\r\n\r\n	table.tabela tr td {\r\n		font-size: 12px;\r\n		padding: 10px;\r\n	}\r\n\r\n	div.tit {\r\n		text-align: center;\r\n		padding: 10px;\r\n		font-size: 18px;\r\n		font-weight: bold;\r\n		color: white;\r\n		background-color: #006daf;\r\n	}\r\n\r\n	table.tabela tr td.cT {\r\n		font-weight: bold;\r\n	}\r\n\r\n	table.tabela tr:nth-child(even) td.cT {\r\n		background-color: #c9c9ca;\r\n	}\r\n\r\n	table.tabela tr:nth-child(even) td.cD {\r\n		background-color: #afc6e5;\r\n	}\r\n\r\n	table.tabela tr:nth-child(odd) td.cT {\r\n		background-color: #e2e2e3;\r\n	}\r\n\r\n	table.tabela tr:nth-child(odd) td.cD {\r\n		background-color: #d3e1f2;\r\n	}\r\n</style>\r\n<div class=\"tit\">IDENTIFICAÇÃO</div>\r\n<table class=\"tabela\">\r\n	<tr>\r\n		<td class=\"cT\">Título:</td><td class=\"cD\" colspan=\"5\">#descricao#</td>\r\n	</tr>\r\n	<tr>\r\n		<td class=\"cT\">Código:</td><td class=\"cD\">#codigo#</td>\r\n		<td class=\"cT\">Cópia:</td><td class=\"cD\">#copia#</td>\r\n		<td class=\"cT\">Ativo:</td><td class=\"cD\">#ativo#</td>\r\n	</tr>\r\n	<tr>\r\n		<td class=\"cT\">Código Produto SIAC:</td><td class=\"cD\">#codigo_classificacao_siac#</td>\r\n		<td class=\"cT\">Descrição do Produto no SIAC:</td><td class=\"cD\" colspan=\"3\">#descricao_siac#</td>\r\n	</tr>\r\n	<tr>\r\n		<td class=\"cT\">Situação Atual:</td><td class=\"cD\">#situacao_atual#</td>\r\n		<td class=\"cT\">Entidade Autora:</td><td class=\"cD\" colspan=\"3\">#entidade_autora#</td>\r\n	</tr>\r\n	<tr>\r\n		<td class=\"cT\">Unidade Autora:</td><td class=\"cD\">#unidade_autora#</td>\r\n		<td class=\"cT\">Unidade Responsável:</td><td class=\"cD\" colspan=\"3\">#unidade_responsavel#</td>\r\n	</tr>\r\n</table>\r\n<div class=\"tit\">CLASSIFICAÇÃO</div>\r\n<table class=\"tabela\">\r\n	<tr>\r\n		<td class=\"cT\">Programa:</td><td class=\"cD\">#programa#</td>\r\n		<td class=\"cT\">Instrumento:</td><td class=\"cD\">#instrumento#</td>\r\n	</tr>\r\n	<tr>\r\n		<td class=\"cT\">Família:</td><td class=\"cD\">#familia#</td>\r\n		<td class=\"cT\">Grupo:</td><td class=\"cD\">#grupo#</td>\r\n	</tr>\r\n	<tr>\r\n		<td class=\"cT\">Modalidade:</td><td class=\"cD\">#modalidade#</td>\r\n		<td class=\"cT\">Foco Temático:</td><td class=\"cD\">#foco_tematico#</td>\r\n	</tr>\r\n	<tr>\r\n		<td class=\"cT\">Natureza Serviço:</td><td class=\"cD\">#natureza_servico#</td>\r\n		<td class=\"cT\">Direitos Autorais:</td><td class=\"cD\">#direitos_autorais#</td>\r\n	</tr>\r\n	<tr>\r\n		<td class=\"cT\">Modelo do Certificado:</td><td class=\"cD\">#modelo_certificado#</td>\r\n		<td class=\"cT\">Maturidade:</td><td class=\"cD\">#maturidade#</td>\r\n	</tr>\r\n</table>\r\n<div class=\"tit\">APLICAÇÃO</div>\r\n<table class=\"tabela\">\r\n	<tr>\r\n		<td class=\"cT\">Gratuito:</td><td class=\"cD\">#gratuito#</td>\r\n		<td class=\"cT\">Grau de Escolaridade:</td><td class=\"cD\">#grau_escolaridade#</td>\r\n	</tr>\r\n	<tr>\r\n		<td class=\"cT\">Participantes - Mínimo:</td><td class=\"cD\">#participante_minimo#</td>\r\n		<td class=\"cT\">Participantes - Máximo:</td><td class=\"cD\">#participante_maximo#</td>\r\n	</tr>\r\n	<tr>\r\n		<td class=\"cT\">Quantidade de Encontros:</td><td class=\"cD\">#encontro_quantidade#</td>\r\n		<td class=\"cT\">Observação Quantidade de Encontros:</td><td class=\"cD\">#encontro_texto#</td>\r\n	</tr>\r\n	<tr>\r\n		<td class=\"cT\">Público Alvo:</td><td class=\"cD\" colspan=\"3\">#publico_alvo#</td>\r\n	</tr>\r\n	<tr>\r\n		<td class=\"cT\">Complemento Publico Alvo:</td><td class=\"cD\" colspan=\"3\">#publico_alvo_texto#</td>\r\n	</tr>\r\n	<tr>\r\n		<td class=\"cT\">Palavras Chaves:</td><td class=\"cD\" colspan=\"3\">#palavra_chave#</td>\r\n	</tr>\r\n	<tr>\r\n		<td class=\"cT\">Carga Horária Instrutoria:</td><td class=\"cD\" colspan=\"3\">#carga_horaria#</td>\r\n	</tr>\r\n	<tr>\r\n		<td class=\"cT\">Carga Horária Consultoria:</td><td class=\"cD\" colspan=\"3\">#carga_horaria_2#</td>\r\n	</tr>\r\n	<tr>\r\n		<td class=\"cT\">Objetivo:</td><td class=\"cD\" colspan=\"3\">#objetivo#</td>\r\n	</tr>\r\n	<tr>\r\n		<td class=\"cT\">Descrição dos Serviços:</td><td class=\"cD\" colspan=\"3\">#detalhe#</td>\r\n	</tr>\r\n	<tr>\r\n		<td class=\"cT\">Conteúdo programático:</td><td class=\"cD\" colspan=\"3\">#conteudo_programatico#</td>\r\n	</tr>\r\n	<tr>\r\n		<td class=\"cT\">Benefícios:</td><td class=\"cD\" colspan=\"3\">#beneficio#</td>\r\n	</tr>\r\n	<tr>\r\n		<td class=\"cT\">Informações Complementares:</td><td class=\"cD\" colspan=\"3\">#complemento#</td>\r\n	</tr>\r\n	<tr>\r\n		<td class=\"cT\">Descrição Comercial:</td><td class=\"cD\" colspan=\"3\">#descricao_comercial#</td>\r\n	</tr>\r\n</table>\r\n<div class=\"tit\">PRODUTOS ASSOCIADOS</div>\r\n#produtos_associados#\r\n<div class=\"tit\">ÁREAS DE CONHECIMENTOS</div>\r\n#areas_de_conhecimentos#\r\n<div class=\"tit\">ARQUIVOS ASSOCIADOS</div>\r\n#arquivos_associados#\r\n<div class=\"tit\">GESTORES DO PRODUTO</div>\r\n#gestores_do_produto#\r\n<div class=\"tit\">DISPONIBILIZAÇÃO - UNIDADE REGIONAL</div>\r\n<table class=\"tabela\">\r\n	<tr>\r\n		<td class=\"cT\" nowrap>Todas as Unidades Regionais:</td><td class=\"cD\" style=\"width: 550px;\">#todas_unidade_regional#</td>\r\n	</tr>\r\n</table>\r\n#unidade_regional#\r\n<div class=\"tit\">PREVISÃO - RESUMO</div>\r\n<table class=\"tabela\">\r\n	<tr>\r\n		<td class=\"cT\">Receita Total Mínima:</td><td class=\"cD\">#rtotal_minimo#</td>\r\n		<td class=\"cT\">Custo Total Mínimo:</td><td class=\"cD\">#ctotal_minimo#</td>\r\n		<td class=\"cT\">Despesas - Receita Mínimo:</td><td class=\"cD\">#dif_minimo#</td>\r\n	</tr>\r\n	<tr>\r\n		<td class=\"cT\">Receita Total Máxima:</td><td class=\"cD\">#rtotal_maximo#</td>\r\n		<td class=\"cT\">Custo Total Máximo:</td><td class=\"cD\">#ctotal_maximo#</td>\r\n		<td class=\"cT\">Despesas - Receita Máximo:</td><td class=\"cD\">#dif_maximo#</td>\r\n	</tr>\r\n	<tr>\r\n		<td class=\"cT\">Receita Total Média:</td><td class=\"cD\">#rmedia#</td>\r\n		<td class=\"cT\">Custo Total Médio:</td><td class=\"cD\">#cmedio#</td>\r\n		<td class=\"cT\">Despesas - Receita Médio:</td><td class=\"cD\">#dif_medio#</td>\r\n	</tr>\r\n</table>\r\n<div class=\"tit\">PREVISÃO - PLANILHA DE RECEITAS</div>\r\n#planilha_de_receitas#\r\n<div class=\"tit\">PREVISÃO - PLANILHA DE DESPESAS (INSUMOS)</div>\r\n#planilha_de_despesas#\r\n<div class=\"tit\">VERSÕES</div>\r\n#versoes#\r\n<div class=\"tit\">OCORRENCIAS</div>\r\n#ocorrencias#', '06.01');
INSERT INTO `db_pir_grc`.`grc_parametros` (`codigo`, `descricao`, `ativo`, `html`, `detalhe`, `classificacao`) VALUES ('produto_ficha_cab', 'Modelo da Ficha do Produto (Cabeçalho)', 'S', 'S', '<table width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\">\r\n    <tbody>\r\n        <tr>\r\n            <td style=\"padding:5px; border-bottom: 1px solid #ecf0f1;\" align=\"left\" width=\"236\"><img style=\"padding:5px;\" src=\"/sebrae_grc/admin/fckupload/images/logo_sebrae.jpg\" alt=\"\" height=\"76\" width=\"236\" border=\"0\" /></td>\r\n            <td style=\"font-size: 24px;  padding:5px; border-bottom: 1px solid #ecf0f1;\" colspan=\"2\" align=\"center\">#nome_titulo#</td>\r\n            <td style=\"font-size: 10px; padding-right:20px; border-bottom: 1px solid #ecf0f1;\" align=\"right\" width=\"200\">Emitido em:&nbsp; <br />\r\n            #data_hora_atual# <br />\r\n            #nome_usuario# <br />\r\n            Pagina: {PAGENO} / {nbpg}</td>\r\n        </tr>\r\n    </tbody>\r\n</table>', '06.02');
INSERT INTO `db_pir_grc`.`grc_parametros` (`codigo`, `descricao`, `ativo`, `html`, `detalhe`, `classificacao`) VALUES ('produto_ficha_rod', 'Modelo da Ficha do Produto (Rodape)', 'S', 'S', '<table border=\"0\" cellpadding=\"0\" width=\"100%\" cellspacing=\"0\">\r\n<tr>\r\n<td style=\"border-bottom: 1px solid #ecf0f1;\">\r\n&nbsp;\r\n</td>\r\n</tr>\r\n</table>', '06.03');
INSERT INTO `db_pir_grc`.`grc_parametros` (`codigo`, `descricao`, `ativo`, `html`, `detalhe`, `classificacao`) VALUES ('produto_ficha_sg_cont', '[SEBRAETEC] Modelo da Ficha do Produto SebraeTEC', 'S', 'S', '<style type=\"text/css\">\r\n	table.tabela {\r\n		width: 100%;\r\n		border: none;\r\n		border-spacing: 0px;\r\n	}\r\n\r\n	table.tabela tr td {\r\n		font-size: 12px;\r\n		padding: 10px;\r\n	}\r\n\r\n	div.tit {\r\n		text-align: center;\r\n		padding: 10px;\r\n		font-size: 18px;\r\n		font-weight: bold;\r\n		color: white;\r\n		background-color: #006daf;\r\n	}\r\n\r\n	table.tabela tr td.cT {\r\n		font-weight: bold;\r\n	}\r\n\r\n	table.tabela tr:nth-child(even) td.cT {\r\n		background-color: #c9c9ca;\r\n	}\r\n\r\n	table.tabela tr:nth-child(even) td.cD {\r\n		background-color: #afc6e5;\r\n	}\r\n\r\n	table.tabela tr:nth-child(odd) td.cT {\r\n		background-color: #e2e2e3;\r\n	}\r\n\r\n	table.tabela tr:nth-child(odd) td.cD {\r\n		background-color: #d3e1f2;\r\n	}\r\n</style>\r\n<div class=\"tit\">IDENTIFICAÇÃO DO PRODUTO</div>\r\n<table class=\"tabela\">\r\n	<tr>\r\n		<td class=\"cT\">Título:</td><td class=\"cD\" colspan=\"3\">#descricao#</td>\r\n	</tr>\r\n	<tr>\r\n		<td class=\"cT\">Código:</td><td class=\"cD\" colspan=\"3\">#codigo#</td>\r\n	</tr>\r\n	<tr>\r\n		<td class=\"cT\">Unidade Autora:</td><td class=\"cD\">#unidade_autora#</td>\r\n		<td class=\"cT\">Unidade Responsável:</td><td class=\"cD\">#unidade_responsavel#</td>\r\n	</tr>\r\n</table>\r\n<div class=\"tit\">APLICAÇÃO DO PRODUTO</div>\r\n<table class=\"tabela\">\r\n	<tr>\r\n		<td class=\"cT\">Gratuito:</td><td class=\"cD\">#gratuito#</td>\r\n		<td class=\"cT\">Grau de Escolaridade:</td><td class=\"cD\">#grau_escolaridade#</td>\r\n	</tr>\r\n	<tr>\r\n		<td class=\"cT\">Quantidade de Encontros Presenciais:</td><td class=\"cD\">#encontro_quantidade#</td>\r\n		<td class=\"cT\">Observação Quantidade de Encontros:</td><td class=\"cD\">#encontro_texto#</td>\r\n	</tr>\r\n	<tr>\r\n		<td class=\"cT\">Público Alvo:</td><td class=\"cD\" colspan=\"3\">#publico_alvo#</td>\r\n	</tr>\r\n	<tr>\r\n		<td class=\"cT\">Complemento Publico Alvo:</td><td class=\"cD\" colspan=\"3\">#publico_alvo_texto#</td>\r\n	</tr>\r\n	<tr>\r\n		<td class=\"cT\">Objetivo:</td><td class=\"cD\" colspan=\"3\">#objetivo#</td>\r\n	</tr>\r\n	<tr>\r\n		<td class=\"cT\">Descrição dos Serviços:</td><td class=\"cD\" colspan=\"3\">#detalhe#</td>\r\n	</tr>\r\n	<tr>\r\n		<td class=\"cT\">Conteúdo programático:</td><td class=\"cD\" colspan=\"3\">#conteudo_programatico#</td>\r\n	</tr>\r\n	<tr>\r\n		<td class=\"cT\">Benefícios:</td><td class=\"cD\" colspan=\"3\">#beneficio#</td>\r\n	</tr>\r\n	<tr>\r\n		<td class=\"cT\">Informações Complementares:</td><td class=\"cD\" colspan=\"3\">#complemento#</td>\r\n	</tr>\r\n	<tr>\r\n		<td class=\"cT\">Descrição Comercial:</td><td class=\"cD\" colspan=\"3\">#descricao_comercial#</td>\r\n	</tr>\r\n</table>\r\n<div class=\"tit\">ENTREGAS DO PRODUTO</div>\r\n#entregas_do_produto#\r\n<div class=\"tit\">DIMENSIONAMENTO DA DEMANDA</div>\r\n#dimensionamento_da_demanda#', '06.04');
INSERT INTO `db_pir_grc`.`grc_parametros` (`codigo`, `descricao`, `ativo`, `html`, `detalhe`, `classificacao`) VALUES ('produto_ficha_sg_cab', '[SEBRAETEC] Modelo da Ficha do Produto SebraeTEC (Cabeçalho)', 'S', 'S', '<table width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\">\r\n    <tbody>\r\n        <tr>\r\n            <td style=\"padding:5px; border-bottom: 1px solid #ecf0f1;\" align=\"left\" width=\"236\"><img style=\"padding:5px;\" src=\"/sebrae_grc/admin/fckupload/images/logo_sebrae.jpg\" alt=\"\" height=\"76\" width=\"236\" border=\"0\" /></td>\r\n            <td style=\"font-size: 24px;  padding:5px; border-bottom: 1px solid #ecf0f1;\" colspan=\"2\" align=\"center\">#nome_titulo#</td>\r\n            <td style=\"font-size: 10px; padding-right:20px; border-bottom: 1px solid #ecf0f1;\" align=\"right\" width=\"200\">Emitido em:&nbsp; <br />\r\n            #data_hora_atual# <br />\r\n            #nome_usuario# <br />\r\n            Pagina: {PAGENO} / {nbpg}</td>\r\n        </tr>\r\n    </tbody>\r\n</table>', '06.05');
INSERT INTO `db_pir_grc`.`grc_parametros` (`codigo`, `descricao`, `ativo`, `html`, `detalhe`, `classificacao`) VALUES ('produto_ficha_sg_rod', '[SEBRAETEC] Modelo da Ficha do Produto SebraeTEC (Rodape)', 'S', 'S', '<table width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\">\r\n    <tbody>\r\n        <tr>\r\n            <td style=\"border-bottom: 1px solid #ecf0f1;\">&nbsp;</td>\r\n        </tr>\r\n    </tbody>\r\n</table>', '06.06');

-- 06/05/2017

ALTER TABLE db_pir_gec.`gec_area_conhecimento`
ADD COLUMN `ws_sg_idarea`  int(10) UNSIGNED NULL AFTER `idt_sgtec_tipo_servico`,
ADD COLUMN `ws_sg_idsubarea`  int(10) UNSIGNED NULL AFTER `ws_sg_idarea`;

update db_pir_gec.gec_area_conhecimento set ws_sg_idarea = 8 where idt = 257;
update db_pir_gec.gec_area_conhecimento set ws_sg_idarea = 12 where idt = 258;
update db_pir_gec.gec_area_conhecimento set ws_sg_idarea = 10 where idt = 259;
update db_pir_gec.gec_area_conhecimento set ws_sg_idarea = 11 where idt = 260;
update db_pir_gec.gec_area_conhecimento set ws_sg_idarea = 9 where idt = 261;
update db_pir_gec.gec_area_conhecimento set ws_sg_idarea = 15 where idt = 262;
update db_pir_gec.gec_area_conhecimento set ws_sg_idarea = 14 where idt = 263;

update db_pir_gec.gec_area_conhecimento set ws_sg_idarea = 14, ws_sg_idsubarea = 38 where idt = 286;
update db_pir_gec.gec_area_conhecimento set ws_sg_idarea = 9, ws_sg_idsubarea = 14 where idt = 281;
update db_pir_gec.gec_area_conhecimento set ws_sg_idarea = 10, ws_sg_idsubarea = 33 where idt = 273;
update db_pir_gec.gec_area_conhecimento set ws_sg_idarea = 10, ws_sg_idsubarea = 7 where idt = 274;
update db_pir_gec.gec_area_conhecimento set ws_sg_idarea = 11, ws_sg_idsubarea = 35 where idt = 276;
update db_pir_gec.gec_area_conhecimento set ws_sg_idarea = 11, ws_sg_idsubarea = 13 where idt = 277;
update db_pir_gec.gec_area_conhecimento set ws_sg_idarea = 8, ws_sg_idsubarea = 1 where idt = 265;
update db_pir_gec.gec_area_conhecimento set ws_sg_idarea = 8, ws_sg_idsubarea = 27 where idt = 266;
update db_pir_gec.gec_area_conhecimento set ws_sg_idarea = 8, ws_sg_idsubarea = 2 where idt = 267;
update db_pir_gec.gec_area_conhecimento set ws_sg_idarea = 8, ws_sg_idsubarea = 3 where idt = 269;
update db_pir_gec.gec_area_conhecimento set ws_sg_idarea = 15, ws_sg_idsubarea = 42 where idt = 284;
update db_pir_gec.gec_area_conhecimento set ws_sg_idarea = 12, ws_sg_idsubarea = 31 where idt = 271;
update db_pir_gec.gec_area_conhecimento set ws_sg_idarea = 14, ws_sg_idsubarea = 18 where idt = 287;
update db_pir_gec.gec_area_conhecimento set ws_sg_idarea = 12, ws_sg_idsubarea = 29 where idt = 268;
update db_pir_gec.gec_area_conhecimento set ws_sg_idarea = 12, ws_sg_idsubarea = 30 where idt = 270;
update db_pir_gec.gec_area_conhecimento set ws_sg_idarea = 14, ws_sg_idsubarea = 39 where idt = 288;
update db_pir_gec.gec_area_conhecimento set ws_sg_idarea = 11, ws_sg_idsubarea = 10 where idt = 278;
update db_pir_gec.gec_area_conhecimento set ws_sg_idarea = 10, ws_sg_idsubarea = 34 where idt = 275;
update db_pir_gec.gec_area_conhecimento set ws_sg_idarea = 9, ws_sg_idsubarea = 15 where idt = 282;
update db_pir_gec.gec_area_conhecimento set ws_sg_idarea = 9, ws_sg_idsubarea = 37 where idt = 283;
update db_pir_gec.gec_area_conhecimento set ws_sg_idarea = 11, ws_sg_idsubarea = 36 where idt = 280;
update db_pir_gec.gec_area_conhecimento set ws_sg_idarea = 11, ws_sg_idsubarea = 11 where idt = 279;
update db_pir_gec.gec_area_conhecimento set ws_sg_idarea = 14, ws_sg_idsubarea = 40 where idt = 289;
update db_pir_gec.gec_area_conhecimento set ws_sg_idarea = 14, ws_sg_idsubarea = 41 where idt = 291;
update db_pir_gec.gec_area_conhecimento set ws_sg_idarea = 15, ws_sg_idsubarea = 43 where idt = 285;
update db_pir_gec.gec_area_conhecimento set ws_sg_idarea = 14, ws_sg_idsubarea = 20 where idt = 290;
update db_pir_gec.gec_area_conhecimento set ws_sg_idarea = 12, ws_sg_idsubarea = 32 where idt = 272;

select id_funcao INTO @id_funcao from plu_funcao where cod_funcao = 'grc_sgtec_natureza';
INSERT INTO `db_pir_grc`.`plu_painel_funcao` (`idt_painel_grupo`, `id_funcao`, `pos_top`, `pos_left`, `imagem`, `imagem_d`, `texto_cab`, `detalhe`, `visivel`, `hint`, `parametros`, `texto_font_tam`, `texto_ativ_font_cor`, `texto_ativ_fundo`, `texto_desativ_font_cor`, `texto_desativ_fundo`, `include`, `include_arq`, `include_altura`, `include_largura`) VALUES ('23', @id_funcao, '270', '340', '397_imagem_366_343imagem962ic-incluir.png', NULL, 'SGTEC - Natureza', NULL, 'S', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'N', NULL, NULL, NULL);

select id_funcao INTO @id_funcao from plu_funcao where cod_funcao = 'grc_sgtec_modalidade';
INSERT INTO `db_pir_grc`.`plu_painel_funcao` (`idt_painel_grupo`, `id_funcao`, `pos_top`, `pos_left`, `imagem`, `imagem_d`, `texto_cab`, `detalhe`, `visivel`, `hint`, `parametros`, `texto_font_tam`, `texto_ativ_font_cor`, `texto_ativ_fundo`, `texto_desativ_font_cor`, `texto_desativ_fundo`, `include`, `include_arq`, `include_altura`, `include_largura`) VALUES ('23', @id_funcao, '135', '340', '398_imagem_352_343imagem962ic-incluir.png', NULL, 'SGTEC - Modalidade', NULL, 'S', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'N', NULL, NULL, NULL);

select id_funcao INTO @id_funcao from plu_funcao where cod_funcao = 'grc_sgtec_tipo_servico';
INSERT INTO `db_pir_grc`.`plu_painel_funcao` (`idt_painel_grupo`, `id_funcao`, `pos_top`, `pos_left`, `imagem`, `imagem_d`, `texto_cab`, `detalhe`, `visivel`, `hint`, `parametros`, `texto_font_tam`, `texto_ativ_font_cor`, `texto_ativ_fundo`, `texto_desativ_font_cor`, `texto_desativ_fundo`, `include`, `include_arq`, `include_altura`, `include_largura`) VALUES ('23', @id_funcao, '0', '680', '399_imagem_375_343imagem962ic-incluir.png', NULL, 'SGTEC - Tipo de Serviço', NULL, 'S', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'N', NULL, NULL, NULL);

UPDATE `grc_sgtec_modalidade` SET `codigo`='10' WHERE (`idt`='2');
UPDATE `grc_sgtec_modalidade` SET `codigo`='11' WHERE (`idt`='3');

UPDATE `grc_sgtec_natureza` SET `codigo`='0' WHERE (`idt`='2');
UPDATE `grc_sgtec_natureza` SET `codigo`='1' WHERE (`idt`='4');
UPDATE `grc_sgtec_natureza` SET `codigo`='2' WHERE (`idt`='5');
UPDATE `grc_sgtec_natureza` SET `codigo`='4' WHERE (`idt`='3');

UPDATE `grc_sgtec_tipo_servico` SET `codigo`='34' WHERE (`idt`='2');
UPDATE `grc_sgtec_tipo_servico` SET `codigo`='35' WHERE (`idt`='3');
UPDATE `grc_sgtec_tipo_servico` SET `codigo`='36' WHERE (`idt`='4');
UPDATE `grc_sgtec_tipo_servico` SET `codigo`='37' WHERE (`idt`='5');
UPDATE `grc_sgtec_tipo_servico` SET `codigo`='38' WHERE (`idt`='6');
UPDATE `grc_sgtec_tipo_servico` SET `codigo`='39' WHERE (`idt`='7');
UPDATE `grc_sgtec_tipo_servico` SET `codigo`='40' WHERE (`idt`='8');
UPDATE `grc_sgtec_tipo_servico` SET `codigo`='41' WHERE (`idt`='9');
UPDATE `grc_sgtec_tipo_servico` SET `codigo`='42' WHERE (`idt`='10');
UPDATE `grc_sgtec_tipo_servico` SET `codigo`='43' WHERE (`idt`='11');

-- homologacao
-- sala
-- producao
-- desenvolve
