
<style type="text/css">


div#link_util {
    background: #FFFFFF;
    width:100%;
}


td.link_util_cab_td {
    xbackground: #2F66B8;
    background: #FFFFFF;
    color:#000000;
}
td.class_link {
    background: #ECF0F1;
    color:#000000;
    padding:5px;
    padding-left:20px;
    border-bottom:1px solid #C0C0C0;

}
td.class_link a {
    text-decoration:none;
    cursor:pointer;
    font-sizs:14px;
    
}
td.class_link_n {
    background: #C4C9CD;
    color:#FFFFFF;
    padding:5px;
    font-sizs:16px;
    border-bottom:1px solid #FFFFFF;
}

#filtro_classificacao {
    display: block;
}

#classificacao {
    display: none;
}




div#home_duvida_pergunta {
    background-color:#F1F1F1;
    padding-left:10px;
    margin-top:10px;
    padding-top:2px;
    padding-bottom:5px;
}

div#home_duvida_pergunta span {
    font-family : Calibri, Arial, Helvetica, sans-serif;
    font-size   : 13px;
    font-style  : normal;
    font-weight : normal;
    color       : #C40000;
    color       : #AFAFAF;

    color       : #282828;

    padding-top:2px;
    padding-bottom:5px;

}

div#home_duvida_resposta {
    background:#ECF0F1;
    padding-top:2px;
    padding-bottom:5px;
}

div#home_duvida_resposta span {
    font-family : Arial, Calibri, Helvetica, sans-serif;
    font-size   : 12px;
    font-style  : normal;
    font-weight : normal;
    color       : #000000;
    padding-top:2px;
    padding-bottom:5px;
}






</style>


<?php

$marcados        = str_replace('___','###',$_GET['marcados']);
$idt_pessoa      = $_GET['idt_pessoa'];
$idt_atendimento = $_GET['idt_atendimento'];
$html        = EnviarEmailBia($idt_atendimento,$idt_pessoa,$marcados);
//
$nomew   = $_GET['texto'];
$emailw  = $_GET['email'];

/*
echo "------------------ {$idt_atendimento} <br />";
p($_SESSION[CS]['g_bia_email_vet']['protocolo']);
p($_SESSION[CS]['g_bia_email_vet']['destinatario']);
p($_SESSION[CS]['g_bia_email_vet']['email_destino']);
echo '------------------<br />';
*/


if ($nomew=='')
{
    $nomew=$_SESSION[CS]['g_bia_email_vet']['destinatario'];
}
if ($emailw=='')
{
    $emailw=$_SESSION[CS]['g_bia_email_vet']['email_destino'];
}

$complemento_acao = $_SESSION[CS]['g_bia_email_vet']['titulobia'];

echo "<table class='table_contato' width='100%' border='0' cellspacing='4' cellpadding='4' vspace='0' hspace='0'> ";

$link  = " onclick='return EnviaEmail();' ";
$bt_pesquisar = " <img {$link} width='50%'  height='50%'  title='Inicia o Envio do EMAIL.' src='imagens/boton_enviar.png' border='0' style='cursor:pointer; '>";

echo "<tr class='table_contato_linha'> ";
$nomelabelw="<label for='texto' >Destinatário:&nbsp;</label>";
echo "   <td class='table_contato_celula_label'>{$nomelabelw}</td> ";

$nomew="<input title='Digitar o destinatário.'  id='id_texto' class='Texto' type='text' name='texto' value='{$nomew}' size='50' maxlength='80' style='height:32px;'><br>";
$div1  = "<div style='float:left;'>";
$div1 .= "{$nomew}";
$div1 .= "</div>";

echo "   <td class='table_contato_celula_value' style='xborder:1px solid red;'>{$div1}</td> ";

echo "</tr>";


echo "<tr class='table_contato_linha'> ";
$emaillabelw="<label for='texto' >Email:&nbsp;</label>";
echo "   <td class='table_contato_celula_label'>{$emaillabelw}</td> ";
$emailw="<input title='Digitar os email de Destino para envio dos conteúdos do BIA selecionadosda.'  id='id_email' class='Texto' type='text' name='email' value='{$emailw}' size='50' maxlength='80' style='height:32px;'><br>";

$div1  = "<div style='float:left;'>";
$div1 .= "{$emailw}";
$div1 .= "</div>";

$div2  = "<div style='float:left; padding-left:10px;'>";
$div2 .= "{$bt_pesquisar}";
$div2 .= "</div>";
echo "   <td class='table_contato_celula_value' style='xborder:1px solid red;'>{$div1} {$div2}</td> ";
echo "</tr>";
echo "</table> ";




echo " <div id='link_util'> ";

echo "<table class='link_util_table' width='100%' border='0' cellspacing='0' cellpadding='0' vspace='0' hspace='0'> ";
echo "<tr class='link_util_cab_tr'>  ";
echo "   <td class='link_util_cab_td' >".$html."</td> ";
echo "</tr>";
echo "</table>";

echo " </div> ";

?>


<script>

var marcados        = '<?php echo $marcados; ?>';
var idt_pessoa      = '<?php echo $idt_pessoa; ?>';
var idt_atendimento = '<?php echo $idt_atendimento; ?>';
var htmlw           = '<?php echo ""; ?>';

var complemento_acao = '<?php echo $complemento_acao; ?>';

$(document).ready(function () {
    // foco no campo texto
    objd=document.getElementById('id_texto');
    if (objd != null)
    {
       $(objd).focus();
    }
});

function EnviaEmail()
{
    var texto = "";
    objd=document.getElementById('id_texto');
    if (objd != null)
    {
       texto = objd.value;
    }
    
    var email = "";
    objd=document.getElementById('id_email');
    if (objd != null)
    {
       email = objd.value;
    }
    //
    // enviar email para destinatários
    //
    if (texto=='')
    {
        alert('Por favor, informar destinatário do email.');
        return false;
    }

    if (email=='')
    {
        alert('Por favor, informar email de destino.');
        return false;
    }

     var str="";
       var titulo = "Processando Enviar Email. Aguarde...";
       processando_grc(titulo,'#2F66B8');
       
       $.post('ajax_atendimento.php?tipo=EnviarEmailBia', {
          async: false,
          idt_atendimento  : idt_atendimento,
          destinatario     : texto,
          email            : email,
          html             : htmlw
       }
       , function (str) {
           if (str == '') {
               processando_acabou_grc();
               window.close();
           } else {
               alert(str);
               processando_acabou_grc();
               window.close();
           }
       });

//    var volta = "conteudo_atendimento_email_bia.php?texto="+texto+'&email='+email+'&marcados='+marcados+'&idt_pessoa='+idt_pessoa+'&idt_atendimento='+idt_atendimento+'&enviar=S';
//    self.location=volta;
    return false;
}


function fecha_grupo(grupo)
{
    var id = '#img_grupo_'+grupo;
    var img = $(id);
    if (img.attr('src') == 'imagens/seta_cima.png')
    {
        img.attr('src', 'imagens/seta_baixo.png');
    }
    else
    {
        img.attr('src', 'imagens/seta_cima.png');
    }
    //alert (' ======= '+id);
    var classe_grupo='.classe_grupo_'+grupo;

    //alert (' ccccc======= '+classe_grupo);
    $(classe_grupo).each(function () {
        $(this).toggle();
    });

    return false;
}

</script>