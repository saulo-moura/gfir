<?php
$tabela = 'grc_atendimento_instrumento';
$id = 'idt';

$vetCampo['codigo'] = objTexto('codigo', 'Código', True, 15, 45);
$vetCampo['descricao'] = objTexto('descricao', 'Descrição', True, 60, 120);
$vetCampo['ativo'] = objCmbVetor('ativo', 'Ativo?', True, $vetSimNao);

$maxlength = 700;
$style = "width:700px;";
$js = "";
$vetCampo['detalhe'] = objTextArea('detalhe', 'Detalhe', false, $maxlength, $style, $js);

$sql = "select idt,  descricao from grc_produto_tipo ";
$sql .= " where ativo = ".aspa('S');
$sql .= " order by codigo";
$vetCampo['idt_produto_tipo'] = objCmbBanco('idt_produto_tipo', 'Natureza do Serviço', false, $sql);

MesclarCol($vetCampo['idt_produto_tipo'], 5);

$vetFrm = Array();
$vetFrm[] = Frame('<span></span>', Array(
    Array($vetCampo['codigo'], '', $vetCampo['descricao'], '', $vetCampo['ativo']),
    Array($vetCampo['idt_produto_tipo']),
        ), $class_frame, $class_titulo, $titulo_na_linha);

$vetFrm[] = Frame('<span>Resumo</span>', Array(
    Array($vetCampo['detalhe']),
        ), $class_frame, $class_titulo, $titulo_na_linha);

$sql = '';
$sql .= ' select codigo_sge, codigo';
$sql .= ' from grc_atendimento_instrumento';
$sql .= ' where idt = '.null($_GET['id']);
$rs = execsql($sql);
$row = $rs->data[0];

if ($row['codigo_sge'] != '') {
    $titulo = 'Métrica do Instrumento';

    $vetCampoLC = Array();
    $vetCampoLC['ano'] = CriaVetTabela('Ano');

    if (substr($row['codigo'], 0, 2) == 'MC' || substr($row['codigo'], 0, 2) == 'FE') {
        $vetCampoLC['participacao_sebrae'] = CriaVetTabela('Modo de Participação do Sebrae', 'descDominio', $vetParticipacaoEvento);
    }

    $vetCampoLC['descricao'] = CriaVetTabela('Métrica');

    $sql = "select et.*, am.descricao";
    $sql .= " from grc_atendimento_instrumento_metrica et ";
    $sql .= ' inner join grc_atendimento_metrica am on am.idt = et.idt_atendimento_metrica';
    $sql .= ' where et.idt_atendimento_instrumento = $vlID';
    $sql .= " order by et.ano desc";

    $vetCampo['grc_atendimento_instrumento_metrica'] = objListarConf('grc_atendimento_instrumento_metrica', 'idt', $vetCampoLC, $sql, $titulo, true);

    $vetParametros = Array(
        'width' => '100%',
    );

    $vetFrm[] = Frame('', Array(
        Array($vetCampo['grc_atendimento_instrumento_metrica']),
            ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);
}

$vetCad[] = $vetFrm;
