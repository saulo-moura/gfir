<?php
require_once '../configuracao.php';

$codsebrae = 26;

$sql = '';
$sql .= " select h.codrealizacao as codatendintegrado, pt.unidoperacional_siacweb as codunidop";
$sql .= ' from grc_atendimento a';
$sql .= ' inner join '.db_pir.'sca_organizacao_secao pt on pt.idt = a.idt_ponto_atendimento';
$sql .= ' inner join grc_atendimento_pessoa cl on cl.idt = a.idt_pessoa';
$sql .= ' inner join '.db_pir_siac.'historicorealizacoescliente h on h.codcliente = cl.codigo_siacweb';
$sql .= " and h.datahorainiciorealizacao = concat(a.data, ' ', a.hora_inicio_atendimento)";
$sql .= ' and h.codsebrae = '.null($codsebrae);
$sql .= ' where a.idt_evento is null';
$sql .= ' and h.codrealizacao is not null';
$rs = execsql($sql);

foreach ($rs->data as $row) {
    $sql = 'update AtendimentoIntegrado set CodUnidOp = '.null($row['codunidop']).' where Codsebrae = 26 and CodAtendIntegrado = '.null($row['codatendintegrado']);
    echo "{$sql};<br>";
}


echo '<br><br>FIM...';
