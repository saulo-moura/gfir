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
    'classificacao  ' => 'Classificação',
    'descricao '  => 'Descrição',
    'codigo '  => 'Código',
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
    $sql .= ' scae.*, ';
    $sql .= ' scate.descricao as scate_descricao ';
    $sql .= ' from ';
    $sql .= ' sca_estrutura as scae ';
    $sql .= ' inner join sca_tipo_estrutura scate on  scate.idt = scae.idt_sca_tipo_estrutura ';
    $sql .= $strWhere ;
    $sql .= $korderbyw;
    $rs = execsql($sql);

//
//  CABEÇALHO
//

    echo "<br/>";
    
    echo "<table class='Cab_Geral' width='100%' border='0' cellspacing='0' cellpadding='0' vspace='0' hspace='0'> ";
     echo "<tr class='linha_cab_tabela'>  ";
      echo "<td class='linha_tabela'><b>Relação de Centros de Custos (Simplificada)&nbsp;&nbsp;"."&nbsp;</b></td>";
     echo "</tr>";
    echo "</table>";
//
//  CABEÇALHO  DO DETALHE E DETALHE
//
// O tipo e indicador filial é decodificado de um dominio - Ver como fazer isto no relatorio...

    echo "<table class='Geral' width='100%' border='0' cellspacing='0' cellpadding='0' vspace='0' hspace='0'> ";
     echo "<tr class='linha_cab_tabela' style='border:0;'>  ";
     
      $bgcolor="#808080";
      $color  ="#FFFFFF";

      echo "   <td style='font-weight: bold; font-size:12px; background:{$bgcolor}; color:{$color};'>CLASSIFICAÇÃO</td> ";
      echo "   <td style='font-weight: bold; font-size:12px; background:{$bgcolor}; color:{$color};'>DESCRIÇÃO</td> ";
      //echo "   <td style='font-weight: bold; font-size:12px; background:{$bgcolor}; color:{$color};'>CÓDIGO</td> ";
      echo "   <td style='font-weight: bold; font-size:12px; background:{$bgcolor}; color:{$color};'>SISTEMA</td> ";
      echo "   <td style='width:150px; font-weight: bold; font-size:12px; background:{$bgcolor}; color:{$color}; text-align:left;'>&nbsp;&nbsp;&nbsp;TRANSAÇÃO</td> ";
      echo "   <td style='font-weight: bold; font-size:12px; background:{$bgcolor}; color:{$color}; text-align:left;'>TIPO PROCESSO</td> ";

      echo "<tr class= 'linha_tabela' style='border:0;'>";
      $qtdprow=0;
      $bgcolor="#F0F0F0";
      $color  ="#000000";
      ForEach($rs->data as $row)
      {
         if ($row['grau']==1)
         {
             $bgcolor="#C00000";
             $color  ="#FFFFFF";
         }
         if ($row['grau']==2)
         {
             $bgcolor="#808080";
             $color  ="#FFFFFF";
         }
         if ($row['grau']==3)
         {
             $bgcolor="#C0C0C0";
             $color  ="#FFFFFF";
         }
         if ($row['grau']==4)
         {
             $bgcolor="#FFFFFF";
             $color  ="#000000";
         }



         echo "<tr class= 'linha_tabela' style='border:0;'>";
            echo "<td class='linha_tabela' style='sborder:0; background:{$bgcolor}; color:{$color};'  >".$row['classificacao']."&nbsp;</td>";
            echo "<td class='linha_tabela' style='sborder:0; background:{$bgcolor}; color:{$color};'  >".$row['descricao']."&nbsp;</td>";
            //echo "<td class='linha_tabela' style='sborder:0; background:{$bgcolor}; color:{$color};'  >".$row['codigo']."&nbsp;</td>";
            
            echo "<td class='linha_tabela' style='sborder:0; background:{$bgcolor}; color:{$color};'  >".$row['sistema_executa']."&nbsp;</td>";
            echo "<td class='linha_tabela' style='sborder:0; background:{$bgcolor}; color:{$color};'  >&nbsp;&nbsp;&nbsp;".$row['transacao']."&nbsp;</td>";
            echo "<td class='linha_tabela' style='sborder:0; background:{$bgcolor}; color:{$color};'  >&nbsp;".$row['scate_descricao']."&nbsp;</td>";



            
         echo "</tr>";
         $qtdprow = $qtdprow+1;
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

//
//  TOTAL FINAL DO RELATORIO
//
/*
   $qtddir_cc = count($vet_dircc);
   
   echo "<br />";
   echo "<table class='Geral_tot' width='100%' border='1' cellspacing='1' cellpadding='0' vspace='0' hspace='0'>";
   echo "<tr >";
   $bgcolor='#C00000';
   echo "<td class='linha_tabela' colspan='5' style='text-align:center; font-size:14px; color:#FFFFFF; background:{$bgcolor};' ><b>TOTAIS</b></td>";
   echo "</tr>";

   echo "<tr >";
   $bgcolor='#FF0000';
   echo "<td class='linha_tabela' style='text-align:center; color:#FFFFFF; background:{$bgcolor};' ><b>EMPRESAS</b></td>";
   echo "<td class='linha_tabela' style='text-align:center; color:#FFFFFF; background:{$bgcolor};' ><b>DIRETORIAS</b></td>";
   echo "<td class='linha_tabela' style='text-align:center; color:#FFFFFF; background:{$bgcolor};' ><b>CENTROS CUSTO<br />DIRETORIA</b></td>";
   echo "<td class='linha_tabela' style='text-align:center; color:#FFFFFF; background:{$bgcolor};' ><b>GERÊNCIAS</b></td>";
   echo "<td class='linha_tabela' style='text-align:center; color:#FFFFFF; background:{$bgcolor};' ><b>CENTROS CUSTO<br />GERAL</b></td>";
   echo "</tr>";

   echo "<tr >";
   $bgcolor='#808080';
   echo "<td class='linha_tabela' style='text-align:center; color:#FFFFFF; background:{$bgcolor};' ><b>".$qtempresas."</b></td>";
   echo "<td class='linha_tabela' style='text-align:center; color:#FFFFFF; background:{$bgcolor};' ><b>".$qtddir_cc."</b></td>";
   echo "<td class='linha_tabela' style='text-align:center; color:#FFFFFF;  background:{$bgcolor};' ><b>".$qtdiretorias."</b></td>";
   echo "<td class='linha_tabela' style='text-align:center; color:#FFFFFF; background:{$bgcolor};' ><b>".$qtgerencia."</b></td>";
   echo "<td class='linha_tabela' style='text-align:center; color:#FFFFFF; background:{$bgcolor};' ><b>".$qtdvdw."</b></td>";
   echo "</tr>";
   echo "</table>";
*/


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

