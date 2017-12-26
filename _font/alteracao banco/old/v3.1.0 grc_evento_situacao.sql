/*
Navicat MySQL Data Transfer

Source Server         : Desenvolvimento
Source Server Version : 50533
Source Host           : servidor:3306
Source Database       : db_pir_grc

Target Server Type    : MYSQL
Target Server Version : 50533
File Encoding         : 65001

Date: 2015-12-10 18:28:48
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for grc_evento_situacao
-- ----------------------------
DROP TABLE IF EXISTS `grc_evento_situacao`;
CREATE TABLE `grc_evento_situacao` (
  `idt` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `codigo` varchar(45) NOT NULL,
  `descricao` varchar(120) NOT NULL,
  `ativo` varchar(1) NOT NULL DEFAULT 'S',
  `detalhe` text,
  `situacao_etapa` varchar(1) NOT NULL DEFAULT 'D',
  `vai_para` varchar(120) DEFAULT NULL,
  `volta_para` varchar(120) DEFAULT NULL,
  PRIMARY KEY (`idt`),
  UNIQUE KEY `grc_evento_situacao` (`codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of grc_evento_situacao
-- ----------------------------
INSERT INTO `grc_evento_situacao` VALUES ('1', '01', 'EM CONSTRUÇÃO', 'S', 'evento criado e que ainda não foi enviado para aprovação e pode ser editado a qualquer momento', 'D', '05', '03,90');
INSERT INTO `grc_evento_situacao` VALUES ('2', '80', 'REPROVADO', 'N', null, 'C', null, null);
INSERT INTO `grc_evento_situacao` VALUES ('3', '85', 'EXCLUÍDO', 'N', null, 'C', null, null);
INSERT INTO `grc_evento_situacao` VALUES ('4', '90', 'CANCELADO', 'S', null, 'C', null, null);
INSERT INTO `grc_evento_situacao` VALUES ('5', '03', 'DEVOLVIDO', 'S', 'evento devolvido para correção pelo aprovador', 'D', '05', '85,90');
INSERT INTO `grc_evento_situacao` VALUES ('6', '05', 'EM TRAMITAÇÃO', 'S', 'evento percorrendo o fluxo de aprovação. não pode ser editado ou excluído', 'A', '07', '85,90');
INSERT INTO `grc_evento_situacao` VALUES ('7', '07', 'APROVAÇÃO GESTOR', 'N', null, 'A', '10', '03,90');
INSERT INTO `grc_evento_situacao` VALUES ('8', '10', 'DISPONIBILIZAR EVENTO', 'N', null, 'A', '13', '03');
INSERT INTO `grc_evento_situacao` VALUES ('9', '13', 'AGUARDANDO AVALIAÇÃO SETORIAL', 'N', null, 'A', '20', '03,90');
INSERT INTO `grc_evento_situacao` VALUES ('10', '20', 'AGUARDANDO PACTUAÇÃO COM O GERENTE', 'N', null, 'A', '25', '03,90');
INSERT INTO `grc_evento_situacao` VALUES ('11', '25', 'AGUARDANDO PACTUAÇÃO COM O COORDENADOR', 'N', null, 'A', '30', '03,90');
INSERT INTO `grc_evento_situacao` VALUES ('12', '30', 'AGUARDANDO PACTUAÇÃO COM O GERENTE DISPONIBILIZAÇÃO', 'N', null, 'A', '35', '03,90');
INSERT INTO `grc_evento_situacao` VALUES ('13', '75', 'EVENTO SEM SALDO PARA EXECUÇÃO', 'N', null, 'P', '35', '03,90');
INSERT INTO `grc_evento_situacao` VALUES ('14', '35', 'AGENDADO', 'S', 'evento aprovado que irá acontecer em data futura', 'E', '40,75', '03,90');
INSERT INTO `grc_evento_situacao` VALUES ('15', '40', 'AGUARDANDO EXECUÇÃO', 'N', null, 'E', '45', '90');
INSERT INTO `grc_evento_situacao` VALUES ('16', '60', 'EM EXECUÇÃO', 'S', 'evento que ocorre nesse momento - data atual', 'E', null, null);
INSERT INTO `grc_evento_situacao` VALUES ('17', '45', 'DISPARADA SOLICITAÇÃO DE INSUMOS', 'N', null, 'E', '50', '03,90');
INSERT INTO `grc_evento_situacao` VALUES ('18', '50', 'COMPRAS FECHADA', 'N', null, 'E', '60', '03,90');
INSERT INTO `grc_evento_situacao` VALUES ('19', '65', 'PENDENTE', 'S', 'evento que ocorreu no passado, mas não foi consolidado ainda', 'D', null, null);
INSERT INTO `grc_evento_situacao` VALUES ('20', '67', 'CONSOLIDADO', 'S', 'evento encerrado', 'D', null, null);
