-- esmeraldo
-- desenvolve
-- producao

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

-- homologacao
-- sala