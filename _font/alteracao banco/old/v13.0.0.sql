-- esmeraldo

-- 20/06/2016

insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu, abrir_sistema)
values ('grc_nan_ordem_pagamento_monitoramento','Monitoramento da Ordem de Pagamento NAN','05.70.50.10','N','N', 'listar', 'listar', null);

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_nan_ordem_pagamento_monitoramento') as id_funcao
from plu_direito where cod_direito in ('con');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_nan_ordem_pagamento_monitoramento');

INSERT INTO `db_pir_grc`.`plu_painel_funcao` (`idt_painel_grupo`, `id_funcao`, `pos_top`, `pos_left`, `imagem`, `imagem_d`, `texto_cab`, `detalhe`, `visivel`, `hint`, `parametros`, `texto_font_tam`, `texto_ativ_font_cor`, `texto_ativ_fundo`, `texto_desativ_font_cor`, `texto_desativ_fundo`, `include`, `include_arq`, `include_altura`, `include_largura`) VALUES ('28', null, '230', '120', NULL, NULL, 'Monitoramento da Ordem de Pagamento NAN', NULL, 'S', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'N', NULL, NULL, NULL);

insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu, abrir_sistema)
values ('grc_atendimento_pendencia_troca','Troca do Responsável na Pendências','05.01.51','N','N', 'listar', 'listar', null);

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_atendimento_pendencia_troca') as id_funcao
from plu_direito where cod_direito in ('con', 'alt');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_atendimento_pendencia_troca');

INSERT INTO `db_pir_grc`.`plu_painel_funcao` (`idt_painel_grupo`, `id_funcao`, `pos_top`, `pos_left`, `imagem`, `imagem_d`, `texto_cab`, `detalhe`, `visivel`, `hint`, `parametros`, `texto_font_tam`, `texto_ativ_font_cor`, `texto_ativ_fundo`, `texto_desativ_font_cor`, `texto_desativ_fundo`, `include`, `include_arq`, `include_altura`, `include_largura`) VALUES ('52', null, '0', '780', NULL, NULL, 'Trocar Tutor', NULL, 'S', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'N', NULL, NULL, NULL);

-- 23/06/2016

ALTER TABLE `grc_evento_agenda`
ADD COLUMN `idt_atendimento`  int(10) UNSIGNED NULL DEFAULT NULL AFTER `idt_evento`;

ALTER TABLE `grc_evento_agenda` ADD CONSTRAINT `fk_grc_evento_agenda_6` FOREIGN KEY (`idt_atendimento`) REFERENCES `grc_atendimento` (`idt`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `grc_evento_participante` DROP FOREIGN KEY `FK_grc_evento_participante_2`;

ALTER TABLE `grc_evento_participante` DROP FOREIGN KEY `FK_grc_evento_participante_3`;

ALTER TABLE `grc_evento_participante` DROP FOREIGN KEY `FK_grc_evento_participante_4`;

ALTER TABLE `grc_evento_participante` ADD CONSTRAINT `FK_grc_evento_participante_2` FOREIGN KEY (`idt_atendimento`) REFERENCES `grc_atendimento` (`idt`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `grc_evento_participante` ADD CONSTRAINT `FK_grc_evento_participante_3` FOREIGN KEY (`idt_stand`) REFERENCES `grc_evento_stand` (`idt`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `grc_evento_participante` ADD CONSTRAINT `FK_grc_evento_participante_4` FOREIGN KEY (`idt_midia`) REFERENCES `db_pir_gec`.`gec_meio_informacao` (`idt`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `grc_evento_agenda` DROP FOREIGN KEY `fk_grc_evento_agenda_6`;

ALTER TABLE `grc_evento_agenda` ADD CONSTRAINT `fk_grc_evento_agenda_6` FOREIGN KEY (`idt_atendimento`) REFERENCES `grc_atendimento` (`idt`) ON DELETE CASCADE ON UPDATE RESTRICT;

-- 27/06/2016

ALTER TABLE `grc_evento_participante_pagamento`
ADD COLUMN `percent_valor`  decimal(15,7) NULL AFTER `valor_pagamento`;

-- 28/06/2016

ALTER TABLE `grc_evento_participante_pagamento`
MODIFY COLUMN `percent_valor`  decimal(15,11) NULL DEFAULT NULL AFTER `valor_pagamento`;

-- 29/06/2016

ALTER TABLE `grc_sincroniza_siac` DROP FOREIGN KEY `fk_grc_sincroniza_siac_2`;

ALTER TABLE `grc_sincroniza_siac` DROP FOREIGN KEY `fk_grc_sincroniza_siac_3`;

ALTER TABLE `grc_sincroniza_siac` DROP FOREIGN KEY `fk_grc_sincroniza_siac_4`;

ALTER TABLE `grc_sincroniza_siac`
ADD COLUMN `idt_evento_participante_pagamento`  int(10) UNSIGNED NULL AFTER `idt_evento`;

ALTER TABLE `grc_sincroniza_siac` ADD CONSTRAINT `fk_grc_sincroniza_siac_2` FOREIGN KEY (`idt_atendimento`) REFERENCES `grc_atendimento` (`idt`) ON DELETE CASCADE ON UPDATE RESTRICT;

ALTER TABLE `grc_sincroniza_siac` ADD CONSTRAINT `fk_grc_sincroniza_siac_3` FOREIGN KEY (`idt_evento`) REFERENCES `grc_evento` (`idt`) ON DELETE CASCADE ON UPDATE RESTRICT;

ALTER TABLE `grc_sincroniza_siac` ADD CONSTRAINT `fk_grc_sincroniza_siac_4` FOREIGN KEY (`idt_atendimento_pessoa`) REFERENCES `grc_atendimento_pessoa` (`idt`) ON DELETE CASCADE ON UPDATE RESTRICT;

ALTER TABLE `grc_sincroniza_siac` ADD CONSTRAINT `fk_grc_sincroniza_siac_6` FOREIGN KEY (`idt_evento_participante_pagamento`) REFERENCES `grc_evento_participante_pagamento` (`idt`) ON DELETE CASCADE ON UPDATE RESTRICT;

ALTER TABLE `grc_atendimento_pendencia`
ADD INDEX `FK_grc_atendimento_pendencia_11` (`idt_atendimento`) USING BTREE ;

-- 30/06/2016

ALTER TABLE `grc_atendimento_instrumento`
ADD COLUMN `contrapartida_sgtec`  decimal(15,2) NULL DEFAULT NULL AFTER `balcao`;

UPDATE `grc_atendimento_instrumento` SET `contrapartida_sgtec`='30' WHERE `idt`='40';
UPDATE `grc_atendimento_instrumento` SET `contrapartida_sgtec`='30' WHERE `idt`='50';

-- producao
-- homologa
-- sala