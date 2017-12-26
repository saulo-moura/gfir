<?php
$idCampo = 'idt';
$Tela = "a Pergunta";
//Monta o vetor de Campo
$vetCampo['pergunta'] = CriaVetTabela('Pergunta');
$vetCampo['resposta'] = CriaVetTabela('Resposta');
$sql = 'select * from '.$pre_table.'duvida ';
$sql .= ' order by pergunta';
?>