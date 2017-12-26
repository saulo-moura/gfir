<?php
$tabela = 'db_pir_siac.aplicacao';
$id = 'idt';

$vetCampo['aplicacaoCodigo']      = objInteiro('aplicacaoCodigo', 'Código', True, 11, 11);
$vetCampo['aplicacaoDescricao']   = objTexto('aplicacaoDescricao', 'Descrição', True, 50, 50);
$vetCampo['ExibirAplicacao']      = objCmbVetor('ExibirAplicacao', 'Exibir a Aplicação', False, $vetSimNao);
$vetCampo['tipo']                 = objTexto('tipo', 'Tipo', False, 10, 1);
$vetCampo['TipoSIAC']             = objTexto('TipoSIAC', 'Tipo SIAC', False, 10,1);
//
$maxlength  = 700;
$style      = "width:700px;";
$js         = "";
$vetCampo['detalhe'] = objTextArea('detalhe', 'Detalhe', false, $maxlength, $style, $js);
//$sql = "select idt, codigo, descricao from plu_estado order by descricao";
//$vetCampo['idt_estado'] = objCmbBanco('idt_estado', 'Estado', true, $sql,'','width:180px;');
$vetFrm = Array();
$vetFrm[] = Frame('<span>Identificação</span>', Array(
    Array($vetCampo['aplicacaoCodigo'],'',$vetCampo['aplicacaoDescricao']),
),$class_frame,$class_titulo,$titulo_na_linha);

$vetFrm[] = Frame('<span>Complemento</span>', Array(
    Array($vetCampo['tipo'],'',$vetCampo['ExibirAplicacao'],'',$vetCampo['TipoSIAC']),
),$class_frame,$class_titulo,$titulo_na_linha);


//$vetFrm[] = Frame('<span>Resumo</span>', Array(
//    Array($vetCampo['detalhe']),
//),$class_frame,$class_titulo,$titulo_na_linha);

$vetCad[] = $vetFrm;
?>
