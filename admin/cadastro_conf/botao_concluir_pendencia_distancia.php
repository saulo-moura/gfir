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
    echo " <div class='botao_ag_bl' onclick='return VoltarDevolutiva();'>";
    echo " <div style='margin:8px; '>Voltar</div>";
    echo " </div>";
} else {
    $hint_ap="Clique para aprovar a Devolutiva e enviar para O Cliente.";
	echo " <div title='{$hint_ap}' class='botao_ag_b2' onclick='return AprovarDevolutiva({$idt_atendimento});' >";
	echo " <div style='margin:8px; '>Aprovar Devolutiva</div>";
	echo " </div>";
	$hint_nap="Clique para Não Aprovar a Devolutiva e manter em Pendência.";
	echo " <div title='{$hint_nap}' class='botao_ag_b2' onclick='return DesAprovarDevolutiva({$idt_atendimento});' >";
	echo " <div style='margin:8px; '>Devolver para Ajustes</div>";
	echo " </div>";
	$hint_v="Clique para Voltar sem tomar nenhuma ação.";
	echo " <div  title='{$hint_v}' class='botao_ag_bl' onclick='return VoltarDevolutiva();'>";
	echo " <div style='margin:8px; '>Voltar</div>";
	echo " </div>";
}
echo " </div>";

$sql = '';
$sql .= ' select idt_atendimento_agenda';
$sql .= ' from grc_atendimento';
$sql .= ' where idt = '.null($idt_atendimento);
$rs = execsql($sql);
$idt_atendimento_agenda = $rs->data[0][0];

$url = 'conteudo.php?prefixo=inc&menu=grc_atender_cliente&session_volta=avulso&idt_atendimento_agenda='.$idt_atendimento_agenda.'&idt_atendimento='.$idt_atendimento.'&id='.$idt_atendimento_agenda."&aba=2&idt_atendimento_pendencia=".$idt_atendimento_pendencia;
$acaoVoltarDevolutiva = 'self.location = "'.$url.'";';
?>
<script>
    function espera(idt_atendimento)
	{
        $.ajax({
            dataType: 'json',
            type: 'POST',
            url: 'ajax_atendimento.php' + '?tipo=AprovarDevolutivaDistancia',
            data: {
                cas: conteudo_abrir_sistema,
                idt_atendimento: idt_atendimento,
                situacao: 'Aprovar'
            },
            success: function (response) {
               // processando_acabou_grc();
                if (response.erro != '') {
				    processando_acabou_grc();
                    alert(url_decode(response.erro));
                }
				else
				{
				    processando_acabou_grc();
				    alert("Devolutiva Aprovada com sucesso.\nEnviada por email para o cliente.");
					self.location = 'conteudo.php';
				}
            },
            error: function (jqXHR, textStatus, errorThrown) {
			    processando_acabou_grc(); 
                alert('Erro no ajax no: ' + textStatus + ' - ' + errorThrown);
            },
            async: false
        });
	}
	
    function AprovarDevolutiva(idt_atendimento)
    {
	
	//processando_grc("", "");
        //alert ('AprovarDevolutiva '+idt_atendimento);   
		
        var titulo = "Gerando Devolutiva em PDF e enviando email para Cliente. Aguarde...";
        processando_grc(titulo, '#0000FF');
	    setTimeout(espera, 10000, idt_atendimento);
	
    }

    function DesAprovarDevolutiva(idt_atendimento)
    {
        var solucao = $('#solucao').val();
		if (solucao=="")
		{
		    alert("Por favor, informe o Parecer. Para NÃO Aprovar é Obrigatório o seu preenchimento.");
			$('#solucao').focus();
			return false;
		}
        $.ajax({
            dataType: 'json',
            type: 'POST',
            url: 'ajax_atendimento.php' + '?tipo=DesAprovarDevolutivaDistancia',
            data: {
                cas: conteudo_abrir_sistema,
                idt_atendimento: idt_atendimento,
				solucao    : solucao,
                situacao   : 'DesAprovar'
            },
            success: function (response) {

                if (response.erro != '') {
                    alert(url_decode(response.erro));
                }
				else
				{
				    alert("Devolutiva NÃO Aprovada.\nDevolvida para Ajustes.");
					self.location = 'conteudo.php';
				}
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert('Erro no ajax no: ' + textStatus + ' - ' + errorThrown);
            },
            async: false
        });
    }


    function VoltarDevolutiva()
    {
	<?php echo $acaoVoltarDevolutiva; ?>
    }
</script>