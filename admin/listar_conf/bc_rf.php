<?php

$idCampo = "idt";
$Tela = "os lançamentos";

$TabelaPrinc = db_pir."bc_rf_2015";
$AliasPric = "bc_rf_2015";
$Entidade = "Lançamento";
$Entidade_p = "Lançamentos";

$barra_inc_h = "Incluir um Novo Registro de {$Entidade}";
$contlinfim = "Existem #qt {$Entidade_p}.";

$tipoidentificacao = 'N';
$tipofiltro = 'S';

$comfiltro = 'A';
$comidentificacao = 'F';

$barra_inc_ap = false;
$barra_alt_ap = false;
$barra_con_ap = true;
$barra_exc_ap = false;
$barra_fec_ap = false;

$Filtro = Array();
$Filtro['rs'] = 'Texto';
$Filtro['id'] = 'cnpj';
$Filtro['js'] = 'onblur="return Valida_CNPJ(this);" onkeyup="return Formata_Cnpj(this,event)"';
$Filtro['nome'] = 'CNPJ';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['cnpj'] = $Filtro;

$Filtro = Array();
$Filtro['rs'] = 'Texto';
$Filtro['id'] = 'texto';
$Filtro['js_tam'] = '0';
$Filtro['nome'] = 'Texto';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['texto'] = $Filtro;

$orderby = "{$AliasPric}.D";

$vetCampo = Array();
$vetCampo['cnpj'] = CriaVetTabela('CNPJ');
$vetCampo['razao_social'] = CriaVetTabela('Razão Social');
$vetCampo['nome_fantasia'] = CriaVetTabela('Nome Fantasia');

//$vetCampo = Array();
//$vetCampo['b'] = CriaVetTabela('B - CNPJ');
//$vetCampo['d'] = CriaVetTabela('D - Razão Social');
//$vetCampo['e'] = CriaVetTabela('E - Nome Fantasia');
//$sql   = "select ";
//$sql  .= "   {$AliasPric}.*  ";
//$sql  .= " from {$TabelaPrinc} as {$AliasPric} ";

$sql = "";
$sql .= " SELECT ";
$sql .= " idt, ";
$sql .= " cnpj as cnpj,";
$sql .= " razao_social as razao_social,";
$sql .= " nome_fantasia as nome_fantasia";
$sql .= " FROM {$TabelaPrinc} as {$AliasPric}";
$sql .= ' where 1 = 1';

if ($vetFiltro['cnpj']['valor'] != '') {
    $sql .= ' and cnpj = '.aspa($vetFiltro['cnpj']['valor']);
}

if ($vetFiltro['texto']['valor'] != "") {
    $sql .= " and";
    $sql .= " (";
    $sql .= "  LOWER(razao_social) LIKE LOWER(" . aspa($vetFiltro["texto"]["valor"], "%", "%") . ")";
    $sql .= " OR LOWER(nome_fantasia) LIKE LOWER(" . aspa($vetFiltro["texto"]["valor"], "%", "%") . ")";
    $sql .= " )";
}
