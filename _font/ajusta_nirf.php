<?php
require_once '../configuracao.php';

$vetTabela = Array(
    db_pir_gec.'gec_entidade_organizacao',
    db_pir_grc.'grc_atendimento_organizacao',
    db_pir_grc.'grc_entidade_organizacao',
);

beginTransaction();

$sql = 'update '.db_pir_siac.'pessoaj set nirf = null where nirf = 0';
execsql($sql);

foreach ($vetTabela as $tabela) {
    $sql = "update ".$tabela." set nirf = null where nirf = '0'";
    execsql($sql);

    $sql = '';
    $sql .= ' select idt, nirf';
    $sql .= ' from '.$tabela;
    $sql .= ' where nirf is not null';
    $rs = execsql($sql);

    foreach ($rs->data as $row) {
        $nirf = $row['nirf'];

        if ($nirf != '') {
            $nirf = str_pad(preg_replace('/[^0-9]/i', '', $nirf), 8, '0', STR_PAD_LEFT);

            if ($nirf == 0) {
                $nirf = '';
            } else {
                $nirf = substr($nirf, 0, 1).'.'.substr($nirf, 1, 3).'.'.substr($nirf, 4, 3).'-'.substr($nirf, 7);
            }
        }


        $sql = 'update '.$tabela.' set nirf = '.aspa($nirf);
        $sql .= ' where idt = '.null($row['idt']);
        execsql($sql);
    }
}

commit();

echo 'FIM...';
