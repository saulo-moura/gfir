<?php
echo " <div onclick='return ConfirmaPainel({$idt_atendimento_gera_painel});' style='color:#004080; font-size:14px; cursor:pointer; float:left; padding-top:0px; padding-left:30px; padding-right:5px;'>";
       echo " <img   title='Gera Painel' src='imagens/alterar.png' border='0'> Gera Painel";
echo " </div>";
?>
<script>
function ConfirmaPainel(idt_atendimento_gera_painel)
{
//   alert(' Confirma Gera��o ? = '+idt_atendimento_gera_painel);

   var kokw = confirm('Deseja realmente gerar o painel ?\n\nConfirma?');

   if (kokw == false)
   {
      alert('Opera��o n�o realizada por op��o do usu�rio');
      return false;
   }

    var str = '';
    $.post('ajax_atendimento.php?tipo=ConfirmaGeracaoPainel', {
        async : false,
        idt_atendimento_gera_painel : idt_atendimento_gera_painel
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