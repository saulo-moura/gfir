<?php
$tabela = 'grc_atendimento_fila';
$id = 'idt';


$TabelaPai   = "".db_pir."sca_organizacao_secao";
$AliasPai    = "grc_os";
$EntidadePai = "PA´s";
$idPai       = "idt";

$CampoPricPai     = "idt_ponto_atendimento";

$vetCampo[$CampoPricPai] = objFixoBanco($CampoPricPai, $EntidadePai, $TabelaPai, $idPai, 'descricao', 0);

$vetCampo['codigo']    = objTexto('codigo', 'Código', True, 15, 45);
$vetCampo['descricao'] = objTexto('descricao', 'Descrição', True, 60, 120);
$vetCampo['localizacao'] = objTexto('localizacao', 'Descrição', True, 60, 120);

//$sql   = 'select ';
//$sql  .= '   idt, descricao  ';
//$sql  .= ' from '.db_pir.'sca_organizacao_secao sac_os ';
//$sql  .= " where posto_atendimento = 'UR' or posto_atendimento = 'S' ";
//$sql  .= ' order by classificacao ';
//$js = " ";
//$vetCampo['idt_ponto_atendimento'] = objCmbBanco('idt_ponto_atendimento', 'Ponto Atendimento', false, $sql,' ','width:250px;',$js);

$vetCampo['ativo']     = objCmbVetor('ativo', 'Ativo?', True, $vetSimNao,'');

$maxlength  = 700;
$style      = "width:700px;";
$js         = "";
$vetCampo['mensagem'] = objTextArea('mensagem', 'Mensagem', false, $maxlength, $style, $js);
$vetCampo['mensagem_2'] = objTextArea('mensagem_2', 'Mensagem', false, $maxlength, $style, $js);
//$sql = "select idt, codigo, descricao from plu_estado order by descricao";
//$vetCampo['idt_estado'] = objCmbBanco('idt_estado', 'Estado', true, $sql,'','width:180px;');


$vetFrm = Array();
$vetFrm[] = Frame('<span>Identificação</span>', Array(
    Array($vetCampo['codigo'],'',$vetCampo['descricao'],'',$vetCampo['ativo']),
    Array($vetCampo[$CampoPricPai],'',$vetCampo['localizacao']),
),$class_frame,$class_titulo,$titulo_na_linha);


$vetFrm[] = Frame('<span>Mensagens</span>', Array(
    Array($vetCampo['Mensagem']),
    Array($vetCampo['Mensagem_2']),
),$class_frame,$class_titulo,$titulo_na_linha);

$vetCad[] = $vetFrm;
?>
