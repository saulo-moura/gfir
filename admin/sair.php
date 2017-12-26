<?php



Require_Once('configuracao.php');

$tabela="usuario";
$id_lo =$_SESSION[CS]['g_id_usuario'];
$desc_log="Efetuado Logout para ".$_SESSION[CS]['g_login']. ' de '.$_SESSION[CS]['g_nome_completo'];
$nom_tabela="Logout GC GRC";
grava_log_sis($tabela, 'S', $id_lo, $desc_log, $nom_tabela);

unset($_SESSION[CS]);

echo '<script type="text/javascript">top.location=\'index.php\';</script>';


?>

