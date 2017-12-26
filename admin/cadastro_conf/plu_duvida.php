<?php
$tabela = 'plu_duvida';
$id = 'idt';
$vetCampo['pergunta'] = objTextArea('pergunta', 'Pergunta', false, 800,'height: 60px;width: 650px;');
$vetCampo['resposta'] = objTextArea('resposta', 'Resposta', false, 800,'height: 180px;width: 650px;');


$vetOrig=Array();
$vetOrig['GE']='Geral';
$vetOrig['AT']='Atendimento';
$vetCampo['origem'] = objCmbVetor('origem', 'Origem', True, $vetOrig);
$vetCampo['data_registro']    = objDatahora('data_registro', 'Data de Registro', False);
$sql  = "select id_usuario, nome_completo from plu_usuario ";
$sql .= " order by nome_completo";
$vetCampo['idt_responsavel']  = objCmbBanco('idt_responsavel', 'Responsável', false, $sql,' ','width:400px;');



$vetFrm = Array();

$vetFrm[] = Frame('', Array(
    Array($vetCampo['origem'],'',$vetCampo['data_registro'],'',$vetCampo['idt_responsavel']),
));
$vetFrm[] = Frame('', Array(
    Array($vetCampo['pergunta']),
    Array($vetCampo['resposta']),
));
$vetCad[] = $vetFrm;
?>

<script>
$(document).ready(function () {
   Amarela('data_registro','Datahora');
   Amarela('idt_responsavel','CmbBanco');


});

function Amarela(ele,tipo)
{
   objd=document.getElementById(ele);
   if (objd != null)
   {
       if (tipo=='Datahora' || tipo=='Texto')
       { 
           $(objd).css('background','#FFFF80');
           $(objd).attr('readonly','true');
       } 
       if (tipo=='CmbBanco' )
       { 
           $(objd).css('background','#FFFF80');
           $(objd).attr('disabled','disabled');
       } 

   }


}


</script>