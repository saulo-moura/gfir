delete from db_pir_grc.grc_formulario_resposta;
alter table db_pir_grc.grc_formulario_resposta AUTO_INCREMENT=1;

delete from db_pir_grc.grc_formulario_pergunta;
alter table db_pir_grc.grc_formulario_pergunta AUTO_INCREMENT=1;

delete from db_pir_grc.grc_formulario_secao;
alter table db_pir_grc.grc_formulario_secao AUTO_INCREMENT=1;

delete from db_pir_grc.grc_formulario;
alter table db_pir_grc.grc_formulario AUTO_INCREMENT=1;

-- NAN 06-04-2016
CREATE TABLE `grc_formulario_area` (
  `idt` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `codigo` varchar(45) NOT NULL,
  `descricao` varchar(120) NOT NULL,
  `ativo` varchar(1) NOT NULL,
  `detalhe` text,
  PRIMARY KEY (`idt`),
  UNIQUE KEY `iu_grc_formulario_area` (`codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;


insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_formulario_area','Áreas para Diagnóstico','30.99.10','S','S','listar','listar');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_formulario_area') as id_funcao
from plu_direito where cod_direito in ('alt','con','exc','inc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_formulario_area');


ALTER TABLE `db_pir_grc`.`grc_formulario_secao` ADD COLUMN `idt_formulario_area` INTEGER UNSIGNED AFTER `valido`,
 ADD CONSTRAINT `FK_grc_formulario_secao_2` FOREIGN KEY `FK_grc_formulario_secao_2` (`idt_formulario_area`)
    REFERENCES `grc_formulario_area` (`idt`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE;
	
ALTER TABLE `db_pir_grc`.`grc_formulario_secao` MODIFY COLUMN `idt_formulario_area` INT(10) UNSIGNED NOT NULL;



CREATE TABLE `grc_formulario_relevancia` (
  `idt` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `codigo` varchar(45) NOT NULL,
  `descricao` varchar(120) NOT NULL,
  `ativo` varchar(1) NOT NULL,
  `detalhe` text,
  PRIMARY KEY (`idt`),
  UNIQUE KEY `iu_grc_formulario_relevancia` (`codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;


insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_formulario_relevancia','Relevância da Área para Diagnóstico','30.99.13','S','S','listar','listar');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_formulario_relevancia') as id_funcao
from plu_direito where cod_direito in ('alt','con','exc','inc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_formulario_relevancia');


ALTER TABLE `db_pir_grc`.`grc_formulario_secao` ADD COLUMN `idt_formulario_relevancia` integer UNSIGNED AFTER `idt_formulario_area`;
ALTER TABLE `db_pir_grc`.`grc_formulario_secao` ADD CONSTRAINT `FK_grc_formulario_secao_3` FOREIGN KEY `FK_grc_formulario_secao_3` (`idt_formulario_relevancia`)
    REFERENCES `grc_formulario_relevancia` (`idt`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE;


ALTER TABLE `db_pir_grc`.`grc_formulario_pergunta` MODIFY COLUMN `codigo` INTEGER UNSIGNED NOT NULL;

ALTER TABLE `db_pir_grc`.`grc_formulario_resposta` MODIFY COLUMN `codigo` INTEGER UNSIGNED NOT NULL;




CREATE TABLE `grc_formulario_classe_pergunta` (
  `idt` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `codigo` varchar(45) NOT NULL,
  `descricao` varchar(120) NOT NULL,
  `ativo` varchar(1) NOT NULL,
  `detalhe` text,
  PRIMARY KEY (`idt`),
  UNIQUE KEY `iu_grc_formulario_classe_pergunta` (`codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;


insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_formulario_classe_pergunta','Classe da Pergunta','30.99.16','S','S','listar','listar');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_formulario_classe_pergunta') as id_funcao
from plu_direito where cod_direito in ('alt','con','exc','inc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_formulario_classe_pergunta');




CREATE TABLE `grc_formulario_classe_resposta` (
  `idt` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `codigo` varchar(45) NOT NULL,
  `descricao` varchar(120) NOT NULL,
  `ativo` varchar(1) NOT NULL,
  `detalhe` text,
  PRIMARY KEY (`idt`),
  UNIQUE KEY `iu_grc_formulario_classe_resposta` (`codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;


insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_formulario_classe_resposta','Classe da Resposta','30.99.17','S','S','listar','listar');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_formulario_classe_resposta') as id_funcao
from plu_direito where cod_direito in ('alt','con','exc','inc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_formulario_classe_resposta');


ALTER TABLE `db_pir_grc`.`grc_formulario_pergunta` ADD COLUMN `idt_classe` INTEGER UNSIGNED NOT NULL AFTER `valido`;
ALTER TABLE `db_pir_grc`.`grc_formulario_resposta` ADD COLUMN `idt_classe` INTEGER UNSIGNED NOT NULL AFTER `campo_txt`;


ALTER TABLE `db_pir_grc`.`grc_formulario_resposta` ADD CONSTRAINT `FK_grc_formulario_resposta_2` FOREIGN KEY `FK_grc_formulario_resposta_2` (`idt_classe`)
    REFERENCES `grc_formulario_classe_resposta` (`idt`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE;
ALTER TABLE `db_pir_grc`.`grc_formulario_pergunta` ADD CONSTRAINT `FK_grc_formulario_pergunta_3` FOREIGN KEY `FK_grc_formulario_pergunta_3` (`idt_classe`)
    REFERENCES `grc_formulario_classe_pergunta` (`idt`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE;
ALTER TABLE `db_pir_grc`.`grc_formulario_pergunta` ADD COLUMN `ajuda` TEXT AFTER `idt_classe`;


CREATE TABLE `grc_formulario_dimensao_resposta` (
  `idt` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `codigo` varchar(45) NOT NULL,
  `descricao` varchar(120) NOT NULL,
  `ativo` varchar(1) NOT NULL,
  `detalhe` text,
  PRIMARY KEY (`idt`),
  UNIQUE KEY `iu_grc_formulario_dimensao_resposta` (`codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;


insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_formulario_dimensao_resposta','Dimensão para Respostas','30.99.20','S','S','listar','listar');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_formulario_dimensao_resposta') as id_funcao
from plu_direito where cod_direito in ('alt','con','exc','inc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_formulario_dimensao_resposta');




CREATE TABLE `grc_formulario_ferramenta_gestao` (
  `idt` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `codigo` varchar(45) NOT NULL,
  `descricao` varchar(120) NOT NULL,
  `ativo` varchar(1) NOT NULL,
  `detalhe` text,
  PRIMARY KEY (`idt`),
  UNIQUE KEY `iu_grc_formulario_ferramenta_gestao` (`codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;


insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_formulario_ferramenta_gestao','Ferramentas de Gestão','30.99.23','S','S','listar','listar');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_formulario_ferramenta_gestao') as id_funcao
from plu_direito where cod_direito in ('alt','con','exc','inc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_formulario_ferramenta_gestao');

ALTER TABLE `db_pir_grc`.`grc_formulario_pergunta` ADD COLUMN `idt_ferramenta` INTEGER UNSIGNED NOT NULL AFTER `ajuda`;
ALTER TABLE `db_pir_grc`.`grc_formulario_pergunta` ADD CONSTRAINT `FK_grc_formulario_pergunta_4` FOREIGN KEY `FK_grc_formulario_pergunta_4` (`idt_ferramenta`)
    REFERENCES `grc_formulario_ferramenta_gestao` (`idt`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE;



-- Painel Novo do NAN

insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_presencial_ativo','Presencial Ativo','95.51','S','S','inc','inc');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_presencial_ativo') as id_funcao
from plu_direito where cod_direito in ('alt','con','exc','inc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_presencial_ativo');








-- item para tabelas do NAN

insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_nan','NAN','05.70','S','S','listar','listar');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_nan') as id_funcao
from plu_direito where cod_direito in ('alt','con','exc','inc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_nan');

CREATE TABLE `grc_nan_estrutura` (
  `idt` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `codigo` varchar(45) NOT NULL,
  `descricao` varchar(120) NOT NULL,
  `ativo` varchar(1) NOT NULL,
  `detalhe` text,
  PRIMARY KEY (`idt`),
  UNIQUE KEY `iu_grc_nan_estrutura` (`codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_nan_estrutura','NAN - Estrutura Operacional','05.70.15','S','S','listar','listar');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_nan_estrutura') as id_funcao
from plu_direito where cod_direito in ('alt','con','exc','inc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_nan_estrutura');




CREATE TABLE `grc_nan_estrutura_tipo` (
  `idt` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `codigo` varchar(45) NOT NULL,
  `descricao` varchar(120) NOT NULL,
  `ativo` varchar(1) NOT NULL,
  `detalhe` text,
  PRIMARY KEY (`idt`),
  UNIQUE KEY `iu_grc_nan_estrutura_tipo` (`codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_nan_estrutura_tipo','NAN - Tipo de Estrutura','05.70.17','S','S','listar','listar');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_nan_estrutura_tipo') as id_funcao
from plu_direito where cod_direito in ('alt','con','exc','inc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_nan_estrutura_tipo');



CREATE TABLE `grc_nan_grupo_atendimento` (
  `idt` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `codigo` varchar(45) NOT NULL,
  `descricao` varchar(120) NOT NULL,
  `ativo` varchar(1) NOT NULL,
  `detalhe` text,
  PRIMARY KEY (`idt`),
  UNIQUE KEY `iu_grc_nan_grupo_atendimento` (`codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_nan_grupo_atendimento','NAN - Grupo de Atendimento','05.70.19','S','S','listar','listar');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_nan_grupo_atendimento') as id_funcao
from plu_direito where cod_direito in ('alt','con','exc','inc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_nan_grupo_atendimento');


-- Grupo de Atendimento

ALTER TABLE `db_pir_grc`.`grc_atendimento` ADD COLUMN `idt_grupo_atendimento` INTEGER UNSIGNED AFTER `rm_codcfo`;

ALTER TABLE `db_pir_grc`.`grc_atendimento` ADD CONSTRAINT `FK_grc_atendimento_21` FOREIGN KEY `FK_grc_atendimento_21` (`idt_grupo_atendimento`)
    REFERENCES `grc_nan_grupo_atendimento` (`idt`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE;

-- produto para o SGTEC


insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_sgtec','SGTEC','01.99.60','S','S','listar','listar');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_sgtec') as id_funcao
from plu_direito where cod_direito in ('alt','con','exc','inc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_sgtec');




CREATE TABLE `grc_sgtec_natureza` (
  `idt` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `codigo` varchar(45) NOT NULL,
  `descricao` varchar(120) NOT NULL,
  `ativo` varchar(1) NOT NULL,
  `detalhe` text,
  PRIMARY KEY (`idt`),
  UNIQUE KEY `iu_grc_sgtec_natureza` (`codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_sgtec_natureza','SGTEC - Natureza','01.99.60.03','S','S','listar','listar');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_sgtec_natureza') as id_funcao
from plu_direito where cod_direito in ('alt','con','exc','inc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_sgtec_natureza');


CREATE TABLE `grc_sgtec_modalidade` (
  `idt` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `codigo` varchar(45) NOT NULL,
  `descricao` varchar(120) NOT NULL,
  `ativo` varchar(1) NOT NULL,
  `detalhe` text,
  PRIMARY KEY (`idt`),
  UNIQUE KEY `iu_grc_sgtec_modalidade` (`codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_sgtec_modalidade','SGTEC - Modalidade','01.99.60.05','S','S','listar','listar');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_sgtec_modalidade') as id_funcao
from plu_direito where cod_direito in ('alt','con','exc','inc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_sgtec_modalidade');

CREATE TABLE `grc_sgtec_tipo_servico` (
  `idt` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `codigo` varchar(45) NOT NULL,
  `descricao` varchar(120) NOT NULL,
  `ativo` varchar(1) NOT NULL,
  `detalhe` text,
  PRIMARY KEY (`idt`),
  UNIQUE KEY `iu_grc_sgtec_tipo_servico` (`codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_sgtec_tipo_servico','SGTEC - Tipo de Serviço','01.99.60.07','S','S','listar','listar');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_sgtec_tipo_servico') as id_funcao
from plu_direito where cod_direito in ('alt','con','exc','inc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_sgtec_tipo_servico');


ALTER TABLE `db_pir_grc`.`grc_sgtec_tipo_servico` ADD COLUMN `idt_natureza` INTEGER UNSIGNED NOT NULL AFTER `detalhe`,
 ADD COLUMN `idt_modalidade` INTEGER UNSIGNED NOT NULL AFTER `idt_natureza`;

ALTER TABLE `db_pir_grc`.`grc_sgtec_tipo_servico` ADD CONSTRAINT `FK_grc_sgtec_tipo_servico_1` FOREIGN KEY `FK_grc_sgtec_tipo_servico_1` (`idt_natureza`)
    REFERENCES `grc_sgtec_natureza` (`idt`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE;
ALTER TABLE `db_pir_grc`.`grc_sgtec_tipo_servico` ADD CONSTRAINT `FK_grc_sgtec_tipo_servico_2` FOREIGN KEY `FK_grc_sgtec_tipo_servico_2` (`idt_modalidade`)
    REFERENCES `grc_sgtec_modalidade` (`idt`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE;
	
	
-- 08-04-2016	
	
	
ALTER TABLE `db_pir_grc`.`grc_formulario_ferramenta_gestao` ADD COLUMN `nivel` INTEGER UNSIGNED NOT NULL DEFAULT 1 AFTER `detalhe`;


ALTER TABLE `db_pir_grc`.`grc_formulario_ferramenta_gestao` ADD COLUMN `numero_pagina` INTEGER UNSIGNED AFTER `nivel`;

ALTER TABLE `db_pir_grc`.`grc_formulario_ferramenta_gestao` MODIFY COLUMN `codigo` INTEGER UNSIGNED NOT NULL;

ALTER TABLE `db_pir_grc`.`grc_formulario_ferramenta_gestao` MODIFY COLUMN `codigo` INTEGER UNSIGNED NOT NULL,
 ADD COLUMN `idt_area` INTEGER UNSIGNED NOT NULL AFTER `numero_pagina`;


ALTER TABLE `db_pir_grc`.`grc_formulario_ferramenta_gestao` ADD CONSTRAINT `FK_grc_formulario_ferramenta_gestao_1` FOREIGN KEY `FK_grc_formulario_ferramenta_gestao_1` (`idt_area`)
    REFERENCES `grc_formulario_area` (`idt`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE;

ALTER TABLE `db_pir_grc`.`grc_formulario` ADD COLUMN `idt_dimensao` INTEGER UNSIGNED NOT NULL AFTER `observacao`;

ALTER TABLE `db_pir_grc`.`grc_formulario` ADD CONSTRAINT `FK_grc_formulario_4` FOREIGN KEY `FK_grc_formulario_4` (`idt_dimensao`)
    REFERENCES `grc_formulario_dimensao_resposta` (`idt`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE;

ALTER TABLE `db_pir_grc`.`grc_formulario_pergunta` ADD COLUMN `obrigatoria` VARCHAR(1) NOT NULL DEFAULT 'S' AFTER `idt_ferramenta`,
 ADD COLUMN `evidencias` TEXT AFTER `obrigatoria`;


ALTER TABLE `db_pir_grc`.`grc_formulario` ADD COLUMN `controle_prontos` VARCHAR(1) NOT NULL DEFAULT 'N' AFTER `idt_dimensao`;

ALTER TABLE `db_pir_grc`.`grc_formulario` CHANGE COLUMN `controle_prontos` `controle_pontos` VARCHAR(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'N';


ALTER TABLE `db_pir_grc`.`grc_formulario_pergunta` MODIFY COLUMN `idt_ferramenta` INT(10) UNSIGNED DEFAULT NULL;

-- pontos

ALTER TABLE `db_pir_grc`.`grc_formulario` MODIFY COLUMN `qtd_pontos` INT(10) UNSIGNED DEFAULT NULL;
ALTER TABLE `db_pir_grc`.`grc_formulario_secao` MODIFY COLUMN `qtd_pontos` INT(10) DEFAULT NULL;
ALTER TABLE `db_pir_grc`.`grc_formulario_pergunta` MODIFY COLUMN `qtd_pontos` INT(10) DEFAULT NULL;
ALTER TABLE `db_pir_grc`.`grc_formulario_resposta` MODIFY COLUMN `qtd_pontos` INT(10) DEFAULT NULL;


-- anexo da resposta

CREATE TABLE `grc_avaliacao_resposta_anexo` (
  `idt` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idt_resposta` int(10) unsigned NOT NULL,
  `descricao` varchar(120) NOT NULL,
  `observacao` text,
  `idt_responsavel` int(11) NOT NULL,
  `data_responsavel` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `arquivo` varchar(120) NOT NULL,
  PRIMARY KEY (`idt`),
  KEY `iu_grc_avaliacao_resposta_anexo` (`idt_resposta`,`descricao`),
  KEY `FK_grc_avaliacao_resposta_anexo_2` (`idt_responsavel`),
  CONSTRAINT `FK_grc_avaliacao_resposta_anexo_1` FOREIGN KEY (`idt_resposta`) REFERENCES `grc_avaliacao_resposta` (`idt`) ON DELETE CASCADE,
  CONSTRAINT `FK_grc_avaliacao_resposta_anexo_2` FOREIGN KEY (`idt_responsavel`) REFERENCES `plu_usuario` (`id_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_avaliacao_resposta_anexo','Avaliação - Anexos da Resposta','30.05.03','N','N','listar','listar');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_avaliacao_resposta_anexo') as id_funcao
from plu_direito where cod_direito in ('alt','con','exc','inc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_avaliacao_resposta_anexo');

ALTER TABLE `db_pir_grc`.`grc_formulario_pergunta` MODIFY COLUMN `descricao` VARCHAR(2000) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL;
ALTER TABLE `db_pir_grc`.`grc_formulario_resposta` MODIFY COLUMN `descricao` VARCHAR(2000) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL;

ALTER TABLE `db_pir_grc`.`grc_formulario_dimensao_resposta` ADD COLUMN `agregador` VARCHAR(1) NOT NULL DEFAULT 'N' AFTER `detalhe`;


ALTER TABLE `db_pir_grc`.`grc_formulario_pergunta` ADD COLUMN `idt_dimensao` INTEGER UNSIGNED NOT NULL AFTER `evidencias`,
 DROP INDEX `iu_grc_formulario_pergunta`,
 ADD UNIQUE INDEX `iu_grc_formulario_pergunta` USING BTREE(`idt_secao`, `idt_dimensao`, `codigo`);

CREATE TABLE `db_pir_grc`.`grc_formulario_pergunta_pergunta` (
  `idt` INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  `idt_pergunta_n1` INTEGER UNSIGNED NOT NULL,
  `idt_pergunta_n2` INTEGER UNSIGNED NOT NULL,
  PRIMARY KEY (`idt`),
  UNIQUE INDEX `iu_grc_formulario_pergunta_pergunta`(`idt_pergunta_n1`, `idt_pergunta_n2`)
)
ENGINE = InnoDB;

insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_formulario_pergunta_pergunta','Associação de Perguntas','30.99.03.03.05','N','N','listar','listar');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_formulario_pergunta_pergunta') as id_funcao
from plu_direito where cod_direito in ('alt','con','exc','inc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_formulario_pergunta_pergunta');


ALTER TABLE `db_pir_grc`.`grc_formulario_pergunta` ADD COLUMN `codigo_quesito` INTEGER UNSIGNED AFTER `idt_dimensao`;

ALTER TABLE `db_pir_grc`.`grc_formulario_dimensao_resposta` ADD COLUMN `sigla` VARCHAR(5) AFTER `agregador`;

ALTER TABLE `db_pir_grc`.`grc_formulario_pergunta` ADD COLUMN `sigla_dimensao` VARCHAR(5) AFTER `codigo_quesito`;

ALTER TABLE `db_pir_grc`.`grc_avaliacao` MODIFY COLUMN `data_avaliacao` DATE NOT NULL;
ALTER TABLE `db_pir_grc`.`grc_avaliacao_resposta` MODIFY COLUMN `qtd_pontos` INT(10) UNSIGNED DEFAULT NULL;

CREATE TABLE `db_pir_grc`.`grc_nan_devolutiva` (
  `idt` INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  `codigo` VARCHAR(45) NOT NULL,
  `descricao` VARCHAR(45) NOT NULL,
  `ativo` VARCHAR(1) NOT NULL DEFAULT 'S',
  `detalhe` TEXT,
  `versao` INTEGER UNSIGNED,
  `versao_txt` VARCHAR(45),
  PRIMARY KEY (`idt`),
  UNIQUE INDEX `iu_grc_nan_devolutiva`(`codigo`)
)
ENGINE = InnoDB;
insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_nan_devolutiva','NAN - Devolutiva','05.70.21','S','S','listar','listar');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_nan_devolutiva') as id_funcao
from plu_direito where cod_direito in ('alt','con','exc','inc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_nan_devolutiva');


CREATE TABLE `db_pir_grc`.`grc_nan_devolutiva_item` (
  `idt` INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  `idt_devolutiva` INTEGER UNSIGNED NOT NULL,
  `codigo` VARCHAR(45) NOT NULL,
  `descricao` VARCHAR(255) NOT NULL,
  `ativo` VARCHAR(1) NOT NULL DEFAULT 'S',
  `detalhe` TEXT,
  PRIMARY KEY (`idt`),
  INDEX `iu_grc_nan_devolutiva_item`(`idt_devolutiva`, `codigo`)
)
ENGINE = InnoDB;

insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_nan_devolutiva_item','NAN - Devolutiva Item','05.70.23','N','N','listar','listar');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_nan_devolutiva_item') as id_funcao
from plu_direito where cod_direito in ('alt','con','exc','inc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_nan_devolutiva_item');

ALTER TABLE `db_pir_grc`.`grc_nan_devolutiva_item` ADD CONSTRAINT `FK_grc_nan_devolutiva_item_1` FOREIGN KEY `FK_grc_nan_devolutiva_item_1` (`idt_devolutiva`)
    REFERENCES `grc_nan_devolutiva` (`idt`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE;


ALTER TABLE `db_pir_grc`.`grc_nan_devolutiva_item` ADD COLUMN `tipo` VARCHAR(1) NOT NULL DEFAULT '1' AFTER `detalhe`;
ALTER TABLE `db_pir_grc`.`grc_nan_devolutiva_item` ADD COLUMN `include` VARCHAR(120) AFTER `tipo`;

ALTER TABLE `db_pir_grc`.`grc_nan_devolutiva_item` ADD COLUMN `width` INTEGER UNSIGNED AFTER `include`,
 ADD COLUMN `height` INTEGER UNSIGNED AFTER `width`;
ALTER TABLE `db_pir_grc`.`grc_nan_devolutiva_item` ADD COLUMN `background` VARCHAR(45) AFTER `height`,
 ADD COLUMN `color` VARCHAR(45) AFTER `background`;

-- esmeraldo

CREATE TABLE `grc_formulario_ferramenta_ead` (
  `idt` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `codigo` int(10) unsigned NOT NULL,
  `descricao` varchar(120) NOT NULL,
  `ativo` varchar(1) NOT NULL,
  `detalhe` text,
  `nivel` int(10) unsigned NOT NULL DEFAULT '1',
  `numero_pagina` int(10) unsigned DEFAULT NULL,
  `idt_area` int(10) unsigned NOT NULL,
  PRIMARY KEY (`idt`),
  UNIQUE KEY `iu_grc_formulario_ferramenta_ead` (`codigo`),
  KEY `FK_grc_formulario_ferramenta_ead_1` (`idt_area`),
  CONSTRAINT `FK_grc_formulario_ferramenta_ead_1` FOREIGN KEY (`idt_area`) REFERENCES `grc_formulario_area` (`idt`) ON UPDATE CASCADE
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;


insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_formulario_ferramenta_ead','Ferramentas do EAD','30.99.25','S','S','listar','listar');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_formulario_ferramenta_ead') as id_funcao
from plu_direito where cod_direito in ('alt','con','exc','inc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_formulario_ferramenta_ead');

ALTER TABLE `db_pir_grc`.`grc_formulario_ferramenta_ead` ADD COLUMN `link` VARCHAR(255) AFTER `idt_area`;
ALTER TABLE `db_pir_grc`.`grc_formulario_ferramenta_ead` ADD COLUMN `solucao` VARCHAR(45) AFTER `link`;

-- 

CREATE TABLE `db_pir_grc`.`grc_nan_devolutiva_link` (
  `idt` INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  `codigo` VARCHAR(45) NOT NULL,
  `descricao` VARCHAR(255) NOT NULL,
  `link` VARCHAR(255) NOT NULL,
  `ativo` VARCHAR(1) NOT NULL DEFAULT 'S',
  `detalhe` TEXT,
  PRIMARY KEY (`idt`),
  INDEX `iu_grc_nan_devolutiva_link`(`codigo`)
)
ENGINE = InnoDB;

insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_nan_devolutiva_link','NAN - Devolutiva LINKs','05.70.25','S','S','listar','listar');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_nan_devolutiva_link') as id_funcao
from plu_direito where cod_direito in ('alt','con','exc','inc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_nan_devolutiva_link');

ALTER TABLE `db_pir_grc`.`grc_avaliacao_resposta` MODIFY COLUMN `idt_resposta` INT(10) UNSIGNED DEFAULT NULL;

ALTER TABLE `db_pir_grc`.`grc_avaliacao` ADD COLUMN `qtd_g` INTEGER UNSIGNED AFTER `data_resposta`,
 ADD COLUMN `qtd_e` INTEGER UNSIGNED AFTER `qtd_g`,
 ADD COLUMN `qtd_r` INTEGER UNSIGNED AFTER `qtd_e`;
 
 ALTER TABLE `db_pir_grc`.`grc_avaliacao` ADD COLUMN `idt_situacao` INTEGER UNSIGNED NOT NULL AFTER `qtd_r`;

CREATE TABLE `grc_avaliacao_situacao` (
  `idt` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `codigo` varchar(45) NOT NULL,
  `descricao` varchar(120) NOT NULL,
  `ativo` varchar(1) NOT NULL,
  `detalhe` text,
  PRIMARY KEY (`idt`),
  UNIQUE KEY `iu_grc_avaliacao_situacao` (`codigo`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_avaliacao_situacao','Avaliação - Situação','01.99.27','S','S','listar','listar');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_avaliacao_situacao') as id_funcao
from plu_direito where cod_direito in ('alt','con','exc','inc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_avaliacao_situacao');

ALTER TABLE `db_pir_grc`.`grc_avaliacao` ADD CONSTRAINT `FK_grc_avaliacao_7` FOREIGN KEY `FK_grc_avaliacao_7` (`idt_situacao`)
    REFERENCES `grc_avaliacao_situacao` (`idt`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE;
ALTER TABLE `db_pir_grc`.`grc_avaliacao` MODIFY COLUMN `ativo` VARCHAR(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT 'S';

ALTER TABLE `db_pir_grc`.`grc_avaliacao` MODIFY COLUMN `descricao` VARCHAR(120) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL;




insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_nan_devolutiva_rel','Mostra Devolutiva','01.99.29','N','N','cadastro','cadastro');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_nan_devolutiva_rel') as id_funcao
from plu_direito where cod_direito in ('alt','con','exc','inc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_nan_devolutiva_rel');



ALTER TABLE `db_pir_grc`.`grc_formulario_resposta`
 DROP FOREIGN KEY `FK_grc_formulario_resposta_1`;

ALTER TABLE `db_pir_grc`.`grc_formulario_resposta` ADD CONSTRAINT `FK_grc_formulario_resposta_1` FOREIGN KEY `FK_grc_formulario_resposta_1` (`idt_pergunta`)
    REFERENCES `grc_formulario_pergunta` (`idt`)
    ON DELETE CASCADE
    ON UPDATE CASCADE;


ALTER TABLE `db_pir_grc`.`grc_avaliacao_resposta`
 DROP FOREIGN KEY `fk_grc_avaliacao_resposta_1`;

ALTER TABLE `db_pir_grc`.`grc_avaliacao_resposta`
 DROP FOREIGN KEY `fk_grc_avaliacao_resposta_4`;

ALTER TABLE `db_pir_grc`.`grc_avaliacao_resposta` ADD CONSTRAINT `fk_grc_avaliacao_resposta_1` FOREIGN KEY `fk_grc_avaliacao_resposta_1` (`idt_formulario`)
    REFERENCES `grc_formulario` (`idt`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT,
 ADD CONSTRAINT `fk_grc_avaliacao_resposta_4` FOREIGN KEY `fk_grc_avaliacao_resposta_4` (`idt_resposta`)
    REFERENCES `grc_formulario_resposta` (`idt`)
    ON DELETE CASCADE
    ON UPDATE CASCADE;

-- SGTEC - 18-04-2016

ALTER TABLE `db_pir_grc`.`grc_produto` ADD COLUMN `composto` char(1) DEFAULT 'N' AFTER `titulo_comercial`;

-- 19-04-2016

ALTER TABLE `db_pir_gec`.`gec_area_conhecimento` ADD COLUMN `idt_sgtec_tipo_servico` INTEGER UNSIGNED AFTER `descricao_n3`;
ALTER TABLE `db_pir_gec`.`gec_organizacao_porte` ADD COLUMN `contrapartida_sgtec` NUMERIC(15,2) AFTER `desc_vl_cmb`;

ALTER TABLE `db_pir_grc`.`grc_produto` ADD COLUMN `idt_sgtec_tipo_servico` INTEGER UNSIGNED AFTER `composto`;

ALTER TABLE `db_pir_grc`.`grc_produto` ADD CONSTRAINT `FK_grc_produto_15` FOREIGN KEY `FK_grc_produto_15` (`idt_sgtec_tipo_servico`)
    REFERENCES `grc_sgtec_tipo_servico` (`idt`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE;


CREATE TABLE `db_pir_gec`.`gec_area_x_servico` (
  `idt` INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  `idt_tipo_servico` VARCHAR(45) NOT NULL,
  UNIQUE INDEX `iu_gec_area_x_servico`(`idt`, `idt_tipo_servico`)
)
ENGINE = InnoDB;


ALTER TABLE `db_pir_gec`.`gec_area_x_servico` ADD CONSTRAINT `FK_gec_area_x_servico_1` FOREIGN KEY `FK_gec_area_x_servico_1` (`idt`)
    REFERENCES `gec_area_conhecimento` (`idt`)
    ON DELETE CASCADE
    ON UPDATE CASCADE;

ALTER TABLE `db_pir_grc`.`grc_nan_estrutura` ADD COLUMN `idt_ponto_atendimento` INTEGER UNSIGNED NOT NULL AFTER `detalhe`,
 DROP INDEX `iu_grc_nan_estrutura`,
 ADD UNIQUE INDEX `iu_grc_nan_estrutura` USING BTREE(`idt_ponto_atendimento`, `codigo`);
ALTER TABLE `db_pir_grc`.`grc_nan_estrutura` ADD COLUMN `idt_nan_tipo` INTEGER UNSIGNED NOT NULL AFTER `idt_ponto_atendimento`;

ALTER TABLE `db_pir_grc`.`grc_nan_estrutura` ADD CONSTRAINT `FK_grc_nan_estrutura_1` FOREIGN KEY `FK_grc_nan_estrutura_1` (`idt_nan_tipo`)
    REFERENCES `grc_nan_estrutura_tipo` (`idt`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE;
--
ALTER TABLE `db_pir_grc`.`grc_nan_estrutura` MODIFY COLUMN `codigo` VARCHAR(45) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
 ADD COLUMN `idt_usuario` INTEGER UNSIGNED NOT NULL AFTER `idt_nan_tipo`,
 DROP INDEX `iu_grc_nan_estrutura`,
 ADD UNIQUE INDEX `iu_grc_nan_estrutura` USING BTREE(`idt_ponto_atendimento`, `idt_nan_tipo`, `idt_usuario`);
--
ALTER TABLE `db_pir_grc`.`grc_nan_estrutura` MODIFY COLUMN `idt_usuario` INT(10) NOT NULL,
 ADD CONSTRAINT `FK_grc_nan_estrutura_2` FOREIGN KEY `FK_grc_nan_estrutura_2` (`idt_usuario`)
    REFERENCES `plu_usuario` (`id_usuario`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE;
ALTER TABLE `db_pir_grc`.`grc_nan_estrutura` MODIFY COLUMN `descricao` VARCHAR(120) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL;
--
ALTER TABLE `db_pir_grc`.`grc_nan_estrutura` ADD COLUMN `idt_tutor` INTEGER UNSIGNED AFTER `idt_usuario`
, AUTO_INCREMENT = 2;

-- 26-04-2016


ALTER TABLE `db_pir_gec`.`gec_area_x_servico` MODIFY COLUMN `idt_tipo_servico` INTEGER UNSIGNED NOT NULL;


CREATE TABLE `db_pir_grc`.`grc_nan_ferramenta_x_produto` (
  `idt` INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  `idt_produto` integer NOT NULL,
  UNIQUE INDEX `grc_ferramenta_x_produto`(`idt`, `idt_produto`)
)
ENGINE = InnoDB;

CREATE TABLE `db_pir_grc`.`grc_nan_area_x_foco_tematico` (
  `idt` INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  `idt_tema` integer NOT NULL,
  UNIQUE INDEX `grc_nan_area_x_foco_tematico`(`idt`, `idt_tema`)
)
ENGINE = InnoDB;

ALTER TABLE `db_pir_grc`.`grc_nan_area_x_foco_tematico` ADD CONSTRAINT `FK_grc_nan_area_x_foco_tematico_1` FOREIGN KEY `FK_grc_nan_area_x_foco_tematico_1` (`idt`)
    REFERENCES `grc_formulario_area` (`idt`)
    ON DELETE CASCADE
    ON UPDATE CASCADE;
ALTER TABLE `db_pir_grc`.`grc_nan_area_x_foco_tematico` MODIFY COLUMN `idt_tema` INT(11) UNSIGNED NOT NULL,
 ADD CONSTRAINT `FK_grc_nan_area_x_foco_tematico_2` FOREIGN KEY `FK_grc_nan_area_x_foco_tematico_2` (`idt_tema`)
    REFERENCES `grc_foco_tematico` (`idt`)
    ON DELETE CASCADE
    ON UPDATE CASCADE;
ALTER TABLE `db_pir_grc`.`grc_nan_ferramenta_x_produto` ADD CONSTRAINT `FK_grc_nan_ferramenta_x_produto_1` FOREIGN KEY `FK_grc_nan_ferramenta_x_produto_1` (`idt`)
    REFERENCES `grc_formulario_ferramenta_gestao` (`idt`)
    ON DELETE CASCADE
    ON UPDATE CASCADE;
	
	ALTER TABLE `db_pir_grc`.`grc_nan_ferramenta_x_produto` MODIFY COLUMN `idt_produto` INT(11) UNSIGNED NOT NULL,
 ADD CONSTRAINT `FK_grc_nan_ferramenta_x_produto_2` FOREIGN KEY `FK_grc_nan_ferramenta_x_produto_2` (`idt_produto`)
    REFERENCES `grc_produto` (`idt`)
    ON DELETE CASCADE
    ON UPDATE CASCADE;

-- 29-04-2016


ALTER TABLE `db_pir_grc`.`grc_formulario_area` ADD COLUMN `grupo` VARCHAR(45) NOT NULL DEFAULT 'NAN' AFTER `detalhe`;
ALTER TABLE `db_pir_grc`.`grc_formulario_area` DROP INDEX `iu_grc_formulario_area`,
 ADD UNIQUE INDEX `iu_grc_formulario_area` USING BTREE(`grupo`, `codigo`);

ALTER TABLE `db_pir_grc`.`grc_formulario` ADD COLUMN `grupo` VARCHAR(45) NOT NULL AFTER `controle_pontos`;

ALTER TABLE `db_pir_grc`.`grc_formulario` DROP INDEX `iu_grc_formulario`,
 ADD UNIQUE INDEX `iu_grc_formulario` USING BTREE(`grupo`, `codigo`);

ALTER TABLE `db_pir_grc`.`grc_formulario` MODIFY COLUMN `grupo` VARCHAR(45) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'GER';
ALTER TABLE `db_pir_grc`.`grc_formulario` MODIFY COLUMN `grupo` VARCHAR(45) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'GER';
ALTER TABLE `db_pir_grc`.`grc_formulario_area` MODIFY COLUMN `grupo` VARCHAR(45) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'GER';


ALTER TABLE `db_pir_grc`.`grc_formulario_pergunta` MODIFY COLUMN `idt_dimensao` INT(10) UNSIGNED DEFAULT NULL;

ALTER TABLE `db_pir_grc`.`grc_formulario` ADD COLUMN `idt_instrumento` INTEGER UNSIGNED AFTER `grupo`;

ALTER TABLE `db_pir_grc`.`grc_formulario` ADD CONSTRAINT `FK_grc_formulario_5` FOREIGN KEY `FK_grc_formulario_5` (`idt_instrumento`)
    REFERENCES `grc_atendimento_instrumento` (`idt`)
    ON DELETE RESTRICT
    ON UPDATE SET NULL;


ALTER TABLE `db_pir_grc`.`grc_avaliacao_resposta` ADD COLUMN `grupo` VARCHAR(45) AFTER `resposta_txt`,
 ADD INDEX `Index_7`(`grupo`);
ALTER TABLE `db_pir_grc`.`grc_avaliacao_resposta` MODIFY COLUMN `grupo` VARCHAR(45) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT 'GER';


ALTER TABLE `db_pir_grc`.`grc_avaliacao` ADD COLUMN `grupo` VARCHAR(45) NOT NULL DEFAULT 'GER' AFTER `idt_atendimento`,
 DROP INDEX `iu_grc_avaliacao`,
 ADD UNIQUE INDEX `iu_grc_avaliacao` USING BTREE(`grupo`, `codigo`);


ALTER TABLE `db_pir_grc`.`grc_formulario_secao` MODIFY COLUMN `idt_formulario_area` INT(10) UNSIGNED DEFAULT NULL;


ALTER TABLE `db_pir_grc`.`grc_formulario_pergunta` MODIFY COLUMN `idt_classe` INT(10) UNSIGNED DEFAULT NULL;


ALTER TABLE `db_pir_grc`.`grc_formulario_resposta` MODIFY COLUMN `idt_classe` INT(10) UNSIGNED DEFAULT NULL;

-- 05-05-2016


insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_nan_parametros_projeto_m','NAN - Funcionalidades Administrativas','05.70.50','S','S','listar','listar');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_nan_parametros_projeto_m') as id_funcao
from plu_direito where cod_direito in ('alt','con','exc','inc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_nan_parametros_projeto_m');



insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_nan_parametros_projeto','NAN - Funcionalidades Administrativas','05.70.50.00','S','S','inc','inc');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_nan_parametros_projeto') as id_funcao
from plu_direito where cod_direito in ('alt','con','exc','inc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_nan_parametros_projeto');

insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('nan_parametros_projetos','Parâmetros do Projeto','05.70.50.03','S','S','cadastro','cadastro');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'nan_parametros_projetos') as id_funcao
from plu_direito where cod_direito in ('alt','con','exc','inc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_nan_parametros_projetos');


insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_nan_empresas_executoras','Empresas Executoras','05.70.50.06','S','S','listar','listar');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_nan_empresas_executoras') as id_funcao
from plu_direito where cod_direito in ('alt','con','exc','inc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_nan_empresas_executoras');





insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_nan_gestao_contrato','Gestão de Contratos','05.70.50.09','S','S','listar','listar');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_nan_gestao_contrato') as id_funcao
from plu_direito where cod_direito in ('alt','con','exc','inc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_nan_gestao_contrato');


insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_nan_projeto_acao','Projetos e Ação','05.70.50.12','S','S','listar','listar');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_nan_projeto_acao') as id_funcao
from plu_direito where cod_direito in ('alt','con','exc','inc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_nan_projeto_acao');



insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_nan_transferir_atendimento','Transferir Atendimento','05.70.50.18','S','S','listar','listar');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_nan_transferir_atendimento') as id_funcao
from plu_direito where cod_direito in ('alt','con','exc','inc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_nan_transferir_atendimento');

ALTER TABLE `db_pir_grc`.`grc_projeto` ADD COLUMN `ativo_nan` VARCHAR(1) AFTER `idt_responsavel`;
ALTER TABLE `db_pir_grc`.`grc_projeto_acao` ADD COLUMN `ativo_nan` VARCHAR(1) AFTER `idt_unidade`;


ALTER TABLE `db_pir_grc`.`grc_projeto_acao` ADD COLUMN `nan` VARCHAR(1) AFTER `ativo_nan`;
ALTER TABLE `db_pir_grc`.`grc_projeto` ADD COLUMN `nan` VARCHAR(1) AFTER `ativo_nan`;

ALTER TABLE `db_pir_grc`.`grc_projeto_acao` ADD COLUMN `numero_max_visita` INTEGER UNSIGNED AFTER `nan`,
 ADD COLUMN `numero_adicinal_visita` INTEger UNSIGNED AFTER `numero_max_visita`,
 ADD COLUMN `data_validade` DATE AFTER `numero_adicinal_visita`,
 ADD COLUMN `prazo_max_1_2` INTEGER UNSIGNED AFTER `data_validade`,
 ADD COLUMN `prazo_max_2_3` INTEGER UNSIGNED AFTER `prazo_max_1_2`,
 ADD COLUMN `prazo_tutor` INTEGER UNSIGNED AFTER `prazo_max_2_3`;


ALTER TABLE `db_pir_grc`.`grc_projeto_acao` ADD COLUMN `adicional` VARCHAR(1) AFTER `prazo_tutor`;

-- 06-05-2016

CREATE TABLE `db_pir_grc`.`grc_nan_parametros_projetos` (
  `idt` INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  `codigo` VARCHAR(45) NOT NULL,
  `numero_max_visita` INTEGER UNSIGNED,
  `numero_adicinal_visita` INTEGER UNSIGNED,
  `prazo_max_1_2` INTEGER UNSIGNED,
  `prazo_max_2_3` INTEGER UNSIGNED,
  `prazo_tutor` INTEGER UNSIGNED,
  `data_validade` DATE,
  PRIMARY KEY (`idt`),
  UNIQUE INDEX `iu_grc_nan_parametros_projetos`(`codigo`)
)
ENGINE = InnoDB;

CREATE TABLE `db_pir_grc`.`grc_nan_parametros_projetos_publico_alvo` (
  `idt` INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  `idt_publico_alvo` INTEGER NOT NULL,
  PRIMARY KEY (`idt`)
)
ENGINE = InnoDB;
ALTER TABLE `db_pir_grc`.`grc_nan_parametros_projetos_publico_alvo` DROP PRIMARY KEY,
 ADD PRIMARY KEY  USING BTREE(`idt`, `idt_publico_alvo`);


ALTER TABLE `db_pir_grc`.`grc_nan_parametros_projetos_publico_alvo` MODIFY COLUMN `idt_publico_alvo` INT(10) UNSIGNED NOT NULL,
 ADD CONSTRAINT `FK_grc_nan_parametros_projetos_publico_alvo_1` FOREIGN KEY `FK_grc_nan_parametros_projetos_publico_alvo_1` (`idt_publico_alvo`)
    REFERENCES `grc_publico_alvo` (`idt`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE;
	
	
insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_projeto_acao_nan','Projetos e Ações do NAN','05.70.50.21','N','N','listar','listar');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_projeto_acao_nan') as id_funcao
from plu_direito where cod_direito in ('alt','con','exc','inc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_projeto_acao_nan');





CREATE TABLE `db_pir_grc`.`grc_projeto_acao_nan_publico_alvo` (
  `idt` INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  `idt_publico_alvo` INTEGER NOT NULL,
  PRIMARY KEY (`idt`)
)
ENGINE = InnoDB;
ALTER TABLE `db_pir_grc`.`grc_projeto_acao_nan_publico_alvo` DROP PRIMARY KEY,
 ADD PRIMARY KEY  USING BTREE(`idt`, `idt_publico_alvo`);


ALTER TABLE `db_pir_grc`.`grc_projeto_acao_nan_publico_alvo` MODIFY COLUMN `idt_publico_alvo` INT(10) UNSIGNED NOT NULL,
 ADD CONSTRAINT `FK_grc_projeto_acao_nan_publico_alvo_1` FOREIGN KEY `FK_grc_projeto_acao_nan_publico_alvo_1` (`idt_publico_alvo`)
    REFERENCES `grc_publico_alvo` (`idt`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE;
	
ALTER TABLE `db_pir_grc`.`grc_projeto_acao` ADD COLUMN `nan_idt_unidade_regional` INTEGER UNSIGNED AFTER `adicional`;


ALTER TABLE `db_pir_grc`.`grc_nan_estrutura` ADD COLUMN `idt_acao` INTEGER UNSIGNED AFTER `idt_tutor`;



insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_nan_empresas_executoras_endereco','Empresas Executoras Endereços do NAN','05.70.50.23','N','N','listar','listar');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_nan_empresas_executoras_endereco') as id_funcao
from plu_direito where cod_direito in ('alt','con','exc','inc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_nan_empresas_executoras_endereco');


insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_nan_empresas_executoras_entidade_entidade','EMpresas Executoras Entidade X Entidade do NAN','05.70.50.26','N','N','listar','listar');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_nan_empresas_executoras_entidade_entidade') as id_funcao
from plu_direito where cod_direito in ('alt','con','exc','inc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_nan_empresas_executoras_entidade_entidade');



insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_nan_relatorios','Relatórios NAN','05.70.60','S','S','listar','listar');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_nan_relatorios') as id_funcao
from plu_direito where cod_direito in ('alt','con','exc','inc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_nan_relatorios');


insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('conteudo_nan_credenciado.php','Lista Empresas Executoras','05.70.60.03','S','S','janela','janela');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'conteudo_nan_credenciado.php') as id_funcao
from plu_direito where cod_direito in ('alt','con','exc','inc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('conteudo_nan_credenciado.php');


insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('conteudo_pesquisa_g.php','Pesquisa NAN','05.70.60.05','S','S','janela','janela');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'conteudo_pesquisa_g.php') as id_funcao
from plu_direito where cod_direito in ('alt','con','exc','inc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('conteudo_pesquisa_g.php');


ALTER TABLE `db_pir_grc`.`plu_funcao` MODIFY COLUMN `des_prefixo` VARCHAR(120) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL COMMENT 'Indicador de prefixo - como serÃ¡ chamado para execuÃ§Ã£o.';


insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_nan_visita','Pesquisa NAN Visita','05.70.60.07','N','N','listar_rel','listar_rel');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_nan_visita') as id_funcao
from plu_direito where cod_direito in ('alt','con','exc','inc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_nan_visita');

insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('conteudo_pesquisa_gs.php','Pesquisa NAN','05.70.60.08','S','S','janela','janela');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'conteudo_pesquisa_gs.php') as id_funcao
from plu_direito where cod_direito in ('alt','con','exc','inc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('conteudo_pesquisa_gs.php');



insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_nan_visita_sintetico','Pesquisa NAN Visita - Sintético','05.70.60.11','N','N','listar_rel','listar_rel');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_nan_visita_sintetico') as id_funcao
from plu_direito where cod_direito in ('alt','con','exc','inc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_nan_visita_sintetico');


CREATE TABLE `db_pir_grc`.`plu_parametros_lista` (
  `idt` INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  `codigo` VARCHAR(45) NOT NULL,
  `descricao` VARCHAR(120) NOT NULL,
  `idt_proprietario` INTEGER NOT NULL,
  `numero` INTEGER UNSIGNED NOT NULL,
  PRIMARY KEY (`idt`),
  UNIQUE INDEX `iu_plu_parametros_lista`(`codigo`, `numero`)
)
ENGINE = InnoDB;



insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('plu_parametros_genericos','Parâmetros da Lista','90.80.70','S','S','listar','listar');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'plu_parametros_genericos') as id_funcao
from plu_direito where cod_direito in ('alt','con','exc','inc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('plu_parametros_genericos');



insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('plu_parametros_lista','Parâmetros da Lista','90.80.70.03','S','S','listar','listar');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'plu_parametros_lista') as id_funcao
from plu_direito where cod_direito in ('alt','con','exc','inc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('plu_parametros_lista');

ALTER TABLE `db_pir_grc`.`plu_parametros_lista` ADD COLUMN `detalhe` TEXT AFTER `numero`;
ALTER TABLE `db_pir_grc`.`plu_parametros_lista` ADD COLUMN `ativo` VARCHAR(1) NOT NULL DEFAULT 'S' AFTER `detalhe`;

CREATE TABLE `db_pir_grc`.`grc_nan_motivo_desistencia` (
  `idt` INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  `codigo` VARCHAR(45) NOT NULL,
  `descricao` VARCHAR(120) NOT NULL,
  `detalhe` TEXT,
  `ativo` VARCHAR(45) NOT NULL DEFAULT 'S',
  PRIMARY KEY (`idt`),
  UNIQUE INDEX `iu_grc_nan_motivo_desistencia`(`codigo`)
)
ENGINE = InnoDB;


insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_nan_motivo_desistencia','NAN - Motivo da Desistência','05.70.50.30','S','S','listar','listar');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_nan_motivo_desistencia') as id_funcao
from plu_direito where cod_direito in ('alt','con','exc','inc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_nan_motivo_desistencia');

-- 12-05-2016

ALTER TABLE `db_pir_grc`.`grc_nan_estrutura` ADD COLUMN `idt_contrato` INTEGER UNSIGNED AFTER `idt_acao`;


ALTER TABLE `db_pir_grc`.`grc_nan_estrutura`
 DROP FOREIGN KEY `FK_grc_nan_estrutura_3`;

ALTER TABLE `db_pir_grc`.`grc_nan_estrutura` MODIFY COLUMN `idt_tutor` INT(10) DEFAULT NULL,
 ADD CONSTRAINT `FK_grc_nan_estrutura_3` FOREIGN KEY `FK_grc_nan_estrutura_3` (`idt_tutor`)
    REFERENCES `plu_usuario` (`id_usuario`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT;

ALTER TABLE `db_pir_grc`.`grc_nan_estrutura` MODIFY COLUMN `idt_nan_tipo` INT(10) UNSIGNED NOT NULL DEFAULT 6;

ALTER TABLE `db_pir_grc`.`grc_nan_estrutura` ADD COLUMN `idt_empresa_executora` INTEGER UNSIGNED AFTER `idt_contrato`;


insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_nan_estrutura_arvore','NAN - Estrutura Operacional (Arvore)','05.70.16','S','S','listar','listar');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_nan_estrutura_arvore') as id_funcao
from plu_direito where cod_direito in ('alt','con','exc','inc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_nan_estrutura_arvore');

-- 21-05-2016

ALTER TABLE `db_pir_grc`.`grc_nan_estrutura` DROP INDEX `iu_grc_nan_estrutura`,
 ADD UNIQUE INDEX `iu_grc_nan_estrutura` USING BTREE(`idt_ponto_atendimento`, `idt_nan_tipo`, `idt_usuario`, `idt_acao`);


ALTER TABLE `db_pir_grc`.`grc_formulario_pergunta`
 DROP FOREIGN KEY `FK_grc_formulario_pergunta_2`;

ALTER TABLE `db_pir_grc`.`grc_formulario_pergunta` ADD CONSTRAINT `FK_grc_formulario_pergunta_2` FOREIGN KEY `FK_grc_formulario_pergunta_2` (`idt_secao`)
    REFERENCES `grc_formulario_secao` (`idt`)
    ON DELETE CASCADE
    ON UPDATE CASCADE;

-- 24-05-2016

CREATE TABLE `db_pir_grc`.`grc_avaliacao_secao` (
  `idt` INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  `idt_avaliacao` INTEGER UNSIGNED NOT NULL,
  `idt_formulario` INTEGER UNSIGNED NOT NULL,
  `idt_secao` INTEGER UNSIGNED NOT NULL,
  `evidencia` TEXT,
  `obrigatorio` CHAR(1) NOT NULL DEFAULT 'S',
  PRIMARY KEY (`idt`),
  INDEX `iu_grc_avaliacao_secao`(`idt_avaliacao`, `idt_formulario`, `idt_secao`)
)
ENGINE = InnoDB;


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
  CONSTRAINT `FK_grc_avaliacao_secao_anexo_1` FOREIGN KEY (`idt_avaliacao_secao`) REFERENCES `grc_avaliacao_secao` (`idt`) ON DELETE CASCADE,
  CONSTRAINT `FK_grc_avaliacao_secao_anexo_2` FOREIGN KEY (`idt_responsavel`) REFERENCES `plu_usuario` (`id_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `db_pir_grc`.`grc_formulario_secao` ADD COLUMN `edidencia` CHAR(1) NOT NULL DEFAULT 'N' AFTER `idt_formulario_relevancia`;
ALTER TABLE `db_pir_grc`.`grc_avaliacao_secao` MODIFY COLUMN `obrigatorio` CHAR(1) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'N';
ALTER TABLE `db_pir_grc`.`grc_formulario_secao` CHANGE COLUMN `edidencia` `evidencia` CHAR(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'N';

-- 26-05-2016

ALTER TABLE `db_pir_gec`.`gec_contratar_credenciado` ADD COLUMN `valor_contrato` NUMERIC(15,2) AFTER `nan_meta_atendimentos_aditivo_v2`;
ALTER TABLE `db_pir_grc`.`grc_nan_parametros_projetos` ADD COLUMN `valor_visita1` NUMERIC(15,2) AFTER `data_validade`,
 ADD COLUMN `valor_visita2` NUMERIC(15,2) AFTER `valor_visita1`;


ALTER TABLE `db_pir_gec`.`gec_contratar_credenciado` ADD COLUMN `valor_contratual` DECIMAL(15,2) AFTER `valor_contrato`;

CREATE TABLE `db_pir_grc`.`grc_nan_ordem_pagamento` (
  `idt` INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  `protocolo` VARCHAR(45) NOT NULL,
  `descricao` VARCHAR(120) NOT NULL,
  `objeto` TEXT,
  `idt_cadastrante` INTEGER NOT NULL,
  `data_cadastrante` DATETIME NOT NULL,
  `idt_contrato` INTEGER UNSIGNED NOT NULL,
  `data_inicio` DATE NOT NULL,
  `data_fim` DATE NOT NULL,
  `valor_total` NUMERIC(15,2),
  `qtd_total_visitas` INTEGER UNSIGNED,
  `qtd_visitas1` INTEGER UNSIGNED,
  `qtd_visitas2` INTEGER UNSIGNED,
  PRIMARY KEY (`idt`),
  UNIQUE INDEX `iu_grc_nan_ordem_pagamento`(`protocolo`),
  CONSTRAINT `FK_grc_nan_ordem_pagamento_1` FOREIGN KEY `FK_grc_nan_ordem_pagamento_1` (`idt_cadastrante`)
    REFERENCES `plu_usuario` (`id_usuario`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE
)
ENGINE = InnoDB;

insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_nan_ordem_pagamento','Ordem de Pagamento','05.70.50.11','S','S','listar','listar');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_nan_ordem_pagamento') as id_funcao
from plu_direito where cod_direito in ('alt','con','exc','inc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_nan_ordem_pagamento');

ALTER TABLE `db_pir_grc`.`grc_nan_ordem_pagamento` ADD COLUMN `situacao` CHaR(2) NOT NULL DEFAULT 'GE' AFTER `qtd_visitas2`;


ALTER TABLE `db_pir_grc`.`grc_atendimento` ADD COLUMN `idt_nan_ordem_pagamento` INTEGER UNSIGNED AFTER `idt_nan_empresa`;

ALTER TABLE `db_pir_grc`.`grc_atendimento` ADD CONSTRAINT `FK_grc_atendimento_26` FOREIGN KEY `FK_grc_atendimento_26` (`idt_nan_ordem_pagamento`)
    REFERENCES `grc_nan_ordem_pagamento` (`idt`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT;
ALTER TABLE `db_pir_grc`.`grc_nan_ordem_pagamento` ADD COLUMN `acao_nan` CHAR(2) AFTER `situacao`;

insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_nan_estrutura_arvore_c','NAN - Estrutura Operacional Completa','05.70.18','S','S','listar','listar');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_nan_estrutura_arvore_c') as id_funcao
from plu_direito where cod_direito in ('alt','con','exc','inc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_nan_estrutura_arvore_c');


ALTER TABLE `db_pir_grc`.`grc_nan_ordem_pagamento` MODIFY COLUMN `descricao` VARCHAR(120) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL;

CREATE TABLE `db_pir_grc`.`grc_avaliacao_devolutiva` (
  `idt` INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  `codigo` VARCHAR(45) NOT NULL,
  `descricao` VARCHAR(120) NOT NULL,
  `idt_avaliacao` INTEGER UNSIGNED NOT NULL,
  `versao` INTEGER UNSIGNED,
  `data_versao` DATETIME,
  `idt_cadastrante` INTEGER UNSIGNED,
  `data_cadastro` DATETIME,
  `status` CHar(2) NOT NULL DEFAULT 'CA',
  PRIMARY KEY (`idt`),
  INDEX `iu_grc_avaliacao_devolutiva`(`idt_avaliacao`, `codigo`)
)
ENGINE = InnoDB;
ALTER TABLE `db_pir_grc`.`grc_avaliacao_devolutiva` ADD CONSTRAINT `FK_grc_avaliacao_devolutiva_1` FOREIGN KEY `FK_grc_avaliacao_devolutiva_1` (`idt_avaliacao`)
    REFERENCES `grc_avaliacao` (`idt`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE;
ALTER TABLE `db_pir_grc`.`grc_avaliacao_devolutiva` MODIFY COLUMN `idt_cadastrante` INT(10) DEFAULT NULL,
 ADD CONSTRAINT `FK_grc_avaliacao_devolutiva_2` FOREIGN KEY `FK_grc_avaliacao_devolutiva_2` (`idt_cadastrante`)
    REFERENCES `plu_usuario` (`id_usuario`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE;

insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_avaliacao_devolutiva','NAN - Devolutivas da Avaliação','30.06','S','S','listar','listar');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_avaliacao_devolutiva') as id_funcao
from plu_direito where cod_direito in ('alt','con','exc','inc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_avaliacao_devolutiva');

ALTER TABLE `db_pir_grc`.`grc_avaliacao_devolutiva` CHANGE COLUMN `data_cadastro` `data_cadastrante` DATETIME DEFAULT NULL;

ALTER TABLE `db_pir_grc`.`grc_avaliacao_devolutiva` ADD COLUMN `grupo` VARCHAR(45) NOT NULL DEFAULT 'NAN' AFTER `status`;
ALTER TABLE `db_pir_grc`.`grc_avaliacao_devolutiva` MODIFY COLUMN `descricao` VARCHAR(120) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
 ADD COLUMN `observacao` TEXT AFTER `grupo`;
ALTER TABLE `db_pir_grc`.`grc_avaliacao_devolutiva` ADD COLUMN `atual` CHAR(1) NOT NULL DEFAULT 'S' AFTER `observacao`;



insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_nan_ferramenta_x_produto','NAN - Devolutivas da Avaliação','30.99.23.03','N','N','listar','listar');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_nan_ferramenta_x_produto') as id_funcao
from plu_direito where cod_direito in ('alt','con','exc','inc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_nan_ferramenta_x_produto');


ALTER TABLE `db_pir_grc`.`grc_nan_ferramenta_x_produto` ADD COLUMN `idt_ferramenta` INTEGER UNSIGNED NOT NULL AFTER `idt_produto`;
ALTER TABLE `db_pir_grc`.`grc_nan_ferramenta_x_produto`
 DROP FOREIGN KEY `FK_grc_nan_ferramenta_x_produto_1`;

ALTER TABLE `db_pir_grc`.`grc_nan_ferramenta_x_produto` ADD CONSTRAINT `FK_grc_nan_ferramenta_x_produto_1` FOREIGN KEY `FK_grc_nan_ferramenta_x_produto_1` (`idt_ferramenta`)
    REFERENCES `grc_formulario_ferramenta_gestao` (`idt`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT;
ALTER TABLE `db_pir_grc`.`grc_nan_ferramenta_x_produto` ADD PRIMARY KEY (`idt`),
 DROP INDEX `grc_ferramenta_x_produto`,
 ADD INDEX `grc_ferramenta_x_produto` USING BTREE(`idt_ferramenta`, `idt_produto`);
ALTER TABLE `db_pir_grc`.`grc_nan_ferramenta_x_produto` DROP INDEX `grc_ferramenta_x_produto`,
 ADD UNIQUE INDEX `grc_ferramenta_x_produto` USING BTREE(`idt_ferramenta`, `idt_produto`);


CREATE TABLE `db_pir_grc`.`grc_avaliacao_devolutiva_ferramenta` (
  `idt` INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  `idt_avaliacao_devolutiva` INTEGER UNSIGNED NOT NULL,
  `idt_ferramenta` INTEGER UNSIGNED NOT NULL,
  `ativo` CHAR(1) NOT NULL DEFAULT 'S',
  `status` CHAR(2) NOT NULL DEFAULT 'DE',
  PRIMARY KEY (`idt`),
  UNIQUE INDEX `iu_grc_avaliacao_devolutiva_ferramenta`(`idt_avaliacao_devolutiva`, `idt_ferramenta`)
)
ENGINE = InnoDB;

ALTER TABLE `db_pir_grc`.`grc_avaliacao_devolutiva_ferramenta` ADD CONSTRAINT `FK_grc_avaliacao_devolutiva_ferramenta_1` FOREIGN KEY `FK_grc_avaliacao_devolutiva_ferramenta_1` (`idt_avaliacao_devolutiva`)
    REFERENCES `grc_avaliacao_devolutiva` (`idt`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE;
ALTER TABLE `db_pir_grc`.`grc_avaliacao_devolutiva_ferramenta` ADD CONSTRAINT `FK_grc_avaliacao_devolutiva_ferramenta_2` FOREIGN KEY `FK_grc_avaliacao_devolutiva_ferramenta_2` (`idt_ferramenta`)
    REFERENCES `grc_formulario_ferramenta_gestao` (`idt`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE;
CREATE TABLE `db_pir_grc`.`grc_avaliacao_devolutiva_produto` (
  `idt` INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  `idt_avaliacao_devolutiva` INTEGER UNSIGNED NOT NULL,
  `idt_produto` INTEGER UNSIGNED NOT NULL,
  `ativo` CHAR(1) NOT NULL DEFAULT 'S',
  `status` CHAR(2) NOT NULL DEFAULT 'DE',
  PRIMARY KEY (`idt`),
  UNIQUE INDEX `iu_grc_avaliacao_devolutiva_produto`(`idt_avaliacao_devolutiva`, `idt_produto`)
)
ENGINE = InnoDB;
ALTER TABLE `db_pir_grc`.`grc_avaliacao_devolutiva_produto` ADD CONSTRAINT `FK_grc_avaliacao_devolutiva_produto_1` FOREIGN KEY `FK_grc_avaliacao_devolutiva_produto_1` (`idt_avaliacao_devolutiva`)
    REFERENCES `grc_avaliacao_devolutiva` (`idt`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE,
 ADD CONSTRAINT `FK_grc_avaliacao_devolutiva_produto_2` FOREIGN KEY `FK_grc_avaliacao_devolutiva_produto_2` (`idt_produto`)
    REFERENCES `grc_produto` (`idt`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE;

ALTER TABLE `db_pir_grc`.`grc_avaliacao_devolutiva_ferramenta` ADD COLUMN `ordem` INTEGER UNSIGNED NOT NULL AFTER `status`;

insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_nan_monitoramento','NAN - Monitoramento','05.80','N','N','listar','listar');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_nan_monitoramento') as id_funcao
from plu_direito where cod_direito in ('alt','con','exc','inc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_nan_monitoramento');


insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_nan_monitora_aoe','NAN - Monitora AOE','05.80.03','N','N','listar','listar');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_nan_monitora_aoe') as id_funcao
from plu_direito where cod_direito in ('alt','con','exc','inc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_nan_monitora_aoe');


insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('conteudo_monitora_usuario.php','NAN - Monitora Usuários','05.80.50','S','S','janela','janela');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'conteudo_monitora_usuario.php') as id_funcao
from plu_direito where cod_direito in ('alt','con','exc','inc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('conteudo_monitora_usuario.php');

-- SGTEC
CREATE TABLE `db_pir_grc`.`grc_produto_entrega` (
  `idt` INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  `idt_produto` INTEGER UNSIGNED NOT NULL,
  `codigo` VARCHAR(45) NOT NULL,
  `decricao` VARCHAR(120) NOT NULL,
  `detalhe` TEXT,
  `percentual` NUMERIC(15,4),
  PRIMARY KEY (`idt`),
  UNIQUE INDEX `iu_grc_produto_entrega`(`codigo`),
  CONSTRAINT `FK_grc_produto_entrega_1` FOREIGN KEY `FK_grc_produto_entrega_1` (`idt_produto`)
    REFERENCES `grc_produto` (`idt`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE
)
ENGINE = InnoDB;

insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_produto_entrega','Entrega de Tarefas de produto','01.01.27','S','S','listar','listar');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_produto_entrega') as id_funcao
from plu_direito where cod_direito in ('alt','con','exc','inc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_produto_entrega');

ALTER TABLE `db_pir_grc`.`grc_produto_entrega` ADD COLUMN `ordem` INTEGER UNSIGNED NOT NULL DEFAULT 0 AFTER `percentual`;

ALTER TABLE `db_pir_grc`.`grc_produto_entrega` CHANGE COLUMN `decricao` `descricao` VARCHAR(120) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;


CREATE TABLE `db_pir_grc`.`grc_projeto_acao_produto` (
  `idt` INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  `idt_projeto_acao` INTEGER UNSIGNED NOT NULL,
  `idt_produto` INTEGER UNSIGNED NOT NULL,
  `ativo` CHAR(1) NOT NULL DEFAULT 'S',
  PRIMARY KEY (`idt`),
  UNIQUE INDEX `iu_grc_projeto_acao_produto`(`idt_projeto_acao`, `idt_produto`),
  CONSTRAINT `FK_grc_projeto_acao_produto_1` FOREIGN KEY `FK_grc_projeto_acao_produto_1` (`idt_produto`)
    REFERENCES `grc_produto` (`idt`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE,
  CONSTRAINT `FK_grc_projeto_acao_produto_2` FOREIGN KEY `FK_grc_projeto_acao_produto_2` (`idt_projeto_acao`)
    REFERENCES `grc_projeto_acao` (`idt`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE
)
ENGINE = InnoDB;


insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_projeto_acao_produto','SGTEC - Projeto Ação X Produto','01.99.60.09','S','S','listar','listar');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_projeto_acao_produto') as id_funcao
from plu_direito where cod_direito in ('alt','con','exc','inc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_projeto_acao_produto');

ALTER TABLE `db_pir_grc`.`grc_projeto_acao_produto` ADD COLUMN `observacao` TEXT AFTER `ativo`;

update plu_funcao set cod_classificacao = '05.70.60.09' where cod_funcao = 'grc_nan_visita_sintetico';

insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('conteudo_matriz_atendimento_nan.php','Matriz de Atendimento - NAN','05.70.60.11','S','S','janela','janela');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'conteudo_matriz_atendimento_nan.php') as id_funcao
from plu_direito where cod_direito in ('alt','con','exc','inc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('conteudo_matriz_atendimento_nan.php');



insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('conteudo_historico_cliente.php','Cliente - Historico','05.70.60.13','S','S','janela','janela');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'conteudo_historico_cliente.php') as id_funcao
from plu_direito where cod_direito in ('alt','con','exc','inc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('conteudo_historico_cliente.php');

-- sala

insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('mapa','Visualizações em Mapa','05.85','S','S','listar','listar');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'mapa') as id_funcao
from plu_direito where cod_direito in ('alt','con','exc','inc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('mapa');


insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('conteudo_mapa.php','Mapa PA','05.85.03','S','S','janela','janela');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'conteudo_mapa.php') as id_funcao
from plu_direito where cod_direito in ('alt','con','exc','inc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('conteudo_mapa.php');

CREATE TABLE `db_pir_grc`.`plu_helpdesk` (
  `idt` INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  `login` VARCHAR(255),
  `datahora` DATETIME,
  `ip` VARCHAR(45),
  `anonimo_nome` VARCHAR(120),
  `anomimo_email` VARCHAR(120),
  `latitude` DECIMAL(15,9),
  `longitude` DECIMAL(15,9),
  `titulo` VARCHAR(120) NOT NULL,
  `descricao` TEXT NOT NULL,
  `macroprocesso` VARCHAR(45),
  PRIMARY KEY (`idt`),
  INDEX `ix_login`(`login`, `datahora`),
  INDEX `ix_datahora`(`datahora`, `login`),
  INDEX `ix_ip`(`ip`),
  INDEX `ix_macroprocesso`(`macroprocesso`)
)
ENGINE = InnoDB;


insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('helpdesk','Registra helpDesk','90.80.80','S','S','listar','listar');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'helpdesk') as id_funcao
from plu_direito where cod_direito in ('alt','con','exc','inc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('helpdesk');



insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('plu_helpdesk','Registra helpDesk','90.80.80.03','S','S','listar','listar');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'plu_helpdesk') as id_funcao
from plu_direito where cod_direito in ('alt','con','exc','inc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('plu_helpdesk');


ALTER TABLE `db_pir_grc`.`plu_helpdesk` ADD COLUMN `protocolo` VARCHAR(45) NOT NULL AFTER `macroprocesso`,
 ADD UNIQUE INDEX `iu_protocolo`(`protocolo`);

ALTER TABLE `db_pir_grc`.`plu_helpdesk` ADD COLUMN `nome` VARCHAR(120) AFTER `protocolo`,
 ADD COLUMN `email` VARCHAR(120) AFTER `nome`;


CREATE TABLE `plu_helpdesk_anexo` (
  `idt` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idt_helpdesk` int(10) unsigned NOT NULL,
  `descricao` varchar(120) NOT NULL,
  `observacao` text,
  `idt_responsavel` int(11) NOT NULL,
  `data_responsavel` datetime NOT NULL,
  `arquivo` varchar(120) NOT NULL,
  PRIMARY KEY (`idt`),
  KEY `iu_plu_helpdesk_anexo` (`idt_helpdesk`,`descricao`),
  KEY `FK_plu_helpdesk_anexo_2` (`idt_responsavel`),
  CONSTRAINT `FK_plu_helpdesk_anexo_1` FOREIGN KEY (`idt_helpdesk`) REFERENCES `plu_helpdesk` (`idt`) ON UPDATE CASCADE,
  CONSTRAINT `FK_plu_helpdesk_anexo_2` FOREIGN KEY (`idt_responsavel`) REFERENCES `plu_usuario` (`id_usuario`) ON UPDATE CASCADE
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;


insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('plu_helpdesk_anexo','Registra Anexos helpDesk','90.80.80.03.03','N','N','listar','listar');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'plu_helpdesk_anexo') as id_funcao
from plu_direito where cod_direito in ('alt','con','exc','inc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('plu_helpdesk_anexo');

ALTER TABLE `db_pir_grc`.`plu_helpdesk` ADD COLUMN `navegador` VARCHAR(255) AFTER `email`,
 ADD COLUMN `tipo_dispositivo` VARCHAR(255) AFTER `navegador`;
ALTER TABLE `db_pir_grc`.`plu_helpdesk` ADD COLUMN `modelo` VARCHAR(255) AFTER `tipo_dispositivo`;

ALTER TABLE `db_pir_grc`.`plu_helpdesk` MODIFY COLUMN `navegador` VARCHAR(1000) CHARACTER SET utf8 COLLATE utf8_general_ci;

ALTER TABLE `db_pir_grc`.`plu_helpdesk` ADD COLUMN `status` CHAR(1) NOT NULL DEFAULT 'A' AFTER `modelo`;
ALTER TABLE `db_pir_grc`.`plu_helpdesk` ADD COLUMN `tipo_solicitacao` CHAR(2) NOT NULL DEFAULT 'NA' AFTER `status`;
ALTER TABLE `db_pir_grc`.`plu_helpdesk` ADD COLUMN `data_envio_email_helpdesk` DATETIME AFTER `tipo_solicitacao`;

ALTER TABLE `db_pir_grc`.`plu_helpdesk` ADD COLUMN `mandou_email_helpdesk` VARCHAR(120) AFTER `data_envio_email_helpdesk`;

-- producao
