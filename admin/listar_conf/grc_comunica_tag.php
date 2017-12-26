<?php
$idCampo = 'idt';
$Tela = "a TAG da Comunicaзгo";

$tipoidentificacao = 'N';
$tipofiltro = 'S';
$comfiltro = 'A';
$comidentificacao = 'F';

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
	$barra_alt_ap = false;
	$barra_con_ap = true;
	$barra_exc_ap = false;
	$barra_fec_ap = false;
}


$TabelaPrinc      = "grc_comunica_tag";
$AliasPric        = "grc_ct";
$Entidade         = "TAG da Comunicaзгo";
$Entidade_p       = "TAGs da Comunicaзгo";

$barra_inc_h = "Incluir um Novo Registro de {$Entidade}";
$contlinfim  = "Existem #qt {$Entidade_p}.";



$Filtro = Array();
$Filtro['rs']       = $vetSimNao;
$Filtro['id']       = 'disponivel';
$Filtro['js_tam']   = '0';
$Filtro['LinhaUm']   = '-- Todos --';
$Filtro['nome']     = 'Disponivel?';
$Filtro['valor']    = trata_id($Filtro);
$vetFiltro['disponivel'] = $Filtro;

$Filtro = Array();
$Filtro['rs']       = 'Texto';
$Filtro['id']       = 'texto';
$Filtro['js_tam']   = '0';
$Filtro['nome']     = 'Texto';
$Filtro['valor']    = trata_id($Filtro);
$vetFiltro['texto'] = $Filtro;

//$orderby = "{$AliasPric}.codigo";

$mostrad=1;
$vetCampo['ordem']     = CriaVetTabela('Ordem');
$vetCampo['codigo']    = CriaVetTabela('TAG');
$vetCampo['detalhe'] = CriaVetTabela('Descriзгo');
$vetCampo['ativo']     = CriaVetTabela('Ativo?', 'descDominio', $vetSimNao );
if ($mostrad==1)
{
    $vetCampo['disponivel']= CriaVetTabela('Disponнvel?', 'descDominio', $vetSimNao );
}	

$sql   = "select ";
$sql  .= "   {$AliasPric}.*,  ";
$sql  .= "   concat_ws('<br />',{$AliasPric}.descricao,{$AliasPric}.detalhe) as detalhe   ";
$sql  .= " from {$TabelaPrinc} as {$AliasPric} ";
$sql  .= ' where 1 = 1 ';

if ($vetFiltro['disponivel']['valor']!="" and $vetFiltro['disponivel']['valor']!="0")
{

    $sql .= ' and ';
    $sql .= ' ( ';
    $sql .= "  {$AliasPric}.disponivel = ".aspa($vetFiltro['disponivel']['valor']);
    $sql .= ' ) ';


}


if ($vetFiltro['texto']['valor']!="")
{
    $sql .= ' and ';
    $sql .= ' ( ';
    $sql .= '  lower('.$AliasPric.'.codigo)      like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= ' or lower('.$AliasPric.'.descricao) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
	$sql .= ' or lower('.$AliasPric.'.detalhe) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= ' ) ';
}
//$sql  .= " order by {$orderby}";

?>