<?php
echo " <div onclick='return ConfirmaPrioridade_sim({$idt_atendimento_avulso});' style='color:#004080; font-size:14px; cursor:pointer; float:left; padding-top:20px; padding-left:0px; padding-right:5px;'>";
       echo " <img   title='Com Prioridade' src='imagens/imagem_com_prioridade.png' border='0'> Com Prioridade";
echo " </div>";





?>
<script>


$(document).ready(function () {

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
});



function ConfirmaPrioridade_sim(idt_atendimento_avulso)
{
   var id='tipo_pessoa';
   objtp = document.getElementById(id);
   if (objtp != null) {
       objtp.value = 'S';
    }
   ConfirmaPrioridade(idt_atendimento_avulso);

}


function ConfirmaPrioridade(idt_atendimento_avulso)
{

   var cpttp = "";


   var id='tipo_pessoa';
   objtp = document.getElementById(id);
   if (objtp != null) {
        var cpttp = objtp.value;
    }

  
   var id='mensagem';
   objx = document.getElementById(id);
   if (objx != null) {
       objx.value = '';
   }
   var id='hora_marcada_extra';
   obj = document.getElementById(id);

   if (obj != null) {
        var cpt = obj.value;
        if (cpt=='S')
        {
           if (objx != null) {
              objx.value = ' CLIENTE COM HORA MARCADA.';
           }
 
        }
        else
        {
          if (objx != null) {
             objx.value = ' CLIENTE SEM HORA MARCADA - EXTRA.';
          }
        }  
    }
    
    if (objx != null) {
       if (cpttp== 'N' || cpttp== '' )
       {
          objx.value= objx.value+"\n"+' ESCOLHIDA OPÇÃO DE FILA SEM PRIORIDADE';
       }
       else
       {
          objx.value=objx.value+"\n"+' ESCOLHIDA OPÇÃO DE FILA COM PRIORIDADE';
       }
    }

}

</script>