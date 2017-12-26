<?php
$idt_atendimento_pendenciaw=$_GET['idt_atendimento_pendencia'];
if ($idt_atendimento_pendenciaw=='')
{
	$idt_atendimento_pendenciaw=$idt_atendimento_pendencia;
}
$idt_atendimento_pendencia=$idt_atendimento_pendenciaw;
$vetParametros=Array();
$vetRetorno=Array();
$Parametros['idt_atendimento_pendencia']=$idt_atendimento_pendencia;
PendenciaHistorico($Parametros,$Retorno);
echo $Retorno['html'];
?>
<script>
    $(document).ready(function () {
        
    });
</script>