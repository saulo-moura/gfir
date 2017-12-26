<?php
$tabela = 'gsw_tabelatexto';
$id = 'idt';
$vetCampo['codigo']    = objTexto('codigo', 'Código', True, 15, 45);
$vetCampo['descricao'] = objTexto('descricao', 'Descrição', True, 60, 120);
//
$maxlength  = '';
$style      = "height:300px; width:300px;";
$js         = "";
$vetCampo['texto'] = objTextArea('texto', 'Definição em Texto', false, $maxlength, $style, $js);
$maxlength  = '';
$style      = "height:300px; width:300px;";
$js         = "";
$vetCampo['sql_t'] = objTextArea('sql_t', 'Definição em SQL', false, $maxlength, $style, $js);
$maxlength  = '';
$style      = "height:300px; width:300px;";
$js         = "";
$vetCampo['menu_t'] = objTextArea('menu_t', 'Menu e Direitos', false, $maxlength, $style, $js);
$maxlength  = 7000;
$style      = "height:250px; width:900px;";
$js         = "";
$vetCampo['detalhe'] = objTextArea('detalhe', 'Descrição detalhada da Tabela', false, $maxlength, $style, $js);
$vetCampo['ferramentas'] = objInclude('ferramentas', 'cadastro_conf/gsw_tabelatexto_botoes.php');


// $sql = "select idt, codigo, descricao from plu_estado order by descricao";
// $vetCampo['idt_estado'] = objCmbBanco('idt_estado', 'Estado', true, $sql,'','width:180px;');



$vetFrm = Array();
$vetFrm[] = Frame('<span>Identificação da Tabela</span>', Array(
    Array($vetCampo['codigo'],'',$vetCampo['descricao']),
),$class_frame,$class_titulo,$titulo_na_linha);

MesclarCol($vetCampo['ferramentas'], 5);
$vetFrm[] = Frame('', Array(
    Array($vetCampo['texto'],'',$vetCampo['sql_t'],'',$vetCampo['menu_t']),
	Array($vetCampo['ferramentas']),
	
),$class_frame,$class_titulo,$titulo_na_linha);
$vetFrm[] = Frame('', Array(
    Array($vetCampo['detalhe']),
),$class_frame,$class_titulo,$titulo_na_linha);

$vetCad[] = $vetFrm;
?>