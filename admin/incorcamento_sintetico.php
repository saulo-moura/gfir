
<style type="text/css">


div#despesa_direta {
    soverflow:auto;
    sheight: 380px;
    width : 680px;
    float:left;
    font-family : Calibri, Arial, Helvetica, sans-serif;
    font-style: normal;
    font-size: 12px;
    font-weight: bold;
    color:#FF5959;
    background: #FFFFFF;
    margin-top:0px;
}


div#despesa_direta_1 {
    soverflow:auto;
    sheight: 360px;
    width : 680px;
    float:left;
    font-family : Calibri, Arial, Helvetica, sans-serif;
    font-style: normal;
    font-size: 12px;
    font-weight: bold;
    color:#FF5959;
    padding:0px;
    background: #FFFFFF;
}


table.despesa_direta_table{
    font-family : Calibri, Arial, Helvetica, sans-serif;
    font-style: normal;
    font-size: 12px;
    font-weight: normal;
    color:#000000;
    background: #EFEFEF;
}

tr.despesa_direta_table_tr {


}
td.despesa_direta_titulo_td {
    font-weight : bold;
    color       : #004080;
    text-align  :center;
    padding-top :5px;
    padding-left:5px;
    border-bottom:1px solid #9D0000;
}
tr.despesa_direta_cab_tr {

}
td.despesa_direta_cab_td {
    font-weight :bold;
    color       :#004080;
    text-align  :left;
    padding-top :5px;
    padding-left:5px;
    border-bottom:1px solid #9D0000;
}

td.despesa_direta_cab_td_r {
    font-weight : normal;
    color       :#004080;
    text-align  :left;
    padding-top :5px;
    padding-left:5px;
    border-bottom:1px solid #9D0000;
    text-align: right;
}

tr.despesa_direta_linha_tr {

}
td.despesa_direta_linha_td_t {
    font-weight   : bold;
    color         : #FFFFFF;
    background    : #E0E0E0;
    background    : #900000;
    padding-top   : 5px;
    padding-left  : 5px;
    border-bottom : 1px solid #C0C0C0;
}

td.despesa_direta_linha_td_t1 {
    font-weight   : bold;
    color         : #FFFFFF;
    background    : #808080;
    padding-top   : 5px;
    padding-left  : 5px;
    border-bottom : 1px solid #C0C0C0;
}

td.despesa_direta_linha_td_t2 {
    font-weight   : normal;
    color         : #000000;
    background    : #F0F0F0;
    padding-top   : 5px;
    padding-left  : 5px;
    border-bottom : 1px solid #C0C0C0;
}


td.despesa_direta_linha_td_t_r {
    font-weight   : bold;
    color         : #FFFFFF;
    background    : #E0E0E0;
    background    : #900000;
    padding-top   : 5px;
    padding-left  : 5px;
    border-bottom : 1px solid #C0C0C0;
    text-align    : right;
}

td.despesa_direta_linha_td_t1_r {
    font-weight   : bold;
    color         : #FFFFFF;
    background    : #808080;
    padding-top   : 5px;
    padding-left  : 5px;
    border-bottom : 1px solid #C0C0C0;
    text-align    : right;
}

td.despesa_direta_linha_td_t2_r {
    font-weight   : normal;
    color         : #000000;
    background    : #F0F0F0;
    padding-top   : 5px;
    padding-left  : 5px;
    border-bottom : 1px solid #C0C0C0;
    text-align    : right;
}



td.despesa_direta_linha_td_a {
    font-weight :normal;
    color       :#575757;
    background  :#FFFFFF;
    padding-top :5px;
    padding-left:5px;
    border-bottom : 1px solid #C0C0C0;
}

td.despesa_direta_linha_td_a_r {
    font-weight : normal;
    color       :#575757;
    background  :#FFFFFF;
    padding-top :5px;
    padding-left:5px;
    border-bottom : 1px solid #C0C0C0;
    text-align    : right;
}

div#despesa_direta_c {
    background:#FFCCCC;
    width : 680px;
    height:10px;
    margin:0px;
}

div#despesa_direta_r {
    background:#FFCCCC;
    width : 680px;
    height:10px;
    margin:0px;
    float:left;
}



div#voltar_full_m  {
    float:left;
    height:25px;
    background:transparent;
    sbackground:red;
    margin:0px;
    padding:0px;
}

div#voltar_full_m img {
    cursor: pointer;
}

.voltar  {
    float:left;
}


div#area_imprime {
    float:left;
    background: #FFFFFF;
    text-align:right;
    background:blue;

}
div#area_imprime img {
    background: #FFFFFF;
    padding-right:5px;
    cursor: pointer;
}

div#area_excel {
    float:left;
    background: #FFFFFF;
    text-align:right;

}
div#area_excel img {
    background: #FFFFFF;
    padding-right:5px;
    cursor: pointer;
}

div#area_doc {
    float:left;
    background: #FFFFFF;
    text-align:right;

}
div#area_doc img {
    background: #FFFFFF;
    padding-right:5px;
    cursor: pointer;
}

</style>


<?php


if ($_GET['print'] != 's') {
    echo ' <div id="voltar_full_m">';

    echo ' <div class="voltar">';
    echo '         <img src="imagens/menos_full_pco.jpg" title="Voltar"   width="16" height="16"  style="padding:5px; " alt="Voltar" border="0" onclick="self.location = '."'".$url_volta."'".'" style="cursor: pointer;">';
    echo ' </div>';

    $nome_pr   = 'orcamento_sintetico';
    $nome_ex   = 'OR�AMENTO SINT�TICO - ';
    $titulo_rl = 'Or�amento Sint�tico';
    echo "<div id='area_imprime' >";
   // echo '<a target="_blank" href="conteudo_print.php?prefixo=inc&menu='.$nome_pr.'&print=s&titulo_rel='.$titulo_rl.$parww.'" ><img style="padding:5px; "  src="imagens/impressora.gif" width="16" height="16" title="Preparar para Impress�o" alt="Preparar para Impress�o"  border="0" /></a>';
    echo '<a href="#"  onclick="return chama_orcamento('."'".$nome_pr."', "."'".$titulo_rl."'".');" ><img style="padding:5px; "  src="imagens/impressora.gif" width="16" height="16" title="Preparar para Impress�o" alt="Preparar para Impress�o"  border="0" /></a>';
    echo "</div>";

    echo ' </div>';
    echo "<br /><br /><br />";
}




$par_auto=" onChange = 'document.frm.submit();' ";

$sql     = 'select  idt, estado, descricao from empreendimento ';
if ($veiosite=='S')
{
    $sql    .= '    where idt = '.null($_SESSION[CS]['g_idt_obra']);
}
$sql    .= '    order by estado, descricao ';
$Filtro  = Array();
$Filtro['rs'] = execsql($sql);
$Filtro['vlPadrao'] = $_SESSION[CS]['g_idt_obra'];
$Filtro['id'] = 'idt';
$Filtro['js'] = "style='width:400px;'".$par_auto;

$Filtro['nome'] = 'Empreendimento';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['empreendimento'] = $Filtro;


$sql     = 'select  idt, identificador from orcamentos_empreendimento ';
if ($veiosite=='S')
{
    $sql    .= '    where idt_empreendimento = '.null($_SESSION[CS]['g_idt_obra']);
    $sql    .= '      and tipo = '.aspa('1');
}
$sql    .= '    order by identificador ';
$Filtro  = Array();
$Filtro['rs'] = execsql($sql);
//$Filtro['vlPadrao'] = $_SESSION[CS]['g_idt_obra'];
//$Filtro['LinhaUm'] = ' Selecione um Or�amento ';
$Filtro['id'] = 'idt';
$Filtro['nome'] = 'Or�amentos';
$Filtro['js'] = "style='width:400px;'".$par_auto;

$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['orcamentos'] = $Filtro;



$Filtro = Array();
$Filtro['rs'] = 'Texto';
$Filtro['id'] = 'classificacao';
$Filtro['nome'] = 'Classifica��o';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['texto'] = $Filtro;




//echo '<form name="frm" target="_self" action="conteudo.php?'.substr(getParametro($strPara),1).'" method="post">';


if ($_GET['print'] != 's') {
    $Focus = '';
    codigo_filtro(false,true);
    onLoadPag($Focus);
}

$nivel1w='3';

$sql  = 'select ';
$sql .= '  oo.idt, ';
$sql .= '  oi.idt            as oi_idt, ';
$sql .= '  oi.classificacao  as oi_classificacao, ';
$sql .= '  oi.descricao      as oi_descricao, ';
$sql .= '  oi.tipo_item      as oi_tipo_item, ';
$sql .= '  oi.natureza       as oi_natureza, ';
$sql .= '  oi.grau           as oi_grau, ';
$sql .= '  oo.quantidade     as oo_quantidade,  ';
$sql .= '  oo.percentual     as oo_percentual,  ';
$sql .= '  oo.valor_unitario as oo_valor_unitario,  ';
$sql .= '  oo.valor_total    as oo_valor_total,  ';
$sql .= '  um.codigo         as um_codigo,  ';
$sql .= '  um.descricao as um_descricao  ';
$sql .= 'from orcamento_item oi ';
$sql .= 'left  join unidade_medida um on um.idt  = oi.idt_unidade_medida ';
$sql .= 'left  join orcamento_obra oo on oi.idt  = oo.idt_orcamento_item ';

$sql .= ' where oo.idt_empreendimento= '.null($vetFiltro['empreendimento']['valor']);
$sql .= '   and oo.idt_orcamentos_empreendimento= '.null($vetFiltro['orcamentos']['valor']);

//$sql .= '   and oi.tipo_item = '.aspa('T');
$sql .= '   and oi.grau <= '.$nivel1w;
//$sql .= '   and substring(oi.classificacao,1,1)= '.aspa($nivel1w);

if ($vetFiltro['texto']['valor']!='')
{
    $sql .= '   and oi.classificacao like  '.aspa('%'.$vetFiltro['texto']['valor'].'%');
}


$sql .= ' order by oi.classificacao';
$rs = execsql($sql);
if ($rs->rows == 0)
{
}





if ($_GET['print'] != 's') {
    echo " <div id='despesa_direta'> ";
}
else
{
    echo " <div id='despesa_direta' style='width:100%;'> ";
}

//echo "<div id='despesa_direta_c'> ";
//echo "</div>";


if ($_GET['print'] != 's') {
    echo " <div id='despesa_direta_1'> ";
}
else
{
    echo " <div id='despesa_direta_1' style='width:100%;'> ";
}

echo "<table class='despesa_direta_table' width='100%' border='0' cellspacing='0' cellpadding='0' vspace='0' hspace='0'> ";
echo "<tr class='despesa_direta_cab_tr'>  ";
echo "   <td class='despesa_direta_cab_td' >&nbsp;"."Classifica��o"."</td> ";
echo "   <td class='despesa_direta_cab_td' >&nbsp;"."Descri��o"."</td> ";
echo "   <td class='despesa_direta_cab_td_r' >&nbsp;"."Pre�o Total<br>(R$)"."</td> ";
echo "   <td class='despesa_direta_cab_td_r' >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"."Perc.(%)&nbsp;&nbsp;&nbsp;&nbsp;"."</td> ";
echo "</tr>";

$total=0;

ForEach($rs->data as $row) {
   $oi_classificacao   = $row['oi_classificacao'];
   $oi_descricao       = $row['oi_descricao'];
   $oi_natureza        = $row['oi_natureza'];
   $um_codigo          = $row['um_codigo'];
   $oi_grau            = $row['oi_grau'];
   $oo_quantidade      = format_decimal($row['oo_quantidade'],2);
   $oo_valor_unitario  = format_decimal($row['oo_valor_unitario']);
   $oo_valor_total     = format_decimal($row['oo_valor_total']);
   $oo_percentual      = format_decimal($row['oo_percentual'],2);
   echo "<tr  class='despesa_direta_linha_tr' >  ";
   //$vetniv = explode('.',$oi_classificacao);
   //$nivel  = count($vetniv)+1;
   //$tam    = ($nivel-1)*($nivel);
   $nivel  = $row['oi_grau'];
   $espaco = str_repeat("&nbsp;", $tam);
   $espaco = '';
   
   $classe  = 'despesa_direta_linha_td_t2';
   $classer = 'despesa_direta_linha_td_t2_r';

   
   if ($nivel==1)
   {
       $classe  = 'despesa_direta_linha_td_t';
       $classer = 'despesa_direta_linha_td_t_r';
       $total=$total + $row['oo_valor_total'];

   }
   if ($nivel==2)
   {
       $classe  = 'despesa_direta_linha_td_t1';
       $classer = 'despesa_direta_linha_td_t1_r';
   }
   echo "   <td class='{$classe}' >&nbsp;".$oi_classificacao."</td> ";
   echo "   <td class='{$classe}' >{$espaco}".$oi_descricao."</td> ";
   echo "   <td class='{$classer}' >".$oo_valor_total."</td> ";
   echo "   <td class='{$classer}' >".$oo_percentual." %</td> ";
   echo "</tr>";
}
// criar tabela
/*
   echo "<tr  class='despesa_direta_linha_tr' >  ";
   $classer = 'despesa_direta_linha_td_t_r';
   echo "   <td class='{$classer}' colspan='2' >Total:&nbsp;&nbsp;&nbsp; </td> ";
   echo "   <td class='{$classer}' >".format_decimal($total)."</td> ";
   echo "   <td class='{$classer}' >&nbsp;</td> ";
   echo "</tr>";
*/


echo "</table>";

echo " </div> ";

//echo "<div id='despesa_direta_r'> ";
//echo "</div>";

echo " </div> ";

if ($_GET['print'] != 's') {
}
else
{
    echo "<div style='height:25px; width:100%; background:#FF0000; display:block; '>";
    echo '&nbsp;&nbsp;<br />';
    echo '&nbsp;&nbsp;';
    echo "</div>";

}


//echo '</form>';





?>

