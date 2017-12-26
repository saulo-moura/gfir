<?php
$idCampo = 'idt';
$Tela = "a Ajuda ao Login";
//Monta o vetor de Campo
$vetCampo['pergunta'] = CriaVetTabela('Pergunta');
$vetCampo['resposta'] = CriaVetTabela('Resposta');
$sql = 'select * from '.$pre_table.'plu_ajudalogin ';
$sql .= ' order by ordem';
?>