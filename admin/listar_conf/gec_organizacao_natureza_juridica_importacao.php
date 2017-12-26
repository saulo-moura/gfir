<?php
$idCampo = 'idt';
$Tela = "a Importação da Natureza Jurídica";
//Monta o vetor de Campo
$TabelaPrinc      = "gec_organizacao_natureza_juridica_importacao";
$AliasPric        = "gec_onji";
$Entidade         = "Importação da Natureza Jurídica";
$Entidade_p       = "Importações da Natureza Jurídica";
$barra_inc_h      = "Incluir um Novo Registro de {$Entidade} ";
$contlinfim       = "Existem #qt {$Entidade_p}.";


$Filtro = Array();
$Filtro['rs']       = 'Texto';
$Filtro['id']       = 'texto';
$Filtro['js_tam']   = '0';
$Filtro['nome']     = 'Texto';
$Filtro['valor']    = trata_id($Filtro);
$vetFiltro['texto'] = $Filtro;

$orderby = "{$AliasPric}.codigo";

$vetCampo['codigo']    = CriaVetTabela('Código');
$vetCampo['descricao'] = CriaVetTabela('Descrição');

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
