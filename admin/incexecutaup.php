<?php
    Require_Once 'configuracao_cliente.php';
    Require_Once('gsd_funcoes.php');
    $dir_arq     = $_GET['file'];
    
    echo ' ggggggggggggggggggggg '.$dir_arq ;
  //  exit();
    downloadFile( $dir_arq );
?>
