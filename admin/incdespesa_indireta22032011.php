
<style type="text/css">


div#despesa_direta {
    overflow:auto;
    height: 380px;
    width : 680px;
    float:left;
    font-family : Arial, Helvetica, sans-serif;
    font-style: normal;
    font-size: 12px;
    font-weight: bold;
    color:#FF5959;
    background: #FFFFFF;
    margin-top:0px;
}


div#despesa_direta_1 {
    overflow:auto;
    height: 360px;
    width : 680px;
    float:left;
    font-family : Arial, Helvetica, sans-serif;
    font-style: normal;
    font-size: 12px;
    font-weight: bold;
    color:#FF5959;
    padding:0px;
    background: #FFFFFF;
}


table.despesa_direta_table{
    font-family : Arial, Helvetica, sans-serif;
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
    font-weight :bold;
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
    font-weight   : normal;
    color         : #640000;
    background    : #EAEAEA;
    padding-top   : 5px;
    padding-left  : 5px;
    border-bottom : 1px solid #C0C0C0;
}

td.despesa_direta_linha_td_t1 {
    font-weight   : normal;
    color         : #640000;
    background    : #EEEEEE;
    padding-top   : 5px;
    padding-left  : 5px;
    border-bottom : 1px solid #C0C0C0;
}

td.despesa_direta_linha_td_t2 {
    font-weight   : normal;
    color         : #640000;
    background    : #F0F0F0;
    padding-top   : 5px;
    padding-left  : 5px;
    border-bottom : 1px solid #C0C0C0;
}


td.despesa_direta_linha_td_t_r {
    font-weight   : bold;
    color         : #640000;
    background    : #EAEAEA;
    padding-top   : 5px;
    padding-left  : 5px;
    border-bottom : 1px solid #C0C0C0;
    text-align    : right;
}

td.despesa_direta_linha_td_t1_r {
    font-weight   : bold;
    color         : #640000;
    background    : #EEEEEE;
    padding-top   : 5px;
    padding-left  : 5px;
    border-bottom : 1px solid #C0C0C0;
    text-align    : right;
}

td.despesa_direta_linha_td_t2_r {
    font-weight   : bold;
    color         : #640000;
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
    font-weight : bold;
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


</style>


<?php


$sql     = 'select  idt, estado, descricao from empreendimento ';
$sql    .= '    order by estado, descricao ';
$Filtro  = Array();
$Filtro['rs'] = execsql($sql);
$Filtro['vlPadrao'] = $_SESSION[CS]['g_idt_obra'];
$Filtro['id'] = 'idt';
$Filtro['nome'] = 'Empreendimento';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['empreendimento'] = $Filtro;


$sql     = 'select  idt, identificador from orcamentos_empreendimento ';
$sql    .= '    order by identificador ';
$Filtro  = Array();
$Filtro['rs'] = execsql($sql);
//$Filtro['vlPadrao'] = $_SESSION[CS]['g_idt_obra'];
$Filtro['id'] = 'idt';
$Filtro['nome'] = 'Orçamentos';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['orcamentos'] = $Filtro;



echo '<form name="frm" target="_self" action="conteudo.php?'.substr(getParametro($strPara),1).'" method="post">';


$Focus = '';
codigo_filtro(false);
onLoadPag($Focus);

$nivel1w='2';

$sql  = 'select ';
$sql .= '  oo.idt, ';
$sql .= '  oi.idt            as oi_idt, ';
$sql .= '  oi.classificacao  as oi_classificacao, ';
$sql .= '  oi.descricao      as oi_descricao, ';
$sql .= '  oi.tipo_item      as oi_tipo_item, ';
$sql .= '  oi.natureza       as oi_natureza, ';
$sql .= '  oo.quantidade     as oo_quantidade,  ';
$sql .= '  oo.valor_unitario as oo_valor_unitario,  ';
$sql .= '  oo.valor_total    as oo_valor_total,  ';
$sql .= '  um.codigo         as um_codigo,  ';
$sql .= '  um.descricao as um_descricao  ';
$sql .= 'from orcamento_item oi ';
$sql .= 'left  join unidade_medida um on um.idt  = oi.idt_unidade_medida ';
$sql .= 'left  join orcamento_obra oo on oi.idt  = oo.idt_orcamento_item ';

$sql .= ' where oo.idt_empreendimento= '.null($vetFiltro['empreendimento']['valor']);
$sql .= '   and oo.idt_orcamentos_empreendimento= '.null($vetFiltro['orcamentos']['valor']);

$sql .= '   and substring(oi.classificacao,1,1)= '.aspa($nivel1w);

$sql .= ' order by oi.classificacao';
$rs = execsql($sql);
if ($rs->rows == 0)
{
}
echo " <div id='despesa_direta'> ";

echo "<div id='despesa_direta_c'> ";
echo "</div>";

echo " <div id='despesa_direta_1'> ";

echo "<table class='despesa_direta_table' width='100%' border='0' cellspacing='0' cellpadding='0' vspace='0' hspace='0'> ";
echo "<tr class='despesa_direta_cab_tr'>  ";
//echo "   <td class='despesa_direta_cab_td' >&nbsp;"."Ítem"."</td> ";
echo "   <td class='despesa_direta_cab_td' >&nbsp;"."Descrição"."</td> ";
//echo "   <td class='despesa_direta_cab_td' >&nbsp;"."Nat."."</td> ";
echo "   <td class='despesa_direta_cab_td' >&nbsp;"."UN"."</td> ";
echo "   <td class='despesa_direta_cab_td_r' >&nbsp;"."Quantidade"."</td> ";
echo "   <td class='despesa_direta_cab_td_r' >&nbsp;"."Preço Unitário<br>(R$)"."</td> ";
echo "   <td class='despesa_direta_cab_td_r' >&nbsp;"."Preço Total<br>(R$)"."</td> ";
echo "</tr>";

ForEach($rs->data as $row) {
   $oi_classificacao   = $row['oi_classificacao'];
   $oi_descricao       = $row['oi_descricao'];
   $oi_natureza        = $row['oi_natureza'];
   $um_codigo          = $row['um_codigo'];
   $oo_quantidade      = format_decimal($row['oo_quantidade'],4);
   $oo_valor_unitario  = format_decimal($row['oo_valor_unitario']);
   $oo_valor_total     = format_decimal($row['oo_valor_total']);

   echo "<tr  class='despesa_direta_linha_tr' >  ";
   $vetniv = explode('.',$oi_classificacao);
   $nivel  = count($vetniv)+1;
   $tam    = ($nivel-1)*($nivel);

   $espaco = str_repeat("&nbsp;", $tam);
   $espaco = '';
   if ($row['oi_tipo_item']=='T')
   {
       //$nivel  = strlen($oi_classificacao);
       if ($nivel==1)
       {
           $classe='despesa_direta_linha_td_t';
           $classer='despesa_direta_linha_td_t_r';
       }
       if ($nivel==2)
       {
           $classe='despesa_direta_linha_td_t1';
           $classer='despesa_direta_linha_td_t1_r';
       }
       if ($nivel==3)
       {
           $classe='despesa_direta_linha_td_t2';
           $classer='despesa_direta_linha_td_t2_r';
       }

   }
   else
   {
       $classe='despesa_direta_linha_td_a';
       $classer='despesa_direta_linha_td_a_r';
   }
   //echo "   <td class='{$classe}' >&nbsp;".$oi_classificacao."</td> ";
   echo "   <td class='{$classe}' >{$espaco}".$oi_descricao."</td> ";
//   echo "   <td class='{$classe}' >&nbsp;".$oi_natureza."</td> ";
   echo "   <td class='{$classe}' >".$um_codigo."</td> ";
   echo "   <td class='{$classer}' >".$oo_quantidade."</td> ";
   echo "   <td class='{$classer}' >".$oo_valor_unitario."</td> ";
   echo "   <td class='{$classer}' >".$oo_valor_total."</td> ";
   echo "</tr>";
}
echo "</table>";

echo " </div> ";

echo "<div id='despesa_direta_r'> ";
echo "</div>";

echo " </div> ";



echo '</form>';

?>

