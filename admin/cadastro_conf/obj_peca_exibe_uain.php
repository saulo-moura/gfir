<?php
echo " <div onclick='return ExibePecaUAIN();' style='color:#004080; font-size:14px; cursor:pointer;  padding-top:20px; padding-left:0px;'>";
       echo " <img  width='24' height='24' title='Exibe Peça UAIN' src='imagens/exibir_peca.png' border='0'>";
echo " </div>";
?>
<script>



function ExibePecaUAIN()
{
   // Peça uain
   var idt_peca=0;
   var id='idt_peca';
   objtp = document.getElementById(id);
   if (objtp != null) {
       idt_peca = objtp.value;
   }
   if (idt_peca>0)
   {
       // chmar e mostrar peça Uain
	   peca = "U";
	   //alert('A Peça associada'+idt_peca);
	   var url = 'conteudo_cadastro.php?acao=con&prefixo=cadastro&menu=grc_agenda_emailsms'+'&veio=pa&peca='+peca+'&idt_peca='+idt_peca;
       var titulo = 'Peça Gerada pela UAIN';
       showPopWin(url, titulo, $('div.showPopWin_width').width() - 10, $(window).height() - 100, null, false);
   
   }
   else
   {
      alert('A Peça associada a esse Evento Não é uma Peça gerada pela UAIN')
   }
}


</script>