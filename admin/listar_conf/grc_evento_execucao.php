<?php
$veio = "E";



$barra_inc_ap = false;
$barra_alt_ap = true;
$barra_con_ap = true;
$barra_exc_ap = false;
$barra_fec_ap = true;


if (file_exists('listar_conf/grc_evento.php')) {
  Require_Once('listar_conf/grc_evento.php');
}
else
{
  echo "Erro gere grc_evento.php ";
}

$idCampo          = 'idt';
$Tela             = "o Evento";
$TabelaPrinc      = "grc_evento";
$AliasPric        = "grc_e";
$Entidade         = "Evento";
$Entidade_p       = "Eventos";
//
$barra_inc_h      = "Incluir um Novo Registro de {$Entidade}";
$contlinfim       = "Existem #qt {$Entidade_p}.";

?>