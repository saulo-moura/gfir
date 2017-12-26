<?php
$veio = "R";
if (file_exists('cadastro_conf/grc_produto_insumo.php')) {
  Require_Once('cadastro_conf/grc_produto_insumo.php');
}
else
{
  echo "Erro gere grc_produto_insumo.php ";
}


?>