CREATE TABLE `plu_helpdesk_anexo` (
  `idt` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idt_helpdesk` int(10) unsigned NOT NULL,
  `descricao` varchar(120) NOT NULL,
  `observacao` text,
  `idt_responsavel` int(11) NOT NULL,
  `data_responsavel` datetime NOT NULL,
  `arquivo` varchar(120) NOT NULL,
  PRIMARY KEY (`idt`),
  KEY `iu_plu_helpdesk_anexo` (`idt_atendimento`,`descricao`),
  KEY `FK_plu_helpdesk_anexo_2` (`idt_responsavel`),
  CONSTRAINT `FK_plu_helpdesk_anexo_1` FOREIGN KEY (`helpdesk`) REFERENCES `plu_helpdesk` (`idt`) ON UPDATE CASCADE,
  CONSTRAINT `FK_plu_helpdesk_anexo_2` FOREIGN KEY (`idt_responsavel`) REFERENCES `plu_usuario` (`id_usuario`) ON UPDATE CASCADE
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;
