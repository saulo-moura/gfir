-- 793717365-34

-- esmeraldo

-- 02/03/2017

ALTER TABLE `plu_log_sistema`
ADD COLUMN `vget`  longtext CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL AFTER `obj_extra`,
ADD COLUMN `vpost`  longtext CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL AFTER `vget`,
ADD COLUMN `vserver`  longtext CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL AFTER `vpost`,
ADD COLUMN `vsession`  longtext CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL AFTER `vserver`,
ADD COLUMN `vfiles`  longtext CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL AFTER `vsession`;

-- jonata

-- 05/04/2017

ALTER TABLE `grc_parametros`
MODIFY COLUMN `detalhe`  longtext CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL AFTER `html`;

-- 06/04/2016

ALTER TABLE `comunicacao`
MODIFY COLUMN `recebecontato`  char(1) NULL DEFAULT NULL AFTER `rowguid`,
MODIFY COLUMN `recebesms`  char(1) NULL DEFAULT NULL AFTER `recebecontato`,
MODIFY COLUMN `principal`  char(1) NULL DEFAULT NULL AFTER `recebesms`;

-- 17/04/2017

ALTER TABLE `grc_nan_grupo_atendimento`
ADD COLUMN `nan_ciclo`  int(10) UNSIGNED NULL AFTER `idt_organizacao`;

update grc_nan_grupo_atendimento set nan_ciclo = 1;

rodar sebrae_grc/_font/ajusta_nan_ciclo.php

-- sala

-- 04/05/2017

ALTER TABLE `grc_atendimento_agenda`
ADD INDEX `un_grc_atendimento_agenda_4` (`data`) ,
ADD INDEX `un_grc_atendimento_agenda_5` (`origem`) ;

-- sala
-- sala
-- homologacao
-- producao
-- desenvolve
