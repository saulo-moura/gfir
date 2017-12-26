<?php
require_once '../configuracao.php';

$vetTabela = Array();

$tabela = db_pir_gec.'gec_entidade_organizacao';
$sql = '';
$sql .= ' select e.codigo as cnpj, e.descricao as nome, eo.nirf';
$sql .= ' from '.$tabela.' eo';
$sql .= ' inner join '.db_pir_gec.'gec_entidade e on e.idt = eo.idt_entidade';
$sql .= ' where eo.nirf is not null';
$sql .= ' order by e.codigo';
$vetTabela[$tabela] = $sql;

$tabela = db_pir_grc.'grc_atendimento_organizacao';
$sql = '';
$sql .= ' select cnpj, razao_social as nome, nirf';
$sql .= ' from '.$tabela;
$sql .= ' where nirf is not null';
$sql .= ' order by cnpj';
$vetTabela[$tabela] = $sql;

foreach ($vetTabela as $tabela => $sql) {
    echo "<br />Tabela: '".$tabela."'<br /><br />";

    $rs = execsql($sql);

    foreach ($rs->data as $row) {
        if (!ValidaNirf($row['nirf'])) {
            echo $row['cnpj'].' :: '.$row['nome'].' :: '.$row['nirf'].'<br>';
        }
    }
}

echo '<br><br>FIM...';
