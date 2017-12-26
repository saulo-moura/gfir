<?php
echo " <div onclick='return ConfirmaCPF({$idt_atendimento_agenda});' style='color:#004080; font-size:14px; cursor:pointer; float:left; padding-top:20px; '>";
       echo " <img   title='Confirma CPF' src='imagens/bt_pesquisa.png' border='0'>";
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


function ConfirmaCPF(idt_atendimento_agenda)
{
   //alert(' Confirma CPF = '+idt_atendimento_agenda);
   var id='cpf';
   obj = document.getElementById(id);
   if (obj != null) {
        var cpt = obj.value;
        if (cpt!='')
        {
           //     obj.value = 'S';
		   //  
		   //alert('CPF = '+cpt);
	       ChamaPessoa();

        }
        else 
        {
      //     obj.value = 'N';
	       alert('Por favor, informe o CPF.');
       }
    }
    
    return false;
}
</script>