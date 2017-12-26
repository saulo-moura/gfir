-- esmeraldo

-- luiz

-- 09-08-2016


ALTER TABLE `db_pir_grc`.`plu_helpdesk` ADD COLUMN `complemento` TEXT AFTER `mandou_email_helpdesk`;


ALTER TABLE `db_pir_grc`.`plu_helpdesk` ADD COLUMN `idt_helpdesk` INTEGER UNSIGNED AFTER `complemento`,
 ADD CONSTRAINT `FK_plu_helpdesk_1` FOREIGN KEY `FK_plu_helpdesk_1` (`idt_helpdesk`)
    REFERENCES `plu_helpdesk` (`idt`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT;


CREATE TABLE `db_pir_grc`.`plu_helpdesk_grupo` (
  `idt` INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  `protocolo` VARCHAR(45) NOT NULL,
  `descricao` VARCHAR(120) NOT NULL,
  `data_registro` INTEGER UNSIGNED NOT NULL,
  `idt_responsavel` INTEGER UNSIGNED NOT NULL,
  PRIMARY KEY (`idt`),
  UNIQUE INDEX `iu_plu_helpdesk_grupo`(`protocolo`)
)
ENGINE = InnoDB;

CREATE TABLE `db_pir_grc`.`plu_helpdesk_grupo_sa` (
  `idt` INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  `idt_helpdesk_grupo` VARCHAR(45) NOT NULL,
  `idt_helpdesk` VARCHAR(45) NOT NULL,
  `data_registro` DATETIME NOT NULL,
  `idt_responsavel` INTEGER UNSIGNED NOT NULL,
  PRIMARY KEY (`idt`),
  UNIQUE INDEX `iu_plu_helpdesk_grupo_sa`(`idt_helpdesk_grupo`, `idt_helpdesk`)
)
ENGINE = InnoDB;

CREATE TABLE `plu_helpdesk_interacao` (
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
  `data_envio_email_helpdesk` datetime DEFAULT NULL,
  `mandou_email_helpdesk` varchar(120) DEFAULT NULL,
  `complemento` text,
  `idt_helpdesk_interacao` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`idt`),
  UNIQUE KEY `iu_protocolo` (`protocolo`),
  KEY `ix_login` (`login`,`datahora`),
  KEY `ix_datahora` (`datahora`,`login`),
  KEY `ix_ip` (`ip`),
  KEY `ix_macroprocesso` (`macroprocesso`),
  KEY `FK_plu_helpdesk_interacao_1` (`idt_helpdesk_interacao`),
  CONSTRAINT `FK_plu_helpdesk_interacao_1` FOREIGN KEY (`idt_helpdesk_interacao`) REFERENCES `plu_helpdesk_interacao` (`idt`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `db_pir_grc`.`plu_helpdesk_interacao` ADD COLUMN `idt_helpdesk` INTEGER UNSIGNED NOT NULL AFTER `idt_helpdesk_interacao`,
 ADD CONSTRAINT `FK_plu_helpdesk_interacao_2` FOREIGN KEY `FK_plu_helpdesk_interacao_2` (`idt_helpdesk`)
    REFERENCES `plu_helpdesk` (`idt`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT;
	
	
insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('plu_helpdesk_interacao','Interação no HelpDesk','90.80.80.03.05','S','S','listar','listar');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'plu_helpdesk_interacao') as id_funcao
from plu_direito where cod_direito in ('alt','con','exc','inc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('plu_helpdesk_interacao');


CREATE TABLE `plu_helpdesk_interacao_anexo` (
  `idt` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idt_helpdesk_interacao` int(10) unsigned NOT NULL,
  `descricao` varchar(120) NOT NULL,
  `observacao` text,
  `idt_responsavel` int(11) NOT NULL,
  `data_responsavel` datetime NOT NULL,
  `arquivo` varchar(120) NOT NULL,
  PRIMARY KEY (`idt`),
  KEY `iu_plu_helpdesk_interacao_anexo` (`idt_helpdesk_interacao`,`descricao`),
  KEY `FK_plu_helpdesk_interacao_anexo_2` (`idt_responsavel`),
  CONSTRAINT `FK_plu_helpdesk_interacao_anexo_1` FOREIGN KEY (`idt_helpdesk_interacao`) REFERENCES `plu_helpdesk_interacao` (`idt`) ON UPDATE CASCADE,
  CONSTRAINT `FK_plu_helpdesk_interacao_anexo_2` FOREIGN KEY (`idt_responsavel`) REFERENCES `plu_usuario` (`id_usuario`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('plu_helpdesk_interacao_anexo','Anexos da Interação no HelpDesk','90.80.80.03.05.03','S','S','listar','listar');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'plu_helpdesk_interacao_anexo') as id_funcao
from plu_direito where cod_direito in ('alt','con','exc','inc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('plu_helpdesk_interacao_anexo');

ALTER TABLE `db_pir_grc`.`plu_helpdesk_interacao_anexo` ADD CONSTRAINT `FK_plu_helpdesk_interacao_anexo_3` FOREIGN KEY `FK_plu_helpdesk_interacao_anexo_3` (`idt_helpdesk_interacao`)
    REFERENCES `plu_helpdesk_interacao` (`idt`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT;
	
ALTER TABLE `db_pir_grc`.`plu_helpdesk` ADD COLUMN `flag_logico` char(1) NOT NULL DEFAULT 'I' AFTER `idt_helpdesk`;

ALTER TABLE `db_pir_grc`.`plu_helpdesk_interacao` ADD COLUMN `flag_logico` CHAR(1) NOT NULL DEFAULT 'I' AFTER `idt_helpdesk`;

-- producao
-- sala
