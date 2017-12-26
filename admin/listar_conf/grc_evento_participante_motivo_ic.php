<?php
$idCampo = 'idt';
$Tela = "o Motivo do Cancelamento da Inscriчуo";

$TabelaPrinc = "grc_evento_participante_motivo_ic";
$AliasPric = "grc_eb";
$Entidade = "Motivo do Cancelamento da Inscriчуo";
$Entidade_p = "Motivo do Cancelamento da Inscriчуo";

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

$vetCampo['descricao'] = CriaVetTabela('Descriчуo');

$sql = "select ";
$sql .= "   {$AliasPric}.*  ";
$sql .= " from {$TabelaPrinc} as {$AliasPric} ";

if ($vetFiltro['texto']['valor'] != "") {
    $sql .= ' where ';
    $sql .= ' ( ';
    $sql .= '  lower(' . $AliasPric . '.descricao) like lower(' . aspa($vetFiltro['texto']['valor'], '%', '%') . ')';
    $sql .= ' ) ';
}
