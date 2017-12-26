<style>
    #nm_funcao_desc label{
    }
    #nm_funcao_obj {
    }
    .Tit_Campo {
    }
    .Tit_Campo_Obr {
    }
    fieldset.class_frame_f {
        background:#2F66B8;
        border:1px solid #FFFFFF;
        height:30px;
    }
    div.class_titulo_f {
        background: #2F66B8;
        border    : 1px solid #2C3E50;
        color     : #FFFFFF;
        text-align: left;
        height:30px;
        padding-top:10px;
    }
    div.class_titulo_f span {
        padding-left:20px;
        text-align: left;
    }
    fieldset.class_frame_p {
        background:#ABBBBF;
        border:1px solid #FFFFFF;
    }
    div.class_titulo_p {
        background: #ABBBBF;
        border    : 1px solid #2C3E50;
        color     : #FFFFFF;
        text-align: left;
    }
    div.class_titulo_p span {
        padding-left:20px;
        text-align: left;
    }
    fieldset.class_frame {
        background:#ECF0F1;
        border:1px solid #2C3E50;
    }
    div.class_titulo {
        background: #C4C9CD;
        border    : 1px solid #2C3E50;
        color     : #FFFFFF;
        text-align: left;
    }
    div.class_titulo span {
        padding-left:10px;
    }
</style>
<?php
if ($_GET['idCad'] != '') {
    $_GET['entidade_idt'] = $_GET['idCad'];

    if ($_SESSION[CS]['g_abrir_sistema'] == '') {
        $botao_volta = "parent.btFechaCTC('" . $_GET['session_cod'] . "');";
        $botao_acao = '<script type="text/javascript">parent.btFechaCTC("' . $_GET['session_cod'] . '");</script>';
    } else {
        $botao_volta = "parent.parent.btFechaCTC('" . $_GET['session_cod'] . "');";
        $botao_acao = '<script type="text/javascript">parent.parent.btFechaCTC("' . $_GET['session_cod'] . '");</script>';
    }
}

$TabelaPai = "gec_contratar_credenciado_aditivo";
$AliasPai = "gec_ccd";
$EntidadePai = "";
$idPai = "idt";
//
$TabelaPrinc = "gec_contratar_credenciado_aditivo_participante";
$AliasPric = "gec_ccaa";
$Entidade = "Arquivodem Anexo";
$Entidade_p = "Arquivos em Anexo";
$CampoPricPai = "idt_aditivo";

$tabela = $TabelaPrinc;
$tabela_banco = db_pir_gec;

$class_frame_f = "class_frame_f";
$class_titulo_f = "class_titulo_f";

$class_frame_p = "class_frame_p";
$class_titulo_p = "class_titulo_p";

$class_frame = "class_frame";
$class_titulo = "class_titulo";
$titulo_na_linha = false;

$id = 'idt';

$onSubmitDep = 'gec_contratar_credenciado_aditivo_participante_dep()';

$vetFrm = Array();

$sql = '';
$sql .= " select concat_ws('<br />', a.protocolo, o.razao_social, o.cnpj) as empreendimento";
$sql .= ' from ' . db_pir_gec . 'gec_contratar_credenciado_aditivo_participante ap';
$sql .= " inner join " . db_pir_grc . "grc_atendimento a on a.idt = ap.idt_atendimento";
$sql .= " left outer join " . db_pir_grc . "grc_atendimento_organizacao o on o.idt_atendimento = ap.idt_atendimento";
$sql .= ' where ap.idt = ' . null($_GET['id']);
$rs = execsql($sql);

$vetCampo['empreendimento'] = objTextoFixo('empreendimento', 'Cliente', '', false, false, $rs->data[0][0]);
$vetCampo['vl_aditivo'] = objTextoFixo('vl_aditivo', 'Valor do Aditamento (R$)', '', true);

$vetFrm[] = Frame('', Array(
    Array($vetCampo['empreendimento']),
    Array($vetCampo['vl_aditivo']),
        ), $class_frame, $class_titulo, $titulo_na_linha);

//Anexos do Aditamento
$vetParametros = Array(
    'width' => '100%',
);

$vetCampoLC = Array();
$vetCampoLC['np_descricao'] = CriaVetTabela('Forma de Pagamento');
$vetCampoLC['cb_descricao'] = CriaVetTabela('Bandeira');
$vetCampoLC['fp_descricao'] = CriaVetTabela('Parcelas');
$vetCampoLC['codigo_nsu'] = CriaVetTabela('Código NSU');
$vetCampoLC['data_pagamento'] = CriaVetTabela('Data do Pagamento', 'data');
$vetCampoLC['valor_pagamento'] = CriaVetTabela('Valor do Pagamento', 'decimal', '', '', '', '2', '', true);
$vetCampoLC['rm_idmov'] = CriaVetTabela('Cód. RM');

$titulo = 'Regsitro de Pagamento';

$sql = "select pp.*, np.descricao as np_descricao, cb.descricao as cb_descricao, fp.codigo as fp_descricao";
$sql .= " from grc_evento_participante_pagamento pp";
$sql .= ' left outer join grc_evento_natureza_pagamento np on np.idt = pp.idt_evento_natureza_pagamento';
$sql .= ' left outer join grc_evento_cartao_bandeira cb on cb.idt = pp.idt_evento_cartao_bandeira';
$sql .= ' left outer join grc_evento_forma_parcelamento fp on fp.idt = pp.idt_evento_forma_parcelamento';
$sql .= ' where pp.idt_aditivo_participante = $vlID';
$sql .= " and pp.estornado <> 'S'";
$sql .= " and pp.operacao = 'C'";
$sql .= " order by pp.idt";

$vetCampo['gec_contratar_credenciado_aditivo_participante_pagamento'] = objListarConf('gec_contratar_credenciado_aditivo_participante_pagamento', 'idt', $vetCampoLC, $sql, $titulo, false);

$vetFrm[] = Frame('<span>' . $titulo . '</span>', Array(
    Array($vetCampo['gec_contratar_credenciado_aditivo_participante_pagamento']),
        ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);

$vetCad[] = $vetFrm;
?>
<script type="text/javascript">
    function parListarConf_gec_contratar_credenciado_aditivo_participante_pagamento(idCad, id, objCampo, acao) {
        var par = '';

        par += '&valor_inscricao=' + $('#vl_aditivo').val();

        return par;
    }

    function gec_contratar_credenciado_aditivo_participante_dep() {
        var msg = '';

        processando();

        $.ajax({
            dataType: 'json',
            type: 'POST',
            url: ajax_sistema + '?tipo=gec_contratar_credenciado_aditivo_participante_dep',
            data: {
                cas: conteudo_abrir_sistema,
                idt_aditivo: '<?php echo $_GET['idCad']; ?>',
                idt_aditivo_participante: '<?php echo $_GET['id']; ?>'
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
        } else {
            return true;
        }
    }
</script>