<?php
$idCampo = 'idt';
$Tela = "a Siyua��o do Empreendimento";


//Monta o vetor de Campo
$vetCampo['codigo'] = CriaVetTabela('C�digo');
$vetCampo['descricao'] = CriaVetTabela('Descri��o');
$vetCampo['imagem'] = CriaVetTabela('Imagem', 'arquivo', '200', 'situacao_empreendimento');

$sql  = 'select * from situacao_empreendimento order by codigo';

?>