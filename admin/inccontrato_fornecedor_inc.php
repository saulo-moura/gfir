
<style type="text/css">


div#contrato {
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


div#contrato_1 {
    overflow:auto;
    height: 360px;
    width : 670px;
    float:left;
    font-family : Arial, Helvetica, sans-serif;
    font-style: normal;
    font-size: 12px;
    font-weight: bold;
    color:#FF5959;
    padding:0px;
    background: #FFFFFF;
}


table.contrato_table{
    font-family : Arial, Helvetica, sans-serif;
    font-style: normal;
    font-size: 12px;
    font-weight: normal;
    color:#000000;
    background: #EFEFEF;
    background: #A2A2A2;
}

tr.contrato_table_tr {


}
td.contrato_titulo_td {
    font-weight : bold;
    color       : #FFFFFF;
    text-align  :center;
    padding-top :5px;
    padding-left:5px;
    border-bottom:1px solid #9D0000;
}
tr.contrato_cab_tr {

}
td.contrato_cab_td {
    font-weight :bold;
    color       :#FFFFFF;
    text-align  :left;
    padding-top :5px;
    padding-left:5px;
    border-bottom:1px solid #9D0000;
}

td.contrato_cab_td_r {
    font-weight :bold;
    color       :#FFFFFF;
    text-align  :left;
    padding-top :5px;
    padding-left:5px;
    border-bottom:1px solid #9D0000;
    text-align: right;
}

tr.contrato_linha_tr {

}
td.contrato_linha_td_t {
    font-weight   : normal;
    color         : #640000;
    background    : #EAEAEA;
    padding-top   : 5px;
    padding-left  : 5px;
    border-bottom : 1px solid #C0C0C0;
}

td.contrato_linha_td_t1 {
    font-weight   : normal;
    color         : #640000;
    background    : #EEEEEE;
    padding-top   : 5px;
    padding-left  : 5px;
    border-bottom : 1px solid #C0C0C0;
}

td.contrato_linha_td_t2 {
    font-weight   : normal;
    color         : #640000;
    background    : #F0F0F0;
    padding-top   : 5px;
    padding-left  : 5px;
    border-bottom : 1px solid #C0C0C0;
}

td.contrato_linha_td_t3 {
    font-weight   : normal;
    color         : #640000;
    background    : #F0F0F0;
    padding-top   : 5px;
    padding-left  : 5px;
    border-bottom : 1px solid #C0C0C0;
}


td.contrato_linha_td_t_r {
    font-weight   : bold;
    color         : #640000;
    background    : #EAEAEA;
    padding-top   : 5px;
    padding-left  : 5px;
    border-bottom : 1px solid #C0C0C0;
    text-align    : right;
}

td.contrato_linha_td_t1_r {
    font-weight   : bold;
    color         : #640000;
    background    : #EEEEEE;
    padding-top   : 5px;
    padding-left  : 5px;
    border-bottom : 1px solid #C0C0C0;
    text-align    : right;
}

td.contrato_linha_td_t2_r {
    font-weight   : bold;
    color         : #640000;
    background    : #F0F0F0;
    padding-top   : 5px;
    padding-left  : 5px;
    border-bottom : 1px solid #C0C0C0;
    text-align    : right;
}

td.contrato_linha_td_t3_r {
    font-weight   : bold;
    color         : #640000;
    background    : #F0F0F0;
    padding-top   : 5px;
    padding-left  : 5px;
    border-bottom : 1px solid #C0C0C0;
    text-align    : right;
}



td.contrato_linha_td_a {
    font-weight :normal;
    color       :#575757;
    background  :#FFFFFF;
    padding-top :5px;
    padding-left:5px;
    border-bottom : 1px solid #C0C0C0;
}

td.contrato_linha_td_a_r {
    font-weight : bold;
    color       :#575757;
    background  :#FFFFFF;
    padding-top :5px;
    padding-left:5px;
    border-bottom : 1px solid #C0C0C0;
    text-align    : right;
}

div#contrato_c {
    background:#FFCCCC;
    background:#FFFFFF;
    width : 680px;
    height:10px;
    margin:0px;
}

div#contrato_r {
    background:#FFCCCC;
    background:#FFFFFF;
    width : 680px;
    height:10px;
    margin:0px;
    float:left;
}


</style>


<?php

/*
$sql     = 'select  idt, estado, descricao from empreendimento ';
$sql    .= '    order by estado, descricao ';
$Filtro  = Array();
$Filtro['rs'] = execsql($sql);
$Filtro['vlPadrao'] = $_SESSION[CS]['g_idt_obra'];
$Filtro['id'] = 'idt';
$Filtro['nome'] = 'Empreendimento';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['empreendimento'] = $Filtro;
*/

$sql     = 'select  distinct fo.idt , fo.razao_social from fornecedor fo ';
$sql    .= ' inner join contrato co on co.idt_fornecedor = fo.idt ';
$sql    .= '    order by fo.razao_social ';
$Filtro  = Array();
$Filtro['rs'] = execsql($sql);
$Filtro['LinhaUm'] = ' Listar Todos os Fornecedores ';
$Filtro['id'] = 'idt';
$Filtro['nome'] = 'Fornecedores';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['fornecedor'] = $Filtro;



echo '<form name="frm" target="_self" action="conteudo.php?'.substr(getParametro($strPara),1).'" method="post">';


$Focus = '';
codigo_filtro(false);
onLoadPag($Focus);


$sql   = 'select ';
$sql  .= '  co.idt            as co_idt, ';
$sql  .= '  co.numero         as co_numero, ';
$sql  .= '  co.valor_contrato as co_valor_contrato, ';
$sql  .= '  co.valor_aditivo  as co_valor_aditivo, ';
$sql  .= '  co.valor_pago     as co_valor_pago, ';
$sql  .= '  cs.descricao      as cs_descricao,   ';

$sql  .= '  fo.fantasia      as fo_fantasia, ';
$sql  .= '  fo.razao_social  as fo_razao_social, ';
$sql  .= '  oi.descricao     as oi_descricao, ';
$sql  .= '  csi.imagem        as csi_imagem,   ';
$sql  .= '  css.imagem       as css_imagem   ';
$sql  .= '  from contrato co ';
$sql  .= '  inner join fornecedor        fo  on fo.idt           = co.idt_fornecedor ';
$sql  .= '  left  join contrato_servico  cs  on cs.idt_contrato  = co.idt ';
$sql  .= '  left  join orcamento_item    oi  on oi.idt           = cs.idt_orcamento_item ';
$sql  .= '  left  join contrato_status   css on css.idt          = cs.idt_status_conclusao ';
$sql  .= '  inner join contrato_situacao csi on csi.idt          = co.idt_situacao ';
$sql  .= '  inner join contrato_tipo     ct  on ct.idt           = co.idt_tipo     ';

$sql .= ' where ';
$sql .= '    co.idt_empreendimento = '.null($_SESSION[CS]['g_idt_obra']);

if ($vetFiltro['fornecedor']['valor']!=-1)
{
    $sql .= ' and ';
    $sql .= '   co.idt_fornecedor = '.null($vetFiltro['fornecedor']['valor']);
}
$sql .= ' order by fo.razao_social ';
$rs = execsql($sql);

if ($rs->rows == 0)
{
}
echo " <div id='contrato'> ";

//echo "<div id='contrato_c'> ";
//echo "</div>";

echo " <div id='contrato_1'> ";

echo "<table class='contrato_table' width='100%' border='0' cellspacing='0' cellpadding='0' vspace='0' hspace='0'> ";
echo "<tr class='contrato_cab_tr'>  ";
echo "   <td class='contrato_cab_td' >&nbsp;"."NÚMERO<br>CONTRATO"."</td> ";
echo "   <td class='contrato_cab_td' >&nbsp;"."EMPRESA"."</td> ";
echo "   <td class='contrato_cab_td' >&nbsp;"."SERVIÇO"."</td> ";
echo "   <td class='contrato_cab_td_r' >&nbsp;"."VALOR CONTRATO<br>(R$)"."</td> ";
echo "   <td class='contrato_cab_td_r' >&nbsp;"."VALOR ADITIVO<br>(R$)"."</td> ";
echo "   <td class='contrato_cab_td_r' >&nbsp;"."VALOR PAGO<br>(R$)"."</td> ";
echo "   <td class='contrato_cab_td_r' >&nbsp;"."SALDO<br>(R$)"."</td> ";
echo "</tr>";
$idt_contrato=0;
$separa='';
$oi_descricao_ac='';
ForEach($rs->data as $row) {
   if ($idt_contrato!=$row['co_idt'] and $idt_contrato!=0)
   {
       echo "<tr  class='contrato_linha_tr' >  ";
       $classe='contrato_linha_td_a';
       $classer='contrato_linha_td_a_r';
       echo "   <td class='{$classe}' >".$co_numero."</td> ";
       echo "   <td class='{$classe}' >".$fo_razao_social."</td> ";
       echo "   <td class='{$classe}' >".$oi_descricao_ac."</td> ";

       $saldo = ($row['co_valor_contrato'] + $row['co_valor_aditivo']) - $row['co_valor_pago'];
       $saldo_e = format_decimal($saldo);

       echo "   <td class='{$classer}' >".$co_valor_contrato."</td> ";
       echo "   <td class='{$classer}' >".$co_valor_aditivo."</td> ";
       echo "   <td class='{$classer}' >".$co_valor_pago."</td> ";
       echo "   <td class='{$classer}' >".$saldo_e."</td> ";
       echo "</tr>";
       $separa='';
       $oi_descricao_ac='';
   }
   $idt_contrato       = $row['co_idt'];
   $co_numero          = $row['co_numero'];
   $fo_razao_social    = $row['fo_fantasia'];
   $oi_descricao       = $row['oi_descricao'];
   $cs_descricao       = $row['cs_descricao'];
   $co_valor_contrato  = format_decimal($row['co_valor_contrato']);
   $co_valor_aditivo   = format_decimal($row['co_valor_aditivo']);
   $co_valor_pago      = format_decimal($row['co_valor_pago']);
   $oi_descricao       = $oi_descricao.' - '.$cs_descricao;
   $oi_descricao_ac    = $oi_descricao_ac.$separa.$oi_descricao;
   $separa='<br>';

}

if ($idt_contrato!=0)
{
    echo "<tr  class='contrato_linha_tr' >  ";
    $classe='contrato_linha_td_a';
    $classer='contrato_linha_td_a_r';
    echo "   <td class='{$classe}' >".$co_numero."</td> ";
    echo "   <td class='{$classe}' >".$fo_razao_social."</td> ";
    echo "   <td class='{$classe}' >".$oi_descricao_ac."</td> ";
    $saldo = ($row['co_valor_contrato'] + $row['co_valor_aditivo']) - $row['co_valor_pago'];
    $saldo_e = format_decimal($saldo);

    echo "   <td class='{$classer}' >".$co_valor_contrato."</td> ";
    echo "   <td class='{$classer}' >".$co_valor_aditivo."</td> ";
    echo "   <td class='{$classer}' >".$co_valor_pago."</td> ";
    echo "   <td class='{$classer}' >".$saldo_e."</td> ";
    echo "</tr>";
}

echo "</table>";

echo " </div> ";

//echo "<div id='contrato_r'> ";
//echo "</div>";

echo " </div> ";

$url_volta = 'conteudo'.$cont_arq.'.php';
echo ' <div id="voltar_full_m">';
echo ' <div class="voltar">';
echo '         <img src="imagens/menos_full_PCO.jpg" title="Voltar"  alt="Voltar" border="0" onclick="self.location = '."'".$url_volta."'".'" style="cursor: pointer;">';
echo ' </div>';
echo ' </div>';

echo '</form>';

?>

