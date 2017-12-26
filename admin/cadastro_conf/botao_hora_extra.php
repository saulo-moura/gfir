<?php
echo " <div onclick='return ConfirmaHoraExtra({$idt_atendimento_avulso});' style='color:#004080; font-size:14px; cursor:pointer; float:left; padding-top:20px; padding-bottom:20px; padding-left:0px; padding-right:5px;'>";
       echo " <img   title='Informar se é Hora Extra' src='imagens/imagem_hora_extra.jpg' border='0'>";
echo " </div>";
?>
<script>
$(document).ready(function () {

           objd=document.getElementById('hora_marcada_extra_desc');
           if (objd != null)
           {
               $(objd).css('visibility','hidden');
               
           }
           objd=document.getElementById('hora_marcada_extra');
           if (objd != null)
           {
               objd.value = "";
               $(objd).css('visibility','hidden');
           }
});
function ConfirmaHoraExtra(idt_atendimento_avulso)
{
   //alert(' Confirma Prioridade = '+idt_atendimento_avulso);
   var id='hora_marcada_extra';
   obj = document.getElementById(id);
   if (obj != null) {
        var cpt = obj.value;
        obj.value = 'N';
    }
        objd=document.getElementById('protocolo_marcacao_desc');
           if (objd != null)
           {
             //  $(objd).hide();
               $(objd).css('visibility','hidden');

           }
           objd=document.getElementById('protocolo_marcacao');
           if (objd != null)
           {

               //$(objd).hide();
               $(objd).css('visibility','hidden');
 
            }


    ConfirmaPrioridade(idt_atendimento_avulso);

/* 
    var id='mensagem';
    objx = document.getElementById(id);
    if (objx != null) {
        objx.value = objx.value+"\n"+' CLIENTE SEM HORA MARCADA - EXTRA.';
    }
*/
    return false;
}
</script>