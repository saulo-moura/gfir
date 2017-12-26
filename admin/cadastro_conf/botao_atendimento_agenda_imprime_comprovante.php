<?php

echo " <div onclick='return ImprimeComprovante({$idt_atendimento_agenda});' style='color:#004080; font-size:14px; cursor:pointer; float:left; padding-top:20px; padding-left:0px; padding-right:5px;'>";
       echo " <div style='float:left;'>";
       echo " <img   width='32' height='32'  title='Possibilita Imprimir Comprovante' src='imagens/comprovante_agendamento.png' border='0'>";
   	   echo " </div>";

	   echo " <div style='float:left;padding:5px;'>";
	   echo " Comprovante de Agendamento";
	   echo " </div>";
echo " </div>";


?>
<script>

var acao = '<?php echo $acao; ?>';

$(document).ready(function () {
	onSubmitCancelado = function () {
		valida_cust = '';
		onSubmitMsgTxt = '';
		
		$('#acao_imprime_comprovante').val('N');
	};
});

function ImprimeComprovante(idt_atendimento_agenda)
{
    //alert('to aqui sim ');
    var cpf = "";
	var id='cpf';
	objtp = document.getElementById(id);
	if (objtp != null) {
	   cpf    = objtp.value;
	   if (cpf=='')
	   {
		   alert('Agenda sem Cliente Informado');
		   return false;
	   }
	}
	
	
	
	
	
	
    if (acao=='inc' || acao=='alt'  )
	{
		var r = confirm("A Marcação será Registrada para Impressão do Comprovante.Confirma?");
		if (r == true) {
			//clicar no botão
			
			$('#acao_imprime_comprovante').val('S');
			
			$(':submit:first').click();
			
			
			/*
			var botoes = document.getElementsByTagName("button");
			for (var i = 0; i < botoes.length; i++) {
				if (botoes[i].className === "MINHA-CASSE") {
					botoes[i].click();
				}
			}
			*/
			
		} else {
			return false;
		}
    }
	else
	{
	   //alert('Imprime Comprovante');
	   /*
	   var id='tipo_pessoa';
	   objtp = document.getElementById(id);
	   if (objtp != null) {
		   objtp.value = 'N';
		}
		*/
	  // ConfirmaPrioridade(idt_atendimento_agenda);
	  
		var titulo = "<div style='xwidth:700px; display:block; text-align:center; '>Comprovante de Agendamento</div>";
		
		var parww='&idt_atendimento_agenda='+idt_atendimento_agenda+'&deondeveio=Distancia'+'&titulo_rel='+titulo;  
		var href    ='conteudo_print.php?prefixo=relatorio&menu=grc_imprime_comprovante_agendamento'+parww; 
		
		var  height = $(window).height(); 
		var  width  = $(window).width(); 
		
		var  height = 600; 
		var  width  = 900; 
		
		
		
		
		//showPopWin(href, titulo , width, height, close_ChamaFuncao1,true,20);
		
		
		var  left   = 0; 
		var  top    = 0; 
		var  height = $(window).height(); 
		var  width  = $(window).width();  
		var ImpComp = window.open(href,'ImpComp','left='+left+',top='+top+',width='+width+',height='+height+',resizable=yes,menubar=no,scrollbars=yes,toolbar=no'); 
	}
		
	
	return 1;
}
/*
function ListarCmbClose(returnVal) {
    var valorAnt = $('#' + returnVal.campo).val();
    var descAnt = $('#' + returnVal.campo + '_obj > div').text();

    $('#' + returnVal.campo).val(returnVal.valor);
    $('#' + returnVal.campo + '_obj > div').text(returnVal.desc);

    if ($('#contListar').length > 0) {
        $('#contListar').height($('#contListar').innerHeight()).html('<div align="center" class="Msg">Favor clicar no botão de Pesquisar!</div>');
        //TelaHeight();
    }

    var fncListarCmbMuda = window['fncListarCmbMuda_' + returnVal.campo];

    if ($.isFunction(fncListarCmbMuda)) {
        fncListarCmbMuda(returnVal.valor, returnVal.desc, valorAnt, descAnt);
    }
}
*/

function close_ChamaFuncao1(returnVal) { 
}
	
  


</script>