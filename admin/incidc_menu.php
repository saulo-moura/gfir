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

    div#idc_menu {
       width:100%;
       xbackground:#000000;
       Xbackground: transparent url(obj_file/funcao/idc_fundo.png) repeat left top;
       background: transparent url(obj_file/funcao/idc_fundo.png) no-repeat center;
       xheight:800px;
       color:#FFFFFF;
    }


    div#idc_nomenclatura {
       cursor:pointer;
       xborder:2px solid #000000;
       background:transparent;
    }

.Sub_Menu {
       xbackground:#000000;
       background:transparent;
}

</style>

<?php
$path="obj_file/funcao/";
echo '<div id="idc_menu">';

$cod_idc  = '33.05.80';
$cod_idc  = '33.05.10';

$cod_idcw = $cod_idc.'%';
$cod_idcy = $cod_idc.'.';

$sql  = 'select ';
$sql .= '  fun.*   ';
$sql .= '  from funcao fun ';
$sql .= '  where fun.cod_classificacao like '.aspa($cod_idcw);
$sql .= '  order by linha, coluna ';

$rs = execsql($sql);

if ($rs->rows == 0) {
    echo "Módulo de Identidade Corporativa sem Itens cadastrados no Menu Padrão";
    exit();
}

echo '<table border="1" cellpadding="0" width="100%" cellspacing="0" class="Sub_Menu">';
//
$num_col_tab   = 8;

$num_lin_tab   = 4;

$imagem_nula   = "imagem_nula.png";


$col = 0;
$lin = 0;
//
ForEach ($rs->data as $row) {
    $cod_classificacao = $row['cod_classificacao'];
    $nm_funcao         = $row['nm_funcao'];
    $cod_funcao         = $row['cod_funcao'];
    $imagem            = $row['imagem'];
    $linha             = $row['linha'];
    $coluna            = $row['coluna'];
    $cod_classificacao = str_replace($cod_idcy,'',$cod_classificacao);
    $vet = explode('.',$cod_classificacao);
    $tam = count($vet);
    if  ($tam==1)
    {
         for ($c = 0; $c < 999; $c++)
         {

             if ($col == 0 or $col > 8 )
             {
                 if ($col != 0)
                 {
                     echo '    </tr> ';
                 }
                 echo '    <tr> ';
                 $lin = $lin +1;
                 $col = 0;
             }
             $col = $col + 1;
             $existe=0;
             if ( ($linha>0 and $linha<5) and ($col>0 and $col<9) )
             {
                $existe=1;
             }
             //if ( ($linha = $lin and $coluna = $col) or ($existe==1) )
             if ( ($linha == $lin and $coluna == $col) )
             {
                 // coluna tem conteúdo
                 echo '    <td> ';
                     echo "<div id='idc_nomenclatura' title='{$nm_funcao}' onclick='return {$cod_funcao}();' >";
                         $img      = $imagem;
                         echo "<a style='color:#000000;'>";
                         $pathw = $path.$img;
                         echo '<img style="padding:5px;" src="'.$pathw.'" width="100" height="100"  border="0" />';
                         echo '</a>';
                     echo '</div>';
                 echo '    </td> ';
                 break;
             }
             else
             {
                echo '    <td> ';
                echo "<div id='idc_nomenclatura' title='' >";
                $img      = $imagem_nula;
                echo "<a style='color:#000000;'>";
                $pathw = $path.$img;
                echo '<img style="padding:5px;" src="'.$pathw.'" width="100" height="100"  border="0" />';
                echo '</a>';
                echo '</div>';
                echo '    </td> ';
             }
         }
         
    }
}
// complementar coluna
for ($c = $col; $c <= $num_col_tab; $c++) {
    echo '    <td> ';
    echo "<div id='idc_nomenclatura' title='' ' >";
    $img      = $imagem_nula;
    echo "<a style='color:#000000;'>";
    $pathw = $path.$img;
    echo '<img style="padding:5px;" src="'.$pathw.'" width="100" height="100"  border="0" />';
    echo '</a>';
    echo '</div>';
    echo '    </td> ';
}
echo '    </tr> ';



// complementar linhas
for ($c = $lin; $c < $num_lin_tab; $c++) {
    echo '    <tr> ';
    for ($cx = 0; $cx < $num_col_tab; $cx++) {
        echo '    <td> ';
        echo "<div id='idc_nomenclatura' title='' >";
        $img      = $imagem_nula;
        echo "<a style='color:#000000;'>";
        $pathw = $path.$img;
        echo '<img style="padding:5px;" src="'.$pathw.'" width="100" height="100"  border="0" />';
        echo '</a>';
        echo '</div>';
        echo '    </td> ';
    }
    echo '    </tr> ';
}


/*
echo '    <tr> ';


// linha 1

for ($c = 0; $c < $num_col_tab; $c++) {

echo '    <td> ';






echo "<div id='idc_nomenclatura' title='Tabelas de Nomenclaturas' onclick='return idc_nomenclatura();' >";
$img      = 'idc_nomenclatura.png';
$nm_desc  = 'Tabelas de Nomenclaturas';
echo "<a >";
$pathw = $path.$img;
echo '<img style="padding:5px;" src="'.$pathw.'" width="100" height="100"  border="0" />';
//echo $nm_desc;
echo '</a>';
echo '</div>';
echo '    </td> ';

}
echo '    </tr> ';

// linha 2

echo '    <tr> ';
for ($c = 0; $c < $num_col_tab; $c++) {

echo '    <td> ';
echo "<div id='idc_nomenclatura' title='Tabelas de Nomenclaturas' onclick='return idc_nomenclatura();' >";
$img      = 'idc_nomenclatura.png';
$nm_desc  = 'Tabelas de Nomenclaturas';
echo "<a >";
$pathw = $path.$img;
echo '<img style="padding:5px;" src="'.$pathw.'" width="100" height="100"  border="0" />';
//echo $nm_desc;
echo '</a>';
echo '</div>';
echo '    </td> ';

}

echo '    </tr> ';

*/




echo '</table>';




echo '</div>';

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


function   idc_nomenclaturas()
{
   alert('idc_nomenclaturas');
   return false;
}
function   idc_pessoa()
{
   alert('idc_pessoa');
   self.location = 'conteudo_identidade_corporativa.php?prefixo=listar&menu=idc_pessoa&elemento=0';
   return false;
}
function   idc_cargo()
{
   alert('idc_cargo');
   self.location = 'conteudo_identidade_corporativa.php?prefixo=listar&menu=idc_cargo&elemento=0';
   return false;
}
function   idc_infraestrutura()
{
   alert('idc_infraestrutura');
   return false;
}
function   idc_ambiental()
{
   alert('idc_ambiental');
   return false;
}

function   idc_organizacao()
{
   alert('idc_organizacao');
   return false;
}
function   idc_negocio()
{
   alert('idc_negocio');
   return false;
}

</script>