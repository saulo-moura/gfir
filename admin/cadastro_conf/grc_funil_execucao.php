<?php
$tabela = 'grc_funil_execucao';
$id = 'idt';
$vetCampo['ano']    = objCmbVetor('ano', 'Ano?', True, $vetAno);
if ($_GET['f_idt_unidade0']>0)
{
    $_GET['idt0']=$_GET['f_idt_unidade0'];
    $CampoPricPai='idt_unidade_regional';
	$EntidadePai = "Unidade Regional";
	$TabelaPai   = db_pir.'sca_organizacao_secao';
    $vetCampo[$CampoPricPai] = objFixoBanco($CampoPricPai, $EntidadePai, $TabelaPai, 'idt', 'descricao', 0);
}
else
{
	$sql = '';
	$sql .= ' select idt, descricao';
	$sql .= ' from '.db_pir.'sca_organizacao_secao';
	//$sql .= " where posto_atendimento <> 'S' ";
	$sql .= " where tipo_estrutura = 'UR' ";
	$sql .= ' order by classificacao';
	$vetCampo['idt_unidade_regional'] = objCmbBanco('idt_unidade_regional', 'Unidade Regional', true, $sql,' ','width:380px;');
}


$vetCampo['descricao_jurisdicao'] = objTexto('descricao_jurisdicao', 'Resumo Jurisdição', false, 30, 45);


//
$maxlength  = 7000;
$style      = "width:700px;";
$js         = "";
$vetCampo['detalhe'] = objTextArea('detalhe', 'Observações', false, $maxlength, $style, $js);
$vetCampo['qtd_prospects'] = objInteiro('qtd_prospects', 'Qtd. acumulada de PROSPECTS', false, 30);

$corbloq = "#FFFFD2";
$js         = " readonly='true' style='background:{$corbloq};';";

$vetCampo['qtd_leads'] = objInteiro('qtd_leads', 'Qtd. acumulada de LEADS', false, 30,'','',$js);
$vetCampo['qtd_sem_avaliacao'] = objInteiro('qtd_sem_avaliacao', 'Qtd. acumulada de CLIENTES SEM AVALIAÇÃO', false, 30,'','',$js);
$vetCampo['qtd_detrators'] = objInteiro('qtd_detrators', 'Qtd. acumulada de CLIENTES DETRATORES', false, 30,'','',$js);
$vetCampo['qtd_neutros'] = objInteiro('qtd_neutros', 'Qtd. acumulada de CLIENTES NEUTROS', false, 30,'','',$js);
$vetCampo['qtd_promotores'] = objInteiro('qtd_promotores', 'Qtd. acumulada de CLIENTES PROMOTORES', false, 30,'','',$js);
$vetCampo['net_promoter_score'] = objDecimal('net_promoter_score', '% NET PROMOTORES SCORE', false, 30);


$js='';
$vetCampo['codigo_jurisdicao'] = objInteiro('codigo_jurisdicao', 'Código Jurisdição', false, 30,'','',$js);

$vetFrm = Array();
$vetFrm[] = Frame('<span>Identificação</span>', Array(
    Array($vetCampo['idt_unidade_regional'],'',$vetCampo['ano']),
	Array($vetCampo['codigo_jurisdicao'],'',$vetCampo['descricao_jurisdicao']),
),$class_frame,$class_titulo,$titulo_na_linha);
$vetFrm[] = Frame('<span>Valores</span>', Array(
    Array($vetCampo['qtd_prospects']),
	Array($vetCampo['qtd_leads']),
	Array($vetCampo['qtd_sem_avaliacao']),
	Array($vetCampo['qtd_detrators']),
	Array($vetCampo['qtd_neutros']),
	Array($vetCampo['qtd_promotores']),
	Array($vetCampo['net_promoter_score']),
),$class_frame,$class_titulo,$titulo_na_linha);
$vetFrm[] = Frame('', Array(
    Array($vetCampo['detalhe']),
),$class_frame,$class_titulo,$titulo_na_linha);

$vetCad[] = $vetFrm;
?>