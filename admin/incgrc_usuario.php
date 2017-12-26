<?php

   $acao = "alt";
   $_GET['id']   = $_SESSION[CS]['g_id_usuario'];
   $_GET['acao'] = $acao;
   $prefixo = 'cadastro';
   $menu    = 'grc_usuario';
    if ($_SESSION[CS]['g_id_usuario'] == '') {
        echo "<div align='center' class='Msg'>Favor entrar no sistema outra vez!</div>";
    } else {
        $Require_Once = "cadastro.php";
        if (file_exists($Require_Once)) {
            Require_Once($Require_Once);
        } else {
//       echo "<script type='text/javascript'>self.location = 'index.php';</script>";
//       exit();
        }
    }

?>