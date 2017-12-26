<?php

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

function imagettftextalign($image, $size, $angle, $x, $y, $color, $font, $text, $alignment='L')
{
   //check width of the text
   $bbox = imagettfbbox ($size, $angle, $font, $text);
   $textWidth = $bbox[2] - $bbox[0];
   switch ($alignment) {
       case "R":
           $x -= $textWidth;
           break;
       case "C":
           $x -= $textWidth / 2;
           break;
   }
   //write text
   imagettftext ($image, $size, $angle, $x, $y, -$color, $font, $text);

}


function imageWordWrapBBox ( $Text, $Width = 650, $FontSize = 9, $Font = './fonts/arial.ttf' )
{
    $Words = explode ( ' ', $Text );
    $Lines = array ( );
    $Line  = '';

    foreach ( $Words as $Word )
    {
        $Box  = imagettfbbox ( $FontSize, 0, $Font, $Line . $Word );
        $Size = $Box[4] - $Box[0];
        if ( $Size > $Width )
        {
            $Lines[] = trim ( $Line );
            $Line    = '';
        }
        $Line .= $Word . ' ';
    }
    $Lines[] = trim ( $Line );

    $Dimensions = imagettfbbox ( $FontSize, 0, $Font, 'AJLMYabdfghjklpqry019`@$^&*(,' );
    $lineHeight = $Dimensions[1] - $Dimensions[5];

    return array ( $lineHeight, $Lines, $lineHeight * count ( $Lines ) );
}

function imageWordWrap ( $img,$width_i, $height_i , $Text, $Width, $Color, $X = 0, $Y = 0, $FontSize = 10, $Font = './fonts/arial.ttf', $marg_l )
{
    $Data = imageWordWrapBBox ( $Text, $Width-$marg_l, $FontSize, $Font );

    $alturalinhas = $height_i - $Data[2];
    $y_inicial    = ($alturalinhas/2) + ($Data[0]/2);
    $y_t=$Y + $y_inicial;



    foreach ( $Data[1] as $Key => $Line )
    {
        $locX = $X;
        $locY = $y_t + ( $Key * $Data[0] );

        //$Line=$Line.' - '.$y_t;
       // imagettftext ( $img, $FontSize, 0, $locX, $locY, $Color, $Font, $Line );
        $angle=0;
        $alignment='C';

        $locX=$width_i/2;

        $locX=$locX+$marg_l;

        imagettftextalign($img, $FontSize, $angle, $locX, $locY, $Color, $Font, $Line, $alignment);



    }

    return $Data;
}

    $imp_txt        =$_GET['imp_txt'];
    $texto_ap       =$_GET['texto'];
    $texto2         =$_GET['texto2'];

    //
    $nome           =$_GET['nome'];
    $foto           =$_GET['foto'];
    //
    $semtexto=1;
    if ($texto_ap=='')
    {
        $semtexto=0;
    }
    if ($semtexto==1)
    {
        if ($imp_txt!='S')
        {
           $semtexto=0;
        }
    }
    //
    //$font = imageloadfont('./04b.gdf');
    $path_ap        =$_GET['path'];
    $font_ap        =$_GET['font'];
    $font_tam_ap    =$_GET['font_tam'];
    $font_neg_ap    =$_GET['font_neg'];
    $font_cor_r_ap  =$_GET['cor_t_r'];
    $font_cor_g_ap  =$_GET['cor_t_g'];
    $font_cor_b_ap  =$_GET['cor_t_b'];
    $font_angulo_ap =$_GET['font_angulo'];
    $texto_x_ap     =$_GET['texto_x'];
    $texto_y_ap     =$_GET['texto_y'];
    if ($font_cor_r_ap!='')
    {
        $cor_r=$font_cor_r_ap;
    }
    if ($font_cor_g_ap!='')
    {
        $cor_g=$font_cor_g_ap;
    }
    if ($font_cor_b_ap!='')
    {
        $cor_b=$font_cor_b_ap;
    }
    $fonte = 'font_img/arialbd.ttf';
    if ($font_ap!='')
    {
        $fonte='font_img/'.$font_ap;
    }
    $tam_fonte=9;
    if ($font_tam_ap!='')
    {
        $tam_fonte=$font_tam_ap;
    }

    //echo ' get ggggggg '.$tam_fonte;

    $font_neg='N';
    if ($font_neg_ap!='')
    {
        $font_neg=$font_neg_ap;
    }
    $font_angulo=0;
    $texto_x=0;
    $texto_y=0;
    if ($font_angulo_ap!='')
    {
        $font_angulo=$font_angulo_ap;
    }
    if ($texto_x_ap!='')
    {
        $texto_x=$texto_x_ap;
    }
    if ($texto_y_ap!='')
    {
        $texto_y=$texto_y_ap;
    }
    if ($path_ap!='')
    {
        $img = LoadJpeg($path_ap);
        list($width_i, $height_i, $type_i, $attr_i)=getimagesize($path_ap);

    }
    else
    {
        $img = LoadJpeg($path_ap);
        list($width_i, $height_i, $type_i, $attr_i)=getimagesize($path_ap);
    }
    if ($foto!='')
    {
        $img_foto = LoadJpeg($foto);
        // Copy and merge
        imagecopymerge($img, $img_foto, 5, 7, 0, 0, 53, 70, 100);

    }








    $cor_texto_i = ImageColorAllocate($img, $cor_r, $cor_g, $cor_b); //Cria a cor de primeiro plano da imagem e configura-a para branco
    //ImageString($img, 5, 3, 30,$texto , $branco);
    if ($semtexto==1)
    {


       // imagettftext($img, $tam_fonte, $font_angulo, $texto_x, $texto_y, $branco, $fonte, $texto_ap);


        $border_t_l = 5;
        $border_t_t = 5;
        $border_t_r = 5;
        $border_t_b = 5;
        $marg_l     = 25;
        if ($foto=='')
        {
            $marg_l = 0;
        }

        //
        //$Text       = $texto_ap.' f '.$tam_fonte.' - '.$fonte;
        $Text       = $texto_ap;
        $Width      = $width_i  - ($border_t_l+$marg_l+$border_t_r);
        $Color      = $cor_texto_i;
        $X          = $texto_x;
        $Y          = $texto_y;
        $FontSize   = $tam_fonte;
        $Font       = $fonte;
        if ($nome=='')
        {
            imageWordWrap ( $img, $width_i, $height_i ,$Text, $Width, $Color, $X, $Y, $FontSize, $Font, $marg_l);
        }
        else
        {
            $FontSize=40;
            imageWordWrap ( $img, $width_i, 20 ,$nome, $Width, $Color, $X, $Y, $FontSize, $Font, $marg_l);
            //  imageWordWrap ( $img, $width_i, $height_i+20 ,$Text, $Width, $Color, $X, $Y, $FontSize, $Font, $marg_l);
            $FontSize=24;
            imageWordWrap ( $img, $width_i, 100 ,$Text, $Width, $Color, $X, $Y, $FontSize, $Font, $marg_l);

            $FontSize=24;
            imageWordWrap ( $img, $width_i, 310 , $texto2, $Width, $Color, $X, $Y, $FontSize, $Font, $marg_l);
        }






    }
    //header("Content-Type: image/png");
    imagepng($img, path_fisico.'tmp_img/'.$_GET['arq_img']);
    imageDestroy($img);
?>
