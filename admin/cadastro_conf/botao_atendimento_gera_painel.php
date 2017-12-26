<?php
echo " <div onclick='return ConfirmaPainel({$idt_atendimento_gera_painel});' style='color:#004080; font-size:14px; cursor:pointer; float:left; padding-top:0px; padding-left:30px; padding-right:5px;'>";
       echo " <img   title='Gera Painel' src='imagens/alterar.png' border='0'> Gera Painel";
echo " </div>";
?>
<script>
function ConfirmaPainel(idt_atendimento_gera_painel)
{
//   alert(' Confirma Geração ? = '+idt_atendimento_gera_painel);

   var kokw = confirm('Deseja realmente gerar o painel ?\n\nConfirma?');

   if (kokw == false)
   {
      alert('Operação não realizada por opção do usuário');
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
           alert('Geraçao Efetuada com Sucesso');
        }
        else
        {
           str = "Geraçao não foi executada"+"\n"+str
           alert(url_decode(str).replace(/<br>/gi, "\n"));
         }
    });


   
   return false;
}
</script>