<style type="text/css">

   td.linha_tabela {
        padding:0px;
        border:0px;
        margin:0px;
        font-size:11px;
        border-bottom:1px solid #C0C0C0;
    }

</style>
<?php

$vetFiltro = Array();
// Área de botões de controle --- Barra de Ferramentas
if ($_GET['print'] != 's') {
    echo "<div class='barra_ferramentas'>";
    echo "<table cellspacing='1' cellpadding='1' width='100%' border='1'>";
    echo "<tr>";
    echo "<td width='20'>";
    echo "<a HREF='conteudo.php'><img class='bartar' align=middle src='relatorio/voltar_ie.jpg'></a>";
    echo "</td>";
    echo "<td width='20'>";
    $titulo_rel = 'Estrutura de Processos';
    $str=$menu."&titulo_rel=".$titulo_rel;
    echo "<a HREF='#' onclick=\"return imprimir('$str');\"><img class='bartar' align=middle src='relatorio/visualiza_imprime.jpg'></a>";
    echo "</td>";
    $href = "relatorio/conteudo_excel_rel.php" ;
    echo "<td width='20'>";
    echo "<a HREF='{$href}'><img class='bartar' align=middle src='../imagens/excel.gif'></a>";
    echo "</td>";
 
    
    echo "<td>&nbsp;</td>";
    echo "</tr>";
    echo "</table>";
    echo "</div>";
}
//Monta o vetor de filtro
     // valores fixos
    $sql  = "select idt, descricao from plu_pl_requisitos_prioridade ";
    $sql .= " order by codigo";
    $rs   = execsql($sql);
    $Filtro = Array();
    $Filtro['rs'] = $rs;
    $Filtro['id'] = 'idt';
    $Filtro['LinhaUm'] = '-- Selecione a Prioridade --';
    $Filtro['nome'] = 'Prioridade do Requisito';
    $Filtro['valor'] = trata_id($Filtro);
    $vetFiltro['idt_prioridade'] = $Filtro;


    $sql  = "select idt, descricao from plu_pl_requisitos_classificacao ";
    $sql .= " order by codigo";
    $rs   = execsql($sql);
    $Filtro = Array();
    $Filtro['rs'] = $rs;
    $Filtro['id'] = 'idt';
    $Filtro['LinhaUm'] = '-- Selecione a Classificação --';
    $Filtro['nome'] = 'Classificação do Requisito';
    $Filtro['valor'] = trata_id($Filtro);
    $vetFiltro['idt_classificacao'] = $Filtro;



    $sql  = "select idt, descricao from plu_pl_projeto_natureza ";
    $sql .= " order by codigo";
    $rs   = execsql($sql);
    $Filtro = Array();
    $Filtro['rs'] = $rs;
    $Filtro['id'] = 'idt';
    $Filtro['LinhaUm'] = '-- Selecione a Natureza --';
    $Filtro['nome'] = 'Natureza';
    $Filtro['valor'] = trata_id($Filtro);
    $vetFiltro['idt_natureza'] = $Filtro;


    
    $strWhere = '';

    if ($vetFiltro['idt_prioridade']['valor']!=-1)
    {
        $strWhere = ' Where  plu_pl_req.idt_prioridade = '.$vetFiltro['idt_prioridade']['valor'];
    }
    
    if ($vetFiltro['idt_classificacao']['valor']!=-1)
    {
        if ($strWhere == '')
        {
            $strWhere = ' Where  plu_pl_req.idt_classificacao = '.$vetFiltro['idt_classificacao']['valor'];
        }
        else
        {
            $strWhere = ' and plu_pl_req.idt_classificacao = '.$vetFiltro['idt_classificacao']['valor'];
        }
    }

    if ($vetFiltro['idt_natureza']['valor']!=-1)
    {
        if ($strWhere == '')
        {
            $strWhere = ' Where  plu_pr.idt_natureza = '.$vetFiltro['idt_natureza']['valor'];
        }
        else
        {
            $strWhere = ' and plu_pr.idt_natureza = '.$vetFiltro['idt_natureza']['valor'];
        }
    }

  /*
  $indice_ordenacao = Array(
    'localidade, descricao ' => 'Localidade',
    'descricao '  => 'Descrição',
  //  'codigo '  => 'Código',
  );
  $Filtro = Array();
  $Filtro['rs'] = $indice_ordenacao;
  $Filtro['id'] = 'num_formulario';
  $Filtro['nome'] = 'Classificação:';
  $Filtro['valor'] = trata_id($Filtro);
  $vetFiltro['indice_ordenacao'] = $Filtro;
  */


// Área de Filtro do relatório
$idx = -1;
ForEach($vetFiltro as $Filtro) {
    $idx++;
    $strPara .= $Filtro['id'].$idx.',';
}

echo '<form name="frm" target="_self" action="conteudo.php?'.substr(getParametro($strPara),1).'" method="post">';

if ($_GET['print'] != 's') {
    $Focus = '';
    codigo_filtro(false);
    onLoadPag($Focus);
} else {
   // codigo_filtro_fixo(false);
    onLoadPag();
}

$korderbyw =' order by '.$vetFiltro['indice_ordenacao']['valor'];

$korderbyw = ' order by plu_pr.classificacao ';


$sql   = 'select ';
$sql  .= '   plu_pr.codigo    as plu_pr_codigo,  ';
$sql  .= '   plu_pr.classificacao   as plu_pr_classificacao,  ';
$sql  .= '   plu_pr.descricao as plu_pr_descricao,  ';
$sql  .= '   plu_pr.detalhe as plu_pr_detalhe,  ';
$sql  .= '   plu_pl_req.idt as plu_pl_req_idt,  ';
$sql  .= '   plu_pl_req.codigo  as plu_pl_req_codigo,  ';
$sql  .= '   plu_pl_req.detalhe as plu_pl_req_detalhe,  ';
$sql  .= '   plu_pl_rp.descricao as plu_pl_rp_descricao,  ';
$sql  .= '   plu_pl_rc.descricao as plu_pl_rc_descricao  ';


//$sql  .= ' from  plu_pl_requisitos as plu_pl_req ';

$sql  .= ' from  plu_pl_projeto plu_pr ';


$sql  .= ' left join plu_pl_requisitos as plu_pl_req on plu_pl_req.idt_projeto = plu_pr.idt ';

$sql  .= ' left join plu_pl_responsavel as plu_pl_re on plu_pl_re.idt = plu_pl_req.idt_responsavel ';
$sql  .= ' left join plu_pl_requisitos_prioridade as plu_pl_rp on plu_pl_rp.idt = plu_pl_req.idt_prioridade ';

$sql  .= ' left join plu_pl_requisitos_classificacao as plu_pl_rc on plu_pl_rc.idt = plu_pl_req.idt_classificacao ';


    $sql .= $strWhere ;
    $sql .= $korderbyw;
    $rs = execsql($sql);



//$sql  .= ' where plu_pl_req.idt_projeto = '.null($vetFiltro['idt_projeto']['valor']);
//$sql  .= ' order by plu_pl_req.codigo';


    echo "<br/>";
    
    echo "<table class='Geral' width='100%' border='0' cellspacing='0' cellpadding='0' vspace='0' hspace='0'> ";
     echo "<tr class='linha_cab_tabela' style='border:0;'>  ";
      $bgcolor="#808080";
      $color  ="#FFFFFF";
      echo "   <td style='font-weight: bold; font-size:14px; background:{$bgcolor}; color:{$color};'>CODIGO</td> ";
      echo "   <td style='font-weight: bold; font-size:14px; background:{$bgcolor}; color:{$color};'>DESCRIÇÃO</td> ";
      echo "   <td class=''  style=' font-size:14px;  background:{$bgcolor}; color:{$color};'  >&nbsp;</td>";

     echo "</tr>";
      
     if ($rs->rows > 0 )
     {
         $plu_pr_codigow="#";
         ForEach($rs->data as $row)
         {
             $plu_pr_codigo       = $row['plu_pr_codigo'];
             $plu_pr_classificacao= $row['plu_pr_classificacao'];
             $plu_pr_descricao    = $row['plu_pr_descricao'];
             $plu_pr_detalhe      = $row['plu_pr_detalhe'];
             
             $plu_pl_req_idt      = $row['plu_pl_req_idt'];
             $plu_pl_req_codigo   = $row['plu_pl_req_codigo'];
             $plu_pl_req_detalhe  = $row['plu_pl_req_detalhe'];
             $plu_pl_rp_descricao = $row['plu_pl_rp_descricao'];
             $plu_pl_rc_descricao = $row['plu_pl_rc_descricao'];

             
             
             if ($plu_pr_codigow!=$plu_pr_codigo)
             {
                 $bgcolor = "#0000FF";
                 $color   = "#FFFFFF";
                 echo "<tr class= 'linha_tabela' style='border:0;'>";
                    echo "<td class='' style='font-weight: bold; font-size:14px;  background:{$bgcolor}; color:{$color};'  >$plu_pr_classificacao&nbsp;</td>";
                    echo "<td class='' style='font-weight: bold; font-size:14px;  background:{$bgcolor}; color:{$color};'  >{$plu_pr_descricao}&nbsp;</td>";
                    echo "<td class='' style='font-weight: bold; font-size:14px;  background:{$bgcolor}; color:{$color};'  >{$plu_pr_codigo}&nbsp;</td>";
                 echo "</tr>";
                 
                 
                 if ($plu_pr_detalhe!="")
                 {
                     $bgcolor = "#FFFFFF";
                     $color   = "#000000";
                     echo "<tr class= 'linha_tabela' style='border:0;'>";
                        echo "<td class=''  style='background:{$bgcolor}; color:{$color};'  >&nbsp;</td>";
                        echo "<td class='' colspan='2' style='background:{$bgcolor}; color:{$color};'  >{$plu_pr_detalhe}&nbsp;</td>";
                     echo "</tr>";
                 }
                 $plu_pr_codigow=$plu_pr_codigo;
             }
             if ($plu_pl_req_idt>0)
             {
                 $bgcolor = "#808080";
                 $color   = "#ffffff";
                 echo "<tr class= 'linha_tabela' style='border:0;'>";
                    echo "<td class='' style='font-size:14px; background:{$bgcolor}; color:{$color}; text-align:right;'  >{$plu_pl_req_codigo}&nbsp;</td>";
                    echo "<td class='' style='font-size:14px; background:{$bgcolor}; color:{$color};'   >{$plu_pl_rc_descricao}&nbsp;</td>";
                    echo "<td class='' style='font-size:14px; background:{$bgcolor}; color:{$color};'  >{$plu_pl_rp_descricao}&nbsp;</td>";
                 echo "</tr>";
                 $bgcolor = "#FFFFFF";
                 $color   = "#000000";
                 echo "<tr class= 'linha_tabela' style='border:0;'>";
                    echo "<td class=''  style='background:{$bgcolor}; color:{$color};'  >&nbsp;</td>";
                    echo "<td class='' colspan='2' style='background:{$bgcolor}; color:{$color};'  >{$plu_pl_req_detalhe}&nbsp;</td>";
                 echo "</tr>";
             }
         }
    }
    else
    {

    }
    echo "</table>";

?>
</form>