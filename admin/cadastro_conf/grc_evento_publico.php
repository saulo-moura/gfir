<?php
if ($_GET['idCad'] != '') {
    $_GET['idt0'] = $_GET['idCad'];
    $botao_volta = "parent.btFechaCTC('" . $_GET['session_cod'] . "');";
    $botao_acao = '<script type="text/javascript">parent.btFechaCTC("' . $_GET['session_cod'] . '");</script>';
}

$TabelaPrinc = "grc_evento_publico";
$AliasPric = "grc_epc";
$Entidade = "Público Fechado da Política de Desconto";
$Entidade_p = "Público Fechado da Política de Desconto";
$CampoPricPai = "idt_evento";

$tabela = $TabelaPrinc;
$id = 'idt';

$vetFrm = Array();

$vetCampo[$CampoPricPai] = objHidden($CampoPricPai, $_GET['idt0']);
$vetCampo['cpf'] = objCPF('cpf', 'CPF', true);
$vetCampo['nome_pessoa'] = objTexto('nome_pessoa', 'Nome Completo', true, 120);

$vetFrm[] = Frame('', Array(
    Array($vetCampo[$CampoPricPai]),
    Array($vetCampo['cpf']),
    Array($vetCampo['nome_pessoa']),
        ));

$vetCad[] = $vetFrm;
?>
<script type="text/javascript">
    $(document).ready(function () {
        $('#cpf').change(function () {
            if ($(this).val() != '') {
                $('#btBuscaCPF').click();
            }
        });

        var btAcaoCPF = $('<img border="0" id="btBuscaCPF" style="margin-left: 3px; cursor: pointer; vertical-align: middle;" src="imagens/bt_pesquisa.png" title="Pesquisar">');

        btAcaoCPF.click(function () {
            if ($('#cpf').val() == '') {
                alert('Favor informar o CPF!');
                $('#cpf').val('');
                $('#cpf').focus();
                return false;
            }

            processando();

            $.ajax({
                dataType: 'json',
                type: 'POST',
                url: ajax_sistema + '?tipo=BuscaCPF_Nome',
                data: {
                    cas: conteudo_abrir_sistema,
                    cpf: $('#cpf').val()
                },
                success: function (response) {
                    $('#nome_pessoa').val(url_decode(response.nome_pessoa));

                    if ($('#nome_pessoa').val() == '') {
                        $('#nome_pessoa').removeProp("disabled").removeClass("campo_disabled");
                    } else {
                        $("#nome_pessoa").prop("disabled", true).addClass("campo_disabled");
                    }

                    if (response.erro != '') {
                        alert(url_decode(response.erro));
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    $("#dialog-processando").remove();
                    alert('Erro no ajax no: ' + textStatus + ' - ' + errorThrown);
                },
                async: false
            });

            $("#dialog-processando").remove();
        });

        $('#cpf_obj').attr('nowrap', 'nowrap').append(btAcaoCPF);
    });
</script>