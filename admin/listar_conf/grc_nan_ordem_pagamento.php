<?php
$idCampo = 'idt';
$Tela = "a Ordem de Pagamento";

$TabelaPrinc = "grc_nan_ordem_pagamento";
$AliasPric = "grc_op";
$Entidade = "Ordem de Pagaemento";
$Entidade_p = "Ordens de Pagammento";

$barra_inc_h = "Incluir um Novo Registro de {$Entidade}";
$contlinfim = "Existem #qt {$Entidade_p}.";

$sql = '';
$sql .= ' select distinct idt_ponto_atendimento';
$sql .= ' from grc_nan_estrutura';
$sql .= ' where idt_usuario = '.null($_SESSION[CS]['g_id_usuario']);
$sql .= ' and idt_nan_tipo = 3';
$rs = execsql($sql);

if ($rs->rows == 0) {
    $barra_inc_ap = false;
    $barra_alt_ap = false;
    $barra_exc_ap = false;
}

$Filtro = Array();
$Filtro['rs'] = 'Texto';
$Filtro['id'] = 'texto';
$Filtro['js_tam'] = '0';
$Filtro['nome'] = 'Texto';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['texto'] = $Filtro;


$vetCampo['gec_cc_codigo'] = CriaVetTabela('Número<br />Contrato');
$vetCampo['gec_e_executora'] = CriaVetTabela('Empresa');
$vetCampo['sca_nan_ur'] = CriaVetTabela('Unidade Regional');
$vetCampo['protocolo'] = CriaVetTabela('Protocolo<br />da Ordem');
$vetCampo['data_inicio'] = CriaVetTabela('Período<br />Inicio', 'data');
$vetCampo['data_fim'] = CriaVetTabela('Período<br />Fim', 'data');
$vetCampo['qtd_total_visitas'] = CriaVetTabela('Total de Visitas');
$vetCampo['valor_total'] = CriaVetTabela('Valor R$<br />Total', 'decimal');
$vetCampo['situacao'] = CriaVetTabela('Status', 'func_trata_dado', ftd_grc_nan_ordem_pagamento);

$sql = '';
$sql .= " select {$AliasPric}.*, ";
$sql .= ' gec_cc.codigo as gec_cc_codigo, ';
$sql .= ' gec_e.descricao as gec_e_executora, ';
$sql .= ' sca_nan.descricao as sca_nan_ur,';
$sql .= ' afp.situacao_reg, afp.gfi_situacao';
$sql .= " from  {$TabelaPrinc} as {$AliasPric}";
$sql .= " inner join ".db_pir_gec."gec_contratar_credenciado gec_cc on gec_cc.idt = {$AliasPric}.idt_contrato";
$sql .= " inner join ".db_pir_gec."gec_entidade gec_e on gec_e.idt                = gec_cc.idt_organizacao";
$sql .= " inner join ".db_pir."sca_organizacao_secao sca_nan on sca_nan.idt       = gec_cc.nan_idt_unidade_regional";
$sql .= " left outer join ".db_pir_pfo."pfo_af_processo afp on afp.idmov = {$AliasPric}.rm_idmov";
$sql .= " where gec_cc.nan_indicador = ".aspa('S');

if ($barra_inc_ap) {
    $sql .= " and {$AliasPric}.idt_cadastrante = ".null($_SESSION[CS]['g_id_usuario']);
}

if ($vetFiltro['texto']['valor'] != "") {
    $sql .= ' and ';
    $sql .= ' ( ';
    $sql .= '  lower('.$AliasPric.'.protocolo)      like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= ' or lower(gec_cc.codigo) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= ' or lower(gec_e.descricao) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= ' or lower(sca_nan.descricao) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= ' ) ';
}