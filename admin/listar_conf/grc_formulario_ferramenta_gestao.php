<?php
$idCampo = 'idt';
$Tela = "a Ferramenta de Gestão do Formulário";

$TabelaPrinc      = "grc_formulario_ferramenta_gestao";
$AliasPric        = "grc_fdr";
$Entidade         = "Ferramenta de Gestão do Formulário";
$Entidade_p       = "Ferramentas de Gestão do Formulário";

$barra_inc_h = "Incluir um Novo Registro de {$Entidade}";
$contlinfim  = "Existem #qt {$Entidade_p}.";


if ($_SESSION[CS]['g_id_usuario']!=1)
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

$orderby = "grc_fa.codigo, {$AliasPric}.codigo";


$vetCampo['grc_fa_descricao']    = CriaVetTabela('Área');

$vetCampo['codigo']    = CriaVetTabela('Número');

$vetCampo['descricao'] = CriaVetTabela('Título');

$vetNivel=Array();
$vetNivel[1]='BÁSICO';
$vetNivel[2]='INTERMEDIÁRIO';
$vetNivel[3]='AVANÇADO';

$vetCampo['nivel']            = CriaVetTabela('Nível?', 'descDominio', $vetNivel );
$vetCampo['numero_pagina']    = CriaVetTabela('Página');
$vetCampo['ativo']             = CriaVetTabela('Ativo?', 'descDominio', $vetSimNao );

$sql   = "select ";
$sql  .= "   {$AliasPric}.*,  ";
$sql  .= "   grc_fa.descricao as grc_fa_descricao   ";
$sql  .= " from {$TabelaPrinc} as {$AliasPric} ";
$sql  .= "   inner join grc_formulario_area grc_fa on grc_fa.idt = grc_fdr.idt_Area ";
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