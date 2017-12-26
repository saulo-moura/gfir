-- esmeraldo
-- desenvolve
-- jonata

-- 18/09/2017

ALTER TABLE `grc_insumo_dimensionamento`
MODIFY COLUMN `descricao`  varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL AFTER `codigo`;

ALTER TABLE db_pir_bia.`bia_conteudobia`
MODIFY COLUMN `CorpoTexto`  longtext CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL AFTER `ResumoConteudo`;

-- 29/09/2017

insert into plu_direito_funcao (id_direito, id_funcao, descricao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_nan_grupo_atendimento') as id_funcao,
'Se marcado, vai poder ver todos os registros' as descricao
from plu_direito where cod_direito in ('per');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df 
inner join plu_funcao f on df.id_funcao = f.id_funcao
inner join plu_direito d on df.id_direito = d.id_direito
where f.cod_funcao in ('grc_nan_grupo_atendimento')
and d.cod_direito in ('per');

-- 09/10/2017

ALTER TABLE `grc_evento`
ADD COLUMN `idt_atendimento_evento`  int(10) UNSIGNED NULL AFTER `siac_at_erro_con`;

ALTER TABLE `grc_evento` ADD CONSTRAINT `FK_grc_evento_36` FOREIGN KEY (`idt_atendimento_evento`) REFERENCES `grc_atendimento_evento` (`idt`) ON DELETE NO ACTION ON UPDATE RESTRICT;

update grc_atendimento_evento ae inner join grc_evento e on e.idt = ae.idt_evento
set e.idt_atendimento_evento = ae.idt;

-- 10/10/2017

ALTER TABLE `grc_produto_dimensionamento`
MODIFY COLUMN `descricao`  varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL AFTER `codigo`;

ALTER TABLE `grc_evento_dimensionamento`
MODIFY COLUMN `descricao`  varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL AFTER `codigo`;

ALTER TABLE `grc_atendimento_evento_dimensionamento`
MODIFY COLUMN `descricao`  varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL AFTER `codigo`;

-- 28/10/2017

ALTER TABLE `grc_sincroniza_siac`
ADD COLUMN `idt_erro_log`  int(11) NULL DEFAULT NULL AFTER `erro`;

ALTER TABLE `grc_sincroniza_siac` ADD CONSTRAINT `fk_grc_sincroniza_siac_8` FOREIGN KEY (`idt_erro_log`) REFERENCES `plu_erro_log` (`idt`) ON DELETE SET NULL ON UPDATE RESTRICT;

-- sala
-- producao
-- homologacao
-- sala