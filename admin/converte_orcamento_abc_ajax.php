
<style type="text/css">


div#despesa_direta {
    overflow:auto;
    xheight: 380px;
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
    sheight: 360px;
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

Require_Once('configuracao.php');
/*
function colocar_separador($texto)
{



    $textog=$texto;
    $textow='';
    $textow.=substr($textog,0,17).';';
    $textow.=substr($textog,18,13).';';
    $textow.=substr($textog,31,8).';';
    $textow.=substr($textog,39,103).';';
    $textow.=substr($textog,142,7).';';
    $textow.=substr($textog,149,15).';';
    $textow.=substr($textog,164,42).';';
    $textow.=substr($textog,206,18).';';
    $textow.=substr($textog,224,15).';';
    $textow.=substr($textog,239,11).';';
    return $textow;
}
*/

$empreendimento = $_POST['empreendimento'];
$orcamentos     = $_POST['orcamentos'];
//echo 'guy '.$empreendimento.' bete '.$orcamentos;
//exit();
if ($orcamentos=='')
{
    echo ' Atenção... Orçamento não informado '."<br />";
    echo ' IMPORTAÇÃO NÃO EXECUTADA. '."<br />";

    exit();
}
//$arquivo = "c:/oas_engenharia/orcamento/CurvaABC_Servicos.txt";
$sql  = 'select txt_orcamento, txt_abc_servico, txt_abc_insumo from orcamentos_empreendimento ';
$sql .= ' where idt= '.null($orcamentos);
$rs = execsql($sql);
if ($rs->rows == 0)
{
    echo ' Atenção... ERRO ao acessar registro do Orçamento '."<br />";
    echo ' IMPORTAÇÃO NÃO EXECUTADA. '."<br />";
    exit();
}
else
{
   ForEach ($rs->data as $row) {
      $txt_orcamento   = $row['txt_orcamento'];
      $txt_abc_servico = $row['txt_abc_servico'];
      $txt_abc_insumo  = $row['txt_abc_insumo'];
   }
}
if ($txt_abc_servico=='')
{
    echo ' Atenção... Arquivo TXT Curva ABC Serviço para IMPORTAÇÃO, NÃO INFORMADO. '."<br />";
    echo ' IMPORTAÇÃO NÃO EXECUTADA. '."<br />";
    exit();
}
if ($txt_abc_insumo=='')
{
    echo ' Atenção... Arquivo TXT Curva ABC Insumo para IMPORTAÇÃO, NÃO INFORMADO. '."<br />";
    echo ' IMPORTAÇÃO NÃO EXECUTADA. '."<br />";
    exit();
}


//$dirtxt   = "obj_file/importacao_txt/";

$dirtxt    = "obj_file/orcamentos_empreendimento/";

//$name_txt = "CurvaABC_Servicos.txt";
$name_txt = $txt_abc_servico;
$arquivo  = $dirtxt.$name_txt;

//$arquivo = "c:/oas_engenharia/orcamento/CurvaABC_Insumos.txt";
//$arquivo = "obj_file/importar_txt/CurvaABC_Servicos.txt";
if (!file_exists($arquivo))
{
    echo ' Atenção... Arquivo TXT para IMPORTAÇÃO, NÃO ENCONTRADO. '."<br />";
    echo ' Arquivo TXT : '.$arquivo;
    echo ' IMPORTAÇÃO NÃO EXECUTADA. '."<br />";
    exit();
}

echo '<br /><br />**** Inicio Conversão ABC Serviços ****'.'<br />';


$arquivo = file("$arquivo");
$vetlinha=Array();
foreach($arquivo as $texto) {
   $cpos=Array();
   $cpos=explode(';',$texto);
   $vetlinha[]=$cpos;
}
echo " <div id='despesa_direta'> ";

echo "<div id='despesa_direta_c'> ";
echo "</div>";

echo " <div id='despesa_direta_1'> ";

beginTransaction();

// excluir anterior

$sql_e  = ' delete from orcamento_abc_servico ';
$sql_e .= ' where idt_empreendimento =  '.null($empreendimento);
$sql_e .= '   and idt_orcamento_obra =  '.null($orcamentos);
$result = execsql($sql_e);

$klinn=0;
foreach($vetlinha as $cpos) {
     $cpos=$cpos;
     set_time_limit (90);
     if ($klinn<=1)
     {
         $klinn=$klinn+1;
         continue;
     }
     $klinn=$klinn+1;
     
     $idt_empreendimento            = $empreendimento;
     $idt_orcamentos_empreendimento = $orcamentos;

     $classificacao         = $cpos[0];
     $descricao             = aspa($cpos[1]);
     $unidade               = $cpos[2];
     $quantidade            = $cpos[3];
     $custo_unitario        = $cpos[4];
     $total                 = $cpos[5];
     $custo_acumulado       = $cpos[6];
     $percentual_item       = $cpos[7];
     $percentual_acumulado  = $cpos[8];
     $faixa                 = aspa($cpos[9]);


     $vetniveis = explode('.',$cpos[0]);
     $grau      = count($vetniveis);

     $class=aspa($cpos[0]);


     $idt_unidade_medida='NULL';


     echo ' Importando Classificação == '.$classificacao;



     $unidade=str_replace(' ','',$unidade);
     if ($unidade!='')
     {

         $sql  = 'select idt from unidade_medida ';
         $sql .= ' where codigo= '.aspa($unidade);
         $rs = execsql($sql);

         if ($rs->rows == 0)
         {

              $uni = aspa($unidade);
              $sql_i = ' insert into unidade_medida ';
              $sql_i .= '( codigo , descricao, classificacao)  values  ';
              $sql_i .= "($uni, $uni, '99' )";
              $result = execsql($sql_i);

              $sql  = 'select idt from unidade_medida ';
              $sql .= ' where codigo= '.$uni;
              $rs = execsql($sql);
              if ($rs->rows == 0)
              {
                  echo ' erro '.$unidade.'<br />';
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
     $sql .= ' where idt_empreendimento =  '.null($empreendimento);
     $sql .= ' and   classificacao      = '.$class;
     $rs = execsql($sql);

     if ($rs->rows == 0)
     {
          $idt_o  = null($empreendimento);
          $sql_i = ' insert into orcamento_item ';
          $sql_i .= '( idt_empreendimento, classificacao , descricao, idt_unidade_medida, tipo_item, natureza, grau )  values  ';
          $sql_i .= "( $idt_o, $class, $descricao, $idt_unidade_medida, $tipo_item, $natureza, $grau)";
          $result = execsql($sql_i);

          $sql  = 'select idt from orcamento_item ';
          $sql .= ' where idt_empreendimento =  '.null($empreendimento);
          $sql .= ' and   classificacao = '.$class;
          $rs = execsql($sql);
          if ($rs->rows == 0)
          {
              echo ' erro '.$unidade.'<br />';
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
     
     $vu=str_replace('.','',$custo_unitario);
     $vu=str_replace(',','.',$vu);
     $vu=str_replace(' ','',$vu);
     
     $vt=str_replace('.','',$total);
     $vt=str_replace(',','.',$vt);
     $vt=str_replace(' ','',$vt);
     
     $qt=str_replace('.','',$quantidade);
     $qt=str_replace(',','.',$qt);
     $qt=str_replace(' ','',$qt);
     
     $pi=str_replace('.','',$percentual_item);
     $pi=str_replace(',','.',$pi);
     $pi=str_replace(' ','',$pi);
     $pi=str_replace('%','',$pi);
     
     $pa=str_replace('.','',$percentual_acumulado);
     $pa=str_replace(',','.',$pa);
     $pa=str_replace(' ','',$pa);
     $pa=str_replace('%','',$pa);

     $ca=str_replace('.','',$custo_acumulado);
     $ca=str_replace(',','.',$ca);
     $ca=str_replace(' ','',$ca);


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
     if ($pi=='')
     {
         $pi='NULL';
     }
     if ($pa=='')
     {
         $pa='NULL';
     }
     if ($ca=='')
     {
         $ca='NULL';
     }

     $classificacao = aspa($classificacao);
     $unidade       = aspa($unidade);

     $flag = aspa('S');
     $sql_i  = ' insert into orcamento_abc_servico ';
     $sql_i .= '( idt_empreendimento, idt_orcamento_obra, classificacao , descricao ,unidade, quantidade, custo_unitario, total, custo_acumulado, percentual_item, percentual_acumulado , faixa )  values  ';
     $sql_i .= "( $idt_empreendimento, $idt_orcamentos_empreendimento, $classificacao, $descricao , $unidade , $qt, $vu, $vt, $ca, $pi, $pa, $faixa)";
     $result = execsql($sql_i);
     
     echo "<span style='color:#000000; '> -----> OK.</span><br />";

     
}

echo '<br />**** Fim Normal da Conversão ABC Serviços ****'.'<br />';

echo "<div id='despesa_direta_r'> ";
echo "</div>";

echo " </div> ";

echo " </div> ";

// insumos

//$arquivo = "c:/oas_engenharia/orcamento/CurvaABC_Insumos.txt";

//$name_txt = "CurvaABC_Insumos.txt";


echo '<br /><br />**** Inicio Conversão ABC Insumo ****'.'<br />';


$name_txt = $txt_abc_insumo;
$arquivo  = $dirtxt.$name_txt;

$arquivo = file("$arquivo");
$vetlinha=Array();
foreach($arquivo as $texto) {
   $cpos=Array();
   $cpos=explode(';',$texto);
   $vetlinha[]=$cpos;
}
echo " <div id='despesa_direta'> ";

echo "<div id='despesa_direta_c'> ";
echo "</div>";

echo " <div id='despesa_direta_1'> ";

// excluir anterior

$sql_e  = ' delete from orcamento_abc_insumo ';
$sql_e .= ' where idt_empreendimento =  '.null($empreendimento);
$sql_e .= '   and idt_orcamento_obra =  '.null($orcamentos);
$result = execsql($sql_e);



$klinn=0;
foreach($vetlinha as $cpos) {
     $cpos=$cpos;
     set_time_limit (90);
     if ($klinn<=1)
     {
         $klinn=$klinn+1;
         continue;
     }
     $klinn=$klinn+1;

     $idt_empreendimento            = $empreendimento;
     $idt_orcamentos_empreendimento = $orcamentos;

     $codigo                = $cpos[0];
     $classificacao         = $cpos[1];
     $descricao             = aspa($cpos[2]);
     $unidade               = $cpos[3];
     $quantidade            = $cpos[4];
     $custo_unitario        = $cpos[5];
     $total                 = $cpos[6];
     $custo_acumulado       = $cpos[7];
     $percentual_item       = $cpos[8];
     $percentual_acumulado  = $cpos[9];
     $faixa                 = aspa($cpos[10]);
     $preco_unitario_praticado = $custo_unitario;
     $percentual_praticado     = 1;

     $vetniveis = explode('.',$cpos[1]);
     $grau      = count($vetniveis);

     $class=aspa($cpos[1]);

     echo ' Importando Classificação == '.$classificacao.' Código == '.$codigo;


     $idt_unidade_medida='NULL';

     $unidade=str_replace(' ','',$unidade);
     if ($unidade!='')
     {

         $sql  = 'select idt from unidade_medida ';
         $sql .= ' where codigo= '.aspa($unidade);
         $rs = execsql($sql);

         if ($rs->rows == 0)
         {

              $uni = aspa($unidade);
              $sql_i = ' insert into unidade_medida ';
              $sql_i .= '( codigo , descricao, classificacao)  values  ';
              $sql_i .= "($uni, $uni, '99' )";
              $result = execsql($sql_i);

              $sql  = 'select idt from unidade_medida ';
              $sql .= ' where codigo= '.$uni;
              $rs = execsql($sql);
              if ($rs->rows == 0)
              {
                  echo ' erro '.$unidade.'<br />';
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
  /*
     $sql  = 'select idt from orcamento_item ';
     $sql .= ' where classificacao = '.$class;
     $rs = execsql($sql);

     if ($rs->rows == 0)
     {
          $sql_i = ' insert into orcamento_item ';
          $sql_i .= '( classificacao , descricao, idt_unidade_medida, tipo_item, natureza, grau )  values  ';
          $sql_i .= "($class, $descricao, $idt_unidade_medida, $tipo_item, $natureza, $grau)";
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
 */
     $vu=str_replace('.','',$custo_unitario);
     $vu=str_replace(',','.',$vu);
     $vu=str_replace(' ','',$vu);

     $vt=str_replace('.','',$total);
     $vt=str_replace(',','.',$vt);
     $vt=str_replace(' ','',$vt);

     $qt=str_replace('.','',$quantidade);
     $qt=str_replace(',','.',$qt);
     $qt=str_replace(' ','',$qt);

     $pi=str_replace('.','',$percentual_item);
     $pi=str_replace(',','.',$pi);
     $pi=str_replace(' ','',$pi);
     $pi=str_replace('%','',$pi);

     $pa=str_replace('.','',$percentual_acumulado);
     $pa=str_replace(',','.',$pa);
     $pa=str_replace(' ','',$pa);
     $pa=str_replace('%','',$pa);

     $ca=str_replace('.','',$custo_acumulado);
     $ca=str_replace(',','.',$ca);
     $ca=str_replace(' ','',$ca);


     $pup=str_replace('.','',$preco_unitario_praticado);
     $pup=str_replace(',','.',$pup);
     $pup=str_replace(' ','',$pup);


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
     if ($pi=='')
     {
         $pi='NULL';
     }
     if ($pa=='')
     {
         $pa='NULL';
     }
     if ($ca=='')
     {
         $ca='NULL';
     }
     if ($pup=='')
     {
         $pup='NULL';
     }

     $classificacao = aspa($classificacao);
     $unidade       = aspa($unidade);

     $flag = aspa('S');
     $sql_i  = ' insert into orcamento_abc_insumo ';
     $sql_i .= '( idt_empreendimento, idt_orcamento_obra, classificacao , descricao ,unidade, quantidade, custo_unitario, total, custo_acumulado, percentual_item, percentual_acumulado , faixa, preco_unitario_praticado, percentual_praticado )  values  ';
     $sql_i .= "( $idt_empreendimento, $idt_orcamentos_empreendimento, $classificacao, $descricao , $unidade , $qt, $vu, $vt, $ca, $pi, $pa, $faixa , $pup, $percentual_praticado)";
     $result = execsql($sql_i);
     
     echo "<span style='color:#000000; '> -----> OK.</span><br />";

     
}

commit();

echo '<br />**** Fim Normal da Conversão ABC Insumo ****'.'<br />';

echo "<div id='despesa_direta_r'> ";
echo "</div>";

echo " </div> ";

echo " </div> ";






?>

