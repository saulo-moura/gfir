<?php
$idCampo = 'idt';
$Tela = "a Natureza do Usu�rio";

$TabelaPrinc      = "plu_usuario_natureza";
$AliasPric        = "plu_un";
$Entidade         = "Natureza do Usu�rio";
$Entidade_p       = "Naturezas do Usu�rio";

$barra_inc_h      = "Incluir um Novo Registro de {$Entidade}";
$contlinfim       = "Existem #qt {$Entidade_p}.";


//Monta o vetor de Campo
$vetCampo['codigo']    = CriaVetTabela('C�digo');
$vetCampo['descricao'] = CriaVetTabela('Descri��o');
//
$sql   = 'select ';
$sql  .= '   plu_un.* ';
$sql  .= ' from plu_usuario_natureza as plu_un ';
$sql  .= ' order by plu_un.codigo';
?>
