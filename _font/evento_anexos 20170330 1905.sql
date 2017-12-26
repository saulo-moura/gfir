CREATE TABLE `grc_evento_publicacao` (
  `idt` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idt_evento` int(10) unsigned NOT NULL,
  `descricao` varchar(120) NOT NULL,
  `observacao` text,
  `idt_responsavel` int(11) NOT NULL,
  `data_responsavel` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `arquivo` varchar(120) NOT NULL,
  `ativo` char(1) NOT NULL DEFAULT 'N',
  PRIMARY KEY (`idt`),
  KEY `iu_grc_evento_publicacao` (`idt_evento`,`descricao`),
  KEY `FK_grc_evento_publicacao_2` (`idt_responsavel`),
  CONSTRAINT `FK_grc_evento_publicacao_1` FOREIGN KEY (`idt_evento`) REFERENCES `grc_evento` (`idt`) ON DELETE CASCADE,
  CONSTRAINT `FK_grc_evento_publicacao_2` FOREIGN KEY (`idt_responsavel`) REFERENCES `plu_usuario` (`id_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
