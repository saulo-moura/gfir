<?php
$idCampo = 'idt';
$Tela = "a Situa��o do Projeto";


//Monta o vetor de Campo
$vetCampo['codigo'] = CriaVetTabela('C�digo');
$vetCampo['descricao'] = CriaVetTabela('Descri��o');
$vetCampo['imagem'] = CriaVetTabela('Imagem', 'arquivo', '200', 'situacao_empreendimento');

$sql  = 'select * from sca_projeto_situacao order by codigo';

?>