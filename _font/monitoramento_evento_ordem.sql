select distinct ev.codigo, ev.descricao, ev.dt_previsao_inicial, pen.dt_update as dt_aprovado, ev.cred_necessita_credenciado, ev.cred_rodizio_auto, ev.cred_credenciado_sgc, ev.cred_contratacao_cont, ord.idt as idt_ordem, ord.codigo as codigo_ordem, pd.tipo_ordem
from db_pir_grc.grc_evento ev
left outer join db_pir_gec.gec_contratacao_credenciado_ordem ord on ord.idt_evento = ev.idt
left outer join db_pir_grc.grc_atendimento_pendencia pen on pen.idt_evento = ev.idt and pen.idt_evento_situacao_para = 14
left outer join db_pir_gec.gec_programa pd on pd.idt = ev.idt_programa
where (pen.dt_update is null or pen.dt_update >= '2016-04-02')
and ev.idt_evento_situacao in (14, 16)
and ord.idt is null
and (
  (ev.cred_necessita_credenciado = 'S' and ev.cred_rodizio_auto = 'S')
  or (
    ev.cred_necessita_credenciado = 'S' and ev.cred_rodizio_auto = 'N'
    and ev.cred_credenciado_sgc = 'S' and ev.cred_contratacao_cont = 'N'
  )
)
order by pen.dt_update