-- esmeraldo

-- 13/09/2016

ALTER TABLE `grc_evento`
ADD COLUMN `sincroniza_loja`  char(1) NOT NULL DEFAULT 'S';

update grc_evento set sincroniza_loja = 'N' where idt_evento_situacao in (19, 20);

-- 14/09/2016

ALTER TABLE `grc_atendimento_pessoa` DROP FOREIGN KEY `FK_grc_atendimento_pessoa_5`;

-- 20/09/2016

ALTER TABLE `grc_atendimento`
ADD COLUMN `siacweb_hist_erro_cod`  int(10) NULL AFTER `nan_prazo_validacao`,
ADD COLUMN `siacweb_hist_erro_msg`  varchar(255) NULL AFTER `siacweb_hist_erro_cod`;

-- 21/09/2016

ALTER TABLE `grc_evento`
ADD COLUMN `nao_sincroniza_rm`  char(1) NOT NULL DEFAULT 'N' AFTER `sincroniza_loja`;

ALTER TABLE `plu_usuario`
ADD COLUMN `evento_sincroniza_rm`  char(1) NOT NULL DEFAULT 'N' AFTER `mostra_barra_home`;

ALTER TABLE `grc_sincroniza_siac`
DROP INDEX `un_grc_sincroniza_siac_1` ,
ADD UNIQUE INDEX `un_grc_sincroniza_siac_1` (`idt_entidade`, `idt_atendimento`, `idt_evento`, `tipo`) USING BTREE ;

-- 29/09/2016

ALTER TABLE `plu_perfil`
ADD COLUMN `coloca_evento_retroaitvo`  char(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'N' AFTER `mostra_pk`;

-- 03/10/2016

CREATE TABLE `grc_historico_meta` (
  `idt` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idt_atendimento` int(10) unsigned NOT NULL,
  `horas_atendimento` decimal(15,2) DEFAULT NULL,
  `idt_ponto_atendimento` int(10) unsigned DEFAULT NULL,
  `idt_instrumento` int(10) unsigned DEFAULT NULL,
  `cpf` varchar(45) DEFAULT NULL,
  `cnpj` varchar(45) DEFAULT NULL,
  `data_base` date NOT NULL,
  `protocolo` varchar(45) DEFAULT NULL,
  `ponto_atendimento` varchar(120) DEFAULT NULL,
  `instrumento` varchar(120) DEFAULT NULL,
  `porte` varchar(120) DEFAULT NULL,
  `data_atendimento` datetime DEFAULT NULL,
  `origem` varchar(45) DEFAULT NULL,
  `razao_social` varchar(120) DEFAULT NULL,
  `nome` varchar(120) DEFAULT NULL,
  `idt_porte` int(10) unsigned DEFAULT NULL,
  `idt_tipo_empreendimento` int(10) unsigned DEFAULT NULL,
  `tipo_empreendimento` varchar(120) DEFAULT NULL,
  `evento_concluido` char(1) DEFAULT NULL,
  `evento_contrato` varchar(45) DEFAULT NULL,
  `evento` varchar(120) DEFAULT NULL,
  `idt_evento` int(10) unsigned DEFAULT NULL,
  `horas_evento` decimal(15,2) DEFAULT NULL,
  `inovacao` char(1) DEFAULT NULL,
  `idt_foco_tematico` int(10) unsigned DEFAULT NULL,
  `dt_previsao_fim` date DEFAULT NULL,
  `dt_previsao_inicial` date DEFAULT NULL,
  `tipo_pessoa` char(1) DEFAULT NULL,
  `natureza` char(2) DEFAULT NULL,
  `meta1` char(1) DEFAULT NULL,
  `meta2` char(2) DEFAULT NULL,
  `meta3` char(1) DEFAULT NULL,
  `meta4` char(1) DEFAULT NULL,
  `meta5` char(1) DEFAULT NULL,
  `meta7` char(1) DEFAULT NULL,
  `idt_segmentacao` int(10) unsigned DEFAULT NULL,
  `segmentacao` varchar(45) DEFAULT NULL,
  `instrumento_intensidade` char(2) DEFAULT NULL,
  `instrumento_sigla` char(2) DEFAULT NULL,
  `porte_meta` char(5) DEFAULT NULL,
  `status_1` char(2) DEFAULT NULL,
  `status_2` char(2) DEFAULT NULL,
  PRIMARY KEY (`idt`),
  KEY `iu_grc_historico_meta` (`data_base`,`idt_atendimento`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 10/10/2016

insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_nan_troca_tutor','Troca de Tutor','05.70.50.35','N','N','cadastro','cadastro');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_nan_troca_tutor') as id_funcao
from plu_direito where cod_direito in ('alt');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_nan_troca_tutor');

-- 11/10/2016

insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_atendimento_monitor','Monitoramento de Atendimentos (Consultor)','99.01.10','N','N','listar','listar');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_atendimento_monitor') as id_funcao
from plu_direito where cod_direito in ('alt', 'con');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_atendimento_monitor');

-- homologa
-- producao
-- sala