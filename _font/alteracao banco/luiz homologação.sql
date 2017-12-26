-- 21/10/2017

-- FUNIL

ALTER TABLE `db_pir_grc`.`grc_funil_2017_cliente_classificado` ADD COLUMN `meta7` CHAR(1) AFTER `meta2`;
ALTER TABLE `db_pir_grc`.`grc_funil_2017_gestao_meta` DROP INDEX `Index_7`,
 ADD INDEX `Index_7` USING BTREE(`cnpj`, `meta1`),
 ADD INDEX `Index_8`(`cnpj`, `meta7`);

ALTER TABLE `db_pir_grc`.`grc_funil_2017_gestao_meta` ADD COLUMN `campo_semcnpj` VARCHAR(45) AFTER `codmicro`;

ALTER TABLE `db_pir_grc`.`grc_funil_2017_cliente_classificado` ADD COLUMN `campo_semcnpj` VARCHAR(45) AFTER `meta7`;


ALTER TABLE `db_pir_grc`.`grc_funil_2017_cliente_classificado` ADD COLUMN `tipo_empreendimento` VARCHAR(120) AFTER `campo_semcnpj`;

ALTER TABLE `db_pir_grc`.`grc_atendimento_resumo` ADD COLUMN `complemento_acao` VARCHAR(500) AFTER `marcacao`;

ALTER TABLE `db_pir_grc`.`grc_funil_2017_gestao_meta` ADD COLUMN `codempreendimento` INTEGER UNSIGNED AFTER `campo_semcnpj`;


ALTER TABLE `db_pir_grc`.`grc_funil_parametro` ADD COLUMN `msgClienteSemClassificacao` VARCHAR(500) AFTER `ano_ativo`;

ALTER TABLE `db_pir_grc`.`grc_funil_parametro` CHANGE COLUMN `msgClienteSemClassificacao` `msgclientesemclassificacao` VARCHAR(500) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL;


ALTER TABLE `db_pir_gec`.`gec_entidade` ADD COLUMN `funil_cliente_data_avaliacao` DATETIME AFTER `funil_idt_cliente_classificacao`,
 ADD COLUMN `funil_cliente_obs_avaliacao` VARCHAR(255) AFTER `funil_cliente_data_avaliacao`;



ALTER TABLE `db_pir_grc`.`grc_atendimento_organizacao` ADD COLUMN `funil_cliente_data_avaliacao` DATETIME AFTER `funil_idt_cliente_classificacao`,
 ADD COLUMN `funil_cliente_obs_avaliacao` VARCHAR(255) AFTER `funil_cliente_data_avaliacao`;



ALTER TABLE `db_pir_grc`.`grc_entidade_organizacao` ADD COLUMN `funil_cliente_data_avaliacao` DATETIME AFTER `funil_idt_cliente_classificacao`,
 ADD COLUMN `funil_cliente_obs_avaliacao` VARCHAR(255) AFTER `funil_cliente_data_avaliacao`;



-- AGENDAMENTO




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