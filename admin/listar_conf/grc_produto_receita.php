<?php
$veio = "R";
if (file_exists('listar_conf/grc_produto_insumo.php')) {
  Require_Once('listar_conf/grc_produto_insumo.php');
}
else
{
  echo "Erro gere grc_produto_insumo.php ";
}

$idCampo          = 'idt';
$Tela             = "0 Insumo do Produto";
$TabelaPrinc      = "grc_produto_insumo";
$AliasPric        = "grc_pi";
$Entidade         = "Receita do Produto";
$Entidade_p       = "Receitas do Produto";
//
$barra_inc_h      = "Incluir um Novo Registro de {$Entidade}";
$contlinfim       = "Existem #qt {$Entidade_p}.";

?>