<?php
$idCampo = 'id_config';
$Tela = "a configura��o do site";

$vetCampo['classificacao'] = CriaVetTabela('Classifica��o');
$vetCampo['descricao']     = CriaVetTabela('Configura��o');
$vetCampo['valor, extra']  = CriaVetTabela('Valor', 'str, descDominio', Array('', $vetIcoGrid));

$sql  = "select * from plu_config ";

switch ($veio) {
    case 'PV':
        $sql .= " where classificacao = 'POL�TICA DE DESCONTO'";
        break;

    default:
        $sql .= " where classificacao is null or classificacao <> 'POL�TICA DE DESCONTO'";
        break;
}

$sql .= "order by classificacao, descricao";