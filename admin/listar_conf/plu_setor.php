<?php
$idCampo = 'idt';
$Tela = "o Setor";


//Monta o vetor de Campo
$vetCampo['codigo'] = CriaVetTabela('C�digo');
$vetCampo['descricao'] = CriaVetTabela('Descri��o');

$sql  = 'select * from plu_setor order by codigo';

?>