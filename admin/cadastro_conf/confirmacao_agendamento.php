<style>

</style>
<?php

echo " <div class='botao_ag' onclick='return ConfirmaAgendamento({$idt_atendimento_agenda});' >";
        echo " <div style='margin:8px; '>Confirmar Agendamento</div>";
echo " </div>";

echo " <div class='botao_ag'  onclick='DesfazConfirmacaoAgendamento({$idt_atendimento_agenda});' >";
        echo " <div style='margin:8px; '>Cancelar Confirmação</div>";
echo " </div>";


?>
<script>
function ConfirmaAgendamento(idt_atendimento_agenda)
{
  // alert(' ConfirmaAgendamento = '+idt_atendimento_agenda);
   

    var str = '';
    $.post('ajax_atendimento.php?tipo=ConfirmaAgendamento', {
        async : false,
		idt_atendimento_agenda : idt_atendimento_agenda
		
    }
    , function (str) {
        if (str == '')
        {

            str = str+" erro ao desfazer Confirmação do agendamento ";
            alert(url_decode(str).replace(/<br>/gi, "\n"));

         }
         else
         {
            var ret = str.split('###');
            data = ret[0];
            hora = ret[1];
            var id='data_confirmacao';
            obj = document.getElementById(id);
            if (obj != null) {
                obj.value = data;
            }
            var id='hora_confirmacao';
            obj = document.getElementById(id);
            if (obj != null) {
                obj.value = hora;
             }
             alert('Agendamento Confirmado');
         }
    });
   
   
    return false;
}

function DesfazConfirmacaoAgendamento(idt_atendimento_agenda)
{
  // alert(' DesfazConfirmacao = '+idt_atendimento_agenda);
  
    var str = '';
    $.post('ajax_atendimento.php?tipo=DesfazConfirmaAgendamento', {
        async : false,
		idt_atendimento_agenda : idt_atendimento_agenda
		
    }
    , function (str) {
        if (str == '')
        {
            str = str+" erro ao desfazer Confirmação do agendamento ";

            alert(url_decode(str).replace(/<br>/gi, "\n"));

         }
         else
         {
            var id='data_confirmacao';
            obj = document.getElementById(id);
            if (obj != null) {
                obj.value = '';
            }
            var id='hora_confirmacao';
            obj = document.getElementById(id);
            if (obj != null) {
                obj.value = '';
            }
            alert('Confiemação do Agendamento Desfeito');

         }
    });
   
  
  
  
  
  
            
    return false;
}

















</script>