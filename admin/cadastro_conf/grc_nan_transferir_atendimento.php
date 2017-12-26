<?php
$tabela = '';
$id = 'idt';
$acao = 'alt';
$botao_volta = "self.location = 'conteudo.php'";
$botao_acao = "<script type='text/javascript'>self.location = 'conteudo.php?".substr(getParametro(), 1)."';</script>";

$sql = '';
$sql .= ' select u.id_usuario, u.login, u.nome_completo';
$sql .= ' from grc_atendimento a';
$sql .= ' inner join grc_nan_grupo_atendimento g on g.idt = a.idt_grupo_atendimento';
$sql .= ' inner join plu_usuario u on u.id_usuario = a.idt_nan_empresa';
$sql .= ' where (';
$sql .= "    (a.nan_num_visita = 1 and g.status_1 <> 'AP')";
$sql .= " or (a.nan_num_visita = 1 and g.status_1 = 'AP' and g.num_visita_atu = 1)";
$sql .= " or (a.nan_num_visita = 2 and g.status_2 <> 'AP')";
$sql .= ' )';
$sql .= ' group by u.id_usuario, u.login, u.nome_completo';
$sql .= ' order by u.nome_completo';
$vetCampo['idt_nan_empresa'] = objCmbBanco('idt_nan_empresa', 'Empresa Credenciada', true, $sql);

$sql = '';
$sql .= ' select grc_pa.idt, grc_p.descricao, grc_pa.descricao';
$sql .= ' from grc_atendimento a';
$sql .= ' inner join grc_nan_grupo_atendimento g on g.idt = a.idt_grupo_atendimento';
$sql .= " inner join grc_projeto_acao grc_pa on grc_pa.idt = a.idt_projeto_acao";
$sql .= ' inner join grc_projeto grc_p on grc_p.idt = grc_pa.idt_projeto';
$sql .= ' where a.idt_nan_empresa = -1';
$sql .= ' and (';
$sql .= "    (a.nan_num_visita = 1 and g.status_1 <> 'AP')";
$sql .= " or (a.nan_num_visita = 1 and g.status_1 = 'AP' and g.num_visita_atu = 1)";
$sql .= " or (a.nan_num_visita = 2 and g.status_2 <> 'AP')";
$sql .= ' )';
$sql .= ' group by grc_pa.idt, grc_p.descricao, grc_pa.descricao';
$sql .= ' order by grc_p.descricao, grc_pa.descricao';
$vetCampo['idt_acao'] = objCmbBanco('idt_acao', 'Projeto/Ação', true, $sql);

$sql = '';
$sql .= ' select u.id_usuario, u.login, u.nome_completo';
$sql .= ' from grc_atendimento a';
$sql .= ' inner join grc_nan_grupo_atendimento g on g.idt = a.idt_grupo_atendimento';
$sql .= ' inner join plu_usuario u on u.id_usuario = a.idt_consultor';
$sql .= ' where a.idt_nan_empresa = -1';
$sql .= ' and a.idt_projeto_acao = -1';
$sql .= ' and (';
$sql .= "    (a.nan_num_visita = 1 and g.status_1 <> 'AP')";
$sql .= " or (a.nan_num_visita = 1 and g.status_1 = 'AP' and g.num_visita_atu = 1)";
$sql .= " or (a.nan_num_visita = 2 and g.status_2 <> 'AP')";
$sql .= ' )';
$sql .= ' group by u.id_usuario, u.login, u.nome_completo';
$sql .= ' order by u.nome_completo';
$vetCampo['idt_aoe'] = objCmbBanco('idt_aoe', 'Agente de Origem', true, $sql);

$vetCampo['listagem_aoe'] = objHidden('listagem_aoe', '');

$vetFrm = Array();

$vetParametros = Array(
    'width' => '95%',
);

$vetFrm[] = Frame('', Array(
    Array($vetCampo['idt_nan_empresa']),
    Array($vetCampo['idt_acao']),
    Array($vetCampo['idt_aoe']),
    Array($vetCampo['listagem_aoe']),
        ), '', '', true, $vetParametros);

$vetCad[] = $vetFrm;
?>
<style type="text/css">
    Tr.Registro:nth-child(even) {
        background-color: #f2f2f2;
        cursor:default;
    }

    Tr.Registro:nth-child(odd) {
        background-color: #ffffff;
        cursor:default;
    }

    Tr.Registro:hover {
        background-color: #ff8080;
        cursor:default;
    }
</style>
<script type="text/javascript">
    $(document).ready(function () {
        $("#idt_acao").cascade("#idt_nan_empresa", {
            ajax: {
                url: ajax_sistema + '?tipo=grc_nan_troca_aoe_acao&cas=' + conteudo_abrir_sistema
            }
        });

        $("#idt_nan_empresa, #idt_acao").change(function () {
            valor = $("#idt_aoe").val();

            if (valor != null) {
                $("#idt_aoe").empty();
                var position = {'z-index': '6000', 'position': 'absolute', 'width': '16px'};
                $.extend(position, $("#idt_aoe").offset());
                position.top = position.top + 3;
                position.left = position.left + 3;
                $("<div class='cascade-loading'>&nbsp;</div>").appendTo("body").css(position);
                $("#idt_aoe").disabled = true;

                $.ajax({
                    type: 'POST',
                    url: ajax_sistema + '?tipo=nan_at_pf_pj',
                    data: {
                        cas: conteudo_abrir_sistema,
                        idt_nan_empresa: $('#idt_nan_empresa').val(),
                        idt_acao: $('#idt_acao').val()
                    },
                    success: function (str) {
                        $('#idt_aoe').html(url_decode(str));
                        $('#idt_aoe').change();
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        alert('Erro no ajax no: ' + textStatus + ' - ' + errorThrown);
                    },
                    async: false
                });

                $(".cascade-loading").remove();
            }
        });

        $('#idt_nan_empresa').change(function () {
            $('#listagem_aoe_obj').html('');
        });

        $('#idt_aoe').change(function () {
            $('#listagem_aoe_obj').html('');

            if ($(this).val() != '') {
                processando();

                $.ajax({
                    dataType: 'json',
                    type: 'POST',
                    url: ajax_sistema + '?tipo=grc_nan_troca_aoe_listagem',
                    data: {
                        cas: conteudo_abrir_sistema,
                        idt_nan_empresa: $('#idt_nan_empresa').val(),
                        idt_aoe: $('#idt_aoe').val(),
                        idt_acao: $('#idt_acao').val()
                    },
                    success: function (response) {
                        if (response.erro == '') {
                            $('#listagem_aoe_obj').html(url_decode(response.html));
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

                TelaHeight();
                $("#dialog-processando").remove();
            }
        });

        $('#listagem_aoe_obj').on('change', '#idt_consultor_padrao', function () {
            $('tr.Registro select').val($(this).val());
        });
    });
</script>