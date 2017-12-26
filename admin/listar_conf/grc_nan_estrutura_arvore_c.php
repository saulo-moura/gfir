<?php
$idCampo = 'idt';
$Tela = "Estrutura Completa NAN";

$Entidade = "Estrutura Completa NAN";
$Entidade_p = "Estruturas Completa NAN";

$tipoidentificacao = 'N';
$tipofiltro = 'S';
$comfiltro = 'A';
$comidentificacao = 'F';

$barra_inc_h = "Incluir um Novo Registro de {$Entidade}";
$contlinfim = "Existem #qt {$Entidade_p}.";

$Filtro = Array();
$Filtro['rs'] = 'Texto';
$Filtro['id'] = 'texto';
$Filtro['js_tam'] = '0';
$Filtro['nome'] = 'Texto';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['texto'] = $Filtro;

$vetCampo['grc_nte_descricao'] = CriaVetTabela('Tipo de Ator');
$vetCampo['plu_usuario'] = CriaVetTabela('Ator');
$vetCampo['plu_usut_usuario'] = CriaVetTabela('Ator Superior');
$vetCampo['vl_aprova_ordem'] = CriaVetTabela('Valor da Alçada', 'decimal');

$sql = "select ";
$sql .= "   grc_ne.*, ";
$sql .= "   grc_nte.ordem as grc_nte_ordem,";
$sql .= "   grc_nte.descricao as grc_nte_descricao,";
$sql .= "   plu_usu.nome_completo as plu_usuario,";
$sql .= "   plu_usut.nome_completo as plu_usut_usuario";
$sql .= " from grc_nan_estrutura grc_ne";
$sql .= " inner join grc_nan_estrutura_tipo grc_nte on grc_nte.idt    = grc_ne.idt_nan_tipo ";
$sql .= " left outer join plu_usuario plu_usu on plu_usu.id_usuario   = grc_ne.idt_usuario ";
$sql .= " left outer join grc_nan_estrutura grc_net on grc_net.idt    = grc_ne.idt_tutor ";
$sql .= " left outer join plu_usuario plu_usut on plu_usut.id_usuario = grc_net.idt_usuario ";
$sql .= " where grc_nte.idt in (8, 9, 2, 4)";

if ($vetFiltro['texto']['valor'] != "") {
    $sql .= ' and ';
    $sql .= ' ( ';
    $sql .= '     lower(grc_nte.descricao) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= '  or lower(plu_usu.nome_completo) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= '  or lower(plu_usu.login) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= '  or lower(plu_usut.nome_completo) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= '  or lower(plu_usut.login) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= ' ) ';
}

$vetOrderby = Array(
    "grc_nte.ordem" => 'Ordem do Tipo',
    "grc_nte.descricao" => 'Tipo de Ator',
    "plu_usu.nome_completo" => 'Ator',
    "plu_usut.nome_completo" => 'Ator Superior',
);