<?php
if ($veio == '') {
    $veio = 'O';
}

$ordFiltro = false;
$idCampo = 'idt';
$idCampoPar = 'entidade_idt';
$Tela = "o Entidade";

$tipoidentificacao = 'N';
$tipofiltro = 'S';
$comfiltro = 'A';

$TabelaPrinc = "gec_entidade";
$AliasPric = "gec_en";
$Entidade = "Entidade";
$Entidade_p = "Entidades";
$barra_inc_h = 'Incluir um Novo Registro de Entidade';
$contlinfim = "Existem #qt Entidades.";
$forcarPesquisa = true;

if ($veio == "O") {
    $Filtro = Array();
    $Filtro['rs'] = 'Texto';
    $Filtro['id'] = 'entidade_texto_nome';
    $Filtro['js_tam'] = '0';
    $Filtro['nome'] = 'Razão Social';
    $Filtro['valor'] = trata_id($Filtro);
    $vetFiltro['texto_nome'] = $Filtro;

    $js = 'onblur="return Valida_CNPJ(this)" onkeyup="return Formata_Cnpj(this,event)"';
    $Filtro = Array();
    $Filtro['rs'] = 'Texto';
    $Filtro['id'] = 'entidade_texto_cnpj';
    $Filtro['js'] = $js;
    $Filtro['nome'] = 'CNPJ';
    $Filtro['valor'] = trata_id($Filtro);
    $vetFiltro['texto_cnpj'] = $Filtro;

    $Filtro = Array();
    $Filtro['rs'] = $vetSimNao;
    $Filtro['id'] = 'entidade_tipo_registro';
    $Filtro['LinhaUm'] = '<< Todos >>';
    $Filtro['nome'] = 'Produtor Rural?';
    $Filtro['valor'] = trata_id($Filtro);
    $vetFiltro['tipo_registro'] = $Filtro;

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
} else {
    $Filtro = Array();
    $Filtro['rs'] = 'Texto';
    $Filtro['id'] = 'entidade_texto_nome';
    $Filtro['js_tam'] = '0';
    $Filtro['nome'] = 'Nome';
    $Filtro['valor'] = trata_id($Filtro);
    $vetFiltro['texto_nome'] = $Filtro;

    $js = 'onblur="return   Valida_CPF(this);" onkeyup="return Formata_Cpf(this,event)"';
    $Filtro = Array();
    $Filtro['rs'] = 'Texto';
    $Filtro['id'] = 'entidade_texto_cpf';
    $Filtro['js'] = $js;

    $Filtro['nome'] = 'CPF';
    $Filtro['valor'] = trata_id($Filtro);
    $vetFiltro['texto_cpf'] = $Filtro;
}

$Filtro = Array();
$Filtro['rs'] = 'Texto';
$Filtro['id'] = 'entidade_texto';
$Filtro['js_tam'] = '0';
$Filtro['nome'] = 'Texto';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['texto'] = $Filtro;

if ($veio == "O") {
    $vetCampo['tipo_registro'] = CriaVetTabela('PRODUTOR RURAL', 'func_trata_dado', ftd_gec_entidade);
    $vetCampo['codigo'] = CriaVetTabela('INDENTIFICAÇÃO', 'func_trata_dado', ftd_gec_entidade);
    $vetCampo['descricao'] = CriaVetTabela('RAZÃO SOCIAL');
    $vetCampo['resumo'] = CriaVetTabela('NOME FANTASIA');
    $vetCampo['porte'] = CriaVetTabela('PORTE');
    $vetCampo['gec_es_descricao'] = CriaVetTabela('SITUAÇÃO DO CADASTRO');
    $vetCampo['codigo_siacweb'] = CriaVetTabela('CÓDIGO SAICWEB');
} else {
    $vetCampo['codigo'] = CriaVetTabela('CPF');
    $vetCampo['descricao'] = CriaVetTabela('NOME');
    $vetCampo['gec_es_descricao'] = CriaVetTabela('SITUAÇÃO DO CADASTRO');
    $vetCampo['codigo_siacweb'] = CriaVetTabela('CÓDIGO SAICWEB');
}

$sql = 'select gec_en.*,';

if ($veio == "O") {
    $sql .= ' gec_eo.dap, gec_eo.nirf, gec_eo.rmp, gec_eo.ie_prod_rural,';
    $sql .= " concat_ws(' - ', gec_pr.descricao, gec_pr.desc_vl_cmb) as porte,";
    $sql .= " concat_ws(' - ', gec_en.codigo, gec_eo.dap, gec_eo.nirf, gec_eo.rmp, gec_eo.ie_prod_rural, gec_en.descricao) as {$campoDescListarCmb},";
} else {
    $sql .= " concat_ws(' - ', gec_en.codigo, gec_en.descricao) as {$campoDescListarCmb},";
}

$sql .= ' gec_en.idt_pessoa_sgc as gec_en_idt_pessoa_sgc, ';
$sql .= ' gec_es.descricao as gec_es_descricao ';
$sql .= ' from ' . db_pir_gec . 'gec_entidade gec_en ';
$sql .= ' inner join ' . db_pir_gec . 'gec_entidade_situacao  gec_es on gec_es.idt  = gec_en.idt_situacao ';

if ($veio == "O") {
    $sql .= ' inner join ' . db_pir_gec . 'gec_entidade_organizacao gec_eo on gec_eo.idt_entidade = gec_en.idt';
    $sql .= ' inner join ' . db_pir_gec . 'gec_organizacao_porte gec_pr on gec_pr.idt = gec_eo.idt_porte';
}

$sql .= ' where gec_en.tipo_entidade = ' . aspa($veio);
$sql .= " and gec_en.reg_situacao='A'";

if ($includeListarCmb === true) {
    $sql .= ' and gec_en.idt = ' . null($includeListarCmbWhere);
} else {
    if ($veio == "O") {
        if ($vetFiltro['texto_cnpj']['valor'] != "") {
            $sql .= ' and gec_en.codigo like lower(' . aspa($vetFiltro['texto_cnpj']['valor'], '%', '%') . ')';
        }

        if ($vetFiltro['tipo_registro']['valor'] == 'S') {
            $sql .= " and gec_en.tipo_registro = 'PR'";
        } else if ($vetFiltro['tipo_registro']['valor'] == 'N') {
            $sql .= " and gec_en.tipo_registro = 'OP'";
        }

        if ($vetFiltro['dap']['valor'] != "") {
            $sql .= ' and gec_eo.dap like lower(' . aspa($vetFiltro['dap']['valor'], '%', '%') . ')';
        }

        if ($vetFiltro['nirf']['valor'] != "") {
            $sql .= ' and gec_eo.nirf = ' . aspa($vetFiltro['nirf']['valor']);
        }

        if ($vetFiltro['rmp']['valor'] != "") {
            $sql .= ' and gec_eo.rmp like lower(' . aspa($vetFiltro['rmp']['valor'], '%', '%') . ')';
        }

        if ($vetFiltro['ie_prod_rural']['valor'] != "") {
            $sql .= ' and gec_eo.ie_prod_rural like lower(' . aspa($vetFiltro['ie_prod_rural']['valor'], '%', '%') . ')';
        }
    } else {
        if ($vetFiltro['texto_cpf']['valor'] != "") {
            $sql .= ' and gec_en.codigo like lower(' . aspa($vetFiltro['texto_cpf']['valor'], '%', '%') . ')';
        }
    }

    if ($vetFiltro['texto_nome']['valor'] != "") {
        $sql .= ' and gec_en.descricao  like lower(' . aspa($vetFiltro['texto_nome']['valor'], '%', '%') . ')';
    }

    if ($vetFiltro['texto']['valor'] != '') {
        $sql .= ' and ( ';
        $sql .= '  lower(gec_en.codigo)      like lower(' . aspa($vetFiltro['texto']['valor'], '%', '%') . ')';
        $sql .= ' or lower(gec_en.descricao) like lower(' . aspa($vetFiltro['texto']['valor'], '%', '%') . ')';
        $sql .= ' or lower(gec_en.natureza) like lower(' . aspa($vetFiltro['texto']['valor'], '%', '%') . ')';
        $sql .= ' or lower(gec_en.resumo)    like lower(' . aspa($vetFiltro['texto']['valor'], '%', '%') . ')';
        $sql .= ' ) ';
    }
}

//echo "'".$sql."'<br />";