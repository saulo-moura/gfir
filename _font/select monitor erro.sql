SELECT date_format(data, '%d/%m/%Y') as data, num_erro, count(idt) as tot
FROM `db_pir_grc`.`plu_erro_log`
where mensagem = 'SQLSTATE[40001]: Serialization failure: 1213 Deadlock found when trying to get lock; try restarting transaction'
group by date_format(data, '%d/%m/%Y'), num_erro
order by date_format(data, '%Y%m%d'), num_erro;

SELECT *
FROM `db_pir_grc`.`plu_erro_log`
where mensagem = 'SQLSTATE[40001]: Serialization failure: 1213 Deadlock found when trying to get lock; try restarting transaction'
and date_format(data, '%d/%m/%Y') = '02/05/2016'
order by num_erro, data;


Atendimento:

select a.data as dt_atendimento, pa.descricao as und_escritorio, count(a.idt) as qtd_atendimento, i.descricao as instrumento, p.descricao as porte
from db_pir_grc.grc_atendimento a
inner join db_pir.sca_organizacao_secao pa on pa.idt = a.idt_ponto_atendimento
inner join db_pir_grc.grc_atendimento_instrumento i on i.idt = a.idt_instrumento
left outer join db_pir_grc.grc_atendimento_organizacao o on o.idt_atendimento = a.idt and o.representa = 'S' and o.desvincular = 'N'
left outer join db_pir_gec.gec_organizacao_porte p on p.idt = o.idt_porte
where a.idt_evento is null
and a.situacao in ('Finalizado', 'Finalizado em Alteração')
and a.data > '2016-04-01'
group by a.data, pa.descricao, i.descricao, p.descricao
order by a.data, pa.descricao, i.descricao, p.descricao;

Evento:

select e.codigo as cod_evento, e.dt_previsao_inicial as dt_inicio, e.dt_previsao_fim as dt_final, pa.descricao as und_escritorio, count(ep.idt) as qtd_inscricao, p.descricao as porte, m.descricao as canal
from db_pir_grc.grc_evento e
inner join db_pir.sca_organizacao_secao pa on pa.idt = e.idt_ponto_atendimento
inner join db_pir_grc.grc_atendimento a on a.idt_evento = e.idt
inner join db_pir_grc.grc_evento_participante ep on ep.idt_atendimento = a.idt
left outer join db_pir_grc.grc_atendimento_pessoa pe on pe.idt_atendimento = a.idt
left outer join db_pir_grc.grc_atendimento_organizacao o on o.idt_atendimento = a.idt
left outer join db_pir_gec.gec_organizacao_porte p on p.idt = o.idt_porte
left outer join db_pir_gec.gec_meio_informacao m on m.idt = ep.idt_midia
where ep.contrato <> 'IC'
and e.dt_previsao_inicial > '2016-04-01'
group by e.codigo, e.dt_previsao_inicial, e.dt_previsao_fim, pa.descricao, p.descricao, m.descricao
order by e.codigo, e.dt_previsao_inicial, e.dt_previsao_fim, pa.descricao, p.descricao, m.descricao;