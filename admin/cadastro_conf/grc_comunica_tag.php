<?php
$tabela = 'grc_comunica_tag';
$id = 'idt';

if ($_SESSION[CS]['g_id_usuario']!=1)
{
    $acao='con';
}

$vetCampo['ordem']    = objTexto('ordem', 'Ordem', false, 25, 45);

$vetCampo['codigo']    = objTexto('codigo', 'TAGs', True, 25, 45);
$vetCampo['descricao'] = objTexto('descricao', 'Tнtulo', True, 45, 120);
$vetCampo['ativo']     = objCmbVetor('ativo', 'Ativo?', True, $vetSimNao,'');
//
$vetCampo['tabela_p']   = objTexto('tabela_p', 'Tabela', false, 30, 120);
$vetCampo['campo_p']    = objTexto('campo_p', 'Campo', false, 30, 120);

$vetCampo['disponivel']     = objCmbVetor('disponivel', 'Disponнvel?', True, $vetNaoSim,'');



/*
$vetNivel=Array();
$vetNivel[1]='BБSICO';
$vetNivel[2]='INTERMEDIБRIO';
$vetNivel[3]='AVANЗADO';
$vetCampo['nivel'] = objCmbVetor('nivel', 'Nнvel', True, $vetNivel);
$vetCampo['numero_pagina'] = objInteiro('numero_pagina', 'Pбgina', True, 10, 120);

$vetCampo['link'] = objURL('link', 'Link de acesso', false, 120, 255);
$vetCampo['solucao']    = objTexto('solucao', 'Soluзгo', false, 15, 45);
*/

//
$maxlength  = 10000;
$style      = "width:100%;";
$js         = "";
/*
$vetParametros=Array();
			$vetParametros['tipo']       = "UR";
			$vetParametros['idt_sca_oc'] = "";
			$vetParametros['idt_ponto_atendimento']=83;
			$ret = DadosSCA($vetParametros);
            $unidade_regional = $vetParametros['descricao_ur'];
			p($vetParametros);
*/	

$altura  = '250';
$largura = '800';
$js      = '';
$barra_aberto  = false;
$barra_simples = false;
$campo_fixo    = false;

$vetCampo['detalhe'] = objHtml('detalhe', 'Descriзгo detalhada', false, $altura, $largura);
//
//$sql = "select idt, descricao from grc_formulario_area   order by codigo";
//$vetCampo['idt_area'] = objCmbBanco('idt_area', 'Tema', true, $sql,'','width:100%;');
//
$vetFrm = Array();
$mostrad=1;
if ($acao=='inc' or $mostrad==1)
{
	//MesclarCol($vetCampo['campo_p'], 3);
	MesclarCol($vetCampo['detalhe'], 7);
	$vetFrm[] = Frame('', Array(
		Array($vetCampo['codigo'],'',$vetCampo['descricao'],'',$vetCampo['ativo'],'',$vetCampo['disponivel']),
		Array($vetCampo['ordem'],'',$vetCampo['tabela_p'],'',$vetCampo['campo_p']),
		Array($vetCampo['detalhe']),
	),$class_frame,$class_titulo,$titulo_na_linha);
}
else
{
	//MesclarCol($vetCampo['campo_p'], 3);
	MesclarCol($vetCampo['detalhe'], 5);
	$vetFrm[] = Frame('', Array(
		Array($vetCampo['codigo'],'',$vetCampo['descricao'],'',$vetCampo['ativo']),
		Array($vetCampo['ordem'],'',$vetCampo['tabela_p'],'',$vetCampo['campo_p']),
		Array($vetCampo['detalhe']),
	),$class_frame,$class_titulo,$titulo_na_linha);

}
$vetCad[] = $vetFrm;
?>