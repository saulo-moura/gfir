<style>
    fieldset.class_frame_f {
        background:#0000ff;
        border:1px solid #FFFFFF;
    }

    div.class_titulo_f {
        background: #0000ff;
        border    : 1px solid #ffffff;
        color     : #FFFFFF;
        text-align: left;
        padding-top:10px;
    }

    div.class_titulo_f span {
        padding-left:20px;
        text-align: left;
    }

    fieldset.class_frame_p {
        background:#FFFFFF;
        border:0px solid #FFFFFF;
    }

    div.class_titulo_p {
        background: #2F66B8;
        text-align: left;
        border    : 0px solid #2C3E50;
        color     : #FFFFFF;
        text-align: left;
        font-size : 16px;
    }

    div.class_titulo_p span {
        padding:10px;
        font-size:18px;
    }

    div.class_titulo_p_barra {
        text-align: left;
        background: #c4c9cd;
        border    : none;
        color     : #FFFFFF;
        font-weight: bold;
        line-height: 12px;
        margin: 0;
        padding: 3px;
        padding-left: 20px;
    }

    fieldset.class_frame {
        background:#FFFFFF;
        border:0px solid #2C3E50;
    }

    div.class_titulo {
        text-align: left;
        background: #FFFFFF;
        color     : #000000;
        border    : 0px solid #2C3E50;
        margin-top: 20px;
        text-align:center;		
    }

    div.class_titulo span {
        padding-left:10px;
    }

    div.class_titulo_c {
        text-align: center;
        background: #FFFFFF;
        color     : #FFFFFF;
        border    : 0px solid #2C3E50;
    }

    div.class_titulo_c span {
        padding-left:10px;
    }

    .TextoFixo {
        font-size:12px;
        text-align:left;
        border:0px;
        background:#ECF0F1;
        font-weight:normal;
        font-family: Lato Regular, Calibri, Arial,  Helvetica, sans-serif;
        font-style: normal;
        word-spacing: 0px;
        padding-top:5px;
    }

    td {
        padding-top:0px;
    }

    .Barra .Botao {
        display: none;
    }

    .frm_hidden {
        display: none;
    }
</style>
<?php
$sql = '';
$sql .= ' select op.*, cc.nan_idt_unidade_regional';
$sql .= ' from grc_nan_ordem_pagamento op';
$sql .= ' left outer join '.db_pir_gec.'gec_contratar_credenciado cc on cc.idt = op.idt_contrato';
$sql .= ' where op.idt = '.null($_GET['id']);
$rs = execsql($sql);
$row = $rs->data[0];

if ($rs->rows == 0) {
    unset($_GET['idt_pendencia']);
}

$sql = '';
$sql .= ' select idt';
$sql .= ' from grc_atendimento_pendencia';
$sql .= ' where idt = '.null($_GET['idt_pendencia']);
$sql .= ' and idt_responsavel_solucao = '.null($_SESSION[CS]['g_id_usuario']);
$sql .= " and ativo = 'S'";
$sql .= " and (tipo = 'NAN - Ordem de Pagamento' or tipo = 'Pagamento a Credenciado')";
$sql .= whereAtendimentoPendencia();
$rs = execsql($sql);

if ($rs->rows == 0) {
    unset($_GET['idt_pendencia']);
}

$idt_cadastrante = $row['idt_cadastrante'];

if ($idt_cadastrante == '') {
    $idt_cadastrante = $_SESSION[CS]['g_id_usuario'];
}

if ($acao != 'con') {
    if ($_GET['idt_pendencia'] != '') {
        if ($row['situacao'] != 'GE') {
            $acao_alt_con = 'S';
        }
    } else if ($row['situacao'] != 'GE' && $row['situacao'] != '') {
        if ($row['situacao'] == 'AP') {
            alert('Não pode alterar esta Ordem de Pagamento, pois ela já foi Aprovação!');
        } else {
            alert('Não pode alterar esta Ordem de Pagamento, pois ela esta em processo de Aprovação!');
        }

        $acao = 'con';
        $_GET['acao'] = $acao;
    }
}

if ($_GET['idt_pendencia'] == '' && $row['situacao'] == 'GE') {
    $sql = '';
    $sql .= ' select idt';
    $sql .= ' from grc_atendimento_pendencia';
    $sql .= ' where idt_nan_ordem_pagamento  = '.null($_GET['id']);
    $sql .= " and tipo = 'NAN - Ordem de Pagamento'";
    $sql .= " and ativo = 'S'";
    $sql .= whereAtendimentoPendencia();
    $rs = execsql($sql);
    $_GET['idt_pendencia'] = $rs->data[0][0];
}

$sql = '';
$sql .= ' select distinct idt_ponto_atendimento';
$sql .= ' from grc_nan_estrutura';
$sql .= ' where idt_usuario = '.null($idt_cadastrante);
$sql .= ' and idt_nan_tipo = 3';
$rs = execsql($sql);

if ($_GET['idt_pendencia'] == '' && $rs->rows == 0 && $acao != 'con') {
    alert('Não pode gerar ou alterar uma Ordem de Pagamento, pois não é um Gestor Local!');
    $acao = 'con';
    $_GET['acao'] = $acao;
}

$vetPA = Array();

foreach ($rs->data as $rowt) {
    $vetPA[] = $rowt['idt_ponto_atendimento'];
}

$tabela = 'grc_nan_ordem_pagamento';
$id = 'idt';

$onSubmitDep = 'grc_nan_ordem_pagamento_dep()';
$bt_alterar_aviso = ' ';

$bt_exportar = true;
$bt_exportar_desc = 'Lista Faturamento';
$bt_exportar_tit = 'Lista Faturamento';

$class_frame_f = "class_frame_f";
$class_titulo_f = "class_titulo_f";

$class_frame_p = "class_frame_p";
$class_titulo_p = "class_titulo_p";

$class_frame = "class_frame";
$class_titulo = "class_titulo";
$titulo_na_linha = false;

$vetFrm = Array();

$vetParametros = Array(
    'situacao_padrao' => true,
);

if ($acao == 'inc') {
    $vetFrm[] = Frame("<span>NOVA ORDEM DE PAGAMENTO</span>", '', $class_frame_f, $class_titulo_f, $titulo_na_linha, $vetParametros);
} else {
    $vetFrm[] = Frame("<span>ORDEM DE PAGAMENTO</span>", '', $class_frame_f, $class_titulo_f, $titulo_na_linha, $vetParametros);
}

$vetParametros = Array(
    'codigo_frm' => 'parte01',
    'controle_fecha' => 'A',
);
$vetFrm[] = Frame('<span>IDENTIFICAÇÃO</span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);

$corbloq = "#FFFF80";
$jst = " readonly='true' style='background:".$corbloq."' ";
$vetCampo['protocolo'] = objTexto('protocolo', 'Protocolo', true, 12, 45, $jst);
$vetCampo['descricao'] = objTexto('descricao', 'Título', false, 40, 120);

$maxlength = 700;
$style = "width:700px;";
$js = "";
$vetCampo['objeto'] = objTextArea('objeto', 'Observação', false, $maxlength, $style, $js);

$sql = '';
$sql .= ' select idt';
$sql .= ' from grc_atendimento';
$sql .= ' where idt_nan_ordem_pagamento = '.null($_GET['id']);
$rs = execsql($sql);

if ($rs->rows == 0 && count($vetPA) > 0) {
    $sql = '';
    $sql .= ' select idt, codigo, descricao';
    $sql .= ' from '.db_pir_gec.'gec_contratar_credenciado';
    $sql .= " where nan_indicador = 'S'";
    $sql .= ' and nan_idt_unidade_regional in ('.implode(', ', $vetPA).')';
    $sql .= ' order by codigo ';
    $vetCampo['idt_contrato'] = objCmbBanco('idt_contrato', 'Contrato', true, $sql, ' ', 'width:100%;');
} else {
    $_GET['idt_contrato'] = $row['idt_contrato'];
    $vetCampo['idt_contrato'] = objFixoBanco('idt_contrato', 'Contrato', db_pir_gec.'gec_contratar_credenciado', 'idt', 'codigo, descricao', 99);
}

$vetCampo['sca_nan_ur'] = objTextoFixo('sca_nan_ur', 'Unidade Regional (UR)');
$vetCampo['empresa'] = objTextoFixo('empresa', 'Empresa');

$vetCampo['situacao'] = objFixoVetor('situacao', 'Status', True, $vetNanOrdemPagSituacao, ' ', '', '', '', 'GE');

$vetCampo['acao_nan'] = objHidden('acao_nan', '');

$vetCampo['data_inicio'] = objData('data_inicio', 'Periodo - Início', true, '', '', 'S');
$vetCampo['data_fim'] = objData('data_fim', 'Periodo - Final', true, '', '', 'S');

$js = " readonly='true' style='background:#FFFFE1;' ";
$vetCampo['data_cadastrante'] = objDataHora('data_cadastrante', 'Data de Criação', false, $js);

$sql = "select id_usuario, nome_completo from plu_usuario order by nome_completo";
$js_hm = " disabled  ";
$style = " width:380px; background:#FFFFE1;  ";
$vetCampo['idt_cadastrante'] = objCmbBanco('idt_cadastrante', 'Responsavel', false, $sql, '', $style, $js_hm);

$corbloq = "#FFFF80";
$jst = " readonly='true' style='background:".$corbloq."' ";
$vetCampo['qtd_total_visitas'] = objInteiro('qtd_total_visitas', 'Quantidade Total Visitas', false, 20, '', '', $jst);
$vetCampo['qtd_visitas1'] = objInteiro('qtd_visitas1', 'Quantidade Primeira Visita', false, 20, '', '', $jst);
$vetCampo['qtd_visitas2'] = objInteiro('qtd_visitas2', 'Quantidade Segunda Visita', false, 20, '', '', $jst);

$corbloq = "#FFFF80";
$jst = " readonly='true' style='background:{$corbloq}; ' ";
$vetCampo['valor_total'] = objDecimal('valor_total', 'Valor Total (R$)', false, 15, 15, 2, $jst, 0);

$vetCampo['botao_ordem_pagamento'] = objInclude('botao_ordem_pagamento', 'cadastro_conf/botao_ordem_pagamento.php');

MesclarCol($vetCampo['situacao'], 3);
MesclarCol($vetCampo['objeto'], 3);
MesclarCol($vetCampo['idt_contrato'], 3);
MesclarCol($vetCampo['sca_nan_ur'], 3);
MesclarCol($vetCampo['empresa'], 3);
MesclarCol($vetCampo['acao_nan'], 3);

$vetParametros = Array(
    'codigo_pai' => 'parte01',
);

$vetFrm[] = Frame('', Array(
    Array($vetCampo['protocolo'], '', $vetCampo['situacao']),
    Array($vetCampo['idt_contrato']),
    Array($vetCampo['sca_nan_ur']),
    Array($vetCampo['empresa']),
    Array($vetCampo['objeto']),
    Array($vetCampo['data_inicio'], '', $vetCampo['data_fim']),
    Array($vetCampo['acao_nan']),
        ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);

$vetFrm[] = Frame('', Array(
    Array($vetCampo['botao_ordem_pagamento']),
        ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);

if ($_GET['id'] == 0) {
    $vetFrm[] = Frame('', Array(
        Array($vetCampo['qtd_total_visitas'], '', $vetCampo['qtd_visitas1'], '', $vetCampo['qtd_visitas2']),
        Array($vetCampo['valor_total'], '', $vetCampo['idt_cadastrante'], '', $vetCampo['data_cadastrante']),
            ), $class_frame.' frm_hidden', $class_titulo, $titulo_na_linha, $vetParametros);
} else {
    $vetParametros = Array(
        'codigo_frm' => 'parte02',
        'controle_fecha' => 'A',
    );
    $vetFrm[] = Frame('<span> QUANTITATIVOS E VALORES (Calculados pelo Sistema)</span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);

    $vetParametros = Array(
        'codigo_pai' => 'parte02',
    );

    $vetFrm[] = Frame('', Array(
        Array($vetCampo['qtd_visitas1'], '', $vetCampo['qtd_visitas2'], '', $vetCampo['qtd_total_visitas'], '', $vetCampo['valor_total']),
            ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);


    $vetFrm[] = Frame('', Array(
        Array($vetCampo['idt_cadastrante'], '', $vetCampo['data_cadastrante']),
            ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);

    $sql = '';
    $sql .= ' select idt_pfo_af_processo, idt_usuario, tipo, solucao';
    $sql .= ' from grc_atendimento_pendencia';
    $sql .= ' where idt = '.null($_GET['idt_pendencia']);
    $sql .= ' and idt_responsavel_solucao = '.null($_SESSION[CS]['g_id_usuario']);
    $sql .= " and ativo = 'S'";
    $sql .= " and (tipo = 'NAN - Ordem de Pagamento' or tipo = 'Pagamento a Credenciado')";
    $sql .= whereAtendimentoPendencia();
    $rst = execsql($sql);

    if ($rst->rows > 0) {
        $rowPEN = $rst->data[0];

        switch ($rowPEN['tipo']) {
            case 'Pagamento a Credenciado':
                if ($rowPEN['idt_pfo_af_processo'] != '') {
                    $pfo_idt_usuario = IdUsuarioPIR($rowPEN['idt_usuario'], db_pir_grc, db_pir_pfo);

                    $sql = '';
                    $sql .= ' select afp.obs_validacao, afp.situacao_reg';
                    $sql .= ' from '.db_pir_pfo.'pfo_af_processo afp';
                    $sql .= ' where afp.idt = '.null($rowPEN['idt_pfo_af_processo']);
                    $rsPFO = execsql($sql);
                    $rowPFO = $rsPFO->data[0];

                    $vetParametros = Array(
                        'codigo_frm' => 'pfo',
                        'controle_fecha' => false,
                    );

                    $vetFrm[] = Frame('<span>Atestado em Processo de Pagamento</span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);

                    $vetParametros = Array(
                        'codigo_pai' => 'pfo',
                        'width' => '100%',
                    );

                    $vetCampoLC = Array();
                    $vetCampoLC['arquivo'] = CriaVetTabela('Arquivo', 'func_trata_dado', fnc_grc_evento_pfo_af_processo_item);
                    $vetCampoLC['gec_d_descricao'] = CriaVetTabela('Documento');
                    $vetCampoLC['data_registro'] = CriaVetTabela('Data Registro', 'data');
                    $vetCampoLC['data_vencimento'] = CriaVetTabela('Validade', 'data');
                    $vetCampoLC['doc_obr'] = CriaVetTabela('Obrigatório?', 'descDominio', $vetSimNao);
                    $vetCampoLC['situacao'] = CriaVetTabela('Situacão', 'func_trata_dado', fnc_grc_evento_pfo_af_processo_item);
                    $vetCampoLC['dt_validacao'] = CriaVetTabela('Data Validação', 'data');
                    $vetCampoLC['nome_completo'] = CriaVetTabela('Validador');

                    $titulo = 'Documentos do Processo';

                    $TabelaPrinc = "pfo_af_processo_item";
                    $AliasPric = "pfo_afpi";
                    $Entidade = "Documento do Processo";
                    $Entidade_p = "Documentos do Processo";
                    $CampoPricPai = "idt_processo";

                    $orderby = "gec_d.descricao ";

                    $sql = "select {$AliasPric}.*, ";
                    $sql .= ' u.nome_completo,';
                    $sql .= ' gec_d.tipo_documento,';
                    $sql .= ' gec_d.obrigatorio as doc_obr,';
                    $sql .= " gec_d.descricao as gec_d_descricao";
                    $sql .= " from ".db_pir_pfo."{$TabelaPrinc} {$AliasPric}  ";
                    $sql .= " inner join ".db_pir_gec."gec_documento gec_d on  gec_d.idt = {$AliasPric}.idt_documento ";
                    $sql .= " left outer join ".db_pir_pfo."plu_usuario u on  u.id_usuario = {$AliasPric}.idt_validador ";
                    $sql .= " where {$AliasPric}".'.idt_processo = '.null($rowPEN['idt_pfo_af_processo']);

                    if ($rowPFO['situacao_reg'] != 'ED') {
                        $sql .= " and (gec_d.tipo_documento is null or gec_d.tipo_documento <> 'NF')";
                    }

                    $sql .= " order by {$orderby}";

                    $vetPadrao = Array(
                        'barra_inc_ap' => false,
                        'barra_alt_ap' => true,
                        'barra_con_ap' => true,
                        'barra_exc_ap' => false,
                    );

                    $vetCampoPFO['pfo_af_processo_item'] = objListarConf('pfo_af_processo_item', 'idt', $vetCampoLC, $sql, $titulo, true, $vetPadrao);
                    $vetCampoPFO['pfo_obs_validacao'] = objTextArea('pfo_obs_validacao', 'Observação', false, 5000, '', '', false, $rowPFO['obs_validacao']);
                    $vetCampoPFO['idt_pfo_af_processo'] = objHidden('idt_pfo_af_processo', $rowPEN['idt_pfo_af_processo'], '', '', false);
                    $vetCampoPFO['pfo_idt_usuario'] = objHidden('pfo_idt_usuario', $pfo_idt_usuario, '', '', false);

                    $vetFrm[] = Frame('', Array(
                        Array($vetCampoPFO['pfo_af_processo_item']),
                        Array($vetCampoPFO['pfo_obs_validacao']),
                        Array($vetCampoPFO['idt_pfo_af_processo']),
                        Array($vetCampoPFO['pfo_idt_usuario']),
                            ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);
                }

                unset($vetParametros['width']);
                break;

            case 'NAN - Ordem de Pagamento':
                if ($rowPEN['solucao'] == '') {
                    $maxlength = 5000;
                    $style = "";
                    $js = "";
                    $vetCampo['solucao_pendencia'] = objTextArea('solucao_pendencia', 'Motivo da Devolução', false, $maxlength, $style, $js, false, $rowPEN['solucao']);
                } else {
                    $vetCampo['solucao_pendencia'] = objTextoFixo('solucao_pendencia', 'Motivo da Devolução', '', false, false, $rowPEN['solucao']);
                }

                $vetParametros['width'] = '100%';

                $vetFrm[] = Frame('', Array(
                    Array($vetCampo['solucao_pendencia']),
                        ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);

                unset($vetParametros['width']);
                break;
        }

        $vetCampo['botao_ordem_pagamento_ap'] = objInclude('botao_ordem_pagamento_ap', 'cadastro_conf/botao_ordem_pagamento_ap.php');

        $vetFrm[] = Frame('', Array(
            Array($vetCampo['botao_ordem_pagamento_ap']),
                ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);
    } else {
        $vetCampo['botao_ordem_pagamento_ap'] = objInclude('botao_ordem_pagamento_ap', 'cadastro_conf/botao_ordem_pagamento_ap.php');

        $vetFrm[] = Frame('', Array(
            Array($vetCampo['botao_ordem_pagamento_ap']),
                ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);
    }

    $vetParametros = Array(
        'codigo_frm' => 'parte03',
        'controle_fecha' => 'A',
    );
    $vetFrm[] = Frame('<span> ATENDIMENTOS - VISITAS</span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);

    $vetCampoLC = Array();
    $vetCampoLC['projeto_acao'] = CriaVetTabela('Projeto / Ação');
    $vetCampoLC['data'] = CriaVetTabela('Data do Atendimento', 'data');
    $vetCampoLC['agente'] = CriaVetTabela('AOE');
    $vetCampoLC['tutor'] = CriaVetTabela('Tutor');
    $vetCampoLC['representante_cliente'] = CriaVetTabela('Representante / Cliente');
    $vetCampoLC['horas_atendimento'] = CriaVetTabela('Qtd. Horas<br />do Atendimento');
    $vetCampoLC['protocolo'] = CriaVetTabela('Protocolo');

    $titulo = 'Atendimentos - Visitas';

    $sql = '';
    $sql .= ' select grc_a.*,';
    $sql .= ' concat_ws("<br >", grc_ap.nome, gec_ec.descricao) as representante_cliente, ';
    $sql .= ' concat_ws("<br >", p.descricao, pa.descricao) as projeto_acao, ';
    $sql .= ' plu_usut.nome_completo as tutor, ';
    $sql .= ' plu_usuc.nome_completo as agente ';
    $sql .= ' from grc_atendimento grc_a ';
    $sql .= ' inner join grc_projeto p on p.idt = grc_a.idt_projeto';
    $sql .= ' inner join grc_projeto_acao pa on pa.idt = grc_a.idt_projeto_acao';
    $sql .= ' inner join grc_nan_grupo_atendimento grc_nga on grc_nga.idt = grc_a.idt_grupo_atendimento ';
    $sql .= ' left join '.db_pir_gec.'gec_entidade gec_ec on gec_ec.idt = grc_nga.idt_organizacao ';
    $sql .= " left join grc_atendimento_pessoa grc_ap on grc_ap.idt_atendimento = grc_a.idt and grc_ap.tipo_relacao = 'L'";
    $sql .= ' left join plu_usuario plu_usut on plu_usut.id_usuario = grc_a.idt_nan_tutor ';
    $sql .= ' left join plu_usuario plu_usuc on plu_usuc.id_usuario = grc_a.idt_consultor ';
    $sql .= ' where grc_a.idt_nan_ordem_pagamento = $vlID ';
    $sql .= ' order by concat_ws("<br >", p.descricao, pa.descricao), grc_a.data, plu_usuc.nome_completo';

    $vetParametros = Array(
        'barra_inc_ap' => false,
        'barra_alt_ap' => false,
        'barra_con_ap' => true,
        'barra_exc_ap' => false,
    );

    if ($acao == 'alt' && $acao_alt_con != 'S') {
        $vetParametros['func_botao_per'] = grc_nan_ordem_pagamento_at_per;
    }

    $vetCampo['grc_nan_visita_1'] = objListarConf('grc_nan_visita_1', 'idt', $vetCampoLC, $sql, $titulo, false, $vetParametros);
    $vetCampo['grc_nan_visita_1_dep'] = objInclude('grc_nan_visita_1_dep', 'cadastro_conf/grc_nan_ordem_pagamento_dep.php');

    $vetParametros = Array(
        'codigo_pai' => 'parte03',
        'width' => '100%',
    );
    $vetFrm[] = Frame('', Array(
        Array($vetCampo['grc_nan_visita_1_dep']),
        Array($vetCampo['grc_nan_visita_1']),
            ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);
}

$vetCad[] = $vetFrm;

switch ($row['situacao']) {
    case 'GE':
        $idt_nan_tipo_orcada = 3;
        break;

    case 'AP':
        $idt_nan_tipo_orcada = 0;
        break;

    default:
        $idt_nan_tipo_orcada = substr($row['situacao'], 1);
        break;
}

$nan_idt_unidade_regional_orcada = $row['nan_idt_unidade_regional'];

$sql = '';
$sql .= ' select max(vl_aprova_ordem) as tot';
$sql .= ' from grc_nan_estrutura';
$sql .= ' where idt_usuario = '.null($_SESSION[CS]['g_id_usuario']);
$sql .= ' and idt_nan_tipo = '.null($idt_nan_tipo_orcada);

if ($idt_nan_tipo_orcada == 10 || $idt_nan_tipo_orcada == 3) {
    $sql .= ' and idt_ponto_atendimento = '.null($nan_idt_unidade_regional_orcada);
} else {
    $sql .= ' and idt_ponto_atendimento = 6';
}

$rsOC = execsql($sql);
$vl_aprova_ordem = $rsOC->data[0][0];

if ($vl_aprova_ordem == '') {
    $vl_aprova_ordem = 0;
}
?>
<script type="text/javascript">
    var acao_nan = '';
    var idt_pfo_af_processo = '<?php echo $rowPEN['idt_pfo_af_processo']; ?>';

    $(document).ready(function () {
        ajustaBtAP();

        $('#idt_contrato').change(function () {
            processando();

            $.ajax({
                dataType: 'json',
                type: 'POST',
                url: ajax_sistema + '?tipo=dados_contrato',
                data: {
                    cas: conteudo_abrir_sistema,
                    idt: $('#idt_contrato').val()
                },
                success: function (response) {
                    $('#sca_nan_ur').val(url_decode(response.unidade));
                    $('#sca_nan_ur_fix').html(url_decode(response.unidade));

                    var empresa = url_decode(response.cnpj) + ' - ' + url_decode(response.empresa);
                    $('#empresa').val(empresa);
                    $('#empresa_fix').html(empresa);

                    if (response.erro != '') {
                        alert(url_decode(response.erro));
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert('Erro no ajax no: ' + textStatus + ' - ' + errorThrown);
                },
                async: false
            });

            $('#dialog-processando').remove();
        }).change();

        setTimeout(function () {
            $('textarea#solucao_pendencia').removeProp("disabled").removeClass("campo_disabled");
        }, 100);

        if (idt_pfo_af_processo != '') {
            $('#pfo_af_processo_item_desc td[data-campo=situacao] > :checkbox').click(function () {
                var lbl = 'Pendente';

                if ($(this).prop('checked')) {
                    lbl = 'Conferido';
                }

                $(this).parent().find('label').html(lbl);
            });

            setTimeout(function () {
                $('#pfo_obs_validacao, #pfo_af_processo_item_desc td[data-campo=situacao] > input').removeProp("disabled").removeClass("campo_disabled");
            }, 100);
        }
    });

    function grc_nan_ordem_pagamento_dep() {
        $('#acao_nan').val(acao_nan);
        return true;
    }

    function ajustaBtAP() {
        $('#btAprovar').hide();
        $('#btSincRM').hide();

        var valor_total = str2float($('#valor_total').val());
        var vl_aprova_ordem = <?php echo $vl_aprova_ordem; ?>;

        if (valor_total <= vl_aprova_ordem) {
            $('#btSincRM').show();
        } else {
            $('#btAprovar').show();
        }
    }

    function parIniListarConf_grc_nan_visita_1(idCad, acao, id) {
        var par = '';

        par += '?acao=' + acao;
        par += '&pesquisa=S';
        par += '&prefixo=inc';
        par += '&menu=grc_nan_visita_1';
        par += '&id=' + id;

        btCloseShowPopWin = true;

        return par;
    }

    function grc_nan_ordem_pagamento_at_per(idt, idt_pag, mensagem, session_cod) {
        if (confirm(mensagem)) {
            $.ajax({
                dataType: 'json',
                type: 'POST',
                url: 'ajax_atendimento.php?tipo=grc_nan_ordem_pagamento_at_per',
                data: {
                    cas: conteudo_abrir_sistema,
                    idt_pag: idt_pag,
                    idt: idt
                },
                success: function (response) {
                    $('#qtd_total_visitas').val(response.qtd_total_visitas);
                    $('#qtd_visitas1').val(response.qtd_visitas1);
                    $('#qtd_visitas2').val(response.qtd_visitas2);
                    $('#valor_total').val(response.valor_total);
                    ajustaBtAP();

                    btFechaCTC(session_cod);

                    if (response.erro != '') {
                        alert(url_decode(response.erro));
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert('Erro no ajax no: ' + textStatus + ' - ' + errorThrown);
                },
                async: false
            });
        }

        return false;
    }
</script>