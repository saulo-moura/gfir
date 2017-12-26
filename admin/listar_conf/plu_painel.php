<?php
$idCampo = 'idt';
$Tela = "o painel";

//Monta o vetor de Campo
$vetCampo['classificacao'] = CriaVetTabela('Classificaзгo');
$vetCampo['descricao'] = CriaVetTabela('Descriзгo');
$vetCampo['codigo'] = CriaVetTabela('Cуdigo');

$sql = 'select * from plu_painel order by classificacao';