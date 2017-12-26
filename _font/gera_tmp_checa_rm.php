<?php
require_once '../configuracao.php';

ini_set('memory_limit', '-1');
set_time_limit(0);

$SoapSebraeRM_CS = new SoapSebraeRMGeral('wsConsultaSQL');

$sql = 'truncate table tmp_checa_rm';
execsql($sql);

$sql = '';
$sql .= ' select a.idt_evento, a.idt as idt_atendimento, a.protocolo';
$sql .= ' from grc_atendimento a';
$sql .= ' inner join grc_evento_participante_pagamento ep on ep.idt_atendimento = a.idt';
$sql .= ' group by a.idt_evento, a.idt, a.protocolo';
$rs = execsqlNomeCol($sql);

foreach ($rs->data as $row) {
    $metodo = 'RealizarConsultaSQLAuth';
    $Z = Array('Resultado');
    $parametro = Array(
        'codSentenca' => 'ws_pir_retornaid',
        'codColigada' => '1',
        'codAplicacao' => 'T',
        'parameters' => 'CHAVEORIGEM=CRM-'.$row['protocolo'],
    );
    $rsRM = $SoapSebraeRM_CS->executa($metodo, $Z, $parametro, true);

    if (is_array($rsRM)) {
        foreach ($rsRM['Resultado']->data as $rowRM) {
            $sql = '';
            $sql .= ' select idt';
            $sql .= ' from grc_evento_participante_pagamento';
            $sql .= ' where rm_idmov = '.null($rowRM['idmov']);
            $rst = execsql($sql);
            $idt_evento_participante_pagamento = $rst->data[0][0];

            $sql = 'insert into tmp_checa_rm (idt_evento, idt_atendimento, idt_evento_participante_pagamento, idmov, status) values (';
            $sql .= null($row['idt_evento']).', '.null($row['idt_atendimento']).', '.null($idt_evento_participante_pagamento).', ';
            $sql .= null($rowRM['idmov']).', '.aspa($rowRM['status']).')';
            execsql($sql);
        }
    }
}

echo 'FIM...';
