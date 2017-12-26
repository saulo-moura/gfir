<style type="text/css">

   div#conteudo {
        padding:0px;
        margin:0px;
        margin-top:5px;
        margin-left:10px;
        swidth:685px;
    }

    div#conteudo img {
        smargin-top: 10px;
        smargin-left: 90px;
        text-align:center;

    }
    div#conteudo div#homeobra {
        width:98%;
        sheight:380px;
        sheight:405px;
        height:405px;
        text-align:center;
        border-top: 1px solid #DADADA;
        border-bottom: 1px solid #DADADA;
        background-color: #F2F2F2;
        padding-top:20px;
        padding-bottom:7px;
        margin-top:3px;

    }
    
    div#conteudo div#homeobra_ge {
        width:98%;
        height:405px;
        text-align:center;
        border-top: 1px solid #DADADA;
        border-bottom: 1px solid #DADADA;
        background-color: #FFFFFF;
        padding-top:20px;
        padding-bottom:7px;
        margin-top:3px;

    }
    
    div#imgswf {
        margin-top:20px;
    }
    
    div#barra {
        xmargin-top:3px;
        margin-bottom:5px;
    }

    div#img {
        background-color:white;
        margin-top:3px;
        display:block;
        text-align:center;
        float:none;
        width:665px;

        sheight:50px;
        sborder:1px solid red;
    }



    
    div#tit_home {

        float:right;
        padding-bottom: 2px;
        padding-top: 3px;
        padding-left: 5px;
        padding-right: 37px;
        margin-bottom: 14px;
        font-size: 12px;
        font-weight: bold;
        scolor: #90141a;
        sbackground: #c9c9c9;
        sbackground: url(imagens/seta_titulo.jpg) right top no-repeat #c9c9c9;
        sborder:2px solid red;
        
        color: #B70909;
        background: #c9c9c9;
        
        
    }
    div#tit_home_img {
        float:right;
        sborder:2px solid green;

    }
    div#tit_home_img a {
        text-decoration:none;
    }
    
    div#tit_home_img a:visited {
        text-decoration:none;
    }
    div#logo_obra {
        position:absolute;
        top:20px;
        left:790px;
        width:153px;
        height:150px;
        background:#FFFFFF;
        background:transparent;
        sborder:1px solid red;
    }


</style>

<?php

$obra_escolhida=$_GET['obra_escolhida'];

//p('rtttttt');
//p($_SESSION[CS]['g_periodo_obra']);

$path    = $dir_file.'/empreendimento/';
$sql = '';
$sql .= ' select ';
$sql .= '   em.*, ';
$sql .= '   uf.idt as uf_idt,  ';
$sql .= '   uf.descricao as uf_descricao,  ';
$sql .= '   uf.imagem as uf_imagem  ';
$sql .= ' from  empreendimento em';
$sql .= ' left join  estado uf on uf.codigo = em.estado';
$sql .= ' where em.idt = '.null($_SESSION[CS]['g_idt_obra']);
$rs = execsql($sql);
//p($sql);
$estado='';
$nm_empreendimento='';
$img_empreendimento='';
$img_home_empreendimento='';
$idt=0;

foreach ($rs->data as $row)
{
    $estado=$row['uf_descricao'];
    $nm_empreendimento=$row['descricao'];
    $img_empreendimento=$row['imagem'];
    $img_home_empreendimento=$row['imagem_home'];
    $idt=$row['idt'];
}

if ($_SESSION[CS]['g_idt_obra']!=999 and $_SESSION[CS]['g_idt_obra']!=888)
{
    $pathhome= 'imagens/home_obra.jpg';
}
else
{
    if ($_SESSION[CS]['g_idt_obra']==999)
    {   // gestão de Obras
    
        $pathhome= 'imagens/home_gerencial.jpg';
    }
    else
    {   // procedimentos
    
        $pathhome= 'imagens/home_procedimento.jpg';
    }
}
$pathhomew='';
$pathhomey=$pathhome;
if ($img_home_empreendimento!='')
{
    $pathhome  = $path.$img_home_empreendimento;
    $pathhomew = $path;
    $pathhomey = $img_home_empreendimento;
}

/*
echo '<div id="barra">';
echo '<div id="tela">';
echo '<div id="img">';
    ImagemMostrar(170, 170, $path, $img_empreendimento, $nm_empreendimento, false, 'idt="'.$idt.'"');
echo '</div>';
echo '</div>';
echo '</div>';
*/
if ($_SESSION[CS]['g_idt_obra']!=999 and $_SESSION[CS]['g_idt_obra']!=888)
{
    echo '<div id="homeobra">';
}
else
{
    echo '<div id="homeobra_ge">';

}
//<img alt="" src="imagens/mapa_brasil.jpg" border="0" usemap="#mapa_brasil" />

$path=$pathhomew;
$img=$pathhomey;



echo '<div id="imgswf">';
ImagemMostrar(676, 376, $path, $img, $nm_empreendimento, false, 'idt="'.$idt.'"');
echo '</div>';

//echo '<img alt="" src="'.$pathhome.'" border="0" usemap="#mapa_brasil" />';



?>











<map name="mapa_brasil" id="mapa_brasil">
    <area cod="BA" title="Bahia" shape="poly" coords="309,202,312,189,303,180,292,174,278,171,268,169,262,173,258,171,258,165,256,159,256,150,253,144,255,139,257,136,262,139,267,139,272,138,277,134,279,129,283,126,291,126,296,122,299,122,302,124,308,123,312,120,315,118,318,119,322,121,325,124,326,128,328,132,325,135,326,139,327,144,327,148,325,153,320,153,317,156,317,160,317,166,316,181,317,187,317,193,315,197,315,201,313,205" href="#" />
    <area cod="SP" title="São Paulo" shape="poly" coords="243,271,238,269,233,266,232,261,228,256,222,253,217,252,207,252,207,248,210,247,211,243,212,238,214,233,215,229,219,228,224,227,228,228,231,229,235,229,238,229,241,228,246,228,249,229,249,233,249,237,251,240,252,244,253,250,259,250,267,250,271,250,267,253,266,256,258,259,251,266" href="#" />
    <!--
    <area cod="MG" title="MG" shape="poly" coords="305,201,306,196,308,189,305,185,298,183,293,180,287,177,279,174,273,173,268,174,265,177,260,179,255,177,253,181,253,185,250,188,247,191,248,195,249,200,250,206,245,209,237,211,229,214,223,214,218,221,218,225,222,224,226,224,230,224,235,226,239,225,244,225,249,224,252,226,252,230,253,235,255,239,255,242,256,246,260,247,265,246,270,246,275,243,279,242,283,240,287,238,291,234,295,230,297,226,298,221,300,216,300,213,301,208" href="#" />
    <area cod="ES" title="ES" shape="poly" coords="300,236,304,235,306,231,306,225,309,221,312,217,312,213,311,209,307,206,304,207,301,221,299,230" href="#" />
    <area cod="DF" title="DF" shape="rect" coords="234,185,243,195" href="#" />
    -->
</map>


<?php
echo '</div>';
?>



<script type="text/javascript" >
    $(document).ready(function () {
        $('#mapa_brasil area').click(function() {
            self.location = 'conteudo.php?prefixo=inc&menu=empreendimento&estado=' + $(this).attr('cod');
            return false;
        });
    });
</script>
