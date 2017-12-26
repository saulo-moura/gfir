<?php
$idCampo = 'idt';
$Tela = "a Compet�ncia";

$TabelaPrinc      = "grc_competencia";
$AliasPric        = "grc_com";
$Entidade         = "Compet�ncia";
$Entidade_p       = "Compet�ncias";

$barra_inc_h = "Incluir um Novo Registro de {$Entidade}";
$contlinfim  = "Existem #qt {$Entidade_p}.";

$Filtro = Array();
$Filtro['rs']       = 'Texto';
$Filtro['id']       = 'texto';
$Filtro['js_tam']   = '0';
$Filtro['nome']     = 'Texto';
$Filtro['valor']    = trata_id($Filtro);
$vetFiltro['texto'] = $Filtro;

$orderby = "{$AliasPric}.ano desc, {$AliasPric}.mes desc ";

$vetCampo['data_inicial'] = CriaVetTabela('Data Inicial','data');
$vetCampo['data_final']   = CriaVetTabela('Data Final','data');
$vetCampo['ano']          = CriaVetTabela('Ano');
$vetCampo['mes']          = CriaVetTabela('M�s');
$vetCampo['texto']        = CriaVetTabela('Descri��o');
$vetCampo['fechado']      = CriaVetTabela('Fechado?', 'descDominio', $vetSimNao );

$sql   = "select ";
$sql  .= "   {$AliasPric}.*  ";
$sql  .= " from {$TabelaPrinc} as {$AliasPric} ";

if ($vetFiltro['texto']['valor']!="")
{
    $sql .= ' where ';
    $sql .= ' ( ';
    $sql .= '  lower('.$AliasPric.'.ano)      like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= '  lower('.$AliasPric.'.mes)      like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= ' or lower('.$AliasPric.'.texto)  like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= ' ) ';
}
$sql  .= " order by {$orderby}";

?>