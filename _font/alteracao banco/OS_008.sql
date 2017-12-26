-- Treina

-- 18/04/2017

ALTER TABLE `db_pir_grc`.`grc_evento` MODIFY COLUMN `idt_gestor_evento` INT(10) DEFAULT NULL,
 ADD CONSTRAINT `FK_grc_evento_31` FOREIGN KEY `FK_grc_evento_31` (`idt_gestor_evento`)
    REFERENCES `plu_usuario` (`id_usuario`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT;	
	
-- 12/05/2017

UPDATE `db_pir_grc`.`plu_funcao`
SET nm_funcao='RELATÓRIO DE EVENTOS (STATUS EVENTOS/STATUS FINANCEIRO'
WHERE cod_funcao = 'grc_sebraetec_r03';

-- 24/05/2017

ALTER TABLE `db_pir_grc`.`grc_projeto` ADD COLUMN `idt_setor` INT(10) UNSIGNED AFTER `nan`;

-- 25/05/2017

ALTER TABLE `grc_projeto` DROP FOREIGN KEY `fk_grc_projeto_1`;

ALTER TABLE `grc_projeto` ADD CONSTRAINT `fk_grc_projeto_1` FOREIGN KEY (`idt_responsavel`) REFERENCES `plu_usuario` (`id_usuario`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `grc_projeto` ADD CONSTRAINT `fk_grc_projeto_2` FOREIGN KEY (`idt_setor`) REFERENCES `db_pir_gec`.`gec_entidade_setor` (`idt`) ON DELETE RESTRICT ON UPDATE RESTRICT;

-- 05/07/2017

ALTER TABLE `db_sebrae_pfo`.`pfo_af_processo` ADD COLUMN `liquidado` CHAR(1) NOT NULL DEFAULT 'N' AFTER `nf_cnpjcpf`;

  CREATE TABLE `db_pir_grc`.`grc_sebraetec_setor` (
  `idt` INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  `codigo` VARCHAR(45) NOT NULL,
  `descricao` VARCHAR(120) NOT NULL,
  `ativo` VARCHAR(1) NOT NULL,
  `detalhe` TEXT NOT NULL,
  PRIMARY KEY (`idt`),
  UNIQUE INDEX `iu_grc_setor` USING BTREE(`codigo`)
)
ENGINE = InnoDB;

INSERT INTO `db_pir_grc`.`grc_sebraetec_setor` (codigo, descricao, ativo, detalhe)
VALUES (1, 'INDÚSTRIA', 'S', '');

INSERT INTO `db_pir_grc`.`grc_sebraetec_setor` (codigo, descricao, ativo, detalhe)
VALUES (2, 'COMÉRCIO', 'S', '');

INSERT INTO `db_pir_grc`.`grc_sebraetec_setor` (codigo, descricao, ativo, detalhe)
VALUES (3, 'SERVIÇOS', 'S', '');

INSERT INTO `db_pir_grc`.`grc_sebraetec_setor` (codigo, descricao, ativo, detalhe)
VALUES (4, 'AGRONEGOCIOS', 'S', '');

ALTER TABLE `db_pir_grc`.`grc_projeto`
 DROP FOREIGN KEY `fk_grc_projeto_2`;

ALTER TABLE `db_pir_grc`.`grc_projeto` ADD CONSTRAINT `fk_grc_projeto_2` FOREIGN KEY `fk_grc_projeto_2` (`idt_setor`)
    REFERENCES `grc_sebraetec_setor` (`idt`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT;
	
INSERT INTO plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
VALUES ('grc_sebraetec_setor','Setor','01.99.58','N','N','listar','listar');

INSERT INTO plu_direito_funcao (id_direito, id_funcao)
SELECT id_direito, (SELECT id_funcao FROM plu_funcao WHERE cod_funcao = 'grc_sebraetec_setor') as id_funcao
FROM plu_direito WHERE cod_direito in ('alt', 'con', 'exc', 'inc');

INSERT INTO plu_direito_perfil (id_perfil, id_difu)
SELECT 1 AS id_perfil, id_difu FROM plu_direito_funcao df INNER JOIN plu_funcao f ON df.id_funcao = f.id_funcao
WHERE f.cod_funcao IN ('grc_sebraetec_setor');

-- sala
-- Desenvolve
-- Jonata
-- Homologa
-- Producao