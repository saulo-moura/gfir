<style>

.pesquisa_bia {

    font-size:14px;
    height:24px;

}

</style>
<?php
echo " <div  style='text-align:center; background:#004080; color:#FFFFFF; font-size:12px; width:100%; display:block; height:25px; float:left;'>";
       echo " BIA - Base de Informações para Atendimento";
echo " </div>";

echo " <div  style='color:#004080; margin-top:4px; margin-right:4px; font-size:12px; float:left;'>";
       echo " Texto para pesquisar: ";
echo " </div>";


echo " <div  style='color:#004080; margin-top:4px;  float:left;'>";
       echo " <input id='texto_pesq_bia' type='text' size='50' name='pesq_bia' class='pesquisa_bia' value='' /> ";
echo " </div>";

echo " <div  style='color:#004080; margin-top:4px;  float:left;'>";
       echo " <img onclick='return ConfirmaPrioridade_sim({$idt_atendimento});'  style='cursor:pointer; padding-top=5px;' title='Clique para Pesquisar text existente na BIA' src='imagens/botao_pesquisar_n.png' border='0'>";
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



function ConfirmaPrioridade_sim(idt_atendimento)
{
    alert('to vivo');
    /*
   var id='tipo_pessoa';
   objtp = document.getElementById(id);
   if (objtp != null) {
       objtp.value = 'S';
    }
*/
}

</script>