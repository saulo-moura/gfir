<?php
echo " <div onclick='return ExibePecaUAIN();' style='color:#004080; font-size:14px; cursor:pointer;  padding-top:20px; padding-left:0px;'>";
       echo " <img  width='24' height='24' title='Exibe Pe�a UAIN' src='imagens/exibir_peca.png' border='0'>";
echo " </div>";
?>
<script>



function ExibePecaUAIN()
{
   // Pe�a uain
   var idt_peca=0;
   var id='idt_peca';
   objtp = document.getElementById(id);
   if (objtp != null) {
       idt_peca = objtp.value;
   }
   if (idt_peca>0)
   {
       // chmar e mostrar pe�a Uain
	   peca = "U";
	   //alert('A Pe�a associada'+idt_peca);
	   var url = 'conteudo_cadastro.php?acao=con&prefixo=cadastro&menu=grc_agenda_emailsms'+'&veio=pa&peca='+peca+'&idt_peca='+idt_peca;
       var titulo = 'Pe�a Gerada pela UAIN';
       showPopWin(url, titulo, $('div.showPopWin_width').width() - 10, $(window).height() - 100, null, false);
   
   }
   else
   {
      alert('A Pe�a associada a esse Evento N�o � uma Pe�a gerada pela UAIN')
   }
}


</script>