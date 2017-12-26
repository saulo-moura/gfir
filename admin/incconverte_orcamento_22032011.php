
<style type="text/css">


div#despesa_direta {
    overflow:auto;
    height: 380px;
    width : 690px;
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
    width : 690px;
    float:left;
    font-family : Arial, Helvetica, sans-serif;
    font-style: normal;
    font-size: 12px;
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

td.despesa_direta_linha_td_a {
    font-weight :normal;
    color       :#575757;
    background  :#FFFFFF;
    padding-top :5px;
    padding-left:5px;
    border-bottom : 1px solid #C0C0C0;
}

div#despesa_direta_c {
    background:#FFCCCC;
    width : 690px;
    height:10px;
    margin:0px;
}

div#despesa_direta_r {
    background:#FFCCCC;
    width : 690px;
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
$Filtro['vlPadrao'] = 0;
$Filtro['id'] = 'idt';
$Filtro['nome'] = 'Orçamentos';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['orcamentos'] = $Filtro;

echo '<form name="frm" target="_self" action="conteudo.php?'.substr(getParametro($strPara),1).'" method="post">';


$Focus = '';
codigo_filtro(false);
onLoadPag($Focus);

$arquivo = "c:/oas_engenharia/orcamento.csv";
$arquivo = file("$arquivo");
$vetlinha=Array();
foreach($arquivo as $texto) {
   //     $li  =Array();
   //     $tam=strlen($texto);
   $cpos=Array();
   $cpos=explode(';',$texto);
   $vetlinha[]=$cpos;
}

echo " <div id='despesa_direta'> ";

echo "<div id='despesa_direta_c'> ";
echo "</div>";

echo " <div id='despesa_direta_1'> ";

$klinn=0;
foreach($vetlinha as $cpos) {
     $cpos=$cpos;
     set_time_limit (60);
     if ($klinn<=0)
     {
         $klinn=$klinn+1;
         continue;
     }
     $klinn=$klinn+1;
     
     $idt_empreendimento            = $vetFiltro['empreendimento']['valor'];
     $idt_orcamentos_empreendimento = $vetFiltro['orcamentos']['valor'];
     
     $classificacao = $cpos[0];
     $descricao     = aspa($cpos[1]);
     $unidade       = $cpos[2];
     $quantidade    = $cpos[3];
     $unitario      = $cpos[4];
     $total         = $cpos[5];


     $vetniveis = explode('.',$cpos[0]);
     $tam=count($vetniveis);
     $class='1.'.$vetniveis[0];
     if ($tam>1)
     {
         $class=$class.'.'.ZeroEsq($vetniveis[1],2);

     }
     if ($tam>2)
     {
         $class=$class.'.'.ZeroEsq($vetniveis[2],2);

     }
     if ($tam>3)
     {
         $class=$class.'.'.ZeroEsq($vetniveis[3],2);

     }
     if ($tam>4)
     {
         $class=$class.'.'.ZeroEsq($vetniveis[4],2);

     }
     
     $class=aspa($class);


     $idt_unidade_medida='NULL';

     if ($unidade!='')
     {

         $sql  = 'select idt from unidade_medida ';
         $sql .= ' where codigo= '.aspa($unidade);
         $rs = execsql($sql);

         if ($rs->rows == 0)
         {

              $uni=aspa($unidade);
              $sql_i = ' insert into unidade_medida ';
              $sql_i .= '( codigo , descricao, classificacao)  values  ';
              $sql_i .= "($uni, $uni, '99' )";
              $result = execsql($sql_i);

              $sql  = 'select idt from unidade_medida ';
              $sql .= ' where codigo= '.$uni;
              $rs = execsql($sql);
              if ($rs->rows == 0)
              {
                  echo ' erro '.$unidade;
                  $idt_unidade_medida=0;
              }
              else
              {
                 ForEach ($rs->data as $row) {
                    $idt_unidade_medida=$row['idt'];
                 }
              }


         }
         else
         {
             ForEach ($rs->data as $row) {
                 $idt_unidade_medida=$row['idt'];
             }
         }
         $tipo_item=aspa('A');
     
     }
     else
     {
         $tipo_item=aspa('T');
     }
     
     $natureza=aspa('S');
     
     $sql  = 'select idt from orcamento_item ';
     $sql .= ' where classificacao = '.$class;
     $rs = execsql($sql);

     if ($rs->rows == 0)
     {
          $sql_i = ' insert into orcamento_item ';
          $sql_i .= '( classificacao , descricao, idt_unidade_medida, tipo_item, natureza )  values  ';
          $sql_i .= "($class, $descricao, $idt_unidade_medida, $tipo_item, $natureza)";
          $result = execsql($sql_i);

          $sql  = 'select idt from orcamento_item ';
          $sql .= ' where classificacao = '.$class;
          $rs = execsql($sql);
          if ($rs->rows == 0)
          {
              echo ' erro '.$unidade;
              $idt_orcamento_item=0;
          }
          else
          {
             ForEach ($rs->data as $row) {
                $idt_orcamento_item=$row['idt'];
             }
          }


     }
     else
     {
         ForEach ($rs->data as $row) {
             $idt_orcamento_item=$row['idt'];
         }
     }
     $vu=str_replace('.','',$unitario);
     $vu=str_replace(',','.',$vu);
     $vt=str_replace('.','',$total);
     $vt=str_replace(',','.',$vt);
     
     $qt=str_replace('.','',$quantidade);
     $qt=str_replace(',','.',$qt);

     if ($vu=='')
     {
         $vu='NULL';
     }
     if ($qt=='')
     {
         $qt='NULL';
     }
     
     if ($vt=='')
     {
         $vt='NULL';
     }

     $flag=aspa('S');
     
     $sql_i  = ' insert into orcamento_obra ';
     $sql_i .= '( idt_empreendimento, idt_orcamentos_empreendimento, idt_orcamento_item ,quantidade, valor_unitario, valor_total, flag)  values  ';
     $sql_i .= "( $idt_empreendimento, $idt_orcamentos_empreendimento, $idt_orcamento_item, $qt, $vu, $vt, $flag)";
     $result = execsql($sql_i);
     
}

$class='1';
$descricao          = aspa('DESPESAS DIRETAS');
$idt_unidade_medida = 'NULL';
$natureza           = aspa('');
$tipo_item          = aspa('T');
$sql_i = ' insert into orcamento_item ';
$sql_i .= ' ( classificacao , descricao, idt_unidade_medida, tipo_item, natureza )  values  ';
$sql_i .= " ($class, $descricao, $idt_unidade_medida, $tipo_item, $natureza)";
$result = execsql($sql_i);

$class='2';
$descricao          = aspa('DESPESAS INDIRETAS');
$idt_unidade_medida = 'NULL';
$natureza           = aspa('');
$tipo_item          = aspa('T');
$sql_i = ' insert into orcamento_item ';
$sql_i .= ' ( classificacao , descricao, idt_unidade_medida, tipo_item, natureza )  values  ';
$sql_i .= " ($class, $descricao, $idt_unidade_medida, $tipo_item, $natureza)";
$result = execsql($sql_i);


echo ' Fim da Conversão';

echo "<div id='despesa_direta_r'> ";
echo "</div>";

echo " </div> ";

//echo "<div id='despesa_direta_r'> ";
//echo "</div>";

echo " </div> ";

echo '</form>';

?>

