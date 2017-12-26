<link href="detalhe.css" rel="stylesheet" type="text/css" />
<?php
onLoadPag();

$url_volta = 'conteudo.php?prefixo=listar&menu=galeria_fotos';

$sql   = "select   *   from video ";
$sql  .= "   where idt = ".null($_GET['id']);
//$sql  .= "   order by marketing ";

$rs = execsql($sql);
$row = $rs->data[0];

// <div align="center">

?>
<div class="gallery_linha">
    <div class="gallery_titulo">
        <div style='float:left; '>
        <img src="imagens/menos_full_PCO.jpg" alt="Voltar" border="0" onclick="history.back()" style="cursor: pointer; ">
        </div>


        <div style='float:right; padding-right:10px;'>
        <?php echo $row['descricao'] ?>
        </div>

    </div>

    <div >
        <?php
     // $sql = "select * from video_album where idt_video = ".null($_GET['id'])." order by ordem";
        $sql   = "select   *   from video_album ";
        $sql  .= "   where idt_video  = ".null($_GET['id']);
        $sql  .= "   order by marketing desc, ordem ";

        $rs = execsql($sql);
        
      //  echo '<div id="gallery"><ul>';
        echo '<div id="gallery">';
        $marketingw = '#';
        $pri=0;
        ForEach($rs->data as $row) {
            $path = $dir_file.'/video_album/';
            $marketing = $row['marketing'];
            if ($marketingw != $marketing)
            {
                if ($marketing=='N')
                {
                    $txmark='Fotos Gerais';
                }
                else
                {
                    $txmark='Fotos para Marketing';
                }
                if ($pri==0)
                {

                    echo '<div id="gallery_m">';
                    echo "<span style='color:#000000; font-size:14px; font-weight: bold; display:block; background:#FFFFFF;  border-bottom:1px solid #808080;'>".$txmark."</span>";


                    echo '<ul>';
                    $pri=1;
                }
                else
                {
                    echo '</ul>';
                    echo '</div>';
                    
                    echo '<div id="gallery_m">';
                    echo "<span style='color:#000000; font-size:14px; font-weight: bold; display:block; background:#FFFFFF; border-bottom:1px solid #808080;'>".$txmark."</span>";

                    
                    echo '<ul>';
                }
                $marketingw = $marketing;
            }
            if ($row['tipo_video'] != 'F')
            {

                if ($row['tipo_video'] == 'V')
                {
                    // videos e swf para localizar no servidor

                    $vet = explode('.', $row['arquivo']);
                    $extensao = mb_strtolower($vet[count($vet) - 1]);

                    if ($extensao == 'swf')
                    {
                        $href = $path.$row['arquivo'].'?width=600&amp;height=400';
                    }
                    else
                    {
                        if ($extensao == 'jpg' or $extensao == 'gif')
                        {
                         //   $href = $path.$row['arquivo'];
                            $href = 'monta_album.php?tipo=video&arquivo='.$path.$row['arquivo'].'&iframe=true&amp;width=600&amp;height=400';
                        }
                        else
                        {
                           $href = 'monta_album.php?tipo=video&arquivo='.$path.$row['arquivo'].'&iframe=true&amp;width=600&amp;height=400';
                        }
                    }
                }
                else
                {
                    // aqui é para o caso do youtube
                    $href = $row['youtube'];
                }
            }
            else
            {
                // para imagens estáticas.....

                $href = 'monta_album.php?tipo=imagem&arquivo='.$path.$row['imagem'].'&iframe=true&amp;width=700&amp;height=450';

            }
            echo '<li> ';
            
            echo "<div style='display:block; height:120px; '> ";
            if ($row['descricao']!='')
            {
                $hintw = trata_html(conHTML($row['titulo']." : ".$row['descricao']));
            }
            else
            {
                $hintw = trata_html(conHTML($row['titulo']));
            }
            echo '<a class="Geral" rel="prettyPhoto[ALL]" href="'.$href.'" title="'.$hintw.'" tooltip="'.trata_html(conHTML($row['descricao'])).'&nbsp;">';
            if ($row['tipo_video'] == 'S')
            {
                ImagemProd(150, 200, $path, $row['arquivo'], $row['idt_video'].'_imagem_', False, False);
            }
            else
            {
                ImagemProd(150, 200, $path, $row['imagem'], $row['idt_video'].'_imagem_', False, False);
            }
            echo '</a>';
            echo '</div>';
            
            echo '</li>';
        }
        
        echo '</ul></div>';
        
        echo '</div>';
        
//            <div class="gallery_rodape">
//        <img src="imagens/menos_full_PCO.jpg" alt="Voltar" border="0" onclick="history.back()" style="cursor: pointer;">
//    </div>

        
        
        
        ?>
    </div>
</div>
