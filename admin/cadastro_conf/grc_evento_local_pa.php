<style>
    .proprio {
        background: #2F66B8;
        color     : #FFFFFF;
        text-align: center;
        font-size:18px;
        height:20px;
        padding:10px;

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
        background: #2F66B8;

        text-align: left;
        border    : 0px solid #2C3E50;
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
    div.class_titulo_c {
        xbackground: #C4C9CD;
        xborder    : 1px solid #2C3E50;
        xcolor     : #FFFFFF;
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
        guyheight:25px;
        text-align:left;
        border:0px;
        xbackground:#F1F1F1;
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


    .Texto {
        padding: 3px;
        padding-top: 5px;
        border:0;
    }

    #idt_foco_tematico_tf {
        background: #ffff80;
    }

    div.Barra {
        xdisplay: none;
    }

    #lbl_painel_desc {
        text-align: center;
        color: black;
        font-weight: bold;
        font-size: 16px;
        vertical-align: middle;
    }

    #lbl_painel_desc div {
        padding-bottom: 5px;
        border-bottom: 1px solid #2f66b8;
    } 

    #evento_aberto_obj {
        width: 185px;
    }

    #dt_previsao_inicial_obj,
    #dt_previsao_fim_obj,
    #quantidade_participante_desc {
        white-space: nowrap;
    }

    #descricao {
        width: 500px;
    }

    #divProtocolo {
        color: #FFFFFF;
        font-weight: bold;
        float: right;
        padding-right: 10px;
        position: relative;
        font-size:12px;
        top: -19px;
    }

    .frm_evento_situacao {
        display: none;
    }

    Td.Titulo_radio {
        width: 88px;
    }

    fieldset.frm_sem_margem {
        margin: 0px
    }

    fieldset.frm_sem_margem > table {
        padding: 0px
    }

    fieldset.frm_left > table {
        width: auto;
        float: left;
    }

    #idt_ponto_atendimento_tf {
        width: 730px;
    }
    #frm5 {

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

if ($_GET['showPopWin'] == 'S') {
    $botao_volta = 'parent.hidePopWin(false)';
    $botao_acao = '<script type="text/javascript">parent.hidePopWin(true);</script>';
}



$tabela = 'grc_evento_local_pa';
$id = 'idt';

$TabelaPai = "" . db_pir . "sca_organizacao_secao";
$AliasPai = "grc_os";
$EntidadePai = "Unidade Regional/PA´s";
$idPai = "idt";

$CampoPricPai = "idt_ponto_atendimento";

echo "<div class='proprio'>";

if ($_GET['idt0'] > 0) {
    echo "LOCAL PRÓPRIO";
} else {
    echo "LOCAL EXTERNO";
}
echo "</div>";

$sql = '';
$sql .= " select *";
$sql .= ' from grc_evento_local_pa';
$sql .= ' where idt = ' . null($_GET['id']);
$rs = execsql($sql);
$row = $rs->data[0];

$vetCampo[$CampoPricPai] = objFixoBanco($CampoPricPai, $EntidadePai, $TabelaPai, $idPai, 'descricao', 0);

$corbloq = "#FFFFD7";
$jst = " readonly='true' style='background:{$corbloq}; font-size:12px; xwidth:100%;' ";
$vetCampo['codigo'] = objTexto('codigo', 'Código GRC', true, 10, 45, $jst);
$vetCampo['codigo_siacweb'] = objTexto('codigo_siacweb', 'Código Siacweb', false, 10, 45, $jst);
$vetCampo['descricao'] = objTexto('descricao', 'Descrição', true, 49);
$vetCampo['qtd_pessoas_maximo'] = objTexto('qtd_pessoas_maximo', 'Qtd. Pessoas', true, 10);

$vetParametros = Array(
    'consulta_cep' => true,
    'campo_codest' => 'logradouro_codest',
    'campo_codcid' => 'logradouro_codcid',
    'campo_codbairro' => 'logradouro_codbairro',
    'campo_logradouro' => 'logradouro',
    'campo_codpais' => 'logradouro_codpais',
    'tipo_codest' => 'cmb_val',
    'tipo_codcid' => 'cmb_val',
    'tipo_codbairro' => 'cmb_val',
    'tipo_codpais' => 'cmb_val',
);
$vetCampo['cep'] = objCEP('cep', 'CEP', true, $vetParametros);

$vetCampo['logradouro'] = objTexto('logradouro', 'Logradouro', True, 30, 120);
$vetCampo['logradouro_numero'] = objTexto('logradouro_numero', 'Número', True, 30, 120);
$vetCampo['logradouro_complemento'] = objTexto('logradouro_complemento', 'Complemento', false, 30, 120);

$sql = '';
$sql .= " select distinct codpais as cod, pais_nome";
$sql .= ' from ' . db_pir_gec . 'base_cep';
$sql .= ' where codpais is not null';
$sql .= ' and cep_situacao = 1';
$sql .= ' order by pais_nome';
$vetCampo['logradouro_codpais'] = objCmbBanco('logradouro_codpais', 'País', True, $sql);

$sql = '';
$sql .= " select distinct codest as cod, uf_nome";
$sql .= ' from ' . db_pir_gec . 'base_cep';
$sql .= ' where codpais = ' . aspa($row['logradouro_codpais']);
$sql .= ' and cep_situacao = 1';
$sql .= ' order by uf_nome';
$vetCampo['logradouro_codest'] = objCmbBanco('logradouro_codest', 'Estado', True, $sql);

$sql = '';
$sql .= " select distinct codcid as cod, cidade";
$sql .= ' from ' . db_pir_gec . 'base_cep';
$sql .= ' where codest = ' . aspa($row['logradouro_codest']);
$sql .= ' and cep_situacao = 1';
$sql .= ' order by cidade';
$vetCampo['logradouro_codcid'] = objCmbBanco('logradouro_codcid', 'Cidade', true, $sql);

$sql = '';
$sql .= " select distinct codbairro as cod, bairro";
$sql .= ' from ' . db_pir_gec . 'base_cep';
$sql .= ' where codcid = ' . aspa($row['logradouro_codcid']);
$sql .= ' and cep_situacao = 1';
$sql .= ' order by bairro';
$vetCampo['logradouro_codbairro'] = objCmbBanco('logradouro_codbairro', 'Bairro', True, $sql);

$vetCampo['logradouro_referencia'] = objTexto('logradouro_referencia', 'Referência', false, 120);


$jst = " disabled style='background:{$corbloq}; font-size:12px; ' ";
if ($_GET['idt0'] > 0) {
    $vetCampo['proprio'] = objCmbVetor('proprio', 'Próprio', false, $vetSimNao, '', $jst);
} else {
    $vetCampo['proprio'] = objCmbVetor('proprio', 'Próprio', false, $vetNaoSim, '', $jst);
}
$maxlength = 2000;
$style = "width:730px;";
$js = "";
$vetCampo['detalhe'] = objTextArea('detalhe', 'Observação', false, $maxlength, $style);



if ($_GET['idt0'] > 0) {
    $vetFrm[] = Frame('<span></span>', Array(
        Array($vetCampo[$CampoPricPai]),
            ), $class_frame, $class_titulo, $titulo_na_linha);
}
//

$vetFrm[] = Frame('', Array(
    Array($vetCampo['codigo'], '', $vetCampo['codigo_siacweb'], '', $vetCampo['descricao']),
    Array($vetCampo['qtd_pessoas_maximo'], '', $vetCampo['proprio'], '', $vetCampo['cep']),
        ), $class_frame, $class_titulo, $titulo_na_linha);



MesclarCol($vetCampo['logradouro_codpais'], 5);
$vetFrm[] = Frame('', Array(
    //Array($vetCampo['idt_evento_local_tipo'],'',$vetCampo['cep'],'',$vetCampo['ativo']),
    Array($vetCampo['logradouro'], '', $vetCampo['logradouro_numero'], '', $vetCampo['logradouro_complemento']),
    Array($vetCampo['logradouro_codbairro'], '', $vetCampo['logradouro_codcid'], '', $vetCampo['logradouro_codest']),
    Array($vetCampo['logradouro_codpais']),
        ), $class_frame, $class_titulo, $titulo_na_linha);
$vetFrm[] = Frame('', Array(
    Array($vetCampo['logradouro_referencia']),
        ), $class_frame, $class_titulo, $titulo_na_linha);



$vetFrm[] = Frame('', Array(
    Array($vetCampo['detalhe']),
        ), $class_frame, $class_titulo, $titulo_na_linha);

/*
  $vetFrm[] = Frame('<span></span>', Array(
  Array($vetCampo['idt_projeto']),
  Array($vetCampo['idt_acao']),
  ),$class_frame,$class_titulo,$titulo_na_linha);
 */









//
// MAPA DA SALA
// ____________________________________________________________________________
//
    $vetParametros = Array(
    'codigo_frm' => 'mapasala',
    'controle_fecha' => 'A',
    'width' => '75%',
);

$vetFrm[] = Frame('<span>Mapa da Sala</span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);
// Definição de campos formato full que serão editados na tela full

$vetCampoLC = Array();
$vetCampoLC['codigo'] = CriaVetTabela('Código');
$vetCampoLC['descricao'] = CriaVetTabela('Descrição');
$vetCampoLC['detalhe'] = CriaVetTabela('Observação');
$vetCampoLC['ativo'] = CriaVetTabela('Ativo?', 'descDominio', $vetSimNao);

// Parametros da tela full conforme padrão

$titulo = 'Mapa da Sala';

$TabelaPrinc = "grc_evento_local_pa_mapa";
$AliasPric = "grc_elpm";
$Entidade = "Mapa da Sala";
$Entidade_p = "Mapas das Sala";
$CampoPricPai = "idt_local_pa";
//
// Select para obter campos da tabela que serão utilizados no full
//
    $orderby = "{$AliasPric}.codigo";
//


$sql = "select {$AliasPric}.* ";
$sql .= " from {$TabelaPrinc} {$AliasPric}  ";
//
$sql .= " where {$AliasPric}" . '.idt_local_pa = $vlID';
$sql .= " order by {$orderby}";
// 
// Carrega campos que serão editados na tela full
//
        $vetCampo['grc_evento_local_pa_mapa'] = objListarConf('grc_evento_local_pa_mapa', 'idt', $vetCampoLC, $sql, $titulo, false, $vetParametros);
// 
// Fotmata lay_out de saida da tela full
//   
$vetParametros = Array(
    'codigo_pai' => 'mapasala',
    'width' => '100%',
);

//
$vetFrm[] = Frame('', Array(
    Array($vetCampo['grc_evento_local_pa_mapa']),
        ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);
/////////////////////////////////////////////////// barra do final

if ($_GET['idt0'] > 0) {

    //
    // AGENDA DA SALA
    // ____________________________________________________________________________
    //
    $vetParametros = Array(
        'codigo_frm' => 'agendasala',
        'controle_fecha' => 'A',
        'width' => '75%',
    );

    $vetFrm[] = Frame('<span>Agenda da Sala</span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);
// Definição de campos formato full que serão editados na tela full

    $vetCampoLC = Array();
    $vetCampoLC['data_inicial'] = CriaVetTabela('Data Inicial', 'data');
    $vetCampoLC['hora_inicial'] = CriaVetTabela('Hora Inicial');
    $vetCampoLC['data_final'] = CriaVetTabela('Data Final', 'data');
    $vetCampoLC['hora_final'] = CriaVetTabela('Hora Final');
    $vetCampoLC['status'] = CriaVetTabela('Status');
    $vetCampoLC['detalhe'] = CriaVetTabela('Observação');
    $vetCampoLC['alocacao_disponivel'] = CriaVetTabela('Local/Sala disponível?', 'descDominio', $vetSimNao);

// Parametros da tela full conforme padrão

    $titulo = 'Agenda da Sala';

    $TabelaPrinc = "grc_evento_local_pa_agenda";
    $AliasPric = "grc_elpaa";
    $Entidade = "Agenda da Sala";
    $Entidade_p = "Agenda das Salas";
    $CampoPricPai = "idt_local_pa";
    //
    // Select para obter campos da tabela que serão utilizados no full
    //
    $orderby = "{$AliasPric}.data_inicial, hora_inicial";
    //


    $sql = "select {$AliasPric}.* ";
    $sql .= " from {$TabelaPrinc} {$AliasPric}  ";
    //
    $sql .= " where {$AliasPric}" . '.idt_local_pa = $vlID';
    $sql .= " order by {$orderby}";
    // 
    // Carrega campos que serão editados na tela full
    //
        $vetCampo['grc_evento_local_pa_agenda'] = objListarConf('grc_evento_local_pa_agenda', 'idt', $vetCampoLC, $sql, $titulo, false, $vetParametros);
    // 
    // Fotmata lay_out de saida da tela full
    //   
    $vetParametros = Array(
        'codigo_pai' => 'agendasala',
        'width' => '100%',
    );

    //
    $vetFrm[] = Frame('', Array(
        Array($vetCampo['grc_evento_local_pa_agenda']),
            ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);
    /////////////////////////////////////////////////// barra do final
}

$vetCad[] = $vetFrm;
?>
<script type="text/javascript">
    $(document).ready(function () {
        funcaoFechaCTC_grc_evento_local_pa_agenda();
        
        $("#logradouro_codest").cascade("#logradouro_codpais", {
            ajax: {
                url: ajax_plu + '&tipo=busca_cep_estado&cas=' + conteudo_abrir_sistema
            }
        });

        $("#logradouro_codcid").cascade("#logradouro_codest", {
            ajax: {
                url: ajax_plu + '&tipo=busca_cep_cidade_cod&cas=' + conteudo_abrir_sistema
            }
        });

        $("#logradouro_codbairro").cascade("#logradouro_codcid", {
            ajax: {
                url: ajax_plu + '&tipo=busca_cep_bairro&cas=' + conteudo_abrir_sistema
            }
        });
    });

    function funcaoFechaCTC_grc_evento_local_pa_agenda() {
        var title = 'Facilitador para criação da agenda';

        var bt = $('td#grc_evento_local_pa_agenda_desc td#Titulo_radio > a:first').clone();

        if (bt.length > 0) {
            var onclick = bt.attr('onclick').replace(new RegExp(', "inc", 0, ', "g"), ', "inc", -1, ');

            bt.attr('onclick', onclick);
            bt.attr('alt', title);
            bt.attr('title', title);
            bt.find('img').attr('src', 'imagens/bt_facil.png').attr('title', title);

            $('td#grc_evento_local_pa_agenda_desc td#Titulo_radio').append(bt);
        }
    }
</script>