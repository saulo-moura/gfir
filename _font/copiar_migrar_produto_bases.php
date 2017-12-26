<?php
require_once '../configuracao.php';

/*
  Executar no Banco de Produ��o Antes de Migrar

  INSERT INTO `db_pir_grc`.`grc_insumo_unidade` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`) VALUES ('40', '�rea', 'm�', 'S', '�rea em m� (metros quadrados).\r\nCadastrado em: 17/03/2017.\r\nRespons�vel: Eduardo Garrido (UAIT).');
  INSERT INTO `db_pir_grc`.`grc_insumo_unidade` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`) VALUES ('41', 'Projeto', 'Projeto de Design', 'S', 'Cadastrado em: 17/03/2017.\r\nRespons�vel: Eduardo Garrido (UAIT).');
  INSERT INTO `db_pir_grc`.`grc_insumo_unidade` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`) VALUES ('42', 'Marca', 'Marca', 'S', 'Cadastrado em: 17/03/2017.\r\nRespons�vel: Eduardo Garrido (UAIT).');
  INSERT INTO `db_pir_grc`.`grc_insumo_unidade` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`) VALUES ('43', 'Pe�a', 'Pe�a', 'S', 'Cadastrado em: 17/03/2017.\r\nRespons�vel: Eduardo Garrido (UAIT).');
  INSERT INTO `db_pir_grc`.`grc_insumo_unidade` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`) VALUES ('44', 'EVTE', 'EVTE', 'S', 'EVTE: Estudo de Viabilidade Te&#769;cnica e Econo&#770;mica.\r\nCadastrado em: 17/03/2017.\r\nRespons�vel: Eduardo Garrido (UAIT).');
  INSERT INTO `db_pir_grc`.`grc_insumo_unidade` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`) VALUES ('45', 'Gravidez da vaca', 'Prenhez', 'S', 'Prenhez: Condi��o da f�mea que se encontra no per�odo de gesta��o; gravidez. \r\nCadastrado em: 17/03/2017.\r\nRespons�vel: Eduardo Garrido (UAIT).');
  INSERT INTO `db_pir_grc`.`grc_insumo_unidade` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`) VALUES ('46', 'Layout Interno', 'Ambiente Interno', 'S', 'Layout Interno: Ambiente Interno.\r\nCadastrado em: 17/03/2017.\r\nRespons�vel: Eduardo Garrido (UAIT).');
  INSERT INTO `db_pir_grc`.`grc_insumo_unidade` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`) VALUES ('47', 'Expositor do Ponto de Venda', 'Expositor do Ponto de Venda', 'S', 'Cadastrado em: 17/03/2017.\r\nRespons�vel: Eduardo Garrido (UAIT).');
  INSERT INTO `db_pir_grc`.`grc_insumo_unidade` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`) VALUES ('48', 'Coringa', 'Vari�vel Qualitativa', 'S', 'Vari�vel Qualitativa');
  INSERT INTO `db_pir_grc`.`grc_insumo_unidade` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`) VALUES ('49', 'Servi�o de Consultoria', 'Servi�o de Consultoria', 'S', 'Cadastrado em: 18/03/2017.\r\nRespons�vel: Eduardo Garrido (UAIT).');
  INSERT INTO `db_pir_grc`.`grc_insumo_unidade` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`) VALUES ('50', 'Plano', 'Plano', 'S', 'Cadastrado em: 18/03/2017.\r\nRespons�vel: Eduardo Garrido (UAIT).');
  INSERT INTO `db_pir_grc`.`grc_insumo_unidade` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`) VALUES ('51', 'Processo', 'Processo', 'S', 'Cadastrado em: 17/03/2017.\r\nRespons�vel: Eduardo Garrido (UAIT).');
  INSERT INTO `db_pir_grc`.`grc_insumo_unidade` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`) VALUES ('52', 'Esta��o', 'Esta��o', 'S', 'Cadastrado em: 17/03/2017.\r\nRespons�vel: Eduardo Garrido (UAIT).');
  INSERT INTO `db_pir_grc`.`grc_insumo_unidade` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`) VALUES ('54', 'Patente ou MU', 'Patente ou MU', 'S', 'Patente: Uma patente � um direito exclusivo concedido pelo Estado relativamente a uma inven��o (ou modelo de utilidade), que atende ao requisito de novidade, envolve uma atividade inventiva (ou ato inventivo) e � suscet�vel de aplica��o industrial.\r\nModelo de Utilidade: O modelo de utilidade � considerado o objeto de uso pr�tico ou parte deste, suscet�vel de aplica��o industrial, que apresente nova forma ou disposi��o, envolvendo ato inventivo que resulte em melhoria funcional no seu uso ou em sua fabrica��o. \r\nCadastrado em: 18/03/2017.\r\nRespons�vel: Eduardo Garrido (UAIT).');
  INSERT INTO `db_pir_grc`.`grc_insumo_unidade` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`) VALUES ('55', 'Desenho Industrial', 'Desenho Industrial', 'S', 'Cadastrado em: 18/03/2017.\r\nRespons�vel: Eduardo Garrido (UAIT).');
  INSERT INTO `db_pir_grc`.`grc_insumo_unidade` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`) VALUES ('56', 'Modelo de Utilidade', 'Modelo de Utilidade', 'S', 'Cadastrado em: 18/03/2017.\r\nRespons�vel: Eduardo Garrido (UAIT).');
  INSERT INTO `db_pir_grc`.`grc_insumo_unidade` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`) VALUES ('57', 'Funcion�rio', 'Funcion�rio', 'S', 'Cadastrado em: 20/03/2017.\r\nRespons�vel: Eduardo Garrido (UAIT).');
  INSERT INTO `db_pir_grc`.`grc_insumo_unidade` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`) VALUES ('58', 'E-Commerce', 'E-Commerce', 'S', 'Cadastrado em: 20/03/2017.\r\nRespons�vel: Eduardo Garrido (UAIT).');
  INSERT INTO `db_pir_grc`.`grc_insumo_unidade` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`) VALUES ('59', 'Sim ou N�o', 'Sim ou N�o', 'S', 'Responder 1 para Sim, 2 para N�o.\r\nCadastrado em: 20/03/2017.\r\nRespons�vel: Eduardo Garrido (UAIT).');
  INSERT INTO `db_pir_grc`.`grc_insumo_unidade` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`) VALUES ('60', 'Requerimento', 'Licen�a Ambiental', 'S', 'Requerimento da Licen�a junto ao �rg�o Ambiental.\r\nCadastrado em: 21/03/2017.\r\nRespons�vel: Eduardo Garrido (UAIT).');
  INSERT INTO `db_pir_grc`.`grc_insumo_unidade` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`) VALUES ('61', 'Unidades Produtivas', 'Unidades Produtivas', 'S', 'Cadastrado em: 21/03/2017.\r\nRespons�vel: Eduardo Garrido (UAIT).');
  INSERT INTO `db_pir_grc`.`grc_insumo_unidade` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`) VALUES ('62', 'Posto de Trabalho', 'Posto de Trabalho', 'S', 'Cadastrado em: 21/03/2017.\r\nRespons�vel: Eduardo Garrido (UAIT).');
  INSERT INTO `db_pir_grc`.`grc_insumo_unidade` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`) VALUES ('63', 'P�o', 'P�o', 'S', 'Cadastrado em: 21/03/2017.\r\nRespons�vel: Eduardo Garrido (UAIT).');
  INSERT INTO `db_pir_grc`.`grc_insumo_unidade` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`) VALUES ('64', 'Ambiente', 'Ambiente', 'S', 'Ambiente.');
  INSERT INTO `db_pir_grc`.`grc_insumo_unidade` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`) VALUES ('65', 'Produto', 'Produto', 'S', 'Produto.');
  INSERT INTO `db_pir_grc`.`grc_insumo_unidade` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`) VALUES ('66', 'Servi�o', 'Servi�o', 'S', 'Cadastrado em: 22/03/2017.\r\nRespons�vel: Eduardo Garrido (UAIT).');
  INSERT INTO `db_pir_grc`.`grc_insumo_unidade` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`) VALUES ('67', 'M�quina e/ou Equipamento', 'M�quina e/ou Equipamento', 'S', 'Cadastrado em: 21/03/2017.\r\nRespons�vel: Eduardo Garrido (UAIT).');
  INSERT INTO `db_pir_grc`.`grc_insumo_unidade` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`) VALUES ('68', 'Prot�tipo', 'Prot�tipo', 'S', 'Cadastrado em: 22/03/2017.\r\nRespons�vel: Eduardo Garrido (UAIT).');
  INSERT INTO `db_pir_grc`.`grc_insumo_unidade` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`) VALUES ('69', 'Minuto', 'Minuto', 'S', 'Unidade de Tempo.\r\nCadastrado em: 23/03/2017.\r\nRespons�vel: Eduardo Garrido (UAIT).');
  INSERT INTO `db_pir_grc`.`grc_insumo_unidade` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`) VALUES ('70', 'Grau de Risco', 'Grau de Risco', 'S', 'O Grau de Risco varia de 1 a 4, conforme Norma Regulamentadora 4 do Minist�rio do Trabalho e Emprego e CNAE da Empresa. \r\nA norma pode ser acessada gratuitamente no site do MTE.\r\nCadastrado em: 24/03/2017.\r\nRespons�vel: Eduardo Garrido (UAIT).');
  INSERT INTO `db_pir_grc`.`grc_insumo_unidade` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`) VALUES ('71', 'Oficina', 'Oficina', 'S', 'Cadastrado em: 27/03/2017.\r\nRespons�vel: Eduardo Garrido (UAIT).');
  INSERT INTO `db_pir_grc`.`grc_insumo_unidade` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`) VALUES ('72', 'Metrologia', 'Metrologia', 'S', 'Cadastrado em: 28/03/2017.\r\nRespons�vel: Eduardo Garrido (UAIT).');
  INSERT INTO `db_pir_grc`.`grc_insumo_unidade` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`) VALUES ('73', 'Diagn�stico Tecnol�gico', 'Diagn�stico Tecnol�gico', 'S', 'Cadastrado em: 28/03/2017.\r\nRespons�vel: Eduardo Garrido (UAIT).');
  INSERT INTO `db_pir_grc`.`grc_insumo_unidade` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`) VALUES ('75', 'Servi�os de Metrologia', 'Servi�o de Metrologia', 'S', 'Cadastrado em: 31/03/2017.\r\nRespons�vel: Eduardo Garrido (UAIT).');
  INSERT INTO `db_pir_grc`.`grc_insumo_unidade` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`) VALUES ('76', 'Cl�nica', 'Cl�nica Tecnol�gica', 'S', 'Cadastrado em: 04/04/2017.\r\nRespons�vel: Eduardo Garrido (UAIT).');
  INSERT INTO `db_pir_grc`.`grc_insumo_unidade` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`) VALUES ('77', 'Empresas', 'Empresas', 'S', 'Cadastrado em: 04/04/2017.\r\nRespons�vel: Eduardo Garrido (UAIT).');

  INSERT INTO `db_pir_grc`.`grc_programa` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `sigla`) VALUES ('8', '08', 'SEBRAETEC', 'S', '<p>&nbsp;SEBRAETEC</p>', 'ST');

  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('58', 'UAIT-00001-2017', 'Relat�rio de Visita T�cnica Presencial � Empresa.', 'S', NULL, 'Relat�rio de Visita T�cnica Presencial � Empresa.\r\nCadastrado em: 17/03/2017.\r\nRespons�vel: Eduardo Garrido (UAIT).', 'RVT', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('59', 'UAIT-00002-2017', 'Declara��o do Produtor informando a designa��o de um preposto para acompanhar e atestar os servi�os que ser�o realizados na propriedade.', 'S', NULL, 'Declara��o do Produtor informando a designa��o de um preposto para acompanhar e atestar os servi�os que ser�o realizados na propriedade.\r\nCadastrado em: 17/03/2017.\r\nRespons�vel: Eduardo Garrido (UAIT).', 'DP', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('60', 'UAIT-00003-2017', 'Ata de Reuni�o Presencial com assinatura do empres�rio.', 'S', NULL, 'Ata atestando a realiza��o de reuni�o presencial junto ao cliente.\r\nCadastrado em: 17/03/2017.\r\nRespons�vel: Eduardo Garrido (UAIT).', 'ATA', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '1', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('61', 'UAIT-00004-2017', 'Briefing: levantamento de informa��es junto ao cliente de modo a obter informa��es e instru��es concisas e objetivas sobre miss�o ou tarefa a ser executada.', 'S', NULL, 'Briefing: levantamento de informa��es junto ao cliente de modo a obter informa��es e instru��es concisas e objetivas sobre miss�o ou tarefa a ser executada.\r\nCadastrado em: 17/03/2017.\r\nRespons�vel: Eduardo Garrido (UAIT).', 'BRF', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('62', 'UAIT-00005-2017', 'Medi��es Realizadas: Medidas levantadas para subsidiar o projeto.', 'S', NULL, 'Medi��es Realizadas: Medidas levantadas para subsidiar o projeto.\r\nCadastrado em: 17/03/2017.\r\nRespons�vel: Eduardo Garrido (UAIT).', 'MED', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('63', 'UAIT-00006-2017', 'Registros Fotogr�ficos.', 'S', NULL, 'Registros Fotogr�ficos.\r\nCadastrado em: 17/03/2017.\r\nRespons�vel: Eduardo Garrido (UAIT).', 'FOT', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('64', 'UAIT-00007-2017', 'Planifica��o 2D: desenho t�cnico em duas dimens�es.', 'S', NULL, 'Planifica��o 2D: desenho t�cnico em duas dimens�es.\r\nCadastrado em: 17/03/2017.\r\nRespons�vel: Eduardo Garrido (UAIT).', 'P2D', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('65', 'UAIT-00008-2017', 'Projeto em 3D: projeto em tr�s dimens�es, contendo renderiza��es fotogr�ficas com as devidas explica��es e orienta��es ao empres�rio.', 'S', NULL, 'Projeto em 3D: projeto em tr�s dimens�es, contendo renderiza��es fotogr�ficas com as devidas explica��es e orienta��es ao empres�rio.\r\nCadastrado em: 17/03/2017.\r\nRespons�vel: Eduardo Garrido (UAIT).', 'P3D', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('66', 'UAIT-00009-2017', 'CD ou DVD contendo renderiza��o (processo pelo qual se obt�m o produto final de um processamento digital qualquer) 3D do Projeto em v�deo HD (passeio virtual).', 'S', NULL, 'CD ou DVD contendo renderiza��o (processo pelo qual se obt�m o produto final de um processamento digital qualquer) 3D do Projeto em v�deo HD (passeio virtual).\r\nCadastrado em: 17/03/2017.\r\nRespons�vel: Eduardo Garrido (UAIT).', 'R3D', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('67', 'UAIT-00010-2017', 'Projeto de Design.', 'S', NULL, 'Projeto de Design.\r\nCadastrado em: 17/03/2017.\r\nRespons�vel: Eduardo Garrido (UAIT).', 'PRJ', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('68', 'UAIT-00011-2017', 'Documento(s) de Comprova��o de Prenhezes entregue(s) ao Produtor.', 'S', NULL, 'Documento(s) de Comprova��o de Prenhezes entregue(s) ao Produtor.\r\nCadastrado em: 17/03/2017.\r\nRespons�vel: Eduardo Garrido (UAIT).', 'DOCPREN', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('69', 'UAIT-00012-2017', 'EVTE: Estudo de Viabilidade Te&#769;cnica e Econo&#770;mica.', 'S', NULL, 'EVTE: Estudo de Viabilidade Te&#769;cnica e Econo&#770;mica.\r\nCadastrado em: 17/03/2017.\r\nRespons�vel: Eduardo Garrido (UAIT).', 'EVTE', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('70', 'UAIT-00013-2017', 'Modelagem 2D: desenho t�cnico em duas dimens�es.', 'S', NULL, 'Modelagem 2D: desenho t�cnico em duas dimens�es.\r\nCadastrado em: 17/03/2017.\r\nRespons�vel: Eduardo Garrido (UAIT).', 'M2D', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('71', 'UAIT-00014-2017', 'Recibo de envio do formul�rio de pedido de Registro de Marca junto ao INPI, com: n�mero do pedido, n�mero do protocolo e data com hor�rio do protocolo.', 'S', NULL, 'Recibo de envio do formul�rio de pedido de Registro de Marca junto ao INPI, com: n�mero do pedido, n�mero do protocolo e data com hor�rio do protocolo.\r\nCadastrado em: 17/03/2017.\r\nRespons�vel: Eduardo Garrido (UAIT).', 'REC', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '20', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('72', 'UAIT-00015-2017', 'Documento do PPRA, contendo plano de a��o e assinatura do(s) profissional(is) de seguran�a respons�vel(is) pela elabora��o.', 'S', NULL, 'PCMSO � Programa de Controle M�dico de Sa�de Ocupacional.\r\nPPRA � Programa de Preven��o de Riscos Ambientais.\r\nCadastrado em: 20/03/2017.\r\nRespons�vel: Eduardo Garrido (UAIT).', 'PPRA', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '1', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('73', 'UAIT-00016-2017', 'Anota��o de Responsabilidade T�cnica do Profissional.', 'S', NULL, 'Cadastrado em: 20/03/2017.\r\nRespons�vel: Eduardo Garrido (UAIT).', 'ART', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('74', 'UAIT-00017-2017', 'Documento do PCMSO, contendo plano de a��o e assinatura do profissional de sa�de respons�vel pela elabora��o.', 'S', NULL, 'PCMSO � Programa de Controle M�dico de Sa�de Ocupacional.\r\nPPRA � Programa de Preven��o de Riscos Ambientais.\r\nCadastrado em: 20/03/2017.\r\nRespons�vel: Eduardo Garrido (UAIT).', 'PCMSO', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('75', 'UAIT-00018-2017', 'Declara��o assinada pelo empres�rio atestando o recebimento do documento do PPRA estruturado pelo prestador de servi�o tecnol�gico e que o prestador de servi�o tecnol�gico explicou ao cliente o conte�do da entrega efetivada. Deve conter a assinatura do respons�vel da empresa e do profissional de seguran�a.', 'S', NULL, 'PCMSO � Programa de Controle M�dico de Sa�de Ocupacional.\r\nPPRA � Programa de Preven��o de Riscos Ambientais.\r\nCadastrado em: 20/03/2017.\r\nRespons�vel: Eduardo Garrido (UAIT).', 'DECL PPRA', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('76', 'UAIT-00019-2017', 'Declara��o assinada pelo empres�rio atestando o recebimento do documento do PCMSO estruturado pelo prestador de servi�o tecnol�gico e que o prestador de servi�o tecnol�gico explicou ao cliente o conte�do da entrega efetivada. Deve conter a assinatura do respons�vel da empresa e do profissional de seguran�a.', 'S', NULL, 'PCMSO � Programa de Controle M�dico de Sa�de Ocupacional.\r\nPPRA � Programa de Preven��o de Riscos Ambientais.\r\nCadastrado em: 20/03/2017.\r\nRespons�vel: Eduardo Garrido (UAIT).', 'DECL PCMSO', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('77', 'UAIT-00020-2017', 'Protocolo do Projeto junto a ANATEL.', 'S', NULL, 'ANATEL - Ag�ncia Nacional de Telecomunica��es.\r\nCadastrado em: 20/03/2017.\r\nRespons�vel: Eduardo Garrido (UAIT).', 'PROTOC ANATEL', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('78', 'UAIT-00021-2017', 'Laudo comparativo referente �s exig�ncias da ANATEL e o atual cen�rio da presta��o dos servi�os.', 'S', NULL, 'ANATEL - Ag�ncia Nacional de Telecomunica��es.\r\nCadastrado em: 20/03/2017.\r\nRespons�vel: Eduardo Garrido (UAIT).', 'LAUDO ANATEL', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('79', 'UAIT-00022-2017', 'Publica��o de Extrato da Autoriza��o no Di�rio Oficial da Uni�o.', 'S', NULL, 'Cadastrado em: 20/03/2017.\r\nRespons�vel: Eduardo Garrido (UAIT).', 'DOU', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('80', 'UAIT-00023-2017', 'Relat�rio de conformidade das radia��es eletromagn�ticas.', 'S', NULL, 'Radia��o eletromagn�tica � a defini��o dada � ondas que se propagam no v�cuo ou no ar com velocidade de 300.000 km/s, ou seja, com a velocidade da luz (c), que tamb�m � uma radia��o eletromagn�tica. Uma outra caracter�stica das ondas eletromagn�ticas � a capacidade de transportar energia e informa��es.\r\nCadastrado em: 20/03/2017.\r\nRespons�vel: Eduardo Garrido (UAIT).', 'RAD ELET', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('81', 'UAIT-00024-2017', 'Projeto T�cnico contendo pelo menos as seguintes informa��es: a descri��o do servi�o a ser prestado contemplando as aplica��es previstas; radiofrequ�ncias pretendidas, quando for o caso; pontos de interconex�o previstos; capacidade pretendida do sistema em termos de n�mero de canais e largura de banda ou taxa de transmiss�o; localiza��o dos principais pontos de presen�a, no formato Munic�pio/UF; diagrama ilustrativo do sistema com a descri��o das fun��es executadas por cada elemento do diagrama.', 'S', NULL, 'Radia��o eletromagn�tica � a defini��o dada � ondas que se propagam no v�cuo ou no ar com velocidade de 300.000 km/s, ou seja, com a velocidade da luz (c), que tamb�m � uma radia��o eletromagn�tica. Uma outra caracter�stica das ondas eletromagn�ticas � a capacidade de transportar energia e informa��es.\r\nCadastrado em: 20/03/2017.\r\nRespons�vel: Eduardo Garrido (UAIT).', 'PROJ TEC', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('82', 'UAIT-00025-2017', 'Declara��o assinada pelo empres�rio atestando o recebimento da(s) entrega(s) realizadas pelo prestador de servi�o tecnol�gico e que o prestador de servi�o tecnol�gico explicou presencialmente ao cliente o conte�do da(s) entrega(s) efetivadas.', 'S', NULL, 'Cadastrado em: 20/03/2017.\r\nRespons�vel: Eduardo Garrido (UAIT).', 'DECL ENTREGA', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('83', 'UAIT-00026-2017', 'Manual de Identidade Visual Impresso e em CD ou DVD contendo;\r\n� Todo o material desenvolvido durante a consultoria, em m�dia digital (CD ou DVD), vetorizado ou imagens em alta resolu��o (em se tratando de imagens bitmapeadas);\r\n� Malha Construtiva da Marca;\r\n� Padr�es Crom�ticos (em escala RGB, CMYK, P/B e Pantone);\r\n� Apresenta��o da marca aprovada nas vers�es horizontais ou verticais com suas redu��es m�nimas;\r\n� Defini��o de ��rea de n�o interfer�ncia� da marca aprovada;\r\n� Controle de Fundo. Restri��es e/ou aplica��es em fundos coloridos ou texturizados;\r\n� Usos proibitivos ou incorretos da marca;\r\n� Defini��o de fam�lia tipogr�fica utilizada no projeto, assim como disponibiliza��o da mesma em sua vers�o digital;\r\n� Imagem digital da marca (para registro junto ao INPI) contida, obrigatoriamente, em uma moldura de 8.0 cm x 8.0 cm, no formato.jpg conforme orienta��es contidas no site;\r\n� Vistas frente x verso (quando houver) das aplica��es em papelaria com indica��es de dobra, vinco, cortes e abas;\r\n� Defini��o e detalhamento de suporte gr�fico para cada um dos itens dos elementos desenvolvidos: papel (tipo e gramatura);\r\n� PVC ou acr�lico (espessura).', 'S', NULL, 'Cadastrado em: 20/03/2017.\r\nRespons�vel: Eduardo Garrido (UAIT).', 'MANUAL', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('84', 'UAIT-00027-2017', 'Projeto de Preven��o e Combate Contra Inc�ndio atendendo a legisla��o e normas t�cnicas vigentes. Deve conter Memorial Descritivo, Componentes e o Memorial de C�lculo, contendo a metodologia utilizada e o dimensionamento.', 'S', NULL, 'Cadastrado em: 20/03/2017.\r\nRespons�vel: Eduardo Garrido (UAIT).', 'INCENDIO', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('85', 'UAIT-00028-2017', 'Planta de Situa��o, em escala adequada, com indica��o das canaliza��es externas, inclusive redes existentes das concession�rias e outras de interesse.', 'S', NULL, 'Cadastrado em: 20/03/2017.\r\nRespons�vel: Eduardo Garrido (UAIT).', 'SITUACAO', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('86', 'UAIT-00029-2017', 'Planta Geral para cada n�vel da edifica��o, em escala 1:50, contendo indica��o dos componentes dos sistemas, como comprimentos das tubula��es horizontais e verticais, loca��o dos hidrantes internos e externos, vaz�es, press�es nos pontos de interesse, cotas de eleva��o, registros de bloqueio e de recalque, v�lvulas de reten��o e alarme, extintores, bombas, reservat�rios, ilumina��o de emerg�ncia, sinaliza��o de emerg�ncia, especifica��es dos materiais b�sico e outros.', 'S', NULL, 'Cadastrado em: 20/03/2017.\r\nRespons�vel: Eduardo Garrido (UAIT).', 'GERAL', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('87', 'UAIT-00030-2017', 'Desenhos esquem�ticos de interliga��o, prumadas e cortes.', 'S', NULL, 'Cadastrado em: 20/03/2017.\r\nRespons�vel: Eduardo Garrido (UAIT).', 'ESQUEM', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('88', 'UAIT-00031-2017', 'Especifica��es detalhadas de materiais, equipamentos e servi�os para execu��o do Projeto de Combate a Inc�ndio.', 'S', NULL, 'Cadastrado em: 20/03/2017.\r\nRespons�vel: Eduardo Garrido (UAIT).', 'ESPECIF', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('89', 'UAIT-00032-201', 'Documento do Plano de Emerg�ncia Contra Inc�ndio, atendendo as recomenda��es contidas na legisla��o vigente e normas t�cnicas, contemplando no m�nimo os requisitos estabelecidos no Anexo B (Modelo de plano de emerg�ncia contra inc�ndio) da NBR 15219:2005 e assinatura do(s) profissional(is) de seguran�a respons�vel(is) pela elabora��o.', 'S', NULL, 'Cadastrado em: 20/03/2017.\r\nRespons�vel: Eduardo Garrido (UAIT).', 'EMERG', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('90', 'UAIT-00034-2017', '11. Manual completo impresso e em arquivo digital contendo:\r\n11.1. Passo a passo para uso e gest�o do sistema de E-commerce;\r\n11.2. Instru��es para utiliza��o para meios eletr�nicos de pagamento;\r\n11.3. Orienta��es sobre aspectos legais e tribut�rios;\r\n11.4. Orienta��es sobre embalagem, como realizar as fotografias dos produtos/servi�os, descri��o dos mesmos, bem como estrat�gias para divulga��o e promo��o.', 'S', NULL, 'Cadastrado em: 20/03/2017.\r\nRespons�vel: Eduardo Garrido (UAIT).', 'MANUAL E-COMM', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('91', 'UAIT-00033-2017', 'Print da Tela Evidenciando as Entregas.', 'S', NULL, 'Cadastrado em: 20/03/2017.\r\nRespons�vel: Eduardo Garrido (UAIT).', 'PRINT', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('92', 'UAIT-00035-2017', 'Pe�as desenvolvidas em m�dia digital e formato impresso.', 'S', NULL, 'Cadastrado em: 20/03/2017.\r\nRespons�vel: Eduardo Garrido (UAIT).', 'PE�AS', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('93', 'UAIT-00036-2017', 'Plano de Gerenciamento de Res�duos S�lidos.', 'S', NULL, 'Cadastrado em: 21/03/2017.\r\nRespons�vel: Eduardo Garrido (UAIT).', 'PGRS', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('94', 'UAIT-00037-2017', 'Roteiro de Caracteriza��o de Empreendimento.', 'S', NULL, 'Cadastrado em: 21/03/2017.\r\nRespons�vel: Eduardo Garrido (UAIT).', 'RCE', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('95', 'UAIT-00039-2017', 'Planta de Localiza��o do Im�vel: Mapa Georreferenciado do empreendimento', 'S', NULL, 'Cadastrado em: 21/03/2017.\r\nRespons�vel: Eduardo Garrido (UAIT).', 'LOCALIZA��O', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('96', 'UAIT-00038-2017', 'Plano de Emerg�ncia Ambiental.', 'S', NULL, 'Cadastrado em: 21/03/2017.\r\nRespons�vel: Eduardo Garrido (UAIT).', 'PEA', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('97', 'UAIT-00040-2017', 'Comprovante de pagamento da taxa de licenciamento pelo cliente.', 'S', NULL, 'Comprovante de pagamento da taxa de licenciamento pelo cliente.', 'TAXA LIC', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('98', 'UAIT-00041-2017', 'N� do Protocolo/ Processo de Entrada junto ao �rg�o Ambiental.', 'S', NULL, 'Cadastrado em: 21/03/2017.\r\nRespons�vel: Eduardo Garrido (UAIT).', 'PROTOC AMBIENTAL', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('99', 'UAIT-00042-2017', 'C�pia de toda a documenta��o constante no Processo apresentado ao �rg�o Ambiental, organizado em documento �nico, em meio impresso e digital.', 'S', NULL, 'Cadastrado em: 21/03/2017.\r\nRespons�vel: Eduardo Garrido (UAIT).', 'PROCESSO AMBIENTAL', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('100', 'UAIT-00043-2017', 'C�pia de toda a documenta��o constante no Processo apresentado a ANATEL, organizado em documento �nico, em meio impresso e digital.', 'S', NULL, 'ANATEL - Ag�ncia Nacional de Telecomunica��es.\r\nCadastrado em: 21/03/2017.\r\nRespons�vel: Eduardo Garrido (UAIT).', 'PROCESSO ANATEL', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('101', 'UAIT-00044-2017', 'Memorial descritivo e de c�lculo do processo produtivo/servi�os.', 'S', NULL, 'Cadastrado em: 21/03/2017.\r\nRespons�vel: Eduardo Garrido (UAIT).', 'MEMORIAL', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('102', 'UAIT-00045-2017', 'Manual da Qualidade com a descri��o de todos os processos da empresa.', 'S', NULL, 'Cadastrado em: 21/03/2017.\r\nRespons�vel: Eduardo Garrido (UAIT).', 'MANUAL QUALIDADE', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('103', 'UAIT-00046-2017', 'Procedimentos e Rotinas escritas para os itens obrigat�rios da norma e para os principais processos de trabalho da empresa.', 'S', NULL, 'Cadastrado em: 21/03/2017.\r\nRespons�vel: Eduardo Garrido (UAIT).', 'PROC E ROT', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('104', 'UAIT-00048-2017', 'Declara��o do Empres�rio informando a designa��o de um preposto para acompanhar e atestar os servi�os que ser�o realizados na empresa.', 'S', NULL, 'O CLIENTE deve designar interlocutor para acompanhar o Consultor da CONTRATADA nas visitas ao empreendimento, dando acesso �s instala��es, bem como, fornecer informa��es fidedignas e documentos imprescind�veis para composi��o do procedimento.\r\nCadastrado em: 21/03/2017.\r\nRespons�vel: Eduardo Garrido (UAIT).', 'DEC PREP', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('105', 'UAIT-00047-2017', 'Lista de Presen�a e Certificados emitidos referentes ao Treinamento do(s) Funcion�rio(s) da Empresa. Material desenvolvido/utilizado no treinamento.', 'S', NULL, 'Cadastrado em: 21/03/2017.\r\nRespons�vel: Eduardo Garrido (UAIT).', 'TREINAMENTO', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('106', 'UAIT-00049-2017', 'Relat�rio de auditoria interna.', 'S', NULL, 'Cadastrado em: 21/03/2017.\r\nRespons�vel: Eduardo Garrido (UAIT).', 'AUDITORIA INT', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('107', 'UAIT-00052-2017', 'Documento de Analise Ergon�mica do Trabalho (AET), com base na metodologia EWA - Ergon�mica Workplace Analysis, contendo plano de melhorias, cronograma, prioriza��o das a��es e assinatura do(s) profissional(is) de seguran�a respons�vel(is) pela elabora��o.', 'S', NULL, 'Cadastrado em: 21/03/2017.\r\nRespons�vel: Eduardo Garrido (UAIT).', 'AET', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('108', 'UAIT-00050-2017', 'Relat�rio contendo orienta��es de melhoria para a empresa.', 'S', NULL, 'Cadastrado em: 21/03/2017.\r\nRespons�vel: Eduardo Garrido (UAIT).', 'ORIENT MEL', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('109', 'UAIT-00051-2017', 'Descri��o de Cargos e Fun��es.', 'S', NULL, 'Cadastrado em: 21/03/2017.\r\nRespons�vel: Eduardo Garrido (UAIT).', 'CARGOS E FUN��ES', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('110', 'UAIT-00053-2017', 'Documento de mapeamento descrevendo o fluxograma de processos, balan�os, requisitos de mat�rias primas (entradas) e produtos (sa�das); Identifica��o das principais vari�veis de cada processo. An�lise e mapeamento das vari�veis de processos existentes. Identificar tempos, desvios em rela��o a resultados esperados (metas). Caso n�o exista mapeamento de dados de processo, implementar planilha de levantamento de dados.', 'S', NULL, 'Cadastrado em: 21/03/2017.\r\nRespons�vel: Eduardo Garrido (UAIT).', 'MAPEAMENTO', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('111', 'UAIT-00054-2017', 'Documento de planejamento da produ��o contendo a coleta de requisitos relativos ao planejamento de produ��o, avalia��o se as fichas t�cnicas ou estrutura de produto existente servem de base para o planejamento de compras, produ��o, gest�o de estoques. Caso n�o exista, desenvolver formul�rio padr�o para levantamento de dados.', 'S', NULL, 'Cadastrado em: 21/03/2017.\r\nRespons�vel: Eduardo Garrido (UAIT).', 'PLANEJAMENTO', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '1', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('112', 'UAIT-00055-2017', 'Documento de padroniza��o de processos operacionais. Escolher um processo produtivo, sugerindo melhorias, treinando envolvidos e implementando a padroniza��o.', 'S', NULL, 'Cadastrado em: 21/03/2017.\r\nRespons�vel: Eduardo Garrido (UAIT).', 'PADRONIZA��O', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('113', 'UAIT-00056-2017', 'Documento de an�lise de controles de estoques de mat�rias primas e insumos. Avaliar se os m�todos utilizados possibilitam correta gest�o de estoque, suprimento das linhas de produ��o e continuidade operacional. Caso n�o atenda, implementar controle visual e f�sico; Avaliar os controles de apura��o de produ��o. Planilhas, formul�rio de coleta de dados, fichas de apura��o de produ��o, verificando a sua aplicabilidade no processo de tomada de decis�o. Caso n�o, implementar novos controles. Analisar controles de estoques de produto acabado, interfaces entre entrega da produ��o e recep��o pela log�stica (armaz�m). Avaliar se os m�todos utilizados possibilitam correta gest�o de estoque, expedi��o de produtos, identifica��o de produtos conforme e n�o conforme. Caso n�o atenda, implementar controle visual e f�sico.', 'S', NULL, 'Cadastrado em: 21/03/2017.\r\nRespons�vel: Eduardo Garrido (UAIT).', 'CONTROLE', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('114', 'UAIT-00057-2017', 'Documento de avalia��o e dimensionamento de capacidade produtiva. Medir efici�ncia real x te�rica. Comparar capacidade produtiva x demandas de mercado. Identificar gargalos no processo produtivo e propor a��es para aumento de capacidade e redu��o de gargalos; Avaliar custos de produ��o identificando margem de lucro dos produtos atrav�s da utiliza��o de planilhas e ferramentas que possibilitem o c�lculo de margem e pre�o de venda; Propor estrat�gias para aumento da margem de lucro (redu��o de custos, desperd�cios, tempos de processamento, maximiza��o de sinergias); Propor melhorias no layout produtivo, visando redu��o de custos vari�veis, redu��o de tempos de processo, aumento de capacidade; Propor indicadores de processo chaves (custo, qualidade, produtividade, seguran�a) que possibilite o acompanhamento e an�lise dos processos existentes e potenciais tomadas de decis�es.', 'S', NULL, 'Cadastrado em: 21/03/2017.\r\nRespons�vel: Eduardo Garrido (UAIT).', 'PRODU��O', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('115', 'UAIT-00058-2017', 'Relat�rio definitivo contendo a consolida��o de todas as etapas desenvolvidas na consultoria, validado junto ao cliente. O documento deve conter observa��es, an�lise do problema, plano de a��o contendo a��es executadas, a��es propostas, resultados e plano de melhoria cont�nua.', 'S', NULL, 'Cadastrado em: 21/03/2017.\r\nRespons�vel: Eduardo Garrido (UAIT).', 'CONCLUS�O', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('116', 'UAIT-00059-2017', 'Diagn�stico realizado na empresa.', 'S', NULL, 'Cadastrado em: 21/03/2017.\r\nRespons�vel: Eduardo Garrido (UAIT).', 'DIAGN�STICO', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('117', 'UAIT-00060-2017', 'Caderno de Campo contendo registros de entrada e sa�da de produtos na propriedade, anota��es peri�dicas sobre manejo das culturas ou cria��es.', 'S', NULL, 'Cadastrado em: 21/03/2017.\r\nRespons�vel: Eduardo Garrido (UAIT).', 'CADERNO', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('118', 'UAIT-00061-2017', 'Plano de Manejo (tamb�m chamado de Plano de Transi��o ou Plano de Convers�o) para Sistemas Org�nicos de Produ��o Vegetal e Animal, validado, contendo:\r\n- Hist�rico de Utiliza��o da �rea;\r\n- Manuten��o ou Incremento da Biodiversidade;\r\n- Manejo dos Res�duos;\r\n- Conserva��o do Solo e da �gua;\r\n- Manejos da Produ��o Vegetal e Animal;\r\n- Procedimentos de P�s-Produ��o;\r\n- Medidas para Preven��o de Riscos de Contamina��o Externa;\r\n- Boas Pr�ticas de Produ��o;\r\n- Inter-rela��es ambientais, econ�micas e sociais;\r\n- Ocupa��o da unidade de produ��o, e;\r\n- A��es que visam evitar contamina��es internas e externas.', 'S', NULL, 'Cadastrado em: 21/03/2017.\r\nRespons�vel: Eduardo Garrido (UAIT).', 'MANEJO', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('119', 'UAIT-00062-2017', 'Emiss�o de Certificado de Conformidade Org�nica, o qual permite a utiliza��o da marca e do selo da certificadora em embalagens e publicidade durante a validade do certificado, de 01 (um) ano.', 'S', NULL, 'Cadastrado em: 21/03/2017.\r\nRespons�vel: Eduardo Garrido (UAIT).', 'CERT CONF ORG', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('120', 'UAIT-00063-2017', 'Relat�rio de auditoria externa, contendo a assinatura do empres�rio.', 'S', NULL, 'Cadastrado em: 21/03/2017.\r\nRespons�vel: Eduardo Garrido (UAIT).', 'AUDITORIA EXT', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('121', 'UAIT-00064-2017', 'Manual Pr�tico de Boas Pr�ticas Agr�colas (BRA), com a descri��o dos principais processos da empresa.', 'S', NULL, 'Cadastrado em: 21/03/2017.\r\nRespons�vel: Eduardo Garrido (UAIT).', 'MANUAL BPA', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('122', 'UAIT-00065-2017', 'Documento do Relat�rio de Avalia��o de Exposi��o Ocupacional ao Ru�do, conforme diretrizes estabelecidas no Anexo 01 da NR 15 e na NHO 01 - Avalia��o da Exposi��o Ocupacional ao Ru�do (Fundacentro, 2001), contemplando no m�nimo: 1) Dados da empresa; 2) Introdu��o, incluindo objetivos do trabalho, justificativa e datas ou per�odos em que foram desenvolvidas as avalia��es; 3) Crit�rio de avalia��o adotado; 4) Instrumental utilizado; 5) Metodologia de avalia��o; 6) Descri��o das condi��es de exposi��o avaliadas; 7) Dados obtidos; 8) Interpreta��o dos resultados; 9) Conclus�o e recomenda��es; 10) Anexos: C�pia das fichas de campo e dos certificados de calibra��o do instrumental utilizado; e l)  assinatura do(s) profissional(is) de seguran�a respons�vel(is) pela elabora��o.', 'S', NULL, 'Cadastrado em: 21/03/2017.\r\nRespons�vel: Eduardo Garrido (UAIT).', 'RU�DO', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('123', 'UAIT-00066-2017', 'Documento do Relat�rio de Avalia��o de Exposi��o Ocupacional a Agentes Qu�micos, contendo: a) Dados da empresa; b) Introdu��o, incluindo objetivos do trabalho, justificativa e datas ou per�odos em que foram desenvolvidas as avalia��es quantitativas; c) Crit�rio de avalia��o adotado; d) Instrumental utilizado � materiais e equipamentos utilizados (tipo, marca e modelo de bombas e dispositivos de coleta); e) Metodologia de avalia��o (estrat�gia de coleta, m�todos de coleta e m�todos anal�ticos); f) Descri��o das situa��es de exposi��o avaliadas; g) Resultados obtidos; h) Interpreta��o dos resultados; i) Conclus�es e recomenda��es; j) Refer�ncias bibliogr�ficas; l) Anexos: Laudo das an�lises realizadas em laborat�rio, c�pias das fichas de campo e dos certificados de calibra��o do instrumental utilizado; m) assinatura do(s) profissional(is) de seguran�a respons�vel(is) pela elabora��o.', 'S', NULL, 'Cadastrado em: 22/03/2017.\r\nRespons�vel: Eduardo Garrido (UAIT).', 'QU�MICO', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('124', 'UAIT-00067-2017', 'Projeto baseado em brainstormings, pesquisas de refer�ncias, croquis, etc. da solu��o de inova��o proposta: incluindo sua conceitua��o e contextualiza��o para o desenvolvimento dos novos produtos.', 'S', NULL, 'Cadastrado em: 22/03/2017.\r\nRespons�vel: Eduardo Garrido (UAIT).', 'PROJ ETAPA 1', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('125', 'UAIT-00068-2017', 'Dossi� com registros hist�ricos da empresa, entrevistas, imagens (fotografias e v�deos) das etapas que abrangem o processo produtivo e produto existentes e indica��o de melhorias em processos e poss�vel inclus�o de servi�os suplementares aos produtos desenvolvidos pela empresa.', 'S', NULL, 'Cadastrado em: 22/03/2017.\r\nRespons�vel: Eduardo Garrido (UAIT).', 'DOSSI�', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('126', 'UAIT-00070-2017', 'Detalhamento t�cnico dos produtos em software adequado, com especifica��o de material, medidas, vistas, perspectivas e todo o dimensionamento pr�vio das pe�as a serem prototipadas.', 'S', NULL, 'Cadastrado em: 22/03/2017.\r\nRespons�vel: Eduardo Garrido (UAIT).', 'DET TEC', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('127', 'UAIT-00069-2017', 'Projeto de Cole��o de Moda, contendo: moodboard Mapa de Cen�rio, moodboard Tema da Cole��o, defini��o de cartela de cores, formas, texturas, mix de produtos e croquis.', 'S', NULL, 'Cadastrado em: 22/03/2017.\r\nRespons�vel: Eduardo Garrido (UAIT).', 'COLE��O ETAPA 2', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('128', 'UAIT-00071-2017', 'Registro de acompanhamento do processo de desenvolvimento das modelagens.', 'S', NULL, 'Cadastrado em: 22/03/2017.\r\nRespons�vel: Eduardo Garrido (UAIT).', 'REG MOD', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('129', 'UAIT-00072-2017', 'Registro de acompanhamento do processo de prototipagem das pe�as piloto.', 'S', NULL, 'Cadastrado em: 22/03/2017.\r\nRespons�vel: Eduardo Garrido (UAIT).', 'REG PROT', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('130', 'UAIT-00073-2017', 'Relat�rio contendo os desenhos t�cnicos dos produtos em PDF e impresso em meio f�sico, fotografias dos prot�tipos aprovados pelo cliente, bem como recomenda��es de melhorias nos processos e inclus�o de poss�veis servi�os suplementares aos produtos desenvolvidos.', 'S', NULL, 'Cadastrado em: 22/03/2017.\r\nRespons�vel: Eduardo Garrido (UAIT).', 'RELAT', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('131', 'UAIT-00074-2017', 'Relat�rio final em meio f�sico impresso e digital, contendo:\r\n1. Defini��o de Escopo do Projeto\r\n2. Reenquadramento � Examinar o Problema de Diferentes �ticas\r\n� Contato inicial consultor x empresa\r\n� Paradigmas da empresa\r\n� Concorrentes\r\n3. Identifica��o de Necessidades e Oportunidades\r\n� Swot\r\n� Pesquisa Desk\r\n� Entrevistas\r\n� Observa��o\r\n4. Utilizando M�todo AT-ONE � Colabora��o e Inova��o.\r\n� Atores envolvidos\r\n� TouchPoints (Ponto de contato)\r\n� Oferta do servi�o\r\n� Necessidades do cliente\r\n� Experi�ncias que surpreendem e encantam\r\n5. Identifica��o do Contexto dos Usu�rios/Atores, Ambientes e Ciclo de Vida.\r\n� Mapa de Empatia\r\n� Jornada do Usu�rio (servi�o existente/concorrentes)\r\n� Blue Print (servi�o existente/concorrentes)\r\nIdentifica��o de Crit�rios Norteadores\r\n6. Gera��o de Solu��o\r\n6.1. Constru��o/Revis�o da Proposta de Valor\r\n6.2. Propostas para Solu��es\r\n6.3. Constru��o do Processo Apreender, Utilizar e se Lembrar\r\n� Comunica��o\r\n� Sensibiliza��o\r\n� Aquisi��o\r\n� Evidencias f�sicas\r\n� P�s-servi�o\r\n� Retorno do cliente\r\n� A��es dos usu�rios\r\n� A��o de funcion�rios\r\n� Barreiras para a intera��o', 'S', NULL, 'Cadastrado em: 22/03/2017.\r\nRespons�vel: Eduardo Garrido (UAIT).', 'RELAT SERV', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('132', 'UAIT-00075-2017', 'Recibo de envio do formul�rio com n�mero do pedido junto ao INPI, n�mero do protocolo, data e hor�rio do protocolo, assim como as publica��es referentes a esse processo.', 'S', NULL, 'Cadastrado em: 22/03/2017.\r\nRespons�vel: Eduardo Garrido (UAIT).', 'RECIBO INPI', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('133', 'UAIT-00076-2017', 'Manual da Gest�o Ambiental com a descri��o de todos os processos da empresa e seus aspectos e impactos ambientais.', 'S', NULL, 'Cadastrado em: 22/03/2017.\r\nRespons�vel: Eduardo Garrido (UAIT).', 'MANUAL AMBIENTAL', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('134', 'UAIT-00077-2017', 'Documento do Invent�rio  de M�quinas e Equipamentos, conforme requisitos da NR 12, contendo assinatura do(s) profissional(is) de seguran�a respons�vel(is) pela elabora��o.', 'S', NULL, 'Cadastrado em: 22/03/2017.\r\nRespons�vel: Eduardo Garrido (UAIT).', 'INV MAQ EQUIP', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('135', 'UAIT-00078-2017', 'Documento do Plano de Adequa��o de M�quinas e Equipamentos, contendo a identifica��o das zonas de perigos das m�quinas, a an�lise de risco, medidas de adequa��o, cronograma com prioriza��o de a��es e assinatura do(s) profissional(is) de seguran�a respons�vel(is) pela elabora��o.', 'S', NULL, 'Cadastrado em: 22/03/2017.\r\nRespons�vel: Eduardo Garrido (UAIT).', 'PLAN ADEQ MAQ EQUIP', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('136', 'UAIT-00079-2017', 'Manual de Acredita��o com a descri��o de todos os processos da empresa.', 'S', NULL, 'Cadastrado em: 22/03/2017.\r\nRespons�vel: Eduardo Garrido (UAIT).', 'MANUAL ONA', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('137', 'UAIT-00080-2017', 'Memorial Econ�mico e Sanit�rio do Estabelecimento. \r\nO MESE � Memorial Econ�mico e Sanit�rio do Estabelecimento contempla: \r\n� Avalia��o dos m�veis e equipamentos.\r\n� �reas internas dos compartimentos e nomenclatura dos ambientes.\r\n� Especifica��o b�sica do material de acabamento.\r\n� Fluxograma de produ��o.\r\n� Memorial descritivo da produ��o.', 'S', NULL, 'Cadastrado em: 22/03/2017.\r\nRespons�vel: Eduardo Garrido (UAIT).', 'MESE', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('138', 'UAIT-00081-2017', 'Manual de Boas Pr�ticas de Fabrica��o. O Manual de Boas Pr�ticas de Fabrica��o indica as n�o conformidades a serem corrigidas pela empresa', 'S', NULL, 'Cadastrado em: 22/03/2017.\r\nRespons�vel: Eduardo Garrido (UAIT).', 'BPF', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('139', 'ARQUITET�NICO', 'Relat�rio t�cnico do projeto arquitet�nico.', 'S', NULL, 'Cadastrado em: 22/03/2017.\r\nRespons�vel: Eduardo Garrido (UAIT).', 'ARQUITET�NICO', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('140', 'UAIT-00082-2017', 'N� do Protocolo de entrada no �rg�o competente.', 'S', NULL, 'Cadastrado em: 22/03/2017.\r\nRespons�vel: Eduardo Garrido (UAIT).', 'PROTOCOLO', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('141', 'UAIT-00083-2017', 'Projeto arquitet�nico. Consiste na elabora��o do projeto arquitet�nico, a qual envolve a constru��o do projeto da unidade fabril solicitado pela ind�stria, com base nos requisitos levantados.', 'S', NULL, 'Cadastrado em: 22/03/2017.\r\nRespons�vel: Eduardo Garrido (UAIT).', 'ARQUITET�NICO', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('142', 'UAIT-00084-2017', 'Projeto T�cnico em c�pia impressa e meio eletr�nico contendo especifica��es suficientes para a produ��o de um prot�tipo funcional.\r\nO prot�tipo se configura como a produ��o concreta (f�sica ou digital) de projeto/modelo de produto ou servi�o. A prototipagem deve ter a finalidade de experimentar/testar algum aspecto do produto final (funcionalidade, formato, peso, aceitabilidade junto ao mercado, entre outros).\r\nO projeto de desenvolvimento do prot�tipo deve conter escopo, cronograma com os principais marcos de projeto, recursos humanos necess�rios (capacita��o, expertise de membros da equipe, necessidade de treinamento) e plano de mobiliza��o de recursos. Deve conter a avalia��o de riscos envolvidos no projeto e plano de resposta. Deve agregar todos os custos do projeto e distribuir no tempo com curva de desembolso e reservas. Deve conter o planejamento da qualidade (plano de qualidade contendo requisitos de avalia��o de qualidade estabelecidos, planilhas de coleta de dados, check-list, forma de medi��o, frequ�ncia, crit�rios de aceita��o). Deve conter o controle da qualidade com verifica��o se processos planejados est�o acontecendo conforme requisitos. Deve atentar � garantia da qualidade, com medi��o e tratamento dos desvios observados). Necess�rio apresentar as aquisi��es necess�rias de materiais e servi�os para execu��o do prot�tipo (local, servi�o, materiais, ferramentas e equipamentos de medi��o de desempenho). Planejar a comunica��o entre todos os envolvidos no projeto com base nos requisitos de comunica��o previamente estabelecidos (canal, frequ�ncia, tipo de informa��o, etc).', 'S', NULL, 'Cadastrado em: 22/03/2017.\r\nRespons�vel: Eduardo Garrido (UAIT).', 'PROJ TEC PROTOTIPO', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('143', 'UAIT-00085-2017', 'Prot�tipo em meio f�sico utilizando as escalas previamente estabelecidas.', 'S', NULL, 'Cadastrado em: 22/03/2017.\r\nRespons�vel: Eduardo Garrido (UAIT).', 'PROTOTIPO FISICO', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('144', 'UAIT-00086-2017', 'Laudo apresentando resultados do testes de desempenho e avalia��o de resultados em conformidade com os requisitos estabelecidos de desempenho e custos.', 'S', NULL, 'Cadastrado em: 22/03/2017.\r\nRespons�vel: Eduardo Garrido (UAIT).', 'LAUDO PROT�TIPO', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('145', 'UAIT-00087-2017', 'Relat�rio impresso com as devidas an�lises, explica��es e orienta��es ao empres�rio, incluindo os itens abaixo:\r\n� hist�rico;\r\n� caracter�sticas do p�blico-alvo atual e �rea geogr�fica de abrang�ncia desejada;\r\n� produtos/servi�os oferecidos e os desejados para venda atrav�s de E-commerce;\r\n� conhecimento e descri��o da estrutura f�sica;\r\n� aspectos legais e tribut�rios;\r\n� tecnologia a ser utilizada;\r\n� dom�nio / hospedagem e demais custos envolvidos;\r\n� identidade visual e a import�ncia do registro da marca;\r\n� embalagem;\r\n� fotografias dos produtos/servi�os;\r\n� conhecimento e descri��o dos produtos/servi�os;\r\n� capacidade produtiva;\r\n� estoque;\r\n� log�stica e distribui��o;\r\n� frete;\r\n� forma��o de pre�o;\r\n� utiliza��o de meios eletr�nicos para pagamento;\r\n� canais de comunica��o com o cliente;\r\n� divulga��o e promo��o;\r\n� afinidade do empres�rio com rela��o � tecnologia;\r\n� utiliza��o de ferramentas web e m�dias sociais;\r\n� parcerias;\r\n� recursos humanos;\r\n� recursos financeiros e investimentos;\r\n� An�lise de viabilidade da implanta��o do E-commerce;\r\n� Indica��o de quais produtos/servi�os est�o adequados ao E-commerce;\r\n� Indica��o de qual formato (venda direta ou exposi��o de produtos/servi�os) melhor se adequa � realidade da empresa;\r\n� Orienta��es de melhorias;\r\n� Sugest�es e considera��es relevantes para a empresa.', 'S', NULL, 'Cadastrado em: 22/03/2017.\r\nRespons�vel: Eduardo Garrido (UAIT).', 'DIAGN�STICO E-COMMERCE', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('146', 'UAIT-00088-2017', 'Projeto do Website, sob o formato de Relat�rio com Layout e Especifica��es T�cnicas para embasar o desenvolvimento do site institucional.', 'S', NULL, 'Cadastrado em: 22/03/2017.\r\nRespons�vel: Eduardo Garrido (UAIT).', 'PROJETO WEBSITE', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('148', 'UAIT-00089-2017', 'Laudo T�cnico das an�lises laboratoriais.', 'S', NULL, 'Cadastrado em: 23/03/2017.\r\nRespons�vel: Eduardo Garrido (UAIT).', 'LAUDO LAB', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('149', 'UAIT-00090-2017', 'Projeto de instala��o predial de �guas pluviais.', 'S', NULL, '�gua pluvial: �gua de chuva.\r\nCadastrado em: 23/03/2017.\r\nRespons�vel: Eduardo Garrido (UAIT).', '�GUAS PLUVIAIS', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('150', 'UAIT-00091-2017', 'Projeto do sistema de coleta e tratamento dos efluentes.', 'S', NULL, 'Efluente: res�duo l�quido resultante de processos.\r\nCadastrado em: 23/03/2017.\r\nRespons�vel: Eduardo Garrido (UAIT).', 'EFLUENTE', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('151', 'UAIT-00092-2017', 'Projeto de Efici�ncia Energ�tica. O Projeto de Efici�ncia Energ�tica conter� as prioridades definidas conjuntamente entre empres�rio e consultor, com respectivo projeto, plano de a��o, respons�veis e prazo. Este documento pode se converter em uma ferramenta de controle e acompanhamento do servi�o quando de sua implementa��o.', 'S', NULL, 'Cadastrado em: 23/03/2017.\r\nRespons�vel: Eduardo Garrido (UAIT).', 'EFICI�NCIA ENERG�TICA', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('152', 'UAIT-00093-2017', 'O diagn�stico energ�tico apresentar� ao empres�rio a situa��o da sua empresa e os poss�veis focos de atua��o para otimiza��o do uso de energia. O consultor far� o estudo e acompanhamento do processo produtivo, levantamento de cargas, mapeamento energ�tico e luminot�cnica. Com base neste documento, o empres�rio e o consultor definir�o a prioridade das a��es, gerando o Plano de Trabalho.', 'S', NULL, 'Cadastrado em: 23/03/2017.\r\nRespons�vel: Eduardo Garrido (UAIT).', 'DIAGN�STICO ENERG�TICO', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('154', 'UAIT-00094-2017', 'Plano de a��o com os encaminhamentos e atividades relacionadas a etapa.', 'S', NULL, 'Cadastrado em: 23/03/2017.\r\nRespons�vel: Eduardo Garrido (UAIT).', 'PLANO DE A��O', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('155', 'UAIT-00095-2017', 'Relat�rio de Final de Servi�o demonstrando os avan�os com as atividades acompanhadas e implementadas durante o atendimento.', 'S', NULL, 'Cadastrado em: 23/03/2017.\r\nRespons�vel: Eduardo Garrido (UAIT).', 'RELAT�RIO FINAL', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('156', 'UAIT-00096-2017', 'Relat�rio t�cnico com informa��es do produto padronizado.', 'S', NULL, 'Cadastrado em: 23/03/2017.\r\nRespons�vel: Eduardo Garrido (UAIT).', 'RELAT�RIO PAD 1', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('157', 'UAIT-00097-2017', 'Relat�rio final contemplando Indicadores do Estado Presente e Futuro; Descri��o das oportunidades de melhoria e interven��es realizadas; Produtividade alcan�ada.', 'S', NULL, 'Cadastrado em: 23/03/2017.\r\nRespons�vel: Eduardo Garrido (UAIT).', 'RELAT�RIO PAD 2', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('158', 'UAIT-00098-2017', 'Relat�rio contendo descri��o dos servi�os desenvolvidos acerca de: Estado Presente; Impressora Offset devidamente regulada; Defini��o das a��es de melhoria.', 'S', NULL, 'Cadastrado em: 23/03/2017.\r\nRespons�vel: Eduardo Garrido (UAIT).', 'GR�FICA 1', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('159', 'UAIT-00099-2017', 'Relat�rio contendo descri��o dos servi�os desenvolvidos acerca de: Ajustes no Processo; Efetiva��o juntamente com a equipe.', 'S', NULL, 'Cadastrado em: 23/03/2017.\r\nRespons�vel: Eduardo Garrido (UAIT).', 'GR�FICA 2', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('160', 'UAIT-00100-2017', 'Relat�rio contendo descri��o dos servi�os desenvolvidos acerca de: Cria��o do Mapa de Aloca��o de Custos Indiretos (RKW) parametrizado com a produ��o; Defini��o do Valor/ hora dos Centros de Custos; Corre��o no processo de or�amenta��o.', 'S', NULL, 'Cadastrado em: 23/03/2017.\r\nRespons�vel: Eduardo Garrido (UAIT).', 'GR�FICA 3', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('161', 'UAIT-00101-2017', 'Relat�rio contendo descri��o dos servi�os desenvolvidos acerca de: Produ��o e Clientes mapeados, fornecendo ao empres�rio uma vis�o aprofundada do seu neg�cio; Estrat�gias focadas em vendas; Melhor otimiza��o do parque produtivo;  Aumento da intelig�ncia do neg�cio gr�fico.', 'S', NULL, 'Cadastrado em: 23/03/2017.\r\nRespons�vel: Eduardo Garrido (UAIT).', 'GR�FICA 4', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('162', 'UAIT-00102-2017', 'Relat�rio de Consultoria para cada etapa, descrevendo todo o servi�o prestado, sua metodologia, indica��es, orienta��es e considera��es para que a empresa tome as devidas provid�ncias.', 'S', NULL, 'Cadastrado em: 23/03/2017.\r\nRespons�vel: Eduardo Garrido (UAIT).', 'GR�FICA 5', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('163', 'UAIT-00103-2017', 'Plano de manuten��o do equipamento, com todas as informa��es necess�rias para o planejamento, execu��o e controle da manuten��o.', 'S', NULL, 'Cadastrado em: 23/03/2017.\r\nRespons�vel: Eduardo Garrido (UAIT).', 'PLANO DE MANUT', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('164', 'UAIT-99999-2017', 'Coringa.', 'S', NULL, 'Cadastrado em: 23/03/2017.\r\nRespons�vel: Eduardo Garrido (UAIT).', 'CORINGA', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '1', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('165', 'UAIT-00104-2017', 'Plano de Trabalho.', 'S', NULL, 'Cadastrado em: 30/03/2017.\r\nRespons�vel: Eduardo Garrido (UAIT).', 'PLANO DE TRABALHO', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('166', 'UAIT-00105-2017', 'Certificado UTZ.', 'S', NULL, 'Cadastrado em: 03/04/2017.\r\nRespons�vel: Eduardo Garrido (UAIT).', 'CERT UTZ', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('167', 'UAIT-00106-2017', 'Lista de Presen�a.', 'S', NULL, 'Cadastrado em: 04/04/2017.\r\nRespons�vel: Eduardo Garrido (UAIT).', 'PRESEN�A', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('168', 'UAIT-00107-2017', 'Formul�rio de Satisfa��o do Cliente.', 'S', NULL, 'Cadastrado em: 04/04/2017.\r\nRespons�vel: Eduardo Garrido (UAIT).', 'SATISFA��O', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('169', 'UAIT-00108-2017', 'Relat�rio Final contendo, quando poss�vel:\r\na) Conclus�es acerca da aptid�o de implementa��o da inova��o ou tecnologia na empresa participante;\r\nb) An�lise individual quanto a possibilidade de aplica��o do conte�do no dia a dia da empresa;\r\nc) Percentual de clientes com avalia��o positiva quanto � aptid�o de implementa��o da inova��o ou tecnologia demonstrada;\r\nd) Potenciais verificados para a empresa no que tange os produtos SEBRAE.', 'S', NULL, 'Cadastrado em: 04/04/2017.\r\nRespons�vel: Eduardo Garrido (UAIT).', 'RELAT�RIO CONCLUS�O', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('170', 'UAIT-00109-2017', 'C�pia dos slides apresentados aos empres�rios.', 'S', NULL, 'Cadastrado em: 04/04/2017.\r\nRespons�vel: Eduardo Garrido (UAIT).', 'SLIDES', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');

  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('58', '8');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('58', '24');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('58', '55');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('59', '1');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('59', '8');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('59', '14');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('59', '24');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('59', '25');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('59', '55');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('60', '1');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('60', '8');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('60', '14');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('60', '24');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('60', '25');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('60', '55');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('61', '1');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('61', '8');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('61', '14');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('61', '24');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('61', '25');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('61', '55');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('62', '1');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('62', '6');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('62', '8');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('62', '14');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('62', '24');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('62', '25');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('62', '55');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('63', '1');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('63', '6');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('63', '8');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('63', '14');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('63', '24');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('63', '25');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('63', '55');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('64', '1');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('64', '6');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('64', '8');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('64', '14');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('64', '24');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('64', '25');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('64', '55');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('65', '1');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('65', '6');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('65', '8');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('65', '14');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('65', '24');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('65', '25');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('65', '55');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('66', '5');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('66', '16');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('66', '18');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('66', '20');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('66', '21');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('67', '8');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('67', '24');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('67', '55');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('68', '1');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('68', '8');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('68', '14');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('68', '24');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('68', '25');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('68', '55');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('69', '8');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('69', '24');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('69', '55');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('70', '1');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('70', '6');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('70', '8');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('70', '14');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('70', '24');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('70', '25');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('70', '55');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('71', '1');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('71', '6');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('71', '8');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('71', '14');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('71', '24');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('71', '25');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('71', '55');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('72', '8');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('72', '24');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('72', '55');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('73', '1');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('73', '6');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('73', '8');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('73', '14');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('73', '24');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('73', '25');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('73', '55');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('74', '8');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('74', '24');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('74', '55');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('75', '1');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('75', '6');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('75', '8');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('75', '14');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('75', '24');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('75', '25');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('75', '55');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('76', '1');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('76', '6');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('76', '8');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('76', '14');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('76', '24');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('76', '25');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('76', '55');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('77', '1');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('77', '6');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('77', '8');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('77', '14');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('77', '24');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('77', '25');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('77', '55');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('78', '1');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('78', '6');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('78', '8');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('78', '14');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('78', '24');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('78', '25');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('78', '55');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('79', '1');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('79', '6');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('79', '8');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('79', '14');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('79', '24');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('79', '25');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('79', '55');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('80', '8');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('80', '24');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('80', '55');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('81', '8');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('81', '24');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('81', '55');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('82', '1');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('82', '6');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('82', '8');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('82', '14');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('82', '24');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('82', '25');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('82', '55');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('83', '1');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('83', '8');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('83', '14');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('83', '24');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('83', '55');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('84', '8');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('84', '24');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('84', '55');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('85', '1');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('85', '6');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('85', '8');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('85', '14');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('85', '24');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('85', '25');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('85', '55');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('86', '1');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('86', '6');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('86', '8');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('86', '14');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('86', '24');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('86', '25');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('86', '55');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('87', '1');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('87', '6');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('87', '8');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('87', '14');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('87', '24');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('87', '25');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('87', '55');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('88', '1');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('88', '6');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('88', '8');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('88', '14');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('88', '24');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('88', '25');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('88', '55');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('89', '8');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('89', '24');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('89', '55');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('90', '8');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('90', '24');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('90', '55');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('91', '1');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('91', '6');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('91', '8');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('91', '14');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('91', '24');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('91', '25');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('91', '55');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('92', '1');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('92', '6');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('92', '8');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('92', '14');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('92', '24');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('92', '25');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('92', '55');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('93', '8');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('93', '24');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('93', '55');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('94', '8');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('94', '24');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('94', '55');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('95', '1');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('95', '6');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('95', '8');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('95', '14');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('95', '24');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('95', '25');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('95', '55');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('96', '8');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('96', '24');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('96', '55');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('97', '1');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('97', '6');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('97', '8');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('97', '14');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('97', '24');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('97', '25');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('97', '55');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('98', '1');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('98', '6');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('98', '8');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('98', '14');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('98', '24');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('98', '25');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('98', '55');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('99', '8');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('99', '24');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('99', '55');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('100', '8');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('100', '24');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('100', '55');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('101', '8');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('101', '24');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('101', '55');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('102', '8');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('102', '24');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('102', '55');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('103', '8');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('103', '24');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('103', '55');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('104', '1');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('104', '6');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('104', '8');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('104', '14');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('104', '24');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('104', '25');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('104', '55');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('105', '1');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('105', '8');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('105', '14');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('105', '55');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('106', '8');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('106', '24');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('106', '55');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('107', '8');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('107', '24');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('107', '55');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('108', '8');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('108', '24');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('108', '55');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('109', '8');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('109', '24');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('109', '55');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('110', '8');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('110', '24');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('110', '55');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('111', '8');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('111', '24');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('111', '55');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('112', '8');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('112', '24');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('112', '55');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('113', '8');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('113', '24');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('113', '55');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('114', '8');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('114', '24');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('114', '55');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('115', '8');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('115', '24');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('115', '55');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('116', '8');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('116', '24');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('116', '55');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('117', '8');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('117', '24');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('117', '55');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('118', '8');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('118', '24');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('118', '55');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('119', '1');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('119', '6');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('119', '8');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('119', '14');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('119', '24');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('119', '25');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('119', '55');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('120', '8');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('120', '24');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('120', '55');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('121', '8');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('121', '24');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('121', '55');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('122', '8');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('122', '24');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('122', '55');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('123', '8');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('123', '24');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('123', '55');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('124', '8');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('124', '24');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('124', '55');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('125', '8');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('125', '24');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('125', '55');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('126', '8');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('126', '24');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('126', '55');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('127', '8');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('127', '24');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('127', '55');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('128', '8');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('128', '24');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('128', '55');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('129', '8');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('129', '24');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('129', '55');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('130', '8');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('130', '24');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('130', '55');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('131', '8');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('131', '24');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('131', '55');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('132', '8');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('132', '24');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('132', '55');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('133', '8');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('133', '24');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('133', '55');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('134', '8');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('134', '24');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('134', '55');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('135', '8');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('135', '24');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('135', '55');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('136', '8');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('136', '24');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('136', '55');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('137', '8');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('137', '24');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('137', '55');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('138', '8');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('138', '24');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('138', '55');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('139', '8');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('139', '24');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('139', '55');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('140', '1');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('140', '6');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('140', '8');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('140', '14');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('140', '24');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('140', '25');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('140', '55');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('141', '8');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('141', '24');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('141', '55');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('142', '8');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('142', '24');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('142', '55');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('143', '8');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('143', '24');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('143', '55');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('144', '8');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('144', '24');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('144', '55');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('145', '8');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('145', '24');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('145', '55');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('146', '8');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('146', '24');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('146', '55');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('148', '1');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('148', '6');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('148', '8');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('148', '14');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('148', '24');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('148', '25');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('148', '55');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('149', '8');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('149', '24');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('149', '55');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('150', '8');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('150', '24');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('150', '55');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('151', '8');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('151', '24');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('151', '55');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('152', '8');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('152', '24');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('152', '55');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('154', '8');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('154', '24');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('154', '55');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('155', '8');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('155', '24');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('155', '55');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('156', '8');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('156', '24');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('156', '55');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('157', '8');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('157', '24');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('157', '55');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('158', '8');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('158', '24');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('158', '55');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('159', '8');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('159', '24');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('159', '55');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('160', '8');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('160', '24');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('160', '55');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('161', '8');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('161', '24');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('161', '55');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('162', '8');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('162', '24');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('162', '55');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('163', '8');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('163', '24');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('163', '55');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('164', '24');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('165', '8');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('165', '24');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('165', '55');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('166', '1');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('166', '6');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('166', '8');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('166', '14');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('166', '24');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('166', '25');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('166', '55');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('167', '1');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('167', '6');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('167', '8');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('167', '14');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('167', '24');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('167', '25');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('167', '55');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('168', '1');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('168', '8');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('168', '14');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('168', '24');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('168', '25');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('168', '55');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('169', '8');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('169', '24');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('169', '55');
  INSERT INTO `db_pir_gec`.`gec_documento_tipo_arquivo` (`idt`, `idt_tipo_arquivo`) VALUES ('170', '24');
 */

// Banco Origem
$host_ip_origem = '10.6.14.40';
$bd_user_origem = 'lupe'; // Login do Banco
$password_origem = 'my$ql$sebraeh'; // Senha de acesso ao Banco
$host_origem = $tipodb . ':host=' . $host_ip_origem . ';dbname=db_pir_grc;port=3308';
$con_origem = new_pdo($host_origem, $bd_user_origem, $password_origem, $tipodb, false);

// Banco Destino
$host_ip_destino = '10.6.14.15';
$bd_user_destino = 'lupe'; // Login do Banco
$password_destino = 'my$ql$sebrae'; // Senha de acesso ao Banco
$host_destino = $tipodb . ':host=' . $host_ip_destino . ';dbname=db_pir_grc;port=3306';
$con_destino = new_pdo($host_destino, $bd_user_destino, $password_destino, $tipodb, false);

beginTransaction($con_destino);

$vetEntidade = Array();

$vetTabelaMigracao = Array(
    Array(
        "tabela" => "grc_insumo_dimensionamento",
        "where" => "",
        "tabelaNova" => true,
        "chave" => 'idt'
    ),
    Array(
        "tabela" => db_pir_gec . "gec_programa_grc_programa",
        "where" => "",
        "tabelaNova" => true,
        "chave" => 'idt'
    ),
);

//limpaTabela();
//copiaTabelaNova();

//Vetor da ordem de copia da Produto
$vetTabelaProduto = Array();
$vetTabelaProduto['grc_produto'] = vetCopia('grc_produto', 'idt', false);
$vetTabelaProduto['grc_produto_realizador'] = vetCopia('grc_produto', 'idt_produto', false);
$vetTabelaProduto['grc_produto_conteudo_programatico'] = vetCopia('grc_produto', 'idt_produto', false);
$vetTabelaProduto['grc_produto_produto'] = vetCopia('grc_produto', 'idt_produto', false);
$vetTabelaProduto['grc_produto_profissional'] = vetCopia('grc_produto', 'idt_produto', false);
$vetTabelaProduto['grc_produto_arquivo_associado'] = vetCopia('grc_produto', 'idt_produto', false);
$vetTabelaProduto['grc_produto_area_conhecimento'] = vetCopia('grc_produto', 'idt_produto', false);
$vetTabelaProduto['grc_produto_entrega'] = vetCopia('grc_produto', 'idt_produto', false);
$vetTabelaProduto['grc_produto_entrega_documento'] = vetCopia('grc_produto_entrega', 'idt_produto_entrega', false);
$vetTabelaProduto['grc_produto_unidade_regional'] = vetCopia('grc_produto', 'idt_produto', false);
$vetTabelaProduto['grc_produto_versao'] = vetCopia('grc_produto', 'idt_produto', false);
$vetTabelaProduto['grc_produto_insumo'] = vetCopia('grc_produto', 'idt_produto', false);
$vetTabelaProduto['grc_produto_dimensionamento'] = vetCopia('grc_produto', 'idt_produto', false);
$vetTabelaProduto['grc_produto_publico_alvo'] = vetCopia('grc_produto', 'idt', false);
$vetTabelaProduto['grc_produto_ocorrencia'] = vetCopia('grc_produto', 'idt_produto', false);
$vetTabelaProduto[db_pir_gec . 'gec_entidade_produto'] = vetCopia('grc_produto', 'idt_produto', false);

$sql = "";
$sql .= " select idt";
$sql .= " from grc_produto";
$sql .= " where reg_treina = 'S' ";
//$sql .= " and temporario = 'N' ";
$sql .= " and codigo = 'BA00000002354'";

/*
$sql .= "
AND CONCAT_WS('/', codigo, copia) IN (
	'BA00000002192/0',
	'BA00000002193/0',
	'BA00000002194/0',
	'BA00000002195/0',
	'BA00000002196/0',
	'BA00000002197/0',
	'BA00000002198/0',
	'BA00000002199/0',
	'BA00000002200/0',
	'BA00000002201/0',
	'BA00000002202/0',
	'BA00000002203/0',
	'BA00000002204/0',
	'BA00000002206/0',
	'BA00000002207/0',
	'BA00000002208/0',
	'BA00000002209/0',
	'BA00000002210/0',
	'BA00000002211/0',
	'BA00000002212/0',
	'BA00000002213/0',
	'BA00000002214/0',
	'BA00000002215/0',
	'BA00000002216/0',
	'BA00000002217/0',
	'BA00000002218/0',
	'BA00000002219/0',
	'BA00000002220/0',
	'BA00000002221/0',
	'BA00000002222/0',
	'BA00000002223/0',
	'BA00000002224/0',
	'BA00000002225/0',
	'BA00000002226/0',
	'BA00000002227/0',
	'BA00000002228/0',
	'BA00000002230/0',
	'BA00000002231/0',
	'BA00000002232/0',
	'BA00000002233/0',
	'BA00000002235/0',
	'BA00000002236/0',
	'BA00000002237/0',
	'BA00000002238/0',
	'BA00000002239/0',
	'BA00000002241/0',
	'BA00000002242/0',
	'BA00000002243/0',
	'BA00000002245/0',
	'BA00000002246/0',
	'BA00000002247/0',
	'BA00000002249/0',
	'BA00000002250/0',
	'BA00000002251/0',
	'BA00000002252/0',
	'BA00000002253/0',
	'BA00000002254/0',
	'BA00000002255/0',
	'BA00000002256/0',
	'BA00000002261/0',
	'BA00000002262/0',
	'BA00000002263/0',
	'BA00000002264/0',
	'BA00000002265/0',
	'BA00000002266/0',
	'BA00000002267/0',
	'BA00000002269/0',
	'BA00000002270/0',
	'BA00000002271/0',
	'BA00000002272/0',
	'BA00000002273/0',
	'BA00000002274/0',
	'BA00000002275/0',
	'BA00000002277/0',
	'BA00000002278/0',
	'BA00000002279/0',
	'BA00000002280/0',
	'BA00000002281/0',
	'BA00000002282/0',
	'BA00000002283/0',
	'BA00000002284/0',
	'BA00000002285/0',
	'BA00000002286/0',
	'BA00000002287/0',
	'BA00000002288/0',
	'BA00000002289/0',
	'BA00000002290/0',
	'BA00000002291/0',
	'BA00000002292/0',
	'BA00000002293/0',
	'BA00000002294/0',
	'BA00000002295/0',
	'BA00000002298/0',
	'BA00000002299/0',
	'BA00000002300/0',
	'BA00000002301/0',
	'BA00000002302/0',
	'BA00000002303/0',
	'BA00000002305/0',
	'BA00000002306/0',
	'BA00000002309/0',
	'BA00000002310/0',
	'BA00000002311/0',
	'BA00000002312/0',
	'BA00000002313/0',
	'BA00000002314/0',
	'BA00000002316/0',
	'BA00000002317/0',
	'BA00000002318/0',
	'BA00000002319/0',
	'BA00000002320/0',
	'BA00000002321/0',
	'BA00000002322/0',
	'BA00000002323/0',
	'BA00000002324/0',
	'BA00000002325/0',
	'BA00000002326/0',
	'BA00000002327/0',
	'BA00000002328/0',
	'BA00000002329/0',
	'BA00000002330/0',
	'BA00000002331/0',
	'BA00000002332/0',
	'BA00000002333/0',
	'BA00000002334/0',
	'BA00000002335/0',
	'BA00000002336/0',
	'BA00000002337/0',
	'BA00000002338/0',
	'BA00000002339/0',
	'BA00000002340/0',
	'BA00000002341/0',
	'BA00000002342/0',
	'BA00000002343/0',
	'BA00000002344/0',
	'BA00000002345/0',
	'BA00000002346/0',
	'BA00000002347/0',
	'BA00000002348/0',
	'BA00000002349/0',
	'BA00000002350/0',
	'BA00000002351/0',
	'BA00000002352/0',
	'BA00000002353/0',
	'BA00000002355/0',
	'BA00000002356/0',
	'BA00000002357/0',
	'BA00000002358/0',
	'BA00000002359/0',
	'BA00000002360/0',
	'BA00000002361/0',
	'BA00000002362/0',
	'BA00000002363/0',
	'BA00000002364/0',
	'BA00000002367/0',
	'BA00000002368/0',
	'BA00000002369/0',
	'BA00000002370/0',
	'BA00000002371/0',
	'BA00000002372/0',
	'BA00000002373/0',
	'BA00000002374/0',
	'BA00000002375/0',
	'BA00000002376/0',
	'BA00000002377/0',
	'BA00000002378/0',
	'BA00000002379/0',
	'BA00000002380/0',
	'BA00000002381/0',
	'BA00000002382/0'
)
";
*/

$rs = execsql($sql, true, $con_origem);

if ($rs->rows > 0) {
    echo 'Base Limpa <br/>';
    echo 'Iniciando Copia dos produtos em treinamento...<br/>';
    foreach ($rs->data as $row) {
        inserirProdutoDestino($row['idt']);
    }
}

echo '......................................<br/>';
echo 'Fim Copia dos produtos em treinamento <br/>';

//rollBack($con_destino);
commit($con_destino);

echo 'Conclu�do...';

/**
 * Copia dados para tabela nova
 * @access public
 * */
function copiaTabelaNova() {
    global $vetTabelaMigracao, $con_origem, $con_destino;

    echo 'Limpando Tabelas B�sicas<br/>';

    echo 'Copiando Tabelas<br/>';

    foreach ($vetTabelaMigracao as $tabela) {
        set_time_limit(30);

        // Obter dados da tabela
        $sql = '';
        $sql .= ' select *';
        $sql .= ' from ' . $tabela['tabela'];
        $sql .= ' where 1=1';

        if (!empty($tabela['where'])) {
            $sql .= ' and ' . $tabela['where'];
        }

        $rs = execsql($sql, true, $con_origem);

        if ($rs->rows > 0) {
            $campos = $rs->info['name'];

            foreach ($rs->data as $row) {
                $vetVL = Array();

                foreach ($campos as $col) {
                    $vetVL[$col] = aspa($row[$col]);
                }

                if ($tabela['tabelaNova']) {
                    $sql = 'insert into ' . $tabela['tabela'] . ' (' . implode(', ', $campos) . ') values (' . implode(', ', $vetVL) . ')';
                    execsql($sql, true, $con_destino);
                } else {

                    // Retirando campo chave do insert
                    unset($campos[0]);
                    unset($vetVL[$tabela['chave']]);

                    $sql = 'insert into ' . $tabela['tabela'] . ' (' . implode(', ', $campos) . ') values (' . implode(', ', $vetVL) . ')';
                    execsql($sql, true, $con_destino);
                }
            }
        }
    }
}

/**
 * Fun��o auxilixar para a fun��o cria_rascunho_produto
 * @access public
 * @return array
 * @param string $tabela_pai <p>
 * Nome da tabela pai
 * </p>
 * @param string $campo_pai <p>
 * Campo que faz a liga��o com a tabela pai
 * </p>
 * @param boolean $tem_idt_produto <p>
 * Tem o campo idt_produto
 * </p>
 * */
function vetCopia($tabela_pai, $campo_pai, $tem_idt_produto) {
    $vet = Array();

    $vet['tabela_pai'] = $tabela_pai;
    $vet['campo_pai'] = $campo_pai;
    $vet['tem_idt_produto'] = $tem_idt_produto;

    return $vet;
}

/**
 * Limpa a tabelas para teste
 * @access public
 * */
function limpaTabela() {
    global $con_destino;

    $sql = '';
    $sql .= ' delete from grc_insumo_dimensionamento';
    execsql($sql, true, $con_destino);

    $sql = '';
    $sql .= ' ALTER TABLE grc_insumo_dimensionamento AUTO_INCREMENT = 1;';
    execsql($sql, true, $con_destino);

    $sql = '';
    $sql .= ' delete from ' . db_pir_gec . 'gec_programa_grc_programa';
    execsql($sql, true, $con_destino);

    $sql = '';
    $sql .= ' ALTER TABLE  ' . db_pir_gec . 'gec_programa_grc_programa AUTO_INCREMENT = 1;';
    execsql($sql, true, $con_destino);
}

/**
 * Inserir Produto encontrado na antiga base
 * @access public
 * @return int|string Retorna o IDT do registro de rascunho criado ou uma mensagem de erro
 * @param int $idt_produto <p>
 * IDT da Produto
 * </p>
 * */
function inserirProdutoDestino($idt_produto) {
    global $vetTabelaProduto, $con_origem, $con_destino, $vetEntidade;

    $vetIDT = Array();
    $vetIDT['grc_produto'][$idt_produto] = '';

    foreach ($vetTabelaProduto as $tabela => $coluna) {
        $lst = array_keys($vetIDT[$coluna['tabela_pai']]);

        if (is_array($lst)) {

            $sql = '';
            $sql .= ' select *';
            $sql .= ' from ' . $tabela;
            $sql .= ' where ' . $coluna['campo_pai'] . ' in (' . implode(', ', $lst) . ')';

            if ($coluna['tem_idt_produto']) {
                $sql .= ' and idt_produto = ' . null($idt_produto);
            }

            $rs = execsql($sql, true, $con_origem);

            if ($rs->rows > 0) {
                $campos = $rs->info['name'];

                if ($tabela != 'grc_produto_publico_alvo') {
                    $campos = array_flip($campos);
                    unset($campos['idt']);
                    $campos = array_flip($campos);
                }

                foreach ($rs->data as $row) {
                    $vetVL = Array();

                    foreach ($campos as $col) {
                        $vetVL[$col] = aspa($row[$col]);
                    }

                    if (array_key_exists($coluna['campo_pai'], $vetVL)) {
                        $vetVL[$coluna['campo_pai']] = aspa($vetIDT[$coluna['tabela_pai']][$row[$coluna['campo_pai']]]);
                    }

                    if ($coluna['tem_idt_produto']) {
                        $vetVL['idt_produto'] = aspa($vetIDT['grc_produto'][$row['idt_produto']]);
                    }

                    switch ($tabela) {
                        case 'grc_produto':
                            $treina_campo = array_search('reg_treina', $campos);
                            $treina_valor = array_search($vetVL['reg_treina'], $vetVL);

                            if ($treina_campo || $treina_valor) {
                                unset($campos[$treina_campo]);
                                unset($vetVL[$treina_valor]);
                            }
                            break;

                        case 'grc_produto_insumo':
                            $vetVL['idt_produto_profissional'] = aspa($vetIDT['grc_produto_profissional'][$row['idt_produto_profissional']]);
                            break;

                        case db_pir_gec . 'gec_entidade_produto':
                            if ($vetEntidade[$row['idt_entidade']]['idt'] == '') {
                                $sql = '';
                                $sql .= ' select codigo';
                                $sql .= ' from ' . db_pir_gec . 'gec_entidade';
                                $sql .= ' where idt = ' . null($row['idt_entidade']);
                                $rse = execsql($sql, true, $con_origem);

                                $vetEntidade[$row['idt_entidade']]['obs'] = 'CNPJ: ' . $rse->data[0][0];

                                $sql = '';
                                $sql .= ' select idt';
                                $sql .= ' from ' . db_pir_gec . 'gec_entidade';
                                $sql .= ' where codigo = ' . aspa($rse->data[0][0]);
                                $sql .= " and reg_situacao = 'A'";
                                $rse = execsql($sql, true, $con_destino);

                                $vetEntidade[$row['idt_entidade']]['idt'] = $rse->data[0][0];
                            }

                            $vetVL['idt_entidade'] = null($vetEntidade[$row['idt_entidade']]['idt']);
                            $vetVL['observacao'] = aspa($vetEntidade[$row['idt_entidade']]['obs']);
                            break;
                    }

                    $sql = 'insert into ' . $tabela . ' (' . implode(', ', $campos) . ') values (' . implode(', ', $vetVL) . ')';
                    execsql($sql, true, $con_destino);
                    $vetIDT[$tabela][$row['idt']] = lastInsertId('', $con_destino);
                }
            }
        }
    }

    $idt_produto_novo = $vetIDT['grc_produto'][$idt_produto];

    return $idt_produto_novo;
}
