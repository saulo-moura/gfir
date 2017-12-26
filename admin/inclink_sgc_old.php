<style type="text/css">

div#moldura {
    float:left;
    font-style: normal;
    swidth  : 797px;
    width  : 784px;
    color: #CCCCCC;
    font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
    font-size: 16px;
    font-weight: bold;
    text-shadow: 1px 2px 2px #C0C0C0;
    padding-left:5px;
}


div#texto {
    font-style: normal;
    width     : 764px;
    color: #CCCCCC;
    font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
    font-size: 16px;
    sfont-weight: bold;
    text-shadow: 1px 2px 2px #C0C0C0;
    padding:10px;
}
td.linha_campo_l {
   text-align: left;
   border-collapse: collapse;
   padding-top:5px;
   padding-bottom:5px;
   padding-right: 20px;
   border-bottom:1px solid #FFD2D2;
   border-bottom:1px solid #FFE8E8;
}
td.linha_campo_l a{
   text-decoration:none;
   color: #600000;
   font-weight: normal;
   font-size: 16px;
}

</style>

<?php
// montar a Home do site


$obra_escolhida=$_SESSION[CS]['g_idt_obra'];

echo "<div id='moldura'>";

echo     "<div id='texto'>";
$path='admin/obj_file/consultoria_externa/';
echo "<table id='datatable' class='tabela_lista' width='100%' border='0' cellspacing='0' cellpadding='0' vspace='0' hspace='0'> ";
$sql  = 'select ';
$sql .= ' ce.* ';
$sql .= ' from consultoria_externa ce ';
$sql .= " where ";
$sql  .= '      ce.idt_empreendimento = '.null($obra_escolhida);
$sql .= "   and ce.ativo = 'S' ";
$sql .= ' order by ce.ordem, ce.titulo';
$rs = execsql($sql);
foreach ($rs->data as $row) {
    $imagem     = $row['imagem'];
    $titulo     = $row['titulo'];
    $link       = $row['link'];
    $linhaw="<a href='$link' target='_blank' >$titulo</a>";
    echo "<tr class='linha_lista'>";
    echo "<td class='linha_campo_l' style='width:30px;' >";
    echo "<a href='$link' target='_blank' >";
    ImagemProd(60 , 50, $path, $imagem, $titulo);
    echo "</a>";
    echo "</td>";
    echo "<td class='linha_campo_l'  >".$linhaw."&nbsp;</td>";
    echo "</tr>";
}
echo '</table>';
echo     "</div>";
echo "</div>";
echo '</table>';
//
$url_volta = 'conteudo'.$cont_arq.'.php';
echo ' <div id="voltar_full_m">';
echo ' <div class="voltar">';
echo '         <img src="imagens/menos_full_PCO.jpg" title="Voltar"  alt="Voltar" border="0" onclick="self.location = '."'".$url_volta."'".'" style="cursor: pointer;">';
echo ' </div>';
echo ' </div>';
?>