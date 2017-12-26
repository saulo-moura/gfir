<style type="text/css">

   div#conteudo {
        padding:0px;
        margin:0px;
        margin-top:5px;
        margin-left:10px;
        width:685px;
    }

    div#conteudo img {
        text-align:center;

    }
    div#conteudo div#homeadministrar {
        width:100%;
        height:390px;
        text-align:center;
        text-align:left;
        border-top   : 1px solid #DADADA;
        border-bottom: 1px solid #DADADA;
        padding-top:0px;
        padding-bottom:0px;
        margin-top:3px;
        background:#900000;

        

        
    }
    
    div#imgswf {
        padding-top:0px;
        padding-bottom:0px;
        background: #FFFFFF url(imagens/administrar.jpg) no-repeat ;
        width:100%;
        height:390px;
        margin:0px;
        sopacity: 0.50;
        sfilter: alpha(opacity = 50);
        swidth: 100%; /* stupid IE */
        
        font-family : Calibri, Arial, Helvetica, sans-serif;
        font-size   : 20px;
        font-style  : normal;
        font-weight : bold;
        color       : #808080;
        color       : #900000;

        
}

    div#barra {
        margin-bottom:5px;
    }

    div#img {
        background-color:white;
        margin-top:3px;
        display:block;
        text-align:center;
        float:none;
        width:665px;
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
        scolor: #B70909;
        background: #c9c9c9;
    }
    div#tit_home_img {
        float:right;
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
    }


    div#img_qualidade {
        float:left;
        font-weight: bold;
        background: transparent;
        background: #C0C0C0;
        width:100%;
        margin-top:30px;
        margin-left:30px;
        margin-bottom:1px;
        width:320px;
        height:25px;
        cursor:pointer;
        sborder:1px solid red;
    }
    div#img_qualidade:hover {
        border-bottom:2px solid #900000;
    }


    div#img_qualidade img {
        float:left;
        cursor:pointer;

    }
    div#img_qualidade a {
        text-decoration:none;
        margin-left:20px;
    }

    div#img_qualidade a:visited {
        text-decoration:none;
    }




    div#img_seguranca {
        float:left;
        font-weight: bold;
        background: transparent;
        background: #C0C0C0;
        width:100%;
        margin-left:30px;
        margin-bottom:1px;
        width:320px;
        height:25px;
        cursor:pointer;
        sborder:1px solid red;
    }
    div#img_seguranca:hover {
        border-bottom:2px solid #FFFFFF;
    }

    
    div#img_seguranca img {
        float:left;
        cursor:pointer;

    }
    div#img_seguranca a {
        text-decoration:none;
        margin-left:20px;
    }

    div#img_seguranca a:visited {
        text-decoration:none;
    }


    div#img_meio_ambiente {
        float:left;
        font-weight: bold;
        sbackground: transparent;
        sbackground: #FFFFFF;
        background: #C0C0C0;
        width:100%;
        margin-left:30px;
        margin-bottom:1px;
        width:320px;
        height:25px;
        cursor:pointer;
        sborder:1px solid red;
    }
    div#img_meio_ambiente:hover {
        border-bottom:2px solid #900000;
    }
    div#img_meio_ambiente img {
        float:left;
        cursor:pointer;

    }
    div#img_meio_ambiente a {
        text-decoration:none;
        margin-left:20px;
    }

    div#img_meio_ambiente a:visited {
        text-decoration:none;
    }



    div#img_saude {
        float:left;
        font-weight: bold;
        background: transparent;
        background: #C0C0C0;
        width:100%;
        margin-left:30px;
        margin-bottom:1px;
        width:320px;
        height:25px;
        cursor:pointer;
        sborder:1px solid red;
    }
    div#img_saude:hover {
        border-bottom:2px solid #900000;
    }


    div#img_saude img {
        float:left;
        cursor:pointer;

    }
    div#img_saude a {
        text-decoration:none;
        margin-left:20px;
    }

    div#img_saude a:visited {
        text-decoration:none;
    }






    div#img_responsabilidade_social {
        float:left;
        font-weight: bold;
        background: transparent;
        background: #C0C0C0;
        width:100%;
        margin-left:30px;
        margin-bottom:1px;
        width:320px;
        height:25px;
        cursor:pointer;
        sborder:1px solid red;
    }
    div#img_responsabilidade_social:hover {
        border-bottom:2px solid #900000;
    }


    div#img_responsabilidade_social img {
        float:left;
        cursor:pointer;

    }
    div#img_responsabilidade_social a {
        text-decoration:none;
        margin-left:20px;
    }


    div#img_responsabilidade_social a:visited {
        text-decoration:none;
    }



</style>

<?php

$obra_escolhida=$_GET['obra_escolhida'];

//p('rtttttt');
//p($_SESSION[CS]['g_periodo_obra']);
/*
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
*/
$pathhome  = 'imagens/home_administrar.jpg';
$pathhomew = 'imagens/';
$pathhomey = 'home_administrar.jpg';

/*
if ($img_home_empreendimento!='')
{
    $pathhome  = $path.$img_home_empreendimento;
    $pathhomew = $path;
    $pathhomey = $img_home_empreendimento;
}
*/

/*
echo '<div id="barra">';
echo '<div id="tela">';
echo '<div id="img">';
    ImagemMostrar(170, 170, $path, $img_empreendimento, $nm_empreendimento, false, 'idt="'.$idt.'"');
echo '</div>';
echo '</div>';
echo '</div>';
*/

echo '<div id="homeadministrar">';
//<img alt="" src="imagens/mapa_brasil.jpg" border="0" usemap="#mapa_brasil" />

$path = $pathhomew;
$img  = $pathhomey;
$nm_empreendimento='';
echo '<div id="imgswf">';
//ImagemMostrar(676, 376, $path, $img, $nm_empreendimento, false, 'idt="'.$idt.'"');

echo "<div id='img_qualidade' title='Funcionalidade a ser desenvolvida' onclick='return usuario();' >";
$img  = 'qualidade.jpg';
$nm_desc='Usuários';
echo "<a >";
// ImagemMostrar(100, 50, $path, $img, $nm_desc, false, 'idt="'.$idt.'"');
echo $nm_desc;
echo '</a>';
echo '</div>';

//echo "<div id='img_seguranca' title='Clique aqui para visualizar Assinaturas' onclick='return assinatura_obra();' >";
//$img  = 'botao_pesquisar.jpg';
//$nm_desc='Assinaturas das Obras';
//echo '<a  >';
//ImagemMostrar(100, 50, $path, $img, $nm_desc, false, 'idt="'.$idt.'"');
//echo $nm_desc;
//echo '</a>';
//echo '</div>';

echo "<div id='img_meio_ambiente' title='Clique aqui para visualizar Login' onclick='return login_obra();' >";
$img  = 'botao_pesquisar.jpg';
//$nm_desc='Meio Ambiente';
echo '<a  >';
//ImagemMostrar(100, 50, $path, $img, $nm_desc, false, 'idt="'.$idt.'"');
$nm_desc='Login Sistema';
echo $nm_desc;
echo '</a>';
echo '</div>';

//echo "<div id='img_saude' title='Clique aqui para visualizar Assinantes' onclick='return assinantes();' >";
//$img  = 'botao_pesquisar.jpg';
//$nm_desc='Assinantes';
//echo '<a  >';
//ImagemMostrar(100, 50, $path, $img, $nm_desc, false, 'idt="'.$idt.'"');
//echo $nm_desc;
//echo '</a>';
//echo '</div>';

echo "<div id='img_responsabilidade_social' title='Google Analytics' onclick='return google_analytics();' >";
$img  = 'botao_pesquisar.jpg';
$nm_desc='Google Analytics';
echo '<a  >';
//ImagemMostrar(100, 50, $path, $img, $nm_desc, false, 'idt="'.$idt.'"');
echo $nm_desc;
echo '</a>';
echo '</div>';

$link_ana = $vetConf['url_google_analytics'];



echo '</div>';

//echo '<img alt="" src="'.$pathhome.'" border="0" usemap="#mapa_brasil" />';

?>

<script type="text/javascript">
<?php
    echo "var link_a = '{$link_ana}'; ";
?>
function usuario()
{
    self.location = 'conteudo.php?prefixo=relatorio&menu=usuario&class=0';
    return false;
}
function ZZZassinatura_obra()
{
    self.location = 'conteudo.php?prefixo=relatorio&menu=assinatura&class=0';
    return false;
}
function login_obra()
{
    self.location = 'conteudo.php?prefixo=relatorio&menu=loginobra&class=0';
    return false;
}
function assinantes()
{
    self.location = 'conteudo.php?prefixo=relatorio&menu=assinantes&class=0';
    return false;
}
function perfil_obra()
{
   // alert('Função a ser desenvolvida ');
   // return false;
   // self.location = link_a;
    return false;
}
function google_analytics()
{
    OpenWin(link_a , 'oas_PCO_google_analytics', 800, $(window).height(), 50, ($(window).width() - 800) / 2)
    return false;
}

function   assinatura_obra()
{

   var  left   = 0;
   var  top    = 0;
   var  height = $(window).height();
   var  width  = $(window).width();
   var link_gantt='conteudo_assinatura.php?prefixo=inc&menu=gerencia_assinatura&print=s&lupa=s&titulo_rel=&ampliar=S&origem=S';
   assinaturatrabalho    =  window.open(link_gantt,"ControleAssinatura","left="+left+",top="+top+",width="+width+",height="+height+",resizable=yes,menubar=yes,fullscreen=yes,scrollbars=yes,toolbar=no");
   assinaturatrabalho.focus();
   return false;

}

</script>