-- 11/05/2015

ALTER TABLE `plu_painel`
ADD COLUMN `passo`  char(1) NOT NULL AFTER `move_item`;

update plu_painel set passo = 'N';
