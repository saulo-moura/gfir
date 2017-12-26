<?php
$tabela = 'grc_formulario_area';
$id = 'idt';

$sistema_origem = DecideSistema();
$mede = $_GET['mede'];

$vetGrupo=Array();
if ($sistema_origem=='GEC')
{
	$vetGrupo['GC'] ='Gestão de Credenciados';
}
else
{
	if ($mede!='S')
	{
	    $vetGrupo['NAN']='Negócio a Negócio';
	}
    else
    {
	    $vetGrupo['MEDE']='MEDE';
    }
}


$vetCampo['grupo']     = objCmbVetor('grupo', 'Grupo', True, $vetGrupo,'');
$vetCampo['codigo']    = objTexto('codigo', 'Classificação', True, 15, 45);
$vetCampo['descricao'] = objTexto('descricao', 'Título', True, 60, 120);
$vetCampo['ativo']     = objCmbVetor('ativo', 'Ativo?', True, $vetSimNao);
//
$maxlength  = 700;
$style      = "width:700px;";
$js         = "";
$vetCampo['detalhe'] = objTextArea('detalhe', 'Descrição', false, $maxlength, $style, $js);




$sql_lst_1 = 'select idt as idt_tema, descricao from grc_foco_tematico  order by codigo';


$sql_lst_2 = 'select ds.idt as idt_tema, ds.codigo, ds.descricao from grc_foco_tematico ds inner join
			   grc_nan_area_x_foco_tematico dr on ds.idt = dr.idt_tema
			   where dr.idt = '.null($_GET['id']).' order by ds.codigo';

$vetCampo['idt_tema'] = objLista('idt_tema', false, 'Foco Temático', 'idt_tema1', $sql_lst_1, 'grc_nan_area_x_foco_tematico', 200, 'Focos Temáticos Selecionados', 'idt_foco2', $sql_lst_2);

$sql = '';
$sql .= " select t.descricao as grupo, s.idt, s.descricao";
$sql .= ' from grc_tema_subtema s';
$sql .= ' inner join grc_tema_subtema t on substring(s.codigo, 1, 2) = t.codigo and t.nivel = 0';
$sql .= ' where s.nivel = 1';
$sql .= " and s.ativo = 'S'";
$sql .= ' order by t.descricao, s.descricao';
$vetCampo['idt_tema_subtema'] = objCmbBanco('idt_tema_subtema', 'Tema / Subtema (Tratado)', false, $sql, ' ', 'width:270px;', '', true, '', true);


//$sql = "select idt, codigo, descricao from plu_estado order by descricao";
//$vetCampo['idt_estado'] = objCmbBanco('idt_estado', 'Estado', true, $sql,'','width:180px;');
$vetFrm = Array();
$vetFrm[] = Frame('<span>Identificação</span>', Array(
    Array($vetCampo['grupo'],'',$vetCampo['codigo'],'',$vetCampo['descricao'],'',$vetCampo['ativo']),
),$class_frame,$class_titulo,$titulo_na_linha);


$vetFrm[] = Frame('<span>Resumo</span>', Array(
    Array($vetCampo['detalhe']),
),$class_frame,$class_titulo,$titulo_na_linha);

$vetFrm[] = Frame('<span>Focos Temáticos</span>', Array(
    Array($vetCampo['idt_tema_subtema']),
    Array($vetCampo['idt_tema']),
),$class_frame,$class_titulo,$titulo_na_linha);

$vetCad[] = $vetFrm;
?>