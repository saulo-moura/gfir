<?php
$_GET['veio'] = 'SG';

$sql = '';
$sql .= ' select idt_evento';
$sql .= ' from grc_atendimento_evento';
$sql .= ' where idt = ' . null($_GET['id']);
$rs = execsql($sql);
$_GET['idCad'] = $rs->data[0][0];

//Calcula data do evento SGTEC
$sql = "select grc_e.entrega_prazo_max";
$sql .= ' from grc_evento grc_e';
$sql .= " where grc_e.idt  = " . null($_GET['idCad']);
$rs = execsql($sql);
$rowe = $rs->data[0];

$dt_previsao_inicial = getdata(false, true);

if (is_numeric($vetConf['evento_sg_qtd_inicio'])) {
    $dt_previsao_inicial = Calendario::Intervalo_Util($dt_previsao_inicial, $vetConf['evento_sg_qtd_inicio']);
}

$sql = '';
$sql .= " select ord_lste.data_conclusao_servico_cotacao";
$sql .= " from " . db_pir_gec . "gec_contratacao_credenciado_ordem_lista_endidade ord_lste";
$sql .= " inner join " . db_pir_gec . "gec_contratacao_credenciado_ordem_lista ord_lst on ord_lst.idt = ord_lste.idt_gec_contratacao_credenciado_ordem_lista";
$sql .= " inner join " . db_pir_gec . "gec_contratacao_credenciado_ordem ord on ord.idt = ord_lst.idt_gec_contratacao_credenciado_ordem";
$sql .= " where ord_lst.ativo = 'S'";
$sql .= " and ord_lst.idt_organizacao = ord_lste.idt_organizacao ";
$sql .= ' and ord.idt_evento = ' . null($_GET['idCad']);
$sql .= " and ord.ativo = 'S'";
$rs = execsql($sql);
$dt_previsao_fim = $rs->data[0][0];

if ($dt_previsao_fim == '') {
    $dt_previsao_fim = $dt_previsao_inicial;

    if ($rowe['entrega_prazo_max'] != '') {
        $dt_previsao_fim = Calendario::Intervalo_Corrido($dt_previsao_fim, $rowe['entrega_prazo_max']);
    }
} else {
    $dt_previsao_fim = trata_data($dt_previsao_fim);
}

$sql = 'update grc_evento set ';
$sql .= ' dt_previsao_inicial = ' . aspa(trata_data($dt_previsao_inicial)) . ', ';
$sql .= ' dt_previsao_fim = ' . aspa(trata_data($dt_previsao_fim));
$sql .= ' where idt = ' . null($_GET['idCad']);
execsql($sql);

$sql = '';
$sql .= ' select p.idt as idt_atendimento_pessoa';
$sql .= ' from grc_atendimento a';
$sql .= ' inner join grc_atendimento_pessoa p on p.idt_atendimento = a.idt';
$sql .= ' where a.idt_evento = ' . null($_GET['idCad']);
$rs = execsql($sql);

$_GET['id'] = $rs->data[0][0];

require_once 'cadastro_export\grc_evento_participante.php';
