<?php
require_once '../configuracao.php';

$SoapSebraeRM_DS = new SoapSebraeRMGeral('wsDataServer');

$IDPGTO = 1;

$funcao = 'ReadRecordAuth';

$parametro = Array(
    'DataServerName' => 'FinDadosPgtoDataBR',
    'PrimaryKey' => '1;1;017941;' . $IDPGTO,
    'Contexto' => 'codcoligada=1;codcfo=017941;CODCOLCFO=1;IDPGTO=' . $IDPGTO,
);

$Z = Array('FDadosPgto');

$rsRM = $SoapSebraeRM_DS->executa($funcao, $Z, $parametro, true);
$rowRM = $rsRM['FDadosPgto']->data[0];
p($rowRM);

$rsRM = $SoapSebraeRM_DS->definicao('FinDadosPgtoDataBR', true);
p($rsRM);


echo 'FIM...';
