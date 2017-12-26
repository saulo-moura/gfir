<?php

$TabelaPai   = "gec_tipo_servico";
$AliasPai    = "gec_ts";
$EntidadePai = "Tipo  de Servi�o";
$CampoPricPai= "idt_tipo_servico";

$TabelaPrinc      = "gec_tipo_servico_documento";
$AliasPric        = "gec_tsd";
$Entidade         = "Documento do Tipo do Servi�o";
$Entidade_p       = "Documentos do Tipo do Servi�o";

$tabela = $TabelaPrinc;

$id = 'idt';
$vetCampo[$CampoPricPai] = objFixoBanco($CampoPricPai, $EntidadePai, $TabelaPai, 'idt', 'descricao', 0);
$sql = "select idt, descricao from gec_documento order by descricao";
$vetCampo['idt_documento'] = objCmbBanco('idt_documento', 'Documento', true, $sql,'','width:180px;');

$vetCampo['ativo']     = objCmbVetor('ativo', 'Ativo?', True, $vetSimNao,'');


$maxlength  = 2000;
$style      = "width:700px;";
$js         = "";
$vetCampo['observacao'] = objTextArea('observacao', 'Observa��o', false, $maxlength, $style, $js);


$vetFrm = Array();
$vetFrm[] = Frame('<span>Tipo de Servi�o</span>', Array(
    Array($vetCampo[$CampoPricPai]),
),$class_frame,$class_titulo,$titulo_na_linha);
$vetFrm[] = Frame('<span>Documento do Tipo de Servi�o</span>', Array(
    Array($vetCampo['idt_documento']),
    Array($vetCampo['ativo']),
),$class_frame,$class_titulo,$titulo_na_linha);

$vetFrm[] = Frame('<span>Observa��o</span>', Array(
    Array($vetCampo['observacao']),
),$class_frame,$class_titulo,$titulo_na_linha);


$vetCad[] = $vetFrm;
?>