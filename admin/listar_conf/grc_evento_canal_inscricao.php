<?php
$idCampo = 'idt';
$Tela = "o Canal de Inscriзгo do Evento";

$TabelaPrinc = "grc_evento_canal_inscricao";
$AliasPric = "grc_eci";
$Entidade = "Canal de Inscriзгo do Evento";
$Entidade_p = "Canais de Inscriзгo do Evento";

$barra_inc_h = "Incluir um Novo Registro de {$Entidade}";
$contlinfim = "Existem #qt {$Entidade_p}.";

$barra_exc_ap = false;

$Filtro = Array();
$Filtro['rs'] = 'Texto';
$Filtro['id'] = 'texto';
$Filtro['js_tam'] = '0';
$Filtro['nome'] = 'Texto';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['texto'] = $Filtro;

$vetCampo['codigo'] = CriaVetTabela('Cуdigo');
$vetCampo['descricao'] = CriaVetTabela('Descriзгo');
$vetCampo['ativo'] = CriaVetTabela('Ativo?', 'descDominio', $vetSimNao);

$sql = "select ";
$sql .= "   {$AliasPric}.*  ";
$sql .= " from {$TabelaPrinc} as {$AliasPric} ";

if ($vetFiltro['texto']['valor'] != "") {
    $sql .= ' where ';
    $sql .= ' ( ';
    $sql .= '  lower(' . $AliasPric . '.codigo)      like lower(' . aspa($vetFiltro['texto']['valor'], '%', '%') . ')';
    $sql .= ' or lower(' . $AliasPric . '.descricao) like lower(' . aspa($vetFiltro['texto']['valor'], '%', '%') . ')';
    $sql .= ' ) ';
}
