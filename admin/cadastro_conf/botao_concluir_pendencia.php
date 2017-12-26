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
    if ($tipo == 'Evento') {
        echo " <div class='botao_ag_b2' onclick='return AprovarEvento({$idt_evento});' >";
        echo " <div style='margin:8px; '>Aprovar Evento</div>";
        echo " </div>";
        echo " <div class='botao_ag_b2' onclick='return DesAprovarEvento({$idt_evento});' >";
        echo " <div style='margin:8px; '>Não Aprovar Evento</div>";
        echo " </div>";
        echo " <div class='botao_ag_bl' onclick='return VoltarEvento();'>";
        echo " <div style='margin:8px; '>Voltar</div>";
        echo " </div>";

        /*

          echo " <div class='botao_ag_bl' onclick='return SalvarEvento();' >";
          echo " <div style='margin:8px; '>Salvar</div>";
          echo " </div>";
          echo " <div class='botao_ag_bl' onclick='return CancelarEvento_alt({$idt_evento});' >";
          echo " <div style='margin:8px; '>Cancelar</div>";
          echo " </div>";
          echo " <div class='botao_ag_bl' onclick='return VoltarEvento();'>";
          echo " <div style='margin:8px; '>Voltar</div>";
          echo " </div>";
         */
    } else {
        if ($_GET['grc_atendimento'] != 'S') {
            $hint = 'FINALIZAR - DEMANDA ATENDIDA.';
            echo " <div id='bt_resolver' class='botao_ag_b2' title='{$hint}' onclick='return EncaminharPendenciaA();' >";
            echo " <div style='margin:8px; '>DEMANDA ATENDIDA</div>";
            echo " </div>";
            //
            $hint = 'FINALIZAR - CANCELAR DEMANDA.';
            echo " <div id='bt_resolver' class='botao_ag_b2' title='{$hint}' onclick='return EncaminharPendenciaC();' >";
            echo " <div style='margin:8px; '>CANCELAR A DEMANDA</div>";
            echo " </div>";
            //
            /*
              $hint='Confirma a Gravação da tramitação da Pendência';
              echo " <div id='bt_confirmar_operacao'  class='botao_ag_blA' title='{$hint}' onclick='return SalvarEvento();' >";
              //echo " <div style='margin:8px; '>Enviar</div>";
              echo " <div style='margin:8px; '>CONFIRMAR OPERAÇÃO</div>";
              echo " </div>";
             */

            $hint = 'Retorna sem Gravar a tramitação da Pendência';
            echo " <div id='bt_voltar_operacao'  class='botao_ag_bl' title='{$hint}' onclick='return VoltarEvento();'>";
            echo " <div style='margin:8px; '>Voltar</div>";
            echo " </div>";
        } else if ($_GET['grc_atendimento'] == '') {
            echo " <div class='botao_ag_bl' onclick='return SalvarEvento();' >";
            echo " <div style='margin:8px; '>Enviar</div>";
            echo " </div>";
            echo " <div class='botao_ag_bl' onclick='return VoltarEvento();'>";
            echo " <div style='margin:8px; '>Voltar</div>";
            echo " </div>";
        }
    }
}
echo " </div>";
?>
<script>
    function AprovarEvento(idt_evento)
    {
        $.ajax({
            dataType: 'json',
            type: 'POST',
            url: 'ajax_atendimento.php' + '?tipo=AprovarEvento',
            data: {
                cas: conteudo_abrir_sistema,
                idt_evento: idt_evento,
                situacao: 'Aprovar'
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
        $(':submit:first').click();

    }

    function DesAprovarEvento(idt_evento)
    {
        $.ajax({
            dataType: 'json',
            type: 'POST',
            url: 'ajax_atendimento.php' + '?tipo=DesAprovarEvento',
            data: {
                cas: conteudo_abrir_sistema,
                idt_evento: idt_evento,
                situacao: 'Aprovar'
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
        $(':submit:first').click();
    }







    function SalvarEvento()
    {
        // alert ('ASalvarEvento');   
        situacao_submit = 'Salvar';

        if ('<?php echo $menu; ?>' == 'grc_atendimento_pendencia_m') {
            $('#ativo').val('N');
        }

        $(':submit:first').click();
    }
    function EncaminharPendenciaA()
    {
        objd = document.getElementById('idt_status_tramitacao');
        if (objd != null)
        {
            $(objd).val(3); // Finalizada Atendida

        }
        objd = document.getElementById('opcao_tramitacao');
        if (objd != null)
        {
            $(objd).val('R'); // Resolução

        }
		
		var opcao_tramitacao='';
        var objd = document.getElementById('opcao_tramitacao_E');
        if (objd != null)
        {
		    if (objd.checked == true)
			{
			    opcao_tramitacao = "E";
			}
        }
        var objd = document.getElementById('opcao_tramitacao_R');
        if (objd != null)
        {
		    if (objd.checked == true)
			{
			    opcao_tramitacao = "R";
			}
        }
        situacao_submit = 'Salvar';
        if ('<?php echo $menu; ?>' == 'grc_atendimento_pendencia_m') {
            $('#ativo').val('N');
        }
        $(':submit:first').click();
		
    }
    function EncaminharPendenciaC()
    {
        objd = document.getElementById('idt_status_tramitacao');
        if (objd != null)
        {
            $(objd).val(4); // Finalizada Camcelada

        }
        objd = document.getElementById('opcao_tramitacao');
        if (objd != null)
        {
            $(objd).val('R'); // Resolução

        }
        situacao_submit = 'Salvar';
        if ('<?php echo $menu; ?>' == 'grc_atendimento_pendencia_m') {
            $('#ativo').val('N');
        }
        $(':submit:first').click();
    }

    function CancelarEvento(idt_evento)
    {
        //alert ('CancelarEvento '+idt_evento);  


        $.ajax({
            dataType: 'json',
            type: 'POST',
            url: 'ajax_atendimento.php' + '?tipo=SituacaoEvento',
            data: {
                cas: conteudo_abrir_sistema,
                idt_evento: idt_evento,
                situacao: 'Cancelado'
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
        situacao_submit = 'Cancelado';
        $('#bt_voltar').click();
    }



    function CancelarEvento_alt(idt_evento)
    {
        //alert ('CancelarEvento '+idt_evento);  
        $.ajax({
            dataType: 'json',
            type: 'POST',
            url: 'ajax_atendimento.php' + '?tipo=SituacaoEvento',
            data: {
                cas: conteudo_abrir_sistema,
                idt_evento: idt_evento,
                situacao: 'Cancelado_alt'
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


        situacao_submit = 'Cancelado';
        $(':submit:first').click();
    }
    function VoltarEvento()
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