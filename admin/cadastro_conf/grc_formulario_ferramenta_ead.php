<?php
$tabela = 'grc_formulario_ferramenta_ead';
$id = 'idt';

if (!($_SESSION[CS]['g_id_usuario']==1 || $_SESSION[CS]['g_id_usuario']==111))
{
    $acao='con';
}


$vetCampo['codigo']    = objTexto('codigo', 'C�digo', True, 15, 45);
$vetCampo['descricao'] = objTexto('descricao', 'T�tulo', True, 60, 120);
$vetCampo['ativo']     = objCmbVetor('ativo', 'Ativo?', True, $vetSimNao,'');
//
$vetNivel=Array();
$vetNivel[1]='B�SICO';
$vetNivel[2]='INTERMEDI�RIO';
$vetNivel[3]='AVAN�ADO';
$vetCampo['nivel'] = objCmbVetor('nivel', 'N�vel', True, $vetNivel);
$vetCampo['numero_pagina'] = objInteiro('numero_pagina', 'P�gina', True, 10, 120);

$vetCampo['link'] = objURL('link', 'Link de acesso', false, 120, 255);
$vetCampo['solucao']    = objTexto('solucao', 'Solu��o', false, 15, 45);

//
$maxlength  = 700;
$style      = "width:700px;";
$js         = "";


$altura  = '250';
$largura = '800';
$js      = '';
$barra_aberto  = false;
$barra_simples = false;
$campo_fixo    = false;

$vetCampo['detalhe'] = objHtml('detalhe', '', false, $altura, $largura);
//
$sql = "select idt, descricao from grc_formulario_area   order by codigo";
$vetCampo['idt_area'] = objCmbBanco('idt_area', 'Tema', true, $sql,'','width:100%;');
//
$vetFrm = Array();

MesclarCol($vetCampo['idt_area'], 9);
MesclarCol($vetCampo['link'], 9);
$vetFrm[] = Frame('<span>Identifica��o</span>', Array(
    Array($vetCampo['idt_area']),
    Array($vetCampo['codigo'],'',$vetCampo['descricao'],'',$vetCampo['nivel'],'',$vetCampo['solucao'],'',$vetCampo['ativo']),
	Array($vetCampo['link']),
),$class_frame,$class_titulo,$titulo_na_linha);
$vetFrm[] = Frame('O que �:', Array(
    Array($vetCampo['detalhe']),
),$class_frame,$class_titulo,$titulo_na_linha);

$vetCad[] = $vetFrm;
?>