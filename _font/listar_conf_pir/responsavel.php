<?php
$idCampo = 'idt';
$Tela = "o respons�vel";

$Filtro = Array();
$Filtro['rs'] = 'Texto';
$Filtro['id'] = 'idt';
$Filtro['js_tam'] = '0';
$Filtro['nome'] = 'Texto';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['descricao'] = $Filtro;

//Monta o vetor de Campo
$vetCampo['descricao'] = CriaVetTabela('Respons�vel');

$sql  = 'select * from responsavel order by descricao'
?>