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


.BtIdentificacao_candidato {
    cursor: pointer;
    width: 155px;
    height: 25px;
    border:1px solid #C0C0C0;

}

</style>



<?php
echo "<div id='credenciamento' >";
////////////////////// mostrar editais abertos
 $vetEdital = Array();
 $vetEdital = CarregaEditaisAbertos();

 $vetGEC_parametros=Array();

 $vetGEC_parametros=GEC_parametros();


 
 $candidato_ativo = $_SESSION[CS]['g_nome_candidato'];

echo "<table class='cabpasso' width='100%' border='0' cellspacing='1' cellpadding='5' vspace='0' hspace='0'> ";
echo "<tr class='cab_insc' style=''>  ";
echo "   <td style='text-align:center; font-size:18px; border-bottom:1px solid #FFFFFF;'>";
echo " {$candidato_ativo}<br />PASSO 1 - ESCOLHA DO EDITAL";
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

$texto_explicativo = " Caro Candidato <br /><br /> Por faor verifique em qual edital vc deseja se inscrever ";


$texto_explicativo = $vetGEC_parametros['INSCRICAO_P01'];


echo "<table class='' width='100%' border='0' cellspacing='0' cellpadding='0' vspace='0' hspace='0'> ";
echo "<tr id='instrucao' style=''>  ";
  $bgcolor="#ECF0F1";
  $color  ="#000000";
  echo "   <td style='font-weight: bold; font-size:12px; background:{$bgcolor}; color:{$color};'>$texto_explicativo</td> ";
echo "</tr>";
echo "</table>";



echo "<table id='campos_obrigatorios' style='xdisplay:none;' class='itemsepara' width='100%' border='0' cellspacing='1' cellpadding='5' vspace='0' hspace='0'> ";
echo "<tr class='table_contato_linha'> ";
$msgrodapeobrigatoriow='( * ) campo obrigatório';
echo "   <td class='table_contato_celula_msgrodape' >{$msgrodapeobrigatoriow}</td> ";
echo "</tr>";
echo "</table>";
//echo "<br />";


  $imagem_aguarde = "<img width='16' height='16' style='cursor:pointer;' id='' src='imagens/carregando.gif' title=''  border='0'>";

  $aguarde="<div  id='msg_p'  style='display:none; color:#666666; '>{$imagem_aguarde}&nbsp;&nbsp;Aguarde...</div>";


  
echo "<table class='itemsepara' width='100%' border='0' cellspacing='1' cellpadding='5' vspace='0' hspace='0'> ";
echo "<tr class='instrucoes_insc' style=''>  ";
echo "   <td style='width:30px; border-bottom:1px solid #FFFFFF;'>";
$onclick=" onclick='return MostraInstrucao(this); ' ";
$imagem = "<img $onclick style='cursor:pointer;' id='instrucao_img' src='imagens/seta_baixo.png' title='Mostra Objeto do Edital'  border='0'>";


$onclick ="";
$imagem  = "";
echo "  $imagem ";
echo "</td>";
echo "   <td style='border-bottom:1px solid #FFFFFF;'>";
echo " 2 - IDENTIFICAÇÃO DO CANDIDATO";
echo "</td>";
echo "</tr>";
echo "</table>";





//echo "<table class='' width='100%' border='0' cellspacing='0' cellpadding='0' vspace='0' hspace='0'> ";
//echo "<tr id='instrucao' style=''>  ";
  $bgcolor="#ECF0F1";
  $color  ="#000000";
  

if ($_SESSION[CS]['g_identificacao']!="")
{
     $identificacao   = $_SESSION[CS]['g_identificacao'];
     $cnpjcpf         = $_SESSION[CS]['g_cnpjcpf'];
     $nome_candidato  = $_SESSION[CS]['g_nome_candidato'];
     $email_candidato = $_SESSION[CS]['g_email_candidato'];
     
     $texto1 = "CNPJ:";
     $texto2 = "Razão Social:";
     if ($cnpjcpf=='CPF')
     {
         $texto1 = "CPF:";
         $texto2 = "Nome:";
     }
}
else
{
     $identificacao   = "";
     $cnpjcpf         = "";
     $nome_candidato  = "";
     $email_candidato = "";
     $texto1 = "CNPJ ou CPF:";
     $texto2 = "Nome ou Razão Social:";

}
  
echo "<table id='edital_login_candidato' style='xdisplay:none;' class='LoginCandidato' width='100%' border='0' cellspacing='1' cellpadding='5' vspace='0' hspace='0'> ";
echo "<tr class='' style=''>  ";
echo "   <td id='texto_usuario'  style='text-align:right; width:20%; font-weight: bold; font-size:16px; background:{$bgcolor}; color:{$color};'>";
echo "         $texto1 <span>*</span> ";
echo "   </td>";
echo "   <td xcolspan='2' id='input_usuario'  style='text-align:left;  width:25%; font-weight: bold; font-size:16px; background:{$bgcolor}; color:{$color};'>";
echo "         <input id='identifica_cnpjcpf' class='Texto' type='text' value='{$identificacao}' name='CNPJCPJ' onkeyup='Enter(event)'> ";
echo "   </td>";

echo "   <td id='img_usuario'  style='text-align:left; width:55%; font-weight: bold; font-size:16px; background:{$bgcolor}; color:{$color};'>";

  $msg_p='msg_confirma1';
  $aguardew = str_replace('msg_p',$msg_p,$aguarde);

echo "   &nbsp;<img id='img_usuario_i' title='Confirmar Identificação, CNPJ ou CPF' class='BtIdentificacao_candidato' onclick='return IdentificaCandidato(0);' src='imagens/confirmar_identificacao.png' border='0'>{$aguardew} ";

  $msg_p='msg_limpa1';
  $aguardew = str_replace('msg_p',$msg_p,$aguarde);

echo "   &nbsp;&nbsp;<img id='img_usuario_api' title='Limpar dados de Identificação' class='BtIdentificacao_candidato' onclick='return IdentificaCandidatoLimpa(0);' src='imagens/apagar_identificacao_v.png' border='0'>{$aguardew} ";
echo "   </td>";



echo "</tr>";

echo "<tr id='CandidatoCadastrado_0' class='CandidatoCadastrado' style='display:none;'>  ";
echo "   <td id='texto_senha'  style='text-align:right; width:20%; font-weight: bold; font-size:16px; background:{$bgcolor}; color:{$color};'>";
echo "   $texto2<span>*</span> ";
echo "   </td>";
echo "   <td colspan='2' id='input_identificacao'  style='text-align:left; width:80%; font-weight: bold; font-size:16px; background:{$bgcolor}; color:{$color};'>";
echo "         <input id='input_identificacao_t' style='width:370px;' class='Texto' type='text' value='{$nome_candidato}' name='senha' onkeyup='Enter(event)'> ";
echo "   </td>";
echo "</tr>";


echo "<tr id='CandidatoCadastrado_1' class='CandidatoCadastrado' style='display:none;'>  ";
echo "   <td id='texto_email'  style='text-align:right; width:20%; font-weight: bold; font-size:16px; background:{$bgcolor}; color:{$color};'>";
echo "   Email:<span>*</span> ";
echo "   </td>";
echo "   <td xcolspan='2' id='input_email'  style='text-align:left; width:50%; font-weight: bold; font-size:16px; background:{$bgcolor}; color:{$color};'>";
echo "         <input id='input_email_t' style='width:270px;' class='Texto' type='text' value='{$email_candidato}' name='senha' onkeyup='Enter(event)'> ";
echo "   </td>";

echo "   <td id='img_usuario_1'  style='text-align:left; width:30%; font-weight: bold; font-size:16px; background:{$bgcolor}; color:{$color};'>";

  $msg_p='msg_confirma2';
  $aguardew = str_replace('msg_p',$msg_p,$aguarde);


echo "     &nbsp;&nbsp;&nbsp;<img id='img_usuario_1I' title='Confirmar Identificação, CNPJ ou CPF' class='BtIdentificacao_candidato' onclick='return IdentificaCandidato(1);' src='imagens/confirmar_identificacao.png' border='0'>{$aguardew} ";
echo "   </td>";



echo "</tr>";


$CandidatoCadastrado_msg="";
//echo "</tr>";
echo "<tr id='CandidatoCadastrado_msg' class='CandidatoCadastrado_msg' style='display:none;'>  ";
echo "   <td colspan='3' id='input_CandidatoCadastrado_msg'  style='text-align:left; padding:20px; width:100%; font-weight: normal; font-size:12px; background:{$bgcolor}; color:{$color};'>";
//echo "         <input id='input_CandidatoCadastrado_msg' style='width:100%;' border:0; class='Texto' type='text' value='{$CandidatoCadastrado_msg}' name='CandidatoCadastrado_msg' onkeyup='Enter(event)'> ";

echo " Por favor, informe os dados de identificação, e confirme para prosseguir.";
echo "   </td>";
echo "</tr>";



echo "</table>";

//echo "<br />";


echo "<table id='parte_03_msg' style='display:none;' class='itemsepara' width='100%' border='0' cellspacing='1' cellpadding='5' vspace='0' hspace='0'> ";
echo "<tr id='parte_03_msg_msg' class='CandidatoCadastrado_msg' style='xdisplay:none;'>  ";
echo "   <td colspan='3' id='input_CandidatoCadastrado_msg_msg'  style='text-align:left; padding:20px; width:100%; font-weight: normal; font-size:12px; background:{$bgcolor}; color:{$color};'>";
echo " Para escolher o Edital/Processo clique no Número do Edital destacado em azul na lista abaixo..";
echo "   </td>";
echo "</tr>";
echo "</table>";


echo "<table id='parte_03' style='display:none;' class='itemsepara' width='100%' border='0' cellspacing='1' cellpadding='5' vspace='0' hspace='0'> ";
echo "<tr class='instrucoes_insc' style=''>  ";
echo "   <td style='width:30px; border-bottom:1px solid #FFFFFF;'>";
$onclick=" onclick='return MostraEditais(this); ' ";
$imagem = "<img $onclick style='cursor:pointer;' id='edital_img' src='imagens/seta_baixo.png' title='Mostra Objeto do Edital'  border='0'>";
echo "  $imagem ";
echo "</td>";
echo "   <td style='border-bottom:1px solid #FFFFFF;'>";
echo " 3 - EDITAIS ABERTOS PARA INSCRIÇÃO ";
echo "</td>";
echo "</tr>";
echo "</table>";


 
echo "<table id='edital' style='display:none;' class='' width='100%' border='0' cellspacing='1' cellpadding='5' vspace='0' hspace='0'> ";
echo "<tr class='' style='border:0;'>  ";
  $bgcolor="#C4C9CD";
  $color  ="#FFFFFF";

  echo "   <td style='width:30px; font-weight: bold; font-size:12px; background:{$bgcolor}; color:{$color};'>&nbsp;</td> ";
  echo "   <td style='width:100px; font-weight: bold; font-size:12px; background:{$bgcolor}; color:{$color};'>NÚMERO<br />EDITAL</td> ";
  echo "   <td style='font-weight: bold; font-size:12px; background:{$bgcolor}; color:{$color};'>RESUMO<br />EDITAL</td> ";
  echo "   <td style='font-weight: bold; font-size:12px; background:{$bgcolor}; color:{$color};'>TIPO<br />EDITAL</td> ";
  echo "   <td style='font-weight: bold; font-size:12px; background:{$bgcolor}; color:{$color};'>NÚMERO<br />PROCESSO</td> ";
  echo "   <td style='width:150px; font-weight: bold; font-size:12px; background:{$bgcolor}; color:{$color}; text-align:center;'>TÍTULO<br />PROCESSO</td> ";
  echo "   <td style='font-weight: bold; font-size:12px; background:{$bgcolor}; color:{$color}; text-align:center;'>DATA INICIO<br />INSCRIÇÃO</td> ";
  echo "   <td style='font-weight: bold; font-size:12px; background:{$bgcolor}; color:{$color}; text-align:center;'>DATA TÉRMINO<br />INSCRIÇÃO</td> ";
echo "</tr>";

 
 
$numero_processow    = '';
$numero_editalw      = '';
if ($_SESSION[CS]['g_idt_etapa']!= "")
{
    $idt_etapa_escolhido = $_SESSION[CS]['g_idt_etapa'];
}
else
{
    $idt_etapa_escolhido = 0;

}
 
 
 
 ForEach ($vetEdital as $idt_edital => $VetProcesso)
 {
     ForEach ($VetProcesso as $idt_processo => $VetEtapa)
     {
         ForEach ($VetEtapa as $idt_etapa => $VetDados)
         {
                $codigo_edital      = $VetDados['edital']['cod'];
                $descricao_edital   = $VetDados['edital']['des'];
                $descricao_objeto   = $VetDados['edital']['obj'];
                $edital_tipo        = $VetDados['edital']['tip'];
                
                $edital_pjf         = $VetDados['edital']['pjf'];
                


                $numero_processo    = $VetDados['processo']['num'];
                $titulo_processo    = $VetDados['processo']['des'];

                $etapa_data_inicio  = $VetDados['etapa']['din'];
                $etapa_data_termino = $VetDados['etapa']['dte'];
                
                
                if ($idt_etapa_escolhido == $idt_etapa)
                {
                    $numero_editalw      = $VetDados['edital']['cod'];
                    $descricao_editalw   = $VetDados['edital']['des'];
                    $numero_processow    = $VetDados['processo']['num'];
                    $titulo_processow    = $VetDados['processo']['des'];
                    $etapa_data_iniciow  = $VetDados['etapa']['din'];
                    $etapa_data_terminow = $VetDados['etapa']['dte'];

                }


                echo "<tr class='edital_$idt_etapa  $edital_pjf' style='border:0;'>  ";
                  $bgcolor="#FFFFFF";
                  $color  ="#000000";
                  $onclick=" onclick='return MostraObjeto(this,$idt_etapa); ' ";
                  $onclick_escolhido=" onclick='return EditalEscolhido(this,$idt_etapa); ' ";


                  $bgcolor_escolhe = '#2F66B8';
                  $color_escolhe   = '#FFFFFF';

                  $imagem = "<img id='objeto_img_$idt_etapa' src='imagens/seta_baixo.png' title='Mostra Objeto do Edital'  border='0'>";
                  
                  echo "   <td {$onclick}  style='width:30px; cursor:pointer; font-weight: bold; font-size:12px; background:{$bgcolor}; color:{$color};'>$imagem</td> ";

                  echo "   <td {$onclick_escolhido} title='Clique aqui para escolher o Edital desejado.' style='cursor:pointer;  font-weight: bold; font-size:14px; background:{$bgcolor_escolhe}; color:{$color_escolhe};'>$codigo_edital</td> ";
                  
                  
                  echo "   <td style='font-weight: bold; font-size:11px; background:{$bgcolor}; color:{$color};'>$descricao_edital</td> ";
                  echo "   <td style='font-weight: bold; font-size:11px; background:{$bgcolor}; color:{$color};'>$edital_tipo</td> ";

                  
                  echo "   <td id='numero_processo_{$idt_etapa}' style='font-weight: bold; font-size:11px; background:{$bgcolor}; color:{$color};'>$numero_processo</td> ";
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


echo "<table id='edital_escolhido' style='display:none;' class='itemsepara' width='100%' border='0' cellspacing='1' cellpadding='5' vspace='0' hspace='0'> ";
echo "<tr class='instrucoes_insc' style=''>  ";
echo "   <td style='width:30px; border-bottom:1px solid #FFFFFF;'>";
$onclick=" onclick='return DesistedoEditalEscolhido(this); ' ";
$imagem = "<img $onclick width='24' height='24' style='cursor:pointer;' id='edital_e_img' src='imagens/desfazer_32.png' title='Desiste do Edital Escolhido'  border='0'>";
echo "  $imagem ";
echo "</td>";

echo "   <td style='xborder:1px solid #FFFFFF;'>";
echo " 4 - EDITAL ESCOLHIDO PARA INSCRIÇÃO ";
echo "</td>";
echo "</tr>";
echo "</table>";


echo "<table id='edital_escolhido_2' style='display:none;' class='itemsepara' width='100%' border='0' cellspacing='1' cellpadding='5' vspace='0' hspace='0'> ";

echo "<tr class='' style=''>  ";
$bgcolor="#FFFFFF";
$color  ="#000000";
echo "   <td id='texto_edital_escolhido'  style='border-bottom:1px solid #000000; padding-left:20px; width:70%; font-weight: bold; font-size:16px; background:{$bgcolor}; color:{$color};'>ATENCÃO!!!<br />SEM EDITAL ESCOLHIDO.&nbsp;</td> ";

$onclick=" onclick='return ProximoPassoAutenticacao(this,$idt_etapa); ' ";
//$imagem = "<img $onclick style='cursor:pointer;' id='edital_img' src='imagens/seta_proximo.png' title='Clique aqui para prosseguir com a Inscrição nesse Edital'  border='0'>";


$imagem = "<img $onclick style='cursor:pointer;' id='edital_img' src='imagens/proximo_2.png' title='Clique aqui para prosseguir com a Inscrição nesse Edital'  border='0'>";

echo "   <td id='texto_edital_escolhido_bt'  style='display:none; border-bottom:1px solid #000000;  width:28%; font-weight: bold; font-size:12px; background:{$bgcolor}; color:{$color};'>&nbsp;$imagem</td> ";

echo "</tr>";

echo "</table>";







echo "</div>";


?>

<script type="text/javascript">




var idt_etapa_escolhido =  <?php echo $idt_etapa_escolhido;  ?>;
var numero_editalw      =  '<?php echo $numero_editalw;  ?>';
var numero_processow    =  '<?php echo $numero_processow;  ?>';

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


    var str = '';
    $.post('ajax2.php?tipo=EditalProcessoEtapa', {
        async: false,
        idt_etapa: idt_etapa
    }
    , function (str) {
        if (str == '') {
            var id ='#texto_edital_escolhido_bt';
            $(id).show();
            var numero_edital = thisw.innerHTML;

            var id ='numero_processo_'+idt_etapa;
            objd = document.getElementById(id);
            var numero_processo = "";
            if (objd!=null)
            {
                var numero_processo = objd.innerHTML;
            }
            
            var nomedpr = numero_edital +'-'+ numero_processo;
            
            var msg_edital    = 'ATENCÃO!!!<br />Escolhido o Edital número <span style="font-size:20px; background:#FFFFFF; color:#0000FF;">'+nomedpr+'</span> para Inscrição.';
            //alert(' escolhido numero = '+numero_edital);
            var id ='texto_edital_escolhido';
            objd = document.getElementById(id);
            objd.innerHTML=msg_edital;
            TelaHeight();
        } else {
            alert(url_decode(str).replace(/<br>/gi, "\n"));
        }
    });
/*
            var id ='#texto_edital_escolhido_bt';
            $(id).show();
            var numero_edital = thisw.innerHTML;
            var msg_edital    = 'ATENCÃO!!!<br />Escolhido o Edital número <span style="font-size:20px; background:#FFFFFF; color:#0000FF;">'+thisw.innerHTML+'</span> para Inscrição.';
            //alert(' escolhido numero = '+numero_edital);
            var id ='texto_edital_escolhido';
            objd = document.getElementById(id);
            objd.innerHTML=msg_edital;
            TelaHeight();
*/
    return false;
}

function DesistedoEditalEscolhido(thisw)
{
//    var id ='#edital_escolhido';
//    $(id).hide();
//    var id ='#edital_escolhido_2';
//    $(id).hide();

/*
    var msg_edital    = 'ATENCÃO!!!<br />SEM EDITAL ESCOLHIDO.';
    //alert(' escolhido numero = '+numero_edital);
    var id ='texto_edital_escolhido';
    objd = document.getElementById(id);
    objd.innerHTML=msg_edital;
    texto_edital_escolhido_bt
    var id ='#texto_edital_escolhido_bt';
    $(id).hide();
*/


    var str = '';
    $.post('ajax2.php?tipo=EditalProcessoEtapaLimpa', {
        async: false
    }
    , function (str) {
        if (str == '') {
            var msg_edital    = 'ATENCÃO!!!<br />SEM EDITAL ESCOLHIDO.';
            //alert(' escolhido numero = '+numero_edital);
            var id ='texto_edital_escolhido';
            objd = document.getElementById(id);
            objd.innerHTML=msg_edital;
            texto_edital_escolhido_bt
            var id ='#texto_edital_escolhido_bt';
            $(id).hide();
            TelaHeight();
        } else {
            alert(url_decode(str).replace(/<br>/gi, "\n"));
        }
    });






}


function ProximoPassoAutenticacao(thisw,idt_etapa)
{
    ativa_funcao_painel('gec_inscricao_passo_02');
    $('#gec_inscricao_passo_02').click();
    return false;
}



function IdentificaCandidato(opc)
{
    var identificacao = '';
    var nome          = '';
    var email         = '';
    var id = 'identifica_cnpjcpf';
    objd = document.getElementById(id);
    identificacao=objd.value;
    $msg = "";
    if (identificacao=='')
    {
        $msg = $msg + " Identificação deve ser Informado "+"\n";;
    }
    //
    var id = 'input_identificacao_t';
    objd = document.getElementById(id);
    nome=objd.value;
    //
    var id = 'input_email_t';
    objd = document.getElementById(id);
    email=objd.value;
    //
    if (opc==1)
    {
        if (nome=='')
        {
            $msg = $msg + " Nome deve ser Informado "+"\n";;
        }
        if (email=='')
        {
            $msg = $msg + " Email deve ser Informado "+"\n";;
        }
    }
    if ($msg != "")
    {
        alert($msg);
        return false;
    }
//  alert(' ---- '+identificacao+' ---- '+nome+' ---- '+email);

    if (opc==1)
    {
        var id ='#msg_confirma2';
        $(id).show();
    }
    else
    {
        var id ='#msg_confirma1';
        $(id).show();
    }
    var str = '';
    $.post('ajax2.php?tipo=IdentificaCandidato', {
        async: false,
        opc  : opc,
        identificacao:identificacao,
        nome:nome,
        email:email
    }
    , function (str) {
        if (str == '') {
            str = " Erro ";
            alert(url_decode(str).replace(/<br>/gi, "\n"));
            
            if (opc==1)
            {
                var id ='#msg_confirma2';
                $(id).hide();
            }
            else
            {
                var id ='#msg_confirma1';
                $(id).hide();
            }

        } else {
            var ret    = str.split('###');
            var ident  = ret[0];
            var pessoa = ret[1];
            var nome   = ret[2];
            var email  = ret[3];
            var jacadastrado  = ret[4];

            
            
//            alert(' ---- '+ident+' ==== '+pessoa+' ==== '+nome+' ==== '+email+' ==== '+jacadastrado);
            var id = 'texto_usuario';
            objd = document.getElementById(id);
            objd.innerHTML=pessoa+':'+'<span>*</span>';
            if (pessoa=='CPF')
            {
                var id = 'texto_senha';
                objd = document.getElementById(id);
                objd.innerHTML="Nome:<span>*</span>";
            }
            else
            {
                var id = 'texto_senha';
                objd = document.getElementById(id);
                objd.innerHTML="Razão Social:<span>*</span>";
            }
            
            var id ='#img_usuario_i';
            $(id).hide();

           // if (jacadastrado=='S')
           // {
                var id ='#img_usuario_1I';
                $(id).show();
               // $(id).hide();
           // }
            
            var id ='#CandidatoCadastrado_0';
            $(id).show();
            var id ='#CandidatoCadastrado_1';
            $(id).show();




            
            if (opc==1)
            {

                var id ='#CandidatoCadastrado_msg';
                $(id).hide();
                
                //bosavindas = "Para escolher o Edital/Processo clique no número destacado em azul na lista abaixo.";
                //var id = 'input_CandidatoCadastrado_msg';
                //objd   = document.getElementById(id);
                //objd.innerHTML=bosavindas;

                var id ='#parte_03_msg';
                $(id).show();

                var id ='#parte_03';
                $(id).show();
                var id ='#edital';
                $(id).show();
                var id ='#edital_escolhido';
                $(id).show();
                var id ='#edital_escolhido_2';
                $(id).show();

                var id = 'input_identificacao_t';
                objd = document.getElementById(id);
                if (objd.value=="")
                {
                    objd.value=nome;
                }
                //
                var id = 'input_email_t';
                objd = document.getElementById(id);
                if (objd.value=="")
                {
                    objd.value=email;
                }

                var bosavindas = 'Caro candidato '+nome+',<br />';
                bosavindas = bosavindas+'Obrigado por desejar participar desse Credenciamento.<br />';
                if (jacadastrado=='S')
                {
                    bosavindas = bosavindas+'ATENÇÃO!!!<br />Identificamos que o '+pessoa+' informado já possui Cadastro Provisório, os dados foram recuperados e podem ser modificados.<br />';
                }
                bosavindas = bosavindas + 'Para prosseguir, clique no Botão AZUL "Confirmar"';
                var id = 'input_CandidatoCadastrado_msg';
                objd = document.getElementById(id);
                //objd.innerHTML=bosavindas;
                //alert(bosavindas);

                // esconder editais que não atende
                if (pessoa=='CPF')
                {   // esconde os que só servem para PJ
                    $('.PJ').each(function () {
                        $(this).hide();
                    });
                }

                if (pessoa=='CNPJ')
                {   // esconde os que só servem para PF
                    $('.PF').each(function () {
                        $(this).hide();
                    });
                }
            }
            else
            {
                var id ='#CandidatoCadastrado_msg';
                $(id).show();


                var id = 'input_identificacao_t';
                objd = document.getElementById(id);
                if (objd.value=="")
                {
                    objd.value=nome;
                }
                //
                var id = 'input_email_t';
                objd = document.getElementById(id);
                if (objd.value=="")
                {
                    objd.value=email;
                }




                if (nome!="")
                {
                    var bosavindas = 'Caro candidato '+nome+',<br />';
                    bosavindas = bosavindas+'Obrigado por desejar participar desse Credenciamento.<br />';
                    if (jacadastrado=='S')
                    {
                        bosavindas = bosavindas+'ATENÇÃO!!!<br />Identificamos que o '+pessoa+' informado já possui Cadastro Provisório, os dados foram recuperados e podem ser modificados.<br />';
                    }
                    bosavindas = bosavindas + 'Para prosseguir, clique no Botão AZUL "Confirmar"';
                    var id = 'input_CandidatoCadastrado_msg';
                    objd = document.getElementById(id);
                    objd.innerHTML=bosavindas;
                }
                else
                {
                    var bosavindas = 'Caro candidato,<br />';
                    bosavindas = bosavindas+'Por favor informe os dados solicitados e Confirme para prosseguir.<br />';
                    if (jacadastrado=='S')
                    {
                        bosavindas = bosavindas+'ATENÇÃO!!!<br />Identificamos que o '+pessoa+' informado já possui Cadastro Provisório, os dados foram recuperados e podem ser modificados.<br />';
                    }
                    bosavindas = bosavindas + 'Para prosseguir, clique no Botão AZUL "Confirmar"';
                    var id = 'input_CandidatoCadastrado_msg';
                    objd = document.getElementById(id);
                    objd.innerHTML=bosavindas;
                }
                //alert(bosavindas);
            }
            if (opc==1)
            {
                var id ='#msg_confirma2';
                $(id).hide();
            }
            else
            {
                var id ='#msg_confirma1';
                $(id).hide();
            }
            
            TelaHeight();
        }
    });
    return false;
}


function IdentificaCandidatoLimpa(opc)
{

    if (!confirm('ATENÇÃO!!!' + '\n\n' + 'Se confirmar essa funcionalidade APAGA os dados Informados até agora.' + '\n\n' + 'Confirma?'))
    {

        return false;
    }


    var identificacao = '';
    var nome          = '';
    var email         = '';
    var id = 'identifica_cnpjcpf';
    objd = document.getElementById(id);
    identificacao=objd.value;
    //
    var id = 'input_identificacao_t';
    objd = document.getElementById(id);
    nome=objd.value;
    //
    var id = 'input_email_t';
    objd = document.getElementById(id);
    email=objd.value;
    //
    
    var id ='#msg_limpa1';
    $(id).show();

    var str = '';
    $.post('ajax2.php?tipo=IdentificaCandidatoLimpa', {
        async: false,
        opc  : opc,
        identificacao:identificacao,
        nome:nome,
        email:email
    }
    , function (str) {
        if (str == '') {
            str = " Erro ";
            alert(url_decode(str).replace(/<br>/gi, "\n"));
            var id ='#msg_limpa1';
            $(id).hide();

        } else {
            var ret = str.split('###');
            var ident  = ret[0];
            var pessoa = ret[1];
            var nome   = ret[2];
            var email  = ret[3];
            var jacadastrado  = ret[4];


            var id = 'texto_usuario';
            objd = document.getElementById(id);
            objd.innerHTML='CNPJ ou CPF'+':'+'<span>*</span>';
            
            var id = 'texto_senha';
            objd = document.getElementById(id);
            objd.innerHTML="Nome ou Razão Social:<span>*</span>";

            



            var id ='#img_usuario_i';
            $(id).show();

            var id ='#img_usuario_1I';
            $(id).hide();

            var id ='#CandidatoCadastrado_0';
            $(id).hide();
            var id ='#CandidatoCadastrado_1';
            $(id).hide();
            var id ='#CandidatoCadastrado_msg';
            $(id).hide();


            var id ='#parte_03_msg';
            $(id).hide();

            var id ='#parte_03';
            $(id).hide();
            var id ='#edital';
            $(id).hide();
            var id ='#edital_escolhido';
            $(id).hide();
            var id ='#edital_escolhido_2';
            $(id).hide();

            var id = 'identifica_cnpjcpf';
            objd = document.getElementById(id);
            objd.value="";
            //
            var id = 'input_identificacao_t';
            objd = document.getElementById(id);
            objd.value="";
            //
            var id = 'input_email_t';
            objd = document.getElementById(id);
            objd.value="";

            $('.PJ').each(function () {
                $(id).show();
            });
            $('.PJ').each(function () {
                $(id).show();
            });

            var id ='#msg_limpa1';
            $(id).hide();


            
            TelaHeight();
        }
    });
    return false;
}




$(document).ready(function () {
    desativa_funcao_painel('gec_inscricao_passo_02');
    desativa_funcao_painel('gec_inscricao_passo_03');
    desativa_funcao_painel('gec_inscricao_passo_04');
    
    if (idt_etapa_escolhido>0)
    {
        var id ='#texto_edital_escolhido_bt';
        $(id).show();
        var numero_edital   = numero_editalw;
        var numero_processo = numero_processow;
        var msg_edital    = 'ATENCÃO!!!<br />Escolhido o Edital número <span style="font-size:20px; background:#FFFFFF; color:#0000FF;">'+numero_edital+'-'+numero_processow+'</span> para Inscrição.';
        var id ='texto_edital_escolhido';
        objd = document.getElementById(id);
        objd.innerHTML=msg_edital;
        TelaHeight();
    }
    
    
});

</script>