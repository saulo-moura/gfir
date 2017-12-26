<style>
    .botao_ag {
        text-align:center;
        width:180px;
        height:35px;
        color:#FFFFFF;
        background:#2F65BB;
        font-size:14px;
        cursor:pointer;
        float:left;
        margin-top:20px;
        margin-right:10px;
        font-weight:bold;
    }
    .botao_ag:hover {
        background:#0000FF;


    }
    .botao_ag_bl {
        text-align:center;
        width:220px;
        height:50px;
        color:#FFFFFF;
        background:#2F65BB;
        font-size:14px;
        cursor:pointer;
        display: inline-block;
        padding-top:15px;
        margin-right:10px;
        font-weight:bold;

    }
    .botao_ag_bl:hover {
        background:#0000FF;
    }


    td.botao_concluir_atendimento_desc {
        background:#C0C0C0;
    }

</style>
<?php
//
$idt_avaliacao = $_GET['idt_avaliacao'];

//////////////////////// cabeçalho
$sql = "select  ";
$sql .= "   grc_a.*,  ";
$sql .= '   grc_nga.pdf_devolutiva, grc_nga.pdf_plano_facil, grc_nga.pdf_protocolo,';
$sql .= "   grc_at.protocolo as grc_at_protocolo,  ";
$sql .= "   grc_as.descricao as grc_as_descricao,  ";
$sql .= "   gec_eclio.descricao as gec_eclio_descricao, ";
$sql .= "   gec_eclip.descricao as gec_eclip_descricao, ";
$sql .= "   gec_ecreo.descricao as gec_ecreo_descricao, ";
$sql .= "   gec_ecrep.descricao as gec_ecrep_descricao ";
$sql .= " from grc_avaliacao grc_a ";
$sql .= " inner join grc_avaliacao_situacao grc_as on grc_as.idt = grc_a.idt_situacao ";
$sql .= " inner join grc_atendimento        grc_at on grc_at.idt = grc_a.idt_atendimento ";
$sql .= " inner join grc_nan_grupo_atendimento grc_nga on grc_nga.idt = grc_at.idt_grupo_atendimento ";
$sql .= " left join ".db_pir_gec."gec_entidade gec_eclio on gec_eclio.idt = grc_a.idt_organizacao_avaliado ";
$sql .= " left join ".db_pir_gec."gec_entidade gec_eclip on gec_eclip.idt = grc_a.idt_avaliado ";
$sql .= " left join ".db_pir_gec."gec_entidade gec_ecreo on gec_ecreo.idt = grc_a.idt_organizacao_avaliador ";
$sql .= " left join ".db_pir_gec."gec_entidade gec_ecrep on gec_ecrep.idt = grc_a.idt_avaliador ";
$sql .= " where grc_a.idt = ".null($idt_avaliacao);
$rs = execsql($sql);
foreach ($rs->data as $row) {
    $grc_at_protocolo = $row['grc_at_protocolo'];
    $codigo = $row['codigo'];
    $descricao = $row['descricao'];
    $data_avaliacao = trata_data($row['data_avaliacao']);
    $gec_eclio_descricao = $row['gec_eclio_descricao'];
    $gec_eclip_descricao = $row['gec_eclip_descricao'];
    $gec_ecreo_descricao = $row['gec_ecreo_descricao'];
    $gec_ecrep_descricao = $row['gec_ecrep_descricao'];
    $pdf_devolutiva = $row['pdf_devolutiva'];
    $pdf_plano_facil = $row['pdf_plano_facil'];
    $pdf_protocolo = $row['pdf_protocolo'];
}

verificaInfAvaliacaoNAN($idt_avaliacao, $gec_ecreo_descricao, $gec_ecrep_descricao, $gec_eclio_descricao, $gec_eclip_descricao);

//$background = '#2C3E50;';
$background = '#ECF0F1;';
$color = '#000000;';

//echo "<pagebreak />";

echo "<br />";

echo "<table border='0' cellspacing='0' cellpadding='0' width='100%' style='' >";


$background = '#FFFFFF;';
$color = '#000000;';

$stylo = "border:1px solid #C0C0C0;  padding:5px; font-family : Calibri, Arial, Helvetica, sans-serif; text-align:left; font-size:10pt; color:$color; background:$background;";
echo "<tr >";
echo "<td colspan='5' style='{$stylo} width:300px;' >";
echo "<span style='' >Empresa: <b> {$gec_eclio_descricao}</b></span>";
echo "</td>";
echo "</tr>";
echo "<tr>";
echo "<td  colspan='3' style='{$stylo} xwidth:50%; ' >";
echo "Data do Diagnóstico: <b>{$data_avaliacao}</b>";
echo "</td>";
echo "<td  colspan='2' style='{$stylo} xwidth:50%;' >";
echo "Cliente: <b>{$gec_eclip_descricao}</b>";
echo "</td>";
echo "</tr>";

echo "<tr>";
echo "<td  colspan='3' style='{$stylo}' >";
echo "Agente de Orientação Empresarial: <b>{$gec_ecrep_descricao}</b>";
echo "</td>";
echo "<td  colspan='2' style='{$stylo}' >";
echo "Protocolo da 1a Visita: <b>{$grc_at_protocolo}</b>";
echo "</td>";

echo "</tr>";
echo "</table>";


echo "<br /><br />";

////////////////////////
//  		  
$faztodos = 0;
$faz_de = 0;
$faz_pf = 0;
$faz_pr = 0;
if ($veio == 'DE') {
    if ($pdf_devolutiva == "" and $pdf_plano_facil == "" and $pdf_protocolo == "") {
        $faztodos = 1;
    } else {

        echo "<table  border='0' cellspacing='0' cellpadding='0' width='100%'  >";
        echo "<tr>";

        if ($pdf_devolutiva != "") {
            $pathPDF = "obj_file/grc_nan_grupo_atendimento/".$pdf_devolutiva;

            echo "<td>";
            echo "<a id='pdf_devolutiva' target='_blank' href='{$pathPDF}'>";
            echo " <div class='botao_ag_bl' title='Devolutiva em PDF e possibilita imprimir'  >";
            echo " <div style='margin:8px; ' >Devolutiva</div>";
            echo " </div>";
            echo "</a>";
            echo "</td>";
        } else {
            $faz_de = 1;
        }
        if ($pdf_plano_facil != "") {
            $pathPDF = "obj_file/grc_nan_grupo_atendimento/".$pdf_plano_facil;

            echo "<td>";
            echo "<a id='pdf_plano_facil' target='_blank' href='{$pathPDF}'>";
            echo " <div class='botao_ag_bl' title='Plano Fácil em PDF e possibilita imprimir'  >";
            echo " <div style='margin:8px; ' >Plano Fácil</div>";
            echo " </div>";
            echo "</a>";
            echo "</td>";
        } else {
            $faz_pf = 1;
        }
        if ($pdf_protocolo != "") {
            $pathPDF = "obj_file/grc_nan_grupo_atendimento/".$pdf_protocolo;

            echo "<td>";
            echo "<a id='pdf_protocolo' target='_blank' href='{$pathPDF}'>";
            echo " <div class='botao_ag_bl' title='Protocolo em PDF e possibilita imprimir'  >";
            echo " <div style='margin:8px; ' >Protocolo da 2a Visita</div>";
            echo " </div>";
            echo "</a>";
            echo "</td>";
        } else {
            $faz_pr = 1;
        }
        echo "<td>";
        echo " <div class='botao_ag_bl' title='Visualizar Relatórios em PDF e possibilita imprimir' onclick='return VisualizarRelatoriosPDF($idt_avaliacao);' >";
        echo " <div style='margin:8px; ' >Devolutiva, Plano Fácil e Protocolo</div>";
        echo " </div>";
        echo "</td>";

        echo "</tr>";

        echo "<tr>";
        echo "<td colspan='4' align='center'>";
        echo " <br /><div class='botao_ag_bl' title='Regerar os PDF' onclick='return regerarPDF($idt_avaliacao);' >";
        echo " <div style='margin:8px; ' >Regerar os PDF</div>";
        echo " </div>";
        echo "</td>";
        echo "</tr>";

        echo "</table>";
    }
}

if ($faztodos == 1 or $faz_de == 1 or $faz_pf == 1 or $faz_pr == 1) {
    echo "<table  border='0' cellspacing='0' cellpadding='0' width='100%'  >";
    echo "<tr>";
    echo "<td style='text-align:center; padding:10px; font-size:16px; background:#FFFFFF; color:#red; font-weight: bold; '>";
    echo " <div class='botao_help' title='Explicações sobre essa funcionalidade'  >";
    echo " Por favor, aguarde.<br /><br />";
    echo " Gerando documentos em PDF para Visualização.<br />";
    echo " </div>";
    echo "</td>";
    echo "</tr>";
    echo "</table>";
} else {

    if ($num_visita_atu == 1) {
        echo "<br/>";

        echo "<table  border='0' cellspacing='0' cellpadding='0' width='100%'  >";
        echo "<tr>";


        echo "<td style='text-align:center; padding:10px; font-size:16px;'>";
        echo " <div class='botao_help' title='Explicações sobre essa funcionalidade'  >";
        echo " <b>Antes de clicar em 'Inicializar 2a Visita'</b><br /> Verificar e validar os documentos 'Devolutiva', 'Plano Fácil' e Protocolo 2a Visita'.<br />";
        echo " <b>Utilizar os Botões acima para ter acesso aos documentos em PDF.<br /><br />";



        echo " A funcionalidade <b>'Inicializar 2a Visita'</b> gera a 2a Visita e possibilita o acesso ao Registro.<br />";
        echo " </div>";
        echo "</td>";
        echo "</tr>";

        echo "<tr>";
        echo "<td style='text-align:center;'>";
        //echo " <div class='botao_ag_bl' title='Inicializa 2a Visita' onclick='return ProtocoloSegundaVisita($idt_avaliacao);'>";
        echo " <div class='botao_ag_bl' title='Inicializa 2a Visita' onclick='return Inicializar2visita($idt_avaliacao);'>";
        echo " <div style='margin:8px; '>Inicializar 2a Visita</div>";
        echo " </div>";

//		echo " <div class='botao_ag_bl' title='Visualizar Relatórios em PDF e possibilita imprimir' onclick='return posiciona_devolutiva($idt_avaliacao);' >";
//		echo " <div style='margin:8px; ' >Posiciona {$veio} {$faztodos} em PDF</div>";
//		echo " </div>";
        echo "</td>";
        echo "</tr>";

        echo "</table>";
    } else {
        
    }
}
?>
<script>


    var idt_avaliacao = <?php echo $idt_avaliacao; ?>;

    var faztodos = <?php echo $faztodos; ?>;
    var faz_de = <?php echo $faz_de; ?>;
    var faz_pf = <?php echo $faz_pf; ?>;
    var faz_pr = <?php echo $faz_pr; ?>;

    var gerar_de = false;
    var gerar_pf = false;
    var gerar_pr = false;
    var reloadOK = false;
    
    $(document).ready(function () {
        if (faztodos == 1 || faz_de == 1) {
            reloadOK = true;
            DevolutivaPDF(idt_avaliacao);
        } else {
            gerar_de = true;
        }

        if (faztodos == 1 || faz_pf == 1) {
            reloadOK = true;
            PlanoFacilPDF(idt_avaliacao);
        } else {
            gerar_pf = true;
        }

        if (faztodos == 1 || faz_pr == 1) {
            reloadOK = true;
            ProtocoloPDF(idt_avaliacao);
        } else {
            gerar_pr = true;
        }

        if (reloadOK) {
            geraOK();
        }
    });

    function geraOK() {
        if (gerar_de && gerar_pf && gerar_pr) {
            location.reload();
        }
    }

    function posiciona_devolutiva(idt_avaliacao)
    {
        // alert('teste'+pdf_devolutiva);
        pdf_devolutiva.focus();
    }
    function VisualizarRelatoriosPDF(idt_avaliacao)
    {
        $('#pdf_devolutiva')[0].click();
        $('#pdf_plano_facil')[0].click();
        $('#pdf_protocolo')[0].click();
    }

    function regerarPDF(idt_avaliacao)
    {
        var mensagem = "Confirma a regeração dos PDF?";
        if (confirm(mensagem)) {
            $.ajax({
                type: 'POST',
                url: 'ajax_grc.php?tipo=PlanoFacilRegerarPDF',
                data: {
                    cas: conteudo_abrir_sistema,
                    idt_avaliacao: idt_avaliacao
                },
                success: function (response) {
                    if (response != '') {
                        alert(response);
                    } else
                    {
                        location.reload();
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert('Erro no ajax no: ' + textStatus + ' - ' + errorThrown);
                },
                async: false
            });
        }
    }

    function DevolutivaPDF(idt_avaliacao)
    {
        if (arqGraficoGerado === true && arqGraficoGerado27 === true) {
            $.ajax({
                dataType: 'json',
                type: 'POST',
                url: 'ajax_grc.php?tipo=DevolutivaPDF',
                data: {
                    cas: conteudo_abrir_sistema,
                    idt_avaliacao: idt_avaliacao
                },
                success: function (response) {
                    if (response.erro != '') {
                        alert(url_decode(response.erro));
                    } else
                    {
                        gerar_de = true;
                        geraOK();
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert('Erro no ajax no: ' + textStatus + ' - ' + errorThrown);
                },
                async: false
            });
        } else {
            setTimeout(DevolutivaPDF, 1000, idt_avaliacao);
        }
    }

    function PlanoFacilPDF(idt_avaliacao)
    {
        // alert('plano Fácil ==== '+idt_avaliacao);
        $.ajax({
            dataType: 'json',
            type: 'POST',
            url: 'ajax_grc.php?tipo=PlanoFacilPDF',
            data: {
                cas: conteudo_abrir_sistema,
                idt_avaliacao: idt_avaliacao
            },
            success: function (response) {
                if (response.erro != '') {
                    alert(url_decode(response.erro));
                } else
                {
                    gerar_pf = true;
                    geraOK();
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert('Erro no ajax no: ' + textStatus + ' - ' + errorThrown);
            },
            async: false
        });

    }
    function ProtocoloPDF(idt_avaliacao)
    {
        // alert('protocolo ==== '+idt_avaliacao);
        $.ajax({
            dataType: 'json',
            type: 'POST',
            url: 'ajax_grc.php?tipo=ProtocoloPDF',
            data: {
                cas: conteudo_abrir_sistema,
                idt_avaliacao: idt_avaliacao
            },
            success: function (response) {
                if (response.erro != '') {
                    alert(url_decode(response.erro));
                } else
                {
                    gerar_pr = true;
                    geraOK();
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert('Erro no ajax no: ' + textStatus + ' - ' + errorThrown);
            },
            async: false
        });

    }
    function PlanoFacil(idt_avaliacao)
    {
        //alert('idt avaliação = '+idt_avaliacao);
        var left = 100;
        var top = 100;
        var height = $(window).height() - 100;
        var width = $(window).width() * 0.8;


        var left = 0;
        var top = 0;
        var height = $(window).height();
        var width = $(window).width();


        var link = 'conteudo_plano_facil.php?prefixo=inc&menu=grc_nan_plano_facil&idt_avaliacao=' + idt_avaliacao + '&str=' + str;
        var str = "";
        planofacil = window.open(link, "PlanoFacil", "left=" + left + ",top=" + top + ",width=" + width + ",height=" + height + ",location=no,resizable=yes,menubar=no,scrollbars=yes,toolbar=no,alwaysLowered=yes,alwaysRaised=no,dependent=yes,directories=no,hotkeys=no,menubar=no,personalbar=no,scrollbars=yes,status=no,titlebar=no,z-lock=yes,titlebar=no");
        planofacil.focus();
        //        $('#bt_voltar').click();
    }

    function ProtocoloSegundaVisita(idt_avaliacao)
    {
        //$('#bt_voltar').click();
        var left = 0;
        var top = 0;
        var height = $(window).height();
        var width = $(window).width();


        var link = 'conteudo_nan_protocolo_2.php?prefixo=inc&menu=grc_nan_protocolo_segunda_visita&idt_avaliacao=' + idt_avaliacao + '&str=' + str;
        var str = "";
        Protocolo2Visita = window.open(link, "Protocolo2Visita", "left=" + left + ",top=" + top + ",width=" + width + ",height=" + height + ",location=no,resizable=yes,menubar=no,scrollbars=yes,toolbar=no,alwaysLowered=yes,alwaysRaised=no,dependent=yes,directories=no,hotkeys=no,menubar=no,personalbar=no,scrollbars=yes,status=no,titlebar=no,z-lock=yes,titlebar=no");
        Protocolo2Visita.focus();



    }

    function Inicializar2visita(idt_avaliacao)
    {
        var mensagem = "Confirma a Inicialização da 2a Visita?";
        if (confirm(mensagem)) {
            processando();
            setTimeout(Inicializar2visitaAcao, 1000, idt_avaliacao);
        }

    }

    function Inicializar2visitaAcao(idt_avaliacao) {
        if (arqGraficoGerado === true) {
            $.ajax({
                dataType: 'json',
                type: 'POST',
                url: 'ajax_grc.php?tipo=InicializaSegundaVisita',
                data: {
                    cas: conteudo_abrir_sistema,
                    idt_avaliacao: idt_avaliacao
                },
                success: function (response) {
                    $('#dialog-processando').remove();

                    if (response.erro != '') {
                        alert(url_decode(response.erro));
                    } else
                    {
                        alert('Inicialização da 2a Visita Atendimento NAN Obteve SUCESSO.' + "\n\n" + 'Tecle OK para continuar.' + "\n\n");
                        // $('#retornar_a').click();
                        //top.close();
                        location.reload();
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    $('#dialog-processando').remove();
                    alert('Erro no ajax no: ' + textStatus + ' - ' + errorThrown);
                },
                async: false
            });
        } else {
            setTimeout(Inicializar2visitaAcao, 1000, idt_avaliacao);
        }
    }

    function Voltar()
    {
        $('#bt_voltar').click();
    }
</script>