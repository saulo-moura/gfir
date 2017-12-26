<?php
$veio = "R";
if (file_exists('listar_conf/grc_evento_insumo.php')) {
  Require_Once('listar_conf/grc_evento_insumo.php');
}
else
{
  echo "Erro gere grc_evento_insumo.php ";
}

$idCampo          = 'idt';
$Tela             = "0 Insumo do Evento";
$TabelaPrinc      = "grc_evento_insumo";
$AliasPric        = "grc_Ei";
$Entidade         = "Receita do Evento";
$Entidade_p       = "Receitas do Evento";
//
$barra_inc_h      = "Incluir um Novo Registro de {$Entidade}";
$contlinfim       = "Existem #qt {$Entidade_p}.";

?>