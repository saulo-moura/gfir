<?php
echo " <div onclick='return ExibePecaPadrao();' style='color:#004080; font-size:14px; cursor:pointer; padding-top:20px; padding-left:0px; '>";
       echo " <img  width='24' height='24' title='Exibe Pe�a Padr�o' src='imagens/exibir_peca.png' border='0'>";
echo " </div>";
?>
<script>

var peca = "";

function ExibePecaPadrao()
{
   var peca_padrao=0;
   var id='peca_padrao';
   objtp = document.getElementById(id);
   if (objtp != null) {
       peca_padrao = objtp.value;
   }
   if (peca_padrao=="S")
   {
       // chmar e mostrar pe�a
	   peca = "P";
       //alert('A Pe�a associada'+peca_padrao)
	   var url = 'conteudo_cadastro.php?acao=con&prefixo=cadastro&menu=grc_agenda_emailsms'+'&veio=pa&peca='+peca;
       var titulo = 'pe�a Padr�o associada ao Evento';
       showPopWin(url, titulo, $('div.showPopWin_width').width() - 10, $(window).height() - 100, null, false);
   }
   else
   {
       alert('A Pe�a associada a esse Evento N�o � a Padr�o')
   }
}

/*
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
   
   }
   else
   {
      alert('A Pe�a associada a esse Evento N�o � uma Pe�a gerada pela UAIN')
   }
}

function ExibePecaGestor()
{
   // Pe�a Gestor
   var idt_peca_gestor=0;
   var id='idt_peca_gestor';
   objtp = document.getElementById(id);
   if (objtp != null) {
       idt_peca_gestor = objtp.value;
   }
   if (idt_peca_gestor>0)
   {
       // chmar e mostrar pe�a Gestor
   
   }
   else
   {
      alert('A Pe�a associada a esse Evento N�o � uma Pe�a gerada pelo Gestor')
   }
}
*/
</script>