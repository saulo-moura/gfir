-- linux

-- 17/02/2016

ALTER TABLE `grc_evento_participante_pagamento`
ADD COLUMN `rm_idmov`  int(10) NULL AFTER `lojasiac_id`;

ALTER TABLE `grc_evento_forma_parcelamento`
CHANGE COLUMN `rm_codcfg` `rm_codcpg`  int(10) NOT NULL AFTER `valor_ini`;

update grc_evento set idt_ponto_atendimento = idt_ponto_atendimento_tela
where idt_ponto_atendimento_tela is not null;

-- 18/02/2016

ALTER TABLE `grc_evento_participante_pagamento`
ADD COLUMN `estornar_rm`  char(1) NOT NULL DEFAULT 'N' AFTER `estornado`;

-- homologa
-- producao
