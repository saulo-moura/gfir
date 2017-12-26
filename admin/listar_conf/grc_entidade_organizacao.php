<?php
if ($veio == '') {
    $veio = 'O';
}

$ordFiltro = false;
$idCampo = 'idt';
$idCampoPar = 'entidade_idt';
$Tela = "o Entidade";

$barra_inc_ap = true;
$barra_alt_ap = true;
$barra_con_ap = true;
$barra_exc_ap = false;

$tipoidentificacao = 'N';
$tipofiltro = 'S';
$comfiltro = 'A';

$TabelaPrinc = "gec_entidade";
$AliasPric = "gec_en";
$Entidade = "Entidade";
$Entidade_p = "Entidades";
$barra_inc_h = 'Incluir um Novo Registro de Entidade';
$contlinfim = "Existem #qt Entidades.";

$Filtro = Array();
$Filtro['rs'] = $vetSimNao;
$Filtro['id'] = 'entidade_atendimento';
$Filtro['nome'] = 'Cliente com Atendimento?';
$Filtro['LinhaUm'] = '<< Todos >>';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['atendimento'] = $Filtro;

$Filtro = Array();
$sql = '';
$sql .= ' select idt, descricao';
$sql .= ' from ' . db_pir_gec . 'gec_entidade_situacao';
$sql .= ' order by ativo desc, descricao';
$Filtro['rs'] = execsql($sql);
$Filtro['id_select'] = 'idt';
$Filtro['id'] = 'entidade_situacao';
$Filtro['nome'] = 'Situação';
$Filtro['LinhaUm'] = '<< Todos >>';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['situacao'] = $Filtro;

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
    $Filtro['rs'] = $vetTipoOrganizacao;
    $Filtro['id'] = 'entidade_tipo_registro';
    $Filtro['LinhaUm'] = '<< Todos >>';
    $Filtro['nome'] = 'Tipo da Organização?';
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

    $Filtro = Array();
    $Filtro['rs'] = 'Texto';
    $Filtro['id'] = 'entidade_sicab_codigo';
    $Filtro['js'] = ' onblur="return ValidaSICAB(this);" onkeyup="return FormataSICAB(this);"';
    $Filtro['nome'] = 'SICAB';
    $Filtro['valor'] = trata_id($Filtro);
    $vetFiltro['sicab_codigo'] = $Filtro;
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
    $vetCampo['tipo_registro'] = CriaVetTabela('TIPO', 'func_trata_dado', ftd_gec_entidade);
    $vetCampo['codigo'] = CriaVetTabela('INDENTIFICAÇÃO', 'func_trata_dado', ftd_gec_entidade);
    $vetCampo['descricao'] = CriaVetTabela('RAZÃO SOCIAL');
    $vetCampo['resumo'] = CriaVetTabela('NOME FANTASIA');
    $vetCampo['porte'] = CriaVetTabela('PORTE');
    $vetCampo['gec_es_descricao'] = CriaVetTabela('SITUAÇÃO DO CADASTRO');
    $vetCampo['codigo_siacweb'] = CriaVetTabela('CÓDIGO SAICWEB');
	$vetCampo['fun_cla_descricao'] = CriaVetTabela('FUNIL DE ATENDIMENTO');
	//$vetCampo['funil'] = CriaVetTabela('FUNIL DE ATENDIMENTO');
	$func_trata_rs = "ftr_grc_entidade_organizacao";
} else {
    $vetCampo['codigo'] = CriaVetTabela('CPF');
    $vetCampo['descricao'] = CriaVetTabela('NOME');
    $vetCampo['gec_es_descricao'] = CriaVetTabela('SITUAÇÃO DO CADASTRO');
    $vetCampo['codigo_siacweb'] = CriaVetTabela('CÓDIGO SAICWEB');
}

$sql = 'select distinct gec_en.*,';

if ($veio == "O") {
    $sql .= ' gec_eo.dap, gec_eo.nirf, gec_eo.rmp, gec_eo.ie_prod_rural, gec_eo.sicab_codigo,';
    $sql .= " concat_ws(' - ', gec_pr.descricao, gec_pr.desc_vl_cmb) as porte,";
}

$sql .= ' gec_en.idt_pessoa_sgc as gec_en_idt_pessoa_sgc, ';
$sql .= ' fun_cla.descricao as fun_cla_descricao, ';


$sql .= ' gec_es.descricao as gec_es_descricao ';
$sql .= ' from ' . db_pir_gec . 'gec_entidade gec_en ';
$sql .= ' inner join ' . db_pir_gec . 'gec_entidade_situacao  gec_es on gec_es.idt  = gec_en.idt_situacao ';
$sql .= ' left  join grc_funil_fase fun_cla  on fun_cla.idt = gec_en.funil_idt_cliente_classificacao';



if ($vetFiltro['atendimento']['valor'] == "S") {
    if ($veio == "O") {
        $sql .= ' inner join grc_atendimento_organizacao atend on atend.cnpj = gec_en.codigo';
		
		
		
		
    } else {
        $sql .= ' inner join grc_atendimento_pessoa atend on atend.cpf = gec_en.codigo';
    }
}

if ($veio == "O") {
    $sql .= ' inner join ' . db_pir_gec . 'gec_entidade_organizacao gec_eo on gec_eo.idt_entidade = gec_en.idt';
    $sql .= ' inner join ' . db_pir_gec . 'gec_organizacao_porte gec_pr on gec_pr.idt = gec_eo.idt_porte';
}

$sql .= ' where gec_en.tipo_entidade = ' . aspa($veio);
$sql .= " and ( natureza='CLI' or natureza='CLI.FOR' )";
$sql .= " and ( reg_situacao='A' )";

if ($veio == "O") {
    if ($vetFiltro['texto_cnpj']['valor'] != "") {
        $sql .= ' and gec_en.codigo like lower(' . aspa($vetFiltro['texto_cnpj']['valor'], '%', '%') . ')';
    }

    switch ($vetFiltro['tipo_registro']['valor']) {
        case 'cnpj':
            $sql .= " and gec_en.tipo_registro = 'OP'";
            break;

        case '7':
        case '13':
            $sql .= " and gec_en.idt_entidade_tipo_emp = ". null($vetFiltro['tipo_registro']['valor']);
            break;
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

    if ($vetFiltro['sicab_codigo']['valor'] != "") {
        $sql .= ' and gec_eo.sicab_codigo = ' . aspa($vetFiltro['sicab_codigo']['valor']);
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

if ($vetFiltro['situacao']['valor'] > 0) {
    $sql .= ' and gec_en.idt_situacao = ' . null($vetFiltro['situacao']['valor']);
}

//echo "'".$sql."'<br />";

