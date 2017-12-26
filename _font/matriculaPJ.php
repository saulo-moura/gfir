<?php
require_once 'configuracao.php';

$conSIAC = conSIAC();

beginTransaction($conSIAC);

$sql = '';
$sql .= ' select e.idt, e.codigo_siacweb as codevento, t.cpf, t.cnpj';
$sql .= ' from tmpevento t';
$sql .= ' inner join grc_evento e on e.codigo = t.codigo';
$rs = execsql($sql);

$vetEvento = Array();

foreach ($rs->data as $row) {
    $vetEvento[$row['idt']] = $row['idt'];

    $codevento = $row['codevento'];

    $sql = '';
    $sql .= " select codparceiro";
    $sql .= ' from parceiro with(nolock)';
    $sql .= ' where cgccpf = '.null($row['cpf']);
    $rss = execsql($sql, true, $conSIAC);
    $codpessoapf = $rss->data[0][0];

    $sql = '';
    $sql .= " select codparceiro";
    $sql .= ' from parceiro with(nolock)';
    $sql .= ' where cgccpf = '.null($row['cnpj']);
    $rss = execsql($sql, true, $conSIAC);
    $codpessoapj = $rss->data[0][0];

    $sql = '';
    $sql .= " select codpessoapj";
    $sql .= ' from participante with(nolock)';
    $sql .= ' where codevento = '.null($codevento);
    $sql .= ' and codpessoapf = '.null($codpessoapf);
    $sql .= ' and codpessoapj is null';
    $rss = execsql($sql, true, $conSIAC);

    if ($rss->rows == 1) {
        $sql = 'update participante set codpessoapj = '.null($codpessoapj);
        $sql .= ' where codevento = '.null($codevento);
        $sql .= ' and codpessoapf = '.null($codpessoapf);
        $sql .= ' and codpessoapj is null';
        //execsql($sql, true, $conSIAC);
        echo "'".$sql."'<br />";
    }
}

commit($conSIAC);

if (count($vetEvento) > 0) {
    $sql = "update grc_evento set sincroniza_loja = 'S'";
    $sql .= ' where idt in ('.implode(', ', $vetEvento).')';
    //execsql($sql);
    echo "'".$sql."'<br />";
}

echo 'FIM...';
