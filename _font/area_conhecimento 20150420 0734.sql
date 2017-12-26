CREATE TABLE `gec_documento` (
  `idt` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `codigo` varchar(45) NOT NULL,
  `descricao` varchar(120) NOT NULL,
  `ativo` varchar(1) NOT NULL DEFAULT 'S',
  `detalhe` text,
  PRIMARY KEY (`idt`),
  UNIQUE KEY `iu_gec_documento` (`codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `gec_metodologia` (
  `idt` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `codigo` varchar(45) NOT NULL,
  `descricao` varchar(120) NOT NULL,
  `ativo` varchar(1) NOT NULL DEFAULT 'S',
  `detalhe` text,
  PRIMARY KEY (`idt`),
  UNIQUE KEY `iu_gec_metodologia` (`codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;