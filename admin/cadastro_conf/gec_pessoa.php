<?php
$veio = "P";
if (file_exists('cadastro_conf/gec_entidade.php')) {
  Require_Once('cadastro_conf/gec_entidade.php');
}
else
{
  echo "Erro gere gec_entidade.php ";
}


?>