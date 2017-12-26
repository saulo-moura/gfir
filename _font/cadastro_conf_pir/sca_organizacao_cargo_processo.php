<?php
$tabela = 'sca_organizacao_cargo_processo';
$id = 'idt';
$vetCampo['idt_cargo'] = objFixoBanco('idt_cargo', 'Cargo', 'sca_organizacao_cargo', 'idt', 'descricao', 2);
//
$sql = 'select idt , codigo, descricao from sca_estrutura order by classificacao';
$vetCampo['idt_processo'] = objCmbBanco('idt_processo', 'Processo do Negócio', false, $sql);
//
$sql = 'select idt, codigo, descricao from sca_sistema order by descricao';
$vetCampo['idt_sistema'] = objCmbBanco('idt_sistema', 'Sistema (Computacional)', false, $sql);
//
$vetCampo['classificacao']   = objTexto('classificacao', 'Código Atividade<br />(Negócio)', false, 35, 120);
$vetCampo['processo']        = objTexto('processo', 'Atividade<br />(Negócio)', false, 35, 120);




$sql = 'select id_funcao, cod_classificacao, nm_funcao from funcao order by cod_classificacao';

 $linhafixa = ' ';
 $style = '';
 $js = " onchange='return ModificaPrograma();' ";

$vetCampo['idt_funcao'] = objCmbBanco('idt_funcao', 'Programa do Sistema (Computacional)', false, $sql, $linhafixa, $style, $js);


//
$vetFrm = Array();
$vetFrm[] = Frame(' ', Array(
    Array($vetCampo['idt_cargo'] ),
    Array($vetCampo['idt_processo'] ),

));
$vetFrm[] = Frame(' ', Array(
    Array($vetCampo['classificacao'] ),
    Array($vetCampo['processo'] ),
    Array($vetCampo['idt_sistema'] ),
    Array($vetCampo['idt_funcao'] ),
));
$vetCad[] = $vetFrm;
?>

<script>
function ModificaPrograma()
{
   //  alert(' teste ---- ');
   var id = 'idt_funcao';
   objd=document.getElementById(id);
   if (objd != null)
   {
        idt_funcao = objd.value;
        alert(' teste ---- '+ idt_funcao);
        var str = '';
        $.post('ajax2.php?tipo=ModificaProgramaObjeto',{
                async: false,
    	        idt_funcao : idt_funcao
            }
            , function(str) {
                if (str == '') {
                    // alert('Final da Geração dos Processos de Perfil. Sucesso...');

                } else {
                    alert(str+'\n\n'+'Erro na Associação dos Objetos. Não obteve Sucesso...');
               }
            });
   }

   
   
   
   
   
   
   
   
   
   return false;
}
</script>