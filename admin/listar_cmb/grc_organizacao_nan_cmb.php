<?php
$idCampo = 'idt';
$Tela = "o Entidade";

$idCampo = 'id_usuario';
$Tela = "a Pessoa";
$TabelaPrinc = "gec_entidade";
$AliasPric = "e";
$Entidade = "Pessoa";
$Entidade_p = "Pessoas";
$barra_inc_h = "Incluir um Novo Registro de {$Entidade}";
$contlinfim = "Existem #qt {$Entidade_p}.";
$forcarPesquisa = true;

$tipoidentificacao = 'N';
$tipofiltro = 'S';
$comfiltro = 'A';

$vetTipoEntidade = Array();

if ($_GET['tipo'] == '5') {
    $vetTipoEntidade['T'] = 'NAN e Funcionários';
    $vetTipoEntidade['C'] = 'Credenciados GC';
    $vetTipoEntidade['N'] = 'Credenciados NAN';
    $vetTipoEntidade['F'] = 'Funcionários';
    $vetTipoEntidade['G'] = 'NAN, GC e Funcionários ';
} else {
    $vetTipoEntidade['F'] = 'Funcionários';
}

$Filtro = Array();
$Filtro['rs'] = $vetTipoEntidade;
$Filtro['id'] = 'tipo_entidade';
$Filtro['nome'] = 'Tipo entidade (Tutor)';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['tipo_entidade'] = $Filtro;

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

// Monta o vetor de Campo
$vetCampo['nome_completo'] = CriaVetTabela('NOME');
$vetCampo['credenciado'] = CriaVetTabela('Credenciado?');
$vetCampo['credenciado_nan'] = CriaVetTabela('Credenciado NAN?');
$vetCampo['funcionario'] = CriaVetTabela('Funcionário?');

if ($includeListarCmb === true) {
    $sql = '';
    $sql .= ' select u.id_usuario, u.nome_completo,';
    $sql .= " concat_ws(' - ', u.nome_completo) as {$campoDescListarCmb}";
    $sql .= ' from plu_usuario u';
    $sql .= ' where u.id_usuario = '.null($includeListarCmbWhere);
} else {
    $sql = '';
    $sql .= ' select u.id_usuario, u.nome_completo, e.credenciado, e.credenciado_nan, "N" as funcionario, ';
    $sql .= " concat_ws(' - ', u.nome_completo) as {$campoDescListarCmb}";
    $sql .= ' from plu_usuario u';
    $sql .= ' inner join '.db_pir_gec.'gec_entidade e on e.codigo = u.login';
    $sql .= " where e.tipo_entidade = 'P'";
    $sql .= " and e.reg_situacao = 'A'";
    $sql .= " and e.ativo = 'S'";

    $sql_nan = "(e.credenciado = 'S' and e.credenciado_nan = 'S' and e.nan_ano = ".aspa(nan_ano).")";

    switch ($vetFiltro['tipo_entidade']['valor']) {
        case 'G':
            // Todos
            $sql .= " and ({$sql_nan} or (e.credenciado = 'S' and e.credenciado_nan = 'N'))";
            break;

        case 'T':
            // T Funcionários e AOE
            $sql .= " and ({$sql_nan} or u.matricula_intranet is not null )";
            break;

        case 'N':
            // N AOE
            $sql .= " and ({$sql_nan})";
            break;

        case 'C':
            // C Só Credenciados GC
            $sql .= " and (credenciado = 'S' and credenciado_nan = 'N')";
            break;

        case 'F':
            // F Só Funcionários
            $sql .= " and (1 = 2)";
            break;
    }

    if ($vetFiltro['texto']['valor'] != '') {
        $sql .= ' and ( ';
        $sql .= '    lower(u.nome_completo) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
        $sql .= ' ) ';
    }

    if ($vetFiltro['cpf']['valor'] != '') {
        $sql .= ' and u.cpf = '.aspa($vetFiltro['texto']['valor']);
    }

    if ($vetFiltro['tipo_entidade']['valor'] != "N" && $vetFiltro['tipo_entidade']['valor'] != "C") {
        $sql .= ' union';

        $sql .= ' select u.id_usuario, u.nome_completo, "N" as credenciado, "N" as credenciado_nan, "S" as funcionario, ';
        $sql .= " concat_ws(' - ', u.nome_completo) as {$campoDescListarCmb}";

        $sql .= ' from plu_usuario u';
        $sql .= " where u.matricula_intranet is not null";

        if ($vetFiltro['texto']['valor'] != '') {
            $sql .= ' and ( ';
            $sql .= '    lower(u.nome_completo) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
            $sql .= ' ) ';
        }

        if ($vetFiltro['cpf']['valor'] != '') {
            $sql .= ' and u.cpf = '.aspa($vetFiltro['texto']['valor']);
        }
    }
}
