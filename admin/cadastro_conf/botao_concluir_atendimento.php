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


    td.botao_concluir_atendimento_desc {
        background:#C0C0C0;
    }

</style>
<?php
if ($acao == 'inc' || $acao == 'alt') {
    echo " <div class='botao_ag_bl' onclick='return FinalizarAtendimento();' >";
    echo " <div style='margin:8px; '>Finalizar</div>";
    echo " </div>";

    echo " <div class='botao_ag_bl' onclick='return CancelarAtendimento();' >";
    echo " <div style='margin:8px; '>Cancelar</div>";
    echo " </div>";

    echo " <div class='botao_ag_bl' onclick='return VoltarAtendimentoAba2();'>";
    echo " <div style='margin:8px; '>Voltar</div>";
    echo " </div>";
} else {
    echo " <div class='botao_ag_bl' onclick='{$botao_volta_include};'>";
    echo " <div style='margin:8px; '>Voltar</div>";
    echo " </div>";
    if ($instrumento == 2) {
        if ($origem == "D") {
            echo " <div class='botao_ag_bl' onclick='return ConsultarDistanciaDevolutiva({$idt_atendimento},{$idt_atendimento_pendencia});' >";
            echo " <div style='margin:8px; '>Devolutiva</div>";
            echo " </div>";
        }
    }
}
?>
<script>
    $(document).ready(function () {
        onSubmitCancelado = function () {
            situacao_submit = '';
            onSubmitMsgTxt = '';
            valida_cust = '';
            $('#idt_instrumento').val('<?php echo $instrumento; ?>');

            $('#diagnostico_desc, #demanda_desc, #devolutiva_desc').removeClass("Tit_Campo").addClass("Tit_Campo_Obr");
        };
    });

    function FinalizarAtendimento()
    {
        if ($('#idt_instrumento').val() == '2') {
            calculaMinuto();

            var min = parseInt($('#horas_atendimento').val());

            if (isNaN(min)) {
                min = 0;
            }

            if (min < 60) {
                alert('O atendimento com o instrumento de consultoria precisa ter, no mínimo, 1h de duração');
                return false;
            }
        }
        
        if ('<?php echo $data_fim_atividade; ?>' != '' && $('#data').val() != '') {
            var dt_situacao = newDataStr('<?php echo $data_fim_atividade; ?>');
            var dt_atendimento = newDataStr($('#data').val());
            
            if (dt_atendimento - dt_situacao > 0) {
                alert('Data de inatividade do cadastro (<?php echo $data_fim_atividade; ?>) é menor que a data de início do atendimento. Não será possível concluir essa operação.');
                return false;
            }
        }

        situacao_submit = 'Finalizado';
        onSubmitMsgTxt  = 'Este atendimento será Finalizado e Gravado.\n\nConfirma?';
        $(':submit:first').click();
    }

    function CancelarAtendimento()
    {
        situacao_submit = 'Cancelado';
        onSubmitMsgTxt = 'Este atendimento será Cancelado.\n\nConfirma?';
        valida_cust = 'N';
        $(':submit:first').click();
    }

    function VoltarAtendimentoAba2()
    {
        situacao_submit = 'Finalizado em Alteração';
        $('#diagnostico_desc, #demanda_desc, #devolutiva_desc').addClass("Tit_Campo").removeClass("Tit_Campo_Obr");
        $(':submit:first').click();
    }



    function ConsultarDistanciaDevolutiva(idt_atendimento, idt_atendimento_pendencia)
    {
        //alert('devolutiva');

        var idt_servico = "";
        objd = document.getElementById('idt_servico');
        if (objd != null)
        {
            idt_servico = objd.value;
        }

        var parww = '&acao=alt&&idt_servico=' + idt_servico + '&idt_atendimento=' + idt_atendimento + '&idt_atendimento_pendencia=' + idt_atendimento_pendencia + '&id=' + idt_atendimento_pendencia + '&deondeveio=Devolutiva Distância';
        var href = 'conteudo.php?prefixo=cadastro&menu=grc_atendimento_pendencia_devolutiva&acao=con' + parww;

        self.location = href;
    }

</script>