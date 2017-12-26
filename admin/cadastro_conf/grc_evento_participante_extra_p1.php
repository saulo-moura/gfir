<?php
if ($veio == '') {
    $veio = $_GET['veio'];
}

$composto = $vetParametrosMC['par_composto'];
$origem_evento_tela = $vetParametrosMC['par_origem_evento_tela'];
$gratuito = $vetParametrosMC['par_gratuito'];
$idt_evento = $vetParametrosMC['par_idt_evento'];
$idt_evento_situacao = $vetParametrosMC['par_idt_evento_situacao'];
$situacao_contrato = $vetParametrosMC['par_situacao_contrato'];

$tabela = 'grc_evento_participante';
$id = 'idt';

$class_frame = "class_frame";
$class_titulo = "class_titulo";
$class_titulo_p = "class_titulo_p";
$titulo_na_linha = false;

$maxlength = 2000;
$style = "";
$js = "";
$vetCampo['detalhe'] = objTextArea('detalhe', 'Observação', false, $maxlength, $style, $js);

$sql = "select idt,codigo,descricao from " . db_pir_gec . "gec_meio_informacao ";
$sql .= " order by codigo";
$vetCampo['idt_midia'] = objCmbBanco('idt_midia', 'Mídia', true, $sql, ' ', 'width:300px;');

if ($_GET['idt_instrumento'] == 41) {
    $sql = '';
    $sql .= ' select idt, numero, area';
    $sql .= ' from grc_evento_stand';
    //$sql .= ' where idt_evento = ';
    $sql .= ' order by numero, area';
    $vetCampo['idt_stand'] = objCmbBanco('idt_stand', 'Stand (só para Feiras)', false, $sql, ' ', 'width:300px;');
}

if ($veio == 'SG' || $composto == 'S' || $origem_evento_tela == 'combo') {
    $vetCampo['vl_tot_pagamento'] = objTextoFixo('vl_tot_pagamento', 'Valor Total do Pagamento', 15, true);
}

$vetCampo['idt_evento_publicacao_cupom'] = objHidden('idt_evento_publicacao_cupom', '');

$vetFrm = Array();

if ($composto == 'S') {
    $vetCmb = Array();

    if ($gratuito == 'S' && $veio != 'SG') {
        $tmp = Array(
            'C' => 'Sim',
            'N' => 'Não',
        );
    } else {
        $tmp = Array(
            'S' => 'Sim',
            'C' => 'Cortesia',
            'N' => 'Não',
        );
    }

    $sql = '';
    $sql .= ' select a.idt, p.evento_cortesia, ep.ativo, e.codigo, e.descricao, i.descricao as instrumento, e.idt_instrumento';
    $sql .= ' from grc_evento e';
    $sql .= ' inner join grc_atendimento_instrumento i on i.idt = e.idt_instrumento';
    $sql .= ' left outer join grc_atendimento a on a.idt_evento = e.idt and a.idt_atendimento_pai = ' . null($_GET['id']);
    $sql .= ' left outer join grc_atendimento_pessoa p on p.idt_atendimento = a.idt';
    $sql .= ' left outer join grc_evento_participante ep on ep.idt_atendimento = a.idt';
    $sql .= ' where e.idt_evento_pai = ' . null($idt_evento);
    $sql .= ' order by e.codigo';
    $rsEF = execsql($sql);

    foreach ($rsEF->data as $rowEV) {
        if ($rowEV['ativo'] == 'N') {
            $vl = 'N';
        } else if ($gratuito == 'S' && $veio != 'SG') {
            $vl = 'C';
        } else if ($rowEV['evento_cortesia'] == 'S') {
            $vl = 'C';
        } else {
            $vl = 'S';
        }

        $js = '';

        /*
          if ($idt_evento_situacao >= 14 && $rowEV['idt_instrumento'] == 2) {
          $js = ' disabled ';
          }
         * 
         */

        $vetCmb[][$rowEV['idt']] = objCmbVetor('composto_mat[' . $rowEV['idt'] . ']', $rowEV['instrumento'] . ' - ' . $rowEV['descricao'], true, $tmp, ' ', $js, '', false, $vl);
    }

    $vetFrm[] = Frame('<span>Inscrever nos Eventos</span>', $vetCmb);
}

if ($origem_evento_tela == 'combo' && $_GET['id'] > 0) {
    //Informação das restrições    
    $info_restricao_combo = '';

    $sql = '';
    $sql .= ' select combo_qtd_evento_insc';
    $sql .= ' from grc_evento';
    $sql .= ' where idt = ' . null($idt_evento);
    $rsEF = execsql($sql);
    $row = $rsEF->data[0];

    $info_restricao_combo .= 'Tem que escolher ' . $row['combo_qtd_evento_insc'] . ' eventos';

    $sql = '';
    $sql .= ' select i.descricao as instrumento, eg.qtd_atual';
    $sql .= ' from grc_evento_combo_instrumento eg';
    $sql .= ' inner join grc_atendimento_instrumento i on i.idt = eg.idt_instrumento';
    $sql .= ' where eg.idt_evento = ' . null($idt_evento);
    $sql .= ' and eg.qtd_atual > 0';
    $sql .= ' order by i.descricao';
    $rsEF = execsql($sql);

    $vetTmp = Array();

    foreach ($rsEF->data as $row) {
        $vetTmp[] = $row['qtd_atual'] . ' ' . $row['instrumento'];
    }

    if (count($vetTmp) > 0) {
        $ultTxt = array_pop($vetTmp);

        $info_restricao_combo .= ' e entre os selecionados tem que ser ';

        if (count($vetTmp) > 0) {
            $info_restricao_combo .= implode(', ', $vetTmp) . ' e ';
        }

        $info_restricao_combo .= $ultTxt;
    }

    $info_restricao_combo .= '.';

    $vetCampo['info_restricao_combo'] = objTextoFixoVL('info_restricao_combo', 'Regras para a inscrição', $info_restricao_combo, '', false);

    $vetFrm[] = Frame('', Array(
        Array($vetCampo['info_restricao_combo']),
            ), $class_frame, $class_titulo, $titulo_na_linha);

    $sql = '';
    $sql .= ' select a.idt, p.evento_cortesia, ep.ativo, e.codigo, e.descricao, i.descricao as instrumento, e.idt_instrumento,';
    $sql .= ' ec.vl_matricula, ec.matricula_obr';
    $sql .= ' from grc_evento e';
    $sql .= ' inner join grc_evento_combo ec on ec.idt_evento = e.idt';
    $sql .= ' inner join grc_atendimento_instrumento i on i.idt = e.idt_instrumento';
    $sql .= ' left outer join grc_atendimento a on a.idt_evento = e.idt and a.idt_atendimento_pai = ' . null($_GET['id']);
    $sql .= ' left outer join grc_atendimento_pessoa p on p.idt_atendimento = a.idt';
    $sql .= ' left outer join grc_evento_participante ep on ep.idt_atendimento = a.idt';
    $sql .= ' where ec.idt_evento_origem = ' . null($idt_evento);
    $sql .= ' order by i.descricao, ec.matricula_obr desc, e.descricao limit 10';
    $rsEF = execsql($sql);

    $vetFrmMAT = Array();
    $vetTmp = Array();
    $colPA = 3;

    foreach ($rsEF->data as $rowEV) {
        $complemento_tag = '';

        if ($rowEV['matricula_obr'] == 'S') {
            $complemento_tag = 'disabled';
        }

        $desc = $rowEV['descricao'] . ' (R$ ' . format_decimal($rowEV['vl_matricula']) . ')';

        $vetTmp[$rowEV['instrumento']][$rowEV['idt']] = objCheckbox('matcombo[' . $rowEV['idt'] . ']', '', 'S', 'N', $desc, false, $rowEV['ativo'], $complemento_tag);

        if (count($vetTmp) == $colPA) {
            $vetFrmMAT[] = $vetTmp;
            $vetTmp = Array();
        }
    }

    if (count($vetTmp) > 0) {
        $idxFim = $colPA - count($vetTmp);

        for ($index1 = 0; $index1 < $idxFim; $index1++) {
            $vetTmp[] = '';
        }

        $vetFrmMAT[] = $vetTmp;
    }

    foreach ($vetFrmMAT as $keyGR => $vetGR) {
        $qtdEV = 0;

        foreach ($vetGR as $keyIns => $vetEV) {
            if (count($vetEV) > $qtdEV) {
                $qtdEV = count($vetEV);
            }
        }

        foreach ($vetGR as $keyIns => $vetEV) {
            if (!is_array($vetEV)) {
                $vetEV = Array();
            }

            $idxFim = $qtdEV - count($vetEV);

            for ($index1 = 0; $index1 < $idxFim; $index1++) {
                $vetEV['v' . $index1] = '';
            }

            $vetFrmMAT[$keyGR][$keyIns] = $vetEV;
        }
    }

    $vetFrmFinal = Array();

    foreach ($vetFrmMAT as $keyGR => $vetGR) {
        $vetCab = Array();
        $vetRow = Array();
        $qtdIns = 0;

        foreach ($vetGR as $keyIns => $vetEV) {
            $qtdEV = 0;

            if (is_int($keyIns)) {
                $vetCab[] = '';
            } else {
                $vetCab[] = objBarraTitulo('lbl_' . troca_caracter($keyIns), $keyIns, 'class_titulo_p_barra');
            }

            $vetCab[] = '';

            foreach ($vetEV as $keyEV => $rowEV) {
                $vetRow[$qtdEV++][$qtdIns++] = $rowEV;
            }
        }

        array_pop($vetCab);
        $vetFrmFinal[] = $vetCab;

        foreach ($vetRow as $vetEV) {
            $vetTmp = Array();

            foreach ($vetEV as $rowEV) {
                $vetTmp[] = $rowEV;
                $vetTmp[] = '';
            }

            array_pop($vetTmp);
            $vetFrmFinal[] = $vetTmp;
        }
    }

    $vetFrm[] = Frame('', $vetFrmFinal, $class_frame, $class_titulo, $titulo_na_linha);
}

MesclarCol($vetCampo['detalhe'], 5);
MesclarCol($vetCampo['idt_evento_publicacao_cupom'], 5);

$vetFrm[] = Frame('', Array(
    Array($vetCampo['idt_midia'], '', $vetCampo['vl_tot_pagamento'], '', $vetCampo['idt_stand']),
    Array($vetCampo['detalhe']),
    Array($vetCampo['idt_evento_publicacao_cupom']),
        ), $class_frame, $class_titulo, $titulo_na_linha);

//Política de Desconto - Assento Marcado
if ($_GET['id'] > 0) {
    $sql = '';
    $sql .= ' select ep.assento_marcado';
    $sql .= ' from grc_evento_publicacao ep';
    $sql .= ' where ep.idt_evento = ' . null($idt_evento);
    $sql .= ' and now() between ep.data_publicacao_de and ep.data_publicacao_ate';
    $sql .= " and ep.ativo = 'S'";
    $sql .= " and ep.situacao = 'AP'";
    $rsEP = execsql($sql);
    $rowEP = $rsEP->data[0];

    $assentoMarcadoAlt = false;
    $assentoMarcadoMostra = false;

    if ($rowEP['assento_marcado'] == 'S' && $situacao_contrato == 'R') {
        $assentoMarcadoAlt = true;
        $assentoMarcadoMostra = true;
    } else {
        $sql = '';
        $sql .= ' select pma.idt_evento_mapa';
        $sql .= ' from grc_evento_mapa_assento pma';
        $sql .= ' inner join grc_evento_mapa pm on pm.idt = pma.idt_evento_mapa';
        $sql .= ' where pm.idt_evento = ' . null($idt_evento);
        $sql .= ' and pma.idt_matricula_utilizado = ' . null($_GET['id']);
        $rs = execsql($sql);
        $assentoMarcadoMostra = $rs->rows > 0;
    }

    if ($assentoMarcadoMostra) {
        define('assentoMarcadoAlt', $assentoMarcadoAlt);

        $vetCampo['grc_evento_participante_assento'] = objInclude('grc_evento_participante_assento', 'cadastro_conf/grc_evento_participante_assento.php');

        $vetParametros = Array(
            'width' => '100%',
        );

        $vetFrm[] = Frame('<span>Selecione o Assento</span>', Array(
            Array($vetCampo['grc_evento_participante_assento']),
                ), $class_frame, $class_titulo_p, $titulo_na_linha, $vetParametros);
    }
}

$vetCad[] = $vetFrm;
?>
<script type="text/javascript">
    var assento_marcado = '<?php echo $rowEP['assento_marcado']; ?>';

    $(document).ready(function () {
        if (acao == 'alt' && '<?php echo $situacao_contrato; ?>' == 'R') {
            $('input[id ^= "matcombo"]').change(function () {
                var obj = $(this);
                var ativo = 'N';

                if (obj.prop('checked')) {
                    ativo = 'S';
                }

                MatCompostoCombo(obj, ativo, 'matcombo');
            });

            setTimeout(function () {
                $('input[id ^= "matcombo"]').each(function () {
                    composto_matAjax = 'N';
                    $(this).change();
                    composto_matAjax = 'S';
                });
            }, 100);
        }
    });

    function marcaAssento(obj, idt, idt_matricula_utilizado) {
        processando();

        $.ajax({
            dataType: 'json',
            type: 'POST',
            url: ajax_sistema + '?tipo=marcaAssento',
            data: {
                cas: conteudo_abrir_sistema,
                idt_evento: '<?php echo $idt_evento; ?>',
                idt: idt,
                idt_matricula_utilizado: idt_matricula_utilizado
            },
            success: function (response) {
                if (response.marcado == 'S') {
                    $(obj).attr('src', 'imagens/assento_sel.png');
                }

                if (response.marcado == 'N') {
                    $(obj).attr('src', $(obj).data('img'));
                }

                if (response.html != '') {
                    $('#grc_evento_participante_assento_desc').html(url_decode(response.html));
                }

                if (response.erro != '') {
                    $('#dialog-processando').remove();
                    alert(url_decode(response.erro));
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                $('#dialog-processando').remove();
                alert('Erro no ajax no: ' + textStatus + ' - ' + errorThrown);
            },
            async: false
        });

        $('#dialog-processando').remove();
    }
</script>