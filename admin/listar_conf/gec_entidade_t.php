<?php
$veio = "T";
if (file_exists('listar_conf/gec_entidade.php')) {
  Require_Once('listar_conf/gec_entidade.php');
}
else
{
  echo "Erro gere gec_entidade.php ";
}

$idCampo          = 'idt';
$Tela             = "a Entidade";
$TabelaPrinc      = "gec_entidade";
$AliasPric        = "gec_en";
$Entidade         = "Entidade";
$Entidade_p       = "Entidades";
//
$barra_inc_h      = "Incluir um Novo Registro de {$Entidade}";
$contlinfim       = "Existem #qt {$Entidade_p}.";

?>