<?php
$idCampo = 'idt';
$Tela = "a Ferramenta do RAD do Formul�rio";

$TabelaPrinc      = "grc_formulario_ferramenta_ead";
$AliasPric        = "grc_ffe";
$Entidade         = "Ferramenta do EAD do Formul�rio";
$Entidade_p       = "Ferramentas do EAD do Formul�rio";

$barra_inc_h = "Incluir um Novo Registro de {$Entidade}";
$contlinfim  = "Existem #qt {$Entidade_p}.";

if (!($_SESSION[CS]['g_id_usuario']==1 || $_SESSION[CS]['g_id_usuario']==111))
{
    $barra_inc_ap = false;
	$barra_alt_ap = false;
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

$orderby = "grc_fa.codigo, {$AliasPric}.codigo";


$vetCampo['grc_fa_descricao']    = CriaVetTabela('Tema');

$vetCampo['codigo']    = CriaVetTabela('C�digo');

$vetCampo['descricao'] = CriaVetTabela('T�tulo');

$vetNivel=Array();
$vetNivel[1]='B�SICO';
$vetNivel[2]='INTERMEDI�RIO';
$vetNivel[3]='AVAN�ADO';

$vetCampo['nivel']            = CriaVetTabela('N�vel?', 'descDominio', $vetNivel );
$vetCampo['solucao'] = CriaVetTabela('Solu��o');
$vetCampo['link'] = CriaVetTabela('Link');
$vetCampo['ativo']             = CriaVetTabela('Ativo?', 'descDominio', $vetSimNao );

$sql   = "select ";
$sql  .= "   {$AliasPric}.*,  ";
$sql  .= "   grc_fa.descricao as grc_fa_descricao   ";
$sql  .= " from {$TabelaPrinc} as {$AliasPric} ";
$sql  .= "   inner join grc_formulario_area grc_fa on grc_fa.idt = grc_ffe.idt_area ";
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