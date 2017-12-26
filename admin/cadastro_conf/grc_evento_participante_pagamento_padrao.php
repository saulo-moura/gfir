<?php
if ($veio == '') {
    $veio = $_GET['veio'];
}

$sql = '';
$sql .= ' select sum(valor_pagamento) as tot';
$sql .= ' from grc_evento_participante_pagamento';
$sql .= ' where idt_atendimento = ' . null($_GET['idCad']);
$sql .= ' and idt <> ' . null($_GET['id']);
$sql .= " and estornado <> 'S'";
$sql .= " and operacao = 'C'";
$sql .= ' and idt_aditivo_participante is null';
$rs = execsql($sql);
$vl_pago = $rs->data[0][0];

if ($vl_pago == '') {
    $vl_pago = 0;
}

if ($veio == 'SG') {
    $sql = '';
    $sql .= ' select ep.vl_tot_pagamento, e.nao_sincroniza_rm, e.contrapartida_sgtec, e.sgtec_modelo, e.vl_determinado, a.idt_evento';
    $sql .= ' from grc_evento_participante ep';
    $sql .= ' inner join grc_atendimento a on a.idt = ep.idt_atendimento';
    $sql .= ' inner join grc_evento e on a.idt_evento = e.idt';
    $sql .= ' where ep.idt_atendimento = ' . null($_GET['idCad']);
    $rs = execsql($sql);
    $rowp = $rs->data[0];

    if ($rowp['contrapartida_sgtec'] == '' && $rowp['sgtec_modelo'] == 'E') {
        if ($rowp['vl_determinado'] == 'S') {
            $sql = '';
            $sql .= ' select sum(ea.vl_total) as tot';
            $sql .= ' from grc_evento_dimensionamento ea';
            $sql .= ' where ea.idt_atendimento = ' . null($_GET['idCad']);
        } else {
            $sql = '';
            $sql .= ' select ei.custo_total';
            $sql .= ' from grc_evento_insumo ei';
            $sql .= ' where ei.idt_evento = ' . null($rowp['idt_evento']);
            $sql .= " and ei.codigo = '71001'";
        }

        $rs = execsql($sql);
        $vl_evento = $rs->data[0][0];
    } else {
        $vl_evento = $rowp['vl_tot_pagamento'];
    }

    $nao_sincroniza_rm = $rowp['nao_sincroniza_rm'];

    if ($vl_evento == '') {
        $vl_evento = 0;
    }

    $vl_apagar = $vl_evento - $vl_pago;

    if ($vl_apagar < 0) {
        $vl_apagar = 0;
    }

    if ($nao_sincroniza_rm == 'S') {
        $vl_apagar = '';
    } else {
        $vl_apagar = format_decimal($vl_apagar);
    }
} else {
    $vl_evento = desformat_decimal($_GET['valor_inscricao']);

    $sql = '';
    $sql .= ' select count(idt) as tot';
    $sql .= ' from grc_atendimento_pessoa';
    $sql .= ' where idt_atendimento = ' . null($_GET['idCad']);
    $sql .= " and evento_cortesia <> 'S'";
    $rs = execsql($sql);
    $vl_apagar = ($vl_evento * $rs->data[0][0]) - $vl_pago;

    $vl_apagar = format_decimal($vl_apagar);
}

$vetRow['grc_evento_participante_pagamento']['valor_apagar'] = $vl_apagar;

if ($acao == 'inc') {
    $vetRow['grc_evento_participante_pagamento']['idt_evento_situacao_pagamento'] = 1;
    $vetRow['grc_evento_participante_pagamento']['data_pagamento'] = trata_data(date('d/m/Y'));
    $vetRow['grc_evento_participante_pagamento']['valor_pagamento'] = $vl_apagar;
}