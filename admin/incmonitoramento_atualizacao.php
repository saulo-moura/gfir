
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
    div#link_consultoria  {

       width:685px;
       height: 50px;
       background:#F0F0F0;
       cursor:pointer;
       margin-bottom:20px;
       text-align:center;
       padding-top:10px;
    }
    div#link_consultoria  a {
       text-decoration:none;
       font-family :  Calibri,  Arial, Helvetica, sans-serif;
       font-style: normal;
       font-size: 14px;
       font-weight: bold;
       color: #900000;
    }






</style>

<?php
/*
$obra_escolhida=$_GET['obra_escolhida'];
$msg='';
$idt_obra=null($_SESSION[CS]['g_idt_obra']);
$indicador = verificar_menu_obra($idt_obra, $msg);
if ($indicador=='N')
{
    echo "<div id='menu_existe_obra' > ";
    echo '<a >'.$msg.'</a>';
    echo "</div>";
    onLoadPag();
    FimTela();
    exit();
}
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
$link_consultoria='';

foreach ($rs->data as $row)
{
    $estado=$row['uf_descricao'];
    $nm_empreendimento=$row['descricao'];
    $img_empreendimento=$row['imagem'];
    $img_home_empreendimento=$row['imagem_home'];
    $idt=$row['idt'];
    $link_consultoria=$row['link_consultoria'];
}

$pathhome= 'imagens/home_obra.jpg';
$pathhomew='';
$pathhomey=$pathhome;
if ($img_home_empreendimento!='')
{
    $pathhome  = $path.$img_home_empreendimento;
    $pathhomew = $path;
    $pathhomey = $img_home_empreendimento;
}



$path=$pathhomew;
$img=$pathhomey;
//$vetConf['url_oas_empreendimentos']

*/


echo "<div id='link_consultoria' > ";

// <img style="padding:5px;" src="imagens/zoom.gif" width="32" height="32" title="Ampliar Cronograma Gantt" alt="Ampliar Cronograma Gantt"  border="0" />

echo '<a href="#" onclick="return chama_gantt_amplia()" >Clique aqui para ter acesso ao Monitoramento da Atualização da Obra <br></a>';
echo "</div>";

echo '<script type="text/javascript">';
echo 'var ganttamplia=null;';
echo 'function chama_gantt_amplia()';
echo '{';

echo "    var link_gantt = 'conteudo_assinatura.php?prefixo=inc&menu=gerencia_assinatura&print=s&lupa=s&titulo_rel=&ampliar=S&origem=S';  ";
echo '    var ganttamplia    =  window.open(link_gantt,"_blank","menubar=no,scrollbars=yes,toolbar=no");';
//echo "    alert('time');   ";
//echo '    ganttamplia.document.write("guy e bete!");';
echo '    ganttamplia.opener.blur(); ';
echo '    ganttamplia.focus();   ';


//echo "    alert('time sssss');   ";
echo '    return false;';
echo '}';

//echo '    blur();   ';
//echo '    ganttamplia.focus();   ';
echo ' $(document).ready(function () { ';

echo '    chama_gantt_amplia(); ';

echo '  }); ';

echo "</script>";

?>
