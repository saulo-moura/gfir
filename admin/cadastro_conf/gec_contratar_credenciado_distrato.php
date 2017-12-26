<style>
    fieldset.class_frame_p {
        background:#FFFFFF;
        border:none;
    }

    div.class_titulo_p {
        background: #2F66B8;
        text-align: left;
        border    : none;
        color     : #FFFFFF;
        color     : #FFFFFF;
        text-align: left;
        height    : 20px;
        font-size : 12px;
        padding-top:5px;
    }

    div.class_titulo_p span {
        padding:10px;
        text-align: left;
    }

    fieldset.class_frame {
        background:#FFFFFF;
        border:none;
    }

    div.class_titulo {
        background: #ABBBBF;
        border    : 1px solid #14ADCC;
        color     : #FFFFFF;
        text-align: left;
    }

    div.class_titulo span {
        padding-left:10px;
    }

    #gec_contratacao_credenciado_ordem_entrega_desc td.Registro[data-campo="vl_executado"] {
        width: 125px;
        text-align: right;
        padding-left: 10px;
        padding-right: 10px;
    }

    #gec_contratacao_credenciado_ordem_entrega_desc td.Registro[data-campo="vl_executado"] input {
        margin: 1px 0px;
    }

    div.Barra {
        display: none;
    }
</style>
<?php
$telaAditivo = false;
$numParte = 1;
$par_url .= 'idCad,';

if ($_SESSION[CS]['g_abrir_sistema_origem'] == 'PFO') {
    if ($_SESSION['link_assinar_distrato'] != '') {
        $sql = '';
        $sql .= ' select idt_contratar_credenciado';
        $sql .= ' from ' . db_pir_gec . 'gec_contratar_credenciado_distrato';
        $sql .= ' where md5(idt) = ' . aspa($_SESSION['link_assinar_distrato']);
        $rs = execsql($sql);

        if ($rs->rows != 1) {
            unset($_SESSION['link_assinar_distrato']);
            echo "<script type='text/javascript'>alert('Registro não localizado!');</script>";
            echo "<script type='text/javascript'>top.location = '" . $_SESSION[CS]['g_abrir_sistema_url'] . "';</script>";
            exit();
        }

        $_SESSION[CS]['link_assinar_distrato'] = $_SESSION['link_assinar_distrato'];
        $_GET['id'] = $rs->data[0][0];
        $acao = 'alt';
        $_GET['acao'] = 'alt';
        unset($_SESSION['link_assinar_distrato']);
    }

    if (count($_POST) == 0) {
        $sql = "select cc.idt";
        $sql .= " from " . db_pir_gec . "gec_contratacao_credenciado_ordem_lista_endidade ole ";
        $sql .= " inner join " . db_pir_gec . "gec_contratacao_credenciado_ordem_lista gec_ccol on gec_ccol.idt = ole.idt_gec_contratacao_credenciado_ordem_lista ";
        $sql .= " inner join " . db_pir_gec . "gec_contratacao_credenciado_ordem gec_cco on gec_cco.idt = gec_ccol.idt_gec_contratacao_credenciado_ordem ";
        $sql .= ' inner join ' . db_pir_gec . 'gec_contratar_credenciado cc on cc.idt_gec_contratacao_credenciado_ordem = gec_cco.idt';
        $sql .= ' inner join ' . db_pir_gec . 'gec_contratar_credenciado_distrato tab_ad on tab_ad.idt_contratar_credenciado = cc.idt';
        $sql .= ' left outer join ' . db_pir_grc . "grc_evento e on e.idt = gec_cco.idt_evento";
        $sql .= " left outer join " . db_pir_gec . "gec_programa gec_pr on gec_pr.idt = e.idt_programa";
        $sql .= " where gec_ccol.idt_organizacao = ole.idt_organizacao ";
        $sql .= ' and ole.cnpj_organizacao = ' . aspa($_SESSION[CS]['g_login']);
        $sql .= ' and tab_ad.idt_contratar_credenciado = ' . null($_GET['id']);
        $sql .= " and gec_pr.tipo_ordem = 'SG'";
        $sql .= " and gec_cco.ativo = 'S'";
        $sql .= " and cc.ativo = 'S'";
        $sql .= " and e.idt_evento_situacao in (14, 16, 19)";
        $sql .= " and e.idt_instrumento <> 52";
        $sql .= " and e.idt_evento_pai is null";
        $sql .= " and e.cred_necessita_credenciado = 'S'";
        $sql .= " and e.nao_sincroniza_rm = 'N'";
        $sql .= " and e.sgtec_modelo = 'E'";
        $rs = execsql($sql);

        if ($rs->rows != 1) {
            echo "<script type='text/javascript'>alert('O usuário não tem acesso a este registro!');</script>";
            echo "<script type='text/javascript'>top.location = '" . $_SESSION[CS]['g_abrir_sistema_url'] . "';</script>";
            exit();
        }
    }

    if ($_SESSION[CS]['link_assinar_distrato'] != '') {
        $botao_volta = "top.location = '" . $_SESSION[CS]['g_abrir_sistema_url'] . "';";
        $botao_acao = "<script type='text/javascript'>top.location = '" . $_SESSION[CS]['g_abrir_sistema_url'] . "';</script>";
    }
}

if ($_SESSION[CS]['g_abrir_sistema_origem'] == 'GEC') {
    $acao = 'con';
    $_GET['acao'] = $acao;
    $_GET['idt0'] = $_GET['idCad'];

    $botao_volta = "parent.parent.btFechaCTC('" . $_GET['session_cod'] . "');";
    $botao_acao = '<script type="text/javascript">parent.parent.btFechaCTC("' . $_GET['session_cod'] . '");</script>';
} else {
    if ($_GET['idCad'] == '') {
        $sql = '';
        $sql .= ' select idt';
        $sql .= ' from ' . db_pir_gec . 'gec_contratar_credenciado_distrato';
        $sql .= ' where idt_contratar_credenciado = ' . null($_GET['id']);
        $sql .= " and situacao not in ('CA')";
        $rs = execsql($sql);

        if ($rs->rows == 0) {
            $sql = '';
            $sql .= ' select ord.idt_evento, ord.codigo';
            $sql .= ' from ' . db_pir_gec . 'gec_contratar_credenciado cc';
            $sql .= ' inner join ' . db_pir_gec . 'gec_contratacao_credenciado_ordem ord on ord.idt = cc.idt_gec_contratacao_credenciado_ordem';
            $sql .= ' where cc.idt = ' . null($_GET['id']);
            $rs = execsqlNomeCol($sql);
            $rowDados = $rs->data[0];

            //Cria Registro
            $numero = $rowDados['codigo'] . '.D' . geraAutoNum(db_pir_grc, 'gec_contratar_credenciado_distrato_numero_' . $rowDados['codigo'] . '.D', 3);
            $reg_origem = $_SESSION[CS]['g_abrir_sistema_origem'];

            if ($reg_origem == '') {
                $reg_origem = $plu_sigla_interna;
            }

            $sql = 'insert into ' . db_pir_gec . 'gec_contratar_credenciado_distrato (idt_contratar_credenciado, situacao, idt_responsavel,';
            $sql .= ' idt_usuario_situacao, data_situacao, reg_origem, numero) values (';
            $sql .= null($_GET['id']) . ", 'CD', " . null($_SESSION[CS]['g_id_usuario_sistema']['GEC']) . ", ";
            $sql .= null($_SESSION[CS]['g_id_usuario_sistema']['GEC']) . ", now(), " . aspa($reg_origem) . ", " . aspa($numero) . ")";
            execsql($sql);
            $tmpIDT = lastInsertId();

            $sql = '';
            $sql .= ' select a.idt';
            $sql .= " from " . db_pir_grc . "grc_atendimento a";
            $sql .= " inner join " . db_pir_grc . "grc_evento_participante ep on ep.idt_atendimento = a.idt";
            $sql .= ' where a.idt_evento = ' . null($rowDados['idt_evento']);
            $sql .= " and (ep.contrato is null or ep.contrato <> 'IC')";
            $sql .= " and (ep.ativo is null or ep.ativo = 'S')";
            $rs = execsql($sql);

            foreach ($rs->data as $row) {
                atualizaRegDevolucaoSG($row['idt'], 'DI', $tmpIDT);
            }
        } else {
            $tmpIDT = $rs->data[0][0];
        }

        $_GET['idt0'] = $_GET['id'];
        $_GET['idCad'] = $_GET['id'];
        $_GET['id'] = $tmpIDT;
    }
}

$TabelaPrinc = "gec_contratar_credenciado_distrato";
$AliasPric = "gec_cca";
$Entidade = "Distrato";
$Entidade_p = "Distratos";
$CampoPricPai = "idt_contratar_credenciado";

$tabela = $TabelaPrinc;
$tabela_banco = db_pir_gec;

$id = 'idt';
$barra_bt_top = false;
$formUpload = true;

$onSubmitDep = 'gec_contratar_credenciado_distrato_dep()';

$pathObjFile = $vetSistemaUtiliza['GEC']['path_file'];

if ($acao == 'inc') {
    $sql = '';
    $sql .= ' select idt';
    $sql .= ' from ' . db_pir_gec . 'gec_contratar_credenciado_distrato';
    $sql .= ' where idt_contratar_credenciado = ' . null($_GET['idt0']);
    $sql .= " and situacao not in ('CA')";
    $rs = execsql($sql);

    if ($rs->rows > 0) {
        echo '<script type="text/javascript">alert("Não pode incluir um novo registro, pois tem um registro de Distrato ativo!")</script>';
        echo '<script type="text/javascript">parent.btFechaCTC("' . $_GET['session_cod'] . '");</script>';
        exit();
    }
}

$sql = '';
$sql .= ' select ccd.situacao, ccd.idt_responsavel, cc.idt_gec_contratacao_credenciado_ordem, ord.idt_evento, i.custo_total_real as vl_cotacao, ccd.comentario,';
$sql .= ' e.idt_instrumento, e.idt_ponto_atendimento, e.idt_unidade, e.idt_gestor_projeto, s.classificacao, ccd.valor_distrato, ccd.valor_apagar,';
$sql .= ' e.idt_gestor_evento, e.idt_responsavel as idt_responsavel_evento, ord.codigo, e.codigo as evento_codigo, ccd.reg_origem, ccd.defesa_inicial,';
$sql .= ' gec_o.codigo as pst_cnpj, gec_o.descricao as pst_nome, usu_o.email as pst_email, usu_o.login as pst_login, ccd.valor_realizado, ccd.valor_nao_liquidado';
$sql .= ' from ' . db_pir_gec . 'gec_contratar_credenciado_distrato ccd';
$sql .= ' inner join ' . db_pir_gec . 'gec_contratar_credenciado cc on cc.idt = ccd.idt_contratar_credenciado';
$sql .= ' inner join ' . db_pir_gec . 'gec_contratacao_credenciado_ordem ord on ord.idt = cc.idt_gec_contratacao_credenciado_ordem';
$sql .= " inner join " . db_pir_gec . "gec_contratacao_credenciado_ordem_insumo i on i.idt_gec_contratacao_credenciado_ordem = ord.idt and i.codigo = '71001'";
$sql .= " left outer join " . db_pir_gec . "gec_entidade gec_o on gec_o.idt = cc.idt_organizacao";
$sql .= " left outer join " . db_pir_gec . "plu_usuario usu_o on usu_o.login = gec_o.codigo";
$sql .= ' left outer join ' . db_pir_grc . 'grc_evento e on e.idt = ord.idt_evento';
$sql .= ' left outer join ' . db_pir . 'sca_organizacao_secao s on s.idt = e.idt_unidade';
$sql .= ' where ccd.idt = ' . null($_GET['id']);
$rs = execsqlNomeCol($sql);
$rowDados = $rs->data[0];

$rowDados['idt_responsavel'] = IdUsuarioPIR($rowDados['idt_responsavel'], db_pir_gec, db_pir_grc);

if ($rs->rows == 0) {
    unset($_GET['idt_pendencia']);
}

if ($_GET['idt_pendencia'] == '' && ($rowDados['situacao'] == 'RE' || $rowDados['situacao'] == 'GP' || $rowDados['situacao'] == 'CG' || $rowDados['situacao'] == 'DI')) {
    $sql = '';
    $sql .= ' select idt';
    $sql .= ' from grc_atendimento_pendencia';
    $sql .= ' where idt_contratar_credenciado_distrato = ' . null($_GET['id']);
    $sql .= ' and idt_responsavel_solucao = ' . null($_SESSION[CS]['g_id_usuario']);
    $sql .= " and ativo = 'S'";
    $sql .= " and tipo = 'Aprovação do Distrato'";
    $rs = execsql($sql);
    $_GET['idt_pendencia'] = $rs->data[0][0];
}

if ($rowDados['situacao'] == 'CD' || $rowDados['situacao'] == 'DE') {
    if ($rowDados['idt_responsavel'] != $_SESSION[CS]['g_id_usuario']) {
        $acao = 'con';
        $_GET['acao'] = $acao;
        alert('Não pode alterar o registro, pois você não é o Responsavel pela Solicitação!');
    }
} else if ($_GET['idt_pendencia'] == '' && $_SESSION[CS]['g_abrir_sistema_origem'] != 'PFO') {
    if ($rowDados['idt_responsavel'] == $_SESSION[CS]['g_id_usuario'] && $rowDados['situacao'] == 'AP') {
        $acao_alt_con = 'S';
    } else {
        //Só pode alterar quem tem a pendencia
        $acao = 'con';
        $_GET['acao'] = $acao;
        alert('Não pode alterar o registro, pois você não tem a pendência desta solicitação!');
    }
} else {
    $acao_alt_con = 'S';
}

if ($rowDados['situacao'] == 'RE' && $_SESSION[CS]['g_abrir_sistema_origem'] != 'PFO' && $acao == 'alt') {
    $acao_alt_con_p = 'S';
} else {
    $acao_alt_con_p = '';
}

$vetFrm = Array();
$class_frame_p = "class_frame_p";
$class_titulo_p = "class_titulo_p";
$class_frame = "class_frame";
$class_titulo = "class_titulo";
$titulo_na_linha = false;

$vetParametros = Array(
    'codigo_frm' => 'parte00',
    'controle_fecha' => 'A',
);

$vetFrm[] = Frame('<span>' . numParte() . ' - INFORMAÇÕES GERAIS DO DISTRATO</span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);

$vetParametros = Array(
    'codigo_pai' => 'parte00',
);

$vetCampo[$CampoPricPai] = objHidden($CampoPricPai, $_GET['idt0']);
$vetCampo['idt_responsavel'] = objFixoBanco('idt_responsavel', 'Responsavel pela Solicitação', db_pir_gec . 'plu_usuario', 'id_usuario', 'nome_completo');
$vetCampo['data_registro'] = objTextoFixo('data_registro', 'Data Registro', 20, true);

//$vetCampo['tipo'] = objCmbVetor('tipo', 'Tipo?', false, $vetTipoDistrato, '');
$vetCampo['tipo'] = objHidden('tipo', 'T');

$vetCampo['numero'] = objAutoNum('numero', 'Número', 17, true, 3, $rowDados['codigo'] . '.D');
$vetCampo['data_distrato'] = objData('data_distrato', 'Data base do Distrato', false, '', '', 'S');
$vetCampo['situacao'] = objFixoVetor('situacao', 'Situação', True, $vetSituacaoDistratoAditivo);

if ($_SESSION[CS]['g_abrir_sistema_origem'] != 'PFO') {
    //$vetCampo['retificadora'] = objCmbVetor('retificadora', 'Retificadora?', false, $vetNaoSim, '');
    $vetCampo['retificadora'] = objHidden('retificadora', 'N');
}

MesclarCol($vetCampo[$CampoPricPai], 7);
MesclarCol($vetCampo['situacao'], 3);

$vetFrm[] = Frame('', Array(
    Array($vetCampo[$CampoPricPai]),
    Array($vetCampo['idt_responsavel'], '', $vetCampo['data_registro'], '', $vetCampo['tipo'], '', $vetCampo['retificadora']),
    Array($vetCampo['numero'], '', $vetCampo['data_distrato'], '', $vetCampo['situacao']),
        ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);

$vetParametros['width'] = '100%';

$vetCampo['observacao'] = objHtml('observacao', 'Motivo do Distrato', true, 320, '100%');

$vetFrm[] = Frame('', Array(
    Array($vetCampo['observacao']),
        ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);

$vetParametros = Array(
    'codigo_frm' => 'parte01',
    'controle_fecha' => 'A',
);

$numAba = numParte();
$numAbaNum = 1;

$vetFrm[] = Frame('<span>' . $numAba . ' - DOSSIÊ</span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);

$vetParametros = Array(
    'codigo_pai' => 'parte01',
    'width' => '100%',
);

if ($acao == 'alt' && $acao_alt_con == 'S' && $rowDados['defesa_inicial'] == '') {
    $campo_fixo = 'Aberto';
} else {
    $campo_fixo = '';
}

$vetCampo['defesa_inicial'] = objHTML('defesa_inicial', 'Defesa da Prestadora de Serviço Tecnológico', false, 200, '100%', '', false, false, $campo_fixo);

$vetFrm[] = Frame('<span>' . $numAba . '.0' . $numAbaNum++ . ' - Defesa da Prestadora do Serviço - PST</span>', Array(
    Array($vetCampo['defesa_inicial']),
        ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);

//Anexos do Contrato - Gerado
$vetCampoLC = Array();
$vetCampoLC['ordem'] = CriaVetTabela('ordem');
$vetCampoLC['descricao'] = CriaVetTabela('Descrição');
$vetCampoLC['arquivo'] = CriaVetTabela('Arquivo', 'func_trata_dado', fnc_gec_contratar_credenciado_item);
$vetCampoLC['arquivo_ass'] = CriaVetTabela('Arquivo Assinado', 'func_trata_dado', fnc_gec_contratar_credenciado_item);

$titulo = 'Carta Contrato da Prestadora de Serviço Tecnológico (PST)';

$sql = '';
$sql .= ' select idt, ordem, descricao, arquivo, arquivo_ass';
$sql .= ' from ' . db_pir_gec . 'gec_contratar_credenciado_item';
$sql .= ' where idt_contratar_credenciado = ' . null($_GET['idt0']);
$sql .= ' order by ordem';

$vetParametrosLC = Array(
    'comcontrole' => '0',
    'barra_inc_ap' => false,
    'barra_alt_ap' => false,
    'barra_con_ap' => false,
    'barra_exc_ap' => false,
);

$vetCampo['gec_contratar_credenciado_item'] = objListarConf('gec_contratar_credenciado_item', 'idt', $vetCampoLC, $sql, $titulo, false, $vetParametrosLC);

$vetFrm[] = Frame('<span>' . $numAba . '.0' . $numAbaNum++ . ' - ' . $titulo . '</span>', Array(
    Array($vetCampo['gec_contratar_credenciado_item']),
        ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);

//Evidencias das Entregas
$vetCampoLC = Array();
$vetCampoLC['protocolo'] = CriaVetTabela('Protocolo');
$vetCampoLC['empreendimento'] = CriaVetTabela('Nome do Empreendimento / CNPJ');
$vetCampoLC['mesano'] = CriaVetTabela('Mês/Ano do Processo');
$vetCampoLC['entrega'] = CriaVetTabela('Entrega');
$vetCampoLC['gec_d_descricao'] = CriaVetTabela('Documento');
$vetCampoLC['arquivo'] = CriaVetTabela('Arquivo', 'func_trata_dado', fnc_grc_evento_pfo_af_processo_item);

$titulo = 'Prestação de Contas da Prestadora de Serviço Tecnológico - PST';

$sql = '';
$sql .= ' select ed.idt, a.protocolo, ee.mesano, afpi.arquivo,';
$sql .= " concat_ws(' - ', ee.codigo, ee.descricao) as entrega,";
$sql .= " gec_d.descricao as gec_d_descricao,";
$sql .= " concat_ws('<br />', o.razao_social, o.cnpj) as empreendimento";
$sql .= " from " . db_pir_grc . "grc_atendimento a";
$sql .= " inner join " . db_pir_grc . "grc_evento_participante ep on ep.idt_atendimento = a.idt";
$sql .= " inner join " . db_pir_grc . "grc_atendimento_pessoa p on p.tipo_relacao = 'L' and p.idt_atendimento = a.idt";
$sql .= " left outer join " . db_pir_grc . "grc_atendimento_organizacao o on o.idt_atendimento = a.idt";
$sql .= ' left outer join ' . db_pir_grc . 'grc_evento_entrega ee on ee.idt_atendimento = a.idt';
$sql .= ' left outer join ' . db_pir_grc . 'grc_evento_entrega_documento ed on ed.idt_evento_entrega = ee.idt';
$sql .= " left outer join " . db_pir_gec . "gec_documento gec_d on  gec_d.idt = ed.idt_documento ";
$sql .= ' left outer join ' . db_pir_pfo . 'pfo_af_processo_item afpi on afpi.idt_evento_entrega_documento = ed.idt';
$sql .= ' left outer join ' . db_pir_pfo . "pfo_af_processo afp on afp.idt = afpi.idt_processo";
$sql .= ' where a.idt_evento = ' . null($rowDados['idt_evento']);
$sql .= " and (ep.contrato is null or ep.contrato <> 'IC')";
$sql .= " and (ep.ativo is null or ep.ativo = 'S')";
$sql .= ' order by a.protocolo, o.razao_social, o.cnpj, ee.mesano, ee.codigo, ee.descricao';

$vetParametrosLC = Array(
    'comcontrole' => '0',
    'barra_inc_ap' => false,
    'barra_alt_ap' => false,
    'barra_con_ap' => false,
    'barra_exc_ap' => false,
);

$vetCampo['grc_evento_entrega_documento'] = objListarConf('grc_evento_entrega_documento', 'idt', $vetCampoLC, $sql, $titulo, false, $vetParametrosLC);

$vetFrm[] = Frame('<span>' . $numAba . '.0' . $numAbaNum++ . ' - ' . $titulo . '</span>', Array(
    Array($vetCampo['grc_evento_entrega_documento']),
        ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);

//Anexos do Distrato
$vetCampoLC = Array();
$vetCampoLC['data_registro'] = CriaVetTabela('Data Registro', 'data');
$vetCampoLC['titulo'] = CriaVetTabela('Título do Anexo');
$vetCampoLC['arquivo'] = CriaVetTabela('Arquivo', 'func_trata_dado', fnc_gec_contratar_credenciado_distrato_anexos);
$vetCampoLC['responsavel'] = CriaVetTabela('Responsável');

$titulo = 'Anexos do Distrato da Contratação';

$sql = '';
$sql .= ' select gec_ccda.*,';
$sql .= ' plu_usu.nome_completo as responsavel ';
$sql .= ' from ' . db_pir_gec . 'gec_contratar_credenciado_distrato_anexos gec_ccda ';
$sql .= ' inner join ' . db_pir_gec . 'plu_usuario plu_usu on plu_usu.id_usuario = gec_ccda.idt_responsavel ';
$sql .= ' where idt_distrato = $vlID';
$sql .= ' order by data_registro';

$vetParametrosLC = Array(
    'func_trata_row' => ftr_gec_contratar_credenciado_distrato_anexos,
    'acao_alt_con_p' => $acao_alt_con_p,
);

$vetCampo['gec_contratar_credenciado_distrato_anexos'] = objListarConf('gec_contratar_credenciado_distrato_anexos', 'idt', $vetCampoLC, $sql, $titulo, false, $vetParametrosLC);

$vetFrm[] = Frame('<span>' . $numAba . '.0' . $numAbaNum++ . ' - ' . $titulo . '</span>', Array(
    Array($vetCampo['gec_contratar_credenciado_distrato_anexos']),
        ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);

$valor_realizado = $rowDados['valor_realizado'];

if ($valor_realizado == '') {
    $sql = '';
    $sql .= ' select sum(rm.valor_real) as tot';
    $sql .= ' from ' . db_pir_gec . 'gec_contratacao_credenciado_ordem_rm rm';
    $sql .= ' left outer join ' . db_pir_pfo . 'pfo_af_processo afp on afp.idmov = rm.rm_idmov';
    $sql .= ' where rm.idt_gec_contratacao_credenciado_ordem = ' . null($rowDados['idt_gec_contratacao_credenciado_ordem']);
    $sql .= " and rm.rm_cancelado = 'N'";
    $sql .= " and ((afp.situacao_reg = 'FI' && afp.gfi_situacao = 'CB') || afp.situacao_reg = 'AP')"; //liquidado
    $rs = execsql($sql);
    $valor_realizado = $rs->data[0][0];

    if ($valor_realizado == '') {
        $valor_realizado = 0;
    }
}

$valor_nao_liquidado = $rowDados['valor_nao_liquidado'];

if ($valor_nao_liquidado == '') {
    $sql = '';
    $sql .= ' select sum(rm.valor_real) as tot';
    $sql .= ' from ' . db_pir_gec . 'gec_contratacao_credenciado_ordem_rm rm';
    $sql .= ' left outer join ' . db_pir_pfo . 'pfo_af_processo afp on afp.idmov = rm.rm_idmov';
    $sql .= ' where rm.idt_gec_contratacao_credenciado_ordem = ' . null($rowDados['idt_gec_contratacao_credenciado_ordem']);
    $sql .= " and rm.rm_cancelado = 'N'";
    $sql .= " and (afp.situacao_reg is null or not ((afp.situacao_reg = 'FI' && afp.gfi_situacao = 'CB') || afp.situacao_reg = 'AP'))"; //liquidado
    $rs = execsql($sql);
    $valor_nao_liquidado = $rs->data[0][0];

    if ($valor_nao_liquidado == '') {
        $valor_nao_liquidado = 0;
    }
}

$valor_total = $valor_realizado + $rowDados['valor_apagar'];

$vetCampo['valor_contrato'] = objTextoFixo('valor_contrato', 'Valor do Contrato (R$)', '', false, false, format_decimal($rowDados['vl_cotacao']));
$vetCampo['valor_realizado'] = objTextoFixo('valor_realizado', 'Valor Realizado (R$)', '', true, false, format_decimal($valor_realizado));
$vetCampo['valor_nao_liquidado'] = objTextoFixo('valor_nao_liquidado', 'Valor Distratado (R$)', '', true, false, format_decimal($valor_nao_liquidado));
$vetCampo['valor_apagar'] = objTextoFixo('valor_apagar', 'Valor a Pagar (R$)', '', true);
$vetCampo['valor_total'] = objTextoFixo('valor_total', 'Valor Total (R$)<br />(realizado + a pagar)', '', false, false, format_decimal($valor_total));
$vetCampo['valor_distrato'] = objTextoFixo('valor_distrato', 'Valor do Distrato (R$)', '', true);

$vetFrm[] = Frame('<span>' . $numAba . '.0' . $numAbaNum++ . ' - Resumo do Distrato com a PST</span>', Array(
    Array($vetCampo['valor_contrato'], '', $vetCampo['valor_realizado'], '', $vetCampo['valor_nao_liquidado'], '', $vetCampo['valor_distrato']),
        ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);

$vetFrm[] = Frame('', Array(
    Array($vetCampo['valor_apagar'], '', $vetCampo['valor_total']),
        ), $class_frame . ' display_none', $class_titulo, $titulo_na_linha, $vetParametros);

if ($_SESSION[CS]['g_abrir_sistema_origem'] != 'PFO') {
    if ($rowDados['situacao'] == 'CD' || $rowDados['situacao'] == 'DE' || $rowDados['situacao'] == 'RE') {
        calculaValorDistratoDevolucao($_GET['id'], $valor_total);
    }

    $vetCampoLC = Array();
    $vetCampoLC['empreendimento'] = CriaVetTabela('Protocolo');
    $vetCampoLC['descricao'] = CriaVetTabela('Pagametos feitos por');
    $vetCampoLC['favorecido'] = CriaVetTabela('Favorecido');
    $vetCampoLC['banco_nome'] = CriaVetTabela('Banco');
    $vetCampoLC['agencia'] = CriaVetTabela('Agência');
    $vetCampoLC['cc'] = CriaVetTabela('Conta Corrente');
    //$vetCampoLC['vl_pago_compra'] = CriaVetTabela('Valor Pago pelo Cliente (R$)', 'decimal');
    //$vetCampoLC['vl_ja_devolvido'] = CriaVetTabela('Valor devolvido após Cotação (R$)', 'decimal');
    //$vetCampoLC['vl_devido'] = CriaVetTabela('Valor Devido (R$)', 'decimal');
    $vetCampoLC['vl_devolucao'] = CriaVetTabela('Valor a Devolver (R$)', 'decimal');
    $vetCampoLC['rm_idmov'] = CriaVetTabela('Cód. RM');

    $titulo = 'Dados para Devolução';

    $sql = '';
    $sql .= " select cd.*, concat_ws('-', cd.agencia_numero, cd.agencia_digito) as agencia, concat_ws('-', cd.cc_numero, cd.cc_digito) as cc,";
    $sql .= " concat_ws(' - ', cd.cpfcnpj, cd.razao_social) as favorecido, pp.rm_idmov, cd.vl_pago - cd.vl_devolucao as vl_devido,";
    $sql .= " concat_ws('<br />', a.protocolo, o.razao_social, o.cnpj) as empreendimento";
    $sql .= ' from grc_evento_participante_contadevolucao cd';
    $sql .= " inner join " . db_pir_grc . "grc_atendimento a on a.idt = cd.idt_atendimento";
    $sql .= " inner join " . db_pir_grc . "grc_evento_participante ep on ep.idt_atendimento = cd.idt_atendimento";
    $sql .= " left outer join " . db_pir_grc . "grc_atendimento_organizacao o on o.idt_atendimento = cd.idt_atendimento";
    $sql .= ' left outer join grc_evento_participante_pagamento pp on pp.idt = cd.idt_evento_participante_pagamento';
    $sql .= ' where a.idt_evento = ' . null($rowDados['idt_evento']);
    $sql .= " and (ep.contrato is null or ep.contrato <> 'IC')";
    $sql .= " and (ep.ativo is null or ep.ativo = 'S')";
    $sql .= " and cd.reg_origem = 'DI'";

    $vetParametrosLC = Array(
        'contlinfim' => '',
        'acao_alt_con_p' => $acao_alt_con_p,
    );

    $vetCampo['grc_evento_participante_contadevolucao'] = objListarConf('grc_evento_participante_contadevolucao', 'idt', $vetCampoLC, $sql, $titulo, false, $vetParametrosLC);

    $vetFrm[] = Frame('<span>' . $numAba . '.0' . $numAbaNum++ . ' - Resumo do Distrato com o Cliente</span>', Array(
        Array($vetCampo['grc_evento_participante_contadevolucao']),
            ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);

    //Termo de Adesão
    $vetCampoLC = Array();
    $vetCampoLC['protocolo'] = CriaVetTabela('Protocolo');
    $vetCampoLC['pessoa'] = CriaVetTabela('Nome do Cliente / CPF');
    $vetCampoLC['empreendimento'] = CriaVetTabela('Nome do Empreendimento / CNPJ');
    $vetCampoLC['contrato_pdf'] = CriaVetTabela('PDF do contrato', 'arquivo_link', '', 'grc_evento_participante_contrato');
    $vetCampoLC['contrato_ass_pdf'] = CriaVetTabela('Contrato Assinado', 'arquivo_link', '', 'grc_evento_participante_contrato');

    $titulo = 'Termo de Adesão do Cliente';

    $sql = "select pc.idt, a.protocolo, pc.contrato_pdf, pc.contrato_ass_pdf,";
    $sql .= " concat_ws('<br />', p.nome, p.cpf) as pessoa,";
    $sql .= " concat_ws('<br />', o.razao_social, o.cnpj) as empreendimento";
    $sql .= " from " . db_pir_grc . "grc_evento_participante_contrato pc";
    $sql .= " inner join " . db_pir_grc . "grc_atendimento a on a.idt = pc.idt_atendimento";
    $sql .= " inner join " . db_pir_grc . "grc_evento_participante ep on ep.idt_atendimento = pc.idt_atendimento";
    $sql .= " inner join " . db_pir_grc . "grc_atendimento_pessoa p on p.tipo_relacao = 'L' and p.idt_atendimento = pc.idt_atendimento";
    $sql .= " left outer join " . db_pir_grc . "grc_atendimento_organizacao o on o.idt_atendimento = pc.idt_atendimento";
    $sql .= ' where a.idt_evento = ' . null($rowDados['idt_evento']);
    $sql .= ' and pc.idt_usuario_canc is null';
    $sql .= " and (ep.contrato is null or ep.contrato <> 'IC')";
    $sql .= " and (ep.ativo is null or ep.ativo = 'S')";
    $sql .= " order by a.protocolo";

    $vetPadrao = Array(
        'barra_inc_ap' => false,
        'barra_alt_ap' => false,
        'barra_con_ap' => false,
        'barra_exc_ap' => false,
        'comcontrole' => 0,
    );

    $vetCampo['grc_evento_participante_contrato'] = objListarConf('grc_evento_participante_contrato', 'idt', $vetCampoLC, $sql, $titulo, false, $vetPadrao);

    $vetFrm[] = Frame('<span>' . $numAba . '.0' . $numAbaNum++ . ' - ' . $titulo . '</span>', Array(
        Array($vetCampo['grc_evento_participante_contrato']),
            ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);

    $vetCampo['arq_avaliacao_cliente'] = objFile('arq_avaliacao_cliente', 'Arquivo da Avaliação do Cliente', false, 120, 'todos');

    $vetFrm[] = Frame('<span>' . $numAba . '.0' . $numAbaNum++ . ' - Avaliação do Cliente</span>', Array(
        Array($vetCampo['arq_avaliacao_cliente']),
            ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);

    $vetCampo['arq_avaliacao_cliente'] = objFile('arq_avaliacao_cliente', 'Arquivo da Avaliação do Cliente', false, 120, 'todos');
}

$vetParametros = Array(
    'codigo_frm' => 'parte02',
    'controle_fecha' => 'A',
);

$vetFrm[] = Frame('<span>' . numParte() . ' - ENTREGAS DA CONTRATAÇÃO</span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);

$vetParametros = Array(
    'codigo_pai' => 'parte02',
    'width' => '100%',
);

$vetCampoLC = Array();
$vetCampoLC['pessoa'] = CriaVetTabela('Cliente');
$vetCampoLC['codigo'] = CriaVetTabela('Código');
$vetCampoLC['descricao'] = CriaVetTabela('Atividade');
$vetCampoLC['mesano'] = CriaVetTabela('Mês/Ano');
$vetCampoLC['percentual'] = CriaVetTabela('Percentual', 'decimal');
$vetCampoLC['vl_entrega_real'] = CriaVetTabela('Vl. Cotação', 'decimal');
$vetCampoLC['situacao_reg'] = CriaVetTabela('Financeiro', 'func_trata_dado', ftd_gec_contratacao_credenciado_ordem_entrega);
$vetCampoLC['entrega_realizada'] = CriaVetTabela('Entrega Realizada', 'func_trata_dado', ftd_gec_contratacao_credenciado_ordem_entrega);
$vetCampoLC['vl_executado'] = CriaVetTabela('Vl. Executado', 'func_trata_dado', ftd_gec_contratacao_credenciado_ordem_entrega);

$titulo = 'Entregas';

$sql = "select orde.*,";
$sql .= " concat_ws('<br />', grc_atpe.cpf, grc_atpe.nome) as pessoa,";
$sql .= ' afp.situacao_reg, afp.gfi_situacao, afp.liquidado, afp.gfi_situacao, ccde.vl_executado, ccde.perc_executado,';
$sql .= ' orde.idt as idt_gec_contratacao_credenciado_ordem_entrega';
$sql .= " from " . db_pir_gec . "gec_contratacao_credenciado_ordem_entrega orde";
$sql .= " left outer join " . db_pir_grc . "grc_atendimento_pessoa grc_atpe on grc_atpe.tipo_relacao = 'L' and grc_atpe.idt_atendimento = orde.idt_atendimento";
$sql .= " left outer join " . db_pir_gec . "gec_contratacao_credenciado_ordem_rm rm on";
$sql .= " rm.idt_gec_contratacao_credenciado_ordem = orde.idt_gec_contratacao_credenciado_ordem";
$sql .= " and rm.rm_cancelado = 'N'";
$sql .= " and rm.mesano = orde.mesano";
$sql .= " left outer join " . db_pir_pfo . "pfo_af_processo afp on afp.idmov = rm.rm_idmov";
$sql .= " left outer join " . db_pir_gec . "gec_contratar_credenciado_distrato_entrega ccde on";
$sql .= " ccde.idt_gec_contratacao_credenciado_ordem_entrega = orde.idt";
$sql .= " and ccde.idt_distrato = " . null($_GET['id']);
$sql .= ' where orde.idt_gec_contratacao_credenciado_ordem = ' . null($rowDados['idt_gec_contratacao_credenciado_ordem']);
$sql .= " order by grc_atpe.nome, orde.ordem";

$vetParametrosLC = Array(
    'comcontrole' => '0',
    'barra_inc_ap' => false,
    'barra_alt_ap' => false,
    'barra_con_ap' => false,
    'barra_exc_ap' => false,
);

$vetCampo['gec_contratacao_credenciado_ordem_entrega'] = objListarConf('gec_contratacao_credenciado_ordem_entrega', 'idt', $vetCampoLC, $sql, $titulo, false, $vetParametrosLC);

$vetFrm[] = Frame('', Array(
    Array($vetCampo['gec_contratacao_credenciado_ordem_entrega']),
        ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);

if ($_SESSION[CS]['g_abrir_sistema_origem'] != 'PFO') {
    $vetParametros = Array(
        'codigo_frm' => 'parte03',
        'controle_fecha' => 'A',
    );

    $vetFrm[] = Frame('<span>' . numParte() . ' - PARECERES DO DISTRATO DA CONTRATAÇÃO</span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);

    $vetParametros = Array(
        'codigo_pai' => 'parte03',
        'width' => '100%',
    );

    $vetCampoLC = Array();
    $vetCampoLC['data_registro'] = CriaVetTabela('Data Registro', 'data');
    $vetCampoLC['descricao'] = CriaVetTabela('Título do Parecer');
    $vetCampoLC['responsavel'] = CriaVetTabela('Responsável');

    $titulo = 'Pareceres do Distrato da Contratação';

    $sql = '';
    $sql .= ' select gec_ccdp.*, ';
    $sql .= ' plu_usu.nome_completo as responsavel ';
    $sql .= ' from ' . db_pir_gec . 'gec_contratar_credenciado_distrato_parecer gec_ccdp ';
    $sql .= ' inner join ' . db_pir_gec . 'plu_usuario plu_usu on plu_usu.id_usuario = gec_ccdp.idt_responsavel ';
    $sql .= ' where idt_distrato = $vlID';
    $sql .= ' order by data_registro';

    $vetParametrosLC = Array(
        'contlinfim' => '',
        'acao_alt_con_p' => $acao_alt_con_p,
    );

    $vetCampo['gec_contratar_credenciado_distrato_parecer'] = objListarConf('gec_contratar_credenciado_distrato_parecer', 'idt', $vetCampoLC, $sql, $titulo, false, $vetParametrosLC);

    $vetFrm[] = Frame('', Array(
        Array($vetCampo['gec_contratar_credenciado_distrato_parecer']),
            ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);
}

if ($rowDados['situacao'] == 'AP' || $rowDados['situacao'] == 'AS') {
    $vetParametros = Array(
        'codigo_frm' => 'partepdf',
        'controle_fecha' => 'A',
    );

    $vetFrm[] = Frame('<span>' . numParte() . ' - DISTRATO PARA ASSINAR</span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);

    $vetParametros = Array(
        'codigo_pai' => 'partepdf',
        'width' => '100%',
    );

    $vetCampoLC = Array();
    $vetCampoLC['origem'] = CriaVetTabela('Origem');
    $vetCampoLC['empreendimento'] = CriaVetTabela('Nome do Empreendimento / CNPJ', 'func_trata_dado', fnc_gec_contratar_credenciado_distrato_pdf);
    $vetCampoLC['data_registro'] = CriaVetTabela('Data Registro', 'data');
    $vetCampoLC['arq_distrato'] = CriaVetTabela('Distrato para Assinar', 'func_trata_dado', fnc_gec_contratar_credenciado_distrato_pdf);
    $vetCampoLC['arq_distrato_ass'] = CriaVetTabela('Distrato Assinado', 'func_trata_dado', fnc_gec_contratar_credenciado_distrato_pdf);
    $vetCampoLC['data_upload'] = CriaVetTabela('Data Upload', 'data');
    $vetCampoLC['responsavel_upload'] = CriaVetTabela('Responsável do Upload');

    $titulo = 'Distrato para Assinar';

    $sql = '';
    $sql .= ' select pdf.*, plu_usu.nome_completo as responsavel_upload,';
    $sql .= " if(a.protocolo is null, 'PST', 'Cliente') as origem,";
    $sql .= " concat_ws('<br />', a.protocolo, o.razao_social, o.cnpj) as empreendimento";
    $sql .= ' from ' . db_pir_gec . 'gec_contratar_credenciado_distrato_pdf pdf ';
    $sql .= " left outer join " . db_pir_grc . "grc_atendimento a on a.idt = pdf.idt_atendimento";
    $sql .= " left outer join " . db_pir_grc . "grc_atendimento_organizacao o on o.idt_atendimento = a.idt";
    $sql .= ' left outer join ' . db_pir_gec . 'plu_usuario plu_usu on plu_usu.id_usuario = pdf.idt_usuario_upload ';
    $sql .= ' where pdf.idt_distrato = $vlID';

    if ($_SESSION[CS]['g_abrir_sistema_origem'] == 'PFO') {
        $sql .= ' and a.protocolo is null';
    }

    $sql .= ' order by a.protocolo, o.razao_social, o.cnpj';

    $vetParametrosLC = Array(
        'comcontrole' => '0',
        'barra_inc_ap' => false,
        'barra_alt_ap' => false,
        'barra_con_ap' => false,
        'barra_exc_ap' => false,
    );

    $vetCampo['gec_contratar_credenciado_distrato_pdf'] = objListarConf('gec_contratar_credenciado_distrato_pdf', 'idt', $vetCampoLC, $sql, $titulo, false, $vetParametrosLC);

    $vetFrm[] = Frame('', Array(
        Array($vetCampo['gec_contratar_credenciado_distrato_pdf']),
            ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);
}

if ($_SESSION[CS]['g_abrir_sistema_origem'] != 'PFO') {
    $vetParametros = Array(
        'codigo_frm' => 'parteConclusao',
        'controle_fecha' => 'A',
    );

    $vetFrm[] = Frame('<span>' . numParte() . ' - CONCLUSÃO DO DISTRATO</span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);

    $vetParametros = Array(
        'codigo_pai' => 'parteConclusao',
        'width' => '100%',
    );

    if ($acao == 'alt' && ($rowDados['situacao'] == 'CD' || $rowDados['situacao'] == 'DE' || $rowDados['situacao'] == 'RE')) {
        $campo_fixo = 'Aberto';
    } else {
        $campo_fixo = '';
    }

    $vetCampo['conclusao'] = objHTML('conclusao', 'Conclusão', false, 200, '100%', '', false, false, $campo_fixo);

    $vetFrm[] = Frame('', Array(
        Array($vetCampo['conclusao']),
            ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);

    if ($rowDados['comentario'] != '' || $rowDados['situacao'] == 'DE' || $rowDados['situacao'] == 'RE' || $rowDados['situacao'] == 'GP' || $rowDados['situacao'] == 'CG' || $rowDados['situacao'] == 'DI') {
        $vetCampo['comentario'] = objTextArea('comentario', 'Comentário', false, 2000);

        $vetFrm[] = Frame('', Array(
            Array($vetCampo['comentario']),
                ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);
    }
}

$vetCampo['gec_contratar_credenciado_distrato_bt'] = objInclude('gec_contratar_credenciado_distrato_bt', 'cadastro_conf/gec_contratar_credenciado_distrato_bt.php');
$vetCampo['situacao_ant'] = objHidden('situacao_ant', $rowDados['situacao'], '', '', false);
$vetCampo['bt_salva'] = objHidden('bt_salva', '', '', '', false);
$vetCampo['idt_usuario_situacao'] = objHidden('idt_usuario_situacao', $_SESSION[CS]['g_id_usuario_sistema']['GEC']);
$vetCampo['data_situacao'] = objHidden('data_situacao', getdata(true, true, true));

$vetFrm[] = Frame('', Array(
    Array($vetCampo['gec_contratar_credenciado_distrato_bt']),
    Array($vetCampo['situacao_ant']),
    Array($vetCampo['bt_salva']),
    Array($vetCampo['idt_usuario_situacao']),
    Array($vetCampo['data_situacao']),
        ), $class_frame, $class_titulo, $titulo_na_linha);

$vetCad[] = $vetFrm;
?>
<script type="text/javascript">
    var situacao = '<?php echo $rowDados['situacao']; ?>';
    acao = '<?php echo $acao; ?>';

    $(document).ready(function () {
        $('input.vl_executado').blur(function () {
            money(this);

            var vl_executado = $(this);
            var valor = str2float(vl_executado.val());
            var valant = $(this).data('valant');
            var perc_executado = $(this).parent().find('input.perc_executado');

            perc_executado.val('');

            if (vl_executado.val() !== '') {
                var total = $(this).data('valor');

                if (total == '') {
                    total = 0;
                }

                if (valor > total) {
                    alert("O valor não pode ser maior que o Vl. Cotação!");
                    vl_executado.val('');
                    vl_executado.focus();
                    calculaValor();
                    return false;

                }

                if (valor !== '') {
                    var perc = valor * 100 / total;
                    perc_executado.val(float2str(perc, 8));
                    perc_executado.data('valant', perc);
                }
            }

            if (isNaN(valor)) {
                valor = '';
            }

            if (valor != valant) {
                calculaValor();
            }

            $(this).data('valant', valor);
        });

        $('input.perc_executado').blur(function () {
            money(this, 8);

            var perc_executado = $(this);
            var valor = str2float(perc_executado.val());
            var valant = $(this).data('valant');
            var vl_executado = $(this).parent().find('input.vl_executado');

            vl_executado.val('');

            if (perc_executado.val() !== '') {
                var total = $(this).data('valor');

                if (total == '') {
                    total = 0;
                }

                if (valor > 100) {
                    alert("O valor não pode ser maior que 100%!");
                    perc_executado.val('');
                    perc_executado.focus();
                    calculaValor();
                    return false;

                }

                if (valor !== '') {
                    var perc = valor * total / 100;
                    vl_executado.val(float2str(perc));
                    vl_executado.data('valant', perc);
                }
            }

            if (isNaN(valor)) {
                valor = '';
            }

            if (valor != valant) {
                calculaValor();
            }

            $(this).data('valant', valor);
        });

        if (situacao == 'RE') {
            if (acao == 'alt') {
                setTimeout(function () {
                    $('#retificadora, #arq_avaliacao_cliente, #conclusao').removeProp("disabled").removeClass("campo_disabled");
                }, 500);

                setTimeout(function () {
                    $('#retificadora, #arq_avaliacao_cliente, #conclusao').removeProp("disabled").removeClass("campo_disabled");
                }, 2000);
            }
        }

        if (situacao == 'AP') {
            if (acao == 'alt') {
                setTimeout(function () {
                    $('input.fileAss').removeProp("disabled").removeClass("campo_disabled");
                }, 500);

                setTimeout(function () {
                    $('input.fileAss').removeProp("disabled").removeClass("campo_disabled");
                }, 2000);
            }
        }

        if (situacao == 'DE' || situacao == 'RE' || situacao == 'GP' || situacao == 'CG' || situacao == 'DI') {
            if (acao == 'alt') {
                setTimeout(function () {
                    $('#comentario').removeProp("disabled").removeClass("campo_disabled");
                }, 500);

                setTimeout(function () {
                    $('#comentario').removeProp("disabled").removeClass("campo_disabled");
                }, 2000);
            }
        }

        if ('<?php echo $_SESSION[CS]['g_abrir_sistema_origem']; ?>' != 'GRC' && '<?php echo $_SESSION[CS]['g_abrir_sistema_origem']; ?>' != '') {
            setTimeout(function () {
                TelaHeight();
            }, 500);

            setTimeout(function () {
                TelaHeight();
            }, 2000);
        }
    });

    function calculaValor() {
        processando();

        var valor_apagar = 0;

        $('#gec_contratacao_credenciado_ordem_entrega_desc input.vl_executado').each(function () {
            if ($(this).val() !== '') {
                valor_apagar += str2float($(this).val());
            }
        });

        var valor_nao_liquidado = <?php echo $valor_nao_liquidado; ?>;
        var valor_distrato = valor_nao_liquidado - valor_apagar;
        var valor_total = <?php echo $valor_realizado; ?> + valor_apagar;

        $.ajax({
            dataType: 'json',
            type: 'POST',
            url: ajax_sistema + '?tipo=calculaValorDistratoDevolucao',
            data: {
                cas: conteudo_abrir_sistema,
                idt_distrato: '<?php echo $_GET['id']; ?>',
                valor_total: valor_total
            },
            success: function (response) {
                btFechaCTC($('#grc_evento_participante_contadevolucao').data('session_cod'));

                if (response.erro != '') {
                    alert(url_decode(response.erro));
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert('Erro no ajax no: ' + textStatus + ' - ' + errorThrown);
            },
            async: false
        });

        valor_apagar = float2str(valor_apagar);
        valor_total = float2str(valor_total);
        valor_distrato = float2str(valor_distrato);

        $('#valor_apagar').val(valor_apagar);
        $('#valor_apagar_fix').text(valor_apagar);

        $('#valor_total').val(valor_total);
        $('#valor_total_fix').text(valor_total);

        $('#valor_distrato').val(valor_distrato);
        $('#valor_distrato_fix').text(valor_distrato);

        $('#dialog-processando').remove();
    }

    function gec_contratar_credenciado_distrato_dep() {
        if (valida == 'S') {
            var OK = true;

            if (OK) {
                $('#gec_contratacao_credenciado_ordem_entrega_desc input.Obr').each(function () {
                    if ($(this).val() == '' && OK) {
                        alert('Favor informar o valor deste campo!');
                        $(this).focus();
                        OK = false;
                    }
                });
            }

            if (OK) {
                processando();

                $.ajax({
                    dataType: 'json',
                    type: 'POST',
                    url: ajax_sistema + '?tipo=gec_contratar_credenciado_distrato_dep',
                    data: {
                        cas: conteudo_abrir_sistema,
                        id: $('#id').val()
                    },
                    success: function (response) {
                        if (response.erro != '') {
                            $('#dialog-processando').remove();
                            alert(url_decode(response.erro));
                            OK = false;
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        $('#dialog-processando').remove();
                        alert('Erro no ajax no: ' + textStatus + ' - ' + errorThrown);
                        ok = false;
                    },
                    async: false
                });

                $('#dialog-processando').remove();
            }

            if (OK) {
                calculaValor();
            }

            return OK;
        }

        return true;
    }
</script>
