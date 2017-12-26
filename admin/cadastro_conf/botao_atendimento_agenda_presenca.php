<?php
if ($acao=='con')
{
	echo " <div onclick='return ConfirmaPresencaSMS({$idt_atendimento_agenda});' style='color:#004080; font-size:14px; cursor:pointer; float:left; padding-top:20px; '>";
		   echo " <img  width='24' height='24' title='Solicitar Confirmação de Presença por SMS' src='imagens/presenca_sms.png' border='0'>";
	echo " </div>";
	echo " <div onclick='return ConfirmaPresencaEMAIL({$idt_atendimento_agenda});' style='color:#004080; font-size:14px; cursor:pointer; float:left; padding-top:20px; '>";
		   echo " <img  width='24' height='24' title='Solicitar Confirmação de Presença por EMAIL' src='imagens/presenca_email.png' border='0'>";
	echo " </div>";

	echo " <div onclick='return ConfirmaPresencaEMAIL({$idt_atendimento_agenda});' style='padding-left:5px; margin-top:5px; color:#004080; font-size:14px; cursor:pointer; float:left; padding-top:20px; '>";
		   echo " Confirmação de Presença";
	echo " </div>";
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


function ConfirmaPresencaSMS(idt_atendimento_agenda)
{
    //alert(' Confirma SMS = '+idt_atendimento_agenda);
	processando();
	$.ajax({
		dataType: 'json',
		type: 'POST',
		url: 'ajax_atendimento.php?tipo=EnviarSMSPresenca',
		data: {
			cas: conteudo_abrir_sistema,
			idt_atendimento_agenda : idt_atendimento_agenda
			//session_cod: $('#grc_atendimento_pendencia').data('session_cod')
		},
		success: function (response) {
			if (response.erro == '') {
			   alert(' SMS de Confirmação de Presença enviado com SUCESSO!');
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
	$("#dialog-processando").remove();
    return false;
}
function ConfirmaPresencaEMAIL(idt_atendimento_agenda)
{
   //alert(' Confirma EMAIL = '+idt_atendimento_agenda);
   processando();
	$.ajax({
		dataType: 'json',
		type: 'POST',
		url: 'ajax_atendimento.php?tipo=EnviarEMAILPresenca',
		data: {
			cas: conteudo_abrir_sistema,
			idt_atendimento_agenda : idt_atendimento_agenda
			//session_cod: $('#grc_atendimento_pendencia').data('session_cod')
		},
		success: function (response) {
			if (response.erro == '') {
			   alert(' EMAIL de Confirmação de Presença enviado com SUCESSO!');
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
	$("#dialog-processando").remove();
    return false;
}
</script>