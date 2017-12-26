<?php

echo " <div onclick='return ConfirmaPrioridade_nao({$idt_atendimento_avulso});' style='color:#004080; font-size:14px; cursor:pointer; float:left; padding-top:20px; padding-left:0px; padding-right:5px;'>";
       echo " <img   title='Não tem Prioridade' src='imagens/imagem_sem_prioridade.png' border='0'>";
echo " </div>";


?>
<script>




function ConfirmaPrioridade_nao(idt_atendimento_avulso)
{
   var id='tipo_pessoa';
   objtp = document.getElementById(id);
   if (objtp != null) {
       objtp.value = 'N';
    }
   ConfirmaPrioridade(idt_atendimento_avulso);
}


</script>