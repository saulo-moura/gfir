-- esmeraldo
-- desenvolve
-- producao

-- 30/05/2017

UPDATE grc_evento e
INNER JOIN grc_sincroniza_siac s ON s.idt_evento = e.idt
SET e.dt_consolidado = s.dt_registro
WHERE
	e.dt_consolidado IS NULL
AND s.tipo = 'EV_CON';

ALTER TABLE `grc_evento`
ADD COLUMN `ws_sg_idt_erro_log`  int(11) NULL AFTER `ws_sg_erro`;

ALTER TABLE `grc_evento` ADD CONSTRAINT `FK_grc_evento_32` FOREIGN KEY (`ws_sg_idt_erro_log`) REFERENCES `plu_erro_log` (`idt`) ON DELETE SET NULL ON UPDATE RESTRICT;

-- 14/06/2017

ALTER TABLE `grc_atendimento_pessoa`
ADD COLUMN `ws_sg_dt_cadastro`  datetime NULL DEFAULT NULL AFTER `siacweb_hist_erro_msg`,
ADD COLUMN `ws_sg_iddemanda`  int(10) NULL DEFAULT NULL AFTER `ws_sg_dt_cadastro`,
ADD COLUMN `ws_sg_erro`  text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL AFTER `ws_sg_iddemanda`,
ADD COLUMN `ws_sg_idt_erro_log`  int(11) NULL DEFAULT NULL AFTER `ws_sg_erro`;

ALTER TABLE `grc_atendimento_pessoa` ADD CONSTRAINT `FK_grc_atendimento_pessoa_5` FOREIGN KEY (`ws_sg_idt_erro_log`) REFERENCES `plu_erro_log` (`idt`) ON DELETE SET NULL ON UPDATE RESTRICT;

ALTER TABLE `grc_evento`
DROP COLUMN `ws_sg_iddemanda`;

-- 13/07/2017

ALTER TABLE `grc_evento`
ADD COLUMN `idt_contratar_credenciado_distrato`  int(10) UNSIGNED NULL AFTER `ws_sg_idt_erro_log`;

ALTER TABLE `grc_evento` ADD CONSTRAINT `FK_grc_evento_33` FOREIGN KEY (`idt_contratar_credenciado_distrato`) REFERENCES `db_pir_gec`.`gec_contratar_credenciado_distrato` (`idt`) ON DELETE RESTRICT ON UPDATE RESTRICT;

-- 15/07/2017

insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('gec_contratar_credenciado_distrato','Solicitar Distrato','02.03.95','S','S','listar','listar');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'gec_contratar_credenciado_distrato') as id_funcao
from plu_direito where cod_direito in ('con', 'exc', 'alt', 'inc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('gec_contratar_credenciado_distrato');

select id_funcao INTO @id_funcao from plu_funcao where cod_funcao = 'gec_contratar_credenciado_distrato';
INSERT INTO `db_pir_grc`.`plu_painel_funcao` (`idt_painel_grupo`, `id_funcao`, `pos_top`, `pos_left`, `imagem`, `imagem_d`, `texto_cab`, `detalhe`, `visivel`, `hint`, `parametros`, `texto_font_tam`, `texto_ativ_font_cor`, `texto_ativ_fundo`, `texto_desativ_font_cor`, `texto_desativ_fundo`, `include`, `include_arq`, `include_altura`, `include_largura`) VALUES ('4', @id_funcao, '105', '768', NULL, NULL, NULL, NULL, 'S', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'N', NULL, NULL, NULL);

-- 17/07/2017

insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('gec_contratar_credenciado_distrato_anexos','Distrato - Anexos','02.03.95.03','S','S','listar','listar');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'gec_contratar_credenciado_distrato_anexos') as id_funcao
from plu_direito where cod_direito in ('con', 'exc', 'alt', 'inc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('gec_contratar_credenciado_distrato_anexos');

insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('gec_contratar_credenciado_distrato_parecer','Distrato - Parecer','02.03.95.05','S','S','listar','listar');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'gec_contratar_credenciado_distrato_parecer') as id_funcao
from plu_direito where cod_direito in ('con', 'exc', 'alt', 'inc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('gec_contratar_credenciado_distrato_parecer');

-- 19/07/2017

ALTER TABLE `grc_evento_participante_contadevolucao`
ADD COLUMN `reg_origem`  char(2) NOT NULL DEFAULT 'MA' AFTER `idt_evento_participante_pagamento`;

ALTER TABLE `grc_evento_participante_contadevolucao`
ADD COLUMN `idt_contratar_credenciado_distrato`  int(10) UNSIGNED NULL AFTER `reg_origem`;

ALTER TABLE `grc_evento_participante_contadevolucao` ADD CONSTRAINT `fk_grc_evento_participante_contadevolucao_3` FOREIGN KEY (`idt_contratar_credenciado_distrato`) REFERENCES `db_pir_gec`.`gec_contratar_credenciado_distrato` (`idt`) ON DELETE CASCADE ON UPDATE RESTRICT;

insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('gec_contratar_credenciado_distrato_parecer_anexos','Distrato - Parecer - Anexos','02.03.95.05.03','S','S','listar','listar');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'gec_contratar_credenciado_distrato_parecer_anexos') as id_funcao
from plu_direito where cod_direito in ('con', 'exc', 'alt', 'inc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('gec_contratar_credenciado_distrato_parecer_anexos');

ALTER TABLE `grc_atendimento_pendencia`
ADD COLUMN `idt_contratar_credenciado_distrato`  int(10) UNSIGNED NULL DEFAULT NULL AFTER `data_acao`,
ADD COLUMN `situacao_distrato_de`  char(2) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL AFTER `idt_contratar_credenciado_distrato`,
ADD COLUMN `situacao_distrato_para`  char(2) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL AFTER `situacao_distrato_de`;

ALTER TABLE `grc_atendimento_pendencia` ADD CONSTRAINT `FK_grc_atendimento_pendencia_15` FOREIGN KEY (`idt_contratar_credenciado_distrato`) REFERENCES `db_pir_gec`.`gec_contratar_credenciado_distrato` (`idt`) ON DELETE RESTRICT ON UPDATE RESTRICT;

insert into plu_direito_perfil (id_perfil, id_difu)
select 2 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('gec_contratar_credenciado_distrato', 'gec_contratar_credenciado_distrato_anexos');

-- 19/09/2017

ALTER TABLE `grc_evento_participante_contadevolucao`
ADD COLUMN `vl_ja_devolvido`  decimal(15,2) NULL AFTER `vl_pago`;

ALTER TABLE `grc_evento_participante_contadevolucao`
MODIFY COLUMN `vl_ja_devolvido`  decimal(15,2) NULL DEFAULT NULL AFTER `razao_social`,
ADD COLUMN `vl_pago_compra`  decimal(15,2) NULL AFTER `razao_social`;

-- Mesclagem com o ramo OS012_Aditivo

-- 27/07/2017

insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('gec_contratar_credenciado_aditivo','Solicitar Aditivo','02.03.96','S','S','listar','listar');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'gec_contratar_credenciado_aditivo') as id_funcao
from plu_direito where cod_direito in ('con', 'exc', 'alt', 'inc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('gec_contratar_credenciado_aditivo');

select id_funcao INTO @id_funcao from plu_funcao where cod_funcao = 'gec_contratar_credenciado_aditivo';
INSERT INTO `db_pir_grc`.`plu_painel_funcao` (`idt_painel_grupo`, `id_funcao`, `pos_top`, `pos_left`, `imagem`, `imagem_d`, `texto_cab`, `detalhe`, `visivel`, `hint`, `parametros`, `texto_font_tam`, `texto_ativ_font_cor`, `texto_ativ_fundo`, `texto_desativ_font_cor`, `texto_desativ_fundo`, `include`, `include_arq`, `include_altura`, `include_largura`) VALUES ('4', @id_funcao, '105', '768', NULL, NULL, NULL, NULL, 'S', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'N', NULL, NULL, NULL);

insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('gec_contratar_credenciado_aditivo_anexos','Aditivo - Anexos','02.03.96.03','S','S','listar','listar');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'gec_contratar_credenciado_aditivo_anexos') as id_funcao
from plu_direito where cod_direito in ('con', 'exc', 'alt', 'inc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('gec_contratar_credenciado_aditivo_anexos');

insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('gec_contratar_credenciado_aditivo_parecer','Aditivo - Parecer','02.03.96.05','S','S','listar','listar');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'gec_contratar_credenciado_aditivo_parecer') as id_funcao
from plu_direito where cod_direito in ('con', 'exc', 'alt', 'inc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('gec_contratar_credenciado_aditivo_parecer');

insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('gec_contratar_credenciado_aditivo_parecer_anexos','Aditivo - Parecer - Anexos','02.03.96.05.03','S','S','listar','listar');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'gec_contratar_credenciado_aditivo_parecer_anexos') as id_funcao
from plu_direito where cod_direito in ('con', 'exc', 'alt', 'inc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('gec_contratar_credenciado_aditivo_parecer_anexos');

insert into plu_direito_perfil (id_perfil, id_difu)
select 2 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('gec_contratar_credenciado_aditivo', 'gec_contratar_credenciado_aditivo_anexos');

ALTER TABLE `grc_atendimento_pendencia`
CHANGE COLUMN `situacao_distrato_de` `situacao_de`  char(2) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL AFTER `idt_contratar_credenciado_distrato`,
CHANGE COLUMN `situacao_distrato_para` `situacao_para`  char(2) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL AFTER `situacao_de`,
ADD COLUMN `idt_contratar_credenciado_aditivo`  int(10) UNSIGNED NULL DEFAULT NULL AFTER `idt_contratar_credenciado_distrato`;

ALTER TABLE `grc_atendimento_pendencia` ADD CONSTRAINT `FK_grc_atendimento_pendencia_16` FOREIGN KEY (`idt_contratar_credenciado_aditivo`) REFERENCES `db_pir_gec`.`gec_contratar_credenciado_aditivo` (`idt`) ON DELETE RESTRICT ON UPDATE RESTRICT;

INSERT INTO `db_pir_grc`.`plu_config` (`variavel`, `descricao`, `valor`, `extra`, `js`, `classificacao`) VALUES ('aditivo_limite_valor', '[SEBRAETEC] Porcentagem que pode ser executada no Aditivo (%)', '25', NULL, 'N', NULL);

-- 28/07/2017

insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('gec_contratar_credenciado_aditivo_participante','Aditivo - Pagamento Cliente','02.03.96.07','S','S','listar','listar');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'gec_contratar_credenciado_aditivo_participante') as id_funcao
from plu_direito where cod_direito in ('con', 'alt');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('gec_contratar_credenciado_aditivo_participante');

ALTER TABLE `grc_evento_participante_pagamento`
ADD COLUMN `idt_aditivo_participante`  int(10) UNSIGNED NULL AFTER `operacao`;

ALTER TABLE `grc_evento_participante_pagamento` ADD CONSTRAINT `grc_evento_participante_pagamento_ibfk_8` FOREIGN KEY (`idt_aditivo_participante`) REFERENCES `db_pir_gec`.`gec_contratar_credenciado_aditivo_participante` (`idt`) ON DELETE RESTRICT ON UPDATE RESTRICT;

insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('gec_contratar_credenciado_aditivo_participante_pagamento','Aditivo - Pagamento Cliente - Registro','02.03.96.07.03','S','S','listar','listar');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'gec_contratar_credenciado_aditivo_participante_pagamento') as id_funcao
from plu_direito where cod_direito in ('con', 'alt', 'exc', 'inc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('gec_contratar_credenciado_aditivo_participante_pagamento');

-- Fim da Mesclagem com o ramo OS012_Aditivo

-- 16/12/2017

INSERT INTO `db_pir_grc`.`plu_config` (`variavel`, `descricao`, `valor`, `extra`, `js`, `classificacao`) VALUES ('distrato_dias_sem_assinar_pst', '[SEBRAETEC] Quantidade de dias (corridos) que a PST tem antes de enviar o email avisando a falta da assinatura', '10', NULL, 'N', NULL);

-- homologacao
-- sala