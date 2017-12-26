<?php
$idCampo = 'idt';
$Tela = "o Entidade";
//
$idCampo = 'idt';
$Tela = "a Pessoa";
$TabelaPrinc = "gec_entidade";
$AliasPric = "gec_en";
$Entidade = "Pessoa";
$Entidade_p = "Pessoas";
$barra_inc_h = "Incluir um Novo Registro de {$Entidade}";
$contlinfim = "Existem #qt {$Entidade_p}.";
$forcarPesquisa = true;
//
$tipoidentificacao = 'N';
$tipofiltro = 'S';
$comfiltro = 'A';
//
$Filtro = Array();
$Filtro['rs'] = $vetSimNao;
$Filtro['id'] = 'ativo';
$Filtro['nome'] = 'Ativo';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['ativo'] = $Filtro;
//
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
//
$Filtro = Array();
$Filtro['rs'] = 'Texto';
$Filtro['id'] = 'texto';
$Filtro['js_tam'] = '0';
$Filtro['nome'] = 'Texto';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['texto'] = $Filtro;
//
$Filtro = Array();
$Filtro['rs'] = 'Texto';
$Filtro['id'] = 'cpf';
$Filtro['js'] = 'onblur="return Valida_CPF(this);" onkeyup="return Formata_Cpf(this,event)"';
$Filtro['nome'] = 'CPF';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['cpf'] = $Filtro;
//
// Monta o vetor de Campo
//
$vetCampo['codigo'] = CriaVetTabela('CPF');
$vetCampo['descricao'] = CriaVetTabela('NOME');
$vetCampo['resumo'] = CriaVetTabela('NOME RESUMO (APELIDO)');
$vetCampo['gec_ec_descricao'] = CriaVetTabela('CLASSE');
$vetCampo['gec_es_descricao'] = CriaVetTabela('SITUAÇÃO<br /> DO CADASTRO');
//
$sql = 'select gec_en.*, ';
$sql .= '      gec_es.descricao as gec_es_descricao, ';
$sql .= '      gec_ec.descricao as gec_ec_descricao, ';
$sql .= '      gec_et.descricao as gec_et_descricao, ';
$sql .= " concat_ws(' - ', gec_en.codigo, gec_en.descricao) as {$campoDescListarCmb}";
$sql .= ' from '.db_pir_gec.'gec_entidade gec_en ';
//
$sql .= ' inner join '.db_pir_gec.'gec_entidade_situacao  gec_es on gec_es.idt  = gec_en.idt_situacao ';
$sql .= ' inner join '.db_pir_gec.'gec_entidade_classe gec_ec on gec_ec.idt     = gec_en.idt_entidade_classe ';
$sql .= ' inner join '.db_pir_gec.'gec_entidade_tipo gec_et on gec_et.codigo    = gec_en.tipo_entidade ';
//
$sql .= " where gec_en.tipo_entidade = 'O'";
$sql .= " and gec_en.reg_situacao = 'A'";

if ($includeListarCmb === true) {
    $sql .= ' and gec_en.idt = '.null($includeListarCmbWhere);
} else {
    $sql .= ' and gec_en.ativo = '.aspa($vetFiltro['ativo']['valor']);
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
//
if ($vetFiltro['cpf']['valor'] != '') {
    $sql .= ' and gec_en.codigo = '.aspa($vetFiltro['cpf']['valor']);
}
//
if ($vetFiltro['situacao']['valor'] > 0) {
    $sql .= ' and gec_en.idt_situacao = '.null($vetFiltro['situacao']['valor']);
}