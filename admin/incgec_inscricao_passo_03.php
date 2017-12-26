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





div.Login {
    padding-left : 50px;
    padding-top  : 10px;

}

div.Senha {
    padding-left : 50px;
    padding-top  : 30px;

}

.Login_candidato {
    xpadding-left : 50px;
    xpadding-top  : 10px;

}

.Senha_candidato {
    xpadding-left : 50px;
    xpadding-top  : 30px;

}

.BtSenha_candidato {
    cursor: pointer;
    width: 155px;
    height: 25px;
    border:1px solid red;
}
.BtEnter_candidato {
    cursor: pointer;
    width: 70px;
    height: 25px;
    border:1px solid red;
}


.BtIdentificacao_candidato {
    cursor: pointer;
    width: 155px;
    height: 25px;
    border:1px solid #C0C0C0;

}

table.LoginCandidato input {
    height: 25px;
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
echo " {$candidato_ativo}<br />PASSO 3 - AUTENTICAÇÃO DE LOGIN (USUÁRIO E SENHA) ";
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
$texto_explicativo = $vetGEC_parametros['INSTRUCAO_P03'];



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

// $idt_etapa_escolhido = $_GET['idt_etapa'];
 
if ($_SESSION[CS]['g_idt_etapa']!= "")
{
    $idt_etapa_escolhido = $_SESSION[CS]['g_idt_etapa'];
}
else
{
    $idt_etapa_escolhido = $_GET['idt_etapa'];
    echo "ALGO ESTRANHO .... <BR />";
}
 
echo "<table id='edital' class='' width='100%' border='0' cellspacing='1' cellpadding='5' vspace='0' hspace='0'> ";
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
 //p($idt_etapa_escolhido);
 //p($vetEdital);


 $idt_etapa = $idt_etapa_escolhido;


 ForEach ($vetEdital as $idt_edital => $VetProcesso)
 {
     ForEach ($VetProcesso as $idt_processo => $VetEtapa)
     {
         ForEach ($VetEtapa as $idt_etapaw => $VetDados)
         {

                if ($idt_etapa_escolhido != $idt_etapaw)
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




echo "<table id='campos_obrigatorios' style='xdisplay:none;' class='itemsepara' width='100%' border='0' cellspacing='1' cellpadding='5' vspace='0' hspace='0'> ";
echo "<tr class='table_contato_linha'> ";
$msgrodapeobrigatoriow='( * ) campo obrigatório';
echo "   <td class='table_contato_celula_msgrodape' >{$msgrodapeobrigatoriow}</td> ";
echo "</tr>";
echo "</table>";


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
echo " 3 - IDENTIFICAÇÃO PARA AUTENTICAÇÃO";
echo "</td>";
echo "</tr>";
echo "</table>";

echo "<table class='' width='100%' border='0' cellspacing='0' cellpadding='0' vspace='0' hspace='0'> ";
echo "<tr id='instrucao' style=''>  ";
  $bgcolor="#ECF0F1";
  $color  ="#000000";


if ($_SESSION[CS]['g_identificacao']!="")
{
     $identificacao   = $_SESSION[CS]['g_identificacao'];
     $cnpjcpf         = $_SESSION[CS]['g_cnpjcpf'];
     $nome_candidato  = $_SESSION[CS]['g_nome_candidato'];
     $email_candidato = $_SESSION[CS]['g_email_candidato'];
     $telefone_candidato = $_SESSION[CS]['g_telefone_candidato'];

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
     $telefone_candidato = "";
     $texto1 = "CNPJ ou CPF:";
     $texto2 = "Identificação:";

}

echo "<table id='edital_login_candidato' style='xdisplay:none;' class='LoginCandidato' width='100%' border='0' cellspacing='1' cellpadding='5' vspace='0' hspace='0'> ";
echo "<tr class='' style=''>  ";
echo "   <td id='texto_usuario'  style='text-align:right; width:20%; font-weight: bold; font-size:16px; background:{$bgcolor}; color:{$color};'>";
echo "         $texto1<span>*</span>";
echo "   </td>";
echo "   <td colspan='2' id='input_usuario'  style='text-align:left;  width:25%; font-weight: bold; font-size:16px; background:{$bgcolor}; color:{$color};'>";
echo "         <input id='identifica_cnpjcpf' class='Texto' type='text' value='{$identificacao}' name='CNPJCPJ' onkeyup='Enter(event)'> ";
echo "   </td>";

//echo "   <td id='img_usuario'  style='text-align:left; width:55%; font-weight: bold; font-size:16px; background:{$bgcolor}; color:{$color};'>";
//echo "   &nbsp;<img id='img_usuario_i' title='Confirmar Identificação, CNPJ ou CPF' class='BtIdentificacao_candidato' onclick='return IdentificaCandidato(0);' src='imagens/confirmar_identificacao.png' border='0'> ";
//echo "   </td>";



echo "</tr>";

echo "<tr id='CandidatoCadastrado_0' class='CandidatoCadastrado' style='xdisplay:none;'>  ";
echo "   <td id='texto_senha'  style='text-align:right; width:20%; font-weight: bold; font-size:16px; background:{$bgcolor}; color:{$color};'>";
echo "   $texto2<span>*</span>";
echo "   </td>";
echo "   <td colspan='2' id='input_identificacao'  style='text-align:left; width:80%; font-weight: bold; font-size:16px; background:{$bgcolor}; color:{$color};'>";
echo "         <input id='input_identificacao_t' style='width:370px;' class='Texto' type='text' value='{$nome_candidato}' name='senha' onkeyup='Enter(event)'> ";
echo "   </td>";
echo "</tr>";


echo "<tr id='CandidatoCadastrado_1' class='CandidatoCadastrado' style='xdisplay:none;'>  ";
echo "   <td id='texto_email'  style='text-align:right; width:20%; font-weight: bold; font-size:16px; background:{$bgcolor}; color:{$color};'>";
echo "   Email:<span>*</span>";
echo "   </td>";
echo "   <td colspan='2' id='input_email'  style='text-align:left; width:50%; font-weight: bold; font-size:16px; background:{$bgcolor}; color:{$color};'>";
echo "         <input id='input_email_t' style='width:270px;' class='Texto' type='text' value='{$email_candidato}' name='senha' onkeyup='Enter(event)'> ";
echo "   </td>";

//echo "   <td id='img_usuario_1'  style='text-align:left; width:30%; font-weight: bold; font-size:16px; background:{$bgcolor}; color:{$color};'>";
//echo "     <img id='img_usuario_1I' title='Confirmar Identificação, CNPJ ou CPF' class='BtIdentificacao_candidato' onclick='return IdentificaCandidato(1);' src='imagens/confirmar_identificacao.png' border='0'> ";
//echo "   </td>";
echo "</tr>";


echo "<tr id='CandidatoCadastrado_2' class='CandidatoCadastrado' style='xdisplay:none;'>  ";
echo "   <td id='texto_telefone'  style='text-align:right; width:20%; font-weight: bold; font-size:16px; background:{$bgcolor}; color:{$color};'>";
echo "   Telefone:<span>*</span>";
echo "   </td>";
echo "   <td colspan='2' id='input_telefone'  style='text-align:left; width:50%; font-weight: bold; font-size:16px; background:{$bgcolor}; color:{$color};'>";
echo "         <input id='input_telefone_t' style='width:270px;' class='Texto' type='text' value='{$telefone_candidato}' name='senha' onkeyup='Enter(event)'> ";
echo "   </td>";

//echo "   <td id='img_usuario_1'  style='text-align:left; width:30%; font-weight: bold; font-size:16px; background:{$bgcolor}; color:{$color};'>";
//echo "     <img id='img_usuario_1I' title='Confirmar Identificação, CNPJ ou CPF' class='BtIdentificacao_candidato' onclick='return IdentificaCandidato(1);' src='imagens/confirmar_identificacao.png' border='0'> ";
//echo "   </td>";
echo "</tr>";



echo "<tr id='CandidatoCadastrado_3' class='CandidatoCadastrado' style='xdisplay:none;'>  ";
echo "   <td id='texto_senha'  style='text-align:right; width:20%; font-weight: bold; font-size:16px; background:{$bgcolor}; color:{$color};'>";
echo "   Senha:<span>*</span>";
echo "   </td>";
$senha_candidato="";
echo "   <td colspan='2' id='input_senha'  style='text-align:left; width:50%; font-weight: bold; font-size:16px; background:{$bgcolor}; color:{$color};'>";
echo "         <input id='input_senha_t' style='width:270px;' class='Texto' type='password' value='{$senha_candidato}' name='senha' onkeyup='Enter(event)'> ";
echo "   </td>";

//echo "   <td id='img_usuario_1'  style='text-align:left; width:30%; font-weight: bold; font-size:16px; background:{$bgcolor}; color:{$color};'>";
//echo "     <img id='img_usuario_1I' title='Confirmar Identificação, CNPJ ou CPF' class='BtIdentificacao_candidato' onclick='return IdentificaCandidato(1);' src='imagens/confirmar_identificacao.png' border='0'> ";
//echo "   </td>";
echo "</tr>";

echo "<tr id='CandidatoCadastrado_4' class='CandidatoCadastrado' style='xdisplay:none;'>  ";
echo "   <td id='texto_senha_c'  style='text-align:right; width:20%; font-weight: bold; font-size:16px; background:{$bgcolor}; color:{$color};'>";
echo "   Confirme a Senha:<span>*</span>";
echo "   </td>";
$senha_c_candidato="";
echo "   <td xcolspan='2' id='input_senha_c'  style='text-align:left; width:50%; font-weight: bold; font-size:16px; background:{$bgcolor}; color:{$color};'>";
echo "         <input id='input_senha_c_t' style='width:270px;' class='Texto' type='password' value='{$senha_c_candidato}' name='senha' onkeyup='Enter(event)'> ";
echo "   </td>";

echo "   <td id='img_usuario_1'  style='text-align:left; width:30%; font-weight: bold; font-size:16px; background:{$bgcolor}; color:{$color};'>";
echo "     <img id='img_usuario_1I' title='Confirmar Identificação, CNPJ ou CPF' class='BtIdentificacao_candidato' onclick='return AutenticacaoCandidato(1);' src='imagens/confirmar_identificacao.png' border='0'> ";
echo "   </td>";
echo "</tr>";


echo "</tr>";
echo "</table>";

echo "<br />";


echo "<table id='edital_escolhido' style='display:none;' class='itemsepara' width='100%' border='0' cellspacing='1' cellpadding='5' vspace='0' hspace='0'> ";
echo "<tr class='instrucoes_insc' style=''>  ";
echo "   <td style='width:30px; border-bottom:1px solid #FFFFFF;'>";
$onclick=" onclick='return DesistedoEditalEscolhido(this); ' ";


$imagem = "<img $onclick style='cursor:pointer;' id='edital_e_img' src='imagens/bt_apagar.gif' title='Desiste do Edital Escolhido'  border='0'>";

$onclick="";
$imagem ="";


echo "  $imagem ";
echo "</td>";

echo "   <td style='xborder:1px solid #FFFFFF;'>";
echo " 4 - RESULTADO DA AUTENTICAÇÃO ";
echo "</td>";
echo "</tr>";
echo "</table>";


echo "<table id='edital_escolhido_2' style='xdisplay:none;' class='itemsepara' width='100%' border='0' cellspacing='1' cellpadding='5' vspace='0' hspace='0'> ";

echo "<tr class='' style=''>  ";
$bgcolor="#FFFFFF";
$color  ="#000000";
echo "   <td id='texto_autenticacao_resultado'  style='border-bottom:1px solid #000000; padding-left:20px; width:70%; font-weight: bold; font-size:16px; background:{$bgcolor}; color:{$color};'>&nbsp;</td> ";

$onclick=" onclick='return ProximoPassoCadastro(this,$idt_etapa); ' ";
//$imagem = "<img $onclick style='cursor:pointer;' id='edital_img' src='imagens/seta_proximo.png' title='Clique aqui para prosseguir com a Inscrição nesse Edital'  border='0'>";


$imagem = "<img $onclick style='cursor:pointer;' id='edital_img' src='imagens/proximo_4.png' title='Clique aqui para prosseguir com a Inscrição nesse Edital'  border='0'>";

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


function IdentificaCandidato()
{

    var id ='identifica_cnpjcpf';
    objd   = document.getElementById(id);
    var identificacao = objd.value;
    if (identificacao=="")
    {
        alert(' Atenção!!'+"\n"+' Informe o CNPJ ou CPF. ');
        return false;
    }



    var id ='#CandidatoCadastrado_0';
    $(id).show();

    
    var id ='#CandidatoCadastrado_1';
    $(id).show();

    var id ='#CandidatoCadastrado_2';
    $(id).show();

    
    return false;


}
function AutenticacaoCandidato(opc)
{
    var identificacao = '';
    var nome          = '';
    var email         = '';
    var telefone      = '';
    var senha         = '';
    var senha_c       = '';
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
    
    
    var id = 'input_telefone_t';
    objd = document.getElementById(id);
    telefone=objd.value;

    var id = 'input_senha_t';
    objd = document.getElementById(id);
    senha=objd.value;

    var id = 'input_senha_c_t';
    objd = document.getElementById(id);
    senha_c=objd.value;
    
    if (senha!=senha_c)
    {
        $msg = $msg + " Senha e Confirme Senha DIFEREM."+"\n"+'Por favor informe novamente'+"\n\n";
        var id = 'input_senha_t';
        objd = document.getElementById(id);
        objd.value="";

        var id = 'input_senha_c_t';
        objd = document.getElementById(id);
        objd.value="";

    }

    //
    if (nome=='')
    {
        $msg = $msg + " Nome deve ser Informado "+"\n";;
    }
    if (email=='')
    {
        $msg = $msg + " Email deve ser Informado "+"\n";;
    }
    if (telefone=='')
    {
        $msg = $msg + " Telefone deve ser Informado "+"\n";;
    }
    if (senha=='')
    {
        $msg = $msg + " Senha deve ser Informado "+"\n";;
    }
    if (senha=='')
    {
        $msg = $msg + " Confirmar a Senha deve ser Informado "+"\n";;
    }

    
    
    if ($msg != "")
    {
        alert($msg);
        return false;
    }
 //alert(' ---- '+identificacao+' ---- '+nome+' ---- '+email);
    var str = '';
    $.post('ajax2.php?tipo=AutenticacaoCandidato', {
        async: false,
        opc  : opc,
        identificacao:identificacao,
        nome:nome,
        email:email,
        telefone:telefone,
        senha:senha,
        senha_c:senha_c
    }
    , function (str) {
        if (str == '') {
            str = " Erro ";
            alert(url_decode(str).replace(/<br>/gi, "\n"));
        } else {
            var ret           = str.split('###');
            var ident         = ret[0];
            var pessoa        = ret[1];
            var nome          = ret[2];
            var email         = ret[3];
            var jacadastrado  = ret[4];
            var telefone      = ret[5];
           // alert(str+' ---- '+ident+' ==== '+pessoa+' ==== '+nome+' ==== '+email+' ==== '+jacadastrado+' ==== '+telefone);
            var id = 'texto_usuario';
            objd = document.getElementById(id);
            objd.innerHTML=pessoa;
            if (pessoa=='CPF')
            {
                var id = 'texto_senha';
                objd = document.getElementById(id);
                objd.innerHTML="Nome:";
            }
            else
            {
                var id = 'texto_senha';
                objd = document.getElementById(id);
                objd.innerHTML="Razão Social:";
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

                var id = 'texto_autenticacao_resultado';
                objd = document.getElementById(id);
                objd.innerHTML="Atenção!!!<br />Autenticado com SUCESSO.<br />Você receberá um email e por favor, utilize o LINK disponibilizado no email para confirmar essa ação.";

                var id ='#parte_03';
                $(id).show();
                var id ='#edital';
                $(id).show();
                var id ='#edital_escolhido';
                $(id).show();
                var id ='#edital_escolhido_2';
                $(id).show();
                var id ='#texto_edital_escolhido_bt';
                $(id).show();

                

            }
            TelaHeight();
        }
    });
    return false;


}


function ProximoPassoCadastro(thisw,idt_etapa)
{
    ativa_funcao_painel('gec_inscricao_passo_04');
    $('#gec_inscricao_passo_04').click();
    return false;
}


$(document).ready(function () {
   // desativa_funcao_painel('gec_inscricao_passo_01');
   // desativa_funcao_painel('gec_inscricao_passo_02');
});

</script>