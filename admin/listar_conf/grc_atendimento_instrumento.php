<?php
$idCampo = 'idt';
$Tela = "o Instrumento de Atendimento";

$TabelaPrinc      = "grc_atendimento_instrumento";
$AliasPric        = "grc_ai";
$Entidade         = "Instrumento de Atendimento";
$Entidade_p       = "Instrumentos de Atendimento";

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

$vetCampo['codigo']    = CriaVetTabela('Cуdigo');
$vetCampo['descricao'] = CriaVetTabela('Descriзгo');
$vetCampo['codigo_siacweb']    = CriaVetTabela('Cуdigo SiacWeb');
$vetCampo['codigo_familia_siac']    = CriaVetTabela('Cуdigo Famнlia SiacWeb');
$vetCampo['codigo_sge']    = CriaVetTabela('Cуdigo SGE');
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