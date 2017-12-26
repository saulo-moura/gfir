-- 30/04/2015

CREATE TABLE `plu_painel` (
  `idt` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `codigo` varchar(45) NOT NULL,
  `descricao` varchar(100) NOT NULL,
  `img_altura` int(11) NOT NULL,
  `img_largura` int(11) NOT NULL,
  `painel_altura` int(11) NOT NULL,
  `painel_largura` int(11) NOT NULL,
  PRIMARY KEY (`idt`),
  UNIQUE KEY `un_plu_painel_2` (`codigo`),
  UNIQUE KEY `un_plu_painel_3` (`descricao`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `plu_painel_funcao` (
  `idt` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idt_painel` int(10) unsigned NOT NULL,
  `id_funcao` int(11) NOT NULL,
  `pos_top` int(10) unsigned NOT NULL,
  `pos_left` int(10) unsigned NOT NULL,
  PRIMARY KEY (`idt`),
  KEY `fk_plu_painel_funcao_2` (`id_funcao`),
  KEY `fk_plu_painel_funcao_3` (`idt_painel`,`id_funcao`) USING BTREE,
  CONSTRAINT `fk_plu_painel_funcao_1` FOREIGN KEY (`idt_painel`) REFERENCES `plu_painel` (`idt`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_plu_painel_funcao_2` FOREIGN KEY (`id_funcao`) REFERENCES `plu_funcao` (`id_funcao`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo)
values ('plu_painel','Cadastro de Painel','90.80.05.10','S','N','listar');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'plu_painel') as id_funcao
from plu_direito where cod_direito in ('con', 'alt', 'exc', 'inc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('plu_painel');

/*
INSERT INTO `plu_painel` (`codigo`, `descricao`, `img_altura`, `img_largura`, `painel_altura`, `painel_largura`) VALUES ('teste_01', 'Painel de Teste', '80', '80', '330', '599');

INSERT INTO `plu_painel_funcao` (`idt_painel`, `id_funcao`, `pos_top`, `pos_left`) VALUES ('1', '404', '0', '0');
INSERT INTO `plu_painel_funcao` (`idt_painel`, `id_funcao`, `pos_top`, `pos_left`) VALUES ('1', '382', '220', '100');
INSERT INTO `plu_painel_funcao` (`idt_painel`, `id_funcao`, `pos_top`, `pos_left`) VALUES ('1', '383', '220', '0');
INSERT INTO `plu_painel_funcao` (`idt_painel`, `id_funcao`, `pos_top`, `pos_left`) VALUES ('1', '384', '220', '200');
INSERT INTO `plu_painel_funcao` (`idt_painel`, `id_funcao`, `pos_top`, `pos_left`) VALUES ('1', '421', '220', '500');
INSERT INTO `plu_painel_funcao` (`idt_painel`, `id_funcao`, `pos_top`, `pos_left`) VALUES ('1', '424', '0', '0');
INSERT INTO `plu_painel_funcao` (`idt_painel`, `id_funcao`, `pos_top`, `pos_left`) VALUES ('1', '426', '0', '0');
INSERT INTO `plu_painel_funcao` (`idt_painel`, `id_funcao`, `pos_top`, `pos_left`) VALUES ('1', '427', '0', '0');
INSERT INTO `plu_painel_funcao` (`idt_painel`, `id_funcao`, `pos_top`, `pos_left`) VALUES ('1', '428', '0', '0');
INSERT INTO `plu_painel_funcao` (`idt_painel`, `id_funcao`, `pos_top`, `pos_left`) VALUES ('1', '403', '110', '500');
INSERT INTO `plu_painel_funcao` (`idt_painel`, `id_funcao`, `pos_top`, `pos_left`) VALUES ('1', '405', '110', '400');
INSERT INTO `plu_painel_funcao` (`idt_painel`, `id_funcao`, `pos_top`, `pos_left`) VALUES ('1', '410', '110', '300');
INSERT INTO `plu_painel_funcao` (`idt_painel`, `id_funcao`, `pos_top`, `pos_left`) VALUES ('1', '411', '110', '200');
INSERT INTO `plu_painel_funcao` (`idt_painel`, `id_funcao`, `pos_top`, `pos_left`) VALUES ('1', '412', '110', '100');
INSERT INTO `plu_painel_funcao` (`idt_painel`, `id_funcao`, `pos_top`, `pos_left`) VALUES ('1', '413', '110', '0');
INSERT INTO `plu_painel_funcao` (`idt_painel`, `id_funcao`, `pos_top`, `pos_left`) VALUES ('1', '414', '0', '100');
INSERT INTO `plu_painel_funcao` (`idt_painel`, `id_funcao`, `pos_top`, `pos_left`) VALUES ('1', '415', '0', '200');
INSERT INTO `plu_painel_funcao` (`idt_painel`, `id_funcao`, `pos_top`, `pos_left`) VALUES ('1', '416', '0', '300');
INSERT INTO `plu_painel_funcao` (`idt_painel`, `id_funcao`, `pos_top`, `pos_left`) VALUES ('1', '417', '0', '400');
INSERT INTO `plu_painel_funcao` (`idt_painel`, `id_funcao`, `pos_top`, `pos_left`) VALUES ('1', '418', '0', '500');
INSERT INTO `plu_painel_funcao` (`idt_painel`, `id_funcao`, `pos_top`, `pos_left`) VALUES ('1', '419', '220', '400');
INSERT INTO `plu_painel_funcao` (`idt_painel`, `id_funcao`, `pos_top`, `pos_left`) VALUES ('1', '420', '220', '300');
*/