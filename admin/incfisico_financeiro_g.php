<style type="text/css">

div#area_imprime {
    background: #FFFFFF;
    text-align:left;
    width:2000px;
}
div#area_imprime img {
    background: #FFFFFF;
    padding-right:5px;
}

div#area_imprime_cel {
    background: green;
    text-align:left;
    swidth:20px;
    smargin-left:100px;
    float:left;
}

</style>



<?php

$vet=Array();

echo " <div id='area_imprime' > ";

//echo ' mmm '.$_GET['print'].' oooo '.$_GET['origem'].' lupa '.$_GET['lupa'];

$origem=$_GET['origem'];
$vethtmlexcel=Array();

if ($_GET['print']=='')
{
    $_GET['origem']='G';
    $vet     = carregar_vetor_cronograma($_SESSION[CS]['g_idt_obra'],'S');
    $vethtml = carregar_vetor_cronograma_html($_SESSION[CS]['g_idt_obra'],$vet,'G',$vethtmlexcel);
//    $vethtml = carregar_vetor_cronograma_html($_SESSION[CS]['g_idt_obra'],$vet,$_GET['origem']);


}
else
{
    $vet     = carregar_vetor_cronograma($_SESSION[CS]['g_idt_obra'],'S');
    if ($_GET['lupa']=='s')
    {
        $vethtml = carregar_vetor_cronograma_html($_SESSION[CS]['g_idt_obra'],$vet,'G',$vethtmlexcel);
    }
    else
    {
        $vethtml = carregar_vetor_cronograma_html($_SESSION[CS]['g_idt_obra'],$vet,'S',$vethtmlexcel);
    }
//    $vethtml = carregar_vetor_cronograma_html($_SESSION[CS]['g_idt_obra'],$vet,$_GET['origem']);
}

if (is_array($vethtml)) {
   // echo ' estou aqui ';
    ForEach ($vethtml as $idx => $linhaw) {
       //echo ' <frameset id="frameset" rows="*,0" frameborder="no" border="0" framespacing="0" onunload=\'OpenWin("logout.php", "logout", 100, 100, -200, -200)\'>';
       echo $linhaw;
       //echo ' </frameset> ';
    }
$im = imagegrabscreen();
imagepng($im, "myscreenshot.png");
imagedestroy($im);
}
else
{
    echo "<span style='font-size=13px; '> Sem dados </span>";
}

echo " </div> ";


//p($vet);
?>