-- esmeraldo
-- producao
-- homologa
-- jonata
-- trinamento

-- 03/05/2017

ALTER TABLE `grc_atendimento_instrumento`
ADD COLUMN `ordem_composto`  int(10) UNSIGNED NULL DEFAULT 100 AFTER `idt_produto_tipo`;

update grc_atendimento_instrumento set ordem_composto = 1000 where idt in (2,39,15);

CREATE TABLE `grc_evento_agenda_prev` (
  `idt` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idt_evento` int(10) unsigned NOT NULL,
  `descricao` varchar(45) NOT NULL,
  `data` date NOT NULL,
  `qtd` decimal(15,2) NOT NULL,
  PRIMARY KEY (`idt`),
  KEY `fk_grc_evento_agenda_prev_1` (`idt_evento`) USING BTREE,
  CONSTRAINT `fk_grc_evento_agenda_prev_1` FOREIGN KEY (`idt_evento`) REFERENCES `grc_evento` (`idt`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `grc_evento_agenda_prev`
MODIFY COLUMN `qtd`  decimal(15,2) NULL AFTER `data`;

insert into grc_evento_natureza_pagamento_instrumento (idt_evento_natureza_pagamento, idt_atendimento_instrumento)
select p.idt as idt_evento_natureza_pagamento, i.idt as idt_atendimento_instrumento
from grc_atendimento_instrumento i, grc_evento_natureza_pagamento p
where i.idt in (52)
and p.idt <> 8
and p.desconto = 'N'
order by p.idt, i.idt;

-- desenvolve
-- sala
