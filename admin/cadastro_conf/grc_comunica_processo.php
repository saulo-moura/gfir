<?php
$tabela = 'grc_comunica_processo';
$id = 'idt';

$js = " readonly=true style='background:#FFFF80;' ";
$vetCampo['codigo']    = objTexto('codigo', 'Código', True, 15, 45,$js);
$jst = " style='width:99%;' ";
$vetCampo['descricao'] = objTexto('descricao', 'Descrição', True, 60, 120,$jst);

//$sql  = "select idt, descricao from grc_atendimento_tipo_box ";
//$sql .= " order by descricao";
//$vetCampo['idt_tipo_box'] = objCmbBanco('idt_tipo_box', 'Tipo de Guichê', true, $sql,' ','width:200px;');
$vetCampo['ativo']     = objCmbVetor('ativo', 'Ativo?', True, $vetSimNao,'');

if ($_GET['veio']=='pa')
{
    $origem='P';
}
else
{
    $origem='A';

}
$vetCampo['origem']     = objHidden('origem',$origem);



$sql = "select idt, codigo, descricao from grc_prazo_sms order by codigo";
$vetCampo['prazo'] = objCmbBanco('prazo', 'Prazo de Envio', false, $sql,' ','width:100px;');


$vetCampo['quando']     = objCmbVetor('quando', 'Quando?', false, $vetAgendaQ,' ');

//
$maxlength  = 700;
$style      = "width:700px;";
$js         = "";
$vetCampo['detalhe'] = objTextArea('detalhe', 'Descrição Resumo', false, $maxlength, $style, $js);
//$sql = "select idt, codigo, descricao from plu_estado order by descricao";
//$vetCampo['idt_estado'] = objCmbBanco('idt_estado', 'Estado', true, $sql,'','width:180px;');
$vetFrm = Array();

MesclarCol($vetCampo['detalhe'], 3);
$vetFrm[] = Frame('', Array(
   // Array($vetCampo['codigo'],'',$vetCampo['descricao'],'',$vetCampo['prazo'],'',$vetCampo['quando']),
    Array($vetCampo['codigo'],'',$vetCampo['descricao']),
	Array($vetCampo['detalhe']),
),$class_frame,$class_titulo,$titulo_na_linha);

/*
$vetFrm[] = Frame('<span>Resumo</span>', Array(
    Array($vetCampo['origem']),
    Array($vetCampo['detalhe']),
),$class_frame,$class_titulo,$titulo_na_linha);
*/
$vetCad[] = $vetFrm;
?>