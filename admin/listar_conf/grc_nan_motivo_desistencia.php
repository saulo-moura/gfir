<?php
$idCampo = 'idt';
$Tela = "o Motivo da Desist�ncia";



$TabelaPrinc      = "grc_nan_motivo_desistencia";
$AliasPric        = "grc_nanmdt";
$Entidade         = "Motivo da Desist�ncia";
$Entidade_p       = "Motivos da Desist�ncia";

$barra_inc_h = "Incluir um Novo Registro de {$Entidade}";
$contlinfim  = "Existem #qt {$Entidade_p}.";

$Filtro = Array();
$Filtro['rs']       = 'Texto';
$Filtro['id']       = 'texto';
$Filtro['js_tam']   = '0';
$Filtro['nome']     = 'Texto';
$Filtro['valor']    = trata_id($Filtro);
$vetFiltro['texto'] = $Filtro;

$orderby = "{$AliasPric}.codigo";

$vetCampo['codigo']    = CriaVetTabela('C�digo');
$vetCampo['descricao'] = CriaVetTabela('Descri��o');
$vetCampo['ativo']     = CriaVetTabela('Ativo?', 'descDominio', $vetSimNao );

$sql   = "select ";
$sql  .= "   {$AliasPric}.*  ";
$sql  .= " from {$TabelaPrinc} as {$AliasPric} ";

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