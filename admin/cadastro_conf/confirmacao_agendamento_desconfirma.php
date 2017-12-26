<style>
</style>


<?php
echo " <div class='botao_ag' onclick='return ConfirmaAgendamento({$idt_atendimento_agenda});' >";
//       echo " <img  title='Confirma Agendamento' src='imagens/alterar.png' border='0'> Confirmação";
        echo " <div style='margin:8px; '>Confirmar a Marcação</div>";
echo " </div>";

echo " <div class='botao_ag'  onclick='return DesfazConfirmacao({$idt_atendimento_agenda});' >";
        echo " <div style='margin:8px; '>Desconfirmar a Marcação</div>";
echo " </div>";

//echo " <div onclick='return DesfazConfirmacao({$idt_atendimento_agenda});' style='color:#004080; font-size:14px; cursor:pointer; float:left; padding-top:20px; padding-right:20px;'>";
  //     echo " <img  title='Desfaz Confirmação do Agendamento' src='imagens/alterar.png' border='0'> Desconfirmar ";
//echo " </div>";
?>
<script>
function ConfirmaAgendamento(idt_atendimento_agenda)
{
  // alert(' ConfirmaAgendamento = '+idt_atendimento_agenda);
   

    var str = '';
    $.post('ajax_atendimento.php?tipo=ConfirmaAgendamento', {
        async : false
    }
    , function (str) {
        if (str == '')
        {


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

function DesfazConfirmacao(idt_atendimento_agenda)
{
  // alert(' DesfazConfirmacao = '+idt_atendimento_agenda);
    
    
    
    
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
             alert('Agendamento Desfeito');

    
    
    
    
    
    
    
    
    
    
    
    
    return false;
}


</script>