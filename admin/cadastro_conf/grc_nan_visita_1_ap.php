<?php
if ($num_visita == '') {
    $num_visita = 1;
}

define('nan', 'S');
define('nan_ap', 'S');

if (count($_POST) > 0) {
    $tabela = '';
} else {
    $tabela = 'grc_atendimento';
}

$id = 'idt';
$acao_alt_con = 'S';
$acao_org = $acao;

$barra_bt_top = false;

$onSubmitCon = 'grc_nan_visita_1_ap()';

$class_frame_f = "class_frame_f";
$class_titulo_f = "class_titulo_f";
$class_frame_p = "class_frame_p";
$class_titulo_p = "class_titulo_p";
$class_frame = "class_frame";
$class_titulo = "class_titulo";
$titulo_na_linha = false;

if ($_GET['voltar'] == 'pendencia_home') {
    $botao_acao = '<script type="text/javascript">self.location = "conteudo'.$cont_arq.'.php";</script>';
    $botao_volta = "self.location = 'conteudo{$cont_arq}.php';";
} else if ($_GET['voltar'] == 'pendencia_listar') {
    $botao_acao = '<script type="text/javascript">self.location = "'.$_SESSION[CS]['pendencia_listar'].'";</script>';
    $botao_volta = "self.location = '".$_SESSION[CS]['pendencia_listar']."';";
}

$sql = '';
$sql .= ' select p.idt as idt_pessoa, a.nan_ap_sit_pf, a.nan_ap_sit_pj, a.nan_ap_sit_at';
$sql .= ' from grc_atendimento a';
$sql .= " inner join grc_atendimento_pessoa p on p.idt_atendimento = a.idt and p.tipo_relacao = 'L'";
$sql .= ' where a.idt = '.null($_GET['id']);
$rs = execsql($sql);
$rowa = $rs->data[0];

if ($rowa['nan_ap_sit_pf'] != 'S') {
    $frm_etapa = 'cadastro_pf';
} else if ($rowa['nan_ap_sit_pj'] != 'S') {
    $frm_etapa = 'cadastro_pj';
} else if ($rowa['nan_ap_sit_at'] != 'S') {
    $frm_etapa = 'cadastro_at';
} else {
    $frm_etapa = 'parecer';
}

define('frm_etapa', $frm_etapa);

$vetFrm = Array();

$vetCampo['idt_instrumento'] = objFixoBanco('idt_instrumento', '', 'grc_atendimento_instrumento', 'idt', 'descricao');

$vetParametros = Array(
    'width' => '100%',
);
$vetFrm[] = Frame('', Array(
    Array($vetCampo['idt_instrumento']),
        ), $class_frame, $class_titulo, false, $vetParametros);

$vetParametros = Array(
    'codigo_frm' => 'cadastro_pf',
    'controle_fecha' => 'F',
);

if ($frm_etapa == $vetParametros['codigo_frm']) {
    $vetParametros['controle_fecha'] = 'A';
}

$vetFrm[] = Frame('<span>CADASTRO DE PESSOA</span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);

$vetCad[] = $vetFrm;
$vetFrm = Array();

$vetParametrosMC = Array(
    'codigo_pai' => 'cadastro_pf',
    'width' => '100%',
    'trava_tudo' => 'S',
    'nan_ap' => 'S',
);

$idtVinculo = array(
    'idt_atendimento' => 'grc_atendimento',
    " and tipo_relacao = 'L'" => false,
);

MesclarCadastro('grc_atendimento_pessoa', $idtVinculo, $vetCad, $vetParametrosMC, '', true);

$sql = '';
$sql .= ' select representa_empresa';
$sql .= ' from grc_atendimento_pessoa';
$sql .= ' where idt = '.null($rowa['idt_pessoa']);
$rs = execsql($sql);

if ($rs->data[0][0] == 'S') {
    $vetParametros = Array(
        'codigo_frm' => 'cadastro_pj',
        'controle_fecha' => 'F',
    );

    if ($frm_etapa == $vetParametros['codigo_frm']) {
        $vetParametros['controle_fecha'] = 'A';
    }

    $vetFrm[] = Frame('<span>CADASTRO DE EMPREENDIMENTO</span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);

    $vetCad[] = $vetFrm;
    $vetFrm = Array();

    $vetParametrosMC = Array(
        'codigo_pai' => 'cadastro_pj',
        'width' => '100%',
        'trava_tudo' => 'S',
        'nan_ap' => 'S',
    );

    $idtVinculo = array(
        'idt_atendimento' => 'grc_atendimento',
        " and representa = 'S'" => false,
        " and desvincular = 'N'" => false,
    );

    MesclarCadastro('grc_atendimento_organizacao', $idtVinculo, $vetCad, $vetParametrosMC, '', true);
}

$vetParametros = Array(
    'codigo_frm' => 'cadastro_at',
    'controle_fecha' => 'F',
);

if ($frm_etapa == $vetParametros['codigo_frm']) {
    $vetParametros['controle_fecha'] = 'A';
}

$vetFrm[] = Frame('<span>ATENDIMENTO</span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);

$vetCad[] = $vetFrm;
$vetFrm = Array();

$vetParametrosMC = Array(
    'codigo_pai' => 'cadastro_at',
    'width' => '100%',
    'trava_tudo' => 'S',
    'nan_ap' => 'S',
);
MesclarCadastro('grc_nan_visita_'.$num_visita, 'idt', $vetCad, $vetParametrosMC, 'grc_atendimento', true);

$vetParametros = Array(
    'codigo_frm' => 'parecer',
    'controle_fecha' => 'F',
);

if ($frm_etapa == $vetParametros['codigo_frm']) {
    $vetParametros['controle_fecha'] = 'A';
}

$vetFrm[] = Frame('<span>PARECER</span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);

$sql = '';
$sql .= ' select solucao';
$sql .= ' from grc_atendimento_pendencia';
$sql .= ' where idt = '.null($_GET['idt_pendencia']);
$sql .= " and ativo  =  'S'";
$sql .= " and tipo   =  'NAN - Visita {$num_visita}'";
$sql .= " and status =  'Aprovação'";
$rs = execsql($sql);

$vetCampo['solucao'] = objTextArea('solucao', 'Comentários', true, 5000, '', '', false, $rs->data[0][0]);
$vetCampo['grc_nan_visita_1_ap_bt3'] = objInclude('grc_nan_visita_1_ap_bt3', 'cadastro_conf/grc_nan_visita_1_ap_bt3.php');

$vetParametros = Array(
    'codigo_pai' => 'parecer',
    'width' => '100%',
);
$vetFrm[] = Frame('', Array(
    Array($vetCampo['solucao']),
    Array($vetCampo['grc_nan_visita_1_ap_bt3']),
        ), $class_frame, $class_titulo, false, $vetParametros);

$vetCampo['grc_nan_visita_1_ap_bt'] = objInclude('grc_nan_visita_1_ap_bt', 'cadastro_conf/grc_nan_visita_1_ap_bt.php');

$vetParametros = Array(
    'width' => '100%',
);
$vetFrm[] = Frame('', Array(
    Array($vetCampo['grc_nan_visita_1_ap_bt']),
        ), $class_frame, $class_titulo, false, $vetParametros);

$vetCad[] = $vetFrm;
?>
<style type="text/css">
    Td.Titulo_radio {
        width: 26px;
    }

    td#idt_instrumento_obj {
        display: inline-block;
        height: 43px;
        width: 100%;
    }

    div.class_titulo_p {
        height: 21px;
    }

    .frame > legend > img, .frame > div > img.img_disabled {
        cursor: no-drop;
    }
</style>
<script type="text/javascript">
    var situacao_submit = '';

    $(document).ready(function () {
        setTimeout(function () {
            ajusta_frm_etapa('<?php echo $frm_etapa; ?>');
        }, 100);
    });

    function ajusta_frm_etapa(frm_etapa) {
        $('img.bt_controle_fecha').each(function () {
            var img = $(this);
            var filho = 'fieldset.' + this.id;

            if (img.attr('src') == 'imagens/seta_baixo.png') {
                img.attr('src', 'imagens/seta_cima.png');
                $(filho).toggle();
            }
        });

        $('img.bt_controle_fecha').prop("disabled", true).addClass('img_disabled');

        switch (frm_etapa) {
            case 'cadastro_pf':
                $('#cadastro_pf').removeProp("disabled").removeClass('img_disabled');

                $('#cadastro_pf').click();
                break;

            case 'cadastro_pj':
                $('#cadastro_pf').removeProp("disabled").removeClass('img_disabled');
                $('#cadastro_pj').removeProp("disabled").removeClass('img_disabled');

                $('#cadastro_pj').click();
                break;

            case 'cadastro_at':
                $('#cadastro_pf').removeProp("disabled").removeClass('img_disabled');
                $('#cadastro_pj').removeProp("disabled").removeClass('img_disabled');
                $('#cadastro_at').removeProp("disabled").removeClass('img_disabled');

                $('#cadastro_at').click();
                break;

            default:
                $('#cadastro_pf').removeProp("disabled").removeClass('img_disabled');
                $('#cadastro_pj').removeProp("disabled").removeClass('img_disabled');
                $('#cadastro_at').removeProp("disabled").removeClass('img_disabled');
                $('#parecer').removeProp("disabled").removeClass('img_disabled');

                $('#parecer').click();
                break;
        }

        TelaHeight();
    }

    function grc_nan_visita_1_ap() {
        if (situacao_submit != '') {
            $('#situacao').val(situacao_submit);
        }

        return true;
    }
</script>