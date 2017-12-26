<?php
if ($_GET['idCad'] != '') {
    $botao_volta = "parent.btFechaCTC('".$_GET['session_cod']."');";
    $botao_acao = '<script>parent.btFechaCTC("'.$_GET['session_cod'].'");</script>';
}

$_SESSION[CS]['g_nom_tela'] = 'Atividades do Evento (Prestação de Contas)';
$onSubmitDep = 'grc_evento_agenda_dep()';
$tabela = db_pir_grc.'grc_evento_atividade';
$id = 'idt';

$sql = '';
$sql .= ' select a.protocolo, p.nome, p.cpf, o.razao_social, o.cnpj, ea.atividade';
$sql .= ' from '.db_pir_grc.'grc_evento_atividade ea';
$sql .= " inner join ".db_pir_grc."grc_atendimento a on a.idt = ea.idt_atendimento";
$sql .= " inner join ".db_pir_grc."grc_atendimento_pessoa p on p.tipo_relacao = 'L' and p.idt_atendimento = ea.idt_atendimento";
$sql .= " left join ".db_pir_grc."grc_atendimento_organizacao o on o.idt_atendimento = ea.idt_atendimento";
$sql .= ' where ea.idt = '.null($_GET['id']);
$rs = execsql($sql);
$row = $rs->data[0];

$vetCampo['protocolo'] = objTextoFixo('protocolo', 'Protocolo', '', false, false, $row['protocolo']);
$vetCampo['cpf'] = objTextoFixo('cpf', 'CPF do Cliente', '', false, false, $row['cpf']);
$vetCampo['nome'] = objTextoFixo('nome', 'Nome do Cliente', '', false, false, $row['nome']);
$vetCampo['cnpj'] = objTextoFixo('cnpj', 'CNPJ do Empreendimento', '', false, false, $row['cnpj']);
$vetCampo['razao_social'] = objTextoFixo('razao_social', 'Nome do Empreendimento', '', false, false, $row['razao_social']);
$vetCampo['atividade'] = objTextoFixo('atividade', 'Atividade', '', false, false, $row['atividade']);
$vetCampo['consolidado_cred'] = objCmbVetor('consolidado_cred', 'Aprovado?', True, $vetSimNao);

$vetCampoLC = Array();
$vetCampoLC['data_inicial'] = CriaVetTabela('Data', 'data');
$vetCampoLC['hora_inicial'] = CriaVetTabela('Hora Inicio');
$vetCampoLC['hora_final'] = CriaVetTabela('Hora Final');
$vetCampoLC['carga_horaria'] = CriaVetTabela('Carga Horária', 'decimal');
$vetCampoLC['data_inicial_real'] = CriaVetTabela('Data', 'func_trata_dado', ftd_alt_atividade);
$vetCampoLC['hora_inicial_real'] = CriaVetTabela('Hora Inicio', 'func_trata_dado', ftd_alt_atividade);
$vetCampoLC['hora_final_real'] = CriaVetTabela('Hora Final', 'func_trata_dado', ftd_alt_atividade);
$vetCampoLC['carga_horaria_real'] = CriaVetTabela('Carga Horária', 'func_trata_dado', ftd_alt_atividade);
$vetCampoLC['obs_real'] = CriaVetTabela('Comentário', 'func_trata_dado', ftd_alt_atividade);

$titulo = 'Atividade do Evento';

$sql = '';
$sql .= ' select idt, data_inicial, hora_inicial, hora_final, carga_horaria, data_inicial_real, hora_inicial_real, hora_final_real, carga_horaria_real, obs_real';
$sql .= ' from '.db_pir_grc.'grc_evento_agenda';
$sql .= ' where idt_evento_atividade = '.null($_GET['id']);
$sql .= ' order by data_inicial, hora_inicial, hora_final';

$vetPadrao = Array(
    'barra_inc_ap' => false,
    'barra_alt_ap' => false,
    'barra_con_ap' => false,
    'barra_exc_ap' => false,
);

$vetCampo['grc_evento_agenda'] = objListarConf('grc_evento_agenda', 'idt', $vetCampoLC, $sql, $titulo, false, $vetPadrao);

$vetFrm = Array();

$vetParametros = Array(
    'width' => '100%',
);

MesclarCol($vetCampo['protocolo'], 3);
MesclarCol($vetCampo['atividade'], 3);
MesclarCol($vetCampo['grc_evento_agenda'], 3);
MesclarCol($vetCampo['consolidado_cred'], 3);

$vetFrm[] = Frame('', Array(
    Array($vetCampo['protocolo']),
    Array($vetCampo['cpf'], '', $vetCampo['nome']),
    Array($vetCampo['cnpj'], '', $vetCampo['razao_social']),
    Array($vetCampo['atividade']),
    Array($vetCampo['grc_evento_agenda']),
    Array($vetCampo['consolidado_cred']),
        ), '', '', true, $vetParametros);
$vetCad[] = $vetFrm;

$sql = '';
$sql .= ' select distinct month(data_inicial) as mes, year(data_inicial) as ano';
$sql .= ' from '.db_pir_grc.'grc_evento_agenda';
$sql .= ' where idt_evento_atividade = '.null($_GET['id']);
$rst = execsql($sql);
$rowt = $rst->data[0];

if ($rowt['mes'] < 10) {
    $rowt['mes'] = '0'.$rowt['mes'];
}
?>
<style type="text/css">
    #grc_evento_agenda_desc {
        padding-top: 10px;
    }
</style>
<script type="text/javascript">
    var mes = '<?php echo $rowt['mes']; ?>';
    var ano = '<?php echo $rowt['ano']; ?>';

    $(document).ready(function () {
        var html = '<tr class="Generica"><td class="Titulo_radio"></td><td class="acao_fecha"></td>';
        html += '<td colspan="4" class="Titulo"><b>Previsão</b></td>';
        html += '<td colspan="5" class="Titulo"><b>Realizado</b></td>';
        html += '</tr>';

        $('#grc_evento_agenda_desc table').prepend(html);
        ajusta_altura_PopWin('');

        setTimeout(function () {
            $('#grc_evento_agenda_desc td.acao_fecha:last').click();
            ajusta_altura_PopWin('');
        }, 500);
    });

    function grc_evento_agenda_dep() {
        if (valida == 'S') {
            var OK = true;
            var tot = 0;
            var tot_real = 0;

            if (OK) {
                $('#grc_evento_agenda_desc input.Obr').each(function () {
                    if ($(this).val() == '' && OK) {
                        alert('Favor informar o valor deste campo!');
                        $(this).focus();
                        OK = false;
                    }
                });
            }

            if (OK) {
                $('#grc_evento_agenda_desc tr.Registro, #grc_evento_agenda_desc tr.Registro1').each(function () {
                    if (OK) {
                        var dt = $(this).find('input.DT');
                        var hi = $(this).find('input.HI');
                        var hf = $(this).find('input.HF');

                        var dt_ini = newDataHoraStr(true, dt.val() + ' ' + hi.val());
                        var dt_fim = newDataHoraStr(true, dt.val() + ' ' + hf.val());
                        var diff = dt_fim - dt_ini;
                        var str = float2str(diff / (60 * 60 * 1000));

                        var ch = $(this).find('td[data-campo="carga_horaria_real"]');
                        tot_real += str2float(str);
                        ch.html(str);

                        ch = $(this).find('td[data-campo="carga_horaria"]');
                        tot += str2float(ch.html());

                        var vetDT = dt.val().split("/");

                        if (vetDT[1] != mes || vetDT[2] != ano) {
                            alert('A Data do Encontro da Realização não esta no mês / ano da atividade (' + mes + '/' + ano + ')!');
                            dt.val('');
                            dt.focus();
                            OK = false;
                        } else if (diff < 0) {
                            alert('A Hora Final não pode ser menor que a Hora Inicio!');
                            hf.val('');
                            hf.focus();
                            OK = false;
                        }
                    }
                });
            }

            if (OK) {
                if (tot != tot_real) {
                    alert('A quantidade de horas realizadas esta diferente da quantidade de horas previstas!');
                    OK = false;
                }
            }

            return OK;
        }

        return true;
    }
</script>