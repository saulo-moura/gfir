<?php
$tabela = 'grc_evento_autorizador';
$id     = 'idt';

$TabelaPai   = "".db_pir."sca_organizacao_secao";
$AliasPai    = "grc_os";
$EntidadePai = "Unidades Regionais";
$idPai       = "idt";

$CampoPricPai     = "idt_ponto_atendimento";

//$vetCampo[$CampoPricPai] = objFixoBanco($CampoPricPai, $EntidadePai, $TabelaPai, $idPai, 'descricao', 0);


$sql   = 'select ';
$sql  .= '   idt, descricao  ';
$sql  .= ' from '.db_pir.'sca_organizacao_secao sac_os ';
$sql  .= " where posto_atendimento <> 'S'  ";
$sql  .= ' order by classificacao ';
// objCmbBanco($campo, $nome, $valida, $sql, $linhafixa = ' ', $style = '', $js = '', $campo_tabela = true, $vl_padrao = '', $optgroup = false, $msg_sem_registro = 'Não existe informação no sistema') {
$vetCampo[$CampoPricPai] = objCmbBanco($CampoPricPai, $EntidadePai, true, $sql,' ','width:300px;','',true, $_GET['idt0']);


$sql  = "select id_usuario, nome_completo from plu_usuario ";
$sql .= " where matricula_intranet <> '' ";
$sql .= " order by nome_completo";
$vetCampo['idt_autorizador'] = objCmbBanco('idt_autorizador', 'Autorizador', true, $sql,' ','width:300px;');


$sql  = "select idt, descricao from grc_evento_tipo_autorizador ";
$sql .= " order by codigo";
$vetCampo['idt_tipo_autorizador'] = objCmbBanco('idt_tipo_autorizador', 'Tipo de Autorizador', true, $sql,' ','width:300px;');


$js = "";
$vetCampo['valor'] = objDecimal('valor', 'Valor Alçada', true, 15, '', 0, $js);




$vetRel = Array();
$vetRel['1'] = 'Primeiro';
$vetRel['2'] = 'Segundo';
$vetRel['3'] = 'Terceiro';
$vetRel['4'] = 'Quarto';

$vetCampo['prioridade']    = objCmbVetor('prioridade', 'Prioridade', True, $vetRel,'');

$vetCampo['observacao'] = objTexto('observacao', 'Observação', false, 80, 120);


$vetFrm[] = Frame('<span></span>', Array(
    Array($vetCampo[$CampoPricPai]),
),$class_frame,$class_titulo,$titulo_na_linha);


MesclarCol($vetCampo['observacao'], 3);
$vetFrm[] = Frame('<span></span>', Array(
   // Array($vetCampo['idt_autorizador'],'',$vetCampo['idt_tipo_autorizador'],'',$vetCampo['valor']),
    Array($vetCampo['idt_autorizador'],'',$vetCampo['idt_tipo_autorizador']),
    Array($vetCampo['observacao']),
),$class_frame,$class_titulo,$titulo_na_linha);



/*
$vetFrm[] = Frame('<span></span>', Array(
    Array($vetCampo['idt_projeto']),
    Array($vetCampo['idt_acao']),
),$class_frame,$class_titulo,$titulo_na_linha);
*/


$vetCad[] = $vetFrm;
?>
