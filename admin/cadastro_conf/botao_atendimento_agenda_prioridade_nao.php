<?php

echo " <div onclick='return ConfirmaPrioridade_nao({$idt_atendimento_agenda});' style='color:#004080; font-size:14px; cursor:pointer; float:left; padding-top:20px; padding-left:0px; padding-right:5px;'>";
       echo " <img   width='32' height='32'  title='Não tem Prioridade' src='imagens/imagem_sem_prioridade.png' border='0'> Sem Prioridade";
echo " </div>";


?>
<script>




function ConfirmaPrioridade_nao(idt_atendimento_agenda)
{
   var id='tipo_pessoa';
   objtp = document.getElementById(id);
   if (objtp != null) {
       objtp.value = 'N';
    }
  // ConfirmaPrioridade(idt_atendimento_agenda);
}


</script>