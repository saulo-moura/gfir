<?php

if ($_GET['idCad'] != '') {
   $_GET['idt0'] = $_GET['idCad'];
   $botao_volta = "parent.btFechaCTC('".$_GET['session_cod']."');";
   $botao_acao = '<script type="text/javascript">parent.btFechaCTC("'.$_GET['session_cod'].'");</script>';
}

//
$TabelaPai    = "gec_entidade_mercado";
$AliasPai     = "gec_em";
$EntidadePai  = "Mercado da Entidade";
$idPai        = "idt";
//
//
$TabelaPrinc      = "gec_entidade_mercado_produto";
$AliasPric        = "gec_emp";
$Entidade         = "Produto do Mercado";
$Entidade_p       = "Produtos do Mercado";
$CampoPricPai     = "idt_entidade_mercado";

$tabela = $TabelaPrinc;

$id = 'idt';
$vetCampo[$CampoPricPai] = objFixoBanco($CampoPricPai, $EntidadePai, $TabelaPai, 'idt', 'data_inicio', 1);


$vetCampo['data_inicio'] = objDatahora('data_inicio', 'Data Inicio', true);
$vetCampo['data_termino']   = objDatahora('data_termino', 'Data Termino', false);

$maxlength  = 2000;
$style      = "width:700px;";
$js         = "";
$vetCampo['detalhe'] = objTextArea('detalhe', 'Detalhe', false, $maxlength, $style, $js);

$sql  = "select idt, codigo, descricao from gec_mercado_produto ";
$sql .= " order by codigo";
$vetCampo['idt_produto'] = objCmbBanco('idt_produto', 'Produto', true, $sql,' ','width:280px;');

$vetCampo['ativo']     = objCmbVetor('ativo', 'Ativo?', True, $vetSimNao);



//
$vetFrm = Array();
$vetFrm[] = Frame('<span>Mercado</span>', Array(
    Array($vetCampo[$CampoPricPai]),
),$class_frame,$class_titulo,$titulo_na_linha);

//MesclarCol($vetCampo['ativo'], 7);

$vetFrm[] = Frame('<span>Produto</span>', Array(
    Array($vetCampo['idt_produto'],'',$vetCampo['data_inicio'],'',$vetCampo['data_termino'],'',$vetCampo['ativo']),
),$class_frame,$class_titulo,$titulo_na_linha);

$vetFrm[] = Frame('<span>Observações</span>', Array(
    Array($vetCampo['detalhe']),
),$class_frame,$class_titulo,$titulo_na_linha);

$vetCad[] = $vetFrm;
?>