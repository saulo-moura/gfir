-- esmeraldo
-- desenvolve
-- jonata
-- producao

-- 11/08/2017

ALTER TABLE `grc_evento`
ADD COLUMN `idt_evento_situacao_antes_aprovacao`  int(10) UNSIGNED NULL DEFAULT NULL AFTER `dt_inicio_aprovacao`;

ALTER TABLE `grc_evento` ADD CONSTRAINT `FK_grc_evento_34` FOREIGN KEY (`idt_evento_situacao_antes_aprovacao`) REFERENCES `grc_evento_situacao` (`idt`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `grc_evento`
MODIFY COLUMN `dt_inicio_aprovacao`  datetime NULL DEFAULT NULL AFTER `inc_cliente_dt_fim`;

-- homologacao
-- sala