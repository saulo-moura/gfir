<style>
    div#pendencia {
        background:#FFFFFF;
        color:#000000;
        width:100%;
        display:block;
        xheight:200px;
        display:none;
        xborder:1px solid #2F2FFF;
        float:left;
        border-bottom:2px solid #2F2FFF;
    }

    div#pendencia_cab {
        background:#004080;
        color:#FFFFFF;
        width:100%;
        xdisplay:block;
        height:25px;
        text-align:center;
        padding-top:5px;
    }
    div#pendencia_det {
        background:#FFFFFF;
        color:#FFFFFF;
        width:100%;
        text-align:center;
        padding-top:5px;
        border-bottom:2px solid #004080;

    }
    div#pendencia_com {
        background:#F1F1F1;
        color:#FFFFFF;
        width:100%;
        text-align:center;
        padding-top:5px;

    }


    .table_pendencia_linha {

    }
    .table_pendencia_celula_label {
        color:#000000;
        text-align:right;

    }
    .table_pendencia_celula_value {
        color:#000000;
        text-align:left;
    }

    div#instrumento {
        background:#FFFFFF;
        color:#000000;
        width:100%;
        display:block;
        xheight:200px;
        display:none;
        border-bottom:2px solid #2F2FFF;
        float:left;
    }

    div#instrumento_cab {
        background:#004080;
        color:#FFFFFF;
        width:100%;
        xdisplay:block;
        height:25px;
        text-align:center;
        padding-top:5px;
    }
    div#instrumento_det {
        background:#FFFFFF;
        color:#FFFFFF;
        width:100%;
        text-align:center;
        padding-top:5px;
        border-bottom:2px solid #004080;

    }
    div#instrumento_com {
        background:#F1F1F1;
        color:#FFFFFF;
        width:100%;
        text-align:center;
        padding-top:5px;

    }


    .table_instrumento_linha {

    }
    .table_instrumento_celula_label {
        color:#000000;
        text-align:right;

    }
    .table_instrumento_celula_value {
        color:#000000;
        text-align:left;
    }


</style>
<?php
$tamdiv   = 32;
$largura  = 16;
$altura   = 16;


$fsize = '10px';

$tampadimg = $tamdiv - $largura;
$tamdiv    = $tamdiv.'px';
$tamlabel  = $tamdiv + $tampadimg;
$label     = $tamlabel.'px';
$pad       = $tampadimg.'px';
$padimg    = $tampadimg.'px';


$tit_1 = "Permite a alteração de um instrumento de atendimento com abordagem individual em outro sem a necessidade de retorno a tela principal do atendimento presencial. Nesses casos, a proposta é que seja apresentado ao usuário caixa de diálogo que permita a conversão";

$tit_2 = "Histórico do Cliente.";

$tit_3 = "Funcionalidade de consultar status de adimplência do CPF com o Sebrae Bahia.";

$tit_4 = "Funcionalidade de pesquisa a partir da entrada de dados, ou parte dele, de determinado campo.";

$tit_5 = "Apresenta pop-up com LINKS úteis ao processo de atendimento definidos pela administração do sistema.";


$tit_6 = "Abre tela de cadastro de pessoa física para adicioná-la ao processo de atendimento em andamento.";


$tit_7 = "Abre pop-up para pesquisa ativa de cliente.";


$tit_8 = "Funcionalidade que permite a inclusão do cliente como participante de evento (instrumentos de abordagem grupal/coletiva) durante o atendimento de orientação técnica.";

$tit_9 = "Abre pop-up com informações do programa de fidelidade vinculado ao cliente em atendimento.";


$tit_10 = "Abre pop-up com perguntas e respostas mais comuns. Solução adicional à base de informações para o atendimento. ";

$tit_11 = "Ferramenta para inserção de arquivos relacionados ao atendimento.";



// echo " <div  style='width:100%; color:#000000; float:left; border-top:1px solid #ABBBBF; border-bottom:1px solid #ABBBBF; '>";

    if ($idt_atendimento == '') {
        $idt_atendimento_tmp = 0;
    } else {
        $idt_atendimento_tmp = $idt_atendimento;
    }

    $onclick =  " onclick='return ConfirmaHistorico({$idt_atendimento_tmp}, \"$cnpj\");' ";


    echo " <div {$onclick} style='width:{$tamdiv}; color:#004080; font-size:14px; cursor:pointer; float:left;  margin-right:15px;  '>";
    echo "<div style='float:left; padding:{$pad}; xpadding-top:5px; padding-bottom:5px; '   >";
    echo " <img width='{$largura}'  height='{$altura}'  title='{$tit_2}' src='imagens/at_monitoramento.png' border='0'>";
    echo "</div>";
    echo "<div  title='{$tit_2}' style='width:{$label};  overflow:auto; display:block; float:left; text-align:center; font-size:{$fsize};  '>";
    echo " Histórico";
    echo "</div>";
    echo " </div>";


/*

echo " <div onclick='return ConfirmaFinanceiro({$idt_atendimento});' style='width:{$tamdiv}; color:#004080; font-size:14px; cursor:pointer; float:left;  margin-right:15px;  '>";
echo "<div style='float:left; padding:{$pad}; padding-top:5px; padding-bottom:5px;   '   >";
echo " <img width='{$largura}'  height='{$altura}'  title='{$tit_3}'  src='imagens/at_perguntas.png' border='0'>";
echo "</div>";
echo "<div title='{$tit_3}' style='width:{$label};  overflow:auto; display:block; float:left; text-align:center; font-size:{$fsize};  '>";
echo " Financeiro";
echo "</div>";
echo " </div>";


echo " <div onclick='return ConfirmaPesquisar({$idt_atendimento});' style='width:{$tamdiv}; color:#004080; font-size:14px; cursor:pointer; float:left;  margin-right:15px;  '>";
echo "<div style='float:left; padding:{$pad}; padding-top:5px; padding-bottom:5px;   '   >";
echo " <img width='{$largura}'  height='{$altura}'  title='{$tit_4}'  src='imagens/at_perguntas.png' border='0'>";
echo "</div>";
echo "<div title='{$tit_4}' style='width:{$label};  overflow:auto; display:block; float:left; text-align:center; font-size:{$fsize};  '>";
echo " Pesquisar";
echo "</div>";
echo " </div>";
*/



/*
echo " <div onclick='return ConfirmaPerguntasFrequentes({$idt_atendimento});' style='width:{$tamdiv}; color:#004080; font-size:14px; cursor:pointer; float:left;  margin-right:15px;  '>";
echo "<div style='float:left; padding:{$pad}; padding-top:5px; padding-bottom:5px;   '   >";
echo " <img width='{$largura}'  height='{$altura}'  title='{$tit_10}'  src='imagens/at_perguntas.png' border='0'>";
echo "</div>";
echo "<div title='{$tit_10}' style='width:{$label};  overflow:auto; display:block; float:left; text-align:center; font-size:{$fsize};  '>";
echo " Perguntas Frequentes";
echo "</div>";
echo " </div>";
echo " </div> ";
*/

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




    function ConfirmaHistorico(idt_atendimento,cnpj)
    {
        //alert('Em desenvolvimento!');
        var cpf = "";
        var id = 'cpf';
        objtp = document.getElementById(id);
        if (objtp != null) {
            cpf = objtp.value;
        }
        var codigo_siacweb = "";
        var id = 'codigo_siacweb';
        objtp = document.getElementById(id);
        if (objtp != null) {
            codigo_siacweb = objtp.value;
        }
        //
//        alert('Em desenvolvimento! == '+idt_atendimento+' cpf  '+cpf+' cnpj  '+cnpj);
        //
        var  left   = 0;
        var  top    = 0;
        var  height = $(window).height();
        var  width  = $(window).width();

        var par = '';
        par += '&codparceiro_atual=' + $('#codigo_siacweb').val();
        par += '&tipo_parceiro=F';
        par += '&cpfcnpj=' + $('#cpf').val();

        var link ='conteudo_historico.php?prefixo=inc&menu=grc_historicocliente' + par;
        historico =  window.open(link,"HistoricoCliente","left="+left+",top="+top+",width="+width+",height="+height+",location=no,resizable=yes,menubar=no,scrollbars=yes,toolbar=no,alwaysLowered=yes,alwaysRaised=no,dependent=yes,directories=no,hotkeys=no,menubar=no,personalbar=no,scrollbars=yes,status=no,titlebar=no,z-lock=yes,titlebar=no");
        historico.focus();
        return false;
    }

    function ConfirmaPerguntasFrequentes(idt_atendimento)
    {
        //alert(' Perguntas Frequentes '+idt_atendimento);
        var left = 100;
        var top = 100;
        var height = $(window).height() - 100;
        var width = $(window).width() * 0.8;
        var link = 'conteudo_atendimento_perguntas_frequentes.php?prefixo=inc&menu=atendimento_perguntas_frequentes&idt_atendimento=' + idt_atendimento;
        faq = window.open(link, "PerguntasFrequentes", "left=" + left + ",top=" + top + ",width=" + width + ",height=" + height + ",location=no,resizable=yes,menubar=no,scrollbars=yes,toolbar=no,alwaysLowered=yes,alwaysRaised=no,dependent=yes,directories=no,hotkeys=no,menubar=no,personalbar=no,scrollbars=yes,status=no,titlebar=no,z-lock=yes,titlebar=no");
        faq.focus();
    }

 function ConfirmaFinanceiro(idt_atendimento)
 {
        alert(' Financeiro - Funcionalidade a ser definida ');


 }
 
 function ConfirmaPesquisar(idt_atendimento)
 {
        alert(' Pesquisar - Funcionalidade a ser definida ');


 }
</script>
