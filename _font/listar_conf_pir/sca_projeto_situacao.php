<?php
$idCampo = 'idt';
$Tela = "a Situaзгo do Projeto";


//Monta o vetor de Campo
$vetCampo['codigo'] = CriaVetTabela('Cуdigo');
$vetCampo['descricao'] = CriaVetTabela('Descriзгo');
$vetCampo['imagem'] = CriaVetTabela('Imagem', 'arquivo', '200', 'situacao_empreendimento');

$sql  = 'select * from sca_projeto_situacao order by codigo';

?>