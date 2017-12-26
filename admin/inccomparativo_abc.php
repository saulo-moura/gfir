
<style type="text/css">


div#despesa_direta {
    overflow:auto;
    sheight: 420px;
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
    sheight: 400px;
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
    color       : #000000;
    text-align  :center;
    padding-top :5px;
    padding-left:5px;
    border-bottom:1px solid #9D0000;
}
tr.despesa_direta_cab_tr {

}
td.despesa_direta_cab_td {
    background: #A8A8A8;
    font-weight :bold;
    color       :#EEEEEE;
    text-align  :left;
    padding-top :5px;
    padding-left:5px;
    border-bottom:1px solid #9D0000;
}
td.despesa_direta_cab_td_r {
    background: #A8A8A8;
    font-weight :bold;
    color       :#EEEEEE;
    text-align  :left;
    padding-top :5px;
    padding-left:5px;
    border-bottom:1px solid #9D0000;
    text-align: right;
}

tr.despesa_direta_linha_tr {

}


tr.despesa_direta_linha_tr_a {
   background:red;
}
tr.despesa_direta_linha_tr_b {
   background:yellow;
}
tr.despesa_direta_linha_tr_c {
   background:green;
}
td.despesa_direta_linha_td_t {
    font-weight   : normal;
    color         : #000000;
    sbackground    : #EAEAEA;
    padding-top   : 5px;
    padding-left  : 5px;
    border-bottom : 1px solid #C0C0C0;
}

td.despesa_direta_linha_td_t1 {
    font-weight   : normal;
    color         : #000000;
    sbackground    : #EEEEEE;
    padding-top   : 5px;
    padding-left  : 5px;
    border-bottom : 1px solid #C0C0C0;
}

td.despesa_direta_linha_td_t2 {
    font-weight   : normal;
    color         : #000000;
    sbackground    : #F0F0F0;
    padding-top   : 5px;
    padding-left  : 5px;
    border-bottom : 1px solid #C0C0C0;
}

td.despesa_direta_linha_td_t_r {
    font-weight   : normal;
    color         : #000000;
    sbackground    : #EAEAEA;
    padding-top   : 5px;
    padding-left  : 5px;
    border-bottom : 1px solid #C0C0C0;
    text-align    : right;
}


td.despesa_direta_linha_td_a {
    font-weight :normal;
    color       :#000000;
    sbackground  :#FFFFFF;
    padding-top :5px;
    padding-left:5px;
    border-bottom : 1px solid #C0C0C0;
}

td.despesa_direta_linha_td_a_r {
    font-weight : normal;
    color       :#000000;
    sbackground  :#FFFFFF;
    padding-top :5px;
    padding-left:5px;
    border-bottom : 1px solid #C0C0C0;
    text-align    : right;
}






td.despesa_direta_linha_td_faixaa {
    font-weight   : normal;
    color         : #000000;
    sbackground    : #FF0000;
    padding-top   : 5px;
    padding-left  : 5px;
    border-bottom : 1px solid #C0C0C0;
    text-align    : center;
}
td.despesa_direta_linha_td_faixab {
    font-weight   : normal;
    color         : #000000;
    sbackground    : #E1E100;
    padding-top   : 5px;
    padding-left  : 5px;
    border-bottom : 1px solid #C0C0C0;
    text-align    : center;
}

td.despesa_direta_linha_td_faixac {
    font-weight   : normal;
    color         : #000000;
    sbackground    : #00C632;
    padding-top   : 5px;
    padding-left  : 5px;
    border-bottom : 1px solid #C0C0C0;
    text-align    : center;
}

div#despesa_direta_c {
    sbackground:#FFCCCC;
    width : 680px;
    height:10px;
    margin:0px;
}

div#despesa_direta_r {
    sbackground:#FFCCCC;
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
$Filtro['vlPadrao'] = $_SESSION[CS]['g_idt_obra'];
//$Filtro['LinhaUm'] = ' Selecione um Orçamento ';
$Filtro['id'] = 'idt';
$Filtro['nome'] = 'Orçamentos';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['orcamentos'] = $Filtro;



echo '<form name="frm" target="_self" action="conteudo.php?'.substr(getParametro($strPara),1).'" method="post">';


$Focus = '';
codigo_filtro(false);
onLoadPag($Focus);

$sql  = 'select ';
$sql .= '  oai.* ';
$sql .= 'from orcamento_abc_insumo oai ';
$sql .= ' where oai.idt_empreendimento = '.null($vetFiltro['empreendimento']['valor']);
$sql .= '   and oai.idt_orcamento_obra = '.null($vetFiltro['orcamentos']['valor']);
$sql .= ' order by oai.total desc';
$rs = execsql($sql);
if ($rs->rows == 0)
{
    //exit();
}
echo " <div id='despesa_direta'> ";

//echo "<div id='despesa_direta_c'> ";
//echo "</div>";

echo " <div id='despesa_direta_1'> ";

echo "<table class='despesa_direta_table' width='100%' border='0' cellspacing='0' cellpadding='0' vspace='0' hspace='0'> ";
echo "<tr class='despesa_direta_cab_tr'>  ";
//echo "   <td class='despesa_direta_cab_td' >&nbsp;"."Ítem"."</td> ";
echo "   <td class='despesa_direta_cab_td' >"."Classificação"."</td> ";
echo "   <td class='despesa_direta_cab_td' >"."Descrição"."</td> ";
echo "   <td class='despesa_direta_cab_td' >"."UN"."</td> ";
echo "   <td class='despesa_direta_cab_td_r' >"."Quant."."</td> ";
echo "   <td class='despesa_direta_cab_td_r' >"."Custo Unitário<br>(R$)"."</td> ";
echo "   <td class='despesa_direta_cab_td_r' >"."Preço <br>Praticado<br>(R$)"."</td> ";
echo "   <td class='despesa_direta_cab_td_r' >"."Indice"."</td> ";
echo "   <td class='despesa_direta_cab_td_r' >"."%Item"."</td> ";
echo "   <td class='despesa_direta_cab_td_r' >"."%Acum."."</td> ";
echo "   <td class='despesa_direta_cab_td' >"."Faixa"."</td> ";
echo "</tr>";
$numitem=0;
$faixa_ant='1';
$valor_acumulado=0;
$percentual_acumulado=0;

$soma_cuni=0;
$soma_ppar=0;


ForEach($rs->data as $row) {
   $classificacao   = $row['classificacao'];
   $descricao       = $row['descricao'];
   $unidade         = $row['unidade'];
   $faixa           = $row['faixa'];

   $quantidade      = format_decimal($row['quantidade'],2);
   $custo_unitario  = format_decimal($row['custo_unitario'],2);
   $total           = format_decimal($row['total'],2);
   
   $custo_acumulado = format_decimal($row['custo_acumulado'],2);

   $percentual_item = format_decimal($row['percentual_item'],2);
   $percentual_acumulado      = format_decimal($row['percentual_acumulado'],2);

   $preco_unitario_praticado = format_decimal($row['preco_unitario_praticado'],2);
   $percentual_praticado     = format_decimal($row['percentual_praticado'],2);

   $soma_cuni=$soma_cuni+$row['custo_unitario'];
   $soma_ppar=$soma_ppar+$row['preco_unitario_praticado'];


   if ($faixa=='A')
   {
       echo "<tr  class='despesa_direta_linha_tr_a' >  ";
   }
   else
   {
       if ($faixa=='B')
       {
           echo "<tr  class='despesa_direta_linha_tr_b' >  ";
       }
       else
       {
           if ($faixa=='C')
           {
               echo "<tr  class='despesa_direta_linha_tr_c' >  ";
           }
           else
           {
               echo "<tr  class='despesa_direta_linha_tr' >  ";
           }
       }
   }
   $classe='despesa_direta_linha_td_a';
   $classer='despesa_direta_linha_td_a_r';
   if  ($faixa_ant!=$faixa)
   {
       $numitem=1;
       $faixa_ant=$faixa;
   }
   echo "   <td class='{$classe}' >&nbsp;".$classificacao."</td> ";
   echo "   <td class='{$classe}' >&nbsp;".$descricao."</td> ";
   echo "   <td class='{$classe}' >&nbsp;".$unidade."</td> ";
   echo "   <td class='{$classer}' >&nbsp;".$quantidade."</td> ";
   echo "   <td class='{$classer}' >&nbsp;".$custo_unitario."</td> ";
   echo "   <td class='{$classer}' >&nbsp;".$preco_unitario_praticado."</td> ";
   echo "   <td class='{$classer}' >&nbsp;".$percentual_praticado."</td> ";
   echo "   <td class='{$classer}' >&nbsp;".$percentual_item."</td> ";
   echo "   <td class='{$classer}' >&nbsp;".$percentual_acumulado."</td> ";
   echo "   <td class='{$classe}' >&nbsp;".$faixa."</td> ";
   echo "</tr>";
}


if ($soma_cuni>0)
{
   $perw = $soma_ppar/$soma_cuni;
   $pers = format_decimal($perw,4);
   echo "<tr  class='despesa_direta_linha_tr_a' >  ";
   echo "   <td class='{$classer}' colspan='6'>Indice Total:&nbsp;</td> ";
   echo "   <td class='{$classer}' >&nbsp;".$pers."</td> ";
   echo "   <td class='{$classer}' colspan='3'>&nbsp;</td> ";
   echo "</tr>";
}




echo "</table>";

echo " </div> ";

//echo "<div id='despesa_direta_r'> ";
//echo "</div>";

echo " </div> ";



echo '</form>';

?>

