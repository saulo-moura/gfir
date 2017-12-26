-- OS 13
-- Criar formulário de Estrelinha
INSERT INTO `db_pir_grc`.`grc_formulario` (`idt`, `codigo`, `descricao`, `ativo`, `detalhe`, `qtd_pontos`, `idt_aplicacao`, `idt_responsavel`, `idt_area_responsavel`, `versao_texto`, `versao_numero`, `data_inicio_aplicacao`, `data_termino_aplicacao`, `observacao`, `idt_dimensao`, `controle_pontos`, `grupo`, `idt_instrumento`) VALUES ('14', '700', 'Avaliação de Eventos - Estrelinhas', 'S', 'Avaliação Geral dos Eventos na forma das cinco Estrelinhas.', '100', '5', '90', '64', 'V.01', '1.00', NULL, NULL, NULL, '7', 'S', 'MEDE', NULL);
INSERT INTO `db_pir_grc`.`grc_formulario_secao` (`idt`, `idt_formulario`, `codigo`, `descricao`, `detalhe`, `qtd_pontos`, `valido`, `idt_formulario_area`, `idt_formulario_relevancia`, `evidencia`) VALUES ('204', '14', 'SE0000048', 'Avaliação de Estrelinhas', 'Avaliação da forma Estrelinha', '100', 'S', '22', '5', 'N');
INSERT INTO `db_pir_grc`.`grc_formulario_pergunta` (`idt`, `idt_secao`, `codigo`, `descricao`, `detalhe`, `qtd_pontos`, `valido`, `idt_classe`, `ajuda`, `idt_ferramenta`, `obrigatoria`, `evidencias`, `idt_dimensao`, `codigo_quesito`, `sigla_dimensao`) VALUES ('1362', '204', '1', 'Como você avalia esse Evento?', NULL, '100', 'S', NULL, NULL, NULL, 'N', NULL, NULL, NULL, NULL);
INSERT INTO `db_pir_grc`.`grc_formulario_resposta` (`idt`, `idt_pergunta`, `codigo`, `descricao`, `detalhe`, `qtd_pontos`, `valido`, `campo_txt`, `idt_classe`) VALUES ('4045', '1362', '1', 'Uma Estrelinha', NULL, '0', 'S', 'N', '2');
INSERT INTO `db_pir_grc`.`grc_formulario_resposta` (`idt`, `idt_pergunta`, `codigo`, `descricao`, `detalhe`, `qtd_pontos`, `valido`, `campo_txt`, `idt_classe`) VALUES ('4046', '1362', '2', 'Duas Estrelinhas', NULL, '25', 'S', 'N', '2');
INSERT INTO `db_pir_grc`.`grc_formulario_resposta` (`idt`, `idt_pergunta`, `codigo`, `descricao`, `detalhe`, `qtd_pontos`, `valido`, `campo_txt`, `idt_classe`) VALUES ('4047', '1362', '3', 'Três Estrelinhas', NULL, '25', 'S', 'N', '2');
INSERT INTO `db_pir_grc`.`grc_formulario_resposta` (`idt`, `idt_pergunta`, `codigo`, `descricao`, `detalhe`, `qtd_pontos`, `valido`, `campo_txt`, `idt_classe`) VALUES ('4048', '1362', '4', 'Quatro Estrelinhas', NULL, '25', 'S', 'N', '2');
INSERT INTO `db_pir_grc`.`grc_formulario_resposta` (`idt`, `idt_pergunta`, `codigo`, `descricao`, `detalhe`, `qtd_pontos`, `valido`, `campo_txt`, `idt_classe`) VALUES ('4049', '1362', '5', 'Cinco Estrelinhas', NULL, '25', 'S', 'N', '2');



-- sala