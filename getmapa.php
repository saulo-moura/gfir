<?php

Require_Once('configuracao.php');
//              259,110,260,111,262,111,264,109,
//$poligono_ba   = "309,202,312,189,303,180,292,174,278,171,268,169,262,173,258,171,258,165,256,159,256,150,253,144,255,139,257,136,262,139,267,139,272,138,277,134,279,129,283,126,291,126,296,122,299,122,302,124,308,123,312,120,315,118,318,119,322,121,325,124,326,128,328,132,325,135,326,139,327,144,327,148,325,153,320,153,317,156,317,160,317,166,316,181,317,187,317,193,315,197,315,201,313,205";
$estado_acolorir=$_GET['estado'];

$vet_estado      = Array();
$poligono_estado = '';
$pontos_estado   = 0;
$estadow         = '';
$img_estado      = '';
$pos_siglaw      = Array();
$pos_sigla_x     = 0;
$pos_sigla_y     = 0;

$vetest = $_SESSION[CS]['g_poligono_estado'];
ForEach ($vetest as $estado => $vetpoligono)
{
   if ($estado==$estado_acolorir)
   {
       $descricao = $vetpoligono[0];
       $poligono  = $vetpoligono[1];
       $pos_sigla = $vetpoligono[2];
       $estadow   = mb_strtolower($estado);

       if ($poligono!='')
       {
           $poligono_estado = $poligono;
           $vet_estado      = explode(',',$poligono_estado);
           $pontos_estado   = count($vet_estado)/2;
           $pos_siglaww     = $pos_sigla;
           $pos_siglaw      = explode(',',$pos_siglaww);
           $pos_sigla_x     = $pos_siglaw[0];
           $pos_sigla_y     = $pos_siglaw[1];

       }
   }
}


/*
$poligono_ba   = "309,202,312,189,303,180,292,174,278,171,268,169,262,173,258,171,258,165, 258,174,260,176,262,176,263,175,     256,159,256,150,253,144,255,139,257,136,262,139,267,139,272,138,277,134,279,129,283,126,291,126,296,122,299,122,302,124,308,123,312,120,315,118,318,119,322,121,325,124,326,128,328,132,325,135,326,139,327,144,327,148,325,153,320,153,317,156,317,160,317,166,316,181,317,187,317,193,315,197,315,201,313,205";
$vet_ba        = explode(',',$poligono_ba);
//
$poligono_sp   = "243,271,238,269,233,266,232,261,228,256,222,253,217,252,207,252,207,248,210,247,211,243,212,238,214,233,215,229,219,228,224,227,228,228,231,229,235,229,238,229,241,228,246,228,249,229,249,233,249,237,251,240,252,244,253,250,259,250,267,250,271,250,267,253,266,256,258,259,251,266";
$vet_sp        = explode(',',$poligono_sp);
//
$poligono_df   = "234,185,243,195";
$vet_df        = explode(',',$poligono_df);
//
$poligono_rs   = "206,355,209,353,210,349,210,344,212,340,213,335,214,333,215,331,216,326,219,322,223,323,225,327,223,330,225,324,228,317,228,313,226,309,223,308,220,304,218,301,213,299,208,301,204,300,201,299,197,299,192,301,186,308,183,310,179,314,176,318,174,327,175,323,176,326,180,327,183,334,190,335,193,338,198,342,200,344,203,347,206,348,206,354";
$vet_rs        = explode(',',$poligono_rs);

//
$pontos_ba=count($vet_ba)/2;
$pontos_sp=count($vet_sp)/2;
$pontos_df=count($vet_df)/2;
$pontos_rs=count($vet_rs)/2;
*/


//
$pathmapa      = 'imagens/mapa_brasil/';

$estadow       = $pathmapa.'estado_'.$estadow.'.jpg';
$img_estado    = LoadJpeg($estadow);

/*
$estado_ba     = $pathmapa.'estado_ba.jpg';
$img_estado_ba = LoadJpeg($estado_ba);
//
$estado_sp     = $pathmapa.'estado_sp.jpg';
$img_estado_sp = LoadJpeg($estado_sp);
//
$estado_rs     = $pathmapa.'estado_rs.jpg';
$img_estado_rs = LoadJpeg($estado_rs);
//
$estado_df     = $pathmapa.'estado_df.jpg';
$img_estado_df = LoadJpeg($estado_df);
*/
//
///////$imgname       = $pathmapa.'mapa_brasil.jpg';
///////$im=LoadJpeg($imgname);

$imgname       = $pathmapa.'mapa_brasil.png';
$im=Loadpng($imgname);


// algumas cores
$bg   = imagecolorallocate($im, 255, 255, 255);
$cor  = imagecolorallocate($im, 255, 0, 0);

$path    = $dir_file.'/empreendimento/';
$sql = '';
$sql .= ' select ';
$sql .= '   em.*, ';
$sql .= '   uf.idt as uf_idt,  ';
$sql .= '   uf.codigo as uf_codigo,  ';
$sql .= '   uf.descricao as uf_descricao,  ';
$sql .= '   uf.imagem as uf_imagem  ';
$sql .= ' from  empreendimento em';
$sql .= ' left join estado uf on uf.codigo = em.estado';
$sql .= ' where uf.codigo='.aspa($estado_acolorir);
$sql .= ' order by uf.codigo, em.descricao';
$rs = execsql($sql);
foreach ($rs->data as $row)
{
    $uf_codigo=$row['uf_codigo'];

    imagefilledpolygon($im, $vet_estado, $pontos_estado, $cor );
    imagecopymerge($im, $img_estado,$pos_sigla_x,$pos_sigla_y,  0, 0, 16, 16, 100);
    


    /*
    // desenha um poligono
    if ($uf_codigo=='BA')
    {
        imagefilledpolygon($im, $vet_ba, $pontos_ba, $cor );
        imagecopymerge($im, $img_estado_ba,290,140,  0, 0, 16, 16, 100);
    }
    if ($uf_codigo=='SP')
    {
        imagefilledpolygon($im, $vet_sp, $pontos_sp, $cor );
        imagecopymerge($im, $img_estado_sp,230,240,  0, 0, 16, 16, 100);
    }
    if ($uf_codigo=='DF')
    {
        imagefilledrectangle($im, $vet_df[0], $vet_df[1], $vet_df[2], $vet_df[3], $cor);
        imagecopymerge($im, $img_estado_df,227,195,  0, 0, 16, 16, 100);
    }
    if ($uf_codigo=='RS')
    {
        imagefilledpolygon($im, $vet_rs, $pontos_rs, $cor );
        imagecopymerge($im, $img_estado_rs, 195,309, 0, 0, 16, 16, 100);
    }

    */

}
// envia a imagem
header('Content-type: image/png');

$transparcor     = ImageColorAllocate($im,255,255,255);
imagecolortransparent($im,$transparcor);


imagepng($im);
imagedestroy($im);




function LoadJpeg($imgname)
{
    $x = @getimagesize($imgname);

    if (!$x) {
        return;
    }

    switch ($x[2]) {
        case IMAGETYPE_JPEG:
        case IMAGETYPE_JPEG2000:
            $im = @ImageCreateFromJPEG($imgname);
            break;
        case IMAGETYPE_GIF:
            $im = @ImageCreateFromGIF($imgname);
            break;

        case IMAGETYPE_PNG:
            $im = @ImageCreateFromPNG($imgname);

            break;

        default:
            $im = false;
            break;
    }

    if (!$im) { /* See if it failed */
        $im  = imagecreate(300, 30); /* Create a black image */
        $bgc = imagecolorallocate($im, 255, 255, 255);
        $tc  = imagecolorallocate($im, 255, 0, 0);
        imagefilledrectangle($im, 0, 0, 150, 30, $bgc);
        /* Output an errmsg */
        //imagestring($im, 1, 5, 5, "Error loading $imgname", $tc);
        imagestring($im, 1, 5, 5, "Erro de Carga do Arquivo:", $tc);
        imagestring($im, 1, 5, 15, "$imgname", $tc);

    }
    return $im;
}


function Loadpng($imgname)
{
    $x = @getimagesize($imgname);

    if (!$x) {
        return;
    }

    switch ($x[2]) {
        case IMAGETYPE_JPEG:
        case IMAGETYPE_JPEG2000:
            $im = @ImageCreateFromJPEG($imgname);
            break;
        case IMAGETYPE_GIF:
            $im = @ImageCreateFromGIF($imgname);
            break;

        case IMAGETYPE_PNG:
            $im = @ImageCreateFromPNG($imgname);
            break;

        default:
            $im = false;
            break;
    }

    if (!$im) { /* See if it failed */
        $im  = imagecreate(300, 30); /* Create a black image */
        $bgc = imagecolorallocate($im, 255, 255, 255);
        $tc  = imagecolorallocate($im, 255, 0, 0);
        imagefilledrectangle($im, 0, 0, 150, 30, $bgc);
        /* Output an errmsg */
        //imagestring($im, 1, 5, 5, "Error loading $imgname", $tc);
        imagestring($im, 1, 5, 5, "Erro de Carga do Arquivo:", $tc);
        imagestring($im, 1, 5, 15, "$imgname", $tc);
    }
    return $im;
}



?>
