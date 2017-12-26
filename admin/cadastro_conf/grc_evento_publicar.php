<style>
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
</style>
<?php
$menu_acesso = 'grc_evento_publicar_acao';
$_SESSION[CS]['g_nom_tela'] = $vetMenu[$menu_acesso];
$id = 'idt';

$class_frame = "class_frame";
$class_titulo = "class_titulo";
$titulo_na_linha = false;

if ($_GET['id'] == '' || $_GET['id'] == '0' || $_POST['id'] == '0') {
    $tabela = '';
    $bt_salvar_lbl = 'Publicar';
    $botao_acao = '<script type="text/javascript">parent.ListarCmbMultiLimpa("", "' . $_GET['session_cod'] . '");</script>';
    $botao_volta = "parent.hidePopWin(false);";

    $msg = '';
    $vetSel = $_SESSION[CS]['objListarCmbMulti'][$_GET['session_cod']]['sel_trab'];

    $vetDados = Array();

    foreach ($vetSel as $idx => $dados) {
        $vetDados[$dados['publica_internet']][$dados['pubilcar_situacao']][] = $dados;
    }

    if ($msg == '' && count($vetDados['N']) > 0 && count($vetDados['S']) > 0) {
        $msg = 'Não pode selecionar ao mesmo tempo eventos com a situação ' . $vetEventoPublicaInternet['S'] . ' e ' . $vetEventoPublicaInternet['N'] . '!';
    }

    if ($msg == '' && count($vetDados['N']['AA']) > 0) {
        $msg = 'Não pode selecionar eventos com a situação ' . $vetEventoPubilcarRegistro['AA'] . '!';
    }

    if ($msg == '') {
        $acao = 'inc';

        if ($msg == '' && count($vetDados['S']) > 0) {
            $vetConfMsg['inc'] = '';
            $vetCampo['despublicar'] = objHidden('despublicar', 'S');

            $vetFrm[] = Frame('', Array(
                Array($vetCampo['despublicar']),
                    ), $class_frame, $class_titulo, $titulo_na_linha);
            ?>
            <style type="text/css">
                div.Barra {
                    display: none;
                }
            </style>

            <script type="text/javascript">
                $(document).ready(function () {
                    $(":submit").click();
                });
            </script>
            <?php
        } else {
            $onSubmitDep = 'grc_evento_publicar_inc_dep()';

            $vetCampo['data_publicacao_de'] = objDataHora('data_publicacao_de', 'Publicar De', true, '', '', 'S');
            $vetCampo['data_publicacao_ate'] = objDataHora('data_publicacao_ate', 'Publicar  Até', true, '', '', 'S');
            $vetCampo['data_hora_fim_inscricao_ec'] = objDataHora('data_hora_fim_inscricao_ec', 'Data Fim inscrição loja Virtual', true, '', '', 'S');

            $vetFrm[] = Frame('', Array(
                Array($vetCampo['data_publicacao_de'], '', $vetCampo['data_publicacao_ate'], '', $vetCampo['data_hora_fim_inscricao_ec']),
                    ), $class_frame, $class_titulo, $titulo_na_linha);
        }
    } else {
        $acao = 'con';
        alert($msg, 'E');
    }

    $_GET['id'] = 0;
    $_GET['acao'] = $acao;
} else {
    $tabela = 'grc_evento_publicar';
    $onSubmitDep = 'grc_evento_publicar_alt_dep()';
    $botao_acao = '<script type="text/javascript">self.location = "conteudo.php";</script>';
    $botao_volta = "self.location = 'conteudo.php';";

    $sql = '';
    $sql .= ' select *';
    $sql .= ' from grc_evento_publicar';
    $sql .= ' where idt = ' . null($_GET['id']);
    $rs = execsql($sql);
    $rowDados = $rs->data[0];

    if ($_GET['idt_pendencia'] != '') {
        $sql = '';
        $sql .= ' select idt';
        $sql .= ' from grc_atendimento_pendencia';
        $sql .= ' where idt = ' . null($_GET['idt_pendencia']);
        $sql .= ' and idt_evento_publicar  = ' . null($_GET['id']);
        $sql .= ' and idt_responsavel_solucao = ' . null($_SESSION[CS]['g_id_usuario']);
        $sql .= " and ativo = 'S'";
        $sql .= " and tipo = 'Publicação de Eventos'";
        $sql .= whereAtendimentoPendencia();
        $rs = execsql($sql);

        if ($rs->rows == 0) {
            unset($_GET['idt_pendencia']);
        }
    }

    if ($_GET['idt_pendencia'] == '') {
        $sql = '';
        $sql .= ' select idt';
        $sql .= ' from grc_atendimento_pendencia';
        $sql .= ' where idt_evento_publicar  = ' . null($_GET['id']);
        $sql .= ' and idt_responsavel_solucao = ' . null($_SESSION[CS]['g_id_usuario']);
        $sql .= " and ativo = 'S'";
        $sql .= " and tipo = 'Publicação de Eventos'";
        $sql .= whereAtendimentoPendencia();
        $rs = execsql($sql);
        $_GET['idt_pendencia'] = $rs->data[0][0];
    }

    if ($_GET['idt_pendencia'] == '' || $rowDados['situacao'] != 'AA') {
        $_GET['acao'] = 'con';
        $acao = 'con';
    }

    $vetCampo['codigo'] = objTextoFixo('codigo', 'Código', 10, true);
    $vetCampo['idt_unidade'] = objFixoBanco('idt_unidade', 'Unidade/Escritório', db_pir . 'sca_organizacao_secao', 'idt', 'descricao');
    $vetCampo['situacao'] = objFixoVetor('situacao', 'Situação', false, $vetEventoPubilcar);
    $vetCampo['dt_registro'] = objTextoFixo('dt_registro', 'Data do Registro', 16, true);
    $vetCampo['idt_responsalvel'] = objFixoBanco('idt_responsalvel', 'Responsável', 'plu_usuario', 'id_usuario', 'nome_completo');
    $vetCampo['dt_aprovacao'] = objTextoFixo('dt_aprovacao', 'Data da Aprovação', 16, true);
    $vetCampo['idt_usuario_aprovacao'] = objFixoBanco('idt_usuario_aprovacao', 'Responsável pela Aprovação', 'plu_usuario', 'id_usuario', 'nome_completo');

    $vetCampo['data_publicacao_de'] = objTextoFixo('data_publicacao_de', 'Publicar De', '', true);
    $vetCampo['data_publicacao_ate'] = objTextoFixo('data_publicacao_ate', 'Publicar  Até', '', true);
    $vetCampo['data_hora_fim_inscricao_ec'] = objTextoFixo('data_hora_fim_inscricao_ec', 'Data Fim inscrição loja Virtual', '', true);

    $vetFrm = Array();

    MesclarCol($vetCampo['idt_responsalvel'], 3);
    MesclarCol($vetCampo['idt_usuario_aprovacao'], 3);

    $vetFrm[] = Frame('', Array(
        Array($vetCampo['codigo'], '', $vetCampo['idt_unidade'], '', $vetCampo['situacao']),
        Array($vetCampo['dt_registro'], '', $vetCampo['idt_responsalvel']),
        Array($vetCampo['dt_aprovacao'], '', $vetCampo['idt_usuario_aprovacao']),
        Array($vetCampo['data_publicacao_de'], '', $vetCampo['data_publicacao_ate'], '', $vetCampo['data_hora_fim_inscricao_ec']),
            ), $class_frame, $class_titulo, $titulo_na_linha);

    $vetCampoLC = Array();
    $vetCampoLC['instrumento'] = CriaVetTabela('Instrumento');
    $vetCampoLC['evento'] = CriaVetTabela('Evento');

    if ($_GET['idt_pendencia'] == '' || $acao == 'con') {
        $vetCampoLC['situacao'] = CriaVetTabela('Situação', 'descDominio', $vetEventoPubilcarRegistro);
    } else {
        $vetCampoLC['situacao'] = CriaVetTabela('Situação', 'func_trata_dado', ftd_grc_evento_publicar_evento);
    }

    $titulo = 'Evento Associados';

    $vetParametrosLC = Array(
        'menu_acesso' => 'grc_evento',
        'barra_inc_ap' => false,
        'barra_alt_ap' => false,
        'barra_con_ap' => true,
        'barra_exc_ap' => false,
    );

    $sql = '';
    $sql .= " select eg.*, concat_ws('<br />', e.codigo, e.descricao) as evento, i.descricao as instrumento";
    $sql .= ' from grc_evento_publicar_evento eg';
    $sql .= ' inner join grc_evento e on e.idt = eg.idt_evento';
    $sql .= ' inner join grc_atendimento_instrumento i on i.idt = e.idt_instrumento';
    $sql .= ' where eg.idt_evento_publicar = $vlID';
    $sql .= ' order by i.ordem_composto, e.codigo';

    $vetCampo['grc_evento_publicar_evento'] = objListarConf('grc_evento_publicar_evento', 'idt_evento', $vetCampoLC, $sql, $titulo, true, $vetParametrosLC, 'grc_evento');

    $vetParametros = Array(
        'width' => '100%',
    );

    $vetFrm[] = Frame('<span>' . $titulo . '</span>', Array(
        Array($vetCampo['grc_evento_publicar_evento']),
            ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);
}

$vetCampo['grc_evento_publicar_bt'] = objInclude('grc_evento_publicar_bt', 'cadastro_conf/grc_evento_publicar_bt.php');

$vetFrm[] = Frame('', Array(
    Array($vetCampo['grc_evento_publicar_bt']),
        ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);

$vetCad[] = $vetFrm;
?>
<script type="text/javascript">
    function grc_evento_publicar_inc_dep() {
        if (validaDataMaiorStr(true, $('#data_publicacao_de'), 'Publicar De', '<?php echo date("d/m/Y H:i"); ?>', 'Hoje', false) === false) {
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

        if ($('#data_hora_fim_inscricao_ec').val() != '') {
            if (validaDataMaior(true, $('#data_hora_fim_inscricao_ec'), 'Data Fim inscrição loja Virtual', $('#data_publicacao_de'), 'Publicar De') === false) {
                return false;
            }

            if (validaDataMenor(true, $('#data_hora_fim_inscricao_ec'), 'Data Fim inscrição loja Virtual', $('#data_publicacao_ate'), 'Publicar Até') === false) {
                return false;
            }
        }

        return true;
    }

    function grc_evento_publicar_alt_dep() {
        var OK = true;

        $('#grc_evento_publicar_evento_desc select').each(function () {
            if ($(this).val() == '' && OK) {
                alert('Favor informar o valor deste campo!');
                $(this).focus();
                OK = false;
            }
        });

        return OK;
    }
</script>