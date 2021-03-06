CREATE TABLE `grc_comunicacao` (
  `idt` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `login` varchar(255) DEFAULT NULL,
  `datahora` datetime DEFAULT NULL,
  `ip` varchar(45) DEFAULT NULL,
  `anonimo_nome` varchar(120) DEFAULT NULL,
  `anomimo_email` varchar(120) DEFAULT NULL,
  `latitude` decimal(15,9) DEFAULT NULL,
  `longitude` decimal(15,9) DEFAULT NULL,
  `titulo` varchar(120) NOT NULL,
  `descricao` text NOT NULL,
  `macroprocesso` varchar(45) DEFAULT NULL,
  `protocolo` varchar(45) NOT NULL,
  `nome` varchar(120) DEFAULT NULL,
  `email` varchar(120) DEFAULT NULL,
  `navegador` varchar(1000) DEFAULT NULL,
  `tipo_dispositivo` varchar(255) DEFAULT NULL,
  `modelo` varchar(255) DEFAULT NULL,
  `status` char(1) NOT NULL DEFAULT 'A',
  `tipo_solicitacao` char(2) NOT NULL DEFAULT 'NA',
  `data_envio_email_comunicacao` datetime DEFAULT NULL,
  `mandou_email_comunicacao` varchar(120) DEFAULT NULL,
  `complemento` text,
  `idt_comunicacao` int(10) unsigned DEFAULT NULL,
  `flag_logico` char(1) NOT NULL DEFAULT 'I',
  `msg_erro` text,
  PRIMARY KEY (`idt`),
  UNIQUE KEY `iu_protocolo` (`protocolo`),
  KEY `ix_login` (`login`,`datahora`),
  KEY `ix_datahora` (`datahora`,`login`),
  KEY `ix_ip` (`ip`),
  KEY `ix_macroprocesso` (`macroprocesso`),
  KEY `FK_grc_comunicacao_1` (`idt_comunicacao`),
  CONSTRAINT `FK_grc_comunicacao_1` FOREIGN KEY (`idt_comunicacao`) REFERENCES `grc_comunicacao` (`idt`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `grc_comunicacao_anexo` (
  `idt` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idt_comunicacao` int(10) unsigned NOT NULL,
  `descricao` varchar(120) NOT NULL,
  `observacao` text,
  `idt_responsavel` int(11) NOT NULL,
  `data_responsavel` datetime NOT NULL,
  `arquivo` varchar(120) NOT NULL,
  PRIMARY KEY (`idt`),
  KEY `iu_grc_comunicacao_anexo` (`idt_comunicacao`,`descricao`),
  KEY `FK_grc_comunicacao_anexo_2` (`idt_responsavel`),
  CONSTRAINT `FK_grc_comunicacao_anexo_1` FOREIGN KEY (`idt_comunicacao`) REFERENCES `grc_comunicacao` (`idt`) ON UPDATE CASCADE,
  CONSTRAINT `FK_grc_comunicacao_anexo_2` FOREIGN KEY (`idt_responsavel`) REFERENCES `plu_usuario` (`id_usuario`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `grc_comunicacao_grupo` (
  `idt` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `protocolo` varchar(45) NOT NULL,
  `descricao` varchar(120) NOT NULL,
  `data_registro` int(10) unsigned NOT NULL,
  `idt_responsavel` int(10) unsigned NOT NULL,
  PRIMARY KEY (`idt`),
  UNIQUE KEY `iu_grc_comunicacao_grupo` (`protocolo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `grc_comunicacao_grupo_sa` (
  `idt` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idt_comunicacao_grupo` varchar(45) NOT NULL,
  `idt_comunicacao` varchar(45) NOT NULL,
  `data_registro` datetime NOT NULL,
  `idt_responsavel` int(10) unsigned NOT NULL,
  PRIMARY KEY (`idt`),
  UNIQUE KEY `iu_grc_comunicacao_grupo_sa` (`idt_comunicacao_grupo`,`idt_comunicacao`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `grc_comunicacao_interacao` (
  `idt` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `login` varchar(255) DEFAULT NULL,
  `datahora` datetime DEFAULT NULL,
  `ip` varchar(45) DEFAULT NULL,
  `anonimo_nome` varchar(120) DEFAULT NULL,
  `anomimo_email` varchar(120) DEFAULT NULL,
  `latitude` decimal(15,9) DEFAULT NULL,
  `longitude` decimal(15,9) DEFAULT NULL,
  `titulo` varchar(120) NOT NULL,
  `descricao` text NOT NULL,
  `macroprocesso` varchar(45) DEFAULT NULL,
  `protocolo` varchar(45) NOT NULL,
  `nome` varchar(120) DEFAULT NULL,
  `email` varchar(120) DEFAULT NULL,
  `navegador` varchar(1000) DEFAULT NULL,
  `tipo_dispositivo` varchar(255) DEFAULT NULL,
  `modelo` varchar(255) DEFAULT NULL,
  `status` char(1) NOT NULL DEFAULT 'A',
  `tipo_solicitacao` char(2) NOT NULL DEFAULT 'NA',
  `data_envio_email_comunicacao` datetime DEFAULT NULL,
  `mandou_email_comunicacao` varchar(120) DEFAULT NULL,
  `complemento` text,
  `idt_comunicacao_interacao` int(10) unsigned DEFAULT NULL,
  `idt_comunicacao` int(10) unsigned NOT NULL,
  `flag_logico` char(1) NOT NULL DEFAULT 'I',
  `numero_id_comunicacao_usuario` varchar(255) DEFAULT NULL,
  `idt_comunicacao_interacao_ref` int(10) unsigned DEFAULT NULL,
  `idt_email_conteudo` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`idt`),
  UNIQUE KEY `iu_protocolo` (`idt_comunicacao`,`protocolo`) USING BTREE,
  KEY `ix_login` (`login`,`datahora`),
  KEY `ix_datahora` (`datahora`,`login`),
  KEY `ix_ip` (`ip`),
  KEY `ix_macroprocesso` (`macroprocesso`),
  KEY `FK_grc_comunicacao_interacao_1` (`idt_comunicacao_interacao`),
  KEY `FK_grc_comunicacao_interacao_3` (`idt_email_conteudo`),
  CONSTRAINT `FK_grc_comunicacao_interacao_1` FOREIGN KEY (`idt_comunicacao_interacao`) REFERENCES `grc_comunicacao_interacao` (`idt`),
  CONSTRAINT `FK_grc_comunicacao_interacao_2` FOREIGN KEY (`idt_comunicacao`) REFERENCES `grc_comunicacao` (`idt`),
  CONSTRAINT `FK_grc_comunicacao_interacao_3` FOREIGN KEY (`idt_email_conteudo`) REFERENCES `plu_email_conteudo` (`idt`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
