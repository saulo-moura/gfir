
<style type="text/css">


div#despesa_direta {
    overflow:auto;
    height: 420px;
    width : 680px;
    float:left;
    font-family : Arial, Helvetica, sans-serif;
    font-style: normal;
    font-size: 11px;
    font-weight: bold;
    color:#FF5959;
    background: #FFFFFF;
    margin-top:0px;
}


div#despesa_direta_1 {
    overflow:auto;
    height: 400px;
    width : 680px;
    float:left;
    font-family : Arial, Helvetica, sans-serif;
    font-style: normal;
    font-size: 11px;
    font-weight: bold;
    color:#FF5959;
    padding:0px;
    background: #FFFFFF;
    sborder:1px solid #910000;
    sborder-top:1px solid #910000;
}


table.despesa_direta_table{
    font-family : Arial, Helvetica, sans-serif;
    font-style: normal;
    font-size: 11px;
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






td.despesa_direta_linha_td_faixaa {
    font-weight   : bold;
    color         : #FFFFFF;
    background    : #FF0000;
    padding-top   : 5px;
    padding-left  : 5px;
    border-bottom : 1px solid #C0C0C0;
    text-align    : center;
}
td.despesa_direta_linha_td_faixab {
    font-weight   : bold;
    color         : #000000;
    background    : #E1E100;
    padding-top   : 5px;
    padding-left  : 5px;
    border-bottom : 1px solid #C0C0C0;
    text-align    : center;
}

td.despesa_direta_linha_td_faixac {
    font-weight   : bold;
    color         : #FFFFFF;
    background    : #00C632;
    padding-top   : 5px;
    padding-left  : 5px;
    border-bottom : 1px solid #C0C0C0;
    text-align    : center;
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

$total_geral=0;

$sql  = 'select sum(oo.valor_total) as total_geral ';
$sql .= ' from orcamento_obra oo ';
$sql .= 'left  join orcamento_item oi on oi.idt  = oo.idt_orcamento_item ';
$sql .= ' where oo.idt_empreendimento= '.null($vetFiltro['empreendimento']['valor']);
$sql .= '   and oo.idt_orcamentos_empreendimento= '.null($vetFiltro['orcamentos']['valor']);

$sql .= '   and oi.tipo_item = '.aspa('A');
$rs = execsql($sql);
if ($rs->rows == 0)
{
}
ForEach($rs->data as $row) {
   $total_geral=$row['total_geral'];
}

//echo $total_geral;


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

$sql .= '   and oi.tipo_item = '.aspa('A');
//$sql .= '   and substring(oi.classificacao,1,1)= '.aspa($nivel1w);

$sql .= ' order by oo.valor_total desc';
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
echo "   <td class='despesa_direta_cab_td' >&nbsp;".""."</td> ";
echo "   <td class='despesa_direta_cab_td' >"."Descrição"."</td> ";
echo "   <td class='despesa_direta_cab_td' >"."UN"."</td> ";
echo "   <td class='despesa_direta_cab_td_r' >"."Quant."."</td> ";
echo "   <td class='despesa_direta_cab_td_r' >"."Preço Unitário<br>(R$)"."</td> ";
echo "   <td class='despesa_direta_cab_td_r' >"."Preço Total<br>(R$)"."</td> ";
echo "   <td class='despesa_direta_cab_td_r' >"."Preço Acumulado<br>(R$)"."</td> ";
echo "   <td class='despesa_direta_cab_td_r' >"."%"."</td> ";
echo "   <td class='despesa_direta_cab_td_r' >"."% Acum."."</td> ";
echo "   <td class='despesa_direta_cab_td' >"."Faixa"."</td> ";
echo "</tr>";
$numitem=0;
$faixa_ant='1';
$valor_acumulado=0;
$percentual_acumulado=0;
ForEach($rs->data as $row) {
   $oi_classificacao   = $row['oi_classificacao'];
   $oi_descricao       = $row['oi_descricao'];
   $oi_natureza        = $row['oi_natureza'];
   $um_codigo          = $row['um_codigo'];
   $oo_quantidade      = format_decimal($row['oo_quantidade'],4);
   $oo_valor_unitario  = format_decimal($row['oo_valor_unitario'],2);
   $oo_valor_total     = format_decimal($row['oo_valor_total'],2);

   echo "<tr  class='despesa_direta_linha_tr' >  ";
   
   if ($row['oi_tipo_item']=='T')
   {
       $nivel=strlen($oi_classificacao);
       if ($nivel==1)
       {
           $classe='despesa_direta_linha_td_t';
       }
       if ($nivel==3)
       {
           $classe='despesa_direta_linha_td_t1';
       }
       if ($nivel==6)
       {
           $classe='despesa_direta_linha_td_t2';
       }

   }
   else
   {
       $classe='despesa_direta_linha_td_a';
       $classer='despesa_direta_linha_td_a_r';
   }
   
   $numitem=$numitem+1;
   $valor_acumulado  =$valor_acumulado+$row['oo_valor_total'];
   $valor_acumulado_e=format_decimal($valor_acumulado,2);
   
   $percentual=0;
   if ($total_geral!=0)
   {
       $percentual=($row['oo_valor_total']/$total_geral)*100;
   }
   $percentual_e=format_decimal($percentual,2);

   $percentual_acumulado=$percentual_acumulado+$percentual;
   $percentual_acumulado_e=format_decimal($percentual_acumulado,2);
   
   $faixa='C';
   $classef='despesa_direta_linha_td_faixac';
   if ($percentual_acumulado<50)
   {
       $faixa='A';
       $classef='despesa_direta_linha_td_faixaa';
   }
   else
   {
       if ($percentual_acumulado>=50 and $percentual_acumulado<80)
       {
           $faixa='B';
           $classef='despesa_direta_linha_td_faixab';
       }
   }
   if  ($faixa_ant!=$faixa)
   {
       $numitem=1;
       $faixa_ant=$faixa;
   }


   echo "   <td class='{$classef}' >&nbsp;".$numitem."</td> ";
   echo "   <td class='{$classe}' >&nbsp;".$oi_descricao."</td> ";
   echo "   <td class='{$classe}' >&nbsp;".$um_codigo."</td> ";
   echo "   <td class='{$classer}' >&nbsp;".$oo_quantidade."</td> ";
   echo "   <td class='{$classer}' >&nbsp;".$oo_valor_unitario."</td> ";
   echo "   <td class='{$classer}' >&nbsp;".$oo_valor_total."</td> ";
   echo "   <td class='{$classer}' >&nbsp;".$valor_acumulado_e."</td> ";
   echo "   <td class='{$classer}' >&nbsp;".$percentual_e."</td> ";
   echo "   <td class='{$classer}' >&nbsp;".$percentual_acumulado_e."</td> ";
   echo "   <td class='{$classef}' >&nbsp;".$faixa."</td> ";
   echo "</tr>";
}
echo "</table>";

echo " </div> ";

echo "<div id='despesa_direta_r'> ";
echo "</div>";

echo " </div> ";



echo '</form>';

?>

