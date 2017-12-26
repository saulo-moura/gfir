-- 22/05/2015

ALTER TABLE `plu_funcao`
MODIFY COLUMN `nm_funcao`  varchar(120) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL COMMENT 'Nome da Função (Descrição)' AFTER `cod_funcao`;

ALTER TABLE `plu_funcao`
ADD COLUMN `url`  varchar(255) NULL AFTER `parametros`;

-- 23/05/2015

ALTER TABLE `plu_funcao`
ADD COLUMN `abrir_sistema`  varchar(45) NULL AFTER `painel`;

