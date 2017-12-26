<?php
$tabela = 'sca_organizacao_cargo_perfil';
$id = 'idt';
$vetCampo['idt_cargo'] = objFixoBanco('idt_cargo', 'Cargo', 'sca_organizacao_cargo', 'idt', 'descricao', 2);
//
$sql = 'select id_perfil , classificacao, nm_perfil from perfil order by classificacao';

 $linhafixa = ' ';
 $style = '';
 $js = " onchange='return ModificaPerfil();' ";

$vetCampo['idt_perfil'] = objCmbBanco('idt_perfil', 'Perfil  (Computacional)', false, $sql, $linhafixa, $style, $js);

// direitos é aqui....

$veio2 = 1;
$_SESSION[CS]['g_idt_perfil'] = 1;

$vetCampo['direito'] = objInclude('direito', 'perfil_direito.php');

//
$vetFrm = Array();
$vetFrm[] = Frame(' ', Array(
    Array($vetCampo['idt_cargo'] ),
    Array($vetCampo['idt_perfil'] ),

));
$vetFrm[] = Frame(' Direitos ', Array(
    Array($vetCampo['direito'] ),
));
//
$vetCad[] = $vetFrm;
?>

<script>
function ModificaPerfil()
{
   //  alert(' teste ---- ');
   var id = 'idt_perfil';
   objd=document.getElementById(id);
   if (objd != null)
   {
        idt_perfil = objd.value;
        alert(' teste ---- '+ idt_perfil);
        var str = '';
        $.post('ajax2.php?tipo=ModificaPerfil',{
                async: false,
    	        idt_perfil : idt_perfil
            }
            , function(str) {
                if (str == '') {
                    // alert('Final da Geração do Perfil. Sucesso...');

                } else {
                    alert(str+'\n\n'+'Erro na Associação do Perfil. Não obteve Sucesso...');
               }
            });
   }

   
   
   
   
   
   
   
   
   
   return false;
}
</script>