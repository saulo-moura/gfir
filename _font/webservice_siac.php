<?php
require_once '../configuracao.php';

ini_set('default_socket_timeout', 6000);

$SebraeSIACcad = new SebraeSIAC('SiacWEB_CadastroAtenderWS', 'cad');

/*
$parametro = Array(
	'CodParceiro' => 0,
	'CNPJ' => '23952185000130',
);

$SebareResult = $SebraeSIACcad->executa('Util_Rec_DadosEmpreendimentoParceiro', $parametro, 'Table1', true);
p($SebareResult);
 * 
 */

$parametro = Array(
    'en_parametros' => '26339900100|1| |RIDALVA ALVES PINTO|RIDALVA ALVES PINTO|010151202|1|4|2|031962| |12|ROD TEIXEIRA DE FREITAS - MEDEIROS NETO|45960000|73999742161| |31|5|831|208746|KM 53 / KM 53| |CCIR06623003090| | |1|leop_nonato@hotmail.com|0|0|',
);

$metodo = 'Trans_Ins_CadastroCompletoPJ';

$SebareResult = $SebraeSIACcad->executa($metodo, $parametro, 'Table', true, array('Table1'));
p($SebareResult);

$rowResult = $SebareResult->data[0];
p($rowResult);

var_dump($rowResult['error'] === '0' && $rowResult['description'] == '');