<?php
$idCampo = 'idt';
$Tela = "o painel";

//Monta o vetor de Campo
$vetCampo['classificacao'] = CriaVetTabela('Classifica��o');
$vetCampo['descricao'] = CriaVetTabela('Descri��o');
$vetCampo['codigo'] = CriaVetTabela('C�digo');

$sql = 'select * from plu_painel order by classificacao';