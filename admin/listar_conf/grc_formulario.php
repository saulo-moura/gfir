<?php
$ordFiltro = false;
$idCampo = 'idt';
$idCampoPar = 'formulario_idt';

$Tela = "o Formul�rio da Avalia��o";

if ($_SESSION[CS]['g_id_usuario']!=1)
{
    $barra_inc_ap = false;
	$barra_alt_ap = false;
	$barra_con_ap = true;
	$barra_exc_ap = false;
	$barra_fec_ap = false;
}


$sistema_origem=DecideSistema();

//p($_GET);

$mede = $_GET['mede'];

$prefixow = 'listar';

$tipoidentificacao = 'N';
$tipofiltro = 'S';

$mostrar = false;
$cond_campo = '';
$cond_valor = '';



$TabelaPrinc      = "grc_formulario";
$AliasPric        = "grc_af";
$Entidade         = "Avalia��o do Formul�rio";
$Entidade_p       = "Avalia��es do Formul�rio";

$barra_inc_h = "Incluir um Novo Registro de {$Entidade}";
$contlinfim  = "Existem #qt {$Entidade_p}.";

$sistema_origem = DecideSistema();
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
	    $vetGrupo['GC'] ='Gest�o de Credenciados';
	    $vetGrupo['NAN']='Neg�cio a Neg�cio';
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
$Filtro['id']       = 'formulario_texto';
$Filtro['js_tam']   = '0';
$Filtro['nome']     = 'Texto';
$Filtro['valor']    = trata_id($Filtro);
$vetFiltro['texto'] = $Filtro;

$orderby = "{$AliasPric}.codigo";

if ($mede!='S')
{
	$vetCampo['codigo']            = CriaVetTabela('C�digo');
	$vetCampo['grc_fdr_descricao'] = CriaVetTabela('Dimens�o');
	$vetCampo['descricao']         = CriaVetTabela('T�tulo');
}
else
{
	$vetCampo['codigo']            = CriaVetTabela('C�digo');
	$vetCampo['grc_fdr_descricao'] = CriaVetTabela('Dimens�o do Formul�rio');
	$vetCampo['descricao']         = CriaVetTabela('T�tulo');
}
// $vetCampo['ativo']  = CriaVetTabela('Ativo?', 'descDominio', $vetSimNao );

$sql   = "select ";
$sql  .= "   {$AliasPric}.*,  ";
$sql  .= "   grc_fdr.descricao as grc_fdr_descricao  ";
$sql  .= " from {$TabelaPrinc} as {$AliasPric} ";
$sql  .= " left join grc_formulario_dimensao_resposta grc_fdr on grc_fdr.idt = grc_af.idt_dimensao ";

$sql  .= " where {$AliasPric}.grupo = ".aspa($vetFiltro['grupo']['valor']);

if ($vetFiltro['texto']['valor']!="")
{
    $sql .= ' and ';
    $sql .= ' ( ';
    $sql .= '  lower('.$AliasPric.'.codigo)      like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= ' or lower('.$AliasPric.'.descricao) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= ' ) ';
}
$sql  .= " order by {$orderby}";

?>