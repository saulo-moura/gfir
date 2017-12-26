<style>
    div#pendencia {
        background:#FFFFFF;
        color:#000000;
        width:100%;
        display:block;
        display:none;
        float:left;
        border-bottom:2px solid #2F2FFF;
    }

    div#pendencia_cab {
        background:#004080;
        color:#FFFFFF;
        width:100%;
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
        display:none;
        border-bottom:2px solid #2F2FFF;
        float:left;
    }

    div#instrumento_cab {
        background:#004080;
        color:#FFFFFF;
        width:100%;
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

    #msgTroca {
        color: red;
        padding: 10px;
    }
</style>
<?php
$tamdiv  = 50;
$largura = 25;
$altura  = 25;

$tamdiv  = 32;
$largura = 32;
$altura  = 32;

$fsize = '10px';

$tampadimg = $tamdiv - $largura;
$tamdiv    = $tamdiv . 'px';
$tamlabel  = $tamdiv + $tampadimg;
$label     = $tamlabel . 'px';
$pad       = $tampadimg . 'px';
$padimg    = $tampadimg . 'px';


$tit_1 = "Histórico do Atendimento";


echo " <div  style='width:100%; color:#000000; float:left; xborder-top:1px solid #ABBBBF; xborder-bottom:1px solid #ABBBBF; '>";

echo " <div onclick='return HistoricoCliente();' style='width:{$tamdiv}; color:#004080; font-size:14px; cursor:pointer; float:left;  margin-right:15px;  '>";

echo "<div style='float:left; padding:{$pad}; padding-top:0px; padding-left:10px; '   >";
echo " <img width='{$largura}'  height='{$altura}'  title='{$tit_1}' src='imagens/at_monitoramento.png' border='0'>";
echo "</div>";
echo "<span style='font-size:11px;'>Histórico</span>";

echo "</div>";
echo "</div>";


			

?>
<script>
    var idt_atendimento   = '<?php echo $idt_atendimento; ?>';
    var cpf               = '<?php echo $cpf_atendimento; ?>';
	var codparceiro_atual = '<?php echo $codparceiro_atual; ?>';

    $(document).ready(function () {

    });
    function HistoricoCliente()
    {
        // alert(' LINKs '+idt_atendimento);
        var left = 0;
        var top = 0;
        var height = $(window).height();
        var width = $(window).width();
// conteudo_historico.php?prefixo=inc&menu=grc_historicocliente&codparceiro_atual=261517279&tipo_parceiro=F&cpfcnpj=061846425-53
        var link = 'conteudo_historico.php?prefixo=inc&menu=grc_historicocliente&codparceiro_atual=' + codparceiro_atual+"&tipo_parceiro=F&cpfcnpj="+cpf;
        linkutil = window.open(link, "linkutil", "left=" + left + ",top=" + top + ",width=" + width + ",height=" + height + ",location=no,resizable=yes,menubar=no,scrollbars=yes,toolbar=no,alwaysLowered=yes,alwaysRaised=no,dependent=yes,directories=no,hotkeys=no,menubar=no,personalbar=no,scrollbars=yes,status=no,titlebar=no,z-lock=yes,titlebar=no");
        linkutil.focus();



    }
</script>
