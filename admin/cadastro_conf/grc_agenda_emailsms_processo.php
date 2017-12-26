<?php
$tabela = 'grc_agenda_emailsms_processo';
$id = 'idt';

$vetCampo['codigo']    = objTexto('codigo', 'Código', True, 15, 45);
$vetCampo['descricao'] = objTexto('descricao', 'Descrição', True, 60, 120);

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
$vetCampo['detalhe'] = objTextArea('detalhe', 'Detalhe', false, $maxlength, $style, $js);
//$sql = "select idt, codigo, descricao from plu_estado order by descricao";
//$vetCampo['idt_estado'] = objCmbBanco('idt_estado', 'Estado', true, $sql,'','width:180px;');
$vetFrm = Array();


$vetFrm[] = Frame('<span>Identificação</span>', Array(
    Array($vetCampo['codigo'],'',$vetCampo['descricao'],'',$vetCampo['prazo'],'',$vetCampo['quando'],'',$vetCampo['ativo']),
),$class_frame,$class_titulo,$titulo_na_linha);


$vetFrm[] = Frame('<span>Resumo</span>', Array(
    Array($vetCampo['origem']),
    Array($vetCampo['detalhe']),
),$class_frame,$class_titulo,$titulo_na_linha);

$vetCad[] = $vetFrm;
?>