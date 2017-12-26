<style>
    .pendencias_1 {
        text-align:left;
        background:#FFFFFF;
        color:#000000;
        border-top:1px solid #000000;
        border-bottom:1px solid #000000;
        border:2px solid #2F66B8;
        width:99%;
        font-size:12px;
        float:left;
    }
    .atende_sc {
        width:80%;
    }
    .pendencia_div {
        width:100%;
        display:block;
    }

    .bola {
        border-radius: 50%;
        display: inline-block;
        height: 100px;
        width: 100px;
        border: 1px solid #000000;
        background-color: #FFFF00;
    }


    div#totpen{
        background:#fa0c01;
        color:#fff;
        width:22px;
        height:22px;
        font-weight: bold;

        line-height:22px;
        vertical-align:middle;
        text-align:center;
        font-size:12px;
        float:left;
        border-radius:50%;
        -moz-border-radius:50%;
        -webkit-border-radius:50%;
        margin-top:5px;
    }


    div#totpen span {
        font-size:14px;
        cursor:pointer;
    }

</style>
<?php
$smreg = 1;
$qtdpendencias = 0;

$data_hoje = trata_data(date('d/m/Y'));

$data_hojew = aspa($data_hoje);

$sql = ' select idt, status, tipo, protocolo, data, data_solucao, observacao, idt_evento_combo_origem, idt_evento_publicar,';
$sql .= ' idt_atendimento, idt_nan_ordem_pagamento, idt_evento, null as idt_contratacao_credenciado_ordem,';
$sql .= ' idt_contratar_credenciado_distrato, idt_contratar_credenciado_aditivo';
$sql .= " from grc_atendimento_pendencia";
$sql .= " where  idt_responsavel_solucao = " . null($_SESSION[CS]['g_id_usuario']);
$sql .= " and ativo = 'S'";
$sql .= whereAtendimentoPendencia();

$sql .= "  union all ";

$sql .= ' select idt, status, tipo, protocolo, dt_registro as data, null as data_solucao, observacao, null as idt_evento_combo_origem, null as idt_evento_publicar,';
$sql .= ' null as idt_atendimento, null as idt_nan_ordem_pagamento, null as idt_evento, idt_contratacao_credenciado_ordem,';
$sql .= ' null as idt_contratar_credenciado_distrato, null as idt_contratar_credenciado_aditivo';
$sql .= " from " . db_pir_gec . "gec_pendencia";
$sql .= " where  idt_usuario_solucao = " . null(IdUsuarioPIR($_SESSION[CS]['g_id_usuario'], db_pir_grc, db_pir_gec));
$sql .= " and ativo = 'S'";
$sql .= " and tipo in ('Ordem de Contratação', 'Pagamento a Credenciado')";
/*
  $sql   .= "     ( data_solucao is null ) ";
  $sql   .= "   and (idt_usuario = ".null($_SESSION[CS]['g_id_usuario'])." )" ;
 */
$sql .= "  order by data asc ";
$rs = execsql($sql);

if ($rs->rows == 0) {
    $smreg = 0;
} else {
    $qtdpendencias = $rs->rows;
}
//
$totalpendencias = $rs->rows;
//
$numexibir = 9;
$qtdl = 11;

$numexibir = 5;
$qtdl = $qtdl + $numexibir;

$numexibirbola = 9;  // não entendi o que é esse 9

$clickb = "";
$elemais = '';
$clickb = " onclick='return ChamaPendencias();' ";
$elemais = "<span>+</span>";
// }
//
if ($smreg == 1) {
    echo "<div class='pendencias_1' >";

    echo "<table class='atende_tb' width='100%' border='0' cellspacing='0' cellpadding='0' vspace='0' hspace='0'> ";

    echo "<tr  style='' >  ";
    echo " <td  style='font-weight: bold;'>";
    echo "";
    echo " </td>";
    echo " <td  style='font-weight: bold;'>";
    echo "Código";
    echo " </td>";
    echo " <td  style='font-weight: bold;'>";
    echo "Data de Abertura";
    echo " </td>";
    echo " <td  style='font-weight: bold;'>";
    echo "Tipo";
    echo " </td>";
    echo " <td  style='font-weight: bold;'>";
    echo "Assunto";
    echo " </td>";
    echo " <td  style='font-weight: bold;'>";
    echo "Status";
    echo " </td>";
    echo " <td  style='font-weight: bold;'>";
    echo "Prazo de Resolução";
    echo " </td>";
    echo "</tr>  ";

    echo "<tr  style='' >  ";

    echo " <td  {$clickb} rowspan='{$qtdl}' style='cursor:pointer; width:100px; xborder:1px solid red;'>";
    $pathw = 'imagens/pendencia.png';
    echo "<div style='float:left; xfont-size:11px;'>";
    echo "    <img style='padding:3px; ' src='" . $pathw . "' width='48' height='48'   border='0' /><BR />";
    echo "PENDÊNCIAS";
    echo "</div>";
    $totalpendenciasw = $totalpendencias;

    if ($totalpendenciasw <= $numexibirbola) {
        $elemais = '';
    } else {
        $totalpendenciasw = 9;
    }

    echo "<div id='totpen'> $totalpendenciasw $elemais </div>";
    echo " </td>";
    echo " <td colspan='6' style='font-weight: bold;'>";
    echo "&nbsp;";
    echo " </td>";

    echo "</tr>  ";

    $nume = 0;
    $numeesconde = 0;
    ForEach ($rs->data as $row) {
        $idt_pendencia = $row['idt'];
        $idt_atendimento = $row['idt_atendimento'];
        $idt_nan_ordem_pagamento = $row['idt_nan_ordem_pagamento'];
        $idt_evento = $row['idt_evento'];
        $idt_contratacao_credenciado_ordem = $row['idt_contratacao_credenciado_ordem'];
        $idt_contratar_credenciado_distrato = $row['idt_contratar_credenciado_distrato'];
        $idt_contratar_credenciado_aditivo = $row['idt_contratar_credenciado_aditivo'];
        $status = $row['status'];
        $tipo = $row['tipo'];
        $protocolo = $row['protocolo'];
        $data = trata_data($row['data']);
        $data_solucao = trata_data($row['data_solucao']);
        $observacao = $row['observacao'];
        //
        $nume = $nume + 1;
        $numeesconde = $numeesconde + 1;
        //

        if ($nume <= $numexibir) {
            echo "<tr  style='' >  ";

            if ($idt_contratacao_credenciado_ordem == '') {
                switch ($tipo) {
                    case 'Evento Combo':
                        $url = 'conteudo.php?acao=alt&prefixo=cadastro&menu=grc_evento_combo_cad&id=' . $row['idt_evento_combo_origem'] . '&idt_pendencia=' . $idt_pendencia;
                        $clickb = " onclick='self.location = \"{$url}\";' ";
                        break;
                    
                    case 'Publicação de Eventos':
                        $url = 'conteudo.php?acao=alt&prefixo=cadastro&menu=grc_evento_publicar&id=' . $row['idt_evento_publicar'] . '&idt_pendencia=' . $idt_pendencia;
                        $clickb = " onclick='self.location = \"{$url}\";' ";
                        break;
                    
                    case 'NAN - Visita 1':
                        if ($status == 'Aprovação') {
                            $clickb = " onclick='return DetalhaPendenciasNANap({$idt_pendencia},{$idt_atendimento});' ";
                        } else {
                            $sql = '';
                            $sql .= ' select idt_atendimento_agenda';
                            $sql .= ' from grc_atendimento';
                            $sql .= ' where idt = ' . null($idt_atendimento);
                            $rsa = execsql($sql);
                            $idt_atendimento_agenda = $rsa->data[0][0];

                            $clickb = " onclick='return DetalhaPendenciasNANde({$idt_pendencia},{$idt_atendimento},{$idt_atendimento_agenda});' ";
                        }
                        break;

                    case 'NAN - Visita 2':
                        if ($status == 'Aprovação') {
                            $clickb = " onclick='return DetalhaPendenciasNANap2({$idt_pendencia},{$idt_atendimento});' ";
                        } else {
                            $sql = '';
                            $sql .= ' select idt_atendimento_agenda';
                            $sql .= ' from grc_atendimento';
                            $sql .= ' where idt = ' . null($idt_atendimento);
                            $rsa = execsql($sql);
                            $idt_atendimento_agenda = $rsa->data[0][0];

                            $clickb = " onclick='return DetalhaPendenciasNANde2({$idt_pendencia},{$idt_atendimento},{$idt_atendimento_agenda});' ";
                        }
                        break;

                    case 'NAN - Ordem de Pagamento':
                        $clickb = " onclick='return DetalhaPendenciasNANapPag({$idt_pendencia},{$idt_nan_ordem_pagamento});' ";
                        break;

                    case 'Aprovação do Distrato':
                        $sql = '';
                        $sql .= ' select ccd.idt_contratar_credenciado';
                        $sql .= ' from ' . db_pir_gec . 'gec_contratar_credenciado_distrato ccd';
                        $sql .= ' where ccd.idt = ' . null($idt_contratar_credenciado_distrato);
                        $rsa = execsql($sql);

                        $url = 'conteudo.php?acao=alt&prefixo=cadastro&voltar=pendencia_home&menu=gec_contratar_credenciado_distrato&id=' . $rsa->data[0][0] . '&idt_pendencia=' . $idt_pendencia;
                        $clickb = " onclick='self.location = \"{$url}\";' ";
                        break;

                    case 'Aprovação do Aditamento':
                        $sql = '';
                        $sql .= ' select ccd.idt_contratar_credenciado';
                        $sql .= ' from ' . db_pir_gec . 'gec_contratar_credenciado_aditivo ccd';
                        $sql .= ' where ccd.idt = ' . null($idt_contratar_credenciado_aditivo);
                        $rsa = execsql($sql);

                        $url = 'conteudo.php?acao=alt&prefixo=cadastro&voltar=pendencia_home&menu=gec_contratar_credenciado_aditivo&id=' . $rsa->data[0][0] . '&idt_pendencia=' . $idt_pendencia;
                        $clickb = " onclick='self.location = \"{$url}\";' ";
                        break;

                    case 'Transferência de Responsabilidades':
                        $clickb = " onclick='return DetalhaPendenciasGeral({$idt_pendencia},{$row['idt_transferencia_responsabilidade']}, \"grc_transferencia_responsabilidade\");' ";
                        break;

                    default:
                        if ($idt_nan_ordem_pagamento == '') {
                            $clickb = " onclick='return DetalhaPendencias({$idt_pendencia},\"{$idt_evento}\");' ";
                        } else {
                            $clickb = " onclick='return DetalhaPendenciasNANapPag({$idt_pendencia},{$idt_nan_ordem_pagamento});' ";
                        }
                        break;
                }
            } else {
                switch ($row['tipo']) {
                    case 'Ordem de Contratação':
                    case 'Pagamento a Credenciado':
                        $url = 'conteudo.php?acao=alt&prefixo=cadastro&menu=gec_contratacao_credenciado_ordem&id=' . $row['idt_contratacao_credenciado_ordem'] . '&idt_pendencia=' . $row['idt'];
                        $clickb = " onclick='self.location = \"{$url}\";' ";
                        break;
                }
            }

            echo " <td  {$clickb} title='Detalhar Pendência' style='cursor:pointer;'>";
            echo "<span style='color:#2F66B8;'>" . $protocolo;
            echo " </td>";
            echo " <td  style='xwidth:68px; xborder:1px solid red;'>";
            echo $data;
            echo " </td>";
            echo " <td  style='xwidth:68px; xborder:1px solid red;'>";
            echo $tipo;
            echo " </td>";
            echo " <td  style='xwidth:68px; xborder:1px solid red;'>";

            echo $observacao;
            echo " </td>";
            echo " <td  style='xwidth:68px; xborder:1px solid red;'>";
            echo $status;
            echo " </td>";
            echo " <td  style='xwidth:68px; xborder:1px solid red;'>";
            echo $data_solucao;
            echo " </td>";
            echo "</tr>  ";
        }
    }



    if ($totalpendencias > $numexibir) {

        echo "<tr  style='' >  ";
        echo " <td colspan='8' style='padding-top:15px; padding-bottom:15px;'> ";
        echo "<span style=' '><a style='border-top:1px solid #000000;'>Mostrando as {$numexibir} pendências mais antigas. Para ver lista completa clique sobre o icone de <b>PENDÊNCIAS</b></a>";
        echo " </td> ";
        echo "</tr>";
    }

    echo "</table>";





    echo "</div>";
}
?>
<script>
    function AbrePendencias()
    {
        $('.escondido').each(function () {
            $(this).toggle();
        });
        return false;
    }

    function ChamaPendencias()
    {
        self.location = 'conteudo.php?prefixo=listar&menu=grc_atendimento_pendencia_m';
        return false;
    }

    function DetalhaPendenciasGeral(idt_pendencia, id, menu)
    {
        var url = '';
        url = 'conteudo.php?acao=alt&prefixo=cadastro&voltar=pendencia_home&menu=' + menu + '&id=' + id + '&idt_pendencia=' + idt_pendencia;
        self.location = url;
        return false;
    }

    function DetalhaPendencias(idt_pendencia, idt_evento)
    {
        var url = '';
        if (idt_evento == '')
        {
            url = 'conteudo.php?acao=alt&prefixo=cadastro&voltar=pendencia_home&menu=grc_atendimento_pendencia_m&id=' + idt_pendencia;
        } else {
            url = 'conteudo.php?acao=alt&prefixo=cadastro&voltar=pendencia_home&menu=grc_evento&id=' + idt_evento + '&idt_pendencia=' + idt_pendencia;
        }
        self.location = url;
        return false;
    }

    function DetalhaPendenciasNANap(idt_pendencia, idt_atendimento)
    {
        var url = '';
        url = 'conteudo.php?acao=alt&prefixo=cadastro&voltar=pendencia_home&menu=grc_nan_visita_1_ap&id=' + idt_atendimento + '&idt_pendencia=' + idt_pendencia;
        self.location = url;
        return false;
    }

    function DetalhaPendenciasNANap2(idt_pendencia, idt_atendimento)
    {
        var url = '';
        url = 'conteudo.php?acao=alt&prefixo=cadastro&voltar=pendencia_home&menu=grc_nan_visita_2_ap&id=' + idt_atendimento + '&idt_pendencia=' + idt_pendencia;
        self.location = url;
        return false;
    }

    function DetalhaPendenciasNANapPag(idt_pendencia, idt_nan_ordem_pagamento)
    {
        var url = '';
        url = 'conteudo.php?acao=alt&prefixo=cadastro&voltar=pendencia_home&menu=grc_nan_ordem_pagamento&id=' + idt_nan_ordem_pagamento + '&idt_pendencia=' + idt_pendencia;
        self.location = url;
        return false;
    }

    function DetalhaPendenciasNANde(idt_pendencia, idt_atendimento, idt_atendimento_agenda)
    {
        var url = '';
        url = 'conteudo.php?prefixo=inc&menu=grc_nan_visita_1&voltar=pendencia_home&session_volta=avulso&idt_atendimento_agenda=' + idt_atendimento_agenda + '&idt_atendimento=' + idt_atendimento + '&id=' + idt_atendimento_agenda + '&aba=1&idt_pendencia=' + idt_pendencia;
        self.location = url;
        return false;
    }

    function DetalhaPendenciasNANde2(idt_pendencia, idt_atendimento, idt_atendimento_agenda)
    {
        var url = '';
        url = 'conteudo.php?prefixo=inc&menu=grc_nan_visita_2&voltar=pendencia_home&session_volta=avulso&idt_atendimento_agenda=' + idt_atendimento_agenda + '&idt_atendimento=' + idt_atendimento + '&id=' + idt_atendimento_agenda + '&aba=1&idt_pendencia=' + idt_pendencia;
        self.location = url;
        return false;
    }
</script>
