<?php
$idCampo = 'idt';
$Tela = "o Tipo da Galeria";

$TabelaPrinc = "grc_tipo_galeria";
$AliasPric = "grc_pti";
$Entidade = "Tipo da Galeria";
$Entidade_p = "Tipo da Galeria";

$barra_inc_h = "Incluir um Novo Registro de {$Entidade}";
$contlinfim = "Existem #qt {$Entidade_p}.";

$Filtro = Array();
$Filtro['rs'] = 'Texto';
$Filtro['id'] = 'texto';
$Filtro['js_tam'] = '0';
$Filtro['nome'] = 'Texto';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['texto'] = $Filtro;

$vetCampo['descricao'] = CriaVetTabela('Descriчуo');
$vetCampo['tem_link'] = CriaVetTabela('Tem Link?', 'descDominio', $vetSimNao);
$vetCampo['tem_arquivo'] = CriaVetTabela('Tem Arquivo?', 'descDominio', $vetSimNao);

$sql = "select ";
$sql .= "   {$AliasPric}.*  ";
$sql .= " from {$TabelaPrinc} as {$AliasPric} ";

if ($vetFiltro['texto']['valor'] != "") {
    $sql .= ' where ';
    $sql .= ' ( ';
    $sql .= '  lower(' . $AliasPric . '.descricao) like lower(' . aspa($vetFiltro['texto']['valor'], '%', '%') . ')';
    $sql .= ' ) ';
}