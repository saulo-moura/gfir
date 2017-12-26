<script language="JavaScript" src="js/jscolor/jscolor.js" type="text/javascript"></script>


<?php
$tabela = 'grc_funil_classificacao';
$id = 'idt';
$corbloq = "#FFFFD2";
$js         = " readonly='true' style='background:{$corbloq};';";
$vetCampo['codigo']    = objTexto('codigo', 'Ordem', True, 15, 45, $js);
//$vetCampo['codigo']    = objTexto('codigo', 'Código', True, 15, 45);

$vetCampo['descricao'] = objTexto('descricao', 'Descrição', True, 60, 120);
//$vetCampo['ativo']     = objCmbVetor('ativo', 'Ativo?', True, $vetSimNao,'');
//
$maxlength  = 1000;
$style      = "width:100%;";
$js         = "";
$vetCampo['detalhe']      = objTextArea('detalhe', 'Descrição Detalhada', false, $maxlength, $style, $js);
$vetCampo['cordaclassificacao'] = objTexto('cordaclassificacao', 'Cor', True, 7, 45,$js,'','jscolor');
$vetCampo['nota_minima']    = objDecimal('nota_minima', 'Nota Mínima',True,10);
//$sql = "select idt, codigo, descricao from plu_estado order by descricao";
//$vetCampo['idt_estado'] = objCmbBanco('idt_estado', 'Estado', true, $sql,'','width:180px;');
MesclarCol($vetCampo['detalhe'], 7);
$vetFrm = Array();
$vetFrm[] = Frame('', Array(
    Array($vetCampo['codigo'],'',$vetCampo['descricao'],'',$vetCampo['nota_minima'],'',$vetCampo['cordaclassificacao']),
    Array($vetCampo['detalhe']),
),$class_frame,$class_titulo,$titulo_na_linha);

$vetCad[] = $vetFrm;
?>