<?php
$idCampo = 'idt';
$Tela = "a Estrutura Organizacional";
//Monta o vetor de Campo
$vetCampo['codigo']         = CriaVetTabela('C�digo');
$vetCampo['classificacao']  = CriaVetTabela('Classifica��o');
$vetCampo['descricao']      = CriaVetTabela('Descri��o');
//$vetTipo=Array();
//$vetTipo['E']='Estrat�gico';
//$vetTipo['T']='T�tico';
//$vetTipo['O']='Operacional';
//$vetCampo['tipo']           = CriaVetTabela('Tipo','descDominio',$vetTipo);
$vetCampo['scate_descricao']  = CriaVetTabela('Tipo');

$sql   = 'select ';
$sql  .= '   scaeso.*,  ';
$sql  .= '   scate.descricao as scate_descricao  ';
$sql  .= ' from sca_estrutura_organizacional as scaeso ';
$sql  .= ' inner join  sca_tipo_estrutura scate on scate.idt = scaeso.idt_sca_tipo_estrutura ';
$sql  .= ' order by scaeso.classificacao';



?>

