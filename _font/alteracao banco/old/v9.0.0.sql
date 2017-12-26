-- 23/03/2016

ALTER TABLE db_pir_siac_ba.unidoperacional
MODIFY COLUMN `rowguid`  varchar(36) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL AFTER `codtipounid`;

-- 24/03/2016

ALTER TABLE `grc_evento_insumo`
ADD COLUMN `quantidade_evento`  decimal(10,2) NULL AFTER `custo_total`,
ADD COLUMN `custo_total_evento`  decimal(15,2) NULL AFTER `quantidade_evento`;

ALTER TABLE `grc_evento_insumo`
DROP COLUMN `custo_total_evento`;

update grc_evento_insumo ei 
set
ei.quantidade_evento = ei.quantidade
where por_participante = 'N';

update grc_evento e
inner join grc_evento_insumo ei on ei.idt_evento = e.idt
set
ei.quantidade_evento = ei.quantidade * e.quantidade_participante
where ei.por_participante = 'S';

ALTER TABLE `db_pir_siac_ba`.`contato`
 ADD COLUMN `situacao` TINYINT(4) UNSIGNED AFTER `codcrm`,
 ADD COLUMN `dtsituacao` DATE AFTER `situacao`;

-- 29/03/2016

ALTER TABLE `grc_sincroniza_siac`
ADD COLUMN `idt_responsavel`  int(10) NULL AFTER `idt_evento`;

ALTER TABLE `grc_sincroniza_siac` ADD CONSTRAINT `fk_grc_sincroniza_siac_5` FOREIGN KEY (`idt_responsavel`) REFERENCES `plu_usuario` (`id_usuario`) ON DELETE RESTRICT ON UPDATE RESTRICT;

-- 30/03/2016

ALTER TABLE `grc_evento_participante_contrato`
ADD COLUMN `contrato_ass_pdf`  varchar(255) NULL AFTER `contrato_pdf`;

-- 31/03/2016

ALTER TABLE `grc_evento`
ADD COLUMN `cred_contratacao_cont_obs`  varchar(255) NULL AFTER `cred_cod_evento`;

-- 02/04/2016

ALTER TABLE `grc_evento_insumo`
ADD COLUMN `qtd_automatico`  char(1) NOT NULL DEFAULT 'N' AFTER `idt_profissional`;

update grc_evento_insumo  set qtd_automatico = 'S' where idt_profissional is not null;

-- esmeraldo
-- homologa
-- producao
-- sala
