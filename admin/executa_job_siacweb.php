<?php
Require_Once('configuracao.php');

$conSIAC = conSIAC();
$qtdErro = 0;

$vetTabela = Array(
    'tbpaipratif' => 'rowguid',
    'tbpaiacao' => 'rowguid',
    'unidoperacional' => 'rowguid',
    'produto' => 'rowguid',
    'relporteconstjur' => 'rowguid',
    'porte' => 'rowguid',
    //'bairro' => 'codbairro',
);

try {
    foreach ($vetTabela as $tabela => $pk) {
        $tabela_mysql = db_pir_siac.$tabela;

        beginTransaction();

        set_time_limit(0);

        switch ($tabela_mysql) {
            case 'tbpaipratif':
            case 'tbpaiacao':
                $sql = "update ".$tabela_mysql." set ativo = 'N'";
                execsql($sql, false);
                break;
				
            case 'bairro':
                $sql = "update ".$tabela_mysql." set situacao = 0";
                execsql($sql, false);
                break;
        }

        $sql = '';
        $sql .= ' select *';
        $sql .= ' from '.$tabela;
        $rsSIAC = execsql($sql, false, $conSIAC);

        ForEach ($rsSIAC->data as $row) {
            $vetCampo = Array();

            foreach ($rsSIAC->info['name'] as $campo) {
                $vetCampo[$campo] = aspa($row[$campo]);
            }

            $sql = '';
            $sql .= " select {$pk} as pk";
            $sql .= ' from '.$tabela_mysql;
            $sql .= " where {$pk} = ".aspa($row[$pk]);
            $rs = execsql($sql, false);

            if ($rs->rows == 0) {
                $sql = 'insert into '.$tabela_mysql.' ('.implode(', ', array_keys($vetCampo)).') values ('.implode(', ', $vetCampo).')';
                execsql($sql, false);
            } else {
                $tmp = Array();
                foreach ($vetCampo as $key => $value) {
                    $tmp[] = $key.' = '.$value;
                }

                $sql = 'update '.$tabela_mysql.' set '.implode(', ', $tmp)." where {$pk} = ".aspa($rs->data[0][0]);
                execsql($sql, false);
            }
        }

        commit();
        $grava_log = true;
    }
} catch (Exception $e) {
    $qtdErro++;
    
    if ($fim != 'N') {
        p($e);
    }

    rollBack();
    grava_erro_log('executa_job', $e, '');
}