<style>
    fieldset.class_frame_f {
        background:#2F66B8;
        border:1px solid #FFFFFF;
    }

    div.class_titulo_f {
        background: #2F66B8;
        border    : 1px solid #2C3E50;
        color     : #FFFFFF;
        text-align: left;
        padding-top:10px;
    }

    div.class_titulo_f span {
        padding-left:20px;
        text-align: left;
    }

    fieldset.class_frame_p {
        background:#FFFFFF;
        border:0px solid #FFFFFF;
    }
    div.class_titulo_p {
        background: #2F66B8;
        text-align: left;
        border    : 0px solid #2C3E50;
        color     : #FFFFFF;
        text-align: left;
        height    : 20px;
        font-size : 12px;
        padding-top:5px;
    }

    div.class_titulo_p span {
        padding:10px;
        text-align: left;
    }

    div.class_titulo_p_barra {
        text-align: left;
        background: #2C3E50;
        border    : 0px solid #2C3E50;
        color     : #FFFFFF;
        font-weight: bold;
        line-height: 12px;
        margin: 0;
        padding: 3px;
        padding-left: 20px;
    }

    fieldset.class_frame {
        background:#FFFFFF;
        border:0px solid #2C3E50;
    }

    div.class_titulo {
        text-align: left;
        color     : black;
        border    : 0px solid #2C3E50;
    }

    div.class_titulo span {
        padding:10px;
    }

    div.class_titulo_c {
        text-align: center;
        background: #FFFFFF;
        color     : #FFFFFF;
        border    : 0px solid #2C3E50;
    }

    div.class_titulo_c span {
        padding-left:10px;
    }

    Select {
        border:0px;
    }

    .TextoFixo {
        font-size:12px;
        text-align:left;
        border:0px;
        background:#ECF0F1;
        font-weight:normal;
        font-family: Lato Regular, Calibri, Arial,  Helvetica, sans-serif;
        font-style: normal;
        word-spacing: 0px;
        padding-top:5px;
    }

    .Tit_Campo {
        font-size:12px;
    }

    td.Titulo {
        color:#666666;
    }

    .Texto {
        padding: 3px;
        padding-top: 5px;
        border:0;
    }
</style>
<?php
/*
 * Lembrar de alterar também no arquivo grc_evento_participante_pagamento.php
 */

$botao_volta = "parent.btFechaCTC('" . $_GET['session_cod'] . "');";
$botao_acao = '<script type="text/javascript">parent.btFechaCTC("' . $_GET['session_cod'] . '", parent.funcaoFechaCTC_grc_atendimento_evento_dimensionamento, null, returnVal);</script>';

$TabelaPrinc = "grc_atendimento_evento_pagamento";
$AliasPric = "grc_evepar";
$Entidade = "Pagamento do Participante";
$Entidade_p = "Pagamento do Participante";
$CampoPricPai = "idt_atendimento_evento";

$onSubmitDep = 'grc_atendimento_evento_pagamento_dep()';

$sql = '';
$sql .= ' select idt_atendimento, idt_instrumento';
$sql .= ' from grc_atendimento_evento';
$sql .= ' where idt = ' . null($_GET['idCad']);
$rs = execsql($sql);
$idt_atendimento = $rs->data[0]['idt_atendimento'];
$idt_instrumento = $rs->data[0]['idt_instrumento'];

$sql = '';
$sql .= ' select *';
$sql .= ' from grc_atendimento_evento_pagamento';
$sql .= ' where idt = ' . null($_GET['id']);
$rs = execsql($sql);
$row = $rs->data[0];

if ($row['rm_idmov'] != '' && $acao != 'con') {
    $_GET['acao'] = 'con';
    $acao = 'con';
    alert('Não pode alterar este pagamento, pois já esta integrado com o RM!');
}

$tabela = $TabelaPrinc;
$id = 'idt';

$vetCampo[$CampoPricPai] = objHidden($CampoPricPai, $_GET['idCad']);

$vetCampo['idt_evento_situacao_pagamento'] = objFixoBanco('idt_evento_situacao_pagamento', 'Status do Pagamento', 'grc_evento_situacao_pagamento', 'idt', 'descricao');

$vetCampo['data_pagamento'] = objData('data_pagamento', 'Data do Pagamento', true, '', '', 'S');
$vetCampo['data_vencimento'] = objData('data_vencimento', 'Data do Vencimento', false, '', '', 'S');
$vetCampo['valor_pagamento'] = objDecimal('valor_pagamento', 'Valor do Pagamento', true, 15);
$vetCampo['valor_apagar'] = objTextoFixo('valor_apagar', 'Valor a Pagar', 15);

$sql = "select idt, descricao from grc_evento_natureza_pagamento ";
$sql .= " where ativo = 'S'";
$sql .= " and desconto = 'N'";
$sql .= " order by codigo";
$vetCampo['idt_evento_natureza_pagamento'] = objCmbBanco('idt_evento_natureza_pagamento', 'Forma de Pagamento', true, $sql);

$sql = "select idt, descricao from grc_evento_cartao_bandeira ";
$sql .= " where ativo = 'S'";
$sql .= " order by codigo";
$vetCampo['idt_evento_cartao_bandeira'] = objCmbBanco('idt_evento_cartao_bandeira', 'Bandeira', false, $sql);

$sql = "select idt, codigo from grc_evento_forma_parcelamento ";
$sql .= ' where idt_natureza = ' . null($row['idt_evento_natureza_pagamento']);
$sql .= " and ativo = 'S'";
$sql .= " order by numero_de_parcelas";
$vetCampo['idt_evento_forma_parcelamento'] = objCmbBanco('idt_evento_forma_parcelamento', 'Parcelas', false, $sql);

$vetCampo['codigo_nsu'] = objTexto('codigo_nsu', 'Código NSU', false, 10);

$sql = "select idt, codigo, descricao from grc_evento_estabelecimento ";
$sql .= " where ativo = 'S'";
$sql .= " order by descricao, codigo";
$vetCampo['idt_evento_estabelecimento'] = objCmbBanco('idt_evento_estabelecimento', 'Código do Estabelecimento', false, $sql);

$vetParametros = Array(
    'width' => '100%',
);

$vetFrm = Array();

MesclarCol($vetCampo[$CampoPricPai], 9);
MesclarCol($vetCampo['idt_evento_estabelecimento'], 3);

$vetFrm[] = Frame('', Array(
    Array($vetCampo[$CampoPricPai]),
    Array($vetCampo['idt_evento_situacao_pagamento'], '', $vetCampo['idt_evento_natureza_pagamento'], '', $vetCampo['data_pagamento'], '', $vetCampo['valor_pagamento'], '', $vetCampo['valor_apagar']),
    Array($vetCampo['idt_evento_cartao_bandeira'], '', $vetCampo['idt_evento_forma_parcelamento'], '', $vetCampo['codigo_nsu'], '', $vetCampo['idt_evento_estabelecimento']),
        ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);

$vetCampo['ch_numero'] = objTexto('ch_numero', 'Número do Cheque', false, 20);
$vetCampo['ch_banco'] = objTexto('ch_banco', 'Número do Banco', false, 3);
$vetCampo['ch_agencia'] = objTexto('ch_agencia', 'Agência', false, 6);
$vetCampo['ch_cc'] = objTexto('ch_cc', 'Conta Corrente', false, 15);
$vetCampo['emitente_nome'] = objTexto('emitente_nome', 'Nome do Emitente', false, 30);
$vetCampo['emitente_tel'] = objTelefone('emitente_tel', 'Telefone  do Emitente', false);

MesclarCol($vetCampo['data_vencimento'], 3);

$vetFrm[] = Frame('<span>Dados do Cheque</span>', Array(
    Array($vetCampo['ch_numero'], '', $vetCampo['ch_banco'], '', $vetCampo['ch_agencia'], '', $vetCampo['ch_cc']),
    Array($vetCampo['emitente_nome'], '', $vetCampo['emitente_tel'], '', $vetCampo['data_vencimento']),
        ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);

//Dados do Parceiro
$vetCampo['usa_parceiro'] = objCmbVetor('usa_parceiro', 'Utiliza Parceiro?', True, $vetNaoSim, '');
$vetCampo['par_cnpj'] = objCNPJ('par_cnpj', 'CNPJ', false);
$vetCampo['par_razao_social'] = objTexto('par_razao_social', 'Razão Social', false, 60, 120);
$vetCampo['par_nome_fantasia'] = objTexto('par_nome_fantasia', 'Nome Fantasia', false, 60, 80);

$vetParametrosCEP = Array(
    'consulta_cep' => true,
    'campo_uf' => 'par_estado',
    'campo_cidade' => 'par_cidade',
    'campo_bairro' => 'par_bairro',
    'campo_logradouro' => 'par_rua',
);
$vetCampo['par_cep'] = objCEP('par_cep', 'CEP', false, $vetParametrosCEP);
$vetCampo['par_rua'] = objTexto('par_rua', 'Logradouro', false, 60, 120);
$vetCampo['par_numero'] = objTexto('par_numero', 'Número', false, 6, 6);
$vetCampo['par_bairro'] = objTexto('par_bairro', 'Bairro', false, 60, 120);
$vetCampo['par_cidade'] = objTexto('par_cidade', 'Cidade', false, 60, 120);
$vetCampo['par_estado'] = objTexto('par_estado', 'Estado', false, 2, 2);

$par = 'par_cnpj,par_razao_social,par_nome_fantasia,par_cep,par_rua,par_numero,par_bairro,par_cidade,par_estado';
$vetDesativa['usa_parceiro'][0] = vetDesativa($par);
$vetAtivadoObr['usa_parceiro'][0] = vetAtivadoObr($par);

MesclarCol($vetCampo['par_cnpj'], 3);
MesclarCol($vetCampo['par_nome_fantasia'], 3);

$vetFrm[] = Frame('<span>O pagamento vai ser realizado por um Parceiro</span>', Array(
    Array($vetCampo['usa_parceiro'], '', $vetCampo['par_cnpj']),
    Array($vetCampo['par_razao_social'], '', $vetCampo['par_nome_fantasia']),
    Array($vetCampo['par_cep'], '', $vetCampo['par_rua'], '', $vetCampo['par_numero']),
    Array($vetCampo['par_bairro'], '', $vetCampo['par_cidade'], '', $vetCampo['par_estado']),
        ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);

$vetCad[] = $vetFrm;

$sql = '';
$sql .= ' select idt_evento_natureza_pagamento, qtd_limite';
$sql .= ' from grc_evento_natureza_pagamento_instrumento';
$sql .= ' where idt_atendimento_instrumento = ' . null($idt_instrumento);
$rsPI = execsql($sql);

$vetQtd = Array();
$vetPI = Array();
$vetPI[] = "''";

foreach ($rsPI->data as $rowPI) {
    $vetPI[$rowPI['idt_evento_natureza_pagamento']] = aspa($rowPI['idt_evento_natureza_pagamento']);
    $vetQtd[$rowPI['idt_evento_natureza_pagamento']]['limite'] = $rowPI['qtd_limite'];
    $vetQtd[$rowPI['idt_evento_natureza_pagamento']]['tot'] = 0;
}

$emitente_nome = $row['emitente_nome'];
$emitente_tel = $row['emitente_tel'];

if ($emitente_nome == '' || $emitente_tel == '') {
    $sql = '';
    $sql .= ' select nome, coalesce(telefone_celular, telefone_recado, telefone_residencial) as telefone';
    $sql .= ' from grc_atendimento_pessoa';
    $sql .= ' where idt_atendimento = ' . null($idt_atendimento);
    $sql .= " and tipo_relacao = 'L'";
    $rs = execsql($sql);
    $rowt = $rs->data[0];

    if ($emitente_nome == '') {
        $emitente_nome = $rowt['nome'];
    }

    if ($emitente_tel == '') {
        $emitente_tel = $rowt['telefone'];
    }
}

$emitente_nome = truncaString($emitente_nome, 30);

$sql = '';
$sql .= ' select idt_evento_natureza_pagamento, count(idt) as tot';
$sql .= ' from grc_atendimento_evento_pagamento';
$sql .= ' where idt_atendimento_evento = ' . null($_GET['idCad']);
$sql .= ' and idt <> ' . null($_GET['id']);
$sql .= " and estornado <> 'S'";
$sql .= ' group by idt_evento_natureza_pagamento';
$rst = execsql($sql);

foreach ($rst->data as $rowt) {
    $vetQtd[$rowt['idt_evento_natureza_pagamento']]['tot'] = $rowt['tot'];
}
?>
<script type="text/javascript">
    var acao = '<?php echo $acao; ?>';
    var vetPI = [<?php echo implode(', ', $vetPI); ?>];
    var vetQtd = <?php echo json_encode($vetQtd); ?>;

    $(document).ready(function () {
        $("#idt_evento_forma_parcelamento").cascade("#idt_evento_natureza_pagamento", {
            ajax: {
                url: ajax_sistema + '?tipo=evento_natureza_forma_parcelamento&cas=' + conteudo_abrir_sistema
            },
            datalist: ['valor_ini']
        });

        $('#valor_pagamento').change(function () {
            checaValor();
            grc_atendimento_evento_pagamento_dep();
        });

        $('#idt_evento_forma_parcelamento').bind('cascade', function (event, chain) {
            travaCampo();
        });

        $('#idt_evento_natureza_pagamento > option').prop("disabled", 'true').addClass("campo_disabled");

        $('#idt_evento_natureza_pagamento > option').each(function () {
            if ($.inArray($(this).val(), vetPI) != -1) {
                $(this).removeProp("disabled").removeClass("campo_disabled");
            }
        });

        $('#idt_evento_natureza_pagamento option:disabled:selected').removeProp('selected');

        $('#idt_evento_natureza_pagamento').change(function () {
            var idt = $(this).val();

            if (idt == '') {
                return true;
            }

            var limite = parseInt(vetQtd[idt]['limite']);

            if (!isNaN(limite)) {
            var tot = parseInt(vetQtd[idt]['tot']);

            tot++;

            if (tot > limite) {
                alert('Não pode selecionar esta Forma de Pagamento, pois vai exceder o limite de ' + limite + ' registro!');
                $('#idt_evento_natureza_pagamento option:selected').removeProp('selected');
                $(this).change();
                $(this).focus();
                return false;
            }
            }
        });

        $('#par_cnpj').change(function () {
            if ($('#par_cnpj').val() != '') {
                processando();

                $.ajax({
                    dataType: 'json',
                    type: 'POST',
                    url: ajax_sistema + '?tipo=consultaCnpjRM',
                    data: {
                        cas: conteudo_abrir_sistema,
                        par_cnpj: $('#par_cnpj').val()
                    },
                    success: function (response) {
                        if (response.erro == '') {
                            var campo = $('#par_razao_social, #par_nome_fantasia, #par_cep, #par_rua, #par_numero, #par_bairro, #par_cidade, #par_estado');
                            var obr = $('#par_razao_social_desc, #par_nome_fantasia_desc, #par_cep_desc, #par_rua_desc, #par_numero_desc, #par_bairro_desc, #par_cidade_desc, #par_estado_desc');

                            if (url_decode(response.cadastrado) == 'S') {
                                campo.each(function () {
                                    var id = $(this).attr('id');
                                    $(this).val(url_decode(response[id]));
                                });

                                func_AtivaDesativa('n', ",n".split(","), campo, obr, "n".split(","), "S", "S", '', false);
                            } else {
                                func_AtivaDesativa('s', ",n".split(","), campo, obr, "s".split(","), "S", "S");
                            }
                        } else {
                            alert(url_decode(response.erro));
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        alert('Erro no ajax no: ' + textStatus + ' - ' + errorThrown);
                    },
                    async: false
                });

                $('#dialog-processando').remove();
            }
        });

        if (acao == 'alt' || acao == 'inc') {
            $('#idt_evento_natureza_pagamento').change();

            setTimeout(function () {
                $('#par_cnpj').change();
            }, 500);
        }
    });

    function travaCampo() {
        $('#idt_evento_cartao_bandeira, #idt_evento_forma_parcelamento, #codigo_nsu, #idt_evento_estabelecimento, #ch_numero, #ch_banco, #ch_agencia, #ch_cc, #emitente_nome, #emitente_tel, #data_vencimento').prop("disabled", 'true').addClass("campo_disabled");
        $('#idt_evento_cartao_bandeira_desc, #idt_evento_forma_parcelamento_desc, #codigo_nsu_desc, #idt_evento_estabelecimento_desc, #ch_numero_desc, #ch_banco_desc, #ch_agencia_desc, #ch_cc_desc, #emitente_nome_desc, #emitente_tel_desc, #data_vencimento_desc').addClass("Tit_Campo").removeClass("Tit_Campo_Obr");

        $('#data_vencimento_obj .ui-datepicker-trigger').hide();

        switch ($('#idt_evento_natureza_pagamento').val()) {
            case '2': //Cartão de Crédito A Vista
                $('#idt_evento_cartao_bandeira, #codigo_nsu, #idt_evento_estabelecimento').removeProp("disabled").removeClass("campo_disabled");
                $('#idt_evento_cartao_bandeira_desc, #codigo_nsu_desc, #idt_evento_estabelecimento_desc').addClass("Tit_Campo_Obr").removeClass("Tit_Campo");
                break;

            case '5': //Cartão de Débito
                $('#idt_evento_cartao_bandeira, #codigo_nsu, #idt_evento_estabelecimento').removeProp("disabled").removeClass("campo_disabled");
                $('#idt_evento_cartao_bandeira_desc, #codigo_nsu_desc, #idt_evento_estabelecimento_desc').addClass("Tit_Campo_Obr").removeClass("Tit_Campo");
                break;

            case '6': //Cartão de Crédito Parcelado
                $('#idt_evento_cartao_bandeira, #idt_evento_forma_parcelamento, #codigo_nsu, #idt_evento_estabelecimento').removeProp("disabled").removeClass("campo_disabled");
                $('#idt_evento_cartao_bandeira_desc, #idt_evento_forma_parcelamento_desc, #codigo_nsu_desc, #idt_evento_estabelecimento_desc').addClass("Tit_Campo_Obr").removeClass("Tit_Campo");
                break;

            case '8': //Cheque
                $('#ch_numero, #ch_banco, #ch_agencia, #ch_cc, #emitente_nome, #emitente_tel, #data_vencimento').removeProp("disabled").removeClass("campo_disabled");
                $('#ch_numero_desc, #ch_banco_desc, #ch_agencia_desc, #ch_cc_desc, #emitente_nome_desc, #emitente_tel_desc, #data_vencimento_desc').addClass("Tit_Campo_Obr").removeClass("Tit_Campo");

                $('#data_vencimento_obj .ui-datepicker-trigger').show();

                $('#emitente_nome').val('<?php echo $emitente_nome; ?>');
                $('#emitente_tel').val('<?php echo $emitente_tel; ?>');
                break;
        }

        if ($('#idt_evento_natureza_pagamento').val() != '') {
            if ($('#idt_evento_cartao_bandeira:disabled').length == 1) {
                $('#idt_evento_cartao_bandeira').val('');
            }

            if ($('#idt_evento_forma_parcelamento:disabled').length == 1) {
                $('#idt_evento_forma_parcelamento').find('option:last').prop('selected', 'true');
            }

            if ($('#codigo_nsu:disabled').length == 1) {
                $('#codigo_nsu').val('');
            }

            if ($('#idt_evento_estabelecimento:disabled').length == 1) {
                $('#idt_evento_estabelecimento option:selected').removeProp('selected');
            }

            $('#ch_numero, #ch_banco, #ch_agencia, #ch_cc, #emitente_nome, #emitente_tel').each(function () {
                if ($(this).prop('disabled')) {
                    $(this).val('');
                }
            });
        }

        checaValor();
    }

    function checaValor() {
        if ($('#idt_evento_forma_parcelamento').prop('disabled') == false) {
            var vl = str2float($('#valor_pagamento').val());
            var vlOpt = 0;

            if (isNaN(vl)) {
                vl = 0;
            }

            $('#idt_evento_forma_parcelamento > option').removeProp("disabled").removeClass("campo_disabled");

            $('#idt_evento_forma_parcelamento > option').each(function () {
                vlOpt = str2float($(this).data('valor_ini'));

                if (isNaN(vlOpt)) {
                    vlOpt = 0;
                }

                if (vlOpt > vl) {
                    $(this).prop("disabled", 'true').addClass("campo_disabled").removeProp("selected");
                }
            });
        }
    }

    function grc_atendimento_evento_pagamento_dep() {
        if (valida == 'S') {
            var valor_pagamento = str2float($('#valor_pagamento').val());

            if (isNaN(valor_pagamento)) {
                valor_pagamento = 0;
            }

            if (valor_pagamento <= 0) {
                alert('O Valor do Pagamento tem que ser maior que zero!');
                $('#valor_pagamento').val('');
                $('#valor_pagamento').focus();
                return false;
            }

            var valor_apagar = str2float($('#valor_apagar').val());

            if (isNaN(valor_apagar)) {
                valor_apagar = 0;
            }

            if (valor_pagamento > valor_apagar) {
                alert('O Valor do Pagamento não pode ser maior que Valor a Pagar');
                $('#valor_pagamento').val('');
                $('#valor_pagamento').focus();
                return false;
            }

            if (validaDataMenor(false, $('#data_pagamento'), 'Pagamento', $('#dtBancoObj'), 'Hoje') === false) {
                $('#data_pagamento').focus();
                return false;
            }

            if ($('#data_vencimento').val() != '') {
                if (validaDataMaior(false, $('#data_vencimento'), 'Vencimento', $('#data_pagamento'), 'Pagamento') === false) {
                    $('#data_vencimento').focus();
                    return false;
                }
            }
        }

        return true;
    }
</script>
