<?php
if ($_GET['idCad'] != '') {
    $_GET['idt0'] = $_GET['idCad'];
    $botao_volta = "parent.btFechaCTC('" . $_GET['session_cod'] . "');";
    $botao_acao = '<script type="text/javascript">parent.btFechaCTC("' . $_GET['session_cod'] . '", parent.funcaoFechaCTC_grc_evento_dimensionamento, null, returnVal);</script>';
}

$id = 'idt';
$vetFrm = Array();

$sql = '';
$sql .= ' select e.vl_determinado';
$sql .= ' from grc_evento e';
$sql .= ' where e.idt = ' . null($_GET['idt_evento']);
$rs = execsql($sql);
$vl_determinado = $rs->data[0]['vl_determinado'];

if ($_GET['id'] == 0) {
    $tabela = '';

    $vetCampo['idt_atendimento'] = objHidden('idt_evento', $_GET['idt0']);
    $vetCampo['idt_evento'] = objHidden('idt_evento', $_GET['idt_evento']);

    $vetRetorno = Array(
        vetRetorno('idt', '', false),
        vetRetorno('codigo', '', false),
        vetRetorno('descricao', '', true),
        vetRetorno('grc_iu_descricao', '', true),
        vetRetorno('detalhe', '', false),
        vetRetorno('idt_insumo_unidade', '', false),
        vetRetorno('vl_unitario', '', false),
    );

    $vetCampo['idt_insumo_dimensionamento'] = objListarCmbMulti('idt_insumo_dimensionamento', 'grc_insumo_dimensionamento', 'Itens', true, '', '', '', $vetRetorno);

    $vetFrm[] = Frame('', Array(
        Array($vetCampo['idt_atendimento']),
        Array($vetCampo['idt_evento']),
        Array($vetCampo['idt_insumo_dimensionamento']),
            ), $class_frame, $class_titulo, $titulo_na_linha);
} else {
    $tabela = 'grc_evento_dimensionamento';

    $vetCampo['idt_atendimento'] = objHidden('idt_atendimento', $_GET['idt0']);
    $vetCampo['idt_evento'] = objHidden('idt_evento', $_GET['idt_evento']);
    $vetCampo['codigo'] = objTextoFixo('codigo', 'Código', '', True);
    $vetCampo['descricao'] = objTextoFixo('descricao', 'Descrição', '', True);
    $vetCampo['vl_unitario'] = objTextoFixo('vl_unitario', 'Custo Unitario (R$)', '', True);
    $vetCampo['qtd'] = objDecimal('qtd', 'QTDE', True, 9);
    $vetCampo['vl_total'] = objTextoFixo('vl_total', 'Preço (R$)', 9, True, True);
    $vetCampo['idt_insumo_unidade'] = objFixoBanco('idt_insumo_unidade', 'Unidade', 'grc_insumo_unidade', 'idt', 'codigo, descricao');
    $vetCampo['detalhe'] = objTextoFixo('detalhe', 'Detalhe', '', true);

    $vetFrm[] = Frame('<span>Identificação</span>', Array(
        Array($vetCampo['idt_atendimento'], '', $vetCampo['idt_evento']),
        Array($vetCampo['codigo'], '', $vetCampo['descricao']),
            ), $class_frame, $class_titulo, $titulo_na_linha);

    if ($vl_determinado == 'S') {
        $vetFrm[] = Frame('<span>Custo</span>', Array(
            Array($vetCampo['idt_insumo_unidade'], '', $vetCampo['vl_unitario'], '', $vetCampo['qtd'], '', $vetCampo['vl_total']),
                ), $class_frame, $class_titulo, $titulo_na_linha);
    } else {
        $vetFrm[] = Frame('<span>Custo</span>', Array(
            Array($vetCampo['idt_insumo_unidade'], '', $vetCampo['qtd']),
                ), $class_frame, $class_titulo, $titulo_na_linha);
    }

    $vetFrm[] = Frame('<span>Resumo</span>', Array(
        Array($vetCampo['detalhe']),
            ), $class_frame, $class_titulo, $titulo_na_linha);
}

$vetCad[] = $vetFrm;
?>
<script type="text/javascript">
    $(document).ready(function () {
        $('#vl_unitario, #qtd').change(function () {
            var vl_unitario = str2float($('#vl_unitario').val());
            var qtd = str2float($('#qtd').val());

            if (isNaN(vl_unitario)) {
                vl_unitario = 0;
            }

            if (isNaN(qtd)) {
                qtd = 0;
            }

            var vl_total = vl_unitario * qtd + 0.00;

            $('#vl_total').val(float2str(vl_total));
            $('#vl_total_fix').html(float2str(vl_total));
        });
    });
</script>