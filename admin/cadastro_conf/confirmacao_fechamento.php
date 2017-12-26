<?php
echo " <div onclick='return ConfirmaFechamento({$idt_atendimento_abertura});' style='color:#004080; font-size:14px; cursor:pointer; float:left; padding-top:0px; padding-left:30px; padding-right:5px;'>";
       echo " <img   title='Confirma Fechamento' src='imagens/alterar.png' border='0'> Fechamento";
echo " </div>";
?>
<script type="text/javascript">
function ConfirmaFechamento(idt_atendimento_abertura)
{
   alert(' Confirma Fechamento = '+idt_atendimento_abertura);
    return false;
}
</script>