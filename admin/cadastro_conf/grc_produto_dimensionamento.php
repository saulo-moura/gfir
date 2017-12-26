<?php
if ($_GET['idCad'] != '') {
    $_GET['idt0'] = $_GET['idCad'];
    $botao_volta = "parent.btFechaCTC('".$_GET['session_cod']."');";
    $botao_acao = '<script type="text/javascript">parent.btFechaCTC("'.$_GET['session_cod'].'");</script>';
}

$id = 'idt';
$vetFrm = Array();

if ($_GET['id'] == 0) {
    $tabela = '';

    $vetCampo['idt_produto'] = objFixoBanco('idt_produto', 'Produto', 'grc_produto', 'idt', 'descricao', 0);
    
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
        Array($vetCampo['idt_produto']),
        Array($vetCampo['idt_insumo_dimensionamento']),
            ), $class_frame, $class_titulo, $titulo_na_linha);
} else {
    $tabela = 'grc_produto_dimensionamento';

    $vetCampo['idt_produto'] = objFixoBanco('idt_produto', 'Produto', 'grc_produto', 'idt', 'descricao', 0);
    $vetCampo['codigo'] = objTexto('codigo', 'Código', True, 25, 45);
    $vetCampo['descricao'] = objTexto('descricao', 'Descrição', True, 100, 255);
    $vetCampo['vl_unitario'] = objDecimal('vl_unitario', 'Custo Unitario (R$)', True, 9);

    $sql = "select idt, codigo, descricao from grc_insumo_unidade ";
    $sql .= " order by codigo";
    $vetCampo['idt_insumo_unidade'] = objCmbBanco('idt_insumo_unidade', 'Unidade', True, $sql, ' ', 'width:180px;');

    $maxlength = 700;
    $style = "width:700px;";
    $js = "";
    $vetCampo['detalhe'] = objTextArea('detalhe', 'Detalhe', false, $maxlength, $style, $js);

    MesclarCol($vetCampo['idt_produto'], 3);
    
    $vetFrm[] = Frame('<span>Identificação</span>', Array(
        Array($vetCampo['idt_produto']),
        Array($vetCampo['codigo'], '', $vetCampo['descricao']),
            ), $class_frame, $class_titulo, $titulo_na_linha);

    $vetFrm[] = Frame('<span>Custo</span>', Array(
        Array($vetCampo['idt_insumo_unidade'], '', $vetCampo['vl_unitario']),
            ), $class_frame, $class_titulo, $titulo_na_linha);

    $vetFrm[] = Frame('<span>Resumo</span>', Array(
        Array($vetCampo['detalhe']),
            ), $class_frame, $class_titulo, $titulo_na_linha);
}

$vetCad[] = $vetFrm;
