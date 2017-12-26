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
        width:350px;
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

//if ($acao == 'inc' || $acao == 'alt') {
if ($acao == 'con' || $acao == 'alt' ) {
    echo " <div class='botao_ag_bl' onclick='return ConfirmaVerificarAgenda()' >";
    echo " <div style='margin:8px; '>Verificar Agenda</div>";
    echo " </div>";

    
} else {
    //echo " <div class='botao_ag_bl' onclick='{$botao_volta_include};'>";
    //echo " <div style='margin:8px; '>Voltar</div>";
    //echo " </div>";
}


?>
<script>


$(document).ready(function () {
/*
           objd=document.getElementById('tipo_pessoa_desc');
           if (objd != null)
           {
               $(objd).css('visibility','hidden');
           }
           objd=document.getElementById('tipo_pessoa');
           if (objd != null)
           {
               objd.value = "";
               $(objd).css('visibility','hidden');
           }
		   
	   
*/		   
});
function ConfirmaVerificarAgenda()
{
   // alert(' teste VerificarAgenda ');  
    var opcao=99;
	var thisw=0;
    var ret1 = VerificaHora(thisw,opcao);
    var ret2 = VerificaHoraInt(thisw,opcao);	
	if (ret1==false)
	{
	    alert('Hora Invalida');
	    return false;
	}
	if (ret2==false)
	{
	    alert('Hora Invalida');
	    return false;
	}
    var executa         = "#executa";
	var data_aleatoria  = "#data_aleatoria";
	var valexecuta      = $(executa).val();
	var data_aleatoria  = $(data_aleatoria).val();
	if (data_aleatoria!="")
	{
	    var msg = "";
	    msg = msg+"Atenção!"+"\n";
		msg = msg+"Será considerada Opção de Datas Aleatórias."+"\n";
		msg = msg+"Confirma?"+"\n";
		if (!confirm(msg))
		{
		    return false;
		}	
	
	}
	    
	    var idt_atendimento_agenda   = "#idt_atendimento_agenda";
		var dt_inicial            = "#dt_inicial";
		var dt_final              = "#dt_final";
		var idt_consultor         = "#idt_consultor";
		var idt_ponto_atendimento = "#idt_ponto_atendimento";
		var hora_inicio           = "#hora_inicio";
		var hora_fim              = "#hora_fim";
		
		var hora_intervalo_inicio = "#hora_intervalo_inicio";
		var hora_intervalo_fim    = "#hora_intervalo_fim";
		
		var idt_servico           = "#idt_servico";
		var data_aleatoria        = "#data_aleatoria";
		var observacao            = "#observacao";
		
		
		var idt_atendimento_agenda = 0;
		var dt_inicial  = $(dt_inicial).val();
		var dt_final    = $(dt_final).val();
		
        var idt_consultor    = $(idt_consultor).val();
		var idt_ponto_atendimento    = $(idt_ponto_atendimento).val();
		var hora_inicio    = $(hora_inicio).val();
		var hora_fim    = $(hora_fim).val();
		var hora_intervalo_inicio   = $(hora_intervalo_inicio).val();
		var hora_intervalo_fim   = $(hora_intervalo_fim).val();
		
		var idt_servico   = $(idt_servico).val();
		var data_aleatoria   = $(data_aleatoria).val();
		var observacao   = $(observacao).val();
        var volta = "N";
		if (dt_inicial=='')
		{
		    alert('Informe Data Inicial.');
			return false;
		}
		if (dt_final=='')
		{
		    alert('Informe Data Final.');
			return false;
		}
		if (hora_inicio=='')
		{
		    alert('Informe Hora Inicial.');
			return false;
		}
		if (hora_fim=='')
		{
		    alert('Informe Hora Final.');
			return false;
		}
		if (idt_ponto_atendimento=='')
		{
		    alert('Informe Ponto de Atendimento.');
			return false;
		}
		if (idt_consultor=='')
		{
		    alert('Informe Consultor.');
			return false;
		}
        //alert('bbbbb '+dt_inicial);	
		$.ajax({
			dataType: 'json', 
			type: 'POST',
			url: ajax_sistema + '?tipo=CarregarAgendaExistente',
			data: {
				cas: conteudo_abrir_sistema,
				idt_atendimento_gera_agenda : idt_atendimento_gera_agenda,
				dt_inicial : dt_inicial,    
				dt_final : dt_final, 
				idt_consultor : idt_consultor, 
				idt_ponto_atendimento : idt_ponto_atendimento, 
				hora_inicio : hora_inicio, 
				hora_fim : hora_fim, 
				hora_intervalo_inicio : hora_intervalo_inicio, 
				hora_intervalo_fim : hora_intervalo_fim, 
				idt_servico : idt_servico, 
				data_aleatoria : data_aleatoria, 
				observacao : observacao 
			},
			success: function (response) {
				if (response.erro == '') {
				    if (response.existeagenda == 'N') {
					   // Não tem agenda Procede como de primeira vez
					   alert('Não tem Agenda no Período Informado');
	                }
					else					
					{
					//Ext.Msg.alert('Status', 'Changes saved successfully.');

					
					    // Questiona
						//var r = confirm("Para o Período informado Existem Registros na sua Agenda."+"\n"+"Deseja Verificar os Existentes?");
						var r = true;
						if (r == false) {
							// Parar a OPERAção - Desistir e voltar a tela sem fazer nada.
							//return false;
							volta = "N";
							//alert('Não tem Agenda no Período Informado vvv');
						} else {
						    volta = "S";
	                        var titulo  = "<div style='xwidth:700px; display:block; text-align:center; '>Agenda do Período</div>";
							var parww   = '&idt_atendimento_agenda='+idt_atendimento_agenda+'&deondeveio=Distancia'+'&titulo_rel='+titulo;  
							var href    = 'conteudo_agenda_ex.php?prefixo=inc&menu=agenda_ex'+parww; 
		
							var  height = $(window).height(); 
							var  width  = $(window).width(); 
							
							var  height = 600; 
							var  width  = 900; 
							
							showPopWin(href, titulo , width, height, close_ChamaFuncao1,true,20);
							
						}
					}	
				} else {
					alert(url_decode(response.erro));
				}
			},
			error: function (jqXHR, textStatus, errorThrown) {
				alert('Erro no ajax no: ' + textStatus + ' - ' + errorThrown);
			},
			async: false
		});		
		
	return true;
}
function close_ChamaFuncao1(returnVal) { 
//location.reload();
}

</script>


