<?php
Require_Once('configuracao.php');

if ($_REQUEST['menu'] == '')
 	$menu = 'vazio';
else
	$menu = $_REQUEST['menu'];

if ($_REQUEST['prefixo'] == '')
	$prefixo = 'inc';
else
	$prefixo = $_REQUEST['prefixo'];


if ($_REQUEST['titulo_rel'] == '')
    $nome_titulo='';
else
	$nome_titulo = $_REQUEST['titulo_rel'];

if ($_REQUEST['origem'] == '')
    $origem='';
else
	$origem = $_REQUEST['origem'];

if ($_REQUEST['id_versao'] == '')
    $idt_versao='';
else
	$idt_versao = $_REQUEST['id_versao'];
if ($_REQUEST['idt_obra'] == '')
    $idt_obra='';
else
	$idt_obra = $_REQUEST['idt_obra'];


if ($_GET['seg']=='')
{
  echo ' <div style="display:block; width:100%; height:100%; font-size:34px; text-align:center; background:#600000; color:#FFFFFF; font-weight: bold;"> ';

  echo ' <div style="display:block; font-size:34px; text-align:center; background:#600000; color:#FFFFFF; font-weight: bold; padding-top:100px;"> ';
  $path     = 'obj_file/empreendimento/';
  $kwherew  = ' where em.idt = '.null($idt_obra);
  $sqlx     = 'select ';
  $sqlx    .= ' em.imagem , em.descricao  ';
  $sqlx    .= ' from  ';
  $sqlx    .= ' empreendimento em  ';
  $sqlx    .= $kwherew;
  $rsx = execsql($sqlx);
  ForEach($rsx->data as $rowx)
  {
     $img_empreendimento = $rowx['imagem'];
     $nm_empreendimento  = $rowx['descricao'];
     ImagemMostrar(305, 115, $path, $img_empreendimento, $nm_empreendimento, false);
    // $dd  = $path.$img_empreendimento;
    // $img = "<img border='0' src='".$dd."' title='$nm_empreendimento' alt='$dd' >";
     echo $img;
     echo '<br />';
     echo "<span style=''>{$nm_empreendimento}</span>";
     echo '<br />';
     echo "<span style=''>PQO</span>";
     
  }


  echo ' </div>';

  echo '<br />';
  echo "<span>Aguarde... Gerando PDF<br /><br />Essa operação pode demorar alguns minutos...</span>";
  
  echo '</div>';

  echo '<script type="text/javascript">';
  echo " var link='conteudo_pdf_pqo.php?&prefixo=inc&menu=pqo_pdf&print=s&seg=S&id_versao={$idt_versao}&idt_obra={$idt_obra}';";
  echo " self.location = link; ";
  echo '</script>';
}
else
{
  set_time_limit(360);
  $path='incpqo_pdf.php';
  Require_Once($path);
}
?>



