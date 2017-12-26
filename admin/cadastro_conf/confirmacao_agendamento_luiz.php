<?php
echo " <div onclick='return ConfirmaAgendamento({$idt_atendimento_agenda});' style='color:#004080; font-size:14px; cursor:pointer; float:left; padding-top:20px; padding-right:20px;'>";
       echo " <img onclick='return ConfirmaAgendamento({$idt_atendimento_agenda});'   title='Confirma Agendamento' src='imagens/alterar.png' border='0'> Confirmação";
echo " </div>";
echo " <div onclick='return DesfazConfirmacao({$idt_atendimento_agenda});' style='color:#004080; font-size:14px; cursor:pointer; float:left; padding-top:20px; padding-right:20px;'>";
       echo " <img  title='Desfaz Confirmação do Agendamento' src='imagens/alterar.png' border='0'> Desconfirmar ";
echo " </div>";

echo " <div onclick='return BloqueiaHorario({$idt_atendimento_agenda});' style='color:#004080; font-size:14px; cursor:pointer; float:left; padding-top:20px; padding-right:20px;'>";
       echo " <img  title='Bloqueia Horário' src='imagens/alterar.png' border='0'>Bloqueia ";
echo " </div>";
echo " <div onclick='return DesbloqueiaHorario({$idt_atendimento_agenda});' style='color:#004080; font-size:14px; cursor:pointer; float:left; padding-top:20px; padding-right:20px;'>";
       echo " <img  title='Desbloqueia Horário' src='imagens/alterar.png' border='0'>Desbloqueia ";
echo " </div>";

echo " <div onclick='return CancelaAgendamento({$idt_atendimento_agenda});' style='color:#004080; font-size:14px; cursor:pointer; float:left; padding-top:20px; padding-right:20px;'>";
       echo " <img  title='Cancela Agendamento' src='imagens/alterar.png' border='0'> Cancelar";
echo " </div>";

?>
<script type="text/javascript">
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

function BloqueiaHorario(idt_atendimento_agenda)
{
  //  alert(' BloqueiaHorario = '+idt_atendimento_agenda);
    
    var str = '';
    $.post('ajax_atendimento.php?tipo=BloqueiaHorario', {
        async : false,
        idt_atendimento_agenda : idt_atendimento_agenda
    }
    , function (str) {
        if (str == '')
        {
            self.location= 'conteudo.php?acao=alt&texto0=&prefixo=cadastro&menu=grc_atendimento_agenda&id='+idt_atendimento_agenda;
            alert('Bloqueio Confirmado');
         }
         else
         {
            alert(url_decode(str).replace(/<br>/gi, "\n"));
         }
    });

    
    
    
    
    return false;
}

function DesbloqueiaHorario(idt_atendimento_agenda)
{
//    alert(' DesbloqueiaHorario = '+idt_atendimento_agenda);
    
    var str = '';
    $.post('ajax_atendimento.php?tipo=DesbloqueiaHorario', {
        async : false,
        idt_atendimento_agenda : idt_atendimento_agenda
    }
    , function (str) {
        if (str == '')
        {
           self.location= 'conteudo.php?acao=alt&texto0=&prefixo=cadastro&menu=grc_atendimento_agenda&id='+idt_atendimento_agenda;
           alert('Desbloqueio Confirmado');
         }
         else
         {
            alert(url_decode(str).replace(/<br>/gi, "\n"));
         }
    });

    
    return false;
}

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
            self.location= 'conteudo.php?acao=alt&texto0=&prefixo=cadastro&menu=grc_atendimento_agenda&id='+idt_atendimento_agenda;
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