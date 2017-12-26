<?php
require_once '../configuracao.php';

$tipodb1 = 'mysql';
$host1 = 'localhost';
$bd_user1 = 'root'; // Login do Banco
$password1 = 'root'; // Senha de acesso ao Banco
$host1 = $tipodb1.':host='.$host1.';dbname=db_pir_grc;port=3306'; // Endereço do Banco de Dados

$conMY = new_pdo($host1, $bd_user1, $password1, $tipodb1);

$sql = '';
$sql .= ' SELECT *';
$sql .= ' FROM db_pir.dbo.tmpajuste';
$sql .= " WHERE feito = 'N'";
$rs = execsql($sql);

$sql = 'select idt into tab_tmp from plu_ajuda';
//$con->exec($sql);

foreach ($rs->data as $row) {
    beginTransaction();

    set_time_limit(0);

    $sql = '';
    $sql .= ' SELECT COLUMN_NAME as coluna';
    $sql .= ' FROM information_schema.COLUMNS';
    $sql .= " WHERE TABLE_SCHEMA = ".aspa($row['banco']);
    $sql .= " and TABLE_NAME = ".aspa($row['tabela']);
    $sql .= ' order by ORDINAL_POSITION';
    $rsc = execsql($sql, true, $conMY);

    $vetCampo = Array();

    foreach ($rsc->data as $rowc) {
        $vetCampo[] = $rowc['coluna'];
    }

    $tmp = array_shift($vetCampo);
    array_push($vetCampo, $tmp);
    $lstCampo = implode(', ', $vetCampo);

    $tabela = '['.$row['banco'].'].[dbo].['.$row['tabela'].']';

    $sql = 'drop table tab_tmp';
    execsql($sql);

    $sql = 'select '.$lstCampo.' into tab_tmp from '.$tabela;
    $con->exec($sql);

    $sql = 'TRUNCATE TABLE '.$tabela;
    execsql($sql);

    $sql = '';
    $sql .= ' select CONSTRAINT_NAME ';
    $sql .= ' from ['.$row['banco'].'].information_schema.table_constraints ';
    $sql .= " where constraint_type = 'Primary Key'";
    $sql .= ' and TABLE_NAME = '.aspa($row['tabela']);
    $rst = execsql($sql);

    if ($rst->rows > 0) {
        $sql = 'ALTER TABLE '.$tabela.' DROP CONSTRAINT ['.$rst->data[0][0].']';
        execsql($sql);
    }

    $sql = 'ALTER TABLE '.$tabela.' DROP COLUMN ['.$row['coluna'].']';
    execsql($sql);

    $sql = 'ALTER TABLE '.$tabela.' ADD ['.$row['coluna'].'] int NOT NULL IDENTITY(1,1)';
    execsql($sql);

    $sql = 'ALTER TABLE '.$tabela.' ADD CONSTRAINT [PK_'.$row['tabela'].'_'.$row['coluna'].'] PRIMARY KEY (['.$row['coluna'].'])';
    execsql($sql);

    $sql = 'SET IDENTITY_INSERT '.$tabela.' ON';
    $con->exec($sql);

    $sql = 'insert into '.$tabela.' ('.$lstCampo.') select '.$lstCampo.' from tab_tmp';
    $con->exec($sql);

    $sql = 'SET IDENTITY_INSERT '.$tabela.' OFF';
    $con->exec($sql);

    $sql = "update db_pir.dbo.tmpajuste set feito = 'S' where idt = ".null($row['idt']);
    execsql($sql);

    commit();

    echo $tabela.".[".$row['coluna']."]<br />";
}

$sql = '';
$sql .= ' SELECT TABLE_SCHEMA as banco, TABLE_NAME as tabela, COLUMN_NAME as coluna, COLUMN_DEFAULT AS padrao';
$sql .= ' FROM information_schema.COLUMNS';
$sql .= " where TABLE_SCHEMA IN ('db_pir','db_pir_bia','db_pir_gec','db_pir_gfi','db_pir_grc','db_pir_siac_ba','db_sebrae_pfo')";
$sql .= ' and COLUMN_DEFAULT is not null';
$rs = execsql($sql, true, $conMY);

foreach ($rs->data as $row) {
    try {
        set_time_limit(0);

        $tabela = '['.$row['banco'].'].[dbo].['.$row['tabela'].']';

        $sql = "ALTER TABLE ".$tabela." ADD DEFAULT ".aspa($row['padrao'])." FOR [".$row['coluna']."]";
        execsql($sql, false);
        echo "'".$sql."'<br />";
    } catch (Exception $e) {
    }
}

echo 'FIM...';
