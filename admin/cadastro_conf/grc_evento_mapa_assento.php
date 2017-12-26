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
        background: #c4c9cd;
        border    : none;
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
        background: #FFFFFF;
        color     : #FFFFFF;
        border    : 0px solid #2C3E50;
    }

    div.class_titulo span {
        padding-left:10px;
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
        height:28px;
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

    Td.Titulo_radio {
        width: 64px;
    }
</style>
<?php
if ($_GET['idCad'] != '') {
    $_GET['idt0'] = $_GET['idCad'];
    $botao_volta = "parent.btFechaCTC('" . $_GET['session_cod'] . "', parent.funcaoFechaCTC_grc_evento_mapa_assento);";
    $botao_acao = '<script type="text/javascript">parent.btFechaCTC("' . $_GET['session_cod'] . '", parent.funcaoFechaCTC_grc_evento_mapa_assento);</script>';
}

$id = 'idt';

if ($_GET['id'] == 0) {
    $vetCampo['idt_evento_mapa'] = objHidden('idt_evento_mapa', $_GET['idt0']);
    $vetCampo['linha'] = objInteiro('linha', 'Total de Linha', true, 10);
    $vetCampo['coluna'] = objInteiro('coluna', 'Total de Coluna', true, 10);

    $sql = "select idt, descricao from grc_evento_local_pa_tipo_assento order by descricao";
    $vetCampo['idt_tipo_assento'] = objCmbBanco('idt_tipo_assento', 'Tipo de Assento (Padrão)', true, $sql, ' ', 'width:180px;');

    MesclarCol($vetCampo['idt_evento_mapa'], 5);

    $vetFrm[] = Frame('', Array(
        Array($vetCampo['idt_evento_mapa']),
        Array($vetCampo['linha'], '', $vetCampo['coluna'], '', $vetCampo['idt_tipo_assento']),
            ), $class_frame, $class_titulo, $titulo_na_linha);
} else {
    $tabela = 'grc_evento_mapa_assento';

    $vetCampo['idt_evento_mapa'] = objHidden('idt_evento_mapa', $_GET['idt0']);
    $vetCampo['codigo'] = objTextoFixo('codigo', 'Código Assento', '', true);
    $vetCampo['descricao'] = objTexto('descricao', 'Referência', true, 30, 120);
    $vetCampo['ativo'] = objCmbVetor('ativo', 'Ativo?', True, $vetSimNao, '');

    $maxlength = 2000;
    $style = "width:800px;";
    $js = "";
    $vetCampo['detalhe'] = objTextArea('detalhe', 'Observação', false, $maxlength, $style);

    $vetCampo['linha'] = objTextoFixo('linha', 'Linha', '', true);
    $vetCampo['coluna'] = objTextoFixo('coluna', 'Coluna', '', true);

    $vetCampo['mapa_assento'] = objFile('mapa_assento', 'Mapa do assento', false, 120, 'todos');

    $sql = "select idt, descricao from grc_evento_local_pa_tipo_assento order by descricao";
    $vetCampo['idt_tipo_assento'] = objCmbBanco('idt_tipo_assento', 'Tipo de Assento', true, $sql, '', 'width:180px;');

    MesclarCol($vetCampo['idt_evento_mapa'], 5);
    MesclarCol($vetCampo['detalhe'], 5);
    MesclarCol($vetCampo['mapa_assento'], 5);

    $vetFrm[] = Frame('', Array(
        Array($vetCampo['idt_evento_mapa']),
        Array($vetCampo['codigo'], '', $vetCampo['linha'], '', $vetCampo['coluna']),
        Array($vetCampo['descricao'], '', $vetCampo['idt_tipo_assento'], '', $vetCampo['ativo']),
        Array($vetCampo['detalhe']),
        Array($vetCampo['mapa_assento']),
            ), $class_frame, $class_titulo, $titulo_na_linha);
}

$vetCad[] = $vetFrm;
