<style>
    body {
        padding: 5px;
    }

    fieldset.class_frame {
        background:#ECF0F1;
        border:1px solid #14ADCC;
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

    fieldset.class_frame_f {
        background:#2F66B8;
        border:1px solid #FFFFFF;
    }

    div.class_titulo_f {
        background: #2F66B8;
        border    : 1px solid #2C3E50;
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
        color     : #FFFFFF;
        text-align: left;
        height    : 15px;
        font-size : 12px;
        padding-top:5px;
    }

    div.class_titulo_p span {
        padding:10px;
        text-align: left;
    }

    fieldset.class_frame_px {
        background: #E8E8F8;
        border:0px solid #FFFFFF;
    }

    div.class_titulo_px {
        background: #E8E8F8;
        text-align: left;
        border    : 0px solid #2C3E50;
        color     : #777777;
        text-align: left;
        height    : 20px;
        font-size : 12px;
        padding-top:5px;
    }

    div.class_titulo_px span {
        padding:10px;
        text-align: left;
    }

    div.class_titulo_p_barra {
        text-align: left;
        background: #2C3E50;
        border    : 0px solid #2C3E50;
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
        color     : #FFFFFF;
        border    : 0px solid #2C3E50;
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

    Select {
        border:0px;
        height:20px;
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

    td#idt_competencia_obj div {
        color:#FF0000;
    }

    .Tit_Campo {
        font-size:12px;
    }

    td.Titulo {
        color:#666666;
    }

    #idt_instrumento_obj {
        width:100%;
    }

    #idt_instrumento_tf {
        text-align:center;
        font-size:2em;
        background:#2C3E50;
        color:#FFFFFF;
        font-weight:bold;
        font-family: Lato Regular, Calibri, Arial,  Helvetica, sans-serif;
    }

    .Texto {
        border:0;
    }

    #gestor_sge_fix {
        background:#ECF0F1;
    }

    #fase_acao_projeto_fix {
        background:#ECF0F1;
    }

    div.Barra {
        display: none;
    }

    .display_none {
        display: none;
    }

    #frm4 {
        width:90%;
        margin-left:5em;
    }

    #frm5 > table {
        width:90%;
        margin-left:5em;
    }

    #frm6 {
        width:90%;
        margin-left:1em;
    }

    #frm6 > table {
        width:90%;
    }

    #frm7 {
        width:90%;
        margin-left:5em;
    }

    #frm8 {
        width:90%;
        margin-left:5em;
    }

    #frm8 table {
        margin:0em;
    }

    #frm9 {
        width:90%;
        margin-left:5em;
    }

    #frm9 table {
        margin:0em;
    }

    #idt_gestor_local_obj {
        width:50%;
    }

    #data_solucao_atendimento {
        width:100px;
    }

    #informa_demandante_desc {
        padding-top:10px;
    }

    #enviar_email_cliente_desc {
        padding-top:10px;
    }

    #incluir_anexos_resposta_cliente_desc {
        padding-top:10px;
    }

    #parecer_encaminhamento_desc {
        padding-top:10px;
    }

    #obj_html_pendencia_historico_desc {
        width:1000px;
    }

    #frm10 {
        display:none;
    }

    #frm11 {
        display:none;
    }
</style>

<?php
//p($_GET);

$vetPadraoLC = Array(
    'barra_inc_img' => "imagens/incluir_16.png",
    'barra_alt_img' => "imagens/alterar_16.png",
    'barra_con_img' => "imagens/consultar_16.png",
    'barra_exc_img' => "imagens/excluir_16.png",
);

unset($vetConfMsg['inc']);
$barra_bt_top = false;


//$onSubmitDep = "ConfirmaEnviarParaGravar()";

if ($_GET['idCad'] != '') {
    $_GET['idt0'] = $_GET['idCad'];
    $botao_volta = "parent.btFechaCTC('" . $_GET['session_cod'] . "', parent.grc_atendimento_pendencia_fecha, parent.grc_atendimento_pendencia_fecha_ant);";
    $botao_acao = '<script type="text/javascript">parent.btFechaCTC("' . $_GET['session_cod'] . '", parent.grc_atendimento_pendencia_fecha);</script>';
}
//p($_GET);
$TabelaPai = "grc_atendimento";
$AliasPai = "grc_a";
$EntidadePai = "Protocolo";
$idPai = "idt";
//
$TabelaPrinc = "grc_atendimento_pendencia";
$AliasPric = "grc_ap";
$Entidade = "Pendência do Atendimento";
$Entidade_p = "Pendências do Atendimento";
$CampoPricPai = "idt_atendimento";

$tabela = $TabelaPrinc;

$idt_atendimento_pendencia = $_GET['id'];
$idt_atendimento = $_GET['idt0'];
if ($idt_atendimento == "") {
    $idt_atendimento = 0;
}

$idt_evento = 0;
$ativo = '';
$cpf_atendimento = "";
$codparceiro_atual = "";

if ($acao != 'inc') {
    $sql = "select  ";
    $sql .= " grc_ap.*  ";
    $sql .= " from grc_atendimento_pendencia grc_ap ";
    $sql .= " where idt = " . null($idt_atendimento_pendencia);
    $rs = execsql($sql);
    $wcodigo = '';
    ForEach ($rs->data as $row) {
        $idt_usuario = $row['idt_usuario'];
        $idt_atendimento = $row['idt_atendimento'];
        $idt_evento = $row['idt_evento'];
        $tipo = $row['tipo'];
        $idt_ponto_atendimento = $row['idt_ponto_atendimento'];
        $ativo = $row['ativo'];
        $idt_status_tramitacao = $row['idt_status_tramitacao'];
        $status = $row['status'];
    }
    if ($tipo == 'Evento') {
        $sql = "select  ";
        $sql .= " grc_e.*  ";
        $sql .= " from grc_evento grc_e ";
        $sql .= " where idt = " . null($idt_evento);
        $rs = execsql($sql);
        $wcodigo = '';
        ForEach ($rs->data as $row) {
            $protocolo = $row['codigo'];
        }
    } else {
        if ($tipo == 'Atendimento Presencial') {
            $sql = "select  ";
            $sql .= " grc_a.*,  ";
            $sql .= " grc_ap.cpf   as grc_ap_cpf,  ";
            $sql .= " grc_ap.email as grc_ap_email  ";
            $sql .= " from grc_atendimento grc_a ";
            $sql .= " left join grc_atendimento_pessoa grc_ap on grc_ap.idt_atendimento = grc_a.idt  ";
            $sql .= "       and  grc_ap.tipo_relacao = " . aspa('L');
            $sql .= " where grc_a.idt = " . null($idt_atendimento);
            $rs = execsql($sql);
            $wcodigo = '';
            ForEach ($rs->data as $row) {
                $protocolo = $row['protocolo'];
                $cpf_atendimento = $row['grc_ap_cpf'];
                $email_atendimento = $row['grc_ap_email'];
                $codparceiro_atual = "";
            }
        } else {
            $sql = "select  ";
            $sql .= " grc_a.*  ";
            $sql .= " from grc_atendimento grc_a ";
            $sql .= " where idt = " . null($idt_atendimento);
            $rs = execsql($sql);
            $wcodigo = '';
            ForEach ($rs->data as $row) {
                $protocolo = $row['protocolo'];
            }
        }
    }

    // echo " Protocolo: ".$protocolo;
} else {
    $idt_pessoa = $_GET['idt_pessoa'];
    $idt_cliente = $_GET['idt_cliente'];

    $sql = "select  ";
    $sql .= " grc_a.*  ";
    $sql .= " from grc_atendimento grc_a ";
    $sql .= " where idt = " . null($idt_atendimento);
    $rs = execsql($sql);
    $wcodigo = '';
    ForEach ($rs->data as $row) {
        $protocolo = $row['protocolo'];
        $idt_ponto_atendimento = $row['idt_ponto_atendimento'];
    }
    $sql = "select grc_ap.* from grc_atendimento_pessoa grc_ap ";
    $sql .= " where ";
    $sql .= "    idt  =  " . null($idt_pessoa);
    $rs = execsql($sql);
    ForEach ($rs->data as $row) {
        $codigo_pf = $row['cpf'];
        $nome_pf = $row['nome'];
        $codigo_siacweb_pf = $row['codigo_siacweb'];
    }
    if ($idt_cliente > 0) {
        $sql = "select grc_ao.* from grc_atendimento_organizacao grc_ao ";
        $sql .= " where ";
        $sql .= "    idt  =  " . null($idt_cliente);
        $rs = execsql($sql);
        ForEach ($rs->data as $row) {
            $codigo_pj = $row['cnpj'];
            $nome_pj = $row['razao_social'];
            $codigo_siacweb_pj = $row['codigo_siacweb_e'];
        }
    }
}

if ($ativo == 'N' && $acao != 'con') {
    $acao = 'con';
    $_GET['acao'] = $acao;
    alert('Pendência já foi fechada. Só pode Consultar.');
}

if ($idt_status_tramitacao > 1 && $acao != 'con') {
    $acao = 'con';
    $_GET['acao'] = $acao;
    alert('Pendência está na situação ' . $status . '. Só pode Consultar.');
}

if ($tipo == 'Evento') {
    $protocolo_titulo = 'Código do Evento';
    $data_titulo = 'Data do Solicitação Aprovação';
    $assunto_titulo = 'Título do Evento';
    $observacao_titulo = 'Detalhamento do Evento';
    $solucao = 'Parecer';
} else {
    $protocolo_titulo = 'Protocolo de Atendimento';
    $data_titulo = 'Data do Atendimento';
    $assunto_titulo = 'Assunto';
    $observacao_titulo = 'Detalhamento da Pendência';
    $solucao = 'Resposta';
}


if ($acao == 'inc') {
    $vetCampo['temporario'] = objHidden('temporario', 'S');
} else {
    $vetCampo['temporario'] = objHidden('temporario', 'N');
    $onSubmitDep = "ConfirmaEnviarParaGravar()";
}

$id = 'idt';
$vetCampo[$CampoPricPai] = objHidden($CampoPricPai, $_GET['idt0']);

$corbloq = "#FFFF80";
$jst = " readonly='true' style='background:{$corbloq}; font-size:12px; xwidth:100%;' ";
$vetCampo['protocolo'] = objTexto('protocolo', $protocolo_titulo, false, 12, 45, $jst);

$corbloq = "#FFFF80";
$jst = " readonly='true' style='background:{$corbloq}; font-size:12px; xwidth:100%;' ";
$vetCampo['status'] = objTexto('status', 'Status', false, 13, 45, $jst);

$vetCampo['ativo'] = objHidden('ativo', 'S');



$vetCampo['idt_ponto_atendimento'] = objFixoBanco('idt_ponto_atendimento', 'Ponto de Atendimento', '' . db_pir . 'sca_organizacao_secao', idt, 'descricao');



if ($_GET['grc_atendimento'] == 'S') {
    $vetCampo['idt_responsavel_solucao'] = objHidden('idt_responsavel_solucao', '');
} else {
//$sql  = " select plu_usu.id_usuario, plu_usu.nome_completo from plu_usuario plu_usu";

    $sql = "select id_usuario, nome_completo  descricao from plu_usuario ";
    $sql .= " where matricula_intranet <> '' ";
    $sql .= " order by nome_completo";

    $js_hm = "";
    $js_hm = " disabled='true' style='background:{$corbloq}; font-size:12px; width:237px;' ";
    $style = "";
    $vetCampo['idt_responsavel_solucao'] = objCmbBanco('idt_responsavel_solucao', 'Responsável pela Solução', false, $sql, ' ', $style, $js_hm);
}

//
// pegar gestor local da unidade de atendimento
//
//$sql  = " select plu_usu.id_usuario, plu_usu.nome_completo from plu_usuario plu_usu";
//$sql .= " where plu_usu.id_usuario = ".null($_SESSION[CS]['g_idt_gestor_local']);

$sql = "select id_usuario, nome_completo  descricao from plu_usuario ";
$sql .= " where matricula_intranet <> '' ";
$sql .= " order by nome_completo";

//
$js_hm = "";
$style = " width:100%; ";
$vetCampo['idt_gestor_local'] = objCmbBanco('idt_gestor_local', 'Responsável Gestor', true, $sql, ' ', $style, $js_hm);


$sql = " select plu_usu.id_usuario, plu_usu.nome_completo from plu_usuario plu_usu";
if ($acao != 'inc') {
    $sql .= " where plu_usu.id_usuario = " . null($idt_usuario);
} else {
    
}
//    $js_hm   = " disabled  ";
$js_hm = " disabled style='background:{$corbloq}; font-size:12px; width:210px;' ";

$vetCampo['idt_usuario'] = objCmbBanco('idt_usuario', 'Consultor', false, $sql, '', $style, $js_hm);

$js = "";
$vetCampo['data_dasolucao'] = objDataHora('data_dasolucao', 'Data da Solução', False, $js, '', 'S');

$js = "";
if ($_GET['grc_atendimento'] != 'S') {
    $js = " readonly='true' style=' background:{$corbloq};' ";
}
$vetCampo['data_solucao'] = objDataHora('data_solucao', 'Prazo de Resposta ao Cliente', False, $js, '', 'S');


$js = " readonly='true' style='background:#FFFF80; font-size:14px; width:110px;' ";
$vetCampo['data'] = objDataHora('data', $data_titulo, False, $js, 'S');

$maxlength = 2000;
$style = "border: none;";
$js = "";
if ($_GET['grc_atendimento'] != 'S') {
    $style .= " background:{$corbloq};";
    $js = " readonly='true' ";
}
$vetCampo['observacao'] = objTextArea('observacao', $observacao_titulo, false, $maxlength, $style, $js);




$jst = " readonly='true' style='background:{$corbloq}; font-size:12px; xwidth:100%;' ";
$vetCampo['cod_cliente_siac'] = objTexto('cod_cliente_siac', 'Código Cliente', false, 15, 45, $jst);
$jst = " readonly='true' style='background:{$corbloq}; font-size:12px; xwidth:100%;' ";
$vetCampo['nome_cliente'] = objTexto('nome_cliente', 'Nome Cliente', false, 32, 120, $jst);

$jst = " readonly='true' style='background:{$corbloq}; font-size:12px; xwidth:100%;' ";
$vetCampo['cod_empreendimento_siac'] = objTexto('cod_empreendimento_siac', 'Código Empreendimento', false, 12, 45, $jst);
$jst = " readonly='true' style='background:{$corbloq}; font-size:12px; xwidth:100%;' ";
$vetCampo['nome_empreendimento'] = objTexto('nome_empreendimento', 'Nome Empreendimento', false, 32, 120, $jst);




$maxlength = 5000;
$style = "width:750px;";
$js = "";
$vetCampo['solucao'] = objTextArea('solucao', $solucao, false, $maxlength, $style, $js);
$js = "";
if ($_GET['grc_atendimento'] != 'S') {
    $style .= " background:{$corbloq};";
    $js = " disabled ";
}
$vetCampo['enviar_email'] = objCmbVetor('enviar_email', 'Enviar E-mail?', false, $vetSimNao, ' ', $js);

$maxlength = 255;
$style = "border: none; height:30px;";
$js = "";

if ($_GET['grc_atendimento'] != 'S') {
    $style .= " background:{$corbloq};";
    $js = " readonly='true' ";
}
$vetCampo['assunto'] = objTextArea('assunto', $assunto_titulo, true, $maxlength, $style, $js);

$js = "";
if ($_GET['grc_atendimento'] != 'S') {
    $style .= " background:{$corbloq};";
    $js = " disabled ";
}
$vetCampo['recorrencia'] = objCmbVetor('recorrencia', 'Recorrência?', false, $vetRecorrencia, ' ', $js);


$js = "";
$vetCampo['e_ou'] = objCmbVetor('e_ou', "Tipo = 'ou'?", false, $vetSimNao, '', $js);
$js = "";
$vetCampo['apagado'] = objCmbVetor('apagado', "Apagado?", false, $vetNaoSim, '', $js);


$vetCampo['botao_concluir_pendencia'] = objInclude('botao_concluir_pendencia', 'cadastro_conf/botao_concluir_pendencia.php');

$vetCampo['botao_concluir_pendencia_encaminhar'] = objInclude('botao_concluir_pendencia_encaminhar', 'cadastro_conf/botao_concluir_pendencia_encaminhar.php');

$js2 = " readonly='true' style='background:{$corbloq}; font-size:12px; xwidth:100%;' ";
$vetCampo['email_cliente'] = objEmail('email_cliente', 'E-mail', false, 30, 120, $js2);

$vetCampo['botao_historico_atendimento'] = objInclude('botao_historico_atendimento', 'cadastro_conf/botao_historico_atendimento.php');




$vetTramitacao = Array();

if ($_GET['grc_atendimento'] != 'S') {

    $vetTramitacao['E'] = "Encaminhar Pendência";
    $vetTramitacao['R'] = "Resolver Pendência";
    $js = " onchange='return ResolvePendencia();' ";
    echo "<style>";
    echo "#frm12 { ";
    echo "    display:none; ";
    echo "} ";
    echo "</style>";
} else {
    $vetTramitacao['E'] = "Encaminhar Pendência";
    $js = " xdisabled style='background:{$corbloq}; font-size:12px; ' ";
}

//$vetCampo['opcao_tramitacao'] = objCmbVetor('opcao_tramitacao', 'Opções', false, $vetTramitacao, '', $js);
//objRadio($campo, $nome, $valida, $vetor, $vl_padrao = '', $js = '', $fixo = 'N', $separacao = '&nbsp;&nbsp;&nbsp;&nbsp;') {
$vetCampo['opcao_tramitacao'] = objRadio('opcao_tramitacao', 'Opções', false, $vetTramitacao, '', $js);


$maxlength = 2000;
$style = "border: none; width:100%;";
$js = "";

//$vetCampo['consideracoes_encaminhamento'] = objTextArea('consideracoes_encaminhamento', "Considerações de Encaminhamento", false, $maxlength, $style, $js);


$jst = " readonly='true' style='background:{$corbloq}; font-size:12px; xwidth:100%;' ";
$jst = "";
$vetCampo['consideracoes_encaminhamento'] = objTexto('consideracoes_encaminhamento', 'Considerações de Encaminhamento', false, 80, 500, $jst);
$js = "";
$vetCampo['data_resposta_encaminhamento'] = objDataHora('data_resposta_encaminhamento', 'Prazo de Resposta', False, $js, '', 'S');

$jst = " readonly='true' style='background:{$corbloq}; font-size:12px; xwidth:100%;' ";
//$vetCampo['consideracoes_encaminhamento_pai'] = objTexto('consideracoes_encaminhamento_pai', 'Considerações de Encaminhamento para Resposta', false, 85, 500, $jst);
$maxlength = 500;
$style = "border: none;";
$style = "";
$vetCampo['consideracoes_encaminhamento_pai'] = objTextArea('consideracoes_encaminhamento_pai', "Considerações de Encaminhamento para Resposta", false, $maxlength, $style, $jst);



$vetCampo['data_resposta_encaminhamento_pai'] = objDataHora('data_resposta_encaminhamento_pai', 'Prazo para Resposta', False, $jst);


$js = " ";
$vetCampo['data_solucao_atendimento'] = objDataHora('data_solucao_atendimento', 'Data Solução', False, $js, '', 'S');
$js = "";
$vetCampo['informa_demandante'] = objCmbVetor('informa_demandante', "Informar<br />  ao Demandante?", false, $vetNaoSim, '', $js);
$js = "";
$vetCampo['enviar_email_cliente'] = objCmbVetor('enviar_email_cliente', "Encaminhar E-mail<br />  com Resolução para Cliente?", false, $vetNaoSim, ' ', $js);
$js = "";
$vetCampo['incluir_anexos_resposta_cliente'] = objCmbVetor('incluir_anexos_resposta_cliente', "Incluir o(s) Anexo(s)<br /> na Resposta ao Cliente?", false, $vetNaoSim, ' ', $js);
$maxlength = 5000;
$style = "width:850px;";
$js = "";
$vetCampo['parecer_encaminhamento'] = objTextArea('parecer_encaminhamento', 'Resposta para o Cliente', false, $maxlength, $style, $js);

$sql = "select idt, descricao from grc_atendimento_pendencia_status_tramitacao ";
$sql .= " order by codigo";
$js_hm = "";
$js_hm = " disabled  ";
$style = "font-size:12px; width:150px; background:{$corbloq};";
$vetCampo['idt_status_tramitacao'] = objCmbBanco('idt_status_tramitacao', 'Status da Tramitação', false, $sql, '', $style, $js_hm);


$vetCampo['obj_html_pendencia_historico'] = objInclude('obj_html_pendencia_historico', 'cadastro_conf/obj_html_pendencia_historico.php');

$class_frame_f = "class_frame_f";
$class_titulo_f = "class_titulo_f";
$class_frame_p = "class_frame_p";
$class_titulo_p = "class_titulo_p";
$class_frame = "class_frame";
$class_titulo = "class_titulo";

$class_titulo_px = "class_titulo_px";
$class_frame_px = "class_frame_px";

$class_titulo_c = "class_titulo_c";

$titulo_na_linha = false;

$vetFrm = Array();

if ($tipo == 'Evento') {
    $vetParametros = Array(
        'codigo_frm' => 'informacoes',
        'controle_fecha' => false,
    );
    $vetFrm[] = Frame('<span>Informações', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);
    $vetParametros = Array(
        'codigo_pai' => 'informacoes',
        'width' => '100%',
    );
    MesclarCol($vetCampo['assunto'], 9);
    MesclarCol($vetCampo['observacao'], 9);
    MesclarCol($vetCampo['nome_empreendimento'], 3);
    $vetFrm[] = Frame('<span>Assunto</span>', Array(
        Array($vetCampo['data'], '', $vetCampo['idt_usuario'], '', $vetCampo['idt_ponto_atendimento'], '', $vetCampo['protocolo'], '', $vetCampo['status']),
        Array($vetCampo['assunto']),
        Array($vetCampo['observacao']),
            ), $class_frame, $class_titulo, $titulo_na_linha);
    $vetParametros = Array(
        'codigo_frm' => 'frm_opcao_tramitacao',
        'controle_fecha' => false,
    );
    $vetFrm[] = Frame('<span>OPÇÕES DE TRAMITAÇÃO', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);
    $vetParametros = Array(
        'codigo_pai' => 'frm_opcao_tramitacao',
        'width' => '100%',
    );
    MesclarCol($vetCampo['idt_gestor_local'], 5);
    $vetFrm[] = Frame('<span>Opções da Tramitação</span>', Array(
        Array($vetCampo['idt_gestor_local'], '', $vetCampo['enviar_email'], '', $vetCampo['recorrencia'], '', $vetCampo['data_solucao']),
            ), $class_frame, $class_titulo, $titulo_na_linha);
    MesclarCol($vetCampo['solucao'], 3);
    $vetFrm[] = Frame('<span>Resolução da pendência</span>', Array(
        Array($vetCampo['solucao']),
            ), $class_frame, $class_titulo, $titulo_na_linha);
    $vetFrm[] = Frame('', Array(
        Array($vetCampo['botao_concluir_pendencia']),
            ), $class_frame, $class_titulo, $titulo_na_linha);
} else {
    $vetParametros = Array(
        'codigo_frm' => 'informacoes',
        'controle_fecha' => false,
    );
    $vetFrm[] = Frame('<span>Informações', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);
    $vetParametros = Array(
        'codigo_pai' => 'informacoes',
        'width' => '100%',
    );

    MesclarCol($vetCampo[$CampoPricPai], 11);
    MesclarCol($vetCampo['nome_empreendimento'], 3);
    MesclarCol($vetCampo['temporario'], 9);
    MesclarCol($vetCampo['assunto'], 11);
    MesclarCol($vetCampo['observacao'], 11);
    MesclarCol($vetCampo['data_solucao'], 7);

    $vetFrm[] = Frame('<span>Assunto</span>', Array(
        Array($vetCampo[$CampoPricPai]),
        Array($vetCampo['temporario'], '', $vetCampo['ativo']),
        Array($vetCampo['data'], '', $vetCampo['idt_usuario'], '', $vetCampo['idt_ponto_atendimento'], '', $vetCampo['protocolo'], '', $vetCampo['status'], '', $vetCampo['botao_historico_atendimento']),
        Array($vetCampo['cod_cliente_siac'], '', $vetCampo['nome_cliente'], '', $vetCampo['email_cliente'], '', $vetCampo['cod_empreendimento_siac'], '', $vetCampo['nome_empreendimento']),
        Array($vetCampo['enviar_email'], '', $vetCampo['recorrencia'], '', $vetCampo['data_solucao']),
        Array($vetCampo['assunto']),
        Array($vetCampo['observacao']),
            ), $class_frame, $class_titulo, $titulo_na_linha);

    $titulo = 'Anexos';
    $TabelaPrinc = "grc_atendimento_pendencia_anexo";
    $AliasPric = "grc_aa";
    $Entidade = "Anexo";
    $Entidade_p = "Anexos";

    $vetCampoLC = Array();
    $vetCampoLC['descricao'] = CriaVetTabela('Descrição do Arquivo em Anexo');
    $vetCampoLC['arquivo'] = CriaVetTabela('Arquivo Anexo', 'arquivo', '', 'grc_atendimento_pendencia_anexo');

    $sql = "select {$AliasPric}.*  ";
    $sql .= " from {$TabelaPrinc} {$AliasPric}  ";
    $sql .= " where {$AliasPric}" . '.idt_atendimento_pendencia = $vlID';
    $sql .= " and {$AliasPric}.tipo = 'C'";
    $sql .= " order by {$AliasPric}.descricao";

    if ($_GET['grc_atendimento'] != 'S') {
        $vetParametros = Array(
            'contlinfim' => '',
            'barra_inc_ap' => false,
            'barra_alt_ap' => false,
            'barra_con_ap' => true,
            'barra_exc_ap' => false,
        );
    } else {
        $vetParametros = Array(
            'contlinfim' => '',
        );
    }
    $vetCampo['grc_atendimento_pendencia_anexo'] = objListarConf('grc_atendimento_pendencia_anexo', 'idt', $vetCampoLC, $sql, $titulo, false, array_merge($vetPadraoLC, $vetParametros));

    $vetParametros = Array(
        'width' => '100%',
    );

    $vetFrm[] = Frame('', Array(
        Array($vetCampo['grc_atendimento_pendencia_anexo']),
            ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);

    $vetParametros = Array(
        'codigo_frm' => 'frm_opcao_tramitacao',
        'controle_fecha' => false,
    );
    $vetFrm[] = Frame('<span>OPÇÕES DE TRAMITAÇÃO', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);
    $vetParametros = Array(
        'codigo_pai' => 'frm_opcao_tramitacao',
        'width' => '100%',
    );

    /*
      MesclarCol($vetCampo['idt_gestor_local'], 5);
      $vetFrm[] = Frame('<span>Opções da Tramitação</span>', Array(
      Array($vetCampo['idt_gestor_local'], '', $vetCampo['enviar_email'], '', $vetCampo['recorrencia'], '', $vetCampo['data_solucao']),
      ), $class_frame, $class_titulo, $titulo_na_linha);
     */
    /*
      $vetFrm[] = Frame('<span>Opções da Tramitação</span>', Array(
      Array($vetCampo['e_ou']),
      ), $class_frame, $class_titulo, $titulo_na_linha);
     */

    // outros
    if ($_GET['grc_atendimento'] == 'S') {
        $vetFrm[] = Frame('<span>ENCAMINHAMENTO DA PENDÊNCIA</span>', '', $class_frame_px, $class_titulo_px, $titulo_na_linha_p);
        $vetFrm[] = Frame('', Array(
            //MesclarCol($vetCampo['consideracoes_encaminhamento_pai'], 3);
            //    Array($vetCampo['opcao_tramitacao'], '', $vetCampo['data_resposta_encaminhamento'], '', $vetCampo['consideracoes_encaminhamento']),
            Array($vetCampo['opcao_tramitacao']),
                ), $class_frame, $class_titulo, $titulo_na_linha);

        $vetFrm[] = Frame('', Array(
            Array($vetCampo['data_resposta_encaminhamento'], '', $vetCampo['consideracoes_encaminhamento']),
                ), $class_frame, $class_titulo, $titulo_na_linha);
    } else {
        //MesclarCol($vetCampo['consideracoes_encaminhamento_pai'], 3);
        MesclarCol($vetCampo['opcao_tramitacao'], 3);
        $vetFrm[] = Frame('<span>ENCAMINHAMENTO DA PENDÊNCIA</span>', '', $class_frame_px, $class_titulo_px, $titulo_na_linha_p);


        $vetFrm[] = Frame('', Array(
            Array($vetCampo['data_resposta_encaminhamento_pai'], '', $vetCampo['consideracoes_encaminhamento_pai']),
            //Array($vetCampo['opcao_tramitacao'], '', $vetCampo['data_resposta_encaminhamento'], '', $vetCampo['consideracoes_encaminhamento']),
            Array($vetCampo['opcao_tramitacao']),
                ), $class_frame, $class_titulo, $titulo_na_linha);

        $vetFrm[] = Frame('', Array(
            Array($vetCampo['data_resposta_encaminhamento'], '', $vetCampo['consideracoes_encaminhamento']),
                ), $class_frame, $class_titulo, $titulo_na_linha);
    }

    if ($_GET['grc_atendimento'] == 'S') {
        //  $vetFrm[] = Frame('', Array(
        //      Array($vetCampo['idt_responsavel_solucao']),
        //          ), $class_frame.' display_none', $class_titulo, $titulo_na_linha);
    } else {
        /*
          MesclarCol($vetCampo['solucao'], 3);
          $vetFrm[] = Frame('<span>Resolução da pendência</span>', Array(
          Array($vetCampo['data_dasolucao'], '', $vetCampo['idt_responsavel_solucao']),
          Array($vetCampo['solucao']),
          ), $class_frame, $class_titulo, $titulo_na_linha);
         */
    }
    //////////////////// Destinatários da pendência
    $vetParametros = Array(
        'codigo_frm' => 'grc_atendimento_pendencia_destinatario_w',
        'controle_fecha' => 'A',
        //'comcontrole' => 0,
        //'barra_inc_ap' => false,
        //'barra_alt_ap' => false,
        //'barra_con_ap' => true,
        'barra_exc_ap' => true,
            //'contlinfim' => '',
    );
    $vetFrm[] = Frame('<span>DESTINATÁRIOS PARA RESOLVER A PENDÊNCIA</span>', '', $class_frame_px, $class_titulo_px, $titulo_na_linha_p);
    // Definição de campos formato full que serão editados na tela full
    $vetCampoLC = Array();
    //Monta o vetor de Campo
    $vetCampoLC['plu_usu_nome_completo'] = CriaVetTabela('Colaborador');
    $vetCampoLC['unidade'] = CriaVetTabela('Unidade');
    $vetCampoLC['ponto_atendimento'] = CriaVetTabela('Ponto de Atendimento');
    $vetCampoLC['enviar_email_destinatario'] = CriaVetTabela('Enviar E-mail?', 'descDominio', $vetSimNao);
    //$vetCampoLC['observacao']                = CriaVetTabela('Observação');
    // Parametros da tela full conforme padrão
    $titulo = 'Destinatários da Pendência';
    $TabelaPrinc = "grc_atendimento_pendencia_destinatario";
    $AliasPric = "grc_apd";
    $Entidade = "Destinatário da Pendência do Atendimento";
    $Entidade_p = "Destinatários da Pendência do Atendimento";
    //
    // Select para obter campos da tabela que serão utilizados no full
    //
	$orderby = "plu_usu.nome_completo ";
    $sql = "select {$AliasPric}.*, ";
    $sql .= " sac_osu.descricao as unidade, ";
    $sql .= " sac_ospa.descricao as ponto_atendimento, ";
    $sql .= " plu_usu.nome_completo as plu_usu_nome_completo ";
    $sql .= " from {$TabelaPrinc} {$AliasPric}  ";
    $sql .= " inner join plu_usuario plu_usu on plu_usu.id_usuario = {$AliasPric}.idt_destinatario ";

    $sql .= " left join " . db_pir . "sca_organizacao_secao sac_osu on sac_osu.idt = {$AliasPric}.idt_unidade ";
    $sql .= " left join " . db_pir . "sca_organizacao_secao sac_ospa on sac_ospa.idt = {$AliasPric}.idt_ponto_atendimento ";


    $sql .= " where {$AliasPric}" . '.idt_pendencia = $vlID';
    $sql .= " order by {$orderby}";
    // Carrega campos que serão editados na tela full
    $vetCampo['grc_atendimento_pendencia_destinatario'] = objListarConf('grc_atendimento_pendencia_destinatario', 'idt', $vetCampoLC, $sql, $titulo, false, array_merge($vetPadraoLC, $vetParametros));
    // Fotmata lay_out de saida da tela full
    $vetParametros = Array(
        'codigo_pai' => 'grc_atendimento_pendencia_destinatario_w',
        'width' => '100%',
    );
    $vetFrm[] = Frame('', Array(
        Array($vetCampo['grc_atendimento_pendencia_destinatario']),
            ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);
//////////////

    $vetFrm[] = Frame('', Array(
        Array($vetCampo['botao_concluir_pendencia_encaminhar']),
            ), $class_frame, $class_titulo, $titulo_na_linha);

/////////////////	


    if ($_GET['grc_atendimento'] == 'S') {
        $vetFrm[] = Frame('', Array(
            Array($vetCampo['idt_responsavel_solucao'], '', $vetCampo['idt_status_tramitacao']),
                ), $class_frame . ' display_none', $class_titulo, $titulo_na_linha);
    } else {
        $vetFrm[] = Frame('<span>RESOLUÇÃO</span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p);

        MesclarCol($vetCampo['parecer_encaminhamento'], 5);
        $vetFrm[] = Frame('', Array(
            Array($vetCampo['data_solucao_atendimento'], '', $vetCampo['idt_responsavel_solucao'], '', $vetCampo['idt_status_tramitacao']),
            Array($vetCampo['informa_demandante'], '', $vetCampo['enviar_email_cliente'], '', $vetCampo['incluir_anexos_resposta_cliente']),
            Array($vetCampo['parecer_encaminhamento']),
                ), $class_frame, $class_titulo, $titulo_na_linha);
    }







//////////////////// fim resumo incluido por luiz
    $vetFrm[] = Frame('', Array(
        Array($vetCampo['botao_concluir_pendencia']),
            ), $class_frame, $class_titulo, $titulo_na_linha);

    $vetFrm[] = Frame('', Array(
        Array($vetCampo['obj_html_pendencia_historico']),
            ), $class_frame, $class_titulo, $titulo_na_linha);
}



$vetCad[] = $vetFrm;
?>
<script type="text/javascript">
//
    var idt_atendimento_pendencia = '<?php echo $idt_atendimento_pendencia; ?>';
    var idt_evento = '<?php echo $idt_evento; ?>';
    var idt_instrumento = '<?php echo $idt_instrumento; ?>';
//
    $(document).ready(function () {
        if (acao == 'inc') {
            valida_cust = 'N';
            $(':submit:first').click();
        }

        objd = document.getElementById('idt_ponto_atendimento_tf');
        if (objd != null)
        {
            $(objd).css('background', '#FFFF80');
            $(objd).attr('disabled', 'disabled');
        }

        objd = document.getElementById('assunto');
        if (objd != null)
        {
            // $(objd).css('background','#FFFF80');
            // $(objd).attr('disabled','disabled');
        }

        objd = document.getElementById('observacao');
        if (objd != null)
        {
            // $(objd).css('background','#FFFF80');
            // $(objd).attr('disabled','disabled');
        }



    });

    function parListarConf_grc_atendimento_pendencia_anexo() {
        var par = '';
        par += '&tipo=C';
        return par;
    }

    function ConfirmaEnviarParaGravar() {


        var data_solucao = "";
        objd = document.getElementById('data_solucao');
        if (objd != null)
        {
            data_solucao = $(objd).val(); // Encaminhado

        }
        var data_resposta_encaminhamento = "";
        objd = document.getElementById('data_resposta_encaminhamento');
        if (objd != null)
        {
            data_resposta_encaminhamento = $(objd).val(); // Data resposta Encaminhado

        }
        var opcao_tramitacao = "";
        /*
         objd = document.getElementById('opcao_tramitacao');
         if (objd != null)
         {
         opcao_tramitacao = $(objd).val(); // Opcao de tramitacao
         
         }
         */
        var objd = document.getElementById('opcao_tramitacao_E');
        if (objd != null)
        {
            if (objd.checked == true)
            {
                opcao_tramitacao = "E";
            }
        }
        var objd = document.getElementById('opcao_tramitacao_R');
        if (objd != null)
        {
            if (objd.checked == true)
            {
                opcao_tramitacao = "R";
            }
        }


        if (data_resposta_encaminhamento == '')
        {
            if (opcao_tramitacao == 'E')
            {
                //alert(' teste de antes de gravar' + data_solucao);
                alert("ATENÇÃO...\n\n" + ' Prazo da Resposta ' + data_resposta_encaminhamento + ' deve ser informada.');
                return false;
            }

        } else
        {
            var dif = ComparaDatas(data_solucao, data_resposta_encaminhamento);
            if (dif < 0)
            {
                alert("ATENÇÃO...\n\n" + ' Data solução Pendência ' + data_solucao + ' menor que a Data solicitada para solução ' + data_resposta_encaminhamento + "\n\n" + "Por favor, ajustar para poder registrar a Pendência.");
                return false;
            }

            if (opcao_tramitacao == 'E') {
                var ret = VerificaDestinatarios();
                if (ret == 0)
                {
                    alert("ATENÇÃO...\n\n" + ' Encaminhamento sem Destinatários' + "\n\n" + "Por favor, ajustar para poder registrar a Pendência.");
                    return false;
                }
            }
        }

        /*
         alert(' Data solução ');
         */
        return true;


    }

    function ComparaDatas(data1, data2)
    {

        var dif = 0;
        var dh1 = data1.split(" ");
        var d1 = dh1[0];
        var h1 = dh1[1];
        var d1s = d1.split("/");
        var h1s = h1.split(":");
        var nDia = d1s[0];
        var nMes = d1s[1];
        var nAno = d1s[2];
        var nHora = h1s[0];
        var nMin = h1s[1];
        var nSeg = h1s[2];
        var nMs = h1s[3];
        if (nHora == undefined)
        {
            nHora = 0;
        }
        if (nMin == undefined)
        {
            nMin = 0;
        }
        if (nSeg == undefined)
        {
            nSeg = 0;
        }
        if (nMs == undefined)
        {
            nMs = 0;
        }
        //alert("Data1 = "+nDia+'/'+nMes+'/'+nAno+ ' Hora : '+nHora+':'+nMin+':'+nSeg+':'+nMs);
        var data1w = new Date(nAno, nMes, nDia, nHora, nMin, nSeg, nMs);


        var dh2 = data2.split(" ");
        var d2 = dh2[0];
        var h2 = dh2[1];
        var d2s = d2.split("/");
        var h2s = h2.split(":");
        var nDia = d2s[0];
        var nMes = d2s[1];
        var nAno = d2s[2];
        var nHora = h2s[0];
        var nMin = h2s[1];
        var nSeg = h2s[2];
        var nMs = h2s[3];
        if (nHora == undefined)
        {
            nHora = 0;
        }
        if (nMin == undefined)
        {
            nMin = 0;
        }
        if (nSeg == undefined)
        {
            nSeg = 0;
        }
        if (nMs == undefined)
        {
            nMs = 0;
        }
        var data2w = new Date(nAno, nMes, nDia, nHora, nMin, nSeg, nMs);

        //alert("Data2 = "+nDia+'/'+nMes+'/'+nAno+ ' Hora : '+nHora+':'+nMin+':'+nSeg+':'+nMs);

        dif = data1w - data2w;

        //alert("Dif "+dif);



        return dif;
        /*
         
         
         nAno=0;
         nMes=0;
         nDia=0;
         nHora=0;
         nMin=0;
         nSeg=0;
         nMs=0;
         
         
         data2w = new Date(nAno, nMês, nDia , nHora, nMin, nSeg, nMs );
         */

    }


    function VerificaDestinatarios()
    {
        var ret = 0;
        //idt_etendimento_pendencia
        processando();

        $.ajax({
            dataType: 'json',
            type: 'POST',
            url: 'ajax_atendimento.php?tipo=VerificaDestinatarios',
            data: {
                cas: conteudo_abrir_sistema,
                idt_atendimento_pendencia: idt_atendimento_pendencia

            },
            success: function (response) {
                if (response.erro == '') {
                    ret = 1;
                } else {
                    $("#dialog-processando").remove();
                    //    alert(url_decode(response.erro));
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                $("#dialog-processando").remove();
                alert('Erro no ajax no: ' + textStatus + ' - ' + errorThrown);
            },
            async: false
        });

        $("#dialog-processando").remove();


        return ret;
    }

    function ResolvePendencia()
    {
        //     alert('vivo');
        /*
         var objd = document.getElementById('opcao_tramitacao');
         if (objd != null)
         {
         var opcao = $(objd).val(); // Opção
         alert('vivo '+opcao);
         if (opcao=='R')
         {
         $('#frm10').show();			
         $('#frm11').show();			
         $('#frm12').show();			
         //			
         $('#frm6').hide();			
         $('#frm7').hide();			
         $('#frm8').hide();			
         $('#frm9').hide();			
         }
         else
         {
         $('#frm10').hide();			
         $('#frm11').hide();			
         $('#frm12').hide();			
         //			
         $('#frm6').show();			
         $('#frm7').show();			
         $('#frm8').show();			
         $('#frm9').show();			
         }
         
         }
         */
        var objd = document.getElementById('opcao_tramitacao_R');
        if (objd != null)
        {
            if (objd.checked == true)
            {
//			    alert('sou R');
                $('#frm10').show();
                $('#frm11').show();
                $('#frm12').show();
                //			
                $('#frm6').hide();
                $('#frm7').hide();
                $('#frm8').hide();
                $('#frm9').hide();
            }
        }
        var objd = document.getElementById('opcao_tramitacao_E');
        if (objd != null)
        {
            if (objd.checked == true)
            {
//			    alert('sou E');
                $('#frm10').hide();
                $('#frm11').hide();
                $('#frm12').hide();
                //			
                $('#frm6').show();
                $('#frm7').show();
                $('#frm8').show();
                $('#frm9').show();
            }
        }
    }
</script>

