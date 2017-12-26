<?php
$tabela = 'db_pir_siac.porte';
$id = 'idt';

$vetCampo['codPorte']        = objInteiro('codPorte', 'Código', True, 6, 6);
$vetCampo['porte']           = objTexto('porte', 'Descrição', True, 50, 50);
$vetCampo['Situacao']        = objCmbVetor('Situacao', 'Situacao', True, $vetSimNao);

$vetCampo['nummaxfunc']      = objInteiro('nummaxfunc', 'Num. Máximo Funcionarios', false,6, 6);
$vetCampo['numminfunc']      = objInteiro('numminfunc', 'Num. Mínimo Funcionarios', false, 6, 6);

$vetCampo['FaturamentoMIN']      = objDecimal('FaturamentoMIN', 'Faturamento Mínimo', false, 16, 16);
$vetCampo['FaturamentoMAX']      = objDecimal('FaturamentoMAX', 'Faturamento Máximo', false, 16, 16);

//
$maxlength  = 255;
$style      = "width:700px;";
$js         = "";
$vetCampo['DescPorte'] = objTextArea('DescPorte', 'Descrição Detalhada', false, $maxlength, $style, $js);
//$sql = "select idt, codigo, descricao from plu_estado order by descricao";
//$vetCampo['idt_estado'] = objCmbBanco('idt_estado', 'Estado', true, $sql,'','width:180px;');
$vetFrm = Array();
$vetFrm[] = Frame('<span>Identificação</span>', Array(
    Array($vetCampo['codPorte'],'',$vetCampo['porte'],'',$vetCampo['Situacao']),
),$class_frame,$class_titulo,$titulo_na_linha);

$vetFrm[] = Frame('<span>Complemento</span>', Array(
    Array($vetCampo['numminfunc'],'',$vetCampo['nummaxfunc']),
    Array($vetCampo['FaturamentoMIN'],'',$vetCampo['FaturamentoMAX']),
),$class_frame,$class_titulo,$titulo_na_linha);


$vetFrm[] = Frame('<span>Descrição Detalhada</span>', Array(
    Array($vetCampo['DescPorte']),
),$class_frame,$class_titulo,$titulo_na_linha);

$vetCad[] = $vetFrm;
?>
