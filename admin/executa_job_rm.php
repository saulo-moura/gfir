<?php
Require_Once('configuracao.php');

$qtdErro = 0;
$SoapSebraeRM = new SoapSebraeRM();
set_time_limit(0);

//grc_insumo_elemento_custo
$vetInsumoElementoCusto = Array();

$sql = '';
$sql .= ' select idt, codigo';
$sql .= ' from grc_insumo_elemento_custo';
$rs = execsql($sql);

foreach ($rs->data as $row) {
    $vetInsumoElementoCusto[$row['codigo']] = $row['idt'];
}

//grc_insumo_unidade
$vetInsumoUnidade = Array();

$sql = '';
$sql .= ' select idt, codigo';
$sql .= ' from grc_insumo_unidade';
$rs = execsql($sql);

foreach ($rs->data as $row) {
    $vetInsumoUnidade[$row['codigo']] = $row['idt'];
}

//sca_organizacao_secao
$vetAreaSuporte = Array();

$sql = '';
$sql .= ' select idt, classificacao';
$sql .= ' from '.db_pir.'sca_organizacao_secao';
$rs = execsql($sql);

foreach ($rs->data as $row) {
    $vetAreaSuporte[preg_replace('/[^0-9]/i', '', $row['classificacao'])] = $row['idt'];
}

//grc_insumo
try {
    beginTransaction();

    $sql = "update grc_insumo set ativo = 'N' where idprd is not null";
    execsql($sql, false);

    $vetProd = Array();
    $tem_registro = true;
    $IDTini = 1;
    $IDTfim = 1000;

    do {
        $parametro = Array(
            'DataServerName' => 'EstPrdDataBR',
            'Filtro' => 'TPRODUTO.idprd between '.$IDTini.' and '.$IDTfim,
            'Contexto' => 'codcoligada=1',
        );
        $rsRM = $SoapSebraeRM->executa('ReadViewAuth', Array('TPRODUTO'), $parametro, true);
        $rsRM = $rsRM['TPRODUTO'];
                set_time_limit(0);

        if ($rsRM->rows == 0) {
            $parametro = Array(
                'DataServerName' => 'EstPrdDataBR',
                'Filtro' => 'TPRODUTO.idprd > '.$IDTfim,
                'Contexto' => 'codcoligada=1',
            );
            $rsTmp = $SoapSebraeRM->executa('ReadViewAuth', Array('TPRODUTO'), $parametro, true);
            $tem_registro = $rsTmp['TPRODUTO']->rows > 0;
                set_time_limit(0);
        } else {
            ForEach ($rsRM->data as $row) {
                $codigo = $row['codigoreduzido'];
                $descricao = $row['nomefantasia'];

                if ($row['inativo'] == 1) {
                    $ativo = 'N';
                } else {
                    $ativo = 'S';
                }

                $detalhe = $row['descricao'];
                $classificacao = $row['codigoprd'];
                $rm_classificacao = $row['codtb3fat'];
                $estocavel = 'N';
                
                if ($rm_classificacao == '001') {
                    $estocavel = 'S';
                }

                if ($row['codtb1fat'] == '') {
                    $idt_insumo_elemento_custo = '';
                } else {
                    $idt_insumo_elemento_custo = $vetInsumoElementoCusto[$row['codtb1fat']];
                    if ($idt_insumo_elemento_custo == '') {
                        $sql = 'insert into grc_insumo_elemento_custo (codigo, descricao, ativo) values (';
                        $sql .= aspa($row['codtb1fat']).', '.aspa($row['codtb1fat']).", 'S')";
                        execsql($sql, false);

                        $vetInsumoElementoCusto[$row['codtb1fat']] = lastInsertId();
                        $idt_insumo_elemento_custo = $vetInsumoElementoCusto[$row['codtb1fat']];
                    }
                }

                if ($row['codundcontrole'] == '') {
                    $idt_insumo_unidade = '';
                } else {
                    $idt_insumo_unidade = $vetInsumoUnidade[$row['codundcontrole']];
                    if ($idt_insumo_unidade == '') {
                        $sql = 'insert into grc_insumo_unidade (codigo, descricao, ativo) values (';
                        $sql .= aspa($row['codundcontrole']).', '.aspa($row['codundcontrole']).", 'S')";
                        execsql($sql, false);

                        $vetInsumoUnidade[$row['codundcontrole']] = lastInsertId();
                        $idt_insumo_unidade = $vetInsumoUnidade[$row['codundcontrole']];
                    }
                }

                $idt_area_suporte = $vetAreaSuporte[$row['sebrespdem']];

                $custo_unitario_real = $row['custounitario'];
                
                if ($custo_unitario_real == '') {
                    $custo_unitario_real = 0;
                }

                $vetTmp = explode('.', $row['codigoprd']);
                if (count($vetTmp) < 3) {
                    $nivel = 'N';
                } else {
                    $nivel = 'S';
                }

                $sinal = 'S';
                $codigo_rm = $row['codigoreduzido'];
                $tipo = $row['tipo'];
                $idprd = $row['idprd'];
                $sebprodcrm = $row['sebprodcrm'];

                $sql = '';
                $sql .= ' select idt';
                $sql .= ' from grc_insumo';
                $sql .= ' where idprd = '.null($row['idprd']);
                $rs = execsql($sql, false);

                if ($rs->rows == 0) {
                    $sql = 'insert into grc_insumo (codigo, descricao, ativo, detalhe, classificacao, idt_insumo_elemento_custo,';
                    $sql .= ' idt_insumo_unidade, custo_unitario_real, nivel, sinal, codigo_rm, tipo, idprd,';
                    $sql .= ' rm_classificacao, estocavel, idt_area_suporte, sebprodcrm';
                    $sql .= ') values (';
                    $sql .= aspa($codigo).', '.aspa($descricao).', '.aspa($ativo).', '.aspa($detalhe).', '.aspa($classificacao).', '.null($idt_insumo_elemento_custo).', ';
                    $sql .= null($idt_insumo_unidade).', '.null($custo_unitario_real).', '.aspa($nivel).', '.aspa($sinal).', '.aspa($codigo_rm).', '.aspa($tipo).', '.null($idprd).', ';
                    $sql .= aspa($rm_classificacao).', '.aspa($estocavel).', '.null($idt_area_suporte).', '.aspa($sebprodcrm).')';
                    execsql($sql, false);
                } else {
                    $sql = 'update grc_insumo set';
                    $sql .= ' codigo = '.aspa($codigo).',';
                    $sql .= ' descricao = '.aspa($descricao).',';
                    $sql .= ' ativo = '.aspa($ativo).',';
                    $sql .= ' detalhe = '.aspa($detalhe).',';
                    $sql .= ' classificacao = '.aspa($classificacao).',';
                    $sql .= ' idt_insumo_elemento_custo = '.null($idt_insumo_elemento_custo).',';
                    $sql .= ' idt_insumo_unidade = '.null($idt_insumo_unidade).',';
                    $sql .= ' custo_unitario_real = '.null($custo_unitario_real).',';
                    $sql .= ' idt_area_suporte = '.null($idt_area_suporte).',';
                    $sql .= ' nivel = '.aspa($nivel).',';
                    $sql .= ' sinal = '.aspa($sinal).',';
                    $sql .= ' codigo_rm = '.aspa($codigo_rm).',';
                    $sql .= ' rm_classificacao = '.aspa($rm_classificacao).',';
                    $sql .= ' estocavel = '.aspa($estocavel).',';
                    $sql .= ' sebprodcrm = '.aspa($sebprodcrm).',';
                    $sql .= ' tipo = '.aspa($tipo);
                    $sql .= ' where idt = '.null($rs->data[0][0]);
                    execsql($sql, false);

                    $sql = 'update grc_produto_insumo set';
                    $sql .= ' ativo = '.aspa($ativo).',';
                    $sql .= ' idt_insumo_unidade = '.null($idt_insumo_unidade).',';
                    $sql .= ' custo_unitario_real = '.null($custo_unitario_real).',';
                    $sql .= ' rm_classificacao = '.aspa($rm_classificacao).',';
                    $sql .= ' estocavel = '.aspa($estocavel).',';
                    $sql .= ' idt_area_suporte = '.null($idt_area_suporte);
                    $sql .= ' where idt_insumo = '.null($rs->data[0][0]);
                    $totAlt = execsql($sql, false);

                    if ($totAlt > 0) {
                        $sql = '';
                        $sql .= ' select distinct idt_produto';
                        $sql .= ' from grc_produto_insumo';
                        $sql .= ' where idt_insumo = '.null($rs->data[0][0]);
                        $rsPrd = execsql($sql);

                        foreach ($rsPrd->data as $rowPrd) {
                            $vetProd[$rowPrd['idt_produto']] = $rowPrd['idt_produto'];
                        }
                    }
                }
            }
        }

        $IDTini = $IDTfim + 1;
        $IDTfim = $IDTfim + 1000;
    } while ($tem_registro);
    
    foreach ($vetProd as $idt_produto) {
        CalcularInsumoProduto($idt_produto);
    }

    commit();
    $grava_log = true;
} catch (Exception $e) {
    $qtdErro++;

    if ($fim != 'N') {
        p($e);
    }

    rollBack();
    grava_erro_log('executa_job', $e, '');
}