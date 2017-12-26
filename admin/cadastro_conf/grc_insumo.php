<?php
$tabela = 'grc_insumo';
$id = 'idt';

$sql = '';
$sql .= ' select idprd';
$sql .= ' from grc_insumo';
$sql .= ' where idt = '.null($_GET['id']);
$rs = execsql($sql);

if ($rs->data[0][0] != '' && $acao != 'con') {
    $acao = 'con';
    echo '<div class="alert ui-state-highlight ui-corner-all">Não pode alterar este registro, pois ele veio de importação do RM!</div>';
}

$vetCampo['codigo']           = objTexto('codigo', 'Código', True, 15, 45);
$vetCampo['descricao']        = objTexto('descricao', 'Descrição', True, 30, 120);
$vetCampo['ativo']            = objCmbVetor('ativo', 'Ativo?', True, $vetSimNao);

$vetCampo['classificacao']    = objTexto('classificacao', 'Classificação', True, 10, 15);
$vetCampo['custo_unitario_real'] = objDecimal('custo_unitario_real','Custo Unitario (R$)',false,15);
$vetCampo['por_participante'] = objCmbVetor('por_participante', 'Por Participante?', false, $vetSimNao);

$sql  = "select idt, codigo, descricao from grc_insumo_unidade ";
$sql .= " order by codigo";
$vetCampo['idt_insumo_unidade'] = objCmbBanco('idt_insumo_unidade', 'Unidade', false, $sql,' ','width:180px;');

$sql  = "select idt, codigo, descricao from grc_insumo_elemento_custo ";
$sql .= " order by codigo";
$vetCampo['idt_insumo_elemento_custo'] = objCmbBanco('idt_insumo_elemento_custo', 'Elemento de Custo', false, $sql,' ','width:180px;');

$vetCampo['nivel']            = objCmbVetor('nivel', '´Analítico?', True, $vetSimNao);

$vetTipo=Array();
$vetTipo['P']='Produto';
$vetTipo['S']='Serviço';
$vetTipo['R']='Receita';

$vetCampo['tipo']            = objCmbVetor('tipo', 'Tipo', True, $vetTipo);


$vetCampo['sinal']            = objCmbVetor('sinal', 'Despesa?', True, $vetSimNao);


$vetCampo['codigo_rm']        = objTexto('codigo_rm', 'Código RM', false, 10, 120);


//
$maxlength  = 700;
$style      = "width:700px;";
$js         = "";
$vetCampo['detalhe'] = objTextArea('detalhe', 'Detalhe', false, $maxlength, $style, $js);
//$sql = "select idt, codigo, descricao from plu_estado order by descricao";
//$vetCampo['idt_estado'] = objCmbBanco('idt_estado', 'Estado', true, $sql,'','width:180px;');
$vetFrm = Array();
$vetFrm[] = Frame('<span>Identificação</span>', Array(
    Array($vetCampo['codigo'],'',$vetCampo['classificacao'],'',$vetCampo['codigo_rm'],'',$vetCampo['descricao'],'',$vetCampo['nivel'],'',$vetCampo['sinal'],'',$vetCampo['tipo'],'',$vetCampo['ativo']),
),$class_frame,$class_titulo,$titulo_na_linha);


$vetFrm[] = Frame('<span>Custo</span>', Array(
    Array($vetCampo['idt_insumo_unidade'],'',$vetCampo['idt_insumo_elemento_custo'],'',$vetCampo['custo_unitario_real'],'',$vetCampo['por_participante']),
),$class_frame,$class_titulo,$titulo_na_linha);


/*
$vetFrm[] = Frame('<span>Classificação RM</span>', Array(
    Array($vetCampo['codigo_rm']),
),$class_frame,$class_titulo,$titulo_na_linha);
*/



$vetFrm[] = Frame('<span>Resumo</span>', Array(
    Array($vetCampo['detalhe']),
),$class_frame,$class_titulo,$titulo_na_linha);

$vetCad[] = $vetFrm;
?>