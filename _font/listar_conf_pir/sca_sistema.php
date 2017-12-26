<?php
$idCampo = 'idt';
$Tela = "o Sistema";
//Monta o vetor de Campo
$goCad[] = vetCad('idt', 'Ambiente', 'empreendimento');
$goCad[] = vetCad('idt', 'Responsбveis', 'sca_sistema_responsavel');


$vetCampo['imagem']    = CriaVetTabela('Logomarca', 'arquivo', '25', 'sca_sistema');
$vetCampo['codigo']    = CriaVetTabela('Cуdigo');
$vetCampo['sigla']     = CriaVetTabela('Sigla');
$vetCampo['descricao'] = CriaVetTabela('Descriзгo');
$sql   = 'select ';
$sql  .= '   scasi.idt,  ';
$sql  .= '   scasi.*  ';
$sql  .= ' from sca_sistema as scasi ';
$sql  .= ' order by codigo';
?>