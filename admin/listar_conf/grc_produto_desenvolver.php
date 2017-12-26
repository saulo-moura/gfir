<?php
$veio = "D";
if (file_exists('listar_conf/grc_produto.php')) {
  Require_Once('listar_conf/grc_produto.php');
}
else
{
  echo " Gere grc_produto.php ";
}
$idCampo          = 'idt';
$Tela             = "o Produto";
$TabelaPrinc      = "grc_produto";
$AliasPric        = "grc_p";
$Entidade         = "Produto";
$Entidade_p       = "Produtos";
//
$barra_inc_h      = "Incluir um Novo Registro de {$Entidade}";
$contlinfim       = "Existem #qt {$Entidade_p}.";
?>