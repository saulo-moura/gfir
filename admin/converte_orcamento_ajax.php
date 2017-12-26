
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


$empreendimento = $_POST['empreendimento'];
$orcamentos     = $_POST['orcamentos'];
//echo 'guy '.$empreendimento.' bete '.$orcamentos;
//exit();
if ($orcamentos=='')
{
    echo ' Aten��o... Or�amento n�o informado '."<br />";
    echo ' IMPORTA��O N�O EXECUTADA. '."<br />";
    exit();
}

$sql  = 'select txt_orcamento, txt_abc_servico, txt_abc_insumo from orcamentos_empreendimento ';
$sql .= ' where idt= '.null($orcamentos);
$rs = execsql($sql);
if ($rs->rows == 0)
{
    echo ' Aten��o... ERRO ao acessar registro do Or�amento '."<br />";
    echo ' IMPORTA��O N�O EXECUTADA. '."<br />";
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
if ($txt_orcamento=='')
{
    echo ' Aten��o... Arquivo TXT para IMPORTA��O, N�O INFORMADO. '."<br />";
    echo ' IMPORTA��O N�O EXECUTADA. '."<br />";
    exit();
}


//$arquivo = "obj_file/importar_txt/or�amento analitico.txt";

$dirtxt    = "obj_file/orcamentos_empreendimento/";


//$name_txt  = "or�amento analitico.txt";
$name_txt  = $txt_orcamento;

$arquivo   = $dirtxt.$name_txt;

$modelo=2;


if (!file_exists($arquivo))
{
    echo ' Aten��o... Arquivo TXT para IMPORTA��O, N�O ENCONTRADO. '."<br />";
    echo ' Arquivo TXT : '.$arquivo."<br />";
    echo ' IMPORTA��O N�O EXECUTADA. '."<br />";
    exit();
}

$arquivo = file("$arquivo");
$vetlinha=Array();
if ($modelo==1)
{
    foreach($arquivo as $texto) {

       $textow=colocar_separador($texto);
       $cpos=Array();
       $cpos=explode(';',$textow);
       $vetlinha[]=$cpos;
    }
}
else
{
    foreach($arquivo as $texto) {
       $cpos=Array();
       $cpos=explode(';',$texto);
       $vetlinha[]=$cpos;
    }
}
//p($vetlinha);
//exit();


echo " <div id='despesa_direta'> ";

echo "<div id='despesa_direta_c'> ";
echo "</div>";

echo " <div id='despesa_direta_1'> ";

beginTransaction();

// excluir anterior

$sql_e  = ' delete from orcamento_obra ';
$sql_e .= ' where idt_empreendimento =  '.null($empreendimento);
$sql_e .= '   and idt_orcamentos_empreendimento =  '.null($orcamentos);
$result = execsql($sql_e);


$klinn=0;
foreach($vetlinha as $cpos) {
     $cpos=$cpos;
     set_time_limit (90);
     if ($klinn<=0)
     {
         $klinn=$klinn+1;
         continue;
     }
     $klinn=$klinn+1;
     
     $idt_empreendimento            = $empreendimento;
     $idt_orcamentos_empreendimento = $orcamentos;

     if ($modelo==1)
     {
         $classificacao = $cpos[0];
         $alternativo   = aspa($cpos[1]);
         $insumo        = aspa($cpos[2]);
         $descricao     = aspa($cpos[3]);
         $unidade       = $cpos[4];
         $quantidade    = $cpos[5];
     
         $unitario      = $cpos[7];
         $total         = $cpos[8];
         $percentual    = $cpos[9];


         $vetniveis = explode('.',$cpos[0]);
         $grau      = count($vetniveis);
         $class=aspa($cpos[0]);
     }
     else
     {
         $classificacao = $cpos[0];
         $descricao     = aspa($cpos[1]);
         $unidade       = $cpos[2];
         $quantidade    = $cpos[3];
         $unitario      = $cpos[4];
         $total         = $cpos[5];
         $percentual    = $cpos[6];
         

         
         
         
         $alternativo   = '';
         $insumo        = '';



         $vetniveis = explode('.',$cpos[0]);
         $grau      = count($vetniveis);
         $class=aspa($cpos[0]);
     }

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
     
     $natureza = aspa('S');
     
     $sql  = 'select idt from orcamento_item ';
     $sql .= ' where idt_empreendimento =  '.null($empreendimento);
     $sql .= ' and   classificacao      = '.$class;
     $rs = execsql($sql);
     echo ' Importando Classifica��o == '.$class;
     if ($rs->rows == 0)
     {
          $idt_o  = null($empreendimento);
          $sql_i  = ' insert into orcamento_item ';
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
     
     $vu=str_replace('.','',$unitario);
     $vu=str_replace(',','.',$vu);
     $vu=str_replace(' ','',$vu);
     
     $vt=str_replace('.','',$total);
     $vt=str_replace(',','.',$vt);
     $vt=str_replace(' ','',$vt);
     
     $qt=str_replace('.','',$quantidade);
     $qt=str_replace(',','.',$qt);
     $qt=str_replace(' ','',$qt);
     
     $per=str_replace('.','',$percentual);
     $per=str_replace(',','.',$per);
     $per=str_replace(' ','',$per);
     $per=str_replace('%','',$per);

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
     if ($per=='')
     {
         $per='NULL';
     }

     $flag = aspa('S');
     
     $sql_i  = ' insert into orcamento_obra ';
     $sql_i .= '( idt_empreendimento, idt_orcamentos_empreendimento, idt_orcamento_item ,quantidade, valor_unitario, valor_total, flag, percentual )  values  ';
     $sql_i .= "( $idt_empreendimento, $idt_orcamentos_empreendimento, $idt_orcamento_item, $qt, $vu, $vt, $flag , $per)";
     $result = execsql($sql_i);
     
     echo "<span style='color:#000000; '> -----> OK.</span><br />";

}

commit();

echo '<br />**** Fim Normal da Convers�o ****'.'<br />';

echo "<div id='despesa_direta_r'> ";
echo "</div>";

echo " </div> ";

echo " </div> ";

?>

