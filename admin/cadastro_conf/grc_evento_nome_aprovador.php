<?php
$sql = '';
$sql .= ' select u.nome_completo, ap.dt_update';
$sql .= ' from grc_atendimento_pendencia ap';
$sql .= ' inner join plu_usuario u  on u.id_usuario = ap.idt_usuario_update';
$sql .= ' where ap.idt_evento = '.null($idt_evento);
$sql .= ' and ap.idt_evento_situacao_para = 14';
$sql .= ' order by ap.dt_update desc limit 1';
$rsAP = execsql($sql);

if ($rsAP->rows > 0) {
    $rowAP = $rsAP->data[0];

    echo 'Evento aprovado por:<br />';
    echo '<div class="nome">'.$rowAP['nome_completo'].'</div>';

    $dt = trata_data($rowAP['dt_update']);
    $dt = explode(' ', $dt);
    echo '<div class="dt">Solicitação enviada à CAD em <span>'.$dt[0].'</span> às <span>'.$dt[1].'</span></div>';
}

$sql = '';
$sql .= ' select u.nome_completo, ap.dt_update';
$sql .= ' from grc_atendimento_pendencia ap';
$sql .= ' inner join plu_usuario u  on u.id_usuario = ap.idt_usuario_update';
$sql .= ' where ap.idt_evento = '.null($idt_evento);
$sql .= ' and ap.idt_evento_situacao_para = 21';
$sql .= ' order by ap.dt_update desc limit 1';
$rsAP = execsql($sql);

if ($rsAP->rows > 0) {
    $rowAP = $rsAP->data[0];

    echo '<br />Cancelamento aprovado por:<br />';
    echo '<div class="nome">'.$rowAP['nome_completo'].'</div>';

    $dt = trata_data($rowAP['dt_update']);
    $dt = explode(' ', $dt);
    echo '<div class="dt">Cancelamento realizado em <span>'.$dt[0].'</span> às <span>'.$dt[1].'</span></div>';
}