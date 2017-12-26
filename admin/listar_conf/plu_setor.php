<?php
$idCampo = 'idt';
$Tela = "o Setor";


//Monta o vetor de Campo
$vetCampo['codigo'] = CriaVetTabela('Cуdigo');
$vetCampo['descricao'] = CriaVetTabela('Descriзгo');

$sql  = 'select * from plu_setor order by codigo';

?>