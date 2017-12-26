<?php
$ordFiltro = false;
$idCampo = 'idt';
$Tela = "a Ordem de Pagamento NAN";

$tipoidentificacao = 'N';
$tipofiltro = 'S';
$comfiltro = 'A';
$comidentificacao = 'F';

//$bt_print = false;

$barra_inc_ap = false;
$barra_alt_ap = false;
$barra_con_ap = false;
$barra_exc_ap = false;
$barra_fec_ap = false;

$comcontrole = 0;

$sql = '';
$sql .= ' select idt, descricao';
$sql .= ' from '.db_pir.'sca_organizacao_secao';
$sql .= " where posto_atendimento <> 'S' ";
$sql .= ' order by classificacao';
$Filtro = Array();
$Filtro['rs'] = execsql($sql);
$Filtro['id'] = 'f_idt_unidade';
$Filtro['id_select'] = 'idt';
$Filtro['nome'] = 'Unidade';
$Filtro['LinhaUm'] = ' ';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['f_idt_unidade'] = $Filtro;

$Filtro = Array();
$Filtro['rs'] = $vetSimNao;
$Filtro['id'] = 'f_rm';
$Filtro['nome'] = 'Está no RM';
$Filtro['LinhaUm'] = '<< Todos >>';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['f_rm'] = $Filtro;

$Filtro = Array();
$Filtro['rs'] = $vetAFProcessoSit;
$Filtro['id'] = 'f_situacao_reg';
$Filtro['nome'] = 'Situação do Processo';
$Filtro['LinhaUm'] = ' ';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['f_situacao_reg'] = $Filtro;

$Filtro = Array();
$Filtro['rs'] = 'Texto';
$Filtro['id'] = 'f_texto';
$Filtro['js_tam'] = '0';
$Filtro['nome'] = 'Texto';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['f_texto'] = $Filtro;

$vetCampo['gec_cc_codigo'] = CriaVetTabela('Número Contrato');
$vetCampo['gec_e_executora'] = CriaVetTabela('Empresa');
$vetCampo['sca_nan_ur'] = CriaVetTabela('Unidade Regional');
$vetCampo['protocolo'] = CriaVetTabela('Protocolo da Ordem');
$vetCampo['data_inicio'] = CriaVetTabela('Período Inicio', 'data');
$vetCampo['data_fim'] = CriaVetTabela('Período Fim', 'data');
$vetCampo['qtd_total_visitas'] = CriaVetTabela('Total de Visitas');
$vetCampo['valor_total'] = CriaVetTabela('Valor R$ Total', 'decimal');
$vetCampo['rm_idmov'] = CriaVetTabela('RM');
$vetCampo['situacao'] = CriaVetTabela('Portal', 'func_trata_dado', ftd_grc_nan_ordem_pagamento);

$sql = "select op.*, ";
$sql .= ' gec_cc.codigo as gec_cc_codigo, ';
$sql .= ' gec_e.descricao as gec_e_executora, ';
$sql .= ' sca_nan.descricao as sca_nan_ur,';
$sql .= ' afp.situacao_reg, afp.gfi_situacao';
$sql .= " from grc_nan_ordem_pagamento op";
$sql .= " inner join ".db_pir_gec."gec_contratar_credenciado gec_cc on gec_cc.idt = op.idt_contrato";
$sql .= " inner join ".db_pir_gec."gec_entidade gec_e on gec_e.idt                = gec_cc.idt_organizacao";
$sql .= " inner join ".db_pir."sca_organizacao_secao sca_nan on sca_nan.idt       = gec_cc.nan_idt_unidade_regional";
$sql .= " left outer join ".db_pir_pfo."pfo_af_processo afp on afp.idmov = op.rm_idmov";
$sql .= " where 1 = 1";

if ($vetFiltro['f_idt_unidade']['valor'] != "" && $vetFiltro['f_idt_unidade']['valor'] != "0" && $vetFiltro['f_idt_unidade']['valor'] != "-1") {
    $sql .= ' and op.idt_unidade = '.null($vetFiltro['f_idt_unidade']['valor']);
}

if ($vetFiltro['f_rm']['valor'] == "S") {
    $sql .= ' and op.rm_idmov is not null';
} else if ($vetFiltro['f_rm']['valor'] == "N") {
    $sql .= ' and op.rm_idmov is null';
}

if ($vetFiltro['f_situacao_reg']['valor'] != "" && $vetFiltro['f_situacao_reg']['valor'] != "0" && $vetFiltro['f_situacao_reg']['valor'] != "-1") {
    $sql .= ' and afp.situacao_reg = '.aspa($vetFiltro['f_situacao_reg']['valor']);
}

if ($vetFiltro['f_texto']['valor'] != "") {
    $sql .= ' and ';
    $sql .= ' ( ';
    $sql .= '  lower(op.protocolo) like lower('.aspa($vetFiltro['f_texto']['valor'], '%', '%').')';
    $sql .= ' or lower(gec_cc.codigo) like lower('.aspa($vetFiltro['f_texto']['valor'], '%', '%').')';
    $sql .= ' or lower(gec_e.descricao) like lower('.aspa($vetFiltro['f_texto']['valor'], '%', '%').')';
    $sql .= ' or lower(sca_nan.descricao) like lower('.aspa($vetFiltro['f_texto']['valor'], '%', '%').')';
    $sql .= ' ) ';
}
