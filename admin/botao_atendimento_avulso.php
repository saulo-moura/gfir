<?php
echo " <div onclick='return ConfirmaPrioridade_sim({$idt_atendimento_avulso});' style='color:#004080; font-size:14px; cursor:pointer; float:left; padding-top:20px; padding-left:30px; padding-right:5px;'>";
       echo " <img   title='Com Prioridade' src='imagens/imagem_com_prioridade.jpg' border='0'>";
echo " </div>";



echo " <div onclick='return ConfirmaPrioridade_nao({$idt_atendimento_avulso});' style='color:#004080; font-size:14px; cursor:pointer; float:left; padding-top:20px; padding-left:30px; padding-right:5px;'>";
       echo " <img   title='Não tem Prioridade' src='imagens/imagem_sem_prioridade.jpg' border='0'>";
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


function ConfirmaPrioridadexxxxx(idt_atendimento_avulso)
{
   //alert(' Confirma Prioridade = '+idt_atendimento_avulso);
   
   
   var id='tipo_pessoa';
   obj = document.getElementById(id);
   if (obj != null) {
        var cpt = obj.value;
        if (cpt=='N' || cpt=='' )
        {
           obj.value = 'S';
           
        }
        else 
        {
           obj.value = 'N';
       }
    }
    var id='mensagem';
    objx = document.getElementById(id);
    if (objx != null) {
       if (obj.value== 'N' || obj.value== '' )
       {
           objx.value= objx.value+"\n"+' ESCOLHIDA OPÇÃO DE FILA SEM PRIORIDADE';
       }
       else
       {
          objx.value=objx.value+"\n"+' ESCOLHIDA OPÇÃO DE FILA COM PRIORIDADE';
       }
    }
    return false;
}

function ConfirmaPrioridade_sim(idt_atendimento_avulso)
{
   var id='tipo_pessoa';
   objtp = document.getElementById(id);
   if (objtp != null) {
       objtp.value = 'S';
    }
   ConfirmaPrioridade(idt_atendimento_avulso);

}
function ConfirmaPrioridade_nao(idt_atendimento_avulso)
{
   var id='tipo_pessoa';
   objtp = document.getElementById(id);
   if (objtp != null) {
       objtp.value = 'N';
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