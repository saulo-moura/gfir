<?php
$tabela = 'grc_evento_situacao';
$id = 'idt';
$vetCampo['codigo']    = objTexto('codigo', 'Código', True, 15, 45);
$vetCampo['descricao'] = objTexto('descricao', 'Descrição', True, 60, 120);
$vetCampo['ativo']     = objCmbVetor('ativo', 'Ativo?', True, $vetSimNao);

$vetEtapaSit=Array();
$vetEtapaSit['D']='Desenvolvimento';
$vetEtapaSit['A']='Aprovação';
$vetEtapaSit['E']='Execução';

$vetEtapaSit['P']='Pendência';
$vetEtapaSit['C']='Parado';

$vetCampo['vai_para']   = objTexto('vai_para', 'Vai Para', false, 60, 120);
$vetCampo['volta_para'] = objTexto('volta_para', 'Valta Para', false, 60, 120);


$vetCampo['situacao_etapa']     = objCmbVetor('situacao_etapa', 'Etapa', True, $vetEtapaSit);
//
$maxlength  = 700;
$style      = "width:700px;";
$js         = "";
$vetCampo['detalhe'] = objTextArea('detalhe', 'Detalhe', false, $maxlength, $style, $js);


//$sql = "select idt, codigo, descricao from plu_estado order by descricao";
//$vetCampo['idt_estado'] = objCmbBanco('idt_estado', 'Estado', true, $sql,'','width:180px;');
$vetFrm = Array();
$vetFrm[] = Frame('<span>Identificação</span>', Array(
    Array($vetCampo['codigo'],'',$vetCampo['descricao'],'',$vetCampo['situacao_etapa'],'',$vetCampo['ativo']),
),$class_frame,$class_titulo,$titulo_na_linha);


$vetFrm[] = Frame('<span>Sucessoras</span>', Array(
    Array($vetCampo['vai_para']),
),$class_frame,$class_titulo,$titulo_na_linha);


$vetFrm[] = Frame('<span>Predecessoras</span>', Array(
    Array($vetCampo['volta_para']),
),$class_frame,$class_titulo,$titulo_na_linha);


$vetFrm[] = Frame('<span>Resumo</span>', Array(
    Array($vetCampo['detalhe']),
),$class_frame,$class_titulo,$titulo_na_linha);

$vetCad[] = $vetFrm;
?>