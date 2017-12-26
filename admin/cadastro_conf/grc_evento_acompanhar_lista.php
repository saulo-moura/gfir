<style type="text/css">
    fieldset.frame {
        border: none;
    }
</style>
<?php
$acao = 'alt';
$tabela = '';
$menu_acesso = 'grc_evento_acompanhar';
$bt_submit_mostra = false;
$bt_alterar_aviso = false;

$bt_barra_html_dep = '';
$bt_barra_html_dep .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
$bt_barra_html_dep .= '<input type="Button" name="btnAcao" class="Botao" onclick="listar_rel_pdf(\'LP\')" value="Lista de Presença">';
$bt_barra_html_dep .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
$bt_barra_html_dep .= '<input type="Button" name="btnAcao" class="Botao" onclick="listar_rel_pdf(\'LPB\')" value="Lista de Presença em Branco">';
$bt_barra_html_dep .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
$bt_barra_html_dep .= '<input type="Button" name="btnAcao" class="Botao" onclick="listar_rel_pdf(\'RB\')" value="Relatório de Participantes">';
$bt_barra_html_dep .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
$bt_barra_html_dep .= "<input type='Button' name='btnAcao' class='Botao' onclick='btEnviaEmailCred();' value='Enviar Por E-mail'>";

$vetFrm = Array();

$vetCampo['linha_vazia'] = objCmbVetor('linha_vazia', 'Colocar linhas em branco até o limite de vagas?', True, $vetNaoSim, '');
$vetCampo['concluio'] = objCmbVetor('concluio', 'Concluinte?', True, $vetSimNao, 'Todos');

$vetFrm[] = Frame('', Array(
    Array($vetCampo['linha_vazia'], '', $vetCampo['concluio']),
        ));

$vetTmp = Array();
$desc = 'Contrato';
$vetContrato = $vetEventoContrato;
unset($vetContrato['FE']);

foreach ($vetContrato as $key => $value) {
    $vetCampo['contrato_' . $key] = objCheckbox('contrato[' . $key . ']', $desc, $key, 'N', $value, false, $key);
    $desc = '';

    $vetTmp[] = $vetCampo['contrato_' . $key];
    $vetTmp[] = '';
}

array_pop($vetTmp);

$vetFrm[] = Frame('', Array($vetTmp));

$vetCad[] = $vetFrm;
?>
<script type="text/javascript">
    function btEnviaEmailCred() {
        if (confirm('Deseja enviar o e-mail para o Credenciado / Gestor?')) {
            processando();

            $.ajax({
                dataType: 'json',
                type: 'POST',
                url: ajax_sistema + '?tipo=grc_evento_acompanhar_lista_email',
                data: {
                    cas: conteudo_abrir_sistema,
                    form: $('#frm').serialize()
                },
                success: function (response) {
                    if (response.erro != '') {
                        $('#dialog-processando').remove();
                        alert(url_decode(response.erro));
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    $('#dialog-processando').remove();
                    alert('Erro no ajax no: ' + textStatus + ' - ' + errorThrown);
                },
                async: false
            });

            $('#dialog-processando').remove();
        }
    }
</script>