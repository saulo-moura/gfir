
<style type="text/css">


.bt_topo_barra_se {
	font-family: Calibri, Arial, Helvetica, sans-serif;
	font-size: 16px;
	font-weight:bold;
	color: #999999;
 	text-align: center;
	background: #EBEBEB;
	border:2px solid #C0C0C0;
}
div#meio {
	padding:0;
	border:0;
	width:100%;
	padding-left:20px;
}

</style>
<?php
//header("Content-type: application/octet-stream");
Require_Once('configuracao.php');
//header("Expires: 0");

//header('Content-Type: application/x-msexcel; charset=iso-8859-1');
//header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
//header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
//header ("Cache-Control: no-cache, must-revalidate");
//header ("Pragma: no-cache");
////header ("Content-type: application/x-msexcel");
////header ("Content-Disposition: attachment; filename=excel_file.xls" );
//header ("Content-Description: PHP Generated Data" );

$excel=='S';

if ($_REQUEST['menu'] == '')
	$menu = 'vazio';
else
	$menu = $_REQUEST['menu'];

if ($_REQUEST['comp_excel_name'] == '')
	$comp_excel_name = '';
else
	$comp_excel_name = $_REQUEST['comp_excel_name'].'_';

//header("Content-type: application/octet-stream");
// # replace excelfile.xls with whatever you want the filename to default to
//header("Content-Disposition: attachment; filename=excelfile.xls");
//header("Pragma: no-cache");
//header("Expires: 0");

if ($menu=='fisico_financeiro_g')
{
    $arquivo_excel="{$comp_excel_name}Cronograma_Obra.xls";
}
else
{
    $arquivo_excel="{$comp_excel_name}{$menu}.xls";
}
//header ("Content-Disposition: attachment; filename=\"{$arquivo_excel}\"" );

if ($_REQUEST['menu'] == '')
	$menu = 'vazio';
else
	$menu = $_REQUEST['menu'];

if ($_REQUEST['prefixo'] == '')
	$prefixo = 'inc';
else
	$prefixo = $_REQUEST['prefixo'];

$acao = mb_strtolower($_REQUEST['acao']);

if ($_REQUEST['cabecalho'] == '')
	$cabecalho = 'S';
else
	$cabecalho = $_REQUEST['cabecalho'];

if ($menu == 'vazio' && $_SESSION[CS]['g_fornecedor'] != 'A' && $_SESSION[CS]['idtaltcad'] == '' && $_SESSION[CS]['idtaltcadu'] == '') {
    $menu = 'curriculo';
    $prefixo = 'cad';
}

//$print_tela = 'S';

$print_tela = 'N';

if ($_SESSION[CS]['g_fornecedor'] != 'A') {
    echo '<script language="JavaScript1.2">';
    echo "   var sem_menu   ='N'; ";
    echo "   var privez_menu='S'; ";
    echo "   var print_tela ='N'; ";
    echo "</script>";
} else {
    echo '<script language="JavaScript1.2">';
    echo "   var sem_menu   ='N'; ";
    echo "   var privez_menu='S'; ";
    echo "   var print_tela ='N'; ";
    echo "</script>";
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php Require_Once('head.php'); ?>
<style>
body {
	background-color: white;
}


div#meio {
	padding:0;
	border:0;
	width:100%;

}

</style>

</style>
</head>
<body>
<?php
if ($cabecalho != 'N') {
  //  Require_Once('cabecalho_padrao.php');
}
//<link href="padrao_print.css" rel="stylesheet" type="text/css" media="print" />
?>

<table border="0" cellpadding="0" width="100%" cellspacing="0" class="Menu_print">
    <tr>
        <td align="left" style="font-size: 24px; padding:5px;"><img style="padding:5px;" src="imagens/logo_oas_empreendimentos.jpg" width="305" height="115" alt="Comunicação com o Administrador do Sistema" border="0" /></td>
        <td align="right" style="font-size: 10px; padding-right:20px; ">
            <?php
                $path = $dir_file.'/empreendimento/';
                $img_empreendimento = $_SESSION[CS]['g_imagem_logo_obra'];
                $nm_empreendimento = $_SESSION[CS]['g_nm_obra'];
              //  ImagemMostrar(305, 115, $path, $img_empreendimento, $nm_empreendimento, false);

//                echo '<br />'.date('d/m/Y').' '.(date('H') - date('I')).':'.date('i');
//                echo '<br />Emitido por:&nbsp;'.$_SESSION[CS]['g_nome_completo'];

                    echo '<br />'.date('d/m/Y').' '.(date('H') - date('I')).':'.date('i');
                    echo '<br />Gerado por:&nbsp;'.$_SESSION[CS]['g_nome_completo'];


            ?>
        </td>
    </tr>
    <tr>
        <td align="center"  style="font-size: 24px;  padding:5px;" colspan="2">
            <?php echo $nome_titulo ?>
        </td>

    </tr>
</table>

<div id="meio">

    <?php
    //
    //  folicitar parãmetros de obras a considerar
    //
    
    echo "<table class='tabela_titulo' width='100%' border='0' cellspacing='0' cellpadding='0' vspace='0' hspace='0'> ";
    echo "<tr class='titulo_lista'>  ";                 //0123456
    echo "   <td class='titulo_campo' width='50%' >";
    
    
    echo ' <div class="bt_topo_barra_se"  style="margin-left:40px; width:410px; overflow:auto;" > ';
    
    echo  "<div id='periodo_obra' style='float:left; width:400px; background:#600000;'>";
    $escolher   = '';
    $escolher   = "<div style='float:left; text-align:right; color:#FFFFFF; background:#600000; width:190px;'>";
    $escolher  .= "Selecione Periodo ";
    $escolher  .= "</div>";
    echo $escolher;
    
    echo " <div class='bt_topo_barra_se' style='float:left; width:200px; background:#600000' > ";
    

$anoini_par='2011';
$mesini_par='07';
$anomesini_par=$anoini_par.$mesini_par;

$data = date('d/m/Y');

$anofim_par=date('Y');
$mesfim_par=date('m');
$anomesfim_par=$anofim_par.$mesfim_par;

    
    $sql  = "select peri.idt, peri.ano, peri.mes, peri.resumo ";
    $sql .= "   from periodo peri ";
    $sql .= '    where  concat(peri.ano,peri.mes) >= '.aspa($anomesini_par).'  ' ;
    $sql .= '    and    concat(peri.ano,peri.mes) <= '.aspa($anomesfim_par).'  ' ;
    $sql .= "   order by peri.ano desc, peri.mes desc ";
    

    $rs = execsql($sql);

//    $js = " onchange='return acessa_idt_tipo_acidente(this);'";
//    criar_combo_rs($rs, 'periodo_se', '', '', $js);
    criar_combo_rs($rs, 'periodo_se', '', '', " style='background:#600000; color:#FFFFFF; border:4px solid #900000; ' ");
    echo '      </div>  ';
    
    echo '      </div>  ';

    
    
    $escolher           = "<div style='text-align:center; color:#FFFFFF; background:red; width:100%; display:block; '>";
    $escolher          .= "Selecione Obras ";
    $escolher          .= "</div>";
    echo $escolher;
    $p=$_SESSION[CS]['g_idt_obra_ge'];
    
    echo  "<div id='escolha_obra' style='float:left; width:300px; background:#E6E6E6;'>";
    $escolher           = "<div style='background:#F4F4F4; margin-right:5px; cursor:pointer; float:left;'>";
    $escolher          .= "<input id='idt_obra_todas'   estado='todos' idt_obra='todas' class='obra' onclick='marca_estado(".'"'.'todos'.'"'.")' type='checkbox' name='obra'   value='todas' ><br>";
    $escolher          .= "</div>";
    $conteudo           = "<div style='float:left;'>";
    $conteudo          .= "<span style='cursor:pointer; color:#600000;'  onclick='return marca_estado(".'"'.'todos'.'"'.")'>".'Seleciona Todas as Obras'.'</span>'.'  ';
    $conteudo          .= "</div>";
    echo  $escolher.$conteudo;

    echo  "</div>";
    $escolher           = "<div style='float:left; text-align:center; height:10px; background:#999999; width:100%; display:block; '>";
    $escolher          .= "";
    $escolher          .= "</div>";
    echo  $escolher;

    $vet_ocorr=Array();
    $idt_assina=0;
    $diay = '';
    $mesy = '';
    $anoy = '';
    $ret  = 0;
    $ret = periodo_assina_atual($idt_assina, $diay, $mesy, $anoy, $vet_ocorr);
    $dt_assina=$diay.'/'.$mesy.'/'.$anoy;
    echo "<table class='xxcontrato_table' width='100%' border='0' cellspacing='0' cellpadding='0' vspace='0' hspace='0'> ";
    echo "<tr >  ";
    echo " <td style='width:5%;  color:#FFFFFF; background:#B00000;  border-bottom:1px solid #C0C0C0;' >&nbsp;</td>";
    echo " <td style='width:85%; color:#FFFFFF; background:#B00000;  border-bottom:1px solid #C0C0C0;' >Obras</td>";

    echo " <td style='width:5%;  color:#FFFFFF; background:#B00000; border-bottom:1px solid #C0C0C0;'  >Físico&nbsp;</td>";
    
    echo " <td style='width:5%;  color:#FFFFFF; background:#B00000; border-bottom:1px solid #C0C0C0;'  >Financ.&nbsp;</td>";
    
    
    echo "</tr >  ";
    echo "<tr >  ";
    echo " <td colspan='2' style='  color:#FFFFFF; background:#B00000; border-bottom:1px solid #C0C0C0;'  >&nbsp;</td>";
    echo " <td colspan='2' style='width:10%;  text-align:center; color:#FFFFFF; background:#B00000; border-bottom:1px solid #C0C0C0;'  >{$dt_assina}</td>";
    echo "</tr >  ";



    ForEach ($_SESSION[CS]['g_vet_obras_site'] as $idx => $texto)
    {
             $estado             = substr($texto,0,2);
             $idt_empreendimento = $idx;
             $obra               = substr($texto,5);
             $finw = '&Chi;';
             $fisw = '&Chi;';
             $ret  = 0;
             $ret = verifica_financeiro($idt_empreendimento, $finw, $fisw);
             
             echo "<tr >  ";
             
             echo " <td style='width:5%; border-bottom:1px solid #C0C0C0;' >";
                 echo  "<div id='escolha_obra' style='margin:0; padding:0; background:#E6E6E6;'>";
                 $escolher           = "<div style='width:25px; height:25px; background:#F4F4F4; margin-right:0px; cursor:pointer; float:left; border:0px solid blue;'>";
                 $escolher          .= "<input id='idt_obra_{$idt_empreendimento}'   estado='{$estado}' idt_obra='{$idt_empreendimento}' class='obra' type='checkbox' name='obra'   value='{$idt_empreendimento}' >";
                 $escolher          .= "</div>";

                 $conteudo           = "<div style='text-align:left; display:block; height:25px; width:368px; float:right; border:0px solid red;'>";
                 $conteudo          .= "<span style='cursor:pointer;' onclick='return marca_estado(".'"'.$estado.'"'.")'>".$estado.'</span>'.' - '.$obra;
                 $conteudo          .= "</div>";
                 echo  $escolher;
                 echo  "</div>";
             echo " </td> ";

             
             
             echo " <td style='width:85%; border-bottom:1px solid #C0C0C0;'> ";

                 echo  "<div id='escolha_obra' style='margin:0; padding:0; background:#E6E6E6;'>";
                 $escolher           = "<div style='width:25px; height:25px; background:#F4F4F4; margin-right:0px; cursor:pointer; float:left; border:0px solid blue;'>";
                 $escolher          .= "<input id='idt_obra_{$idt_empreendimento}'   estado='{$estado}' idt_obra='{$idt_empreendimento}' class='obra' type='checkbox' name='obra'   value='{$idt_empreendimento}' >";
                 $escolher          .= "</div>";
             
                 $conteudo           = "<div style='text-align:left; display:block; height:25px; swidth:368px; sfloat:right; border:0px solid red;'>";
                 $conteudo          .= "<span style='cursor:pointer;' onclick='return marca_estado(".'"'.$estado.'"'.")'>".$estado.'</span>'.' - '.$obra;
                 $conteudo          .= "</div>";
              //   echo  $escolher.$conteudo;
                 echo  $conteudo;
                 echo  "</div>";
             echo " </td> ";
             

             echo " <td style='width:5%;  text-align:center; background:#DFDFDF; border-bottom:1px solid #C0C0C0;' > ";
             echo $fisw;
             echo " </td> ";


             echo " <td style='width:5%; text-align:center; background:#DFDFDF; border-bottom:1px solid #C0C0C0;' >";
             echo $finw;
             echo " </td> ";

             
             echo "  </tr>  ";

             
             
             
             //echo  '<br />';
    }
    echo "</table>";

    
    
    
    
    echo '      </div>  ';
    
    
    
    echo  '<br /><br />';

    echo "</td> ";
    echo "   <td class='titulo_campo'  valign='top'  width='50%' >";

    $btconfirma   = "<input type='button' name='btnAcao' value='Executar migração para Excel'  style='width:350px; height:50px; margin-left:10px; cursor: pointer;' onclick='return armar_solicitacao();' title='Executar Migração para Excel'  />";

    echo $btconfirma;
    
    echo "</td> ";
    
    
    echo " </tr> ";

    echo "</table> ";


    /*
	$Require_Once = "$prefixo$menu.php";
    if (file_exists($Require_Once)) {
    	Require_Once($Require_Once);
    } else {
        echo "<script type='text/javascript'>top.location = 'index.php';</script>";
        exit();
    }
    */
    
    
    ?>

</div>
</body>
</html>


<script type="text/javascript">

function  marca_estado(estado)
{

   // alert(' tem '+estado);

    if (estado=='todos')
    {
    $(".obra").each(function () {
         var idw      = this.id ;
         var estado   = $(this).attr('estado');
         var idt_obra = this.value;
         objd_ed=document.getElementById(idw);
         if (objd_ed != null)
         {
             if (objd_ed.checked==true)
             {
                 objd_ed.checked=false;
             }
             else
             {
                 objd_ed.checked=true;
             }
         }

    });
    }
    else
    {
    $(".obra").each(function () {
         var idw      = this.id ;
         var estadow   = $(this).attr('estado');
         var idt_obra = this.value;
         if (estadow==estado)
         {
         objd_ed=document.getElementById(idw);
         if (objd_ed != null)
         {
             if (objd_ed.checked==true)
             {
                 objd_ed.checked=false;
             }
             else
             {
                 objd_ed.checked=true;
             }
         }
         }
    });
    }
    return false;
}



function  armar_solicitacao()
{
    var strvet = '';
    var sep    = '';
    // pegar a opcao do periodo
    var indice                   = 0;
    var idt_periodo              = 0;
    var descricao_periodo        = '';

    var idw = 'periodo_se';
    objd_ed=document.getElementById(idw);
    if (objd_ed != null)
    {
        indice             = objd_ed.selectedIndex;
        idt_periodo        = objd_ed.options[indice].value;
        descricao_periodo  = objd_ed.options[indice].text;
    }
    $(".obra").each(function () {
         var idw      = this.id ;
         var estado   = $(this).attr('estado');
         var idt_obra = this.value;
         objd_ed=document.getElementById(idw);
         if (objd_ed != null)
         {
             if (objd_ed.checked==true)
             {
                 if (estado=='todos')
                 {
                 }
                 else
                 {
                    strvet=strvet+sep+idt_obra;
                    sep = '__';
                 }
             }
         }
    });
//    alert(' ddddd '+idt_periodo);
//    alert(' obr   '+strvet);
    var str='conteudo_excel_migra.php?prefixo=inc&menu=ge_fluxo_financeiro_excel&print=s&lupa=s&titulo_rel=&ampliar=S&origem=S';
    str = str +'&periodo='+idt_periodo+ '&obras='+strvet;
    self.location   = str;

    
    return false;
}

</script>
