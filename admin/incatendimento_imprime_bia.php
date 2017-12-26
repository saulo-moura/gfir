
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
$protocolo  = $_SESSION[CS]['g_bia_email_vet']['protocolo'];
$protocolow = substr($protocolo,2);
$protocolow = TiraZeroEsq($protocolow);
$protocolow = 'AT-'.$protocolow;
$html             = $_SESSION[CS]['g_bia_email_vet']['html'];
$origem_nome      = $_SESSION[CS]['g_nome_completo'];
$origem_email     = $_SESSION[CS]['g_email'];
$destino_nome     = $_SESSION[CS]['g_bia_email_vet']['destinatario'];
$destino_email    = $_SESSION[CS]['g_bia_email_vet']['email_destino'];
$destino_mensagem  = "Sr(a) $destinatario, <br /><br />";
$destino_mensagem .= "Seguem abaixo informações sobre o seu atendimento protocolo {$protocolow}. <br /><br />";
$destino_mensagem .= $html."<br /><br /> ";
$destino_mensagem .= "Obrigado, <br /><br />";
$destino_mensagem .= "Consultor/Atendente: {$origem_nome}<br />";
$destino_mensagem .= "email: {$origem_email}<br />";
//
$msg = $destino_mensagem;

$htmlw="";

$htmlw.=" <div id='link_util'> ";
$htmlw.="<table class='link_util_table' width='100%' border='0' cellspacing='0' cellpadding='0' vspace='0' hspace='0'> ";
$htmlw.="<tr class='link_util_cab_tr'>  ";
$htmlw.="   <td class='link_util_cab_td' >".$msg."</td> ";
$htmlw.="</tr>";
$htmlw.="</table>";
$htmlw.=" </div> ";

echo $htmlw;

// Gravar Atendimento Resumo
$veio            = "BIA";
$idt_acao        = 1;
$idt_pendencia   = "";
//
$protocolo       = $_SESSION[CS]['g_bia_email_vet']['protocolo'];
$assunto         = "Impressão de Conteúdo BIA";
$titulobia=$_SESSION[CS]['g_bia_email_vet']['titulobia'];
$complemento_acao = $titulobia;
$link_util       = "";
$bia_conteudo    = $_SESSION[CS]['g_bia_email_vet']['html'];
$bia_enviada     = $htmlw;
$descricao       = "";
$descricao      .= $assunto;
$vetRetorno                    = Array();
$vetRetorno['veio']            = "BIA";
$vetRetorno['idt_acao']        = $idt_acao;
$vetRetorno['complemento_acao']       = $complemento_acao;
$vetRetorno['idt_pendencia']   = $idt_pendencia;
$vetRetorno['idt_atendimento'] = $idt_atendimento;
$vetRetorno['descricao']       = $descricao;
$vetRetorno['link_util']       = $link_util;
$vetRetorno['bia_conteudo']    = $bia_conteudo;
$vetRetorno['bia_enviada']     = $bia_enviada;

$vetRetorno['bia_acao']        = "IMPRESSÃO";

// Gera no Resumo a Pendência		
$ret = AtendimentoResumo($idt_atendimento,$vetRetorno);
if ($ret==0)
{
}


?>
<script>

$(document).ready(function () {
    window.print();
});

</script>