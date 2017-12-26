<?php
$veio = "O";
if (file_exists('listar_conf/grc_entidade.php')) {
  Require_Once('listar_conf/grc_entidade.php');
}
else
{
  echo " gere gec_entidade.php ";
}
$idCampo          = 'idt';
$Tela             = "a Organizacao";
$TabelaPrinc      = "gec_entidade";
$AliasPric        = "gec_en";
$Entidade         = "Organizacao";
$Entidade_p       = "Organizações";
//
$barra_inc_h      = "Incluir um Novo Registro de {$Entidade}";
$contlinfim       = "Existem #qt {$Entidade_p}.";
?>