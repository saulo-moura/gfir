<?php
$idCampo = 'idt';
$Tela = "o responsável";

$Filtro = Array();
$Filtro['rs'] = 'Texto';
$Filtro['id'] = 'idt';
$Filtro['js_tam'] = '0';
$Filtro['nome'] = 'Texto';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['descricao'] = $Filtro;

//Monta o vetor de Campo
$vetCampo['descricao'] = CriaVetTabela('Responsável');

$sql  = 'select * from responsavel order by descricao'
?>