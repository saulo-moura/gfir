<?php
require_once '../configuracao.php';

ini_set('memory_limit', '2048M');

$conSIAC = conSIAC();

set_time_limit(0);

$sql = '';
$sql .= ' select e.idt, e.descricao, e.codigo, e.codigo_siacweb as cod_e, p.codigo_siacweb as cod_a';
$sql .= ' from '.db_pir_gec.'gec_entidade e';
$sql .= ' inner join '.db_pir_grc.'grc_atendimento_pessoa p on p.cpf = e.codigo';
$sql .= " where p.codigo_siacweb like '99%'";
$sql .= ' and e.codigo_siacweb <> p.codigo_siacweb';
$rs = execsql($sql, true, null, Array(), PDO::FETCH_ASSOC);
p($rs);
exit();

foreach ($rs->data as $row) {
    beginTransaction();
    
    echo 'rowGC: '.implode(' | ', $row).'<br>';

    $codigo = preg_replace('/[^0-9]/i', '', $row['codigo']);

    $sql = '';
    $sql .= ' select codparceiro, tipoparceiro, nomerazaosocial, cgccpf';
    $sql .= ' from parceiro';
    $sql .= ' where codparceiro = '.null($row['cod_e']);
    $rsPR = execsql($sql, true, $conSIAC, Array(), PDO::FETCH_ASSOC);

    foreach ($rsPR->data as $rowPR) {
        echo 'rowPR: '.implode(' | ', $rowPR).'<br>';

        if ($codigo != $rowPR['cgccpf']) {
            echo 'ERRO-----<br>';
            $update = true;

            $sql = '';
            $sql .= ' select codparceiro, tipoparceiro, nomerazaosocial, cgccpf';
            $sql .= ' from parceiro';
            $sql .= ' where cgccpf = '.null($codigo);
            $rsER = execsql($sql, true, $conSIAC, Array(), PDO::FETCH_ASSOC);

            foreach ($rsER->data as $rowER) {
                $update = false;
                echo 'rowER: '.implode(' | ', $rowER).'<br>';
            }

            $sql = '';
            $sql .= ' select codparceiro, tipoparceiro, nomerazaosocial, cgccpf';
            $sql .= ' from '.db_pir_siac.'parceiro';
            $sql .= ' where cgccpf = '.null($codigo);
            $rsCH = execsql($sql, true, null, Array(), PDO::FETCH_ASSOC);

            foreach ($rsCH->data as $rowCH) {
                $update = false;
                echo 'rowCH: '.implode(' | ', $rowCH).'<br>';
            }

            $sql = '';
            $sql .= ' select codparceiro, tipoparceiro, nomerazaosocial, cgccpf';
            $sql .= ' from '.db_pir_siac.'parceiro';
            $sql .= ' where codparceiro = '.null($row['cod_e']);
            $rsCHC = execsql($sql, true, null, Array(), PDO::FETCH_ASSOC);

            foreach ($rsCHC->data as $rowCHC) {
                echo 'rowCHC: '.implode(' | ', $rowCHC).'<br>';

                if ($rowPR['cgccpf'] != $rowCHC['cgccpf']) {
                    $update = false;
                }
            }

            if ($update) {
                $sql = 'update '.db_pir_gec.'gec_entidade set codigo_siacweb_old = codigo_siacweb where idt = '.null($row['idt']);
                execsql($sql);

                $sql = 'update '.db_pir_gec.'gec_entidade set codigo_siacweb = null where idt = '.null($row['idt']);
                execsql($sql);
            }

            echo 'FIM------<br>';
        } else {
            $novo = $row['cod_e'];
            $antigo = $row['cod_a'];

            $sql = '';
            $sql .= ' select codparceiro';
            $sql .= ' from '.db_pir_siac.'pessoaf';
            $sql .= ' where codparceiro = '.null($novo);
            $rst = execsql($sql, true, null, Array(), PDO::FETCH_ASSOC);

            if ($rst->rows == 0) {
                $sql = 'update '.db_pir_siac.'pessoaf set codparceiro = '.null($novo).' where codparceiro = '.null($antigo);
                execsql($sql);
            } else {
                $sql = 'delete from '.db_pir_siac.'pessoaf where codparceiro = '.null($antigo);
                execsql($sql);
            }

            $sql = '';
            $sql .= ' select codcontatopj';
            $sql .= ' from '.db_pir_siac.'contato';
            $sql .= ' where codcontatopf = '.null($antigo);
            $rsDel = execsql($sql);

            $vetDel = Array();
            foreach ($rsDel->data as $rowDel) {
                $vetDel[$rowDel['codcontatopj']] = $rowDel['codcontatopj'];
            }

            if (count($vetDel) > 0) {
                $sql = 'delete from '.db_pir_siac.'contato';
                $sql .= ' where codcontatopf = '.null($novo);
                $sql .= ' and codcontatopj in ('.implode(', ', $vetDel).')';
                execsql($sql);
            }

            $sql = 'update '.db_pir_siac.'contato set codcontatopf = '.null($novo).' where codcontatopf = '.null($antigo);
            execsql($sql);

            $sql = 'update '.db_pir_siac.'historicorealizacoescliente set codcliente = '.null($novo).' where codcliente = '.null($antigo);
            execsql($sql);

            $sql = 'update '.db_pir_grc.'grc_atendimento_pessoa set codigo_siacweb = '.null($novo).' where codigo_siacweb = '.aspa($antigo);
            execsql($sql);

            $sql = 'update '.db_pir_grc.'grc_entidade_pessoa set codigo_siacweb = '.null($novo).' where codigo_siacweb = '.aspa($antigo);
            execsql($sql);
        }

        echo '<br>';
    }

    echo '<br>';

    commit();
}

echo 'FIM...';
