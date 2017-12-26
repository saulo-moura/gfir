<?php

$TabelaPai   = "gec_tipo_servico";
$AliasPai    = "gec_ts";
$EntidadePai = "Tipo  de Serviço";
$CampoPricPai= "idt_tipo_servico";

$TabelaPrinc      = "gec_tipo_servico_documento";
$AliasPric        = "gec_tsd";
$Entidade         = "Documento do Tipo do Serviço";
$Entidade_p       = "Documentos do Tipo do Serviço";

$tabela = $TabelaPrinc;

$id = 'idt';
$vetCampo[$CampoPricPai] = objFixoBanco($CampoPricPai, $EntidadePai, $TabelaPai, 'idt', 'descricao', 0);
$sql = "select idt, descricao from gec_documento order by descricao";
$vetCampo['idt_documento'] = objCmbBanco('idt_documento', 'Documento', true, $sql,'','width:180px;');

$vetCampo['ativo']     = objCmbVetor('ativo', 'Ativo?', True, $vetSimNao,'');


$maxlength  = 2000;
$style      = "width:700px;";
$js         = "";
$vetCampo['observacao'] = objTextArea('observacao', 'Observação', false, $maxlength, $style, $js);


$vetFrm = Array();
$vetFrm[] = Frame('<span>Tipo de Serviço</span>', Array(
    Array($vetCampo[$CampoPricPai]),
),$class_frame,$class_titulo,$titulo_na_linha);
$vetFrm[] = Frame('<span>Documento do Tipo de Serviço</span>', Array(
    Array($vetCampo['idt_documento']),
    Array($vetCampo['ativo']),
),$class_frame,$class_titulo,$titulo_na_linha);

$vetFrm[] = Frame('<span>Observação</span>', Array(
    Array($vetCampo['observacao']),
),$class_frame,$class_titulo,$titulo_na_linha);


$vetCad[] = $vetFrm;
?>