<style>
#nm_funcao_desc label{
}
#nm_funcao_obj {
}
.Tit_Campo {
}
.Tit_Campo_Obr {
}
fieldset.class_frame {
    background:#ECF0F1;
    border:1px solid #14ADCC;
}
div.class_titulo {
    background: #ABBBBF;
    border    : 1px solid #14ADCC;
    color     : #FFFFFF;
    text-align: left;
}
div.class_titulo span {
    padding-left:10px;
}
</style>

<?php

//p($_GET);

if ($_GET['idCad'] != '') {
   $_GET['idt0'] = $_GET['idCad'];
   $botao_volta = "parent.btFechaCTC('".$_GET['session_cod']."');";
   $botao_acao = '<script type="text/javascript">parent.btFechaCTC("'.$_GET['session_cod'].'");</script>';
}
//p($_GET);

$TabelaPai   = "grc_produto";
$AliasPai    = "grc_atd";
$EntidadePai = "Produto";
$idPai       = "idt";

//
$TabelaPrinc      = "grc_produto_insumo";
$AliasPric        = "grc_proins";
$Entidade         = "Insumo Associado do Produto";
$Entidade_p       = "Insumos Associado do Produto";
$CampoPricPai     = "idt_produto";

$tabela = $TabelaPrinc;

$id = 'idt';
$vetCampo[$CampoPricPai] = objFixoBanco($CampoPricPai, $EntidadePai, $TabelaPai, 'idt', 'descricao', 0);

$vetCampo['codigo']    = objTexto('codigo', 'Código', True, 15, 45);
$vetCampo['descricao'] = objTexto('descricao', 'Descrição', True, 60, 120);
$vetCampo['ativo']     = objCmbVetor('ativo', 'Ativo?', True, $vetSimNao);
//
$maxlength  = 2000;
$style      = "width:700px;";
$js         = "";
$vetCampo['detalhe'] = objTextArea('detalhe', 'Detalhe', false, $maxlength, $style, $js);


$sql  = "select idt, codigo, descricao from grc_insumo ";
$sql .= " order by codigo";
$vetCampo['idt_insumo'] = objCmbBanco('idt_insumo', 'Insumo Associado', true, $sql,' ','width:180px;');


$vetCampo['quantidade']    = objDecimal('quantidade','Quantidade',true,15);
$vetCampo['custo_unitario_real'] = objDecimal('custo_unitario_real','Custo Unitario (R$)',true,15);
$vetCampo['por_participante'] = objCmbVetor('por_participante', 'Por Participante?', True, $vetSimNao);

$sql  = "select idt, codigo, descricao from grc_insumo_unidade ";
$sql .= " order by codigo";
$vetCampo['idt_insumo_unidade'] = objCmbBanco('idt_insumo_unidade', 'Unidade', true, $sql,' ','width:180px;');

//
$vetFrm = Array();
$vetFrm[] = Frame('<span>Produto</span>', Array(
    Array($vetCampo[$CampoPricPai]),
),$class_frame,$class_titulo,$titulo_na_linha);

//MesclarCol($vetCampo['idt_situacao'], 3);
$vetFrm[] = Frame('<span>Insumo Associado</span>', Array(
    Array($vetCampo['idt_insumo']),
),$class_frame,$class_titulo,$titulo_na_linha);


$vetFrm[] = Frame('<span>Identificação</span>', Array(
    Array($vetCampo['codigo'],'',$vetCampo['descricao'],'',$vetCampo['ativo']),
),$class_frame,$class_titulo,$titulo_na_linha);


$vetFrm[] = Frame('<span>Resumo</span>', Array(
    Array($vetCampo['detalhe']),
),$class_frame,$class_titulo,$titulo_na_linha);

$vetFrm[] = Frame('<span>Classificação</span>', Array(
    Array($vetCampo['quantidade'],'',$vetCampo['idt_insumo_unidade'],'','',$vetCampo['custo_unitario_real'],'',$vetCampo['por_participante']),
),$class_frame,$class_titulo,$titulo_na_linha);



$vetCad[] = $vetFrm;
?>