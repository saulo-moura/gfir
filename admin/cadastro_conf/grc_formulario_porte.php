<?php
$tabela = 'grc_formulario_porte';
$id = 'idt';

$sistema_origem = DecideSistema();
$mede = $_GET['mede'];
$grupo="";

$vetGrupo=Array();
if ($sistema_origem=='GEC')
{
	$vetGrupo['GC'] ='Gestão de Credenciados';
	$grupo="GC";
}
else
{
	if ($mede!='S')
	{
	    $vetGrupo['NAN']='Negócio a Negócio';
		$grupo="NAN";
	}
    else
    {
	    $vetGrupo['MEDE']='MEDE';
		$grupo="MEDE";
    }
}


$vetCampo['grupo']     = objCmbVetor('grupo', 'Grupo', True, $vetGrupo,'');
$vetCampo['codigo']    = objTexto('codigo', 'Classificação', True, 15, 45);
$vetCampo['descricao'] = objTexto('descricao', 'Título', True, 60, 120);
$vetCampo['ativo']     = objCmbVetor('ativo', 'Ativo?', True, $vetSimNao,'');
//
$maxlength  = 700;
$style      = "width:700px;";
$js         = "";
$vetCampo['detalhe'] = objTextArea('detalhe', 'Descrição', false, $maxlength, $style, $js);




$sql_lst_1  = 'select idt as idt_area, descricao from grc_formulario_area ';
$sql_lst_1 .= ' where  grupo = '.aspa($grupo);
$sql_lst_1 .= ' order by codigo';


$sql_lst_2 = 'select ds.idt as idt_area, ds.codigo, ds.descricao from grc_formulario_area ds inner join
			   grc_formulario_porte_area dr on ds.idt = dr.idt_area
			   where dr.idt = '.null($_GET['id'])." and ds.grupo = ".aspa($grupo).' order by ds.codigo';

$vetCampo['idt_area'] = objLista('idt_area', false, 'Áreas prioritárias', 'idt_area1', $sql_lst_1, 'grc_formulario_porte_area', 200, 'Áreas Selecionadas', 'idt_area2', $sql_lst_2);

/*
$sql = '';
$sql .= " select t.descricao as grupo, s.idt, s.descricao";
$sql .= ' from grc_tema_subtema s';
$sql .= ' inner join grc_tema_subtema t on substring(s.codigo, 1, 2) = t.codigo and t.nivel = 0';
$sql .= ' where s.nivel = 1';
$sql .= " and s.ativo = 'S'";
$sql .= ' order by t.descricao, s.descricao';
$vetCampo['idt_tema_subtema'] = objCmbBanco('idt_tema_subtema', 'Tema / Subtema (Tratado)', false, $sql, ' ', 'width:270px;', '', true, '', true);
*/


$sql = '';
$sql .= ' select idt, descricao, desc_vl_cmb';
$sql .= ' from '.db_pir_gec.'gec_organizacao_porte';
$sql .= " where codigo in ('2', '3', '99')";
$sql .= ' order by descricao, desc_vl_cmb';
$rs = execsql($sql);

$js1 = " style='width:14em;'";
$vetCampo['idt_porte'] = objCmbBanco('idt_porte', 'Porte / Faixa Faturamento', false, $sql, ' ', '', $js1);






$vetFrm = Array();
$vetFrm[] = Frame('<span>Identificação</span>', Array(
    Array($vetCampo['grupo'],'',$vetCampo['codigo'],'',$vetCampo['descricao'],'',$vetCampo['idt_porte'],'',$vetCampo['ativo']),
),$class_frame,$class_titulo,$titulo_na_linha);


$vetFrm[] = Frame('<span>Resumo</span>', Array(
    Array($vetCampo['detalhe']),
),$class_frame,$class_titulo,$titulo_na_linha);

$vetFrm[] = Frame('<span>Áreas Prioritárias</span>', Array(
    //Array($vetCampo['idt_tema_subtema']),
     Array($vetCampo['idt_area']),
),$class_frame,$class_titulo,$titulo_na_linha);

/*
$vetFrm[] = Frame('<span>Focos Temáticos</span>', Array(
    Array($vetCampo['idt_tema_subtema']),
    Array($vetCampo['idt_tema']),
),$class_frame,$class_titulo,$titulo_na_linha);
*/


$vetCad[] = $vetFrm;
?>