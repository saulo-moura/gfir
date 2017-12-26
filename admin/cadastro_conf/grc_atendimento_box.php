<?php
$tabela = 'grc_atendimento_box';
$id = 'idt';

$TabelaPai   = "".db_pir."sca_organizacao_secao";
$AliasPai    = "sca_os";
$EntidadePai = "PA's";
$idPai       = "idt";



$CampoPricPai     = "idt_organizacao_secao";


$vetCampo[$CampoPricPai] = objFixoBanco($CampoPricPai, $EntidadePai, $TabelaPai, 'idt', 'descricao', 0);


$vetCampo['codigo']    = objTexto('codigo', 'Código', True, 15, 45);
$vetCampo['descricao'] = objTexto('descricao', 'Descrição', True, 60, 120);

$sql  = "select idt, descricao from grc_atendimento_tipo_box ";
$sql .= " order by descricao";
$vetCampo['idt_tipo_box'] = objCmbBanco('idt_tipo_box', 'Tipo de Guichê', true, $sql,' ','width:200px;');
$vetCampo['ativo']     = objCmbVetor('ativo', 'Ativo?', True, $vetSimNao);
//
$maxlength  = 700;
$style      = "width:700px;";
$js         = "";
$vetCampo['detalhe'] = objTextArea('detalhe', 'Detalhe', false, $maxlength, $style, $js);
//$sql = "select idt, codigo, descricao from plu_estado order by descricao";
//$vetCampo['idt_estado'] = objCmbBanco('idt_estado', 'Estado', true, $sql,'','width:180px;');
$vetFrm = Array();

$vetFrm[] = Frame('<span>Ponto de Atendimento</span>', Array(
    Array($vetCampo[$CampoPricPai]),
),$class_frame,$class_titulo,$titulo_na_linha);


$vetFrm[] = Frame('<span>Identificação</span>', Array(
    Array($vetCampo['codigo'],'',$vetCampo['descricao'],'',$vetCampo['idt_tipo_box'],'',$vetCampo['ativo']),
),$class_frame,$class_titulo,$titulo_na_linha);


$vetFrm[] = Frame('<span>Resumo</span>', Array(
    Array($vetCampo['detalhe']),
),$class_frame,$class_titulo,$titulo_na_linha);

$vetCad[] = $vetFrm;
?>