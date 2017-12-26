<?php
$tabela = 'grc_formulario_guia';
$id = 'idt';

$sistema_origem = DecideSistema();
$mede = $_GET['mede'];
$grupo="";

$vetGrupo=Array();
if ($sistema_origem=='GEC')
{
	$vetGrupo['GC'] ='Gestão de Credenciados';
	$grupo="GC";
}
else
{
	if ($mede!='S')
	{
	    $vetGrupo['NAN']='Negócio a Negócio';
		$grupo="NAN";
	}
    else
    {
	    $vetGrupo['MEDE']='MEDE';
		$grupo="MEDE";
    }
}


$vetCampo['grupo']     = objCmbVetor('grupo', 'Grupo', True, $vetGrupo,'');
$vetCampo['codigo']    = objTexto('codigo', 'Classificação', True, 15, 45);
$vetCampo['descricao'] = objTexto('descricao', 'Pergunta de Acesso', True, 60, 120);
$vetCampo['ativo']     = objCmbVetor('ativo', 'Ativo?', True, $vetSimNao,'');
//
$maxlength  = 700;
$style      = "width:700px;";
$js         = "";
$vetCampo['detalhe'] = objTextArea('detalhe', 'Lógica de Acesso', false, $maxlength, $style, $js);






$sql = '';
$sql .= ' select idt, descricao ';
$sql .= ' from grc_formulario_porte ';
$sql .= " where grupo = ".aspa($grupo);
$sql .= ' order by codigo ';
$rs = execsql($sql);
$js1 = " style='width:14em;'";
$vetCampo['idt_porte'] = objCmbBanco('idt_porte', 'Porte', false, $sql, ' ', '', $js1);



$sql = '';
$sql .= ' select idt, descricao ';
$sql .= ' from grc_formulario ';
$sql .= " where grupo = ".aspa($grupo);
$sql .= ' order by codigo ';
$rs = execsql($sql);
$js1 = " style='width:14em;'";
$vetCampo['idt_formulario'] = objCmbBanco('idt_formulario', 'Formulário', false, $sql, ' ', '', $js1);


$vetSituacaoFor=Array();
$vetSituacaoFor[1]="Formal";
$vetSituacaoFor[2]="Informal";
$vetCampo['situacao']     = objCmbVetor('situacao', 'Situação', True, $vetSituacaoFor,'');




$vetFrm = Array();
$vetFrm[] = Frame('<span>Identificação</span>', Array(
    Array($vetCampo['grupo'],'',$vetCampo['codigo'],'',$vetCampo['descricao'],'',$vetCampo['ativo']),
),$class_frame,$class_titulo,$titulo_na_linha);


$vetFrm[] = Frame('<span>Resumo</span>', Array(
    Array($vetCampo['detalhe']),
),$class_frame,$class_titulo,$titulo_na_linha);

$vetFrm[] = Frame('', Array(
    //Array($vetCampo['idt_tema_subtema']),
     Array($vetCampo['idt_porte'],'',$vetCampo['situacao'],'',$vetCampo['idt_formulario']),
),$class_frame,$class_titulo,$titulo_na_linha);

/*
$vetFrm[] = Frame('<span>Focos Temáticos</span>', Array(
    Array($vetCampo['idt_tema_subtema']),
    Array($vetCampo['idt_tema']),
),$class_frame,$class_titulo,$titulo_na_linha);
*/


$vetCad[] = $vetFrm;
?>