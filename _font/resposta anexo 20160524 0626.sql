CREATE TABLE `grc_avaliacao_secao_anexo` (
  `idt` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idt_avaliacao_secao` int(10) unsigned NOT NULL,
  `descricao` varchar(120) NOT NULL,
  `observacao` text,
  `idt_responsavel` int(11) NOT NULL,
  `data_responsavel` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `arquivo` varchar(120) NOT NULL,
  PRIMARY KEY (`idt`),
  KEY `iu_grc_avaliacao_secao_anexo` (`idt_avaliacao_secao`,`descricao`),
  KEY `FK_grc_avaliacao_resposta_anexo_2` (`idt_responsavel`),
  CONSTRAINT `FK_grc_avaliacao_secao_anexo_1` FOREIGN KEY (`idt_acaliacao_secao`) REFERENCES `grc_avaliacao_secao` (`idt`) ON DELETE CASCADE,
  CONSTRAINT `FK_grc_avaliacao_secao_anexo_2` FOREIGN KEY (`idt_responsavel`) REFERENCES `plu_usuario` (`id_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
