<?php
$idCampo = 'idt';
$Tela = "o Setor para Contato (Fale Conosco)";

$TabelaPrinc      = "plu_contato";
$AliasPric        = "plu_co";
$Entidade         = "Contato";
$Entidade_p       = "Contatos";

$barra_inc_h      = "Incluir um Novo Registro de {$Entidade}";
$contlinfim       = "Existem #qt {$Entidade_p}.";

//Monta o vetor de Campo
$vetCampo['descricao'] = CriaVetTabela('Setor');
$vetCampo['email'] = CriaVetTabela('E-mail');
$vetCampo['usu_responsavel'] = CriaVetTabela('Responsável');

$sql = 'select co.*, usu.nome_completo as usu_responsavel  from '.$pre_table.'plu_contato co ';
$sql .= ' inner join plu_usuario usu on usu.id_usuario = co.idt_responsavel';
$sql .= ' order by descricao';
?>