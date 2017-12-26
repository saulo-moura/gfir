<?php
$idCampo = 'idt';
$Tela = "o Porte do Formul�rio";



$TabelaPrinc      = "grc_formulario_porte";
$AliasPric        = "grc_fp";
$Entidade         = "Porte do Formul�rio";
$Entidade_p       = "Portes do Formul�rio";

$barra_inc_h = "Incluir um Novo Registro de {$Entidade}";
$contlinfim  = "Existem #qt {$Entidade_p}.";

$sistema_origem = DecideSistema();
$mede = $_GET['mede'];

$vetGrupo=Array();
if ($sistema_origem=='GEC')
{
	$vetGrupo['GC'] ='Gest�o de Credenciados';
}
else
{
	if ($mede!='S')
	{
	    $vetGrupo['NAN']='Neg�cio a Neg�cio';
	}
    else
    {
	    $vetGrupo['MEDE']='MEDE';
    }

}


if ($_SESSION[CS]['g_id_usuario']!=1)
{
    $barra_inc_ap = false;
	$barra_alt_ap = true;
	$barra_con_ap = true;
	$barra_exc_ap = false;
	$barra_fec_ap = false;
}


$Filtro = Array();
$Filtro['rs'] = $vetGrupo;
$Filtro['id'] = 'f_grupo';
$Filtro['nome'] = 'Grupo';
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

$vetCampo['codigo']    = CriaVetTabela('Classifica��o');
$vetCampo['descricao'] = CriaVetTabela('T�tulo');
$vetCampo['detalhe']   = CriaVetTabela('Descri��o');
$vetCampo['ativo']     = CriaVetTabela('Ativo?', 'descDominio', $vetSimNao );

$sql   = "select ";
$sql  .= "   {$AliasPric}.*  ";
$sql  .= " from {$TabelaPrinc} as {$AliasPric} ";


$sql  .= " where {$AliasPric}.grupo = ".aspa($vetFiltro['grupo']['valor']);

if ($vetFiltro['texto']['valor']!="")
{
    $sql .= ' and ';
    $sql .= ' ( ';
    $sql .= '  lower('.$AliasPric.'.codigo)      like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= ' or lower('.$AliasPric.'.descricao) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
	$sql .= ' or lower('.$AliasPric.'.detalhe) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= ' ) ';
}
$sql  .= " order by {$orderby}";

?>