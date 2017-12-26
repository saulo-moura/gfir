<style>
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

    #alocacao_disponivel_obj > div {
        width: 40px;
    }

    #alocacao_msg_obj > div {
        width: auto;
    }

    #bt_novo_desc {
        vertical-align: bottom;
    }

    #idt_local {
        width: 480px;
    }
</style>
<?php
if ($_GET['mat'] == 's') {
    $_GET['idt0'] = $_GET['idt_evento'];
    $_GET['idt_atendimento'] = $_GET['idCad'];

    $botao_volta = "parent.btFechaCTC('" . $_GET['session_cod'] . "');";
    $botao_acao = '<script type="text/javascript">parent.btFechaCTC("' . $_GET['session_cod'] . '", parent.funcaoFechaCTC_grc_evento_agenda_mat, null, returnVal);</script>';
} else if ($_GET['idCad'] != '') {
    $_GET['idt0'] = $_GET['idCad'];
    $botao_volta = "parent.btFechaCTC('" . $_GET['session_cod'] . "');";
    $botao_acao = '<script type="text/javascript">parent.btFechaCTC("' . $_GET['session_cod'] . '", parent.funcaoFechaCTC_grc_evento_agenda, null, returnVal);</script>';
}

$veio = $_GET['veio'];

$sql = '';
$sql .= ' select ea.idt_cidade, ts.codigo as codtema';
$sql .= ' from grc_evento_agenda ea';
$sql .= ' left outer join grc_tema_subtema ts on ts.idt = ea.idt_tema';
$sql .= ' where ea.idt = ' . null($_GET['id']);
$rs = execsql($sql);
$row = $rs->data[0];

$onSubmitDep = 'grc_evento_agenda_dep()';

$TabelaPai = "grc_evento";
$AliasPai = "grc_ppr";
$EntidadePai = "PROGRAMAÇÃO DE EVENTO";
$idPai = "idt";

$TabelaPrinc = "grc_evento_agenda";
$AliasPric = "grc_ppp";
$Entidade = "Agenda de Programação de Evento";
$Entidade_p = "Agenda de Programação de Evento";
$CampoPricPai = "idt_evento";

$id = 'idt';
$tabela = $TabelaPrinc;

$idt_instrumento = $_GET['idt_instrumento'];

$vetTipoAgenda = Array(
    'Consultoria' => 'Consultoria',
    'Instrutoria' => 'Instrutoria',
    'Ambos' => 'Consultoria/Instrutoria',
    'Outra' => 'Outras',
);

if ($_GET['id'] == 0) {
    $tabela = '';
    $vetCampo['carga_horaria'] = objHidden('carga_horaria', '');
} else {
    $vetCampo['competencia'] = objHidden('competencia', '');
    $js = " readonly='true' style='background:#FFFF80;' ";
    $vetCampo['carga_horaria'] = objDecimal('carga_horaria', 'Carga Horária', false, 15, 15, 0, $js);
}

$vetCampo[$CampoPricPai] = objHidden($CampoPricPai, $_GET['idt0']);

if ($_GET['idt_atendimento'] != '') {
    $vetCampo['idt_atendimento'] = objHidden('idt_atendimento', $_GET['idt_atendimento']);
}

$vetCampo['tipo_agenda'] = objCmbVetor('tipo_agenda', 'Tipo Agenda', True, $vetTipoAgenda);
$vetCampo['codigo'] = objTexto('codigo', 'Ordem', True, 15, 45);
$vetCampo['nome_agenda'] = objTexto('nome_agenda', 'Nome do Ítem da Agenda', True, 60, 120);

$vetCampo['ativo'] = objCmbVetor('ativo', 'Ativo?', True, $vetSimNao);

if ($_GET['id'] == 0) {
    $lbl = 'Inicio';
    $vetCampo['data_final'] = objData('data_final', 'Fim', true, '', '', 'S');
} else {
    $lbl = 'Data do Encontro';
    $vetCampo['data_final'] = objHidden('data_final', '');
}

$vetCampo['data_inicial'] = objData('data_inicial', $lbl, true, '', '', 'S');

$vetCampo['hora_inicial'] = objHora('hora_inicial', 'Hora Início', true);
$vetCampo['hora_final'] = objHora('hora_final', 'Hora Fim', true);

$vetCampo['dt_ini'] = objHidden('dt_ini', '');
$vetCampo['dt_fim'] = objHidden('dt_fim', '');


if ($_GET['id'] == 0 && $idt_instrumento == 2) {
    $obr = false;

    $sql = '';
    $sql .= ' select idt, substring(atividade, 1, 120) as txt';
    $sql .= ' from grc_evento_atividade';
    $sql .= ' where idt_atendimento = ' . null($_GET['idt_atendimento']);
    $sql .= ' order by txt';
    $vetCampo['idt_evento_atividade'] = objCmbBanco('idt_evento_atividade', 'Selecione uma Atividade já cadastrada', false, $sql);

    $par = 'idt_evento_atividade';
    $vetDesativa['idt_evento_atividade'][0] = vetDesativa($par, 'x');
    $vetAtivadoObr['idt_evento_atividade'][0] = vetAtivadoObr($par, '', false);

    $par = 'atividade,idt_tema,idt_subtema';
    $vetDesativa['idt_evento_atividade'][1] = vetDesativa($par, '', false);
    $vetAtivadoObr['idt_evento_atividade'][1] = vetAtivadoObr($par, '');

    $lbl = 'Cadastrada uma Nova Atividade (Limitado a 1000 caracteres)';
} else {
    $obr = true;
    $vetCampo['idt_evento_atividade'] = objHidden('idt_evento_atividade', '');

    $lbl = 'Atividade (Limitado a 1000 caracteres)';
}

$maxlength = 1000;
$style = "width:98%;";
$js = " ";

$vetCampo['atividade'] = objTextArea('atividade', $lbl, $obr, $maxlength, $style, $js);
//
$vetCampo['valor_hora'] = objDecimal('valor_hora', 'Valor da Hora', true, 15, 15, 2, '', $_GET['valor_hora']);
//
$sql = "select grc_ts.idt,  grc_ts.descricao from grc_tema_subtema grc_ts ";
$sql .= " where grc_ts.nivel =  0 ";
$sql .= " and ativo = 'S'";
$sql .= " order by  grc_ts.descricao";
$vetCampo['idt_tema'] = objCmbBanco('idt_tema', 'Tema', true, $sql, ' ', 'width:200px;');

$sql = "select grc_ts.idt,  grc_ts.descricao from grc_tema_subtema grc_ts ";
$sql .= " where grc_ts.nivel  =  1 ";
$sql .= "   and substring(grc_ts.codigo,1,3) =  " . aspa($row['codtema'] . '.');
$sql .= " and ativo = 'S'";
$sql .= " order by  grc_ts.descricao";
$js_hm = " style='background:{$corbloq}; font-size:12px; width:200px;' ";
$vetCampo['idt_subtema'] = objCmbBanco('idt_subtema', 'Subtema', true, $sql, ' ', 'width:300px;');

if ($veio == 'SG' && $idt_instrumento != 2) {
    $lbl_obs = 'Atividade';
} else {
    $lbl_obs = 'Observação';
}

$maxlength = 2000;
$style = "width:700px;";
$js = "";
$vetCampo['observacao'] = objTextArea('observacao', $lbl_obs, false, $maxlength, $style, $js);

$js = " readonly='true' style='background:#FFFF80;' ";
$vetCampo['dia_extenso'] = objTexto('dia_extenso', 'Dia(Extenso)', False, 15, 15, $js);

$vetCampo['dia_abreviado'] = objTexto('dia_abreviado', 'Dia(Abreviado)', False, 15, 15, $js);
$vetCampo['quantidade_horas_mes'] = objDecimal('quantidade_horas_mes', 'Quantidade Horas (Mes)', false, 15);

// Cidade
$sql = "select codcid, desccid from " . db_pir_siac . "cidade where codest=5 ";
$sql .= " order by desccid";
$vetCampo['idt_cidade'] = objCmbBanco('idt_cidade', 'Cidade', true, $sql, ' ', 'width:250px;', '', true, $_GET['idt_cidade']);

if ($row['idt_cidade'] == '') {
    $row['idt_cidade'] = $_GET['idt_cidade'];
}

// Local
$sql = '';
$sql .= " select case proprio when 'S' then 'Interno' else 'Externo' end as grupo,";
$sql .= ' idt,descricao';
$sql .= ' from grc_evento_local_pa';
$sql .= ' where logradouro_codcid = ' . null($row['idt_cidade']);
$sql .= ' order by grupo desc, descricao';
$vetCampo['idt_local'] = objCmbBanco('idt_local', 'Local/Sala', true, $sql, ' ', '', '', true, $_GET['idt_local'], true);

$vetCampo['bt_novo'] = objInclude('bt_novo', 'cadastro_conf/grc_evento_agenda_btnovo.php');

$vetFrm = Array();

//   
if ($idt_instrumento != 2) {
    MesclarCol($vetCampo[$CampoPricPai], 3);
    MesclarCol($vetCampo['idt_cidade'], 5);
    //
    $vetFrm[] = Frame('<span>Identificação</span>', Array(
        Array($vetCampo[$CampoPricPai], '', $vetCampo['idt_atendimento'], '', $vetCampo['dt_ini'], '', $vetCampo['dt_fim']),
        Array($vetCampo['data_inicial'], '', $vetCampo['data_final'], '', $vetCampo['hora_inicial'], '', $vetCampo['hora_final'], '', $vetCampo['carga_horaria']),
        Array($vetCampo['idt_cidade'], '', $vetCampo['idt_local'], '', $vetCampo['bt_novo']),
            ), $class_frame, $class_titulo, $titulo_na_linha);
    /*
      $vetFrm[] = Frame('<span>Carga Horaria</span>', Array(
      Array($vetCampo['carga_horaria'],'',$vetCampo['quantidade_horas_mes']),
      ),$class_frame,$class_titulo,$titulo_na_linha);
     */

    $vetFrm[] = Frame('<span>' . $lbl_obs . '</span>', Array(
        Array($vetCampo['observacao']),
            ), $class_frame, $class_titulo, $titulo_na_linha);

    if ($_GET['id'] > 0) {
        $vetCampo['alocacao_disponivel'] = objFixoVetor('alocacao_disponivel', 'Local/Sala disponível?', false, $vetSimNao);
        $vetCampo['alocacao_msg'] = objHtml('alocacao_msg', 'Mensagem', false, '100', '', '', false, false, true);

        $vetFrm[] = Frame('<span>Local/Sala</span>', Array(
            Array($vetCampo['alocacao_disponivel'], '', $vetCampo['alocacao_msg']),
                ), $class_frame, $class_titulo, $titulo_na_linha);
    }
} else {
    MesclarCol($vetCampo[$CampoPricPai], 3);
    MesclarCol($vetCampo['idt_evento_atividade'], 9);
    MesclarCol($vetCampo['atividade'], 9);

    $vetFrm[] = Frame('<span>Identificação</span>', Array(
        Array($vetCampo[$CampoPricPai], '', $vetCampo['idt_atendimento'], '', $vetCampo['dt_ini'], '', $vetCampo['dt_fim']),
        Array($vetCampo['idt_evento_atividade']),
        Array($vetCampo['atividade']),
        Array($vetCampo['data_inicial'], '', $vetCampo['data_final'], '', $vetCampo['hora_inicial'], '', $vetCampo['hora_final'], '', $vetCampo['carga_horaria']),
            ), $class_frame, $class_titulo, $titulo_na_linha);

    $vetCampo['data_inicial_real'] = objTextoFixo('data_inicial_real', 'Data do Encontro', '', true);
    $vetCampo['hora_inicial_real'] = objTextoFixo('hora_inicial_real', 'Hora Inicio', '', true);
    $vetCampo['hora_final_real'] = objTextoFixo('hora_final_real', 'Hora Final', '', true);
    $vetCampo['carga_horaria_real'] = objTextoFixo('carga_horaria_real', 'Carga Horária', '', true);
    $vetCampo['obs_real'] = objTextoFixo('obs_real', 'Comentário', '', true);

    $vetFrm[] = Frame('Dados da Realização da Atividade', Array(
        Array($vetCampo['data_inicial_real'], '', $vetCampo['hora_inicial_real'], '', $vetCampo['hora_final_real'], '', $vetCampo['carga_horaria_real'], '', $vetCampo['obs_real']),
            ), $class_frame, $class_titulo, $titulo_na_linha);

    if ($veio == 'SG') {
        $vetFrm[] = Frame('', Array(
            Array($vetCampo['idt_tema'], '', $vetCampo['idt_subtema'], '', $vetCampo['competencia']),
                ), $class_frame, $class_titulo, $titulo_na_linha);
    } else {
        $vetFrm[] = Frame('', Array(
            Array($vetCampo['valor_hora'], '', $vetCampo['idt_tema'], '', $vetCampo['idt_subtema'], '', $vetCampo['competencia']),
                ), $class_frame, $class_titulo, $titulo_na_linha);
    }

    $vetFrm[] = Frame('<span>Observações</span>', Array(
        Array($vetCampo['observacao']),
            ), $class_frame, $class_titulo, $titulo_na_linha);
}

$vetCad[] = $vetFrm;
?>
<script type="text/javascript">
    $(document).ready(function () {
        $("#idt_local").cascade("#idt_cidade", {
            ajax: {
                url: ajax_sistema + '?tipo=pa_cidade&cas=' + conteudo_abrir_sistema
            }
        });

        $("#idt_subtema").cascade("#idt_tema", {ajax: {
                url: 'ajax_atendimento.php?tipo=subtema_tratado&cas=' + conteudo_abrir_sistema
            }});
    });

    function grc_evento_agenda_dep() {
        if ('<?php echo $_GET['id']; ?>' > '0') {
            $('#data_final').val($('#data_inicial').val());
        }

        if (valida == 'S') {
            /*
             if (acao == 'inc' && '<?php echo $veio; ?>' != 'SG') {
             if (validaDataMaiorStr(false, $('#data_inicial'), 'Inicio', '<?php echo date('01/m/Y'); ?>', 'Inicio da Competência do Sistema') === false) {
             return false;
             }
             }
             */

            var dt_ini = newDataHoraStr(true, $('#data_inicial').val() + ' ' + $('#hora_inicial').val());
            var dt_fim = newDataHoraStr(true, $('#data_final').val() + ' ' + $('#hora_final').val());

            if (dt_fim - dt_ini < 0) {
                alert('A Data / Hora Fim não pode ser menor que a Data / Hora Inicio!');
                return false;
            }

            if ('<?php echo $_GET['idt_instrumento']; ?>' == '2') {
                var erro = '';

                processando();

                $.ajax({
                    dataType: 'json',
                    type: 'POST',
                    url: ajax_sistema + '?tipo=grc_evento_agenda_valida',
                    data: {
                        cas: conteudo_abrir_sistema,
                        idt: '<?php echo $_GET['id']; ?>',
                        idt_evento: '<?php echo $_GET['idt0']; ?>',
                        idt_atendimento: '<?php echo $_GET['idt_atendimento']; ?>',
                        cred_necessita_credenciado: parent.parent.$('#cred_necessita_credenciado').val(),
                        idt_evento_atividade: $('#idt_evento_atividade').val(),
                        data_inicial: $('#data_inicial').val(),
                        data_final: $('#data_final').val(),
                        hora_inicial: $('#hora_inicial').val(),
                        hora_final: $('#hora_final').val()
                    },
                    success: function (response) {
                        if (response.erro != '') {
                            erro += url_decode(response.erro);
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        $('#dialog-processando').remove();
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
        }

        return true;
    }
</script>
