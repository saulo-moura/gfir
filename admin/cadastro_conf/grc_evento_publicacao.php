<style>
    fieldset.class_frame_f {
        background:#2F66B8;
        border:1px solid #FFFFFF;
        height:30px;
    }

    div.class_titulo_f {
        background: #2F66B8;
        border    : 1px solid #2C3E50;
        color     : #FFFFFF;
        text-align: left;
        height:30px;
        padding-top:10px;
    }

    div.class_titulo_f span {
        padding-left:20px;
        text-align: left;
    }

    fieldset.class_frame_p {
        background:#ABBBBF;
        border:1px solid #FFFFFF;
    }

    div.class_titulo_p {
        background: #ABBBBF;
        border    : 1px solid #2C3E50;
        color     : #FFFFFF;
        text-align: left;
    }

    div.class_titulo_p span {
        padding-left:20px;
        text-align: left;
    }

    fieldset.class_frame {
        background: #FFFFFF;
        border:1px solid #2C3E50;
    }

    div.class_titulo {
        background: #C4C9CD;
        border    : 1px solid #2C3E50;
        color     : #FFFFFF;
        text-align: left;
    }

    div.class_titulo span {
        padding-left:10px;
    }

    .Texto {
        border:0;
        background:#ECF0F1;
    }

    Select {
        border:0;
        background:#ECF0F1;
    }

    TextArea {
        border:0;
        background:#ECF0F1;
    }

    .TextArea {
        border:0;
        background:#ECF0F1;
    }

    div#xEditingArea {
        border:0;
        background:#ECF0F1;
    }

    .TextoFixo {
        background:#ECF0F1;
    }


    fieldset.class_frame {
        border:0;
    }

    .campo_disabled {
        background-color: #ffffd7;
    }    

    #parterepasse_tit {
        padding-left:0px;
    }

    div.Barra {
        display: none;
    }

    Td.Titulo_radio {
        width: 70px;
    }

    #aceita_cupom_can_tf {
        width: 50px;
    }

    fieldset.cupon_desconto_tit {
        border: 0;
    }
</style>
<?php
if ($_GET['idCad'] != '') {
    $_GET['idt0'] = $_GET['idCad'];
    $botao_volta = "parent.btFechaCTC('" . $_GET['session_cod'] . "');";
    $botao_acao = '<script type="text/javascript">parent.btFechaCTC("' . $_GET['session_cod'] . '");</script>';
}

$TabelaPrinc = "grc_evento_publicacao";
$AliasPric = "grc_ep";
$Entidade = "Política de Desconto do Evento";
$Entidade_p = "Política de Desconto do Eventos";
$CampoPricPai = "idt_evento";

$id = 'idt';
$tabela = $TabelaPrinc;
$barra_bt_top = false;
$onSubmitDep = 'grc_evento_publicacao_dep()';

if ($acao == 'inc') {
    $sql = '';
    $sql .= ' select idt';
    $sql .= ' from grc_evento_combo';
    $sql .= ' where idt_evento = ' . null($_GET['idt0']);
    $rs = execsql($sql);

    if ($rs->rows > 0) {
        echo '<script type="text/javascript">alert("Este evento não pode ter Política de Desconto, pois pertence a um Evento Combo!")</script>';
        echo '<script type="text/javascript">parent.btFechaCTC("' . $_GET['session_cod'] . '");</script>';
        exit();
    }
    
    $sql = '';
    $sql .= ' select idt';
    $sql .= ' from grc_evento_publicacao';
    $sql .= ' where idt_evento = ' . null($_GET['idt0']);
    $sql .= " and ativo = 'S'";
    $sql .= " and tipo_acao = 'P'";
    $sql .= " and situacao not in ('CA')"; //'AP', 
    //Verificar como vai ser uma segundo registro
    $rs = execsql($sql);

    if ($rs->rows > 0) {
        echo '<script type="text/javascript">alert("Não pode incluir um novo registro, pois tem um registro de Política de Desconto em planejamento que esta válido!")</script>';
        echo '<script type="text/javascript">parent.btFechaCTC("' . $_GET['session_cod'] . '");</script>';
        exit();
    }

    $dt_ini = trata_data($_GET['ini']);

    //Cria Registro
    $sql = 'insert into grc_evento_publicacao (idt_evento, tipo_acao, situacao, idt_responsavel, data_publicacao_ate, data_hora_fim_inscricao_ec, descricao) values (';
    $sql .= null($_GET['idt0']) . ", 'P', 'CD', " . null($_GET['idt_gestor_evento']) . ', ' . aspa($dt_ini) . ', ' . aspa($dt_ini) . ', ' . aspa($_GET['descricao']) . ')';
    execsql($sql);

    $href = str_replace('&id=0', '&id=' . lastInsertId(), $_SERVER['QUERY_STRING']);
    $href = str_replace('acao=inc&', 'acao=alt&', $href);
    echo '<script type="text/javascript">self.location = "conteudo_cadastro.php?' . $href . '";</script>';
    exit();
}

$class_frame_f = "class_frame_f";
$class_titulo_f = "class_titulo_f";
$class_frame_p = "class_frame_p";
$class_titulo_p = "class_titulo_p";
$class_frame = "class_frame";
$class_titulo = "class_titulo";
$titulo_na_linha = false;
$titulo_cadastro = "Política de Desconto do Evento";

$sql = '';
$sql .= ' select ep.*, e.idt_evento_situacao, e.idt_produto';
$sql .= ' from grc_evento_publicacao ep';
$sql .= ' inner join grc_evento e on e.idt = ep.idt_evento';
$sql .= ' where ep.idt = ' . null($_GET['id']);
$rs = execsql($sql);
$rowDados = $rs->data[0];

if ($rowDados['situacao'] == 'CD') {
    geraPublicoAlvoPoliticaDesconto($rowDados['idt_evento']);
}

if ($rowDados['situacao'] != 'CD') {
    $acao_alt_con = 'S';
}

if ($_GET['idt_pendencia'] == '' && ($rowDados['situacao'] == 'GP' || $rowDados['situacao'] == 'CG' || $rowDados['situacao'] == 'DI')) {
    $sql = '';
    $sql .= ' select idt';
    $sql .= ' from grc_atendimento_pendencia';
    $sql .= ' where idt_evento_publicacao = ' . null($_GET['id']);
    $sql .= ' and idt_responsavel_solucao = ' . null($_SESSION[CS]['g_id_usuario']);
    $sql .= " and ativo = 'S'";
    $sql .= " and tipo = 'Política de Desconto do Evento'";
    $sql .= whereAtendimentoPendencia();
    $rs = execsql($sql);
    $_GET['idt_pendencia'] = $rs->data[0][0];
}

$vetFrm = Array();

$vetCampo[$CampoPricPai] = objHidden($CampoPricPai, $_GET['idt0']);
$vetCampo['idt_usuario_situacao'] = objHidden('idt_usuario_situacao', $_SESSION[CS]['g_id_usuario']);
$vetCampo['data_situacao'] = objHidden('data_situacao', getdata(true, true, true));
$vetCampo['situacao_ant'] = objHidden('situacao_ant', $rowDados['situacao'], '', '', false);
$vetCampo['situacao'] = objFixoVetor('situacao', 'Situação', True, $vetEventoPubSituacao, ' ', '', '', '', 'CD');

$sql = "select idt, codigo, descricao from grc_evento_grupo order by descricao";
$vetCampo['idt_grupo'] = objCmbBanco('idt_grupo', 'Grande Evento', true, $sql);

$vetCampo['descricao'] = objTextoFixo('descricao', 'Evento', '', true);

$maxlength = 2000;
$style = "";
$js = "";
$vetCampo['tag_busca'] = objTextArea('tag_busca', 'TAGs Busca', false, $maxlength, $style, $js);

$vetCampo['data_publicacao_de'] = objDataHora('data_publicacao_de', 'Publicar De', true, '', '', 'S');
$vetCampo['data_publicacao_ate'] = objDataHora('data_publicacao_ate', 'Publicar  Até', true, '', '', 'S');
$vetCampo['data_hora_fim_inscricao_ec'] = objDataHora('data_hora_fim_inscricao_ec', 'Data Fim inscrição loja Virtual', true, '', '', 'S');

if ($_GET['id'] == 0) {
    $_GET['id_usuario1'] = $rowDados['idt_responsavel'];
}

$vetCampo['idt_responsavel'] = objFixoBanco('idt_responsavel', 'Responsavel pela Política de Desconto', 'plu_usuario', 'id_usuario', 'nome_completo', 1, true, '', true);
$vetCampo['data_responsavel'] = objTextoFixo('data_responsavel', 'Data Registro', 20, true, true, getdata(true, true, true));

$vetCampo['restrito'] = objCmbVetor('restrito', 'Evento Restrito?', true, $vetSimNao, '');

$desc = 'Público Alvo da Política de Desconto';
$vetFrmPA = Array();
$vetTmp = Array();
$colPA = 4 * 2;

$sql = '';
$sql .= ' select pa.idt, pa.descricao, epa.ativo';
$sql .= ' from grc_evento_publicacao_publico_alvo epa';
$sql .= ' inner join grc_publico_alvo pa on pa.idt = epa.idt_publico_alvo';
$sql .= ' where epa.idt = ' . null($_GET['id']);
$sql .= ' order by pa.descricao';
$rs = execsql($sql);

ForEach ($rs->data as $row) {
    $vetCampo['pa_' . $row['idt']] = objCheckbox('pa[' . $row['idt'] . ']', $desc, 'S', 'N', $row['descricao'], false, $row['ativo'], '', false);
    $desc = '';

    $vetTmp[] = $vetCampo['pa_' . $row['idt']];
    $vetTmp[] = '';

    if (count($vetTmp) == $colPA) {
        array_pop($vetTmp);
        $vetFrmPA[] = $vetTmp;
        $vetTmp = Array();
    }
}

if (count($vetTmp) > 0) {
    $idxFim = $colPA - 1 - count($vetTmp);

    for ($index1 = 0; $index1 < $idxFim; $index1++) {
        $vetTmp[] = '';
    }

    $vetFrmPA[] = $vetTmp;
}

$vetParametros = Array(
    'width' => '100%',
);

$vetParametrosPA = $vetParametros;
$vetParametrosPA['width'] = '';
$vetParametrosPA['align'] = 'left';

MesclarCol($vetCampo['idt_responsavel'], 3);
MesclarCol($vetCampo['idt_grupo'], 7);
MesclarCol($vetCampo['descricao'], 7);
MesclarCol($vetCampo['tag_busca'], 7);

$vetFrm[] = Frame('<span>PUBLICAÇÃO</span>', Array(
    Array($vetCampo[$CampoPricPai], '', $vetCampo['idt_usuario_situacao'], '', $vetCampo['data_situacao'], '', $vetCampo['situacao_ant']),
    Array($vetCampo['descricao']),
    Array($vetCampo['situacao'], '', $vetCampo['idt_responsavel'], '', $vetCampo['data_responsavel']),
    //Array($vetCampo['idt_grupo']),
    //Array($vetCampo['tag_busca']),
    //Array($vetCampo['data_publicacao_de'], '', $vetCampo['data_publicacao_ate'], '', $vetCampo['data_hora_fim_inscricao_ec'], '', $vetCampo['restrito']),
        ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);

$vetFrm[] = Frame('', $vetFrmPA, $class_frame, $class_titulo, $titulo_na_linha, $vetParametrosPA);

// Canal
$vetParametros = Array(
    'codigo_frm' => 'canalinscricao',
    'controle_fecha' => 'A',
);

$vetFrm[] = Frame('<span>CANAL DE INSCRIÇÃO </span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);

$vetCampoFC = Array();
$vetCampoFC['grc_eci_descricao'] = CriaVetTabela('Canal');
$vetCampoFC['quantidade_inscrito'] = CriaVetTabela('Quantidade de Inscrições');

$titulo = 'Canal de Inscrição';
$TabelaPrinc = "grc_evento_publicacao_canal";
$AliasPric = "grc_epc";
$Entidade = "Canal de inscrição";
$Entidade_p = "Canais de inscrição";
$CampoPricPai = "idt_evento_publicacao";
$orderby = "grc_eci.descricao";

$sql = "select {$AliasPric}.*, ";
$sql .= "       grc_eci.descricao as grc_eci_descricao ";
$sql .= " from {$TabelaPrinc} {$AliasPric}  ";
$sql .= " inner join grc_evento_canal_inscricao grc_eci on grc_eci.idt = {$AliasPric}.idt_canal_inscricao ";
$sql .= " where {$AliasPric}" . '.idt_evento_publicacao = $vlID';
$sql .= " order by {$orderby}";

$vetCampo['grc_evento_publicacao_canal'] = objListarConf('grc_evento_publicacao_canal', 'idt', $vetCampoFC, $sql, $titulo, false);

$vetParametros = Array(
    'codigo_pai' => 'canalinscricao',
    'width' => '100%',
);

$vetFrm[] = Frame('', Array(
    Array($vetCampo['grc_evento_publicacao_canal']),
        ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);

// brindes
/*
$vetParametros = Array(
    'codigo_frm' => 'brindesevento',
    'controle_fecha' => 'A',
);

$vetFrm[] = Frame('<span>BRINDES DO EVENTO</span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);

$vetCampoFC = Array();
$vetCampoFC['grc_eb_descricao'] = CriaVetTabela('Brinde');

$titulo = 'Brindes do Evento';
$TabelaPrinc = "grc_evento_publicacao_brinde";
$AliasPric = "grc_epb";
$Entidade = "Brinde do Evento";
$Entidade_p = "Brindes do Evento";
$CampoPricPai = "idt_evento_publicacao";
$orderby = "grc_eb.descricao";

$sql = "select {$AliasPric}.*, ";
$sql .= "       grc_eb.descricao as grc_eb_descricao ";
$sql .= " from {$TabelaPrinc} {$AliasPric}  ";
$sql .= " inner join grc_evento_brinde grc_eb on grc_eb.idt = {$AliasPric}.idt_brinde ";
$sql .= " where {$AliasPric}" . '.idt_evento_publicacao = $vlID';
$sql .= " order by {$orderby}";

$vetCampo['grc_evento_publicacao_brinde'] = objListarConf('grc_evento_publicacao_brinde', 'idt', $vetCampoFC, $sql, $titulo, false);

$vetParametros = Array(
    'codigo_pai' => 'brindesevento',
    'width' => '100%',
);

$vetFrm[] = Frame('', Array(
    Array($vetCampo['grc_evento_publicacao_brinde']),
        ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);
*/

// Anexos
$vetParametros = Array(
    'codigo_frm' => 'anexos_publicacao',
    'controle_fecha' => 'A',
);

$vetFrm[] = Frame('<span>ANEXOS</span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);

$vetCampoFC = Array();
$vetCampoFC['descricao'] = CriaVetTabela('Descrição');
$vetCampoFC['arquivo'] = CriaVetTabela('Arquivo', 'arquivo_link', '', 'grc_evento_publicacao_anexo');

$titulo = 'Anexos';
$TabelaPrinc = "grc_evento_publicacao_anexo";
$AliasPric = "grc_epa";
$Entidade = "Anexo da Política de Desconto";
$Entidade_p = "Anexos da Política de Desconto";
$CampoPricPai = "idt_evento_publicacao";
$orderby = "grc_epa.descricao";

$sql = "select {$AliasPric}.* ";
$sql .= " from {$TabelaPrinc} {$AliasPric}  ";
$sql .= " where {$AliasPric}" . '.idt_evento_publicacao = $vlID';
$sql .= " order by {$orderby}";

$vetCampo['grc_evento_publicacao_anexo'] = objListarConf('grc_evento_publicacao_anexo', 'idt', $vetCampoFC, $sql, $titulo, false);

$vetParametros = Array(
    'codigo_pai' => 'anexos_publicacao',
    'width' => '100%',
);

$vetFrm[] = Frame('', Array(
    Array($vetCampo['grc_evento_publicacao_anexo']),
        ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);

$vetFrm[] = Frame('<span>DESCONTO</span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p);

//Voucher
$vetParametros = Array(
    'codigo_frm' => 'gerador_voucher_tit',
    'controle_fecha' => 'A',
);

$vetFrm[] = Frame('<span>VOUCHER</span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);

$vetCampoFC = Array();
$vetCampoFC['descricao'] = CriaVetTabela('Descrição');
$vetCampoFC['tipo'] = CriaVetTabela('Tipo');
$vetCampoFC['quantidade'] = CriaVetTabela('Quantidade');
$vetCampoFC['perc_desconto'] = CriaVetTabela('% Desconto', 'decimal');
$vetCampoFC['data_validade'] = CriaVetTabela('Data Validade', 'data');

$titulo = 'Dados do Voucher';
$TabelaPrinc = "grc_evento_publicacao_voucher";
$AliasPric = "grc_epc";
$Entidade = "Voucher da Política de Desconto";
$Entidade_p = "Voucher da Política de Desconto";
$CampoPricPai = "idt_evento_publicacao";
$orderby = "{$AliasPric}.descricao, tv.descricao";

$sql = "select {$AliasPric}.*, concat(tv.codigo, ' - ', tv.descricao) as tipo ";
$sql .= " from {$TabelaPrinc} {$AliasPric}  ";
$sql .= " inner join grc_evento_tipo_voucher tv on tv.idt = {$AliasPric}.idt_tipo_voucher";
$sql .= " where {$AliasPric}" . '.idt_evento_publicacao = $vlID';
$sql .= " order by {$orderby}";

$vetCampo['grc_evento_publicacao_voucher'] = objListarConf('grc_evento_publicacao_voucher', 'idt', $vetCampoFC, $sql, $titulo, false);

$vetParametros = Array(
    'codigo_pai' => 'gerador_voucher_tit',
    'width' => '100%',
);

$vetCampo['gerador_voucher'] = objCmbVetor('gerador_voucher', 'Utilizar Voucher?', true, $vetNaoSim, '');

$vetFrm[] = Frame('', Array(
    Array($vetCampo['gerador_voucher']),
        ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);

$vetFrm[] = Frame('<span>Dados do Voucher</span>', Array(
    Array($vetCampo['grc_evento_publicacao_voucher']),
        ), $class_frame . ' gerador_voucher_frm', $class_titulo, $titulo_na_linha, $vetParametros);

/*
  $vetCampoFC = Array();
  $vetCampoFC['descricao'] = CriaVetTabela('Descrição');
  $vetCampoFC['numero'] = CriaVetTabela('Número');
  $vetCampoFC['pessoa'] = CriaVetTabela('NOME DO CLIENTE / CPF');
  $vetCampoFC['empreendimento'] = CriaVetTabela('NOME DO EMPREENDIMENTO / CNPJ');
  $vetCampoFC['dt_utilizacao'] = CriaVetTabela('Dt. Utilização', 'data');

  $titulo = 'Registro do Voucher';
  $TabelaPrinc = "grc_evento_publicacao_voucher_registro";
  $AliasPric = "grc_epc";
  $orderby = "{$AliasPric}.numero";

  $sql = "select {$AliasPric}.*, v.descricao,";
  $sql .= " concat_ws('<br />', {$AliasPric}.nome_pessoa, {$AliasPric}.cpf) as pessoa";
  $sql .= " from {$TabelaPrinc} {$AliasPric} ";
  $sql .= " inner join grc_evento_publicacao_voucher v on v.idt = {$AliasPric}.idt_evento_publicacao_voucher";
  $sql .= " where {$AliasPric}" . '.idt_evento_publicacao = $vlID';
  $sql .= ' and v.idt_tipo_voucher = ' . null($vetTipoVoucherCodIDT['B']);
  $sql .= " order by {$orderby}";

  $vetParametrosLC = Array(
  'func_trata_row' => trata_row_grc_evento_publicacao_voucher_registro,
  'barra_icone' => true,
  'barra_inc_ap' => false,
  'barra_exc_ap' => false,
  );

  $vetCampo['grc_evento_publicacao_voucher_registro'] = objListarConf('grc_evento_publicacao_voucher_registro', 'idt', $vetCampoFC, $sql, $titulo, false, $vetParametrosLC);

  $vetFrm[] = Frame('<span>Registro do Voucher - Tipo B</span>', Array(
  Array($vetCampo['grc_evento_publicacao_voucher_registro']),
  ), $class_frame . ' gerador_voucher_frm gerador_voucher_b', $class_titulo, $titulo_na_linha, $vetParametros);
 */

if ($rowDados['situacao'] == 'AP') {
    $vetCampoFC = Array();
    $vetCampoFC['descricao'] = CriaVetTabela('Descrição');
    $vetCampoFC['numero'] = CriaVetTabela('Número');
    $vetCampoFC['pessoa'] = CriaVetTabela('NOME DO CLIENTE / CPF');
    $vetCampoFC['ativo'] = CriaVetTabela('Ativo', 'descDominio', $vetSimNao);
    $vetCampoFC['dt_utilizacao'] = CriaVetTabela('Dt. Utilização', 'data');

    $titulo = 'Registro do Voucher';
    $TabelaPrinc = "grc_evento_publicacao_voucher_registro";
    $AliasPric = "grc_epc";
    $orderby = "{$AliasPric}.numero";

    $sql = "select {$AliasPric}.*, v.descricao,";
    $sql .= " concat_ws('<br />', {$AliasPric}.nome_pessoa, {$AliasPric}.cpf) as pessoa";
    $sql .= " from {$TabelaPrinc} {$AliasPric} ";
    $sql .= " inner join grc_evento_publicacao_voucher v on v.idt = {$AliasPric}.idt_evento_publicacao_voucher";
    $sql .= " where {$AliasPric}" . '.idt_evento_publicacao = $vlID';
    $sql .= ' and v.idt_tipo_voucher <> ' . null($vetTipoVoucherCodIDT['B']);
    $sql .= " order by {$orderby}";

    $vetParametrosLC = Array(
        'comcontrole' => '0',
        'barra_inc_ap' => false,
        'barra_alt_ap' => false,
        'barra_con_ap' => false,
        'barra_exc_ap' => false,
    );

    $vetCampo['grc_evento_publicacao_voucher_registro_o'] = objListarConf('grc_evento_publicacao_voucher_registro_o', 'idt', $vetCampoFC, $sql, $titulo, false, $vetParametrosLC);

    $vetFrm[] = Frame('<span>Registro do Voucher - Outros</span>', Array(
        Array($vetCampo['grc_evento_publicacao_voucher_registro_o']),
            ), $class_frame . ' gerador_voucher_frm', $class_titulo, $titulo_na_linha, $vetParametros);
}

// Cupom
$vetParametros = Array(
    'codigo_frm' => 'cupon_desconto_tit',
    'controle_fecha' => 'A',
);

$vetFrm[] = Frame('<span>CUPOM</span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);

$vetParametros = Array(
    'codigo_pai' => 'cupon_desconto_tit',
    'width' => '100%',
);

$vetCampo['cupon_desconto'] = objCmbVetor('cupon_desconto', 'Cupom de Desconto?', true, $vetSimNao, '');

if ($rowDados['situacao'] == 'CD') {
    if ($vetConf['evento_publicacao_cupom_can'] == 'Sim' || $vetConf['evento_publicacao_cupom_can'] == 'Não') {
        $rowDados['aceita_cupom_can'] = $vetConf['evento_publicacao_cupom_can'][0];

        $sql = 'update grc_evento_publicacao set aceita_cupom_can = ' . aspa($rowDados['aceita_cupom_can']);
        $sql .= ' where idt = ' . null($_GET['id']);
        execsql($sql);

        $vetCampo['aceita_cupom_can'] = objFixoVetor('aceita_cupom_can', 'Aceita Cupom de Cancelamento?', True, $vetSimNao);
    } else {
        $vetCampo['aceita_cupom_can'] = objCmbVetor('aceita_cupom_can', 'Aceita Cupom de Cancelamento?', true, $vetSimNao);
    }
} else {
    $vetCampo['aceita_cupom_can'] = objFixoVetor('aceita_cupom_can', 'Aceita Cupom de Cancelamento?', True, $vetSimNao);
}

$vetFrm[] = Frame('', Array(
    Array($vetCampo['cupon_desconto'], '', $vetCampo['aceita_cupom_can']),
        ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);

$vetCad[] = $vetFrm;

$vetParametrosMC = $vetParametros;
$vetParametrosMC['situacao'] = $rowDados['situacao'];

//grd1
MesclarCadastro('grc_evento_publicacao_cupom', 'idt_evento_publicacao', $vetCad, $vetParametrosMC, '', false, false);

$par = 'idt_evento_cupom,qtd_resevada';
$vetDesativa['cupon_desconto'][0] = vetDesativa($par);
$vetAtivadoObr['cupon_desconto'][0] = vetAtivadoObr($par);

$vetFrm = Array();

// Porte
$vetParametros = Array(
    'codigo_frm' => 'desconto_porte_tit',
    'controle_fecha' => 'A',
);

$vetFrm[] = Frame('<span>DESCONTO POR PORTE</span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);

$vetCampoFC = Array();
$vetCampoFC['gec_p_descricao'] = CriaVetTabela('Porte');
$vetCampoFC['percentual_desconto'] = CriaVetTabela('% Desconto', 'decimal');

$titulo = 'Desconto por Porte';
$TabelaPrinc = "grc_evento_publicacao_porte";
$AliasPric = "grc_epp";
$Entidade = "Porte para Desconto na inscrição";
$Entidade_p = "Portes para Desconto na  inscrição";
$CampoPricPai = "idt_evento_publicacao";
$orderby = "gec_p.descricao";

$sql = "select {$AliasPric}.*, ";
$sql .= "       gec_p.descricao as gec_p_descricao ";
$sql .= " from {$TabelaPrinc} {$AliasPric}  ";
$sql .= " inner join " . db_pir_gec . "gec_organizacao_porte gec_p on gec_p.idt = {$AliasPric}.idt_porte ";
$sql .= " where {$AliasPric}" . '.idt_evento_publicacao = $vlID';
$sql .= " order by {$orderby}";

$vetCampo['grc_evento_publicacao_porte'] = objListarConf('grc_evento_publicacao_porte', 'idt', $vetCampoFC, $sql, $titulo, false);

$vetParametros = Array(
    'codigo_pai' => 'desconto_porte_tit',
    'width' => '100%',
);

$vetCampo['desconto_porte'] = objCmbVetor('desconto_porte', 'Desconto por Porte?', true, $vetNaoSim, '');

$vetFrm[] = Frame('', Array(
    Array($vetCampo['desconto_porte']),
        ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);

$vetFrm[] = Frame('', Array(
    Array($vetCampo['grc_evento_publicacao_porte']),
        ), $class_frame . ' desconto_porte_frm', $class_titulo, $titulo_na_linha, $vetParametros);

//Campos Adicionais

$vetParametros = Array(
    'width' => '100%',
);

$maxlength = 2000;
$style = "";
$js = "";
$vetCampo['observacao'] = objTextArea('observacao', 'Observação', false, $maxlength, $style, $js);

$vetFrm[] = Frame('', Array(
    Array($vetCampo['observacao']),
        ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);

$vetCampo['grc_evento_publicacao_bt'] = objInclude('grc_evento_publicacao_bt', 'cadastro_conf/grc_evento_publicacao_bt.php');

$vetFrm[] = Frame('', Array(
    Array($vetCampo['grc_evento_publicacao_bt']),
        ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);

$vetCad[] = $vetFrm;
?>
<script type="text/javascript">
    var situacao = '<?php echo $rowDados['situacao']; ?>';

    $(document).ready(function () {
        $('#gerador_voucher').change(function () {
            if ($(this).val() == 'S') {
                $('fieldset.gerador_voucher_frm').show();
                $('fieldset.gerador_voucher_frm').data('bt_controle_fecha_estado', 'A');
                $('#grc_evento_publicacao_voucher_desc').addClass("Tit_Campo_Obr").removeClass("Tit_Campo");
            } else {
                $('fieldset.gerador_voucher_frm').hide();
                $('fieldset.gerador_voucher_frm').data('bt_controle_fecha_estado', 'F');
                $('#grc_evento_publicacao_voucher_desc').addClass("Tit_Campo").removeClass("Tit_Campo_Obr");
            }
        }).change();

        $('#cupon_desconto').change(function () {
            if ($(this).val() == 'S') {
                $('#grd1').show();
                $('#grd1').data('bt_controle_fecha_estado', 'A');
                $('#grc_evento_publicacao_cupom_desc').addClass("Tit_Campo_Obr").removeClass("Tit_Campo");
            } else {
                $('#grd1').hide();
                $('#grd1').data('bt_controle_fecha_estado', 'F');
                $('#grc_evento_publicacao_cupom_desc').addClass("Tit_Campo").removeClass("Tit_Campo_Obr");
            }
        }).change();

        $('#desconto_porte').change(function () {
            if ($(this).val() == 'S') {
                $('fieldset.desconto_porte_frm').show();
                $('fieldset.desconto_porte_frm').data('bt_controle_fecha_estado', 'A');
                $('#grc_evento_publicacao_porte_desc').addClass("Tit_Campo_Obr").removeClass("Tit_Campo");
            } else {
                $('fieldset.desconto_porte_frm').hide();
                $('fieldset.desconto_porte_frm').data('bt_controle_fecha_estado', 'F');
                $('#grc_evento_publicacao_porte_desc').addClass("Tit_Campo").removeClass("Tit_Campo_Obr");
            }
        }).change();

        gerador_voucher_b();
    });

    function gerador_voucher_b() {
        if ($('#grc_evento_publicacao_voucher_registro_tot').val() == '' || $('#grc_evento_publicacao_voucher_registro_tot').val() == '0') {
            $('fieldset.gerador_voucher_b').hide();
        } else {
            $('fieldset.gerador_voucher_b').show();
        }
    }

    function bt_controle_fecha_estado() {
        if ($('fieldset.gerador_voucher_frm').data('bt_controle_fecha_estado') == 'F') {
            $('fieldset.gerador_voucher_frm').hide();
        } else if ($('fieldset.gerador_voucher_frm').data('bt_controle_fecha_estado') == 'A') {
            if ($('fieldset.gerador_voucher_tit:first').is(":visible")) {
                $("fieldset.gerador_voucher_frm").show();
            }
        }

        if ($('#grd1').data('bt_controle_fecha_estado') == 'F') {
            $('#grd1').hide();
        } else if ($('#grd1').data('bt_controle_fecha_estado') == 'A') {
            if ($('fieldset.cupon_desconto_tit:first').is(":visible")) {
                $("#grd1").show();
            }
        }

        if ($('fieldset.desconto_porte_frm').data('bt_controle_fecha_estado') == 'F') {
            $('fieldset.desconto_porte_frm').hide();
        } else if ($('fieldset.desconto_porte_frm').data('bt_controle_fecha_estado') == 'A') {
            if ($('fieldset.desconto_porte_tit:first').is(":visible")) {
                $("fieldset.desconto_porte_frm").show();
            }
        }

        gerador_voucher_b();
    }

    function parListarConf_grc_evento_publicacao_voucher_registro() {
        var par = '';

        par += '&veio=ep';

        return par;
    }

    function parListarConf_grc_evento_publicacao_voucher() {
        var par = '';

        /*
        if ($('#data_publicacao_de').val() == '') {
            alert('Favor informar o Publicar De!');
            $('#data_publicacao_de').focus();
            return false;
        }

        if ($('#data_publicacao_ate').val() == '') {
            alert('Favor informar o Publicar Até!');
            $('#data_publicacao_ate').focus();
            return false;
        }

        if ($('#data_hora_fim_inscricao_ec').val() == '') {
            alert('Favor informar a Data Fim inscrição loja Virtual!');
            $('#data_hora_fim_inscricao_ec').focus();
            return false;
        }
        */

        par += '&data_publicacao_de=' + parent.$('#data_publicacao_de').val();
        par += '&data_publicacao_ate=' + parent.$('#data_publicacao_ate').val();
        par += '&data_hora_fim_inscricao_ec=' + parent.$('#data_hora_fim_inscricao_ec').val();

        return par;
    }

    function funcaoFechaCTC_grc_evento_publicacao_voucher() {
        processando();

        btFechaCTC($('#grc_evento_publicacao_voucher').data('session_cod'));
        btFechaCTC($('#grc_evento_publicacao_voucher_registro').data('session_cod'));
        gerador_voucher_b();

        $('#dialog-processando').remove();
    }

    function funcaoFechaCTC_grc_evento_publicacao_voucher_ant(idt_evento_publicacao_voucher) {
        var qtd = 0;

        processando();

        $.ajax({
            dataType: 'json',
            type: 'POST',
            url: ajax_sistema + '?tipo=grc_evento_publicacao_voucher_ant',
            data: {
                cas: conteudo_abrir_sistema,
                idt: $('#id').val()
            },
            success: function (response) {
                qtd = response.qtd;

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

        if (qtd == 0) {
            return true;
        }

        if (confirm('O registro de Voucher vai ser excluido, pois não foi informados todas as Pessoas Fisicas!\nDeseja continuar?')) {
            processando();

            $.ajax({
                dataType: 'json',
                type: 'POST',
                url: ajax_sistema + '?tipo=grc_evento_publicacao_voucher_del',
                data: {
                    cas: conteudo_abrir_sistema,
                    idt: idt_evento_publicacao_voucher
                },
                success: function (response) {
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

            return true;
        }

        return false;
    }

    function grc_evento_publicacao_dep() {
        if (valida == 'S') {
            /*
            if (situacao == 'CD') {
                if (validaDataMaior(false, $('#data_publicacao_de'), 'Publicar De', $('#dtBancoObj'), 'Hoje') === false) {
                    return false;
                }

                if (validaDataMenorStr(false, $('#data_publicacao_ate'), 'Publicar Até', '<?php echo $_GET['ini'] ?>', 'Início do Evento') === false) {
                    return false;
                }

                var dt_ini = newDataHoraStr(false, $('#data_publicacao_de').val());
                var dt_fim = newDataHoraStr(false, $('#data_publicacao_ate').val());

                if (dt_fim - dt_ini < 0) {
                    alert('A Data Publicar Até não pode ser menor que a Data Publicar De!');
                    $('#data_publicacao_ate').val('');
                    $('#data_publicacao_ate').focus();
                    return false;
                }

                if (validaDataMaior(true, $('#data_hora_fim_inscricao_ec'), 'Data Fim inscrição loja Virtual', $('#data_publicacao_de'), 'Publicar De') === false) {
                    return false;
                }

                if (validaDataMenor(true, $('#data_hora_fim_inscricao_ec'), 'Data Fim inscrição loja Virtual', $('#data_publicacao_ate'), 'Publicar Até') === false) {
                    return false;
                }
            }

            if ($('#restrito').val() == 'S') {
                var erro = true;

                $('input[name^="pa["').each(function () {
                    if ($(this).prop('checked')) {
                        erro = false;
                    }
                });

                if (erro) {
                    alert('Favor informar o Público Alvo da Política de Desconto!');
                    return false;
                }
            }
            */

            var erro = '';

            processando();

            $.ajax({
                dataType: 'json',
                type: 'POST',
                url: ajax_sistema + '?tipo=grc_evento_publicacao_dep',
                data: {
                    cas: conteudo_abrir_sistema,
                    quantidade_participante: '<?php echo $_GET['quantidade_participante'] ?>',
                    data_publicacao_de: parent.$('#data_publicacao_de').val(),
                    data_hora_fim_inscricao_ec: parent.$('#data_hora_fim_inscricao_ec').val(),
                    cupon_desconto: $('#cupon_desconto').val(),
                    gerador_voucher: $('#gerador_voucher').val(),
                    idt: $('#id').val()
                },
                success: function (response) {
                    if (response.erro != '') {
                        erro += url_decode(response.erro);
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert('Erro no ajax no: ' + textStatus + ' - ' + errorThrown);
                },
                async: false
            });

            $('#dialog-processando').remove();

            if (erro != '') {
                alert(erro);
                return false;
            }
        }

        return grc_evento_publicacao_cupom_dep();
    }
</script>