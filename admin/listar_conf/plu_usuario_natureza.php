<?php
$idCampo = 'idt';
$Tela = "a Natureza do Usuário";

$TabelaPrinc      = "plu_usuario_natureza";
$AliasPric        = "plu_un";
$Entidade         = "Natureza do Usuário";
$Entidade_p       = "Naturezas do Usuário";

$barra_inc_h      = "Incluir um Novo Registro de {$Entidade}";
$contlinfim       = "Existem #qt {$Entidade_p}.";


//Monta o vetor de Campo
$vetCampo['codigo']    = CriaVetTabela('Código');
$vetCampo['descricao'] = CriaVetTabela('Descrição');
//
$sql   = 'select ';
$sql  .= '   plu_un.* ';
$sql  .= ' from plu_usuario_natureza as plu_un ';
$sql  .= ' order by plu_un.codigo';
?>
