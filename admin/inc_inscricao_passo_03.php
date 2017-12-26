<style>


div#credenciamento {
    background:#FFFFFF;
    color:#000000;
    font-size: 20px;
    font-weight: bold;
    width:100%;
}

tr.instrucoes_insc {
    xdisplay: block;
    font-size: 12px;
    background:#14ADCC;
    color:#FFFFFF;
}

table.itemsepara {
    border-bottom:1px solid #FFFFFF;
}


table.cabpasso {
    border-bottom:1px solid #FFFFFF;
}
tr.cab_insc {
    font-size: 18px;
    background:#2F66B8;
    color:#FFFFFF;
}

</style>



<?php
echo "<div id='credenciamento' >";
////////////////////// mostrar editais abertos
 $vetEdital = Array();
 $vetEdital = CarregaEditaisAbertos();
 
 
echo "<table class='cabpasso' width='100%' border='0' cellspacing='1' cellpadding='5' vspace='0' hspace='0'> ";
echo "<tr class='cab_insc' style=''>  ";
echo "   <td style='text-align:center; font-size:18px; border-bottom:1px solid #FFFFFF;'>";
echo " INSCRIÇÃO :: PASSO 3 - AUTENTICAÇÃO DE LOGIN (USUÁRIO E SENHA) ";
echo "</td>";
echo "</tr>";
echo "</table>";

echo "<br />";

 
 
 
 
 
 
echo "<table class='itemsepara' width='100%' border='0' cellspacing='1' cellpadding='5' vspace='0' hspace='0'> ";
echo "<tr class='instrucoes_insc' style=''>  ";
echo "   <td style='width:30px; border-bottom:1px solid #FFFFFF;'>";
$onclick=" onclick='return MostraInstrucao(this); ' ";
$imagem = "<img $onclick style='cursor:pointer;' id='instrucao_img' src='imagens/seta_baixo.png' title='Mostra Objeto do Edital'  border='0'>";
echo "  $imagem ";
echo "</td>";
echo "   <td style='border-bottom:1px solid #FFFFFF;'>";
echo " 1 - INSTRUÇÕES ";
echo "</td>";
echo "</tr>";
echo "</table>";

$texto_explicativo = " Caro Candidato <br /><br /> Vc aqui TERÁ QUE SE AUTENTICAR USUÁRIO E SENHA";

echo "<table class='' width='100%' border='0' cellspacing='0' cellpadding='0' vspace='0' hspace='0'> ";
echo "<tr id='instrucao' style=''>  ";
  $bgcolor="#ECF0F1";
  $color  ="#000000";
  echo "   <td style='font-weight: bold; font-size:12px; background:{$bgcolor}; color:{$color};'>$texto_explicativo</td> ";
echo "</tr>";
echo "</table>";



//echo "<br />";



echo "<table class='itemsepara' width='100%' border='0' cellspacing='1' cellpadding='5' vspace='0' hspace='0'> ";
echo "<tr class='instrucoes_insc' style=''>  ";
echo "   <td style='width:30px; border-bottom:1px solid #FFFFFF;'>";
$onclick=" onclick='return MostraEditais(this); ' ";
$imagem = "<img $onclick style='cursor:pointer;' id='edital_img' src='imagens/seta_baixo.png' title='Mostra Objeto do Edital'  border='0'>";
echo "  $imagem ";
echo "</td>";
echo "   <td style='border-bottom:1px solid #FFFFFF;'>";
echo " 2 - EDITAL ESCOLHIDO PARA INSCRIÇÃO ";
echo "</td>";
echo "</tr>";
echo "</table>";

 $idt_etapa_escolhido = $_GET['idt_etapa'];
 
echo "<table id='edital' class='' width='100%' border='0' cellspacing='1' cellpadding='5' vspace='0' hspace='0'> ";
echo "<tr class='' style='border:0;'>  ";
  $bgcolor="#C4C9CD";
  $color  ="#FFFFFF";

  echo "   <td style='font-weight: bold; font-size:12px; background:{$bgcolor}; color:{$color};'>&nbsp;</td> ";
  echo "   <td style='font-weight: bold; font-size:12px; background:{$bgcolor}; color:{$color};'>NÚMERO<br />EDITAL</td> ";
  echo "   <td style='font-weight: bold; font-size:12px; background:{$bgcolor}; color:{$color};'>RESUMO<br />EDITAL</td> ";
  echo "   <td style='font-weight: bold; font-size:12px; background:{$bgcolor}; color:{$color};'>TIPO<br />EDITAL</td> ";
  echo "   <td style='font-weight: bold; font-size:12px; background:{$bgcolor}; color:{$color};'>NÚMERO<br />PROCESSO</td> ";
  echo "   <td style='width:150px; font-weight: bold; font-size:12px; background:{$bgcolor}; color:{$color}; text-align:center;'>TÍTULO<br />PROCESSO</td> ";
  echo "   <td style='font-weight: bold; font-size:12px; background:{$bgcolor}; color:{$color}; text-align:center;'>DATA INICIO<br />INSCRIÇÃO</td> ";
  echo "   <td style='font-weight: bold; font-size:12px; background:{$bgcolor}; color:{$color}; text-align:center;'>DATA TÉRMINO<br />INSCRIÇÃO</td> ";
echo "</tr>";
 //p($idt_etapa_escolhido);
 //p($vetEdital);

 ForEach ($vetEdital as $idt_edital => $VetProcesso)
 {
     ForEach ($VetProcesso as $idt_processo => $VetEtapa)
     {
         ForEach ($VetEtapa as $idt_etapa => $VetDados)
         {

                if ($idt_etapa_escolhido != $idt_etapa)
                {
                    continue;
                }
                
                $codigo_edital      = $VetDados['edital']['cod'];
                $descricao_edital   = $VetDados['edital']['des'];
                $descricao_objeto   = $VetDados['edital']['obj'];
                $edital_tipo        = $VetDados['edital']['tip'];
                $pessoa_jf          = $VetDados['edital']['pjf'];

                $numero_processo    = $VetDados['processo']['num'];
                $titulo_processo    = $VetDados['processo']['des'];

                $etapa_data_inicio  = $VetDados['etapa']['din'];
                $etapa_data_termino = $VetDados['etapa']['dte'];

                echo "<tr class='edital_$idt_etapa' style='border:0;'>  ";
                  $bgcolor="#FFFFFF";
                  $color  ="#000000";
                  $onclick=" onclick='return MostraObjeto(this,$idt_etapa); ' ";
//                  $onclick_escolhido=" onclick='return EditalEscolhido(this,$idt_etapa); ' ";

                  $onclick_escolhido="";


                  $bgcolor_escolhe = '#FFFFFF';
                  $color_escolhe   = '#000000';

                  $imagem = "<img id='objeto_img_$idt_etapa' src='imagens/seta_baixo.png' title='Mostra Objeto do Edital'  border='0'>";
                  
                  echo "   <td {$onclick}  style='cursor:pointer; font-weight: bold; font-size:12px; background:{$bgcolor}; color:{$color};'>$imagem</td> ";

                  echo "   <td {$onclick_escolhido} title='Clique aqui para escolher o Edital desejado.' style='cursor:pointer;  font-weight: bold; font-size:14px; background:{$bgcolor_escolhe}; color:{$color_escolhe};'>$codigo_edital</td> ";
                  
                  
                  echo "   <td style='font-weight: bold; font-size:11px; background:{$bgcolor}; color:{$color};'>$descricao_edital</td> ";
                  echo "   <td style='font-weight: bold; font-size:11px; background:{$bgcolor}; color:{$color};'>$edital_tipo</td> ";

                  
                  echo "   <td style='font-weight: bold; font-size:11px; background:{$bgcolor}; color:{$color};'>$numero_processo</td> ";
                  echo "   <td style='width:150px; font-weight: bold; font-size:11px; background:{$bgcolor}; color:{$color}; text-align:center;'>$titulo_processo</td> ";
                  echo "   <td style='font-weight: bold; font-size:11px; background:{$bgcolor}; color:{$color}; text-align:center;'>$etapa_data_inicio</td> ";
                  echo "   <td style='font-weight: bold; font-size:11px; background:{$bgcolor}; color:{$color}; text-align:center;'>$etapa_data_termino</td> ";
                echo "</tr>";
                
                echo "<tr id='objeto_$idt_etapa' style='display:none;'>  ";
                  $bgcolor="#C0C0C0";
                  $color  ="#000000";
                  echo "   <td colspan='8' style='font-weight: bold; font-size:12px; background:{$bgcolor}; color:{$color};'>&nbsp;$descricao_objeto</td> ";
                echo "</tr>";



         }
     }
 }
 
echo "<tr class='' style='border:0;'>  ";
$bgcolor="#A1ADB3";
$color  ="#FFFFFF";
echo "   <td colspan='8' style='font-weight: bold; font-size:12px; background:{$bgcolor}; color:{$color};'>&nbsp;</td> ";
echo "</tr>";

echo "</table> ";







//////////////////// edital escolhido


echo "<table id='edital_escolhido' style='xdisplay:none;' class='itemsepara' width='100%' border='0' cellspacing='1' cellpadding='5' vspace='0' hspace='0'> ";
echo "<tr class='instrucoes_insc' style=''>  ";
echo "   <td style='width:30px; border-bottom:1px solid #FFFFFF;'>";
$onclick=" onclick='return DesistedoEditalEscolhido(this); ' ";
$imagem = "<img $onclick style='cursor:pointer;' id='edital_e_img' src='imagens/bt_apagar.gif' title='Desiste do Edital Escolhido'  border='0'>";
echo "  $imagem ";
echo "</td>";

echo "   <td style='xborder:1px solid #FFFFFF;'>";
echo " 3 - AUTENTICAÇÃO";
echo "</td>";
echo "</tr>";
echo "</table>";


echo "<table id='edital_escolhido_2' style='xdisplay:none;' class='itemsepara' width='100%' border='0' cellspacing='1' cellpadding='5' vspace='0' hspace='0'> ";



echo "<tr class='' style=''>  ";
$bgcolor="#FFFFFF";
$color  ="#000000";
$termo="Erro de pessoa ";
if ($pessoa_jf=='01')
{   // pessoa Jurídica
    $termo  ="";
    $termo .=" EDITAL APENAS PARA PESSOA JURÍDICA<BR />Por favor, informe o seu CNPJ:";
    echo "   <td colspan='2' id='texto_edital_termo'  style='border-bottom:1px solid #000000; padding-left:20px; width:70%; font-weight: bold; font-size:16px; background:{$bgcolor}; color:{$color};'>{$termo}&nbsp;</td> ";


}
else
{
    if ($pessoa_jf=='02')
    {   // pessoa física
        $termo  ="";
        $termo .=" EDITAL APENAS PARA PESSOA FÍSICA<BR />Por favor, informe o seu CPF:";
        echo "   <td colspan='2' id='texto_edital_termo'  style='border-bottom:1px solid #000000; padding-left:20px; width:70%; font-weight: bold; font-size:16px; background:{$bgcolor}; color:{$color};'>{$termo}&nbsp;</td> ";
    }
    else
    {
        if ($pessoa_jf=='03')
        {   // pessoa física e jurídica
            $termo  ="";
            $termo .=" EDITAL APENAS PARA PESSOA FÍSICA E JURÍDICA<BR />Por favor, informe: FISICA OU JURÍDICA?";
            echo "   <td colspan='2' id='texto_edital_termo'  style='border-bottom:1px solid #000000; padding-left:20px; width:70%; font-weight: bold; font-size:16px; background:{$bgcolor}; color:{$color};'>{$termo}&nbsp;</td> ";
        }
        else
        {
            $termo  ="";
            $termo .=" EDITAL PARA QUALQUER PESSOA MESMO SEM CNPJ OU CPF??????";
             echo "   <td colspan='2' id='texto_edital_termo'  style='border-bottom:1px solid #000000; padding-left:20px; width:70%; font-weight: bold; font-size:16px; background:{$bgcolor}; color:{$color};'>{$termo}&nbsp;</td> ";


        }


    }

}







//$onclick=" onclick='return ProximoPassoAutenticacao(this,$idt_etapa); ' ";
//$imagem = "<img $onclick style='cursor:pointer;' id='edital_img' src='imagens/seta_proximo.png' title='Clique aqui para prosseguir com a Inscrição nesse Edital'  border='0'>";




//$imagem = "<img $onclick style='cursor:pointer;' id='edital_img' src='imagens/proximo_2.png' title='Clique aqui para prosseguir com a Inscrição nesse Edital'  border='0'>";

//echo "   <td id='texto_edital_escolhido_bt'  style='display:none; border-bottom:1px solid #000000;  width:28%; font-weight: bold; font-size:12px; background:{$bgcolor}; color:{$color};'>&nbsp;$imagem</td> ";

echo "</tr>";




echo "<tr class='' style=''>  ";
$bgcolor="#FFFFFF";
$color  ="#000000";



$onclick_escolhido=" onclick='return AceitedoTermo($idt_etapa); ' ";

$imagem = "<img $onclick_escolhido style='cursor:pointer;' id='edital_img' src='imagens/aceito_termo.png' title='Clique aqui para prosseguir com a Inscrição nesse Edital'  border='0'>";

echo "   <td colspan='2' id='texto_edital_termo_bt'  style='border-bottom:1px solid #000000;  width:28%; font-weight: bold; font-size:12px; background:{$bgcolor}; color:{$color};'>&nbsp;$imagem</td> ";

echo "</tr>";








echo "<tr class='' style=''>  ";
$bgcolor="#FFFFFF";
$color  ="#ff0000";
echo "   <td id='texto_edital_escolhido'  style='border-bottom:1px solid #000000; padding-left:20px; width:70%; font-weight: bold; font-size:16px; background:{$bgcolor}; color:{$color};'>ATENCÃO!!!<br />SEM ACEITE NO TERMO.&nbsp;</td> ";

$onclick=" onclick='return ProximoPassoAutenticacao(this,$idt_etapa); ' ";
//$imagem = "<img $onclick style='cursor:pointer;' id='edital_img' src='imagens/seta_proximo.png' title='Clique aqui para prosseguir com a Inscrição nesse Edital'  border='0'>";


$imagem = "<img $onclick style='cursor:pointer;' id='edital_img' src='imagens/proximo_3.png' title='Clique aqui para prosseguir com a Inscrição nesse Edital'  border='0'>";

echo "   <td id='texto_edital_escolhido_bt'  style='display:none; border-bottom:1px solid #000000;  width:28%; font-weight: bold; font-size:12px; background:{$bgcolor}; color:{$color};'>&nbsp;$imagem</td> ";

echo "</tr>";

echo "</table>";







echo "</div>";


?>

<script type="text/javascript">

function MostraInstrucao(thisw)
{
    var id ='#instrucao';
    $(id).toggle();
    id ='#instrucao_img';
    var img = $(id);
    if (img.attr('src') == 'imagens/seta_baixo.png') {
        img.attr('src', 'imagens/seta_cima.png');
    } else {
        img.attr('src', 'imagens/seta_baixo.png');
    }
    TelaHeight();
    return false;
}



function MostraEditais(thisw)
{
    var id ='#edital';
    $(id).toggle();
    id ='#edital_img';
    var img = $(id);
    if (img.attr('src') == 'imagens/seta_baixo.png') {
        img.attr('src', 'imagens/seta_cima.png');
    } else {
        img.attr('src', 'imagens/seta_baixo.png');
    }
    TelaHeight();
    return false;
}



function MostraObjeto(thisw,idt_etapa)
{
    var id ='#objeto_'+idt_etapa;
    $(id).toggle();
    id ='#objeto_img_'+idt_etapa;
    var img = $(id);
    if (img.attr('src') == 'imagens/seta_baixo.png') {
        img.attr('src', 'imagens/seta_cima.png');
    } else {
        img.attr('src', 'imagens/seta_baixo.png');
    }

    
    TelaHeight();
    return false;
}

function EditalEscolhido(thisw,idt_etapa)
{
    //alert(' escolhido = '+idt_etapa);
//    var id ='#edital_escolhido';
//    $(id).show();
//    var id ='#edital_escolhido_2';
//    $(id).show();

    var id ='#texto_edital_escolhido_bt';
    $(id).show();


    var numero_edital = thisw.innerHTML;
    var msg_edital    = 'ATENCÃO!!!<br />Escolhido o Edital número <span style="font-size:20px; background:#FFFFFF; color:#0000FF;">'+thisw.innerHTML+'</span> para Inscrição.';
    //alert(' escolhido numero = '+numero_edital);
    var id ='texto_edital_escolhido';
    objd = document.getElementById(id);
    objd.innerHTML=msg_edital;
    TelaHeight();
    return false;
}

function DesistedoEditalEscolhido(thisw)
{
//    var id ='#edital_escolhido';
//    $(id).hide();
//    var id ='#edital_escolhido_2';
//    $(id).hide();
    var msg_edital    = 'ATENCÃO!!!<br />SEM ACEITE NO TERMO.';
    //alert(' escolhido numero = '+numero_edital);
    var id ='texto_edital_escolhido';
    objd = document.getElementById(id);
    objd.innerHTML=msg_edital;
    texto_edital_escolhido_bt
    var id ='#texto_edital_escolhido_bt';
    $(id).hide();

}


function ProximoPassoAutenticacao(thisw,idt_etapa)
{
    self.location='conteudo.php?prefixo=inc&menu=gec_inscricao_passo_03&idt_etapa='+idt_etapa+'&origem_tela=painel&elemento=0&voltar=aHR0cDovL2x1cGUuZW5naW5mby5jb20uYnIvc2VicmFlX2dlYy9hZG1pbi9jb250ZXVkby5waHA/cHJlZml4bz1pbmMmbWVudT1nZWNfaW5zY3JpY2FvX2NyZWRlbmNpYWRvJm9yaWdlbV90ZWxhPXBhaW5lbCZlbGVtZW50bz0wJnZvbHRhcj1hSFIwY0RvdkwyeDFjR1V1Wlc1bmFXNW1ieTVqYjIwdVluSXZjMlZpY21GbFgyZGxZeTloWkcxcGJpOWpiMjUwWlhWa2J5NXdhSEEvY0hKbFptbDRiejFwYm1NbWJXVnVkVDFuWldOZlkzSmxaR1Z1WTJsaGJXVnVkRzhtYjNKcFoyVnRYM1JsYkdFOWNHRnBibVZzSm1Wc1pXMWxiblJ2UFRBbWRtOXNkR0Z5UFdGSVVqQmpSRzkyVERKNE1XTkhWWFZhVnpWdVlWYzFiV0o1TldwaU1qQjFXVzVKZG1NeVZtbGpiVVpzV0RKa2JGbDVPV2hhUnpGd1ltazRQUT09';
    TelaHeight();
    return false;
}


function AceitedoTermo(idt_etapa)
{
    alert(' Aceiou o termo = '+idt_etapa);

   // var id ='#texto_edital_escolhido_bt';
   // $(id).show();


     var id ='#texto_edital_escolhido_bt';
    $(id).show();


  //  var numero_edital = thisw.innerHTML;
  //  var msg_edital    = 'ATENCÃO!!!<br />Escolhido o Edital número <span style="font-size:20px; background:#FFFFFF; color:#0000FF;">'+thisw.innerHTML+'</span> para Inscrição.';
  
  
    var msg_aceite  = 'OBRIGADO!!!<br />Termo de Aceite Lido e Aceito pelo Candidato.';
    var id ='texto_edital_escolhido';
    objd = document.getElementById(id);
    objd.innerHTML=msg_aceite;
    TelaHeight();
    return false;
}

</script>