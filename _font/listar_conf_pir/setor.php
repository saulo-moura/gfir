<?php
$idCampo = 'idt';
$Tela = "o Setor";


//Monta o vetor de Campo
$vetCampo['codigo'] = CriaVetTabela('Cуdigo');
$vetCampo['descricao'] = CriaVetTabela('Descriзгo');

$sql  = 'select * from setor order by codigo';

?>