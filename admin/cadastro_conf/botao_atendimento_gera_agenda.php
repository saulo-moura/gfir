<?php
echo " <div onclick='return ConfirmaGeracao({$idt_atendimento_gera_agenda});' style='color:#004080; font-size:14px; cursor:pointer; float:left; padding-top:0px; padding-left:30px; padding-right:5px;'>";
       echo " <img   title='Gera Agenda' src='imagens/alterar.png' border='0'> Gera Agenda";
echo " </div>";
?>
<script>
function ConfirmaGeracao(idt_atendimento_gera_agenda)
{
   // alert(' Confirma Gera��o ? = '+idt_atendimento_gera_agenda);

   var kokw = confirm('Deseja realmente gerar a agenda ?\n\nConfirma?');

   if (kokw == false)
   {
      alert('Opera��o n�o realizada por op��o do usu�rio');
      return false;
   }

    var str = '';
    $.post('ajax_atendimento.php?tipo=ConfirmaGeracaoAgenda', {
        async : false,
        idt_atendimento_gera_agenda : idt_atendimento_gera_agenda
    }
    , function (str) {
        if (str == '')
        {
           alert('Gera�ao Efetuada com Sucesso');
        }
        else
        {
           str = "Gera�ao n�o foi executada"+"\n"+str
           alert(url_decode(str).replace(/<br>/gi, "\n"));
         }
    });

   return false;
}
</script>