<?php
    // dowload_torre_andar_servico.php
    $idt_obra = $_GET['idt_obra'];
    $pasta    = "obj_file/ma_parametros/";
    $file     = "output_residuo".$idt_obra.".csv";
    $path     = $pasta.$file;
    if(isset($file) && file_exists("{$pasta}/".$file)){
       $type = filetype("{$pasta}/{$file}");
       $size = filesize("{$pasta}/{$file}");
       header("Content-Description: File Transfer");
       header("Content-Type:{$type}");
       header("Content-Length:{$size}");
       header("Content-Disposition: attachment; filename=$file");
       header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
       header('Expires: 0');
       readfile("{$pasta}/{$file}");
       exit();

    }
?>