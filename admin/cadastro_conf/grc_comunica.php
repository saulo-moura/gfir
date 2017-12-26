<?php
$tabela = 'grc_comunica';
$_GET['veio']='pa';
if ($_GET['veio']=='pa')
{
    $origem='P';
	$js = "";
	//$js = " readonly=true style='background:#FFFF80;' ";
}
else
{
    $origem='A';
    $js = " readonly=true style='background:#FFFF80;' ";
}

$id = 'idt';

$vetCampo['codigo']    = objTexto('codigo', 'Código', True, 15, 45,$js);

//$titulo='Título do E-mail/Texto SMS';
$titulo='Título do E-mail';
$jst = " style='width:99%;'";
$vetCampo['descricao'] = objTexto('descricao', $titulo, True, 60, 120,$jst);
//$vetCampo['ativo']     = objCmbVetor('ativo', 'Ativo?', True, $vetSimNao,'');

$vetCampo['origem']     = objHidden('origem',$origem);



//
$maxlength  = 2000;
$style      = "width:700px;";
$js         = "";
//$vetCampo['detalhe'] = objTextArea('detalhe', 'Conteúdo', false, $maxlength, $style, $js);

// $vetCampo['detalhe'] = objHtml('detalhe', 'Corpo do EMAIL', false, '100', '', '', false, false, true);

//$titulo='Corpo do EMAIL  / Detalhe Texto SMS';
$titulo='Corpo do EMAIL';
$vetCampo['detalhe'] = objHtml('detalhe',$titulo, true);


$sql  = "select idt, descricao from grc_comunica_processo "; 
//$sql .= " where origem = ".aspa($origem);
$sql .= " order by descricao";


$vetCampo['idt_processo'] = objCmbBanco('idt_processo', 'Processo', true, $sql,'','width:100%;');

$vetTipoAESX=Array();
$vetTipoAESX['E-mail']='E-mail';
$js = " disabled style='background:#FFFF80;' ";
$vetCampo['tipo']     = objCmbVetor('tipo', 'Tipo?', True, $vetTipoAESX,'',$js);

MesclarCol($vetCampo['idt_processo'], 3);
MesclarCol($vetCampo['descricao'], 3);
MesclarCol($vetCampo['detalhe'], 3);
$vetFrm = Array();
$vetFrm[] = Frame('', Array(
    //Array($vetCampo['codigo'],'',$vetCampo['descricao'],'',$vetCampo['idt_processo'],'',$vetCampo['tipo'],'',$vetCampo['ativo']),
	//Array($vetCampo['codigo'],'',$vetCampo['descricao'],'',$vetCampo['idt_processo'],'',$vetCampo['ativo']),
	
	Array($vetCampo['codigo'],'',$vetCampo['tipo']),
	Array($vetCampo['descricao']),
	Array($vetCampo['idt_processo']),
	Array($vetCampo['detalhe']),
),$class_frame,$class_titulo,$titulo_na_linha);

/*
$vetFrm[] = Frame('', Array(
    Array($vetCampo['origem']),
    Array($vetCampo['detalhe']),
),$class_frame,$class_titulo,$titulo_na_linha);
*/
$vetCad[] = $vetFrm;
?>

