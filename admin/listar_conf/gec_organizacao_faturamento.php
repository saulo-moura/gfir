<?php
$idCampo = 'idt';
$Tela = "o Faturamento da Organiza��o";


$TabelaPrinc      = "gec_organizacao_faturamento";
$AliasPric        = "gec_of";
$Entidade         = "Faturamento da Organiza��o";
$Entidade_p       = "Faturamentos da Organiza��o";

$barra_inc_h = "Incluir um Novo Registro de {$Entidade}";
$contlinfim  = "Existem #qt {$Entidade_p}.";

$Filtro = Array();
$Filtro['rs']       = 'Texto';
$Filtro['id']       = 'texto';
$Filtro['js_tam']   = '0';
$Filtro['nome']     = 'Texto';
$Filtro['valor']    = trata_id($Filtro);
$vetFiltro['texto'] = $Filtro;

$orderby = "{$AliasPric}.valor_menor";

$vetCampo['codigo']    = CriaVetTabela('C�digo');
$vetCampo['descricao'] = CriaVetTabela('Descri��o');

$vetCampo['valor_menor']    = CriaVetTabela('Faixa Menor de Faturamento','decimal');
$vetCampo['valor_maior']    = CriaVetTabela('Faixa Maior de Faturamento','decimal');


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