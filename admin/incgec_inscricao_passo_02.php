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
 
 $vetGEC_parametros=Array();
 $vetGEC_parametros=GEC_parametros();
 
 $candidato_ativo = $_SESSION[CS]['g_nome_candidato'];
 //p($vetGEC_parametros);
echo "<table class='cabpasso' width='100%' border='0' cellspacing='1' cellpadding='5' vspace='0' hspace='0'> ";
echo "<tr class='cab_insc' style=''>  ";
echo "   <td style='text-align:center; font-size:18px; border-bottom:1px solid #FFFFFF;'>";
echo " {$candidato_ativo}<br />PASSO 2 - TERMO DE ACEITE";
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

$texto_explicativo = " Caro Candidato <br /><br /> Vc aqui TERÁ QUE LER E ACEITAR O tERMO DE ACEITE PARA PROSSEGUIR NO cREDENCIAMENTO.?";
$texto_explicativo = $vetGEC_parametros['INSTRUCAO_P02'];
$texto_explicativo = str_replace('#candidato',$_SESSION[CS]['g_nome_candidato'],$texto_explicativo);


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

$numero_processow    = '';
$numero_editalw      = '';

if ($_SESSION[CS]['g_idt_etapa']!= "")
{
    $idt_etapa_escolhido = $_SESSION[CS]['g_idt_etapa'];
}
else
{
    $idt_etapa_escolhido = $_GET['idt_etapa'];
    echo "ALGO ESTRANHO .... <BR />";
}
$aceitestatus="N";


//p($_SESSION[CS]);
if ($_SESSION[CS][$idt_etapa_escolhido]['g_Aceite_Termo']=="S")
{
    $aceitestatus="S";
}

//p($idt_etapa_escolhido);

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

                $numero_processow    = $numero_processo;
                $numero_editalw      = $codigo_edital;



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
$onclick=" onclick='return ImprimeTermo(this); ' ";
$imagem = "<img $onclick style='cursor:pointer;' id='edital_e_img' src='imagens/impressora.gif' title='Imprime o Termo de Aceite'  border='0'>";
echo "  $imagem ";
echo "</td>";

echo "   <td style='xborder:1px solid #FFFFFF;'>";
echo " 3 - TERMO DE ACEITE";
echo "</td>";
echo "</tr>";
echo "</table>";


echo "<table id='edital_escolhido_2' style='xdisplay:none;' class='itemsepara' width='100%' border='0' cellspacing='1' cellpadding='5' vspace='0' hspace='0'> ";



echo "<tr class='' style=''>  ";
$bgcolor="#FFFFFF";
$color  ="#000000";



$termodeaceite  = "";
$termodeaceite .= "<br /> 1 - Estou ciente e aceito todos os termos e condições do Edital de Credenciamento.";
$termodeaceite .= "<br /> 2 - Comprometo desde já com a veracidade das informações, a qual dou fé, sob as penas da lei.";
$termodeaceite .= "<br />";


$troca = $_SESSION[CS]['g_cnpjcpf'].': '.$_SESSION[CS]['g_identificacao'];


                $numero_processow    = $numero_processo;
                $numero_editalw      = $codigo_edital;



if ($pessoa_jf=='PJ')
{   // juridica
    $termodeaceite = $vetGEC_parametros['TERMO_ACEITE_01'];
}
else
{
    if ($pessoa_jf=='PF')
    {   // fisica
        $termodeaceite = $vetGEC_parametros['TERMO_ACEITE_02'];

    }
    else
    {   // ambos
        $termodeaceite = $vetGEC_parametros['TERMO_ACEITE_03'];
    }
}

$termodeaceite = str_replace('#candidato',$_SESSION[CS]['g_nome_candidato'],$termodeaceite);
$termodeaceite = str_replace('#cnpjcpf',$troca,$termodeaceite);
$termodeaceite = str_replace('#numero_edital',$numero_editalw,$termodeaceite);
$termodeaceite = str_replace('#numero_processo',$numero_processow,$termodeaceite);

$_SESSION[CS]['g_texto_emite']=$termodeaceite;

echo "   <td colspan='2' id='texto_edital_termo'  style='border-bottom:1px solid #000000; padding-left:20px; width:70%; font-weight: bold; font-size:16px; background:{$bgcolor}; color:{$color};'>{$termodeaceite}&nbsp;</td> ";





//$onclick=" onclick='return ProximoPassoAutenticacao(this,$idt_etapa); ' ";
//$imagem = "<img $onclick style='cursor:pointer;' id='edital_img' src='imagens/seta_proximo.png' title='Clique aqui para prosseguir com a Inscrição nesse Edital'  border='0'>";




//$imagem = "<img $onclick style='cursor:pointer;' id='edital_img' src='imagens/proximo_2.png' title='Clique aqui para prosseguir com a Inscrição nesse Edital'  border='0'>";

//echo "   <td id='texto_edital_escolhido_bt'  style='display:none; border-bottom:1px solid #000000;  width:28%; font-weight: bold; font-size:12px; background:{$bgcolor}; color:{$color};'>&nbsp;$imagem</td> ";

echo "</tr>";




echo "<tr class='' style=''>  ";
$bgcolor="#FFFFFF";
$color  ="#000000";



$onclick_escolhido       = " onclick='return AceitedoTermo($idt_etapa); ' ";
$onclick_escolhido_limpa = " onclick='return AceitedoTermoLimpa($idt_etapa); ' ";

$imagem   = "<img $onclick_escolhido style='cursor:pointer;' id='edital_img' src='imagens/aceito_termo.png' title='Clique aqui para ACEITAR O TERMO DE ACEITE'  border='0'>";
$imagem_n = "<img id='nao_aceita' $onclick_escolhido_limpa style='cursor:pointer;' id='edital_img' src='imagens/aceito_termo_nao_v.png' title='Clique aqui para NÃO ACEITAR O TERMO DE ACEITE'  border='0'>";


$imagem_aguarde = "<img width='16' height='16' style='cursor:pointer;' id='' src='imagens/carregando.gif' title=''  border='0'>";

//echo "   <td id='texto_edital_termo_bt'  style='width:50%; text-align:right; border-bottom:1px solid #000000;   font-weight: bold; font-size:12px; background:{$bgcolor}; color:{$color};'>&nbsp;$imagem</td> ";
echo "   <td colspan='2' id='texto_edital_termo_bt'  style='width:50%; text-align:center; border-bottom:1px solid #000000;   font-weight: bold; font-size:12px; background:{$bgcolor}; color:{$color};'><div>$imagem&nbsp;&nbsp;&nbsp;$imagem_n</div><div  id='msg_aceite'  style='display:none; color:#666666; '>{$imagem_aguarde}&nbsp;&nbsp;Aguarde...</div></td> ";

echo "</tr>";







echo "<tr class='' style=''>  ";
$bgcolor="#FFFFFF";
$color  ="#ff0000";
echo "   <td id='texto_edital_escolhido'  style='border-bottom:1px solid #000000; padding-left:20px; width:70%; font-weight: bold; font-size:16px; background:{$bgcolor}; color:{$color};'>ATENCÃO!!!<br />SEM ACEITE NO TERMO.<br />CLIQUE NO BOTÃO 'Aceito' ou 'Não Aceito'.&nbsp;</td> ";

$onclick=" onclick='return ProximoPassoAutenticacao(this,$idt_etapa); ' ";
//$imagem = "<img $onclick style='cursor:pointer;' id='edital_img' src='imagens/seta_proximo.png' title='Clique aqui para prosseguir com a Inscrição nesse Edital'  border='0'>";


$imagem = "<img $onclick style='cursor:pointer;' id='edital_img' src='imagens/proximo_3.png' title='Clique aqui para prosseguir com a Inscrição nesse Edital'  border='0'>";

echo "   <td id='texto_edital_escolhido_bt'  style='display:none; border-bottom:1px solid #000000;  width:28%; font-weight: bold; font-size:12px; background:{$bgcolor}; color:{$color};'>&nbsp;$imagem</td> ";



$onclick=" onclick='return FimProcesso(this,$idt_etapa); ' ";

$imagem = "<img $onclick style='cursor:pointer;' id='edital_img' src='imagens/proximo_fim_v.png' title='Clique aqui para Finalizar o Processo de Inscrição nesse Edital'  border='0'>";

echo "   <td id='texto_edital_escolhido_bt_n'  style='display:none; border-bottom:1px solid #000000;  width:28%; font-weight: bold; font-size:12px; background:{$bgcolor}; color:{$color};'>&nbsp;$imagem</td> ";

echo "</tr>";

echo "</table>";







echo "</div>";


?>

<script type="text/javascript">


var aceitestatus        =  '<?php echo $aceitestatus;  ?>';
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

function xxxxxEditalEscolhido(thisw,idt_etapa)
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

function xxxxxDesistedoEditalEscolhido(thisw)
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
    
    var campo = $('#' + id);
    campo.css("color", "#FF0000");

    
    
    texto_edital_escolhido_bt
    var id ='#texto_edital_escolhido_bt';
    $(id).hide();

}


function ProximoPassoAutenticacao(thisw,idt_etapa)
{
    //self.location='conteudo.php?prefixo=inc&menu=gec_inscricao_passo_03&idt_etapa='+idt_etapa+'&origem_tela=painel&elemento=0&voltar=aHR0cDovL2x1cGUuZW5naW5mby5jb20uYnIvc2VicmFlX2dlYy9hZG1pbi9jb250ZXVkby5waHA/cHJlZml4bz1pbmMmbWVudT1nZWNfaW5zY3JpY2FvX2NyZWRlbmNpYWRvJm9yaWdlbV90ZWxhPXBhaW5lbCZlbGVtZW50bz0wJnZvbHRhcj1hSFIwY0RvdkwyeDFjR1V1Wlc1bmFXNW1ieTVqYjIwdVluSXZjMlZpY21GbFgyZGxZeTloWkcxcGJpOWpiMjUwWlhWa2J5NXdhSEEvY0hKbFptbDRiejFwYm1NbWJXVnVkVDFuWldOZlkzSmxaR1Z1WTJsaGJXVnVkRzhtYjNKcFoyVnRYM1JsYkdFOWNHRnBibVZzSm1Wc1pXMWxiblJ2UFRBbWRtOXNkR0Z5UFdGSVVqQmpSRzkyVERKNE1XTkhWWFZhVnpWdVlWYzFiV0o1TldwaU1qQjFXVzVKZG1NeVZtbGpiVVpzV0RKa2JGbDVPV2hhUnpGd1ltazRQUT09';
    ativa_funcao_painel('gec_inscricao_passo_03');
    $('#gec_inscricao_passo_03').click();

    TelaHeight();
    return false;
}


function AceitedoTermo(idt_etapa)
{
   // alert(' AceiTou o termo = '+idt_etapa);

   // var id ='#texto_edital_escolhido_bt';
   // $(id).show();

/*
     var id ='#texto_edital_escolhido_bt';
    $(id).show();


  //  var numero_edital = thisw.innerHTML;
  //  var msg_edital    = 'ATENCÃO!!!<br />Escolhido o Edital número <span style="font-size:20px; background:#FFFFFF; color:#0000FF;">'+thisw.innerHTML+'</span> para Inscrição.';
  
  
    var msg_aceite  = 'OBRIGADO!!!<br />Termo de Aceite Lido e Aceito pelo Candidato.';
    var id ='texto_edital_escolhido';
    objd = document.getElementById(id);
    objd.innerHTML=msg_aceite;
    TelaHeight();
*/
    

    
    var id ='#msg_aceite';
    $(id).show();

    var str = '';
    $.post('ajax2.php?tipo=AceitedoTermo', {
        async: false,
        idt_etapa : idt_etapa
    }
    , function (str) {
        if (str == '') {
            var id ='#texto_edital_escolhido_bt';
            $(id).show();
            var id ='#texto_edital_escolhido_bt_n';
            $(id).hide();

            var msg_aceite  = 'OBRIGADO!!!<br />Termo de Aceite Lido e Aceito pelo Candidato.';
            var id ='texto_edital_escolhido';
            
            var campo = $('#' + id);
            campo.css("color", "#14ADCC");

            
            objd = document.getElementById(id);
            objd.innerHTML=msg_aceite;
            
            aceitestatus='S';
            
            var id ='#msg_aceite';
            $(id).hide();
            TelaHeight();
        } else {
            alert(url_decode(str).replace(/<br>/gi, "\n"));
            var id ='#msg_aceite';
            $(id).hide();

        }
    });

    
    
    
    
    
    
    
    
    
    return false;
}


function AceitedoTermoLimpa(idt_etapa)
{

    var id ='#msg_aceite';
    $(id).show();
    //alert(' aaaa ');
    var str = '';
    $.post('ajax2.php?tipo=AceitedoTermoLimpa', {
        async: false,
        idt_etapa : idt_etapa
    }
    , function (str) {
        if (str == '') {
            aceitestatus='N';
            var id ='#texto_edital_escolhido_bt';
            $(id).hide();
            var id ='#texto_edital_escolhido_bt_n';
            $(id).show();
            var msg_aceite  = 'ATENCÃO!!!<br />SEM ACEITE NO TERMO.<br />CLIQUE NO BOTÃO AO LADO PARA FINALIZAR O PROCESSO.';
            
            
            var id ='texto_edital_escolhido';
            var campo = $('#' + id);
            campo.css("color", "#FF0000");

            
            objd = document.getElementById(id);
            objd.innerHTML=msg_aceite;

            
            
            var id ='#msg_aceite';
            $(id).hide();
            TelaHeight();
        } else {
            alert(url_decode(str).replace(/<br>/gi, "\n"));
            var id ='#msg_aceite';
            $(id).hide();

        }
    });
    return false;
}

function FimProcesso(thisw,idt_etapa)
{
    //alert('Fim do Processo');
    var str = '';
    $.post('ajax2.php?tipo=FimProcesso', {
        async: false,
        idt_etapa : idt_etapa
    }
    , function (str) {
        if (str == '') {
            desativa_funcao_painel('gec_inscricao_passo_02');
            ativa_funcao_painel('gec_inscricao_passo_01');
            $('#gec_inscricao_passo_01').click();
            TelaHeight();
        } else {
            alert(url_decode(str).replace(/<br>/gi, "\n"));
        }
    });
    return false;
}


function ImprimeTermo(thisw)
{
   // alert(' Imprime termo ');

/*
    var id = $('table.Generica input:radio:checked').val();
    if (id == undefined) {
       alert('Favor selecionar a Obra para Acessar a Tipologia de Medição!');
       return false;
    }
*/
   var msg_aceite = "";
    //
   // var id ='texto_edital_termo';
   // objd = document.getElementById(id);
   // msg_aceite = objd.innerHTML;
    //
    var  par = '&numero_edital='+numero_editalw+'&numero_processo='+numero_processow+'&aceite='+aceitestatus;
    var  left   = 0;
    var  top    = 0;
    var  height = $(window).height();
    var  width  = $(window).width();
    var titulo_rel = "TERMO DE ACEITE";
    var link ='conteudo_termo_aceite.php?&print=S&titulo_rel='+titulo_rel+'&texto_emite='+msg_aceite+par;
    //
    termo_aceite =  window.open(link,"TermoAceite","left="+left+",top="+top+",width="+width+",height="+height+",resizable=yes,menubar=no,scrollbars=yes,toolbar=no");
    termo_aceite.focus();
    //
    return false;
}

$(document).ready(function () {
   // desativa_funcao_painel('gec_inscricao_passo_01');
    desativa_funcao_painel('gec_inscricao_passo_03');
    desativa_funcao_painel('gec_inscricao_passo_04');

    if (aceitestatus=='S')
    {
        var id ='#texto_edital_escolhido_bt';
        $(id).show();
        var msg_aceite  = 'OBRIGADO!!!<br />Termo de Aceite Lido e Aceito pelo Candidato.';
        var id ='texto_edital_escolhido';
        objd = document.getElementById(id);
        objd.innerHTML=msg_aceite;
        
        var campo = $('#' + id);
        campo.css("color", "#14ADCC");

        
        TelaHeight();
    }

});

</script>