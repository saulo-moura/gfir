<?php
require_once '../configuracao.php';

/*
  Executar no Banco de Produção Antes de Migrar

  INSERT INTO `db_pir_grc`.`grc_insumo_unidade` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`) VALUES ('40', 'Área', 'm²', 'S', 'Área em m² (metros quadrados).\r\nCadastrado em: 17/03/2017.\r\nResponsável: Eduardo Garrido (UAIT).');
  INSERT INTO `db_pir_grc`.`grc_insumo_unidade` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`) VALUES ('41', 'Projeto', 'Projeto de Design', 'S', 'Cadastrado em: 17/03/2017.\r\nResponsável: Eduardo Garrido (UAIT).');
  INSERT INTO `db_pir_grc`.`grc_insumo_unidade` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`) VALUES ('42', 'Marca', 'Marca', 'S', 'Cadastrado em: 17/03/2017.\r\nResponsável: Eduardo Garrido (UAIT).');
  INSERT INTO `db_pir_grc`.`grc_insumo_unidade` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`) VALUES ('43', 'Peça', 'Peça', 'S', 'Cadastrado em: 17/03/2017.\r\nResponsável: Eduardo Garrido (UAIT).');
  INSERT INTO `db_pir_grc`.`grc_insumo_unidade` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`) VALUES ('44', 'EVTE', 'EVTE', 'S', 'EVTE: Estudo de Viabilidade Te&#769;cnica e Econo&#770;mica.\r\nCadastrado em: 17/03/2017.\r\nResponsável: Eduardo Garrido (UAIT).');
  INSERT INTO `db_pir_grc`.`grc_insumo_unidade` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`) VALUES ('45', 'Gravidez da vaca', 'Prenhez', 'S', 'Prenhez: Condição da fêmea que se encontra no período de gestação; gravidez. \r\nCadastrado em: 17/03/2017.\r\nResponsável: Eduardo Garrido (UAIT).');
  INSERT INTO `db_pir_grc`.`grc_insumo_unidade` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`) VALUES ('46', 'Layout Interno', 'Ambiente Interno', 'S', 'Layout Interno: Ambiente Interno.\r\nCadastrado em: 17/03/2017.\r\nResponsável: Eduardo Garrido (UAIT).');
  INSERT INTO `db_pir_grc`.`grc_insumo_unidade` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`) VALUES ('47', 'Expositor do Ponto de Venda', 'Expositor do Ponto de Venda', 'S', 'Cadastrado em: 17/03/2017.\r\nResponsável: Eduardo Garrido (UAIT).');
  INSERT INTO `db_pir_grc`.`grc_insumo_unidade` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`) VALUES ('48', 'Coringa', 'Variável Qualitativa', 'S', 'Variável Qualitativa');
  INSERT INTO `db_pir_grc`.`grc_insumo_unidade` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`) VALUES ('49', 'Serviço de Consultoria', 'Serviço de Consultoria', 'S', 'Cadastrado em: 18/03/2017.\r\nResponsável: Eduardo Garrido (UAIT).');
  INSERT INTO `db_pir_grc`.`grc_insumo_unidade` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`) VALUES ('50', 'Plano', 'Plano', 'S', 'Cadastrado em: 18/03/2017.\r\nResponsável: Eduardo Garrido (UAIT).');
  INSERT INTO `db_pir_grc`.`grc_insumo_unidade` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`) VALUES ('51', 'Processo', 'Processo', 'S', 'Cadastrado em: 17/03/2017.\r\nResponsável: Eduardo Garrido (UAIT).');
  INSERT INTO `db_pir_grc`.`grc_insumo_unidade` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`) VALUES ('52', 'Estação', 'Estação', 'S', 'Cadastrado em: 17/03/2017.\r\nResponsável: Eduardo Garrido (UAIT).');
  INSERT INTO `db_pir_grc`.`grc_insumo_unidade` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`) VALUES ('54', 'Patente ou MU', 'Patente ou MU', 'S', 'Patente: Uma patente é um direito exclusivo concedido pelo Estado relativamente a uma invenção (ou modelo de utilidade), que atende ao requisito de novidade, envolve uma atividade inventiva (ou ato inventivo) e é suscetível de aplicação industrial.\r\nModelo de Utilidade: O modelo de utilidade é considerado o objeto de uso prático ou parte deste, suscetível de aplicação industrial, que apresente nova forma ou disposição, envolvendo ato inventivo que resulte em melhoria funcional no seu uso ou em sua fabricação. \r\nCadastrado em: 18/03/2017.\r\nResponsável: Eduardo Garrido (UAIT).');
  INSERT INTO `db_pir_grc`.`grc_insumo_unidade` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`) VALUES ('55', 'Desenho Industrial', 'Desenho Industrial', 'S', 'Cadastrado em: 18/03/2017.\r\nResponsável: Eduardo Garrido (UAIT).');
  INSERT INTO `db_pir_grc`.`grc_insumo_unidade` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`) VALUES ('56', 'Modelo de Utilidade', 'Modelo de Utilidade', 'S', 'Cadastrado em: 18/03/2017.\r\nResponsável: Eduardo Garrido (UAIT).');
  INSERT INTO `db_pir_grc`.`grc_insumo_unidade` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`) VALUES ('57', 'Funcionário', 'Funcionário', 'S', 'Cadastrado em: 20/03/2017.\r\nResponsável: Eduardo Garrido (UAIT).');
  INSERT INTO `db_pir_grc`.`grc_insumo_unidade` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`) VALUES ('58', 'E-Commerce', 'E-Commerce', 'S', 'Cadastrado em: 20/03/2017.\r\nResponsável: Eduardo Garrido (UAIT).');
  INSERT INTO `db_pir_grc`.`grc_insumo_unidade` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`) VALUES ('59', 'Sim ou Não', 'Sim ou Não', 'S', 'Responder 1 para Sim, 2 para Não.\r\nCadastrado em: 20/03/2017.\r\nResponsável: Eduardo Garrido (UAIT).');
  INSERT INTO `db_pir_grc`.`grc_insumo_unidade` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`) VALUES ('60', 'Requerimento', 'Licença Ambiental', 'S', 'Requerimento da Licença junto ao Órgão Ambiental.\r\nCadastrado em: 21/03/2017.\r\nResponsável: Eduardo Garrido (UAIT).');
  INSERT INTO `db_pir_grc`.`grc_insumo_unidade` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`) VALUES ('61', 'Unidades Produtivas', 'Unidades Produtivas', 'S', 'Cadastrado em: 21/03/2017.\r\nResponsável: Eduardo Garrido (UAIT).');
  INSERT INTO `db_pir_grc`.`grc_insumo_unidade` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`) VALUES ('62', 'Posto de Trabalho', 'Posto de Trabalho', 'S', 'Cadastrado em: 21/03/2017.\r\nResponsável: Eduardo Garrido (UAIT).');
  INSERT INTO `db_pir_grc`.`grc_insumo_unidade` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`) VALUES ('63', 'Pão', 'Pão', 'S', 'Cadastrado em: 21/03/2017.\r\nResponsável: Eduardo Garrido (UAIT).');
  INSERT INTO `db_pir_grc`.`grc_insumo_unidade` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`) VALUES ('64', 'Ambiente', 'Ambiente', 'S', 'Ambiente.');
  INSERT INTO `db_pir_grc`.`grc_insumo_unidade` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`) VALUES ('65', 'Produto', 'Produto', 'S', 'Produto.');
  INSERT INTO `db_pir_grc`.`grc_insumo_unidade` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`) VALUES ('66', 'Serviço', 'Serviço', 'S', 'Cadastrado em: 22/03/2017.\r\nResponsável: Eduardo Garrido (UAIT).');
  INSERT INTO `db_pir_grc`.`grc_insumo_unidade` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`) VALUES ('67', 'Máquina e/ou Equipamento', 'Máquina e/ou Equipamento', 'S', 'Cadastrado em: 21/03/2017.\r\nResponsável: Eduardo Garrido (UAIT).');
  INSERT INTO `db_pir_grc`.`grc_insumo_unidade` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`) VALUES ('68', 'Protótipo', 'Protótipo', 'S', 'Cadastrado em: 22/03/2017.\r\nResponsável: Eduardo Garrido (UAIT).');
  INSERT INTO `db_pir_grc`.`grc_insumo_unidade` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`) VALUES ('69', 'Minuto', 'Minuto', 'S', 'Unidade de Tempo.\r\nCadastrado em: 23/03/2017.\r\nResponsável: Eduardo Garrido (UAIT).');
  INSERT INTO `db_pir_grc`.`grc_insumo_unidade` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`) VALUES ('70', 'Grau de Risco', 'Grau de Risco', 'S', 'O Grau de Risco varia de 1 a 4, conforme Norma Regulamentadora 4 do Ministério do Trabalho e Emprego e CNAE da Empresa. \r\nA norma pode ser acessada gratuitamente no site do MTE.\r\nCadastrado em: 24/03/2017.\r\nResponsável: Eduardo Garrido (UAIT).');
  INSERT INTO `db_pir_grc`.`grc_insumo_unidade` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`) VALUES ('71', 'Oficina', 'Oficina', 'S', 'Cadastrado em: 27/03/2017.\r\nResponsável: Eduardo Garrido (UAIT).');
  INSERT INTO `db_pir_grc`.`grc_insumo_unidade` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`) VALUES ('72', 'Metrologia', 'Metrologia', 'S', 'Cadastrado em: 28/03/2017.\r\nResponsável: Eduardo Garrido (UAIT).');
  INSERT INTO `db_pir_grc`.`grc_insumo_unidade` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`) VALUES ('73', 'Diagnóstico Tecnológico', 'Diagnóstico Tecnológico', 'S', 'Cadastrado em: 28/03/2017.\r\nResponsável: Eduardo Garrido (UAIT).');
  INSERT INTO `db_pir_grc`.`grc_insumo_unidade` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`) VALUES ('75', 'Serviços de Metrologia', 'Serviço de Metrologia', 'S', 'Cadastrado em: 31/03/2017.\r\nResponsável: Eduardo Garrido (UAIT).');
  INSERT INTO `db_pir_grc`.`grc_insumo_unidade` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`) VALUES ('76', 'Clínica', 'Clínica Tecnológica', 'S', 'Cadastrado em: 04/04/2017.\r\nResponsável: Eduardo Garrido (UAIT).');
  INSERT INTO `db_pir_grc`.`grc_insumo_unidade` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`) VALUES ('77', 'Empresas', 'Empresas', 'S', 'Cadastrado em: 04/04/2017.\r\nResponsável: Eduardo Garrido (UAIT).');

  INSERT INTO `db_pir_grc`.`grc_programa` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `sigla`) VALUES ('8', '08', 'SEBRAETEC', 'S', '<p>&nbsp;SEBRAETEC</p>', 'ST');

  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('58', 'UAIT-00001-2017', 'Relatório de Visita Técnica Presencial à Empresa.', 'S', NULL, 'Relatório de Visita Técnica Presencial à Empresa.\r\nCadastrado em: 17/03/2017.\r\nResponsável: Eduardo Garrido (UAIT).', 'RVT', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('59', 'UAIT-00002-2017', 'Declaração do Produtor informando a designação de um preposto para acompanhar e atestar os serviços que serão realizados na propriedade.', 'S', NULL, 'Declaração do Produtor informando a designação de um preposto para acompanhar e atestar os serviços que serão realizados na propriedade.\r\nCadastrado em: 17/03/2017.\r\nResponsável: Eduardo Garrido (UAIT).', 'DP', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('60', 'UAIT-00003-2017', 'Ata de Reunião Presencial com assinatura do empresário.', 'S', NULL, 'Ata atestando a realização de reunião presencial junto ao cliente.\r\nCadastrado em: 17/03/2017.\r\nResponsável: Eduardo Garrido (UAIT).', 'ATA', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '1', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('61', 'UAIT-00004-2017', 'Briefing: levantamento de informações junto ao cliente de modo a obter informações e instruções concisas e objetivas sobre missão ou tarefa a ser executada.', 'S', NULL, 'Briefing: levantamento de informações junto ao cliente de modo a obter informações e instruções concisas e objetivas sobre missão ou tarefa a ser executada.\r\nCadastrado em: 17/03/2017.\r\nResponsável: Eduardo Garrido (UAIT).', 'BRF', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('62', 'UAIT-00005-2017', 'Medições Realizadas: Medidas levantadas para subsidiar o projeto.', 'S', NULL, 'Medições Realizadas: Medidas levantadas para subsidiar o projeto.\r\nCadastrado em: 17/03/2017.\r\nResponsável: Eduardo Garrido (UAIT).', 'MED', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('63', 'UAIT-00006-2017', 'Registros Fotográficos.', 'S', NULL, 'Registros Fotográficos.\r\nCadastrado em: 17/03/2017.\r\nResponsável: Eduardo Garrido (UAIT).', 'FOT', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('64', 'UAIT-00007-2017', 'Planificação 2D: desenho técnico em duas dimensões.', 'S', NULL, 'Planificação 2D: desenho técnico em duas dimensões.\r\nCadastrado em: 17/03/2017.\r\nResponsável: Eduardo Garrido (UAIT).', 'P2D', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('65', 'UAIT-00008-2017', 'Projeto em 3D: projeto em três dimensões, contendo renderizações fotográficas com as devidas explicações e orientações ao empresário.', 'S', NULL, 'Projeto em 3D: projeto em três dimensões, contendo renderizações fotográficas com as devidas explicações e orientações ao empresário.\r\nCadastrado em: 17/03/2017.\r\nResponsável: Eduardo Garrido (UAIT).', 'P3D', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('66', 'UAIT-00009-2017', 'CD ou DVD contendo renderização (processo pelo qual se obtém o produto final de um processamento digital qualquer) 3D do Projeto em vídeo HD (passeio virtual).', 'S', NULL, 'CD ou DVD contendo renderização (processo pelo qual se obtém o produto final de um processamento digital qualquer) 3D do Projeto em vídeo HD (passeio virtual).\r\nCadastrado em: 17/03/2017.\r\nResponsável: Eduardo Garrido (UAIT).', 'R3D', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('67', 'UAIT-00010-2017', 'Projeto de Design.', 'S', NULL, 'Projeto de Design.\r\nCadastrado em: 17/03/2017.\r\nResponsável: Eduardo Garrido (UAIT).', 'PRJ', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('68', 'UAIT-00011-2017', 'Documento(s) de Comprovação de Prenhezes entregue(s) ao Produtor.', 'S', NULL, 'Documento(s) de Comprovação de Prenhezes entregue(s) ao Produtor.\r\nCadastrado em: 17/03/2017.\r\nResponsável: Eduardo Garrido (UAIT).', 'DOCPREN', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('69', 'UAIT-00012-2017', 'EVTE: Estudo de Viabilidade Te&#769;cnica e Econo&#770;mica.', 'S', NULL, 'EVTE: Estudo de Viabilidade Te&#769;cnica e Econo&#770;mica.\r\nCadastrado em: 17/03/2017.\r\nResponsável: Eduardo Garrido (UAIT).', 'EVTE', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('70', 'UAIT-00013-2017', 'Modelagem 2D: desenho técnico em duas dimensões.', 'S', NULL, 'Modelagem 2D: desenho técnico em duas dimensões.\r\nCadastrado em: 17/03/2017.\r\nResponsável: Eduardo Garrido (UAIT).', 'M2D', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('71', 'UAIT-00014-2017', 'Recibo de envio do formulário de pedido de Registro de Marca junto ao INPI, com: número do pedido, número do protocolo e data com horário do protocolo.', 'S', NULL, 'Recibo de envio do formulário de pedido de Registro de Marca junto ao INPI, com: número do pedido, número do protocolo e data com horário do protocolo.\r\nCadastrado em: 17/03/2017.\r\nResponsável: Eduardo Garrido (UAIT).', 'REC', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '20', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('72', 'UAIT-00015-2017', 'Documento do PPRA, contendo plano de ação e assinatura do(s) profissional(is) de segurança responsável(is) pela elaboração.', 'S', NULL, 'PCMSO – Programa de Controle Médico de Saúde Ocupacional.\r\nPPRA – Programa de Prevenção de Riscos Ambientais.\r\nCadastrado em: 20/03/2017.\r\nResponsável: Eduardo Garrido (UAIT).', 'PPRA', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '1', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('73', 'UAIT-00016-2017', 'Anotação de Responsabilidade Técnica do Profissional.', 'S', NULL, 'Cadastrado em: 20/03/2017.\r\nResponsável: Eduardo Garrido (UAIT).', 'ART', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('74', 'UAIT-00017-2017', 'Documento do PCMSO, contendo plano de ação e assinatura do profissional de saúde responsável pela elaboração.', 'S', NULL, 'PCMSO – Programa de Controle Médico de Saúde Ocupacional.\r\nPPRA – Programa de Prevenção de Riscos Ambientais.\r\nCadastrado em: 20/03/2017.\r\nResponsável: Eduardo Garrido (UAIT).', 'PCMSO', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('75', 'UAIT-00018-2017', 'Declaração assinada pelo empresário atestando o recebimento do documento do PPRA estruturado pelo prestador de serviço tecnológico e que o prestador de serviço tecnológico explicou ao cliente o conteúdo da entrega efetivada. Deve conter a assinatura do responsável da empresa e do profissional de segurança.', 'S', NULL, 'PCMSO – Programa de Controle Médico de Saúde Ocupacional.\r\nPPRA – Programa de Prevenção de Riscos Ambientais.\r\nCadastrado em: 20/03/2017.\r\nResponsável: Eduardo Garrido (UAIT).', 'DECL PPRA', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('76', 'UAIT-00019-2017', 'Declaração assinada pelo empresário atestando o recebimento do documento do PCMSO estruturado pelo prestador de serviço tecnológico e que o prestador de serviço tecnológico explicou ao cliente o conteúdo da entrega efetivada. Deve conter a assinatura do responsável da empresa e do profissional de segurança.', 'S', NULL, 'PCMSO – Programa de Controle Médico de Saúde Ocupacional.\r\nPPRA – Programa de Prevenção de Riscos Ambientais.\r\nCadastrado em: 20/03/2017.\r\nResponsável: Eduardo Garrido (UAIT).', 'DECL PCMSO', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('77', 'UAIT-00020-2017', 'Protocolo do Projeto junto a ANATEL.', 'S', NULL, 'ANATEL - Agência Nacional de Telecomunicações.\r\nCadastrado em: 20/03/2017.\r\nResponsável: Eduardo Garrido (UAIT).', 'PROTOC ANATEL', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('78', 'UAIT-00021-2017', 'Laudo comparativo referente às exigências da ANATEL e o atual cenário da prestação dos serviços.', 'S', NULL, 'ANATEL - Agência Nacional de Telecomunicações.\r\nCadastrado em: 20/03/2017.\r\nResponsável: Eduardo Garrido (UAIT).', 'LAUDO ANATEL', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('79', 'UAIT-00022-2017', 'Publicação de Extrato da Autorização no Diário Oficial da União.', 'S', NULL, 'Cadastrado em: 20/03/2017.\r\nResponsável: Eduardo Garrido (UAIT).', 'DOU', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('80', 'UAIT-00023-2017', 'Relatório de conformidade das radiações eletromagnéticas.', 'S', NULL, 'Radiação eletromagnética é a definição dada à ondas que se propagam no vácuo ou no ar com velocidade de 300.000 km/s, ou seja, com a velocidade da luz (c), que também é uma radiação eletromagnética. Uma outra característica das ondas eletromagnéticas é a capacidade de transportar energia e informações.\r\nCadastrado em: 20/03/2017.\r\nResponsável: Eduardo Garrido (UAIT).', 'RAD ELET', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('81', 'UAIT-00024-2017', 'Projeto Técnico contendo pelo menos as seguintes informações: a descrição do serviço a ser prestado contemplando as aplicações previstas; radiofrequências pretendidas, quando for o caso; pontos de interconexão previstos; capacidade pretendida do sistema em termos de número de canais e largura de banda ou taxa de transmissão; localização dos principais pontos de presença, no formato Município/UF; diagrama ilustrativo do sistema com a descrição das funções executadas por cada elemento do diagrama.', 'S', NULL, 'Radiação eletromagnética é a definição dada à ondas que se propagam no vácuo ou no ar com velocidade de 300.000 km/s, ou seja, com a velocidade da luz (c), que também é uma radiação eletromagnética. Uma outra característica das ondas eletromagnéticas é a capacidade de transportar energia e informações.\r\nCadastrado em: 20/03/2017.\r\nResponsável: Eduardo Garrido (UAIT).', 'PROJ TEC', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('82', 'UAIT-00025-2017', 'Declaração assinada pelo empresário atestando o recebimento da(s) entrega(s) realizadas pelo prestador de serviço tecnológico e que o prestador de serviço tecnológico explicou presencialmente ao cliente o conteúdo da(s) entrega(s) efetivadas.', 'S', NULL, 'Cadastrado em: 20/03/2017.\r\nResponsável: Eduardo Garrido (UAIT).', 'DECL ENTREGA', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('83', 'UAIT-00026-2017', 'Manual de Identidade Visual Impresso e em CD ou DVD contendo;\r\n• Todo o material desenvolvido durante a consultoria, em mídia digital (CD ou DVD), vetorizado ou imagens em alta resolução (em se tratando de imagens bitmapeadas);\r\n• Malha Construtiva da Marca;\r\n• Padrões Cromáticos (em escala RGB, CMYK, P/B e Pantone);\r\n• Apresentação da marca aprovada nas versões horizontais ou verticais com suas reduções mínimas;\r\n• Definição de “Área de não interferência” da marca aprovada;\r\n• Controle de Fundo. Restrições e/ou aplicações em fundos coloridos ou texturizados;\r\n• Usos proibitivos ou incorretos da marca;\r\n• Definição de família tipográfica utilizada no projeto, assim como disponibilização da mesma em sua versão digital;\r\n• Imagem digital da marca (para registro junto ao INPI) contida, obrigatoriamente, em uma moldura de 8.0 cm x 8.0 cm, no formato.jpg conforme orientações contidas no site;\r\n• Vistas frente x verso (quando houver) das aplicações em papelaria com indicações de dobra, vinco, cortes e abas;\r\n• Definição e detalhamento de suporte gráfico para cada um dos itens dos elementos desenvolvidos: papel (tipo e gramatura);\r\n• PVC ou acrílico (espessura).', 'S', NULL, 'Cadastrado em: 20/03/2017.\r\nResponsável: Eduardo Garrido (UAIT).', 'MANUAL', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('84', 'UAIT-00027-2017', 'Projeto de Prevenção e Combate Contra Incêndio atendendo a legislação e normas técnicas vigentes. Deve conter Memorial Descritivo, Componentes e o Memorial de Cálculo, contendo a metodologia utilizada e o dimensionamento.', 'S', NULL, 'Cadastrado em: 20/03/2017.\r\nResponsável: Eduardo Garrido (UAIT).', 'INCENDIO', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('85', 'UAIT-00028-2017', 'Planta de Situação, em escala adequada, com indicação das canalizações externas, inclusive redes existentes das concessionárias e outras de interesse.', 'S', NULL, 'Cadastrado em: 20/03/2017.\r\nResponsável: Eduardo Garrido (UAIT).', 'SITUACAO', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('86', 'UAIT-00029-2017', 'Planta Geral para cada nível da edificação, em escala 1:50, contendo indicação dos componentes dos sistemas, como comprimentos das tubulações horizontais e verticais, locação dos hidrantes internos e externos, vazões, pressões nos pontos de interesse, cotas de elevação, registros de bloqueio e de recalque, válvulas de retenção e alarme, extintores, bombas, reservatórios, iluminação de emergência, sinalização de emergência, especificações dos materiais básico e outros.', 'S', NULL, 'Cadastrado em: 20/03/2017.\r\nResponsável: Eduardo Garrido (UAIT).', 'GERAL', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('87', 'UAIT-00030-2017', 'Desenhos esquemáticos de interligação, prumadas e cortes.', 'S', NULL, 'Cadastrado em: 20/03/2017.\r\nResponsável: Eduardo Garrido (UAIT).', 'ESQUEM', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('88', 'UAIT-00031-2017', 'Especificações detalhadas de materiais, equipamentos e serviços para execução do Projeto de Combate a Incêndio.', 'S', NULL, 'Cadastrado em: 20/03/2017.\r\nResponsável: Eduardo Garrido (UAIT).', 'ESPECIF', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('89', 'UAIT-00032-201', 'Documento do Plano de Emergência Contra Incêndio, atendendo as recomendações contidas na legislação vigente e normas técnicas, contemplando no mínimo os requisitos estabelecidos no Anexo B (Modelo de plano de emergência contra incêndio) da NBR 15219:2005 e assinatura do(s) profissional(is) de segurança responsável(is) pela elaboração.', 'S', NULL, 'Cadastrado em: 20/03/2017.\r\nResponsável: Eduardo Garrido (UAIT).', 'EMERG', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('90', 'UAIT-00034-2017', '11. Manual completo impresso e em arquivo digital contendo:\r\n11.1. Passo a passo para uso e gestão do sistema de E-commerce;\r\n11.2. Instruções para utilização para meios eletrônicos de pagamento;\r\n11.3. Orientações sobre aspectos legais e tributários;\r\n11.4. Orientações sobre embalagem, como realizar as fotografias dos produtos/serviços, descrição dos mesmos, bem como estratégias para divulgação e promoção.', 'S', NULL, 'Cadastrado em: 20/03/2017.\r\nResponsável: Eduardo Garrido (UAIT).', 'MANUAL E-COMM', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('91', 'UAIT-00033-2017', 'Print da Tela Evidenciando as Entregas.', 'S', NULL, 'Cadastrado em: 20/03/2017.\r\nResponsável: Eduardo Garrido (UAIT).', 'PRINT', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('92', 'UAIT-00035-2017', 'Peças desenvolvidas em mídia digital e formato impresso.', 'S', NULL, 'Cadastrado em: 20/03/2017.\r\nResponsável: Eduardo Garrido (UAIT).', 'PEÇAS', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('93', 'UAIT-00036-2017', 'Plano de Gerenciamento de Resíduos Sólidos.', 'S', NULL, 'Cadastrado em: 21/03/2017.\r\nResponsável: Eduardo Garrido (UAIT).', 'PGRS', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('94', 'UAIT-00037-2017', 'Roteiro de Caracterização de Empreendimento.', 'S', NULL, 'Cadastrado em: 21/03/2017.\r\nResponsável: Eduardo Garrido (UAIT).', 'RCE', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('95', 'UAIT-00039-2017', 'Planta de Localização do Imóvel: Mapa Georreferenciado do empreendimento', 'S', NULL, 'Cadastrado em: 21/03/2017.\r\nResponsável: Eduardo Garrido (UAIT).', 'LOCALIZAÇÃO', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('96', 'UAIT-00038-2017', 'Plano de Emergência Ambiental.', 'S', NULL, 'Cadastrado em: 21/03/2017.\r\nResponsável: Eduardo Garrido (UAIT).', 'PEA', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('97', 'UAIT-00040-2017', 'Comprovante de pagamento da taxa de licenciamento pelo cliente.', 'S', NULL, 'Comprovante de pagamento da taxa de licenciamento pelo cliente.', 'TAXA LIC', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('98', 'UAIT-00041-2017', 'Nº do Protocolo/ Processo de Entrada junto ao Órgão Ambiental.', 'S', NULL, 'Cadastrado em: 21/03/2017.\r\nResponsável: Eduardo Garrido (UAIT).', 'PROTOC AMBIENTAL', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('99', 'UAIT-00042-2017', 'Cópia de toda a documentação constante no Processo apresentado ao Órgão Ambiental, organizado em documento único, em meio impresso e digital.', 'S', NULL, 'Cadastrado em: 21/03/2017.\r\nResponsável: Eduardo Garrido (UAIT).', 'PROCESSO AMBIENTAL', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('100', 'UAIT-00043-2017', 'Cópia de toda a documentação constante no Processo apresentado a ANATEL, organizado em documento único, em meio impresso e digital.', 'S', NULL, 'ANATEL - Agência Nacional de Telecomunicações.\r\nCadastrado em: 21/03/2017.\r\nResponsável: Eduardo Garrido (UAIT).', 'PROCESSO ANATEL', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('101', 'UAIT-00044-2017', 'Memorial descritivo e de cálculo do processo produtivo/serviços.', 'S', NULL, 'Cadastrado em: 21/03/2017.\r\nResponsável: Eduardo Garrido (UAIT).', 'MEMORIAL', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('102', 'UAIT-00045-2017', 'Manual da Qualidade com a descrição de todos os processos da empresa.', 'S', NULL, 'Cadastrado em: 21/03/2017.\r\nResponsável: Eduardo Garrido (UAIT).', 'MANUAL QUALIDADE', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('103', 'UAIT-00046-2017', 'Procedimentos e Rotinas escritas para os itens obrigatórios da norma e para os principais processos de trabalho da empresa.', 'S', NULL, 'Cadastrado em: 21/03/2017.\r\nResponsável: Eduardo Garrido (UAIT).', 'PROC E ROT', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('104', 'UAIT-00048-2017', 'Declaração do Empresário informando a designação de um preposto para acompanhar e atestar os serviços que serão realizados na empresa.', 'S', NULL, 'O CLIENTE deve designar interlocutor para acompanhar o Consultor da CONTRATADA nas visitas ao empreendimento, dando acesso às instalações, bem como, fornecer informações fidedignas e documentos imprescindíveis para composição do procedimento.\r\nCadastrado em: 21/03/2017.\r\nResponsável: Eduardo Garrido (UAIT).', 'DEC PREP', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('105', 'UAIT-00047-2017', 'Lista de Presença e Certificados emitidos referentes ao Treinamento do(s) Funcionário(s) da Empresa. Material desenvolvido/utilizado no treinamento.', 'S', NULL, 'Cadastrado em: 21/03/2017.\r\nResponsável: Eduardo Garrido (UAIT).', 'TREINAMENTO', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('106', 'UAIT-00049-2017', 'Relatório de auditoria interna.', 'S', NULL, 'Cadastrado em: 21/03/2017.\r\nResponsável: Eduardo Garrido (UAIT).', 'AUDITORIA INT', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('107', 'UAIT-00052-2017', 'Documento de Analise Ergonômica do Trabalho (AET), com base na metodologia EWA - Ergonômica Workplace Analysis, contendo plano de melhorias, cronograma, priorização das ações e assinatura do(s) profissional(is) de segurança responsável(is) pela elaboração.', 'S', NULL, 'Cadastrado em: 21/03/2017.\r\nResponsável: Eduardo Garrido (UAIT).', 'AET', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('108', 'UAIT-00050-2017', 'Relatório contendo orientações de melhoria para a empresa.', 'S', NULL, 'Cadastrado em: 21/03/2017.\r\nResponsável: Eduardo Garrido (UAIT).', 'ORIENT MEL', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('109', 'UAIT-00051-2017', 'Descrição de Cargos e Funções.', 'S', NULL, 'Cadastrado em: 21/03/2017.\r\nResponsável: Eduardo Garrido (UAIT).', 'CARGOS E FUNÇÕES', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('110', 'UAIT-00053-2017', 'Documento de mapeamento descrevendo o fluxograma de processos, balanços, requisitos de matérias primas (entradas) e produtos (saídas); Identificação das principais variáveis de cada processo. Análise e mapeamento das variáveis de processos existentes. Identificar tempos, desvios em relação a resultados esperados (metas). Caso não exista mapeamento de dados de processo, implementar planilha de levantamento de dados.', 'S', NULL, 'Cadastrado em: 21/03/2017.\r\nResponsável: Eduardo Garrido (UAIT).', 'MAPEAMENTO', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('111', 'UAIT-00054-2017', 'Documento de planejamento da produção contendo a coleta de requisitos relativos ao planejamento de produção, avaliação se as fichas técnicas ou estrutura de produto existente servem de base para o planejamento de compras, produção, gestão de estoques. Caso não exista, desenvolver formulário padrão para levantamento de dados.', 'S', NULL, 'Cadastrado em: 21/03/2017.\r\nResponsável: Eduardo Garrido (UAIT).', 'PLANEJAMENTO', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '1', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('112', 'UAIT-00055-2017', 'Documento de padronização de processos operacionais. Escolher um processo produtivo, sugerindo melhorias, treinando envolvidos e implementando a padronização.', 'S', NULL, 'Cadastrado em: 21/03/2017.\r\nResponsável: Eduardo Garrido (UAIT).', 'PADRONIZAÇÃO', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('113', 'UAIT-00056-2017', 'Documento de análise de controles de estoques de matérias primas e insumos. Avaliar se os métodos utilizados possibilitam correta gestão de estoque, suprimento das linhas de produção e continuidade operacional. Caso não atenda, implementar controle visual e físico; Avaliar os controles de apuração de produção. Planilhas, formulário de coleta de dados, fichas de apuração de produção, verificando a sua aplicabilidade no processo de tomada de decisão. Caso não, implementar novos controles. Analisar controles de estoques de produto acabado, interfaces entre entrega da produção e recepção pela logística (armazém). Avaliar se os métodos utilizados possibilitam correta gestão de estoque, expedição de produtos, identificação de produtos conforme e não conforme. Caso não atenda, implementar controle visual e físico.', 'S', NULL, 'Cadastrado em: 21/03/2017.\r\nResponsável: Eduardo Garrido (UAIT).', 'CONTROLE', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('114', 'UAIT-00057-2017', 'Documento de avaliação e dimensionamento de capacidade produtiva. Medir eficiência real x teórica. Comparar capacidade produtiva x demandas de mercado. Identificar gargalos no processo produtivo e propor ações para aumento de capacidade e redução de gargalos; Avaliar custos de produção identificando margem de lucro dos produtos através da utilização de planilhas e ferramentas que possibilitem o cálculo de margem e preço de venda; Propor estratégias para aumento da margem de lucro (redução de custos, desperdícios, tempos de processamento, maximização de sinergias); Propor melhorias no layout produtivo, visando redução de custos variáveis, redução de tempos de processo, aumento de capacidade; Propor indicadores de processo chaves (custo, qualidade, produtividade, segurança) que possibilite o acompanhamento e análise dos processos existentes e potenciais tomadas de decisões.', 'S', NULL, 'Cadastrado em: 21/03/2017.\r\nResponsável: Eduardo Garrido (UAIT).', 'PRODUÇÃO', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('115', 'UAIT-00058-2017', 'Relatório definitivo contendo a consolidação de todas as etapas desenvolvidas na consultoria, validado junto ao cliente. O documento deve conter observações, análise do problema, plano de ação contendo ações executadas, ações propostas, resultados e plano de melhoria contínua.', 'S', NULL, 'Cadastrado em: 21/03/2017.\r\nResponsável: Eduardo Garrido (UAIT).', 'CONCLUSÃO', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('116', 'UAIT-00059-2017', 'Diagnóstico realizado na empresa.', 'S', NULL, 'Cadastrado em: 21/03/2017.\r\nResponsável: Eduardo Garrido (UAIT).', 'DIAGNÓSTICO', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('117', 'UAIT-00060-2017', 'Caderno de Campo contendo registros de entrada e saída de produtos na propriedade, anotações periódicas sobre manejo das culturas ou criações.', 'S', NULL, 'Cadastrado em: 21/03/2017.\r\nResponsável: Eduardo Garrido (UAIT).', 'CADERNO', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('118', 'UAIT-00061-2017', 'Plano de Manejo (também chamado de Plano de Transição ou Plano de Conversão) para Sistemas Orgânicos de Produção Vegetal e Animal, validado, contendo:\r\n- Histórico de Utilização da Área;\r\n- Manutenção ou Incremento da Biodiversidade;\r\n- Manejo dos Resíduos;\r\n- Conservação do Solo e da Água;\r\n- Manejos da Produção Vegetal e Animal;\r\n- Procedimentos de Pós-Produção;\r\n- Medidas para Prevenção de Riscos de Contaminação Externa;\r\n- Boas Práticas de Produção;\r\n- Inter-relações ambientais, econômicas e sociais;\r\n- Ocupação da unidade de produção, e;\r\n- Ações que visam evitar contaminações internas e externas.', 'S', NULL, 'Cadastrado em: 21/03/2017.\r\nResponsável: Eduardo Garrido (UAIT).', 'MANEJO', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('119', 'UAIT-00062-2017', 'Emissão de Certificado de Conformidade Orgânica, o qual permite a utilização da marca e do selo da certificadora em embalagens e publicidade durante a validade do certificado, de 01 (um) ano.', 'S', NULL, 'Cadastrado em: 21/03/2017.\r\nResponsável: Eduardo Garrido (UAIT).', 'CERT CONF ORG', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('120', 'UAIT-00063-2017', 'Relatório de auditoria externa, contendo a assinatura do empresário.', 'S', NULL, 'Cadastrado em: 21/03/2017.\r\nResponsável: Eduardo Garrido (UAIT).', 'AUDITORIA EXT', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('121', 'UAIT-00064-2017', 'Manual Prático de Boas Práticas Agrícolas (BRA), com a descrição dos principais processos da empresa.', 'S', NULL, 'Cadastrado em: 21/03/2017.\r\nResponsável: Eduardo Garrido (UAIT).', 'MANUAL BPA', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('122', 'UAIT-00065-2017', 'Documento do Relatório de Avaliação de Exposição Ocupacional ao Ruído, conforme diretrizes estabelecidas no Anexo 01 da NR 15 e na NHO 01 - Avaliação da Exposição Ocupacional ao Ruído (Fundacentro, 2001), contemplando no mínimo: 1) Dados da empresa; 2) Introdução, incluindo objetivos do trabalho, justificativa e datas ou períodos em que foram desenvolvidas as avaliações; 3) Critério de avaliação adotado; 4) Instrumental utilizado; 5) Metodologia de avaliação; 6) Descrição das condições de exposição avaliadas; 7) Dados obtidos; 8) Interpretação dos resultados; 9) Conclusão e recomendações; 10) Anexos: Cópia das fichas de campo e dos certificados de calibração do instrumental utilizado; e l)  assinatura do(s) profissional(is) de segurança responsável(is) pela elaboração.', 'S', NULL, 'Cadastrado em: 21/03/2017.\r\nResponsável: Eduardo Garrido (UAIT).', 'RUÍDO', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('123', 'UAIT-00066-2017', 'Documento do Relatório de Avaliação de Exposição Ocupacional a Agentes Químicos, contendo: a) Dados da empresa; b) Introdução, incluindo objetivos do trabalho, justificativa e datas ou períodos em que foram desenvolvidas as avaliações quantitativas; c) Critério de avaliação adotado; d) Instrumental utilizado – materiais e equipamentos utilizados (tipo, marca e modelo de bombas e dispositivos de coleta); e) Metodologia de avaliação (estratégia de coleta, métodos de coleta e métodos analíticos); f) Descrição das situações de exposição avaliadas; g) Resultados obtidos; h) Interpretação dos resultados; i) Conclusões e recomendações; j) Referências bibliográficas; l) Anexos: Laudo das análises realizadas em laboratório, cópias das fichas de campo e dos certificados de calibração do instrumental utilizado; m) assinatura do(s) profissional(is) de segurança responsável(is) pela elaboração.', 'S', NULL, 'Cadastrado em: 22/03/2017.\r\nResponsável: Eduardo Garrido (UAIT).', 'QUÍMICO', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('124', 'UAIT-00067-2017', 'Projeto baseado em brainstormings, pesquisas de referências, croquis, etc. da solução de inovação proposta: incluindo sua conceituação e contextualização para o desenvolvimento dos novos produtos.', 'S', NULL, 'Cadastrado em: 22/03/2017.\r\nResponsável: Eduardo Garrido (UAIT).', 'PROJ ETAPA 1', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('125', 'UAIT-00068-2017', 'Dossiê com registros históricos da empresa, entrevistas, imagens (fotografias e vídeos) das etapas que abrangem o processo produtivo e produto existentes e indicação de melhorias em processos e possível inclusão de serviços suplementares aos produtos desenvolvidos pela empresa.', 'S', NULL, 'Cadastrado em: 22/03/2017.\r\nResponsável: Eduardo Garrido (UAIT).', 'DOSSIÊ', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('126', 'UAIT-00070-2017', 'Detalhamento técnico dos produtos em software adequado, com especificação de material, medidas, vistas, perspectivas e todo o dimensionamento prévio das peças a serem prototipadas.', 'S', NULL, 'Cadastrado em: 22/03/2017.\r\nResponsável: Eduardo Garrido (UAIT).', 'DET TEC', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('127', 'UAIT-00069-2017', 'Projeto de Coleção de Moda, contendo: moodboard Mapa de Cenário, moodboard Tema da Coleção, definição de cartela de cores, formas, texturas, mix de produtos e croquis.', 'S', NULL, 'Cadastrado em: 22/03/2017.\r\nResponsável: Eduardo Garrido (UAIT).', 'COLEÇÃO ETAPA 2', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('128', 'UAIT-00071-2017', 'Registro de acompanhamento do processo de desenvolvimento das modelagens.', 'S', NULL, 'Cadastrado em: 22/03/2017.\r\nResponsável: Eduardo Garrido (UAIT).', 'REG MOD', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('129', 'UAIT-00072-2017', 'Registro de acompanhamento do processo de prototipagem das peças piloto.', 'S', NULL, 'Cadastrado em: 22/03/2017.\r\nResponsável: Eduardo Garrido (UAIT).', 'REG PROT', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('130', 'UAIT-00073-2017', 'Relatório contendo os desenhos técnicos dos produtos em PDF e impresso em meio físico, fotografias dos protótipos aprovados pelo cliente, bem como recomendações de melhorias nos processos e inclusão de possíveis serviços suplementares aos produtos desenvolvidos.', 'S', NULL, 'Cadastrado em: 22/03/2017.\r\nResponsável: Eduardo Garrido (UAIT).', 'RELAT', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('131', 'UAIT-00074-2017', 'Relatório final em meio físico impresso e digital, contendo:\r\n1. Definição de Escopo do Projeto\r\n2. Reenquadramento – Examinar o Problema de Diferentes Óticas\r\n• Contato inicial consultor x empresa\r\n• Paradigmas da empresa\r\n• Concorrentes\r\n3. Identificação de Necessidades e Oportunidades\r\n• Swot\r\n• Pesquisa Desk\r\n• Entrevistas\r\n• Observação\r\n4. Utilizando Método AT-ONE – Colaboração e Inovação.\r\n• Atores envolvidos\r\n• TouchPoints (Ponto de contato)\r\n• Oferta do serviço\r\n• Necessidades do cliente\r\n• Experiências que surpreendem e encantam\r\n5. Identificação do Contexto dos Usuários/Atores, Ambientes e Ciclo de Vida.\r\n• Mapa de Empatia\r\n• Jornada do Usuário (serviço existente/concorrentes)\r\n• Blue Print (serviço existente/concorrentes)\r\nIdentificação de Critérios Norteadores\r\n6. Geração de Solução\r\n6.1. Construção/Revisão da Proposta de Valor\r\n6.2. Propostas para Soluções\r\n6.3. Construção do Processo Apreender, Utilizar e se Lembrar\r\n• Comunicação\r\n• Sensibilização\r\n• Aquisição\r\n• Evidencias físicas\r\n• Pós-serviço\r\n• Retorno do cliente\r\n• Ações dos usuários\r\n• Ação de funcionários\r\n• Barreiras para a interação', 'S', NULL, 'Cadastrado em: 22/03/2017.\r\nResponsável: Eduardo Garrido (UAIT).', 'RELAT SERV', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('132', 'UAIT-00075-2017', 'Recibo de envio do formulário com número do pedido junto ao INPI, número do protocolo, data e horário do protocolo, assim como as publicações referentes a esse processo.', 'S', NULL, 'Cadastrado em: 22/03/2017.\r\nResponsável: Eduardo Garrido (UAIT).', 'RECIBO INPI', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('133', 'UAIT-00076-2017', 'Manual da Gestão Ambiental com a descrição de todos os processos da empresa e seus aspectos e impactos ambientais.', 'S', NULL, 'Cadastrado em: 22/03/2017.\r\nResponsável: Eduardo Garrido (UAIT).', 'MANUAL AMBIENTAL', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('134', 'UAIT-00077-2017', 'Documento do Inventário  de Máquinas e Equipamentos, conforme requisitos da NR 12, contendo assinatura do(s) profissional(is) de segurança responsável(is) pela elaboração.', 'S', NULL, 'Cadastrado em: 22/03/2017.\r\nResponsável: Eduardo Garrido (UAIT).', 'INV MAQ EQUIP', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('135', 'UAIT-00078-2017', 'Documento do Plano de Adequação de Máquinas e Equipamentos, contendo a identificação das zonas de perigos das máquinas, a análise de risco, medidas de adequação, cronograma com priorização de ações e assinatura do(s) profissional(is) de segurança responsável(is) pela elaboração.', 'S', NULL, 'Cadastrado em: 22/03/2017.\r\nResponsável: Eduardo Garrido (UAIT).', 'PLAN ADEQ MAQ EQUIP', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('136', 'UAIT-00079-2017', 'Manual de Acreditação com a descrição de todos os processos da empresa.', 'S', NULL, 'Cadastrado em: 22/03/2017.\r\nResponsável: Eduardo Garrido (UAIT).', 'MANUAL ONA', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('137', 'UAIT-00080-2017', 'Memorial Econômico e Sanitário do Estabelecimento. \r\nO MESE – Memorial Econômico e Sanitário do Estabelecimento contempla: \r\n• Avaliação dos móveis e equipamentos.\r\n• Áreas internas dos compartimentos e nomenclatura dos ambientes.\r\n• Especificação básica do material de acabamento.\r\n• Fluxograma de produção.\r\n• Memorial descritivo da produção.', 'S', NULL, 'Cadastrado em: 22/03/2017.\r\nResponsável: Eduardo Garrido (UAIT).', 'MESE', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('138', 'UAIT-00081-2017', 'Manual de Boas Práticas de Fabricação. O Manual de Boas Práticas de Fabricação indica as não conformidades a serem corrigidas pela empresa', 'S', NULL, 'Cadastrado em: 22/03/2017.\r\nResponsável: Eduardo Garrido (UAIT).', 'BPF', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('139', 'ARQUITETÔNICO', 'Relatório técnico do projeto arquitetônico.', 'S', NULL, 'Cadastrado em: 22/03/2017.\r\nResponsável: Eduardo Garrido (UAIT).', 'ARQUITETÔNICO', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('140', 'UAIT-00082-2017', 'Nº do Protocolo de entrada no órgão competente.', 'S', NULL, 'Cadastrado em: 22/03/2017.\r\nResponsável: Eduardo Garrido (UAIT).', 'PROTOCOLO', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('141', 'UAIT-00083-2017', 'Projeto arquitetônico. Consiste na elaboração do projeto arquitetônico, a qual envolve a construção do projeto da unidade fabril solicitado pela indústria, com base nos requisitos levantados.', 'S', NULL, 'Cadastrado em: 22/03/2017.\r\nResponsável: Eduardo Garrido (UAIT).', 'ARQUITETÔNICO', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('142', 'UAIT-00084-2017', 'Projeto Técnico em cópia impressa e meio eletrônico contendo especificações suficientes para a produção de um protótipo funcional.\r\nO protótipo se configura como a produção concreta (física ou digital) de projeto/modelo de produto ou serviço. A prototipagem deve ter a finalidade de experimentar/testar algum aspecto do produto final (funcionalidade, formato, peso, aceitabilidade junto ao mercado, entre outros).\r\nO projeto de desenvolvimento do protótipo deve conter escopo, cronograma com os principais marcos de projeto, recursos humanos necessários (capacitação, expertise de membros da equipe, necessidade de treinamento) e plano de mobilização de recursos. Deve conter a avaliação de riscos envolvidos no projeto e plano de resposta. Deve agregar todos os custos do projeto e distribuir no tempo com curva de desembolso e reservas. Deve conter o planejamento da qualidade (plano de qualidade contendo requisitos de avaliação de qualidade estabelecidos, planilhas de coleta de dados, check-list, forma de medição, frequência, critérios de aceitação). Deve conter o controle da qualidade com verificação se processos planejados estão acontecendo conforme requisitos. Deve atentar à garantia da qualidade, com medição e tratamento dos desvios observados). Necessário apresentar as aquisições necessárias de materiais e serviços para execução do protótipo (local, serviço, materiais, ferramentas e equipamentos de medição de desempenho). Planejar a comunicação entre todos os envolvidos no projeto com base nos requisitos de comunicação previamente estabelecidos (canal, frequência, tipo de informação, etc).', 'S', NULL, 'Cadastrado em: 22/03/2017.\r\nResponsável: Eduardo Garrido (UAIT).', 'PROJ TEC PROTOTIPO', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('143', 'UAIT-00085-2017', 'Protótipo em meio físico utilizando as escalas previamente estabelecidas.', 'S', NULL, 'Cadastrado em: 22/03/2017.\r\nResponsável: Eduardo Garrido (UAIT).', 'PROTOTIPO FISICO', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('144', 'UAIT-00086-2017', 'Laudo apresentando resultados do testes de desempenho e avaliação de resultados em conformidade com os requisitos estabelecidos de desempenho e custos.', 'S', NULL, 'Cadastrado em: 22/03/2017.\r\nResponsável: Eduardo Garrido (UAIT).', 'LAUDO PROTÓTIPO', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('145', 'UAIT-00087-2017', 'Relatório impresso com as devidas análises, explicações e orientações ao empresário, incluindo os itens abaixo:\r\n• histórico;\r\n• características do público-alvo atual e área geográfica de abrangência desejada;\r\n• produtos/serviços oferecidos e os desejados para venda através de E-commerce;\r\n• conhecimento e descrição da estrutura física;\r\n• aspectos legais e tributários;\r\n• tecnologia a ser utilizada;\r\n• domínio / hospedagem e demais custos envolvidos;\r\n• identidade visual e a importância do registro da marca;\r\n• embalagem;\r\n• fotografias dos produtos/serviços;\r\n• conhecimento e descrição dos produtos/serviços;\r\n• capacidade produtiva;\r\n• estoque;\r\n• logística e distribuição;\r\n• frete;\r\n• formação de preço;\r\n• utilização de meios eletrônicos para pagamento;\r\n• canais de comunicação com o cliente;\r\n• divulgação e promoção;\r\n• afinidade do empresário com relação à tecnologia;\r\n• utilização de ferramentas web e mídias sociais;\r\n• parcerias;\r\n• recursos humanos;\r\n• recursos financeiros e investimentos;\r\n• Análise de viabilidade da implantação do E-commerce;\r\n• Indicação de quais produtos/serviços estão adequados ao E-commerce;\r\n• Indicação de qual formato (venda direta ou exposição de produtos/serviços) melhor se adequa à realidade da empresa;\r\n• Orientações de melhorias;\r\n• Sugestões e considerações relevantes para a empresa.', 'S', NULL, 'Cadastrado em: 22/03/2017.\r\nResponsável: Eduardo Garrido (UAIT).', 'DIAGNÓSTICO E-COMMERCE', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('146', 'UAIT-00088-2017', 'Projeto do Website, sob o formato de Relatório com Layout e Especificações Técnicas para embasar o desenvolvimento do site institucional.', 'S', NULL, 'Cadastrado em: 22/03/2017.\r\nResponsável: Eduardo Garrido (UAIT).', 'PROJETO WEBSITE', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('148', 'UAIT-00089-2017', 'Laudo Técnico das análises laboratoriais.', 'S', NULL, 'Cadastrado em: 23/03/2017.\r\nResponsável: Eduardo Garrido (UAIT).', 'LAUDO LAB', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('149', 'UAIT-00090-2017', 'Projeto de instalação predial de águas pluviais.', 'S', NULL, 'Água pluvial: água de chuva.\r\nCadastrado em: 23/03/2017.\r\nResponsável: Eduardo Garrido (UAIT).', 'ÁGUAS PLUVIAIS', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('150', 'UAIT-00091-2017', 'Projeto do sistema de coleta e tratamento dos efluentes.', 'S', NULL, 'Efluente: resíduo líquido resultante de processos.\r\nCadastrado em: 23/03/2017.\r\nResponsável: Eduardo Garrido (UAIT).', 'EFLUENTE', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('151', 'UAIT-00092-2017', 'Projeto de Eficiência Energética. O Projeto de Eficiência Energética conterá as prioridades definidas conjuntamente entre empresário e consultor, com respectivo projeto, plano de ação, responsáveis e prazo. Este documento pode se converter em uma ferramenta de controle e acompanhamento do serviço quando de sua implementação.', 'S', NULL, 'Cadastrado em: 23/03/2017.\r\nResponsável: Eduardo Garrido (UAIT).', 'EFICIÊNCIA ENERGÉTICA', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('152', 'UAIT-00093-2017', 'O diagnóstico energético apresentará ao empresário a situação da sua empresa e os possíveis focos de atuação para otimização do uso de energia. O consultor fará o estudo e acompanhamento do processo produtivo, levantamento de cargas, mapeamento energético e luminotécnica. Com base neste documento, o empresário e o consultor definirão a prioridade das ações, gerando o Plano de Trabalho.', 'S', NULL, 'Cadastrado em: 23/03/2017.\r\nResponsável: Eduardo Garrido (UAIT).', 'DIAGNÓSTICO ENERGÉTICO', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('154', 'UAIT-00094-2017', 'Plano de ação com os encaminhamentos e atividades relacionadas a etapa.', 'S', NULL, 'Cadastrado em: 23/03/2017.\r\nResponsável: Eduardo Garrido (UAIT).', 'PLANO DE AÇÃO', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('155', 'UAIT-00095-2017', 'Relatório de Final de Serviço demonstrando os avanços com as atividades acompanhadas e implementadas durante o atendimento.', 'S', NULL, 'Cadastrado em: 23/03/2017.\r\nResponsável: Eduardo Garrido (UAIT).', 'RELATÓRIO FINAL', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('156', 'UAIT-00096-2017', 'Relatório técnico com informações do produto padronizado.', 'S', NULL, 'Cadastrado em: 23/03/2017.\r\nResponsável: Eduardo Garrido (UAIT).', 'RELATÓRIO PAD 1', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('157', 'UAIT-00097-2017', 'Relatório final contemplando Indicadores do Estado Presente e Futuro; Descrição das oportunidades de melhoria e intervenções realizadas; Produtividade alcançada.', 'S', NULL, 'Cadastrado em: 23/03/2017.\r\nResponsável: Eduardo Garrido (UAIT).', 'RELATÓRIO PAD 2', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('158', 'UAIT-00098-2017', 'Relatório contendo descrição dos serviços desenvolvidos acerca de: Estado Presente; Impressora Offset devidamente regulada; Definição das ações de melhoria.', 'S', NULL, 'Cadastrado em: 23/03/2017.\r\nResponsável: Eduardo Garrido (UAIT).', 'GRÁFICA 1', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('159', 'UAIT-00099-2017', 'Relatório contendo descrição dos serviços desenvolvidos acerca de: Ajustes no Processo; Efetivação juntamente com a equipe.', 'S', NULL, 'Cadastrado em: 23/03/2017.\r\nResponsável: Eduardo Garrido (UAIT).', 'GRÁFICA 2', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('160', 'UAIT-00100-2017', 'Relatório contendo descrição dos serviços desenvolvidos acerca de: Criação do Mapa de Alocação de Custos Indiretos (RKW) parametrizado com a produção; Definição do Valor/ hora dos Centros de Custos; Correção no processo de orçamentação.', 'S', NULL, 'Cadastrado em: 23/03/2017.\r\nResponsável: Eduardo Garrido (UAIT).', 'GRÁFICA 3', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('161', 'UAIT-00101-2017', 'Relatório contendo descrição dos serviços desenvolvidos acerca de: Produção e Clientes mapeados, fornecendo ao empresário uma visão aprofundada do seu negócio; Estratégias focadas em vendas; Melhor otimização do parque produtivo;  Aumento da inteligência do negócio gráfico.', 'S', NULL, 'Cadastrado em: 23/03/2017.\r\nResponsável: Eduardo Garrido (UAIT).', 'GRÁFICA 4', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('162', 'UAIT-00102-2017', 'Relatório de Consultoria para cada etapa, descrevendo todo o serviço prestado, sua metodologia, indicações, orientações e considerações para que a empresa tome as devidas providências.', 'S', NULL, 'Cadastrado em: 23/03/2017.\r\nResponsável: Eduardo Garrido (UAIT).', 'GRÁFICA 5', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('163', 'UAIT-00103-2017', 'Plano de manutenção do equipamento, com todas as informações necessárias para o planejamento, execução e controle da manutenção.', 'S', NULL, 'Cadastrado em: 23/03/2017.\r\nResponsável: Eduardo Garrido (UAIT).', 'PLANO DE MANUT', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('164', 'UAIT-99999-2017', 'Coringa.', 'S', NULL, 'Cadastrado em: 23/03/2017.\r\nResponsável: Eduardo Garrido (UAIT).', 'CORINGA', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '1', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('165', 'UAIT-00104-2017', 'Plano de Trabalho.', 'S', NULL, 'Cadastrado em: 30/03/2017.\r\nResponsável: Eduardo Garrido (UAIT).', 'PLANO DE TRABALHO', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('166', 'UAIT-00105-2017', 'Certificado UTZ.', 'S', NULL, 'Cadastrado em: 03/04/2017.\r\nResponsável: Eduardo Garrido (UAIT).', 'CERT UTZ', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('167', 'UAIT-00106-2017', 'Lista de Presença.', 'S', NULL, 'Cadastrado em: 04/04/2017.\r\nResponsável: Eduardo Garrido (UAIT).', 'PRESENÇA', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('168', 'UAIT-00107-2017', 'Formulário de Satisfação do Cliente.', 'S', NULL, 'Cadastrado em: 04/04/2017.\r\nResponsável: Eduardo Garrido (UAIT).', 'SATISFAÇÃO', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('169', 'UAIT-00108-2017', 'Relatório Final contendo, quando possível:\r\na) Conclusões acerca da aptidão de implementação da inovação ou tecnologia na empresa participante;\r\nb) Análise individual quanto a possibilidade de aplicação do conteúdo no dia a dia da empresa;\r\nc) Percentual de clientes com avaliação positiva quanto à aptidão de implementação da inovação ou tecnologia demonstrada;\r\nd) Potenciais verificados para a empresa no que tange os produtos SEBRAE.', 'S', NULL, 'Cadastrado em: 04/04/2017.\r\nResponsável: Eduardo Garrido (UAIT).', 'RELATÓRIO CONCLUSÃO', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');
  INSERT INTO `db_pir_gec`.`gec_documento` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `observacao`, `sigla`, `nivel`, `link`, `arquivo`, `tipo`, `tipo_documento`, `data_emissao_mostra`, `data_emissao_label`, `data_emissao_aviso`, `data_vencimento_mostra`, `data_vencimento_label`, `data_vencimento_aviso`, `idt_pais_mostra`, `idt_pais_label`, `idt_estado_mostra`, `idt_estado_label`, `numero_mostra`, `numero_label`, `serie_mostra`, `serie_label`, `tamanho_maximo`, `obrigatorio`, `doc_sgtec`) VALUES ('170', 'UAIT-00109-2017', 'Cópia dos slides apresentados aos empresários.', 'S', NULL, 'Cadastrado em: 04/04/2017.\r\nResponsável: Eduardo Garrido (UAIT).', 'SLIDES', 'S', NULL, NULL, 'PJ', 'EV', 'N', NULL, NULL, 'N', NULL, NULL, 'N', NULL, 'N', NULL, 'N', NULL, 'N', NULL, '100', 'S', 'S');

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

echo 'Concluído...';

/**
 * Copia dados para tabela nova
 * @access public
 * */
function copiaTabelaNova() {
    global $vetTabelaMigracao, $con_origem, $con_destino;

    echo 'Limpando Tabelas Básicas<br/>';

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
 * Função auxilixar para a função cria_rascunho_produto
 * @access public
 * @return array
 * @param string $tabela_pai <p>
 * Nome da tabela pai
 * </p>
 * @param string $campo_pai <p>
 * Campo que faz a ligação com a tabela pai
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
