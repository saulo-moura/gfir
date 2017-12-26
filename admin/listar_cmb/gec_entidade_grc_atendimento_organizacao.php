<?php
$ordFiltro = false;
$idCampo = 'idt';
$Tela = "a Pessoa";
$TabelaPrinc = "gec_entidade";
$AliasPric = "gec_en";
$Entidade = "Pessoa";
$Entidade_p = "Pessoas";
$barra_inc_h = "Incluir um Novo Registro de {$Entidade}";
$contlinfim = "Existem #qt {$Entidade_p}.";
$forcarPesquisa = true;

$tipoidentificacao = 'N';
$tipofiltro = 'S';
$comfiltro = 'A';

$_GET['entidade_texto_cnpj'] = rawurldecode($_GET['entidade_texto_cnpj']);
$_GET['entidade_dap'] = rawurldecode($_GET['entidade_dap']);
$_GET['entidade_nirf'] = rawurldecode($_GET['entidade_nirf']);
$_GET['entidade_rmp'] = rawurldecode($_GET['entidade_rmp']);
$_GET['entidade_ie_prod_rural'] = rawurldecode($_GET['entidade_ie_prod_rural']);
$_GET['entidade_texto_nome'] = rawurldecode($_GET['entidade_texto_nome']);
$_GET['entidade_texto_fantasia'] = rawurldecode($_GET['entidade_texto_fantasia']);

$Filtro = Array();
$sql = '';
$sql .= ' select idt, descricao';
$sql .= ' from '.db_pir_gec.'gec_entidade_situacao';
$sql .= ' order by ativo desc, descricao';
$Filtro['rs'] = execsql($sql);
$Filtro['id'] = 'idt';
$Filtro['nome'] = 'Situação';
$Filtro['LinhaUm'] = '<< Todos >>';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['situacao'] = $Filtro;

$Filtro = Array();
$Filtro['rs'] = 'Texto';
$Filtro['id'] = 'entidade_texto_nome';
$Filtro['js_tam'] = '0';
$Filtro['nome'] = 'Razão Social';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['texto_nome'] = $Filtro;

$Filtro = Array();
$Filtro['rs'] = 'Texto';
$Filtro['id'] = 'entidade_texto_fantasia';
$Filtro['js_tam'] = '0';
$Filtro['nome'] = 'Nome Fantasia';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['texto_fantasia'] = $Filtro;

$js = 'onblur="return Valida_CNPJ(this)" onkeyup="return Formata_Cnpj(this,event)"';
$Filtro = Array();
$Filtro['rs'] = 'Texto';
$Filtro['id'] = 'entidade_texto_cnpj';
$Filtro['js'] = $js;
$Filtro['nome'] = 'CNPJ';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['texto_cnpj'] = $Filtro;

$Filtro = Array();
$Filtro['rs'] = 'Texto';
$Filtro['id'] = 'entidade_dap';
$Filtro['js_tam'] = '0';
$Filtro['nome'] = 'DAP';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['dap'] = $Filtro;

$Filtro = Array();
$Filtro['rs'] = 'Texto';
$Filtro['id'] = 'entidade_nirf';
$Filtro['js'] = ' onblur="return Valida_Nirf(this);" onkeyup="return Formata_Nirf(this);"';
$Filtro['nome'] = 'NIRF';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['nirf'] = $Filtro;

$Filtro = Array();
$Filtro['rs'] = 'Texto';
$Filtro['id'] = 'entidade_rmp';
$Filtro['js_tam'] = '0';
$Filtro['nome'] = 'Registro Ministério da Pesca';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['rmp'] = $Filtro;

$Filtro = Array();
$Filtro['rs'] = 'Texto';
$Filtro['id'] = 'entidade_ie_prod_rural';
$Filtro['js_tam'] = '0';
$Filtro['nome'] = 'Inscrição Estadual';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['ie_prod_rural'] = $Filtro;

$Filtro = Array();
$Filtro['rs'] = 'Texto';
$Filtro['id'] = 'texto';
$Filtro['js_tam'] = '0';
$Filtro['nome'] = 'Texto';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['texto'] = $Filtro;

// Monta o vetor de Campo
$vetCampo['codigo'] = CriaVetTabela('CNPJ');
$vetCampo['descricao'] = CriaVetTabela('RAZÃO SOCIAL');
$vetCampo['resumo'] = CriaVetTabela('NOME FANTASIA');
$vetCampo['gec_ec_descricao'] = CriaVetTabela('CLASSE');
$vetCampo['gec_es_descricao'] = CriaVetTabela('SITUAÇÃO<br /> DO CADASTRO');

$sql = 'select gec_en.*, ';
$sql .= '      gec_es.descricao as gec_es_descricao, ';
$sql .= '      gec_ec.descricao as gec_ec_descricao, ';
$sql .= '      gec_et.descricao as gec_et_descricao, ';
//$sql .= " concat_ws(' - ', gec_en.codigo, gec_en.descricao) as {$campoDescListarCmb}";

$sql .= " concat_ws('', gec_en.codigo) as {$campoDescListarCmb}";



$sql .= ' from '.db_pir_gec.'gec_entidade gec_en ';
$sql .= ' inner join '.db_pir_gec.'gec_entidade_situacao  gec_es on gec_es.idt  = gec_en.idt_situacao ';
$sql .= ' inner join '.db_pir_gec.'gec_entidade_classe gec_ec on gec_ec.idt  = gec_en.idt_entidade_classe ';
$sql .= ' inner join '.db_pir_gec.'gec_entidade_tipo gec_et on gec_et.codigo = gec_en.tipo_entidade ';
$sql .= ' inner join '.db_pir_gec.'gec_entidade_organizacao gec_eo on gec_eo.idt_entidade = gec_en.idt';
$sql .= " where gec_en.tipo_entidade = 'O'";
$sql .= " and gec_en.reg_situacao = 'A'";

//$sql .= ' and gec_en.ativo = '.aspa($vetFiltro['ativo']['valor']);

if ($includeListarCmb === true) {
    $sql .= ' and gec_en.idt = '.null($includeListarCmbWhere);
}

if ($vetFiltro['texto']['valor'] != '') {
    $sql .= ' and ( ';
    $sql .= '    lower(gec_en.descricao) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= ' or lower(gec_en.resumo)    like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';

    $sql .= ' or lower(gec_ec.descricao) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= ' or lower(gec_ec.detalhe) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';

    $sql .= ' or lower(gec_es.descricao) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= ' or lower(gec_es.detalhe) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';

    $sql .= ' ) ';
}

if ($vetFiltro['situacao']['valor'] > 0) {
    $sql .= ' and gec_en.idt_situacao = '.null($vetFiltro['situacao']['valor']);
}

$temWhere = false;

if ($vetFiltro['texto_cnpj']['valor'] != "") {
    $temWhere = true;
    $sql .= ' and gec_en.codigo = '.aspa($vetFiltro['texto_cnpj']['valor']);
}

if ($vetFiltro['dap']['valor'] != "") {
    $temWhere = true;
    $sql .= ' and gec_eo.dap = '.aspa($vetFiltro['dap']['valor']);
}

if ($vetFiltro['nirf']['valor'] != "") {
    $temWhere = true;
    $sql .= ' and gec_eo.nirf = '.aspa($vetFiltro['nirf']['valor']);
}

if ($vetFiltro['rmp']['valor'] != "") {
    $temWhere = true;
    $sql .= ' and gec_eo.rmp = '.aspa($vetFiltro['rmp']['valor']);
}

if ($vetFiltro['ie_prod_rural']['valor'] != "") {
    $temWhere = true;
    $sql .= ' and gec_eo.ie_prod_rural = '.aspa($vetFiltro['ie_prod_rural']['valor']);
}

if (!$temWhere) {
    if ($vetFiltro['texto_fantasia']['valor'] != "") {
        $sql .= ' and gec_en.descricao like '.aspa($vetFiltro['texto_fantasia']['valor'], '%', '%');
    }
    
    if ($vetFiltro['texto_fantasia']['valor'] != "") {
        $sql .= ' and gec_en.resumo like '.aspa($vetFiltro['texto_fantasia']['valor'], '%', '%');
    }
}