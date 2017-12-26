<?php
require_once '../configuracao.php';

$conSIAC = conSIAC();
set_time_limit(0);

beginTransaction();

$sql = '';
$sql .= ' select idt, codigo_siacweb, codigo, descricao';
$sql .= ' from grc_evento';
$sql .= ' where idt_evento_situacao = 19';
$sql .= ' and codigo_siacweb is not null';
$rs = execsql($sql);

foreach ($rs->data as $row) {
    //situacao = 1 Consolidado

    $sql = '';
    $sql .= " select situacao";
    $sql .= ' from evento with(nolock)';
    $sql .= ' where codevento = '.null($row['codigo_siacweb']);
    $rss = execsql($sql, true, $conSIAC);
    
    if ($rss->data[0][0] == '1') {
        $sql = 'update grc_evento set idt_evento_situacao_ant = 19, idt_evento_situacao = 20';
        $sql .= ' where idt = '.null($row['idt']);
        //echo "'".$sql."'<br />";
        execsql($sql);

        $des_registro = 'Ajuste da situação do ['.$row['codigo'].'] '.$row['descricao'].' para '.$vetSituacao[20];

        $vetLogDetalhe = Array();
        $vetLogDetalhe['idt_evento_situacao']['campo_desc'] = 'Status';
        $vetLogDetalhe['idt_evento_situacao']['vl_ant'] = 19;
        $vetLogDetalhe['idt_evento_situacao']['desc_ant'] = $vetSituacao[19];
        $vetLogDetalhe['idt_evento_situacao']['vl_atu'] = 20;
        $vetLogDetalhe['idt_evento_situacao']['desc_atu'] = $vetSituacao[20];

        grava_log_sis('grc_evento', 'A', $row['idt'], $des_registro, 'Ajuste da situação do Evento', '', $vetLogDetalhe);
    }
}

commit();

echo 'FIM...';
