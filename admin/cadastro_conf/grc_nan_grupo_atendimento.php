<?php
$tabela = 'grc_nan_grupo_atendimento';
$id = 'idt';
$idt_atendimento = 0;
$idt_avaliacao = "";
$sql = "select ";
$sql .= "grc_at.*, ";
$sql .= "grc_ga.*, ";
$sql .= " grc_a.idt as grc_a_idt ";
$sql .= " from grc_nan_grupo_atendimento grc_ga ";
$sql .= " inner join  grc_atendimento grc_at on grc_at.idt_grupo_atendimento = grc_ga.idt ";
$sql .= " left  join  grc_avaliacao   grc_a  on grc_a.idt_atendimento = grc_at.idt ";
$sql .= " where grc_ga.idt = " . null($_GET['id']);
$sql .= "   and grc_at.nan_num_visita = 1 ";
$rs = execsql($sql);
$num_visita_atu = "";
$pdf_devolutiva = "";
$pdf_plano_facil = "";
$pdf_protocolo = "";

ForEach ($rs->data as $row) {
    $protocolo = $row['protocolo'];
    $idt_atendimento = $row['idt'];
    $idt_avaliacao = $row['grc_a_idt'];
    $num_visita_atu = $row['num_visita_atu'];
    $pdf_devolutiva = $row['pdf_devolutiva'];
    $pdf_plano_facil = $row['pdf_plano_facil'];
    $pdf_protocolo = $row['pdf_protocolo'];
}

if ($pdf_devolutiva == '' || $pdf_plano_facil == '' || $pdf_protocolo == '' || $num_visita_atu == 1) {
    $htmlDE = true;
} else {
    $htmlDE = false;
}

$msg_alerta = "";
$msg_alerta .= "<span style='font-size:18px; ' >Processo esta na Visita {$num_visita_atu}.</span>";
if ($num_visita_atu > 1) {
    $msg_alerta .= "<br />Documentos podem ser Visualizados em formato Definitivo";
    alert($msg_alerta);
} else {
    if ($pdf_devolutiva == '' and $pdf_plano_facil == '' and $pdf_protocolo == '') {
        
    } else {
        $msg_alerta .= "<br />Documentos podem ser Visualizados em formato Rascunho";
        alert($msg_alerta);
    }
}
if ($veio == 'DE') {
    $msg = "";
    if ($pdf_devolutiva == "") {
        $msg .= "Devolutiva sendo gerada em PDF.<br />";
    }
    if ($pdf_plano_facil == "") {
        $msg .= "Plano Fácil sendo gerada em PDF.<br />";
    }
    if ($pdf_protocolo == "") {
        $msg .= "Protocolo Rascunho sendo gerada em PDF.<br />";
    }
    //alert("<span style='font-size:18px; ' >{$msg}</span>");
}


$direto = 1;
//p($_POST);
//p($_REQUEST);
$veio = $_REQUEST['veio'];
$_GET['idt_avaliacao'] = $idt_avaliacao;

if ($veio == 'DE') {
    if ($idt_avaliacao != "") {
        $vetFrm = Array();
        $vetParametros = Array();

        if ($htmlDE) {
            $Require_Once = "cadastro_conf/grc_nan_devolutiva_rel_inc.php";
            $vetCampo['devolutiva_html'] = objInclude('devolutiva', $Require_Once);

            $vetFrm[] = Frame('', Array(
                Array($vetCampo['devolutiva_html']),
                    ), $class_frame . ' display_none', $class_titulo, $titulo_na_linha, $vetParametros);
        }

        $Require_Once = "cadastro_conf/botao_devolutiva.php";

        $vetCampo['devolutiva'] = objInclude('devolutiva', $Require_Once);
        $vetFrm[] = Frame('<span>DEVOLUTIVA</span>', Array(
            Array($vetCampo['devolutiva']),
                ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);

        $vetCad[] = $vetFrm;
    } else {
        alert("Visita sem Devolutiva gerada.");
    }
} else {
    //Require_Once('grc_avaliacao_resposta.php');
    $Require_Once = "cadastro_conf/grc_avaliacao_resposta.php";
    if (file_exists($Require_Once)) {
        Require_Once($Require_Once);
        /*
          $vetParametros=Array();
          $vetCampo['diagnostico'] = objInclude('diagnostico', $Require_Once);
          $vetFrm[] = Frame('<span>DIAGNÓSTICO SITUACIONAL</span>', Array(
          Array($vetCampo['diagnostico']),
          ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);
         */
    } else {
        echo "PROBLEMA NA CHAMADA DO PROGRAMA: {$Require_Once}.<br /> CONTACTAR ADMINISTRADOR DO SISTEMA";
    }
}
?>
<script type="text/javascript">
    var arqGraficoGerado27 = true;
</script>
