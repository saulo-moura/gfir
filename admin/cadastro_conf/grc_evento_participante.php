<style type="text/css">
    .Barra {
        display: none;
    }

    .none {
        display: none;
    }

    #idt_instrumento_obj {
        width:100%;
        height: 28px;
        overflow: hidden;
        display: block;
    }

    #idt_instrumento_tf {
        text-align:center;
        font-size:2em;
        background:#2C3E50;
        color:#FFFFFF;
        font-weight:bold;
        font-family: Lato Regular, Calibri, Arial,  Helvetica, sans-serif;
    }

    #gerar_voucher_a_tf {
        width: 50px;
    }

    #gerar_voucher_e_tf {
        width: 50px;
    }

    #legenda {
        margin: 10px;
    }

    #legenda > span {
        display: inline-block;
        margin: 0px 10px;
        color: black;
        font-weight: bold;
    }

    #legenda img {
        vertical-align: middle;
        padding-right: 5px;
    }
</style>
<?php
$getORG = $_GET;

if (count($_POST) == 0) {
    $sql = '';
    $sql .= ' select a.idt_atendimento_pai';
    $sql .= ' from grc_atendimento_pessoa p';
    $sql .= ' inner join grc_atendimento a on a.idt = p.idt_atendimento';
    $sql .= ' where p.idt = ' . null($_GET['id']);
    $rs = execsql($sql);
    $row = $rs->data[0];

    if ($row['idt_atendimento_pai'] != '') {
        $sql = '';
        $sql .= ' select p.idt, a.idt_evento';
        $sql .= ' from grc_atendimento a';
        $sql .= ' inner join grc_atendimento_pessoa p on p.idt_atendimento = a.idt';
        $sql .= ' where a.idt = ' . null($row['idt_atendimento_pai']);
        $sql .= ' and a.idt_instrumento = 54';
        $sql .= " and p.tipo_relacao = 'L'";
        $rs = execsql($sql);

        if ($rs->rows > 0) {
            $row = $rs->data[0];

            $_GET['idCad'] = $row['idt_evento'];
            $_GET['id'] = $row['idt'];
            $_GET['idt_instrumento'] = 54;
            $_GET['valor_inscricao'] = '';
            $_GET['veio'] = '';
            $_GET['idt_produto'] = '';
            $_GET['gratuito'] = 'N';
        }
    }
}

$veio = $_GET['veio'];

if ($_GET['idt_instrumento'] == 54) {
    $origem_evento_tela = 'combo';
} else {
    $origem_evento_tela = '';
}
/*
  p($getORG);
  if ($_GET['instrumento']=='')
  {
  $_GET['instrumento']=40;
  $veio="GC";
  $_GET['veio']="GC";
  $_GET['gratuito']="N";
  $instrumento=40;

  }
  $getORG = $_GET;
  p($getORG);
 */

$acaoOrg = $acao;
$altPag = false;
$bt_alterar_lbl = 'Salvar Inscrição';

if (filadeespera == 'S' && $acao == 'inc') {
    $sql = '';
    $sql .= ' select quantidade_participante as qtd, qtd_matriculado_siacweb + qtd_vagas_resevado + qtd_vagas_bloqueadas as tot';
    $sql .= ' from grc_evento';
    $sql .= " where idt = " . null($_GET['idCad']);
    $rsVaga = execsql($sql);
    $rowVaga = $rsVaga->data[0];

    if ($rowVaga['qtd'] != '') {
        if ($rowVaga['tot'] < $rowVaga['qtd']) {
            echo '<script type="text/javascript">';
            echo 'alert("Não pode fazer a inscrição na Fila de Espera, pois o Evento ainda tem mais vagas disponíveis!");';
            echo 'parent.btFechaCTC("' . $_GET['session_cod'] . '");';
            echo '</script>';
            onLoadPag();

            die();
        }
    }
}

if ($_POST['btnAcao'] == $bt_excluir_lbl && $acao == 'exc' && $veio != 'SG' && filadeespera != 'S') {
    $_POST['btnAcao'] = $bt_alterar_lbl;
    $acao = 'alt';
    $_GET['acao'] = $acao;
}

if ($_GET['idCad'] != '') {
    $_GET['idt0'] = $_GET['idCad'];
    $botao_volta = "btAcaoVoltar()";

    if ($_GET['idt_instrumento'] == 54) {
        $botao_acao = '<script type="text/javascript">parent.btFechaCTC("' . $_GET['session_cod'] . '", parent.funcaoFechaCTC_grc_evento_participante_combo);</script>';
    } else if ($veio == 'SG' || $_GET['idt_instrumento'] == 2) {
        $botao_acao = '<script type="text/javascript">parent.btFechaCTC("' . $_GET['session_cod'] . '", parent.funcaoFechaCTC_grc_evento_participante);</script>';
    } else {
        $botao_acao = '<script type="text/javascript">parent.btFechaCTC("' . $_GET['session_cod'] . '");</script>';
    }
}

if ($_POST['volta_cad'] == 'S') {
    $botao_acao = '<script type="text/javascript">self.location = "' . $_SESSION[CS]['grc_evento_participante_volta_cad'] . '";</script>';
} else if ($_POST['bt_acao_insc'] == '') {
    $_SESSION[CS]['grc_evento_participante_volta_cad'] = 'conteudo_cadastro.php?' . $_SERVER['QUERY_STRING'];
}

if ($_POST['id'] == '') {
    $sql = '';
    $sql .= ' select idt_atendimento, tipo_relacao';
    $sql .= ' from grc_atendimento_pessoa';
    $sql .= ' where idt = ' . null($_GET['id']);
    $rs = execsql($sql);
    $tipo_relacao = $rs->data[0]['tipo_relacao'];
    $idt_atendimento_pessoa = $_GET['id'];

    $_GET['id'] = $rs->data[0]['idt_atendimento'];
} else {
    $sql = '';
    $sql .= ' select idt, tipo_relacao';
    $sql .= ' from grc_atendimento_pessoa';
    $sql .= ' where idt_atendimento = ' . null($_GET['id']);
    $sql .= " and tipo_relacao = 'L'";
    $rs = execsql($sql);
    $tipo_relacao = $rs->data[0]['tipo_relacao'];
    $idt_atendimento_pessoa = $rs->data[0]['idt'];
}

if ($_GET['id'] == '') {
    $_GET['id'] = 0;
}

$idt_evento = $_GET['idt0'];

if ($_GET['mudou_cpf'] == 'S') {
    //Entregas
    $sql = '';
    $sql .= ' select idt';
    $sql .= ' from grc_evento_entrega';
    $sql .= ' where idt_atendimento = ' . null($_GET['id']);
    $sql .= ' limit 1';
    $rs = execsql($sql);

    if ($rs->rows == 0) {
        $sql = '';
        $sql .= ' select idt, codigo, descricao, detalhe, percentual, ordem';
        $sql .= ' from grc_produto_entrega';
        $sql .= ' where idt_produto = ' . null($_GET['idt_produto']);
        $rs = execsql($sql);

        foreach ($rs->data as $row) {
            $sql = '';
            $sql .= ' insert into grc_evento_entrega (idt_evento, idt_atendimento, codigo, descricao, detalhe, percentual, ordem) values (';
            $sql .= null($idt_evento) . ', ' . null($_GET['id']) . ', ' . aspa($row['codigo']) . ', ' . aspa($row['descricao']) . ', ' . aspa($row['detalhe']) . ', ';
            $sql .= aspa($row['percentual']) . ', ' . aspa($row['ordem']) . ')';
            execsql($sql);
            $idt_evento_entrega = lastInsertId();

            $sql = '';
            $sql .= ' insert into grc_evento_entrega_documento (idt_evento_entrega, idt_documento, codigo)';
            $sql .= ' select ' . $idt_evento_entrega . ' as idt_evento_entrega, idt_documento, codigo';
            $sql .= ' from grc_produto_entrega_documento';
            $sql .= ' where idt_produto_entrega = ' . null($row['idt']);
            execsql($sql);
        }
    }

    //Dimensionamento
    $sql = '';
    $sql .= ' select idt';
    $sql .= ' from grc_evento_dimensionamento';
    $sql .= ' where idt_atendimento = ' . null($_GET['id']);
    $sql .= ' limit 1';
    $rs = execsql($sql);

    if ($rs->rows == 0) {
        $sql = '';
        $sql .= ' insert into grc_evento_dimensionamento (idt_evento, idt_atendimento, idt_insumo_dimensionamento, codigo, descricao, detalhe, idt_insumo_unidade, vl_unitario, qtd, vl_total)';
        $sql .= ' select ' . $idt_evento . ' as idt_evento, ' . $_GET['id'] . ' as idt_atendimento, idt_insumo_dimensionamento, codigo, descricao, detalhe, idt_insumo_unidade, vl_unitario, 0 as qtd, 0 as vl_total';
        $sql .= ' from grc_produto_dimensionamento';
        $sql .= ' where idt_produto = ' . null($_GET['idt_produto']);
        execsql($sql);
    }
}

$sql = '';
$sql .= ' select idt';
$sql .= ' from grc_atendimento_pessoa';
$sql .= ' where idt_atendimento = ' . null($_GET['id']);
$sql .= " and tipo_relacao = 'L'";
$rs = execsql($sql);
$idt_atendimento_pessoa_lider = $rs->data[0][0];

$sql = '';
$sql .= ' select a.evento_origem, a.idt_atendimento_pai, e.gratuito, e.idt_evento_situacao, e.idt, e.composto, e.sgtec_modelo, e.vl_determinado, p.vl_teto';
$sql .= ' from grc_atendimento a';
$sql .= ' inner join grc_evento e on a.idt_evento = e.idt';
$sql .= ' left outer join grc_produto p on e.idt_produto = p.idt';
$sql .= ' where a.idt = ' . null($_GET['id']);
$rs = execsql($sql);
$row = $rs->data[0];

$evento_origem = $row['evento_origem'];
$idt_evento_situacao = $row['idt_evento_situacao'];
$sgtec_modelo = $row['sgtec_modelo'];
$vl_determinado = $row['vl_determinado'];
$composto = $row['composto'];
$vl_teto = $row['vl_teto'];

define('idt_evento_situacao', $idt_evento_situacao);

if ($row['idt'] != $idt_evento && $rs->rows > 0) {
    erro_try('Erro na consulta da Matricula! Favor consultar novamente.', 'grc_evento_participante', $getORG);

    echo '<script type="text/javascript">';
    echo 'alert("Erro na consulta da Matricula! Favor consultar novamente.");';
    echo 'parent.btFechaCTC("' . $_GET['session_cod'] . '");';
    echo '</script>';
    onLoadPag();

    die();
}

if ($origem_evento_tela == 'combo' && $_GET['id'] == 0) {
    $sql = '';
    $sql .= ' select combo_dt_validade';
    $sql .= ' from grc_evento';
    $sql .= ' where idt = ' . null($idt_evento);
    $rs = execsql($sql);
    $row = $rs->data[0];

    if (diffDate(trata_data($row['combo_dt_validade']), date('d/m/Y')) > 0) {
        echo '<script type="text/javascript">';
        echo 'alert("Não pode fazer a Matricula no Combo, pois não esta mais válido! (Válido até ' . trata_data($row['combo_dt_validade']) . ')");';
        echo 'parent.btFechaCTC("' . $_GET['session_cod'] . '");';
        echo '</script>';
        onLoadPag();

        die();
    }
}

if ($row['idt_atendimento_pai'] != '') {
    $_GET['acao'] = 'con';
    $acao = 'con';
    alert('Este registro pertence a uma Matricula de um Combo! Com isso só pode consultar!');
}

$gratuito = $_GET['gratuito'];

if ($gratuito == '') {
    $gratuito = $rs->data[0]['gratuito'];
}

checaMatFEprazo($idt_evento);

$sql = '';
$sql .= ' select contrato, fe_situacao, fe_dt_validade, motivo_cancelamento, motivo_cancelamento_md5';
$sql .= ' from grc_evento_participante';
$sql .= ' where idt_atendimento = ' . null($_GET['id']);
$rs = execsql($sql);
$rowDados = $rs->data[0];
$situacao_contrato = $rowDados['contrato'];

if (filadeespera != 'S' && $rowDados['contrato'] == 'FE' && $rowDados['fe_situacao'] == 'QP') {
    echo '<script type="text/javascript">';
    echo 'alert("Não pode efetuar esta matrícula, pois expirou o prazo! Prazo: ' . trata_data($rowDados['fe_dt_validade'], true) . '");';
    echo "parent.btFechaCTC(parent.$('#grc_evento_participante_filaespera').data('session_cod'));";
    echo 'parent.btFechaCTC("' . $_GET['session_cod'] . '");';
    echo '</script>';
    onLoadPag();

    die();
}

if ($situacao_contrato == '') {
    if ($gratuito == 'S') {
        $situacao_contrato = 'G';
    } else {
        $situacao_contrato = 'R';
    }
}

if ($veio == 'SG' && $sgtec_modelo == 'H') {
    $situacao_contrato = 'G';
}

if (filadeespera == "S") {
    $situacao_contrato = 'FE';
}

if ($situacao_contrato != 'R' && $situacao_contrato != 'G' && $situacao_contrato != 'FE') {
    $acao_alt_con = 'S';
}

if ($evento_origem == 'SIACWEB' && $acao != 'con') {
    $acao_alt_con = 'S';
    $_GET['acao'] = 'con';
    $acao = 'con';
    alert('Não pode alterar este inscrição, pois ela veio do SiacWeb');
}

if ($acao_alt_con_p == 'SG') {
    $acao_alt_con = 'S';
    $altPag = true;
    $_GET['acao'] = 'con';
    $acao = 'con';
    alert('Evento já aprovado, com isso só pode alterar o Resumo de Pagamento que não estão sincronizados com o RM!');
}

if ($idt_evento_situacao == 8 || ($idt_evento_situacao == 24 && $sgtec_modelo == 'H')) {
    $acao_alt_con = 'S';
    $altPag = true;

    if (!($situacao_contrato == 'R' || $situacao_contrato == 'A' || $situacao_contrato == 'C')) {
        $_GET['acao'] = 'con';
        $acao = 'con';
    }
}

$onSubmitDep = 'grc_evento_participante_dep()';
$barra_bt_top = false;

$TabelaPai = "grc_evento";
$AliasPai = "grc_eve";
$EntidadePai = "Evento";
$idPai = "idt";

$TabelaPrinc = "grc_atendimento";
$AliasPric = "grc_at";
$Entidade = "Inscrição";
$Entidade_p = "Inscrição";
$CampoPricPai = "idt_evento";

$tabela = $TabelaPrinc;

$class_frame_f = "class_frame_f";
$class_titulo_f = "class_titulo_f";
$class_frame_p = "class_frame_p";
$class_titulo_p = "class_titulo_p";
$class_frame = "class_frame";
$class_titulo = "class_titulo";
$titulo_na_linha = false;

$id = 'idt';
$vetFrm = Array();

$vetParametros = Array(
    'width' => '100%',
);

$vetCampo['idt_instrumento'] = objFixoBanco('idt_instrumento', '', 'grc_atendimento_instrumento', 'idt', 'descricao', 'idt_instrumento');

$vetFrm[] = Frame('', Array(
    Array($vetCampo['idt_instrumento']),
        ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);

$vetCampo[$CampoPricPai] = objHidden($CampoPricPai, $_GET['idt0']);
$vetCampo['volta_cad'] = objHidden('volta_cad', '', '', '', false);

$vetFrm[] = Frame('', Array(
    Array($vetCampo[$CampoPricPai]),
    Array($vetCampo['volta_cad']),
        ), $class_frame . ' none', $class_titulo, $titulo_na_linha, $vetParametros);

//Mostra se esta vinculado a um evento combo
if ($_GET['id'] == 0) {
    $sql = '';
    $sql .= ' select e.idt, e.codigo, e.descricao, e.combo_qtd_evento_insc, e.idt_instrumento, e.combo_dt_validade, e.combo_vl_tot_matricula, e.combo_percentual_desc';
    $sql .= ' from grc_evento_combo ec';
    $sql .= ' inner join grc_evento e on e.idt = ec.idt_evento_origem';
    $sql .= ' where ec.idt_evento = ' . null($_GET['idt0']);
    $sql .= " and e.publica_internet = 'S'";
    $sql .= " and e.idt_evento_situacao = 15";
    $sql .= ' and e.combo_dt_validade >= ' . aspa(trata_data(date('d/m/Y')));
    $sql .= ' order by e.codigo';
    $rsEC = execsql($sql);

    if ($rsEC->rows > 0) {
        $vetCampoLC = Array();
        $vetCampoLC['codigo'] = CriaVetTabela('Código');
        $vetCampoLC['descricao'] = CriaVetTabela('Evento');
        $vetCampoLC['combo_qtd_evento_insc'] = CriaVetTabela('Quantidade Total de Eventos do Combo');
        $vetCampoLC['combo_dt_validade'] = CriaVetTabela('Data Validade do Combo', 'data');
        $vetCampoLC['combo_vl_tot_matricula'] = CriaVetTabela('Somatório das Inscrições no Combo', 'decimal');
        $vetCampoLC['combo_percentual_desc'] = CriaVetTabela('Desconto (%)', 'decimal');

        $titulo = 'Combo';

        $vetParametrosLC = Array(
            'barra_inc_ap' => false,
            'barra_alt_ap' => false,
            'barra_con_ap' => true,
            'barra_exc_ap' => false,
            'mostra_tabela' => true,
            'menu_acesso' => 'grc_evento',
            'func_botao_per' => fbp_grc_evento_participante,
        );

        $vetCampo['grc_evento_combo_cad'] = objListarConf('grc_evento_combo_cad', 'idt', $vetCampoLC, $sql, $titulo, true, $vetParametrosLC);

        $vetFrm[] = Frame('<span>Este evento faz parte de um Evento Combo, a sua incrição no Combo pode ser mais vantajoso para o Cliente!</span>', Array(
            Array($vetCampo['grc_evento_combo_cad']),
                ), $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);
    }
}

//Utiliza o Voucher
$idt_evento_publicacao_voucher_utilizado = '';
$voucher_utilizado = '';

if ($_GET['id'] == 0) {
    $sql = '';
    $sql .= ' select vr.idt_evento_publicacao_voucher';
    $sql .= ' from grc_evento_publicacao_voucher_registro vr';
    $sql .= " inner join grc_evento_publicacao_voucher v on v.idt = vr.idt_evento_publicacao_voucher";
    $sql .= " inner join grc_evento_publicacao ep on ep.idt = vr.idt_evento_publicacao";
    $sql .= ' where ep.idt_evento = ' . null($idt_evento);
    $sql .= " and ep.situacao = 'AP'";
    $sql .= ' and v.idt_tipo_voucher in (' . $vetTipoVoucherCodIDT['A'] . ', ' . $vetTipoVoucherCodIDT['E'] . ')';
    $sql .= " and vr.ativo = 'S'";
    $sql .= ' and vr.idt_matricula_utilizado is null';
    $rs = execsql($sql);
    $idt_evento_publicacao_voucher_utilizado = $rs->data[0][0];

    if ($idt_evento_publicacao_voucher_utilizado != '') {
        $vetCampo['voucher_utilizado'] = objTexto('voucher_utilizado', 'Número do Voucher', false, 20, 45, '', '', false);

        $vetFrm[] = Frame('<span>Matricular utilizando Voucher</span>', Array(
            Array($vetCampo['voucher_utilizado']),
                ), $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);
    }
} else {
    $sql = '';
    $sql .= ' select vr.numero';
    $sql .= ' from grc_evento_publicacao_voucher_registro vr';
    $sql .= " inner join grc_evento_publicacao_voucher v on v.idt = vr.idt_evento_publicacao_voucher";
    $sql .= " inner join grc_evento_publicacao ep on ep.idt = vr.idt_evento_publicacao";
    $sql .= ' where ep.idt_evento = ' . null($idt_evento);
    $sql .= " and ep.situacao = 'AP'";
    $sql .= ' and vr.idt_matricula_utilizado = ' . null($_GET['id']);
    $sql .= ' and v.idt_tipo_voucher in (' . $vetTipoVoucherCodIDT['A'] . ', ' . $vetTipoVoucherCodIDT['E'] . ')';
    $rs = execsql($sql);
    $voucher_utilizado = $rs->data[0][0];

    if ($voucher_utilizado != '') {
        $vetCampo['voucher_utilizado'] = objTextoFixo('voucher_utilizado', 'Número do Voucher', 15, false, false, $voucher_utilizado);

        $vetFrm[] = Frame('<span>Matricular utilizando o Voucher</span>', Array(
            Array($vetCampo['voucher_utilizado']),
                ), $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);
    }
}

define('voucher_utilizado', $voucher_utilizado);

$vetParametros = Array(
    'codigo_frm' => 'grc_evento_participante_pessoa_l',
    'controle_fecha' => 'A',
);

$vetFrm[] = Frame('<span>CADASTRO DE PESSOA</span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);

$vetCad[] = $vetFrm;
$vetFrm = Array();

$vetParametros = Array(
    'codigo_pai' => 'grc_evento_participante_pessoa_l',
    'width' => '100%',
    'trava_tudo' => $acao_alt_con,
);

$idtVinculo = array(
    'idt_atendimento' => 'grc_atendimento',
    " and tipo_relacao = 'L'" => false,
);
MesclarCadastro('grc_evento_participante_pessoa_l', $idtVinculo, $vetCad, $vetParametros, 'grc_atendimento_pessoa', false, false);

$montaOrganizacao = $_POST['volta_cad'] != 'S';

if ($_POST['btnAcao'] == $bt_alterar_lbl && $_POST['representa_empresa'] == 'N') {
    $montaOrganizacao = false;
}

if ($montaOrganizacao) {
    $vetParametros = Array(
        'codigo_frm' => 'frm_organizacao_pai',
        'controle_fecha' => 'F',
    );

    $vetFrm[] = Frame('<span>CADASTRO DE EMPREENDIMENTO</span>', '', $class_frame_p . ' frm_organizacao', $class_titulo_p, $titulo_na_linha_p, $vetParametros);

    $vetCad[] = $vetFrm;
    $vetFrm = Array();

    $vetParametros = Array(
        'codigo_pai' => 'frm_organizacao_pai',
        'width' => '100%',
        'trava_tudo' => $acao_alt_con,
    );

    MesclarCadastro('grc_evento_participante_organizacao', 'idt_atendimento', $vetCad, $vetParametros, 'grc_atendimento_organizacao', false, false);

    if ($veio != 'SG' && $composto != 'S' && filadeespera != 'S') {
        $vetCampoLC = Array();
        $vetCampoLC['cpf'] = CriaVetTabela('CPF do Cliente');
        $vetCampoLC['nome'] = CriaVetTabela('Nome do Cliente');
        $vetCampoLC['evento_cortesia'] = CriaVetTabela('Cortesia?', 'descDominio', $vetSimNao);

        $titulo = 'Pessoas';
        $TabelaPrinc = "grc_atendimento_pessoa";
        $AliasPric = "grc_ap";
        $Entidade = "Pessoa do Empreendimento";
        $Entidade_p = "Pessoas do Empreendimento";

        $sql = "select {$AliasPric}.*  ";
        $sql .= " from {$TabelaPrinc} {$AliasPric}  ";
        $sql .= " where {$AliasPric}" . '.idt_atendimento = $vlID';
        $sql .= " and {$AliasPric}.tipo_relacao = 'P'";
        $sql .= " order by {$AliasPric}.cpf";

        $vetParametrosLC = Array(
            'contlinfim' => '',
            'menu_acesso' => 'grc_evento_participante',
            'trava_tudo' => $acao_alt_con,
        );

        $vetCampo['grc_evento_participante_pessoa_p'] = objListarConf('grc_evento_participante_pessoa_p', 'idt', $vetCampoLC, $sql, $titulo, false, $vetParametrosLC);

        $vetFrm[] = Frame('<span>PESSOAS DO EMPREENDIMENTO</span>', Array(
            Array($vetCampo['grc_evento_participante_pessoa_p']),
                ), $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);
    }
}

$vetParametros = Array(
    'codigo_frm' => 'grc_evento_participante_extra_p1',
    'controle_fecha' => 'A',
);

$vetFrm[] = Frame('<span>INFORMAÇÕES DA INSCRIÇÃO</span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);

$vetCad[] = $vetFrm;
$vetFrm = Array();

$vetParametros = Array(
    'codigo_pai' => 'grc_evento_participante_extra_p1',
    'width' => '100%',
    'par_composto' => $composto,
    'par_origem_evento_tela' => $origem_evento_tela,
    'par_gratuito' => $gratuito,
    'par_idt_evento' => $idt_evento,
    'par_idt_evento_situacao' => $idt_evento_situacao,
    'par_situacao_contrato' => $situacao_contrato,
);

MesclarCadastro('grc_evento_participante_extra_p1', 'idt_atendimento', $vetCad, $vetParametros, 'grc_evento_participante', false, false);

$vetParametros = Array(
    'width' => '100%',
    'situacao_contrato' => $situacao_contrato,
);

MesclarCadastro('grc_evento_participante_extra_p2', 'idt_atendimento', $vetCad, $vetParametros, 'grc_evento_participante', false, false);

if (!($veio == 'SG' && $sgtec_modelo == 'E')) {
    if ($acaoOrg != 'inc' && ($_GET['idt_instrumento'] == 2 || $composto == 'S' || $origem_evento_tela == 'combo')) {
        $vetFilho = Array();

        if ($composto == 'S' || $origem_evento_tela == 'combo') {
            $sql = '';
            $sql .= ' select a.idt as idt_atendimento, a.idt_evento, e.codigo, e.idt_instrumento, e.codigo, e.descricao, i.descricao as instrumento';
            $sql .= ' from grc_atendimento a';
            $sql .= ' inner join grc_evento e on e.idt = a.idt_evento';
            $sql .= ' inner join grc_atendimento_instrumento i on i.idt = e.idt_instrumento';
            $sql .= ' where a.idt_atendimento_pai = ' . null($_GET['id']);
            $sql .= ' and e.idt_instrumento = 2';
            $rs = execsql($sql);

            foreach ($rs->data as $row) {
                $vetFilho[] = $row;
            }
        } else {
            $vetFilho[] = $idt_evento;
        }

        foreach ($vetFilho as $rowFilho) {
            if ($composto == 'S' || $origem_evento_tela == 'combo') {
                $titFrame = ' do ' . $rowFilho['instrumento'] . ' - ' . $rowFilho['descricao'];
                $idt_evento_w = $rowFilho['idt_evento'];
                $idt_instrumento_w = $rowFilho['idt_instrumento'];
                $id_w = $rowFilho['idt_atendimento'];
                $menu_listarConf = 'grc_evento_agenda_mat';
                $campo_listarConf = 'grc_evento_agenda_mat_' . $rowFilho['idt_atendimento'];
                $codigo_frm = 'composto_mat' . $rowFilho['idt_atendimento'] . '_frm';
                $codigo_frm_tit = ' composto_mat' . $rowFilho['idt_atendimento'] . '_tit';
                $campo_copia = 'copiar_agenda_' . $rowFilho['idt_atendimento'];
            } else {
                $titFrame = '';
                $idt_evento_w = $idt_evento;
                $idt_instrumento_w = $_GET['idt_instrumento'];
                $id_w = $_GET['id'];
                $menu_listarConf = '';
                $campo_listarConf = 'grc_evento_agenda_mat';
                $codigo_frm = 'agenda';
                $codigo_frm_tit = '';
                $campo_copia = 'copiar_agenda';
            }

            $vetParametros = Array(
                'codigo_frm' => $codigo_frm,
                'controle_fecha' => 'A',
            );

            $vetFrm[] = Frame('<span>Cronograma / Atividades' . $titFrame . '</span>', '', $class_frame_p . $codigo_frm_tit, $class_titulo_p, $titulo_na_linha_p, $vetParametros);

            $vetCampoLC = Array();
            $vetCampoLC['atividade'] = CriaVetTabela('Atividade', 'data');
            $vetCampoLC['data_inicial'] = CriaVetTabela('Data do Encontro', 'data');
            $vetCampoLC['hora_inicial'] = CriaVetTabela('Hora Inicial');
            $vetCampoLC['hora_final'] = CriaVetTabela('Hora Final');
            $vetCampoLC['carga_horaria'] = CriaVetTabela('Carga Horária', 'decimal');
            $vetCampoLC['tema'] = CriaVetTabela('Tema');
            $vetCampoLC['subtema'] = CriaVetTabela('Sub-tema');

            $titulo = 'Cronograma / Atividades' . $titFrame;

            $TabelaPrinc = "grc_evento_agenda";
            $AliasPric = "grc_ppa";
            $Entidade = "Cronograma / Atividades";
            $Entidade_p = "Cronograma / Atividades";
            $CampoPricPai = "idt_evento";

            $sql = "select {$AliasPric}.*,";
            $sql .= "       grc_t.descricao as tema, ";
            $sql .= "       grc_ts.descricao as subtema ";
            $sql .= " from {$TabelaPrinc} {$AliasPric}  ";
            $sql .= " left outer join grc_tema_subtema grc_t on grc_t.idt = {$AliasPric}.idt_tema ";
            $sql .= " left outer join grc_tema_subtema grc_ts on grc_ts.idt = {$AliasPric}.idt_subtema ";
            $sql .= " where {$AliasPric}" . '.idt_atendimento = ' . null($id_w);
            $sql .= " order by {$AliasPric}.data_inicial, {$AliasPric}.atividade";

            $input_data = Array(
                'idt_evento' => $idt_evento_w,
                'idt_instrumento' => $idt_instrumento_w,
            );

            $vetPadrao = Array(
                'menu_acesso' => 'grc_evento_agenda',
                'idCadPer' => $id_w,
                'input_data' => $input_data,
            );

            $vetCampo[$campo_listarConf] = objListarConf($campo_listarConf, 'idt', $vetCampoLC, $sql, $titulo, true, $vetPadrao, $menu_listarConf);

            $vetParametros = Array(
                'codigo_pai' => $codigo_frm,
                'width' => '100%',
            );

            $sql = '';
            $sql .= ' select a.idt, a.protocolo, grc_atpe.nome, grc_atpe.cpf';
            $sql .= ' from grc_atendimento a';
            $sql .= " left outer join grc_atendimento_pessoa grc_atpe on grc_atpe.idt_atendimento = a.idt ";
            $sql .= ' where a.idt_evento = ' . null($idt_evento_w);
            $sql .= ' and a.idt <> ' . null($id_w);

            $sql .= ' union all';

            $sql .= " select distinct 'evento' as idt, ' -  - Cronograma / Atividades sem Cliente' as protocolo, null as nome, null as cpf";
            $sql .= ' from grc_evento_agenda';
            $sql .= ' where idt_evento = ' . null($idt_evento_w);
            $sql .= ' and idt_atendimento is null';

            $sql .= ' order by protocolo, nome, cpf';

            $vetPadrao = Array(
                'input_data' => Array(
                    'idt_evento' => $idt_evento_w,
                    'idt_atendimento' => $id_w,
                    'composto' => $composto,
                ),
            );

            $vetCampo[$campo_copia] = objCmbBanco($campo_copia, 'Copiar o Cronograma / Atividades da Matricula', false, $sql, ' ', '', '', false, '', false, 'Não existe informação no sistema', $vetPadrao);

            $vetFrm[] = Frame('', Array(
                Array($vetCampo[$campo_copia]),
                Array($vetCampo[$campo_listarConf]),
                    ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);
        }
    }
}

if ($acaoOrg != 'inc' && $veio == 'SG' && $sgtec_modelo == 'E') {
    $vetParametros = Array(
        'codigo_frm' => 'frm_grc_evento_entrega',
        'controle_fecha' => 'A',
    );

    $vetFrm[] = Frame('<span>ENTREGAS</span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);

    $titulo = 'Entregas';

    $vetCampoLC = Array();
    $vetCampoLC['ordem'] = CriaVetTabela('Ordem');
    $vetCampoLC['codigo'] = CriaVetTabela('Código');
    $vetCampoLC['descricao'] = CriaVetTabela('Nome');
    $vetCampoLC['detalhe'] = CriaVetTabela('Descrição');
    $vetCampoLC['mesano'] = CriaVetTabela('Mês/Ano');
    $vetCampoLC['percentual'] = CriaVetTabela('Percentual', 'decimal', '', '', '', '2', '', true);

    $sql = "select *";
    $sql .= " from grc_evento_entrega";
    $sql .= ' where idt_atendimento = $vlID';
    $sql .= " order by descricao";

    $vetCampo['grc_evento_entrega'] = objListarConf('grc_evento_entrega', 'idt', $vetCampoLC, $sql, $titulo, false);

    $vetParametros = Array(
        'codigo_pai' => 'frm_grc_evento_entrega',
        'width' => '100%',
    );

    $vetFrm[] = Frame('', Array(
        Array($vetCampo['grc_evento_entrega']),
            ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);

    $vetParametros = Array(
        'codigo_frm' => 'frm_grc_evento_dimensionamento',
        'controle_fecha' => 'A',
    );

    $vetFrm[] = Frame('<span>DIMENSIONAMENTO DA DEMANDA</span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);

    $titulo = 'Dimensionamento da Demanda';

    $vetCampoLC = Array();
    $vetCampoLC['codigo'] = CriaVetTabela('Código');
    $vetCampoLC['descricao'] = CriaVetTabela('Descrição');
    $vetCampoLC['grc_iu_descricao'] = CriaVetTabela('Unidade');

    if ($vl_determinado == 'S') {
        $vetCampoLC['vl_unitario'] = CriaVetTabela('Custo Unitário', 'decimal');
        $vetCampoLC['qtd'] = CriaVetTabela('QTDE', 'decimal');
        $vetCampoLC['vl_total'] = CriaVetTabela('Preço', 'decimal', '', '', '', '2', '', true);
    } else {
        $vetCampoLC['qtd'] = CriaVetTabela('QTDE', 'decimal');
    }

    $sql = "select ed.*, grc_iu.descricao as grc_iu_descricao";
    $sql .= " from grc_evento_dimensionamento ed";
    $sql .= " inner join grc_insumo_unidade grc_iu on grc_iu.idt = ed.idt_insumo_unidade ";
    $sql .= ' where ed.idt_atendimento = $vlID';
    $sql .= " order by ed.descricao";

    $vetCampo['grc_evento_dimensionamento'] = objListarConf('grc_evento_dimensionamento', 'idt', $vetCampoLC, $sql, $titulo, false);

    $vetParametros = Array(
        'codigo_pai' => 'frm_grc_evento_dimensionamento',
        'width' => '100%',
    );

    $vetFrm[] = Frame('', Array(
        Array($vetCampo['grc_evento_dimensionamento']),
            ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);
}

if ($acaoOrg != 'inc' && ($situacao_contrato != 'G' || $veio == 'SG')) {
        $mostraResumoPagamento = false;

        if ($veio != 'SG' || ($veio == 'SG' && ($sgtec_modelo == 'H' || $vl_determinado == 'N') && $idt_evento_situacao >= 8) || ($veio == 'SG' && $sgtec_modelo == 'E')) {
            $mostraResumoPagamento = true;
        }

        if ($veio == 'SG' && $sgtec_modelo == 'E' && $vl_determinado == 'N' && ($idt_evento_situacao == 1 || $idt_evento_situacao == 5)) {
            $mostraResumoPagamento = false;
        }

    if ($situacao_contrato == 'FE') {
        $mostraResumoPagamento = false;
    }

        if ($mostraResumoPagamento) {
            $vetParametros = Array(
                'codigo_frm' => 'participante_pagamento',
                'controle_fecha' => 'A',
            );

            $vetFrm[] = Frame('<span>RESUMO DO PAGAMENTO</span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);

        $vetCad[] = $vetFrm;
        $vetFrm = Array();

        $vetParametros = Array(
            'codigo_pai' => 'participante_pagamento',
            'width' => '100%',
            'par_composto' => $composto,
            'par_idt_evento' => $idt_evento,
            'par_situacao_contrato' => $situacao_contrato,
        );

        MesclarCadastro('grc_evento_participante_extra_p3', 'idt_atendimento', $vetCad, $vetParametros, 'grc_evento_participante', false, false);

            $vetCampoLC = Array();
            $vetCampoLC['np_descricao'] = CriaVetTabela('Forma de Pagamento');
            $vetCampoLC['cb_descricao'] = CriaVetTabela('Bandeira');
            $vetCampoLC['fp_descricao'] = CriaVetTabela('Parcelas');
            $vetCampoLC['codigo_nsu'] = CriaVetTabela('Código NSU');
            $vetCampoLC['data_pagamento'] = CriaVetTabela('Data do Pagamento', 'data');
            $vetCampoLC['valor_pagamento'] = CriaVetTabela('Valor do Pagamento', 'decimal', '', '', '', '2', '', true);
            $vetCampoLC['rm_idmov'] = CriaVetTabela('Cód. RM');

            $titulo = 'Regsitro de Pagamento';

            $sql = "select pp.*, np.descricao as np_descricao, cb.descricao as cb_descricao, fp.codigo as fp_descricao";
            $sql .= " from grc_evento_participante_pagamento pp";
            $sql .= ' left outer join grc_evento_natureza_pagamento np on np.idt = pp.idt_evento_natureza_pagamento';
            $sql .= ' left outer join grc_evento_cartao_bandeira cb on cb.idt = pp.idt_evento_cartao_bandeira';
            $sql .= ' left outer join grc_evento_forma_parcelamento fp on fp.idt = pp.idt_evento_forma_parcelamento';
            $sql .= ' where pp.idt_atendimento = $vlID';
            $sql .= " and pp.estornado <> 'S'";
            $sql .= " and pp.operacao = 'C'";
            $sql .= ' and pp.idt_aditivo_participante is null';
            $sql .= " order by pp.idt";

            if ($idt_evento_situacao == 8 || ($idt_evento_situacao == 24 && $sgtec_modelo == 'H')) {
                if ($situacao_contrato == 'C') {
                    $vetParametrosLC = Array(
                        'contlinfim' => '',
                    );
                } else {
                    $vetParametrosLC = Array(
                        'acao_alt_con_p' => 'S',
                        'barra_inc_ap' => true,
                        'barra_alt_ap' => true,
                        'barra_con_ap' => true,
                        'barra_exc_ap' => true,
                        'barra_inc_ap_muda_vl' => false,
                        'barra_alt_ap_muda_vl' => false,
                        'barra_exc_ap_muda_vl' => false,
                    );
                }
            } else {
                $vetParametrosLC = Array(
                    'contlinfim' => '',
                );
            }

            if ($altPag === true && $idt_evento_situacao != 8) {
                $vetParametrosLC['func_trata_row'] = trata_row_grc_evento_participante_pagamento;
            }

            if ($vetParametrosLC['func_trata_row'] == '') {
                $vetParametrosLC['func_trata_row'] = trata_row_grc_evento_participante_pagamento_d;
            }

            $vetCampo['grc_evento_participante_pagamento'] = objListarConf('grc_evento_participante_pagamento', 'idt', $vetCampoLC, $sql, $titulo, false, $vetParametrosLC);

            $vetParametros = Array(
                'codigo_pai' => 'participante_pagamento',
                'width' => '100%',
            );

            $vetFrm[] = Frame('', Array(
                Array($vetCampo['grc_evento_participante_pagamento']),
                    ), $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);

            $vetCampoLC = Array();
            $vetCampoLC['descricao'] = CriaVetTabela('Descrição');
            $vetCampoLC['percentual'] = CriaVetTabela('Percentual de Desconto', 'decimal');

            $titulo = 'Regsitro de Desconto';

            $sql = "select *";
            $sql .= " from grc_evento_participante_desconto";
            $sql .= ' where idt_atendimento = $vlID';
            $sql .= " order by percentual desc";

            $vetParametrosLC = Array(
                'contlinfim' => '',
                'comcontrole' => 0,
            );

            $vetCampo['grc_evento_participante_desconto'] = objListarConf('grc_evento_participante_desconto', 'idt', $vetCampoLC, $sql, $titulo, false, $vetParametrosLC);

            $vetFrm[] = Frame('', Array(
                Array($vetCampo['grc_evento_participante_desconto']),
                    ), $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);

            if ($veio == 'SG' && $sgtec_modelo == 'E' && $vl_determinado == 'S') {
                $vetParametros = Array(
                    'codigo_frm' => 'participante_contadevolucao',
                    'controle_fecha' => 'A',
                );

                $vetFrm[] = Frame('<span>DADOS PARA DEVOLUÇÃO</span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);

                $vetCampoLC = Array();
                $vetCampoLC['descricao'] = CriaVetTabela('Pagametos feitos por');
                $vetCampoLC['favorecido'] = CriaVetTabela('Favorecido');
                $vetCampoLC['banco_nome'] = CriaVetTabela('Banco');
                $vetCampoLC['agencia'] = CriaVetTabela('Agência');
                $vetCampoLC['cc'] = CriaVetTabela('Conta Corrente');
                $vetCampoLC['vl_pago'] = CriaVetTabela('Vl. Pago', 'decimal', '', '', '', '2', '', true);

                if ($idt_evento_situacao >= 8) {
                    $vetCampoLC['vl_devido'] = CriaVetTabela('Vl. Devido', 'decimal', '', '', '', '2', '', true);
                    $vetCampoLC['vl_devolucao'] = CriaVetTabela('Vl. Devolvido', 'decimal', '', '', '', '2', '', true);
                    $vetCampoLC['rm_idmov'] = CriaVetTabela('Cód. RM');
                }

                $titulo = 'Dados para Devolução';

                $sql = '';
                $sql .= " select cd.*, concat_ws('-', cd.agencia_numero, cd.agencia_digito) as agencia, concat_ws('-', cd.cc_numero, cd.cc_digito) as cc,";
                $sql .= " concat_ws(' - ', cd.cpfcnpj, cd.razao_social) as favorecido, pp.rm_idmov, cd.vl_pago - cd.vl_devolucao as vl_devido";
                $sql .= ' from grc_evento_participante_contadevolucao cd';
                $sql .= ' left outer join grc_evento_participante_pagamento pp on pp.idt = cd.idt_evento_participante_pagamento';
                $sql .= ' where cd.idt_atendimento = $vlID';
                $sql .= " and cd.reg_origem = 'MA'";

                $vetParametrosLC = Array(
                    'contlinfim' => '',
                );

                $vetCampo['grc_evento_participante_contadevolucao'] = objListarConf('grc_evento_participante_contadevolucao', 'idt', $vetCampoLC, $sql, $titulo, false, $vetParametrosLC);

                $vetParametros = Array(
                    'codigo_pai' => 'participante_contadevolucao',
                    'width' => '100%',
                );

                $vetFrm[] = Frame('', Array(
                    Array($vetCampo['grc_evento_participante_contadevolucao']),
                        ), $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);
            }

            if (!($veio == 'SG' && $sgtec_modelo == 'H')) {
                if ($veio == 'SG') {
                    $tmp = 'TERMO DE ADESÃO';
                } else {
                    $tmp = 'CONTRATO';
                }

                $vetFrm[] = Frame('<span>' . $tmp . '</span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);

                $vetCampoLC = Array();
                $vetCampoLC['contrato_pdf'] = CriaVetTabela('PDF do contrato', 'arquivo_sem_nome', '', 'grc_evento_participante_contrato');
                $vetCampoLC['contrato_ass_pdf'] = CriaVetTabela('Contrato Assinado', 'arquivo_sem_nome', '', 'grc_evento_participante_contrato');
                $vetCampoLC['dt_contrato'] = CriaVetTabela('Data do Contrato', 'data');
                $vetCampoLC['ui_nome'] = CriaVetTabela('Quem Gerou');
                $vetCampoLC['dt_cancelamento'] = CriaVetTabela('Data do Cancelamento', 'data');
                $vetCampoLC['uc_nome'] = CriaVetTabela('Quem Cancelou');

                $titulo = 'Contrato';

                $sql = "select pc.*, ui.nome_completo as ui_nome, uc.nome_completo as uc_nome";
                $sql .= " from grc_evento_participante_contrato pc";
                $sql .= " left outer join plu_usuario ui on ui.id_usuario = pc.idt_usuario_cont ";
                $sql .= " left outer join plu_usuario uc on uc.id_usuario = pc.idt_usuario_canc ";
                $sql .= ' where pc.idt_atendimento = $vlID';
                $sql .= " order by pc.dt_contrato desc";

                $vetParametrosLC = Array(
                    'contlinfim' => '',
                    'comcontrole' => 0,
                );

                $vetCampo['grc_evento_participante_contrato'] = objListarConf('grc_evento_participante_contrato', 'idt', $vetCampoLC, $sql, $titulo, false, $vetParametrosLC);

                $vetFrm[] = Frame('', Array(
                    Array($vetCampo['grc_evento_participante_contrato']),
                        ), $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);

                if ($situacao_contrato == 'A') {
                    if ($veio == 'SG') {
                        $file_nome = 'Termo de Adesão Assinado';
                        $file_valida = true;
                    } else {
                        $file_nome = 'Contrato Assinado';
                        $file_valida = false;
                    }

                    $vetCampo['contrato_ass_pdf'] = objFile('contrato_ass_pdf', $file_nome, $file_valida, 120, 'pdf');
                    $vetCampo['contrato_ass_pdf']['campo_tabela'] = false;
                    $vetCampo['contrato_ass_pdf']['tabela'] = '';

                    $vetFrm[] = Frame('', Array(
                        Array($vetCampo['contrato_ass_pdf']),
                            ), $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);
                }
            }
        }
    }

$sql = '';
$sql .= " select idt";
$sql .= ' from grc_evento_participante_fe_log';
$sql .= ' where idt_atendimento = '. null($_GET['id']);
$rs = execsql($sql);

if ($rs->rows > 0) {
    $vetParametros = Array(
        'codigo_frm' => 'histFE',
        'controle_fecha' => 'F',
    );

    $vetFrm[] = Frame('<span>HISTÓRICO DAS MOVIMENTAÇÕES NA FILA DE ESPERA</span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);

    $vetParametros = Array(
        'codigo_pai' => 'histFE',
        'width' => '100%',
    );

    $vetCampoLC = Array();
    $vetCampoLC['dt_registro'] = CriaVetTabela('Data da Movimentação', 'datahora');
    $vetCampoLC['usuario_nome'] = CriaVetTabela('Quem fez a Movimentação');
    $vetCampoLC['situacao'] = CriaVetTabela('Situação', 'descDominio', $vetEventoMatFE);
    $vetCampoLC['dt_validade'] = CriaVetTabela('Prazo da Situação', 'datahora');

    $titulo = 'Histórico das movimentações na Fila de Espera';

    $sql = '';
    $sql .= " select *";
    $sql .= ' from grc_evento_participante_fe_log';
    $sql .= ' where idt_atendimento = $vlID';
    $sql .= ' order by dt_registro desc';

    $vetParametrosLC = Array(
        'comcontrole' => '0',
        'contlinfim' => '',
    );

    $vetCampo['grc_evento_participante_fe_log'] = objListarConf('grc_evento_participante_fe_log', 'idt', $vetCampoLC, $sql, $titulo, false, $vetParametrosLC);

    $vetFrm[] = Frame('', Array(
        Array($vetCampo['grc_evento_participante_fe_log']),
            ), $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);
    }

if (($acaoOrg == 'exc' && $veio != 'SG') || $rowDados['motivo_cancelamento'] != '') {
    $vetCad[] = $vetFrm;
    $vetFrm = Array();

    $vetParametros = Array(
        'width' => '100%',
        'par_acaoOrg' => $acaoOrg,
        'par_rowDados' => $rowDados,
    );

    MesclarCadastro('grc_evento_participante_extra_p4', 'idt_atendimento', $vetCad, $vetParametros, 'grc_evento_participante', false, false);
}

$vetCampo['grc_evento_participante_botao'] = objInclude('grc_evento_participante_botao', 'cadastro_conf/grc_evento_participante_botao.php');

$vetParametros = Array(
    'width' => '100%',
);

$vetFrm[] = Frame('', Array(
    Array($vetCampo['grc_evento_participante_botao']),
        ), $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);

$vetCad[] = $vetFrm;
?>
<script type="text/javascript">
    var msgVoltar = 'N';
    var veio = '<?php echo $veio; ?>';
    var idt_instrumento = '<?php echo $_GET['idt_instrumento']; ?>';
    var composto_matAjax = 'S';

    $(document).ready(function () {
        onSubmitCancelado = function () {
            onSubmitMsgTxt = '';
            valida_cust = '';
            msgVoltar = 'N';

            $('#volta_cad').val('');
            $('#bt_acao_insc').val('');
            $('#contrato').val('<?php echo $situacao_contrato; ?>');
        };

        if (acao == 'alt') {
            $('td[id ^= "copiar_agenda_"][id $= "_obj"]').each(function () {
                $(this).append('<div class="botao_ag_b2 btCopiarAgenda" onclick="return CopiarAgenda(this);"><div style="margin:8px;">Copiar o Cronograma / Atividades informada</div></div>');
            });
        }

        if ('<?php echo $situacao_contrato; ?>' == 'A') {
            setTimeout(function () {
                $('#contrato_ass_pdf').removeProp("disabled").removeClass("campo_disabled");
            }, 500);

            setTimeout(function () {
                $('#contrato_ass_pdf').removeProp("disabled").removeClass("campo_disabled");
            }, 2000);
        }

        $('#representa_empresa').change(function () {
            var frm_organizacao = $('.frm_organizacao');

            if ($(this).val() == 'S') {
                if ($('#idt_tipo_empreendimento').val() == 7) {
                    $("#cnpj_desc").addClass("Tit_Campo").removeClass("Tit_Campo_Obr");
                } else {
                    $("#cnpj_desc").addClass("Tit_Campo_Obr").removeClass("Tit_Campo");
                }

                $('.frm_organizacao_pai .Campo_Obr').addClass("Tit_Campo_Obr").removeClass("Tit_Campo").removeClass("Campo_Obr");

                frm_organizacao.show();

                if ($('.frm_organizacao_pai:last').is(":hidden")) {
                    $('#frm_organizacao_pai').click();
                }
            } else {
                $("#cnpj_desc").addClass("Tit_Campo").removeClass("Tit_Campo_Obr");

                $('.frm_organizacao_pai .Tit_Campo_Obr').addClass("Tit_Campo").addClass("Campo_Obr").removeClass("Tit_Campo_Obr");

                if ($('.frm_organizacao_pai:last').is(":visible")) {
                    $('#frm_organizacao_pai').click();
                }

                frm_organizacao.hide();
            }
        });

        setTimeout("$('#representa_empresa').change()", 10);

        $('select[id ^= "composto_mat"]').change(function () {
            MatCompostoCombo($(this), $(this).val(), 'composto_mat');
        });

        setTimeout(function () {
            $('select[id ^= "composto_mat"]').each(function () {
                composto_matAjax = 'N';
                $(this).change();
                composto_matAjax = 'S';
            });
        }, 100);

        if ('<?php echo $idt_evento_publicacao_voucher_utilizado; ?>' != '') {
            var btVoucherUtilizado = $('<img border="0" id="btVoucherUtilizado" style="margin-left: 3px; cursor: pointer; vertical-align: middle;" src="imagens/bt_pesquisa.png" title="Pesquisar">');

            btVoucherUtilizado.click(function () {
                if ($('#voucher_utilizado').val() == '') {
                    return false;
                }

                var prefixoCod = $('#voucher_utilizado').val().toUpperCase();

                if (prefixoCod.substr(0, 2) != 'VA' && prefixoCod.substr(0, 3) != 'VEO') {
                    alert('O Código do Voucher informado não é de outro Participante ou Indicação de Amigo!');
                    $('#voucher_utilizado').val('');
                    $('#voucher_utilizado').focus();
                    return false;
                }

                processando();

                $.ajax({
                    dataType: 'json',
                    type: 'POST',
                    url: ajax_sistema + '?tipo=ChecaVoucher',
                    data: {
                        cas: conteudo_abrir_sistema,
                        voucher_numero: $('#voucher_utilizado').val(),
                        idt_evento: '<?php echo $idt_evento; ?>',
                        idt_matricula_utilizado: '<?php echo $_GET['id']; ?>'
                    },
                    success: function (response) {
                        if (response.erro != '') {
                            $('#voucher_utilizado').val('');
                            $('#dialog-processando').remove();
                            alert(url_decode(response.erro));
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        $('#voucher_utilizado').val('');
                        $('#dialog-processando').remove();
                        alert('Erro no ajax no: ' + textStatus + ' - ' + errorThrown);
                    },
                    async: false
                });

                $('#dialog-processando').remove();
            });

            $('#voucher_utilizado_obj').attr('nowrap', 'nowrap').append(btVoucherUtilizado);

            $('#voucher_utilizado').blur(function () {
                btVoucherUtilizado.click();
            });

            setTimeout(function () {
                $('#voucher_utilizado').removeProp("disabled").removeClass("campo_disabled");
            }, 500);

            setTimeout(function () {
                $('#voucher_utilizado').removeProp("disabled").removeClass("campo_disabled");
            }, 2000);
        }

        if ('<?php echo $tipo_relacao; ?>' == 'P') {
            setTimeout("abrePessoa()", 500);
        }
    });

    function MatCompostoCombo(obj, ativo, idxCampo) {
        var reg = new RegExp(idxCampo, "g");
        var strId = obj.attr('id');
        strId = strId.replace(/\[/g, '');
        strId = strId.replace(/\]/g, '');

        var strTab = strId.replace(reg, 'grc_evento_agenda_mat_');
        var idt_atendimento_filho = strId.replace(reg, '');

        var frmID = strId.replace(reg, 'composto_mat');
        var frm_organizacao = $('.' + frmID + '_tit');
        var frm_organizacao_pai = frmID + '_frm';

        if (ativo == 'S' || ativo == 'C') {
            $('#' + strTab + '_desc').addClass("Tit_Campo_Obr").removeClass("Tit_Campo");

            frm_organizacao.show();

            if ($('.' + frm_organizacao_pai + ':last').is(":hidden")) {
                $('#' + frm_organizacao_pai).click();
            }
        } else {
            $('#' + strTab + '_desc').addClass("Tit_Campo").removeClass("Tit_Campo_Obr");

            if ($('.' + frm_organizacao_pai + ':last').is(":visible")) {
                $('#' + frm_organizacao_pai).click();
            }

            frm_organizacao.hide();
        }

        if (composto_matAjax == 'S') {
            processando();

            $.ajax({
                dataType: 'json',
                type: 'POST',
                url: ajax_sistema + '?tipo=MatriculaEventoCompostoPag',
                data: {
                    cas: conteudo_abrir_sistema,
                    valor: ativo,
                    idt_atendimento_filho: idt_atendimento_filho,
                    idt_atendimento: '<?php echo $_GET['id']; ?>'
                },
                success: function (response) {
                    $('#vl_tot_pagamento').val(response.valor);
                    $('#vl_tot_pagamento_fix').html(response.valor);

                    if (response.erro != '') {
                        obj.val(response.ativo_banco);
                        $('#dialog-processando').remove();
                        alert(url_decode(response.erro));
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    obj.val('');
                    $('#dialog-processando').remove();
                    alert('Erro no ajax no: ' + textStatus + ' - ' + errorThrown);
                },
                async: false
            });

            $('#dialog-processando').remove();
        }
    }

    function CopiarAgenda(obj) {
        obj = $(obj).parent();
        var sel = obj.find('select');

        if (sel.val() == '') {
            alert('Favor informar o Cronograma / Atividades que vai ser copiado!');
            sel.focus();
            return false;
        }

        if (confirm('Deseja copiar o Cronograma / Atividades informada?')) {
            processando();

            $.ajax({
                dataType: 'json',
                type: 'POST',
                url: ajax_sistema + '?tipo=CopiarAgendaEvento',
                data: {
                    cas: conteudo_abrir_sistema,
                    idt_atendimento: sel.data('idt_atendimento'),
                    idt_evento: sel.data('idt_evento'),
                    idt_copia: sel.val()
                },
                success: function (response) {
                    $('input[id ^= "grc_evento_agenda_mat"]').each(function () {
                        btFechaCTC($(this).data('session_cod'));
                    });

                    if (response.erro != '') {
                        $('#dialog-processando').remove();
                        alert(url_decode(response.erro));
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    $('#dialog-processando').remove();
                    alert('Erro no ajax no: ' + textStatus + ' - ' + errorThrown);
                },
                async: false
            });

            $('#dialog-processando').remove();
        }

    }

    function abrePessoa() {
        var obj_td = $('#grc_evento_participante_pessoa_p_desc td[data-id="<?php echo $idt_atendimento_pessoa; ?>"]:first');
        var bt = obj_td.parent().find('a[data-acao="alt"]');

        if (bt.length == 0) {
            obj_td.parent().find('a[data-acao="con"]').click();
        } else {
            bt.click();
        }
    }

    function grc_evento_participante_dep() {
        if ($('#bt_acao_insc').val() == 'inscricao_excluir') {
            return true;
        }

        var ok = grc_atendimento_pessoa_dep();

        if (ok === true && valida == 'S' && $('#representa_empresa').val() == 'S') {
            ok = grc_atendimento_organizacao_dep();
        }

        if (ok && $('#volta_cad').val() != 'S' && valida == 'S') {
            processando();

            var composto = '<?php echo $composto; ?>';

            if (idt_instrumento == 54) {
                composto = 'S';
            }

            if (composto == 'S') {
                var valor_inscricao = $('#vl_tot_pagamento').val();
            } else {
                var valor_inscricao = '<?php echo $_GET['valor_inscricao']; ?>';
            }

            $.ajax({
                dataType: 'json',
                type: 'POST',
                url: ajax_sistema + '?tipo=grc_evento_participante_valida_geral',
                data: {
                    cas: conteudo_abrir_sistema,
                    veio: veio,
                    composto: composto,
                    valor_inscricao: valor_inscricao,
                    idt_lider: '<?php echo $idt_atendimento_pessoa_lider; ?>',
                    evento_cortesia: $('#evento_cortesia').val(),
                    evento_contrato: $('#contrato').val(),
                    assento_marcado: assento_marcado,
                    situacao_contrato: '<?php echo $situacao_contrato; ?>',
                    id: $('#id').val()
                },
                success: function (response) {
                    if (response.erro != '') {
                        $('#dialog-processando').remove();
                        alert(url_decode(response.erro));
                        ok = false;
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

        return ok;
    }

    function parListarConf_grc_evento_participante_pessoa_p() {
        var par = '';

        par += '&idt_instrumento=' + idt_instrumento;
        par += '&idt_evento=<?php echo $idt_evento; ?>';
        par += '&veio=' + veio;

        return par;
    }

    function parListarConf_grc_evento_participante_pagamento(idCad, id, objCampo, acao) {
        var par = '';
        var erro = false;

        if (acao == 'inc' && '<?php echo $sgtec_modelo; ?>' == 'E' && '<?php echo $vl_determinado; ?>' == 'S' && '<?php echo $vl_teto; ?>' != '') {
            $.ajax({
                dataType: 'json',
                type: 'POST',
                url: ajax_sistema + '?tipo=grc_evento_participante_valida_sg',
                data: {
                    cas: conteudo_abrir_sistema,
                    idt_produto: '<?php echo $_GET['idt_produto']; ?>',
                    idt_atendimento: '<?php echo $_GET['id']; ?>'
                },
                success: function (response) {
                    if (response.erro != '') {
                        $('#dialog-processando').remove();
                        alert(url_decode(response.erro));
                        erro = true;
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    $('#dialog-processando').remove();
                    alert('Erro no ajax no: ' + textStatus + ' - ' + errorThrown);
                    erro = true;
                },
                async: false
            });
        }

        if (erro) {
            return false;
        }

        var composto = '<?php echo $composto; ?>';

        if (idt_instrumento == 54) {
            composto = 'S';
        }

        if (composto == 'S') {
            par += '&valor_inscricao=' + $('#vl_tot_pagamento').val();
        } else {
            par += '&valor_inscricao=<?php echo $_GET['valor_inscricao']; ?>';
        }

        par += '&veio=' + veio;

        return par;
    }

    function parListarConf_grc_evento_agenda_mat(idCad, id, objCampo) {
        var par = '';

        var valor_hora = parent.$('#valor_hora').val();

        if (valor_hora == undefined) {
            valor_hora = '';
        }

        par += '&idt_local=' + parent.$('#idt_local').val();
        par += '&idt_cidade=' + parent.$('#idt_cidade').val();
        par += '&valor_hora=' + valor_hora;
        par += '&idt_instrumento=' + objCampo.data('idt_instrumento');
        par += '&veio=' + veio;
        par += '&idt_evento=' + objCampo.data('idt_evento');
        par += '&mat=s';

        return par;
    }

    function funcaoFechaCTC_grc_evento_agenda_mat(returnVal) {
        btFechaCTC($('#grc_evento_participante_pagamento').data('session_cod'));

        parent.$('#grc_evento_agenda_erro').val(url_decode(returnVal.grc_evento_agenda_erro));

        parent.$('#dt_previsao_inicial').val(url_decode(returnVal.dt_ini));
        parent.$('#dt_previsao_fim').val(url_decode(returnVal.dt_fim));
        parent.$('#hora_inicio').val(url_decode(returnVal.hr_ini));
        parent.$('#hora_fim').val(url_decode(returnVal.hr_fim));

        parent.$('#dt_previsao_inicial_fix').html(url_decode(returnVal.dt_ini));
        parent.$('#dt_previsao_fim_fix').html(url_decode(returnVal.dt_fim));
        parent.$('#hora_inicio_fix').html(url_decode(returnVal.hr_ini));
        parent.$('#hora_fim_fix').html(url_decode(returnVal.hr_fim));

        if (idt_instrumento != 2) {
            if (parent.$('#idt_cidade_tf').length > 0) {
                parent.$('#idt_cidade').val(url_decode(returnVal.idt_cidade));
                parent.$('#idt_cidade_tf').html(url_decode(returnVal.idt_cidade_tf));
            }
        }

        parent.$('#idt_local').val(url_decode(returnVal.idt_local));
        parent.$('#idt_local_tf').html(url_decode(returnVal.idt_local_tf));

        parent.$('#carga_horaria_total').val(url_decode(returnVal.tot_hora_consultoria));

        parent.$('#tot_hora_consultoria').val(url_decode(returnVal.tot_hora_consultoria));
        parent.$('#tot_hora_consultoria_fix').html(url_decode(returnVal.tot_hora_consultoria));

        parent.$('#custo_tot_consultoria').val(url_decode(returnVal.custo_tot_consultoria));
        parent.$('#custo_tot_consultoria_fix').html(url_decode(returnVal.custo_tot_consultoria));

        parent.$('#qtd_dias_reservados').val(url_decode(returnVal.qtd_dias_reservados));
    }

    function parListarConf_grc_evento_dimensionamento() {
        var par = '';

        par += '&idt_evento=<?php echo $idt_evento; ?>';

        return par;
    }

    function funcaoFechaCTC_grc_evento_dimensionamento(returnVal) {
        $('#vl_tot_pagamento').val(returnVal);
        $('#vl_tot_pagamento_fix').html(returnVal);
    }

    function parListarConf_grc_evento_entrega() {
        var par = '';

        par += '&idt_evento=<?php echo $idt_evento; ?>';

        return par;
    }

    function funcaoFechaCTC_grc_evento_participante_pagamento() {
        btFechaCTC($('#grc_evento_participante_contadevolucao').data('session_cod'));
    }

    function btAcaoVoltar() {
        var conf = true;

        if (msgVoltar == 'S') {
            conf = confirm('Atenção! A inscrição não foi finalizado e as informações não foram salvas.\n\nConfirma?');
        }

        if (conf) {
            var fnc = null;

            if (veio == 'SG' || idt_instrumento == 2) {
                fnc = parent.funcaoFechaCTC_grc_evento_participante;
            }

            parent.btFechaCTC('<?php echo $_GET['session_cod']; ?>', fnc, parent.grc_evento_participante_fecha_ant('<?php echo $_GET['id']; ?>', '<?php echo filadeespera; ?>'));
        }
    }
</script>