<?php
$idCampo = 'idt';
$Tela = "a Fase do Funil";

$TabelaPrinc      = "grc_funil_fase";
$AliasPric        = "grc_ff";
$Entidade         = "Fase do Funil";
$Entidade_p       = "Fases do Funil";

$barra_inc_h = "Incluir um Novo Registro de {$Entidade}";
$contlinfim  = "Existem #qt {$Entidade_p}.";


if ($_SESSION[CS]['g_id_usuario']==1)
{
    $permite = 1;
}
else
{
	$permite = 0;
}

if ($permite != 1)
{
	$barra_inc_ap = false;
	$barra_alt_ap = true;
	$barra_con_ap = true;
	$barra_exc_ap = false;
	$barra_fec_ap = false;
}

$Filtro = Array();
$Filtro['rs']       = 'Texto';
$Filtro['id']       = 'texto';
$Filtro['js_tam']   = '0';
$Filtro['nome']     = 'Texto';
$Filtro['valor']    = trata_id($Filtro);
$vetFiltro['texto'] = $Filtro;

$orderby = "{$AliasPric}.codigo";

$vetCampo['codigo']    = CriaVetTabela('Cуdigo');
$vetCampo['nome']      = CriaVetTabela('Nome');
$vetCampo['descricao'] = CriaVetTabela('Descriзгo');
//$vetCampo['ativo']     = CriaVetTabela('Ativo?', 'descDominio', $vetSimNao );
// $vetCampo['detalhe']   = CriaVetTabela('Descriзгo Detalhada');

$sql   = "select ";
$sql  .= "   {$AliasPric}.*  ";
$sql  .= " from {$TabelaPrinc} as {$AliasPric} ";

if ($vetFiltro['texto']['valor']!="")
{
    $sql .= ' where ';
    $sql .= ' ( ';
    $sql .= '  lower('.$AliasPric.'.codigo)      like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= ' or lower('.$AliasPric.'.descricao) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
	$sql .= ' or lower('.$AliasPric.'.detalhe)   like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= ' ) ';
}
$sql  .= " order by {$orderby}";

?>