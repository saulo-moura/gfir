<?php
$sql = '';
$sql .= ' select sum(valor_pagamento) as tot';
$sql .= ' from grc_atendimento_evento_pagamento';
$sql .= ' where idt_atendimento_evento = ' . null($_GET['idCad']);
$sql .= ' and idt <> ' . null($_GET['id']);
$sql .= " and estornado <> 'S'";
$rs = execsql($sql);
$vl_pago = $rs->data[0][0];

if ($vl_pago == '') {
    $vl_pago = 0;
}

$sql = '';
$sql .= ' select resumo_pag, resumo_tot, contrapartida_sgtec';
$sql .= ' from grc_atendimento_evento';
$sql .= ' where idt = ' . null($_GET['idCad']);
$rs = execsql($sql);
$rowp = $rs->data[0];

if ($rowp['contrapartida_sgtec'] == '') {
    $vl_evento = $rowp['resumo_tot'];
} else {
    $vl_evento = $rowp['resumo_pag'];
}

if ($vl_evento == '') {
    $vl_evento = 0;
}

$vl_apagar = $vl_evento - $vl_pago;

if ($vl_apagar < 0) {
    $vl_apagar = 0;
}

$vl_apagar = format_decimal($vl_apagar);

$vetRow['grc_atendimento_evento_pagamento']['valor_apagar'] = $vl_apagar;

if ($acao == 'inc') {
    $vetRow['grc_atendimento_evento_pagamento']['idt_evento_situacao_pagamento'] = 1;
    $vetRow['grc_atendimento_evento_pagamento']['data_pagamento'] = trata_data(date('d/m/Y'));
    $vetRow['grc_atendimento_evento_pagamento']['valor_pagamento'] = $vl_apagar;
}