SELECT a.protocolo, aoe.nome_completo as Agente, t.nome_completo as Tutor, p.nome as Responsavel, o.razao_social as Empresa
FROM grc_atendimento a
inner join grc_nan_grupo_atendimento g on g.idt = a.idt_grupo_atendimento
inner join plu_usuario aoe on aoe.id_usuario = a.idt_consultor
inner join plu_usuario t on t.id_usuario = a.idt_nan_tutor
inner join grc_atendimento_organizacao o on o.idt_atendimento = a.idt and o.representa = 'S'
inner join grc_atendimento_pessoa p on p.idt_atendimento = a.idt and p.tipo_relacao = 'L'
where a.idt_nan_ordem_pagamento is not NULL
and g.status_1 <> 'AP'
ORDER BY a.protocolo 

NAN com Empresa duplicada com pagamento

select * from grc_nan_grupo_atendimento
where (idt_organizacao in (
SELECT g.idt_organizacao
FROM grc_atendimento a
inner join grc_nan_grupo_atendimento g on g.idt = a.idt_grupo_atendimento
where a.idt_nan_ordem_pagamento is not NULL
and a.nan_num_visita = 1
GROUP BY g.idt_organizacao
HAVING count(g.idt) > 1
)
and status_1 <> 'CA'
) or idt_organizacao = 151934
order by idt_organizacao