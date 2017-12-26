-- 793717365-34

-- esmeraldo

fazer bkp outra vez de homologação
executar v12.0.0 grc formulario 20160523 1023.sql

-- 25/05/2016

insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu, abrir_sistema)
values ('grc_evento_monitoramento','Monitoramento de Evento','02.03.70','N','N', 'listar', 'listar', null);

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_evento_monitoramento') as id_funcao
from plu_direito where cod_direito in ('con');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_evento_monitoramento');

-- 30/05/2016

insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu, abrir_sistema)
values ('grc_avaliacao_devolutiva_produto','NAN - Devolutivas da Avaliação Produtos','30.06.05','N','N', 'listar', 'listar', null);

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_avaliacao_devolutiva_produto') as id_funcao
from plu_direito where cod_direito in ('con', 'alt', 'inc', 'exc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_avaliacao_devolutiva_produto');

ALTER TABLE `grc_atendimento`
ADD COLUMN `nan_ap_sit_pf`  char(1) NULL AFTER `idt_nan_ordem_pagamento`,
ADD COLUMN `nan_ap_dt_pf`  datetime NULL AFTER `nan_ap_sit_pf`,
ADD COLUMN `nan_ap_sit_pj`  char(1) NULL AFTER `nan_ap_dt_pf`,
ADD COLUMN `nan_ap_dt_pj`  datetime NULL AFTER `nan_ap_sit_pj`,
ADD COLUMN `nan_ap_sit_at`  char(1) NULL AFTER `nan_ap_dt_pj`,
ADD COLUMN `nan_ap_dt_at`  datetime NULL AFTER `nan_ap_sit_at`;

-- 31/05/2016

ALTER TABLE `grc_avaliacao_secao`
DROP INDEX `iu_grc_avaliacao_secao` ,
ADD UNIQUE INDEX `iu_grc_avaliacao_secao` (`idt_avaliacao`, `idt_secao`) USING BTREE ;

ALTER TABLE `grc_avaliacao_secao` ADD CONSTRAINT `fk_grc_avaliacao_secao_1` FOREIGN KEY (`idt_formulario`) REFERENCES `grc_formulario` (`idt`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `grc_avaliacao_secao` ADD CONSTRAINT `fk_grc_avaliacao_secao_2` FOREIGN KEY (`idt_secao`) REFERENCES `grc_formulario_secao` (`idt`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `grc_avaliacao_secao` ADD CONSTRAINT `fk_grc_avaliacao_secao_3` FOREIGN KEY (`idt_avaliacao`) REFERENCES `grc_avaliacao` (`idt`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `grc_avaliacao_secao_anexo` DROP FOREIGN KEY `FK_grc_avaliacao_secao_anexo_1`;

ALTER TABLE `grc_avaliacao_secao_anexo`
DROP COLUMN `idt_avaliacao_secao`,
ADD COLUMN `idt_avaliacao`  int(10) UNSIGNED NOT NULL AFTER `idt`,
ADD COLUMN `idt_secao`  int(10) UNSIGNED NOT NULL AFTER `idt_avaliacao`,
DROP INDEX `iu_grc_avaliacao_secao_anexo`;

ALTER TABLE `grc_avaliacao_secao_anexo` ADD CONSTRAINT `FK_grc_avaliacao_secao_anexo_3` FOREIGN KEY (`idt_secao`) REFERENCES `grc_formulario_secao` (`idt`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `grc_avaliacao_secao_anexo` ADD CONSTRAINT `FK_grc_avaliacao_secao_anexo_1` FOREIGN KEY (`idt_avaliacao`) REFERENCES `grc_avaliacao` (`idt`) ON DELETE RESTRICT ON UPDATE RESTRICT;

insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu, abrir_sistema)
values ('grc_avaliacao_secao_anexo','Avaliação - Anexos da Seção','30.05.05','N','N', 'listar', 'listar', null);

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_avaliacao_secao_anexo') as id_funcao
from plu_direito where cod_direito in ('con', 'alt', 'inc', 'exc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_avaliacao_secao_anexo');

ALTER TABLE `grc_nan_estrutura_tipo`
ADD COLUMN `ordem`  int(10) NOT NULL AFTER `detalhe`;

-- 01/06/2016

-- AOE
update plu_usuario set ativo = 'S', id_perfil = 15
where id_usuario in (
	select idt_usuario from grc_nan_estrutura where idt_nan_tipo = 6
) and id_perfil = 2;

-- Tutor
update plu_usuario set ativo = 'S', id_perfil = 17
where id_usuario in (
	select idt_usuario from grc_nan_estrutura where idt_nan_tipo = 5
) and id_perfil = 2;

-- Gestor Local
update plu_usuario set ativo = 'S', id_perfil = 16
where id_usuario in (
	select idt_usuario from grc_nan_estrutura where idt_nan_tipo = 3
) and id_perfil = 2;

update plu_usuario set ativo_pir = 'S'
where id_perfil in (14, 15, 16, 17);

-- 06/06/2016

ALTER TABLE `plu_erro_log`
ADD COLUMN `vfiles`  longtext CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL AFTER `vsession`;

ALTER TABLE db_pir_siac_ba.`historicorealizacoescliente_anosanteriores`
MODIFY COLUMN `codcliente`  bigint(11) NOT NULL AFTER `codsebrae`,
MODIFY COLUMN `codempreedimento`  bigint(11) NULL DEFAULT NULL AFTER `datahorainiciorealizacao`;

-- 07/06/2016

ALTER TABLE `grc_nan_estrutura_tipo`
ADD COLUMN `wf_tipo_ant`  int(10) UNSIGNED NULL AFTER `ordem`,
ADD COLUMN `wf_tipo_prox`  int(10) UNSIGNED NULL AFTER `wf_tipo_ant`;

-- 08/06/2016

ALTER TABLE `grc_nan_parametros_projetos_publico_alvo` DROP FOREIGN KEY `FK_grc_nan_parametros_projetos_publico_alvo_1`;

ALTER TABLE `grc_nan_parametros_projetos_publico_alvo` ADD CONSTRAINT `FK_grc_nan_parametros_projetos_publico_alvo_1` FOREIGN KEY (`idt_publico_alvo`) REFERENCES `grc_publico_alvo` (`idt`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `grc_nan_parametros_projetos_publico_alvo` ADD CONSTRAINT `FK_grc_nan_parametros_projetos_publico_alvo_2` FOREIGN KEY (`idt`) REFERENCES `grc_nan_parametros_projetos` (`idt`) ON DELETE CASCADE ON UPDATE RESTRICT;

UPDATE `db_pir_grc`.`grc_nan_estrutura_tipo` SET `idt`='7', `codigo`='07', `descricao`='Empresa Credenciada', `ativo`='N', `detalhe`='Instituição  vinculadas  ao GC  responsável  pela  contratação dos AOE.', `ordem`='0', `wf_tipo_ant`=NULL, `wf_tipo_prox`=NULL WHERE (`idt`='7');
UPDATE `db_pir_grc`.`grc_nan_estrutura_tipo` SET `idt`='1', `codigo`='01', `descricao`='NAN', `ativo`='N', `detalhe`='Programa nacional de atendimento ativo negócio a negócio que tem escopo a realização  de  atendimentos  presenciais  no empreendimento  cliente  na  modalidade visita;', `ordem`='1', `wf_tipo_ant`=NULL, `wf_tipo_prox`=NULL WHERE (`idt`='1');
UPDATE `db_pir_grc`.`grc_nan_estrutura_tipo` SET `idt`='8', `codigo`='08', `descricao`='Diretor', `ativo`='S', `detalhe`=NULL, `ordem`='2', `wf_tipo_ant`='9', `wf_tipo_prox`=NULL WHERE (`idt`='8');
UPDATE `db_pir_grc`.`grc_nan_estrutura_tipo` SET `idt`='9', `codigo`='09', `descricao`='Gerente Estadual', `ativo`='S', `detalhe`=NULL, `ordem`='3', `wf_tipo_ant`='2', `wf_tipo_prox`='8' WHERE (`idt`='9');
UPDATE `db_pir_grc`.`grc_nan_estrutura_tipo` SET `idt`='2', `codigo`='02', `descricao`='Gestor Estadual', `ativo`='S', `detalhe`='Colaborador do Sebrae Bahia, lotado na UAIN, responsável estadual pela aplicação da metodologia do projeto e interlocução com o Sebrae Nacional;', `ordem`='4', `wf_tipo_ant`='4', `wf_tipo_prox`='9' WHERE (`idt`='2');
UPDATE `db_pir_grc`.`grc_nan_estrutura_tipo` SET `idt`='4', `codigo`='04', `descricao`='Tutor Sênior', `ativo`='S', `detalhe`='Credenciado  responsável  pelo  suporte  estadual  do  projeto.  Atua próximo a  gestão estadual  do  projeto, porém  também  é  interface  de  relacionamento com os tutores e gestores locais;', `ordem`='5', `wf_tipo_ant`='3', `wf_tipo_prox`='2' WHERE (`idt`='4');
UPDATE `db_pir_grc`.`grc_nan_estrutura_tipo` SET `idt`='3', `codigo`='03', `descricao`='Gestor Local', `ativo`='S', `detalhe`='Colaborador   do   Sebrae   Bahia,   lotado   nas   unidades   regionais, responsável  local  pela  aplicação  da  metodologia  do  projeto  e  acompanhamento  das atividades de campo dos agentes;', `ordem`='6', `wf_tipo_ant`=NULL, `wf_tipo_prox`='4' WHERE (`idt`='3');
UPDATE `db_pir_grc`.`grc_nan_estrutura_tipo` SET `idt`='5', `codigo`='05', `descricao`='Tutor', `ativo`='S', `detalhe`='Colaborador  ou  credenciado  responsável  pelo  acompanhamento  direto  das atividades  de  campo  dos  agentes.  A  ele  será atribuído  o  papel  de  validador  dos atendimentos  realizados (processos  de  conferência  e  auditoria)  no CRM|Sebrae e liberação das etapas do processo de atendimento;', `ordem`='7', `wf_tipo_ant`=NULL, `wf_tipo_prox`=NULL WHERE (`idt`='5');
UPDATE `db_pir_grc`.`grc_nan_estrutura_tipo` SET `idt`='6', `codigo`='06', `descricao`='AOE', `ativo`='S', `detalhe`='Agente de orientação  empresarial  vinculados  ao  Sebrae  Bahia  por  meio  de empresas credenciadas ao SGC para  atuação em campo – realização de visitas segundo metodologia do projeto e registro de atendimentos no CRM|Sebrae\r\nEle é remunerado segundo sua produtividade;', `ordem`='8', `wf_tipo_ant`=NULL, `wf_tipo_prox`=NULL WHERE (`idt`='6');

ALTER TABLE `grc_atendimento_pendencia`
MODIFY COLUMN `idt_evento`  int(10) UNSIGNED NULL DEFAULT NULL AFTER `idt`,
ADD COLUMN `idt_nan_ordem_pagamento`  int(10) UNSIGNED NULL AFTER `idt`;

ALTER TABLE `grc_atendimento_pendencia` ADD CONSTRAINT `FK_grc_atendimento_pendencia_10` FOREIGN KEY (`idt_nan_ordem_pagamento`) REFERENCES `grc_nan_ordem_pagamento` (`idt`) ON DELETE RESTRICT ON UPDATE RESTRICT;

-- 09/06/2016

UPDATE `plu_funcao` SET `abrir_sistema`= NULL WHERE cod_funcao = 'gec_area_conhecimento';

-- 10/06/2016

ALTER TABLE `grc_nan_ordem_pagamento`
ADD COLUMN `rm_idmov`  int(10) UNSIGNED NULL AFTER `acao_nan`;

INSERT INTO `db_pir_grc`.`grc_parametros` (`codigo`, `descricao`, `ativo`, `html`, `detalhe`, `classificacao`) VALUES ('grc_nan_ordem_pagamento_01', 'Assunto do email para novos registros da Ordem de Pagamento no RM', 'S', 'N', 'Novos registros da Ordem de Pagamento no RM', '03.01');
INSERT INTO `db_pir_grc`.`grc_parametros` (`codigo`, `descricao`, `ativo`, `html`, `detalhe`, `classificacao`) VALUES ('grc_nan_ordem_pagamento_02', 'Mensagem do email para novos registros da Ordem de Pagamento no RM', 'S', 'S', 'protocolo: #protocolo<br/>data: #data<br/>ordem_pagamento: #ordem_pagamento<br/>contrato: #contrato<br/>data_inicio: #data_inicio<br/>data_fim: #data_fim<br/>observacao: #observacao<br/>qtd_total_visitas: #qtd_total_visitas<br/>qtd_visitas1: #qtd_visitas1<br/>qtd_visitas2: #qtd_visitas2<br/>valor_total: #valor_total', '03.02');

UPDATE `db_pir_grc`.`grc_parametros` SET `idt`='13', `codigo`='grc_nan_ordem_pagamento_02', `descricao`='Mensagem do email para novos registros da Ordem de Pagamento no RM', `ativo`='S', `html`='S', `detalhe`='protocolo: #protocolo<br/>data: #data<br/>ordem_pagamento: #ordem_pagamento<br/>contrato: #contrato<br/>data_inicio: #inicio_data<br/>data_fim: #fim_data<br/>observacao: #observacao<br/>qtd_total_visitas: #qtd_total_visitas<br/>qtd_visitas1: #qtd_visitas1<br/>qtd_visitas2: #qtd_visitas2<br/>valor_total: #valor_total', `classificacao`='03.02' WHERE (`idt`='13');

ALTER TABLE `grc_nan_estrutura_tipo`
DROP COLUMN `wf_tipo_ant`,
DROP COLUMN `wf_tipo_prox`;

ALTER TABLE `grc_nan_estrutura_tipo`
ADD COLUMN `aprova_ordem`  char(1) NOT NULL DEFAULT 'N' AFTER `ordem`;

UPDATE `db_pir_grc`.`grc_nan_estrutura_tipo` SET `idt`='7', `codigo`='07', `descricao`='Empresa  Credenciada', `ativo`='N', `detalhe`='Instituição  vinculadas  ao GC  responsável  pela  contratação dos AOE.', `ordem`='0', `aprova_ordem`='N' WHERE (`idt`='7');
UPDATE `db_pir_grc`.`grc_nan_estrutura_tipo` SET `idt`='1', `codigo`='01', `descricao`='NAN', `ativo`='N', `detalhe`='Programa nacional de atendimento ativo negócio a negócio que tem escopo a realização  de  atendimentos  presenciais  no empreendimento  cliente  na  modalidade visita;', `ordem`='1', `aprova_ordem`='N' WHERE (`idt`='1');
UPDATE `db_pir_grc`.`grc_nan_estrutura_tipo` SET `idt`='8', `codigo`='08', `descricao`='Diretor', `ativo`='S', `detalhe`=NULL, `ordem`='2', `aprova_ordem`='S' WHERE (`idt`='8');
UPDATE `db_pir_grc`.`grc_nan_estrutura_tipo` SET `idt`='9', `codigo`='09', `descricao`='Gerente Estadual', `ativo`='S', `detalhe`=NULL, `ordem`='3', `aprova_ordem`='N' WHERE (`idt`='9');
UPDATE `db_pir_grc`.`grc_nan_estrutura_tipo` SET `idt`='2', `codigo`='02', `descricao`='Gestor Estadual', `ativo`='S', `detalhe`='Colaborador do Sebrae Bahia, lotado na UAIN, responsável estadual pela aplicação da metodologia do projeto e interlocução com o Sebrae Nacional;', `ordem`='4', `aprova_ordem`='N' WHERE (`idt`='2');
UPDATE `db_pir_grc`.`grc_nan_estrutura_tipo` SET `idt`='4', `codigo`='04', `descricao`='Tutor Sênior', `ativo`='S', `detalhe`='Credenciado  responsável  pelo  suporte  estadual  do  projeto.  Atua próximo a  gestão estadual  do  projeto, porém  também  é  interface  de  relacionamento com os tutores e gestores locais;', `ordem`='5', `aprova_ordem`='N' WHERE (`idt`='4');
UPDATE `db_pir_grc`.`grc_nan_estrutura_tipo` SET `idt`='10', `codigo`='10', `descricao`='Gerente Regional', `ativo`='S', `detalhe`=NULL, `ordem`='6', `aprova_ordem`='S' WHERE (`idt`='10');
UPDATE `db_pir_grc`.`grc_nan_estrutura_tipo` SET `idt`='3', `codigo`='03', `descricao`='Gestor Local', `ativo`='S', `detalhe`='Colaborador   do   Sebrae   Bahia,   lotado   nas   unidades   regionais, responsável  local  pela  aplicação  da  metodologia  do  projeto  e  acompanhamento  das atividades de campo dos agentes;', `ordem`='7', `aprova_ordem`='S' WHERE (`idt`='3');
UPDATE `db_pir_grc`.`grc_nan_estrutura_tipo` SET `idt`='5', `codigo`='05', `descricao`='Tutor', `ativo`='S', `detalhe`='Colaborador  ou  credenciado  responsável  pelo  acompanhamento  direto  das atividades  de  campo  dos  agentes.  A  ele  será atribuído  o  papel  de  validador  dos atendimentos  realizados (processos  de  conferência  e  auditoria)  no CRM|Sebrae e liberação das etapas do processo de atendimento;', `ordem`='8', `aprova_ordem`='N' WHERE (`idt`='5');
UPDATE `db_pir_grc`.`grc_nan_estrutura_tipo` SET `idt`='6', `codigo`='06', `descricao`='AOE', `ativo`='S', `detalhe`='Agente de orientação  empresarial  vinculados  ao  Sebrae  Bahia  por  meio  de empresas credenciadas ao SGC para  atuação em campo – realização de visitas segundo metodologia do projeto e registro de atendimentos no CRM|Sebrae\r\nEle é remunerado segundo sua produtividade;', `ordem`='9', `aprova_ordem`='N' WHERE (`idt`='6');

ALTER TABLE `grc_nan_estrutura`
ADD COLUMN `vl_aprova_ordem`  decimal(15,2) UNSIGNED NULL AFTER `idt_empresa_executora`;

-- 11/06/2016

UPDATE `grc_insumo` SET `descricao`='DESPESAS COM PROFISSIONAIS GC', `detalhe`='DESPESAS COM PROFISSIONAIS GC' WHERE (`codigo`='70000');

INSERT INTO `db_pir_grc`.`grc_insumo` (`codigo`, `descricao`, `ativo`, `detalhe`, `classificacao`, `idt_insumo_elemento_custo`, `idt_insumo_unidade`, `custo_unitario_real`, `por_participante`, `nivel`, `sinal`, `codigo_rm`, `tipo`, `idprd`, `evento_insc_receita`, `idt_area_suporte`, `rm_classificacao`, `estocavel`, `sebprodcrm`) VALUES ('71000', 'DESPESA COM PROFISSIONAIS SGTEC', 'S', 'DESPESAS COM PROFISSIONAIS SGTEC', '71', NULL, NULL, NULL, NULL, 'N', 'S', NULL, 'S', NULL, 'N', NULL, NULL, 'N', NULL);
INSERT INTO `db_pir_grc`.`grc_insumo` (`codigo`, `descricao`, `ativo`, `detalhe`, `classificacao`, `idt_insumo_elemento_custo`, `idt_insumo_unidade`, `custo_unitario_real`, `por_participante`, `nivel`, `sinal`, `codigo_rm`, `tipo`, `idprd`, `evento_insc_receita`, `idt_area_suporte`, `rm_classificacao`, `estocavel`, `sebprodcrm`) VALUES ('71001', 'COTAÇÃO', 'S', NULL, '71.01', NULL, '1', NULL, 'N', 'S', 'S', NULL, 'S', NULL, 'N', NULL, NULL, 'N', NULL);

-- 14/06/2016

update grc_nan_estrutura set idt_tutor = null where idt_nan_tipo = 3;

ALTER TABLE `grc_nan_ordem_pagamento`
MODIFY COLUMN `situacao`  varchar(3) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'GE' AFTER `qtd_visitas2`;

-- 16/06/2016

ALTER TABLE `grc_nan_ordem_pagamento` DROP FOREIGN KEY `FK_grc_nan_ordem_pagamento_1`;

ALTER TABLE `grc_nan_ordem_pagamento`
ADD COLUMN `idt_aprova_ordem`  int(11) NULL AFTER `rm_idmov`,
ADD COLUMN `data_aprova_ordem`  datetime NULL AFTER `idt_aprova_ordem`;

ALTER TABLE `grc_nan_ordem_pagamento` ADD CONSTRAINT `FK_grc_nan_ordem_pagamento_1` FOREIGN KEY (`idt_cadastrante`) REFERENCES `plu_usuario` (`id_usuario`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `grc_nan_ordem_pagamento` ADD CONSTRAINT `FK_grc_nan_ordem_pagamento_2` FOREIGN KEY (`idt_aprova_ordem`) REFERENCES `plu_usuario` (`id_usuario`) ON DELETE RESTRICT ON UPDATE RESTRICT;

-- 17/06/2016

ALTER TABLE `grc_nan_ordem_pagamento`
ADD COLUMN `pdf_aprova_ordem`  varchar(255) NULL AFTER `data_aprova_ordem`;

ALTER TABLE `grc_nan_ordem_pagamento`
MODIFY COLUMN `acao_nan`  varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL AFTER `situacao`;

-- INSERT INTO `db_pir_grc`.`plu_config` (`variavel`, `descricao`, `valor`, `extra`, `js`) VALUES ('helpdesk_solicitacao', 'e-Mail utilizado na Solicitação do HelpDesk (separar os email com ;)', 'servicedesk@servico.sebraeba.com.br', NULL, 'N');

-- producao
-- homologa
-- sala