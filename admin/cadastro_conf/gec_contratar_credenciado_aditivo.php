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

    div.Barra {
        display: none;
    }
</style>
<?php
$telaAditivo = true;
$numParte = 1;
$par_url .= 'idCad,';

if ($_SESSION[CS]['g_abrir_sistema_origem'] == 'PFO') {
    if ($_SESSION['link_assinar_aditivo'] != '') {
        $sql = '';
        $sql .= ' select idt_contratar_credenciado';
        $sql .= ' from ' . db_pir_gec . 'gec_contratar_credenciado_aditivo';
        $sql .= ' where md5(idt) = ' . aspa($_SESSION['link_assinar_aditivo']);
        $rs = execsql($sql);

        if ($rs->rows != 1) {
            unset($_SESSION['link_assinar_aditivo']);
            echo "<script type='text/javascript'>alert('Registro não localizado!');</script>";
            echo "<script type='text/javascript'>top.location = '" . $_SESSION[CS]['g_abrir_sistema_url'] . "';</script>";
            exit();
        }

        $_SESSION[CS]['link_assinar_aditivo'] = $_SESSION['link_assinar_aditivo'];
        $_GET['id'] = $rs->data[0][0];
        $acao = 'alt';
        $_GET['acao'] = 'alt';
        unset($_SESSION['link_assinar_aditivo']);
    }

    if (count($_POST) == 0) {
        $sql = "select cc.idt";
        $sql .= " from " . db_pir_gec . "gec_contratacao_credenciado_ordem_lista_endidade ole ";
        $sql .= " inner join " . db_pir_gec . "gec_contratacao_credenciado_ordem_lista gec_ccol on gec_ccol.idt = ole.idt_gec_contratacao_credenciado_ordem_lista ";
        $sql .= " inner join " . db_pir_gec . "gec_contratacao_credenciado_ordem gec_cco on gec_cco.idt = gec_ccol.idt_gec_contratacao_credenciado_ordem ";
        $sql .= ' inner join ' . db_pir_gec . 'gec_contratar_credenciado cc on cc.idt_gec_contratacao_credenciado_ordem = gec_cco.idt';
        $sql .= ' inner join ' . db_pir_gec . 'gec_contratar_credenciado_aditivo tab_ad on tab_ad.idt_contratar_credenciado = cc.idt';
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

    if ($_SESSION[CS]['link_assinar_aditivo'] != '') {
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
        $sql .= ' from ' . db_pir_gec . 'gec_contratar_credenciado_aditivo';
        $sql .= ' where idt_contratar_credenciado = ' . null($_GET['id']);
        $sql .= " and situacao not in ('CA')";
        $rs = execsql($sql);

        if ($rs->rows == 0) {
            $sql = '';
            $sql .= ' select ord.idt_evento, ord.codigo, i.custo_total_real as vl_cotacao, p.vl_teto, e.dt_previsao_fim';
            $sql .= ' from ' . db_pir_gec . 'gec_contratar_credenciado cc';
            $sql .= ' inner join ' . db_pir_gec . 'gec_contratacao_credenciado_ordem ord on ord.idt = cc.idt_gec_contratacao_credenciado_ordem';
            $sql .= " inner join " . db_pir_gec . "gec_contratacao_credenciado_ordem_insumo i on i.idt_gec_contratacao_credenciado_ordem = ord.idt and i.codigo = '71001'";
            $sql .= ' left outer join ' . db_pir_grc . 'grc_produto p on p.idt = ord.idt_produto';
            $sql .= ' left outer join ' . db_pir_grc . 'grc_evento e on e.idt = ord.idt_evento';
            $sql .= ' where cc.idt = ' . null($_GET['id']);
            $rs = execsqlNomeCol($sql);
            $rowDados = $rs->data[0];

            $aditivo_limite_valor = desformat_decimal($vetConf['aditivo_limite_valor']);

            if ($aditivo_limite_valor == '' || $aditivo_limite_valor == 0) {
                $aditivo_limite_valor = 0;
            } else {
                $aditivo_limite_valor = 1 + ($aditivo_limite_valor / 100);
            }

            $valor_total = $rowDados['vl_cotacao'] * $aditivo_limite_valor;

            if ($valor_total > $rowDados['vl_teto']) {
                $valor_total = $rowDados['vl_teto'];
            }

            $sql = '';
            $sql .= ' select sum(valor_aditivo) as vl';
            $sql .= ' from ' . db_pir_gec . 'gec_contratar_credenciado_aditivo';
            $sql .= ' where idt_contratar_credenciado = ' . null($_GET['id']);
            $sql .= " and situacao in ('AP', 'AS')";
            $rs = execsql($sql);
            $rowt = $rs->data[0];

            $valor_aditivo_ant = $rowt['vl'];

            if ($valor_aditivo_ant == '') {
                $valor_aditivo_ant = 0;
            }

            $valor_limite = $valor_total - $rowDados['vl_cotacao'] - $valor_aditivo_ant;

            //Cria Registro
            beginTransaction();

            $numero = $rowDados['codigo'] . '.A' . geraAutoNum(db_pir_grc, 'gec_contratar_credenciado_aditivo_numero_' . $rowDados['codigo'] . '.A', 3);
            $reg_origem = $_SESSION[CS]['g_abrir_sistema_origem'];

            if ($reg_origem == '') {
                $reg_origem = $plu_sigla_interna;
            }

            $sql = 'insert into ' . db_pir_gec . 'gec_contratar_credenciado_aditivo (idt_contratar_credenciado, situacao, idt_responsavel,';
            $sql .= ' idt_usuario_situacao, data_situacao, reg_origem, numero, valor_aditivo_ant, valor_limite) values (';
            $sql .= null($_GET['id']) . ", 'CD', " . null($_SESSION[CS]['g_id_usuario_sistema']['GEC']) . ", ";
            $sql .= null($_SESSION[CS]['g_id_usuario_sistema']['GEC']) . ", now(), " . aspa($reg_origem) . ", " . aspa($numero) . ", ";
            $sql .= null($valor_aditivo_ant) . ", " . null($valor_limite) . ")";
            execsql($sql);
            $tmpIDT = lastInsertId();

            $sql = 'insert into ' . db_pir_gec . 'gec_contratar_credenciado_aditivo_participante (idt_aditivo, idt_atendimento)';
            $sql .= ' select ' . $tmpIDT . ' as idt_aditivo, a.idt as idt_atendimento';
            $sql .= " from " . db_pir_grc . "grc_atendimento a";
            $sql .= " inner join " . db_pir_grc . "grc_evento_participante ep on ep.idt_atendimento = a.idt";
            $sql .= ' where a.idt_evento = ' . null($rowDados['idt_evento']);
            $sql .= " and (ep.contrato is null or ep.contrato <> 'IC')";
            $sql .= " and (ep.ativo is null or ep.ativo = 'S')";
            execsql($sql);

            commit();
        } else {
            $tmpIDT = $rs->data[0][0];
        }

        $_GET['idt0'] = $_GET['id'];
        $_GET['idCad'] = $_GET['id'];
        $_GET['id'] = $tmpIDT;
    }
}

$TabelaPrinc = "gec_contratar_credenciado_aditivo";
$AliasPric = "gec_cca";
$Entidade = "Aditamento";
$Entidade_p = "Aditivos";
$CampoPricPai = "idt_contratar_credenciado";

$tabela = $TabelaPrinc;
$tabela_banco = db_pir_gec;

$id = 'idt';
$barra_bt_top = false;
$formUpload = true;

$onSubmitDep = 'gec_contratar_credenciado_aditivo_dep()';

$pathObjFile = $vetSistemaUtiliza['GEC']['path_file'];

if ($acao == 'inc') {
    $sql = '';
    $sql .= ' select idt';
    $sql .= ' from ' . db_pir_gec . 'gec_contratar_credenciado_aditivo';
    $sql .= ' where idt_contratar_credenciado = ' . null($_GET['idt0']);
    $sql .= " and situacao not in ('CA')";
    $rs = execsql($sql);

    if ($rs->rows > 0) {
        echo '<script type="text/javascript">alert("Não pode incluir um novo registro, pois tem um registro de Aditamento ativo!")</script>';
        echo '<script type="text/javascript">parent.btFechaCTC("' . $_GET['session_cod'] . '");</script>';
        exit();
    }
}

$sql = '';
$sql .= ' select ccd.situacao, ccd.idt_responsavel, cc.idt_gec_contratacao_credenciado_ordem, ord.idt_evento, i.custo_total_real as vl_cotacao,';
$sql .= ' e.idt_instrumento, e.idt_ponto_atendimento, e.idt_unidade, e.idt_gestor_projeto, s.classificacao, ccd.valor_aditivo_ant, ccd.valor_limite,';
$sql .= ' e.idt_gestor_evento, e.idt_responsavel as idt_responsavel_evento, ord.codigo, e.codigo as evento_codigo, ccd.reg_origem,';
$sql .= ' gec_o.codigo as pst_cnpj, gec_o.descricao as pst_nome, usu_o.email as pst_email, usu_o.login as pst_login, ccd.valor_aditivo';
$sql .= ' from ' . db_pir_gec . 'gec_contratar_credenciado_aditivo ccd';
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
    $sql .= ' where idt_contratar_credenciado_aditivo = ' . null($_GET['id']);
    $sql .= ' and idt_responsavel_solucao = ' . null($_SESSION[CS]['g_id_usuario']);
    $sql .= " and ativo = 'S'";
    $sql .= " and tipo = 'Aprovação do Aditamento'";
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

$vetFrm[] = Frame('<span>' . numParte() . ' - INFORMAÇÕES GERAIS DO ADITAMENTO</span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);

$vetParametros = Array(
    'codigo_pai' => 'parte00',
);

$vetCampo[$CampoPricPai] = objHidden($CampoPricPai, $_GET['idt0']);
$vetCampo['idt_responsavel'] = objFixoBanco('idt_responsavel', 'Responsavel pela Solicitação', db_pir_gec . 'plu_usuario', 'id_usuario', 'nome_completo');
$vetCampo['data_registro'] = objTextoFixo('data_registro', 'Data Registro', '', true);
$vetCampo['numero'] = objAutoNum('numero', 'Número', 17, true, 3, $rowDados['codigo'] . '.A');

//$vetCampo['tipo'] = objCmbVetor('tipo', 'Tipo?', true, $vetTipoAditivo);
$vetCampo['tipo'] = objFixoVetor('tipo', 'Tipo?', True, $vetTipoAditivo, ' ', '', '', '', 'P');

$vetCampo['valor_aditivo'] = objTextoFixo('valor_aditivo', 'Valor Total do Aditamento (R$)', '', true);
$vetCampo['situacao'] = objFixoVetor('situacao', 'Situação', True, $vetSituacaoDistratoAditivo);
$vetCampo['valor_contrato'] = objTextoFixo('valor_contrato', 'Valor do Contrato (R$)', '', false, false, format_decimal($rowDados['vl_cotacao']));
//$vetCampo['valor_aditivo_ant'] = objTextoFixo('valor_aditivo_ant', 'Valor dos Aditivos anteriores(R$)', '', false, false, format_decimal($rowDados['valor_aditivo_ant']));
$vetCampo['valor_limite'] = objTextoFixo('valor_limite', 'Valor Limite do Aditamento (R$)', '', false, false, format_decimal($rowDados['valor_limite']));

MesclarCol($vetCampo[$CampoPricPai], 7);
MesclarCol($vetCampo['situacao'], 3);

$vetFrm[] = Frame('', Array(
    Array($vetCampo[$CampoPricPai]),
    Array($vetCampo['idt_responsavel'], '', $vetCampo['data_registro'], '', $vetCampo['situacao']),
    Array($vetCampo['numero'], '', $vetCampo['tipo'], '', $vetCampo['valor_aditivo']),
    Array($vetCampo['valor_contrato'], '', $vetCampo['valor_aditivo_ant'], '', $vetCampo['valor_limite']),
        ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);

$vetParametros['width'] = '100%';

$vetCampo['observacao'] = objHtml('observacao', 'Motivo do Aditamento', true, 320, '100%');

$vetFrm[] = Frame('', Array(
    Array($vetCampo['observacao']),
        ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);

$vetParametros = Array(
    'codigo_frm' => 'parte02',
    'controle_fecha' => 'A',
);

$vetFrm[] = Frame('<span>' . numParte() . ' - ANEXOS DO ADITAMENTO DA CONTRATAÇÃO</span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);

$vetParametros = Array(
    'codigo_pai' => 'parte02',
    'width' => '100%',
);

//Anexos do Aditamento
$vetCampoLC = Array();
$vetCampoLC['data_registro'] = CriaVetTabela('Data Registro', 'data');
$vetCampoLC['titulo'] = CriaVetTabela('Título do Anexo');
$vetCampoLC['arquivo'] = CriaVetTabela('Arquivo', 'func_trata_dado', fnc_gec_contratar_credenciado_aditivo_anexos);
$vetCampoLC['responsavel'] = CriaVetTabela('Responsável');

$titulo = 'Anexos do Aditamento da Contratação';

$sql = '';
$sql .= ' select gec_ccda.*,';
$sql .= ' plu_usu.nome_completo as responsavel ';
$sql .= ' from ' . db_pir_gec . 'gec_contratar_credenciado_aditivo_anexos gec_ccda ';
$sql .= ' inner join ' . db_pir_gec . 'plu_usuario plu_usu on plu_usu.id_usuario = gec_ccda.idt_responsavel ';
$sql .= ' where idt_aditivo = $vlID';
$sql .= ' order by data_registro';

$vetParametrosLC = Array(
    'func_trata_row' => ftr_gec_contratar_credenciado_aditivo_anexos,
    'acao_alt_con_p' => $acao_alt_con_p,
);

$vetCampo['gec_contratar_credenciado_aditivo_anexos'] = objListarConf('gec_contratar_credenciado_aditivo_anexos', 'idt', $vetCampoLC, $sql, $titulo, false, $vetParametrosLC);

$vetFrm[] = Frame('', Array(
    Array($vetCampo['gec_contratar_credenciado_aditivo_anexos']),
        ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);

$vetParametros = Array(
    'codigo_frm' => 'parteEntrega',
    'controle_fecha' => 'A',
);

$vetFrm[] = Frame('<span>' . numParte() . ' - ENTREGAS DA CONTRATAÇÃO</span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);

$vetParametros = Array(
    'codigo_pai' => 'parteEntrega',
    'width' => '100%',
);

$vetCampoLC = Array();
$vetCampoLC['pessoa'] = CriaVetTabela('Cliente');
$vetCampoLC['codigo'] = CriaVetTabela('Código');
$vetCampoLC['descricao'] = CriaVetTabela('Atividade');
$vetCampoLC['mesano'] = CriaVetTabela('Mês/Ano', 'func_trata_dado', ftd_gec_contratacao_credenciado_ordem_entrega);
$vetCampoLC['percentual'] = CriaVetTabela('Percentual', 'decimal');
$vetCampoLC['vl_entrega_real'] = CriaVetTabela('Vl. Cotação', 'func_trata_dado', ftd_gec_contratacao_credenciado_ordem_entrega);
$vetCampoLC['situacao_reg'] = CriaVetTabela('Financeiro', 'func_trata_dado', ftd_gec_contratacao_credenciado_ordem_entrega);
$vetCampoLC['valor'] = CriaVetTabela('Vl. Aditado', 'func_trata_dado', ftd_gec_contratacao_credenciado_ordem_entrega);
$vetCampoLC['data'] = CriaVetTabela('Prazo Aditado', 'func_trata_dado', ftd_gec_contratacao_credenciado_ordem_entrega);

$titulo = 'Entregas';

$sql = "select orde.*,";
$sql .= " concat_ws('<br />', grc_atpe.cpf, grc_atpe.nome) as pessoa,";
$sql .= ' afp.situacao_reg, afp.gfi_situacao, afp.liquidado, ccae.valor, ccae.data,';
$sql .= ' orde.idt as idt_gec_contratacao_credenciado_ordem_entrega';
$sql .= " from " . db_pir_gec . "gec_contratacao_credenciado_ordem_entrega orde";
$sql .= " left outer join " . db_pir_grc . "grc_atendimento_pessoa grc_atpe on grc_atpe.tipo_relacao = 'L' and grc_atpe.idt_atendimento = orde.idt_atendimento";
$sql .= " left outer join " . db_pir_gec . "gec_contratacao_credenciado_ordem_rm rm on";
$sql .= " rm.idt_gec_contratacao_credenciado_ordem = orde.idt_gec_contratacao_credenciado_ordem";
$sql .= " and rm.rm_cancelado = 'N'";
$sql .= " and rm.mesano = orde.mesano";
$sql .= " left outer join " . db_pir_pfo . "pfo_af_processo afp on afp.idmov = rm.rm_idmov";
$sql .= " left outer join " . db_pir_gec . "gec_contratar_credenciado_aditivo_entrega ccae on";
$sql .= " ccae.idt_gec_contratacao_credenciado_ordem_entrega = orde.idt";
$sql .= " and ccae.idt_aditivo = " . null($_GET['id']);
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
    /*
     * Removido ate fazer o aditivo por valor
      $vetParametros = Array(
      'codigo_frm' => 'partePAR',
      'controle_fecha' => 'A',
      );

      $vetFrm[] = Frame('<span>' . numParte() . ' - ADITAMENTO COM O CLIENTE</span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);

      $vetParametros = Array(
      'codigo_pai' => 'partePAR',
      'width' => '100%',
      );

      if ($rowDados['situacao'] == 'CD' || $rowDados['situacao'] == 'DE' || $rowDados['situacao'] == 'RE') {
      calculaValorAditivoParticipante($_GET['id'], $rowDados['valor_aditivo']);
      }

      $vetCampoLC = Array();
      $vetCampoLC['empreendimento'] = CriaVetTabela('Protocolo');
      $vetCampoLC['vl_aditivo'] = CriaVetTabela('Valor do Aditamento (R$)', 'decimal');
      $vetCampoLC['vl_tot_pagamento'] = CriaVetTabela('Valor do Pago (R$)', 'decimal');

      $titulo = 'Aditamento com a Cliente';

      $sql = '';
      $sql .= " select ap.*,";
      $sql .= " concat_ws('<br />', a.protocolo, o.razao_social, o.cnpj) as empreendimento";
      $sql .= ' from ' . db_pir_gec . 'gec_contratar_credenciado_aditivo_participante ap';
      $sql .= " inner join " . db_pir_grc . "grc_atendimento a on a.idt = ap.idt_atendimento";
      $sql .= " left outer join " . db_pir_grc . "grc_atendimento_organizacao o on o.idt_atendimento = ap.idt_atendimento";
      $sql .= ' where ap.idt_aditivo = $vlID';

      $vetParametrosLC = Array(
      'contlinfim' => '',
      'acao_alt_con_p' => $acao_alt_con_p,
      );

      $vetCampo['gec_contratar_credenciado_aditivo_participante'] = objListarConf('gec_contratar_credenciado_aditivo_participante', 'idt', $vetCampoLC, $sql, $titulo, false, $vetParametrosLC);

      $vetFrm[] = Frame('', Array(
      Array($vetCampo['gec_contratar_credenciado_aditivo_participante']),
      ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);
     */

    $vetParametros = Array(
        'codigo_frm' => 'parte03',
        'controle_fecha' => 'A',
    );

    $vetFrm[] = Frame('<span>' . numParte() . ' - PARECERES DO ADITAMENTO DA CONTRATAÇÃO</span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);

    $vetParametros = Array(
        'codigo_pai' => 'parte03',
        'width' => '100%',
    );

    $vetCampoLC = Array();
    $vetCampoLC['data_registro'] = CriaVetTabela('Data Registro', 'data');
    $vetCampoLC['descricao'] = CriaVetTabela('Título do Parecer');
    $vetCampoLC['responsavel'] = CriaVetTabela('Responsável');

    $titulo = 'Pareceres do Aditamento da Contratação';

    $sql = '';
    $sql .= ' select gec_ccdp.*, ';
    $sql .= ' plu_usu.nome_completo as responsavel ';
    $sql .= ' from ' . db_pir_gec . 'gec_contratar_credenciado_aditivo_parecer gec_ccdp ';
    $sql .= ' inner join ' . db_pir_gec . 'plu_usuario plu_usu on plu_usu.id_usuario = gec_ccdp.idt_responsavel ';
    $sql .= ' where idt_aditivo = $vlID';
    $sql .= ' order by data_registro';

    $vetParametrosLC = Array(
        'contlinfim' => '',
        'acao_alt_con_p' => $acao_alt_con_p,
    );

    $vetCampo['gec_contratar_credenciado_aditivo_parecer'] = objListarConf('gec_contratar_credenciado_aditivo_parecer', 'idt', $vetCampoLC, $sql, $titulo, false, $vetParametrosLC);

    $vetFrm[] = Frame('', Array(
        Array($vetCampo['gec_contratar_credenciado_aditivo_parecer']),
            ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);

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
}


if ($rowDados['situacao'] == 'AP' || $rowDados['situacao'] == 'AS') {
    $vetParametros = Array(
        'codigo_frm' => 'partepdf',
        'controle_fecha' => 'A',
    );

    $vetFrm[] = Frame('<span>' . numParte() . ' - ADITAMENTO PARA ASSINAR</span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);

    $vetParametros = Array(
        'codigo_pai' => 'partepdf',
        'width' => '100%',
    );

    $vetCampoLC = Array();
    $vetCampoLC['origem'] = CriaVetTabela('Origem');
    $vetCampoLC['empreendimento'] = CriaVetTabela('Nome do Empreendimento / CNPJ', 'func_trata_dado', fnc_gec_contratar_credenciado_aditivo_pdf);
    $vetCampoLC['data_registro'] = CriaVetTabela('Data Registro', 'data');
    $vetCampoLC['arq_aditivo'] = CriaVetTabela('Aditamento para Assinar', 'func_trata_dado', fnc_gec_contratar_credenciado_aditivo_pdf);
    $vetCampoLC['arq_aditivo_ass'] = CriaVetTabela('Aditamento Assinado', 'func_trata_dado', fnc_gec_contratar_credenciado_aditivo_pdf);
    $vetCampoLC['data_upload'] = CriaVetTabela('Data Upload', 'data');
    $vetCampoLC['responsavel_upload'] = CriaVetTabela('Responsável do Upload');

    $titulo = 'Aditamento para Assinar';

    $sql = '';
    $sql .= ' select pdf.*, plu_usu.nome_completo as responsavel_upload,';
    $sql .= " if(a.protocolo is null, 'PST', 'Cliente') as origem,";
    $sql .= " concat_ws('<br />', a.protocolo, o.razao_social, o.cnpj) as empreendimento";
    $sql .= ' from ' . db_pir_gec . 'gec_contratar_credenciado_aditivo_pdf pdf ';
    $sql .= " left outer join " . db_pir_grc . "grc_atendimento a on a.idt = pdf.idt_atendimento";
    $sql .= " left outer join " . db_pir_grc . "grc_atendimento_organizacao o on o.idt_atendimento = a.idt";
    $sql .= ' left outer join ' . db_pir_gec . 'plu_usuario plu_usu on plu_usu.id_usuario = pdf.idt_usuario_upload ';
    $sql .= ' where pdf.idt_aditivo = $vlID';

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

    $vetCampo['gec_contratar_credenciado_aditivo_pdf'] = objListarConf('gec_contratar_credenciado_aditivo_pdf', 'idt', $vetCampoLC, $sql, $titulo, false, $vetParametrosLC);

    $vetFrm[] = Frame('', Array(
        Array($vetCampo['gec_contratar_credenciado_aditivo_pdf']),
            ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);
}

$vetCampo['gec_contratar_credenciado_aditivo_bt'] = objInclude('gec_contratar_credenciado_aditivo_bt', 'cadastro_conf/gec_contratar_credenciado_aditivo_bt.php');
$vetCampo['situacao_ant'] = objHidden('situacao_ant', $rowDados['situacao'], '', '', false);
$vetCampo['bt_salva'] = objHidden('bt_salva', '', '', '', false);
$vetCampo['idt_usuario_situacao'] = objHidden('idt_usuario_situacao', $_SESSION[CS]['g_id_usuario_sistema']['GEC']);
$vetCampo['data_situacao'] = objHidden('data_situacao', getdata(true, true, true));

$vetFrm[] = Frame('', Array(
    Array($vetCampo['gec_contratar_credenciado_aditivo_bt']),
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
        $('#tipo').change(function () {
            switch ($('#tipo').val()) {
                case 'T':
                    $('input.entrega_valor').removeProp("disabled").removeClass("campo_disabled");
                    $('input.entrega_data').removeProp("disabled").removeClass("campo_disabled");
                    break;

                case 'P':
                    $("input.entrega_valor").prop("disabled", true).addClass("campo_disabled").val('');
                    $('input.entrega_data').removeProp("disabled").removeClass("campo_disabled");
                    break;

                case 'V':
                    $('input.entrega_valor').removeProp("disabled").removeClass("campo_disabled");
                    $("input.entrega_data").prop("disabled", true).addClass("campo_disabled").val('');
                    break;

                default:
                    $("input.entrega_valor").prop("disabled", true).addClass("campo_disabled").val('');
                    $("input.entrega_data").prop("disabled", true).addClass("campo_disabled").val('');
                    break;
            }
        });

        $('#tipo').change();

        $('input.entrega_valor').blur(function () {
            money(this);

            var obj_valor = $(this);
            var valor = str2float(obj_valor.val());
            var vl_atu = str2float(obj_valor.data('valor'));

            if (isNaN(valor)) {
                valor = '';
            }

            if (isNaN(vl_atu)) {
                vl_atu = 0;
            }

            if (valor != '') {
                if (valor < 0) {
                    alert("O Vl. Aditado não pode ser negativo!");
                    obj_valor.data('valant', '');
                    obj_valor.val('');
                    obj_valor.focus();
                    calculaValor(true, obj_valor);
                    return false;

                }
            }

            if (valor != obj_valor.data('valant')) {
                calculaValor(true, obj_valor);
            }

            obj_valor.data('valant', valor);
        });

        $('input.entrega_data').blur(function () {
            checkdate(this);

            if ($(this).val() !== '') {
                if (validaDataMaiorStr(false, $(this), 'Prazo Aditado', $(this).data('valor'), 'Data da Entrega', false, '') === false) {
                    return false;
                }
            }
        });

        if (situacao == 'RE') {
            if (acao == 'alt') {
                setTimeout(function () {
                    $('#conclusao').removeProp("disabled").removeClass("campo_disabled");
                }, 500);

                setTimeout(function () {
                    $('#conclusao').removeProp("disabled").removeClass("campo_disabled");
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

        if ('<?php echo $_SESSION[CS]['g_abrir_sistema_origem']; ?>' != 'GRC' && '<?php echo $_SESSION[CS]['g_abrir_sistema_origem']; ?>' != '') {
            setTimeout(function () {
                TelaHeight();
            }, 500);

            setTimeout(function () {
                TelaHeight();
            }, 2000);
        }
    });

    function calculaValor(display, obj_valor) {
        if (display) {
            processando();
        }

        var valor_aditivo = 0;
        var valor_limite = <?php echo $rowDados['valor_limite']; ?>;

        $('#gec_contratacao_credenciado_ordem_entrega_desc input.entrega_valor').each(function () {
            if ($(this).val() !== '') {
                valor_aditivo += str2float($(this).val());
            }
        });

        if (valor_aditivo > valor_limite) {
            if (display) {
                $('#dialog-processando').remove();
            }

            alert("O Valor Total do Aditamento não pode ser maior que o Valor Limite Aditamento!");

            if (obj_valor !== null) {
                obj_valor.val('');
                obj_valor.focus();
            }

            return false;
        }

        valor_aditivo = float2str(valor_aditivo);

        $('#valor_aditivo').val(valor_aditivo);
        $('#valor_aditivo_fix').html(valor_aditivo);

        $.ajax({
            dataType: 'json',
            type: 'POST',
            url: ajax_sistema + '?tipo=calculaValorAditivoParticipante',
            data: {
                cas: conteudo_abrir_sistema,
                idt_aditivo: '<?php echo $_GET['id']; ?>',
                valor_aditivo: valor_aditivo
            },
            success: function (response) {
                btFechaCTC($('#gec_contratar_credenciado_aditivo_participante').data('session_cod'));

                if (response.erro != '') {
                    alert(url_decode(response.erro));
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert('Erro no ajax no: ' + textStatus + ' - ' + errorThrown);
            },
            async: false
        });

        if (display) {
            $('#dialog-processando').remove();
        }

        return true;
    }

    function gec_contratar_credenciado_aditivo_dep() {
        if (valida == 'S') {
            var OK = true;
            var temValor = false;

            if (OK && ($('#tipo').val() == 'P' || $('#tipo').val() == 'T')) {
                temValor = false;

                $('#gec_contratacao_credenciado_ordem_entrega_desc input.entrega_data').each(function () {
                    if ($(this).val() != '') {
                        temValor = true;
                    }
                });

                if (!temValor) {
                    alert('Favor informar algum campo do Prazo Aditado!');
                    OK = false;
                }
            }

            if (OK && ($('#tipo').val() == 'V' || $('#tipo').val() == 'T')) {
                temValor = false;

                $('#gec_contratacao_credenciado_ordem_entrega_desc input.entrega_valor').each(function () {
                    if ($(this).val() != '') {
                        temValor = true;
                    }
                });

                if (!temValor) {
                    alert('Favor informar algum campo do Vl. Aditado!');
                    OK = false;
                }
            }

            if (OK) {
                processando();

                OK = calculaValor(false, null);

                if (OK) {
                    $.ajax({
                        dataType: 'json',
                        type: 'POST',
                        url: ajax_sistema + '?tipo=gec_contratar_credenciado_aditivo_dep',
                        data: {
                            cas: conteudo_abrir_sistema,
                            idt_aditivo: '<?php echo $_GET['id']; ?>'
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
                }

                $('#dialog-processando').remove();
            }

            return OK;
        }

        return true;
    }
</script>
