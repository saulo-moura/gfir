<style>
    div#grd1 {
        xfloat: left;
        xwidth: 25%;
        xheight:500px;
        xbackground-color: fuchsia;
        xborder-right:2px solid red;
        xbackground-color: #ECF0F1;
        xoverflow:scroll;
        xoverflow-y: scroll;
    }

    div#grd2 {
        xfloat: left;
        xwidth: 75%;
        xbackground-color: lime;
    }

    div#grd3 {
        xfloat: left;
        xmargin-top:20px;
    }

    #nm_funcao_desc label{
    }
    #nm_funcao_obj {
    }
    .Tit_Campo {
    }
    .Tit_Campo_Obr {
    }
    fieldset.class_frame_f {
        background:#2F66B8;
        border:1px solid #FFFFFF;
        guyheight:30px;
    }
    div.class_titulo_f {
        background: #2F66B8;
        border    : 1px solid #2C3E50;
        color     : #FFFFFF;
        text-align: left;
        guyheight:30px;
        padding-top:10px;
    }
    div.class_titulo_f span {
        padding-left:20px;
        text-align: left;
    }

    fieldset.class_frame_p {
        xbackground:#ABBBBF;
        xborder:1px solid #FFFFFF;

        background:#FFFFFF;
        border:0px solid #FFFFFF;



    }
    div.class_titulo_p {
        text-align: left;
        background: #C4C9CD;
        xbackground:#006ca8;
        border    : 0px solid #2C3E50;
        color     : #FFFFFF;
    }
    div.class_titulo_p span {
        padding-left:20px;
        text-align: left;
    }



    fieldset.class_frame {
        xbackground:#ECF0F1;
        xborder:1px solid #2C3E50;
        background:#FFFFFF;
        border:0px solid #2C3E50;
    }
    div.class_titulo {
        xbackground: #C4C9CD;
        xborder    : 1px solid #2C3E50;
        xcolor     : #FFFFFF;
        text-align: left;

        background: #FFFFFF;
        color     : #FFFFFF;
        border    : 0px solid #2C3E50;


    }
    div.class_titulo span {
        padding-left:10px;
    }

    Select {
        border:0px;
        xopacity: 0;
        xfilter:alpha(opacity=0);
    }

    .TextoFixo {

        font-size:12px;
        guyheight:25px;
        text-align:left;
        border:0px;
        xbackground:#F1F1F1;
        background:#ECF0F1;


        font-weight:normal;

        font-family: Lato Regular, Calibri, Arial,  Helvetica, sans-serif;
        color:#5C6D7E;
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


    div#topo {
        wwxwidth:900px;
    }
    div#geral {
        wwxwidth:900px;
    }

    div#grd0 {
        wwxwidth:700px;
        wwxmargin-left:200px;

    }

    div#meio_util {
        wwxwidth:700px;
        wwxmargin-left:70px;
    }
    td.Titulo {
        color:#666666;
    }



    div.Barra td {
        height: 30px;
    }

    /*
    div.Barra input {
        display: none;
    }
    */

    .radio_representa {
        margin: 0px 4px;
        vertical-align: middle;
    }
</style>

<?php
$numParte = 1;
$barra_bt_top = false;

$vetPadraoLC = Array(
    'barra_inc_img' => "imagens/incluir_16.png",
    'barra_alt_img' => "imagens/alterar_16.png",
    'barra_con_img' => "imagens/consultar_16.png",
    'barra_exc_img' => "imagens/excluir_16.png",
);

if (!is_bool($so_aba_um)) {
    if ($_GET['so_aba_um'] == 'S') {
        $so_aba_um = true;
    } else {
        $so_aba_um = false;
    }
}

if ($idt_atendimento_agenda == '') {
    $idt_atendimento_agenda = $_GET['idt_atendimento_agenda'];
}

if ($idt_atendimento == '') {
    $idt_atendimento = $_GET['idt_atendimento'];
}

$_GET['idt_atendimento'] = $idt_atendimento;
$_GET['idt_atendimento_agenda'] = $idt_atendimento_agenda;

$vetConfMsg['alt'] = 'Este cadastro será gravado e integrado com o SIACWEB para avançar a próxima etapa deste atendimento.\n\nConfirma?';
$bt_alterar_lbl = 'Avançar';

$onSubmitDep = 'grc_atendimento_cadastro_dep()';

if ($_GET['idCad'] != '') {
    $_GET['idt0'] = $_GET['idCad'];
}
$tabela = 'grc_atendimento';
$id = 'idt';

$corbloq = "#FFFFD2";
$corbloq = "#F1F1F1";
$corbloq = "#ECF0F1";

$TabelaPai = "grc_atendimento_agenda";
$AliasPai = "grc_aa";
$EntidadePai = "Agenda";
$idPai = "idt";
//
$TabelaPrinc = "grc_atendimento";
$AliasPric = "grc_a";
$Entidade = "Atendimento da Agenda";
$Entidade_p = "Atendimentos da Agenda";
$CampoPricPai = "idt_atendimento_agenda";
//
// $vetCampo[$CampoPricPai] = objFixoBanco($CampoPricPai, $EntidadePai, $TabelaPai, 'idt', 'idt', 0);
//p($_GET);
$idt_cliente = 0;
$idt_ponto_atendimento = 0;
$idt_pessoa = 0;
$idt_projeto = 0;
$idt_projeto_acao = 0;
$idt_atendimento = $_GET['id'];
$inc_cont = $_GET['cont'];
$idt_ponto_atendimento = $_GET['idt0'];
// p($_GET);
// exit();
$codigo_tema = "";
$idt_tema_produto_interesse = "";

if ($acao != 'inc') {
    $sql = "select  ";
    $sql .= " grc_a.*, gestor, grc_ps.descricao as etapa  ";
    $sql .= " from grc_atendimento grc_a ";
    $sql .= " left join grc_projeto grc_p on grc_p.idt = grc_a.idt_projeto ";
    $sql .= " left join grc_projeto_situacao grc_ps on grc_ps.idt = grc_p.idt_projeto_situacao ";
    $sql .= " where grc_a.idt = {$idt_atendimento} ";
    $rs = execsql($sql);
    $wcodigo = '';
    ForEach ($rs->data as $row) {
        $idt_cliente = $row['idt_cliente'];
        $idt_ponto_atendimento = $row['idt_ponto_atendimento'];
        $idt_pessoa = $row['idt_pessoa'];
        $idt_projeto = $row['idt_projeto'];
        $idt_projeto_acao = $row['idt_projeto_acao'];
        $idt_consultor = $row['idt_consultor'];
        $idt_instrumento = $row['idt_instrumento'];
        $situacao = $row['situacao'];
        $gestor_sge = $row['gestor'];
        $fase_acao_projeto = $row['etapa'];
        //$instrumento        = $row['idt_instrumento'];
    }
    if ($situacao == 'Finalizado' or $situacao == 'Cancelado') {
        $acao = 'con';
        $_GET['acao'] = $acao;
    }
} else {

    $idt_consultor = $_SESSION[CS]['g_id_usuario'];
    //  $idt_ponto_atendimento     = $_SESSION[CS]['g_idt_unidade_regional'];
    $idt_projeto = $_SESSION[CS]['g_idt_projeto'];
    $idt_projeto_acao = $_SESSION[CS]['g_idt_acao'];
    $idt_instrumento = $instrumento;
    $gestor_sge = $_SESSION[CS]['g_projeto_gestor'];
    $fase_acao_projeto = $_SESSION[CS]['g_projeto_etapa'];

    if ($inc_cont != 's') {
        $datadia = date('d/m/Y H:i:s');
        $vet = explode(' ', $datadia);
        $data_inicial = trata_data($vet[0]);
        $hora_inicial = substr($vet[1], 0, 5);
        $idt_atendimentow = 0;
        //echo " t^entramdo <br />";
        // GeraAtendimentoHE($idt_consultor,$idt_ponto_atendimento,$data_inicial,$hora_inicial,$idt_instrumento,$idt_atendimentow);
        $idt_atendimento = $idt_atendimentow;
        // $_GET['id']      = $idt_atendimento;
        // $acao            = "alt";
        // $_GET['acao']    = $acao;
    }
}

if ($_GET['pesquisa'] == 'S') {
    $par = getParametro('menu', false);
    $href = "conteudo.php?menu=".$_GET['menu_origem'].$par;

    if ($acao == 'con') {
        $trava_tudo = 'S';
        $botao_volta = "self.location = '{$href}'";
        $bt_voltar_lbl = 'Avançar';
    } else {
        $trava_tudo = 'N';
        $botao_volta = "btAcaoVoltarListar();";
    }
} else {
    $trava_tudo = 'N';

    if ($so_aba_um === true) {
        $_GET['so_aba_um'] = 'S';

        $bt_salvar_lbl = 'Novo';
        $bt_alterar_lbl = 'Salvar';
        $vetConfMsg['alt'] = 'Este cadastro deste atendimento será gravado.\n\nConfirma?';

        $href = $_SESSION[CS]['grc_atendimento_'.$_GET['session_volta']];
    } else {
        $_GET['so_aba_um'] = 'N';

        $href = "conteudo.php?prefixo=inc&menu=grc_atender_cliente&session_volta=".$_GET['session_volta']."&idt_atendimento_agenda=".$idt_atendimento_agenda."&idt_atendimento=".$idt_atendimento."&id=".$idt_atendimento_agenda."&aba=2";
    }

    $botao_volta = "btAcaoVoltar();";
}

$botao_acao = '<script type="text/javascript">self.location = "'.$href.'";</script>';

$_GET['idt_instrumento_aten_cad'] = $idt_instrumento;
?>
<script>
    var acao = '<?php echo $acao; ?>';
    var inc_cont = '<?php echo $inc_cont; ?>';
</script>
<?php
$class_frame_f = "class_frame_f";
$class_titulo_f = "class_titulo_f";
$class_frame_p = "class_frame_p";
$class_titulo_p = "class_titulo_p";
$class_frame = "class_frame";
$class_titulo = "class_titulo";
$titulo_na_linha = false;

$titulo_cadastro = "CADASTROS DO ATENDIMENTO";



//p($_GET);

$vetParametros = Array(
    'codigo_frm' => 'grc_representantes_w',
    'controle_fecha' => 'A',
    'barra_inc_ap' => true,
    'barra_alt_ap' => true,
    'barra_con_ap' => false,
    'barra_exc_ap' => true,
);

$vetFrm = Array();
$vetFrm[] = Frame('<span> CADASTRO DE PESSOA</span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);

$vetParametros = Array(
    'codigo_pai' => 'grc_representantes_w',
    'width' => '100%',
    'sem_registro' => $sem_registro,
    'trava_tudo' => $trava_tudo,
);
$vetCad[] = $vetFrm;

$idtVinculo = array(
    'idt_atendimento' => 'grc_atendimento',
    " and tipo_relacao = 'L'" => false,
);

MesclarCadastro('grc_atendimento_pessoa', $idtVinculo, $vetCad, $vetParametros);

$vetFrm = Array();
if ($_GET['representantes'] == 1) {
    $vetParametros = Array(
        'codigo_frm' => 'grc_atendimento_pessoa_w',
        'controle_fecha' => 'F',
        'barra_inc_ap' => true,
        'barra_alt_ap' => true,
        'barra_con_ap' => false,
        'barra_exc_ap' => true,
    );
} else {
    $vetParametros = Array(
        'codigo_frm' => 'grc_atendimento_pessoa_w',
        'controle_fecha' => 'A',
        'barra_inc_ap' => true,
        'barra_alt_ap' => true,
        'barra_con_ap' => false,
        'barra_exc_ap' => true,
    );
}
//$vetFrm[] = Frame('<span> CLIENTES - REPRESENTANTE E PARTICIPANTES</span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);
// Definição de campos formato full que serão editados na tela full

$vetCampo = Array();
//Monta o vetor de Campo

$vetRelacao = Array();
$vetRelacao['L'] = 'Representante';
$vetRelacao['P'] = 'Participante';
$vetCampo['tipo_relacao'] = CriaVetTabela('Tipo Relação', 'descDominio', $vetRelacao);

$vetCampo['cpf'] = CriaVetTabela('CPF');
$vetCampo['nome'] = CriaVetTabela('Nome');


// Parametros da tela full conforme padrão

$titulo = 'Pessoas';

$TabelaPrinc = "grc_atendimento_pessoa";
$AliasPric = "grc_ap";
$Entidade = "Pessoa do Atendimento";
$Entidade_p = "Pessoas do Atendimento";

// Select para obter campos da tabela que serão utilizados no full

$orderby = "{$AliasPric}.tipo_relacao, {$AliasPric}.cpf ";

$sql = "select {$AliasPric}.*  ";
$sql .= " from {$TabelaPrinc} {$AliasPric}  ";
//
$sql .= " where {$AliasPric}".'.idt_atendimento = $vlID';
$sql .= " order by {$orderby}";

// Carrega campos que serão editados na tela full



$vetCampo['grc_atendimento_pessoa'] = objListarConf('grc_atendimento_pessoa', 'idt', $vetCampo, $sql, $titulo, false, array_merge($vetPadraoLC, $vetParametros));

// Fotmata lay_out de saida da tela full

$vetParametros = Array(
    'codigo_pai' => 'grc_atendimento_pessoa_w',
    'width' => '100%',
);


/*
  $vetFrm[] = Frame('', Array(
  Array($vetCampo['grc_atendimento_pessoa']),
  ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);
 */

$vetParametros = Array(
    'codigo_frm' => 'grc_atendimento_organizacao_w',
    'controle_fecha' => 'A',
);
//
$vetFrm[] = Frame('<span>EMPREENDIMENTO(S) VINCULADO(S)</span>', '', $class_frame_p.' frm_grc_atendimento_organizacao_w', $class_titulo_p, $titulo_na_linha_p, $vetParametros);
//
$vetCampoLC = Array();
$vetCampoLC['cnpj'] = CriaVetTabela('cnpj do empreendimento');
$vetCampoLC['razao_social'] = CriaVetTabela('Razão Social');
$vetCampoLC['nome_fantasia'] = CriaVetTabela('Nome Fantasia');
$vetCampoLC['porte'] = CriaVetTabela('Porte/Faixa de Faturamento');
$vetCampoLC['desccargcli'] = CriaVetTabela('Cargo do Representante');
$vetCampoLC['funil'] = CriaVetTabela('Funil de Atendimento');

//
$titulo = 'Organização';
$TabelaPrinc = "grc_atendimento_organizacao";
$AliasPric = "grc_ao";
$Entidade = "Organização do Atendimento";
$Entidade_p = "Organizações do Atendimento";
//
$orderby = "{$AliasPric}.cnpj ";
//
$sql = "select {$AliasPric}.*,  ";
$sql .= " gec_eop.descricao   as gec_eop_descricao,  ";
$sql .= " gec_eop.desc_vl_cmb as gec_eop_desc_vl_cmb,  ";
$sql .= ' siac_c.desccargcli,';
$sql .= " concat_ws('/', gec_eop.descricao, gec_eop.desc_vl_cmb) as porte  ";


//
$sql .= " from  {$TabelaPrinc} {$AliasPric}  ";
//$sql .= " left  join ".db_pir_gec."gec_entidade_organizacao gec_eo        on gec_eo.idt_entidade = {$AliasPric}.idt_organizacao ";
$sql .= " left  join ".db_pir_gec."gec_organizacao_porte gec_eop          on gec_eop.idt         = {$AliasPric}.idt_porte ";
$sql .= " left  join ".db_pir_siac."cargcli siac_c                     on siac_c.codcargcli   = {$AliasPric}.representa_codcargcli ";


$sql .= " where {$AliasPric}".'.idt_atendimento = $vlID';
$sql .= " and {$AliasPric}.desvincular = 'N'";
$sql .= " order by {$orderby}";

if ($acao == 'con' || $acao == 'exc') {
    $vetParametros = Array(
        'barra_inc_ap' => false,
        'barra_alt_ap' => false,
        'barra_con_ap' => true,
        'barra_exc_ap' => false,
        'iframe' => true,
        //'extra_pagina' => false,
        'contlinfim' => "",
        'vetBtOrdem' => Array('per', 'exc', 'con', 'alt'),
        'func_botao_per' => grc_atendimento_organizacao_per_consulta,
		'func_trata_rs' => ftr_grc_atendimento_organizacao,
		
    );
} else {
    $vetParametros = Array(
        'barra_inc_ap' => true,
        'barra_alt_ap' => true,
        'barra_con_ap' => false,
        'barra_exc_ap' => false,
        'iframe' => true,
        //'extra_pagina' => false,
        'contlinfim' => "",
        'vetBtOrdem' => Array('per', 'exc', 'con', 'alt'),
        'func_botao_per' => grc_atendimento_organizacao_per,
		'func_trata_rs' => ftr_grc_atendimento_organizacao,
    );
}

$vetCampo['grc_atendimento_organizacao'] = objListarConf('grc_atendimento_organizacao', 'idt', $vetCampoLC, $sql, $titulo, false, array_merge($vetPadraoLC, $vetParametros));


$vetParametros = Array(
    'codigo_pai' => 'grc_atendimento_organizacao_w',
    'width' => '100%',
);

$vetFrm[] = Frame('', Array(
    Array($vetCampo['grc_atendimento_organizacao']),
        ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);

$vetCad[] = $vetFrm;
$vetFrm = Array();

/*
  if (!$sem_registro) {
  $vetParametros = Array(
  'codigo_frm' => 'empresa_vinculado',
  'controle_fecha' => 'F',
  );
  $vetFrm[] = Frame('<span> EMPREENDIMENTOS VINCULADOS AO SEU CADASTRO</span>', '', $class_frame_p.' frm_empresa_vinculado', $class_titulo_p, $titulo_na_linha_p, $vetParametros);

  $vetCampo['grc_atendimento_cadastro_inc'] = objInclude('grc_atendimento_cadastro_inc', 'grc_atendimento_cadastro_inc.php');
  }

  $vetParametros = Array(
  'codigo_pai' => 'empresa_vinculado',
  'width' => '100%',
  );
  $vetFrm[] = Frame('', Array(
  Array($vetCampo['grc_atendimento_cadastro_inc']),
  ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);


  $vetCad[] = $vetFrm;


  //if  ($_GET['cnpj']!="")
  //p($_GET);
  $vetParametros = Array(
  'codigo_frm' => 'grc_empreendimento_w',
  'controle_fecha' => 'A',
  'barra_inc_ap' => true,
  'barra_alt_ap' => true,
  'barra_con_ap' => false,
  'barra_exc_ap' => true,
  );
  $vetFrm = Array();
  $vetFrm[] = Frame('<span> CADASTRO DO EMPREENDIMENTO</span>', '', $class_frame_p.' frm_grc_empreendimento_w', $class_titulo_p, $titulo_na_linha_p, $vetParametros);
  $vetParametros = Array(
  'codigo_pai' => 'grc_empreendimento_w',
  'width' => '100%',
  'sem_registro' => $sem_registro,
  );
  $vetCad[] = $vetFrm;
  $vetCadOrg = MesclarCadastro('grc_atendimento_organizacao', 'idt_atendimento', $vetCad, $vetParametros);

  if (!$sem_registro) {
  $par = Array();

  ForEach ($vetCadOrg as $idxGrd => $vetGrd) {
  ForEach ($vetGrd as $idxFrm => $vetFrm) {
  if (is_array($vetFrm['dados'])) {
  ForEach ($vetFrm['dados'] as $nLinha => $Linha) {
  ForEach ($Linha as $Coluna) {
  if (is_array($Coluna)) {
  if ($Coluna['valida']) {
  $par[] = $Coluna['campo'];
  }
  }
  }
  }
  }
  }
  }

  $par = implode(',', $par);
  $vetDesativa['representa_empresa'][0] = vetDesativa($par);
  $vetAtivadoObr['representa_empresa'][0] = vetAtivadoObr($par);
  }
 * 
 */
?>
<script type="text/javascript">
    function parListarConf_grc_atendimento_organizacao() {
        var par = '';

        par += '&trava_tudo=<?php echo $trava_tudo; ?>';

        return par;
    }

    function parListarConfIframeOpen_grc_atendimento_organizacao() {
        $('#representa_empresa').prop("disabled", true).addClass("campo_disabled");
    }

    function funcaoFechaCTCAjaxDep_grc_atendimento_organizacao() {
        $('#representa_empresa').removeProp("disabled").removeClass("campo_disabled");
    }

    $(document).ready(function () {
        $('#representa_empresa').change(function () {
            var frm_empresa_vinculado = $('.frm_empresa_vinculado');
            var frm_grc_empreendimento_w = $('.frm_grc_empreendimento_w');
            var frm_grc_atendimento_organizacao_w = $('.frm_grc_atendimento_organizacao_w');

            if ($(this).val() == 'S') {
                if (acao == 'inc' || acao == 'alt') {
                    $.ajax({
                        dataType: 'json',
                        type: 'POST',
                        url: 'ajax_atendimento.php?tipo=grc_atendimento_cadastro_representa_empresa_s',
                        data: {
                            cas: conteudo_abrir_sistema,
                            idt_atendimento: '<?php echo $idt_atendimento; ?>'
                        },
                        success: function (response) {
                            if (response.erro == '') {
                                btFechaCTC($('#grc_atendimento_organizacao').data('session_cod'));
                            } else {
                                alert(url_decode(response.erro));
                            }
                        },
                        error: function (jqXHR, textStatus, errorThrown) {
                            alert('Erro no ajax no: ' + textStatus + ' - ' + errorThrown);
                        },
                        async: false
                    });
                }

                frm_empresa_vinculado.show();
                frm_grc_empreendimento_w.show();
                frm_grc_atendimento_organizacao_w.show();

                if ($('.grc_empreendimento_w').is(":hidden")) {
                    $('#grc_empreendimento_w').click();
                }

                if ($('.grc_atendimento_organizacao_w').is(":hidden")) {
                    $('#grc_atendimento_organizacao_w').click();
                }
            } else {
                if ($('.empresa_vinculado').is(":visible")) {
                    $('#empresa_vinculado').click();
                }

                frm_empresa_vinculado.hide();

                if ($('.grc_empreendimento_w').is(":visible")) {
                    $('#grc_empreendimento_w').click();
                }

                frm_grc_empreendimento_w.hide();

                if ($('.grc_atendimento_organizacao_w').is(":visible")) {
                    $('#grc_atendimento_organizacao_w').click();
                }

                frm_grc_atendimento_organizacao_w.hide();

                $.ajax({
                    dataType: 'json',
                    type: 'POST',
                    url: 'ajax_atendimento.php?tipo=grc_atendimento_cadastro_representa_empresa_n',
                    data: {
                        cas: conteudo_abrir_sistema,
                        idt_atendimento: '<?php echo $idt_atendimento; ?>'
                    },
                    success: function (response) {
                        if (response.erro == '') {
                            btFechaCTC($('#grc_atendimento_organizacao').data('session_cod'));
                        } else {
                            alert(url_decode(response.erro));
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        alert('Erro no ajax no: ' + textStatus + ' - ' + errorThrown);
                    },
                    async: true
                });
            }
        });

        setTimeout("$('#representa_empresa').change()", 100);

        if (acao == 'inc' || acao == 'alt') {
            $('#grc_atendimento_organizacao_desc').on('change', '.radio_representa', function () {
                grc_atendimento_organizacao_td_click($(this).val(), 'representa', $(this).parent());
            });
        }
    });

    function grc_atendimento_cadastro_dep() {
        var ok = true;

        if (grc_atendimento_pessoa_dep() === false) {
            return false;
        }

        if ($('#representa_empresa').val() == 'S') {
            $.ajax({
                dataType: 'json',
                type: 'POST',
                representa_empresa: $('#representa_empresa').val(),
                url: 'ajax_atendimento.php?tipo=grc_atendimento_cadastro_dep',
                data: {
                    cas: conteudo_abrir_sistema,
                    idt_atendimento: '<?php echo $idt_atendimento; ?>'
                },
                success: function (response) {
                    if (response.erro != '') {
                        ok = false;
                        alert(url_decode(response.erro));
                    }

                    if (response.idt_atendimento_organizacao != '') {
                        var obj_td = $('#grc_atendimento_organizacao_desc td[data-id="' + response.idt_atendimento_organizacao + '"]:first');
                        obj_td.parent().find('a[data-acao="alt"]').click();
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    ok = false;
                    alert('Erro no ajax no: ' + textStatus + ' - ' + errorThrown);
                },
                async: false
            });
        }

        return ok;
    }

    function btDesvincula(idt_valor, mensagem) {
        if (confirm(mensagem)) {
            grc_atendimento_organizacao_td_click(idt_valor, 'desvincular', null);
        }

        return false;
    }

    function grc_atendimento_organizacao_td_click(id, campo, obj_td) {
        $.ajax({
            dataType: 'json',
            type: 'POST',
            url: 'ajax_atendimento.php?tipo=grc_atendimento_organizacao_td_click',
            data: {
                cas: conteudo_abrir_sistema,
                campo: campo,
                idt: id
            },
            beforeSend: function () {
                processando();
            },
            complete: function () {
                $("#dialog-processando").remove();
            },
            success: function (response) {
                btFechaCTC($('#grc_atendimento_organizacao').data('session_cod'));

                if (response.erro == '') {
                    if (response.representa == 'S') {
                        obj_td.parent().find('a[data-acao="alt"]').click();
                    }
                } else {
                    $("#dialog-processando").remove();
                    alert(url_decode(response.erro));
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                ok = false;
                $("#dialog-processando").remove();
                alert('Erro no ajax no: ' + textStatus + ' - ' + errorThrown);
            },
            async: false
        });
    }

    function grc_atendimento_organizacao_fecha_ant() {
        $.ajax({
            dataType: 'json',
            type: 'POST',
            url: 'ajax_atendimento.php?tipo=grc_atendimento_organizacao_fecha_ant',
            data: {
                cas: conteudo_abrir_sistema,
                session_cod: $('#grc_atendimento_organizacao').data('session_cod')
            },
            beforeSend: function () {
                processando();
            },
            complete: function () {
                $("#dialog-processando").remove();
            },
            success: function (response) {
                if (response.erro == '') {
                } else {
                    $("#dialog-processando").remove();
                    alert(url_decode(response.erro));
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                $("#dialog-processando").remove();
                alert('Erro no ajax no: ' + textStatus + ' - ' + errorThrown);
            },
            async: false
        });
    }

    function btAcaoVoltar() {
        if (confirm('Atenção! O Atendimento não foi finalizado e as informações não foram salvas.\n\nConfirma?')) {
            self.location = '<?php echo $_SESSION[CS]['grc_atendimento_'.$session_volta]; ?>';
        }

    }

    function btAcaoVoltarListar() {
        if (confirm('Atenção! O Atendimento não foi finalizado e as informações não foram salvas.\n\nConfirma?')) {
            self.location = '<?php echo $_SESSION[CS]['grc_atendimento_listar']; ?>';
        }

    }
</script>