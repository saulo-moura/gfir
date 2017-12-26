-- Vai para EDUARDO BENJAMIN ANDRADE

-- GRC
update db_pir_grc.grc_evento set idt_gestor_evento = 88 where idt in (75,76);
update db_pir_grc.grc_atendimento_pendencia set idt_gestor_local = 88, idt_responsavel_solucao = 88 where ativo = 'S' and idt_evento in (75,76);

-- GEC
update db_pir_gec.gec_contratacao_credenciado_ordem set idt_responsavel = 107 where idt_evento in (75,76);


-- Todos

-- GRC
update db_pir_grc.grc_evento set idt_gestor_evento = 590 where idt_gestor_evento = 589;
update db_pir_grc.grc_atendimento_pendencia set idt_gestor_local = 590, idt_responsavel_solucao = 590 where ativo = 'S' and idt_responsavel_solucao = 589;

-- GEC
update db_pir_gec.gec_contratacao_credenciado_ordem set idt_responsavel = 608 where idt_responsavel = 607;
