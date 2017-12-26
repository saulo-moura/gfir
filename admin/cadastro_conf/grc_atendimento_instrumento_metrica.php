<?php
if ($_GET['idCad'] != '') {
    $_GET['idt0'] = $_GET['idCad'];
    $botao_volta = "parent.btFechaCTC('".$_GET['session_cod']."');";
    $botao_acao = '<script type="text/javascript">parent.btFechaCTC("'.$_GET['session_cod'].'");</script>';
}

$sql = '';
$sql .= ' select codigo';
$sql .= ' from grc_atendimento_instrumento';
$sql .= ' where idt = '.null($_GET['idt0']);
$rs = execsql($sql);
$row = $rs->data[0];

$tabela = 'grc_atendimento_instrumento_metrica';
$id = 'idt';

if ($_GET['idCad'] == '') {
    $vetCampo['idt_atendimento_instrumento'] = objFixoBanco('idt_atendimento_instrumento', 'Instrumento', 'grc_atendimento_instrumento', 'idt', 'descricao', 0);
} else {
    $vetCampo['idt_atendimento_instrumento'] = objHidden('idt_atendimento_instrumento', $_GET['idt0']);
}

$vetCampo['ano'] = objInteiro('ano', 'Ano', true, 4);

if (substr($row['codigo'], 0, 2) == 'MC') {
    unset($vetParticipacaoEvento['PRFE']);
    unset($vetParticipacaoEvento['ACFE']);

    $vetCampo['participacao_sebrae'] = objCmbVetor('participacao_sebrae', 'Modo de Participação do Sebrae', true, $vetParticipacaoEvento);
}

if (substr($row['codigo'], 0, 2) == 'FE') {
    unset($vetParticipacaoEvento['PRMC']);
    unset($vetParticipacaoEvento['ACMC']);

    $vetCampo['participacao_sebrae'] = objCmbVetor('participacao_sebrae', 'Modo de Participação do Sebrae', true, $vetParticipacaoEvento);
}

$sql = '';
$sql .= ' select idt, codigo, descricao';
$sql .= ' from grc_atendimento_metrica';
$sql .= ' order by descricao';
$vetCampo['idt_atendimento_metrica'] = objCmbBanco('idt_atendimento_metrica', 'Métrica', true, $sql);

$vetFrm = Array();
$vetFrm[] = Frame('', Array(
    Array($vetCampo['idt_atendimento_instrumento']),
    Array($vetCampo['ano']),
    Array($vetCampo['participacao_sebrae']),
    Array($vetCampo['idt_atendimento_metrica']),
        ), $class_frame, $class_titulo, $titulo_na_linha);

$vetCad[] = $vetFrm;
