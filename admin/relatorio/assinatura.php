<?php
Require_Once('relatorio/lupe_generico.php');
Require_Once('relatorio/style.php');
?>


<style type="text/css">

div#area_imprime {
    background: #FFFFFF;
    text-align:right;
}
div#area_imprime img {
    background: #FFFFFF;
    padding-right:5px;
}
div#conteudo {
    overflow:auto;
}
div#smeio_util {
    overflow:auto;
}
div#smeio {
    overflow:auto;
}
div#sgeral {
    overflow:auto;
}


table.Geral_t_pa {
	font-family: Calibri, Arial, Helvetica, sans-serif;
	font-size: 18px;
	color: #9B0000;
	text-align: left;
	border: 0px solid #FFFFFF;
	border-collapse: collapse;
}

tr.linha_cab_tabela_t_pa {
 	background: #FFFFFF;
	font-weight: normal;
	text-align: center;
	border: 0px solid #B00000;
	border-collapse: collapse;
	padding: 2px;
}

table.Geral_pa {
	font-family: Calibri, Arial, Helvetica, sans-serif;
	font-size: 11px;
	color: #FF3C3C;
	text-align: left;
	border: 0px solid #840000;
	border-collapse: collapse;
}


tr.linha_cab_tabela_pa {
 	background: #600000;
	font-weight: bold;
	text-align: center;
	border: 0px solid #840000;
	border-collapse: collapse;
	padding: 2px;
	color:#FFFFFF;
}

td.linha_tabela_pa {
	background: #DDDDDD;
	border-bottom: 1px solid #666666;
	border-collapse: collapse;
	padding: 4px;
	font-family: Calibri, Arial, Helvetica, sans-serif;
	font-size: 11px;
	color: #151515;
	text-align: right;
}

td.linha_tabela_pa_d {
	background: #F2F2F2;
	font-weight: normal;
 border-bottom: 1px solid #666666;
	border-collapse: collapse;
	padding: 4px;
	font-family: Calibri, Arial, Helvetica, sans-serif;
	font-size: 11px;
	color: #A7A7A7;
	text-align: right;
}

td.linha_tabela_pa_l {
	background: #F2F2F2;
	font-weight: normal;
 border-bottom: 1px solid #666666;
	border-collapse: collapse;
	padding: 4px;
	font-family: Calibri, Arial, Helvetica, sans-serif;
	font-size: 11px;
    color:#000000;
	text-align: center;
	

	
}


td.linha_tabela_sa {
	background: #F8F8F8;
	sborder: 1px solid Black;
	border-collapse: collapse;
	padding: 10px;
	font-family: Calibri, Arial, Helvetica, sans-serif;
	font-size: 11px;
	color: #151515;
	text-align: right;
}

td.linha_tabela_sa_l {
	background: #F8F8F8;
	sborder: 1px solid Black;
	border-collapse: collapse;
	padding: 4px;
	font-family: Calibri, Arial, Helvetica, sans-serif;
	font-size: 11px;
	color: #151515;
	text-align: left;
}


tr.linha_tabela_pa_t {
	background: #DDDDDD;
	font-weight: normal;
	text-align: right;
	sborder: 1px solid #840000;
	border-collapse: collapse;
	padding: 4px;
	color:#5E0000;
}

td.linha_tabela_pa_t {
	background: #DDDDDD;
	font-weight: normal;
	text-align: right;
	sborder: 1px solid #840000;
	border-collapse: collapse;
	padding: 10px;
	color:#5E0000;
}

div.barra_imp {
	background: #DDDDDD;
	width:'100%';
}
div.barra_imp img{
	float:right;
}

div#select_a {
	display:none;
    background:#C0C0C0;
    height:300px;
}

div#aciona_select {
	display:block;
    background:#C0C0C0;
    weight:100%;
    height:21px;
}
div#aciona_select a {
    text-decoration:none;
	font-family: Calibri, Arial, Helvetica, sans-serif;
	font-size: 11px;
	color: #000000;
}
div#a_aciona_select {
}
div#a_aciona_select span {
    text-decoration:none;
}
div#aciona_select_img {
}

</style>


<?php
$estado = $_GET['codigo1'];
$idt    = $_GET['id'];
if ($_GET['print'] != 's') {
    echo "<div class='barra_ferramentas'>";
    echo "<table cellspacing='1' cellpadding='1' width='100%' border='1'>";
    echo "<tr>";
    echo "<td width='20'>";
    echo "<a HREF='conteudo.php?prefixo=inc&menu=administrar_menu&class=0'><img class='bartar' align=middle src='relatorio/voltar_ie.jpg'></a>";
    echo "</td>";

    
    echo "<td width='20'>";
    echo "<a HREF='#' onclick=\"return imprimir_ass('$menu','$idt','$estado');\"><img class='bartar' align=middle src='relatorio/visualiza_imprime.jpg'></a>";
    echo "</td>";
    echo "<td width='20'>";
    echo "<a HREF='#' onclick=\"return imprimir_excel_ass('$menu','$idt','$estado');\"><img class='bartar' align=middle src='relatorio/excel.gif'></a>";
    echo "</td>";
    echo "<td>&nbsp;</td>";
    echo "</tr>";
    echo "</table>";
    echo "</div>";
}
else
{
    echo "<div class='barra_imp'>";
    echo "<a HREF='#' onclick=\"return ch_imp();\"><img class='bartar' align=middle src='imagens/impressora.gif'></a>";
    echo "</div>";
}
//$_GET['print']='s';

$sql  = 'select idt, dia, mes, ano from assina_controle order by ano desc, mes desc, dia desc';
$Filtro          = Array();
$Filtro['rs']    = execsql($sql);
$Filtro['id']    = 'idt';
$Filtro['nome']  = 'Controle Assinatura';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['assinatura_controle'] = $Filtro;

$sql   = 'select distinct es.codigo,  es.codigo, es.descricao from estado es ';
$sql  .= ' inner join empreendimento em on em.estado = es.codigo ';
$sql  .= ' order by es.descricao';
$Filtro          = Array();
    $_GET['pri']='S';
$Filtro['vlPadrao'] = 5;
$Filtro['LinhaUm']  = '-- Todos --';
$Filtro['rs']    = execsql($sql);
$Filtro['id']    = 'codigo';
$Filtro['nome']  = 'Estado';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['estado'] = $Filtro;

$Filtro = Array();
$Filtro['rs'] = 'Texto';
$Filtro['id'] = 'texto_geral';
//$Filtro['js'] = "marca_obra_s('obras_escolha');";
$Filtro['js_tam'] = '0';
$Filtro['nome'] = 'Obras Selecionadas';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['identificacao'] = $Filtro;


echo '<form name="frm_p" target="_self" action="conteudo.php?'.substr(getParametro($strPara),1).'" method="post">';

$imagemf = '<img id="aciona_select_img" src="imagens/abrir_div.gif" title="Clique aqui para Selecionar Obras" alt="Clique aqui para Selecionar Obras"/>';
echo ' <div id="aciona_select" > ';
echo '       <a id="a_aciona_select" href="#" onclick="return seleciona_obras();" title="Clique aqui para Selecionar Obras" >'.$imagemf.'<span class="oas">&nbsp;&nbsp;Selecionar Obras</span></a>';
echo '      </div>  ';



echo '<div id="select_a">';
echo '<select name="obras_escolha" multiple="multiple" onclick="return marca_obra(this);" style="width:100%; height:300px;">';
$sql   = 'select idt, estado, descricao from empreendimento';
$sql  .= ' order by estado, descricao';
$rs = execsql($sql);
if  ($rs->rows==0)
{

}
else
{
     $estado_ant='#';
     ForEach($rs->data as $row) {
        $idt       = $row['idt'];
        $estado    = $row['estado'];
        $descricao = $row['descricao'];
        if ($estado_ant!=$estado)
        {
            $lblinha = ''.$estado;
            $idlinha = 'opcao_id'.$estado;
            echo "<optgroup id='{$idlinha}' label='{$lblinha}'>";
            $estado_ant=$estado;
        }
        $linha   = $estado.' - '.$descricao;
        $lblinha = 'opcao_'.$idt;
        $idlinha = 'opcao_id'.$idt;
//        echo "<option id='{$idlinha}' label='{$lblinha}' value='{$idt}'>{$linha}</option>";
        echo "<option id='{$idlinha}' value='{$idt}'>{$linha}</option>";
     }
}

echo '</select>';
echo '</div>';


echo '</form>';




echo '<form name="frm" target="_self" action="conteudo.php?'.substr(getParametro($strPara),1).'" method="post">';




if ($_GET['print'] != 's') {
    $Focus = '';
    codigo_filtro(false);
    onLoadPag($Focus);
} else {
 //   codigo_filtro_fixo();
    onLoadPag();
}

$Vopcao_obras=Array();

$obras_escolhidas=$vetFiltro['identificacao']['valor'];
if  ($obras_escolhidas=='')
{
     $opcao_obras='T';
}
else
{
     $opcao_obras='E';
     $Vopcao_obras=explode('#',$obras_escolhidas);
}
//p($Vopcao_obras);
$Vopcao_obras_idt=Array();
ForEach ($Vopcao_obras as $idxo => $idt)
{
   $Vopcao_obras_idt[$idt]=$idt;
}


                    $vmesnum = Array();
                    $vmesnum['01'] = 'Janeiro';
                    $vmesnum['02'] = 'Fevereiro';
                    $vmesnum['03'] = 'Março';
                    $vmesnum['04'] = 'Abril';
                    $vmesnum['05'] = 'Maio';
                    $vmesnum['06'] = 'Junho';
                    $vmesnum['07'] = 'Julho';
                    $vmesnum['08'] = 'Agôsto';
                    $vmesnum['09'] = 'Setembro';
                    $vmesnum['10'] = 'Outubro';
                    $vmesnum['11'] = 'Novembro';
                    $vmesnum['12'] = 'Dezembro';

$ac_data     = '';
$ac_data_ref = '';
$estado = $vetFiltro['estado']['valor'];

$sql   = 'select idt, dia, mes, ano from assina_controle';
$sql  .= ' where idt = '.null($vetFiltro['assinatura_controle']['valor']);
$sql  .= ' order by ano desc, mes desc, dia desc';
//p($sql);
$rs = execsql($sql);
if  ($rs->rows==0)
{
}
else
{
     ForEach($rs->data as $row) {
        $ac_data = $row['dia'].'/'.$row['mes'].'/'.$row['ano'];
        $ac_data_ref =  $vmesnum[$row['mes']].'/'.$row['ano'];
        
     }
}



//p($estado);



$titulo_rel     ='MONITORAMENTO DE ATUALIZAÇÃO';
$subtitulo_rel  ='';
$subtitulo_rel .="<span style='font-size:12px; ' >";
$subtitulo_rel .='<br />'.date('d/m/Y').' '.(date('H') - date('I')).':'.date('i');
$subtitulo_rel .='<br />Emitido por:&nbsp;'.$_SESSION[CS]['g_nome_completo'];
$subtitulo_rel .="</span>";


$vetObras=Array();
$vetFassina=Array();
$vetNatrizObraAss=Array();
$idt_controle_assinatura=null($vetFiltro['assinatura_controle']['valor']);
$ret=carregar_matriz_obra_funcao($idt_controle_assinatura,$vetObras,$vetFassina,$vetNatrizObraAss);

//p($vetObras);
//p($vetFassina);
//p($vetNatrizObraAss);
//exit();
//       $vetNatrizObraAssw[$idx]['func']=$Vet;
//       $vetNatrizObraAssw[$idx]['obra']=$vetObras_trabw;

   $tam = count($vetObras)+1;
   if ($estado!='-1')
   {
       $tam = 1;
       ForEach ($vetObras as $idxo => $Vet_o)
       {
            $em_estado = $Vet_o['em_estado'];
            if ($estado==$em_estado)
            {
                $tam = $tam+1;
            }
       }
   }
   
   if ($opcao_obras=='E')
   {
       $tam = count($Vopcao_obras)+1;
   }

echo "<br />";


echo "<table class='Geral_t_pa' width='100%' border='0' cellspacing='0' cellpadding='0' vspace='0' hspace='0'> ";
echo "<tr class='linha_cab_tabela_t_pa'>  ";
echo "   <td style='border-bottom:3px solid #C0C0C0; text-align:left; width=30px; padding:10px;'  >";
$pathlPCO='imagens/';
$nomelPCO='logo_PCO.jpg';
echo '<div class="sempreendimento_l">';
ImagemMostrar(80, 0, $pathlPCO, $nomelPCO, 'Logo do Sistema PCO', false, '');
echo '</div>';
echo "</td> ";
$tamw=$tam-1;
echo "   <td style='border-bottom:3px solid #C0C0C0; text-align:center;'  colspan='{$tamw}' >&nbsp;$titulo_rel<br/ >$subtitulo_rel</td> ";
echo "</tr>";
echo "   <td style='border-bottom:3px solid #FFFFFF; text-align:center;'  colspan='{$tamw}' >&nbsp;</td> ";
echo "</tr>";
echo "</table>";


$ref_atu= 'Atualização referente a '.$ac_data_ref;
$path = $dir_file.'/empreendimento/';

echo "<table class='Geral_pa' width='100%' border='0' cellspacing='0' cellpadding='0' vspace='0' hspace='0'> ";
echo "<tr class='linha_cab_tabela_pa' style='background:#FFFFFF;' >  ";

echo "   <td style='border-bottom:1px solid #666666; width:20%; color:#0080C0; font-weight: bold; font-size: 14px;' >$ref_atu</td> ";
ForEach ($vetObras as $idx => $Vet)
{

     $nome_obra = $Vet['em_descricao'].'<br>'.$Vet['em_estado'];
     if ($opcao_obras=='E')
     {
         $em_idt = $Vet['em_idt'];
         //p( ' aaaa '.$em_idt. ' bbbb '.$Vopcao_obras_idt[$em_idt]);
         if ($em_idt==$Vopcao_obras_idt[$em_idt])
         {
              echo "   <td style='background:#FFFFFF; width:7%; border-bottom:1px solid #666666;' >";
                       echo '<div class="sempreendimento_l">';
                       ImagemMostrar(80, 0, $path, $Vet['em_imagem'], $Vet['em_descricao'], false, 'idt="'.$Vet['em_idt'].'"');
                       echo '</div>';
               echo "   </td> ";
         }
         else
         {
             continue;
         }
     }
     else
     {
         if ($estado=='-1')
         {
//             echo "   <td style='width:8%;' >$nome_obra</td> ";
              echo "   <td style='background:#FFFFFF; width:7%; border-bottom:1px solid #666666;' >";
                        echo '<div class="sempreendimento_l">';
                        ImagemMostrar(80, 0, $path, $Vet['em_imagem'], $Vet['em_descricao'], false, 'idt="'.$Vet['em_idt'].'"');
                        echo '</div>';
               echo "   </td> ";

         }
         else
         {
             if ($estado==$Vet['em_estado'])
             {
  //               echo "   <td style='width:8%;' >$nome_obra</td> ";
                echo "   <td style='background:#FFFFFF;  width:7%; border-bottom:1px solid #666666;' >";
                       echo '<div class="sempreendimento_l">';
                       ImagemMostrar(80, 0, $path, $Vet['em_imagem'], $Vet['em_descricao'], false, 'idt="'.$Vet['em_idt'].'"');
                       echo '</div>';
               echo "   </td> ";

             }
         }
     }
}
echo "</tr>";
echo "<tr class='linha_cab_tabela_pa' style='background:#C0C0C0; color:#666666;' >  ";

// GGC da obra
echo "   <td style='border-bottom:1px solid #666666; width:20%; color:#0080C0; text-align:right; font-weight: bold; font-size: 12px;' >GGC</td> ";

//p($vetObras);




$path = $dir_file.'/ggc/';


$colspantotal=0;

ForEach ($vetObras as $idx => $Vet)
{

     $ggc_nome = $Vet['ggc_nome'];
     if ($ggc_nome=='')
     {
         $ggc_nome='guy';
     }
     if ($opcao_obras=='E')
     {
         $em_idt = $Vet['em_idt'];
         //p( ' aaaa '.$em_idt. ' bbbb '.$Vopcao_obras_idt[$em_idt]);
         if ($em_idt==$Vopcao_obras_idt[$em_idt])
         {
              echo "   <td style='border-bottom:1px solid #666666; width:8%;' >";
                       if ($Vet['ggc_imagem']!='')
                       {
                           echo '<div class="empreendimento_l">';
                           ImagemMostrar(80, 0, $path, $Vet['ggc_imagem'], $Vet['ggc_nome'], false, 'idt="'.$Vet['ggc_idt'].'"');
                           echo '</div>';
                       }
                       else
                       {
                            echo "   <td style='background:#FFFFFF; border-bottom:1px solid #666666; width:7%;  text-align:center;' >{$ggc_nome}</td> ";

                       }
               echo "   </td> ";
               $colspantotal=$colspantotal+1;
         }
         else
         {
             continue;
         }
     }
     else
     {
         if ($estado=='-1')
         {
                       if ($Vet['ggc_imagem']!='')
                       {
                           echo '<div class="empreendimento_l">';
                           ImagemMostrar(80, 0, $path, $Vet['ggc_imagem'], $Vet['ggc_nome'], false, 'idt="'.$Vet['ggc_idt'].'"');
                           echo '</div>';
                       }
                       else
                       {
                            echo "   <td style='background:#FFFFFF; border-bottom:1px solid #666666; width:7%;  text-align:center;' >{$ggc_nome}</td> ";

                       }
                       $colspantotal=$colspantotal+1;

         }
         else
         {
             if ($estado==$Vet['em_estado'])
             {
                       if ($Vet['ggc_imagem']!='')
                       {
                           echo '<div class="empreendimento_l">';
                           ImagemMostrar(80, 0, $path, $Vet['ggc_imagem'], $Vet['ggc_nome'], false, 'idt="'.$Vet['ggc_idt'].'"');
                           echo '</div>';
                       }
                       else
                       {
                            echo "   <td style='background:#FFFFFF; border-bottom:1px solid #666666; width:7%;  text-align:center;' >{$ggc_nome}</td> ";

                       }
                       $colspantotal=$colspantotal+1;

             }
         }
     }
}
echo "</tr>";


echo "<tr class='linha_cab_tabela_pa' style='background:#C0C0C0;  color:#666666;' >  ";

//p(' bbbbbbb '.$opcao_obras);
// % de assinatura
echo "   <td style='border-bottom:1px solid #666666; width:20%; color:#0080C0; text-align:right; font-weight: bold; font-size: 12px;' >% ATUALIZAÇÃO OBRA</td> ";


ForEach ($vetObras as $idx => $Vet)
{

     $nome_obra = $Vet['em_descricao'].'<br>'.$Vet['em_estado'];
     if ($opcao_obras=='E')
     {
         $em_idt = $Vet['em_idt'];
         //p( ' aaaa '.$em_idt. ' bbbb '.$Vopcao_obras_idt[$em_idt]);
         if ($em_idt==$Vopcao_obras_idt[$em_idt])
         {
             $percent_total_ggc = format_decimal(0);
              echo "   <td style='background:#FFFFFF; border-bottom:1px solid #666666; width:8%;  text-align:center;' >$percent_total_ggc</td> ";
         }
         else
         {
             continue;
         }
     }
     else
     {
         if ($estado=='-1')
         {
             $percent_total_ggc = format_decimal(0);
              echo "   <td style='background:#FFFFFF; border-bottom:1px solid #666666; width:7%;  text-align:center;' >$percent_total_ggc</td> ";
         }
         else
         {
             if ($estado==$Vet['em_estado'])
             {
              $percent_total_ggc = format_decimal(0);
              echo "   <td style='background:#FFFFFF; border-bottom:1px solid #666666; width:7%; text-align:center;' >$percent_total_ggc</td> ";

             }
         }
     }
}
echo "</tr>";




//p($vetObras);

//p(' bbbbbbb '.$opcao_obras);


// % geral do ggc
echo "<tr class='linha_cab_tabela_pa' style='background:#C0C0C0; color:#666666;' >  ";

echo "   <td style='border-bottom:1px solid #666666; width:20%; color:#0080C0; text-align:right; font-weight: bold; font-size: 12px;' >% GGC</td> ";
    $sp=($colspantotal-1);
    $percent_total_ggc = format_decimal(0);
echo "   <td style='background:#FFFFFF;border-bottom:1px solid #666666; width:7%; text-align:center;' >{$percent_total_ggc}</td> ";

echo "   <td style='background:#FFFFFF; border-bottom:1px solid #666666;  width:72%; ' colspan='{$sp}' >&nbsp;</td> ";


echo "</tr>";


echo "<tr class='linha_cab_tabela_pa' style='background:#FFFFFF;' >  ";
    $sp=($colspantotal);
    echo "   <td style=' width:7%; colspan='{$sp}' >&nbsp;</td> ";
echo "</tr>";



echo "<tr class='linha_cab_tabela_pa'>  ";
echo "   <td style='width:20%;' >Ítem</td> ";

//p($Vopcao_obras_idt);

//p(' bbbbbbb '.$opcao_obras);


ForEach ($vetObras as $idx => $Vet)
{

     $nome_obra = $Vet['em_descricao'].'<br>'.$Vet['em_estado'];
     if ($opcao_obras=='E')
     {
         $em_idt = $Vet['em_idt'];
         //p( ' aaaa '.$em_idt. ' bbbb '.$Vopcao_obras_idt[$em_idt]);
         if ($em_idt==$Vopcao_obras_idt[$em_idt])
         {
              echo "   <td style='width:7%;' >$nome_obra</td> ";
         }
         else
         {
             continue;
         }
     }
     else
     {
         if ($estado=='-1')
         {
             echo "   <td style='width:7%;' >$nome_obra</td> ";
         }
         else
         {
             if ($estado==$Vet['em_estado'])
             {
                 echo "   <td style='width:7%;' >$nome_obra</td> ";
             }
         }
     }
}
echo "</tr>";

$itgrupo=0;
$itele = 0;
ForEach ($vetNatrizObraAss as $idx => $Vet)
{
   $vet_func=$Vet['func'];
   $vet_obra=$Vet['obra'];
   // monta função;
   $sf_idt        = $vet_func['sf_idt'];
   $sf_nm_funcao  = $vet_func['sf_nm_funcao'];
   $sf_assinatura = $vet_func['sf_assinatura'];
   $sf_cod_classificacao =  $vet_func['sf_cod_classificacao'];
   
   $tam   = strlen($sf_cod_classificacao);
   $des   = str_repeat('&nbsp;', (($tam-2)*1) );
   $nivel = ($tam/2);

   $bgi='';
   $cli='#000000';
   
   if ($nivel==1)
   {
       $itgrupo=$itgrupo+1;
       $des = $des.'&nbsp;&nbsp;'.$itgrupo.' - '.mb_strtoupper($sf_nm_funcao);
       $itele = 0;
       $bgi='#C0C0C0;';
   }
   else
   {
       $itele=$itele+1;
       $des = $des.$itele.' - '.$sf_nm_funcao;
       $bgi='#FFFFFF;';
   }
   
   echo "<tr class= 'linha_tabela_pa' >";
   echo "<td class='linha_tabela_pa_l' style='font-weight: bold; background:{$bgi}; width:25%; color:{$cli}; text-align:left;'>{$des}</td>";
   // monta colunas
   ForEach ($vet_obra as $idxo => $Vet_o)

   {
        $em_idt    = $Vet_o['em_idt'];
        $em_estado = $Vet_o['em_estado'];
        $ativo     = $Vet_o['ativo'];
        $assina    = $Vet_o['assina'];
        $data      = $Vet_o['data'];
        $versao    = $Vet_o['versao'];
        $assinante = $Vet_o['assinante'];
        
        
        if ($opcao_obras=='E')
        {
            if ($em_idt!=$Vopcao_obras_idt[$em_idt])
            {
                continue;
            }
        }
        
        $colw  = '';
       // $colw  .= $ativo.'<br>';
       // $colw .= $assina.'<br>';
       
       
       
        $bg='#FFFFFF';
        $cc='#000000';
        if  ($assina=='S')
        {   // assinado verde
            //$bg='#00FF40';
            //$colw .= $assinante.' - '.$data.' - '.$versao.'<br>';
            $colw .= '&radic;';
        }
        else
        {
            if  ($ativo=='S')
            {   // ativo e não assinado vermelho
              //  $bg='#FF0000';
                $cc='#FF0000';
                $colw .= '&Chi;';
            }
            else
            {   // não ativo amarelo
              //  $bg='#FFFF80';
                $colw .= 'N/A';
            }
        }
        if ($nivel==1)
        {
            $bg='#C0C0C0';
            $cc='#000000';
            if  ($ativo!='S')
            {   // ativo e não assinado vermelho
                $colw = '&nbsp;';
            }
        }
        if ($estado=='-1')
        {
            echo "<td class='linha_tabela_pa_l' style='background:{$bg}; color:{$cc}; ' >".$colw."</td>";
        }
        else
        {
            if ($estado==$em_estado)
            {
                echo "<td class='linha_tabela_pa_l' style='background:{$bg}; color:{$cc}; ' >".$colw."</td>";
            }
        }
   }
   echo "</tr>";
}
echo "</table>";

$where='';

$sql  = 'select ';
$sql .= ' at.*, ';
$sql .= ' ac.dia as ac_dia, ';
$sql .= ' ac.mes as ac_mes, ';
$sql .= ' ac.ano as ac_ano, ';
$sql .= ' em.idt as em_idt, ';
$sql .= ' em.estado as em_estado, ';
$sql .= ' em.descricao as em_descricao, ';
$sql .= ' sf.nm_funcao as sf_nm_funcao, ';
$sql .= ' sf.cod_classificacao as sf_cod_classificacao, ';
$sql .= ' us.nome_completo as us_nome_completo ';
$sql .= ' from  assina_tela at ';
$sql .= ' inner join assina_controle ac on ac.idt = at.idt_assina_controle';
$sql .= ' inner join site_funcao sf on sf.cod_assinatura = at.assinatura';
$sql .= ' inner join usuario us on us.id_usuario = at.idt_usuario';
$sql .= ' inner join empreendimento em on em.idt = at.idt_empreendimento';
//$sql .= ' where at.idt_empreendimento = '.null($vetFiltro['empreendimento']['valor']);
$sql .= ' where ac.idt = '.null($vetFiltro['assinatura_controle']['valor']);
if ($estado!='-1')
{

    $sql .= ' and em.estado = '.aspa($vetFiltro['estado']['valor']);

}

$titulo_rel=' Lista de Assinantes - Controle de '.$ac_data;

$sql .= ' order by ac.ano desc, ac.mes desc , ac.dia desc, em.estado, em.descricao, em.idt, sf.cod_classificacao, us.nome_completo, at.versao desc';
$rs = execsql($sql);

echo "<br /><br />";

echo "<table class='Geral_t_pa' width='100%' border='0' cellspacing='0' cellpadding='0' vspace='0' hspace='0'> ";
echo "<tr class='linha_cab_tabela_t_pa'>  ";
echo "   <td style='text-align:center;'  colspan='6' >&nbsp;$titulo_rel</td> ";
echo "</tr>";
echo "<tr class='linha_cab_tabela_t_pa'>  ";
echo "   <td style='text-align:center;'  colspan='6' >&nbsp;$subtitulo_rel</td> ";
echo "</tr>";
echo "</table>";

if  ($rs->rows==0)
{
     $msg= "<br><b>Não tem Resultados para Assinaturas.</b><br><br>";
     echo "<table class='Geral' width='100%' border='0' cellspacing='0' cellpadding='0' vspace='0' hspace='0'> ";
     echo "<tr class='linha_cab_tabela'>  ";
     echo "   <td style='text-align:center;' >&nbsp;$msg</td> ";
     echo "</tr>";
     echo "</table>";
}
else
{

     echo "<table class='Geral_pa' width='100%' border='1' cellspacing='0' cellpadding='0' vspace='0' hspace='0'> ";
     echo "<tr class='linha_cab_tabela_pa'>  ";
//     echo "   <td style='width:10%;' >Controle</td> ";
     echo "   <td style='width:10%;' >Estado</td> ";
     echo "   <td style='width:10%;' >Obra</td> ";
     echo "   <td style='width:15%;' >Menu</td> ";
     echo "   <td style='width:15%;' >Data<br />Assinatura</td> ";
     echo "   <td style='width:10%;' >Versão<br />Assinatura</td> ";
     echo "   <td style='width:20%;' >Usuário<br />Assinante</td> ";
     echo "</tr>";
     $em_estado_ant='#';
     $em_idt_ant=0;
     ForEach($rs->data as $row) {
        $ac_data                  = $row['ac_dia'].'/'.$row['ac_mes'].'/'.$row['ac_ano'];
        $em_idt                   = $row['em_idt'];
        $em_estado                = $row['em_estado'];
        $em_descricao             = $row['em_descricao'];
        $at_data                  = trata_data($row['data']);
        $at_versao                = $row['versao'];
        $us_nome_completo         = $row['us_nome_completo'];
        $sf_cod_classificacao     = $row['sf_cod_classificacao'];
        $sf_nm_funcao             = $row['sf_nm_funcao'];
        $tam = strlen($sf_cod_classificacao);
        $des = str_repeat('&nbsp;', (($tam-2)*1) );
        $des = '';
        echo "<tr class= 'linha_tabela_pa' >";
  //      echo "<td class='linha_tabela_pa_l' >".$ac_data."</td>";
        if ($em_estado_ant!=$em_estado)
        {
            echo "<td class='linha_tabela_pa_l' >".$em_estado."</td>";
            $em_estado_ant = $em_estado;

        }
        else
        {
            echo "<td class='linha_tabela_pa_l' >".'&nbsp;'."</td>";

        }
        if ($em_idt_ant!=$em_idt)
        {
            echo "<td class='linha_tabela_pa_l' >".$em_descricao."</td>";
            $em_idt_ant = $em_idt;

        }
        else
        {
            echo "<td class='linha_tabela_pa_l' >".'&nbsp;'."</td>";

        }


        echo "<td class='linha_tabela_pa_l' >{$des}".$sf_nm_funcao."</td>";
        echo "<td class='linha_tabela_pa_l' >".$at_data."</td>";
        echo "<td class='linha_tabela_pa_l' >".$at_versao."</td>";
        echo "<td class='linha_tabela_pa_l' >".$us_nome_completo."</td>";
        echo "</tr>";
    }
    echo "</table>";
}





// rodapé
if ($_GET['print'] == 's')
{
   /*
   echo " <table class='Geral' width='100%' border='0' cellspacing='0' cellpadding='0' vspace='0' hspace='0'>";
   echo " <tr class='linha_cab_tabela'>";
   echo "   <td align='center'><img src='imagens/rodape_rel.jpg'/></td>";
   echo " </tr>";
   echo " </table>";
   */
}
?>
</form>

