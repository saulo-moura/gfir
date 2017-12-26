<?php
if ($veio == '') {
    $veio = $_GET['veio'];
}

$composto = $vetParametrosMC['par_composto'];
$idt_evento = $vetParametrosMC['par_idt_evento'];
$situacao_contrato = $vetParametrosMC['par_situacao_contrato'];

$tabela = 'grc_evento_participante';
$id = 'idt';

$class_frame = "class_frame";
$class_titulo = "class_titulo";
$class_titulo_p = "class_titulo_p";
$titulo_na_linha = false;

$vetFrm = Array();

//Política de Desconto
$rowEPV_A = Array();
$rowEPV_E = Array();
$vetTmpCampo = Array();

//Verifica se pode usar Desconto
$sql = '';
$sql .= ' select ep.idt, ep.gerador_voucher, ep.desconto_porte, ep.cupon_desconto';
$sql .= ' from grc_evento_publicacao ep';
$sql .= ' where ep.idt_evento = ' . null($idt_evento);
$sql .= ' and now() between ep.data_publicacao_de and ep.data_publicacao_ate';
$sql .= " and ep.ativo = 'S'";
$sql .= " and ep.situacao = 'AP'";
$rsEP = execsql($sql);
$rowEP = $rsEP->data[0];

if ($rsEP->rows == 0) {
    //Mostra o Cupom Utilizado
    $sql = '';
    $sql .= ' select codigo_cupom';
    $sql .= ' from grc_evento_participante';
    $sql .= ' where idt_atendimento = ' . null($_GET['id']);
    $rs = execsql($sql);
    $codigo_cupom = $rs->data[0][0];

    if ($codigo_cupom != '') {
        $vetCampo['codigo_cupom'] = objTextoFixo('codigo_cupom', 'Cupom de Desconto', 45, true);

        if (count($vetTmpCampo) > 0) {
            $vetTmpCampo[] = '';
        }

        $vetTmpCampo[] = $vetCampo['codigo_cupom'];
    }
} else {
    //Verifica se pode usar o Cupom
    if ($rowEP['cupon_desconto'] == 'S') {
        $vetCampo['codigo_cupom'] = objTexto('codigo_cupom', 'Cupom de Desconto', false, 45);

        if (count($vetTmpCampo) > 0) {
            $vetTmpCampo[] = '';
        }

        $vetTmpCampo[] = $vetCampo['codigo_cupom'];
    }
}

if (voucher_utilizado == '') {
    $vetCampo['idt_voucher_e_indicado'] = objFixoBanco('idt_voucher_e_indicado', 'Número do Indicado', 'grc_evento_publicacao_voucher_registro', 'idt', 'numero');
    $vetCampo['idt_voucher_e_indicador'] = objFixoBanco('idt_voucher_e_indicador', 'Número do Indicador', 'grc_evento_publicacao_voucher_registro', 'idt', 'numero');
    $idxDesativa = -1;

    if ($rsEP->rows == 0) {
        //Mostra o Voucher do Tipo A Gerado
        $sql = '';
        $sql .= ' select vr.numero';
        $sql .= ' from grc_evento_publicacao_voucher_registro vr';
        $sql .= " inner join grc_evento_publicacao_voucher v on v.idt = vr.idt_evento_publicacao_voucher";
        $sql .= " inner join grc_evento_publicacao ep on ep.idt = vr.idt_evento_publicacao";
        $sql .= ' where ep.idt_evento = ' . null($idt_evento);
        $sql .= " and ep.situacao = 'AP'";
        $sql .= ' and vr.idt_matricula_gerado = ' . null($_GET['id']);
        $sql .= ' and v.idt_tipo_voucher = ' . null($vetTipoVoucherCodIDT['A']);
        $rs = execsql($sql);
        $voucher_numero_a = $rs->data[0][0];

        if ($voucher_numero_a != '') {
            $vetCampo['gerar_voucher_a'] = objFixoVetor('gerar_voucher_a', 'Cliente deseja levar outro Participante?', false, $vetNaoSim, '');
            $vetCampo['voucher_numero_a'] = objTextoFixo('voucher_numero_a', 'Número do Voucher A', 20, false, false, $voucher_numero_a);

            if (count($vetTmpCampo) > 0) {
                $vetTmpCampo[] = '';
            }

            $vetTmpCampo[] = $vetCampo['gerar_voucher_a'];
            $vetTmpCampo[] = '';
            $vetTmpCampo[] = $vetCampo['voucher_numero_a'];
        }

        //Mostra o Voucher do Tipo E Gerado
        $sql = '';
        $sql .= ' select vr.numero';
        $sql .= ' from grc_evento_publicacao_voucher_registro vr';
        $sql .= " inner join grc_evento_publicacao_voucher v on v.idt = vr.idt_evento_publicacao_voucher";
        $sql .= " inner join grc_evento_publicacao ep on ep.idt = vr.idt_evento_publicacao";
        $sql .= ' where ep.idt_evento = ' . null($idt_evento);
        $sql .= " and ep.situacao = 'AP'";
        $sql .= ' and vr.idt_matricula_gerado = ' . null($_GET['id']);
        $sql .= ' and v.idt_tipo_voucher = ' . null($vetTipoVoucherCodIDT['E']);
        $rs = execsql($sql);
        $voucher_numero_e = $rs->data[0][0];

        if ($voucher_numero_e != '') {
            $vetCampo['gerar_voucher_e'] = objFixoVetor('gerar_voucher_e', 'Deseja Indicar Amigo?', false, $vetNaoSim, '');
            $vetCampo['email_indicado'] = objTextoFixo('email_indicado', 'e-Mail do Indicado', 40, true);

            if (count($vetTmpCampo) > 0) {
                $vetTmpCampo[] = '';
            }

            $vetTmpCampo[] = $vetCampo['gerar_voucher_e'];
            $vetTmpCampo[] = '';
            $vetTmpCampo[] = $vetCampo['email_indicado'];
            $vetTmpCampo[] = '';
            $vetTmpCampo[] = $vetCampo['idt_voucher_e_indicado'];
            $vetTmpCampo[] = '';
            $vetTmpCampo[] = $vetCampo['idt_voucher_e_indicador'];
        }
    } else {
        //Verifica se pode usar Voucher
        if ($rowEP['gerador_voucher'] == 'S') {
            //Gerar Voucher do Tipo A
            $sql = '';
            $sql .= ' select v.idt, v.quantidade';
            $sql .= ' from grc_evento_publicacao_voucher v';
            $sql .= ' where v.idt_evento_publicacao = ' . null($rowEP['idt']);
            $sql .= ' and v.idt_tipo_voucher = ' . null($vetTipoVoucherCodIDT['A']);
            $rs = execsql($sql);

            if ($rs->rows > 0) {
                $rowEPV_A = $rs->data[0];

                $sql = '';
                $sql .= ' select numero as voucher_numero_a, idt_matricula_utilizado';
                $sql .= ' from grc_evento_publicacao_voucher_registro';
                $sql .= ' where idt_evento_publicacao_voucher = ' . null($rowEPV_A['idt']);
                $sql .= ' and idt_matricula_gerado = ' . null($_GET['id']);
                $rs = execsql($sql);
                $rowEPVR = $rs->data[0];

                $sql = '';
                $sql .= ' select count(idt) as tot';
                $sql .= ' from grc_evento_publicacao_voucher_registro';
                $sql .= ' where idt_evento_publicacao_voucher = ' . null($rowEPV_A['idt']);
                $sql .= ' and idt_matricula_gerado <> ' . null($_GET['id']);
                $sql .= " and ativo = 'S'";
                $rs = execsql($sql);
                $qtd_utilizada = $rs->data[0][0];

                if ($qtd_utilizada > $rowEPV_A['quantidade'] || $rowEPVR['idt_matricula_utilizado'] != '') {
                    $vetCampo['gerar_voucher_a'] = objFixoVetor('gerar_voucher_a', 'Cliente deseja levar outro Participante?', false, $vetNaoSim, '', '', '', '', 'N');
                    $vetCampo['voucher_numero_a'] = objTextoFixo('voucher_numero_a', 'Número do Voucher A', 20, false, false, $rowEPVR['voucher_numero_a']);

                    if (count($vetTmpCampo) > 0) {
                        $vetTmpCampo[] = '';
                    }

                    $vetTmpCampo[] = $vetCampo['gerar_voucher_a'];
                    $vetTmpCampo[] = '';
                    $vetTmpCampo[] = $vetCampo['voucher_numero_a'];
                } else {
                    $vetCampo['gerar_voucher_a'] = objCmbVetor('gerar_voucher_a', 'Cliente deseja levar outro Participante?', false, $vetNaoSim, '');
                    $vetCampo['voucher_numero_a'] = objTextoFixo('voucher_numero_a', 'Número do Voucher A', 20, false, false, $rowEPVR['voucher_numero_a']);

                    if (count($vetTmpCampo) > 0) {
                        $vetTmpCampo[] = '';
                    }

                    $vetTmpCampo[] = $vetCampo['gerar_voucher_a'];
                    $vetTmpCampo[] = '';
                    $vetTmpCampo[] = $vetCampo['voucher_numero_a'];

                    $par = 'gerar_voucher_a';
                    $vetDesativa['representa_empresa'][0] = vetDesativa($par);
                    $vetAtivadoObr['representa_empresa'][0] = vetAtivadoObr($par);
                }
            }

            //Gerar Voucher do Tipo E
            $sql = '';
            $sql .= ' select v.idt, v.quantidade';
            $sql .= ' from grc_evento_publicacao_voucher v';
            $sql .= ' where v.idt_evento_publicacao = ' . null($rowEP['idt']);
            $sql .= ' and v.idt_tipo_voucher = ' . null($vetTipoVoucherCodIDT['E']);
            $rs = execsql($sql);

            if ($rs->rows > 0) {
                $rowEPV_E = $rs->data[0];

                $sql = '';
                $sql .= ' select numero as voucher_numero_e, idt_matricula_utilizado';
                $sql .= ' from grc_evento_publicacao_voucher_registro';
                $sql .= ' where idt_evento_publicacao_voucher = ' . null($rowEPV_E['idt']);
                $sql .= ' and idt_matricula_gerado = ' . null($_GET['id']);
                $sql .= " and substring(numero, 1, 3) = 'VEO'";
                $rs = execsql($sql);
                $rowEPVR = $rs->data[0];

                if ($rowEPVR['idt_matricula_utilizado'] != '') {
                    $vetCampo['gerar_voucher_e'] = objFixoVetor('gerar_voucher_e', 'Deseja Indicar Amigo?', false, $vetNaoSim, '', '', '', '', 'N');
                    $vetCampo['email_indicado'] = objTextoFixo('email_indicado', 'e-Mail do Indicado', 40, true);

                    if (count($vetTmpCampo) > 0) {
                        $vetTmpCampo[] = '';
                    }

                    $vetTmpCampo[] = $vetCampo['gerar_voucher_e'];
                    $vetTmpCampo[] = '';
                    $vetTmpCampo[] = $vetCampo['email_indicado'];
                    $vetTmpCampo[] = '';
                    $vetTmpCampo[] = $vetCampo['idt_voucher_e_indicado'];
                    $vetTmpCampo[] = '';
                    $vetTmpCampo[] = $vetCampo['idt_voucher_e_indicador'];
                } else {
                    $vetCampo['gerar_voucher_e'] = objCmbVetor('gerar_voucher_e', 'Deseja Indicar Amigo?', false, $vetNaoSim, '');
                    $vetCampo['email_indicado'] = objEmail('email_indicado', 'e-Mail do Indicado', false, 40, 200);

                    $idxDesativa++;
                    $par = 'email_indicado';
                    $vetDesativa['gerar_voucher_e'][$idxDesativa] = vetDesativa($par);
                    $vetAtivadoObr['gerar_voucher_e'][$idxDesativa] = vetAtivadoObr($par);

                    if (count($vetTmpCampo) > 0) {
                        $vetTmpCampo[] = '';
                    }

                    $vetTmpCampo[] = $vetCampo['gerar_voucher_e'];
                    $vetTmpCampo[] = '';
                    $vetTmpCampo[] = $vetCampo['email_indicado'];
                    $vetTmpCampo[] = '';
                    $vetTmpCampo[] = $vetCampo['idt_voucher_e_indicado'];
                    $vetTmpCampo[] = '';
                    $vetTmpCampo[] = $vetCampo['idt_voucher_e_indicador'];
                }
            }
        }
    }
}

//Utiliza Voucher do Tipo E
$vetCampo['usado_numero_voucher_e'] = objTexto('usado_numero_voucher_e', 'Utilizar Voucher do Indicador', false, 20, 45);

if (count($vetTmpCampo) > 0) {
    $vetTmpCampo[] = '';
}

$vetTmpCampo[] = $vetCampo['usado_numero_voucher_e'];

if (count($vetTmpCampo) > 0) {
    $vetFrm[] = Frame('', Array(
        $vetTmpCampo,
            ), $class_frame, $class_titulo, $titulo_na_linha);
}

$vetCad[] = $vetFrm;
?>
<script type="text/javascript">
    var idt_epv_a = '<?php echo $rowEPV_A['idt']; ?>';
    var idt_epv_e = '<?php echo $rowEPV_E['idt']; ?>';

    var composto = '<?php echo $composto; ?>';

    if ('<?php echo $_GET['idt_instrumento']; ?>' == '54') {
        composto = 'S';
    }

    var vl_evento = 0;

    $(document).ready(function () {
        if (acao == 'alt' && '<?php echo $situacao_contrato; ?>' == 'R') {
            if (idt_epv_a != '') {
                $('#gerar_voucher_a').change(function () {
                    processando();

                    $.ajax({
                        dataType: 'json',
                        type: 'POST',
                        url: ajax_sistema + '?tipo=GerarVoucher',
                        data: {
                            cas: conteudo_abrir_sistema,
                            gera: $('#gerar_voucher_a').val(),
                            idt_evento_publicacao: '<?php echo $rowEP['idt']; ?>',
                            idt_evento_publicacao_voucher: idt_epv_a,
                            idt_tipo_voucher: '<?php echo $vetTipoVoucherCodIDT['A']; ?>',
                            idt_matricula_gerado: '<?php echo $_GET['id']; ?>'
                        },
                        success: function (response) {
                            if (response.altera_numero == 'S') {
                                $('#voucher_numero_a').val(response.voucher_numero);
                                $('#voucher_numero_a_fix').html(response.voucher_numero);
                            }

                            if (response.erro != '') {
                                $('#gerar_voucher_a').val('N');
                                $('#dialog-processando').remove();
                                alert(url_decode(response.erro));
                            }
                        },
                        error: function (jqXHR, textStatus, errorThrown) {
                            $('#gerar_voucher_a').val('N');
                            $('#dialog-processando').remove();
                            alert('Erro no ajax no: ' + textStatus + ' - ' + errorThrown);
                        },
                        async: false
                    });

                    $('#dialog-processando').remove();
                });
            }

            if (idt_epv_e != '') {
                $('#gerar_voucher_e').change(function () {
                    if ($('#usado_numero_voucher_e').val().toUpperCase().substr(0, 3) == 'VEO' && $('#gerar_voucher_e').val() == 'S') {
                        alert('Não pode usar o Voucher do Indicado junto com a opção de Indicar Amigo!!');
                        $('#gerar_voucher_e').val('N');
                        return false;
                    }

                    processando();

                    $.ajax({
                        dataType: 'json',
                        type: 'POST',
                        url: ajax_sistema + '?tipo=GerarVoucher',
                        data: {
                            cas: conteudo_abrir_sistema,
                            gera: $('#gerar_voucher_e').val(),
                            idt_evento_publicacao: '<?php echo $rowEP['idt']; ?>',
                            idt_evento_publicacao_voucher: idt_epv_e,
                            idt_tipo_voucher: '<?php echo $vetTipoVoucherCodIDT['E']; ?>',
                            idt_matricula_gerado: '<?php echo $_GET['id']; ?>'
                        },
                        success: function (response) {
                            if (response.altera_numero == 'S') {
                                $('#idt_voucher_e_indicado').val(response.idt_voucher_numero);
                                $('#idt_voucher_e_indicado_tf').html(response.voucher_numero);

                                $('#idt_voucher_e_indicador').val(response.idt_voucher_numero_indicador);
                                $('#idt_voucher_e_indicador_tf').html(response.voucher_numero_indicador);
                            }

                            if (response.erro != '') {
                                $('#gerar_voucher_e').val('N');
                                $('#dialog-processando').remove();
                                alert(url_decode(response.erro));
                            }
                        },
                        error: function (jqXHR, textStatus, errorThrown) {
                            $('#gerar_voucher_e').val('N');
                            $('#dialog-processando').remove();
                            alert('Erro no ajax no: ' + textStatus + ' - ' + errorThrown);
                        },
                        async: false
                    });

                    $('#dialog-processando').remove();
                });
            }

            var btVoucherUtilizado_E = $('<img border="0" id="btVoucherUtilizado_E" style="margin-left: 3px; cursor: pointer; vertical-align: middle;" src="imagens/bt_pesquisa.png" title="Pesquisar">');

            btVoucherUtilizado_E.click(function () {
                if ($('#usado_numero_voucher_e').val() != '') {
                    var gerar_voucher_e = '';

                    if ($('#gerar_voucher_e').length > 0) {
                        gerar_voucher_e = $('#gerar_voucher_e').val();
                    }

                    if ($('#usado_numero_voucher_e').val().toUpperCase().substr(0, 3) != 'VER') {
                        alert('O Número do Voucher informado não é do Indicador!');
                        $('#usado_numero_voucher_e').val('');
                        $('#usado_numero_voucher_e').focus();
                        return false;
                    }

                    if ($('#usado_numero_voucher_e').val().toUpperCase().substr(0, 3) == 'VEO' && gerar_voucher_e == 'S') {
                        alert('Não pode usar o Voucher do Indicado junto com a opção de Indicar Amigo!!');
                        $('#usado_numero_voucher_e').val('');
                        $('#usado_numero_voucher_e').focus();
                        return false;
                    }
                }

                processando();

                if (composto == 'S') {
                    vl_evento = $('#vl_tot_pagamento').val();
                } else {
                    vl_evento = '<?php echo $_GET['valor_inscricao']; ?>';
                }

                $.ajax({
                    dataType: 'json',
                    type: 'POST',
                    url: ajax_sistema + '?tipo=ChecaVoucher',
                    data: {
                        cas: conteudo_abrir_sistema,
                        voucher_numero: $('#usado_numero_voucher_e').val(),
                        vl_evento: vl_evento,
                        idt_evento: '<?php echo $idt_evento; ?>',
                        idt_matricula_utilizado: '<?php echo $_GET['id']; ?>'
                    },
                    success: function (response) {
                        btFechaCTC($('#grc_evento_participante_pagamento').data('session_cod'));
                        btFechaCTC($('#grc_evento_participante_desconto').data('session_cod'));

                        if (response.erro != '') {
                            $('#dialog-processando').remove();
                            alert(url_decode(response.erro));
                            $('#usado_numero_voucher_e').val(url_decode(response.voucher_numero));
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        $('#usado_numero_voucher_e').val('');
                        $('#dialog-processando').remove();
                        alert('Erro no ajax no: ' + textStatus + ' - ' + errorThrown);
                    },
                    async: false
                });

                $('#dialog-processando').remove();
            });

            $('#usado_numero_voucher_e_obj').attr('nowrap', 'nowrap').append(btVoucherUtilizado_E);

            $('#usado_numero_voucher_e').blur(function () {
                btVoucherUtilizado_E.click();
            });

            /*
             setTimeout(function () {
             $('#usado_numero_voucher_e').removeProp("disabled").removeClass("campo_disabled");
             }, 500);
             
             setTimeout(function () {
             $('#usado_numero_voucher_e').removeProp("disabled").removeClass("campo_disabled");
             }, 2000);
             */


            var btDescontoCodigo = $('<img border="0" id="btDescontoCodigo" style="margin-left: 3px; cursor: pointer; vertical-align: middle;" src="imagens/bt_pesquisa.png" title="Pesquisar">');

            btDescontoCodigo.click(function () {
                processando();

                if (composto == 'S') {
                    vl_evento = $('#vl_tot_pagamento').val();
                } else {
                    vl_evento = '<?php echo $_GET['valor_inscricao']; ?>';
                }

                $.ajax({
                    dataType: 'json',
                    type: 'POST',
                    url: ajax_sistema + '?tipo=consulta_desconto_pagamento',
                    data: {
                        cas: conteudo_abrir_sistema,
                        vl_evento: vl_evento,
                        idt_evento_publicacao: '<?php echo $rowEP['idt']; ?>',
                        idt_atendimento: '<?php echo $_GET['id']; ?>',
                        codigo_cupom: $('#codigo_cupom').val()
                    },
                    success: function (response) {
                        btFechaCTC($('#grc_evento_participante_pagamento').data('session_cod'));
                        btFechaCTC($('#grc_evento_participante_desconto').data('session_cod'));

                        $('#idt_evento_publicacao_cupom').val(response.idt_desconto);

                        if (response.erro != '') {
                            $('#dialog-processando').remove();
                            $('#codigo_cupom').val('');
                            alert(url_decode(response.erro));
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        alert('Erro no ajax no: ' + textStatus + ' - ' + errorThrown);
                    },
                    async: false
                });

                $('#dialog-processando').remove();
            });

            $('#codigo_cupom_obj').attr('nowrap', 'nowrap').append(btDescontoCodigo);

            $('#codigo_cupom').blur(function () {
                btDescontoCodigo.click();
            });

            if ('<?php echo $rowEP['desconto_porte']; ?>' == 'S') {
                $('#idt_porte').change(function () {
                    processando();

                    if (composto == 'S') {
                        vl_evento = $('#vl_tot_pagamento').val();
                    } else {
                        vl_evento = '<?php echo $_GET['valor_inscricao']; ?>';
                    }

                    $.ajax({
                        dataType: 'json',
                        type: 'POST',
                        url: ajax_sistema + '?tipo=GerarDescontoPorte',
                        data: {
                            cas: conteudo_abrir_sistema,
                            idt_porte: $('#idt_porte').val(),
                            idt_evento_publicacao: '<?php echo $rowEP['idt']; ?>',
                            vl_evento: vl_evento,
                            idt_atendimento: '<?php echo $_GET['id']; ?>'
                        },
                        success: function (response) {
                            btFechaCTC($('#grc_evento_participante_pagamento').data('session_cod'));
                            btFechaCTC($('#grc_evento_participante_desconto').data('session_cod'));

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
                });

                $('#idt_porte').change();
            }
        }
    });
</script>