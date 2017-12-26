-- 19/02/2016

ALTER TABLE grc_evento_participante_pagamento
MODIFY COLUMN origem_reg  varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'PIR' AFTER estornar_rm;

-- 20/02/2016

ALTER TABLE grc_evento
ADD COLUMN mesanocompetencia  datetime NULL AFTER custo_tot_consultoria;

ALTER TABLE grc_evento
ADD COLUMN idt_evento_situacao_ant  int(10) UNSIGNED NULL AFTER idt_evento_situacao;

ALTER TABLE grc_evento ADD CONSTRAINT FK_grc_evento_25 FOREIGN KEY (idt_evento_situacao_ant) REFERENCES grc_evento_situacao (idt) ON DELETE RESTRICT ON UPDATE CASCADE;

ALTER TABLE grc_evento
ADD COLUMN qtd_matriculado_siacweb  int(10) UNSIGNED NOT NULL DEFAULT 0 AFTER mesanocompetencia,
ADD COLUMN qtd_vagas_resevado  int(10) UNSIGNED NOT NULL DEFAULT 0 AFTER qtd_matriculado_siacweb,
ADD COLUMN qtd_vagas_bloqueadas  int(10) UNSIGNED NOT NULL DEFAULT 0 AFTER qtd_vagas_resevado;

-- 22/02/2016

ALTER TABLE grc_evento_participante
MODIFY COLUMN contrato  varchar(2) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT 'R' AFTER idt_atendimento;

-- 23/02/2016

ALTER TABLE grc_evento
MODIFY COLUMN qtd_matriculado_siacweb  int(10) NOT NULL DEFAULT 0 AFTER mesanocompetencia,
MODIFY COLUMN qtd_vagas_resevado  int(10) NOT NULL DEFAULT 0 AFTER qtd_matriculado_siacweb,
MODIFY COLUMN qtd_vagas_bloqueadas  int(10) NOT NULL DEFAULT 0 AFTER qtd_vagas_resevado;

-- 26/02/2016

UPDATE grc_parametros SET descricao='Assunto do email para novos registros de Pendência de Atendimento' WHERE (idt='1');
UPDATE grc_parametros SET descricao='Mensagem do email para novos registros de Pendência de Atendimento' WHERE (idt='2');
UPDATE grc_parametros SET descricao='Assunto do email para novos registros de Pendência de Evento para \"EM TRAMITAÇÃO\"' WHERE (idt='3');
UPDATE grc_parametros SET descricao='Mensagem do email para novos registros de Pendência de Evento para \"EM TRAMITAÇÃO\"' WHERE (idt='4');
UPDATE grc_parametros SET descricao='Assunto do email para novos registros de Pendência de Evento para \"DEVOLVIDO\"' WHERE (idt='5');
UPDATE grc_parametros SET descricao='Mensagem do email para novos registros de Pendência de Evento  para \"DEVOLVIDO\"' WHERE (idt='6');
UPDATE grc_parametros SET descricao='Assunto do email para novos registros de Pendência de Evento para \"AGENDADO\"' WHERE (idt='7');
UPDATE grc_parametros SET descricao='Mensagem do email para novos registros de Pendência de Evento para \"AGENDADO\"' WHERE (idt='8');

UPDATE grc_parametros SET detalhe='<p>Caro(a) #responsavel<br />\r\n<br />\r\nFoi aberta pend&ecirc;ncia de evento no CRM|Sebrae para sua an&aacute;lise e delibera&ccedil;&atilde;o.<br />\r\nInforma&ccedil;&otilde;es sobre esta pend&ecirc;ncia:<br />\r\n<br />\r\n<strong>C&oacute;digo do Evento:</strong><br />\r\n#codigo<br />\r\n<strong> T&iacute;tulo do Evento:</strong><br />\r\n#descricao<br />\r\n<strong>Data de Realiza&ccedil;&atilde;o:</strong><br />\r\n#dt_previsao_inicial #hora_inicio a #dt_previsao_fim #hora_fim<br />\r\n<strong> Local/Cidade:</strong><br />\r\n#local / #cidade<br />\r\n<strong> Previs&atilde;o Receita:</strong><br />\r\n#previsao_receita<br />\r\n<strong> Despesas:</strong><br />\r\n#previsao_despesa<br />\r\n<strong> Data de Abertura:</strong><br />\r\n#dt_previsao_inicial<br />\r\n<strong> Criador:</strong><br />\r\n#solicitante<br />\r\n<strong> Respons&aacute;vel:</strong><br />\r\n#evento_responsavel<br />\r\n<br />\r\nPara respond&ecirc;-la, acesse a p&aacute;gina principal do sistema.<br />\r\n<br />\r\nCordialmente,<br />\r\n<br />\r\nEquipe gestora da Plataforma Integrada de Relacionamento<br />\r\nUnidade de Atendimento Individual - DIRAT<br />\r\nUnidade de Tecnologia da Informa&ccedil;&atilde;o e Comunica&ccedil;&atilde;o - DISUP<br />\r\nSebrae - Bahia<br />\r\n<br />\r\n<strong>IMPORTANTE:</strong> Mensagem autom&aacute;tica do sistema. N&atilde;o responda!</p>' WHERE (idt='4');

UPDATE grc_produto_maturidade SET descricao='Inicial', ativo='S' WHERE (idt='1');
UPDATE grc_produto_maturidade SET descricao='Intermediária', ativo='S' WHERE (idt='2');
UPDATE grc_produto_maturidade SET descricao='Avançada', ativo='S' WHERE (idt='3');
UPDATE grc_produto_maturidade SET descricao='N/A', ativo='N' WHERE (idt='4');

INSERT INTO grc_produto_maturidade (codigo, descricao, ativo, detalhe) VALUES ('4', 'Todos', 'S', NULL);

ALTER TABLE grc_produto
CHANGE COLUMN carga_horaria_num carga_horaria_ini  decimal(15,2) NULL DEFAULT NULL AFTER carga_horaria,
MODIFY COLUMN carga_horaria_2  varchar(4000) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL AFTER carga_horaria_ini,
CHANGE COLUMN carga_horaria_2_num carga_horaria_2_ini  decimal(15,2) NULL DEFAULT NULL AFTER carga_horaria_2,
ADD COLUMN carga_horaria_fim  decimal(15,2) NULL AFTER carga_horaria_ini,
ADD COLUMN carga_horaria_2_fim  decimal(15,2) NULL AFTER carga_horaria_2_ini;

ALTER TABLE grc_produto
MODIFY COLUMN carga_horaria  varchar(4000) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL COMMENT 'Instrutoria' AFTER complemento,
MODIFY COLUMN carga_horaria_ini  decimal(15,2) NULL DEFAULT NULL COMMENT 'Instrutoria' AFTER carga_horaria,
MODIFY COLUMN carga_horaria_fim  decimal(15,2) NULL DEFAULT NULL COMMENT 'Instrutoria' AFTER carga_horaria_ini,
MODIFY COLUMN carga_horaria_2  varchar(4000) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL COMMENT 'Consultoria' AFTER carga_horaria_fim,
MODIFY COLUMN carga_horaria_2_ini  decimal(15,2) NULL DEFAULT NULL COMMENT 'Consultoria' AFTER carga_horaria_2,
MODIFY COLUMN carga_horaria_2_fim  decimal(15,2) NULL DEFAULT NULL COMMENT 'Consultoria' AFTER carga_horaria_2_ini;

update grc_produto set carga_horaria_fim = carga_horaria_ini, carga_horaria_2_fim = carga_horaria_2_ini;

-- 29/02/2016

cadastrar novo instrumento no painel 90.05 - Presencial

INSERT INTO `db_pir_grc`.`grc_atendimento_instrumento` (`idt`, `codigo`, `codigo_siacweb`, `codigo_sge`, `codigo_familia_siac`, `codigo_tipoevento_siac`, `nivel`, `descricao`, `descricao_siacweb`, `ativo`, `detalhe`, `idt_atendimento_instrumento`, `balcao`) VALUES ('50', 'CT', NULL, NULL, '10002', '13', '1', 'Consultoria Tecnológica', 'Consultoria Tecnológica', 'S', NULL, NULL, 'N');

UPDATE `grc_atendimento_instrumento` SET `descricao_siacweb`='Consultoria Presencial' WHERE (`idt`='50');
UPDATE `grc_atendimento_instrumento` SET `codigo_sge`='02' WHERE (`idt`='50');

-- 02/03/2016

ALTER TABLE `grc_evento_agenda`
ADD COLUMN `siacweb_codatividade`  int(10) NULL AFTER `alocacao_msg`;

ALTER TABLE `grc_evento_agenda` ADD CONSTRAINT `fk_grc_evento_agenda_4` FOREIGN KEY (`idt_tema`) REFERENCES `grc_tema_subtema` (`idt`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `grc_evento_agenda` ADD CONSTRAINT `fk_grc_evento_agenda_5` FOREIGN KEY (`idt_subtema`) REFERENCES `grc_tema_subtema` (`idt`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `grc_atendimento_pessoa`
ADD COLUMN `siacweb_codparticipantecosultoria`  int(10) NULL AFTER `codigo_siacweb`;

-- 04/03/2016

UPDATE `db_pir_gec`.`gec_entidade_tipo_informacao` SET `codigo`= codigo + 100;

UPDATE `db_pir_gec`.`gec_entidade_tipo_informacao` SET `codigo`='4' WHERE (`idt`='1');
UPDATE `db_pir_gec`.`gec_entidade_tipo_informacao` SET `codigo`='2' WHERE (`idt`='2');
UPDATE `db_pir_gec`.`gec_entidade_tipo_informacao` SET `codigo`='1' WHERE (`idt`='3');
UPDATE `db_pir_gec`.`gec_entidade_tipo_informacao` SET `codigo`='3' WHERE (`idt`='4');

ALTER TABLE `plu_perfil`
ADD COLUMN `mostra_pk`  char(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'N' AFTER `atendimento_digitador`;

-- sala
-- homologa
-- producao
-- esmeraldo
