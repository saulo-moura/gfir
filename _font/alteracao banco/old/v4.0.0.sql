-- linux

-- 18/01/2016

CREATE TABLE `grc_evento_anexo` (
  `idt` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idt_evento` int(10) unsigned NOT NULL,
  `descricao` varchar(120) NOT NULL,
  `observacao` text,
  `idt_responsavel` int(11) NOT NULL,
  `data_responsavel` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `arquivo` varchar(120) NOT NULL,
  PRIMARY KEY (`idt`),
  KEY `iu_grc_evento_anexo` (`idt_evento`,`descricao`),
  KEY `FK_grc_evento_anexo_2` (`idt_responsavel`),
  CONSTRAINT `FK_grc_evento_anexo_1` FOREIGN KEY (`idt_evento`) REFERENCES `grc_evento` (`idt`) ON DELETE CASCADE,
  CONSTRAINT `FK_grc_evento_anexo_2` FOREIGN KEY (`idt_responsavel`) REFERENCES `plu_usuario` (`id_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_evento_anexo','Evento Anexo','02.03.53','N','N','listar','listar');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_evento_anexo') as id_funcao
from plu_direito where cod_direito in ('con', 'alt', 'exc', 'inc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_evento_anexo');

-- 19/01/2016

ALTER TABLE `grc_atendimento` DROP FOREIGN KEY `FK_grc_atendimento_1`;

ALTER TABLE `grc_atendimento` DROP FOREIGN KEY `FK_grc_atendimento_10`;

ALTER TABLE `grc_atendimento` DROP FOREIGN KEY `FK_grc_atendimento_11`;

ALTER TABLE `grc_atendimento` DROP FOREIGN KEY `FK_grc_atendimento_13`;

ALTER TABLE `grc_atendimento` DROP FOREIGN KEY `FK_grc_atendimento_14`;

ALTER TABLE `grc_atendimento` DROP FOREIGN KEY `FK_grc_atendimento_15`;

ALTER TABLE `grc_atendimento` DROP FOREIGN KEY `FK_grc_atendimento_16`;

ALTER TABLE `grc_atendimento` DROP FOREIGN KEY `FK_grc_atendimento_19`;

ALTER TABLE `grc_atendimento` DROP FOREIGN KEY `FK_grc_atendimento_4`;

ALTER TABLE `grc_atendimento` DROP FOREIGN KEY `FK_grc_atendimento_5`;

ALTER TABLE `grc_atendimento` DROP FOREIGN KEY `FK_grc_atendimento_6`;

ALTER TABLE `grc_atendimento` DROP FOREIGN KEY `FK_grc_atendimento_7`;

ALTER TABLE `grc_atendimento` DROP FOREIGN KEY `FK_grc_atendimento_8`;

ALTER TABLE `grc_atendimento` DROP FOREIGN KEY `FK_grc_atendimento_9`;

ALTER TABLE `grc_atendimento`
ADD COLUMN `idt_digitador`  int(11) NULL AFTER `idt_consultor`;

ALTER TABLE `grc_atendimento` ADD CONSTRAINT `FK_grc_atendimento_1` FOREIGN KEY (`idt_consultor`) REFERENCES `plu_usuario` (`id_usuario`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `grc_atendimento` ADD CONSTRAINT `FK_grc_atendimento_10` FOREIGN KEY (`idt_setor`) REFERENCES `grc_atendimento_empreendimento_setor` (`idt`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `grc_atendimento` ADD CONSTRAINT `FK_grc_atendimento_11` FOREIGN KEY (`idt_tipo_empreendimento`) REFERENCES `grc_atendimento_empreendimento_tipo` (`idt`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `grc_atendimento` ADD CONSTRAINT `FK_grc_atendimento_13` FOREIGN KEY (`idt_competencia`) REFERENCES `grc_competencia` (`idt`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `grc_atendimento` ADD CONSTRAINT `FK_grc_atendimento_14` FOREIGN KEY (`idt_canal`) REFERENCES `grc_produto_canal_midia` (`idt`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `grc_atendimento` ADD CONSTRAINT `FK_grc_atendimento_15` FOREIGN KEY (`idt_categoria`) REFERENCES `grc_atendimento_categoria` (`idt`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `grc_atendimento` ADD CONSTRAINT `FK_grc_atendimento_16` FOREIGN KEY (`idt_tipo_realizacao`) REFERENCES `grc_atendimento_tipo_realizacao` (`idt`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `grc_atendimento` ADD CONSTRAINT `FK_grc_atendimento_19` FOREIGN KEY (`idt_evento`) REFERENCES `grc_evento` (`idt`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `grc_atendimento` ADD CONSTRAINT `FK_grc_atendimento_4` FOREIGN KEY (`idt_atendimento_agenda`) REFERENCES `grc_atendimento_agenda` (`idt`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `grc_atendimento` ADD CONSTRAINT `FK_grc_atendimento_5` FOREIGN KEY (`idt_projeto`) REFERENCES `grc_projeto` (`idt`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `grc_atendimento` ADD CONSTRAINT `FK_grc_atendimento_6` FOREIGN KEY (`idt_projeto_acao`) REFERENCES `grc_projeto_acao` (`idt`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `grc_atendimento` ADD CONSTRAINT `FK_grc_atendimento_7` FOREIGN KEY (`idt_segmentacao`) REFERENCES `grc_atendimento_segmentacao` (`idt`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `grc_atendimento` ADD CONSTRAINT `FK_grc_atendimento_8` FOREIGN KEY (`idt_subsegmentacao`) REFERENCES `grc_atendimento_subsegmentacao` (`idt`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `grc_atendimento` ADD CONSTRAINT `FK_grc_atendimento_9` FOREIGN KEY (`idt_programa_fidelidade`) REFERENCES `grc_atendimento_programa_fidelidade` (`idt`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `grc_atendimento` ADD CONSTRAINT `FK_grc_atendimento_20` FOREIGN KEY (`idt_digitador`) REFERENCES `plu_usuario` (`id_usuario`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `plu_perfil`
ADD COLUMN `atendimento_digitador`  char(1) NOT NULL DEFAULT 'N' AFTER `ativo`;

-- 20/01/2016

CREATE TABLE `grc_produto_publico_alvo` (
  `idt` INTEGER UNSIGNED NOT NULL,
  `idt_publico_alvo` INTEGER UNSIGNED NOT NULL,
  PRIMARY KEY (`idt`, `idt_publico_alvo`),
  CONSTRAINT `fk_grc_produto_publico_alvo_1` FOREIGN KEY `fk_grc_produto_publico_alvo_1` (`idt`)
    REFERENCES `grc_produto` (`idt`)
    ON DELETE CASCADE
    ON UPDATE RESTRICT,
  CONSTRAINT `fk_grc_produto_publico_alvo_2` FOREIGN KEY `fk_grc_produto_publico_alvo_2` (`idt_publico_alvo`)
    REFERENCES `grc_publico_alvo` (`idt`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT
)
ENGINE = InnoDB;

ALTER TABLE `grc_produto_publico_alvo` DROP FOREIGN KEY `fk_grc_produto_publico_alvo_2`;

ALTER TABLE `grc_produto_publico_alvo`
CHANGE COLUMN `idt_publico_alvo` `idt_publico_alvo_outro`  int(10) UNSIGNED NOT NULL AFTER `idt`,
DROP INDEX `fk_grc_produto_publico_alvo_2` ,
ADD INDEX `fk_grc_produto_publico_alvo_2` (`idt_publico_alvo_outro`) USING BTREE ;

ALTER TABLE `grc_produto_publico_alvo` ADD CONSTRAINT `fk_grc_produto_publico_alvo_2` FOREIGN KEY (`idt_publico_alvo_outro`) REFERENCES `grc_publico_alvo` (`idt`) ON DELETE RESTRICT ON UPDATE RESTRICT;

-- 21/01/2016

insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_atender_cliente_1','Instrumentos de Atendimento - Informação','05.01.65.01','N','N','inc','inc');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_atender_cliente_1') as id_funcao
from plu_direito where cod_direito in ('con', 'alt', 'exc', 'inc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_atender_cliente_1');

insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_atender_cliente_2','Instrumentos de Atendimento - Orientação Técnica','05.01.65.02','N','N','inc','inc');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_atender_cliente_2') as id_funcao
from plu_direito where cod_direito in ('con', 'alt', 'exc', 'inc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_atender_cliente_2');

insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_atender_cliente_3','Instrumentos de Atendimento - Consultoria Curta Duração','05.01.65.03','N','N','inc','inc');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_atender_cliente_3') as id_funcao
from plu_direito where cod_direito in ('con', 'alt', 'exc', 'inc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_atender_cliente_3');

update plu_painel_funcao set id_funcao = (select id_funcao from plu_funcao where cod_funcao = 'grc_atender_cliente_1') where idt = 257;
update plu_painel_funcao set id_funcao = (select id_funcao from plu_funcao where cod_funcao = 'grc_atender_cliente_2') where idt = 249;
update plu_painel_funcao set id_funcao = (select id_funcao from plu_funcao where cod_funcao = 'grc_atender_cliente_3') where idt = 254;

insert into plu_direito_perfil (id_perfil, id_difu)
select 6 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_atender_cliente_1');

insert into plu_direito_perfil (id_perfil, id_difu)
select 7 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_atender_cliente_1');

insert into plu_direito_perfil (id_perfil, id_difu)
select 8 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_atender_cliente_1');

insert into plu_direito_perfil (id_perfil, id_difu)
select 9 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_atender_cliente_1');

insert into plu_direito_perfil (id_perfil, id_difu)
select 6 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_atender_cliente_2');

insert into plu_direito_perfil (id_perfil, id_difu)
select 7 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_atender_cliente_2');

insert into plu_direito_perfil (id_perfil, id_difu)
select 8 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_atender_cliente_2');

insert into plu_direito_perfil (id_perfil, id_difu)
select 9 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_atender_cliente_2');

insert into plu_direito_perfil (id_perfil, id_difu)
select 6 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_atender_cliente_3');

insert into plu_direito_perfil (id_perfil, id_difu)
select 7 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_atender_cliente_3');

insert into plu_direito_perfil (id_perfil, id_difu)
select 8 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_atender_cliente_3');

insert into plu_direito_perfil (id_perfil, id_difu)
select 9 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_atender_cliente_3');

-- 22/01/2016

ALTER TABLE `grc_evento_participante`
DROP COLUMN `statuspgto`,
DROP COLUMN `data_pagamento`,
DROP COLUMN `valor_pagamento`;

CREATE TABLE `grc_evento_participante_pagamento` (
  `idt` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idt_atendimento` int(10) unsigned DEFAULT NULL,
  `statuspgto` varchar(45) DEFAULT 'Pendente',
  `data_pagamento` date DEFAULT NULL,
  `valor_pagamento` decimal(15,2) DEFAULT NULL,
  PRIMARY KEY (`idt`),
  KEY `FK_grc_evento_participante_pagamento_2` (`idt_atendimento`) USING BTREE,
  CONSTRAINT `grc_evento_participante_pagamento_ibfk_1` FOREIGN KEY (`idt_atendimento`) REFERENCES `grc_atendimento` (`idt`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_evento_participante_pagamento','Participante Pagamento (Evento)','02.03.36','N','N','listar','listar');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_evento_participante_pagamento') as id_funcao
from plu_direito where cod_direito in ('con', 'alt', 'exc', 'inc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_evento_participante_pagamento');

DROP TABLE `grc_evento_participante_pagamento`;

CREATE TABLE `grc_evento_participante_pagamento` (
  `idt` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idt_atendimento` int(10) unsigned NOT NULL,
  `statuspgto` varchar(45) DEFAULT 'Pendente',
  `data_pagamento` date DEFAULT NULL,
  `valor_pagamento` decimal(15,2) DEFAULT NULL,
  `idt_evento_natureza_pagamento` int(10) unsigned DEFAULT NULL,
  `idt_evento_cartao_bandeira` int(10) unsigned DEFAULT NULL,
  `idt_evento_forma_parcelamento` int(10) unsigned DEFAULT NULL,
  `codigo_nsu` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`idt`),
  KEY `FK_grc_evento_participante_pagamento_2` (`idt_atendimento`) USING BTREE,
  KEY `grc_evento_participante_pagamento_ibfk_2` (`idt_evento_natureza_pagamento`),
  KEY `grc_evento_participante_pagamento_ibfk_3` (`idt_evento_cartao_bandeira`),
  KEY `grc_evento_participante_pagamento_ibfk_4` (`idt_evento_forma_parcelamento`),
  CONSTRAINT `grc_evento_participante_pagamento_ibfk_4` FOREIGN KEY (`idt_evento_forma_parcelamento`) REFERENCES `grc_evento_forma_parcelamento` (`idt`),
  CONSTRAINT `grc_evento_participante_pagamento_ibfk_1` FOREIGN KEY (`idt_atendimento`) REFERENCES `grc_atendimento` (`idt`),
  CONSTRAINT `grc_evento_participante_pagamento_ibfk_2` FOREIGN KEY (`idt_evento_natureza_pagamento`) REFERENCES `grc_evento_natureza_pagamento` (`idt`),
  CONSTRAINT `grc_evento_participante_pagamento_ibfk_3` FOREIGN KEY (`idt_evento_cartao_bandeira`) REFERENCES `grc_evento_cartao_bandeira` (`idt`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;


INSERT INTO `grc_parametros` (`codigo`, `descricao`, `ativo`, `html`, `detalhe`, `classificacao`) VALUES ('evento_modelo_contrato', 'Modelo do Contrato para o Evento', 'S', 'S', '', '02');

-- 26/01/2016

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'monitor_atendimento') as id_funcao
from plu_direito where cod_direito in ('alt');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
inner join plu_direito d on df.id_direito = d.id_direito
where f.cod_funcao in ('monitor_atendimento') and d.cod_direito in ('alt');

ALTER TABLE `grc_evento_forma_parcelamento`
DROP INDEX `iu_grc_evento_forma_parcelamento` ,
ADD UNIQUE INDEX `iu_grc_evento_forma_parcelamento` (`idt_natureza`, `codigo`) USING BTREE ;

-- 27/01/2016

ALTER TABLE `plu_erro_log`
ADD COLUMN `inf_extra`  longtext CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL AFTER `vsession`;

/*
Ver se vai usar esta função...
insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('monitor_evento','Monitoramento de Evento','99.01.04','N','N','listar','listar');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'monitor_evento') as id_funcao
from plu_direito where cod_direito in ('con');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('monitor_evento');
*/

/*
Navicat MySQL Data Transfer

Source Server         : Desenvolvimento
Source Server Version : 50533
Source Host           : servidor:3306
Source Database       : db_pir_grc

Target Server Type    : MYSQL
Target Server Version : 50533
File Encoding         : 65001

Date: 2016-01-27 16:02:55
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for grc_evento_cartao_bandeira
-- ----------------------------
DROP TABLE IF EXISTS `grc_evento_cartao_bandeira`;
CREATE TABLE `grc_evento_cartao_bandeira` (
  `idt` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `codigo` varchar(45) NOT NULL,
  `descricao` varchar(120) DEFAULT NULL,
  `detalhe` varchar(1000) DEFAULT NULL,
  `ativo` varchar(1) NOT NULL DEFAULT 'S',
  PRIMARY KEY (`idt`),
  UNIQUE KEY `iu_grc_evento_cartao_bandeira` (`codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of grc_evento_cartao_bandeira
-- ----------------------------
INSERT INTO `grc_evento_cartao_bandeira` VALUES ('1', 'VISA', 'VISA', null, 'S');
INSERT INTO `grc_evento_cartao_bandeira` VALUES ('2', 'MASTERCARD', 'MASTERCARD', null, 'S');
INSERT INTO `grc_evento_cartao_bandeira` VALUES ('3', 'DINERS', 'DINERS', null, 'S');
INSERT INTO `grc_evento_cartao_bandeira` VALUES ('4', 'ELO', 'ELO', null, 'S');
INSERT INTO `grc_evento_cartao_bandeira` VALUES ('5', 'DISCOVER', 'DISCOVER', null, 'S');
INSERT INTO `grc_evento_cartao_bandeira` VALUES ('6', 'AMEX', 'AMEX', null, 'S');
INSERT INTO `grc_evento_cartao_bandeira` VALUES ('7', 'JCB', 'JCB', null, 'S');
INSERT INTO `grc_evento_cartao_bandeira` VALUES ('8', 'AURA', 'AURA', null, 'S');

-- ----------------------------
-- Table structure for grc_evento_forma_parcelamento
-- ----------------------------
DROP TABLE IF EXISTS `grc_evento_forma_parcelamento`;
CREATE TABLE `grc_evento_forma_parcelamento` (
  `idt` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `codigo` varchar(45) NOT NULL,
  `descricao` varchar(120) DEFAULT NULL,
  `detalhe` varchar(1000) DEFAULT NULL,
  `ativo` varchar(1) NOT NULL DEFAULT 'S',
  `idt_natureza` int(10) unsigned NOT NULL,
  `numero_de_parcelas` int(10) unsigned NOT NULL,
  `valor_ate` decimal(15,2) NOT NULL,
  `valor_ini` decimal(15,2) NOT NULL,
  PRIMARY KEY (`idt`),
  UNIQUE KEY `iu_grc_evento_forma_parcelamento` (`idt_natureza`,`codigo`) USING BTREE,
  CONSTRAINT `FK_grc_evento_forma_parcelamento_1` FOREIGN KEY (`idt_natureza`) REFERENCES `grc_evento_natureza_pagamento` (`idt`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of grc_evento_forma_parcelamento
-- ----------------------------
INSERT INTO `grc_evento_forma_parcelamento` VALUES ('1', 'A Vista', 'Até R$ 99,99', null, 'S', '6', '1', '99.99', '0.00');
INSERT INTO `grc_evento_forma_parcelamento` VALUES ('2', '2X', 'Mínimo de R$ 100,00', null, 'S', '6', '2', '149.99', '100.00');
INSERT INTO `grc_evento_forma_parcelamento` VALUES ('11', 'A Vista', 'A Vista', null, 'S', '2', '1', '0.00', '0.00');
INSERT INTO `grc_evento_forma_parcelamento` VALUES ('12', 'A Vista', 'A Vista', null, 'S', '3', '1', '0.00', '0.00');
INSERT INTO `grc_evento_forma_parcelamento` VALUES ('13', 'A Vista', 'A Vista', null, 'S', '1', '1', '0.00', '0.00');
INSERT INTO `grc_evento_forma_parcelamento` VALUES ('14', 'A Vista', 'A Vista', null, 'S', '5', '1', '0.00', '0.00');
INSERT INTO `grc_evento_forma_parcelamento` VALUES ('15', 'A Vista', 'A Vista', null, 'S', '7', '1', '0.00', '0.00');
INSERT INTO `grc_evento_forma_parcelamento` VALUES ('3', '3X', 'Mínimo de R$ 150,00', null, 'S', '6', '3', '199.99', '150.00');
INSERT INTO `grc_evento_forma_parcelamento` VALUES ('4', '4X', 'Mínimo de R$ 200,00', null, 'S', '6', '4', '249.99', '200.00');
INSERT INTO `grc_evento_forma_parcelamento` VALUES ('5', '5X', 'Mínimo de R$ 250,00', null, 'S', '6', '5', '899.99', '250.00');
INSERT INTO `grc_evento_forma_parcelamento` VALUES ('6', '6X', 'Mínimo de R$ 900,00', null, 'S', '6', '6', '1049.99', '900.00');
INSERT INTO `grc_evento_forma_parcelamento` VALUES ('7', '7X', 'Mínimo de R$ 1.050,00', null, 'S', '6', '7', '1199.99', '1050.00');
INSERT INTO `grc_evento_forma_parcelamento` VALUES ('8', '8X', 'Mínimo de R$ 1.200,00', null, 'S', '6', '8', '1349.99', '1200.00');
INSERT INTO `grc_evento_forma_parcelamento` VALUES ('9', '9X', 'Mínimo de R$ 1.350,00', null, 'S', '6', '9', '1499.99', '1350.00');
INSERT INTO `grc_evento_forma_parcelamento` VALUES ('10', '10X', 'Mínimo de R$ 1.500,00', null, 'S', '6', '10', '9999999999999.99', '1500.00');

-- ----------------------------
-- Table structure for grc_evento_natureza_pagamento
-- ----------------------------
DROP TABLE IF EXISTS `grc_evento_natureza_pagamento`;
CREATE TABLE `grc_evento_natureza_pagamento` (
  `idt` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `codigo` varchar(45) NOT NULL,
  `descricao` varchar(120) DEFAULT NULL,
  `detalhe` varchar(1000) DEFAULT NULL,
  `ativo` varchar(1) NOT NULL DEFAULT 'S',
  PRIMARY KEY (`idt`),
  UNIQUE KEY `iu_grc_evento_natureza_pagamento` (`codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of grc_evento_natureza_pagamento
-- ----------------------------
INSERT INTO `grc_evento_natureza_pagamento` VALUES ('1', 'DI', 'Dinheiro', null, 'S');
INSERT INTO `grc_evento_natureza_pagamento` VALUES ('2', 'CCA', 'Cartão de Crédito A Vista', null, 'S');
INSERT INTO `grc_evento_natureza_pagamento` VALUES ('3', 'BO', 'Boleto', null, 'S');
INSERT INTO `grc_evento_natureza_pagamento` VALUES ('5', 'CD', 'Cartão de Débito', null, 'S');
INSERT INTO `grc_evento_natureza_pagamento` VALUES ('6', 'CCP', 'Cartão de Crédito Parcelado', null, 'S');
INSERT INTO `grc_evento_natureza_pagamento` VALUES ('7', 'DC', 'Débito em Conta', null, 'S');

-- 28/01/2016

ALTER TABLE `grc_evento_participante`
DROP COLUMN `codigo`,
DROP COLUMN `descricao`,
CHANGE COLUMN `ativo` `contrato`  varchar(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT 'N' AFTER `idt_atendimento`;

ALTER TABLE `grc_atendimento_pessoa`
ADD COLUMN `evento_cortesia`  char(1) NULL AFTER `idt_pessoa`;

UPDATE grc_atendimento_pessoa SET evento_cortesia = 'N'
where idt_atendimento in (
select idt from grc_atendimento where idt_evento is not null
);

ALTER TABLE `grc_evento_participante_pagamento`
ADD COLUMN `estornado`  char(1) NOT NULL DEFAULT 'N' AFTER `codigo_nsu`;

-- 29/01/2016

CREATE TABLE `grc_evento_participante_contrato` (
  `idt` INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  `idt_atendimento` INTEGER UNSIGNED NOT NULL,
  `dt_contrato` TIMESTAMP NOT NULL DEFAULT current_TIMESTAMP,
  `idt_usuario_cont` INTEGER NOT NULL,
  `dt_cancelamento` DATETIME,
  `idt_usuario_canc` INTEGER,
  `contrato_txt` LONGTEXT NOT NULL,
  `contrato_pdf` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`idt`),
  CONSTRAINT `fk_grc_evento_participante_contrato_1` FOREIGN KEY `fk_grc_evento_participante_contrato_1` (`idt_atendimento`)
    REFERENCES `grc_atendimento` (`idt`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT,
  CONSTRAINT `fk_grc_evento_participante_contrato_2` FOREIGN KEY `fk_grc_evento_participante_contrato_2` (`idt_usuario_canc`)
    REFERENCES `plu_usuario` (`id_usuario`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT,
  CONSTRAINT `fk_grc_evento_participante_contrato_3` FOREIGN KEY `fk_grc_evento_participante_contrato_3` (`idt_usuario_cont`)
    REFERENCES `plu_usuario` (`id_usuario`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT
)
ENGINE = InnoDB;

ALTER TABLE `grc_evento_participante`
MODIFY COLUMN `contrato`  varchar(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT 'R' AFTER `idt_atendimento`;

UPDATE grc_evento_participante SET contrato = 'R';

ALTER TABLE `grc_evento_participante_pagamento`
ADD COLUMN `idt_evento_participante_contrato`  int(10) UNSIGNED NULL AFTER `codigo_nsu`;

ALTER TABLE `grc_evento_participante_pagamento` ADD CONSTRAINT `grc_evento_participante_pagamento_ibfk_5` FOREIGN KEY (`idt_evento_participante_contrato`) REFERENCES `grc_evento_participante_contrato` (`idt`) ON DELETE RESTRICT ON UPDATE RESTRICT;

-- 01/02/2016

ALTER TABLE `grc_atendimento`
ADD COLUMN `evento_origem`  varchar(10) NULL AFTER `idt_evento`;

UPDATE grc_atendimento SET evento_origem = 'PIR' where idt_evento is not null;

-- 02/02/2016

ALTER TABLE `grc_atendimento_pessoa`
ADD COLUMN `evento_alt_siacweb`  char(1) NULL AFTER `evento_cortesia`;

-- 03/02/2016

ALTER TABLE `grc_atendimento_pessoa`
ADD COLUMN `evento_inscrito`  char(1) NULL AFTER `evento_alt_siacweb`,
ADD COLUMN `evento_exc_siacweb`  char(1) NULL AFTER `evento_inscrito`;

ALTER TABLE `grc_atendimento_pessoa`
ADD COLUMN `falta_sincronizar_siacweb`  char(1) NOT NULL DEFAULT 'N' AFTER `evento_exc_siacweb`;

ALTER TABLE `grc_sincroniza_siac`
ADD COLUMN `idt_atendimento_pessoa`  int(10) UNSIGNED NULL AFTER `idt_atendimento`;

ALTER TABLE `grc_sincroniza_siac` ADD CONSTRAINT `fk_grc_sincroniza_siac_4` FOREIGN KEY (`idt_atendimento_pessoa`) REFERENCES `grc_atendimento_pessoa` (`idt`) ON DELETE CASCADE ON UPDATE NO ACTION;

ALTER TABLE `grc_sincroniza_siac`
MODIFY COLUMN `tipo`  varchar(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL AFTER `idt_evento`;

ALTER TABLE `grc_atendimento`
ADD COLUMN `rm_codcfo`  varchar(20) NULL AFTER `evento_origem`;

-- 05/02/2016

ALTER TABLE db_pir_gec.`cnae`
ADD COLUMN `existe_siacweb`  char(1) NOT NULL DEFAULT 'N' AFTER `ativo`,
ADD COLUMN `codclass_siacweb`  int(10) NULL AFTER `existe_siacweb`,
ADD COLUMN `codativecon_siacweb`  varchar(5) NULL AFTER `codclass_siacweb`,
ADD COLUMN `codcnaefiscal_siacweb`  varchar(2) NULL AFTER `codativecon_siacweb`,
ADD COLUMN `codsetor_siacweb`  int(10) NULL AFTER `codcnaefiscal_siacweb`,
ADD COLUMN `idt_entidade_setor`  int(255) UNSIGNED NULL AFTER `codsetor_siacweb`;

ALTER TABLE db_pir_gec.`cnae` ADD CONSTRAINT `fk_cnae_1` FOREIGN KEY (`idt_entidade_setor`) REFERENCES `gec_entidade_setor` (`idt`) ON DELETE RESTRICT ON UPDATE RESTRICT;

update db_pir_gec.cnae set
codclass_siacweb = 1,
codativecon_siacweb = coalesce(replace(replace(classe, '-', ''), '.', ''), replace(replace(grupo, '-', ''), '.', ''), divisao),
codcnaefiscal_siacweb = right(subclasse, 2);

ALTER TABLE db_pir_gec.`cnae`
MODIFY COLUMN `descricao`  varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL AFTER `codigo`;

-- 06/02/2016

ALTER TABLE `grc_atendimento_pendencia`
ADD COLUMN `idt_usuario_update`  int(10) UNSIGNED NULL AFTER `temporario`,
ADD COLUMN `dt_update`  datetime NULL AFTER `idt_usuario_update`;

ALTER TABLE `grc_atendimento_pendencia`
MODIFY COLUMN `idt_usuario_update`  int(10) NULL DEFAULT NULL AFTER `temporario`;

ALTER TABLE `grc_atendimento_pendencia` ADD CONSTRAINT `FK_grc_atendimento_pendencia_6` FOREIGN KEY (`idt_usuario_update`) REFERENCES `plu_usuario` (`id_usuario`) ON DELETE RESTRICT ON UPDATE CASCADE;

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_evento') as id_funcao
from plu_direito where cod_direito in ('per');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
inner join plu_direito d on df.id_direito = d.id_direito
where f.cod_funcao in ('grc_evento') and d.cod_direito in ('per');

-- 11/02/2016

ALTER TABLE `plu_direito`
ADD COLUMN `desc_funcao`  char(1) NOT NULL DEFAULT 'N' AFTER `nm_direito`;

UPDATE `plu_direito` SET `desc_funcao`='S' WHERE (`id_direito`='5');

ALTER TABLE `plu_direito_funcao`
ADD COLUMN `descricao`  varchar(200) NULL AFTER `id_funcao`;

ALTER TABLE `grc_atendimento_pendencia`
ADD COLUMN `idt_evento_situacao_de`  int(10) UNSIGNED NULL AFTER `dt_update`,
ADD COLUMN `idt_evento_situacao_para`  int(10) UNSIGNED NULL AFTER `idt_evento_situacao_de`;

ALTER TABLE `grc_atendimento_pendencia` ADD CONSTRAINT `FK_grc_atendimento_pendencia_7` FOREIGN KEY (`idt_evento_situacao_de`) REFERENCES `grc_evento_situacao` (`idt`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `grc_atendimento_pendencia` ADD CONSTRAINT `FK_grc_atendimento_pendencia_8` FOREIGN KEY (`idt_evento_situacao_para`) REFERENCES `grc_evento_situacao` (`idt`) ON DELETE RESTRICT ON UPDATE RESTRICT;

INSERT INTO `grc_evento_situacao` (`codigo`, `descricao`, `ativo`, `detalhe`, `situacao_etapa`, `vai_para`, `volta_para`) VALUES ('95', 'CANCELADO', 'S', NULL, 'C', NULL, NULL);

-- 12/02/2016

update grc_evento_insumo set idt_area_suporte = null;
update grc_insumo set idt_area_suporte = null;
update grc_produto_insumo set idt_area_suporte = null;

ALTER TABLE `grc_evento_insumo` DROP FOREIGN KEY `FK_grc_evento_insumo_4`;

ALTER TABLE `grc_evento_insumo`
MODIFY COLUMN `idt_area_suporte`  int(11) NULL DEFAULT NULL AFTER `dif_media`;

ALTER TABLE `grc_evento_insumo` ADD CONSTRAINT `FK_grc_evento_insumo_4` FOREIGN KEY (`idt_area_suporte`) REFERENCES `db_pir`.`sca_organizacao_secao` (`idt`) ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE `grc_insumo` DROP FOREIGN KEY `FK_grc_insumo_3`;

ALTER TABLE `grc_insumo`
MODIFY COLUMN `idt_area_suporte`  int(11) NULL DEFAULT NULL AFTER `evento_insc_receita`;

ALTER TABLE `grc_insumo` ADD CONSTRAINT `FK_grc_insumo_3` FOREIGN KEY (`idt_area_suporte`) REFERENCES `db_pir`.`sca_organizacao_secao` (`idt`) ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE `grc_produto_insumo` DROP FOREIGN KEY `FK_grc_produto_insumo_4`;

ALTER TABLE `grc_produto_insumo`
MODIFY COLUMN `idt_area_suporte`  int(11) NULL DEFAULT NULL AFTER `receita_total`;

ALTER TABLE `grc_produto_insumo` ADD CONSTRAINT `FK_grc_produto_insumo_4` FOREIGN KEY (`idt_area_suporte`) REFERENCES `db_pir`.`sca_organizacao_secao` (`idt`) ON DELETE NO ACTION ON UPDATE NO ACTION;

drop table grc_area_suporte;

-- homologa
-- producao

