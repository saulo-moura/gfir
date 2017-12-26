-- esmeraldo
-- producao

/*
Produção: Executado em 06/12/2016 para implantação do chamado 1486 NF final de Ano

insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_evento_nf','Autorizar NF sem documentação','02.03.75','N','N','listar','listar');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_evento_nf') as id_funcao
from plu_direito where cod_direito in ('alt','con');

insert into plu_direito_funcao (id_direito, id_funcao, descricao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_evento_nf') as id_funcao,
'Se marcado, vai poder autorizar qualquer Evento' as descricao
from plu_direito where cod_direito in ('per');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df 
inner join plu_funcao f on df.id_funcao = f.id_funcao
inner join plu_direito d on df.id_direito = d.id_direito
where f.cod_funcao in ('grc_evento_nf');
-- and d.cod_direito in ('alt','con');
*/

ALTER TABLE `grc_evento`
ADD COLUMN `autorizar_nf_sem_doc`  char(1) NOT NULL DEFAULT 'N' AFTER `sincroniza_loja`;

-- 28/11/2016

-- Painel do grc_evento_monitoramento
INSERT INTO `db_pir_grc`.`plu_painel_funcao` (`idt_painel_grupo`, `id_funcao`, `pos_top`, `pos_left`, `imagem`, `imagem_d`, `texto_cab`, `detalhe`, `visivel`, `hint`, `parametros`, `texto_font_tam`, `texto_ativ_font_cor`, `texto_ativ_fundo`, `texto_desativ_font_cor`, `texto_desativ_fundo`, `include`, `include_arq`, `include_altura`, `include_largura`) VALUES ('1', '799', '115', '840', NULL, NULL, NULL, NULL, 'S', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'N', NULL, NULL, NULL);

/*
Produção: Executado em 06/12/2016 para implantação do chamado 1486 NF final de Ano

ALTER TABLE `grc_evento_prazo_insumo`
ADD COLUMN `idt_programa`  int(10) UNSIGNED NOT NULL DEFAULT 1 AFTER `idt_instrumento`;

ALTER TABLE `grc_evento_prazo_insumo` ADD CONSTRAINT `fk_grc_evento_prazo_insumo_2` FOREIGN KEY (`idt_programa`) REFERENCES `db_pir_gec`.`gec_programa` (`idt`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `grc_evento_prazo_insumo`
MODIFY COLUMN `idt_programa`  int(10) UNSIGNED NOT NULL AFTER `idt_instrumento`;

ALTER TABLE `grc_evento_prazo_insumo`
DROP INDEX `un_grc_evento_prazo_insumo_1` ,
ADD UNIQUE INDEX `un_grc_evento_prazo_insumo_1` (`idt_instrumento`, `idt_programa`) USING BTREE ;

update grc_evento set tipo_sincroniza_siacweb = 'VF'
where idt_instrumento in (46,47);
*/

-- 05/12/2016

ALTER TABLE `grc_evento`
DROP COLUMN `autorizar_nf_sem_doc`;

-- v18.0.0 OS001.1

-- 02/12/2016

ALTER TABLE `grc_transferencia_responsabilidade`
DROP COLUMN `codigo`,
DROP COLUMN `detalhe`,
MODIFY COLUMN `justificativa`  text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL AFTER `ativo`,
MODIFY COLUMN `idt_colaborador_origem`  int(11) NOT NULL AFTER `justificativa`,
MODIFY COLUMN `idt_colaborador_destino`  int(11) NOT NULL AFTER `idt_colaborador_origem`,
CHANGE COLUMN `data_validade` `data_validade_ini`  date NOT NULL AFTER `idt_colaborador_destino`,
ADD COLUMN `tipo`  char(1) NOT NULL AFTER `idt`,
ADD COLUMN `data_validade_fim`  date NOT NULL AFTER `data_validade_ini`,
DROP INDEX `iu_grc_transferencia_responsabilidade`;

ALTER TABLE `grc_transferencia_responsabilidade` ADD CONSTRAINT `fk_grc_transferencia_responsabilidade_1` FOREIGN KEY (`idt_colaborador_origem`) REFERENCES `plu_usuario` (`id_usuario`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `grc_transferencia_responsabilidade` ADD CONSTRAINT `fk_grc_transferencia_responsabilidade_2` FOREIGN KEY (`idt_colaborador_destino`) REFERENCES `plu_usuario` (`id_usuario`) ON DELETE RESTRICT ON UPDATE RESTRICT;

CREATE TABLE `grc_transferencia_responsabilidade_reg` (
`idt`  int(10) UNSIGNED NOT NULL AUTO_INCREMENT ,
`idt_transferencia_responsabilidade`  int(10) UNSIGNED NOT NULL ,
`tipo`  varchar(120) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '' ,
`idt_evento`  int(10) UNSIGNED NULL DEFAULT NULL ,
`idt_atendimento`  int(10) UNSIGNED NULL DEFAULT NULL ,
PRIMARY KEY (`idt`),
CONSTRAINT `fk_grc_transferencia_responsabilidade_reg_1` FOREIGN KEY (`idt_transferencia_responsabilidade`) REFERENCES `grc_transferencia_responsabilidade` (`idt`) ON DELETE RESTRICT ON UPDATE RESTRICT,
CONSTRAINT `fk_grc_transferencia_responsabilidade_reg_2` FOREIGN KEY (`idt_evento`) REFERENCES `grc_evento` (`idt`) ON DELETE RESTRICT ON UPDATE RESTRICT,
CONSTRAINT `fk_grc_transferencia_responsabilidade_reg_3` FOREIGN KEY (`idt_atendimento`) REFERENCES `grc_atendimento` (`idt`) ON DELETE RESTRICT ON UPDATE RESTRICT,
UNIQUE INDEX `un_grc_transferencia_responsabilidade_reg_1` (`idt_transferencia_responsabilidade`, `tipo`, `idt_evento`, `idt_atendimento`) 
);

-- 08/12/2016

ALTER TABLE `grc_transferencia_responsabilidade`
CHANGE COLUMN `ativo` `situacao`  char(2) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'S' AFTER `descricao`;

ALTER TABLE `grc_transferencia_responsabilidade_reg` DROP FOREIGN KEY `fk_grc_transferencia_responsabilidade_reg_2`;

ALTER TABLE `grc_transferencia_responsabilidade_reg` DROP FOREIGN KEY `fk_grc_transferencia_responsabilidade_reg_3`;

ALTER TABLE `grc_transferencia_responsabilidade_reg`
DROP COLUMN `idt_evento`,
CHANGE COLUMN `idt_atendimento` `idt_atendimento_pendencia`  int(10) UNSIGNED NOT NULL AFTER `idt_transferencia_responsabilidade`,
CHANGE COLUMN `tipo` `ativo`  char(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '' AFTER `idt_atendimento_pendencia`,
DROP INDEX `fk_grc_transferencia_responsabilidade_reg_2`,
DROP INDEX `fk_grc_transferencia_responsabilidade_reg_3`,
DROP INDEX `un_grc_transferencia_responsabilidade_reg_1` ,
ADD UNIQUE INDEX `un_grc_transferencia_responsabilidade_reg_1` (`idt_transferencia_responsabilidade`, `idt_atendimento_pendencia`) USING BTREE ;

ALTER TABLE `grc_transferencia_responsabilidade_reg` ADD CONSTRAINT `fk_grc_transferencia_responsabilidade_reg_2` FOREIGN KEY (`idt_atendimento_pendencia`) REFERENCES `grc_atendimento_pendencia` (`idt`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `grc_transferencia_responsabilidade`
MODIFY COLUMN `data_validade_ini`  date NULL AFTER `idt_colaborador_destino`,
MODIFY COLUMN `data_validade_fim`  date NULL AFTER `data_validade_ini`,
ADD COLUMN `chk_evento`  char(1) NOT NULL COMMENT 'Pendencias do Tipo: Evento' AFTER `data_validade_fim`,
ADD COLUMN `chk_pag_cred`  char(1) NOT NULL COMMENT 'Pendencias do Tipo: Pagamento a Credenciado' AFTER `chk_evento`,
ADD COLUMN `chk_atend`  char(1) NOT NULL COMMENT 'Pendencias do Tipo: Atendimento Presencial' AFTER `chk_pag_cred`;

ALTER TABLE `grc_transferencia_responsabilidade`
ADD COLUMN `evidencia`  varchar(255) NOT NULL AFTER `data_validade_fim`,
ADD COLUMN `dt_etapa_gc`  datetime NULL AFTER `chk_atend`,
ADD COLUMN `usuario_etapa_gc`  int(11) NULL AFTER `dt_etapa_gc`,
ADD COLUMN `dt_etapa_cg`  datetime NULL AFTER `usuario_etapa_gc`,
ADD COLUMN `usuario_etapa_cg`  int(11) NULL AFTER `dt_etapa_cg`,
ADD COLUMN `justificativa_reprovacao`  text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL AFTER `usuario_etapa_cg`;

ALTER TABLE `grc_transferencia_responsabilidade` ADD CONSTRAINT `fk_grc_transferencia_responsabilidade_3` FOREIGN KEY (`usuario_etapa_gc`) REFERENCES `plu_usuario` (`id_usuario`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `grc_transferencia_responsabilidade` ADD CONSTRAINT `fk_grc_transferencia_responsabilidade_4` FOREIGN KEY (`usuario_etapa_cg`) REFERENCES `plu_usuario` (`id_usuario`) ON DELETE RESTRICT ON UPDATE RESTRICT;

delete from plu_direito_funcao 
where id_funcao in (select id_funcao from plu_funcao where cod_funcao = 'grc_transferencia_responsabilidade')
and id_direito in (select id_direito from plu_direito where cod_direito in ('exc'));

ALTER TABLE `grc_transferencia_responsabilidade`
DROP COLUMN `data_validade_fim`,
CHANGE COLUMN `data_validade_ini` `dt_validade`  date NOT NULL AFTER `idt_colaborador_destino`;

-- 09/12/2016

ALTER TABLE `grc_atendimento_pendencia`
ADD COLUMN `idt_transferencia_responsabilidade`  int(10) UNSIGNED NULL AFTER `idt_evento`;

ALTER TABLE `grc_atendimento_pendencia`
DROP INDEX `FK_grc_atendimento_pendencia_11` ,
ADD INDEX `FK_grc_atendimento_pendencia_1` (`idt_atendimento`) USING BTREE ;

ALTER TABLE `grc_atendimento_pendencia` ADD CONSTRAINT `FK_grc_atendimento_pendencia_11` FOREIGN KEY (`idt_transferencia_responsabilidade`) REFERENCES `grc_transferencia_responsabilidade` (`idt`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `grc_atendimento_pendencia`
MODIFY COLUMN `idt_pfo_af_processo`  int(10) UNSIGNED NULL DEFAULT NULL AFTER `idt_evento`;

-- 12/12/2016

INSERT INTO `db_pir_grc`.`grc_parametros` (`codigo`, `descricao`, `ativo`, `html`, `detalhe`, `classificacao`) VALUES ('grc_transferencia_responsabilidade_01', 'Assunto do email da Reprovação da Transferência de Responsabilidades', 'S', 'N', '[#protocolo#] - Reprova&ccedil;&atilde;o da Transfer&ecirc;ncia de Responsabilidades no CRM | Sebrae', '04.01');
INSERT INTO `db_pir_grc`.`grc_parametros` (`codigo`, `descricao`, `ativo`, `html`, `detalhe`, `classificacao`) VALUES ('grc_transferencia_responsabilidade_02', 'Mensagem do email da Reprovação da Transferência de Responsabilidades', 'S', 'S', '<p>Caro(a) #responsavel#<br />\r\n<br />\r\nA sua solicita&ccedil;&atilde;o de Transfer&ecirc;ncia de Responsabilidades foi Reprovada.<br />\r\n<br />\r\n<strong> Justificativa da Reprova&ccedil;&atilde;o:</strong><br />\r\n#justificativa_reprovacao#<br />\r\n<br />\r\nInforma&ccedil;&otilde;es sobre a Transfer&ecirc;ncia de Responsabilidades:<br />\r\n<br />\r\n<strong> Protocolo:</strong><br />\r\n#protocolo#<br />\r\n<strong> Descri&ccedil;&atilde;o:</strong><br />\r\n#descricao#<br />\r\n<strong> Colaborador Origem:</strong><br />\r\n#colaborador_origem#<br />\r\n<strong> Colaborador Destino:</strong><br />\r\n#colaborador_destino#<br />\r\n<strong> Validade da Transfer&ecirc;ncia:</strong><br />\r\n#dt_validade#<br />\r\n<strong> Justificativa:</strong><br />\r\n#justificativa#<br />\r\n<br />\r\nPara responde-la, acesse pagina principal do sistema.<br />\r\n<br />\r\nCordialmente,<br />\r\n<br />\r\nEquipe Gestora da Plataforma Integrada de Relacionamento<br />\r\nUnidade de Atendimento Individual - DIRAT<br />\r\nUnidade de Tecnologia da Informa&ccedil;&atilde;o e Comunica&ccedil;&atilde;o - DISUP<br />\r\nSebrae - Bahia<br />\r\n<br />\r\n<strong>IMPORTANTE:</strong> Mensagem autom&aacute;tica  do sistema. N&atilde;o responda!</p>', '04.02');

INSERT INTO `db_pir_grc`.`grc_parametros` (`codigo`, `descricao`, `ativo`, `html`, `detalhe`, `classificacao`) VALUES ('grc_transferencia_responsabilidade_03', 'Assunto do email da Aprovação da Transferência de Responsabilidades', 'S', 'N', '[#protocolo#] - Aprova&ccedil;&atilde;o da Transfer&ecirc;ncia de Responsabilidades no CRM | Sebrae', '04.03');
INSERT INTO `db_pir_grc`.`grc_parametros` (`codigo`, `descricao`, `ativo`, `html`, `detalhe`, `classificacao`) VALUES ('grc_transferencia_responsabilidade_04', 'Mensagem do email da Aprovação da Transferência de Responsabilidades', 'S', 'S', '<p>Caro(a) #responsavel#<br />\r\n<br />\r\nA sua solicita&ccedil;&atilde;o de Transfer&ecirc;ncia de Responsabilidades foi Aprovada.<br />\r\n<br />\r\nInforma&ccedil;&otilde;es sobre a Transfer&ecirc;ncia de Responsabilidades:<br />\r\n<br />\r\n<strong> Protocolo:</strong><br />\r\n#protocolo#<br />\r\n<strong> Descri&ccedil;&atilde;o:</strong><br />\r\n#descricao#<br />\r\n<strong> Colaborador Origem:</strong><br />\r\n#colaborador_origem#<br />\r\n<strong> Colaborador Destino:</strong><br />\r\n#colaborador_destino#<br />\r\n<strong> Validade da Transfer&ecirc;ncia:</strong><br />\r\n#dt_validade#<br />\r\n<strong> Justificativa:</strong><br />\r\n#justificativa#<br />\r\n<br />\r\nPara responde-la, acesse pagina principal do sistema.<br />\r\n<br />\r\nCordialmente,<br />\r\n<br />\r\nEquipe Gestora da Plataforma Integrada de Relacionamento<br />\r\nUnidade de Atendimento Individual - DIRAT<br />\r\nUnidade de Tecnologia da Informa&ccedil;&atilde;o e Comunica&ccedil;&atilde;o - DISUP<br />\r\nSebrae - Bahia<br />\r\n<br />\r\n<strong>IMPORTANTE:</strong> Mensagem autom&aacute;tica  do sistema. N&atilde;o responda!</p>', '04.04');

ALTER TABLE db_pir.`sca_organizacao_secao`
ADD COLUMN `grc_transferencia_responsabilidade`  char(255) NOT NULL DEFAULT 'N' AFTER `telefone`;

UPDATE db_pir.`sca_organizacao_secao` SET `grc_transferencia_responsabilidade`='S' WHERE (`idt`='13');

ALTER TABLE `grc_transferencia_responsabilidade`
ADD COLUMN `dt_inicio`  date NOT NULL AFTER `idt_colaborador_destino`;

ALTER TABLE `grc_atendimento_pendencia`
ADD COLUMN `idt_atendimento_pendencia_trans`  int(10) UNSIGNED NULL AFTER `idt_evento_situacao_para`,
ADD COLUMN `dt_limite_trans`  date NULL AFTER `idt_atendimento_pendencia_trans`;

ALTER TABLE `grc_atendimento_pendencia` ADD CONSTRAINT `FK_grc_atendimento_pendencia_12` FOREIGN KEY (`idt_atendimento_pendencia_trans`) REFERENCES `grc_atendimento_pendencia` (`idt`) ON DELETE RESTRICT ON UPDATE RESTRICT;

-- 13/12/2016

ALTER TABLE `grc_atendimento_pendencia`
ADD INDEX `un_grc_atendimento_pendencia_1` (`dt_limite_trans`) ;

-- 14/12/2016

ALTER TABLE `grc_transferencia_responsabilidade`
MODIFY COLUMN `evidencia`  varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL AFTER `dt_validade`;

-- 19/01/2017

insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_transferencia_interinidade','Transferência por Interinidade','95.65.61','S','S','listar','listar');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_transferencia_interinidade') as id_funcao
from plu_direito where cod_direito in ('con');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df 
inner join plu_funcao f on df.id_funcao = f.id_funcao
inner join plu_direito d on df.id_direito = d.id_direito
where f.cod_funcao in ('grc_transferencia_interinidade');
-- and d.cod_direito in ('alt','con');

ALTER TABLE `plu_perfil`
ADD COLUMN `trans_resp_aprova_cgp`  char(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'N' AFTER `coloca_evento_retroaitvo`;

-- desenvolve
-- homologacao
-- jonata
-- sala
