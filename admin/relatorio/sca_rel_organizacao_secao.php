<?php
Require_Once('relatorio/lupe_generico.php');
Require_Once('relatorio/style.php');

?>


<style type="text/css">

   td.linha_tabela {
        padding:0px;
        border:0px;
        margin:0px;
        font-size:11px;
        border-bottom:1px solid #C0C0C0;
    }
    table.Cab_Geral {
        padding:0px;
        border:0px;
        margin:0px;
        background:#C00000;
        color:#FFFFFF;
        font-size:18px;
    }
    table.Geral {
        padding:0px;
        border:0px;
        margin:0px;


    }
    table.Geral_tot {
        padding:0px;
        border:0px;
        margin:0px;
        background:#C00000;
        color:#FFFFFF;
        font-size:18px;

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
    $href = "relatorio/conteudo_excel_relx.php" ;
    echo "<td width='20'>";
    echo "<a HREF='{$href}'><img class='bartar' align=middle src='../imagens/excel.gif'></a>";
    echo "</td>";
 
    
    echo "<td>&nbsp;</td>";
    echo "</tr>";
    echo "</table>";
    echo "</div>";
}
//Monta o vetor de filtro
/*
     // valores fixos
    $sql  = "select idt, nome from cge_empresa ";
    $sql .= " where idt = ".null($_SESSION[CS]['g_idt_empresa']);
    $sql .= " order by nome";
    $Filtro = Array();
//    $Filtro['rs'] = execsql($sql);
    $Filtro['rs'] = $_SESSION[CS]['g_vet_empresa'];

    $Filtro['id'] = 'idt';
    $Filtro['nome'] = 'Empresa';
   // $Filtro['vlPadrao'] = $_SESSION[CS]['g_idt_empresa'];
    // $Filtro['LinhaUm'] = ' ';
    $Filtro['valor'] = trata_id($Filtro);
    $vetFiltro['idt_empresa'] = $Filtro;
    $strWhere = ' Where  cge_centro_resultado.idt_empresa = '.$vetFiltro['idt_empresa']['valor'];
*/


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

// Área de Mostrar Tabela do relatório
//    $sql = 'select * from municipio where idt_uf = '.null($vetFiltro['uf']['valor']).'
//            order by descricao ';

$kwherew   ='';
$korderbyw =' order by '.$vetFiltro['indice_ordenacao']['valor'];

//$korderbyw ='';
$strWhere  ='';

//  ________________________________________________________________________

// SELECT, contendo os campos do arquivo, que serão listados
//         no relatorio
//  ________________________________________________________________________

    $sql  = 'select  ' ;
    $sql .= ' scaos.* ';
    $sql .= ' from ';
    $sql .= ' sca_organizacao_secao as scaos ';
    $sql .= $strWhere ;
    $sql .= $korderbyw;
    $rs = execsql($sql);

//
//  CABEÇALHO
//

    echo "<br/>";
    
    /*
    echo "<table class='Cab_Geral' width='100%' border='0' cellspacing='0' cellpadding='0' vspace='0' hspace='0'> ";
     echo "<tr class='linha_cab_tabela'>  ";
      echo "<td class='linha_tabela'><b>Relação de Centros de Custos (Simplificada)&nbsp;&nbsp;"."&nbsp;</b></td>";
     echo "</tr>";
    echo "</table>";
    */
//
//  CABEÇALHO  DO DETALHE E DETALHE
//
// O tipo e indicador filial é decodificado de um dominio - Ver como fazer isto no relatorio...


    echo "<table class='Geral' width='100%' border='0' cellspacing='0' cellpadding='0' vspace='0' hspace='0'> ";
     echo "<tr class='linha_cab_tabela' style='border:0;'>  ";
     
      $bgcolor="#808080";
      $color  ="#FFFFFF";

      echo "   <td style='font-weight: bold; font-size:12px; background:{$bgcolor}; color:{$color};'>LOCALIDADE</td> ";
      echo "   <td style='font-weight: bold; font-size:12px; background:{$bgcolor}; color:{$color};'>DESCRIÇÃO</td> ";
      echo "<tr class= 'linha_tabela' style='border:0;'>";
      $qtdprow=0;
      $localidade = '##';
      ForEach($rs->data as $row)
      {
         $idt_secao = $row['idt'];
         //
         $bgcolor="#F0F0F0";
         $color  ="#000000";
         if ($row['localidade']!=$localidade)
         {
             if ($vetFiltro['indice_ordenacao']['valor']=='localidade, descricao ')
             {
                 $bgcolor="#C00000";
                 $color  ="#FFFFFF";
                 $localidade = $row['localidade'];
             }
         }
         
         echo "<tr class= 'linha_tabela' style='border:0;'>";
            echo "<td class='linha_tabela' style='sborder:0; background:{$bgcolor}; color:{$color};'  >".$row['localidade']."&nbsp;</td>";
            echo "<td class='linha_tabela' style='sborder:0; background:{$bgcolor}; color:{$color};'  >".$row['descricao']."&nbsp;</td>";
         $qtdprow = $qtdprow+1;
         echo "</tr>";
        // cargos associados
        $bgcolor = "#F0F0F0";
        $color   = "#000000";

        echo "<tr class= 'linha_tabela' style='border:0;'>";
        echo "<td colspan='2' class='linha_tabela' style='sborder:0; background:{$bgcolor}; color:{$color};'  >";;

        
        $sqlc  = 'select  ' ;
        $sqlc .= ' scaoc.* ';
        $sqlc .= ' from ';
        $sqlc .= ' sca_organizacao_cargo as scaoc ';
        $sqlc .= ' where scaoc.idt_secao = '.null($idt_secao);
        $sqlc .= ' order by scaoc.agrupamento, scaoc.descricao ';
        $rsc = execsql($sqlc);
        $agrupamento = '##';

        if ($rsc->rows > 0 )
        {
            echo "<table class='Geral' width='100%' border='0' cellspacing='0' cellpadding='0' vspace='0' hspace='0'> ";
            echo "<tr class='linha_cab_tabela' style='border:0;'>  ";
            echo "   <td style='width:230px; text-align:center; font-weight: bold; font-size:12px; background:{$bgcolor}; color:{$color};'>&nbsp;</td> ";

          //  echo "   <td style='text-align:center; font-weight: bold; font-size:12px; background:{$bgcolor}; color:{$color};'>AGRUPAMENTO</td> ";
            echo "   <td style='text-align:center; font-weight: bold; font-size:12px; background:{$bgcolor}; color:{$color};'>CARGO</td> ";
            echo "</tr>";

        }
        ForEach($rsc->data as $rowc)
        {
            $bgcolor = "#F5F5F5";
            $color   = "#000000";
            $idt_cargo = $rowc['idt'];
            if ($rowc['agrupamento']!=$agrupamento)
            {
                // $bgcolor     = "#C00000";
                // $color       = "#FFFFFF";
                 $agrupamento = $rowc['agrupamento'];
            }
            $chama = "return sca_organizacao_cargo_processo($idt_cargo);";
            echo "<tr class= 'linha_tabela' style='border:0;'>";
                echo "<td class='linha_tabela' style='sborder:0; background:{$bgcolor}; color:{$color};'  >"."&nbsp;</td>";
               // echo "<td class='linha_tabela' style='sborder:0; background:{$bgcolor}; color:{$color};'  >".$rowc['agrupamento']."&nbsp;</td>";
                echo "<td class='linha_tabela' onclick='{$chama}' style='cursor:pointer; sborder:0; background:{$bgcolor}; color:{$color};'  >".$rowc['descricao']."&nbsp;</td>";
                
            echo "</tr>";
            
            

            echo "<tr id='processo_cargo_{$idt_cargo}'  class= 'linha_tabela' style='display:none; border:0;'>";
                echo "<td class='linha_tabela' style='sborder:0; background:{$bgcolor}; color:{$color};'  >"."&nbsp;</td>";
                echo "<td id='processo_cargo_det{$idt_cargo}' class='linha_tabela'  style='sborder:0; background:{$bgcolor}; color:{$color};'  >";
                echo "</td>";
            echo "</tr>";

            

         }

         //
        echo "</td>";
        echo "</tr>";



      }
   echo "</table>";
   //
   echo "<br />";
   $qtdproww = format_decimal($qtdprow,0);
   echo "<table class='Geral_tot' width='100%' border='1' cellspacing='1' cellpadding='0' vspace='0' hspace='0'>";
   echo "<tr >";
   $bgcolor='#C00000';
   echo "<td class='linha_tabela' colspan='5' style='text-align:center; font-size:14px; color:#FFFFFF; background:{$bgcolor};' ><b>TOTAIS</b></td>";
   echo "<td class='linha_tabela' colspan='5' style='text-align:center; font-size:14px; color:#FFFFFF; background:{$bgcolor};' ><b>{$qtdproww}</b></td>";
   echo "</tr>";
   echo "</table>";



 // rodapé
  if ($_GET['print'] == 's')
   {
   echo " <table class='Geral' width='100%' border='0' cellspacing='0' cellpadding='0' vspace='0' hspace='0'>";
   echo " <tr class='linha_cab_tabela'>";
   echo "   <td align='center'><img src='imagens/rodape_rel.jpg'/></td>";
   echo " </tr>";
   echo " </table>";
   }
 
 
?>
</form>

