<?php
echo " <div onclick='return ExibePecaPadrao();' style='color:#004080; font-size:14px; cursor:pointer; padding-top:20px; padding-left:0px; '>";
       echo " <img  width='24' height='24' title='Exibe Peça Padrão' src='imagens/exibir_peca.png' border='0'>";
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
       // chmar e mostrar peça
	   peca = "P";
       //alert('A Peça associada'+peca_padrao)
	   var url = 'conteudo_cadastro.php?acao=con&prefixo=cadastro&menu=grc_agenda_emailsms'+'&veio=pa&peca='+peca;
       var titulo = 'peça Padrão associada ao Evento';
       showPopWin(url, titulo, $('div.showPopWin_width').width() - 10, $(window).height() - 100, null, false);
   }
   else
   {
       alert('A Peça associada a esse Evento Não é a Padrão')
   }
}

/*
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
   
   }
   else
   {
      alert('A Peça associada a esse Evento Não é uma Peça gerada pela UAIN')
   }
}

function ExibePecaGestor()
{
   // Peça Gestor
   var idt_peca_gestor=0;
   var id='idt_peca_gestor';
   objtp = document.getElementById(id);
   if (objtp != null) {
       idt_peca_gestor = objtp.value;
   }
   if (idt_peca_gestor>0)
   {
       // chmar e mostrar peça Gestor
   
   }
   else
   {
      alert('A Peça associada a esse Evento Não é uma Peça gerada pelo Gestor')
   }
}
*/
</script>