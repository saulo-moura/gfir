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
//p($_GET);

if ($_GET['idCad'] != '') {
    $_GET['idt0'] = $_GET['idCad'];
    $botao_volta = "parent.btFechaCTC('".$_GET['session_cod']."');";
    $botao_acao = '<script type="text/javascript">parent.btFechaCTC("'.$_GET['session_cod'].'", parent.atualizaPrevisaoReceita);</script>';
}
//p($_GET);

$TabelaPai = "grc_evento";
$AliasPai = "grc_ppr";
$EntidadePai = "Programação de Evento";
$idPai = "idt";

//
$TabelaPrinc  = "grc_evento_insumo";
$AliasPric    = "grc_proins";
$Entidade     = "Insumo da Programação do Evento";
$Entidade_p   = "Insumos da Programação do Evento";
$CampoPricPai = "idt_evento";

$tabela = $TabelaPrinc;

$id = 'idt';
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

$vetCampo['quantidade']          = objDecimal('quantidade', 'Quantidade', true, 15, '', '', $js);
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
    $vetCampo['custo_total'] = objDecimal('custo_total', 'Custo Total(R$)', false, 10, '', 2, $completapar);
    $vetCampo['ctotal_minimo'] = objDecimal('ctotal_minimo', 'Custo Total Mínimo(R$)', false, 10, '', 2, $completapar);
    $vetCampo['ctotal_maximo'] = objDecimal('ctotal_maximo', 'Custo Total Máximo(R$)', false, 10, '', 2, $completapar);
}
$sql = "select idt, codigo, descricao from grc_insumo_unidade ";
$sql .= " order by codigo";
$vetCampo['idt_insumo_unidade'] = objCmbBanco('idt_insumo_unidade', 'Unidade', true, $sql, ' ', 'width:180px;');
$sql = "select idt, descricao from ".db_pir."sca_organizacao_secao ";
$sql .= " order by codigo";
$vetCampo['idt_area_suporte'] = objCmbBanco('idt_area_suporte', 'Área de Suporte', true, $sql, ' ', 'width:150px;');



$completapar = " ' ";
$vetCampo['atendimento_quantidade'] = objDecimal('atendimento_quantidade', 'Qtd. Atendida', false, 10, '', 2, $completapar);
$completapar = " readonly='true' style='background:#FFFF80;' ";
$vetCampo['atendimento_falta_atender'] = objDecimal('atendimento_falta_atender', 'Qtd. a Atender', false, 10, '', 2, $completapar);

$vetCampo['atendimento_data_prevista'] = objData('atendimento_data_prevista', 'Dt. Prevista', false, '', '', 'S');
$vetCampo['atendimento_data_real'] = objData('atendimento_data_real', 'Dt. Real', false, '', '', 'S');

$vetCampo['status'] = objTexto('status', 'Status', false, 15, 45);


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

    $vetFrm[] = Frame('<span>Quantificação</span>', Array(
        Array($vetCampo['quantidade'], '', $vetCampo['idt_insumo_unidade'], '', '', $vetCampo['custo_unitario_real'], '', $vetCampo['por_participante'], '', $vetCampo['receita_total'], '', $vetCampo['rtotal_minimo'], '', $vetCampo['rtotal_maximo']),
            ), $class_frame, $class_titulo, $titulo_na_linha);
} else {


    $vetFrm[] = Frame('<span>Quantificação</span>', Array(
        Array($vetCampo['idt_insumo_unidade'], '', '', $vetCampo['custo_unitario_real'], '', $vetCampo['por_participante'], '', $vetCampo['custo_total'], '', $vetCampo['ctotal_minimo'], '', $vetCampo['ctotal_maximo']),
            ), $class_frame, $class_titulo, $titulo_na_linha);
}








 $vetFrm[] = Frame('<span>Insumo Associado</span>', Array(
  Array($vetCampo['idt_area_suporte'],'',$vetCampo['status']),
  Array($vetCampo['quantidade'], '',$vetCampo['atendimento_data_prevista'],'',$vetCampo['atendimento_data_real']),
  Array($vetCampo['atendimento_quantidade'],'',$vetCampo['atendimento_falta_atender']),
  ),$class_frame,$class_titulo,$titulo_na_linha);




$vetFrm[] = Frame('<span></span>', Array(
    Array($vetCampo['detalhe']),
        ), $class_frame, $class_titulo, $titulo_na_linha);



$vetCad[] = $vetFrm;
?>



<script type="text/javascript">


    var veio = '<?php echo $veio; ?>';


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
        var participante_minimo = 0;
        var participante_maximo = 0;
        objd = parent.document.getElementById('participante_minimo');
        if (objd != null)
        {
            participante_minimo = objd.value;
        }

        objd = parent.document.getElementById('participante_maximo');
        if (objd != null)
        {
            participante_maximo = objd.value;
        }


        var por_participante = "N";


        objd = document.getElementById('por_participante');
        if (objd != null)
        {
            por_participante = objd.value;
        }

        if (por_participante == "N")
        {
            participante_minimo = 1;
            participante_maximo = 1;


        }



        var custo_unitario_real = 0;
        objd = document.getElementById('custo_unitario_real');
        if (objd != null)
        {
            var custo_unitario_realw = objd.value;
            custo_unitario_real = am_decimal(custo_unitario_realw);
        }

        var quantidadew = 0;
        objd = document.getElementById('quantidade');
        if (objd != null)
        {
            var quantidade = objd.value;

            quantidadew = am_decimal(quantidade);
            //quantidadew      = quantidade;
        }


        var custo_total = quantidadew * custo_unitario_real;
        var custo_totalw = format_decimal_n(custo_total, 2);

        var receita_total = quantidadew * custo_unitario_real;

        if (veio == 'R')
        {
            objd = document.getElementById('receita_total');
            if (objd != null)
            {
                objd.value = custo_totalw;
            }
        } else
        {
            objd = document.getElementById('custo_total');
            if (objd != null)
            {
                objd.value = custo_totalw;
            }

        }

        var ctotal_minimo = 0;
        var ctotal_maximo = 0;

        var rtotal_minimo = 0;
        var rtotal_maximo = 0;


        if (participante_minimo == 0)
        {
            participante_minimo = 1;
        }
        if (participante_maximo == 0)
        {
            participante_maximo = 1;
        }


        if (veio == 'R')
        {

            rtotal_minimo = participante_minimo * receita_total;
            rtotal_maximo = participante_maximo * receita_total;

        } else
        {
            ctotal_minimo = participante_minimo * custo_total;
            ctotal_maximo = participante_maximo * custo_total;
        }




        if (veio == 'R')
        {
            var rtotal_minimow = format_decimal_n(rtotal_minimo, 2);
            objd = document.getElementById('rtotal_minimo');
            if (objd != null)
            {
                objd.value = rtotal_minimow;
            }
            var rtotal_maximow = format_decimal_n(rtotal_maximo, 2);
            objd = document.getElementById('rtotal_maximo');
            if (objd != null)
            {
                objd.value = rtotal_maximow;
            }

        } else
        {
            var ctotal_minimow = format_decimal_n(ctotal_minimo, 2);
            objd = document.getElementById('ctotal_minimo');
            if (objd != null)
            {
                objd.value = ctotal_minimow;
            }
            var ctotal_maximow = format_decimal_n(ctotal_maximo, 2);
            objd = document.getElementById('ctotal_maximo');
            if (objd != null)
            {
                objd.value = ctotal_maximow;
            }


        }
    }
</script>