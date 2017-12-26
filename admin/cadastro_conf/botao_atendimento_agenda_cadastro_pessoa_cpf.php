<?php

echo " <div onclick='return CadastroCliente({$idt_atendimento_agenda});' style='color:#004080; font-size:14px; cursor:pointer; float:left; padding-top:20px; padding-left:0px; padding-right:5px;'>";
       echo " <img   width='32' height='32'  title='Possibilita acesso ao Cadastro de Cliente' src='imagens/dados_clientes.png' border='0'>";
echo " </div>";


?>
<script>


var idt_cliente = '<?php echo $idt_cliente;   ?>';

function CadastroCliente(idt_atendimento_agenda)
{
   alert('cadastro de cliente'+idt_cliente+' aaaa '+idt_atendimento_agenda);
   /*
   var id='tipo_pessoa';
   objtp = document.getElementById(id);
   if (objtp != null) {
       objtp.value = 'N';
    }
	*/
  // ConfirmaPrioridade(idt_atendimento_agenda);
}


</script>