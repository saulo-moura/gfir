<?php
$tabela = 'grc_funil_parametro';
$id = 'idt';

$_GET['id']=1;
$acao='alt';
$retorno = "self.location='"."conteudo.php?prefixo=inc&menu=grc_funil_painel&origem_tela=painel&cod_volta=home'";
$botao_volta = "{$retorno};";
$botao_acao = '<script type="text/javascript">'.$retorno.';</script>';


$vetCampo['codigo']    = objTexto('codigo', 'Código', True, 15, 45);
$vetCampo['descricao'] = objTexto('descricao', 'Descrição', True, 60, 120);
$vetCampo['ativo']     = objCmbVetor('ativo', 'Ativo?', True, $vetSimNao,' ');
//
$vetCampo['ano_ativo']     = objCmbVetor('ano_ativo', 'Ano Ativo', True, $vetAno,' ');
//
$maxlength  = 1000;
$style      = "width:750px;";
$js         = "";
$vetCampo['msgclientesemclassificacao']      = objTextArea('msgclientesemclassificacao', 'Alerta para Cliente sem Avaliação', false, $maxlength, $style, $js);
//$sql = "select idt, codigo, descricao from plu_estado order by descricao";
//$vetCampo['idt_estado'] = objCmbBanco('idt_estado', 'Estado', true, $sql,'','width:180px;');
MesclarCol($vetCampo['detalhe'], 9);
$vetFrm = Array();
$vetFrm[] = Frame('', Array(
    Array($vetCampo['ano_ativo']),
    Array($vetCampo['msgclientesemclassificacao']),
),$class_frame,$class_titulo,$titulo_na_linha);

$vetCad[] = $vetFrm;
?>