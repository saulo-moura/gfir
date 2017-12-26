-- 05/04/2016

ALTER TABLE `grc_evento`
MODIFY COLUMN `qtd_previsto`  int(10) NULL DEFAULT NULL AFTER `fase_acao_projeto`,
MODIFY COLUMN `qtd_realizado`  int(10) NULL DEFAULT NULL AFTER `qtd_previsto`,
MODIFY COLUMN `qtd_saldo`  int(10) NULL DEFAULT NULL AFTER `qtd_percentual`;

ALTER TABLE `grc_produto`
MODIFY COLUMN `titulo_comercial`  varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL AFTER `idt_programa_grc`;

-- 07/04/2016

INSERT INTO `db_pir_grc`.`plu_painel` (`idt`, `codigo`, `classificacao`, `descricao`) VALUES ('37', 'grc_presencial_ativo', '90.08', 'Presencial - Ativo');

INSERT INTO `db_pir_grc`.`plu_painel_grupo` (`idt`, `idt_painel`, `codigo`, `ordem`, `descricao`, `hint`, `tit_mostrar`, `tit_bt_fecha`, `tit_font_tam`, `tit_font_cor`, `tit_fundo`, `mostra_item`, `texto_altura`, `texto_font_tam`, `texto_ativ_font_cor`, `texto_ativ_fundo`, `texto_desativ_font_cor`, `texto_desativ_fundo`, `move_item`, `passo`, `passo_tit`, `layout_grid`, `img_altura`, `img_largura`, `img_margem_dir`, `img_margem_esq`, `espaco_linha`, `painel_altura`, `painel_largura`) VALUES ('44', '37', '1', '1', 'ATENDIMENTO PRESENCIAL - ATIVO', NULL, 'S', 'A', NULL, NULL, NULL, 'IT', '30', NULL, NULL, NULL, NULL, NULL, 'S', 'N', 'N', 'S', '65', '67', '8', '8', '15', '0', '0');
INSERT INTO `db_pir_grc`.`plu_painel_grupo` (`idt`, `idt_painel`, `codigo`, `ordem`, `descricao`, `hint`, `tit_mostrar`, `tit_bt_fecha`, `tit_font_tam`, `tit_font_cor`, `tit_fundo`, `mostra_item`, `texto_altura`, `texto_font_tam`, `texto_ativ_font_cor`, `texto_ativ_fundo`, `texto_desativ_font_cor`, `texto_desativ_fundo`, `move_item`, `passo`, `passo_tit`, `layout_grid`, `img_altura`, `img_largura`, `img_margem_dir`, `img_margem_esq`, `espaco_linha`, `painel_altura`, `painel_largura`) VALUES ('45', '37', '2', '2', 'PROGRAMA NACIONAL NEGÓCIO A NEGÓCIO', NULL, 'S', 'A', NULL, NULL, NULL, 'IT', '30', NULL, NULL, NULL, NULL, NULL, 'S', 'N', 'N', 'S', '65', '67', '8', '8', '15', '110', '989');
INSERT INTO `db_pir_grc`.`plu_painel_grupo` (`idt`, `idt_painel`, `codigo`, `ordem`, `descricao`, `hint`, `tit_mostrar`, `tit_bt_fecha`, `tit_font_tam`, `tit_font_cor`, `tit_fundo`, `mostra_item`, `texto_altura`, `texto_font_tam`, `texto_ativ_font_cor`, `texto_ativ_fundo`, `texto_desativ_font_cor`, `texto_desativ_fundo`, `move_item`, `passo`, `passo_tit`, `layout_grid`, `img_altura`, `img_largura`, `img_margem_dir`, `img_margem_esq`, `espaco_linha`, `painel_altura`, `painel_largura`) VALUES ('46', '37', '3', '3', 'PROGRAMA NACIONAL AGENTES LOCAIS DE INOVAÇÃO', 'NÃO DISPONIBILIZADO.\r\nO PROGRAMA NACIONAL AGENTES LOCAIS DE INOVAÇÃO \r\nSERÁ OBJETO DE DEFINIÇÃO E DESENVOLVIMENTO POSTERIOR.', 'S', 'N', NULL, NULL, NULL, 'IT', '30', NULL, NULL, NULL, NULL, NULL, 'S', 'N', 'N', 'S', '70', '100', '15', '15', '15', '0', '0');

INSERT INTO `db_pir_grc`.`plu_painel_funcao` (`idt_painel_grupo`, `id_funcao`, `pos_top`, `pos_left`, `imagem`, `imagem_d`, `texto_cab`, `detalhe`, `visivel`, `hint`, `parametros`, `texto_font_tam`, `texto_ativ_font_cor`, `texto_ativ_fundo`, `texto_desativ_font_cor`, `texto_desativ_fundo`, `include`, `include_arq`, `include_altura`, `include_largura`) VALUES ('23', NULL, '260', '510', NULL, NULL, 'Relação Instrumento x Foco x Insumo RM', NULL, 'S', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'N', NULL, NULL, NULL);
INSERT INTO `db_pir_grc`.`plu_painel_funcao` (`idt_painel_grupo`, `id_funcao`, `pos_top`, `pos_left`, `imagem`, `imagem_d`, `texto_cab`, `detalhe`, `visivel`, `hint`, `parametros`, `texto_font_tam`, `texto_ativ_font_cor`, `texto_ativ_fundo`, `texto_desativ_font_cor`, `texto_desativ_fundo`, `include`, `include_arq`, `include_altura`, `include_largura`) VALUES ('28', NULL, '0', '720', NULL, NULL, NULL, NULL, 'S', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'N', NULL, NULL, NULL);
INSERT INTO `db_pir_grc`.`plu_painel_funcao` (`idt_painel_grupo`, `id_funcao`, `pos_top`, `pos_left`, `imagem`, `imagem_d`, `texto_cab`, `detalhe`, `visivel`, `hint`, `parametros`, `texto_font_tam`, `texto_ativ_font_cor`, `texto_ativ_fundo`, `texto_desativ_font_cor`, `texto_desativ_fundo`, `include`, `include_arq`, `include_altura`, `include_largura`) VALUES ('36', NULL, '0', '340', NULL, NULL, 'Áreas para Diagnóstico', NULL, 'S', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'N', NULL, NULL, NULL);
INSERT INTO `db_pir_grc`.`plu_painel_funcao` (`idt_painel_grupo`, `id_funcao`, `pos_top`, `pos_left`, `imagem`, `imagem_d`, `texto_cab`, `detalhe`, `visivel`, `hint`, `parametros`, `texto_font_tam`, `texto_ativ_font_cor`, `texto_ativ_fundo`, `texto_desativ_font_cor`, `texto_desativ_fundo`, `include`, `include_arq`, `include_altura`, `include_largura`) VALUES ('36', NULL, '0', '510', NULL, NULL, NULL, NULL, 'S', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'N', NULL, NULL, NULL);
INSERT INTO `db_pir_grc`.`plu_painel_funcao` (`idt_painel_grupo`, `id_funcao`, `pos_top`, `pos_left`, `imagem`, `imagem_d`, `texto_cab`, `detalhe`, `visivel`, `hint`, `parametros`, `texto_font_tam`, `texto_ativ_font_cor`, `texto_ativ_fundo`, `texto_desativ_font_cor`, `texto_desativ_fundo`, `include`, `include_arq`, `include_altura`, `include_largura`) VALUES ('36', NULL, '0', '680', NULL, NULL, NULL, NULL, 'S', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'N', NULL, NULL, NULL);
INSERT INTO `db_pir_grc`.`plu_painel_funcao` (`idt_painel_grupo`, `id_funcao`, `pos_top`, `pos_left`, `imagem`, `imagem_d`, `texto_cab`, `detalhe`, `visivel`, `hint`, `parametros`, `texto_font_tam`, `texto_ativ_font_cor`, `texto_ativ_fundo`, `texto_desativ_font_cor`, `texto_desativ_fundo`, `include`, `include_arq`, `include_altura`, `include_largura`) VALUES ('36', NULL, '115', '680', NULL, NULL, NULL, NULL, 'S', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'N', NULL, NULL, NULL);
INSERT INTO `db_pir_grc`.`plu_painel_funcao` (`idt_painel_grupo`, `id_funcao`, `pos_top`, `pos_left`, `imagem`, `imagem_d`, `texto_cab`, `detalhe`, `visivel`, `hint`, `parametros`, `texto_font_tam`, `texto_ativ_font_cor`, `texto_ativ_fundo`, `texto_desativ_font_cor`, `texto_desativ_fundo`, `include`, `include_arq`, `include_altura`, `include_largura`) VALUES ('36', NULL, '115', '510', NULL, NULL, NULL, NULL, 'S', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'N', NULL, NULL, NULL);
INSERT INTO `db_pir_grc`.`plu_painel_funcao` (`idt_painel_grupo`, `id_funcao`, `pos_top`, `pos_left`, `imagem`, `imagem_d`, `texto_cab`, `detalhe`, `visivel`, `hint`, `parametros`, `texto_font_tam`, `texto_ativ_font_cor`, `texto_ativ_fundo`, `texto_desativ_font_cor`, `texto_desativ_fundo`, `include`, `include_arq`, `include_altura`, `include_largura`) VALUES ('36', NULL, '115', '0', NULL, NULL, 'Ferramentas de Gestão', NULL, 'S', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'N', NULL, NULL, NULL);
INSERT INTO `db_pir_grc`.`plu_painel_funcao` (`idt_painel_grupo`, `id_funcao`, `pos_top`, `pos_left`, `imagem`, `imagem_d`, `texto_cab`, `detalhe`, `visivel`, `hint`, `parametros`, `texto_font_tam`, `texto_ativ_font_cor`, `texto_ativ_fundo`, `texto_desativ_font_cor`, `texto_desativ_fundo`, `include`, `include_arq`, `include_altura`, `include_largura`) VALUES ('44', NULL, '0', '0', '378_imagem_069_icagendamento2.jpg', NULL, 'Agendamento', NULL, 'S', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'N', NULL, NULL, NULL);
INSERT INTO `db_pir_grc`.`plu_painel_funcao` (`idt_painel_grupo`, `id_funcao`, `pos_top`, `pos_left`, `imagem`, `imagem_d`, `texto_cab`, `detalhe`, `visivel`, `hint`, `parametros`, `texto_font_tam`, `texto_ativ_font_cor`, `texto_ativ_fundo`, `texto_desativ_font_cor`, `texto_desativ_fundo`, `include`, `include_arq`, `include_altura`, `include_largura`) VALUES ('45', NULL, '0', '0', NULL, NULL, 'Primeira Visita', NULL, 'S', NULL, '&balcao=2&instrumento=2&opcao=inc', NULL, NULL, NULL, NULL, NULL, 'N', NULL, NULL, NULL);
INSERT INTO `db_pir_grc`.`plu_painel_funcao` (`idt_painel_grupo`, `id_funcao`, `pos_top`, `pos_left`, `imagem`, `imagem_d`, `texto_cab`, `detalhe`, `visivel`, `hint`, `parametros`, `texto_font_tam`, `texto_ativ_font_cor`, `texto_ativ_fundo`, `texto_desativ_font_cor`, `texto_desativ_fundo`, `include`, `include_arq`, `include_altura`, `include_largura`) VALUES ('44', NULL, '0', '83', '380_imagem_283_icbasedeinformacao.jpg', NULL, 'Base de Informações', NULL, 'S', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'N', NULL, NULL, NULL);
INSERT INTO `db_pir_grc`.`plu_painel_funcao` (`idt_painel_grupo`, `id_funcao`, `pos_top`, `pos_left`, `imagem`, `imagem_d`, `texto_cab`, `detalhe`, `visivel`, `hint`, `parametros`, `texto_font_tam`, `texto_ativ_font_cor`, `texto_ativ_fundo`, `texto_desativ_font_cor`, `texto_desativ_fundo`, `include`, `include_arq`, `include_altura`, `include_largura`) VALUES ('44', NULL, '0', '166', '381_imagem_552_ic2pesquisaratendimento.jpg', NULL, 'Pesquisar Atendimento', NULL, 'S', NULL, '&balcao=2&instrumento=500', NULL, NULL, NULL, NULL, NULL, 'N', NULL, NULL, NULL);
INSERT INTO `db_pir_grc`.`plu_painel_funcao` (`idt_painel_grupo`, `id_funcao`, `pos_top`, `pos_left`, `imagem`, `imagem_d`, `texto_cab`, `detalhe`, `visivel`, `hint`, `parametros`, `texto_font_tam`, `texto_ativ_font_cor`, `texto_ativ_fundo`, `texto_desativ_font_cor`, `texto_desativ_fundo`, `include`, `include_arq`, `include_altura`, `include_largura`) VALUES ('44', NULL, '0', '249', NULL, NULL, 'Financeiro', NULL, 'S', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'N', NULL, NULL, NULL);
INSERT INTO `db_pir_grc`.`plu_painel_funcao` (`idt_painel_grupo`, `id_funcao`, `pos_top`, `pos_left`, `imagem`, `imagem_d`, `texto_cab`, `detalhe`, `visivel`, `hint`, `parametros`, `texto_font_tam`, `texto_ativ_font_cor`, `texto_ativ_fundo`, `texto_desativ_font_cor`, `texto_desativ_fundo`, `include`, `include_arq`, `include_altura`, `include_largura`) VALUES ('44', NULL, '0', '332', NULL, NULL, 'Relatórios', NULL, 'S', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'N', NULL, NULL, NULL);
INSERT INTO `db_pir_grc`.`plu_painel_funcao` (`idt_painel_grupo`, `id_funcao`, `pos_top`, `pos_left`, `imagem`, `imagem_d`, `texto_cab`, `detalhe`, `visivel`, `hint`, `parametros`, `texto_font_tam`, `texto_ativ_font_cor`, `texto_ativ_fundo`, `texto_desativ_font_cor`, `texto_desativ_fundo`, `include`, `include_arq`, `include_altura`, `include_largura`) VALUES ('44', NULL, '0', '415', '384_imagem_762_icpendencias2.jpg', NULL, 'Pendências', NULL, 'S', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'N', NULL, NULL, NULL);
INSERT INTO `db_pir_grc`.`plu_painel_funcao` (`idt_painel_grupo`, `id_funcao`, `pos_top`, `pos_left`, `imagem`, `imagem_d`, `texto_cab`, `detalhe`, `visivel`, `hint`, `parametros`, `texto_font_tam`, `texto_ativ_font_cor`, `texto_ativ_fundo`, `texto_desativ_font_cor`, `texto_desativ_fundo`, `include`, `include_arq`, `include_altura`, `include_largura`) VALUES ('44', NULL, '0', '498', '385_imagem_796_icpreferenciasdousuario-01.png', NULL, 'Parametrizações', NULL, 'S', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'N', NULL, NULL, NULL);
INSERT INTO `db_pir_grc`.`plu_painel_funcao` (`idt_painel_grupo`, `id_funcao`, `pos_top`, `pos_left`, `imagem`, `imagem_d`, `texto_cab`, `detalhe`, `visivel`, `hint`, `parametros`, `texto_font_tam`, `texto_ativ_font_cor`, `texto_ativ_fundo`, `texto_desativ_font_cor`, `texto_desativ_fundo`, `include`, `include_arq`, `include_altura`, `include_largura`) VALUES ('45', NULL, '0', '83', NULL, NULL, 'Segunda Visita', NULL, 'S', NULL, '&balcao=2&instrumento=500', NULL, NULL, NULL, NULL, NULL, 'N', NULL, NULL, NULL);
INSERT INTO `db_pir_grc`.`plu_painel_funcao` (`idt_painel_grupo`, `id_funcao`, `pos_top`, `pos_left`, `imagem`, `imagem_d`, `texto_cab`, `detalhe`, `visivel`, `hint`, `parametros`, `texto_font_tam`, `texto_ativ_font_cor`, `texto_ativ_fundo`, `texto_desativ_font_cor`, `texto_desativ_fundo`, `include`, `include_arq`, `include_altura`, `include_largura`) VALUES ('45', NULL, '0', '166', NULL, NULL, 'Terceira Visita', NULL, 'S', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'N', NULL, NULL, NULL);
INSERT INTO `db_pir_grc`.`plu_painel_funcao` (`idt_painel_grupo`, `id_funcao`, `pos_top`, `pos_left`, `imagem`, `imagem_d`, `texto_cab`, `detalhe`, `visivel`, `hint`, `parametros`, `texto_font_tam`, `texto_ativ_font_cor`, `texto_ativ_fundo`, `texto_desativ_font_cor`, `texto_desativ_fundo`, `include`, `include_arq`, `include_altura`, `include_largura`) VALUES ('45', NULL, '0', '332', NULL, NULL, 'Relatório<br /> Desempenho', NULL, 'S', 'Relatório de Desempenho', NULL, NULL, NULL, NULL, NULL, NULL, 'N', NULL, NULL, NULL);
INSERT INTO `db_pir_grc`.`plu_painel_funcao` (`idt_painel_grupo`, `id_funcao`, `pos_top`, `pos_left`, `imagem`, `imagem_d`, `texto_cab`, `detalhe`, `visivel`, `hint`, `parametros`, `texto_font_tam`, `texto_ativ_font_cor`, `texto_ativ_fundo`, `texto_desativ_font_cor`, `texto_desativ_fundo`, `include`, `include_arq`, `include_altura`, `include_largura`) VALUES ('45', NULL, '0', '415', NULL, NULL, 'Relatório<br /> Conformidade', NULL, 'S', 'Relatório de Conformidade', NULL, NULL, NULL, NULL, NULL, NULL, 'N', NULL, NULL, NULL);
INSERT INTO `db_pir_grc`.`plu_painel_funcao` (`idt_painel_grupo`, `id_funcao`, `pos_top`, `pos_left`, `imagem`, `imagem_d`, `texto_cab`, `detalhe`, `visivel`, `hint`, `parametros`, `texto_font_tam`, `texto_ativ_font_cor`, `texto_ativ_fundo`, `texto_desativ_font_cor`, `texto_desativ_fundo`, `include`, `include_arq`, `include_altura`, `include_largura`) VALUES ('45', NULL, '0', '498', NULL, NULL, 'Relatório<br />Soluções', NULL, 'S', 'Relatório de Soluções', NULL, NULL, NULL, NULL, NULL, NULL, 'N', NULL, NULL, NULL);
INSERT INTO `db_pir_grc`.`plu_painel_funcao` (`idt_painel_grupo`, `id_funcao`, `pos_top`, `pos_left`, `imagem`, `imagem_d`, `texto_cab`, `detalhe`, `visivel`, `hint`, `parametros`, `texto_font_tam`, `texto_ativ_font_cor`, `texto_ativ_fundo`, `texto_desativ_font_cor`, `texto_desativ_fundo`, `include`, `include_arq`, `include_altura`, `include_largura`) VALUES ('45', NULL, '0', '664', NULL, NULL, 'Diagnóstico', NULL, 'S', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'N', NULL, NULL, NULL);
INSERT INTO `db_pir_grc`.`plu_painel_funcao` (`idt_painel_grupo`, `id_funcao`, `pos_top`, `pos_left`, `imagem`, `imagem_d`, `texto_cab`, `detalhe`, `visivel`, `hint`, `parametros`, `texto_font_tam`, `texto_ativ_font_cor`, `texto_ativ_fundo`, `texto_desativ_font_cor`, `texto_desativ_fundo`, `include`, `include_arq`, `include_altura`, `include_largura`) VALUES ('45', NULL, '0', '747', NULL, NULL, 'Devolutiva', NULL, 'S', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'N', NULL, NULL, NULL);
INSERT INTO `db_pir_grc`.`plu_painel_funcao` (`idt_painel_grupo`, `id_funcao`, `pos_top`, `pos_left`, `imagem`, `imagem_d`, `texto_cab`, `detalhe`, `visivel`, `hint`, `parametros`, `texto_font_tam`, `texto_ativ_font_cor`, `texto_ativ_fundo`, `texto_desativ_font_cor`, `texto_desativ_fundo`, `include`, `include_arq`, `include_altura`, `include_largura`) VALUES ('45', NULL, '0', '830', NULL, NULL, 'Desistência', NULL, 'S', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'N', NULL, NULL, NULL);
INSERT INTO `db_pir_grc`.`plu_painel_funcao` (`idt_painel_grupo`, `id_funcao`, `pos_top`, `pos_left`, `imagem`, `imagem_d`, `texto_cab`, `detalhe`, `visivel`, `hint`, `parametros`, `texto_font_tam`, `texto_ativ_font_cor`, `texto_ativ_fundo`, `texto_desativ_font_cor`, `texto_desativ_fundo`, `include`, `include_arq`, `include_altura`, `include_largura`) VALUES ('45', NULL, '0', '913', NULL, NULL, 'Parâmetros<br /> do Projeto', NULL, 'S', 'Parâmetros do Projeto', NULL, NULL, NULL, NULL, NULL, NULL, 'N', NULL, NULL, NULL);
INSERT INTO `db_pir_grc`.`plu_painel_funcao` (`idt_painel_grupo`, `id_funcao`, `pos_top`, `pos_left`, `imagem`, `imagem_d`, `texto_cab`, `detalhe`, `visivel`, `hint`, `parametros`, `texto_font_tam`, `texto_ativ_font_cor`, `texto_ativ_fundo`, `texto_desativ_font_cor`, `texto_desativ_fundo`, `include`, `include_arq`, `include_altura`, `include_largura`) VALUES ('46', NULL, '0', '0', NULL, NULL, 'A', NULL, 'N', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'N', NULL, NULL, NULL);

insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_nan_visita_1','NAN - Primeira Visita','05.70.01','N','N', 'inc', 'inc');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_nan_visita_1') as id_funcao
from plu_direito where cod_direito in ('con', 'alt', 'inc', 'exc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_nan_visita_1');

insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_nan_visita_1_cadastro','NAN - Primeira Visita - Cadastros PJ e PF','05.70.02','N','N', 'cadastro', 'cadastro');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_nan_visita_1_cadastro') as id_funcao
from plu_direito where cod_direito in ('con', 'alt', 'inc', 'exc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_nan_visita_1_cadastro');

-- 09/04/2016

update grc_evento_insumo set quantidade = 1 where codigo = 'evento_insc';

executar _font/calcula_evento_insumo.php

-- 11/04/2016

UPDATE `db_pir_grc`.`plu_funcao` SET `id_funcao`='404', `cod_funcao`='grc_entidade_organizacao', `nm_funcao`='Organização', `cod_classificacao`='03.01', `sts_menu`='S', `sts_linha`='S', `des_prefixo`='listar', `prefixo_menu`='listar', `parametros`=NULL, `url`=NULL, `imagem`=NULL, `coluna`=NULL, `linha`=NULL, `texto_cab`=NULL, `detalhe`=NULL, `visivel`=NULL, `grupo_classe`=NULL, `hint`=NULL, `painel`=NULL, `abrir_sistema`='atual' WHERE (`id_funcao`='404');
UPDATE `db_pir_grc`.`plu_funcao` SET `id_funcao`='382', `cod_funcao`='grc_entidade_pessoa', `nm_funcao`='Pessoa', `cod_classificacao`='03.03', `sts_menu`='S', `sts_linha`='N', `des_prefixo`='listar', `prefixo_menu`='listar', `parametros`=NULL, `url`=NULL, `imagem`=NULL, `coluna`=NULL, `linha`=NULL, `texto_cab`=NULL, `detalhe`=NULL, `visivel`=NULL, `grupo_classe`=NULL, `hint`=NULL, `painel`=NULL, `abrir_sistema`='atual' WHERE (`id_funcao`='382');

insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_entidade_organizacao_cnae', 'Atendimento Organização CNAE - GEC', '03.01.01', 'N', 'N', 'listar', 'listar');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_entidade_organizacao_cnae') as id_funcao
from plu_direito where cod_direito in ('con', 'alt', 'inc', 'exc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_entidade_organizacao_cnae');

insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_entidade_pessoa_arquivo_interesse', 'Arquivos de Interesse da Pessoa - GEC', '03.03.01', 'N', 'N', 'listar', 'listar');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_entidade_pessoa_arquivo_interesse') as id_funcao
from plu_direito where cod_direito in ('con', 'alt', 'inc', 'exc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_entidade_pessoa_arquivo_interesse');

insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_entidade_pessoa_produto_interesse', 'Produtos de Interesse da Pessoa - GEC', '03.03.05', 'N', 'N', 'listar', 'listar');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_entidade_pessoa_produto_interesse') as id_funcao
from plu_direito where cod_direito in ('con', 'alt', 'inc', 'exc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_entidade_pessoa_produto_interesse');

insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_entidade_pessoa_tema_interesse', 'Temas de Interesse da Pessoa - GEC', '03.03.10', 'N', 'N', 'listar', 'listar');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_entidade_pessoa_tema_interesse') as id_funcao
from plu_direito where cod_direito in ('con', 'alt', 'inc', 'exc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_entidade_pessoa_tema_interesse');

-- 12/04/2016

ALTER TABLE `grc_evento`
ADD COLUMN `qtd_vagas_adicional`  int(10) NOT NULL DEFAULT 0 AFTER `qtd_vagas_bloqueadas`;

-- 13/04/2016

CREATE TABLE `grc_evento_estabelecimento` (
  `idt` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `codigo` varchar(45) NOT NULL,
  `descricao` varchar(120) NOT NULL,
  `detalhe` varchar(1000) DEFAULT NULL,
  `ativo` varchar(1) NOT NULL DEFAULT 'S',
  PRIMARY KEY (`idt`),
  UNIQUE KEY `iu_grc_evento_estabelecimento` (`codigo`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_evento_estabelecimento', 'Código do Estabelecimento', '02.99.23', 'S', 'N', 'listar', 'listar');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_evento_estabelecimento') as id_funcao
from plu_direito where cod_direito in ('con', 'alt', 'inc', 'exc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_evento_estabelecimento');

ALTER TABLE `grc_evento_participante_pagamento`
ADD COLUMN `idt_evento_estabelecimento`  int(10) UNSIGNED NULL AFTER `codigo_nsu`;

ALTER TABLE `grc_evento_participante_pagamento` ADD CONSTRAINT `grc_evento_participante_pagamento_ibfk_7` FOREIGN KEY (`idt_evento_estabelecimento`) REFERENCES `grc_evento_estabelecimento` (`idt`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `grc_evento_estabelecimento`
DROP INDEX `iu_grc_evento_estabelecimento`;

INSERT INTO `db_pir_grc`.`grc_evento_estabelecimento` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('1', '1030115904', 'Cartão BNDES', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_estabelecimento` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('2', '1064782938', 'Loja virtual', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_estabelecimento` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('3', '1023606663', 'UDT', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_estabelecimento` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('4', '1025104606', 'CRS (0800)', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_estabelecimento` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('5', '1023921550', 'CAE', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_estabelecimento` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('6', '1023921550', 'Livraria', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_estabelecimento` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('7', '1023921550', 'Lauro de Freitas', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_estabelecimento` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('8', '1023921550', 'SAC Empresarial', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_estabelecimento` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('9', '1064520445', 'Alagoinhas', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_estabelecimento` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('10', '1063798610', 'Liberdade', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_estabelecimento` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('11', '1063798865', 'Itapagipe', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_estabelecimento` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('12', '1042084804', 'Camacarí', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_estabelecimento` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('13', '1023921798', 'Barreiras', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_estabelecimento` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('14', '1023921925', 'Feira', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_estabelecimento` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('15', '1042085053', 'Ipirá', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_estabelecimento` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('16', '1042085266', 'Euclides da Cunha', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_estabelecimento` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('17', '1042085347', 'Itaberaba', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_estabelecimento` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('18', '1023948521', 'Ilhéus', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_estabelecimento` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('19', '1033277662', 'Itabuna', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_estabelecimento` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('20', '1023948629', 'PA Jacobina', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_estabelecimento` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('21', '1037831478', 'Senhor do Bonfim', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_estabelecimento` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('22', '1023962982', 'Juazeiro', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_estabelecimento` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('23', '1033888076', 'Paulo Afonso', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_estabelecimento` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('24', '1023967127', 'SAJ', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_estabelecimento` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('25', '1042085495', 'Valença', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_estabelecimento` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('26', '1023967135', 'Seabra', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_estabelecimento` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('27', '1036348820', 'Irece', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_estabelecimento` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('28', '1023967143', 'Teixeira de Freitas', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_estabelecimento` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('29', '1042204362', 'Porto Seguro', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_estabelecimento` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('30', '1042086181', 'Eunápolis', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_estabelecimento` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('31', '1023967151', 'Vitoria da Conquista', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_estabelecimento` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('32', '1042204648', 'Brumado', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_estabelecimento` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('33', '1042204575', 'Guanambi', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_estabelecimento` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('34', '1042204508', 'Itapetinga', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_estabelecimento` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('35', '1042204451', 'Jequie', NULL, 'S');
INSERT INTO `db_pir_grc`.`grc_evento_estabelecimento` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`) VALUES ('36', '1042204419', 'Ipiaú', NULL, 'S');

ALTER TABLE `grc_evento_estabelecimento`
AUTO_INCREMENT=1;

UPDATE `grc_evento_natureza_pagamento` SET `ativo`='N' WHERE (`idt`='1');

ALTER TABLE `grc_insumo`
ADD COLUMN `sebprodcrm`  varchar(45) NULL AFTER `estocavel`;

-- 14/04/2016

ALTER TABLE db_pir_gec.`base_cep`
DROP INDEX `un_base_cep_10` ,
ADD INDEX `un_base_cep_1` (`cep`) USING BTREE ,
ADD INDEX `un_base_cep_11` (`logradouro`, `cep_situacao`) USING BTREE ,
ADD INDEX `un_base_cep_12` (`bairro`, `cep_situacao`) USING BTREE ,
ADD INDEX `un_base_cep_13` (`cidade`, `cep_situacao`) USING BTREE ,
ADD INDEX `un_base_cep_14` (`uf_sigla`, `cep_situacao`) USING BTREE ,
ADD INDEX `un_base_cep_15` (`codbairro`, `cep_situacao`) USING BTREE ,
ADD INDEX `un_base_cep_16` (`codcid`, `cep_situacao`) USING BTREE ,
ADD INDEX `un_base_cep_17` (`codest`, `cep_situacao`) USING BTREE ,
ADD INDEX `un_base_cep_18` (`codpais`, `cep_situacao`) USING BTREE ,
ADD INDEX `un_base_cep_10` (`cep`, `cep_situacao`) USING BTREE ;

insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('executa_job_siacweb','Sincronização do Cache com o SIACWEB','99.80.05.97','N','N','inc','inc');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'executa_job_siacweb') as id_funcao
from plu_direito where cod_direito in ('alt');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('executa_job_siacweb');

INSERT INTO `db_pir_grc`.`plu_painel_funcao` (`idt_painel_grupo`, `id_funcao`, `pos_top`, `pos_left`, `imagem`, `imagem_d`, `texto_cab`, `detalhe`, `visivel`, `hint`, `parametros`, `texto_font_tam`, `texto_ativ_font_cor`, `texto_ativ_fundo`, `texto_desativ_font_cor`, `texto_desativ_fundo`, `include`, `include_arq`, `include_altura`, `include_largura`) VALUES ('28', NULL, '230', '720', NULL, NULL, NULL, NULL, 'S', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'N', NULL, NULL, NULL);

-- 15/04/2016

ALTER TABLE `grc_nan_grupo_atendimento`
DROP COLUMN `detalhe`,
CHANGE COLUMN `codigo` `dt_primeira_visita`  timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `idt`,
CHANGE COLUMN `descricao` `idt_organizacao`  int(10) UNSIGNED NULL AFTER `dt_primeira_visita`,
CHANGE COLUMN `ativo` `idt_pessoa`  int(10) UNSIGNED NULL AFTER `idt_organizacao`,
ADD COLUMN `status`  char(2) NOT NULL AFTER `idt_pessoa`,
DROP INDEX `iu_grc_nan_grupo_atendimento`;

ALTER TABLE `grc_nan_grupo_atendimento` ADD CONSTRAINT `fk_grc_nan_grupo_atendimento_1` FOREIGN KEY (`idt_organizacao`) REFERENCES `db_pir_gec`.`gec_entidade` (`idt`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `grc_nan_grupo_atendimento` ADD CONSTRAINT `fk_grc_nan_grupo_atendimento_2` FOREIGN KEY (`idt_pessoa`) REFERENCES `db_pir_gec`.`gec_entidade` (`idt`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `grc_atendimento`
ADD COLUMN `nan_status`  char(2) NULL AFTER `idt_grupo_atendimento`;

ALTER TABLE `grc_atendimento` DROP FOREIGN KEY `FK_grc_atendimento_21`;

ALTER TABLE `grc_atendimento`
ADD COLUMN `idt_nan_tutor`  int(11) NULL AFTER `nan_status`;

ALTER TABLE `grc_atendimento` ADD CONSTRAINT `FK_grc_atendimento_21` FOREIGN KEY (`idt_grupo_atendimento`) REFERENCES `grc_nan_grupo_atendimento` (`idt`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `grc_atendimento` ADD CONSTRAINT `FK_grc_atendimento_22` FOREIGN KEY (`idt_nan_tutor`) REFERENCES `plu_usuario` (`id_usuario`) ON DELETE RESTRICT ON UPDATE RESTRICT;

-- esmeraldo

-- 18/04/2016

UPDATE `db_pir_grc`.`plu_funcao` SET `id_funcao`='573', `cod_funcao`='grc_avaliacao_apoio_xxx', `nm_funcao`='Tabelas de Apoio', `cod_classificacao`='30.99', `sts_menu`='S', `sts_linha`='S', `des_prefixo`='inc', `prefixo_menu`='inc', `parametros`=NULL, `url`=NULL, `imagem`=NULL, `coluna`=NULL, `linha`=NULL, `texto_cab`=NULL, `detalhe`=NULL, `visivel`=NULL, `grupo_classe`=NULL, `hint`=NULL, `painel`=NULL, `abrir_sistema`='atual' WHERE (`id_funcao`='573');
UPDATE `db_pir_grc`.`plu_funcao` SET `id_funcao`='569', `cod_funcao`='grc_avaliacao_apoio', `nm_funcao`='Gestão de Diagnóstico', `cod_classificacao`='30', `sts_menu`='S', `sts_linha`='N', `des_prefixo`='inc', `prefixo_menu`='inc', `parametros`=NULL, `url`=NULL, `imagem`=NULL, `coluna`=NULL, `linha`=NULL, `texto_cab`=NULL, `detalhe`=NULL, `visivel`=NULL, `grupo_classe`=NULL, `hint`=NULL, `painel`=NULL, `abrir_sistema`='atual' WHERE (`id_funcao`='569');

UPDATE `db_pir_grc`.`plu_painel` SET `idt`='26', `codigo`='grc_avaliacao_apoio', `classificacao`='30.01', `descricao`='Diagnóstico Situacional - Avaliação' WHERE (`idt`='26');

UPDATE `db_pir_grc`.`plu_painel_grupo` SET `idt`='36', `idt_painel`='26', `codigo`='DIAGNÓSTICO SITUACIONAL - APOIO', `ordem`='2', `descricao`='TABELAS DE APOIO', `hint`=NULL, `tit_mostrar`='S', `tit_bt_fecha`='A', `tit_font_tam`=NULL, `tit_font_cor`=NULL, `tit_fundo`=NULL, `mostra_item`='IT', `texto_altura`='30', `texto_font_tam`=NULL, `texto_ativ_font_cor`=NULL, `texto_ativ_fundo`=NULL, `texto_desativ_font_cor`=NULL, `texto_desativ_fundo`=NULL, `move_item`='S', `passo`='N', `passo_tit`='N', `layout_grid`='S', `img_altura`='70', `img_largura`='150', `img_margem_dir`='10', `img_margem_esq`='10', `espaco_linha`='15', `painel_altura`='345', `painel_largura`='850' WHERE (`idt`='36');
delete from plu_painel_funcao where idt_painel_grupo = 36;

INSERT INTO `db_pir_grc`.`plu_painel_grupo` (`idt`, `idt_painel`, `codigo`, `ordem`, `descricao`, `hint`, `tit_mostrar`, `tit_bt_fecha`, `tit_font_tam`, `tit_font_cor`, `tit_fundo`, `mostra_item`, `texto_altura`, `texto_font_tam`, `texto_ativ_font_cor`, `texto_ativ_fundo`, `texto_desativ_font_cor`, `texto_desativ_fundo`, `move_item`, `passo`, `passo_tit`, `layout_grid`, `img_altura`, `img_largura`, `img_margem_dir`, `img_margem_esq`, `espaco_linha`, `painel_altura`, `painel_largura`) VALUES ('48', '26', 'APLICAR DIAGNÓSTICO SITUACIONAL 2', '1', 'APLICAR DIAGNÓSTICO SITUACIONAL', NULL, 'S', 'A', NULL, NULL, NULL, 'IT', '30', NULL, NULL, NULL, NULL, NULL, 'S', 'N', 'N', 'S', '70', '120', '10', '10', '15', '0', '0');

INSERT INTO `db_pir_grc`.`plu_painel_funcao` (`idt`, `idt_painel_grupo`, `id_funcao`, `pos_top`, `pos_left`, `imagem`, `imagem_d`, `texto_cab`, `detalhe`, `visivel`, `hint`, `parametros`, `texto_font_tam`, `texto_ativ_font_cor`, `texto_ativ_fundo`, `texto_desativ_font_cor`, `texto_desativ_fundo`, `include`, `include_arq`, `include_altura`, `include_largura`) VALUES ('198', '36', null, '230', '510', '198_imagem_183_download-1.jpg', NULL, 'Aplicação', NULL, 'S', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'N', NULL, NULL, NULL);
INSERT INTO `db_pir_grc`.`plu_painel_funcao` (`idt`, `idt_painel_grupo`, `id_funcao`, `pos_top`, `pos_left`, `imagem`, `imagem_d`, `texto_cab`, `detalhe`, `visivel`, `hint`, `parametros`, `texto_font_tam`, `texto_ativ_font_cor`, `texto_ativ_fundo`, `texto_desativ_font_cor`, `texto_desativ_fundo`, `include`, `include_arq`, `include_altura`, `include_largura`) VALUES ('199', '36', null, '0', '0', '199_imagem_174_diagnosisicon-150x150.png', NULL, 'Criar Diagnóstico Situacional', NULL, 'S', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'N', NULL, NULL, NULL);
INSERT INTO `db_pir_grc`.`plu_painel_funcao` (`idt`, `idt_painel_grupo`, `id_funcao`, `pos_top`, `pos_left`, `imagem`, `imagem_d`, `texto_cab`, `detalhe`, `visivel`, `hint`, `parametros`, `texto_font_tam`, `texto_ativ_font_cor`, `texto_ativ_fundo`, `texto_desativ_font_cor`, `texto_desativ_fundo`, `include`, `include_arq`, `include_altura`, `include_largura`) VALUES ('372', '36', null, '0', '510', '372_imagem_063_download-1.jpg', NULL, 'Áreas para Diagnóstico', NULL, 'S', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'N', NULL, NULL, NULL);
INSERT INTO `db_pir_grc`.`plu_painel_funcao` (`idt`, `idt_painel_grupo`, `id_funcao`, `pos_top`, `pos_left`, `imagem`, `imagem_d`, `texto_cab`, `detalhe`, `visivel`, `hint`, `parametros`, `texto_font_tam`, `texto_ativ_font_cor`, `texto_ativ_fundo`, `texto_desativ_font_cor`, `texto_desativ_fundo`, `include`, `include_arq`, `include_altura`, `include_largura`) VALUES ('373', '36', null, '0', '680', '373_imagem_114_download-1.jpg', NULL, NULL, NULL, 'S', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'N', NULL, NULL, NULL);
INSERT INTO `db_pir_grc`.`plu_painel_funcao` (`idt`, `idt_painel_grupo`, `id_funcao`, `pos_top`, `pos_left`, `imagem`, `imagem_d`, `texto_cab`, `detalhe`, `visivel`, `hint`, `parametros`, `texto_font_tam`, `texto_ativ_font_cor`, `texto_ativ_fundo`, `texto_desativ_font_cor`, `texto_desativ_fundo`, `include`, `include_arq`, `include_altura`, `include_largura`) VALUES ('374', '36', null, '230', '680', '374_imagem_072_download-1.jpg', NULL, NULL, NULL, 'S', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'N', NULL, NULL, NULL);
INSERT INTO `db_pir_grc`.`plu_painel_funcao` (`idt`, `idt_painel_grupo`, `id_funcao`, `pos_top`, `pos_left`, `imagem`, `imagem_d`, `texto_cab`, `detalhe`, `visivel`, `hint`, `parametros`, `texto_font_tam`, `texto_ativ_font_cor`, `texto_ativ_fundo`, `texto_desativ_font_cor`, `texto_desativ_fundo`, `include`, `include_arq`, `include_altura`, `include_largura`) VALUES ('375', '36', null, '115', '680', '375_imagem_081_download-1.jpg', NULL, NULL, NULL, 'S', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'N', NULL, NULL, NULL);
INSERT INTO `db_pir_grc`.`plu_painel_funcao` (`idt_painel_grupo`, `id_funcao`, `pos_top`, `pos_left`, `imagem`, `imagem_d`, `texto_cab`, `detalhe`, `visivel`, `hint`, `parametros`, `texto_font_tam`, `texto_ativ_font_cor`, `texto_ativ_fundo`, `texto_desativ_font_cor`, `texto_desativ_fundo`, `include`, `include_arq`, `include_altura`, `include_largura`) VALUES ('36', null, '115', '510', '376_imagem_098_download-1.jpg', NULL, NULL, NULL, 'S', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'N', NULL, NULL, NULL);
INSERT INTO `db_pir_grc`.`plu_painel_funcao` (`idt_painel_grupo`, `id_funcao`, `pos_top`, `pos_left`, `imagem`, `imagem_d`, `texto_cab`, `detalhe`, `visivel`, `hint`, `parametros`, `texto_font_tam`, `texto_ativ_font_cor`, `texto_ativ_fundo`, `texto_desativ_font_cor`, `texto_desativ_fundo`, `include`, `include_arq`, `include_altura`, `include_largura`) VALUES ('36', null, '0', '340', '377_imagem_106_download-1.jpg', NULL, 'Ferramentas de Gestão', NULL, 'S', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'N', NULL, NULL, NULL);
INSERT INTO `db_pir_grc`.`plu_painel_funcao` (`idt_painel_grupo`, `id_funcao`, `pos_top`, `pos_left`, `imagem`, `imagem_d`, `texto_cab`, `detalhe`, `visivel`, `hint`, `parametros`, `texto_font_tam`, `texto_ativ_font_cor`, `texto_ativ_fundo`, `texto_desativ_font_cor`, `texto_desativ_fundo`, `include`, `include_arq`, `include_altura`, `include_largura`) VALUES ('36', null, '0', '170', '402_imagem_318_download-2.jpg', NULL, 'Modelo de Devolutiva', NULL, 'S', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'N', NULL, NULL, NULL);
INSERT INTO `db_pir_grc`.`plu_painel_funcao` (`idt_painel_grupo`, `id_funcao`, `pos_top`, `pos_left`, `imagem`, `imagem_d`, `texto_cab`, `detalhe`, `visivel`, `hint`, `parametros`, `texto_font_tam`, `texto_ativ_font_cor`, `texto_ativ_fundo`, `texto_desativ_font_cor`, `texto_desativ_fundo`, `include`, `include_arq`, `include_altura`, `include_largura`) VALUES ('36', null, '115', '340', '403_imagem_394_planejar.jpg', NULL, 'Ferramentas do EAD', NULL, 'S', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'N', NULL, NULL, NULL);
INSERT INTO `db_pir_grc`.`plu_painel_funcao` (`idt_painel_grupo`, `id_funcao`, `pos_top`, `pos_left`, `imagem`, `imagem_d`, `texto_cab`, `detalhe`, `visivel`, `hint`, `parametros`, `texto_font_tam`, `texto_ativ_font_cor`, `texto_ativ_fundo`, `texto_desativ_font_cor`, `texto_desativ_fundo`, `include`, `include_arq`, `include_altura`, `include_largura`) VALUES ('36', null, '230', '340', '404_imagem_317_download-1.jpg', NULL, 'LINKs - Devolutiva', NULL, 'S', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'N', NULL, NULL, NULL);
INSERT INTO `db_pir_grc`.`plu_painel_funcao` (`idt_painel_grupo`, `id_funcao`, `pos_top`, `pos_left`, `imagem`, `imagem_d`, `texto_cab`, `detalhe`, `visivel`, `hint`, `parametros`, `texto_font_tam`, `texto_ativ_font_cor`, `texto_ativ_fundo`, `texto_desativ_font_cor`, `texto_desativ_fundo`, `include`, `include_arq`, `include_altura`, `include_largura`) VALUES ('36', null, '115', '170', NULL, NULL, 'Situação da Avaliação', NULL, 'S', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'N', NULL, NULL, NULL);
INSERT INTO `db_pir_grc`.`plu_painel_funcao` (`idt_painel_grupo`, `id_funcao`, `pos_top`, `pos_left`, `imagem`, `imagem_d`, `texto_cab`, `detalhe`, `visivel`, `hint`, `parametros`, `texto_font_tam`, `texto_ativ_font_cor`, `texto_ativ_fundo`, `texto_desativ_font_cor`, `texto_desativ_fundo`, `include`, `include_arq`, `include_altura`, `include_largura`) VALUES ('48', 570, '0', '0', NULL, NULL, 'Aplicar Diagnóstico Situacional', NULL, 'S', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'N', NULL, NULL, NULL);

INSERT INTO `db_pir_grc`.`plu_funcao` (`id_funcao`, `cod_funcao`, `nm_funcao`, `cod_classificacao`, `sts_menu`, `sts_linha`, `des_prefixo`, `prefixo_menu`, `parametros`, `url`, `imagem`, `coluna`, `linha`, `texto_cab`, `detalhe`, `visivel`, `grupo_classe`, `hint`, `painel`, `abrir_sistema`) VALUES ('570', 'grc_avaliacao', 'Avaliar Contratação', '30.03', 'S', 'N', 'listar', 'listar', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'atual');

ALTER TABLE `grc_avaliacao`
ADD COLUMN `idt_atendimento`  int(10) UNSIGNED NULL AFTER `idt_situacao`;

ALTER TABLE `grc_avaliacao` ADD CONSTRAINT `FK_grc_avaliacao_8` FOREIGN KEY (`idt_atendimento`) REFERENCES `grc_atendimento` (`idt`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `grc_atendimento`
ADD COLUMN `idt_nan_empresa`  int(11) NULL AFTER `idt_nan_tutor`;

ALTER TABLE `grc_atendimento` ADD CONSTRAINT `FK_grc_atendimento_23` FOREIGN KEY (`idt_nan_empresa`) REFERENCES `plu_usuario` (`id_usuario`) ON DELETE RESTRICT ON UPDATE RESTRICT;

-- 19/04/2016

ALTER TABLE `grc_evento`
ADD COLUMN `idt_programa`  int(10) UNSIGNED NULL AFTER `idt_instrumento`;

ALTER TABLE `grc_evento` ADD CONSTRAINT `fk_grc_evento_27` FOREIGN KEY (`idt_programa`) REFERENCES `db_pir_gec`.`gec_programa` (`idt`) ON DELETE RESTRICT ON UPDATE RESTRICT;

executar _font/ajusta_evento_programa.php

ALTER TABLE `grc_produto` ADD CONSTRAINT `FK_grc_produto_16` FOREIGN KEY (`idt_programa`) REFERENCES `db_pir_gec`.`gec_programa` (`idt`) ON DELETE RESTRICT ON UPDATE RESTRICT;

-- 20/04/2016

ALTER TABLE `grc_atendimento_pessoa`
ADD INDEX `iu_grc_atendimento_pessoa_1` (`cpf`) USING BTREE ;

ALTER TABLE `grc_atendimento_organizacao`
ADD INDEX `iu_grc_atendimento_organizacao_1` (`cnpj`) USING BTREE ;

-- homologa
-- producao
-- sala
