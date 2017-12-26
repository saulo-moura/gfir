<?php
$idCampo = 'idt';
$Tela = "o Setor para Contato (Fale Conosco)";
//Monta o vetor de Campo
$vetCampo['descricao'] = CriaVetTabela('Setor');
$vetCampo['email'] = CriaVetTabela('E-mail');
$vetCampo['usu_responsavel'] = CriaVetTabela('Responsável');

$sql = 'select co.*, usu.nome_completo as usu_responsavel  from '.$pre_table.'contato co ';
$sql .= ' inner join usuario usu on usu.id_usuario = co.idt_responsavel';
$sql .= ' order by descricao';
?>