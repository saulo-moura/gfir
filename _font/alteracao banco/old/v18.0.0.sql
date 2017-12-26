-- esmeraldo

ALTER TABLE `plu_erro_log`
ADD INDEX `un_plu_erro_log_1` (`data`, `idt`) ;

-- 21/10/2016

update plu_funcao set des_prefixo = 'cadastro', prefixo_menu = 'cadastro' where cod_funcao = 'grc_nan_transferir_atendimento';

-- 27/10/2016

ALTER TABLE `grc_produto`
ADD COLUMN `tipo_calculo`  char(1) NULL AFTER `pc_seminario`,
ADD COLUMN `forcar_carga_horarria`  char(1) NULL AFTER `tipo_calculo`;

update grc_produto set forcar_carga_horarria = 'N'
where idt_instrumento = 39
and (idt_programa <> 4 
or idt_programa is null
);

-- 05/11/2016

ALTER TABLE `grc_evento`
ADD COLUMN `dt_real_ini`  datetime NULL AFTER `tipo_sincroniza_siacweb_old`,
ADD COLUMN `seg_real_ini`  char(3) NULL AFTER `dt_real_ini`,
ADD COLUMN `siacweb_hist_hora_ini`  datetime NULL AFTER `seg_real_ini`;

UPDATE grc_evento SET 
	siacweb_hist_hora_ini = concat(dt_previsao_inicial, ' ', hora_inicio)
WHERE
	idt_evento_situacao = 20;

ALTER TABLE `plu_usuario`
ADD COLUMN `evento_muda_dt_real_ini_hist`  char(1) NOT NULL DEFAULT 'N' AFTER `evento_sincroniza_rm`;

-- 07/11/2016

ALTER TABLE `grc_evento`
MODIFY COLUMN `seg_real_ini`  char(3) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL AFTER `tipo_sincroniza_siacweb_old`,
ADD COLUMN `muda_dt_hist`  char(1) NOT NULL DEFAULT 'N' AFTER `tipo_sincroniza_siacweb_old`,
ADD COLUMN `dt_real_fim`  datetime NULL AFTER `dt_real_ini`,
ADD COLUMN `siacweb_hist_hora_fim`  datetime NULL AFTER `siacweb_hist_hora_ini`;

UPDATE grc_evento SET 
	siacweb_hist_hora_fim = concat(dt_previsao_fim, ' ', hora_fim)
WHERE
	idt_evento_situacao = 20;

-- 11/11/2016

ALTER TABLE `grc_evento_participante`
ADD COLUMN `ativo`  char(1) NOT NULL DEFAULT 'S' AFTER `idt_atendimento`;

UPDATE `grc_atendimento_instrumento` SET `descricao`='Evento Composto' WHERE (`idt`='52');

ALTER TABLE `grc_atendimento`
ADD COLUMN `idt_atendimento_pai`  int(10) UNSIGNED NULL AFTER `idt_evento`;

ALTER TABLE `grc_atendimento` ADD CONSTRAINT `FK_grc_atendimento_28` FOREIGN KEY (`idt_atendimento_pai`) REFERENCES `grc_atendimento` (`idt`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `grc_atendimento`
DROP INDEX `iu_grc_atendimento` ,
ADD INDEX `iu_grc_atendimento` (`protocolo`) USING BTREE ;

-- 18/11/2016

ALTER TABLE `grc_atendimento_instrumento`
ADD COLUMN `idt_produto_tipo`  int(10) UNSIGNED NULL AFTER `descricao_matriz`;

ALTER TABLE `grc_atendimento_instrumento` ADD CONSTRAINT `FK_grc_atendimento_instrumento_2` FOREIGN KEY (`idt_produto_tipo`) REFERENCES `grc_produto_tipo` (`idt`) ON DELETE RESTRICT ON UPDATE RESTRICT;

update grc_atendimento_instrumento set idt_produto_tipo = 1 where nivel = 1;
update grc_atendimento_instrumento set idt_produto_tipo = 2 where idt = 39;

-- 16/12/2016

-- CLD
/* Já executado em Produção
ALTER TABLE `grc_atendimento_pessoa`
ADD COLUMN `siacweb_codcosultoria`  int(10) UNSIGNED NULL DEFAULT NULL AFTER `codigo_siacweb`;

update grc_atendimento a
inner join grc_atendimento_pessoa p on p.idt_atendimento = a.idt and p.tipo_relacao = 'L'
set p.siacweb_codcosultoria = a.siacweb_codcosultoria
where a.siacweb_codcosultoria is not null;

ALTER TABLE `grc_atendimento`
DROP COLUMN `siacweb_codcosultoria`;

ALTER TABLE `grc_atendimento_pessoa`
ADD COLUMN `siacweb_hist_erro_cod`  int(10) NULL DEFAULT NULL AFTER `falta_sincronizar_siacweb`,
ADD COLUMN `siacweb_hist_erro_msg`  varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL AFTER `siacweb_hist_erro_cod`;

update grc_atendimento a
inner join grc_atendimento_pessoa p on p.idt_atendimento = a.idt
set p.siacweb_hist_erro_cod = a.siacweb_hist_erro_cod, p.siacweb_hist_erro_msg = a.siacweb_hist_erro_msg
where a.siacweb_hist_erro_cod is not null;

ALTER TABLE `grc_atendimento`
DROP COLUMN `siacweb_hist_erro_cod`,
DROP COLUMN `siacweb_hist_erro_msg`;
*/

-- 21/12/2016

CREATE TABLE `grc_evento_declaracao` (
  `idt` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idt_evento` int(10) unsigned NOT NULL,
  `idt_pfo_af_processo` int(10) unsigned NOT NULL,
  `ativo` char(1) NOT NULL,
  `arquivo` varchar(255) NOT NULL,
  `md5` char(32) NOT NULL,
  `ip` varchar(45) NOT NULL,
  `login_aprovacao` varchar(150) NOT NULL,
  `codigo_evento` varchar(45) NOT NULL,
  `codigo_produto` varchar(45) DEFAULT NULL,
  `vl_despesa` decimal(15,2) NOT NULL,
  `vl_receita` decimal(15,2) NOT NULL,
  `codigo_os` varchar(45) NOT NULL,
  `vl_os` decimal(15,2) NOT NULL,
  `dt_aprovacao` datetime NOT NULL,
  `idt_usuario_aprovacao` int(10) NOT NULL,
  `dt_cancelamento` datetime DEFAULT NULL,
  `idt_usuario_cancelamento` int(10) DEFAULT NULL,
  PRIMARY KEY (`idt`),
  KEY `fk_grc_evento_declaracao_1` (`idt_evento`),
  KEY `fk_grc_evento_declaracao_2` (`idt_usuario_aprovacao`),
  KEY `fk_grc_evento_declaracao_3` (`idt_usuario_cancelamento`),
  KEY `fk_grc_evento_declaracao_4` (`idt_pfo_af_processo`),
  CONSTRAINT `fk_grc_evento_declaracao_4` FOREIGN KEY (`idt_pfo_af_processo`) REFERENCES `db_sebrae_pfo`.`pfo_af_processo` (`idt`),
  CONSTRAINT `fk_grc_evento_declaracao_1` FOREIGN KEY (`idt_evento`) REFERENCES `grc_evento` (`idt`),
  CONSTRAINT `fk_grc_evento_declaracao_2` FOREIGN KEY (`idt_usuario_aprovacao`) REFERENCES `plu_usuario` (`id_usuario`),
  CONSTRAINT `fk_grc_evento_declaracao_3` FOREIGN KEY (`idt_usuario_cancelamento`) REFERENCES `plu_usuario` (`id_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `grc_evento_anexo`
ADD COLUMN `so_consulta`  char(1) NOT NULL DEFAULT 'N' AFTER `arquivo`;

insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_evento_declaracao','Declaração de Conclusão dos Serviços no Evento','02.03.80','N','N','listar','listar');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_evento_declaracao') as id_funcao
from plu_direito where cod_direito in ('con');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df 
inner join plu_funcao f on df.id_funcao = f.id_funcao
inner join plu_direito d on df.id_direito = d.id_direito
where f.cod_funcao in ('grc_evento_declaracao');
-- and d.cod_direito in ('alt','con');

-- 13/03/2017

ALTER TABLE `grc_evento`
ADD COLUMN `inc_cliente_prev`  char(1) NOT NULL DEFAULT 'N' AFTER `idt_evento_motivo_cancelamento`,
ADD COLUMN `inc_cliente_dt_ini`  date NULL AFTER `inc_cliente_prev`,
ADD COLUMN `inc_cliente_dt_fim`  date NULL AFTER `inc_cliente_dt_ini`;

-- sala
-- homologa
-- jonata
-- producao
