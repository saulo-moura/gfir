
<?php
//header("Content-type: application/octet-stream");
Require_Once('..\configuracao.php');


if ($_REQUEST['menu'] == '')
	$menu = 'vazio';
else
	$menu = $_REQUEST['menu'];

if ($_REQUEST['comp_excel_name'] == '')
	$comp_excel_name = '';
else
	$comp_excel_name = $_REQUEST['comp_excel_name'].' - ';

//header("Content-type: application/octet-stream");
// # replace excelfile.xls with whatever you want the filename to default to
//header("Content-Disposition: attachment; filename=excelfile.xls");
//header("Pragma: no-cache");
//header("Expires: 0");



//Costa Espana_2011_07_Fluxo Financeiro.xls MUDAR FORMATO PARA FLUXO FINANCEIRO – COSTA ESPAÑA – DEZ/2012

//FinanceiroConsolidado_2011_12
// OK. MUDAR FORMATO PARA FINANCEIRO CONSOLIDADO DEZ/2012






header("Expires: 0");
//header("Content-Type: text/html; charset=ISO-8859-1",true);

header('Content-Type: application/x-msexcel; charset=iso-8859-1',true);


header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
//header ("Content-type: application/x-msexcel");
//header ("Content-Disposition: attachment; filename=excel_file.xls" );
header ("Content-Description: PHP Generated Data" );
$arquivo_excel='Arquivo_Excel';
header ("Content-Disposition: attachment; filename=\"{$arquivo_excel}\"" );


if ($_REQUEST['menu'] == '')
	$menu = 'vazio';
else
	$menu = $_REQUEST['menu'];

if ($_REQUEST['prefixo'] == '')
	$prefixo = 'inc';
else
	$prefixo = $_REQUEST['prefixo'];

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php //Require_Once('head.php'); ?>
<?php
?>
<style>
body {
	background-color: white;
}
</style>
</head>
<body>
<?php
if ($cabecalho != 'N') {
  //  Require_Once('cabecalho_padrao.php');
}
//<link href="padrao_print.css" rel="stylesheet" type="text/css" media="print" />
?>
<div id="meio">
    <?php

    $korderbyw =' order by classificacao ';
    $strWhere  ='';

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
    
</div>

</body>
</html>
 
   