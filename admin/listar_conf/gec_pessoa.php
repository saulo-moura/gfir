<?php
$veio = "P";
if (file_exists('listar_conf/gec_entidade.php')) {
  Require_Once('listar_conf/gec_entidade.php');
}
else
{
  echo "Erro gere gec_entidade.php ";
}

$idCampo          = 'idt';
$Tela             = "a Pessoa";
$TabelaPrinc      = "gec_entidade";
$AliasPric        = "gec_en";
$Entidade         = "Pessoa";
$Entidade_p       = "Pessoas";
//
$barra_inc_h      = "Incluir um Novo Registro de {$Entidade}";
$contlinfim       = "Existem #qt {$Entidade_p}.";

?>