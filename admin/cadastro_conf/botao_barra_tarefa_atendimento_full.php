<?php
$largura = 40;
$altura  = 40;
/*
echo " <div onclick='return ConfirmaPendencia({$idt_atendimento});' style='color:#004080; font-size:14px; cursor:pointer; float:left; padding-top:20px; padding-left:30px; padding-right:5px;'>";
       echo " <img width='{$largura}'  height='{$altura}'  title='Pendências' src='imagens/bt_pendencias.png' border='0'>";
echo " </div>";

echo " <div onclick='return ConfirmaHistorico({$idt_atendimento});' style='color:#004080; font-size:14px; cursor:pointer; float:left; padding-top:20px; padding-left:30px; padding-right:5px;'>";
       echo " <img width='{$largura}'  height='{$altura}'  title='Histórico' src='imagens/bt_historico.png' border='0'>";
echo " </div>";

echo " <div onclick='return ConfirmaVincular_pj({$idt_atendimento});' style='color:#004080; font-size:14px; cursor:pointer; float:left; padding-top:20px; padding-left:30px; padding-right:5px;'>";
       echo " <img width='{$largura}'  height='{$altura}'  title='Vincular PJ' src='imagens/bt_vincular_pj.png' border='0'>";
echo " </div>";

echo " <div onclick='return ConfirmaMaisPessoas({$idt_atendimento});' style='color:#004080; font-size:14px; cursor:pointer; float:left; padding-top:20px; padding-left:30px; padding-right:5px;'>";
       echo " <img width='{$largura}'  height='{$altura}'  title='+ Pessoas' src='imagens/bt_maisPessoas.png' border='0'>";
echo " </div>";
*/
echo " <div onclick='return ConfirmaLinks({$idt_atendimento});' style='color:#004080; font-size:14px; cursor:pointer; float:left; padding-top:20px; padding-left:30px; padding-right:5px;'>";
       echo " <img width='{$largura}'  height='{$altura}'  title='Links' src='imagens/bt_links.png' border='0'>";
echo " </div>";

echo " <div onclick='return ConfirmaPesquisas({$idt_atendimento});' style='color:#004080; font-size:14px; cursor:pointer; float:left; padding-top:20px; padding-left:30px; padding-right:5px;'>";
       echo " <img width='{$largura}'  height='{$altura}'  title='Pesquisas' src='imagens/bt_links.png' border='0'>";
echo " </div>";

echo " <div onclick='return ConfirmaPerguntasFrequentes({$idt_atendimento});' style='color:#004080; font-size:14px; cursor:pointer; float:left; padding-top:20px; padding-left:30px; padding-right:5px;'>";
       echo " <img width='{$largura}'  height='{$altura}'  title='Perguntas Frequentes' src='imagens/bt_faqs.png' border='0'>";
echo " </div>";

echo " <div onclick='return ConfirmaProgramaFidelidade({$idt_atendimento});' style='color:#004080; font-size:14px; cursor:pointer; float:left; padding-top:20px; padding-left:30px; padding-right:5px;'>";
       echo " <img width='{$largura}'  height='{$altura}'  title='Programa de Fidelidade' src='imagens/bt_fidelidade.png' border='0'>";
echo " </div>";

$larguraw = 120;
$alturaw  = 40;

echo " <div onclick='return ConfirmaBaseInformacoes({$idt_atendimento});' style='color:#004080; font-size:14px; cursor:pointer; float:left; padding-top:20px; padding-left:30px; padding-right:5px;'>";
       echo " <img width='{$larguraw}'  height='{$alturaw}'  title='Base de Informações' src='imagens/bt_baseinformacao.png' border='0'>";
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

function ConfirmaPendencia(idt_atendimento)
{
   alert(' vivo estou 1 '+idt_atendimento);
    /*
   var id='tipo_pessoa';
   objtp = document.getElementById(id);
   if (objtp != null) {
       objtp.value = 'S';
    }
*/
}

function ConfirmaHistorico(idt_atendimento)
{
   alert(' vivo estou 2 '+idt_atendimento);
}

function ConfirmaVincular_pj(idt_atendimento)
{
   alert(' vivo estou 3 '+idt_atendimento);
}

function ConfirmaMaisPessoas(idt_atendimento)
{
   alert(' vivo estou 4 '+idt_atendimento);
}

function ConfirmaLinks(idt_atendimento)
{
   alert(' vivo estou 5 '+idt_atendimento);
}

function ConfirmaPesquisas(idt_atendimento)
{
   alert(' vivo estou 6 '+idt_atendimento);
}

function ConfirmaPerguntasFrequentes(idt_atendimento)
{
   alert(' vivo estou 7 '+idt_atendimento);
}

function ConfirmaProgramaFidelidade(idt_atendimento)
{
   alert(' vivo estou 8 '+idt_atendimento);
}

function ConfirmaBaseInformacoes(idt_atendimento)
{
   alert(' vivo estou 9 '+idt_atendimento);
}




</script>
