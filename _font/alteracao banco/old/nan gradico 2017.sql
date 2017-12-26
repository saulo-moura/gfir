-- 20/05/2017

INSERT INTO `db_pir_grc`.`grc_nan_devolutiva_item` (`idt`, `idt_devolutiva`, `codigo`, `descricao`, `ativo`, `detalhe`, `tipo`, `include`, `width`, `height`, `background`, `color`) VALUES ('15', '1', '27', 'SUA EVOLUÇÃO NO PROJETO NEGÓCIO A NEGÓCIO', 'S', 'O Gráfico abaixo mostra a evolução de seu desempenho em relação aos ciclos anteriores deste projeto. É importante que você nunca deixe a inércia tomar conta de sua empresa!', '3', 'grc_nan_devolutiva_rel_27', NULL, NULL, NULL, NULL);

CREATE TABLE `grc_nan_ciclo_setor` (
  `idt` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ciclo` int(10) unsigned NOT NULL,
  `idt_setor` int(10) unsigned DEFAULT NULL,
  `descricao_setor` varchar(120) DEFAULT NULL,
  `cnpj` varchar(45) DEFAULT NULL,
  `razao_social` varchar(120) DEFAULT NULL,
  `area` varchar(45) DEFAULT NULL,
  `valor` decimal(15,2) DEFAULT NULL,
  `idt_avaliacao` int(10) unsigned DEFAULT NULL,
  `idt_area` int(10) unsigned DEFAULT NULL,
  `descricao_area` varchar(120) DEFAULT NULL,
  `valor_inv` decimal(15,2) DEFAULT NULL,
  `valor_medio` decimal(15,2) DEFAULT NULL,
  `valor_medio_inv` decimal(15,2) DEFAULT NULL,
  `tipo` char(1) DEFAULT NULL,
  `quantidade` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`idt`),
  KEY `ix_grc_nan_ciclo_setor` (`ciclo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `grc_nan_ciclo_setor`
ADD INDEX `ix_grc_nan_ciclo_setor_2` (`tipo`, `ciclo`, `idt_setor`) USING BTREE ;

-- sala
-- desenvolvimento
-- producao
-- homologacao