<?php
$sql = '';
$sql .= ' select sum(valor_pagamento) as tot';
$sql .= ' from grc_evento_participante_pagamento';
$sql .= ' where idt_aditivo_participante = ' . null($_GET['idt_aditivo_participante']);
$sql .= ' and idt <> ' . null($_GET['id']);
$sql .= " and estornado <> 'S'";
$sql .= " and operacao = 'C'";
$rs = execsql($sql);
$vl_pago = $rs->data[0][0];

if ($vl_pago == '') {
    $vl_pago = 0;
}

$vl_evento = desformat_decimal($_GET['valor_inscricao']);

$vl_apagar = $vl_evento  - $vl_pago;

$vl_apagar = format_decimal($vl_apagar);

$vetRow['grc_evento_participante_pagamento']['valor_apagar'] = $vl_apagar;

if ($acao == 'inc') {
    $vetRow['grc_evento_participante_pagamento']['idt_evento_situacao_pagamento'] = 1;
    $vetRow['grc_evento_participante_pagamento']['data_pagamento'] = trata_data(date('d/m/Y'));
    $vetRow['grc_evento_participante_pagamento']['valor_pagamento'] = $vl_apagar;
}