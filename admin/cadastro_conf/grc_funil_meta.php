<?php
$tabela = 'grc_funil_meta';
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

//
$maxlength  = 7000;
$style      = "width:700px;";
$js         = "";
$vetCampo['detalhe'] = objTextArea('detalhe', 'Observações', false, $maxlength, $style, $js);
$vetCampo['qtd_prospects'] = objInteiro('qtd_prospects', 'PROSPECTS (Qtd.)', false, 30);
$vetCampo['qtd_leads'] = objInteiro('qtd_leads', 'LEADS (Qtd.)', false, 30);
$vetCampo['qtd_clientes'] = objInteiro('qtd_clientes', 'CLIENTES (Qtd.)', false, 30);
$vetCampo['net_promoter_score'] = objDecimal('net_promoter_score', '% NET PROMOTORES SCORE', false, 30);
$vetFrm = Array();
$vetFrm[] = Frame('<span>Identificação</span>', Array(
    Array($vetCampo['idt_unidade_regional'],'',$vetCampo['ano']),
),$class_frame,$class_titulo,$titulo_na_linha);
$vetFrm[] = Frame('<span>Valores</span>', Array(
    Array($vetCampo['qtd_prospects']),
	Array($vetCampo['qtd_leads']),
	Array($vetCampo['qtd_clientes']),
	Array($vetCampo['net_promoter_score']),
),$class_frame,$class_titulo,$titulo_na_linha);
$vetFrm[] = Frame('', Array(
    Array($vetCampo['detalhe']),
),$class_frame,$class_titulo,$titulo_na_linha);

$vetCad[] = $vetFrm;
?>