<?php
$tabela = 'grc_pendencia_recorrencia';
$id = 'idt';
$vetCampo['codigo']    = objTexto('codigo', 'Código Ação', True, 15, 45);
$vetCampo['descricao'] = objTexto('descricao', 'Descrição', True, 60, 120);
//$vetCampo['ativo']     = objCmbVetor('ativo', 'Ativo?', True, $vetSimNao,'');

$vetPeriodicidade=Array();
$vetPeriodicidade[0]='Diária';
$vetPeriodicidade[1]='Mensal - mesmo dia';
$vetPeriodicidade[2]='Mensal - No último Dia';
$vetCampo['periodicidade']  = objCmbVetor('periodicidade', 'Periodicidade', True, $vetPeriodicidade,'');
$vetCampo['periodo'] = objInteiro('periodo', 'Periodo', True, 10);

$vetCampo['ordem'] = objInteiro('ordem', 'Recorrência', True, 10);

//
$maxlength  = 700;
$style      = "width:700px;";
$js         = "";
$vetCampo['observacao'] = objTextArea('observacao', 'Observação', false, $maxlength, $style, $js);

$vetFrm = Array();
MesclarCol($vetCampo['periodo'], 3);
$vetFrm[] = Frame('<span>Identificação</span>', Array(
    Array($vetCampo['codigo'],'',$vetCampo['ordem'],'',$vetCampo['descricao']),
	Array($vetCampo['periodicidade'],'',$vetCampo['periodo']),
),$class_frame,$class_titulo,$titulo_na_linha);


$vetFrm[] = Frame('<span>Observação</span>', Array(
    Array($vetCampo['observacao']),
),$class_frame,$class_titulo,$titulo_na_linha);

$vetCad[] = $vetFrm;
?>
