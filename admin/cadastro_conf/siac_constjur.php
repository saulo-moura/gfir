<?php
$tabela = 'db_pir_siac.constjur';
$id = 'idt';

$vetCampo['CodConst']        = objInteiro('CodConst', 'Código', True, 6, 6);
$vetCampo['DescConst']       = objTexto('DescConst', 'Descrição', True, 50, 50);
$vetCampo['DescAbrevConst']  = objTexto('DescAbrevConst', 'Descrição Abreviada', True, 50, 50);
$vetCampo['Atende']          = objCmbVetor('Atende', 'Atende', True, $vetSimNao);
$vetCampo['Cadastro']        = objCmbVetor('Cadastro', 'Cadastro', True, $vetSimNao);
$vetCampo['Parceiro']        = objCmbVetor('Parceiro', 'Parceiro', True, $vetSimNao);
$vetCampo['Situacao']        = objCmbVetor('Situacao', 'Situação', True, $vetSimNao);
//
$maxlength  = 700;
$style      = "width:700px;";
$js         = "";
$vetCampo['detalhe'] = objTextArea('detalhe', 'Detalhe', false, $maxlength, $style, $js);
//$sql = "select idt, codigo, descricao from plu_estado order by descricao";
//$vetCampo['idt_estado'] = objCmbBanco('idt_estado', 'Estado', true, $sql,'','width:180px;');
$vetFrm = Array();
$vetFrm[] = Frame('<span>Identificação</span>', Array(
    Array($vetCampo['CodConst'],'',$vetCampo['DescConst'],'',$vetCampo['Situacao']),
),$class_frame,$class_titulo,$titulo_na_linha);

$vetFrm[] = Frame('<span>Complemento</span>', Array(
    Array($vetCampo['DescAbrevConst'],'',$vetCampo['Cadastro'],'',$vetCampo['Atende'],'',$vetCampo['Parceiro']),
),$class_frame,$class_titulo,$titulo_na_linha);
//$vetFrm[] = Frame('<span>Resumo</span>', Array(
//    Array($vetCampo['detalhe']),
//),$class_frame,$class_titulo,$titulo_na_linha);

$vetCad[] = $vetFrm;
?>
