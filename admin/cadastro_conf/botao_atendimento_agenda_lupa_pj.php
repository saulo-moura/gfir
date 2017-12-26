<?php
echo " <div onclick='return ConfirmaCNPJ({$idt_atendimento_agenda});' style='color:#004080; font-size:14px; cursor:pointer; float:left; padding-top:20px; '>";
       echo " <img   title='Confirma CNPJ' src='imagens/bt_pesquisa.png' border='0'>";
echo " </div>";

?>
<script>


$(document).ready(function () {
/*
           objd=document.getElementById('tipo_pessoa_desc');
           if (objd != null)
           {
               $(objd).css('visibility','hidden');
           }
           objd=document.getElementById('tipo_pessoa');
           if (objd != null)
           {
               objd.value = "";
               $(objd).css('visibility','hidden');
           }
		   */
});


function ConfirmaCNPJ(idt_atendimento_agenda)
{
   //alert(' Confirma CNPJ = '+idt_atendimento_agenda);
   var id='cpf';
   obj = document.getElementById(id);
   if (obj != null) {
        var cpt = obj.value;
        if (cpt!='')
        {
			var id='cnpj';
			obj = document.getElementById(id);
			if (obj != null) {
				var cpt = obj.value;
				if (cpt!='')
				{
				    ChamaPessoaJuridica();
				}
				else 
				{
				   //alert('Por favor, informe o CNPJ.');
				   ChamaPessoaJuridica();
			   }
			}
        }
        else 
        {
	       alert('Por favor, informe o CPF.');
       }
    }
    return false;
}
</script>