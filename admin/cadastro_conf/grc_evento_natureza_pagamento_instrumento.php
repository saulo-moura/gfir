<style>
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
    $botao_acao = '<script type="text/javascript">parent.btFechaCTC("'.$_GET['session_cod'].'");</script>';
}

$id = 'idt';
$tabela = 'grc_evento_natureza_pagamento_instrumento';

$vetCampo['idt_evento_natureza_pagamento'] = objHidden('idt_evento_natureza_pagamento', $_GET['idt0']);

$sql = '';
$sql .= ' select idt, descricao';
$sql .= ' from grc_atendimento_instrumento';
$sql .= " where idt in (2, 40, 41, 45, 46, 47, 48, 49, 50, 52, 54)";
$sql .= ' order by descricao';
$vetCampo['idt_atendimento_instrumento'] = objCmbBanco('idt_atendimento_instrumento', 'Instrumento', true, $sql);

$vetCampo['qtd_limite'] = objInteiro('qtd_limite', 'Qtd. Limite', false, 10);

$vetFrm[] = Frame('', Array(
    Array($vetCampo['idt_evento_natureza_pagamento']),
    Array($vetCampo['idt_atendimento_instrumento']),
    Array($vetCampo['qtd_limite']),
        ), $class_frame, $class_titulo, $titulo_na_linha);

$vetCad[] = $vetFrm;
