<style type="text/css">

div#home_noticia_sistema  {
    font-family : Arial, Helvetica, sans-serif;
    font-size   : 13px;
    font-style  : normal;
    font-weight : normal;
    color       : #C40000;
    text-align  : left;

    margin-left:0px;
    margin-top :1px;
    background-color:#FFFFFF;

    sborder-top:6px solid #808080;
    sborder-right:6px solid #C0C0C0;
    sborder-bottom:6px solid #808080;
    sborder-left:6px solid #C0C0C0;

    padding:0px;
    width:99%;
    height:420px;
    overflow:auto;

    z-index:20000;
}

div#home_noticia_sistema  {
    width:99%;
    background-color:#FFFFFF;
    border-bottom:1px solid black;
    padding-top:5px;
    padding-bottom:5px;
    text-align  : center;
}

div#home_noticia_sistema_titulo span {
    padding-left :3px;
    padding-right:3px;
}


div#home_noticia_sistema_pergunta {
    background-color:#E2E2E2;
    padding-left:10px;
    padding-top:2px;
    padding-bottom:5px;
    text-align  : left;
}

div#home_noticia_sistema_pergunta span {
    font-family : Arial, Helvetica, sans-serif;
    font-size   : 13px;
    font-style  : normal;
    font-weight : bold;
    color       : #C40000;
    padding-top:2px;
    padding-bottom:5px;

}

div#home_noticia_sistema_resposta {
    background-color:#FFFFFF;
    padding-left:20px;
    padding-top:2px;
    padding-bottom:5px;
    text-align  : left;
}

div#home_noticia_sistema_resposta span {
    font-family : Arial, Helvetica, sans-serif;
    font-size   : 12px;
    font-style  : normal;
    font-weight : normal;
    color       : #232323;
    padding-top:2px;
    padding-bottom:5px;

}

</style>


<?php
$nome     =$_SESSION[CS]['g_nome_completo'];
$email    =$_SESSION[CS]['g_email'];
$telefone ='';
echo "<div id='home_noticia_sistema'>";
echo "<div id='home_noticia_sistema_titulo'>";

echo " <span> ";
echo '<img id="src_noticia_sistema" src="imagens/logo_noticia_sistema.jpg" alt="Notícias do sistema" title="Notícias do sistema" border="0"/>';
echo " </span> ";

echo "</div>";



$sql   = "select  ";
$sql  .= "    idt,  ";
$sql  .= "    data,  ";
$sql  .= "    hora,  ";
$sql  .= "    descricao,  ";
$sql  .= "    detalhe,  ";
$sql  .= "    contato  ";
$sql  .= " from plu_noticia_sistema ";
$sql  .= ' where ativa = '.aspa('S');
$sql  .= ' order by principal desc, ativa desc, data desc, hora desc';

$rs = execsql($sql);
ForEach($rs->data as $row) {
    echo " <div id='home_noticia_sistema_pergunta'> ";
    echo " <span> ";
    $l1= trata_data($row['data']).'&nbsp;&nbsp;&nbsp;&nbsp;'.$row['hora'].'&nbsp;&nbsp;&nbsp;&nbsp;'.$row['contato'];
    echo $l1.'<br />';
    echo " </span> ";
    echo " </div> ";
    echo " <div id='home_noticia_sistema_resposta'> ";
    echo " <span> ";
    echo $row['descricao'].'<br /><br />';
    echo $row['detalhe'].'<br />';
    echo " </span> ";
    echo " </div> ";
}


echo "<table class='table_contato' width='100%' border='0' cellspacing='4' cellpadding='4' vspace='0' hspace='0'> ";
$btconfirma = "<input type='submit' name='btnAcao' value='Enviar' onClick='valida = ".'"'."S".'"'."' style='width:150px; height:25px; margin-left:10px; cursor: pointer;'/>";
$btretorna  = "<input type='button' value='Retornar' name='btretornar' id='btretornar' style='width:150px; height:25px; margin-left:10px; cursor: pointer;'  onclick='return fecha_noticia();'  />";
echo "<tr class='table_contato_linha'> ";
echo "   <td class='table_contato_celula_btconfirmar' >{$btretorna}</td> ";
echo "</tr>";
echo "</table >";

echo "</div>";
?>

<script type="text/javascript">

function fecha_noticia()
{
    //alert('fecha');
    parent.hidePopWin(false);

    return false;
}

</script>
