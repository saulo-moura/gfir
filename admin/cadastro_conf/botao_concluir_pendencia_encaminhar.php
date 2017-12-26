<style>
    .botao_ag {
        text-align:center;
        width:180px;
        height:35px;
        color:#FFFFFF;
        background:#2F65BB;
        font-size:14px;
        cursor:pointer;
        float:left;
        margin-top:20px;
        margin-right:10px;
        font-weight:bold;
    }
    .botao_ag:hover {
        background:#0000FF;
    }
    .botao_ag_bl {
        text-align:center;
        width:100px;
        height:35px;
        color:#FFFFFF;
        background:#2F65BB;
        font-size:14px;
        cursor:pointer;
        display: inline-block;
        margin-top:10px;
        margin-right:10px;
        font-weight:bold;
    }
    .botao_ag_bl:hover {
        background:#0000FF;
    }


    .botao_ag_blA {
        text-align:center;
        width:200px;
        height:35px;
        color:#FFFFFF;
        background:#2F65BB;
        font-size:14px;
        cursor:pointer;
        display: inline-block;
        margin-top:10px;
        margin-right:10px;
        font-weight:bold;
    }
    .botao_ag_blA:hover {
        background:#0000FF;
    }






    .botao_ag_b2 {
        text-align:center;
        width:200px;
        height:35px;
        color:#FFFFFF;
        background:#2F65BB;
        font-size:14px;
        cursor:pointer;
        display: inline-block;
        margin-top:10px;
        margin-right:10px;
        font-weight:bold;
    }
    .botao_ag_b2:hover {
        background:#0000FF;
    }
    td.botao_concluir_atendimento_desc {
        background:#C0C0C0;
    }
    .barra_final {
        text-align:center;
        xborder:1px solid red;
    }
</style>
<?php
echo " <div class='barra_final' >";

if ($acao == 'con') {
    echo " <div class='botao_ag_bl' onclick='return VoltarEvento();'>";
    echo " <div style='margin:8px; '>Voltar</div>";
    echo " </div>";
} else {
    $hint = 'Encaminhar pendência para Consultores, exige Preenchimento dos dados necessários';
    echo " <div id='bt_encaminhar_e' class='botao_ag_b2' title='{$hint}' onclick='return EncaminharPendencia_e();' >";
    echo " <div style='margin:8px; '>ENCAMINHAR</div>";
    echo " </div>";
    $hint = 'Confirma a Gravação da Pendência mesmo sem Encaminhamento.';
    echo " <div id='bt_confirmar_operacao'  class='botao_ag_blA' title='{$hint}' onclick='return SalvarEvento_e();' >";
    //echo " <div style='margin:8px; '>Enviar</div>";
    echo " <div style='margin:8px; '>CONFIRMAR OPERAÇÃO</div>";
    echo " </div>";
    $hint = 'Retorna sem Gravar a Pendência';
    echo " <div id='bt_voltar_operacao_e'  class='botao_ag_bl' title='{$hint}' onclick='return VoltarEvento_e();'>";
    echo " <div style='margin:8px; '>Voltar</div>";
    echo " </div>";
}
echo " </div>";
?>
<script>
    function SalvarEvento_e()
    {
        // alert ('ASalvarEvento');   
        situacao_submit = 'Salvar';

        if ('<?php echo $menu; ?>' == 'grc_atendimento_pendencia_m') {
            $('#ativo').val('N');
        }

        $('#idt_status_tramitacao').val(1); //Aberto
        $(':submit:first').click();
    }
    
    function EncaminharPendencia_e()
    {

        $('#idt_status_tramitacao').val(2); //Encaminhado

        situacao_submit = 'Salvar';
        if ('<?php echo $menu; ?>' == 'grc_atendimento_pendencia_m') {
            $('#ativo').val('N');
        }
        $(':submit:first').click();
    }
    
    function VoltarEvento_e()
    {
        //alert ('VoltarEvento');   
        $.ajax({
            dataType: 'json',
            type: 'POST',
            url: 'ajax_atendimento.php' + '?tipo=ExcluiEventoTemporario',
            data: {
                cas: conteudo_abrir_sistema,
                idt_evento: idt_evento

            },
            success: function (response) {

                if (response.erro != '') {
                    alert(url_decode(response.erro));
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert('Erro no ajax no: ' + textStatus + ' - ' + errorThrown);
            },
            async: false
        });



        situacao_submit = 'Voltar';
        $('#bt_voltar').click();
    }
</script>