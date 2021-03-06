CREATE TABLE `gec_contratacao_credenciado_ordem_lista_anexo` (
  `idt` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idt_origem` int(10) unsigned DEFAULT NULL,
  `idt_gec_contratacao_credenciado_ordem_lista` int(10) unsigned NOT NULL,
  `data_cadastro` datetime NOT NULL,
  `idt_usuario` int(11) NOT NULL,
  `arquivo` varchar(120) DEFAULT NULL,
  `observacao` varchar(2000) DEFAULT NULL,
  `data_emissao` date DEFAULT NULL,
  `data_vencimento` date DEFAULT NULL,
  `numero` varchar(45) DEFAULT NULL,
  `serie` varchar(45) DEFAULT NULL,
  `idt_pais` int(10) unsigned DEFAULT NULL,
  `idt_estado` int(11) DEFAULT NULL,
  PRIMARY KEY (`idt`),
  KEY `FK_gec_contratacao_credenciado_ordem_lista_2` (`idt_usuario`),
  KEY `FK_gec_contratacao_credenciado_ordem_lista_3` (`idt_pais`),
  KEY `FK_gec_contratacao_credenciado_ordem_lista_4` (`idt_estado`),
  KEY `FK_gec_contratacao_credenciado_ordem_lista_1` (`idt_entidade_documento`),
  CONSTRAINT `FK_gec_contratacao_credenciado_ordem_lista_3` FOREIGN KEY (`idt_pais`) REFERENCES `plu_pais` (`idt`),
  CONSTRAINT `FK_gec_contratacao_credenciado_ordem_lista_4` FOREIGN KEY (`idt_estado`) REFERENCES `plu_estado` (`idt`),
  CONSTRAINT `FK_gec_contratacao_credenciado_ordem_lista_1` FOREIGN KEY (`idt_gec_contratacao_credenciado_ordem_lista`) REFERENCES `gec_contratacao_credenciado_ordem_lista_endidade` (`idt`) ON UPDATE CASCADE,
  CONSTRAINT `FK_gec_contratacao_credenciado_ordem_lista_2` FOREIGN KEY (`idt_usuario`) REFERENCES `plu_usuario` (`id_usuario`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
