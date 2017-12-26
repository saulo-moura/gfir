<style type="text/css">
    .iq_tit {
        background:#2A5696;
        color:#FFFFFF;
        font-size:16px;
        text-align:center;
        border-bottom:1px solid #FFFFFF;
        border-top:1px solid #FFFFFF;
        padding:5px;
    }
    .iq_cab {
        background:#C0C0C0;
        color:#000000;
        font-size:14px;
        text-align:center;
        border-bottom:1px solid #FFFFFF;
        border-top:1px solid #FFFFFF;
        padding:5px;
    }
    .iq_lin {
        background:#FFFFFF;
        color:#000000;
        font-size:14px;
        text-align:left;
        border-bottom:1px solid #C0C0C0;
        padding:5px;

    }
    .iq_tt {
        background:#0000FF;
        color:#FFFFFF;
        font-size:14px;
        text-align:left;
        border-bottom:1px solid #C0C0C0;
        padding:5px;

    }
    .iq_ttg {
        background:#FF0000;
        color:#FFFFFF;
        font-size:14px;
        text-align:left;
        border-bottom:1px solid #C0C0C0;
        padding:5px;

    }
</style>
<?php
$vetIN_T = Array();
$vetIN_T[1] = "COMPLETUDE DO CADASTRO";
$vetIN_T[2] = "CONFIABILIDADE DAS INFORMAÇÕES DO CADASTRO DE PESSOA FISICA";
$vetIN_T[3] = "DUPLICIDADE DE DADOS EM CADASTROS DISTINTOS";
$vetIN_T[4] = "VALIDAÇÃO DE EMAIL (NÃO IMPLEMENTADO)";
$vetIN_T[5] = "QUALIDADE DE ATENDIMENTO";

$vetIN_D = Array();
$vetIN_D[1] = "COMPLETUDE DO CADASTRO";
$vetIN_D[2] = "CONFIABILIDADE DAS INFORMAÇÕES DO CADASTRO DE PESSOA FISICA";
$vetIN_D[3] = "DUPLICIDADE DE DADOS EM CADASTROS DISTINTOS";
$vetIN_D[4] = "VALIDAÇÃO DE EMAIL (NÃO IMPLEMENTADO)";
$vetIN_D[5] = "QUALIDADE DE ATENDIMENTO";

$ano_base = '2017';
$tabela_ref_iq = " grc_dw_{$ano_base}_iq ";
$sql = "select ";
$sql .= " * ";
$sql .= " from {$tabela_ref_iq} ";
$sql .= ' order by unidade_regional, ponto_atendimento';
//$rsl = execsql($sql, true, null, array(), PDO::FETCH_ASSOC);
$rsl = execsql($sql);

echo "<table class='' width='100%' border='0' cellspacing='0' cellpadding='0' vspace='0' hspace='0'> ";
echo "<tr class=''>  ";
echo "   <td colspan='8' class='iq_tit' style='' >Ano de {$ano_base}</td> ";
echo "</tr>";
$hint1 = $vetIN_T[1];
$hint2 = $vetIN_T[2];
$hint3 = $vetIN_T[3];
$hint4 = $vetIN_T[4];
$hint5 = $vetIN_T[5];
echo "<tr class=''>  ";
echo "   <td  class='iq_cab' title='' style='border-right:1px solid #C0C0C0;'>Unidade Regional</td> ";
echo "   <td  class='iq_cab' title='' style='border-right:1px solid #C0C0C0;'>Ponto de Atendimento</td> ";
echo "   <td  class='iq_cab' title='{$hint1}' style='border-right:1px solid #C0C0C0;'>Indicador 1</td> ";
echo "   <td  class='iq_cab' title='{$hint2}' style='border-right:1px solid #C0C0C0;'>Indicador 2</td> ";
echo "   <td  class='iq_cab' title='{$hint3}' style='border-right:1px solid #C0C0C0;'>Indicador 3</td> ";
echo "   <td  class='iq_cab' title='{$hint4}' style='border-right:1px solid #C0C0C0;'>Indicador 4</td> ";
echo "   <td  class='iq_cab' title='{$hint5}' style='border-right:1px solid #C0C0C0;'>Indicador 5</td> ";
echo "   <td  class='iq_cab' style=''>GERAL</td> ";
echo "</tr>";
//p($rowl);
$indicador_1urt = 0;
$indicador_2urt = 0;
$indicador_3urt = 0;
$indicador_4urt = 0;
$indicador_5urt = 0;
$indicador_gurt = 0;
$quantidade_gurt = 0;


$indicador_1t = 0;
$indicador_2t = 0;
$indicador_3t = 0;
$indicador_4t = 0;
$indicador_5t = 0;
$indicador_gt = 0;
$quantidade_gt = 0;
$quantidade_gpat = 0;
$ur = "##";
ForEach ($rsl->data as $rowl) {
    $idt_ponto_atendimento = $rowl['idt_ponto_atendimento'];
    $unidade_regional = $rowl['unidade_regional'];
    $ponto_atendimento = $rowl['ponto_atendimento'];
    $indicador_1 = $rowl['indicador_1'];
    $indicador_2 = $rowl['indicador_2'];
    $indicador_3 = $rowl['indicador_3'];
    $indicador_4 = $rowl['indicador_4'];
    $indicador_5 = $rowl['indicador_5'];
    $indicador_g = $rowl['indicador_g'];
    $quantidade_gt = $quantidade_gt + 1;
    $unidade_regionalw = $unidade_regional;
    if ($ur != $unidade_regional) {
        if ($ur != "##") {
            // Quebra de UR
            $indicador_1urt = $indicador_1urt / $quantidade_gurt;
            $indicador_2urt = $indicador_2urt / $quantidade_gurt;
            $indicador_3urt = $indicador_3urt / $quantidade_gurt;
            $indicador_4urt = $indicador_4urt / $quantidade_gurt;
            $indicador_5urt = $indicador_5urt / $quantidade_gurt;
            $indicador_4urt = 0;
            $indicador_gf = ($indicador_1urt + $indicador_2urt + $indicador_3urt + $indicador_4urt + $indicador_5urt) / 4;
            $indicador_gf = format_decimal($indicador_gf, 2);

            $indicador_1f = format_decimal($indicador_1urt, 2);
            $indicador_2f = format_decimal($indicador_2urt, 2);
            $indicador_3f = format_decimal($indicador_3urt, 2);
            $indicador_4f = format_decimal($indicador_4urt, 2);
            $indicador_5f = format_decimal($indicador_5urt, 2);
            //$indicador_gf       = format_decimal($indicador_gurt,2); 

            $indicador_4f = "";
            echo "<tr class=''>  ";
            echo "   <td  colspan='2' class='iq_tt' style='text-align:right; border-right:1px solid #C0C0C0;'>TOTAL  UR</td> ";
            echo "   <td  class='iq_tt' style='text-align:right; padding-right:10px; border-right:1px solid #C0C0C0;'>$indicador_1f</td> ";
            echo "   <td  class='iq_tt' style='text-align:right; padding-right:10px; border-right:1px solid #C0C0C0;'>$indicador_2f</td> ";
            echo "   <td  class='iq_tt' style='text-align:right; padding-right:10px; border-right:1px solid #C0C0C0;'>$indicador_3f</td> ";
            echo "   <td  class='iq_tt' style='text-align:right; padding-right:10px; border-right:1px solid #C0C0C0; background:#F1F1F1;'>$indicador_4f</td> ";
            echo "   <td  class='iq_tt' style='text-align:right; padding-right:10px; border-right:1px solid #C0C0C0;'>$indicador_5f</td> ";
            echo "   <td  class='iq_tt' style='text-align:right; padding-right:10px; '>$indicador_gf</td> ";
            echo "</tr>";
        }
        $indicador_1urt = 0;
        $indicador_2urt = 0;
        $indicador_3urt = 0;
        $indicador_4urt = 0;
        $indicador_5urt = 0;
        $indicador_gurt = 0;
        $quantidade_gurt = 0;
    } else {
        $unidade_regionalw = "";
    }
    $ur = $unidade_regional;


    $indicador_1urt = $indicador_1urt + $indicador_1;
    $indicador_2urt = $indicador_2urt + $indicador_2;
    $indicador_3urt = $indicador_3urt + $indicador_3;
    $indicador_4urt = $indicador_4urt + $indicador_4;
    $indicador_5urt = $indicador_5urt + $indicador_5;

    $quantidade_gurt = $quantidade_gurt + 1;

    $quantidade_gpat = $quantidade_gpat + 1;




    $indicador_1t = $indicador_1t + $indicador_1;
    $indicador_2t = $indicador_2t + $indicador_2;
    $indicador_3t = $indicador_3t + $indicador_3;
    $indicador_4t = $indicador_4t + $indicador_4;
    $indicador_5t = $indicador_5t + $indicador_5;
    $indicador_4 = 0;
    $indicador_gf = ($indicador_1 + $indicador_2 + $indicador_3 + $indicador_4 + $indicador_5) / 4;
    $indicador_gf = format_decimal($indicador_gf, 2);





    $indicador_1f = format_decimal($rowl['indicador_1'], 2);
    $indicador_2f = format_decimal($rowl['indicador_2'], 2);
    $indicador_3f = format_decimal($rowl['indicador_3'], 2);
    $indicador_4f = format_decimal($rowl['indicador_4'], 2);
    $indicador_5f = format_decimal($rowl['indicador_5'], 2);
    //$indicador_gf       = format_decimal($rowl['indicador_g'],2); 



    $indicador_4f = "";

    $clique_i1 = " onclick=' return ChamaIndicador({$idt_ponto_atendimento}, 1) ';   ";
    $clique_i2 = " onclick=' return ChamaIndicador({$idt_ponto_atendimento}, 2) ';   ";
    $clique_i3 = " onclick=' return ChamaIndicador({$idt_ponto_atendimento}, 3) ';   ";
    $clique_i5 = " onclick=' return ChamaIndicador({$idt_ponto_atendimento}, 5) ';   ";



    echo "<tr class=''>  ";
    echo "   <td  class='iq_lin' style='border-right:1px solid #C0C0C0;'>$unidade_regionalw</td> ";
    echo "   <td  class='iq_lin' style='border-right:1px solid #C0C0C0;'>$ponto_atendimento</td> ";
    echo "   <td  class='iq_lin' {$clique_i1} style='cursor:pointer; text-align:right; padding-right:10px; border-right:1px solid #C0C0C0;'>$indicador_1f</td> ";
    echo "   <td  class='iq_lin' {$clique_i2} style='cursor:pointer; text-align:right; padding-right:10px; border-right:1px solid #C0C0C0;'>$indicador_2f</td> ";
    echo "   <td  class='iq_lin' {$clique_i3} style='cursor:pointer; text-align:right; padding-right:10px; border-right:1px solid #C0C0C0;'>$indicador_3f</td> ";
    echo "   <td  class='iq_lin' style='text-align:right; padding-right:10px; border-right:1px solid #C0C0C0; background:#F1F1F1;'>$indicador_4f</td> ";
    echo "   <td  class='iq_lin' {$clique_i5} style='cursor:pointer; text-align:right; padding-right:10px; border-right:1px solid #C0C0C0;'>$indicador_5f</td> ";
    echo "   <td  class='iq_lin' style='text-align:right; padding-right:10px; '>$indicador_gf</td> ";
    echo "</tr>";
}





if ($ur != "##") {
    // Quebra de UR
    $indicador_1urt = $indicador_1urt / $quantidade_gurt;
    $indicador_2urt = $indicador_2urt / $quantidade_gurt;
    $indicador_3urt = $indicador_3urt / $quantidade_gurt;
    $indicador_4urt = $indicador_4urt / $quantidade_gurt;
    $indicador_5urt = $indicador_5urt / $quantidade_gurt;
    $indicador_4urt = 0;
    $indicador_gf = ($indicador_1urt + $indicador_2urt + $indicador_3urt + $indicador_4urt + $indicador_5urt) / 4;
    $indicador_gf = format_decimal($indicador_gf, 2);
    //
    $indicador_1f = format_decimal($indicador_1urt, 2);
    $indicador_2f = format_decimal($indicador_2urt, 2);
    $indicador_3f = format_decimal($indicador_3urt, 2);
    $indicador_4f = format_decimal($indicador_4urt, 2);
    $indicador_5f = format_decimal($indicador_5urt, 2);
    //$indicador_gf       = format_decimal($indicador_gurt,2); 
    //
				$indicador_4f = "";
    echo "<tr class=''>  ";
    echo "   <td  colspan='2' class='iq_tt' style='text-align:right; border-right:1px solid #C0C0C0;'>TOTAL UR</td> ";
    echo "   <td  class='iq_tt' style='text-align:right; padding-right:10px; border-right:1px solid #C0C0C0;'>$indicador_1f</td> ";
    echo "   <td  class='iq_tt' style='text-align:right; padding-right:10px; border-right:1px solid #C0C0C0;'>$indicador_2f</td> ";
    echo "   <td  class='iq_tt' style='text-align:right; padding-right:10px; border-right:1px solid #C0C0C0;'>$indicador_3f</td> ";
    echo "   <td  class='iq_tt' style='text-align:right; padding-right:10px; border-right:1px solid #C0C0C0; background:#F1F1F1;'>$indicador_4f</td> ";
    echo "   <td  class='iq_tt' style='text-align:right; padding-right:10px; border-right:1px solid #C0C0C0;'>$indicador_5f</td> ";
    echo "   <td  class='iq_tt' style='text-align:right; padding-right:10px; '>$indicador_gf</td> ";
    echo "</tr>";
}









$indicador_1t = $indicador_1t / $quantidade_gpat;
$indicador_2t = $indicador_2t / $quantidade_gpat;
$indicador_3t = $indicador_3t / $quantidade_gpat;
$indicador_4t = $indicador_4t / $quantidade_gpat;
$indicador_5t = $indicador_5t / $quantidade_gpat;



$indicador_1f = format_decimal($indicador_1t, 2);
$indicador_2f = format_decimal($indicador_2t, 2);
$indicador_3f = format_decimal($indicador_3t, 2);
$indicador_4f = format_decimal($indicador_4t, 2);
$indicador_5f = format_decimal($indicador_5t, 2);
//$indicador_gf       = format_decimal($indicador_gt,2); 
$indicador_4t = 0;
$indicador_gf = ($indicador_1t + $indicador_2t + $indicador_3t + $indicador_4t + $indicador_5t) / 4;
$indicador_gf = format_decimal($indicador_gf, 2);


$indicador_4f = "";

echo "<tr class=''>  ";
echo "   <td  colspan='2' class='iq_ttg' style='text-align:right; border-right:1px solid #C0C0C0;'>TOTAL GERAL</td> ";
echo "   <td  class='iq_ttg' style='text-align:right; padding-right:10px; border-right:1px solid #C0C0C0;'>$indicador_1f</td> ";
echo "   <td  class='iq_ttg' style='text-align:right; padding-right:10px; border-right:1px solid #C0C0C0;'>$indicador_2f</td> ";
echo "   <td  class='iq_ttg' style='text-align:right; padding-right:10px; border-right:1px solid #C0C0C0;'>$indicador_3f</td> ";
echo "   <td  class='iq_ttg' style='text-align:right; padding-right:10px; border-right:1px solid #C0C0C0; background:#F1F1F1;'>$indicador_4f</td> ";
echo "   <td  class='iq_ttg' style='text-align:right; padding-right:10px; border-right:1px solid #C0C0C0;'>$indicador_5f</td> ";
echo "   <td  class='iq_ttg' style='text-align:right; padding-right:10px; '>$indicador_gf</td> ";
echo "</tr>";

echo "</table>";
?>
<script type="text/javascript" >

    function ChamaIndicador(idt_ponto_atendimento, indicador)
    {
        var left = 10;
        var top = 10;
        var height = $(window).height() - 0;
        var width = $(window).width() - 20;
        var link = 'conteudo_indicador_qd_det.php?prefixo=listar&menu=grc_indicador_q' + indicador + '&idt_ponto_atendimento=' + idt_ponto_atendimento + '&veio_at=INQ' + indicador;
        IndicadorQ1 = window.open(link, "linkIndicadorQ" + indicador + 'PA' + idt_ponto_atendimento, "left=" + left + ",top=" + top + ",width=" + width + ",height=" + height + ",location=no,resizable=yes,menubar=no,scrollbars=yes,toolbar=no,alwaysLowered=yes,alwaysRaised=no,dependent=yes,directories=no,hotkeys=no,menubar=no,personalbar=no,scrollbars=yes,status=no,titlebar=no,z-lock=yes,titlebar=no");
        IndicadorQ1.focus();

    }
</script>
