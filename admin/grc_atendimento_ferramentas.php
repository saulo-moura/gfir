
<style>

.div_instrumento {
   border:2px solid #FFFFFF;
   color:#004080;
   font-size:14px;
   cursor:pointer;
   float:left;
   xpadding:2px;

}
</style>

<?php




$idt_atendimento=0;

$largura = 48;
$altura  = 48;




echo " <div  style='width:100%; xdisplay:block; xfloat:right; xborder:1px solid red;'>";

// segunda serie de botões

echo " <div onclick='return ConfirmaOpcao({$idt_atendimento},1);'  style='color:#004080; font-size:14px; cursor:pointer; float:left; padding-top:0px; padding-left:0px; padding-right:5px;'>";
       echo " <img width='{$largura}'  height='{$altura}'  title='Links' src='imagens/bt_links.png' border='0'>";
echo " </div>";

echo " <div onclick='return  ConfirmaOpcao({$idt_atendimento},2);'  style='color:#004080; font-size:14px; cursor:pointer; float:left; padding-top:0px; padding-left:0px; padding-right:5px;'>";
       echo " <img width='{$largura}'  height='{$altura}'  title='Pesquisas' src='imagens/atendimento_pesquisas.png' border='0'>";
echo " </div>";

echo " <div onclick='return ConfirmaOpcao({$idt_atendimento},3);' style='color:#004080; font-size:14px; cursor:pointer; float:left; padding-top:0px; padding-left:0px; padding-right:5px;'>";
       echo " <img width='{$largura}'  height='{$altura}'  title='Perguntas Frequentes' src='imagens/bt_faqs.png' border='0'>";
echo " </div>";

echo " <div onclick='return  ConfirmaOpcao({$idt_atendimento},4);'  style='color:#004080; font-size:14px; cursor:pointer; float:left; padding-top:0px; padding-left:0px; padding-right:5px;'>";
       echo " <img width='{$largura}'  height='{$altura}'  title='Programa de Fidelidade' src='imagens/bt_fidelidade.png' border='0'>";
echo " </div>";



$larguraw = 120;
$alturaw  = 40;

echo " <div onclick='return ConfirmaBaseInformacoes({$idt_atendimento});' style='color:#004080; font-size:14px; cursor:pointer; float:left; padding-top:0px; padding-left:0px; padding-right:5px;'>";
       echo " <img width='{$larguraw}'  height='{$alturaw}'  title='Base de Informações' src='imagens/bt_baseinformacao.png' border='0'>";
echo " </div>";


echo " </div>";




?>
<script>

var instrumento = '<?php  echo $instrumento; ?>';
var idt_atendimento = '<?php  echo $idt_atendimento; ?>';

$(document).ready(function () {

});


function ConfirmaOpcao(idt_atendimento,opcao)
{
   var  left   = 0;
   var  top    = 0;
   var  height = $(window).height();
   var  width  = $(window).width();
   var prefixo = "";
   var menu    = "";
   if (opcao==1)
   {
       prefixo = 'listar';
       menu    =  'plu_link_util';
   }
   if (opcao==3)
   {
       prefixo = 'listar';
       menu    =  'grc_pergunta_resposta';
   }
   var link_at='conteudo_atendimento.php?prefixo='+prefixo+'&menu='+menu+'&titulo_rel=&idt_atendimento='+idt_atendimento+'&opcao='+opcao;
   self.location = link_at;
}


</script>
