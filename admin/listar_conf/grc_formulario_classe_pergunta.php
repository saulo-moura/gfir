<?php
$idCampo = 'idt';
$Tela = "a Classe da Pergunta do Formulбrio";

$TabelaPrinc      = "grc_formulario_classe_pergunta";
$AliasPric        = "grc_afa";
$Entidade         = "Classe da Pergunta do Formulбrio";
$Entidade_p       = "Classe da Pergunta do Formulбrio";

$barra_inc_h = "Incluir um Novo Registro de {$Entidade}";
$contlinfim  = "Existem #qt {$Entidade_p}.";



$sistema_origem = DecideSistema();
$mede  = $_GET['mede'];
$grupo = "";
$vetGrupo=Array();
if ($sistema_origem=='GEC')
{
	$vetGrupo['GC'] ='Gestгo de Credenciados';
	$onSubmitDep = 'grc_formulario_secao_dep()';
	$grupo = "GC";

}
else
{
	if ($mede!='S')
	{
	    $vetGrupo['NAN']='Negуcio a Negуcio';
		$grupo = "NAN";
	}
    else
    {
	    $vetGrupo['MEDE']='MEDE';
		$grupo = "MEDE";
		
    }
}
$Filtro = Array();
$Filtro['rs'] = $vetGrupo;
$Filtro['id'] = 'f_grupo';
$Filtro['nome'] = 'Grupo:';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['grupo'] = $Filtro;



$Filtro = Array();
$Filtro['rs']       = 'Texto';
$Filtro['id']       = 'texto';
$Filtro['js_tam']   = '0';
$Filtro['nome']     = 'Texto';
$Filtro['valor']    = trata_id($Filtro);
$vetFiltro['texto'] = $Filtro;

$orderby = "{$AliasPric}.codigo";

$vetCampo['codigo']    = CriaVetTabela('Cуdigo');
$vetCampo['descricao'] = CriaVetTabela('Descriзгo');
$vetCampo['ativo']     = CriaVetTabela('Ativo?', 'descDominio', $vetSimNao );

$sql   = "select ";
$sql  .= "   {$AliasPric}.*  ";
$sql  .= " from {$TabelaPrinc} as {$AliasPric} ";
$sql .= " where {$AliasPric}.grupo = ".aspa($vetFiltro['grupo']['valor']);


if ($vetFiltro['texto']['valor']!="")
{
    $sql .= ' where ';
    $sql .= ' ( ';
    $sql .= '  lower('.$AliasPric.'.codigo)      like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= ' or lower('.$AliasPric.'.descricao) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= ' ) ';
}
$sql  .= " order by {$orderby}";

?>