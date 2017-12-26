-- 15/07/2015

ALTER TABLE `plu_noticia_sistema`
ADD COLUMN `local_apresentacao`  varchar(45) NOT NULL DEFAULT 'T' AFTER `detalhe`;

Retirar do painel 30.01 - Tabelas de Apoio a função de seção

UPDATE `plu_funcao` SET `cod_funcao`='grc_formulario' WHERE (`id_funcao`='574');
UPDATE `plu_funcao` SET `cod_funcao`='grc_formulario_aplicacao' WHERE (`id_funcao`='572');
UPDATE `plu_funcao` SET `cod_funcao`='grc_formulario_secao', `nm_funcao`='Seção de Formulario' WHERE (`id_funcao`='571');
UPDATE `plu_funcao` SET `cod_funcao`='grc_formulario_pergunta' WHERE (`id_funcao`='575');
UPDATE `plu_funcao` SET `cod_funcao`='grc_formulario_resposta' WHERE (`id_funcao`='576');

/*
Navicat MySQL Data Transfer

Source Server         : Desenvolvimento
Source Server Version : 50533
Source Host           : servidor:3306
Source Database       : db_pir_grc

Target Server Type    : MYSQL
Target Server Version : 50533
File Encoding         : 65001

Date: 2015-07-20 09:27:49
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for grc_avaliacao
-- ----------------------------
DROP TABLE IF EXISTS `grc_avaliacao`;
CREATE TABLE `grc_avaliacao` (
  `idt` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `codigo` varchar(45) NOT NULL,
  `descricao` varchar(120) NOT NULL,
  `ativo` varchar(1) NOT NULL DEFAULT 'S',
  `detalhe` text,
  `idt_avaliador` int(10) unsigned DEFAULT NULL,
  `idt_avaliado` int(10) unsigned DEFAULT NULL,
  `idt_organizacao_avaliador` int(10) unsigned DEFAULT NULL,
  `idt_organizacao_avaliado` int(10) unsigned DEFAULT NULL,
  `observacao` text,
  `data_avaliacao` datetime NOT NULL,
  `data_registro` datetime NOT NULL,
  `idt_responsavel_registro` int(11) NOT NULL,
  `idt_formulario` int(10) unsigned NOT NULL,
  PRIMARY KEY (`idt`),
  UNIQUE KEY `iu_grc_avaliacao` (`codigo`),
  KEY `FK_grc_avaliacao_1` (`idt_formulario`),
  KEY `FK_grc_avaliacao_2` (`idt_responsavel_registro`),
  KEY `FK_grc_avaliacao_3` (`idt_avaliador`),
  KEY `FK_grc_avaliacao_4` (`idt_avaliado`),
  KEY `FK_grc_avaliacao_5` (`idt_organizacao_avaliador`),
  KEY `FK_grc_avaliacao_6` (`idt_organizacao_avaliado`),
  CONSTRAINT `FK_grc_avaliacao_1` FOREIGN KEY (`idt_formulario`) REFERENCES `grc_formulario` (`idt`) ON UPDATE CASCADE,
  CONSTRAINT `FK_grc_avaliacao_2` FOREIGN KEY (`idt_responsavel_registro`) REFERENCES `plu_usuario` (`id_usuario`) ON UPDATE CASCADE,
  CONSTRAINT `FK_grc_avaliacao_3` FOREIGN KEY (`idt_avaliador`) REFERENCES `db_pir_gec`.`gec_entidade` (`idt`),
  CONSTRAINT `FK_grc_avaliacao_4` FOREIGN KEY (`idt_avaliado`) REFERENCES `db_pir_gec`.`gec_entidade` (`idt`),
  CONSTRAINT `FK_grc_avaliacao_5` FOREIGN KEY (`idt_organizacao_avaliador`) REFERENCES `db_pir_gec`.`gec_entidade` (`idt`),
  CONSTRAINT `FK_grc_avaliacao_6` FOREIGN KEY (`idt_organizacao_avaliado`) REFERENCES `db_pir_gec`.`gec_entidade` (`idt`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for grc_formulario
-- ----------------------------
DROP TABLE IF EXISTS `grc_formulario`;
CREATE TABLE `grc_formulario` (
  `idt` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `codigo` varchar(45) NOT NULL,
  `descricao` varchar(120) NOT NULL,
  `ativo` varchar(1) NOT NULL DEFAULT 'S',
  `detalhe` text,
  `qtd_pontos` int(10) unsigned NOT NULL,
  `idt_aplicacao` int(10) unsigned NOT NULL,
  `idt_responsavel` int(11) NOT NULL,
  `idt_area_responsavel` int(11) NOT NULL,
  `versao_texto` varchar(45) NOT NULL DEFAULT 'V.0',
  `versao_numero` decimal(15,2) NOT NULL,
  `data_inicio_aplicacao` datetime NOT NULL,
  `data_termino_aplicacao` datetime NOT NULL,
  `observacao` varchar(4000) DEFAULT NULL,
  PRIMARY KEY (`idt`),
  UNIQUE KEY `iu_grc_formulario` (`codigo`),
  KEY `FK_grc_formulario_1` (`idt_aplicacao`),
  KEY `FK_grc_formulario_2` (`idt_responsavel`),
  KEY `FK_grc_formulario_3` (`idt_area_responsavel`),
  CONSTRAINT `FK_grc_formulario_1` FOREIGN KEY (`idt_aplicacao`) REFERENCES `grc_formulario_aplicacao` (`idt`),
  CONSTRAINT `FK_grc_formulario_2` FOREIGN KEY (`idt_responsavel`) REFERENCES `plu_usuario` (`id_usuario`),
  CONSTRAINT `FK_grc_formulario_3` FOREIGN KEY (`idt_area_responsavel`) REFERENCES `db_pir`.`sca_organizacao_secao` (`idt`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for grc_formulario_aplicacao
-- ----------------------------
DROP TABLE IF EXISTS `grc_formulario_aplicacao`;
CREATE TABLE `grc_formulario_aplicacao` (
  `idt` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `codigo` varchar(45) NOT NULL,
  `descricao` varchar(120) NOT NULL,
  `ativo` varchar(1) NOT NULL,
  `detalhe` text,
  PRIMARY KEY (`idt`),
  UNIQUE KEY `iu_grc_formulario_aplicacao` (`codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for grc_formulario_pergunta
-- ----------------------------
DROP TABLE IF EXISTS `grc_formulario_pergunta`;
CREATE TABLE `grc_formulario_pergunta` (
  `idt` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idt_secao` int(10) unsigned NOT NULL,
  `codigo` varchar(45) NOT NULL,
  `descricao` varchar(120) NOT NULL,
  `detalhe` text,
  `qtd_pontos` int(10) NOT NULL,
  `valido` char(1) NOT NULL DEFAULT 'S',
  PRIMARY KEY (`idt`),
  UNIQUE KEY `iu_grc_formulario_pergunta` (`idt_secao`,`codigo`) USING BTREE,
  CONSTRAINT `FK_grc_formulario_pergunta_2` FOREIGN KEY (`idt_secao`) REFERENCES `grc_formulario_secao` (`idt`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for grc_formulario_resposta
-- ----------------------------
DROP TABLE IF EXISTS `grc_formulario_resposta`;
CREATE TABLE `grc_formulario_resposta` (
  `idt` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idt_pergunta` int(10) unsigned NOT NULL,
  `codigo` varchar(45) NOT NULL,
  `descricao` varchar(120) NOT NULL,
  `detalhe` text,
  `qtd_pontos` int(10) NOT NULL,
  `valido` char(1) NOT NULL DEFAULT 'S',
  `campo_txt` char(1) NOT NULL DEFAULT 'N',
  PRIMARY KEY (`idt`),
  UNIQUE KEY `iu_grc_formulario_resposta` (`idt_pergunta`,`codigo`) USING BTREE,
  CONSTRAINT `FK_grc_formulario_resposta_1` FOREIGN KEY (`idt_pergunta`) REFERENCES `grc_formulario_pergunta` (`idt`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for grc_formulario_secao
-- ----------------------------
DROP TABLE IF EXISTS `grc_formulario_secao`;
CREATE TABLE `grc_formulario_secao` (
  `idt` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idt_formulario` int(10) unsigned NOT NULL,
  `codigo` varchar(45) NOT NULL,
  `descricao` varchar(120) NOT NULL,
  `detalhe` text,
  `qtd_pontos` int(10) NOT NULL,
  `valido` char(1) NOT NULL DEFAULT 'S',
  PRIMARY KEY (`idt`),
  UNIQUE KEY `iu_grc_formulario_secao` (`idt_formulario`,`codigo`) USING BTREE,
  CONSTRAINT `fk_grc_formulario_secao` FOREIGN KEY (`idt_formulario`) REFERENCES `grc_formulario` (`idt`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- 20/07/2015

CREATE TABLE `grc_avaliacao_resposta` (
  `idt` INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  `idt_formulario` INTEGER UNSIGNED NOT NULL,
  `idt_secao` INTEGER UNSIGNED NOT NULL,
  `idt_pergunta` INTEGER UNSIGNED NOT NULL,
  `idt_resposta` INTEGER UNSIGNED NOT NULL,
  `idt_avaliacao` INTEGER UNSIGNED NOT NULL,
  `qtd_pontos` INTEGER UNSIGNED NOT NULL,
  `resposta_txt` TEXT,
  PRIMARY KEY (`idt`),
  INDEX `un_grc_avaliacao_resposta_2`(`idt_avaliacao`, `idt_resposta`),
  CONSTRAINT `fk_grc_avaliacao_resposta_1` FOREIGN KEY `fk_grc_avaliacao_resposta_1` (`idt_formulario`)
    REFERENCES `grc_formulario` (`idt`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT,
  CONSTRAINT `fk_grc_avaliacao_resposta_2` FOREIGN KEY `fk_grc_avaliacao_resposta_2` (`idt_secao`)
    REFERENCES `grc_formulario_secao` (`idt`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT,
  CONSTRAINT `fk_grc_avaliacao_resposta_3` FOREIGN KEY `fk_grc_avaliacao_resposta_3` (`idt_pergunta`)
    REFERENCES `grc_formulario_pergunta` (`idt`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT,
  CONSTRAINT `fk_grc_avaliacao_resposta_4` FOREIGN KEY `fk_grc_avaliacao_resposta_4` (`idt_resposta`)
    REFERENCES `grc_formulario_resposta` (`idt`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT,
  CONSTRAINT `fk_grc_avaliacao_resposta_5` FOREIGN KEY `fk_grc_avaliacao_resposta_5` (`idt_avaliacao`)
    REFERENCES `grc_avaliacao` (`idt`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT
)
ENGINE = InnoDB;

ALTER TABLE `grc_avaliacao_resposta`
MODIFY COLUMN `idt_avaliacao`  int(10) UNSIGNED NOT NULL AFTER `idt`;

ALTER TABLE `grc_avaliacao`
ADD COLUMN `data_resposta`  datetime NULL AFTER `idt_formulario`;

-- 21/07/2015

ALTER TABLE `grc_avaliacao_resposta`
DROP INDEX `un_grc_avaliacao_resposta_2` ,
ADD INDEX `un_grc_avaliacao_resposta_2` (`idt_avaliacao`, `idt_pergunta`) USING BTREE ;


-- linux
