<style>
</style>

<?php
/*
echo " <div onclick='return ConfirmaLiberacao({$idt_atendimento_agenda});' style='color:#004080; font-size:14px; cursor:pointer; float:left; padding-top:0px; padding-right:5px;'>";
       echo " <img  title='Confirma Liberação' src='imagens/alterar.png' border='0'>Liberar ";
echo " </div>";
echo " <div onclick='return DesfazLiberacao({$idt_atendimento_agenda});' style='color:#004080; font-size:14px; cursor:pointer; float:left; padding-top:0px; padding-right:0px;'>";
       echo " <img  title='Desfaz Liberação' src='imagens/alterar.png' border='0'>Desliberar ";
echo " </div>";
*/

echo " <div class='botao_ag' onclick='return ConfirmaLiberacao({$idt_atendimento_agenda});' >";
        echo " <div style='margin:8px; '>Liberar para Atendimento</div>";
echo " </div>";

echo " <div class='botao_ag'  onclick='return DesfazLiberacao({$idt_atendimento_agenda});' >";
        echo " <div style='margin:8px; '>Cancelar Liberação</div>";
echo " </div>";


?>
<script>
function ConfirmaLiberacao(idt_atendimento_agenda)
{
//    alert(' Confirma Liberação = '+idt_atendimento_agenda);

    var str = '';
    $.post('ajax_atendimento.php?tipo=ConfirmaLiberacao', {
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
            var id='hora_liberacao';
            obj = document.getElementById(id);
            if (obj != null) {
                obj.value = hora;
             }
             alert('Liberação Confirmada');
         }
    });


    return false;
}

function DesfazLiberacao(idt_atendimento_agenda)
{
//    alert(' Desfaz Liberação = '+idt_atendimento_agenda);

            var id='hora_liberacao';
            obj = document.getElementById(id);
            if (obj != null) {
                obj.value = '';
             }
             alert('Liberação Desfeita');


    return false;
}

</script>