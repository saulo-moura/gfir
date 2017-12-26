<style>

</style>
<?php
/*
echo " <div onclick='return ConfirmaAtendimento({$idt_atendimento_agenda});' style='color:#004080; font-size:14px; cursor:pointer; float:left; padding-top:20px; padding-right:20px;'>";
       echo " <img   title='Confirma Atendimento' src='imagens/alterar.png' border='0'> Confirmar";
echo " </div>";
echo " <div onclick='return DesfazAtendimento({$idt_atendimento_agenda});' style='color:#004080; font-size:14px; cursor:pointer; float:left; padding-top:20px; padding-right:20px;'>";
       echo " <img  title='Desfaz Confirmação do Atendimento' src='imagens/alterar.png' border='0'> Desconfirmar ";
echo " </div>";
*/




echo " <div class='botao_ag' onclick='return ConfirmaAtendimento({$idt_atendimento_agenda});' >";
        echo " <div style='margin:8px; '>Iniciar Atendimento</div>";
echo " </div>";

echo " <div class='botao_ag'  onclick='DesfazAtendimento({$idt_atendimento_agenda});' >";
        echo " <div style='margin:8px; '>Cancelar Atendimento</div>";
echo " </div>";


?>
<script>
function ConfirmaAtendimento(idt_atendimento_agenda)
{
//   alert(' Confirma Atendimento = '+idt_atendimento_agenda);
   
    var str = '';
    $.post('ajax_atendimento.php?tipo=ConfirmaAtendimento', {
        async : false ,
        idt_atendimento_agenda : idt_atendimento_agenda
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
       //   var id='data_confirmacao';
       //   obj = document.getElementById(id);
       //   if (obj != null) {
       //       obj.value = data;
       //   }
            var id='hora_atendimento';
            obj = document.getElementById(id);
            if (obj != null) {
                obj.value = hora;
             }
             alert('Atendimento Confirmado');
         }
    });

   
   
   
   
    return false;
}

function DesfazAtendimento(idt_atendimento_agenda)
{
//    alert(' Desfaz Atendimento = '+idt_atendimento_agenda);
    
            var id='hora_atendimento';
            obj = document.getElementById(id);
            if (obj != null) {
                obj.value = '';
             }
             alert('Atendimento Desfeito');

    
    
    
    
    return false;
}
</script>