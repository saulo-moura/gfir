<link href="detalhe.css" rel="stylesheet" type="text/css" />
<?php
onLoadPag();

$sql = 'select * from video where idt_video = '.null($_GET['id']);
$rs = execsql($sql);
$row = $rs->data[0];
?>
<div class="detalhe_row">
    <div class="detalhe_tit16bc">
        <?php echo $row['ds_video'] ?>
    </div>
    <br>
    <div align="center">
        <?php
        $sql = "select * from video_album where idt_video = ".null($_GET['id'])." order by idt_vial";
        $rs = execsql($sql);
        
        echo '<div id="gallery"><ul>';
        
        ForEach($rs->data as $row) {
            $path = $dir_file.'/video_album/';
            
            if ($row['tipo_video'] == 'S') {
                $vet = explode('.', $row['nm_arquivo']);
                $extensao = mb_strtolower($vet[count($vet) - 1]);
                
                if ($extensao == 'swf') {
                    $href = $path.$row['nm_arquivo'].'?width=600&amp;height=400';
                } else {
                    $href = 'monta_album.php?tipo=video&arquivo='.$path.$row['nm_arquivo'].'&iframe=true&amp;width=600&amp;height=400';
                }
            } else {
                $href = $row['ds_youtube'];
            }
            
            echo '<li><a class="Geral" rel="prettyPhoto[all]" href="'.$href.'" title="'.trata_html(conHTML($row['ds_titulo'])).'" tooltip="'.trata_html(conHTML($row['ds_video'])).'&nbsp;">';
            ImagemProd(100, $path, $row['nm_imagem'], $row['idt_vial'].'_nm_imagem_', False, trata_html(conHTML($row['ds_titulo']))); 
            echo '</a></li>';
        }
        
        echo '</ul></div>';
        ?>
    </div>
</div>
<div align="center">
    <br>
    <img src="imagens/voltar.jpg" alt="Voltar" border="0" onclick="history.back()" style="cursor: pointer;">
</div>