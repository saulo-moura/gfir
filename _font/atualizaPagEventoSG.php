<?php
Require_Once('../configuracao.php');

XatualizaPagEventoSG(10879);

function XatualizaPagEventoSG($idt_evento, $trata_erro = true) {
    $sql = '';
    $sql .= ' select ei.custo_total, e.idt_instrumento, i.contrapartida_sgtec';
    $sql .= ' from '.db_pir_grc.'grc_evento_insumo ei';
    $sql .= ' inner join '.db_pir_grc.'grc_evento e on e.idt = ei.idt_evento';
    $sql .= ' inner join '.db_pir_grc.'grc_atendimento_instrumento i on i.idt = e.idt_instrumento';
    $sql .= ' where ei.idt_evento = '.null($idt_evento);
    $sql .= " and ei.codigo = '71001'";
    $rs = execsql($sql, $trata_erro);
    $row = $rs->data[0];
	p($sql);
	p($row);
    $cotacao = $row['custo_total'];
    $idt_instrumento = $row['idt_instrumento'];
    $contrapartida_sgtec = $row['contrapartida_sgtec'];

    if ($cotacao == '') {
        $cotacao = 0;
    }

    if ($contrapartida_sgtec == '') {
        $contrapartida_sgtec = 0;
    }

    $sql = '';
    $sql .= ' select count(idt) as qtd';
    $sql .= ' from '.db_pir_grc.'grc_atendimento';
    $sql .= ' where idt_evento = '.null($idt_evento);
    $rs = execsql($sql, $trata_erro);
    $quantidade_participante = $rs->data[0][0];

    if ($quantidade_participante == '') {
        $quantidade_participante = 0;
    }

    $sql = '';
    $sql .= ' select sum(ea.carga_horaria) as tot';
    $sql .= ' from '.db_pir_grc.'grc_evento_agenda ea';
    $sql .= ' left outer join '.db_pir_grc.'grc_evento_participante ep on ep.idt_atendimento = ea.idt_atendimento';
    $sql .= ' where ea.idt_evento = '.null($idt_evento);
    $sql .= " and (ep.contrato is null or ep.contrato <> 'IC')";
    $rs = execsql($sql, $trata_erro);
    $carga_horaria = $rs->data[0][0];

    if ($carga_horaria == '') {
        $carga_horaria = 0;
    }

    if ($carga_horaria == 0) {
        $valor_hora = 0;
    } else {
        $valor_hora = $cotacao / $carga_horaria;
    }

    $sql = '';
    $sql .= ' select a.idt as idt_atendimento, ep.idt as idt_ep';
    $sql .= ' from '.db_pir_grc.'grc_atendimento a';
    $sql .= ' left outer join '.db_pir_grc.'grc_evento_participante ep on ep.idt_atendimento = a.idt';
    $sql .= ' where a.idt_evento = '.null($idt_evento);
    $sql .= " and (ep.contrato is null or ep.contrato <> 'IC')";
    $rs = execsql($sql, $trata_erro);

    foreach ($rs->data as $row) {
        if ($idt_instrumento == 2) {
            $sql = '';
            $sql .= ' select sum(carga_horaria) as tot';
            $sql .= ' from '.db_pir_grc.'grc_evento_agenda';
            $sql .= ' where idt_atendimento = '.null($row['idt_atendimento']);
            $rs = execsql($sql, $trata_erro);
            $carga_horaria = $rs->data[0][0];

            if ($carga_horaria == '') {
                $carga_horaria = 0;
            }

            $sql = '';
            $sql .= ' select p.contrapartida_sgtec';
            $sql .= ' from '.db_pir_grc.'grc_atendimento_organizacao o';
            $sql .= ' left outer join '.db_pir_gec.'gec_organizacao_porte p on p.idt = o.idt_porte';
            $sql .= ' where idt_atendimento = '.null($row['idt_atendimento']);
            $rs = execsql($sql, $trata_erro);
            $contrapartida_sgtec = $rs->data[0][0];

            if ($contrapartida_sgtec == '') {
                $contrapartida_sgtec = 0;
            }

            $vl_evento = round($valor_hora * $carga_horaria * $contrapartida_sgtec / 100, 2);
        } else {
            if ($quantidade_participante == 0) {
                $vl_evento = 0;
            } else {
                $vl_evento = round($cotacao * $contrapartida_sgtec / 100 / $quantidade_participante, 2);
            }
        }

        if ($row['idt_ep'] == '') {
            $sql = 'insert into '.db_pir_grc.'grc_evento_participante (idt_atendimento, contrato, vl_tot_pagamento) values (';
            $sql .= null($row['idt_atendimento']).", 'G', ".null($vl_evento).')';
        } else {
            $sql = 'update '.db_pir_grc.'grc_evento_participante set vl_tot_pagamento = '.null($vl_evento);
            $sql .= ' where idt = '.null($row['idt_ep']);
        }

		p($sql);
        execsql($sql, $trata_erro);
    }

    $sql = '';
    $sql .= ' select count(x.idt_atendimento) as qtd, avg(x.pag) as media';
    $sql .= ' from (';
    $sql .= ' select p.idt_atendimento, sum(p.valor_pagamento) as pag';
    $sql .= ' from '.db_pir_grc.'grc_evento_participante_pagamento p';
    $sql .= ' inner join '.db_pir_grc.'grc_atendimento a on a.idt = p.idt_atendimento';
    $sql .= ' left outer join '.db_pir_grc.'grc_evento_participante ep on ep.idt_atendimento = p.idt_atendimento';
    $sql .= ' where a.idt_evento = '.null($idt_evento);
    $sql .= " and p.estornado <> 'S'";
    $sql .= " and (ep.contrato is null or ep.contrato <> 'IC')";
    $sql .= ' group by p.idt_atendimento';
    $sql .= ' ) x';
    $rs = execsql($sql, $trata_erro);
    $rowu = $rs->data[0];

    $tot = $rowu['qtd'] * $rowu['media'];

    $sql = 'update '.db_pir_grc.'grc_evento set valor_inscricao = '.null($rowu['media']);
    $sql .= ', quantidade_participante = '.null($rowu['qtd']);
    $sql .= ', previsao_receita = '.null($tot);
    $sql .= ', valor_hora = '.null($valor_hora);
    $sql .= ', custo_tot_consultoria = '.null($cotacao);
    $sql .= " where idt = ".null($idt_evento);
    execsql($sql, $trata_erro);

    $sql = 'update '.db_pir_grc.'grc_evento_agenda set valor_hora = '.null($valor_hora);
    $sql .= " where idt_evento = ".null($idt_evento);
    execsql($sql, $trata_erro);

    $sql = 'update '.db_pir_grc.'grc_evento_insumo set';
    $sql .= ' quantidade = 1, ';
    $sql .= ' quantidade_evento = '.null($rowu['qtd']).', ';
    $sql .= ' custo_unitario_real = '.null($rowu['media']).', ';
    $sql .= ' rtotal_minimo = '.null($tot).', ';
    $sql .= ' rtotal_maximo = '.null($tot).', ';
    $sql .= ' receita_total = '.null($tot);
    $sql .= ' where idt_evento = '.null($idt_evento);
    $sql .= " and codigo = 'evento_insc'";
    execsql($sql, $trata_erro);
}

