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

p('Passei aqui----------------------------------------------------');
echo ' entrei ............................................'

 echo "<br/>";

 echo "<table class='Geral' width='100%' border='0' cellspacing='0' cellpadding='0' vspace='0' hspace='0'> ";
   echo "<tr class='linha_cab_tabela' style='border:0;'>  ";
      $bgcolor="#808080";
      $color  ="#FFFFFF";
     echo "   <td style='font-weight: bold; font-size:14px; background:{$bgcolor}; color:{$color};'>Registros Atualizados</td> ";
 echo "</tr>";


 $ac = 0;

 $sql1 = 'select ';
 $sql1 .= '  par.idt, par.CodParceiro ';
 $sql1 .= '  from db_pir_siac.bairrox par ';
 $rs_a1 = execsql($sql1);

 echo ' executei sql......................................................'

 ForEach ($rs_a1->data as $row)
 {
     $idt      = $row['idt'];
     $codigo   = $row['CodParceiro'];

     $sql_a = ' update  db_pir_siac.ativeconpj set ';
     $sql_a .= ' idt_parceiro      = '.null($idt);
     $sql_a .= ' where CodParceiro = '.null($codigo);
     $result = execsql($sql_a);
     
     $ac=$ac+1;
     
     $resto = ($ac % 1000);
     
 //    if ($resto == 0)
 //    {
          echo "<tr class= 'linha_tabela' style='border:0;'>";
             echo "<td class='' style='font-size:14px; background:{$bgcolor}; color:{$color}; text-align:right;'  >$ac &nbsp;</td>";
          echo "</tr>";
     
 //     }

  }

  echo "</table>";

?>
</form>
