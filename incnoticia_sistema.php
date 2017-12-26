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
    padding:0px;
    width:49%;

    z-index:20000;
}

div#home_noticia_sistema  {
    width:49%;
    background-color:#FFFFFF;
    border-bottom:1px solid black;
    padding-top:5px;
    padding-bottom:5px;
    text-align  : left;
    background:#8080FF;

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


echo "<div id='home_noticia_sistema' style='float:left; '>";

echo "<div id='home_noticia_sistema_titulo'>";

echo " <span style='text-align:left; font-size:20px; font-weight: bold; color:#004080;'> ";
//echo '<img id="src_noticia_sistema" src="imagens/logo_noticia_sistema.jpg" alt="Notícias do sistema" title="Notícias do sistema" border="0"/>';
echo "Destaques";

echo " </span> ";

echo "</div>";



$sql   = "select  ";
$sql  .= "    idt,  ";
$sql  .= "    data,  ";
$sql  .= "    hora,  ";
$sql  .= "    descricao,  ";
$sql  .= "    detalhe,  ";
$sql  .= "    contato  ";
$sql  .= " from ".$pre_table."plu_noticia_sistema ";
$sql  .= ' where ativa     = '.aspa('S');
$sql  .= ' and   principal = '.aspa('S');
$sql  .= ' order by principal desc, ativa desc, data desc, hora desc';

$rs = execsql($sql);
echo "<table class='table_contato' width='100%' border='0' cellspacing='0' cellpadding='0' vspace='0' hspace='0'> ";

ForEach($rs->data as $row) {
    echo "<tr>";
    echo "<td>";
    echo " <div id='home_noticia_sistema_pergunta'> ";
    echo " <span> ";
    $l1= trata_data($row['data']).'&nbsp;&nbsp;&nbsp;&nbsp;'.$row['hora'].'&nbsp;&nbsp;&nbsp;&nbsp;'.$row['contato'];
    echo $l1.'<br />';
    echo " </span> ";
    echo " </div> ";
    echo " <div id='home_noticia_sistema_resposta'> ";
    echo " <span style='color:#000000; font-size:14px;'> ";
    echo $row['descricao'].'<br />';
    echo "<span style='color:#004080; font-size:14px;'>".$row['detalhe']." </span>".'<br />';
    echo " </span> ";
    echo " </div> ";
    echo "</td>";
    echo "</tr>";
}
echo "</table >";

echo "</div>";




///////////////// lado direito

echo "<div id='home_noticia_sistema' style='float:right'> ";

echo "<div id='home_noticia_sistema_titulo'>";

echo " <span style='text-align:left; font-size:20px; font-weight: bold; color:#004080;'> ";
//echo '<img id="src_noticia_sistema" src="imagens/logo_noticia_sistema.jpg" alt="Notícias do sistema" title="Notícias do sistema" border="0"/>';
echo "Notícias";

echo " </span> ";

echo "</div>";



$sql   = "select  ";
$sql  .= "    idt,  ";
$sql  .= "    data,  ";
$sql  .= "    hora,  ";
$sql  .= "    descricao,  ";
$sql  .= "    detalhe,  ";
$sql  .= "    contato  ";
$sql  .= " from ".$pre_table."plu_noticia_sistema ";
$sql  .= ' where ativa     = '.aspa('S');
$sql  .= ' and   principal <> '.aspa('S');
$sql  .= ' order by principal desc, ativa desc, data desc, hora desc';

$rs = execsql($sql);
echo "<table class='table_contato' width='100%' border='0' cellspacing='0' cellpadding='0' vspace='0' hspace='0'> ";

ForEach($rs->data as $row) {
    echo "<tr>";
    echo "<td>";
    echo " <div id='home_noticia_sistema_pergunta'> ";
    echo " <span> ";
    $l1= trata_data($row['data']).'&nbsp;&nbsp;&nbsp;&nbsp;'.$row['hora'].'&nbsp;&nbsp;&nbsp;&nbsp;'.$row['contato'];
    echo $l1.'<br />';
    echo " </span> ";
    echo " </div> ";
    echo " <div id='home_noticia_sistema_resposta'> ";
    echo " <span style='color:#000000; font-size:14px;'> ";
    echo $row['descricao'].'<br />';
    echo "<span style='color:#004080; font-size:14px;'>".$row['detalhe']." </span>".'<br />';
    echo " </span> ";
    echo " </div> ";
    echo "</td>";
    echo "</tr>";
}
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
