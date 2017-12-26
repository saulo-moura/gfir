<?php
echo " <div onclick='return ConfirmaAbertura({$idt_atendimento_abertura});' style='color:#004080; font-size:14px; cursor:pointer; float:left; padding-top:0px; padding-right:5px;'>";
       echo " <img   title='Confirma Abertura' src='imagens/alterar.png' border='0'> Abertura";
echo " </div>";
?>
<script type="text/javascript">
function ConfirmaAbertura(idt_atendimento_abertura)
{
   alert(' Confirma Abertura = '+idt_atendimento_abertura);
    return false;
}
</script>