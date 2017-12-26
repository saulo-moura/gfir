-- 793717365-34
-- 028373325-00 nan 2 visita

-- esmeraldo

-- 04/07/2016

ALTER TABLE `grc_evento_insumo`
ADD COLUMN `cod_ordem_contratacao`  varchar(30) NULL AFTER `idt_ordem_contratacao`;

ALTER TABLE `grc_evento_insumo` DROP FOREIGN KEY `FK_grc_evento_insumo_2`,
DROP FOREIGN KEY `FK_grc_evento_insumo_3`,
DROP FOREIGN KEY `FK_grc_evento_insumo_4`,
DROP FOREIGN KEY `FK_grc_evento_insumo_5`,
DROP FOREIGN KEY `FK_grc_pevento_insumo`;

ALTER TABLE `grc_evento_insumo` ADD CONSTRAINT `FK_grc_evento_insumo_2` FOREIGN KEY (`idt_insumo`) REFERENCES `grc_insumo` (`idt`) ON DELETE RESTRICT ON UPDATE RESTRICT,
ADD CONSTRAINT `FK_grc_evento_insumo_3` FOREIGN KEY (`idt_insumo_unidade`) REFERENCES `grc_insumo_unidade` (`idt`) ON DELETE RESTRICT ON UPDATE RESTRICT,
ADD CONSTRAINT `FK_grc_evento_insumo_4` FOREIGN KEY (`idt_area_suporte`) REFERENCES `db_pir`.`sca_organizacao_secao` (`idt`) ON DELETE RESTRICT ON UPDATE RESTRICT,
ADD CONSTRAINT `FK_grc_evento_insumo_5` FOREIGN KEY (`idt_profissional`) REFERENCES `db_pir_gec`.`gec_profissional` (`idt`) ON DELETE RESTRICT ON UPDATE RESTRICT,
ADD CONSTRAINT `FK_grc_pevento_insumo` FOREIGN KEY (`idt_evento`) REFERENCES `grc_evento` (`idt`) ON DELETE RESTRICT ON UPDATE RESTRICT,
ADD CONSTRAINT `FK_grc_evento_insumo_6` FOREIGN KEY (`idt_ordem_contratacao`) REFERENCES `db_pir_gec`.`gec_contratacao_credenciado_ordem` (`idt`) ON DELETE RESTRICT ON UPDATE RESTRICT;

-- 06/07/2016

ALTER TABLE db_pir.plu_log_sistema MODIFY COLUMN `ip_usuario`  varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL;
ALTER TABLE db_pir_bia.plu_log_sistema MODIFY COLUMN `ip_usuario`  varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL;
ALTER TABLE db_pir_gec.plu_log_sistema MODIFY COLUMN `ip_usuario`  varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL;
ALTER TABLE db_pir_gfi.plu_log_sistema MODIFY COLUMN `ip_usuario`  varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL;
ALTER TABLE db_pir_grc.plu_log_sistema MODIFY COLUMN `ip_usuario`  varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL;
ALTER TABLE db_sebrae_pfo.plu_log_sistema MODIFY COLUMN `ip_usuario`  varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL;
ALTER TABLE db_pir_gin.plu_log_sistema MODIFY COLUMN `ip_usuario`  varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL;
ALTER TABLE db_pir_pa.plu_log_sistema MODIFY COLUMN `ip_usuario`  varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL;

ALTER TABLE db_pir.plu_erro_log MODIFY COLUMN `ip_usuario`  varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL;
ALTER TABLE db_pir_bia.plu_erro_log MODIFY COLUMN `ip_usuario`  varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL;
ALTER TABLE db_pir_gec.plu_erro_log MODIFY COLUMN `ip_usuario`  varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL;
ALTER TABLE db_pir_gfi.plu_erro_log MODIFY COLUMN `ip_usuario`  varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL;
ALTER TABLE db_pir_grc.plu_erro_log MODIFY COLUMN `ip_usuario`  varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL;
ALTER TABLE db_sebrae_pfo.plu_erro_log MODIFY COLUMN `ip_usuario`  varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL;
ALTER TABLE db_pir_gin.plu_erro_log MODIFY COLUMN `ip_usuario`  varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL;
ALTER TABLE db_pir_pa.plu_erro_log MODIFY COLUMN `ip_usuario`  varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL;

delete from grc_produto_area_conhecimento
where idt_area not in (
	select idt from db_pir_gec.gec_area_conhecimento
);

ALTER TABLE `grc_produto_area_conhecimento` ADD CONSTRAINT `FK_grc_produto_area_conhecimento_2` FOREIGN KEY (`idt_area`) REFERENCES `db_pir_gec`.`gec_area_conhecimento` (`idt`) ON DELETE RESTRICT ON UPDATE RESTRICT;


-- 07/07/2016

update grc_atendimento set nan_status = 1 where nan_status = 'V1';

ALTER TABLE `grc_atendimento`
CHANGE COLUMN `nan_status` `nan_num_visita`  int(10) UNSIGNED NULL DEFAULT NULL AFTER `idt_grupo_atendimento`;

ALTER TABLE `grc_nan_grupo_atendimento` DROP FOREIGN KEY `fk_grc_nan_grupo_atendimento_2`;

ALTER TABLE `grc_nan_grupo_atendimento`
MODIFY COLUMN `idt_organizacao`  int(10) UNSIGNED NULL DEFAULT NULL AFTER `idt`,
CHANGE COLUMN `num_visita` `num_visita_atu`  int(10) UNSIGNED NOT NULL AFTER `idt_organizacao`,
CHANGE COLUMN `dt_primeira_visita` `dt_registro_1`  timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `num_visita_atu`,
CHANGE COLUMN `idt_pessoa` `idt_pessoa_1`  int(10) UNSIGNED NULL DEFAULT NULL AFTER `dt_registro_1`,
CHANGE COLUMN `status` `status_1`  char(2) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL AFTER `idt_pessoa_1`,
ADD COLUMN `dt_registro_2`  datetime NULL AFTER `status_1`,
ADD COLUMN `idt_pessoa_2`  int(10) UNSIGNED NULL DEFAULT NULL AFTER `dt_registro_2`,
ADD COLUMN `status_2`  char(2) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL AFTER `idt_pessoa_2`,
ADD COLUMN `dt_registro_3`  datetime NULL AFTER `status_2`,
ADD COLUMN `idt_pessoa_3`  int(10) UNSIGNED NULL DEFAULT NULL AFTER `dt_registro_3`,
ADD COLUMN `status_3`  char(2) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL AFTER `idt_pessoa_3`,
DROP INDEX `fk_grc_nan_grupo_atendimento_2` ,
ADD INDEX `fk_grc_nan_grupo_atendimento_2` (`idt_pessoa_1`) USING BTREE ;

ALTER TABLE `grc_nan_grupo_atendimento` ADD CONSTRAINT `fk_grc_nan_grupo_atendimento_2` FOREIGN KEY (`idt_pessoa_1`) REFERENCES `db_pir_gec`.`gec_entidade` (`idt`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `grc_nan_grupo_atendimento` ADD CONSTRAINT `fk_grc_nan_grupo_atendimento_3` FOREIGN KEY (`idt_pessoa_2`) REFERENCES `db_pir_gec`.`gec_entidade` (`idt`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `grc_nan_grupo_atendimento` ADD CONSTRAINT `fk_grc_nan_grupo_atendimento_4` FOREIGN KEY (`idt_pessoa_3`) REFERENCES `db_pir_gec`.`gec_entidade` (`idt`) ON DELETE RESTRICT ON UPDATE RESTRICT;

update grc_nan_grupo_atendimento ga
inner join grc_atendimento a on a.idt_grupo_atendimento = ga.idt
left outer join grc_avaliacao av on av.idt_atendimento = a.idt
set ga.status_1 = 'CD'
where ga.status_1 = 'V1'
and av.idt is null;

update grc_nan_grupo_atendimento ga
inner join grc_atendimento a on a.idt_grupo_atendimento = ga.idt
inner join grc_avaliacao av on av.idt_atendimento = a.idt
set ga.status_1 = 'DI'
where ga.status_1 = 'V1'
and (av.idt_situacao = 1 or av.idt_situacao = 2);

update grc_nan_grupo_atendimento ga
inner join grc_atendimento a on a.idt_grupo_atendimento = ga.idt
inner join grc_avaliacao av on av.idt_atendimento = a.idt
set ga.status_1 = 'AT'
where ga.status_1 = 'V1'
and av.idt_situacao > 2;

-- 08/07/2016

insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_nan_visita_2_cadastro','NAN - Segunda Visita - Cadastros PJ e PF','05.70.05','N','N', 'cadastro', 'cadastro');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_nan_visita_2_cadastro') as id_funcao
from plu_direito where cod_direito in ('con', 'alt', 'inc', 'exc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_nan_visita_2_cadastro');

insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu, abrir_sistema)
values ('grc_nan_visita_2_ap','NAN - Segunda Visita - Aprovação','05.70.06','N','N', 'listar', 'listar', null);

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_nan_visita_2_ap') as id_funcao
from plu_direito where cod_direito in ('con', 'alt');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_nan_visita_2_ap');

-- 09/07/2016

INSERT INTO `db_pir_grc`.`grc_evento_situacao` (`codigo`, `descricao`, `ativo`, `detalhe`, `situacao_etapa`, `vai_para`, `volta_para`) VALUES ('96', 'CANCELAMENTO COM ERRO', 'S', NULL, 'C', NULL, NULL);

ALTER TABLE db_pir_gec.`gec_contratacao_credenciado_ordem_rm`
ADD COLUMN `rm_cancelado`  char(1) NOT NULL DEFAULT 'N' AFTER `rm_idmov`;

INSERT INTO `db_pir_grc`.`grc_evento_situacao` (`codigo`, `descricao`, `ativo`, `detalhe`, `situacao_etapa`, `vai_para`, `volta_para`) VALUES ('97', 'APROVAÇÃO DE CANCELAMENTO', 'S', NULL, 'C', NULL, NULL);

ALTER TABLE `grc_evento`
ADD COLUMN `motivo_cancelamento`  text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL AFTER `envio_sts_entrega`,
ADD COLUMN `parecer_cancelamento`  text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL AFTER `motivo_cancelamento`;

ALTER TABLE `grc_evento`
ADD COLUMN `idt_evento_situacao_can`  int(10) UNSIGNED NULL DEFAULT NULL AFTER `parecer_cancelamento`;

ALTER TABLE `grc_evento` ADD CONSTRAINT `FK_grc_evento_28` FOREIGN KEY (`idt_evento_situacao_can`) REFERENCES `grc_evento_situacao` (`idt`) ON DELETE RESTRICT ON UPDATE RESTRICT;

INSERT INTO `db_pir_grc`.`grc_parametros` (`codigo`, `descricao`, `ativo`, `html`, `detalhe`, `classificacao`) VALUES ('grc_atendimento_pendencia_09', 'Assunto do email para novos registros de Pendência de Evento para \"APROVAÇÃO DE CANCELAMENTO\"', 'S', 'N', '[#codigo] – Solicitação de Aprovação de Cancelamento do Evento no CRM|Sebrae', '01.09');
INSERT INTO `db_pir_grc`.`grc_parametros` (`codigo`, `descricao`, `ativo`, `html`, `detalhe`, `classificacao`) VALUES ('grc_atendimento_pendencia_10', 'Mensagem do email para novos registros de Pendência de Evento para \"APROVAÇÃO DE CANCELAMENTO\"', 'S', 'S', '<p>Caro(a) #responsavel<br />\r\n<br />\r\nFoi aberta pend&ecirc;ncia de evento no CRM|Sebrae para sua an&aacute;lise e delibera&ccedil;&atilde;o.<br />\r\nInforma&ccedil;&otilde;es sobre esta pend&ecirc;ncia:<br />\r\n<br />\r\n<strong>C&oacute;digo do Evento:</strong><br />\r\n#codigo<br />\r\n<strong> T&iacute;tulo do Evento:</strong><br />\r\n#descricao<br />\r\n<strong>Data de Realiza&ccedil;&atilde;o:</strong><br />\r\n#dt_previsao_inicial #hora_inicio a #dt_previsao_fim #hora_fim<br />\r\n<strong> Local/Cidade:</strong><br />\r\n#local / #cidade<br />\r\n<strong> Previs&atilde;o Receita:</strong><br />\r\n#previsao_receita<br />\r\n<strong> Despesas:</strong><br />\r\n#previsao_despesa<br />\r\n<strong> Data de Abertura:</strong><br />\r\n#dt_previsao_inicial<br />\r\n<strong> Criador:</strong><br />\r\n#solicitante<br />\r\n<strong> Respons&aacute;vel:</strong><br />\r\n#evento_responsavel<br />\r\n<br />\r\nPara respond&ecirc;-la, acesse a p&aacute;gina principal do sistema.<br />\r\n<br />\r\nCordialmente,<br />\r\n<br />\r\nEquipe gestora da Plataforma Integrada de Relacionamento<br />\r\nUnidade de Atendimento Individual - DIRAT<br />\r\nUnidade de Tecnologia da Informa&ccedil;&atilde;o e Comunica&ccedil;&atilde;o - DISUP<br />\r\nSebrae - Bahia<br />\r\n<br />\r\n<strong>IMPORTANTE:</strong> Mensagem autom&aacute;tica do sistema. N&atilde;o responda!</p>', '01.10');

-- 12/07/2016

INSERT INTO `db_pir_grc`.`grc_parametros` (`codigo`, `descricao`, `ativo`, `html`, `detalhe`, `classificacao`) VALUES ('grc_atendimento_pendencia_11', 'Assunto do email para aviso nos Evento para \"CANCELADO\"', 'S', 'N', '[#codigo] – Cancelamento do Evento no CRM|Sebrae', '01.11');
INSERT INTO `db_pir_grc`.`grc_parametros` (`codigo`, `descricao`, `ativo`, `html`, `detalhe`, `classificacao`) VALUES ('grc_atendimento_pendencia_12', 'Mensagem do email para aviso nos Evento para \"CANCELADO\"', 'S', 'S', '<p>Caro(a) #responsavel<br />\r\n<br />\r\nFoi cancelado o evento no CRM|Sebrae para sua an&aacute;lise e delibera&ccedil;&atilde;o.<br />\r\nInforma&ccedil;&otilde;es sobre esta pend&ecirc;ncia:<br />\r\n<br />\r\n<strong>C&oacute;digo do Evento:</strong><br />\r\n#codigo<br />\r\n<strong> T&iacute;tulo do Evento:</strong><br />\r\n#descricao<br />\r\n<strong>Data de Realiza&ccedil;&atilde;o:</strong><br />\r\n#dt_previsao_inicial #hora_inicio a #dt_previsao_fim #hora_fim<br />\r\n<strong> Local/Cidade:</strong><br />\r\n#local / #cidade<br />\r\n<strong> Previs&atilde;o Receita:</strong><br />\r\n#previsao_receita<br />\r\n<strong> Despesas:</strong><br />\r\n#previsao_despesa<br />\r\n<strong> Data de Abertura:</strong><br />\r\n#dt_previsao_inicial<br />\r\n<strong> Criador:</strong><br />\r\n#solicitante<br />\r\n<strong> Respons&aacute;vel:</strong><br />\r\n#evento_responsavel<br />\r\n<br />\r\nPara respond&ecirc;-la, acesse a p&aacute;gina principal do sistema.<br />\r\n<br />\r\nCordialmente,<br />\r\n<br />\r\nEquipe gestora da Plataforma Integrada de Relacionamento<br />\r\nUnidade de Atendimento Individual - DIRAT<br />\r\nUnidade de Tecnologia da Informa&ccedil;&atilde;o e Comunica&ccedil;&atilde;o - DISUP<br />\r\nSebrae - Bahia<br />\r\n<br />\r\n<strong>IMPORTANTE:</strong> Mensagem autom&aacute;tica do sistema. N&atilde;o responda!</p>', '01.12');

ALTER TABLE `plu_config`
MODIFY COLUMN `variavel`  varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL COMMENT 'VariÃ¡vel de identificaÃ§Ã£o da ConfiguraÃ§Ã£o.' AFTER `id_config`,
MODIFY COLUMN `descricao`  varchar(200) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL COMMENT 'DescriÃ§Ã£o da configuraÃ§Ã£o.' AFTER `variavel`;

INSERT INTO `plu_config` (`variavel`, `descricao`, `valor`, `extra`, `js`) VALUES ('email_canc_evento_suporte', 'e-Mail utilizado no envio das mensagens no Cancelamento do Evento para a Unidades de Suporte (separar os email com ;)', '', NULL, 'N');
INSERT INTO `plu_config` (`variavel`, `descricao`, `valor`, `extra`, `js`) VALUES ('email_canc_evento_financeiro', 'e-Mail utilizado no envio das mensagens no Cancelamento do Evento para o Financeiro (separar os email com ;)', '', NULL, 'N');

-- homologa
-- producao
-- sala