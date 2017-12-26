<?php
$idCampo = 'id_config';
$Tela = "a configuração do site";

$vetCampo['classificacao'] = CriaVetTabela('Classificação');
$vetCampo['descricao']     = CriaVetTabela('Configuração');
$vetCampo['valor, extra']  = CriaVetTabela('Valor', 'str, descDominio', Array('', $vetIcoGrid));

$sql  = "select * from plu_config ";

switch ($veio) {
    case 'PV':
        $sql .= " where classificacao = 'POLÍTICA DE DESCONTO'";
        break;

    default:
        $sql .= " where classificacao is null or classificacao <> 'POLÍTICA DE DESCONTO'";
        break;
}

$sql .= "order by classificacao, descricao";