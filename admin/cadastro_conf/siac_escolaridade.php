<?php
$tabela = 'db_pir_siac.escolaridade';
$id = 'idt';

$vetCampo['CodGrauEscol']    = objTexto('CodGrauEscol', 'Código', True, 6, 6);
$vetCampo['DescGrauEscol']   = objTexto('DescGrauEscol', 'Descrição', True, 50, 50);
$vetCampo['Situacao']      = objCmbVetor('Situacao', 'Situacao', True, $vetSimNao);
//
$maxlength  = 700;
$style      = "width:700px;";
$js         = "";
$vetCampo['detalhe'] = objTextArea('detalhe', 'Detalhe', false, $maxlength, $style, $js);
//$sql = "select idt, codigo, descricao from plu_estado order by descricao";
//$vetCampo['idt_estado'] = objCmbBanco('idt_estado', 'Estado', true, $sql,'','width:180px;');
$vetFrm = Array();
$vetFrm[] = Frame('<span>Identificação</span>', Array(
    Array($vetCampo['CodGrauEscol'],'',$vetCampo['DescGrauEscol'],'',$vetCampo['Situacao']),
),$class_frame,$class_titulo,$titulo_na_linha);


//$vetFrm[] = Frame('<span>Resumo</span>', Array(
//    Array($vetCampo['detalhe']),
//),$class_frame,$class_titulo,$titulo_na_linha);

$vetCad[] = $vetFrm;
?>
