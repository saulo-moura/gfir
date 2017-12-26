<?php
$tabela = 'grc_evento_forma_parcelamento';
$id = 'idt';
$vetCampo['codigo'] = objTexto('codigo', 'Texto do Número de Parcelas', True, 15, 45);
$vetCampo['descricao'] = objTexto('descricao', 'Descrição', True, 30, 120);
$vetCampo['ativo'] = objCmbVetor('ativo', 'Ativo?', True, $vetSimNao);
//
$maxlength = 1000;
$style = "width:700px;";
$js = "";
$vetCampo['detalhe'] = objTextArea('detalhe', 'Detalhe', false, $maxlength, $style, $js);
$sql = "select idt, descricao from grc_evento_natureza_pagamento order by descricao";
$vetCampo['idt_natureza'] = objCmbBanco('idt_natureza', 'Forma de Pagamento', true, $sql, '', 'width:180px;');

$vetCampo['valor_ini'] = objDecimal('valor_ini', 'Valor de', True, 10);
$vetCampo['valor_ate'] = objDecimal('valor_ate', 'Valor até', True, 10);
$vetCampo['numero_de_parcelas'] = objInteiro('numero_de_parcelas', 'Quantidade de Parcelas', True, 10);

$vetCampo['rm_codcpg'] = objInteiro('rm_codcpg', 'codcpg do RM', false, 10);

$vetFrm = Array();

$vetFrm[] = Frame('<span>Identificação</span>', Array(
    Array($vetCampo['idt_natureza'], '', $vetCampo['numero_de_parcelas'], '', $vetCampo['codigo'], '', $vetCampo['descricao']),
    Array($vetCampo['valor_ini'], '', $vetCampo['valor_ate'], '', $vetCampo['ativo'], '', $vetCampo['rm_codcpg']),
        ), $class_frame, $class_titulo, $titulo_na_linha);


$vetFrm[] = Frame('<span>Resumo</span>', Array(
    Array($vetCampo['detalhe']),
        ), $class_frame, $class_titulo, $titulo_na_linha);

$vetCad[] = $vetFrm;
?>