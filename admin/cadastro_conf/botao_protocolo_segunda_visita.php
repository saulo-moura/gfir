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
        width:220px;
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
$idt_avaliacao=$_GET['idt_avaliacao'];

echo "<table border='0' cellspacing='0' cellpadding='0' width='100%' style='' >";
 echo "<tr>";
echo "<td>";
echo " O Protocolo da Segunda Visita será Gerado e impresso da forma mostrada abaixo.<br /><br />";
echo " Para Fechar TODO o Processo da PRIMEIRA VISITA e INICIAR o Processo da SEGUNDA VISITA, 'clicar' em 'Iniciar 2a Visita'<br />";
echo " ATENÇÃO. O PROTOCOLO SÓ PODERÁ SER IMPRESSO APÓS A EXECUÇÃO DA INICIALIZAÇÃO DA 2a VISITA.'<br />";


echo "</td>";
echo "</tr>";
echo "</table>";


echo " <div class='botao_ag_bl' onclick='return IniciarSegundaVisita($idt_avaliacao);'>";
echo " <div style='margin:8px; '>Iniciar 2a Visita</div>";
echo " </div>";

//echo " <div class='botao_ag_bl' onclick='return Voltar();'>";
//echo " <div style='margin:8px; '>Voltar</div>";
//echo " </div>";


?>
<script>
    $(document).ready(function () {
        
    });

    function ProtocoloPDF(idt_avaliacao)
    {
       
        alert('pdf');
        
    }

    
    function IniciarSegundaVisita(idt_avaliacao)
    {
		var mensagem = "Confirma a Inicialização da 2a Visita?";
		if (confirm(mensagem)) {
            $.ajax({
                dataType: 'json',
                type: 'POST',
                url: 'ajax_grc.php?tipo=InicializaSegundaVisita',
                data: {
                    cas: conteudo_abrir_sistema,
                    idt_avaliacao: idt_avaliacao
                },
                success: function (response) {
                    if (response.erro != '') {
                        alert(url_decode(response.erro));
                    }
					else
					{
					   alert('Inicialização da 2a Visita Atendimento NAN Obteve SUCESSO.'+"\n\n"+'Tecle OK para continuar.'+"\n\n");
					   // $('#retornar_a').click();
					   top.close();
					}
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert('Erro no ajax no: ' + textStatus + ' - ' + errorThrown);
                },
                async: false
            });
        }

    }
	function Voltar()
    {
        $('#bt_voltar').click();
    }
</script>