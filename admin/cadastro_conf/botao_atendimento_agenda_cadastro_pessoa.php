<?php

echo " <div onclick='return CadastroCliente({$idt_atendimento_agenda});' style='color:#004080; font-size:14px; cursor:pointer; float:left; padding-top:20px; padding-left:0px; padding-right:5px;'>";
	    echo " <div style='float:left;'>";
       echo " <img   width='32' height='32'  title='Possibilita acesso ao Cadastro de Cliente' src='imagens/dados_clientes.png' border='0'>";
   	   echo " </div>";

	   echo " <div style='float:left;padding:5px; padding-top:10px;'>";
	   echo " Cadastro do Cliente";
	   echo " </div>";
echo " </div>";


?>
<script>
var acao = '<?php echo $acao; ?>'
function CadastroCliente(idt_atendimento_agenda)
{
	var cpf = "";
	var id='cpf';
	objtp = document.getElementById(id);
	if (objtp != null) {
	   cpf    = objtp.value;
	   if (cpf=='')
	   {
		   alert('Agenda sem Cliente Informado');
		   return false;
	   }
	}
	var titulo  = "<div style='xwidth:700px; display:block; text-align:center; '>Cadstro do Cliente</div>";
	var parww   = '&cpf='+cpf+'&acao='+acao+'&idt_atendimento_agenda='+idt_atendimento_agenda+'&deondeveio=Agenda'+'&titulo_rel='+titulo;  
	var href    = 'conteudo_cadastro_agenda_cliente.php?prefixo=cadastro&menu=grc_entidade_pessoa'+parww; 
	var  height = $(window).height(); 
	var  width  = $(window).width(); 
	showPopWin(href, titulo , width, height, null,true,0 );
}
</script>