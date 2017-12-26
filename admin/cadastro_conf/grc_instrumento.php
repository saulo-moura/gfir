<?php
$tabela = 'grc_instrumento';
$id = 'idt';
$vetCampo['codigo']    = objTexto('codigo', 'Código', True, 15, 45);
$vetCampo['descricao'] = objTexto('descricao', 'Descrição', True, 60, 120);
$vetCampo['ativo']     = objCmbVetor('ativo', 'Ativo?', True, $vetSimNao);

$vetCampo['nivel']     = objCmbVetor('nivel', 'Analítico?', True, $vetSimNao);


$vetCampo['metrica'] = objTexto('metrica', 'Métrica', True, 60, 120);




$vetCampo['nivel_cadastro_incremental'] = objTexto('nivel_cadastro_incremental', 'Nível do Cadastro Incremental', False, 25, 45);
$vetCampo['data_criacao']   = objDatahora('data_criacao', 'Data da Criaçãor (dd/mm/aaaa hh:mm)', False);
$vetCampo['data_modificacao']   = objDatahora('data_modificacao', 'Data da Modificação (dd/mm/aaaa hh:mm)', False);

$sql  = "select id_usuario, nome_completo from plu_usuario ";
$sql .= " order by nome_completo";
$vetCampo['idt_usuario_criador'] = objCmbBanco('idt_usuario_criador', 'Criado por', false, $sql,' ','width:500px;');

$sql  = "select id_usuario, nome_completo from plu_usuario ";
$sql .= " order by nome_completo";
$vetCampo['idt_usuario_modificador'] = objCmbBanco('idt_usuario_modificador', 'Modificado por', false, $sql,' ','width:500px;');

$sql  = "select idt, descricao from grc_produto_tipo ";
$sql .= " order by descricao";
$vetCampo['idt_produto_tipo'] = objCmbBanco('idt_produto_tipo', 'Tipo do Produto', false, $sql,' ','width:500px;');

//
$maxlength  = 700;
$style      = "width:700px;";
$js         = "";
$vetCampo['detalhe'] = objTextArea('detalhe', 'Detalhe', false, $maxlength, $style, $js);
//$sql = "select idt, codigo, descricao from plu_estado order by descricao";
//$vetCampo['idt_estado'] = objCmbBanco('idt_estado', 'Estado', true, $sql,'','width:180px;');
$vetFrm = Array();
$vetFrm[] = Frame('<span>Identificação</span>', Array(
    Array($vetCampo['codigo'],'',$vetCampo['descricao'],'',$vetCampo['nivel'],'',$vetCampo['ativo']),
),$class_frame,$class_titulo,$titulo_na_linha);


$vetFrm[] = Frame('<span>Métrica</span>', Array(
    Array($vetCampo['metrica']),
),$class_frame,$class_titulo,$titulo_na_linha);


$vetFrm[] = Frame('<span>Resumo</span>', Array(
    Array($vetCampo['detalhe']),
),$class_frame,$class_titulo,$titulo_na_linha);


/*
$vetFrm[] = Frame('<span>Criador/Modificador</span>', Array(
    Array($vetCampo['idt_usuario_criador'],'',$vetCampo['data_criacao']),
    Array($vetCampo['idt_usuario_modificador'],'',$vetCampo['data_modificacao']),
),$class_frame,$class_titulo,$titulo_na_linha);

$vetFrm[] = Frame('<span>Complemento</span>', Array(
    Array($vetCampo['idt_produto_tipo'],'',$vetCampo['nivel_cadastro_incremental']),
),$class_frame,$class_titulo,$titulo_na_linha);
*/


$vetCad[] = $vetFrm;
?>