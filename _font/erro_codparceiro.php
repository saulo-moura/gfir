<?php
require_once '../configuracao.php';

ini_set('memory_limit', '2048M');

$conSIAC = conSIAC();

set_time_limit(0);

$totSIAC = 0;
$totErro = 0;
$vetCod = Array();

$sql = '';
$sql .= ' select idt, codigo_siacweb, tipo_entidade, descricao, codigo';
$sql .= ' from '.db_pir_gec.'gec_entidade';
$sql .= ' where codigo_siacweb is not null';
$sql .= ' and codigo_siacweb in (261573540, 261573082, 372000267, 26983969, 26693247, 26867449, 261557739, 26558980, 261561303, 306874693, 261500580, 261259981, 261569772, 261569716, 261498806, 261570815, 261571171, 261571260, 261571488, 26329934, 261571685, 26976116, 261571844, 26555874, 26840471, 261577991, 26750312, 261575224, 261575232, 261575241, 261575378, 261548486, 26208669, 261463621, 261443145, 261581237, 261581477, 261453762, 261453761, 261458458, 261459720, 261582302, 261582804, 261583089, 261583095)';
$rsGC = execsql($sql, true, null, Array(), PDO::FETCH_ASSOC);

foreach ($rsGC->data as $rowGC) {
    $codigo = preg_replace('/[^0-9]/i', '', $rowGC['codigo']);
    $update = false;

    $sql = '';
    $sql .= ' select codparceiro, tipoparceiro, nomerazaosocial, cgccpf, rowguid';
    $sql .= ' from parceiro';
    $sql .= ' where codparceiro = '.null($rowGC['codigo_siacweb']);
    $rsPR = execsql($sql, true, $conSIAC, Array(), PDO::FETCH_ASSOC);

    foreach ($rsPR->data as $rowPR) {
        $totSIAC++;

        if ($rowPR['cgccpf'] == '') {
            $validacao = mb_strtolower($rowGC['descricao']) != mb_strtolower($rowPR['nomerazaosocial']);
        } else {
            $validacao = $codigo != $rowPR['cgccpf'];
        }

        if ($validacao) {
            $update = true;
            $vetCod[$rowPR['codparceiro']] = $rowPR['codparceiro'];
            $totErro++;

            echo 'rowGC: '.implode(' | ', $rowGC).'<br>';
            echo 'rowPR: '.implode(' | ', $rowPR).'<br>';

            $sql = '';
            $sql .= ' select codparceiro, tipoparceiro, nomerazaosocial, cgccpf, rowguid';
            $sql .= ' from '.db_pir_siac.'parceiro';
            $sql .= ' where cgccpf = '.null($codigo);
            $rsCH = execsql($sql, true, null, Array(), PDO::FETCH_ASSOC);

            foreach ($rsCH->data as $rowCH) {
                echo 'rowCH: '.implode(' | ', $rowCH).'<br>';
            }

            if ($rowGC['tipo_entidade'] == 'O') {
                $sql = '';
                $sql .= ' select idt, codigo_siacweb_e, razao_social, cnpj';
                $sql .= ' from '.db_pir_grc.'grc_atendimento_organizacao';
                $sql .= ' where cnpj = '.null($rowGC['codigo']);
                $rsO = execsql($sql, true, null, Array(), PDO::FETCH_ASSOC);

                foreach ($rsO->data as $rowO) {
                    echo 'rowO: '.implode(' | ', $rowO).'<br>';
                }
            } else {
                $sql = '';
                $sql .= ' select idt, codigo_siacweb, nome, cpf';
                $sql .= ' from '.db_pir_grc.'grc_atendimento_pessoa';
                $sql .= ' where cpf = '.null($rowGC['codigo']);
                $rsP = execsql($sql, true, null, Array(), PDO::FETCH_ASSOC);

                foreach ($rsP->data as $rowP) {
                    echo 'rowP: '.implode(' | ', $rowP).'<br>';
                }
            }

            $sql = '';
            $sql .= ' select codparceiro, tipoparceiro, nomerazaosocial, cgccpf, rowguid';
            $sql .= ' from '.db_pir_siac.'parceiro';
            $sql .= ' where cgccpf = '.null($rowPR['cgccpf']);
            $rsCHP = execsql($sql, true, null, Array(), PDO::FETCH_ASSOC);

            foreach ($rsCHP->data as $rowCHP) {
                echo 'rowCHP: '.implode(' | ', $rowCHP).'<br>';
            }

            if ($rowPR['tipoparceiro'] == 'J') {
                $sql = '';
                $sql .= ' select idt, codigo_siacweb_e, razao_social, cnpj';
                $sql .= ' from '.db_pir_grc.'grc_atendimento_organizacao';
                $sql .= ' where cnpj = '.aspa(FormataCNPJ($rowPR['cgccpf']));
                $rsO = execsql($sql, true, null, Array(), PDO::FETCH_ASSOC);

                foreach ($rsO->data as $rowO) {
                    echo 'rowOP: '.implode(' | ', $rowO).'<br>';
                }
            } else {
                $sql = '';
                $sql .= ' select idt, codigo_siacweb, nome, cpf';
                $sql .= ' from '.db_pir_grc.'grc_atendimento_pessoa';
                $sql .= ' where cpf = '.aspa(FormataCPF12($rowPR['cgccpf']));
                $rsP = execsql($sql, true, null, Array(), PDO::FETCH_ASSOC);

                foreach ($rsP->data as $rowP) {
                    echo 'rowPP: '.implode(' | ', $rowP).'<br>';
                }
            }

            echo '<br>';
        }
    }

    $update = false;

    if ($update) {
        beginTransaction();

        switch ($rowGC['codigo_siacweb']) {
            case '261546378':
            case '261546665':
            case '261549243':
                //Muda codigo_siacweb para temporario do GEC e Cache
                $novo = '99'.geraAutoNum(db_pir_grc, 'codparceiro_99', 12);
                $antigo = $rowGC['codigo_siacweb'];

                $sql = 'update '.db_pir_gec.'gec_entidade set codigo_siacweb_old = codigo_siacweb where idt = '.null($rowGC['idt']);
                execsql($sql);

                $sql = 'update '.db_pir_gec.'gec_entidade set codigo_siacweb = '.null($novo).' where idt = '.null($rowGC['idt']);
                execsql($sql);

                //SIAC
                $sql = 'update '.db_pir_siac.'parceiro set codparceiro = '.null($novo).' where codparceiro = '.null($antigo);
                execsql($sql, false);

                $sql = 'update '.db_pir_siac.'comunicacao set codparceiro = '.null($novo).' where codparceiro = '.null($antigo);
                execsql($sql, false);

                $sql = 'update '.db_pir_siac.'endereco set codparceiro = '.null($novo).' where codparceiro = '.null($antigo);
                execsql($sql, false);

                $sql = 'update '.db_pir_siac.'ativeconpj set codparceiro = '.null($novo).' where codparceiro = '.null($antigo);
                execsql($sql, false);

                if ($rowGC['tipo_entidade'] == 'P') {
                    $sql = 'update '.db_pir_siac.'pessoaf set codparceiro = '.null($novo).' where codparceiro = '.null($antigo);
                    execsql($sql, false);

                    $sql = '';
                    $sql .= ' select codcontatopj';
                    $sql .= ' from '.db_pir_siac.'contato';
                    $sql .= ' where codcontatopf = '.null($antigo);
                    $rsDel = execsql($sql, false);

                    $vetDel = Array();
                    foreach ($rsDel->data as $rowDel) {
                        $vetDel[$rowDel['codcontatopj']] = $rowDel['codcontatopj'];
                    }

                    if (count($vetDel) > 0) {
                        $sql = 'delete from '.db_pir_siac.'contato';
                        $sql .= ' where codcontatopf = '.null($novo);
                        $sql .= ' and codcontatopj in ('.implode(', ', $vetDel).')';
                        execsql($sql, false);
                    }

                    $sql = 'update '.db_pir_siac.'contato set codcontatopf = '.null($novo).' where codcontatopf = '.null($antigo);
                    execsql($sql, false);

                    $sql = 'update '.db_pir_siac.'historicorealizacoescliente set codcliente = '.null($novo).' where codcliente = '.null($antigo);
                    execsql($sql, false);
                } else {
                    $sql = 'update '.db_pir_siac.'pessoaj set codparceiro = '.null($novo).' where codparceiro = '.null($antigo);
                    execsql($sql, false);

                    $sql = '';
                    $sql .= ' select codcontatopf';
                    $sql .= ' from '.db_pir_siac.'contato';
                    $sql .= ' where codcontatopj = '.null($antigo);
                    $rsDel = execsql($sql, false);

                    $vetDel = Array();
                    foreach ($rsDel->data as $rowDel) {
                        $vetDel[$rowDel['codcontatopf']] = $rowDel['codcontatopf'];
                    }

                    if (count($vetDel) > 0) {
                        $sql = 'delete from '.db_pir_siac.'contato';
                        $sql .= ' where codcontatopj = '.null($novo);
                        $sql .= ' and codcontatopf in ('.implode(', ', $vetDel).')';
                        execsql($sql, false);
                    }

                    $sql = 'update '.db_pir_siac.'contato set codcontatopj = '.null($novo).' where codcontatopj = '.null($antigo);
                    execsql($sql, false);

                    $sql = 'update '.db_pir_siac.'historicorealizacoescliente set codempreedimento = '.null($novo).' where codempreedimento = '.null($antigo);
                    execsql($sql, false);
                }
                break;

            case '261553401':
                //Pega o codigo_siacweb do Cache e coloca no GEC
                $sql = '';
                $sql .= ' select codparceiro';
                $sql .= ' from '.db_pir_siac.'parceiro';
                $sql .= ' where cgccpf = '.null($codigo);
                $rsTT = execsql($sql, true);

                $sql = 'update '.db_pir_gec.'gec_entidade set codigo_siacweb_old = codigo_siacweb where idt = '.null($rowGC['idt']);
                execsql($sql);

                $sql = 'update '.db_pir_gec.'gec_entidade set codigo_siacweb = '.null($rsTT->data[0][0]).' where idt = '.null($rowGC['idt']);
                execsql($sql);
                break;

            default:
                //Apaga codigo_siacweb do GEC
                $sql = 'update '.db_pir_gec.'gec_entidade set codigo_siacweb_old = codigo_siacweb where idt = '.null($rowGC['idt']);
                execsql($sql);

                $sql = 'update '.db_pir_gec.'gec_entidade set codigo_siacweb = null where idt = '.null($rowGC['idt']);
                execsql($sql);
                break;
        }

        commit();
    }
}

echo '<br><br>totSIAC = '.$totSIAC.'<br>';
echo 'totErro = '.$totErro.'<br>';

echo '<br>and codigo_siacweb in ('.implode(', ', $vetCod).')<br>';

echo 'FIM...';
