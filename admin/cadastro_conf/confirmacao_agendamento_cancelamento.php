<style>
</style>


<?php




echo " <div class='botao_ag_bl' onclick='return CancelaAgendamento({$idt_atendimento_agenda});' style=' text-align:center; width:150px; height:35px; color:#FFFFFF; background:#0000FF; font-size:14px; cursor:pointer; float:left; margin:10px; xpadding-top:20px; xpadding-right:20px;'>";
       //echo " <img  title='Cancela Agendamento' src='imagens/alterar.png' border='0'>Cancelar a Marcação";

       echo " <div style='margin:8px; font-weight:bold; '>Cancelar a Marcação</div>";
       //echo " Cancelar a Marcação";
echo " </div>";

?>
<script>
function CancelaAgendamento(idt_atendimento_agenda)
{
//    alert(' CancelaAgendamento = '+idt_atendimento_agenda);
    var str = '';
    $.post('ajax_atendimento.php?tipo=CancelaAgendamento', {
        async : false,
        idt_atendimento_agenda : idt_atendimento_agenda
    }
    , function (str) {
        if (str == '')
        {
            //self.location= 'conteudo.php?acao=alt&texto0=&prefixo=cadastro&menu=grc_atendimento_agenda&id='+idt_atendimento_agenda;
            alert('Cancelamento de Agendamento');
         }
         else
         {
            alert(url_decode(str).replace(/<br>/gi, "\n"));
         }
    });
    return false;
}
</script>