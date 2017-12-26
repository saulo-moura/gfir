<style>

</style>
<?php





echo " <div class='botao_ag'  onclick='ConfirmaAusencia({$idt_atendimento_agenda});' >";
        echo " <div style='margin:8px; '>Confirmar Ausência</div>";
echo " </div>";


echo " <div class='botao_ag'  onclick='DesfazConfirmacaoAusencia({$idt_atendimento_agenda});' >";
        echo " <div style='margin:8px; '>Desfaz Ausência</div>";
echo " </div>";



?>
<script>









function ConfirmaAusencia(idt_atendimento_agenda)
{
  // alert(' ConfirmaAgendamento = '+idt_atendimento_agenda);
   

    var str = '';
    $.post('ajax_atendimento.php?tipo=ConfirmaAusencia', {
        async : false,
		idt_atendimento_agenda : idt_atendimento_agenda
		
    }
    , function (str) {
        if (str == '')
        {

            str = str+" erro ao Confirmar Ausência ";
            alert(url_decode(str).replace(/<br>/gi, "\n"));

         }
         else
         {
            var ret = str.split('###');
            data = ret[0];
            var id='data_hora_ausencia';
            obj = document.getElementById(id);
            if (obj != null) {
                obj.value = data;
            }
            alert('Registrada Ausência do Cliente. Data: '+data);
         }
    });
   
   
    return false;
}


function DesfazConfirmacaoAusencia(idt_atendimento_agenda)
{
  // alert(' DesfazConfirmacao = '+idt_atendimento_agenda);
  
    var str = '';
    $.post('ajax_atendimento.php?tipo=DesfazConfirmaAusencia', {
        async : false,
		idt_atendimento_agenda : idt_atendimento_agenda
		
    }
    , function (str) {
        if (str == '')
        {
            str = str+" erro ao desfazer Confirmação do ausêmcia ";

            alert(url_decode(str).replace(/<br>/gi, "\n"));

         }
         else
         {
            var id='data_hora_ausencia';
            obj = document.getElementById(id);
            if (obj != null) {
                obj.value = '';
            }
            alert('Confirmação do Agendamento Desfeito');

         }
    });
   
  
  
  
  
  
            
    return false;
}








</script>