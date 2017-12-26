-- 29/07/2015

CREATE 
VIEW `gec_programa`AS 
SELECT *
FROM
db_pir_gec.gec_programa ;

ALTER 
VIEW `gec_area_conhecimento` AS 
SELECT *
from `db_pir_gec`.`gec_area_conhecimento` ;

-- 31/07/2015

ALTER TABLE `plu_painel_funcao` MODIFY COLUMN `id_funcao` INT(11) DEFAULT NULL,
 MODIFY COLUMN `pos_top` INT(10) UNSIGNED NOT NULL DEFAULT 0,
 MODIFY COLUMN `pos_left` INT(10) UNSIGNED NOT NULL DEFAULT 0,
 MODIFY COLUMN `imagem` VARCHAR(120) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL;

CREATE TABLE `plu_painel_grupo` (
  `idt` INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  `idt_painel` INTEGER UNSIGNED NOT NULL,
  `descricao` VARCHAR(255) NOT NULL,
  `hint` TEXT,
  `pos_top` INTEGER UNSIGNED NOT NULL DEFAULT 0,
  `pos_left` INTEGER UNSIGNED NOT NULL DEFAULT 0,
  `painel_altura` INTEGER UNSIGNED NOT NULL DEFAULT 0,
  `painel_largura` INTEGER UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (`idt`),
  CONSTRAINT `fk_plu_painel_grupo_1` FOREIGN KEY `fk_plu_painel_grupo_1` (`idt_painel`)
    REFERENCES `plu_painel` (`idt`)
    ON DELETE CASCADE
    ON UPDATE RESTRICT
)
ENGINE = InnoDB;

ALTER TABLE `plu_painel_funcao` ADD COLUMN `idt_painel_grupo` INTEGER UNSIGNED AFTER `parametros`
, DROP INDEX `fk_plu_painel_funcao_3`,
 ADD INDEX `fk_plu_painel_funcao_1` USING BTREE(`idt_painel`, `id_funcao`),
 ADD CONSTRAINT `fk_plu_painel_funcao_3` FOREIGN KEY `fk_plu_painel_funcao_3` (`idt_painel_grupo`)
    REFERENCES `plu_painel_grupo` (`idt`)
    ON DELETE SET NULL
    ON UPDATE RESTRICT;

insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo)
values ('plu_painel_grupo','Cadastro do Painel Grupo','90.80.05.10.05','N','N','listar');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'plu_painel_grupo') as id_funcao
from plu_direito where cod_direito in ('con', 'alt', 'exc', 'inc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('plu_painel_grupo');

ALTER TABLE `plu_painel_grupo`
DROP COLUMN `pos_top`,
DROP COLUMN `pos_left`,
ADD COLUMN `ordem`  int(10) NOT NULL AFTER `idt_painel`;


-- 05/08/2015

ALTER TABLE `grc_produto`
ADD COLUMN `todas_unidade_regional`  char(1) NOT NULL DEFAULT 'N' AFTER `data_cadastro`;


-- 07/08/2015

ALTER TABLE `plu_mime_tipo` DROP FOREIGN KEY `plu_mime_tipo_ibfk_1`;

ALTER TABLE `plu_mime_tipo` ADD CONSTRAINT `plu_mime_tipo_ibfk_1` FOREIGN KEY (`idt_miar`) REFERENCES `plu_mime_arquivo` (`idt_miar`) ON DELETE RESTRICT ON UPDATE RESTRICT;

-- 10/08/2015

ALTER TABLE `grc_produto`
MODIFY COLUMN `publico_alvo_texto`  text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL AFTER `gratuito`;

-- 13/08/2015

ALTER TABLE `plu_direito_perfil` DROP FOREIGN KEY `plu_direito_perfil_ibfk_2`;

ALTER TABLE `plu_direito_perfil` ADD CONSTRAINT `plu_direito_perfil_ibfk_2` FOREIGN KEY (`id_perfil`) REFERENCES `plu_perfil` (`id_perfil`) ON DELETE CASCADE ON UPDATE RESTRICT;

-- 14/08/2015

ALTER TABLE `plu_painel_grupo`
ADD COLUMN `codigo`  varchar(50) NOT NULL AFTER `idt_painel`;

UPDATE plu_painel_grupo set codigo = idt;

ALTER TABLE `plu_painel_grupo`
ADD UNIQUE INDEX `un_plu_painel_grupo_1` (`idt_painel`, `codigo`) ;

ALTER TABLE `plu_painel_grupo`
ADD COLUMN `mostra_barra`  char(1) NOT NULL DEFAULT 'S' AFTER `hint`;

ALTER TABLE `plu_painel_grupo`
MODIFY COLUMN `painel_altura`  int(11) UNSIGNED NOT NULL DEFAULT 0 AFTER `mostra_barra`,
MODIFY COLUMN `painel_largura`  int(11) UNSIGNED NOT NULL DEFAULT 0 AFTER `painel_altura`,
ADD COLUMN `mostra_item`  char(2) NOT NULL AFTER `mostra_barra`,
ADD COLUMN `texto_altura`  int(11) NOT NULL AFTER `mostra_item`,
ADD COLUMN `move_item`  char(1) NOT NULL AFTER `texto_altura`,
ADD COLUMN `passo`  char(1) NOT NULL AFTER `move_item`,
ADD COLUMN `layout_grid`  char(1) NOT NULL AFTER `passo`,
ADD COLUMN `img_altura`  int(11) NOT NULL AFTER `layout_grid`,
ADD COLUMN `img_largura`  int(11) NOT NULL AFTER `img_altura`,
ADD COLUMN `img_margem_dir`  int(11) NOT NULL AFTER `img_largura`,
ADD COLUMN `img_margem_esq`  int(11) NOT NULL AFTER `img_margem_dir`,
ADD COLUMN `espaco_linha`  int(11) NOT NULL AFTER `img_margem_esq`;

executar arquivo v1.1.0.php

ALTER TABLE `plu_painel`
DROP COLUMN `mostra_item`,
DROP COLUMN `texto_altura`,
DROP COLUMN `move_item`,
DROP COLUMN `passo`,
DROP COLUMN `layout_grid`,
DROP COLUMN `img_altura`,
DROP COLUMN `img_largura`,
DROP COLUMN `img_margem_dir`,
DROP COLUMN `img_margem_esq`,
DROP COLUMN `espaco_linha`,
DROP COLUMN `painel_altura`,
DROP COLUMN `painel_largura`;

ALTER TABLE `plu_painel_funcao` DROP FOREIGN KEY `fk_plu_painel_funcao_1`;

ALTER TABLE `plu_painel_funcao` DROP FOREIGN KEY `fk_plu_painel_funcao_3`;

ALTER TABLE `plu_painel_funcao`
MODIFY COLUMN `idt_painel_grupo`  int(10) UNSIGNED NULL DEFAULT NULL AFTER `idt_painel`,
DROP INDEX `fk_plu_painel_funcao_1`;

ALTER TABLE `plu_painel_funcao` ADD CONSTRAINT `fk_plu_painel_funcao_3` FOREIGN KEY (`idt_painel_grupo`) REFERENCES `plu_painel_grupo` (`idt`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `plu_painel_funcao`
DROP COLUMN `idt_painel`;

ALTER TABLE `plu_painel_grupo`
CHANGE COLUMN `mostra_barra` `tit_mostrar`  char(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'S' AFTER `hint`,
ADD COLUMN `tit_font_tam`  int(10) NULL AFTER `tit_mostrar`,
ADD COLUMN `tit_font_cor`  varchar(6) NULL AFTER `tit_font_tam`,
ADD COLUMN `tit_fundo`  varchar(6) NULL AFTER `tit_font_cor`,
ADD COLUMN `texto_font_tam`  int(10) NULL AFTER `texto_altura`,
ADD COLUMN `texto_ativ_font_cor`  varchar(6) NULL AFTER `texto_font_tam`,
ADD COLUMN `texto_ativ_fundo`  varchar(6) NULL AFTER `texto_ativ_font_cor`,
ADD COLUMN `texto_desativ_font_cor`  varchar(6) NULL AFTER `texto_ativ_fundo`,
ADD COLUMN `texto_desativ_fundo`  varchar(6) NULL AFTER `texto_desativ_font_cor`;

ALTER TABLE `plu_painel_funcao`
ADD COLUMN `texto_font_tam`  int(10) NULL AFTER `parametros`,
ADD COLUMN `texto_ativ_font_cor`  varchar(6) NULL AFTER `texto_font_tam`,
ADD COLUMN `texto_ativ_fundo`  varchar(6) NULL AFTER `texto_ativ_font_cor`,
ADD COLUMN `texto_desativ_font_cor`  varchar(6) NULL AFTER `texto_ativ_fundo`,
ADD COLUMN `texto_desativ_fundo`  varchar(6) NULL AFTER `texto_desativ_font_cor`;

ALTER TABLE `plu_painel_funcao`
ADD COLUMN `imagem_d`  varchar(120) NULL AFTER `imagem`;

-- 15/08/2015

ALTER TABLE `plu_painel_grupo`
ADD COLUMN `passo_tit`  char(1) NOT NULL DEFAULT 'N' AFTER `passo`;

ALTER TABLE `plu_painel_funcao`
ADD COLUMN `include`  char(1) NOT NULL DEFAULT 'N' AFTER `texto_desativ_fundo`,
ADD COLUMN `include_arq`  varchar(50) NULL AFTER `include`,
ADD COLUMN `include_altura`  int(10) NULL AFTER `include_arq`,
ADD COLUMN `include_largura`  int(10) NULL AFTER `include_altura`;

-- linux

