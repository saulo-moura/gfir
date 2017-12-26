<?php
$idCampo = 'idt';
$Tela = "a Siyuaзгo do Empreendimento";


//Monta o vetor de Campo
$vetCampo['codigo'] = CriaVetTabela('Cуdigo');
$vetCampo['descricao'] = CriaVetTabela('Descriзгo');
$vetCampo['imagem'] = CriaVetTabela('Imagem', 'arquivo', '200', 'situacao_empreendimento');

$sql  = 'select * from situacao_empreendimento order by codigo';

?>