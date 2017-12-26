-- 028373325-00 nan 2 visita

-- esmeraldo

-- 08/08/2016

INSERT INTO `grc_evento_situacao` (`codigo`, `descricao`) VALUES ('27', 'PRÉ-APROVADO');

-- 09/08/2016

ALTER TABLE `grc_evento_participante`
ADD COLUMN `vl_tot_pagamento`  decimal(15,2) NULL AFTER `idt_stand`;

ALTER TABLE `grc_evento_participante_pagamento`
DROP COLUMN `percent_valor`;

-- producao
-- homologa
-- sala