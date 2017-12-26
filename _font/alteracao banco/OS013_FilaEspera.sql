-- esmeraldo
-- desenvolve
-- jonata
-- producao

-- 21/09/2017

insert into plu_direito_funcao (id_direito, id_funcao, descricao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'grc_evento_participante_filaespera') as id_funcao,
'Se marcado, vai poder habilitar os registros da Fila de Espera para poder continuar a inscrição no evento' as descricao
from plu_direito where cod_direito in ('per');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df 
inner join plu_funcao f on df.id_funcao = f.id_funcao
inner join plu_direito d on df.id_direito = d.id_direito
where f.cod_funcao in ('grc_evento_participante_filaespera')
and d.cod_direito in ('per');

-- 22/09/2017

CREATE TABLE `grc_evento_participante_fe_log` (
  `idt` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idt_evento` int(10) unsigned NOT NULL,
  `idt_atendimento` int(10) unsigned NOT NULL,
  `dt_registro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `usuario_nome` varchar(120) CHARACTER SET latin1 NOT NULL,
  `usuario_login` varchar(120) CHARACTER SET latin1 NOT NULL,
  `situacao` char(2) NOT NULL,
  `dt_validade` datetime DEFAULT NULL,
  PRIMARY KEY (`idt`),
  KEY `fk_grc_evento_participante_fe_log_1` (`idt_evento`),
  KEY `fk_grc_evento_participante_fe_log_2` (`idt_atendimento`),
  CONSTRAINT `fk_grc_evento_participante_fe_log_1` FOREIGN KEY (`idt_evento`) REFERENCES `grc_evento` (`idt`),
  CONSTRAINT `fk_grc_evento_participante_fe_log_2` FOREIGN KEY (`idt_atendimento`) REFERENCES `grc_atendimento` (`idt`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `grc_evento_participante`
ADD COLUMN `fe_situacao`  char(2) NULL AFTER `idt_stand`,
ADD COLUMN `fe_dt_validade`  datetime NULL AFTER `fe_situacao`;

INSERT INTO `db_pir_grc`.`plu_config` (`variavel`, `descricao`, `valor`, `extra`, `js`) VALUES ('evento_fe_prazo_habilitado', 'Qtd. de Horas para a efeticação da inscrição quando é Habilitado a partir da Fila de Espera', 30, NULL, 'N');

-- homologacao
-- sala
