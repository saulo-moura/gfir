<?php
$idCampo = 'idt';
$comfiltro = 'A';

$Filtro = Array();
$Filtro['rs'] = 'Texto';
$Filtro['id'] = 'texto';
$Filtro['js_tam'] = '0';
$Filtro['nome'] = 'Texto';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['texto'] = $Filtro;

$vetTmp = Array(
    'S' => 'Não',
    'N' => 'Sim',
);

$vetCampo['codigo_evento'] = CriaVetTabela('Código do Evento');
$vetCampo['codigo_os'] = CriaVetTabela('Código da O.S.');
$vetCampo['dt_aprovacao'] = CriaVetTabela('Data/hora da Aprovação', 'datahora');
$vetCampo['md5'] = CriaVetTabela('Hash da Aprovação');
$vetCampo['ativo'] = CriaVetTabela('Cancelado?', 'descDominio', $vetTmp);

$sql = '';
$sql .= ' select *';
$sql .= ' from grc_evento_declaracao';

if ($vetFiltro['texto']['valor'] != "") {
    $sql .= ' where ';
    $sql .= ' ( ';
    $sql .= '  lower(md5) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= ' or lower(codigo_evento) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= ' or lower(codigo_os) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= ' ) ';
}
