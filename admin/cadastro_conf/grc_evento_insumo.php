<style>
    #nm_funcao_desc label{
    }
    #nm_funcao_obj {
    }
    .Tit_Campo {
    }
    .Tit_Campo_Obr {
    }
    fieldset.class_frame {
        background:#ECF0F1;
        border:1px solid #14ADCC;
    }
    div.class_titulo {
        background: #ABBBBF;
        border    : 1px solid #14ADCC;
        color     : #FFFFFF;
        text-align: left;
    }
    div.class_titulo span {
        padding-left:10px;
    }
</style>

<?php
if ($_GET['idCad'] != '') {
    $_GET['idt0'] = $_GET['idCad'];
    $botao_volta = "parent.btFechaCTC('".$_GET['session_cod']."');";
    $botao_acao = '<script type="text/javascript">parent.btFechaCTC("'.$_GET['session_cod'].'", parent.atualizaPrevisaoReceita);</script>';
}

$onSubmitDep = 'grc_evento_insumo_dep()';

$TabelaPai = "grc_evento";
$AliasPai = "grc_ppr";
$EntidadePai = "Programação de Evento";
$idPai = "idt";

//
$TabelaPrinc = "grc_evento_insumo";
$AliasPric = "grc_proins";
$Entidade = "Insumo da Programação do Evento";
$Entidade_p = "Insumos da Programação do Evento";
$CampoPricPai = "idt_evento";

$tabela = $TabelaPrinc;
$id = 'idt';

$sql = '';
$sql .= ' select idt_profissional';
$sql .= ' from grc_evento_insumo';
$sql .= ' where idt = '.null($_GET['id']);
$rs = execsql($sql);
$row = $rs->data[0];

$vetCampo[$CampoPricPai] = objFixoBanco($CampoPricPai, $EntidadePai, $TabelaPai, 'idt', 'descricao', 0);

$vetCampo['codigo'] = objTexto('codigo', 'Código', false, 15, 45);
$vetCampo['descricao'] = objTexto('descricao', 'Complemento da Descrição', false, 60, 120);
$vetCampo['ativo'] = objCmbVetor('ativo', 'Ativo?', True, $vetSimNao);
//
$maxlength = 2000;
$style = "width:700px;";
$js = "";
$vetCampo['detalhe'] = objTextArea('detalhe', 'Observações', false, $maxlength, $style, $js);

if ($veio == 'R') {
    $desc = 'Receita Associada';
} else {
    $desc = 'Insumo Associada';
}

$vetCampo['idt_insumo'] = objListarCmb('idt_insumo', 'grc_insumo_cmb', $desc, true);





$js = " onchange = 'return TotailInsumo();' ";

$vetCampo['quantidade'] = objDecimal('quantidade', 'Quantidade', true, 15, '', '', $js);
$vetCampo['custo_unitario_real'] = objDecimal('custo_unitario_real', 'Custo Unitario (R$)', true, 15, '', '', $js);


$vetCampo['por_participante'] = objCmbVetor('por_participante', 'Por Participante?', True, $vetSimNao, '', $js);




$completapar = " readonly='true' style='background:#FFFF80;' ";

//$vetCampo['custo_total'] = objDecimal('custo_total','Custo Total(R$)',false,10,'',2,$completapar);
//$vetCampo['ctotal_minimo'] = objDecimal('ctotal_minimo','Custo Total Mínimo(R$)',false,10,'',2,$completapar);
//$vetCampo['ctotal_maximo'] = objDecimal('ctotal_maximo','Custo Total Máximo(R$)',false,10,'',2,$completapar);

if ($veio == 'R') {
    $vetCampo['receita_total'] = objDecimal('receita_total', 'Receita Total(R$)', false, 10, '', 2, $completapar);
    $vetCampo['rtotal_minimo'] = objDecimal('rtotal_minimo', 'Receita Total   Mínimo(R$)', false, 10, '', 2, $completapar);
    $vetCampo['rtotal_maximo'] = objDecimal('rtotal_maximo', 'Receita Total Máximo(R$)', false, 10, '', 2, $completapar);
} else {
    $vetCampo['custo_total'] = objDecimal('custo_total', 'Custo Total (R$)', false, 10, '', 2, $completapar);
    $vetCampo['ctotal_minimo'] = objDecimal('ctotal_minimo', 'Custo Total Mínimo (R$)', false, 10, '', 2, $completapar);
    $vetCampo['ctotal_maximo'] = objDecimal('ctotal_maximo', 'Custo Total Máximo (R$)', false, 10, '', 2, $completapar);
}

$vetCampo['quantidade_evento'] = objDecimal('quantidade_evento', 'Quantidade a ser Atendida', false, 10, '', 2, $completapar);



$sql = "select idt, codigo, descricao from grc_insumo_unidade ";
$sql .= " order by codigo";
$vetCampo['idt_insumo_unidade'] = objCmbBanco('idt_insumo_unidade', 'Unidade', true, $sql, ' ', 'width:180px;');


$sql = "select idt, descricao from ".db_pir."sca_organizacao_secao ";
$sql .= " order by codigo";
$vetCampo['idt_area_suporte'] = objCmbBanco('idt_area_suporte', 'Unidade de Suporte', false, $sql, ' ', 'width:150px;');

if ($row['idt_profissional'] == '' || $_GET['origem_evento_tela'] == 'compra') {
    $vetCampo['qtd_automatico'] = objHidden('qtd_automatico', 'N');
} else {
    $acao_alt_con = 'S';
    $vetCampo['qtd_automatico'] = objCmbVetor('qtd_automatico', 'Qtd. Automatico?', True, $vetSimNao);
}

//
$vetFrm = Array();
$vetFrm[] = Frame('<span>Produto</span>', Array(
    Array($vetCampo[$CampoPricPai]),
        ), $class_frame, $class_titulo, $titulo_na_linha);

//MesclarCol($vetCampo['idt_situacao'], 3);
/*
  $vetFrm[] = Frame('<span>Insumo Associado</span>', Array(
  Array($vetCampo['idt_insumo']),
  ),$class_frame,$class_titulo,$titulo_na_linha);
 */

$vetFrm[] = Frame('<span>Identificação</span>', Array(
    Array($vetCampo['idt_insumo'], '', $vetCampo['descricao'], '', $vetCampo['ativo']),
        ), $class_frame, $class_titulo, $titulo_na_linha);


/*
  $vetFrm[] = Frame('<span>Classificação</span>', Array(
  Array($vetCampo['quantidade'],'',$vetCampo['idt_insumo_unidade'],'','',$vetCampo['custo_unitario_real'],'',$vetCampo['por_participante'],'',$vetCampo['custo_total'],'',$vetCampo['ctotal_minimo'],'',$vetCampo['ctotal_maximo']),
  ),$class_frame,$class_titulo,$titulo_na_linha);
 */

if ($veio == 'R') {
    MesclarCol($vetCampo['qtd_automatico'], 13);

    $vetFrm[] = Frame('<span>Quantificação</span>', Array(
        Array($vetCampo['qtd_automatico']),
        Array($vetCampo['idt_area_suporte'], '', $vetCampo['quantidade'], '', $vetCampo['idt_insumo_unidade'], '', $vetCampo['custo_unitario_real'], '', $vetCampo['por_participante']),
        Array($vetCampo['quantidade_evento'], '', $vetCampo['receita_total'], '', $vetCampo['rtotal_minimo'], '', $vetCampo['rtotal_maximo']),
        ), $class_frame, $class_titulo, $titulo_na_linha);
} else {
    MesclarCol($vetCampo['qtd_automatico'], 9);
    MesclarCol($vetCampo['ctotal_maximo'], 3);

    $vetFrm[] = Frame('<span>Quantificação</span>', Array(
        Array($vetCampo['qtd_automatico']),
        Array($vetCampo['idt_area_suporte'], '', $vetCampo['quantidade'], '', $vetCampo['idt_insumo_unidade'], '', $vetCampo['custo_unitario_real'], '', $vetCampo['por_participante']),
        Array($vetCampo['quantidade_evento'], '', $vetCampo['custo_total'], '', $vetCampo['ctotal_minimo'], '', $vetCampo['ctotal_maximo']),
            ), $class_frame, $class_titulo, $titulo_na_linha);
}

$vetFrm[] = Frame('<span></span>', Array(
    Array($vetCampo['detalhe']),
        ), $class_frame, $class_titulo, $titulo_na_linha);


if ($_GET['origem_evento_tela'] == 'compra') {
    $acao_alt_con = 'S';

    $vetCampo['status'] = objCmbVetor('status', 'Status do Insumo', true, $vetEventoStsInsumo);

    $vetFrm[] = Frame('<span>Atendimento</span>', Array(
        Array($vetCampo['status']),
            ), $class_frame, $class_titulo, $titulo_na_linha);
}

$vetCad[] = $vetFrm;
?>



<script type="text/javascript">
    var veio = '<?php echo $veio; ?>';

    var origem_evento_tela = '<?php echo $_GET['origem_evento_tela']; ?>';

    $(document).ready(function () {
        if (acao == 'inc' || acao == 'alt') {
            if (origem_evento_tela == 'compra') {
                setTimeout(function () {
                    $('#status').removeProp("disabled").removeClass("campo_disabled");
                }, 100);
            }

            $('#qtd_automatico').change(function () {
                if ($(this).data('tipo') == 'Hidden') {
                    return;
                }

                if ($(this).val() == 'S') {
                    $('#quantidade').prop("disabled", true).addClass("campo_disabled");
                } else {
                    $('#quantidade').removeProp("disabled").removeClass("campo_disabled");
                }
            });

            setTimeout(function () {
                $('#qtd_automatico').change();
            }, 100);

            if (acao_alt_con == 'S') {
                setTimeout(function () {
                    $('#qtd_automatico, #detalhe').removeProp("disabled").removeClass("campo_disabled").change();
                }, 100);
            }
        }
    });

    function grc_evento_insumo_dep() {
        if ('<?php echo $row['idt_profissional']; ?>' != '') {
            var msg = '';
            processando();

            $.ajax({
                dataType: 'json',
                type: 'POST',
                url: ajax_sistema + '?tipo=grc_evento_insumo_valida',
                data: {
                    cas: conteudo_abrir_sistema,
                    idt: '<?php echo $_GET['id']; ?>',
                    quantidade: $('#quantidade').val(),
                    idt_evento: '<?php echo $_GET['idt0']; ?>'
                },
                success: function (response) {
                    if (response.erro != '') {
                        msg += url_decode(response.erro);
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    $('#dialog-processando').remove();
                    alert('Erro no ajax no: ' + textStatus + ' - ' + errorThrown);
                },
                async: false
            });

            $('#dialog-processando').remove();

            if (msg != '') {
                alert(msg);
                return false;
            }
        }

        return true;
    }

    function parListarCmb_idt_insumo() {
        var par = '';

        par += '&veio=' + veio;

        return par;
    }

    function fncListarCmbMuda_idt_insumo(valor) {
        //
        // BUSCAR VALORES
        //
        /*
         var participante_minimo = 0;
         var participante_maximo = 0;
         objd=parent.document.getElementById('participante_minimo');
         if (objd != null)
         {
         participante_minimo = objd.value;
         }
         
         objd=parent.document.getElementById('participante_maximo');
         if (objd != null)
         {
         participante_maximo = objd.value;
         }
         */

//	alert('valor do idt_insumo: ' + valor);


        var idt_insumo = 0;
        objd = document.getElementById('idt_insumo');
        if (objd != null)
        {
            idt_insumo = objd.value;
        }
//    alert(' id '+idt_insumo);


        var str = '';
        $.post('ajax2.php?tipo=buscar_insumo', {
            async: true,
            idt_insumo: idt_insumo
        }, function (str) {
            if (str == '') {
                alert('ERRO voltou nada');
            } else {
                var ret = str.split('###');

                var codigo = ret[0];
                var descricao = ret[1];
                var ativo = ret[2];
                var detalhe = ret[3];
                var classificacao = ret[4];
                var idt_insumo_elemento_custo = ret[5];
                var idt_insumo_unidade = ret[6];
                var custo_unitario_real = ret[7];
                var por_participante = ret[8];
                var nivel = ret[9];

                //alert(' bbbb '+custo_unitario_real);
                var custo_unitario_realw = format_decimal_n(ret[7], 2);

                objd = document.getElementById('custo_unitario_real');
                if (objd != null)
                {
                    objd.value = custo_unitario_realw;
                }

                objd = document.getElementById('idt_insumo_unidade');
                if (objd != null)
                {
                    objd.value = idt_insumo_unidade;
                }


                objd = document.getElementById('por_participante');
                if (objd != null)
                {
                    objd.value = por_participante;
                }


                objd = document.getElementById('ativo');
                if (objd != null)
                {
                    objd.value = ativo;
                }

                objd = document.getElementById('detalhe');
                if (objd != null)
                {
                    objd.value = detalhe;
                }



                TotailInsumo();

                /*
                 var quantidadew   = 0; 
                 objd=document.getElementById('quantidade');
                 if (objd != null)
                 {
                 var quantidade = objd.value;
                 
                 quantidadew    = am_decimal(quantidade);
                 //quantidadew      = quantidade;
                 }
                 
                 
                 var custo_total  = quantidadew * custo_unitario_real;
                 var custo_totalw = format_decimal_n(custo_total,2);
                 objd=document.getElementById('custo_total');
                 if (objd != null)
                 {
                 objd.value = custo_totalw;
                 }
                 
                 
                 var ctotal_minimo = 0;
                 var ctotal_maximo = 0;
                 
                 if (participante_minimo==0)
                 {
                 participante_minimo=1;
                 }
                 if (participante_maximo==0)
                 {
                 participante_maximo=1;
                 }
                 
                 
                 ctotal_minimo = participante_minimo * custo_total;
                 ctotal_maximo = participante_maximo * custo_total;
                 
                 
                 var ctotal_minimow = format_decimal_n(ctotal_minimo,2);
                 objd=document.getElementById('ctotal_minimo');
                 if (objd != null)
                 {
                 objd.value = ctotal_minimow;
                 }
                 var ctotal_maximow = format_decimal_n(ctotal_maximo,2);
                 objd=document.getElementById('ctotal_maximo');
                 if (objd != null)
                 {
                 objd.value = ctotal_maximow;
                 }
                 
                 // innerHTML
                 */

                //alert(str);
            }
        });
    }

    function TotailInsumo() {
        var participante_minimo = '<?php echo $_GET['participante_minimo']; ?>';
        participante_minimo = parseFloat(participante_minimo);

        if (isNaN(participante_minimo)) {
            participante_minimo = 0;
        }

        var participante_maximo = '<?php echo $_GET['participante_maximo']; ?>';
        participante_maximo = parseFloat(participante_maximo);

        if (isNaN(participante_maximo)) {
            participante_maximo = 0;
        }

        var quantidade_participante = '<?php echo $_GET['quantidade_participante']; ?>';
        quantidade_participante = str2float(quantidade_participante);

        if (isNaN(quantidade_participante)) {
            quantidade_participante = 0;
        }

        var quantidade = $('#quantidade').val();
        quantidade = str2float(quantidade);

        if (isNaN(quantidade)) {
            quantidade = 0;
        }

        var por_participante = $('#por_participante').val();

        if (por_participante == "N") {
            participante_minimo = 1;
            participante_maximo = 1;
            quantidade_participante = 1;
        }

        var quantidade_evento = quantidade_participante * quantidade;

        var custo_unitario_real = $('#custo_unitario_real').val();
        custo_unitario_real = str2float(custo_unitario_real);

        if (isNaN(custo_unitario_real)) {
            custo_unitario_real = 0;
        }

        var custo_total = quantidade_evento * custo_unitario_real;
        var receita_total = quantidade_evento * custo_unitario_real;

        if (veio == 'R') {
            $('#receita_total').val(float2str(receita_total));
        } else {
            $('#custo_total').val(float2str(custo_total));
        }

        var ctotal_minimo = 0;
        var ctotal_maximo = 0;

        var rtotal_minimo = 0;
        var rtotal_maximo = 0;

        if (veio == 'R') {
            rtotal_minimo = participante_minimo * quantidade * custo_unitario_real;
            rtotal_maximo = participante_maximo * quantidade * custo_unitario_real;
        } else {
            ctotal_minimo = participante_minimo * quantidade * custo_unitario_real;
            ctotal_maximo = participante_maximo * quantidade * custo_unitario_real;
        }

        if (veio == 'R') {
            $('#rtotal_minimo').val(float2str(rtotal_minimo));
            $('#rtotal_maximo').val(float2str(rtotal_maximo));
        } else {
            $('#ctotal_minimo').val(float2str(ctotal_minimo));
            $('#ctotal_maximo').val(float2str(ctotal_maximo));
        }

        $('#quantidade_evento').val(float2str(quantidade_evento));
    }
</script>