<?php
$tabela = '';
$id = 'idt';
$acao = 'alt';
$botao_volta = "self.location = 'conteudo.php'";
$botao_acao = "<script type='text/javascript'>self.location = 'conteudo.php?".substr(getParametro(), 1)."';</script>";

$sql = '';
$sql .= " select ne.idt, concat(u.nome_completo, ' (', grc_p.descricao, ' / ', grc_pa.descricao, ')') as acao";
$sql .= ' from grc_nan_estrutura ne';
$sql .= ' inner join plu_usuario u on u.id_usuario = ne.idt_usuario';
$sql .= ' inner join grc_projeto_acao grc_pa on grc_pa.idt = ne.idt_acao';
$sql .= ' inner join grc_projeto grc_p on grc_p.idt = grc_pa.idt_projeto';
$sql .= ' where ne.idt_nan_tipo = 5';
$sql .= ' order by u.nome_completo';
$vetCampo['idt_tutor_old'] = objCmbBanco('idt_tutor_old', 'Tutor Origem', true, $sql);

$vetCampo['listagem_aoe'] = objHidden('listagem_aoe', '');

$vetFrm = Array();

$vetParametros = Array(
    'width' => '95%',
);

$vetFrm[] = Frame('', Array(
    Array($vetCampo['idt_tutor_old']),
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
        $('#idt_tutor_old').change(function () {
            $('#listagem_aoe_obj').html('');

            if ($(this).val() != '') {
                processando();

                $.ajax({
                    dataType: 'json',
                    type: 'POST',
                    url: ajax_sistema + '?tipo=grc_nan_troca_tutor_listagem',
                    data: {
                        cas: conteudo_abrir_sistema,
                        idt_tutor: $(this).val()
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
    });
</script>