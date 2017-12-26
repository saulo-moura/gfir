<style>
</style>

<?php
/*
echo " <div onclick='return ConfirmaChegada({$idt_atendimento_agenda});' style='color:#004080; font-size:14px; cursor:pointer; float:left; padding-top:0px; padding-right:5px;'>";
       echo " <img   title='Confirma Chegada' src='imagens/alterar.png' border='0'> Confirmar";
echo " </div>";
echo " <div onclick='return DesfazChegada({$idt_atendimento_agenda});' style='color:#004080; font-size:14px; cursor:pointer; float:left; padding-top:0px; padding-right:0px;'>";
       echo " <img  title='Desfaz Confirmação da Chegada' src='imagens/alterar.png' border='0'> Desconfirmar ";
echo " </div>";
*/



echo " <div class='botao_ag' onclick='return ConfirmaChegada({$idt_atendimento_agenda});' >";
        echo " <div style='margin:8px; '>Confirmar a Chegada</div>";
echo " </div>";

echo " <div class='botao_ag'  onclick='return DesfazChegada({$idt_atendimento_agenda});' >";
        echo " <div style='margin:8px; '>Desconfirmar a Chegada</div>";
echo " </div>";





?>
<script>
function ConfirmaChegada(idt_atendimento_agenda)
{
  // alert(' ConfirmaChegada = '+idt_atendimento_agenda);

    var str = '';
    $.post('ajax_atendimento.php?tipo=ConfirmaChegada', {
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
            var id='hora_chegada';
            obj = document.getElementById(id);
            if (obj != null) {
                obj.value = hora;
             }
             alert('Chegada Confirmada');
         }
    });


    return false;
}



   

function DesfazChegada(idt_atendimento_agenda)
{
//    alert(' Desfaz Chegada = '+idt_atendimento_agenda);
    
            var id='hora_chegada';
            obj = document.getElementById(id);
            if (obj != null) {
                obj.value = '';
             }
             alert('Chegada Desfeita');

    
    
    return false;
}
</script>