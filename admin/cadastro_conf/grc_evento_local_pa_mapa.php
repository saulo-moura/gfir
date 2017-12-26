<style>
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
        border    : 0px solid #2C3E50;
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
        height:28px;
    }

    .TextoFixo {
        font-size:12px;
        text-align:left;
        border:0px;
        font-weight:normal;
        font-family: Lato Regular, Calibri, Arial,  Helvetica, sans-serif;
        font-style: normal;
        word-spacing: 0px;
        padding-top:5px;
    }

    .Tit_Campo {
        font-size:12px;
    }

    td.Titulo {
        color:#666666;
    }

    .Texto {
        padding: 3px;
        padding-top: 5px;
        border:0;
    }

    #idt_local_pa_tf {
        width: 700px;
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
$class_frame_f = "class_frame_f";
$class_titulo_f = "class_titulo_f";
$class_frame_p = "class_frame_p";
$class_titulo_p = "class_titulo_p";
$class_frame = "class_frame";
$class_titulo = "class_titulo";
$class_titulo_c = "class_titulo_c";
$titulo_na_linha = false;

if ($_GET['idCad'] != '') {
    $_GET['idt0'] = $_GET['idCad'];
    $botao_volta = "parent.btFechaCTC('" . $_GET['session_cod'] . "');";
    $botao_acao = '<script type="text/javascript">parent.btFechaCTC("' . $_GET['session_cod'] . '");</script>';
}

$tabela = 'grc_evento_local_pa_mapa';
$id = 'idt';
$TabelaPai = "grc_evento_local_pa";
$AliasPai = "grc_elpa";
$EntidadePai = "Local da Unidade Regional/PA´s";
$idPai = "idt";
$CampoPricPai = "idt_local_pa";

$vetCampo[$CampoPricPai] = objFixoBanco($CampoPricPai, $EntidadePai, $TabelaPai, $idPai, 'descricao', 0);
$vetCampo['codigo'] = objAutoNum('codigo', 'Código Mapa', 15, true, 2);
$vetCampo['descricao'] = objTexto('descricao', 'Descrição', true, 80, 120);
$vetCampo['ativo'] = objCmbVetor('ativo', 'Ativo?', True, $vetSimNao, '');
$vetCampo['assento_mapa'] = objFile('assento_mapa', 'Mapa de assentos', false, 120, 'todos');

$maxlength = 2000;
$style = "width:700px;";
$js = "";
$vetCampo['detalhe'] = objTextArea('detalhe', 'Observação', false, $maxlength, $style);

if ($_GET['idt0'] > 0) {
    $vetFrm[] = Frame('', Array(
        Array($vetCampo[$CampoPricPai]),
            ), $class_frame, $class_titulo, $titulo_na_linha);
}

MesclarCol($vetCampo['detalhe'], 5);
MesclarCol($vetCampo['assento_mapa'], 5);

$vetFrm[] = Frame('', Array(
    Array($vetCampo['codigo'], '', $vetCampo['descricao'], '', $vetCampo['ativo']),
    Array($vetCampo['detalhe']),
    Array($vetCampo['assento_mapa']),
        ), $class_frame, $class_titulo, $titulo_na_linha);

if ($_GET['id'] > 0) {
    // ASSENTOS DO MAPA DA SALA
    $vetParametros = Array(
        'codigo_frm' => 'mapasala',
        'controle_fecha' => 'A',
    );

    $vetFrm[] = Frame('<span>Mapa da Sala</span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);

    $vetParametros = Array(
        'codigo_pai' => 'mapasala',
        'width' => '100%',
    );

    $vetCampo['grc_evento_local_pa_mapa_assento_tabela'] = objInclude('grc_evento_local_pa_mapa_assento_tabela', 'cadastro_conf/grc_evento_local_pa_mapa_assento_tabela.php');

    $vetFrm[] = Frame('', Array(
        Array($vetCampo['grc_evento_local_pa_mapa_assento_tabela']),
            ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);

    if ($acao == 'alt') {
        //Facilitadores
        $vetCampo['ab_ini'] = objTexto('ab_ini', 'Coordenada Inicial', false, 10, 45, '', '', false);
        $vetCampo['ab_fim'] = objTexto('ab_fim', 'Coordenada Final', false, 10, 45, '', '', false);

        $sql = "select idt, descricao from grc_evento_local_pa_tipo_assento order by descricao";
        $vetCampo['ab_idt_tipo_assento'] = objCmbBanco('ab_idt_tipo_assento', 'Tipo de Assento', false, $sql, ' ', 'width:180px;', '', false);

        $vetCampo['ab_ativo'] = objCmbVetor('ab_ativo', 'Ativo?', false, $vetSimNao, ' ', '', '', false);

        $vetCampo['grc_evento_local_pa_mapa_bt'] = objInclude('grc_evento_local_pa_mapa_bt', 'cadastro_conf/grc_evento_local_pa_mapa_bt.php');

        unset($vetParametros['width']);

        MesclarCol($vetCampo['grc_evento_local_pa_mapa_bt'], 7);

        $vetFrm[] = Frame('<span>Alteraçao em Bloco</span>', Array(
            Array($vetCampo['ab_ini'], '', $vetCampo['ab_fim'], '', $vetCampo['ab_idt_tipo_assento'], '', $vetCampo['ab_ativo']),
            Array($vetCampo['grc_evento_local_pa_mapa_bt']),
                ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);
    }
}

$vetParametros = Array(
    'codigo_frm' => 'assentosmapasala',
    'controle_fecha' => 'F',
    'width' => '100%',
);

$vetFrm[] = Frame('<span>Assentos do Mapa da Sala</span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);

$vetCampoLC = Array();
$vetCampoLC['codigo'] = CriaVetTabela('Código');
$vetCampoLC['descricao'] = CriaVetTabela('Descrição');
$vetCampoLC['grc_elpta_descricao'] = CriaVetTabela('Tipo');
$vetCampoLC['linha'] = CriaVetTabela('Linha');
$vetCampoLC['coluna'] = CriaVetTabela('Coluna');
$vetCampoLC['ativo'] = CriaVetTabela('Ativo?', 'descDominio', $vetSimNao);

$titulo = 'Assentos do Mapa da Sala';

$TabelaPrinc = "grc_evento_local_pa_mapa_assento";
$AliasPric = "grc_elpma";
$Entidade = "Assento do Mapa da Sala";
$Entidade_p = "Assentos do Mapas das Sala";
$CampoPricPai = "idt_local_pa_mapa";
$orderby = "{$AliasPric}.linha, {$AliasPric}.coluna";

$sql = "select {$AliasPric}.*, ";
$sql .= "  grc_elpta.descricao as grc_elpta_descricao  ";
$sql .= " from {$TabelaPrinc} {$AliasPric}  ";
$sql .= " inner join grc_evento_local_pa_tipo_assento grc_elpta on  grc_elpta.idt = {$AliasPric}.idt_tipo_assento ";
$sql .= " where {$AliasPric}" . '.idt_local_pa_mapa = $vlID';
$sql .= " order by {$orderby}";

$vetCampo['grc_evento_local_pa_mapa_assento'] = objListarConf('grc_evento_local_pa_mapa_assento', 'idt', $vetCampoLC, $sql, $titulo, false, $vetParametros);

$vetParametros = Array(
    'codigo_pai' => 'assentosmapasala',
    'width' => '100%',
);

$vetFrm[] = Frame('', Array(
    Array($vetCampo['grc_evento_local_pa_mapa_assento']),
        ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);


$vetCad[] = $vetFrm;
?>
<script type="text/javascript">
    function funcaoFechaCTC_grc_evento_local_pa_mapa_assento() {
        processando();

        $.ajax({
            dataType: 'html',
            type: 'POST',
            url: ajax_sistema + '?tipo=grc_evento_local_pa_mapa_assento_tabela',
            data: {
                cas: conteudo_abrir_sistema,
                acao: '<?php echo $acao; ?>',
                id: $('#id').val()
            },
            success: function (response) {
                $('#grc_evento_local_pa_mapa_assento_tabela_desc').html(url_decode(response));
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert('Erro no ajax no: ' + textStatus + ' - ' + errorThrown);
            },
            async: false
        });

        $('#dialog-processando').remove();
    }

    function abreALT(idt) {
        $("#grc_evento_local_pa_mapa_assento_desc a.Titulo[data-id='" + idt + "'][data-acao='alt']").click();
    }
</script>
