-- esmeraldo

-- 26/04/2016

ALTER TABLE db_pir_siac_ba.parceiro MODIFY COLUMN codparceiro bigint(15) UNSIGNED NOT NULL;
ALTER TABLE db_pir_siac_ba.comunicacao MODIFY COLUMN codparceiro bigint(15) UNSIGNED NOT NULL;
ALTER TABLE db_pir_siac_ba.endereco MODIFY COLUMN codparceiro bigint(15) UNSIGNED NOT NULL;
ALTER TABLE db_pir_siac_ba.ativeconpj MODIFY COLUMN codparceiro bigint(15) UNSIGNED NOT NULL;
ALTER TABLE db_pir_siac_ba.pessoaf MODIFY COLUMN codparceiro bigint(15) UNSIGNED NOT NULL;
ALTER TABLE db_pir_siac_ba.pessoaj MODIFY COLUMN codparceiro bigint(15) UNSIGNED NOT NULL;
ALTER TABLE db_pir_siac_ba.contato MODIFY COLUMN codcontatopf bigint(15) UNSIGNED NOT NULL, MODIFY COLUMN codcontatopj bigint(15) UNSIGNED NOT NULL;
ALTER TABLE db_pir_siac_ba.historicorealizacoescliente MODIFY COLUMN codcliente bigint(15) UNSIGNED NOT NULL, MODIFY COLUMN codempreedimento bigint(15) UNSIGNED NULL DEFAULT NULL;

-- 03/05/2016

ALTER TABLE `grc_atendimento_pendencia` DROP FOREIGN KEY `FK_grc_atendimento_pendencia_1`;

ALTER TABLE `grc_atendimento_pendencia` DROP FOREIGN KEY `FK_grc_atendimento_pendencia_2`;

ALTER TABLE `grc_atendimento_pendencia` DROP FOREIGN KEY `FK_grc_atendimento_pendencia_3`;

ALTER TABLE `grc_atendimento_pendencia` DROP FOREIGN KEY `FK_grc_atendimento_pendencia_4`;

ALTER TABLE `grc_atendimento_pendencia` DROP FOREIGN KEY `FK_grc_atendimento_pendencia_5`;

ALTER TABLE `grc_atendimento_pendencia` DROP FOREIGN KEY `FK_grc_atendimento_pendencia_6`;

ALTER TABLE `grc_atendimento_pendencia`
ADD COLUMN `idt_pfo_af_processo`  int(10) UNSIGNED NULL AFTER `idt_evento_situacao_para`;

ALTER TABLE `grc_atendimento_pendencia` ADD CONSTRAINT `FK_grc_atendimento_pendencia_1` FOREIGN KEY (`idt_atendimento`) REFERENCES `grc_atendimento` (`idt`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `grc_atendimento_pendencia` ADD CONSTRAINT `FK_grc_atendimento_pendencia_2` FOREIGN KEY (`idt_usuario`) REFERENCES `plu_usuario` (`id_usuario`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `grc_atendimento_pendencia` ADD CONSTRAINT `FK_grc_atendimento_pendencia_3` FOREIGN KEY (`idt_responsavel_solucao`) REFERENCES `plu_usuario` (`id_usuario`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `grc_atendimento_pendencia` ADD CONSTRAINT `FK_grc_atendimento_pendencia_4` FOREIGN KEY (`idt_gestor_local`) REFERENCES `plu_usuario` (`id_usuario`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `grc_atendimento_pendencia` ADD CONSTRAINT `FK_grc_atendimento_pendencia_5` FOREIGN KEY (`idt_evento`) REFERENCES `grc_evento` (`idt`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `grc_atendimento_pendencia` ADD CONSTRAINT `FK_grc_atendimento_pendencia_6` FOREIGN KEY (`idt_usuario_update`) REFERENCES `plu_usuario` (`id_usuario`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `grc_atendimento_pendencia` ADD CONSTRAINT `FK_grc_atendimento_pendencia_9` FOREIGN KEY (`idt_pfo_af_processo`) REFERENCES `db_sebrae_pfo`.`pfo_af_processo` (`idt`) ON DELETE RESTRICT ON UPDATE RESTRICT;

-- 04/05/2016

insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu, abrir_sistema)
values ('pfo_af_processo_item','Atestado em Processo de Pagamento','02.03.65','N','N', 'listar', 'listar', 'PFO');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'pfo_af_processo_item') as id_funcao
from plu_direito where cod_direito in ('con');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('pfo_af_processo_item');

-- 06/05/2016

ALTER TABLE db_pir_siac_ba.pessoaj
MODIFY COLUMN `codconst`  smallint(6) NULL AFTER `codsetor`,
MODIFY COLUMN `faturam`  smallint(6) NULL AFTER `capsocial`;

-- 09/05/2016

ALTER TABLE `grc_avaliacao`
ADD COLUMN `idt_pfo_af_processo`  int(10) UNSIGNED NULL AFTER `grupo`;

ALTER TABLE `grc_avaliacao` ADD CONSTRAINT `FK_grc_avaliacao_9` FOREIGN KEY (`idt_pfo_af_processo`) REFERENCES `db_sebrae_pfo`.`pfo_af_processo` (`idt`) ON DELETE RESTRICT ON UPDATE RESTRICT;

CREATE TABLE `grc_evento_portal` (
  `idt` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idt_evento` int(10) unsigned NOT NULL,
  `banner_imagem` varchar(255) DEFAULT NULL,
  `titulo` varchar(120) DEFAULT NULL,
  `resumo` text,
  `apresentacaohtml` text,
  `idt_responsavel_registro` int(10) unsigned DEFAULT NULL,
  `data_cadastro` datetime DEFAULT NULL,
  `imagem_width` decimal(15,7) DEFAULT NULL,
  `imagem_height` decimal(15,2) DEFAULT NULL,
  `link` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`idt`),
  UNIQUE KEY `iu_grc_evento_portal` (`idt_evento`),
  CONSTRAINT `FK_grc_evento_portal_1` FOREIGN KEY (`idt_evento`) REFERENCES `grc_evento` (`idt`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `db_pir_grc`.`plu_painel` (`idt`, `codigo`, `classificacao`, `descricao`) VALUES ('39', 'grc_nan_parametros_projeto', '90.08.03', 'NAN - Funcionalidades Administrativas');

INSERT INTO `db_pir_grc`.`plu_painel_grupo` (`idt`, `idt_painel`, `codigo`, `ordem`, `descricao`, `hint`, `tit_mostrar`, `tit_bt_fecha`, `tit_font_tam`, `tit_font_cor`, `tit_fundo`, `mostra_item`, `texto_altura`, `texto_font_tam`, `texto_ativ_font_cor`, `texto_ativ_fundo`, `texto_desativ_font_cor`, `texto_desativ_fundo`, `move_item`, `passo`, `passo_tit`, `layout_grid`, `img_altura`, `img_largura`, `img_margem_dir`, `img_margem_esq`, `espaco_linha`, `painel_altura`, `painel_largura`) VALUES ('52', '39', '1', '1', 'Cadastros Administrativos', NULL, 'S', 'A', NULL, NULL, NULL, 'IT', '30', NULL, NULL, NULL, NULL, NULL, 'S', 'N', 'N', 'S', '70', '100', '15', '15', '10', '110', '910');
INSERT INTO `db_pir_grc`.`plu_painel_grupo` (`idt`, `idt_painel`, `codigo`, `ordem`, `descricao`, `hint`, `tit_mostrar`, `tit_bt_fecha`, `tit_font_tam`, `tit_font_cor`, `tit_fundo`, `mostra_item`, `texto_altura`, `texto_font_tam`, `texto_ativ_font_cor`, `texto_ativ_fundo`, `texto_desativ_font_cor`, `texto_desativ_fundo`, `move_item`, `passo`, `passo_tit`, `layout_grid`, `img_altura`, `img_largura`, `img_margem_dir`, `img_margem_esq`, `espaco_linha`, `painel_altura`, `painel_largura`) VALUES ('53', '39', '2', '2', 'Tabelas de Apoio', NULL, 'S', 'A', NULL, NULL, NULL, 'IT', '30', NULL, NULL, NULL, NULL, NULL, 'S', 'N', 'N', 'S', '70', '100', '15', '15', '15', '0', '0');
INSERT INTO `db_pir_grc`.`plu_painel_grupo` (`idt`, `idt_painel`, `codigo`, `ordem`, `descricao`, `hint`, `tit_mostrar`, `tit_bt_fecha`, `tit_font_tam`, `tit_font_cor`, `tit_fundo`, `mostra_item`, `texto_altura`, `texto_font_tam`, `texto_ativ_font_cor`, `texto_ativ_fundo`, `texto_desativ_font_cor`, `texto_desativ_fundo`, `move_item`, `passo`, `passo_tit`, `layout_grid`, `img_altura`, `img_largura`, `img_margem_dir`, `img_margem_esq`, `espaco_linha`, `painel_altura`, `painel_largura`) VALUES ('54', '39', '3', '3', 'RELATÓRIOS', NULL, 'S', 'A', NULL, NULL, NULL, 'IT', '30', NULL, NULL, NULL, NULL, NULL, 'S', 'N', 'N', 'S', '70', '100', '15', '15', '15', '0', '0');

INSERT INTO `db_pir_grc`.`plu_painel_funcao` (`idt`, `idt_painel_grupo`, `id_funcao`, `pos_top`, `pos_left`, `imagem`, `imagem_d`, `texto_cab`, `detalhe`, `visivel`, `hint`, `parametros`, `texto_font_tam`, `texto_ativ_font_cor`, `texto_ativ_fundo`, `texto_desativ_font_cor`, `texto_desativ_fundo`, `include`, `include_arq`, `include_altura`, `include_largura`) VALUES ('434', '52', null, '0', '130', NULL, NULL, 'Empresas<br /> Executoras', NULL, 'S', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'N', NULL, NULL, NULL);
INSERT INTO `db_pir_grc`.`plu_painel_funcao` (`idt`, `idt_painel_grupo`, `id_funcao`, `pos_top`, `pos_left`, `imagem`, `imagem_d`, `texto_cab`, `detalhe`, `visivel`, `hint`, `parametros`, `texto_font_tam`, `texto_ativ_font_cor`, `texto_ativ_fundo`, `texto_desativ_font_cor`, `texto_desativ_fundo`, `include`, `include_arq`, `include_altura`, `include_largura`) VALUES ('435', '52', null, '0', '0', NULL, NULL, 'Parâmetros do Projeto', NULL, 'S', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'N', NULL, NULL, NULL);
INSERT INTO `db_pir_grc`.`plu_painel_funcao` (`idt`, `idt_painel_grupo`, `id_funcao`, `pos_top`, `pos_left`, `imagem`, `imagem_d`, `texto_cab`, `detalhe`, `visivel`, `hint`, `parametros`, `texto_font_tam`, `texto_ativ_font_cor`, `texto_ativ_fundo`, `texto_desativ_font_cor`, `texto_desativ_fundo`, `include`, `include_arq`, `include_altura`, `include_largura`) VALUES ('436', '52', null, '0', '390', NULL, NULL, 'Projeto e Ação', NULL, 'S', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'N', NULL, NULL, NULL);
INSERT INTO `db_pir_grc`.`plu_painel_funcao` (`idt`, `idt_painel_grupo`, `id_funcao`, `pos_top`, `pos_left`, `imagem`, `imagem_d`, `texto_cab`, `detalhe`, `visivel`, `hint`, `parametros`, `texto_font_tam`, `texto_ativ_font_cor`, `texto_ativ_fundo`, `texto_desativ_font_cor`, `texto_desativ_fundo`, `include`, `include_arq`, `include_altura`, `include_largura`) VALUES ('437', '52', null, '0', '520', NULL, NULL, 'Empresa<br /> AOE e TUTOR', NULL, 'S', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'N', NULL, NULL, NULL);
INSERT INTO `db_pir_grc`.`plu_painel_funcao` (`idt`, `idt_painel_grupo`, `id_funcao`, `pos_top`, `pos_left`, `imagem`, `imagem_d`, `texto_cab`, `detalhe`, `visivel`, `hint`, `parametros`, `texto_font_tam`, `texto_ativ_font_cor`, `texto_ativ_fundo`, `texto_desativ_font_cor`, `texto_desativ_fundo`, `include`, `include_arq`, `include_altura`, `include_largura`) VALUES ('438', '52', null, '0', '650', NULL, NULL, 'Transferir Atendimentos', NULL, 'S', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'N', NULL, NULL, NULL);
INSERT INTO `db_pir_grc`.`plu_painel_funcao` (`idt`, `idt_painel_grupo`, `id_funcao`, `pos_top`, `pos_left`, `imagem`, `imagem_d`, `texto_cab`, `detalhe`, `visivel`, `hint`, `parametros`, `texto_font_tam`, `texto_ativ_font_cor`, `texto_ativ_fundo`, `texto_desativ_font_cor`, `texto_desativ_fundo`, `include`, `include_arq`, `include_altura`, `include_largura`) VALUES ('439', '52', null, '0', '260', NULL, NULL, 'Gestão<br /> de Contratos', NULL, 'S', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'N', NULL, NULL, NULL);
INSERT INTO `db_pir_grc`.`plu_painel_funcao` (`idt`, `idt_painel_grupo`, `id_funcao`, `pos_top`, `pos_left`, `imagem`, `imagem_d`, `texto_cab`, `detalhe`, `visivel`, `hint`, `parametros`, `texto_font_tam`, `texto_ativ_font_cor`, `texto_ativ_fundo`, `texto_desativ_font_cor`, `texto_desativ_fundo`, `include`, `include_arq`, `include_altura`, `include_largura`) VALUES ('441', '53', null, '0', '0', NULL, NULL, 'Tipo de Estrutura NAN', NULL, 'S', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'N', NULL, NULL, NULL);
INSERT INTO `db_pir_grc`.`plu_painel_funcao` (`idt`, `idt_painel_grupo`, `id_funcao`, `pos_top`, `pos_left`, `imagem`, `imagem_d`, `texto_cab`, `detalhe`, `visivel`, `hint`, `parametros`, `texto_font_tam`, `texto_ativ_font_cor`, `texto_ativ_fundo`, `texto_desativ_font_cor`, `texto_desativ_fundo`, `include`, `include_arq`, `include_altura`, `include_largura`) VALUES ('442', '54', null, '0', '0', NULL, NULL, 'Lista Executoras e AOE\'s', NULL, 'S', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'N', NULL, NULL, NULL);
INSERT INTO `db_pir_grc`.`plu_painel_funcao` (`idt`, `idt_painel_grupo`, `id_funcao`, `pos_top`, `pos_left`, `imagem`, `imagem_d`, `texto_cab`, `detalhe`, `visivel`, `hint`, `parametros`, `texto_font_tam`, `texto_ativ_font_cor`, `texto_ativ_fundo`, `texto_desativ_font_cor`, `texto_desativ_fundo`, `include`, `include_arq`, `include_altura`, `include_largura`) VALUES ('443', '54', null, '0', '130', NULL, NULL, 'Relatório Analítico NAN', NULL, 'S', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'N', NULL, NULL, NULL);
INSERT INTO `db_pir_grc`.`plu_painel_funcao` (`idt`, `idt_painel_grupo`, `id_funcao`, `pos_top`, `pos_left`, `imagem`, `imagem_d`, `texto_cab`, `detalhe`, `visivel`, `hint`, `parametros`, `texto_font_tam`, `texto_ativ_font_cor`, `texto_ativ_fundo`, `texto_desativ_font_cor`, `texto_desativ_fundo`, `include`, `include_arq`, `include_altura`, `include_largura`) VALUES ('444', '54', null, '0', '260', NULL, NULL, 'Relatório Sintético NAN', NULL, 'S', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'N', NULL, NULL, NULL);

UPDATE `plu_painel_funcao` SET `id_funcao`='777' WHERE (`idt`='392');

UPDATE `plu_funcao` SET `abrir_sistema`='GEC' WHERE (`cod_funcao`='grc_nan_empresas_executoras');

-- 10/05/2016

INSERT INTO `db_pir_grc`.`grc_nan_estrutura_tipo` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`) VALUES ('1', '01', 'NAN', 'S', 'Programa nacional de atendimento ativo negócio a negócio que tem escopo a realização  de  atendimentos  presenciais  no empreendimento  cliente  na  modalidade visita;');
INSERT INTO `db_pir_grc`.`grc_nan_estrutura_tipo` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`) VALUES ('2', '02', 'Gestor Estadual', 'S', 'Colaborador do Sebrae Bahia, lotado na UAIN, responsável estadual pela aplicação da metodologia do projeto e interlocução com o Sebrae Nacional;');
INSERT INTO `db_pir_grc`.`grc_nan_estrutura_tipo` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`) VALUES ('3', '03', 'Gestor   Local', 'S', 'Colaborador   do   Sebrae   Bahia,   lotado   nas   unidades   regionais, responsável  local  pela  aplicação  da  metodologia  do  projeto  e  acompanhamento  das atividades de campo dos agentes;');
INSERT INTO `db_pir_grc`.`grc_nan_estrutura_tipo` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`) VALUES ('4', '04', 'Tutor  Sênior', 'S', 'Credenciado  responsável  pelo  suporte  estadual  do  projeto.  Atua próximo a  gestão estadual  do  projeto, porém  também  é  interface  de  relacionamento com os tutores e gestores locais;');
INSERT INTO `db_pir_grc`.`grc_nan_estrutura_tipo` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`) VALUES ('5', '05', 'Tutor', 'S', 'Colaborador  ou  credenciado  responsável  pelo  acompanhamento  direto  das atividades  de  campo  dos  agentes.  A  ele  será atribuído  o  papel  de  validador  dos atendimentos  realizados (processos  de  conferência  e  auditoria)  no CRM|Sebrae e liberação das etapas do processo de atendimento;');
INSERT INTO `db_pir_grc`.`grc_nan_estrutura_tipo` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`) VALUES ('6', '06', 'AOE', 'S', 'Agente de orientação  empresarial  vinculados  ao  Sebrae  Bahia  por  meio  de empresas credenciadas ao SGC para  atuação em campo – realização de visitas segundo metodologia do projeto e registro de atendimentos no CRM|Sebrae\r\nEle é remunerado segundo sua produtividade;');
INSERT INTO `db_pir_grc`.`grc_nan_estrutura_tipo` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`) VALUES ('7', '07', 'Empresa  Credenciada', 'S', 'Instituição  vinculadas  ao GC  responsável  pela  contratação dos AOE.');

ALTER TABLE `grc_atendimento`
ADD COLUMN `idt_unidade`  int(10) UNSIGNED NULL AFTER `idt_digitador`;

ALTER TABLE `grc_atendimento`
MODIFY COLUMN `idt_unidade`  int(11) NULL DEFAULT NULL AFTER `idt_digitador`,
MODIFY COLUMN `idt_ponto_atendimento`  int(11) NOT NULL AFTER `idt_unidade`;

ALTER TABLE `grc_atendimento` ADD CONSTRAINT `FK_grc_atendimento_24` FOREIGN KEY (`idt_ponto_atendimento`) REFERENCES `db_pir`.`sca_organizacao_secao` (`idt`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `grc_atendimento` ADD CONSTRAINT `FK_grc_atendimento_25` FOREIGN KEY (`idt_unidade`) REFERENCES `db_pir`.`sca_organizacao_secao` (`idt`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `grc_atendimento`
MODIFY COLUMN `idt_ponto_atendimento`  int(11) NULL AFTER `idt_unidade`;

ALTER TABLE `grc_atendimento_avulso`
MODIFY COLUMN `idt_ponto_atendimento`  int(10) UNSIGNED NULL AFTER `protocolo_marcacao`;

ALTER TABLE `grc_nan_estrutura` ADD CONSTRAINT `FK_grc_nan_estrutura_3` FOREIGN KEY (`idt_tutor`) REFERENCES `grc_nan_estrutura` (`idt`) ON DELETE RESTRICT ON UPDATE CASCADE;

ALTER TABLE `grc_nan_estrutura` DROP FOREIGN KEY `FK_grc_nan_estrutura_3`;

ALTER TABLE `grc_nan_estrutura` DROP FOREIGN KEY `FK_grc_nan_estrutura_1`;

ALTER TABLE `grc_nan_estrutura` DROP FOREIGN KEY `FK_grc_nan_estrutura_2`;

ALTER TABLE `grc_nan_estrutura` ADD CONSTRAINT `FK_grc_nan_estrutura_3` FOREIGN KEY (`idt_tutor`) REFERENCES `grc_nan_estrutura` (`idt`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `grc_nan_estrutura` ADD CONSTRAINT `FK_grc_nan_estrutura_1` FOREIGN KEY (`idt_nan_tipo`) REFERENCES `grc_nan_estrutura_tipo` (`idt`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `grc_nan_estrutura` ADD CONSTRAINT `FK_grc_nan_estrutura_2` FOREIGN KEY (`idt_usuario`) REFERENCES `plu_usuario` (`id_usuario`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `grc_nan_estrutura` ADD CONSTRAINT `FK_grc_nan_estrutura_5` FOREIGN KEY (`idt_acao`) REFERENCES `grc_projeto_acao` (`idt`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `grc_nan_estrutura`
MODIFY COLUMN `idt_ponto_atendimento`  int(11) NOT NULL AFTER `detalhe`;

ALTER TABLE `grc_nan_estrutura` ADD CONSTRAINT `FK_grc_nan_estrutura_4` FOREIGN KEY (`idt_ponto_atendimento`) REFERENCES `db_pir`.`sca_organizacao_secao` (`idt`) ON DELETE RESTRICT ON UPDATE RESTRICT;

INSERT INTO `db_pir_grc`.`grc_nan_devolutiva` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `versao`, `versao_txt`) VALUES ('1', '01', 'DEVOLUTIVA', 'S', '<p>PROJETO NEG&Oacute;CIO A NEG&Oacute;CIO 2016</p>\r\n<p>SEBRAE - Bahia</p>', '1', 'V.01');

INSERT INTO `db_pir_grc`.`grc_nan_devolutiva_item` (`idt`, `idt_devolutiva`, `codigo`, `descricao`, `ativo`, `detalhe`, `tipo`, `include`, `width`, `height`, `background`, `color`) VALUES ('1', '1', '01', 'IDENTIFICAÇÃO', 'S', NULL, '2', 'grc_nan_devolutiva_rel_01', NULL, NULL, NULL, NULL);
INSERT INTO `db_pir_grc`.`grc_nan_devolutiva_item` (`idt`, `idt_devolutiva`, `codigo`, `descricao`, `ativo`, `detalhe`, `tipo`, `include`, `width`, `height`, `background`, `color`) VALUES ('2', '1', '02', 'SOBRE ESSE DIAGNÓSTICO', 'S', '<p>Prezado Empres&aacute;rio,</p>\r\n<p>Como voc&ecirc; sabe, este projeto tem o objetivo de impulsionar a melhoria da gest&atilde;o em sua empresa. O primeiro passo para melhorar &eacute; identificar no que precisamos melhorar e, logo em seguida, pensar em como fazer estas mudan&ccedil;as.</p>\r\n<p>O diagn&oacute;stico aplicado no Atendimento 1 tem o objetivo de lhe mostrar as &aacute;reas nas quais sua empresa pode melhorar (no que), bem como lhe indica as ferramentas que voc&ecirc; poder&aacute; usar para atingir este objetivo (o como).</p>\r\n<p>Agora &eacute; a hora de colocar em pr&aacute;tica as melhorias propostas! Guarde bem este documento (sugerimos que afixe o mesmo em um lugar vis&iacute;vel) e m&atilde;os &agrave; obra!</p>', '1', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `db_pir_grc`.`grc_nan_devolutiva_item` (`idt`, `idt_devolutiva`, `codigo`, `descricao`, `ativo`, `detalhe`, `tipo`, `include`, `width`, `height`, `background`, `color`) VALUES ('3', '1', '03', 'RESULTADOS DO DIAGNÓSTICO POR ÁREA - NESTE CICLO', 'S', '<p><span style=\"font-family: Tahoma;\">Aqui est&atilde;o os Resultados da sua empresa em cada &aacute;rea avaliada, considerando duas informa&ccedil;&otilde;es: o quanto o diagn&oacute;stico indica que sua empresa pode melhorar e o quanto voc&ecirc; entende que deve melhorar &nbsp;(sua insatisfa&ccedil;&atilde;o em rela&ccedil;&atilde;o a cada Tema).</span></p>', '1', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `db_pir_grc`.`grc_nan_devolutiva_item` (`idt`, `idt_devolutiva`, `codigo`, `descricao`, `ativo`, `detalhe`, `tipo`, `include`, `width`, `height`, `background`, `color`) VALUES ('4', '1', '04.01', 'INDICAÇÃO DO DIAGNÓSTICO', 'S', NULL, '2', 'grc_nan_devolutiva_rel_0401', '50', NULL, NULL, NULL);
INSERT INTO `db_pir_grc`.`grc_nan_devolutiva_item` (`idt`, `idt_devolutiva`, `codigo`, `descricao`, `ativo`, `detalhe`, `tipo`, `include`, `width`, `height`, `background`, `color`) VALUES ('5', '1', '04.02', 'SUA PERCEPÇÃO', 'S', NULL, '2', 'grc_nan_devolutiva_rel_0402', '50', NULL, NULL, NULL);
INSERT INTO `db_pir_grc`.`grc_nan_devolutiva_item` (`idt`, `idt_devolutiva`, `codigo`, `descricao`, `ativo`, `detalhe`, `tipo`, `include`, `width`, `height`, `background`, `color`) VALUES ('6', '1', '20', 'FERRAMENTAS INDICADAS', 'S', '<p><span style=\"font-family: Tahoma;\">Para melhorar a gest&atilde;o em sua empresa, estas s&atilde;o as ferramentas recomendadas pelo Agente de Orienta&ccedil;&atilde;o Empresarial para a melhoria da gest&atilde;o em sua empresa.Estas ferramentas foram selecionadas de acordo com suas respostas no diagn&oacute;stico realizado, e pelo conhecimento adquirido pelo Agente de Orienta&ccedil;&atilde;o Empresarial sobre sua Empresa</span></p>', '3', 'grc_nan_devolutiva_rel_20', NULL, NULL, NULL, NULL);
INSERT INTO `db_pir_grc`.`grc_nan_devolutiva_item` (`idt`, `idt_devolutiva`, `codigo`, `descricao`, `ativo`, `detalhe`, `tipo`, `include`, `width`, `height`, `background`, `color`) VALUES ('8', '1', '24', 'PRÓXIMAS CAPACITAÇÕES PRESENCIAIS - SEBRAE /BA (NOME DA REGIONAL)', 'S', '<p><span style=\"font-family: Tahoma;\">Para se aprofundar nas ferramentas propostas, selecionamos as capacita&ccedil;&otilde;es mais adequadas para as suas necessidades.Caso n&atilde;o possa participar nestas datas, ligue para o telefone desta regional (0800 570 0800) e pergunte sobre as pr&oacute;ximas datas dispon&iacute;veis!</span></p>', '3', 'grc_nan_devolutiva_rel_24', NULL, NULL, NULL, NULL);
INSERT INTO `db_pir_grc`.`grc_nan_devolutiva_item` (`idt`, `idt_devolutiva`, `codigo`, `descricao`, `ativo`, `detalhe`, `tipo`, `include`, `width`, `height`, `background`, `color`) VALUES ('10', '1', '26', 'OUTROS MATERIAIS DE APOIO', 'S', '<p><span style=\"font-family: Tahoma;\">O Sebrae publica periodicamente uma s&eacute;rie de materiais &uacute;teis para ajudar voc&ecirc; a aprimorar a gest&atilde;o de seu neg&oacute;cio.Acesse os links abaixo e aperfei&ccedil;oe a gest&atilde;o em sua empresa!</span></p>', '3', 'grc_nan_devolutiva_rel_26', NULL, NULL, NULL, NULL);
INSERT INTO `db_pir_grc`.`grc_nan_devolutiva_item` (`idt`, `idt_devolutiva`, `codigo`, `descricao`, `ativo`, `detalhe`, `tipo`, `include`, `width`, `height`, `background`, `color`) VALUES ('13', '1', '30', 'ASSINATURAS', 'S', '<table width=\"100%\" border=\"0\" cellpadding=\"1\" cellspacing=\"1\">\r\n    <tbody>\r\n        <tr>\r\n            <td>&nbsp;</td>\r\n            <td>&nbsp;</td>\r\n        </tr>\r\n        <tr>\r\n            <td>&nbsp;</td>\r\n            <td>&nbsp;</td>\r\n        </tr>\r\n        <tr>\r\n            <td>&nbsp;</td>\r\n            <td>&nbsp;</td>\r\n        </tr>\r\n        <tr>\r\n            <td>&nbsp;</td>\r\n            <td>&nbsp;</td>\r\n        </tr>\r\n        <tr>\r\n            <td>____________________________________________&nbsp;</td>\r\n            <td>____________________________________________&nbsp;</td>\r\n        </tr>\r\n        <tr>\r\n            <td>Agente de Orienta&ccedil;&atilde;o Empresarial</td>\r\n            <td>&nbsp;Empres&aacute;rio</td>\r\n        </tr>\r\n    </tbody>\r\n</table>\r\n<p>&nbsp;</p>\r\n<p>&nbsp;</p>', '1', NULL, NULL, NULL, NULL, NULL);

-- 11/05/2016

insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu, abrir_sistema)
values ('grc_nan_visita_1_ap','NAN - Primeira Visita - Aprovação','05.70.03','N','N', 'listar', 'listar', null);

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_nan_visita_1_ap') as id_funcao
from plu_direito where cod_direito in ('con', 'alt');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_nan_visita_1_ap');

-- 12/05/2016

-- Já executado em Produção (Inicio) *******************************************
ALTER TABLE `plu_direito`
MODIFY COLUMN `cod_direito`  varchar(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL COMMENT 'CÃ³digo do Direito' AFTER `id_direito`;

INSERT INTO `db_pir_grc`.`plu_direito` (`id_direito`, `cod_direito`, `nm_direito`, `desc_funcao`) VALUES ('6', 'extra1', 'Extra 1', 'S');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_evento') as id_funcao
from plu_direito where cod_direito in ('extra1');

UPDATE db_pir_grc.plu_direito_funcao SET descricao='Quando marcado: O evento na situação Pendente não faz a conciliação, só salva' WHERE id_direito = 6;
-- Já executado em Produção (Fim) **********************************************

ALTER TABLE `grc_formulario_area`
ADD COLUMN `idt_tema_subtema`  int(10) UNSIGNED NULL AFTER `grupo`;

ALTER TABLE `grc_formulario_area` ADD CONSTRAINT `fk_grc_formulario_area_1` FOREIGN KEY (`idt_tema_subtema`) REFERENCES `grc_tema_subtema` (`idt`) ON DELETE RESTRICT ON UPDATE RESTRICT;

-- 13/05/2016

ALTER TABLE `grc_nan_grupo_atendimento`
ADD COLUMN `num_visita`  int(10) UNSIGNED NOT NULL DEFAULT 1 AFTER `idt_pessoa`;

ALTER TABLE `grc_nan_grupo_atendimento`
MODIFY COLUMN `num_visita`  int(10) UNSIGNED NOT NULL AFTER `idt_pessoa`;

insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu, abrir_sistema)
values ('grc_nan_visita_2','NAN - Segunda Visita','05.70.04','N','N', 'listar', 'listar', null);

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_nan_visita_2') as id_funcao
from plu_direito where cod_direito in ('con', 'alt');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_nan_visita_2');

-- homologacao 386
update plu_painel_funcao set parametros = null, id_funcao = (select id_funcao from plu_funcao where cod_funcao = 'grc_nan_visita_2')
where idt = 384;

-- 14/05/2016

ALTER TABLE db_pir_gec.`gec_contratar_credenciado`
DROP INDEX `un_gec_contratar_credenciado_3` ,
ADD UNIQUE INDEX `un_gec_contratar_credenciado_3` (`codigo`, `nan_indicador`) USING BTREE ;

insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu, abrir_sistema)
values ('gec_contratar_credenciado_anexo','Gestão de Contratos Anexo','05.70.50.09.01','N','N', 'listar', 'listar', 'GEC');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'gec_contratar_credenciado_anexo') as id_funcao
from plu_direito where cod_direito in ('con', 'alt', 'inc', 'exc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('gec_contratar_credenciado_anexo');

ALTER TABLE `grc_nan_estrutura` ADD CONSTRAINT `FK_grc_nan_estrutura_20` FOREIGN KEY (`idt_contrato`) REFERENCES `db_pir_gec`.`gec_contratar_credenciado` (`idt`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `grc_nan_estrutura` ADD CONSTRAINT `FK_grc_nan_estrutura_21` FOREIGN KEY (`idt_empresa_executora`) REFERENCES `db_pir_gec`.`gec_entidade` (`idt`) ON DELETE RESTRICT ON UPDATE RESTRICT;

-- 16/05/2016

update grc_nan_estrutura set idt_tutor = null;

ALTER TABLE `grc_nan_estrutura` DROP FOREIGN KEY `FK_grc_nan_estrutura_3`;

ALTER TABLE `grc_nan_estrutura`
MODIFY COLUMN `idt_tutor`  int(10) UNSIGNED NULL DEFAULT NULL AFTER `idt_usuario`;

ALTER TABLE `grc_nan_estrutura` ADD CONSTRAINT `FK_grc_nan_estrutura_3` FOREIGN KEY (`idt_tutor`) REFERENCES `grc_nan_estrutura` (`idt`) ON DELETE RESTRICT ON UPDATE RESTRICT;

-- producao
-- homologa
-- sala