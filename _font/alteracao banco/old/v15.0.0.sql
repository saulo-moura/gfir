-- 793717365-34
-- 028373325-00 nan 2 visita

-- esmeraldo

-- 14/07/2016

INSERT INTO `db_pir_grc`.`grc_evento_natureza_pagamento` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`, `rm_idformapagto`, `lojasiac_modalidade`) VALUES ('8', 'CH', 'Cheque', NULL, 'S', '2', NULL);
INSERT INTO `db_pir_grc`.`grc_evento_forma_parcelamento` (`idt`, `codigo`, `descricao`, `detalhe`, `ativo`, `idt_natureza`, `numero_de_parcelas`, `valor_ate`, `valor_ini`, `rm_codcpg`) VALUES ('16', 'A Vista', 'A Vista', NULL, 'S', '8', '1', '0.00', '0.00', '27');

ALTER TABLE `grc_plano_facil_ferramenta`
ADD COLUMN `ativo`  char(1) NOT NULL DEFAULT 'S' AFTER `flag`;

CREATE TABLE `db_pir_grc`.`grc_evento_natureza_pagamento_instrumento` (
  `idt` INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  `idt_evento_natureza_pagamento` INTEGER UNSIGNED NOT NULL,
  `idt_atendimento_instrumento` INTEGER UNSIGNED NOT NULL,
  `qtd_limite` INTEGER UNSIGNED,
  PRIMARY KEY (`idt`),
  UNIQUE INDEX `un_grc_evento_natureza_pagamento_instrumento_2`(`idt_evento_natureza_pagamento`, `idt_atendimento_instrumento`),
  CONSTRAINT `fk_grc_evento_natureza_pagamento_instrumento_1` FOREIGN KEY `fk_grc_evento_natureza_pagamento_instrumento_1` (`idt_evento_natureza_pagamento`)
    REFERENCES `grc_evento_natureza_pagamento` (`idt`)
    ON DELETE CASCADE
    ON UPDATE RESTRICT,
  CONSTRAINT `fk_grc_evento_natureza_pagamento_instrumento_2` FOREIGN KEY `fk_grc_evento_natureza_pagamento_instrumento_2` (`idt_atendimento_instrumento`)
    REFERENCES `grc_atendimento_instrumento` (`idt`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT
)
ENGINE = InnoDB;

insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo,prefixo_menu)
values ('grc_evento_natureza_pagamento_instrumento','Natureza da Forma de Pagamento por Instrumento','02.99.17.01','N','N', 'listar', 'listar');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_evento_natureza_pagamento_instrumento') as id_funcao
from plu_direito where cod_direito in ('con', 'alt', 'inc', 'exc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('grc_evento_natureza_pagamento_instrumento');

insert into grc_evento_natureza_pagamento_instrumento (idt_evento_natureza_pagamento, idt_atendimento_instrumento)
select p.idt as idt_evento_natureza_pagamento, i.idt as idt_atendimento_instrumento
from grc_atendimento_instrumento i, grc_evento_natureza_pagamento p
where i.idt in (2, 40, 41, 45, 46, 47, 48, 49, 50)
and p.idt <> 8
order by p.idt, i.idt;

INSERT INTO `db_pir_grc`.`grc_evento_natureza_pagamento_instrumento` (`idt_evento_natureza_pagamento`, `idt_atendimento_instrumento`, `qtd_limite`) VALUES ('8', '2', '5');

-- 15/07/2016

ALTER TABLE `grc_evento_participante_pagamento`
ADD COLUMN `ch_numero`  varchar(50) NULL AFTER `rm_idmov`,
ADD COLUMN `ch_banco`  varchar(50) NULL AFTER `ch_numero`,
ADD COLUMN `ch_agencia`  varchar(50) NULL AFTER `ch_banco`,
ADD COLUMN `ch_cc`  varchar(50) NULL AFTER `ch_agencia`,
ADD COLUMN `emitente_nome`  varchar(120) NULL AFTER `ch_cc`,
ADD COLUMN `emitente_tel`  varchar(50) NULL AFTER `emitente_nome`;

-- 23/07/2016

ALTER TABLE `grc_produto`
ADD COLUMN `carga_horaria_comp`  decimal(15,2) NULL AFTER `carga_horaria_2_fim`;

ALTER TABLE `grc_evento`
ADD COLUMN `carga_horaria_comp`  decimal(15,2) NULL AFTER `carga_horaria_total`;

-- 28/07/2016

INSERT INTO `grc_nan_devolutiva_link` (`codigo`, `descricao`, `link`) VALUES ('03', 'Capacitação à Distância Sebrae', 'ead.sebrae.com.br/');
UPDATE `grc_nan_devolutiva_item` SET `detalhe`='<p><span style=\"font-family: Tahoma;\">Para se aprofundar nas ferramentas propostas, procure participar de capacitações presenciais realizadas no Ponto de Atendimento SEBRAE mais próximo de você. Para ter conhecimento da agenda de capacitações presenciais do SEBRAE, em sua região, ligue para o telefone desta regional (0800 570 0800) e pergunte sobre as próximas datas disponíveis! Ou acesse http://lojavirtual.ba.sebrae.com.br/loja/.</span></p>' WHERE (`idt`='8');

-- 29/07/2016

ALTER TABLE `grc_produto`
DROP COLUMN `carga_horaria_comp`;

ALTER TABLE `grc_evento`
DROP COLUMN `carga_horaria_comp`;

INSERT INTO `db_pir_grc`.`grc_insumo` (`codigo`, `descricao`, `ativo`, `detalhe`, `classificacao`, `idt_insumo_elemento_custo`, `idt_insumo_unidade`, `custo_unitario_real`, `por_participante`, `nivel`, `sinal`, `codigo_rm`, `tipo`, `idprd`, `evento_insc_receita`, `idt_area_suporte`, `rm_classificacao`, `estocavel`, `sebprodcrm`) VALUES ('70004', 'HORAS COMPLEMENTARES', 'S', NULL, '70.04', NULL, '1', NULL, 'N', 'S', 'S', NULL, 'S', NULL, 'N', NULL, NULL, 'N', NULL);

ALTER TABLE `grc_produto`
ADD COLUMN `insumo_horas_comp`  char(1) NOT NULL DEFAULT 'N' AFTER `idt_sgtec_tipo_servico`;

-- 01/08/2016

ALTER TABLE `grc_evento_participante_pagamento`
ADD COLUMN `data_vencimento`  date NULL AFTER `idt_evento_situacao_pagamento`;

CREATE TABLE `grc_plano_facil_ferramenta_pri` (
`idt`  int(10) UNSIGNED NOT NULL AUTO_INCREMENT ,
`idt_atendimento`  int(10) UNSIGNED NOT NULL ,
`idt_grc_plano_facil_ferramenta`  int(10) UNSIGNED NOT NULL ,
PRIMARY KEY (`idt`),
CONSTRAINT `fk_grc_plano_facil_ferramenta_pri_1` FOREIGN KEY (`idt_atendimento`) REFERENCES `grc_atendimento` (`idt`) ON DELETE RESTRICT ON UPDATE RESTRICT,
CONSTRAINT `fk_grc_plano_facil_ferramenta_pri_2` FOREIGN KEY (`idt_grc_plano_facil_ferramenta`) REFERENCES `grc_plano_facil_ferramenta` (`idt`) ON DELETE RESTRICT ON UPDATE RESTRICT,
UNIQUE INDEX `iu_grc_plano_facil_ferramenta_pri_1` (`idt_atendimento`, `idt_grc_plano_facil_ferramenta`) 
);

ALTER TABLE `grc_plano_facil_plano_acao`
DROP COLUMN `idt_quem`,
DROP COLUMN `quando_txt`,
DROP COLUMN `observacao`,
DROP COLUMN `atividade`,
ADD COLUMN `idt_atendimento`  int(10) UNSIGNED NULL AFTER `idt`;

ALTER TABLE `grc_plano_facil_plano_acao` ADD CONSTRAINT `FK_grc_plano_facil_plano_acao_2` FOREIGN KEY (`idt_atendimento`) REFERENCES `grc_atendimento` (`idt`) ON DELETE RESTRICT ON UPDATE RESTRICT;

UPDATE grc_plano_facil_plano_acao
SET grc_plano_facil_plano_acao.idt_atendimento = (
	SELECT
		grc_plano_facil.idt_atendimento
	FROM
		grc_plano_facil
	INNER JOIN grc_plano_facil_area ON grc_plano_facil_area.idt_plano_facil = grc_plano_facil.idt
	WHERE
		grc_plano_facil_area.idt = grc_plano_facil_plano_acao.idt_plano_facil_area
);

ALTER TABLE `grc_plano_facil_plano_acao` DROP FOREIGN KEY `FK_grc_plano_facil_plano_acao_1`;

ALTER TABLE `grc_plano_facil_plano_acao`
DROP COLUMN `idt_plano_facil_area`,
MODIFY COLUMN `idt_atendimento`  int(10) UNSIGNED NOT NULL AFTER `idt`,
DROP INDEX `iu_grc_plano_facil_plano_acao`;

-- 02/08/2016

ALTER TABLE `grc_plano_facil_produto`
DROP COLUMN `flag`,
DROP COLUMN `observacao`,
ADD COLUMN `idt_atendimento`  int(10) UNSIGNED NULL AFTER `idt`;

ALTER TABLE `grc_plano_facil_produto` ADD CONSTRAINT `FK_grc_plano_facil_produto_3` FOREIGN KEY (`idt_atendimento`) REFERENCES `grc_atendimento` (`idt`) ON DELETE RESTRICT ON UPDATE RESTRICT;

UPDATE grc_plano_facil_produto
SET grc_plano_facil_produto.idt_atendimento = (
	SELECT
		grc_plano_facil.idt_atendimento
	FROM
		grc_plano_facil
	INNER JOIN grc_plano_facil_area ON grc_plano_facil_area.idt_plano_facil = grc_plano_facil.idt
	WHERE
		grc_plano_facil_area.idt = grc_plano_facil_produto.idt_plano_facil_area
);

ALTER TABLE `grc_plano_facil_produto` DROP FOREIGN KEY `FK_grc_plano_facil_produto_1`;

ALTER TABLE `grc_plano_facil_produto`
DROP COLUMN `idt_plano_facil_area`,
MODIFY COLUMN `idt_atendimento`  int(10) UNSIGNED NOT NULL AFTER `idt`,
DROP INDEX `iu_grc_plano_facil_produto` ,
ADD UNIQUE INDEX `iu_grc_plano_facil_produto` (`idt_atendimento`, `idt_produto`) USING BTREE ;

-- homologa

-- 03/08/2016

delete from grc_atendimento_pendencia where idt_atendimento in (select idt from grc_atendimento where nan_num_visita = 2);
delete from grc_atendimento_tema where idt_atendimento in (select idt from grc_atendimento where nan_num_visita = 2);

delete from grc_atendimento_organizacao_cnae where idt_atendimento_organizacao in (select idt from grc_atendimento_organizacao where idt_atendimento in (select idt from grc_atendimento where nan_num_visita = 2));
delete from grc_atendimento_organizacao_tipo_informacao where idt in (select idt from grc_atendimento_organizacao where idt_atendimento in (select idt from grc_atendimento where nan_num_visita = 2));
delete from grc_atendimento_organizacao where idt_atendimento in (select idt from grc_atendimento where nan_num_visita = 2);

delete from grc_atendimento_pessoa_produto_interesse where idt_atendimento_pessoa in (select idt from grc_atendimento_pessoa where idt_atendimento in (select idt from grc_atendimento where nan_num_visita = 2));
delete from grc_atendimento_pessoa_tema_interesse where idt_atendimento_pessoa in (select idt from grc_atendimento_pessoa where idt_atendimento in (select idt from grc_atendimento where nan_num_visita = 2));
delete from grc_atendimento_pessoa_tipo_deficiencia where idt in (select idt from grc_atendimento_pessoa where idt_atendimento in (select idt from grc_atendimento where nan_num_visita = 2));
delete from grc_atendimento_pessoa_tipo_informacao where idt in (select idt from grc_atendimento_pessoa where idt_atendimento in (select idt from grc_atendimento where nan_num_visita = 2));
delete from grc_atendimento_pessoa_arquivo_interesse where idt_atendimento_pessoa in (select idt from grc_atendimento_pessoa where idt_atendimento in (select idt from grc_atendimento where nan_num_visita = 2));
delete from grc_atendimento_pessoa where idt_atendimento in (select idt from grc_atendimento where nan_num_visita = 2);

delete from grc_plano_facil_cresce;
delete from grc_plano_facil_ferramenta_pri;
delete from grc_plano_facil_ferramenta;
delete from grc_plano_facil_plano_acao;
delete from grc_plano_facil_produto;
delete from grc_plano_facil_area;
delete from grc_plano_facil;

alter table grc_plano_facil_area auto_increment = 1;
alter table grc_plano_facil_cresce auto_increment = 1;
alter table grc_plano_facil_ferramenta auto_increment = 1;
alter table grc_plano_facil_ferramenta_pri auto_increment = 1;
alter table grc_plano_facil_plano_acao auto_increment = 1;
alter table grc_plano_facil_produto auto_increment = 1;

delete from grc_atendimento where nan_num_visita = 2;

UPDATE grc_nan_grupo_atendimento
SET num_visita_atu = 1,
 dt_registro_2 = NULL,
 idt_pessoa_2 = NULL,
 status_2 = NULL,
 dt_registro_3 = NULL,
 idt_pessoa_3 = NULL,
 status_3 = NULL,
 pdf_devolutiva = NULL,
 pdf_plano_facil = NULL,
 pdf_protocolo = NULL,
 idt_aprovador_1 = NULL,
 data_aprovador_1 = NULL,
 idt_aprovador_2 = NULL,
 data_aprovador_2 = NULL,
 idt_aprovador_3 = NULL,
 data_aprovador_3 = NULL
WHERE
	num_visita_atu = 2;

-- producao
-- sala