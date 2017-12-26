-- esmeraldo

-- 11/08/2016

ALTER TABLE `grc_atendimento_organizacao`
ADD INDEX `FK_grc_atendimento_organizacao_7` (`dap`) ,
ADD INDEX `FK_grc_atendimento_organizacao_8` (`nirf`) ,
ADD INDEX `FK_grc_atendimento_organizacao_9` (`rmp`) ,
ADD INDEX `FK_grc_atendimento_organizacao_10` (`ie_prod_rural`) ;

ALTER TABLE `grc_entidade_organizacao`
ADD INDEX `FK_grc_entidade_organizacao_7` (`dap`) ,
ADD INDEX `FK_grc_entidade_organizacao_8` (`nirf`) ,
ADD INDEX `FK_grc_entidade_organizacao_9` (`rmp`) ,
ADD INDEX `FK_grc_entidade_organizacao_10` (`ie_prod_rural`) ;

-- 16/08/2016

insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_entidade_ajuste','Ajuste do Produtor Rural','99.99','N','N','listar','listar');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_entidade_ajuste') as id_funcao
from plu_direito where cod_direito in ('alt','con');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_entidade_ajuste');

CREATE TABLE `grc_entidade_ajuste` (
  `idt` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idt_entidade` int(10) DEFAULT NULL,
  `codparceiro_gec` bigint(15) DEFAULT NULL,
  `descricao` varchar(255) DEFAULT NULL,
  `dap` varchar(45) DEFAULT NULL,
  `nirf` varchar(45) DEFAULT NULL,
  `rmp` varchar(45) DEFAULT NULL,
  `ie_prod_rural` varchar(45) DEFAULT NULL,
  `codigo` varchar(45) DEFAULT NULL,
  `codparceiro_siac` int(10) DEFAULT NULL,
  `descricao_siac` varchar(255) DEFAULT NULL,
  `dap_siac` varchar(45) DEFAULT NULL,
  `nirf_siac` varchar(45) DEFAULT NULL,
  `rmp_siac` varchar(45) DEFAULT NULL,
  `ie_prod_rural_siac` varchar(45) DEFAULT NULL,
  `codigo_siac` varchar(45) DEFAULT NULL,
  `erro_descricao` char(1) DEFAULT NULL,
  `erro_codparceiro` char(1) DEFAULT NULL,
  `msg_2` varchar(255) DEFAULT NULL,
  `verificado` varchar(1) DEFAULT NULL,
  PRIMARY KEY (`idt`),
  KEY `un_grc_entidade_ajuste_1` (`dap`),
  KEY `un_grc_entidade_ajuste_2` (`nirf`),
  KEY `un_grc_entidade_ajuste_3` (`rmp`),
  KEY `un_grc_entidade_ajuste_4` (`ie_prod_rural`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- 24/08/2016

ALTER TABLE `grc_atendimento_instrumento`
ADD COLUMN `evento_alcada_coordenador`  decimal(20,2) NOT NULL DEFAULT 0 AFTER `descricao_matriz`;

insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('evento_alcada_coordenador','Alçada Gerente / Coordenador no Evento','05.90.61','N','N','listar','listar');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'evento_alcada_coordenador') as id_funcao
from plu_direito where cod_direito in ('alt','con');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('evento_alcada_coordenador');

UPDATE `db_pir_grc`.`grc_evento_situacao` SET `idt`='2', `codigo`='80', `descricao`='Aguardando aprovação do Gestor do Projeto', `ativo`='S', `detalhe`=NULL, `situacao_etapa`='C', `vai_para`=NULL, `volta_para`=NULL WHERE (`idt`='2');
UPDATE `db_pir_grc`.`grc_evento_situacao` SET `idt`='3', `codigo`='85', `descricao`='Aguardando aprovação do Coordenador/Gerente', `ativo`='S', `detalhe`=NULL, `situacao_etapa`='C', `vai_para`=NULL, `volta_para`=NULL WHERE (`idt`='3');
UPDATE `db_pir_grc`.`grc_evento_situacao` SET `idt`='7', `codigo`='07', `descricao`='Aguardando a aprovação do Diretor', `ativo`='S', `detalhe`=NULL, `situacao_etapa`='A', `vai_para`='10', `volta_para`='03,90' WHERE (`idt`='7');

-- 25/08/2016

insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('evento_alcada_funcao','Funções do RM para Alçada do Evento','05.90.62','N','N','listar','listar');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'evento_alcada_funcao') as id_funcao
from plu_direito where cod_direito in ('alt','con');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('evento_alcada_funcao');

-- 26/08/2016

INSERT INTO `db_pir_grc`.`grc_parametros` (`codigo`, `descricao`, `ativo`, `html`, `detalhe`, `classificacao`) VALUES ('grc_atendimento_pendencia_13', 'Assunto do email para aviso de Evento para o Cadastrante', 'S', 'N', '[#codigo] – Andamento do Evento no CRM|Sebrae', '01.13');
INSERT INTO `db_pir_grc`.`grc_parametros` (`codigo`, `descricao`, `ativo`, `html`, `detalhe`, `classificacao`) VALUES ('grc_atendimento_pendencia_14', 'Mensagem do email para aviso de Evento para o Cadastrante', 'S', 'S', '<p>Caro(a) #responsavel<br />\r\n<br />\r\nO evento de c&oacute;digo n&uacute;mero&nbsp; #codigo aberta em&nbsp; #dt_previsao_inicial no CRM|Sebrae foi enviado para #situacao.<br />\r\n<br />\r\nInforma&ccedil;&otilde;es sobre o evento:<br />\r\n<br />\r\n<strong>T&iacute;tulo do Evento:</strong><br />\r\n#descricao<br />\r\n<strong>Data de Realiza&ccedil;&atilde;o:</strong><br />\r\n#dt_previsao_inicial #hora_inicio a #dt_previsao_fim #hora_fim<br />\r\n<strong> Local/Cidade:</strong><br />\r\n#local / #cidade<br />\r\n<strong> Previs&atilde;o Receita:</strong><br />\r\n#previsao_receita<br />\r\n<strong> Despesas:</strong><br />\r\n#previsao_despesa<br />\r\n<strong> </strong><br />\r\nPara verific&aacute;-la, acesse a p&aacute;gina principal do sistema.<br />\r\n<br />\r\nCordialmente,<br />\r\n<br />\r\nEquipe gestora da Plataforma Integrada de Relacionamento<br />\r\nUnidade de Atendimento Individual - DIRAT<br />\r\nUnidade de Tecnologia da Informa&ccedil;&atilde;o e Comunica&ccedil;&atilde;o - DISUP<br />\r\nSebrae - Bahia<br />\r\n<br />\r\n<strong>IMPORTANTE:</strong> Mensagem autom&aacute;tica do sistema. N&atilde;o responda!</p>', '01.14');

-- 02/09/2016

INSERT INTO `db_pir_grc`.`plu_config` (`variavel`, `descricao`, `valor`, `extra`, `js`) VALUES ('evento_cons_hora_mes', 'A quantidade de horas mensais máximas de um credenciado', '120', NULL, 'N');

CREATE TABLE `grc_evento_motivo_cancelamento` (
  `idt` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `codigo` int(10) NOT NULL,
  `descricao` varchar(120) NOT NULL,
  `ativo` char(1) NOT NULL,
  PRIMARY KEY (`idt`),
  UNIQUE KEY `iu_grc_evento_motivo_cancelamento` (`codigo`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `grc_evento`
ADD COLUMN `idt_evento_motivo_cancelamento`  int(10) UNSIGNED NULL AFTER `idt_evento_situacao_can`;

ALTER TABLE `grc_evento` ADD CONSTRAINT `FK_grc_evento_29` FOREIGN KEY (`idt_evento_motivo_cancelamento`) REFERENCES `grc_evento_motivo_cancelamento` (`idt`) ON DELETE RESTRICT ON UPDATE RESTRICT;

insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_evento_motivo_cancelamento','Evento - Motivo da Recisão','02.03.55','N','N','listar','listar');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_evento_motivo_cancelamento') as id_funcao
from plu_direito where cod_direito in ('alt', 'con', 'inc', 'exc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_evento_motivo_cancelamento');

INSERT INTO `db_pir_grc`.`grc_evento_motivo_cancelamento` (`codigo`, `descricao`, `ativo`) VALUES ('3', 'Falta de Tempo', 'S');
INSERT INTO `db_pir_grc`.`grc_evento_motivo_cancelamento` (`codigo`, `descricao`, `ativo`) VALUES ('4', 'Cliente Insatisfeito', 'S');

-- 05/09/2016

CREATE TABLE `grc_evento_atividade` (
  `idt` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idt_atendimento` int(10) unsigned NOT NULL,
  `atividade` text NOT NULL,
  `cod_atividade` char(32) NOT NULL,
  `consolidado` char(1) NOT NULL DEFAULT 'N',
  PRIMARY KEY (`idt`),
  UNIQUE KEY `un_grc_evento_atividade_1` (`idt_atendimento`,`cod_atividade`),
  CONSTRAINT `fk_grc_evento_atividade_1` FOREIGN KEY (`idt_atendimento`) REFERENCES `grc_atendimento` (`idt`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `grc_evento_agenda`
ADD COLUMN `idt_evento_atividade`  int(10) UNSIGNED NULL AFTER `idt_cidade`;

ALTER TABLE `grc_evento_agenda` ADD CONSTRAINT `fk_grc_evento_agenda_7` FOREIGN KEY (`idt_evento_atividade`) REFERENCES `grc_evento_atividade` (`idt`) ON DELETE RESTRICT ON UPDATE RESTRICT;

-- 08/09/2016

CREATE TABLE `grc_evento_alcada` (
  `idt` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idt_instrumento` int(10) unsigned NOT NULL,
  `idt_sca_organizacao_funcao` int(10) unsigned NOT NULL,
  `vl_alcada` decimal(20,2) unsigned NOT NULL,
  PRIMARY KEY (`idt`),
  UNIQUE KEY `un_grc_evento_alcada_1` (`idt_instrumento`,`idt_sca_organizacao_funcao`),
  KEY `fk_grc_evento_alcada_2` (`idt_sca_organizacao_funcao`),
  CONSTRAINT `fk_grc_evento_alcada_1` FOREIGN KEY (`idt_instrumento`) REFERENCES `grc_atendimento_instrumento` (`idt`),
  CONSTRAINT `fk_grc_evento_alcada_2` FOREIGN KEY (`idt_sca_organizacao_funcao`) REFERENCES `db_pir`.`sca_organizacao_funcao` (`idt`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `grc_atendimento_instrumento`
DROP COLUMN `evento_alcada_coordenador`;

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'evento_alcada_coordenador') as id_funcao
from plu_direito where cod_direito in ('inc', 'exc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
inner join plu_direito d on df.id_direito = d.id_direito
where f.cod_funcao in ('evento_alcada_coordenador')
and d.cod_direito in ('inc', 'exc');

CREATE TABLE `grc_evento_prazo_insumo` (
  `idt` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idt_instrumento` int(10) unsigned NOT NULL,
  `prazo_insumo` int(10) unsigned NOT NULL,
  `prazo_credenciado` int(10) unsigned NOT NULL,
  PRIMARY KEY (`idt`),
  UNIQUE KEY `un_grc_evento_prazo_insumo_1` (`idt_instrumento`),
  CONSTRAINT `fk_grc_evento_prazo_insumo_1` FOREIGN KEY (`idt_instrumento`) REFERENCES `grc_atendimento_instrumento` (`idt`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_evento_prazo_insumo','Prazo do Insumo no Evento','05.90.64','N','N','listar','listar');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_evento_prazo_insumo') as id_funcao
from plu_direito where cod_direito in ('alt', 'con', 'inc', 'exc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_evento_prazo_insumo');

ALTER TABLE `grc_evento`
ADD COLUMN `dt_inicio_aprovacao`  date NULL AFTER `idt_evento_motivo_cancelamento`;

-- 10/09/2016

ALTER TABLE `grc_atendimento`
ADD COLUMN `siacweb_codcosultoria`  int(10) UNSIGNED NULL AFTER `idt_evento`;

ALTER TABLE `grc_evento_atividade`
CHANGE COLUMN `consolidado` `consolidado_cred`  char(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'N' AFTER `cod_atividade`,
ADD COLUMN `consolidado_siacweb`  char(1) NOT NULL DEFAULT 'N' AFTER `consolidado_cred`;

-- 12/09/2016

ALTER TABLE `grc_evento_agenda`
ADD COLUMN `data_inicial_real`  date NULL AFTER `siacweb_codatividade`,
ADD COLUMN `hora_inicial_real`  varchar(5) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL AFTER `data_inicial_real`,
ADD COLUMN `dt_ini_real`  datetime NULL AFTER `hora_inicial_real`,
ADD COLUMN `data_final_real`  date NULL AFTER `dt_ini_real`,
ADD COLUMN `hora_final_real`  varchar(5) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL AFTER `data_final_real`,
ADD COLUMN `dt_fim_real`  datetime NULL AFTER `hora_final_real`,
ADD COLUMN `carga_horaria_real`  decimal(10,2) NULL DEFAULT NULL AFTER `dt_fim_real`;

ALTER TABLE `grc_evento_agenda`
ADD COLUMN `obs_real`  varchar(255) NULL AFTER `dt_fim_real`;

ALTER TABLE `grc_evento_agenda`
DROP COLUMN `siacweb_codatividade`;

ALTER TABLE `grc_evento_atividade`
MODIFY COLUMN `cod_atividade`  char(32) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL AFTER `idt_atendimento`,
ADD COLUMN `idt_tema`  int(10) UNSIGNED NULL DEFAULT NULL AFTER `atividade`,
ADD COLUMN `idt_subtema`  int(10) UNSIGNED NULL DEFAULT NULL AFTER `idt_tema`;

ALTER TABLE `grc_evento_atividade` ADD CONSTRAINT `fk_grc_evento_atividade_2` FOREIGN KEY (`idt_tema`) REFERENCES `grc_tema_subtema` (`idt`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `grc_evento_atividade` ADD CONSTRAINT `fk_grc_evento_atividade_3` FOREIGN KEY (`idt_subtema`) REFERENCES `grc_tema_subtema` (`idt`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `grc_evento_atividade`
MODIFY COLUMN `idt_tema`  int(10) UNSIGNED NOT NULL AFTER `atividade`,
MODIFY COLUMN `idt_subtema`  int(10) UNSIGNED NOT NULL AFTER `idt_tema`;

ALTER TABLE `grc_evento_atividade`
ADD COLUMN `siacweb_codatividade`  int(10) NULL;

-- 13/09/2016

ALTER TABLE `grc_sincroniza_siac`
ADD COLUMN `idt_evento_atividade`  int(10) UNSIGNED NULL AFTER `idt_evento_participante_pagamento`;

ALTER TABLE `grc_sincroniza_siac` ADD CONSTRAINT `fk_grc_sincroniza_siac_7` FOREIGN KEY (`idt_evento_atividade`) REFERENCES `grc_evento_atividade` (`idt`) ON DELETE CASCADE ON UPDATE RESTRICT;

-- 15/09/2016

ALTER TABLE `grc_sincroniza_siac`
ADD INDEX `un_grc_sincroniza_siac_2` (`tipo`) ,
ADD INDEX `un_grc_sincroniza_siac_3` (`dt_sincroniza`) ;

ALTER TABLE `grc_evento`
ADD COLUMN `resultados_obtidos`  text NULL AFTER `sincroniza_loja`;

-- 16/09/2016

ALTER TABLE `grc_produto`
ADD COLUMN `temporario`  char(1) NOT NULL DEFAULT 'N' AFTER `idt`;

-- 17/09/2016

ALTER TABLE `grc_evento`
ADD COLUMN `idt_evento_pai`  int(10) UNSIGNED NULL AFTER `idt`,
ADD COLUMN `composto`  char(1) NOT NULL DEFAULT 'N' AFTER `idt_evento_pai`;

ALTER TABLE `grc_evento` ADD CONSTRAINT `FK_grc_evento_30` FOREIGN KEY (`idt_evento_pai`) REFERENCES `grc_evento` (`idt`) ON DELETE RESTRICT ON UPDATE RESTRICT;

-- 22/09/2016

INSERT INTO `db_pir_grc`.`plu_painel` (`idt`, `codigo`, `classificacao`, `descricao`) VALUES ('38', 'grc_atendimento_distancia', '90.04', 'A Distância');
INSERT INTO `db_pir_grc`.`plu_painel` (`idt`, `codigo`, `classificacao`, `descricao`) VALUES ('40', 'grc_distancia_parametrizacao', '90.04.01', 'Parametrização Atendimento à Distância');

INSERT INTO `db_pir_grc`.`plu_painel_grupo` (`idt`, `idt_painel`, `codigo`, `ordem`, `descricao`, `hint`, `tit_mostrar`, `tit_bt_fecha`, `tit_font_tam`, `tit_font_cor`, `tit_fundo`, `mostra_item`, `texto_altura`, `texto_font_tam`, `texto_ativ_font_cor`, `texto_ativ_fundo`, `texto_desativ_font_cor`, `texto_desativ_fundo`, `move_item`, `passo`, `passo_tit`, `layout_grid`, `img_altura`, `img_largura`, `img_margem_dir`, `img_margem_esq`, `espaco_linha`, `painel_altura`, `painel_largura`) VALUES ('49', '38', '1', '1', 'ATENDIMENTO À DISTÂNCIA', NULL, 'S', 'A', NULL, NULL, NULL, 'IT', '30', NULL, NULL, NULL, NULL, NULL, 'N', 'N', 'N', 'S', '65', '70', '8', '8', '10', '0', '0');
INSERT INTO `db_pir_grc`.`plu_painel_grupo` (`idt`, `idt_painel`, `codigo`, `ordem`, `descricao`, `hint`, `tit_mostrar`, `tit_bt_fecha`, `tit_font_tam`, `tit_font_cor`, `tit_fundo`, `mostra_item`, `texto_altura`, `texto_font_tam`, `texto_ativ_font_cor`, `texto_ativ_fundo`, `texto_desativ_font_cor`, `texto_desativ_fundo`, `move_item`, `passo`, `passo_tit`, `layout_grid`, `img_altura`, `img_largura`, `img_margem_dir`, `img_margem_esq`, `espaco_linha`, `painel_altura`, `painel_largura`) VALUES ('50', '38', '2', '2', 'PAINEL DE BORDO', NULL, 'S', 'A', NULL, NULL, NULL, 'IT', '30', NULL, NULL, NULL, NULL, NULL, 'N', 'N', 'N', 'S', '65', '67', '8', '8', '10', '0', '0');
INSERT INTO `db_pir_grc`.`plu_painel_grupo` (`idt`, `idt_painel`, `codigo`, `ordem`, `descricao`, `hint`, `tit_mostrar`, `tit_bt_fecha`, `tit_font_tam`, `tit_font_cor`, `tit_fundo`, `mostra_item`, `texto_altura`, `texto_font_tam`, `texto_ativ_font_cor`, `texto_ativ_fundo`, `texto_desativ_font_cor`, `texto_desativ_fundo`, `move_item`, `passo`, `passo_tit`, `layout_grid`, `img_altura`, `img_largura`, `img_margem_dir`, `img_margem_esq`, `espaco_linha`, `painel_altura`, `painel_largura`) VALUES ('51', '38', '3', '3', 'INSTRUMENTOS', NULL, 'S', 'A', NULL, NULL, NULL, 'IT', '30', NULL, NULL, NULL, NULL, NULL, 'N', 'N', 'N', 'S', '65', '67', '8', '8', '10', '0', '0');
INSERT INTO `db_pir_grc`.`plu_painel_grupo` (`idt`, `idt_painel`, `codigo`, `ordem`, `descricao`, `hint`, `tit_mostrar`, `tit_bt_fecha`, `tit_font_tam`, `tit_font_cor`, `tit_fundo`, `mostra_item`, `texto_altura`, `texto_font_tam`, `texto_ativ_font_cor`, `texto_ativ_fundo`, `texto_desativ_font_cor`, `texto_desativ_fundo`, `move_item`, `passo`, `passo_tit`, `layout_grid`, `img_altura`, `img_largura`, `img_margem_dir`, `img_margem_esq`, `espaco_linha`, `painel_altura`, `painel_largura`) VALUES ('57', '40', '1', '1', 'GERAL', NULL, 'S', 'A', NULL, NULL, NULL, 'IT', '30', NULL, NULL, NULL, NULL, NULL, 'S', 'N', 'N', 'S', '70', '100', '15', '15', '15', '0', '0');

INSERT INTO `db_pir_grc`.`plu_painel_funcao` (`idt`, `idt_painel_grupo`, `id_funcao`, `pos_top`, `pos_left`, `imagem`, `imagem_d`, `texto_cab`, `detalhe`, `visivel`, `hint`, `parametros`, `texto_font_tam`, `texto_ativ_font_cor`, `texto_ativ_fundo`, `texto_desativ_font_cor`, `texto_desativ_fundo`, `include`, `include_arq`, `include_altura`, `include_largura`) VALUES ('411', '49', '851', '0', '0', '411_imagem_506_259imagem255icagendamento2.jpg', '411_imagem_d_506_259imagemd255icagendamento3.jpg', 'Agendamento', NULL, 'S', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'N', NULL, NULL, NULL);
INSERT INTO `db_pir_grc`.`plu_painel_funcao` (`idt`, `idt_painel_grupo`, `id_funcao`, `pos_top`, `pos_left`, `imagem`, `imagem_d`, `texto_cab`, `detalhe`, `visivel`, `hint`, `parametros`, `texto_font_tam`, `texto_ativ_font_cor`, `texto_ativ_fundo`, `texto_desativ_font_cor`, `texto_desativ_fundo`, `include`, `include_arq`, `include_altura`, `include_largura`) VALUES ('425', '49', NULL, '0', '86', '425_imagem_142_icadistancia.jpg', '425_imagem_d_142_icadistancia2.jpg', 'Telemarketing<br />Ativo', NULL, 'S', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'N', NULL, NULL, NULL);
INSERT INTO `db_pir_grc`.`plu_painel_funcao` (`idt`, `idt_painel_grupo`, `id_funcao`, `pos_top`, `pos_left`, `imagem`, `imagem_d`, `texto_cab`, `detalhe`, `visivel`, `hint`, `parametros`, `texto_font_tam`, `texto_ativ_font_cor`, `texto_ativ_fundo`, `texto_desativ_font_cor`, `texto_desativ_fundo`, `include`, `include_arq`, `include_altura`, `include_largura`) VALUES ('426', '49', NULL, '0', '172', '426_imagem_119_icenviarparaaprovacao.jpg', '426_imagem_d_119_icenvaiarparaaprovacao2.jpg', 'SMS', NULL, 'S', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'N', NULL, NULL, NULL);
INSERT INTO `db_pir_grc`.`plu_painel_funcao` (`idt`, `idt_painel_grupo`, `id_funcao`, `pos_top`, `pos_left`, `imagem`, `imagem_d`, `texto_cab`, `detalhe`, `visivel`, `hint`, `parametros`, `texto_font_tam`, `texto_ativ_font_cor`, `texto_ativ_fundo`, `texto_desativ_font_cor`, `texto_desativ_fundo`, `include`, `include_arq`, `include_altura`, `include_largura`) VALUES ('427', '49', NULL, '0', '258', '427_imagem_096_icenviarparaaprovacao.jpg', '427_imagem_d_096_icenvaiarparaaprovacao2.jpg', 'E-mail<br />Marketing', NULL, 'S', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'N', NULL, NULL, NULL);
INSERT INTO `db_pir_grc`.`plu_painel_funcao` (`idt`, `idt_painel_grupo`, `id_funcao`, `pos_top`, `pos_left`, `imagem`, `imagem_d`, `texto_cab`, `detalhe`, `visivel`, `hint`, `parametros`, `texto_font_tam`, `texto_ativ_font_cor`, `texto_ativ_fundo`, `texto_desativ_font_cor`, `texto_desativ_fundo`, `include`, `include_arq`, `include_altura`, `include_largura`) VALUES ('428', '49', '684', '0', '344', '428_imagem_701_250imagem999icbasedeinformacao.jpg', '428_imagem_d_701_250imagemd999icbasedeinformacao2.jpg', 'Base de Informação', NULL, 'S', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'N', NULL, NULL, NULL);
INSERT INTO `db_pir_grc`.`plu_painel_funcao` (`idt`, `idt_painel_grupo`, `id_funcao`, `pos_top`, `pos_left`, `imagem`, `imagem_d`, `texto_cab`, `detalhe`, `visivel`, `hint`, `parametros`, `texto_font_tam`, `texto_ativ_font_cor`, `texto_ativ_fundo`, `texto_desativ_font_cor`, `texto_desativ_fundo`, `include`, `include_arq`, `include_altura`, `include_largura`) VALUES ('429', '49', '480', '0', '430', '429_imagem_758_251imagem042ic2pesquisaratendimento.jpg', '429_imagem_d_758_251imagemd042ic2pesquisaratendimento2.jpg', 'Pesquisar Atendimentos', NULL, 'S', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'N', NULL, NULL, NULL);
INSERT INTO `db_pir_grc`.`plu_painel_funcao` (`idt`, `idt_painel_grupo`, `id_funcao`, `pos_top`, `pos_left`, `imagem`, `imagem_d`, `texto_cab`, `detalhe`, `visivel`, `hint`, `parametros`, `texto_font_tam`, `texto_ativ_font_cor`, `texto_ativ_fundo`, `texto_desativ_font_cor`, `texto_desativ_fundo`, `include`, `include_arq`, `include_altura`, `include_largura`) VALUES ('430', '49', NULL, '0', '516', '430_imagem_387_292imagem008icfinancas-01.png', '430_imagem_d_387_292imagemd008icfinancas-03.png', 'Financeiro', NULL, 'S', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'N', NULL, NULL, NULL);
INSERT INTO `db_pir_grc`.`plu_painel_funcao` (`idt`, `idt_painel_grupo`, `id_funcao`, `pos_top`, `pos_left`, `imagem`, `imagem_d`, `texto_cab`, `detalhe`, `visivel`, `hint`, `parametros`, `texto_font_tam`, `texto_ativ_font_cor`, `texto_ativ_fundo`, `texto_desativ_font_cor`, `texto_desativ_fundo`, `include`, `include_arq`, `include_altura`, `include_largura`) VALUES ('431', '49', NULL, '0', '602', '431_imagem_427_252imagem966icrelatorios-01.png', '431_imagem_d_427_252imagemd966icrelatorios-03.png', 'Relatórios', NULL, 'S', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'N', NULL, NULL, NULL);
INSERT INTO `db_pir_grc`.`plu_painel_funcao` (`idt`, `idt_painel_grupo`, `id_funcao`, `pos_top`, `pos_left`, `imagem`, `imagem_d`, `texto_cab`, `detalhe`, `visivel`, `hint`, `parametros`, `texto_font_tam`, `texto_ativ_font_cor`, `texto_ativ_fundo`, `texto_desativ_font_cor`, `texto_desativ_fundo`, `include`, `include_arq`, `include_altura`, `include_largura`) VALUES ('432', '49', '638', '0', '688', '432_imagem_470_293imagem368icpendencias2.jpg', '432_imagem_d_470_293imagemd368icpendencias3.jpg', 'Pendências', NULL, 'S', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'N', NULL, NULL, NULL);
INSERT INTO `db_pir_grc`.`plu_painel_funcao` (`idt`, `idt_painel_grupo`, `id_funcao`, `pos_top`, `pos_left`, `imagem`, `imagem_d`, `texto_cab`, `detalhe`, `visivel`, `hint`, `parametros`, `texto_font_tam`, `texto_ativ_font_cor`, `texto_ativ_fundo`, `texto_desativ_font_cor`, `texto_desativ_fundo`, `include`, `include_arq`, `include_altura`, `include_largura`) VALUES ('433', '49', '853', '0', '774', '433_imagem_515_253imagem057icpreferenciasdousuario-01.png', '433_imagem_d_515_253imagemd057icpreferenciasdousuario-03.png', 'Parametrizações', NULL, 'S', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'N', NULL, NULL, NULL);
INSERT INTO `db_pir_grc`.`plu_painel_funcao` (`idt`, `idt_painel_grupo`, `id_funcao`, `pos_top`, `pos_left`, `imagem`, `imagem_d`, `texto_cab`, `detalhe`, `visivel`, `hint`, `parametros`, `texto_font_tam`, `texto_ativ_font_cor`, `texto_ativ_fundo`, `texto_desativ_font_cor`, `texto_desativ_fundo`, `include`, `include_arq`, `include_altura`, `include_largura`) VALUES ('412', '50', NULL, '0', '0', NULL, NULL, 'FUNÇÃO 1', NULL, 'N', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'N', NULL, NULL, NULL);
INSERT INTO `db_pir_grc`.`plu_painel_funcao` (`idt`, `idt_painel_grupo`, `id_funcao`, `pos_top`, `pos_left`, `imagem`, `imagem_d`, `texto_cab`, `detalhe`, `visivel`, `hint`, `parametros`, `texto_font_tam`, `texto_ativ_font_cor`, `texto_ativ_fundo`, `texto_desativ_font_cor`, `texto_desativ_fundo`, `include`, `include_arq`, `include_altura`, `include_largura`) VALUES ('413', '51', '729', '0', '0', '413_imagem_413_257imagem431icinformacao2.jpg', '413_imagem_d_427_257imagemd431icinformacao3.jpg', 'Informação', NULL, 'S', NULL, 'balcao=1&instrumento=1&opcao=inc&distancia=D', NULL, NULL, NULL, NULL, NULL, 'N', NULL, NULL, NULL);
INSERT INTO `db_pir_grc`.`plu_painel_funcao` (`idt`, `idt_painel_grupo`, `id_funcao`, `pos_top`, `pos_left`, `imagem`, `imagem_d`, `texto_cab`, `detalhe`, `visivel`, `hint`, `parametros`, `texto_font_tam`, `texto_ativ_font_cor`, `texto_ativ_fundo`, `texto_desativ_font_cor`, `texto_desativ_fundo`, `include`, `include_arq`, `include_altura`, `include_largura`) VALUES ('414', '51', '730', '0', '83', '414_imagem_863_249imagem521icorientacaotecnica2.jpg', '414_imagem_d_863_249imagemd521icorientacaotecnica3.jpg', 'Orientação Técnica', NULL, 'S', NULL, 'balcao=2&instrumento=2&opcao=inc&distancia=D', NULL, NULL, NULL, NULL, NULL, 'N', NULL, NULL, NULL);
INSERT INTO `db_pir_grc`.`plu_painel_funcao` (`idt`, `idt_painel_grupo`, `id_funcao`, `pos_top`, `pos_left`, `imagem`, `imagem_d`, `texto_cab`, `detalhe`, `visivel`, `hint`, `parametros`, `texto_font_tam`, `texto_ativ_font_cor`, `texto_ativ_fundo`, `texto_desativ_font_cor`, `texto_desativ_fundo`, `include`, `include_arq`, `include_altura`, `include_largura`) VALUES ('415', '51', '731', '0', '166', '415_imagem_935_254imagem643icconsultoria2.jpg', '415_imagem_d_935_254imagemd643icconsultoria3.jpg', 'Consultoria de Curta Duração', NULL, 'S', NULL, 'balcao=3&instrumento=3&opcao=inc&distancia=D', NULL, NULL, NULL, NULL, NULL, 'N', NULL, NULL, NULL);
INSERT INTO `db_pir_grc`.`plu_painel_funcao` (`idt`, `idt_painel_grupo`, `id_funcao`, `pos_top`, `pos_left`, `imagem`, `imagem_d`, `texto_cab`, `detalhe`, `visivel`, `hint`, `parametros`, `texto_font_tam`, `texto_ativ_font_cor`, `texto_ativ_fundo`, `texto_desativ_font_cor`, `texto_desativ_fundo`, `include`, `include_arq`, `include_altura`, `include_largura`) VALUES ('416', '51', '545', '0', '249', '416_imagem_437_254imagem643icconsultoria2.jpg', '416_imagem_d_437_254imagemd643icconsultoria3.jpg', 'Consultoria de Longa Duração', NULL, 'S', NULL, 'idt_instrumento=2&distancia=D', NULL, NULL, NULL, NULL, NULL, 'N', NULL, NULL, NULL);
INSERT INTO `db_pir_grc`.`plu_painel_funcao` (`idt`, `idt_painel_grupo`, `id_funcao`, `pos_top`, `pos_left`, `imagem`, `imagem_d`, `texto_cab`, `detalhe`, `visivel`, `hint`, `parametros`, `texto_font_tam`, `texto_ativ_font_cor`, `texto_ativ_fundo`, `texto_desativ_font_cor`, `texto_desativ_fundo`, `include`, `include_arq`, `include_altura`, `include_largura`) VALUES ('417', '51', '545', '0', '332', '417_imagem_999_254imagem643icconsultoria2.jpg', '417_imagem_d_999_254imagemd643icconsultoria3.jpg', 'Consultoria Tecnológica', NULL, 'S', NULL, 'idt_instrumento=50&distancia=D', NULL, NULL, NULL, NULL, NULL, 'N', NULL, NULL, NULL);
INSERT INTO `db_pir_grc`.`plu_painel_funcao` (`idt`, `idt_painel_grupo`, `id_funcao`, `pos_top`, `pos_left`, `imagem`, `imagem_d`, `texto_cab`, `detalhe`, `visivel`, `hint`, `parametros`, `texto_font_tam`, `texto_ativ_font_cor`, `texto_ativ_fundo`, `texto_desativ_font_cor`, `texto_desativ_fundo`, `include`, `include_arq`, `include_altura`, `include_largura`) VALUES ('418', '51', '545', '0', '415', '418_imagem_050_255imagem699iccurso2.jpg', '418_imagem_d_050_255imagemd699iccurso3.jpg', 'Curso', NULL, 'S', NULL, 'idt_instrumento=40&distancia=D', NULL, NULL, NULL, NULL, NULL, 'N', NULL, NULL, NULL);
INSERT INTO `db_pir_grc`.`plu_painel_funcao` (`idt`, `idt_painel_grupo`, `id_funcao`, `pos_top`, `pos_left`, `imagem`, `imagem_d`, `texto_cab`, `detalhe`, `visivel`, `hint`, `parametros`, `texto_font_tam`, `texto_ativ_font_cor`, `texto_ativ_fundo`, `texto_desativ_font_cor`, `texto_desativ_fundo`, `include`, `include_arq`, `include_altura`, `include_largura`) VALUES ('419', '51', '545', '0', '498', '419_imagem_086_256imagem211icfeiras2.jpg', '419_imagem_d_086_256imagemd211icfeira3.jpg', 'Feira', NULL, 'S', NULL, 'idt_instrumento=41&distancia=D', NULL, NULL, NULL, NULL, NULL, 'N', NULL, NULL, NULL);
INSERT INTO `db_pir_grc`.`plu_painel_funcao` (`idt`, `idt_painel_grupo`, `id_funcao`, `pos_top`, `pos_left`, `imagem`, `imagem_d`, `texto_cab`, `detalhe`, `visivel`, `hint`, `parametros`, `texto_font_tam`, `texto_ativ_font_cor`, `texto_ativ_fundo`, `texto_desativ_font_cor`, `texto_desativ_fundo`, `include`, `include_arq`, `include_altura`, `include_largura`) VALUES ('420', '51', '545', '0', '581', '420_imagem_137_261imagem941icoficina2.jpg', '420_imagem_d_137_261imagemd941icoficina3.jpg', 'Oficina', NULL, 'S', NULL, 'idt_instrumento=46&distancia=D', NULL, NULL, NULL, NULL, NULL, 'N', NULL, NULL, NULL);
INSERT INTO `db_pir_grc`.`plu_painel_funcao` (`idt`, `idt_painel_grupo`, `id_funcao`, `pos_top`, `pos_left`, `imagem`, `imagem_d`, `texto_cab`, `detalhe`, `visivel`, `hint`, `parametros`, `texto_font_tam`, `texto_ativ_font_cor`, `texto_ativ_fundo`, `texto_desativ_font_cor`, `texto_desativ_fundo`, `include`, `include_arq`, `include_altura`, `include_largura`) VALUES ('421', '51', '545', '0', '664', '421_imagem_223_260imagem968icmissaocaravana2.jpg', '421_imagem_d_223_260imagemd968icmissaocaravana3.jpg', 'Missão Caravana', NULL, 'S', NULL, 'idt_instrumento=45&distancia=D', NULL, NULL, NULL, NULL, NULL, 'N', NULL, NULL, NULL);
INSERT INTO `db_pir_grc`.`plu_painel_funcao` (`idt`, `idt_painel_grupo`, `id_funcao`, `pos_top`, `pos_left`, `imagem`, `imagem_d`, `texto_cab`, `detalhe`, `visivel`, `hint`, `parametros`, `texto_font_tam`, `texto_ativ_font_cor`, `texto_ativ_fundo`, `texto_desativ_font_cor`, `texto_desativ_fundo`, `include`, `include_arq`, `include_altura`, `include_largura`) VALUES ('422', '51', '545', '0', '747', '422_imagem_287_262imagem022icpalestra2.jpg', '422_imagem_d_287_262imagemd022icpalestra3.jpg', 'Palestra', NULL, 'S', NULL, 'idt_instrumento=47&distancia=D', NULL, NULL, NULL, NULL, NULL, 'N', NULL, NULL, NULL);
INSERT INTO `db_pir_grc`.`plu_painel_funcao` (`idt`, `idt_painel_grupo`, `id_funcao`, `pos_top`, `pos_left`, `imagem`, `imagem_d`, `texto_cab`, `detalhe`, `visivel`, `hint`, `parametros`, `texto_font_tam`, `texto_ativ_font_cor`, `texto_ativ_fundo`, `texto_desativ_font_cor`, `texto_desativ_fundo`, `include`, `include_arq`, `include_altura`, `include_largura`) VALUES ('423', '51', '545', '0', '830', '423_imagem_330_264imagem466icseminario2.jpg', '423_imagem_d_330_264imagemd466icseminario3.jpg', 'Seminário', NULL, 'S', NULL, 'idt_instrumento=49&distancia=D', NULL, NULL, NULL, NULL, NULL, 'N', NULL, NULL, NULL);
INSERT INTO `db_pir_grc`.`plu_painel_funcao` (`idt`, `idt_painel_grupo`, `id_funcao`, `pos_top`, `pos_left`, `imagem`, `imagem_d`, `texto_cab`, `detalhe`, `visivel`, `hint`, `parametros`, `texto_font_tam`, `texto_ativ_font_cor`, `texto_ativ_fundo`, `texto_desativ_font_cor`, `texto_desativ_fundo`, `include`, `include_arq`, `include_altura`, `include_largura`) VALUES ('424', '51', NULL, '0', '913', '424_imagem_389_263imagem136icrodadadenegocios2.jpg', '424_imagem_d_389_263imagemd136icrodadadenegocios3.jpg', 'Rodada de Negócio', NULL, 'S', NULL, 'idt_instrumento=48&distancia=D', NULL, NULL, NULL, NULL, NULL, 'N', NULL, NULL, NULL);
INSERT INTO `db_pir_grc`.`plu_painel_funcao` (`idt`, `idt_painel_grupo`, `id_funcao`, `pos_top`, `pos_left`, `imagem`, `imagem_d`, `texto_cab`, `detalhe`, `visivel`, `hint`, `parametros`, `texto_font_tam`, `texto_ativ_font_cor`, `texto_ativ_fundo`, `texto_desativ_font_cor`, `texto_desativ_fundo`, `include`, `include_arq`, `include_altura`, `include_largura`) VALUES ('473', '57', '854', '0', '0', NULL, NULL, 'Parâmetros', NULL, 'S', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'N', NULL, NULL, NULL);
INSERT INTO `db_pir_grc`.`plu_painel_funcao` (`idt`, `idt_painel_grupo`, `id_funcao`, `pos_top`, `pos_left`, `imagem`, `imagem_d`, `texto_cab`, `detalhe`, `visivel`, `hint`, `parametros`, `texto_font_tam`, `texto_ativ_font_cor`, `texto_ativ_fundo`, `texto_desativ_font_cor`, `texto_desativ_fundo`, `include`, `include_arq`, `include_altura`, `include_largura`) VALUES ('474', '57', '857', '0', '0', NULL, NULL, 'Formato de Emails e SMS', NULL, 'S', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'N', NULL, NULL, NULL);

insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_atendimento_distancia','Atendimento à Distância','95.48','N','N','inc','inc');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_atendimento_distancia') as id_funcao
from plu_direito where cod_direito in ('alt','con','exc','inc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_atendimento_distancia');

UPDATE `plu_painel_funcao` SET `id_funcao`=(select id_funcao from plu_funcao where cod_funcao = 'grc_atendimento_distancia') WHERE (`idt`='243');

ALTER TABLE `grc_atendimento`
ADD COLUMN `origem`  char(1) NOT NULL DEFAULT 'P' AFTER `idt`;

-- 24/09/2016

ALTER TABLE `grc_evento`
ADD COLUMN `tipo_sincroniza_siacweb`  varchar(10) NOT NULL DEFAULT 'P' AFTER `resultados_obtidos`;

ALTER TABLE `grc_evento_atividade`
ADD COLUMN `idt_evento`  int(10) UNSIGNED NULL AFTER `idt`,
ADD INDEX `fk_grc_evento_atividade_4` (`idt_evento`) USING BTREE ;

ALTER TABLE `grc_evento_atividade` ADD CONSTRAINT `fk_grc_evento_atividade_4` FOREIGN KEY (`idt_evento`) REFERENCES `grc_evento` (`idt`) ON DELETE RESTRICT ON UPDATE RESTRICT;

update grc_evento_atividade set idt_evento = (select idt_evento from grc_atendimento where idt = idt_atendimento);

ALTER TABLE `grc_evento_atividade`
MODIFY COLUMN `idt_evento`  int(10) UNSIGNED NOT NULL AFTER `idt`;

ALTER TABLE `grc_evento_atividade`
MODIFY COLUMN `idt_atendimento`  int(10) UNSIGNED NULL AFTER `idt_evento`;

ALTER TABLE `grc_evento_atividade`
MODIFY COLUMN `idt_tema`  int(10) UNSIGNED NULL AFTER `atividade`,
MODIFY COLUMN `idt_subtema`  int(10) UNSIGNED NULL AFTER `idt_tema`;

ALTER TABLE `grc_evento`
ADD COLUMN `tipo_sincroniza_siacweb_old`  varchar(10) NULL AFTER `tipo_sincroniza_siacweb`;

-- 28/09/2016

INSERT INTO `db_pir_grc`.`grc_atendimento_instrumento` (`idt`, `codigo`, `codigo_siacweb`, `codigo_sge`, `codigo_familia_siac`, `codigo_tipoevento_siac`, `nivel`, `descricao`, `descricao_siacweb`, `ativo`, `detalhe`, `idt_atendimento_instrumento`, `balcao`, `contrapartida_sgtec`, `ordem_matriz`, `descricao_matriz`) VALUES ('52', 'COMPOSTO', NULL, NULL, NULL, NULL, '1', 'Produto Composto', NULL, 'N', NULL, NULL, 'N', NULL, NULL, NULL);

ALTER TABLE `grc_evento`
ADD COLUMN `idt_instrumento_org`  int(10) UNSIGNED NULL AFTER `idt_instrumento`;

ALTER TABLE `grc_evento`
MODIFY COLUMN `descricao`  varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL AFTER `codigo`,
ADD COLUMN `tit_comercical`  varchar(255) NULL AFTER `descricao`;

-- 03/10/2016

ALTER TABLE `grc_atendimento`
ADD COLUMN `codrealizacao`  int(11) NULL AFTER `origem`;

ALTER TABLE `grc_atendimento`
ADD COLUMN `hist_descricao`  varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
ADD COLUMN `hist_codigo`  varchar(45) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL AFTER `hist_descricao`,
ADD COLUMN `hist_dap`  varchar(45) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL AFTER `hist_codigo`,
ADD COLUMN `hist_nirf`  varchar(45) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL AFTER `hist_dap`,
ADD COLUMN `hist_rmp`  varchar(45) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL AFTER `hist_nirf`,
ADD COLUMN `hist_ie_prod_rural`  varchar(45) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL AFTER `hist_rmp`;

-- 07/10/2016

ALTER TABLE `grc_atendimento`
ADD COLUMN `hist_faturam`  int(10) NULL AFTER `hist_ie_prod_rural`,
ADD COLUMN `hist_codconst`  int(10) NULL AFTER `hist_faturam`,
ADD COLUMN `siacweb_faturam`  int(10) NULL AFTER `hist_codconst`,
ADD COLUMN `siacweb_codconst`  int(10) NULL AFTER `siacweb_faturam`;

-- 19/10/2016

ALTER TABLE `grc_evento_atividade` DROP FOREIGN KEY `fk_grc_evento_atividade_1`;

ALTER TABLE `grc_evento_atividade` DROP FOREIGN KEY `fk_grc_evento_atividade_4`;

ALTER TABLE `grc_evento_atividade` ADD CONSTRAINT `fk_grc_evento_atividade_1` FOREIGN KEY (`idt_atendimento`) REFERENCES `grc_atendimento` (`idt`) ON DELETE CASCADE ON UPDATE RESTRICT;

ALTER TABLE `grc_evento_atividade` ADD CONSTRAINT `fk_grc_evento_atividade_4` FOREIGN KEY (`idt_evento`) REFERENCES `grc_evento` (`idt`) ON DELETE CASCADE ON UPDATE RESTRICT;

-- 13/10/2016

UPDATE db_pir_siac_ba.historicorealizacoescliente
SET tiporealizacao = 'ATN'
WHERE
	tiporealizacao = 'NAN'
AND instrumento = 'Orientação Técnica Presencial'
AND codaplicacao = '900000'
AND codrealizacaocomp = '0'
AND abordagem = 'I'
AND rowguid IS NULL;

UPDATE db_pir_siac_ba.historicorealizacoescliente
SET tiporealizacao = 'CON'
WHERE
	tiporealizacao = 'NAN'
AND instrumento = 'Consultoria Presencial'
AND codaplicacao = '900000'
AND codrealizacaocomp = '0'
AND abordagem = 'I'
AND rowguid IS NULL;

executar _font\gera_grc_evento_atividade.php

-- producao
-- homologa
-- sala