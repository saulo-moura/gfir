<?php
$idCampo = 'idt';
$Tela = "a Ajuda ao Login";
//Monta o vetor de Campo
$vetCampo['pergunta'] = CriaVetTabela('Pergunta');
$vetCampo['resposta'] = CriaVetTabela('Resposta');
$sql = 'select * from '.$pre_table.'ajudalogin_adm ';
$sql .= ' order by ordem';
?>