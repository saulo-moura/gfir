<?php
$tabela = 'db_pir_siac.categoriaatendimento';
$id = 'idt';

$vetCampo['CodCategoria']    = objInteiro('CodCategoria', 'Código', True, 11,11);
$vetCampo['DescCategoria']   = objTexto('DescCategoria', 'Descrição', True, 70, 100);
$vetCampo['Situacao']        = objTexto('Situacao', 'Situação', True, 10, 2);

$vetCampo['Tipo']             = objTexto('Tipo', 'Tipo', True, 10, 2);

$vetCampo['Individual']        = objCmbVetor('Individual', 'Individual', True, $vetSimNao);
$vetCampo['Grupal']        = objCmbVetor('Grupal', 'Grupal', True, $vetSimNao);
$vetCampo['Universal']        = objCmbVetor('Universal', 'Universal', True, $vetSimNao);
$vetCampo['Ativo']        = objCmbVetor('Ativo', 'Ativo', True, $vetSimNao);

//
$maxlength  = 700;
$style      = "width:700px;";
$js         = "";
$vetCampo['detalhe'] = objTextArea('detalhe', 'Detalhe', false, $maxlength, $style, $js);
//$sql = "select idt, codigo, descricao from plu_estado order by descricao";
//$vetCampo['idt_estado'] = objCmbBanco('idt_estado', 'Estado', true, $sql,'','width:180px;');
$vetFrm = Array();
$vetFrm[] = Frame('<span>Identificação</span>', Array(
    Array($vetCampo['CodCategoria'],'',$vetCampo['DescCategoria'],'',$vetCampo['Situacao']),
),$class_frame,$class_titulo,$titulo_na_linha);

$vetFrm[] = Frame('<span>Complemento</span>', Array(
    Array($vetCampo['Tipo'],'',$vetCampo['Ativo'],'',$vetCampo['Individual'],'',$vetCampo['Grupal'],'',$vetCampo['Universal']),
),$class_frame,$class_titulo,$titulo_na_linha);


//$vetFrm[] = Frame('<span>Resumo</span>', Array(
//    Array($vetCampo['detalhe']),
//),$class_frame,$class_titulo,$titulo_na_linha);

$vetCad[] = $vetFrm;
?>
