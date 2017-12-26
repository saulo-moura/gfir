-- 15-02-2016

CREATE TABLE `db_pir_grc`.`grc_evento_portal` (
  `idt` INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  `idt_evento` INTEGER UNSIGNED NOT NULL,
  `banner_imagem` VARCHAR(255),
  `titulo` VARCHAR(120),
  `resumo` TEXT,
  `apresentacaohtml` TEXT,
  `idt_responsavel` INTEGER UNSIGNED,
  `data_cadastro` DATETIME,
  PRIMARY KEY (`idt`),
  UNIQUE INDEX `iu_grc_evento_portal`(`idt_evento`)
)
ENGINE = InnoDB;

ALTER TABLE `db_pir_grc`.`grc_evento_portal` ADD CONSTRAINT `FK_grc_evento_portal_1` FOREIGN KEY `FK_grc_evento_portal_1` (`idt_evento`)
    REFERENCES `grc_evento` (`idt`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE;
	
	
	ALTER TABLE `db_pir_grc`.`grc_evento_portal` ADD COLUMN `imagem_width` NUMERIC(15,7) AFTER `data_cadastro`,
 ADD COLUMN `imagem_height` numeric(15,2) AFTER `imagem_width`;


ALTER TABLE `db_pir_grc`.`grc_evento_portal` ADD COLUMN `link` VARCHAR(255) AFTER `imagem_height`;

ALTER TABLE `db_pir_grc`.`grc_evento_portal` CHANGE COLUMN `idt_responsavel` `idt_responsavel_registro` INT(10) UNSIGNED DEFAULT NULL;

