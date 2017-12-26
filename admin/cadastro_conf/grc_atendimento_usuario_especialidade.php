<?php
$tabela = 'grc_atendimento_usuario_especialidade';
$id = 'idt';

$TabelaPai   = "db_pir_grc.plu_usuario";
$AliasPai    = "grc_pu";
$EntidadePai = "usuários";
$idPai       = "id_usuario";



$CampoPricPai     = "idt_usuario";


$vetCampo[$CampoPricPai] = objFixoBanco($CampoPricPai, $EntidadePai, $TabelaPai, 'id_usuario', 'nome_completo', 0);


//$vetCampo['codigo']    = objTexto('codigo', 'Código', True, 15, 45);
//$vetCampo['descricao'] = objTexto('descricao', 'Descrição', True, 60, 120);

$sql  = "select idt, descricao from grc_atendimento_especialidade ";
$sql .= " order by descricao";
$vetCampo['idt_atendimento_especialidade'] = objCmbBanco('idt_atendimento_especialidade', 'Especialidade', true, $sql,' ','width:700px;');
$vetCampo['ativo']     = objCmbVetor('ativo', 'Ativo?', True, $vetSimNao);

$maxlength  = 700;
$style      = "width:700px;";
$js         = "";
$vetCampo['detalhe'] = objTextArea('detalhe', 'Detalhe', false, $maxlength, $style, $js);
$vetFrm = Array();

$vetFrm[] = Frame('<span>Usuário</span>', Array(
    Array($vetCampo[$CampoPricPai]),
),$class_frame,$class_titulo,$titulo_na_linha);




$vetFrm[] = Frame('<span>Especialidade</span>', Array(
    Array($vetCampo['idt_atendimento_especialidade'],'',$vetCampo['ativo']),
),$class_frame,$class_titulo,$titulo_na_linha);


$vetFrm[] = Frame('<span>Resumo</span>', Array(
    Array($vetCampo['detalhe']),
),$class_frame,$class_titulo,$titulo_na_linha);

$vetCad[] = $vetFrm;
?>